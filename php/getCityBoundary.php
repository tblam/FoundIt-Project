<?php
// Create database connection 
include("connectToDatabase.php");

//echo $password;
$city = $_GET['city']; 
 
//$sql = "select CAST(DB2GSE.ST_AsText(DB2GSE.ST_Transform(SHAPE, 1)) as CLOB(2147483647)) MULTI_POLYGON from city_boundary where name = '$city'";
//$sql = "select DB2GSE.ST_AsText(SHAPE) MULTI_POLYGON from county_boundary where name = 'Santa Clara'";

//$sql = "select DB2GSE.ST_AsText(DB2GSE.ST_Transform(SHAPE, 1)) MULTI_POLYGON from city_boundary where name = '$city'";
  
$sql = "select DB2GSE.ST_AsText(SHAPE) from CITY_BOUNDARY where NAME = '$city'"; 

$stmt = db2_prepare($conn, $sql);
$result = db2_execute($stmt);

if ($result == true) {   
    while ($row = db2_fetch_array($stmt)){  
        $json[] = array(
            'SHAPE' => $row[0]);  
    } 
		echo json_encode($json); 
}
else{ 
//    echo "Excution error!";
    echo db2_stmt_errormsg();
} 

//Close connection
db2_close($conn);
?>
     