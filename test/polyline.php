<div id="map_canvas" style="height:400px; width:400px"></div>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?libraries=geometry&sensor=false&v=3.3">
  
</script>
<script>
var markers=[];
var bounds = new google.maps.LatLngBounds()
</script>

<?php
include '../includes/define.php';
$sql="select location.latitute,location.longitude from location where booking_id=626";
$result=$objConnect->execute($sql);
$location=array();
while ($row = mysql_fetch_assoc($result)) {
    
    ?>
<script>
markers.push(new google.maps.LatLng(<?php echo $row['latitute'];?>,<?php echo $row['longitude'];?>));
bounds.extend(new google.maps.LatLng(<?php echo $row['latitute'];?>,<?php echo $row['longitude'];?>));
</script>      
            <?php
}

?>
<script>
    function dump(arr,level) {
	var dumped_text = "";
	if(!level) level = 0;
	
	//The padding given at the beginning of the line.
	var level_padding = "";
	for(var j=0;j<level+1;j++) level_padding += "    ";
	
	if(typeof(arr) == 'object') { //Array/Hashes/Objects 
		for(var item in arr) {
			var value = arr[item];
			
			if(typeof(value) == 'object') { //If it is an array,
				dumped_text += level_padding + "'" + item + "' ...\n";
				dumped_text += dump(value,level+1);
			} else {
				dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
			}
		}
	} else { //Stings/Chars/Numbers etc.
		dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
	}
	return dumped_text;
}
    dump(markers);
var map;
var polyline;


function init() {
  var moptions = {
    center: new google.maps.LatLng(22.7266833, 75.8796141),
    zoom: 14,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }

  map = new google.maps.Map(document.getElementById("map_canvas"), moptions);

  var iconsetngs = {
    path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW
  };
  var polylineoptns = {
    path: markers,
    strokeOpacity: 0.8,
    strokeWeight: 3,
    map: map,
    icons: [{
      icon: iconsetngs,
      offset: '100%'
    }]
  };
  map.fitBounds(bounds);
  polyline = new google.maps.Polyline(polylineoptns);
  var length = google.maps.geometry.spherical.computeLength(polyline.getPath());
 document.getElementById('order').value=length;
}
window.onload = init;</script>
<body>
<input type="text" id="order">
<?php echo $var="<script>document.getElementById('order').value;</script>";