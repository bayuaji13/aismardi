<?php
 
require_once(APPPATH.'libraries/REST_Controller.php');

class Rest extends REST_Controller {

     function __construct(){
        parent::__construct();
        $this->load->database();
        $this->load->model('nilai');
        $this->load->helper('url');
        $this->load->helper(array('form', 'url'));
        $this->load->library('excel');
        // $this->load->model('grocery_CRUD');
    }

    public function allKelas_get()
    {
        $this->load->model('kelas');
        $list_kelas = $this->kelas->getAllkelas();
        $data = $list_kelas->result_array();
        
        if($data)
        {
            $this->response($data, 200); // 200 being the HTTP response code
        }
 
        else
        {
            $this->response($data, 200);
        }
    }

	function dataSantri_get()
	{
		$this->load->model('siswa');

		if(!$this->get('tipe'))
        {
            $this->response(NULL, 400);
        }
 
        $santri = $this->siswa->get_siswa_bytipe( $this->get('tipe') );
         
        if($santri)
        {
            $this->response($santri, 200); // 200 being the HTTP response code
        }
 
        else
        {
            $this->response(NULL, 404);
        }
	} 

	function nilai_get()
	{
		$this->load->model('nilai');

		if(!$this->get('tipe'))
        {
            $this->response(NULL, 400);
        }
 
        $nilai = $this->nilai->get_nilai_bytipe( $this->get('tipe') );
         
        if($nilai)
        {
            $this->response($nilai, 200); // 200 being the HTTP response code
        }
 
        else
        {
            $this->response(NULL, 404);
        }
	}

    function jadwal_get()
    {
        $this->load->model('siswa');

        if(!$this->get('kelas'))
        {
            $this->response(NULL, 400);
        }
 
        $jadwal = $this->siswa->get_jadwal( $this->get('kelas') );
         
        if($jadwal)
        {
            $this->response($jadwal, 200); // 200 being the HTTP response code
        }
 
        else
        {
            $this->response(NULL, 404);
        }

    }

        public function exporterRapor2013_get()
    {
        $kd_siswa = $this->get('kd_siswa');
        $semester = $this->get('semester');
        $pdf = null;
        $this->load->model(array('siswa','kelas','mata_pelajaran','nilai_m'));
        $this->tahun_ajaran->cekSemester($semester);
        $starting = 15;
        $tabel = [];
        $styleNoBorder = array(
            'borders' => array(
                    'top' => array(
                            'style' => PHPExcel_Style_Border::BORDER_NONE
                        ),
                    'bottom' => array(
                            'style' => PHPExcel_Style_Border::BORDER_NONE
                        ),
                    'right' => array(
                            'style' => PHPExcel_Style_Border::BORDER_NONE
                        ),
                    'left' => array(
                            'style' => PHPExcel_Style_Border::BORDER_NONE
                        )

                )
        );
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
        $styleArray1 = array(
            'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
        );
        $styleArrayLeft = array(
            'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
        );
        $styleArrayVerticalTop = array(
            'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
                )
        );
        $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
        $rendererLibrary = 'mpdf';
        $rendererLibraryPath = APPPATH.'third_party/'.$rendererLibrary;
        if (!PHPExcel_Settings::setPdfRenderer($rendererName,$rendererLibraryPath)) {
            die(
                'Please set the $rendererName and $rendererLibraryPath values' .
                    PHP_EOL .
                ' as appropriate for your directory structure'
                );
        }
        $path_template = realpath(FCPATH).'/assets/template_excel/templateRapor2013.xls';
        $excel = new PHPExcel_Reader_Excel5();
        $objPHPExcel = $excel->load($path_template);
        $objWorksheet = $objPHPExcel->getActiveSheet();

        $query = $this->siswa->getSiswa($kd_siswa);
        $result = $query->first_row();
        $objWorksheet->setCellValue('C8',$result->nama_siswa);
        $objWorksheet->setCellValue('C9',$result->nis);
        $tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
        $kd_guru = -1;
        $query = $this->kelas->getKelasBySiswaByTahunAjaranByGuru($kd_siswa,$tahun_ajaran,$kd_guru);

        $result = $query->first_row();

        $kd_kelas = $result->kd_kelas;
        
