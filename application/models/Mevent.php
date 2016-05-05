<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mevent extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
	public function getLatestEvents($jumlahEvent = 3){
		$this->db->order_by('startDate', 'DESC');
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		$this->db->or_where(array('startDate >=' => $now, 'endDate >=' => $now));
		$query = $this->db->get('tabel_event', $jumlahEvent);
		$indeks = 0;
		$result = array();
	
		foreach ($query->result_array() as $row){
			$dt = new DateTime($row['startDate']);
			
			$dateBegin = $dt->format('m/d/Y');
			$timeBegin = $dt->format('H:i:s');
			$dayBegin = $dt->format('d');
			$monthBegin = $dt->format('M');
			$hourBegin = $dt->format('H:i');
			
			$dt = new DateTime($row['endDate']);
				
			$dateEnded = $dt->format('m/d/Y');
			$dayEnded = $dt->format('d');
			$monthEnded = $dt->format('M');
			$hourEnded = $dt->format('H:i');
			
			if ($dayBegin == $dayEnded){
				$row['duration'] = 'day';
				$row['dayBegin'] = $dayBegin;
				$row['monthBegin'] = $monthBegin;
				$row['hourBegin'] = $hourBegin;
				$row['hourEnded'] = $hourEnded;
			}else{
				$row['duration'] = 'days';
				$row['dayBegin'] = $dayBegin;
				$row['monthBegin'] = $monthBegin;
				$row['dayEnded'] = $dayEnded;
				$row['monthEnded'] = $monthEnded;
			}
			$result[$indeks++] = $row;
		}
		return $result;
	}
	
	public function getEvent($limit = "", $start = ""){
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		
		$this->db->order_by('startDate', 'DESC');
		$this->db->limit($limit, $start);
		$this->db->or_where(array('startDate >=' => $now, 'endDate >=' => $now));
		$query = $this->db->get('tabel_event');
		
		$indeks = 0;
		$result = array();
		
		foreach ($query->result_array() as $row){
			$dt = new DateTime($row['startDate']);
				
			$dateBegin = $dt->format('m/d/Y');
			$timeBegin = $dt->format('H:i:s');
			$dayBegin = $dt->format('d');
			$monthBegin = $dt->format('M');
			$hourBegin = $dt->format('H:i');
				
			$dt = new DateTime($row['endDate']);
		
			$dateEnded = $dt->format('m/d/Y');
			$dayEnded = $dt->format('d');
			$monthEnded = $dt->format('M');
			$hourEnded = $dt->format('H:i');
				
			if ($dayBegin == $dayEnded){
				$row['duration'] = 'day';
				$row['dayBegin'] = $dayBegin;
				$row['monthBegin'] = $monthBegin;
				$row['hourBegin'] = $hourBegin;
				$row['hourEnded'] = $hourEnded;
			}else{
				$row['duration'] = 'days';
				$row['dayBegin'] = $dayBegin;
				$row['monthBegin'] = $monthBegin;
				$row['dayEnded'] = $dayEnded;
				$row['monthEnded'] = $monthEnded;
			}
			$result[$indeks++] = $row;
		}
		return $result;
	}
	
	public function countAllEvent(){
		$now = new DateTime();
		$now = $now->format('Y-m-d H:i:s');
		$this->db->or_where(array('startDate >=' => $now, 'endDate >=' => $now));
		return $this->db->count_all_results('tabel_event');
	}
}