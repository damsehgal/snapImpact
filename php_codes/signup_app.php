<?php
include_once 'dbconnect.php';
session_start();
$phone = $_POST['phone'];
$email = $_POST['email'];
$name = $_POST['name'];
$password = $_POST['password'];
$age = $_POST['age'];
$city = $_POST['city'];
$state = $_POST['state'];
$country = $_POST['country'];
$res = mysqli_query($con,"SELECT * FROM user WHERE email='$email' OR phone ='$phone' ");
	mysqli_store_result($con);
	if(mysqli_num_rows($res) != 0)
		echo "-1";
	else
	{
		$sql = "INSERT INTO `u233855366_db`.`user` (`userid`, `phone`, `email`, `name`, `password`, `age`, `city`, `state`, `country`) VALUES (NULL, '$phone', '$email', '$name', '$password', '$age', '$city', '$state', '$country');";
		$res = mysqli_query($con,$sql);
		mysqli_store_result($con);
		echo "1";
	}
?>