<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class siswas extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('grocery_CRUD');
    }

    function index() {
        redirect('siswas/managesiswa');
    }

    public function managesiswa($tipe = null){
        // $this->tahun_ajaran->newTA();echo "allalala";die();
        //$ta = $this->tahun_ajaran->getCurrentTA();
        $data = [];
        $crud = new grocery_CRUD();

        $crud->set_table('tabel_siswa')
        ->columns('nis','nisn','nama_siswa','tahun_masuk','jurusan','status','tingkat','tahun_lulus')
        ->set_relation('tahun_masuk','tahun_ajaran','tahun_ajaran',null,'id_tahun_ajaran DESC LIMIT 3')
        ->set_relation('jurusan','tabel_jurusan','nama_jurusan')
        ->unset_fields('id_siswa')
        ->field_type('tahun_lulus','integer')
        //->field_type('tahun_masuk','integer')
        ->required_fields('nis','nama_siswa','status', 'jurusan','tahun_masuk')
        ->unique_fields('nis')
        // ->set_relation('jns_kelamin','tabel_jenkel','jenis_kelamin')
        // ->unset_texteditor('alamat','alamat_ortu','alamat_sekolah')
        ->callback_after_insert(array($this,'createUsersiswa'))
        ->callback_before_delete(array($this,'deleteUserSiswa'))
        ->field_type('status','dropdown',
            array('1' => 'Aktif', '2' => 'Tidak Aktif'));
        //tambahan untuk yang aktif maupun tidak aktif
        if (isset($this->session->userdata['all_siswa']))
            $crud->where('status','1');
        //buat yang yayasan
        if ($this->session->userdata['level'] == 3)
            $crud->where('status','1');
        
        // die($this->session->userdata('level'));
        if ($this->session->userdata('level') != 9){
            $crud->unset_edit()
            ->unset_delete()
            ->unset_add();
        }
   

//         if ($tipe == 'wali'){
//             $where = "data_siswa.kd_siswa IN (SELECT kelas_siswa.kd_siswa FROM kelas_siswa WHERE kelas_siswa.kd_kelas IN (SELECT kelas.kd_kelas FROM kelas WHERE kd_guru=" . $this->session->userdata('kd_transaksi') . ") AND kelas_siswa.tahun_ajaran =$ta)";
//             $crud->where($where);
//             $data['url'] = '<div class="tab-pane" id="chartjs">
//     <!-- page start-->
//     <div class="row mt">
//         <div class="col-lg-12">
//             <div class="content-panel"> 
//                 <div class="panel-body"><p><a href="'.base_url('batchoutput/exporterLeger/1').'">Klik di sini untuk download leger Semester 1</a></p>'.'<a href="'.base_url('batchoutput/exporterLeger/2').'">Klik di sini untuk download leger Semester 2</a>              </div>
//             </div>
//         </div>
//     </div>
// </div>';
//         }

        $output = $crud->render();

        $output->output ='<h3><i class="fa fa-angle-right"></i>Data Siswa </h3> <br/>' . $output->output;

        
        $this->showOutput($output, $data);

    }

    function showOutput($output = null, $data = null)
    {
        $this->showHeader();
        $this->load->view('blank_url', $data);  
        if ($this->session->userdata('level') == 9) {
            
        }
        $this->load->view('crud/manage',$output);    
        $this->load->view('footer_crud');     
    } 

    function createUsersiswa($post_array, $primary_key)
    {
        $credential = $this->db->insert_id();
        $data = array(
            'user' => $post_array['nis'],
            'level' => '4',
            'pass' => sha1('123'),
            'id_transaksi' => $credential
            );
        $this->db->insert('tabel_users',$data);
    }

    function deleteUserSiswa($primary_key)
    {
        $query = $this->db->query("SELECT nis FROM tabel_siswa WHERE id_siswa='$primary_key'");
        $hasil = $query->first_row();
        $user = $hasil->nis;
        $this->db->query("DELETE FROM tabel_users WHERE user='$user'");
    }
}