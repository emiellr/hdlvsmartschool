<?php
function getValue($table, $column, $conn) {
  // Get connection
  $conn = $conn ? $conn:$GLOBALS["conn"];
  
  // Get setting
  $conn->query("SELECT value FROM $table WHERE name='$str'");
  if($row = $conn->fetch_assoc()) {
    $value = $row["value"];
  }
  return $value;
}
?>
