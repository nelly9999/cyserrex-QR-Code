<?php
include "koneksi.php";

$file = "";
$json = file_get_contents('http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/json/admin_laporan.php?bulan_c=8&tahun_c=2017');
$data =  json_decode($json, true);


$no = 1;
foreach ($data['rows'] as $value) {

		echo $no;
		echo $value['nip']."</br>";
		echo $value['nama']."</br>";
		echo $value['jbt']."</br>";
		$no++;
}
		
?>