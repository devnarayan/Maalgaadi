<?php

include '../includes/define.php';
include '../api/GCM.php';
$mode = $_POST['mode'];
unset($_POST['mode']);

switch ($mode) {
    case "assignEmployee":
        $employee_id = $_POST['employee_id'];
        $booking_id = $_POST['booking_id'];
        $booking = array();
        $booking['employee_assign_id'] = $employee_id;
        $booking['status'] = 1;
        $booking['last_updated'] = date("Y-m-d H:i:s");
        $objConnect->update("booking", $booking, " id='$booking_id'");
        $brr['status'] = 0;
        $brr['closer_id'] = $_SESSION['executive_id'];
        $brr['closetime'] = date("Y-m-d H:i:s");
        $objConnect->update("notification", $brr, "booking_id=$booking_id and (booking_status=0 || booking_status=1) and status=1");
        $crr['booking_id'] = $booking_id;
        $crr['booking_status'] = 1;
        $crr['employee_id'] = $_SESSION['executive_id'];
        $crr['addedon'] = date("Y-m-d h:i:s");
        $crr['status'] = 1;
        $objConnect->insert("notification", $crr);
        
        echo "reloadAssigned ";
        break;
    case "assignToDriver":
        $vehicle = $_POST['driver_id'];
        $booking_id = $_POST['booking_id'];
        $sql = "select * from booking where id=$booking_id and status<2";
        $result = $objConnect->execute($sql);
        $num = mysql_num_rows($result);
        if ($num) {
            $row = mysql_fetch_assoc($result);
            $row2 = $row;
            $row2['pickup_name'] = $row2['pick_up_name'];
            $row2['pickup_number'] = $row2['pick_up_no'];
            $row2['pickup_organization'] = $row2['pick_up_organization'];
            $result3 = $objConnect->selectWhere("vehicle", "id='$vehicle'");
            $row3 = $objConnect->fetch_assoc();
            $regId = $row3["device_token"];
            $data['result'][0]['data'] = $row2;
            $message = json_encode($data); 
            $gcm = new GCM();
            $registatoin_ids = array($regId);
            $message = array("booking" => $message);
            $result = $gcm->send_notification($registatoin_ids, $message);
            $brr['booking_id'] = $row['id'];
            $brr['vehicle_id'] = $vehicle;
            $brr['added_on'] = date("Y-m-d H:i:s");
            $brr['status'] = 1;
            $objConnect->insert("alert", $brr);
            $crr['status'] = 0;
            $crr['closer_id'] = $_SESSION['executive_id'];
            $crr['closetime'] = date("Y-m-d H:i:s");
            $crr['vehicle_id']= $vehicle;
            $objConnect->update("notification", $crr, "booking_id=$booking_id and (booking_status=1) and status=1");
            echo "redirect Notification send to driverURL".BASE_PATH;
        } else {
            echo "Driver Already Assigned";
        }
        break;
    case "acceptbooking":
        $employee_id = $_SESSION['executive_id'];
        $booking_id = $_POST['booking_id'];
        $booking = array();
        $booking['employee_assign_id'] = $employee_id;
        $booking['status'] = 1;
        $booking['last_updated'] = date("Y-m-d H:i:s");
        $objConnect->update("booking", $booking, " id='$booking_id'");
       
        $brr['status'] = 0;
        $brr['closer_id'] = $_SESSION['executive_id'];
        $brr['closetime'] = date("Y-m-d H:i:s");
        $objConnect->update("notification", $brr, "booking_id=$booking_id and (booking_status=0 || booking_status=1) and status=1");
         $crr['booking_id'] = $booking_id;
        $crr['booking_status'] = 1;
        $crr['employee_id'] = $_SESSION['executive_id'];
        $crr['addedon'] = date("Y-m-d h:i:s");
        $crr['status'] = 1;
        $objConnect->insert("notification", $crr);
        echo "redirect booking Accepted Please Assign Driver URL".BASE_PATH;;
        break;
}
?>