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
		$berita = $this->mberita->getBerita($kategori, $namaBerita);
		if ($kategori != "" && $namaBerita != ""){
			$this->load->model('mcategory');
			$data['pageTitle'] = $berita['newsTitle'];
			$data['judulBerita'] = $berita['newsTitle'];
			$data['kategori'] = $this->mcategory->getCategoryNameByPid($kategori);
			$data['kategoriPid'] = $kategori;
			$tanggal = new DateTime($berita['newsDate']);
			$tanggal = $tanggal->format('d M Y');
			$data['tanggal'] = $tanggal;
			$data['konten'] = $berita['newsContent'];
			$data['similarBerita'] = $this->mberita->getSimilarBerita($kategori, $berita['newsTitle']);
			$data['latestEvents'] = $this->mevent->getLatestEvents(3); 
			$this->load->template('berita', $data);
		}else if ($kategori != "" && $namaBerita == ""){
			
		}else {
			
		}
	}
}