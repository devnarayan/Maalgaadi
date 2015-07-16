<script type="text/javascript" src="../js/jquery.min.js"></script> 
<link rel="stylesheet" href="../css/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>

<script src="http://maps.google.com/maps/api/js?key=AIzaSyBIkQyG2nXYEVIOt3cce94TEdWDVuBG7MY&libraries=places,geometry&amp;sensor=false" type="text/javascript"></script>
            <script type="text/javascript" src="../js/gmaps.js"></script>
            <script src="http://www.daftlogic.com/script/route-elevation.js" type="text/javascript"></script>
<script>

// JavaScript Document
//unit_handler
var FEET=
{
	label:"feet",
	f:function(distance)
	{
		return distance*3.2808399;
	}
};

var MILES=
{
	label:"miles",
	f:function(distance)
	{
		return distance/1609.344;
	}
};

var KMS=
{
	label:"km",
	f:function(distance)
	{
		return distance/1000;
	}
};

var NMILES=
{
	label:"nautical miles",
	f:function(distance)
	{
		return ((distance/1609.344)*(1/1.150779));
	}
};

var METRES=
{
	label:"metres",
	f:function(distance)
	{
		return (distance);
	}
};

var unit_handler=MILES;
//document.getElementById("cb_dist1").checked=true;
//unit_handler

//global varibles
var map;
var autopan;
var routePoints=new Array(0);
var routeMarkers=new Array(0);
var lines=[];
var lineWidth=1;
var lineColor='#ff0066';
var routePath;
var total_distance=0;
var togglemarkers=1;
var toggleGoogleBar=0;
var markerclickmode=0;
var geocoder;

//global varibles
//***********************************************************************
     
function initialize() 
{
	var latlng = new google.maps.LatLng(0,0);
	var myOptions = {zoom:1,center:latlng,mapTypeId:google.maps.MapTypeId.ROADMAP,draggableCursor:'crosshair',mapTypeControlOptions:{style:google.maps.MapTypeControlStyle.DROPDOWN_MENU}};
	map = new google.maps.Map(document.getElementById("map_canvas"),myOptions);
		
	if  (routefromurl!="0")
	{
		loadroutefromurl(routefromurl);
	}	
	else
	{
		LoadCookieRoute();
		LoadPosandSettings();
	}
	
	google.maps.event.addListener(map, 'moveend', function()
	{
		SavePosandSettings();
	});
	
	google.maps.event.addListener(map, 'zoom_changed', function()
	{
		SavePosandSettings();
	});
	
	google.maps.event.addListener(map, 'click', function(event)
	{
		clickatpoint(event.latLng);
 	});
		
	autopan=document.getElementById("autopan").checked;
	
	google.maps.event.addListenerOnce(map, 'tilesloaded', function() 
	{
		google.maps.event.addListener(map, 'maptypeid_changed', function()
		{
			SavePosandSettings();
		});
	});
	
	geocoder = new google.maps.Geocoder();
	
	//upload coordinated textbox
	change('notselected');
	empty();
}

function loadroutefromurl(routefromurl)
{
	var arr_points = routefromurl.split("|");
	for (var i = 0; i < arr_points.length; i++) 
	{		
		var lat = arr_points[i].split(",")[0];
		var lng = arr_points[i].split(",")[1];
		var point = new google.maps.LatLng(lat,lng);
		
		routePoints.push(point);
		var marker=placeMarker(point,routePoints.length);
		routeMarkers.push(marker);
	}		
	//add polyline
	routePath=getRoutePath();
	routePath.setMap(map);

	updateDisplay();
	
	ZoomOut();

	SaveCookieRoute();
}

function gotomylocation()
{
	var geocoder = new google.maps.Geocoder();
	if (google.loader.ClientLocation) 
	{
		var Lat = google.loader.ClientLocation.latitude;
		var Lng = google.loader.ClientLocation.longitude;
		var latlng = new google.maps.LatLng(Lat,Lng);
		map.panTo(latlng);
	}
	else
	{
		document.getElementById("btn_findlocation").value="Sorry, Location Not Available";
	}
}

