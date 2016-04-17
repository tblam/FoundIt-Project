//for map
var map;
var geocoder; 
var previous_infox;

//for 
var list_circle = []; 
var range = 5; 

//store selected city from index page
var selected_city;

//for city boundary
var ptsArray=[]; 
var cityBoundary =[];

//for houses
var houses = [];

//for school
var schools = [];

//for earthquake
var heatmap;

//for flood zone
var flood = []; 

function init () { 
    //Initialize the map
    geocoder = new google.maps.Geocoder(); 
    map = new google.maps.Map(document.getElementById("map"), { 
        zoom: 15
    });  
    
    //Get selected city from index page
    selected_city = localStorage.getItem("storeddata");
    
    //Set the starting point as user request
    if (typeof(Storage) !== "undefined") { 
        $('#autocomplete').val(selected_city);
        var a = getData(selected_city); 
    }
    else{
        alert("Sorry, your browser does not support web storage..."); 
    }  
      
    //Create customized autocomplete
    var input = document.getElementById('autocomplete'); 
    
    //Add listener to autocomplete
    $("#autocomplete").bind("keypress", function(event) {
        if(event.which == 13) {
            selected_city = $('#autocomplete').val();   
            getData(selected_city + ", California");  
        }
    });     
      
    //Create filter for the map
    var types = document.getElementById('map-filter'); 
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(types);
    
    //Add listener for displaying city boundary
    $("#displayCityBoundary").change(function(){
        if(this.checked)
           displayCityBoundary(map);        
        else
            displayCityBoundary(null);
    });
    
    //Add listener for displaying earthquake zone
    $("#displayEarthquake").change(function(){
        if(this.checked) 
            map.data.setStyle(function(feature) {
		var magnitude = feature.getProperty('mag'); 
		return {
		  icon: getCircle(magnitude)
		};
	  });
        else
            map.data.setStyle({visible: false}); 
    });
    
     //Add listener for displaying earthquake zone
     $("#displayEarthquake-heatmap").change(function(){ 
        if(this.checked)
            heatmap.setMap(map);
        else
            heatmap.setMap(null);
    });
    
    //Add listener for displaying earthquake zone
    $("#displaySchool").change(function(){
        if(this.checked)
            displaySchools(map);
        else
            displaySchools(null);
    });
     
    //Add listener for displaying flood zone
    $("#displayFloodZone").change(function(){
        if(this.checked)
            displayFloodZone(map);
        else
            displayFloodZone(null);
    });    
    
     //Add listener for filter search
    $("#submit_filter").on('click', function(){ 
        //Get number of beds
        var beds = get_num_bed();

        //Get number of baths
        var baths = get_num_bath();
         
        //Check if price range is bounded
        var min = $("#min_range").val();
        var max = $("#max_range").val();
        if(min != "" || max != ""){   
            min = parseInt(min);
            max = parseInt(max);
            
            if(!$.isNumeric(min))
                min = 0;
             if(!$.isNumeric(max))
                max = 0;
            
            console.log(min + "-" + max);
            //Go search
            filter_search(min, max, beds, baths);
        }
        else{
            //Get text for price range
            var price = $("#price_range").text().trim(); 
            
            //Reformat the string 
            price = price.slice(0, price.length - 1); 
            
            //Convert to number
            price = parseInt(price) * 1000;
            
            //Check if any of the filter has not been selected 
            if(!$.isNumeric(price))
                price = 0; 
            
            //Go search
            filter_search(price, -1, beds, baths);
        }  
    });
        
    //Display earthquake data in California within 10 years 
	var script = document.createElement('script');
	script.src = 'earthquake_data.js';
	document.getElementsByTagName('head')[0].appendChild(script); 
    
    //for earthquake points
	map.data.setStyle(function(feature) {
		var magnitude = feature.getProperty('mag'); 
		return {
		  icon: getCircle(magnitude)
		};
	  });  
    map.data.setStyle({visible: false});
    
    map.data.addListener('mouseover', function(event) {
        infowindow = new google.maps.InfoWindow(); 
        infowindow.setPosition(event.latLng);
        infowindow.setContent('<div> Location: ' +
                              event.feature.getProperty("place") + '<br> Magnitude: ' +
                              event.feature.getProperty("mag") + '<br> Gap: ' +
                              event.feature.getProperty("gap") + '</div>');
        if(previous_infox != null)
            previous_infox.close();
        infowindow.open(map, this);    
        previous_infox = infowindow; 
    });
    
}   

