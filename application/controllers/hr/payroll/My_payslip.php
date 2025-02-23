<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class My_payslip extends CI_Controller {

    public $page_code = 'my_payslip';
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
        
        $this->page_title = 'My Salary Slip';
        $this->section = 'hr/payroll';
        $this->page_name = 'calculate_salary_list';
        $this->customview = '';
    }

    public function index() {
        if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->data['page_name']            = 'calculate_salary_list';
        $this->data['page_title']           = $this->page_title;
        $this->data['section']              = $this->section;
        $this->data['customview']           = $this->customview;
        $this->data['right_access']         = $this->right_access;
        $getempid=$this->dbconnection->select("user","employee_id","id=".$this->session->userdata('user_id'));
        $this->data['employee_id']=!empty($getempid) ?  $getempid[0]->employee_id: 0;
        $this->data['fetch_employee_salary']= $this->dbconnection->select('salary_calculation', "id,emp_id,(select employee_code from employee where status=1 and id=emp_id) as emp_code, (select name from employee where status=1 and id=emp_id) as emp_name, year, month,paid_status,paid_days,working_days,amount_paid", "status=1 and emp_id=".$this->data['employee_id']);

        $this->load->view('index', $this->data);
    }

    public function viewSalary() {

        if (substr($this->right_access, 1, 1) != 'R') 
        {
            redirect('404');
        }
        $school_id = $this->session->userdata('school_id');
        $school = $this->school_desc;
        $salary_calc_id= $this->input->post('id');
        $salary = $this->dbconnection->select("salary_calculation", "*", "id=".$salary_calc_id); 
        $fetch_detail = $this->dbconnection->select("employee", "id,name,aadhar_id,category_id,designation_id,bank_id,bank_accnt_no,pf_accnt,esi_accnt,employee_code", "id=" . $salary[0]->emp_id);
        $salary_head_id=$salary[0]->sal_head_id;
        $earning_sal=$this->dbconnection->select('salary_type', "*,(select amount from salary_entitlement where salary_id=salary_type.id and salary_group_id=$salary_head_id and salary_type.id and status='Y') as sal_amt", "status=1");

        $earning_sal1=$this->dbconnection->select('salary_type', "*,(select amount from salary_entitlement where salary_id=salary_type.id and salary_group_id=$salary_head_id and status='Y') as sal_amt", "status=1");

        $sal_head   = $this->dbconnection->select("salary_group", "*", "id=" . $salary_head_id);
        $earning='';
        $deduction='';
        foreach($earning_sal as $r)
        {
            if($r->salary_typ==1) 
            {
                $earning.='<tr>';
                $earning .='<td colspan="2">'.$r->salary_code.'</td> <td>'.round(($r->sal_amt/$salary[0]->working_days)*$salary[0]->paid_days).'</td>';
                 
                $earning .='</tr>';

            }
            else if($r->salary_typ==4) 
            {
                $total1=0;
                $ctccal.='<tr>';
                $ctccal .='<td>'.$r->salary_code.'</td> <td>'.round($r->sal_amt).'</td>';
                $ctccal .='</tr>';

            } 
            else if($r->salary_typ==3) 
            {
                $ctccals.='<tr>';
                $ctccals .='<td>'.$r->salary_name.'</td> <td>'.round($r->sal_amt).'</td>';
                $ctccals .='</tr>';

            } 
            else if($r->salary_typ==2)
            {
                $deduction.='<tr>';
                $deduction .='<td colspan="2">'.$r->salary_code.'</td> <td>'.round(($r->sal_amt/$salary[0]->working_days)*$salary[0]->paid_days).'</td>';
                $deduction .='</tr>';
            }
            else{}
        }
            $totalctctamt=0;
            $totalerntamt=0;
            $totaldedamt=0;
            $erncamt=0;
            $dedcamt=0;
        foreach($earning_sal1 as $r1)
        {               
            if($r1->salary_typ==4) 
            {
                $ctcamt=$r1->sal_amt;
                $totalctctamt=$totalctctamt + $ctcamt;
            }
        }

        foreach($earning_sal1 as $r1)
        {               
            if($r1->salary_typ==1) 
            {
                $erncamt=$r1->sal_amt;
                $totalerntamt=$totalerntamt + $erncamt;
            }
        }

        foreach($earning_sal1 as $r1)
        {               
            if($r1->salary_typ==2) 
            {
                $dedcamt=$r1->sal_amt;
                $totaldedamt=$totaldedamt + $dedcamt;
            }
        }

        $data = array(
            'emp_code' =>$fetch_detail[0]->employee_code,
            'emp_name'=> $fetch_detail[0]->name,
            'emp_cat'=> $this->dbconnection->Get_namme('employee_category', 'id', $fetch_detail[0]->category_id, 'category_desc'),
            'emp_desg'=> $this->dbconnection->Get_namme('employee_designation', 'id', $fetch_detail[0]->designation_id, 'designation_desc'),
            'aadhar'=> $fetch_detail[0]->aadhar_id,
            'pfaccnt'=> $fetch_detail[0]->pf_accnt,
            'esicaccnt'=> $fetch_detail[0]->esi_accnt,
            'bnkaccnt'=> $fetch_detail[0]->bank_accnt_no,
            'workingdays'=> $salary[0]->working_days,
            'leaveapprove'=> $salary[0]->total_leave_approved,
            'absent'=> $salary[0]->absent_days,
            'present'=> $salary[0]->paid_days,
            'payslipno'=> $salary[0]->pay_slipno,
            'sal_monthyr'=> $salary[0]->year.'-'.$salary[0]->month,
            'earning'=> $earning,
            'deduction'=> $deduction,
            'ctccal'=> $ctccal,
            'ctccals'=> $ctccals,
            'gross'=> round(($sal_head[0]->gross_salary)),
            // 'gross'=> round(($sal_head[0]->gross_salary/$salary[0]->working_days)*$salary[0]->paid_days),
            'net'=> $salary[0]->amount_paid,
            'pfemployer'=> round(($sal_head[0]->pf_employer/$salary[0]->working_days)*$salary[0]->paid_days),
            'remburse_amt'=> round(($salary[0]->remburse_amt)),
            'esicemployer'=> round(($sal_head[0]->medical_employer/$salary[0]->working_days)*$salary[0]->paid_days),
            'ctcm'=> round(($sal_head[0]->ctc_month/$salary[0]->working_days)*$salary[0]->paid_days  + $ctccal),
             'school_id' => $school_id,
            'school_name' => $school[0]->description,
            'school_address' => $school[0]->address,
            'vision' => $school[0]->vision,
            'phone' => $school[0]->phone,
            'email' => $school[0]->email,
            'totalctctamt' => $totalctctamt,
            'totalerntamt' => round(($totalerntamt/$salary[0]->working_days)*$salary[0]->paid_days),
            'totaldedamt' => round(($totaldedamt/$salary[0]->working_days)*$salary[0]->paid_days),
        );
        
        
        echo json_encode($data);

    }


}
