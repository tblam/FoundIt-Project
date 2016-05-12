<?php  
session_start();   
// Create database connection 
include("connectToDatabase.php");
	if(isset($_POST['comment'])){
		$houseID = $_GET['house'];
		$userID = (int) $_SESSION['userID'];	
        $comment = $_POST['comment'];
		
		$sql = "insert into COMMENT values('$houseID', $userID, '$comment', CURRENT TIMESTAMP)";     
		$stmt = db2_prepare($conn, $sql);
		$result = db2_execute($stmt);
		
		if ($result = true) {
			header("Location: " . $_SERVER["HTTP_REFERER"]);
		} 
		else
			echo "Excution error!";
	}
	db2_close($conn);
?>