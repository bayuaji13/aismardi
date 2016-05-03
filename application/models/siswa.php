<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class Siswa extends CI_Model {
	function __construct() {
		parent::__construct();
		$this->load->model('nilai_m');
	}
	public function get_all_siswa() {
		return $this->db->get('tabel_siswa');
	}
	public function delete_user($nisn) {
		$this->db->where('nisn', $nisn);
		if ($this->db->delete('tabel_siswa')) {
			return true;
		} else {
			return false;
		}
	}

	public function rangkaiDataSKHU($id_siswa)
	{
		$tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
		$data_kelas = $this->getKelasSiswa($id_siswa,$tahun_ajaran);
		$data['program_studi'] = "PROGRAM STUDI : ";
		if ($data_kelas['jurusan'] == 2){
			$data['program_studi'] .= "ILMU PENGETAHUAN ALAM";
		} elseif ($data_kelas['jurusan'] == 3) {
			$data['program_studi'] .= "ILMU PENGETAHUAN SOSIAL";
		}
		$data['tahun_ajaran'] = 'TAHUN PELAJARAN '.(string)$tahun_ajaran . ' / '. (string)($tahun_ajaran + 1);
		$data_siswa = $this->getDetailSiswa($id_siswa);
		$data['nama'] = $data_siswa['nama'];
		$data['ttl'] = $data_siswa['tempat_lahir'] .', '.$this->reKonversiTanggal($data_siswa['tanggal_lahir']);
		$data['nisn'] = $data_siswa['nisn'];

		$this->db->where('id_siswa',$id_siswa);
		$query = $this->db->get('tabel_peserta_un');


		$data['nomor_peserta'] = $query->first_row('array')['no_peserta_un'];
		if ($data_siswa['tingkat'] > 3){
			$string_lulus = "LULUS";
		} else {
			$string_lulus = "TIDAK LULUS";
		}

		$data['lulus'] = $string_lulus;

		$nilai = $this->nilai_m->getNilaiUN($id_siswa);
		$jumlah = 0;

		for ($i=0; $i < count($nilai); $i++) { 
			$nilai[$i]['nama_mapel'] = $this->mata_pelajaran->getNamaMapel($nilai[$i]['id_mapel']);
			$jumlah += $nilai[$i]['nilai'];
		}
		$data['jumlah'] = $jumlah;
		$data['nilai'] = $nilai;

		$this->db->where('id_tahun_ajaran',$tahun_ajaran);
		$query = $this->db->get('tahun_ajaran');
		$dataTambahan = $query->first_row('array');
		$data['nomor_peraturan'] = $dataTambahan['nomor_peraturan'];
		$data['tahun_peraturan'] = $dataTambahan['tahun_peraturan'];
		$data['kepala_sekolah'] = $dataTambahan['kepala_sekolah'];
		return $data;
	}

	public function reKonversiTanggal($value = null)
	{
		if ($value == null){
			return "";
		}
		$perkata = explode('-', $value);
		$daftar['01'] = 'Januari';
		$daftar['02'] = 'Februari';
		$daftar['03'] = 'Maret';
		$daftar['04'] = 'April';
		$daftar['05'] = 'Mei';
		$daftar['06'] = 'Juni';
		$daftar['07'] = 'Juli';
		$daftar['08'] = 'Agustus';
		$daftar['09'] = 'September';
		$daftar['10'] = 'Oktober';
		$daftar['11'] = 'November';
		$daftar['12'] = 'Desember';
		return $perkata[2]." ".$daftar[$perkata[1]]." ".$perkata[0];
	}
	public function setMenunggak($id_siswa)
	{
		$this->db->where('id_siswa',$id_siswa);
		$data['flag_tunggakan'] = 1;
		$this->db->update('tabel_siswa',$data);
	}

	public function setTidakMenunggak($id_siswa)
	{
		$this->db->where('id_siswa',$id_siswa);
		$data['flag_tunggakan'] = 0;
		$this->db->update('tabel_siswa',$data);
	}

	public function cekTunggakan($id_siswa)
	{
		$this->db->where('id_siswa',$id_siswa);
		$query = $this->db->select('flag_tunggakan')->get('tabel_siswa');
		$hasil = $query->first_row('array');
		return ($hasil['flag_tunggakan'] == 1);
	}

	public function cekWaktuDownloadSKHU()
	{
		$tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
		$this->db->where('id_tahun_ajaran',$tahun_ajaran)->where('NOW() > buka_skhu')->where('buka_skhu IS NOT NULL');
		$query = $this->db->get('tahun_ajaran');
		return ($query->result_array() != null);
	}

	public function cekBolehDownload($id_siswa)
	{
		$this->db->where('id_siswa',$id_siswa);
		$query = $this->db->select('flag_tunggakan')->get('tabel_siswa');
		$hasil = $query->first_row('array');
		$hasil = !($hasil['flag_tunggakan'] == 1);

		$query = $this->db->where('DATE(NOW()) BETWEEN tanggal_mulai and tanggal_akhir')->select('keterangan')->get('tabel_tanggal')->where('tanggal_mulai IS NOT NULL')->where('tanggal_akhir IS NOT NULL');
		$hasil2 = $query->first_row('array');
		$hasil2 = $hasil2['keterangan'];

		if ($hasil and $hasil2)
			return $hasil2;
		else
			return false;

	}


	public function deleteSiswa($nisn) {
		$this->db->where('nisn', $nisn);
		if ($this->db->delete('tabel_siswa')) {
			return true;
		} else {
			return false;
		}
	}

	public function batalKelulusan($tidak_lulus)
	{
		$data['tingkat'] = 3;
		$data['status'] = 1;
		$this->db->where('tingkat',4)->where('status',2)->where_in('id_siswa',$tidak_lulus);;
		$this->db->update('tabel_siswa',$data); 
	}

	public function kelulusan($tidak_lulus)
	{
		$data['tingkat'] = 4;
		$data['status'] = 2;
		$this->db->where('tingkat',3)->where('status',1)->where_not_in('id_siswa',$tidak_lulus);;
		$this->db->update('tabel_siswa',$data); 
	}

	public function isiKartuSiswa($data)
    {
        $berhasil = true;
        foreach ($data as $row) {
            if ($existed = $this->cekKartuSiswa($row)){ //kalo udah ada diupdate
                $this->db->where($existed);
                $berhasil = $berhasil AND $this->db->update('tabel_kartu',$row);
            } else {
                $berhasil = $berhasil AND $this->db->insert('tabel_kartu',$row);
            }
        }
        return $berhasil;
    }

    public function cekKartuSiswa($data)
    {
        $check['id_siswa'] = $data['id_siswa'];

        $this->db->where($check);
        $query = $this->db->get('tabel_kartu');
        if ($query->num_rows() == 1)
            return $check;
        else
            return FALSE;
    }


	public function isiNomorUN($data)
    {
        $berhasil = true;
        foreach ($data as $row) {
            if ($existed = $this->cekNomorUN($row)){ //kalo udah ada diupdate
                $this->db->where($existed);
                $berhasil = $berhasil AND $this->db->update('tabel_peserta_un',$row);
            } else {
                $berhasil = $berhasil AND $this->db->insert('tabel_peserta_un',$row);
            }
        }
        return $berhasil;
    }

    public function cekNomorUN($data)
    {
        $check['id_siswa'] = $data['id_siswa'];

        $this->db->where($check);
        $query = $this->db->get('tabel_peserta_un');
        if ($query->num_rows() == 1)
            return $check;
        else
            return FALSE;
    }
	
	public function get_user_details($user) {
		$this->db->where('user', $user);
		return $this->db->get('users');
	}

	public function getSiswa($id_siswa)
	{
		$query = $this->db->query("SELECT nama as nama_siswa,nisn FROM tabel_siswa WHERE id_siswa='$id_siswa'");
		$hasil = $query->first_row('array');
		return $hasil;
	}

	public function getDetailSiswa($id_siswa)
	{
		$query = $this->db->query("SELECT * FROM tabel_siswa WHERE id_siswa='$id_siswa'");
		$hasil = $query->first_row('array');
		return $hasil;
	}

	public function getSiswaByTingkat($tingkat)
	{
		$query = $this->db->query("SELECT nisn FROM tabel_siswa WHERE tingkat='$tingkat'");
		$hasil = $query->result_array();
		return $hasil;
	}

	public function isiAbsensi($id_siswa,$tanggal,$status,$semester,$tahun_ajaran)
	{
		$data['id_siswa'] = $id_siswa;
		$data['tanggal'] = $tanggal;
		$data['status'] = $status;
		$data['semester'] = $semester;
		$data['tahun_ajaran'] = $tahun_ajaran;

		return $this->db->insert('tabel_absensi',$data);
	}

	public function getAbsensi($id_siswa,$tahun_ajaran,$semester,$status)
	{
		$this->db->where('id_siswa',$id_siswa);
		$this->db->where('tahun_ajaran',$tahun_ajaran);
		$this->db->where('semester',$semester);
		$this->db->where('status',$status);
		$query = $this->db->select('tanggal')->get('tabel_absensi');

		$hasil['tanggal'] = $query->result_array();
		$hasil['jumlah'] = $query->num_rows();

		return $hasil;
	}

	public function konversiStatusAbsen($value)
	{
		if ($value == 1)
			return "Sakit";
		else if ($value == 2) {
			return "Izin";
		} else if ($value == 3) {
			return "Tanpa Keterangan";
		}
	}

	public function getAllAbsensi($id_siswa,$tahun_ajaran,$semester)
	{
		$this->db->where('id_siswa',$id_siswa);
		$this->db->where('tahun_ajaran',$tahun_ajaran);
		$this->db->where('semester',$semester);
		$query = $this->db->select('tanggal,status')->get('tabel_absensi');

		$hasil = $query->result_array();

		for ($i=0; $i < count($hasil); $i++) { 
			$hasil[$i]['keterangan'] = $this->konversiStatusAbsen($hasil[$i]['status']);
		}

		return $hasil;
	}


    public function process_create_siswa($data){
            if ($this->db->insert('tabel_siswa',$data)){
                    return $this->db->insert_id();
            } else {
                    return FALSE;
            }
	}

	public function process_update_siswa($id, $data) {
            $this->db->where('id_siswa', $id);
            if ($this->db->update('tabel_siswa', $data)) {
                return true;
            } else {
                return false;
            }
    }


	public function cekSiswaDiKelas($nisn)
	{
		$id_siswa = $this->nisn2id_siswa($nisn);
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
	public function process_update_siswa_($nisn, $data) {
            $this->db->where('nisn', $nisn);
            if ($this->db->update('tabel_siswa', $data)) {
                return true;
            } else {
                return false;
            }
        }

    public function nisn2id_siswa($nisn)
	{	
		$query = $this->db->query("SELECT id_siswa FROM tabel_siswa WHERE nisn='$nisn'");
		$result = $query->first_row();
		if ($result != null)
			return $result->id_siswa;
	}

	public function cekSiswa($nisn)
	{
		$query = "SELECT * FROM tabel_siswa WHERE nisn = '$nisn'";
		$hasil = $this->db->query($query);
		$hasil = $hasil->first_row('array');
		if ($hasil != null)
			return true;
		else
			return false;
	}
	 public function get_siswa_bytipe($tipe){
		$query = $this->db->query("SELECT *, tabel_jenkel.jenisn_kelamin
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