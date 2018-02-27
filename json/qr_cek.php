<?php
        include '../koneksi.php';
         $myArray = array();

        if($_GET['aksi']=='cek'){
		  $id_qr = mysqli_real_escape_string($db,$_POST['id']);

		  //CEK1 QR_LEVEL
		  $cek1=$db->query("SELECT * FROM barcode b 
		  					LEFT JOIN pegawai p ON p.id_peg=b.id_peg
		  					WHERE qr_code='$id_qr'");
		  if(!$cek1){
		    die($db->error);
		  }
		  $value 	= $cek1->fetch_assoc();
		  $level 	= $value['qr_level'];

		  //TIMEZONE
		  date_default_timezone_set('Asia/Makassar');
		  $jam = date('H:i:s');
		  $tanggal = date('Y/m/d');

		  if ($level=='1')
		  {

			  //CEK2 DATA
			  $sql=$db->query("SELECT * FROM barcode b 
			  					LEFT JOIN pegawai p ON p.id_peg=b.id_peg
			  					WHERE qr_code='$id_qr'");
			  if(!$sql){
			    die($db->error);
			  }

			   $num = $sql->num_rows;

			  //OUTPUT QR CODE JSON, KE STATUS/LOG
				while ($row = $sql->fetch_assoc())
					  {
					  	$myArray[] = $row;
					  }

				if($num){

					//CEK3 ID PEGAWAI
					$cek3=$db->query("SELECT * FROM barcode b 
			  					LEFT JOIN pegawai p ON p.id_peg=b.id_peg
			  					WHERE qr_code='$id_qr'");
					  if(!$cek3){
					    die($db->error);
					  }
					$value 	= $cek3->fetch_assoc();
					$id_peg = $value['id_peg'];

					

					//CONVERT TANGGAL INDONESIA
					function tanggal_indo($tanggal)
					{
						$bulan = array (1 =>   
									'Januari',
									'Februari',
									'Maret',
									'April',
									'Mei',
									'Juni',
									'Juli',
									'Agustus',
									'September',
									'Oktober',
									'Nopember',
									'Desember'
								);
						$split = explode('-', $tanggal);
						return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
					}

					$tanggalv2 = tanggal_indo(date('Y-m-d')); 
					$myArray['jam'] = $jam;
				  	$myArray['tanggal'] = $tanggalv2;

					//BATAS WAKTU
					//$waktu_plg = '14:00:00';
					//$waktu_msk = '06:00:00';

					//1=HADIR, 2=IZIN, 3=SAKIT, 4=ALFA
					$id_khd	= '1';

					//CEK4 JAM_MSK
					$cek4=$db->query("SELECT * FROM presensi WHERE id_peg='$id_peg' AND tgl='$tanggal'");
			        if(!$cek4){
						die($db->error);
					}

			        $value = $cek4->fetch_assoc();
			        $jam_msk = $value['jam_msk'];
			        $jam_keluar = $value['jam_keluar'];
			        $jam_keluar_msk = $value['jam_keluar_msk'];



					//PRESENSI MASUK
					if (empty($jam_msk) || $jam_msk=='00:00:00')
					{
				  		$sql2 = $db->query("INSERT INTO presensi (id_peg,tgl,jam_msk,id_khd) VALUES ('$id_peg','$tanggal','$jam','$id_khd')");

				  		$myArray['ket'] = 'Masuk';

					} 

					//PRESENSI KELUAR
					elseif($jam_keluar=='00:00:00' && $jam_msk!='00:00:00')
					{
						$sql2 = $db->query("UPDATE presensi SET
								jam_keluar	= '$jam'
								WHERE id_peg='$id_peg' AND tgl='$tanggal'");

				  		$myArray['ket'] = 'Keluar (Istirahat)';
					}

					//PRESENSI KELUAR
					elseif($jam_keluar_msk=='00:00:00' && $jam_keluar!='00:00:00' && $jam_msk!='00:00:00')
					{
						$sql2 = $db->query("UPDATE presensi SET
								jam_keluar_msk	= '$jam'
								WHERE id_peg='$id_peg' AND tgl='$tanggal'");

				  		$myArray['ket'] = 'Masuk (Istirahat)';
					}

					//PRESENSI PULANG
					elseif($jam_msk!='00:00:00' && $jam_keluar_msk!='00:00:00' && $jam_keluar!='00:00:00')
					{
						$sql3 = $db->query("UPDATE presensi SET
								jam_plg	= '$jam'
								WHERE id_peg='$id_peg' AND tgl='$tanggal'");

						$myArray['ket'] = 'Pulang';

					}
				}

				echo "{\"rows\":" .json_encode($myArray). "}" ;
			}
			else if ($level=='2')
			{
				/* Sambung...
				$sql = $db->query("SELECT * FROM pegawai p 
		  					LEFT JOIN presensi pr ON pr.id_peg=p.id_peg
		  					WHERE tgl!='$tanggal'");
				if(!$sql){
						die($db->error);
					}

			    $value = $sql->fetch_assoc();
			    $jam_msk = $value['jam_msk'];
				*/

				$myArray['ket'] = 'admin';
				echo "{\"rows\":" .json_encode($myArray). "}" ;
			}
			else
			{
				echo "{\"rows\":" .json_encode($myArray). "}" ;
			}
		}

		/*
        $cek = "SELECT qr_code FROM presensi WHERE qr_code='$result.code'";
        if(!$result = $koneksi->query($cek)){
            die('There was an error running the query [' . $koneksi->error . ']');
            }

        $value = $result->fetch_assoc();
        $qr_code = $value['qr_code'];
        */
?>