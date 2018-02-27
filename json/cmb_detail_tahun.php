<?php
include "../koneksi.php";
header("Content-type: application/json");
$arr = array();	

$sql = "SELECT YEAR(tgl) AS tahun FROM presensi GROUP BY tahun";

if(!$result = $db->query($sql)){
    die('There was an error running the query [' . $db->error . ']');
}	

while($row = $result->fetch_assoc()){
		$arr[] = $row;
}	
	echo json_encode($arr) ;
?>