<?php
include ('connection.php');
include ('function.php');
if(isset($_POST['submit'])){
$opt = $_POST['status'];
$id=$_GET['id'];
$e = "UPDATE issues SET status = '$opt' WHERE issueid= '$id'";

if (mysqli_query($connection, $e)) {
    header('location:http://snapimpact.esy.es/website/comdetails.php?id='.$id);
} else {
    echo "Error updating record: " . mysqli_error($connection);
}

}
 
?>