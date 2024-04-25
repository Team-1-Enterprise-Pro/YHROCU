<?php
function connectToDatabase() {

    // Database credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db_name = "enterpriseCW";

    try {
        // Create connection
        $conn = new mysqli($servername, $username, $password, $db_name);

        // Check connection
        if ($conn->connect_error) {
            return false; // Return false if connection failed
        } else {
            return true; // Return true if connection successful
        }
    } catch (Exception $e) {
        return false; // Return false if connection fails due to an exception
    }
}
