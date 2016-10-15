<?php
session_start();
include ('connection.php');
include ('function.php'); 
?>
<html lan="en">
	<head>
		<meta charset="utf-8"/>
		<title>Dashboard - SmartCities</title>
		<link rel="stylesheet" href="bootstrap.min.css">
		<link rel="stylesheet" href="style.css">
		<link rel="stylesheet" href="style1.css">		
		<link href="https://fonts.googleapis.com/css?family=PT+Sans:400" rel="stylesheet">
		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" ></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		
		
</head>
<body >
<!--nav-bar-start-->
<nav class="navbar navbar-inverse no-margin" style="margin-bottom: 0px;">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
	  <img alt="Brand" src="logo.png" style="width: 145px;height: 24px;margin-top: 14px;margin-right: 65px;">
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		   <ul class="nav navbar-nav navbar-right">
              <li class="cir"><a href="logout.php"  style="bottom:15px;">Logout</a></li>
           </ul>
    </div>
  </div>
</nav>
<!--nav-bar-ends-->
<div class="row">
<p style="margin-top:15px;">Response Details</p>
    <?php
	 $ng = $_SESSION["hregno"];
	 $info = "SELECT * FROM issues WHERE ngoid = '$ng'";
	 $info1 = mysqli_query($connection,$info);
	 $count = mysqli_num_rows($info1);
	 if($count > 0)
	 {

           ?>

<table  class="table-hover table-responsive table-striped table-condensed" style="margin-bottom:5%; border:1px solid grey;width:97%;margin-left:15px;margin-right:15px;">
							   <thead style="background-color:black;">
							     <tr>
								    <th style="text-align:center;padding:0; color:white; border:1px solid black;">Id</th>
								    <th style="text-align:center;color:white; border:1px solid black;">Type</th>
								    <th style="text-align:center;color:white; border:1px solid black;">Date/Time</th>
								    <th style="text-align:center;color:white; border:1px solid black;">City</th>
								    <th style="text-align:center;color:white; border:1px solid black;">State</th>
								    <th style="text-align:center;color:white; border:1px solid black;">Country</th>
								    <th style="text-align:center;color:white; border:1px solid black;">Status</th>
                                                                    <th style="text-align:center;color:white; border:1px solid black;">View</th>
								 </tr>
							   </thead>
							   <tbody>

           <?php
	  while($row = mysqli_fetch_array($info1))
	  {	  
                $lat = $row['location_latitude'];
		$lng = $row['location_longitude'];
                $in = " SELECT * FROM world_cities_table ORDER BY ABS( lat-'$lat')+ ABS(lng-'$lng') ";
                $in1=mysqli_query($connection,$in);
                $in2 = mysqli_fetch_array($in1);
        
                $abc=urlencode($row['issueid']);
     
		?>
                <tr height="100">
			<td style="width:90px; text-align:center;"><?php echo $row['issueid'];?></td>
			<td style="width:90px; text-align:center;"><?php echo $row['type'];?></td>
			<td style="width:90px; text-align:center;"><?php echo $row['date_time'];?></td>
			<td style="width:90px; text-align:center;"><?php echo $in2['city'];?></td>
			<td style="width:90px; text-align:center;"><?php echo $in2['province'];?></td>
			<td style="width:90px;text-align:center;"><?php echo $in2['country'];?></td>
			<td style="width:90px;text-align:center;"><?php echo $row['status'];?></td>
                        <td style="width:90px;text-align:center;"><a href = "comdetails.php?id=<?php echo $abc; ?>"> View </a></td>
		 </tr>

        <?	
      }		
	 }
	 else
	 {
		?>
          <div class="jumbotron text-center" style="padding-top:112px;padding-bottom:112px;" >
				<h1>NO COMPLAINT IN YOUR AREA.</h1>			
			</div>
        <?php		
	 }
?>
</div>
</body>
</html>