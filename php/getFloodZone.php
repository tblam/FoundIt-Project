<?php
// Create database connection to DB2 for LUW
$database = "foundit";
$user= "Luan Bui";
$password = "Saigon20162";
$conn = db2_connect($database, $user, $password);
 
$city =  $_GET['city'];  

//$sql = "select DB2GSE.ST_AsText(DB2GSE.ST_Transform(SHAPE, 1)) MULTI_POLYGON from floodzone";
//$sql = "select DB2GSE.ST_Transform(SHAPE, 1) from floodzone";
//$sql = "select db2gse.ST_Intersection(DB2GSE.ST_Transform(a.SHAPE, 1), b.shape) from floodzone a, city_boundary b where b.name = '$city' fetch first 10 row only";
$sql = "select INTERSECTION from (select db2gse.ST_AsText(db2gse.ST_Intersection(DB2GSE.ST_Transform(a.SHAPE, 1), b.shape)) INTERSECTION from floodzone a, city_boundary b where b.name = '$city' fetch first 6000 row only) where INTERSECTION <> 'POINT EMPTY'";
    
//$sql = "select INTERSECTION from (select CAST(db2gse.ST_AsText(db2gse.ST_Intersection(DB2GSE.ST_Transform(a.SHAPE, 1), b.shape)) as VARCHAR (2000)) INTERSECTION from floodzone a, city_boundary b where b.name = '$city' fetch first 500 row only) where INTERSECTION like 'MULTIPOLYGON%'";

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
    echo db2_stmt_errormsg();
} 

//Close connection
db2_close($conn);
?>
     