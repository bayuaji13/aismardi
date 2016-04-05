<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mpage extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
	public function getPage($pageName) {
		$query = $this->db->get_where('tabel_laman', array('pageName' => $pageName));
		return $query->row_array();
	}
}