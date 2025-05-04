<?php
session_start(); // Ensure session is started here to destroy it
session_unset(); // Unset session variables
session_destroy(); // Destroy session

// Redirect to login page after logout
header("Location: login.php");
exit();
?>
