<?php
// Create database connection 
include("connectToDatabase.php"); 

//$sql = "select DB2GSE.ST_AsText(SHAPE) MUTILLINESTRING from floodzone";
$sql = "select DB2GSE.ST_AsText(DB2GSE.ST_Transform(SHAPE, 1)) MULTI_POLYGON from floodzone"
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
     