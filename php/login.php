<?php 
// Create database connection 
include("connectToDatabase.php");

// Starting Session
session_start(); 

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
//                header('Location: profile.php'); 
            }
            else{    
                echo '<center>
                <div id="login_error" class="alert alert-danger fade in" style="width: 30%" role="alert"><b>Username and/or Password incorrect. Try again!</b></div>
                </center>
                <script>
                    document.addEventListener("DOMContentLoaded", function () {
                    setTimeout(function () {
                        $("#login_error").fadeOut(2000);
                    }, 2000);
                });</script>'; 
            }  
        } 
    }
}
?>