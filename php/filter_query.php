<?php 
// Create database connection 
include("connectToDatabase.php");  

$city = $_GET['city'];  
$min_price = $_GET['min_price'];
$max_price = $_GET['max_price'];
$num_bed = $_GET['num_bed'];
$num_bath = $_GET['num_bath'];
   
//Get price range 
if($max_price > 0) 
    $price_range = "CurrentPrice >= $min_price And CurrentPrice <= $max_price";
else
    $price_range = "CurrentPrice >= $min_price";  
 
// SQL query to fetch information of registerd users and finds user match.
$sql = "select status, AdditionalListingInfo, MLSNumber, address, CurrentPrice, DOM, BathsTotal, BedsTotal, BathsFull, BathsHalf, SqftTotal, LotSizeArea_Min, City, Age, long, lat from house where city ='$city' AND status ='Active' AND BathsTotal >= $num_bath AND BedsTotal >= $num_bed AND $price_range" ; 
     
//Execute the query      
$stmt = db2_prepare($conn, $sql);
$result = db2_execute($stmt);

if ($result == true) {   
    while ($row = db2_fetch_array($stmt)){  
        $json[] = array(
            'status' => $row[0], 
            'AdditionalListingInfo' => $row[1],
            'MLSNumber' => $row[2],
            'address' => $row[3],
            'CurrentPrice' => $row[4],
            'DOM' => $row[5],
            'BathsTotal' => $row[6],
            'BedsTotal' => $row[7],
            'BathsFull' => $row[8], 
            'BathsHalf' => $row[9],
            'SqftTotal' => $row[10],
            'LotSizeArea_Min' => $row[11],
            'city' => $row[12],
            'Age' => $row[13],
            'long' => $row[14], 
            'lat' => $row[15]);  
    } 
    echo json_encode($json); 
}
else
    echo "Excution error!";

// Closing Connection
db2_close($conn); 
?>