<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Galeri extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('mgaleri');
	}
	
	public function index(){
		$this->load->model('mtautan');		
		$data['daftarTautan'] = $this->mtautan->getTautan();
		
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
		
		$page = $this->input->get('per_page');
		$galeri = $this->mgaleri->getGaleri($per_page, $page);
		if(!$galeri){
			$data['pageTitle'] = 'Galeri';
			$data['title'] = 'Tidak Ada Konten Dalam Galeri';
		}else{
			$this->load->library("pagination");
			$data['pageTitle'] = 'Galeri';
			$data['title'] = 'Galeri';
				
			$config["base_url"] = base_url("galeri");
			$config["total_rows"] = $this->mgaleri->countAllGaleri();
			$this->pagination->initialize($config);
				
			$data["links"] = $this->pagination->create_links();
			$data['galeri'] = $galeri;
		}
		$this->load->template('galeri', $data);
	}
}