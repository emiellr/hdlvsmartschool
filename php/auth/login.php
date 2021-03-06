<?php
// Create connection
require("../utils/mysql/connect.php");
$conn = connect();

// Prevent SQL injection
require("../utils/mysql/detectInjection.php")
if(detectInjection($_GET["username"] . $_GET["password"])) {
  die("false");
}

// Create object for return values
$returnData = new stdClass();

/* Get stored hash and user id
   Generate SQL */
$username = $_GET["username"];
$sql = "SELECT id, hash FROM users WHERE username='$username'";

// Execute SQL
$query = $conn->query($sql);

// Process query
if($row = $query->fetch_assoc();) {
  $hash = $row["hash"];
  $id = $row["id"];
} else {
  die("authError");
}

// Add id to return values
$returnData["id"] = $id;

// Verify password
if(!password_verify($_GET["password"], $hash)) {
  die("authError");
}

// Generate one-time-pass
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$otp = '';
for ($i = 0; $i < 16; $i++) {
  $otp .= $characters[rand(0, strlen($characters) - 1)];
}

// Add one-time-pass to return values
$returnData["otp"] = $otp;

// Generate a hash for the one-time-pass
$hash = password_hash($otp, PASSWORD_BCRYPT);

/* Register one-time-pass
   Construct SQL*/
$sql = "INSERT INTO otp (username, hash) VALUES ('$id', '$hash')";

// Execute SQL
$conn->query($sql);

// Close connection
$conn->close();

// Return data
echo json_encode($returnData);
