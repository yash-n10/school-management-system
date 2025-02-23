<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Salary_calculator extends CI_Controller {

    public $page_code = 'salary_calculation';
    public $page_id = '';
    public $page_perm = '----';
    
    public function __construct() {
        parent::__construct();
        $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");

        $this->id           = $this->session->userdata('school_id');
        $this->academic_session=array();
        $this->school_desc = $this->dbconnection->select("school", "*", "id=" . $this->id . " and status = 1");
        $this->schools      = $this->dbconnection->select("school", "*", 'status = 1');
        $this->bank         = $this->dbconnection->select("bank", "*");
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
        
        $this->page_title   = 'Salary Calculator';
        $this->section      = 'hr/payroll';
        $this->page_name    = 'salary_calculator';
        $this->customview   = '';
    }

    public function download_receipt()
    {
        $id = $this->uri->segment(5);
        $salary = $this->dbconnection->select("salary_calculation", "*", "id=".$id);

        $fetch_detail = $this->dbconnection->select("employee", "id,name,aadhar_id,category_id,designation_id,bank_id,bank_accnt_no,pf_accnt,esi_accnt,employee_code", "id=" . $salary[0]->emp_id);
        
        $salary_head_id=$salary[0]->sal_head_id;
        
        $earning_sal=$this->dbconnection->select('salary_type', "*,(select amount from salary_entitlement where salary_id=salary_type.id and salary_group_id=$salary_head_id and salary_type.id and status='Y') as sal_amt", "status=1");
        $earning_sal1=$this->dbconnection->select('salary_type', "*,(select amount from salary_entitlement where salary_id=salary_type.id and salary_group_id=$salary_head_id and status='Y') as sal_amt", "status=1");


        $school_id = $this->session->userdata('school_id');
        $school = $this->school_desc;
        $sal_head   = $this->dbconnection->select("salary_group", "*", "id=" . $salary_head_id);
        $array = array('id'=>$id,'fetch_detail'=>$fetch_detail,'earning_sal'=>$earning_sal,'salary'=>$salary,'school'=>$school,'earning_sal1'=>$earning_sal1,'sal_head'=>$sal_head);
        
        $this->load->view('hr/payroll/download_receipt',$array);
        $html = $this->output->get_output();
        $this->load->library('pdf');
        $this->dompdf->load_html($html);
        $this->dompdf->set_paper('A4','portrait');
        $this->dompdf->render();
        ob_end_clean();
        $this->dompdf->stream("Salary_Slip.pdf", array("Attachment" => FALSE));
    }

    public function index($year='',$month='') {
        // error_reporting(E_ALL);
        // ini_set('display_errors',1);
        // $this->db->debug=TRUE;
        
        if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->data['page_name']            = 'calculate_salary_list';
        $this->data['page_title']           = $this->page_title;
        $this->data['section']              = $this->section;
        $this->data['customview']           = $this->customview;
        $this->data['right_access']         = $this->right_access;
        $this->data['year_view']            = $year;
        $this->data['month_view']           = $month;
        $this->data['fin_yr_start'] = date('Y', strtotime($this->academic_session[0]->start_date));
        $this->data['fin_yr_end']   = date('Y', strtotime($this->academic_session[0]->end_date));
        if(($year=='all'||$year=='') && ($month=='all'||$month=='')){
            $this->data['fetch_employee_salary']= $this->dbconnection->select('salary_calculation', "id,emp_id,(select employee_code from employee where status=1 and id=emp_id) as emp_code, (select name from employee where status=1 and id=emp_id) as emp_name, year, month,paid_status,paid_days,working_days,amount_paid", "status=1");
        }else if($year=='all' || $month=='all'){
            $yrmonth=($year=='all')?'month':'year';
            $yrmonthdata=($year=='all')?$month:$year;
            $this->data['fetch_employee_salary']= $this->dbconnection->select('salary_calculation', "id,emp_id,(select employee_code from employee where status=1 and id=emp_id) as emp_code, (select name from employee where status=1 and id=emp_id) as emp_name, year, month,paid_status,paid_days,working_days,amount_paid", "status=1 and $yrmonth='$yrmonthdata'");
        }else{
            $this->data['fetch_employee_salary']= $this->dbconnection->select('salary_calculation', "id,emp_id,(select employee_code from employee where status=1 and id=emp_id) as emp_code, (select name from employee where status=1 and id=emp_id) as emp_name, year, month,paid_status,paid_days,working_days,amount_paid", "status=1 and year='$year' and month='$month'");
        }
        $this->load->view('index', $this->data);
    }

    public function add_sal_calc() {
        
        
        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        
        $this->data['page_name']    = 'salary_calculator';
        $this->data['page_title']   = $this->page_title;
        $this->data['section']      = $this->section;
        $this->data['customview']   = $this->customview;
        $this->data['task']         = 'Save';
        $this->data['title']        = 'Salary Details';
        $this->data['emp_code']     = '';
        $this->data['emp_name']     = '';
        $this->data['aadhar']       = '';
        $this->data['cat']          = '';
        $this->data['design']       = '';
        $this->data['bank']         = '';
        $this->data['accnt']        = '';
        $this->data['pan']          = '';
        $this->data['pf']           = '';
        $this->data['esic']         = '';
        $this->data['ifsc']         = '';
        $this->data['fetch_salary_name'] = $this->dbconnection->select('salary_type', "*", "status=1");
        $this->data['payable']      = '';
        $this->data['gross_pay']    = '';
        $this->data['pf_empl']      = '';
        $this->data['health_empl']  = '';
        $this->data['ctc_mon']      = '';
        $this->data['year']         = '';
        $this->data['fin_yr_start'] = date('Y', strtotime($this->academic_session[0]->start_date));
        $this->data['fin_yr_end']   = date('Y', strtotime($this->academic_session[0]->end_date));
        $this->data['sal_head_id']      = '';
        $this->data['sal_month']    = '';
        $this->data['working_days']    = '';
        $this->data['total_holiday']    = '';
        $this->data['total_leave_approved']    = '';
        $this->data['absent_days']    = '';
        $this->data['paid_days']    = '';
        $this->data['designation']  = $this->dbconnection->select("employee_designation", "id,designation_desc", "status=1");
        $this->data['category'] = $this->dbconnection->select("employee_category", "id,category_desc", "status=1");
        $this->data['emp_details']  = $this->dbconnection->select("employee", "id,employee_code", "status=1");
        $this->data['fetch_bank']   = $this->bank;
        $this->data['sal_calc_id']       = '';


        $this->load->view('index', $this->data);
    }

    public function save() {
        // if (!$this->input->is_ajax_request() || substr($this->right_access, 0, 1) != 'C') {
        //     redirect('404');
        // }
        $data = array(
            'year'          => $this->input->post('year'),
            'emp_id'        => $this->input->post('emp_code'),
            'sal_head_id'   => $this->input->post('sal_head_id'),
            'month'         => $this->input->post('sal_mnth'),
            'amount_paid'   => $this->input->post('sal_paid'),
            'advance'       => $this->input->post('adv'),
            'working_days'       => $this->input->post('wrk_day'),
            'total_holiday'       => $this->input->post('holi_day'),
            'total_leave_approved'       => $this->input->post('leave'),
            'absent_days'       => $this->input->post('leave_exceed'),
            'paid_days'       => $this->input->post('paid_day'),
            'status'       => 1,
            'created_by' => $this->session->userdata('user_id'),
            'academic_year_id'=> $this->academic_session[0]->fin_year,
            'remburse_amt'=> $this->input->post('rembursement'),
            'basic'=>$this->input->post('earning_1'),
            'transport'=>$this->input->post('earning_4'),
            'lic'=>$this->input->post('deduction_6'),
            'tds'=>$this->input->post('deduction_7'),
            'edli'=>$this->input->post('ctchead_11')
        );

        $q=$this->dbconnection->insert('salary_calculation', $data);
     
        $last_id = $this->dbconnection->get_last_id();
        if($q){
                $audit = array("action" => 'Add Salary Calculation',
                "module" => "Payroll Module",
                'datetime' => date("Y-m-d H:i:s"),
                'userid' => $this->session->userdata('user_id'),
                'student_id' => 0,
                'page' => 'add_salary_structure',
                'remarks' => 'Calculation of Salary of EmpID:'.$this->input->post('emp_code').' and of ID:'.$last_id,
            );
            $this->dbconnection->insert("auditntrail", $audit);
        }
       redirect('hr/payroll/Salary_calculator');
    }

    public function edit_sal_calc($sal_calc_id = '',$task='') {
         // error_reporting(-1);
         // ini_set('display_errors', 1);
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->data['page_name']    = 'salary_calculator';
        $this->data['page_title']   = $this->page_title;
        $this->data['section']      = $this->section;
        $this->data['customview']   = $this->customview;

        $emp_salary = $this->dbconnection->select("salary_calculation", "*", "id=$sal_calc_id");
//        print_r($emp_salary);
        $emp_data   = $this->dbconnection->select("employee", "id, name, category_id, pan_no, pf_accnt, esi_accnt, ifsc_code, aadhar_id, employee_code, designation_id, bank_id, bank_accnt_no,salary_group_id", "id=" . $emp_salary[0]->emp_id . " and status=1");
        $sal_head   = $this->dbconnection->select("salary_group", "*", "id=" . $emp_data[0]->salary_group_id);

        if($task=='View') {
            $this->data['task']             = 'View';
        }else{
            $this->data['task']             = 'Update';
        }
        
        $this->data['emp_code']         = $emp_data[0]->id;
        $this->data['emp_name']         = $emp_data[0]->name;
        $this->data['aadhar']           = $emp_data[0]->aadhar_id;
        $this->data['cat']              = $emp_data[0]->category_id;
        $this->data['design']           = $emp_data[0]->designation_id;
        $this->data['bank']             = $emp_data[0]->bank_id;
        $this->data['accnt']            = $emp_data[0]->bank_accnt_no;
        $this->data['pan']              = $emp_data[0]->pan_no;
        $this->data['pf']               = $emp_data[0]->pf_accnt;
        $this->data['esic']             = $emp_data[0]->esi_accnt;
        $this->data['ifsc']             = $emp_data[0]->ifsc_code;
        $this->data['fetch_salary_name']= $this->dbconnection->select('salary_entitlement', "salary_id AS id, amount AS sal_amt, (SELECT salary_typ FROM salary_type WHERE salary_type.id=salary_id and id NOT IN(19,20,21)) AS salary_typ, (SELECT salary_name FROM salary_type WHERE salary_type.id=salary_id) AS salary_name", "status='Y' and salary_group_id=" . $sal_head[0]->id );
        $this->data['payable']          = $emp_salary[0]->amount_paid;
        // $this->data['payable']          = $emp_salary[0]->amount_paid-362;
        
        $gross_salary=round(($sal_head[0]->gross_salary/$emp_salary[0]->working_days)*$emp_salary[0]->paid_days);
        $this->data['gross_pay']        = $gross_salary;
        // $this->data['gross_pay']        = $gross_salary;
        
        $pf_employer=round(($sal_head[0]->pf_employer/$emp_salary[0]->working_days)*$emp_salary[0]->paid_days);
        $this->data['pf_empl']          = $pf_employer;
        $medical_employer=round(($sal_head[0]->medical_employer/$emp_salary[0]->working_days)*$emp_salary[0]->paid_days);
        $this->data['health_empl']      = $medical_employer;
        
        if($emp_data[0]->id==2){
             $ctc_month=round(($sal_head[0]->ctc_month/$emp_salary[0]->working_days)*$emp_salary[0]->paid_days);
        $this->data['ctc_mon']          = $ctc_month;
        // $this->data['ctc_mon']          = $ctc_month+67+15+94+275-16;
    }else{
         $ctc_month=round(($sal_head[0]->ctc_month/$emp_salary[0]->working_days)*$emp_salary[0]->paid_days);
        $this->data['ctc_mon']          = $ctc_month;
    }
        // $ctc_month=round(($sal_head[0]->ctc_month/$emp_salary[0]->working_days)*$emp_salary[0]->paid_days);
        // $this->data['ctc_mon']          = $ctc_month;
        
        $this->data['year']             = $emp_salary[0]->year;
        $this->data['fin_yr_start'] = date('Y', strtotime($this->academic_session[0]->start_date));
        $this->data['fin_yr_end']   = date('Y', strtotime($this->academic_session[0]->end_date));
        $this->data['sal_month']        = $emp_salary[0]->month;
        $this->data['working_days']     = $emp_salary[0]->working_days;
        $this->data['total_holiday']     = $emp_salary[0]->total_holiday;
        $this->data['total_leave_approved']     = $emp_salary[0]->total_leave_approved;
        $this->data['absent_days']     = $emp_salary[0]->absent_days;
        $this->data['paid_days']     = $emp_salary[0]->paid_days;
        $this->data['sal_head_id']          = $sal_head[0]->id;
        $this->data['designation']      = $this->dbconnection->select("employee_designation", "id,designation_desc", "status=1");
        $this->data['category'] = $this->dbconnection->select("employee_category", "id,category_desc", "status=1");
        $this->data['emp_details']      = $this->dbconnection->select("employee", "id,employee_code", "status=1");
        $this->data['fetch_bank']       = $this->bank;
        $this->data['sal_calc_id']       = $sal_calc_id;
        

        $this->load->view('index', $this->data);
    }

    
    
    public function update($sal_calc_id) {
        
    if (!$this->input->is_ajax_request() || substr($this->right_access, 2, 1) != 'U') {
            redirect('404');
        }
        $data = array(
            'year'          => $this->input->post('year'),
            'emp_id'        => $this->input->post('emp_code'),
            'month'         => $this->input->post('sal_mnth'),
            'sal_head_id'         => $this->input->post('sal_head_id'),
            'amount_paid'   => $this->input->post('sal_paid'),
            'advance'       => $this->input->post('adv'),
            'working_days'       => $this->input->post('wrk_day'),
            'total_holiday'       => $this->input->post('holi_day'),
            'total_leave_approved'       => $this->input->post('leave'),
            'absent_days'       => $this->input->post('leave_exceed'),
            'paid_days'       => $this->input->post('paid_day'),
            'status'       => 1,
            'remburse_amt'=> $this->input->post('rembursement'),
        );
        $q=$this->dbconnection->update('salary_calculation', $data,"id=$sal_calc_id");
        
        if($q){
                $audit = array("action" => 'Update Salary Calculation',
                "module" => "Payroll Module",
                'datetime' => date("Y-m-d H:i:s"),
                'userid' => $this->session->userdata('user_id'),
                'student_id' => 0,
                'page' => 'add_salary_structure',
                'remarks' => 'Calculation of Salary of EmpID:'.$this->input->post('emp_code').' and of ID:'.$sal_calc_id,
            );
            $this->dbconnection->insert("auditntrail", $audit);
        }
        
    }
    
    
    public function pay() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }
        
        $payslipno=$this->input->post('sal_month').'-'.$this->input->post('sal_ecode').'-'.$this->input->post('sal_calc_id');
        $data=array(
            'paid_status'=>1,
            'pay_slipno'=>$payslipno,
            'sal_pay_date'=>date('Y-m-d H:i:s'),
        );
        $this->dbconnection->update('salary_calculation', $data,"id=".$this->input->post('sal_calc_id'));
    }
    
    
    public function create_salary1() {
        $this->db->db_debug=TRUE;
         error_reporting(-1);
         ini_set('display_errors', 1);
        $sal_len    = 0;
        $emp_id     = $this->input->post('emp_id');
//        $yr         = $this->input->post('year');
//        $mnth       = $this->input->post('month');

        
        
        $emp_data       = $this->dbconnection->select("employee", "id,name,category_id,salary_group_id,pan_no,pf_accnt,esi_accnt,ifsc_code,aadhar_id,employee_code,designation_id,bank_id,bank_accnt_no", "id=$emp_id and status=1");
         $salary_group_id=$emp_data[0]->salary_group_id;

        $salary_total   = $this->dbconnection->select("salary_group", "*", "status='Y' and id=".$salary_group_id, "id", "DESC", "Y");


        $data['name']   = $emp_data[0]->name;
        $data['cat']    = $emp_data[0]->category_id;
        $data['pan']    = $emp_data[0]->pan_no;
        $data['pf']     = $emp_data[0]->pf_accnt;
        $data['esi']    = $emp_data[0]->esi_accnt;
        $data['aadhar'] = $emp_data[0]->aadhar_id;
        $data['desig']  = $emp_data[0]->designation_id;
        $data['bank']   = $emp_data[0]->bank_id;
        $data['account']= $emp_data[0]->bank_accnt_no;
        $data['ifs']    = $emp_data[0]->ifsc_code;

        if (empty($salary_total)) {
            $data['msg']        = 'No Salary Structure Assigned !';
//            $data['validation'] = '';
        } else {
            // $salary         = $this->dbconnection->select("salary_entitlement", "amount,salary_id,(select salary_typ from salary_type where id=salary_id) as sal_type", "salary_group_id ="$salary_group_id" and status=1");

            $salary=$this->dbconnection->select('salary_type', "*,(select amount from salary_entitlement where salary_id=salary_type.id and salary_id!=11 and salary_id!=13 and salary_group_id={$salary_group_id} and status='Y') as sal_amt ", "status=1");
            // echo '<pre>';
            // print_r($salary);
            // die();
            $ctc_mon=(round($salary_total[0]->ctc_month,2));

            $ctc_ann=(round($salary_total[0]->ctc_month*12,2));

            $data['msg']         = '';
            $data['sal_head_id'] = $salary_total[0]->id;
            $data['pf_empl']     = $salary_total[0]->pf_employer;
            $data['med_empl']    = $salary_total[0]->medical_employer;
            $data['gross1']      = $salary_total[0]->gross_salary;
            $data['net']         = $salary_total[0]->net_payable;
            $data['ctc_mon']     = $ctc_mon;
            $data['ctc_ann']     = $ctc_ann;
            $sal_amt=array();
            $sal_amt1=array();
            foreach ($salary as $sal) {
                // print_r($sal);
                if ($sal->salary_typ == 1) {
                    $samt=(round($sal->sal_amt,2));
                    $sal_amt[$sal->id] = $samt;
                }
                else if ($sal->salary_typ == 2) {
                    $samt=(round($sal->sal_amt,2));
                    $sal_amt1[$sal->id] = $samt;
                }
                else if ($sal->salary_typ == 4) {
                    $samt=(round($sal->sal_amt,2));
                    $sal_amt2[$sal->id] = $samt;
                } else {
                    // $samt=(round($sal->sal_amt,2));
                    // $sal_amt1[$sal->id] = $samt;
                }
            }
            $data['amount']['e']  = $sal_amt;
            $data['amount']['d']  = $sal_amt1;
            $data['amount']['c']  = $sal_amt2;

        }

       

        echo json_encode($data);
    }

    public function find_holiday() {
         //        $this->db->db_debug=TRUE;
         // error_reporting(-1);
         // ini_set('display_errors', 1);
//        $year           = date('Y');
        $year           = $this->input->post('year');
        $month          = $this->input->post('mnth');
        $emp_cod        = $this->input->post('emp_code');
        
        $dup_salary_find=$this->dbconnection->select("salary_calculation","count(id) as cntsal","emp_id=$emp_cod and year=$year and month=$month and status=1");
        if($dup_salary_find[0]->cntsal==0) {
            $msg='';
                $qry_holiday    = $this->dbconnection->select("holiday", "holiday_date_from,holiday_date_to", "status=1 and ((MONTH(holiday_date_from)=$month and YEAR(holiday_date_from)=$year) or (MONTH(holiday_date_to)=$month and YEAR(holiday_date_to)=$year)) ");
                $holidaysum = 0;
                foreach ($qry_holiday as $row) {
        //            echo 'hi';
                    $from       = $row->holiday_date_from;
                    $to         = $row->holiday_date_to;
                    $to_mnth    = date('m', strtotime($row->holiday_date_to));
                    $from_mnth  = date('m', strtotime($row->holiday_date_from));
        //            echo $month.' '.$to_mnth.'<br>';
                    if ($to_mnth == $from_mnth || $to_mnth=='00') {

                        $date1      = new DateTime($from);
                        $date2      = new DateTime($to);
                        if($to!='0000-00-00'){
                            $difference = $date1->diff($date2);
                            $hd2        = ++$difference->d;
                        }else{
                            $hd2        =1;
                        }

                        $holidaysum       += $hd2;
                        $sundays = $this->calculate_sunday($date1, $date2);
                        $holidaysum = $holidaysum-$sundays;
        //                echo $from. 'to'.$to.'<br>';
        //                echo 'same month'.$hd2.' '.$holidaysum;
                    } else if ($month == $from_mnth) {
                        $last_date  = $from;
                        $date       = new DateTime($last_date);
                        $last_dat   = $date->format('Y-m-t');
                        $date1      = new DateTime($from);
                        $date2      = new DateTime($last_dat);
                        $difference = $date1->diff($date2);
                        $hd         = ++$difference->d;      // Holiday from given month
                        $holidaysum       += $hd;
                        $sundays = $this->calculate_sunday($date1, $date2);
                        $holidaysum = $holidaysum-$sundays;
        //                echo 'from month'.$hd.' '.$holidaysum;
                    } else if ($month == $to_mnth) {
                        $till_date  = "$year-$month-01";
                        $date3      = new DateTime($till_date);
                        $date4      = new DateTime($to);
        //                $to_date    = $date3->diff($date4);
                        $hd1        = date('d', strtotime($row->holiday_date_to));
                        $holidaysum       += $hd1;
                        $sundays = $this->calculate_sunday($date3, $date4);
                        $holidaysum = $holidaysum-$sundays;
        //                echo 'to month'.$to.' '.$holidaysum;
                    }
                }

        //-----------------------------------------------leave calculation-----------------------------------------------------//       

                $result = array();
                $leave_in_mnth = 0;
                $tot_extra_leave = 0;
        //            $exceed=0;
                $tot_leave = $this->dbconnection->select("employee_leave", "opening_leave,leave_type_id,balance_leave", "employee_id=$emp_cod");
                foreach ($tot_leave as $l) {
                    $result[$l->leave_type_id] = $l->opening_leave;
                    $bal_leave[$l->leave_type_id] = $l->balance_leave;
        //            $till_mnth_leave[$l->leave_type_id] = $this->balance_leave($emp_cod, $month, $year, $l->leave_type_id);
                    $consumed_leave[$l->leave_type_id] = $this->consumed_leave($emp_cod, $month, $year, $l->leave_type_id,'APPROVED');
                    $leave_in_mnth += $consumed_leave[$l->leave_type_id];
                    $extra_consumed_leave[$l->leave_type_id] = $this->consumed_leave($emp_cod, $month, $year, $l->leave_type_id,'APPROVED:LOP');
                    $tot_extra_leave += $extra_consumed_leave[$l->leave_type_id];
        //               echo $consumed_leave[$l->leave_type_id].'con';
        //               echo $till_mnth_leave[$l->leave_type_id].'mn';
        //               echo $result[$l->leave_type_id].'op';
        //            $extra_leave[$l->leave_type_id] = 0;
        //            if ($till_mnth_leave[$l->leave_type_id] <= $result[$l->leave_type_id]) {
        ////                echo '';
        //            } else {
        //                foreach ($till_mnth_leave as $net => $v) {
        //                    $extra_leave[$l->leave_type_id] = $result[$l->leave_type_id] - $till_mnth_leave[$l->leave_type_id];
        ////                       echo $extra_leave[$l->leave_type_id].'ext';
        //                }
        //            }

        //                echo $excced;
                }

        //        foreach ($extra_leave as $l => $e) {
        //            $tot_extra += $e;
        //        }
        //        if ($tot_extra < 0) {
        //            $r = explode('-', $tot_extra);
        //            $exceed = $r[1];
        //        } else {
        //            $exceed = $tot_extra;
        //        }
        //             return $exceed;


        //        foreach ($consumed_leave as $val => $a) {
        //            $leave_in_mnth += $a;
        //        }
        //           echo $leave_in_mnth;




                /*-------------------------------------- Attendence --------------------------------------------------*/

                    $attendence_query=$this->dbconnection->select("staff_attendance","attendance","emp_no=$emp_cod and attendance='P' and MONTH(date)=$month and YEAR(date)=$year");
                    // print_r($attendence_query);
                    if(empty($attendence_query)){
                        $no_absent=0;
                    }else{
                        $no_absent=count($attendence_query);
                    }
                    $absent_days=abs($no_absent);


                    $attendence_query_abs=$this->dbconnection->select("staff_attendance","attendance","emp_no=$emp_cod and attendance='A' and MONTH(date)=$month and YEAR(date)=$year");
                    // print_r($attendence_query_abs);
                    if(empty($attendence_query_abs)){
                        $tot_absent=0;
                    }else{
                        $tot_absent=count($attendence_query_abs);
                    }
                    $absent_days_tot=abs($tot_absent-$leave_in_mnth);
                    // echo 'abs'.$absent_days=$no_absent-$leave_in_mnth;
                    // $absent_days=4;
                /*----------------------------------------------------------------------------------------------------*/

        } else{
            
            $holidaysum =$leave_in_mnth=$absent_days= 0;
            $msg='Salary Has Been Already Calculated For This Month!';
        }
         $result = array(
            'holiday' => $holidaysum,
            'leave' => $leave_in_mnth,
//            'extra' => $tot_extra_leave,
            'extra' => $absent_days,
            'absent_days' => $absent_days_tot,
            'msg' =>$msg,
        );
        echo json_encode($result);
    }

    public function consumed_leave($emp_cod, $month, $year, $leav_id, $leavetype) {
        
        $qry_leave = $this->dbconnection->select("leave_apply_approve", "from_date,to_date,leave_type_id", "emp_id = $emp_cod and leave_type_id=$leav_id and ((MONTH(from_date)=$month and YEAR(from_date)=$year) or (MONTH(to_date)=$month and YEAR(to_date)=$year)) and leave_status='$leavetype'");
//               print_r($qry_leave);
        $tot_lv = 0;
        $sun_lv = 0;
        $fin_lv = 0;
        $leav[$leav_id] = 0;
        foreach ($qry_leave as $r) {
            $lv_from = $r->from_date;
            $lv_to = $r->to_date;
            $lv_to_mnth = date('m', strtotime($r->to_date));
            $lv_from_mnth = date('m', strtotime($r->from_date));
            $lv_type = $r->leave_type_id;


//            if ($lv_type == $leav_id) {
                if ($lv_to_mnth == $lv_from_mnth || $lv_to_mnth='00') {
                    
                    $date1 = new DateTime($lv_from);
                    $date2 = new DateTime($lv_to);
                    if($lv_to!='0000-00-00'){
                        $difference = $date1->diff($date2);
                        $ld2 = ++$difference->d;
                    }else{
                        $ld2        =1;
                    }

                    $tot_lv += $ld2;
                    $leav[$leav_id] = $tot_lv;
//                    $tot_lv = $leav[$leav_id];
                    $sun_lv = $this->calculate_sunday($date1, $date2);
//                                                echo $sun_lv;
                    $fin_lv = $tot_lv - $sun_lv;
//                                                echo $fin_lv;
                } else if ($month == $lv_from_mnth) {
                    $last_date = $lv_from;
                    $date = new DateTime($last_date);
                    $date->modify('last day of this month');
                    $last_dat = $date->format('Y-m-d');
                    $date1 = new DateTime($lv_from);
                    $date2 = new DateTime($last_dat);
                    $difference = $date1->diff($date2);
                    $ld = ++$difference->d;      // Holiday from given month
                    $tot_lv += $ld;
                    $leav[$leav_id] = $tot_lv;
//                    $tot_lv = $leav[$leav_id];
                    $sun_lv = $this->calculate_sunday($date1, $date2);
                    $fin_lv = $tot_lv - $sun_lv;

//                                                         echo $tot_lv;
                } else if ($month == $lv_to_mnth) {
                    $till_date = $lv_to;
                    $date3 = new DateTime('0000-00-01');
                    $date4 = new DateTime($till_date);
                    $to_date = $date3->diff($date4);
                    $ld1 = ++$to_date->d;
                    $tot_lv += $ld1;
                    $leav[$leav_id] = $tot_lv;
//                    $tot_lv = $leav[$leav_id];
                    $sun_lv = $this->calculate_sunday($date3, $date4);
                    $fin_lv = $tot_lv - $sun_lv;
                }
//            }
        }
        return $fin_lv;
    }

    public function balance_leave($emp_cod, $month, $year, $val) {
        $tot_lev = 0;
        $lv_sun = 0;
        $final_taken = 0;

        $emp_doj = $this->dbconnection->select("employee", "doj", "id=$emp_cod");
        $join_date = date('Y-m-d', strtotime($emp_doj[0]->doj));
        $date = '01' . '-' . $month . '-' . $year;
        $curr_mnth = date('Y-m-t', strtotime($date));
        $qry_cnt_leave = $this->dbconnection->select("leave_apply_approve", "from_date,to_date", "emp_id=$emp_cod and (from_date<='$curr_mnth' or to_date<='$curr_mnth') and leave_type_id=$val");
//         print_r($qry_cnt_leave);   

        foreach ($qry_cnt_leave as $q) {
            $leav[$val] = 0;

            $lev_from = $q->from_date;
            $lev_to = $q->to_date;
            $lev_to_mnth = date('m', strtotime($q->to_date));
            $lev_from_mnth = date('m', strtotime($q->from_date));

            if ($lev_to_mnth == $lev_from_mnth) {
                $date1 = new DateTime($lev_from);
                $date2 = new DateTime($lev_to);
                $difference = $date1->diff($date2);
                $ld2 = ++$difference->d;
                $tot_lev += $ld2;
                $leav[$val] += $tot_lev;
                $tot_lev = $leav[$val];
                $lv_sun = $this->calculate_sunday($date1, $date2);
                $final_taken = $tot_lev - $lv_sun;
            }
//                                            
            else if ($month == $lev_from_mnth) {
                $last_date = $lev_from;
                $date = new DateTime($last_date);
                $date->modify('last day of this month');
                $last_dat = $date->format('Y-m-d');
                $date1 = new DateTime($lev_from);
                $date2 = new DateTime($last_dat);
                $difference = $date1->diff($date2);
                $ld = ++$difference->d;      // Holiday from given month
                $tot_lev += $ld;
                $leav[$val] += $tot_lev;
                $tot_lev = $leav[$val];
                $lv_sun = $this->calculate_sunday($date1, $date2);
                $final_taken = $tot_lev - $lv_sun;
            }
//                    
            else if ($month == $lev_to_mnth) {
                $till_date = $lev_to;
                $date3 = new DateTime($join_date);
                $date4 = new DateTime($till_date);
                $to_date = $date3->diff($date4);
                $ld1 = $to_date->d;
                $tot_lev += $ld1;
                $leav[$val] += $tot_lev;
                $tot_lev = $leav[$val];
                $lv_sun = $this->calculate_sunday($date3, $date4);
                $final_taken = $tot_lev - $lv_sun;
            }
//                                                   
        }

        return $final_taken;
    }

    public function calculate_sunday($date1, $date2) {
        $sunday = array();
        while ($date1 <= $date2) {
            if ($date1->format('w') == 0) {
                $sunday[] = $date1->format('Y-m-d');
            }

            $date1->modify('+1 day');
        }
//                                                print_r($sunday);
        $sun = sizeof($sunday);
        return $sun;
//                                                echo $sun;
    }
    
    
    public function delete() {
        if (!$this->input->is_ajax_request() || substr($this->right_access, 3, 1) != 'D') {
            redirect('404');
        }
        $sal_id_string = $this->input->post('employee_id_string');
        foreach ($sal_id_string as $val) {
            $q=$this->dbconnection->update('salary_calculation', array('status' => 0, 'last_modified_by' => $this->session->userdata('user_id'), 'last_date_modified' => date('Y-m-d H:i:s')), 'id=' . $val);
            
            
            if($q){
                $audit = array("action" => 'Delete Salary Calculation',
                    "module" => "Payroll Module",
                    'datetime' => date("Y-m-d H:i:s"),
                    'userid' => $this->session->userdata('user_id'),
                    'student_id' => 0,
                    'page' => 'calculate_salary_list',
                    'remarks' => 'Deletion of Salary Calculation of ID:'.$val,
                );
                $this->dbconnection->insert("auditntrail", $audit);
            }
            
        }
    }


}
