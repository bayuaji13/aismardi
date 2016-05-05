<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mmenu extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
	public function getMenu(){
		$query = $this->db->query("SELECT tabel_menu.*,tabel_menu_children.id as id_child,tabel_menu_children.title as title_child,tabel_menu_children.customSelect as customSelect_child
				FROM tabel_menu LEFT JOIN tabel_menu_children 
				ON tabel_menu.id=tabel_menu_children.idParent ORDER BY tabel_menu.order, tabel_menu_children.order ASC");
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
	        			'customSelect' => $row['customSelect_child'], 'select2ScrollPosition' => array('x' => 0, 'y' => 0) 
	        	));
        	}
        }
        
        $hasil = array();
        foreach ($result as $row)
        	array_push($hasil, $row);
        
        return $hasil;
	}
	
	public function getMenuView(){
		$this->load->model('mpage');
		$this->load->model('mtautan');
		$query = $this->db->query("SELECT tabel_menu.*,tabel_menu_children.id as id_child,tabel_menu_children.title as title_child,tabel_menu_children.customSelect as customSelect_child, tabel_menu_children.idParent as parent
				FROM tabel_menu LEFT JOIN tabel_menu_children
				ON tabel_menu.id=tabel_menu_children.idParent ORDER BY tabel_menu.order, tabel_menu_children.order ASC");
		$result = array();
		foreach ($query->result_array() as $row){
			$result[$row['id']]['id'] = $row['id'];
			$result[$row['id']]['title'] = $row['title'];
			if ($row['customSelect'] == null)
				$row['customSelect'] = "#";
			else {
				$url = explode("_", $row['customSelect']);
				if ($url[0] == 'laman'){
					$page = $this->mpage->getPageById($url[1]);
					$row['customSelect'] = $page['pageUrl'];
				} else if ($url[0] == 'tautan'){
					$tautan = $this->mtautan->getTautanById($url[1]);
					$row['customSelect'] = $tautan ['linkUrl'];
				} else if ($url[0] == 'home'){
					$row['customSelect'] = base_url();
				}
			}
			$result[$row['id']]['customSelect'] = $row['customSelect'];
				
			if(!is_null($row['id_child'])){
				if (!isset($result[$row['id']]['children']))
					$result[$row['id']]['children'] = array();
				if ($row['customSelect_child'] == null)
					$row['customSelect_child'] = "#";
				else {
					$url = explode("_", $row['customSelect_child']);
					if ($url[0] == 'laman'){
						$page = $this->mpage->getPageById($url[1]);
						$row['customSelect_child'] = $page['pageUrl'];
					} else if ($url[0] == 'tautan'){
						$tautan = $this->mtautan->getTautanById($url[1]);
						$row['customSelect_child'] = $tautan ['linkUrl'];
					} else if ($url[0] == 'home'){
						$row['customSelect_child'] = base_url();
					}
				}
				array_push($result[$row['id']]['children'], array('id' => $row['id_child'], 'title' => $row['title_child'],
						'customSelect' => $row['customSelect_child'], 'parent' => $row['parent'] 
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
		$orderParent = 1;
		$orderChild = 1;
		foreach ($data as $row){
			if($row['customSelect'] == "Pilih..")
				$row['customSelect'] = null;
			array_push($parent, array('id' => $row['id'], 'title' => $row['title'], 'customSelect' => $row['customSelect'], 'order' => $orderParent++));
			if(isset($row['children'])){
				foreach ($row['children'] as $child){
					if($child['customSelect'] == "Pilih..")
						$child['customSelect'] = null;
					array_push($children, array('id' => $child['id'], 'title' => $child['title'], 'customSelect' => $child['customSelect'], 'idParent' => $row['id'], 'order' => $orderChild++));
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
	
	public function getParentTitleByChildId($menuId){
		$query = $this->db->query("SELECT tabel_menu.title FROM `tabel_menu_children` LEFT JOIN `tabel_menu` ON tabel_menu_children.idParent = tabel_menu.id WHERE tabel_menu_children.customSelect = '$menuId'");
		return $query->row_array();
	}
	
	public function cekSelect($select){
		$query = $this->db->get_where('tabel_menu', array('customSelect' => $select));
		$result1 = $query->row_array();
		
		$query = $this->db->get_where('tabel_menu_children', array('customSelect' => $select));
		$result2 = $query->row_array();
		
		return (!empty($result1)) || (!empty($result2));
	}
}