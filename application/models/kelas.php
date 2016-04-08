<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class Kelas extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	// public function delete_user($nis) {
	// 	$this->db->where('nis', $nis);
	// 	if ($this->db->delete('data_siswa')) {
	// 		return true;
	// 	} else {
	// 		return false;
	// 	}
	// }
	// public function get_user_details($user) {
	// 	$this->db->where('user', $user);
	// 	return $this->db->get('users');
	// }

	public function getAllKelas()
	{
		$tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
		$query = $this->db->query("SELECT id_kelas,nama_kelas FROM tabel_kelas where tahun_ajaran = '$tahun_ajaran'");
		$hasil = $query->result_array();
		return $hasil;
	}

    public function process_create_kelas($data){
            if ($this->db->insert('tabel_kelas',$data)){
                    return  $this->db->insert_id();
            } else {
                    return FALSE;
            }
	}

	public function process_isi_kelas($data){
            if ($this->db->insert('tabel_kelas_siswa',$data)){
                    return TRUE;
            } else {
                    return FALSE;
            }
	}

	public function cekKelas($nama_kelas)
	{
		$ta = $this->tahun_ajaran->getCurrentTA();
		$query = $this->db->query("SELECT * FROM tabel_kelas WHERE nama_kelas='$nama_kelas' AND tahun_ajaran='$ta'");
		$hasil = $query->first_row();
		if ($hasil != null)
			return true;
		else
			return null;
	}

	public function getJurusanByKelas($id_kelas)
	{
		$ta = $this->tahun_ajaran->getCurrentTA();
		$query = $this->db->query("SELECT jurusan FROM tabel_kelas WHERE id_kelas='$id_kelas' AND tahun_ajaran='$ta'");
		$hasil = $query->first_row();
		return $hasil->jurusan;

	}

	public function naikKelas($id_siswa)
	{
		return $this->db->query("UPDATE tabel_siswa SET tingkat = tingkat + 1 WHERE id_siswa='$id_siswa'");
	}

	public function getKelasByWali($id_guru)
	{
		$ta = $this->tahun_ajaran->getCurrentTA();
		return $this->db->query("SELECT id_kelas,nama_kelas FROM tabel_kelas WHERE id_guru='$id_guru' and tahun_ajaran=$ta");
	}

	public function getKelasBySiswaByTahunAjaranByGuru($kd_siswa,$tahun_ajaran,$kd_guru=null)
	{
		return $this->db->query("SELECT kelas.nama_kelas as nama,kelas.kd_kelas FROM tabel_kelas,tabel_kelas_siswa 
									WHERE kelas.kd_kelas = kelas_siswa.kd_kelas 
									AND kelas_siswa.kd_siswa = '$kd_siswa'
									AND kelas_siswa.tahun_ajaran = '$tahun_ajaran'
									OR kelas.kd_guru = '$kd_guru'
									");
	}

	public function getNamaKelas($id_kelas)
	{
		$query = $this->db->query("SELECT nama_kelas FROM tabel_kelas WHERE id_kelas='$id_kelas'");
		$hasil = $query->first_row();
		return $hasil->nama_kelas;
	}

	public function getIsiKelas($kd_kelas)
	{
		$query = $this->db->query("SELECT kd_siswa FROM tabel_kelas_siswa WHERE kd_kelas='$kd_kelas'");
		$hasil = $query->result_array();
		return $hasil;

	}

	public function getJumlahSiswa($kd_kelas)
	{
		$query = $this->db->query("SELECT count(kd_siswa) AS jumlah FROM tabel_kelas_siswa WHERE kd_kelas='$kd_kelas'");
		$hasil = $query->first_row();
		return $hasil->jumlah;
	}
	// public function process_update_siswa($nis, $data) {
 //            $this->db->where('nis', $nis);
 //            if ($this->db->update('data_siswa', $data)) {
 //                return true;
 //            } else {
 //                return false;
 //            }
 //        }

    }
