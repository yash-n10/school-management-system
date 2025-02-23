<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Backend extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (empty($this->session->userdata('user_id')) || $this->session->userdata('user_group_id') != 1) {
            redirect('/login');
        }
        error_reporting(-1);
        ini_set('display_errors', 1);
        $this->month_arr = array(0 => "", 1 => "Apr", 2 => "May", 3 => "Jun", 4 => "Jul", 5 => "Aug", 6 => "Sep", 7 => "Oct", 8 => "Nov", 9 => "Dec", 10 => "Jan", 11 => "Feb", 12 => "Mar", 13 => "Apr", 14 => "May", 15 => "Jun", 16 => "Jul", 17 => "Aug", 18 => "Sep", 19 => "Oct",);
//		$this->data['user'] = $this->dbconnection->select('user','*','id = '.$this->session->userdata('user_id'));
    }
    public function functionName() {
        $this->load->view('backend/index');
    }

    public function transactionUpdate() {


        $school = $this->dbconnection->select("school", "*", "status=1");
        $data = array(
            'school' => $school,
            'page_name' => 'select_school',
            'page_title' => 'Fees Transaction Update',
            'section' => 'backend',
            'customview' => '',
        );
        $this->load->view('index', $data);
    }

    public function trans_notupdate_info() {
        $school_code = $this->input->post('school_code');
        $school_id = $this->input->post('school_id');
//        $fetch = $this->dbconnection->select("feesclub_v4.gateway_response", "merchant_ref_no,date", "merchant_ref_no like '$school_code%' and response_code=0 and response_message like '%Transaction Successful%'", "date", "ASC");
//        $fetch = $this->dbconnection->select("gateway_response", "merchant_ref_no,date", "merchant_ref_no like '$school_code%' and response_code=0 and response_message like '%Transaction Successful%'", "date", "ASC");

        $fetch = $this->db->query("select merchant_ref_no,date from gateway_response where merchant_ref_no like '$school_code%' and response_code=0 and response_message like 'Transaction Successful%'"
                . " UNION select merchant_ref_no,date from gateway_response where merchant_ref_no like '$school_code%' and response_message like 'Captured%'"
                . " UNION select merchant_ref_no,date from gateway_response where merchant_ref_no like '$school_code%' and response_message like 'Success%' order by date ASC");
        $fetch = $fetch->result();


        $return = '';
        $return .= "<table class='table table-bordered table-striped' id='tbl_trans_not_update' style='width:100%'>";
        $return .= "<thead>";
        $return .= "<tr><th colspan='4' style='text-align:center'>LIST OF TRANSACTION NOT UPDATED</th></tr>";
        $return .= "<tr>";
        $return .= "<th>Order Id /Merchant Ref No</th>";
        $return .= "<th>Admission No</th>";
        $return .= "<th>Payment Date</th>";
        $return .= "<th>Action Log</th>";
        $return .= "<th>Update Payment</th>";

        $return .= "</tr>";
        $return .= "</thead>";
        $return .= "<tbody>";
        foreach ($fetch as $r) {

            $d = explode('-', $r->merchant_ref_no);
            $f = $this->dbconnection->select("crmfeesclub_$school_id.fee_transaction_head", "id,student_id", "id=$d[2] and response_code=1");
            if (count($f) > 0) {


                $action_log = $this->dbconnection->select("crmfeesclub_$school_id.fee_transaction_action", "action_description", "fee_transaction_head_id=$d[2]");
                $log = '';
                $l = 1;
                foreach ($action_log as $al) {
                    $log .= $l . ') ' . $al->action_description . '<br>';
                    $l++;
                }
                $return .= "<tr>";
                $return .= "<td>$r->merchant_ref_no</td>";
                $return .= "<td>$d[1]</td>";
                $return .= "<td>$r->date</td>";
                $return .= "<td>$log</td>";
                $datet=date('Y-m-d', strtotime($r->date));
                $return .= "<td><a onclick='payupdate(\"$d[1]\",\"{$f[0]->student_id}\",\"$datet\")'>Update pay</a></td>";
                $return .= "</tr>";
            }
        }
        $return .= "</tbody>";
        $return .= "</table>";
        echo $return;
    }

    public function get_info() {
        $scl_id = $this->input->post('school_id');
        $this->db->db_select('crmfeesclub_' . $scl_id);
        $admission_no = $this->dbconnection->select("student", "id,admission_no", "status=1");
        $data = array(
            'student' => $admission_no,
            'school_id' => $scl_id,
        );
        $this->load->view('backend/carry_fwd_transac', $data);
    }

    public function get_trans_status() {
        $school_id = $this->input->post('school_id');
//            $this->db->db_select('crmfeesclub');
        $sckool_gw = $this->dbconnection->select("school", "school_code, payment_gateway, pgw_mid, pgw_enckey", "id=$school_id and status=1");
        $scool_code = $sckool_gw[0]->school_code;
        $payment_gateway = !empty($sckool_gw[0]->payment_gateway) ? $sckool_gw[0]->payment_gateway : 0;
        switch ($sckool_gw[0]->payment_gateway) {
            case 'WORLDLINE':
                $this->Worldline_trans_status($school_id, $scool_code,$payment_gateway);
                break;
            case 'CCAVENUE':
                
                    $this->ccavenue_trans_status($school_id, $scool_code);                
                break;
            default:
                $this->hdfc_trans_status($school_id, $scool_code);
                break;
        }
    }

    public function Worldline_trans_status($scl_id, $skl_code,$payment_gateway) {
        $adm = $this->input->post('adm');
        $stud_id = $this->input->post('stud_id');
        $paymnt_date = $this->input->post('pay_date');

//        echo 'No Data Receive of WORLDLINE';

        $i = 0;
        $j = 0;
        $k = 0;

        $annual = $ann_date = $ann_trans_id = $ann_pay_id = $ann_order_id = $ann_mod = $mnth_name = $amnt = $pay_date = $pay_mode = $trans_id = $pay_id = $order_id =$cat_id= array();
        $this->db->db_select('crmfeesclub_' . $scl_id);
        $academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y' and active='Y'");
        $fees_det = $this->dbconnection->select_join("fee_transaction_head f", "f.id, f.payment_id,f.transaction_id,f.payment_date,f.payment_method, fee.amount,fee.month_desc, fee.fee_cat_id", "f.paid_status=1 and f.response_code=0 and f.year={$academic_session[0]->fin_year} and f.student_id=$stud_id", "fee_transaction_det fee", "f.id=fee.fee_trans_head_id", "inner");
        $fee_category= array_column($this->dbconnection->select_returnarray("crmfeesclub.fee_category", "id,fee_cat_name"), 'fee_cat_name', 'id');
        foreach ($fees_det as $row) {
            if ($row->fee_cat_id == 2 || $row->fee_cat_id == 5) {
                $mnth_name[$j] = $row->month_desc;                
            }else{
                $mnth_name[$j] = '';    
            }
                $cat_id[$j]=$row->fee_cat_id;
                $annual[$j] = $row->amount;
                $ann_date[$j] = $row->payment_date;
                $ann_trans_id[$j] = $row->transaction_id;
                $ann_pay_id[$j] = $row->payment_id;
                $ann_order_id[$j] = $skl_code . '-' . $adm . '-' . $row->id;
                $ann_mod[$j] = $row->payment_method;
                
                $amnt[$j] = '';
                $pay_date[$j] = '';
                $pay_mode[$j] = '';
                $trans_id[$j] = '';
                $pay_id[$j] = '';
                $order_id[$j] = '';
               
                $j++;
        }


        $merchant = array();
        $cnt = $i;
        $cont = $j;
        $ct = $k;

        $data = array(
            'ann_amnt' => $annual,
            'ann_pay_date' => $ann_date,
            'ann_trans_id' => $ann_trans_id,
            'ann_pay_id' => $ann_pay_id,
            'ann_pay_mode' => $ann_mod,
            'ann_order_id' => $ann_order_id,
            'mnth' => $mnth_name,
            'amount' => $amnt,
            'date' => $pay_date,
            'cat_id' => $cat_id,
            'trans_id' => $trans_id,
            'pay_id' => $pay_id,
            'order_id' => $order_id,
            'mode' => $pay_mode,
            'count' => $cnt,
            'count_ann' => $cont,
            'ref' => $merchant,
            'school_code' => $skl_code,
            'school_id' => $scl_id,
            'paymnt_date' => $paymnt_date,
            'cnt' => $ct,
            'pgw' => $payment_gateway,
            'fees_det'=>$fees_det,
            'fee_category'=>$fee_category,
            'autostatus'=>$this->input->post('autostatus')
        );
        $this->load->view('backend/load_div', $data);
    }

    public function hdfc_trans_status($school_id, $scool_code) {
        $admisn = $this->input->post('adm');
        $paymnt_date = $this->input->post('pay_date');
        $skl_id = $this->input->post('school_id');
        $skl_code = $scool_code;

        $stud_id = array();
        $student_name = array();
        $amount = array();
        $paymnt_id = array();
        $transaction_id = array();
        $paid_date = array();
        $res_msg = array();
        $stat = array();
        $adm = array();
        $desc = array();
        $month = array();
        $method_name = array();
        $mon = array();
        $mnthly = array();
        $ann = array();
        $half = array();
        $oth = array();
        $fin = array();
        $mon_no = array();
        $fee_head_id = array();
        $fee_trans_head = array();

//        $this->db->db_select('feesclub_v4');
        $this->db->db_select('crmfeesclub');
        $gw_data = $this->dbconnection->select("gateway_response", "net_amount,payment_id,merchant_ref_no,description,payment_method,transaction_id,date,response_message,status", "merchant_ref_no like CONCAT('$skl_code','-','$admisn%') and date like '$paymnt_date%'");
//            print_r($gw_data);
        $i = 0;
        $j = 0;
        $this->db->db_select('crmfeesclub_' . $skl_id);
        $stud_detail = $this->dbconnection->select("student", "id,CONCAT(first_name,' ',middle_name,' ',last_name) as name", "admission_no='$admisn'");
//             print_r($stud_detail) ;
        $fee_cnt = 0;
        foreach ($gw_data as $row) {
            $stud_id[$i] = $stud_detail[0]->id;
            $student_name[$i] = $stud_detail[0]->name;
            $amount[$i] = $row->net_amount;
            $paymnt_id[$i] = $row->payment_id;
            $transaction_id[$i] = $row->transaction_id;
            $paid_date[$i] = $row->date;
            $res_msg[$i] = $row->response_message;
            $stat[$i] = $row->status;
            $adm[$i] = $admisn;
            $this->db->db_select('crmfeesclub');
            $method = $this->dbconnection->Get_namme("payment_method_desc", "payment_code", "$row->payment_method", "payment_desc");
            $method_name[$i] = $method;
            $this->db->db_select('crmfeesclub_' . $skl_id);
            $fee_trans_head[$i] = $row->merchant_ref_no;
            $fee_head_id = explode("-", $fee_trans_head[$i]);
            $fee_head = $fee_head_id[2];
//                $fee_det=$this->dbconnection->select("fee_transaction_det","sum(amount) as amt,count(month_no) as mon,fee_cat_id","fee_trans_head_id=$fee_head");                
            $fee_det = $this->dbconnection->select("fee_transaction_det", "amount,fee_cat_id", "fee_trans_head_id=$fee_head");
            $k = 0;

            if (count($fee_det) > 0) {
                $sumMonthly = 0;
                $countMonthly = 0;
                $sumAnnualy = 0;
                $sumOther = 0;
                $sumHalf = 0;
                $sumFine = 0;
                $countFine = 0;
                foreach ($fee_det as $fee) {
                    if ($fee->fee_cat_id == 2 || $fee->fee_cat_id==5) {
                        $sumMonthly = $sumMonthly + $fee->amount;
                        $countMonthly = $countMonthly + 1;
                    } else if ($fee->fee_cat_id == 1) {
                        $sumAnnualy = $sumAnnualy + $fee->amount;
                    } else if ($fee->fee_cat_id == 3) {
                        $sumOther = $sumOther + $fee->amount;
                    } else if ($fee->fee_cat_id == 4) {
                        $sumHalf = $sumHalf + $fee->amount;
                    } else if ($fee->fee_cat_id == 0) {
                        $sumFine = $sumFine + $fee->amount;
                        $countFine = $countFine + 1;
                    }
                    $k++;
                }
                $mnthly[$i] = $sumMonthly;
                $month[$i] = $mnthly[$i] . '(' . $countMonthly . 'month)';
                $ann[$i] = $sumAnnualy;
                $oth[$i] = $sumOther;
                $half[$i] = $sumHalf;
                $fin1[$i] = $sumFine;
                $fin[$i] = $fin1[$i] . '(' . $countFine . 'month)';
            }
            $fee_cnt = $k;

            $i++;
        }

        $cnt = $i;

        $data = array(
            'student_id' => $stud_id,
            'stud_name' => $student_name,
            'stud_admission' => $adm,
            'paid_amount' => $amount,
            'pay_id' => $paymnt_id,
            'trans_id' => $transaction_id,
            'pay_date' => $paid_date,
            'response' => $res_msg,
            'paid_mnth' => $mon,
            'pay_method' => $method_name,
            'anual' => $ann,
            'paid_mnthly' => $month,
            'half_yearly' => $half,
            'other' => $oth,
            'fine' => $fin,
            'description' => $fee_trans_head,
            'status' => $stat,
            'count' => $cnt,
            'fee' => $fee_cnt,
            'school_id' => $skl_id,
            'date_payment' => $paymnt_date,
            'scl_code' => $skl_code,
            'autostatus'=>$this->input->post('autostatus')
        );
        $this->load->view('backend/upload_trans_det', $data);
    }
    
    public function ccavenue_trans_status($school_id, $scool_code) {
        $admisn = $this->input->post('adm');
        $paymnt_date = $this->input->post('pay_date');
        $skl_id = $this->input->post('school_id');
        $skl_code = $scool_code;

        $stud_id = array();
        $student_name = array();
        $amount = array();
        $paymnt_id = array();
        $transaction_id = array();
        $paid_date = array();
        $res_msg = array();
        $stat = array();
        $adm = array();
        $desc = array();
        $month = array();
        $method_name = array();
        $mon = array();
        $mnthly = array();
        $ann = array();
        $half = array();
        $oth = array();
        $fin = array();
        $mon_no = array();
        $fee_head_id = array();
        $fee_trans_head = array();

//        $this->db->db_select('feesclub_v4');
        $this->db->db_select('crmfeesclub');
        $gw_data = $this->db->query("SELECT total_amount,payment_id,response_message,status,remarksn,payment_method,transaction_id,payment_date,receipt_no FROM fee_trans_head ");
      	if($gw_data){
      		echo "string";
      		die();
      	}
      	else{
      		echo "fsdfsdfsdfsdvxcvxcvxvfsd";die();
      	}
        // $gw_data = $this->dbconnection->select("gateway_response", "net_amount,payment_id,merchant_ref_no,description,payment_method,transaction_id,date,response_message,status", "merchant_ref_no like CONCAT('$skl_code','-','$admisn%') and date like '$paymnt_date%'");
          
        $i = 0;
        $j = 0;
        $this->db->db_select('crmfeesclub_' . $skl_id);
        $stud_detail = $this->dbconnection->select("student", "id,CONCAT(first_name,' ',middle_name,' ',last_name) as name", "admission_no='$admisn'");
//             print_r($stud_detail) ;
        $fee_cnt = 0;
        foreach ($gw_data as $row) {
            $stud_id[$i] = $stud_detail[0]->id;
            $student_name[$i] = $stud_detail[0]->name;
            $amount[$i] = $row->net_amount;
            $paymnt_id[$i] = $row->payment_id;
            $transaction_id[$i] = $row->transaction_id;
            $paid_date[$i] = $row->date;
            $res_msg[$i] = $row->response_message;
            $stat[$i] = $row->status;
            $adm[$i] = $admisn;
            $this->db->db_select('crmfeesclub');
            $method = $this->dbconnection->Get_namme("payment_method_desc", "payment_code", "$row->payment_method", "payment_desc");
            $method_name[$i] = $method;
            $this->db->db_select('crmfeesclub_' . $skl_id);
            $fee_trans_head[$i] = $row->merchant_ref_no;
            $fee_head_id = explode("-", $fee_trans_head[$i]);
            $fee_head = $fee_head_id[2];
//                $fee_det=$this->dbconnection->select("fee_transaction_det","sum(amount) as amt,count(month_no) as mon,fee_cat_id","fee_trans_head_id=$fee_head");                
            $fee_det = $this->dbconnection->select("fee_transaction_det", "amount,fee_cat_id", "fee_trans_head_id=$fee_head");
            $k = 0;

            if (count($fee_det) > 0) {
                $sumMonthly = 0;
                $countMonthly = 0;
                $sumAnnualy = 0;
                $sumOther = 0;
                $sumHalf = 0;
                $sumFine = 0;
                $countFine = 0;
                foreach ($fee_det as $fee) {
                    if ($fee->fee_cat_id == 2 || $fee->fee_cat_id == 5) {
                        $sumMonthly = $sumMonthly + $fee->amount;
                        $countMonthly = $countMonthly + 1;
                    } else if ($fee->fee_cat_id == 1) {
                        $sumAnnualy = $sumAnnualy + $fee->amount;
                    } else if ($fee->fee_cat_id == 3) {
                        $sumOther = $sumOther + $fee->amount;
                    } else if ($fee->fee_cat_id == 4) {
                        $sumHalf = $sumHalf + $fee->amount;
                    } else if ($fee->fee_cat_id == 0) {
                        $sumFine = $sumFine + $fee->amount;
                        $countFine = $countFine + 1;
                    }
                     else if ($fee->fee_cat_id == 8) {
                        $sumOther = $sumOther + $fee->amount;
                        
                    }
                    $k++;
                }
                $mnthly[$i] = $sumMonthly;
                $month[$i] = $mnthly[$i] . '(' . $countMonthly . 'month)';
                $ann[$i] = $sumAnnualy;
                $oth[$i] = $sumOther;
                $half[$i] = $sumHalf;
                $fin1[$i] = $sumFine;
                $fin[$i] = $fin1[$i] . '(' . $countFine . 'month)';
            }
            $fee_cnt = $k;

            $i++;
        }

        $cnt = $i;

        $data = array(
            'student_id' => $stud_id,
            'stud_name' => $student_name,
            'stud_admission' => $adm,
            'paid_amount' => $amount,
            'pay_id' => $paymnt_id,
            'trans_id' => $transaction_id,
            'pay_date' => $paid_date,
            'response' => $res_msg,
            'paid_mnth' => $mon,
            'pay_method' => $method_name,
            'anual' => $ann,
            'paid_mnthly' => $month,
            'half_yearly' => $half,
            'other' => $oth,
            'fine' => $fin,
            'description' => $fee_trans_head,
            'status' => $stat,
            'count' => $cnt,
            'fee' => $fee_cnt,
            'school_id' => $skl_id,
            'date_payment' => $paymnt_date,
            'scl_code' => $skl_code,
            'autostatus'=>$this->input->post('autostatus')
        );
        
        echo "<pre>";print_r($data);die();
            $this->load->view('backend/upload_trans_det', $data);
    }

    public function load_div() {
        $adm = $this->input->post('admission');
        $stud_id = $this->input->post('studnt_id');
        $paymnt_date = $this->input->post('pay_date');
        $scl_id = $this->input->post('school_id');
        $skl_code = $this->input->post('scl_code');
        $i = 0;
        $j = 0;
        $k = 0;
        $annual = $ann_date = $ann_trans_id = $ann_pay_id = $ann_order_id = $ann_mod = $mnth_name = $amnt = $pay_date = $pay_mode = $trans_id = $pay_id = $order_id =$cat_id= array();
        $this->db->db_select('crmfeesclub_' . $scl_id);
        $academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y' and active='Y'");
        $fee_category= array_column($this->dbconnection->select_returnarray("crmfeesclub.fee_category", "id,fee_cat_name"), 'fee_cat_name', 'id');
        $fees_det = $this->dbconnection->select_join("fee_transaction_head f", "f.id, f.payment_id,f.transaction_id,f.payment_date,f.payment_method, fee.amount,fee.month_desc, fee.fee_cat_id", "f.paid_status=1 and f.response_code=0 and f.year={$academic_session[0]->fin_year} and f.student_id=$stud_id", "fee_transaction_det fee", "f.id=fee.fee_trans_head_id", "inner");
        foreach ($fees_det as $row) {
            if ($row->fee_cat_id == 2 || $row->fee_cat_id == 5) {
                $mnth_name[$j] = $row->month_desc;                
            }else{
                $mnth_name[$j] = '';    
            }
                $cat_id[$j]=$row->fee_cat_id;
                $annual[$j] = $row->amount;
                $ann_date[$j] = $row->payment_date;
                $ann_trans_id[$j] = $row->transaction_id;
                $ann_pay_id[$j] = $row->payment_id;
                $ann_order_id[$j] = $skl_code . '-' . $adm . '-' . $row->id;
                $ann_mod[$j] = $row->payment_method;
                
                $amnt[$j] = '';
                $pay_date[$j] = '';
                $pay_mode[$j] = '';
                $trans_id[$j] = '';
                $pay_id[$j] = '';
                $order_id[$j] = '';
               
                $j++;
        }

//        $this->db->db_select('feesclub_v4');
        $this->db->db_select('crmfeesclub');
        $merchant = array();
        $success_trans = $this->dbconnection->select("gateway_response", "distinct(merchant_ref_no)", "merchant_ref_no like CONCAT('$skl_code','-','$adm%') and date like '$paymnt_date%' and (status='Authorized' or status='Captured' or status='Success')");
        foreach ($success_trans as $ref) {
            $merchant[$k] = $ref->merchant_ref_no;
            $k++;
        }

        $cnt = $i;
        $cont = $j;
        $ct = $k;

        $data = array(
            'ann_amnt' => $annual,
            'ann_pay_date' => $ann_date,
            'ann_trans_id' => $ann_trans_id,
            'ann_pay_id' => $ann_pay_id,
            'ann_pay_mode' => $ann_mod,
            'ann_order_id' => $ann_order_id,
            'mnth' => $mnth_name,
            'amount' => $amnt,
            'date' => $pay_date,
            'cat_id' => $cat_id,
            'trans_id' => $trans_id,
            'pay_id' => $pay_id,
            'order_id' => $order_id,
            'mode' => $pay_mode,
            'count' => $cnt,
            'count_ann' => $cont,
            'ref' => $merchant,
            'school_code' => $skl_code,
            'school_id' => $scl_id,
            'paymnt_date' => $paymnt_date,
            'cnt' => $ct,
            'pgw' => 'HDFC',
            'fee_category'=>$fee_category,
            'autostatus'=>$this->input->post('autostatus')
        );
        $this->load->view('backend/load_div', $data);
    }

    public function fill_data() {
        $merchnt = $this->input->post('ref');

//        if ($this->input->post('pgw') == 'HDFC') {
////        $this->db->db_select('feesclub_v4');
//            $this->db->db_select('crmfeesclub');
//            $pg_data = $this->dbconnection->select("gateway_response", "date,payment_id,transaction_id,payment_method", "merchant_ref_no='$merchnt'");
//            $mod = $pg_data[0]->payment_method;
////        $this->db->db_select('crmfeesclub');
//            $method = $this->dbconnection->Get_namme("payment_method_desc", "payment_code", "$mod", "payment_desc");
//            $pay_mode = $this->dbconnection->Get_namme("payment_method_desc", "payment_code", "$mod", "payment_mode");
//            $data = array(
//                'paym_date3' => $pg_data[0]->date,
//                'pay_id' => trim($pg_data[0]->payment_id),
//                'trans_id' => trim($pg_data[0]->transaction_id),
//                'pay_method' => $method,
//                'pay_mode' => $pay_mode,
//            );
//            echo json_encode($data);
//        } else {
        if ($this->input->post('pgw') == 'HDFC') {
//        $this->db->db_select('feesclub_v4');
            $this->db->db_select('crmfeesclub');
            $pg_data = $this->dbconnection->select("gateway_response", "date,payment_id,transaction_id,payment_method", "merchant_ref_no='$merchnt'");
            $mod = $pg_data[0]->payment_method;
//        $this->db->db_select('crmfeesclub');
            $method = $this->dbconnection->Get_namme("payment_method_desc", "payment_code", "$mod", "payment_desc");
            $pay_mode = $this->dbconnection->Get_namme("payment_method_desc", "payment_code", "$mod", "payment_mode");
            $modearr=array('Debit Card'=>'DC','Credit Card'=>'CC','Net Banking'=>'NB');
            $data = array(
                'paym_date3' => $pg_data[0]->date,
                'pay_id' => trim($pg_data[0]->payment_id),
                'trans_id' => trim($pg_data[0]->transaction_id),
                'pay_method' => $mod,
                'pay_mode' => $modearr[$mod],
            );
            echo json_encode($data);
        } else {
            $this->db->db_select('crmfeesclub_' . $this->input->post('scool_id'));
            $fee_trans_id = explode('-', $merchnt);
            $fee_trans_id = $fee_trans_id[2];
            $pg_data = $this->dbconnection->select("fee_transaction_head", "payment_date,transaction_id,payment_id,mode,payment_method", "id=$fee_trans_id");
            $data = array(
                'paym_date3' => $pg_data[0]->payment_date,
                'pay_id' => trim($pg_data[0]->payment_id),
                'trans_id' => trim($pg_data[0]->transaction_id),
                'pay_method' => $pg_data[0]->payment_method,
                'pay_mode' => '',
            );
            echo json_encode($data);
        }
    }

    public function save_transaction() {
        $fee = array();
        $merchant = $this->input->post('ref_no');
        $pay_date = $this->input->post('pay_date');
        $payment = $this->input->post('paym_id');
        $trans = $this->input->post('transac_id');
        $paymethod = $this->input->post('pay_method');
        $paymod = $this->input->post('pay_mode');
        $scl_code = $this->input->post('school_code');
        $scol_id = $this->input->post('school_id');
        $this->db->db_select('crmfeesclub_' . $scol_id);
        $fee = explode('-', $merchant);
        $fee_head_id = $fee[2];
        $acc = $this->dbconnection->select("accedemic_session", "max(id) as max_id", "status='Y' and active='Y'");
        
        $session_id = $acc[0]->max_id;

        $receipt_log = $this->dbconnection->select("receipt_log", "max(recipt_no) as rec", "");

        $number = strlen($receipt_log[0]->rec);
        $str = '';
        for ($i = 1; $i <= (6 - $number); $i++) {
            $str .= '0';
        }

        $maxn = $str . ($receipt_log[0]->rec + 1);
        $receipt_no = "FC$session_id$scl_code$maxn";

        $data = array(
            'recipt_no' => $maxn,
            'fee_trans_id' => $fee_head_id,
        );
        $this->dbconnection->insert('receipt_log', $data);

        $stud_id = $this->dbconnection->Get_namme("student", "admission_no", "$fee[1]", "id");
        $mon_count = $this->dbconnection->select('fee_transaction_det', 'max(month_no) as cnt_month', "fee_trans_head_id in( select id from fee_transaction_head where student_id=$stud_id and year=$session_id and paid_status=1 and response_code=0 and status=1) and fee_cat_id in (2,5)");
        $count_month = empty($mon_count) ? 0 : $mon_count[0]->cnt_month;


        $data1 = array(
            'transaction_id' => $trans,
            'payment_id' => $payment,
            'payment_method' => $paymethod,
            'mode' => $paymod,
            'date_modified' => date('Y-m-d H:i:s'),
            'payment_date' => $pay_date,
            'paid_status' => 1,
            'response_code' => 0,
            'receipt_no' => $receipt_no,
            'response_message' => 'Transaction Successful',
            'remarks' => 'Updated by FCLB ',
            'modified_by' => $this->session->userdata('user_id'),
        );
        $this->dbconnection->update('fee_transaction_head', $data1, "id=$fee_head_id");


//        echo $count_month;
        $query = $this->dbconnection->select("fee_transaction_det", "*", "fee_trans_head_id=$fee_head_id and fee_cat_id in (2,5)");
        foreach ($query as $rm) {
            if ($rm->month_no <= $count_month) {
                $count_month = $count_month + 1;

                $this->dbconnection->update('fee_transaction_det', array('month_no' => $count_month, 'month_desc' => $this->month_arr[$count_month]), "fee_trans_head_id=$fee_head_id and id=$rm->id and fee_cat_id in (2,5)");
            }
        }
        
        $instantfee=$this->db->query("select other_fee_id,amount from fee_transaction_det where fee_trans_head_id=$fee_head_id and fee_cat_id=8")->result();
        
        foreach ($instantfee as $keyi => $valuei) {
            $this->dbconnection->update("student_other_fee",array('paid_status'=>1,'last_date_modified'=>date('Y-m-d H:i:s'),'modified_by'=>$this->session->userdata('user_id')),array('student_id'=>$stud_id,'fee_id'=>$valuei->other_fee_id,'amount'=>$valuei->amount,'paid_status'=>0,'status'=>'Y'));
        }
        
    }

