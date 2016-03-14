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
		->field_type('newsContent','text')
		->field_type('newsTitle','string')
		->field_type('newsId','invisible')
		->field_type('newsName','invisible')
		->field_type('newsDate','invisible')
		->field_type('newsUrl','invisible')
		->field_type('newsModified','invisible')
		->display_as('newsTitle','Judul Berita')
		->display_as('newsModified','Terakhir Diubah')
		->display_as('newsContent','Konten Berita')
		->display_as('categoryId','Kategori')
		->display_as('newsStatus','Status Berita')
		->required_fields('newsTitle')
		->unique_fields('newsTitle')
		->set_relation('categoryId','tabel_kategori','categoryName')
		->columns('newsTitle','newsContent', 'categoryId', 'newsStatus', 'newsModified')
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
		
		$post_array['newsName'] = str_replace(" ", "-", $post_array['newsTitle']);
		$post_array['newsModified'] = date("Y-m-d H:i:s");
		$post_array['newsUrl'] = base_url("news/".$categoryName.$post_array['newsName']);
		
		return $post_array;
	}
	
	public function newsBeforeInsert($post_array) {
		$this->load->model('mcategory');
		$categoryName = $this->mcategory->getCategoryName($post_array['categoryId']);
		$categoryName = strtolower($categoryName);
		
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
		->field_type('newsContent','text')
		->field_type('newsTitle','string')
		->field_type('newsId','invisible')
		->field_type('newsName','invisible')
		->field_type('newsDate','invisible')
		->field_type('newsUrl','invisible')
		->field_type('newsModified','invisible')
		->display_as('newsTitle','Judul Berita')
		->display_as('newsModified','Terakhir Diubah')
		->display_as('newsContent','Konten Berita')
		->display_as('categoryId','Kategori')
		->display_as('newsStatus','Status Berita')
		->required_fields('newsTitle')
		->unique_fields('newsTitle')
		->set_relation('categoryId','tabel_kategori','categoryName')
		->columns('newsTitle','newsContent', 'categoryId', 'newsStatus', 'newsModified')
		->order_by('newsDate','desc')
		->unset_export()
		->unset_print();
	
	
		if ($this->session->userdata('level') != 9){
			$crud->unset_edit()
			->unset_delete();
		}
	
	
		$crud->callback_before_update(array($this,'newsBeforeUpdate'))
		->callback_before_insert(array($this,'newsBeforeInsert'));
	
		$output = $crud->render();
		$output->output ='<h3><i class="fa fa-angle-right"></i>Daftar Berita </h3> <br/>' . $output->output;
		$this->showOutput($output);
	}
}