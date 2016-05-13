<?php
session_start(); 
//Get current page
$page = $_GET['page']; 
if(session_destroy()) // Destroying All Sessions
{
header("Location: $page"); // Redirecting To Home Page
}
?>