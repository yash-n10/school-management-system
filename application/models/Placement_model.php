<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class placement_model extends MY_Model {
	
	function insert_placement($placementdata){
		return $this->db->insert('placement',$placementdata);
	}
	function getplacements(){
		$this->db->where('placement_delete','N');
		$query =  $this->db->get_where('placement');
		return $query->result();
	}
	function getplacement($pslid){
		$this->db->where('placement_id',$pslid);
		$query =  $this->db->get_where('placement');
		return $query->row_array();
	}
	function update_placement($placementdata,$pslid){
		$this->db->where('placement_id',$pslid);
		return $this->db->update('placement',$placementdata);
	}
	function getplacementsactive(){
		$this->db->where('placement_status','active');
		$this->db->where('placement_delete','N');
		$query =  $this->db->get_where('placement');
		return $query->result();
	}
}