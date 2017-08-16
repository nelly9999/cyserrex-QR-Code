<?php
include "../koneksi.php";
header("Content-type: application/json");
$arr = array();	
$sort  	= isset($_POST['sort'])  ? strval($_POST['sort'])  : 'tgl';
$order 	= isset($_POST['order']) ? strval($_POST['order']) : 'desc';
$hal   = isset($_POST['page']) ? intval($_POST['page']) : 1;
$batas = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$posisi = ($hal-1)*$batas;
$tgl 	= isset($_GET['tgl']) ? strval($_GET['tgl']) : '';
//$tgl = strtoupper(mysqli_real_escape_string($db,$_GET['tgl']));

$where = "pr.tgl LIKE '%$tgl%'";

$sql = "SELECT pr.tgl FROM presensi pr where $where";
if(!$result = $db->query($sql)){
    die('There was an error running the query [' . $db->error . ']');
}	
$jml_hal=$result->num_rows;
     
$sql = "SELECT * FROM presensi pr
LEFT JOIN pegawai p ON p.id_peg=pr.id_peg
LEFT JOIN kehadiran k ON k.id_khd=pr.id_khd
WHERE $where
ORDER BY $sort $order limit $posisi,$batas";

if(!$result = $db->query($sql)){
    die('There was an error running the query [' . $db->error . ']');
}	

while($row = $result->fetch_assoc()){
		$arr[] = $row;
}	
echo "{\"total\":" .$jml_hal . ",\"rows\":" .json_encode($arr). "}" ;
?>