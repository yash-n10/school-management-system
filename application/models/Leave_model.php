<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class leave_model extends MY_Model {
	
	function insert_ltype($ltypedata){
		return $this->db->insert('leave_types',$ltypedata);
	}
	function getltypes(){
		$this->db->where('leave_type_delete','N');
		$query =  $this->db->get_where('leave_types');
		return $query->result();
	}
	function getltype($ltid){
		$this->db->where('leave_type_id',$ltid);
		$query =  $this->db->get_where('leave_types');
		return $query->row_array();
	}
	function update_ltype($ltypedata,$ltid){
		$this->db->where('leave_type_id',$ltid);
		return $this->db->update('leave_types',$ltypedata);
	}
	function listltypes(){
		$this->db->where('leave_type_delete','N');
		$this->db->where('leave_type_status','active');
		$query =  $this->db->get_where('leave_types');
		return $query->result();
	}
}