<?php
include "../koneksi.php";

if (isset($_GET['bulan']) && isset($_GET['tahun']))
{
	if ($_GET['bulan']>=1 && $_GET['bulan']<=12)
	{
		$bulan_c = $_GET['bulan'];
		$tahun_c = $_GET['tahun'];
		$month = array();
	    $month[1] = "Januari";
	    $month[2] = "Februari";
	    $month[3] = "Maret";
	    $month[4] = "April";
	    $month[5] = "Mei";
	    $month[6] = "Juni";
	    $month[7] = "Juli";
	    $month[8] = "Agustus";
	    $month[9] = "September";
	    $month[10] = "Oktober";
	    $month[11] = "Nopember";
	    $month[12] = "Desember";
		$nma_bulan_c = $month[$bulan_c];

		$json = file_get_contents('http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']).'/admin_laporan.php?bulan_c='.$bulan_c.'&tahun_c='.$tahun_c);

		include "../admin/excel/PHPExcel.php";

		$excel = new PHPExcel();
		$excel->getProperties()->setCreator('SMAN 1 Mandastana')
							   ->setLastModifiedBy('SMAN 1 Mandastana')
							   ->setTitle("Laporan Presensi")
							   ->setSubject("Laporan")
							   ->setDescription("Laporan Presensi")
							   ->setKeywords("Laporan Presensi");

		$style_col = array(
			'font' => array('bold' => true), // Set font nya jadi bold
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);

		$style_row = array(
			'alignment' => array(
				'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
			),
			'borders' => array(
				'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
				'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
				'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
				'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
			)
		);

		$style_merah = array(
	    'font'  => array(
	        'bold'  => true,
	        'color' => array('rgb' => 'E20909'),
	    ));

		/*$objDrawing = new PHPExcel_Worksheet_Drawing();
		$objDrawing->setName('file_kiri');
		$objDrawing->setDescription('file_kiri');
		$objDrawing->setPath(FCPATH.'ico/'.$_header->row('GBR_1'));
		$objDrawing->setCoordinates('A1');                      
		//setOffsetX works properly
		$objDrawing->setOffsetX(10); 
		$objDrawing->setOffsetY(10);                
		//set width, height
		$objDrawing->setWidth(50); 
		$objDrawing->setHeight(50); 
		$objDrawing->setWorksheet($excel->getActiveSheet());*/


		$barisH = 5;
		$barisH2 = $barisH+1;
		$excel->setActiveSheetIndex(0)->setCellValue('B'.$barisH, "NO"); 
		$excel->getActiveSheet()->mergeCells('B'.$barisH.':B'.$barisH2);

		$excel->setActiveSheetIndex(0)->setCellValue('C'.$barisH, "NAMA"); 
		$excel->getActiveSheet()->mergeCells('C'.$barisH.':C'.$barisH2);
		$excel->getActiveSheet()->getStyle('C'.$barisH)->getAlignment()->setWrapText(true);

		$excel->setActiveSheetIndex(0)->setCellValue('D'.$barisH, "NIP"); 
		$excel->getActiveSheet()->mergeCells('D'.$barisH.':D'.$barisH2);
		$excel->getActiveSheet()->getStyle('D'.$barisH)->getAlignment()->setWrapText(true);

		$excel->setActiveSheetIndex(0)->setCellValue('E'.$barisH, "JABATAN");
		$excel->getActiveSheet()->mergeCells('E'.$barisH.':E'.$barisH2);
		$excel->getActiveSheet()->getStyle('E'.$barisH)->getAlignment()->setWrapText(true);

		$pres_abc = 'F';
		$pres_abc2 = 'E';


		$tgl = date_create($tahun_c.'-'.$bulan_c.'-01');
		$bulan = date_format($tgl,'m');
		$tahun = date_format($tgl,'Y');
		$total_hari = cal_days_in_month(CAL_GREGORIAN,$bulan,$tahun)+1;
		for ($i=1;$i<$total_hari;$i++) { 
		 	$cek_minggu = $tahun.'-'.$bulan.'-'.$i;
		 	if(date('N', strtotime($cek_minggu)) >= 7)
		 	{
		 		$excel->getActiveSheet()->getStyle($pres_abc.$barisH2)->applyFromArray($style_merah);
		 	}	
		 	
		 	$excel->setActiveSheetIndex(0)->setCellValue($pres_abc.$barisH2, $i); 
			$excel->getActiveSheet()->getColumnDimension($pres_abc)->setWidth(3);
			$excel->getActiveSheet()->getStyle($pres_abc.$barisH2)->applyFromArray($style_col); 
		
			$excel->getActiveSheet()->getStyle($pres_abc.$barisH2)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
			$pres_abc++;
			$pres_abc2++;
		} 

		$excel->setActiveSheetIndex(0)->setCellValue('F'.$barisH, "PRESENSI"); 
		$excel->getActiveSheet()->mergeCells('F'.$barisH.':'.$pres_abc2.$barisH);
		//$excel->getActiveSheet()->getStyle('F'.$barisH)->getAlignment()->setWrapText(true);

		// Apply style
		$excel->getActiveSheet()->getStyle('B'.$barisH.':B'.$barisH2)->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('C'.$barisH.':C'.$barisH2)->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('D'.$barisH.':D'.$barisH2)->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('E'.$barisH.':E'.$barisH2)->applyFromArray($style_col);
		$excel->getActiveSheet()->getStyle('F'.$barisH.':'.$pres_abc2.$barisH)->applyFromArray($style_col);


		$data =  json_decode($json, true);
		$barisI = 7;
		$no = 1;
		foreach ($data['rows'] as $value) {
			$excel->setActiveSheetIndex(0)->setCellValue('B'.$barisI, $no);
			$excel->getActiveSheet()->getStyle('B'.$barisI)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
			$excel->setActiveSheetIndex(0)->setCellValue('C'.$barisI, $value['nama']);
			$excel->setActiveSheetIndex(0)->setCellValueExplicit('D'.$barisI, $value['nip'], PHPExcel_Cell_DataType::TYPE_STRING);
			$excel->setActiveSheetIndex(0)->setCellValue('E'.$barisI, $value['jbt']);

			$pres_isi = 'F';
			for ($i=1;$i<$total_hari;$i++)
			{
				if (isset($value['tgl'.$i]))
				{
					$excel->setActiveSheetIndex(0)->setCellValue($pres_isi.$barisI, 'x');
					$excel->getActiveSheet()->getStyle($pres_isi.$barisI)->applyFromArray($style_row);
					$excel->getActiveSheet()->getStyle($pres_isi.$barisI)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
				}
				else
				{
					$excel->setActiveSheetIndex(0)->setCellValue($pres_isi.$barisI, ' ');
					$excel->getActiveSheet()->getStyle($pres_isi.$barisI)->applyFromArray($style_row);
					$excel->getActiveSheet()->getStyle($pres_isi.$barisI)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
				}
				$pres_isi++;
			}
			
			// Apply style 
			$excel->getActiveSheet()->getStyle('B'.$barisI)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('C'.$barisI)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('D'.$barisI)->applyFromArray($style_row);
			$excel->getActiveSheet()->getStyle('E'.$barisI)->applyFromArray($style_row);
			
			$excel->getActiveSheet()->getRowDimension($barisI)->setRowHeight(15);

			$no++;
			$barisI++;
		}

		// Set width kolom
		$excel->getActiveSheet()->getColumnDimension('B')->setWidth(5); 
		$excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); 
		$excel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
		$excel->getActiveSheet()->getColumnDimension('E')->setWidth(17);

		//HEADER
		$atas = 1;
		$excel->setActiveSheetIndex(0)->setCellValue('A'.$atas, 'SMA Negeri 1 Mandastana'); 
		$excel->getActiveSheet()->mergeCells('A'.$atas.':'.$pres_abc.$atas); 
		$excel->getActiveSheet()->getStyle('A'.$atas)->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A'.$atas)->getFont()->setSize(15); 
		$excel->getActiveSheet()->getStyle('A'.$atas)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$atas = 2;
		$excel->setActiveSheetIndex(0)->setCellValue('A'.$atas, 'Jalan'); 
		$excel->getActiveSheet()->mergeCells('A'.$atas.':'.$pres_abc.$atas); 
		$excel->getActiveSheet()->getStyle('A'.$atas)->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A'.$atas)->getFont()->setSize(11); 
		$excel->getActiveSheet()->getStyle('A'.$atas)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 

		$atas = 3;
		$excel->setActiveSheetIndex(0)->setCellValue('A'.$atas, 'Telepon'); 
		$excel->getActiveSheet()->mergeCells('A'.$atas.':'.$pres_abc.$atas); 
		$excel->getActiveSheet()->getStyle('A'.$atas)->getFont()->setBold(TRUE); 
		$excel->getActiveSheet()->getStyle('A'.$atas)->getFont()->setSize(11); 
		$excel->getActiveSheet()->getStyle('A'.$atas)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); 
		$excel->getActiveSheet()->getStyle('A'.$atas.':'.$pres_abc.$atas)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

		// Set height baris ke 1, 2 dan 3
		$excel->getActiveSheet()->getRowDimension('1')->setRowHeight(15);
		$excel->getActiveSheet()->getRowDimension('2')->setRowHeight(15);
		$excel->getActiveSheet()->getRowDimension('3')->setRowHeight(15); 


		$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

		$excel->getActiveSheet(0)->setTitle("Laporan Presensi");
		$excel->setActiveSheetIndex(0);

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="Lap_Presensi_'.$nma_bulan_c.'_'.$tahun_c.'.xlsx"');
		header("Cache-Control: max-age=0");

		$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
		ob_end_clean();
		$write->save('php://output');
	}
	else
	{
		echo "Bulan Salah";
	}
}
else
{
	echo "Gagal";
}
?>