<?php
function connectToDatabase() {
    // Start session
    session_start();

    // these are the details to log in to the database, they have been assigned to variables to make the code more dynamic
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db_name = "enterpriseCW";

    // Creates a  connection to the database
    $conn = new mysqli($servername, $username, $password, $db_name, 3306);

   // Checking the connection has been established successfully
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Returns the connection object so it can be used
    return $conn;
}
?>
