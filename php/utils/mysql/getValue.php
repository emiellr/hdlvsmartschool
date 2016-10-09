<?php
function getValue($table, $column) {
  // Get connection
  global $conn;
  // Get setting
  $conn->query("SELECT value FROM $table WHERE name='$str'");
  if($row = $conn->fetch_assoc()) {
    $value = $row["value"];
  }
  return $value;
}
?>
