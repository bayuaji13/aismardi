<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Pengampu extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model(array('pengampu_m','kelas','mata_pelajaran','siswa','nilai_m'));
        $this->load->library('grocery_CRUD');
    }

    public function index(){
        redirect('pengampu/managePengampu');
    }


    public function managePengampu($mode = null) {
        $crud = new grocery_CRUD();

        $crud->set_table('pengampu')
            ->set_subject('Pengampu')
            ->display_as('kd_guru', 'Nama Guru')
            ->display_as('kd_pelajaran', 'Mata Pelajaran')
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

    public function getKelasDanMapelAmpu($kd_guru,$tahun_ajaran,$field,$semester)
    {
        $hasil = $this->pengampu_m->getKelasDanMapelAmpu($kd_guru,$tahun_ajaran);
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

    public function cekKelasDanMapelAmpu($kd_guru,$kd_pelajaran,$kd_kelas,$tahun_ajaran,$semester)
    {
        $array = $this->pengampu_m->getKelasDanMapelAmpuV2($kd_guru,$tahun_ajaran);
        $hasil = false;
        // print_r($array);
        // die();
        for ($i=0; $i < sizeof($array['kd_kelas']); $i++) { 
            if ($array['kd_kelas'][$i] == $kd_kelas AND $array['kd_pelajaran'][$i] == $kd_pelajaran){
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




    public function isiNilaiSiswaAmpu($kd_kelas,$kd_pelajaran,$field,$tahun_ajaran,$semester)
    {
        
        $this->tahun_ajaran->cekSemester($semester,$tahun_ajaran);
        // die($this->session->userdata('level'));
        if (!$this->cekKelasDanMapelAmpu($this->session->userdata('kd_transaksi'),$kd_pelajaran,$kd_kelas,$tahun_ajaran,$semester) OR $this->session->userdata('level') != 1){
            echo "akses ditolak";
            // sleep(5);
            redirect('users/login');
        }
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '<br />');
        $data = $this->kelas->getIsiKelas($kd_kelas);
        $i = 0;
        foreach ($data as $row) {
            $inner_data = $this->siswa->getSiswa($row['kd_siswa']);
            $hasil = $inner_data->first_row('array');
            $hasil[$i]['kd_siswa'] = $row['kd_siswa'];
            $teks = $hasil['nama_siswa'] . " - " .$hasil['nis'];
            $this->form_validation->set_rules("nilai[$i]",$teks,'min_length[1]|max_length[5]');
            $i++;
            
        }
        $form['data']['min'] = 0;
        if ($field == "nilai_ki1" or $field == "nilai_ki4"){ //validasi buat range 4
            $form['data']['max'] = 4;
        } else {
            $form['data']['max'] = 100;
        }

        if ($this->form_validation->run() == false){
            $i = 0;
            foreach ($data as $row) {
                $form['data']['nilai'][$i] = array(
                                                    'name' => "nilai[]",
                                                    'id' => "nilai_$i",
                                                    'value' => set_value("nilai[$i]",$this->nilai_m->cekNilaiField($row['kd_siswa'],$kd_pelajaran,$tahun_ajaran,$semester,$field)),
                                                    'max_length' => '5',
                                                    'min' => '0',
                                                    'max' => '100'
                                                );
                $form['data']['kd_siswa'][$i] = array(
                                                    'name' => "kd_siswa[$i]",
                                                    'id' => "kd_siswa_$i",
                                                    'type' => "hidden",
                                                    'value' => set_value("kd_siswa[$i]",$row['kd_siswa'])
                                                );
                $inner_data = $this->siswa->getSiswa($row['kd_siswa']);
                $hasil = $inner_data->first_row('array');
                $teks = $hasil['nama_siswa'] . " - " .$hasil['nis'];
                $form['data']['label'][$i] = $teks;
                $i++;
            }
            $form['data']['kd_pelajaran'] = array(
                                                    'name' => "kd_pelajaran",
                                                    'type' => "hidden",
                                                    'value' => set_value("kd_pelajaran",$kd_pelajaran)
                                                );
            $form['data']['semester'] = array(
                                                    'name' => "semester",
                                                    'type' => "hidden",
                                                    'value' => set_value("semester",$semester)
                                                );
            $form['data']['tahun_ajaran'] = array(
                                                    'name' => "tahun_ajaran",
                                                    'type' => "hidden",
                                                    'value' => set_value("tahun_ajaran",$tahun_ajaran)
                                                );
            $form['data']['field'] = array(
                                                    'name' => "field",
                                                    'type' => "hidden",
                                                    'value' => set_value("field",$field)
                                                );
            $form['data']['kd_kelas'] = array(
                                                    'name' => "kd_kelas",
                                                    'type' => "hidden",
                                                    'value' => set_value("kd_kelas",$kd_kelas)
                                                );
        }
        $this->showHeader();
        $this->load->view('pengampu/isi_nilai',$form['data']);
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