<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pay_scale extends CI_Controller {

    public function __construct() {

        $this->page_code = 'pay_scale';
        
        parent::__construct();
        
        $this->bank = $this->dbconnection->select("crmfeesclub.bank", "*");
        


        
        $this->id = $this->session->userdata('school_id');
                if ($this->id != 0)
                    $this->db->db_select('crmfeesclub_' . $this->id);
        $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y' and active='Y'", '', '', array('id'));

        $this->page_title = 'Pay Scale';
        $this->section = 'hr/settings';
        $this->page_name = 'salary_slab';
        $this->customview = '';
        $this->dbtable = 'salary_slab';
        $this->data_table = $this->dbtable . ' AS t1';
	$this->data_select = '*';
    }

    public function index() {
        $this->data['page_name'] = $this->page_name;
        $this->data['page_title'] = $this->page_title;
        $this->data['section'] = $this->section;
        $this->data['customview'] = $this->customview;
        $this->data['right_access'] = $this->right_access;
        $this->data['salary_slab_id'] = 0;
        $this->data['salary_group'] = $this->dbconnection->select("salary_slab", "*", "status='Y'");
        $this->data['fetch_designation'] = array_column($this->dbconnection->select_returnarray("employee_designation", "id,designation_desc", "status='Y'"),'designation_desc','id');
        $this->load->view('index', $this->data);
    }



    public function save() {


        if (!$this->input->is_ajax_request()) {
            show_permission();
        }
        $data = array(
            'salary_group_name' => $this->input->post('salary_group_name'),
            'applicable_from' => $this->input->post('applicable_from'),
            'academic_year_id' => $this->academic_session[0]->fin_year,
            'designation_id' => $this->input->post('designation_id'),
            'from_basic' => $this->input->post('from_basic'),
            'to_basic' => $this->input->post('to_basic'),
            'grade_pay' => $this->input->post('grade_pay'),           
            'created_by' => $this->session->userdata('user_id'),
        );
        $q = $this->dbconnection->insert('salary_slab', $data);

        


//        if($q){
//                $audit = array("action" => 'Add Salary Structure',
//                "module" => "Payroll Module",
//                'datetime' => date("Y-m-d H:i:s"),
//                'userid' => $this->session->userdata('user_id'),
//                'student_id' => 0,
//                'page' => 'add_salary_structure',
//                'remarks' => 'Creation of Salary Structure of EmpID:'.$this->input->post('emp_code').' and of Id:'.$last_id,
//            );
//            $this->dbconnection->insert("auditntrail", $audit);
//        }
    }



    public function update() {
        if (!$this->input->is_ajax_request()) {
            show_permission();
        }

        $data = array(
            'salary_group_name' => $this->input->post('salary_group_name'),
            'applicable_from' => $this->input->post('applicable_from'),
            'designation_id' => $this->input->post('designation_id'),
            'from_basic' => $this->input->post('from_basic'),
            'to_basic' => $this->input->post('to_basic'),
            'grade_pay' => $this->input->post('grade_pay'),
            'last_date_modified' => date('Y-m-d H:i:s'),
            'last_modified_by' => $this->session->userdata('user_id'),
        );
        $this->db->where('id', $this->input->post('idmain'));
        $q = $this->db->update('salary_slab', $data);



        // if($q){
        // $audit = array("action" => 'Update Salary Structure',
        // "module" => "Payroll Module",
        // "page" => basename(__FILE__, '.php'),
        // 'created_at' => date("Y-m-d H:i:s"),
        // 'user_id' => $this->session->userdata('user_id'),
        // 'remarks' => 'Updation of Salary Structure of EmpID:'.$this->input->post('emp_code'),
        // );
        // $this->dbconnection->insert("auditntrail", $audit);
        // }
    }

    public function delete() {
        if (!$this->input->is_ajax_request()) {
            show_permission();
        }
        $salary_group_id_string = $this->input->post('class_id_string');
        foreach ($salary_group_id_string as $val) {
            $this->dbconnection->update('salary_slab', array('status' => 'N', 'last_modified_by' => $this->session->userdata('user_id'), 'last_date_modified' => date('Y-m-d H:i:s')), 'id=' . $val);


//            if ($q) {
//                $audit = array("action" => 'Delete Salary Structure',
//                    "module" => "Payroll Module",
//                    "page" => basename(__FILE__, '.php'),
//                    'created_at' => date("Y-m-d H:i:s"),
//                    'user_id' => $this->session->userdata('user_id'),
//                    'remarks' => 'Deletion of Salary Structure of ID:' . $val,
//                );
//                $this->dbconnection->insert("auditntrail", $audit);
//            }
        }
//$this->dbconnection->delete($id);
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
        $emp_data = $this->dbconnection->select("employee", "id,name,category_id,pan_no,pf_accnt,esi_accnt,aadhar_id,employee_code,designation_id,bank_id,bank_accnt_no", "status='Y' and id='$ecode'");
        $salary_structure = $this->dbconnection->select("salary_head", "id,end_date,IF(end_date != '', if(end_date<'$start_year','',concat('Salary Structure Already Assigned! Period:',' ',start_date,' to ',end_date)),concat('There is an already assigned Salary ,Please mention end date of that salary sructure! Period:', start_date)) as msg", " YEAR(start_date)='$curr_year' and emp_id=$ecode and id!=$salary_head_id and status='Y'", "id", "DESC", "1");

        if (count($salary_structure) == 0) {
            $msg = '';
        } else {
            $msg = $salary_structure[0]->msg;
        }
        $fetch_array = array($emp_data, $msg); 
        echo json_encode($fetch_array);
    }

    public function add_salary_group() { 


        $this->data['salary_group_name'] = 'salary_group_name';
        $this->data['salary_group_id'] = 'salary_group_id';
        $data = $this->dbconnection->select("salary_group,data");
        $data = $this->dbconnection->select("salary_entitlement,data");


        $this->load->view('index', $this->data);
    }

}
