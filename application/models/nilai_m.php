<?php
class Nilai_m extends CI_Model
{
    public function isiNilaiSiswa($data)
    {
        $berhasil = true;
        foreach ($data as $row) {
            if ($existed = $this->cekNilai($row)){ //kalo udah ada diupdate
                $this->db->where($existed);
                $berhasil = $berhasil AND $this->db->update('tabel_nilai_rapor',$row);
            } else {
                $berhasil = $berhasil AND $this->db->insert('tabel_nilai_rapor',$row);
            }
        }
        return $berhasil;
    }

    public function cekNilai($data)
    {
        $check['id_siswa'] = $data['id_siswa'];
        $check['id_mapel'] = $data['id_mapel'];
        $check['tahun_ajaran'] = $data['tahun_ajaran'];
        $check['semester'] = $data['semester'];

        $this->db->where($check);
        $query = $this->db->get('tabel_nilai_rapor');
        if ($query->num_rows() == 1)
            return $check;
        else
            return FALSE;
    }

    public function getNilaiRapor($id_siswa,$tahun_ajaran,$semester)
    {
        $this->db->where('id_siswa',$id_siswa);
        $this->db->where('semester',$semester);
        $this->db->where('tahun_ajaran',$tahun_ajaran);
        $query = $this->db->get('tabel_nilai_rapor');
        $hasil = $query->result_array();

        for ($i=0; $i < count($hasil); $i++) { 
            $mapel = $this->mata_pelajaran->getMapel($hasil[$i]['id_mapel']);
            $hasil[$i]['nama_mapel'] = $mapel['nama_mapel'];
            $hasil[$i]['kkm'] = $mapel['kkm'];
        }

        return $hasil;

    }

    public function isiNilaiPengembangan($nilai_ekskul,$nilai_organisasi)
    {
        $row_ekskul = array_filter($nilai_ekskul);
        $row_organisasi = array_filter($nilai_organisasi);
        

        $row_ekskul['nama_kegiatan'] = $row_ekskul['nama_kegiatan_lama'];
        $row_organisasi['nama_organisasi'] = $row_organisasi['nama_organisasi_lama'];

        unset($row_ekskul['nama_kegiatan_lama']);
        unset($row_organisasi['nama_organisasi_lama']);

        unset($row_ekskul['ket_kegiatan']);
        unset($row_ekskul['nilai_kegiatan']);

        unset($row_organisasi['ket_organisasi']);
        unset($row_organisasi['nilai_organisasi']);

        

        print_r($row_ekskul);
        print_r($row_organisasi);
        die();

    }

    public function cekNilaiKegiatan($id_siswa,$tahun_ajaran,$semester)
    {
        $this->db->where('id_siswa',$id_siswa);
        $this->db->where('tahun_ajaran',$tahun_ajaran);
        $this->db->where('semester',$semester);
        $query = $this->db->get('tabel_nilai_ekstrakurikuler');
        return $query->result_array();
    }

    public function cekNilaiOrganisasi($id_siswa,$tahun_ajaran,$semester)
    {
        $this->db->where('id_siswa',$id_siswa);
        $this->db->where('tahun_ajaran',$tahun_ajaran);
        $this->db->where('semester',$semester);
        $query = $this->db->get('tabel_nilai_organisasi');
        return $query->result_array();
    }

