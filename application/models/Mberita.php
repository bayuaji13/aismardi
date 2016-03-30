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
	
	public function getLatestBerita($jumlahBerita = 6){
		$this->db->order_by('newsDate', 'DESC');
		$query = $this->db->get_where('tabel_berita', array('newsStatus' => 'Publish'), $jumlahBerita);
		$indeks = 0;
		$result = array();
		
		foreach ($query->result_array() as $row){
			if ($row['newsThumbnail'] == "" || $row['newsThumbnail'] == null){
				$row['newsThumbnail'] = 'default-news.png';
			}
			if(strlen($row['newsContent']) > 144){
				$row['newsContent'] = substr(strip_tags($row['newsContent']), 0, 144);
				$row['newsContent'] = $row['newsContent'].'....';
			}else 
				$row['newsContent'] = substr(strip_tags($row['newsContent']), 0, 144);
			
			$result[$indeks++] = $row;
		}
		return $result;
	}
}