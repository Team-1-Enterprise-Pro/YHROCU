<?php
	include("connect.php");
	if(isset($_POST["submit"])){
		$staffNumber = $_POST["staffNumber"];
		$password = $_POST["password"];
		
		$sql = "select * from staff where staffNumber = '$staffNumber' and password = '$password'";  
		$result = mysqli_query($conn, $sql);
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		$count = mysqli_num_rows($result);
		if($count == 1){
			#replace dashboard.html
			header("Location:tasks.php");
			exit();
		}
		else{
			echo '<script>
                    window.location.href = "Login.html";
                    alert("Login failed. Invalid username or password!!")
                </script>';
		}
	}
?>