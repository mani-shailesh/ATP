<?php
 include('connection.php');
 $passkey = mysqli_real_escape_string($link,$_GET['passkey']);
 $len=strlen($passkey);
 $passkey=substr($passkey,2,$len-4);
 $category=mysqli_real_escape_string($link,$_GET['category']);
 $category=substr($category,2,3);

 if($category==1){
 	$sql = "UPDATE master_teacher SET com_code=NULL WHERE com_code='$passkey'";
 }
 else if($category==0){
 	$sql = "UPDATE master_student SET com_code=NULL WHERE com_code='$passkey'";
 }
 $result = mysqli_query($link,$sql); 
 //or die(mysqli_error());
 echo '<h3 style="text-align: center;color:';
 if($result)
 {
  echo 'green">Your account is now active.<br> You will automatically redirect to login page or <a href="index.php">Log in</a></h3> <meta http-equiv="refresh" content="3;url=index.php" />';
}
 else
 {
  echo 'red">Some error occured.</h3>';
 }
?>