//        public function transfer_student_fees() {
//            $this->db->db_select('crmfeesclub_10');
//            $query_fee=$this->dbconnection->select("fee_trans_det","*","fee_cat_id=2");
//            
//            foreach($query_fee as $r) {
//                
//                $fetch_student=$this->dbconnection->select("student","*","id=".$r->student_id);
//                $class_fee_head_id = $this->dbconnection->select('class_fee_head','id',' year=2017  and (from_class_id <=' . $fetch_student[0]->class_id . ' and  to_class_id >=' . $fetch_student[0]->class_id .') and course='.$fetch_student[0]->course_id . ' and status="Y"');
//                
//                    $data_head=array(
//                        'student_id'       =>$r->student_id,
//                        'request_status'   =>$r->request_status,
//                        'response_status'  =>$r->response_status,
//                        'chargeback_status'=>$r->chargeback_status,
//                        'year'             =>$r->year,
//                        'total_amount'     =>$r->amount,
//                        'paid_by'          =>$r->paid_by,
//                        'payment_date'     =>$r->payment_date,
//                        'transaction_id'   =>$r->transaction_id,
//                        'payment_id'       =>$r->payment_id,
//                        'response_code'    =>$r->response_code,
//                        'payment_method'   =>$r->payment_method,
//                        'response_message' =>$r->response_message,
//                        'remarks'          =>$r->remarks,
//                        'status'           =>$r->status,
//                        'paid_status'      =>$r->paid_status,
//                        'receipt_no'       =>$r->receipt_no,
//                        'mode'             =>$r->mode,
//                        'bank_name'        =>$r->bank_name,
//                        'collection_centre'=>$r->collection_centre,
//                        'req_ipaddr_str'   =>$r->req_ipaddr_str,
//                        'full_pgw_response_json'=>$r->full_pgw_response_json,
//                        'date_created'     =>$r->payment_date,
//                        'created_by'       =>$r->paid_by,
//                    );
//                    $this->dbconnection->insert("fee_transaction_head",$data_head);
//                    $fee_transac_id = $this->dbconnection->get_last_id();
//                    
//                    $data_action=array(
//                        'fee_transaction_head_id' =>$fee_transac_id,
//                        'action_description' =>$r->remarks,
//                        'full_pymt_description' =>'',
//                        'date_created'     =>$r->payment_date,
//                        'created_by'       =>$r->paid_by,
//                    );
//                    $this->dbconnection->insert("fee_transaction_action",$data_action);
//                    
//                    $monthl=$r->month_no;
//                    if($monthl==0) {
//                        $amount_per=$r->amount;
//                    }
//                    else {
//                        $amount_per=$r->amount/$monthl;
//                    }
//                    $month_desc=explode('to',$r->month_desc);
//                    $init_month=$month_desc[0];
//                    $month_arr = array(0 =>"",1 => "April", 2 => "May", 3 => "June", 4 => "July", 5 => "Aug", 6 => "Sep", 7 => "Oct", 8 => "Nov", 9 => "Dec", 10 => "Jan", 11 => "Feb", 12 => "Mar",13 =>"Apr",14 =>"May",15 =>"June",16 => "July", 17 => "Aug", 18 => "Sep", 19 => "Oct",);
//                    for($i=1;$i<=$monthl;$i++)
//                    {
//                        
//                        $data_det=array(
//                            'class_fee_head_id' =>$class_fee_head_id[0]->id,
//                            'stud_category'     =>$fetch_student[0]->stud_category,
//                            'fee_cat_id'        =>$r->fee_cat_id,
//                            'amount'            =>$amount_per,
//                            'month_no'          =>$init_month,
//                            'month_desc'        =>$month_arr[$init_month],
//                            'fee_trans_head_id' =>$fee_transac_id,
//                            'date_created'      =>$r->payment_date,
//                            'created_by'        =>$r->paid_by,
//                        );   
//                        $this->dbconnection->insert("fee_transaction_det",$data_det);
//                        $init_month++;
//                    }
//                    
//                
//            }
//            
//        }

    public function generateRandomString($length = 25) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function transac_status() {
        $this->load->view("student/transc_status");
    }

    public function davbupload() {



        $data = array(
            'page_name' => 'davb_upload',
            'page_title' => 'davb_upload',
            'section' => 'backend',
            'customview' => '',
        );

        if (!empty($this->session->userdata('offln_error'))) {
            $this->session->set_flashdata('myMSG', 'Please Check CSV File to see the Below Errors');
            $data['message'] = $this->session->flashdata('myMSG');
            $data['errors'] = $this->session->userdata('offln_error');
            $this->session->unset_userdata('offln_error');
        } else {

            $data['message'] = $this->session->flashdata('myMSG');
        }

        $this->load->view('index', $data);
    }

    public function save_offln_payment() {
//        ini_set('max_input_time', 0);
//                ini_set('max_execution_time', 0);
//                ini_set('display_errors', 1);
        $this->db->db_select('crmfeesclub_29');
        ini_set('max_execution_time', 3600);
        error_reporting(-1);
        ini_set('display_errors', 1);
        $this->data['message'] = 'no upload';
        $this->data['errors'] = array();
        $accedmic_sssion = $this->dbconnection->select('accedemic_session', 'max(id) as max_year', 'active="Y" and status="Y"');
        $current_year = $accedmic_sssion[0]->max_year;
        $admsn_error = array();
        $month_arr = array(1 => "April", 2 => "May", 3 => "June", 4 => "July", 5 => "Aug", 6 => "Sep", 7 => "Oct", 8 => "Nov", 9 => "Dec", 10 => "Jan", 11 => "Feb", 12 => "Mar");

        if (!empty($_FILES['uploadm']['tmp_name'])) {



            $handle = fopen($_FILES['uploadm']['tmp_name'], "r");
            fgetcsv($handle);

            /* ------  reading file  ------- */
            $linerow = 1;
            while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
                $linerow++;
                $fetchstudent_id = $this->dbconnection->select("student", "id,class_id,course_id,stud_category", "admission_no='$data[0]'");

                if (count($fetchstudent_id) == 0) {
                    $this->data['errors'][] = "Line $linerow: Admission Number '" . $data[0] . "' not in our database, skipping...";
                    continue;
                }

                $stud_id = $fetchstudent_id[0]->id;
                $monthly_ann_amount = 0;
                $transport_amount = 0;
                $total_paid_month = 0;
                $ann_amount = 0;
                $class_fee_head_id_qry = $this->dbconnection->select('class_fee_head', 'id', '(from_class_id <=' . $fetchstudent_id[0]->class_id . ' and  to_class_id >=' . $fetchstudent_id[0]->class_id . ') and course=' . $fetchstudent_id[0]->course_id . ' and status="Y"', 'id', 'DESC', '1');

                if (empty($class_fee_head_id_qry[0]->id)) {
                    $this->data['errors'][] = "Line $linerow: Admission Number '" . $data[0] . "' contains no fee structure, skipping...";
                    continue;
                }
                $class_fee_head_id = $class_fee_head_id_qry[0]->id;
                if (strtoupper("$data[1]") == 'MON' || strtoupper("$data[1]") == 'MA') {
                    $fetch_m = $this->dbconnection->select("fee_transaction_det", "count(month_no) paid", "fee_trans_head_id in(select id from fee_transaction_head where year=$current_year and student_id=" . $stud_id . " and paid_status=1 and response_code=0) and fee_cat_id=2");
                    $total_paid_month = $fetch_m[0]->paid;
                    $test = $total_paid_month + $data[2];
                    if ($test > 12) {
                        $this->data['errors'][] = "Line $linerow: Admission Number '" . $data[0] . "' contains next year payment, skipping...";
                        continue;
                    }
                    if (empty($data[2])) {
                        $this->data['errors'][] = "Line $linerow: Admission Number '" . $data[0] . "' contains No of Month Blank, skipping...";
                        continue;
                    }
                    $fee_details = $this->db->query("SELECT sum(fee_amount) fee_amount FROM class_fee_det WHERE class_fee_head_id=$class_fee_head_id and stud_cat={$fetchstudent_id[0]->stud_category} and fee_cat=2 and status=1")->result();
                    $monthly_ann_amount = $data[2] * $fee_details[0]->fee_amount;
                    
                    if(strtoupper("$data[1]") == 'MA') {
                        $fee_details = $this->db->query("SELECT sum(fee_amount) fee_amount FROM class_fee_det WHERE class_fee_head_id=$class_fee_head_id and stud_cat={$fetchstudent_id[0]->stud_category} and fee_cat=1 and status=1")->result();
                        $monthly_ann_amount = $monthly_ann_amount+$fee_details[0]->fee_amount;
                        $ann_amount=$fee_details[0]->fee_amount;
                    }
                    
                }elseif (strtoupper("$data[1]") == 'ANN') {
                    $fee_details = $this->db->query("SELECT sum(fee_amount) fee_amount FROM class_fee_det WHERE class_fee_head_id=$class_fee_head_id and stud_cat={$fetchstudent_id[0]->stud_category} and fee_cat=1 and status=1")->result();
                    $monthly_ann_amount = $fee_details[0]->fee_amount;
                }
                
                if (!empty($data[3])) {
                    $transport_amount = $this->dbconnection->Get_namme("student", "id", $stud_id, 'transport_amt');
                    if (!empty($transport_amount)) {
//                            $transport_amount=$transport_amount;
                        $transport_amount = $transport_amount * $data[2];
                        if (($total_paid_month < 3) && ($data[2] >= 3 - $total_paid_month)) { //June
                            $transport_amount = $transport_amount * ($data[2] - 1);
                        }
                    } else {
                        $transport_amount = 0;
                    }
                }


                if (date('Y', strtotime(str_replace('/', '-', $data[9]))) == 1970) {
                    $this->data['errors'][] = "Line $linerow: Admission Number '" . $data[0] . "' contains payment date Invalid, skipping...";
                    continue;
                }
//                    $year_class = $this->dbconnection->select('class_fee_head', 'max(year) as year');
//                    $class_fee_head_year = $year_class[0]->year;


                if (empty($class_fee_head_id_qry[0]->id)) {
                    $this->data['errors'][] = "Line $linerow: Admission Number '" . $data[0] . "' contains no fee structure, skipping...";
                    continue;
                }

                $paid_status = 1;


                if (strtoupper("$data[1]") == 'MON' || strtoupper("$data[1]") == 'ANN' || strtoupper("$data[1]") == 'MA') {

                    if(strtoupper($data[6])=='FCLB'){
                        $action_description=$data[10];
                        $description = "FeesClub Total $total_amount - AdmissionN0 $data[0] - Student ID $stud_id "
                    . "-  of session $current_year";
                        $request_status=1;
                        $response_status=1;
                    }else{
                        $action_description='Offline Collection';
                        $description = "Offline Collection Total $total_amount - AdmissionN0 $data[0] - Student ID $stud_id of session $current_year from IP:" . $_SERVER['REMOTE_ADDR'];
                    
                        $request_status=0;
                        $response_status=0;
                    }

                    /* ---------- Saving Details to Fee Payment record table(fee_transaction_head)  --------- */
                    $total_amount = $monthly_ann_amount + $transport_amount + $data[4];
                    $this->dbconnection->insert("fee_transaction_head", array('student_id' => $stud_id, 'year' => $current_year,
                        'request_status'=>$request_status,'response_status'=>$response_status,'transaction_id'=>$data[13],'payment_id'=>$data[13],
                        'total_amount' => $total_amount, 'paid_by' => $this->session->userdata('user_id'), 'payment_date' => date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $data[9]))),
                        'remarks' => $data[10], 'mode' => strtoupper($data[6]), 'collection_centre' => $data[8], 'response_code' => 0, 'payment_method' => $data[6],
                        'response_message' => 'Payment Successful', 'paid_status' => 1, 'req_ipaddr_str' => $_SERVER['REMOTE_ADDR'],
                        'receipt_no' => $data[11], 'bank_name' => $data[7], 'date_created' => date('Y-m-d H:i:s'), 'created_by' => $this->session->userdata('user_id')));
                    $fee_transac_id = $this->dbconnection->get_last_id();
                    /* --------------------------------------------------------------------------------------- */

                    $this->dbconnection->update("receipt_log",array('fee_trans_id'=>$fee_transac_id),'recipt_no="'.str_replace('FC1DAVB', '', $data[11]).'"');
                    
                    
                    

                    /* ---------- Saving Details to Fee Payment Action table(fee_transaction_action)  --------- */

                    $this->dbconnection->insert("fee_transaction_action", array('fee_transaction_head_id' => $fee_transac_id, 'action_description' =>$action_description ,
                        'created_by' => $this->session->userdata('user_id'), 'full_pymt_description' => $description));
                    $fee_action_id = $this->dbconnection->get_last_id();

                    /* --------------------------------------------------------------------------------------- */
                } else {
                    $this->data['errors'][] = "Line $linerow: Fee Head $data[1] is invalid";
                    continue;
                }

                if (strtoupper("$data[1]") == 'MON' || strtoupper("$data[1]") == 'MA') {
//
                    $fee_cat_id = 2;
                    $no_of_month = $data[2];
                    $from = $total_paid_month + 1;
                    $amount = ($monthly_ann_amount-$ann_amount) / $no_of_month;
                    for ($m = 1; $m <= $no_of_month; $m++) {

                        $result = $this->dbconnection->insert("fee_transaction_det", array('amount' => $amount, 'month_no' => $from,
                            'fee_cat_id' => $fee_cat_id, 'month_desc' => $month_arr[$from], 'fee_trans_head_id' => $fee_transac_id,
                            'class_fee_head_id' => $class_fee_head_id, 'stud_category' => $fetchstudent_id[0]->stud_category, 'created_by' => $this->session->userdata('user_id')));

                        $from++;
                    }

                    if (!empty($transport_amount)) { //transport fee
                        $this->dbconnection->insert("fee_transaction_det", array('amount' => $transport_amount, 'fee_cat_id' => 6,
                            'fee_trans_head_id' => $fee_transac_id, 'class_fee_head_id' => $class_fee_head_id, 'stud_category' => $fetchstudent_id[0]->stud_category,
                            'created_by' => $this->session->userdata('user_id')));
                    }
                    if (!empty($data[4]) && !empty($data[5])) { //fine
                        $due_month_no = $data[5];
                        

                            $last_due_month = $total_paid_month + $due_month_no;
                            $init_month = $total_paid_month + 1;
                            $month_desc = "$month_arr[$init_month] to $month_arr[$last_due_month]";
                            $this->dbconnection->insert("fee_transaction_det", array('amount' => $data[4], 'fee_cat_id' => 0,
                                'month_desc' => $month_desc, 'fee_trans_head_id' => $fee_transac_id, 'due_month_no' => $due_month_no,
                                'class_fee_head_id' => $class_fee_head_id, 'stud_category' => $fetchstudent_id[0]->stud_category, 'created_by' => $this->session->userdata('user_id')));
                       
                    }
                    
                    if (strtoupper("$data[1]") == 'MA' && $ann_amount!=0) {
                        $fee_cat_id = 1;
                        $no_of_month = 0;

                        $result = $this->dbconnection->insert("fee_transaction_det", array('amount' => $ann_amount,
                            'fee_cat_id' => $fee_cat_id, 'fee_trans_head_id' => $fee_transac_id,
                        'class_fee_head_id' => $class_fee_head_id, 'stud_category' => $fetchstudent_id[0]->stud_category, 'created_by' => $this->session->userdata('user_id')));
                    }
                    
                } else if (strtoupper("$data[1]") == 'ANN') {
                    $fee_cat_id = 1;
                    $no_of_month = 0;

                    $result = $this->dbconnection->insert("fee_transaction_det", array('amount' => $monthly_ann_amount,
                        'fee_cat_id' => $fee_cat_id, 'fee_trans_head_id' => $fee_transac_id,
                        'class_fee_head_id' => $class_fee_head_id, 'stud_category' => $fetchstudent_id[0]->stud_category, 'created_by' => $this->session->userdata('user_id')));
                }

                $audit = array("action" => 'Corrected Payment Collection by Aniket Sir',
                    "module" => $this->uri->segment(1),
                    "page" => basename(__FILE__, '.php'),
                    'datetime' => date("Y-m-d H:i:s"),
                    'userid' => $this->session->userdata('user_id'),
                    'remarks' => 'ID:' . $fee_transac_id,
                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                );
                $this->dbconnection->insert("auditntrail", $audit);
            }
            /* ---------  end of reading file  ----------- */

            $this->session->set_flashdata('myMSG', 'Successfully uploaded');
        } else {
            $this->data['errors'][] = "File is Empty";
        }

        $this->session->set_userdata('offln_error', $this->data['errors']);
        header('Location:' . site_url("Backend/davbupload"));
    }
    
    
    
    public function transportfee_log() { //19 nov
        $this->db->db_select("crmfeesclub_30");
        
        $studlist=$this->db->query("select id,transport_amt,student_academicyear_id,stud_category from student where transport_amt!=0 or transport_amt is not null")->result();
    
        foreach ($studlist as $value) {
            
            $this->dbconnection->insert("transport_feecategory_monthly_log",array('student_id'=>$value->id,'change_name'=>'stud_category',
                'year'=>$value->student_academicyear_id,'apr'=>$value->stud_category,'may'=>$value->stud_category,'jun'=>$value->stud_category
                ,'jul'=>$value->stud_category,'aug'=>$value->stud_category,'sep'=>$value->stud_category,'oct'=>$value->stud_category
                ,'nov'=>$value->stud_category,'dec'=>$value->stud_category,'jan'=>$value->stud_category,'feb'=>$value->stud_category,'mar'=>$value->stud_category,
                    'date_created'=>date('Y-m-d H:i:s'),'created_by'=>0));
            echo 'Student entry of '.$value->id.' fee='.$value->stud_category;
            if(!empty($value->transport_amt)) {
            $this->dbconnection->insert("transport_feecategory_monthly_log",array('student_id'=>$value->id,'change_name'=>'transport_amt',
                'year'=>$value->student_academicyear_id,'apr'=>$value->transport_amt,'may'=>$value->transport_amt,'jun'=>$value->transport_amt
                ,'jul'=>$value->transport_amt,'aug'=>$value->transport_amt,'sep'=>$value->transport_amt,'oct'=>$value->transport_amt
                ,'nov'=>$value->transport_amt,'dec'=>$value->transport_amt,'jan'=>$value->transport_amt,'feb'=>$value->transport_amt,'mar'=>$value->transport_amt,
                    'date_created'=>date('Y-m-d H:i:s'),'created_by'=>0));
            
            echo ' trans='.$value->transport_amt.'<html><br><html>';
            }
            echo '<html><br><html>';
        }
        
        
    }
    
    
    public function davb_due_log_update() {
        $this->db->db_select('crmfeesclub_29');
        if (!empty($_FILES['uploadm']['tmp_name'])) {
            $handle = fopen($_FILES['uploadm']['tmp_name'], "r");
            fgetcsv($handle);
            $linerow = 1;
            while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
                $linerow++;
                $count=$this->dbconnection->select("student_class_acedemic_log","id","student_id=$data[0] and acedemic_year_id=1");
                
                if(count($count)>0) {
                    $this->dbconnection->update("student_class_acedemic_log",array('no_unpaid_month'=>$data[1], 'annual_unpaid'=>0),"id={$count[0]->id}");

                }else{
                    
                }
                $this->data['errors'][] = "Line $linerow: Admission Number '" . $data[0] . "' doesnot contains, skipping...";
                        continue;
                    
                    //$this->dbconnection->delete("fee_transaction_head",array('status'=>0, 'payment_date'=>'2019-03-30 00:00:00'),"id=$data[0]");
                
                
//                 $audit = array("action" => 'Corrected Payment Collection by Aniket Sir',
//                    "module" => $this->uri->segment(1),
//                    "page" => basename(__FILE__, '.php'),
//                    'datetime' => date("Y-m-d H:i:s"),
//                    'userid' => $this->session->userdata('user_id'),
//                    'remarks' => 'ID:' . $fee_transac_id,
//                    'ip_address' => $_SERVER['REMOTE_ADDR'],
//                );
//                $this->dbconnection->insert("auditntrail", $audit);
            }
            $this->session->set_flashdata('myMSG', 'Successfully uploaded');
        } else {
            $this->data['errors'][] = "File is Empty";
        }
        
    }
    
    
    
    public function davb_transaction_delete() {
        $this->db->db_select('crmfeesclub_29');
        if (!empty($_FILES['uploadm']['tmp_name'])) {
            $handle = fopen($_FILES['uploadm']['tmp_name'], "r");
            fgetcsv($handle);
            $linerow = 1;
            while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
                $linerow++;
                
                
                if(strtoupper($data[1])=='ALL') {
                    $this->dbconnection->update("fee_transaction_head",array('status'=>0, 'payment_date'=>'2019-03-30 00:00:00'),"id=$data[0]");
                }else{
                    
                    $this->db->query("select * from fee_transaction_det where fee_transaction_id=$data[0] order by id desc limit $data[1]")->result();
                    
                    //$this->dbconnection->delete("fee_transaction_head",array('status'=>0, 'payment_date'=>'2019-03-30 00:00:00'),"id=$data[0]");
                }
                
                 $audit = array("action" => 'Corrected Payment Collection by Aniket Sir',
                    "module" => $this->uri->segment(1),
                    "page" => basename(__FILE__, '.php'),
                    'datetime' => date("Y-m-d H:i:s"),
                    'userid' => $this->session->userdata('user_id'),
                    'remarks' => 'ID:' . $fee_transac_id,
                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                );
                $this->dbconnection->insert("auditntrail", $audit);
            }
            $this->session->set_flashdata('myMSG', 'Successfully uploaded');
        } else {
            $this->data['errors'][] = "File is Empty";
        }
        
    }
    
    
    //        ini_set('max_input_time', 0);
//                ini_set('max_execution_time', 0);
//                ini_set('display_errors', 1);
    
    
    public function datapayment() {
        ini_set('max_execution_time', 3600);
        error_reporting(-1);
        ini_set('display_errors', 1);
        $this->db->db_debug=TRUE;
        $this->db->db_select("crmfeesclub_30");
        
        if (!empty($_FILES['uploadm']['tmp_name'])) {
             $handle = fopen($_FILES['uploadm']['tmp_name'], "r");
            fgetcsv($handle);

            /* ------  reading file  ------- */
            $linerow = 0;
            while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
                
                
                $q= $this->dbconnection->update("fee_transaction_head",array('payment_date'=>"$data[9]"),"id=$data[0]");
                 
                if($q){
                    echo 'done=';
                    $linerow=$linerow+$this->db->affected_rows();
                }else{
                    echo 'not working';
                }
            }
            echo $linerow;
            
        }
    }
    

    
    

}
