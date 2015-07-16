 <?php 
 include '../includes/define1.php';
 include './GCM.php';
 $data = array_merge($_POST, json_decode(file_get_contents('php://input'), true));
        $_POST = $data[0];
        $message="";
        $registatoin_ids="";
        if ((isset($_POST)) && (!empty($_POST))) {
            $vehicle = $_POST['vehicle_id'];
            $booking_id = $_POST['booking_id'];
			$objConnect->dbConnect();
            $result1 = $objConnect->selectWhere('booking', "id=$booking_id and vehicle_id=$vehicle");
			$objConnect->dbConnect();
            $num1 = $objConnect->total_rows();
            if ($num1) {
                $row2 = $objConnect->fetch_assoc();
                $row2['pickup_name'] = $row2['pick_up_name'];
                $row2['pickup_number'] = $row2['pick_up_no'];
                $row2['pickup_organization'] = $row2['pick_up_organization'];
				$objConnect->dbConnect();
                $result3 = $objConnect->selectWhere("vehicle", "id='$vehicle'");
				$objConnect->dbConnect();
                $row3 = $objConnect->fetch_assoc();
                $regId = $row3["device_token"];
                $data1['result'][0]['data'] = $row2;
                $message = json_encode($data1);
                $gcm = new GCM();
                $registatoin_ids = array($regId);
                $message = array("booking" => $message);
                 $output['status'] = "200";
                $output['message'] = "Booking done ";
                  
               
                print(json_encode($output));
 $result = $gcm->send_notification($registatoin_ids, $message);
               // print_r($message);
                
            } else {
                $output['status'] = "404";
                $output['message'] = "Booking Does Not belong to you";
                print(json_encode($output));
            }
        } else {
            $output['status'] = "500";
            $output['message'] = "No Data Recieved in Request";
            print(json_encode($output));
        }
       
        ?>