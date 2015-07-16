<?php
include '../includes/define.php';
$message=file_get_contents('php://input');
        $sql="insert into requests values('','$message','".date("Y-m-d h:i:s")."','logout',1)";
        mysql_query($sql) or die(mysql_error());
$data = array_merge($_POST, json_decode(file_get_contents('php://input'), true));
$_POST = $data[0];
if ((isset($_POST)) && (!empty($_POST))) {
	$objConnect->dbConnect();
    $result = $objConnect->selectWhere('vehicle', "id = '" . $_POST['vehicle_id'] . "' and (driver1_id='" . $_POST['driver_id'] . "' or driver2_id='" . $_POST['driver_id'] . "')");
	$objConnect->dbConnect();
    $num = $objConnect->total_rows();
    if ($num) {
        $today = date("Y-m-d H:i:s");
        $output['status'] = "200";
        $arr['status'] = 0;
        $arr['logout_latitute'] = $_POST['logout_latitute'];
        $arr['logout_longitude'] = $_POST['logout_longitude'];
        $arr['logout_time'] = $today;
        if(isset($_POST['distance'])){
           $arr['distance'] = $_POST['distance']; 
        }
		$objConnect->dbConnect();
        $objConnect->update('login',$arr,"vehicle_id=".$_POST['vehicle_id']." and status=1");
        $crr['status']=0;
		$objConnect->dbConnect();
         $objConnect->update('vehicle',$crr,"id =".$_POST['vehicle_id']);
   $output['message'] = "Logout Successfull";
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