function clickatpoint(point)
{
		routePoints.push(point);
		var marker=placeMarker(point,routePoints.length);
		routeMarkers.push(marker);
		if (togglemarkers!=1)
		{
			//now remove it!
			marker.setMap(null);
		}
		
		//remove old polyline first
		if (!(routePath==undefined))
		{
			routePath.setMap(null);
		}
		routePath=getRoutePath();
		routePath.setMap(map);
		 
		updateDisplay();
		
		if (autopan==true)
		{
			map.setCenter(point);
		}	
		
		SaveCookieRoute();
}

//***********************************************************************
function getRoutePath()
{
	var routePath = new google.maps.Polyline({
		path: routePoints,
		strokeColor: lineColor,
		strokeOpacity: 1.0,
		strokeWeight: lineWidth,
		geodesic: true
	});
	return routePath;
}
//***********************************************************************
function deletepoint_pre()
{
	var btn_deletepoint=document.getElementById("btn_deletepoint");
	btn_deletepoint.style.backgroundColor="#ffffff";
	markerclickmode=1;
}

function deletepoint_post()
{
	var btn_deletepoint=document.getElementById("btn_deletepoint");
	btn_deletepoint.style.backgroundColor="#cccccc";
	markerclickmode=0;
}

function clearMap() 
{
	if (routeMarkers) 
	{
		for (i in routeMarkers) 
		{
			routeMarkers[i].setMap(null);
		}
	}
	routePoints=new Array(0);
	routeMarkers=new Array(0);
	//remove polyline
	if (!(routePath==undefined))
	{
		routePath.setMap(null);
	}
	total_distance=0;
	document.getElementById("distance").value="";
}

function ftn_quickfind2(address) 
{
	document.getElementById("btn_go").value="Searching...";
	geocoder.geocode( { 'address': address}, function(results, status) 
	{
		if (status == google.maps.GeocoderStatus.OK) 
		{
        	var image = new google.maps.MarkerImage('http://www.daftlogic.com/images/gmmarkersv3/stripes.png',
			// This marker is 20 pixels wide by 32 pixels tall.
			new google.maps.Size(20, 34),
			// The origin for this image is 0,0.
			new google.maps.Point(0,0),
			// The anchor for this image is the base of the flagpole at 0,32.
			new google.maps.Point(9, 33));
	
			var point = results[0].geometry.location;
			
			map.setCenter(point);
			map.fitBounds(results[0].geometry.viewport);  
			
			if (document.getElementById("rb_placedistancemarker1").checked==true)
			{
				clickatpoint(point);
			}
			else
			{
				var marker = new google.maps.Marker({position:point,map:map,icon:image,title:address});
				
				var infowindow = new google.maps.InfoWindow(
				{           
						content: "<div><font size='2' face='Verdana' color='#000099'>lat "
							+ point.lat() + "</font></div><div><font size='2' face='Verdana' color='#000099'>lng "
							+ point.lng() + "</font></div><div><font size='2' face='Verdana' color='#FF0000'>address:"
							+ address + "</font></div>"
				});
							
				infowindow.open(map, marker);
				google.maps.event.addListener(marker, 'click', function() {
					//infowindow.open(map, marker);
					infowindow.close();
					marker.setMap(null);
				});
			}

			document.getElementById("btn_go").value="Found";  	
      	} 
		else 
		{
        	//console.log("Geocode was not successful for the following reason: " + status);
			document.getElementById("btn_go").value="Not Found";
      	}
   	});
}

