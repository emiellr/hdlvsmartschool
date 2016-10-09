<?php
function getArray($criteria=null, $table="datalog", $rows="*", $conn=null) {
  // Get connection
  $conn = $conn ? $conn:$GLOBALS["conn"];
  
  // Construct SQL
  $sql = "SELECT $rows FROM $table";
  $sql .= $criteria ? " WHERE $criteria":null;
  
  // Get data
  $data = array();
  $query = $conn->query($sql);
  while($row = $query->fetch_assoc()) {
    array_push($data, $row);
  };
  return $data;
}
?>
