<?php

include '../includes/define.php';
$mode = $_GET['mode'];
unset($_GET['mode']);
switch ($mode) {
    case "prepayment":
        $data = array_merge($_POST, json_decode(file_get_contents('php://input'), true));
        $_POST = $data[0];
        if ((isset($_POST)) && (!empty($_POST))) {
            $today = date("Y-m-d H:i:s");
            $_POST['addedon'] = $today;
            $arr['driver_id'] = $_POST['driver_id'];
            $arr['vehicle_id'] = $_POST['vehicle_id'];
            $arr['booking_id'] = $_POST['booking_id'];
			$objConnect->dbConnect();
            $result = $objConnect->selectWhere('booking', "id=" . $_POST['booking_id']);
            $row = $objConnect->fetch_assoc();
			$objConnect->dbConnect();
            $result1 = $objConnect->selectWhere('booking_short', "id=" . $_POST['booking_id']);
            $row1 = $objConnect->fetch_assoc();
            $output['status'] = "200";
            $output['result'][0]['data']['distance_km'] = (string) $row['distance_km'];
            $output['result'][0]['data']['fare'] = (string) $row['total_fare'];
            $output['result'][0]['data']['waiting_time'] = (string) $row1['wait_time'];
            $output['result'][0]['data']['waiting_time_charge'] = (string) $row1['waiting_time_charge'];
            $output['result'][0]['data']['total_duration'] = (string) $row['total_duration'];
            $output['result'][0]['data']['total_fare'] = (string) ($output['result'][0]['data']['fare'] + $output['result'][0]['data']['waiting_time_charge']);
            foreach ($output['result'][0]['data'] as $key => $value) {
                if (empty($output['result'][0]['data'][$key])) {
                    $output['result'][0]['data'][$key] = "0";
                }
            }
            $output['message'] = "Payment Details";
            print(json_encode($output));
        } else {
            $output['status'] = "500";
            $output['message'] = "No Data Recieved in Request";
            print(json_encode($output));
        }
        break;
    case "payment":
        $data = array_merge($_POST, json_decode(file_get_contents('php://input'), true));
        $_POST = $data[0];
        if ((isset($_POST)) && (!empty($_POST))) {
            $today = date("Y-m-d H:i:s");
            $booking_id = $_POST['booking_id'];
            $arr['addedon'] = $today;
            $arr['booking_id'] = $_POST['booking_id'];
            $arr['wait_time'] = $_POST['wait_time'];
            $arr['trip_time'] = $_POST['trip_time'];
            $arr['trip_distance'] = $_POST['trip_distance'];
            $arr['rate'] = $_POST['rate'];
            $arr['payment'] = $_POST['payment'];
			$objConnect->dbConnect();
            $result = $objConnect->insert('payment', $arr);
			$objConnect->dbConnect();
            $result1 = $objConnect->selectWhere('booking_short', "booking_id=$booking_id");
            $row1 = $objConnect->fetch_assoc();
            $brr['payment_type'] = "Prepayment";
            $brr['payment'] = $_POST['payment'];
            $brr['total_payment_amount']=$row1['total_payment_amount'];
            $brr['balance'] = $row1['balance'] + ($brr['total_payment_amount'] - $_POST['payment']);
			$objConnect->dbConnect();
            $result2 = $objConnect->update('booking_short', $brr, "booking_id=$booking_id");
            $output['status'] = "200";
            $output['message'] = "Payment Success ";
            print(json_encode($output));
        } else {
            $output['status'] = "500";
            $output['message'] = "No Data Recieved in Request";
            print(json_encode($output));
        }
        break;
    case "postpayment":
        $data = array_merge($_POST, json_decode(file_get_contents('php://input'), true));
        $_POST = $data[0];
        if ((isset($_POST)) && (!empty($_POST))) {
            $today = date("Y-m-d H:i:s");
            $booking_id = $_POST['booking_id'];
            $arr['addedon'] = $today;
            $arr['booking_id'] = $_POST['booking_id'];
            $arr['wait_time'] = $_POST['wait_time'];
            $arr['trip_time'] = $_POST['trip_time'];
            $arr['trip_distance'] = $_POST['trip_distance'];
            $arr['rate'] = $_POST['rate'];
            $arr['payment'] = $_POST['payment'];
			$objConnect->dbConnect();
            $result = $objConnect->insert('payment', $arr);
			$objConnect->dbConnect();
            $result1 = $objConnect->selectWhere('booking_short', "booking_id=$booking_id");
            $row1 = $objConnect->fetch_assoc();
            $brr['payment_type'] = "Postpayment";
            $brr['payment'] = $_POST['payment'];
            $brr['total_payment_amount']=$row1['total_payment_amount'];
            $brr['balance'] = $row1['balance']- $_POST['payment'];
			$objConnect->dbConnect();
            $result2 = $objConnect->update('booking_short', $brr, "booking_id=$booking_id");
            $x['status']=5;
			$objConnect->dbConnect();
        $result3 = $objConnect->update("booking", $x, "id=$booking_id ");
            $output['status'] = "200";
            $output['message'] = "Payment Success ";
            print(json_encode($output));
        } else {
            $output['status'] = "500";
            $output['message'] = "No Data Recieved in Request";
            print(json_encode($output));
        }
        break;
}
?>