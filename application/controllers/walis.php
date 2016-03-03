<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Walis extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model(array('pengampu_m','kelas','mata_pelajaran','siswa','nilai_m','wali'));
        $this->load->library('grocery_CRUD');
    }

    public function isiNilaiKI1SiswaAmpu($kd_kelas,$tahun_ajaran,$semester)
    {
    	
        // die($this->session->userdata('level'));
        // if (!$this->cekKelasDanMapelAmpu($this->session->userdata('kd_transaksi'),$kd_pelajaran,$kd_kelas,$tahun_ajaran,$semester) OR $this->session->userdata('level') != 1){
        //     echo "akses ditolak";
        //     // sleep(5);
        //     redirect('users/login');
        // }
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

        if ($this->form_validation->run() == false){
            $i = 0;
            foreach ($data as $row) {
                $form['data']['nilai'][$i] = array(
                                                    'name' => "nilai[$i]",
                                                    'id' => "nilai_$i",
                                                    'type' => "text",
                                                    'value' => set_value("nilai[$i]",$this->nilai_m->cekNilaiFieldKI1($row['kd_siswa'],$tahun_ajaran,$semester)),
                                                    'max_length' => '1000'
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
            $form['data']['kd_kelas'] = array(
                                                    'name' => "kd_kelas",
                                                    'type' => "hidden",
                                                    'value' => set_value("kd_kelas",$kd_kelas)
                                                );
        }
        $this->showHeader();
        $this->load->view('pengampu/isi_nilaiKI1',$form['data']);
        $this->load->view('footer_general');
    }

    public function prosesIsiNilaiKI1()
    {

        // if ($this->session->userdata('level') != 1){
        //     echo "akses ditolak";
        //     // sleep(5);
        //     redirect('users/login');
        // }
        $nilai = $this->input->post('nilai');
        $kd_siswa = $this->input->post('kd_siswa');
        $semester = $this->input->post('semester');
        $kd_kelas = $this->input->post('kd_kelas');
        $tahun_ajaran= $this->input->post('tahun_ajaran');
        // echo $field;
        
        for ($i=0; $i < sizeof($nilai); $i++) { 
            $this->nilai_m->isiNilaiKI1($kd_siswa[$i],$tahun_ajaran,$semester,$nilai[$i]);
        }

        redirect("wali/isiNilaiKI1SiswaAmpu/$kd_kelas/$tahun_ajaran/$semester");

    }

    public function isiNilaiSekunder($kd_kelas,$tahun_ajaran,$semester)
    {
        $kd_guru = $this->session->userdata['kd_transaksi'];
        if (!$this->wali->verifikasiGuru($kd_guru,$kd_kelas,$tahun_ajaran) or !$this->tahun_ajaran->verifikasiSemester($semester,$tahun_ajaran))
            redirect("users/login");
    	$isi = $this->kelas->getIsiKelas($kd_kelas);
    	foreach ($isi as $siswa) {
    		$form['kd_siswa'][] = $siswa['kd_siswa'];
    		$query = $this->siswa->getSiswa($siswa['kd_siswa']);
    		$hasil = $query->first_row();
    		$nama_siswa = $hasil->nama_siswa;
    		$nis = $hasil->nis;
    		$form['kegiatan'][$siswa['kd_siswa']] = $this->nilai_m->cekNilaiFieldKegiatan($siswa['kd_siswa'],$tahun_ajaran,$semester);
    		$form['sekunder'][$siswa['kd_siswa']] = $this->nilai_m->cekNilaiFieldSekunder($siswa['kd_siswa'],$tahun_ajaran,$semester);

    		$form['nama_siswa'][] = $nama_siswa." - ".$nis;
    	}
    	$form['semester'] = $semester;
    	$form['tahun_ajaran'] = $tahun_ajaran;
        $form['kd_kelas'] = $kd_kelas;

    	// print_r($form['sekunder']);

    	// die();

    	$this->showHeader();
    	$this->load->view('nilai_sekunder',$form);
    	$this->load->view('footer_form');
    }

    public function prosesIsiNilaiSekunder()
    {

        $kd_guru = $this->session->userdata['kd_transaksi'];
        $tahun_ajaran = $this->input->post('tahun_ajaran');
        $kd_kelas = $this->input->post('kd_kelas');
        $semester = $this->input->post('semester');
        if (!$this->wali->verifikasiGuru($kd_guru,$kd_kelas,$tahun_ajaran) or !$this->tahun_ajaran->verifikasiSemester($semester,$tahun_ajaran))
            redirect("users/login");
        
    	
    	$kd_siswa = $this->input->post('kd_siswa');
    	$sakit = $this->input->post('sakit');
    	$izin = $this->input->post('izin');
    	$alfa = $this->input->post('alfa');
    	$antar_mapel = $this->input->post('antar_mapel');
    	$jenis = $this->input->post('nama_kegiatan');
        $keterangan = $this->input->post('ket_kegiatan');
    	
    	// print_r($antar_mapel);
    	// die();


    	$iter = 0;
    	foreach ($kd_siswa as $key) {

    		$this->nilai_m->isiNilaiSekunder($kd_siswa[$iter],$tahun_ajaran,$semester,$antar_mapel[$iter],$sakit[$iter],$izin[$iter],$alfa[$iter]);

    		//isi nilai pengembangan
    		$in_iter = 0;
    		foreach ($jenis[$iter] as $kegiatan) {
    			$this->nilai_m->isiNilaiKegiatan($kd_siswa[$iter],$tahun_ajaran,$semester,$jenis[$iter][$in_iter],$keterangan[$iter][$in_iter]);
    			$in_iter++;
    		}
    		$iter++;
    	}

    	redirect('walis/isiNilaiSekunder/'.$kd_kelas.'/'.$tahun_ajaran.'/'.$semester);

    	
    }


}