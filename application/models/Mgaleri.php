<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mgaleri extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
	public function countAllGaleri(){
		return $this->db->count_all('tabel_galeri');
	}
	
	public function getGaleri($limit = "", $start = ""){
		$this->db->order_by('imagePriority', 'ASC');
		$this->db->limit($limit, $start);
		$query = $this->db->get('tabel_galeri');
		
		if($query->num_rows() > 0){
			return $query->result_array();
		}
		else
			return false;
		
	}
}