<?php
include_once 'dbconnect.php';
$type = $_POST['type'];
$location_latitude = $_POST['location_latitude'];
$location_longitude = $_POST['location_longitude'];
$status = false;
$userid = $_POST['userid'];
$name = $_POST['name'];
$age = $_POST['age'];
$image = $_POST['image'];

$query = "SELECT * FROM ngo WHERE field = '$type' ORDER BY ABS('$location_latitude' - location_latitude) + ABS('$location_longitude' - location_longitude)";
$res = mysqli_query($con,$query); 
mysqli_store_result($con);
$row = mysqli_fetch_array($res,MYSQLI_NUM);
$ans = $row['0'];
echo $ans;
$sql = "INSERT INTO `u233855366_db`.`issues` (`issueid`, `type`, `location_latitude`, `location_longitude`, `status`, `userid`, `ngoid`, `date_time`, `name`, `age`, `image`) VALUES (NULL, '$type','$location_latitude', '$location_longitude', '0','$userid', '$ans', NULL, '$name', '$age', '$image');";
$res = mysqli_query($con,$sql); 
mysqli_store_result($con);

?>