        $objWorksheet->setCellValue('J6',$result->nama);
        $objWorksheet->setCellValue('J7',$semester." ");
        $objWorksheet->setCellValue('J8',$tahun_ajaran." ");
        $i = -1;
        $query = $this->mata_pelajaran->getAllCatName();
        $count = $tab_count[] = 0;
        foreach ($query->result() as $row) {
            $mapel = $this->mata_pelajaran->getAllMapelByKategori($row->kd_kategori);
            $isiKategori[] = $mapel->num_rows();
            $listKategori[] = $row->kd_kategori;
            foreach ($mapel->result() as $in_row){
                ++$i;
                $tabel[$i]['kd_pelajaran'] = $in_row->kd_pelajaran;
                $tabel[$i]['nama_pelajaran'] = $in_row->nama_pelajaran;
                $pengampu_q = $this->mata_pelajaran->getPengampu($in_row->kd_pelajaran,$tahun_ajaran,$semester);
                if ($pengampu_q->num_rows == 0)
                    $tabel[$i]['nama_pengampu'] = "-";
                else{
                    $pengampu = $pengampu_q->first_row();
                    $tabel[$i]['nama_pengampu'] = $pengampu->nama_guru;
                }
                
                $kd_pelajaran = $in_row->kd_pelajaran;

                $inner_query = $this->nilai->getNilaiBySiswaBySemesterByTahunAjaranByMapel($kd_siswa,$semester,$tahun_ajaran,$kd_pelajaran);
                $inner_result = $inner_query->first_row();
                if ($inner_result == null)
                    $tabel[$i]['nilai'] = 0;
                else if ($inner_result->nilai == null)
                    $tabel[$i]['nilai'] = 0;
                else
                    $tabel[$i]['nilai'] = round($inner_result->nilai/25,2);
                $tabel[$i]['predikat_nilai'] = $this->getPredikat($tabel[$i]['nilai']);

                $inner_query = $this->nilai->getNilaiKI1BySiswaBySemesterByTahunAjaranByMapel($kd_siswa,$semester,$tahun_ajaran,$kd_pelajaran);
                $inner_result = $inner_query->first_row();
                if ($inner_result == null)
                    $tabel[$i]['nilai_ki1'] = 0;
                else if ($inner_result->nilai_ki1 == null)
                    $tabel[$i]['nilai_ki1'] = 0;
                else
                    $tabel[$i]['nilai_ki1'] = $inner_result->nilai_ki1;
                $tabel[$i]['predikat_nilai_ki1'] = $this->getPredikat($tabel[$i]['nilai_ki1']);

                $inner_query = $this->nilai->getNilaiKI4BySiswaBySemesterByTahunAjaranByMapel($kd_siswa,$semester,$tahun_ajaran,$kd_pelajaran);
                $inner_result = $inner_query->first_row();
                if ($inner_result == null)
                    $tabel[$i]['nilai_ki4'] = 0;
                else if ($inner_result->nilai_ki4 == null)
                    $tabel[$i]['nilai_ki4'] = 0;
                else
                    $tabel[$i]['nilai_ki4'] = $inner_result->nilai_ki4;
                $tabel[$i]['predikat_nilai_ki4'] = $this->getPredikat($tabel[$i]['nilai_ki4']);
                
            }
            $tab_count[] = $count + $i;
        }
        $tertampil=0;
        $indekstabel = 0;
        $catline = $starting;
        for ($counter=0;$counter<count($tab_count)-1;$counter++){
            $catline = $tertampil+$starting;
            $tertampil++;
            // echo "kateori di line -> $catline\n";

            $ctm = "A".$catline.":"."I".$catline;
            $objWorksheet->setCellValue('A'.$catline,$this->mata_pelajaran->getCatName($listKategori[$counter]));
            $cellToLeftAligned[] = $catline;
            $objWorksheet->mergeCells($ctm);
            $n = $tab_count[$counter+1] - $tab_count[$counter];
            if ($counter == 0){
                $n++;
            }
            for ($i=0; $i < $n; $i++) { 
                $ltf = $tertampil+$starting;
                $entry = $tabel[$indekstabel];
                $objWorksheet->setCellValueByColumnAndRow(0,$ltf,$i+1);
                $objWorksheet->setCellValueByColumnAndRow(1,$ltf,$entry['nama_pelajaran']);
                $objWorksheet->setCellValueByColumnAndRow(2,$ltf,$entry['nama_pengampu']);
                $objWorksheet->setCellValueByColumnAndRow(3,$ltf,$entry['nilai']);
                $objWorksheet->setCellValueByColumnAndRow(4,$ltf,$entry['predikat_nilai']);
                $objWorksheet->setCellValueByColumnAndRow(5,$ltf,$entry['nilai_ki4']);
                $objWorksheet->setCellValueByColumnAndRow(6,$ltf,$entry['predikat_nilai_ki4']);
                $objWorksheet->setCellValueByColumnAndRow(7,$ltf,$entry['nilai_ki1']);
                $objWorksheet->setCellValueByColumnAndRow(8,$ltf,$entry['predikat_nilai_ki1']);


                $tertampil++;
                $indekstabel++;
            }
        }

