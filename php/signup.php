<?php   
// Create database connection 
include("connectToDatabase.php");

// Starting Session
session_start(); 

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
    $sql = "select * from user where email ='$email'";
    
    //Execute the query      
    $stmt = db2_prepare($conn, $sql);
    $result = db2_execute($stmt);
    
    if (db2_fetch_both($stmt) != null) {    
        echo "<script type='text/JavaScript'>alert('This email has already created an account');</script>";   
        header("Refresh:0");
    } else{
        // Generate sql for creating an account
        $sql = "insert into user (firstname, lastname, email, password) values ('$firstname', '$lastname', '$email', '$password')";   

<<<<<<< Updated upstream
        //Execute the query      
        $stmt = db2_prepare($conn, $sql);
        $result = db2_execute($stmt);
        if ($result == true)  {
            $_SESSION['username']= $email; 
            $_SESSION['firstname'] = $firstname;
            $_SESSION['lastname'] = $lastname; 
            header('Location: profile.php');  
        }
            
    }  
=======
    if ($result == true) {  
		$message = "Signup succeeded. Please log in.";
        echo "<script type='text/javascript'>alert('$message');</script>";
		//echo 'alert("Signup succeeded. Please log in");';  
		//header('Location: home.php');
    } else{

		$message = "Cannot sign up";
        echo "<script type='text/javascript'>alert('$message');</script>";
	}
//        echo "Cannot sign up";
>>>>>>> Stashed changes

    // Closing Connection
    db2_close($conn);
}
?>