function get_num_bed(){
        //Get pure text for number of bed such as +2
        $bed = $("#num_bed").text().trim();
        //Reformat the number
        $bed = $bed.slice(0, $bed.length - 1);
        
        //Check if num_bed is numeric
        if(!$.isNumeric($bed))
            $bed = 0;
        return $bed;
}
    
function get_num_bath(){
    //Get pure text for number of bath such as +1
    $bath = $("#num_bath").text().trim();
    //Reformat the number
    $bath = $bath.slice(0, $bath.length - 1);
    //Check if num_bed is numeric
    if(!$.isNumeric($bath))
            $bath = 0;
    return $bath;
}
    
function filter_search(min_price, max_price, beds, baths){
    var a_url = "php/filter_query.php?city=" + localStorage.getItem("storeddata") + "&min_price=" + min_price + "&max_price=" + max_price + "&num_bed=" + beds + "&num_bath=" + baths;   
    $.get(a_url, function(data, status){  
        console.log(a_url);
        var count = 0; 
        //Remove all current displayed houses
        for (var i = 0; i < houses.length; i++)
            houses[i].setMap(null);

        houses = []; 
        for(count in data)  { 
            var house = new google.maps.Marker({
                map: map,
                position: new google.maps.LatLng(data[count].lat, data[count].long),
                animation:google.maps.Animation.DROP, 
            });  

            //Create infobox content
             var house_content = '<div style="font-size:14px;"><b>' + data[count].address + ", " + data[count].city + '<b></div>' +
                'Beds: ' + data[count].BedsTotal + '<br>' +
                'Baths: ' + data[count].BathsTotal + '<br>' + 
                'Area: ' + data[count].SqftTotal + ' sqft<br>' +
                'Lot size: ' + data[count].LotSizeArea_Min + ' sqft<br>' +
                'Age: ' + data[count].Age + ' year(s)<br>' +
                'Price: $ ' + data[count].CurrentPrice + '<br>';
            
            //Create infobox
            setInfoBox('House information', house_content, house);

            //Add house to list
            houses.push(house);
        }  
        alert("Houses found: " + count);
    }, "json"); 
}

function getCircle(magnitude) {  
    var earthquake = {
        path: google.maps.SymbolPath.CIRCLE,
        fillColor: 'orange',
        fillOpacity: .5,
        scale: Math.pow(2, magnitude) / 2,
        strokeColor: 'red',
        strokeWeight: .5
    };  
return earthquake;
}

function eqfeed_callback(results) {
    //for earthquake points
    map.data.addGeoJson(results);
    
    //for earthquake zone (heatmap)
    var heatmapData = [];
    for (var i = 0; i < results.features.length; i++) {
      var coords = results.features[i].geometry.coordinates;
      var latLng = new google.maps.LatLng(coords[1], coords[0]);
      var magnitude = results.features[i].properties.mag;
      var weightedLoc = {
        location: latLng,
        weight: Math.pow(2, magnitude)
      };
      heatmapData.push(weightedLoc);
    }
    heatmap = new google.maps.visualization.HeatmapLayer({
        data: heatmapData,
        dissipating: false,
        radius: 20 
    });
}

