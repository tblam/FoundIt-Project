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
            addresses.push(data[count].address + ", " + data[count].city + ", California");  

        console.log("Total housing displayed: " + addresses.length);  

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
    
    geocoder.geocode({'address': addr}, function(results, status) { 
    if (status == google.maps.GeocoderStatus.OK){     
        var p = results[0].geometry.location;
        var lat = p.lat();
        var lng = p.lng();

        //Show on map
        setMarker(lat, lng, addr); 

        // Output the data
        msg = 'Address= "' + addr + '"\nlat = ' +lat+ ' lng = ' +lng+ ' (delay='+delay+'ms)\n\n'; 
        $('#resultArea').append(msg);
        
        //Get the address 
        var chunk = addr.split(",")[0]; 
        var url = "import_database.php?lat=" + lat + "&lng=" + lng + "&addr=" + chunk;
        $.get(url, function(data, status){ 
//            console.log(data);
         });
        
        console.log("Number of houses imported: " + nextAddress);
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
 

