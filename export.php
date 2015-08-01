<?php
	
	session_start();
if(!isset($_SESSION['id'])){
	header("Location:index.php");
}

?>

<?php
	include("connection.php");
	$sql="SELECT `date` FROM `".$_GET['course']."` WHERE 1";
	$result=mysqli_query($link, $sql);
	$totalClasses=mysqli_num_rows($result);
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
WHERE table_name = '".$_GET['course']."' AND column_name LIKE '2%' ORDER BY column_name";
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
	$sql2="SELECT `date` FROM `".$_GET['course']."` WHERE 1";
 	$result2=mysqli_query($link, $sql2);
 	while($row2=mysqli_fetch_array($result2)){
	
 		$date=$row2['date'];
 	    $sql1="SELECT `".$entryno."` FROM `".$_GET['course']."` WHERE `date`='".$date."'";
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
	$file=$_GET['course'].".xls";
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$file");
	echo $table;
	//header("Location: view_attendance.php");
?>