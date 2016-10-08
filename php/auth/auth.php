<?php
function auth($lOtp=$otp, $lId=$id) {
  // Construct SQL
  $sql = "SELECT hash FROM otp WHERE id=$lId";
  
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