        $ltf2 = $ltf + 2;
        $objWorksheet->setCellValueByColumnAndRow(0,$ltf+1," ");
        $objWorksheet->setCellValueByColumnAndRow(0,$ltf2,"No");
        $objWorksheet->setCellValueByColumnAndRow(1,$ltf2,"Jenis Pengembangan Diri");
        $objWorksheet->setCellValueByColumnAndRow(2,$ltf2,"Keterangan");

        $kegiatan = $this->nilai_m->cekNilaiFieldKegiatan($kd_siswa,$tahun_ajaran,$semester);
        $sekunder = $this->nilai_m->cekNilaiFieldSekunder($kd_siswa,$tahun_ajaran,$semester);
        // print_r($sekunder);
        // die();

        for ($i=0; $i < 3; $i++) { 
            $placer = $i+1;
            $objWorksheet->setCellValueByColumnAndRow(0,$ltf2+$placer,$placer);             
            if (isset($kegiatan[$i])){
                $objWorksheet->setCellValueByColumnAndRow(1,$ltf2+$placer,$kegiatan[$i]['jenis']);
                $objWorksheet->setCellValueByColumnAndRow(2,$ltf2+$placer,$kegiatan[$i]['keterangan']);
            } else {
                $objWorksheet->setCellValueByColumnAndRow(1,$ltf2+$placer,"");
                $objWorksheet->setCellValueByColumnAndRow(2,$ltf2+$placer,"");
            }
        }

        if (isset($sekunder['sakit']))
            $sakit = $sekunder['sakit'];
        else
            $sakit = 0;
        if (isset($sekunder['izin']))
            $izin = $sekunder['izin'];
        else
            $izin = 0;
        if (isset($sekunder['alfa']))
            $alfa = $sekunder['alfa'];
        else
            $alfa = 0;
        if (isset($sekunder['nilai']))
            $teks = $sekunder['nilai'];
        else
            $teks = "belum diisi oleh wali";

        $ltf3 = $ltf2 + $placer + 2;
        $objWorksheet->setCellValueByColumnAndRow(0,$ltf3-1," ");
        $objWorksheet->setCellValueByColumnAndRow(0,$ltf3,"No");
        $objWorksheet->setCellValueByColumnAndRow(1,$ltf3,"Ketidak Hadiran");
        $objWorksheet->setCellValueByColumnAndRow(2,$ltf3,"hari");
        $objWorksheet->setCellValueByColumnAndRow(0,$ltf3+1,1);
        $objWorksheet->setCellValueByColumnAndRow(1,$ltf3+1,"Sakit");
        $objWorksheet->setCellValueByColumnAndRow(2,$ltf3+1,$sakit);
        $objWorksheet->setCellValueByColumnAndRow(0,$ltf3+2,2);
        $objWorksheet->setCellValueByColumnAndRow(1,$ltf3+2,"Izin");
        $objWorksheet->setCellValueByColumnAndRow(2,$ltf3+2,$izin);
        $objWorksheet->setCellValueByColumnAndRow(0,$ltf3+3,3);
        $objWorksheet->setCellValueByColumnAndRow(1,$ltf3+3,"Tanpa Keterangan");
        $objWorksheet->setCellValueByColumnAndRow(2,$ltf3+3,$alfa);


        $maxX = $ltf3+2;
        
        for($x=$starting;$x<=$maxX;$x++){
            for ($y=0; $y<=9 ; $y++) { 
                $cell = PHPExcel_Cell::stringFromColumnIndex($y) . $x;
                $objWorksheet->getStyle($cell)->applyFromArray($styleNoBorder);
            }
            
        }

        

        for($x=$starting;$x<=$ltf;$x++){
            for ($y=0; $y<=9 ; $y++) { 
                $cell = PHPExcel_Cell::stringFromColumnIndex($y) . $x;
                $objWorksheet->getStyle($cell)->applyFromArray($styleArray);
            }
            
        }
        

        for($x=$starting;$x<=$ltf;$x++){
            $cell = PHPExcel_Cell::stringFromColumnIndex(0) . $x;
            $objWorksheet->getStyle($cell)->applyFromArray($styleArray1);
            for ($y=2; $y<=9 ; $y++) { 
                $cell = PHPExcel_Cell::stringFromColumnIndex($y) . $x;
                $objWorksheet->getStyle($cell)->applyFromArray($styleArray1);
            }
            
        }

