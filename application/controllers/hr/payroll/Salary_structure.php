<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Salary_structure extends CI_Controller {

    public $page_code = 'salary_structure';
    public $page_id = '';
    public $page_perm = '----';
    
    public function __construct() {

        parent::__construct();
        $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");
 
        $this->id = $this->session->userdata('school_id');
        $this->academic_session=array();
        $this->school_desc = $this->dbconnection->select("school", "*", "id=" . $this->id . " and status = 1");
        $this->schools = $this->dbconnection->select("school", "*", 'status = 1');
        $this->bank = $this->dbconnection->select("bank", "*");
        if ($this->id !=0 ) {
            $this->db->db_select('crmfeesclub_'.$this->id);                 
            $this->academic_session=$this->dbconnection->select("accedemic_session","id as fin_year,start_date,end_date","active='Y'","id","DESC","1");
        }
        
        $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
        $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
        $this->right_access = $this->page_perm;

        if (strpos($this->page_perm, '----') == true) {
            redirect(base_url(''), 'refresh');
        }
        $this->page_title = 'Salary Structure';
        $this->section = 'hr/payroll';
        $this->page_name = 'salary_structure';
        $this->customview = '';
    }

    public function index() {
        if (substr($this->right_access, 1, 1) != 'R') {
            redirect('404');
        }
        $this->data['page_name'] = $this->page_name;
        $this->data['page_title'] = $this->page_title;
        $this->data['section'] = $this->section;
        $this->data['customview'] = $this->customview;
        $this->data['right_access'] = $this->right_access;
        // $this->data['fetch_salary_structure'] = $this->dbconnection->select('salary_head', "id,emp_id,(select employee_code from employee where status=1 and id=emp_id) as emp_code, (select name from employee where status=1 and id=emp_id) as emp_name, year,gross_salary,(ctc_month*12) as ctc_year,ctc_month,(gross_salary-net_payable) as deduction,net_payable,(ctc_month-gross_salary) as employer_contri,start_date,end_date,active_status", "status=1");

        $this->data['fetch_salary_structure'] = $this->db->query("select sg.id,sg.salary_group_name,sg.applicable_from,sg.designation_id,sg.gross_salary,sg.ctc_month,sg.net_payable,(gross_salary-net_payable) as deduction,(ctc_month*12) as ctc_year,(ctc_month-gross_salary) as employer_contri,emp.id as emp_id,emp.employee_code,emp.name,emp.salary_group_id from salary_group sg,employee emp where emp.salary_group_id=sg.id and sg.status='Y'")->result() ;

        // $this->data['fetch_salary_structure'] = $this->dbconnection->select('salary_head', "id,emp_id,(select employee_code from employee where status=1 and id=emp_id) as emp_code, (select name from employee where status=1 and id=emp_id) as emp_name, year,gross_salary,(ctc_month*12) as ctc_year,ctc_month,(gross_salary-net_payable) as deduction,net_payable,(ctc_month-gross_salary) as employer_contri,start_date,end_date,active_status", "status=1");


        $this->load->view('index', $this->data);
    }

    public function create_salary() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }
        $ecode = $this->input->post('emp_code');
        $start_year = $this->input->post('start_year');
        $end_year = $this->input->post('end_year');
        $salary_head_id = $this->input->post('salary_head_id');
        $yr = explode('-', $start_year);
        $curr_year = !empty($yr) ? $yr[0] : '';
        $emp_data = $this->dbconnection->select("employee", "id,name,category_id,pan_no,pf_accnt,esi_accnt,aadhar_id,employee_code,designation_id,bank_id,bank_accnt_no", "status=1 and id='$ecode'");
        $salary_structure = $this->dbconnection->select("salary_head", "id,end_date,IF(end_date != '', if(end_date<'$start_year','',concat('Salary Structure Already Assigned! Period:',' ',start_date,' to ',end_date)),concat('There is an already assigned Salary ,Please mention end date of that salary sructure! Period:', start_date)) as msg", " YEAR(start_date)='$curr_year' and emp_id=$ecode and id!=$salary_head_id and status=1", "id", "DESC", "1");

        if (count($salary_structure) == 0) {
            $msg = '';
        } else {
            $msg = $salary_structure[0]->msg;
        }
        $fetch_array = array($emp_data, $msg); 
        echo json_encode($fetch_array);
    }
      public function add_sal() {

        $this->data['page_name'] = 'add_salary_structure';
        $this->data['page_title'] = 'Create Salary ';
        $this->data['section'] = $this->section;
        $this->data['customview'] = $this->customview;
        $this->data['task'] = 'Save';
        $this->data['title'] = 'Salary Details';
        $this->data['emp_code'] = '';
        $this->data['emp_name'] = '';
        $this->data['aadhar'] = '';
        $this->data['cat'] = '';
        $this->data['design'] = '';
        $this->data['bank'] = '';
        $this->data['accnt'] = '';
        $this->data['pan'] = '';
        $this->data['pf'] = '';
        $this->data['esic'] = '';
        $this->data['fetch_salary_name'] = $this->dbconnection->select('salary_type', "*", "status=1");
        $this->data['payable'] = '';
        $this->data['gross_pay'] = '';
        $this->data['pf_empl'] = '';
        $this->data['health_empl'] = '';
        $this->data['ctc_mon'] = '';
        $this->data['fin_yr_start_date'] = $this->academic_session[0]->start_date;
        $this->data['fin_yr_end_date'] = $this->academic_session[0]->end_date;
        $this->data['start_date'] = '';
        $this->data['end_date'] = '';
        $this->data['ctc_ann'] = '';
        $this->data['designation'] = $this->dbconnection->select("employee_designation", "id,designation_desc", "status=1");
        $this->data['emp_details'] = $this->dbconnection->select("employee", "id,employee_code", "status=1");
        $this->data['fetch_bank'] = $this->bank;
        $this->data['salary_head_id'] = '0';


        $this->load->view('index', $this->data);
    }

    public function save() {
    
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }
        $data = array(
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
            'emp_id' => $this->input->post('emp_code'),
            'pf_employer' => $this->input->post('pf_employer'),
            'medical_employer' => $this->input->post('medical_employer'),
            'gross_salary' => $this->input->post('gross'),
            'ctc_month' => $this->input->post('ctc_mnth'),
            'net_payable' => $this->input->post('net'),
            'created_by' => $this->session->userdata('user_id'),
            'academic_year_id'=> $this->academic_session[0]->fin_year,
        );
        $q=$this->dbconnection->insert('salary_head', $data);
