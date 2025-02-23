<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cce_model extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }
	
	public function get_categories()
	{		
		$this->db->select('*');
		$this->db->from('cce_category');        
        $query	= $this->db->get()->result_array();
        return $query;
	}
	public function count_rows()
	{		
		$this->db->select('*');
		$this->db->from('cce_category');        
        $query	= $this->db->get();
        return $query->num_rows();
	}
	public function check_cce_existed($cce_sid='')
	{
		$this->db->select('*');
		$this->db->where('category',$cce_sid);
		$this->db->from('cce_category');
		$query	= $this->db->get()->result_array();
		if($query)
		return true;				
	}
	public function get_skills()
	{		
		$this->db->select('cce_skills.*,cce_category.category as cname');
		$this->db->from('cce_skills');
		$this->db->join('cce_category','cce_category.cce_id = cce_skills.category_name'); 
        $query	= $this->db->get()->result_array();
        return $query;
	}
	public function count_rows_skills()
	{		
		$this->db->select('*');
		$this->db->from('cce_skills');        
        $query	= $this->db->get();
        return $query->num_rows();
	}
	public function getfpdata($fc_id)
	{		
		$this->db->select('*');
		$this->db->from('cce_skills');
		$this->db->where('category_name',$fc_id);
        $query	= $this->db->get()->result();
        return $query;
	}
	public function check_cce_skill_existed($cce_spid='')
	{		
		$this->db->select('*');
		$this->db->where('skill_name',$cce_spid);
		$this->db->from('cce_skills');
		$query	= $this->db->get()->result_array();
		if($query)
		return true;				
	}
	public function get_indicators()
	{		
		$this->db->select('cce_indicators.*,cce_category.category as cname,cce_skills.*');
		$this->db->from('cce_indicators,cce_skills');   
		$this->db->join('cce_category','cce_category.cce_id = cce_indicators.category_name');
		$this->db->where('cce_indicators.parent_skill = cce_skills.skill_id');       
        $query	= $this->db->get()->result_array();
        return $query;
	}
	public function count_rows_indicators()
	{		
		$this->db->select('*');
		$this->db->from('cce_indicators');        
        $query	= $this->db->get();
        return $query->num_rows();
	}
	public function check_cce_indicator_existed($cce_spid='')
	{		
		$this->db->select('*');
		$this->db->where('indicator_name',$cce_spid);
		$this->db->from('cce_indicators');
		$query	= $this->db->get()->result_array();
		if($query)
		return true;				
	}
	public function get_assessment()
	{		
		$this->db->select('*');
		$this->db->from('cce_assessment');        
        $query	= $this->db->get()->result_array();
        return $query;
	}
	public function count_rows_assessment()
	{		
		$this->db->select('*');
		$this->db->from('cce_assessment');        
        $query	= $this->db->get();
        return $query->num_rows();
	}
	public function check_cce_term_existed($cce_spid='')
	{		
		$this->db->select('*');
		$this->db->where('term_name',$cce_spid);
		$this->db->from('cce_assessment');
		$query	= $this->db->get()->result_array();
		if($query)
		return true;				
	}

	//Grades,Grade-sets
	public function get_grade_sets()
	{		
		$this->db->select('*');
		$this->db->from('cce_gradesets');    
		    
        $query	= $this->db->get()->result_array();
        return $query;
	}
	public function count_rows_gradeset()
	{		
		$this->db->select('*');
		$this->db->from('cce_gradesets');        
        $query	= $this->db->get();
        return $query->num_rows();
	}
	public function check_cce_set_existed($cce_spid='')
	{		
		$this->db->select('*');
		$this->db->where('set_name',$cce_spid);
		$this->db->from('cce_gradesets');
		$query	= $this->db->get()->result_array();
		if($query)
		return true;				
	}
	public function get_grades_details()
	{		
		$this->db->select('*');
		$this->db->from('cce_grades');        
        $query	= $this->db->get()->result_array();
        return $query;
	}	
	public function get_grades_dynamic($grade_id='')
	{		
		$this->db->select('*');
		$this->db->from('cce_grades');        
		$this->db->join('cce_gradesets','cce_gradesets.set_id = cce_grades.set_name'); 
		$this->db->where('cce_grades.set_name',$grade_id);
		
        $query	= $this->db->get()->result_array();
        return $query;
	}
	public function get_grade_rows_dynamic($grade_id='')
	{		
		$this->db->select('*');
		$this->db->where('set_name',$grade_id);
		$this->db->from('cce_grades');         
        $query	= $this->db->get();
        return $query->num_rows();
	}	
	public function cce_grade_skills()
	{		
		$this->db->select('cce_grade_skills.*,cce_skills.skill_name as sname,cce_gradesets.set_name as setname');
		$this->db->from('cce_grade_skills');
		$this->db->join('cce_skills','cce_skills.skill_id = cce_grade_skills.skill_name'); 
		$this->db->join('cce_gradesets','cce_gradesets.set_id = cce_grade_skills.grade_set');       
        $query	= $this->db->get()->result_array();
        return $query;
	}
	public function cce_grade_skills_rows()
	{		
		$this->db->select('*');
		$this->db->from('cce_grade_skills');        
        $query	= $this->db->get();
        return $query->num_rows();
	}
	public function count_rows_grade_skills($skill_id)
	{		
		$this->db->select('*');
		$this->db->where('category_name',$skill_id);
		$this->db->from('cce_skills');        
        $query	= $this->db->get();
        return $query->num_rows();
	}
	public function check_grade_skills_existed($skill_name)
	{		
		$this->db->select('*');
		$this->db->where('skill_name',$skill_name);
		$this->db->from('cce_grade_skills');        
        $query	= $this->db->get();
        return $query->num_rows();
	}
	
	public function get_assessment_assign()
	{		
		$this->db->select('*');
		$this->db->from('cce_assessment_assign');    
		$this->db->join('cce_assessment','cce_assessment.term_id = cce_assessment_assign.term_name');     
        $query	= $this->db->get()->result_array();
        return $query;
	}
	public function count_rows_assessment_assign()
	{		
		$this->db->select('*');
		$this->db->from('cce_assessment_assign');        
        $query	= $this->db->get();
        return $query->num_rows();
	}
	public function class_indicator_check($data)
	{
		$this->db->select('*');
		$this->db->where('class',$data['class']);
		$this->db->where('category_name',$data['category_name']);
		$this->db->where('skill_name',$data['skill_name']);
		$this->db->where('indicator_name',$data['indicator_name']);
		$this->db->from('cce_class_indicator');
		$query	= $this->db->get();
        return $query->num_rows();		
	}
	public function check_class_indicator()
	{		
		$this->db->select('*');
		$this->db->from('cce_class_indicator');        
        $query	= $this->db->get()->result_array();
        return $query;
	}
	
	
	function insTestData($data){
		return $this->db->insert('cce_tests',$data);
	}
	function delTestData($test_id,$data){
		
		$this->db->where('test_id',$test_id);
		
		return $this->db->update('cce_tests',$data);
		
	}
	
	function getStudentData($param1){
		$this->db->select('student_id,name');
		$this->db->where('class_id',$param1);
		$query = $this->db->get_where('student');
		
		return $query->result_array();
	}
	
}

