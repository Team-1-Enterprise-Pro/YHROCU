<?php
session_start();
//using the connect file to establish a quick connect to the database
include("connect.php");
$conn = connectToDatabase();

	//getting all of the signup information from the user to add to the database
	if(isset($_POST["form1"])){
		$staffNumber = $_POST["staffNumber"];
		$firstName = $_POST["firstName"];
		$lastName = $_POST["lastName"];
		$role = "staff";
		$team = $_POST["team"];
		$email = $_POST["email"];
		$password = $_POST["password"];
		
		//inserting the details into the database
		$sql = "INSERT INTO `staff`(`firstName`, `lastName`, `team`, `role`, `email`, `password`, `staffNumber`)
		        VALUES('$firstName', '$lastName', '$team', '$role', '$email', '$password', '$staffNumber')";  
		$result = mysqli_query($conn, $sql);
		
		if($result){
			// Redirect to dashboard if insertion was successful
			echo '<script>
                     confirm("User account created");
					 window.location.href = "signup.html"; // Redirect to signup page
                  </script>';
			exit();
		}
		else{
			// Redirect to login page with alert if insertion failed
			echo '<script>
                     alert("User account NOT created, please retry");
					 window.location.href = "signup.html"; // Redirect to signup page
                  </script>';
		}
	}
?>
