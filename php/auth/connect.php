<?php
function connect($servername = "***", $username = "***", $password = "***", $database = "***") {
  // Create connection
  $conn = new mysqli($servername, $username, $password, $database);
  
  // Check connection
  if ($conn->connect_error) {
    // Return failure
    die("ERROR MYSQL connection error, details:" . $lConn->connect_error . "(report to @thomasduursma on Slack)");
  }
  
  // Return connection
  return $conn;
}
?>