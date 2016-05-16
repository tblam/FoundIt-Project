<?php
// Create database connection 
include("connectToDatabase.php");

$houseID =  $_POST['houseID']; 
$userID = (int) $_POST['userID'];   

$sql = "select userID from favoriteHouse where userID = $userID and id_house = '$houseID'";  
//echo $sql;
$stmt = db2_prepare($conn, $sql);
$result = db2_execute($stmt);

if($result){
    if($row = db2_fetch_array($stmt))
        echo "saved"; 
    else
        return null;
}else
    echo "error"; 

// Closing Connection
db2_close($conn);
?> 