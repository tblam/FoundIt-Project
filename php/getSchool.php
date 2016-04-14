<?php
// Create database connection 
include("connectToDatabase.php");

$city =  $_GET['city']; 

$sql = "select name, street, city, state, zip, county, long, lat from school where city = '$city'";   

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
     