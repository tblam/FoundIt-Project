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

    // Generate sql
    $sql = "insert into user (firstname, lastname, email, password) values ('$firstname', '$lastname', '$email', '$password')";   

    //Execute the query      
    $stmt = db2_prepare($conn, $sql);
    $result = db2_execute($stmt);

    if ($result == true) {  
//		echo 'alert("Signup succeeded. Please log in");';  
    } else
//        echo "Cannot sign up";

    // Closing Connection
    db2_close($conn);
}
?>