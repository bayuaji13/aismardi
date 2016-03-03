<?php
if (! defined('BASEPATH')) exit('No direct script access allowed');
class Users extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('security');
        $this->load->model('user');
        $this->load->database();
    }
    
    public function index(){
        redirect('users/login');
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
                redirect(base_url().'users/view_users');
            }
        }
        $this->load->view('users/login',$data);
    }
    public function view_users() {
		$data['query'] = $this->user->get_all_users();
		$this->load->view('header');
		$this->load->view('users/view_all_users', $data);
		$this->load->view('footer_general');

	}

    public function delete_user() {
// Load support assets
            $this->load->library('form_validation');
            $this->form_validation->set_error_delimiters('', '<br />');
// Set validation rules
            $this->form_validation->set_rules('user', 'User',
                    'required|min_length[1]|max_length[20]');
            if ($this->input->post()) {
                    $user = $this->input->post('user');
            } else {
                    $user = $this->uri->segment(3);
            }
            if ($this->form_validation->run() == FALSE) {
                    // First load, or problem with form
                    $data['query'] = $this->user->get_user_details($user);
                    $this->load->view('header');
                    $this->load->view('users/delete_user', $data);
                    $this->load->view('footer_general');
            } else {
                    if ($this->user->delete_user($user)) {
                            redirect('users/view_users');
                    }
            }
    }
    
    function new_user(){
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('','<br/>');

        //validation rule
        $this->form_validation->set_rules('user','User','required|minlength[1]|maxlength[80]|is_unique[users.user]');
        $this->form_validation->set_rules('pass','Nama','required|minlength[5]|maxlength[15]');
        $this->form_validation->set_rules('level', 'Level','required');

        //Begin validation 
        if ($this->form_validation->run()==FALSE) {
                //1st run atau ada error
                $data['user'] = array(
                        'name' => 'user',
                        'id' => 'user',
                        'value' => set_value('user',''),
                        'maxlength' => '20',
                        'size' => '35'
                );
                $data['pass'] = array(
                        'name' => 'pass',
                        'id' => 'pass',
                        'value' => set_value('pass',''),
                        'maxlength' => '30',
                        'size' => '35'
                );
                $data['level'] = array(
                0 => 'Admin',
                1 => 'Kepala Sekolah',
                2 => 'Yayasan',
                3 => 'Guru',
                4 => 'Wali Kelas',
                5 => 'Siswa',
                );
                $this->load->view('header');
                $this->load->view('users/new_user',$data);
                $this->load->view('footer_form');
        } else {
                //validasi sukses
                $hash = sha1($this->input->post('pass'));
                $data = array(
                        'user' => $this->input->post('user'),
                        'level' => $this->input->post('level'),
                        'pass' => $hash
                );
                if ($this->user->process_create_user($data)){
                        redirect('users/view_users');
                }
        }
    }
    function edit_user(){
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('','<br/>');

        //validation rule
        $this->form_validation->set_rules('user','User','required|minlength[1]|maxlength[80]|is_unique[users.user]');
        $this->form_validation->set_rules('pass','Nama','required|minlength[5]|maxlength[15]');
        $this->form_validation->set_rules('level', 'Level','required');
        
        if ($this->input->post()) {
            $user = $this->input->post('init_user');
        } else {
            $user = $this->uri->segment(3); 
        }

        //Begin validation 
        if ($this->form_validation->run()==FALSE) {
            $query = $this->user->get_user_details($user);
            foreach ($query->result() as $row) {
                $user = $row->user;
                $data['selectedLevel'] = $row->level;                
            }
            //1st run atau ada error
            $data['init_user'] = $user;
            $data['user'] = array(
                    'name' => 'user',
                    'id' => 'user',
                    'value' => set_value('user',$user),
                    'maxlength' => '20',
                    'size' => '35'
            );
            $data['pass'] = array(
                    'name' => 'pass',
                    'id' => 'pass',
                    'value' => set_value('pass',''),
                    'maxlength' => '30',
                    'size' => '35'
            );
            $data['level'] = array(
            0 => 'Admin',
            1 => 'Kepala Sekolah',
            2 => 'Yayasan',
            3 => 'Guru',
            4 => 'Wali Kelas',
            5 => 'Siswa',
            );
            $this->load->view('header');
            $this->load->view('users/edit_user',$data);
            $this->load->view('footer_form');
        } else {
            //validasi sukses
            $hash = sha1($this->input->post('pass'));
            $data = array(
                    'user' => $this->input->post('user'),
                    'level' => $this->input->post('level'),
                    'pass' => $hash
            );
            if ($this->user->process_update_user($user,$data)){
                    redirect('users/view_users');
            }
        }

        
    }    

}
    