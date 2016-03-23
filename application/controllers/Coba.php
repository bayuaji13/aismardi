<?php

class Coba extends CI_Controller {
	
	public function index()
	{
		$this->load->database();
        $this->load->helper('url');
        $this->load->helper('form');
		$this->load->model('mata_pelajaran');
		$query = $this->mata_pelajaran->GetMapelByJurusan(2,2016);
		// print_r($query->result_array());
		$this->showHeader();
		$this->load->view('seleksi_mapel');
		$this->load->view('footer_general');
	}
}