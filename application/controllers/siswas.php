<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Siswas extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model('siswa');
        $this->load->library('excel');
        $this->load->library('grocery_CRUD');
        $this->load->model('mata_pelajaran');
    }

    function index() {
        redirect('siswas/managesiswa');
    }

    public function managesiswa($tipe = null){
        // $this->tahun_ajaran->newTA();echo "allalala";die();
        //$ta = $this->tahun_ajaran->getCurrentTA();
        $data = array();
        $crud = new grocery_CRUD();

        $crud->set_table('tabel_siswa')
        ->columns('nis','nama','tahun_masuk','jurusan','status','tingkat')
        ->set_relation('tahun_masuk','tahun_ajaran','tahun_ajaran',null,'id_tahun_ajaran', 'DESC LIMIT 3')
        ->set_relation('jurusan','tabel_jurusan','nama_jurusan')
        ->unset_fields('id_siswa')
        // ->field_type('tahun_lulus','integer')
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

    public function setTidakLulus()
    {
        $siswa = $this->input->post('tidak_lulus');
        $this->siswa->lulus();
        if ($siswa != null){
            foreach ($siswa as $row) {
                $this->siswa->tidakLulus($row);
            }
        }
        echo "<script>alert('Sistem masuk ke tahun ajaran baru!')</script>";
        redirect('users/home');
    }

    public function setTunggakan()
    {
        $berhasil = true;
        $keMenunggak = $this->input->post('menunggak');
        $keTidakMenunggak = $this->input->post('tidak_menunggak');

        foreach ($keMenunggak as $row) {
            $berhasil = $berhasil and $this->siswa->setMenunggak($row);
        }

        foreach ($keTidakMenunggak as $row) {
            $berhasil = $berhasil and $this->siswa->setTidakMenunggak($row);
        }

        if ($berhasil){
            echo "<script>alert('berhasil memasukkan data!')</script>";
        } else {
            echo "<script>alert('ada data yang gagal dimasukkan!')</script>";
        }

        redirect('siswas/gantiTunggakan');
    }

    public function gantiTunggakan()
    {
        $this->showHeader();
        $this->load->view('siswa/status_tunggakan');    
        $this->load->view('footer_general');  
    }

    public function downloadKartu($id_siswa)
    {
        $valid = ($this->session->userdata('level') == 5 and  $this->session->userdata('id_transaksi') == $id_siswa);
        if ((!$tes = $this->siswa->cekBolehDownload($id_siswa)) or (!$valid)){
            $output['data'] = "Akses ke kartu ditolak";
            $this->showHeader();
            $this->load->view('siswa/kartu_ujian',$output);
            $this->load->view('footer_table');  
        } else {
            $tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
            $styleArray = array(
            'borders' => array(
                    'top' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        ),
                    'bottom' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        ),
                    'right' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        ),
                    'left' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )

                )
            );
            // $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
            // $rendererLibrary = 'mpdf';
            // $rendererLibraryPath = APPPATH.'third_party/'.$rendererLibrary;
            // if (!PHPExcel_Settings::setPdfRend
            //     die(
            //         'Please set the $rendererName and $rendererLibraryPath values' .
            //             PHP_EOL .
            //         ' as appropriate for your directory structure'
            //         );
            // }
            $path_template = realpath(FCPATH).'/assets/template_excel/TemplateKartuUjian.xls';
            $excel = new PHPExcel_Reader_Excel5();
            $objPHPExcel = $excel->load($path_template);
            $objWorksheet = $objPHPExcel->getActiveSheet();

            //prepare data
            $data_siswa = $this->siswa->getSiswa($id_siswa);
            $data_kelas = $this->siswa->getKelasSiswa($id_siswa,$tahun_ajaran);
            $data_mapel = $this->mata_pelajaran->getMapelByJurusan($data_kelas['jurusan'],$tahun_ajaran);

            $string_tahun_ajaran = (string)$tahun_ajaran . ' / '. (string)($tahun_ajaran + 1);

            if ($tes = 'uts')
                $string_kartu = "Kartu Ujian Tengah Semester";
            else if ($tes = 'uas')
                $string_kartu = "Kartu Ujian Akhir Semester";

            $objWorksheet->setCellValue('A1',$string_kartu);
            $objWorksheet->setCellValue('C6',$data_siswa['nama_siswa']);
            $objWorksheet->setCellValue('C7',$data_siswa['nis']." ");
            $objWorksheet->setCellValue('C8',$data_kelas['nama_kelas']);

            $baris = 11;
            for ($i=0; $i < count($data_mapel); $i++) { 
                $row = $data_mapel[$i];
                $cur_baris = $baris + $i;
                $merge = "B".$cur_baris.":C".$cur_baris;
                $objWorksheet->setCellValueByColumnAndRow(0,$i+$baris,$i+1);
                $objWorksheet->mergeCells($merge);
                $objWorksheet->setCellValueByColumnAndRow(1,$i+$baris,$row['nama_mapel']);
            }
            $baris_akhir = $baris+$i;

            for($x=$baris;$x<$baris_akhir;$x++){
                for ($y=0; $y<=3 ; $y++) { 
                    $cell = PHPExcel_Cell::stringFromColumnIndex($y) . $x;
                    $objWorksheet->getStyle($cell)->applyFromArray($styleArray);
                }
            }

            $objWriter = new PHPExcel_Writer_HTML($objPHPExcel);  
            $output['data'] = $objWriter->generateHTMLHeader();
            $output['data'] .= $objWriter->generateStyles();
            $output['data'] .= $objWriter->generateSheetData();
            $output['data'] .= $objWriter->generateHTMLFooter();


            $this->showHeader();
            $this->load->view('siswa/kartu_ujian',$output);
            $this->load->view('footer_table');  
        }
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

    public function kehadiranSiswa($id_siswa,$tahun_ajaran,$semester)
    {
        $sakit = $this->siswa->getAbsensi($id_siswa,$tahun_ajaran,$semester,1);
        $izin = $this->siswa->getAbsensi($id_siswa,$tahun_ajaran,$semester,2);
        $alfa = $this->siswa->getAbsensi($id_siswa,$tahun_ajaran,$semester,3);
        $tanggal = $this->siswa->getAllAbsensi($id_siswa,$tahun_ajaran,$semester);

        $data['sakit'] = $sakit['jumlah'];
        $data['izin'] = $izin['jumlah'];
        $data['alfa'] = $alfa['jumlah'];

        // $data['tanggal'] = $tanggal;

        // print_r($data);
        // die();
        
        $i = 0;
        $events = array();
        foreach ($tanggal as $row) {
            $events[$i] = array(
                                'title' => $row['keterangan'],
                                'start' => $row['tanggal']
                );
            $i++;
        }
        $array['data'] = 
        array(
                'header' => 
                array(
                        'left' => 'prev, next today',
                        'center' => 'title',
                        'right' => 'month,basicWeek,basicDay'
                    ),
                'events' => $events

             );
        $this->showHeader();
        $this->load->view('siswa/rekap_absensi',$data);
        $this->load->view('footer_calendar',$array);

    }

    public function kehadiranSiswaOLD($id_siswa,$tahun_ajaran,$semester)
    {
        $data['sakit'] = $this->siswa->getAbsensi($id_siswa,$tahun_ajaran,$semester,1);
        $data['izin'] = $this->siswa->getAbsensi($id_siswa,$tahun_ajaran,$semester,2);
        $data['alfa'] = $this->siswa->getAbsensi($id_siswa,$tahun_ajaran,$semester,3);

        print_r($data);
        die();

        $this->showHeader();
        $this->load->view('siswa/rekap_absensi',$data);
        $this->load->view('footer_general');
    }

    public function setAbsensi($semester)
    {
        $berhasil = true;
        print_r($semester);
        print_r($_POST);
        $sakit = $this->input->post('sakit');
        $izin = $this->input->post('izin');
        $alfa = $this->input->post('alfa');
        $tanggal = $this->input->post('tanggal');
        $tahun_ajaran = $this->tahun_ajaran->getCurrentTA();

        if ($sakit != null)
            foreach ($sakit as $row) {
                $berhasil = $berhasil and $this->siswa->isiAbsensi($row,$tanggal,1,$semester,$tahun_ajaran);
            }
        if ($izin != null)
            foreach ($izin as $row) {
                $berhasil = $berhasil and $this->siswa->isiAbsensi($row,$tanggal,2,$semester,$tahun_ajaran);
            }
        if ($alfa != null)
            foreach ($alfa as $row) {
                $berhasil = $berhasil and $this->siswa->isiAbsensi($row,$tanggal,3,$semester,$tahun_ajaran);
            }

        if ($berhasil){
            echo "<script>alert('berhasil memasukkan data!')</script>";
        } else {
            echo "<script>alert('ada data yang gagal dimasukkan!')</script>";
        }
        redirect("siswas/absensiSiswa/$semester");
    }

    public function coba()
    {
        $query = $this->db->query("SELECT tabel_menu.*,tabel_menu_children.id as id_child,tabel_menu_children.title as title_child,tabel_menu_children.customSelect as customSelect_child FROM tabel_menu,tabel_menu_children WHERE tabel_menu.id=tabel_menu_children.idParent");
        $hasil = $query->result_array();
        $hasil2 = array();
        foreach ($hasil as $row) {
            $hasil2[$row['id']]['id'] = $row['id'];
            $hasil2[$row['id']]['title'] = $row['title'];
            $hasil2[$row['id']]['customSelect'] = $row['customSelect'];
            $hasil2[$row['id']]['children'][] = array('id' => $row['id_child'],'title' => $row['title_child'],'customSelect' => $row['customSelect_child'] );
            
        }
        print_r($hasil);
        print_r($hasil2);
        // print_r(json_encode($hasil2));
    }

    public function cariSiswa($tingkat)
    {
        $nis = '%'.$this->input->get('search').'%';
        $query = $this->db->query("SELECT id_siswa as value,nis as text,nama as nama_siswa FROM tabel_siswa WHERE status = '1' AND tingkat='$tingkat' AND nis LIKE '$nis'");
        $result = $query->result_array();
        for ($i=0; $i < sizeof($result); $i++) { 
            $result[$i]['text'] = $result[$i]['text'] .' - '.$result[$i]['nama_siswa'];
            $result[$i]['data_siswa'] = null;
        } 

        // print_r($result);
        // die();
        $result = json_encode($result);
        print_r($result);
        die();
    }

    public function cariSiswaAll()
    {
        $nis = '%'.$this->input->get('search').'%';
        $query = $this->db->query("SELECT id_siswa as value,nis as text,nama as nama_siswa FROM tabel_siswa WHERE status = '1' AND nis LIKE '$nis'");
        $result = $query->result_array();
        for ($i=0; $i < sizeof($result); $i++) { 
            $result[$i]['text'] = $result[$i]['text'] .' - '.$result[$i]['nama_siswa'];
            $result[$i]['data_siswa'] = null;
        }

        // print_r($result);
        // die();
        $result = json_encode($result);
        print_r($result);
        die();
    }

    public function absensiSiswa($semester)
    {
        $data['semester'] = $semester;
        $this->showHeader();
        $this->load->view('absensi/absensi',$data);
        $this->load->view('footer_general');
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