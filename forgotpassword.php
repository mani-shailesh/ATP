<!DOCTYPE html>
<html lang="en">
<head>
  <title>Forgot Password</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery-2.1.3.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
<style>
	.navbar {
		position:relative;
	}
	.center {
		text-align: center;
	}
	.logoimg {
			float: left;
			margin-right: 20px; 
			margin-top: -5px;
		}
	.linknone,.linknone:hover,.linknone:visited,.linknone:active,.linknone:link {
					text-decoration:none;
					color: #777;
	}
</style>
</head>

<body>
	<div class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header pull-left">
			<div class="navbar-brand"><a href="index.php" class="linknone">ATP</a><a href="http://www.iitrpr.ac.in/" target="blank"><img class="logoimg" src="img/iitrpr.png" width="30px" height="30px"></a></div>

		</div>

			<a class="navbar-form navbar-right" href="index.php"><input type="submit" name="submit" class="btn btn-success " value="Log In"/>
			</a>
		</div>
	</div>
	<?php 
		session_destroy();
		echo '<div class="alert alert-';
		include("connection.php");
		if(isset($_POST['category']) AND isset($_POST['email'])){
			$com_code=md5(uniqid(rand())); 
			$com_code=md5($com_code.time());
			if($_POST['category']=="teacher"){
				$category=1;
				$query="SELECT * FROM master_teacher WHERE `email`='".mysqli_real_escape_string($link,$_POST['email'])."'";
			$sql = "UPDATE master_teacher SET `forgot_code`='".$com_code."' WHERE email='".mysqli_real_escape_string($link,$_POST['email'])."'";
				}
			else if($_POST['category']=="student") {
					$category=0;
					$query="SELECT * FROM master_student WHERE `email`='".mysqli_real_escape_string($link,$_POST['email'])."'";
					$sql = "UPDATE master_student SET `forgot_code`='".$com_code."' WHERE email='".mysqli_real_escape_string($link,$_POST['email'])."'";
				}

			mysqli_query($link, $sql);
			$result=mysqli_query($link, $query);
			$row=mysqli_num_rows($result);


			if($row==0){
				echo 'danger">Entered email is not registered with us!!!</div>';
				 // print_r($result);
			}
			else{

			 $to = $_POST['email'];
		   $subject = "Forgot Password ATP, IIT Ropar";
		   $header = "ATP: Change password";
		   $msg = 'Please click the link below to Change password of your account.http://localhost/ATP/new_password.php?passkey='.$com_code.'&category='.$category;
			
			// mail($to,$subject,$msg,$header);

			if (@mail($to,$subject,$msg,$header))
			 	{
			 		// echo 'success">A mail has been sent to this email with further instuctions</div>';
			 		header("Location:index.php?confirm=1");
				 }
				 else
				  {
				  	echo 'danger">There were some errors in sending the mail!!!</div>';
				   

				   }
		}
	}
	
	?>
	<div class="container">
		<div class="row center" > 
			<div class="col-md-6 col-md-offset-3">
			<h3>An email will be send to this email including further steps</h3>
			<form class="sendmail" action="forgotpassword.php" method="post">
			<label for="email"></label>
			<div class="input-group">
				<span class="input-group-addon">&#64;</span>
				<input name="email" type="email" placeholder="Your registered email" class="form-control" >
			</div>
			<label for="category">Category</label>
					<div class="input-group">
						
						<span class="input-group-addon glyphicon glyphicon-tag"></span>
						 <select id="cat" type="category" name="category" class="form-control">
							<option value="" selected disabled style="display:none;">Select Category</option>
  							<option value="teacher">Teacher</option>
							  <option value="student">Student</option>
						</select> 
					</div>

			<br>
			<input type="submit" name="send" class="btn btn-success btn-bg margintop an" value="Send" />		
			<br>
      	</form>

 </div>
	</div>
</div>
</body>
</html>