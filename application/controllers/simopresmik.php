<?php
require(APPPATH.'/libraries/REST_Controller.php');
 
class simopresmik extends REST_Controller
{
    function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('nilai');
        $this->load->helper('url');
        $this->load->helper(array('form', 'url'));
		$this->load->library('excel');
    }

    public function coba_get()
    {
        // $data = 'halooooooo';
        // $this->response($data,200);

        $data = $this->nilai->get_10_tingkat('top',1);
        if ($data){
            $this->response($data,200);
        } else {
            $this->response('Not Found',404);
        }
    }

    //fungsi buat ngambil yang beresiko tinggal kelas
    public function risky_get()
    {
    	$tingkat = $this->get('tingkat');
        for ($i=1; $i < 3; $i++) { 
            $array['data'][$i] = $this->nilai->get_lower($i,$tingkat);
        }
        // echo ($array['data'][2] == null);
        // print_r($array);mm
        if ($array['data'][1]){
        	$this->response($array['data'],200);
        } else {
        	$this->response('Not Data',404);
        }
    }

    public function prestasiMapel_get(){
    	$tingkat = $this->get('tingkat');
        $query = $this->db->query("SELECT nama_pelajaran,kd_pelajaran FROM mata_pelajaran");
        $array['data']['tingkat'] = $tingkat;
        foreach ($query->result() as $mapel) {
            $array['data']['nama_mapel'][] = $mapel->nama_pelajaran;
            $array['data']['hasil'][] = $this->nilai->get_10_mapel('top',$tingkat,$mapel->kd_pelajaran);
        }
      	if ($array['data']['nama_mapel'][1]){
        	$this->response($array['data'],200);
        } else {
        	$this->response('Not Data',404);
        }
    }

    public function overall10_get($value='')
    {
    	for ($i=1; $i <=3; $i++) { 
    		$array['data'][$i]['upper'] = $this->nilai->get_10_tingkat('top',$i);
    	}
    	for ($i=1; $i <=3; $i++) { 
    		$array['data'][$i]['lower'] = $this->nilai->get_10_tingkat('least',$i);
    	}
    	// print_r($array);
    	// die();
    	
    	if ($array['data'][1]){
        	$this->response($array['data'],200);
        } else {
        	$this->response('Not Data',404);
        }
    }

    public function chartTingkat_get()
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
        
        if ($data){
            $this->response($data,200);
        } else {
            $this->response('Not Found',404);
        }
    }

    public function chartTingkatMapelKelas_get()
    {
    	$tingkat = $this->get('tingkat');
    	$tahun_ajaran = $this->get('tahun_ajaran');
        $query = $this->db->query('SELECT nama_pelajaran,kd_pelajaran FROM mata_pelajaran');
        $label = $query->result_array();
        $query = $this->db->query("SELECT kd_kelas, nama_kelas FROM kelas WHERE tingkat = '$tingkat' AND tahun_ajaran='$tahun_ajaran'");
        $kelas = $query->result_array();
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

        if ($data){
            $this->response($data,200);
        } else {
            $this->response('Not Found',404);
        }
    }
    
}



?>