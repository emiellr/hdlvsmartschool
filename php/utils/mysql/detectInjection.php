<?php
function detectInjection($str, $charSet=";") {
  // Prevent SQL injection
  return strpos($str, $charSet);
}
?>
