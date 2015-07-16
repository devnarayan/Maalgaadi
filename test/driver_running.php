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
                    <li class="active"><a title="">Driver Running</a></li>
                </ul>
            </div>

            <div class="cont_container mt15 mt10">
                <div class="content_middle"> 

                    <!-- Start Book-Now -->
                    <script type="text/javascript" src="http://maps.google.com/maps/api/js?libraries=geometry&sensor=false&v=3.3"></script>
                    <script>
                        var markers = [];
                        var bounds = new google.maps.LatLngBounds();
                        var c = bounds;
                    </script>
                    <?php
                    if($_POST['vehicle']){
                        
                    
                    $vehicle = $_POST['vehicle'];
                    $date = changeFormat("d/m/Y", "Y-m-d", $_POST['date']);
                    $sql3 = "select location.latitute,location.longitude from location where vehicle_id=$vehicle and date(addedon)='$date'";
                    $result3 = $objConnect->execute($sql3);
                    $location3 = array();
                    while ($row3 = mysql_fetch_assoc($result3)) {
                        ?>
                        <script>
                            markers.push(new google.maps.LatLng(<?php echo $row3['latitute']; ?>,<?php echo $row3['longitude']; ?>));
                            bounds.extend(new google.maps.LatLng(<?php echo $row3['latitute']; ?>,<?php echo $row3['longitude']; ?>));</script>      
                    
                        <?php
                        $last_lati=$row3['latitute'];
                        $last_longi=$row3['longitude'];
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
                               // pathTotrack();
                                //setInterval("pathTotrack()", 30000)
                            }

                            polyline = new google.maps.Polyline(polylineoptns);
                            var length = google.maps.geometry.spherical.computeLength(polyline.getPath());
                            length = length / 1000
                            $('#order').html(length.toFixed(2) + " km");
                            var geocoder = new google.maps.Geocoder();
                            var latlng = new google.maps.LatLng(
                                    parseFloat('<?php echo $last_lati;?>'),
                                    parseFloat('<?php echo $last_longi;?>'));
                            geocoder.geocode({
                                latLng: latlng
                            }, function (responses) {
                                $("#lastseen").html(responses[0].formatted_address);
                                createMarker(latlng, responses[0].formatted_address, "../images/hit-002.png");
                                map.setCenter(latlng);
                            });

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
                       
                    </script>
                    <?php }?>
                    <div class="banner">
                        <h2>
                            Driver Running
                        </h2>
                    </div>
                    <form method="post">
                        <table>
                            <tr>
                                <td>
                                    <div class="new_input_field" style="">
                                        <select name="vehicle" required="true">
                                            <option value="">Select Vehicle</option>
                                            <?php 
                                            $result=$objConnect->select("vehicle");
                                            while ($row = $objConnect->fetch_assoc()) {
                                                ?>
                                            <option value="<?php echo $row['id'];?>"><?php echo $row['name'].", ".$row['registration_no'];?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </td>
                                <td>
                                    <div class="new_input_field" style="">
                                        <input type="text"  name="date"   id="date" required="true">
                                    </div>
                                </td>
                            </tr>
                            <tr><td colspan="2" >
                                    <input type="submit" class="btn btn-success btn-large mt15" value="search"/>
                                </td></tr>
                        </table>
                    </form>
                 <?php if($_POST['vehicle']){ ?>
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
                                                                <p> <?php echo $date; ?> </p>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                
                                                 

                                                   
                                                  
                                                </div>
                                            </div>
                                       
                                        </div>
                                        <br/>
                                      
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
                    <?php }?>
                    <!-- End Book-Now -->
                </div>
                <div class="content_bottom"><div class="bot_left"></div><div class="bot_center"></div><div class="bot_rgt"></div></div>
            </div>

        </div>
        <script>
        $(document).ready(function(){
        $('#date').datepicker({
            maxDate:new Date(),
            dateFormat:'dd/mm/yy'
        });
        });
            </script>
        <?php include '../includes/footer.php'; ?>
    </body>
</html>