<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Report_Army extends CI_Controller {

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


       public function monthlyfees_wise_fee_summary() {

       //  error_reporting(-1);
       // ini_set('display_errors', 1);
        $fdate = $this->input->post('frmdate');
        $tdate = $this->input->post('todate');
        if ($this->input->post('colcenter') == 'all') {
            $str_query1 = '';
        } else {
            $str_query1 = " and fh.collection_centre= '{$this->input->post('colcenter')}'";
        }

        $str_query = "fh.payment_date>=DATE_FORMAT('$fdate', '%Y-%m-%d 00:00:00') and fh.payment_date<=DATE_FORMAT('$tdate', '%Y-%m-%d 23:59:59')"; 
        
        $fee_details=array();
        $fetch_transaction_date=$this->db->query("SELECT fh.id,group_concat(distinct(fd.fee_cat_id)) fee_cat,fd.class_fee_head_id, fh.payment_method,fh.transaction_id,DATE_FORMAT(fh.payment_date, '%d-%m-%Y') payment_date,fh.total_amount,fh.response_message,fh.student_id,s.admission_no,concat(s.first_name,' ',s.middle_name,' ',s.last_name) as name,s.class_id,s.section_id,fd.stud_category,s.course_id,s.roll,s.transport_amt,s.start_fee_month,GROUP_CONCAT(distinct(fd.month_no) order by fd.month_no) month_details,fh.discount_amount,fh.receipt_no,fh.remarks,fh.mode FROM `fee_transaction_head` fh inner join student s on fh.student_id=s.id inner join fee_transaction_det fd on fd.fee_trans_head_id=fh.id WHERE $str_query and fh.paid_status=1 and  fh.response_code=0 $str_query1 group by fh.id")->result();

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
        
        $this->load->view('feepayment/report/load_monthlyfee_wise_fee_summ_army', $fee_details);
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
        $this->load->view('feepayment/report/load_monthly_wise_fee_summ_army', $this->data1);
    }


    public function daily_wise_fee_summary() {

        $date = date('Y-m-d', strtotime($this->input->post('date')));
        $this->data['fee_details'] = $this->find_fee($date);
        $this->data['trans_status'] = $this->dbconnection->Get_namme("crmfeesclub.school", "id", $this->session->userdata('school_id'), "transport_fee");
        $this->load->view('feepayment/report/load_daily_wise_fee_summ_army', $this->data);
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
            // $fee_head_id1 = $this->dbconnection->select("fee_transaction_head", "id", "student_id=$q->stud and paid_status=1 and response_code=0 and MONTH(payment_date)='$month' and Year(payment_date)=$yearmn and year={$this->academic_session[0]->fin_year} $str_query1 $strquery3 ");

            $fee_head_id1 = $this->db->query("select fth.id,ftd.stud_category FROM fee_transaction_head fth ,fee_transaction_det ftd where fth.id=ftd.fee_trans_head_id and fth.student_id=$q->stud and fth.paid_status=1 and fth.response_code=0 and MONTH(fth.payment_date)='$month' and Year(fth.payment_date)=$yearmn and fth.year={$this->academic_session[0]->fin_year}")->result();

            // print_r($fee_head_id1);
            // die();

            $stud = $this->dbconnection->select("student", "id,admission_no,stud_category,(select cat_name from category where id=stud_category) as stud_cat_name,concat(first_name,' ', middle_name,' ',last_name) as name,class_id,(select class_name from class where id=class_id) as class_name, (select sec_name from section where id=section_id) as sec_name,course_id,transport_amt,start_fee_month", "id=$q->stud");
            
            $monthly_fee['admission'][$i] = $stud[0]->admission_no;
            $monthly_fee['studclass'][$i] = $stud[0]->class_name . ' ' . $stud[0]->sec_name;
            $monthly_fee['studname'][$i] = $stud[0]->name;
            $stud_class = $stud[0]->class_id;
            $stud_course = $stud[0]->course_id;
            $monthly_fee['stud_cat'][$i] = $stud[0]->stud_cat_name;
            $stud_cat = $fee_head_id1[0]->stud_category;
            $start_fee_month = $stud[0]->start_fee_month;
            $total = 0;
            foreach ($fee_type as $row) {
                
                $max_class_year = $this->dbconnection->select('class_fee_head', 'max(year) as max_year, max(id) as max_id', "(from_class_id<=$stud_class and to_class_id>=$stud_class) and course=$stud_course and status='Y' and year<=$this->session_start_yr");
                 $s=($row->fee_cat_id==3)?'':"and stud_cat=$stud_cat";
                $class_fee = $this->dbconnection->select("class_fee_det", "fee_amount,fee_cat,fee_id", "class_fee_head_id={$max_class_year[0]->max_id} $s  and stud_cat=$stud_cat and status=1 and fee_id=" . $row->id);
                if ($row->fee_cat_id!=8 && count($class_fee) > 0) {
                    $fee_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,fee_cat_id,month_no", "fee_trans_head_id in (select id from fee_transaction_head where student_id=$q->stud and paid_status=1 and response_code=0 and MONTH(payment_date)='$month' and Year(payment_date)=$yearmn and year={$this->academic_session[0]->fin_year} $str_query1 $strquery3 ) and fee_cat_id=" . $class_fee[0]->fee_cat);
                    $fee_amt = 0;
                    if (count($fee_qry) > 0) {
                        foreach ($fee_qry as $rfee) {
                            $fee_amt = $fee_amt + $class_fee[0]->fee_amount;
                            $total += $class_fee[0]->fee_amount;
                        }
                        $monthly_fee['fee_amnt'][$i][$row->id] = $fee_amt;
                    } else {
                        $monthly_fee['fee_amnt'][$i][$row->id] = 0;
                        $total += 0;
                    }
                } else if($row->fee_cat_id==8){
                    $fee_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,month_no,amount,other_fee_id", "fee_trans_head_id in (select id from fee_transaction_head where student_id=$q->stud and paid_status=1 and response_code=0 and MONTH(payment_date)='$month' and Year(payment_date)=$yearmn and year={$this->academic_session[0]->fin_year} $str_query1 $strquery3 ) and fee_cat_id=8");
                    $fee_amt=0;
                    if (count($fee_qry) > 0) {

                         if($fee_qry[0]->month_no!=0)
                        {
                            if($row->fee_cat_id==5)
                            {
                                $de=$class_fee[0]->fee_amount/3;
                            }
                            else
                            {
                                $de=$class_fee[0]->fee_amount;
                            }
                        }

                        else
                        {

                             if($row->fee_cat_id==1)
                                      {
                                          // $start_fee_month=$stud[0]->start_fee_month;
                                           $rest_month = (12-$start_fee_month)+1;
                                            $fee_amount = $class_fee[0]->fee_amount;
                                            $fee_id     = $class_fee[0]->fee_id;
                                            if($fee_id==10 || $fee_id==16)
                                            {
                                                $de = $fee_amount;
                                            }                
                                            else
                                            {
                                                $de = ($fee_amount/12)*$rest_month;
                                            }
                                      }
                                      else{
                                        $dee=$class_fee[0]->fee_amount/12;
                                        $de=$dee*12;
                                      }


                        }
                        foreach ($fee_qry as $rfee) {
                                
                                $fee_amt = $fee_amt + $de;
                                $total += $de;

                        }
                        $monthly_fee['fee_amnt'][$i][$row->id] = $fee_amt;

                        // foreach ($fee_qry as $rfee) {
                        //     $fee_amt = $fee_amt + $rfee->amount;
                        //     $total += $rfee->amount;
                        // }
                        // $monthly_fee['fee_amnt'][$i][$row->id] = $fee_amt;
                    }else {
                        $monthly_fee['fee_amnt'][$i][$row->id] = 0;
                        $total += 0;
                    }
                    
                }  else {
                    $monthly_fee['fee_amnt'][$i][$row->id] = 0;
                    $total += 0;
                }
            }

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
        foreach ($fee_type as $row) {
            $fee_details['f_name'][$row->id] = $row->fee_name;
        }

        foreach ($fetch_transaction_date as $q) {
            $j = 0;
            $stud = $this->dbconnection->select("student", "id,admission_no,stud_category,(select cat_name from category where id=stud_category) as stud_cat_name,concat(first_name,' ', middle_name,' ',last_name) as name,class_id,(select class_name from class where id=class_id) as class_name, (select sec_name from section where id=section_id) as sec_name,course_id,transport_amt,start_fee_month", "id=$q->stud");
            $fee_details['admission'][$i] = $stud[0]->admission_no;
            $fee_details['studclass'][$i] = $stud[0]->class_name . ' ' . $stud[0]->sec_name;
            $fee_details['studname'][$i] = $stud[0]->name;
            $stud_class = $stud[0]->class_id;
            $stud_course = $stud[0]->course_id;
            $start_fee_month = $stud[0]->start_fee_month;
            $fee_details['stud_cat'][$i] = $stud[0]->stud_cat_name;
            $stud_cat = $stud[0]->stud_category;
            $total = 0;


            foreach ($fee_type as $row) {

                $max_class_year = $this->dbconnection->select('class_fee_head', 'max(year) as max_year, max(id) as max_id', "(from_class_id<=$stud_class and to_class_id>=$stud_class) and course=$stud_course and status='Y' and year<=$this->session_start_yr");
                
                $s=($row->fee_cat_id==3)  ?'':"and stud_cat=$stud_cat";
                $class_fee = $this->dbconnection->select("class_fee_det", "fee_amount,fee_cat,fee_id", "class_fee_head_id={$max_class_year[0]->max_id} $s and status=1 and stud_cat=$stud_cat and fee_id=" . $row->id );
                if ($row->fee_cat_id!=8 && count($class_fee) > 0) {
                    $fee_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,month_no", "fee_trans_head_id in (select id from fee_transaction_head where student_id=$q->stud and paid_status=1 and response_code=0 and payment_date Like '%$date%' $str_query1 $strquery3 ) and fee_cat_id=" . $class_fee[0]->fee_cat);
                    $fee_amt = 0;
                    if (count($fee_qry) > 0) {


                        if($fee_qry[0]->month_no!=0)
                        {
                            if($row->fee_cat_id==5)
                            {
                                $de=$class_fee[0]->fee_amount/3;
                            }
                            else
                            {
                                $de=$class_fee[0]->fee_amount;
                            }
                        }

                        else
                        {

                             if($row->fee_cat_id==1)
                                      {
                                          // $start_fee_month=$stud[0]->start_fee_month;
                                           $rest_month = (12-$start_fee_month)+1;
                                            $fee_amount = $class_fee[0]->fee_amount;
                                            $fee_id     = $class_fee[0]->fee_id;
                                            if($fee_id==10 || $fee_id==16)
                                            {
                                                $de = $fee_amount;
                                            }                
                                            else
                                            {
                                                $de = ($fee_amount/12)*$rest_month;
                                            }
                                      }
                                      else{
                                        $dee=$class_fee[0]->fee_amount/12;
                                        $de=$dee*12;
                                      }


                        }
                        foreach ($fee_qry as $rfee) {
                                
                                $fee_amt = $fee_amt + $de;
                                $total += $de;

                        }
                        $fee_details['fee_amnt'][$i][$row->id] = $fee_amt;

                    } else {
                        $fee_details['fee_amnt'][$i][$row->id] = 0;
                        $total += 0;
                        $fee_amt = 0;
                        // $total += 0;
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


    public function feehead_wise_term_report() 
    {
       
        $fdate = $this->input->post('from_date');
        $tdate = $this->input->post('to_date');
        
        if ($this->input->post('collection_center') == 'all') 
        {
            $str_query1 = '';
        } 
        else 
        {
            $str_query1 = " and t1.collection_centre= '{$this->input->post('collection_center')}'";
        }

        $str_query = "t1.payment_date>=DATE_FORMAT('$fdate', '%Y-%m-%d 00:00:00') and t1.payment_date<=DATE_FORMAT('$tdate', '%Y-%m-%d 23:59:59')"; 
        
        $fee_details=array(); 
        $mode=array();
      
        $fee_details['paymodeqry']=$this->dbconnection->select("crmfeesclub.mode","id,mode_name");
        // $fetch_transaction_date=$this->db->query("select payment_date,group_concat(fhid order by fhid) as fhid,sum(total_amount) total_amount,group_concat(mode order by fhid) as mode,group_concat(total_amount order by fhid) as ttamt,sum(discount_amount) discount_amount,group_concat(st order by fhid) studentid,group_concat(sfm order by fhid) st_fe_mn,group_concat(stc order by fhid ) classid,group_concat(course_id order by fhid) courseid,group_concat(stud_category order by fhid) stud_category,sum(transport_amt) transport_amt from (SELECT fh.id as fhid,DATE_FORMAT(fh.payment_date, '%Y-%m-%d') payment_date,fh.total_amount,fh.mode,fh.discount_amount, fh.student_id as st, s.class_id as stc,s.start_fee_month as sfm,s.course_id,ftd.stud_category,s.transport_amt FROM `fee_transaction_head` fh inner join fee_transaction_det ftd on fh.id=ftd.fee_trans_head_id inner join student s on fh.student_id=s.id  WHERE $str_query and fh.paid_status=1 and  fh.response_code=0 $str_query1 group by fh.id) as d group by payment_date")->result();
        
        $fetch_transaction_date = $this->db->query("SELECT group_concat(t1.id order by t1.id) as fhid,group_concat(t1.student_id order by t1.id) studentid,group_concat(t1.mode order by t1.id) as mode,group_concat(t1.total_amount order by t1.id) as ttamt,sum(t1.discount_amount) discount_amount,DATE_FORMAT(t1.payment_date, '%Y-%m-%d') as payment_date,sum(t1.total_amount) total_amount,group_concat(t3.class_id order by t1.id ) classid,group_concat(t3.course_id order by t1.id) courseid,group_concat(t3.start_fee_month order by t1.id) st_fe_mn FROM fee_transaction_head as t1 JOIN student as t3 ON t3.id=t1.student_id WHERE $str_query and t1.response_code=0 AND t1.status=1 AND t1.paid_status=1 $str_query1 GROUP BY CAST(payment_date AS DATE)")->result();
        echo '<pre>';
        print_r($fetch_transaction_date);
        die();
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

        $this->load->view('feepayment/report/load_feehead_wise_term_report_army', $fee_details);
    }


    public function date_wise_term_report() 
    {
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $collection_center = $this->input->post('collection_center');

        if ($collection_center == 'all') 
        {
            $str_query1 = '';
        } 
        else 
        {
            $str_query1 = " and collection_centre= '$collection_center'";
        }

        if ($this->session->userdata('school_id') != 9) 
        {
            $strquery3 = "";
        } 
        else 
        {
            $strquery3 = " and ( mode!='NB' or (mode='NB' and payment_date<'2017-04-24 00:00:00'))";
        }

        $tran_date = array();
        $onetime_amount = array();
        $annual_amount = array();
        $monthly_amount = array();
        $count_transac = array();
        $grand_total = array();

        if ($to_date == '') 
        {
            $fetch_transaction_date = $this->db->query("SELECT distinct(DATE(payment_date)) as date_pay FROM fee_transaction_head WHERE payment_date like '%$from_date%' $str_query1 $strquery3 order by date_pay ");
        } 
        else 
        {
            $fetch_transaction_date = $this->db->query("SELECT distinct(DATE(payment_date)) as date_pay FROM fee_transaction_head WHERE payment_date>=DATE_FORMAT('$from_date', '%Y-%m-%d 00:00:00') and payment_date<=DATE_FORMAT('$to_date', '%Y-%m-%d 23:59:59') $str_query1 $strquery3 order by date_pay");
        }

        $query = $fetch_transaction_date->result();
        $i = 0;
        $total_cnt_transac = 0;
        $total_annual_amt = 0;
        $total_onetime_amt = 0;
        $total_monthly_amt = 0;
        $total_grand_amt = 0;
        $mode=array();
      
        $paymodeqry=$this->dbconnection->select("crmfeesclub.mode","id,mode_name");
        
        foreach ($query as $transac_date) 
        {
            $tran_date[$i] = $transac_date->date_pay;

            $query_annual_amount = $this->db->query("SELECT sum(amount) as ann_amt,count(distinct(fee_trans_head_id)) as cnt_ann  FROM fee_transaction_det WHERE fee_trans_head_id in (select id from fee_transaction_head where payment_date LIKE '%$transac_date->date_pay%' and paid_status=1 and response_code=0 $str_query1 $strquery3 ) and fee_cat_id=1");
            $q = $query_annual_amount->result();
            $annual_amount[$i] = $q[0]->ann_amt;
            $total_annual_amt = $total_annual_amt + $annual_amount[$i];


            $query_onetime_amount = $this->db->query("SELECT sum(amount) as one_amt,count(distinct(fee_trans_head_id)) as cnt_one  FROM fee_transaction_det WHERE fee_trans_head_id in (select id from fee_transaction_head where payment_date LIKE '%$transac_date->date_pay%' and paid_status=1 and response_code=0 $str_query1 $strquery3 ) and fee_cat_id in (9,10)");
            $qone = $query_onetime_amount->result();
            $onetime_amount[$i] = $qone[0]->one_amt;
            $total_onetime_amt = $total_onetime_amt + $onetime_amount[$i];

            $query_monthly_amount = $this->db->query("SELECT sum(amount) as mon_amt,count(distinct(fee_trans_head_id)) as cnt_mon  FROM fee_transaction_det WHERE fee_trans_head_id in (select id from fee_transaction_head where payment_date LIKE '%$transac_date->date_pay%' and paid_status=1 and response_code=0 $str_query1 $strquery3) and fee_cat_id in (2,0,11,6,3,8,5)");
            $q1 = $query_monthly_amount->result();

            $query_discount_amount = $this->db->query("SELECT sum(discount_amount) as discount_amount  FROM fee_transaction_head where payment_date LIKE '%$transac_date->date_pay%' and paid_status=1 and response_code=0 $str_query1 $strquery3");
            $q2 = $query_discount_amount->result();
            $monthly_amount[$i] = $q1[0]->mon_amt -$q2[0]->discount_amount;
            $total_monthly_amt = $total_monthly_amt + $monthly_amount[$i] - $q2[0]->discount_amount;
            
            $count_transac[$i] = $qone[0]->cnt_one + $q[0]->cnt_ann + $q1[0]->cnt_mon;
            $total_cnt_transac = $total_cnt_transac + $count_transac[$i];
            $grand_total[$i] = $onetime_amount[$i] +$annual_amount[$i] + $monthly_amount[$i];
            $total_grand_amt = $total_grand_amt + $grand_total[$i];
            
            
            foreach ($paymodeqry as $p) 
            {
                $qmode = $this->db->query("SELECT sum(total_amount) as total_amount  FROM fee_transaction_head WHERE payment_date LIKE '%$transac_date->date_pay%' and paid_status=1 and response_code=0 and mode='$p->mode_name' $str_query1 $strquery3 ")->result();
                $mode[$i][$p->id]=$qmode[0]->total_amount;
            }
            
            $i++;
        }

        $data = array(
            'tran_date'         => $tran_date,
            'annual_amount'     => $annual_amount,
            'onetime_amount'    => $onetime_amount,
            'monthly_amount'    => $monthly_amount,
            'count_transac'     => $count_transac,
            'mode'              => $mode,
            'paymodeqry'        => $paymodeqry,
            'grand_total'       => $grand_total,
            'cnti'              => $i,
            'total_cnt_transac' => $total_cnt_transac,
            'total_annual_amt'  => $total_annual_amt,
            'total_onetime_amt' => $total_onetime_amt,
            'total_monthly_amt' => $total_monthly_amt,
            'total_grand_amt'   => $total_grand_amt,
        );

        $this->load->view('feepayment/report/load_date_wise_term_report_army', $data);
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
        $onetime_amount = array();
        $monthly_amount = array();
        $grand_total = array();


        $fetch_category = $this->db->query("select * from category where status='Y'");
        $query = $fetch_category->result();
        $i = 0;
        $total_annual_amt = 0;
        $total_onetime_amt = 0;
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


            $query_onetime_amount = $this->db->query("SELECT sum(amount) as one_amt,count(distinct(fee_trans_head_id)) as cnt_one  FROM fee_transaction_det WHERE fee_trans_head_id in (select id from fee_transaction_head where $str_query $str_query1 $strquery3 and paid_status=1) and fee_cat_id in(9,10) and stud_category=$category->id");
            $q1 = $query_onetime_amount->result();
            $onetime_amount[$i] = $q1[0]->one_amt;
            $total_onetime_amt = $total_onetime_amt + $onetime_amount[$i];

            $query_monthly_amount = $this->db->query("SELECT sum(amount) as mon_amt,count(amount) as cnt_mon  FROM fee_transaction_det WHERE fee_trans_head_id in ( select id from fee_transaction_head where $str_query $str_query1 $strquery3 and paid_status=1) and fee_cat_id in (2,0,11,6,3,8,5) and stud_category=$category->id ");
            $q1 = $query_monthly_amount->result();

            
            $query_discount_amount = $this->db->query("SELECT sum(amount) as discount_amount  FROM fee_transaction_det WHERE fee_trans_head_id in ( select id from fee_transaction_head where $str_query $str_query1 $strquery3 and paid_status=1) and (fee_cat_id=7) and stud_category=$category->id ");
            $q2 = $query_discount_amount->result();
            $monthly_amount[$i] = $q1[0]->mon_amt -$q2[0]->discount_amount;
            $total_monthly_amt = $total_monthly_amt + $monthly_amount[$i] ;

            $grand_total[$i] = $onetime_amount[$i] +$annual_amount[$i] + $monthly_amount[$i];
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
            'onetime_amount' => $onetime_amount,
            'monthly_amount' => $monthly_amount,
            'mode' => $mode,
            'paymodeqry' => $paymodeqry,
            'grand_total' => $grand_total,
            'total_annual_amt' => $total_annual_amt,
            'total_onetime_amt' => $total_onetime_amt,
            'total_monthly_amt' => $total_monthly_amt,
            'total_grand_amt' => $total_grand_amt,
            'cnti' => $i,
        );

        $this->load->view('feepayment/report/load_category_wise_term_report_army.php', $data);
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
        $onetime_amount = array();
        $annual_amount = array();
        $monthly_amount = array();

        $grand_total = array();
        $cntj = array();

        $query = $this->dbconnection->select("class", "id, class_name", "status='Y'");

        $i = 0;
        $j = 0;
        $total_onetime_amt = array();
        $total_annual_amt = array();
        $total_monthly_amt = array();
        $total_grand_amt = array();
        
        $mode=array();
      
        $paymodeqry=$this->dbconnection->select("crmfeesclub.mode","id,mode_name");
        foreach ($query as $cls) {

            $tot_one_amt = 0;
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
                    $query_onetime_amount = $this->db->query("SELECT sum(amount) as one_amt,count(amount) as cnt_one  FROM fee_transaction_det WHERE  fee_trans_head_id in( select id from fee_transaction_head where $str_query $str_query1 $strquery3 and paid_status=1 and student_id in (select id from student where class_id=$cls->id and section_id=$sec)) and fee_cat_id in(9,10)");

                    $query_monthly_amount = $this->db->query("SELECT sum(amount) as mon_amt,count(amount) as cnt_mon  FROM fee_transaction_det WHERE fee_trans_head_id in( select id from fee_transaction_head where $str_query $str_query1 $strquery3 and paid_status=1 and student_id in (select id from student where class_id=$cls->id and section_id=$sec) ) and fee_cat_id in (2,0,11,6,3,8,5) ");
                    $query_discount_amount = $this->db->query("SELECT sum(amount) as discount_amount  FROM fee_transaction_det WHERE fee_trans_head_id in( select id from fee_transaction_head where $str_query $str_query1 $strquery3 and paid_status=1 and student_id in (select id from student where class_id=$cls->id and section_id=$sec) ) and (fee_cat_id=7) ");
                } else {
                    $query_annual_amount = $this->db->query("SELECT sum(amount) as ann_amt,count(amount) as cnt_ann  FROM fee_transaction_det WHERE  fee_trans_head_id in( select id from fee_transaction_head where $str_query $str_query1 $strquery3 and paid_status=1 and student_id in (select id from student where class_id=$cls->id and section_id=$sec and stud_category=$category)) and fee_cat_id=1 ");
                    $query_onetime_amount = $this->db->query("SELECT sum(amount) as one_amt,count(amount) as cnt_one  FROM fee_transaction_det WHERE  fee_trans_head_id in( select id from fee_transaction_head where $str_query $str_query1 $strquery3 and paid_status=1 and student_id in (select id from student where class_id=$cls->id and section_id=$sec and stud_category=$category)) and fee_cat_id in (9,10) ");
                    $query_monthly_amount = $this->db->query("SELECT sum(amount) as mon_amt,count(amount) as cnt_mon  FROM fee_transaction_det WHERE fee_trans_head_id in( select id from fee_transaction_head where $str_query $str_query1 $strquery3 and paid_status=1  and student_id in (select id from student where class_id=$cls->id and section_id=$sec and stud_category=$category)) and fee_cat_id in (2,0,11,6,3,8,5) ");
                    $query_discount_amount = $this->db->query("SELECT sum(amount) as discount_amount  FROM fee_transaction_det WHERE fee_trans_head_id in( select id from fee_transaction_head where $str_query $str_query1 $strquery3 and paid_status=1  and student_id in (select id from student where class_id=$cls->id and section_id=$sec and stud_category=$category)) and (fee_cat_id=7) ");
                }

                $q = $query_annual_amount->result();
                $annual_amount[$i][$j] = $q[0]->ann_amt;
                $tot_ann_amt = $tot_ann_amt + $annual_amount[$i][$j];

                $qone = $query_onetime_amount->result();
                $onetime_amount[$i][$j] = $qone[0]->one_amt;
                $tot_one_amt = $tot_one_amt + $onetime_amount[$i][$j];


                $q1 = $query_monthly_amount->result();
                $q2 = $query_discount_amount->result();
                $monthly_amount[$i][$j] = $q1[0]->mon_amt-$q2[0]->discount_amount;
                $tot_mon_amt = $tot_mon_amt + $monthly_amount[$i][$j] -$q2[0]->discount_amount;

//                        $count_transac[$i]=$q[0]->cnt_ann+$q1[0]->cnt_mon;
                $grand_total[$i][$j] = $onetime_amount[$i][$j] + $annual_amount[$i][$j] + $monthly_amount[$i][$j];
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
            $total_onetime_amt[$i] = $tot_one_amt;
            $total_annual_amt[$i] = $tot_ann_amt;
            $total_monthly_amt[$i] = $tot_mon_amt;
            $total_grand_amt[$i] = $tot_grand_amt;
            $j = 0;
            $i++;
        }

        $data = array(
            'class' => $class,
            'section' => $section,
            'onetime_amount' => $onetime_amount,
            'annual_amount' => $annual_amount,
            'monthly_amount' => $monthly_amount,
//                        'count_transac'=>$count_transac,
            'mode' => $mode,
            'paymodeqry' => $paymodeqry,
            'grand_total' => $grand_total,
            'total_onetime_amt' => $total_onetime_amt,
            'total_annual_amt' => $total_annual_amt,
            'total_monthly_amt' => $total_monthly_amt,
            'total_grand_amt' => $total_grand_amt,
            'cnti' => $i,
            'cntj' => $cntj,
        );

        $this->load->view('feepayment/report/load_class_wise_term_report_army.php', $data);
    }

    }