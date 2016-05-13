<?php
//Create connection to db2 for LUW
$database = "foundit";
$user= "Luan Bui";
$password = "Saigon20162";

$conn = db2_connect($database, $user, $password); 

//Get passing parameters  
$lng = $_GET['lng']; 
$lat = $_GET['lat'];  
$lname = $_GET['lname']; 
$fname = $_GET['fname']; 

$sql = "update sex_offenders set lat = $lat, long = $lng, loc = db2gse.ST_Point($lng, $lat, 1) where last_name = '$lname' and first_name = '$fname'"; 
echo $sql;
//Execute the query       
$stmt = db2_prepare($conn, $sql);
$result = db2_execute($stmt); 

//Execute the query 
if (!$result)  
    echo "Error" ;
//echo db2_num_rows ($stmt);
//Close connection
db2_close($conn);
?>
     