//***********************************************************************
function placeMarker(location,number) 
{
	var image = new google.maps.MarkerImage('http://www.daftlogic.com/images/gmmarkersv3/stripes.png',
	// This marker is 20 pixels wide by 32 pixels tall.
	new google.maps.Size(20, 34),
	// The origin for this image is 0,0.
	new google.maps.Point(0,0),
	// The anchor for this image is the base of the flagpole at 0,32.
	new google.maps.Point(9, 33));
	
  	var text="(" +(number) + ")" + location;
	
	var marker = new google.maps.Marker({position:location,map:map,icon:image,title:text,draggable:true});
	
	google.maps.event.addListener(marker, 'dragend', function(event)
	{
		
		marker.setTitle('(' + number + ')' + event.latLng);
		routePoints[number-1]=event.latLng;
		//remove polyline
		routePath.setMap(null);
		//add new polyline
		routePath=getRoutePath();
		routePath.setMap(map);
		SaveCookieRoute();
		updateDisplay();
	});
	
	google.maps.event.addListener(marker, 'click', function()
	{
		//normal, insert new point at that point
		if (markerclickmode==0)
		{
			clickatpoint(location);
		}
		//delete the marker at that point
		if (markerclickmode==1)
		{
			
			
			//remove marker
			routeMarkers[number-1].setMap(null);

			//update arrays...
			routePoints.splice((number-1),1);


			routeMarkers=new Array(0);
			//recreate routeMarkers
			if (routePoints) 
			{
				var count=1;
				for (i in routePoints) 
				{
					var marker=placeMarker(i,count);
					routeMarkers.push(marker);
					count++;
				}
			}

			//remove old polyline first
			if (!(routePath==undefined))
			{
				routePath.setMap(null);
			}
			
			//add new polyline
			routePath=null;
			routePath=getRoutePath();
			routePath.setMap(map);
				
			updateDisplay();
			SaveCookieRoute();
			
			deletepoint_post();
		}
	});
	
	return marker;
}

function autopantoggle(state)
{
	autopan=state;
	SavePosandSettings();
}
function updateDisplay()
{
	var total_distance_m=1000*routePath.inKm();		
	var dist=unit_handler.f(total_distance_m);
	document.getElementById("distance").value=dist.toFixed(3);
}
function toggleUnits(arg)
{
	if(arg=="MILES")
	unit_handler=MILES;
	if(arg=="KMS")
	unit_handler=KMS;
	if(arg=="NMILES")
	unit_handler=NMILES;
	if(arg=="FEET")
	unit_handler=FEET;
	if(arg=="METRES")
	unit_handler=METRES;
	
	updateDisplay();
	SavePosandSettings();
}

function togglemarkersbtn()
{
	//If they are on
	if (togglemarkers==1)
	{
		togglemarkers=0;
		if (routeMarkers) 
		{
			for (i in routeMarkers) 
			{
				routeMarkers[i].setMap(null)
			}
		}
	}
	else
	//If thety are off
	{
		togglemarkers=1;
		if (routeMarkers) 
		{
			for (i in routeMarkers) 
			{
				routeMarkers[i].setMap(map);
			}
		}
	}
	SavePosandSettings();
}

function ZoomOut()
{
	var latlngbounds = new google.maps.LatLngBounds();
	
	if (routePoints) 
	{
		for (i in routePoints) 
		{
			latlngbounds.extend(routePoints[i]);
		}
	}
	
	map.setCenter(latlngbounds.getCenter());
	map.fitBounds(latlngbounds);
	SavePosandSettings();
}

function clearLastLeg()
{
	if(routePoints.length<2)
	return;

	//remove last marker
	routeMarkers[routeMarkers.length-1].setMap(null);
	
	//remove last ployline segment...
	//remove old polyline first
	if (!(routePath==undefined))
	{
		routePath.setMap(null);
	}
	
	routePoints.pop();
	routeMarkers.pop();
	
	//add new polyline
	routePath=getRoutePath();
	routePath.setMap(map);
		
	updateDisplay();
	SaveCookieRoute();
}

