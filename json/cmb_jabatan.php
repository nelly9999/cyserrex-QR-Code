<?php
include "../koneksi.php";
header("Content-type: application/json");
$arr = array();	

$sql = "SELECT id_jbt, nama_jbt FROM jabatan ORDER BY id_jbt ASC";

if(!$result = $db->query($sql)){
    die('There was an error running the query [' . $db->error . ']');
}	

while($row = $result->fetch_assoc()){
		$arr[] = $row;
}	
	echo json_encode($arr) ;
?>