// print_r($q);die();
        $last_id = $this->dbconnection->get_last_id();

        $inputall = $this->input->post();
        for ($i = 0; i <= count($inputall['sal_id']); $i++) {
            $data1 = array(
                'sal_head_id' => $last_id,
                'amount' => $inputall['sal_amount'][$i],
                'salary_id' => $inputall['sal_id'][$i],
                'created_by' => $this->session->userdata('user_id'),
            );
            $this->dbconnection->insert('salary_structure', $data1);
        }


        if($q){
                $audit = array("action" => 'Add Salary Structure',
                "module" => "Payroll Module",
                'datetime' => date("Y-m-d H:i:s"),
                'userid' => $this->session->userdata('user_id'),
                'student_id' => 0,
                'page' => 'add_salary_structure',
                'remarks' => 'Creation of Salary Structure of EmpID:'.$this->input->post('emp_code').' and of Id:'.$last_id,
            );
            $this->dbconnection->insert("auditntrail", $audit);
        }
    }

    public function edit_sal($salary_head_id = '') {

        $this->data['page_name'] = 'add_salary_structure';
        $this->data['page_title'] = $this->page_title;
        $this->data['section'] = $this->section;
        $this->data['customview'] = $this->customview;

        $f = $this->dbconnection->select("salary_head", "*", "id=$salary_head_id");
        $fetch_detail = $this->dbconnection->select("employee", "*", "id=" . $f[0]->emp_id);

        $this->data['task'] = 'Update';
        $this->data['emp_code'] = $fetch_detail[0]->id;
        $this->data['fin_yr_start_date'] = $this->academic_session[0]->start_date;
        $this->data['fin_yr_end_date'] = $this->academic_session[0]->end_date;
        $this->data['start_date'] = $f[0]->start_date;
        $this->data['end_date'] = $f[0]->end_date;
        $this->data['emp_name'] = $fetch_detail[0]->name;
        $this->data['aadhar'] = $fetch_detail[0]->aadhar_id;
        $this->data['cat'] = $fetch_detail[0]->category_id;
        $this->data['design'] = $fetch_detail[0]->designation_id;
        $this->data['bank'] = $fetch_detail[0]->bank_id;
        $this->data['accnt'] = $fetch_detail[0]->bank_accnt_no;
        $this->data['pan'] = $fetch_detail[0]->pan_no;
        $this->data['pf'] = $fetch_detail[0]->pf_accnt;
        $this->data['esic'] = $fetch_detail[0]->esi_accnt;
        $this->data['fetch_salary_name'] = $this->dbconnection->select('salary_type', "*,(select amount from salary_structure where salary_id=salary_type.id and sal_head_id=$salary_head_id) as sal_amt", "status=1");
        $this->data['gross_pay'] = $f[0]->gross_salary;
        $this->data['pf_empl'] = $f[0]->pf_employer;
        $this->data['health_empl'] = $f[0]->medical_employer;
        $this->data['payable'] = $f[0]->net_payable;
        $this->data['ctc_mon'] = $f[0]->ctc_month;
        $this->data['ctc_ann'] = $f[0]->ctc_month * 12;
        $this->data['designation'] = $this->dbconnection->select("employee_designation", "id,designation_desc", "status=1");
        $this->data['emp_details'] = $this->dbconnection->select("employee", "id,employee_code", "status=1");
        $this->data['fetch_bank'] = $this->bank;
        $this->data['salary_head_id'] = $salary_head_id;


        $this->load->view('index', $this->data);
    }

    public function update($sal_head_id) {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }
        $data = array(
            'start_date' => $this->input->post('start_date'),
            'end_date' => $this->input->post('end_date'),
            'emp_id' => $this->input->post('emp_code'),
            'pf_employer' => $this->input->post('pf_employer'),
            'medical_employer' => $this->input->post('medical_employer'),
            'gross_salary' => $this->input->post('gross'),
            'ctc_month' => $this->input->post('ctc_mnth'),
            'net_payable' => $this->input->post('net'),
            'last_date_modified' => date('Y-m-d H:i:s'),
            'last_modified_by' => $this->session->userdata('user_id'),
        );
        $this->db->where('id', $sal_head_id);
        $q=$this->db->update('salary_head', $data);

        $sal_head = $sal_head_id;
        $inputall = $this->input->post();

        for ($j = 0; $j < count($inputall['sal_id']); $j++) {
            $data1 = array(
                'amount' => $inputall['sal_amount'][$j],
                'last_date_modified' => date('Y-m-d H:i:s'),
                'last_modified_by' => $this->session->userdata('user_id'),
            );
            $this->dbconnection->update('salary_structure', $data1, "sal_head_id=$sal_head and salary_id=" . $inputall['sal_id'][$j]);
        }
        
        if($q){
                $audit = array("action" => 'Update Salary Structure',
                "module" => "Payroll Module",
                'datetime' => date("Y-m-d H:i:s"),
                'userid' => $this->session->userdata('user_id'),
                'student_id' => 0,
                'page' => 'add_salary_structure',
                'remarks' => 'Updation of Salary Structure of EmpID:'.$this->input->post('emp_code'),
            );
            $this->dbconnection->insert("auditntrail", $audit);
        }
    }

    public function delete() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }
        $sal_id_string = $this->input->post('class_id_string');
        foreach ($sal_id_string as $val) {
            $q=$this->dbconnection->update('salary_head', array('status' => 0, 'last_modified_by' => $this->session->userdata('user_id'), 'last_date_modified' => date('Y-m-d H:i:s')), 'id=' . $val);
            $this->dbconnection->update('salary_structure', array('status' => 0, 'last_modified_by' => $this->session->userdata('user_id'), 'last_date_modified' => date('Y-m-d H:i:s')), 'sal_head_id =' . $val);
            
            if($q){
                $audit = array("action" => 'Delete Salary Structure',
                    "module" => "Payroll Module",
                    'datetime' => date("Y-m-d H:i:s"),
                    'userid' => $this->session->userdata('user_id'),
                    'student_id' => 0,
                    'page' => 'salary_structure',
                    'remarks' => 'Deletion of Salary Structure of ID:'.$val,
                );
                $this->dbconnection->insert("auditntrail", $audit);
            }
            
        }
    }


}
