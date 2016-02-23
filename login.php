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
  
	$sql = "SELECT firstn, lastn FROM user WHERE email='$email' AND password='$password'";   

	//Execute the query      
	$stmt = db2_prepare($conn, $sql);
	$result = db2_execute($stmt);

	if ($result == true) { 
		while($row = db2_fetch_array($stmt)){
			//echo $email;
			//echo $password;	
			//$_SESSION['logged'] = true;
			//echo "success";
			//$_SESSION['email'] = $row[0];
			$_SESSION['firstn'] = $row[0];
			$_SESSION['lastn'] = $row[1];	
			$_SESSION['email'] = $email;
			header('Location: index.php');
		}
		echo "Email or password is incorrect";
    }
	
	else
	{
		echo "Execution error";	
	}
	db2_close($conn);
}
else {
	echo "Connection failed.";
}

?>