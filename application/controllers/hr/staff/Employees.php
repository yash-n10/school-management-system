<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Employees extends CI_Controller {

    public $page_code = 'hr_staff';
    public $page_id = '';
    public $page_perm = '----';

    public function __construct() {

        parent::__construct();
        $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");
//        switch ($this->session->userdata('login_type')) {
//            case 'appadmin':
//                $this->right_access = 'CRUD';
//                break;
//            case 'admin':
//                $this->right_access = 'CRUD';
//                break;
//            case 'principal':
//                $this->right_access = '-R--';
//                break;
//            case 'hr':
//                $this->right_access = 'CRUD';
//                break;
//            default:
//                $this->right_access = '----';
//                redirect(base_url(), 'refresh');
//        }
        $this->id = $this->session->userdata('school_id');
        $this->academic_session = array();
        $this->school_desc = $this->dbconnection->select("school", "*", "id=" . $this->id . " and status = 1");
        $this->school_code=$this->session->userdata('school_code');
        $this->schools = $this->dbconnection->select("school", "*", 'status = 1');
        $this->bank = $this->dbconnection->select("bank", "*");
        $this->bank_arr = $this->dbconnection->select_returnarray("bank", "*", "");

        if ($this->id != 0) {
            $this->db->db_select('crmfeesclub_' . $this->id);
            $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y' and active='Y'");
        }

        $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
        $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
        $this->right_access = $this->page_perm;

        if (strpos($this->page_perm, '----') == true) {
            redirect(base_url(''), 'refresh');
        }

        $this->admission_csv_columns = array(
            array('field' => 'employee_code', 'human_name' => 'Employee Code'), //0
            array('field' => 'name', 'human_name' => 'Employee Name'), //1
            array('field' => 'doj', 'human_name' => 'Joining Date'), //3
            array('field' => 'category_id', 'human_name' => 'Employee Category'), //4
            array('field' => 'department_id', 'human_name' => 'Department'), //5
            array('field' => 'designation_id', 'human_name' => 'Designation'), //6
            array('field' => 'leave_group', 'human_name' => 'Leave Group'), //7
            array('field' => 'user_group', 'human_name' => 'User Group'), //7
            array('field' => 'salary_group', 'human_name' => 'Salary Group'), //7            
            array('field' => 'qualification', 'human_name' => 'Qualification'), //8
            array('field' => 'total_experience', 'human_name' => 'Total Experience'),
            array('field' => 'father_name', 'human_name' => 'Father\'s Name'),
            array('field' => 'mother_name', 'human_name' => 'Mother\'s Name'),
            array('field' => 'dob', 'human_name' => 'D.O.B'),
            array('field' => 'gender', 'human_name' => 'Gender'),
            array('field' => 'martial_status', 'human_name' => 'Martial Status'),
            array('field' => 'spouse_name', 'human_name' => 'Spouse Name'),
            array('field' => 'aadhar_id', 'human_name' => 'Aadhar No'),
            array('field' => 'voter_id', 'human_name' => 'Voter Id'),
            array('field' => 'bank_id', 'human_name' => 'Bank Name'),
            array('field' => 'bank_accnt_no', 'human_name' => 'Account NO'),
            array('field' => 'ifsc_code', 'human_name' => 'IFSC Code'),
            array('field' => 'pan_no', 'human_name' => 'Pan NO'),
            array('field' => 'branch_address', 'human_name' => 'Branch Address'),
            array('field' => 'pf_accnt', 'human_name' => 'PF No'),
            array('field' => 'esi_accnt', 'human_name' => 'ESI No'),
            array('field' => 'address', 'human_name' => 'Address'),
            array('field' => 'phone_no', 'human_name' => 'Phone No'),
            array('field' => 'email', 'human_name' => 'Email'),
            array('field' => 'pension_no', 'human_name' => 'Pension Number'),
            array('field' => 'pension_nom', 'human_name' => 'Pension Nominee'),
        );

        $this->page_title = 'Employees';
        $this->section = 'hr/staff';
        $this->page_name = 'employee_list';
        $this->customview = '';
    }

    public function index() {
        if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->data['page_name'] = $this->page_name;
        $this->data['page_title'] = $this->page_title;
        $this->data['section'] = $this->section;
        $this->data['customview'] = $this->customview;
        $this->data['right_access'] = $this->right_access;
        $getempid=$this->dbconnection->select("user","employee_id","id=".$this->session->userdata('user_id'));
        $this->data['employee_id']=$getempid[0]->employee_id;
        $this->data['employee_id']=!empty($getempid) ?  $getempid[0]->employee_id: 0;
        if($this->data['employee_id']==0)
        {
          $this->data['employee'] = $this->dbconnection->select('employee', '*,(select designation_desc from employee_designation where id=designation_id) as designation_name,(select department_desc from employee_department where id=department_id) as department_name,(select category_desc from employee_category where id=category_id) as category_name,(select leave_group_name from leave_group where id=employee.leave_group) as leave_group', 'status=1');  
        }
        else{
             $this->data['employee'] = $this->dbconnection->select('employee', '*,(select designation_desc from employee_designation where id=designation_id) as designation_name,(select department_desc from employee_department where id=department_id) as department_name,(select category_desc from employee_category where id=category_id) as category_name,(select leave_group_name from leave_group where id=employee.leave_group) as leave_group', 'status=1 and id='.$this->data['employee_id']);
        }
       
        $this->load->view('index', $this->data);
    }

    public function add() {

        if (substr($this->right_access, 0, 1) != 'C') {
            redirect('404');
        }
        $this->data = [
            'employee_code' => '',
            'doj' => '',
            'designation' => '',
            'department' => '',
            'leave_group' => '',
            'salary_group' => '',
            'user_group' => '',
            'qualification' => '',
            'total_experience' => '',
            'name' => '',
            'dob' => '',
            'gender' => '',
            'martial_status' => '',
            'aadhar_no' => '',
            'voter_id' => '',
            'father_name' => '',
            'mother_name' => '',
            'spouse_name' => '',
            'bank' => '',
            'account_no' => '',
            'ifsc_code' => '',
            'pan_no' => '',
            'branch_address' => '',
            'pf_no' => '',
            'esi_no' => '',
            'address' => '',
            'phone' => '',
            'email' => '',
            'task' => 'Save',
            'employee_id' => '',
            'category' => '',
            'pension_no' => '',
            'pension_nom' => '',
            'fetch_designation' => $this->dbconnection->select("employee_designation", "id,designation_desc", "status=1"),
            'fetch_department' => $this->dbconnection->select("employee_department", "id,department_desc", "status=1"),
            'fetch_category' => $this->dbconnection->select("employee_category", "id,category_desc", "status=1"),
            'fetch_leave_group' => $this->dbconnection->select("leave_group", "id,leave_group_name", "status=1"),
            'fetch_user_group' => $this->dbconnection->select("user_group", "id,group_type", "status='Y' and id>1"),
            'fetch_salary_group' => $this->dbconnection->select("salary_group", "id,salary_group_name", "status='Y'"),
            'fetch_salary_slab' => $this->dbconnection->select("salary_slab", "*", "status='Y'"),
            'fetch_bank' => $this->bank,
            'page_name' => 'add_employee',
            'page_title' => $this->page_title,
            'section' => $this->section,
            'customview' => $this->customview,
            'school'=>$this->school_desc,
        ];

        $this->load->view('index', $this->data);
    }

    public function edit($param2 = '') {
        if (substr($this->right_access, 2, 1) != 'U') {
            redirect('404');
        }
        $fetch_employee = $this->dbconnection->select("employee", "*", "id=$param2");

        $fetch_user = $this->dbconnection->select("user", "user_group_id", "employee_id=$param2 and status=1");

        $usergroup_id = !empty($fetch_user[0]->user_group_id) ? $fetch_user[0]->user_group_id : 0;

        $this->data = [
            'employee_id' => $param2,
            'employee_code' => $fetch_employee[0]->employee_code,
            'doj' => $fetch_employee[0]->doj,
            'category' => $fetch_employee[0]->category_id,
            'designation' => $fetch_employee[0]->designation_id,
            'leave_group' => $fetch_employee[0]->leave_group,
            'user_group' => $usergroup_id,
            'salary_group' => $fetch_employee[0]->salary_group_id,
            'department' => $fetch_employee[0]->department_id,
            'qualification' => $fetch_employee[0]->qualification,
            'total_experience' => $fetch_employee[0]->total_experience,
            'name' => $fetch_employee[0]->name,
            'dob' => $fetch_employee[0]->dob,
            'gender' => $fetch_employee[0]->gender,
            'martial_status' => $fetch_employee[0]->martial_status,
            'aadhar_no' => $fetch_employee[0]->aadhar_id,
            'voter_id' => $fetch_employee[0]->voter_id,
            'father_name' => $fetch_employee[0]->father_name,
            'mother_name' => $fetch_employee[0]->mother_name,
            'spouse_name' => $fetch_employee[0]->spouse_name,
            'bank' => $fetch_employee[0]->bank_id,
            'account_no' => $fetch_employee[0]->bank_accnt_no,
            'ifsc_code' => $fetch_employee[0]->ifsc_code,
            'pan_no' => $fetch_employee[0]->pan_no,
            'branch_address' => $fetch_employee[0]->branch_address,
            'pf_no' => $fetch_employee[0]->pf_accnt,
            'esi_no' => $fetch_employee[0]->esi_accnt,
            'address' => $fetch_employee[0]->address,
            'phone' => $fetch_employee[0]->phone_no,
            'email' => $fetch_employee[0]->email,
            'photo' => $fetch_employee[0]->photo,
            'pension_no' => $fetch_employee[0]->pension_no,
            'pension_nom' => $fetch_employee[0]->pension_nom,
            'task' => 'Update',
            'title' => 'Employee Details',
            'fetch_designation' => $this->dbconnection->select("employee_designation", "id,designation_desc", "status=1"),
            'fetch_department' => $this->dbconnection->select("employee_department", "id,department_desc", "status=1"),
            'fetch_category' => $this->dbconnection->select("employee_category", "id,category_desc", "status=1"),
            'fetch_leave_group' => $this->dbconnection->select("leave_group", "id,leave_group_name", "status=1"),
            'fetch_user_group' => $this->dbconnection->select("user_group", "id,group_type", "status='Y' and id>1"),
            'fetch_salary_group' => $this->dbconnection->select("salary_group", "id,salary_group_name", "status='Y'"),
            'fetch_salary_slab' => $this->dbconnection->select("salary_slab", "*", "status='Y'"),
            'fetch_bank' => $this->bank,
            'page_name' => 'add_employee',
            'page_title' => $this->page_title,
            'section' => $this->section,
            'customview' => $this->customview,
            'school'=>$this->school_desc,
        ];

        $this->load->view('index', $this->data);
    }

    public function save() {

        // if (!$this->input->is_ajax_request() || substr($this->right_access, 0, 1) != 'C') {
            // redirect('404');
        // }
     
            $employee_code= $this->input->post('employee_code');
            $doj= $this->input->post('doj');
            $category_id= $this->input->post('category');
            $designation_id= $this->input->post('designation');
            $department_id= $this->input->post('department');
            $qualification= $this->input->post('qualification');
            $total_experience= $this->input->post('total_experience');
            $name= $this->input->post('employee_name');
            $dob= $this->input->post('dob');
            $gender= $this->input->post('gender');
            $martial_status= $this->input->post('martial_status');
            $aadhar_id= $this->input->post('aadhar_no');
            $voter_id= $this->input->post('voter_id');
            $father_name= $this->input->post('father_name');
            $mother_name= $this->input->post('mother_name');
            $spouse_name= $this->input->post('spouse_name');
            $bank_id= $this->input->post('bank_name');
            $bank_accnt_no= $this->input->post('account_no');
            $ifsc_code= $this->input->post('ifsc_code');
            $branch_address= $this->input->post('pan_no');
            $pan_no= $this->input->post('branch_address');
            $pf_accnt= $this->input->post('pf_no');
            $esi_accnt= $this->input->post('esi_no');
            $address= $this->input->post('address');
            $phone_no= $this->input->post('phone');
            $email= $this->input->post('email');
            $leave_group= $this->input->post('leave_group');
            $salary_group_id= $this->input->post('salary_group_id');
            $pension_no= $this->input->post('pension_no');
            $pension_nom= $this->input->post('pension_nom');
            $created_by= $this->session->userdata('user_id');$           
            // $academic_session_yash=$this->db->query("SELECT * FROM accedemic_session where status='Y' and active='Y'");
            // print_r($academic_session_yash);die();
            // $academic_session_yash=$academic_session_yash->result();
            // $academic_session_yash=$academic_session_yash[0];
            // print_r($this->academic_session[0]->fin_year);die();
            // print_r($this->academic_session[0]->fin_year);die();
            $id = $this->dbconnection->get_last_id() + 1;
           $user_id=$this->session->userdata('user_id');
         // echo "<pre>";print_r("INSERT INTO employee (employee_code,doj,category_id,designation_id,department_id,qualification,total_experience,name,dob,gender,martial_status,aadhar_id,voter_id,father_name,mother_name,spouse_name,bank_id,bank_accnt_no,ifsc_code,branch_address,pan_no,pf_accnt,esi_accnt,address,phone_no,email,leave_group,salary_group_id,academic_year_id,photo,created_by,date_modified,modified_by) VALUES($employee_code,'$doj',$category_id,$designation_id,$department_id,'$qualification','$total_experience','$name','$dob','$gender','$martial_status','$aadhar_id','$voter_id','$father_name','$mother_name','$spouse_name','$bank_id','$bank_accnt_no','$ifsc_code','$branch_address','$pan_no','$pf_accnt','$esi_accnt','$address','$phone_no','$email','$leave_group','$salary_group_id',1,'','$user_id','0000-00-00 00:00:00',0)");die();
        $this->db->query("INSERT INTO employee (employee_code,doj,category_id,designation_id,department_id,qualification,total_experience,name,dob,gender,martial_status,aadhar_id,voter_id,father_name,mother_name,spouse_name,bank_id,bank_accnt_no,ifsc_code,branch_address,pan_no,pf_accnt,esi_accnt,address,phone_no,email,leave_group,salary_group_id,academic_year_id,photo,created_by,date_modified,modified_by) VALUES($employee_code,'$doj',$category_id,$designation_id,$department_id,'$qualification','$total_experience','$name','$dob','$gender','$martial_status','$aadhar_id','$voter_id','$father_name','$mother_name','$spouse_name','$bank_id','$bank_accnt_no','$ifsc_code','$branch_address','$pan_no','$pf_accnt','$esi_accnt','$address','$phone_no','$email','$leave_group','$salary_group_id',1,'','$user_id','0000-00-00 00:00:00',0)");
        // $this->db->insert('employee', $data);



        $this->employee_leave($this->input->post('leave_group'), $employee_id);

        $this->salary_creation($employee_id,$this->input->post('salary_group_id'), 'SAVE');

        $ledgerdata = array(
                'ledger_code' => 'EMP-' . $this->input->post('employee_code'),
                'ledger_name' => $this->input->post('employee_name'),
                'under_group' => 7,
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address'),
                'city' => '',
                'state' => '',
                'zip_code' => '',
                'uid_no' => $this->input->post('aadhar_no'),
                'pan_no' => $this->input->post('pan_no'),
                'bank_name' => $this->input->post('bank_name'),
                'account_number' => $this->input->post('account_no'),
                'cr_dr' => '',
                'opening_date' => '',
                'opening_balance' => 0,
                'credit_limit' => '',
                'credit_days' => '',
                'created_by' => $this->session->userdata('user_id'),
                'created_ip' => $_SERVER['REMOTE_ADDR'],
            );
        $this->ledger_creation($employee_id,$ledgerdata, 'SAVE');
        if($this->session->userdata('school_id')==29)
        {
            $userdata=array(
                    'phone'=>$this->input->post('phone'),
                    'pension_no'=>$this->input->post('pension_no'),
                    'usergroup'=>$this->input->post('user_group'),
                    'email'=>$this->input->post('email'),
                );
        }
        else
        {
            $userdata=array(
                    'phone'=>$this->input->post('phone'),
                    'empcode'=>$this->input->post('employee_code'),
                    'usergroup'=>$this->input->post('user_group'),
                    'email'=>$this->input->post('email'),
                );
        }
        // $userdata=array(
        //             'phone'=>$this->input->post('phone'),
        //             'empcode'=>$this->input->post('employee_code'),
        //             'usergroup'=>$this->input->post('user_group'),
        //             'email'=>$this->input->post('email'),
        //         );
        
        $this->user_creation($employee_id,$userdata, 'SAVE');
        
        redirect('');
    }

    public function update($param2) {

        if (!$this->input->is_ajax_request() || substr($this->right_access, 2, 1) != 'U') {
            redirect('404');
        }

        $config['upload_path'] = 'hr/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '2048000000';
        $config['overwrite'] = FALSE;
        $this->load->library('upload',$config);
        $this->upload->initialize($config);
         $this->upload->do_upload('photo');
        if($this->upload->do_upload('photo'))
        {  
            $homeattach = array('upload_data' => $this->upload->data());

            $data = array(
            'employee_code' => $this->input->post('employee_code'),
            'doj' => $this->input->post('doj'),
            'category_id' => $this->input->post('category'),
            'designation_id' => $this->input->post('designation'),
            'department_id' => $this->input->post('department'),
            'qualification' => $this->input->post('qualification'),
            'total_experience' => $this->input->post('total_experience'),
            'name' => $this->input->post('employee_name'),
            'dob' => $this->input->post('dob'),
            'gender' => $this->input->post('gender'),
            'martial_status' => $this->input->post('martial_status'),
            'aadhar_id' => $this->input->post('aadhar_no'),
            'voter_id' => $this->input->post('voter_id'),
            'father_name' => $this->input->post('father_name'),
            'mother_name' => $this->input->post('mother_name'),
            'spouse_name' => $this->input->post('spouse_name'),
            'bank_id' => $this->input->post('bank_name'),
            'bank_accnt_no' => $this->input->post('account_no'),
            'ifsc_code' => $this->input->post('ifsc_code'),/*
            'branch_address' => $this->input->post('pan_no'),
            'pan_no' => $this->input->post('branch_address'),*/
            'branch_address' => $this->input->post('branch_address'),
            'pan_no' => $this->input->post('pan_no'),
            'pf_accnt' => $this->input->post('pf_no'),
            'esi_accnt' => $this->input->post('esi_no'),
            'address' => $this->input->post('address'),
            'phone_no' => $this->input->post('phone'),
            'email' => $this->input->post('email'),
            'leave_group' => $this->input->post('leave_group'),
            'salary_group_id' => $this->input->post('salary_group_id'),
            'pension_no' => $this->input->post('pension_no'),
            'pension_nom' => $this->input->post('pension_nom'),
            'modified_by' => $this->session->userdata('user_id'),
            'date_modified' => date('Y-m-d H:i:s'),
            'photo' =>$homeattach['upload_data']['file_name'],
        );
           
        }
        else
        {
            $data = array(
            'employee_code' => $this->input->post('employee_code'),
            'doj' => $this->input->post('doj'),
            'category_id' => $this->input->post('category'),
            'designation_id' => $this->input->post('designation'),
            'department_id' => $this->input->post('department'),
            'qualification' => $this->input->post('qualification'),
            'total_experience' => $this->input->post('total_experience'),
            'name' => $this->input->post('employee_name'),
            'dob' => $this->input->post('dob'),
            'gender' => $this->input->post('gender'),
            'martial_status' => $this->input->post('martial_status'),
            'aadhar_id' => $this->input->post('aadhar_no'),
            'voter_id' => $this->input->post('voter_id'),
            'father_name' => $this->input->post('father_name'),
            'mother_name' => $this->input->post('mother_name'),
            'spouse_name' => $this->input->post('spouse_name'),
            'bank_id' => $this->input->post('bank_name'),
            'bank_accnt_no' => $this->input->post('account_no'),
            'ifsc_code' => $this->input->post('ifsc_code'),/*
            'branch_address' => $this->input->post('pan_no'),
            'pan_no' => $this->input->post('branch_address'),*/
            'branch_address' => $this->input->post('branch_address'),
            'pan_no' => $this->input->post('pan_no'),
            'pf_accnt' => $this->input->post('pf_no'),
            'esi_accnt' => $this->input->post('esi_no'),
            'address' => $this->input->post('address'),
            'phone_no' => $this->input->post('phone'),
            'email' => $this->input->post('email'),
            'leave_group' => $this->input->post('leave_group'),
            'salary_group_id' => $this->input->post('salary_group_id'),
            'pension_no' => $this->input->post('pension_no'),
            'pension_nom' => $this->input->post('pension_nom'),
            'modified_by' => $this->session->userdata('user_id'),
            'date_modified' => date('Y-m-d H:i:s'),
        );
             
        }
        

        $this->db->where('id', $param2);
        $this->db->update('employee', $data);
        // $this->employee_leave($this->input->post('leave_group'), $param2);

        $fetch_employee = $this->dbconnection->select("employee", "*", "id=$param2");

        // if ($this->input->post('salary_group_id') != $fetch_employee[0]->salary_group_id) {
        //     $this->salary_creation($param2,$this->input->post('salary_group_id'), 'UPDATE');
        // }
        
        $field = array
                (
                'ledger_name' => $this->input->post('employee_name'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address'),
                'city' => '',
                'state' => '',
                'zip_code' => '',
                'uid_no' => $this->input->post('aadhar_no'),
                'pan_no' => $this->input->post('pan_no'),
                'bank_name' => $this->input->post('bank_name'),
                'account_number' => $this->input->post('account_no'),
                'cr_dr' => 0,
                'opening_date' => '',
                'opening_balance' => '',
                'credit_limit' => '',
                'credit_days' => '',
                'last_modified_by' => $this->session->userdata('user_id'),
                'modified_ip' => $_SERVER['REMOTE_ADDR'],
            );
        $this->ledger_creation($param2,$field, 'UPDATE', $fetch_employee[0]->emp_ledger_id);

        $fetch_user = $this->dbconnection->select("user", "user_group_id", "employee_id=$param2 and status=1");
        $usergroup_id = !empty($fetch_user[0]->user_group_id) ? $fetch_user[0]->user_group_id : 0;

        if ($this->input->post('user_group') != $usergroup_id) {
            $userdata=array(
                    
                    'usergroup'=>$this->input->post('user_group'),
                    
                );
            $this->user_creation($param2, 'UPDATE');
        }
    }

    private function employee_leave($leave_group, $employee_id) {

        $fetch_leave_entitlement = $this->dbconnection->select("leave_entitlement", "leave_id,total_allowed", "leave_group_id=$leave_group and allowed='Y'");
        foreach ($fetch_leave_entitlement as $leave) {

            $cnt_empl_leave_taken = $this->dbconnection->select("employee_leave", "count(id) as cnt", "employee_id=$employee_id and leave_type_id=$leave->leave_id and opening_leave!=balance_leave");
            if ($cnt_empl_leave_taken[0]->cnt == 0) {
                $this->dbconnection->delete("employee_leave", "employee_id=$employee_id and leave_type_id=$leave->leave_id");

                $data = array(
                    'employee_id' => $employee_id,
                    'leave_type_id' => $leave->leave_id,
                    'opening_leave' => empty($leave->total_allowed) ? 0 : $leave->total_allowed,
                    'balance_leave' => empty($leave->total_allowed) ? 0 : $leave->total_allowed,
                    'academic_year_id' => $this->academic_session[0]->fin_year,
                );
                $this->db->insert('employee_leave', $data);
            }
        }
    }
    
    
    private function salary_creation($employee_id,$salary_group_id, $task) {


        if ($task == 'UPDATE') {
            $data = array(
                'active_status' => 'CLOSED',
                'last_modified_by' => $this->session->userdata('user_id'),
                'last_date_modified'=>date('Y-m-d H:i:s')
            );
            $this->db->update('salary_head', $data, "emp_id=$employee_id and status='Y' and active_status='OPEN'");
        }

        $fetch_salary_group = $this->dbconnection->select("salary_group", "id,pf_employer,medical_employer,gross_salary,ctc_month,net_payable", "id=" . $salary_group_id);
        $data = array(
            'emp_id' => $employee_id,
            'salary_group_id' => $fetch_salary_group[0]->id,
            'pf_employer' => $fetch_salary_group[0]->pf_employer,
            'medical_employer' => $fetch_salary_group[0]->medical_employer,
            'gross_salary' => $fetch_salary_group[0]->gross_salary,
            'ctc_month' => $fetch_salary_group[0]->ctc_month,
            'net_payable' => $fetch_salary_group[0]->net_payable,
            'academic_year_id' => $this->academic_session[0]->fin_year,
            'active_status' => 'OPEN',
            'start_date' => date('Y-m-d'),
            'created_by' => $this->session->userdata('user_id'),
        );
        $this->db->insert('salary_head', $data);
    }

    private function ledger_creation($employee_id,$data, $task, $ledger_id = '0') {

        if ($task == 'SAVE') {
            
//print_r($data);
            $this->dbconnection->insert('ledger', $data);
            $ledgerid = $this->dbconnection->get_last_id();
//LEDGER ENTRY END//
            $this->dbconnection->update("employee", array('emp_ledger_id' => $ledgerid), array('id' => $employee_id));
        } elseif ($task == 'UPDATE') {
            $this->dbconnection->update('ledger', $data, 'id=' . $ledger_id);
//LEDGER ENTRY END //
        }
    }

    private function user_creation($employee_id,$userdata, $task) {


        if ($task == 'SAVE') {
                //                $this->dbconnection->update("student", array('registered_status' => 1), array('id' => $student_id));
            $hashoptions = array(); // No options currently, but, we could add in future
            $pwhash = password_hash($userdata['phone'], PASSWORD_DEFAULT, $hashoptions); // Generate new hash
            $this->load->library('Randomno');
            $salt = $this->randomno->generateRandomString();
            $password = md5($this->input->post('phone') . $salt);

            if($this->session->userdata('school_id')==29)
            {
                $data_user = array(
                    "user_name" => "{$this->school_desc[0]->school_code}-E{$userdata['phone']}",
                    'password' => $password,
                    'salt' => $salt,
                    'pw_hash' => $pwhash,
                    "encrypt_id" => 2,
                    "user_group_id" => $userdata['usergroup'],
                    "employee_id" => $employee_id,
                    "change_password" => 0,
                    'created_by' => $this->session->userdata('user_id'),
                    "contact_no" => $userdata['phone'],
                    "email" => $userdata['email'],
                );
            }
            else{
                $data_user = array(
                "user_name" => "{$this->school_desc[0]->school_code}-E{$userdata['empcode']}",
                'password' => $password,
                'salt' => $salt,
                'pw_hash' => $pwhash,
                "encrypt_id" => 2,
                "user_group_id" => $userdata['usergroup'],
                "employee_id" => $employee_id,
                "change_password" => 0,
                'created_by' => $this->session->userdata('user_id'),
                "contact_no" => $userdata['phone'],
                "email" => $userdata['email'],
            );
            }

            

            $this->dbconnection->insert("user", $data_user);
        }else if($task == 'UPDATE') {
            $data_user = array(
               
                "user_group_id" => $userdata['usergroup'],
                "last_date_modified" => date('Y-m-d H:i:s'),
                'last_modified_by' => $this->session->userdata('user_id'),
            );

            $this->dbconnection->update("user", $data_user,"employee_id=$employee_id and status=1");
        }

    }

    public function delete() {
        if (!$this->input->is_ajax_request() || substr($this->right_access, 3, 1) != 'D') {
            redirect('404');
        }
        $employee_id_string = $this->input->post('employee_id_string');
        foreach ($employee_id_string as $val) {
            $this->dbconnection->update('employee', array('status' => 0), 'id=' . $val);
            $this->dbconnection->update('salary_head', array('status' => 0), 'emp_id=' . $val);
            //$this->dbconnection->update('ledger', array('status' => 'N'), 'emp_id=' . $val);
        }
    }

    public function exportcsv() {


        $where = ' status=1';
        $records = $this->dbconnection->select("employee", "employee_code,name,doj,category_id,(select category_desc "
                . "from employee_category where id=category_id) category_id_desp,department_id,"
                . "(select department_desc from employee_department where id=department_id) department_id_desp,"
                . "designation_id,(select designation_desc from employee_designation where id=designation_id) designation_id_desp,"
                . "leave_group,(select leave_group_name from leave_group where id=leave_group) leave_group_desp,"
                . "salary_group_id,(select salary_group_name from salary_group where id=salary_group_id) salary_group_desp,"
                . "qualification,total_experience,father_name,mother_name,dob,gender,martial_status,spouse_name,aadhar_id,"
                . "voter_id,bank_id,(select bank_code from crmfeesclub.bank where id=bank_id) bank_id_desp,bank_accnt_no,"
                . "ifsc_code,pan_no,branch_address,pf_accnt,esi_accnt,address,phone_no,email  ", $where);

        $filename = "FCLB-$this->school_code-Employee-Export-" . date('Ymd') . ".csv";


        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $filename);

        $colnames = array();
        $colnames[] = 'Employee Code';
        $colnames[] = 'Employee Name';
        $colnames[] = 'Joining Date';
        $colnames[] = 'Employee Category';
        $colnames[] = 'Department';
        $colnames[] = 'Designation';
        $colnames[] = 'Leave Group';
        $colnames[] = 'User Group';
        $colnames[] = 'Salary Group';
        $colnames[] = 'Qualification';
        $colnames[] = 'Total Experience';
        $colnames[] = 'Father\'s Name';
        $colnames[] = 'Mother\'s Name';
        $colnames[] = 'D.O.B';
        $colnames[] = 'Gender';
        $colnames[] = 'Martial Status';
        $colnames[] = 'Spouse Name';
        $colnames[] = 'Aadhar No';
        $colnames[] = 'Voter Id';
        $colnames[] = 'Bank Name';
        $colnames[] = 'Account NO';
        $colnames[] = 'IFSC Code';
        $colnames[] = 'Pan NO';
        $colnames[] = 'Branch Address';
        $colnames[] = 'PF No';
        $colnames[] = 'ESI No';
        $colnames[] = 'Address';
        $colnames[] = 'Phone No';
        $colnames[] = 'Email';


        $out = fopen('php://output', 'w');
        fputcsv($out, $colnames);
        foreach ($records as $rec) {
            $recarr = array();
            $recarr[] = $rec->employee_code;
            $recarr[] = $rec->name;
            $recarr[] = $rec->doj;
            $recarr[] = $rec->category_id_desp;
            $recarr[] = $rec->department_id_desp;
            $recarr[] = $rec->designation_id_desp;
            $recarr[] = $rec->leave_group_desp;
            $recarr[] = '';
            $recarr[] = $rec->salary_group_desp;
            $recarr[] = $rec->qualification;
            $recarr[] = $rec->total_experience;
            $recarr[] = $rec->father_name;
            $recarr[] = $rec->mother_name;
            $recarr[] = $rec->dob;
            $recarr[] = $rec->gender;
            $recarr[] = $rec->martial_status;
            $recarr[] = $rec->spouse_name;
            $recarr[] = $rec->aadhar_id;
            $recarr[] = $rec->voter_id;
            $recarr[] = $rec->bank_id_desp;
            $recarr[] = $rec->bank_accnt_no;
            $recarr[] = $rec->ifsc_code;
            $recarr[] = $rec->pan_no;
            $recarr[] = $rec->branch_address;
            $recarr[] = $rec->pf_accnt;
            $recarr[] = $rec->esi_accnt;
            $recarr[] = $rec->address;
            $recarr[] = $rec->phone_no;
            $recarr[] = $rec->email;
            fputcsv($out, $recarr);
        }
        fclose($out);
    }

    public function importcsv() {

        $this->data['page_name'] = 'upload_employee';
        $this->data['page_title'] = 'Upload Employee';
        $this->data['section'] = 'hr/staff';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->data['fetch_designation'] = $this->dbconnection->select("employee_designation", "id,UPPER(designation_desc) designation_desc", "status=1");
        $this->data['fetch_department'] = $this->dbconnection->select("employee_department", "id,UPPER(department_desc) department_desc", "status=1");
        $this->data['fetch_category'] = $this->dbconnection->select("employee_category", "id,UPPER(category_desc) category_desc", "status=1");
        $this->data['fetch_leave_group'] = $this->dbconnection->select("leave_group", "id,UPPER(leave_group_name) leave_group_name", "status=1");
        $this->data['fetch_user_group'] = $this->dbconnection->select("user_group", "id,group_type", "status='Y' and id>1");
        $this->data['fetch_salary_group'] = $this->dbconnection->select("salary_group", "id,salary_group_name", "status='Y'");
        $this->data['fetch_bank'] = $this->bank;

        $this->load->view('index', $this->data);
    }

    public function upload() {

        if (substr($this->right_access, 0, 1) != 'C') {
            redirect('404');
        }
//                ini_set('max_input_time', 0);
        ini_set('max_execution_time', 3600);
        // error_reporting(-1);
        // ini_set('display_errors', 1);
        // $this->db->db_debug=TRUE;
        $this->data['errors'] = array();
// Cache employee_code
        $this->db->select('employee_code');
        $query = $this->db->get('employee');
        $employee_code = array_column($query->result_array(), NULL, 'employee_code');

// Cache bank
        $query = $this->dbconnection->select_returnarray("crmfeesclub.bank", "id,bank_code", "");
        $bank = array_change_key_case(array_column($query, 'id', 'bank_code'), CASE_UPPER);

// Cache designation

        $query = $this->dbconnection->select_returnarray("employee_designation", "id,UPPER(designation_desc) designation_desc", "status=1");
        $designation = array_change_key_case(array_column($query, 'id', 'designation_desc'), CASE_UPPER);

// Cache department

        $query = $this->dbconnection->select_returnarray("employee_department", "id,UPPER(department_desc) department_desc", "status=1");
        $department = array_change_key_case(array_column($query, 'id', 'department_desc'), CASE_UPPER);

// Cache leave_group

        $query = $this->dbconnection->select_returnarray("leave_group", "id,UPPER(leave_group_name) leave_group_name", "status=1");
        $leave_group = array_change_key_case(array_column($query, 'id', 'leave_group_name'), CASE_UPPER);
        
// Cache user_group

        $query = $this->dbconnection->select_returnarray("user_group", "id,UPPER(group_type) group_type", "status='Y'");
        $user_group = array_change_key_case(array_column($query, 'id', 'group_type'), CASE_UPPER);
        
// Cache salary_group

        $query = $this->dbconnection->select_returnarray("salary_group", "id,UPPER(salary_group_name) salary_group_name", "status='Y'");
        $salary_group = array_change_key_case(array_column($query, 'id', 'salary_group_name'), CASE_UPPER);


        $category = array('TEACHING' => '1', 'NON-TEACHING' => '2');

        if (!empty($_FILES['admission_upload']['tmp_name'])) {

            $employee_code_file = array();
            $handle = fopen($_FILES['admission_upload']['tmp_name'], "r");
            fgetcsv($handle); // Read and discard header row
            while (($row = fgetcsv($handle, 10000, ",")) !== FALSE) {
                $rowarr = array();
                foreach ($row as $pos => $value) {
//                                        if($pos!=13 || $pos!=14 || $pos!=15 ){
//                    if ($pos < 4) {
//                        if (!isset($this->admission_csv_columns[$pos]))
//                            continue;
//                    }
                    $rowarr[$this->admission_csv_columns[$pos]['field']] = trim($value);
                }
                /* ------ checking duplicate admission number in csv file  -------- */
                if (in_array($rowarr['employee_code'], $employee_code_file)) {
                    $this->data['errors'][] = "Employeee Code '" . $rowarr['employee_code'] . "' previously present in this file, skipping...";
                    continue;
                }

                $employee_code_file[] = $rowarr['employee_code'];
                if (isset($employee_code[$rowarr['employee_code']])) {
                    $this->data['errors'][] = "Employeee Code '" . $rowarr['employee_code'] . "' already present, skipping...";
                    continue;
                }

                if (!isset($category[strtoupper($rowarr['category_id'])])) {
                    $this->data['errors'][] = "Employeee Code '" . $rowarr['employee_code'] . "' has undefined category of '" . $rowarr['category_id'] . "', skipping...";
                    continue;
                }
//                echo $department[strtoupper($rowarr['department_id'])];

                if (!isset($department[strtoupper($rowarr['department_id'])])) {
                    $this->data['errors'][] = "Employeee Code '" . $rowarr['employee_code'] . "' has undefined department of '" . $rowarr['department_id'] . "', skipping...";
                    continue;
                }

                if (!isset($designation[strtoupper($rowarr['designation_id'])])) {
                    $this->data['errors'][] = "Employeee Code '" . $rowarr['employee_code'] . "' has undefined designation of '" . $rowarr['designation_id'] . "', skipping...";
                    continue;
                }

                if (!isset($leave_group[strtoupper($rowarr['leave_group'])])) {
                    $this->data['errors'][] = "Employeee Code '" . $rowarr['employee_code'] . "' has undefined Leave group of '" . $rowarr['leave_group'] . "', skipping...";
                    continue;
                }
                
                if (!isset($user_group[strtoupper($rowarr['user_group'])])) {
                    $this->data['errors'][] = "Employeee Code '" . $rowarr['user_group'] . "' has undefined User group of '" . $rowarr['user_group'] . "', skipping...";
                    continue;
                }
                
                if (!isset($salary_group[strtoupper($rowarr['salary_group'])])) {
                    $this->data['errors'][] = "Employeee Code '" . $rowarr['salary_group'] . "' has undefined Salary group of '" . $rowarr['salary_group'] . "', skipping...";
                    continue;
                }

                if (!empty($rowarr['bank_id']) && !isset($bank[strtoupper($rowarr['bank_id'])])) {
                    $this->data['errors'][] = "Employeee Code '" . $rowarr['employee_code'] . "' has undefined bank code of '" . $rowarr['bank_id'] . "', skipping...";
                    continue;
                }

                if (!empty($data[2]) && date('Y', strtotime(str_replace('/', '-', $data[2]))) == 1970) {
                    $this->data['errors'][] = "Line $linerow: Employeee Code '" . $data[0] . "' contains Joining date Invalid, skipping...";
                    continue;
                }

                if (!empty($data[11]) && date('Y', strtotime(str_replace('/', '-', $data[11]))) == 1970) {
                    $this->data['errors'][] = "Line $linerow: Employeee Code '" . $data[0] . "' contains D.O.B Invalid, skipping...";
                    continue;
                }


//				$reference_no = "$this->country_code-$this->state_code-$this->city_code-$this->school_code-{$rowarr['admission_no']}";
//                                if(!empty($this->data['errors'])) {
                $data_student = array(
//						"reference_no" => $reference_no,

                    "employee_code" => $rowarr['employee_code'],
                    "name" => $rowarr['name'],
                    "doj" => !empty($rowarr['doj']) ? date('Y-m-d', strtotime(str_replace('/', '-', $rowarr['doj']))) : '',
                    "category_id" => $category[strtoupper($rowarr['category_id'])],
                    "department_id" => $department[strtoupper($rowarr['department_id'])],
                    "designation_id" => $designation[strtoupper($rowarr['designation_id'])],
                    "leave_group" => $leave_group[strtoupper($rowarr['leave_group'])],
                    // "leave_group" =>'',
                    // "salary_group_id" => '',
                    "salary_group_id" => $salary_group[strtoupper($rowarr['salary_group'])],
                    // "qualification" => $rowarr['qualification'],
                    "total_experience" => $rowarr['total_experience'],
                    "father_name" => $rowarr['father_name'],
                    "mother_name" => $rowarr['mother_name'],
                    "dob" => !empty($rowarr['dob']) ? date('Y-m-d', strtotime(str_replace('/', '-', $rowarr['dob']))) : '',
                    "gender" => $rowarr['gender'],
                    "martial_status" => $rowarr['martial_status'],
                    "spouse_name" => $rowarr['spouse_name'],
                    "aadhar_id" => $rowarr['aadhar_id'],
                    "voter_id" => $rowarr['voter_id'],
                    "bank_id" => !empty($rowarr['bank_id']) ? $rowarr['bank_id'] : 0,
                    "bank_accnt_no" => $rowarr['bank_accnt_no'],
                    "ifsc_code" => $rowarr['ifsc_code'],
                    "pan_no" => $rowarr['pan_no'],
                    "branch_address" => $rowarr['branch_address'],
                    "pf_accnt" => $rowarr['pf_accnt'],
                    "esi_accnt" => $rowarr['esi_accnt'],
                    "address" => $rowarr['address'],
                    "phone_no" => $rowarr['phone_no'],
                    "email" => $rowarr['email'],
                    "pension_no" => $rowarr['pension_no'],
                    "pension_nom" => $rowarr['pension_nom'],
                    "academic_year_id" => $this->academic_session[0]->fin_year,
                    "created_by" => $this->session->userdata('user_id'),
                );
                $this->db->insert('employee', $this->security->xss_clean($data_student));
                $employee_id = $this->dbconnection->get_last_id();
                $this->employee_leave($leave_group[strtoupper($rowarr['leave_group'])], $employee_id);

                $employee_code[$rowarr['employee_code']] = TRUE;

                $this->salary_creation($employee_id,$salary_group[strtoupper($rowarr['salary_group'])], 'SAVE');

                $ledger_data = array(
//						"reference_no" => $reference_no,

                    "ledger_code" => $rowarr['employee_code'],
                    "ledger_name" => $rowarr['name'],
                    'under_group' => 7,
                    "email" => $rowarr['email'],
                    "phone" => $rowarr['phone_no'],
                    "address" => $rowarr['address'],             
                    'city' => '',
                    'state' => '',
                    'zip_code' => '',
                    "uid_no" => $rowarr['aadhar_id'],
                    "pan_no" => $rowarr['pan_no'],
                    "bank_name" => !empty($rowarr['bank_id']) ? $rowarr['bank_id'] : 0,
                    "account_number" => $rowarr['bank_accnt_no'],
                    'cr_dr' => 0,
                    'opening_date' => '',
                    'opening_balance' => '',
                    'credit_limit' => '',
                    'credit_days' => '',
                    'last_modified_by' => $this->session->userdata('user_id'),
                    'modified_ip' => $_SERVER['REMOTE_ADDR'],
                    
                );
                $this->ledger_creation($employee_id,$ledger_data, 'SAVE');

                $userdata=array(
                    'phone'=>$rowarr['phone_no'],
                    'empcode'=>$rowarr['employee_code'],
                    'usergroup'=>$user_group[strtoupper($rowarr['user_group'])],
                    'email'=>$rowarr['email'],
                );
                $this->user_creation($employee_id,$userdata, 'SAVE');

                $audit = array("action" => 'Upload Employee Information',
                    "module" => "STAFF Module",
                    'datetime' => date("Y-m-d H:i:s"),
                    'userid' => $this->session->userdata('user_id'),
                    'student_id' => $employee_id,
                    'page' => 'School',
                    'remarks' => ''
                );
                $this->dbconnection->insert("auditntrail", $audit);
//                                }
//                            }else {/*------------  end of checking duplicate data in csv file   -------------*/
//                                
//                            }
            }
        }
        if (empty($this->data['errors'])) {
            $this->session->set_flashdata('employeeupload', 'Successfully Uploaded !');
        } else {
            $this->session->set_flashdata('employeeupload', 'File has some error !');
        }
        $this->importcsv();
    }

    public function bulk_update() {
   // error_reporting(-1);
   //  ini_set('display_errors', 1);
   //  $this->db->db_debug=TRUE;
        if (substr($this->right_access, 2, 1) != 'U') {
            redirect('404');
        }
        if (!$this->session->flashdata('employeebulkupdate')) {

            $this->data['errors'] = array();
            $this->db->select('employee_code');
            $query = $this->db->get('employee');
            $employee_code = array_column($query->result_array(), NULL, 'employee_code');

            $bank = array_change_key_case(array_column($this->bank, 'id', 'bank_code'), CASE_UPPER);

            $query = $this->dbconnection->select_returnarray("employee_designation", "id,UPPER(designation_desc) designation_desc", "status=1");
            $designation = array_change_key_case(array_column($query, 'id', 'designation_desc'), CASE_UPPER);

            $query1 = $this->dbconnection->select_returnarray("employee_department", "id,UPPER(department_desc) department_desc", "status=1");
            $department = array_change_key_case(array_column($query1, 'id', 'department_desc'), CASE_UPPER);

            $query2 = $this->dbconnection->select_returnarray("leave_group", "id,UPPER(leave_group_name) leave_group_name", "status=1");
            $leave_group = array_change_key_case(array_column($query2, 'id', 'leave_group_name'), CASE_UPPER);

            $query3 = $this->dbconnection->select_returnarray("user_group", "id,UPPER(group_type) group_type", "status='Y'");
            $user_group = array_change_key_case(array_column($query3, 'id', 'group_type'), CASE_UPPER);

            $query4 = $this->dbconnection->select_returnarray("salary_group", "id,UPPER(salary_group_name) salary_group_name", "status='Y'");
            $salary_group = array_change_key_case(array_column($query4, 'id', 'salary_group_name'), CASE_UPPER);

            $category = array('TEACHING' => '1', 'NON-TEACHING' => '2');

            if (!empty($_FILES['admission_upload']['tmp_name'])) {

                $employee_code_file = array();
                $handle = fopen($_FILES['admission_upload']['tmp_name'], "r");
                fgetcsv($handle); 
                while (($row = fgetcsv($handle, 10000, ",")) !== FALSE) {
                    $rowarr = array();
                    $data_student = array();
                    foreach ($row as $pos => $value) {

                        if ($pos < 4) {
                            if (!isset($this->admission_csv_columns[$pos]))
                                continue;
                        }
                        $rowarr[$this->admission_csv_columns[$pos]['field']] = trim($value);
                    }
                    if (in_array($rowarr['employee_code'], $employee_code_file)) {
                        $this->data['errors'][] = "Employeee Code '" . $rowarr['employee_code'] . "' previously present in this file, skipping...";
                        continue;
                    }

                    $employee_code_file[] = $rowarr['employee_code'];
                    if (!isset($employee_code[$rowarr['employee_code']])) {
                        $this->data['errors'][] = "Employeee Code '" . $rowarr['employee_code'] . "' is not already present, skipping...";
                        continue;
                    }


                    if (!empty($rowarr['category_id']) && !isset($category[strtoupper($rowarr['category_id'])])) {
                        $this->data['errors'][] = "Employeee Code '" . $rowarr['employee_code'] . "' has undefined category of '" . $rowarr['category_id'] . "', skipping...";
                        continue;
                    }

                    if (!empty($rowarr['department_id']) && !isset($department[strtoupper($rowarr['department_id'])])) {
                        $this->data['errors'][] = "Employeee Code '" . $rowarr['employee_code'] . "' has undefined department of '" . $rowarr['department_id'] . "', skipping...";
                        continue;
                    }

                    if (!empty($rowarr['designation_id']) && !isset($designation[strtoupper($rowarr['designation_id'])])) {
                        $this->data['errors'][] = "Employeee Code '" . $rowarr['employee_code'] . "' has undefined designation of '" . $rowarr['designation_id'] . "', skipping...";
                        continue;
                    }

                    if (!empty($rowarr['leave_group']) && !isset($leave_group[strtoupper($rowarr['leave_group'])])) {
                        $this->data['errors'][] = "Employeee Code '" . $rowarr['employee_code'] . "' has undefined Leave group of '" . $rowarr['leave_group'] . "', skipping...";
                        continue;
                    }
                    
                    if (!empty($rowarr['user_group']) && !isset($user_group[strtoupper($rowarr['user_group'])])) {
                        $this->data['errors'][] = "Employeee Code '" . $rowarr['employee_code'] . "' has undefined User group of '" . $rowarr['user_group'] . "', skipping...";
                        continue;
                    }
                    
                    if (!empty($rowarr['salary_group']) && !isset($salary_group[strtoupper($rowarr['salary_group'])])) {
                        $this->data['errors'][] = "Employeee Code '" . $rowarr['employee_code'] . "' has undefined Salary group of '" . $rowarr['salary_group'] . "', skipping...";
                        continue;
                    }

                    if (!empty($data[2]) && date('Y', strtotime(str_replace('/', '-', $data[2]))) == 1970) {
                        $this->data['errors'][] = "Line $linerow: Employeee Code '" . $data[0] . "' contains Joining date Invalid, skipping...";
                        continue;
                    }

                    if (!empty($data[11]) && date('Y', strtotime(str_replace('/', '-', $data[11]))) == 1970) {
                        $this->data['errors'][] = "Line $linerow: Employeee Code '" . $data[0] . "' contains D.O.B Invalid, skipping...";
                        continue;
                    }

                    if (!empty($rowarr['bank_id']) && !isset($bank[strtoupper($rowarr['bank_id'])])) {
                        $this->data['errors'][] = "Employeee Code '" . $rowarr['employee_code'] . "' has undefined bank of '" . $rowarr['bank_id'] . "', skipping...";
                        continue;
                    }


                    foreach ($rowarr as $index => $value) {
                        // print_r($index);
                        // echo '<br>';
                        // die();

                        if (!empty($value)) {
                            if ($index == 'category_id') {
                                $data_student[$index] = $category[strtoupper($rowarr['category_id'])];
                            } else if ($index == 'department_id') {
                                $data_student[$index] = $department[strtoupper($rowarr['department_id'])];
                            } else if ($index == 'designation_id') {
                                $data_student[$index] = $designation[strtoupper($rowarr['designation_id'])];
                            } else if ($index == 'leave_group') {
                                $data_student[$index] = $leave_group[strtoupper($rowarr['leave_group'])];
                            } 
                            else if ($index == 'salary_group') {
                                $data_student[$index] = $salary_group[strtoupper($rowarr['salary_group'])];
                            } 
                            else if ($index == 'dob') {
                                $data_student[$index] = date('Y-m-d', strtotime(str_replace('/', '-', $rowarr['dob'])));
                            } else if ($index == 'doj') {
                                $data_student[$index] = date('Y-m-d', strtotime(str_replace('/', '-', $rowarr['doj'])));
                            } 
                            else if ($index == 'bank_id') {
                                $data_student[$index] = $bank[strtoupper($rowarr['bank_id'])];
                            } 
                            else {
                                $data_student[$index] = $value;
                            }
                        }
                    }
                     // die();
                    // print_r($value);
                    // die();

                    $employee_id = $this->dbconnection->Get_namme('employee', 'employee_code', $rowarr['employee_code'], 'id');
                   
                    $data_student['date_modified'] = date('Y-m-d H:i:s');
                    $data_student['modified_by'] = $this->session->userdata('user_id');
                    // $data_student['salary_group_id'] = $salary_group[strtoupper($rowarr['salary_group'])];
//                                $data_student['student_academicyear_id']=$this->academic_session[0]->fin_year;
                    $update_data=$this->dbconnection->update("employee", $data_student, array('id' => $employee_id));
                    //  print_r($update_data);
                    // die();
                    // $this->employee_leave($leave_group[strtoupper($rowarr['leave_group'])], $employee_id);

                    $fetch_employee = $this->dbconnection->select("employee", "*", "id=$employee_id");

                    // if ($salary_group[strtoupper($rowarr['salary_group'])] != $fetch_employee[0]->salary_group_id) {
                    // $this->salary_creation($employee_id,$salary_group[strtoupper($rowarr['salary_group'])], 'UPDATE');
                    // }
                    
                    $ledger_data = array(

                        "ledger_name" => $rowarr['name'],
                        "email" => $rowarr['email'],
                        "phone" => $rowarr['phone_no'],
                        "address" => $rowarr['address'],             
                        'city' => '',
                        'state' => '',
                        'zip_code' => '',
                        "uid_no" => $rowarr['aadhar_id'],
                        "pan_no" => $rowarr['pan_no'],
                        "bank_name" => !empty($rowarr['bank_id']) ? $rowarr['bank_id'] : 0,
                        "account_number" => $rowarr['bank_accnt_no'],
                        'cr_dr' => 0,
                        'opening_date' => '',
                        'opening_balance' => '',
                        'credit_limit' => '',
                        'credit_days' => '',
                        'last_modified_by' => $this->session->userdata('user_id'),
                        'modified_ip' => $_SERVER['REMOTE_ADDR'],

                    );
                    $this->ledger_creation($employee_id,$ledger_data, 'UPDATE', $fetch_employee[0]->emp_ledger_id);

                    $fetch_user = $this->dbconnection->select("user", "user_group_id", "employee_id=$employee_id and status=1");
                    $usergroup_id = !empty($fetch_user[0]->user_group_id) ? $fetch_user[0]->user_group_id : 0;

                    if ($user_group[strtoupper($rowarr['user_group'])] != $usergroup_id) {
                    $userdata=array(
                        'usergroup'=>$user_group[strtoupper($rowarr['user_group'])],
                    );
                    $this->user_creation($employee_id,$userdata, 'SAVE');
                    }
                    $audit = array("action" => 'Bulk Update Employee Information',
                        "module" => "Admission Module",
                        'datetime' => date("Y-m-d H:i:s"),
                        'userid' => $this->session->userdata('user_id'),
                        'student_id' => $employee_id,
                        'page' => 'Upload_employee',
                        'remarks' => ''
                    );
                    $this->dbconnection->insert("auditntrail", $audit);
//                                }
//                            }else {/*------------  end of checking duplicate data in csv file   -------------*/
//                                
                }
            }
            if (empty($this->data['errors'])) {
                $this->session->set_flashdata('employeebulkupdate', 'Successfully Updated !');
            } else {
                $this->session->set_flashdata('employeebulkupdate', 'File has some error !');
            }
            $this->importcsv();
        } else {
            redirect(base_url('/hr/staff/employees/importcsv'), 'refresh');
        }
    }

    public function download_format() {
        $this->load->helper('download');
        $fh = fopen('php://memory', 'w');

        fputcsv($fh, array_column($this->admission_csv_columns, 'human_name'));
        fseek($fh, 0);
        
        $csv = stream_get_contents($fh);
        force_download('FCLB-'.$this->school_code.'-Employee-NewUPLOAD-Format.csv', $csv);
    }

}
