<?php 
// Create database connection 
include("connectToDatabase.php");

// Starting Session
session_start(); 

$error=''; // Variable To Store Error Message

if (isset($_POST['submit_login'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) 
        $error = "Username or Password is invalid";
    else{ 
        // Get username & password
        $username=$_POST['username'];
        $password=$_POST['password'];  
        // SQL query to fetch information of registerd users and finds user match.
        $sql = "SELECT firstname, lastname, userID FROM user WHERE email='$username' AND password='$password'";   

        //Execute the query      
        $stmt = db2_prepare($conn, $sql);
        $result = db2_execute($stmt);
        
        if ($result == true) { 
            if(($row = db2_fetch_array($stmt)) != null)
            { 
                $_SESSION['username'] = $username; // Initializing Session 
                $_SESSION['firstname'] = $row[0];
                $_SESSION['lastname'] = $row[1];
				$_SESSION['userID']= $row[2];		
                header('Location: profile.php'); 
            }
            else{   
                $message = "Username and/or Password incorrect.";
                echo "<script type='text/javascript'>alert('$message');</script>";
//                header("Refresh:0");
            } 
            
//            while($row = db2_fetch_array($stmt)){ 
//                $_SESSION['username']=$username; // Initializing Session 
//                $_SESSION['firstname'] = $row[0];
//                $_SESSION['lastname'] = $row[1];  
//                header('Location: profile.php'); 
//            } 
//            // if the array is empty
//            if(db2_fetch_array($stmt) == null)
//            {
//                $message = "Username and/or Password incorrect. Try Again";
//                echo "<script type='text/javascript'>alert('$message');</script>";
//            }
        }
         
        // Closing Connection
        db2_close($conn);
    }
}
?>