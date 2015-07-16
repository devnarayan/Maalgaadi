<?php
include '../includes/define.php';
$booking_id = $_POST['booking_id'];
$result = $objConnect->selectWhere("booking", "id=$booking_id and status=33");
$num = $objConnect->total_rows();
if ($num) {
    $row = $objConnect->fetch_assoc();
    $result1 = $objConnect->selectWhere("vehicle", "id=" . $row['vehicle_id']);
    $row1 = $objConnect->fetch_assoc();
    include_once '../api/GCM.php';
    $gcm = new GCM();
    $registatoin_ids = array($row1['device_token']);
    $message = array("cancel" => $booking_id);
    $result = $gcm->send_notification($registatoin_ids, $message);
//    $arr['status']=34;
//    $result2=$objConnect->update('booking',$arr,"id=$booking_id");
    echo "Success";
} else {
    echo "Booking not in breakdown";
}