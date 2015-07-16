<?php
include '../includes/define.php';
$booking_id = $_GET['booking'];
$sql3 = "select location.latitute,location.longitude from location where booking_id=$booking_id and status='start trip'";

$result3 = $objConnect->execute($sql3);
$location3 = array();
while ($row3 = mysql_fetch_assoc($result3)) {
    $location3[]=$row3;
    } 
    print_r(json_encode($location3));
    ?>


