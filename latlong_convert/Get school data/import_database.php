<?php
//Create connection to db2 for LUW
$database = "foundit";
$user= "Luan Bui";
$password = "Saigon20162";

$conn = db2_connect($database, $user, $password);

//Count record 
$record_count = 0;

//Get passing parameters  
$lng = $_GET['lng']; 
$lat = $_GET['lat'];  
$street = $_GET['street'];
$city = $_GET['city'];
$county = $_GET['county'];
$zip = $_GET['zip'];
$addr = $_GET['addr'];

$sql = "update school set address = '$street',city = '$city', county = '$county', zipcode = $zip, state = 'CA', lat = $lat, long = $lng, loc = db2gse.ST_Point($lng, $lat, 1) where address = '$addr'"; 

//Execute the query      
$result = db2_exec($conn, $sql);
 
//Execute the query 
if ($result == TRUE) {
    $record_count += 1;
    echo "Successful!";
    }
else 
    echo "Error" ;

//Close connection
db2_close($conn);
?>
     