<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class My_salary extends CI_Controller {

    public $page_code = 'my_salary';
    public $page_id = '';
    public $page_perm = '----';
    
    public function __construct() {

        parent::__construct();
        $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");

        $this->id = $this->session->userdata('school_id');
        $this->school_desc = $this->dbconnection->select("school", "*", "id=" . $this->id . " and status = 1");
        $this->schools = $this->dbconnection->select("school", "*", 'status = 1');
        $this->bank = $this->dbconnection->select("bank", "*");
        if ($this->id != 0)
            $this->db->db_select('crmfeesclub_' . $this->id);

        $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
        $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
        $this->right_access = $this->page_perm;

        if (strpos($this->page_perm, '----') == true) {
            redirect(base_url(''), 'refresh');
        }
        
        $this->page_title = 'My Salary';
        $this->section = 'hr/payroll';
        $this->page_name = 'salary_structure';
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
        $this->data['employee_id']=!empty($getempid) ?  $getempid[0]->employee_id: 0;
        $this->data['fetch_salary_structure'] = $this->dbconnection->select('salary_head', "id,emp_id,(select employee_code from employee where status=1 and id=emp_id) as emp_code, (select name from employee where status=1 and id=emp_id) as emp_name, year,academic_year_id,gross_salary,(ctc_month*12) as ctc_year,ctc_month,(gross_salary-net_payable) as deduction,net_payable,(ctc_month-gross_salary) as employer_contri,start_date,end_date,active_status", "status=1 and emp_id=".$this->data['employee_id']);

        $this->load->view('index', $this->data);
    }



    public function viewSalary() {
        
        if (substr($this->right_access, 1, 1) != 'R') {
            redirect('404');
        }

        $salary_head_id= str_replace('v_', '', $this->input->post('id'));
        $emp_id= $this->input->post('emp_id');
        $salary = $this->dbconnection->select("salary_group", "*", "id=".$salary_head_id);
        $fetch_detail = $this->dbconnection->select("employee", "id,name,aadhar_id,category_id,designation_id,bank_id,bank_accnt_no,pf_accnt,esi_accnt,employee_code", "id=" . $emp_id);

        $earning_sal=$this->dbconnection->select('salary_type', "*,(select amount from salary_entitlement where salary_id=salary_type.id and salary_group_id={$salary[0]->id} and status='Y') as sal_amt", "status=1 and id!=11 and id!=13");

        $earning_sal1=$this->dbconnection->select('salary_type', "*,(select amount from salary_entitlement where salary_id=salary_type.id and salary_group_id={$salary[0]->id} and status='Y') as sal_amt", "status=1 and id!=11 and id!=13");

        $earning='';
        $deduction='';


        foreach($earning_sal as $r){
            if($r->salary_typ==1) {
                $sal_amt=(round($r->sal_amt,2));
                $earning.='<tr class="earning">';
                $earning .='<td colspan="2">'.$r->salary_code.'</td> <td colspan="2">'.$sal_amt.'</td>';
                $earning .='</tr>';
            }
            else if($r->salary_typ==4) {
                $sal_amt=(round($r->sal_amt,2));
                $ctccal.='<tr class="ctc">';
                $ctccal .='<td colspan="2">'.$r->salary_code.'</td> <td colspan="2">'.$sal_amt.'</td>';
                $ctccal .='</tr>';

            } else if($r->salary_typ==2){
                $sal_amt=(round($r->sal_amt,2));
                $deduction.='<tr class="deduction">';
                $deduction .='<td colspan="2">'.$r->salary_code.'</td> <td colspan="2">'.$sal_amt.'</td>';
                $deduction .='</tr>';
            }
            else{}
        }
            $totalctctamt=0;
            $ctcamt=0;
        foreach($earning_sal1 as $r1){
               
            if($r1->salary_typ==4) {
                $ctcamt=$r1->sal_amt;
                $totalctctamt=$totalctctamt + $ctcamt;
            }
        }



        $cctm=(round($salary[0]->ctc_month,2));
        $cctmyear=(round($cctm*12,2));
        $data=array(
            'emp_code' =>$fetch_detail[0]->employee_code,
            'emp_name'=> $fetch_detail[0]->name,
            'emp_cat'=> $this->dbconnection->Get_namme('employee_category', 'id', $fetch_detail[0]->category_id, 'category_desc'),
            'emp_desg'=> $this->dbconnection->Get_namme('employee_designation', 'id', $fetch_detail[0]->designation_id, 'designation_desc'),
            'aadhar'=> $fetch_detail[0]->aadhar_id,
            'pfaccnt'=> $fetch_detail[0]->pf_accnt,
            'esicaccnt'=> $fetch_detail[0]->esi_accnt,
            'bnkaccnt'=> $fetch_detail[0]->bank_accnt_no,
            'startdate'=> $salary[0]->start_date,
            'enddate'=> $salary[0]->end_date,
            'earning'=> $earning,
            'ctccal'=> $ctccal,
            'deduction'=> $deduction,
            'gross'=> $salary[0]->gross_salary,
            'net'=> $salary[0]->net_payable,
            'pfemployer'=> $salary[0]->pf_employer,
            'esicemployer'=> $salary[0]->medical_employer,
            'ctcm'=> $cctm,
            'cctmyear'=> $cctmyear,
            'totalctctamt' => $totalctctamt,
        );
        
        echo json_encode($data);
    }

}
