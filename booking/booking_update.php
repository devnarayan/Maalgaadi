<?php
include '../includes/define.php';
$mode = $_REQUEST['mode'];
unset($_POST['mode']);
unset($_GET['mode']);
switch ($mode) {
    case "new":
        $brr['customer_id'] = 0;
        $today = date("Y-m-d H:i:s");
        if ((isset($_POST['customer_id'])) && (!empty($_POST['customer_id']))) {
            $brr['customer_id'] = $_POST['customer_id'];
            $arr['last_booking_date'] = $today;
            $where = "`id`=" . $brr['customer_id'];
            $result = $objConnect->update('customer', $arr, $where);
        } else {
            $arr['customer_number'] = $_POST['customer_number'];
            $arr['customer_name'] = $_POST['customer_name'];
            $arr['customer_address'] = $_POST['customer_address'];
            $arr['added_on'] = $today;
            $arr['added_by'] = $_SESSION['executive_id'];
            $arr['last_booking_date'] = $today;
            $result = $objConnect->insert('customer', $arr);
            $brr['customer_id'] = $result;
        }
        $brr['pickup_address'] = $_POST['pickup_address'];
        $brr['destination_address'] = $_POST['destination_address'];
        $brr['vehicle_type'] = $_POST['vehicle_type'];
        $brr['pickup_time'] = $_POST['pickup_time'];
        $brr['booking_time'] = $today;
        $brr['status'] = 1;

        break;
    case "calculateTotalFare":

        $today = date("Y-m-d H:i:s");
        $vehicle_category = $_POST['model_id'];
        $km = $_POST['distance_km'];
        $result = $objConnect->selectWhere('vehicle_category', "id=$vehicle_category");

        $row = $objConnect->fetch_assoc();
        //print_r($row);
        echo $total = ($km * $row['rate']) . "," . $row['rate'] . "," . $row['min_fare'];
        break;
    case "booking":
        $today = date("Y-m-d H:i:s");
        $_POST['customer_id'] = trim($_POST['customer_id']);
        if ($_POST['customer_id'] == "") {
            $arr['customer_name'] = $_POST['firstname'];
            $arr['customer_number'] = $_POST['phone'];
            $arr['customer_email'] = $_POST['email'];
            $arr['customer_category'] = $_POST['customer_category'];
            $arr['added_on'] = $today;
            $arr['added_by'] = $_SESSION['executive_id'];
            $arr['status'] = 1;
            $result1 = $objConnect->insert("customer", $arr);
            $_POST['customer_id'] = $result1;
        }

        $_POST['pickup_date'];
        $_POST['pickup_date'] = changeFormat("d/m/Y H:i", "Y-m-d H:i:s", $_POST['pickup_date']);

        $today = date("Y-m-d H:i:s");
        $_POST['booking_time'] = $today;
        $result = $objConnect->insert("booking", $_POST);
        $result2 = $objConnect->selectWhere('booking', "id=$result");
        $num2 = $objConnect->total_rows();

        $row2 = $objConnect->fetch_assoc();
        $fields = mysql_query("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'favorite_location'");
        $columns = array();
        while ($row = mysql_fetch_assoc($fields)) {
            $columns[] = ($row['COLUMN_NAME']);
        }
        $newarray = array_intersect_key($row2, array_flip($columns));
        $rowx = $objConnect->selectWhere("favorite_location", "current_location like '" . $row2['current_location'] . "' and customer_id='".$_POST['customer_id']."'");
        $numx = $objConnect->total_rows();
        echo $numx;
        if (!$numx) {
            unset($newarray['id']);
            $newarray['status'] = 0;
            echo $insertx = $objConnect->insert("favorite_location", $newarray);
        }
        $result4 = $objConnect->selectWhere("vehicle_category", "id ='" . $_POST['vehicle'] . "'");
        $row4 = $objConnect->fetch_assoc();
        $result3 = $objConnect->selectWhere("vehicle", "category ='" . $row4['name'] . "' and status=1");
        $regId = array();
        while ($row3 = $objConnect->fetch_assoc()) {
            $regId[] = $row3["device_token"];
        }
        $vehicle = $row2['vehicle'];
        $result8 = $objConnect->selectWhere("vehicle_category", "id='$vehicle'");
        $row8 = $objConnect->fetch_assoc();
        $row2['standard_wait_time'] = $row8['waiting_time'];
        $row2['wait_time_charge'] = $row8['waiting_time_charge'];
        $data['result'][0]['data'] = $row2;
         $message = json_encode($data);

        include_once '../api/GCM.php';
        $gcm = new GCM();
        $registatoin_ids = $regId;
        $message = array("booking" => $message);

        
        $result = $gcm->send_notification($registatoin_ids, $message);
        echo "booking done Successfully <a href='booking_list.php'>View Booking List</a>";
        break;

    case "autocompleteFirstname":
        $q = $_GET['term'];
        $org_id = $_GET['term_id'];
        if(!empty($org_id))
        {
            $result = $objConnect->selectWhere("customer", "organization_id='$org_id' and customer_name like '%$q%'");
        }
        else
        {
            $result = $objConnect->selectWhere("customer", "customer_name like '%$q%'");
        }
        $data = array();
        while ($row1 = $objConnect->fetch_assoc()) {

            /*$o_id=$row1['organization_id'];
            $result1 = $objConnect->selectWhere("organization", "id='$o_id'");
            $row12 = $objConnect->fetch_assoc();*/

             $o_id=$row1['organization_id'];
           $res121 =mysql_query("SELECT * FROM organization WHERE id='$o_id'");
           $row12=mysql_fetch_array($res121);

            $data[]  = array('id' =>$row1['id'],'customer_name' =>$row1['customer_name'],'customer_email' =>$row1['customer_email'],'customer_address' =>$row1['customer_address'],'customer_number' =>$row1['customer_number'],'organization_id' =>$row12['id'],'organization_name' =>$row12['name'],'organization_email' =>$row12['email'],'organization_address' =>$row12['address'],'customer_category' =>$row1['customer_category'] );
       
        }
        print_r(json_encode($data));
        break;

    case "autocompleteorganization":
        $q = $_GET['term'];
        $result = $objConnect->selectWhere("organization", "name like '%$q%'");
        $data = array();
        while ($row1 = $objConnect->fetch_assoc())
         {
            $o_id=$row1['id'];
           $res121 =mysql_query("SELECT * FROM customer WHERE organization_id='$o_id'");
           $row12=mysql_fetch_array($res121);
           
            $data[]  = array('id' =>$row1['id'],'customer_name' =>$row1['name'],'customer_email' =>$row1['email'],'address' =>$row1['address'],'cus_id' =>$row12['id'],'cus_customer_name' =>$row12['customer_name'],'cus_customer_email' =>$row12['customer_email'],'cus_customer_number' =>$row12['customer_number'],'cus_customer_address' =>$row12['customer_address'],'customer_category' =>$row12['customer_category'] );
       
        }
        print_r(json_encode($data));
        break;
        
    case "autocompleteEmail":
        $q = $_GET['term'];
        $result = $objConnect->selectWhere("customer", "customer_email like '%$q%'");
        $data = array();
        while ($row1 = $objConnect->fetch_assoc()) {

            $data[] = $row1;
        }
        print_r(json_encode($data));
        break;

    case "autocompletePhone":
        $q = $_GET['term'];
        /*$result = $objConnect->selectWhere("customer", "customer_number like '%$q%'");
        $data = array();
        while ($row1 = $objConnect->fetch_assoc()) {

            $data[] = $row1;
        }*/
        $org_id = $_GET['term_id'];
        if(!empty($org_id))
        {
            $result = $objConnect->selectWhere("customer", "organization_id='$org_id' and customer_number like '%$q%'");
        }
        else
        {
            $result = $objConnect->selectWhere("customer", "customer_number like '%$q%'");
        }
        $data = array();
        while ($row1 = $objConnect->fetch_assoc()) {

            $o_id=$row1['organization_id'];
           $res121 =mysql_query("SELECT * FROM organization WHERE id='$o_id'");
           $row12=mysql_fetch_array($res121);

            $data[]  = array('id' =>$row1['id'],'customer_name' =>$row1['customer_name'],'customer_email' =>$row1['customer_email'],'customer_address' =>$row1['customer_address'],'customer_number' =>$row1['customer_number'],'organization_id' =>$row12['id'],'organization_name' =>$row12['name'],'organization_email' =>$row12['email'],'organization_address' =>$row12['address'],'customer_category' =>$row1['customer_category'] );
       
        }
        print_r(json_encode($data));
        break;
    case "payment_info":
        $q = $_GET['value'];
        $payment=0;
        $total_amount=0;
        $final_total_amount=0;
        
      
        $sql2="SELECT SUM(credit) AS credit FROM `customer_ledger` WHERE `customer_id`='$q'";
        $result2=$objConnect->execute($sql2);
        $tr2=mysql_fetch_array($result2);
        $credit=$tr2['credit'];

        $sql3="SELECT SUM(debit) AS debit FROM `customer_ledger` WHERE `customer_id`='$q'";
        $result3=$objConnect->execute($sql3);
        $tr3=mysql_fetch_array($result3);
        $debit=$tr3['debit'];

        $balence=$debit-$credit;

        echo $balence=round($balence,2);

        break;
    case "discount_info":
        $q = $_GET['value'];
        
        $sql2="SELECT * FROM `customer` WHERE `id`='$q'";
        $result2=$objConnect->execute($sql2);
        $tr2=mysql_fetch_array($result2);
        $discount_percentage=$tr2['discount_percentage'];

         $discount_percentage=round($discount_percentage,2);
         echo$discount_percentage."%";
        break;

    case "vehicle_detail":
        $vehicle_id = $_POST['model_id'];
        $result = $objConnect->selectWhere("vehicle_category", "id=$vehicle_id");
        $row = $objConnect->fetch_assoc();
        print_r(json_encode($row));
        break;
    case "fetchpickup_drop":
        $customer_id = $_POST['customer_id'];
        $result = $objConnect->selectWhere("favorite_location", "customer_id=$customer_id");
        $data = array();
        while ($row = $objConnect->fetch_assoc()) {
            $data[] = $row;
        }
        print_r(json_encode($data));
        break;
    case "bookingnew":
        $today = date("Y-m-d H:i:s");
        $_POST['customer_id'] = trim($_POST['customer_id']);
        $sql3 = "select * from customer where(customer_number='" . $_POST['phone'] . "')";
        $result3 = mysql_query($sql3) or die(mysql_error());
        $num3 = mysql_num_rows($result3);
        if ($num3) {
            $row3 = mysql_fetch_assoc($result3);
            $_POST['customer_id'] = $row3['id'];
        } else {
            $_POST['customer_id'] = "";
        }
         
        if ($_POST['customer_id'] == "") {
            $arr['customer_name'] = $_POST['firstname'];
            $arr['customer_number'] = $_POST['phone'];
            $arr['customer_email'] = $_POST['email'];
            $arr['customer_category'] = $_POST['customer_category'];
            $arr['customer_address'] = $_POST['address'];
            if ($_POST['organization_id']=="") {
                    
                   if($_POST['organization']=="")
                   {
                        echo$orr['name'] = $_POST['firstname'];
                   }
                   else
                   {
                        echo$orr['name'] = $_POST['organization'];
                   }

                $sql122 = "select * from organization where name='" . $orr['name'] . "'";
                $result122 = mysql_query($sql122) or die(mysql_error());
                 if(mysql_fetch_array($result122))
                 {  
                        echo"organization name already exist";
                        exit;
                
                }else
                {
                    $orr['email'] = $_POST['organization_email'];
                    $orr['address'] = $_POST['organization_address'];
                    $result22 = $objConnect->insert("organization", $orr);
                    $organi_id = $objConnect->rows_id();
                    $arr['organization_id'] = $organi_id;

                }

                

            }else
            {
                $arr['organization_id'] = $_POST['organization_id'];
            }

            $arr['added_on'] = $today;
            $arr['added_by'] = $_SESSION['executive_id'];
            $arr['status'] = 1;
            $result1 = $objConnect->insert("customer", $arr);
            $_POST['customer_id'] = $result1;
        }
         unset($_POST['organization_id']);
         unset($_POST['organization_address']);
         unset($_POST['organization_email']);
        $_POST['city_id']= $_SESSION['dash_city'];
        $_POST['pickup_date'];
        $_POST['pickup_date'] = changeFormat("d/m/Y H:i", "Y-m-d H:i:s", $_POST['pickup_date']);
        $_POST['customer_organization'] = $_POST['organization'];
        unset($_POST['organization']);
        $_POST['customer_address'] = $_POST['address'];
        unset($_POST['address']);
        $_POST['employee_booking_id'] = $_SESSION['executive_id'];
        $_POST['status'] = -3;
        $today = date("Y-m-d H:i:s");
        $_POST['booking_time'] = $today;
        $_POST['city_id'] = $_SESSION['dash_city'];
        //$total_exp_fare=$_POST['total_exp_fare'];
        if($_POST['total_exp_fare'] != '' && $_POST['total_exp_fare'] != 0 ){ $_POST['total_fare'] = $_POST['total_exp_fare']; }
        unset($_POST['total_exp_fare']);

        //print_r($_POST); exit;

        $result = $objConnect->insert("booking", $_POST);
        $result2 = $objConnect->selectWhere('booking', "id=$result");
        $num2 = $objConnect->total_rows();
        $row2 = $objConnect->fetch_assoc();
        $rowx = $objConnect->selectWhere("favorite_location", "current_location like '" . $row2['current_location']."' and type='pickup' and customer_id='".$_POST['customer_id']."'");
        $numx = $objConnect->total_rows();
        if (!$numx) {
            $newarray['customer_id'] = $row2['customer_id'];
            $newarray['type'] = "pickup";
            $newarray['pick_up_name'] = $row2['pick_up_name'];
            $newarray['pick_up_no'] = $row2['pick_up_no'];
            $newarray['pick_up_organization'] = $row2['pick_up_organization'];
            $newarray['current_location'] = $row2['current_location'];
            $newarray['pick_up_landmark'] = $row2['pick_up_landmark'];
            $newarray['pickup_lat'] = $row2['pickup_lat'];
            $newarray['pickup_lng'] = $row2['pickup_lng'];
            $newarray['booking_id'] = $row2['id'];
            $newarray['booking_time'] = $row2['booking_time'];
            $newarray['last_updated'] = date("Y-m-d H:i:s");
            $newarray['status'] = 0;
			$insertx = $objConnect->insert("favorite_location", $newarray);
        }
        $rowx = $objConnect->selectWhere("favorite_location", "  current_location like '" . $row2['drop_location'] . "' and type='drop' and customer_id='".$_POST['customer_id']."'");
        $numx1 = $objConnect->total_rows();

        if (!$numx1) {
        
            
            $newarray['customer_id'] = $row2['customer_id'];
            $newarray['type'] = "drop";
            $newarray['pick_up_name'] = $row2['drop_name'];
            $newarray['pick_up_no'] = $row2['drop_number'];
            $newarray['pick_up_organization'] = $row2['drop_organization'];
            $newarray['current_location'] = $row2['drop_location'];
            $newarray['pick_up_landmark'] = $row2['drop_landmark'];
            $newarray['pickup_lat'] = $row2['drop_lat'];
            $newarray['pickup_lng'] = $row2['drop_lng'];
            $newarray['booking_id'] = $row2['id'];
            $newarray['booking_time'] = $row2['booking_time'];
            $newarray['last_updated'] = date("Y-m-d H:i:s");
            $newarray['status'] = 0;
            $insertx = $objConnect->insert("favorite_location", $newarray);
        }
        $mobileno = $_POST['phone'];
        $result5 = $objConnect->selectWhere("vehicle_category", "id=" . $_POST['vehicle']);
        $row5 = $objConnect->fetch_assoc();
        $message = "Booking request received for " . $row5['name'] . " on " . date("d/m/Y h:i a", strtotime($_POST['pickup_date'])) . " Booking id " . sprintf("%07d", $result) . ". We will revert with the confirmation and driver details soon. Thank you - MaalGaadi.";
        $senderid = "101010";
      //  sendsms($mobileno, $message, $senderid);



        
//        $num2 = $objConnect->total_rows();
//
//        $row2 = $objConnect->fetch_assoc();
//        $result4 = $objConnect->selectWhere("vehicle_category", "id ='" . $_POST['vehicle'] . "'");
//        $row4 = $objConnect->fetch_assoc();
//        $result3 = $objConnect->selectWhere("vehicle", "category ='" . $row4['name'] . "' and status=1");
//        $regId = array();
//        while ($row3 = $objConnect->fetch_assoc()) {
//            $regId[] = $row3["device_token"];
//        }
//        $vehicle = $row2['vehicle'];
//        $data['result'][0]['data'] = $row2;
//        $message = json_encode($data);
//        include_once '../api/GCM.php';
//        $gcm = new GCM();
//        $registatoin_ids = $regId;
//        $message = array("booking" => $message);
//        $result = $gcm->send_notification($registatoin_ids, $message);
        echo "reloadbooking done <a href='booking_list.php'>View Booking List</a>";
        break;
    case "cancelbooking":
        $booking_id = $_POST['booking_id'];
        $reason = $_POST['reason'];
        $employee_id = $_SESSION['executive_id'];
        $sql1 = "insert into `cancel` value('','','$booking_id','$reason','','$employee_id','1')";
        $result1 = mysql_query($sql1) or die(mysql_error());

        $arr['status'] = 99;

        $objConnect->update("booking", $arr, "id=$booking_id");
        $result = $objConnect->selectWhere("booking", "id=$booking_id ");
$num = $objConnect->total_rows();
if ($num) {
    
        $row = $objConnect->fetch_assoc();
    $result1 = $objConnect->selectWhere("vehicle", "id=" . $row['vehicle_id']);
    $row1 = $objConnect->fetch_assoc();
    include_once '../api/GCM.php';
    $gcm = new GCM();
    $registatoin_ids = array($row1['device_token']);
    $message = array("cancelcustomer" => $booking_id);
     $result = $gcm->send_notification($registatoin_ids, $message);
}
       echo "redirectBooking Canceled URL".BASE_PATH."/booking/booking_list.php    ";
        break;
    case "editbooking":
        $number = $_POST['id'];
        $result = $objConnect->selectWhere('booking', "`id`='$number' ");
        $row = mysql_fetch_assoc($result);
        $customer_id=$row['customer_id'];
        $result1 = $objConnect->selectWhere('customer', "`id`='$customer_id' ");
        $row1 = mysql_fetch_assoc($result1);

        $organization_id=$row1['organization_id'];

        $result2 = $objConnect->selectWhere('organization', "`id`='$organization_id' ");
        $row2 = mysql_fetch_assoc($result2);

        $row['organization']=$row2['name'];
        $row['organization_address']=$row2['address'];
        $row['organization_email']=$row2['email'];

	//$row['organization']=$row['customer_organization'];
        $row['address']=$row['customer_address'];
        $row['customer_category']=$row['customer_category'];
        $row['total_fare_edit']=$row['total_fare'];
        print_r(json_encode($row));
        break;
    case "update_booking":
          $today = date("Y-m-d H:i:s");
        $_POST['customer_id'] = trim($_POST['customer_id']);
        $sql3 = "select * from customer where(customer_number='" . $_POST['phone'] . "')";
        $result3 = mysql_query($sql3) or die(mysql_error());
        $num3 = mysql_num_rows($result3);
        if ($num3) {
            $row3 = mysql_fetch_assoc($result3);
            $_POST['customer_id'] = $row3['id'];
        } else {
            $_POST['customer_id'] = "";
        }
        if ($_POST['customer_id'] == "") {
            $arr['customer_name'] = $_POST['firstname'];
            $arr['customer_number'] = $_POST['phone'];
            $arr['customer_email'] = $_POST['email'];
            $arr['customer_category'] = $_POST['customer_category'];
            $arr['customer_address'] = $_POST['address'];
            $arr['customer_organization'] = $_POST['organization'];
            $arr['added_on'] = $today;
            $arr['added_by'] = $_SESSION['executive_id'];
            $arr['status'] = 1;
            $result1 = $objConnect->insert("customer", $arr);
            $_POST['customer_id'] = $result1;
        }
         unset($_POST['organization_id']);
         unset($_POST['organization_address']);
         unset($_POST['organization_email']);
        $_POST['city_id']= $_SESSION['dash_city'];
        $_POST['pickup_date'];
        $_POST['pickup_date'] = changeFormat("d/m/Y H:i", "Y-m-d H:i:s", $_POST['pickup_date']);
        $_POST['customer_organization'] = $_POST['organization'];
        unset($_POST['organization']);
        $_POST['customer_address'] = $_POST['address'];
        unset($_POST['address']);
        $_POST['employee_booking_id'] = $_SESSION['executive_id'];
       // $_POST['status'] = -3;
        $today = date("Y-m-d H:i:s");
        //$_POST['booking_time'] = $today;
       // print_r($_POST); exit;
        if($_POST['total_exp_fare'] != '' && $_POST['total_exp_fare'] != 0 ){ $_POST['total_fare'] = $_POST['total_exp_fare']; }
        unset($_POST['total_exp_fare']);
        $booking_id=$_POST['id'];
        $result = $objConnect->update("booking", $_POST,"id=$booking_id");
        $result2 = $objConnect->selectWhere('booking', "id=$booking_id");
        $num2 = $objConnect->total_rows();
        $row2 = $objConnect->fetch_assoc();
        $rowx = $objConnect->selectWhere("favorite_location", "current_location like '" . $row2['current_location']."' and type='pickup'");
        $numx = $objConnect->total_rows();
        if (!$numx) {
            $newarray['customer_id'] = $row2['customer_id'];
            $newarray['type'] = "pickup";
            $newarray['pick_up_name'] = $row2['pick_up_name'];
            $newarray['pick_up_no'] = $row2['pick_up_no'];
            $newarray['pick_up_organization'] = $row2['pick_up_organization'];
            $newarray['current_location'] = $row2['current_location'];
            $newarray['pick_up_landmark'] = $row2['pick_up_landmark'];
            $newarray['pickup_lat'] = $row2['pickup_lat'];
            $newarray['pickup_lng'] = $row2['pickup_lng'];
            $newarray['booking_id'] = $row2['id'];
            $newarray['booking_time'] = $row2['booking_time'];
            $newarray['last_updated'] = date("Y-m-d H:i:s");
            $newarray['status'] = 0;
			$insertx = $objConnect->insert("favorite_location", $newarray);
        }
        $rowx = $objConnect->selectWhere("favorite_location", "  current_location like '" . $row2['drop_location'] . "' and type='drop'");
        $numx1 = $objConnect->total_rows();

        if (!$numx1) {       
            $newarray['customer_id'] = $row2['customer_id'];
            $newarray['type'] = "drop";
            $newarray['pick_up_name'] = $row2['drop_name'];
            $newarray['pick_up_no'] = $row2['drop_number'];
            $newarray['pick_up_organization'] = $row2['drop_organization'];
            $newarray['current_location'] = $row2['drop_location'];
            $newarray['pick_up_landmark'] = $row2['drop_landmark'];
            $newarray['pickup_lat'] = $row2['drop_lat'];
            $newarray['pickup_lng'] = $row2['drop_lng'];
            $newarray['booking_id'] = $row2['id'];
            $newarray['booking_time'] = $row2['booking_time'];
            $newarray['last_updated'] = date("Y-m-d H:i:s");
            $newarray['status'] = 0;
            $insertx = $objConnect->insert("favorite_location", $newarray);
        }
        $mobileno = $_POST['phone'];
        $result5 = $objConnect->selectWhere("vehicle_category", "id=" . $_POST['vehicle']);
        $row5 = $objConnect->fetch_assoc();
        $message = "Booking Updated for " . $row5['name'] . " on " . date("d/m/Y h:i a", strtotime($_POST['pickup_date'])) . " Booking id " . sprintf("%07d", $result) . ". We will revert with the confirmation and driver details soon. Thank you - MaalGaadi.";
        $senderid = "101010";
       // sendsms($mobileno, $message, $senderid);
        echo "reloadbooking done <a href='booking_list.php'>View Booking List</a>";
        break;
}
?>
