<?php
//db2 express c  (v10.5) in local
$database = "sample";
$user = "tran";
$password = "db2admin";
$conn = db2_connect("sample", "tran", "db2admin");

if ($conn) 
{
	$firstn = $_POST['firstname'];
	$lastn = $_POST['lastname']; 
	$email = $_POST['email']; 
	$message = $_POST['message']; 
  
	$sql = "insert into contact values ('$firstn', '$lastn', '$email', '$message')";   

	//Execute the query      
	$stmt = db2_prepare($conn, $sql);
	$result = db2_execute($stmt);

	if ($result == true) {   
		echo "Insert successful";	
	}
	else
	{
		echo "message failed";
	}
	
	db2_close($conn);
}
else {
	echo "Connection failed.";
}

?>