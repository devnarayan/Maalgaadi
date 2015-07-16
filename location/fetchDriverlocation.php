<?php
include '../includes/define.php';
$today=date("Y-m-d H:i:s", strtotime("-3 min"));
$sql="select vehicle.id,location.latitute,location.longitude,location.addedon as addedon,vehicle_category.id as categoryid,vehicle.name,vehicle.registration_no,vehicle.category from location,vehicle,vehicle_category where location.status like 'free' and vehicle.category like vehicle_category.name and location.latitute!='0.0' and  location.addedon>='$today' and vehicle.id=location.vehicle_id and vehicle.status=1 group by vehicle_id  order by location.addedon ";
$result=$objConnect->execute($sql);
$location=array();
while ($row = mysql_fetch_assoc($result)) {
    $location[]=$row;
    //echo $row['latitute'].",".$row['longitude']."<br>";
}


print_r(json_encode($location));
?>
