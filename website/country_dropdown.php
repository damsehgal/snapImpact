<?php
include('connection.php');
$sql="SELECT country,id FROM world_cities_table GROUP BY country";
$sql1=mysqli_query($connection,$sql);
if(mysqli_num_rows($sql1))
{
	$data=array();
	while($row=mysqli_fetch_array($sql1)){
		$data[]=array(
		'id'=>$row['id'],
		'name'=>$row['country']
		);
	}
	header('Content-type: application/json');
	echo json_encode($data);
}


?>