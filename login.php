<?php
//db2 express c  (v10.5) in local
$database = "sample";
$user = "tran";
$password = "db2admin";
$conn = db2_connect("sample", "tran", "db2admin");

if ($conn) 
{ 
	$email = $_POST['email']; 
	$password = $_POST['password']; 
  
	$sql = "SELECT email, password FROM user WHERE email='$email' AND password='$password'";   

	//Execute the query      
	$stmt = db2_prepare($conn, $sql);
	$result = db2_execute($stmt);

	if ($result == true) {   
		echo "log in successed";
		header("Location: profile.html");
	}
	db2_close($conn);
}
else {
	echo "Connection failed.";
}

?>