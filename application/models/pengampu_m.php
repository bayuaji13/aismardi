<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pengampu_m extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	public function nip2id_guru($nip)
	{
		$query = $this->db->query("SELECT id_guru FROM tabel_guru WHERE nip='$nip'");
		$hasil = $query->first_row();
		if ($hasil != null)
			return $hasil->id_guru;
		else
			return null;
	}

	public function isWali($id_guru)
	{
		$tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
		$this->db->where('id_guru',$id_guru);
		$this->db->where('tahun_ajaran',$tahun_ajaran);
		$query = $this->db->get('tabel_kelas');
		if ($query->result() != null)
			return true;
		else
			return false;
	}

	public function isGuruBP($id_guru)
	{
		$tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
		$this->db->where('id_guru',$id_guru);
		$this->db->where('tahun_ajaran',$tahun_ajaran);
		$this->db->where('id_mapel',4);
		$query = $this->db->get('tabel_pengampu');
		if ($query->result() != null)
			return true;
		else
			return false;
	}

	public function getKelasDanMapelAmpu($kd_guru)
	{
		$tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
		$query = $this->db->query("SELECT id_kelas,id_mapel FROM tabel_pengampu WHERE id_guru='$kd_guru' AND tahun_ajaran='$tahun_ajaran' ");
		// AND semester='$semester'"
		$hasil = $query->result_array();
		$returned = array();
		$i = 0;
		foreach ($hasil as $row) {
			$returned[$i]['id_kelas'] = $row['id_kelas'];
			$returned[$i]['id_mapel'] = $row['id_mapel'];
			$i++;
		}

		return $returned;

	}

	public function getKelasDanMapelAmpuV2($kd_guru,$tahun_ajaran)
	{
		$query = $this->db->query("SELECT kd_kelas,kd_pelajaran FROM pengampu WHERE kd_guru='$kd_guru' AND tahun_ajaran='$tahun_ajaran'");
		// AND semester='$semester'"
		$hasil = $query->result_array();
		$returned = array();
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

	public function setPengampu($id_kelas,$id_mapel,$id_guru)
	{
		$data['tahun_ajaran'] = $this->tahun_ajaran->getCurrentTA(); 
		$data['id_kelas'] = $id_kelas;
		$data['id_mapel'] = $id_mapel;
		$data['id_guru'] = $id_guru;
		if ($id_entry = $this->cekPengampu($id_kelas,$id_mapel)){
			$this->db->where('id_entry',$id_entry);
			return $this->db->update('tabel_pengampu', $data);
		} else {
			return $this->db->insert('tabel_pengampu', $data);
		}
	}

	public function cekStatusAmpu($id_guru,$id_kelas,$id_mapel)
	{
		$tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
		$this->db->where('id_guru',$id_guru);
		$this->db->where('id_kelas',$id_kelas);
		$this->db->where('id_mapel',$id_mapel);
		$this->db->where('tahun_ajaran',$tahun_ajaran);
		$query = $this->db->get('tabel_pengampu');
		if ($query->result_array() != null){
			return true;
		} else
			return false;
	}

	public function cekPengampu($id_kelas,$id_mapel)
	{
		$ta = $this->tahun_ajaran->getCurrentTA();
		$query = $this->db->query("SELECT * FROM tabel_pengampu WHERE id_kelas='$id_kelas' AND id_mapel='$id_mapel' AND tahun_ajaran='$ta'");
		$hasil = $query->first_row();
		if ($hasil != null){
			return $hasil->id_guru;
		} else
			return false;
	}

	public function cekGuru($nip)
	{
		$query = $this->db->query("SELECT * FROM tabel_guru WHERE nip='$nip'");
		$hasil = $query->first_row();
		if ($hasil != null){
			return true;
		} else
			return false;
	}

	public function getPengampu($id_guru)
	{
		$query = $this->db->where('id_guru',$id_guru)->get('tabel_guru');
		$hasil = $query->first_row('array');
		return $hasil;
	}

	public function getAllGuru()
	{
		// $ta = $this->tahun_ajaran->getCurrentTA();
		$query = $this->db->query("SELECT id_guru,nama FROM tabel_guru GROUP BY id_guru ORDER BY id_guru");
		$hasil = $query->result_array();
		return $hasil;
	}

	public function getNamaPengampu($kd_guru)
	{
		$query = $this->db->query("SELECT nama_guru FROM guru WHERE kd_guru = '$kd_guru'");
		$hasil = $query->first_row();
		return $hasil->nama_guru;
	}

}