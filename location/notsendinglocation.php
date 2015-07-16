<?php
include '../includes/define.php';
$today = date("Y-m-d H:i:s", strtotime("-3 min"));
// $sql = "select login.login_time,location.batterystatus,location.addedon,vehicle.mobile_no,vehicle.id,location.status,vehicle_category.name as category,vehicle.name,vehicle.registration_no,location.latitute,location.longitude from login inner join vehicle on vehicle.id=login.vehicle_id inner join vehicle_category on vehicle_category.name like vehicle.category left join location on location.vehicle_id=vehicle.id and location.addedon>='$today' where login.status=1 group by vehicle.id order by vehicle.id, location.addedon desc ";


$sql = "SELECT DISTINCT vehicle.id, login.login_time, vehicle.mobile_no, vehicle.category, vehicle.name, vehicle.registration_no, a.batterystatus, a.addedon, a.status, a.latitute, a.longitude
FROM login, vehicle, (
SELECT location.vehicle_id, location.batterystatus, location.status, location.latitute, location.longitude, MAX( location.addedon ) addedon
FROM location
WHERE location.addedon >=  '$today'
GROUP BY location.vehicle_id
)a
WHERE login.status =1
AND login.vehicle_id = vehicle.id
AND a.vehicle_id = vehicle.id";

$result = $objConnect->execute($sql);
$location = array();
while ($row = mysql_fetch_assoc($result)) {
    if ($row['status'] == "") {
        $location[] = $row;
        ?>
        <li class="show_logs_li1">
            <div class="show_tag1"> 
                <div class="show_logcontent1"><?php echo $row['category'] . ", " . $row['registration_no'] . "<br/>"; ?>Vehicle has not sent location for more then 3 min<br>Mobile No<?php echo $row['mobile_no']; ?>&nbsp; login: <?php echo $row['login_time']; ?>
                    <input type="button" onclick="notifydriver(<?php echo $row['id'];?>)" value="Notify" class="btn btn-danger"></div>
            </div>
        </li>
        <?php
    }
    elseif ($row['batterystatus'] <= 20 ) {
        $location[] = $row;
        ?>
        <li class="show_logs_li1 redbg">
            <div class="show_tag1"> 
                <div class="show_logcontent1"><?php echo $row['category'] . ", " . $row['registration_no'] . "<br/>"; ?>Vehicle's Battery is less then 20% <br>Mobile No<?php echo $row['mobile_no']; ?>&nbsp; Battery: <?php echo $row['batterystatus']; ?>%</div>
            </div>
        </li>
        <?php
    }
}
?>


