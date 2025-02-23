<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Salary_groups extends CI_Controller {

    public function __construct() {

        parent::__construct();



        $link_code = 'salary_group';

        $this->db->db_debug = TRUE;

        if (empty($this->session->userdata('user_group_id'))) {
            redirect(base_url(), 'refresh');
        }
        $accesspermission = $this->dbconnection->select('crmfeesclub.user_group_permission', 'permission', "status='Y' AND link_code='$link_code' AND user_group_id=" . $this->session->userdata('user_group_id'));

        $tt = $this->right_access = $this->right_access = (count($accesspermission) == 0 || empty($accesspermission[0]->permission)) ? '----' : $accesspermission[0]->permission;

        if ($this->right_access == 'CRUD') {
            redirect(base_url(), 'refresh');
        }
// switch ($this->session->userdata('login_type')) {
// case 'appadmin':
// $this->right_access = 'CRUDV'; // C for Create(add), R for Read(view), U for Update(edit), D for delete, V for salary_view
// break;
// case 'admin':
// $this->right_access = 'CRUDV';
// break;
// case 'principal':
// $this->right_access = '-R--V';
// break;
// case 'hr':
// $this->right_access = 'CRUDV';
// break;
// default:
// $this->right_access = '-----';
// redirect(base_url(), 'refresh');
// } 
        $this->id = $this->session->userdata('school_id');
        $this->academic_session = array();
        $this->school_desc = $this->dbconnection->select("school", "*", "id=" . $this->id . " and status = 1");
        $this->schools = $this->dbconnection->select("school", "*", 'status = 1');
        $this->bank = $this->dbconnection->select("bank", "*");
        if ($this->id != 0) {
            $this->db->db_select('crmfeesclub_' . $this->id);
            $this->academic_session=$this->dbconnection->select("accedemic_session","max(id) as fin_year","active='Y'");
        }
        $this->page_title = 'Salary Group';
        $this->section = 'hr/settings';
        $this->page_name = 'salary_group';
        $this->customview = '';
    }

    public function index() {
        $this->data['page_name'] = $this->page_name;
        $this->data['page_title'] = $this->page_title;
        $this->data['section'] = $this->section;
        $this->data['customview'] = $this->customview;
        $this->data['right_access'] = $this->right_access;
        $this->data['fetch_salary_structure'] = $this->dbconnection->select('salary_head', "id,emp_id,(select employee_code from employee where status=1 and id=emp_id) as emp_code, (select name from employee where status=1 and id=emp_id) as emp_name, year,gross_salary,(ctc_month*12) as ctc_year,ctc_month,(gross_salary-net_payable) as deduction,net_payable,(ctc_month-gross_salary) as employer_contri,start_date,end_date", "status=1");
        $this->data['salary_group'] = $this->dbconnection->select("salary_group", "id,salary_group_name", "status='Y'");
        $this->load->view('index', $this->data);
    }

    public function add_sal() {

        $this->data['page_name'] = 'add_salary_group';
        $this->data['page_title'] = 'Create Salary Group';
        $this->data['section'] = $this->section;
        $this->data['customview'] = $this->customview;
        $this->data['task'] = 'Save';
        $this->data['title'] = 'Salary Details';
        $this->data['salary_group_name'] = '';
        $this->data['applicable_from'] = '';
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
        $this->data['designation'] = '0';
        $this->data['salary_group_id'] = 0;
//'fetch_designation'     => $this->dbconnection->select("employee_designation", "id,designation_desc", "status='Y'"),
        $this->data['fetch_designation'] = $this->dbconnection->select("employee_designation", "id,designation_desc", "status='1'");
        $this->data['emp_details'] = $this->dbconnection->select("employee", "id,employee_code", "status=1");

//$this->data['fetch_leave'] = $this->dbconnection->select('leave_type','id,leave_type_code','status="Y"');
        $this->data['fetch_bank'] = $this->bank;
        $this->data['salary_head_id'] = '0';


        $this->load->view('index', $this->data);
    }

    public function save() {
        error_reporting(-1);
        ini_set('display_errors', 1);

// if (!$this->input->is_ajax_request()) {
// redirect('404');
// }
        $data = array(
            'salary_group_name' => $this->input->post('salary_group_name'),
            'applicable_from' => $this->input->post('applicable_from'),
            'academic_year_id' => $this->academic_session[0]->fin_year,
            'designation_id' => $this->input->post('designation'),
            'pf_employer' => 0,
            // 'pf_employer' => $this->input->post('pf_employer'),
            'medical_employer' => 0,
            // 'medical_employer' => $this->input->post('medical_employer'),
            'gross_salary' => $this->input->post('gross'),
            'ctc_month' => $this->input->post('ctc_mnth'),
// 'ctc_yr' => $this->input->post('ctc_yr'),
            'net_payable' => $this->input->post('net'),
            'created_by' => $this->session->userdata('user_id'),
        );
        $q = $this->dbconnection->insert('salary_group', $data);

        $last_id = $this->dbconnection->get_last_id();

        $inputall = $this->input->post();
        foreach ($inputall['sal_id'] as $k => $v) {
            $data1 = array(
                'salary_group_id' => $last_id,
                'amount' => $inputall['sal_amount'][$k],
                'salary_id' => $inputall['sal_id'][$k],
                'created_by' => $this->session->userdata('user_id'),
            );
            $this->dbconnection->insert('salary_entitlement', $data1);
        }
    }

    public function edit_sal($salary_group_id = '') {

        $this->data['page_name'] = 'add_salary_group';
        $this->data['page_title'] = $this->page_title;
        $this->data['section'] = $this->section;
        $this->data['customview'] = $this->customview;


        $f = $this->dbconnection->select("salary_group", "*", "id=$salary_group_id");
//$fetch_detail = $this->dbconnection->select("employee", "*", "id=" . $f[0]->emp_id);

        $this->data['task'] = 'Update';
        $this->data['designation'] = $f[0]->designation_id;

        $this->data['fetch_salary_name'] = $this->dbconnection->select('salary_type', "*,(select amount from salary_entitlement where salary_id=salary_type.id and salary_group_id=$salary_group_id and status='Y') as sal_amt", "status=1");
        $this->data['fetch_designation'] = $this->dbconnection->select("employee_designation", "id,designation_desc", "status=1");
        $this->data['gross_pay'] = $f[0]->gross_salary;
        $this->data['pf_empl'] = $f[0]->pf_employer;
        $this->data['health_empl'] = $f[0]->medical_employer;
        $this->data['payable'] = $f[0]->net_payable;
        $this->data['ctc_mon'] = $f[0]->ctc_month;
        $this->data['ctc_ann'] = $f[0]->ctc_month * 12;
        $this->data['salary_group_name'] = $f[0]->salary_group_name;
        $this->data['applicable_from'] = $f[0]->applicable_from;
//$this->data['designation_id'] = $f[0]->designation;
        $this->data['salary_group_id'] = $salary_group_id;

//	$this->data['fetch_salary'] = $this->dbconnection->select('salary_group',"*,(select allowed from  salary_id=salary.id and id=$param2) allowed,(select total_allowed from salary_entitlement where salary_id=salary.id and id=$param2) total_allowed,(select total_allowed_per_month from salary_entitlement where  salary_id=salary.id and id=$param2) total_allowed_per_month,(select carry_frwd from salary_entitlement where salary_id=salary_group.id and id=$param2) carry_frwd,(select max_carry_frwd from salary_entitlement where salary_id=salary_group.id and id=$param2) max_carry_frwd,(select convrt_to_amount from salary_entitlement where salary_id=salary_group.id and id=$param2) convrt_to_amount,(select amount from salary_entitlement where  salary_id=salary.id and id=$param2) amount","status='Y'");

        $this->load->view('index', $this->data);
    }

    public function update($salary_group_id) {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }

        $data = array(
            'pf_employer' => $this->input->post('pf_employer'),
            'designation_id' => $this->input->post('designation'),
            'medical_employer' => $this->input->post('medical_employer'),
            'gross_salary' => $this->input->post('gross'),
            'ctc_month' => $this->input->post('ctc_mnth'),
            'net_payable' => $this->input->post('net'),
            'last_date_modified' => date('Y-m-d H:i:s'),
            'last_modified_by' => $this->session->userdata('user_id'),
        );
        $this->db->where('id', $salary_group_id);
        $q = $this->db->update('salary_group', $data);

        // $data_salary_head = array(            
        //     'pf_employer' => $this->input->post('pf_employer'),
        //     'medical_employer' => $this->input->post('medical_employer'),
        //     'gross_salary' => $this->input->post('gross'),
        //     'ctc_month' => $this->input->post('ctc_mnth'),
        //     'net_payable' => $this->input->post('net'),            
        //     'last_date_modified' => date('Y-m-d H:i:s'),
        //     'last_modified_by' => $this->session->userdata('user_id'),
        // );
        // $this->db->where('salary_group_id', $salary_group_id);
        // $qu = $this->db->update('salary_head', $data_salary_head);

        $inputall = $this->input->post();
        $data_stat=array(
            'status'=>'N',
        );
        $this->dbconnection->update('salary_entitlement', $data_stat, "salary_group_id=$salary_group_id");
        foreach ($inputall['sal_id'] as $j => $v) {

            $data1 = array(
                'amount' => $inputall['sal_amount'][$j],
                'salary_id' => $inputall['sal_id'][$j],
                'salary_group_id' => $salary_group_id,
                'status'=>'Y',
                'last_date_modified' => date('Y-m-d H:i:s'),
                'last_modified_by' => $this->session->userdata('user_id'),
            );
            $this->dbconnection->insert('salary_entitlement', $data1);
        }

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
            redirect('404');
        }
        $salary_group_id_string = $this->input->post('class_id_string');
        foreach ($salary_group_id_string as $val) {
            $q = $this->dbconnection->update('salary_group', array('status' => 'N', 'last_modified_by' => $this->session->userdata('user_id'), 'last_date_modified' => date('Y-m-d H:i:s')), 'id=' . $val);
            $this->dbconnection->update('salary_entitlement', array('status' => 'N', 'last_modified_by' => $this->session->userdata('user_id'), 'last_date_modified' => date('Y-m-d H:i:s')), 'salary_group_id =' . $val);

            if ($q) {
                $audit = array("action" => 'Delete Salary Structure',
                    "module" => "Payroll Module",
                    "page" => basename(__FILE__, '.php'),
                    'created_at' => date("Y-m-d H:i:s"),
                    'user_id' => $this->session->userdata('user_id'),
                    'remarks' => 'Deletion of Salary Structure of ID:' . $val,
                );
                $this->dbconnection->insert("auditntrail", $audit);
            }
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
        $emp_data = $this->dbconnection->select("employee", "id,name,category_id,pan_no,pf_accnt,esi_accnt,aadhar_id,employee_code,designation_id,bank_id,bank_accnt_no", "status=1 and id='$ecode'");
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
