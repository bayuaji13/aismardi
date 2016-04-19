<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mpartner extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
	public function getPartners(){
		$this->db->order_by('imagePriority', 'ASC');
		$query = $this->db->get('tabel_partner');
		
		return $query->result_array();
	}
}