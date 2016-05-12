<?php
// Create database connection 
include("connectToDatabase.php");

$city =  strtoupper($_GET['city']); 

$sql = "select lastname, firstname, dob, gender, street, city, zip, long, lat from sex_offenders where city = '$city'";  
 
//Execute the query      
$stmt = db2_prepare($conn, $sql);
$result = db2_execute($stmt);

if ($result == true) {   
    while ($row = db2_fetch_array($stmt)){  
        $json[] = array(
            'lastname' => $row[0], 
            'firstname' => $row[1],
            'dob' => $row[2],
            'gender' => $row[3],
            'street' => $row[4],
            'city' => $row[5],
            'zip' => $row[6],
            'long' => $row[7],
            'lat' => $row[8]);  
    } 
		echo json_encode($json); 
}
else
    echo "Excution error!";

//Close connection
db2_close($conn);
?>
     