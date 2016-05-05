<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Pengampu extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model(array('pengampu_m','kelas','mata_pelajaran','siswa','nilai_m'));
        $this->load->library('excel');
        $this->load->library('grocery_CRUD');
    }

    public function index(){
        redirect('pengampu/managePengampu');
    }

    public function pilihKelas()
    {
        $data['kelas'] = $this->kelas->getAllKelas();
        $this->showHeader();
        $this->load->view('pengampu/pilih_kelas',$data);
        $this->load->view('footer_general');
    }

    public function pilihPengampu($id_kelas)
    {
        $tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
        $jurusan = $this->kelas->getJurusanByKelas($id_kelas);
        if ($jurusan == null)
            $jurusan = 1;
        $data['mapel'] = $this->mata_pelajaran->getMapelByJurusan($jurusan,$tahun_ajaran);
        $data['guru'] = $this->pengampu_m->getAllGuru();
        $data['id_kelas'] = $id_kelas;
        $this->showHeader();
        $this->load->view('pengampu/pilih_pengampu',$data);
        $this->load->view('footer_general');
    }

    public function setPengampu()
    {
        print_r($_POST);
        $mapel = $_POST['mapel'];
        $pengampu = $_POST['pengampu'];
        $id_kelas = $_POST['id_kelas'];
        $success = true;
        for ($i=0; $i < count($mapel); $i++) { 
            $success = $success AND $this->pengampu_m->setPengampu($id_kelas,$mapel[$i],$pengampu[$i]);
        }
        if ($success)
            $this->session->set_flashdata('notice','Data berhasil diinput');
        else
            $this->session->set_flashdata('notice','Ada data yang gagal diinput');
        redirect('pengampu/pilihPengampu/'.$id_kelas);
    }


    public function managePengampu($mode = null) {
        $crud = new grocery_CRUD();

        $crud->set_table('tabel_guru')
            ->set_subject('Pengampu')
            ->display_as('id_guru', 'Nama Guru')
            ->display_as('id_mapel', 'Mata Pelajaran')
            ->display_as('tahun_ajaran', 'Tahun Ajaran')
            ->field_type('tahun_ajaran', 'hidden', $this->tahun_ajaran->getCurrentTA())
            ->set_relation('kd_pelajaran','mata_pelajaran','nama_pelajaran')
            ->set_relation('kd_guru','guru','nama_guru')
            ->set_relation('kd_kelas','kelas','nama_kelas',array('tahun_ajaran' => $this->tahun_ajaran->getCurrentTA()))
            ->display_as('kd_kelas', 'Kelas')
            ->required_fields('tahun_ajaran','kd_guru','kd_pelajaran','kd_kelas')
            ->where('pengampu.tahun_ajaran',$this->tahun_ajaran->getCurrentTA())
            ->order_by('tahun_ajaran','desc');

        //kalau bukan mode nampilin semua, edit di enable, tampilin cuma pengampu TA sekarang
        if ($mode == null){
            $crud->where('pengampu.tahun_ajaran',$this->tahun_ajaran->getCurrentTA());
            // $crud->where('pengampu.tahun_ajaran', $this->tahun_ajaran->getCurrentTA());
        }
        if ($mode == 'all_pengampu'){ //pas mode nampilin semua, unset edit
            $crud->unset_edit();
        }

        if ($this->session->userdata('level') != 9){
            $crud->unset_edit()
            ->where('pengampu.tahun_ajaran',$this->tahun_ajaran->getCurrentTA())
            ->unset_delete()
            ->unset_add();
        }
        $output = $crud->render();
        $output->output ='<h3><i class="fa fa-angle-right"></i>Data Pengampu</h3> <br/>' . $output->output;
        $this->showOutput($output);
    }

    public function getKelasDanMapelAmpu($id_guru,$semester)
    {
        $hasil = $this->pengampu_m->getKelasDanMapelAmpu($id_guru);
        for ($i=0; $i < sizeof($hasil); $i++) { 
            $hasil[$i]['string'] = $this->kelas->getNamaKelas($hasil[$i]['id_kelas']) ." - ".$this->mata_pelajaran->getNamaMapel($hasil[$i]['id_mapel']);
        }
        $array['data'] = $hasil;
        $array['semester'] = $semester;
        $this->showHeader();
        $this->load->view('list_kelas_ampu',$array);
        $this->load->view('footer_general');
        
    }

    public function getKelasDanMapelAmpuOLD($id_guru,$semester)
    {

        $hasil = $this->pengampu_m->getKelasDanMapelAmpu($id_guru,$tahun_ajaran);
        for ($i=0; $i < sizeof($hasil); $i++) { 
            $hasil[$i]['string'] = $this->kelas->getNamaKelas($hasil[$i]['kd_kelas']) ." - ".$this->mata_pelajaran->getNamaMapel($hasil[$i]['kd_pelajaran']);
        }
        $array['data'] = $hasil;
        $array['tahun_ajaran'] = $this->tahun_ajaran->getCurrentTA();
        $array['field'] = $field;
        $array['semester'] = $semester;
        // print_r($array);
        // die();
        $this->showHeader();
        $this->load->view('list_kelas_ampu',$array);
        $this->load->view('footer_general');
        // foreach ($hasil as $row) {
        //     echo $this->kelas->getNamaKelas($row['kd_kelas'])." - ".$this->mata_pelajaran->getNamaMapel($row['kd_pelajaran'])."<br/>";
        // }
    }


    public function monitorGuruMapelKelas($kd_guru,$kd_pelajaran,$kd_kelas,$tahun_ajaran,$semester)
    {
        $this->load->model('kelas');

        $jumlah_siswa = $this->kelas->getJumlahSiswa($kd_kelas);

        $list[0]['nama'] = 'Nilai Harian 1';
        $list[0]['terisi'] = ($this->nilai_m->cekCompletionMapel($kd_pelajaran,$kd_kelas,'nilai_harian1',$tahun_ajaran,$semester) / $jumlah_siswa) * 100;
        // $list[0]['persen'] = $this->nilai_m->cekCompletionMapel($kd_pelajaran,$kd_kelas,'nilai_harian1',$tahun_ajaran,$semester);

        $list[1]['nama'] = 'Nilai Harian 2';
        $list[1]['terisi'] = $this->nilai_m->cekCompletionMapel($kd_pelajaran,$kd_kelas,'nilai_harian2',$tahun_ajaran,$semester) / $jumlah_siswa * 100;

        $list[2]['nama'] = 'Nilai Harian 3';
        $list[2]['terisi'] = $this->nilai_m->cekCompletionMapel($kd_pelajaran,$kd_kelas,'nilai_harian3',$tahun_ajaran,$semester) / $jumlah_siswa * 100;

        $list[3]['nama'] = 'Nilai Harian 4';
        $list[3]['terisi'] = $this->nilai_m->cekCompletionMapel($kd_pelajaran,$kd_kelas,'nilai_harian4',$tahun_ajaran,$semester) / $jumlah_siswa * 100;

        $list[4]['nama'] = 'Nilai Harian 5';
        $list[4]['terisi'] = $this->nilai_m->cekCompletionMapel($kd_pelajaran,$kd_kelas,'nilai_harian5',$tahun_ajaran,$semester) / $jumlah_siswa * 100;

        $list[5]['nama'] = 'Nilai Tugas 1';
        $list[5]['terisi'] = $this->nilai_m->cekCompletionMapel($kd_pelajaran,$kd_kelas,'nilai_tugas1',$tahun_ajaran,$semester) / $jumlah_siswa * 100;

        $list[6]['nama'] = 'Nilai Tugas 2';
        $list[6]['terisi'] = $this->nilai_m->cekCompletionMapel($kd_pelajaran,$kd_kelas,'nilai_tugas2',$tahun_ajaran,$semester) / $jumlah_siswa * 100;

        $list[7]['nama'] = 'Nilai Tugas 3';
        $list[7]['terisi'] = $this->nilai_m->cekCompletionMapel($kd_pelajaran,$kd_kelas,'nilai_tugas3',$tahun_ajaran,$semester) / $jumlah_siswa * 100;

        $list[8]['nama'] = 'Nilai MID Semester';
        $list[8]['terisi'] = $this->nilai_m->cekCompletionMapel($kd_pelajaran,$kd_kelas,'nilai_mid',$tahun_ajaran,$semester) / $jumlah_siswa * 100;

        $list[9]['nama'] = 'Nilai UAS ';
        $list[9]['terisi'] = $this->nilai_m->cekCompletionMapel($kd_pelajaran,$kd_kelas,'nilai_uas',$tahun_ajaran,$semester) / $jumlah_siswa * 100;

        $array['data'] = $list;
        $array['jumlah_siswa'] = $jumlah_siswa;

        $this->showHeader();
        $this->load->view('capaian_guru',$array);
        $this->load->view('footer_general');

    }

    public function cekKelasDanMapelAmpu($id_guru,$id_kelas,$id_mapel)
    {
        $array = $this->pengampu_m->getKelasDanMapelAmpu($id_guru);
        $hasil = false;
        // echo sizeof($array);
        // print_r($array);
        // die();
        for ($i=0; $i < sizeof($array); $i++) { 
            if ($array[$i]['id_kelas'] == $id_kelas AND $array[$i]['id_mapel'] == $id_mapel){
                $hasil = true;
            }
        }
        return $hasil;
    }

    public function PenilaianPerSemester()
    {
        $this->showHeader();
        $this->load->view('menu_nilai');
        $this->load->view('footer_general');
    }

    public function monitorPengampu($semester)
    {
        $data = $this->pengampu_m->getAllPengampu($this->tahun_ajaran->getCurrentTA());
        for ($i=0; $i < sizeof($data); $i++) { 
            $data[$i]['nama_guru'] = $this->pengampu_m->getNamaPengampu($data[$i]['kd_guru']);
        }
        $array['data'] = $data;
        $array['semester'] = $semester;
        $this->showHeader();
        $this->load->view('list_pengampu',$array);
        $this->load->view('footer_general');
    }

    public function monitorListKelasMapel($kd_guru,$tahun_ajaran,$semester)
    {
        $hasil = $this->pengampu_m->getKelasDanMapelAmpu($kd_guru,$tahun_ajaran);
        for ($i=0; $i < sizeof($hasil); $i++) { 
            $hasil[$i]['string'] = $this->kelas->getNamaKelas($hasil[$i]['kd_kelas']) ." - ".$this->mata_pelajaran->getNamaMapel($hasil[$i]['kd_pelajaran']);
        }
        $array['data'] = $hasil;
        $array['kd_guru'] = $kd_guru;
        $array['tahun_ajaran'] = $tahun_ajaran;
        $array['semester'] = $semester;
        $this->showHeader();
        $this->load->view('list_kelas_mapel_ampu',$array);
        $this->load->view('footer_general');
    }

    public function coba()
    {
        // $hasil = $this->kelas->getInfoKelas(11);
        // print_r($hasil);
        // $hasil = $this->pengampu_m->getPengampu(5);
        // print_r($hasil);
        // $hasil = $this->mata_pelajaran->getNamaMapel(2);
        // print_r($hasil);
        $hasil = $this->kelas->getIsiKelas(11);
        print_r($hasil);
    }

    public function templateExporter($id_kelas,$id_mapel,$semester)
    {

        $path_template = realpath(FCPATH).'/assets/template_excel/TemplateUploadNilaiSiswa.xls';
        $excel = new PHPExcel_Reader_Excel5();
        $objPHPExcel = $excel->load($path_template);
        $objWorksheet = $objPHPExcel->getActiveSheet();

        //set datakelas dulu :
        $tahun_ajaran = (string)$this->tahun_ajaran->getCurrentTA() . ' / '. (string)($this->tahun_ajaran->getCurrentTA() + 1);
        $id_guru = $this->session->userdata('id_transaksi');
        $data_kelas = $this->kelas->getInfoKelas($id_kelas);
        $data_guru = $this->pengampu_m->getPengampu($id_guru);
        $nama_mapel = $this->mata_pelajaran->getNamaMapel(2);

        $objWorksheet->setCellValueByColumnAndRow(3,4,$tahun_ajaran);
        $objWorksheet->setCellValueByColumnAndRow(3,5,$semester);
        $objWorksheet->setCellValueByColumnAndRow(3,6,$data_kelas['nip_wali']);
        $objWorksheet->setCellValueByColumnAndRow(3,7,$data_kelas['nama_wali']);

        $objWorksheet->setCellValueByColumnAndRow(8,4,$nama_mapel);
        $objWorksheet->setCellValueByColumnAndRow(8,5,$data_kelas['nama_kelas'] .' '. $data_kelas['jurusan']);
        $objWorksheet->setCellValueByColumnAndRow(8,6,$data_guru['nip']);
        $objWorksheet->setCellValueByColumnAndRow(8,7,$data_guru['nama']);

        //set data hidden (id_kelas, idmapel, tahun_ajaran, )
        $objWorksheet->setCellValueByColumnAndRow(1,11,$id_kelas);
        $objWorksheet->setCellValueByColumnAndRow(2,11,$id_mapel);
        $objWorksheet->setCellValueByColumnAndRow(3,11,$this->tahun_ajaran->getCurrentTA());

        //tambahin data anak-anaknya sekalian haha
        $row = 16;
        $isi_kelas = $this->kelas->getIsiKelas($id_kelas);
        $i = 1;
        foreach ($isi_kelas as $siswa) {
            $objWorksheet->setCellValueByColumnAndRow(0,$row,$i);
            $objWorksheet->setCellValueByColumnAndRow(1,$row,$siswa['nis']);
            $objWorksheet->setCellValueByColumnAndRow(2,$row,$siswa['nama']);
            $i++;
            $row++;
        }









        // $row = 19;
        // $highestColumnIndex = count($field)+1;
        // for ($i=0; $i < count($laporan); $i++) { 
        //     $laporan[$i]['tgl_lahir'] = $this->reKonversiTanggal($laporan[$i]['tgl_lahir']);
        //     $laporan[$i]['jns_kelamin'] = $this->reKonversiJekel($laporan[$i]['jns_kelamin']);
        //     $laporan[$i]['status'] = $this->reKonversiStatus($laporan[$i]['status']);
        //     $laporan[$i]['tipe'] = $this->reKonversiTipe($laporan[$i]['tipe']);
        //     $objWorksheet->setCellValueByColumnAndRow(0,$row,$i+1);
        //     for ($j=1; $j < $highestColumnIndex; $j++) { 
        //         $objWorksheet->setCellValueByColumnAndRow($j,$row,$laporan[$i][$field[$j]]);
        //     }
        //     $row++;
        // }

        //===================================================================================
        $filename='Data Kelas '. $data_kelas['nama_kelas']. time() . '.xls'; //save our workbook as this file name
        $filename = urlencode($filename);
        // header('Content-Type: application/vnd.ms-excel'); //mime type
        // header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        // header('Cache-Control: max-age=0'); //no cache

        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);  
        $exportPlace = realpath(FCPATH).'/assets/downloadable/'.$filename;
        $objWriter->save($exportPlace);
        return $filename;
        //===================================================================================

        // $filename='nananana.xls'; //save our workbook as this file name
        // header('Content-Type: application/vnd.ms-excel'); //mime type
        // header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        // header('Cache-Control: max-age=0'); //no cache

        // $objWriter = new PHPExcel_Writer_excel5($objPHPExcel);  
        // $objWriter->save('php://output');




    }

    public function isiNilaiSiswaAmpu($id_kelas,$id_mapel,$semester)
    {
        $tahun_ajaran = $this->tahun_ajaran->getCurrentTA();        
        $this->tahun_ajaran->cekSemester($semester,$tahun_ajaran);
        // die($this->session->userdata('level'));
        if (!$this->cekKelasDanMapelAmpu($this->session->userdata('id_transaksi'),$id_kelas,$id_mapel) OR $this->session->userdata('level') != 1){
            echo "<script>alert('akses ditolak')</script>";
            // sleep(5);
            redirect('users/login');
        }
        $url = $this->templateExporter($id_kelas,$id_mapel,$semester);
        $url = base_url().'assets/downloadable/'.$url;
        $data['url'] = "<a href=".$url.">Download Format Peneilaian </a>";
        $this->showHeader();
        $this->load->view('nilai/form_upload',$data);
        $this->load->view('footer_general');
    }

    public function prosesIsiNilaiSiswaAmpu()
    {

        if ($this->session->userdata('level') != 1){
            echo "akses ditolak";
            // sleep(5);
            redirect('users/login');
        }
        $nilai = $this->input->post('nilai');
        $kd_siswa = $this->input->post('kd_siswa');
        $kd_pelajaran = $this->input->post('kd_pelajaran');
        $tahun_ajaran = $this->input->post('tahun_ajaran');
        $semester = $this->input->post('semester');
        $field = $this->input->post('field');
        $kd_kelas = $this->input->post('kd_kelas');
        // echo $field;
        
        for ($i=0; $i < sizeof($nilai); $i++) { 
            $this->nilai_m->isiNilai($kd_siswa[$i],$kd_pelajaran,$tahun_ajaran,$semester,$field,$nilai[$i]);
        }

        

        redirect("pengampu/isiNilaiSiswaAmpu/$kd_kelas/$kd_pelajaran/$field/$tahun_ajaran/$semester?success");

    }

    public function showOutput($output=null){
        $this->showHeader(); 
        $this->load->view('crud/manage',$output);
        $this->load->view('footer_crud');  
    }
 
}