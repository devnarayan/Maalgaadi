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
                                                                if ($row['status'] == 1) {
                                                                    echo "Trip not yet started";
                                                                } elseif ($row['status'] == 7) {
                                                                    ?>
                                                                    <a href="">Track Followed Route</a>
                                                                    <?php
                                                                } elseif ($row['status'] > 1) {
                                                                    
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
                                                                <div class="cols2 truck"> <img src="../uploads/<?php echo $row1['image'] ?>" alt="" title="" width="150px" onerror="this.src='../images/no-image.png'" /> </div>


                                                                <div class="clearfix"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <br/>
                                            <div class="row-fluid">

                                                <div class="span6"> 
                                                    <div id="map-canvas"></div>
                                                    <div id="directions-panel" style="display: none;"></div>
                                                </div>
                                                <div class="span5">
                                                    <?php if($row['status']<2){?>
                                                    <form action="assign_update.php" mode="post" id="assignDriver">
                                                        <input type="hidden" value="<?php echo $row['id']; ?>" name="booking_id">
                                                        <input type="hidden" name="mode" value="assignToDriver">
                                                        <fieldset class="booking-form-fieldset">
                                                            <legend>Driver List</legend>
                                                            <div id="driver_list">
                                                                <ul>
                                                                    <li> No Favorite Address </li>
                                                                </ul>
                                                            </div>
                                                            <input type="button" class="btn btn-warning edit_btn" onClick="assigndriver()" style="" value="Assign"/> 
                                                            <script>
                                                                function assigndriver() {
                                                                  
                                                                    var x = $('#driver_id').val();

                                                                    if (x == null || x == "") {
                                                                        alert("No driver To assign");
                                                                    }
                                                                    else {
                                                                        formSubmit('assignDriver', 'driverresult', 'assign_update.php');
                                                                    }
                                                                }
                                                            </script>
                                                            <div id="driverresult"></div>
                                                        </fieldset>
                                                    </form>
                                                    <?php }else{
                                                        echo "Driver Already assign";
                                                    }
?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <script>
                            function getNearestDriver(latitude, longitude,vehicle) {
                                $.get("../location/fetchNearestDriver.php?latitude=" + latitude + "&longitude=" + longitude+"&vehicle="+vehicle, function (data) {
                                    // alert(data);
                                    var item = JSON.parse(data);
                                    var driver = "<ul>";
                                    for (var i = 0; i < item.length; i++) {
                                        var cont = item[i];
                                        driver += "<li ><input type='radio' id='driver_id' required name='driver_id' value='" + cont.id + "'><div class='address'>" + cont.name + " (reg no: " + cont.registration_no + ")" + "</div><div class='landmark'> Distance: " + cont.distance.toFixed(2) + " meter</div></li>";
                                    }
                                    driver += "</ul>";
                                    $("#driver_list").html(driver);
                                });
                            }
                            getNearestDriver('<?php echo $row['pickup_lat']; ?>', '<?php echo $row['pickup_lng']; ?>','<?php echo $row['vehicle']; ?>')
                        </script>
                        <style>
                            #map-canvas {
                                height: 400px;
                                margin: 0px;
                                padding: 0px;
                                width: 100%;
                            }
                            .booking-form-fieldset{
                                border:1px solid rgba(99, 99, 99, .4);
                                border-radius:5px;
                                margin-bottom:15px;
                                padding: 5% 7%;
                                position:relative;
                            }
                            .booking-form-fieldset legend{
                                font-family:"Open Sans";
                                font-weight:bold;
                                color:#0a2b6e;
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