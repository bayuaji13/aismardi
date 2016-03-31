<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Main extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
	}
	
	public function index() {
		$this->load->model('mslider');
		$this->load->model('mberita');
		$this->load->model('msambutan');
		$this->load->model('mevent');
		$this->load->model('mtautan');
		$this->load->model('mtestimoni');
		$data['sliders'] = $this->mslider->getSliders();
		$data['latestNews'] = $this->mberita->getLatestBerita();
		$data['sambutan'] = $this->msambutan->getSambutan();
		$data['latestEvents'] = $this->mevent->getLatestEvents();
		$data['daftarTautan'] = $this->mtautan->getTautan();
		$data['daftarTestimoni'] = $this->mtestimoni->getTestimoni();
		$data['pageTitle'] = "Beranda";
		$this->load->template('beranda', $data);
	}
}