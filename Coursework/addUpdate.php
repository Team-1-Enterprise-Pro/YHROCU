<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "enterpriseCW";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare data for insertion
$taskName = $_POST["taskName"];
$update = $_POST["update"];

// Perform insertion
$sql = "INSERT INTO taskupdates (taskName, `update`) VALUES ('$taskName', '$update')";

if ($conn->query($sql) === TRUE) {
    header("Location:tasks.php");
			exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>