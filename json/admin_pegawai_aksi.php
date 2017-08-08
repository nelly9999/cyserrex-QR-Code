<?php
include "../koneksi.php";
header("Content-type: application/json");
     
$arr = array();	

if($_GET['page']=='simpan')
{
	$tgl_bimbingan = strtoupper(mysqli_real_escape_string($db,$_POST['tgl_bimbingan']));
	$materi_bimbingan = strtoupper(mysqli_real_escape_string($db,$_POST['materi_bimbingan']));
	$id_tim=$_GET['id_tim'];

	$sql_id = "SELECT d_bim.id_dosen_pembimbing FROM pkl_daftar_bimbingan d_bim
				where id_tim='$id_tim'";
	if(!$result_pmb = $db->query($sql_id)){
			die('There was an error running the query [' . $db->error . ']');
			}

	$value_pmb = $result_pmb->fetch_assoc();
	$id_dosen_pembimbing= $value_pmb['id_dosen_pembimbing'];

	$diterima=0;
	$sql_simpan = $db->query("INSERT INTO pkl_bimbingan
						(id_dosen_pembimbing,id_tim,materi_bimbingan,tgl_bimbingan,diterima)
						VALUES 
						('$id_dosen_pembimbing','$id_tim','$materi_bimbingan','$tgl_bimbingan','$diterima')
						");

			if($sql_simpan){
			echo json_encode(array('success'=>true));
			}else{
			echo json_encode(array('msg'=>'Ada Masalah Penambahan data Bimbingan '.$db->error));
			}
}

if($_GET['page']=='edit')
{
	$id_bimbingan		= mysqli_real_escape_string($db,$_POST['id_bimbingan']);
	$tgl_bimbingan		= mysqli_real_escape_string($db,$_POST['tgl_bimbingan']);
	$materi_bimbingan	= mysqli_real_escape_string($db,$_POST['materi_bimbingan']);

	$sql = $db->query("UPDATE pkl_bimbingan SET
				tgl_bimbingan			= '$tgl_bimbingan',
				materi_bimbingan		= '$materi_bimbingan'
				WHERE 	id_bimbingan='$id_bimbingan' ");	
	if($sql){
		echo json_encode(array('success'=>true));
	}else{
		echo json_encode(array('msg'=>'Ada Masalah edit konsultasi pada tanggal = '.$tgl_bimbingan.''));
	}
}

if($_GET['page']=='del')
{
	$id_bimbingan		= mysqli_real_escape_string($db,$_POST['id_bimbingan']);

	$sql = $db->query("DELETE FROM pkl_bimbingan WHERE id_bimbingan='$id_bimbingan' ");	
	if($sql){
		echo json_encode(array('success'=>true));
	}else{
		echo json_encode(array('msg'=>'Ada Masalah penghapusan bimbingan'));
	}
}

?>