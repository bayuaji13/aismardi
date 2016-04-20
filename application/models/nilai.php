<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    class Nilai extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    
    public function process_create_nilai($data){
            if ($this->db->insert('tabel_nilai',$data)){
                    return TRUE;
            } else {
                    return FALSE;
            }
    }

    public function getNilaiBySiswaBySemesterByTahunAjaranByMapel($kd_siswa,$semester,$tahun_ajaran,$kd_pelajaran)
    {
        return $this->db->query("SELECT nilai FROM tabel_nilai WHERE kd_siswa='$kd_siswa' AND semester='$semester' AND tahun_ajaran='$tahun_ajaran' AND kd_pelajaran='$kd_pelajaran'");
    }

    public function getNilaiKI4BySiswaBySemesterByTahunAjaranByMapel($kd_siswa,$semester,$tahun_ajaran,$kd_pelajaran)
    {
        return $this->db->query("SELECT nilai_ki4 FROM tabel_nilai WHERE kd_siswa='$kd_siswa' AND semester='$semester' AND tahun_ajaran='$tahun_ajaran' AND kd_pelajaran='$kd_pelajaran'");
    }

    public function getNilaiKI1BySiswaBySemesterByTahunAjaranByMapel($kd_siswa,$semester,$tahun_ajaran,$kd_pelajaran)
    {
        return $this->db->query("SELECT nilai_ki1 FROM tabel_nilai WHERE kd_siswa='$kd_siswa' AND semester='$semester' AND tahun_ajaran='$tahun_ajaran' AND kd_pelajaran='$kd_pelajaran'");
    }

    public function getRerataKelasPerwalianByPelajaranBySemesterByTahunAjaran($kd_guru,$semester,$kd_pelajaran,$tahun_ajaran)
    {
        return $this->db->query("SELECT AVG(tabel_nilai.nilai) AS rerata FROM tabel_nilai WHERE 
                                tabel_nilai.kd_pelajaran ='$kd_pelajaran' AND semester='$semester' AND tabel_nilai.kd_siswa IN (SELECT kelas_siswa.kd_siswa FROM kelas_siswa WHERE kelas_siswa.kd_kelas IN 
                                    (SELECT kelas.kd_kelas FROM kelas WHERE kd_guru='$kd_guru')) AND tabel_nilai.tahun_ajaran = '$tahun_ajaran'");
    }

    public function get_10_mapel($tipe,$tingkat,$kd_mapel)
    {
        $data = array();
        $tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
        if ($tipe == 'top'){
            $query = $this->db->query("SELECT tabel_nilai.kd_siswa, data_siswa.nis, data_siswa.nama_siswa, AVG(tabel_nilai.nilai) as rerata 
                                        FROM tabel_nilai,data_siswa 
                                        WHERE tabel_nilai.tahun_ajaran = '$tahun_ajaran' 
                                        AND tabel_nilai.kd_siswa = data_siswa.kd_siswa 
                                        AND tabel_nilai.kd_pelajaran='$kd_mapel' 
                                        AND data_siswa.tingkat='$tingkat' AND data_siswa.status='1' 
                                        GROUP BY data_siswa.kd_siswa 
                                        ORDER BY rerata DESC LIMIT 0,10");    
        } elseif ($tipe == 'least') {
            $query = $this->db->query("SELECT tabel_nilai.kd_siswa, data_siswa.nis, data_siswa.nama_siswa, AVG(tabel_nilai.nilai) as rerata FROM tabel_nilai,data_siswa WHERE tabel_nilai.kd_siswa = data_siswa.kd_siswa AND tabel_nilai.kd_pelajaran='$kd_mapel' AND data_siswa.tingkat='$tingkat' AND data_siswa.status='1' GROUP BY data_siswa.kd_siswa ORDER BY rerata LIMIT 0,10");    
        }
        foreach ($query->result() as $row) {
            $data[] = array('kd_siswa' => $row->kd_siswa,'nis' => $row->nis ,'nama_siswa' => $row->nama_siswa,'rerata' => round($row->rerata,2));
        }
        return $data;
    }

    public function get_10_mapel_santri($tipe,$tingkat,$kd_mapel)
    {
        $data = array();
        $tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
        if ($tipe == 'top'){
            $query = $this->db->query("SELECT tabel_nilai.kd_siswa, data_siswa.nis, data_siswa.nama_siswa, AVG(tabel_nilai.nilai) as rerata 
                                        FROM tabel_nilai,data_siswa 
                                        WHERE tabel_nilai.tahun_ajaran = '$tahun_ajaran' 
                                        AND tabel_nilai.kd_siswa = data_siswa.kd_siswa 
                                        AND tabel_nilai.kd_pelajaran='$kd_mapel' 
                                        AND data_siswa.tingkat='$tingkat' AND data_siswa.status='1'
                                        AND data_siswa.tipe='2' 
                                        GROUP BY data_siswa.kd_siswa 
                                        ORDER BY rerata DESC LIMIT 0,10");    
        } elseif ($tipe == 'least') {
            $query = $this->db->query("SELECT tabel_nilai.kd_siswa, data_siswa.nis, data_siswa.nama_siswa, AVG(tabel_nilai.nilai) as rerata FROM tabel_nilai,data_siswa WHERE tabel_nilai.kd_siswa = data_siswa.kd_siswa AND tabel_nilai.kd_pelajaran='$kd_mapel' AND data_siswa.tingkat='$tingkat' AND data_siswa.status='1' GROUP BY data_siswa.kd_siswa ORDER BY rerata LIMIT 0,10");    
        }
        foreach ($query->result() as $row) {
            $data[] = array('kd_siswa' => $row->kd_siswa,'nis' => $row->nis ,'nama_siswa' => $row->nama_siswa,'rerata' => round($row->rerata,2));
        }
        return $data;
    }

    public function get_10_tingkat($tipe,$tingkat)
    {
        $data = array();
        $tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
        if ($tipe == 'top'){
            $query = $this->db->query("SELECT tabel_nilai.kd_siswa, data_siswa.nis, data_siswa.nama_siswa, AVG(tabel_nilai.nilai) as rerata FROM tabel_nilai,data_siswa WHERE tabel_nilai.tahun_ajaran = '$tahun_ajaran' AND tabel_nilai.kd_siswa = data_siswa.kd_siswa  AND data_siswa.tingkat='$tingkat' AND data_siswa.status='1' GROUP BY data_siswa.kd_siswa ORDER BY rerata DESC LIMIT 0,10");    
        } elseif ($tipe == 'least') {
            $query = $this->db->query("SELECT tabel_nilai.kd_siswa, data_siswa.nis, data_siswa.nama_siswa, AVG(tabel_nilai.nilai) as rerata FROM tabel_nilai,data_siswa WHERE tabel_nilai.tahun_ajaran = '$tahun_ajaran' AND tabel_nilai.kd_siswa = data_siswa.kd_siswa  AND data_siswa.tingkat='$tingkat' AND data_siswa.status='1' GROUP BY data_siswa.kd_siswa ORDER BY rerata LIMIT 0,10");    
        }
        foreach ($query->result() as $row) {
            $data[] = array('kd_siswa' => $row->kd_siswa,'nis' => $row->nis ,'nama_siswa' => $row->nama_siswa,'rerata' => round($row->rerata,2));
        }
        return $data;
    }

    public function get_10_tingkat_santri($tipe,$tingkat)
    {
        $tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
        $data = array();
        if ($tipe == 'top'){
            $query = $this->db->query("SELECT tabel_nilai.kd_siswa, data_siswa.nis, data_siswa.nama_siswa, AVG(tabel_nilai.nilai) as rerata FROM tabel_nilai,data_siswa WHERE tabel_nilai.tahun_ajaran = '$tahun_ajaran' AND tabel_nilai.kd_siswa = data_siswa.kd_siswa AND data_siswa.tipe = '2'  AND data_siswa.tingkat='$tingkat' AND data_siswa.status='1' GROUP BY data_siswa.kd_siswa ORDER BY rerata DESC LIMIT 0,10");    
        } elseif ($tipe == 'least') {
            $query = $this->db->query("SELECT tabel_nilai.kd_siswa, data_siswa.nis, data_siswa.nama_siswa, AVG(tabel_nilai.nilai) as rerata FROM tabel_nilai,data_siswa WHERE tabel_nilai.tahun_ajaran = '$tahun_ajaran' AND tabel_nilai.kd_siswa = data_siswa.kd_siswa AND data_siswa.tipe = '2'  AND data_siswa.tingkat='$tingkat' AND data_siswa.status='1' GROUP BY data_siswa.kd_siswa ORDER BY rerata LIMIT 0,10");    
        }
        foreach ($query->result() as $row) {
            $data[] = array('kd_siswa' => $row->kd_siswa,'nis' => $row->nis ,'nama_siswa' => $row->nama_siswa,'rerata' => round($row->rerata,2));
        }
        return $data;
    }

    public function get_lower($semester,$tingkat)
    {
        $data = array();
        $tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
        $query = $this->db->query("SELECT * FROM 
                                            (SELECT data_siswa.kd_siswa, data_siswa.nis, data_siswa.nama_siswa, COUNT(tabel_nilai.nilai) as jumlah 
                                                FROM data_siswa,tabel_nilai,mata_pelajaran 
                                                WHERE data_siswa.kd_siswa = tabel_nilai.kd_siswa 
                                                AND data_siswa.status = '1'
                                                AND data_siswa.tingkat = '$tingkat'
                                                AND tabel_nilai.kd_pelajaran = mata_pelajaran.kd_pelajaran 
                                                AND tabel_nilai.semester = '$semester' 
                                                AND tabel_nilai.nilai < mata_pelajaran.kkm 
                                                AND tabel_nilai.tahun_ajaran = '$tahun_ajaran'
                                                GROUP BY tabel_nilai.kd_siswa
                                            ) hasil WHERE jumlah > 3
                                    ");
        foreach ($query->result() as $row) {
            $data[] = array('kd_siswa' => $row->kd_siswa,'nis' => $row->nis,'nama_siswa' => $row->nama_siswa,'jumlah' => $row->jumlah);
        }
        return $data;
    }

    public function get_lower_santri($semester,$tingkat)
    {
        $data = array();
        $tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
        $query = $this->db->query("SELECT * FROM 
                                            (SELECT data_siswa.kd_siswa, data_siswa.nis, data_siswa.nama_siswa, COUNT(tabel_nilai.nilai) as jumlah 
                                                FROM data_siswa,tabel_nilai,mata_pelajaran 
                                                WHERE data_siswa.kd_siswa = tabel_nilai.kd_siswa 
                                                AND data_siswa.status = '1'
                                                AND data_siswa.tipe = '2'
                                                AND data_siswa.tingkat = '$tingkat'
                                                AND tabel_nilai.kd_pelajaran = mata_pelajaran.kd_pelajaran 
                                                AND tabel_nilai.semester = '$semester' 
                                                AND tabel_nilai.nilai < mata_pelajaran.kkm 
                                                AND tabel_nilai.tahun_ajaran = '$tahun_ajaran'
                                                GROUP BY tabel_nilai.kd_siswa
                                            ) hasil WHERE jumlah > 3
                                    ");
        foreach ($query->result() as $row) {
            $data[] = array('kd_siswa' => $row->kd_siswa,'nis' => $row->nis,'nama_siswa' => $row->nama_siswa,'jumlah' => $row->jumlah);
        }
        return $data;
    }
  

    public function get_nilai_bytingkat($tingkat, $kd_pelajaran)
    {
        # code...
        $tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
        $query = $this->db->query("SELECT avg(nilai) as rerata,count(*) as jumlah_total FROM tabel_nilai WHERE tabel_nilai.kd_siswa IN (SELECT data_siswa.kd_siswa FROM data_siswa WHERE tingkat = $tingkat)AND tahun_ajaran='$tahun_ajaran' AND kd_pelajaran = '$kd_pelajaran'");
        $result = $query->first_row('array');
        $avg = $result['rerata'];
        if ($avg == NULL){
            $avg = 0;
        }
        $ndata = $result['jumlah_total'];
        $query = $this->db->query("SELECT count(*) as jumlah_lebih_rerata FROM tabel_nilai WHERE tabel_nilai.kd_siswa IN (SELECT data_siswa.kd_siswa FROM data_siswa WHERE tingkat = $tingkat) AND tahun_ajaran='$tahun_ajaran' AND kd_pelajaran = '$kd_pelajaran' AND tabel_nilai.nilai >= $avg");
        $result = $query->first_row('array');
        $nhigher = $result['jumlah_lebih_rerata'];
        $nlower = $ndata - $nhigher;
        $hasil = '';
        $hasil['nhigher'] = $nhigher;
        $hasil['nlower'] = $nlower;
        return $hasil;  
    }

    public function get_nilai_bytingkat_santri($tingkat, $kd_pelajaran)
    {
        # code...
        $tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
        $query = $this->db->query("SELECT avg(nilai) as rerata,count(*) as jumlah_total FROM tabel_nilai WHERE tabel_nilai.kd_siswa IN (SELECT data_siswa.kd_siswa FROM data_siswa WHERE tingkat = $tingkat)AND tahun_ajaran='$tahun_ajaran' AND kd_pelajaran = '$kd_pelajaran'");
        $result = $query->first_row('array');
        $avg = $result['rerata'];
        if ($avg == NULL){
            $avg = 0;
        }
        $ndata = $result['jumlah_total'];
        $query = $this->db->query("SELECT count(*) as jumlah_lebih_rerata FROM tabel_nilai WHERE tabel_nilai.kd_siswa IN (SELECT data_siswa.kd_siswa FROM data_siswa WHERE tingkat = $tingkat AND data_siswa.tipe = '2') AND tahun_ajaran='$tahun_ajaran' AND kd_pelajaran = '$kd_pelajaran' AND tabel_nilai.nilai >= $avg");
        $result = $query->first_row('array');
        $nhigher = $result['jumlah_lebih_rerata'];
        $nlower = $ndata - $nhigher;
        $hasil = '';
        $hasil['nhigher'] = $nhigher;
        $hasil['nlower'] = $nlower;
        return $hasil;  
    }

    public function get_nilai_bytingkat_bymapel($tingkat, $mapel){
    	$tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
        $query = $this->db->query("SELECT avg(nilai) as rerata, count(*) as jumlah_total FROM tabel_nilai WHERE tabel_nilai.kd_siswa IN (SELECT data_siswa.kd_siswa FROM data_siswa WHERE tingkat = $tingkat AND tabel_nilai.kd_pelajaran IN (SELECT mata_pelajaran.kd_pelajaran FROM mata_pelajaran WHERE kd_pelajaran = $mapel)) AND tahun_ajaran='$tahun_ajaran'");
        $result = $query->first_row('array');
        $avg = $result['rerata'];
        if ($avg == NULL){
            $avg = 0;
        }
        $ndata = $result['jumlah_total'];
        $query = $this->db->query("SELECT count(*) as jumlah_lebih_rerata FROM tabel_nilai WHERE tabel_nilai.kd_siswa IN (SELECT data_siswa.kd_siswa FROM data_siswa WHERE tingkat = $tingkat AND tabel_nilai.kd_pelajaran IN (SELECT mata_pelajaran.kd_pelajaran FROM mata_pelajaran WHERE kd_pelajaran = $mapel)) AND tahun_ajaran='$tahun_ajaran' AND tabel_nilai.nilai >= $avg");
        $result = $query->first_row('array');
        $nhigher = $result['jumlah_lebih_rerata'];
        $nlower = $ndata - $nhigher;
        $hasil = '';
        $hasil['nhigher'] = $nhigher;
        $hasil['nlower'] = $nlower;
        return $hasil;
    }

    public function get_nilai_bytingkat_bymapel_bykelas($tingkat, $mapel, $kelas){
        $tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
        $query = $this->db->query("SELECT avg(nilai) as rerata, count(*) jumlah_total FROM tabel_nilai WHERE tabel_nilai.kd_siswa IN (SELECT data_siswa.kd_siswa FROM data_siswa WHERE tingkat = '$tingkat' AND tabel_nilai.kd_pelajaran IN (SELECT mata_pelajaran.kd_pelajaran FROM mata_pelajaran WHERE kd_pelajaran = '$mapel' AND tabel_nilai.kd_kelas = '$kelas')) AND tahun_ajaran='$tahun_ajaran'");
        $result = $query->first_row('array');
        $avg = $result['rerata'];
        // die($avg==null);
        if ($avg == NULL){
            $avg = 0;
        }
        $ndata = $result['jumlah_total'];
        $query = $this->db->query("SELECT count(*) as jumlah_lebih_rerata FROM tabel_nilai WHERE tabel_nilai.kd_siswa IN (SELECT data_siswa.kd_siswa FROM data_siswa WHERE tingkat = $tingkat AND tabel_nilai.kd_pelajaran IN (SELECT mata_pelajaran.kd_pelajaran FROM mata_pelajaran WHERE kd_pelajaran = $mapel AND tabel_nilai.kd_kelas = $kelas)) AND tahun_ajaran='$tahun_ajaran' AND tabel_nilai.nilai >= $avg");
        $result = $query->first_row('array');
        $nhigher = $result['jumlah_lebih_rerata'];
        $nlower = $ndata - $nhigher;
        $hasil = '';
        $hasil['nhigher'] = $nhigher;
        $hasil['nlower'] = $nlower;
        return $hasil;
    }

    public function get_nilai_bytingkat_bymapel_bykelas_santri($tingkat, $mapel, $kelas){
    	$tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
        $query = $this->db->query("SELECT avg(nilai) as rerata, count(*) jumlah_total FROM tabel_nilai WHERE tabel_nilai.kd_siswa IN (SELECT data_siswa.kd_siswa FROM data_siswa WHERE tingkat = '$tingkat' AND tabel_nilai.kd_pelajaran IN (SELECT mata_pelajaran.kd_pelajaran FROM mata_pelajaran WHERE kd_pelajaran = '$mapel' AND tabel_nilai.kd_kelas = '$kelas')) AND tahun_ajaran='$tahun_ajaran'");
        $result = $query->first_row('array');
        $avg = $result['rerata'];
        // die($avg==null);
        if ($avg == NULL){
            $avg = 0;
        }
        $ndata = $result['jumlah_total'];
        $query = $this->db->query("SELECT count(*) as jumlah_lebih_rerata FROM tabel_nilai 
                    WHERE tabel_nilai.kd_siswa IN 
                    (SELECT data_siswa.kd_siswa FROM data_siswa WHERE tingkat = $tingkat AND data_siswa.tipe = '2' AND 
                        tabel_nilai.kd_pelajaran IN 
                            (SELECT mata_pelajaran.kd_pelajaran FROM mata_pelajaran WHERE kd_pelajaran = $mapel AND tabel_nilai.kd_kelas = $kelas)) 
                            AND tahun_ajaran='$tahun_ajaran' AND tabel_nilai.nilai >= $avg");
        $result = $query->first_row('array');
        $nhigher = $result['jumlah_lebih_rerata'];
        $nlower = $ndata - $nhigher;
        $hasil = '';
        $hasil['nhigher'] = $nhigher;
        $hasil['nlower'] = $nlower;
        return $hasil;
    }

    public function getCompletion($tahun_ajaran)
    {
        $query = $this->db->query("SELECT count(kd_siswa) as jumlah FROM data_siswa WHERE status='1'");
        $result = $query->first_row();
        $data['total_nilai'] = $result->jumlah;

        $query = $this->db->query("SELECT count(*) as jumlah FROM mata_pelajaran");
        $result = $query->first_row();
        $data['total_nilai'] = $data['total_nilai'] * 2 * $result->jumlah;

        $query = $this->db->query("SELECT count(*) as jumlah FROM tabel_nilai WHERE tahun_ajaran='$tahun_ajaran'");
        $result = $query->first_row();
        $data['terisi'] = $result->jumlah;

        // print_r($data);
        // die();

        return $data;
    }
	public function get_nilai_bytipe($tipe){
        $query = $this->db->query("SELECT tabel_nilai.nilai, data_siswa.kd_siswa, data_siswa.nama_siswa, data_siswa.tingkat, mata_pelajaran.nama_pelajaran, data_siswa.nis
                                    FROM tabel_nilai, data_siswa, mata_pelajaran
                                    WHERE data_siswa.kd_siswa = tabel_nilai.kd_siswa 
                                    AND tabel_nilai.kd_pelajaran = mata_pelajaran.kd_pelajaran
                                    AND data_siswa.tipe ='$tipe'");
        // $data = $query->db->where('tipe', $tipe);
        $result = $query;
        return $result->result(); 
    }


}
