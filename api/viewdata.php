<?php include '../includes/define.php'; ?>
<html><head>
        <?php include '../includes/head.php'; ?>
    </head>
    <body data-base="<?php echo BASE_URL; ?>">
        <?php include '../includes/header.php'; ?>
        <div class="crumbs">
            <ul id="breadcrumbs" class="breadcrumb">
                <li>
                    <a href="<?php echo BASE_URL; ?>" title="<?php echo BASE_URL; ?>">Home</a>		                
                </li>
                <li>
                    <a href="<?php echo BASE_URL; ?>/settlement/driver_remaining.php" title="">Driver Remaining</a>		                
                </li>
                <li class="active"><a title=""> Daily Settlement </a></li>
            </ul>
        </div>
        <div class="content_middle mt15">    
            <form method="post" id="searchform">
                <table>
                    <tr>
                        <td valign="top" width="20%" class="mtb"><label>Select Vehicle</label><span class="star">*</span></td>
                        <td>
                            <div class="new_input_field" style="">
                                <select name="vehicle" required="true">
                                    <option value="<?php echo $_POST['vehicle'];?>">Select Vehicle</option>
                                    <?php
									$objConnect->dbConnect();
                                    $result = $objConnect->select("vehicle");
                                    while ($row = $objConnect->fetch_assoc()) {
                                        ?>
                                        <option <?php if((isset($_POST['vehicle']))&&($_POST['vehicle'] == $row['id'])){echo 'selected="selected"';}?> value="<?php echo $row['id']; ?>"><?php echo $row['name'] . ", " . $row['registration_no']; ?></option>
                                            <?php
                                        }
                                        ?>
                                </select>
                            </div>
                        </td>

                    </tr>
                    <tr>
                        <td valign="top" width="20%" class="mtb"><label>Start Date</label><span class="star">*</span></td>        
                        <td class="mtb">
                            <div class="new_input_field">
                                <input type="text" title="Satrt Date From the booking should be search" id="startDate" value="<?php echo $_POST['startDate']; ?>" required name="startDate" readonly />
                            </div>
                        </td>
                        <td valign="top" width="20%" class="mtb"><label>End Date</label><span class="star">*</span></td>        
                        <td class="mtb">
                            <div class="new_input_field">
                                <input type="text" title="End Date To the booking should be search" id="endDate"  value="<?php echo $_POST['endDate']; ?>" name="endDate" required readonly />
                            </div>
                        </td>

                    </tr>
                    <tr><td colspan="2" >
                            <input type="submit" class="btn btn-success btn-large mt15" value="search"/>
                        </td></tr>
                </table>
            </form>
        </div>
