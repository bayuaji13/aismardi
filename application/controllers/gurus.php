<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Gurus extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('grocery_CRUD');
	}

	public function index(){
		redirect('gurus/manageGuru');
	}


	public function manageGuru(){

		$crud = new grocery_CRUD();

		$crud->set_table('tabel_guru')
		->unique_fields('nip')
		->unset_fields('id_guru')
		->callback_after_insert(array($this,'createUserGuru'))
		->callback_before_delete(array($this,'deleteUserGuru'))
		;

		if ($this->session->userdata('level') != 9){
			$crud->unset_edit()
			->unset_delete()
			->unset_add();
		}



		$crud->required_fields('nip','nama');
		$output = $crud->render();

		$output->output ='<h3><i class="fa fa-angle-right"></i>Data Guru </h3> <br/>' . $output->output;

		$this->showOutput($output);
	}



	function showOutput($output = null)
    {
    	$this->showHeader();
        $this->load->view('crud/manage',$output);    
        $this->load->view('footer_crud');   
    } 

    function createUserGuru($post_array, $primary_key)
    {
    	// $this->load->model('user');
    	$credential = $this->db->insert_id();
    	$data = array(
                        'user' => $post_array['nip'],
                        'level' => '1',
                        'pass' => sha1($post_array['nip']),
                        'id_transaksi' => $credential
            	);
    	// $this->user->process_create_user($data);
    	$this->db->insert('tabel_users',$data);
    }

    function deleteUserGuru($primary_key)
    {
    	$query = $this->db->query("SELECT nip FROM tabel_guru WHERE id_guru='$primary_key'");
    	$hasil = $query->first_row();
        $user = $hasil->nip;
        $this->db->query("DELETE FROM tabel_users WHERE user='$user'");
    }
}