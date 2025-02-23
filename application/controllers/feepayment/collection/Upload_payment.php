<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_payment extends CI_Controller {

    public $page_code = 'upload_fee_collect';
    public $page_id = '';
    public $page_perm = '----';
    
    public function __construct() {
        parent::__construct();

        $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");

//
//// Access Control
//        switch ($this->session->userdata('login_type')) {
//            case 'appadmin':
//                $this->right_access = 'CRUD';
//                break;
//            case 'admin':
//                $this->right_access = 'CRUD';
//                break;
//            case 'office':
//                $this->right_access = '-R--';
//                break;
//            case 'school':
//                $this->right_access = '-R--';
//                break;
//            case 'principal':
//                $this->right_access = 'CRUD';
//                break;
//            default:
//                $this->right_access = '----';
//                redirect(base_url(), 'refresh');
//        }
        $this->id = $this->session->userdata('school_id');
        $this->school_desc = $this->dbconnection->select("school", "*", "id=" . $this->id . " and status = 1");

        if ($this->school_desc[0]->fee_type1 == 1) {
            $this->fee_cat1 = 2;
            $monqtr='Month';
        } else {
            $this->fee_cat1 = 5;
            $monqtr='Qtr';
            $this->qtrset=explode('@',$this->school[0]->month_set);
            $this->qtr=array();
            foreach ($this->qtrset as $key => $value) {
                $set= explode('-', $value);
                foreach ($set as $value1) {
                    $this->qtr[$value1]=$key;
                }
            }
        }

        if ($this->school_desc[0]->fee_type2 == 3) {
            $this->fee_cat2 = 4;
        } else {
            $this->fee_cat2 = 1;
        }
        $this->bank_name = $this->dbconnection->select("bank", "bank_code", "");

//            $this->month=$this->session->userdata('act_year_from');
        if ($this->id != 0) {
            $this->db->db_select('crmfeesclub_' . $this->id);
            $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year", "active='Y'");
        }
        
        $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
        $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
        $this->right_access = $this->page_perm;

        if (strpos($this->page_perm, '----') == true) {
            redirect(base_url(''), 'refresh');
        }

        $this->uploadfee_csv_columns = array(
            array('field' => 'admission_no', 'human_name' => 'Admission Number'),
            array('field' => 'fee_head', 'human_name' => 'Fee head'),
            array('field' => 'no_of_month', 'human_name' => 'No.of '.$monqtr),
//				array('field' => 'fee_amount', 'human_name' => 'Fees Amount'),
            array('field' => 'transport_fee_amount', 'human_name' => 'Transport Fee (YES/No)'),
            array('field' => 'late_fine', 'human_name' => 'Late Fine Amount(if any)'),
            array('field' => 'no_late_month', 'human_name' => 'No. of Late Month'),
            array('field' => 'mode', 'human_name' => 'Mode'),
            array('field' => 'bank_code', 'human_name' => 'Bank code'),
            array('field' => 'collection_centre', 'human_name' => 'Collection centre'),
            array('field' => 'payment_date', 'human_name' => 'payment date'),
            array('field' => 'remarks', 'human_name' => 'Remarks'),
            array('field' => 'instant_fee_name', 'human_name' => 'Instant Fee Name(if Instant fee in Fee Head)'),
        );
        $this->page_title = 'Upload Fees Collection';
        $this->section = 'feepayment/collection';
        $this->page_name = 'upload_payment';
        $this->customview = '';
    }

    public function index($msg = 'yes', $validation = '') {
        
        if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->data['message'] = '';
//        $this->data['aclass'] = $this->dbconnection->select("class", "id,class_name", "status='Y'");
        $this->data['acollectioncentre'] = $this->dbconnection->select("collection_center", "collection_code", "status='Y' and collection_code!='FCLB'");
        $this->data['page_name'] = $this->page_name;
        $this->data['page_title'] = $this->page_title;
        $this->data['section'] = $this->section;
        $this->data['customview'] = $this->customview;
        $this->data['right_access'] = $this->right_access;
        $this->data['fee_cat1'] =$this->fee_cat1;
        $this->data['activesess'] = $this->academic_session[0]->fin_year;
        $this->data['session'] = $this->dbconnection->select("accedemic_session", "*", "status='Y'");

        $this->data['token'] = $msg;
        if (!empty($this->session->userdata('offln_error'))) {
            $this->session->set_flashdata('myMSG', 'Please Check CSV File to see the Below Errors');
            $this->data['message'] = $this->session->flashdata('myMSG');
            $this->data['errors'] = $this->session->userdata('offln_error');
            $this->session->unset_userdata('offln_error');
        } else {

            $this->data['message'] = $this->session->flashdata('myMSG');
        }

        $this->data['action'] = 'feepayment/collection/Upload_payment/save_offln_payment';
        $this->load->view('index', $this->data);
    }

    public function save_offln_payment() {
//        ini_set('max_input_time', 0);
//                ini_set('max_execution_time', 0);
//                ini_set('display_errors', 1);

        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        ini_set('max_execution_time', 3600);
//        error_reporting(-1);
//        ini_set('display_errors', 1);
        $this->data['message'] = 'no upload';
        $this->data['errors'] = array();
        $accedmic_sssion = $this->dbconnection->select('accedemic_session', 'max(id) as max_year', 'active="Y" and status="Y"');
        $current_year = $accedmic_sssion[0]->max_year;
        $chooseyear = $this->input->post('academic_session');
        
        $startyear=$this->dbconnection->select('accedemic_session', 'start_date', 'id='.$chooseyear);
        $startyear=$startyear[0]->start_date;
        $admsn_error = array();
        $month_arr = array(1 => "April", 2 => "May", 3 => "June", 4 => "July", 5 => "Aug", 6 => "Sep", 7 => "Oct", 8 => "Nov", 9 => "Dec", 10 => "Jan", 11 => "Feb", 12 => "Mar");
        
        
        $this->db->select('id, fee_name');
        $this->db->where('status=1');
        $query = $this->db->get('fee_master');
        $fee_type = array_change_key_case(array_column($query->result_array(), 'id', 'fee_name'), CASE_UPPER);
        
        
        if (!empty($_FILES['offln_payment_upload']['tmp_name'])) {



            $handle = fopen($_FILES['offln_payment_upload']['tmp_name'], "r");
            fgetcsv($handle);

            /* ------  reading file  ------- */
            $linerow = 1;
            while (($data = fgetcsv($handle, 10000, ",")) !== FALSE) {
                $linerow++;
                
                
                $fetchstudent_id = $this->dbconnection->select("student", "id,class_id,course_id,stud_category,student_academicyear_id,start_fee_month", "admission_no='$data[0]'");
                $start_fee_month=$fetchstudent_id[0]->start_fee_month;
                if (count($fetchstudent_id) == 0) {
                    $this->data['errors'][] = "Line $linerow: Admission Number '" . $data[0] . "' not in our database, skipping...";
                    continue;
                }

                $stud_id = $fetchstudent_id[0]->id;
                $stud_class_id = $fetchstudent_id[0]->class_id;
                
                
                if($fetchstudent_id[0]->student_academicyear_id!=$chooseyear) {
                    $fetchstudent_id = $this->dbconnection->select("student_class_acedemic_log", "student_id as id,class_id,course_id,stud_category,acedemic_year_id as student_academicyear_id", "student_id='$stud_id' and acedemic_year_id='$chooseyear'");
                }
                
                if (count($fetchstudent_id) == 0) {
                    $this->data['errors'][] = "Line $linerow: Admission Number '" . $data[0] . "' not in our database, skipping...";
                    continue;
                }
                
                
                $monthly_ann_amount = 0;
                $transport_amount = 0;
                $total_paid_month = 0;
                $class_fee_head_id_qry = $this->dbconnection->select('class_fee_head', 'id,year', '(from_class_id <=' . $fetchstudent_id[0]->class_id . ' and  to_class_id >=' . $fetchstudent_id[0]->class_id . ') and course=' . $fetchstudent_id[0]->course_id . ' and status="Y" and year<="'.$startyear.'" ', 'id', 'DESC', '1');

                if (empty($class_fee_head_id_qry[0]->id)) {
                    $this->data['errors'][] = "Line $linerow: Admission Number '" . $data[0] . "' contains no fee structure, skipping...";
                    continue;
                }
                $class_fee_head_id = $class_fee_head_id_qry[0]->id;
                if (strtoupper("$data[1]") == 'MON' || strtoupper("$data[1]") == 'QTR') {
                    $fetch_m = $this->dbconnection->select("fee_transaction_det", "count(month_no) paid", "fee_trans_head_id in(select id from fee_transaction_head where year=$chooseyear and student_id=" . $stud_id . " and paid_status=1 and response_code=0 and status=1) and fee_cat_id in (2,5)");
                    $total_paid_month = $fetch_m[0]->paid + ($start_fee_month-1);
                    if(strtoupper("$data[1]") == 'MON') {
                        $test = $total_paid_month + $data[2];
                    }else{
                        $test = $total_paid_month + ($data[2]*3);
                    }
                    
                    if ($test > 12) {
                        $this->data['errors'][] = "Line $linerow: Admission Number '" . $data[0] . "' contains next year payment, skipping...";
                        continue;
                    }
                    if (empty($data[2])) {
                        $this->data['errors'][] = "Line $linerow: Admission Number '" . $data[0] . "' contains No of Month Blank, skipping...";
                        continue;
                    }
                    $fee_details = $this->db->query("SELECT sum(fee_amount) fee_amount FROM class_fee_det WHERE class_fee_head_id=$class_fee_head_id and stud_cat={$fetchstudent_id[0]->stud_category} and fee_cat in (2,5) and status=1")->result();
                    
                    $monthly_ann_amount = $data[2] * $fee_details[0]->fee_amount;
                    
                    
                }
                if (strtoupper("$data[1]") == 'ANN') {
                    $fetch_a = $this->dbconnection->select("fee_transaction_det", "id", "fee_trans_head_id in(select id from fee_transaction_head where year=$chooseyear and student_id=" . $stud_id . " and paid_status=1 and response_code=0 and status=1) and fee_cat_id=1");
                    
                    if(count($fetch_a)>0) {
                        $this->data['errors'][] = "Line $linerow: Admission Number '" . $data[0] . "' already paid annual, skipping...";
                        continue;
                    }
                    $fee_details = $this->db->query("SELECT sum(cd.fee_amount) fee_amount,sum(if(fm.fee_type='REFUND',fee_amount,0)) refundamt FROM class_fee_det cd join fee_master fm on fm.id=cd.fee_id WHERE cd.class_fee_head_id=$class_fee_head_id and cd.stud_cat={$fetchstudent_id[0]->stud_category} and cd.fee_cat=1 and cd.status=1")->result();
                    $monthly_ann_amount = $fee_details[0]->fee_amount;
                    
                    if ($start_fee_month != 1 || $this->school_desc[0]->school_group=='ARMY') {
                        $refunded=$fee_details[0]->refundamt/12;
                        $total_refunded = $refunded * ($start_fee_month - 1);
                        $monthly_ann_amount = $monthly_ann_amount-$total_refunded;
                    }
                }
                
                $onetme_amount=0;
                $deposit_amount=0;
                if (strtoupper("$data[1]") == 'ONE') {
                    $fetch_a = $this->dbconnection->select("fee_transaction_det", "id", "fee_trans_head_id in(select id from fee_transaction_head where year=$chooseyear and student_id=" . $stud_id . " and paid_status=1 and response_code=0 and status=1) and fee_cat_id in (9,10)");
                    
                    if(count($fetch_a)>0) {
                        $this->data['errors'][] = "Line $linerow: Admission Number '" . $data[0] . "' already paid onetime, skipping...";
                        continue;
                    }
                    $fee_details = $this->db->query("SELECT sum(cd.fee_amount) fee_amount, sum(if(cd.fee_cat=9,fee_amount,0)) onetme , sum(if(cd.fee_cat=10,fee_amount,0)) deposit   FROM class_fee_det cd join fee_master fm on fm.id=cd.fee_id WHERE cd.class_fee_head_id=$class_fee_head_id and cd.stud_cat={$fetchstudent_id[0]->stud_category} and cd.fee_cat in (9,10) and cd.status=1")->result();
                    $monthly_ann_amount = $fee_details[0]->fee_amount;
                    $onetme_amount = $fee_details[0]->onetme;
                    $deposit_amount = $fee_details[0]->deposit;
                    
              
                }
                
                if (strtoupper("$data[1]") == 'INSTANT') {
                    $a=$fee_type[strtoupper($data[11])];
                    if (empty($a)) {
                        $this->data['errors'][] = "Line $linerow: Admission Number '" . $data[0] . "' contains Invalid Instant Fee, skipping...";
                        continue;
                    }
                    $fee_details = $this->dbconnection->select("student_other_fee as fee", "amount as fee_amount", "fee.student_id=$stud_id and fee_id=$a and year=$chooseyear and paid_status!=1 and status='Y' ");
                    $monthly_ann_amount = $fee_details[0]->fee_amount;
                    $data[4]=0;
                }
                if (!empty($data[3]) && strtoupper("$data[1]") == 'MON') {
                    $transport_amount = $this->dbconnection->Get_namme("student", "id", $stud_id, 'transport_amt');
                    if (!empty($transport_amount)) {
//                            $transport_amount=$transport_amount;
                        $transport_amount = $transport_amount * $data[2];
                        switch ($this->session->userdata('school_id')) {
                            case 29:
                            if(($total_paid_month < 3) && ($data[2] >= 3 - $total_paid_month)){ //June
                                $transport_amount = $transport_amount * ($data[2] - 1);
                            }
                            break;
                             case 35:
                              $trans= $transport_amount;
                            if(($total_paid_month < 3) && ($data[2] >= 3 - $total_paid_month)){     //June
                                $transport_amount = $transport_amount * ($data[2] - 1);
                            }
                            if((($stud_class_id==10)||($stud_class_id==12))&&(($total_paid_month < 12) && ($data[2] >= 12 - $total_paid_month))) {          //March
                                $transport_amount = $transport_amount * ($data[2] - 1);
                            }
                            break;
                            case 24:
                                if (($total_paid_month < 3) && ($data[2] >= 3 - $total_paid_month)) { //June
                                    $transport_amount = $transport_amount * ($data[2] - 1);
                                }
                                break;
                            case 33:
                                if(($total_paid_month < 3) && ($data[2] >= 3 - $total_paid_month)){ //June
                                    $transport_amount = $transport_amount * ($data[2] - 1);
                                }
                                break;
                            case 25:
                                if (($total_paid_month < 2) && ($data[2] >= 2 - $total_paid_month)) { //May
                                    $transport_amount = $transport_amount * ($data[2] - 1);
                                }
                                break;
                                 case 38:
                                if (($total_paid_month < 2) && ($data[2] >= 2 - $total_paid_month)) { //May
                                    $transport_amount = $transport_amount * ($data[2] - 1);
                                }
                                break;
                            case 26:
                                if(($total_paid_month < 2) && ($data[2] >= 2 - $total_paid_month)){ //May
                                    $transport_amount = $transport_amount * ($data[2] - 1);
                                }
                                break;
                            default:
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
                  $class_fee_head_year = $class_fee_head_id_qry[0]->year;


                if (empty($class_fee_head_id_qry[0]->id)) {
                    $this->data['errors'][] = "Line $linerow: Admission Number '" . $data[0] . "' contains no fee structure, skipping...";
                    continue;
                }

                $paid_status = 1;


                if (strtoupper("$data[1]") == 'MON' || strtoupper("$data[1]") == 'QTR' || strtoupper("$data[1]") == 'ANN' || strtoupper("$data[1]") == 'ONE' || strtoupper("$data[1]") == 'INSTANT') {


                    /* ---------- Saving Details to Fee Payment record table(fee_transaction_head)  --------- */
                    $total_amount = $monthly_ann_amount + $transport_amount + $data[4];
                    $this->dbconnection->insert("fee_transaction_head", array('student_id' => $stud_id, 'year' => $chooseyear,
                        'total_amount' => $total_amount, 'paid_by' => $this->session->userdata('user_id'), 'payment_date' => date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $data[9]))),
                        'remarks' => $data[10], 'mode' => strtoupper($data[6]), 'collection_centre' => $data[8], 'response_code' => 0, 'payment_method' => $data[6],
                        'response_message' => 'Payment Successful', 'paid_status' => 1, 'req_ipaddr_str' => $_SERVER['REMOTE_ADDR'],
                        'receipt_no' => '', 'bank_name' => $data[7], 'date_created' => date('Y-m-d H:i:s'), 'created_by' => $this->session->userdata('user_id')));
                    $fee_transac_id = $this->dbconnection->get_last_id();
                    /* --------------------------------------------------------------------------------------- */

                    $description = "Offline Collection Total $total_amount - AdmissionN0 $data[0] - Student ID $stud_id of session $chooseyear from IP:" . $_SERVER['REMOTE_ADDR'];

                    /* ---------- Saving Details to Fee Payment Action table(fee_transaction_action)  --------- */

                    $this->dbconnection->insert("fee_transaction_action", array('fee_transaction_head_id' => $fee_transac_id, 'action_description' => 'Offline Collection',
                        'created_by' => $this->session->userdata('user_id'), 'full_pymt_description' => $description));
                    $fee_action_id = $this->dbconnection->get_last_id();

                    /* --------------------------------------------------------------------------------------- */
                } else {
                    $this->data['errors'][] = "Line $linerow: Fee Head $data[1] is invalid";
                    continue;
                }

                if (strtoupper("$data[1]") == 'MON') {
//
                    $fee_cat_id = 2;
                    $no_of_month = $data[2];
                    $from = $total_paid_month + 1;
                    $amount = $monthly_ann_amount / $no_of_month;
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
                        if ($this->school_desc[0]->fine_monthly_segregation == 'YES') {
                            $due_month = $total_paid_month + 1;
                            $fine_arr = array();
                            array_push($fine_arr, "0");
                            $quer_fine = $this->dbconnection->select("class_fee_det", "fee_amount,no_of_months", 'class_fee_head_id in(select id from class_fee_head '
                                    . ' where year=' . $class_fee_head_year
                                    . ' and  (from_class_id <=' . $fetchstudent_id[0]->class_id . ' and  to_class_id >=' . $fetchstudent_id[0]->class_id
                                    . ' and course=' . $fetchstudent_id[0]->course_id . ')) and status=1 and stud_cat=0 and fee_cat=0 ');

                            foreach ($quer_fine as $row) {
                                array_push($fine_arr, "$row->fee_amount");
                            }
//                            print_r($fine_arr);
                            for ($dm = $due_month_no; $dm >= 1; $dm--) {

                                $ist_index = $dm;
                                $scnd_index = $dm - 1;
                                $amountf = $fine_arr[$ist_index] - $fine_arr[$scnd_index];
                                $this->dbconnection->insert("fee_transaction_det", array('amount' => $amountf, 'fee_cat_id' => 0,
                                    'month_desc' => $month_arr[$due_month], 'fee_trans_head_id' => $fee_transac_id, 'due_month_no' => $dm,
                                    'class_fee_head_id' => $class_fee_head_id, 'stud_category' => $fetchstudent_id[0]->stud_category, 'created_by' => $this->session->userdata('user_id')));
                                $due_month++;
                            }
                        } else {

                            $last_due_month = $total_paid_month + $due_month_no;
                            $init_month = $total_paid_month + 1;
                            $month_desc = "$month_arr[$init_month] to $month_arr[$last_due_month]";
                            $this->dbconnection->insert("fee_transaction_det", array('amount' => $data[4], 'fee_cat_id' => 0,
                                'month_desc' => $month_desc, 'fee_trans_head_id' => $fee_transac_id, 'due_month_no' => $due_month_no,
                                'class_fee_head_id' => $class_fee_head_id, 'stud_category' => $fetchstudent_id[0]->stud_category, 'created_by' => $this->session->userdata('user_id')));
                        }
                    }



                    if ($this->fee_cat2 == 4) {
                        $half_yearly_fee = $this->db->query('SELECT fee_id,fee_amount,'
                                . '(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name,(select SUBSTRING_INDEX(month_set,",",1) from fee_master where id=class_fee_det.fee_id) as first_half ,(select SUBSTRING_INDEX(month_set,",",-1) from fee_master where id=class_fee_det.fee_id) as second_half'
                                . ' FROM class_fee_det where fee_cat=4 and stud_cat=' . $fetchstudent_id[0]->stud_category . ' and '
                                . 'class_fee_head_id=' . $class_fee_head_id . ' and status=1');
//                    $half_yearly_month= array_column($half_yearly_fee->result_array(), 'month_set','id');
                        $half_yearly_amount = array_column($half_yearly_fee->result_array(), 'fee_amount', 'fee_id');
                        $half_yearly_first_half = array_column($half_yearly_fee->result_array(), 'first_half', 'fee_id');
                        $half_yearly_second_half = array_column($half_yearly_fee->result_array(), 'second_half', 'fee_id');
                        $year = $this->academic_session[0]->fin_year;
                        $query_half_trans = $this->db->query('SELECT * from fee_transaction_det where fee_trans_head_id in( select id from fee_transaction_head where year=' . $chooseyear . ' and student_id=' . $stud_id . ' and paid_status=1 and status=1) and fee_cat_id=4');
                        $qhalfmonth = array_column($query_half_trans->result_array(), 'month_no', 'halfyearly_fee_id');
                        $half_yearly_fee_id = array();
                        $half_yearly_fee_amount = array();
                        $tot_half_amt = 0;
                        for ($i = $total_paid_month + 1; $i <= $total_paid_month + $no_of_month; $i++) {
                            $dbq = $this->db->query("SELECT id,fee_name,month_set,(SELECT fee_amount FROM class_fee_det where fee_cat=4 and stud_cat={$fetchstudent_id[0]->stud_category} and class_fee_head_id=$class_fee_head_id and status=1 and fee_id=fee_master.id) fee_amount FROM `fee_master` WHERE fee_cat_id=4 and FIND_IN_SET('$i', month_set) group by id")->result();
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
                        foreach ($half_yearly_fee_id as $key => $value) {
                            if ($value == $half_yearly_amount[$key] * 2) {

                                $tot_half_amt = $tot_half_amt + $half_yearly_amount[$key] + $half_yearly_amount[$key];
                                $this->dbconnection->insert("fee_transaction_det", array('amount' => $half_yearly_amount[$key], 'month_no' => $half_yearly_first_half[$key],
                                    'fee_cat_id' => 4, 'fee_trans_head_id' => $fee_transac_id, 'halfyearly_fee_id' => $key,
                                    'class_fee_head_id' => $class_fee_head_id, 'stud_category' => $fetchstudent_id[0]->stud_category, 'created_by' => $this->session->userdata('user_id')));
                                $this->dbconnection->insert("fee_transaction_det", array('amount' => $half_yearly_amount[$key], 'month_no' => $half_yearly_second_half[$key],
                                    'fee_cat_id' => 4, 'fee_trans_head_id' => $fee_transac_id, 'halfyearly_fee_id' => $key,
                                    'class_fee_head_id' => $class_fee_head_id, 'stud_category' => $fetchstudent_id[0]->stud_category, 'created_by' => $this->session->userdata('user_id')));
                            } else {
                                if (empty($qhalfmonth[$key]) || count($qhalfmonth[$key]) < 1) {
                                    $m = $half_yearly_first_half[$key];
                                } else {
                                    $m = $half_yearly_second_half[$key];
                                }
                                $tot_half_amt = $tot_half_amt + $half_yearly_amount[$key];
                                $this->dbconnection->insert("fee_transaction_det", array('amount' => $half_yearly_amount[$key], 'month_no' => $m,
                                    'fee_cat_id' => 4, 'fee_trans_head_id' => $fee_transac_id, 'halfyearly_fee_id' => $key,
                                    'class_fee_head_id' => $class_fee_head_id, 'stud_category' => $fetchstudent_id[0]->stud_category, 'created_by' => $this->session->userdata('user_id')));
                            }
                        }

                        $this->db->set('total_amount', 'total_amount+' . $tot_half_amt, FALSE);
                        $this->db->set('payment_date', date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $data[9]))));
                        $this->db->where('id', $fee_transac_id);
                        $this->db->update('fee_transaction_head');
                    }

                    $oth_fee_id = array();
                    $oth_fee_amount = array();
                    for($j = $total_paid_month + 1; $j <= $total_paid_month + $no_of_month; $j++) {
                        $othquery = $this->db->query("SELECT id,fee_name,month_set,(SELECT fee_amount FROM class_fee_det where fee_cat=3 and stud_cat=0 and class_fee_head_id=$class_fee_head_id and status=1 and fee_id=fee_master.id) fee_amount FROM `fee_master` WHERE fee_cat_id=3 and FIND_IN_SET('$j', month_set) and status=1 group by id")->result();
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
                    $total_othfee = 0;
                    foreach ($oth_fee_id as $keyo => $valueo) {
                        $total_othfee = $total_othfee + $oth_fee_amount[$keyo];
                        $this->dbconnection->insert("fee_transaction_det", array('amount' => $oth_fee_amount[$keyo],
                            'fee_cat_id' => 3, 'fee_trans_head_id' => $fee_transac_id, 'other_fee_id' => $keyo,
                            'class_fee_head_id' => $class_fee_head_id, 'stud_category' => $fetchstudent_id[0]->stud_category, 'created_by' => $this->session->userdata('user_id')));
                    }
                    
                    if($total_othfee!=0) {
                        $this->db->set('total_amount', 'total_amount+' . $total_othfee, FALSE);
                        $this->db->set('payment_date', date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $data[9]))));
                        $this->db->where('id', $fee_transac_id);
                        $this->db->update('fee_transaction_head');
                    }
                        
                }else if (strtoupper("$data[1]") == 'QTR') {
//
                    $fee_cat_id = 5;
                    $no_of_qtr = $data[2];
                    $from = $total_paid_month + 1;
                    $amount = $monthly_ann_amount / $no_of_qtr;
                    $no_of_month=($no_of_qtr*3)-($start_fee_month-1);
                    for ($m = 1; $m <= $no_of_month; $m++) {

                        $result = $this->dbconnection->insert("fee_transaction_det", array('amount' => $amount, 'month_no' => $from,
                            'fee_cat_id' => $fee_cat_id, 'month_desc' => $month_arr[$from].'-QTR-'.$this->qtr[$from], 'fee_trans_head_id' => $fee_transac_id,
                            'class_fee_head_id' => $class_fee_head_id, 'stud_category' => $fetchstudent_id[0]->stud_category, 'created_by' => $this->session->userdata('user_id')));

                        $from++;
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


                    $oth_fee_id = array();
                    $oth_fee_amount = array();
                    for($j = $total_paid_month + 1; $j <= $total_paid_month + $no_of_month; $j++) {
                        $othquery = $this->db->query("SELECT id,fee_name,month_set,(SELECT fee_amount FROM class_fee_det where fee_cat=3 and stud_cat=0 and class_fee_head_id=$class_fee_head_id and status=1 and fee_id=fee_master.id) fee_amount FROM `fee_master` WHERE fee_cat_id=3 and FIND_IN_SET('$j', month_set) and status=1 group by id")->result();
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
                    $total_othfee = 0;
                    foreach ($oth_fee_id as $keyo => $valueo) {
                        $total_othfee = $total_othfee + $oth_fee_amount[$keyo];
                        $this->dbconnection->insert("fee_transaction_det", array('amount' => $oth_fee_amount[$keyo],
                            'fee_cat_id' => 3, 'fee_trans_head_id' => $fee_transac_id, 'other_fee_id' => $keyo,
                            'class_fee_head_id' => $class_fee_head_id, 'stud_category' => $fetchstudent_id[0]->stud_category, 'created_by' => $this->session->userdata('user_id')));
                    }
                    
                    if($total_othfee!=0) {
                        $this->db->set('total_amount', 'total_amount+' . $total_othfee, FALSE);
                        $this->db->set('payment_date', date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $data[9]))));
                        $this->db->where('id', $fee_transac_id);
                        $this->db->update('fee_transaction_head');
                    }
                        
                } else if (strtoupper("$data[1]") == 'ANN') {
                    $fee_cat_id = 1;
                    $no_of_month = 0;

                    $result = $this->dbconnection->insert("fee_transaction_det", array('amount' => $monthly_ann_amount,
                        'fee_cat_id' => $fee_cat_id, 'fee_trans_head_id' => $fee_transac_id,
                        'class_fee_head_id' => $class_fee_head_id, 'stud_category' => $fetchstudent_id[0]->stud_category, 'created_by' => $this->session->userdata('user_id')));
                } else if (strtoupper("$data[1]") == 'ONE') {
                    $fee_cat_id = 1;
                    $no_of_month = 0;

                    $result = $this->dbconnection->insert("fee_transaction_det", array('amount' => $onetme_amount,
                        'fee_cat_id' => 9, 'fee_trans_head_id' => $fee_transac_id,
                        'class_fee_head_id' => $class_fee_head_id, 'stud_category' => $fetchstudent_id[0]->stud_category, 'created_by' => $this->session->userdata('user_id')));
                    
                    $result = $this->dbconnection->insert("fee_transaction_det", array('amount' => $deposit_amount,
                        'fee_cat_id' => 10, 'fee_trans_head_id' => $fee_transac_id,
                        'class_fee_head_id' => $class_fee_head_id, 'stud_category' => $fetchstudent_id[0]->stud_category, 'created_by' => $this->session->userdata('user_id')));
                    
                }else if (strtoupper("$data[1]") == 'INSTANT') {
                    $fee_cat_id = 8;
                    $no_of_month = 0;

                    $result = $this->dbconnection->insert("fee_transaction_det", array('amount' => $monthly_ann_amount,'other_fee_id'=>$fee_type[strtoupper($data[11])],
                        'fee_cat_id' => $fee_cat_id, 'fee_trans_head_id' => $fee_transac_id,
                        'class_fee_head_id' => $class_fee_head_id, 'stud_category' => $fetchstudent_id[0]->stud_category, 'created_by' => $this->session->userdata('user_id')));
                    $this->dbconnection->update("student_other_fee",
                            array('paid_status'=>1,
                                'last_date_modified'=>date('Y-m-d H:i:s'),
                                'modified_by'=>$this->session->userdata('user_id')
                            ),
                            array('student_id'=>$stud_id,'fee_id'=>$fee_type[strtoupper($data[11])],
                                'amount'=>$monthly_ann_amount,'paid_status'=>0,'status'=>'Y'));
                    
                }

                $audit = array("action" => 'Offline Payment Collection',
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
        header('Location:' . site_url("feepayment/collection/Upload_payment"));
    }

