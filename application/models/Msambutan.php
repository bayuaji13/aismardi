<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Msambutan extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
	public function getJumlahBaris(){
		return $this->db->count_all('tabel_sambutan');
	}
	
	public function getSambutan(){
		$query = $this->db->get('tabel_sambutan');
		$result = $query->row_array();
		$result['sambutanKonten'] = strip_tags($result['sambutanKonten']); 
		return $result;
	}
}