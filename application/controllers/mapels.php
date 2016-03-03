<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Mapels extends CI_Controller {
 
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('grocery_CRUD');
 
    }

    public function index(){
        redirect('mapels/manageMapel');
    }

    public function manageMapel() {
        $crud = new grocery_CRUD();

        $crud->set_table('mata_pelajaran')
            ->set_subject('Mata Pelajaran')
            ->display_as('kd_pelajaran', 'Kode Pelajaran')
            ->display_as('kkm', 'Nilai Lulus Minimal')
            ->display_as('nama_pelajaran', 'Nama Pelajaran')
            ->display_as('kd_kategori','Kategori')
            ->set_relation('kd_kategori','tabel_kategori_mapel','nama')
            ->required_fields('nama_pelajaran','kd_kategori','kkm');

        if ($this->session->userdata('level') != 9){
            $crud->unset_edit()
            ->unset_delete()
            ->unset_add();
        }
            
        $output = $crud->render();
        $output->output ='<h3><i class="fa fa-angle-right"></i>Data Mata Pelajaran </h3> <br/>' . $output->output;

        $this->showOutput($output);
    }

    function showOutput($output=null){
        $this->showHeader();  
        $this->load->view('crud/manage',$output);
        $this->load->view('footer_crud');  
    }
    
 
}