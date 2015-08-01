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
  <script src="js/jquery-2.1.3.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <style type="text/css">
	.container{
		text-align: center;
	}
/*	.red:hover{
		background-color: red;
	}
*/
	.red{
    color: red;
}
.borderround {
	border:1px solid #DEDEDE;
	border-radius: 10px;

}
.righticon {
	float: right;
	
}
.smallfont {
	font-size: .8em;
}
.navbar{
	position: relative;
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
	tr.red:hover {
		color: red;
	}
	th.rotate {
  /* Something you can count on */
  height: 140px;
  white-space: nowrap;
}

th.rotate > div {
  transform: 
    /* Magic Numbers */
    
    /* 45 is really 360 - 45 */
    rotate(270deg);
  width: 30px;
}
th.rotate > div > span {
  border-bottom: 1px solid #ccc;
  padding: 15px 10px;
}
.clearicon {
	float:right;
	margin-right: 20px;
	
}	
.borderbottom {
margin: 0;
}
  </style>
</head>

<body>
	<div class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header pull-left">
			<div class="navbar-brand"><a href="student_dashboard.php" class="linknone">ATP</a><a href="http://www.iitrpr.ac.in/" target="blank"><img class="logoimg" src="img/iitrpr.png" width="30px" height="30px"></a></div>
			
		</div>
		<div class="pull-right">
			<ul class="navbar-nav nav">
			<li><a href="logout.php">Log Out</a></li>
			</ul>
			
		</div>
	</div>
	</div>

<?php 

	include("connection.php");
	$query="SELECT courses
FROM `master_student`
WHERE id='".mysqli_real_escape_string($link,$_SESSION['id'])."'
LIMIT 0 , 30";
	$result=mysqli_query($link,$query);
	$row=mysqli_fetch_array($result);
function findCourses($str) {
    return explode(",",$str);
}
$courses=findCourses($row['courses']);
?>
<div class="container">
	<?php

		echo '<h2>Hi, '.$_SESSION['name'].'! Welcome to Attendance Tracking Portal of IIT Ropar</h2>';

	?>
	<br>






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






<br>
<br><br>

 <!--  <h2>Your Attendance</h2> -->
  <div class="row">
  	<div class="col-md-5">
  <div class="borderround" >
		<h2 class="borderbottom alert alert-success">Inbox<a href="javascript:DoPost(0)"><button class="btn btn-sm btn-danger clearicon">Clear All</button></a></h2>
		<div style="overflow:auto;overflow-y: scroll;height: 180px;">
		<?php

		if(isset($_POST['delete'])){
			if($_POST['delete']==0){
				$sql="SELECT * FROM `message` WHERE `student`='".mysqli_real_escape_string($link,$_SESSION['entryno'])."'";
				$result=mysqli_query($link, $sql);
				while($row=mysqli_fetch_array($result)){
					if($row['show_teacher']==1){
						$sql="UPDATE `message` SET `show_student`='0' WHERE `id`='".mysqli_real_escape_string($link,$row['id'])."'";		
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
				if($row['show_teacher']==1){
					$sql="UPDATE `message` SET `show_student`='0' WHERE `id`='".mysqli_real_escape_string($link,$_POST['delete'])."'";
				}
				else{
					$sql="DELETE FROM `message` WHERE `id`='".mysqli_real_escape_string($link,$_POST['delete'])."'";
				}
				mysqli_query($link, $sql);
			}
		}
		$sql="SELECT * FROM `message` WHERE `student`='".mysqli_real_escape_string($link,$_SESSION['entryno'])."' AND `show_student`='1' ORDER BY `time` DESC";
		$result=mysqli_query($link, $sql);
		$cnt=mysqli_num_rows($result);
		if($cnt==0){
			echo '<br><div class="alert alert-danger">No Messages!</div>';
		}
		echo '<br>';
		while($row=mysqli_fetch_array($result)){
		// if($row['show_teacher']==1){
		echo '
		<div class="panel panel-info">
		  <div class="panel-heading">';
		$query="SELECT `name` FROM `master_teacher` WHERE `email`='".mysqli_real_escape_string($link,$row['teacher'])."'";
		$res=mysqli_query($link, $query);
		$r=mysqli_fetch_array($res);
		echo $r['name']; 
		echo '<br><span class="smallfont"><a href="'.$row['teacher'].'">'.$row['teacher'].'</a></span><a href="javascript:DoPost('.$row['id'].')"><span class="righticon"><i class="glyphicon glyphicon-trash"></i></span></a>	</div>
		  
		  <div class="panel-body">';
		  $date=date_create($row['time']);
		$new_date=date_format($date,"M j, Y - H:i");
		echo $new_date." : ".$row['message'];
		echo '</div>
		</div>
		';
	// }

	}

		
		

		?>
</div>
	</div>
	</div>
<div class="col-md-5 col-md-offset-2">
		<div class="borderround" >
		<h2 class="borderbottom alert alert-success">Attendance Alerts<a href="javascript:DoPostAlert(0)"><button class="btn btn-sm btn-danger clearicon">Clear All</button></a></h2>
		<div style="overflow:auto;overflow-y: scroll;height: 180px;">
	


	<?php
		if(isset($_POST['alertdelete'])){
			if($_POST['alertdelete']==0){
				$sql="SELECT * FROM `alert` WHERE `student`='".mysqli_real_escape_string($link,$_SESSION['entryno'])."'";
				$result=mysqli_query($link, $sql);
				while($row=mysqli_fetch_array($result)){
						$sql="UPDATE `alert` SET `show_student`='0' WHERE `id`=".mysqli_real_escape_string($link,$row['id']);		
				   mysqli_query($link, $sql);	
				}
			}
			else{
				$sql="UPDATE `alert` SET `show_student`='0' WHERE `id`=".mysqli_real_escape_string($link,$_POST['alertdelete']);
				mysqli_query($link, $sql);
			}
		}

		$sql="SELECT * FROM `alert` WHERE `student`='".mysqli_real_escape_string($link,$_SESSION['entryno'])."' AND `show_student`='1' ORDER BY `time` DESC";
		$result=mysqli_query($link, $sql);
		$cnt=mysqli_num_rows($result);
		if($cnt==0){
			echo '<br><div class="alert alert-danger">No New Alerts!</div>';
		}
		echo '<br>';
		while($row=mysqli_fetch_array($result)){
		// if($row['show_teacher']==1){
		echo '
		<div class="alert alert-info">';
		$query="SELECT `name` FROM `master_teacher` WHERE `email`='".mysqli_real_escape_string($link,$row['teacher'])."'";
		$res=mysqli_query($link, $query);
		$r=mysqli_fetch_array($res);
		echo '<a style="float:right" href="javascript:DoPostAlert('.$row['id'].')">X</a>';
		  $date=date_create($row['time']);
		$new_date=date_format($date,"M j, Y - H:i");
		// echo '<a href="javascript:DoPostAlert('.$row['id'].')" class="close" data-dismiss="alert">&times;</a>';
		 echo $new_date; 
		echo '<br>';  
		$date=date_create($row['attendance_date']);
		$new_date=date_format($date,"M j, Y");
		echo $r['name'].' changed your attendance of '.$row['course'].' on '.$new_date.' in class '.$row['class']
		.' from ';
		if($row['from']==1)
			echo 'Present';
		else
			echo 'Absent';
		echo ' to ';

		if($row['to']==1)
			echo 'Present';
		else
			echo 'Absent';
		echo '</div>';
	// }
	}	?>


	</div>
</div>
</div>
	
</div>
	<br><br>
	 <h4>Please click on any row to see complete details of that course:</h4>
 
<br>

  <hr>            
  <table class="table table-hover">
    <thead>
      <tr>
        <th style="text-align: center">Course</th>
        <th style="text-align: center">Total Classes</th>
        <th style="text-align: center">Classes Attended</th>
        <th style="text-align: center">Percentage Attendance</th>
      </tr>
    </thead>
    <tbody>
    	<?php
    	$cnt1=0;
    	foreach ($courses as $value)
    	{	$cnt1+=1;
    		$result = mysqli_query($link, "SELECT * FROM ".$value);
    		$totalClasses = mysqli_num_rows($result);
    		$result = mysqli_query($link, "SELECT SUM(".$_SESSION['entryno'].") AS value_sum FROM ".$value); 
			$row = mysqli_fetch_assoc($result); 
			$sum = $row['value_sum'];
			$percent=($sum/$totalClasses)*100;
			$percent=round($percent, 2);
    		echo "<tr ";
    		if($percent<=75){
    			echo 'class="red"';
    		}
    		echo "data-toggle=collapse data-target=#accordion".$cnt1." class=clickable><td>".$value."</td><td>".$totalClasses."</td><td>".$sum."</td><td>".$percent."%</td></tr>";
    		echo "<tr>
        <td colspan=3>
            <div id=accordion".$cnt1." class=collapse><table class=table table-bordered>
    <thead>
      <tr>";
      $query="SELECT date FROM ".$value." ORDER BY date";
	$result=mysqli_query($link,$query);
	while($row=mysqli_fetch_array($result)){
		$date=date_create($row['date']);
		$new_date=date_format($date,"M j, Y");
		echo '<th class="rotate"><div><span>'.$new_date.'</span></div></th>';
		// echo "<th style=".'"text-align: center"'. ">".$row['date']."</th>";
	};
      echo "</tr>
    </thead>
    <tbody><tr>";
      $query="SELECT ".$_SESSION['entryno']." FROM ".$value." ORDER BY date";
	$result=mysqli_query($link,$query);
	while($row=mysqli_fetch_array($result)){
		echo '<td ';
		if($row[$_SESSION['entryno']]==1){
			echo ' style="text-align:left;color: green">';
			echo '&nbsp &#x2713;';
		}
		else{
			echo ' style="text-align:left;color: red">';
			echo '&nbsp &#x2717;';
		}
 		echo '</td>';	
		// if($row[$_SESSION['entryno']]==0)
		// {
		// 	$print='Absent';
		// }
		// else
		// {
		// 	$print='Present';
		// }
		// echo "<td>".$print."</td>";
	};

  echo "</tr></table></div>
        </td>
    </tr>";
    	}

    	?>
    </tbody>
  </table>
</div>
<script>
function DoPost(id){
	$.post("student_dashboard.php", { delete: id});
	location.reload();
}
function DoPostAlert(id){
	$.post("student_dashboard.php", { alertdelete: id});
	location.reload();
}

</script>
</body>
</html>


