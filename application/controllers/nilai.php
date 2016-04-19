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

    public function generateExcel($id_siswa,$tahun_ajaran,$semester)
    {
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
        $objWorksheet->setCellValue('C5',$data_siswa['nis']);
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

    public function inputExcel($file){
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
            $data[$index]['id_siswa'] = $this->siswa->nis2id_siswa($objWorksheet->getCellByColumnAndRow(1,$row)->getValue());
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
            $nis_kelas[] = $row['id_siswa'];
        }
        print_r($nis_kelas);
        foreach ($data as $row) {
            if (!in_array($row['id_siswa'],$nis_kelas)){
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

    public function coba()
    {
        print_r($this->nilai_m->getNilaiRapor(18,2016,1));
        echo 'aaaa';
    }

    public function coba2()
    {
        // if ($this->nilai_m->cekNilaiField(2,2,2017,2,'nilai_mid'))
        //     echo "ada";
        // else
        //     echo "tak ada";
        print_r($this->nilai_m->cekNilaiField(1,8,2017,1,'nilai_uas'));
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