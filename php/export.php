<?php
$servername = "localhost";
$username = "webapp";
$password = "***";
$database = "duursmait";
// Create connection
global $conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  // Return failure
  die("ERROR MYSQL connection error, details:" . $conn->connect_error . "(report to @thomasduursma on Slack)");
}

// Prevent SQL injection
if (strpos($_GET["date"] . $_GET["startDate"] . $_GET["endDate"], ";")) {
  die("false");
}

// Construct SQL
if ($_GET["date"]) {
  $criteria = " WHERE date LIKE '$date%'";
} elseif ($_GET["startDate"] and $_GET["endDate"]) {
  $criteria = " WHERE date BETWEEN '" . $_GET["startDate"] . "' AND '" . $_GET["endDate"] . "'";
} elseif ($_GET["startDate"]) {
  $criteria = " WHERE date >= '" . $_GET["startDate"] . "'";
} elseif ($_GET["endDate"]) {
  $criteria = " WHERE date <= '" . $_GET["endDate"] . "'";
}
$sql = "SELECT * FROM datalog" . $criteria;

// Get data
$query = $conn->query($sql);
$result = array();
while($row = $query->fetch_assoc()) {
  array_push($result, $row);
}

// Get the file name
$fname = $_GET['fname'];
if (!$fname) {
  $fname = date("Y-m-d");
}

// Create file
$f = fopen($fname . '.txt', "w");
fwrite($f, json_encode($result));
fclose($f);

// Delete data from database
if($_GET["archive"] == 'true') {
  $sql = "DELETE FROM datalog" . $criteria;
  $conn->query($sql);
}

echo true;

// Close connection
$conn->close();
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
