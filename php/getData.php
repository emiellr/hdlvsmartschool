<?php
// Create connection
require("utils/mysql/connect.php");
$conn = connect();

// Prevent SQL injection
require("utils/mysql/detectInjection.php");
if(detectInjection($_GET["criteria"])) {
  die("false");
}

// Construct sql
$rows = "*";
if($_GET["rows"]) {
  $rows = join(", ", json_decode($_GET["rows"]));
}

// Get data
require("utils/mysql/getArray.php");
echo json_encode(getArray($_GET["criteria"]));

// Close connection
$conn->close();
?>
