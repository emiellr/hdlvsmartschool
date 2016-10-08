<?php
$servername = "localhost";
$username = "webapp";
$password = "W9?0uqy2";
$database = "duursmait";
// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  // Return failure
  die("ERROR MYSQL connection error, details:" . $conn->connect_error . "(report to @thomasduursma on Slack)");
}

// Prevent SQL injection
if (strpos($_GET["criteria"] . $_GET["rows"], ";")) {
  die("false");
}

// Construct sql
$rows = "*";
if($_GET["rows"]) {
  $rows = join(", ", json_decode($_GET["rows"]));
}

$criteria = null;
if($_GET["criteria"]) {
  $criteria = " WHERE " . $_GET["criteria"];
}

$sql = "SELECT" . $rows . "FROM datalog" . $criteria;



// Get data
$query = $conn->query($sql);
$result = array();

while($row = $query->fetch_assoc()) {
  array_push($result, $row);
}

// Close connection
$conn->close();

// Return data
echo json_encode($result);
?>
