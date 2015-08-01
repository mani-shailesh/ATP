<?php
include("connection.php");
$sql="SELECT * FROM `roll_list` WHERE '1'";
$result=mysqli_query($link, $sql);
while($row=mysqli_fetch_array($result)){
$add_query="CREATE TABLE IF NOT EXISTS `".$row['course']."` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,";
$str = $row['students'];
$students=explode(",",$str);
foreach ($students as $entry_no){
	$entry_no=trim($entry_no);
  $add_query.="`".$entry_no."` int(11) NOT NULL DEFAULT '0',";
 }
  $add_query.="PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1" ;

mysqli_query($link, $add_query);
$add_query="CREATE TABLE IF NOT EXISTS `alert` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student` text NOT NULL,
  `teacher` text NOT NULL,
  `course` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `attendance_date` date NOT NULL,
  `show_student` int(11) NOT NULL DEFAULT '1',
  `class` int(11) NOT NULL DEFAULT '1',
  `from` int(11) NOT NULL DEFAULT '1',
  `to` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
mysqli_query($link, $add_query);
$add_query="CREATE TABLE IF NOT EXISTS `master_student` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `courses` text,
  `com_code` text,
  `entryno` text NOT NULL,
  `forgot_code` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
mysqli_query($link, $add_query);

$add_query="CREATE TABLE IF NOT EXISTS `master_teacher` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `courses` text,
  `com_code` text,
  `forgot_code` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
mysqli_query($link, $add_query);

$add_query="CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `teacher` text NOT NULL,
  `student` text NOT NULL,
  `message` text NOT NULL,
  `show_teacher` tinyint(1) NOT NULL DEFAULT '1',
  `show_student` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
mysqli_query($link, $add_query);


}
?>