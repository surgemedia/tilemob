<?php
session_start();
//Clear user sessions
session_destroy();
//proceed to admin login screen
header('location:index.php?s2=You have logged out.');
?>
