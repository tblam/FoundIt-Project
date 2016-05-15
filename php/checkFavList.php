<?php
// Create database connection 
include("connectToDatabase.php");

$houseID =  $_GET['houseID']; 
$userID =  $_GET['userID'];   

$sql = "select userID from favoriteHouse where userID = $userID and id_house = '$houseID'";  
//echo $sql;
$stmt = db2_prepare($conn, $sql);
$result = db2_execute($stmt);

if($result){
    if($row = db2_fetch_array($stmt))
        echo "true";
    else
        echo "";
}else
    echo "error"; 

// Closing Connection
db2_close($conn);
?> 