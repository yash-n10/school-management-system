<?php 
class Subject_model extends CI_Model {

function __construct()

{

parent::__construct();

$this->load->database();

}

function getSubjectName($sid){
	$this->db->select('name');
	$this->db->where('subject_id',$sid);
	$query = $this->db->get_where('subject');
	
	return $query->row_array();
}

}