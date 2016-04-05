<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Berita extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('mberita');
	}
	
	public function index($kategori = "", $namaBerita = ""){
		$this->load->model('mtautan');
		$this->load->model('mevent');
		$data['daftarTautan'] = $this->mtautan->getTautan();
		$data['latestEvents'] = $this->mevent->getLatestEvents(3);
		$per_page = 6;
		$config["per_page"] = $per_page;
		$config['page_query_string'] = TRUE;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['next_link'] = "&raquo;";
		$config['prev_link'] = "&laquo;";
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="active"><a href="#">';
		$config['cur_tag_close'] = '</a></li">';
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li">';
		
		if ($kategori != "" && $namaBerita == ""){
			$page = $this->input->get('per_page');
			$berita = $this->mberita->getBerita($kategori, "", $per_page, $page);
			if(!$berita){
				$data['pageTitle'] = 'Berita Tidak Ditemukan';
			}else{
				$this->load->library("pagination");
				$data['kategori'] = $this->mcategory->getCategoryNameByPid($kategori);
				$data['kategoriPid'] = $kategori;
				$data['pageTitle'] = 'Daftar Berita '. $data['kategori'];
			
				$config["base_url"] = base_url("berita/".$kategori);
				$config["total_rows"] = $this->mberita->countAllBerita($kategori);
				$this->pagination->initialize($config);
					
				$data["links"] = $this->pagination->create_links();
				$data['berita'] = $berita;
			}
			$this->load->template('daftar_berita', $data);
		}else if ($kategori != "" && $namaBerita != ""){
			$berita = $this->mberita->getBerita($kategori, $namaBerita);
			$data['similarBerita'] = $this->mberita->getSimilarBerita($kategori, $berita['newsTitle']);
			if (empty($berita)){
				$data['berita'] = $berita;
				$data['pageTitle'] = "Berita Tidak Ditemukan";
				$data['judulBerita'] = "Berita Tidak Ditemukan";
			}else {
				$data['berita'] = $berita;
				$this->load->model('mcategory');
				$data['pageTitle'] = $berita['newsTitle'];
				$data['judulBerita'] = $berita['newsTitle'];
				$data['kategori'] = $this->mcategory->getCategoryNameByPid($kategori);
				$data['kategoriPid'] = $kategori;
				$tanggal = new DateTime($berita['newsDate']);
				$tanggal = $tanggal->format('d M Y');
				$data['tanggal'] = $tanggal;
				$data['konten'] = $berita['newsContent'];
			}
			$this->load->template('berita', $data);
		}else {
			$page = $this->input->get('per_page');
			$berita = $this->mberita->getBerita("", "", $per_page, $page);
			if(!$berita){
				$data['pageTitle'] = 'Berita Tidak Ditemukan';
			}else{
				$this->load->library("pagination");
				$data['pageTitle'] = 'Daftar Semua Berita ';
					
				$config["base_url"] = base_url("berita/");
				$config["total_rows"] = $this->mberita->countAllBerita();
				$this->pagination->initialize($config);
					
				$data["links"] = $this->pagination->create_links();
				$data['berita'] = $berita;
			}
			$this->load->template('daftar_berita', $data);
		}
	}
}