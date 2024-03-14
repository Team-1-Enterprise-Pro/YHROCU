<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.
session_start();

// Check if user is not logged in
if(!isset($_SESSION["user_id"])) {
    // User is not logged in, redirect to login page
    header("Location: login.html");
    exit();}
    
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "enterpriseCW";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteTask"])) {
    $taskName = $_POST["taskName"];
    $deleteFromTable = "DELETE FROM tasklist WHERE taskName = '$taskName'";
    if ($conn->query($deleteFromTable) === TRUE) {
        echo "";
    } else {
        echo "Error deleting task: " . $conn->error;
    }
}
?>

<html>

<head>
    <title>YHROCU</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="navbar">
        <div class="menuitems"><a href="createTask.php">Create Task</a></div>
        <div class="menuitems"><a href="tasks.php">All Tasks</a></div>
        <div class="menuitems"><a href="SearchTask.php">Search Task</a></div>
        <div class="menuitems"><a href="logout.php">Logout</a></div>
    </div>

    <div id="updatePopup" class="popup">
        <div class="popup-content">
            <span class="close" onclick="closeUpdatePopup()">&times;</span>
            <div id="updatesList">
                <table>
                    <thead>
                        <tr>
                            <th>Task Name</th>
                            <th>Update</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $updateSql = "SELECT taskName, `update` FROM taskupdates";
                        $updateResult = $conn->query($updateSql);
                        if ($updateResult->num_rows > 0) {
                            while ($row = $updateResult->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["taskName"] . "</td>";
                                echo "<td>" . $row["update"] . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='2'>No updates found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <form id="addUpdateForm" method="POST" action="addUpdate.php">
                <input type="hidden" id="updateTaskName" name="taskName">
                <input type="text" id="updateInput" name="update" placeholder="Add new update">
                <button type="submit">Add Update</button>
            </form>
        </div>
    </div>

    <?php
    $sql = "SELECT * FROM tasklist";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<div class='box'>";
        echo "<br><br><br>";
        echo "<table class='createTaskForm'>";
        echo "<th class='headingAllTasks' colspan='4'><br>All Tasks<th>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>Task Name: " . $row["taskName"] . "</td>";
            echo "<td>Task Description: " . $row["taskDescription"] . "</td>";
            echo "<td>Task Date: " . $row["taskDate"] . "</td>";
            echo "<td>Task View: " . $row["whoCanView"] . "</td>";
            echo "<td>";
            echo "<form method='POST' action='' class='userform' onsubmit='return confirmDelete()'>";
            echo "<input type='hidden' name='taskName' value='" . $row["taskName"] . "'>";
            echo "<input type='submit' name='deleteTask' value='Delete'>";
            echo "</form>";
            echo "</td>";
            echo "<td>";
            echo "<button onclick='openUpdatesList(\"" . $row["taskName"] . "\")'>View Updates</button>";
            echo "<button onclick='taskCompleted(this)' name='completeTask'>Complete</button>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "</div>";
    } else {
        echo "No tasks found.";
    }
    ?>

    <script>
        function confirmDelete() {
            var adminPIN = prompt("Enter admin PIN:");
            if (adminPIN === '1234') {
                return true;
            } else {
                alert("Incorrect admin PIN. Task not deleted.");
                return false;
            }
        }

        function openUpdatesList(taskName) {
            document.getElementById("updateTaskName").value = taskName;
            document.getElementById("updatePopup").style.display = "block";
        }

        function closeUpdatePopup() {
            document.getElementById("updatePopup").style.display = "none";
        }

    
        function taskCompleted(button) {
            var row = button.closest('tr');
        row.style.backgroundColor = "green";}

    </script>
</body>

</html>