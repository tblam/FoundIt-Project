<?php
//Create connection to db2 for LUW
$database = "foundit";
$user= "tran";
$password = "db2admin";

$conn = db2_connect($database, $user, $password);
?>