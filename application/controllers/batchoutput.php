<?php

class BatchOutput extends CI_Controller {
	

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('excel');
		$this->load->model('siswa');
		$this->load->model('kelas');
		$this->load->model('wali');
		$this->load->model('nilai');
		$this->load->model('nilai_m');
		$this->load->model('mata_pelajaran');
	}

	
	public function exporterLeger($value='')
	{
		$styleArray = array(
			'borders' => array(
					'top' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						),
					'bottom' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						),
					'right' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						),
					'left' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						)

				)
		);
		// echo $this->session->userdata('kd_transaksi');
		$rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
		$rendererLibrary = 'mpdf';
		$rendererLibraryPath = APPPATH.'third_party/'.$rendererLibrary;
		// echo $rendererLibrary;
		// echo "<br/>";
		// echo $rendererLibraryPath;
		// die();
		if (!PHPExcel_Settings::setPdfRenderer($rendererName,$rendererLibraryPath)) {
			die(
				'Please set the $rendererName and $rendererLibraryPath values' .
					PHP_EOL .
				' as appropriate for your directory structure'
				);
		}

		// $path_template = '../../../assets/template_excel/templateLeger.xls';
		$path_template = realpath(FCPATH).'/assets/template_excel/templateLeger.xls';
		// if (file_exists('templateLeger.xls')){
		// 	die("nananana");
		// }
		// die($path_template);
		$excel = new PHPExcel_Reader_Excel5();
		$this->excel = $excel->load($path_template);
		
		$this->excel->setActiveSheetIndex(0);
		$this->excel->getActiveSheet()->setTitle('Template Upload Nilai Kelas');
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
		//ambil data-data mapel
		$query = $this->mata_pelajaran->getAllMapelOrderByKategori();
		$i=3;
		$n = 0;
		foreach ($query->result() as $row) {
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow($i,5,$row->kd_pelajaran)->setCellValueByColumnAndRow($i++,6,$row->nama_pelajaran);			
			$n++;
		}
		//ambil kd_kelas
		$query = $this->kelas->getKelasByWali($this->session->userdata('kd_transaksi'));
		$result = $query->first_row();
		if ($result == null){
			$kd_kelas = null;
			$nama_kelas = null;
		} else {
			$kd_kelas = $result->kd_kelas;
			$nama_kelas = $result->nama_kelas;
		}
		//ambil data siswa di kelas yang diampu
		$query = $this->wali->getSiswaPerwalian($this->session->userdata('kd_transaksi'));
		
		$i = 6;
		$this->excel->getActiveSheet()->setCellValue('A6','No')->setCellValue('B6','nisn')->setCellValue('C6','Nama Siswa')
					->setCellValue('B3',$kd_kelas)->setCellValue('B2',$nama_kelas)->setCellValue('E2',$value)
					->setCellValue('A3','Kode Kelas :')->setCellValue('A2','Nama Kelas')
					->setCellValue('D2','Semester');
		$numb = 0;
		foreach ($query->result() as $row ) {
			$i++;
			$numb = $numb+1;
			// echo $numb;
			// die();
			$this->excel->getActiveSheet()->setCellValue('A'.$i,$numb.' ');
			$this->excel->getActiveSheet()->setCellValue('B'.$i,$row->nisn);
			// $this->excel->getActiveSheet()->setCellValue('A'.$i,'');
			$this->excel->getActiveSheet()->setCellValue('C'.$i,$row->nama);
			for ($j=0;$j<$n;$j++){
				$kd_siswa = $this->siswa->nisn2kd_siswa($row->nisn);
				$tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
				$kd_pelajaran = $this->excel->getActiveSheet()->getCellByColumnAndRow($j+3 , 5)->getValue();
				$query = $this->nilai->getNilaiBySiswaBySemesterByTahunAjaranByMapel($kd_siswa,$value,$tahun_ajaran,$kd_pelajaran);
				
				$result = $query->first_row();
				// print_r($result);
				// die();
				if ($result == null)
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j+3,$i,0);
				else
					$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j+3,$i,$result->nilai);
			}

		}
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,$i+2,'KKM');
		$this->excel->getActiveSheet()->setCellValueByColumnAndRow(0,$i+3,'Rata-rata');
		for ($j=0;$j<$n;$j++){
			$kd_pelajaran = $this->excel->getActiveSheet()->getCellByColumnAndRow($j+3 , 5)->getValue();
			$query = $this->mata_pelajaran->getKKM($kd_pelajaran);
			
			$result = $query->first_row();
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j+3,$i+2,$result->kkm);
			$tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
			$kd_guru = $this->session->userdata('kd_transaksi');
			$semester = $value;
			$query = $this->nilai->getRerataKelasPerwalianByPelajaranBySemesterByTahunAjaran($kd_guru,$semester,$kd_pelajaran,$tahun_ajaran);
			
			$result = $query->first_row();
			$rerata = round($result->rerata,2);
			// die($rerata);
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j+3,$i+3,$rerata);
			$this->excel->getActiveSheet()->setCellValueByColumnAndRow($j+3 , 5,'');
		}

		// $range = 'A6:'.PHPExcel_Cell::stringFromColumnIndex($n+2).($i-1);
		// echo $range;
		// die();
		for($x=6;$x<=$i;$x++){
			for ($y=0; $y <=$n+2 ; $y++) { 
				$cell = PHPExcel_Cell::stringFromColumnIndex($y) . $x;
				$this->excel->getActiveSheet()->getStyle($cell)->applyFromArray($styleArray);
			}
			
		}

		// 
		


		// $filename='templateKelas.pdf'; //save our workbook as this file name
		// header('Content-Type: application/pdf'); //mime type
		// header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		// header('Cache-Control: max-age=0'); //no cache
		$filename='templateKelas.xls'; //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache

		$objWriter = new PHPExcel_Writer_Excel5($this->excel);  
		$objWriter->save('php://output');
		# code...
	}

	public function exporterRapor($kd_siswa,$semester)
	{
		$styleArray = array(
			'borders' => array(
					'top' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						),
					'bottom' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						),
					'right' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						),
					'left' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						)

				)
		);
		$rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
		$rendererLibrary = 'mpdf';
		$rendererLibraryPath = APPPATH.'third_party/'.$rendererLibrary;
		if (!PHPExcel_Settings::setPdfRenderer($rendererName,$rendererLibraryPath)) {
			die(
				'Please set the $rendererName and $rendererLibraryPath values' .
					PHP_EOL .
				' as appropriate for your directory structure'
				);
		}
		$path_template = realpath(FCPATH).'/assets/template_excel/templateRapor.xls';
		$excel = new PHPExcel_Reader_Excel5();
		$objPHPExcel = $excel->load($path_template);
		$objWorksheet = $objPHPExcel->getActiveSheet();

		$query = $this->siswa->getSiswa($kd_siswa);
		$result = $query->first_row();
		$objWorksheet->setCellValue('C6',$result->nama_siswa);
		$objWorksheet->setCellValue('C7',$result->nisn);
		$tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
		$kd_guru = -1;
		if ($this->session->userdata('level') == 4){
			$kd_guru = $this->session->userdata('kd_transaksi');
		}
		$query = $this->kelas->getKelasBySiswaByTahunAjaranByGuru($kd_siswa,$tahun_ajaran,$kd_guru);
		$result = $query->first_row();
		$kd_kelas = $result->kd_kelas;
		
		$objWorksheet->setCellValue('F6',$result->nama);
		$objWorksheet->setCellValue('F7',$semester);
		$objWorksheet->setCellValue('F8',$tahun_ajaran);
		$i = 0;
		$query = $this->mata_pelajaran->getAllMapel();
		foreach ($query->result() as $row) {
			$tabel[++$i]['kd_pelajaran'] = $row->kd_pelajaran;
			$tabel[$i]['nama_pelajaran'] = $row->nama_pelajaran;
			$tabel[$i]['kkm'] = $row->kkm;
			$tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
			$kd_pelajaran = $row->kd_pelajaran;
			$inner_query = $this->nilai->getRerataKelasPerwalianByPelajaranBySemesterByTahunAjaran($kd_guru,$semester,$kd_pelajaran,$tahun_ajaran);
			$inner_result = $inner_query->first_row();
			$tabel[$i]['rerata'] = round($inner_result->rerata,2);
			$inner_query = $this->nilai->getNilaiBySiswaBySemesterByTahunAjaranByMapel($kd_siswa,$semester,$tahun_ajaran,$kd_pelajaran);
			$inner_result = $inner_query->first_row();

			if ($inner_result == null)
				$tabel[$i]['nilai'] = 0;
			else
				$tabel[$i]['nilai'] = $inner_result->nilai;
			$tabel[$i]['terbilang'] = $this->konversiNilai($tabel[$i]['nilai']);
			// $tabel[$i]['nilai'] = $inner_result->nilai;
			// $tabel[$i]['terbilang'] = $this->konversiNilai($inner_result->nilai);
		}
		
		$i = 0;
		foreach ($tabel as $row) {
			$i++;
			$objWorksheet->setCellValueByColumnAndRow(0,$i+11,$i);
			$objWorksheet->setCellValueByColumnAndRow(1,$i+11,$row['nama_pelajaran']);
			$objWorksheet->mergeCells(PHPExcel_Cell::stringFromColumnIndex(1).($i+11).':'.PHPExcel_Cell::stringFromColumnIndex(2).($i+11));
			$objWorksheet->setCellValueByColumnAndRow(3,$i+11,$row['kkm']);
			$objWorksheet->setCellValueByColumnAndRow(4,$i+11,$row['nilai']);
			$objWorksheet->setCellValueByColumnAndRow(5,$i+11,$row['terbilang']);
			$objWorksheet->setCellValueByColumnAndRow(6,$i+11,$row['rerata']);


		}
		for($x=12;$x<=$i+11;$x++){
			for ($y=0; $y<=6 ; $y++) { 
				$cell = PHPExcel_Cell::stringFromColumnIndex($y) . $x;
				$objWorksheet->getStyle($cell)->applyFromArray($styleArray);
			}
			
		}
		// print_r($tabel);
		// die();

		
		$filename='Rapor.pdf'; //save our workbook as this file name
		header('Content-Type: application/pdf'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache

		$objWriter = new PHPExcel_Writer_PDF($objPHPExcel);  
		$objWriter->save('php://output');
	}

	public function exporterRaporWeb($kd_siswa,$semester)
	{
		$styleArray = array(
			'borders' => array(
					'top' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						),
					'bottom' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						),
					'right' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						),
					'left' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						)

				)
		);
		$rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
		$rendererLibrary = 'mpdf';
		$rendererLibraryPath = APPPATH.'third_party/'.$rendererLibrary;
		if (!PHPExcel_Settings::setPdfRenderer($rendererName,$rendererLibraryPath)) {
			die(
				'Please set the $rendererName and $rendererLibraryPath values' .
					PHP_EOL .
				' as appropriate for your directory structure'
				);
		}
		$path_template = realpath(FCPATH).'/assets/template_excel/templateRapor.xls';
		$excel = new PHPExcel_Reader_Excel5();
		$objPHPExcel = $excel->load($path_template);
		$objWorksheet = $objPHPExcel->getActiveSheet();

		$query = $this->siswa->getSiswa($kd_siswa);
		$result = $query->first_row();
		$objWorksheet->setCellValue('C6',$result->nama_siswa);
		$objWorksheet->setCellValue('C7',$result->nisn);
		$tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
		$kd_guru = -1;
		if ($this->session->userdata('level') == 4){
			$kd_guru = $this->session->userdata('kd_transaksi');
		}
		$query = $this->kelas->getKelasBySiswaByTahunAjaranByGuru($kd_siswa,$tahun_ajaran,$kd_guru);
		$result = $query->first_row();
		$kd_kelas = $result->kd_kelas;
		
		$objWorksheet->setCellValue('F6',$result->nama);
		$objWorksheet->setCellValue('F7',$semester);
		$objWorksheet->setCellValue('F8',$tahun_ajaran);
		$i = 0;
		$query = $this->mata_pelajaran->getAllMapel();
		foreach ($query->result() as $row) {
			$tabel[++$i]['kd_pelajaran'] = $row->kd_pelajaran;
			$tabel[$i]['nama_pelajaran'] = $row->nama_pelajaran;
			$tabel[$i]['kkm'] = $row->kkm;
			$kd_pelajaran = $row->kd_pelajaran;
			$inner_query = $this->nilai->getRerataKelasPerwalianByPelajaranBySemesterByTahunAjaran($kd_guru,$semester,$kd_pelajaran,$tahun_ajaran);
			$inner_result = $inner_query->first_row();
			$tabel[$i]['rerata'] = round($inner_result->rerata,2);
			$inner_query = $this->nilai->getNilaiBySiswaBySemesterByTahunAjaranByMapel($kd_siswa,$semester,$tahun_ajaran,$kd_pelajaran);
			$inner_result = $inner_query->first_row();

			// if ($inner_result.'' == null){
			// 	$this->session->set_userdata('currentUrl',current_url());
			// 	redirect('batchoutput/noData');
			// }
			if ($inner_result == null)
				$tabel[$i]['nilai'] = 0;
			else
				$tabel[$i]['nilai'] = $inner_result->nilai;
			$tabel[$i]['terbilang'] = $this->konversiNilai($tabel[$i]['nilai']);
		}
		
		$i = 0;
		foreach ($tabel as $row) {
			$i++;
			$objWorksheet->setCellValueByColumnAndRow(0,$i+11,$i);
			$objWorksheet->setCellValueByColumnAndRow(1,$i+11,$row['nama_pelajaran']);
			$objWorksheet->mergeCells(PHPExcel_Cell::stringFromColumnIndex(1).($i+11).':'.PHPExcel_Cell::stringFromColumnIndex(2).($i+11));
			$objWorksheet->setCellValueByColumnAndRow(3,$i+11,$row['kkm']);
			$objWorksheet->setCellValueByColumnAndRow(4,$i+11,$row['nilai']);
			$objWorksheet->setCellValueByColumnAndRow(5,$i+11,$row['terbilang']);
			$objWorksheet->setCellValueByColumnAndRow(6,$i+11,$row['rerata']);


		}
		for($x=12;$x<=$i+11;$x++){
			for ($y=0; $y<=6 ; $y++) { 
				$cell = PHPExcel_Cell::stringFromColumnIndex($y) . $x;
				$objWorksheet->getStyle($cell)->applyFromArray($styleArray);
			}
			
		}

		$objWriter = new PHPExcel_Writer_HTML($objPHPExcel);  
		$output['data'] = $objWriter->generateHTMLHeader();
		$output['data'] .= $objWriter->generateStyles();
		$output['data'] .= $objWriter->generateSheetData();
		$output['data'] .= $objWriter->generateHTMLFooter();
		$output['url'] = '<p>'.anchor('batchoutput/exporterRapor/'.$kd_siswa.'/'.$semester,'Download Rapor (PDF)').'</p>';


		$this->load->view('header_wali');
		$this->load->view('tabel_rapor',$output);
		$this->load->view('footer_table');


	}

	public function konversiNilai($value)
	{
		if ($value <= 11) {
			switch ($value) {
				case '0':
					return 'nol';
					break;
				case '1':
					return 'satu';
					break;
				case '2':
					return 'dua';
					break;
				case '3':
					return 'tiga';
					break;
				case '4':
					return 'empat';
					break;
				case '5':
					return 'lima';
					break;
				case '6':
					return 'enam';
					break;
				case '7':
					return 'tujuh';
					break;
				case '8':
					return 'delapan';
					break;
				case '9':
					return 'sembilan';
					break;
				case '10':
					return 'sepuluh';
					break;
				case '11':
					return 'sebelas';
					break;
			}
		} 
		elseif ($value == 100) {
		 	return 'seratus';
		} 
		elseif ($value>11 and $value <20) {
			return $this->konversiNilai($value % 10). ' belas';
		}
		elseif ($value % 10 != 0) {
		 	return $this->konversiNilai(floor($value/10)).' puluh '.$this->konversiNilai($value % 10);
		} 
		elseif ($value % 10 == 0) {
		 	return $this->konversiNilai($value/10).' puluh ';
		}

	}

	public function nanana($value)
	{
		echo $this->konversiNilai($value);
	}



	// function index()
	// {
	// 	$this->load->view('upload/upload_form', array('error' => ' ' ));
	// }



	public function konversiStatus($value)
	{
		# code...
		switch ($value) {
			case 'Aktif':
				return '1';
				break;

			case 'Tidak Aktif':
				return '2';
				break;
		}

	}

	public function konversiJekel($value)
	{
		# code...
		switch ($value) {
			case 'Laki-laki':
				return '1';
				break;

			case 'Perempuan':
				return '2';
				break;
		}

	}

	public function konversiTipe($value)
	{
		# code...
		switch ($value) {
			case 'Reguler':
				return '1';
				break;

			case 'Santri':
				return '2';
				break;
		}

	}

	public function konversiTanggal($value)
	{
		# code...
		$perkata = explode(" ", $value);
		$bulan = $perkata[1];
		if (strcasecmp($bulan, 'januari') == 0) {
			# code...
			return $perkata[2].'-01-'.$perkata[0];
		} else if (strcasecmp($bulan, 'februari') == 0 || strcasecmp($bulan, 'pebruari') == 0) {
			# code...
			return $perkata[2].'-02-'.$perkata[0];
		} else if (strcasecmp($bulan, 'maret') == 0) {
			# code...
			return $perkata[2].'-03-'.$perkata[0];
		}
		 else if (strcasecmp($bulan, 'april') == 0) {
			# code...
			return $perkata[2].'-04-'.$perkata[0];
		}
		 else if (strcasecmp($bulan, 'mei') == 0) {
			# code...
			return $perkata[2].'-05-'.$perkata[0];
		}
		 else if (strcasecmp($bulan, 'juni') == 0) {
			# code...
			return $perkata[2].'-06-'.$perkata[0];
		}
		 else if (strcasecmp($bulan, 'juli') == 0) {
			# code...
			return $perkata[2].'-07-'.$perkata[0];
		}
		 else if (strcasecmp($bulan, 'agustus') == 0) {
			# code...
			return $perkata[2].'-08-'.$perkata[0];
		}
		 else if (strcasecmp($bulan, 'september') == 0) {
			# code...
			return $perkata[2].'-09-'.$perkata[0];
		}
		 else if (strcasecmp($bulan, 'oktober') == 0) {
			# code...
			return $perkata[2].'-10-'.$perkata[0];
		}
		 else if (strcasecmp($bulan, 'november') == 0 || strcasecmp($bulan, 'nopember') == 0) {
			# code...
			return $perkata[2].'-11-'.$perkata[0];
		}
		 else if (strcasecmp($bulan, 'desember') == 0) {
			# code...
			return $perkata[2].'-12-'.$perkata[0];
		}
	}

	public function rapor_wali($value='')
	{
		# code...
		$kd_guru = $this->session->userdata['kd_transaksi'];
		
		$query = $this->wali->getSiswaPerwalian($kd_guru);
		foreach ($query->result() as $row) {
			$data['siswa'][]  = array('kd_siswa' => $row->kd_siswa, 'nisn' => $row->nisn , 'nama_siswa' => $row->nama);
		}
		if (!isset($data)){
			$data['last_url'] = base_url().'users/home';
			$data['url'] = 'Belum ada data';

			$this->showHeader();
			$this->load->view('blank_page',$data);
			$this->load->view('footer_general');
		} else {
			$this->showHeader();
			$this->load->view('rapor',$data);
			$this->load->view('footer_general');
		}
		
	}

	public function noData()
	{
		$this->showHeader();
		$data['last_url'] = 'rapor_wali';
		$data['url'] = "belum ada data";
		$this->load->view('blank_page',$data);
		$this->load->view('footer_general');
	}

	public function exporterRapor2013($kd_siswa,$semester,$tahun_ajaran = null,$pdf = null)
	{
		$this->tahun_ajaran->cekSemester($semester);
		$ta_chooser['kd_siswa'] = $kd_siswa;
		$ta_chooser['semester'] = $semester;
		$starting = 15;
		$tabel = [];
		$styleNoBorder = array(
			'borders' => array(
					'top' => array(
							'style' => PHPExcel_Style_Border::BORDER_NONE
						),
					'bottom' => array(
							'style' => PHPExcel_Style_Border::BORDER_NONE
						),
					'right' => array(
							'style' => PHPExcel_Style_Border::BORDER_NONE
						),
					'left' => array(
							'style' => PHPExcel_Style_Border::BORDER_NONE
						)

				)
		);
		$styleArray = array(
			'borders' => array(
					'top' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						),
					'bottom' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						),
					'right' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						),
					'left' => array(
							'style' => PHPExcel_Style_Border::BORDER_THIN
						)

				)
		);
		$styleArray1 = array(
			'alignment' => array(
           			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
           			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
           		)
		);
		$styleArrayLeft = array(
			'alignment' => array(
           			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
           			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
           		)
		);
		$styleArrayVerticalTop = array(
			'alignment' => array(
					'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
           			'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
           		)
		);
		$rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
		$rendererLibrary = 'mpdf';
		$rendererLibraryPath = APPPATH.'third_party/'.$rendererLibrary;
		if (!PHPExcel_Settings::setPdfRenderer($rendererName,$rendererLibraryPath)) {
			die(
				'Please set the $rendererName and $rendererLibraryPath values' .
					PHP_EOL .
				' as appropriate for your directory structure'
				);
		}
		$path_template = realpath(FCPATH).'/assets/template_excel/templateRapor2013.xls';
		$excel = new PHPExcel_Reader_Excel5();
		$objPHPExcel = $excel->load($path_template);
		$objWorksheet = $objPHPExcel->getActiveSheet();

		$query = $this->siswa->getSiswa($kd_siswa);
		$result = $query->first_row();
		$objWorksheet->setCellValue('C8',$result->nama_siswa);
		$objWorksheet->setCellValue('C9',$result->nisn);
		if ($tahun_ajaran == null)
			$tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
		$kd_guru = -1;
		if ($this->session->userdata('level') == 4){
			$kd_guru = $this->session->userdata('kd_transaksi');
		}
		$query = $this->kelas->getKelasBySiswaByTahunAjaranByGuru($kd_siswa,$tahun_ajaran,$kd_guru);
		$result = $query->first_row();
		if ($result == null){
            $data['last_url'] = base_url().'users/home';
            $data['url'] = 'Belum ada data';
            $this->showHeader();
            $this->load->view('blank_page',$data);
            $this->load->view('footer_table');
            return 0;
		}
		$kd_kelas = $result->kd_kelas;
		
		$objWorksheet->setCellValue('J6',$result->nama);
		$objWorksheet->setCellValue('J7',$semester." ");
		$objWorksheet->setCellValue('J8',$tahun_ajaran." ");
		$i = -1;
		$query = $this->mata_pelajaran->getAllCatName();
		$count = $tab_count[] = 0;
		foreach ($query->result() as $row) {
			$mapel = $this->mata_pelajaran->getAllMapelByKategori($row->kd_kategori);
			$isiKategori[] = $mapel->num_rows();
			$listKategori[] = $row->kd_kategori;
			foreach ($mapel->result() as $in_row){
				++$i;
				$tabel[$i]['kd_pelajaran'] = $in_row->kd_pelajaran;
				$tabel[$i]['nama_pelajaran'] = $in_row->nama_pelajaran;
				$pengampu_q = $this->mata_pelajaran->getPengampu($in_row->kd_pelajaran,$tahun_ajaran,$kd_kelas);
				if ($pengampu_q->num_rows == 0)
					$tabel[$i]['nama_pengampu'] = "-";
				else{
					$pengampu = $pengampu_q->first_row();
					$tabel[$i]['nama_pengampu'] = $pengampu->nama_guru;
				}
				
				$kd_pelajaran = $in_row->kd_pelajaran;

				$inner_query = $this->nilai->getNilaiBySiswaBySemesterByTahunAjaranByMapel($kd_siswa,$semester,$tahun_ajaran,$kd_pelajaran);
				$inner_result = $inner_query->first_row();
				if ($inner_result == null)
					$tabel[$i]['nilai'] = 0;
				else if ($inner_result->nilai == null)
					$tabel[$i]['nilai'] = 0;
				else
					$tabel[$i]['nilai'] = round($inner_result->nilai/25,2);
				$tabel[$i]['predikat_nilai'] = $this->getPredikat($tabel[$i]['nilai']);

				$inner_query = $this->nilai->getNilaiKI1BySiswaBySemesterByTahunAjaranByMapel($kd_siswa,$semester,$tahun_ajaran,$kd_pelajaran);
				$inner_result = $inner_query->first_row();
				if ($inner_result == null)
					$tabel[$i]['nilai_ki1'] = 0;
				else if ($inner_result->nilai_ki1 == null)
					$tabel[$i]['nilai_ki1'] = 0;
				else
					$tabel[$i]['nilai_ki1'] = $inner_result->nilai_ki1;
				$tabel[$i]['predikat_nilai_ki1'] = $this->getPredikat($tabel[$i]['nilai_ki1']);

				$inner_query = $this->nilai->getNilaiKI4BySiswaBySemesterByTahunAjaranByMapel($kd_siswa,$semester,$tahun_ajaran,$kd_pelajaran);
				$inner_result = $inner_query->first_row();
				if ($inner_result == null)
					$tabel[$i]['nilai_ki4'] = 0;
				else if ($inner_result->nilai_ki4 == null)
					$tabel[$i]['nilai_ki4'] = 0;
				else
					$tabel[$i]['nilai_ki4'] = $inner_result->nilai_ki4;
				$tabel[$i]['predikat_nilai_ki4'] = $this->getPredikat($tabel[$i]['nilai_ki4']);
				
			}
			$tab_count[] = $count + $i;
		}
		$tertampil=0;
		$indekstabel = 0;
		$catline = $starting;
		for ($counter=0;$counter<count($tab_count)-1;$counter++){
			$catline = $tertampil+$starting;
			$tertampil++;
			// echo "kateori di line -> $catline\n";

			$ctm = "A".$catline.":"."I".$catline;
			$objWorksheet->setCellValue('A'.$catline,$this->mata_pelajaran->getCatName($listKategori[$counter]));
			$cellToLeftAligned[] = $catline;
			$objWorksheet->mergeCells($ctm);
			$n = $tab_count[$counter+1] - $tab_count[$counter];
			if ($counter == 0){
				$n++;
			}
			for ($i=0; $i < $n; $i++) { 
				$ltf = $tertampil+$starting;
				$entry = $tabel[$indekstabel];
				$objWorksheet->setCellValueByColumnAndRow(0,$ltf,$i+1);
				$objWorksheet->setCellValueByColumnAndRow(1,$ltf,$entry['nama_pelajaran']);
				$objWorksheet->setCellValueByColumnAndRow(2,$ltf,$entry['nama_pengampu']);
				$objWorksheet->setCellValueByColumnAndRow(3,$ltf,$entry['nilai']);
				$objWorksheet->setCellValueByColumnAndRow(4,$ltf,$entry['predikat_nilai']);
				$objWorksheet->setCellValueByColumnAndRow(5,$ltf,$entry['nilai_ki4']);
				$objWorksheet->setCellValueByColumnAndRow(6,$ltf,$entry['predikat_nilai_ki4']);
				$objWorksheet->setCellValueByColumnAndRow(7,$ltf,$entry['nilai_ki1']);
				$objWorksheet->setCellValueByColumnAndRow(8,$ltf,$entry['predikat_nilai_ki1']);


				$tertampil++;
				$indekstabel++;
			}
		}

		$ltf2 = $ltf + 2;
		$objWorksheet->setCellValueByColumnAndRow(0,$ltf+1," ");
		$objWorksheet->setCellValueByColumnAndRow(0,$ltf2,"No");
		$objWorksheet->setCellValueByColumnAndRow(1,$ltf2,"Jenisn Pengembangan Diri");
		$objWorksheet->setCellValueByColumnAndRow(2,$ltf2,"Keterangan");

		$kegiatan = $this->nilai_m->cekNilaiFieldKegiatan($kd_siswa,$tahun_ajaran,$semester);
		$sekunder = $this->nilai_m->cekNilaiFieldSekunder($kd_siswa,$tahun_ajaran,$semester);
		// print_r($sekunder);
		// die();

		for ($i=0; $i < 3; $i++) { 
			$placer = $i+1;
			$objWorksheet->setCellValueByColumnAndRow(0,$ltf2+$placer,$placer);				
			if (isset($kegiatan[$i])){
				$objWorksheet->setCellValueByColumnAndRow(1,$ltf2+$placer,$kegiatan[$i]['jenisn']);
				$objWorksheet->setCellValueByColumnAndRow(2,$ltf2+$placer,$kegiatan[$i]['keterangan']);
			} else {
				$objWorksheet->setCellValueByColumnAndRow(1,$ltf2+$placer,"");
				$objWorksheet->setCellValueByColumnAndRow(2,$ltf2+$placer,"");
			}
		}

		if (isset($sekunder['sakit']))
			$sakit = $sekunder['sakit'];
		else
			$sakit = 0;
		if (isset($sekunder['izin']))
			$izin = $sekunder['izin'];
		else
			$izin = 0;
		if (isset($sekunder['alfa']))
			$alfa = $sekunder['alfa'];
		else
			$alfa = 0;
		if (isset($sekunder['nilai']))
			$teks = $sekunder['nilai'];
		else
			$teks = "belum diisi oleh wali";

		$ltf3 = $ltf2 + $placer + 2;
		$objWorksheet->setCellValueByColumnAndRow(0,$ltf3-1," ");
		$objWorksheet->setCellValueByColumnAndRow(0,$ltf3,"No");
		$objWorksheet->setCellValueByColumnAndRow(1,$ltf3,"Ketidak Hadiran");
		$objWorksheet->setCellValueByColumnAndRow(2,$ltf3,"hari");
		$objWorksheet->setCellValueByColumnAndRow(0,$ltf3+1,1);
		$objWorksheet->setCellValueByColumnAndRow(1,$ltf3+1,"Sakit");
		$objWorksheet->setCellValueByColumnAndRow(2,$ltf3+1,$sakit);
		$objWorksheet->setCellValueByColumnAndRow(0,$ltf3+2,2);
		$objWorksheet->setCellValueByColumnAndRow(1,$ltf3+2,"Izin");
		$objWorksheet->setCellValueByColumnAndRow(2,$ltf3+2,$izin);
		$objWorksheet->setCellValueByColumnAndRow(0,$ltf3+3,3);
		$objWorksheet->setCellValueByColumnAndRow(1,$ltf3+3,"Tanpa Keterangan");
		$objWorksheet->setCellValueByColumnAndRow(2,$ltf3+3,$alfa);


		$maxX = $ltf3+2;
		
		for($x=$starting;$x<=$maxX;$x++){
			for ($y=0; $y<=9 ; $y++) { 
				$cell = PHPExcel_Cell::stringFromColumnIndex($y) . $x;
				$objWorksheet->getStyle($cell)->applyFromArray($styleNoBorder);
			}
			
		}

		

		for($x=$starting;$x<=$ltf;$x++){
			for ($y=0; $y<=9 ; $y++) { 
				$cell = PHPExcel_Cell::stringFromColumnIndex($y) . $x;
				$objWorksheet->getStyle($cell)->applyFromArray($styleArray);
			}
			
		}
		

		for($x=$starting;$x<=$ltf;$x++){
			$cell = PHPExcel_Cell::stringFromColumnIndex(0) . $x;
			$objWorksheet->getStyle($cell)->applyFromArray($styleArray1);
			for ($y=2; $y<=9 ; $y++) { 
				$cell = PHPExcel_Cell::stringFromColumnIndex($y) . $x;
				$objWorksheet->getStyle($cell)->applyFromArray($styleArray1);
			}
			
		}

		for($x=$ltf2;$x<=$ltf2+$placer;$x++){
			for ($y=0; $y<=2 ; $y++) { 
				$cell = PHPExcel_Cell::stringFromColumnIndex($y) . $x;
				$objWorksheet->getStyle($cell)->applyFromArray($styleArray1);
				$objWorksheet->getStyle($cell)->applyFromArray($styleArray);
			}
			
		}
		for($x=$ltf3;$x<=$ltf3+3;$x++){
			for ($y=0; $y<=2 ; $y++) { 
				$cell = PHPExcel_Cell::stringFromColumnIndex($y) . $x;
				$objWorksheet->getStyle($cell)->applyFromArray($styleArray1);
				$objWorksheet->getStyle($cell)->applyFromArray($styleArray);
			}
			
		}
		foreach ($cellToLeftAligned as $row) {
			$cell = PHPExcel_Cell::stringFromColumnIndex(0) . $row;
			$objWorksheet->getStyle($cell)->applyFromArray($styleArrayLeft);
		}



		$objWorksheet->mergeCells("J".$starting.":"."J".$ltf);
		// $teks = $this->nilai_m->cekNilaiFieldKI1($kd_siswa,$tahun_ajaran,$semester);
		$objWorksheet->setCellValueByColumnAndRow(9,$starting,$teks);
		$cell = PHPExcel_Cell::stringFromColumnIndex(9) . $starting;
		$objWorksheet->getStyle($cell)->applyFromArray($styleArrayVerticalTop);
		$objWorksheet->setShowGridLines(false);
		
		$objWriter = new PHPExcel_Writer_HTML($objPHPExcel);  
		$output['data'] = $objWriter->generateHTMLHeader();
		$output['data'] .= $objWriter->generateStyles();
		$output['data'] .= $objWriter->generateSheetData();
		$output['data'] .= $objWriter->generateHTMLFooter();
		$output['url'] = '<br/><p>'.anchor('batchoutput/exporterRapor2013/'.$kd_siswa.'/'.$semester.'/'.$tahun_ajaran.'/pdf','Download Rapor (PDF)').'</p>';

		if ($pdf != null){
			// $filename='Rapor.pdf'; //save our workbook as this file name
			// header('Content-Type: application/pdf'); //mime type
			// header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			// header('Cache-Control: max-age=0'); //no cache

			// $objWriter = new PHPExcel_Writer_PDF($objPHPExcel);  
			// $objWriter->save('php://output');
			include(APPPATH."third_party/mpdf/mpdf.php");

			$mpdf=new mPDF();
			$mpdf->SetDisplayMode('fullpage');

			$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list

			$mpdf->WriteHTML($output['data']);
				    
			$mpdf->Output();
			return 0;
		}
		$ta_chooser['tingkat'] = $this->siswa->getTingkat($kd_siswa);
		// $chooser = $this->load->view('tahun_rapor',$ta_chooser);
		$output['ta_chooser'] = $ta_chooser;
		// $output = $chooser . $output;
		$this->showHeader();
		$this->load->view('tabel_rapor',$output);
		$this->load->view('footer_table');


	}

	public function getPredikat($value='')
	{
		if ($value>=0 and $value <1 ){
			return 'K';
		}
		else if ($value>=1 and $value <2 ){
			return 'C';
		}
		else if ($value>=2 and $value <3 ){
			return 'B';
		}
		else if ($value>=3 and $value <=4 ){
			return 'SB';
		}
	}

}
?>