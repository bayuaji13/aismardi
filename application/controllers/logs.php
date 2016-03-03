<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Logs extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('grocery_CRUD');
	}

	public function index(){
		redirect('logs/showLog');
	}

	public function showLog(){

		if ($this->session->userdata['level'] != 9){
			redirect('users/home');
		}

		$crud = new grocery_CRUD();

		$crud->set_table('statistik')
		->display_as('when','waktu')
		->display_as('uri','URL')
		->unset_edit()
		->unset_add()
		->unset_delete()
		->order_by('when','desc')

		;

		$output = $crud->render();
		$output->output ='<h3><i class="fa fa-angle-right"></i>Log Sistem </h3> <br/>' . $output->output;
		$this->showOutput($output);
	}

	function showOutput($output = null)
    {
    	$this->showHeader();
        $this->load->view('crud/manage',$output);    
        $this->load->view('footer_crud');   
    } 
}