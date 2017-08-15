<?php
include "../koneksi.php";
header("Content-type: application/json");
$arr = array();	
$id_jbt=$_GET['id_jbt'];
	
$sql = "SELECT id_jbt, id_peg FROM pegawai WHERE id_jbt='$id_jbt'";

if(!$result = $db->query($sql)){
    die('There was an error running the query [' . $db->error . ']');
}	

$kepsek_cek=$result->num_rows;
$a = '';
if ($kepsek_cek)
{$a = 1;}

	//echo "{\"total\":" .$result->num_rows . ",\"rows\":" .json_encode($arr). "}" ;
	echo json_encode($arr) ;
?>