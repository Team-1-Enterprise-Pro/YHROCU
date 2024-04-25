<?php
// Start session
session_start();

// Clear session variables
unset($_SESSION["staffNumber"]);

// Destroy the session to ensure logout is done completely as content is tailored to each staff member and may be confidential
session_destroy();


// Redirect to login page after logout
header("Location: login.html");
exit();
?>
