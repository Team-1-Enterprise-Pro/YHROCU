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
            <h1>Search tasks</h1>
            <form method="POST" action="">
                <div class="input-container">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" class="input-field" placeholder="Search Tasks" name="search" required>
                </div>
                <button type="submit" name="submit" class="enter-btn">Search</button>
            </form>
            <table>
                <thead>
                    <tr>
                        <th>Task Name</th>
                        <th>Task Description</th>
                        <th>Task Date</th>
                        <th>Assignees</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- PHP to create table filled with data from database --> 
                    <?php
                    include("connect.php");
                    if(isset($_POST["submit"])){
                        $search = mysqli_real_escape_string($conn, $_POST["search"]);
                        $get_tasks= "SELECT * FROM tasklist WHERE taskName LIKE '%$search%'";
                        $result = mysqli_query($conn, $get_tasks);
                        if($result){
                            while($row = mysqli_fetch_assoc($result)){
                                $taskName = $row["taskName"];
                                $taskDescription = $row["taskDescription"];
                                $taskDate = $row["taskDate"];
                                $whoCanView = $row["whoCanView"];
                                echo "<tr>
                                        <td>$taskName</td>
                                        <td>$taskDescription</td>
                                        <td>$taskDate</td>
                                        <td>$whoCanView</td>
                                    </tr>";
                            }
                        } else {
                            echo "Error: " . mysqli_error($conn);
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
