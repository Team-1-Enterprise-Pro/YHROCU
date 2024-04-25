<?php
function logout() {
    // Start session
    session_start();

    // Check if session is active
    if (session_status() === PHP_SESSION_ACTIVE) {
        // Clear session variables
        unset($_SESSION["staffNumber"]);

        // Destroy the session
        if (session_destroy()) {
            return true; // Logout successful
        } else {
            return false; // Logout unsuccessful
        }
    }

    return false; // Session not active
}
?>
