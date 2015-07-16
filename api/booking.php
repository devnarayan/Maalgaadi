<?php
include '../includes/define.php';
include_once './GCM.php';
$mode = $_GET['mode'];
unset($_GET['mode']);
switch ($mode) {
    case "accept":
        $data = array_merge($_POST, json_decode(file_get_contents('php://input'), true));
        $_POST = $data[0];
        if ((isset($_POST)) && (!empty($_POST))) {
            $today = date("Y-m-d H:i:s");
            $_POST['accept_time'] = $today;
            $arr['accept_time'] = $_POST['accept_time'];
            $arr['driver_id'] = $_POST['driver_id'];
            $arr['vehicle_id'] = $_POST['vehicle_id'];
            $arr['id'] = $_POST['booking_id'];
            $booking_id = $_POST['booking_id'];
            $arr['status'] = 2;
            $vehicle = $_POST['vehicle_id'];
			$objConnect->dbConnect();
            $result1 = $objConnect->selectWhere('booking', "id=$booking_id and (status<2 or status=33 or status=34 or status=93)");
			$objConnect->dbConnect();
            $num1 = $objConnect->total_rows();
            if ($num1) {
                
                $row1 = $objConnect->fetch_assoc();
                $sql4 = "select vehicle.category,vehicle.registration_no,vehicle.mobile_no, driver.name from vehicle left join login on login.vehicle_id=vehicle.id and login.status=1  left join driver on driver.id=login.driver_id where vehicle.id=$vehicle ";
				$objConnect->dbConnect();
                $result4 = mysql_query($sql4) or die(mysql_error());
                $row4 = mysql_fetch_assoc($result4);
                $brr['status'] = 0;
				$objConnect->dbConnect();
                $result2 = $objConnect->update("vehicle", $brr, "id=$vehicle");
                $crr['status'] = 0;
                $crr['closer_id'] = $_POST['driver_id'];
                $crr['closetime'] = date("Y-m-d H:i:s");
                $crr['vehicle_id'] = $_POST['vehicle_id'];
                $crr['driver_id'] = $_POST['driver_id'];
				$objConnect->dbConnect();
                $objConnect->update("notification", $crr, "booking_id=$booking_id and (booking_status=1 || booking_status=0 ||  booking_status=33 ||  booking_status=93) and status=1");
                $xrr['status'] = 0;
				$objConnect->dbConnect();
                $objConnect->update("logout", $xrr, "booking_id=$booking_id and status=1");
				$objConnect->dbConnect();
                $result = $objConnect->update('booking', $arr, "id=$booking_id");
                $mobileno = $row1['phone'];
                $message = "Trip Id  " . sprintf("%07d", $arr['id']) . " Your MaalGaadi " . $row4['category'] ." ". $row4['registration_no'] . " With driver " . $row4['name'] . " " . $row4['mobile_no'] . "  has been booked for  ".$row1['booking_time'].".Hope you have an awesome experience. Call 8305-771-771 for any assistance.";
                $senderid = "101010";
                sendsms($mobileno, $message, $senderid);
                $output['status'] = "200";
                $output['message'] = "Booking succefully accepted";
                print(json_encode($output));
               
            } else {
				$objConnect->dbConnect();
                $result1 = $objConnect->selectWhere('booking', "id=$booking_id");
                $row1 = mysql_fetch_array($result1);
                if ($row1['status'] == 2 && $row1['vehicle_id'] == $_POST['vehicle_id']) {
                    $output['status'] = "200";
                    $output['message'] = "Booking succefully accepted";
                    print(json_encode($output));
                } else {
                    $output['status'] = "404";
                    $output['message'] = "Booking already assigned";
                    print(json_encode($output));
                }
            }
        } else {
            $output['status'] = "500";
            $output['message'] = "No Data Recieved in Request";
            print(json_encode($output));
        }
        break;
    case "rebooking":
        $data = array_merge($_POST, json_decode(file_get_contents('php://input'), true));
        $_POST = $data[0];
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
               // print_r($message);
                sleep(20);
                
                $result = $gcm->send_notification($registatoin_ids, $message);
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
        break;
    case "decline":
        $data = array_merge($_POST, json_decode(file_get_contents('php://input'), true));
        $_POST = $data[0];
        if ((isset($_POST)) && (!empty($_POST))) {
            $today = date("Y-m-d H:i:s");
            $_POST['decline_time'] = $today;
            $arr['driver_id'] = $_POST['driver_id'];
            $arr['vehicle_id'] = $_POST['vehicle_id'];
            $arr['booking_id'] = $_POST['booking_id'];
            $arr['decline_time'] = $today;
            $arr['status'] = 1;
			$objConnect->dbConnect();
            $result = $objConnect->insert('declines', $arr);
            if ($result) {
                $output['status'] = "200";
                $output['message'] = "Booking Declined ";
                print(json_encode($output));
            } else {
                $output['status'] = "404";
                $output['message'] = "Can not save Record ";
                print(json_encode($output));
            }
        } else {
            $output['status'] = "500";
            $output['message'] = "No Data Recieved in Request";
            print(json_encode($output));
        }
        break;
    case "completeBooking":
        $message=file_get_contents('php://input');
        $sql="insert into requests values('','$message','".date("Y-m-d h:i:s")."','complete booking',1)";
        mysql_query($sql) or die(mysql_error());
        $data = array_merge($_POST, json_decode(file_get_contents('php://input'), true));
        
        if ((isset($data)) && (!empty($data))) {
            foreach ($data as $key1 => $value1) {
                //send message
                $_POST = $value1;

                $booking_id = $_POST['booking_id'];
                $logs = $_POST['logs'];
                // $objConnect->deleteRow("booking_logs","booking_id=$booking_id");
				$objConnect->dbConnect();
                $result7 = $objConnect->selectWhere("booking", "id=$booking_id");
                $row7 = $objConnect->fetch_assoc();
                foreach ($logs as $value) {
                    unset($value['booking_logs_id']);
                    unset($value['sync_status']);
                    unset($value['id']);

                    if ($value['status'] == "reached to customer") {
                        $borr['pickup_lat'] = $value['current_latitude'];
                        $borr['pickup_lng'] = $value['current_longitude'];
						$objConnect->dbConnect();
                        $borr['pick_up_landmark'] = getAddress($value['current_latitude'], $value['current_longitude']);
						$objConnect->dbConnect();
                        $objConnect->update("booking", $borr, "id=$booking_id");
                        $borr['status'] = 1;
						$objConnect->dbConnect();
                        $objConnect->update("favorite_location", $borr, "status=0 and current_location like '" . mysql_real_escape_string($row7['current_location']) . "' and customer_id='" . $row7['customer_id'] . "'");
                    } elseif ($value['status'] == "stop unloading") {
                        $corr['drop_lat'] = $value['current_latitude'];
                        $corr['drop_lng'] = $value['current_longitude'];
						$objConnect->dbConnect();
                        $corr['drop_landmark'] = getAddress($value['current_latitude'], $value['current_longitude']);
                        $borr['pickup_lat'] = $value['current_latitude'];
                        $borr['pickup_lng'] = $value['current_longitude'];
						$objConnect->dbConnect();
                        $borr['pick_up_landmark'] = getAddress($value['current_latitude'], $value['current_longitude']);
						$objConnect->dbConnect();
                        $objConnect->update("booking", $corr, "id=$booking_id");
                        $borr['status'] = 1;
						$objConnect->dbConnect();
                        $objConnect->update("favorite_location", $borr, "status=0 and current_location like '" . mysql_real_escape_string($row7['drop_location']) . "' and customer_id='" . $row7['customer_id'] . "'");
                    }

                    $value['datetime'] = changeFormat("d:M:Y:H:i:s", "Y-m-d H:i:s", $value['datetime']);
					$objConnect->dbConnect();
                    $result2 = $objConnect->insert("booking_logs", $value);
                }
                unset($_POST['short']['bookingshort_id']);
                unset($_POST['short']['id']);

                //$objConnect->deleteRow("booking_short","booking_id=$booking_id");

                $objConnect->dbConnect();
				$result2 = $objConnect->insert("booking_short", $_POST['short']);
                $xrr['status'] = 7;
                $xrr['edit_status'] = 'completed';
				$objConnect->dbConnect();
                $result3 = $objConnect->update("booking", $xrr, "id=$booking_id");
                $output['status'] = "200";
				$objConnect->dbConnect();
                $result7 = $objConnect->selectWhere("booking", "id=$booking_id");
                $row7 = $objConnect->fetch_assoc();
                unset($brr);
                $vrr['status'] = 1;
				$objConnect->dbConnect();
                $resultvehi = $objConnect->update("vehicle", $vrr, "id='" . $row7['vehicle_id']."'");
                $brr['booking_id'] = $booking_id;
                $brr['trip_time'] = $_POST['short']['trip_time'];
                $brr['trip_distance'] = $_POST['short']['trip_distance'];
                $brr['rate'] = $row7['rate'];
                $brr['payment'] = $_POST['short']['payment'];
                $brr['addedon'] = date("Y-m-d H:i:s");
				$objConnect->dbConnect();
                $result2 = $objConnect->insert("payment", $brr);
                $mobileno = $row7['phone'];
            

                




                //$booking_id=1389;
            $id = $booking_id;
            $result = $objConnect->selectWhere("booking", "id=$id");
            $row = $objConnect->fetch_assoc();
            $result1 = $objConnect->selectWhere("booking_short", "booking_id=$id");
            $row1 = $objConnect->fetch_assoc();
            $result2 = $objConnect->selectWhere("booking_logs", "booking_id=$id and status like 'reached to customer'");
            $row2 = $objConnect->fetch_assoc();
            $pickup_date = date("d/m/Y H:i:s", strtotime($row2['datetime']));
            $result3 = $objConnect->selectWhere("booking_logs", "booking_id=$id and status like 'stop unloading'");
            $row3 = $objConnect->fetch_assoc();
            $drop_date = date("d/m/Y H:i:s", strtotime($row3['datetime']));
            
            //  $message1 = "The consignment booked through " . sprintf("%07d", $booking_id) . " has been successfully delivered. An amount of Rs. " . $_POST['short']['payment'] . "  has been duly received by driver. Thank you for choosing MaalGaadi.";
                 //$message1 = "Received an amount of Rs. " . sprintf("%07d", $booking_id) . " has been successfully delivered. The Total amount is: ".$row1['total_payment_amount']."  An amount of Rs. " . $_POST['short']['payment'] . "  has been duly received by driver. Thank you for choosing MaalGaadi.";
            $sql111="SELECT SUM(balance) AS payment_amt FROM `booking_short` WHERE `booking_id` in( select id from `booking` where `customer_id`='".$row['customer_id']."')";
            $result111=$objConnect->execute($sql111);
            $tr1111=mysql_fetch_array($result111);
            $payment_amt=$tr1111['payment_amt']." ";


            $sql222="SELECT SUM(discount_amount) AS discount_pay FROM `discount` WHERE `customer_id`='".$row['customer_id']."'";
            $result22=$objConnect->execute($sql222);
            $tr22=mysql_fetch_array($result22);
            $discount_pay=$tr22['discount_pay']." ";

            $sql333="SELECT SUM(cash_amount) AS cash_pay FROM `cashreceive` WHERE `customer_id`='".$row['customer_id']."'";
            $result33=$objConnect->execute($sql333);
            $tr33=mysql_fetch_array($result33);
            $cash_pay=$tr33['cash_pay']." ";

            /*$sql222="SELECT total_payment_amount FROM `booking_short` WHERE `customer_id`='".$row['customer_id']."'";
            $result22=$objConnect->execute($sql222);
            $tr22=mysql_fetch_array($result22);
            $discount_pay=$tr22['discount_pay']." ";*/

            $balence=$payment_amt-($discount_pay-$cash_pay);

                $message1 = "Received an amount of Rs. " . $row1['payment'] . " against bill of Rs. " . $row1['total_payment_amount'] . " For Trip Id  " . sprintf("%07d", $booking_id) . ". Thanks for using MaalGaadi. Please Call 8305-771-771 for any assistance";
               
                $senderid = "101010";
                sendsms($mobileno, $message1, $senderid);



            $message='<table style="width: 100%;">
                            <tr>
                                <td colspan="4" style="border-right: none; padding-top: 22px; line-height: 20px">
                                    <strong>Invoice No: Mg'.sprintf("%03d", $row['id']).'</strong><br/>
                                    <strong>Date:'.$row3['datetime'].'</strong>
                                </td>
                                <td colspan="2" style="text-align: right; ">
                                    <img src="<?php echo BASE_URL; ?>/images/maalgaadi.png">
                                </td>
                            </tr>
                            
                            <tr>
                                <td colspan="6" style="text-align: center;border: 1px solid black; background: #0a2b6e;border-bottom: 5px solid #fec60f; color: #fff; padding: 7px 0">
                                    <h2 style="font-size: 23px">';
                                        
                                        if (($row['customer_organization'] != "NA") && (!empty($row['customer_organization']))) {
                                            $message.=$row['customer_organization'];
                                            ?><?php
                                        } else {
                                            $message.=$row['firstname'];
                                        }
                                        
                                        $message.='</h2></td>
                               
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <table style="width:96%; margin: 20px auto 0">
                                        <tr>
                                <td style=" width: 70%;text-align: center;border: 1px solid #ccc; border-right: none; color: #000">
                                    <div style="  padding-top: 20px; margin-top: -1px">';
                                    
                                    $loading = 0.0;
                                    $unloading = 0.0;
                                    if ($row['loading']) {
                                        $loading = $row['loading_charge'];
                                    }
                                    if ($row['unloading']) {
                                        $unloading = $row['loading_charge'];
                                    }
                                    $loading = sprintf("%.02f", $loading);
                                    $unloading = sprintf("%.02f", $unloading);
                                    $Freight=$row1['total_payment_amount']-$loading-$unloading;
                                    
                                        $message.='<h3 style="font-size: 23px;">Total Amount: <br /><span style="font-size:50px; line-height: 60px">'.$row1['total_payment_amount'].'</span></h3>
                                    <h3 style="line-height:35px; font-size: 18px">Total Freight:'.$Freight.'</h3>

                                    <h3 style="line-height:35px; font-size: 18px">Charges for Loading:'.$loading.'</h3>
                                    <h3 style="line-height:35px; font-size: 18px; margin-bottom: 10px">Charges for Unloading: '.$unloading.'</h3>
                                    </div>
                                    
                                    <table style="width: 100%; font-size: 10px">
                                        <tr><th> MONEY DEDUCTED (For prepaid cust)</th><th>DISCOUNT</th><th>PAYABLE AMOUNT</th></tr>
                                        <tr><td style="text-align: center">0.0</td><td style="text-align: center">0.0</td><td style="text-align: center">'.$row1['total_payment_amount'].'</td></tr>
                                    </table>
                              </td>
                              <td style="width: 30%; border: 1px solid #ccc; border-left: none;">
                                  <div id="map-canvas" style="width:100%; height:280px; margin-top: -1px"></div></td>
                                    </tr>
                             </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <table style="width:96%; margin: 20px auto 0">                                        
                                        <tr class="thead">
                                            <th style=" background: #0a2b6e; color: #fff; padding: 10px 0">FARE BREAKUP </th>
                                            <th style=" background: #0a2b6e; color: #fff; padding: 10px 0">BOOKING DETAILS</th>
                                        </tr>
                                        
                                        <tr>
                                                <td style="padding:10px 5px 20px">
                                                    <table style="width:100%; color: #333">
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Minimum Fare:</strong></td>
                                                            <td><span style="font-size:15px">'.$row['model_minfare'].'</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Fare for First 10 Km. :</strong></td>
                                                            <td><span style="font-size:15px">'.$row['firstten'].'</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Fare for Post 10 Km. :</strong></td>
                                                            <td><span style="font-size:15px">'.$row['rate'].'</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Fare per hour :</strong></td>
                                                            <td><span style="font-size:15px">'.$row['wait_time_charge'].'</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Fare for Loading/Unloading:</strong></td>
                                                            <td><span style="font-size:15px">'.$row['loading_charge'].'/'.$row['loading_charge'].'</span></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style="padding:10px 5px 20px; font-size:15px">
                                                    <table style="width:100%; color: #333">
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Booking Id:</strong></td>
                                                            <td><span style="font-size:15px">'.sprintf("%7d", $row['id']).'</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Service Type :</strong></td>
                                                            <td><span style="font-size:15px">'.$row['vehicle'].'</span></td>
                                                        </tr>
                                                        <tr>';
                                                        $trip_distance=$row1['trip_distance']/ 1000;
                                                            $message.='<td><strong style="font-size:15px; line-height: 25px">Total Distance  :</strong></td>
                                                            <td><span style="font-size:15px">'.$trip_distance.' Km</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Total Time :</strong></td>
                                                            <td><span style="font-size:15px">'.$row1['wait_time'].' min</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Pickup Date and Time :</strong></td>
                                                            <td><span style="font-size:15px">'.$pickup_date.'</span></td>
                                                         </tr>
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Drop Date and Time :</strong></td>
                                                            <td><span style="font-size:15px">'.$drop_date.'</span></td>
                                                         </tr>
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Person Contact Number :</strong></td>
                                                            <td><span style="font-size:15px">'.$row['phone'].'</span></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        
                                        <tr>
                                            <td colspan="2" style=" padding: 20px 0; border-top: 1px solid #ccc">
                                                **Higher of the Hourly or Distance rate will be charged.<br>
                                                ** All charges other than freight & loading/unloading like toll tax etc will be charged from the customer on actual basis.<br>

                                                For further queries, please write to mail@maalgaadi.net<br>
                                                Note: This is an electronically generated invoice and does not require signature.<br>

                                            </td>
                                        </tr>
                                        
                                        
                                        <tr>
                                            <td colspan="2" style="text-align: center; background: black; color: #fff; padding: 10px 0">
                                                301, Laxmi Tower, M.G. Road, Indore M. P. -  452018   <br>          
                                                Tel : +91 731 4256866         <br>    
                                                AVPS Transort           <br>  

                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            
                        </table>';







                $emailList="mail@maalgaadi.net";
                $to=$row['email']; //change to ur mail address
                $strSubject="MaalGaadi | Invoice";
                //$message =  file_get_contents('templete.php');              
                $headers = 'MIME-Version: 1.0'."\r\n";
                $headers .= 'Content-type: text/html; charset=iso-8859-1'."\r\n";
                $headers .= "From:No Reply <no-reply@maalgaadi.net>"."\r\n"; 
                $headers .= "Bcc: mail@maalgaadi.net";
                
                $mail_sent=mail($to, $strSubject, $message, $headers);  


                unset($_POST);
            }
            print(json_encode($output));
        } else {
            $output['status'] = "500";
            $output['message'] = "No Data Recieved in Request";
            print(json_encode($output));
        }
        break;
    case "canceldetail":
        $data = array_merge($_POST, json_decode(file_get_contents('php://input'), true));
        $_POST = $data[0];
        if ((isset($_POST)) && (!empty($_POST))) {
            $booking_id = $_POST['booking_id'];
            $_POST['datetime'] = changeFormat("d:M:Y:H:i:s", "Y-m-d H:i:s", $_POST['datetime']);
			$objConnect->dbConnect();
            $objConnect->insert("reassigndetail", $_POST);
            $arr['status'] = 34;
			$objConnect->dbConnect();
            $result2 = $objConnect->update('booking', $arr, "id=$booking_id");
            $output['status'] = "200";
            $output['message'] = "Booking Canceled";
            print(json_encode($output));
        } else {
            $output['status'] = "500";
            $output['message'] = "No Data Recieved in Request";
            print(json_encode($output));
        }
        break;
    case "send_sms_driver_reached":
        //$data = array_merge($_POST, json_decode(file_get_contents('php://input'), true));
        //$_POST = $data[0];
        if ($_REQUEST['booking_id']!="" && $_REQUEST['driver_id']!="" && $_REQUEST['vehicle_id']!="") {

            $booking_id = $_REQUEST['booking_id'];
            $driver_id = $_REQUEST['driver_id'];
            $vehicle_id = $_REQUEST['vehicle_id']; //next update par change karna hai.

            $result = $objConnect->selectWhere("booking", "id=$booking_id");
            $row = mysql_fetch_array($result);

            $result1 = $objConnect->selectWhere("driver", "id=$driver_id");
            $row1 = mysql_fetch_array($result1);

            $result2 = $objConnect->selectWhere("vehicle", "id=$vehicle_id");
            $row2 = mysql_fetch_array($result2);

            $mobileno = $row['phone'];
            $message = "Trip Id  " . sprintf("%07d", $booking_id) . " Your MaalGaadi has reached the pickup point & is waiting to get loaded. Please pay an estimated amount of Rs. " . $row['total_fare'] . " to the driver " . $row1['name'] . " and mobile no.  " . $row1['mobile']."";
            $senderid = "101010";
            sendsms($mobileno, $message, $senderid);

            $output['status'] = "200";
            $output['message'] = "sms send successfully";
            print(json_encode($output));
        } else {
            $output['status'] = "500";
            $output['message'] = "No Data Recieved in Request";
            print(json_encode($output));
        }
        break;
    default:
        break;

        case "status_update":
        //$data = array_merge($_POST, json_decode(file_get_contents('php://input'), true));
        //$_POST = $data[0];
        if ($_REQUEST['booking_id']!="" && $_REQUEST['driver_id']!="" && $_REQUEST['vehicle_id']!="" && $_REQUEST['current_latitude']!="" && $_REQUEST['current_longitude']!="" && $_REQUEST['datetime']!="" && $_REQUEST['status']!="") 
        {

            $brr['booking_id'] = mysql_escape_string($_REQUEST['booking_id']);
            $brr['driver_id'] = mysql_escape_string($_REQUEST['driver_id']);
            $brr['vehicle_id'] = mysql_escape_string($_REQUEST['vehicle_id']);
            $brr['current_latitude'] = mysql_escape_string($_REQUEST['current_latitude']);
            $brr['current_longitude'] = mysql_escape_string($_REQUEST['current_longitude']);
            $brr['datetime'] = mysql_escape_string($_REQUEST['datetime']);
            $brr['status'] = mysql_escape_string($_REQUEST['status']);
            $brr['datetime'] = changeFormat("d:M:Y:H:i:s", "Y-m-d H:i:s", $brr['datetime']);
            $booking_id=mysql_escape_string($_REQUEST['booking_id']);

            /*$objConnect->dbConnect();
            $result2 = $objConnect->insert("booking_logs", $brr);*/

            $arr['edit_status'] = mysql_escape_string($_REQUEST['status']);

            $result2 = $objConnect->update('booking', $arr, "id=$booking_id");

            $output['status'] = "200";
            $output['message'] = "successfully";
            print(json_encode($output));
        } else {
            $output['status'] = "500";
            $output['message'] = "No Data Recieved in Request";
            print(json_encode($output));
        }
        break;
    default:
        break;
}
?>