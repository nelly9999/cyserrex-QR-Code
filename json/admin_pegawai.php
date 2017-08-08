<?php
include "../koneksi.php";
header("Content-type: application/json");
     
$sort  	= isset($_POST['sort'])  ? strval($_POST['sort'])  : 'nama';
$order 	= isset($_POST['order']) ? strval($_POST['order']) : 'asc';
$hal   = isset($_POST['page']) ? intval($_POST['page']) : 1;
$batas = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$posisi = ($hal-1)*$batas;
     
    $sql = "SELECT * FROM pegawai p
	LEFT JOIN barcode b ON b.id_peg=p.id_peg
	ORDER BY $sort $order limit $posisi,$batas";

if(!$result = $db->query($sql)){
    die('There was an error running the query [' . $db->error . ']');
}	
$jml_hal=$result->num_rows;

while($row = $result->fetch_assoc()){
		$arr[] = $row;
}	
echo "{\"total\":" .$jml_hal . ",\"rows\":" .json_encode($arr). "}" ;
?>