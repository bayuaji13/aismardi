<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mcategory extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
	public function getCategoryName($categoryId){
		$query = $this->db->get_where('tabel_kategori', array('categoryId' => $categoryId), 1);
		
		$result = $query->row_array();
		
		return $result['categoryName'];
	}
	
	public function getCategoryCount(){
		$query = $this->db->query('SELECT `categoryId`, COUNT(`newsId`) as count FROM `tabel_berita` GROUP BY `categoryId` ');
		
		$result = $query->result_array();
		
		return $result;
	}
	
	public function updateCountCategory(){
		$category = $this->getCategoryCount();
		$data = array();
		
		foreach ($category as $row){
			array_push($data, array(
					'categoryId' => $row['categoryId'],
					'count' => $row['count']
			));
		}
		
		$this->db->update_batch('tabel_kategori', $data, 'categoryId');
	}
}