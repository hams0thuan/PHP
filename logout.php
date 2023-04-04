<?php 

if (isset($_COOKIE['Cookie'])) {
   setcookie("Cookie", "", time() - 3600, '', '', 1, 1); 
}
header("location: ./login.php");
?>


