<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mtautan extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
	public function getTautan(){
		$query = $this->db->get('tabel_tautan');
		return $query->result_array();
	}
}