<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Nilai extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model('nilai_m');
        $this->load->library('grocery_CRUD');
    }

    public function index(){
        redirect('nilai/manageNilai');
    }

    public function coba()
    {
        if ($this->nilai_m->cekNilai(1,2,2017,2))
            echo "ada";
        else
            echo "tak ada";
    }

    public function coba2()
    {
        // if ($this->nilai_m->cekNilaiField(2,2,2017,2,'nilai_mid'))
        //     echo "ada";
        // else
        //     echo "tak ada";
        print_r($this->nilai_m->cekNilaiField(1,8,2017,1,'nilai_uas'));
    }



    public function manageNilai($tipe = null) {        
        $crud = new grocery_CRUD();
         
        $crud->set_table('tabel_nilai')
            ->set_subject('Nilai')
            ->display_as('kd_pelajaran', 'Kode Pelajaran')
            ->display_as('kd_siswa', 'NIS')
            ->display_as('kd_kelas', 'Kelas')
            ->set_relation('kd_pelajaran','mata_pelajaran','nama_pelajaran')
            ->set_relation('kd_siswa','data_siswa','nis',array('status' => 1))
            ->set_relation('kd_kelas','kelas','nama_kelas',array('tahun_ajaran' => $this->tahun_ajaran->getCurrentTA()))
            ->field_type('nilai','hidden')
            ->required_fields('kd_pelajaran','kd_siswa', 'tahun_ajaran','kd_kelas','semester')
            ; 
        

        if ($tipe != null){
            switch ($tipe) {
                case 'guru':
                    # code...
                    $where = "tabel_nilai.kd_pelajaran IN (SELECT pengampu.kd_pelajaran FROM pengampu WHERE kd_guru=" . $this->session->userdata('kd_transaksi') . ")";
                    $crud->where($where);
                    break;
                case 'siswa':
                    # code...
                    // $where = "tabel_nilai.kd_pelajaran IN (SELECT pengampu.kd_pelajaran FROM pengampu WHERE kd_guru=" . $this->session->userdata('kd_transaksi') . ")";
                    $crud->where('tabel_nilai.kd_siswa',$this->session->userdata('kd_transaksi'));
                    break;                    
                case 'wali':
                    # code...
                    $where = "tabel_nilai.kd_kelas IN (SELECT kelas.kd_kelas FROM kelas WHERE kd_guru=" . $this->session->userdata('kd_transaksi') . ")";
                    $crud->where($where);
                    break;                    
                default:
                    # code...
                    break;
            }
        }

        if ($this->session->userdata('level') != 9){
            $crud->unset_edit()
            ->unset_delete()
            ->unset_add();
        }

        if ($this->session->userdata('filter_mapel')){
            $crud->where('tabel_nilai.kd_pelajaran',$this->session->userdata('filter_mapel'));
        }            
        if ($this->session->userdata('filter_kelas')){
            $crud->where('tabel_nilai.kd_kelas',$this->session->userdata('filter_kelas'));
        } 

        if ($this->session->userdata('filter_ta')){
            $crud->where('tabel_nilai.tahun_ajaran',$this->session->userdata('filter_ta'));
        }
        else if (!$this->session->userdata('filter_ta')){
            $crud->where('tabel_nilai.tahun_ajaran',$this->tahun_ajaran->getCurrentTA());
        }

        if ($this->session->userdata('filter_lulus')){
            $crud->set_model('nilai_model');
        } 
                  
        $this->session->set_userdata('uri_filter_nilai',$this->uri->uri_string());

        $output = $crud->render();
        $output->output ='<h3><i class="fa fa-angle-right"></i>Data Nilai</h3> <br/>' . $output->output;
        $this->showOutput($output);
    }


    public function filterNilai(){
        $data['mapel'] = $this->db->get('mata_pelajaran');
        $data['kelas'] = $this->db->get('kelas');
        $this->load->view('nilai/filter',$data);
    }

    public function processFilter(){
        $this->session->set_userdata('filter_mapel',$_POST['mapel']);
        $this->session->set_userdata('filter_kelas',$_POST['kelas']);
        $this->session->set_userdata('filter_lulus',$_POST['lulus']);
        // redirect('nilai/manageNilai');
        redirect($this->session->userdata('uri_filter_nilai'));

    }

    public function clearFilter(){
        $this->session->unset_userdata('filter_mapel');
        $this->session->unset_userdata('filter_kelas');
        $this->session->unset_userdata('filter_lulus');
        // redirect('nilai/manageNilai');
        redirect($this->session->userdata('uri_filter_nilai'));
    }

    public function showOutput($output=null){
        $this->showHeader();
        if ($this->uri->segment(3) === false)
            $this->filterNilai();
        $this->load->view('crud/manage',$output);
        $this->load->view('footer_crud');  
    }

    
}