<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mtestimoni extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
	public function getTestimoni(){
		$query = $this->db->get('tabel_testi');
		$indeks = 0;
		$result = array();
		
		foreach ($query->result_array() as $row){
			$result[$indeks++] = $row;
		}
		return $result;
	}
}