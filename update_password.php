<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Update Password</title>
</head>
<body>	

<?php
	session_start();
	// print_r($_POST);
	include("connection.php");
	// print_r($_SESSION);
	// print_r($_SESSION);
	if($_SESSION['category']=='teacher'){
		$table='master_teacher';
		$dashboard='teacher_dashboard';
	}
	else{
		$table='master_student';
		$dashboard='student_dashboard';
	}
	$query="SELECT email FROM `".$table."` WHERE id='".mysqli_real_escape_string($link,$_SESSION['id'])."' LIMIT 0 , 30";
	$result=mysqli_query($link,$query);
	$row=mysqli_fetch_array($result);
			// print_r($result);
	$email=$row['email'];
	// echo $table."<br>";
		if(isset($_POST['forgot'])){
			$query="SELECT * FROM `".$table."` where 1";
			// echo $query;
			$result=mysqli_query($link,$query);
			$row=mysqli_fetch_array($result);
		}
		else{
			
			// echo $email."<br>";							
			$query="SELECT * FROM `".$table."` where id='".mysqli_real_escape_string($link,$_SESSION['id'])."' AND password='".mysqli_real_escape_string($link,md5(md5($email).$_POST['oldpassword']))."' LIMIT 1";
			// echo $query;
			$result=mysqli_query($link,$query);
			$row=mysqli_fetch_array($result);
		}
		echo '<h3 style="text-align: center;color: ';
		if($row){
			$query = "UPDATE `".$table."` SET `password`='".mysqli_real_escape_string($link,md5(md5($email).$_POST['newpassword']))."' WHERE id='".mysqli_real_escape_string($link,$_SESSION['id'])."'";
			mysqli_query($link,$query);
			echo 'green">Your password has been successfully updated';
			// echo $query;
		}
		else{
			echo 'red">Please enter valid old password';
		}
		// echo '</h3>';
		echo '<br>You will be automatically redirected to your home page in 5 seconds or <a href="'.$dashboard.'.php">click here</a> to continue. <meta http-equiv="refresh" content="5;url='.$dashboard.'.php" /></h3>';
?>

</body>
</html>