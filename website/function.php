<?php
function hospital_exists($hosregno,$connection)
{
	$result=mysqli_query($connection,"SELECT ngoid FROM ngo WHERE ngo_register_id='$hosregno' ");
	if(mysqli_num_rows($result)==1)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function logged_in()
{
	if(isset($_SESSION['hid']))
	{
		return true;
	}
	else
	{
		return false;
	}
}
?>