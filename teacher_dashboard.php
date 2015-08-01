<?php
	
	session_start();
if(!isset($_SESSION['id'])){
	header("Location:index.php");
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/datepicker.css">
  <script src="js/jquery-2.1.3.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
   <script src="js/bootstrap-datepicker.js"></script>

  <style type="text/css">
/*  label{margin-left: 20px;}*/
/*#datepicker{width:180px; margin: 0 20px 20px 20px;}*/
#datepicker > span:hover{cursor: pointer;}
	.container{
		text-align: center;
	}
	.navbar{
	position: relative;
}
.borderround {
	border:1px solid #DEDEDE;
	border-radius: 10px;
}
.righticon {
	float: right;
}
.smallfont {
	font-size: .6em;
}
.linknone,.linknone:hover,.linknone:visited,.linknone:active,.linknone:link {
	text-decoration:none;
color: #777;
	
}
.logoimg {
			float: left;
			margin-right: 20px; 
			margin-top: -5px;
		}
.clearicon {
	margin-top:-30px;
}	
	</style>
</head>

<body>
<div class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header pull-left">
		<div class="navbar-brand"><a href="teacher_dashboard.php" class="linknone">ATP</a><a href="http://www.iitrpr.ac.in/" target="blank"><img class="logoimg" src="img/iitrpr.png" width="30px" height="30px"></a></div>				
		</div>
		<div class="pull-right">
			<ul class="navbar-nav nav">
			<li><a href="logout.php">Log Out</a></li>
			</ul>
			
		</div>
	</div>
	</div>

<div class="container">
<!-- <div id="passwordchange" class="alert alert-success" style="display:none;">Password Changed</div> -->
<a class="righticon" href="view_attendance.php"><button class="btn btn-success">View Attendance</button></a>
	
	<?php

		echo '<h2>Hi, '.$_SESSION['name'].'! Welcome to Attendance Tracking Portal of IIT Ropar</h2>';

	?>
	<br>

 <!--  <h2>Your Attendance</h2> -->
  <h4>Please select course and date to add or edit attendance</h4>
  <hr> 
  </div>
 <div class="container">
<div class="row">
<div class="col-md-4 am" id="toprow">
 <form class="margintop" method="post" action="teacher_dashboard.php">
					<label for="category"></label>
					<div class="input-group">
						
						<span class="input-group-addon">Course</span>
						 <select id="cat" type="course" name="course" class="form-control" >
							<option value="" selected disabled style="display:none;">Select Course</option>
							<?php

								include("connection.php");
								$query="SELECT courses
								FROM `master_teacher`
								WHERE id='".mysqli_real_escape_string($link,$_SESSION['id'])."'
								LIMIT 0 , 30";
								$result=mysqli_query($link,$query);
								$row=mysqli_fetch_array($result);
								function findCourses($str) {
								    return explode(",",$str);
								}
								$courses=findCourses($row['courses']);
								foreach ($courses as $value){
									echo "<option value=".$value.">".$value."</option>";
								}
							?><!-- 
  							<option value="teacher">Teacher</option>
							  <option value="student">Student</option> -->
						</select> 
					</div>	
					<label></label>
					<div id="datepicker" class="input-group date" data-date-format="yyyy-mm-dd">
						 <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
					   <input type="text" name="date" class="form-control"/>
					   
					</div>
					<br>
					<input type="submit" name="submit" class="btn btn-success btn-bg margintop an" value="Proceed" />
				</form>  
				<hr>
				<br>
</div>

<div class="col-md-4 " id="toprow">

		


<button type="button" class="btn btn-success btn-bg" data-toggle="modal" data-target="#myModal">
  Send notification
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Notification</h4>
      </div>
      <div class="modal-body">
        <form action="send.php" method="post">
			<label for="entrynumber"></label>
					<div class="input-group">
						<span class="input-group-addon">Entry Number(s)</span>
				<input name="entrynumber" type="text" placeholder="Ex-2013CSB1004,2013CSB1069" class="form-control">
			</div>
			<label for="message"></label>
					<div class="input-group">
						<span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
			<textarea style="resize: none;height:80px;" name="message" type="text" class="form-control"></textarea>
			</div>	
			<br>
			<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<input type="submit" name="send" class="btn btn-success btn-bg margintop an" value="Send" />
      </div>
      	</form>
      </div>
      
    </div>
  </div>
</div>

<?php
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


<button type="button" class="btn btn-success btn-bg" data-toggle="modal" data-target="#myModal1">
  Update password
</button>

<!-- Modal -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Update Password</h4>
      </div>
      <div class="modal-body">
        <form action="update_password.php" method="post">
			<label for="oldpassword"></label>
					<div class="input-group">
						<span class="input-group-addon">Old password</span>
				<input id="oldpassword" name="oldpassword" type="password"  class="form-control">
			</div>
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
      	<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<input type="submit" id="changepassword" name="changepassword" class="btn btn-success btn-bg margintop an" value="Change password" />
      </div>
  </form>
      </div>
      
    </div>
  </div>
</div>





</div>
<div class="col-md-4 " id="toprow">

	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-success">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a class="linknone" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
        Sent History
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
        <h4><a class="righticon" href="javascript:DoPost(0)"><button class="btn btn-sm btn-danger clearicon">Clear All</button></a></h4>
        <br>
		<div style="word-wrap: break-word;overflow:auto;overflow-y: scroll;height: 180px;">
	

	<?php 
		if(isset($_POST['delete'])){
			if($_POST['delete']==0){
				$sql="SELECT * FROM `message` WHERE `teacher`='".mysqli_real_escape_string($link,$_SESSION['email'])."'";
				$result=mysqli_query($link, $sql);
				while($row=mysqli_fetch_array($result)){
					if($row['show_student']==1){
						$sql="UPDATE `message` SET `show_teacher`='0' WHERE `id`='".mysqli_real_escape_string($link,$row['id'])."'";		
					}
					else{
						$sql="DELETE FROM `message` WHERE `id`='".mysqli_real_escape_string($link,$row['id'])."'";		
					}
				mysqli_query($link, $sql);	
				}
			}
			else{
				$sql="SELECT * FROM `message` WHERE `id`='".mysqli_real_escape_string($link,$_POST['delete'])."' LIMIT 1";
				$result=mysqli_query($link, $sql);
				$row=mysqli_fetch_array($result);
				if($row['show_student']==1){
					$sql="UPDATE `message` SET `show_teacher`='0' WHERE `id`='".mysqli_real_escape_string($link,$_POST['delete'])."'";
				}
				else{
					$sql="DELETE FROM `message` WHERE `id`='".mysqli_real_escape_string($link,$_POST['delete'])."'";
				}
				mysqli_query($link, $sql);
			}
		}
		$sql="SELECT * FROM `message` WHERE `teacher`='".mysqli_real_escape_string($link,$_SESSION['email'])."' AND `show_teacher`='1' ORDER BY `time` DESC";
		$result=mysqli_query($link, $sql);
		$cnt=mysqli_num_rows($result);
		if($cnt==0){
			echo '<div class="alert alert-danger">No Messages!</div>';
		}
		while($row=mysqli_fetch_array($result)){
		// if($row['show_teacher']==1){
		echo '<div class="panel panel-info">
		  <div class="panel-heading">';
		echo $row['student']; 
		echo '<a href="javascript:DoPost('.$row['id'].')"><span class="righticon"><i class="glyphicon glyphicon-trash"></i></span></a>	</div>
		  <div class="panel-body">';
		echo $row['time']." : ".$row['message'];
		echo '</div>
		</div>';
	// }

	}

		?>

		</div>
      </div>
    </div>
  </div>
</div>
	
<!-- 	<div class="borderround" >
		
		<br>

		<br>
	
	</div>
 --></div>
</div>
<br>
<?php

//see http://php.net/manual/en/function.call-user-func-array.php how to use extensively
if(isset($_GET['result'])){
	echo '<div class="alert alert-success">The details are successfully ';
	if($_GET['result']==1){
		echo 'added';
	}
	else{
		echo 'edited';
	}
	echo '</div>';
}

else if(isset($_POST['date']) && isset($_POST['course'])){

	$date=$_POST['date'];
	$course=$_POST['course'];	

if($_POST['submit_delete']=='Delete This Class'){
	
	$sql="SELECT * FROM `".$_POST['course']."` WHERE `id`=".mysqli_real_escape_string($link,$_POST['class_id']);
	$rslt=mysqli_query($link, $sql);
	$row_last=mysqli_fetch_array($rslt);
	$query = "SELECT COLUMN_NAME
	FROM INFORMATION_SCHEMA.COLUMNS
	WHERE table_name = '".mysqli_real_escape_string($link,$_POST['course'])."' AND column_name LIKE '2%' ORDER BY column_name";
	$result = mysqli_query($link,$query);
	while($row = mysqli_fetch_array($result)){
		$value=$row['COLUMN_NAME'];
		if($row_last[$value]!=0){
	$qry="INSERT INTO `alert` (`from`, `to`, `class`, `course`, `student`, `attendance_date`, `teacher`) 
			VALUES ('".$row_last[$value]."', '0', '".$_POST['class_no']."', '".$_POST['course']."', '".$value."', '".$_POST['date']."', '".$_SESSION['email']."')";
			mysqli_query($link, $qry);
		}
	}
	$qry="DELETE FROM `".$_POST['course']."` WHERE `id`=".mysqli_real_escape_string($link,$_POST['class_id']);
	mysqli_query($link, $qry);
}
$qu="SELECT * FROM ".$course."
WHERE date = '".mysqli_real_escape_string($link,$date)."'";
// .$date.";
$res_first = mysqli_query($link,$qu);
$rows=mysqli_num_rows($res_first);
$res_first = mysqli_query($link,$qu);
if($rows==0){$found=0;}else{$found=1;}

if($_POST['submit_new']=='Add New Class' OR $found==0){
	$new=1;
}
else{
	$new=0;
}
 

 $_SESSION['new']=$new;
// print_r($new);
 $_SESSION['course']=$course;
 $_SESSION['date']=$date;
$loop_cnt=1;

if($new==0){
 	
 	echo '<i style="color: red">The class is already present in the database! However, you can edit the details, if required.</i><br>';
 }
 else{
 	
 	echo '<i style="color: green">This is a new class. Please tick the boxes corresponding to present students to add this date\'s attendance.</i><br>';
 }
 echo "<h3>Course : ".$_POST['course']."<br><br>Date : ".$_POST['date']."</h3>";
 if($new==0){
 echo ' <br><form action="teacher_dashboard.php" method="POST">
 
 	<input type="hidden" name="course" value="'.$_POST['course'].'"/>
 	<input type="hidden" name="date" value="'.$_POST['date'].'"/>
 <input type="submit" name="submit_new" class="btn btn-success btn-bg margintop an" value="Add New Class" />
 </form>';
}
 while($loop_cnt<=$rows OR $new==1){
 	if($new==0){
 		$change_row=mysqli_fetch_array($res_first);
 		$class=$loop_cnt;
 	}
 	else{
 		$class=$rows+1;
 	}

	echo "<h3><br>Class : ".$class."</h3><br>";
if(!$new){
 	echo '<form action="teacher_dashboard.php" method="POST">
 	<input type="hidden" name="course" value="'.$_POST['course'].'"/>
 	<input type="hidden" name="date" value="'.$_POST['date'].'"/>
 	<input type="hidden" name="class_id" value="'.$change_row["id"].'"/>
 	<input type="hidden" name="class_no" value="'.$class.'"/>
 	<input type="submit" name="submit_delete" class="btn btn-danger btn-bg margintop an" value="Delete This Class" onclick="return confirm(`Are you sure you want to delete this attendance?`)" />
 
  </form>';
}
	$sql = "SELECT COLUMN_NAME
FROM INFORMATION_SCHEMA.COLUMNS
WHERE table_name = '".mysqli_real_escape_string($link,$_POST['course'])."' AND column_name LIKE '2%' ORDER BY column_name";
$result = mysqli_query($link,$sql);
echo '<form method="post" action="update.php"><table class=table table-bordered>
    <thead>
      <tr>
        <th style="text-align: center">Entry No</th>
        <th style="text-align: center">Name</th>
        <th style="text-align: center">Attendance</th>
      </tr>
    </thead>
    <tbody>
    ';
while($row = mysqli_fetch_array($result)){
$value=$row['COLUMN_NAME'];
$query="SELECT name
FROM `master_student`
WHERE entryno='".mysqli_real_escape_string($link,$value)."'
LIMIT 0 , 30";
$res = mysqli_query($link,$query);
$name=mysqli_fetch_array($res);
echo '<tr><td>'.$value.'</td><td>'.$name["name"].'</td><td><input type="hidden" name='.$value.' value=0 /><input type="checkbox" name='.$value.' value=1 ';

if($new==0){
$qu="SELECT ".$value."
 AS attendance FROM ".$course."
WHERE date = '".mysqli_real_escape_string($link,$date)."' AND id = ".mysqli_real_escape_string($link,$change_row["id"]);
// .$date.";
$resu = mysqli_query($link,$qu);
$att=mysqli_fetch_array($resu);

if($att['attendance']==1)
	echo ' checked';
}
echo '></td></tr>';
}
echo '</tbody>
  </table>';
  if($new==0)
  	echo '<input type="hidden" name="class_id" value="'.$change_row["id"].'"/>';
  echo '<input type="hidden" name="class_no" value="'.$class.'"/>';
echo '<input type="submit" name="submit" class="btn btn-success btn-bg margintop an" value="Update Attendance" onclick="return confirm(`Are you sure you want to update attendance?`)" />
  </form>';
if($new==1)
	break;
$loop_cnt+=1;
}
}
?>
</div>
<script>
$(function () {
  $("#datepicker").datepicker({ 
        autoclose: true, 
        todayHighlight: true
  }).datepicker('update', new Date());;
});

$('#collapseOne').collapse("hide");

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
   		if ($('#oldpassword').val().length!=0) {
   		$('#message1').hide();
   		$('#message2').show();
   		$('#changepassword').prop('disabled', false);	   		
	   	}
	   } else  {

    	$('#message2').hide();
    	$('#message1').show();
   		$('#changepassword').prop('disabled', true);
    }
    // $('#message').html('not matching').css('color', 'red');
});
// var q="<?php echo (isset($_GET['changepass']))?$_GET['changepass']:'';?>";
if ($('#confirmpassword').val().length==0 || $('#newpassword').val().length==0 || $('#oldpassword').val().length==0 || $('#newpassword').val().length<8)
{
	   		$('#changepassword').prop('disabled', true);

}

function DoPost(id){
	$.post("teacher_dashboard.php", { delete: id});
	location.reload();
}

 
</script>
</body>
</html>
