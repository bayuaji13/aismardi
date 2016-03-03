<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Jadwals extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('grocery_CRUD');
    }

    public function index(){
        redirect('jadwals/manageJadwal');
    }

    public function manageJadwal($mode = null) {
        $crud = new grocery_CRUD();

        $crud->set_table('jadwal')
            ->set_subject('Jadwal')
            ->display_as('tahun_ajaran', 'Tahun Ajaran')
            ->field_type('tahun_ajaran', 'hidden', $this->tahun_ajaran->getCurrentTA())
            ->columns('hari','jam','kd_pelajaran','kd_guru','kd_kelas')
            ->display_as('kd_kelas', 'Kelas')
            ->set_relation('kd_pelajaran','mata_pelajaran','nama_pelajaran')
            ->set_relation('hari','tabel_hari','nama_hari',null,'id_hari ASC')
            ->set_relation('kd_guru','guru','nama_guru')
            ->set_relation('kd_kelas','kelas','nama_kelas',array('tahun_ajaran' => $this->tahun_ajaran->getCurrentTA()))
            ->display_as('kd_pelajaran', 'Pelajaran')
            ->display_as('kd_guru', 'Guru Pengajar')
            ->required_fields('tahun_ajaran','hari','jam','kd_guru','kd_pelajaran','kd_kelas')
            ->where('jadwal.tahun_ajaran',$this->tahun_ajaran->getCurrentTA());

        //kalau bukan mode nampilin semua, edit di enable, tampilin cuma jadwal TA sekarang
         if ($this->session->userdata('level') != 9){
            $crud->unset_edit()
            ->unset_delete()
            ->unset_add();
        }

         if ($mode != null){
            switch ($mode) {
                case 'guru':
                    # code...
                    $crud->where('jadwal.kd_guru ',$this->session->userdata('kd_transaksi'));
                    break;
                case 'siswa':
                    # code...
                    $where = "jadwal.kd_kelas IN (SELECT kelas_siswa.kd_kelas FROM kelas_siswa WHERE kd_siswa=" . $this->session->userdata('kd_transaksi') . ")";
                    $crud->where($where);
                    break;                               
                default:
                    # code...
                    break;
            }
        }
    
        $output = $crud->render();
        $output->output ='<h3><i class="fa fa-angle-right"></i>Data Jadwal </h3> <br/>' . $output->output;
        $this->showOutput($output);

    }

    public function showOutput($output=null){
        $this->showHeader();  
        $this->load->view('crud/manage',$output);
        $this->load->view('footer_crud');  
    }
 
}