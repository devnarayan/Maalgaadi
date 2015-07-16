<?php
include '../includes/define.php';
verifyLogin();
?>
<html>
    <head>
        <?php include '../includes/head.php'; ?>
    </head>
    <body data-base="<?php echo BASE_URL; ?>">
        <?php include '../includes/header.php'; ?>
        <div class="container_content">
            <div class="crumbs">
                <ul id="breadcrumbs" class="breadcrumb">
                    <li> <a href="<?php echo BASE_URL; ?>" title="<?php echo BASE_URL; ?>">Home</a> </li>
                    <li> <a href="<?php echo BASE_URL; ?>booking/booking_list.php" title="<?php echo BASE_URL; ?>booking/booking_list.php">Booking list</a> </li>
                    <li class="active"><a title="">New Booking </a></li>
                </ul>
            </div>
            <div class="content_middle mt20">
                <form name="booking_form" class="form" id="booking_form" action="" method="post" enctype="multipart/form-data" onSubmit="">
                    <div class="customerDetail" id="customerDetail">

                    <?php
                        $status_edit=-3;
                        $flag=0; 
                        $booking_id=$_GET['booking'];
                        $c=mysql_query("SELECT * FROM `booking` WHERE `id`='$booking_id'");
                        $ch=mysql_fetch_array($c);
                        //echo"hiii".$ch['edit_status'];exit;
                        if($ch['edit_status']=='start to customer')
                        {
                            $flag=1;
                        }else if($ch['edit_status']=='start trip')
                        {
                            $flag=2;
                        }else if($ch['edit_status']=='stop trip')
                        {
                            $flag=3;
                        }

                        if($ch['status']==2)
                        {
                             $status_edit=2;
                        }
                    ?>
                        <div class="first_fieldset fl ml1p ">
                            <fieldset class="booking-form-fieldset">
                                <legend>CUSTOMER INFORMATION</legend>
                                <div class="new_booking_field ">
                                    <input type="text" <?php if($flag>0){ echo"disabled";} ?> title="Enter the first name with atleast 3 character" class="required" name="firstname" id="firstname" value=""  minlength="3"  placeholder="First Name"  autocomplete="off" />
                                    <input name="customer_id" id="customer_id" type="hidden" >
                                </div>
                                <div class="new_booking_field mt10">
                                    <input type="text" <?php if($flag>0){ echo"disabled";} ?> title="Enter the email address" class="email" name="email" id="email" value=""  maxlength="50" placeholder="Email" autocomplete="off"/>
                                </div>
                                <div class="new_booking_field mt10">
                                    <input type="text" <?php if($flag>0){ echo"disabled";} ?> title="Enter the mobile number minimum with 7 numbers" name="phone" id="phone" class="required digits" value="" minlength="7" maxlength="20" placeholder="Mobile" autocomplete="off" />
                                </div>
                                <div class="new_booking_field mt10">
                                    <input type="text" <?php if($flag>0){ echo"disabled";} ?> title="Organization Name" name="organization" id="organization" class="" value="" placeholder="Organization"  />
                                </div>
                                <div class="new_booking_field mt10">
                                    <textarea title="Address" <?php if($flag>0){ echo"disabled";} ?> name="address" id="address" class="" value="" placeholder="Addresss"  ></textarea>
                                </div>
                                <div class="new_booking_field mt10">
                                    <select <?php if($flag>0){ echo"disabled";} ?> title="Select Customer Category" name="customer_category" id="customer_category" class="required " >
                                        <option  value="Regular">Regular</option>
                                        <option  value="Corporate">Corporate</option>
                                    </select>
                                </div>
                                <div class="new_booking_field mt20 mb50"></div>
                            </fieldset>
                        </div>
                        <div class="first_fieldset fl ml4p" >
                            <fieldset class="booking-form-fieldset">
                                <legend>VEHICLE</legend>
                                <div class="new_booking_field mt10">
                                    <select <?php if($flag>0){ echo"disabled";} ?> name="vehicle" id="vehicle" class="required" title="Select the Taxi Model" OnChange="vehicle_info(this.value);" >
                                        <option value="">--Select--</option>
                                        <?php
                                        $result1 = $objConnect->select('vehicle_category');
                                        while ($row1 = $objConnect->fetch_assoc()) {
                                            ?>
                                            <option value="<?php echo $row1['id']; ?>"><?php echo $row1['name']; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="new_booking_field mt10">
                                    <div class="fl"> Model Min Fare </div>
                                    <div class="fr"><i class="fa fa-rupee"></i>
                                        <input type="text" required readonly name="model_minfare" id="model_minfare" class="onlyData" value="0.00"/>
                                    </div>
                                </div>
                                <div class="new_booking_field mt10 clear">
                                    <div class="fl"> Model Rate for first 10 km</div>
                                    <div class="fr"><i class="fa fa-rupee"></i>
                                        <input type="text" required readonly id="firstten" name="firstten" class="onlyData" value="0.00"/>
                                    </div>
                                </div>
                                <div class="new_booking_field mt10 clear">
                                    <div class="fl"> Model Rate Post 10 km </div>
                                    <div class="fr"><i class="fa fa-rupee"></i>
                                        <input type="text" required readonly id="rate" name="rate" class="onlyData" value="0.00"/>
                                    </div>
                                </div>
                                <div class="new_booking_field mt10 clear">
                                    <div class="fl"> Loading Charge </div>
                                    <div class="fr"><i class="fa fa-rupee"></i>
                                        <input type="text" readonly id="loading_charge" name="loading_charge" class="onlyData" value="0.00"/>
                                    </div>
                                </div>

                                <input type="hidden" readonly id="standard_wait_time" name="standard_wait_time" class="onlyData" value="0.00"/>


                                <div class="new_booking_field mt10 clear">
                                    <div class="fl">Hourly Charge </div>
                                    <div class="fr"><i class="fa fa-rupee"></i>
                                        <input type="text" readonly id="wait_time_charge" name="wait_time_charge" class="onlyData" value="0.00"/>
                                    </div>
                                </div>
                                <div class="new_booking_field mt10 clear">
                                    <div class="fl"> Capacity </div>
                                    <div class="fr"> <span id="capacity" class="onlyData" >0.00</span> </div>
                                </div>
                                <div class="new_booking_field mt10 clear">
                                    <div class="fl"> Volume </div>
                                    <div class="fr"> <span id="capacity" class="onlyData" >0.00</span> </div>
                                </div>
                                <div class="new_booking_field mt20 mb50"></div>
                            </fieldset>
                        </div>
                        <div class="first_fieldset fr mr1p">
                            <fieldset class="booking-form-fieldset">
                                <legend>Booking Info</legend>
                                <div class="new_booking_field mt10">
                                    <input <?php if($flag>0){ echo"disabled";} ?> type="text" title="Pickup Date" class="" name="pickup_date" id="pickup_date" value="<?php echo date("d/m/Y H:i", strtotime(date("Y-m-d H:i"))); ?>"  autocomplete="off" placeholder="Today" readonly />
                                </div>
                                <div class="new_booking_field mt10">
                                    <input <?php if($flag>0){ echo"disabled";} ?> type="text" title="Enter in round value(Kg)" class="onlynumbers" name="luggage" id="luggage" value=""  autocomplete="off" placeholder="Volume" />
                                </div>
                                <div class="new_booking_field mt10">
                                    <textarea <?php if($flag>0){ echo"disabled";} ?> title="Write a note to driver" name="notes" id="notes" value=""  autocomplete="off"  placeholder="Write a note to driver" ></textarea>
                                </div>

                                <div class="new_booking_field mt20 mb50"></div>
                            </fieldset>
                            <div style="width:100%" align="right">
                                <input type="button" class="btn btn-warning edit_btn" onClick="paneonevalidate()" style="" value="Next"/>
                            </div>
                        </div>
                    </div>
                    <div class="pickupDetail" id="pickupDetail">
                        <div class="first_fieldset fl ml1p">
                            <fieldset class="booking-form-fieldset">
                                <legend>Pick up</legend>
                                <div class="new_booking_field">
                                    <input type="text" <?php if($flag>1){ echo"disabled";} ?> title="Enter the Pickup Person Name" class="required " name="pick_up_name" id="pick_up_name" value=""  autocomplete="off"  placeholder="Enter the Pickup name" />
                                </div>
                                <div class="new_booking_field mt10">
                                    <input type="number" <?php if($flag>1){ echo"disabled";} ?> minlength="10" title="Enter the Pickup Person Mobile No" class="required " name="pick_up_no" id="pick_up_no" value=""  autocomplete="off"  placeholder="Enter the Pickup Number" />
                                </div>
                                <div class="new_booking_field mt10">
                                    <input type="text" <?php if($flag>1){ echo"disabled";} ?> title="Enter the Pickup organization"  name="pick_up_organization" id="pick_up_organization" value=""  autocomplete="off"  placeholder="Enter the Pickup organization" />
                                </div>
                                <div class="new_booking_field mt10">
                                    <input type="text" <?php if($flag>1){ echo"disabled";} ?> title="Enter the Pickup Address" name="current_location" id="current_location" value=""  autocomplete="off"  placeholder="Enter the Pickup Address" />
                                </div>
                                <div class="new_booking_field mt10">
                                    <input type="text" <?php if($flag>1){ echo"disabled";} ?> title="Enter the Pickup Landmark" class="required " name="pick_up_landmark" id="pick_up_landmark" value=""  autocomplete="off"  placeholder="Enter the Pickup Landmark" onChange="GeocodeFromAddress()"/>
                                    <input type="hidden" name="pickup_lat" id="pickup_lat" value="">
                                    <input type="hidden" name="pickup_lng" id="pickup_lng" value="">
                                </div>
                                <div class="new_booking_field mb20 clr"></div>
                            </fieldset>
                            <div style="width:100%" align="left">
                                <input type="button" class="btn btn-warning edit_btn" onClick="panethreevalidate()" style="" value="View Driver">
                                <input type="button" class="btn btn-warning edit_btn" onClick="panetwovalidate()" style="" value="Next">
                            </div>
                        </div>
                        <div class="first_fieldset fl ml4p">
                            <fieldset class="booking-form-fieldset">
                                <legend>User's Pick up</legend>
                                <?php if($flag<1) {?>
                                <div id="fav_pick_up_pickup">
                                    <ul>
                                        <li> No Favorite Address </li>
                                    </ul>
                                </div>
                                <?php } ?>
                            </fieldset>
                        </div>
                        <div class="first_fieldset fr mr1p">
                            <fieldset class="booking-form-fieldset">
                                <legend>User's Drop</legend>
                                 <?php if($flag<1) {?>
                                <div id="fav_drop_pickup">
                                    <ul>
                                        <li> No Favorite Address </li>
                                    </ul>
                                </div>
                                 <?php } ?>
                            </fieldset>
                        </div>
                    </div>
                    <div class="dropDetail" id="dropDetail">
                        <div class="first_fieldset fl ml1p">
                            <fieldset class="booking-form-fieldset">
                                <legend>Drop Detail</legend>
                                <div class="new_booking_field">
                                    <input  type="text" title="Enter the Drop Person Name"  name="drop_name" id="drop_name" value=""  autocomplete="off"  placeholder="Enter the Drop name" />
                                </div>
                                <div class="new_booking_field mt10">
                                    <input type="number" minlength="10" title="Enter the Drop Person Mobile No"  name="drop_number" id="drop_number" value=""  autocomplete="off"  placeholder="Enter the Drop Number" />
                                </div>
                                <div class="new_booking_field mt10">
                                    <input type="text" title="Enter the Drop organization"  name="drop_organization" id="drop_organization" value=""  autocomplete="off"  placeholder="Enter the Drop organization" />
                                </div>
                                <div class="new_booking_field mt10">
                                    <input type="text" title="Enter the Drop Address" class="required " name="drop_location" id="drop_location" value=""  autocomplete="off" placeholder="Enter the Drop Location" />
                                </div>
                                <div class="new_booking_field mt10">
                                    <input type="text" title="Enter the Drop Location" class="required " name="drop_landmark" id="drop_landmark" value=""  autocomplete="off" placeholder="Enter the Drop Landmark" onChange="GeocodeFromAddress()"/>
                                    <input type="hidden" name="drop_lat" id="drop_lat" value="">
                                    <input type="hidden" name="drop_lng" id="drop_lng" value="">
                                </div>
                                <div class="new_booking_field mb20 clr"></div>
                            </fieldset>
                            <div style="width:100%" align="left">
                                <input type="button" class="btn btn-warning edit_btn" onClick="panethreevalidate()" style="" value="Next">
                            </div>
                        </div>
                        <div class="first_fieldset fl ml4p">
                            <fieldset class="booking-form-fieldset">
                                <legend>User's Pick up</legend>
                                <div id="fav_pick_up_drop">
                                    <ul>
                                        <li> No Favorite Address </li>
                                    </ul>
                                </div>
                            </fieldset>
                        </div>
                        <div class="first_fieldset fr mr1p">
                            <fieldset class="booking-form-fieldset">
                                <legend>User's Drop</legend>
                                <div id="fav_drop_drop">
                                    <ul>
                                        <li> No Favorite Address </li>
                                    </ul>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="routes" id="routes">
                        <div class="fl map" style="width:100%;">
                            <div id="map-canvas" style="width:100%;height:450px;"></div>
                            <div id="directions-panel" class="hide"> </div>
                        </div>
                        <div class="first_fieldset ml4p fl driver_box">
                            <fieldset class="booking-form-fieldset">
                                <legend>Driver List</legend>
                                <div id="driver_list">
                                    <ul>
                                        <li> No Favorite Address </li>
                                    </ul>
                                </div>
                                <input type="button" class="btn btn-warning edit_btn" onClick="paneonevalidate()" style="" value="Go to pickup"/> <input type="button" class="btn btn-warning edit_btn" onClick="panefourvalidate()" style="" value="Next"/>
                            </fieldset>

                        </div>
                    </div>
                    <div class="myownh1 space1" id="payment">
                        <div class="first_fieldset fl">

                            <fieldset class="booking-form-fieldset">
                                <legend>Payment Detail</legend>
                                <div class="new_booking_field mt10 clear">
                                    <div class="fl"> Loading </div>
                                    <div class="fr">
                                        <input type="checkbox" onChange="calculate_totalfare();" id="loading" name="loading" value="true"/>
                                    </div>
                                </div>
                                <div class="new_booking_field mt10 clear">
                                    <div class="fl"> Un Loading </div>
                                    <div class="fr">
                                        <input type="checkbox" id="unloading" onChange="calculate_totalfare();" name="unloading" value="true"/>
                                    </div>
                                </div>
                                <div class="new_booking_field mt10 clear">
                                    <div class="fl"> Distance Km </div>
                                    <div class="fr">
                                        <input type="text" required="" readonly="" style="width:100px !important;" name="distance_km" id="distance_km" class="onlyData" value="0.00">
                                    </div>
                                </div>
                                <div class="new_booking_field mt10 clear">
                                    <div class="fl"> Total Duration </div>
                                    <div class="fr">
                                        <input type="text" required="" readonly=""  style="width:100px !important;" name="total_duration" id="total_duration" class="onlyData" value="0.00">
                                    </div>
                                </div>
                                <div class="new_booking_field mt10 clear">
                                    <div class="fl"> Trip Fare </div>
                                    <div class="fr"><i class="fa fa-rupee"></i>
                                        <input type="text" required="" readonly="" name="trip_fare" id="trip_fare" class="onlyData" value="0.00">
                                    </div>
                                </div>
                                <div class="new_booking_field mt10 clear">
                                    <div class="fl"> Total Fare </div>
                                    <div class="fr"><i class="fa fa-rupee"></i>
                                        <input type="text" required="" readonly="" name="total_fare" id="total_fare" class="onlyData" value="0.00">
                                        <input type="hidden" name="id" value="" id="id">
                                    </div>
                                </div>

                                <div class="new_booking_field mt10 clear">
                                    <div class="fl"> Expected Total Fare </div>
                                    <div class="fr"><i class="fa fa-rupee"></i>
                                        <input type="number"  name="total_exp_fare" id="total_exp_fare" class="form-data" value="" style="width: 80px;"> <!-- -->
                                    </div>
                               </div>
                            </fieldset>
                            <input type="hidden" name="status" value="<?php echo$status_edit; ?>" id="status">
                            <input type="hidden" name="mode" value="update_booking">
                            <input type="button" value="Book Now" class="btn btn-success book-now" onClick="formSubmit('booking_form', 'form_result', 'booking_update.php')">
                            <div id="form_result"></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="content_bottom">
                <div class="bot_left"></div>
                <div class="bot_center"></div>
                <div class="bot_rgt"></div>
            </div>
        </div>
        <script src="http://maps.google.com/maps/api/js?key=AIzaSyBIkQyG2nXYEVIOt3cce94TEdWDVuBG7MY&libraries=places,geometry&amp;sensor=false" type="text/javascript"></script> 
        <script>
                                        $(document).ready(function () {
                                $('#pickup_date').datetimepicker({
                                dateFormat: 'dd/mm/yy',
                                        timeFormat: 'HH:mm',
                                        minDate: new Date()
                                });
                                        $("#firstname").focus();
                                        $.ui.autocomplete.prototype._renderItem = function (ul, item) {
                                        var data = item.customer_name + ", " + item.customer_email;
                                                var re = new RegExp("(" + data + ")", "gi");
                                                var t = data.replace(re, "<strong>$1</strong>");
                                                return $("<li></li>")
                                                .data("item.autocomplete", item)
                                                .append("<a>" + data + "</a>")
                                                .appendTo(ul);
                                        };
                                        $("#firstname").autocomplete({
//                                        source: 'booking_update.php?mode=autocompleteFirstname',
                                source: 'booking_update.php?mode=autocompleteFirstname',
                                        select: function (event, ui) {
                                        console.log(ui.item.id);
                                                $('#customer_id').val(ui.item.id);
                                                $('#firstname').val(ui.item.customer_name);
                                                $('#email').val(ui.item.customer_email);
                                                $('#phone').val(ui.item.customer_number);
                                                $('#organization').val(ui.item.customer_organization);
                                                $('#address').val(ui.item.customer_address);
                                                $('#customer_category').val(ui.item.customer_category);
                                                fetchpickupDrop(ui.item.id);
                                                return false;
                                        },
                                        minLength: 1
                                });
                                        $("#phone").autocomplete({
                                source: 'booking_update.php?mode=autocompletePhone',
                                        select: function (event, ui) {
                                        console.log(ui.item.id);
                                                $('#customer_id').val(ui.item.id);
                                                $('#firstname').val(ui.item.customer_name);
                                                $('#email').val(ui.item.customer_email);
                                                $('#phone').val(ui.item.customer_number);
                                                $('#organization').val(ui.item.customer_organization);
                                                $('#address').val(ui.item.customer_address);
                                                $('#customer_category').val(ui.item.customer_category);
                                                fetchpickupDrop(ui.item.id);
                                                return false;
                                        },
                                        minLength: 1
                                });
                                        $("#email").autocomplete({
//                                        source: 'booking_update.php?mode=autocompleteEmail',
                                source: 'booking_update.php?mode=autocompleteEmail',
                                        select: function (event, ui) {
                                        console.log(ui.item.id);
                                                $('#customer_id').val(ui.item.id);
                                                $('#firstname').val(ui.item.customer_name);
                                                $('#email').val(ui.item.customer_email);
                                                $('#phone').val(ui.item.customer_number);
                                                $('#organization').val(ui.item.customer_organization);
                                                $('#address').val(ui.item.customer_address);
                                                $('#customer_category').val(ui.item.customer_category);
                                                fetchpickupDrop(ui.item.id);
                                                return false;
                                        },
                                        minLength: 1
                                });
                                 populatebooking();
                                });
                                        var marker = null;
                                        var working = false;
                                        var marker;
                                        var circle = new google.maps.Circle();
                                        var latlng = new google.maps.LatLng(22.719569, 75.857726);
                                        var options = {
                                        zoom: 12,
                                                center: latlng,
                                                mapTypeId: google.maps.MapTypeId.ROADMAP
                                        };
                                        var map = new google.maps.Map(document.getElementById("map-canvas"), options);
                                  
                                        var rendererOptions = {draggable: false};
                                        var directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
                                        directionsDisplay.setMap(map);
                                        directionsDisplay.setPanel(document.getElementById("directions-panel"));
                                        google.maps.event.addListener(directionsDisplay, 'directions_changed', function () {
                                        updateStatus("Route changed");
                                                if (!working) {
                                        working = true;
                                        }
                                        });
                                        google.maps.event.addListener(directionsDisplay, 'routeindex_changed', function () {
                                        updateStatus("Route index changed");
                                                /*if (!working) {
                                                 working = true;*/
                                                GetElevation(directionsDisplay.directions.routes[directionsDisplay.getRouteIndex()]);
                                                /*}*/
                                        });
                                        // autocomplete
                                        var autocomplete = new google.maps.places.Autocomplete(document.getElementById('pick_up_landmark'), {});
                                        var toAutocomplete = new google.maps.places.Autocomplete(document.getElementById('drop_landmark'), {});
                                        google.maps.event.addListener(autocomplete, 'place_changed', function () {
                                        var place = autocomplete.getPlace();
                                                GeocodeFromAddress();
                                                GotoLocation(place.geometry.location, 1);
                                        });
                                        google.maps.event.addListener(toAutocomplete, 'place_changed', function () {
                                        var place = toAutocomplete.getPlace();
                                                GeocodeFromAddress();
                                                GotoLocation(place.geometry.location, 2);
                                        });
                                        function createMarker(latlng, name, image) {
                                        var html = name;
                                                var marker = new google.maps.Marker({map: map, position: latlng, icon: image});
                                                var infowindow = new google.maps.InfoWindow({content: html});
                                                google.maps.event.addListener(marker, 'click', function () {
                                                infowindow.open(map, this);
                                                        alert(123);
                                                });
                                                return marker;
                                                 
                                        }
                                function GotoLocation(location, field) {
                                GetLocationInfo(location, field);
                                        map.setCenter(location);
                                }
                                function GetLocationInfo(latlng, field)
                                {
                                if (latlng != null)
                                {
                                ShowLatLong(latlng, field);
                                }
                                }

                                function ShowLatLong(latLong, field)
                                {
                                // show the lat/long
                                if (marker != null) {
                                marker.setMap(null);
                                }
                                marker = new google.maps.Marker({
                                position: latLong,
                                        map: map});
                                        if (field == 1)
                                {
                                $('#pickup_lat').val(latLong.lat());
                                        $('#pickup_lng').val(latLong.lng());
                                }
                                else
                                {
                                $('#drop_lat').val(latLong.lat());
                                        $('#drop_lng').val(latLong.lng());
                                }

                                }
                                function paneonevalidate() {
                                //                $("#booking_form #customerDetail").validate();
                                //                if ($("#booking_form #customerDetail").valid()) {
                                //                    
                                //                }
                                window.location.href = "#pickupDetail";
                                }
                                function panetwovalidate() {
                                //                $("#booking_form #customerDetail").validate();
                                //                if ($("#booking_form #customerDetail").valid()) {
                                //                    
                                //                }
                                window.location.href = "#dropDetail";
                                }
                                function panethreevalidate() {
                                //                $("#booking_form #customerDetail").validate();
                                //                if ($("#booking_form #customerDetail").valid()) {
                                //                    
                                //                }
                                window.location.href = "#routes";
                                }
                                function panefourvalidate() {
                                //                $("#booking_form #customerDetail").validate();
                                //                if ($("#booking_form #customerDetail").valid()) {
                                //                    
                                //                }
                                window.location.href = "#payment";
                                }
                                function vehicle_info(vehicle_id) {
                                if (vehicle_id != "") {
                                $.post("booking_update.php", {mode: "vehicle_detail", model_id: vehicle_id}, function (data) {
                                var item = JSON.parse(data);
                                        $("#model_minfare").val(parseFloat(item.min_fare).toFixed(2));
                                        $("#rate").val(parseFloat(item.rate).toFixed(2));
                                        $("#firstten").val(parseFloat(item.firstten).toFixed(2));
                                        $("#loading_charge").val(parseFloat(item.loading_charge).toFixed(2));
                                        $("#standard_wait_time").val(parseFloat(item.waiting_time).toFixed(2));
                                        $("#wait_time_charge").val(parseFloat(item.waiting_time_charge).toFixed(2));
                                        $("#capacity").html(parseFloat(item.capacity));
                                        $("#volume").html(parseFloat(item.volume));
                                        calculate_totalfare();
                                });
                                }
                                else {
                                }
                                }
                                function fetchpickupDrop(customer_id) {
                                if (customer_id != "") {
                                var pickup_pickup = "<ul>";
                                        var drop_pickup = "<ul>";
                                        var pickup_drop = "<ul>";
                                        var drop_drop = "<ul>";
                                        $.post("booking_update.php", {mode: "fetchpickup_drop", customer_id: customer_id}, function (data) {
                                        var item = JSON.parse(data);
                                                for (var i = 0; i < item.length; i++) {
                                        var cont = item[i];
                                                if (cont.type == "pickup") {
                                        pickup_pickup += "<li><i class='fa fa-trash editfav' onclick='deletefavorite(\"" + cont.id + "\",\"" + cont.customer_id + "\")'></i><i class='fa fa-edit editfav' title='edit' onclick='editfavorite(\"" + cont.id + "\",\"" + cont.customer_id + "\")'></i><i class='fa fa-asterisk editfav' title='use this' onclick='pickup(\"" + cont.pick_up_name + "\",\"" + cont.pick_up_no + "\",\"" + cont.pick_up_organization + "\",\"" + cont.current_location + "\",\"" + cont.pick_up_landmark + "\",\"" + cont.pickup_lat + "\",\"" + cont.pickup_lng + "\")'></i><div class='address'>" + cont.current_location + "</div><div class='landmark'>" + cont.pick_up_landmark + "</div></li>";
                                                pickup_drop += "<li><i class='fa fa-trash editfav' title='delete' onclick='deletefavorite(\"" + cont.id + "\",\"" + cont.customer_id + "\")'></i> <i class='fa fa-edit editfav' title='edit' onclick='editfavorite(\"" + cont.id + "\",\"" + cont.customer_id + "\")'></i><i class='fa fa-asterisk editfav' title='use this' onclick='drop(\"" + cont.pick_up_name + "\",\"" + cont.pick_up_no + "\",\"" + cont.pick_up_organization + "\",\"" + cont.current_location + "\",\"" + cont.pick_up_landmark + "\",\"" + cont.pickup_lat + "\",\"" + cont.pickup_lng + "\")'></i><div class='address'>" + cont.current_location + "</div><div class='landmark'>" + cont.pick_up_landmark + "</div></li>";
                                        }
                                        else if (cont.type == "drop") {

                                        drop_pickup += "<li><i class='fa fa-trash editfav' title='delete' onclick='deletefavorite(\"" + cont.id + "\",\"" + cont.customer_id + "\")'></i><i class='fa fa-edit editfav' title='edit' onclick='editfavorite(\"" + cont.id + "\",\"" + cont.customer_id + "\")'></i><i class='fa fa-asterisk editfav' title='use this'  onclick='pickup(\"" + cont.pick_up_name + "\",\"" + cont.pick_up_no + "\",\"" + cont.pick_up_organization + "\",\"" + cont.current_location + "\",\"" + cont.pick_up_landmark + "\",\"" + cont.pickup_lat + "\",\"" + cont.pickup_lng + "\")'></i><div class='address'>" + cont.current_location + "</div><div class='landmark'>" + cont.pick_up_landmark + "</div></li>";
                                                drop_drop += "<li><i class='fa fa-trash editfav' title='delete' onclick='deletefavorite(\"" + cont.id + "\",\"" + cont.customer_id + "\")'></i><i class='fa fa-edit editfav' title='edit' onclick='editfavorite(\"" + cont.id + "\",\"" + cont.customer_id + "\")'></i> <i class='fa fa-asterisk editfav' title='use this' onclick='drop(\"" + cont.pick_up_name + "\",\"" + cont.pick_up_no + "\",\"" + cont.pick_up_organization + "\",\"" + cont.current_location + "\",\"" + cont.pick_up_landmark + "\",\"" + cont.pickup_lat + "\",\"" + cont.pickup_lng + "\")'></i><div class='address'>" + cont.current_location + "</div><div class='landmark'>" + cont.pick_up_landmark + "</div></li>";
                                        }
                                        }
                                        pickup_pickup += "</ul>";
                                                drop_pickup += "</ul>";
                                                pickup_drop += "</ul>";
                                                drop_drop += "</ul>";
                                                $("#fav_pick_up_pickup").html(pickup_pickup);
                                                $("#fav_drop_pickup").html(drop_pickup);
                                                $("#fav_pick_up_drop").html(pickup_drop);
                                                $("#fav_drop_drop").html(drop_drop);
                                        });
                                }

                                }

                                 function editfavorite(id, customer_id) {
                                    $("#modal-body").load("editfavlocation.php?id=" + id, function () {

                                        latitudelngfromaddress();
                                    });
                                    $("#exampleModal").modal("show");

                                }
                                function latitudelngfromaddress() {

                                    var autocomplete1 = new google.maps.places.Autocomplete(
                                            (document.getElementById('fav_pick_up_landmark')), {types: ['geocode']});
                                    google.maps.event.addListener(autocomplete1, 'place_changed', function () {
                                        var addd = $("#fav_pick_up_landmark").val();
                                       
                                        $.get("https://maps.googleapis.com/maps/api/geocode/json?address=" + addd, function (data) {
                                            $("#fav_pickup_lat").val(data.results[0].geometry.location.lat);
                                            $("#fav_pickup_lng").val(data.results[0].geometry.location.lng);


                                        });
                                    });
                                }

                                function deletefavorite(id, customer_id) {
                                var confirmbox = confirm("Are You SureYou Want To delete");
                                        if (confirmbox) {
                                $.post("favorite_update.php", {mode: "deletefav", id: id}, function (response) {
                                if (response == "success") {
                                alert("Fav Location Deleted Successfully");
                                        fetchpickupDrop(customer_id);
                                }
                                });
                                }
                                }
                                function pickup(pickup_name, pickup_number, pickup_organization, pickup_address, pick_up_landmark, pickup_lat, pickup_lng) {
                                $("#pick_up_name").val(pickup_name);
                                        $("#pick_up_no").val(pickup_number);
                                        $("#pick_up_organization").val(pickup_organization);
                                        $("#current_location").val(pickup_address);
                                        $("#pick_up_landmark").val(pick_up_landmark);
                                        $("#pickup_lat").val(pickup_lat);
                                        $("#pickup_lng").val(pickup_lng);
                                        $("#pick_up_landmark").change();
                                }
                                function drop(drop_name, drop_number, drop_organization, drop_address, drop_landmark, pickup_lat, pickup_lng) {
                                $("#drop_name").val(drop_name);
                                        $("#drop_number").val(drop_number);
                                        $("#drop_organization").val(drop_organization);
                                        $("#drop_landmark").val(drop_landmark);
                                        $("#drop_location").val(drop_address);
                                        $("#pickup_lat").val(pickup_lat);
                                        $("#pickup_lng").val(pickup_lng);
                                        $("#drop_landmark").change();
                                }
                                function GeocodeFromAddress() {
                                working = true;
                                        $("#distance_km").val("");
                                        $("#trip_fare").html("");
                                        $("#total_duration").html("");
                                        clearMarker();
                                        // geocode from address
                                        updateStatus("Locating from address...");
                                        var geocoder = new google.maps.Geocoder();
                                        var from = $("#pick_up_landmark").val();
                                        geocoder.geocode({'address': from},
                                                function (results, status) {
                                                if (results[0]) {
                                                var result = results[0];
                                                        var fromLatLng = result.geometry.location;
                                                        $('#pickup_lat').val(result.geometry.location.lat());
                                                        $('#pickup_lng').val(result.geometry.location.lng());
                                                        getNearestDriver(result.geometry.location.lat(), result.geometry.location.lng(),$('#vehicle').val());
                                                        setInterval("getNearestDriver($('#pickup_lat').val(),$('#pickup_lng').val(),$('#vehicle').val())", 20000);
                                                        GeocodeToAddress(fromLatLng);
                                                        var searchArea = new google.maps.LatLng(result.geometry.location.lat(), result.geometry.location.lng());
                                                        circle = new google.maps.Circle({
                                                        center: searchArea,
                                                                radius: 1000, //convert miles to meters
                                                                strokeColor: "#0000FF",
                                                                strokeOpacity: 0.8,
                                                                strokeWeight: 2,
                                                                fillColor: "#0000FF",
                                                                fillOpacity: 0.4
                                                        });
                                                        circle.setMap(map);
                                                }
                                                else {
                                                updateStatus("From address not found");
                                                        working = false;
                                                }
                                                }
                                        );
                                }

                                function GeocodeToAddress(fromLatLng) {
                                // geocode to address
                                updateStatus("Locating to address...");
                                        var geocoder = new google.maps.Geocoder();
                                        var to = $("#drop_landmark").val();
                                        geocoder.geocode({'address': to},
                                                function (results, status) {
                                                if (results[0]) {
                                                var result = results[0];
                                                        var toLatLng = result.geometry.location;
                                                        $('#drop_lat').val(result.geometry.location.lat());
                                                        $('#drop_lng').val(result.geometry.location.lng());
                                                        CalculateRoute(fromLatLng, toLatLng);
                                                }
                                                else {
                                                updateStatus("To address not found");
                                                        working = false;
                                                }
                                                }
                                        );
                                }
                                function CalculateRoute(fromLatLng, toLatLng) {
                                // calculate the route
                                updateStatus("Calculating route...");
                                        var directions = new google.maps.DirectionsService();
                                        var travelMode = google.maps.DirectionsTravelMode.DRIVING;
                                        var request = {
                                        origin: fromLatLng,
                                                destination: toLatLng,
                                                travelMode: travelMode,
                                                provideRouteAlternatives: true
                                        };
                                        directions.route(request, function (result, status) {
                                        if (status == google.maps.DirectionsStatus.OK) {
                                        directionsDisplay.setDirections(result);
                                                GetElevation(result.routes[0]);
                                        }
                                        else {
                                        var statusText = getDirectionStatusText(status);
                                                updateStatus("An error occurred calculating the route - " + statusText);
                                                working = false;
                                        }
                                        });
                                }
                                var locations;
                                        var show_time;
                                        var hm_hours;
                                        var hm_secsl
                                        function showResults(results) {
                                        // display the results
                                        var ascent = 0;
                                                var descent = 0;
                                                ShowElevation("#start", results[0]);
                                                ShowElevation("#end", results[results.length - 1]);
                                                var minElevation = results[0];
                                                var maxElevation = results[0];
                                                var chartData = [];
                                                var distance = 0;
                                                for (var i = 0; i < results.length; i++) {
                                        minElevation = Math.min(results[i], minElevation);
                                                maxElevation = Math.max(results[i], maxElevation);
                                                // calculate distance
                                                if (i > 0) {
                                        var d = google.maps.geometry.spherical.computeDistanceBetween(locations[i - 1], locations[i]);
                                                distance += d;
                                        }

                                        chartData.push([distance / 1000, results[i]]);
                                                if (i > 0) {
                                        var thisAscent = results[i] - results[i - 1];
                                                if (thisAscent > 0)
                                                ascent += thisAscent;
                                                else
                                                descent -= thisAscent;
                                        }
                                        }
                                        ShowElevation("#ascent", ascent);
                                                ShowElevation("#descent", descent);
                                                ShowElevation("#min", minElevation);
                                                ShowElevation("#max", maxElevation);
                                                // chart
                                        }

                                function showTooltip(x, y, contents) {
                                $('<div id="tooltip">' + contents + '</div>').css({
                                position: 'absolute',
                                        display: 'none',
                                        top: y,
                                        left: x + 20,
                                        border: '1px solid #fdd',
                                        padding: '2px',
                                        'background-color': '#fee',
                                        opacity: 0.80
                                }).appendTo("body").fadeIn(200);
                                }

                                var previousPoint = null;
                                
                                function GetElevation(route) {

                                clearMarker();
                                        // show distance
                                        var distance = 0;
                                        var time = 0;
                                        for (var i = 0; i < route.legs.length; i++) {
                                var theLeg = route.legs[i];
                                        distance += theLeg.distance.value;
                                        time += theLeg.duration.value;
                                }

                                hm_hours = ('0' + Math.round(time / 3600) % 24).slice( - 2) + ' hours';
                                        hm_secs = ('0' + Math.round(time / 60) % 60).slice( - 2) + ' mins';
                                        if (hm_hours != '00 hours')
                                {
                                show_time = hm_hours + hm_secs;
                                }
                                else
                                {
                                show_time = hm_secs;
                                }


                                var km = ((distance / 100) / 10).toFixed(1);
                                        $('#distance_km').val(km);
                                        $('#total_duration').val(show_time);
                                        var model_minfare = $('#model_minfare').val();
                                        var model_id = $('#vehicle').val();
                                        var pickup_location = $('#current_location').val();
                                        var pickup_lat = $('#pickup_lat').val();
                                        var pickup_lng = $('#pickup_lng').val();
                                        var pickup_latlng = pickup_lat + ',' + pickup_lng;
                                        geocoder = new google.maps.Geocoder();
                                        var latlng = new google.maps.LatLng(pickup_lat, pickup_lng);
                                        geocoder.geocode({'latLng': latlng}, function (results, status) {
                                        if (status == google.maps.GeocoderStatus.OK) {
                                        //Check result 0
                                        var result = results[0];
                                                //look for locality tag and administrative_area_level_1
                                                calculate_totalfare();
                                        }
                                        });
                                        // get all the lat/longs
                                        locations = [];
                                        for (var i = 0; i < route.legs.length; i++) {
                                var thisLeg = route.legs[i];
                                        for (var j = 0; j < thisLeg.steps.length; j++) {
                                var thisStep = thisLeg.steps[j];
                                        for (var k = 0; k < thisStep.lat_lngs.length; k++) {
                                locations.push(thisStep.lat_lngs[k]);
                                }
                                }
                                }

                                updateStatus("Calculating elevation for " + locations.length + " locations...");
                                        elevations = [];
                                        currentPos = 0;
                                        getElevation();
                                }
                                function calculate_totalfare() {
                                var model_minfare = $('#model_minfare').val();
                                        var rate = $('#rate').val();
                                        var firstten = $("#firstten").val();
                                        var distance_km = $('#distance_km').val();
                                        var loading = $("#loading").is(":checked");
                                        var unloading = $("#unloading").is(":checked");
                                        var loading_charge = $("#loading_charge").val();
                                        if (parseFloat(distance_km) <= 10) {
                                var trip_charge = (parseFloat(firstten) * parseFloat(distance_km)).toFixed(2);
                                }
                                else if (distance_km > 10) {
                                var dist = distance_km - 10;
                                        var trip_charge = (parseFloat(firstten) * 10).toFixed(2);
                                        trip_charge = parseFloat((parseFloat(rate) * parseFloat(dist)).toFixed(2)) + parseFloat(trip_charge);
                                }
//alert();
                                if (trip_charge < parseFloat(model_minfare)) {
                                trip_charge = parseFloat(model_minfare);
                                }
                                var total_fare = trip_charge;
                                        if (loading) {
                                total_fare = parseFloat(total_fare) + parseFloat(loading_charge);
                                }
                                if (unloading) {
                                total_fare = parseFloat(total_fare) + parseFloat(loading_charge);
                                }
                                    $("#trip_fare").val(trip_charge);
                                    $("#total_fare").val(total_fare);
                                }




                                function getDirectionStatusText(status) {
                                switch (status) {
                                case google.maps.DirectionsStatus.INVALID_REQUEST:
                                        return "Invalid request";
                                        case google.maps.DirectionsStatus.MAX_WAYPOINTS_EXCEEDED:
                                        return "Maximum waypoints exceeded";
                                        case google.maps.DirectionsStatus.NOT_FOUND:
                                        return "Not found";
                                        case google.maps.DirectionsStatus.OVER_QUERY_LIMIT:
                                        return "Over query limit";
                                        case google.maps.DirectionsStatus.REQUEST_DENIED:
                                        return "Request denied";
                                        case google.maps.DirectionsStatus.UNKNOWN_ERROR:
                                        return "Unknown error";
                                        case google.maps.DirectionsStatus.ZERO_RESULTS:
                                        return "Zero results";
                                        default:
                                        return status;
                                }
                                }
                                function showDistance(distance) {
                                return Math.round(distance / 100) / 10 + " km (" +
                                        Math.round((distance * 0.621371192) / 100) / 10 + " miles)";
                                }
                                function updateStatus(status) {
                                $("#info").html(status);
                                }

                                function clearMarker() {
                                if (marker != null)
                                        marker.setMap(null);
                                        circle.setMap(null);
                                }
                                var currentPos = 0;
                                        var partLength = 100;
                                        var elevations = [];
                                        function getElevation() {
                                        // calculate the elevation of the route
                                        var locationsPart = [];
                                                var end = Math.min(locations.length, currentPos + 100);
                                                for (i = currentPos; i < end; i++) {
                                        locationsPart.push(locations[i]);
                                        }
                                        updateStatus("Calculating elevation for " + currentPos + " to " + end + " (of " + locations.length + ")...");
                                                var positionalRequest = {
                                                'locations': locationsPart
                                                };
                                                var elevator = new google.maps.ElevationService();
                                                // Initiate the location request
                                                elevator.getElevationForLocations(positionalRequest,
                                                        function (results, status) {
                                                        if (status == google.maps.ElevationStatus.OK) {
                                                        for (var i = 0; i < results.length; i++) {
                                                        elevations.push(results[i].elevation);
                                                        }
                                                        currentPos += partLength;
                                                                if (currentPos > locations.length) {
                                                        showResults(elevations);
                                                                updateStatus("Elevation calculated using " + locations.length + " locations");
                                                                working = false;
                                                        }
                                                        else {
                                                        getElevation();
                                                        }
                                                        }
                                                        else {
                                                        if (status == google.maps.ElevationStatus.OVER_QUERY_LIMIT) {
                                                        updateStatus("Over query limit calculating the elevation for " + currentPos + " to " + (currentPos + partLength) + " (of " + locations.length + "), waiting 1 second before retrying");
                                                                setTimeout("getElevation()", 1000);
                                                        }
                                                        else {
                                                        updateStatus("An error occurred calculating the elevation - " + elevationStatusDescription(status));
                                                                working = false;
                                                        }
                                                        }
                                                        }
                                                );
                                        }
                                function elevationStatusDescription(status) {
                                switch (status) {
                                case "OVER_QUERY_LIMIT":
                                        return "Over query limit";
                                        case "UNKNOWN_ERROR":
                                        return "Unknown error";
                                        default:
                                        return status;
                                }
                                }
                                function ShowElevation(selector, elevation) {
                                $(selector).html(Math.round(elevation) + " metres (" + Math.round(elevation * 3.2808399) + " feet)");
                                }
                                var map; // A new marker is created based on the parameters provided and the listener is added to them"
                                        function createMarker(latlng, name, image) {
                                        var html = name;
                                                var marker = new google.maps.Marker({map: map, position: latlng, icon: image});
                                                var infowindow = new google.maps.InfoWindow({content: html});
                                                google.maps.event.addListener(marker, 'click', function () {
                                                var point = marker.getPosition();
                                                        geocode(point, marker, html);
                                                });
                                                return marker;
                                        }

                                var geocoder = new google.maps.Geocoder();
                                        function showAddress(val) {
                                        infoWindow.close();
                                                geocoder.geocode({
                                                'address': val
                                                }, function (results, status) {
                                                if (status == google.maps.GeocoderStatus.OK) {
                                                marker.setPosition(results[0].geometry.location);
                                                        geocode(results[0].geometry.location);
                                                } else {
                                                alert("Sorry but Google Maps could not find this location.");
                                                }
                                                });
                                        }
                                var infoWindowx;
                                        function geocode(position, markerx, name) {
                                        if (infoWindowx) {
                                        infoWindowx.close();
                                        }
                                        geocoder.geocode({
                                        latLng: position
                                        }, function (responses) {
                                        var html = '';
                                                window.location.hash = '#' + markerx.getPosition().lat() + "," + markerx.getPosition().lng();
                                                if (responses && responses.length > 0) {
                                        html += '<h3>' + name + '</h3><hr/>' + responses[0].formatted_address;
                                                // html += '<hr /><iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Fdigital.inspiration&amp;width&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=21&amp;appId=609713525766533" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:21px; width:120px" allowTransparency="true"></iframe>';
                                                //html += '<span style="float:right"><a target="_blank" href="https://twitter.com/intent/tweet?related=labnol&via=labnol&url=' + encodeURIComponent(window.location.href) + '&text=I%20am%20at%20' + encodeURIComponent(responses[0].formatted_address) + '">Tweet #location</a></span><br />';
                                        } else {
                                        html += 'Sorry but Google Maps could not determine the approximate postal address of this location.';
                                        }
                                        html += '<hr />' + 'Latitude : ' + markerx.getPosition().lat() + ', Longitude: ' + markerx.getPosition().lng();
                                                map.panTo(markerx.getPosition());
                                                infoWindowx = new google.maps.InfoWindow();
                                                infoWindowx.setContent("<div id='iw'>" + html + "</div>");
                                                infoWindowx.open(map, markerx);
                                        });
                                        }
                                var marker2 = [];
                                        var marker3 = null;
                                        function createMarker2(latlng, name, image) {
                                        var html = name;
                                                marker3 = new google.maps.Marker({map: map, position: latlng, icon: image});
                                                var infowindow = new google.maps.InfoWindow({content: html});
                                                google.maps.event.addListener(marker3, 'click', function () {
                                                var point = marker3.getPosition();
                                                        geocode(point, this, html);
                                                });
                                                return marker3;
                                        }
                                function clearautomarker() {
                                if (marker2 != null) {
                                for (var i = 0; i < marker2.length; i++) {
                                marker2[i].setMap(null);
                                }
                                marker2 = [];
                                }
                                }
                                function fetchDriver() {
                                clearautomarker();
                                        var x = new XMLHttpRequest();
                                                 var baseUrl = $('body').data("base");
                                        var url = baseUrl + "location/fetchDriverlocation.php";
                                                 x.onreadystatechange = function ()
                                                 {    
                                        if (x.readyState == 4)    
                                                     {

                                        var d = x.responseText;
                                                // Parsing XML to get the data
                                                //alert(JSON.stringify(d));
                                                var bounds = new google.maps.LatLngBounds();
                                                var markerNodes = jQuery.parseJSON(d);
                                                var cnt = markerNodes.length;
                                                for (var j = 0; j < cnt; j++)
                                        {
                                        var item = markerNodes[j];
                                                if (item) {
                                        var id = item.categoryid % 10;
                                                if (!id) {
                                        id = 10;
                                        }
                                        var shadow = new google.maps.MarkerImage(baseUrl + 'images/markericon' + id + '.png',
                                                new google.maps.Size(22, 44),
                                                new google.maps.Point(0, 0),
                                                new google.maps.Point(0, 32));
                                                var shape = {
                                                coord: [1, 1, 1, 20, 18, 20, 18, 1],
                                                        type: 'poly'
                                                };
                                                var info = item.name + '<p> ' + item.registration_no + '</p>';
                                                var latlng = new google.maps.LatLng(
                                                        parseFloat(item.latitute),
                                                        parseFloat(item.longitude));
                                                var markerx = createMarker2(latlng, info, shadow);
                                                markerx.setMap(map);
                                                marker2.push(markerx);
                                                bounds.extend(latlng);
                                        }
                                        }
                                        if (!bounds.isEmpty()) {
                                        //map.fitBounds(bounds);
                                        }

                                        }
                                        }
                                x.open("get", url, "true");
                                        x.send();
                                }

                                function getNearestDriver(latitude, longitude, vehicle) {
                                $.get("../location/fetchNearestDriver.php?latitude=" + latitude + "&longitude=" + longitude + "&vehicle=" + vehicle, function (data) {
                                // alert(data);
                                var item = JSON.parse(data);
                                        var driver = "<ul>";
                                        for (var i = 0; i < item.length; i++) {
                                var cont = item[i];
                                        driver += "<li ><div class='address'>" + cont.name + " (reg no: " + cont.registration_no + ")" + "</div><div class='landmark'> Distance: " + cont.distance.toFixed(2) + " meter</div></li>";
                                }
                                driver += "</ul>";
                                        $("#driver_list").html(driver);
                                });
                                }
                                setInterval('fetchDriver()', 20000);
                                function edit_fav_booking(){
                                    formSubmit('edit_fav_location', 'edit_fav_location_result', 'favorite_update.php');
                                    fetchpickupDrop($("#customer_id").val());
                                }
                                
                                function populatebooking(){
                                     $(".overflow").show();

            $.post('booking_update.php', {mode: "editbooking", id: <?php echo $_GET['booking'];?>}).done(function (data) {
                var form = document.forms['booking_form'];
                // create the text variables

                if (data != 'false') {
                    var text = data
                    text = text.replace(/(^\s+|\s+$)/, '');
                    text = "(" + text + ");";
                    // attempt to create valid JSON
                    try
                    {
                        var json = eval(text)
                    }
                    catch (err)
                    {
                        alert('That appears to be invalid JSON!')
                        return false;
                    }
                   
                      json.pickup_date = moment(json.pickup_date, "YYYY-MM-DD hh:mm:s").format("DD/MM/YYYY hh:mm");
                    $(form).populate(json, {resetForm: true, debug: 1});
                     $('#customer_category option[value="' + json.customer_category + '"]').prop('selected', true);
                     $("#total_exp_fare").val(json.total_fare_edit);
                    fetchpickupDrop(json.customer_id);
                    vehicle_info(json.vehicle);
                    GeocodeFromAddress();
                    getNearestDriver(json.pickup_lat,json.pickup_lng,json.vehicle);
                    calculate_totalfare();
                    $(".overflow").hide();
                }
                else {
                    $(".overflow").hide();
                    alert("No Booking Found");
                }
            });
       
    }
    
                                    
  
        </script>
        <script src="../js/jquery.populate.js"></script>
        <script src="../js/moment.js"></script>
       <style>
        .pac-container{
            z-index: 9999;
        }
    </style>
    <link rel="stylesheet" href="../css/booking.css">
    <?php include '../includes/footer.php'; ?>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">Edit Favorite Location</h4>
                </div>
                <div class="modal-body" id="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="edit_fav_booking()">Update </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<!-- Perform search over radius
   var request = {
        location: searchArea,
        radius: parseFloat(document.getElementById("distance").value) * 1609.3, //convert miles to meters
        keyword: "coffee",
        rankBy: google.maps.places.RankBy.PROMINENCE
      };
      service.nearbySearch(request, callback);         
    }-->