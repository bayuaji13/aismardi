<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class Wali extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	public function getSiswaPerwalian($kd_guru)
	{
		$ta = $this->tahun_ajaran->getCurrentTA();
		return $this->db->query("SELECT data_siswa.kd_siswa as kd_siswa, data_siswa.nis AS nis, data_siswa.nama_siswa AS nama FROM data_siswa WHERE 
								data_siswa.kd_siswa IN (SELECT kelas_siswa.kd_siswa FROM kelas_siswa WHERE kelas_siswa.kd_kelas IN 
									(SELECT kelas.kd_kelas FROM kelas WHERE kd_guru='$kd_guru') AND kelas_siswa.tahun_ajaran = $ta)");
	}

	public function getKelasPerwalian($kd_guru,$tahun_ajaran)
	{
		$query = $this->db->query("SELECT kd_kelas FROM kelas WHERE kd_guru='$kd_guru' AND tahun_ajaran='$tahun_ajaran'");
		if ($query->num_rows() > 0) {
		    $hasil =  $query->first_row();
		    return $hasil->kd_kelas;
		}

	}

	public function verifikasiGuru($kd_guru,$kd_kelas,$tahun_ajaran)
	{
		$query = $this->db->query("SELECT kd_kelas FROM kelas WHERE kd_guru='$kd_guru' AND tahun_ajaran='$tahun_ajaran'");
		if ($query->num_rows() > 0) {
		    $hasil =  $query->first_row();
		    return ($hasil->kd_kelas == $kd_kelas);
		} else {
			return false;
		}
	}
}