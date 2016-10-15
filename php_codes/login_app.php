<?php
include_once 'dbconnect.php';
session_start();
$email = $_POST['email'];
$password = $_POST['password'];
$res = mysqli_query($con,"SELECT * FROM user WHERE email='$email' and password = '$password'");
	mysqli_store_result($con);
	if(mysqli_num_rows($res) == 0)
	{
		echo "-1";
	}
	else
	{
		$row = mysqli_fetch_array($res,MYSQLI_NUM);
		echo $row[0];
	} 
?>
