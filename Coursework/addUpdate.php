<?php
// these are the details to log in to the database, they have been assigned to variables to make the code more dynamic
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "enterpriseCW";

// Creates a  connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Checking the connection has been established successfully
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Preparing data to be added into the database
$taskName = $_POST["taskName"];
$update = $_POST["update"];

// adding the data into the respective table
$sql = "INSERT INTO taskupdates (taskName, `update`) VALUES ('$taskName', '$update')";

if ($conn->query($sql) === TRUE) {
    header("Location:tasks.php");
			exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error; //error handling
}

$conn->close();
?>