function SavePosandSettings()
{
	
	var mapzoom=map.getZoom();
	
	var mapcenter=map.getCenter();
	var maplat=mapcenter.lat();
	var maplng=mapcenter.lng();
	
	var cMT=map.getMapTypeId();

	var MT="";
	if (cMT=="roadmap")
	{
		MT=0;	
	}
	if (cMT=="satellite")
	{
		MT=1;	
	}
	if (cMT=="hybrid")
	{
		MT=2;	
	}
	if (cMT=="terrain")
	{
		MT=3;	
	}

	var cookiestring=maplat+"_"+maplng+"_"+mapzoom+"_"+toggleGoogleBar+"_"+togglemarkers+"_"+MT+"_"+unit_handler.label;

	var exp = new Date();     //set new date object
	exp.setTime(exp.getTime() + (1000 * 60 * 60 * 24 * 40));     //set it 40 days ahead
	
	setCookie("DaftLogicGMDCv2",cookiestring, exp);
}


function LoadPosandSettings()
{
	var loadedstring=getCookie("DaftLogicGMDCv2");
	if (loadedstring!="")
	{
		var splitstr;
		splitstr=loadedstring.split("_");

		if ((parseFloat(splitstr[0])!=0)&&(parseFloat(splitstr[1])!=0))
		{
			var point=new google.maps.LatLng(parseFloat(splitstr[0]), parseFloat(splitstr[1]));
			map.panTo(point);
		}
		map.setZoom(parseFloat(splitstr[2]));
	
		toggleGoogleBar=splitstr[3];
		togglemarkers=splitstr[4];
			
			
		if (togglemarkers=="1")
		{
			if (routeMarkers) 
			{
				for (i in routeMarkers) 
				{
					routeMarkers[i].setMap(map);
				}
			}
		}
		else
		{
			if (routeMarkers) 
			{
				for (i in routeMarkers) 
				{
					routeMarkers[i].setMap(null);
				}
			}	
		}
			
		if (splitstr[5] != "")
		{
			if (splitstr[5]==0)
			{
				map.setMapTypeId("roadmap");
			}
			if (splitstr[5]==1)
			{
				map.setMapTypeId("satellite");
			}
			if (splitstr[5]==2)
			{
				map.setMapTypeId("hybrid");	
			}
			if (splitstr[5]==3)
			{
				map.setMapTypeId("terrain");
			}
		}
		
		if (splitstr[6]!= null) 
		{
			if(splitstr[6]=="miles")
			{
				unit_handler=MILES;
				document.getElementById("cb_dist1").checked=true;
			}
			if(splitstr[6]=="km")
			{
				unit_handler=KMS;
				document.getElementById("cb_dist2").checked=true;
			}
			if(splitstr[6]=="nautical miles")
			{
				unit_handler=NMILES;
				document.getElementById("cb_dist3").checked=true;
			}
			if(splitstr[6]=="feet")
			{
				unit_handler=FEET;
				document.getElementById("cb_dist5").checked=true;
			}
			if(splitstr[6]=="metres")
			{
				unit_handler=METRES;
				document.getElementById("cb_dist4").checked=true;
			}
		}
	}
}

function setCookie(name, value, expires) 
{
	document.cookie = name + "=" + escape(value) + "; path=/" + ((expires == null) ? "" : "; expires=" + expires.toGMTString());
}

function getCookie(c_name)
{
	if (document.cookie.length>0)
  	{
  		c_start=document.cookie.indexOf(c_name + "=");
  		if (c_start!=-1)
    	{ 
    		c_start=c_start + c_name.length+1; 
    		c_end=document.cookie.indexOf(";",c_start);
    		if (c_end==-1) c_end=document.cookie.length;
    		return unescape(document.cookie.substring(c_start,c_end));
    	} 
  	}
	return "";
}

function SaveCookieRoute()
{
	var cookiestring="";
	for(var j=0;j<routePoints.length;++j)
	{
		if (j>0)
		{
			cookiestring+="|";
		}
		var lattosave=routePoints[j].lat();
		var longtosave=routePoints[j].lng();
		cookiestring+=lattosave+","+longtosave;
	}

	var exp = new Date();     //set new date object
	exp.setTime(exp.getTime() + (1000 * 60 * 60 * 24 * 40));     //set it 40 days ahead
	setCookie("DaftLogicGMDCRoutev2",cookiestring, exp);
}

