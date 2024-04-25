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
$conn = connectToDatabase();


//this block of code allows the admin user to delete a task, when the task is deleted it is no longer displayed on the screen or in the database
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteTask"])) {
    $taskName = $_POST["taskName"];
    $deleteFromTable = "DELETE FROM tasklist WHERE taskName = '$taskName'"; //only deletes task from database if it matches
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
        $sql = "UPDATE tasklist SET taskDate='$newTaskDate' WHERE taskName='$taskName'"; //ensuring the right taskdate is updated by checking it with the task name
        if ($conn->query($sql) === TRUE) {
            echo "";
        } else {
            //
        }
    }
    //toggle button to toggle between Y and N for task completion
    if(isset($_POST["toggleTaskComplete"])) {
        // Prompt for PIN
        $supervisorPIN = $_POST["supervisorPIN"];
        if($supervisorPIN !== '1111') {
            // Incorrect PIN
            echo "<script>alert('Error updating task completion status');</script>";
        } else {
            // PIN is correct, proceed with toggling task completion status
            $taskName = $_POST["taskName"];
            $taskCompleted = $_POST["taskCompleted"];
            
            // Toggle the task completion status
            $newTaskCompleted = $taskCompleted == 'Y' ? 'N' : 'Y';
            
            // Update the task completion status in the database
            $updateSql = "UPDATE tasklist SET taskComplete = '$newTaskCompleted' WHERE taskName = '$taskName'";
            if ($conn->query($updateSql) === TRUE) {
                echo "<script>alert('Task completion status updated sucessfully');</script>";
            } else {
                //
            }
        }
    }


?>
<html>

<head>
      <!--Title of the webpage-->
    <title>YHROCU</title>
    <!--Linking the style sheet-->
    <link rel="stylesheet" href="CSS_tasks.css">
    
</head>

<body>
     <!--code for the navbar-->
    <div class="navbar">
        <!--menu items with appropriate links-->
    <div class="menuitems"><a href="createTask.php">Create Task</a></div>
        <div class="menuitems"><a href="tasks.php">All Tasks</a></div>
        <div class="menuitems"><a href="normalUser.php">My Tasks</a></div>
        <div class="menuitems"><a href="SearchTask.php">Search Task</a></div>
        <div class="menuitems"><a href="Signup.html" onclick="verifyPINAndRedirect()">Signup User</a></div>
        <div class="menuitems"><a href="logout.php">Logout</a></div>
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
        $sql = "SELECT * FROM tasklist WHERE whoCanView = '{$_SESSION["staffNumber"]}' OR whoCanView = 'everyone' ORDER BY taskDate ASC";
        
        $result = $conn->query($sql);

        // Display tasks dynamically from the database
        if ($result->num_rows > 0) {
            echo "<div class='box'>";
            echo "<br><br><br>"; //formatting so the content from the database is displayed neatly
            echo "<div class='task-container'>";
            echo "<table class='createTaskForm'>";
            echo "<tr><th class='headingAllTasks' colspan='10'>My Tasks</th></tr>"; 
            echo "<tr><th>Task Name</th><th>Task Description</th><th>Task Date</th><th>Task View</th><th>Task Completed</th><th>Delete</th><th>View Updates</th><th>Change Due Date</th><th>Task complete?</th></tr>";

            // this block of code checks whether the task date is in the past by comparing it to todays date, if it is in the past it is marked and 
            //apprpriate css styles are applied e.g, colour red so it stands out
            while ($row = $result->fetch_assoc()) {
                $taskDate = $row["taskDate"];
                $overdueClass = ($taskDate < date('Y-m-d')) ? "overdue" : ""; // Check if the task date is in the past
        
                echo "<tr>";
                echo "<td>" . $row["taskName"] . "</td>";
                echo "<td>" . $row["taskDescription"] . "</td>";
                echo "<td><span class='task-date $overdueClass'>" . $row["taskDate"] . "</span></td>"; // Add the overdue class
                echo "<td>" . $row["whoCanView"] . "</td>";
                echo "<td>" . $row["taskComplete"] . "</td>";
                echo "<td>";
                echo "<form method='POST' action='' class='userform' onsubmit='return confirmDelete()'>"; //allowing admins to delete task
                echo "<input type='hidden' name='taskName' value='" . $row["taskName"] . "'>";
                echo "<input type='submit' name='deleteTask' value='Delete' class='delete'>";
                echo "</form>";
                echo "</td>";
                echo "<td>";
                echo "<button class='update-button' onclick='openUpdatesList(\"" . $row["taskName"] . "\")'>View Updates</button>";
                echo "</td>";
                echo "<td>";
                echo "<form method='POST' action='' class='userform' onsubmit='return confirmUpdate()'>"; //allowing the supervisor to updaate the task date
                echo "<input type='hidden' name='taskName' value='" . $row["taskName"] . "'>";
                echo "<input type='date' name='newTaskDate' placeholder='New Task Date'>";
                echo "<input type='submit' name='updateTaskDate' class='date-button' value='Change Due Date'>";
                echo "</td>";
                echo "<td>";//allowing the supervisor to mark the task as completed
                echo "<form method='POST' action='' class='userform' onsubmit='return confirmToggleTaskComplete()'>";
                echo "<input type='hidden' name='taskName' value='" . $row["taskName"] . "'>";
                echo "<input type='hidden' name='taskCompleted' value='" . $row["taskComplete"] . "'>";
                echo "<input type='password' name='supervisorPIN' placeholder='Supervisor PIN' required>"; //pin confirmation so not everyone can mark as complete
                echo "<button type='submit' name='toggleTaskComplete' class='complete-button'>Complete Task</button>";
                echo "</form>";
                echo "</td>";
                echo "</td>";
                echo "</tr>";
            }

            echo "</table>";
            echo "</div>";
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

        //closing the popup for the task updates
        function closeUpdatePopup() {
            document.getElementById("updatePopup").style.display = "none";
        }

        //function to allow the supervisor to mark a task as completed, a confirmation pin is required for security purposes
        function confirmToggleTaskComplete() {
    var supervisorPIN = prompt("Enter supervisor PIN:");
    if (supervisorPIN === '1111') { //this is the pin we have set, feel free to change 
        return true;
    } else {
        alert("Incorrect supervisor PIN. Task completion status not updated."); //appropriate error handling for when an incorrect pin is submitted
        return false;
    }
}

//function for when the pin is correct or incorrect to view the signup page
function verifyPINAndRedirect() {
    var enteredPIN = prompt("Enter Admin PIN to create new user:");
    var correctPIN = "1234"; // Change this to your correct PIN
    
    if (enteredPIN === correctPIN) { //if pin is crrect
        // Correct PIN, redirect to signup page
        window.location.href = "Signup.html";
    } else {
        // Incorrect PIN, display an alert message
        alert("Incorrect PIN. Access denied.");
    }
}

    </script>
</body>



</html>