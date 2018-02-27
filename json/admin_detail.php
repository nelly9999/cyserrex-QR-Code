<?php
include "../koneksi.php";
header("Content-type: application/json");
$sql=$db->query("SELECT * FROM JAM WHERE id='1'");
            if(!$sql){
               die($db->error);
              }
            while($row = $sql->fetch_assoc()) {
            	$j_msk = $row['j_msk'];
            	$j_keluar = $row['j_keluar'];
            	$j_plg = $row['j_plg'];
            }

$arr = array();	
$arr2 = array();
$sort  	= isset($_POST['sort'])  ? strval($_POST['sort'])  : 'pr.id_peg';
$order 	= isset($_POST['order']) ? strval($_POST['order']) : 'desc';
$hal   = isset($_POST['page']) ? intval($_POST['page']) : 1;
$batas = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
$posisi = ($hal-1)*$batas;
$bulan_now = date("m");
$tahun_now = date("Y");
$id_peg 	= isset($_GET['id_peg']) ? strval($_GET['id_peg']) : '';
$bulan_c 	= isset($_GET['bulan_c']) ? strval($_GET['bulan_c']) : $bulan_now;
$tahun_c 	= isset($_GET['tahun_c']) ? strval($_GET['tahun_c']) : $tahun_now;
//$tgl = strtoupper(mysqli_real_escape_string($db,$_GET['tgl']));

$where = "pr.id_peg LIKE '$id_peg' AND MONTH(pr.tgl) LIKE '%$bulan_c%' AND YEAR(pr.tgl) LIKE '%$tahun_c%'";

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
	$total_rata2=0;

while($row = $result->fetch_assoc()){
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


			//----1---//
			if ($row['jam_msk'] > $row['jam_keluar'])
				{ $tl=date('Y-m-d', strtotime($tl=$row['tgl'] . ' +1 day')); }
			else
				{$tl=$row['tgl'];}

			$awal  = date_create($row['tgl'].' '.$row['jam_msk']);
			$akhir = date_create($tl.' '.$row['jam_keluar']);
			$selisih = date_diff($awal,$akhir);

			//UNTUK CHART TANGGAL
			$row['tanggal'] = date('j', strtotime( $row['tgl']));

			$hari=$selisih->d;
			$jam=$selisih->h;
			$mnt=$selisih->i;
			$dtk=$selisih->s;
			//----1---//

			//----2---//
			if ($row['jam_keluar_msk'] > $row['jam_plg'])
				{ $tl=date('Y-m-d', strtotime($tl=$row['tgl'] . ' +1 day')); }
			else
				{$tl=$row['tgl'];}

			$awal  = date_create($row['tgl'].' '.$row['jam_keluar_msk']);
			$akhir = date_create($tl.' '.$row['jam_plg']);
			$selisih = date_diff($awal,$akhir);

			$dtk+=$selisih->s;
			if ($dtk>59)
			{
				$mnt+=1;
				$dtk=59;
			}
			$mnt+=$selisih->i;
			if ($mnt>59)
			{
				$jam+=1;
				$mnt=59;
			}
			$jam+=$selisih->h;
			if ($jam>23)
			{
				$hari+=1;
				$jam=23;
			}
			$hari+=$selisih->d;
			


			//----2---//

			//JIKA TIDAK PRESENSI PULANG
			$Tdtk+=$dtk;
			if ($Tdtk>59)
			{
				$Tmnt+=1;
				$Tdtk=59;
			}
			$Tmnt+=$mnt;
			if ($Tmnt>59)
			{
				$Tjam+=1;
				$Tmnt=59;
			}
			$Tjam+=$jam;
			if ($Tjam>23)
			{
				$Thari+=1;
				$Tjam=23;
			}
			$Thari+=$hari;
			
			

			$row['jam_chart']=$jam;
			$total_rata2++;
			if ($total_rata2==0)
			{$total_rata2=1;}

			$merge= $jam.':'.$mnt.':'.$dtk;

			$rata+=strtotime($merge);
			


			if ($row['jam_msk']>$j_msk)
			{$terlambat='Ya';}
			else {$terlambat='Tidak';}

			$row['lama_k'] = $hari.' Hari. '.$jam.' Jam.'.$mnt.' Menit.'.$dtk.' Detik';
			$row['terlambat'] = $terlambat;
			$arr[] = $row;
}	

		  $rata2=$rata/$total_rata2;

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
	if (is_null($value['nama']))
	{
		$nama 	= '-';
	}


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