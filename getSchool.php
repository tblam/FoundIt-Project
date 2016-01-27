<?php
//Create connection to db2 for LUW
$database = "cs174";
$user= "Luan Bui";
$password = "Saigon20161";

$conn = db2_connect($database, $user, $password);

$range = $_GET['range'];
$lat = $_GET['lat']; 
$lng = $_GET['lng']; 
  
$sql = "select name, street, city, state, zip, county, long, lat from school where db2gse.st_distance(loc, db2gse.ST_Point($lng, $lat, 1), 'STATUTE MILE') < $range";   

//Execute the query      
$stmt = db2_prepare($conn, $sql);
$result = db2_execute($stmt);

if ($result == true) {   
    while ($row = db2_fetch_array($stmt)){  
        $json[] = array(
            'name' => $row[0], 
            'street' => $row[1],
            'city' => $row[2],
            'state' => $row[3],
            'zip' => $row[4],
            'county' => $row[5],
            'long' => $row[6],
            'lat' => $row[7]);  
    } 
		echo json_encode($json); 
}
else
    echo "Excution error!";

//Close connection
db2_close($conn);
?>
     