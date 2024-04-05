<?php
// Start session
session_start();

// Check if user is not logged in
if(!isset($_SESSION["staffNumber"])) {
    // User is not logged in, redirect to login page
    header("Location: login.html");
    exit();
}

// Include database connection
include("connect.php");

//this block of code allows the admin user to delete a task, when the task is deleted it is no longer displayed on the screen or in the database
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteTask"])) {
    $taskName = $_POST["taskName"];
    $deleteFromTable = "DELETE FROM tasklist WHERE taskName = '$taskName'";
    if ($conn->query($deleteFromTable) === TRUE) {
        echo "";
    } else {
        echo "Error deleting task: " . $conn->error; //error handling
    }

   
    //this block of code allows the admin user to update the due date for the task, it gets updated on the screen and also in the database
} if (isset($_POST['updateTaskDate'])) {
        $taskName = $_POST['taskName'];
        $newTaskDate = $_POST['newTaskDate'];
    
        // updating in the database
        $sql = "UPDATE tasklist SET taskDate='$newTaskDate' WHERE taskName='$taskName'";
        if ($conn->query($sql) === TRUE) {
            echo "";
        } else {
            echo "Error updating task date: " . $conn->error; //error handling
        }
    }
    
if(isset($_POST["toggleTaskComplete"])) {
    $taskName = $_POST["taskName"];
    $taskCompleted = $_POST["taskCompleted"];
    
    // Toggle the task completion status
    $newTaskCompleted = $taskCompleted == 'Y' ? 'N' : 'Y';
    
    // Update the task completion status in the database
    $updateSql = "UPDATE tasklist SET taskComplete = '$newTaskCompleted' WHERE taskName = '$taskName'";
    if ($conn->query($updateSql) === TRUE) {
        // Task completion status updated successfully
    } else {
        // Error updating task completion status
    }
}


// Retrieve logged-in user's staff number
$staffNumber = $_SESSION["staffNumber"];
?>
<html>

<head>
      <!--Title of the webpage-->
    <title>YHROCU</title>
    <!--Linking the style sheet-->
    <link rel="stylesheet" href="style.css">
</head>

<body>
     <!--code for the navbar-->
    <div class="navbar">
    <div class="menuitems"><a href="createTask.php">Create Task</a></div>
        <div class="menuitems"><a href="tasks.php">All Tasks</a></div>
        <div class="menuitems"><a href="normalUser.php">My Tasks</a></div>
        <div class="menuitems"><a href="SearchTask.php">Search Task</a></div>
        <div class="menuitems"><a href="Signup.html">Signup User</a></div>
        <div class="menuitems"><a href="login.html">Logout</a></div>
    </div>

     <!--this block of code allows the user to add updates about the task, these updates get saved to the database-->
    <div id="updatePopup" class="popup">
        <div class="popup-content">
             <!--the textfield to add the update is displayed in a pop up window-->
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
                         <!--this checks that the update is added for the correct task for example if the user clicks on the update button next to 
                        task 2 then the update will be added for task 2-->
                        <?php
                        $updateSql = "SELECT taskName, `update` FROM taskupdates";
                        $updateResult = $conn->query($updateSql);
                        if ($updateResult->num_rows > 0) {
                            //html code is printed out onto the screen
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
             <!--the form used to add task updates-->
            <form id="addUpdateForm" method="POST" action="addUpdate.php">
                <input type="hidden" id="updateTaskName" name="taskName">
                <input type="text" id="updateInput" name="update" placeholder="Add new update">
                <button type="submit">Add Update</button>
            </form>
        </div>
    </div>

    <?php




// SQL query to fetch tasks for the logged-in user's staff number
$sql = "SELECT * FROM tasklist WHERE whoCanView = '$staffNumber' OR whoCanView = 'everyone'";
$result = $conn->query($sql);

// Display tasks
if ($result->num_rows > 0) {
    echo "<div class='box'>";
    echo "<br><br><br>";
    echo "<table class='createTaskForm'>";
    echo "<th class='headingAllTasks' colspan='4'><br>My Tasks<th>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>Task Name: " . $row["taskName"] . "</td>";
        echo "<td>Task Description: " . $row["taskDescription"] . "</td>";
        echo "<td>Task Date: " . $row["taskDate"] . "</td>";
        echo "<td>Task View: " . $row["whoCanView"] . "</td>";
        echo "<td>Task Completed: " . $row["taskComplete"] . "</td>";
        echo "<td>";
        echo "<form method='POST' action='' class='userform' onsubmit='return confirmDelete()'>";
        echo "<input type='hidden' name='taskName' value='" . $row["taskName"] . "'>";
        echo "<input type='submit' name='deleteTask' value='Delete'>";
        echo "</form>";
        echo "</td>";
        echo "<td>";
        echo "<button onclick='openUpdatesList(\"" . $row["taskName"] . "\")'>View Updates</button>";
        echo "</td>";
        echo "<td>";
        echo "<form method='POST' action='' class='userform' onsubmit='return confirmUpdate()'>";
        echo "<input type='hidden' name='taskName' value='" . $row["taskName"] . "'>";
        echo "<input type='date' name='newTaskDate' placeholder='New Task Date'>";
        echo "<input type='submit' name='updateTaskDate' value='change due date'>";
        echo "<input type='hidden' name='taskCompleted' value='" . $row["taskComplete"] . "'>";
        echo "<button type='submit' name='toggleTaskComplete'>Complete Task</button>";
        echo "</form>";
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
        //this function confirms deletion of a task, 1234 is the confirmation which must be entered by the user in the alert that pops up
        function confirmDelete() { 
            var adminPIN = prompt("Enter admin PIN:");
            if (adminPIN === '1234') {
                return true;
            } else {
                alert("Incorrect admin PIN. Task not deleted.");
                return false;
            }
        }

        //function to open the pop up that allows the user to add task updates
        function openUpdatesList(taskName) {
            document.getElementById("updateTaskName").value = taskName;
            document.getElementById("updatePopup").style.display = "block";
        }

        //closing the popup
        function closeUpdatePopup() {
            document.getElementById("updatePopup").style.display = "none";
        }

  

    </script>
</body>

</html>