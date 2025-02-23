<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('getsubjectname'))
{
  function getsubjectname($sid){
	  $ci =& get_instance();
	  
	  $ci->load->model('subject_model');
	  $subjectdata=$ci->subject_model->getSubjectName($sid);
	  extract($subjectdata);
	  return $subjectdata['name'];
	}
}
if(!function_exists('gettaskscount'))
{
	function gettaskscount(){
	  $ci =& get_instance();
	  $login_type = $ci->session->userdata('login_type');
      $user_id = $ci->session->userdata($login_type . '_id');
	  
	  $sdate = date('Y-m-d');
	  $edate = date('Y-m-d',strtotime('+1 week'));
	  
      $ci->load->model('task_model');
	  $tcount = $ci->task_model->getcounttask($user_id,$login_type,$sdate,$edate);
	  return $tcount;
	}
}
if(!function_exists('getcountry'))
{
	function getcountry($cid){
	  $ci =& get_instance();
	  
	  $ci->db->where('country_id',$cid);
	  
	  $qry = $ci->db->get_where('tam_country');
	  
	  $qryval = $qry->row_array();
	  
	   extract($qryval);
	   
	  return $qryval['name'];
	}
}

if(!function_exists('getPrntSkill'))
{
	function getPrntSkill($pid){
		if($pid!='none'){
	  $ci =& get_instance();
	  
	  $ci->db->where('skill_id',$pid);
	  
	  $qry = $ci->db->get_where('cce_skills');
	  
	  $qryval = $qry->row_array();
	  
	   extract($qryval);
	   
	  return $qryval['skill_name'];
		} else {
			return "No Parent";
		}
	}
}