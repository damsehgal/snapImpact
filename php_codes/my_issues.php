<?php
	include_once 'dbconnect.php';
	$userid = $_POST['userid'];
	$query = "SELECT * FROM `issues` where userid = '$userid'";
	if ($result=mysqli_query($con,$query))
    {
        while ($row = mysqli_fetch_assoc($result))
        {
            $jsonObj[] = $row;
        }
    }
    print json_encode($jsonObj);

?>