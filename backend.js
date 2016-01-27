var map;
var geocoder;
var startingPoint = {lat: 37.3351874, lng: -121.88107150000002};
var infowindow;
var markers = [];  
var list_circle = [];
 
function init () { 
    geocoder = new google.maps.Geocoder();
    infowindow = new google.maps.InfoWindow({width: 2000}); 
    map = new google.maps.Map(document.getElementById("map"), { 
        zoom: 12 
    }); 
    
    //Set the starting point as user request
    if (typeof(Storage) !== "undefined") { 
        $('#address_input').val(localStorage.getItem("storeddata"));
        geocodeAddress(localStorage.getItem("storeddata"));
    }
    else{
        alert("Sorry, your browser does not support web storage..."); 
    }  
     
    // Create the search box 
    var input = document.getElementById('address_input'); 
    var types = document.getElementById('type-selector');
//    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);

    var autocomplete = new google.maps.places.Autocomplete(input); 
    autocomplete.bindTo('bounds', map); 
    autocomplete.addListener('place_changed', function() {
        
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();

        if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry");
            return;
        }
        // If the place has a geometry, then present it on a map.
//        if (place.geometry.viewport) {
//            map.fitBounds(place.geometry.viewport); 
//        } else {
//            map.setCenter(place.geometry.location);  
//        }

        map.setCenter(place.geometry.location);  
        
        //Clear previous markers
        clearMarkers();
        
        //Set marker for current location
//        marker.setIcon(/** @type {google.maps.Icon} */({
//            url: place.icon,
//            size: new google.maps.Size(71, 71),
//            origin: new google.maps.Point(0, 0),
//            anchor: new google.maps.Point(17, 34),
//            scaledSize: new google.maps.Size(35, 35)
//        }));
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);
         

        //Get range and keyword
        var range = 5; 
        var keyword = "school"; 
              
        //Clear circle & Display range
        for (var i = 0; i < list_circle.length; i++)  
        {
            list_circle[i].setMap(null);
            list_circle.shift(); 
        } 
        
        var circle = new google.maps.Circle({
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.35,
            map: map,
            center: place.geometry.location,
            radius: range / 0.00062137
        });  
        
        list_circle.push(circle);
        
        
        //PHP calling 
        var a_url="getSchool.php?range=" + range + "&lat=" + place.geometry.location.lat() + "&lng=" + place.geometry.location.lng(); 
        $.get(a_url, function(data, status){  
            var count = 0;
            for(count in data)  {
                var icon = {
				url: 'images/school.png',
//				size: new google.maps.Size(50, 50),
				origin: new google.maps.Point(0, 0),
//				anchor: new google.maps.Point(17, 34),
				scaledSize: new google.maps.Size(25, 25)
                }
                setMarker(data[count].long, data[count].lat, icon);
                
            } 
         }, "json");          
 }); 
//        var address = '';
//        if (place.address_components) {
//            address = [
//                (place.address_components[0] && place.address_components[0].short_name || ''),
//                (place.address_components[1] && place.address_components[1].short_name || ''),
//                (place.address_components[2] && place.address_components[2].short_name || '')
//                ].join(' ');
//        }
//
//        infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
//        infowindow.open(map, marker);
    

//    function setupClickListener(id, types) {
//        var radioButton = document.getElementById(id);
//        radioButton.addEventListener('click', function() {
//        autocomplete.setTypes(types);
//        });
//    }
//
//    setupClickListener('changetype-all', []);
//    setupClickListener('changetype-address', ['address']);
//    setupClickListener('changetype-establishment', ['establishment']);
//    setupClickListener('changetype-geocode', ['geocode']);
    
//    document.getElementById('geoCode').addEventListener('click', function() {geocodeAddress(geocoder)});
}

function setMarker(newLng, newlat, a_icon){ 
    var marker = new google.maps.Marker({
        map: map,
        position: new google.maps.LatLng(newlat, newLng),
        animation:google.maps.Animation.DROP,
        icon: a_icon,
    });
    
    //Creating infor box when mouse over
    marker.addListener('mouseover', function() { 
         infowindow.setContent("<div style='width:130px;'>" +
                               "<div style='float:left; margin-right:5px;'>" +
                               "<img src='images/kitchen.jpg' alt='house' style='width:50px;height:50px;'></img>" +
                               "</div>" +
                               "<a id='link' href='home.html'>$700</a><br>" +
                               "4 bd, 3ba<br>" +
                               "2000 sqft<br>" +
                               "</div>");
         infowindow.open(map, marker);
         });
    
    //Close infobox when mouse is not over
    var ibtimeout;
    marker.addListener('mouseout', function() {
        ibTimeout = setTimeout(function(){
            ib.close();
        }, 50);
    }); 
     
    markers.push(marker);
}

function getNearby(newCenter, newRange, newKeyword){    
    if(newRange == "")
        newRange = 0;
    var service = new google.maps.places.PlacesService(map);
    service.nearbySearch({
        location: newCenter,
        radius: newRange,
        keyword: newKeyword 
    }, callback); 
}

function callback(results, status) {
  if (status === google.maps.places.PlacesServiceStatus.OK) {
    for (var i = 0; i < results.length; i++) {
      createMarker(results[i]);
    }
  }
}

function createMarker(place) { 
    var marker = new google.maps.Marker({
        map: map,
        position: place.geometry.location
    });
//    document.getElementById("resultArea").value += place.name + "\r\n" + marker.position + "\r\n" + place.types + "\r\n \r\n";
    markers.push(marker);

    google.maps.event.addListener(marker, 'click', function() {
        infowindow.setContent(place.name);
        infowindow.open(map, this);
    });
}

function geocodeAddress(city) { 
    geocoder.geocode({'address': city}, function(results, status) { 
      if (status == google.maps.GeocoderStatus.OK) 
      { 
          clearMarkers();  
          startingPoint = {lat: results[0].geometry.location.lat(), lng: results[0].geometry.location.lng()}; 
          map.setCenter(startingPoint);
          var marker = new google.maps.Marker({
              map: map,
              position: startingPoint
          });  
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    });
}

// Sets the map on all markers in the array.
function setMapOnAll(map) {
    for (var i = 0; i < markers.length; i++) 
        markers[i].setMap(map); 
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
    setMapOnAll(null);
}

