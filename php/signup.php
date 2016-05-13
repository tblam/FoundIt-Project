<?php   
// Create database connection 
include("connectToDatabase.php");

$error=''; // Variable To Store Error Message
if (isset($_POST['submit_signup'])) {   
    // Get username & password
    $firstname = $_POST['signup_firstname'];
    $lastname = $_POST['signup_lastname']; 
    $email = $_POST['signup_email']; 
    $password = $_POST['signup_password']; 

    //Clean up email string
    $email = strtolower(trim($email));
    
    //Check for duplicate email
    $sql = "select userID from user where email ='$email'";
    
    //Execute the query      
    $stmt = db2_prepare($conn, $sql);
    $result = db2_execute($stmt);
    
    if (db2_fetch_both($stmt) != null) {    
        echo "<script type='text/JavaScript'>alert('This email has already created an account');</script>";   
//        header("Refresh:0");
    } else{
        // Generate sql for creating an account
        $sql1 = "insert into user (firstname, lastname, email, password) values ('$firstname', '$lastname', '$email', '$password')";   

        //Execute the query      
        $stmt1 = db2_prepare($conn, $sql1);
        $result1 = db2_execute($stmt1);
        if ($result1 == true)  {
            $_SESSION['username']= $email; 
            $_SESSION['firstname'] = $firstname;
            $_SESSION['lastname'] = $lastname; 
            //Display popup
            $message = "Signup succeeded";
            echo "<script type='text/javascript'>alert('$message');</script>";
            
			$result2 = db2_execute($stmt);	
			if ($result2 = true) {
				$_SESSION['userID']= $row[0];
			}
            //direct to profile page
            header('Location: profile.php');  
        }
        else{
            $message = "Cannot sign up";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
            
    }  

    // Closing Connection
    db2_close($conn);
}
?>