<?php
// Define login info
$servername = "localhost";
$username = "webapp";
$password = "***";
$database = "duursmait";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  // Return failure
  die("ERROR MYSQL connection error, details:" . $conn->connect_error . "(report to @thomasduursma on Slack)");
}

// Hash password
$hash = password_hash($_GET["password"], PASSWORD_BCRYPT);

// Prevent SQL injection
if (strpos($_GET["username"], ";")) {
  die("false");
}

/* Get default role setting
   Construct SQL*/
$sql = "SELECT value FROM settings WHERE name=defaultRole";

// Execute SQL
$query = $conn->query($sql);

// Get result
$defaultRole = $query->fetch_assoc()['value'];

// Construct SQL
$username = $_GET["username"];
$sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$hash', '$defaultRole')";
$id = $conn->insert_id;

// Execute SQL
$conn->query($sql);

// Get one-time-pass
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$otp = '';
for ($i = 0; $i < 16; $i++) {
  $otp .= $characters[rand(0, strlen($characters) - 1)];
}

// Generate a hash for the one-time-pass
$hash = password_hash($otp, PASSWORD_BCRYPT);

/* Register one-time-pass
   Construct SQL*/
$sql = "INSERT INTO otp (username, hash) VALUES ('$id', '$hash')";

// Execute SQL
$conn->query($sql);

// Close connection
$conn->close();

// Create object for return values
$returnData = new stdClass();
$returnData["id"] = $id;
$returnData["otp"] = $otp;

// Return data
echo json_encode($returnData);
?>
