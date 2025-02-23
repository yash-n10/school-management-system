<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Offline_payment extends CI_Controller {
    
    public $page_code = 'fee_collect';
    public $page_id = '';
    public $page_perm = '----';
    
    public function __construct() {
        parent::__construct();

//        error_reporting(-1);
//        ini_set('display_errors', TRUE);
//        $this->db->db_debug=TRUE;
        
         $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");

        $this->id = $this->session->userdata('school_id');
        $this->school_desc = $this->dbconnection->select("school", "*", "id=" . $this->id . " and status = 1");

        if ($this->school_desc[0]->fee_type1 == 1) {
            $this->fee_cat1 = 2;
        } else {
            $this->fee_cat1 = 5;
        }

        if ($this->school_desc[0]->fee_type2 == 3) {
            $this->fee_cat2 = 4;
        } else {
            $this->fee_cat2 = 1;
        }
        $this->bank_name = $this->dbconnection->select("bank", "bank_code", "");

        if ($this->id != 0) {
            $this->db->db_select('crmfeesclub_' . $this->id);
        }
        
        $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y' and active='Y'");
        $fetch_startyr = isset($this->academic_session[0]->start_date) ? explode('-', $this->academic_session[0]->start_date) : array('0');
        $this->session_start_yr = reset($fetch_startyr);
        $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
        $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
        $this->right_access = $this->page_perm;

        if (strpos($this->page_perm, '----') == true) {
            redirect(base_url(''), 'refresh');
        }
        $this->page_title = 'Fee Collect';
        $this->section = 'feepayment/collection';
        $this->page_name = 'offline_payment_upload';
        $this->customview = '';
    }

    public function index($msg = 'yes', $validation = '') {
        if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        
        if($this->school_desc[0]->school_group=='ARMY') {
            
            redirect(base_url('feepayment/collection/Offline_payment_army'));
            die();
        }
        //  if($this->id==29) 
        // {
        //     redirect(base_url('feepayment/collection/Offline_payment_previous'));
        //     die();
        // }
        $this->data['message'] = '';
        $this->data['aclass'] = $this->dbconnection->select("class", "id,class_name", "status='Y'");
        $this->data['asection'] = $this->dbconnection->select("section", "id,sec_name", "status='Y'");
        $this->data['page_name'] = $this->page_name;
        $this->data['page_title'] = $this->page_title;
        $this->data['section'] = $this->section;
        $this->data['customview'] = $this->customview;
        $this->data['right_access'] = $this->right_access;

        $this->data['token'] = $msg;

        $this->load->view('index', $this->data);
    }

    public function get_admsn_no() {

        $stud_qry = $this->dbconnection->select_order('student', 'id,admission_no,CONCAT(first_name," ",middle_name," ",last_name) as name', 'class_id=' . $this->input->post('class') . ' and section_id=' . $this->input->post('section') . ' and status = "Y"  ', 'name', 'ASC');
        $return = '';
        $return .= '<select class="form-control" id="fee_admission_no1" name="fee_admission_no">';
        $return .= "<option value=''>- Select Student -</option>";
        foreach ($stud_qry as $row) {

            $return .= "<option value='" . $row->admission_no . "'>" . $row->name . "</option>";
        }
        $return .= '</select>';
        echo $return;
    }

    public function load_student_fee_div() {


        $dataload = $this->input->post('dataload');
        if ($dataload == 'class') {
            $class = $this->input->post('class');
            $section = $this->input->post('section');
            $admsn = $this->input->post('admsn');
        } else {
            $admsn = $this->input->post('admsn_wise');
        }

        $month = array(1 => "April", 2 => "May", 3 => "June", 4 => "July", 5 => "Aug", 6 => "Sep", 7 => "Oct", 8 => "Nov", 9 => "Dec", 10 => "Jan", 11 => "Feb", 12 => "Mar");
        $fetch_stud = $this->dbconnection->select("student", "id,transport_amt,CONCAT(first_name,' ',middle_name,' ',last_name) as name,course_id,father_name,dob,stud_category,(select cat_name from category where id=stud_category) as category_name,phone,email_address,class_id,section_id,student_academicyear_id,(select session from accedemic_session where id=student_academicyear_id) as session,start_fee_month,student_type", " admission_no='$admsn' and status='Y'");

        if ($dataload == 'admsn') {
            $class = !empty($fetch_stud) ? $fetch_stud[0]->class_id : 0;
            $section = !empty($fetch_stud) ? $fetch_stud[0]->section_id : 0;
        }
        $course_id = !empty($fetch_stud) ? $fetch_stud[0]->course_id : 0;
        $stud_category = !empty($fetch_stud) ? $fetch_stud[0]->stud_category : 0;
        $stud_id = $fetch_stud[0]->id;
        $stud_acedemic_session_id = !empty($fetch_stud) ? $fetch_stud[0]->student_academicyear_id : 0;
        $stud_acedemic_session = !empty($fetch_stud) ? $fetch_stud[0]->session : 0;
        $start_fee_month=$fetch_stud[0]->start_fee_month;
//            $max_year = $this->dbconnection->select('accedemic_session', 'max(id) as max_year','active="Y" and status="Y"');
        $year = $this->academic_session[0]->fin_year;

        $fee_session_query = $this->dbconnection->select("class_fee_head", "max(year) as accd_session, max(id) as max_id", "(from_class_id<=$class and to_class_id>=$class) and course=" . $course_id . " and status='Y' and year<=$this->session_start_yr");
        $fee_session_year = $fee_session_query[0]->accd_session;
        $max_class_fee_id = $fee_session_query[0]->max_id;

//            $fetch_fees_head = $this->dbconnection->select("class_fee_head", "id", "(from_class_id<=$class and to_class_id>=$class) and year=$fee_session_year and status='Y' and course=" .$course_id );
        $class_fee_head_id = 0;
//            if (count($fetch_fees_head) > 0) {
        if ($max_class_fee_id != NULL || $max_class_fee_id != '') {
            $class_fee_head_id = $max_class_fee_id;
            
            
            /* -------------------------------   OneTime  ----------------------------- */
                
            $onetime_fee = $this->db->query('SELECT fee_amount,'
                . '(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name,fee_cat '
                . 'FROM class_fee_det where fee_cat in (9,10) and stud_cat=' . $stud_category . ' and'
                . ' class_fee_head_id=' . $max_class_fee_id . ' and status=1'); 
            $onetime_fee_paid = $this->db->query('SELECT * from fee_transaction_det where fee_trans_head_id in( select id from fee_transaction_head where year=' . $year . ' and student_id=' . $fetch_stud[0]->id . ' and paid_status=1 and status=1) and fee_cat_id in (9,10)')->result();
            /* ------------------------------------------------------------------------------------ */

            /* -------------------------------  Monthly or Quarterly ----------------------------- */


            $fetch_fees_mon_quar = $this->dbconnection->select("class_fee_det as fee", "fee.id,fee.fee_id,fee.fee_amount, (Select fee_name from fee_master where id=fee.fee_id) as fee_desc", "fee.class_fee_head_id=" . $max_class_fee_id . " and fee_cat=$this->fee_cat1 and status=1 and stud_cat=" . $stud_category);

//                        $qpm=$this->dbconnection->select("fee_trans_det","sum(month_no) cnt_paid","fee_trans_head_id in(select id from fee_trans_head where year=$year and student_id=".$fetch_stud[0]->id ." and paid_status=1) and fee_cat_id=$this->fee_cat1");
//                        $qpm=$this->dbconnection->select_join('fee_trans_head a','a.paid_status,a.remarks,a.receipt_no',"a.year=$year and a.student_id=".$fetch_stud[0]->id ." and a.paid_status=1 and b.fee_cat_id=".$this->fee_cat2,"fee_trans_det b"," a.id=b.fee_trans_head_id","inner");
            $qpm = $this->dbconnection->select("fee_transaction_det", "count(month_no) cnt_paid", "fee_trans_head_id in(select id from fee_transaction_head where year=$year and student_id=" . $fetch_stud[0]->id . " and paid_status=1 and response_code=0 and status=1) and fee_cat_id=$this->fee_cat1");
//                        $qpm=$this->dbconnection->select("fee_trans_det","sum(month_no) cnt_paid","year=$year and student_id=".$fetch_stud[0]->id ." and paid_status=1 and fee_cat_id=$this->fee_cat1");
            $paid_month = $qpm[0]->cnt_paid;
            
            $chqqpm = $this->dbconnection->select("fee_transaction_det", "count(month_no) cnt_paid", "fee_trans_head_id in(select id from fee_transaction_head where year=$year and student_id=" . $fetch_stud[0]->id . " and paid_status=2 and response_code=0 and status=1) and fee_cat_id=2");
//                        $qpm=$this->dbconnection->select("fee_trans_det","sum(month_no) cnt_paid","year=$year and student_id=".$fetch_stud[0]->id ." and paid_status=1 and fee_cat_id=$this->fee_cat1");
            $chqpaid_month = $chqqpm[0]->cnt_paid;
//                        if(count($mon_quar_fee_paid)>0)
//                        {
//                            $paid_status1=1;
//                             
//                            $remark1=$mon_quar_fee_paid[0]->remarks;
//                            $receipt_no1=$mon_quar_fee_paid[0]->receipt_no;
//                        }
//                        else 
//                        {
//                            $paid_status1=0;
//                            $remark1='';
//                            $receipt_no1='';
//                        }

            /* ------------------------------------------------------------------------------------ */

            /* -------------------------------  Half-Yearly or Annual ----------------------------- */
            $fetch_fees_half_ann = $this->dbconnection->select("class_fee_det as fee", "fee.id,fee.fee_id,fee.fee_amount, (Select fee_name from fee_master where id=fee.fee_id) as fee_desc,(Select month_set from fee_master where id=fee.fee_id) as month_set", "fee.class_fee_head_id=" . $max_class_fee_id . " and fee_cat=$this->fee_cat2 and status=1 and stud_cat=" . $stud_category);
            $half_ann_fee_paid = $this->dbconnection->select_join('fee_transaction_head a', 'a.paid_status,a.remarks,a.receipt_no', "a.year=$year and a.student_id=" . $fetch_stud[0]->id . " and a.paid_status=1 and a.status=1 and b.fee_cat_id=" . $this->fee_cat2, "fee_transaction_det b", " a.id=b.fee_trans_head_id", "inner");
//            $half_ann_fee_paid = $this->dbconnection->select("fee_trans_det", "paid_status,receipt_no,remarks", "year=$year and student_id=" . $fetch_stud[0]->id . " and paid_status=1 and fee_cat_id=$this->fee_cat2");
//            $half_ann_fee_paid = $this->dbconnection->select("fee_transaction_det", "paid_status,receipt_no,remarks,response_message", "fee_trans_head_id in(select id from fee_transaction_head where year=$year and student_id=" . $fetch_stud[0]->id . " and paid_status=1 and response_code=0) and fee_cat_id=$this->fee_cat2");
//                        $half_ann_fee_paid=$this->dbconnection->select("fee_trans_head","paid_status,remarks,receipt_no","year=$year and student_id=".$fetch_stud[0]->id ." and paid_status=1");
            if (count($half_ann_fee_paid) > 0) {
                $paid_status2 = count($half_ann_fee_paid);

                $remark2 = $half_ann_fee_paid[0]->remarks;
                $receipt_no2 = $half_ann_fee_paid[0]->receipt_no;
            } else {
                $paid_status2 = 0;
                $remark2 = '';
                $receipt_no2 = '';
            }

            if (count($onetime_fee_paid) > 0) {
                $paid_status3 = 1;

            }

            else {
                $paid_status3 = 0;
            }


            /* -------------------------------  Other fees ----------------------------- */
            $fetch_other_fees_det_month = $this->db->query('SELECT cd.*,cd.fee_amount,fm.fee_name as fee_desc,fm.month_set FROM class_fee_det cd inner join fee_master fm on fm.id=cd.fee_id'
                . ' where cd.fee_cat=3 and cd.class_fee_head_id='. $max_class_fee_id . ' and cd.status=1 and cd.fee_amount!=0 and (fm.month_set= "" OR fm.month_set IS NULL) ')->result();
            $fetch_other_fees_det = $this->dbconnection->select("class_fee_det as fee", "fee.*, (Select fee_name from fee_master where id=fee.fee_id) as fee_desc,(Select month_set from fee_master where id=fee.fee_id) as month_set", "fee.class_fee_head_id=" . $max_class_fee_id . " and fee_cat=3 and fee_amount!='0' and status=1");
            $fetch_instant_fees_det = $this->dbconnection->select("student_other_fee as fee", "fee.*, (Select fee_name from fee_master where id=fee.fee_id) as fee_desc", "fee.student_id=" . $stud_id . " and year=$year and paid_status!=1 and status='Y'");
            $fetch_instant_fees_det1 = $this->dbconnection->select("student_other_fee as fee", "fee.*, (Select fee_name from fee_master where id=fee.fee_id) as fee_desc", "fee.student_id=" . $stud_id . " and year=$year  and status='Y'");
//            $fetch_other_fees_det_month = $this->dbconnection->select("class_fee_det as fee", "fee.*, (Select fee_name from fee_master where id=fee.fee_id) as fee_desc,(Select month_set from fee_master where id=fee.fee_id) as month_set", "fee.class_fee_head_id=" . $max_class_fee_id . " and fee_cat=3 and fee_amount!='0' and status=1");
        } else {
            $fetch_fees_mon_quar = array();
            $paid_month = 0;
            $chqpaid_month = 0;


            $fetch_fees_half_ann = array();
            $paid_status2 = 0;
            $remark2 = '';
            $receipt_no2 = '';

            $fetch_other_fees_det = array();
            $fetch_other_fees_det_month = array();
            $fetch_instant_fees_det = array();
            $fetch_instant_fees_det1 = array();
        }


        /* --------------------------------------  Transaction History  ------------------------------- */
        $t = 0;
        $fee_trans_head_id = array();
        $fe_descrip = array();
        $description = array();
        $amount = array();
        $transaction_id = array();
        $payment_id = array();
        $payment_date = array();
        $remarks = array();
        $response_message = array();
        $receipt_no = array();
        $collection_centre = array();
        $paid_status = array();
        $charge_back = array();
        $response_code = array();
        $bank_name = array();
        $mode = array();
        $transaction_history = $this->db->query("select f1.*,group_concat(distinct(f2.fee_cat_id)) as fee,"
                . " count(case when f2.month_no<>0 and f2.fee_cat_id=2 then f2.month_no end) as m,min(case when f2.month_no<>0 and f2.fee_cat_id=2 then f2.month_no end) as from_month,"
                . " max(f2.due_month_no) as d from fee_transaction_head f1, fee_transaction_det f2 where f1.student_id=" . $stud_id
                . " and f1.year=$year and f1.status=1 and f1.response_message is not NULL and f1.id=f2.fee_trans_head_id group by f1.id");
        $fetch_transaction_history = $transaction_history->result();
        foreach ($fetch_transaction_history as $payment) {


            $fe_desc = explode(',', $payment->fee);
            $str = '';
            foreach ($fe_desc as $index => $value) {
                if ($value == 2) {
                    if ($payment->m > 1) {

                        $month_var = $payment->from_month + $payment->m - 1;
                        $str .= $payment->m . " Months Fees (" . $month[$payment->from_month] . " to " . $month[$month_var] . "),";
                    } else {
                        $str .= $payment->m . " Month Fees (" . $month[$payment->from_month] . "),";
                    }
                } 
                else if ($value == 1) {
                    $str .= ' Annual Fees,';
                } else if ($value == 9) {
                    $str .= ' Onetime Fees,';
                } else if ($value == 3) {
                    $str .= ' Other/Additional Fees,';
                } else if ($value == 8) {
                    $str .= ' Instant/Misc. Fees,';
                } else if ($value == 4) {
                    $str .= ' Half-Yearly Fees,';
                } else if ($value == 6) {
                    $str .= ' Transport Fees,';
                } else if ($value == 0) {
                    if ($payment->d > 1) {
                        $str .= ' ' . $payment->d . ' Months Fine,';
                    } else {
                        $str .= ' ' . $payment->d . ' Month Fine,';
                    }
                } else if ($value == 11) {
                    
                    $str .= 'Re-Admission-Fine,';
                   
                } else if ($value == 7) {
                    $str .= ' Instant Discount,';
                }
            }

            $fe_descrip[$t] = $fe_desc;
            $str = rtrim($str, ',');
            $fee_trans_head_id[$t] = $payment->id;
            $description[$t] = $str;
            $amount[$t] = $payment->total_amount;
            $transaction_id[$t] = $payment->transaction_id;
            $payment_id[$t] = $payment->payment_id;
            $payment_date[$t] = $payment->payment_date;
            $remarks[$t] = $payment->remarks;
            $response_message[$t] = $payment->response_message;
            $receipt_no[$t] = $payment->receipt_no;
            $collection_centre[$t] = $payment->collection_centre;
            $paid_status[$t] = $payment->paid_status;
            $charge_back[$t] = $payment->chargeback_status;
            $response_code[$t] = $payment->response_code;
            $mode[$t] = $payment->mode;
            $bank_name[$t] = $payment->bank_name;
            $t++;
        }


        /* --------------- Late Fine ----------------- */

        $count_due = 0;
        $pm = $paid_month + 1;
        $curr_month = date('m');
        $day = date('d'); 
//        $day =25;
        if ($curr_month >= 1 && $curr_month <= 3) {
            $curr_month = $curr_month + 9;
        } else {
            $curr_month = $curr_month - 3;
        }
        
        $fine_rule = $this->dbconnection->select("fine_rule", "count(id) cnt,max(due_month) mdue_month");
        $fine_rule_fetch = array();
        $due_month = $curr_month - $paid_month - 1;
//        if ($day > $this->school_desc[0]->last_pay_date) {
//            $due_month = $curr_month - $paid_month;
////            if ($due_month == 0 && $this->session->userdata('school_id') == 25) {
////                $due_month = 0.5;
////            } elseif ($this->session->userdata('school_id') == 24 || $this->session->userdata('school_id') == 25) {
////                $due_month = $due_month + 1;
////            }
//            
//            
////                if($this->session->userdata('school_id')==24) {
////        //        if($day>$this->school[0]->last_pay_date) {
////                    $due_month=$due_month+1;
////                }
//        } else {
//            $due_month = $curr_month - $paid_month - 1;
//            
//        } 
        $original_due_month=$due_month;
        if ($fine_rule[0]->cnt != 0) {
                if ($fine_rule[0]->mdue_month < $due_month) {
                    $fine_rule_fetch = $this->dbconnection->select("fine_rule", "max_day,remain", "due_month={$fine_rule[0]->mdue_month} and from_day>=$day and to_day<=$day");
                    if ($day > $this->school[0]->last_pay_date)
                        $due_month = $due_month + 1;
                }else {
                    $fine_rule_fetch = $this->dbconnection->select("fine_rule", "max_day,remain", "due_month=$due_month and from_day<=$day and to_day>=$day");
                    $due_month = !empty($fine_rule_fetch) ? $fine_rule_fetch[0]->max_day : $due_month;
                }
        }
        
        $due_month_corrected_condn = !empty($fine_rule_fetch) ? $fine_rule_fetch[0]->remain : '=';
        
        $fine_amount = 0;
        $fine_month = 0;
        $rule_array=array('='=>1,'>'=>2,'>='=>3,'<'=>4,'<='=>5);
        $readmsnfineamt=0;
        if ($due_month > 0) {
            
            $fine_month = $due_month;
            if ($this->session->userdata('school_id')==5) {
                $f=$fine_month;
                $skip_month=0;
                if (empty($fine_rule_fetch)) {

                    $quer_fine=$this->db->query("select sum(fee_amount) fee_amount from class_fee_det where class_fee_head_id=$max_class_fee_id and status=1 "
                            . "and stud_cat=0 and fee_cat=0 and no_of_months>'$skip_month' and id <=(select id from class_fee_det where class_fee_head_id=$max_class_fee_id and status=1 and stud_cat=0 and fee_cat=0 "
                            . "and ( fine_condition=1 and no_of_months='$f') or ( fine_condition=2 and no_of_months < '$f' and `no_of_months`-1>'$f')"
                            . "or ( fine_condition=3 and no_of_months <= '$f') or ( fine_condition=4 and no_of_months >'$f')"
                            . "or ( fine_condition=5 and no_of_months >='$f' and `no_of_months`-1<='$f'))")->result();
                } else {
                    $quer_fine=$this->db->query("select sum(fee_amount) fee_amount from class_fee_det where class_fee_head_id=$max_class_fee_id and status=1 "
                            . "and stud_cat=0 and fee_cat=0 and no_of_months>'$skip_month' and id <=(select id from class_fee_det where class_fee_head_id=$max_class_fee_id and status=1 and stud_cat=0 and fee_cat=0 "
                            . "and ( fine_condition={$rule_array["$due_month_corrected_condn"]} and no_of_months='$f'))")->result();

                }
                if (count($quer_fine) > 0) {
                    $fine_amount = $fine_amount+$quer_fine[0]->fee_amount;
                }
            }else{
                if (empty($fine_rule_fetch)) {

                            $quer_fine = $this->dbconnection->select("class_fee_det", "fee_amount", 'class_fee_head_id=' . $max_class_fee_id . ' and status=1 and stud_cat=0 and fee_cat=0 and '
                                    . ' (( fine_condition=1 and no_of_months="' . $due_month . '") or ( fine_condition=2 and no_of_months <"' . $due_month . '" and `no_of_months`-1>"' . $due_month . '") '
                                    . ' or ( fine_condition=3 and no_of_months <= "' . $due_month . '") '
                                    . ' or ( fine_condition=4 and no_of_months > "' . $due_month . '") '
                                    . ' or ( fine_condition=5 and no_of_months >= "' . $due_month . '" and `no_of_months`-1<="' . $due_month . '"))', '', '', '1');



                } else {
                    $quer_fine = $this->dbconnection->select("class_fee_det", "fee_amount", 'class_fee_head_id=' . $max_class_fee_id . ' and status=1 and stud_cat=0 and fee_cat=0 and '
                            . ' ( fine_condition='.$rule_array["$due_month_corrected_condn"].' and no_of_months="' . $due_month . '")', '', '', '1');
    //                print_r($quer_fine);
                }
    //            $quer_fine = $this->dbconnection->select("class_fee_det", "fee_amount", 'class_fee_head_id=' . $max_class_fee_id . ' and status=1 and stud_cat=0 and fee_cat=0 and '
    //                    . ' (( fine_condition=1 and no_of_months=' . $due_month . ') or ( fine_condition=2 and no_of_months<' . $due_month . ') '
    //                    . ' or ( fine_condition=3 and no_of_months <= ' . $due_month . ') '
    //                    . ' or ( fine_condition=4 and no_of_months > ' . $due_month . ') '
    //                    . ' or ( fine_condition=5 and no_of_months >= ' . $due_month . '))');

                if (count($quer_fine) > 0) {
                    $fine_amount = $quer_fine[0]->fee_amount;
                }
            }
//            echo $fine_amount;
            $readmsnfine=$this->dbconnection->select("class_fee_det","fee_amount","class_fee_head_id=$max_class_fee_id and status=1 and fee_cat=11 and stud_cat=0 and no_of_months<=$due_month");
            if(!empty($readmsnfine)) {
                $readmsnfineamt=$readmsnfine[0]->fee_amount;
            }
        }


        $collection_center_qry = $this->dbconnection->select("collection_center", "id,collection_code,collection_desc", "status='Y'");




        $collection_center_qry_counter1 = $this->dbconnection->select("collection_center", "id,collection_code,collection_desc", "status='Y' and id=4");

        $collection_center_qry_counter2 = $this->dbconnection->select("collection_center", "id,collection_code,collection_desc", "status='Y' and id=5");

        $collection_center_qry_counter3 = $this->dbconnection->select("collection_center", "id,collection_code,collection_desc", "status='Y' and id=6");

        $collection_center_qry_old = $this->dbconnection->select("collection_center", "collection_code", "status='Y' and id=3");
        $olddd=$collection_center_qry_old[0]->collection_code;

        $data = array(
            'student_id' => $stud_id,
            'admission_no' => $admsn,
            'student_name' => !empty($fetch_stud) ? $fetch_stud[0]->name : '',
            'student_type' => !empty($fetch_stud) ? $fetch_stud[0]->student_type : '',
            'father_name' => !empty($fetch_stud) ? $fetch_stud[0]->father_name : '',
            'dob' => !empty($fetch_stud) ? $fetch_stud[0]->dob : '',
            'category_id' => !empty($fetch_stud) ? $fetch_stud[0]->stud_category : 0,
            'category_name' => !empty($fetch_stud) ? $fetch_stud[0]->category_name : '',
            'course_id' => !empty($fetch_stud) ? $fetch_stud[0]->course_id : 0,
            'class_id' => $class,
            'section_id' => $section,
            'stud_acedemic_session_id' => $stud_acedemic_session_id,
            'stud_acedemic_session' => $stud_acedemic_session,
            'active_acedemic_session' => $this->academic_session,
            'class_fee_head_id' => $class_fee_head_id,
            'class' => $this->dbconnection->Get_namme("class", "id", "$class", "class_name"),
            'section' => $this->dbconnection->Get_namme("section", "id", "$section", "sec_name"),
            'course' => $this->dbconnection->Get_namme("course", "id", "$course_id", "course_name"),
            'phone' => !empty($fetch_stud) ? $fetch_stud[0]->phone : '',
            'email_address' => !empty($fetch_stud) ? $fetch_stud[0]->email_address : '',
            'fee_type1' => $this->school_desc[0]->fee_type1,
            'fee_type2' => $this->school_desc[0]->fee_type2,
            'onetime_avai' =>$this->school_desc[0]->onetime,
            'school_group' =>$this->school_desc[0]->school_group,
            'paid_month' => $paid_month,
            'chqpaid_month' => $chqpaid_month,
            'onetime_fee' => $onetime_fee,
            'onetime_fee_paid' => $onetime_fee_paid,
            'month' => $month,
            'fees1' => $fetch_fees_mon_quar,
            'fees2' => $fetch_fees_half_ann,
            'paid_status2' => $paid_status2,
            'paid_status3' => $paid_status3,
            'remark2' => $remark2,
            'receipt_no2' => $receipt_no2,
            'other_fees' => $fetch_other_fees_det,
            'fetch_other_fees_det_withoutmonth' => $fetch_other_fees_det_month,
            'fetch_instant_fees_det' => $fetch_instant_fees_det,
            'fetch_instant_fees_det1' => $fetch_instant_fees_det1,
            'fee_trans_head_id' => $fee_trans_head_id,
            'description' => $description,
            'transaction_id' => $transaction_id,
            'payment_id' => $payment_id,
            'payment_date' => $payment_date,
            'remarks' => $remarks,
            'response_message' => $response_message,
            'receipt_no' => $receipt_no,
            'collection_centre' => $collection_centre,
            'mode' => $mode,
            'bank_name' => $bank_name,
            'paid_status' => $paid_status,
            'response_code' => $response_code,
            'charge_back' => $charge_back,
            'amount' => $amount,
            'cntt' => $t,
            'original_due_month' => $original_due_month,
            'fine_month' => $fine_month,
            'fine_amount' => $fine_amount,
            'readmsnfineamt' => $readmsnfineamt,
            'fee_session_year' => $fee_session_year,
            'collection_centers' => $collection_center_qry,
            'collection_centers_c1' => $collection_center_qry_counter1,
            'collection_centers_c2' => $collection_center_qry_counter2,
            'collection_centers_c3' => $collection_center_qry_counter3,
            'olddd' => $olddd,
            'bank_list' => $this->bank_name,
            'dataload' => $dataload,
            'right_access' => $this->right_access,
            'transport_fee_amt' => !empty($fetch_stud) ? $fetch_stud[0]->transport_amt : 0
        );
        if($this->session->userdata('school_id')==5)
        {
            $this->load->view('feepayment/collection/load_fee_collection_vv', $data);
        }
        else{
            $this->load->view('feepayment/collection/load_fee_collection', $data);
        }

        // $this->load->view('feepayment/collection/load_fee_collection', $data);
    }

    public function get_fine_amount() {
//            error_reporting(-1);
//		ini_set('display_errors', 1);
        $max_class_fee_id = $this->input->post('class_fee_head_id');
        $due_month = $this->input->post('fine_month_no');
        $actual_due_month = $this->input->post('fine_month');
        $original_due_month = $this->input->post('original_due_month');
        $checkmonth = $this->input->post('checkmonth');
        $fee_session_year = $this->input->post('fee_session_year');
        $class = $this->input->post('class');
        $course = $this->input->post('course');
        list($year, $month, $day) = explode('-', date('Y-m-d'));
        if ($month >= 1 && $month <= 3) {
            $month = $month + 12;
        }
        $fine_amount = 0;
//            if($this->session->userdata('school_id')==24 && $day>$this->school_desc[0]->last_pay_date && $checkmonth>=($month - 3)) {
//    //        if($day>$this->school[0]->last_pay_date && $total_check_month>=($month - 3)) {
//                $due_month=$due_month+1;
//            }
        if ($day > $this->school_desc[0]->last_pay_date && $checkmonth >= ($month - 3)  && $due_month!=0) {
//            if ($due_month == 0 && $this->session->userdata('school_id') == 25) {
//                $due_month = 0.5;
//            } elseif ($this->session->userdata('school_id') == 25 || $this->session->userdata('school_id') == 24) {
//                $due_month = $due_month + 1;
//            }
        }
        $due_month_corrected = $due_month;
        $fine_rule = $this->dbconnection->select("fine_rule", "count(id) cnt,max(due_month) mdue_month");
        $fine_rule_fetch = array();
        if ($fine_rule[0]->cnt != 0 ) {
            if ($fine_rule[0]->mdue_month < $due_month) {
                $fine_rule_fetch = $this->dbconnection->select("fine_rule", "max_day,remain", "due_month={$fine_rule[0]->mdue_month} and from_day>=$day and to_day<=$day");
//                if ($day > $this->school[0]->last_pay_date)
//                    $due_month_corrected = $due_month + 1;
            }else {
                $fine_rule_fetch = $this->dbconnection->select("fine_rule", "max_day,remain", "due_month=$due_month and from_day<=$day and to_day>=$day");
                $due_month_corrected = !empty($fine_rule_fetch) && !empty($fine_rule_fetch[0]->max_day) ? $fine_rule_fetch[0]->max_day : $due_month;
            }
        }
        $due_month_corrected_condn = !empty($fine_rule_fetch) && !empty($fine_rule_fetch[0]->max_day) ? $fine_rule_fetch[0]->remain : '=';
        if (empty($fine_rule_fetch)) {
            $due_month_corrected_condn1='=';$due_month_corrected_condn2='<';$due_month_corrected_condn3='<=';$due_month_corrected_condn4='>';$due_month_corrected_condn5='>=';                        
        } else {                       
            $due_month_corrected_condn1=$due_month_corrected_condn2=$due_month_corrected_condn3=$due_month_corrected_condn4=$due_month_corrected_condn5=$due_month_corrected_condn;
        }
//        echo $due_month_corrected.$due_month_corrected_condn;
        $rule_array=array('='=>1,'>'=>2,'>='=>3,'<'=>4,'<='=>5);
        if ($due_month_corrected > 0) {
            if ($this->session->userdata('school_id')==5) {
                $f=$original_due_month;                
                $skip_month=$original_due_month - $due_month;
               
                if (empty($fine_rule_fetch)) {

                    $quer_fine=$this->db->query("select sum(fee_amount) fee_amount from class_fee_det where class_fee_head_id=$max_class_fee_id and status=1 "
                            . "and stud_cat=0 and fee_cat=0 and no_of_months>'$skip_month' and id <=(select id from class_fee_det where class_fee_head_id=$max_class_fee_id  and status=1 and stud_cat=0 and fee_cat=0 "
                            . "and ( fine_condition=1 and no_of_months='$f') or ( fine_condition=2 and no_of_months < '$f' and `no_of_months`-1>'$f')"
                            . "or ( fine_condition=3 and no_of_months <= '$f') or ( fine_condition=4 and no_of_months >'$f')"
                            . "or ( fine_condition=5 and no_of_months >='$f' and `no_of_months`-1<='$f'))")->result();
                } else {
                    $quer_fine=$this->db->query("select sum(fee_amount) fee_amount from class_fee_det where class_fee_head_id=$max_class_fee_id and status=1 "
                            . "and stud_cat=0 and fee_cat=0 and no_of_months>'$skip_month' and id <=(select id from class_fee_det where class_fee_head_id=$max_class_fee_id  and status=1 and stud_cat=0 and fee_cat=0 "
                            . "and ( fine_condition={$rule_array["$due_month_corrected_condn"]} and no_of_months='$f'))")->result();

                }
//                print_r($quer_fine);
                if (count($quer_fine) > 0) {
                    $fine_amount = $fine_amount+$quer_fine[0]->fee_amount;
                }
            }else{
                if ($this->school_desc[0]->fine_type_checkbox == 'ADJUSTABLE') {
                    $duemonthcancel = $actual_due_month - $due_month;
                    $quer_fine_actual = $this->dbconnection->select("class_fee_det", "fee_amount", 'class_fee_head_id in(select id from class_fee_head '
                            . ' where year=' . $fee_session_year
                            . ' and  (from_class_id <=' . $class . ' and  to_class_id >=' . $class
                            . ' and course=' . $course . ' and year<=' . $this->session_start_yr . ')) and status=1 and stud_cat=0 and fee_cat=0 and '
                            . ' (( fine_condition=1 and no_of_months=' . $actual_due_month . ') or ( fine_condition=2 and no_of_months<' . $actual_due_month . ') '
                            . ' or ( fine_condition=3 and no_of_months <= ' . $actual_due_month . ') '
                            . ' or ( fine_condition=4 and no_of_months > ' . $actual_due_month . ') '
                            . ' or ( fine_condition=5 and no_of_months >= ' . $actual_due_month . '))');

                    $quer_fine_cancel = $this->dbconnection->select("class_fee_det", "fee_amount", 'class_fee_head_id in(select id from class_fee_head '
                            . ' where year=' . $fee_session_year
                            . ' and  (from_class_id <=' . $class . ' and  to_class_id >=' . $class
                            . ' and course=' . $course . ' and year<=' . $this->session_start_yr . ')) and status=1 and stud_cat=0 and fee_cat=0 and '
                            . ' (( fine_condition=1 and no_of_months=' . $duemonthcancel . ') or ( fine_condition=2 and no_of_months<' . $duemonthcancel . ') '
                            . ' or ( fine_condition=3 and no_of_months <= ' . $duemonthcancel . ') '
                            . ' or ( fine_condition=4 and no_of_months > ' . $duemonthcancel . ') '
                            . ' or ( fine_condition=5 and no_of_months >= ' . $duemonthcancel . '))');
                    if (count($quer_fine_actual) > 0) {
                        if (count($quer_fine_cancel) > 0) {
                            $fine_amount = $quer_fine_actual[0]->fee_amount - $quer_fine_cancel[0]->fee_amount;
                        } else {
                            $fine_amount = $quer_fine_actual[0]->fee_amount;
                        }
                    }
                } elseif ($this->school_desc[0]->fine_type_checkbox == 'NOT_CHANGEABLE') {
                    $quer_fine_actual = $this->dbconnection->select("class_fee_det", "fee_amount", 'class_fee_head_id in(select id from class_fee_head '
                            . ' where year=' . $fee_session_year
                            . ' and  (from_class_id <=' . $class . ' and  to_class_id >=' . $class
                            . ' and course=' . $course . ' and year<=' . $this->session_start_yr . ')) and status=1 and stud_cat=0 and fee_cat=0 and '
                            . ' (( fine_condition=1 and no_of_months=' . $actual_due_month . ') or ( fine_condition=2 and no_of_months <' . $actual_due_month . ') '
                            . ' or ( fine_condition=3 and no_of_months <= ' . $actual_due_month . ') '
                            . ' or ( fine_condition=4 and no_of_months > ' . $actual_due_month . ') '
                            . ' or ( fine_condition=5 and no_of_months >= ' . $actual_due_month . '))');
                    if (count($quer_fine_actual) > 0) {
                        $fine_amount = $quer_fine_actual[0]->fee_amount;
                    }
                } else {
    //                $due_month=$due_month-1;
                    $quer_fine = $this->dbconnection->select("class_fee_det", "fee_amount", 'class_fee_head_id in(select id from class_fee_head '
                            . ' where year=' . $fee_session_year
                            . ' and  (from_class_id <=' . $class . ' and  to_class_id >=' . $class
                            . ' and course=' . $course . ' and year<=' . $this->session_start_yr . ')) and status=1 and stud_cat=0 and fee_cat=0 and '
                            . ' (( fine_condition=1 and no_of_months=' . $due_month . ') or ( fine_condition=2 and no_of_months <' . $due_month . ') '
                            . ' or ( fine_condition=3 and no_of_months <= ' . $due_month . ') '
                            . ' or ( fine_condition=4 and no_of_months > ' . $due_month . ') '
                            . ' or ( fine_condition=5 and no_of_months >= ' . $due_month . '))');
                    if (count($quer_fine) > 0) {
                        $fine_amount = $quer_fine[0]->fee_amount;
                    }
    //                if (empty($fine_rule_fetch)) {
    //                    $quer_fine = $this->dbconnection->select("class_fee_det", "fee_amount", 'class_fee_head_id=' . $max_class_fee_id . ' and status=1 and stud_cat=0 and fee_cat=0 and '
    //                        . ' (( fine_condition=1 and no_of_months'.$due_month_corrected_condn1.'"' . $due_month_corrected . '") or ( fine_condition=2 and no_of_months'.$due_month_corrected_condn2.'"' . $due_month_corrected . '") '
    //                        . ' or ( fine_condition=3 and no_of_months '.$due_month_corrected_condn3.'"' . $due_month_corrected . '") '
    //                        . ' or ( fine_condition=4 and no_of_months '.$due_month_corrected_condn4.'"' . $due_month_corrected . '") '
    //                        . ' or ( fine_condition=5 and no_of_months '.$due_month_corrected_condn5.'"' . $due_month_corrected . '"))');
    //                } else {
    //                    $quer_fine = $this->dbconnection->select("class_fee_det", "fee_amount", 'class_fee_head_id=' . $max_class_fee_id . ' and status=1 and stud_cat=0 and fee_cat=0 and '
    //                            . ' ( fine_condition='.$rule_array[$due_month_corrected_condn].' and no_of_months="' . $due_month_corrected . '")');
    //                } 
    ////                echo $due_month_corrected;
    ////                print_r($quer_fine);
    //                if (count($quer_fine) > 0) {
    //                    $fine_amount = $quer_fine[0]->fee_amount;
    //                }
                }
            }
        }

        echo $fine_amount;
    }
    
    
    public function get_halfother_amount() {
//        error_reporting(-1);
//        ini_set('display_errors', 1);
        $noofmonth=$this->input->post('month_no');
        $paid_month=$this->input->post('paid_month');
        $class_fee_head_id=$this->input->post('class_fee_head_id');
        $category_id=$this->input->post('category_id');
//        $fee_session_year=$this->input->post('fee_session_year');
        $student_id=$this->input->post('student_id');
        $oth_fee_id = array();
        $oth_fee_amount = array();
        $half_yearly_fee_id = array();
        $half_yearly_fee_amount = array();
        
        if ($this->fee_cat2 == 4) {
            $half_yearly_fee = $this->db->query('SELECT fee_id,fee_amount,'
                            . '(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name,(select SUBSTRING_INDEX(month_set,",",1) from fee_master where id=class_fee_det.fee_id) as first_half ,(select SUBSTRING_INDEX(month_set,",",-1) from fee_master where id=class_fee_det.fee_id) as second_half'
                            . ' FROM class_fee_det where fee_cat=4 and stud_cat=' . $category_id . ' and '
                            . 'class_fee_head_id=' . $class_fee_head_id . ' and status=1');
    //                    $half_yearly_month= array_column($half_yearly_fee->result_array(), 'month_set','id');
            $half_yearly_amount = array_column($half_yearly_fee->result_array(), 'fee_amount', 'fee_id');
            $half_yearly_first_half = array_column($half_yearly_fee->result_array(), 'first_half', 'fee_id');
            $half_yearly_second_half = array_column($half_yearly_fee->result_array(), 'second_half', 'fee_id');
            $year = $this->academic_session[0]->fin_year;
            $query_half_trans = $this->db->query('SELECT * from fee_transaction_det where fee_trans_head_id in( select id from fee_transaction_head where year=' . $year . ' and student_id=' . $student_id . ' and paid_status=1 and status=1) and fee_cat_id=4');
            $qhalfmonth = array_column($query_half_trans->result_array(), 'month_no', 'halfyearly_fee_id');
        }
        for ($i = $paid_month+1; $i <= $paid_month+$noofmonth; $i++) {
                    $othquery=$this->db->query("SELECT id,fee_name,month_set,(SELECT fee_amount FROM class_fee_det where fee_cat=3 and stud_cat=0 and class_fee_head_id=$class_fee_head_id and status=1 and fee_id=fee_master.id) fee_amount FROM `fee_master` WHERE fee_cat_id=3 and FIND_IN_SET('$i', month_set) and status=1 group by id")->result();
                    foreach ($othquery as $valueo) {
                        $oth_fee_id[$valueo->id] = $valueo->fee_name . ' ';
                        if (array_key_exists($valueo->id, $oth_fee_amount)) {
                            $o = $oth_fee_amount[$valueo->id] + $valueo->fee_amount;
                        } else {
                            $o = $valueo->fee_amount;
                        }

                        $oth_fee_amount[$valueo->id] = $o;
                    }
                    
                    
                    if ($this->fee_cat2 == 4) {
                    
                    $dbq = $this->db->query("SELECT id,fee_name,month_set,(SELECT fee_amount FROM class_fee_det where fee_cat=4 and stud_cat=$category_id and class_fee_head_id=$class_fee_head_id and status=1 and fee_id=fee_master.id) fee_amount FROM `fee_master` WHERE fee_cat_id=4 and FIND_IN_SET('$i', month_set) group by id having fee_amount!=0")->result();
//                    print_r($dbq);
                    foreach ($dbq as $value) {

                        if (empty($qhalfmonth[$value->id])) {

                            $half_yearly_fee_id[$value->id] = $value->fee_name . ' (Half Yearly)';
                            if (array_key_exists($value->id, $half_yearly_fee_amount)) {
                                $h = $half_yearly_fee_amount[$value->id] + $value->fee_amount;
                            } else {
                                $h = $value->fee_amount;
                            }

                            $half_yearly_fee_amount[$value->id] = $h;
                        } elseif (is_array($qhalfmonth[$value->id]) && !in_array($h, is_array($i, $qhalfmonth[$value->id]))) {
                            $half_yearly_fee_id[$value->id] = $value->fee_name . ' (Half Yearly)';
                            if (array_key_exists($value->id, $half_yearly_fee_amount)) {
                                $h = $half_yearly_fee_amount[$value->id] + $value->fee_amount;
                            } else {
                                $h = $value->fee_amount;
                            }

                            $half_yearly_fee_amount[$value->id] = $h;
                        } elseif ($i != $qhalfmonth[$value->id]) {
                            $half_yearly_fee_id[$value->id] = $value->fee_name . ' (Half Yearly)';
                            if (array_key_exists($value->id, $half_yearly_fee_amount)) {
                                $h = $half_yearly_fee_amount[$value->id] + $value->fee_amount;
                            } else {
                                $h = $value->fee_amount;
                            }

                            $half_yearly_fee_amount[$value->id] = $h;
                        }
                    }
                }
        }
        
        $table_html = '';
        if(count($half_yearly_fee_id)>0) {
            $total_fee_html=0;
            foreach ($half_yearly_fee_id as $hfeeid => $hvalue) {
                $total_fee_html = $total_fee_html + $half_yearly_fee_amount[$hfeeid];
                $table_html .= '<input type="hidden" readonly="true" style="border: 0px;width: 100%;background:inherit" name="half_yearly_fee[' . $hfeeid . ']" value="' . $half_yearly_fee_amount[$hfeeid] . '">';


            }
            $table_html .= '<td class="col-sm-1"><input type="checkbox" name="fee_head[4]" id="chk_4" value="4" checked style="pointer-events:none"></td>';
            $table_html .= '<td class="col-sm-3">Half-Yearly Fees</td>';
            $table_html .= '<td id="half_head" class="col-sm-4"></td>';           
            $table_html .= '<td class="col-sm-4"><input type="text" required class="form-control" name="fee_amt[4]" id="half-yearlyth" value="'.$total_fee_html.'" style="padding-right:1px;pointer-events: none;"  oninvalid="this.setCustomValidity(\'Please Select either 1st-Half or 2nd-Half or Both Option\')" oninput="setCustomValidity(\'\')" onchange="setCustomValidity(\'\')" ></td>';
        }
        
        
        $table_html1 = '';
        if(count($oth_fee_id)>0) {
            $total_fee_html1=0;
            foreach ($oth_fee_id as $ofeeid => $ovalue) {
                $total_fee_html1 = $total_fee_html1 + $oth_fee_amount[$ofeeid];
                $table_html1 .= '<input type="hidden"  style="border: 0px;width: 100%;background:inherit" name="other_chk[' . $ofeeid . ']" value="' . $oth_fee_amount[$ofeeid] . '">';
                
            }
            
            $table_html1 .= '<td class="col-sm-1"> <input type="checkbox" name="fee_head[3]" id="chk_3" value="3" checked style="pointer-events:none"></td>';
            $table_html1 .= '<td class="col-sm-3">Other Monthly Fees</td>';
            $table_html1 .= '<td class="col-sm-4"></td>';  
            $table_html1 .= '<td class="col-sm-4"><input type="text" class="form-control" value="'.$total_fee_html1.'" id="other_feetm" required name="fee_amt[3o]" style="padding-right:1px;pointer-events: none;" oninvalid="this.setCustomValidity(\'Please Select atleast one Other Fee Type\')" oninput="setCustomValidity(\'\')" onchange="setCustomValidity(\'\')"></td>';

        } 
        $data=array('table_html'=>$table_html,'table_html1'=>$table_html1);
        echo json_encode($data);
    }
    
    

    public function save_offln_payment_student_wise() {

        $no_of_month = 0;
//            $accedmic_sssion = $this->dbconnection->select('accedemic_session', 'max(id) as max_year',"active='Y' and status='Y'");
        $current_year = $this->academic_session[0]->fin_year;

        $school_code = $this->school_desc[0]->school_code;

        $inputall = $this->input->post();
        $payment_date = $inputall['payment_date'];
        $remarks = $inputall['remarks'];
        $final_total = str_replace("INR", "", $inputall['tot_amount']);
        $student_id = $inputall['student_id'];
        $admission_no = $inputall['admission_no'];
        $stud_category = $inputall['stud_cat'];
        $class_id = $inputall['class_id'];
        $class_fee_head_id = $inputall['class_fee_head_id'];
        $fee_session_year = $inputall['fee_session_year'];
        $course_id = $inputall['course_id'];

        $month_arr = array(1 => "April", 2 => "May", 3 => "June", 4 => "July", 5 => "Aug", 6 => "Sep", 7 => "Oct", 8 => "Nov", 9 => "Dec", 10 => "Jan", 11 => "Feb", 12 => "Mar");

//                        echo $student_id.' '.$admission_no.' '.$stud_category.' '.$class_fee_head_id;



        if (!empty($inputall['fee_head']) && $final_total != 0) {


            if ($inputall['automatic_receipt'] == 'YES') {

                $receipt_log = $this->dbconnection->select('receipt_log', 'max(recipt_no) as rec');

                $number = strlen($receipt_log[0]->rec);

                $str = '';
                for ($i = 1; $i <= (6 - $number); $i++) {
                    $str .= '0';
//                                                                             
                }

                $maxn = $str . ($receipt_log[0]->rec + 1);
                $receipt_no = 'OFLN' . $current_year . $school_code . $maxn;
            } else {
                $receipt_no = $inputall['receipt_no'];
                $maxn = '';
            }

//$inputall['fee_amt'][7]
            /* ---------- Saving Details to Fee Payment record table(fee_transaction_head)  --------- */
            if($inputall['mode_payment']=='CHEQUE')
            {
                if($inputall['cheque_status']=='Pending')
                {
                    $paid_status=2;
                }
                else if($inputall['cheque_status']=='Bounce')
                {
                    $paid_status=0;
                }
                else{
                    $paid_status=1;
                }                    
            }
            else
            {
                $paid_status=1;
            }
            
            $this->dbconnection->insert("fee_transaction_head", array('student_id' => $student_id, 'year' => $current_year,
            'total_amount' => $final_total, 'discount_amount' => $inputall['fee_amt'][7], 'paid_by' => $this->session->userdata('user_id'), 'payment_date' => date('Y-m-d H:i:s', strtotime($payment_date)),'remarks' => $remarks, 'mode' => $inputall['mode_payment'],
            'cheque_no'=>$inputall['cheque_no'],'cheque_date'=>$inputall['cheque_date'],'cheque_status'=>$inputall['cheque_status'],'pos_no'=>$inputall['pos_no'],
            'collection_centre' => $inputall['collection_center'], 'response_code' => 0, 'payment_method' => $inputall['mode_payment'],
            'response_message' => 'Payment Successful', 'paid_status' => $paid_status,'date_created'=>date('Y-m-d H:i:s'),
            'receipt_no' => $receipt_no, 'bank_name' => $inputall['bank_name'], 'created_by' => $this->session->userdata('user_id')));
            $fee_transac_id = $this->dbconnection->get_last_id();


            /* --------------------------------------------------------------------------------------- */

            if ($inputall['automatic_receipt'] == 'YES') {

                $data1 = array(
                    'fee_trans_id' => $fee_transac_id,
                    'recipt_no' => $maxn
                );
                $this->dbconnection->insert("receipt_log", $data1);
            }

            $description = "Offline Collection Total $final_total - AdmissionN0 $admission_no - Student ID $student_id of session $current_year";

            /* ---------- Saving Details to Fee Payment Action table(fee_transaction_action)  --------- */

            $this->dbconnection->insert("fee_transaction_action", array('fee_transaction_head_id' => $fee_transac_id, 'action_description' => 'Offline Collection',
                'created_by' => $this->session->userdata('user_id'), 'full_pymt_description' => $description));
            $fee_action_id = $this->dbconnection->get_last_id();

            /* --------------------------------------------------------------------------------------- */


            $paid_mon_query = $this->dbconnection->select('fee_transaction_det', 'count(month_no) as paid', 'fee_trans_head_id in( select id from fee_transaction_head where student_id=' . $student_id . ' and paid_status=1 and response_code=0 and status=1 and year=' . $current_year . ') and fee_cat_id=2');
            $total_month_paid = $paid_mon_query[0]->paid;
            foreach ($inputall['fee_head'] as $selected) {

                if($selected==9){
                    
                    $amount = $inputall['cal_list'][9];
                    $this->dbconnection->insert("fee_transaction_det", array('amount' => $amount, 'fee_cat_id' => 9,
                        'fee_trans_head_id' => $fee_transac_id, 'class_fee_head_id' => $class_fee_head_id, 'stud_category' => $stud_category,
                        'created_by' => $this->session->userdata('user_id')));
                    
                    $amount = $inputall['cal_list'][10];
                    $this->dbconnection->insert("fee_transaction_det", array('amount' => $amount, 'fee_cat_id' => 10,
                        'fee_trans_head_id' => $fee_transac_id, 'class_fee_head_id' => $class_fee_head_id, 'stud_category' => $stud_category,
                        'created_by' => $this->session->userdata('user_id')));
                    
                }
             
                if ($selected == 2) { //monthly
                    $amount = $inputall['fee_amt'][$selected];
                    $trans_fee_amt = $inputall['trans_fee_amt'];
                    $pm_month_no = $total_month_paid + 1;
                    $no_of_month = $inputall['noofmonth'];
                    if ($trans_fee_amt > 0) {
                        $amount = ($amount - $trans_fee_amt) / $no_of_month;
                    } else {
                        $amount = $amount / $no_of_month;
                    }
                    for ($m = 1; $m <= $no_of_month; $m++) {

                        $this->dbconnection->insert("fee_transaction_det", array('amount' => $amount, 'month_no' => $pm_month_no,
                            'fee_cat_id' => $selected, 'month_desc' => $month_arr[$pm_month_no], 'fee_trans_head_id' => $fee_transac_id,
                            'class_fee_head_id' => $class_fee_head_id, 'stud_category' => $stud_category, 'created_by' => $this->session->userdata('user_id')));

                        $pm_month_no++;
                    }
                    if ($trans_fee_amt > 0) {
                        $this->dbconnection->insert("fee_transaction_det", array('amount' => $trans_fee_amt, 'fee_cat_id' => 6,
                            'fee_trans_head_id' => $fee_transac_id, 'class_fee_head_id' => $class_fee_head_id, 'stud_category' => $stud_category,
                            'created_by' => $this->session->userdata('user_id')));
                    }
                } else if ($selected == 0) { //fine
                    $amount = $inputall['fee_amt'][$selected];
                    $due_month_no = $inputall['no_of_duemonth'];

                    if ($this->school_desc[0]->fine_monthly_segregation == 'YES') {

                        $due_month = $total_month_paid + 1;
                        $fine_arr = array();
                        array_push($fine_arr, "0");
                        $quer_fine = $this->dbconnection->select("class_fee_det", "fee_amount,no_of_months", 'class_fee_head_id in(select id from class_fee_head '
                                . ' where year=' . $fee_session_year
                                . ' and  (from_class_id <=' . $class_id . ' and  to_class_id >=' . $class_id
                                . ' and course=' . $course_id . ' and year<=' . $this->session_start_yr . ')) and status=1 and stud_cat=0 and fee_cat=0 ');
                        foreach ($quer_fine as $row) {
                            array_push($fine_arr, "$row->fee_amount");
                        }
//                            print_r($fine_arr);
                        for ($dm = $due_month_no; $dm >= 1; $dm--) {

                            $ist_index = $dm;
                            $scnd_index = $dm - 1;
                            $amount = $fine_arr[$ist_index] - $fine_arr[$scnd_index];
                            $this->dbconnection->insert("fee_transaction_det", array('amount' => $amount, 'fee_cat_id' => $selected,
                                'month_desc' => $month_arr[$due_month], 'fee_trans_head_id' => $fee_transac_id, 'due_month_no' => $dm,
                                'class_fee_head_id' => $class_fee_head_id, 'stud_category' => $stud_category, 'created_by' => $this->session->userdata('user_id')));
                            $due_month++;
                        }
                    } else {

                        $last_due_month = $total_month_paid + $due_month_no;
                        $init_month = $total_month_paid + 1;
                        $month_desc = "$month_arr[$init_month] to $month_arr[$last_due_month]";
                        $this->dbconnection->insert("fee_transaction_det", array('amount' => $amount, 'fee_cat_id' => $selected,
                            'month_desc' => $month_desc, 'fee_trans_head_id' => $fee_transac_id, 'due_month_no' => $due_month_no,
                            'class_fee_head_id' => $class_fee_head_id, 'stud_category' => $stud_category, 'created_by' => $this->session->userdata('user_id')));
                    }
                } else if ($selected == 3) {

                    if (!empty($inputall['other_chk'])) {
                        foreach ($inputall['other_chk'] as $othselected => $val) { //val is amount , selected is fee_cat_id, othrselected is fee_id .
//                                                            echo 'otht'.$othselected.'-'.$val.'  ';
                            $this->dbconnection->insert("fee_transaction_det", array('amount' => $val, 'fee_cat_id' => $selected,
                                'other_fee_id' => $othselected, 'fee_trans_head_id' => $fee_transac_id,
                                'class_fee_head_id' => $class_fee_head_id, 'stud_category' => $stud_category, 'created_by' => $this->session->userdata('user_id')));
                        }
                    }
                } else if ($selected == 8) {

                    if (!empty($inputall['instantfee_chk'])) {
                        foreach ($inputall['instantfee_chk'] as $k1=>$instselected) {
                            foreach ($instselected as $k2=>$v2) {//val is amount , selected is fee_cat_id, othrselected is fee_id .
//                                                            echo 'otht'.$othselected.'-'.$val.'  ';
                            $this->dbconnection->insert("fee_transaction_det", array('amount' => $v2, 'fee_cat_id' => $selected,
                                'other_fee_id' => $k2, 'fee_trans_head_id' => $fee_transac_id,
                                'class_fee_head_id' => $class_fee_head_id, 'stud_category' => $stud_category, 'created_by' => $this->session->userdata('user_id')));
                            
                            $this->dbconnection->update("student_other_fee",array('paid_status'=>1,'last_date_modified'=>date('Y-m-d H:i:s'),'modified_by'=>$this->session->userdata('user_id')),array('id'=>$k1));
                            }
                        }
                    }
                }else if ($selected == 4) {
                    $amount = $inputall['fee_amt'][$selected];
                    $half_yearly_fee = $this->db->query('SELECT fee_id,fee_amount,'
                            . '(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name,(select SUBSTRING_INDEX(month_set,",",1) from fee_master where id=class_fee_det.fee_id) as first_half ,(select SUBSTRING_INDEX(month_set,",",-1) from fee_master where id=class_fee_det.fee_id) as second_half'
                            . ' FROM class_fee_det where fee_cat=4 and stud_cat=' . $stud_category . ' and '
                            . 'class_fee_head_id=' . $class_fee_head_id . ' and status=1');
//                    $half_yearly_month= array_column($half_yearly_fee->result_array(), 'month_set','id');
                    $half_yearly_amount = array_column($half_yearly_fee->result_array(), 'fee_amount', 'fee_id');
                    $half_yearly_first_half = array_column($half_yearly_fee->result_array(), 'first_half', 'fee_id');
                    $half_yearly_second_half = array_column($half_yearly_fee->result_array(), 'second_half', 'fee_id');
                    $year = $this->academic_session[0]->fin_year;
                    $query_half_trans = $this->db->query('SELECT * from fee_transaction_det where fee_trans_head_id in( select id from fee_transaction_head where year=' . $year . ' and student_id=' . $student_id . ' and paid_status=1 and status=1) and fee_cat_id=4');
                    $qhalfmonth = array_column($query_half_trans->result_array(), 'month_no', 'halfyearly_fee_id');
                    foreach ($this->input->post('half_yearly_fee') as $key => $value) {

                        if ($value == $half_yearly_amount[$key] * 2) {
                            $this->dbconnection->insert("fee_transaction_det", array('amount' => $half_yearly_amount[$key],'month_no'=>$half_yearly_first_half[$key], 'fee_cat_id' => $selected,
                                'halfyearly_fee_id' => $key, 'fee_trans_head_id' => $fee_transac_id,
                                'class_fee_head_id' => $class_fee_head_id, 'stud_category' => $stud_category, 'created_by' => $this->session->userdata('user_id')));
                            $this->dbconnection->insert("fee_transaction_det", array('amount' => $half_yearly_amount[$key],'month_no'=>$half_yearly_second_half[$key], 'fee_cat_id' => $selected,
                                'halfyearly_fee_id' => $key, 'fee_trans_head_id' => $fee_transac_id,
                                'class_fee_head_id' => $class_fee_head_id, 'stud_category' => $stud_category, 'created_by' => $this->session->userdata('user_id')));
                        } else {
                            if (empty($qhalfmonth[$key]) || count($qhalfmonth[$key]) < 1) {
                                $m = $half_yearly_first_half[$key];
                            } else {
                                $m = $half_yearly_second_half[$key];
                            }                            
                            $this->dbconnection->insert("fee_transaction_det", array('amount' => $half_yearly_amount[$key],'month_no'=>$m, 'fee_cat_id' => $selected,
                                'halfyearly_fee_id' => $key, 'fee_trans_head_id' => $fee_transac_id,
                                'class_fee_head_id' => $class_fee_head_id, 'stud_category' => $stud_category, 'created_by' => $this->session->userdata('user_id')));
                        }
                    }
                    
                }else {
                    $amount = $inputall['fee_amt'][$selected];
                    $this->dbconnection->insert("fee_transaction_det", array('amount' => $amount, 'fee_cat_id' => $selected,
                        'fee_trans_head_id' => $fee_transac_id, 'class_fee_head_id' => $class_fee_head_id, 'stud_category' => $stud_category,
                        'created_by' => $this->session->userdata('user_id')));
                }
//                                    echo $inputall['fee_amt'][$selected].'<br>';
            }

            $audit = array("action" => 'Add Offline Colletion',
                "module" => $this->uri->segment(1),
                "page" => basename(__FILE__, '.php'),
                'datetime' => date("Y-m-d H:i:s"),
                'userid' => $this->session->userdata('user_id'),
                'remarks' => 'ID:' . $fee_transac_id,
                'ip_address' => $_SERVER['REMOTE_ADDR'],
            );
            $this->dbconnection->insert("auditntrail", $audit);

            $d['msg']= 'Successfully Saved';
            $d['fee_trans_id']= $fee_transac_id;
            $d['student_id']= $student_id;
        } else {
//                if($final_total==0){
//                    
//                }
            $d['msg']= 'Oops, No Fees has been selected Or Total Amount is Zero !!!';
            $d['fee_trans_id']= 0;
            $d['student_id']= 0;
        }
        
        echo json_encode($d);
    }

    public function update_offln_payment_student_wise() {

        $id = $this->input->post('feetransid');
        $data = array(
            'payment_date' => date('Y-m-d 00:00:00', strtotime($this->input->post('edit_payment_date'))),
            'mode' => $this->input->post('edit_mode_payment'),
            'payment_method' => $this->input->post('edit_mode_payment'),
            'collection_centre' => $this->input->post('edit_collection_center'),
            'bank_name' => $this->input->post('edit_bank_name'),
            'remarks' => $this->input->post('edit_remarks'),
            'receipt_no' => $this->input->post('receipt_no'),
            'date_modified' => date('Y-m-d H:i:s'),
            'modified_by' => $this->session->userdata('user_id'),
        );

            if($this->input->post('tot_amount_update')!=$this->input->post('tot_amount_update_hidden')) {
                $data['total_amount']=$this->input->post('tot_amount_update');
//                
//                $trans_id=$this->input->post('fee_trans_id_hidden');
//                $transaction_history = $this->db->query("select f1.student_id,group_concat(distinct(f2.fee_cat_id)) as fee,"
//                        . " count(case when f2.month_no<>0 then f2.month_no end) as m,min(case when f2.month_no<>0 then f2.month_no end) as from_month,"
//                        . " max(f2.due_month_no) as d from fee_transaction_head f1, fee_transaction_det f2 where f1.id=$trans_id and f1.id=f2.fee_trans_head_id group by f1.id");
//                $fetch_transaction_history = $transaction_history->result();
//                $fe_desc = explode(',', $fetch_transaction_history[0]->fee);
//                $student_class_id=$this->dbconnection->Get_namme("student","id",$fetch_transaction_history[0]->student_id,"class_id");
//                $student_course_id=$this->dbconnection->Get_namme("student","id",$fetch_transaction_history[0]->student_id,"course_id");
//                $student_cat=$this->dbconnection->Get_namme("student","id",$fetch_transaction_history[0]->student_id,"stud_category");
//                $year_class = $this->dbconnection->select('class_fee_head', 'max(year) as year, max(id) as max_id', "(from_class_id <=$student_class_id and  to_class_id >=$student_class_id) and course=" . $student_course_id . " and status='Y' and year<=$this->session_start_yr");
//                $class_fee_head_year = $year_class[0]->year;
//                $max_class_fee_id = $year_class[0]->max_id;
//                $class_fee_head_id = $max_class_fee_id;
//                $amt=0;
//                if(in_array(2, $fe_desc)) {
//                    $fee_details = $this->db->query("SELECT sum(fee_amount) fee_amount FROM class_fee_det WHERE class_fee_head_id=$class_fee_head_id and stud_cat=$student_cat and fee_cat=2  and status=1")->result();
//                    $amt=$amt+($fetch_transaction_history[0]->fee*$fee_details[0]->fee_amount);
//                    
//                }
//                if(in_array(1, $fe_desc)) {
//                    $fee_details = $this->db->query("SELECT sum(fee_amount) fee_amount FROM class_fee_det WHERE class_fee_head_id=$class_fee_head_id and stud_cat=$student_cat and fee_cat=1  and status=1")->result();
//                    $amt=$amt+($fee_details[0]->fee_amount);
//                }
//                if(in_array(0, $fe_desc)) {
//                    $fee_details = $this->db->query("SELECT sum(fee_amount) fee_amount FROM class_fee_det WHERE class_fee_head_id=$class_fee_head_id and stud_cat=$student_cat and fee_cat=1  and status=1")->result();
//                    $amt=$amt+($fee_details[0]->fee_amount);
//                }
//                
//                
//                
            }

        $this->dbconnection->update("fee_transaction_head", $data, "id=$id");

        $audit = array("action" => 'Update Offline Colletion',
            "module" => $this->uri->segment(1),
            "page" => basename(__FILE__, '.php'),
            'datetime' => date("Y-m-d H:i:s"),
            'userid' => $this->session->userdata('user_id'),
            'remarks' => 'ID:' . $id,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
        );
        $this->dbconnection->insert("auditntrail", $audit);
    }

    public function delete_offln_payment_student_wise() {
            $id = $this->input->post('feetransid');
            $data = array(
                'status' => 1,
                'paid_status' => 3, //cancel receipt
                'response_code' => 1, //cancel receipt
                'remarks' => $this->input->post('reason'),
                'response_message' => 'Receipt Cancelation Pending',
                'date_modified' => date('Y-m-d H:i:s'),
                'modified_by' => $this->session->userdata('user_id'),
            );

        $this->dbconnection->update("fee_transaction_head", $data, "id=$id");

        $audit = array("action" => 'Delete Offline Colletion',
            "module" => $this->uri->segment(1),
            "page" => basename(__FILE__, '.php'),
            'datetime' => date("Y-m-d H:i:s"),
            'userid' => $this->session->userdata('user_id'),
            'remarks' => 'ID:' . $id,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
        );
        $this->dbconnection->insert("auditntrail", $audit);

    }

//        public function save_transaction_data($current_year,$student_id,$payment_date,$remarks,$maxn,$amount,$selected,$no_of_month='',$otherfee_id='')
//        {
//            
//                    
//                                
//                        $data=array(
//                            
//                            'student_id'=>$student_id,
//                            'amount'=>$amount,
//                            'year'=>$current_year,
//                            'month_id'=>$no_of_month,
//                            'fee_cat_id'=>$selected,
//                            'fee_id'=>$otherfee_id,
//                            'paid_by'=>$this->session->userdata('user_id'),
//                            'payment_date'=>$payment_date,
////                            'transaction_id'=>'',
////                            'payment_id'=>'',
//                            'response_code'=>0,
//                            'payment_method'=>'Cash',
//                            'response_message'=>'Payment Successful',
//                            'remarks'=>$remarks,
//                            'status'=>1,//active
//                            'paid_status'=>1,
//                            'receipt_no'=>'OFFLN'.$current_year.$maxn,
//                            'mode'=>'CASH',
//                            'bank_name'=>'',
//                            'collection_centre'=>'SCH CMP',
//                                    
//                                );
//            
//                        $this->dbconnection->insert("fee_trans_det",$data);
//                
//            
//        }


    public function download_receipt() {
 //               error_reporting(-1);
 // ini_set('display_errors', 1);
 //      $this->db->db_debug=TRUE;
        $month = array(1 => "April", 2 => "May", 3 => "June", 4 => "July", 5 => "August", 6 => "September", 7 => "October", 8 => "Novemeber", 9 => "December", 10 => "January", 11 => "February", 12 => "March");

        $fee_transaction_id = $this->uri->segment(5);
        $query_transaction = $this->db->query("select f1.*,f2.class_fee_head_id,group_concat(distinct(f2.fee_cat_id)) as fee,count(case when f2.month_no<>0 and f2.fee_cat_id=2 then f2.month_no end) as m,min(case when f2.month_no<>0 and f2.fee_cat_id=2 then f2.month_no end) as from_month,max(f2.due_month_no) as d,f2.stud_category as fee_stud_cat from fee_transaction_head f1, fee_transaction_det f2 where f1.id=$fee_transaction_id and f1.response_message=0 and f1.status=1 and f1.id=f2.fee_trans_head_id group by f1.id");
        $q = $query_transaction->result();
        $student = $this->dbconnection->select('student', 'id,roll,course_id,transport_amt,'
                . ' class_id,(select class_name from class where id=student.class_id) as class_name,'
                . ' concat(first_name," ",middle_name," ",last_name) as name,admission_no,'
                . ' stud_category,'
                . ' (select c.cat_name from category c where c.id=stud_category) as cat_name,'
                . '  section_id,(select s.sec_name from section s where s.id=section_id) as sec_name,father_name,'
                . ' email_address, phone, dob, status, date_created, created_by,last_date_modified, last_modified_by', 'id = ' . $this->uri->segment(6));

        $school_id = $this->session->userdata('school_id');
        $school = $this->school_desc;
        $transport_fee = 0;
        $discount = 0;
        $monthly_fee = array();
        $annual_fee = array();
        $one_fee = array();
        $other_fee = array();
        $instant_fee = array();
        $fine_fee = array();
        $half_fee = array();
        $fe_desc = explode(',', $q[0]->fee);
        $str = '';
        $monthly = 0;
        $annual = 0;
        $half_yearly = 0;
        $other = 0;
        $fine = 0;
        foreach ($fe_desc as $index => $value) {
            if ($value == 2) {
                if ($q[0]->m > 1) {

                    $month_var = $q[0]->from_month + $q[0]->m - 1;
                    $str .= $month[$q[0]->from_month] . "-" . $month[$month_var] . " Fees,";
                } else {
                    $str .= $month[$q[0]->from_month] . " Fees,";
                }
                $monthly_fee = $this->db->query("SELECT (" . $q[0]->m . "*fee_amount) as fee_amount,(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name,fee_id FROM class_fee_det  where fee_cat=2 and stud_cat=" . $q[0]->fee_stud_cat . " and class_fee_head_id=" . $q[0]->class_fee_head_id . " and status=1");
                $monthly_fee = $monthly_fee->result();
            }
            else if ($value == 1) {
                $str .= ' Annual Fees,';
                $annual_fee = $this->db->query("SELECT fee_amount,(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name FROM class_fee_det  where fee_cat=1 and stud_cat=" . $q[0]->fee_stud_cat . " and class_fee_head_id=" . $q[0]->class_fee_head_id . " and status=1");
                $annual_fee = $annual_fee->result();
            } else if ($value == 9) {
                $str .= ' Onetime Fees,';
                $one_fee = $this->db->query("SELECT fee_amount,(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name FROM class_fee_det  where fee_cat in (9,10) and stud_cat=" . $q[0]->fee_stud_cat . " and class_fee_head_id=" . $q[0]->class_fee_head_id . " and status=1");
                $one_fee = $one_fee->result();
            }else if ($value == 3) {
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
                    $str .= ' ' . $q[0]->d . ' Months Fine';
                } else {
                    $str .= ' ' . $q[0]->d . ' Month Fine';
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


        $this->load->library('FpdfGen');
        $this->fpdf->SetX(60);
        $this->fpdf->SetFont('Arial', '', 10);

        $this->fpdf->setSourceFile("fpdf/E-receipt.pdf");
        $import = $this->fpdf->importPage(1);
        $this->fpdf->useTemplate($import, NULL, NULL, 0, 0, true);
        $school_id = $this->session->userdata('school_id');
        $img = $school_id .'.JPG';
        if (file_exists('assets/img/' . $img)) {
        $this->fpdf->Image('assets/img/' . $img, 20, 20, 30, 30);
        }
        $this->fpdf->SetFont('Arial', 'B', 20);

        $this->fpdf->SetXY(55, 23);
        $this->fpdf->Write(0, $school[0]->description);
        $this->fpdf->SetFont('Arial', '', 8);

        $this->fpdf->SetXY(60,30);
        $this->fpdf->Write(2, $school[0]->vision);
        // $this->fpdf->Write(2, strtoupper($school[0]->vision));
        $this->fpdf->SetFont('Arial', '', 9);
        $this->fpdf->SetXY(60,37);
//        $this->fpdf->Cell(60,20,strtoupper($school[0]->address),0,0,'C');
        $this->fpdf->Write(5, strtoupper($school[0]->address));

        $this->fpdf->SetXY(60, 45);
        $this->fpdf->Write(0, 'MAIL : ' . $school[0]->email . ' | TEL : ' . $school[0]->phone);
        $this->fpdf->SetFont('Arial', '', 10);

        $this->fpdf->SetXY(60, 78.5);
        $this->fpdf->Write(0, $q[0]->transaction_id);
        $this->fpdf->SetXY(140, 77.7);
        $this->fpdf->Write(0, $q[0]->payment_date);

        $this->fpdf->SetXY(60, 88);
        $this->fpdf->Write(0, $q[0]->receipt_no);

        $this->fpdf->SetFont('Arial','B',10);
        $this->fpdf->SetXY(124, 88);
        $this->fpdf->Write(0, 'Mode  :');
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->SetXY(140, 88);
        $this->fpdf->Write(0, $q[0]->mode);
        
        $this->fpdf->SetXY(60, 98);
        $this->fpdf->Write(0, $student[0]->admission_no);

        $this->fpdf->SetXY(60, 107.8);
        $this->fpdf->Write(0, $student[0]->name);
        
        $this->fpdf->SetFont('Arial','B',10);
        $this->fpdf->SetXY(124, 107.8);
        $this->fpdf->Write(0, 'Father\'s Name :');
        $this->fpdf->SetFont('Arial', '', 8);
        $this->fpdf->SetXY(155, 107.8);
        $this->fpdf->Write(0, $student[0]->father_name);
        

        $this->fpdf->SetXY(60, 116.8);
        $this->fpdf->Write(0, $student[0]->class_name);

        $this->fpdf->SetFont('Arial','B',10);
        $this->fpdf->SetXY(124, 116.8);
        $this->fpdf->Write(0, 'Roll    :');
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->SetXY(140, 116.8);
        $this->fpdf->Write(0, $student[0]->roll);
        
        $this->fpdf->SetXY(60, 126);
        $this->fpdf->Write(0, $student[0]->sec_name);
        $this->fpdf->SetXY(60, 135.8);
        $this->fpdf->Write(0, $student[0]->cat_name);
        $this->fpdf->SetFont('Arial', 'B', 10);
        $this->fpdf->SetXY(21, 145);
        $this->fpdf->Write(0, 'Fee Paid');
        $this->fpdf->SetFont('Arial', '', 10);
        $this->fpdf->SetXY(60, 145);
        $this->fpdf->Write(0, $str);

        $total = 0;
        $top_height = 165;
        foreach ($monthly_fee as $obj) {
            $total = $total + $obj->fee_amount;
            $this->fpdf->SetXY(15, $top_height);
            $this->fpdf->Write(0, $obj->fee_name);

            $this->fpdf->SetXY(108, $top_height);
            $this->fpdf->Write(0, $obj->fee_amount);
            $top_height = $top_height + 6;
        }
        if ($transport_fee > 0) {
            $total = $total + $transport_fee;
            $this->fpdf->SetXY(15, $top_height);
            $this->fpdf->Write(0, 'Transport Fees');
            $this->fpdf->SetXY(108, $top_height);
            $this->fpdf->Write(0, $transport_fee);
            $top_height = $top_height + 6;
        }
        foreach ($annual_fee as $obj) {
            $total = $total + $obj->fee_amount;
            $this->fpdf->SetXY(15, $top_height);
            $this->fpdf->Write(0, $obj->fee_name);

            $this->fpdf->SetXY(108, $top_height);
            $this->fpdf->Write(0, $obj->fee_amount);
            $top_height = $top_height + 6;
        }
        foreach ($one_fee as $obj) {
            $total = $total + $obj->fee_amount;
            $this->fpdf->SetXY(15, $top_height);
            $this->fpdf->Write(0, $obj->fee_name);

            $this->fpdf->SetXY(108, $top_height);
            $this->fpdf->Write(0, $obj->fee_amount);
            $top_height = $top_height + 6;
        }
        foreach ($other_fee as $obj) {
            $total = $total + $obj->fee_amount;
            $this->fpdf->SetXY(15, $top_height);
            $this->fpdf->Write(0, $obj->fee_name);

            $this->fpdf->SetXY(108, $top_height);
            $this->fpdf->Write(0, $obj->fee_amount);
            $top_height = $top_height + 6;
        }
        foreach ($instant_fee as $obj) {
            $total = $total + $obj->fee_amount;
            $this->fpdf->SetXY(15, $top_height);
            $this->fpdf->Write(0, $obj->fee_name);

            $this->fpdf->SetXY(108, $top_height);
            $this->fpdf->Write(0, $obj->fee_amount);
            $top_height = $top_height + 6;
        }
        foreach ($fine_fee as $obj) {
            $total = $total + $obj->fee_amount;
            $this->fpdf->SetXY(15, $top_height);
            $this->fpdf->Write(0, $obj->fee_name);

            $this->fpdf->SetXY(108, $top_height);
            $this->fpdf->Write(0, $obj->fee_amount);
            $top_height = $top_height + 6;
        }
        if(!empty($readmsnfine_fee)) {
            $total = $total + $readmsnfine_fee[0]->fee_amount;
            $this->fpdf->SetXY(15, $top_height);
            $this->fpdf->Write(0, $readmsnfine_fee[0]->fee_name);

            $this->fpdf->SetXY(108, $top_height);
            $this->fpdf->Write(0, $readmsnfine_fee[0]->fee_amount);
            $top_height = $top_height + 6;
        }
        foreach ($half_fee as $obj) {
            $total = $total + $obj->fee_amount;
            $this->fpdf->SetXY(15, $top_height);
            $this->fpdf->Write(0, $obj->fee_name);

            $this->fpdf->SetXY(108, $top_height);
            $this->fpdf->Write(0, $obj->fee_amount);
            $top_height = $top_height + 6;
        }
        if($this->session->userdata('school_id')==35)
        {
            if ($discount > 0) {
            // $total = $total ;
            $total = $total ;
            // $this->fpdf->SetXY(15, $top_height);
            // $this->fpdf->Write(0, 'Fine Waiver (-)');
            // $this->fpdf->SetXY(108, $top_height);
            // $this->fpdf->Write(0, $discount);
            // // $this->fpdf->Write(0, '-'.$discount);
            // $top_height = $top_height + 6;
            }
        }
        else{
            if ($discount > 0) {
            $total = $total ;
            // $total = $total - $discount;
            $this->fpdf->SetXY(15, $top_height);
            $this->fpdf->Write(0, 'Fine Waiver (-)');
            $this->fpdf->SetXY(108, $top_height);
            $this->fpdf->Write(0, '-'.$discount);
            $top_height = $top_height + 6;
        }
        }
        // if ($discount > 0) {
        //     $total = $total ;
        //     // $total = $total - $discount;
        //     $this->fpdf->SetXY(15, $top_height);
        //     $this->fpdf->Write(0, 'Fine Waiver');
        //     $this->fpdf->SetXY(108, $top_height);
        //     $this->fpdf->Write(0, '-'.$discount);
        //     $top_height = $top_height + 6;
        // }


        $this->fpdf->SetXY(55, 246);
        $this->load->library('numbertowords');
        $this->fpdf->Write(0, strtoupper($this->numbertowords->convert_number($total) . ' only'));
        $this->fpdf->SetXY(108, 225);
        $this->fpdf->Write(0, $total . ' INR');
        $this->fpdf->Output("E-receipt_" . $str . ".pdf", "D");


        $audit = array("action" => 'Receipt Download from offline',
            "module" => $this->uri->segment(1),
            "page" => basename(__FILE__, '.php'),
            'datetime' => date("Y-m-d H:i:s"),
            'userid' => $this->session->userdata('user_id'),
            'remarks' => 'ID:' . $fee_transaction_id,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
        );
        $this->dbconnection->insert("auditntrail", $audit);
//		$this->fpdf->SetFont('Arial','B',16);
//		$this->fpdf->Cell(40,10,'Hello World!');
//		
//		echo $this->fpdf->Output('hello_world.pdf','D');
    }
    
        
    

}
