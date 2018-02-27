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
     
$sql = "SELECT p.id_peg, p.nama, p.nip, pr.tgl, pr.id_khd, j.nama_jbt, pr.jam_msk, pr.jam_plg, pr.jam_keluar, pr.jam_keluar_msk, pr.ket FROM presensi pr 
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
$jam_bln=0;
while($row = $result->fetch_assoc()){
	if ($row['id_peg']!=$cek)
	{
		$r++;
		$jlh=0;
		$jam_bln=0;
		$jam_bln1=0;
		$jam_bln2=0;
	}
	// $diff  = date_diff(date_create($row['jam_msk']), date_create($row['jam_plg']));
	// $jam_bln += $diff->h;
	
	//----CEK JAM---//
	if ($row['jam_keluar']=='00:00:00')
		{
			$row['jam_keluar']=$row['jam_msk'];
			$row['jam_keluar_msk']=$row['jam_msk'];
			$row['jam_plg']=$row['jam_msk'];
		}
	elseif($row['jam_keluar_msk']=='00:00:00')
		{
			$row['jam_keluar_msk']=$row['jam_keluar'];
			$row['jam_plg']=$row['jam_keluar'];
		}
	elseif($row['jam_plg']=='00:00:00')
		{
			$row['jam_plg']=$row['jam_keluar_msk'];
		}
	//----CEK JAM---//

	//----1-----
	if ($row['jam_msk'] > $row['jam_keluar'])
		{ $tl1=date('Y-m-d', strtotime($tl1=$row['tgl'] . ' +1 day')); }
	else
		{$tl1=$row['tgl'];}

	$awal1  = date_create($row['tgl'].' '.$row['jam_msk']);
	$akhir1 = date_create($tl1.' '.$row['jam_keluar']);
	$selisih1 = date_diff($awal1,$akhir1);

	//JIKA PRESENSI KELUAR
	if($row['jam_keluar']!='00:00:00')
	{
		$jam_bln1 += $selisih1->h;
	}
	//-----1----
	//-----2----
	if ($row['jam_keluar_msk'] > $row['jam_plg'])
		{ $tl2=date('Y-m-d', strtotime($tl2=$row['tgl'] . ' +1 day')); }
	else
		{$tl2=$row['tgl'];}

	$awal2  = date_create($row['tgl'].' '.$row['jam_keluar_msk']);
	$akhir2 = date_create($tl2.' '.$row['jam_plg']);
	$selisih2 = date_diff($awal2,$akhir2);

	//JIKA PRESENSI PULANG
	if($row['jam_plg']!='00:00:00')
	{
		$jam_bln2 += $selisih2->h;
	}
	//-----2----

	$jam_bln += $jam_bln1;
	$jam_bln += $jam_bln2;

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
	$arr[$r]["jam_bln"] = $jam_bln.' Jam';
	if (!empty($row['ket']))
	{
		$arr[$r]["ket"] = $row['ket'];
	}
	
	$cek = $row['id_peg'];
}	
echo "{\"total\":" .$jml_hal . ",\"rows\":" .json_encode($arr). "}" ;
?>