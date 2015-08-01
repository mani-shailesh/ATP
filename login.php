<?php
// ini_set('display_errors',1);
// ini_set('display_startup_errors',1);
// error_reporting(-1);
	session_start();
	if ($_GET['logout']==1 AND isset($_SESSION['id'])) {session_destroy();
		
		$message="You have been log out. Have a nice day.";
	
	}
	else if ($_GET['confirm']==1 AND isset($_SESSION['id'])) { session_destroy();
		  $message="Your Confirmation link Has Been Sent To Your Email Address. Open your inbox and confirm."; 
				 
	}
	else if ($_GET['confirm']==0 AND isset($_SESSION['id'])) {session_destroy();
 		$error="Cannot send Confirmation link to your e-mail address.".$error;
	}
	else if($_GET['confirm']==1){
		$message="Please check your mail for further instructions";
	}

	include("connection.php");
	if ($_POST['submit']=="Sign Up") {
		
		if (!$_POST['email']) $error.="<br />Please enter your mail";
			else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) $error.="Please enter a valid email";
		$email = $_POST['email'];
		$allowed = array('iitrpr.ac.in');

    $domain = array_pop(explode('@', $email));

    if ( ! in_array($domain, $allowed)) $error.="<br />Please enter email-id of institute domain name";


		if (!$_POST['name']) $error.="<br />Please enter your name";
		if (!$_POST['password']) $error.="<br />Please enter your password";
			else {
			if (strlen($_POST['password'])<8) $error.="<br />Please enter a password with at least 8 character";
			if (!preg_match('`[A-Z]`',$_POST['password'])) $error.="<br />Please enter at least one capital letter";
			}
		if (!$_POST['category']) $error.="<br />Please enter your category";
		if ($_POST['category']=="student" AND !$_POST['entryno']) $error.="<br />Please enter your Entry No";
		if ($error) $error= "There were error(s) in your sign up details:".$error;	
		else {
				
				$query1="SELECT * FROM master_teacher WHERE email='".mysqli_real_escape_string($link,$_POST['email'])."'";
				$result1=mysqli_query($link,$query1);
				$results1=mysqli_num_rows($result1);
				$query2="SELECT * FROM master_student WHERE email='".mysqli_real_escape_string($link,$_POST['email'])."'";
				$result2=mysqli_query($link,$query2);
				$results2=mysqli_num_rows($result2);
				if($_POST['category']=="student"){
				$entryno=strtoupper($_POST['entryno']);
				$query3="SELECT * FROM master_student WHERE entryno='".mysqli_real_escape_string($link,$entryno)."'";
				$result3=mysqli_query($link,$query3);
				$results3=mysqli_num_rows($result3);
			}
				$category=0;
				if ($results1 OR $results2 OR ($_POST['category']=="student" AND $results3)) $error= "That email address or entry no is already registered. Do you want to log in?";
				else {
						$com_code=md5(uniqid(rand()));
						
						if($_POST['category']=="teacher"){
						$sql="SELECT * FROM `roll_list` WHERE `instructors` LIKE '%".$_POST['email']."%'";
						$result=mysqli_query($link,$sql);
						$courses="";
						while($row=mysqli_fetch_array($result)){
							$courses.=$row['course'].",";
						}
						$len=strlen($courses);
						$courses=substr($courses, 0, $len-1);
						$query="INSERT INTO master_teacher (email,password,name,com_code,courses) VALUES('".mysqli_real_escape_string($link,$_POST['email'])."','".md5(md5($_POST['email']).$_POST['password'])."','".mysqli_real_escape_string($link,$_POST['name'])."','".mysqli_real_escape_string($link,$com_code)."','".$courses."')";
						mysqli_query($link,$query);
						$category=1;
						
					
					}
					else if($_POST['category']=="student") {
						$sql="SELECT * FROM `roll_list` WHERE `students` LIKE '%".$_POST['entryno']."%'";
						print_r($sql);
						$result=mysqli_query($link,$sql);
						$courses="";
						while($row=mysqli_fetch_array($result)){
							$courses.=$row['course'].",";
						}
						$len=strlen($courses);
						$courses=substr($courses, 0, $len-1);
						$entryno=strtoupper($_POST['entryno']);
						
						$query="INSERT INTO master_student (email,password,name,entryno,com_code,courses) VALUES('".mysqli_real_escape_string($link,$_POST['email'])."','".md5(md5($_POST['email']).$_POST['password'])."','".mysqli_real_escape_string($link,$_POST['name'])."', '".mysqli_real_escape_string($link,$entryno)."','".mysqli_real_escape_string($link,$com_code)."','".$courses."')";
						mysqli_query($link,$query);
						$category=0;
					
					}
					$to = $_POST['email'];
				   $subject = "Confirmation from ATP, IIT Ropar";
				   $header = "ATP: Confirmation from ATP";
				   $msg = "'Please click the link below to verify and activate your account.http://localhost/ATP/confirm.php?passkey='.$com_code.'&category='.$category";
				  

				   if (@mail($to,$subject,$msg,$header))
				    {

				 	header("Location:index.php?confirm=1");

				   }
				   else
				    {

				   header("Location:index.php?confirm=0");

				   }

				 $_SESSION['id']=mysqli_insert_id($link);
				 
			}
		}
	}

	if ($_POST['submit']=="Log In"){
		
		if (!isset($_POST['category'])) {
			$error="Select your category";
		}

		else {
			$_SESSION['category']=$_POST['category'];
		if($_POST['category']=="teacher"){
		$query="SELECT * FROM master_teacher where email='".mysqli_real_escape_string($link,$_POST['loginemail'])."' AND password='".md5(md5($_POST['loginemail']).$_POST['loginpassword'])."' LIMIT 1";
		$result=mysqli_query($link,$query);
		$row=mysqli_fetch_array($result);
		if($row) {	
			if ($row['com_code']==NULL) {
					$_SESSION['id']=$row['id'];
					$_SESSION['name']=$row['name'];
					$_SESSION['email']=$row['email'];
					header("Location:teacher_dashboard.php");
			}
			else  {
				$error="Please check your email to confirm your account";
				// $array=print_r($row);
				$error=$array.$error;
			}
		}

		else {
			$error="We could not find username in database.";
		}

		}

		else if ($_POST['category']=="student") {
		$query="SELECT * FROM master_student where email='".mysqli_real_escape_string($link,$_POST['loginemail'])."' AND password='".md5(md5($_POST['loginemail']).$_POST['loginpassword'])."' LIMIT 1";
		$result=mysqli_query($link,$query);
		$row=mysqli_fetch_array($result);
		if($row){
			if ($row['com_code']==NULL) {

				$_SESSION['entryno']=$row['entryno'];
				$_SESSION['id']=$row['id'];
				$_SESSION['name']=$row['name'];
				header("Location:student_dashboard.php");
				
			}
			else  {
				$error="Please check your email to confirm your account";
			}	
		}
		}
		

		else {
			$error="We could not find username in database.";
		}
		
		}
	
	}
?>