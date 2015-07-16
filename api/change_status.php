<?php
include '../includes/define.php';
$data = array_merge($_POST, json_decode(file_get_contents('php://input'), true));
$_POST = $data[0];
if ((isset($_POST)) && (!empty($_POST))) {
    $_POST['datetime'] = changeFormat("d:M:Y:H:i:s", "Y-m-d H:i:s", $_POST['datetime']);
    $_POST['status'] = trim($_POST['status']);
    $output['status'] = "200";
    
    if ($_POST['status'] == "start to customer") {
        $arr['booking_id'] = $_POST['booking_id'];
        $booking_id = $_POST['booking_id'];
        $arr['status'] = 0;
		$objConnect->dbConnect();
        $result1 = $objConnect->selectWhere("booking", "id=$booking_id ");
        $row1 = $objConnect->fetch_assoc();
        $arr['booking_type'] = $row1['customer_category'];
        $arr['trip_distance'] = $row1['distance_km'];
        $arr['trip_time'] = $row1['total_duration'];
        $arr['total_payment_amount'] = $row1['total_fare'];
        $brr['status']=3;
		$objConnect->dbConnect();
        $result1 = $objConnect->update("booking", $brr,"id=$booking_id ");
		$objConnect->dbConnect();
        $result = $objConnect->insert('booking_short', $arr);
    } elseif ($_POST['status'] == "reached to customer") {
        $booking_id = $_POST['booking_id'];
        $x['pickup_lat'] = $_POST['current_latitude'];
        $x['pickup_lng'] = $_POST['current_longitude'];
		$objConnect->dbConnect();
        $result = $objConnect->update("booking", $x, "id=$booking_id ");
		$objConnect->dbConnect();
        $result = $objConnect->selectWhere("location", "booking_id=$booking_id and status like 'start to customer' order by addedon");
        $distance = 0;
        $i = 0;
        while ($row = $objConnect->fetch_assoc()) {
            if ($i == 0) {
                $start_lati = $row['latitute'];
                $start_longi = $row['longitude'];
            } else {
                $last_lati = $row['latitute'];
                $last_longi = $row['longitude'];
                $dLat = deg2rad($last_lati - $start_lati);
                $dLon = deg2rad($last_longi - $start_longi);
                $dLat1 = deg2rad($start_lati);
                $dLat2 = deg2rad($last_longi);
                $a = sin($dLat / 2) * sin($dLat / 2) + cos($dLat1 / 2) * cos($dLat1 / 2) * sin($dLon / 2) * sin($dLon / 2);
                $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                $d = 6378100 * $c;
                $distance = $distance + $d;
                $start_lati = $last_lati;
                $start_longi = $last_longi;
            }
            $i++;
        }
        $arr['distance_to_customer'] = $distance;
		$objConnect->dbConnect();
        $result = $objConnect->update('booking_short', $arr, "booking_id=$booking_id");
    } elseif ($_POST['status'] == "stop loading") {
        $booking_id = $_POST['booking_id'];
		$objConnect->dbConnect();
        $result = $objConnect->selectWhere("booking_logs", "booking_id=$booking_id and status like 'start loading'");
        $row = $objConnect->fetch_assoc();
        $starttime = $row['datetime'];

        $time_01 = strtotime($starttime);
        $time_02 = strtotime($_POST['datetime']);
        $total_seconds = 0;

        if ($time_01 > $time_02) {
            $total_seconds = (($time_01) - ($time_02));
        } else {
            $total_seconds = (($time_02) - ($time_01));
        }
        $minutes = $total_seconds / 60;
        $arr['loading_time'] = $minutes;
        $arr['wait_time'] = 0;
        $extraloading = 0;
        if (($arr['loading_time'] - 40) > 0) {
            $extraloading = $arr['loading_time'] - 40;
        }

        $arr['wait_time'] = $arr['wait_time'] + ($extraloading);
		$objConnect->dbConnect();
        $result = $objConnect->update('booking_short', $arr, "booking_id=$booking_id");
    } elseif ($_POST['status'] == "stop unloading") {
        $booking_id = $_POST['booking_id'];
		$objConnect->dbConnect();
        $result = $objConnect->selectWhere("booking_logs", "booking_id=$booking_id and status like 'start unloading'");
        $row = $objConnect->fetch_assoc();
        $starttime = $row['datetime'];

        $time_01 = strtotime($starttime);
        $time_02 = strtotime($_POST['datetime']);
        $total_seconds = 0;

        if ($time_01 > $time_02) {
            $total_seconds = (($time_01) - ($time_02));
        } else {
            $total_seconds = (($time_02) - ($time_01));
        }
        $minutes = $total_seconds / 60;
        $arr['wait_time'] = 0;
        $arr['unloading_time'] = $minutes;
        $extraunloading = 0;
        if (($arr['unloading_time'] - 40) > 0) {
            $extraunloading = $arr['unloading_time'] - 40;
        }

        $arr['wait_time'] = $arr['wait_time'] + ($extraunloading);
		$objConnect->dbConnect();
        $result2 = $objConnect->selectWhere("booking_short", "booking_id=$booking_id");
        $row2 = $objConnect->fetch_assoc();
        $arr['loading_time'] = $row2['loading_time'];
        $extraloading = 0;
        if (($arr['loading_time'] - 40) > 0) {
            $extraloading = $arr['loading_time'] - 40;
        }
        $arr['wait_time'] = $arr['wait_time'] + ($extraloading);
		$objConnect->dbConnect();
        $result5 = $objConnect->selectWhere("booking", "id=$booking_id");
        $row5 = $objConnect->fetch_assoc();
       
         $arr['total_payment_amount'] = $row2['trip_distance'] * $row5['rate'];
         if($arr['total_payment_amount']<$row5['model_minfare']){
             $arr['total_payment_amount']=$row5['model_minfare'];
         }
		 $objConnect->dbConnect();
        $result6 = $objConnect->selectWhere("vehicle_category", "id=" . $row5['vehicle']);
        $row6 = $objConnect->fetch_assoc();
        $arr['waiting_time_charge'] = $arr['wait_time'] * $row6['waiting_time_charge'];
        $arr['total_payment_amount'] = $arr['total_payment_amount'] + $arr['waiting_time_charge'];
        $arr['balance'] = $arr['total_payment_amount'] - $row2['payment'];
		$objConnect->dbConnect();
        $result7 = $objConnect->update('booking_short', $arr, "booking_id=$booking_id");
		$objConnect->dbConnect();
        $result8 = $objConnect->selectWhere('booking_short', "booking_id=$booking_id");
        $row8=$objConnect->fetch_assoc();
        $output['result'][0]['data']=$row8;
        
        
    } elseif ($_POST['status'] == "stop trip") {
        $booking_id = $_POST['booking_id'];
        $x['drop_lat'] = $_POST['current_latitude'];
        $x['drop_lng'] = $_POST['current_longitude'];
        $x['status']=4;
		$objConnect->dbConnect();
        $result3 = $objConnect->update("booking", $x, "id=$booking_id ");
		$objConnect->dbConnect();
        $result = $objConnect->selectWhere("location", "booking_id=$booking_id and status like 'start trip' order by addedon");
        $distance = 0;
        $i = 0;
        while ($row = $objConnect->fetch_assoc()) {
            if ($i == 0) {
                $start_lati = $row['latitute'];
                $start_longi = $row['longitude'];
            } else {
                $last_lati = $row['latitute'];
                $last_longi = $row['longitude'];
                $dLat = deg2rad($last_lati - $start_lati);
                $dLon = deg2rad($last_longi - $start_longi);
                $dLat1 = deg2rad($start_lati);
                $dLat2 = deg2rad($last_longi);
                $a = sin($dLat / 2) * sin($dLat / 2) + cos($dLat1 / 2) * cos($dLat1 / 2) * sin($dLon / 2) * sin($dLon / 2);
                $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                $d = 6378100 * $c;
                $distance = $distance + $d;
                $start_lati = $last_lati;
                $start_longi = $last_longi;
            }
        $i++;
        }
        $arr['trip_distance'] = $distance/1000;
		$objConnect->dbConnect();
        $result4 = $objConnect->selectWhere("booking_logs", "booking_id=$booking_id and status like 'start trip' order by datetime");
        $row4 = $objConnect->fetch_assoc();
        $starttime = $row4['datetime'];

        $time_01 = strtotime($starttime);
        $time_02 = strtotime($_POST['datetime']);
        $total_seconds = 0;

        if ($time_01 > $time_02) {
            $total_seconds = (($time_01) - ($time_02));
        } else {
            $total_seconds = (($time_02) - ($time_01));
        }
        $minutes = $total_seconds / 60;
        $arr['trip_time'] = $minutes;
		$objConnect->dbConnect();
        $result5 = $objConnect->selectWhere("booking", "id=$booking_id");
        $row5 = $objConnect->fetch_assoc();
        $arr['total_payment_amount'] = $arr['trip_distance'] * $row5['rate'];
		$objConnect->dbConnect();
        $result6 = $objConnect->selectWhere("vehicle_category", "id=" . $row5['vehicle']);
        $row6 = $objConnect->fetch_assoc();
		$objConnect->dbConnect();
        $result7 = $objConnect->selectWhere("booking_short", "booking_id=$booking_id ");
        $row7 = $objConnect->fetch_assoc();
        $arr['waiting_time_charge'] = $row7['wait_time'] * $row6['waiting_time_charge'];
        $arr['total_payment_amount'] = $arr['total_payment_amount'] + $arr['waiting_time_charge'];
        $arr['balance'] = $arr['total_payment_amount'] - $row7['payment'];
		$objConnect->dbConnect();
        $result2 = $objConnect->update('booking_short', $arr, "booking_id=$booking_id");
        
    }
elseif ($_POST['status'] == "complete booking") {
        $booking_id = $_POST['booking_id'];
        
        $x['status']=7;
		$objConnect->dbConnect();
        $result3 = $objConnect->update("booking", $x, "id=$booking_id ");
      //  echo $_POST['status'];
        
    }
	$objConnect->dbConnect();
    $result1 = $objConnect->insert('booking_logs', $_POST);
    $output['message'] = "Status Updated";
    print(json_encode($output));
} else {
    $output['status'] = "500";
    $output['message'] = "No Data Recieved in Request";
    print(json_encode($output));
}
?>