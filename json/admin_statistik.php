<?php
include "../koneksi.php";
header("Content-type: application/json");
$arr = array();	
$arr2 = array();
$sort  	= isset($_POST['sort'])  ? strval($_POST['sort'])  : 'pr.id_peg';
$order 	= isset($_POST['order']) ? strval($_POST['order']) : 'desc';
$hal   = isset($_POST['page']) ? intval($_POST['page']) : 1;
$batas = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$posisi = ($hal-1)*$batas;
$id_peg 	= isset($_GET['id_peg']) ? strval($_GET['id_peg']) : '';
//$tgl = strtoupper(mysqli_real_escape_string($db,$_GET['tgl']));


$where = "pr.id_peg LIKE '%$id_peg%'";


$sql = "SELECT * FROM presensi pr 
		LEFT JOIN pegawai p ON p.id_peg=pr.id_peg
		WHERE $where
		ORDER BY $sort $order limit $posisi,$batas";

if(!$result = $db->query($sql)){
    die('There was an error running the query [' . $db->error . ']');
}	
	$Thari=0;
	$Tjam=0;
	$Tmnt=0;
	$Tdtk=0;
	$rata=0;
	$no=1;
while($row = $result->fetch_assoc()){

		if ($row['jam_msk'] > $row['jam_plg'])
				{ $tl=date('Y-m-d', strtotime($tl=$row['tgl'] . ' +1 day')); }
			else
				{$tl=$row['tgl'];}

			$awal  = date_create($row['tgl'].' '.$row['jam_msk']);
			$akhir = date_create($tl.' '.$row['jam_plg']);
			$selisih = date_diff($awal,$akhir);

			$hari=$selisih->d;
			$jam=$selisih->h;
			$mnt=$selisih->i;
			$dtk=$selisih->s;
			$jamArr[]=$jam;
			$noArr[]=$no;

			$Thari+=$selisih->d;
			$Tjam+=$selisih->h;
			$Tmnt+=$selisih->i;
			$Tdtk+=$selisih->s;

			$merge= $jam.':'.$mnt.':'.$dtk;

			$rata+=strtotime($merge);

			if ($row['jam_msk']>'08:30:00')
			{$terlambat='Ya';}
			else {$terlambat='Tidak';}

			$row['lama_k'] = $hari.' Hari. '.$jam.' Jam.'.$mnt.' Menit.'.$dtk.' Detik';
			$row['terlambat'] = $terlambat;
			$no++;
			$arr[] = $row;
}	
		//MASIH SALAHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHHH...................
		  $rata2=$rata/$no;

		 if ($Tdtk>59)
			{
				$Mntnya=$Tdtk/60;
				$Tmnt_=$Tmnt+$Mntnya;
				$Tdtk_=$Tdtk%60;
			}
			else
			{
				$Tdtk_=$Tjam;
			}
		if ($Tmnt>59)
			{
				$Jamnya=$Tmnt/60;
				$Tjam_=$Tjam+$Jamnya;
				$Tmnt_=$Tmnt%60;
				if ($Tdtk>59)
				{
					$Tmnt_=$Tmnt_+$Mntnya;
				}
			}
			else
			{
				$Tmnt_=$Tmnt;
				$Tjam_=$Tjam;
			}
	$Tjam_=number_format($Tjam_,0);
	$Tmnt_=number_format($Tmnt_,0);

	$arr2['total_k']='<b>Total:</b> '.$Tjam_.' Jam. '.$Tmnt_.' Menit. '.$Tdtk_.' Detik';
	$arr2['kerja_t']='<b>Rata2 Kerja Perhari:</b> '.date('G',$rata2).' Jam. '.intval(date('i',$rata2)).' Menit. ';

	$sql = "SELECT * FROM pegawai WHERE id_peg='$id_peg'";
if(!$cek = $db->query($sql)){
    die('There was an error running the query [' . $db->error . ']');
}
$value 	= $cek->fetch_assoc();
$nama 	= $value['nama'];


$sql = "SELECT pr.tgl, pr.id_peg FROM presensi pr where $where";
if(!$result = $db->query($sql)){
    die('There was an error running the query [' . $db->error . ']');
}	
$jml_hal=$result->num_rows;
if (empty($jml_hal))
{
	$arr2['total_k']='<b>Total:</b> -';
	$arr2['kerja_t']='<b>Rata2 Kerja Perhari:</b> -';
	$row['nama'] = $nama;
	$arr[] = $row;
}    


echo "{\"total\":" .$jml_hal . ",\"rows\":" .json_encode($arr). ",\"rows2\":" .json_encode($arr2). "}" ;
?>