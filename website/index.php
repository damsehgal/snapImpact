<html lan="en">
  <head>
		<meta charset="utf-8"/>
		<title>Welcome to SmartCities</title>
		<link rel="icon" type="image/png" href="logo.png" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="stylesheet" href="bootstrap.min.css">
		<link href="https://fonts.googleapis.com/css?family=PT+Sans:400" rel="stylesheet">
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" ></script>
		<link rel="stylesheet" href="style.css">
  </head>
<body>
<!--nav-bar-start-->
	<?php
	   include ('navbarTop.php');
	?>
<!--nav-bar-ends-->

<!--map and side navigation-bar-starts-->
<div class="row" >
  <div class="col-md-2">
   <div class="panel-group" id="accordion">								
			 <div class="panel panel-default">
				<div class="panel-heading">									
					<div class="panel-title">
						<div data-toggle="collapse" data-parent="#accordion" href="#collapse1">Issues<span class="glyphicon glyphicon-chevron-down" style="float:right;font-size:10px;margin-top: 6px;" aria-hidden="true"></span></div>								
					</div>						  
				</div>
				<div id="collapse1" class="panel-collapse collapse in">
					<div class="panel-body" >
					    <ul class="list-group">
						   <li class="list-group-item active1"><a href="index.php">Road Patholes</a></li>
						   <li class="list-group-item"><a href="2.php">Food Collection</a></li>
                                                   <li class="list-group-item"><a href="3.php">Garbage Issues</a></li>
						</ul>
					</div>
				</div>			
			  </div> 
			 
			  
			  
						  
			 
			  
		

                <div class="panel panel-default">
				<div class="panel-heading">									
					<div class="panel-title">
						<div><a href="about.php">About Us</a></div>								
					</div>						  
				</div>	
			  </div> 			  
        </div>
  </div>
  <div class="col-md-10">
		
		<div id="map"></div>
   </div>	
	
</div>	
<h1 style="color:#52B3D9;text-align:center;margin-top:40px;margin-bottom:0px;">About Us</h1>
<div class="row" style="text-align:center; height:447px;">
  <div class="col-md-4" style="margin:30px;margin-left:186px;max-height:447px;padding:10px; width:300px;">
    <div class="thumbnail"> 
      <img class="img-responsive" src="logo.png" width="200">
        <div class="caption" >
          <h1 style="text-align:center;">What is it?</h1>
          <p style="text-align:justify;font-size:16px">The application enables citizens to report local problems such as potholes, food wastage, garbage on streets etc. The submitted issues are displayed on a map. Users may add photos. The application informs citizens about the progress on their submitted problem.</p>
         </div>
     </div>
  </div>

  <div class="col-md-4" style="margin:30px;max-height:447px;padding:10px;width:300px;">
    <div class="thumbnail"> 
      <img class=" img-responsive" src="logo.png" width="200">
        <div class="caption">
          <h1 style="text-align:center;">Who is it for?</h1>
          <p style="text-align:justify;font-size:16px;">Through the application local government agencies enable citizens to share and promote the places that make their city unique. Sharing what's great about the city in an easily accessible and visually compelling way will drive more residents to shop downtown.</p>
         </div>
     </div>
  </div>

  <div class="col-md-4" style="margin:30px;max-height:447px;padding:10px;width:300px;">
    <div class="thumbnail"> 
      <img class=" img-responsive" src="logo.png" width="200">
        <div class="caption">
          <h1 style="text-align:center;">Why choose it?</h1>
          <p style="text-align:justify;font-size:16px">It is a truly user-centered digital application, adapted to the needs Municipalities and local communities. Moreover, the source code of the application is available free as open source software.</p>
         </div>
     </div>
  </div>

</div>
<div class="row" style="background-color:#91cfe7;">
   <p style="text-align:right;color:white;font-size:15px;margin-top: 8px;margin-right: 16px;">Copyrights@ 2016. All Rights Reserved</p>

</div>
<!--map and side navigation-bar-ends-->
    <?php
	include ('connection.php');
        include ('function.php'); 
	$count="select count('issueid') from issues WHERE status='0'";
        $retval1=mysqli_query($connection,$count);
        $cc=mysqli_fetch_row($retval1);
        $alat=array();
        $alng=array();
        $query1="select world_cities_table.lat from world_cities_table, issues where issues.status='0' AND issues.type='Road Patholes' ORDER BY ABS(world_cities_table.lat-issues.location_latitude) + ABS (world_cities_table.lng-issues.location_longitude)";
        $query2="select world_cities_table.lng from world_cities_table, issues where issues.status='0' AND issues.type='Road Patholes' ORDER BY ABS(world_cities_table.lat-issues.location_latitude) + ABS (world_cities_table.lng-issues.location_longitude)";
        $result1=mysqli_query($connection, $query1);
        $result2=mysqli_query($connection, $query2);
$i=0;
while($row=mysqli_fetch_assoc($result1))
{
	$alat[]=$row['lat'];
	if($i==$cc[0])
		break;
	$i=$i+1;
}

$i=0;

while($row=mysqli_fetch_assoc($result2))
{
	$alng[]=$row['lng'];
	if($i==$cc[0])
		break;
	$i=$i+1;	
}
	?>
	
	
<script>
var map, heatmap;
var lat=<?php echo json_encode($alat);?>;
var lng=<?php echo json_encode($alng);?>;
var c='<?php echo $i;?>';
var j;

function initMap() {
  map = new google.maps.Map(document.getElementById('map'), {
    zoom: 3,
    center: {lat: 28.7041, lng: 77.1025},
    mapTypeId: google.maps.MapTypeId.MAP,
    streetViewControl: false,
	mapTypeControl: false,
	zoomControlOptions: {
        position: google.maps.ControlPosition.RIGHT_CENTER
    }
  });
 

 for(j=0;j<c;j++)
  {  
     heatmap = new google.maps.visualization.HeatmapLayer({ data: getPoints(),map: map});
  }
}

function getPoints() {
  return [
  new google.maps.LatLng(lat[j],lng[j]),
  ];
}
    </script>
                        

    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAPlDFb8ZNNM0z3HW2QmLJ6jZL4N2WfBNQ&signed_in=true&libraries=visualization&callback=initMap">
    </script>

</body>
</html>