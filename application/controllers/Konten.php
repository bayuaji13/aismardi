<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Konten extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->database();
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->library('grocery_CRUD');
		
	}
	
	function showOutput($output = null)
	{
		$this->showHeader();
		$this->load->view('crud/manage',$output);
		$this->load->view('footer_crud');
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
		->display_as('newsTitle','Judul Berita')
		->display_as('newsModified','Terakhir Diubah')
		->display_as('newsContent','Konten Berita')
		->display_as('categoryId','Kategori')
		->display_as('newsStatus','Status Berita')
		->display_as('newsUrl','URL Berita')
		->required_fields('newsTitle', 'newsStatus')
		->unique_fields('newsTitle')
		->set_relation('categoryId','tabel_kategori','categoryName')
		->columns('newsTitle','newsContent', 'categoryId', 'newsStatus', 'newsModified', 'newsUrl')
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
		$categoryName = $this->mcategory->getCategoryName($post_array['categoryId']);
		
		if($post_array['categoryId'] == ""){
			$post_array['categoryId'] = 0;
		}
		
		$post_array['newsTitle'] = strip_tags($post_array['newsTitle']);
		$post_array['newsName'] = str_replace(" ", "-", $post_array['newsTitle']);
		$post_array['newsModified'] = date("Y-m-d H:i:s");
		$post_array['newsUrl'] = base_url("news/".$categoryName."/".$post_array['newsName']);
		
		return $post_array;
	}
	
	public function newsBeforeInsert($post_array) {
		$this->load->model('mcategory');
		$categoryName = $this->mcategory->getCategoryName($post_array['categoryId']);
		$categoryName = strtolower($categoryName);
		
		$post_array['newsTitle'] = strip_tags($post_array['newsTitle']);
		$post_array['newsName'] = str_replace(" ", "-", strtolower($post_array['newsTitle']));
		$post_array['newsDate'] = date("Y-m-d H:i:s");
		$post_array['newsModified'] = date("Y-m-d H:i:s");
		$post_array['newsUrl'] = base_url("news/".$categoryName."/".$post_array['newsName']);
		
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
		$post_array['categoryName'] = strip_tags($post_array['categoryName']); 
		$this->load->model('mcategory');
		$post_array['categoryId'] = $this->mcategory->getJumlahCategory(); 
		
		return $post_array;
	}
	
	public function categoryBeforeUpdate($post_array){
		$post_array['categoryName'] = strip_tags($post_array['categoryName']); 
		return $post_array;
	}
	
	public function categoryAfterUpdate($post_array,$primary_key){
		$this->load->model('mberita');
		$this->mberita->updateUrlBerita($primary_key);
	}
	
	public function categoryBeforeDelete($idCategory){
		if($idCategory == 0)
			return false;
		else{
			$this->load->model('mberita');
			$this->load->model('mcategory');
			$this->mberita->setCategoryToDefault($idCategory);
			$this->mcategory->updateCountCategory();
			return true;
		}
	}
}