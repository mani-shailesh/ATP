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
 <h4>Please select course to view full attendance of that course</h4>
  <hr> 
 </div>
<div class="container">
<div class="row">
<div class="col-md-4 col-md-offset-4 am" id="toprow">
 <form class="margintop" method="get" action="view_attendance.php">
					<label for="category"></label>
					<div class="input-group">
						
						<span class="input-group-addon">Course</span>
						 <select id="cat" type="course" name="course" class="form-control" >
							<option value="" selected disabled style="display:none;">Select Course</option>
							<?php

								include("connection.php");
								$query="SELECT courses
								FROM `master_teacher`
								WHERE id='".mysqli_real_escape_string($link,$_SESSION['id'])." '
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
					<br>
					<input type="submit" name="submit" class="btn btn-success btn-bg margintop an" value="View Attendance" />
				</form>  
				<hr>
				<br>
</div>
</div>
</div>
<?php

if(isset($_GET['course'])){
	$sql="SELECT * FROM `".mysqli_real_escape_string($link,$_GET['course'])."` WHERE 1 ORDER BY date";
	$result=mysqli_query($link, $sql);
	$totalClasses=mysqli_num_rows($result);
	echo '<div class="container">
	<div class="row">
	<h4>Total classes taken : '.$totalClasses.'</h5><hr>
	<div class="col-md-2 col-md-offset-10">';
	$table = '<table class="table table-striped">
    <thead>
      <tr>
      <th style="text-align:center">Entry Number</th>
      <th style="text-align:center">Name</th>
      <th style="text-align:center">Percentage Attendance</th>';
        
	while($row=mysqli_fetch_array($result)){
		$date=date_create($row['date']);
		$new_date=date_format($date,"M j, Y");
		$table.= '<th class="rotate"><div><span>'.$new_date.'</span></div></th>';
		//echo '<th class="vertical_text">'.$row['date'].'</th>';
	}
	$table.= '
      </tr>
    </thead>
    <tbody>';
    


$sql = "SELECT COLUMN_NAME
FROM INFORMATION_SCHEMA.COLUMNS
WHERE table_name = '".mysqli_real_escape_string($link,$_GET['course'])."' AND column_name LIKE '2%' ORDER BY column_name";
$result = mysqli_query($link,$sql);
 while($row = mysqli_fetch_array($result)){
 	$entryno=$row['COLUMN_NAME'];
 	
 	$query="SELECT name
	FROM `master_student`
	WHERE entryno='".$entryno."'
	LIMIT 0 , 30";
	$res = mysqli_query($link,$query);
	$name=mysqli_fetch_array($res);
	
	$resultx = mysqli_query($link, "SELECT SUM(".$entryno.") AS value_sum FROM ".$_GET['course']); 
	$rowx = mysqli_fetch_assoc($resultx); 
	$sum = $rowx['value_sum'];
	$percent=($sum/$totalClasses)*100;
	$percent=round($percent, 2);
	if($percent<=75){
		$red="color:red";
	}
	else
	{
		$red="";
	}
	$table.= '<tr><td style="text-align:center;'.$red.'">'.$entryno.'</td>';
	$table.= '<td style="text-align:center;'.$red.'">'.$name['name'].'</td>';
	$table.= '<td style="text-align:center;'.$red.'">'.$percent.'&#37;</td>';
	$sql2="SELECT * FROM `".mysqli_real_escape_string($link,$_GET['course'])."` WHERE 1";
 	$result2=mysqli_query($link, $sql2);
 	while($row2=mysqli_fetch_array($result2)){
	
 		$class_id=$row2['id'];
 	    $sql1="SELECT `".$entryno."` FROM `".$_GET['course']."` WHERE `id`=".mysqli_real_escape_string($link,$class_id);
 		$result1=mysqli_query($link, $sql1);
 		$row1=mysqli_fetch_array($result1);
		$table.= '<td ';
		if($row1[$entryno]==1){
			$table.= ' style="text-align:left; color: green">';
			$table.= '&nbsp &#x2713;';
		}
		else{
			$table.= ' style="text-align:left; color: red">';
			$table.= '&nbsp &#x2717;';
		}
 		$table.= '</td>';	

 	}
 	$table.= '</tr>';
 }

    $table.= '
    </tbody>
  </table>';
  echo '<a href="export.php?course='.$_GET['course'].'"><button class="btn btn-success">Export to Excel</button></a>
	</div>
	</div>
	</div>';
	
  echo $table;

//$test="<table  ><tr><td>Cell 1</td><td>Cell 2</td></tr></table>";
//echo $table;
}

?>
</body>
</html>