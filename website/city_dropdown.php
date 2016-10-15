<?php
include('connection.php');
$state=$_GET["cid"];
$sql="SELECT id,province,city FROM world_cities_table WHERE province='$state' GROUP BY city";
$sql1=mysqli_query($connection,$sql);
if(mysqli_num_rows($sql1))
{
	$data=array();
	while($row=mysqli_fetch_array($sql1)){
		$data[]=array(
		'id'=>$row['id'],
		'name'=>$row['city']
		);
	}
	header('Content-type:application/json');
	echo json_encode($data);
}


?>