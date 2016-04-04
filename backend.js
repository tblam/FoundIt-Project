var map;
var geocoder; 
var infowindow;
var infoWindow; // for earthquake
var marker;
var markers = [];  
var list_circle = []; 
var range = 5; 
 
function init () { 
    geocoder = new google.maps.Geocoder();
	
	// tran change infoWindow for earthquake
    infoWindow = new google.maps.InfoWindow({
		content: "",	
	}); 
	
	infowindow = new google.maps.InfoWindow({maxWidth: 500}); 
	
    map = new google.maps.Map(document.getElementById("map"), { 
        zoom: 12
    });
	
 // Create a <script> tag and set the USGS URL as the source.
	var script = document.createElement('script');

	// (In this example we use a locally stored copy instead.)
	//script.src = 'http://earthquake.usgs.gov/earthquakes/feed/v1.0/summary/2.5_week.geojsonp';
	script.src = 'earthquake4.5_GeoJSONP.js';
	document.getElementsByTagName('head')[0].appendChild(script);
	
	map.data.setStyle(function(feature) {
		var magnitude = feature.getProperty('mag');
		return {
		  icon: getCircle(magnitude)
		};
	});
	
	//want do display earthquake info
	
	/*map.data.addListener('mouseover', function(event) {
				//show an infowindow on click   
				infoWindow.setContent('<div> Place: '+
					event.feature.getProperty("place") +"<br/> Magnitude: "+
					event.feature.getProperty("mag") +"<br/>Gap: " + event.feature.getProperty("gap") + "</div>");
				
				infoWindow.open(map, marker);
			});*/
	map.data.addListener('mouseover', function(event) {
				//show an infowindow on click   
				infoWindow.setPosition(event.latLng);
				infoWindow.setContent('<div> Location: '+
					event.feature.getProperty("place") +"<br/> Magnitude: "+
					event.feature.getProperty("mag") +"<br/>Gap: " + event.feature.getProperty("gap") + "</div>");
				
				infoWindow.open(map, this);
			});
	/*map.data.addListener('mouseover', function(event) {
		infoWindow = new google.maps.InfoWindow({
		position: event.latLng,
		content: '<div> Place: '+
					event.feature.getProperty("place") +"<br/> Magnitude: "+
					event.feature.getProperty("mag") +"<br/>Gap: " + event.feature.getProperty("gap") + "</div>"
		}).open(map);
		setTimeout(function () { infoWindow.close(); }, 5);
	});*/
	
    //Set the starting point as user request
    if (typeof(Storage) !== "undefined") { 
        $('#address_input').val(localStorage.getItem("storeddata"));
        var a = geocodeAddress(localStorage.getItem("storeddata")); 
    }
    else{
        alert("Sorry, your browser does not support web storage..."); 
    }  
      
    // Create the search box and bind it to google autocomplete
    var input = document.getElementById('address_input'); 
    var types = document.getElementById('type-selector');

    var autocomplete = new google.maps.places.Autocomplete(input); 
    autocomplete.bindTo('bounds', map); 
    autocomplete.addListener('place_changed', function() {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            window.alert("Autocomplete's returned place contains no geometry. Please click on an address from the list.");
            return;
        } 
        
        //Set center
        map.setCenter(place.geometry.location);  
        
        //Clear previous markers
        clearMarkers();
        
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);
          
        //Display range 
        displayRange(place.geometry.location, range);
        
        //Connect to database
        getSchool(range, place.geometry.location.lat(), place.geometry.location.lng()); 
 }); 

    
//    document.getElementById('geoCode').addEventListener('click', function() {geocodeAddress(geocoder)});
}

// display earthquake
function getCircle(magnitude) {
	  var circle = {
		path: google.maps.SymbolPath.CIRCLE,
		fillColor: 'orange',
		fillOpacity: .5,
		scale: Math.pow(2, magnitude) / 2,
		strokeColor: 'red',
		strokeWeight: .5,
		
	  };
	  return circle;
}


function eqfeed_callback(results) {
        map.data.addGeoJson(results);
}


function displayRange(centerPoint, range){
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
        center: centerPoint,
        radius: range / 0.00062137
    });  

    list_circle.push(circle);
}

function getSchool(range, newlat, newlng){
    //PHP calling 
        var a_url="getSchool.php?range=" + range + "&lat=" + newlat + "&lng=" + newlng; 
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
        infowindow.setContent("<div class='infobox' style='border: solid black; width:130px;'>" +
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
            infowindow.close();
        }, 1000);
    }); 
     
    
//    google.maps.event.addListener(infowindow, 'domready', function(e){
//        $('.infobox').on('mouseenter', function(e){
//            clearTimeout(ibtimeout);
//        }).on('mouseleave', function(e){
//            clearTimeout(ibtimeout);
//            infowindow.close();
//        }); 
//        $('.infobox').mouseenter(function(){
//            clearTimeout(ibTimeout);
//        });
//        $('.infobox').mouseout(function(){
//            clearTimeout(ibTimeout);
//            infowindow.close();
//        });
//    });
     
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
    var test = 0;
    geocoder.geocode({'address': city}, function(results, status) { 
      if (status == google.maps.GeocoderStatus.OK) 
      { 
          clearMarkers();  
          test = results[0].geometry.location.lat(); 
          var startingPoint = {lat: results[0].geometry.location.lat(), lng: results[0].geometry.location.lng()};  
          map.setCenter(startingPoint);
          marker = new google.maps.Marker({
              map: map,
              position: startingPoint
          });    
          //Get houses around
          getSchool(5, startingPoint.lat, startingPoint.lng);
          
          //Display range
          displayRange(startingPoint, 5);
           
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