<?php if (isset($_POST['vehicle'])) { ?>
            <div class="content_middle mt15">    
                <table id="example" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Login Time</th>
                            <th>Login Location</th>
                            <th>Logout Time</th>
                            <th>Logout Location</th> 
                            <th>Log In Hours</th>
                            <th>Driver</th>
                            <th>Billed Kms</th>
                            <th>Un-billed Kms</th>
                            <th>Total Distance Travelled</th>
                            <th>No. of Trips</th>
                            <th>Fare</th>
                            <th>Loading Amount</th>
                            <th>Unloading Amount</th>
                            <th>Fare Collected</th>
    <!--                            <th>Action</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $start_date = changeFormat("d/m/Y", "Y-m-d", $_POST['startDate']) . " 00:00:00";
                        $end_date = changeFormat("d/m/Y", "Y-m-d", $_POST['endDate']) . " 23:59:59";
						$objConnect->dbConnect();
                        $sql = "select vehicle.*, login.login_time,login.logout_time,login.login_latitute,login.login_logitude,login.logout_latitute,login.logout_longitude,driver.name as dname,login.distance from vehicle inner join login on vehicle.id=login.vehicle_id inner join driver on driver.id=login.driver_id where date(login.login_time) between '" . $start_date . "' and '" . $end_date . "' and login.vehicle_id='" . $_POST['vehicle'] . "'";
                        $result = mysql_query($sql) or die(mysql_error());
                        $total_billed_km=0;
                        $total_unbiiled_km=0;
                        $total_km=0;
                        $total_no_of_trips=0;
                        $total_fare=0;
                        $total_loading_amount=0;
                        $total_unloading_amount=0;
                        $total_fare_collected=0;
                        while ($row = mysql_fetch_assoc($result)) {
							$objConnect->dbConnect();
                                $sql1 = "select booking_id from booking_logs where datetime between '" . $row['login_time'] . "' and '" . $row['logout_time'] . "' and status like 'start to customer' and vehicle_id='" . $_POST['vehicle'] . "' order by datetime asc group by booking_id";
                            $result1 = $objConnect->execute($sql1);
                            $book_id = "";
                            $book_id_show = "";
                            $no_of_trip = 0;
                            while ($row1 = $objConnect->fetch_assoc()) {
                                if ($book_id == "") {
                                    $book_id.=$row1['booking_id'];
                                    $book_id_show = "<a href='../booking/booking_details.php?booking=" . $row1['booking_id'] . "' target='_blank'>" . sprintf('%07d', $row1['booking_id']) . "</a>";
                                } else {
                                    $book_id.="," . $row1['booking_id'];
                                    $book_id_show = "," . "<a href='../booking/booking_details.php?booking=" . $row1['booking_id'] . "' target='_blank'>" . sprintf('%07d', $row1['booking_id']) . "</a>";
                                }
                                $no_of_trip++;
                            }
                            $loading_charge = 0;
                            $unloading_charge = 0;
                            if(isset($row2)){
                                unset($row2);
                            }
                            $row2=array();
                            if ($book_id != "") {
								$objConnect->dbConnect();
                                    $sql2 = "select sum(distance_to_customer) as distancetocustomer, sum(total_payment_amount) as total_payment_amount, sum(payment) as totalpayment,sum(trip_distance) as tripdistance from booking_short where booking_id in ($book_id)";
                                
                                $result2 = $objConnect->execute($sql2);
                                $row2 = $objConnect->fetch_assoc();
								$objConnect->dbConnect();
                                $sql3 = "select * from booking where id in ('$book_id')";
                                $result3 = $objConnect->execute($sql3);
                                while ($row3 = $objConnect->fetch_assoc()) {
                                    if ($row3['loading'] == "true") {
                                        $loading_charge+=$row3['loading_charge'];
                                    }
                                    if ($row3['unloading'] == "true") {
                                        $unloading_charge+=$row3['loading_charge'];
                                    }
                                }
                            }
                            ?>
                            <tr>
                                <td><?php  echo date("d/m/Y", strtotime($row['login_time'])); ?></td>
                                <td><?php echo changeFormat("Y-m-d H:i:s", "d/m/Y H:i:s", $row['login_time']); ?></td>
                                <td><?php $objConnect->dbConnect(); echo getAddress($row['login_latitute'], $row['login_longitute']); ?></td>
                                <td><?php echo changeFormat("Y-m-d H:i:s", "d/m/Y H:i:s", $row['logout_time']); ?></td>
                                <td><?php echo getAddress($row['logout_latitute'], $row['logout_longitute']); ?></td>
                                <td><?php
                                    $seconds = strtotime($row['logout_time']) - strtotime($row['login_time']);

                                    echo $days = floor($seconds / 86400);
                                    echo " Days ";
                                    echo $hours = floor(($seconds - ($days * 86400)) / 3600);
                                    echo " Hours ";
                                    echo $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600)) / 60);
                                    echo " Minutes";
                                    ?></td>
                                <td><?php echo $row['dname']; ?></td>
                                <td><?php echo $billed_km= round((($booking_distance = round($row2['distancetocustomer'], 2) + round($row2['tripdistance'], 2)) / 1000), 2); $total_billed_km+=$billed_km;?></td>
                                <td><?php echo $unbilled_km=round((($unbilled = round($row['distance'], 2) - $booking_distance) / 1000), 2); $total_unbilled_km+=$unbilled_km;?></td>
                                <td><?php echo $km=round(((round($row['distance'], 2)) / 1000), 2); $total_km+=$km;?></td>
                                <td><?php echo $no_of_trip ;$total_no_of_trip+=$no_of_trip; ?></td>

                                <td><?php echo $fare=round(($fare = $row2['total_payment_amount'] - ($loading_charge + $unloading_charge)), 2); $total_fare+=$fare;?> </td>

                                <td><?php echo $loading_charge;$total_loading_charge+=$loading_charge; ?></td>
                                <td><?php echo $unloading_charge;$total_unloading_charge+=$unloading_charge; ?></td>

                                <td><?php echo $fare_collected=$row2['totalpayment'];$total_fare_collected+=$fare_collected; ?></td>


                            </tr>
        <?php
    }
    ?>
                            <tr>
                                <th>Total</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            <th><?php echo $total_billed_km;?></th>
                            <th><?php echo $total_unbilled_km;?></th>
                            <th><?php echo $total_km;?></th>
                            <th><?php echo $total_no_of_trip;?></th>
                            <th><i class="fa fa-rupee"></i><?php echo $total_fare;?></th>
                            <th><i class="fa fa-rupee"></i><?php echo $total_loading_charge;?></th>
                            <th><i class="fa fa-rupee"></i><?php echo $total_unloading_charge;?></th>
                            <th><i class="fa fa-rupee"></i><?php echo $total_fare_collected;?></th>
                            </tr>
                    </tbody>
                </table>
            </table>

            <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
        </div>

        <script src="<?php echo BASE_PATH; ?>js/jquery.dataTables.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="<?php echo BASE_PATH; ?>css/jquery.dataTables.css">
    <!--dtat tabl-->
    <style>
        tfoot {
            display: table-header-group;
        }
    </style>
    <script>
        $("#example").DataTable();
    </script>
<?php } ?>
<?php include '../includes/footer.php'; ?>
<script>
    $(document).ready(function () {
        $("#startDate").datepicker({
            dateFormat: 'dd/mm/yy',
            showOtherMonths: true,
            changeMonth: true,
            changeYear: true


        });
        $("#endDate").datepicker({
            dateFormat: 'dd/mm/yy',
            showOtherMonths: true,
            changeMonth: true,
            changeYear: true

        });
    });
</script>
</body>
</html> 