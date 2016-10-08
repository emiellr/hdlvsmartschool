<?php
$servername = "localhost";
$username = "webapp";
$password = "***";
$database = "duursmait";
// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  // Return failure
  die("false");
}

// Prevent SQL injection
if (strpos($_GET["dataType"] . $_GET["data"] . $_GET["deviceId"], ";")) {
  die("false");
}

// Store data
$sql = "INSERT INTO datalog (dataType, data, deviceId) VALUES ('" . $_GET["dataType"] . "', '" . $_GET["data"] . "', " . $_GET["deviceId"] . ")";

$conn->query($sql);

// Close connection
$conn->close();

// Return success
echo("true");
?>
