<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "enterpriseCW";

// Establish connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get task name from the GET request
$taskName = $_GET["taskName"];

// Query to fetch updates for the task
$sql = "SELECT `update` FROM taskupdates WHERE taskName = '$taskName'";
$result = $conn->query($sql);

// Output updates as an unordered list
if ($result->num_rows > 0) {
    echo "<h3>Updates for Task: $taskName</h3><ul>";
    while ($row = $result->fetch_assoc()) {
        echo "<li>" . $row["update"] . "</li>";
    }
    echo "</ul>";
} else {
    echo "No updates found for Task: $taskName";
}

$conn->close();
?>