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

            <script src="http://maps.google.com/maps/api/js?key=AIzaSyBIkQyG2nXYEVIOt3cce94TEdWDVuBG7MY&libraries=places,geometry&amp;sensor=false" type="text/javascript"></script>
            <script type="text/javascript" src="<?php echo BASE_URL; ?>js/gmaps.js"></script>
            <script type="text/javascript" src="<?php echo BASE_URL; ?>js/site.js"></script>
            <script type="text/javascript" src="<?php echo BASE_URL; ?>js/jquery-ui.multidatespicker.js"></script>
            <!-- time picker start-->
            <script type="text/javascript" src="<?php echo BASE_URL; ?>js/jquery.validate.js"></script>
            <div class="crumbs">
                <ul id="breadcrumbs" class="breadcrumb">
                    <li>

                        <a href=<?php echo BASE_URL; ?>admin/dashboard title=<?php echo BASE_URL; ?>admin/dashboard>Home</a>		                </li>
                    <li class="active"><a title="">Dashboard</a></li>
                </ul>

            </div>
            <div class="errorp alert-message">
                <a  class="close"></a>
                <p>Note : User will create automatically if not exist !!</p>
            </div>
            <div class="container_content  clr">
                <div class="cont_container mt15 mt10">
                    <div class="content_middle">    
                        <form name="booking_form" class="form" id="booking_form" action="" method="post" enctype="multipart/form-data" onSubmit="check_passengerexit()">
                            <div class="first_fieldset">	
                                <fieldset class="booking-form-fieldset">
                                    <legend>PASSENGERS INFORMATION</legend>
                                    <div class="new_booking_field ">
                                        <input type="text" title="Enter the first name with atleast 3 character" class="required" name="firstname" id="firstname" value=""  minlength="3"  placeholder="First Name"  autocomplete="off" />
                                        <input name="customer_id" id="customer_id" type="hidden" >

                                        <span id="unameavilable" class="error"> </span>
                                    </div>

                                    <div class="new_booking_field mt10">
                                        <input type="text" title="Enter the email address" class="required email" name="email" id="email" value=""  maxlength="50" placeholder="Email" autocomplete="off" onBlur="checkuseremail(this.value)" />
                                        <span id="uemailavilable" class="error"> </span>
                                    </div>
                                    <div class="new_booking_field mt10">
                                        <input type="text" title="Enter the mobile number minimum with 7 numbers" name="phone" id="phone" class="required digits" value="" minlength="7" maxlength="20" placeholder="Mobile" autocomplete="off" onBlur="checkuserphone(this.value)" />
                                        <span id="uphoneavilable" class="error"></span>
                                    </div>
                                    <div class="new_booking_field mt10">
                                        <select type="text" title="Select Customer Category" name="customer_category" id="customer_category" class="required " autocomplete="off">
                                            <option class="Regular">Regular</option>
                                            <option class="Corporate">Corporate</option>
                                        </select>
                                        <span id="uphoneavilable" class="error"></span>
                                    </div>
                                    <div class="new_booking_field mt20 mb50"></div>
                                </fieldset>

                                <fieldset class="booking-form-fieldset">
                                    <legend>BOOKING</legend>
                                    <div class="new_booking_field">
                                        <input type="text" title="Enter the Pickup Address" class="required " name="current_location" id="" value=""  autocomplete="off"  placeholder="Enter the Pickup Address" />
                                    </div>
                                    <div class="new_booking_field">
                                        <input type="text" title="Enter the Pickup Landmark" class="required " name="pick_up_landmark" id="current_location" value=""  autocomplete="off"  placeholder="Enter the Pickup Landmark" onChange="GeocodeFromAddress()"/>

                                        <input type="hidden" name="pickup_lat" id="pickup_lat" value=""><input type="hidden" name="pickup_lng" id="pickup_lng" value="">
                                    </div>
                                    <div class="new_booking_field mt10">
                                        <input type="text" title="Enter the Drop Address" class="required " name="drop_location" id="" value=""  autocomplete="off" placeholder="Enter the Drop Location" /> 
                                    </div>
                                    <div class="new_booking_field mt10">
                                        <input type="text" title="Enter the Drop Location" class="required " name="drop_landmark" id="drop_location" value=""  autocomplete="off" placeholder="Enter the Drop Landmark" onChange="GeocodeFromAddress()"/>
                                        <input type="hidden" name="drop_lat" id="drop_lat" value=""><input type="hidden" name="drop_lng" id="drop_lng" value="">

                                    </div>
                                    <div class="new_booking_field mt10">
                                        <input type="text" title="Write a note to driver" name="notes" id="notes" value=""  autocomplete="off"  placeholder="Write a note to driver" />		     	
                                    </div>
                                    <div class="new_booking_field mt10">
                                        <input type="text" title="Pickup Date" class="" name="pickup_date" id="pickup_date" value="<?php echo date("d/m/Y h:i", strtotime(date("Y-m-d h:i") . "+1 hours")); ?>"  autocomplete="off" placeholder="Today" readonly />
                                    </div>
                                    <div class="new_booking_field mt10">
                                        <input type="text" title="Enter in round value(Kg)" class="required onlynumbers" name="luggage" id="luggage" value=""  autocomplete="off" placeholder="Volume" />
                                    </div>
                                    <div class="new_booking_field mb20 clr"></div>			
                                </fieldset>	
                            </div>
                            
                            
                            <div class="second_fieldset third_fieldset fl ml20">	
                                <div id="show_suggestion" style="display: none">
                                    <div id="show_suggested"><p style="line-height: 32px;font-size:1.063em;font-weight:bold;text-transform:capitalize; color:#ffc000;" >Favorite journey and locations</p></div>
                                    <div id="locations_journeys" class="locations">
                                        <h2>Favourite Journeys</h2>
                                        <ul id="load_journey">
                                            <li>No Data Found!</li>		</ul>
                                    </div>

                                    <div id="locations_locations" class="locations mt20 mb20">
                                        <h2>Favourite Locations</h2>
                                        <ul id="load_location">
                                            <li>No Data Found!</li>		</ul>
                                    </div>
                                </div>	


                                <fieldset class="booking-form-fieldset">
                                    <legend>VEHICLE</legend>
                                    <div class="formRight">
                                        <div class="selector" id="uniform-user_type">
                                            <select name="vehicle" id="vehicle" class="required" title="Select the Taxi Model" OnChange="change_minfare(this.value);" style="width:290px;">
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
                                    </div>	
                                    <label for="taxi_model" generated="true" class="errorvalid" style="display:none;width:250px;">Select the Taxi Model</label>
                                    <div class="new_booking_field mt20 mb50"></div>
                                </fieldset>
                                <fieldset class="booking-form-fieldset">
                                    <legend>DIRECTIONS</legend>
                                    <div id="directions"></div>
                                    </filedset>
                            </div>
                            <div class="second_fieldset  fl ml50" id="payment_sec" >	
                                <fieldset class="booking-form-fieldset">
                                    <legend>  PAYMENT  </legend>
                                    <div class="new_booking_field mt10">
                                        <ul id="acc">
                                            <li><label>Journey :</label><span id="find_duration">0 mins</span></li>
                                            <li><label>Distance :</label><span id="find_km"></span></li>
                                            <li><label>Fare :</label><span id="min_fare" class="">0</span><span>&#8377; </span></li>
                                            <li><label>Subtotal :</label><span id="sub_total"></span><span>&#8377; </span></li>				
                                            <li><label>Model Min Fare :</label><input type="text" readonly name="model_minfare" id="model_minfare" value="0" ><span>&#8377; </span></li>
                                        </ul>
                                    </div>	
                                    <div class="new_booking_field mt10 clr">
                                        <ul id="acc">
                                            <li><label></label><span id="total_price">0</span><span>Total : &#8377;</span></li>
                                        </ul>
                                    </div>	

                                    <div class="new_booking_field mt10">
                                        <ul id="acc" style="display:none;">
                                            <li><label>Description :</label><span id="desc">Rate Kilometer</span></li>
                                            <li><label>Value :</label><span>$</span><span id="min_value"></span></li>

                                        </ul>

                                        <input type="hidden" name="distance_km" id="distance_km" value="0" >
                                        <input type="hidden" name="total_fare" id="total_fare" value="0" >
                                        <input type="hidden" name="total_duration" id="total_duration" value="0" >
                                        <input type="hidden" name="city_id" id="city_id" value="" >
                                        <input type="hidden" name="cityname" id="cityname" value="" >
                                        <input type="hidden" name="mode" value="booking"/>
                                        <input type="hidden" name="rate" id="rate" value="" >
                                        <div class="mt10 button greenB  mb20" >
                                            <input type="button" class="my_btn" style="background:#FF0; background-image:none !important;" name="create" value="Create" onClick="formSubmit('booking_form', 'form_result', 'booking_update.php')">
                                        </div>
                                        <div class="form_result"  style="width:100%; float:none;" id="form_result">
                                        </div>
                                    </div>	
                                    <div class="new_booking_field mt20 "></div>
                                </fieldset>
                                <fieldset class="booking-form-fieldset">
                                    <legend>MAP</legend>
                                    <div id="map" ></div>

                                    <div style="display:none;">
                                        <table>
                                            <tr>
                                                <td>Start altitude:</td>
                                                <td id="start"></td>
                                            </tr>
                                            <tr>
                                                <td>End altitude:</td>
                                                <td id="end"></td>
                                            </tr>
                                            <tr>
                                                <td>Maximum altitude:</td>
                                                <td id="max"></td>
                                            </tr>
                                            <tr>
                                                <td>Minimum altitude:</td>
                                                <td id="min"></td>
                                            </tr>
                                            <tr>
                                                <td>Distance:</td>
                                                <td id="distance"></td>
                                            </tr>
                                            <tr>
                                                <td>Total ascent:</td>
                                                <td id="ascent"></td>
                                            </tr>
                                            <tr>
                                                <td>Total descent:</td>
                                                <td id="descent"></td>
                                            </tr>
                                        </table>
                                    </div>	
                                    <div class="new_booking_field mb20" ></div>
                                </fieldset>	
                            </div>
                        </form>
                    </div>
                    <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
                </div>
                <script type="text/javascript" src="<?php echo BASE_URL; ?>js/script.js" defer></script>
                <script type="text/javascript">
                                                $(document).ready(function () {
                                                    $('#pickup_date').datetimepicker({
                                                        dateFormat: 'dd/mm/yy',
                                                        timeFormat: 'HH:mm',
                                                        minDate: new Date(<?php echo date("Y, m, d, H, i", strtotime(date("Y-m-d H:i:s") . " +1 hours -1 month")); ?>)});
                                                    $("#firstname").focus();

                                                    $("#addcompany_form").validate();
                                                    jQuery.validator.addMethod('cmpenddt', function (value) {
                                                        var cstartdate = document.getElementById('frmdate').value;
                                                        var cenddate = document.getElementById('todate').value;
                                                        return (cenddate > cstartdate);
                                                    }, '...');

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
                                                        source: 'booking_update.php?mode=autocompleteFirstname',
                                                        select: function (event, ui) {
                                                            console.log(ui.item.id);
                                                            $('#customer_id').val(ui.item.id);
                                                            $('#firstname').val(ui.item.customer_name);
                                                            $('#email').val(ui.item.customer_email);
                                                            $('#phone').val(ui.item.customer_number);
                                                            $('#customer_category').val(ui.item.customer_category);
                                                            return false;
                                                        },
                                                        minLength: 1
                                                    });
                                                    $("#email").autocomplete({
                                                        source: 'booking_update.php?mode=autocompleteEmail',
                                                        select: function (event, ui) {
                                                            console.log(ui.item.id);
                                                            $('#customer_id').val(ui.item.id);
                                                            $('#firstname').val(ui.item.customer_name);
                                                            $('#email').val(ui.item.customer_email);
                                                            $('#phone').val(ui.item.customer_number);
                                                            $('#customer_category').val(ui.item.customer_category);
                                                            return false;
                                                        },
                                                        minLength: 1
                                                    });



                                                    function log(message) {
                                                        $("#email").text(message);
                                                    }
                                                    $('#fixedprice').blur(function () {
                                                        var price = $(this).val();
                                                        if (price == '')
                                                        {
                                                            //$('#show_suggestion').hide();	
                                                            $('#min_fare').removeClass('strike');
                                                            var tot_price = $('#total_fare').val();
                                                            $('#total_price').html(tot_price);
                                                        }
                                                        else
                                                        {	//$('#show_suggestion').hide();
                                                            $('#total_price').html(price);
                                                            $('#min_fare').addClass('strike');
                                                        }
                                                    });

                                                    $('#firstname').change(function () {
                                                        $('#passenger_id').val('');
                                                        //$('#email').val('');
                                                        $('#email').removeAttr('readonly');
                                                        //$('#phone').val('');
                                                        $('#phone').removeAttr('readonly');
                                                        $('#show_group').hide();
                                                        $('#usergroup_list').html('');
                                                        //$('#load_location').html('');
                                                        //$('#load_journey').html('');
                                                        //$('#show_suggestion').hide();
                                                    });
                                                    $('#email').change(function () {
                                                        $('#passenger_id').val('');
                                                        //$('#firstname').val('');
                                                        $('#firstname').removeAttr('readonly');
                                                        //$('#phone').val('');
                                                        $('#phone').removeAttr('readonly');
                                                        $('#show_group').hide();
                                                        $('#usergroup_list').html('');
                                                        //$('#load_location').html('');
                                                        //$('#load_journey').html('');
                                                        //$('#show_suggestion').hide();
                                                    });
                                                    $('#phone').change(function () {
                                                        $('#passenger_id').val('');
                                                        //$('#email').val('');
                                                        $('#email').removeAttr('readonly');
                                                        //$('#firstname').val('');
                                                        $('#firstname').removeAttr('readonly');
                                                        $('#show_group').hide();
                                                        $('#usergroup_list').html('');
                                                        //$('#load_location').html('');
                                                        //$('#load_journey').html('');
                                                        //$('#show_suggestion').hide();
                                                    });
                                                });
                                             

                                                function change_fromtolocation(fromlocation, tolocation)
                                                {
                                                    $('#current_location').val(urldecode(fromlocation));
                                                    $('#drop_location').val(urldecode(tolocation));
                                                    GeocodeFromAddress();
                                                }

                                                function urldecode(str) {
                                                    return decodeURIComponent((str + '').replace(/\+/g, '%20'));
                                                }

                                                function popup_location(fid)
                                                {
                                                    $('#add_pick_drop').remove();
                                                    $('#load_location li').removeClass('location_selected');
                                                    var p = $("#fid_" + fid);
                                                    var position = p.position();
                                                    var pheight = (position.top) - 20;

                                                    $("<div id='add_pick_drop' style='top:" + pheight + "px; display: block;'><div id='close_location' style='color:black;float:right;padding:5px 5px 5px 5px ! important;'>X</div><div class='button dredB add_pic_but'><input type='button' value='Add To Pick Up' title='Add To Pick Up' id='add_to_pickup' onClick='add_booking_pickup(" + fid + ");'></div><div class='button greenB add_pic_but'><input type='button' value='Add To Drop off' title='Add To Drop off'  id='add_to_dropoff' onClick='add_booking_dropoff(" + fid + ");'></div></div>").insertAfter('#fid_' + fid);
                                                    $('#selectclass_' + fid).addClass('location_selected');

                                                    $('#close_location').click(function () {
                                                        $('#add_pick_drop').remove();
                                                    });


                                                }

                                                function add_booking_pickup(fid)
                                                {

                                                    var pickuplocation = $('#fid_' + fid).text();
                                                    $('#current_location').val(urldecode(pickuplocation));
                                                    $('#add_pick_drop').remove();
                                                    GeocodeFromAddress();
                                                    $('#add_pick_drop').remove();
                                                }

                                                function add_booking_dropoff(fid)
                                                {
                                                    var droplocation = $('#fid_' + fid).text();
                                                    $('#drop_location').val(urldecode(droplocation));
                                                    $('#add_pick_drop').remove();
                                                    GeocodeFromAddress();
                                                }

                                                $(function () {

                                                    $('#add_exclusion').click(function () {
                                                        var newRow = $("#sub_add tr").length + 1;
                                                        $("#sub_add").append('<tr id="row_' + newRow + '"><td><input type="text" placeholder="Exclus.start" name="exclus_start[]" id="exclus_start' + newRow + '"  class="mt10" style="width:120px;"  title=""><br><span id="error' + newRow + '" style="display:none;color:red;font-size:11px;"></span><td><input type="text" placeholder="Exclus.end" name="exclus_end[]" id="exclus_end' + newRow + '"  class="mt10 " style="width:120px;margin-left:12px;" title=""></td><td><button type="button" class="remove_icon" onClick="return removetr_contact(' + newRow + ');"></td></tr>');

                                                        var date = new Date();
                                                        var currentMonth = date.getMonth(); // current month
                                                        var currentDate = date.getDate(); // current date
                                                        var currentYear = date.getFullYear(); //this year

                                                        $("#exclus_start" + newRow).datepicker({
                                                            showTimepicker: true,
                                                            showSecond: true,
                                                            dateFormat: 'yy-mm-dd',
                                                            stepHour: 1,
                                                            stepMinute: 1,
                                                            minDate: new Date(currentYear, currentMonth, currentDate),
                                                            stepSecond: 1
                                                        });


                                                        $("#exclus_end" + newRow).datepicker({
                                                            showTimepicker: true,
                                                            showSecond: true,
                                                            dateFormat: 'yy-mm-dd',
                                                            stepHour: 1,
                                                            stepMinute: 1,
                                                            minDate: new Date(currentYear, currentMonth, currentDate),
                                                            stepSecond: 1
                                                        });


                                                        return false;
                                                    });

                                                });

                                                function removetr_contact(rowid) {
                                                    var r1 = "row_" + rowid;
                                                    $("#sub_add tr").each(function () {
                                                        if (r1 == $(this).attr('id')) {
                                                            $(this).remove();
                                                        }
                                                    });
                                                    return false;
                                                }
                                                function getid(rowid) {
                                                    var r2 = "row_" + rowid;
                                                }

                                                $('.cal_label').click(function (e) {
                                                    var id = $(this).text();

                                                    if ($('#monthDays_' + id).is(':checked'))
                                                    {
                                                        $('#monthDays_' + id).attr('checked', false);
                                                        $('#calactive_' + id).removeClass('green_active');
                                                    }
                                                    else
                                                    {
                                                        $('#monthDays_' + id).attr('checked', true);
                                                        $('#calactive_' + id).addClass('green_active');
                                                    }

                                                });

                                                $('.cale_label').click(function (e) {
                                                    var id = $(this).text();

                                                    if ($('#daysofweek_' + id).is(':checked'))
                                                    {
                                                        $('#daysofweek_' + id).attr('checked', false);
                                                        $('#calactive_' + id).removeClass('green_active');
                                                    }
                                                    else
                                                    {
                                                        $('#daysofweek_' + id).attr('checked', true);
                                                        $('#calactive_' + id).addClass('green_active');
                                                    }

                                                });



                                                /* Map */

                                                function updateStatus(status) {
                                                    $("#info").html(status);

                                                }

                                                function clearMarker() {
                                                    if (marker != null)
                                                        marker.setMap(null);
                                                }

                                                var marker = null;
                                                var working = false;


                                                var marker;
                                                var latlng = new google.maps.LatLng(54.559322, -4.174804);
                                                var options = {
                                                    zoom: 6,
                                                    center: latlng,
                                                    mapTypeId: google.maps.MapTypeId.ROADMAP
                                                };
                                                var map = new google.maps.Map(document.getElementById("map"), options);


                                                //map.controls[google.maps.ControlPosition.TOP_RIGHT].push(new FullScreenControl(map));

                                                // set up directions renderer
                                                var rendererOptions = {draggable: false};
                                                var directionsDisplay = new google.maps.DirectionsRenderer(rendererOptions);
                                                directionsDisplay.setMap(map);
                                                directionsDisplay.setPanel(document.getElementById("directions"));
                                                google.maps.event.addListener(directionsDisplay, 'directions_changed', function () {
                                                    updateStatus("Route changed");
                                                    if (!working) {
                                                        working = true;
                                                        GetElevation(directionsDisplay.directions.routes[0]);
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
                                                var autocomplete = new google.maps.places.Autocomplete(document.getElementById('current_location'), {});
                                                var toAutocomplete = new google.maps.places.Autocomplete(document.getElementById('drop_location'), {});


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
                                                        $('#payment_sec').show();
                                                    }
                                                    else
                                                    {
                                                        $('#drop_lat').val(latLong.lat());
                                                        $('#drop_lng').val(latLong.lng());
                                                        $('#payment_sec').show();
                                                    }

                                                }


                                                function GeocodeFromAddress() {
                                                    working = true;
                                                    // clear all fields
                                                    $("#info").html("");
                                                    $("#distance").html("");
                                                    $("#start").html("");
                                                    $("#end").html("");
                                                    $("#min").html("");
                                                    $("#max").html("");
                                                    $("#ascent").html("");
                                                    $("#descent").html("");
                                                    clearMarker();

                                                    // geocode from address
                                                    updateStatus("Locating from address...");



                                                    var geocoder = new google.maps.Geocoder();
                                                    var from = $("#current_location").val();

                                                    geocoder.geocode({'address': from},
                                                    function (results, status) {
                                                        if (results[0]) {
                                                            var result = results[0];
                                                            var fromLatLng = result.geometry.location;
                                                            $('#pickup_lat').val(result.geometry.location.lat());
                                                            $('#pickup_lng').val(result.geometry.location.lng());
                                                            GeocodeToAddress(fromLatLng);

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
                                                    var to = $("#drop_location").val();
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
                                                    var routeType = $('#routeType').val();
                                                    var travelMode = google.maps.DirectionsTravelMode.DRIVING;
                                                    if (routeType == "Walking")
                                                        travelMode = google.maps.DirectionsTravelMode.WALKING;
                                                    else if (routeType == "Public transport")
                                                        travelMode = google.maps.DirectionsTravelMode.TRANSIT;
                                                    else if (routeType == "Cycling")
                                                        travelMode = google.maps.DirectionsTravelMode.BICYCLING;

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

                                                    hm_hours = ('0' + Math.round(time / 3600) % 24).slice(-2) + ' hours';
                                                    hm_secs = ('0' + Math.round(time / 60) % 60).slice(-2) + ' mins';

                                                    if (hm_hours != '00 hours')
                                                    {
                                                        show_time = hm_hours + hm_secs;
                                                    }
                                                    else
                                                    {
                                                        show_time = hm_secs;
                                                    }


                                                    $("#distance").html(showDistance(distance));

                                                    var km = ((distance / 100) / 10).toFixed(1);
                                                    $('#find_km').html(km + " km");
                                                    $('#distance_km').val(km);
                                                    $('#desc').html('Rate Kilometer ' + km);

                                                    $('#find_duration').html(show_time);
                                                    $('#total_duration').val(show_time);
                                                    var model_minfare = $('#model_minfare').val();
                                                    $('#min_value').html(model_minfare);

                                                    var model_id = $('#vehicle').val();
                                                    var pickup_location = $('#current_location').val();

                                                    var pickup_lat = $('#pickup_lat').val();
                                                    var pickup_lng = $('#pickup_lng').val();

                                                    var pickup_latlng = pickup_lat + ',' + pickup_lng;

                                                    var city = "";
                                                    var state = "";
                                                    //11.0104033,76.94990280000002
                                                    geocoder = new google.maps.Geocoder();
                                                    var latlng = new google.maps.LatLng(pickup_lat, pickup_lng);
                                                    geocoder.geocode({'latLng': latlng}, function (results, status) {
                                                        if (status == google.maps.GeocoderStatus.OK) {
                                                            //Check result 0
                                                            var result = results[0];
                                                            //look for locality tag and administrative_area_level_1

                                                            for (var i = 0, len = result.address_components.length; i < len; i++) {
                                                                var ac = result.address_components[i];
                                                                if (ac.types.indexOf("locality") >= 0)
                                                                    city = ac.long_name;
                                                                if (ac.types.indexOf("administrative_area_level_1") >= 0)
                                                                    state = ac.long_name;
                                                            }
                                                            //only report if we got Good Stuff
                                                            if (city != '') {
                                                                //alert("Hello to you out there in "+city);
                                                                $('#cityname').val(city);
                                                                var city_id = $('#city_id').val();
                                                                // alert(km+","+model_id+","+city+","+city_id);
                                                                calculate_totalfare(km, model_id, city, city_id);

                                                            }
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

                                                /* Map */



                </script>


                <style>
                    #map{
                        display: block;
                        width: 100%;
                        height: 350px;
                        margin-top:20px;	
                        margin: 0 auto;
                        -moz-box-shadow: 0px 5px 20px #ccc;
                        -webkit-box-shadow: 0px 5px 20px #ccc;
                        box-shadow: 0px 5px 20px #ccc;
                    }
                    #map.large{
                        height:350px;
                    }
                </style>
            </div>

            <script type="text/javascript">

                function load_logcontent()
                {
                    var dataS = '';
                    var SrcPath = $('#baseurl').val();

                    var response;
                    $.ajax
                            ({
                                type: "POST",
                                url: SrcPath + "logs/get_log_content.php",
                                data: dataS,
                                cache: false,
                                dataType: 'html',
                                success: function (response)
                                {
                                    $('#log_content').html(response);

                                }
                            });


                }

                $(function () {

                    //var height = $(window).height()-300;
                    //var width = $(window).width()-530;
                    //document.getElementById("log_content").style.top=height+"px";
                    //document.getElementById("log_details").style.marginLeft=width+"px";
//                                                    load_logcontent();
//                                                    $('.age').age();


                    $("#jsrp_related").toggle(
                            function () {
                                var imgSrc = $("#close_btn").attr("src");
                                var findimg = imgSrc.split('/').pop();

                                //For Replacing the Menu Images
                                //==============================
                                var toggle_image = "http://demo.tagmytaxi.com/public/admin/images/minus.png";
                                if (findimg == "minus.png")
                                    var toggle_image = "http://demo.tagmytaxi.com/public/admin/images/maximize.png";

                                $("#close_btn").attr({src: toggle_image});

                                $("#jsrp_related").animate({height: "40px"}, {queue: false, duration: 500});
                            },
                            function () {
                                var imgSrc = $("#close_btn").attr("src");
                                var findimg = imgSrc.split('/').pop();

                                //For Replacing the Menu Images
                                //==============================
                                var toggle_image = "http://demo.tagmytaxi.com/public/admin/images/minus.png";
                                if (findimg == "minus.png")
                                    var toggle_image = "http://demo.tagmytaxi.com/public/admin/images/maximize.png";

                                $("#close_btn").attr({src: toggle_image});

                                $("#jsrp_related").animate({height: "300px"}, {queue: false, duration: 500});
                            });

                });
            </script>

            <style>
                #model_minfare{        
                    color: #383838;    
                    float: right;
                    width: 30px;  
                    padding: 2px;  
                    border: 0;      
                    font-size: 100%;  
                    font-weight: bold;
                }
            </style>
            <?php include '../includes/footer.php'; ?>
