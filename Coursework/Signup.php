<?php
	include("connect.php");

	if(isset($_POST["form1"])){
		$staffNumber = $_POST["staffNumber"];
		$firstName = $_POST["firstName"];
		$lastName = $_POST["lastName"];
		$role = "staff";
		$team = $_POST["team"];
		$email = $_POST["email"];
		$password = $_POST["password"];
		
		$sql = "INSERT INTO `staff`(`firstName`, `lastName`, `team`, `role`, `email`, `password`, `staffNumber`)
		        VALUES('$firstName', '$lastName', '$team', '$role', '$email', '$password', '$staffNumber')";  
		$result = mysqli_query($conn, $sql);
		
		if($result){
			// Redirect to dashboard if insertion was successful
			header("Location: Login.html");
			exit();
		}
		else{
			// Redirect to login page with alert if insertion failed
			echo '<script>
                     window.location.href = "Login.html";
                     alert("Login failed. Invalid username or password!!");
                  </script>';
		}
	}
?>
