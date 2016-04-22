<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Konten extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->library('grocery_CRUD');
		$level = $this->session->userdata('level');
		if ($level != 9){
			redirect('users/login');
		}
	}
	
	function showOutput($output = null)
	{
		$this->showHeader();
		$this->load->view('crud/manage',$output);
		$this->load->view('footer_crud');
	}
	
	function alphanumericAndSpace( $string )
	{
		return preg_replace('/[^0-9a-zA-Z ]/', '', $string);
	}
	
	public function manageNews(){
		
		$crud = new grocery_CRUD();
	
		$crud->set_table('tabel_berita')
		->set_subject('News')
		->unset_read()
		->field_type('newsContent','text')
		->field_type('newsTitle','string')
		->field_type('newsId','invisible')
		->field_type('newsName','invisible')
		->field_type('newsDate','invisible')
		->field_type('newsUrl','hidden')
		->field_type('newsModified','invisible')
		->set_field_upload('newsThumbnail', 'assets/uploads/images/images')
		->display_as('newsTitle','Judul Berita')
		->display_as('newsThumbnail','Thumbnail Berita')
		->display_as('newsModified','Terakhir Diubah')
		->display_as('newsContent','Konten Berita')
		->display_as('categoryId','Kategori')
		->display_as('newsStatus','Status Berita')
		->display_as('newsUrl','URL Berita')
		->required_fields('newsTitle', 'newsStatus')
		->unique_fields('newsTitle')
		->set_relation('categoryId','tabel_kategori','categoryName')
		->columns('newsTitle', 'newsThumbnail', 'newsContent', 'categoryId', 'newsStatus', 'newsModified', 'newsUrl')
		->order_by('newsDate','desc')
		->unset_export()
		->unset_print();
		
	
		if ($this->session->userdata('level') != 9){
			$crud->unset_edit()
			->unset_delete();
		}
	
	
		$crud->callback_before_update(array($this,'newsBeforeUpdate'))
		->callback_before_insert(array($this,'newsBeforeInsert'))
		->callback_after_insert(array($this,'newsAfterOperation'))
		->callback_after_update(array($this,'newsAfterOperation'))
		->callback_after_delete(array($this,'newsAfterOperation'));
	
		$output = $crud->render();
		$output->output ='<h3><i class="fa fa-angle-right"></i>Daftar Berita </h3> <br/>' . $output->output;
		$this->showOutput($output);
	}
	
	public function newsBeforeUpdate($post_array){
		$this->load->model('mcategory');
		$categoryName = $this->mcategory->getCategoryPid($post_array['categoryId']);
		
		if($post_array['categoryId'] == ""){
			$post_array['categoryId'] = 0;
		}
		$post_array['newsContent'] = $this->security->xss_clean($post_array['newsContent']);
		$post_array['newsTitle'] = strip_tags($post_array['newsTitle']);
		$post_array['newsName'] = str_replace(" ", "-", $this->alphanumericAndSpace(strtolower($post_array['newsTitle'])));
		$post_array['newsModified'] = date("Y-m-d H:i:s");
		$post_array['newsUrl'] = base_url("berita/".$categoryName."/".$post_array['newsName']);
		
		return $post_array;
	}
	
	public function newsBeforeInsert($post_array) {
		$this->load->model('mcategory');
		$categoryName = $this->mcategory->getCategoryPid($post_array['categoryId']);
		$categoryName = strtolower($categoryName);
		$post_array['newsContent'] = $this->security->xss_clean($post_array['newsContent']);
		$post_array['newsTitle'] = strip_tags($post_array['newsTitle']);
		$post_array['newsName'] = str_replace(" ", "-", $this->alphanumericAndSpace(strtolower($post_array['newsTitle'])));
		$post_array['newsDate'] = date("Y-m-d H:i:s");
		$post_array['newsModified'] = date("Y-m-d H:i:s");
		$post_array['newsUrl'] = base_url("berita/".$categoryName."/".$post_array['newsName']);
		
		return $post_array;
	}
	
	public function newsAfterOperation($post_array){
		$this->load->model('mcategory');
		return $this->mcategory->updateCountCategory();
	}
	
	public function manageCategory(){
	
		$crud = new grocery_CRUD();
	
		$crud->set_table('tabel_kategori')
		->set_subject('Kategori')
		->unset_read()
		->field_type('categoryId','invisible')
		->field_type('categoryName','string')
		->field_type('count','invisible')
		->field_type('categoryPid','invisible')
		->display_as('categoryId','ID Kategori')
		->display_as('categoryName','Nama Kategori')
		->display_as('count','Jumlah Berita')
		->required_fields('categoryName')
		->unique_fields('categoryName')
		->columns('categoryName', 'count')
		->order_by('categoryId','asc')
		->unset_export()
		->unset_print();
	
	
		if ($this->session->userdata('level') != 9){
			$crud->unset_edit()
			->unset_delete();
		}
		
		$crud->callback_before_insert(array($this,'categoryBeforeInsert'))
		->callback_before_update(array($this,'categoryBeforeUpdate'))
		->callback_after_update(array($this,'categoryAfterUpdate'))
		->callback_before_delete(array($this,'categoryBeforeDelete'));
	
		$output = $crud->render();
		$output->output ='<h3><i class="fa fa-angle-right"></i>Daftar Kategori </h3> <br/>' . $output->output;
		$this->showOutput($output);
	}
	
	public function categoryBeforeInsert($post_array){
		$post_array['categoryName'] = $this->alphanumericAndSpace(strip_tags($post_array['categoryName'])); 
		$post_array['categoryPid'] = str_replace(" ", "-", strtolower($post_array['categoryName']));
		$this->load->model('mcategory');
		$post_array['categoryId'] = $this->mcategory->getJumlahCategory(); 
		
		return $post_array;
	}
	
	public function categoryBeforeUpdate($post_array){
		$post_array['categoryName'] = $this->alphanumericAndSpace(strip_tags($post_array['categoryName'])); 
		$post_array['categoryPid'] = str_replace(" ", "-", strtolower($post_array['categoryName']));
		return $post_array;
	}
	
	public function categoryAfterUpdate($post_array,$primary_key){
		$this->load->model('mberita');
		$this->mberita->updateUrlBerita($primary_key);
	}
	
	public function categoryBeforeDelete($idCategory){
		if($idCategory == 1)
			return false;
		else{
			$this->load->model('mberita');
			$this->load->model('mcategory');
			$this->mberita->setCategoryToDefault($idCategory);
			$this->mcategory->updateCountCategory();
			return true;
		}
	}
	
	public function managePage(){
	
		$crud = new grocery_CRUD();
	
		$crud->set_table('tabel_laman')
		->set_subject('Laman')
		->unset_read()
		->field_type('pageContent','text')
		->field_type('pageTitle','string')
		->field_type('pageId','invisible')
		->field_type('pageName','invisible')
		->field_type('pageDate','invisible')
		->field_type('pageUrl','hidden')
		->field_type('pageModified','invisible')
		->display_as('pageTitle','Judul Laman')
		->display_as('pageModified','Terakhir Diubah')
		->display_as('pageContent','Konten Laman')
		->display_as('pageStatus','Status Laman')
		->display_as('pageUrl','URL Laman')
		->required_fields('pageTitle', 'pageStatus')
		->unique_fields('pageTitle')
		->columns('pageTitle','pageContent', 'pageStatus', 'pageModified', 'pageUrl')
		->order_by('pageDate','desc')
		->unset_export()
		->unset_print();
	
		if ($this->session->userdata('level') != 9){
			$crud->unset_edit()
			->unset_delete();
		}
	
	
		$crud->callback_before_update(array($this,'pageBeforeUpdate'))
		->callback_before_insert(array($this,'pageBeforeInsert'))
		->callback_before_delete(array($this,'pageBeforeDelete'));
	
		$output = $crud->render();
		$output->output ='<h3><i class="fa fa-angle-right"></i>Daftar Berita </h3> <br/>' . $output->output;
		$this->showOutput($output);
	}
	
	public function pageBeforeUpdate($post_array){
		$post_array['pageContent'] = $this->security->xss_clean($post_array['pageContent']);
		$post_array['pageTitle'] = strip_tags($post_array['pageTitle']);
		$post_array['pageName'] = str_replace(" ", "-", $this->alphanumericAndSpace(strtolower($post_array['pageTitle'])));
		$post_array['pageModified'] = date("Y-m-d H:i:s");
		$post_array['pageUrl'] = base_url("page/".$post_array['pageName']);
	
		return $post_array;
	}
	
	public function pageBeforeInsert($post_array) {
		$post_array['pageContent'] = $this->security->xss_clean($post_array['pageContent']);
		$post_array['pageTitle'] = strip_tags($post_array['pageTitle']);
		$post_array['pageName'] = str_replace(" ", "-", $this->alphanumericAndSpace(strtolower($post_array['pageTitle'])));
		$post_array['pageDate'] = date("Y-m-d H:i:s");
		$post_array['pageModified'] = date("Y-m-d H:i:s");
		$post_array['pageUrl'] = base_url("page/".$post_array['pageName']);
	
		return $post_array;
	}
	
	public function pageBeforeDelete($idLaman){
		$this->load->model('mmenu');
		$idLaman = 'laman_'.$idLaman;
		return !$this->mmenu->cekSelect($idLaman);
	}
	
	public function manageEvent(){
	
		$crud = new grocery_CRUD();
	
		$crud->set_table('tabel_event')
		->set_subject('Event')
		->unset_read()
		->field_type('locationName','string')
		->field_type('content','text')
		->display_as('eventTitle','Judul Event')
		->display_as('startDate','Waktu Mulai')
		->display_as('endDate','Waktu Selesai')
		->display_as('locationName','Lokasi')
		->display_as('eventContent','Deskripsi Event')
		->required_fields('eventTitle')
		->columns('eventTitle', 'startDate','endDate', 'locationName', 'eventContent')
		->fields('eventTitle', 'startDate','endDate', 'locationName', 'eventContent')
		->order_by('eventId','asc')
		->set_rules('eventContent', 'Deskripsi Event', 'max_length[255]')
		->unset_export()
		->unset_print();
	
		if ($this->session->userdata('level') != 9){
			$crud->unset_edit()
			->unset_delete();
		}
	
	
		$crud->callback_before_update(array($this,'eventBefore'))
		->callback_before_insert(array($this,'eventBefore'));
	
		$output = $crud->render();
		$output->output ='<h3><i class="fa fa-angle-right"></i>Daftar Event </h3> <br/>' . $output->output;
		$this->showOutput($output);
	}
	
	public function eventBefore($post_array){
		$post_array['eventTitle'] = strip_tags($post_array['eventTitle']);
		
		return $post_array;
	}
	
	public function manageGallery(){
		$this->load->library('image_CRUD');
		
		$image_crud = new image_CRUD();
		$image_crud->set_table('tabel_galeri')
		->set_primary_key_field('imageId');
		$image_crud->set_url_field('imageUrl')
		->set_title_field('imageTitle')
		->set_ordering_field('imagePriority')
		->set_image_path('assets/uploads/images/galleries');
		
		$output = $image_crud->render();
		$output->output ='<h3><i class="fa fa-angle-right"></i>Galeri </h3> <br/>
				(Harap refresh halaman setelah selesai proses upload) <br/>' . $output->output;
		$this->showOutput($output);
	}
	
	public function manageSlider(){
		$this->load->library('image_CRUD');
	
		$image_crud = new image_CRUD();
		$image_crud->set_table('tabel_slider')
		->set_primary_key_field('sliderId');
		$image_crud->set_url_field('sliderUrl')
		->set_title_field('sliderTitle')
		->set_ordering_field('sliderPriority')
		->set_image_path('assets/uploads/images/sliders');
	
		$output = $image_crud->render();
		$output->output ='<h3><i class="fa fa-angle-right"></i>Slider </h3> <br/>Untuk hasil
				yang optimal gunakan gambar dengan dimensi 1140x350 (Harap refresh halaman setelah selesai proses upload)
				<br/>' . $output->output;
		$this->showOutput($output);
	}
	
	public function managePartner(){
		$this->load->library('image_CRUD');
	
		$image_crud = new image_CRUD();
		$image_crud->set_table('tabel_partner')
		->set_primary_key_field('imageId');
		$image_crud->set_url_field('imageUrl')
		->set_title_field('imageTitle')
		->set_ordering_field('imagePriority')
		->set_image_path('assets/uploads/images/partners');
	
		$output = $image_crud->render();
		$output->output ='<h3><i class="fa fa-angle-right"></i>Partner </h3> <br/>
				(Harap refresh halaman setelah selesai proses upload) <br/>' . $output->output;
		$this->showOutput($output);
	}
	
	public function manageSambutan(){
		$this->load->model('msambutan');
		$crud = new grocery_CRUD();
	
		$crud->set_table('tabel_sambutan')
		->set_subject('Sambutan Kepala Sekolah')
		->unset_read()
		->field_type('sambutanKonten','text')
		->display_as('sambutanKonten','Isi Sambutan')
		->display_as('imageUrl','Foto Kepala Sekolah')
		->required_fields('sambutanKonten', 'imageUrl')
		->columns('imageUrl', 'sambutanKonten')
		->fields('imageUrl', 'sambutanKonten')
		->order_by('sambutanId','asc')
		->set_field_upload('imageUrl', 'assets/uploads/images/sambutan')
		->unset_export()
		->unset_print();
		
		if($this->msambutan->getJumlahBaris() >= 1)
			$crud->unset_add();
		
		if ($this->session->userdata('level') != 9){
			$crud->unset_edit()
			->unset_delete();
		}
		
		$crud->callback_before_upload(array($this, 'before_test_upload'));
	
		$output = $crud->render();
		$output->output ='<h3><i class="fa fa-angle-right"></i>Sambutan Kepala Sekolah </h3> <br/>' . $output->output;
		$this->showOutput($output);
	}
	
	public function before_test_upload($files_to_upload, $field_info){
		foreach($files_to_upload as $value) {
			$ext = pathinfo($value['name'], PATHINFO_EXTENSION);
		}
		
		$allowed_formats = array("jpg", "gif", "png", "jpeg");
		if(in_array($ext,$allowed_formats)){
			return true;
		}
		else{
			return 'Hanya bisa upload .jpg, .jpeg, .png, .gif';
		}
	}
	
	public function manageTesti(){
		$crud = new grocery_CRUD();
	
		$crud->set_table('tabel_testi')
		->set_subject('Testimonial Siswa')
		->unset_read()
		->display_as('testiImage','Foto Pemberi Testimoni')
		->display_as('testiName','Nama Pemberi Testimoni')
		->display_as('testiAngkatan','Angkatan Pemberi Testimoni')
		->display_as('testiContent','Konten Testimoni')
		->required_fields('testiImage', 'testiName', 'testiAngkatan', 'testiContent')
		->columns('testiImage', 'testiName', 'testiAngkatan', 'testiContent')
		->fields('testiImage', 'testiName', 'testiAngkatan', 'testiContent')
		->set_rules('testiContent', 'Angkatan Pemberi Testimoni', 'max_length[255]')
		->set_rules('testiName', 'Angkatan Pemberi Testimoni', 'max_length[64]')
		->set_rules('testiAngkatan', 'Angkatan Pemberi Testimoni', 'max_length[8]')
		->order_by('testiId','asc')
		->set_field_upload('testiImage', 'assets/uploads/images/sambutan')
		->unset_export()
		->unset_print();
	
		if ($this->session->userdata('level') != 9){
			$crud->unset_edit()
			->unset_delete();
		}
	
		$crud->callback_before_upload(array($this, 'before_test_upload'))
		->callback_before_update(array($this,'testiBefore'))
		->callback_before_insert(array($this,'testiBefore'));
	
		$output = $crud->render();
		$output->output ='<h3><i class="fa fa-angle-right"></i>Testimonial Siswa </h3> (Gunakan foto dengan ukuran 90x60)<br/>' . $output->output;
		$this->showOutput($output);
	}
	
	public function testiBefore($post_array){
		$post_array['testiContent'] = strip_tags($post_array['testiContent']);
	
		return $post_array;
	}
	
	public function manageLinks(){
		$crud = new grocery_CRUD();
	
		$crud->set_table('tabel_tautan')
		->set_subject('Daftar Tautan')
		->unset_read()		
		->display_as('linkName','Nama Link')
		->display_as('linkUrl','URL Tautan')
		->required_fields('linkName', 'linkUrl')
		->columns('linkName', 'linkUrl')
		->fields('linkName', 'linkUrl')
		->set_rules('linkUrl', 'URL Tautan', 'valid_url')
		->order_by('linkId','asc')
		->unset_export()
		->unset_print();
	
		if ($this->session->userdata('level') != 9){
			$crud->unset_edit()
			->unset_delete();
		}
		
		$crud->callback_field('linkUrl',array($this,'_callback_url'))
		->callback_before_delete(array($this,'tautanBeforeDelete'));
	
		$output = $crud->render();
		$output->output ='<h3><i class="fa fa-angle-right"></i>Daftar Tautan </h3> <br/>' . $output->output;
		$this->showOutput($output);
	}
	
	public function tautanBeforeDelete($idTautan){
		$this->load->model('mmenu');
		$idTautan = 'tautan_'.$idTautan;
		return !$this->mmenu->cekSelect($idTautan);
	}
	
	public function _callback_url($value = '', $primary_key = null) {
		
		return '<input type="text" maxlength="128" name="linkUrl" placeholder="http://">';
	}
	
	public function manageMenu(){
		$level = $this->session->userdata('level');
		if ($level == null){
			redirect('users/login');
		}
		$this->load->model('mpage');
		$this->load->model('mtautan');
		$data['pages'] = $this->mpage->getPages();
		$data['tautan'] = $this->mtautan->getTautan();
		$this->load->view('header_menu');
		$this->load->view('menu/menumanager', $data);
		$this->load->view('footer_menu');
	}
}