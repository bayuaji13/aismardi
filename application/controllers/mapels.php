<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Mapels extends CI_Controller {
 
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('grocery_CRUD');
        $this->load->model('mata_pelajaran');
    }

    public function index(){
        redirect('mapels/manageMapel');
    }

    public function seleksiMapel()
    {
        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('form');

        $data['non_jurusan'] = $this->mata_pelajaran->getMapelByJurusan(1,2016);
        $data['ipa'] = $this->mata_pelajaran->getMapelByJurusan(2,2016);
        $data['ips'] = $this->mata_pelajaran->getMapelByJurusan(3,2016);
        $data['mapel'] = $this->mata_pelajaran->getAllMapel();

        // echo in_array($data['ips'][1],$data['mapel']);
        // print_r($data);
        // die();

        $this->showHeader();
        $this->load->view('seleksi_mapel',$data);
        $this->load->view('footer_general');
    }

    public function setSeleksiMapel()
    {
        foreach ($_POST['non_jurusan'] as $row) {
            $this->mata_pelajaran->setMapelTahunan(1,$row);
        }

        foreach ($_POST['ipa'] as $row) {
            $this->mata_pelajaran->setMapelTahunan(2,$row);
        }

        foreach ($_POST['ips'] as $row) {
            $this->mata_pelajaran->setMapelTahunan(3,$row);
        }
        echo "<script>alert('Data berhasil dimasukkan')</script>";
        redirect('mapels/seleksiMapel');
    }

    public function manageMapel() {
        $crud = new grocery_CRUD();

        $crud->set_table('tabel_mapel')
            ->set_subject('Mata Pelajaran')
            ->required_fields('nama_mapel');

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