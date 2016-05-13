<?php 
//Create connection to db2 for LUW
$database = "foundit";
$user= "Luan Bui";
$password = "Saigon20162";

$conn = db2_connect($database, $user, $password);
  
$sql = "select street,city,state,zip,last_name,first_name from sex_offenders where lat is NULL";   

//Execute the query      
$stmt = db2_prepare($conn, $sql);
$result = db2_execute($stmt);

if ($result == true) {   
    while ($row = db2_fetch_array($stmt)){  
        $json[] = array(
            'street' => $row[0],
            'city' => $row[1],
            'state' => $row[2],
            'zip' => $row[3],
            'last_name' => $row[4],
            'first_name' => $row[5]
        );  
    } 
		echo json_encode($json); 
}
else
    echo "Excution error!";

//Close connection
db2_close($conn);
?>
     