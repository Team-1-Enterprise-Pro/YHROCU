<?php
//this clears the cache so when the user logs out they cant click the back to access content again
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache"); 
header("Expires: 0");
session_start();

// checks if user is not logged in, this is important as certain contect is only visible to logged in users
if(!isset($_SESSION["staffNumber"])) {
    //if the uer is not logged in, it redirects them to the login page
    header("Location: login.html");
    exit();}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // get user input from the login form (this is for creating a new task)
    $taskName = $_POST["taskName"];
    $taskDescription = $_POST["taskDescription"];
    $taskDate = $_POST["taskDate"];
    $taskViewers = $_POST["taskViewers"];
    $taskCompleted = $_POST["taskCompleted"];

    // making a connection to the database, ammend these details as they will be different for every local machine
    $servername = "localhost";
    $db_username = "root"; 
    $db_password = "";
    $dbname = "enterpriseCW";

    // creating  a connection to the database and assigning it to a variable/object so it can be used
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    //using the object to see if the connection has been established successfully
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    // this is for creating a task, check if the task name already exists, so tasks are not duplicated when creating
    $sql3 = "SELECT * FROM taskList WHERE taskName = '$taskName'";
    $checkIfExists = mysqli_query($conn, $sql3);

    if (mysqli_num_rows($checkIfExists) == 0) {
        // if the task name doesnt exist only then does the task gets inserted into the table
        $insertToTable = "INSERT INTO taskList (taskName, taskDescription, taskDate, whoCanView, taskComplete) VALUES ('$taskName', '$taskDescription', '$taskDate', '$taskViewers', '$taskCompleted')";

        if (mysqli_query($conn, $insertToTable)) {
            echo '<script>'; //javascript for popups
            echo 'if (confirm("Task created successfully")) {'; //a pop up to show that the task has been created successfully
            echo '    window.location.href = "tasks.php";'; //redirects to the tasks page so the user can see all the tasks that exist
            echo '}';
            echo '</script>';
            exit();
        } else {
            echo "Error adding task: " . mysqli_error($conn); //an error handling for when a task is not created
        }
    } else {
        //an error handling for when a task with the same name already exists in the database
        echo '<script>
                     alert("Task with that name already exists"); 
					 window.location.href = "createTask.php"; // Redirect to signup page
                  </script>';
    }


    // Closing the connection
    $conn->close();
}
?>

<html>

<head>
    <!--Title of the webpage-->
    <title>YHROCU</title>
    <!--Linking the style sheet-->
    <link rel="stylesheet" href="CSS_createTask.css">
    
</head>

<body>
    <!--this is a div containing the menu items and their appropriate links-->
    <div class="navbar">
        <div class="menuitems"><a href="createTask.php">Create Task</a></div>
        <div class="menuitems"><a href="tasks.php">All Tasks</a></div>
        <div class="menuitems"><a href="normalUser.php">My Tasks</a></div>
        <div class="menuitems"><a href="SearchTask.php">Search Task</a></div>
        <div class="menuitems"><a href="Signup.html" onclick="verifyPINAndRedirect()">Signup User</a></div>
        <div class="menuitems"><a href="logout.php">Logout</a></div>
    </div>

    <!-- this is the html form to create a task -->
    <div class="box">
        <div class="createTaskForm">
            <h1 class="heading">Create Task</h1>
            <form method="POST" action="createTask.php" class="input-box">
                <!-- Name of task -->
                <input type="text" name="taskName" placeholder="Task Name" class="input-field">
                <!-- Description of task -->
                <textarea name="taskDescription" rows="5" cols="30" placeholder="Task description" class="input-field"></textarea>
                <!-- Due date for task -->
                <input type="date" name="taskDate" placeholder="Task Due Date" class="input-field">
                <!-- Who can view the task -->
                <input type="text" name="taskViewers" placeholder="Who can view task? Enter staff number or 'Everyone'" class="input-field">
                <!-- Is the task complete -->
                <input type="text" name="taskCompleted" placeholder="Is the task complete? Enter Y or N" class="input-field">
                <button name="createTask" class="enter-btn">Create Task</button>
            </form>
        </div>
    </div>
<script>
    //this function directs the user if they entered the correct or incorrect admin pin, for example
    //certain parts of the website such as deleting tasks or signing up users shouldnt be visible to everyone, therefore the pin is required
    function verifyPINAndRedirect() { 
    var enteredPIN = prompt("Enter Admin PIN to create new user:");
    var correctPIN = "1234"; // this is the admin pin to control task deletions and accessing certain parts of the website, feel free to change
    
    if (enteredPIN === correctPIN) {
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
