<?php
require '../includes/define.php';
//verifyLogin("callCenter");
?>
<html>
    <head>
        <?php include '../includes/head.php'; ?>
    </head>
    <body data-base="<?php echo BASE_URL; ?>">
        <?php include '../includes/header.php'; ?>
        <!-- General form elements -->
        <div class="widget row-fluid">
            <div class="navbar">
                <div class="navbar-inner">
                    <h6><i class="fa fa-align-justify"></i>Booking List</h6>
                </div>
            </div>
            <div class="container_content">
                <!-- Action tabs -->

                <!-- /action tabs -->
                <!-- Chart -->
                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIkQyG2nXYEVIOt3cce94TEdWDVuBG7MY" type="text/javascript"></script>
                <script src="<?php echo BASE_URL ?>js/maps.js" type="text/javascript"></script>
                <script>
                    //function initialize() {
                    //  var mapOptions = {
                    //    center: new google.maps.LatLng(22.722096, 75.857817),
                    //    zoom: 8
                    //  };
                    //  var map = new google.maps.Map(document.getElementById('map-canvas'),
                    //    mapOptions);
                    //
                    //  var input = /** @type {HTMLInputElement} */(
                    //      document.getElementById('pickup_address'));
                    //
                    //  var types = document.getElementById('type-selector');
                    //  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
                    //  map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);
                    //
                    //  var autocomplete = new google.maps.places.Autocomplete(input);
                    //  autocomplete.bindTo('bounds', map);
                    //
                    //  var infowindow = new google.maps.InfoWindow();
                    //  var marker = new google.maps.Marker({
                    //    map: map,
                    //    anchorPoint: new google.maps.Point(0, -29)
                    //  });
                    //
                    //  google.maps.event.addListener(autocomplete, 'place_changed', function() {
                    //    infowindow.close();
                    //    marker.setVisible(false);
                    //    var place = autocomplete.getPlace();
                    //    if (!place.geometry) {
                    //      return;
                    //    }
                    //
                    //    // If the place has a geometry, then present it on a map.
                    //    if (place.geometry.viewport) {
                    //      map.fitBounds(place.geometry.viewport);
                    //    } else {
                    //      map.setCenter(place.geometry.location);
                    //      map.setZoom(17);  // Why 17? Because it looks good.
                    //    }
                    //    marker.setIcon(/** @type {google.maps.Icon} */({
                    //      url: place.icon,
                    //      size: new google.maps.Size(71, 71),
                    //      origin: new google.maps.Point(0, 0),
                    //      anchor: new google.maps.Point(17, 34),
                    //      scaledSize: new google.maps.Size(35, 35)
                    //    }));
                    //    marker.setPosition(place.geometry.location);
                    //    marker.setVisible(true);
                    //
                    //    var address = '';
                    //    if (place.address_components) {
                    //      address = [
                    //        (place.address_components[0] && place.address_components[0].short_name || ''),
                    //        (place.address_components[1] && place.address_components[1].short_name || ''),
                    //        (place.address_components[2] && place.address_components[2].short_name || '')
                    //      ].join(' ');
                    //    }
                    //
                    //    infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
                    //    infowindow.open(map, marker);
                    //  });

                    // Sets a listener on a radio button to change the filter type on Places
                    // Autocomplete.
                    //  function setupClickListener(id, types) {
                    //    var radioButton = document.getElementById(id);
                    //    google.maps.event.addDomListener(radioButton, 'click', function() {
                    //      autocomplete.setTypes(types);
                    //    });
                    //  }
                    //
                    //  setupClickListener('changetype-all', []);
                    //  setupClickListener('changetype-address', ['address']);
                    //  setupClickListener('changetype-establishment', ['establishment']);
                    //  setupClickListener('changetype-geocode', ['geocode']);
                    //}
                    //
                    //google.maps.event.addDomListener(window, 'load', initialize);

                </script>
                <div class="container_content fl clr">
                    <div class="cont_container mt15 mt10">
                        <div class="content_middle"> 
                            <table style="width: 100%">
                                <tr>
                                    <td style="width:20%">  <form method="POST" enctype="multipart/form-data" class="form" action="" name="bookingNew" id="bookingNew">

                                            <table class="bookingtable" cellpadding="5" cellspacing="0" >
                                                <tbody><tr>
                                                        <td valign="top" width="20%"><label>Customer Number</label><span class="star">*</span></td>   
                                                        <td><div class="new_input_field" style=""><input type="number" maxlength="12" minlength="10" name="customer_number" id="Number" title="Enter Customers Number,max 13 number, min 10 numbers" maxlength="250" value="" required></div>
                                                        </td></tr>

                                                    <tr>
                                                        <td valign="top" width="20%"><label>Customer Name</label><span class="star">*</span></td>   
                                                        <td><div class="new_input_field" style=""><input  type="text" name="customer_name" id="customer_name"   title="Enter Customer Name" value="" required></div>
                                                            <span class="error"></span>
                                                        </td>

                                                    </tr> 

                                                    <tr>
                                                        <td valign="top" width="20%"><label>Address of Customer</label><span class="star"></span></td>   
                                                        <td><div class="new_input_field" style=""><textarea  rows="5" cols="35" style="resize:none;" name="customer_address" id="customer_address" title="Enter Customer Address" maxlength="150"></textarea></div>
                                                            <span class="error"></span>
                                                        </td>
                                                    </tr>                              


                                                    <tr>
                                                        <td valign="top" width="20%"><label>Pickup Address </label><span class="star">*</span></td>   
                                                        <td><div class="new_input_field" style=""><input type="text"   name="pickup_address" id="pickup_address" title="Enter Pick up Address"  required></div>
                                                            <span class="error"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="top" width="20%"><label>Destination Address  </label><span class="star">*</span></td>   
                                                        <td><div class="new_input_field" style=""><textarea  rows="5" cols="35" style="resize:none;" name="destination_address" id="destination_address" title="Enter Destination Address" maxlength="150" required></textarea></div>
                                                            <span class="error"></span></td>
                                                <input type="button" value="get on map" onclick="calcRoute('pickup_address', 'destination_address')"
                                                       </tr>
                                                <tr>
                                                    <td valign="top" width="20%"><label>Vehicle Type</label><span class="star">*</span></td>   
                                                    <td>
                                                        <div class="formRight">
                                                            <div class="selector" id="uniform-user_type">
                                                                <select name="vehicle_type" id="vehicle_type" title="Select Vehicle Type">
                                                                    <option value="">-- Select --</option>
                                                                    <option value="Small">Small</option>
                                                                    <option value="Medium" >Medium</option>
                                                                    <option value="Large">Large</option>

                                                                </select>
                                                            </div>
                                                            <span class="error"></span>
                                                        </div>
                                                    </td>
                                                </tr>             
                                                <tr>
                                                    <td valign="top">&nbsp;</td>
                                                    <td style="padding-left:0px;">
                                                        <div class="button dredB"> <input type="reset" name="editsettings_reset" title="Reset" value="Reset"></div>
                                                        <div class="button greenB">
                                                            <input type="hidden" name="mode" value="new"/>
                                                            <input type="button" title="Book" value="Book" onclick="formSubmit('bookingNew', 'result', 'booking_update.php')"></div>

                                                    </td></tr>

                                                <tr>
                                                    <td colspan="3" id="result">

                                                    </td></tr>
                                                </tbody></table>

                                        </form>
                                    </td>
                                    <td>

                                        <div id="map-canvas" class="boookingpagegraph"  style="width: 100%;height: 600px;"></div>
                                    </td>
                                </tr>
                            </table>
                            <div id="directionsPanel" style=""></div>
                        </div>

                        <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
                    </div>

                </div>    



            </div>

        </div>
    <style>
        .boookingpagegraph{
            width: 550px;
            height: 400px;
        }
        .bookingtable{


        }
    </style>
    <!-- /content wrapper -->
    <?php include '../includes/footer.php'; ?>
</body>
</html>