//    public function get_fine(){
//        
//        $fine_amount=0;
//        if ($this->school_desc[0]->fine_type_checkbox == 'ADJUSTABLE') {
//                    $duemonthcancel=$actual_due_month-$due_month;
//                    $quer_fine_actual = $this->dbconnection->select("class_fee_det", "fee_amount", 'class_fee_head_id in(select id from class_fee_head '
//                        . ' where year=' . $fee_session_year
//                        . ' and  (from_class_id <=' . $class . ' and  to_class_id >=' . $class
//                        . ' and course=' . $course . ' and year<='.$this->session_start_yr.')) and status=1 and stud_cat=0 and fee_cat=0 and '
//                        . ' (( fine_condition=1 and no_of_months=' . $actual_due_month . ') or ( fine_condition=2 and no_of_months<' . $actual_due_month . ') '
//                        . ' or ( fine_condition=3 and no_of_months <= ' . $actual_due_month . ') '
//                        . ' or ( fine_condition=4 and no_of_months > ' . $actual_due_month . ') '
//                        . ' or ( fine_condition=5 and no_of_months >= ' . $actual_due_month . '))');
//
//                    $quer_fine_cancel = $this->dbconnection->select("class_fee_det", "fee_amount", 'class_fee_head_id in(select id from class_fee_head '
//                        . ' where year=' . $fee_session_year
//                        . ' and  (from_class_id <=' . $class . ' and  to_class_id >=' . $class
//                        . ' and course=' . $course . ' and year<='.$this->session_start_yr.')) and status=1 and stud_cat=0 and fee_cat=0 and '
//                        . ' (( fine_condition=1 and no_of_months=' . $duemonthcancel . ') or ( fine_condition=2 and no_of_months<' . $duemonthcancel . ') '
//                        . ' or ( fine_condition=3 and no_of_months <= ' . $duemonthcancel . ') '
//                        . ' or ( fine_condition=4 and no_of_months > ' . $duemonthcancel . ') '
//                        . ' or ( fine_condition=5 and no_of_months >= ' . $duemonthcancel . '))');
//                    if(count($quer_fine_actual) > 0){
//                        if(count($quer_fine_cancel) > 0) {
//                            $fine_amount = $quer_fine_actual[0]->fee_amount-$quer_fine_cancel[0]->fee_amount;
//                        }else{
//                            $fine_amount = $quer_fine_actual[0]->fee_amount;
//                        }
//                    }
//                }elseif ($this->school_desc[0]->fine_type_checkbox == 'NOT_CHANGEABLE') {
//                    $quer_fine_actual = $this->dbconnection->select("class_fee_det", "fee_amount", 'class_fee_head_id in(select id from class_fee_head '
//                            . ' where year=' . $fee_session_year
//                            . ' and  (from_class_id <=' . $class . ' and  to_class_id >=' . $class
//                            . ' and course=' . $course . ' and year<='.$this->session_start_yr.')) and status=1 and stud_cat=0 and fee_cat=0 and '
//                            . ' (( fine_condition=1 and no_of_months=' . $actual_due_month . ') or ( fine_condition=2 and no_of_months<' . $actual_due_month . ') '
//                            . ' or ( fine_condition=3 and no_of_months <= ' . $actual_due_month . ') '
//                            . ' or ( fine_condition=4 and no_of_months > ' . $actual_due_month . ') '
//                            . ' or ( fine_condition=5 and no_of_months >= ' . $actual_due_month . '))');
//                    if (count($quer_fine_actual) > 0) {
//                        $fine_amount = $quer_fine_actual[0]->fee_amount;
//                    }
//                }else {
//                    
//                    $quer_fine = $this->dbconnection->select("class_fee_det", "fee_amount", 'class_fee_head_id in(select id from class_fee_head '
//                        . ' where year=' . $fee_session_year
//                        . ' and  (from_class_id <=' . $class . ' and  to_class_id >=' . $class
//                        . ' and course=' . $course . ' and year<='.$this->session_start_yr.')) and status=1 and stud_cat=0 and fee_cat=0 and '
//                        . ' (( fine_condition=1 and no_of_months=' . $due_month . ') or ( fine_condition=2 and no_of_months<' . $due_month . ') '
//                        . ' or ( fine_condition=3 and no_of_months <= ' . $due_month . ') '
//                        . ' or ( fine_condition=4 and no_of_months > ' . $due_month . ') '
//                        . ' or ( fine_condition=5 and no_of_months >= ' . $due_month . '))');
//
//                    if (count($quer_fine) > 0) {
//                        $fine_amount = $quer_fine[0]->fee_amount;
//                    }
//                    
//                }
//                return $fine_amount;
//    }
//    public function download_format()
//    { 
//            $this->load->helper('download');
//            force_download('./Download/Offline_payment_structure.csv', NULL);                                        
//    }
    public function download_format() {
        $this->load->helper('download');
        $fh = fopen('php://memory', 'w');
        fputcsv($fh, array_column($this->uploadfee_csv_columns, 'human_name'));
        fseek($fh, 0);
        $csv = stream_get_contents($fh);
        $school_code=$this->session->userdata('school_code');
        force_download($school_code.'-Offline-Collection-Format.csv', $csv);
    }

    public function download_instruction() {
        $this->load->helper('download');
        force_download('./Download/Offln_pay_instruction.csv', NULL);
    }

}
