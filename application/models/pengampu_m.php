<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class pengampu_m extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	public function getKelasDanMapelAmpu($kd_guru,$tahun_ajaran)
	{
		$query = $this->db->query("SELECT kd_kelas,kd_pelajaran FROM pengampu WHERE kd_guru='$kd_guru' AND tahun_ajaran='$tahun_ajaran' ");
		// AND semester='$semester'"
		$hasil = $query->result_array();
		$returned = [];
		$i = 0;
		foreach ($hasil as $row) {
			$returned[$i]['kd_kelas'] = $row['kd_kelas'];
			$returned[$i]['kd_pelajaran'] = $row['kd_pelajaran'];
			$i++;
		}

		return $returned;

	}

	public function getKelasDanMapelAmpuV2($kd_guru,$tahun_ajaran)
	{
		$query = $this->db->query("SELECT kd_kelas,kd_pelajaran FROM pengampu WHERE kd_guru='$kd_guru' AND tahun_ajaran='$tahun_ajaran'");
		// AND semester='$semester'"
		$hasil = $query->result_array();
		$returned = [];
		$i = 0;
		foreach ($hasil as $row) {
			$returned['kd_kelas'][$i] = $row['kd_kelas'];
			$returned['kd_pelajaran'][$i] = $row['kd_pelajaran'];
			$i++;
		}

		return $returned;

	}

	public function getAllPengampu($tahun_ajaran)
	{
		$query = $this->db->query("SELECT kd_guru FROM pengampu WHERE tahun_ajaran='$tahun_ajaran' GROUP BY kd_guru ORDER BY kd_guru");
		return $query->result_array();
	}


	public function getNamaPengampu($kd_guru)
	{
		$query = $this->db->query("SELECT nama_guru FROM guru WHERE kd_guru = '$kd_guru'");
		$hasil = $query->first_row();
		return $hasil->nama_guru;
	}

}