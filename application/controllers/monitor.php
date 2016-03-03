<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Monitor extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model('nilai');
    }

    public function overall10($value='')
    {
    	for ($i=1; $i <=3; $i++) { 
    		$array['data'][$i]['upper'] = $this->nilai->get_10_tingkat('top',$i);
    	}
    	for ($i=1; $i <=3; $i++) { 
    		$array['data'][$i]['lower'] = $this->nilai->get_10_tingkat('least',$i);
    	}
        $kosong = true;
        for ($i=1; $i <=3; $i++) { 
            $kosong = $kosong and ($array['data'][$i]['lower'] == null);
            $kosong = $kosong and ($array['data'][$i]['upper'] == null);
        }
        $kosong = false;
        if ($kosong) {
            $data['last_url'] = base_url().'users/home';
            $data['url'] = 'Belum ada data lengkap';
            $this->showHeader();
            $this->load->view('blank_page',$data);
            $this->load->view('footer_table');
        } else{
        	$this->showHeader();
        	$this->load->view('overall10',$array);
        	$this->load->view('footer_table');
        }
    }

    public function risky($tingkat)
    {
        for ($i=1; $i < 3; $i++) { 
            $array['data'][$i] = $this->nilai->get_lower($i,$tingkat);
        }
        // echo ($array['data'][2] == null);
        // print_r($array);
        $array['tingkat'] = $tingkat;
        $this->showHeader();
        $this->load->view('risky',$array);
        $this->load->view('footer_table');
    }

    public function prestasiMapel($tingkat){
        $query = $this->db->query("SELECT nama_pelajaran,kd_pelajaran FROM mata_pelajaran");
        $array['data']['tingkat'] = $tingkat;
        foreach ($query->result() as $mapel) {
            $array['data']['nama_mapel'][] = $mapel->nama_pelajaran;
            $array['data']['hasil'][] = $this->nilai->get_10_mapel('top',$tingkat,$mapel->kd_pelajaran);
        }
         // print_r($array);
         // die();
        $this->showHeader();
        $this->load->view('prestasi_mapel',$array);
        $this->load->view('footer_table');   
        // echo (0%3 == 0);
        // print_r($array);
        // $nana = $array['data']['nama_mapel'];
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */