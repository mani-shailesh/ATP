<?php
	include("login.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendance Tracking Portal</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNIhNG: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<style>
		.navbar-brand {
			font-size:1.8em;
		}
		#topcontainer {
			/*background-image:url("desktop.jpg");*/
			/*background-color: ;*/
			width:100%;
			background-size:cover;
		}
		.container {
			background-size:cover;
		}
		#toprow {
			margin-top:100px;
			text-align:center;
		}
		#toprow h1 {
			font-size:300%;
		}
		.bold {
			font-weight:bold;
		}
		.margintop {
			margin-top:30px;
			
		}
		.center {
			text-align:center;
		}
		.title {
			margin-top:100px;
			font-size:300%;
		}
		#footer {
			background-color:#4C9ED9;
			padding-top:70px;
			width:100%;
		}
		.marginbottom {
			margin-bottom:30px;
		}
		.android {
			width:250px;
		}
		.am {
			background-color:#F8F8F8;
			border-radius:10px;
		}
		.an {
			margin-bottom:10px;
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
	html {
  position: relative;
  min-height: 100%;
}
body {
  /* Margin bottom by footer height */
  margin-bottom: 60px;
}
.footer {
  position: absolute;
  bottom: 0;
  width: 100%;
  /* Set the fixed height of the footer here */
  height: 60px;
  background-color: #f5f5f5;
  text-align: center;
}

</style>
  </head>
 <body>
	<div class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<div class="navbar-brand"><a href="index.php" class="linknone">ATP</a><a href="http://www.iitrpr.ac.in/" target="blank"><img class="logoimg" src="img/iitrpr.png" width="30px" height="30px"></a></div>
			<button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<div class="collapse navbar-collapse">
			
			<form class="navbar-form navbar-right" method="post">
				<div class="form-group">
					<input type="email" name="loginemail" placeholder="Email" class="form-control" value="<?php echo addslashes($_POST['loginemail']); ?>"/>
				</div>
				<div class="form-group">
					<input type="password" name="loginpassword" placeholder="Password" class="form-control" value="<?php echo addslashes($_POST['loginpassword']); ?>"/>
				</div>
				<div class="form-group">
				<select type="category" name="category" class="form-control" value="<?php echo addslashes($_POST['category']); ?>">
							<option value="" selected disabled style="display:none;">Select Category</option>
  							<option value="teacher">Teacher</option>
							  <option value="student">Student</option>
						</select>
				</div>
				<a href="forgotpassword.php"> Forgot password?</a>
				<input type="submit" name="submit" class="btn btn-success " value="Log In"/>
			</form>
		</div>
	</div>
	</div>
	<div class="container contentcontainer" id="topcontainer">
		<class="row">
			<div class="col-md-6 col-md-offset-3 am" id="toprow">
				<h1 class="margintop">Attendance Tracking Portal</h1>
				<p class="lead">Indian Institute of Technology Ropar</p>
				
				<?php
					if ($error){
						echo '<div class="alert alert-danger">'.addslashes($error).'</div>';
					
					}
					if ($message){
						echo '<div class="alert alert-success">'.addslashes($message).'</div>';
					
					}
				?>
				
				
				<p class="bold margintop" >Not yet registered? Sign Up below!</p>
				<form class="margintop" method="post">
					<label for="name">Name</label>
					<div class="input-group">
						
						<span class="input-group-addon glyphicon glyphicon-user"></span>
						<input type="name" name="name" class="form-control" placeholder="Your Name" value="<?php echo addslashes($_POST['name']); ?>"/>
					</div>
					<label for="category">Category</label>
					<div class="input-group">
						
						<span class="input-group-addon glyphicon glyphicon-tag"></span>
						 <select id="cat" type="category" name="category" class="form-control" value="<?php echo addslashes($_POST['category']); ?>">
							<option value="" selected disabled style="display:none;">Select Category</option>
  							<option value="teacher">Teacher</option>
							  <option value="student">Student</option>
						</select> 
					</div>
					<div id="entry">
					<label for="entryno">Entry No</label>
					<div class="input-group">
						<span class="input-group-addon glyphicon glyphicon-list-alt"></span>
					<input type="text" name="entryno" placeholder="Entry No" class="form-control" value="<?php echo addslashes($_POST['entryno']); ?>"/>
				</div>
			</div>
					<label for="email">Email Address(@iitrpr.ac.in)</label>
					<div class="input-group">
						
						<span class="input-group-addon">&#64;</span>
						<input type="email" name="email" class="form-control" placeholder="Your Email" value="<?php echo addslashes($_POST['email']); ?>"/>
					</div>
					<label for="password">Password</label>
					<div class="input-group">
						<span class="input-group-addon glyphicon glyphicon-lock"></span>
						<input type="password" name="password" class="form-control" placeholder="Your Password" value="<?php echo addslashes($_POST['password']); ?>"/>
					</div>
					
					<input type="submit" name="submit" class="btn btn-success btn-bg margintop an" value="Sign Up" />
				</form>
			</div>
		</div>
	</div>
	<footer class="footer">
      <div class="container">
        <p class="text-muted">Design by: Anil Kumar, Utkarsh Singh Chauhan, Shailesh Mani Pandey,<br> Under guidance of: Dr. Nitin Auluck</p>
      </div>
    </footer>
	

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-2.1.3.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
	<script>
$(document).ready(function() {
  $('#cat').on('change.entry', function() {
    $("#entry").toggle($(this).val() == 'student');
  }).trigger('change.entry');
});
	//var windowheight=$(window).height();
	//$("#topcontainer").height(windowheight+"px");
	$(".contentcontainer").css("min-height",$(window).height());
	</script>

  </body>

</html>
