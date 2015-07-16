<?php
include '../includes/define.php';
include '../api/GCM.php';
$mode=$_POST['mode'];
unset($_POST['mode']);
switch ($mode){
    case "details":
        $booking_id=$_POST['booking_id'];
        $vehicle_id=$_POST['vehicle_id'];
        $result1=$objConnect->selectWhere("booking","id=$booking_id and status=34");
        $num1=$objConnect->total_rows();
        if($num1){
        $result=$objConnect->selectWhere('reassigndetail',"vehicle_id=$vehicle_id and booking_id=$booking_id order by datetime desc");
        $num=$objConnect->total_rows();
      
            $row=$objConnect->fetch_assoc();
            print_r(json_encode($row));
        }
        else{
            echo "no";
        }
        break;
    case "assignToDriver":
        $vehicle = $_POST['driver_id'];
        $booking_id = $_POST['booking_id'];
        $sql = "select * from booking where id=$booking_id and (status<2 or status=33 or status=34)";
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
            $result4=$objConnect->selectWhere('reassigndetail',"booking_id=$booking_id order by datetime desc");
            $row4=$objConnect->fetch_assoc();
            $row2['re_driver_id']=$row4['driver_id'];
            $row2['re_vehicle_id']=$row4['vehicle_id'];
            $result5=$objConnect->selectWhere("driver","id=".$row4['driver_id']);
            $row5=$objConnect->fetch_assoc();
            $row2['re_driver_name']=$row5['name'];
            $result6=$objConnect->selectWhere("vehicle","id=".$row4['vehicle_id']);
            $row6=$objConnect->fetch_assoc();
            $row2['re_vehicle_info']=$row6['name'].",".$row6['registration_no'];
            $row2['re_vehicle_mobile']=$row6['mobile_no'];
            $row2['re_vehicle_current_address']=  getAddress($row4['latitute'], $row4['longitude']);
            $row2['re_distance']=$row4['trip_distance'];
            $crr['employee_id'] = $_SESSION['executive_id'];
            $objConnect->update("notification", $crr, "booking_id=$booking_id and (booking_status=33) and status=1");
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
            echo "Notification send to driver";
        } else {
            echo "Driver Already Assigned";
        }
        break;
}