<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payment_army extends CI_Controller {

    public function __construct() {
    parent::__construct();
        
    // error_reporting(-1);
    //	ini_set('display_errors', 1);
    // $this->db->db_debug=TRUE;
    if ($this->session->userdata('login_type') != 'student' || empty($this->session->userdata('user_id'))) {
        redirect('/login');
    }

    // $this->config->set_item('csrf_protection', TRUE);

        $this->id = $this->session->userdata('school_id');
        $this->school = $this->dbconnection->select('school', '*', 'id = ' . $this->id);
        $this->countries = $this->dbconnection->select('countries', '*', 'id=' . $this->school[0]->country_id);
        $this->state = $this->dbconnection->select('states', '*', 'id=' . $this->school[0]->state_id);
        $this->city = $this->dbconnection->select('cities', '*', 'id=' . $this->school[0]->city_id);

        if ($this->id != 0) {
            $this->db->db_select('crmfeesclub_' . $this->id);
        }

        $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y' and active='Y'");
        $fetch_startyr = isset($this->academic_session[0]->start_date) ? explode('-', $this->academic_session[0]->start_date) : array('0');
        $this->session_start_yr = reset($fetch_startyr);

        $this->qtrset=explode('@',$this->school[0]->month_set);
        $this->qtr=array();
        foreach ($this->qtrset as $key => $value) {
            $set= explode('-', $value);
            foreach ($set as $value1) {
                $this->qtr[$value1]=$key;
            }
        }
        
//        print_r($this->qtr);
        
        $this->page_title = 'Fee Payment';
        $this->section = 'feepayment/gateway';
        $this->page_name = 'pay_army';
        $this->customview = '';

//        $this->token_name = $this->security->get_csrf_token_name();
//        $this->token_hash = $this->security->get_csrf_hash();
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $user = $this->dbconnection->select('user', 'student_id', 'id = ' . $user_id);
        $student_id = $user[0]->student_id;
			//Amit
			// echo "Student ID: " . $student_id . "<br>";
			//AMit

        $student = $this->dbconnection->select('student', 'id,transport_amt,fine_waiver,course_id,'
                . ' class_id,(select class_name from class where id=student.class_id) as class_name,'
                . ' concat(first_name," ",middle_name," ",last_name) as name,first_name,'
                . ' stud_category,student_academicyear_id,'
                . ' (select c.cat_name from category c where c.id=stud_category) as cat_name,'
                . '  section_id,(select s.sec_name from section s where s.id=section_id) as sec_name,'
                . ' email_address, phone,status,date_created, created_by,last_date_modified, last_modified_by,start_fee_month,student_type,student_academicyear_id', 'id = ' . $student_id);

        $student_cat = $student[0]->stud_category;
		$student_class_id = $student[0]->class_id;

        $year = $this->academic_session[0]->fin_year;
        $stud_acedemic_session_id = $student[0]->student_academicyear_id;
        $year = $this->academic_session[0]->fin_year;

        $active_ses_id= $this->dbconnection->select('accedemic_session','*',"id='$stud_acedemic_session_id'");
        $active_=$active_ses_id[0]->active;

        $max_year = $this->dbconnection->select('class_fee_head', 'max(year) as max_year, max(id) as max_id', "(from_class_id<=$student_class_id and to_class_id>=$student_class_id) and course=" . $student[0]->course_id . " and status='Y' and year=".$stud_acedemic_session_id);
//        $fee_session_year = $max_year[0]->max_year;
        $max_class_fee_id = $max_year[0]->max_id;

        $annual_fee = $this->db->query('SELECT fee_amount,'
                . '(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name, (select fee_type from fee_master where id=class_fee_det.fee_id) as fee_type'
                . ',fee_id FROM class_fee_det where fee_cat=1 and stud_cat=' . $student_cat . ' and'
                . ' class_fee_head_id=' . $max_class_fee_id . ' and status=1');

        $onetime_fee = $this->db->query('SELECT fee_amount,'
                . '(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name,fee_cat '
                . 'FROM class_fee_det where fee_cat in (9,10) and stud_cat=' . $student_cat . ' and'
                . ' class_fee_head_id=' . $max_class_fee_id . ' and status=1'); 
        
        $quarterly_fee = $this->db->query('SELECT fee_id,fee_amount,'
                . '(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name '
                . 'FROM class_fee_det where fee_cat=5 and stud_cat=' . $student_cat . ' and'
                . ' class_fee_head_id=' . $max_class_fee_id . ' and status=1');
        
//Amit
// echo $quarterly_fee;
//Amit

        $annual_fee_paid = $this->db->query('SELECT * from fee_transaction_det where fee_trans_head_id in( select id from fee_transaction_head where year=' . $year . ' and student_id=' . $student_id . ' and paid_status=1 and status=1) and fee_cat_id=1');
        $onetime_fee_paid = $this->db->query('SELECT * from fee_transaction_det where fee_trans_head_id in( select id from fee_transaction_head where year=' . $year . ' and student_id=' . $student_id . ' and paid_status=1 and status=1) and fee_cat_id in (9,10)');
        
        $quarterly_fee_paid = $this->db->query('SELECT * from fee_transaction_det where fee_trans_head_id in( select id from fee_transaction_head where year=' . $year . ' and student_id=' . $student_id . ' and paid_status=1 and status=1) and fee_cat_id=5');
//Amit
// echo $quarterly_fee_paid;
//Amit

        
        $other_fee = $this->db->query('SELECT cd.*,cd.fee_amount,fm.fee_name FROM class_fee_det cd inner join fee_master fm on fm.id=cd.fee_id'
                . ' where cd.fee_cat=3 and cd.class_fee_head_id=' . $max_class_fee_id . ' and cd.status=1 and (fm.month_set= "" OR fm.month_set IS NULL) ');


        $fetch_instant_fees_det = $this->dbconnection->select("student_other_fee as fee", "fee.*, (Select fee_name from fee_master where id=fee.fee_id) as fee_desc", "fee.student_id=" . $student_id . " and year=$year and paid_status!=1 and status='Y'");
        
        $transaction_history = $this->db->query("select f1.*,group_concat(distinct(f2.fee_cat_id)) as fee,count(case when f2.month_no<>0 and f2.fee_cat_id in (2,5) then f2.month_no end) as m,min(case when f2.month_no<>0 and f2.fee_cat_id in (2,5) then f2.month_no end) as from_month,max(f2.due_month_no) as d from fee_transaction_head f1, fee_transaction_det f2 where f1.student_id=$student_id and f1.year=$year and status=1 and f1.response_message is not NULL and f1.id=f2.fee_trans_head_id group by f1.id order by f1.payment_date desc");


        $paid_mon_query = $this->dbconnection->select('fee_transaction_det', 'count(month_no) as paid', 'fee_trans_head_id in( select id from fee_transaction_head where student_id=' . $student_id . ' and paid_status=1 and status=1 and response_code=0  and year=' . $year . ') and fee_cat_id=5');
        $total_qtrm_paid = $paid_mon_query[0]->paid + ($student[0]->start_fee_month-1);
        
        
        list($year, $month, $day) = explode('-', date('Y-m-d'));
        //$month=10;
        $current_month = $month;
        
        $pais_status = array();
        $paid_month_array = array();
        $checked_status = array();
        $chkcount = $student[0]->start_fee_month-1;

        for ($pm = $student[0]->start_fee_month; $pm <= $total_qtrm_paid; $pm++) {
            $paid_month_array[] = $pm;
            $pais_status[$pm] = 'checked disabled';
            $checked_status[$pm] = 'disabled';
            $chkcount++;
        }

        $lastfeemonth = $this->dbconnection->Get_namme("class", "id", "$student_class_id", "last_monthlyfeepay_month");
        $lastfeemonth = isset($lastfeemonth) ? $lastfeemonth : 12;
        // print_r($month);die();
        if ($month >= 1 && $month <= 3) {
            $month = $month + 12;
        }
		

        $newmonth = $month - 3;
        if ($lastfeemonth == $newmonth)
			$newmonth = $newmonth + (12 - $newmonth);
		

        $oth_fee_id = array();
        $oth_fee_amount = array();
        
                
        $qtrpaid=array();$count = 0;$acount = 0;
        for ($i = $total_qtrm_paid + 1; $i <= 12; $i++) {
            if ($i <= $newmonth || $this->qtr[$i]==$this->qtr[$newmonth]) {
//THIS IS DONE BY YASH TO REMOVE AUTOCHECK FROM MONTHS
                $checked_status[$i] = 'checked';

                // $checked_status[$i] = 'checked';
                $qtrpaid[$i]=$this->qtr[$i];
                if($i <= $newmonth){
                    $acount++;
                }
                $count++;
                $chkcount++;
                $othquery = $this->db->query("SELECT id,fee_name,month_set,(SELECT fee_amount FROM class_fee_det where fee_cat=3 and stud_cat=0 and class_fee_head_id=$max_class_fee_id and status=1 and fee_id=fee_master.id) fee_amount FROM `fee_master` WHERE fee_cat_id=3 and FIND_IN_SET('$i', month_set) and status=1 group by id")->result();
                foreach ($othquery as $valueo) {
                    $oth_fee_id[$valueo->id] = $valueo->fee_name . ' ';
                    if (array_key_exists($valueo->id, $oth_fee_amount)) {
                        $o = $oth_fee_amount[$valueo->id] + $valueo->fee_amount;
                    } else {
                        $o = $valueo->fee_amount;
                    }

                    $oth_fee_amount[$valueo->id] = $o;
                }

            } else {
                $checked_status[$i] = '';
            }
        }
        for ($st = ($chkcount + 2); $st <= 12; $st++) {
            $checked_status[$st] = 'disabled';
        }



        // print_r($this->qtr);
        $disable_trans = 0;
        $fine_amount = 0;
        $fine_apply_status = 0;
        $fineacmonth = 0;
        // print_r($acount);echo "<br>";print_r($newmonth);echo"<br>";print_r($month);die();
        // print_r($this->qtr);die();
        $fine_rule_duemonth= $due_month = $acount - ($newmonth - $month + 4) ;
        if((($this->qtr['1']==0)&&($this->qtr['2']==0)&&($this->qtr['3']==0))&&(($this->qtr['4']==1)&&($this->qtr['5']==1)&&($this->qtr['6']==1))&&($fine_rule_duemonth>3))
        {
           	
        // print_r("string");die();
            $fine_apply_status=1;
            $fine_amount=850;
        	
        }

        // else if((($this->qtr['1']==0)&&($this->qtr['2']==0)&&($this->qtr['3']==0)))
        // {
        //     $fine_apply_status=='';
        //     $fine_amount='';
        // }
        else
        {
            $fine_rule = $this->dbconnection->select("fine_rule", "count(id) cnt,max(due_month) mdue_month");
            $fine_rule_fetch = array();
            if ($fine_rule[0]->cnt != 0) {
                if ($fine_rule[0]->mdue_month < $due_month) {            
                    $fine_rule_duemonth=$fine_rule[0]->mdue_month;
                    $fine_rule_fetch = $this->dbconnection->select_join("fine_rule fr", "fr.id,fr.from_day,fr.to_day,fr.due_month,cf.fee_amount,cf.fine_rule_id", "fr.due_month=$fine_rule_duemonth and fr.from_day<=$day "
                        . "and fr.to_day>=$day and cf.fee_cat=0 and cf.class_fee_head_id=$max_class_fee_id and cf.status=1 and cf.stud_cat=0","class_fee_det cf","fr.id=cf.fine_rule_id","inner");            
                    if ($day > $this->school[0]->last_pay_date)
                        $fineacmonth = $due_month + 1;
                }else{
                    $fine_rule_fetch = $this->dbconnection->select_join("fine_rule fr", "fr.id,fr.from_day,fr.to_day,fr.max_day,fr.due_month,cf.fee_amount,cf.fine_rule_id", "fr.due_month=$fine_rule_duemonth and fr.from_day<=$day "
                        . "and fr.to_day>=$day and cf.fee_cat=0 and cf.class_fee_head_id=$max_class_fee_id and cf.status=1 and cf.stud_cat=0","class_fee_det cf","fr.id=cf.fine_rule_id","inner"); 
                    $fineacmonth=!empty($fine_rule_fetch) ? $fine_rule_fetch[0]->max_day : $due_month;
                }
                
            
                if (!empty($fine_rule_fetch)) {
                    $fine_amount=$fine_rule_fetch[0]->fee_amount;
                    
                            
                }
            }
            $start_date = '';
            if (!empty($this->school[0]->start_pay_date) && $student[0]->fine_waiver != 'YES') {//only if fine is applicable
                if ($day < $this->school[0]->start_pay_date || $day > $this->school[0]->last_pay_date) {

                    if ($this->school[0]->transc_freeze_status == 1) {
                        $disable_trans = 1;
                    }
                    if (!empty($fine_rule_fetch)) {
                        $fine_apply_status = 1;
                    }


                    if ($day < $this->school[0]->start_pay_date) {

                        $start_date = $this->school[0]->start_pay_date . '-' . $current_month . '-' . $year;
                    } else {

                        $m = $current_month + 1;
                        if ($current_month == 12) {
                            $m = 1;
                            $year = $year + 1;
                        }
                        $start_date = $this->school[0]->start_pay_date . '-' . $m . '-' . $year;
                    }
                } else {

                    if (!empty($fine_rule_fetch)) {
                        $fine_apply_status = 1;
                    }
                    $start_date = '';
                }

                
            } 
            else if (!empty($this->school[0]->start_pay_date) && $student[0]->fine_waiver == 'YES') {
                if (($day < $this->school[0]->start_pay_date || $day > $this->school[0]->last_pay_date) && $this->school[0]->transc_freeze_status == 1){
                   
                        $disable_trans = 1;
                  
                }
            }
        }

        
//Amit
// echo "line 270";
//Amit
        
        
//        if($student_id==2) {
//            echo $fine_apply_status;
//            die();
//        }
        
//        if ($fine_apply_status == 1) {
//                $fine_amount=$fine_rule_fetch[0]->fee_amount;
//        }
        /* -----------  --------------------- */

        $school = $this->school;
        
        $data = array(
            'school_name' => $school[0]->description,
            'school_address' => $school[0]->address,
            'checked_status' => $checked_status,
            'count' => $count,
            'pais_status' => $pais_status,
            'annual_fee' => $annual_fee,
            'onetime_fee' => $onetime_fee,
            'quarterly_fee' => $quarterly_fee,
            'other_fee' => $other_fee,
            'annual_fee_paid' => $annual_fee_paid,
            'onetime_fee_paid' => $onetime_fee_paid,
            'quarterly_fee_paid' => $quarterly_fee_paid,
            'page' => 'student',
            'fee_type1' => $school[0]->fee_type1,
            'fee_type2' => $school[0]->fee_type2,
            'student' => $student,
            'school' => $school,
            'academic_session' => $this->academic_session,
            'msg1' => '',
            'msg2' => '',
            'student_id' => $student_id,
            'fine_amount' => $fine_amount,
            'disable_trans' => $disable_trans,
            'fine_apply_status' => $fine_apply_status,
            'start_pay_date' => $start_date,
            'due_month' => $due_month,
            'fineacmonth' => $fineacmonth,
            'fetch_instant_fees_det' => $fetch_instant_fees_det,
            'transaction_history' => $transaction_history,
            'lastmonthlyfeemonth' => $lastfeemonth,
            'oth_fee_id' => $oth_fee_id,
            'oth_fee_amount' => $oth_fee_amount,
            'qtrs' => $this->qtr,
            'qtrsetcount'=>array_count_values($this->qtr),
            'qtrset' => $this->qtrset,
            'qtrpaid' => array_unique($qtrpaid),
            'start_fee_month' => $student[0]->start_fee_month,
            'page_name' => $this->page_name,
            'page_title' => $this->page_title,
            'section' => $this->section,
            'customview' => $this->customview,
        );
        // print_r($data['checked_status']);die();
        $this->load->view('index', $data);
    }

    public function request() {
//Amit
// echo "request";
//Amit
        $final_total = 0;
        list($current_year, $month, $day) = explode('-', date('Y-m-d'));
        $school_id = $this->session->userdata('school_id');
        $user = $this->dbconnection->select('user', '*', 'id = ' . $this->session->userdata('user_id'));
        $student = $this->dbconnection->select('student', 'id,reference_no,first_name, middle_name, last_name, stud_category,admission_no,'
                . ' (select c.cat_name from category c where c.id=stud_category) as cat_name,'
                . ' class_id,(select cl.class_name from class cl where cl.id=class_id) as class_name,'
                . ' section_id,(select s.sec_name from section s where s.id=section_id) as sec_name,'
                . ' course_id,email_address, phone,status, date_created, created_by, last_date_modified, last_modified_by,start_fee_month,student_type', 'id = ' . $user[0]->student_id);

        $student_id = $user[0]->student_id;
        $class_name = $student[0]->class_name;
        $student_class_id = $student[0]->class_id;
        $start_fee_month=$student[0]->start_fee_month;
        $user_id = $this->session->userdata('user_id');
        $student_cat = $student[0]->stud_category;

        if ($student[0]->email_address == '') 
        {
            $email = 'abc@gmail.com';
        } 
        else 
        {
            $email = $student[0]->email_address;
        }

        $school         = $this->school;
        $countries      = $this->countries;
        $country_code   = $countries[0]->country_code;
        $state          = $this->state;
        $state_code     = $state[0]->state_code;
        $city           = $this->city;
        $city_code      = $city[0]->city_code;
        $admission_no   = $student[0]->admission_no;
        $school_code    = $school[0]->school_code;
        $class_code     = $class_name;


        $max_sesion_id = $this->academic_session[0]->fin_year;
        $year_class = $this->dbconnection->select('class_fee_head', 'max(year) as year, max(id) as max_id', "(from_class_id <=$student_class_id and  to_class_id >=$student_class_id) and course=" . $student[0]->course_id . " and status='Y' and year<=$this->session_start_yr");
        $class_fee_head_year = $year_class[0]->year;
        $max_class_fee_id = $year_class[0]->max_id;

        $monthly_fee_paid = $this->db->query('SELECT * from fee_transaction_det where fee_trans_head_id in( select id from fee_transaction_head where year=' . $max_sesion_id . ' and student_id=' . $student_id . ' and paid_status=1 and status=1) and fee_cat_id=5');
        $class_fee_head_id = $max_class_fee_id;

        $fee_details = $this->db->query("SELECT sum(if(fee_cat=1,fee_amount,0)) annual, sum(if(fee_cat=5,fee_amount,0)) monthly, sum(if(fee_cat=9 or fee_cat=10,fee_amount,0)) onetime FROM class_fee_det WHERE class_fee_head_id=$class_fee_head_id and stud_cat=$student_cat and status=1");
        $fee_details = $fee_details->result();

        $months = $this->input->post('month');
        $i = 1;
        $init_mont = 0;
        $fin_mont = 0;

        if (count($months) > 0) {
            foreach ($months as $key => $value) {
                if ($i == 1) {
                    $init_mont = $value;
                    $fin_mont = $value;
                } elseif (count($months) == $i) {
                    $fin_mont = $value;
                }
                $i++;
            }
        }
        $month_id = $this->input->post('month');

        $total_paid_month = count($monthly_fee_paid->result())+($student[0]->start_fee_month-1);
        $total_check_month = count($month_id);
        $total_pay_month = $total_check_month - $total_paid_month;


        $fine_amount = 0;
        $oth_amount = 0;
        $instantfee_amount = 0;
        $fine_duemonth = 0;
        $cnt_other = 0;
        $annual_last_month_amount = 0;
        if (isset($_POST['total1'])) 
        { 
            $year_val = 0;
            $fee_cat_id = 5;
            $month_no = ($fin_mont - $init_mont) + 1;
            $fine_amount = !empty($this->input->post('fine_amt')) ? $this->input->post('fine_amt') : 0;
            $fine_duemonth = !empty($this->input->post('fine_due_month')) ? $this->input->post('fine_due_month') : 0;
            
            $annual_last_month_amount = !empty($this->input->post('annual_last_fee_amt')) ? $this->input->post('annual_last_fee_amt') : 0;
            $onetime_amount = !empty($this->input->post('onetime_fee_amt')) ? $this->input->post('onetime_fee_amt') : 0;
            $final_total = round($this->input->post('total_m')); //total in month box
            $monthfeeamt = round(($fee_details[0]->monthly/3) * $month_no);
            
            if ($annual_last_month_amount != 0) 
            {               
               $monthfeeamt = $monthfeeamt + ($fee_details[0]->annual-$this->input->post('annual_total_refunded'));
            }
            if ($onetime_amount != 0) 
            {
               $monthfeeamt = $monthfeeamt + $fee_details[0]->onetime;
            }
            if (!empty($this->input->post('oth_fee'))) 
            {
               $oth_amount = $oth_amount + array_sum($this->input->post('oth_fee'));
            }

            if (!empty($this->input->post('instantfee_chk'))) 
            {
                foreach ($this->input->post('instantfee_chk') as $k1 => $instselected) 
                {
                    foreach ($instselected as $k2 => $v2) 
                    {
                        $instantfee_amount = $instantfee_amount + $v2;
                    }
                }
            }
            // echo $monthfeeamt;
            // echo '-----------';
            // echo $final_total;
            //  die();
            if ($final_total != ($monthfeeamt + $fine_amount + $oth_amount + $instantfee_amount)) {

                $this->session->set_flashdata('redirectmsg', 'Sorry you cant proceed to Payment as Invalid Amount tried to send.');
                redirect(base_url('payment_army'));
                die();
            }
        }
       

        if (isset($_POST['total2'])) 
        {  //annual fee pop up button's id
            $year_val = $current_year;
            $fee_cat_id = 1;
            $month_no = 0;
            $final_total = $this->input->post('total_y1'); //total in annual box 
            $refundrecpt= !empty($this->input->post('total_r'))?$this->input->post('total_r'):0;
            $annualfeeamt = $fee_details[0]->annual;
            
            if ($student[0]->start_fee_month != 1) {
                $refunded = $annualfeeamt / 12;
                $total_refunded = $refunded * ($student[0]->start_fee_month - 1);
                
            } else {
                $total_refunded = 0;
            }
            
            if ($annualfeeamt-$total_refunded != $final_total-$refundrecpt) {
                $this->session->set_flashdata('redirectmsg', 'Sorry you cant proceed to Payment as Invalid Amount tried to send.');
                redirect(base_url('payment_army'));
            }
            $final_total=$final_total-$refundrecpt;
        }

        if (isset($_POST['total4'])) 
        {   //otherfee
            $year_val = 0;
            $fee_cat_id = 3;
            $month_no = 0;
            $final_total = $this->input->post('total_other');
            $otherfee = $this->input->post('other_amt');
        }

        if (isset($_POST['total5'])) 
        {  //instant
            $year_val = 0;
            $fee_cat_id = 8;
            $month_no = 0;
            $final_total = $this->input->post('total_instant');
            //$instantfee = $this->input->post('instant_amt');
        }
        
        if (isset($_POST['total6'])) 
        {   //onetime
            $year_val = 0;
            $fee_cat_id = 9;
            $month_no = 0;
            $final_total = $this->input->post('total_o');
            //$instantfee = $this->input->post('instant_amt');
        }

			// //Amit
			// echo $final_total;
			// //AMit

        if ($final_total == 0 || empty($fee_cat_id)) 
        {
            $this->session->set_flashdata('redirectmsg', 'Sorry you cant Proceed to Payment as Amount is Zero Or Something Suspicious happen');
            redirect(base_url('payment_army'));
        } 
        else 
        {
            /* ---------- Saving Details to Fee Payment record table(fee_transaction_head)  --------- */

            $this->dbconnection->insert("fee_transaction_head", array('student_id' => $student_id, 'request_status' => 1, 'year' => $max_sesion_id,'total_amount' => $final_total, 'paid_by' => $this->session->userdata('user_id'), 'payment_date' => date('Y-m-d H:i:s'), 'date_created' => date('Y-m-d H:i:s'),'remarks' => 'Sent to payment gateway', 'mode' => 'FCLB', 'collection_centre' => 'FCLB', 'req_ipaddr_str' => $_SERVER['REMOTE_ADDR']));

            $fee_transac_id = $this->dbconnection->get_last_id();
            
            /* --------------------------------------------------------------------------------------- */

            $month_arr = array(1 => "April", 2 => "May", 3 => "June", 4 => "July", 5 => "Aug", 6 => "Sep", 7 => "Oct", 8 => "Nov", 9 => "Dec", 10 => "Jan", 11 => "Feb", 12 => "Mar");


            /* ---------- Saving Details to Fee Payment Details table(fee_transaction_det)  --------- */
            if ($fee_cat_id == 5) 
            { //quarterly
                $amount = ($final_total - $fine_amount - $annual_last_month_amount - $onetime_amount - $oth_amount - $instantfee_amount) / $month_no;

                for ($m = $init_mont; $m <= $fin_mont; $m++) 
                {
                    $this->save_transaction_details($class_fee_head_id, $student_cat, $amount, $m, $month_arr[$m].'-QTR-'.$this->qtr[$m], 0, NULL, $fee_cat_id, $fee_transac_id, $user_id);
                }

			    
                /*$quarterly_fee = $this->db->query('SELECT fee_id,fee_amount,(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name FROM class_fee_det where fee_cat=5 and stud_cat=' . $student_cat . '  and class_fee_head_id='. $max_class_fee_id .' and status=1');  

        		$qtr_id = $this->qtr[$m];
				$total_check_qtr = count($qtr_id);

				foreach ($quarterly_fee->result() as $obj) 
				{
		            if($start_fee_month!=1 && in_array($this->qtr[$start_fee_month-1], $qtr_id) ) 
                    {
		                $subtractqtr=($obj->fee_amount/3)*($start_fee_month-1);
		            }
                    else
                    {
		                $subtractqtr=0;
		            }
		            $user_ids 	= $user_id;
		            $head_id 	= $fee_transac_id;
		            $curramt	= max(($obj->fee_amount * $total_pay_qtr)-$subtractqtr,0);
		            $fees_id 	= $obj->fee_id;
		            $amts    	= $curramt;

		            $array = array(
		            	'fee_trans_head_id' => $head_id,
						'student_id' => $user_ids,
						'fee_id' => $fees_id,
						'amount' => $amts,
		            );
		            
		            $this->dbconnection->insert("fees_payment_detail", $array);
				}*/
                

                if (!empty($this->input->post('instantfee_chk'))) 
                {
                    foreach ($this->input->post('instantfee_chk') as $k1 => $instselected) 
                    {
                        foreach ($instselected as $k2 => $v2) 
                        {
                            $this->save_transaction_details($class_fee_head_id, $student_cat, $v2, 0, '', 0, $k2, 8, $fee_transac_id, $user_id);
                        }
                    }
                }

                /* ----- fine details saved ---- */
                if ($fine_amount != 0) 
                {
                    $last_due_month = $init_mont + ($fine_duemonth - 1);
                    $month_desc = "$month_arr[$init_mont] to $month_arr[$last_due_month]";
                    $this->save_transaction_details($class_fee_head_id, $student_cat, $fine_amount, 0, $month_desc, $fine_duemonth, NULL, 0, $fee_transac_id, $user_id);
                }

                if ($annual_last_month_amount != 0) 
                {
                    $this->save_transaction_details($class_fee_head_id, $student_cat, $annual_last_month_amount, 0, '', 0, NULL, 1, $fee_transac_id, $user_id);
                }
                
                if ($onetime_amount != 0) 
                {
                    $this->save_transaction_details($class_fee_head_id, $student_cat, $this->input->post('categorylist[1]'), 0, '', 0, NULL, 9, $fee_transac_id, $user_id);
                    if(!empty($this->input->post('categorylist[2]'))) 
                    {
                        $this->save_transaction_details($class_fee_head_id, $student_cat, $this->input->post('categorylist[2]'), 0, '', 0, NULL, 10, $fee_transac_id, $user_id);
                    }
                }


                if (!empty($this->input->post('oth_fee'))) 
                {
                    foreach ($this->input->post('oth_fee') as $keyo => $valueo) 
                    {
                        $this->save_transaction_details($class_fee_head_id, $student_cat, $valueo, 0, '', 0, $keyo, 3, $fee_transac_id, $user_id);
                        $cnt_other++;
                    }
                }






            } 

            else if ($fee_cat_id == 1) 
            {//annual
                $this->save_transaction_details($class_fee_head_id, $student_cat, $final_total, 0, '', 0, NULL, $fee_cat_id, $fee_transac_id, $user_id);
            } 

            else if ($fee_cat_id == 9) 
            {//onetime
            
                $this->save_transaction_details($class_fee_head_id, $student_cat, $this->input->post('categorylist[1]'), 0, '', 0, NULL, $fee_cat_id, $fee_transac_id, $user_id);
                if(!empty($this->input->post('categorylist[2]'))) {
                    $this->save_transaction_details($class_fee_head_id, $student_cat, $this->input->post('categorylist[2]'), 0, '', 0, NULL, 10, $fee_transac_id, $user_id);
                }
            }

            else if ($fee_cat_id == 3) 
            {//other fees
                foreach ($otherfee as $key => $value) {
                    $this->save_transaction_details($class_fee_head_id, $student_cat, $value, 0, '', 0, $key, $fee_cat_id, $fee_transac_id, $user_id);
                    $cnt_other++;
                }
            } 
            else if ($fee_cat_id == 8) 
            {//instant fees
                foreach ($this->input->post('instant') as $k1 => $instselected) {
                    $a2 = $this->input->post('instant_amt')[$instselected];
                    $k2 = $this->input->post('instant_feeid')[$instselected];

                    $this->save_transaction_details($class_fee_head_id, $student_cat, $a2, 0, '', 0, $k2, 8, $fee_transac_id, $user_id);

                }
            } 

            /* --------------------------------------------------------------------------------------- */




            $refrence_no = "$school_code-$admission_no-$fee_transac_id";

            $payment_gateway = !empty($school[0]->payment_gateway) ? $school[0]->payment_gateway : 'nogateway';

            $description = "FeesClub Total $final_total - AdmissionN0 $admission_no - Student ID $student_id "
                    . "- Class $class_code - from_month $init_mont - to_month  $fin_mont - with_fine  $fine_amount - year  $year_val - other_fees  $cnt_other - half_yearly  $cnt_other of session $max_sesion_id";


            /* ---------- Saving Details to Fee Payment Action table(fee_transaction_action)  --------- */
            $this->dbconnection->insert("fee_transaction_action", array('fee_transaction_head_id' => $fee_transac_id, 'action_description' => 'Sent to payment gateway',
                'created_by' => $this->session->userdata('user_id'), 'full_pymt_description' => $description));
            $fee_action_id = $this->dbconnection->get_last_id();
            /* --------------------------------------------------------------------------------------- */

            $data = array(
                'description' => $description,
                'return_url' => base_url() . "payment_army/respond?transac_id=$fee_transac_id&total=$final_total&school_id=$school_id&pgw=$payment_gateway&max_sesion_id=$max_sesion_id&fee_action_id=$fee_action_id",
                'final_total' => $final_total,
                'email' => $email,
                'name' => $student[0]->first_name . ' ' . $student[0]->middle_name . ' ' . $student[0]->last_name,
                'refrence_no_order_id' => $refrence_no,
                'MID' => $school[0]->pgw_mid,
                'EncKey' => $school[0]->pgw_enckey,
                'AccessCode' => $school[0]->pgw_access_code,
                'Live_Test' => $school[0]->test_live_mode,
                'Payment_gateway' => $payment_gateway,
                'fee_transac_id' => $fee_transac_id,
                'school_id' => $school_id,
                'pgw' => $payment_gateway,
                'max_sesion_id' => $max_sesion_id,
                'student_id' => $student_id,
                'fee_action_id' => $fee_action_id,
            );

            $audit = array("action" => 'PAYMENT REQUEST',
                "module" => $this->page_title,
                "page" => basename(__FILE__, '.php'),
                'datetime' => date("Y-m-d H:i:s"),
                'userid' => $this->session->userdata('user_id'),
                'remarks' => 'ID:' . $fee_transac_id,
                'ip_address' => $_SERVER['REMOTE_ADDR'],
            );
            $this->dbconnection->insert("auditntrail", $audit);

            switch ($payment_gateway) {
                case 'WORLDLINE':
//                    if($school_code=='MTBS')
//                    {
//                       $school_code='CPS'; 
//                    }
                    $amtfinal = $final_total * 100;
                    $data['product_code'] = "$school_code^$amtfinal";

                    $this->Worldline_payment_gateway($data);
                    break;
                case 'CCAVENUE':
                    $this->hdfc_ccavenue_gateway($data);
                    break;
                default:
                    $this->hdfc_payment_gateway($data);
                    break;
            }
        }
    }


    public function save_transaction_details($class_fee_head_id, $student_cat, $amount, $month_no, $month_desc, $due_month_no, $other_fee_id, $fee_cat_id, $fee_transac_id, $user_id, $hal_fee_id = 0) {
// //Amit
// echo "save_transaction_details";
// // Amit
        $data_grid = array(
            'class_fee_head_id' => $class_fee_head_id,
            'stud_category' => $student_cat,
            'amount' => $amount,
            'month_no' => $month_no,
            'month_desc' => $month_desc,
            'due_month_no' => $due_month_no,
            'other_fee_id' => $other_fee_id,
            'fee_cat_id' => $fee_cat_id,
            'fee_trans_head_id' => $fee_transac_id,
            'halfyearly_fee_id' => $hal_fee_id,
            'created_by' => $user_id,
        );
        $this->dbconnection->insert("fee_transaction_det", $data_grid);
    }

    public function Worldline_payment_gateway($data) {
        $this->load->view('feepayment/gateway/WL_Pay_page', $data);
    }

    public function hdfc_payment_gateway($data) {
        $this->load->view('feepayment/gateway/hdfc_payment_page', $data);
    }

    public function hdfc_ccavenue_gateway($data) {
        $this->load->view('feepayment/gateway/hdfc_ccavenue_payment_page', $data);
    }

    public function wordline_success($response_var) {
        $data = array('response_var' => $response_var);
    }

    public function respond() {
//            print_r($_GET);
//            print_r($_POST);

        $ERROR = '';
        $insert_to_db = 'NO';
        list($current_year, $month, $day) = explode('-', date('Y-m-d'));
        $maxn = '';
        $inputall = $this->input->post();
        $total = $this->input->get('total');

        $school_id = $this->id;
        $session_id = $this->academic_session[0]->fin_year;
        $payment_gateway = !empty($this->school[0]->payment_gateway) ? $this->school[0]->payment_gateway : 'HDFC';


        if ($payment_gateway == 'WORLDLINE') {  // WORLDLINE ............
            include ($_SERVER['DOCUMENT_ROOT'] . '/assets/gateway/AWLMEAPI.php');
            $obj = new AWLMEAPI();
            $resMsgDTO = new ResMsgDTO();
            $reqMsgDTO = new ReqMsgDTO();
            $enc_key = !empty($this->school[0]->pgw_enckey) ? $this->school[0]->pgw_enckey : '48b3ea074f36178c4f59c10bfd9c4416';
            $responseMerchant = $_REQUEST['merchantResponse'];
            $response = $obj->parseTrnResMsg($responseMerchant, $enc_key);
//                        print_r($response);
            if ($response->getStatusCode() == 'S') {
                $responseCode = 0;
            } else {
                $responseCode = 2;
            }

            $trans_id = $this->input->get('transac_id');
            $trans_cnt_query = $this->dbconnection->select('fee_transaction_head', 'count(id) as cnt', "id=$trans_id and (response_code=0 or response_code=2) and status=1");
            $requestfee_action_id = $this->input->get('fee_action_id');

            $response_var = array('txnRefNo' => $response->getPgMeTrnRefNo(),
                'payment_id' => $response->getPgMeTrnRefNo(),
                'orderId' => $response->getOrderId(),
                'amount' => $response->getTrnAmt(),
                'statusCode' => $response->getStatusCode(),
                'statusDesc' => $response->getStatusDesc(),
                'txnReqDate' => $response->getTrnReqDate(),
                'responseCode' => $responseCode,
                'payment_method' => $response->getAddField9(),
                'txnRemarks' => '',
                'full_pgw_response_json' => json_encode((array) $response),
                'doubleresponse' => $trans_cnt_query[0]->cnt,
            );
//                         print_r($response_var);
            $success_page = 'feepayment/gateway/WL_Success_page';
            $PaymentMethod = $response_var['payment_method'];
            $PaymentMode = $response_var['payment_method'];
            $Remarks = $this->dbconnection->Get_namme('fee_transaction_action', 'id', "$requestfee_action_id", 'full_pymt_description');

            if ($response_var['orderId'] != NULL && $response_var['orderId'] != '' && $trans_cnt_query[0]->cnt == 0) {
                $insert_to_db = 'YES';
            } else {
                $ERROR .= 'Invalid Access Or Time Out Or Double Response Received!';
            }

            $response_var['ERROR'] = $ERROR;
            $this->db->db_select('crmfeesclub');
        } elseif ($payment_gateway == 'CCAVENUE') { // CCAVENUE...........
            include ($_SERVER['DOCUMENT_ROOT'] . '/assets/gateway/Crypto.php');
            $workingKey = !empty($this->school[0]->pgw_enckey) ? $this->school[0]->pgw_enckey : '3F5E6C3F9219D7489C617C2924F18929';  //Working Key should be provided here.
            $encResponse = $inputall["encResp"];   //This is the response sent by the CCAvenue Server
            $rcvdString = decrypt($encResponse, $workingKey);  //Crypto Decryption used as per the specified working key.
            $order_status = "";
            $decryptValues = explode('&', $rcvdString);
            $dataSize = sizeof($decryptValues);
            $response = array();

            for ($i = 0; $i < $dataSize; $i++) {
                $information = explode('=', $decryptValues[$i]);
                $response[$information[0]] = $information[1];
            }

//                    $school_id = $response['merchant_param1'];
            $trans_id = $response['merchant_param1'];
            $trans_cnt_query = $this->dbconnection->select('fee_transaction_head', 'count(id) as cnt', "id=$trans_id and (response_code=0 or response_code=2) and status=1");
            $requestfee_action_id = $response['merchant_param2'];

            if ($response['order_status'] === "Success") {
                $responseCode = 0;
                $statusCode = 'S';
            } else {
                $responseCode = 2;
                $statusCode = 'F';
            }

            $response_var = array(
                'txnRefNo' => $response['tracking_id'],
                'payment_id' => $response['tracking_id'],
                'orderId' => $response['order_id'],
                'amount' => round($response['amount'], 0),
                'statusCode' => $statusCode,
                'statusDesc' => $response['order_status'],
                'txnReqDate' => date('Y-m-d H:i:s', strtotime(str_replace("/", "-", "{$response['trans_date']}"))),
                'responseCode' => $responseCode,
                'payment_method' => $response['payment_mode'],
                'txnRemarks' => '',
                'full_pgw_response_json' => json_encode($response),
                'doubleresponse' => $trans_cnt_query[0]->cnt,
            );

            $success_page = 'feepayment/gateway/hdfc_ccavenue_success_page';
            $PaymentMethod = $response['payment_mode'];
            if ($PaymentMethod == 'Debit Card') {
                $PaymentMode = 'DC';
            } else if ($PaymentMethod == 'Credit Card') {
                $PaymentMode = 'CC';
            } else if ($PaymentMethod == 'Net Banking') {
                $PaymentMode = 'NB';
            } else {
                $PaymentMode = $PaymentMethod;
            }
            $Remarks = $this->dbconnection->Get_namme('fee_transaction_action', 'id', "$requestfee_action_id", 'full_pymt_description');

            if ($response['order_status'] === "Success" || $response['order_status'] === "Aborted" || $response['order_status'] === "Failure") {
//                    echo "<br>Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.";                                         
                if ($response_var['orderId'] != NULL && $response_var['orderId'] != '' && $trans_cnt_query[0]->cnt == 0) {
                    $insert_to_db = 'YES';
                } else {
                    $ERROR .= 'Invalid Access Or Time Out Or Double Response Received!';
                }
            } else {
//                    echo "<br>Security Error. Illegal access detected";
                $ERROR .= 'Security_Error. Illegal access detected';
            }
            $response_var['ERROR'] = $ERROR;
            $this->db->db_select('crmfeesclub');
        } else { // DEFAULT HDFC EBS
            $HASHING_METHOD = 'sha512';
            $enc_key = !empty($this->school[0]->pgw_enckey) ? $this->school[0]->pgw_enckey : 'e643efc7cd6cb3a61bbed0842644dd76';
            $hashData = $enc_key;
            $post_val = $this->input->post();
            ksort($post_val);
            foreach ($post_val as $key => $value) {
                if (strlen($value) > 0 && $key != 'SecureHash') {
                    $hashData .= '|' . $value;
                }
            }

            $trans_id = $this->input->get('transac_id');
            $trans_cnt_query = $this->dbconnection->select('fee_transaction_head', 'count(id) as cnt', "id=$trans_id and (response_code=0 or response_code=2) and status=1");
            $requestfee_action_id = $this->input->get('fee_action_id');

            $responseCode = $this->input->post('ResponseCode');
            $response_var = array('txnRefNo' => trim($this->input->post('TransactionID')),
                'payment_id' => trim($this->input->post('PaymentID')),
                'orderId' => trim($this->input->post('MerchantRefNo')),
                'amount' => $total,
                'statusCode' => $responseCode,
                'statusDesc' => trim($this->input->post('ResponseMessage')),
                'txnReqDate' => $this->input->post('DateCreated'),
                'responseCode' => $responseCode,
                'payment_method' => trim($this->input->post('PaymentMethod')),
                'txnRemarks' => trim($this->input->post('Description')),
                'full_pgw_response_json' => json_encode($this->input->post()),
                'doubleresponse' => $trans_cnt_query[0]->cnt,
            );
            $success_page = 'feepayment/gateway/hdfc_success_page';
            $Remarks = $response_var['txnRemarks'];
            $this->db->db_select('crmfeesclub');

            $PaymentMethod = $this->dbconnection->Get_namme('payment_method_desc', 'payment_code', '' . $response_var['payment_method'] . '', 'payment_desc');
            $PaymentMode = $this->dbconnection->Get_namme('payment_method_desc', 'payment_code', '' . $response_var['payment_method'] . '', 'payment_mode');

            if (strlen($hashData) > 0) {
                $secureHash = strtoupper(hash($HASHING_METHOD, $hashData));
//                echo 'encrypted ='.$secureHash;
                if ($secureHash == $this->input->post('SecureHash')) {

                    if ($response_var['orderId'] != NULL && $response_var['orderId'] != '' && $trans_cnt_query[0]->cnt == 0) {
                        $insert_to_db = 'YES';
                    } else {
                        $ERROR .= 'Invalid Access Or Time Out Or Double Response Received!'; // user may refresh the page
                    }
                } else {
                    $ERROR .= 'Hash validation failed'; // Do not receive same data
                }
            } else {
                $ERROR .= 'Invalid response'; // does not receive any response
            }
            $response_var['ERROR'] = $ERROR;
        }
        $school_code = $this->dbconnection->Get_namme("school", "id", $school_id, "school_code");
        $this->db->db_select('crmfeesclub_' . $school_id);

//                echo 'response='.$responseCode;


        if ($insert_to_db == 'YES') {

            if ($responseCode == 0) { //success
                $status = 1;
                $paid_status = 1;
                $remarks_message = 'Successful Payment';
                if ($PaymentMethod != '') {
                    $remarks_message .= ' using';
                }

                $receipt_log = $this->dbconnection->select('receipt_log', 'max(recipt_no) as rec');

                $number = strlen($receipt_log[0]->rec);

                $str = '';
                for ($i = 1; $i <= (6 - $number); $i++) {
                    $str .= '0';
                }

                $maxn = $str . ($receipt_log[0]->rec + 1);
                $this->save_receipt_log($trans_id, $maxn);
                $receipt_no = "FC$session_id$school_code$maxn";

                $instantfee = $this->db->query("select other_fee_id,amount from fee_transaction_det where fee_trans_head_id=$trans_id and fee_cat_id=8")->result();
                $student_id_ = $this->dbconnection->Get_namme("fee_transaction_head", "id", "$trans_id", "student_id");
                foreach ($instantfee as $keyi => $valuei) {
                    $this->dbconnection->update("student_other_fee", array('paid_status' => 1, 'last_date_modified' => date('Y-m-d H:i:s'), 'modified_by' => $this->session->userdata('user_id')), array('student_id' => $student_id_, 'fee_id' => $valuei->other_fee_id, 'amount' => $valuei->amount, 'paid_status' => 0, 'status' => 'Y'));
                }
            } else {
                $status = 0;
                $paid_status = 0;

                $remarks_message = 'Failure Payment';
                if ($PaymentMethod != '') {
                    $remarks_message .= ' using';
                }

                $receipt_no = "";
            }

            /* ---------- Updating Details to Fee Payment record table(fee_transaction_head)  --------- */


            $data = array(
                'paid_status' => $paid_status,
                'response_status' => 1,
                'paid_by' => $this->session->userdata('user_id'),
                'payment_date' => date('Y-m-d H:i:s'),
                'transaction_id' => $response_var['txnRefNo'],
                'payment_id' => $response_var['payment_id'],
                'response_code' => $responseCode,
                'response_message' => $response_var['statusDesc'],
                'remarks' => $remarks_message . ' ' . $PaymentMethod,
                'payment_method' => $PaymentMethod,
                'mode' => $PaymentMode,
                'receipt_no' => $receipt_no,
                'date_modified' => date('Y-m-d H:i:s'),
                'modified_by' => $this->session->userdata('user_id'),
                'full_pgw_response_json' => $response_var['full_pgw_response_json'],
            );

            $this->dbconnection->update("fee_transaction_head", $data, "id=$trans_id");
            /* ---------- Saving Details to Fee Payment Action table(fee_transaction_action)  --------- */
            $this->dbconnection->insert("fee_transaction_action", array('fee_transaction_head_id' => $trans_id, 'action_description' => $remarks_message . ' ' . $PaymentMethod,
                'created_by' => $this->session->userdata('user_id'), 'full_pymt_description' => $Remarks . ' (' . $response_var['statusDesc'] . ')'));
            /* --------------------------------------------------------------------------------------- */

//            $audit = array("action" => "Student Update Fees Status After Payment for transaction id $trans_id",
//                "module" => "Student Fees Module",
//                'datetime' => date("Y-m-d H:i:s"),
//                'userid' => $this->session->userdata('user_id'));
        } else {

            /* ---------- Saving Details to Fee Payment Action table(fee_transaction_action)  --------- */
            $this->dbconnection->insert("fee_transaction_action", array('fee_transaction_head_id' => $trans_id, 'action_description' => $ERROR,
                'created_by' => $this->session->userdata('user_id'), 'full_pymt_description' => $Remarks . ' (' . $response_var['statusDesc'] . ')'));
            /* --------------------------------------------------------------------------------------- */
        }

        $audit = array("action" => 'PAYMENT RESPONSE',
            "module" => $this->page_title,
            "page" => basename(__FILE__, '.php'),
            'datetime' => date("Y-m-d H:i:s"),
            'userid' => $this->session->userdata('user_id'),
            'remarks' => 'ID:' . $trans_id,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
        );
        $this->dbconnection->insert("auditntrail", $audit);

        $this->load->view($success_page, $response_var);
    }

    public function save_receipt_log($trans_id, $maxn) {
		// //Amit
		// echo "save_receipt_log";
		// //Amit
		
        $data1 = array(
            'recipt_no' => $maxn,
            'fee_trans_id' => $trans_id
        );
        $this->dbconnection->insert("receipt_log", $data1);
    } 


    public function generateRandomString($length = 25) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function get_student_fee() {
        error_reporting(0);
        ini_set('display_errors', 1);
		// //Amit
		// echo ("Inside 'get_student_fee'\n");
		// //Amit
        $this->db->db_debug=TRUE;
        $student_id = $this->input->post('stud_id');
        $month_id = $this->input->post('month_id');
        $qtr_id = array_unique((array)$this->input->post('qtr_id'));

        $student = $this->dbconnection->select('student', '*', 'id = ' . $student_id);

        $student_cat = $student[0]->stud_category;
        $year = $this->academic_session[0]->fin_year;
        $student_class_id = $student[0]->class_id;
        $stud_acedemic_session_id = $student[0]->student_academicyear_id;
        $max_year = $this->dbconnection->select('class_fee_head', 'max(year) as max_year, max(id) as max_id', "(from_class_id <=$student_class_id and  to_class_id >=$student_class_id) and course=" . $student[0]->course_id . " and status='Y' and year=".$stud_acedemic_session_id);
        $fee_session_year = $max_year[0]->max_year;
        $max_class_fee_id = $max_year[0]->max_id;
        
        $quarterly_fee_paid = $this->dbconnection->select('fee_transaction_det', 'month_no ,REPLACE(month_desc, "QTR-", "") paidqtr', "fee_trans_head_id in( select id from fee_transaction_head where year=$year and student_id=$student_id and paid_status=1 and response_code=0 and status=1) and fee_cat_id=5");
        $annual_fee_paid = $this->db->query('SELECT * from fee_transaction_det where fee_trans_head_id in( select id from fee_transaction_head where year=' . $year . ' and student_id=' . $student_id . ' and paid_status=1 and status=1) and fee_cat_id=1');
        $onetime_fee_paid = $this->db->query('SELECT * from fee_transaction_det where fee_trans_head_id in( select id from fee_transaction_head where year=' . $year . ' and student_id=' . $student_id . ' and paid_status=1 and status=1) and fee_cat_id in (9,10)');

        $quarterly_fee = $this->db->query('SELECT fee_id,fee_amount,(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name FROM class_fee_det where fee_cat=5 and stud_cat=' . $student_cat . '  and class_fee_head_id=' . $max_class_fee_id . ' and status=1');

        $annual_fee = $this->db->query('SELECT fee_amount,'
                . '(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name, (select fee_type from fee_master where id=class_fee_det.fee_id) as fee_type '
                . 'FROM class_fee_det where fee_cat=1 and stud_cat=' . $student_cat . ' and'
                . ' class_fee_head_id=' . $max_class_fee_id . ' and status=1');

        $onetime_fee = $this->db->query('SELECT fee_amount,'
                . '(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name,fee_cat '
                . 'FROM class_fee_det where fee_cat in (9,10) and stud_cat=' . $student_cat . ' and'
                . ' class_fee_head_id=' . $max_class_fee_id . ' and status=1'); 

        $fetch_instant_fees_det = $this->dbconnection->select("student_other_fee as fee", "fee.*, (Select fee_name from fee_master where id=fee.fee_id) as fee_desc", "fee.student_id=" . $student_id . " and year=$year and paid_status!=1 and status='Y'");
//        $fetch_instant_fees_det1 = $this->dbconnection->select("student_other_fee as fee", "fee.*, (Select fee_name from fee_master where id=fee.fee_id) as fee_desc", "fee.student_id=" . $student_id . " and year=$year  and status='Y'");

        $total_paid_month = count($quarterly_fee_paid)+($student[0]->start_fee_month-1);
		// //Amit
		// echo ("annual_fee " . $annual_fee . "\n");
		// echo ("onetime_fee " . $onetime_fee . "\n");
		// echo ("fetch_instant_fees_det " . $fetch_instant_fees_det . "\n");
		// echo ("total_paid_month " . $total_paid_month . "\n");
		// //Amit
        
        
//        $total_paid_qtr = !empty($quarterly_fee_paid[count($quarterly_fee_paid)]->paidqtr)?$quarterly_fee_paid[count($quarterly_fee_paid)]->paidqtr+1:0;
        $total_paid_qtr = $total_paid_month/3;
       
        
        $total_check_month = count($month_id);
        $total_check_qtr = count($qtr_id);
        $total_pay_month = $total_check_month ;
        $total_pay_qtr = $total_check_qtr;

		// //Amit
		// echo ("total_paid_qtr " . $total_paid_qtr . "\n");
		// echo ("total_check_qtr " . $total_check_qtr . "\n");
		// //Amit
        
        
        $actualfinemonth = $this->input->post('actualfine');
        list($year, $month, $day) = explode('-', date('Y-m-d'));


//---------------- Applying Fine if any -------------------------------//
        $count = 0;
        $pm = $total_paid_month + 1;
        $l = $total_pay_month;
        if ($month >= 1 && $month <= 3) {
            $month = $month + 12;
        }
        while ($l > 0) {
            if ($pm < ($month - 3)) {

                $count++;
            }
            $l--;
            $pm++;
        }
        $due_month = $count;

        if ($day > $this->school[0]->last_pay_date && $total_check_month >= ($month - 3) && $actualfinemonth != 0) {

            $due_month = $due_month + 1;
        }

// //Amit
// echo ("due_month " . $due_month . "\n");
// //Amit


//-----------Late Fine --------------- // 
        $due_month_corrected=$fine_rule_duemonth = $due_month;
            $fine_rule = $this->dbconnection->select("fine_rule", "count(id) cnt,max(due_month) mdue_month");
            $fine_rule_fetch = array();
            if ($fine_rule[0]->cnt != 0) {
                if ($fine_rule[0]->mdue_month < $due_month) {            
                    $fine_rule_duemonth=$fine_rule[0]->mdue_month;                    
                }
                $fine_rule_fetch = $this->dbconnection->select_join("fine_rule fr", "fr.id,fr.from_day,fr.to_day,fr.due_month,cf.fee_amount,cf.fine_rule_id", "fr.due_month=$fine_rule_duemonth and fr.from_day<=$day "
                        . "and fr.to_day>=$day and cf.fee_cat=0 and cf.class_fee_head_id=$max_class_fee_id and cf.status=1 and cf.stud_cat=0","class_fee_det cf","fr.id=cf.fine_rule_id","inner");          
            }
        
        $fine_amount = 0;
        $fine_apply_status = 0;
        $disable_trans = 0;
        if (!empty($this->school[0]->start_pay_date) && $student[0]->fine_waiver != 'YES' && $total_paid_month < ($month - 3) && $total_pay_month != 0) {  //only if fine is applicable
            if ($day < $this->school[0]->start_pay_date || $day > $this->school[0]->last_pay_date) {

                if ($this->school[0]->transc_freeze_status == 1) {

                    $disable_trans = 1;
                }
                if (!empty($fine_rule_fetch)) {
                    $fine_apply_status = 1;
                }
            } else {

                if (!empty($fine_rule_fetch)) {
                    $fine_apply_status = 1;
                }
            }



            if ($fine_apply_status == 1) {

                if ($this->school[0]->fine_type_checkbox == 'ADJUSTABLE') {

                    $duemonthcancel = $actualfinemonth - $due_month_corrected;

                    $fine_rule_fetch = $this->dbconnection->select_join("fine_rule fr", "fr.id,fr.from_day,fr.to_day,fr.due_month,cf.fee_amount,cf.fine_rule_id", "fr.due_month=$actualfinemonth and fr.from_day<=$day "
                    . "and fr.to_day>=$day and cf.fee_cat=0 and cf.class_fee_head_id=$max_class_fee_id and cf.status=1 and cf.stud_cat=0","class_fee_det cf","fr.id=cf.fine_rule_id","inner");            
                    $fine_amount=$fine_rule_fetch[0]->fee_amount;

                    $cancelfine_rule_fetch = $this->dbconnection->select_join("fine_rule fr", "fr.id,fr.from_day,fr.to_day,fr.due_month,cf.fee_amount,cf.fine_rule_id", "fr.due_month=$duemonthcancel and fr.from_day<=$day "
                    . "and fr.to_day>=$day and cf.fee_cat=0 and cf.class_fee_head_id=$max_class_fee_id and cf.status=1 and cf.stud_cat=0","class_fee_det cf","fr.id=cf.fine_rule_id","inner");            
                    if (count($fine_rule_fetch) > 0) {
                        if (count($cancelfine_rule_fetch) > 0) {
                            $fine_amount = $fine_rule_fetch[0]->fee_amount - $cancelfine_rule_fetch[0]->fee_amount;
                        } else {
                            $fine_amount = $fine_rule_fetch[0]->fee_amount;
                        }
                    }
                } elseif ($this->school[0]->fine_type_checkbox == 'NOT_CHANGEABLE') {
//                    if($this->session->userdata('school_id')==5){
                    $fine_rule_fetch = $this->dbconnection->select_join("fine_rule fr", "fr.id,fr.from_day,fr.to_day,fr.due_month,fr.max_day,cf.fee_amount,cf.fine_rule_id", "fr.due_month<=$actualfinemonth and fr.from_day<=$day "
                    . "and fr.to_day>=$day and cf.fee_cat=0 and cf.class_fee_head_id=$max_class_fee_id and cf.status=1 and cf.stud_cat=0","class_fee_det cf","fr.id=cf.fine_rule_id","inner");            
                    if(count($fine_rule_fetch)>0) {
                        $fine_amount=$fine_rule_fetch[count($fine_rule_fetch)-1]->fee_amount;
                        if ($fine_rule[0]->mdue_month >= $due_month) {
                            $due_month_corrected=$fine_rule_fetch[count($fine_rule_fetch)-1]->max_day;
                        }else{
                            $due_month_corrected=$due_month;
                        }
                    }
                    
                } else {
                    $fine_amount=$fine_rule_fetch[0]->fee_amount;

                }
            }
        }
        
       
//-------------------------------- //

        $table_html = '';

        $total_fee = 0;
        $start_fee_month=$student[0]->start_fee_month;
// //Amit
// echo ("start_fee_month " . $start_fee_month . "\n");
// //Amit
        
        $qtrsetcount=array_count_values($this->qtr);
        $table_html .= '<tr><td><input type="hidden" name="actual_fine_due_month" value=' . $actualfinemonth . '></td>';
        $table_html .= '<td><input type="hidden" name="fine_due_month" value=' . $due_month_corrected . '></td>';
        $y = 1;
        foreach ($quarterly_fee->result() as $obj) {

            
            if($start_fee_month!=1 && in_array($this->qtr[$start_fee_month-1], $qtr_id) ) {
//                $subtractqtr=($obj->fee_amount/$qtrsetcount[$this->qtr[$start_fee_month-1]])*($start_fee_month-1);

// Commented by Amit --below one line               
			   $subtractqtr=round(($obj->fee_amount/3)*($start_fee_month-1));
// // --Amit code				$subtractqtr=floor((($obj->fee_amount)/3)*($start_fee_month-1));		//Amit
// 			echo ("obj->fee_amount " . $obj->fee_amount . "\n");
// 		echo ("subtractqtr " . $subtractqtr . "\n");
// 		//Amit



                
            }else{
                $subtractqtr=0;
            }
   //          //Amit
			// echo ("subtractqtr " . $subtractqtr . "\n");
			// echo ("total_pay_qtr " . $total_pay_qtr . "\n");
			// echo ("obj->fee_amount " . $obj->fee_amount . "\n");
			// //Amit

            $curramt=max(($obj->fee_amount * $total_pay_qtr)-$subtractqtr,0);
   //          //Amit
			// echo ("curramt " . $curramt . "\n");
			// //Amit
			
			
            $total_fee = $total_fee + $curramt;
            $table_html .= '<tr id=fee_'.$y.'>';
            $table_html .= '<td style="display:none">'.$obj->fee_id .'</td>';
            $table_html .= '<td>'.$obj->fee_name .'</td>';
            $table_html .= '<td>'.$curramt.'</td>';
            $table_html .= '</tr>';
        	$y++;
        }
        if (count($fetch_instant_fees_det) > 0) {
            foreach ($fetch_instant_fees_det as $instfee) {
//                                            $total = $total + $transport_fee_amt * $count;
                $total_fee = $total_fee + $instfee->amount;

                $table_html .= '<tr>';
                $table_html .= '<td>' . $instfee->fee_desc . ' (Instant Fee)</td>';
                $table_html .= '<td><input type="text" readonly="true" style="border: 0px;width: 100%;background:inherit" name="instantfee_chk[' . $instfee->id . '][' . $instfee->fee_id . ']" value="' . $instfee->amount . '"></td>';
                $table_html .= '</tr>';
            }
        }
        // print_r($qtr_id);
        // die();
        // if((($qtr_id[0]==0)))
        // {
        //     echo 'yes';
        // }
         if((($qtr_id[0]==0)&&($qtr_id[3]==1)))
        {
            // echo 'hiii';
            
            if ($fine_apply_status == 1 && $fine_amount != 0) {
                // $fine_amount=100;
                $total_fee = $total_fee + $fine_amount;
                $table_html .= '<tr>';
                $table_html .= '<td>Fine Amount</td>';
                
                $table_html .= '<td><input type="text" readonly="true" style="border: 0px;width:65px;background:inherit" name="fine_amt" value="' . $fine_amount . '"></td>';
                $table_html .= '</tr>';
            } 
        }
        else if(($qtr_id[0]==0))
        {
            // echo 'yes';
        }
        else
        {
            // echo 'noo';
           if ($fine_apply_status == 1 && $fine_amount != 0) {
            $total_fee = $total_fee + $fine_amount;
            $table_html .= '<tr>';
            $table_html .= '<td>Fine Amount</td>';
            
            $table_html .= '<td><input type="text" readonly="true" style="border: 0px;width:65px;background:inherit" name="fine_amt" value="' . $fine_amount . '"></td>';
            $table_html .= '</tr>';
        } 
        }

        
        if (count($annual_fee_paid->result()) == 0 && $this->school[0]->annual_month != 0 && ($month - 3) >= $this->school[0]->annual_month) {
            $total_annual_f = 0;
            $total_annual_rf = 0;
            foreach ($annual_fee->result() as $obj) {
                $total_annual_f = $total_annual_f + $obj->fee_amount;
                if ($obj->fee_type == 'REFUND') {
                    $total_annual_rf = $total_annual_rf + $obj->fee_amount;
                }
                
            }
            if ($total_annual_f != 0) {
                if ($start_fee_month != 1) {
                    $refunded = $total_annual_rf / 12;
                    $total_refunded = $refunded * ($start_fee_month - 1);
                    $total_annual_f = $total_annual_f - $total_refunded;
                }
                $total_fee = $total_fee + $total_annual_f;
                $table_html .= '<tr>';
                $table_html .= '<td>Annual Fee (as this is the last month for Annual)</td>';
                $table_html .= '<td>';
                $table_html .= '<input type="text" readonly="true" style="border: 0px;width: 100%;background:inherit" name="annual_last_fee_amt" value="' . $total_annual_f . '">';
                $table_html .= '</td>';
                $table_html .= '</tr>';
            }
        }
        
        if (count($onetime_fee_paid->result()) == 0 && $student[0]->student_type!='EXISTING') {
            $total_onetime = 0;
            $total_onet = 0;
            $total_refundt = 0;
            foreach ($onetime_fee->result() as $obj) {
                $total_onetime = $total_onetime + $obj->fee_amount;
                if ($obj->fee_cat == 9) {
                    $total_onet = $total_onet + $obj->fee_amount;
                }
                if ($obj->fee_cat == 10) {
                    $total_refundt = $total_refundt + $obj->fee_amount;
                }
            }
            if ($total_onetime != 0) {
                
                $total_fee = $total_fee + $total_onetime;
                $table_html .= '<tr>';
                $table_html .= '<td>OneTime Fee</td>';
                $table_html .= '<td>';
                $table_html .= '<input type="text" readonly="true" style="border: 0px;width: 100%;background:inherit" name="onetime_fee_amt" value="' . $total_onetime . '">';
                $table_html .= '<input type="hidden" name="categorylist[1]" value="'.$total_onet.'">';
                $table_html .= '<input type="hidden" name="categorylist[2]" value="'.$total_refundt.'">';
                $table_html .= '</td>';
                $table_html .= '</tr>';
            }
        }


        $oth_fee_id = array();
        $oth_fee_amount = array();
        for ($i = $total_paid_month + 1; $i <= $total_paid_month + $total_pay_month; $i++) {

            $othquery = $this->db->query("SELECT id,fee_name,month_set,(SELECT fee_amount FROM class_fee_det where fee_cat=3 and stud_cat=0 and class_fee_head_id=$max_class_fee_id and status=1 and fee_id=fee_master.id) fee_amount FROM `fee_master` WHERE fee_cat_id=3 and FIND_IN_SET('$i', month_set) and status=1 group by id")->result();
            foreach ($othquery as $valueo) {
                $oth_fee_id[$valueo->id] = $valueo->fee_name . ' ';
                if (array_key_exists($valueo->id, $oth_fee_amount)) {
                    $o = $oth_fee_amount[$valueo->id] + $valueo->fee_amount;
                } else {
                    $o = $valueo->fee_amount;
                }

                $oth_fee_amount[$valueo->id] = $o;
            }
        }

        foreach ($oth_fee_id as $ofeeid => $ovalue) {
            $total_fee = $total_fee + $oth_fee_amount[$ofeeid];
            $table_html .= '<tr>';
            $table_html .= '<td>' . $ovalue . '</td>';
            $table_html .= '<td>';
            $table_html .= '<input type="text" readonly="true" style="border: 0px;width: 100%;background:inherit" name="oth_fee[' . $ofeeid . ']" value="' . $oth_fee_amount[$ofeeid] . '">';
            $table_html .= '</td>';
            $table_html .= '</tr>';
        }

        $table_html1 = '<tr style="font-size: 17px;font-weight: bold;">';
        $table_html1 .= '<td>Total</td>';
        $table_html1 .= '<td><input type="text" readonly="true" style="border: 0px;width:65px;background:inherit" name="total_m" value="' . $total_fee . '"></td>';
        $table_html1 .= '</tr>';
                
//        $token['name']=$this->token_name;
//        $token['value']=$this->token_hash;
        echo $table_html . '|' . $total_fee . '|' . $table_html1 . '|' . $total_paid_month . '|' . $this->school[0]->annual_month . '|' . $due_month_corrected;
    }


    public function download_pdf($data) { 
        include('fpdf/fpdf.php');
        include('fpdi/fpdi.php');
        $pdf = new FPDF();
        $pdf = new FPDI();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 10);

        $pdf->setSourceFile("fpdf/E-receipt.pdf");
        $import = $pdf->importPage(1);
        $pdf->useTemplate($import, NULL, NULL, 0, 0, true);
        $school_id = $this->session->userdata('school_id');
        $img = $school_id . '.JPG';
        if (file_exists('assets/img/' . $img)) {
            $pdf->Image('assets/img/' . $img, 20, 20, 30, 30);
        }
        $pdf->SetFont('Arial', 'B', 20);

        $pdf->SetXY(55, 23);
        $pdf->Write(0, $data['school_name']);
        $pdf->SetFont('Arial', '', 10);

        $pdf->SetXY(60, 30);
        $pdf->Write(2, strtoupper($data['vision']));
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetXY(60, 37);
//        $this->fpdf->Cell(60,20,strtoupper($school[0]->address),0,0,'C');
        $pdf->Write(5, strtoupper($data['school_address']));

//        $pdf->SetXY(60, 30);
//        $pdf->Write(0, strtoupper($data['school_address']));

        $pdf->SetXY(60, 45);
        $pdf->Write(0, 'MAIL : ' . $data['email'] . ' | TEL : ' . $data['phone']);
        $pdf->SetFont('Arial', '', 10);

        $pdf->SetXY(60, 78.5);
        $pdf->Write(0, $data['transaction_id']);
        $pdf->SetXY(140, 77.7);
        $pdf->Write(0, $data['date']);

        $pdf->SetXY(60, 88);
        $pdf->Write(0, $data['receipt_no']);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY(124, 88);
        $pdf->Write(0, 'Mode  :');
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY(140, 88);
        $pdf->Write(0, $data['mode']);

        $pdf->SetXY(60, 98);
        $pdf->Write(0, $data['admission_no']);

        $pdf->SetXY(60, 107.8);
        $pdf->Write(0, $data['name']);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY(124, 107.8);
        $pdf->Write(0, 'Father\'s Name :');
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY(155, 107.8);
        $pdf->Write(0, $data['father_name']);

        $pdf->SetXY(60, 116.8);
        $pdf->Write(0, $data['class']);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY(124, 116.8);
        $pdf->Write(0, 'Roll    :');
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY(140, 116.8);
        $pdf->Write(0, $data['roll']);

        $pdf->SetXY(60, 126);
        $pdf->Write(0, $data['secname']);
        $pdf->SetXY(60, 135.8);
        $pdf->Write(0, $data['cat']);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY(21, 145);
        $pdf->Write(0, $data['fee_type_name']);
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY(60, 145);
        $pdf->Write(0, $data['month_session']);

        $total = 0;
        $top_height = 165;
        foreach ($data['monthly_fee'] as $obj) {
            $total = $total + $obj->fee_amount;
            $pdf->SetXY(15, $top_height);
            $pdf->Write(0, $obj->fee_name);

            $pdf->SetXY(108, $top_height);
            $pdf->Write(0, $obj->fee_amount);
            $top_height = $top_height + 4;
        }
        if ($data['transport_fee'] > 0) {
            $total = $total + $data['transport_fee'];
            $pdf->SetXY(15, $top_height);
            $pdf->Write(0, 'Transport Fees');
            $pdf->SetXY(108, $top_height);
            $pdf->Write(0, $data['transport_fee']);
            $top_height = $top_height + 4;
        }
        foreach ($data['annual_fee'] as $obj) {
            //$total = $total + $obj->fee_amount;
            $start_fee_month = $data['start_fee_month'];
            $rest_month = (12-$start_fee_month)+1;
            $fee_amount = $obj->fee_amount;
            $fee_id     = $obj->fee_id;
            if($fee_id==10 || $fee_id==16)
            {
                $fee = $fee_amount;
            }                
            else
            {
                $fee = ($fee_amount/12)*$rest_month;
            }
            $total = $total+$fee;   

            $pdf->SetXY(15, $top_height);
            $pdf->Write(0, $obj->fee_name);

            $pdf->SetXY(108, $top_height);
            $pdf->Write(0, $fee);
            $top_height = $top_height + 4;


        }
        foreach ($data['one_fee'] as $obj) {
            $total = $total + $obj->fee_amount;
            $pdf->SetXY(15, $top_height);
            $pdf->Write(0, $obj->fee_name);

            $pdf->SetXY(108, $top_height);
            $pdf->Write(0, $obj->fee_amount);
            $top_height = $top_height + 4;
        }        
        foreach ($data['other_fee'] as $obj) {
            $total = $total + $obj->fee_amount;
            $pdf->SetXY(15, $top_height);
            $pdf->Write(0, $obj->fee_name);

            $pdf->SetXY(108, $top_height);
            $pdf->Write(0, $obj->fee_amount);
            $top_height = $top_height + 4;
        }
        foreach ($data['instant_fee'] as $obj) {
            $total = $total + $obj->fee_amount;
            $pdf->SetXY(15, $top_height);
            $pdf->Write(0, $obj->fee_name);

            $pdf->SetXY(108, $top_height);
            $pdf->Write(0, $obj->fee_amount);
            $top_height = $top_height + 4;
        }
        foreach ($data['fine_fee'] as $obj) {
            $total = $total + $obj->fee_amount;
            $pdf->SetXY(15, $top_height);
            $pdf->Write(0, $obj->fee_name);

            $pdf->SetXY(108, $top_height);
            $pdf->Write(0, $obj->fee_amount);
            $top_height = $top_height + 4;
        }
        if (!empty($data['readmsnfine_fee'])) {
            $total = $total + $data['readmsnfine_fee'][0]->fee_amount;
            $pdf->SetXY(15, $top_height);
            $pdf->Write(0, 'Re-Admission-Fine');
            $pdf->SetXY(108, $top_height);
            $pdf->Write(0, $data['readmsnfine_fee'][0]->fee_amount);
            $top_height = $top_height + 4;
        }
        foreach ($data['half_fee'] as $obj) {
            $total = $total + $obj->fee_amount;
            $pdf->SetXY(15, $top_height);
            $pdf->Write(0, $obj->fee_name);

            $pdf->SetXY(108, $top_height);
            $pdf->Write(0, $obj->fee_amount);
            $top_height = $top_height + 4;
        }

        if ($data['discount'] > 0) {
            $total = $total - $data['discount'];
            $this->fpdf->SetXY(15, $top_height);
            $this->fpdf->Write(0, 'Instant Discount');
            $this->fpdf->SetXY(108, $top_height);
            $this->fpdf->Write(0, $data['discount']);
            $top_height = $top_height + 4;
        }


        $pdf->SetXY(55, 246);
        $pdf->Write(0, strtoupper($this->convert_number_to_words($total) . ' only'));
        $pdf->SetXY(108, 225);
        $pdf->Write(0, $total . ' INR');
        $pdf->Output("E-receipt_" . $data['month_session'] . ".pdf", "D");
    }


    public function btn_download_pop_load() {

        $month = array(1 => "April", 2 => "May", 3 => "June", 4 => "July", 5 => "August", 6 => "September", 7 => "October", 8 => "Novemeber", 9 => "December", 10 => "January", 11 => "February", 12 => "March");

        if ($this->uri->segment(3) == 'dwld_no')
            $fee_transaction_id = $this->input->post('trans_id');
        else
            $fee_transaction_id = $this->uri->segment(4);

        $query_transaction = $this->db->query("select f1.*,f2.class_fee_head_id,group_concat(distinct(f2.fee_cat_id)) as fee,count(case when f2.month_no<>0 and f2.fee_cat_id=5 then f2.month_no end) as m,min(case when f2.month_no<>0 and f2.fee_cat_id=5 then f2.month_no end) as from_month,max(f2.due_month_no) as d from fee_transaction_head f1, fee_transaction_det f2 where f1.id=$fee_transaction_id and f1.response_message=0 and f1.status=1 and f1.id=f2.fee_trans_head_id group by f1.id");
        $q = $query_transaction->result();
        $school_id = $this->session->userdata('school_id');
        $school = $this->school;



        $student = $this->dbconnection->select('student', 'id,roll,course_id,transport_amt,'
                . ' class_id,(select class_name from class where id=student.class_id) as class_name,'
                . ' concat(first_name," ",middle_name," ",last_name) as name,admission_no,'
                . ' stud_category,'
                . ' (select c.cat_name from category c where c.id=stud_category) as cat_name,'
                . '  section_id,(select s.sec_name from section s where s.id=section_id) as sec_name,father_name,'
                . ' email_address, phone, dob, status, date_created, created_by,last_date_modified, last_modified_by,start_fee_month', 'id = ' . $q[0]->student_id);

        if ($this->academic_session[0]->fin_year == $q[0]->year) {

            $class_name = $student[0]->class_name;
            $sec_name = $student[0]->sec_name;
            $cat_name = $student[0]->cat_name;
            $start_fee_month = $student[0]->start_fee_month;
        } else {
            $log = $this->dbconnection->select('student_class_acedemic_log', 'id,class_id,section_id,course_id,stud_category,'
                    . ' (select class_name from class where id=student_class_acedemic_log.class_id) as class_name,'
                    . ' (select s.sec_name from section s where s.id=section_id) as sec_name,'
                    . ' (select c.cat_name from category c where c.id=stud_category) as cat_name,start_fee_month', "student_id={$q[0]->student_id} and acedemic_year_id={$q[0]->year}");
            $class_name = $log[0]->class_name;
            $sec_name = $log[0]->sec_name;
            $cat_name = $log[0]->cat_name;
            $start_fee_month = $log[0]->start_fee_month;

        }


        $transaction_id = $q[0]->transaction_id;
        $payment_date = $q[0]->payment_date;
        $receipt_no = $q[0]->receipt_no;
        $mode = $q[0]->mode;

        $fee_type_name = 'Fee Paid';
        $transport_fee = 0;
        $monthly_fee = array();
        $annual_fee = array();
        $one_fee = array();
        $instant_fee = array();
        $other_fee = array();
        $fine_fee = array();
        $half_fee = array();
        $fe_desc = explode(',', $q[0]->fee);
        $str = '';
        $discount=0;
        foreach ($fe_desc as $index => $value) {
            if ($value == 5) {
                if ($q[0]->m > 1) {

                    $month_var = $q[0]->from_month + $q[0]->m - 1;
                    $str .= $month[$q[0]->from_month] . "-" . $month[$month_var] . " Fees,";
                } else {
                    $str .= $month[$q[0]->from_month] . " Fees,";
                }
                $monthly_fee = $this->db->query("SELECT round(" . $q[0]->m . "*(fee_amount/3)) as fee_amount,(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name FROM class_fee_det  where fee_cat=5 and stud_cat=" . $student[0]->stud_category . " and class_fee_head_id=" . $q[0]->class_fee_head_id . " and status=1");
                $monthly_fee = $monthly_fee->result();
            } 
            else if ($value == 1) 
            {
                $str .= ' Annual Fees,';
                $annual_fee = $this->db->query("SELECT fee_amount,(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name,fee_id FROM class_fee_det  where fee_cat=1 and stud_cat=" . $student[0]->stud_category . " and class_fee_head_id=" . $q[0]->class_fee_head_id . " and status=1");
                $annual_fee = $annual_fee->result();

                $annual_totals = $this->db->query("SELECT sum(fee_amount)as amt FROM class_fee_det  where fee_cat=1 and stud_cat=" . $student[0]->stud_category . " and class_fee_head_id=" . $q[0]->class_fee_head_id . " and status=1")->result();
                $annual_total = $annual_totals[0]->amt;

            } else if ($value == 9) {
                $str .= ' Onetime Fees,';
                $one_fee = $this->db->query("SELECT fee_amount,(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name FROM class_fee_det  where fee_cat in (9,10) and stud_cat=" . $student[0]->stud_category . " and class_fee_head_id=" . $q[0]->class_fee_head_id . " and status=1");
                $one_fee = $one_fee->result();
            } else if ($value == 3) {
                $str .= ' Other/Additional Fees,';
                $other_fee = $this->db->query("SELECT amount as fee_amount,(select fee_name from fee_master where id=other_fee_id) as fee_name FROM fee_transaction_det  where fee_cat_id=3 and fee_trans_head_id=$fee_transaction_id");
                $other_fee = $other_fee->result();
            } else if ($value == 8) {
                $str .= ' Instant/Misc. Fees,';
                $instant_fee = $this->db->query("SELECT amount as fee_amount,(select fee_name from fee_master where id=other_fee_id) as fee_name FROM fee_transaction_det  where fee_cat_id=8 and fee_trans_head_id=$fee_transaction_id")->result();
            } else if ($value == 4) {
                $str .= ' Half-Yearly Fees,';
                $half_fee = $this->db->query("SELECT sum(amount) as fee_amount,(select fee_name from fee_master where id=halfyearly_fee_id) as fee_name FROM fee_transaction_det  where fee_cat_id=4 and fee_trans_head_id=$fee_transaction_id group by halfyearly_fee_id");
                $half_fee = $half_fee->result();
            } else if ($value == 0) {

                if ($q[0]->d > 1) {
                    $str .= ' ' . $q[0]->d . ' Months Fine,';
                } else {
                    $str .= ' ' . $q[0]->d . ' Month Fine,';
                }
                $fine_fee = $this->db->query("SELECT sum(amount) as fee_amount,'Fine for " . $q[0]->d . " Months' as fee_name FROM fee_transaction_det  where fee_cat_id=0 and fee_trans_head_id=$fee_transaction_id");
                $fine_fee = $fine_fee->result();
            }else if ($value == 11) {
//                $str .= ' Re-Admission-Fine,';
                $readmsnfine_fee = $this->db->query("SELECT amount as fee_amount,'Re-Admission-Fine' as fee_name FROM fee_transaction_det  where fee_cat_id=11 and fee_trans_head_id=$fee_transaction_id");
                $readmsnfine_fee = $readmsnfine_fee->result();
                
            } else if ($value == 6) {
                $transport_fee = $this->db->query("SELECT sum(amount) as fee_amount FROM fee_transaction_det  where fee_cat_id=6 and fee_trans_head_id=$fee_transaction_id")->result();
                $str .= ' Transport Fees,';
//                $transport_fee = $q[0]->m * $student[0]->transport_amt;
                $transport_fee = $transport_fee[0]->fee_amount;
            } else if ($value == 7) {
                $str .= ' Instant Discount,';
                $discount = $q[0]->discount_amount;
            }
        }
        $str = rtrim($str, ',');

        $month_session = $str;

//        $fee_session_year = $this->academic_session[0]->fin_year;
        $session = $this->dbconnection->select('accedemic_session', '*', 'id=' . $q[0]->year);
        $accedemic_session = $session[0]->session;

        $total_amt_words = $q[0]->total_amount;
        $data = array(
            'school_id' => $school_id,
            'school_name' => $school[0]->description,
            'school_address' => $school[0]->address,
            'school_group' => $school[0]->school_group,
            'vision' => $school[0]->vision,
            'phone' => $school[0]->phone,
            'email' => $school[0]->email,
            'roll' => $student[0]->roll,
            'father_name' => $student[0]->father_name,
            'transaction_id' => $transaction_id,
            'mode' => $mode,
            'date' => date('d-m-Y', strtotime($payment_date)),
            'receipt_no' => $receipt_no,
            'admission_no' => $student[0]->admission_no,
            'name' => $student[0]->name,
            'class' => $class_name,
            'secname' => $sec_name,
            'cat' => $cat_name,
            'fee_type_name' => $fee_type_name,
            'month_session' => $month_session,
            'year' => $accedemic_session,
            'monthly_fee' => $monthly_fee,
            'annual_fee' => $annual_fee,
            'one_fee' => $one_fee,
            'half_fee' => $half_fee,
            'other_fee' => $other_fee,
            'instant_fee' => $instant_fee,
            'fine_fee' => $fine_fee,
            'student_id' => $student[0]->id,
            'fee_transaction_id' => $fee_transaction_id,
            'transport_fee' => $transport_fee,
            'discount' => $discount,
            'cntrl' => 'payment_army',
            'readmsnfine_fee' => $readmsnfine_fee,
            'total_amt_words' => $this->convert_number_to_words($total_amt_words),
            'start_fee_month' => $start_fee_month,
            'annual_total' => $annual_total
        );
        if ($this->uri->segment(3) == 'dwld_no')
            $this->load->view('feepayment/gateway/receipt_popup', $data);
        else
            $this->download_pdf($data);
    }