    public function cekNilaiOLD($kd_siswa,$kd_pelajaran,$tahun_ajaran,$semester)
    {
        $query = $this->db->query("SELECT * FROM tabel_nilai WHERE kd_siswa='$kd_siswa' AND kd_pelajaran='$kd_pelajaran'
                                    AND semester='$semester'
                                    AND tahun_ajaran='$tahun_ajaran'
                                ");
        if ($query->num_rows() == 1)
            return TRUE;
        else
            return FALSE;
    }
          
    public function cekNilaiKI1($kd_siswa,$tahun_ajaran,$semester)
    {
        $query = $this->db->query("SELECT * FROM tabel_nilai_sekunder WHERE kd_siswa='$kd_siswa' AND semester='$semester'
                                    AND tahun_ajaran='$tahun_ajaran'
                                ");
        if ($query->num_rows() == 1)
            return TRUE;
        else
            return FALSE;
    }

    public function CekNilaiKegiatanOLD($kd_siswa,$tahun_ajaran,$semester,$jenis){
        $query = $this->db->query("SELECT * FROM tabel_pengembangan_diri_siswa WHERE kd_siswa='$kd_siswa' AND semester='$semester'
                                    AND tahun_ajaran='$tahun_ajaran'AND jenis = '$jenis'
                                ");
        if ($query->num_rows() == 1)
            return TRUE;
        else
            return FALSE;
    }

    public function CekNilaiSekunder($kd_siswa,$tahun_ajaran,$semester){
        $query = $this->db->query("SELECT * FROM tabel_nilai_sekunder WHERE kd_siswa='$kd_siswa' AND semester='$semester'
                                    AND tahun_ajaran='$tahun_ajaran'
                                ");
        if ($query->num_rows() == 1)
            return TRUE;
        else
            return FALSE;
    }

    public function getKelas($kd_siswa,$tahun_ajaran)
    {
        $query = "SELECT kd_kelas FROM kelas_siswa WHERE kd_siswa='$kd_siswa' AND tahun_ajaran='$tahun_ajaran'";
        $query = $this->db->query($query);
        $hasil = $query->first_row();
        return $hasil->kd_kelas;
    }

    public function cekCompletionMapel($kd_pelajaran,$kd_kelas,$field,$tahun_ajaran,$semester)
    {
        $query = "SELECT count('$field') as terisi FROM tabel_nilai 
                    WHERE kd_kelas = '$kd_kelas' 
                    AND kd_pelajaran = '$kd_pelajaran' 
                    AND semester='$semester'
                    AND $field IS NOT NULL";
        $hasil = $this->db->query($query);
        $result = $hasil->first_row();

        // return $query;
        return $result->terisi;
    }


    public function cekNilaiField($kd_siswa,$kd_pelajaran,$tahun_ajaran,$semester,$field)
    {
        $query = $this->db->query("SELECT $field FROM tabel_nilai 
                                    WHERE kd_siswa='$kd_siswa' 
                                    AND kd_pelajaran='$kd_pelajaran'
                                    AND semester='$semester'
                                    AND tahun_ajaran='$tahun_ajaran'
                                ");
        $isi = $query->first_row('array');
        if (isset($isi[$field]))
            $nilai = $isi[$field];
        else
            $nilai = '';
        if ($query->num_rows() == 1)
            return $nilai;
        else 
            return '';
    }

    public function cekNilaiFieldKI1($kd_siswa,$tahun_ajaran,$semester)
    {
        $query = $this->db->query("SELECT nilai FROM tabel_nilai_sekunder 
                                    WHERE kd_siswa='$kd_siswa' 
                                    AND semester='$semester'
                                    AND tahun_ajaran='$tahun_ajaran'
                                ");
        $isi = $query->first_row('array');
        if (isset($isi['nilai']))
            $nilai = $isi['nilai'];
        else
            $nilai = '-';
        if ($query->num_rows() == 1)
            return $nilai;
        else 
            return 'Belum diisi oleh wali';
    }

    public function cekNilaiFieldKegiatanOLD($kd_siswa,$tahun_ajaran,$semester)
    {
        $query = $this->db->query("SELECT jenis,keterangan FROM tabel_pengembangan_diri_siswa
                                    WHERE kd_siswa='$kd_siswa' 
                                    AND semester='$semester'
                                    AND tahun_ajaran='$tahun_ajaran'
                                    LIMIT 0,3
                                ");
        $isi = $query->result('array');
        return $isi;
    }

    public function cekNilaiFieldSekunder($kd_siswa,$tahun_ajaran,$semester)
    {
        $query = $this->db->query("SELECT nilai,sakit,izin,alfa FROM tabel_nilai_sekunder
                                    WHERE kd_siswa='$kd_siswa' 
                                    AND semester='$semester'
                                    AND tahun_ajaran='$tahun_ajaran'
                                ");
        $isi = $query->first_row('array');
        return $isi;
    }

    public function isiNilaiKegiatan($kd_siswa,$tahun_ajaran,$semester,$jenis,$keterangan)
    {
        if ($jenis == null and $keterangan == null)
            return true;
        if (!$this->CekNilaiKegiatan($kd_siswa,$tahun_ajaran,$semester,$jenis))
            $query = "INSERT INTO tabel_pengembangan_diri_siswa (`kd_siswa`,`tahun_ajaran`,`semester`,`jenis`,`keterangan`) VALUES ('$kd_siswa','$tahun_ajaran','$semester','$jenis','$keterangan')";
        else
            $query = "UPDATE `tabel_pengembangan_diri_siswa` SET `keterangan` = '$keterangan' WHERE `tabel_pengembangan_diri_siswa`.`kd_siswa` = '$kd_siswa' AND `tabel_pengembangan_diri_siswa`.`jenis` = '$jenis' AND `tabel_pengembangan_diri_siswa`.`tahun_ajaran` = '$tahun_ajaran' AND `tabel_pengembangan_diri_siswa`.`semester` = '$semester'";
        // die($query);
        if ($this->db->query($query)){
            return true;
        }
        else{
            return false;
        }
    }
    public function isiNilaiSekunder($kd_siswa,$tahun_ajaran,$semester,$nilai,$sakit,$izin,$alfa)
    {
        if (!$this->CekNilaiSekunder($kd_siswa,$tahun_ajaran,$semester))
            $query = "INSERT INTO tabel_nilai_sekunder(`kd_siswa`,`tahun_ajaran`,`semester`,`nilai`,`sakit`,`izin`,`alfa`) VALUES ('$kd_siswa','$tahun_ajaran','$semester','$nilai','$sakit','$izin','$alfa')";
        else
            $query = "UPDATE `tabel_nilai_sekunder` SET `nilai` = '$nilai',`sakit` = '$sakit',`izin` = '$izin',`alfa` = '$alfa' WHERE `tabel_nilai_sekunder`.`kd_siswa` = '$kd_siswa' AND `tabel_nilai_sekunder`.`tahun_ajaran` = '$tahun_ajaran' AND `tabel_nilai_sekunder`.`semester` = '$semester'";
        // die($query);
        if ($this->db->query($query)){
            return true;
        }
        else{
            return false;
        }
    }

    public function isiNilai($kd_siswa,$kd_pelajaran,$tahun_ajaran,$semester,$field,$nilai)
    {
        if ($nilai != ''){
            $kd_kelas = $this->getKelas($kd_siswa,$tahun_ajaran);
            if ($this->cekNilai($kd_siswa,$kd_pelajaran,$tahun_ajaran,$semester) == 0){
                $query = "INSERT INTO tabel_nilai (`kd_siswa`, `kd_pelajaran`, `tahun_ajaran`, `semester`,`$field`,`kd_kelas`) VALUES ('$kd_siswa','$kd_pelajaran','$tahun_ajaran','$semester','$nilai','$kd_kelas')";
            }else{
                $query =" UPDATE `tabel_nilai` SET `$field` = '$nilai' WHERE `tabel_nilai`.`kd_siswa` = '$kd_siswa' AND `tabel_nilai`.`kd_pelajaran` = '$kd_pelajaran' AND `tabel_nilai`.`tahun_ajaran` = '$tahun_ajaran' AND `tabel_nilai`.`semester` = '$semester' AND `tabel_nilai`.`kd_kelas` = '$kd_kelas'" ;
            }
            if ($this->db->query($query)){
            return true;
            }
            else{
                return false;
            }
        }
        
    }

    public function isiNilaiKI1($kd_siswa,$tahun_ajaran,$semester,$nilai)
    {
        if ($nilai != ''){
            $kd_kelas = $this->getKelas($kd_siswa,$tahun_ajaran);
            if ($this->cekNilaiKI1($kd_siswa,$tahun_ajaran,$semester) == 0){
                $query = "INSERT INTO tabel_nilaiki1 (`kd_siswa`, `tahun_ajaran`, `semester`,`nilai`) VALUES ('$kd_siswa','$tahun_ajaran','$semester','$nilai')";
            }else{
                $query =" UPDATE `tabel_nilaiki1` SET `nilai` = '$nilai' WHERE `tabel_nilaiki1`.`kd_siswa` = '$kd_siswa' AND `tabel_nilaiki1`.`tahun_ajaran` = '$tahun_ajaran' AND `tabel_nilaiki1`.`semester` = '$semester' " ;
            }
            if ($this->db->query($query)){
            return true;
            }
            else{
                return false;
            }
        }
        
    }
}