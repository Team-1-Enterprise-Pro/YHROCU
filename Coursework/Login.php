<?php
session_start();
// Establish a database connection
// these are the details to log in to the database, they have been assigned to variables to make the code more dynamic
$servername = "localhost";
$username = "root";
$password = "";
$db_name = "enterpriseCW";

// Create connection to the database
$conn = new mysqli($servername, $username, $password, $db_name);

// Check if connection successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function checkLoggedIn() {
    // Check if user is already logged in important as some content only visible to logged in users
    if(isset($_SESSION["staffNumber"])) {
        // User is already logged in, redirect to tasks.php or any other page
        header("Location: tasks.php");
        exit();
    }
}

checkLoggedIn();

function handleLoginFormSubmission($conn) {
    // Check if the login form is submitted
    if(isset($_POST["submit"])) {
        $staffNumber = $_POST["staffNumber"]; //these are taken from the login.html page when the user fills out the login page
        $password = $_POST["password"];

        // Query database to check user credentials
        $sql = "SELECT * FROM staff WHERE staffNumber = '$staffNumber' AND password = '$password'";
        $result = $conn->query($sql);

        if($result && $result->num_rows == 1) {
            // Login successful, set user session
            $row = $result->fetch_assoc();
            $_SESSION["staffNumber"] = $row["staffNumber"];
            
            // Redirect to tasks.php or any other page
            header("Location: tasks.php");
            exit();
        } else {
            // Invalid username or password, redirect to login page with error message
            header("Location: Login.html?error=invalid_credentials"); //error handling
            exit();
        }
    }
}

// Call the function to handle login form submission
handleLoginFormSubmission($conn);
?>
