<?php
date_default_timezone_set('Asia/Kolkata');
include_once("class/class.connect.php"); 
include 'common_functions.php';
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL^E_DEPRECATED);
//$_SESSION['executive_id']=1;
$objConnect=new connect;
define("BASE_URL",'http://base3.engineerbabu.com/maalgaadi_server_test/');
define("BASE_PATH",'http://base3.engineerbabu.com/maalgaadi_server_test/');

define("IMAGE_URL",BASE_URL."images/");
define("IMAGE_LOC",BASE_PATH."images/");



?>