<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Menuajax extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->database();	
	}
	
	public function getMenuAjax(){
		$this->load->model('mmenu');
		$result = $this->mmenu->getMenu();
		
		echo json_encode($result);
	}
	
	public function saveMenuAjax() {
		$this->load->model('mmenu');
		$result = $this->mmenu->updateMenu();
		
		echo ($result);
	}
}