<?php
session_start();
session_destroy();
setcookie("user", "", time() - 3600, "/"); // Clear the cookie
header("Location: ../views/login.php"); // Redirect to login page
exit();
?>
