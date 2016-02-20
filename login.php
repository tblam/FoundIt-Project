<?php
//db2 express c  (v10.5) in local
$database = "sample";
$user = "tran";
$password = "db2admin";
$conn = db2_connect("sample", "tran", "db2admin");
session_start();
if ($conn) 
{ 
	$email = $_POST['email']; 
	$password = $_POST['password']; 
  
	$sql = "SELECT email FROM user WHERE email='$email' AND password='$password'";   

	//Execute the query      
	$stmt = db2_prepare($conn, $sql);
	$result = db2_execute($stmt);

	if ($result == true && db2_fetch_row($stmt) == true) { 
			echo $email;
			echo $password;
			$_SESSION["email"] = $email;
			$_SESSION["logged"] = true;
			echo "success";
			
    }
	
	else
	{
		$_SESSION["logged"] = false;
		echo "Wrong email or password";
	}
	db2_close($conn);
}
else {
	echo "Connection failed.";
}

?>