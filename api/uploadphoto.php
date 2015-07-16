<?php
include '../includes/define.php';
//print_r($_POST);
$data =  json_decode(file_get_contents('php://input'), true);
print_r($data);
$_POST = $data[0];
if ((isset($_POST)) && (!empty($_POST))) {
    $im = $_POST['vehicle_id'] . time();
	$objConnect->dbConnect();
    $file_name = $objConnect->insertImageApi($_POST['image'], $im, "../vehicleimage/");
    $_POST["image"] = $file_name;
    $_POST['addedon']=date("Y-m-d H:i:s");
	$objConnect->dbConnect();
    $objConnect->insert("photos", $_POST);
    $output['status'] = "200";
    $output['message'] = "Login Successfull";
    print(json_encode($output));
} else {
    $output['status'] = "500";
    $output['message'] = "No Data Recieved in Request";
    print(json_encode($output));
}
?>
