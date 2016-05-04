<?php   
// Create database connection 
include("connectToDatabase.php");

$error=''; // Variable To Store Error Message
session_start();

/*if (isset($_POST['submit_login'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) 
        $error = "Please sign in";
    else{*/
		//Check for duplicate save house
		$userID = (int) $_SESSION['userID'];
		$houseID = $_POST['id_house'];
		
		//$sql = "select * from favoriteHouse where useID = $userID and id_house = '$houseID'";
    
		//echo $userID;
		//echo $sql;
	
		// //Execute the query      
		//$stmt = db2_prepare($conn, $sql);
		//$result = db2_execute($stmt);
		//echo $result;
		//if (db2_fetch_array($stmt) != null) {    
		//	echo "<script type='text/JavaScript'>alert('The house is saved in your favorite list');</script>";   
		//} 
		//else{
			// // Generate sql for creating an account
			$sql1 = "insert into favoriteHouse (userID, id_house) values ($userID, '$houseID')";
			//echo $sql;
			// //Execute the query      
			$stmt1 = db2_prepare($conn, $sql1);
			$result1 = db2_execute($stmt1);
			//echo $result;
			/*if ($result1 == true)  {
				echo "<script type='text/javascript'>alert('The house abcd is added to your favorite list');</script>";
			}*/
			// else{
				// $message = "Cannot sign up";
				// echo "<script type='text/javascript'>alert('$message');</script>";
			// }
		//}
		
            
    //}

    // Closing Connection
    db2_close($conn);
//}
?>