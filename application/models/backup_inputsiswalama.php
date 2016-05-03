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
			if (!$this->siswa->cekSiswa($data[$index]['nisn']) AND $tingkat_atas){
					$this->session->set_flashdata('notice','Siswa '.$data[$index]['nisn'].' - '.$data[$index]['nama'].' tidak ada dalam daftar');
					$alert = "fail";
					redirect('batchinput/do_upload/data/'.$alert);
			}
			if (!$this->siswa->cekSiswaDiKelas($data[$index]['nisn'])){
					$this->session->set_flashdata('notice','Siswa '.$data[$index]['nisn'].' - '.$data[$index]['nama'].' sudah terdaftar di kelas lain');
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