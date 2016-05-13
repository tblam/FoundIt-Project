<?php 
// Create database connection 
include("connectToDatabase.php");

// Starting Session
session_start();  
 
$userID = (int) $_SESSION['userID'];
$houseID = $_POST['id_house'];
// SQL query to fetch information of registerd users and finds user match.
$sql = "DELETE from favoriteHouse WHERE id_house = '$houseID' AND userID = $userID";	  

//Execute the query      
$stmt = db2_prepare($conn, $sql);
$result = db2_execute($stmt);
if ($result == true) { 
    echo 'remove';
}
         
db2_close($conn);
?>