function getCityBoundary(){  
    //PHP calling   
    var a_url="php/getCityBoundary.php?city=" + selected_city;

    $.get(a_url, function(data, status){   
        var count = data.length;
        for(var a = 0; a < count; a++){
            var poly;
            ptsArray = [];
            var triangleCoords = data[a].SHAPE;  
            //using regex, we will get the indivudal Rings
            var regex = /\(([^()]+)\)/g;
           
            //Parse the wkt-multipolygon. The while loop will get all polygons in the wkt.
            //However, we only need to get the biggest polygon for the boundary, so that we don't get
            //polygons that are overlapped 
//            var Rings = [];
//            var results;   
//            while( results = regex.exec(triangleCoords) ) {
//                Rings.push( results[1] );   
//                console.log(results[1]);
//            }
            
            
            //Parse the wkt and
            AddPoints(regex.exec(triangleCoords)[1]);

            //now we need to draw the polygon for each of inner rings, but reversed
//            var polyLen=Rings.length;
//            for(var i=0;i<polyLen;i++){
//                AddPoints(Rings[i]);
//            }   

            poly = new google.maps.Polygon({
                paths: ptsArray,
                strokeColor: 'green', 
                strokeWeight: 2,  
                fillOpacity: 0.05,
                map: map, 
              }); 
            
            cityBoundary.push(poly);
//            console.log("Number of polygon in this data: " + list_poly.length);
            poly.setMap(map); 
        } 
     }, "json");    
}

function AddPoints(data){
    //first spilt the string into individual points
    var pointsData=data.split(", "); 
    
    //iterate over each points data and create a latlong
    //& add it to the cords array
    var len=pointsData.length;  
    for (var i=0;i<len;i++)
    {
        var xy = pointsData[i].split(" ");   
        var pt = new google.maps.LatLng(xy[1], xy[0]);  
        ptsArray.push(pt); 
    } 
}

function getFloodZone(){
    //PHP calling   
    var a_url="php/getFloodZone.php";
    
    $.get(a_url, function(data, status){  
        var count = data.length;
        for(var a = 0; a < count; a++){ 
            ptsArray = [];
            var points = data[a].SHAPE;  

            var regex = /\(([^()]+)\)/g; 

            //Parse the wkt and
            AddPoints(regex.exec(points)[1]);
             
            var line = new google.maps.Polyline({
                path: ptsArray,
                geodesic: true,
                strokeColor: '#FF0000',
                strokeOpacity: 1.0,
                strokeWeight: 2
            });

            flood.push(line); 
            line.setMap(map);  
        } 
    }, "json");   
}
 
function getHouse(){
    //PHP calling  
    var a_url="php/getHouse.php?city=" + selected_city; 
    $.get(a_url, function(data, status){  
        var count = 0; 
        for(count in data)  {
            var house = new google.maps.Marker({
                map: map,
                position: new google.maps.LatLng(data[count].lat, data[count].long),
                animation:google.maps.Animation.DROP, 
            });  
                
            //Create infobox content
             var house_content = '<div style="font-size:14px;"><b>' + data[count].address + ", " + data[count].city + '<b></div>' +
                'Beds: ' + data[count].BedsTotal + '<br>' +
                'Baths: ' + data[count].BathsTotal + '<br>' + 
                'Area: ' + data[count].SqftTotal + ' sqft<br>' +
                'Lot size: ' + data[count].LotSizeArea_Min + ' sqft<br>' +
                'Age: ' + data[count].Age + ' year(s)<br>' +
                'Price: $ ' + data[count].CurrentPrice + '<br>';
            
            //Create infobox
            setInfoBox('House information', house_content, house);
            
            //Add house to list
            houses.push(house);
        } 
//        count ++;
//        alert("Houses on market: " + count);
     }, "json"); 
}

