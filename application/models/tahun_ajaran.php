<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class Tahun_ajaran extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function getCurrentTA(){
		$sql="SELECT * FROM tahun_ajaran ORDER BY id_tahun_ajaran DESC LIMIT 1";
		$query=$this->db->query($sql);
		$result = $query->first_row('array');

		return $result['id_tahun_ajaran'];
	}

	public function verifikasiSemester($value,$ta = null)
	{
		if ($ta == null)
			$verfiTA = true;
		else 
			$verfiTA = ($ta <= $this->getCurrentTA());
		return ($value == '1' or $value == '2' or $value == 1 or $value == 2 and $verfiTA);
	}

	public function cekSemester($value,$ta = null)
	{
		if (!$this->verifikasiSemester($value,$ta))
            redirect("users/login");
	}

	function newTA(){
		$data['tahun'] = (int)$this->getCurrentTA();
		$data['tahun']++;
		$tahun = $data['tahun'];
		$data['ket_tahun'] = (string)$data['tahun'] . "/" . ((string)$data['tahun']+1);

		$this->db->insert('tahun_ajaran',$data);
		$query = $this->db->query("UPDATE data_siswa SET tingkat = tingkat + 1 WHERE $tahun - tahun_masuk < 4");
		$sql = "UPDATE data_siswa SET status = '2' WHERE tingkat > 3";
		$query = $this->db->query($sql);
	}

	function tinggalKelas($id){
		$query = $this->db->query("SELECT tingkat FROM data_siswa WHERE kd_siswa = '$id' ");
		$result = $query->first_row();
		$tingkat = $result->tingkat;

		// die(); //mute
	
		$data = array();
		$data['kd_siswa'] = $id;
		$data['tahun_ajaran'] = $this->getCurrentTA();

		$this->db->insert('tinggal_kelas',$data);

		$tingkat = $tingkat - 1;
		$query = $this->db->query("UPDATE data_siswa SET tingkat = '$tingkat' WHERE kd_siswa='$id'");


	}


}
