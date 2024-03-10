<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the login form
    $taskName = $_POST["taskName"];
    $taskDescription = $_POST["taskDescription"];
    $taskDate = $_POST["taskDate"];
    $taskViewers = $_POST["taskViewers"];

    // Establish a database connection and verify the user's credentials
    $servername = "localhost";
    $db_username = "root"; 
    $db_password = "";
    $dbname = "enterpriseCW";

    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }


    // Check if task name already exists
    $sql3 = "SELECT * FROM taskList WHERE taskName = '$taskName'";
    $checkIfExists = mysqli_query($conn, $sql3);

    if (mysqli_num_rows($checkIfExists) == 0) {
        // Insert task into the table
        $insertToTable = "INSERT INTO taskList (taskName, taskDescription, taskDate, whoCanView) VALUES ('$taskName', '$taskDescription', '$taskDate', '$taskViewers')";

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
        echo ""; //task already exists
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
        <div class="menuitems"><a href="login.html">Logout</a></div>
    </div>

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
            <input type="text" name="taskViewers" placeholder="Who can view the task?" class="input-field"><div><div>
            <button name="createTask" class="enter-btn">Create Task</button>
      
        </form>
    </div>
   </div>

</body>

</html>
