<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class siswa extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	public function get_all_siswa() {
		return $this->db->get('data_siswa');
	}
	public function delete_user($nis) {
		$this->db->where('nis', $nis);
		if ($this->db->delete('data_siswa')) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteSiswa($nis) {
		$this->db->where('nis', $nis);
		if ($this->db->delete('data_siswa')) {
			return true;
		} else {
			return false;
		}
	}
	
	public function get_user_details($user) {
		$this->db->where('user', $user);
		return $this->db->get('users');
	}

	public function getSiswa($kd_siswa)
	{
		return $this->db->query("SELECT nama_siswa,nis FROM data_siswa WHERE kd_siswa='$kd_siswa'");
	}

    public function process_create_siswa($data){
            if ($this->db->insert('data_siswa',$data)){
                    return $this->db->insert_id();
            } else {
                    return FALSE;
            }
	}

	public function getTingkat($kd_siswa)
	{
		$query = $this->db->query("SELECT tingkat FROM data_siswa WHERE kd_siswa='$kd_siswa'");
		$result = $query->first_row();
		return $result->tingkat;
	}
	public function process_update_siswa($nis, $data) {
            $this->db->where('nis', $nis);
            if ($this->db->update('data_siswa', $data)) {
                return true;
            } else {
                return false;
            }
        }

    public function nis2kd_siswa($nis)
	{	
		$query = $this->db->query("SELECT kd_siswa FROM data_siswa WHERE nis='$nis'");
		$result = $query->first_row();
		return $result->kd_siswa;
	}

	public function cekSiswa($nis)
	{
		$query = "SELECT * FROM data_siswa WHERE nis = '$nis'";
		$hasil = $this->db->query($query);
		if ($hasil->num_rows >= 1)
			return true;
		else
			return false;
	}
	 public function get_siswa_bytipe($tipe){
		$query = $this->db->query("SELECT *, tabel_jenkel.jenis_kelamin
							FROM data_siswa, kelas_siswa, kelas, tabel_jenkel
							WHERE data_siswa.kd_siswa = kelas_siswa.kd_siswa
							AND data_siswa.jns_kelamin = tabel_jenkel.id_jekel
							AND kelas.kd_kelas=kelas_siswa.kd_kelas
							AND data_siswa.tipe = '$tipe'
							AND data_siswa.status = '1'");
		$result = $query;
		return $result->result(); 
	}

	public function get_jadwal($kelas){
			$query = $this->db->query("SELECT jadwal.jam, mata_pelajaran.nama_pelajaran, tabel_hari.nama_hari, guru.nama_guru, kelas.nama_kelas
                                    FROM jadwal, mata_pelajaran, guru, tabel_hari, kelas
                                    WHERE mata_pelajaran.kd_pelajaran = jadwal.kd_pelajaran
                                    AND guru.kd_guru = jadwal.kd_guru
                                    AND tabel_hari.id_hari = jadwal.hari
                                    AND kelas.kd_kelas =jadwal.kd_kelas
                                    AND jadwal.kd_kelas= '$kelas'");

			$result = $query;
       		return $result->result();
		}
}