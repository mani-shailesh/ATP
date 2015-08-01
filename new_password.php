<!DOCTYPE html>
<html lang="en">
<head>
  <title>Forgot Password</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery-2.1.3.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
 </head>


<body>
<div class="container">
<div class="row" style="text-allign:center">
	<div class="col-md-6 col-md-offset-3">
<?php
 session_start();
 include('connection.php');
 // print_r($_GET);
 $passkey = $_GET['passkey'];
 // $len=strlen($passkey);
 // $passkey=substr($passkey,2,$len-4);
 $category=$_GET['category'];
 // $category=substr($category,2,3);
 if($category==1){
 	$_SESSION['category']='teacher';
 	$query="SELECT * FROM master_teacher WHERE `forgot_code`='".mysqli_real_escape_string($link,$passkey)."'";
 	$sql = "UPDATE master_teacher SET `forgot_code`=NULL WHERE `forgot_code`='".mysqli_real_escape_string($link,$passkey)."'";
 }
 else if($category==0){
 	$_SESSION['category']='student';
 	$query="SELECT * FROM master_student WHERE `forgot_code`='".mysqli_real_escape_string($link,$passkey)."'";
 	$sql = "UPDATE master_student SET `forgot_code`=NULL WHERE `forgot_code`='".mysqli_real_escape_string($link,$passkey)."'";
 }
 $res=mysqli_query($link, $query);
 $row=mysqli_fetch_array($res);
 $_SESSION['id']=$row['id'];
 mysqli_query($link, $sql); 
 //or die(mysqli_error());
 if($row)
 {

 	echo '
        <form action="update_password.php" method="post">
        	<input type="hidden" name="forgot" value="1">
			<label for="newpassword"></label>
					<div class="input-group">
						<span class="input-group-addon">New password</span>
				<input id="newpassword" name="newpassword" type="password"  class="form-control">
			</div>
			<div id="error" class="alert alert-danger" style="display:none;"></div>
			<label for="confirmpassword"></label>
					<div class="input-group">
						<span class="input-group-addon">Confirm password</span>
				<input id="confirmpassword" name="confirmpassword" type="password"  class="form-control">
			</div>
					<br>

			<div id="message1" class="alert alert-danger" style="display:none;">Does not match</div>
			<div id="message2" class="alert alert-success" style="display:none;">Matching</div>
			
			<br>
      	<input type="submit" id="changepassword" name="changepassword" class="btn btn-success btn-bg margintop an" value="Change password" />
  </form>';

  
}
 else
 {
  echo "Some error occured.";
 }
?>
</div>
</div>
</div>
<script type="text/javascript">
$('#newpassword').on('keyup', function (){
	var reg = new RegExp(`[A-Z]`);
	 var VAL=$(this).val();
	if ($(this).val().length<8){ 
			$('#error').html('Please enter a password with at least 8 character');
			$('#error').show();
			}
	
     else if (!reg.test(VAL)) {
      		$('#error').html('Please enter at least one capital letter');
     		$('#error').show();
	 }

	else {
		$("#error").hide();
	}
});

$('#confirmpassword').on('keyup', function () {
    if ($(this).val() == $('#newpassword').val() && $('#newpassword').val().length>7 ) {
        // $('#message').html('matching').css('color', 'green');
   		// if ($('#oldpassword').val().length!=0) {
   		$('#message1').hide();
   		$('#message2').show();
   		$('#changepassword').prop('disabled', false);	   		
	   	// }
	   } else  {

    	$('#message2').hide();
    	$('#message1').show();
   		$('#changepassword').prop('disabled', true);
    }
    // $('#message').html('not matching').css('color', 'red');
});
// var q="<?php echo (isset($_GET['changepass']))?$_GET['changepass']:'';?>";
if ($('#confirmpassword').val().length==0 || $('#newpassword').val().length==0 || $('#newpassword').val().length<8)
{
	   		$('#changepassword').prop('disabled', true);

}
 
</script>
</body>
</html>