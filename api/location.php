<?php
include '../includes/define.php';
$data = array_merge($_POST, json_decode(file_get_contents('php://input'), true));
if ((isset($data)) && (!empty($data))) {
    foreach ($data as $value) {
        $_POST = $value;
        $_POST['addedon_to'] = $_POST['addedon'];
        $_POST['addedon'] = changeFormat("d:M:Y:H:i:s", "Y-m-d H:i:s", $_POST['addedon']);
        if (!empty($_POST['latitute'])) {
            if((empty($_POST['booking_id']))||($_POST['booking_id']=="0")){
               $_POST['status']="free"; 
             
        }
//        if($_POST['vehicle_id']==39){
//            $message="";
//            foreach ($_POST as $key=>$value){
//                $message.="$key=$value";
//            }
//        
//             mail("mmfinfotech335@gmail.com","location","$message");
//            
//        }
$objConnect->dbConnect();
            $result1 = $objConnect->insert('location', $_POST);
			
			//Query edit by neeraj
			$objConnect->dbConnect();
            $res = mysql_query('select * from getCurrentDriver where vehicle_id = "'.$_POST['vehicle_id'].'"');
			$numRow = mysql_num_rows($res);
			if($numRow > 0)
			{
				$where = 'vehicle_id = "'.$_POST['vehicle_id'].'"';
				unset($_POST['vehicle_id']);
				$objConnect->dbConnect();
          		$result1 = $objConnect->update('getCurrentDriver',$_POST,$where);
			}
			else
			{
				$objConnect->dbConnect();
				$result1 = $objConnect->insert('getCurrentDriver', $_POST);
			}
			//Query edit end by neeraj
        }
    }
    $output['status'] = "200";
    $output['message'] = "Location Saved";
    print(json_encode($output));
} else {
    $output['status'] = "500";
    $output['message'] = "No Data Recieved in Request";
    print(json_encode($output));
}