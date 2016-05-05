<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Nilai extends CI_Controller {
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->model('nilai_m');
        $this->load->library('excel');
        $this->load->model('siswa');
        $this->load->model('kelas');
        $this->load->model('pengampu_m');
        $this->load->model('mata_pelajaran');
        $this->load->library('grocery_CRUD');
    }

    public function index(){
        redirect('nilai/manageNilai');
    }

    public function do_upload($alert = null,$notice = null)
    {
        
        $config['upload_path'] = './assets/uploads/temporary_xls';
        $config['allowed_types'] = 'xls';
        $config['max_size'] = '20000';
        // $config['max_width']  = '1024';
        // $config['max_height']  = '768';

        $this->load->library('upload', $config);
        

        if ( ! $this->upload->do_upload())
        {
            die('gagal mengupload');
        }
        else
        {
            $data = $this->upload->data();
            $this->inputExcel($data['full_path']);
        }
    }

    public function getSKHU($id_siswa)
    {
        if ($this->siswa->cekTunggakan($id_siswa) and $this->session->userdata('level') == 5){
            redirect('siswas/menunggak');
        } 
        if ($id_siswa != $this->session->userdata('id_transaksi') and $this->session->userdata('level') == 5){
            echo "<script>alert('Anda mencoba melakukan akses diluar authorisasi')</script>";
            redirect('users/logout');
        }
        if (!$this->siswa->cekWaktuDownloadSKHU()){
            redirect('siswas/belum_waktu');
        } 

        $data = $this->siswa->rangkaiDataSKHU($id_siswa);

        $styleArray = array(
            'borders' => array(
                    'top' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        ),
                    'bottom' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        ),
                    'right' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        ),
                    'left' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )

                )
        );
        // $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
        // $rendererLibrary = 'mpdf';
        // $rendererLibraryPath = APPPATH.'third_party/'.$rendererLibrary;
        // if (!PHPExcel_Settings::setPdfRenderer($rendererName,$rendererLibraryPath)) {
        //     die(
        //         'Please set the $rendererName and $rendererLibraryPath values' .
        //             PHP_EOL .
        //         ' as appropriate for your directory structure'
        //         );
        // }
        $path_template = realpath(FCPATH).'/assets/template_excel/TemplateSKHUS.xls';
        $excel = new PHPExcel_Reader_Excel5();
        $objPHPExcel = $excel->load($path_template);
        $objWorksheet = $objPHPExcel->getActiveSheet();

        $objWorksheet->setCellValue('B6',$data['program_studi']);
        $objWorksheet->setCellValue('B7',$data['tahun_ajaran']);
        $objWorksheet->setCellValue('F11',$data['nama']);
        $objWorksheet->setCellValue('F12',$data['ttl']);
        $objWorksheet->setCellValue('F13',$data['nisn']);
        $objWorksheet->setCellValue('F14',$data['nomor_peserta']);
        $objWorksheet->setCellValue('B17',$data['lulus']);
        $string = "Ujian Nasional Berdasarkan Peraturan Menteri Pendidikan Nasional Nomor ".$data['nomor_peraturan']." Tahun ".$data['tahun_peraturan']." dengan hasil sebagai berikut ";
        $objWorksheet->setCellValue('B19',$string);
        $objWorksheet->setCellValue('G33',$data['kepala_sekolah']);

        $nilai = $data['nilai'];
        $baris = 22;
        for ($i=0; $i < count($nilai); $i++) { 
            $objWorksheet->setCellValueByColumnAndRow(2,$i+$baris,$i+1);
            $objWorksheet->setCellValueByColumnAndRow(3,$i+$baris,$nilai[$i]['nama_mapel']);
            $objWorksheet->setCellValueByColumnAndRow(5,$i+$baris,$nilai[$i]['nilai']);
            $objWorksheet->setCellValueByColumnAndRow(6,$i+$baris,$this->konversiNilai($nilai[$i]['nilai']));
        }
        $objWorksheet->setCellValue('F28',$data['jumlah']);
        $objWorksheet->setCellValue('H30',$this->siswa->reKonversiTanggal(date("Y-m-d")));
        $objWorksheet->setCellValue('G28',$this->konversiNilai($data['jumlah']));


        $objWriter = new PHPExcel_Writer_HTML($objPHPExcel);  
        $output['data'] = $objWriter->generateHTMLHeader();
        $output['data'] .= $objWriter->generateStyles();
        $output['data'] .= $objWriter->generateSheetData();
        $output['data'] .= $objWriter->generateHTMLFooter();
        
    

        $this->showHeader();
        $this->load->view('nilai/skhu',$output);
        $this->load->view('footer_general');

    }

    public function do_upload_skhu($alert = null,$notice = null)
    {
        
        $config['upload_path'] = './assets/uploads/temporary_xls';
        $config['allowed_types'] = 'xls';
        $config['max_size'] = '20000';
        // $config['max_width']  = '1024';
        // $config['max_height']  = '768';

        $this->load->library('upload', $config);
        

        if ( ! $this->upload->do_upload())
        {
            die('gagal mengupload');
        }
        else
        {
            $data = $this->upload->data();
            $this->inputExcelSKHU($data['full_path']);
        }
    }

    public function do_upload_kartu($alert = null,$notice = null)
    {
        
        $config['upload_path'] = './assets/uploads/temporary_xls';
        $config['allowed_types'] = 'xls';
        $config['max_size'] = '20000';
        // $config['max_width']  = '1024';
        // $config['max_height']  = '768';

        $this->load->library('upload', $config);
        

        if ( ! $this->upload->do_upload())
        {
            die('gagal mengupload');
        }
        else
        {
            $data = $this->upload->data();
            $this->inputExcelKartu($data['full_path']);
        }
    }

    public function generateExcel($id_siswa,$tahun_ajaran,$semester)
    {
        if ($this->siswa->cekTunggakan($id_siswa) and $this->session->userdata('level') == 5){
            redirect('siswas/menunggak');
        } 
        if ($id_siswa != $this->session->userdata('id_transaksi') and $this->session->userdata('level') == 5){
            echo "<script>alert('Anda mencoba melakukan akses diluar authorisasi')</script>";
            redirect('users/logout');
        }

        $styleArray = array(
            'borders' => array(
                    'top' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        ),
                    'bottom' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        ),
                    'right' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        ),
                    'left' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )

                )
        );
        // $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
        // $rendererLibrary = 'mpdf';
        // $rendererLibraryPath = APPPATH.'third_party/'.$rendererLibrary;
        // if (!PHPExcel_Settings::setPdfRenderer($rendererName,$rendererLibraryPath)) {
        //     die(
        //         'Please set the $rendererName and $rendererLibraryPath values' .
        //             PHP_EOL .
        //         ' as appropriate for your directory structure'
        //         );
        // }
        $path_template = realpath(FCPATH).'/assets/template_excel/TemplateRaporMardi.xls';
        $excel = new PHPExcel_Reader_Excel5();
        $objPHPExcel = $excel->load($path_template);
        $objWorksheet = $objPHPExcel->getActiveSheet();

        //prepare data
        $data_siswa = $this->siswa->getSiswa($id_siswa);
        $data_kelas = $this->siswa->getKelasSiswa($id_siswa,$tahun_ajaran);
        $data_nilai = $this->nilai_m->getNilaiRapor($id_siswa,$tahun_ajaran,$semester);
        $string_tahun_ajaran = (string)$tahun_ajaran . ' / '. (string)($tahun_ajaran + 1);


        $objWorksheet->setCellValue('C4',$data_siswa['nama_siswa']);
        $objWorksheet->setCellValue('C5',$data_siswa['nisn']);
        $objWorksheet->setCellValue('F4',$semester);
        $objWorksheet->setCellValue('F5',$string_tahun_ajaran);

        $baris = 10;
        for ($i=0; $i < count($data_nilai); $i++) { 
            $row = $data_nilai[$i];
            $objWorksheet->setCellValueByColumnAndRow(0,$i+$baris,$i+1);
            $objWorksheet->setCellValueByColumnAndRow(1,$i+$baris,$row['nama_mapel']);
            $objWorksheet->setCellValueByColumnAndRow(2,$i+$baris,$row['kkm']);
            $objWorksheet->setCellValueByColumnAndRow(3,$i+$baris,$row['nilai_pengetahuan']);
            $objWorksheet->setCellValueByColumnAndRow(4,$i+$baris,$this->konversiNilai($row['nilai_pengetahuan']));
            if ($row['nilai_praktek'] == null){
                $objWorksheet->setCellValueByColumnAndRow(5,$i+$baris," ");
                $objWorksheet->setCellValueByColumnAndRow(6,$i+$baris," ");
            } else {
                $objWorksheet->setCellValueByColumnAndRow(5,$i+$baris,$row['nilai_praktek']);
                $objWorksheet->setCellValueByColumnAndRow(6,$i+$baris,$this->konversiNilai($row['nilai_praktek']));
            }
            $objWorksheet->setCellValueByColumnAndRow(7,$i+$baris,$row['nilai_sikap']);
        }
        $baris_akhir = $baris+$i;

        for($x=$baris;$x<$baris_akhir;$x++){
            for ($y=0; $y<=7 ; $y++) { 
                $cell = PHPExcel_Cell::stringFromColumnIndex($y) . $x;
                $objWorksheet->getStyle($cell)->applyFromArray($styleArray);
            }
        }
        $objWriter = new PHPExcel_Writer_HTML($objPHPExcel);  
        $output['data'] = $objWriter->generateHTMLHeader();
        $output['data'] .= $objWriter->generateStyles();
        $output['data'] .= $objWriter->generateSheetData();
        $output['data'] .= $objWriter->generateHTMLFooter();


        $this->showHeader();
        $this->load->view('nilai/tabel_rapor',$output);
        $this->load->view('footer_table');       

    }
    public function generateExcelSKHU($id_jurusan)
    {
        $tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
        $mapel = $this->mata_pelajaran->getMapelUNByJurusan($id_jurusan,$tahun_ajaran);
        $styleArray = array(
            'borders' => array(
                    'top' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        ),
                    'bottom' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        ),
                    'right' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        ),
                    'left' => array(
                            'style' => PHPExcel_Style_Border::BORDER_THIN
                        )

                )
        );
        // $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
        // $rendererLibrary = 'mpdf';
        // $rendererLibraryPath = APPPATH.'third_party/'.$rendererLibrary;
        // if (!PHPExcel_Settings::setPdfRenderer($rendererName,$rendererLibraryPath)) {
        //     die(
        //         'Please set the $rendererName and $rendererLibraryPath values' .
        //             PHP_EOL .
        //         ' as appropriate for your directory structure'
        //         );
        // }
        $path_template = realpath(FCPATH).'/assets/template_excel/TemplateNilaiSKHUMardi.xls';
        $excel = new PHPExcel_Reader_Excel5();
        $objPHPExcel = $excel->load($path_template);
        $objWorksheet = $objPHPExcel->getActiveSheet();

        $objWorksheet->setCellValueByColumnAndRow(2,7,$id_jurusan);

        for ($i=0; $i < count($mapel); $i++) { 
            $row = $mapel[$i];
            $objWorksheet->setCellValueByColumnAndRow($i+3,7,$row['id_mapel']);
            $objWorksheet->setCellValueByColumnAndRow($i+3,9,$row['nama_mapel']);
        }
        $kolom_akhir = $i+3;

        for($x=8;$x<=9;$x++){
            for ($y=0; $y<$kolom_akhir ; $y++) { 
                $cell = PHPExcel_Cell::stringFromColumnIndex($y) . $x;
                $objWorksheet->getStyle($cell)->applyFromArray($styleArray);
            }
        }

        $filename='Data Kelas '. $tahun_ajaran .'-'. $id_jurusan.'.xls'; //save our workbook as this file name
        $filename = urlencode($filename);
        // header('Content-Type: application/vnd.ms-excel'); //mime type
        // header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
        // header('Cache-Control: max-age=0'); //no cache

        $objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);  
        $exportPlace = realpath(FCPATH).'/assets/downloadable/'.$filename;
        $objWriter->save($exportPlace);
        return $filename;

    }

    public function isiNilaiSKHU($id_jurusan)
    {
        $tahun_ajaran = $this->tahun_ajaran->getCurrentTA();        
        // die($this->session->userdata('level'));
        if ($this->session->userdata('level') != 9 or $id_jurusan != 3 and $id_jurusan != 2){
            echo "<script>alert('akses ditolak')</script>";
            // sleep(5);
            redirect('users/login');
        }
        $url = $this->generateExcelSKHU($id_jurusan);
        $url = base_url().'assets/downloadable/'.$url;
        $data['url'] = "<a href=".$url.">Download Format Penilaian </a>";
        $this->showHeader();
        $this->load->view('nilai/form_upload_skhu',$data);
        $this->load->view('footer_general');
    }

    public function isiKartu()
    {
        if ($this->session->userdata('level') != 9){
            echo "<script>alert('akses ditolak')</script>";
            // sleep(5);
            redirect('users/login');
        }
        $url = base_url().'assets/template_excel/templateInputKartu.xls';
        $data['url'] = "<a href=".$url.">Download Format Kartu </a>";
        $this->showHeader();
        $this->load->view('siswa/form_upload_kartu',$data);
        $this->load->view('footer_general');
    }

    public function inputExcel($file){
        if ($this->session->userdata('level') == 5){
            echo "<script>alert('akses ditolak')</script>";
            // sleep(5);
            redirect('users/login');
        }
        $laporan = null;
        $valid = true;
        $this->load->model('siswa');
        $this->load->model('user');
        $inputFileType = PHPExcel_IOFactory::identify($file);

        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($file);
        $objWorksheet = $objPHPExcel->getActiveSheet();


        $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
        $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5

        // do some checking here

        $id_guru = $this->pengampu_m->nip2id_guru($objWorksheet->getCellByColumnAndRow(3,6)->getValue());
        $id_mapel = $objWorksheet->getCellByColumnAndRow(2,11)->getValue();
        $id_kelas = $objWorksheet->getCellByColumnAndRow(1,11)->getValue();

        if (!$this->pengampu_m->cekStatusAmpu($id_kelas,$id_mapel,$id_guru)){
            
        }else{
            echo '<script>alert("Anda bukan pengampu untuk kelas ini")</script>';
            $valid = false;
        }

        $tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
        $semester = $objWorksheet->getCellByColumnAndRow(3,5)->getValue();

        $index = 0;
        for ($row=16; $row <= $highestRow; $row++) { 
            $data[$index]['id_siswa'] = $this->siswa->nisn2id_siswa($objWorksheet->getCellByColumnAndRow(1,$row)->getValue());
            $data[$index]['nilai_pengetahuan'] = $objWorksheet->getCellByColumnAndRow(4,$row)->getValue();
            $data[$index]['nilai_praktek'] = $objWorksheet->getCellByColumnAndRow(5,$row)->getValue();
            $data[$index]['nilai_sikap'] = $objWorksheet->getCellByColumnAndRow(6,$row)->getValue();
            $data[$index]['keterangan'] = $objWorksheet->getCellByColumnAndRow(7,$row)->getValue();
            $data[$index]['ketercapaian_kompetensi'] = $objWorksheet->getCellByColumnAndRow(8,$row)->getValue();
            $data[$index]['tahun_ajaran'] = $tahun_ajaran;
            $data[$index]['semester'] = $semester;
            $data[$index]['id_mapel'] = $id_mapel;
            $index++;
        }

        //verifikasi dia ada di kelas
        $isi_kelas = $this->kelas->getIsiKelas($id_kelas);
        foreach ($isi_kelas as $row) {
            $nisn_kelas[] = $row['id_siswa'];
        }
        print_r($nisn_kelas);
        foreach ($data as $row) {
            if (!in_array($row['id_siswa'],$nisn_kelas)){
                $valid = false;
                echo '<script>alert("ada siswa yang bukan dari kelas ini")</script>';
                break;
            }
        }

        if ($valid){
            if ($this->nilai_m->isiNilaiSiswa($data)){
                echo '<script>alert("berhasil memasukkan data")</script>';
            } else {
                echo '<script>alert("gagal memasukkan data")</script>';
           }
        } else {
            echo '<script>alert("gagal memasukkan data")</script>';
        }
        unlink($file);
    }

    public function inputExcelSKHU($file){
        if ($this->session->userdata('level') == 9){
            echo "<script>alert('akses ditolak')</script>";
            // sleep(5);
            redirect('users/login');
        }
        $laporan = null;
        $valid = true;
        $this->load->model('siswa');
        $this->load->model('user');
        $inputFileType = PHPExcel_IOFactory::identify($file);

        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($file);
        $objWorksheet = $objPHPExcel->getActiveSheet();


        $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
        $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5

        // do some checking here

        $id_jurusan = $objWorksheet->getCellByColumnAndRow(2,7)->getValue();

        $tahun_ajaran = $this->tahun_ajaran->getCurrentTA();

        $data_mapel = array();

        
        for ($column=3; $column < $highestColumnIndex; $column++) { 
            $data_mapel[] = $objWorksheet->getCellByColumnAndRow($column,7)->getValue();
        }

        $index = 0;
        for ($row=10; $row <= $highestRow; $row++) { 
            $data[$index]['id_siswa'] = $this->siswa->nisn2id_siswa($objWorksheet->getCellByColumnAndRow(1,$row)->getValue());
            $data[$index]['no_peserta_un'] = $objWorksheet->getCellByColumnAndRow(0,$row)->getValue();
            for ($column=3; $column < $highestColumnIndex; $column++) { 
                $data[$index]['nilai'][] = $objWorksheet->getCellByColumnAndRow($column,$row)->getValue();
            }
            $index++;
        }

        $valid = true;
        $entry['tahun_ajaran'] = $tahun_ajaran;
        foreach ($data as $siswa) {
            $index = 0;
            $entry_nomor['id_siswa'] = $siswa['id_siswa'];
            $entry_nomor['no_peserta_un'] = $siswa['no_peserta_un'];

            $entry['id_siswa'] = $siswa['id_siswa'];
            for ($i=0; $i < count($data_mapel); $i++) { 
                $entry['id_mapel'] = $data_mapel[$i];
                $entry['nilai'] = $siswa['nilai'][$i];
                $data_entry[] = $entry;
            }
            $data_kartu[] = $entry_nomor;
            
        }
        //masukin data kartu ke tabel_peserta_un
        $valid = $valid and $this->nilai_m->isiNilaiSKHUSiswa($data_entry);
        $valid = $valid and $this->siswa->isiNomorUN($data_kartu);
        if ($valid){
            echo '<script>alert("berhasil memasukkan data")</script>';
        } else {
            echo '<script>alert("gagal memasukkan data")</script>';
        }
        unlink($file);
        redirect('siswas/menuKelulusan');
    }

    public function inputExcelKartu($file){
        if ($this->session->userdata('level') != 9){
            echo "<script>alert('akses ditolak')</script>";
            // sleep(5);
            redirect('users/login');
        }
        $laporan = null;
        $valid = true;
        $this->load->model('siswa');
        $this->load->model('user');
        $inputFileType = PHPExcel_IOFactory::identify($file);

        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($file);
        $objWorksheet = $objPHPExcel->getActiveSheet();


        $highestRow = $objWorksheet->getHighestRow(); // e.g. 10
        $highestColumn = $objWorksheet->getHighestColumn(); // e.g 'F'
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn); // e.g. 5

        // do some checking here

        $jenis_kartu = $objWorksheet->getCellByColumnAndRow(1,5)->getValue();

        $kartu_valid = array('uts','uas','us');

        if (!in_array($jenis_kartu, $kartu_valid)){
            die('jenis kartu tidak valid');
        }

        $tahun_ajaran = $this->tahun_ajaran->getCurrentTA();

        $data_kartu = array();


        $index = 0;
        for ($row=9; $row <= $highestRow; $row++) { 
            $data[$index]['id_siswa'] = $this->siswa->nisn2id_siswa($objWorksheet->getCellByColumnAndRow(0,$row)->getValue());
            $data[$index]['nomor_peserta'] = $objWorksheet->getCellByColumnAndRow(2,$row)->getValue();
            $data[$index]['ruang'] = $objWorksheet->getCellByColumnAndRow(3,$row)->getValue();
            $data[$index]['jenis_kartu'] = $jenis_kartu;
            $index++;
        }

        $valid = $valid and $this->siswa->isiKartuSiswa($data);
        if ($valid){
            echo '<script>alert("berhasil memasukkan data")</script>';
        } else {
            echo '<script>alert("gagal memasukkan data")</script>';
        }
        unlink($file);
        redirect('nilai/isiKartu');
    }

    public function coba()
    {
        print_r($this->siswa->cekWaktuDownloadSKHU());


    }

    public function coba2()
    {
        // if ($this->nilai_m->cekNilaiField(2,2,2017,2,'nilai_mid'))
        //     echo "ada";
        // else
        //     echo "tak ada";
        print_r($this->nilai_m->cekNilaiField(1,8,2017,1,'nilai_uas'));
    }



    public function manageNilai($tipe = null) {        
        $crud = new grocery_CRUD();
         
        $crud->set_table('tabel_nilai_rapor')
            ->set_subject('Nilai')
            ->display_as('id_mapel', 'Kode Pelajaran')
            ->display_as('id_siswa', 'nisn')
            ->set_relation('id_mapel','tabel_mapel','nama_mapel')
            ->set_relation('id_siswa','tabel_siswa','nisn',array('status' => 1))
            ->set_relation('tahun_ajaran','tahun_ajaran','tahun_ajaran',array('id_tahun_ajaran' => $this->tahun_ajaran->getCurrentTA()))
            ->unset_texteditor('ketercapaian_kompetensi')
            ->field_type('semester','dropdown',array('1' => '1', '2' => '2'))
            ->field_type('nilai_sikap','dropdown',array('A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E'))
            ->field_type('keterangan','dropdown',array('T' => 'Tuntas', 'TT' => 'Tidak Tuntas'))
            ; 
        

        // if ($tipe != null){
        //     switch ($tipe) {
        //         case 'guru':
        //             # code...
        //             $where = "tabel_nilai.kd_pelajaran IN (SELECT pengampu.kd_pelajaran FROM pengampu WHERE kd_guru=" . $this->session->userdata('kd_transaksi') . ")";
        //             $crud->where($where);
        //             break;
        //         case 'siswa':
        //             # code...
        //             // $where = "tabel_nilai.kd_pelajaran IN (SELECT pengampu.kd_pelajaran FROM pengampu WHERE kd_guru=" . $this->session->userdata('kd_transaksi') . ")";
        //             $crud->where('tabel_nilai.kd_siswa',$this->session->userdata('kd_transaksi'));
        //             break;                    
        //         case 'wali':
        //             # code...
        //             $where = "tabel_nilai.kd_kelas IN (SELECT kelas.kd_kelas FROM kelas WHERE kd_guru=" . $this->session->userdata('kd_transaksi') . ")";
        //             $crud->where($where);
        //             break;                    
        //         default:
        //             # code...
        //             break;
        //     }
        // }

        if ($this->session->userdata('level') != 9){
            $crud->unset_edit()
            ->unset_delete()
            ->unset_add();
        }

        $output = $crud->render();
        $output->output ='<h3><i class="fa fa-angle-right"></i>Data Nilai</h3> <br/>' . $output->output;
        $this->showOutput($output);
    }


    public function filterNilai(){
        $data['mapel'] = $this->db->get('mata_pelajaran');
        $data['kelas'] = $this->db->get('kelas');
        $this->load->view('nilai/filter',$data);
    }

    public function processFilter(){
        $this->session->set_userdata('filter_mapel',$_POST['mapel']);
        $this->session->set_userdata('filter_kelas',$_POST['kelas']);
        $this->session->set_userdata('filter_lulus',$_POST['lulus']);
        // redirect('nilai/manageNilai');
        redirect($this->session->userdata('uri_filter_nilai'));

    }

    public function clearFilter(){
        $this->session->unset_userdata('filter_mapel');
        $this->session->unset_userdata('filter_kelas');
        $this->session->unset_userdata('filter_lulus');
        // redirect('nilai/manageNilai');
        redirect($this->session->userdata('uri_filter_nilai'));
    }

    public function konversiNilai($value)
    {
        if (is_float($value)){
            $hai = $value;
            // $hai = explode('.', $hai);
            list($satu,$dua) = array_pad(explode('.', $hai,2),2,'');
            return $this->konversiNilai($satu) . " koma ". $this->konversiNilai($dua);
            // return $this->konversiNilai($hai[0]) . " koma ". $this->konversiNilai($hai[1]);
        }
        if ($value <= 11) {
            switch ($value) {
                case '0':
                    return 'nol';
                    break;
                case '1':
                    return 'satu';
                    break;
                case '2':
                    return 'dua';
                    break;
                case '3':
                    return 'tiga';
                    break;
                case '4':
                    return 'empat';
                    break;
                case '5':
                    return 'lima';
                    break;
                case '6':
                    return 'enam';
                    break;
                case '7':
                    return 'tujuh';
                    break;
                case '8':
                    return 'delapan';
                    break;
                case '9':
                    return 'sembilan';
                    break;
                case '10':
                    return 'sepuluh';
                    break;
                case '11':
                    return 'sebelas';
                    break;
            }
        } 
        elseif ($value == 100) {
            return 'seratus';
        } 
        elseif ($value>11 and $value <20) {
            return $this->konversiNilai($value % 10). ' belas';
        }
        elseif ($value % 10 != 0) {
            return $this->konversiNilai(floor($value/10)).' puluh '.$this->konversiNilai($value % 10);
        } 
        elseif ($value % 10 == 0) {
            return $this->konversiNilai($value/10).' puluh ';
        }

    }

    public function showOutput($output=null){
        $this->showHeader();
        if ($this->uri->segment(3) === false)
            $this->filterNilai();
        $this->load->view('crud/manage',$output);
        $this->load->view('footer_crud');  
    }

    
}