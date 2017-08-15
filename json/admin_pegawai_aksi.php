<?php
include "../koneksi.php";
header("Content-type: application/json");
     
$arr = array();	

if($_GET['page']=='simpan')
{
	$nip=$_POST['nip'];
	$nama=$_POST['nama'];
	$jk=$_POST['jk'];
	$jabatan=$_POST['id_jbt'];
	$status=$_POST['id_sts'];
	$tgl_lhr=$_POST['tgl_lahir'];
	$alamat=$_POST['alamat'];
	$no_telp=$_POST['no_telp'];
/*
	//CEK KEPSEK
	$sql_cek_1 = "SELECT id_jbt FROM pegawai WHERE id_jbt='1'";
	if(!$result = $db->query($sql_cek_1)){
			die('There was an error running the query [' . $db->error . ']');
			}
	$kepsek_cek=$result->num_rows;
	$a = '';
	if ($kepsek_cek)
	{$a = 1;}

	//CEK WAKASEK
	$sql_cek_2 = "SELECT id_jbt FROM pegawai WHERE id_jbt='2'";
	if(!$result = $db->query($sql_cek_2)){
			die('There was an error running the query [' . $db->error . ']');
			}
	$wakasek_cek=$result->num_rows;
	$b = '';
	if ($wakasek_cek)
	{$b = 2;}
*/

	if (!empty($_FILES['foto']['name']))
	{
		$tipe_file   = $_FILES['foto']['type'];
		$lokasi_file = $_FILES['foto']['tmp_name'];
		$ukuran_file = $_FILES['foto']['size'];
		$path 		 = $_FILES['foto']['name'];
		$ext 		 = pathinfo($path, PATHINFO_EXTENSION);
		$nama_nospace= str_replace(' ', '_', $nama);
		$nama_file	 = $nama_nospace."-".$tgl_lhr.".".$ext;
		$direktori 	 = "../foto/$nama_file";
	}


	if (isset($nip))
	{
		$sql_cek = "SELECT nip 
					FROM pegawai
					WHERE nip='$nip' AND nip!=''";

		if(!$result = $db->query($sql_cek)){
				die('There was an error running the query [' . $db->error . ']');
				}

		$nip_cek=$result->num_rows;
		if ($nip_cek)
		{
			echo json_encode(array('msg'=>'Data Pegawai dengan NIP: '.$nip.' sudah ada.'));
		}
		else 
		{
			if (!empty($_FILES['foto']['name']))
			{
				$ekstensi_diperbolehkan = array( "image/png", "image/jpg", "image/gif", "image/jpeg" );
				if (!in_array($tipe_file, $ekstensi_diperbolehkan))
				{
					echo json_encode(array('msg'=>'Upload Gagal, Tipe File: ('.$tipe_file.'). Hanya file Foto yang bisa diupload'));
				}					
				else if ($ukuran_file>(1024*1024))
				{
					echo json_encode(array('msg'=>'Maksimal File Upload 1Mb !!!'));
				}
				else
				{
					move_uploaded_file($lokasi_file,"$direktori");

					$sql_simpan = $db->query("INSERT INTO pegawai
									(nip,nama,jk,id_jbt,id_sts,tgl_lahir,alamat,no_telp,foto)
									VALUES 
									('$nip','$nama','$jk','$jabatan','$status','$tgl_lhr','$alamat','$no_telp','$nama_file')
									");

					if($sql_simpan)
					{
						$id_peg_akhir = $db->insert_id;	
						//TAMBAH ID PEGAWAI AKHIR KE BARCODE
						$qr_level=1;
						$sql_simpan = $db->query("INSERT INTO barcode
									(id_peg,qr_level)
									VALUES 
									('$id_peg_akhir','$qr_level')
									");

						if($sql_simpan)
						{
							echo json_encode(array('success'=>true));
						}
						else
						{
							echo json_encode(array('msg'=>'Ada Masalah Penambahan data Pegawai '.$db->error));
						}		
					}
					else
					{
						echo json_encode(array('msg'=>'Ada Masalah Penambahan data Pegawai '.$db->error));
					}
				}	
			}
			else
			{
				$sql_simpan = $db->query("INSERT INTO pegawai
									(nip,nama,jk,id_jbt,id_sts,tgl_lahir,alamat,no_telp)
									VALUES 
									('$nip','$nama','$jk','$jabatan','$status','$tgl_lhr','$alamat','$no_telp')
									");

				if($sql_simpan)
				{
					$id_peg_akhir = $db->insert_id;	
					//TAMBAH ID PEGAWAI AKHIR KE BARCODE
					$qr_level=1;
					$sql_simpan = $db->query("INSERT INTO barcode
								(id_peg,qr_level)
								VALUES 
								('$id_peg_akhir','$qr_level')
								");

					if($sql_simpan)
					{
						echo json_encode(array('success'=>true));
					}
					else
					{
						echo json_encode(array('msg'=>'Ada Masalah Penambahan data Pegawai '.$db->error));
					}		
				}
				else
				{
					echo json_encode(array('msg'=>'Ada Masalah Penambahan data Pegawai '.$db->error));
				}
			}		
		}
	}
	else
	{
		if (!empty($_FILES['foto']['name']))
		{
			$ekstensi_diperbolehkan = array( "image/png", "image/jpg", "image/gif", "image/jpeg" );
			if (!in_array($tipe_file, $ekstensi_diperbolehkan))
			{
				echo json_encode(array('msg'=>'Upload Gagal, Tipe File: ('.$tipe_file.'). Hanya file Foto yang bisa diupload'));
			}	
				
			else if ($ukuran_file>(1024*1024))
			{
				echo json_encode(array('msg'=>'Maksimal File Upload 1Mb !!!'));
			}
			else
			{
				move_uploaded_file($lokasi_file,"$direktori");

				$sql_simpan = $db->query("INSERT INTO pegawai
								(nip,nama,jk,id_jbt,id_sts,tgl_lahir,alamat,no_telp,foto)
								VALUES 
								('$nip','$nama','$jk','$jabatan','$status','$tgl_lhr','$alamat','$no_telp','$nama_file')
								");

				if($sql_simpan)
				{
					$id_peg_akhir = $db->insert_id;	
					//TAMBAH ID PEGAWAI AKHIR KE BARCODE
					$qr_level=1;
					$sql_simpan = $db->query("INSERT INTO barcode
								(id_peg,qr_level)
								VALUES 
								('$id_peg_akhir','$qr_level')
								");

					if($sql_simpan)
					{
						echo json_encode(array('success'=>true));
					}
					else
					{
						echo json_encode(array('msg'=>'Ada Masalah Penambahan data Pegawai '.$db->error));
					}		
				}
				else
				{
					echo json_encode(array('msg'=>'Ada Masalah Penambahan data Pegawai '.$db->error));
				}
			}	
		}
		else
		{
			$sql_simpan = $db->query("INSERT INTO pegawai
								(nip,nama,jk,id_jbt,id_sts,tgl_lahir,alamat,no_telp)
								VALUES 
								('$nip','$nama','$jk','$jabatan','$status','$tgl_lhr','$alamat','$no_telp')
								");

			if($sql_simpan)
			{
				$id_peg_akhir = $db->insert_id;	
				//TAMBAH ID PEGAWAI AKHIR KE BARCODE
				$qr_level=1;
				$sql_simpan = $db->query("INSERT INTO barcode
							(id_peg,qr_level)
							VALUES 
							('$id_peg_akhir','$qr_level')
							");

				if($sql_simpan)
				{
					echo json_encode(array('success'=>true));
				}
				else
				{
					echo json_encode(array('msg'=>'Ada Masalah Penambahan data Pegawai '.$db->error));
				}		
			}
			else
			{
				echo json_encode(array('msg'=>'Ada Masalah Penambahan data Pegawai '.$db->error));
			}
		}
	}	
}

if($_GET['page']=='edit')
{
	$id_peg=$_POST['id_peg'];
	$nip=$_POST['nip'];
	$nama=$_POST['nama'];
	$jk=$_POST['jk'];
	$jabatan=$_POST['id_jbt'];
	$status=$_POST['id_sts'];
	$tgl_lhr=$_POST['tgl_lahir'];
	$alamat=$_POST['alamat'];
	$no_telp=$_POST['no_telp'];

	$sql_cek = "SELECT nip, id_peg 
				FROM pegawai
				WHERE nip='$nip' && nip!='' && id_peg!='$id_peg'";
	if(!$result = $db->query($sql_cek)){
			die('There was an error running the query [' . $db->error . ']');
			}
	$nip_cek=$result->num_rows;

	if (!$nip_cek)
	{
		if (!empty($_FILES['foto']['name']))
		{
			//CEK FILE JIKA ADA
			$sql_cek = "SELECT foto 
						FROM pegawai
						WHERE id_peg='$id_peg'";
			if(!$result = $db->query($sql_cek)){
				die('There was an error running the query [' . $db->error . ']');
				}
			$id_peg_cek=$result->fetch_assoc();
			$foto_cek = $id_peg_cek['foto'];
			if (!empty($foto_cek) && file_exists("../foto/$foto_cek"))
			{
				//HAPUS FILE
				unlink("../foto/$foto_cek");
			}

			$tipe_file   = $_FILES['foto']['type'];
			$lokasi_file = $_FILES['foto']['tmp_name'];
			$ukuran_file = $_FILES['foto']['size'];
			$path 		 = $_FILES['foto']['name'];
			$ext 		 = pathinfo($path, PATHINFO_EXTENSION);
			$nama_nospace= str_replace(' ', '_', $nama);
			$nama_file	 = $nama_nospace."-".$tgl_lhr.".".$ext;
			$direktori 	 = "../foto/$nama_file";


			//EKSTENSI
			$ekstensi_diperbolehkan = array( "image/png", "image/jpg", "image/gif", "image/jpeg" );
			if (!in_array($tipe_file, $ekstensi_diperbolehkan))
			{
				echo json_encode(array('msg'=>'Upload Gagal, Tipe File: ('.$tipe_file.'). Hanya file Foto yang bisa diupload'));
			}	
				
			else if ($ukuran_file>(1024*1024))
			{
				echo "Maksimal File Upload 1Mb !!! <br>";
			}
			else
			{
				move_uploaded_file($lokasi_file,"$direktori");

				$sql = $db->query("UPDATE pegawai SET
							nip			= '$nip',
							nama		= '$nama',
							jk			= '$jk',
							id_jbt		= '$jabatan',
							id_sts		= '$status',
							tgl_lahir	= '$tgl_lhr',
							alamat		= '$alamat',
							no_telp		= '$no_telp',
							foto 		= '$nama_file'
							WHERE id_peg='$id_peg' ");	

				if($sql)
				{
					echo json_encode(array('success'=>true));	
				}
				else
				{
					echo json_encode(array('msg'=>'Ada Masalah Penambahan data Pegawai '.$db->error));
				}
			}	
		}
		else
		{
			$sql = $db->query("UPDATE pegawai SET
						nip			= '$nip',
						nama		= '$nama',
						jk			= '$jk',
						id_jbt		= '$jabatan',
						id_sts		= '$status',
						tgl_lahir	= '$tgl_lhr',
						alamat		= '$alamat',
						no_telp		= '$no_telp'
						WHERE id_peg='$id_peg' ");	

			if($sql)
			{
				echo json_encode(array('success'=>true));		
			}
			else
			{
				echo json_encode(array('msg'=>'Ada Masalah Penambahan data Pegawai '.$db->error));
			}
		}
	}
	else
	{
		echo json_encode(array('success'=>false,'msg'=>'NIP '.$nip.' Sudah ada'));
	}

}

if($_GET['page']=='hapus')
{
	$id_peg	= $_POST['id_peg'];

	//CEK FILE JIKA ADA
	$sql_cek = "SELECT foto 
				FROM pegawai
				WHERE id_peg='$id_peg'";
	if(!$result = $db->query($sql_cek)){
		die('There was an error running the query [' . $db->error . ']');
		}
	$id_peg_cek=$result->fetch_assoc();
	$foto_cek = $id_peg_cek['foto'];
	if (!empty($foto_cek) && file_exists("../foto/$foto_cek"))
	{
		//HAPUS FILE
		unlink("../foto/$foto_cek");
	}
	

	$sql = $db->query("DELETE FROM pegawai WHERE id_peg='$id_peg'");	
	if($sql)
	{
		$sql = $db->query("DELETE FROM barcode WHERE id_peg='$id_peg'");	
		if($sql)
		{
			echo json_encode(array('success'=>true));
		}
		else
		{
			echo json_encode(array('msg'=>'Ada Masalah penghapusan pegawai '.$db->error));
		}
	}
	else
	{
		echo json_encode(array('msg'=>'Ada Masalah penghapusan pegawai '.$db->error));
	}
}

if($_GET['page']=='qr_gen')
{
	include ('../admin/qr_lib_gen/qrlib.php');

	$tempdir = "../admin/temp_qr/"; 
	if (!file_exists($tempdir))
	    mkdir($tempdir);

	$id_peg=$_POST['id_peg'];
	$nama=$_POST['nama'];
	$qr_level=$_POST['qr_level'];
	$qr_code1=$_POST['qr_code1'];
	$qr_code2=$_POST['qr_code2'];
	$isi_teks= $qr_code1.$qr_code2;
	$namafile = $isi_teks.".png";
	$quality = 'H'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
	$ukuran = 5; //batasan 1 paling kecil, 10 paling besar
	$padding = 1;

	$sql_cek = "SELECT qr_code 
				FROM barcode
				WHERE qr_code='$isi_teks' && id_peg!='$id_peg'";
	if(!$result = $db->query($sql_cek)){
			die('There was an error running the query [' . $db->error . ']');
			}
	$qr_code_cek=$result->num_rows;

	if (!$qr_code_cek)
	{
		if ($qr_level=='2')
		{
			$sql_cek = "SELECT b.qr_level, p.nama 
						FROM barcode b
						LEFT JOIN pegawai p ON p.id_peg=b.id_peg
						WHERE qr_level='2'";

			if(!$result = $db->query($sql_cek)){
					die('There was an error running the query [' . $db->error . ']');
					}

			$level_cek=$result->fetch_assoc();
			$nama_level_peg_cek = $level_cek['nama'];
			if ($nama_level_peg_cek)
			{
				echo json_encode(array('success'=>false,'msg'=>'Level SPESIAL sudah ada. Yaitu pada: '.$nama_level_peg_cek));
			}
			else
			{
				$sql = $db->query("UPDATE barcode SET
									qr_code		= '$isi_teks',
									qr_level	= '$qr_level'
									WHERE id_peg='$id_peg'");	

						if($sql)
						{
							//GENERATE QR CODE
							QRCode::png($isi_teks,$tempdir.$namafile,$quality,$ukuran,$padding);
							echo json_encode(array('success'=>true,'namafile'=>$namafile,'nama'=>$nama));		
						}
						else
						{
							echo json_encode(array('msg'=>'Ada Masalah Pembaruan QR Code '.$db->error));
						}
			}
		}
		else
		{
			$sql = $db->query("UPDATE barcode SET
									qr_code		= '$isi_teks',
									qr_level	= '$qr_level'
									WHERE id_peg='$id_peg'");	

						if($sql)
						{
							//GENERATE QR CODE
							QRCode::png($isi_teks,$tempdir.$namafile,$quality,$ukuran,$padding);

							echo json_encode(array('success'=>true,'namafile'=>$namafile,'nama'=>$nama));		
						}
						else
						{
							echo json_encode(array('msg'=>'Ada Masalah Pembaruan QR Code '.$db->error));
						}
		}
	}
	else
	{
		echo json_encode(array('success'=>false,'msg'=>'QR Code '.$qr_code2.' sudah ada. Silakan ganti dengan yang lain'));
	}
}

?>