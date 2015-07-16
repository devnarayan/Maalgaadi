<?php include '../includes/define.php';?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Waypoints in directions</title>
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
      #panel {
        position: absolute;
        top: 5px;
        left: 50%;
        margin-left: -180px;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <?php 
    $result=$objConnect->selectWhere("booking","id=203");
    $row=$objConnect->fetch_assoc();
    ?>
    <script>
var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var map;

function initialize() {
  directionsDisplay = new google.maps.DirectionsRenderer();
  var chicago = new google.maps.LatLng(21.7679, 78.8718);
  var mapOptions = {
    zoom: 6,
    center: chicago
  }
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
  directionsDisplay.setMap(map);
}

function calcRoute() {
  var start = new google.maps.LatLng(<?php echo $row['pickup_lat'].",".$row['pickup_lng'];?>);
  var end = new google.maps.LatLng(<?php echo $row['drop_lat'].",".$row['drop_lng'];?>);
  var waypts = [];
  var checkboxArray = document.getElementById('waypoints');
  jQuery.unique(checkboxArray);
 
  for (var i = 0; i < checkboxArray.length; i++) {
  
        var latlngway=checkboxArray[i].value.split(",");
      waypts.push({
          
          location:new google.maps.LatLng(latlngway[0],latlngway[1]),
          stopover:false});
    
  }

  var request = {
      origin: start,
      destination: end,
      waypoints: waypts,
      optimizeWaypoints: true,
      travelMode: google.maps.TravelMode.DRIVING
  };
  directionsService.route(request, function(response, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      directionsDisplay.setDirections(response);
      var route = response.routes[0];
      var summaryPanel = document.getElementById('directions_panel');
      summaryPanel.innerHTML = '';
      // For each route, display summary information.
      for (var i = 0; i < route.legs.length; i++) {
        var routeSegment = i + 1;
        summaryPanel.innerHTML += '<b>Route Segment: ' + routeSegment + '</b><br>';
        summaryPanel.innerHTML += route.legs[i].start_address + ' to ';
        summaryPanel.innerHTML += route.legs[i].end_address + '<br>';
        summaryPanel.innerHTML += route.legs[i].distance.text + '<br><br>';
      }
    }
  });
}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body>
    <div id="map-canvas" style="float:left;width:70%;height:100%;"></div>
    <div id="control_panel" style="float:right;width:30%;text-align:left;padding-top:20px">
    <div style="margin:20px;border-width:2px;">
    <b>Start:</b>
    <select id="start">
        <option></option>
    </select>
    <br>
    <b>Waypoints:</b> <br>
    <i>(Ctrl-Click for multiple selection)</i> <br>
    <select multiple id="waypoints">
      <?php 
$result2=$objConnect->selectWhere("location","booking_id=203 and status like 'stop loadin%'");
$waypoints="";
while($row2=  mysql_fetch_assoc($result2)){
  
  ?>
        <option value="<?php echo $row2['latitute'].",".$row2['longitude'];?>"><?php echo $row2['latitute'].",".$row2['longitude'];?></option>
        <?php
}

?>
    </select>
    <br>
    <b>End:</b>
    <select id="end">
      <option value="Vancouver, BC">Vancouver, BC</option>
      <option value="Seattle, WA">Seattle, WA</option>
      <option value="San Francisco, CA">San Francisco, CA</option>
      <option value="Los Angeles, CA">Los Angeles, CA</option>
    </select>
    <br>
      <input type="submit" onclick="calcRoute();">
    </div>
    <div id="directions_panel" style="margin:20px;background-color:#FFEE77;"></div>
    </div>
  </body>
</html>