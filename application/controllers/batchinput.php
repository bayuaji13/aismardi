<?php

class BatchInput extends CI_Controller {
	

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('excel');
		$this->load->model('siswa');
	}

	// function index() {
	// 	redirect('BatchInput/do_upload');
	// }

	// function index() {
	// 	redirect('BatchInput/do_upload');
	// }


	function do_upload($target,$alert = null)
	{
		
		$config['upload_path'] = './assets/uploads/temporary_xls';
		$config['allowed_types'] = 'xls';
		$config['max_size']	= '20000';
		// $config['max_width']  = '1024';
		// $config['max_height']  = '768';

		$this->load->library('upload', $config);
		

		if ( ! $this->upload->do_upload())
		{
			$data= array('error' => $this->upload->display_errors(),'target' => $target);
			$this->showHeader('');
			if ($target == 'nilai')
			{
				$data['url'] = '<a href="'.base_url('batchoutput/exporterNilai').'">Klik di sini untuk download template nilai kelas </a>';
				$data['alert'] = $alert;
			}
			elseif ($target == 'data')
			{
				if ($this->session->userdata('level') != 9)
					redirect('users/login');
				$data['url'] = '<a href="'.base_url('assets/template_excel/templateInputDataSiswa.xls').'">Klik di sini untuk download template pengisian data siswa </a>';
				$data['alert'] = $alert;
			}

			$this->load->view('upload/upload_form', $data);
			$this->load->view('footer_general'); 

		}
		else
		{
			$data = $this->upload->data();
			// print_r($data);
			// die();
			if ($target == 'nilai')
				$this->inputDataNilai($data['full_path']);
			elseif ($target == 'data') {
				$this->inputDatasiswa($data['full_path']);
			}
			elseif ($target == 'kelas') {
				$this->inputDataKelas($data['full_path']);
			}

		}
	}

	function do_upload_Nilai()
	{
		$config['upload_path'] = './assets/uploads/temporary_xls';
		$config['allowed_types'] = 'xls';
		$config['max_size']	= '20000';
		// $config['max_width']  = '1024';
		// $config['max_height']  = '768';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());

			$this->load->view('upload/upload_form', $error);
		}
		else
		{
			$data = $this->upload->data();
			// print_r($data);
			// die();
			$this->inputDataNilai($data['full_path']);

		}
	}

	public function inputNilai($file)
	{	
		$inputFileType = PHPExcel_IOFactory::identify($file);

		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($file);
		$objWorksheet = $objPHPExcel->getActiveSheet();
		$highestRow = $objWorksheet->getHighestRow(); // e.g. 10
		$highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5
		echo '<table>' . "\n";
		for ($row = 7; $row <= $highestRow; ++$row) {
			echo '<tr>' . "\n";
			for ($col = 1; $col <= $highestColumnIndex; ++$col) {
				echo '<td>' . $objWorksheet->getCellByColumnAndRow($col, $row)->getValue() . 
				'</td>' . "\n";
			}
			echo '</tr>' . "\n";
		}
		echo '</table>' . "\n";
	}

	public function konversiStatus($value = null)
	{
		if ($value == null){
			return "";
		}
		$value = strtolower($value);
		switch ($value) {
			case 'aktif':
				return '1';
				break;
			case 'aktif ':
				return '1';
				break;

			case 'tidak aktif':
				return '2';
				break;

			case 'tidak aktif ':
				return '2';
				break;
		}

	}

	public function reKonversiStatus($value = null)
	{
		if ($value == null){
			return "";
		}
		switch ($value) {
			case '1':
				return 'aktif';
				break;
			case '2':
				return 'tidak aktif';
				break;

		}

	}

	public function konversiJekel($value = null)
	{
		if ($value == null){
			return "";
		}
		# code...
		$value = strtolower($value);
		switch ($value) {
			case 'laki-laki':
				return '1';
				break;

			case 'laki-laki ':
				return '1';
				break;

			case 'laki - laki':
				return '1';
				break;

			case 'laki - laki ':
				return '1';
				break;

			case 'perempuan':
				return '2';
				break;

			case 'perempuan ':
				return '2';
				break;
		}

	}

	public function reKonversiJekel($value = null)
	{
		if ($value == null){
			return "";
		}
		switch ($value) {
			case '1':
				return 'Laki-laki';
				break;
			
			case '2':
				return 'Perempuan';
				break;
		}
	}

	public function konversiTipe($value = null)
	{
		if ($value == null){
			return "";
		}
		# code...
		$value = strtolower($value);
		switch ($value) {
			case 'reguler':
				return '1';
				break;

			case 'santri':
				return '2';
				break;

			case 'reguler ':
				return '1';
				break;

			case 'santri ':
				return '2';
				break;
		}

	}

	public function reKonversiTipe($value = null) 
	{
		if ($value == null){
			return "";
		}
		switch ($value) {
			case '1':
				return 'reguler';
				break;
			
			case '2':
				return 'santri';
				break;
		}
	}


	public function konversiTanggal($value = null)
	{
		if ($value == null){
			return "";
		}
		# code...
		$perkata = explode(" ", $value);
		$bulan = strtolower($perkata[1]);
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

	public function reKonversiTanggal($value = null)
	{
		if ($value == null){
			return "";
		}
		$perkata = explode('-', $value);
		$daftar['01'] = 'Januari';
		$daftar['02'] = 'Februari';
		$daftar['03'] = 'Maret';
		$daftar['04'] = 'April';
		$daftar['05'] = 'Mei';
		$daftar['06'] = 'Juni';
		$daftar['07'] = 'Juli';
		$daftar['08'] = 'Agustus';
		$daftar['09'] = 'September';
		$daftar['10'] = 'Oktober';
		$daftar['11'] = 'November';
		$daftar['12'] = 'Desember';
		return $perkata[2]." ".$daftar[$perkata[1]]." ".$perkata[0];
	}


	public function nip2kd_guru($nip)
	{
		if ($value == null){
			return "";
		}
		$query = $this->db->query("SELECT kd_guru FROM guru WHERE nip='$nip'");
		$result = $query->first_row();
		if ($result)
			return $result->kd_guru;
		else
			return false;
	}

	public function inputDataKelas($file)
	{
		$this->load->model('kelas');
		$this->load->model('user');

		$inputFileType = PHPExcel_IOFactory::identify($file);

		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($file);
		$objWorksheet = $objPHPExcel->getActiveSheet();
		$highestRow = $objWorksheet->getHighestRow(); // e.g. 10
		$highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5

		$nip = $objWorksheet->getCell('C5')->getValue();
		$data['nama_kelas'] = $objWorksheet->getCell('C3')->getValue();
		$data['kd_guru'] = $this->nip2kd_guru($nip);
		$data['tahun_ajaran'] = $this->tahun_ajaran->getCurrentTA();

		

		$isiKelas['tahun_ajaran'] = $this->tahun_ajaran->getCurrentTA();
		$isiKelas['kd_kelas'] = $this->kelas->process_create_kelas($data);


		$userWali= array(
                        'user' => 'WL-' . $nip,
                        'level' => '4',
                        'pass' => sha1($nip),
                        'kd_transaksi' => $data['kd_guru']
                );
		$isiKelas['kd_siswa'] = $this->siswa->nis2kd_siswa($objWorksheet->getCellByColumnAndRow(1,8));

		print_r($data);
		echo "<br/>";
		print_r($isiKelas);
		echo "<br/>";
		print_r($userWali);
		echo "<br/>";
		echo "<br/>";
		// die();

		if (!$this->user->get_user_details($userWali['user'])){
			$this->user->process_create_user($userWali);
		}

		for ($row = 8; $row <= $highestRow; ++$row) {
			$isiKelas['kd_siswa'] = $this->siswa->nis2kd_siswa($objWorksheet->getCellByColumnAndRow(1,$row));
			$this->kelas->process_isi_kelas($isiKelas);
			print_r($isiKelas);
			echo "<br/>";
		}
	}


	public function inputDataNilai($file)
	{
		$this->load->model('nilai');

		$inputFileType = PHPExcel_IOFactory::identify($file);

		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($file);
		$objWorksheet = $objPHPExcel->getActiveSheet();
		$highestRow = $objWorksheet->getHighestRow(); // e.g. 10
		$highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5
		$data['kd_kelas'] = $objWorksheet->getCellByColumnAndRow(1,3)->getValue();
		$data['semester'] = $objWorksheet->getCellByColumnAndRow(4,2)->getValue();
		$data['tahun_ajaran'] = $this->tahun_ajaran->getCurrentTA();
		for ($row = 7; $row <= $highestRow; ++$row) {
			$nis=$objWorksheet->getCellByColumnAndRow(1,$row)->getValue();
			$query = $this->db->query("SELECT kd_siswa FROM data_siswa WHERE nis='$nis'");
			$result = $query->first_row();
			$data['kd_siswa'] = $result->kd_siswa;
			for ($column=3; $column < $highestColumnIndex; $column++) { 
				$data['kd_pelajaran'] = $objWorksheet->getCellByColumnAndRow($column,5)->getValue();
				$data['nilai'] = $objWorksheet->getCellByColumnAndRow($column,$row)->getValue();
				// print_r($data);
				// echo '<br/>';
				// die();
				$this->nilai->process_create_nilai($data);
			}
			// die();
		}
		redirect('nilai/manageNilai/wali');
	}

	public function inputDatasiswaB4($file){
		$this->load->model('siswa');
		$this->load->model('user');
		$inputFileType = PHPExcel_IOFactory::identify($file);

		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($file);
		$objWorksheet = $objPHPExcel->getActiveSheet();
		$valid = true;

		$field = array(
					'',
					'No Ijazah',
					'NIS',
					'Nama',
					'Tempat lahir',
					'Tanggal Lahir',
					'Jenis Kelamin',
					'Tipe',
					'Status',
					'Tahun Masuk',
					'Tingkat',
					'Golongan Darah',
					'Agama',
					'Alamat',
					'Telepon',
					'Kewarganegaraan',
					'Nama Ayah',
					'Pendidikan Ayah',
					'Pekerjaan Ayah',
					'Nama Ibu',
					'Pendidikan Ibu',
					'Pekerjaan Ibu',
					'Alamat Orang Tua',
					'Telepon Orang Tua',
					'Tahun Lulus',
					'Asal Sekolah',
					'Alamat Sekolah Asal'
			);

		for ($i=1; $i <= 26; $i++) { 
			$valid = ($valid && ($objWorksheet->getCellByColumnAndRow($i, 3) == $field[$i]));
			if (!$valid){
				$missing = $objWorksheet->getCellByColumnAndRow($i, 3);
				break;
			}
		}
		if (!$valid){
			$data = array('error' => "File Excel Tidak Valid ! Tidak dijumpai field".$missing,'target' => 'data');
			$this->showHeader('');
			$this->load->view('upload/upload_form', $data);
			$this->load->view('footer_general');
			return 0;
		}

		$highestRow = $objWorksheet->getHighestRow(); // e.g. 10
		$highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5
		for ($row = 4; $row <= $highestRow; ++$row) {
			$data['no_ijazah'] 				= $objWorksheet->getCellByColumnAndRow(1, $row)->getValue() ;
			$user['user'] = $data['nis'] 	= $objWorksheet->getCellByColumnAndRow(2, $row)->getValue() ;
			$data['nama_siswa'] 			= $objWorksheet->getCellByColumnAndRow(3, $row)->getValue() ;
			$data['tmpt_lahir'] 			= $objWorksheet->getCellByColumnAndRow(4, $row)->getValue() ;
			$data['tgl_lahir'] 				= $this->konversiTanggal($objWorksheet->getCellByColumnAndRow(5, $row)->getValue()) ;
			$data['jns_kelamin']			= $this->konversiJekel($objWorksheet->getCellByColumnAndRow(6, $row)->getValue()) ;
			$data['tipe'] 					= $this->konversiTipe($objWorksheet->getCellByColumnAndRow(7, $row)->getValue()) ;
			$data['status'] 				= $this->konversiStatus($objWorksheet->getCellByColumnAndRow(8, $row)->getValue()) ;
			$data['tahun_masuk'] 			= $objWorksheet->getCellByColumnAndRow(9, $row)->getValue() ;
			$data['tingkat'] 				= $objWorksheet->getCellByColumnAndRow(10, $row)->getValue() ;
			$data['gol_darah']				= $objWorksheet->getCellByColumnAndRow(11, $row)->getValue() ;
			$data['agama'] 					= $objWorksheet->getCellByColumnAndRow(12, $row)->getValue() ;
			$data['alamat'] 				= $objWorksheet->getCellByColumnAndRow(13, $row)->getValue() ;
			$data['telp'] 					= $objWorksheet->getCellByColumnAndRow(14, $row)->getValue() ;
			$data['kewarganegaraan'] 		= $objWorksheet->getCellByColumnAndRow(15, $row)->getValue() ;
			$data['nama_ayah'] 				= $objWorksheet->getCellByColumnAndRow(16, $row)->getValue() ;
			$data['pendidikan_ayah'] 		= $objWorksheet->getCellByColumnAndRow(17, $row)->getValue() ;
			$data['pekerjaan_ayah'] 		= $objWorksheet->getCellByColumnAndRow(18, $row)->getValue() ;
			$data['nama_ibu'] 				= $objWorksheet->getCellByColumnAndRow(19, $row)->getValue() ;
			$data['pendidikan_ibu'] 		= $objWorksheet->getCellByColumnAndRow(20, $row)->getValue() ;
			$data['pekerjaan_ibu'] 			= $objWorksheet->getCellByColumnAndRow(21, $row)->getValue() ;
			$data['alamat_ortu'] 			= $objWorksheet->getCellByColumnAndRow(22, $row)->getValue() ;
			$data['telp_ortu'] 				= $objWorksheet->getCellByColumnAndRow(23, $row)->getValue() ;
			$data['tahun_lulus'] 			= $objWorksheet->getCellByColumnAndRow(24, $row)->getValue() ;
			$data['nama_sekolah'] 			= $objWorksheet->getCellByColumnAndRow(25, $row)->getValue() ;
			$data['alamat_sekolah'] 		= $objWorksheet->getCellByColumnAndRow(26, $row)->getValue() ;

			$user['pass']= sha1('123');
			$user['level'] = 5;

			$data = array_filter($data);

			$user['kd_transaksi'] = $this->siswa->process_create_siswa($data);
			$this->user->process_create_user($user);
			}
			redirect('siswas/managesiswa');

			// print_r($data);
			// echo "<br/><br/>";

			// for ($col = 2; $col <= $highestColumnIndex; ++$col) {
			// 	echo '<td>' . $objWorksheet->getCellByColumnAndRow($col, $row)->getValue() . 
			// 	'</td>' . "\n";
			// }
		
	}

	public function inputDatasiswa($file){
		$this->load->model('siswa');
		$this->load->model('user');
		$inputFileType = PHPExcel_IOFactory::identify($file);

		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load($file);
		$objWorksheet = $objPHPExcel->getActiveSheet();


		$highestRow = $objWorksheet->getHighestRow(); // e.g. 10
		$highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
		$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5


		for ($i=1; $i < $highestColumnIndex; $i++) { 
			$field[$i] = $objWorksheet->getCellByColumnAndRow($i, 16)->getValue();
		}
		$index = 0;
		for ($i=19; $i <= $highestRow; $i++) { 
			for ($j=1; $j < $highestColumnIndex; $j++) { 
				$data[$index][$field[$j]]= $objWorksheet->getCellByColumnAndRow($j, $i)->getValue();
			}
			$data[$index]['tgl_lahir'] = $this->konversiTanggal($data[$index]['tgl_lahir']);
			$data[$index]['jns_kelamin'] = $this->konversiJekel($data[$index]['jns_kelamin']);
			$data[$index]['status'] = $this->konversiStatus($data[$index]['status']);
			$data[$index]['tipe'] = $this->konversiTipe($data[$index]['tipe']);
			$index++;
		}

		$laporan = null;

		foreach ($data as $row) {
			$user['user'] = $row['nis'];
			$user['pass']= sha1('123');
			$user['level'] = 5;

			

			$credential = ($row['tahun_masuk'] != null and $row['tingkat'] != null and $row['status'] != null and $row['tingkat'] != null);

			$row2 = array_filter($row);
			if (!$this->siswa->cekSiswa($row['nis']) and !$this->user->cekUser($row['nis']) and $credential){

				if (!$user['kd_transaksi'] = $this->siswa->process_create_siswa($row2))
					$laporan[] = $row;	//kalo error input masukin ke laporan
				else if (!$this->user->process_create_user($user))	{
					$this->siswa->deleteSiswa($row['nis']); //kalo gagal bikin user, hapus siswa yang udah masuk, masukin ke laporan
					$laporan[] = $row;	//kalo error input masukin ke laporan
				}

			}
			else 
				$laporan[] = $row;
		}

		if ($laporan == null){
			$alert = "success";
			// echo '<script> alert("Data berhasil dimasukkan") </script>';
		} else {
			$alert = "fail";
			$this->laporanInput($field,$laporan);
			// echo '<script> alert("Ada data yang gagal dimasukkan, daftar data yang gagal otomatis terdownload") </script>'; 
			unlink($file);
			redirect('batchinput/do_upload/data/'.$alert);
		}
		redirect('batchinput/do_upload/data/'.$alert);
		unlink($file);

		
	}

	public function laporanInput($field,$laporan)
	{

		$path_template = realpath(FCPATH).'/assets/template_excel/templateInputDataSiswa.xls';
		$excel = new PHPExcel_Reader_Excel5();
		$objPHPExcel = $excel->load($path_template);
		$objWorksheet = $objPHPExcel->getActiveSheet();

		$row = 19;
		$highestColumnIndex = count($field)+1;
		for ($i=0; $i < count($laporan); $i++) { 
			$laporan[$i]['tgl_lahir'] = $this->reKonversiTanggal($laporan[$i]['tgl_lahir']);
			$laporan[$i]['jns_kelamin'] = $this->reKonversiJekel($laporan[$i]['jns_kelamin']);
			$laporan[$i]['status'] = $this->reKonversiStatus($laporan[$i]['status']);
			$laporan[$i]['tipe'] = $this->reKonversiTipe($laporan[$i]['tipe']);
			$objWorksheet->setCellValueByColumnAndRow(0,$row,$i+1);
			for ($j=1; $j < $highestColumnIndex; $j++) { 
				$objWorksheet->setCellValueByColumnAndRow($j,$row,$laporan[$i][$field[$j]]);
			}
			$row++;
		}
		$filename='DataBelumTerinput.xls'; //save our workbook as this file name
		// header('Content-Type: application/vnd.ms-excel'); //mime type
		// header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		// header('Cache-Control: max-age=0'); //no cache

		$objWriter = new PHPExcel_Writer_excel5($objPHPExcel);  
		$exportPlace = realpath(FCPATH).'/assets/downloadable/'.$filename;
		$objWriter->save($exportPlace);


	}



	public function coba()
	{
		$this->load->model('siswa');
		$this->load->model('wali');
		echo $this->wali->aaa;

	}

	 // public function showOutput($output=null){
  //       $this->showHeader('');
  //       $this->load->view('upload_form',$output);
  //       $this->load->view('footer_general');  
  //   }
}
