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
        </style>
    </head>
    <body data-base="<?php echo BASE_URL; ?>">
        <?php include '../includes/header.php'; ?>
        <div class="container_content">
            <div class="crumbs">
                <ul id="breadcrumbs" class="breadcrumb">
                    <li>
                        <a href=<?php echo BASE_URL; ?> title=<?php echo BASE_URL; ?>>Home</a>	
                    </li>
                    <li>
                        <a href=booking_list.php title=<?php echo BASE_URL; ?>booking/booking_list.php>Booking List</a>
                    </li>
                    <li class="active"><a title="">Booking Detail</a></li>
                </ul>
            </div>
           
                <div class="cont_container mt15 mt10">
                    <div class="content_middle"> 
                        <?php
                        $id = $_GET['booking'];
                        $result = $objConnect->selectWhere("booking", "id=$id");
                        $row = $objConnect->fetch_assoc();
                        ?>
                        <!-- Start Book-Now -->
                        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
                        <script>
                            var directionsDisplay;
                            var directionsService = new google.maps.DirectionsService();

                            function initialize() {
                                directionsDisplay = new google.maps.DirectionsRenderer();
                                var mapOptions = {
                                    zoom: 7,
                                    center: new google.maps.LatLng(41.850033, -87.6500523)
                                };
                                var map = new google.maps.Map(document.getElementById('map-canvas'),
                                        mapOptions);
                                directionsDisplay.setMap(map);
                                directionsDisplay.setPanel(document.getElementById('directions-panel'));



                            }

                            function calcRoute() {

                                var start = "<?php echo $row['pick_up_landmark']; ?>";
                                var end = "<?php echo $row['drop_landmark']; ?>";
                                var request = {
                                    origin: start,
                                    destination: end,
                                    travelMode: google.maps.TravelMode.DRIVING
                                };
                                directionsService.route(request, function (response, status) {
                                    if (status == google.maps.DirectionsStatus.OK) {
                                        directionsDisplay.setDirections(response);
                                    }
                                });
                            }


                            google.maps.event.addDomListener(window, 'load', initialize);
                            setTimeout("calcRoute()", 2000);
                        </script>
                            <div class="banner">
                                <h2>
                                    Booking Detail
                                </h2>
                        </div>

                        <div style="width:100%">
                            <div class="container">
                                <div class="row-fluid">
                                    <div class="span12">
                                        <div class="my-booking">
                                            <div class="row-fluid">
                                                <div class="span9">
                                                    <div class="book-sec-1">
                                                        <div class="row space2">
                                                            <div class="span6">
                                                                <div class="field-1">
                                                                    <h6>Pick up Address</h6>
                                                                    <p> <?php echo $row['current_location']; ?> </p>
                                                                </div>
                                                            </div>
                                                            <div class="span6">
                                                                <div class="field-1">
                                                                    <h6>Destination Address</h6>
                                                                    <p> <?php echo $row['drop_location']; ?> </p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row space2">
                                                            <div class="span6">
                                                                <div class="field-1">
                                                                    <h6>Date & Time</h6>
                                                                    <p> <?php echo $row['pickup_date']; ?> </p>
                                                                </div>
                                                            </div>
                                                            <div class="span6">
                                                                <div class="field-1">
                                                                    <h6>Contact No.</h6>
                                                                    <p> <?php echo $row['phone']; ?> </p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row space2">
                                                            <div class="span6">
                                                                <div class="field-1">
                                                                    <h6>Pick up Landmark</h6>
                                                                    <p> <?php echo $row['pick_up_landmark']; ?> </p>
                                                                </div>
                                                            </div>
                                                            <div class="span6">
                                                                <div class="field-1">
                                                                    <h6>Destination Landmark</h6>
                                                                    <p> <?php echo $row['drop_landmark']; ?> </p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row space2">
                                                            <div class="span6">
                                                                <div class="field-1">
                                                                    <h6>Chosen Vehicle</h6>
                                                                    <p> <?php
                                                                        $result1 = $objConnect->selectWhere('vehicle_category', "id=" . $row['vehicle']);
                                                                        $row1 = $objConnect->fetch_assoc();
                                                                        echo $row1['name'];
                                                                        ?> </p>
                                                                </div>
                                                            </div>
                                                            <div class="span6">
                                                                <?php 
                                                                if($row['status']==1){
                                                                    echo "Trip not yet started";
                                                                }
                                                                elseif($row['status']==7){
                                                                    ?>
                                                                <a href="">Track Followed Route</a>
                                                                <?php 
                                                                }
                                                                elseif($row['status']>1){
                                                                    
                                                                }
                                                                    ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span3">
                                                    <div class="book-sec-2">
                                                        <div class="row-fluid">
                                                            <div class="span12">
                                                               <div class="cols1">
                                            <p class="txt-style-5"> <span class="style2">Rs.<?php echo $row['total_fare']; ?>/-</span><br/>
                                                <strong>Base Fare</strong>: Rs <?php echo $row['model_minfare']; ?> & Rs<?php echo $row['firstten']; ?>  Per km<br/>
                                                <strong>Fare post 10 kms</strong>: Rs.<?php echo $row['rate']; ?> per km<br/>
                                                <?php if($row['loading']){?><strong>Loading Charge</strong>: Rs.<?php echo $row['loading_charge']; ?> <br/><?php }?>
                                                <?php if($row['unloading']){?><strong>Un Loading Charge</strong>: Rs.<?php echo $row['loading_charge']; ?> <br/><?php }?>
                                                <strong>Distance</strong>: <?php echo $row['distance_km']; ?> Km <br/>
                                            <strong>Trip charge</strong>: Rs.<?php echo $row['trip_fare']; ?> </p>
                                        </div>
                                                                <div class="cols2 truck"> <img src="../uploads/<?php echo $row1['image']?>" alt="" title="" width="150px" onerror="this.src='../images/no-image.png'" /> </div>


                                                                <div class="clearfix"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br/>
                                            <div class="row-fluid" style="display:none !important;">

                                                <div class="span12"> 
                                                    <div id="map-canvas"></div>
                                                    <div id="directions-panel" style="display: none;"></div>
                                                </div>
                                            </div>
                                            <br/>
                                            <div class="row-fluid">
                                                <div class="span12"> 
                                                    <form id="assign_employee" method="post">
                                                        <table border="0" cellspacing="0" cellpadding="5" width="100%">
                                                            <tr>
                                                                <td valign="top" width="20%" class="mtb"><label>Employee</label><span class="star">*</span></td>
                                                                <td>
                                                                    <select name="employee_id" required>
                                                                        <option value="">Select User</option>
                                                                    <?php
                                                                    $result1 = $objConnect->selectWhere('employee', " 1 ");
                                                                    while($row1 = mysql_fetch_array($result1)){ ?>
                                                                        <option value="<?php echo $row1['id']; ?>"><?php echo $row1['name']; ?></option>
                                                                    <?php } ?>
                                                                    </select>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2">
                                                                    <strong>
                                                                    <?php 
                                                                    if($row['status']==1){
                                                                        echo "Employee already assigned, If you Wish to change then submit";
                                                                    }
                                                                    elseif($row['status']>=2){
                                                                        echo "booking already allotted or canceled no need to alot employee ";
                                                                    }
                                                                    ?>
                                                                    </strong>
                                                                    <?php 
                                                                   if($row['status']<2){ 
                                                                    ?>
                                                                    <input type="hidden" name="mode" value="assignEmployee" />
                                                                    <input type="hidden" name="booking_id" value="<?php echo $id; ?>" />
                                                                    <div class="button greenB">  <input type="button" class="my_btn" value="submit" onclick="formSubmit('assign_employee', 'assign_employee_result', 'assign_update.php')" title="submit"></div>
                                                                   <?php }?>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </form>
                                                </div>
                                                <br />
                                                <div class="form_result" id="assign_employee_result"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <style>
                            #map-canvas {
                                height: 400px;
                                margin: 0px;
                                padding: 0px
                            }
                        </style>
                        <!-- End Book-Now -->
                    </div>
                    <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
                </div>
        </div>
        <?php include '../includes/footer.php'; ?>
    </body>
</html>