<?php
include '../includes/define.php';
verifyLogin();
?>
<html>
    <head>
        <?php include '../includes/head.php'; ?>
        <style>
            #footer{
                bottom:0 !important;  
            }
            table{
/*                border-left: 1px solid black; 
                 border-top: 1px solid black; */
            }
            td,th{
/*                border-right: 1px solid black; 
                 border-bottom: 1px solid black;*/
                 vertical-align: top;
                 min-height: 16px;
                 font-family: arial;
            }
        </style>
    </head>
    <body data-base="<?php echo BASE_URL; ?>">
        
        <div class="container_content">
            
<?php 
$id=$_GET['booking'];
$result=$objConnect->selectWhere("booking","id=$id");
$row=$objConnect->fetch_assoc();
$result1=$objConnect->selectWhere("booking_short","booking_id=$id");
$row1=$objConnect->fetch_assoc();
$result2=$objConnect->selectWhere("booking_logs","booking_id=$id and status like 'reached to customer'");
$row2=$objConnect->fetch_assoc();
$pickup_date=date("d/m/Y H:i:s",strtotime($row2['datetime']));
$result3=$objConnect->selectWhere("booking_logs","booking_id=$id and status like 'stop trip'");
$row3=$objConnect->fetch_assoc();
$drop_date=date("d/m/Y H:i:s",strtotime($row3['datetime']));

