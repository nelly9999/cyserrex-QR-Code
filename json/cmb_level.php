<?php
include "../koneksi.php";
header("Content-type: application/json");
$arr = array();	

$sql = "SELECT *, IF(qr_level=1,'Biasa','Spesial') AS qr_lvl FROM barcode GROUP BY qr_level ORDER BY qr_level ASC ";

if(!$result = $db->query($sql)){
    die('There was an error running the query [' . $db->error . ']');
}	

while($row = $result->fetch_assoc()){
		$arr[] = $row;
}	
	echo json_encode($arr) ;
?>