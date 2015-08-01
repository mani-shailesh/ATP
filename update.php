<?php

session_start();
if(!isset($_SESSION['id'])){
	header("Location:index.php");
}
include("connection.php");
$sql = "SELECT COLUMN_NAME
FROM INFORMATION_SCHEMA.COLUMNS
WHERE table_name = '".mysqli_real_escape_string($link,$_SESSION['course'])."' AND column_name LIKE '2%' ORDER BY column_name";
$result = mysqli_query($link,$sql);
if($_SESSION['new']==1){
	$sql = "INSERT INTO ".$_SESSION['course']."(`date`";
	// print_r($sql);
	while($row = mysqli_fetch_array($result)){
		$value=$row['COLUMN_NAME'];
		$sql=$sql.", `".$value."`";
	}
	$sql.=") VALUES (";
	$sql.="'".$_SESSION['date']."'";
	$query = "SELECT COLUMN_NAME
	FROM INFORMATION_SCHEMA.COLUMNS
	WHERE table_name = '".mysqli_real_escape_string($link,$_SESSION['course'])."' AND column_name LIKE '2%' ORDER BY column_name";
	$result = mysqli_query($link,$query);
	// print_r($sql);
	// $row = mysqli_fetch_array($result)
	// $value=$row['COLUMN_NAME'];
	// $sql.=$_POST[$value];
	while($row = mysqli_fetch_array($result)){
		$value=$row['COLUMN_NAME'];
		$sql=$sql.",".$_POST[$value];
	}
	$sql.=")";
	// print_r($sql);
	if(mysqli_query($link,$sql))
	header("Location:teacher_dashboard.php?result=1");
}
else{
	$sql="SELECT * FROM `".$_SESSION['course']."` WHERE `id`=".mysqli_real_escape_string($link,$_POST['class_id']);
	$rslt=mysqli_query($link, $sql);
	$row_last=mysqli_fetch_array($rslt);


	$sql = "UPDATE ".$_SESSION['course']." SET `date`=";
	// print_r($sql);
	$sql.="'".$_SESSION['date']."'";
	while($row = mysqli_fetch_array($result)){
		$value=$row['COLUMN_NAME'];
		if($row_last[$value]!=$_POST[$value]){
			$qry="INSERT INTO `alert` (`from`, `to`, `class`, `course`, `student`, `attendance_date`, `teacher`) 
			VALUES ('".$row_last[$value]."', '".$_POST[$value]."', '".$_POST['class_no']."', '".$_SESSION['course']."', '".$value."', '".$_SESSION['date']."', '".$_SESSION['email']."')";
			mysqli_query($link, $qry);
		}
		$sql=$sql.", `".$value."`=";
		$sql=$sql.$_POST[$value];
	}
	$sql=$sql." WHERE `date`=";
	// print_r($sql);
	$sql.="'".mysqli_real_escape_string($link,$_SESSION['date'])."' AND `id`=".mysqli_real_escape_string($link,$_POST['class_id']);
	// $query = "SELECT COLUMN_NAME
	// FROM INFORMATION_SCHEMA.COLUMNS
	// WHERE table_name = '".$_SESSION['course']."' AND column_name LIKE '2%' ORDER BY column_name";
	// $result = mysqli_query($link,$query);
	// // print_r($sql);
	// // $row = mysqli_fetch_array($result)
	// // $value=$row['COLUMN_NAME'];
	// // $sql.=$_POST[$value];
	// while($row = mysqli_fetch_array($result)){
	// 	$value=$row['COLUMN_NAME'];
	// 	$sql=$sql.",".$_POST[$value];
	// }
	// $sql.=")";
	// print_r($sql);
	mysqli_query($link,$sql);
	header("Location:teacher_dashboard.php?result=0");
}

?>