<?php
include '../includes/define.php';
$data = array_merge($_POST, json_decode(file_get_contents('php://input'), true));
$_POST = $data[0];
if ((isset($_POST)) && (!empty($_POST))) {

    $output['status'] = "200";

    $_POST['datetime'] = changeFormat("d:M:Y:H:i:s", "Y-m-d H:i:s", $_POST['datetime']);
//    $arr['status'] = 0;
//    $result2 = $objConnect->update('vehicle', $arr, "id=" . $_POST['vehicle_id']);
    $booking_id = trim($_POST['booking_id']);
    $_POST['status'] = 1;
	$objConnect->dbConnect();
    $result1 = $objConnect->insert('breakdown', $_POST);
    if ($booking_id != "") {
        $crr['vehicle_id'] = $_POST['vehicle_id'];
       
        $crr['booking_id'] = $booking_id;
        $crr['booking_status'] = 33;
        $crr['addedon'] = date("Y-m-d h:i:s");
        $crr['status'] = 1;
		$objConnect->dbConnect();
        $objConnect->insert("notification", $crr);
        $arr['status'] = 33;
		$objConnect->dbConnect();
        $objConnect->update("booking", $arr, "id=$booking_id");
    }
    $output['message'] = "Request Submitted";
    print(json_encode($output));
} else {
    $output['status'] = "500";
    $output['message'] = "No Data Recieved in Request";
    print(json_encode($output));
}