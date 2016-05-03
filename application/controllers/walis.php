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

    public function raporWali($semester)
    {
        $id_guru = $this->session->userdata('id_transaksi');
        $tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
        $id_kelas = $this->wali->getKelasPerwalian($id_guru,$tahun_ajaran);
        $data_kelas = $this->kelas->getInfoKelas($id_kelas);
        $isi_kelas = $this->kelas->getIsiKelas($id_kelas);
        $i = 0;
        foreach ($isi_kelas as $row) {
            $data[$i]['teks'] = $row['nisn']." - ".$row['nama'];
            $data[$i]['link'] = "nilai/generateExcel/".$row['id_siswa']."/".$tahun_ajaran."/".$semester;
            $i++;
        }
        $form['data'] = $data;
        $this->showHeader();
        $this->load->view('wali/lihat_rapor',$form);
        $this->load->view('footer_general');
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
            $teks = $hasil['nama_siswa'] . " - " .$hasil['nisn'];
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
                $teks = $hasil['nama_siswa'] . " - " .$hasil['nisn'];
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

    public function isiNilaiSekunder($id_kelas,$tahun_ajaran,$semester)
    {
        $id_guru = $this->session->userdata['id_transaksi'];
        // if (!$this->wali->verifikasiGuru($kd_guru,$kd_kelas,$tahun_ajaran) or !$this->tahun_ajaran->verifikasiSemester($semester,$tahun_ajaran))
        //     redirect("users/login");
    	$isi = $this->kelas->getIsiKelas($id_kelas);
    	foreach ($isi as $siswa) {
    		$form['id_siswa'][] = $siswa['id_siswa'];
    		$form['kegiatan'][$siswa['id_siswa']] = $this->nilai_m->cekNilaiKegiatan($siswa['id_siswa'],$tahun_ajaran,$semester);
    		$form['organisnasi'][$siswa['id_siswa']] = $this->nilai_m->cekNilaiOrganisnasi($siswa['id_siswa'],$tahun_ajaran,$semester);

    		$form['nama_siswa'][] = $siswa['nama'];
    	}
    	$form['semester'] = $semester;
    	$form['tahun_ajaran'] = $tahun_ajaran;
        $form['id_kelas'] = $id_kelas;

    	// print_r($form['sekunder']);

    	// die();

    	$this->showHeader();
    	$this->load->view('nilai/nilai_pengembangan',$form);
    	$this->load->view('footer_form');
    }

    public function prosesIsiNilaiPengembangan()
    {



        // print_r($_POST);
        // die();

        $id_guru = $this->session->userdata['id_transaksi'];
        $tahun_ajaran = $this->input->post('tahun_ajaran');
        $id_kelas = $this->input->post('id_kelas');
        $semester = $this->input->post('semester');
        $id_siswa = $this->input->post('id_siswa');
        $nama_kegiatan = $this->input->post('nama_kegiatan');
        $nama_kegiatan_lama = $this->input->post('nama_kegiatan_lama');
        $nama_organisnasi_lama = $this->input->post('nama_organisnasi_lama');
        $nama_organisnasi = $this->input->post('nama_organisnasi');
        $nilai_kegiatan = $this->input->post('nilai_kegiatan');
        $nilai_organisnasi = $this->input->post('nilai_organisnasi');
        $ket_kegiatan = $this->input->post('ket_kegiatan');
        $ket_organisnasi = $this->input->post('ket_organisnasi');

        for ($i=0; $i < count($id_siswa); $i++) { 
            $dataKegiatan['id_siswa'] = $id_siswa[$i];
            $dataKegiatan['tahun_ajaran'] = $tahun_ajaran;
            $dataKegiatan['semester'] = $semester;
            $dataKegiatan['nama_kegiatan'] = $nama_kegiatan[$i];
            $dataKegiatan['nama_kegiatan_lama'] = $nama_kegiatan_lama[$i];
            $dataKegiatan['nilai_kegiatan'] = $nilai_kegiatan[$i];
            $dataKegiatan['ket_kegiatan'] = $ket_kegiatan[$i];

            $dataOrganisnasi['id_siswa'] = $id_siswa[$i];
            $dataOrganisnasi['tahun_ajaran'] = $tahun_ajaran;
            $dataOrganisnasi['semester'] = $semester;
            $dataOrganisnasi['nama_organisnasi'] = $nama_organisnasi[$i];
            $dataOrganisnasi['nama_organisnasi_lama'] = $nama_organisnasi_lama[$i];
            $dataOrganisnasi['nilai_organisnasi'] = $nilai_organisnasi[$i];
            $dataOrganisnasi['ket_organisnasi'] = $ket_organisnasi[$i];

            // $dataKegiatan[$i]['id_siswa'] = $id_siswa[$i];
            // $dataKegiatan[$i]['tahun_ajaran'] = $tahun_ajaran;
            // $dataKegiatan[$i]['semester'] = $semester;
            // $dataKegiatan[$i]['nama_kegiatan'] = $nama_kegiatan[$i];
            // $dataKegiatan[$i]['nama_kegiatan_lama'] = $nama_kegiatan_lama[$i];
            // $dataKegiatan[$i]['nilai_kegiatan'] = $nilai_kegiatan[$i];
            // $dataKegiatan[$i]['ket_kegiatan'] = $ket_kegiatan[$i];

            // $dataOrganisnasi[$i]['id_siswa'] = $id_siswa[$i];
            // $dataOrganisnasi[$i]['tahun_ajaran'] = $tahun_ajaran;
            // $dataOrganisnasi[$i]['semester'] = $semester;
            // $dataOrganisnasi[$i]['nama_organisnasi'] = $nama_organisnasi[$i];
            // $dataOrganisnasi[$i]['nama_organisnasi_lama'] = $nama_organisnasi_lama[$i];
            // $dataOrganisnasi[$i]['nilai_organisnasi'] = $nilai_organisnasi[$i];
            // $dataOrganisnasi[$i]['ket_organisnasi'] = $ket_organisnasi[$i];

            $this->nilai_m->isiNilaiPengembangan($dataKegiatan,$dataOrganisnasi);
            die();
        }
        print_r($dataKegiatan);
        print_r($dataOrganisnasi);
        die();


        redirect('walis/isiNilaiSekunder/'.$kd_kelas.'/'.$tahun_ajaran.'/'.$semester);

        
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
    	$jenisn = $this->input->post('nama_kegiatan');
        $keterangan = $this->input->post('ket_kegiatan');
    	
    	// print_r($antar_mapel);
    	// die();


    	$iter = 0;
    	foreach ($kd_siswa as $key) {

    		$this->nilai_m->isiNilaiSekunder($kd_siswa[$iter],$tahun_ajaran,$semester,$antar_mapel[$iter],$sakit[$iter],$izin[$iter],$alfa[$iter]);

    		//isi nilai pengembangan
    		$in_iter = 0;
    		foreach ($jenisn[$iter] as $kegiatan) {
    			$this->nilai_m->isiNilaiKegiatan($kd_siswa[$iter],$tahun_ajaran,$semester,$jenisn[$iter][$in_iter],$keterangan[$iter][$in_iter]);
    			$in_iter++;
    		}
    		$iter++;
    	}

    	redirect('walis/isiNilaiSekunder/'.$kd_kelas.'/'.$tahun_ajaran.'/'.$semester);

    	
    }


}