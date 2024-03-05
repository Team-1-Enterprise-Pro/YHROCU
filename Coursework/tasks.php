<?php //establishing a connection to the server
$servername="localhost";
$username="root";
$password="";
$dbname="enterpriseCW";

$conn=new mysqli($servername, $username, $password, $dbname);

//checks that the connection has been established
if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}

else {
    echo "";
}

//checks that if the remove from cart button has been clicked then it gets the product number which was selected and deletes the row in the table called cart
if ($_SERVER["REQUEST_METHOD"]=="POST"&& isset($_POST["deleteTask"])) {
    $taskName=$_POST["taskName"];

    // this deletes the selected product from the table
    $deleteFromTable="DELETE FROM taskList WHERE taskName = '$taskName'";

    if ($conn->query($deleteFromTable)===TRUE) {
        echo "";
    }

    else {
        echo "Error deleting task: ". $conn->error;
    }
}

?><html>

<head>
        <title>YHROCU</title>
            <link rel="stylesheet" href="style.css">
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
            </script>
</head>

<body>
    <div class="navbar">
        <div class="menuitems"><a href="createTask.php">Create Task</a></div>
        <div class="menuitems"><a href="tasks.php">All Tasks</a></div>
        <div class="menuitems"><a href="">Search Task</a></div>
        <div class="menuitems"><a href="login.html">Logout</a></div>
    </div><?php $sql="SELECT * FROM taskList";
$result=$conn->query($sql);

// check if there are tasks in the database
if ($result->num_rows > 0) {
    // display tasks
        echo "<div class='box'>";
        echo "<br><br><br>";
        echo "<table class='createTaskForm'>";
        echo "<th class='headingAllTasks' colspan='4'><br>All Tasks<th>";

        while ($row=$result->fetch_assoc()) {
        //task details displayed in table rows
        echo "<tr>";
        echo "<td >Task Name: ". $row["taskName"] . "</td>";
        echo "<td>Task Description: ". $row["taskDescription"] . "</td>";
        echo "<td>Task Date: ". $row["taskDate"] . "</td>";
        echo "<td>Task View: ". $row["whoCanView"] . "</td>";
        echo "<td><form method='POST' action='' class='userform' onsubmit='return confirmDelete()'>";
        echo "<input type='hidden' name='taskName' value='". $row["taskName"] . "'>";
        echo "<input type='submit' name='deleteTask' value='Delete task' class='button-box'></form></td>";
        echo "<br>";
        echo "</tr>";
    }

    echo "</table>";
    echo "</div>"; 
}

else {
    // If no tasks found
    echo "No tasks found.";
}

?>
</body>

</html>