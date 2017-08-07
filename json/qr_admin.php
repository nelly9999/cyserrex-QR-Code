<?php
	include '../koneksi.php';

    $pegawai = $_POST['pegawai'];
    $jenis_khd = $_POST['jenis_khd'];

    //TIMEZONE
	date_default_timezone_set('Asia/Makassar');
	$jam = date('H:i:s');
	$tanggal = date('Y/m/d');

    $sql = $db->query("INSERT INTO presensi (id_peg,tgl,jam_msk,id_khd) VALUES ('$pegawai','$tanggal','$jam','$jenis_khd')");
    if(!$sql){
    	die($db->error);
    }

?>