function getSchool(){
    //PHP calling 
    var a_url="php/getSchool.php?city=" + selected_city;  
    $.get(a_url, function(data, status){  
        var count = 0;
        for(count in data)  {
            //Create icon for school
            var icon = {
            url: 'icons/school.png',
//				size: new google.maps.Size(50, 50),
            origin: new google.maps.Point(0, 0),
//				anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(25, 25)
            } 

            var school = new google.maps.Marker({ 
                position: new google.maps.LatLng(data[count].lat, data[count].long),
                animation:google.maps.Animation.DROP,
                icon: icon
            });  
            
            //Create infobox content
            var school_content = '<div style="font-size:14px;"><b>' + data[count].address + ", " + data[count].city + ",CA" + data[count].zipcode + '<b></div>' +
                'Type: ' + data[count].type + '<br>' +
                'Average Performance Index: ' + data[count].api + '<br>' + 
                'State rank: ' + data[count].staterank + '/10 <br>';  
            
            //Create infobox
            setInfoBox('School information', school_content, school);
            
            //Add school to list
            schools.push(school);
        } 
         console.log("Number of school: " + count);
     }, "json");   
   
}

function getData(city) {  
    geocoder.geocode({'address': city}, function(results, status) { 
      if (status == google.maps.GeocoderStatus.OK) 
      { 
          //Clear everything on map
          clearMarkers();  
          
          //Get the new position and set it as center of the map
          var startingPoint = {lat: results[0].geometry.location.lat(), lng: results[0].geometry.location.lng()};  
          map.setCenter(startingPoint);
          map.setZoom(13);
          
          clearMarkers();
          
          //Display houses
          getHouse();
          
          //Display schools 
          getSchool();  
           
          //Display city boundary
          getCityBoundary();
          
          //Display flood zone
//          getFloodZone(); 
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    }); 
}

// Sets the map on all markers in the array.
function clearMarkers() {
    //Clear all markers
    displaySchools(null);
    schools = [];
    
    //Clear city boundary
    displayCityBoundary (null);
    cityBoundary = [];
    
    //Clear all circle
    for (var i = 0; i < list_circle.length; i++)  {
        list_circle[i].setMap(null);
        list_circle.shift(); 
    }     
    
    //Clear houses
    for (var i = 0; i < houses.length; i++)  {
        houses[i].setMap(null); 
    }     
}    

function displayCityBoundary (check){
    for (var i = 0; i < cityBoundary.length; i++) {
        if(cityBoundary[i] instanceof google.maps.Polygon)
            cityBoundary[i].setMap(check);
    }
}

function displaySchools (check){ 
    for (var i = 0; i < schools.length; i++) { 
        schools[i].setMap(check);
    }   
}

function displayEarthquake (check){
    for (var i = 0; i < list_earthquake.length; i++) 
        list_earthquake[i].setVisible(check);
}

function displayFloodZone(check){
    for (var i = 0; i < flood.length; i++) 
        flood[i].setMap(check);
}

function setInfoBox(tab_name, message, marker){   
     //Create info window for each marker
//    var infowindow = new google.maps.InfoWindow();
    var infowindow = new InfoBubble({ 
        minWidth: 250,
        minHeight: 150
    });   
    
    infowindow.addTab(tab_name, message); 
//    infowindow.addTab('Search around', "empty");  
    google.maps.event.addListener(marker, 'click', function(){
        if(previous_infox != null)
            previous_infox.close();
        infowindow.open(map, this);    
        previous_infox = infowindow;
    }); 
    
//    var content = document.createElement("DIV"); 
//    var streetview = document.createElement("DIV");
//    streetview.style.width = "200px";
//    streetview.style.height = "200px";
//    content.appendChild(streetview);
//    var infowindow = new google.maps.InfoWindow({
//        content: content
//    });
//    
//    //Adding street view
//    google.maps.event.addListenerOnce(infowindow, "domready", function() {
//        var panorama = new google.maps.StreetViewPanorama(streetview, {
//            navigationControl: false,
//            enableCloseButton: false,
//            addressControl: false,
//            linksControl: false,
//            visible: true,
//            position: marker.getPosition()
//        });
//    });
}