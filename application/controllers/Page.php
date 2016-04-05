<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Page extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('mpage');
	}
	
	public function index($pageName = ""){
		$this->load->model('mtautan');
		$this->load->model('mberita');
		$data['daftarTautan'] = $this->mtautan->getTautan();
		$data['latestNews'] = $this->mberita->getLatestBerita(4);
		if ($pageName != ""){
			$page = $this->mpage->getPage($pageName);
			if (!empty($page)){
				$data['pageTitle'] = $page['pageTitle'];
				$data['page'] = $page;
				$tanggal = new DateTime($page['pageDate']);
				$tanggal = $tanggal->format('d M Y');
				$data['tanggal'] = $tanggal;
			}else{
				$data['pageTitle'] = 'Laman Tidak Ditemukan';
			}
		}else {
			$data['pageTitle'] = 'Laman Tidak Ditemukan';
		}
		$this->load->template('page', $data);
	}
}