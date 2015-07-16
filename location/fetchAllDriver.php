<?php
include '../includes/define.php';
$today=date("Y-m-d H:i:s", strtotime("-3 min"));
$sql="select vehicle.id,getCurrentDriver.latitute,getCurrentDriver.status,getCurrentDriver.longitude,getCurrentDriver.addedon as addedon,vehicle_category.id as categoryid,vehicle.name,vehicle.registration_no,vehicle.category,driver.name as drivername from getCurrentDriver , vehicle,vehicle_category,login,driver where vehicle.category = vehicle_category.name and getCurrentDriver.latitute!='0.0'  and  getCurrentDriver.addedon>='$today' and vehicle.id=getCurrentDriver.vehicle_id and login.vehicle_id=vehicle.id and login.status=1 and driver.id=login.driver_id  group by getCurrentDriver.vehicle_id order by getCurrentDriver.addedon ";
$result=$objConnect->execute($sql);
$location=array();
while ($row = mysql_fetch_assoc($result)) {
    $location[]=$row;
    //echo $row['latitute'].",".$row['longitude']."<br>";
}
print_r(json_encode($location));
?>
