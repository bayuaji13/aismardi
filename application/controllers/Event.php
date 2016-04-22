<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Event extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('mevent');
	}
	
	public function index(){
		$this->load->model('mtautan');
		$this->load->model('mberita');
		$this->load->model('mmenu');
		$data['menu'] = $this->mmenu->getMenuView();
		$data['active'] = 'Event';
		$data['daftarTautan'] = $this->mtautan->getTautan();
		$data['latestNews'] = $this->mberita->getLatestBerita(4);
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
		$event = $this->mevent->getEvent($per_page, $page);
		if(!$event){
			$data['pageTitle'] = 'Event Tidak Ditemukan';
		}else{
			$this->load->library("pagination");
			$data['pageTitle'] = 'Daftar Event';
				
			$config["base_url"] = base_url("event");
			$config["total_rows"] = $this->mevent->countAllEvent();
			$this->pagination->initialize($config);
				
			$data["links"] = $this->pagination->create_links();
			$data['event'] = $event;
		}
		$this->load->template('event', $data);
	}
}