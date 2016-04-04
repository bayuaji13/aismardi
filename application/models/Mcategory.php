<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mcategory extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
	public function getCategoryNameByPid($categoryPid){
		$query = $this->db->get_where('tabel_kategori', array('categoryPid' => $categoryPid), 1);
		
		$result = $query->row_array();
		
		return $result['categoryName'];
	}
	
	public function getCategoryPid($categoryId){
		$query = $this->db->get_where('tabel_kategori', array('categoryId' => $categoryId), 1);
	
		$result = $query->row_array();
	
		return $result['categoryPid'];
	}
	
	public function getCategoryId($categoryPid){
		$query = $this->db->get_where('tabel_kategori', array('categoryPid' => $categoryPid), 1);
	
		$result = $query->row_array();
	
		return $result['categoryId'];
	}
	
	public function getJumlahCategory(){
		$query = $this->db->query("SELECT * FROM `tabel_kategori` ORDER BY categoryId DESC LIMIT 1 ");
		
		$result = $query->row_array();
		
		return $result['categoryId'] + 1;
	}
	
	public function getCategoryCount(){
		$query = $this->db->query('select tabel_kategori.categoryId, 
				(select count(*) from tabel_berita where tabel_berita.categoryId=tabel_kategori.categoryId) as count 
				from tabel_kategori left join tabel_berita on tabel_berita.categoryId=tabel_kategori.categoryId ');
		
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