<?php
include '../includes/define1.php';
$result = $objConnect->selectWhere("vehicle", "status=1");
while ($row = mysql_fetch_assoc($result)) {
    
    $sql10 = "update `vehicle` set status=0 where id=" . $row['id'] ;
    $result10 = mysql_query($sql10) or die(mysql_error());
    if ($result10) {
        $today = date("d-m-Y H:i:s");
        $logouttime = date("Y-m-d 21:00:00", strtotime($today));
        $sql7 = "update login set logout_time='$logouttime', status=0 where vehicle_id=" . $row['id']." and status=1";
        $result7 = mysql_query($sql7) or die(mysql_error());
    }
}
$message=date("Y-m-d H:i:s");
$date=$message;
mail("mmfinfotech335@gmail.com","autologout ".$date,$message);
?>