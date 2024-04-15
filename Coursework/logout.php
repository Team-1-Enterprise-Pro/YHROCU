<?php
// Start session
session_start();

// Clear session variables
unset($_SESSION["staffNumber"]);

// Destroy the session
session_destroy();


// Redirect to login page after logout
header("Location: login.html");
exit();
?>
