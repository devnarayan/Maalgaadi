<?php session_start();
ob_start();
date_default_timezone_set('Asia/Kolkata');
include_once("class/class.connect.php"); 
include 'common_functions.php';
error_reporting(0);
ini_set('error_reporting', 0);
//$_SESSION['executive_id']=1;
$objConnect=new connect;
//define("BASE_URL",'http://maalgaadi.net/newTest/newTestLi/');
//define("BASE_PATH",'http://maalgaadi.net/newTest/newTestLi/');


define("BASE_URL",'http://base3.engineerbabu.com/maalgaadi_server_test/');
define("BASE_PATH",'http://base3.engineerbabu.com/maalgaadi_server_test/');

define("IMAGE_URL",BASE_URL."images/");
define("IMAGE_LOC",BASE_PATH."images/");

?>