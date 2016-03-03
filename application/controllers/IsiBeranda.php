<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
	class IsiBeranda extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('grocery_CRUD');
    }

   	public function showProfil ($output = null){
   		// $crud = new grocery_CRUD();
   		// $output = $crud->render();
   		$this->showHeader();
   		// $this->load->view('crud/manage',$output); 
   		$this->load->view('profil');
        $this->load->view('footer_general');  
   	}

   	public function showTentang (){
   		$this->showHeader();
   		$this->load->view('tentang');
   		$this->load->view('footer_general');
   	}

   	public function showBantuan (){
   		$this->showHeader();
   		$this->load->view('bantuan');
   		 $this->load->view('footer_general');
   	}
}
