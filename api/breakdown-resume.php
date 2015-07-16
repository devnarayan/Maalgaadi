<?php
include '../includes/define.php';
$data = array_merge($_POST, json_decode(file_get_contents('php://input'), true));
$_POST = $data[0];
if ((isset($_POST)) && (!empty($_POST))) {
    
    $_POST['datetime'] = changeFormat("d:M:Y:H:i:s", "Y-m-d H:i:s", $_POST['datetime']);
//    $arr['status'] = 0;
//    $result2 = $objConnect->update('vehicle', $arr, "id=" . $_POST['vehicle_id']);
    $booking_id = trim($_POST['booking_id']);
    if ($booking_id != "") {
        $vehicle_id=$_POST['vehicle_id'];
        $crr['status'] = 0;
		$objConnect->dbConnect();
        $objConnect->update("notification", $crr,"booking_status=33 and booking_id=$booking_id and vehicle_id=$vehicle_id and status=1");
        $arr['status'] = 2;
		$objConnect->dbConnect();
        $objConnect->update("booking", $arr, "id=$booking_id");
		$objConnect->dbConnect();
        $result1 = $objConnect->update('breakdown', $crr,"booking_id=$booking_id and status=1 and vehicle_id=$vehicle_id");
        $output['status'] = "200";
        $output['message'] = "Booking Resumed";
        print(json_encode($output));
    }
    
} else {
    $output['status'] = "500";
    $output['message'] = "No Data Recieved in Request";
    print(json_encode($output));
}