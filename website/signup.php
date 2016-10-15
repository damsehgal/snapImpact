<?php
include ('connection.php');
include ('function.php'); 
if(isset($_POST['submit']))
{	
  $hos_name=$_POST['ngoname'];
  $city= $_POST['city'];
  $state = $_POST['state'];
  $country = $_POST['country'];
  $hosregno=$_POST['regno'];
  $password=$_POST['password'];
  $field=$_POST['field'];
  $phone=$_POST['phone'];

   $latlan="SELECT city,lat,lng FROM world_cities_table WHERE city='$city'";
   $q=mysqli_query($connection,$latlan);
   $qq=mysqli_fetch_assoc($q);

   $lat=$qq['lat'];
   $lng=$qq['lng']; 


	 $result="INSERT INTO ngo(name,city,state,country,location_latitude ,location_longitude,ngo_register_id,password,phone,field)
                     VALUES('$hos_name','$city','$state','$country','$lat','$lng','$hosregno','$password','$phone','$field');";
	 $retval=mysqli_query($connection,$result);	
     header('location:login.php');	 
}
?>
<html lan="en">
	<head>
		<meta charset="utf-8"/>
		<title>Signup - SmartCities</title>
		<link rel="icon" type="image/png" href="images/logo.png" />
		<link rel="stylesheet" href="bootstrap.min.css">
		<link rel="stylesheet" href="style.css">
		<link rel="stylesheet" href="style1.css">
		<link href="https://fonts.googleapis.com/css?family=PT+Sans:400" rel="stylesheet">
		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" ></script>
		<meta name="viewport" content="width=device-width, initial-scale=1.0/>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
 
                <script>
	   function Country()
	   {
		  $('#countrydd1').empty();
		  $('#countrydd1').append("<option>Loading.....</option>");
		  $('#statedd1').append("<option value='0'>Select State</option>");
		  $('#citydd1').append("<option value='0'>Select City</option>");
		  $.ajax({
			  type:"POST",
			  url:"country_dropdown.php",
			  contentType:"application/json; charset=utf-8",
			  dataType:"json",
			  success: function(data){
				  $('#countrydd1').empty();
				  $('#countrydd1').append("<option value='0'>Select Country</option>");
				  $.each(data,function(i,item){
					  $('#countrydd1').append('<option value="'+ data[i].name +'">'+ data[i].name+'</option>');
					  
				  });
			  },
			  complete:function(){
				  
			  }
			  
		  });
	   }
	 
	      function State(sid){
		  $('#statedd1').empty();
		  $('#statedd1').append("<option>Loading.....</option>");
		  $.ajax({
			  type:"POST",
			  url:"state_dropdown.php?sid="+sid,
			  contentType:"application/json; charset=utf-8",
			  dataType:"json",
			  success: function(data){
				  $('#statedd1').empty();
				  $('#statedd1').append("<option value='0'>Select State</option>");
				  $.each(data,function(i,item){
					  $('#statedd1').append('<option value="'+ data[i].name +'">'+ data[i].name+'</option>');
					  
				  });
			  },
			  complete:function(){
				  
			  }
			  
		  });
		  }
		  
		  function District(cid){
		  $('#citydd1').empty();
		  $('#citydd1').append("<option>Loading.....</option>");
		  $.ajax({
			  type:"POST",
			  url:"city_dropdown.php?cid="+cid,
			  contentType:"application/json; charset=utf-8",
			  dataType:"json",
			  success: function(data){
				  $('#citydd1').empty();
				  $('#citydd1').append("<option value='0'>Select City</option>");
				  $.each(data,function(i,item){
					  $('#citydd1').append('<option value="'+ data[i].name +'">'+ data[i].name+'</option>');
					  
				  });
			  },
			  complete:function(){
				  
			  }
			  
		  });
		  }
		  
		 
		  
		  $(document).ready(function(){
			  Country();
			  $('#countrydd1').change(function(){
				  var countryid=$('#countrydd1 option:selected').text();
				  State(countryid);
			  });
			  
			  $('#statedd1').change(function(){
				  var stateid=$('#statedd1 option:selected').text();
				  District(stateid);
			  });
			  
		  });
	 </script>
		
</head>
<body style="background-color:#91cfe7;">
<!--nav-bar-start-->
	<?php
	include ('navbarTop.php');
	?>
<!--nav-bar-ends-->
<div class="formback row">
    <img src="logo.png" class="logo">
	<p style="margin-top:15px;">Sign up and be a part of revolution! </p>
	<form method="POST" action="signup.php">
		  <input type="text" name="ngoname" placeholder="NGO Name" class="main" required /><br><br>
		  <input type="text" name="phone" placeholder="Phone Number" class="main" required /><br><br>
		  <input type="text" name="regno" placeholder="Registration Number" class="main" required /><br><br>
		  <select name="country" id="countrydd1" type="text" class="main" required></select><br><br>
	          <select name="state" id="statedd1" type="text" class="main" required></select><br><br>
	          <select name="city" id="citydd1" type="text" class="main" required></select><br><br>
		  <select name="field" class="main">
			  <option value="Road Patholes">Road Patholes</option>
			  <option value="Garbage Issues">Garbage Issues</option>
			  <option value="Food Collection">Food Collection</option>
		  </select><br><br>
		  <input type="password" name="password" placeholder="Password" class="main" required /><br><br>
		  <input type="submit" name="submit" value="Sign up to SmartCities" class="button">
	</form>
	<p>By clicking "Sign up" I agree to SmartCities <a href="#"><span style="color:#52B3D9;">Terms of Service</span></a></p>
    <p>Already have an account?  <a href="login.php"><span style="color:#52B3D9;">Log in!</span></a></p>
</div>
</body>
</html>