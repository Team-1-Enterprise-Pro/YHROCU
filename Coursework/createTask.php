<?php
//this clears the cache so when the user logs out they cant click the back to access content again
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache"); 
header("Expires: 0");
session_start();

// checks if user is not logged in
if(!isset($_SESSION["user_id"])) {
    // if the uer is not logged in, it redirects them to the login page
    header("Location: login.html");
    exit();}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // get user input from the login form
    $taskName = $_POST["taskName"];
    $taskDescription = $_POST["taskDescription"];
    $taskDate = $_POST["taskDate"];
    $taskViewers = $_POST["taskViewers"];
    $taskCompleted = $_POST["taskCompleted"];

    // making a connection to the database
    $servername = "localhost";
    $db_username = "root"; 
    $db_password = "";
    $dbname = "enterpriseCW";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    // check if the task name already exists, so tasks are not duplicated when creating
    $sql3 = "SELECT * FROM taskList WHERE taskName = '$taskName'";
    $checkIfExists = mysqli_query($conn, $sql3);

    if (mysqli_num_rows($checkIfExists) == 0) {
        // if it doesnt exist then the task gets inserted into the table
        $insertToTable = "INSERT INTO taskList (taskName, taskDescription, taskDate, whoCanView, taskComplete) VALUES ('$taskName', '$taskDescription', '$taskDate', '$taskViewers', '$taskCompleted')";

        if (mysqli_query($conn, $insertToTable)) {
            echo '<script>'; //javascript for popups
            echo 'if (confirm("Task created successfully")) {';
            echo '    window.location.href = "tasks.php";'; //redirects to tasks page
            echo '}';
            echo '</script>';
            exit();
        } else {
            echo "Error adding task: " . mysqli_error($conn);
        }
    } else {
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
    <link rel="stylesheet" href="style.css">
    
</head>

<body>
    
        <div class="navbar">
        <div class="menuitems"><a href="createTask.php">Create Task</a></div>
        <div class="menuitems"><a href="tasks.php">All Tasks</a></div>
        <div class="menuitems"><a href="normalUser.php">My Tasks</a></div>
        <div class="menuitems"><a href="SearchTask.php">Search Task</a></div>
        <div class="menuitems"><a href="Signup.html">Signup User</a></div>
        <div class="menuitems"><a href="login.html">Logout</a></div>
    </div>

    <!-- this is the html form to create a task -->
    <div class="box">
    <div class="createTaskForm">
        <form method="POST" action="createTask.php" class="input-box">
            <div class="taskFormContentWrapper">
            <div class="taskFormContent">
            <h1>Create Task</h1>
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
            <div><div>
            <button name="createTask" class="enter-btn">Create Task</button>
      
        </form>
    </div>
   </div>

</body>

</html>
