<html>
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
<body>
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



<?php
include ('connection.php');
include ('function.php');
$id = $_GET['id'];
$query = "SELECT * FROM issues WHERE issueid = '$id'";
$query1 = mysqli_query($connection,$query);
$query2 = mysqli_fetch_array($query1);

 $lat = $query2['location_latitude'];
 $lng = $query2['location_longitude'];
 $in = "SELECT city,province,country FROM world_cities_table ORDER BY ABS( lat - '$lat') + ABS( lng -'$lng')";
 $in1=mysqli_query($connection,$in);
 $in2=mysqli_fetch_array($in1);
?>

<div class="row" style="margin-top:15px;">
   <div class="col-sm-6" style="text-align:center;">
        <table  class="table-hover table-responsive table-striped table-condensed" style="margin-bottom:5%; border:1px solid grey;width:97%;margin-left:15px;margin-right:15px;"">
			<tbody>
			 <tr>
			    <td style="text-align:center; ">ID</td>
			    <td style="text-align:center; "><?php echo $query2['issueid'];?></td>
			 </tr>
			 <tr>
			    <td style="text-align:center; ">Type</td>
			    <td style="text-align:center; "><?php echo $query2['type'];?></td>
			 </tr>
			 <tr>
			    <td style="text-align:center; ">Date / Time</td>
			    <td style="text-align:center; "><?php echo $query2['date_time'];?></td>
			 </tr>
			 <tr>
			    <td style="text-align:center; "">City</td>
			    <td style="text-align:center; "><?php echo $in2['city'];?></td>
			 </tr>
			 <tr>
			    <td style="text-align:center; "">State</td>
			    <td style="text-align:center; "><?php echo $in2['province'];?></td>
			 </tr>
			 <tr>
			    <td style="text-align:center; ">Country</td>
			    <td style="text-align:center; "><?php echo $in2['country'];?></td>
			 </tr>
			 <tr>
			    <td style="text-align:center; ">Status(0:Not Completed, 1:Completed)</td>
			    <td style="text-align:center; "><?php echo $query2['status'];?></td>
			 </tr>
			 <tr>
			    <td style="text-align:center; ">Image</td>
			    <td style="text-align:center; "><img src ="<?php echo $query2['image'];?>" width="200"></td>
			 </tr>
			<tbody>
		</table>
  <h2 style="margin-left:15px;">UPDATE STATUS</h2>
      <form action="update.php?id=<?php echo $id;?>" method="POST" style="margin-left:15px;">
        <select name="status" class="main">
          <option value="0">Not Completed</option>
          <option value="1">Completed</option>
        </select></br></br>
        <input class="main" type="submit" name="submit" value="Submit"/>
     </form>
 	
   </div>
   <div class="col-sm-6">
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
		<div style="overflow:hidden;height:500px;width:600px;">
		    <div id="gmap_canvas" style="height:500px;width:600px;">
			   <style>#gmap_canvas img{max-width:none!important;background:none!important}</style>
			   <a class="google-map-code" href="http://www.map-embed.com" id="get-map-data">embed google map</a>
			</div>
		<script type="text/javascript"> function init_map(){
			var myOptions = {
				zoom:14,
				center:new google.maps.LatLng(<?php echo $lat; ?>,<?php echo $lng;  ?>),
				mapTypeId: google.maps.MapTypeId.ROADMAP};
				map = new google.maps.Map(document.getElementById("gmap_canvas"), myOptions);
				marker = new google.maps.Marker({map: map,position: new google.maps.LatLng(<?php echo $lat; ?>,<?php echo $lng;  ?>)});
				infowindow = new google.maps.InfoWindow({
					            content:"<b>Type:</b><?php echo $query2['type'];?><br/><b>City:</b><?php echo $in2['city']?><br/><b>State:</b><?php echo $in2['province']?><br/><b>Country:</b><?php echo $in2['country']?>" 
								});
				google.maps.event.addListener(marker, "click", function(){
					   infowindow.open(map,marker);
					            });
				infowindow.open(map,marker);}google.maps.event.addDomListener(window, 'load', init_map);
		</script>
   </div>
</div>
</body>
</html>