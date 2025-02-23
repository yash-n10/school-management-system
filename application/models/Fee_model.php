<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class fee_model extends MY_Model {
	
	function insert_feecategory($fcdata){
		return $this->db->insert('fee_categories',$fcdata);
	}
	
	function getfeecategories(){
		$this->db->where('fee_category_delete','N');
		$query =  $this->db->get_where('fee_categories');
		return $query->result();
	}
	function getfeecategory($fc_id){
		$this->db->where('fee_category_id',$fc_id);
		$query =  $this->db->get_where('fee_categories');
		return $query->row_array();
	}
	function update_feecategory($fcdata,$fc_id){
		$this->db->where('fee_category_id',$fc_id);
		return $this->db->update('fee_categories',$fcdata);
	}
	function feecategory_count($fc_val,$prv_fc_val){
		
		$this->db->where('fee_category',$fc_val);
		$this->db->where('fee_category !=',$prv_fc_val);
		$this->db->where('fee_category_delete','N');
		return $this->db->count_all_results('fee_categories');
		
	}
	function feecategory_inc_count($fc_inc_val,$prv_fc_inc_val){
		
		$this->db->where('fc_invoice_pre_fix',$fc_inc_val);
		$this->db->where('fc_invoice_pre_fix !=',$prv_fc_inc_val);
		$this->db->where('fee_category_delete','N');
		return $this->db->count_all_results('fee_categories');
		
	}
	function getstandard(){
		$this->db->where('standard_status','active');
		$query = $this->db->get_where('standard');
		return $query->result();
	}
	function getclass(){
		$query = $this->db->get_where('class');
		return $query->result();
	}
	function getrolls($fp_cid){
		$this->db->where('class_id',$fp_cid);
		//$this->db->where('student_academicyear_id',$this->session->userdata('academic_year'));
		$query = $this->db->get_where('student');
		return $query->result();
	}
	function getrolls2($fp_cid){
		$this->db->where('class_id',$fp_cid);
		//$this->db->where('student_academicyear_id',$this->session->userdata('academic_year'));
		$query = $this->db->get_where('student');
		return $query->result();
	}
	function getdnumber($fp_cid2){		
		$this->db->where('room_id',$fp_cid2);		
		$query = $this->db->get_where('room');
		return $query->result();
	}
	function insert_feeparticular($fpdata){
		return $this->db->insert('fee_particulars',$fpdata);
	}
	
	function getfeeparticulars(){
		$this->db->select('fee_categories.fee_category as fcategory,fee_particulars.*');
		$this->db->from('fee_particulars,fee_categories');
		$this->db->where('fee_categories.fee_category_id = fee_particulars.fee_category_id');
		$this->db->where('fee_particular_delete','N');
		$this->db->where('fee_category_delete','N');
		$query =  $this->db->get_where();
		return $query->result();
	}
	function update_feeparticular($fpdata,$fp_id){
		$this->db->where('fee_particular_id',$fp_id);
		return $this->db->update('fee_particulars',$fpdata);
	}
	function update_cfeeparticular($fpdata,$fp_cid){
		$this->db->where('fee_category_id',$fp_cid);
		return $this->db->update('fee_particulars',$fpdata);
	}
	function getsrolls($srolls,$sclass){
		
     	$sids = explode(",",$srolls);
		$this->db->select('roll,name,father_name');
		$this->db->where_in('student_id',$sids );
		$this->db->where('class_id',$sclass);
		$query =  $this->db->get_where('student');
		return $query->result();
	}
	function getfeeparticular($fp_id){
		
		$this->db->select('fee_categories.fee_category as fcategory,fee_particulars.*');
		$this->db->from('fee_particulars,fee_categories');
		$this->db->where('fee_categories.fee_category_id = fee_particulars.fee_category_id');
		$this->db->where('fee_particular_id',$fp_id);
		$this->db->where('fee_particular_delete','N');
		$query =  $this->db->get_where();
		return $query->row_array();
		
	}
	function getfcdata(){
		$this->db->select('fee_category_id,fee_category');
		$this->db->where('fee_category_status','active');
		$this->db->where('fee_category_delete','N');
		$query =  $this->db->get_where('fee_categories');
		return $query->result();
	}
	function getfpdata($fc_id){
		$this->db->select('fee_particular_id,fee_particular_name');
		$this->db->where('fee_category_id',$fc_id);
		$this->db->where('fee_particular_status','active');
		$this->db->where('fee_particular_delete','N');
		$query =  $this->db->get_where('fee_particulars');
		return $query->result();
	}
	function insert_feeperiod($fcpdata){
		
		return $this->db->insert('fee_periods',$fcpdata);
		
	}
	function getfeeperiods(){
		
		$this->db->select('fee_categories.fee_category as fcategory,fee_particulars.fee_particular_name as fpname,fee_periods.*');
		$this->db->from('fee_periods');
		$this->db->join('fee_categories','fee_categories.fee_category_id = fee_periods.fee_period_cid');
		$this->db->join('fee_particulars','fee_particulars.fee_particular_id = fee_periods.fee_period_pid');
		$this->db->where('fee_particular_delete','N');
		$this->db->where('fee_period_delete','N');
		$query = $this->db->get();
		return $query->result();
		
	}
	function update_feeperiod($fpdata,$fp_id){
		$this->db->where('fee_period_id',$fp_id);
		return $this->db->update('fee_periods',$fpdata);
	}
	function getfeeperiod($fp_id){
		$this->db->where('fee_period_id',$fp_id);
		$query =  $this->db->get_where('fee_periods');
		return $query->row_array();

	}
	function getfeepperiod($fp_id){
		$this->db->where('fee_period_pid',$fp_id);
		$query =  $this->db->get_where('fee_periods');
		return $query->row_array();

	}
	
	function chkparticular($fp_val,$fc_id,$prv_fp_val){
		
		$this->db->where('fee_category_id',$fc_id);
		$this->db->where('fee_particular_name',$fp_val);
		$this->db->where('fee_particular_name !=',$prv_fp_val);
		
		return $this->db->count_all_results('fee_particulars');
		
	}
	function getfeeclassdata($fc_cid){
		$this->db->select('fee_categories.fee_category,class.name cname,class.name_numeric nname,fee_particulars.*,');
		$this->db->from('fee_particulars');
		$this->db->join('fee_categories','fee_categories.fee_category_id = fee_particulars.fee_category_id');
		$this->db->join('class ','class.class_id  = fee_particulars.fee_particular_type_id');
		$this->db->where('fee_category_status','active');
		$this->db->where('fee_category_delete','N');
		$this->db->where('fee_particular_status','active');
		$this->db->where('fee_particular_delete','N');
		$this->db->where('fee_particular_type_id',$fc_cid);
		$query = $this->db->get();
		
		return $query->result();
	}
	function getfeealldata($fc_cid){
		$this->db->select('fee_categories.fee_category,class.name cname,class.name_numeric nname,fee_particulars.*,');
		$this->db->from('fee_particulars,class');
		$this->db->join('fee_categories','fee_categories.fee_category_id = fee_particulars.fee_category_id');
		//$this->db->join('class ','class.class_id  = fee_particulars.fee_particular_type_id');
		$this->db->where('fee_category_status','active');
		$this->db->where('fee_category_delete','N');
		$this->db->where('fee_particular_status','active');
		$this->db->where('fee_particular_delete','N');
		
		$this->db->where('fee_particular_type','fp_all');
		$this->db->where('class.class_id',$fc_cid);
		$query = $this->db->get();
		
		return $query->result();
	}
	function getfeerolldata($fc_cid,$fc_rollid){
		
		$this->db->select('fee_categories.fee_category,class.name cname,class.name_numeric nname,fee_particulars.*,');
		$this->db->from('fee_particulars');
		$this->db->join('fee_categories','fee_categories.fee_category_id = fee_particulars.fee_category_id');
		$this->db->join('class ','class.class_id  = fee_particulars.fee_particular_type_cid');
		$this->db->like('fee_particular_type_id',','.$fc_rollid.',');
		$this->db->where('fee_category_status','active');
		$this->db->where('fee_category_delete','N');
		$this->db->where('fee_particular_status','active');
		$this->db->where('fee_particular_delete','N');
		
		$this->db->where('fee_particular_type_cid',$fc_cid);
		$query = $this->db->get();
		return $query->result();
		
	}
	
	function getfeestandarddata($fc_cid){
		
		$this->db->select('standard_id');
		$this->db->from('class');
		$this->db->where('class_id',$fc_cid);
		$query = $this->db->get();
		
		$query_res =$query->row_array();
		
		extract($query_res); 
		
		$this->db->select('fee_categories.fee_category,class.name cname,class.name_numeric nname,fee_particulars.*,');
		$this->db->from('fee_particulars,class');
		$this->db->join('fee_categories','fee_categories.fee_category_id = fee_particulars.fee_category_id');
		$this->db->where('fee_particular_type_id',$standard_id);
		$this->db->where('fee_category_status','active');
		$this->db->where('fee_category_delete','N');
		$this->db->where('fee_particular_status','active');
		$this->db->where('fee_particular_delete','N');
		$this->db->where('class.class_id',$fc_cid);
		$query = $this->db->get();
		
		return $query->result();
	}
	
	function insert_fee_collection($fee_collect_data){
		
		return $this->db->insert('fee_collections',$fee_collect_data);
		
	}
	
	function getSumPaid($fc_perid,$fc_class_id,$fc_roll_id){
		
		$this->db->select_sum('fee_collection_amount');
		$this->db->where('fee_collection_class_id',$fc_class_id);
		$this->db->where('fee_collection_roll_id',$fc_roll_id);
		$this->db->where('fee_collection_particular_id',$fc_perid);
		$query = $this->db->get('fee_collections');
		
		$res = $query->row_array();
		extract($res); return $fee_collection_amount;
	}
	
	function getReceiptData($receipt_id){
		
		$this->db->select('class.name as cname,student.name as sname,student.father_name as fname,student.student_parent_email rmail,student.address as raddress,admin.name as aname,fee_particular_name as pname,fee_particular_discount as discount,fee_particular_amount as pamount,fee_category_id as cat_id, fee_collections.*');
		$this->db->from('fee_collections');
		$this->db->join('class','class_id = fee_collection_class_id');
		$this->db->join('student','student_id = fee_collection_roll_id');
		$this->db->join('fee_particulars','fee_particular_id = fee_collection_particular_id');
		$this->db->join('admin','admin_id = fee_collection_added_by');
		$this->db->where('fee_collection_id',$receipt_id);
		$query = $this->db->get();
		return $query->row_array();
	}
	function getPayData($sdnt_id,$petr_id){
		
		$this->db->where('fee_collection_roll_id',$sdnt_id);
		$this->db->where('fee_collection_particular_id',$petr_id);
		
		$query = $this->db->get_where('fee_collections');
		
		
		return $query->result();
	}
	
	
	function getAllParticular(){
		
		$this->db->select('fee_particular_id,fee_particular_name');
		$this->db->where('fee_particular_type','fp_all');
		$this->db->where('fee_particular_status','active');
		$this->db->where('fee_particular_delete','N');
		$query = $this->db->get_where('fee_particulars');
		
		return $query->result();
		
	}
	
	function getClassParticular($cls_id){
		$this->db->select('fee_particular_id,fee_particular_name');
		$this->db->where('fee_particular_type','fp_class');
		$this->db->where('fee_particular_type_id',$cls_id);
		$this->db->where('fee_particular_status','active');
		$this->db->where('fee_particular_delete','N');
		$query = $this->db->get_where('fee_particulars');
		return $query->result();
	}
	function getRollParticular($cls_id){
		$this->db->select('fee_particular_id,fee_particular_name');
		$this->db->where('fee_particular_type','fp_roll');
		$this->db->where('fee_particular_type_cid',$cls_id);
		$this->db->where('fee_particular_status','active');
		$this->db->where('fee_particular_delete','N');
		$query = $this->db->get_where('fee_particulars');
		return $query->result();
	}
	function getStndParticular($cls_id){
		
		$this->db->select('standard_id');
		$this->db->from('class');
		$this->db->where('class_id',$cls_id);
		$query = $this->db->get();
		
		$query_res =$query->row_array();
		
		extract($query_res); 
		
		$this->db->select('fee_particular_id,fee_particular_name');
		$this->db->where('fee_particular_type','fp_standard');
		$this->db->where('fee_particular_type_id',$standard_id);
		$this->db->where('fee_particular_status','active');
		$this->db->where('fee_particular_delete','N');
		$query = $this->db->get_where('fee_particulars');
		return $query->result();
	}
	function getStudentReport($cid){
		
		$this->db->select('student_id,name,class_id,roll');
		$this->db->where('class_id',$cid);
		$query = $this->db->get_where('student');
		return $query->result();
		
	}
	function getStudentRollReport($fee_particular_type_id){
		
		$sids = explode(",",$fee_particular_type_id);
		$this->db->select('student_id,name,class_id,roll');
		$this->db->where_in('student_id',$sids );
		$query =  $this->db->get_where('student');
		return $query->result();
	}
	
}