<?php
include "../koneksi.php";

if($_GET['page']=='simpanCuti')
{
	$pegawai  	= $_POST['pegawai'];
	$ket  		= $_POST['ket'];
	$tgl_awal  	= $_POST['tgl_awal'];
	$tgl_akhir  = $_POST['tgl_akhir'];

         $sql=$db->query("SELECT * FROM JAM WHERE id='1'");
         if(!$sql){
         	die($db->error);
          }
            while($row = $sql->fetch_assoc()) {
            	$j_msk = $row['j_msk'];
            	$j_keluar = $row['j_keluar'];
            	$j_keluar_msk = $row['j_keluar_msk'];
            	$j_plg = $row['j_plg'];
          }
            
 	if ($tgl_awal < $tgl_akhir || $pegawai=='' || $ket=='')
 	{
 		for($i=$tgl_awal;$i<=$tgl_akhir;$i++)
 		{
 			$iw=0;
 		 	$bulan = date("m",strtotime($i));
 		 	$tahun = date("Y",strtotime($i));
			// $tgl = date_create($submit_thn.'-'.$submit_bln.'-01');
			// $bulan = date_format($i,'m');
			// $tahun = date_format($i,'Y');
			$total_hari = cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun)+1;
			 for ($x=1;$x<$total_hari;$x++) { 
			 	$cek_minggu = $tahun.'-'.$bulan.'-'.$x;
			 	if(date('N', strtotime($cek_minggu)) >= 7)
			 		{
			 			if($i==$cek_minggu)
			 			{
			 				$iw=1;
			 			}
			 		}
			} 

			if($iw!=1)//TGL TDK LIBUR
			{
				$sql = $db->query("INSERT INTO presensi (id_peg, tgl, jam_msk, jam_keluar, jam_keluar_msk, jam_plg, id_khd, ket)
						VALUES ('$pegawai','$i','$j_msk','$j_keluar','$j_keluar_msk','$j_plg','2','$ket')");	
				if($sql)
				{
					echo json_encode(array('success'=>true));
				}
				else
				{
					echo json_encode(array('msg'=>'Ada Masalah Penyimpanan Jam '.$db->error));
				}
			}
		
			
		}	
	}
	else
	{
		echo json_encode(array('msg'=>'Ada kesalahan pada pengisian Kosong/Tanggal Awal Lebih besar'));
	}
}
?>