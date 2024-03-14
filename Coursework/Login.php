<?php
// Start session
session_start();

// Check if user is logged in
if(isset($_SESSION["user_id"])) {
    // User is already logged in, redirect to tasks.php or any other page
    header("Location: tasks.php");
    exit();
}

// Include database connection
include("connect.php");

// Handle login form submission
if(isset($_POST["submit"])) {
    $staffNumber = $_POST["staffNumber"];
    $password = $_POST["password"];

    // Query database to check user credentials
    $sql = "SELECT * FROM staff WHERE staffNumber = '$staffNumber' AND password = '$password'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    if($count == 1) {
        // Login successful, set user session
        $_SESSION["user_id"] = $row["staffNumber"];
        
        // Redirect to tasks.php or any other page
        header("Location: tasks.php");
        exit();
    } else {
        // Invalid username or password, redirect to login page with error message
        header("Location: Login.html?error=invalid_credentials");
        exit();
    }
}
?>
