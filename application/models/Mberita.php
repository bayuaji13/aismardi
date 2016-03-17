<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mberita extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
	public  function getBeritaByCategory($categoryId){
		$query = $this->db->get_where('tabel_berita', array('categoryId' => $categoryId));
		
		$result = $query->result_array();
		return $result;
	}
	
	public function updateUrlBeritaToDefault($categoryId){
		$news = $this->getBeritaByCategory($categoryId);
		
		if(!empty($news)){
			$data = array();
			
			foreach($news as $row){
				$newUrl = base_url("news/uncategorized/".$row['newsName']);
				array_push($data, array(
						'categoryId' => $categoryId,
						'newsUrl' => $newUrl
				));
			}
			
			$this->db->update_batch('tabel_berita', $data, 'categoryId');
		}
	}
	
	public function setCategoryToDefault($categoryId){
		$data = array(
				'categoryId' => 0
		);
		
		$this->updateUrlBeritaToDefault($categoryId);
		$this->db->update('tabel_berita', $data, array('categoryId' => $categoryId));
	}
	
	public function updateUrlBerita($categoryId) {
		$this->load->model('mcategory');
		$news = $this->getBeritaByCategory($categoryId);
		$namaKategori = $this->mcategory->getCategoryName($categoryId);
		
		if(!empty($news)){
			$data = array();
			
			foreach($news as $row){
				$newUrl = base_url("news/".$namaKategori."/".$row['newsName']);
				array_push($data, array(
						'categoryId' => $categoryId,
						'newsUrl' => $newUrl
				));
			}
			
			$this->db->update_batch('tabel_berita', $data, 'categoryId');
		}
	}
}