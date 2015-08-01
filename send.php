<?php
session_start();
include("connection.php");
function findCourses($str) {
								    return explode(",",$str);
								}
if(isset($_POST['send'])){
	$receivers=findCourses($_POST['entrynumber']);
	foreach ($receivers as $student){
		$student=trim($student);
		$student=strtoupper($student);
		$sql="INSERT INTO `message`(`teacher`, `student`, `message`) VALUES ('".$_SESSION['email']."','".$student."','".$_POST['message']."')";
		// print_r($sql);
		mysqli_query($link, $sql);
	}
	header('location: teacher_dashboard.php');
}

?>