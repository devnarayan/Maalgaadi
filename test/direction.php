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
                    <script type="text/javascript" src="http://maps.google.com/maps/api/js?libraries=geometry&sensor=false&v=3.3"></script>
                    <script>
                        var markers = [];
                        var bounds = new google.maps.LatLngBounds();
                        var c = bounds;
                    </script>
                    <?php
                    $sql3 = "select location.latitute,location.longitude from location where booking_id=$id and status='start trip'";
                    $result3 = $objConnect->execute($sql3);
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
                            var iconsetngs = {
                                path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW
                            };
                            var polylineoptns = {
                                path: markers,
                                strokeOpacity: 0.8,
                                strokeWeight: 1,
                                map: map,
                                optimized: true,
                                icons: [{
                                        icon: iconsetngs,
                                        offset: '100%'
                                    }]
                            };
                            //alert(bounds);
                            map.fitBounds(bounds);
                            if (bounds.isEmpty()) {
                                setTimeout("direction()", 2000);
                            }
                            else {
                                pathTotrack();
                                setInterval("pathTotrack()", 30000)
                            }

                            polyline = new google.maps.Polyline(polylineoptns);
                            var length = google.maps.geometry.spherical.computeLength(polyline.getPath());
                            length = length / 1000
                            $('#order').html(length.toFixed(2) + " km");


                        }



                        function createMarker(latlng, name, image) {
                            var html = name;
                            var marker = new google.maps.Marker({map: map, position: latlng, icon: image});
                            var infowindow = new google.maps.InfoWindow({content: html});
                            google.maps.event.addListener(marker, 'click', function () {
                                infowindow.open(map, marker);
                            });
                            return marker;
                        }
                        $(document).ready(function () {
                            google.maps.event.addDomListener(window, 'load', initialize);


                        });
                        function pathTotrack() {
                            $.post("fetchbookinglatlng.php?booking=<?php echo $id ?>", function (responseText) {
                                var d = responseText;
                                var locater = [];
                                var polyf;
                                var area = new google.maps.LatLngBounds();
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
                                        var lat1,lat2,lon1,lon2;
                                        
                                        var i = 0;
                                        if (i == 0) {
                                            lat1 = item.latitute;
                                            lon1 = item.longitude;
                                        } else {
                                            lat2 = item.latitute;
                                            lon2 = item.longitude;
                                            var R = 6371; // metres
                                            var φ1 = lat1.toRadians();
                                            var φ2 = lat2.toRadians();
                                            var Δφ = (lat2 - lat1).toRadians();
                                            var Δλ = (lon2 - lon1).toRadians();
                                            var a = Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
                                                    Math.cos(φ1) * Math.cos(φ2) *
                                                    Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
                                            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                                            var d = R * c;
                                           
                                            if (d < 1) {
                                                

                                                lat1 = item.latitute;
                                                lon1 = item.longitude;
                                                locater.push(new google.maps.LatLng(parseFloat(item.latitute), parseFloat(item.longitude)));
                                                area.extend(new google.maps.LatLng(parseFloat(item.latitute), parseFloat(item.longitude)));
                                            }
                                        }
                                        $i++;
                                    }
                                }
                                var iconh = {
                                    path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW
                                };
                                var polyg = {
                                    path: locater,
                                    strokeOpacity: 0.8,
                                    strokeWeight: 1,
                                    optimized: true,
                                    map: map,
                                    icons: [{
                                            icon: iconh,
                                            offset: '100%'
                                        }]
                                };
                                polyline.setMap(null);
                                polyline = new google.maps.Polyline(polyg);
                                var length = google.maps.geometry.spherical.computeLength(polyline.getPath());
                                length = length / 1000
                                $('#order').html(length.toFixed(2) + " km");
                                var geocoder = new google.maps.Geocoder();
                                var latlng = new google.maps.LatLng(
                                        parseFloat(markerNodes[cnt - 1].latitute),
                                        parseFloat(markerNodes[cnt - 1].longitude));
                                geocoder.geocode({
                                    latLng: latlng
                                }, function (responses) {
                                    $("#lastseen").html(responses[0].formatted_address);
                                    createMarker(latlng, responses[0].formatted_address, "../images/hit-002.png");
                                    map.setCenter(latlng);
                                });
                            });
                        }
                        function direction() {
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
                            directionsDisplay.setMap(map);
                        }
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
                                                                <h6>Booking no</h6>
                                                                <p> <?php echo sprintf("%07d", $row['id']); ?></p>
                                                            </div>
                                                        </div>
                                                        <div class="span6">
                                                            <div class="field-1">
                                                                <h6>Last Status</h6>
                                                                <p> <span id="order"></span> Traveled till now.<br/>
                                                                    <span id="lastseen"></span> </p>
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
                                                                    <?php if ($row['loading']) { ?><strong>Loading Charge</strong>: Rs.<?php echo $row['loading_charge']; ?> <br/><?php } ?>
                                                                    <?php if ($row['unloading']) { ?><strong>Un Loading Charge</strong>: Rs.<?php echo $row['loading_charge']; ?> <br/><?php } ?>
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
                                            <div class="span12">
                                                <?php
                                                if ($row['status'] == 1) {
                                                    echo "Trip not yet started";
                                                } elseif ($row['status'] == 7) {
                                                    ?>
                                                    <a href="completiondetail.php?booking=<?php echo $id; ?>" class="edit_btn">View Complete Logs</a>
                                                    Track Followed Route
                                                    <?php
                                                } elseif ($row['status'] > 1) {
                                                    ?>
                                                    Vehicle Running on th following route
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="row-fluid mt15">
                                            <div class="span12"> 

                                                <div id="map-canvas"></div>
                                                <div id="directions-panel" style="display: none;"></div>
                                            </div>
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