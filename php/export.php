<?php
require("utils/mysql/connect.php");
$conn = connect();

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
if (!$fname = $_GET["fname"]) {
  $fname = date("Y-m-d");
}

// Create file
fwrite($f = fopen($fname . '.txt', "w"), json_encode($result));
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
