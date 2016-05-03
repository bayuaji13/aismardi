<?php

class TahunAjaran extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->model('tahun_ajaran');
		$this->load->model('siswa');
		$this->load->model('nilai');
	}

	public function dataTambahan()
	{
		$this->showHeader();
		$this->load->view('tahun_ajaran/data_tambahan');
		$this->load->view('footer_general');
	}


	public function bukaSKHU()
	{
		$this->showHeader();
		$this->load->view('tahun_ajaran/set_buka_skhu');
		$this->load->view('footer_time');
	}



	public function prosesSetData()
	{
		$data['tahun_ajaran'] = $this->tahun_ajaran->getCurrentTA();
		$data['kepala_sekolah'] = $this->input->post('nama_kepsek');
		$data['nomor_peraturan'] = $this->input->post('nomor_peraturan');
		$data['tahun_peraturan'] = $this->input->post('tahun_peraturan');

		$this->db->where('id_tahun_ajaran',$data['tahun_ajaran']);
		$this->db->update('tahun_ajaran',$data);
		echo "<script>alert('data berhasil dimasukkan')</script>";
		redirect('tahunajaran/dataTambahan');
	}

	public function index()
	{
		// $tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
		// $data = $this->nilai->getCompletion($tahun_ajaran);
		// $data['tahun_ajaran'] = $tahun_ajaran;
		// // print_r($data);
		$this->showHeader();
		$this->load->view('tahun_ajaran_baru');
		$this->load->view('footer_general');
	}

	public function getTinggalKelas($tingkat)
	{
		$nisn = '%'.$this->input->get('search').'%';
		$query = $this->db->query("SELECT kd_siswa as value,nisn as text,nama_siswa FROM data_siswa WHERE status = '1' AND tingkat='$tingkat' AND nisn LIKE '$nisn'");
		$result = $query->result_array();
		for ($i=0; $i < sizeof($result); $i++) { 
			$result[$i]['text'] = $result[$i]['text'] .' - '.$result[$i]['nama_siswa'];
			$result[$i]['data_siswa'] = null;
		}

		// print_r($result);
		// die();
		$result = json_encode($result);
		print_r($result);
	}

	public function setTanggal()
	{
		$this->showHeader();
		$this->load->view('tahun_ajaran/set_tanggal');
		$this->load->view('footer_general');
	}

	public function prosesSetTanggal()
	{
		$data = $_POST;
		unset($data['Submit']);
		$this->tahun_ajaran->gantiTanggal($data);
		redirect('tahunajaran/setTanggal');
	}

	public function setTinggalKelas()
	{
		if ($this->session->userdata('level') != 9)
			redirect('users/login');
		$data = $this->input->post('daftar');
		// print_r($data);

		if ($data != null){
			foreach ($data as $id) {
				$this->tahun_ajaran->tinggalKelas($id);
			}
		}
		$this->index();
	}

	public function confirmTABaru()
	{
		if ($this->session->userdata('level') != 9)
			redirect('users/login');
		// $this->tahun_ajaran->newTA(); //MUTED
		$this->tidakLulus();
	}

	public function tidakLulus()
	{
		if ($this->session->userdata('level') != 9)
			redirect('users/login');
		$this->showHeader('');
		$this->load->view('tahun_ajaran/tidak_lulus');
		$this->load->view('footer_form');
	}

	public function tahunAjaranBaru()
	{
		if ($this->session->userdata('level') != 9)
			redirect('users/login');
		$this->showHeader('');
		$this->load->view('tahun_ajaran_baru');
		$this->load->view('footer_general');
	}

	public function prosesSetTanggalSKHU()
	 {
	 	$tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
	 	$this->db->where('id_tahun_ajaran',$tahun_ajaran);
	 	$data['buka_skhu'] = $this->input->post('waktu_skhu');
	 	$this->db->update('tahun_ajaran',$data);
	 	redirect('users/home');
	 } 

}