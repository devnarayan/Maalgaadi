<?php
include '../includes/define.php';
$latitude1 = $_GET['latitude'];
$longitude1 = $_GET['longitude'];
$search= "order by location.addedon";
if((isset($_GET['vehicle'])&&(!empty($_GET['vehicle'])))&&($_GET['vehicle']!="undefined")){
 $vehicle =$_GET['vehicle'];   
 //$search="vehicle_category.id=$vehicle";
    $search="order by case when vehicle_category.id = $vehicle then 0 else 1 end, vehicle_category.id";
}

$today=date("Y-m-d H:i:s", strtotime("-3 min"));
$sql = "select vehicle.id,location.latitute,location.longitude,location.addedon as addedon,vehicle_category.id as categoryid,vehicle.name,vehicle.registration_no,vehicle.category from location,vehicle,vehicle_category,login where login.vehicle_id=vehicle.id and login.status= 1 and location.latitute!='0.0' and location.status like 'free' and vehicle.category like vehicle_category.name and location.addedon>='$today' and   vehicle.id=location.vehicle_id group by vehicle.id $search   ";
    //echo $sql;
$result = $objConnect->execute($sql);
$location = array();
while ($row = mysql_fetch_assoc($result)) {
    $latitude = $row['latitute'];
    $longitude = $row['longitude'];
    $pickup_latitude = $latitude1;
    $pickup_longitude = $longitude1;
    $dLat = deg2rad($latitude - $pickup_latitude);
    $dLon = deg2rad($longitude - $pickup_longitude);
    $dLat1 = deg2rad($pickup_longitude);
    $dLat2 = deg2rad($longitude);
    $a = sin($dLat / 2) * sin($dLat / 2) + cos($dLat1 / 2) * cos($dLat1 / 2) * sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $d = 6371000 * $c;
    $row['distance']=$d;
    $location[] = $row;
}
print_r(json_encode($location));
?>