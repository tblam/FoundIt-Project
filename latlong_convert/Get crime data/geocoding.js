var map;
var geocoder;
var startingPoint = {lat: 37.3351874, lng: -121.88107150000002};
var infowindow;
var markers = [];  
 
var addresses = [];
var delay = 100;
var nextAddress = 0;

function init () { 
    geocoder = new google.maps.Geocoder();
    infowindow = new google.maps.InfoWindow(); 
    
    map = new google.maps.Map(document.getElementById("map"), {
        center: startingPoint,
        zoom: 10
    }); 
    
    //PHP calling to get the list of addresses
    $.get("getData.php", function(data){     
        var count = 0;
        //Collect addresses
        for(count in data)
            addresses.push(data[count].first_name + ", " + data[count].last_name + "," + data[count].street + ", " + data[count].city + ", " + data[count].state + data[count].zip);  

        console.log("Total data displayed: " + addresses.length);  

        //Start geocode the list of addresses
        getNext();
    }, "json" );    
     
}  

function getNext(){
     if (nextAddress < addresses.length) {
         setTimeout('geoCode("'+addresses[nextAddress]+'")', delay);     
         nextAddress++;
        }
    else{
        alert("Done!");
        $('#resultLabel').text("List of addresses with latitude & longtitude");
    }
        
}
       
function geoCode(addr) {    
    //Convert address to lat & long
    var msg;   
    var firstname = addr.split(",")[0].trim(); 
    var lastname = addr.split(",")[1].trim();
    addr = addr.split(",").splice(2).toString();
//    console.log("First name: " + firstname);
//    console.log("Last name: " + lastname);
//    console.log(addr);
    
    geocoder.geocode({'address': addr}, function(results, status) { 
    if (status == google.maps.GeocoderStatus.OK){     
        var p = results[0].geometry.location;
        var lat = p.lat();
        var lng = p.lng();

        //Show on map
        setMarker(lat, lng, addr);    
        
        //Get the city, county
        for(var i = 0; i < results[0].address_components.length; i++){
            if(results[0].address_components[i].types[0] == "locality"){
                var city = results[0].address_components[i].long_name; 
            }
            if(results[0].address_components[i].types[0] == "administrative_area_level_2"){
                var county = results[0].address_components[i].long_name; 
            }
            if(results[0].address_components[i].types[0] == "street_number"){
                var street = results[0].address_components[i].long_name; 
            }
            if(results[0].address_components[i].types[0] == "route"){
                var street = street + " " + results[0].address_components[i].long_name; 
            }
            if(results[0].address_components[i].types[0] == "postal_code"){
                var zip = results[0].address_components[i].long_name; 
            } 
        } 
        
        //Display data to textbox
        msg = "Street: " + street + "\nCity: " + city + "\nCounty: " + county + "\nZip: " + zip + "\nLat: " + lat + "\nLong: " + lng + "\nDelay = " + delay + "ms\n\n";  
        $('#resultArea').append(msg); 
        
        //Import to database
        var url = "import_database.php?lat=" + lat + "&lng=" + lng + "&lname=" + lastname + "&fname=" + firstname;  
        $.get(url, function(data, status){    
//            console.log(data);
         });
         
        //Reset the delay timer
        delay = 50; 
    } else {
        if (status == google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
            nextAddress--;
            delay++;
        } else {
            var reason="Code "+status;
            msg = 'Address = "' + addr + '" error=' +reason+ '(delay='+delay+'ms)\n\n';
            alert("Geocode was not successful for the following reason: " + msg); 
            nextAddress++;
            delay = 50;
        }  
    }
    });
    
    //Go to the next address
    getNext(); 
}

function setMarker(newlat, newLng, info){ 
    var marker = new google.maps.Marker({
        map: map,
        position: new google.maps.LatLng(newlat, newLng),
        animation:google.maps.Animation.DROP,
    });
    
    //Add info box
    google.maps.event.addListener(marker, 'click', function() {
        infowindow.setContent(info);
        infowindow.open(map, this);
    });
    
    markers.push(marker);
}
 

