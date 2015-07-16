<?php
include '../includes/define.php';
include_once "../api/GCM.php";

//echo $_SESSION['executive_position'];
$employee_id = $_SESSION['executive_id'];
$today = date("Y-m-d H:i:s", strtotime("+63 min"));
$twominuit = strtotime("-3 min");
//$searchx = " and booking.employee_assign_id='$employee_id'  ";

$sql = "select booking.*,employee.name as employeename , employee.id as emp_id from booking left join employee on employee_assign_id=employee.id  where booking.pickup_date <='$today' and (booking.status<=1 or booking.status=33 )  ";

$result = $objConnect->execute($sql);
if ($result) {
    while ($row = mysql_fetch_assoc($result)) {
//        echo "<li style='width:100%'>" . $row['id'] . "-" . $row['status'] . "-" . $row['emp_id'] . "</li>";
        $booking_id = $row['id'];
        $vehicle_category = $row['vehicle'];

        $last_updated = strtotime($row['last_updated']);
        $min = date("Y-m-d H:i:s", strtotime("-3 min"));
        $timethreemin = strtotime($min);
        if (($row['status'] == -3) && ($_SESSION['executive_position'] == "admin")) {
            if (isset($distance)) {
                unset($distance);
            }
            $distance = array();
            $sql1 = "select vehicle_category.name as cat, location.addedon,location.latitute,location.longitude,location.vehicle_id from location,vehicle,vehicle_category where vehicle.status=1 and location.addedon>'$min' and location.vehicle_id=vehicle.id and  vehicle.category like vehicle_category.name and location.batterystatus>20 and vehicle_category.id=$vehicle_category group by location.vehicle_id";
            $result1 = $objConnect->execute($sql1);
            while ($row1 = $objConnect->fetch_assoc()) {
                $latitude = $row1['latitute'];
                $longitude = $row1['longitude'];
                $pickup_latitude = $row['pickup_lat'];
                $pickup_longitude = $row['pickup_lng'];
                $dLat = deg2rad($latitude - $pickup_latitude);
                $dLon = deg2rad($longitude - $pickup_longitude);
                $dLat1 = deg2rad($pickup_longitude);
                $dLat2 = deg2rad($longitude);
                $a = sin($dLat / 2) * sin($dLat / 2) + cos($dLat1 / 2) * cos($dLat1 / 2) * sin($dLon / 2) * sin($dLon / 2);
                $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                $d = 6371000 * $c;
                $distance[] = array("distance" => $d, "vehicle_id" => $row1['vehicle_id']);
            }
            if (!empty($distance)) {
                array_multisort($distance);
                if ($distance[0]["distance"] <= 1000) {
                    $vehicle = $distance[0]['vehicle_id'];
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
                    $arr['status'] = -2;
                    $arr['last_updated'] = date("Y-m-d h:i:s");
                    $objConnect->update("booking", $arr, "id=" . $row['id']);
                    $brr['booking_id'] = $row['id'];
                    $brr['vehicle_id'] = $vehicle;
                    $brr['added_on'] = date("Y-m-d H:i:s");
                    $brr['status'] = 1;
                    $objConnect->insert("alert", $brr);
                } else {
                    $arr['status'] = -2;
                    $arr['last_updated'] = date("Y-m-d h:i:s");
                    $objConnect->update("booking", $arr, "id=" . $row['id']);
                }
            } else {
                $arr['status'] = -2;
                $arr['last_updated'] = date("Y-m-d h:i:s");
                $objConnect->update("booking", $arr, "id=" . $row['id']);
            }
        } elseif (($row['status'] == -2) && ($_SESSION['executive_position'] == "admin")) {
            if ($last_updated < $timethreemin) {
                if (isset($distance)) {
                    unset($distance);
                }
                $distance = array();
               // $sql1 = "select location.addedon,location.latitute,location.longitude,location.vehicle_id from location,vehicle,vehicle_category where location.vehicle_id not in (select vehicle_id from alert where booking_id=$booking_id ) and location.batterystatus>20 and vehicle.status=1 and location.addedon>'$min' and vehicle.category like vehicle_category.name and location.vehicle_id=vehicle.id and  vehicle_category.id=$vehicle_category group by location.vehicle_id";
				 $sql1 = "select location.addedon,location.latitute,location.longitude,location.vehicle_id from 
location,vehicle,vehicle_category ,alert where 
location.vehicle_id=alert.vehicle_id and alert.booking_id!=$booking_id and location.batterystatus>20 and vehicle.status=1 and location.addedon>'$min' 
and vehicle.category like vehicle_category.name and location.vehicle_id=vehicle.id and vehicle_category.id=$vehicle_category group by location.vehicle_id";
                $result1 = $objConnect->execute($sql1);
                while ($row1 = $objConnect->fetch_assoc()) {
                    $latitude = $row1['latitute'];
                    $longitude = $row1['longitude'];
                    $pickup_latitude = $row['pickup_lat'];
                    $pickup_longitude = $row['pickup_lng'];
                    $dLat = deg2rad($latitude - $pickup_latitude);
                    $dLon = deg2rad($longitude - $pickup_longitude);
                    $dLat1 = deg2rad($pickup_longitude);
                    $dLat2 = deg2rad($longitude);
                    $a = sin($dLat / 2) * sin($dLat / 2) + cos($dLat1 / 2) * cos($dLat1 / 2) * sin($dLon / 2) * sin($dLon / 2);
                    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                    $d = 6371000 * $c;
                    $distance[] = array("distance" => $d, "vehicle_id" => $row1['vehicle_id']);
                }
                if (!empty($distance)) {
                    array_multisort($distance);
                    if ($distance[0]["distance"] <= 1000) {
                        $vehicle = $distance[0]['vehicle_id'];
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

                        $crr['booking_id'] = $booking_id;
                        $crr['booking_status'] = 0;
                        $crr['addedon'] = date("Y-m-d h:i:s");
                        $crr['status'] = 1;
                        $objConnect->insert("notification", $crr);

                        $arr['status'] = 0;
                        $arr['last_updated'] = date("Y-m-d h:i:s");
                        $objConnect->update("booking", $arr, "id=" . $row['id']);
                        $brr['booking_id'] = $row['id'];
                        $brr['vehicle_id'] = $vehicle;
                        $brr['added_on'] = date("Y-m-d H:i:s");
                        $brr['status'] = 1;
                        $objConnect->insert("alert", $brr);
                    } else {
                        $crr['booking_id'] = $booking_id;
                        $crr['booking_status'] = 0;
                        $crr['addedon'] = date("Y-m-d h:i:s");
                        $crr['status'] = 1;
                        $objConnect->insert("notification", $crr);

                        $arr['status'] = 0;
                        $arr['last_updated'] = date("Y-m-d h:i:s");
                        $objConnect->update("booking", $arr, "id=" . $row['id']);
                    }
                } else {
                    $crr['booking_id'] = $booking_id;
                    $crr['booking_status'] = 0;
                    $crr['addedon'] = date("Y-m-d h:i:s");
                    $crr['status'] = 1;
                    $objConnect->insert("notification", $crr);

                    $arr['status'] = 0;
                    $arr['last_updated'] = date("Y-m-d h:i:s");
                    $objConnect->update("booking", $arr, "id=" . $row['id']);
                }
            }
        } elseif ($row['status'] == 0) {
            if ($last_updated < $timethreemin) {
                $sixmin = date("Y-m-d H:i:s", strtotime("-5 min"));
                $timesixmin = strtotime($sixmin);
                $class = "";
                if ($last_updated < $sixmin) {
                    $class = "redbg";
                }
                $result4 = $objConnect->selectWhere("notification", "booking_id=$booking_id and booking_status=0 and status=1");
                $row4 = $objConnect->fetch_assoc();
                ?>
                <li class="show_logs_li <?php echo $class; ?>">
                    <div class="show_tag">

                        <div class="booking_icon">
                            <div class="show_timer"><time class="age" datetime="<?php echo $row['pickup_date']; ?>"></time></div>
                        </div>
                        <div class="show_logcontent">Booking id <?php echo sprintf("%07d", $row['id']); ?> has no Driver to assign Allot Employee
                           <div class="">Time : <?php echo $row4['addedon']; ?></div>
                            <?php
                            if ($_SESSION['executive_position'] == "admin") {
                                ?><a href="<?php echo BASE_PATH; ?>assign/to_employee.php?booking=<?php echo $row['id']; ?>" class="btn btn-warning">Allot Employee</a>
                                <?php
                            }
                            ?>
                            <input type="button" class="btn btn-success " onclick="accept_booking(<?php echo $row['id']; ?>)" value="Accept"/>
                        </div>
                    </div>
                </li>
                <?php
            }
        } elseif (($row['status'] == 1) && ((($_SESSION['executive_position'] == "admin")) || ($employee_id == $row['emp_id']))) {
         
                $sixmin = date("Y-m-d H:i:s", strtotime("-5 min"));
                $timesixmin = strtotime($sixmin);
                $class1 = "";
                if ($last_updated < $sixmin) {
                    $class1 = "redbg";
                }
                $result4 = $objConnect->selectWhere("notification", "booking_id=$booking_id and booking_status=1 and status=1");
                $row4 = $objConnect->fetch_assoc();
                ?>
                <li class="show_logs_li <?php echo $class1; ?>">
                    <div class="show_tag">      
                        <div class="booking_icon">
                            <div class="show_timer"><time class="age" datetime="<?php echo $row['pickup_date']; ?>"></time></div>
                        </div>
                        <div class="show_logcontent">Booking id <?php echo sprintf("%07d", $row['id']); ?> has no Driver to assign, please assign manually , Alloted To <?php echo $row['employeename']; ?><br> 
                           <div class="">Time : <?php echo $row4['addedon']; ?></div>
                            <?php if ($_SESSION['executive_position'] == "admin") {
                                ?><a href="<?php echo BASE_PATH; ?>assign/to_employee.php?booking=<?php echo $row['id']; ?>" class="btn btn-warning">Allot Employee</a>
                                <?php
                            }
                            if (($employee_id == $row['employee_assign_id'])||($_SESSION['executive_position'] == "admin")) {
                                ?>
                                <a href="<?php echo BASE_PATH; ?>assign/to_driver.php?booking=<?php echo $row['id']; ?>" class="btn btn-success">To Driver</a>
                            <?php } ?>
                        </div>
                    </div>
                </a>
                </li>
                <?php
            
        } elseif ($row['status'] == 33) {
            $result4 = $objConnect->selectWhere("notification", "booking_id=$booking_id and booking_status=33 and status=1");
            $row4 = $objConnect->fetch_assoc();
            $result5 = $objConnect->selectWhere("breakdown", "booking_id=$booking_id  and status=1");
            $row5 = $objConnect->fetch_assoc();
                $class = "";
                if ($last_updated < $timethreemin) {
                    $class2 = "redbg";
                }
            ?>

            <li class="show_logs_li <?php echo $class2; ?>">
                <div class="show_tag">      
                    <div class="booking_icon">
                        <div class="show_timer"><time class="age" datetime="<?php echo $row['pickup_date']; ?>"></time></div>
                    </div>
                   
                    <div class="show_logcontent">Booking id <?php echo sprintf("%07d", $row['id']); ?> has A Break Down at <?php echo getAddress($row5['latitude'], $row5['longitude']); ?>,Please Process<br> 
                         <div class="">Time : <?php echo $row4['addedon']; ?></div>
                        <a href="<?php echo BASE_PATH; ?>assign/breakdown.php?booking=<?php echo $row['id']; ?>" class="btn btn-warning">Manage</a>
                    </div>
                </div>

            </li>
            <?php
        }
        elseif ($row['status'] == 34) {
            $result4 = $objConnect->selectWhere("notification", "booking_id=$booking_id and booking_status=33 and status=1");
            $row4 = $objConnect->fetch_assoc();
            $result5 = $objConnect->selectWhere("reassigndetail", "booking_id=$booking_id  order by datetime desc");
            $row5 = $objConnect->fetch_assoc();
                $class = "";
                if ($last_updated < $timethreemin) {
                    $class2 = "redbg";
                }
            ?>

            <li class="show_logs_li <?php echo $class2; ?>">
                <div class="show_tag">      
                    <div class="booking_icon">
                        <div class="show_timer"><time class="age" datetime="<?php echo $row['pickup_date']; ?>"></time></div>
                    </div>
                   
                    <div class="show_logcontent">Booking id <?php echo sprintf("%07d", $row['id']); ?> has A Break Down at <?php echo getAddress($row5['latitude'], $row5['longitude']); ?>,Please Process<br> 
                         <div class="">Time : <?php echo $row4['addedon']; ?></div>
                        <a href="<?php echo BASE_PATH; ?>assign/breakdown.php?booking=<?php echo $row['id']; ?>" class="btn btn-warning">Manage</a>
                    </div>
                </div>

            </li>
            <?php
        }
    }
}


    