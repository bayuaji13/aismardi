<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->library('grocery_CRUD');
		$this->load->model('user');
	}

	public function index(){
		if ($this->getSession())
			redirect('users/home');
		else
			redirect('users/login');
		// echo $this->session->userdata('user') . $this->session->userdata('level');
		// echo ($this->session->userdata('user') != null) && ($this->session->userdata('level') != null);
		// die();
	}

	public function manageUser(){

		$crud = new grocery_CRUD();

		$crud->set_table('tabel_users')
		->set_subject('User')
		->field_type('pass','password')
		->display_as('pass','Password')
		->required_fields('user','pass')
		->unique_fields('user')
		->set_relation('level','tabel_level','jenis_user')
		->columns('user','pass')
		->unset_add_fields('kd_transaksi')
		->unset_edit_fields('kd_transaksi','level')
		->callback_edit_field('pass',array($this,'edit_field_callback'));
		;

		if ($this->session->userdata('level') != 9){
			$crud->unset_edit()
			->unset_delete();
		}


		$crud->callback_before_update(array($this,'encryptPasswordCallback'))
		->callback_before_insert(array($this,'encryptPasswordCallback'));

		$output = $crud->render();
		$output->output ='<h3><i class="fa fa-angle-right"></i>Data Pengguna </h3> <br/>' . $output->output;
		$this->showOutput($output);
	}

	function edit_field_callback($value, $primary_key)
	{
	    return '<input id="field-pass" class="form-control" name="pass" type="password" value="" maxlength="80">';
	}

	function showOutput($output = null)
	{
			$this->showHeader();
	        $this->load->view('crud/manage',$output);    
	        $this->load->view('footer_crud');
	} 

	function encryptPasswordCallback($post_array, $primary_key) {
	 
	    //Encrypt password only if is not empty. Else don't change the password to an empty field
	    if(!empty($post_array['pass']))
	    {
	        $post_array['pass'] = sha1($post_array['pass']);
	    }
	    else
	    {
	        unset($post_array['pass']);
	    }
	 
	  return $post_array;
	}
    
    public function login(){
        $data['error']=0;
        if ($_POST){
            $username=$this->input->post('user');
            $password=$this->input->post('pass');
            $user=$this->user->login($username,$password);
            if (!$user){
                $data['error']=1;
            }else{
                $this->session->set_userdata('user',$user['user']);
                $this->session->set_userdata('level',$user['level']);
                $this->session->set_userdata('kd_transaksi',$user['kd_transaksi']);
                $this->session->set_userdata('nama_akun',$this->nama_akun($user['kd_transaksi']));
                redirect('users/home');
            }
        }
        $this->load->view('users/login',$data);

    }

    public function home(){
    	if (!$this->getSession())
    		redirect('users/login');
    	$data['user'] =  $this->session->userdata('user');
    	$data['level'] = $this->session->userdata('level');
    	$this->showHeader();
        $this->load->view('welcome_message',$data);
        $this->load->view('footer_general');
    }

    public function logout(){
    	$this->session->sess_destroy();
    	redirect('users');
    }

    public function nama_akun(){
    	$kode = $this->session->userdata('kd_transaksi');
    	if ($this->session->userdata['level'] == 5)	{
    		$query = $this->db->query("SELECT nama_siswa as nama FROM data_siswa WHERE kd_siswa = '$kode' ");
    		$result = $query->first_row();
    	    return $result->nama;
    	    
    	}
    	else if ($this->session->userdata['level'] == 4 or $this->session->userdata['level'] == 1){
    		$query = $this->db->query("SELECT nama_guru as nama FROM guru WHERE kd_guru = '$kode' ");
    		$result = $query->first_row();
    	    return $result->nama;
    	}

    	
    }

    public function ubahPassword($flag = null)
	{	

		$this->load->library('form_validation');
		$this->form_validation->set_error_delimiters('', '<br />');

		//set aturan validasi

		$this->form_validation
		->set_rules('password_lama','Password','required|min_length[1]|max_length[40]')
		->set_rules('password','Password','required|min_length[1]|max_length[40]|matches[password_conf]')
		->set_rules('password_conf','Konfirmasi Password','required|min_length[1]|max_length[40]')
		;

		$id= $this->session->userdata('id_account');


		if ($this->form_validation->run() == FALSE) {
			$data['password_lama'] = array(
									'name' => 'password_lama', 
									'id' => 'password_lama',
									'value' => set_value('password',''),
									'maxlength'=> '40',
									'size' => '20'
								);

			$data['password_conf'] = array(
									'name' => 'password_conf', 
									'id' => 'password_conf',
									'value' => set_value('password_conf',''),
									'maxlength'=> '40',
									'size' => '20'
									);
			$data['password'] = array(
									'name' => 'password', 
									'id' => 'password',
									'value' => set_value('password',''),
									'maxlength'=> '40',
									'size' => '20'
								);

			$this->showHeader();
			$this->load->view('users/ubahakunpribadi',$data);
			$this->load->view('footer_form');
		} else {
			$password = $this->input->post('password');
			$password_lama = sha1($this->input->post('password_lama'));
			if ($password_lama != $this->user->getPassword($this->session->userdata('user'))){
				$data['password_lama'] = array(
										'name' => 'password_lama', 
										'id' => 'password_lama',
										'value' => set_value('password_lama',''),
										'maxlength'=> '40',
										'size' => '20'
									);
				$data['password_conf'] = array(
										'name' => 'password_conf', 
										'id' => 'password_conf',
										'value' => set_value('password_conf',''),
										'maxlength'=> '40',
										'size' => '20'
									);
				$data['password'] = array(
										'name' => 'password', 
										'id' => 'password',
										'value' => set_value('password',''),
										'maxlength'=> '40',
										'size' => '20'
									);
				$data['error'] = "Password tidak cocok dengan password lama";
				$this->showHeader();
				$this->load->view('users/ubahakunpribadi',$data);
				$this->load->view('footer_form');
				return 0;
			}
			$this->user->setPassword($this->session->userdata('user'),sha1($password));
			$this->showHeader();
			$this->load->view('users/successEdited');
			$this->load->view('footer_form');			
		}

	}

	public function dummy()
	{
		echo $this->user->getPassword($this->session->userdata('user'));
	}

}