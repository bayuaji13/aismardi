<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class Mata_pelajaran extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	public function getMapelByJurusan($id_jurusan,$tahun_ajaran)
	{
		$query =  $this->db->query("SELECT tabel_mapel.id_mapel, tabel_mapel.nama_mapel FROM tabel_mapel,tabel_mapel_jurusan 
								WHERE tabel_mapel.id_mapel = tabel_mapel_jurusan.id_mapel 
								AND tabel_mapel_jurusan.id_jurusan = $id_jurusan 
								AND tabel_mapel_jurusan.tahun_ajaran = $tahun_ajaran");
		$hasil = $query->result_array();
		return $hasil;
	}

	public function getMapelUNByJurusan($id_jurusan,$tahun_ajaran)
	{
		$query =  $this->db->query("SELECT tabel_mapel.id_mapel, tabel_mapel.nama_mapel FROM tabel_mapel,tabel_mapel_un 
								WHERE tabel_mapel.id_mapel = tabel_mapel_un.id_mapel 
								AND tabel_mapel_un.id_jurusan = $id_jurusan 
								AND tabel_mapel_un.tahun_ajaran = $tahun_ajaran");
		$hasil = $query->result_array();
		return $hasil;
	}


	public function setMapelUN($id_jurusan,$id_mapel)
	{
		$ta = $this->tahun_ajaran->getCurrentTA();
		$data['id_jurusan'] = $id_jurusan;
		$data['id_mapel'] = $id_mapel;
		$data['tahun_ajaran'] = $ta;
		$query = $this->db->query("SELECT * FROM tabel_mapel_un WHERE tahun_ajaran='$ta' AND id_mapel='$id_mapel' AND id_jurusan='$id_jurusan'");
		$hasil = $query->result();
		if ($hasil != null){
			$query = $this->db->query("DELETE FROM tabel_mapel_un WHERE tahun_ajaran='$ta' AND id_mapel='$id_mapel' AND id_jurusan='$id_jurusan'");
		}
		$this->db->insert('tabel_mapel_un',$data);
	}

	public function setMapelTahunan($id_jurusan,$id_mapel)
	{
		$ta = $this->tahun_ajaran->getCurrentTA();
		$data['id_jurusan'] = $id_jurusan;
		$data['id_mapel'] = $id_mapel;
		$data['tahun_ajaran'] = $ta;
		$query = $this->db->query("SELECT * FROM tabel_mapel_jurusan WHERE tahun_ajaran='$ta' AND id_mapel='$id_mapel' AND id_jurusan='$id_jurusan'");
		$hasil = $query->result();
		if ($hasil != null){
			$query = $this->db->query("DELETE FROM tabel_mapel_jurusan WHERE tahun_ajaran='$ta' AND id_mapel='$id_mapel' AND id_jurusan='$id_jurusan'");
		}
		$this->db->insert('tabel_mapel_jurusan',$data);
	}

	public function getAllMapel()
	{
		$query = $this->db->query("SELECT * FROM tabel_mapel");
		$hasil = $query->result_array();
		return $hasil;
	}


	public function getAllMapelOrderByKategori()
	{
		return $this->db->query("SELECT * FROM mata_pelajaran ORDER BY kd_kategori");
	}

	public function getAllMapelByKategori($cat)
	{
		return $this->db->query("SELECT * FROM mata_pelajaran WHERE kd_kategori='$cat'");
	}

	public function getAllCatName()
	{
		return $this->db->query("SELECT * FROM tabel_kategori_mapel ORDER BY kd_kategori");
	}
	public function getCatName($kd_kategori)
	{
		$query = $this->db->query("SELECT nama FROM tabel_kategori_mapel WHERE kd_kategori='$kd_kategori'");
		$hasil = $query->first_row('array');
		return $hasil['nama'];
	}

	// public function getAllMapel()
	// {
	// 	return $this->db->query("SELECT * FROM mata_pelajaran");
	// }

	public function getPengampu($kd_pelajaran,$tahun_ajaran,$kelas)
	{
		return $this->db->query("SELECT nama_guru FROM guru,pengampu WHERE guru.kd_guru=pengampu.kd_guru AND pengampu.kd_pelajaran='$kd_pelajaran' AND pengampu.tahun_ajaran='$tahun_ajaran' AND pengampu.kd_kelas='$kelas'");
	}

	public function getKKM($kd_pelajaran)
	{
		return $this->db->query("SELECT kkm FROM mata_pelajaran WHERE kd_pelajaran='$kd_pelajaran'");
	}

	public function getMapel($id_mapel)
	{	
		$query = $this->db->query("SELECT nama_mapel,kkm FROM tabel_mapel WHERE id_mapel='$id_mapel'");
		$hasil = $query->first_row('array');
		return $hasil;
	}

	public function getNamaMapel($id_mapel)
	{	
		$query = $this->db->query("SELECT nama_mapel FROM tabel_mapel WHERE id_mapel='$id_mapel'");
		$hasil = $query->first_row('array');
		return $hasil['nama_mapel'];
	}

}