?>
            <div class="cont_container mt15 mt10">
                <div class="content_middle"> 
                    
                         <div id="printInvoice">
                        <table style="width: 100%;">
                            <tr>
                                <td colspan="4" style="border-right: none; padding-top: 22px; line-height: 20px">
                                    <strong>Invoice No: Mg <?php echo sprintf("%03d", $row['id']); ?></strong><br/>
                                    <strong>Date: <?php echo $row3['datetime']; ?></strong>
                                </td>
                                <td colspan="2" style="text-align: right; ">
                                    <img src="<?php echo BASE_URL; ?>/images/maalgaadi.png">
                                </td>
                            </tr>
                            
                            <tr>
                                <td colspan="6" style="text-align: center;border: 1px solid black; background: #0a2b6e;border-bottom: 5px solid #fec60f; color: #fff; padding: 7px 0">
                                    <h2 style="font-size: 23px">
                                        <?php
                                        if (($row['customer_organization'] != "NA") && (!empty($row['customer_organization']))) {
                                            echo $row['customer_organization'];
                                            ?><?php
                                        } else {
                                            echo $row['firstname'];
                                        }
                                        ?></h2></td>
                               
                            </tr>
                            <tr>
                                <td colspan="6">
                                    <table style="width:96%; margin: 20px auto 0">
                                        <tr>
                                <td style=" width: 70%;text-align: center;border: 1px solid #ccc; border-right: none; color: #000">
                                    <div style="  padding-top: 20px; margin-top: -1px">
                                    <?php
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
                                    ?>
                                        <h3 style="font-size: 23px;">Total Amount: <br /><span style="font-size:50px; line-height: 60px"><?php echo $row1['total_payment_amount']; ?></span></h3>
                                    <h3 style="line-height:35px; font-size: 18px">Total Freight: <?php echo $row1['total_payment_amount'] - $loading - $unloading; ?></h3>

                                    <h3 style="line-height:35px; font-size: 18px">Charges for Loading: <?php echo $loading; ?></h3>
                                    <h3 style="line-height:35px; font-size: 18px; margin-bottom: 10px">Charges for Unloading: <?php echo $unloading; ?></h3>
                                    </div>
                                    
                                    <table style="width: 100%; font-size: 10px">
                                        <tr><th> MONEY DEDUCTED (For prepaid cust)</th><th>DISCOUNT</th><th>PAYABLE AMOUNT</th></tr>
                                        <tr><td style="text-align: center">0.0</td><td style="text-align: center">0.0</td><td style="text-align: center"><?php echo $row1['total_payment_amount']; ?></td></tr>
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
                                                            <td><span style="font-size:15px"><?php echo $row['model_minfare']; ?></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Fare for First 10 Km. :</strong></td>
                                                            <td><span style="font-size:15px"><?php echo $row['firstten']; ?></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Fare for Post 10 Km. :</strong></td>
                                                            <td><span style="font-size:15px"><?php echo $row['rate']; ?></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Fare per hour :</strong></td>
                                                            <td><span style="font-size:15px"><?php echo $row['wait_time_charge']; ?></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Fare for Loading/Unloading:</strong></td>
                                                            <td><span style="font-size:15px"><?php echo $row['loading_charge']; ?>/<?php echo $row['loading_charge']; ?></span></td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style="padding:10px 5px 20px; font-size:15px">
                                                    <table style="width:100%; color: #333">
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Booking Id:</strong></td>
                                                            <td><span style="font-size:15px"><?php echo sprintf("%7d", $row['id']); ?></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Service Type :</strong></td>
                                                            <td><span style="font-size:15px"><?php echo $row['vehicle']; ?></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Total Distance  :</strong></td>
                                                            <td><span style="font-size:15px"><?php echo $row1['trip_distance'] / 1000; ?> Km</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Total Time :</strong></td>
                                                            <td><span style="font-size:15px"><?php echo $row1['wait_time']; ?> min</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Pickup Date and Time :</strong></td>
                                                            <td><span style="font-size:15px"><?php echo $pickup_date; ?></span></td>
                                                         </tr>
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Drop Date and Time :</strong></td>
                                                            <td><span style="font-size:15px"><?php echo $drop_date; ?></span></td>
                                                         </tr>
                                                        <tr>
                                                            <td><strong style="font-size:15px; line-height: 25px">Person Contact Number :</strong></td>
                                                            <td><span style="font-size:15px"><?php echo $row['phone']; ?></span></td>
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
                                                301, Laxmi Tower, M.G. Road, Indore M. P. -  452018		<br>					
                                                Tel : +91 731 4256866					<br>		
                                                AVPS Transort						<br>	

                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            
                        </table>
                        <?php
                        $id = $_GET['booking'];
                        $result = $objConnect->selectWhere("booking", "id=$id");
                        $row = $objConnect->fetch_assoc();


                        $row6 = "";
                        ?>
                        <!-- Start Book-Now -->
                        <script type="text/javascript" src="http://maps.google.com/maps/api/js?libraries=geometry&sensor=false&v=3.3"></script>
                        <script>
                            var markers = [];
                            var bounds = new google.maps.LatLngBounds();
                            var c = bounds;
                        </script>
                        <?php
                        $result55 = $objConnect->selectWhere("booking_logs", "booking_id=" . $row['id'] . " and status='start trip'");
                        $num55 = $objConnect->total_rows();
                        if ($num55) {
                            $row55 = $objConnect->fetch_assoc();
                            $dateofbooking = date("Y-m-d", strtotime($row55['datetime']));
                            $today = date("Y-m-d");
                            if ($dateofbooking == $today) {
                                $sql3 = "select location.latitute,location.longitude from location where booking_id=$id and status='start trip'";
                                $result3 = $objConnect->execute($sql3);
                            } else {
                                $currentmonth = strtolower(date("FY", strtotime($row55['datetime'])));
                                $sql3 = "select $currentmonth.latitute,$currentmonth.longitude from $currentmonth where booking_id=$id and status='start trip'";
                                $result3 = $objConnect->execute($sql3);
                            }
                        } else {
                            $sql3 = "select location.latitute,location.longitude from location where booking_id=$id and status='start trip'";
                            $result3 = $objConnect->execute($sql3);
                        }

                        $location3 = array();
                        $distance = 0;
                        $i = 0;
                        while ($row3 = mysql_fetch_assoc($result3)) {
                            if ($i == 0) {
                                $start_lati = $row3['latitute'];
                                $start_longi = $row3['longitude'];
                            } else {
                                $last_lati = $row3['latitute'];
                                $last_longi = $row3['longitude'];
                                $dLat = deg2rad($last_lati - $start_lati);
                                $dLon = deg2rad($last_longi - $start_longi);
                                $dLat1 = deg2rad($start_lati);
                                $dLat2 = deg2rad($last_longi);
                                $a = sin($dLat / 2) * sin($dLat / 2) + cos($dLat1 / 2) * cos($dLat1 / 2) * sin($dLon / 2) * sin($dLon / 2);
                                $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
                                $d = 6371 * $c;
                                if ($d < 3) {

                                    $start_lati = $last_lati;
                                    $start_longi = $last_longi;
                                    ?>
                                    <script>

                                        markers.push(new google.maps.LatLng(<?php echo $row3['latitute']; ?>,<?php echo $row3['longitude']; ?>));
                                        bounds.extend(new google.maps.LatLng(<?php echo $row3['latitute']; ?>,<?php echo $row3['longitude']; ?>));</script>      
            <?php
        }
    }
    $i++;
}
?>
                        <script>
                            var total = markers.length;
                            var interval = 1;
                            if (parseInt(total) > 16) {
                                interval = parseInt(parseInt(total) / 8);

                            }

                            var direcpoint = [];
                            for (var i = interval, j = 1; i < total && j <= 8; i = i + interval, j++) {

                                direcpoint.push({location: markers[i]});
                            }

                            var directionsDisplay;
                            var directionsService = new google.maps.DirectionsService();
                            var map;
                            var polyline;
                            function initialize() {

                                var mapOptions = {
                                    zoom: 7,
                                    center: new google.maps.LatLng(41.850033, -87.6500523)
                                };
                                map = new google.maps.Map(document.getElementById('map-canvas'),
                                        mapOptions);

                                directionsDisplay = new google.maps.DirectionsRenderer();


                                //alert(bounds);
                                map.fitBounds(bounds);
                                var start = "<?php echo $row['pick_up_landmark']; ?>";
                                var end = "<?php echo $row['drop_landmark']; ?>";
<?php
$result5 = $objConnect->selectWhere("booking_logs", "booking_id=" . $row['id'] . " and status='start trip'");
$num5 = $objConnect->total_rows();
if ($num5) {
    $row5 = $objConnect->fetch_assoc();
    ?>
                                    start = new google.maps.LatLng(<?php echo $row5['current_latitude']; ?>, <?php echo $row5['current_longitude']; ?>);
    <?php
}
?>
<?php
$result6 = $objConnect->selectWhere("booking_logs", "booking_id=" . $row['id'] . " and status='stop trip'");
$num6 = $objConnect->total_rows();
if ($num6) {
    $row6 = $objConnect->fetch_assoc();
    ?>

                                    end = new google.maps.LatLng(<?php echo $row6['current_latitude']; ?>, <?php echo $row6['current_longitude']; ?>);
    <?php
}
?>
                                var request = {
                                    origin: start,
                                    destination: end,
                                    travelMode: google.maps.TravelMode.DRIVING,
                                    optimizeWaypoints: true,
                                    waypoints: direcpoint
                                };
                                directionsService.route(request, function (response, status) {
                                    if (status == google.maps.DirectionsStatus.OK) {
                                        directionsDisplay.setDirections(response);

                                    }
                                });
                                directionsDisplay.setMap(map);



                            }



                            $(document).ready(function () {
                                google.maps.event.addDomListener(window, 'load', initialize);


                            });

                        </script>
                    </div>
                    </div>
                <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
            </div>
     
        </div>
        
        
        <script>
        $(document).ready(function(){
            setTimeout('window.print()',2000);
            setTimeout('window.close()',3000);
           // window.close();
        });
        </script>
    </body>
</html>