<?php
function auth($otp, $id, $conn) {
  // Get default values
  $otp = $otp ? $otp:$GLOBALS["otp"];
  $id = $id ? $id:$GLOBALS["id"];
  $conn = $conn ? $conn:$GLOBALS["conn"];
  
  // Construct SQL
  $sql = "SELECT hash FROM otp WHERE id=$id and date > DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
  
  // Execute SQL
  $query = $conn->query($sql);
  
  // Check one-time-pass
  $auth = false;
  if($query->num_rows > 0) {
    while($row = $query->fetch_assoc() and !$auth) {
      $auth = password_verify($lOtp, $row["hash"]);
    }
  }
  
  return $auth;
}
?>
