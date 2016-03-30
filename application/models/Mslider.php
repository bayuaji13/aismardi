<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mslider extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
	public function getSliders(){
		$this->db->order_by('sliderPriority', 'ASC');
		$query = $this->db->get('tabel_slider');
		
		return $query->result_array();
	}
}