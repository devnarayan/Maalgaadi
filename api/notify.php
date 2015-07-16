<?php
include '../includes/define.php';
include_once './GCM.php';
$email = $_GET['email'];
$data['result'][0]['data'] = "location is not recieving";
$message = json_encode($data);
$objConnect->dbConnect();
$result3 = $objConnect->selectWhere("vehicle", "email like '$email'");
$objConnect->dbConnect();
$num3=$objConnect->total_rows();
if($num3){
$row3 = $objConnect->fetch_assoc();
$regId = $row3["device_token"];
$gcm = new GCM();
$registatoin_ids = array($regId);
$message = array("location" => $message);
$result = $gcm->send_notification($registatoin_ids, $message);

}
else{
    echo "NO driver with email";
}
?>
