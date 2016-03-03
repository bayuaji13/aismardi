<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class mata_pelajaran extends CI_Model {
	function __construct() {
		parent::__construct();
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

	public function getAllMapel()
	{
		return $this->db->query("SELECT * FROM mata_pelajaran");
	}

	public function getPengampu($kd_pelajaran,$tahun_ajaran,$kelas)
	{
		return $this->db->query("SELECT nama_guru FROM guru,pengampu WHERE guru.kd_guru=pengampu.kd_guru AND pengampu.kd_pelajaran='$kd_pelajaran' AND pengampu.tahun_ajaran='$tahun_ajaran' AND pengampu.kd_kelas='$kelas'");
	}

	public function getKKM($kd_pelajaran)
	{
		return $this->db->query("SELECT kkm FROM mata_pelajaran WHERE kd_pelajaran='$kd_pelajaran'");
	}

	public function getNamaMapel($kd_pelajaran)
	{	
		$query = $this->db->query("SELECT nama_pelajaran FROM mata_pelajaran WHERE kd_pelajaran='$kd_pelajaran'");
		$hasil = $query->first_row();
		return $hasil->nama_pelajaran;
	}

}
