<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mmenu extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
	public function getMenu(){
		$query = $this->db->query("SELECT tabel_menu.*,tabel_menu_children.id as id_child,tabel_menu_children.title as title_child,tabel_menu_children.customSelect as customSelect_child
				FROM tabel_menu LEFT JOIN tabel_menu_children 
				ON tabel_menu.id=tabel_menu_children.idParent");
		$result = array();
        foreach ($query->result_array() as $row){
        	$result[$row['id']]['id'] = $row['id'];
        	$result[$row['id']]['title'] = $row['title'];
        	$result[$row['id']]['customSelect'] = $row['customSelect'];
        	$result[$row['id']]['select2ScrollPosition'] = array('x' => 0, 'y' => 0);
			
        	if(!is_null($row['id_child'])){
        		if (!isset($result[$row['id']]['children']))
        			$result[$row['id']]['children'] = array();
	        	array_push($result[$row['id']]['children'], array('id' => $row['id_child'], 'title' => $row['title_child'],
	        			'customSelect' => $row['customSelect_child']
	        	));
        	}
        }
        
        $hasil = array();
        foreach ($result as $row)
        	array_push($hasil, $row);
        
        return $hasil;
	}
	
	public function updateMenu(){
		$data = $this->input->post('data');
		$parent = array();
		$children = array();
		foreach ($data as $row){
			if(!is_numeric($row['customSelect']))
				$row['customSelect'] = null;
			array_push($parent, array('id' => $row['id'], 'title' => $row['title'], 'customSelect' => $row['customSelect']));
			if(isset($row['children'])){
				foreach ($row['children'] as $child){
					array_push($children, array('id' => $child['id'], 'title' => $child['title'], 'customSelect' => $child['customSelect'], 'idParent' => $row['id']));
				}	
			}
		}
		
		$this->db->truncate('tabel_menu');
		$this->db->truncate('tabel_menu_children');
		$hasil = 1;
		
		if (!empty($parent))
			$hasil &= $this->db->insert_batch('tabel_menu', $parent);
		if (!empty($children))
			$hasil &= $this->db->insert_batch('tabel_menu_children', $children);
		
		return $hasil;
	}
}