//        public function df()
//        {
//            $this->load->helper('download');
//            $data['rt']='b';
//            $d=$this->load->view('student/tr',$data,true);
////            $pdf=build_pdf($d);
//            force_download('tr.pdf',$d);
//        }


    public function pdf() {
        require_once('tcpdf/tcpdf.php');
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('times', '', 10, '', true);
        $pdf->AddPage();
        $pdf->setTextShadow(array('enabled' => false, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));
        $FEESCLUB00001 = 'FEESCLUB00001';
        $html = '
<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
<style>
td,th 
{
height:20px;
}
td
{
width:48%;
}
th
{
width:12%;
text-align:left;
}
.left_col
{
width:12%;text-align: left;
}
.left_col_val
{
width:48%;
}
.right_col
{
width:13%;text-align:left;
}
.right_col_val
{
width:27%;
}

</style>
</head>
<body style="font-family:serif;font-size:13px">
<div style="height:auto;width:100%;">	
<div style="height:auto;width:100%;">
//                  <img src="1.PNG-" alt="test alt attribute" width="600" height="100" />
</div>
<hr>
<div style="font-family:serif;text-align:right;float:left;position:relative;height:60px"><u>Receipt No</u>:' . $FEESCLUB00001 . '</div>
<div style="height:50px"></div>

<table style="width:100%;">

<tr>
<th class="left_col">Session</th>
<td class="left_col_val">:2015-17</td>
<th class="right_col">Date</th>
<td class="right_col_val">:02-05-2017</td>
</tr>

<tr>
<th class="left_col">Name</th>
<td class="left_col_val">:Prabhat Kumar Rana</td>
<th class="right_col">Adm No</th>
<td class="right_col_val">:1001</td>
</tr>
<tr>
<th class="left_col">Class</th>
<td class="left_col_val">:A</td>
<th class="right_col">Section</th>
<td class="right_col_val">:1001</td>
</tr>
<tr>
<th class="left_col">Fee Paid</th>
<td class="left_col_val">:Apr-May,Diary Fee,Annual</td>
<th class="right_col"></th>
<td class="right_col_val"></td>
</tr>


</table>
<div style="height:20px"></div>

<table border="1">
<tr>
<th style="text-align:center;width:10%"><u>#Sno</u></th>
<th style="text-align:center;width:70%"><u>Fee Type</u></th>
<th style="text-align:center;width:20%"><u>Amount</u></th>

</tr>';
        for ($i = 0; $i < 15; $i++) {
            $html .= '<tr>
<th style="text-align:center;width:10%"></th>
<th style="text-align:center;width:70%"></th>
<th style="text-align:center;width:20%"></th>

</tr>';
        }

        $html .= '<tr>
<th colspan="2" style="width:80%;text-align:right">Total</th>        
<th style="text-align:center;width:20%">200</th>

</tr>';
        $html .= ' </table>

<div style="height:50px"></div>
<div>Amount In Words:Six thousand five hundred</div>
<div style="height:500px">
</div>
<div>
Note:This is computer Generated Receipt.It does not require any signature and seal by any authority.
</div>

</div>

</body>
</html>';

        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
        ob_clean();
        $pdf->Output('example_001.pdf', 'I');
    }


    public function convert_number_to_words($number) {
        $hyphen = '-';
        $conjunction = ' and ';
        $separator = ', ';
        $negative = 'negative ';
        $decimal = ' point ';
        $dictionary = array(
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'fourty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety',
            100 => 'hundred',
            1000 => 'thousand',
            1000000 => 'million',
            1000000000 => 'billion',
            1000000000000 => 'trillion',
            1000000000000000 => 'quadrillion',
            1000000000000000000 => 'quintillion'
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
		// overflow
            trigger_error('Function convert_number_to_words accepts Numbers only between - ' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING);
            return false;
        }

        if ($number < 0) {
            return $negative . $this->convert_number_to_words(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
				
            case $number < 100:
                $tens = ((int) ($number / 10)) * 10;
                $units = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            
			case $number < 1000:
                $hundreds = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . $this->convert_number_to_words($remainder);
                }
                break;
            
			default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = $this->convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= $this->convert_number_to_words($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }
    
	
	public function quarter_month()
    {
		// //Amit
		// echo "quarter_month";		
		// //Amit
		
        $quarter_month = $this->dbconnection->select("crmfeesclub.school_fee_structure", "*", "status='Y'"); //where school id army public school
        $a = $quarter_month[0]->set1;

        $a . '<br>';
        $var1 = unserialize($a);
        $one = $var1[0];
        $two = $var1[1];
        $three = $var1[2];
        echo $set1=$one.'-'.$two.'-'.$three. '<br>';
        
        $date = $one;
        $qtrmon=date('m', strtotime($date)).'<br>';
//        print_r($var1);
//        die();
    }
    
    public function getStatus() {
	//    $this->load->view('feepayment/gateway/status');
        
        $url="https://login.ccavenue.com/apis/servlet/DoWebTrans";
        $ch= curl_init($url);
        $data= array(
			//  'merchant_id'   => "223969",
            'reference_no'=>'',
            'order_no'=>'APSR-15909-6714',
            
        );
        include($_SERVER['DOCUMENT_ROOT'] . '/assets/gateway/Crypto.php');
                
        $working_key = "C233E51624F136F629EB67EEA57F1B4F"; //Shared by CCAVENUES
//        $access_code = 'AVXF77FC13CH70FXHC'; //Shared by CCAVENUES
//        $access_code = "AVYT86GF27CK86TYKC"; //Shared by CCAVENUES
//        foreach ($data as $key => $value){
//		$merchant_data.=$value.'|';
//	}
        $merchant_data= json_encode($data);
        
//        print_r($merchant_data);

        $encrypted_data = $this->encrypt($merchant_data, $working_key); // Method for encrypting the data.
        
//        $payload=array('enc_request'=>"$encrypted_data",
//            'access_code'=>'AVYT86GF27CK86TYKC',
//            'order_no'=>'APSR-15909-6714',
//            'command'=>'orderStatusTracker',
//            'request_type'=>'JSON',
//            'response_type'=>'JSON');
        $command="orderStatusTracker";
        $final_data ="request_type=JSON&access_code=AVYT86GF27CK86TYKC&command=orderStatusTracker&response_type=JSON&version=1.1&enc_request=".$encrypted_data;
        //attach encoded JSON string to the POST fields
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $final_data);

        curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        //** set the content type to application/json
		//  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

        //return response instead of outputting
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);	//* Execute the POST request
        echo($result);
        
        curl_close($ch);			//* Close cURL resource
    }
    
    public function encrypt($plainText, $key) {
        $secretKey = self::hextobin(md5($key));
        $initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
        $openMode = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', 'cbc', '');
        $blockSize = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, 'cbc');
        $plainPad = self::pkcs5_pad($plainText, $blockSize);
        
		if (mcrypt_generic_init($openMode, $secretKey, $initVector) != -1) {
            $encryptedText = mcrypt_generic($openMode, $plainPad);
            mcrypt_generic_deinit($openMode);
        }
        return bin2hex($encryptedText);
    }
    
	
    public function pkcs5_pad($plainText, $blockSize) {
		$pad = $blockSize - (strlen($plainText) % $blockSize);
	 	return $plainText . str_repeat(chr($pad), $pad);
	}
	

	//********** Hexadecimal to Binary function for php 4.0 version ********
	public function hextobin($hexString) {
		$length = strlen($hexString);
	 	$binString = "";
		$count = 0;
		
		while ($count < $length)
		{
			$subString = substr($hexString, $count, 2);
			$packedString = pack("H*", $subString);
			if ($count == 0) {
				$binString = $packedString;
			} else {
				$binString.=$packedString;
			}
			$count+=2;
		}
		return $binString;
	}

}
