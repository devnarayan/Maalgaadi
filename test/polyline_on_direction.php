
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
		<title>Google Qualified JS Maps Application: polyline from directions</title>
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
		<script type='text/javascript' charset="utf-8" src='http://marx-tseng.appspot.com/maps/js/jquery-1.4.2.min.js'></script>
		
		<script type="text/javascript">
		
			function initialize() {
				var center = new google.maps.LatLng(24.7756,121.0062);
				
				var map = new google.maps.Map(document.getElementById('map_canvas'), {
			    	center: center,
			    	zoom: 13,
			    	mapTypeId: google.maps.MapTypeId.ROADMAP
			  	});

				var polyline = new google.maps.Polyline({
					path: [],
					strokeColor: "#708090",
					strokeWeight: 5
				});
				var origin=new google.maps.LatLng(24.832701,120.954924);
                                var destination=new google.maps.LatLng(24.802864,120.971575);
				var bounds = new google.maps.LatLngBounds();
				var directionsService = new google.maps.DirectionsService(); 
				var request = { 
					origin: new google.maps.LatLng(24.832701,120.954924), 
					destination: new google.maps.LatLng(24.802864,120.971575), 
					travelMode: google.maps.DirectionsTravelMode.DRIVING 
				};
				var marker=new google.maps.Marker({
  position:origin,
  
  
  });
   marker=new google.maps.Marker({
  [position:origin],
  [position:destination]

  
  });
  
				directionsService.route(request, function(result, status) { 
					if (status == google.maps.DirectionsStatus.OK) {
						path = result.routes[0].overview_path;
						
						$(path).each(function(index, item) {
							polyline.getPath().push(item);
							bounds.extend(item);
						})

						polyline.setMap(map);
                                                marker.setMap(map);
						map.fitBounds(bounds);
					}
				});
			}
		</script>
		
		<style type="text/css">
			html { height: 100% }
			body { height: 100%; margin: 0px; padding: 0px }
			#map_canvas { height: 100% }
		</style>
	</head>
	<body onload="initialize()">
  		<div id="map_canvas"></div>
  		
		<script type="text/javascript">
		
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-17413393-1']);
		  _gaq.push(['_trackPageview']);
		
		  (function() {
		    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();
		
		</script>
	</body>
</html>
