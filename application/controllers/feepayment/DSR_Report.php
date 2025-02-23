<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class DSR_Report extends CI_Controller {

    public function __construct() {

        parent::__construct();
        if (empty($this->session->userdata('user_id')) || $this->session->userdata('user_group_id') == 4) {
            redirect('/login');
        }
        $this->id = $this->session->userdata('school_id');
        $this->school_date_created=$this->dbconnection->Get_namme("school","id",$this->id,"start_report_date");
        if ($this->id != 0)
            $this->db->db_select('crmfeesclub_' . $this->id);
        $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y' and active='Y'");
        $fetch_startyr = isset($this->academic_session[0]->start_date) ? explode('-', $this->academic_session[0]->start_date) : array('0');
        $this->session_start_yr = reset($fetch_startyr);
        $fetch_endyr = isset($this->academic_session[0]->end_date) ? explode('-', $this->academic_session[0]->end_date) : array('0');
        $this->session_end_yr = reset($fetch_endyr);

          $this->schoolgrp=$this->dbconnection->Get_namme("crmfeesclub.school","id",$this->id,"school_group");
    }

    public function daily_wise_fee_summary() {

        $date = date('Y-m-d', strtotime($this->input->post('date')));
        $this->data['fee_details'] = $this->find_fee($date);
        $this->data['dateee'] = $date;
        $this->data['trans_status'] = $this->dbconnection->Get_namme("crmfeesclub.school", "id", $this->session->userdata('school_id'), "transport_fee");
        if($this->session->userdata('school_id')==35)
        {
            $this->load->view('feepayment/report/load_daily_wise_fee_summ_hzb', $this->data);
        }
        else
        {
            $this->load->view('feepayment/report/load_daily_wise_fee_summ', $this->data);
        }
        
    }

    public function find_fee($date) {
        $admission = array();
        $studclass = array();
        $studcategory = array();
        $studname = array();
        $amount = array();
        if ($this->session->userdata('school_id') != 9) {
            $strquery3 = "";
        } else {
            $strquery3 = " and ( mode!='NB' or (mode='NB' and payment_date<'2017-04-24 00:00:00'))";
        }

        if ($this->input->post('colcenter') == 'all') {
            $str_query1 = '';
        } else {
            $str_query1 = " and collection_centre= '{$this->input->post('colcenter')}'";
        }
        $fetch_transaction_date = $this->dbconnection->select("fee_transaction_head", "distinct(student_id) as stud", "payment_date Like '%$date%' and paid_status=1 and response_code=0 $str_query1 $strquery3 ");
        $fee_details['stud_cnt'] = count($fetch_transaction_date);
        $i = 0;
        $fee_type = $this->dbconnection->select("fee_master", "id,fee_name,fee_cat_id", "status=1");
        $fee_details['fee_ty'] = $fee_type;
        $k = 0;

        $fee_details['paymodeqry']=$this->dbconnection->select("crmfeesclub.mode","id,mode_name");
        foreach ($fee_details['paymodeqry'] as $p) { $tot_mode[$p->id]=0;}
        $fee_details['tot_mode']=$tot_mode;
        foreach ($fee_type as $row) {
            $fee_details['f_name'][$row->id] = $row->fee_name;
        }

        foreach ($fetch_transaction_date as $q) {
            $j = 0;
//            $fee_head_id = $this->dbconnection->select("fee_transaction_head", "id", "student_id=$q->stud and paid_status=1 and response_code=0 and payment_date Like '%$date%'");
            $stud = $this->dbconnection->select("student", "id,admission_no,stud_category,(select cat_name from category where id=stud_category) as stud_cat_name,concat(first_name,' ', middle_name,' ',last_name) as name,class_id,(select class_name from class where id=class_id) as class_name, (select sec_name from section where id=section_id) as sec_name,course_id,transport_amt", "id=$q->stud");
            $fee_details['admission'][$i] = $stud[0]->admission_no;
            $fee_details['studclass'][$i] = $stud[0]->class_name . ' ' . $stud[0]->sec_name;
            $fee_details['studname'][$i] = $stud[0]->name;
            $stud_class = $stud[0]->class_id;
            $stud_course = $stud[0]->course_id;
            $fee_details['stud_cat'][$i] = $stud[0]->stud_cat_name;
            $stud_cat = $stud[0]->stud_category;
            $total = 0;


            foreach ($fee_type as $row) {

                $max_class_year = $this->dbconnection->select('class_fee_head', 'max(year) as max_year, max(id) as max_id', "(from_class_id<=$stud_class and to_class_id>=$stud_class) and course=$stud_course and status='Y' and year<=$this->session_start_yr");
                
                $s=($row->fee_cat_id==3)  ?'':"and stud_cat=$stud_cat";
                $class_fee = $this->dbconnection->select("class_fee_det", "fee_amount,fee_cat", "class_fee_head_id={$max_class_year[0]->max_id} $s and status=1  and fee_id=" . $row->id);
                if ($row->fee_cat_id!=8 && count($class_fee) > 0) {
                    $fee_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,month_no", "fee_trans_head_id in (select id from fee_transaction_head where student_id=$q->stud and paid_status=1 and response_code=0 and payment_date Like '%$date%' $str_query1 $strquery3 ) and fee_cat_id=" . $class_fee[0]->fee_cat);
                    $fee_amt = 0;
                    if (count($fee_qry) > 0) {
                        foreach ($fee_qry as $rfee) {
                            $fee_amt = $fee_amt + $class_fee[0]->fee_amount;
                            $total += $class_fee[0]->fee_amount;
                        }
                        $fee_details['fee_amnt'][$i][$row->id] = $fee_amt;
//                    if (count($fee_qry) > 0) {
//                        $fee_details['fee_amnt'][$i][$row->id] = count($fee_qry)*$class_fee[0]->fee_amount;
//                        $total += count($fee_qry)*$class_fee[0]->fee_amount;
                    } else {
                        $fee_details['fee_amnt'][$i][$row->id] = 0;
                        $total += 0;
                    }
                }else if($row->fee_cat_id==8){
                    $fee_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,amount,other_fee_id", "fee_trans_head_id in (select id from fee_transaction_head where student_id=$q->stud and paid_status=1 and response_code=0 and payment_date Like '%$date%' $str_query1 $strquery3 ) and fee_cat_id=8");
                    $fee_amt=0;
                    if (count($fee_qry) > 0) {
                        foreach ($fee_qry as $rfee) {
                            $fee_amt = $fee_amt + $rfee->amount;
                            $total += $rfee->amount;
                        }
                        $fee_details['fee_amnt'][$i][$row->id] = $fee_amt;
                    }else {
                        $fee_details['fee_amnt'][$i][$row->id] = 0;
                        $total += 0;
                    }
                    
                } else {
                    $fee_details['fee_amnt'][$i][$row->id] = 0;
                    $total += 0;
                }
            }


//transport
//            if (!empty($stud[0]->transport_amt)) {
                $trns_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,amount", "fee_trans_head_id in (select id from fee_transaction_head where student_id=$q->stud and paid_status=1 and response_code=0 and payment_date Like '%$date%' $str_query1 $strquery3 ) and fee_cat_id=6");
                $trans_amt = 0;
                if (count($trns_qry) > 0) {
                    foreach ($trns_qry as $rt) {
                        $trans_amt = $trans_amt + $rt->amount;
                        $total += $rt->amount;
                    }
                    $fee_details['transport_amt'][$i] = $trans_amt;
                } else {
                    $fee_details['transport_amt'][$i] = 0;
                    $total += 0;
                }
//            } else {
//                $fee_details['transport_amt'][$i] = 0;
//                $total += 0;
//            }

//fine

            $fine_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,month_no,amount", "fee_trans_head_id in (select id from fee_transaction_head where student_id=$q->stud and paid_status=1 and response_code=0 and payment_date Like '%$date%' $str_query1 $strquery3 ) and fee_cat_id=0");
            $fine_amt = 0;
            if (count($fine_qry) > 0) {
                foreach ($fine_qry as $rfine) {
                    $fine_amt = $fine_amt + $rfine->amount;
                    $total += $rfine->amount;
                }
                $fee_details['fine'][$i] = $fine_amt;
            } else {
                $fee_details['fine'][$i] = 0;
                $total += 0;
            }
            $readmsnfine_qry = $this->dbconnection->select("fee_transaction_det", "amount", "fee_trans_head_id in (select id from fee_transaction_head where student_id=$q->stud and paid_status=1 and response_code=0 and payment_date Like '%$date%' $str_query1 $strquery3 ) and fee_cat_id=11");
            $fee_details['readmsnfine'][$i]=!empty($readmsnfine_qry)?$readmsnfine_qry[0]->amount:0;
            $total += $fee_details['readmsnfine'][$i];
            
            $qry = $this->dbconnection->select("fee_transaction_head", "id,sum(discount_amount) discount_amount,group_concat(receipt_no) receipt_no", "student_id=$q->stud and paid_status=1 and response_code=0 and payment_date Like '%$date%' $str_query1 $strquery3 ","","student_id");
            
            $total -= $qry[0]->discount_amount;
            $fee_details['instant_discount'][$i] = $qry[0]->discount_amount;
            $fee_details['receipt_no'][$i] = $qry[0]->receipt_no;
            $fee_details['total1'][$i] = $total;
            $i++;
        }
        return $fee_details;
    }

    public function monthly_wise_fee_summary() {
        $month = $this->input->post('month');
        if ($month >= 1 && $month <= 9) {
            $month = $month + 3;
            $year = $this->session_start_yr;
        } else {
            $month = $month - 9;
            $year = $this->session_end_yr;
        }
//        if ($month >= 4 && $month <= 12) {
//            $month = $month - 3;
//        } else if ($month >= 1 && $month <= 3) {
//            $month = $month + 9;
//        }
        $this->data1['monthly_fee'] = $this->find_mnth_fee($month, $year);
        $this->data1['trans_status'] = $this->dbconnection->Get_namme("crmfeesclub.school", "id", $this->session->userdata('school_id'), "transport_fee");
        $this->load->view('feepayment/report/load_monthly_wise_fee_summ', $this->data1);
    }

    public function find_mnth_fee($month, $yearmn) {
        $admission = array();
        $studclass = array();
        $studcategory = array();
        $studname = array();
        $amount = array();

        if ($this->session->userdata('school_id') != 9) {
            $strquery3 = "";
        } else {
            $strquery3 = " and ( mode!='NB' or (mode='NB' and payment_date<'2017-04-24 00:00:00'))";
        }

        if ($this->input->post('colcenter') == 'all') {
            $str_query1 = '';
        } else {
            $str_query1 = " and collection_centre= '{$this->input->post('colcenter')}'";
        }

//        $fetch_transaction_mnth = $this->dbconnection->select("fee_transaction_head", "distinct(student_id) as stud", "MONTH(payment_date)='$month' and year={$this->academic_session[0]->fin_year} and paid_status=1 and response_code=0 $str_query1 $strquery3");
        $fetch_transaction_mnth = $this->dbconnection->select("fee_transaction_head", "distinct(student_id) as stud", "MONTH(payment_date)='$month' and Year(payment_date)=$yearmn and year={$this->academic_session[0]->fin_year} and paid_status=1 and response_code=0 $str_query1 $strquery3");
        $monthly_fee['stud_cnt'] = count($fetch_transaction_mnth);
        $i = 0;
        $fee_type = $this->dbconnection->select("fee_master", "id,fee_name,fee_cat_id", "status=1");
        $monthly_fee['fee_ty'] = $fee_type;
        $k = 0;
        foreach ($fee_type as $row) {
            $monthly_fee['f_name'][$row->id] = $row->fee_name;
        }

        foreach ($fetch_transaction_mnth as $q) {
            $j = 0;
//            $fee_head_id1 = $this->dbconnection->select("fee_transaction_head", "id", "student_id=$q->stud and paid_status=1 and response_code=0 and MONTH(payment_date)='$month' and year={$this->academic_session[0]->fin_year} $str_query1 $strquery3 ");
            $fee_head_id1 = $this->dbconnection->select("fee_transaction_head", "id", "student_id=$q->stud and paid_status=1 and response_code=0 and MONTH(payment_date)='$month' and Year(payment_date)=$yearmn and year={$this->academic_session[0]->fin_year} $str_query1 $strquery3 ");
            $stud = $this->dbconnection->select("student", "id,admission_no,stud_category,(select cat_name from category where id=stud_category) as stud_cat_name,concat(first_name,' ', middle_name,' ',last_name) as name,class_id,(select class_name from class where id=class_id) as class_name, (select sec_name from section where id=section_id) as sec_name,course_id,transport_amt", "id=$q->stud");
            $monthly_fee['admission'][$i] = $stud[0]->admission_no;
            $monthly_fee['studclass'][$i] = $stud[0]->class_name . ' ' . $stud[0]->sec_name;
            $monthly_fee['studname'][$i] = $stud[0]->name;
            $stud_class = $stud[0]->class_id;
            $stud_course = $stud[0]->course_id;
            $monthly_fee['stud_cat'][$i] = $stud[0]->stud_cat_name;
            $stud_cat = $stud[0]->stud_category;
            $total = 0;
            foreach ($fee_type as $row) {
                
                $max_class_year = $this->dbconnection->select('class_fee_head', 'max(year) as max_year, max(id) as max_id', "(from_class_id<=$stud_class and to_class_id>=$stud_class) and course=$stud_course and status='Y' and year<=$this->session_start_yr");
                 $s=($row->fee_cat_id==3)?'':"and stud_cat=$stud_cat";
                $class_fee = $this->dbconnection->select("class_fee_det", "fee_amount,fee_cat", "class_fee_head_id={$max_class_year[0]->max_id} $s and status=1 and fee_id=" . $row->id);
                if ($row->fee_cat_id!=8 && count($class_fee) > 0) {
//                        $fee_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,fee_cat_id", "fee_trans_head_id in (select id from fee_transaction_head where student_id=$q->stud and paid_status=1 and response_code=0 and MONTH(payment_date)='$month' and year={$this->academic_session[0]->fin_year} $str_query1 $strquery3 ) and fee_cat_id=" . $class_fee[0]->fee_cat);
                    $fee_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,fee_cat_id", "fee_trans_head_id in (select id from fee_transaction_head where student_id=$q->stud and paid_status=1 and response_code=0 and MONTH(payment_date)='$month' and Year(payment_date)=$yearmn and year={$this->academic_session[0]->fin_year} $str_query1 $strquery3 ) and fee_cat_id=" . $class_fee[0]->fee_cat);
                    $fee_amt = 0;
                    if (count($fee_qry) > 0) {
                        foreach ($fee_qry as $rfee) {
                            $fee_amt = $fee_amt + $class_fee[0]->fee_amount;
                            $total += $class_fee[0]->fee_amount;
                        }
                        $monthly_fee['fee_amnt'][$i][$row->id] = $fee_amt;
//                        $monthly_fee['fee_amnt'][$i][$row->id] = $class_fee[0]->fee_amount;
//                        $total += $class_fee[0]->fee_amount;
                    } else {
                        $monthly_fee['fee_amnt'][$i][$row->id] = 0;
                        $total += 0;
                    }
                } else if($row->fee_cat_id==8){
                    $fee_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,amount,other_fee_id", "fee_trans_head_id in (select id from fee_transaction_head where student_id=$q->stud and paid_status=1 and response_code=0 and MONTH(payment_date)='$month' and Year(payment_date)=$yearmn and year={$this->academic_session[0]->fin_year} $str_query1 $strquery3 ) and fee_cat_id=8");
                    $fee_amt=0;
                    if (count($fee_qry) > 0) {
                        foreach ($fee_qry as $rfee) {
                            $fee_amt = $fee_amt + $rfee->amount;
                            $total += $rfee->amount;
                        }
                        $monthly_fee['fee_amnt'][$i][$row->id] = $fee_amt;
                    }else {
                        $monthly_fee['fee_amnt'][$i][$row->id] = 0;
                        $total += 0;
                    }
                    
                }  else {
                    $monthly_fee['fee_amnt'][$i][$row->id] = 0;
                    $total += 0;
                }
            }

//                echo $stud[0]->transport_amt;
//transport
//            if (!empty($stud[0]->transport_amt)) {
                $trns_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,amount", "fee_trans_head_id in (select id from fee_transaction_head where student_id=$q->stud and paid_status=1 and response_code=0 and MONTH(payment_date)='$month' and Year(payment_date)=$yearmn and year={$this->academic_session[0]->fin_year} $str_query1 $strquery3 ) and fee_cat_id=6");
                $trans_amt = 0;
                if (count($trns_qry) > 0) {
                    foreach ($trns_qry as $rt) {
                        $trans_amt = $trans_amt + $rt->amount;
                        $total += $rt->amount;
                    }
                    $monthly_fee['transport_amt'][$i] = $trans_amt;
                } else {
                    $monthly_fee['transport_amt'][$i] = 0;
                    $total += 0;
                }
//                        print_r($trns_qry);
//            } else {
//                $monthly_fee['transport_amt'][$i] = 0;
//                $total += 0;
//            }

//                echo $fee_details['transport_amt'][$i];
//fine
//                $fine_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,month_no,amount", "fee_trans_head_id in (select id from fee_transaction_head where student_id=$q->stud and paid_status=1 and response_code=0 and MONTH(payment_date)='$month' and year={$this->academic_session[0]->fin_year} $str_query1 $strquery3 ) and fee_cat_id=0");
            $fine_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,month_no,amount", "fee_trans_head_id in (select id from fee_transaction_head where student_id=$q->stud and paid_status=1 and response_code=0 and MONTH(payment_date)='$month' and Year(payment_date)=$yearmn and year={$this->academic_session[0]->fin_year} $str_query1 $strquery3 ) and fee_cat_id=0");
            $fine_amt = 0;
            if (count($fine_qry) > 0) {
                foreach ($fine_qry as $rfine) {
                    $fine_amt = $fine_amt + $rfine->amount;
                    $total += $rfine->amount;
                }
                $monthly_fee['fine'][$i] = $fine_amt;
            } else {
                $monthly_fee['fine'][$i] = 0;
                $total += 0;
            }
            
            $readmsnfine_qry = $this->dbconnection->select("fee_transaction_det", "amount", "fee_trans_head_id in (select id from fee_transaction_head where student_id=$q->stud and paid_status=1 and response_code=0 and MONTH(payment_date)='$month' and Year(payment_date)=$yearmn and year={$this->academic_session[0]->fin_year} $str_query1 $strquery3 ) and fee_cat_id=11");
            $readmsnfine_amt=!empty($readmsnfine_qry)?$readmsnfine_qry[0]->amount:0;
            $monthly_fee['readmsnfine'][$i] = $readmsnfine_amt;
            $total += $readmsnfine_amt;
            $monthly_fee['total1'][$i] = $total;
            $i++;
        }
        return $monthly_fee;
    }

    public function monthlyfees_wise_fee_summary() {
        $fdate = $this->input->post('frmdate');
        $tdate = $this->input->post('todate');
        if ($this->input->post('colcenter') == 'all') {
            $str_query1 = '';
        } else {
            $str_query1 = " and fh.collection_centre= '{$this->input->post('colcenter')}'";
        }

        $str_query = "fh.payment_date>=DATE_FORMAT('$fdate', '%Y-%m-%d 00:00:00') and fh.payment_date<=DATE_FORMAT('$tdate', '%Y-%m-%d 23:59:59')"; 
        
        $fee_details=array();
        $fetch_transaction_date=$this->db->query("SELECT fh.id,group_concat(distinct(fd.fee_cat_id)) fee_cat,fd.class_fee_head_id, fh.payment_method,fh.transaction_id,DATE_FORMAT(fh.payment_date, '%d-%m-%Y') payment_date,fh.total_amount,fh.response_message,fh.student_id,fh.pos_no,s.admission_no,concat(s.first_name,' ',s.middle_name,' ',s.last_name) as name,s.class_id,s.section_id,s.stud_category,s.course_id,s.roll,s.transport_amt,s.start_fee_month,GROUP_CONCAT(distinct(fd.month_no) order by fd.month_no) month_details,fh.discount_amount,fh.collection_centre,fh.receipt_no,fh.remarks,fh.mode FROM `fee_transaction_head` fh inner join student s on fh.student_id=s.id inner join fee_transaction_det fd on fd.fee_trans_head_id=fh.id WHERE $str_query and fh.paid_status=1 and  fh.response_code=0 $str_query1
group by fh.id")->result();
//        $fetch_transaction_date = $this->dbconnection->select("fee_transaction_head", "student_id as stud, payment_date", "payment_date>=DATE_FORMAT('$fdate', '%Y-%m-%d 00:00:00') and payment_date<=DATE_FORMAT('$tdate', '%Y-%m-%d 23:59:59') and paid_status=1 and response_code=0 $str_query1 ");
        $fee_details['fetch_transaction_date']=$fetch_transaction_date;
        $fee_type = $this->dbconnection->select_returnarray("fee_master", "id,fee_name,fee_cat_id", "status=1");
        $fee_details['fee_ty']=array_column($fee_type, 'fee_name', 'id');
        $fee_details['fee_cat_id']=array_column($fee_type, 'fee_cat_id', 'id');

        $fee_details['trans_status'] = $this->dbconnection->Get_namme("crmfeesclub.school", "id", $this->session->userdata('school_id'), "transport_fee");
        $fee_details['paymodeqry']=$this->dbconnection->select("crmfeesclub.mode","id,mode_name");
        $fee_details['session_start_yr']=$this->session_start_yr;
        $fee_details['month_arr']= array('0'=>'', '1' => 'APR', '2' => 'MAY', '3' => 'JUN', '4' => 'JUL', '5' => 'AUG', '6' => 'SEP', '7' => 'OCT', '8' => 'NOV', '9' => 'DEC', '10' => 'JAN', '11' => 'FEB', '12' => 'MAR', '13' => 'APR', '14' => 'MAY');
        $tot_mode=array();
        foreach ($fee_details['paymodeqry'] as $p) { $tot_mode[$p->id]=0;}
        $fee_details['tot_mode']=$tot_mode;
        $class = $this->dbconnection->select_returnarray("class", "id,class_name", "status='Y'");
        $section = $this->dbconnection->select_returnarray("section", "id,sec_name", "status='Y'");
        
        $fee_details['class'] = array_column($class, 'class_name', 'id');
        $fee_details['section'] = array_column($section, 'sec_name', 'id');
        $fee_details['rmvcol'] = $this->input->post('rmvcol');
        $fee_details['rmvcol1'] = $this->input->post('rmvcol1');
        $fee_details['schgrp'] = $this->dbconnection->Get_namme("crmfeesclub.school","id",$this->id,"school_group");
        
        $this->load->view('feepayment/report/load_monthlyfee_wise_fee_summ', $fee_details);
    }

    public function term_report() {
        
         if($this->schoolgrp=='ARMY')
        {

        $this->data['page_title'] = 'Term Report';
        $this->data['section'] = 'feepayment/report';
        $this->data['page_name'] = 'term_report_army';
        $this->data['customview'] = '';
        $this->data['school_date_created'] =$this->school_date_created;
        $this->data['aclass'] = $this->dbconnection->select("class", "id,class_name", "status='Y'");
        $this->data['asection'] = $this->dbconnection->select("section", "id,sec_name", "status='Y'");
        $this->data['acategory'] = $this->dbconnection->select("category", "id,cat_name", "status='Y'");
        $this->data['collection_center'] = $this->dbconnection->select("collection_center", "id,collection_code,collection_desc", "status='Y'");
        $this->load->view('index', $this->data);

        }
        else
        {

        $this->data['page_title'] = 'Term Report';
        $this->data['section'] = 'feepayment/report';
        $this->data['page_name'] = 'term_report';
        $this->data['customview'] = '';
        $this->data['school_date_created'] =$this->school_date_created;
        $this->data['aclass'] = $this->dbconnection->select("class", "id,class_name", "status='Y'");
        $this->data['asection'] = $this->dbconnection->select("section", "id,sec_name", "status='Y'");
        $this->data['acategory'] = $this->dbconnection->select("category", "id,cat_name", "status='Y'");
        $this->data['collection_center'] = $this->dbconnection->select("collection_center", "id,collection_code,collection_desc", "status='Y'");
        $this->load->view('index', $this->data);
    }
    }

    public function date_wise_term_report() {
//        error_reporting(-1);
//        ini_set('display_errors', 1);
        $from_date = $this->input->post('from_date');

        $to_date = $this->input->post('to_date');
        $collection_center = $this->input->post('collection_center');
        if ($collection_center == 'all') {
            $str_query1 = '';
        } else {
            $str_query1 = " and collection_centre= '$collection_center'";
        }

        if ($this->session->userdata('school_id') != 9) {
            $strquery3 = "";
        } else {
            $strquery3 = " and ( mode!='NB' or (mode='NB' and payment_date<'2017-04-24 00:00:00'))";
        }

        $tran_date = array();
        $annual_amount = array();
        $monthly_amount = array();
        $count_transac = array();
        $grand_total = array();

        if ($to_date == '') {
            $fetch_transaction_date = $this->db->query("SELECT distinct(DATE(payment_date)) as date_pay FROM fee_transaction_head WHERE payment_date like '%$from_date%' $str_query1 $strquery3 order by date_pay ");
        } else {
            $fetch_transaction_date = $this->db->query("SELECT distinct(DATE(payment_date)) as date_pay FROM fee_transaction_head WHERE payment_date>=DATE_FORMAT('$from_date', '%Y-%m-%d 00:00:00') and payment_date<=DATE_FORMAT('$to_date', '%Y-%m-%d 23:59:59') $str_query1 $strquery3 order by date_pay");
        }

        $query = $fetch_transaction_date->result();
//        print_r($query);
        $i = 0;
        $total_cnt_transac = 0;
        $total_annual_amt = 0;
        $total_monthly_amt = 0;
        $total_grand_amt = 0;
        $mode=array();
      
        $paymodeqry=$this->dbconnection->select("crmfeesclub.mode","id,mode_name");
        
        foreach ($query as $transac_date) {
            $tran_date[$i] = $transac_date->date_pay;

            $query_annual_amount = $this->db->query("SELECT sum(amount) as ann_amt,count(distinct(fee_trans_head_id)) as cnt_ann  FROM fee_transaction_det WHERE fee_trans_head_id in (select id from fee_transaction_head where payment_date LIKE '%$transac_date->date_pay%' and paid_status=1 and response_code=0 $str_query1 $strquery3 ) and fee_cat_id=1");
            $q = $query_annual_amount->result();
            $annual_amount[$i] = $q[0]->ann_amt;
//                        $annual_cnt[$i]=$q[0]->cnt_ann;
            $total_annual_amt = $total_annual_amt + $annual_amount[$i];

            $query_monthly_amount = $this->db->query("SELECT sum(amount) as mon_amt,count(distinct(fee_trans_head_id)) as cnt_mon  FROM fee_transaction_det WHERE fee_trans_head_id in (select id from fee_transaction_head where payment_date LIKE '%$transac_date->date_pay%' and paid_status=1 and response_code=0 $str_query1 $strquery3) and fee_cat_id in (2,0,11,6,3,8,5)");
            $q1 = $query_monthly_amount->result();
//            $monthly_amount[$i] = $q1[0]->mon_amt;
//            $total_monthly_amt = $total_monthly_amt + $monthly_amount[$i];


            $query_discount_amount = $this->db->query("SELECT sum(discount_amount) as discount_amount  FROM fee_transaction_head where payment_date LIKE '%$transac_date->date_pay%' and paid_status=1 and response_code=0 $str_query1 $strquery3");
            $q2 = $query_discount_amount->result();
            $monthly_amount[$i] = $q1[0]->mon_amt -$q2[0]->discount_amount;
            $total_monthly_amt = $total_monthly_amt + $monthly_amount[$i] - $q2[0]->discount_amount;
            
            $count_transac[$i] = $q[0]->cnt_ann + $q1[0]->cnt_mon;
            $total_cnt_transac = $total_cnt_transac + $count_transac[$i];
            $grand_total[$i] = $annual_amount[$i] + $monthly_amount[$i];
            $total_grand_amt = $total_grand_amt + $grand_total[$i];
            
            
            foreach ($paymodeqry as $p) {
                $qmode = $this->db->query("SELECT sum(total_amount) as total_amount  FROM fee_transaction_head WHERE payment_date LIKE '%$transac_date->date_pay%' and paid_status=1 and response_code=0 and mode='$p->mode_name' $str_query1 $strquery3 ")->result();
                $mode[$i][$p->id]=$qmode[0]->total_amount;
            }
            
            
            $i++;
        }

        $data = array(
            'tran_date' => $tran_date,
            'annual_amount' => $annual_amount,
            'monthly_amount' => $monthly_amount,
            'count_transac' => $count_transac,
            'mode' => $mode,
            'paymodeqry' => $paymodeqry,
            'grand_total' => $grand_total,
            'cnti' => $i,
            'total_cnt_transac' => $total_cnt_transac,
            'total_annual_amt' => $total_annual_amt,
            'total_monthly_amt' => $total_monthly_amt,
            'total_grand_amt' => $total_grand_amt,
        );

        $this->load->view('feepayment/report/load_date_wise_term_report.php', $data);
    }

    public function category_wise_term_report() {
        
        $from_date = $this->input->post('from_date');


        $to_date = $this->input->post('to_date');
        if ($to_date == '') {
            $str_query = "payment_date like '%$from_date%'";
        } else {
            $str_query = "payment_date>=DATE_FORMAT('$from_date', '%Y-%m-%d 00:00:00') and payment_date<=DATE_FORMAT('$to_date', '%Y-%m-%d 23:59:59')";
        }
        $collection_center = $this->input->post('collection_center');
        if ($collection_center == 'all') {
            $str_query1 = '';
        } else {
            $str_query1 = " and collection_centre= '$collection_center'";
        }

        if ($this->session->userdata('school_id') != 9) {
            $strquery3 = "";
        } else {
            $strquery3 = " and ( mode!='NB' or (mode='NB' and payment_date<'2017-04-24 00:00:00'))";
        }

        $category_list = array();
        $annual_amount = array();
        $monthly_amount = array();
//                    $count_transac=array();
        $grand_total = array();
//            $fetch_transaction_date= $this->dbconnection->select_union("distinct(DATE(last_date_modified)) as date_pay","mon_due_fees_det","last_date_modified>='$from_date' and last_date_modified<='$to_date'","distinct(DATE(last_date_modified)) as date_pay","annual_payments","last_date_modified>='$from_date' and last_date_modified<='$to_date'","date_pay");

        $fetch_category = $this->db->query("select * from category where status='Y'");
        $query = $fetch_category->result();
        $i = 0;
        $total_annual_amt = 0;
        $total_monthly_amt = 0;
        $total_grand_amt = 0;
        $mode=array();
      
        $paymodeqry=$this->dbconnection->select("crmfeesclub.mode","id,mode_name");
        
        foreach ($query as $category) {

            $category_list[$i] = $category->cat_name;

            $query_annual_amount = $this->db->query("SELECT sum(amount) as ann_amt,count(amount) as cnt_ann  FROM fee_transaction_det WHERE fee_trans_head_id in ( select id from fee_transaction_head where $str_query $str_query1 $strquery3 and paid_status=1) and fee_cat_id=1 and stud_category=$category->id");
            $q = $query_annual_amount->result();
            $annual_amount[$i] = $q[0]->ann_amt;
            $total_annual_amt = $total_annual_amt + $annual_amount[$i];

            $query_monthly_amount = $this->db->query("SELECT sum(amount) as mon_amt,count(amount) as cnt_mon  FROM fee_transaction_det WHERE fee_trans_head_id in ( select id from fee_transaction_head where $str_query $str_query1 $strquery3 and paid_status=1) and fee_cat_id in (2,0,11,6,3,8,5) and stud_category=$category->id ");
            $q1 = $query_monthly_amount->result();
//            $monthly_amount[$i] = $q1[0]->mon_amt;
//            $total_monthly_amt = $total_monthly_amt + $monthly_amount[$i];
            
            $query_discount_amount = $this->db->query("SELECT sum(amount) as discount_amount  FROM fee_transaction_det WHERE fee_trans_head_id in ( select id from fee_transaction_head where $str_query $str_query1 $strquery3 and paid_status=1) and (fee_cat_id=7) and stud_category=$category->id ");
            $q2 = $query_discount_amount->result();
            $monthly_amount[$i] = $q1[0]->mon_amt -$q2[0]->discount_amount;
            $total_monthly_amt = $total_monthly_amt + $monthly_amount[$i] ;
            
//                        $count_transac[$i]=$q[0]->cnt_ann+$q1[0]->cnt_mon;
            $grand_total[$i] = $annual_amount[$i] + $monthly_amount[$i];
            $total_grand_amt = $total_grand_amt + $grand_total[$i];
            
            foreach ($paymodeqry as $p) {
                $qmode = $this->db->query("SELECT sum(amount) as total_amount  FROM fee_transaction_det WHERE fee_trans_head_id in ( select id from fee_transaction_head where $str_query $str_query1 $strquery3 and paid_status=1 and mode='$p->mode_name') and stud_category=$category->id ")->result();
                $mode[$i][$p->id]=$qmode[0]->total_amount;
            }
            
            $i++;
        }

        $data = array(
            'category_list' => $category_list,
            'annual_amount' => $annual_amount,
            'monthly_amount' => $monthly_amount,
//                        'count_transac'=>$count_transac,
            'mode' => $mode,
            'paymodeqry' => $paymodeqry,
            'grand_total' => $grand_total,
            'total_annual_amt' => $total_annual_amt,
            'total_monthly_amt' => $total_monthly_amt,
            'total_grand_amt' => $total_grand_amt,
            'cnti' => $i,
        );

        $this->load->view('feepayment/report/load_category_wise_term_report.php', $data);
    }

    public function class_wise_term_report() {
        
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $collection_center = $this->input->post('collection_center');
        $category = $this->input->post('category');

        if ($to_date == '') {
            $str_query = "payment_date like '%$from_date%'";
        } else {
            $str_query = "payment_date>=DATE_FORMAT('$from_date', '%Y-%m-%d 00:00:00') and payment_date<=DATE_FORMAT('$to_date', '%Y-%m-%d 23:59:59')";
        }


        if ($collection_center == 'all') {
            $str_query1 = '';
        } else {
            $str_query1 = " and collection_centre= '$collection_center'";
        }

        if ($this->session->userdata('school_id') != 9) {
            $strquery3 = "";
        } else {
            $strquery3 = " and ( mode!='NB' or (mode='NB' and payment_date<'2017-04-24 00:00:00'))";
        }

        $class = array();
        $section = array();
        $annual_amount = array();
        $monthly_amount = array();

        $grand_total = array();
        $cntj = array();

        $query = $this->dbconnection->select("class", "id, class_name", "status='Y'");

        $i = 0;
        $j = 0;
        $total_annual_amt = array();
        $total_monthly_amt = array();
        $total_grand_amt = array();
        
        $mode=array();
      
        $paymodeqry=$this->dbconnection->select("crmfeesclub.mode","id,mode_name");
        foreach ($query as $cls) {

            $tot_ann_amt = 0;
            $tot_mon_amt = 0;
            $tot_grand_amt = 0;
            $section_qry = $this->dbconnection->select("class", "section", "id=$cls->id");
            $sub = array();
            $sub = explode("-", $section_qry[0]->section);

            foreach ($sub as $sec) { 

                $class[$i][$j] = $cls->class_name;
                $section[$i][$j] = $sec;

                if ($category == '') {
                    $query_annual_amount = $this->db->query("SELECT sum(amount) as ann_amt,count(amount) as cnt_ann  FROM fee_transaction_det WHERE  fee_trans_head_id in( select id from fee_transaction_head where $str_query $str_query1 $strquery3 and paid_status=1 and student_id in (select id from student where class_id=$cls->id and section_id=$sec)) and fee_cat_id=1");
                    $query_monthly_amount = $this->db->query("SELECT sum(amount) as mon_amt,count(amount) as cnt_mon  FROM fee_transaction_det WHERE fee_trans_head_id in( select id from fee_transaction_head where $str_query $str_query1 $strquery3 and paid_status=1 and student_id in (select id from student where class_id=$cls->id and section_id=$sec) ) and fee_cat_id in (2,0,11,6,3,8,5) ");
                    $query_discount_amount = $this->db->query("SELECT sum(amount) as discount_amount  FROM fee_transaction_det WHERE fee_trans_head_id in( select id from fee_transaction_head where $str_query $str_query1 $strquery3 and paid_status=1 and student_id in (select id from student where class_id=$cls->id and section_id=$sec) ) and (fee_cat_id=7) ");
                } else {
                    $query_annual_amount = $this->db->query("SELECT sum(amount) as ann_amt,count(amount) as cnt_ann  FROM fee_transaction_det WHERE  fee_trans_head_id in( select id from fee_transaction_head where $str_query $str_query1 $strquery3 and paid_status=1 and student_id in (select id from student where class_id=$cls->id and section_id=$sec and stud_category=$category)) and fee_cat_id=1 ");
                    $query_monthly_amount = $this->db->query("SELECT sum(amount) as mon_amt,count(amount) as cnt_mon  FROM fee_transaction_det WHERE fee_trans_head_id in( select id from fee_transaction_head where $str_query $str_query1 $strquery3 and paid_status=1  and student_id in (select id from student where class_id=$cls->id and section_id=$sec and stud_category=$category)) and fee_cat_id in (2,0,11,6,3,8,5) ");
                    $query_discount_amount = $this->db->query("SELECT sum(amount) as discount_amount  FROM fee_transaction_det WHERE fee_trans_head_id in( select id from fee_transaction_head where $str_query $str_query1 $strquery3 and paid_status=1  and student_id in (select id from student where class_id=$cls->id and section_id=$sec and stud_category=$category)) and (fee_cat_id=7) ");
                }

                $q = $query_annual_amount->result();
                $annual_amount[$i][$j] = $q[0]->ann_amt;
                $tot_ann_amt = $tot_ann_amt + $annual_amount[$i][$j];


                $q1 = $query_monthly_amount->result();
                $q2 = $query_discount_amount->result();
                $monthly_amount[$i][$j] = $q1[0]->mon_amt-$q2[0]->discount_amount;
                $tot_mon_amt = $tot_mon_amt + $monthly_amount[$i][$j] -$q2[0]->discount_amount;

//                        $count_transac[$i]=$q[0]->cnt_ann+$q1[0]->cnt_mon;
                $grand_total[$i][$j] = $annual_amount[$i][$j] + $monthly_amount[$i][$j];
                $tot_grand_amt = $tot_grand_amt + $grand_total[$i][$j];
                foreach ($paymodeqry as $p) {
                    if ($category == '') {
                        $qmode = $this->db->query("SELECT sum(amount) as total_amount  FROM fee_transaction_det WHERE fee_trans_head_id in( select id from fee_transaction_head where $str_query $str_query1 $strquery3 and paid_status=1 and mode='$p->mode_name' and student_id in (select id from student where class_id=$cls->id and section_id=$sec) )")->result();
                    }else {
                        $qmode = $this->db->query("SELECT sum(amount) as total_amount FROM fee_transaction_det WHERE fee_trans_head_id in( select id from fee_transaction_head where $str_query $str_query1 $strquery3 and paid_status=1  and mode='$p->mode_name'  and student_id in (select id from student where class_id=$cls->id and section_id=$sec and stud_category=$category)) ")->result();
                    }
                    $mode[$i][$j][$p->id]=$qmode[0]->total_amount;
                }
                $j++;
            }

            $cntj[$i] = $j;
            $total_annual_amt[$i] = $tot_ann_amt;
            $total_monthly_amt[$i] = $tot_mon_amt;
            $total_grand_amt[$i] = $tot_grand_amt;
            $j = 0;
            $i++;
        }

        $data = array(
            'class' => $class,
            'section' => $section,
            'annual_amount' => $annual_amount,
            'monthly_amount' => $monthly_amount,
//                        'count_transac'=>$count_transac,
            'mode' => $mode,
            'paymodeqry' => $paymodeqry,
            'grand_total' => $grand_total,
            'total_annual_amt' => $total_annual_amt,
            'total_monthly_amt' => $total_monthly_amt,
            'total_grand_amt' => $total_grand_amt,
            'cnti' => $i,
            'cntj' => $cntj,
        );

        $this->load->view('feepayment/report/load_class_wise_term_report.php', $data);
    }
    
    
    public function feehead_wise_term_report() {
//                error_reporting(-1);
//        ini_set('display_errors', 1);
        $fdate = $this->input->post('from_date');
        $tdate = $this->input->post('to_date');
        if ($this->input->post('collection_center') == 'all') {
            $str_query1 = '';
        } else {
            $str_query1 = " and fh.collection_centre= '{$this->input->post('collection_center')}'";
        }

        $str_query = "fh.payment_date>=DATE_FORMAT('$fdate', '%Y-%m-%d 00:00:00') and fh.payment_date<=DATE_FORMAT('$tdate', '%Y-%m-%d 23:59:59')"; 
        
        $fee_details=array(); 
        $mode=array();
      
        $fee_details['paymodeqry']=$this->dbconnection->select("crmfeesclub.mode","id,mode_name");
        $fetch_transaction_date=$this->db->query("select payment_date,group_concat(fhid order by fhid) as fhid,sum(total_amount) total_amount,group_concat(mode order by fhid) as mode,group_concat(total_amount order by fhid) as ttamt,sum(discount_amount) discount_amount,group_concat(st order by fhid) studentid,group_concat(stc order by fhid ) classid,group_concat(course_id order by fhid) courseid,group_concat(stud_category order by fhid) stud_category,sum(transport_amt) transport_amt from (SELECT fh.id as fhid,DATE_FORMAT(fh.payment_date, '%Y-%m-%d') payment_date,fh.total_amount,fh.mode,fh.discount_amount, fh.student_id as st, s.class_id as stc,s.course_id,s.stud_category,s.transport_amt FROM `fee_transaction_head` fh inner join student s on fh.student_id=s.id  WHERE $str_query and fh.paid_status=1 and  fh.response_code=0 $str_query1
group by fh.id) as d group by payment_date")->result();
//        $fetch_transaction_date = $this->dbconnection->select("fee_transaction_head", "student_id as stud, payment_date", "payment_date>=DATE_FORMAT('$fdate', '%Y-%m-%d 00:00:00') and payment_date<=DATE_FORMAT('$tdate', '%Y-%m-%d 23:59:59') and paid_status=1 and response_code=0 $str_query1 ");
        $fee_details['fetch_transaction_date']=$fetch_transaction_date;
        $fee_type = $this->dbconnection->select_returnarray("fee_master", "id,fee_name,fee_cat_id", "status=1");
        $fee_details['fee_ty']=array_column($fee_type, 'fee_name', 'id');
        $fee_details['fee_cat']=array_column($fee_type, 'fee_cat_id', 'id');

        $fee_details['trans_status'] = $this->dbconnection->Get_namme("crmfeesclub.school", "id", $this->session->userdata('school_id'), "transport_fee");
        
        $fee_details['session_start_yr']=$this->session_start_yr;
        $fee_details['month_arr']= array('0'=>'', '1' => 'APR', '2' => 'MAY', '3' => 'JUN', '4' => 'JUL', '5' => 'AUG', '6' => 'SEP', '7' => 'OCT', '8' => 'NOV', '9' => 'DEC', '10' => 'JAN', '11' => 'FEB', '12' => 'MAR', '13' => 'APR', '14' => 'MAY');
        
        $class = $this->dbconnection->select_returnarray("class", "id,class_name", "status='Y'");
        $section = $this->dbconnection->select_returnarray("section", "id,sec_name", "status='Y'");
        
        $fee_details['class'] = array_column($class, 'class_name', 'id');
        $fee_details['section'] = array_column($section, 'sec_name', 'id');

        $this->load->view('feepayment/report/load_feehead_wise_term_report', $fee_details);
    }
    
    
    public function settle_report() {


        $this->data['page_title'] = 'Settlement Report';
        $this->data['section'] = 'feepayment/report';
        $this->data['page_name'] = 'settle_report';
        $this->data['customview'] = '';
        $this->data['school_date_created'] =$this->school_date_created;
        if ($this->input->post()) {


            $from = $this->input->post('from_date');
            $to = $this->input->post('to_date');


            $query = "SELECT date(payment_date) AS trxday,DATE_ADD(date(payment_date), INTERVAL 1 DAY) AS settle_card,DATE_ADD(date(payment_date), INTERVAL 2 DAY) AS settle_nb, " .
                    "sum(if(mode='CC',total_amount,0)) AS cc_amt, " .
                    "sum(if(mode='DC',total_amount,0)) AS dc_amt, " .
                    "sum(if(mode='DC' OR mode='CC',total_amount,0)) AS tot_card_amt, " .
                    "sum(if(mode='NB',total_amount,0)) AS nb_amt, " .
                    "sum(total_amount) AS grand_tot " .
                    "FROM fee_transaction_head WHERE payment_date>=DATE_FORMAT('$from', '%Y-%m-%d 00:00:00') and payment_date<=DATE_FORMAT('$to', '%Y-%m-%d 23:59:59') and status=1 and paid_status=1 and collection_centre='FCLB' GROUP BY trxday WITH ROLLUP;";
            $result = $this->db->query($query)->result();

            $this->data['data1'] = $result;
        }

        $this->load->view('index', $this->data);
    }
    
    
    public function student_ledger() {
        
        $class_id = $this->input->post('class_id');
        $section_id = $this->input->post('section_id');

        $select = "s.*,concat(s.first_name,' ',s.middle_name,' ',s.last_name) as name,(select class_name from class where id=s.class_id) as class_name,(select sec_name from section where id=s.section_id) as sec_name,(select cat_code from category where id=s.stud_category) as cat_code";

        if ($section_id == 'all' && $class_id == 'all') {
            $str_query = "where s.status='Y' and f1.year={$this->academic_session[0]->fin_year}";
        } else if ($section_id == 'all' && $class_id != 'all') {
            $str_query = "where s.class_id=$class_id and s.status='Y' and f1.year={$this->academic_session[0]->fin_year}";
        } else {

            $str_query = "where s.class_id=$class_id and s.section_id=$section_id and s.status='Y' and f1.year={$this->academic_session[0]->fin_year}";
        }

        $query_defaulter = $this->db->query("select $select,IF(month(f1.payment_date) = 4,f1.receipt_no,'') as apr_receipt_no,IF(month(f1.payment_date) = 4,f1.total_amount,'') as apr_total_amount,IF(month(f1.payment_date) =4,f1.payment_date,'') as apr_payment_date"
                . " ,IF(month(f1.payment_date) = 5,f1.receipt_no,'') as may_receipt_no,IF(month(f1.payment_date) = 5,f1.total_amount,'') as may_total_amount,IF(month(f1.payment_date) = 5,f1.payment_date,'') as may_payment_date"
                . " ,IF(month(f1.payment_date) = 6,f1.receipt_no,'') as jun_receipt_no,IF(month(f1.payment_date) = 6,f1.total_amount,'') as jun_total_amount,IF(month(f1.payment_date) = 6,f1.payment_date,'') as jun_payment_date"
                . " ,IF(month(f1.payment_date) = 7,f1.receipt_no,'') as jul_receipt_no,IF(month(f1.payment_date) = 7,f1.total_amount,'') as jul_total_amount,IF(month(f1.payment_date) = 7,f1.payment_date,'') as jul_payment_date"
                . " ,IF(month(f1.payment_date) = 8,f1.receipt_no,'') as aug_receipt_no,IF(month(f1.payment_date) = 8,f1.total_amount,'') as aug_total_amount,IF(month(f1.payment_date) = 8,f1.payment_date,'') as aug_payment_date"
                . " ,IF(month(f1.payment_date) = 9,f1.receipt_no,'') as sep_receipt_no,IF(month(f1.payment_date) = 9,f1.total_amount,'') as sep_total_amount,IF(month(f1.payment_date) = 9,f1.payment_date,'') as sep_payment_date"
                . " ,IF(month(f1.payment_date) = 10,f1.receipt_no,'') as oct_receipt_no,IF(month(f1.payment_date) = 10,f1.total_amount,'') as oct_total_amount,IF(month(f1.payment_date) = 10,f1.payment_date,'') as oct_payment_date"
                . " ,IF(month(f1.payment_date) = 11,f1.receipt_no,'') as nov_receipt_no,IF(month(f1.payment_date) = 11,f1.total_amount,'') as nov_total_amount,IF(month(f1.payment_date) = 11,f1.payment_date,'') as nov_payment_date"
                . " ,IF(month(f1.payment_date) = 12,f1.receipt_no,'') as dec_receipt_no,IF(month(f1.payment_date) = 12,f1.total_amount,'') as dec_total_amount,IF(month(f1.payment_date) = 12,f1.payment_date,'') as dec_payment_date"
                . " ,IF(month(f1.payment_date) = 1,f1.receipt_no,'') as jan_receipt_no,IF(month(f1.payment_date) = 1,f1.total_amount,'') as jan_total_amount,IF(month(f1.payment_date) = 1,f1.payment_date,'') as jan_payment_date"
                . " ,IF(month(f1.payment_date) = 2,f1.receipt_no,'') as feb_receipt_no,IF(month(f1.payment_date) = 2,f1.total_amount,'') as feb_total_amount,IF(month(f1.payment_date) = 2,f1.payment_date,'') as feb_payment_date"
                . " ,IF(month(f1.payment_date) = 3,f1.receipt_no,'') as mar_receipt_no,IF(month(f1.payment_date) = 3,f1.total_amount,'') as mar_total_amount,IF(month(f1.payment_date) = 3,f1.payment_date,'') as mar_payment_date"
                . " from student s left join (fee_transaction_head as f1 inner join fee_transaction_det d2 on f1.id=d2.fee_trans_head_id )"
                . " on f1.student_id=s.id and f1.paid_status=1  and f1.response_code=0 $str_query group by s.id ");

        $this->data['query_defaulter'] = $query_defaulter->result();

        $this->load->view('feepayment/report/load_fees_ledger', $this->data);
        
    }

    public function cheque_collection() {

//        $last = $this->uri->total_segments();
//  $id = $this->uri->segment($last);
        $this->data['page_title'] = 'Cheque Collection Report';
        $this->data['section'] = 'feepayment/report';
        $this->data['page_name'] = 'cheque_collection';
        $this->data['customview'] = '';
        $this->data['school_date_created'] =$this->school_date_created;

        $this->data['aclass'] = $this->dbconnection->select("class", "id,class_name", "status='Y'");
        $this->data['asection'] = $this->dbconnection->select("section", "id,sec_name", "status='Y'");
        $this->data['acategory'] = $this->dbconnection->select("category", "id,cat_name", "status='Y'");
        $this->data['collection_center'] = $this->dbconnection->select("collection_center", "id,collection_code,collection_desc", "status='Y'");
        $this->load->view('index', $this->data);
}
    
        public function paymentlogcheque_report() {

        $max_year = $this->dbconnection->select('accedemic_session', 'max(id) as max_year', 'status="Y" and active="Y"');
        $year = $max_year[0]->max_year;
        $class_id = $this->input->post('class_id');
        $section_id = $this->input->post('section_id');

        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $transac_type = $this->input->post('transac_type');
        $collection_center = $this->input->post('collection_center');

        if ($from_date == '') {
            $from_date = date('Y-m-d 00:00:00');
        }
        if ($to_date == '') {
            $str_query = "f1.payment_method='CHEQUE' and f1.cheque_status!='Cleared' and f1.payment_date like '%$from_date%'";
        } else {
            $str_query = "f1.payment_method='CHEQUE' and f1.cheque_status!='Cleared' and f1.payment_date>=DATE_FORMAT('$from_date', '%Y-%m-%d 00:00:00') and f1.payment_date<=DATE_FORMAT('$to_date', '%Y-%m-%d 23:59:59')";
        }

        if ($collection_center == 'all') {
            $str_query1 ='';
        } else {
            $str_query1 = "and f1.collection_centre= '$collection_center'";
        }

        if ($transac_type == 'all') {
            $str_query2 = "f1.remarks not like '%abandoned%'";
        } 
//        else if ($transac_type == 2) {
//            $str_query2 = "f1.payment_method='CHEQUE' and f1.paid_status=2";
//        } 
        else {
            $str_query2 = "f1.paid_status=$transac_type and f1.payment_method='CHEQUE' and f1.cheque_status!='Cleared' and f1.remarks not like '%abandoned%'";
        }

        if ($this->session->userdata('school_id') != 9) {
            $strquery3 = "";
        } else {
            $strquery3 = " and ( mode!='NB' or (mode='NB' and payment_date<'2017-04-24 00:00:00'))";
        }

        $order = '';
        $like = array();
        $or_like = array();
        $output = array();
        $offset = $this->input->post('start');
        $limit = $this->input->post('length');
//                $search_columns = array(
//              'alpha_num' => array(
//                                        'admission_no',
//                  'first_name',
//
//                  ),
//              'numeric' => array(
//                  
//                                         'admission_no'
//                  ),
//              );        
//                $search = $this->input->post('search');
//      if (ctype_digit($search['value'])) {
//          $search_cols = $search_columns['numeric'];
//      } else {
//          $search_cols = $search_columns['alpha_num'];
//      }
//      foreach ($search_cols AS $search_col) {
//          $or_like[] = array('col' => $search_col, 'val' => $search['value']); 
//      }
//                $transaction_history=$this->db->query("select f1.*,group_concat(distinct(f2.fee_cat_id)) as fee,count(case when f2.month_no<>0 then f2.month_no end) as m,min(case when f2.month_no<>0 then f2.month_no end) as from_month,max(f2.due_month_no) as d from fee_transaction_head f1, fee_transaction_det f2 where f1.student_id=$student_id and f1.year=$year and f1.response_message is not NULL and f1.id=f2.fee_trans_head_id group by f1.id");

        if ($class_id == 'all' && $section_id == 'all') {

            $where = "($str_query) $str_query1 and $str_query2 $strquery3";
//            $where = "f1.year=$year and ($str_query) $str_query1 and $str_query2 $strquery3";
        } else if ($section_id == 'all' && $class_id != 'all') {

            $where = "($str_query) $str_query1 and f1.student_id in ( select id from student where class_id=$class_id)"
                    . " and $str_query2 $strquery3";
//            $where = "f1.year=$year and ($str_query) $str_query1 and f1.student_id in ( select id from student where class_id=$class_id)"
//                    . " and $str_query2 $strquery3";
        } else if ($section_id != 'all' && $class_id == 'all') {

            $where = "($str_query) $str_query1 and f1.student_id in ( select id from student where section_id=$section_id) "
                    . "and $str_query2 $strquery3";
//            $where = "f1.year=$year and ($str_query) $str_query1 and f1.student_id in ( select id from student where section_id=$section_id) "
//                    . "and $str_query2 $strquery3";
        } else {

            $where = "($str_query) $str_query1 and f1.student_id in ( select id from student where class_id=$class_id "
                    . "and section_id=$section_id) and $str_query2 $strquery3";
//            $where = "f1.year=$year and ($str_query) $str_query1 and f1.student_id in ( select id from student where class_id=$class_id "
//                    . "and section_id=$section_id) and $str_query2 $strquery3";
        }

        $query = $this->db->query("select f1.*,(select concat(first_name,' ',middle_name,' ',last_name) from student where id=f1.student_id) as name,group_concat(distinct(f2.fee_cat_id)) as fee,count(case when f2.month_no<>0 and f2.fee_cat_id in (2,5) then f2.month_no end) as m,min(case when f2.month_no<>0 and f2.fee_cat_id in (2,5) then f2.month_no end) as from_month,max(f2.due_month_no) as d from fee_transaction_head f1, fee_transaction_det f2 where $where and f1.id=f2.fee_trans_head_id group by f1.id ");

        if ($offset != '') {

            $query_payment = $this->db->query("select f1.*,(select concat(first_name,' ',middle_name,' ',last_name) from student where id=f1.student_id) as name,group_concat(distinct(f2.fee_cat_id)) as fee,count(case when f2.month_no<>0 and f2.fee_cat_id in (2,5) then f2.month_no end) as m,min(case when f2.month_no<>0 and f2.fee_cat_id in (2,5) then f2.month_no end) as from_month,max(f2.due_month_no) as d from fee_transaction_head f1, fee_transaction_det f2 where $where and f1.id=f2.fee_trans_head_id group by f1.id  limit $limit offset $offset");
        } else {

            $query_payment = $this->db->query("select f1.*,(select concat(first_name,' ',middle_name,' ',last_name) from student where id=f1.student_id) as name,group_concat(distinct(f2.fee_cat_id)) as fee,count(case when f2.month_no<>0 and f2.fee_cat_id in (2,5) then f2.month_no end) as m,min(case when f2.month_no<>0 and f2.fee_cat_id in (2,5) then f2.month_no end) as from_month,max(f2.due_month_no) as d from fee_transaction_head f1, fee_transaction_det f2 where $where and f1.id=f2.fee_trans_head_id group by f1.id  limit $limit");
        }

//                $query_payment=$query_payment->result();
//                $query_payment = $this->dbconnection->select_limit_query("fee_trans_det", $select, $where, $order, $limit, $offset, $like, $or_like);
//                $count_filtered = $this->dbconnection->count("fee_trans_det", $where, $like, $or_like);
        $count_filtered = count($query->result());
        $output['draw'] = $this->input->post('draw');
        $output['recordsTotal'] = $count_filtered;
        $output['recordsFiltered'] = $count_filtered;

        $i = 0;
        $j = 0;
        $records_arr = array();
        $month_arr = array('1' => 'April', '2' => 'May', '3' => 'June', '4' => 'July', '5' => 'Aug', '6' => 'Sep', '7' => 'Oct', '8' => 'Nov', '9' => 'Dec', '10' => 'Jan', '11' => 'Feb', '12' => 'Mar', '13' => 'Apr', '14' => 'May');
        $total_amount=0;
        foreach ($query_payment->result() as $row) {
            $recarr = array();
            $recarr[] = $row->payment_date;
            $q = $this->dbconnection->select('student', 'admission_no,class_id,(select class_name from class where id=class_id) as class_name,'
                    . 'section_id,(select sec_name from section where id=section_id) as sec_name', "id=$row->student_id");
            $recarr[] = $q[0]->admission_no;
            $recarr[] = $row->name;
            $recarr[] = $q[0]->class_name;
            $recarr[] = $q[0]->sec_name;
            $fe_desc = explode(',', $row->fee);
            $str = '';
            foreach ($fe_desc as $index => $value) {
                if ($value == 2 || $value == 5) {
                    if ($row->m > 1) {

                        $month_var = $row->from_month + $row->m - 1;
                        $str .= $row->m . " Months Fees (" . $month_arr[$row->from_month] . " to " . $month_arr[$month_var] . "),";
                    } else {
                        $str .= $row->m . " Month Fees (" . $month_arr[$row->from_month] . "),";
                    }
                } else if ($value == 1) {
                    $str .= ' Annual Fees,';
                } else if ($value == 3) {
                    $otherfeeget = $this->dbconnection->select('fee_transaction_det', '(select fee_name from fee_master where id=other_fee_id) as otherfee', "fee_trans_head_id=$row->id and fee_cat_id=3");
                    $strotherfee = '';
                    foreach ($otherfeeget as $ot) {
                        $strotherfee .= $ot->otherfee . ',';
                    }
                    $strotherfee = rtrim($strotherfee, ',');
                    $str .= " Other Fees($strotherfee),";
                } else if ($value == 8) {
                    
                    $instfeeget = $this->dbconnection->select('fee_transaction_det', '(select fee_name from fee_master where id=other_fee_id) as instantfee', "fee_trans_head_id=$row->id and fee_cat_id=8");
                    $strinstfee = '';
                    foreach ($instfeeget as $ot1) {
                        $strinstfee .= $ot1->instantfee . ',';
                    }
                    $strinstfee = rtrim($strinstfee, ',');
                    $str .= " Instant/Misc. Fees($strinstfee),";
                } else if ($value == 4) {
                    $str .= ' Half-Yearly Fees,';
                } else if ($value == 0) {
                    if ($row->d > 1) {
                        $str .= ' ' . $row->d . ' Months Fine';
                    } else {
                        $str .= ' ' . $row->d . ' Month Fine';
                    }
                } else if ($value == 6) {
                    $transport_fee = $this->db->query("SELECT sum(amount) as fee_amount FROM fee_transaction_det  where fee_cat_id=6 and fee_trans_head_id=$row->id")->result();
                    $str .= ' Transport Fees,';
    //                $transport_fee = $q[0]->m * $student[0]->transport_amt;
                    $transport_fee = $transport_fee[0]->fee_amount;
                } else if ($value == 7) {
                    $str .= ' Instant Discount,';
                    $discount = $row->discount_amount;
                } else if ($value == 11) {
                    $str .= ' Readmission Fine,';
                    
                }
            }
           if($row->paid_status==2){
              $a= '<button type="button" name="clear" class="btn btn-success" value="'.$row->student_id.'" onclick="changestatus('. $row->id.','. $row->total_amount.');">Clear</button>'
                . '<button type="button" name="decline" class="btn btn-danger" onclick="changestatusbounce('. $row->id.','. $row->total_amount.');">Bounce</button>';
           }
           elseif($row->paid_status==0){
               $a= '<button type="button" name="clear" class="btn btn-success" value="'.$row->student_id.'" onclick="changestatus('. $row->id.','. $row->total_amount.');">Clear</button>'
                . '<button type="button" name="decline" class="btn btn-danger" onclick="changestatusbounce('. $row->id.','. $row->total_amount.');">Bounce</button>'; 
           }
           else{
               $a='<button type="button" name="button" class="btn btn-primary">PAID</button>';
           }
//           }
            $str = rtrim($str, ',');

            $recarr[] = $str;
            $recarr[] = $row->total_amount;
            $recarr[] = $row->remarks . ' (' . $row->response_message . ')';
//            $recarr[] = $row->transaction_id;
//            $recarr[] = $row->payment_id;
            $recarr[] = $row->payment_method;
            $recarr[] = $row->mode;
            $recarr[] = $row->receipt_no;
            $recarr[] = $this->session->userdata('school_code') . '-' . $q[0]->admission_no . '-' . $row->id;
            $recarr[] = $row->cheque_no;
            $recarr[] = $row->cheque_status;
            $recarr[] = $a;
            $records_arr[] = $recarr;
            $total_amount=$total_amount+$row->total_amount;

        }

       
//        $records_arr[] = ['Total','','','','','',$total_amount,'','','','','','',''];
        $output['data'] = $records_arr;
        echo json_encode($output);
    }
    
        public function exportpaymentlogcheque() {
        
        $max_year = $this->dbconnection->select('accedemic_session', 'max(id) as max_year', 'status="Y" and active="Y"');
        $year = $max_year[0]->max_year;
        $class_id = $this->input->post('annuallstClass');
        $section_id = $this->input->post('annuallstSection');
        $collection_center = $this->input->post('collection_center');
        $transac_type = $this->input->post('transac_type');
        $from_date = $this->input->post('st_date');
        $to_date = $this->input->post('ed_date');



        if ($to_date == '') {
            $str_query = "f1.payment_method='CHEQUE' and f1.payment_date like '%$from_date%'";
        } else {
            $str_query = "f1.payment_method='CHEQUE' and f1.payment_date>=DATE_FORMAT('$from_date', '%Y-%m-%d 00:00:00') and f1.payment_date<=DATE_FORMAT('$to_date', '%Y-%m-%d 23:59:59')";
        }

        if ($collection_center == 'all') {
            $str_query1 = '';
        } else {
            $str_query1 = " and f1.collection_centre= '$collection_center'";
        }
        
        if ($transac_type == 'all') {
            $str_query2 = "f1.remarks not like '%abandoned%'";
        } else {
            $str_query2 = " f1.paid_status=$transac_type and f1.remarks not like '%abandoned%'";
        }
//                $select="*,(select concat(first_name,' ',middle_name,' ',last_name) from student where id=student_id) as name";

        if ($this->session->userdata('school_id') != 9) {
            $strquery3 = "";
        } else {
            $strquery3 = " and ( mode!='NB' or (mode='NB' and payment_date<'2017-04-24 00:00:00'))";
        }

        if ($class_id == 'all' && $section_id == 'all') {
            $where = "($str_query) $str_query1 and $str_query2 $strquery3";
//            $where = "f1.year=$year and ($str_query) $str_query1 and $str_query2 $strquery3";
        } else if ($section_id == 'all' && $class_id != 'all') {
            $where = "($str_query) $str_query1 and f1.student_id in ( select id from student where class_id=$class_id)"
                    . " and $str_query2 $strquery3";
//            $where = "f1.year=$year and ($str_query) $str_query1 and f1.student_id in ( select id from student where class_id=$class_id)"
//                    . " and $str_query2 $strquery3";
        } else if ($section_id != 'all' && $class_id == 'all') {
            $where = "($str_query) $str_query1 and f1.student_id in ( select id from student where section_id=$section_id) "
                    . "and $str_query2 $strquery3";
//            $where = "f1.year=$year and ($str_query) $str_query1 and f1.student_id in ( select id from student where section_id=$section_id) "
//                    . "and $str_query2 $strquery3";
        } else {
            $where = "($str_query) $str_query1 and f1.student_id in ( select id from student where class_id=$class_id "
                    . "and section_id=$section_id) and $str_query2 $strquery3";
//            $where = "f1.year=$year and ($str_query) $str_query1 and f1.student_id in ( select id from student where class_id=$class_id "
//                    . "and section_id=$section_id) and $str_query2 $strquery3";
        }


        $filename = "Cheque Log -Export-" . date('Ymd') . ".csv";

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $filename);

        $display_columns = array('payment_date' => 'Payment Date',
            'admission_no' => 'Admission No', 'name' => 'Student&apos;s Name',
            'class' => 'Class', 'sec_name' => 'Section', 'description' => 'Description',
            'amount' => 'Total Paid Amount', 'remarks' => 'Remarks',
            'payment_method' => 'Payment Method', 'mode' => 'Payment Mode',
            'receipt_no' => 'Receipt No.', 'order_no' => 'Order Id','cheque_no'=>'Cheque No.','cheque_status'=>'Cheque Status'
        );
        $colnames = array();
        foreach ($display_columns as $field => $disp) {
            $colnames[] = $disp;
        }


        $out = fopen('php://output', 'w');
        fputcsv($out, $colnames);

        $query_payment = $this->db->query("select f1.*,(select concat(first_name,' ',middle_name,' ',last_name) from student where id=f1.student_id) as name,group_concat(distinct(f2.fee_cat_id)) as fee,count(case when f2.month_no<>0 and f2.fee_cat_id in (2,5) then f2.month_no end) as m,min(case when f2.month_no<>0 and f2.fee_cat_id in (2,5) then f2.month_no end) as from_month,max(f2.due_month_no) as d from fee_transaction_head f1, fee_transaction_det f2 where $where and f1.id=f2.fee_trans_head_id group by f1.id");

        $month_arr = array('1' => 'April', '2' => 'May', '3' => 'June', '4' => 'July', '5' => 'Aug', '6' => 'Sep', '7' => 'Oct', '8' => 'Nov', '9' => 'Dec', '10' => 'Jan', '11' => 'Feb', '12' => 'Mar', '13' => 'Apr', '14' => 'May');
        foreach ($query_payment->result() as $row) {
            $recarr = array();
            $recarr[] = $row->payment_date;
            $q = $this->dbconnection->select('student', 'admission_no,class_id,(select class_name from class where id=class_id) as class_name,section_id,(select sec_name from section where id=section_id) as sec_name', "id=$row->student_id");
            $recarr[] = $q[0]->admission_no;
            $recarr[] = $row->name;
            $recarr[] = $q[0]->class_name;
            $recarr[] = $q[0]->sec_name;
            $fe_desc = explode(',', $row->fee);
            $str = '';
            foreach ($fe_desc as $index => $value) {
                if ($value == 2 || $value == 5) {
                    if ($row->m > 1) {

                        $month_var = $row->from_month + $row->m - 1;
                        $str .= $row->m . " Months Fees (" . $month_arr[$row->from_month] . " to " . $month_arr[$month_var] . "),";
                    } else {
                        $str .= $row->m . " Month Fees (" . $month_arr[$row->from_month] . "),";
                    }
                } else if ($value == 1) {
                    $str .= ' Annual Fees,';
                } else if ($value == 3) {

                    $otherfeeget = $this->dbconnection->select('fee_transaction_det', '(select fee_name from fee_master where id=other_fee_id) as otherfee', "fee_trans_head_id=$row->id and fee_cat_id=3");
                    $strotherfee = '';
                    foreach ($otherfeeget as $ot) {
                        $strotherfee .= $ot->otherfee . ',';
                    }
                    $strotherfee = rtrim($strotherfee, ',');
                    $str .= " Other Fees($strotherfee),";
                } else if ($value == 8) {
                    
                    $instfeeget = $this->dbconnection->select('fee_transaction_det', '(select fee_name from fee_master where id=other_fee_id) as instantfee', "fee_trans_head_id=$row->id and fee_cat_id=8");
                    $strinstfee = '';
                    foreach ($instfeeget as $ot1) {
                        $strinstfee .= $ot1->instantfee . ',';
                    }
                    $strinstfee = rtrim($strinstfee, ',');
                    $str .= " Instant/Misc. Fees($strinstfee),";
                }  else if ($value == 4) {
                    $str .= ' Half-Yearly Fees,';
                } else if ($value == 0) {
                    if ($row->d > 1) {
                        $str .= ' ' . $row->d . ' Months Fine';
                    } else {
                        $str .= ' ' . $row->d . ' Month Fine';
                    }
                }else if ($value == 6) {
                    $transport_fee = $this->db->query("SELECT sum(amount) as fee_amount FROM fee_transaction_det  where fee_cat_id=6 and fee_trans_head_id=$row->id")->result();
                    $str .= ' Transport Fees,';
    //                $transport_fee = $q[0]->m * $student[0]->transport_amt;
                    $transport_fee = $transport_fee[0]->fee_amount;
                } else if ($value == 7) {
                    $str .= ' Instant Discount,';
                    $discount = $row->discount_amount;
                } else if ($value == 11) {
                    $str .= ' Readmission Fine,';
                    
                }
            }
            $str = rtrim($str, ',');

            $recarr[] = $str;
            $recarr[] = $row->total_amount;
            $recarr[] = $row->remarks . ' ' . $row->response_message;
//            $recarr[] = $row->transaction_id;
//            $recarr[] = $row->payment_id;
            $recarr[] = $row->payment_method;
            $recarr[] = $row->mode;
            $recarr[] = $row->receipt_no;
            $recarr[] = $this->session->userdata('school_code') . '-' . $q[0]->admission_no . '-' . $row->id;
            $recarr[] = $row->cheque_no;
            $recarr[] = $row->cheque_status;

            fputcsv($out, $recarr);
        }
        fclose($out);
    }
    public function update_cheque_collection_status() {

        $id = $this->input->post('fee_trans_head_id');
        $previous_data=$this->dbconnection->select("fee_transaction_head","*","id=$id");
        $remarks=$previous_data[0]->remarks;
        $data = array(
            'paid_status' => 1,
            'remarks' => $remarks.'-'.'Cheque Cleared',
            'cheque_status' =>'Cleared',
            'date_modified' => date('Y-m-d H:i:s'),
            'modified_by' => $this->session->userdata('user_id'),
        );
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
    
    public function update_cheque_collection_status_bounce() {

        $id = $this->input->post('fee_trans_head_id');
        $previous_data=$this->dbconnection->select("fee_transaction_head","*","id=$id");
        $remarks=$previous_data[0]->remarks;
        $data = array(
            'paid_status' => 0,
            'remarks' => $remarks.'-'.'Cheque Bounce',
            'cheque_status' =>'Bounce',
            'date_modified' => date('Y-m-d H:i:s'),
            'modified_by' => $this->session->userdata('user_id'),
        );
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

    //function defaulter army

        public function defaulters_test() {
        
        $this->data['page_title'] = 'Fee Defaulters';
        $this->data['section'] = 'feepayment/report';
        $this->data['page_name'] = 'defaulters_onetime';
        $this->data['customview'] = '';
        $this->data['school_date_created'] =$this->school_date_created;
        $this->data['aclass'] = $this->dbconnection->select("class", "id,class_name", "status='Y'");
        $this->data['asection'] = $this->dbconnection->select("section", "id,sec_name", "status='Y'");
        $this->data['acategory'] = $this->dbconnection->select("category", "id,cat_name", "status='Y'");
        $this->data['session_end_date'] = $this->academic_session[0]->end_date;
        $this->data['collection_center'] = $this->dbconnection->select("collection_center", "id,collection_code,collection_desc", "status='Y'");
        $schoolgrp=$this->dbconnection->Get_namme("crmfeesclub.school","id",$this->id,"school_group");
        $this->data['schoolgrp'] = $schoolgrp;
        $this->load->view('index', $this->data);
    }

        public function defaulter_report_test() 
        {
     //   error_reporting(-1);
     // ini_set('display_errors', 1);
        $class_id = $this->input->post('class_id');
        $section_id = $this->input->post('section_id');

        $term = $this->input->post('term');
        $indication = $this->input->post('indication');
        $month = $this->input->post('choosetillmonth');

        $qtrmonth = $this->input->post('choosetillmonth');
        /* -------------- */
        if ($month >= 4 && $month <= 12) {
           $month = $month - 3;
        } else {
           $month = $month + 9;
        }
        
        
        /* ------------------ */

        if (date('Y-m-d') > $this->academic_session[0]->end_date) {
            $month = 12;
        }

        $order = '';
        $like = array();
        $or_like = array();
        $output = array();
        $offset = $this->input->post('start');
        $limit = $this->input->post('length');

        $select = "s.id,s.admission_no,concat(s.first_name,' ',s.middle_name,' ',s.last_name) as name,s.class_id,s.stud_category,s.course_id,(select class_name from class where id=s.class_id) as class_name,(select sec_name from section where id=s.section_id) as sec_name,(select cat_code from category where id=s.stud_category) as cat_code,s.father_name,s.phone,s.transport_amt,s.start_fee_month,s.student_type";

        if ($section_id == 'all' && $class_id == 'all') {
            $str_query = "where s.status='Y' ";
        } else if ($section_id == 'all' && $class_id != 'all') {
            $str_query = "where s.class_id=$class_id and s.status='Y' ";
        } else if ($section_id != 'all' && $class_id == 'all') {
            $str_query = "where s.section_id=$section_id and s.status='Y' ";
        } 
        else {

            $str_query = "where s.class_id=$class_id and s.section_id=$section_id and s.status='Y' ";
        }

        if($qtrmonth==6)
        {
            $start_query="and s.start_fee_month in (1,2,3)";
        }
        else if($qtrmonth==9)
        {
            $start_query="and s.start_fee_month in (1,2,3,4,5,6)";
        }
        else if($qtrmonth==6)
        {
            $start_query="and s.start_fee_month in (1,2,3,4,5,6,7,8,9)";
        }
        else
        {
            $start_query="and s.start_fee_month in (1,2,3,4,5,6,7,8,9,10,11,12)";
        }


        $month_arr = array(1 => 'April', '2' => 'May', '3' => 'June', '4' => 'July', '5' => 'Aug', '6' => 'Sep', '7' => 'Oct', '8' => 'Nov', '9' => 'Dec', '10' => 'Jan', '11' => 'Feb', '12' => 'Mar');

        if($indication=='monthwise'){
            $month_no_query="'$month_arr[$month]'";
        }else{
             $month_no_query="cast($month-count(d2.month_no) as char)";
        }

        if ($term == 'all') {
            $query_defaulter = $this->db->query("select $select,if(count(f1.id)=0,'Unpaid','Paid') as annual,if(count(f1.id)=0,'Unpaid','Paid') as onetime,if(count(d2.month_no)>=$month"
                    . " ,'Paid',$month_no_query) as monthly from student as s"
                    . " left join ( fee_transaction_head as f1 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d1 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f1.id=d1.fee_trans_head_id and d1.fee_cat_id=1 and f1.year={$this->academic_session[0]->fin_year})"
                    . " on f1.student_id=s.id and f1.paid_status=1 "
                    . " left join ( fee_transaction_head as f2 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d2 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f2.id=d2.fee_trans_head_id and d2.fee_cat_id=5 and f2.year={$this->academic_session[0]->fin_year})"
                    . " on f2.student_id=s.id and f2.paid_status=1  and f2.response_code=0  $str_query $start_query group by s.id having ( annual!='Paid' or monthly!='Paid' and monthly!=0 or onetime!='Paid')")->result();

            if ($offset == '') {
                $str_query2 = "limit $limit";
            } else {
                $str_query2 = "limit $limit offset $offset";
            }
            $query = $this->db->query("select $select,if(count(f1.id)=0,'Unpaid','Paid') as annual,if(count(f1.id)=0,'Unpaid','Paid') as onetime,if(count(d2.month_no)>=$month"
                    . " ,'Paid',$month_no_query) as monthly from student as s"
                    . " left join ( fee_transaction_head as f1 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d1 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f1.id=d1.fee_trans_head_id and d1.fee_cat_id=1 and f1.year={$this->academic_session[0]->fin_year})"
                    . " on f1.student_id=s.id and f1.paid_status=1 "
                    . " left join ( fee_transaction_head as f2 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d2 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f2.id=d2.fee_trans_head_id and d2.fee_cat_id=5 and f2.year={$this->academic_session[0]->fin_year})"
                    . " on f2.student_id=s.id and f2.paid_status=1  and f2.response_code=0  $str_query $start_query  group by s.id having ( annual!='Paid' or monthly!='Paid' or onetime!='Paid' ) $str_query2");
        } else if ($term == '1') {

            $query_defaulter = $this->db->query("select $select,if(count(f1.id)=0,'Unpaid','Paid') as annual,"
                    . " '' as monthly,'' as onetime from student as s"
                    . " left join ( fee_transaction_head as f1 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d1 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f1.id=d1.fee_trans_head_id and d1.fee_cat_id=1 and f1.year={$this->academic_session[0]->fin_year})"
                    . " on f1.student_id=s.id and f1.paid_status=1 "
                    . " $str_query group by s.id having ( annual!='Paid')")->result();

            if ($offset == '') {
                $str_query2 = "limit $limit";
            } else {
                $str_query2 = "limit $limit offset $offset";
            }
            $query = $this->db->query("select $select,if(count(f1.id)=0,'Unpaid','Paid') as annual,"
                    . " '' as monthly,'' as onetime from student as s"
                    . " left join ( fee_transaction_head as f1 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d1 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f1.id=d1.fee_trans_head_id and d1.fee_cat_id=1 and f1.year={$this->academic_session[0]->fin_year})"
                    . " on f1.student_id=s.id and f1.paid_status=1 "
                    . " $str_query group by s.id having ( annual!='Paid') $str_query2");
        } 
        else if ($term == '3') {

            $query_defaulter = $this->db->query("select $select,if(count(f1.id)=0,'Unpaid','Paid') as onetime,"
                    . " '' as monthly,'' as annual from student as s"
                    . " left join ( fee_transaction_head as f1 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d1 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f1.id=d1.fee_trans_head_id and d1.fee_cat_id=1 and f1.year={$this->academic_session[0]->fin_year})"
                    . " on f1.student_id=s.id and f1.paid_status=1 "
                    . " $str_query group by s.id having ( onetime!='Paid' and s.student_type!='EXISTING')")->result();

            if ($offset == '') {
                $str_query2 = "limit $limit";
            } else {
                $str_query2 = "limit $limit offset $offset";
            }
            $query = $this->db->query("select $select,if(count(f1.id)=0,'Unpaid','Paid') as onetime,"
                    . " '' as monthly,'' as annual from student as s"
                    . " left join ( fee_transaction_head as f1 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d1 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f1.id=d1.fee_trans_head_id and d1.fee_cat_id=1 and f1.year={$this->academic_session[0]->fin_year})"
                    . " on f1.student_id=s.id and f1.paid_status=1 "
                    . " $str_query group by s.id having (onetime!='Paid' and s.student_type!='EXISTING') $str_query2");
        }
        else 
        {
            if($qtrmonth==6)
            {
                $query_defaulter = $this->db->query("select $select,'' as annual,'' as onetime,if(count(d2.month_no)>=$month"
                    . " ,'Paid',$month_no_query) as monthly from student as s"
                    . " left join ( fee_transaction_head as f2 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d2 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f2.id=d2.fee_trans_head_id and d2.fee_cat_id in (2,5) and f2.year={$this->academic_session[0]->fin_year})"
                    . " on f2.student_id=s.id and f2.paid_status=1 and f2.response_code=0 $str_query $start_query group by s.id having (monthly!='Paid')")->result();
            }
            else if($qtrmonth==9)
            {
                $query_defaulter = $this->db->query("select $select,'' as annual,'' as onetime,if(count(d2.month_no)>=$month"
                    . " ,'Paid',$month_no_query) as monthly from student as s"
                    . " left join ( fee_transaction_head as f2 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d2 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f2.id=d2.fee_trans_head_id and d2.fee_cat_id in (2,5) and f2.year={$this->academic_session[0]->fin_year})"
                    . " on f2.student_id=s.id and f2.paid_status=1  and f2.response_code=0 $str_query $start_query group by s.id having ( monthly!='Paid')")->result();
            }
            else if($qtrmonth==12)
            {
                $query_defaulter = $this->db->query("select $select,'' as annual,'' as onetime,if(count(d2.month_no)>=$month"
                    . " ,'Paid',$month_no_query) as monthly from student as s"
                    . " left join ( fee_transaction_head as f2 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d2 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f2.id=d2.fee_trans_head_id and d2.fee_cat_id in (2,5) and f2.year={$this->academic_session[0]->fin_year})"
                    . " on f2.student_id=s.id and f2.paid_status=1  and f2.response_code=0  $str_query $start_query group by s.id having ( monthly!='Paid')")->result();
            }
            else
            {
                 $query_defaulter = $this->db->query("select $select,'' as annual,'' as onetime,if(count(d2.month_no)>=$month"
                    . " ,'Paid',$month_no_query) as monthly from student as s"
                    . " left join ( fee_transaction_head as f2 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d2 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f2.id=d2.fee_trans_head_id and d2.fee_cat_id in (2,5) and f2.year={$this->academic_session[0]->fin_year})"
                    . " on f2.student_id=s.id and f2.paid_status=1  and f2.response_code=0  $str_query $start_query group by s.id having ( monthly!='Paid')")->result();
            }

            if ($offset == '') 
            {
                $str_query2 = "limit $limit";
            } 
            else 
            {
                $str_query2 = "limit $limit offset $offset";
            }
            if ($qtrmonth==6)
            {
                $query = $this->db->query("select $select,'' as annual,'' as onetime,if(count(d2.month_no)>=$month"
                    . " ,'Paid',$month_no_query) as monthly from student as s"
                    . " left join ( fee_transaction_head as f2 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d2 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f2.id=d2.fee_trans_head_id and d2.fee_cat_id in (2,5) and f2.year={$this->academic_session[0]->fin_year})"
                    . " on f2.student_id=s.id and f2.paid_status=1 and f2.response_code=0  $str_query $start_query group by s.id having ( monthly!='Paid') $str_query2");
            }
            else if ($qtrmonth==9)
            {
                $query = $this->db->query("select $select,'' as annual,'' as onetime,if(count(d2.month_no)>=$month"
                    . " ,'Paid',$month_no_query) as monthly from student as s"
                    . " left join ( fee_transaction_head as f2 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d2 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f2.id=d2.fee_trans_head_id and d2.fee_cat_id in (2,5) and f2.year={$this->academic_session[0]->fin_year})"
                    . " on f2.student_id=s.id and f2.paid_status=1 and f2.response_code=0 $str_query $start_query group by s.id having ( monthly!='Paid') $str_query2");
            }
            else if ($qtrmonth==12)
            {
                $query = $this->db->query("select $select,'' as annual,'' as onetime,if(count(d2.month_no)>=$month"
                    . " ,'Paid',$month_no_query) as monthly from student as s"
                    . " left join ( fee_transaction_head as f2 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d2 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f2.id=d2.fee_trans_head_id and d2.fee_cat_id in (2,5) and f2.year={$this->academic_session[0]->fin_year})"
                    . " on f2.student_id=s.id and f2.paid_status=1 and f2.response_code=0 $str_query $start_query group by s.id having ( monthly!='Paid') $str_query2");
            }
            else
            {
                 $query = $this->db->query("select $select,'' as annual,'' as onetime,if(count(d2.month_no)>=$month"
                    . " ,'Paid',$month_no_query) as monthly from student as s"
                    . " left join ( fee_transaction_head as f2 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d2 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f2.id=d2.fee_trans_head_id and d2.fee_cat_id in (2,5) and f2.year={$this->academic_session[0]->fin_year})"
                    . " on f2.student_id=s.id and f2.paid_status=1 and f2.response_code=0 $str_query $start_query group by s.id having ( monthly!='Paid') $str_query2");
            }
           
        }



        $count_filtered = count($query_defaulter);


        $search_columns = array(
            'alpha_num' => array(
                'admission_no',
                'first_name',
            ),
            'numeric' => array(
                'admission_no'
            ),
        );

        $search = $this->input->post('search');
        if (ctype_digit($search['value'])) {
            $search_cols = $search_columns['numeric'];
        } else {
            $search_cols = $search_columns['alpha_num'];
        }
        foreach ($search_cols AS $search_col) {
            $or_like[] = array('col' => $search_col, 'val' => $search['value']);
        }

        $output['draw'] = $this->input->post('draw');
        $output['recordsTotal'] = $count_filtered;
        $output['recordsFiltered'] = $count_filtered;


        $stud_cat_query = $this->db->query("select id from category where status='Y'")->result_array();
        

        $sfees = array();
        foreach ($stud_cat_query as $scq) {
            $fee_query = $this->db->query("select s.id,s.year, Sum(Case When s1.fee_cat in(2,5) Then s1.fee_amount Else 0 End) mon, Sum(Case When s1.fee_cat = 1 Then s1.fee_amount Else 0 End) ann,Sum(Case When s1.fee_cat in (9,10) Then s1.fee_amount Else 0 End) one  from class_fee_head s, class_fee_det s1 where s.id=s1.class_fee_head_id  and  s1.status=1 and s1.stud_cat={$scq['id']} group by s.id")->result_array();
            foreach ($fee_query as $fq) {

                $sfees[$scq['id']][$fq['id']]['mon'] = $fq['mon'];
                $sfees[$scq['id']][$fq['id']]['ann'] = $fq['ann'];
                $sfees[$scq['id']][$fq['id']]['one'] = $fq['one'];
            }
        }



        $records_arr = array();
        $e = 1;
        $totsum=0;
       
//        echo $month_arr[5]; 
        foreach ($query->result() as $row) 
        {


            $recarr = array();
//          $recarr[] = $e;
            $recarr[] = $row->admission_no;
            $recarr[] = $row->name;
            $recarr[] = $row->class_name;
            $recarr[] = $row->sec_name;
            
            $recarr[] = $row->cat_code;
//            $recarr[] = $row->father_name;
            $recarr[] = $row->phone;
            $recarr[] = $row->annual;
            $recarr[] = $row->onetime;
            $recarr[] = $row->student_type;
            $recarr[] = $row->start_fee_month;


            $clasfeehead = $this->db->query("select id from class_fee_head where from_class_id<=$row->class_id and to_class_id>=$row->class_id and course=$row->course_id and status='Y' and year<=$this->session_start_yr order by id desc limit 1")->result_array();
            

            if ($row->annual == 'Paid' || $row->annual == '') {
                $anns = 0;
            } else {
                $anns = $sfees[$row->stud_category][$clasfeehead[0]['id']]['ann'];
            }

            if ($row->onetime == 'Paid' || $row->onetime == '' || $row->student_type == 'EXISTING') {
                $one = 0;
            } else {
                $one = $sfees[$row->stud_category][$clasfeehead[0]['id']]['one'];
            }
            if($row->start_fee_month!= '1'){

                 // $rest_month = (12-$start_fee_month)+1;
                 $abc=$row->monthly-($row->start_fee_month-1);
            }

            else{
                $abc=$row->monthly;
            }
           
            if ($row->monthly == 'Paid' || $row->monthly == '') {
                $mons = 0;
                $h = '';
            }

             else {
                
                if($indication=='monthwise'){
                    $mons = $sfees[$row->stud_category][$clasfeehead[0]['id']]['mon'];
                    $h='';
                }else{
                    $schoolgrp=$this->dbconnection->Get_namme("crmfeesclub.school","id",$this->id,"school_group");
                    $this->data['schoolgrp'] = $schoolgrp;
                    if($schoolgrp=='ARMY')
                    {
                        $f = explode(' ', $row->monthly);

                        $mons = $abc * $sfees[$row->stud_category][$clasfeehead[0]['id']]['mon']/3;
                      
                            // $mn = $month - ($row->monthly - 1);

                            if($row->start_fee_month!= '1'){
                                 $mn=$month - (($row->monthly - 1)-($row->start_fee_month-1));
                            }
                            else{
                                 $mn = $month - ($row->monthly - 1);
                            }


                            if ($month_arr[$mn] == $month_arr[$month]) 
                            {
                                $h = ' months Unpaid-(' . $month_arr[$mn] . ')';
                            } 
                            else 
                            {
                                $h = ' months Unpaid-(' . $month_arr[$mn] . ' to ' . $month_arr[$month] . ')';
                            }
                    }
                    else
                    {

                    }
                   
                }
            }
            $sum_fees = $mons + $anns + $row->transport_amt + $one;
            $recarr[] = $abc/3 . ' ' .'Quarter Unpaid' . ' '. $h;
            $recarr[] = $sum_fees;
            $records_arr[] = $recarr;
            $e++;
        }

                
        $output['data'] = $records_arr;
      // print_r($output['data']);
      // die()
        echo json_encode($output);
    }


        public function exportdefaulters_test() {
        
        $class_id = $this->uri->segment(4);
        $section_id = $this->uri->segment(5);
        $term = $this->uri->segment(6);
        $month = $this->uri->segment(7);
        $indication = $this->uri->segment(8);
        
         /* -------------- */
        if ($month >= 4 && $month <= 12) {
            $month = $month - 3;
        } else {
            $month = $month + 9;
        }
        /* ------------------ */

        if (date('Y-m-d') > $this->academic_session[0]->end_date) {
            $month = 12;
        }

        $select = "s.id,s.admission_no,concat(s.first_name,' ',s.middle_name,' ',s.last_name) as name,s.class_id,s.stud_category,s.course_id,(select class_name from class where id=s.class_id) as class_name,(select sec_name from section where id=s.section_id) as sec_name,(select cat_code from category where id=s.stud_category) as cat_code,s.father_name,s.phone,s.transport_amt,s.start_fee_month";

        if ($section_id == 'all' && $class_id == 'all') {
            $str_query = "where s.status='Y' ";
        } else if ($section_id == 'all' && $class_id != 'all') {
            $str_query = "where s.class_id=$class_id and s.status='Y' ";
        } else {

            $str_query = "where s.class_id=$class_id and s.section_id=$section_id and s.status='Y' ";
        }

        $month_arr = array(1 => 'April', '2' => 'May', '3' => 'June', '4' => 'July', '5' => 'Aug', '6' => 'Sep', '7' => 'Oct', '8' => 'Nov', '9' => 'Dec', '10' => 'Jan', '11' => 'Feb', '12' => 'Mar', '13' => 'Apr', '14' => 'May');
        
        $month_arr_qtr = array(3 => 'April', '3' => 'May', '3' => 'June', '6' => 'July', '6' => 'Aug', '6' => 'Sep', '9' => 'Oct', '9' => 'Nov', '9' => 'Dec', '12' => 'Jan', '12' => 'Feb', '12' => 'Mar', '13' => 'Apr', '14' => 'May');

        $head = (date('Y-m-d') > $this->academic_session[0]->end_date) ? 'Till March' : 'Including Current Month-' . date('M');

        if($indication=='monthwise'){
            $month_no_query="'$month_arr[$month]'";
            
            $display_columns = array(
                'admission_no' => 'Admission No', 'name' => "Student\'s Name",
                'class' => 'Class', 'sec_name' => 'Section','cat_code' => 'Fee Category',
               'phone'=>'Phone No.','annual' => 'Annual','onetime' => 'Onetime',
                'monthly' => "Unpaid Month", 'amount' => 'Total Unpaid Amount',
            );
            
        }else{
            $month_no_query="cast($month-count(d2.month_no) as char)";
            
            $display_columns = array(
                'admission_no' => 'Admission No', 'name' => 'Student&apos;s Name',
                'class' => 'Class', 'sec_name' => 'Section','cat_code' => 'Fee Category',
                'phone'=>'Phone No.','annual' => 'Annual','onetime' => 'Onetime',
                'monthly' => "Monthly ($head)", 'amount' => 'Total Unpaid Amount',
            );
        }
        
        if ($term == 'all') {// Both Term
            $query_defaulter = $this->db->query("select $select,if(count(f1.id)=0,'Unpaid','Paid') as annual,if(count(f1.id)=0,'Unpaid','Paid') as onetime,if(count(d2.month_no)>=$month"
                    . " ,'Paid',$month_no_query) as monthly from student as s"
                    . " left join ( fee_transaction_head as f1 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d1 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f1.id=d1.fee_trans_head_id and d1.fee_cat_id=1 and f1.year={$this->academic_session[0]->fin_year})"
                    . " on f1.student_id=s.id and f1.paid_status=1 "
                    . " left join ( fee_transaction_head as f2 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d2 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f2.id=d2.fee_trans_head_id and d2.fee_cat_id in (2,5) and d2.fee_cat_id in (9,10) and f2.year={$this->academic_session[0]->fin_year})"
                    . " on f2.student_id=s.id and f2.paid_status=1 and f2.response_code=0  $str_query   group by s.id having ( annual!='Paid' or monthly!='Paid' or onetime!='Paid')");
        } else if ($term == '1') { //For Annual
            $query_defaulter = $this->db->query("select $select,if(count(f1.id)=0,'Unpaid','Paid') as annual,"
                    . " '' as monthly,'' as onetime from student as s"
                    . " left join ( fee_transaction_head as f1 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d1 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f1.id=d1.fee_trans_head_id and d1.fee_cat_id=1 and f1.year={$this->academic_session[0]->fin_year})"
                    . " on f1.student_id=s.id and f1.paid_status=1 "
                    . " $str_query  group by s.id having ( annual!='Paid')");
        } 
        else if ($term == '3') { //For onetime
            $query_defaulter = $this->db->query("select $select,if(count(f1.id)=0,'Unpaid','Paid') as onetime,"
                    . " '' as monthly,'' as annual from student as s"
                    . " left join ( fee_transaction_head as f1 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d1 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f1.id=d1.fee_trans_head_id and d1.fee_cat_id in (9,10) and f1.year={$this->academic_session[0]->fin_year})"
                    . " on f1.student_id=s.id and f1.paid_status=1 "
                    . " $str_query  group by s.id having ( onetime!='Paid')");
        } 
        else { // For Monthly
            $query_defaulter = $this->db->query("select $select,'' as annual,'' as onetime,if(count(d2.month_no)>=$month"
                    . " ,'Paid',$month_no_query) as monthly from student as s"
                    . " left join ( fee_transaction_head as f2 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d2 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f2.id=d2.fee_trans_head_id and d2.fee_cat_id in (2,5) and f2.year={$this->academic_session[0]->fin_year})"
                    . " on f2.student_id=s.id and f2.paid_status=1 and f2.response_code=0  $str_query  group by s.id having ( monthly!='Paid')");
        }

        $school_code=$this->session->userdata('school_code');
        $filename = "$school_code-Defaulters-Export-" . date('Ymd') . ".csv";

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $filename);
       
        
        $colnames = array();
        foreach ($display_columns as $field => $disp) {
            $colnames[] = $disp;
        }

        $out = fopen('php://output', 'w');
        fputcsv($out, $colnames);

        $stud_cat_query = $this->db->query("select id from category where status='Y'")->result_array();


        $sfees = array();
        foreach ($stud_cat_query as $scq) {
            $fee_query = $this->db->query("select s.id, Sum(Case When s1.fee_cat in (2,5) Then s1.fee_amount Else 0 End) mon, Sum(Case When s1.fee_cat = 1 Then s1.fee_amount Else 0 End) ann,Sum(Case When s1.fee_cat in(9,10) Then s1.fee_amount Else 0 End) one  from class_fee_head s, class_fee_det s1 where s.id=s1.class_fee_head_id  and  s1.status=1 and s1.stud_cat={$scq['id']} group by s.id")->result_array();

            foreach ($fee_query as $fq) {
                $sfees[$scq['id']][$fq['id']]['mon'] = $fq['mon'];
                $sfees[$scq['id']][$fq['id']]['ann'] = $fq['ann'];
                $sfees[$scq['id']][$fq['id']]['one'] = $fq['one'];
            }
        }
        $records_arr = array();
        $totsum=0;
        foreach ($query_defaulter->result() as $row) {


            $recarr = array();
            $recarr[] = $row->admission_no;
            $recarr[] = $row->name;
            $recarr[] = $row->class_name;
            $recarr[] = $row->sec_name;
            
            $recarr[] = $row->cat_code;
//            $recarr[] = $row->father_name;
            $recarr[] = $row->phone;
            $recarr[] = $row->annual;
            $recarr[] = $row->onetime;
            $recarr[] = $row->student_type;
            $recarr[] = $row->start_fee_month;

            $clasfeehead = $this->db->query("select id from class_fee_head where from_class_id<=$row->class_id and to_class_id>=$row->class_id and course=$row->course_id and status='Y' and year<=$this->session_start_yr order by id desc limit 1")->result_array();;


            if ($row->annual == 'Paid' || $row->annual == '') {
                $anns = 0;
            } else {
                $anns = $sfees[$row->stud_category][$clasfeehead[0]['id']]['ann'];
            }
            if($row->student_type == 'EXISTING'){
                 $one = 'PAID';
            }
            else
            {
                if ($row->onetime == 'Paid' || $row->onetime == '' || $row->student_type == 'EXISTING') {
                $one = 0;
            } else {
                $one = $sfees[$row->stud_category][$clasfeehead[0]['id']]['one'];
            }
            }
           

            if ($row->monthly == 'Paid' || $row->monthly == '') {
                $mons = 0;
                $h = '';
            } else {
                
                if($indication=='monthwise'){
                    $mons = $sfees[$row->stud_category][$clasfeehead[0]['id']]['mon'];
                    $h='';
                }else{
                    $schoolgrp=$this->dbconnection->Get_namme("crmfeesclub.school","id",$this->id,"school_group");
                    $this->data['schoolgrp'] = $schoolgrp;
                    if($schoolgrp=='ARMY'){
                         $f = explode(' ', $row->monthly);
                         $mons = $f[0] * $sfees[$row->stud_category][$clasfeehead[0]['id']]['mon']/3;
                    //$mons = $f[0] * $sfees[$row->stud_category][$clasfeehead[0]['id']]['mon'];
                    $mn = $month - ($row->monthly - 1);
                    if ($month_arr[$mn] == $month_arr[$month]) {
                        $h = ' months Unpaid-(' . $month_arr[$mn] . ')';
                    } else {
                        $h = ' months Unpaid-(' . $month_arr[$mn] . ' to ' . $month_arr[$month] . ')';
                    }
                   
                    }
                    else{
                        $f = explode(' ', $row->monthly);
                    $mons = $f[0] * $sfees[$row->stud_category][$clasfeehead[0]['id']]['mon'];
                    $mn = $month - ($row->monthly - 1);
                    if ($month_arr[$mn] == $month_arr[$month]) {
                        $h = ' months Unpaid-(' . $month_arr[$mn] . ')';
                    } else {
                        $h = ' months Unpaid-(' . $month_arr[$mn] . ' to ' . $month_arr[$month] . ')';
                    }
                }
                   
                }
            }
            $sum_fees = $mons + $anns + $row->transport_amt + $one;
            $recarr[] = $row->monthly . $h;
            $recarr[] = $sum_fees;
            $totsum+=$sum_fees;
            fputcsv($out, $recarr);
        }
        $recarr=array('Total','','','','','','','','',$totsum);
        fputcsv($out, $recarr);
        fclose($out);
    }

    public function print_dsr()
    {
        echo $collection_center=$this->input->post('collection_center');
        echo $date=$this->input->post('report_date');
    }



}
