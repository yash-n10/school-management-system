<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Salary_create extends CI_Controller {

    public $page_code = 'salary_create';
    public $page_id = '';
    public $page_perm = '----';
    
    public function __construct() 
    {
        parent::__construct();
        //$this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");

        $this->id           = $this->session->userdata('school_id');
        $this->academic_session=array();
        $this->school_desc  = $this->dbconnection->select("school", "*", "id=" . $this->id . " and status = 1");
        $this->schools      = $this->dbconnection->select("school", "*", 'status = 1');
        $this->bank         = $this->dbconnection->select("bank", "*");
        if ($this->id !=0 ) 
        {
            $this->db->db_select('crmfeesclub_'.$this->id);                 
            $this->academic_session=$this->dbconnection->select("accedemic_session","id as fin_year,start_date,end_date","active='Y'","id","DESC","1");
        }
        
        /*$permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
        $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
        $this->right_access = $this->page_perm;

        if (strpos($this->page_perm, '----') == true) {
            redirect(base_url(''), 'refresh');
        }*/
        
        $this->page_title   = 'Salary Create';
        $this->section      = 'hr/payroll';
        $this->page_name    = 'salary_create';
        $this->customview   = '';
    }
    
    public function index() 
    {
        $this->data['page_name']            = 'salary_create';
        $this->data['page_title']           = $this->page_title;
        $this->data['section']              = $this->section;
        $this->data['customview']           = $this->customview;
        $this->data['right_access']         = $this->right_access;
        $this->data['fin_yr_start'] = date('Y', strtotime($this->academic_session[0]->start_date));
        $this->data['fin_yr_end']   = date('Y', strtotime($this->academic_session[0]->end_date));
        $this->data['category']  = $this->dbconnection->select("employee_category", "*", "status = 1");
        $this->data['saltype']=$sa  =$this->dbconnection->select('salary_type', "*", "status='1'");
        $this->data['saltype1_count']=$this->dbconnection->select('salary_type', "*", "status='1' AND salary_typ=1");
        $this->data['saltype2_count']=$this->dbconnection->select('salary_type', "*", "status='1' AND salary_typ=2");
        $this->data['saltype4_count']=$this->dbconnection->select('salary_type', "*", "status='1' AND salary_typ=4");
        $this->load->view('index', $this->data);
    }

    public function get()
    {
        $this->data['month']=$month     =   $this->input->post('month');
        $this->data['year']=$year       =   $this->input->post('year');
        $this->data['category'] = $cat  =   $this->input->post('category');
        
        $this->data['saltype']          =   $this->dbconnection->select('salary_type', "*", "status='1'");

        $this->data['saltype1_count']   =   $this->dbconnection->select('salary_type', "*", "status='1' AND salary_typ=1");
        $this->data['saltype2_count']   =   $this->dbconnection->select('salary_type', "*", "status='1' AND salary_typ=2");
        $this->data['saltype4_count']   =   $this->dbconnection->select('salary_type', "*", "status='1' AND salary_typ IN(3,4)");
        
        if($cat=='all')
        {
        	$this->data['employee'] = $emp  =   $this->db->query("SELECT t1.*,t2.designation_desc FROM employee as t1 JOIN employee_designation as t2 ON t1.designation_id=t2.id WHERE t1.status=1 AND t1.id!=3")->result();
        }
        else
        {
        	$this->data['employee'] = $emp  =   $this->db->query("SELECT t1.*,t2.designation_desc FROM employee as t1 JOIN employee_designation as t2 ON t1.designation_id=t2.id WHERE t1.status=1 AND t1.category_id=$cat AND t1.id!=3")->result();
        }
        
        $this->data['sunday'] = $this->total_sundays($month,$year);
        $this->data['days'] = cal_days_in_month(CAL_GREGORIAN,$month,$year);
        $this->load->view("hr/payroll/salary_create_data", $this->data);
    }

    function total_sundays($month,$year)
    {
        $sundays=0;
        $total_days=cal_days_in_month(CAL_GREGORIAN, $month, $year);
        for($i=1;$i<=$total_days;$i++)
        if(date('N',strtotime($year.'-'.$month.'-'.$i))==7)
        $sundays++;
        return $sundays;
    }
    
}
