<?php   
// Create database connection 
include("connectToDatabase.php");

$error=''; // Variable To Store Error Message
session_start();
		$userID = (int) $_SESSION['userID'];
		$houseID = $_POST['house_id'];
		
    db2_close($conn);
//}
?>