<?php
// Create database connection 
include("connectToDatabase.php");

$city =  $_GET['city']; 

$sql = "select name, type, api, staterank, address, city, county, zipcode, state, long, lat from school where city = '$city'";  

//select name, type, api, staterank, address, city, county, state, long, lat from school where city = 'Milpitas'

//Execute the query      
$stmt = db2_prepare($conn, $sql);
$result = db2_execute($stmt);

if ($result == true) {   
    while ($row = db2_fetch_array($stmt)){  
        $json[] = array(
            'name' => $row[0], 
            'type' => $row[1],
            'api' => $row[2],
            'staterank' => $row[3],
            'address' => $row[4],
            'city' => $row[5],
            'county' => $row[6],
            'zipcode' => $row[7],
            'state' => $row[8],
            'long' => $row[9],
            'lat' => $row[10]);  
    } 
		echo json_encode($json); 
}
else
    echo "Excution error!";

//Close connection
db2_close($conn);
?>
     