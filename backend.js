//for map
var map;
var geocoder; 
var previous_infox;
var current_location; 

//store selected city from index page
var selected_city;

//for city boundary
var ptsArray=[]; 
var cityBoundary =[];

//for houses
var houses = [];
var MLSN;

//for school
var schools = [];

//for crime
var crimes = [];

//for earthquake
var heatmap;

//for flood zone
var floods = []; 
var num = 1;

function init () { 
    //Initialize the map
    geocoder = new google.maps.Geocoder(); 
    map = new google.maps.Map(document.getElementById("map"), { 
        zoom: 11,
        panControl:true,
        zoomControl:true,
        zoomControlOptions: {
          style:google.maps.ZoomControlStyle.SMALL
        },
        mapTypeControl:true,
        scaleControl:true,
        streetViewControl:true,
        overviewMapControl:true,
        rotateControl:true, 
    });  
    
    // Create a DIV to hold the control and call HomeControl()
    var homeControlDiv = document.createElement('div');
    var homeControl = new HomeControl(homeControlDiv, map);
    homeControlDiv.index = 1;
    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(homeControlDiv);
    
    //Get selected city from index page
    selected_city = localStorage.getItem("storeddata");
    
    //Set the starting point as user request
    if (typeof(Storage) !== "undefined") { 
        $('#autocomplete').val(selected_city);
        getData(selected_city); 
    }
    else
        alert("Sorry, your browser does not support web storage..."); 
    
      
    //Create customized autocomplete
    var input = document.getElementById('autocomplete'); 
    
    //Add listener to autocomplete
    $("#autocomplete").bind("keypress", function(event) {
        if(event.which == 13) {
            localStorage.setItem("storeddata", $('#autocomplete').val()); 
            selected_city = $('#autocomplete').val();   
            clearMarkers();
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
    
    //Add listener for displaying school
    $("#displaySchool").change(function(){
        if(this.checked)
            displaySchools(map);
        else
            displaySchools(null);
    });
     
    //Add listener for displaying crime
    $("#displayCrime").change(function(){
        
        if(this.checked) 
            displayCrime(map); 
        else  
            displayCrime(null); 
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

// Add a Home control that returns the user to current position
function HomeControl(controlDiv, map) {
    controlDiv.style.padding = '5px';
    var controlUI = document.createElement('div');
    controlUI.style.backgroundColor = 'yellow';
    controlUI.style.border='1px solid';
    controlUI.style.cursor = 'pointer';
    controlUI.style.textAlign = 'center';
    controlUI.title = 'Click to re-center the map';
    controlDiv.appendChild(controlUI);
    var controlText = document.createElement('div');
    controlText.style.fontFamily='Arial,sans-serif';
    controlText.style.fontSize='12px';
    controlText.style.paddingLeft = '4px';
    controlText.style.paddingRight = '4px';
    controlText.innerHTML = '<b>Re-center the map<b>' 
    controlUI.appendChild(controlText);

    // Setup click-event listener: simply set the map
    google.maps.event.addDomListener(controlUI, 'click', function() {
        map.setCenter(current_location);
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
        var count = 0; 
        //Remove all current displayed houses
        for (var i = 0; i < houses.length; i++)
            houses[i].setMap(null);

        houses = []; 
        for(count in data)  { 
			var icon = {
                url: 'icons/house.png', 
                scaledSize: new google.maps.Size(30, 30)
            } 
            var house = new google.maps.Marker({
                map: map,
				icon: icon,
                position: new google.maps.LatLng(data[count].lat, data[count].long),
                animation:google.maps.Animation.DROP, 
            });  
			store_MLSN = (data[count].MLSNumber).substring(0);

            var house_content = '<div style="text-align:center; font-size:17px;"><b><a href="forum.php?house='+store_MLSN+'" >' + data[count].address + ", " + data[count].city + '</a></b></div>' +
                '<div style="font-size:14px;"><b>Bedrooms: </b>' + data[count].BedsTotal + '<br>' +
                '<b>Bathrooms: </b>' + data[count].BathsTotal + '<br>' + 
                '<b>Area: </b>' + data[count].SqftTotal + ' sqft<br>' +
                '<b>Lot Size Area: </b>' + data[count].LotSizeArea_Min + ' sqft<br>' +
                '<b>Age: </b>' + data[count].Age + ' year(s)<br>' +
                '<b>Price: </b>$ ' + numberWithThousandSep(data[count].CurrentPrice) + '<br>' +
                '<b>MLSNumber: </b>' + data[count].MLSNumber + "</div>";
            
            if(display_saveButton != "")
				house_content += '<button type="button" class="btn btn-success pull-right" style="height:30px; width:55px" onclick="addFavorite(\''+ store_MLSN +'\')"> Save </button>';
            
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
        var a = 0; 
        for(a in data){
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
//    console.log(data);
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
    var a_url="php/getFloodZone.php?city=" + selected_city; 
    $.get(a_url, function(data, status){  
        var a = 0;
        if(!data){
            $("#displayFloodZone").attr("disabled", true);  
            $("#label_displayFloodZone").text('No flood data');
        }
        for(a in data){ 
            ptsArray = [];
            //Get multipolygon unformatted string from database
            var point = data[a].SHAPE;   

            //Parse the multipolygon unformatted string 
            var list_poly = point.match(/\([^\(\)]+\)/g);

            for(b in list_poly){  
                //Remove the brackets '(' & ')'
                var tmp = list_poly[b].substring(1,list_poly[b].length-1); 

                //Split multipolygon into points 
                var coords = tmp.split(", "); 
                for(var c = 0; c < coords.length; c++){ 
                    var test = coords[c].split(" ");   
                    var pt = new google.maps.LatLng(test[1], test[0]);  
                    ptsArray.push(pt); 
                } 
            }  

            var poly = new google.maps.Polygon({
                path: ptsArray,
                strokeColor: '#1A1AFF',
                strokeOpacity: 0.8,
                strokeWeight: 2,
                fillColor: '#1A1AFF',
                fillOpacity: 0.35
            });

            poly.addListener('click', showArrays);
            floods.push(poly);    
            
            if(a == data.length - 1){
                $("#displayFloodZone").attr("disabled", false);
                $("#label_displayFloodZone").text('Flood zone');
            } 
        }  
    }, "json");   
    
        
}
 
function showArrays(event) {
    infoWindow = new google.maps.InfoWindow;
    // Since this polygon has only one path, we can call getPath() to return the
    // MVCArray of LatLngs.
    var vertices = this.getPath();

    var contentString = '<b>Floodzone information</b><br>' +
        'Clicked location: <br>' + event.latLng.lat() + ',' + event.latLng.lng() +
        '<br>';

    // Iterate over the vertices.
    for (var i =0; i < vertices.getLength(); i++) {
        var xy = vertices.getAt(i);
        contentString += '<br>' + 'Coordinate ' + i + ':<br>' + xy.lat() + ',' +
            xy.lng();
    }

    // Replace the info window's content and position.
    infoWindow.setContent(contentString);
    infoWindow.setPosition(event.latLng);

    infoWindow.open(map);
}

function getHouse(){
    //PHP calling  
    var a_url="php/getHouse.php?city=" + selected_city; 
	var store_MLSN;
    
    $.get(a_url, function(data, status){  
        var count = 0; 
        for(count in data)  {
			var icon = {
                url: 'icons/house.png', 
                scaledSize: new google.maps.Size(30, 30)
            } 
            var house = new google.maps.Marker({
                map: map,
				icon: icon,
                position: {lat: data[count].lat, lng: data[count].long} 
            });  
            
            store_MLSN = (data[count].MLSNumber).substring(0);

            var house_content = '<div style="text-align:center; font-size:17px;"><b><a href="forum.php?house='+store_MLSN+'" >' + data[count].address + ", " + data[count].city + '</a></b></div>' +
                '<div style="font-size:14px;"><b>Bedrooms: </b>' + data[count].BedsTotal + '<br>' +
                '<b>Bathrooms: </b>' + data[count].BathsTotal + '<br>' + 
                '<b>Area: </b>' + data[count].SqftTotal + ' sqft<br>' +
                '<b>Lot Size Area: </b>' + data[count].LotSizeArea_Min + ' sqft<br>' +
                '<b>Age: </b>' + data[count].Age + ' year(s)<br>' +
                '<b>Price: </b>$ ' + numberWithThousandSep(data[count].CurrentPrice) + '<br>' +
                '<b>MLSNumber: </b>' + data[count].MLSNumber + '</div>';
      
            if(display_saveButton != "")  
                house_content += '<button type="button" class="btn btn-success pull-right" style="height:30px; width:55px" onclick="addFavorite(\''+ store_MLSN +'\')"> Save </button>';     
				
             //Create infobox
            setInfoBox('House information', house_content, house);

            //Add house to list
            houses.push(house);
        } 
     }, "json"); 
    
//    var layer = new google.maps.FusionTablesLayer({
//      map: map,
//      heatmap: { enabled: false },
//      query: {
//        select: "*",
//        from: "1tQxcgEByzTejNyfCbX0CsZLQKE0SJY-3dHffFUUF",
//        where: "col13='Milpitas'"
//      },
//      options: {
//        styleId: 2,
//        templateId: 3
//      }
//    }); 

//    // Using fusion table from Google API
//    var fusion_url = 'https://www.googleapis.com/fusiontables/v2/query?sql=';
//    var a_query = "select status, AdditionalListingInfo, MLSNumber, address, CurrentPrice, DOM, BathsTotal, BedsTotal, BathsFull, BathsHalf, SqftTotal, LotSizeArea_Min, City, Age,       location from 1tQxcgEByzTejNyfCbX0CsZLQKE0SJY-3dHffFUUF where City ='" + selected_city + "' and status ='Active'";
//    var key = "&key=AIzaSyD5wg59qptDQmk185hwXK9uRb0PA7ttvBg";
//    
//    var url = fusion_url + encodeURIComponent(a_query) + key;
//    
//    $.get(url, function(data, status){ 
//        var store_MLSN;
//        var list_data = data['rows'];
//        for(var count in list_data){
//            var rows = list_data[count];
//            var coord = rows[14].split(",");  
//            
//            var icon = {
//                url: 'icons/house.png', 
//                scaledSize: new google.maps.Size(30, 30)
//            } 
//            
//            var house = new google.maps.Marker({
//                map: map,
//                position: new google.maps.LatLng(coord[0], coord[1]),
//				icon: icon
//            });   
//            store_MLSN = rows[2];
//
//            var house_content = '<div style="text-align:center; font-size:17px;"><b><a href="forum.php?house=' + store_MLSN+'" >' + rows[3] + ", " + rows[12] + '</a></b></div>' +
//                '<div style="font-size:14px;"><b>Bedrooms: </b>' + rows[7] + '<br>' +
//                '<b>Bathrooms: </b>' + rows[6] + '<br>' + 
//                '<b>Area: </b>' + rows[10] + ' sqft<br>' +
//                '<b>Lot Size Area: </b>' + rows[11] + ' sqft<br>' +
//                '<b>Age: </b>' + rows[13] + ' year(s)<br>' +
//                '<b>Price: </b>$ ' + numberWithThousandSep(rows[4]) + '<br>' +
//                '<b>MLSNumber: </b>' + store_MLSN + "</div>";
// 
//            if(display_saveButton != "")
//				house_content += '<button type="button" class="btn btn-success pull-right" style="height:30px; width:55px" onclick="addFavorite(\''+ store_MLSN +'\')"> Save </button>';
//
//            //Create infobox
//            setInfoBox('House information', house_content, house);
//            
//            //Add house to list
//            houses.push(house);
//        } 
//    }, "jsonp");  
}

function addFavorite(MLSNumber) { 
	 $.get("php/addHouse.php?id_house=" + MLSNumber, function(data, status){ 
        if(data == "")
            $('#successMessage').slideDown(1000, function(){ $('h3').fadeOut(2000)});
        else
            alert(data);
    });     
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
            scaledSize: new google.maps.Size(40, 40)
            } 

            var school = new google.maps.Marker({ 
                position: new google.maps.LatLng(data[count].lat, data[count].long),
                animation:google.maps.Animation.DROP,
                icon: icon
            });  
            
            //Create infobox content
            var school_content = '<div style="text-align:center; font-size:17px;"><b>' + data[count].name + '</b></div>' + 
				'<div style="font-size:15px;"><b>Address: </b>' + data[count].address + ", " + data[count].city + ",CA" + data[count].zipcode + '<br>' +
                '<b>Type: </b>' + data[count].type + '<br>' +
                '<b>Average Performance Index: </b>' + data[count].api + '<br>' + 
                '<b>State rank: </b>' + data[count].staterank + '/10</div>';  
            
            //Create infobox
            setInfoBox('School information', school_content, school);
            
            //Add school to list
            schools.push(school);
        }  
     }, "json");   
   
}

function getCrime(){
    //PHP calling  
    var a_url="php/getCrime.php?city=" + selected_city; 
    $.get(a_url, function(data, status){   
        var count = 0;    
        if(!data){
            $("#displayCrime").attr("disabled", true);  
            $("#label_displayCrime").text('No crime data');
        }
            
        for(count in data)  { 
            //Create icon for crime
            var icon = {
                url: 'icons/crime.png', 
                scaledSize: new google.maps.Size(25, 25)
            }  
            var crime = new google.maps.Marker({ 
                position: new google.maps.LatLng(data[count].lat, data[count].long),
                animation:google.maps.Animation.DROP,  
                icon: icon
            });  
            
            //Create infobox content
            var crime_content = '<div style="font-size:15px;"><b>Criminal name: </b>' + data[count].firstname + " " + data[count].lastname + "<br>" + 
				'<b>Location of crime: </b>' + data[count].street + ", " + data[count].city + ", CA" + data[count].zip + '<br>' +
                '<b>Date of birth: </b>' + data[count].dob + '<br>' + 
                '<b>Gender: </b>' + data[count].gender + "</div>";  
            
            //Create infobox
            setInfoBox('Sexual assult', crime_content, crime);
            
            //Add school to list
            crimes.push(crime);
            if(count == data.length - 1){
                $("#displayCrime").attr("disabled", false);
                $("#label_displayCrime").text('Crime');
            }
        } 
    }, "json");
}

function getData(city) {  
    geocoder.geocode({'address': city}, function(results, status) { 
      if (status == google.maps.GeocoderStatus.OK) 
      {   
          //Get the new position and set it as center of the map
          current_location = {lat: results[0].geometry.location.lat(), lng: results[0].geometry.location.lng()};  
          map.setCenter(current_location);
          map.setZoom(13); 
          
          //Reset the labels
          $("#displayCrime").attr("disabled", true);  
          $("#label_displayCrime").text('Crime');
          $("#displayFloodZone").attr("disabled", true);  
          $("#label_displayFloodZone").text('Loading flood data');
          
          //Clear all markers on map
          clearMarkers();
          
          //Display city boundary
          getCityBoundary(); 
          
          //Display houses
          getHouse();
          
          //Display crime zone
          getCrime(); 
          
          //Display flood zone
          getFloodZone();  
          
          //Display schools 
          getSchool();   
      } else {
        alert("Geocode was not successful for the following reason: " + status);
      }
    }); 
}
 
function clearMarkers() {
    //Clear all markers
    displaySchools(null);
    schools = [];
    
    //Clear crime
    displayCrime(null);
    crimes = [];
    
    //Clear city boundary
    displayCityBoundary (null);
    cityBoundary = [];
     
    //Clear flood zone
    displayFloodZone(null)
    floods = [];
    
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
    for (var i = 0; i < schools.length; i++)  
        schools[i].setMap(check); 
}

function displayCrime (check){   
    for (var i = 0; i < crimes.length; i++) 
        crimes[i].setMap(check);
}

function displayEarthquake (check){
    for (var i = 0; i < list_earthquake.length; i++) 
        list_earthquake[i].setVisible(check);
}

function displayFloodZone(check){
    for (var i = 0; i < floods.length; i++) 
        floods[i].setMap(check);
}

function setInfoBox(tab_name, message, marker){   
    //Create info window for each marker 
    var infowindow = new InfoBubble({ 
        minWidth: 400,
        minHeight: 'auto',
        disableAutoPan: false
    });   
    infowindow.addTab(tab_name, message);  
    
    google.maps.event.addListener(marker, 'click', function(){
        if(previous_infox != null)
            previous_infox.close();
        infowindow.open(map, this);    
        previous_infox = infowindow; 
    });  
    
    // Listen for user click on map to close any open info bubbles
    google.maps.event.addListener(map, "click", function () { 
        infowindow.close(); 
    }); 
}

// add thousand separator for current price
function numberWithThousandSep(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function checkFavouriteList(){
    
} 