function LoadCookieRoute()
{
	var loadedstring=getCookie("DaftLogicGMDCRoutev2");
	
	if (loadedstring!="")
	{

		var pointsplit;
		var splitstr= loadedstring.split("|");
		for(i = 0; i < splitstr.length; i++)
		{
			pointsplit=splitstr[i].split(",");
			var point=new google.maps.LatLng(parseFloat(pointsplit[0]), parseFloat(pointsplit[1]));
			
			routePoints.push(point);
		
			var marker=placeMarker(point,routePoints.length);
			routeMarkers.push(marker);
			if (togglemarkers!=1)
			{
				//now remove it!
				marker.setMap(null);
			}
		}
		
		//add polyline
		routePath=getRoutePath();
		routePath.setMap(map);


		if (autopan==true)
		{
			map.panTo(point);
		}
		updateDisplay();
	}
}

google.maps.LatLng.prototype.kmTo = function(a)
{
	var e = Math, ra = e.PI/180;
	var b = this.lat() * ra, c = a.lat() * ra, d = b - c;
	var g = this.lng() * ra - a.lng() * ra;
	var f = 2 * e.asin(e.sqrt(e.pow(e.sin(d/2), 2) + e.cos(b) * e.cos(c) * e.pow(e.sin(g/2), 2)));
	return f * 6378.137;
};

google.maps.Polyline.prototype.inKm = function(n)
{
	var a = this.getPath(n), len = a.getLength(), dist = 0;
	for(var i=0; i<len-1; i++)
	{
  		dist += a.getAt(i).kmTo(a.getAt(i+1));
	}
	return dist;
};

function submitenter(myfield,e)
{
	var keycode;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
	else return true;
	
	if (keycode == 13)
	{
		ftn_quickfind2(document.getElementById('goto').value);
		document.getElementById("goto").focus();
		document.getElementById("goto").select();
		return false;
	}
	else
	{
	   return true;
	}
}


function empty() {
  var ta = document.getElementById("ta_coordinates");
  if (ta.getAttribute("class") == "notselected" && ta.value == "") ta.value = "Input in the format lat,lng e.g.\n48.857798,2.299962\n47.857798,2.299962";
  if (ta.getAttribute("class") == "selected") ta.value = "";
}

function change(cls) {
  document.getElementById("ta_coordinates").setAttribute("class", cls);
}

function ftn_processcsv()
{
	var txtarea = document.getElementById('ta_coordinates');		
	var arr_str_coordinates = txtarea.value.split('\n');
	
	for ( i = 0; i < arr_str_coordinates.length; i += 1) 
	{
		var arr_str_latlng = arr_str_coordinates[i].split(',');
		
		if ((arr_str_latlng[0]!="")&&(arr_str_latlng[1]!=""))
		{
			var point = new google.maps.LatLng(arr_str_latlng[0],arr_str_latlng[1]);
			routePoints.push(point);
			var marker=placeMarker(point,routePoints.length);
			routeMarkers.push(marker);
			if (togglemarkers!=1)
			{
				//now remove it!
				marker.setMap(null);
			}
		}
		
		
	}
	
	//remove old polyline first
	if (!(routePath==undefined))
	{
		routePath.setMap(null);
	}
	routePath=getRoutePath();
	routePath.setMap(map);
	
	updateDisplay();
	
	if (autopan==true)
	{
		map.setCenter(point);
	}	
	
	SaveCookieRoute();
	ZoomOut(map);
}

$(function() {
	$('#accordion').accordion({ 
		collapsible: true, 
		autoHeight: false, 
		active: false 
	});
});

$(function() {
	$('#accordionlink').accordion({ 
		change: function( event, ui ) {findtinyurl();},
		collapsible: true, 
		autoHeight: false, 
		active: false 
    
	});
});

