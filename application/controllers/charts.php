<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Charts extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->model('nilai');
	}

	function index() {
		redirect('charts/chart_tingkat');
	}


	// function showOutput($output = null)
 //    {
 //        $this->showHeader();   
 //        $this->load->view('crud/manage',$output);    
 //        $this->load->view('footer_chart');     
 //    } 
    public function n()
    {
        $haish = $this->nilai->get_nilai_bytingkat(2, 21);
        print_r($haish);
    }

    public function chart_tingkat()
    {
        //chart tingkat

        $query = $this->db->query('SELECT nama_pelajaran,kd_pelajaran FROM mata_pelajaran');
        $result= $query->result_array();
        for ($i=1; $i < 4; $i++) { 
            foreach ($result as $row) {
                $data['labels'][$i][] = $row['nama_pelajaran'];
                $hasil = $this->nilai->get_nilai_bytingkat($i, $row['kd_pelajaran']);
                $data['higher'][$i][] = $hasil['nhigher'];
                $data['lower'][$i][] = $hasil['nlower'];
            }

        }
        $data['tahun_ajaran'] = $this->tahun_ajaran->getCurrentTA();
        
        // echo json_encode($barChartData);
        // // print_r($data['labels'][1]);
        // die();
        // print_r($labels);
        // echo "<br/>";
        // print_r($higher);
        // echo "<br/>";
        // print_r($lower);        

        // $hasil[1] = $this->nilai->get_nilai_bytingkat(1);
        // $hasil[2] = $this->nilai->get_nilai_bytingkat(2);
        // $hasil[3] = $this->nilai->get_nilai_bytingkat(3);
        
        // for ($i=1; $i <= 3; $i++) { 
        //     $hasil[$i]['nhigher'] = array('value' => (int)$hasil[$i]['nhigher'],'color' => "#9b59b6" , 'highlight' => "#eb0c40", 'label' => 'diatas rata-rata' );
        //     $hasil[$i]['nlower'] = array('value' => (int)$hasil[$i]['nlower'],'color' => "#34495e" );
        //     $data['chart'][$i] = "[".json_encode($hasil[$i]['nhigher']).",".json_encode($hasil[$i]['nlower'])."]";
       
        // }

        
        
        $this->showHeader();
        $this->load->view('chart_tingkat', $data);
        $this->load->view('footer_chart',$data);
    }

    public function chart_tingkat_mapel_kelas($tingkat, $tahun_ajaran)
    {
        // $hasil = $this->nilai->get_nilai_bytingkat_bymapel_bykelas($tingkat, $jadwal, $kelas);
        // $hasil['nhigher'] = array('value' => (int)$hasil['nhigher'],'color' => "#9b59b6" );
        // $hasil['nlower'] = array('value' => (int)$hasil['nlower'],'color' => "#34495e" );
        // // print_r(json_decode($nini));
        // $data['chart1'] = "[".json_encode($hasil['nhigher'])."]";
        // $data['chart2'] = "[".json_encode($hasil['nlower'])."]";
        // $this->showHeader();
        // $this->load->view('chart_tingkat_kelas1');
        // $this->load->view('footer_chart',$data);
        $query = $this->db->query('SELECT nama_pelajaran,kd_pelajaran FROM mata_pelajaran');
        $label = $query->result_array();
        $query = $this->db->query("SELECT kd_kelas, nama_kelas FROM kelas WHERE tingkat = '$tingkat' AND tahun_ajaran='$tahun_ajaran'");
        $kelas = $query->result_array();
        // print_r($kelas);
        // echo "<br/>";
        // print_r($label);
        // die();
        $data['jumlah_kelas'] = $query->num_rows();
        $i=0;
        foreach ($kelas as $i_kelas) {
            $data['kelas'][] = $i_kelas['nama_kelas'];
            $i++;
            foreach ($label as $mapel) {
                
                $hasil = $this->nilai->get_nilai_bytingkat_bymapel_bykelas($tingkat,$mapel['kd_pelajaran'],$i_kelas['kd_kelas']);
                $data['labels'][$i][] = $mapel['nama_pelajaran'];
                $data['higher'][$i][] = $hasil['nhigher'];
                $data['lower'][$i][] = $hasil['nlower'];
            }

        }
        // print_r($data);
        // die();

        $this->showHeader();
        $this->load->view('chart_tingkat_kelas',$data);
        $this->load->view('footer_chart',$data);
    }
    
}