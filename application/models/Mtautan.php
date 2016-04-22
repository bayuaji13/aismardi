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
	
	public function getTautanById($pageId){
		$query = $this->db->get_where('tabel_tautan', array('linkId' => $pageId));
		return $query->row_array();
	}
}