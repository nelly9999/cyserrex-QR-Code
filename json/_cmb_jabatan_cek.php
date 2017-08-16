<?php
include "../koneksi.php";
header("Content-type: application/json");
$arr = array();	
$id_jbt=$_GET['id_jbt'];
	
if ($id_jbt=='1')
{
	$sql = "SELECT id_jbt, id_peg FROM pegawai WHERE id_jbt='$id_jbt'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}
	$cek1=$result->num_rows;
}	
else if ($id_jbt=='2')
{
	$sql = "SELECT id_jbt, id_peg FROM pegawai WHERE id_jbt='$id_jbt'";

	if(!$result = $db->query($sql)){
	    die('There was an error running the query [' . $db->error . ']');
	}
	$cek2=$result->num_rows;
}	
else
{
	echo json_encode(array('success'=>true));
}

//JIKA CEK JABATAN (KEPSEK/WAKASEK) SUDAH ADA
if (is_null($cek1) AND is_null($cek2))
{
	echo json_encode(array('success'=>false));
}
else
{
	echo json_encode(array('success'=>true));
}
?>