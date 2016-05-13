<?php   
// Create database connection 
include("connectToDatabase.php");
session_start();
//Check for duplicate save house 
$userID = $_SESSION['userID'];
$houseID = $_GET['id_house'];

$sql = "select * from favoriteHouse where userID = $userID and id_house = '$houseID'";
//Execute the query      
$stmt = db2_prepare($conn, $sql);
$result = db2_execute($stmt);  

if(!db2_fetch_array($stmt)){
    $sql = "insert into favoriteHouse (userID, id_house) values ($userID, '$houseID')"; 
//    echo $sql;
    //Execute the query      
    $stmt = db2_prepare($conn, $sql);
    $result = db2_execute($stmt); 
    if(!$result)
        echo "Cannot save! Database error!";
}else
    echo "You have already saved this house!"; 
return null;
?>