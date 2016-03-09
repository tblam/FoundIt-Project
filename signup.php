<?php
//db2 express c  (v10.5) in local
$database = "sample";
$user = "tran";
$password = "db2admin";
$conn = db2_connect("sample", "tran", "db2admin");

if ($conn) 
{
	$firstn = $_POST['firstn'];
	$lastn = $_POST['lastn']; 
	$email = strtolower($_POST['email']); 
	$password = $_POST['password']; 
  
	$sql = "insert into user values ('$email', '$firstn', '$lastn', '$password')";   

	//Execute the query      
	$stmt = db2_prepare($conn, $sql);
	$result = db2_execute($stmt);

	if ($result == true) {   
		$_SESSION['firstn'] = $_POST['firstn'];
		//$_SESSION['message'] = "You have signed up successfully. Please log in.";
		header("Location: signupSucc.html?action=success");
	}
	else
	{
		
	}
	
	db2_close($conn);
}
else {
	echo "Connection failed.";
}

?>