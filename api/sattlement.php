<?php

include '../includes/define.php';
$data = array_merge($_POST, json_decode(file_get_contents('php://input'), true));
$_POST = $data[0];
if ((isset($_POST)) && (!empty($_POST))) {
    $vehicle_id = $_POST['vehicle_id'];
	$objConnect->dbConnect();
    $sql="select min(date) as start_date,max(date) as end_date, sum(amount_payable) as remaining from settlement where vehicle_id='$vehicle_id' and status=0";
    $result=  mysql_query($sql) or die(mysql_error());
    $row=  mysql_fetch_assoc($result);
	$objConnect->dbConnect();
    $sql1="select * from driver_payment where vehicle_id='$vehicle_id' order by payment_date desc limit 1";
    $result1=  mysql_query($sql1) or die(mysql_error());
    $row1=  mysql_fetch_assoc($result1);
    $output['status'] = "200";
   $output['result'][0]['data']['remaining']=$row['remaining'];
    $output['result'][0]['data']['last_payment_date']=$row1['payment_date'];
    $output['result'][0]['data']['end_date']=$row['end_date'];
    $output['result'][0]['data']['start_date']=$row['start_date'];
    $output['message'] = "Settlement detail";
    print(json_encode($output));
} else {
    $output['status'] = "500";
    $output['message'] = "No Data Recieved in Request";
    print(json_encode($output));
}
?>