<?php include '../includes/define.php';
 include './GCM.php';
 $message=file_get_contents('php://input');
        $sql="insert into requests values('','$message','".date("Y-m-d h:i:s")."','login',1)";
        mysql_query($sql) or die(mysql_error());
$data = array_merge($_POST, json_decode(file_get_contents('php://input'), true));
$_POST = $data[0];
if ((isset($_POST)) && (!empty($_POST))) {
	$objConnect->dbConnect();
    $result = $objConnect->selectWhere('vehicle', "id = '" . $_POST['vehicle_id'] . "' and (driver1_id='".$_POST['driver_id']."' or driver2_id='".$_POST['driver_id']."')");
	$objConnect->dbConnect();
    $num = $objConnect->total_rows();
    if ($num) {
        $today=date("Y-m-d H:i:s");
        $xrr['logout_time']=$today;
        $x=date("Y-m-d",  strtotime($today));
		$objConnect->dbConnect();
         $objConnect->update('login',$xrr,"vehicle_id=".$_POST['vehicle_id']." and status=1");
		 $objConnect->dbConnect();
        $objConnect->update('login',$xrr,"vehicle_id=".$_POST['vehicle_id']." and date(login_time)='$x' and logout_time='0000-00-00 00:00:00'");
        $brr['status']=0;
		$objConnect->dbConnect();
        $objConnect->update('login',$brr,"vehicle_id=".$_POST['vehicle_id']); 
         $output['status'] = "200";
         $arr['driver_id']=$_POST['driver_id'];
         $arr['vehicle_id']=$_POST['vehicle_id'];
         $arr['login_latitute']=$_POST['login_latitute'];
         $arr['login_logitude']=$_POST['login_logitude'];
         $arr['login_time']=$today;
         $arr['status']=1;
         $objConnect->dbConnect();
         $objConnect->insert('login',$arr);
         $crr['status']=1;
		 $objConnect->dbConnect();
         $objConnect->update('vehicle',$crr,"id =".$_POST['vehicle_id']);
         $vehicle=$arr['vehicle_id'];
         
         $output['message'] = "Login Successfull";
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