        for($x=$ltf2;$x<=$ltf2+$placer;$x++){
            for ($y=0; $y<=2 ; $y++) { 
                $cell = PHPExcel_Cell::stringFromColumnIndex($y) . $x;
                $objWorksheet->getStyle($cell)->applyFromArray($styleArray1);
                $objWorksheet->getStyle($cell)->applyFromArray($styleArray);
            }
            
        }
        for($x=$ltf3;$x<=$ltf3+3;$x++){
            for ($y=0; $y<=2 ; $y++) { 
                $cell = PHPExcel_Cell::stringFromColumnIndex($y) . $x;
                $objWorksheet->getStyle($cell)->applyFromArray($styleArray1);
                $objWorksheet->getStyle($cell)->applyFromArray($styleArray);
            }
            
        }
        foreach ($cellToLeftAligned as $row) {
            $cell = PHPExcel_Cell::stringFromColumnIndex(0) . $row;
            $objWorksheet->getStyle($cell)->applyFromArray($styleArrayLeft);
        }



        $objWorksheet->mergeCells("J".$starting.":"."J".$ltf);
        // $teks = $this->nilai_m->cekNilaiFieldKI1($kd_siswa,$tahun_ajaran,$semester);
        $objWorksheet->setCellValueByColumnAndRow(9,$starting,$teks);
        $cell = PHPExcel_Cell::stringFromColumnIndex(9) . $starting;
        $objWorksheet->getStyle($cell)->applyFromArray($styleArrayVerticalTop);
        $objWorksheet->setShowGridLines(false);
        
        $objWriter = new PHPExcel_Writer_HTML($objPHPExcel);  
        $output['data'] = $objWriter->generateHTMLHeader();
        $output['data'] .= $objWriter->generateStyles();
        $output['data'] .= $objWriter->generateSheetData();
        $output['data'] .= $objWriter->generateHTMLFooter();
        $output['url'] = '<br/><p>'.anchor('batchoutput/exporterRapor2013/'.$kd_siswa.'/'.$semester.'/pdf','Download Rapor (PDF)').'</p>';

        if ($pdf != null){
            // $filename='Rapor.pdf'; //save our workbook as this file name
            // header('Content-Type: application/pdf'); //mime type
            // header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            // header('Cache-Control: max-age=0'); //no cache

            // $objWriter = new PHPExcel_Writer_PDF($objPHPExcel);  
            // $objWriter->save('php://output');
            include(APPPATH."third_party/mpdf/mpdf.php");

            $mpdf=new mPDF();
            $mpdf->SetDisplayMode('fullpage');

            $mpdf->list_indent_first_level = 0; // 1 or 0 - whether to indent the first level of a list

            $mpdf->WriteHTML($output['data']);
                    
            $mpdf->Output();
            return 0;
        }

