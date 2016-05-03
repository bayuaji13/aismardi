<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Mapels extends CI_Controller {
 
    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('grocery_CRUD');
        $this->load->model('mata_pelajaran');
        $this->load->model('tahun_ajaran');
    }

    public function index(){
        redirect('mapels/manageMapel');
    }

    public function seleksiMapel()
    {
        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('form');

        $tahun_ajaran = $this->tahun_ajaran->getCurrentTA();

        $data['non_jurusan'] = $this->mata_pelajaran->getMapelByJurusan(1,$tahun_ajaran);
        $data['ipa'] = $this->mata_pelajaran->getMapelByJurusan(2,$tahun_ajaran);
        $data['ips'] = $this->mata_pelajaran->getMapelByJurusan(3,$tahun_ajaran);
        $data['mapel'] = $this->mata_pelajaran->getAllMapel();

        // echo in_array($data['ips'][1],$data['mapel']);

        $this->showHeader();
        $this->load->view('seleksi_mapel',$data);
        $this->load->view('footer_general');
    }

    public function seleksiMapelUN()
    {
        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('form');

        $tahun_ajaran = $this->tahun_ajaran->getCurrentTA();

        $data['ipa'] = $this->mata_pelajaran->getMapelUNByJurusan(2,$tahun_ajaran);
        $data['ips'] = $this->mata_pelajaran->getMapelUNByJurusan(3,$tahun_ajaran);
        $data['mapel'] = $this->mata_pelajaran->getAllMapel();

        // echo in_array($data['ips'][1],$data['mapel']);

        $this->showHeader();
        $this->load->view('seleksi_mapel_un',$data);
        $this->load->view('footer_general');
    }

    public function setSeleksiMapel()
    {
        $ta = $this->tahun_ajaran->getCurrentTA();
        $query = $this->db->query("DELETE FROM tabel_mapel_jurusan WHERE tahun_ajaran='$ta'");
        if (isset($_POST['non_jurusan']))
            foreach ($_POST['non_jurusan'] as $row) {
                $this->mata_pelajaran->setMapelTahunan(1,$row);
            }

        if (isset($_POST['ipa']))
            foreach ($_POST['ipa'] as $row) {
                $this->mata_pelajaran->setMapelTahunan(2,$row);
            }

        if (isset($_POST['ips']))
            foreach ($_POST['ips'] as $row) {
                $this->mata_pelajaran->setMapelTahunan(3,$row);
            }
        echo "<script>alert('Data berhasil dimasukkan')</script>";
        redirect('mapels/seleksiMapel');
    }
    
    public function setSeleksiMapelUN()
    {
        $ta = $this->tahun_ajaran->getCurrentTA();
        $query = $this->db->query("DELETE FROM tabel_mapel_un WHERE tahun_ajaran='$ta' AND (id_jurusan='2' OR id_jurusan='3')");

        if (isset($_POST['ipa']))
            foreach ($_POST['ipa'] as $row) {
                $this->mata_pelajaran->setMapelUN(2,$row);
            }

        if (isset($_POST['ips']))
            foreach ($_POST['ips'] as $row) {
                $this->mata_pelajaran->setMapelUN(3,$row);
            }
        echo "<script>alert('Data berhasil dimasukkan')</script>";
        redirect('mapels/seleksiMapelUN');
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