<?php
class Kelas extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('grocery_CRUD');
        

    }

     public function index(){
        redirect('kelas/manageKelas');
    }

    public function manageKelas($mode = null) {
        $ta = $this->tahun_ajaran->getCurrentTA();
        $crud = new grocery_CRUD();

        $crud->set_table('tabel_kelas')
        ->set_relation('id_guru','tabel_guru','nama')
        ->set_relation('jurusan','tabel_jurusan','nama_jurusan')
        ->display_as('id_guru','Wali Kelas')
        ->field_type('tahun_ajaran', 'hidden', $this->tahun_ajaran->getCurrentTA())
        ->set_relation_n_n('Isi','tabel_kelas_siswa','tabel_siswa','id_kelas','id_siswa','nisn',null,"id_siswa NOT IN (SELECT id_siswa FROM tabel_kelas_siswa WHERE tahun_ajaran=$ta) AND id_siswa NOT IN (SELECT id_siswa FROM tabel_siswa WHERE status = '2')",true)
        // ->callback_after_update(array($this,'createUserWali'))
        ->required_fields('tahun_ajaran','id_guru','nama_kelas','tingkat')
        ->order_by('tahun_ajaran','desc')
        ->where('tahun_ajaran',$this->tahun_ajaran->getCurrentTA())
        ->unset_add();
        ;

        //kalau bukan mode nampilin semua, edit di enable, tampilin cuma kelas TA sekarang
        if ($mode == null){
            $crud->where('tahun_ajaran',$this->tahun_ajaran->getCurrentTA());
        }
        else if ($mode == 'all_kelas'){ //pas mode nampilin semua, unset edit
            $crud->unset_edit();
        }
        if ($this->session->userdata('level') != 9){
            $crud->unset_edit()
            ->unset_delete()
            ->unset_add();
        }
            
        $output = $crud->render();
        $output->output ='<h3><i class="fa fa-angle-right"></i>Data Kelas </h3> <br/>' . $output->output;
        $this->showOutput($output);
    }

    function showOutput($output=null){
        $this->showHeader();
        $this->load->view('crud/manage',$output);
        $this->load->view('footer_crud');  
    }

    function createUserWali($post_array, $primary_key)
    {
        // $this->load->model('user');
        $query = $this->db->query('SELECT max(kd_kelas) AS kode FROM kelas');
        $result = $query->first_row('array');
        $kd_kelas = $result['kode'];

        $tahun_ajaran = $post_array['tahun_ajaran'];
        $tahun_ajaran2 = $this->tahun_ajaran->getCurrentTA();

        $nana = $this->db->select('nip')->get_where('guru',array('kd_guru' => $post_array['kd_guru']));
        $res = $nana->first_row('array');
        $data = array(
                        'user' => 'WL-' . $res['nip'],
                        'level' => '4',
                        'pass' => sha1($res['nip']),
                        'kd_transaksi' => $post_array['kd_guru']
                );
        // $this->user->process_create_user($data);
        $query = $this->db->query("SELECT * FROM users WHERE user = 'WL-".$res['nip']."' AND level = 4");
        if ($query->first_row() == null)
            $this->db->insert('users',$data);

        
        $this->db->query("UPDATE kelas_siswa SET tahun_ajaran='$tahun_ajaran' WHERE kd_kelas='$kd_kelas'");
        $this->db->query("UPDATE kelas_siswa SET tahun_ajaran='$tahun_ajaran2' WHERE tahun_ajaran=''");
    }


}