        $this->response($output, 200);

    }

    public function getPredikat($value='')
    {
        if ($value>=0 and $value <1 ){
            return 'K';
        }
        else if ($value>=1 and $value <2 ){
            return 'C';
        }
        else if ($value>=2 and $value <3 ){
            return 'B';
        }
        else if ($value>=3 and $value <=4 ){
            return 'SB';
        }
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


    public function risky_get()
    {
        $tingkat = $this->get('tingkat');
        for ($i=1; $i < 3; $i++) { 
            $array['data'][$i] = $this->nilai->get_lower($i,$tingkat);
        }
        // echo ($array['data'][2] == null);
        // print_r($array);mm
        if ($array['data'][1]){
            $this->response($array['data'],200);
        } else {
            $this->response('Not Data',200);
        }
    }

    public function prestasiMapel_get(){
        $tingkat = $this->get('tingkat');
        $query = $this->db->query("SELECT nama_pelajaran,kd_pelajaran FROM mata_pelajaran");
        $array['data']['tingkat'] = $tingkat;
        foreach ($query->result() as $mapel) {
            $array['data']['nama_mapel'][] = $mapel->nama_pelajaran;
            $array['data']['hasil'][] = $this->nilai->get_10_mapel_santri('top',$tingkat,$mapel->kd_pelajaran);
        }
        if ($array['data']['nama_mapel'][1]){
            $this->response($array['data'],200);
        } else {
            $this->response('Not Data',404);
        }
    }

    public function overall10_get($value='')
    {
        for ($i=1; $i <=3; $i++) { 
            $array['data'][$i]['upper'] = $this->nilai->get_10_tingkat_santri('top',$i);
        }
        for ($i=1; $i <=3; $i++) { 
            $array['data'][$i]['lower'] = $this->nilai->get_10_tingkat_santri('least',$i);
        }
        // print_r($array);
        // die();
        
        if ($array['data'][1]){
            $this->response($array['data'],200);
        } else {
            $this->response('Not Data',404);
        }
    }

    public function chartTingkat_get()
    {
        //chart tingkat

        $query = $this->db->query('SELECT nama_pelajaran,kd_pelajaran FROM mata_pelajaran');
        $result= $query->result_array();
        for ($i=1; $i < 4; $i++) { 
            foreach ($result as $row) {
                $data['labels'][$i][] = $row['nama_pelajaran'];
                $hasil = $this->nilai->get_nilai_bytingkat_santri($i, $row['kd_pelajaran']);
                $data['higher'][$i][] = $hasil['nhigher'];
                $data['lower'][$i][] = $hasil['nlower'];
            }

        }
        $data['tahun_ajaran'] = $this->tahun_ajaran->getCurrentTA();
        
        if ($data){
            $this->response($data,200);
        } else {
            $this->response('Not Found',404);
        }
    }

    public function chartTingkatMapelKelas_get()
    {
        $tingkat = $this->get('tingkat');
        $tahun_ajaran = $this->get('tahun_ajaran');
        $query = $this->db->query('SELECT nama_pelajaran,kd_pelajaran FROM mata_pelajaran');
        $label = $query->result_array();
        $query = $this->db->query("SELECT kd_kelas, nama_kelas FROM kelas WHERE tingkat = '$tingkat' AND tahun_ajaran='$tahun_ajaran'");
        $kelas = $query->result_array();
        $data['jumlah_kelas'] = $query->num_rows();
        $i=0;
        foreach ($kelas as $i_kelas) {
            $data['kelas'][] = $i_kelas['nama_kelas'];
            $i++;
            foreach ($label as $mapel) {
                
                $hasil = $this->nilai->get_nilai_bytingkat_bymapel_bykelas_santri($tingkat,$mapel['kd_pelajaran'],$i_kelas['kd_kelas']);
                $data['labels'][$i][] = $mapel['nama_pelajaran'];
                $data['higher'][$i][] = $hasil['nhigher'];
                $data['lower'][$i][] = $hasil['nlower'];
            }

        }
        // print_r($data);
        // die();

        if ($data){
            $this->response($data,200);
        } else {
            $this->response('Not Found',404);
        }
    }

    public function tahun_ajaran_get(){
        $data = $this->tahun_ajaran->getCurrentTA();
        if ($data){
            $this->response($data,200);
        } else {
            $this->response('Not Found',404);
        }
    }

    public function managesiswa_get($tipe = null){
        // $this->tahun_ajaran->newTA();echo "allalala";die();
        $data = [];
        $crud = new grocery_CRUD();

        $crud->set_table('data_siswa')
        ->set_relation('jns_kelamin','tabel_jenkel','jenis_kelamin')
        ->set_relation('tahun_masuk','tahun_ajaran','tahun',null,'tahun DESC LIMIT 3')
        ->unset_fields('kd_siswa')
        ->field_type('tahun_lulus','integer')
        ->required_fields('nis','nama_siswa','status', 'tipe','tahun_masuk')
        ->unique_fields('nis')
        ->unset_texteditor('alamat','alamat_ortu','alamat_sekolah')
        ->callback_after_insert(array($this,'createUsersiswa'))
        ->callback_before_delete(array($this,'deleteUsersiswa'))
        ->field_type('status','dropdown',
            array('1' => 'Aktif', '2' => 'Tidak Aktif'))
        ->field_type('tipe','dropdown',
            array('1' => 'Reguler', '2' => 'Santri'));
        if (isset($this->session->userdata['all_siswa']))
            $crud->where('status','1');
        if ($this->session->userdata['level'] == 3)
            $crud->where('status','1');
        
        if ($this->session->userdata('level') != 9){
            $crud->unset_edit()
            ->unset_delete()
            ->unset_add();
        }

        
   

        if ($tipe == 'wali'){
            $where = "data_siswa.kd_siswa IN (SELECT kelas_siswa.kd_siswa FROM kelas_siswa WHERE kelas_siswa.kd_kelas IN (SELECT kelas.kd_kelas FROM kelas WHERE kd_guru=" . $this->session->userdata('kd_transaksi') . "))";
            $crud->where($where);
            $data['url'] = '<p><a href="'.base_url('batchoutput/exporterLeger/1').'">Klik di sini untuk download leger Semester 1</a></p>'.'<a href="'.base_url('batchoutput/exporterLeger/2').'">Klik di sini untuk download leger Semester 2</a>';
        }

        $output = $crud->render();
        
        $this->showOutput($output, $data);

    }
     
   
}