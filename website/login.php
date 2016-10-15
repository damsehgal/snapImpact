<?php
session_start();
include ('connection.php');
include ('function.php'); 
$error=' ';
if(logged_in()){
	  header("location:patient.php");
	  exit();
  }
  
if(isset($_POST['submit']))
{	
  $hos_regno= $_POST['hregno'];
  $password= $_POST['password'];
  $retval=mysqli_query($connection,"SELECT password FROM ngo WHERE ngo_register_id='$hos_regno';");	  
	 $retrievepass = mysqli_fetch_assoc($retval);
			if($password === $retrievepass['password'])
			{
				$_SESSION["hregno"]=$hos_regno;
                     
				header("location:patient.php");
			}
			else
			{
		              $error='Password is incorrect.';
			}
}
?>
<html lan="en">
	<head>
		<meta charset="utf-8"/>
		<title>Login - SmartCities</title>
		<link rel="icon" type="image/png" href="logo.png" />

		<link rel="stylesheet" href="bootstrap.min.css">
		<link rel="stylesheet" href="style.css">
		<link rel="stylesheet" href="style1.css">
		<link href="https://fonts.googleapis.com/css?family=PT+Sans:400" rel="stylesheet">
		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" ></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0/>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body style="background-color:#91cfe7;" >
<!--nav-bar-start-->
	<?php
	include ('navbarTop.php');
	?>
<!--nav-bar-ends-->

<div class="formback row">
    <img src="logo.png" class="logo">
	<p style="margin-top:20px;">Login with NGO registration number to continue</p>
	<form method="post" action="login.php">
		  <br><input type="text" name="hregno" placeholder="NGO Registration Number" class="main" required /><br><br>
		  <br><input type="password" name="password" placeholder="Password" class="main" required /><br><br>
		  <input type="submit" name="submit" value="Log in to SmartCities >" class="button">
	</form>
	<div id="error_bar">          
		<?php     
		  echo $error       ;
		?>     
	</div>
	<p>Don't have an account?  <a href="signup.php"><span style="color:#52B3D9;">Get Started</span></a></p>
</div>
</body>
</html>