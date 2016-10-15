<?php
include_once 'dbconnect.php';
$ftp_server = "snapimpact.esy.es";
$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
$login = ftp_login($ftp_conn, "u233855366", "localhost");
$userid = $_GET['userid'];
$uploads_dir = "/home/u233855366/public_html/images/".$userid."/";
if (!file_exists($uploads_dir)) 
{
    mkdir($uploads_dir, 0777, true);
}
if (is_uploaded_file($_FILES['bill']['tmp_name'])) 
{
	$tmp_name = $_FILES['bill']['tmp_name'];
	$pic_name = $_FILES['bill']['name'];
	move_uploaded_file($tmp_name, $uploads_dir.$pic_name);
	echo $tmp_name;
	echo $pic_name;
}
ftp_close($ftp_conn);
?>