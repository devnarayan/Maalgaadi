<?php include '../includes/define.php';
 include './GCM.php';
$data = array_merge($_POST, json_decode(file_get_contents('php://input'), true));
$_POST = $data[0];
if ((isset($_POST)) && (!empty($_POST))) {
	$objConnect->dbConnect();
     $result = $objConnect->selectWhere('vehicle', "id = '" . $_POST['vehicle_id'] . "' and (driver1_id='".$_POST['driver_id']."' or driver2_id='".$_POST['driver_id']."')");
	 $objConnect->dbConnect();
    $num = $objConnect->total_rows();
    if ($num) {
        $vehicle=$_POST['vehicle_id'];
        $today=date("Y-m-d");
		$objConnect->dbConnect();
 $select="select * from logout where vehicle_id='".$_POST['vehicle_id']."' and date(datetime)='$today' and status=1  group by booking_id limit 0,1";
         $res= mysql_query($select) or die(mysql_error());
         while($rowes=  mysql_fetch_assoc($res)){
             //$row = mysql_fetch_assoc($result);
             
             $row2=$rowes;
             $booking_id=$rowes['booking_id'];
			 $objConnect->dbConnect();
             $sql2="select * from booking where id='$booking_id' and status =93";
             $result2=  mysql_query($sql2) or die(mysql_error());
            while($row2 = mysql_fetch_assoc($result2)){
            $row2['pickup_name'] = $row2['pick_up_name'];
            $row2['pickup_number'] = $row2['pick_up_no'];
            $row2['pickup_organization'] = $row2['pick_up_organization'];
			$objConnect->dbConnect();
            $result3 = $objConnect->selectWhere("vehicle", "id='$vehicle'");
            $row3 = $objConnect->fetch_assoc();
            $regId = $row3["device_token"];
			$objConnect->dbConnect();
            $result4=$objConnect->selectWhere('logout',"booking_id=$booking_id and status=1 order by datetime desc");
            $row4=$objConnect->fetch_assoc();
            $row2['re_distance']=$row4['trip_distance'];
            $row2['re_time']=$row4['trip_time'];
            $row2['booking_reassign']="true";
            $data1['result'][0]['data'] = $row2;
            $message = json_encode($data1);
            $gcm = new GCM();
            $registatoin_ids = array($regId);
            $message = array("booking" => $message);
            
           $result = $gcm->send_notification($registatoin_ids, $message);
            $brr['booking_id'] =$booking_id;
            $brr['vehicle_id'] = $vehicle;
            $brr['added_on'] = date("Y-m-d H:i:s");
            $brr['status'] = 1;
			$objConnect->dbConnect();
            $objConnect->insert("alert", $brr);
            $crr['status'] = 0;
            
            $crr['closetime'] = date("Y-m-d H:i:s");
            $crr['vehicle_id']= $vehicle;
			$objConnect->dbConnect();
            $objConnect->update("notification", $crr, "booking_id=$booking_id and (booking_status=93) and status=1");
            }
         }
         $output['status'] = "200";
        $output['message'] = "Complete";
        print(json_encode($output));
         } else {
        $output['status'] = "404";
        $output['message'] = "Associated Vehicle and driver not match with the id";
        print(json_encode($output));
    }
} else {
    $output['status'] = "500";
    $output['message'] = "No Data Recieved in Request";
    print(json_encode($output));
}
?>