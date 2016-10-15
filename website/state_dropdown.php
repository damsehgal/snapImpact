<?php
include('connection.php');
$country=$_GET["sid"];
$sql="SELECT id,province,country FROM world_cities_table WHERE country='$country' GROUP BY province";
$sql1=mysqli_query($connection,$sql);
if(mysqli_num_rows($sql1))
{
	$data=array();
	while($row=mysqli_fetch_array($sql1)){
		$data[]=array(
		'id'=>$row['id'],
		'name'=>$row['province']
		);
	}
	header('Content-type:application/json');
	echo json_encode($data);
}


?>