<?php
//Create connection to db2 for LUW
//$database = "foundit";
//$user= "Luan Bui";
//$password = "Saigon20162";
//$conn = db2_connect($database, $user, $password);


//Create connection to db2 for zOS
$connectString = "DATABASE=stlec1;HOSTNAME=dtec938.vmec.svl.ibm.com;port=446;PROTOCOL=TCPIP;UID=sysadm;PWD=c0deshop";
$uid = "sysadm";
$pwd = "c0deshp";
$conn = db2_connect($connectString, $uid, $pwd);

?>