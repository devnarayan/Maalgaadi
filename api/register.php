<?php

include '../includes/define.php';

$data = array_merge($_POST, json_decode(file_get_contents('php://input'), true));
$_POST = $data[0];
if ((isset($_POST)) && (!empty($_POST))) {
	$objConnect->dbConnect();
    $result = $objConnect->selectWhere('vehicle', "email like '" . $_POST['email'] . "'");
	$objConnect->dbConnect();
    $num = $objConnect->total_rows();
    $output['status'] = "200";
    if ($num) {
        $row = $objConnect->fetch_assoc();
        $arr['device_token']=$_POST['device_token'];
        //$arr['mobile_no']=$_POST['mobile_no'];
		$objConnect->dbConnect();
        $result5 = $objConnect->update('vehicle', $arr," id=".$row['id']);
        $output['result'][0]['vehicle'] = $row;
		$objConnect->dbConnect();
        $result3 = $objConnect->selectWhere('driver', "id='" . $row['driver1_id'] . "'");
        $row3 = $objConnect->fetch_assoc();
        $output['result'][0]['driver1'] = $row3;
		$objConnect->dbConnect();
        $result3 = $objConnect->selectWhere('driver', "id='" . $row['driver2_id'] . "'");
        $row4 = $objConnect->fetch_assoc();
        $output['result'][0]['driver2'] = $row4;
        $output['message'] = "Registration Updated";
        print(json_encode($output));
    } else {
        $output['status'] = "404";
        $output['message'] = "No Vehicle Found With tis email";
        print(json_encode($output));
    }
} else {
    $output['status'] = "500";
    $output['message'] = "No Data Recieved in Request";
    print(json_encode($output));
}
?>