function findtinyurl()
{
	var pointsxml="";
	
	for(var j=0;j<routePoints.length;++j)
	{
		var lat=routePoints[j].lat();
		var lng=routePoints[j].lng();
		pointsxml+=lat+","+lng+"|";
	}
	
	var strLen = pointsxml.length;
	pointsxml = pointsxml.slice(0,strLen-1);

	//Create a boolean variable to check for a valid MS instance.
	var xmlhttp = false;
	//Check if we are using IE.
	try 
	{
		//If the javascript version is greater than 5.
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} 
	catch (e) 
	{
		//If not, then use the older active x object.
		try 
		{
			//If we are using IE.
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} 
		catch (E)
		{
			//Else we must be using a non-IE browser.
			xmlhttp = false;
		}
	}
	
	//If we are using a non-IE browser, create a javascript instance of the object.
	if (!xmlhttp && typeof XMLHttpRequest != 'undefined') 
	{
		xmlhttp = new XMLHttpRequest();
	}
	xmlhttp.onreadystatechange=function()
	{
		if(xmlhttp.readyState==4)
		{
			//response
			var tinyurl = xmlhttp.responseText;
			document.getElementById("tb_link").value=tinyurl;
		}
	};
	
	var ran_number=Math.floor(Math.random()*999);			
	xmlhttp.open("POST","includes/ajax/generate-tinyurl.php",true);
	var params="url=http://www.daftlogic.com/projects-google-maps-distance-calculator.htm?route="+pointsxml;
	//Send the proper header information along with the request
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.setRequestHeader("Content-length", params.length);
	xmlhttp.setRequestHeader("Connection", "close");

	xmlhttp.send(params);
}
</script>
<table border="0">
    <tbody><tr>
    <td><input class="custombutton" type="button" value="Clear Last Point" onclick="clearLastLeg();"></td>
    <td width="5px"></td>
    <td><input class="custombutton" type="button" value="Zoom To Fit" onclick="ZoomOut();"></td>
    <td width="5px"></td>
    <td><input class="custombutton" type="button" value="Clear Map" onclick="clearMap();SaveCookieRoute();"></td>
    <td width="5px"></td>
    <td><input class="custombutton" type="button" value="Toggle Markers" onclick="togglemarkersbtn();"></td>
    <td width="5px"></td>
    <td><input class="custombutton" type="button" id="btn_findlocation" value="Pan to My Location" onclick="gotomylocation();"></td>
    <td width="5px"></td>
    <td><input class="custombutton" type="button" id="btn_findlocation" value="Show Elevation" onclick="ftn_showelevation();"></td>
    </tr>
</tbody></table>
<div id="map_canvas"  </div>

<div id="elevation_chart" style="width: 95%;"></div>

<table border="0">
    <tbody><tr>
    <td>Total Distance <input style="display: inline;" id="distance" type="text" size="12" value="0.000"> 
    </td>
    <td width="20px"></td>
    <td>
    <input id="cb_dist1" name="cb_dist" type="radio" onclick="toggleUnits(&#39;MILES&#39;);" checked="checked">
    <font face="verdana, geneva, helvetica" size="2">Miles</font> 
    <input id="cb_dist2" type="radio" name="cb_dist" onclick="toggleUnits(&#39;KMS&#39;);">
    <font face="verdana, geneva, helvetica" size="2">km</font> 
    <input id="cb_dist3" type="radio" name="cb_dist" onclick="toggleUnits(&#39;NMILES&#39;);">
    <font face="verdana, geneva, helvetica" size="2">Nautical Miles</font> 
    <input id="cb_dist4" type="radio" name="cb_dist" onclick="toggleUnits(&#39;METRES&#39;);">
    <font face="verdana, geneva, helvetica" size="2">Metres</font> 
    <input id="cb_dist5" type="radio" name="cb_dist" onclick="toggleUnits(&#39;FEET&#39;);">
    <font face="verdana, geneva, helvetica" size="2">Feet</font> 
    </td>
    <td width="20px"></td>
    <td><font face="verdana, geneva, helvetica" size="2">Autopan ?</font> <input name="autopan" id="autopan" type="checkbox" onclick="autopantoggle(this.checked);" checked="CHECKED">
    </td>
    </tr>
</tbody></table>