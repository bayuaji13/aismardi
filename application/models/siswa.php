<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class siswa extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	public function get_all_siswa() {
		return $this->db->get('tabel_siswa');
	}
	public function delete_user($nis) {
		$this->db->where('nis', $nis);
		if ($this->db->delete('tabel_siswa')) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteSiswa($nis) {
		$this->db->where('nis', $nis);
		if ($this->db->delete('tabel_siswa')) {
			return true;
		} else {
			return false;
		}
	}
	
	public function get_user_details($user) {
		$this->db->where('user', $user);
		return $this->db->get('users');
	}

	public function getSiswa($id_siswa)
	{
		$query = $this->db->query("SELECT nama as nama_siswa,nis FROM tabel_siswa WHERE id_siswa='$id_siswa'");
		$hasil = $query->first_row('array');
		return $hasil;
	}

    public function process_create_siswa($data){
            if ($this->db->insert('tabel_siswa',$data)){
                    return $this->db->insert_id();
            } else {
                    return FALSE;
            }
	}
	public function cekSiswaDiKelas($nis)
	{
		$id_siswa = $this->nis2id_siswa($nis);
		$ta = $this->tahun_ajaran->getCurrentTA();
		$query = $this->db->query("SELECT * FROM tabel_kelas_siswa WHERE id_siswa='$id_siswa' AND tahun_ajaran='$ta'");
		$hasil = $query->first_row('array');
		if ($hasil != null)
			return $hasil;
		else
			return null;
	}

	public function getKelasSiswa($id_siswa,$tahun_ajaran)
	{
		$this->db->where('id_siswa',$id_siswa);
		$this->db->where('tahun_ajaran',$tahun_ajaran);
		$query = $this->db->get('tabel_kelas_siswa');
		$hasil = $query->first_row('array');
		$id_kelas = $hasil['id_kelas'];


		$this->db->where('id_kelas',$id_kelas);
		$query = $this->db->get('tabel_kelas');
		$hasil = $query->first_row('array');
		return $hasil;
	}

	public function getTingkat($kd_siswa)
	{
		$query = $this->db->query("SELECT tingkat FROM tabel_siswa WHERE kd_siswa='$kd_siswa'");
		$result = $query->first_row();
		return $result->tingkat;
	}
	public function process_update_siswa($nis, $data) {
            $this->db->where('nis', $nis);
            if ($this->db->update('tabel_siswa', $data)) {
                return true;
            } else {
                return false;
            }
        }

    public function nis2id_siswa($nis)
	{	
		$query = $this->db->query("SELECT id_siswa FROM tabel_siswa WHERE nis='$nis'");
		$result = $query->first_row();
		if ($result != null)
			return $result->id_siswa;
	}

	public function cekSiswa($nis)
	{
		$query = "SELECT * FROM tabel_siswa WHERE nis = '$nis'";
		$hasil = $this->db->query($query);
		$hasil = $hasil->first_row('array');
		if ($hasil != null)
			return true;
		else
			return false;
	}
	 public function get_siswa_bytipe($tipe){
		$query = $this->db->query("SELECT *, tabel_jenkel.jenis_kelamin
							FROM tabel_siswa, kelas_siswa, kelas, tabel_jenkel
							WHERE tabel_siswa.kd_siswa = kelas_siswa.kd_siswa
							AND tabel_siswa.jns_kelamin = tabel_jenkel.id_jekel
							AND kelas.kd_kelas=kelas_siswa.kd_kelas
							AND tabel_siswa.tipe = '$tipe'
							AND tabel_siswa.status = '1'");
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