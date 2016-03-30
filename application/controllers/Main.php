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
		$data['sliders'] = $this->mslider->getSliders();
		$data['latestNews'] = $this->mberita->getLatestBerita();
		$data['sambutan'] = $this->msambutan->getSambutan();
		$data['pageTitle'] = "Beranda";
		$this->load->template('beranda', $data);
	}
}