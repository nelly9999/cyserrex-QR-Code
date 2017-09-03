<?php
include "../koneksi.php";
header("Content-type: application/json");
$arr = array();
$arr2 = array();
$sort  	= isset($_POST['sort'])  ? strval($_POST['sort'])  : 'nama';
$order 	= isset($_POST['order']) ? strval($_POST['order']) : 'asc';
$hal   = isset($_POST['page']) ? intval($_POST['page']) : 1;
$batas = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$posisi = ($hal-1)*$batas;
$bulan_now = date("m");
$tahun_now = date("Y");
$bulan_c 	= isset($_GET['bulan_c']) ? strval($_GET['bulan_c']) : $bulan_now;
$tahun_c 	= isset($_GET['tahun_c']) ? strval($_GET['tahun_c']) : $tahun_now;

$where = "MONTH(pr.tgl) LIKE '%$bulan_c%' AND YEAR(pr.tgl) LIKE '%$tahun_c%'";
     
$sql = "SELECT p.id_peg, p.nama, p.nip, pr.tgl, pr.id_khd, j.nama_jbt FROM presensi pr
		LEFT JOIN pegawai p ON p.id_peg=pr.id_peg
		LEFT JOIN jabatan j ON j.id_jbt=p.id_jbt
    	WHERE $where
		ORDER BY $sort $order limit $posisi,$batas";

if(!$result = $db->query($sql)){
    die('There was an error running the query [' . $db->error . ']');
}	
$jml_hal=$result->num_rows;

$cek=0;
$r=-1;
$jlh=0;
while($row = $result->fetch_assoc()){
	if ($row['id_peg']!=$cek)
	{
		$r++;
		$jlh=0;
	}
	$t = date('j', strtotime($row['tgl']));
	$tgl = "tgl".$t;
	$arr[$r]["nama"] = $row['nama'];
	$arr[$r]["nip"] = $row['nip'];
	$arr[$r]["jbt"] = $row['nama_jbt'];
	if ($row['tgl'])
	{
		$arr[$r]["$tgl"] = 'x';
		$jlh++;
	}
	$arr[$r]["jumlah"] = $jlh;
	$cek = $row['id_peg'];
}	
echo "{\"total\":" .$jml_hal . ",\"rows\":" .json_encode($arr). "}" ;
?>