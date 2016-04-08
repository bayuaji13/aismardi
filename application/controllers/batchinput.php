<?php

class BatchInput extends CI_Controller {
	

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('excel');
		$this->load->model('siswa');
		$this->load->model('kelas');
		$this->load->model('pengampu_m');
	}

	// function index() {
	// 	redirect('BatchInput/do_upload');
	// }

	// function index() {
	// 	redirect('BatchInput/do_upload');
	// }

	function do_upload($target,$alert = null,$notice = null)
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
				$data['url'] = '<a href="'.base_url('assets/template_excel/TemplateUploadDataSiswa.xls').'">Klik di sini untuk download template pengisian data siswa </a>';
				$data['alert'] = $alert;
				$data['notice'] = $notice;
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

	
	public function inputDatasiswa($file){
		$laporan = null;
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

		$nama_kelas = $objWorksheet->getCellByColumnAndRow(2,8)->getValue();
		$tingkat = $objWorksheet->getCellByColumnAndRow(2,9)->getValue();
		$nip = $objWorksheet->getCellByColumnAndRow(2,11)->getValue();
		$penjurusan = $objWorksheet->getCellByColumnAndRow(2,12)->getValue();

		echo "nama kelas : ".$nama_kelas;
		echo "<br/>tingkat : ".$tingkat;
		echo "<br/>nip : ".$nip;
		echo "<br/>penjurusan : ".$penjurusan;

		if ($this->kelas->cekKelas($nama_kelas)){
			$this->session->set_flashdata('notice','Nama kelas sudah terdaftar');
			$alert = "fail";
			redirect('batchinput/do_upload/data/'.$alert);
		}
		if (!$this->pengampu_m->cekGuru($nip)){
			$this->session->set_flashdata('notice','NIP Guru tidak ada dalam daftar');
			$alert = "fail";
			redirect('batchinput/do_upload/data/'.$alert);
		}

		$index = 0;
		$tingkat_atas = ($tingkat == 2 OR $tingkat == 3);

		for ($i=0; $i < $highestColumnIndex; $i++) { 
			$field[$i] = $objWorksheet->getCellByColumnAndRow($i, 15)->getValue();
		}
		for ($i=17; $i <= $highestRow; $i++) { 
			for ($j=0; $j < $highestColumnIndex; $j++) { 
				$data[$index][$field[$j]]= $objWorksheet->getCellByColumnAndRow($j, $i)->getValue();
			}
			if (!$this->siswa->cekSiswa($data[$index]['nis']) AND $tingkat_atas){
					$this->session->set_flashdata('notice','Siswa '.$data[$index]['nis'].' - '.$data[$index]['nama'].' tidak ada dalam daftar');
					$alert = "fail";
					redirect('batchinput/do_upload/data/'.$alert);
			}
			if (!$this->siswa->cekSiswaDiKelas($data[$index]['nis'])){
					$this->session->set_flashdata('notice','Siswa '.$data[$index]['nis'].' - '.$data[$index]['nama'].' sudah terdaftar di kelas lain');
					$alert = "fail";
					redirect('batchinput/do_upload/data/'.$alert);
			}
			$index++;
		}


		if ($tingkat_atas){
			$validasi_penjurusan = ($penjurusan = 'IPA' OR $penjurusan == 'IPS');
			if (!$validasi_penjurusan){
				$laporan = $data;
			} else {
				$this->entryKelasSiswa($nip,$nama_kelas,$tingkat,$data,$penjurusan);
			}

		} else {
			$this->entryDataSiswa($data);
			$this->entryKelasSiswa($nip,$nama_kelas,$tingkat,$data);
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

	public function entryDataSiswa($data)
	{
		$laporan = [];
		foreach ($data as $row) {
			$row['tahun_masuk'] = $this->tahun_ajaran->getCurrentTA();
			$row['status'] = 1;
			$row['tingkat'] = 0;


			if ($row['tgl_kls'] == null OR strtolower($row['tgl_kls']) != 'ya'){
				unset($row['tgl_kls']);
				if (!$user['id_transaksi'] = $this->siswa->process_create_siswa($row))
					$laporan[] = $row;
				else {
					$user['user'] = $row['nis'];
					$user['pass'] = sha1('123');
					$user['level'] = 4;
					$this->user->process_create_user($user);
				}
			}
		}
	}
	

	public function konversiJurusan($jurusan)
	{
		$jurusan = strtolower($jurusan);
		if ($jurusan == 'ipa' OR $jurusan == 'ilmu pengetahuan alam')
			return 2;
		else if ($jurusan == 'ips' OR $jurusan == 'ilmu pengetahuan sosial')
			return 3;
		else
			return 1;
	}

	public function entryKelasSiswa($nip,$nama_kelas,$tingkat,$data,$penjurusan = null){
		$tahun_ajaran = $entry_kelas['tahun_ajaran'] = $this->tahun_ajaran->getCurrentTA();
		$entry_kelas['id_guru']= $this->pengampu_m->nip2id_guru($nip);
		$entry_kelas['nama_kelas'] = $nama_kelas;
		$entry_kelas['jurusan'] = $this->konversiJurusan($penjurusan);
		$entry_kelas['tingkat'] = $tingkat;

		$id_kelas = $this->kelas->process_create_kelas($entry_kelas);

		foreach ($data as $row) {
			$row['tahun_ajaran'] = $tahun_ajaran;
			$row['id_siswa'] = $this->siswa->nis2id_siswa($row['nis']);
			$row['id_kelas'] = $id_kelas;

			unset($row['nis']);
			unset($row['nama']);

			if ($row['tgl_kls'] == null){
				$this->kelas->naik_kelas($row['id_siswa']);
			}
			unset($row['tgl_kls']);
			print_r($row);

			$this->kelas->process_isi_kelas($row);
		}
	}

	public function laporanInput($field,$laporan)
	{

		$path_template = realpath(FCPATH).'/assets/template_excel/TemplateUploadDataSiswa.xls';
		$excel = new PHPExcel_Reader_Excel5();
		$objPHPExcel = $excel->load($path_template);
		$objWorksheet = $objPHPExcel->getActiveSheet();

		$row = 19;
		$highestColumnIndex = count($field)+1;
		for ($i=0; $i < count($laporan); $i++) { 
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
		$test = '122';
		if ($hasil = $this->pengampu_m->cekGuru($test)){
			echo "sudah";
		} else
			echo "belum";

		print_r($hasil);

	}

	 // public function showOutput($output=null){
  //       $this->showHeader('');
  //       $this->load->view('upload_form',$output);
  //       $this->load->view('footer_general');  
  //   }
}
