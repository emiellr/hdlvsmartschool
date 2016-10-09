<?php
// Create connection
require("utils/mysql/connect.php");

$conn = connect();

// Prevent SQL injection
require("utils/mysql/detectInjection.php");

if(detectInjection()) {
  die "false";
}

// Store data
$sql = "INSERT INTO datalog (dataType, data, deviceId) VALUES ('" . $_GET["dataType"] . "', '" . $_GET["data"] . "', " . $_GET["deviceId"] . ")";

$conn->query($sql);

// Close connection
$conn->close();

// Return success
echo("true");
?>
