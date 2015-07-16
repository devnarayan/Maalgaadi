var map; // A new marker is created based on the parameters provided and the listener is added to them"
var deletemarker = [];
function createMarker(latlng, name, image, drivername) {
    var html = name;
    var marker = new google.maps.Marker({map: map, position: latlng, icon: image});
    var infowindow = new google.maps.InfoWindow({content: html,
    boxClass: "iw"});
    google.maps.event.addListener(marker, 'click', function () {
        var point = marker.getPosition();
        // geocode(point, marker, html);

    });
    marker.desc = html;
    marker.drivername = drivername;
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
var windowinfo;
function geocode(position, marker, name, drivername) {
    if (windowinfo) {
        windowinfo.close();
    }
    geocoder.geocode({
        latLng: position
    }, function (responses) {
        var html = '';
        window.location.hash = '#' + marker.getPosition().lat() + "," + marker.getPosition().lng();
        if (responses && responses.length > 0) {
            html += '<h3>' + name + '</h3><hr/>' + responses[0].formatted_address;
            // html += '<hr /><iframe src="//www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Fdigital.inspiration&amp;width&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=false&amp;height=21&amp;appId=609713525766533" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:21px; width:120px" allowTransparency="true"></iframe>';
            //html += '<span style="float:right"><a target="_blank" href="https://twitter.com/intent/tweet?related=labnol&via=labnol&url=' + encodeURIComponent(window.location.href) + '&text=I%20am%20at%20' + encodeURIComponent(responses[0].formatted_address) + '">Tweet #location</a></span><br />';
        } else {
            html += 'Sorry but Google Maps could not determine the approximate postal address of this location.';
        }
        //html += '<hr />' + 'Latitude : ' + marker.getPosition().lat() + ', Longitude: ' + marker.getPosition().lng();
        html += '<hr />' + 'Driver : ' + drivername;
        //map.panTo(marker.getPosition());
        var infoWindow = new google.maps.InfoWindow({ boxClass: "iw",closeBoxURL: "http://servo/maalgaadi/location/fetchAllDriver.php"});
        infoWindow.setContent("<div id='iw'>" + html + "</div>");
        windowinfo = infoWindow;
        infoWindow.open(map, marker);

    });
}
var marker2 = [];
function initialize() {
    var marker = [];
     var city_lat =  $('#city_lat').val();
    var city_lng = $('#city_lng').val();
   // alert(city_lat+city_lng);
    var latlng = new google.maps.LatLng(city_lat,city_lng);
    var myOptions = {
             zoom: 10,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
    var oms = new OverlappingMarkerSpiderfier(map, {markersWontMove: true, markersWontHide: true});
    var iw = new google.maps.InfoWindow();
    oms.addListener('click', function (marker, event) {
        var point = marker.getPosition();
        var html = marker.desc
        var drivername = marker.drivername;
        geocode(point, marker, html, drivername);

        //iw.open(map, marker);
    });

            //Ajax request to get the data.xml
    var bounds = new google.maps.LatLngBounds();
                       var x = new XMLHttpRequest();
             var baseUrl = $('body').data("base");
    var url = baseUrl + "location/fetchAllDriver.php";
             x.onreadystatechange = function ()
             {    
        if (x.readyState == 4)    
                     {

            var d = x.responseText;

// Parsing XML to get the data


            var markerNodes = jQuery.parseJSON(d);

            var cnt = markerNodes.length;
            var newmarker = [];
            for (var j = 0; j < cnt; j++)
            {
                var item = markerNodes[j];

                if (item) {
                    var id = item.categoryid % 10;
                    if (!id) {
                        id = 10;
                    }
                    if (item.status != "free") {
                        var shadow = new google.maps.MarkerImage(baseUrl + 'images/booked.png',
                                new google.maps.Size(22, 44),
                                new google.maps.Point(0, 0),
                                new google.maps.Point(0, 32));
                    }
                    else {
                        var shadow = new google.maps.MarkerImage(baseUrl + 'images/markericon' + id + '.png',
                                new google.maps.Size(22, 44),
                                new google.maps.Point(0, 0),
                                new google.maps.Point(0, 32));
                    }
                    var shape = {
                        coord: [1, 1, 1, 20, 18, 20, 18, 1],
                        type: 'poly'
                    };
                    var info = item.name + '<p> ' + item.registration_no + '</p>';
                    var latlng = new google.maps.LatLng(
                            parseFloat(item.latitute),
                            parseFloat(item.longitude));

                    var marker = "";
                    marker = createMarker(latlng, info, shadow, item.drivername);
                    marker2.push(marker);
                    marker.setMap(map);
                    newmarker.push(marker);
                    oms.addMarker(marker);
                    bounds.extend(latlng);

                }
            }
            if (!bounds.isEmpty()) {
                map.fitBounds(bounds);
//                var markerCluster = new MarkerClusterer(map, newmarker);
//                markerCluster.setMap(map);
            }
            //map.setZoom(14);
        }
    }
    x.open("get", url, "true");
    x.send();
    oms.addListener('spiderfy', function (newmarker) {
        iw.close();
    });
}
function clearautomarker() {
    if (marker2 != null) {
        for (var i = 0; i < marker2.length; i++) {
            marker2[i].setMap(null);

        }
        marker2 = [];
    }
}
function initialize1() {
// newmarker.setMap(null);
clearautomarker();
    var marker = [];

    var city_lat = document.getElementById('city_lat');
    var city_lng = document.getElementById('city_lng');

    var latlng = new google.maps.LatLng(city_lat,city_lng);

    var oms = new OverlappingMarkerSpiderfier(map, {markersWontMove: true, markersWontHide: true});
    var iw = new google.maps.InfoWindow();
    oms.addListener('click', function (marker, event) {
        var point = marker.getPosition();
        var html = marker.desc
        var drivername = marker.drivername;
        geocode(point, marker, html, drivername);

        //iw.open(map, marker);
    });

            //Ajax request to get the data.xml
    var bounds = new google.maps.LatLngBounds();
                       var x = new XMLHttpRequest();
             var baseUrl = $('body').data("base");
    var url = baseUrl + "location/fetchAllDriver.php";
             x.onreadystatechange = function ()
             {    
        if (x.readyState == 4)    
                     {

            var d = x.responseText;

// Parsing XML to get the data


            var markerNodes = jQuery.parseJSON(d);

            var cnt = markerNodes.length;
            var newmarker = [];
            for (var j = 0; j < cnt; j++)
            {
                var item = markerNodes[j];

                if (item) {
                    var id = item.categoryid % 10;
                    if (!id) {
                        id = 10;
                    }
                    if (item.status != "free") {
                        var shadow = new google.maps.MarkerImage(baseUrl + 'images/booked.png',
                                new google.maps.Size(22, 44),
                                new google.maps.Point(0, 0),
                                new google.maps.Point(0, 32));
                    }
                    else {
                        var shadow = new google.maps.MarkerImage(baseUrl + 'images/markericon' + id + '.png',
                                new google.maps.Size(22, 44),
                                new google.maps.Point(0, 0),
                                new google.maps.Point(0, 32));
                    }
                    var shape = {
                        coord: [1, 1, 1, 20, 18, 20, 18, 1],
                        type: 'poly'
                    };
                    var info = item.name + '<p> ' + item.registration_no + '</p>';
                    var latlng = new google.maps.LatLng(
                            parseFloat(item.latitute),
                            parseFloat(item.longitude));

                    var marker = "";
                    marker = createMarker(latlng, info, shadow, item.drivername);
                    
                    marker.setMap(map);
                    marker2.push(marker);
                    newmarker.push(marker);
                    oms.addMarker(marker);
                    // bounds.extend(latlng);

                }
            }
            if (!bounds.isEmpty()) {
//                map.fitBounds(bounds);
//                var markerCluster = new MarkerClusterer(map, newmarker);
//                markerCluster.setMap(map);
            }
            //map.setZoom(14);
        }
    }
    x.open("get", url, "true");
    x.send();
    oms.addListener('spiderfy', function (newmarker) {
        iw.close();
    });
}
$(document).ready(function () {
    initialize();
    setInterval("initialize1()", 1000 * 60);
});