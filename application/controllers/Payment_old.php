<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payment extends CI_Controller {

    /**
     * @Author : Joyonto Roy
     * 22nd january 2013
     */
    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('login_type') != 'student' || empty($this->session->userdata('user_id'))) {

            redirect('/login');
        }
        $this->id = $this->session->userdata('school_id');
        $this->school = $this->dbconnection->select('school', '*', 'id = ' . $this->id);
        $this->countries = $this->dbconnection->select('countries', '*', 'id=' . $this->school[0]->country_id);
        $this->state = $this->dbconnection->select('states', '*', 'id=' . $this->school[0]->state_id);
        $this->city = $this->dbconnection->select('cities', '*', 'id=' . $this->school[0]->city_id);

        if ($this->id != 0) {
            $this->db->db_select('crmfeesclub_' . $this->id);
        }
        $this->page_title = 'Fee Payment';
        $this->section = 'feepayment/gateway';
        $this->page_name = 'pay';
        $this->customview = '';
    }

    public function index() {
        $user_id = $this->session->userdata('user_id');
        $user = $this->dbconnection->select('user', 'student_id', 'id = ' . $user_id);
        $student_id = $user[0]->student_id;
        $student = $this->dbconnection->select('student', 'id,transport_amt,course_id,'
                . ' class_id,(select class_name from class where id=student.class_id) as class_name,'
                . ' concat(first_name," ",middle_name," ",last_name) as name,first_name,'
                . ' stud_category,'
                . ' (select c.cat_name from category c where c.id=stud_category) as cat_name,'
                . '  section_id,(select s.sec_name from section s where s.id=section_id) as sec_name,'
                . ' email_address, phone,status,date_created, created_by,last_date_modified, last_modified_by', 'id = ' . $student_id);
        $school_id = $this->session->userdata('school_id');

        $student_cat = $student[0]->stud_category;
        $student_class_id = $student[0]->class_id;
        $max_year = $this->dbconnection->select('accedemic_session', 'max(id) as max_year');
        $year = $max_year[0]->max_year;

        $max_year = $this->dbconnection->select('class_fee_head', 'max(year) as max_year');
        $fee_session_year = $max_year[0]->max_year;

        $annual_fee = $this->db->query('SELECT fee_amount,'
                . '(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name '
                . 'FROM class_fee_det where fee_cat=1 and stud_cat=' . $student_cat . ' and'
                . ' class_fee_head_id in(select id from class_fee_head  where year=' . $fee_session_year . ' '
                . 'and  (from_class_id <=' . $student_class_id . ' and  to_class_id >=' . $student_class_id . ' '
                . 'and course=' . $student[0]->course_id . ')) and status=1');
        $annual_fee_paid = $this->db->query('SELECT * from fee_transaction_det where fee_trans_head_id in( select id from fee_transaction_head where year=' . $year . ' and student_id=' . $student_id . ' and paid_status=1 ) and fee_cat_id=1');
        $monthly_fee_paid = $this->db->query('SELECT * from fee_transaction_det where fee_trans_head_id in( select id from fee_transaction_head where year=' . $year . ' and student_id=' . $student_id . ' and paid_status=1 ) and fee_cat_id=2');
        $monthly_fee = $this->db->query('SELECT fee_amount,'
                . '(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name'
                . ' FROM class_fee_det where fee_cat=2 and stud_cat=' . $student_cat . ' and '
                . 'class_fee_head_id in(select id from class_fee_head  where year=' . $fee_session_year . ' and'
                . ' (from_class_id <=' . $student_class_id . ' and  to_class_id >=' . $student_class_id . ' and course=' . $student[0]->course_id . ')) and status=1');

        $other_fee = $this->db->query('SELECT *,fee_amount,'
                . '(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name '
                . 'FROM class_fee_det where fee_cat=3 and '
                . 'class_fee_head_id in(select id from class_fee_head  where year=' . $fee_session_year . ' and '
                . ' (from_class_id <=' . $student_class_id . ' and  to_class_id >=' . $student_class_id . '  and course=' . $student[0]->course_id . ')) and status=1');
        $half_yearly_fee = $this->db->query('SELECT fee_amount,'
                . '(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name '
                . 'FROM class_fee_det where fee_cat=4 and stud_cat=' . $student_cat . ' and '
                . 'class_fee_head_id in(select id from class_fee_head  where year=' . $fee_session_year . ' and '
                . ' (from_class_id <=' . $student_class_id . ' and  to_class_id >=' . $student_class_id . ' and course=' . $student[0]->course_id . ')) and status=1');

        $query_half_trans = $this->db->query('SELECT * from fee_trans_det where year=' . $year . ' and student_id=' . $student_id . '  and paid_status=1 and fee_cat_id=4 and response_code=0');

        $half_yearly_fee_history = $this->db->query('SELECT * from fee_trans_det where student_id=' . $student_id . ' and year=' . $year . ' and fee_cat_id=4 and response_message is not null');

        $transaction_history = $this->db->query("select f1.*,group_concat(distinct(f2.fee_cat_id)) as fee,count(case when f2.month_no<>0 then f2.month_no end) as m,min(case when f2.month_no<>0 then f2.month_no end) as from_month,max(f2.due_month_no) as d from fee_transaction_head f1, fee_transaction_det f2 where f1.student_id=$student_id and f1.year=$year and f1.response_message is not NULL and f1.id=f2.fee_trans_head_id group by f1.id");
        $paid_mon_query = $this->dbconnection->select('fee_transaction_det', 'count(month_no) as paid', 'fee_trans_head_id in( select id from fee_transaction_head where student_id=' . $student_id . ' and paid_status=1 and response_code=0  and year=' . $year . ') and fee_cat_id=2');
        $total_month_paid = $paid_mon_query[0]->paid;

        list($year, $month, $day) = explode('-', date('Y-m-d'));
        $current_month = $month;
        $pais_status = array();
        $paid_month_array = array();
        $checked_status = array();
        $id = array();
        for ($pm = 1; $pm <= $total_month_paid; $pm++) {
            $paid_month_array[] = $pm;
            $pais_status[$pm] = 'checked disabled';
            $checked_status[$pm] = 'disabled';
        }

        $count = 0;
        for ($i = 1; $i <= 12; $i++) {
            if (!in_array($i, $paid_month_array)) {
                if ($month >= 1 && $month <= 3) {
                    $month = $month + 12;
                }
                if ($i <= ($month - 3)) {
                    $checked_status[$i] = 'checked';
                    $count++;
                } else {
                    $checked_status[$i] = '';
                }
            }
        }

        /* ----------- late fine ---------- */

        $disable_trans = 0;
        $fine_amount = 0;
        $fine_apply_status = 0;
        $due_month = $count - 1;


        if ($day < $this->school[0]->start_pay_date || $day > $this->school[0]->last_pay_date) {

            if ($this->school[0]->transc_freeze_status == 1) {
                $disable_trans = 1;
            }
            if ($due_month > 0) {
                $fine_apply_status = 1;
            }


            if ($day < $this->school[0]->start_pay_date) {

                $start_date = $this->school[0]->start_pay_date . '-' . $current_month . '-' . $year;
            } else {

                $m = $current_month + 1;
                $start_date = $this->school[0]->start_pay_date . '-' . $m . '-' . $year;
            }
        } else {

            if ($due_month > 0) {
                $fine_apply_status = 1;
            }
            $start_date = '';
        }



        if ($fine_apply_status == 1) {

            $quer_fine = $this->dbconnection->select("class_fee_det", "fee_amount", 'class_fee_head_id in(select id from class_fee_head '
                    . ' where year=' . $fee_session_year
                    . ' and  (from_class_id <=' . $student_class_id . ' and  to_class_id >=' . $student_class_id
                    . ' and course=' . $student[0]->course_id . ')) and status=1 and stud_cat=0 and fee_cat=0 and '
                    . ' (( fine_condition=1 and no_of_months=' . $due_month . ') or ( fine_condition=2 and no_of_months<' . $due_month . ') '
                    . ' or ( fine_condition=3 and no_of_months <= ' . $due_month . ') '
                    . ' or ( fine_condition=4 and no_of_months > ' . $due_month . ') '
                    . ' or ( fine_condition=5 and no_of_months >= ' . $due_month . '))');

            if (count($quer_fine) > 0) {
                $fine_amount = $quer_fine[0]->fee_amount;
            }
        }
        /* -----------  --------------------- */

        $school = $this->school;
        $data = array(
            'school_name' => $school[0]->description,
            'school_address' => $school[0]->address,
            'checked_status' => $checked_status,
            'count' => $count,
            'pais_status' => $pais_status,
            'annual_fee' => $annual_fee,
            'monthly_fee' => $monthly_fee,
            'other_fee' => $other_fee,
            'annual_fee_paid' => $annual_fee_paid,
            'monthly_fee_paid' => $monthly_fee_paid,
            'half_yearly_fee' => $half_yearly_fee,
            'half_yearly_fee_history' => $half_yearly_fee_history,
            'page' => 'student',
            'fee_type1' => $school[0]->fee_type1,
            'fee_type2' => $school[0]->fee_type2,
            'student' => $student,
            'school' => $school,
            'msg1' => '',
            'msg2' => '',
            'query_half_trans' => $query_half_trans->result(),
            'student_id' => $student_id,
            'fine_amount' => $fine_amount,
            'disable_trans' => $disable_trans,
            'fine_apply_status' => $fine_apply_status,
            'start_pay_date' => $start_date,
            'due_month' => $due_month,
            'transaction_history' => $transaction_history,
            'transport_fee_amt' => $student[0]->transport_amt,
            'page_name' => $this->page_name,
            'page_title' => $this->page_title,
            'section' => $this->section,
            'customview' => $this->customview,
        );
        $this->load->view('index', $data);
    }

    public function request() {

        $final_total = 0;
        list($current_year, $month, $day) = explode('-', date('Y-m-d'));

        $school_id = $this->session->userdata('school_id');
        $user = $this->dbconnection->select('user', '*', 'id = ' . $this->session->userdata('user_id'));
        $student = $this->dbconnection->select('student', 'id,reference_no,first_name, middle_name, last_name, stud_category,admission_no,'
                . ' (select c.cat_name from category c where c.id=stud_category) as cat_name,'
                . ' class_id,(select cl.class_name from class cl where cl.id=class_id) as class_name,'
                . ' section_id,(select s.sec_name from section s where s.id=section_id) as sec_name,'
                . ' course_id,email_address, phone,status, date_created, created_by, last_date_modified, last_modified_by', 'id = ' . $user[0]->student_id);

        $student_id = $user[0]->student_id;
        $class_name = $student[0]->class_name;
        $student_class_id = $student[0]->class_id;
        $user_id = $this->session->userdata('user_id');
        $student_cat = $student[0]->stud_category;

        if ($student[0]->email_address == '') {
            $email = 'abc@gmail.com';
        } else {
            $email = $student[0]->email_address;
        }

        $school = $this->school;
        $countries = $this->countries;
        $country_code = $countries[0]->country_code;
        $state = $this->state;
        $state_code = $state[0]->state_code;
        $city = $this->city;
        $city_code = $city[0]->city_code;
        $admission_no = $student[0]->admission_no;
        $school_code = $school[0]->school_code;
        $class_code = $class_name;

        $fee_trans = $this->dbconnection->select('accedemic_session', 'max(id) as max_id', 'status="Y"');
        $max_sesion_id = $fee_trans[0]->max_id;
        $year_class = $this->dbconnection->select('class_fee_head', 'max(year) as year');
        $class_fee_head_year = $year_class[0]->year;
        $monthly_fee_paid = $this->db->query('SELECT * from fee_transaction_det where fee_trans_head_id in( select id from fee_transaction_head where year=' . $max_sesion_id . ' and student_id=' . $student_id . ' and paid_status=1 ) and fee_cat_id=2');
        $class_fee_head_id = $this->dbconnection->select('class_fee_head', 'id', ' year=' . $class_fee_head_year . '  and (from_class_id <=' . $student_class_id . ' and  to_class_id >=' . $student_class_id . ') and course=' . $student[0]->course_id . ' and status="Y"');

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

        $total_paid_month = count($monthly_fee_paid->result());
        $total_check_month = count($month_id);
        $total_pay_month = $total_check_month - $total_paid_month;
        $table_html = '';
        $total_fee = 0;
        $fine_amount = 0;
        $fine_duemonth = 0;
        $cnt_other = 0;
        if (isset($_POST['total1'])) { //monthly fee pop up button id
            $year_val = 0;
            $fee_cat_id = 2;
            $month_no = ($fin_mont - $init_mont) + 1;
            $fine_amount = !empty($this->input->post('fine_amt')) ? $this->input->post('fine_amt') : 0;
            $fine_duemonth = !empty($this->input->post('fine_due_month')) ? $this->input->post('fine_due_month') : 0;
            $transport_fee_amt = !empty($this->input->post('trans_fee_amt')) ? $this->input->post('trans_fee_amt') : 0;
            $final_total = $this->input->post('total_m'); //total in month box
        }

        if (isset($_POST['total2'])) { //annual fee pop up button's id
            $year_val = $current_year;
            $fee_cat_id = 1;
            $month_no = 0;
            $final_total = $this->input->post('total_y1'); //total in annual box
        }

        if (isset($_POST['total3'])) { //monthly fee pop up button id on click on half yearly pay button
            $half = $this->input->post('half');
            $sem1_val = $this->input->post('total_h1');
            $count = 0;
            foreach ($half as $val) {
                $count++;
            }
            $year_val = $current_year;
            $fee_cat_id = 4;
            $month_no = 0;
            $final_total = ($sem1_val * $count);
        }
        if (isset($_POST['total4'])) {
            $year_val = 0;
            $fee_cat_id = 3;
            $month_no = 0;
            $final_total = $this->input->post('total_other');
            $otherfee = $this->input->post('other_amt');
        }


        if ($final_total == 0) {
            redirect(base_url('payment'), 'refresh');
        } else {
            /* ---------- Saving Details to Fee Payment record table(fee_transaction_head)  --------- */

            $this->dbconnection->insert("fee_transaction_head", array('student_id' => $student_id, 'request_status' => 1, 'year' => $max_sesion_id,
                'total_amount' => $final_total, 'paid_by' => $this->session->userdata('user_id'), 'payment_date' => date('Y-m-d H:i:s'), 'date_created' => date('Y-m-d H:i:s'),
                'remarks' => 'Sent to payment gateway', 'mode' => 'FCLB', 'collection_centre' => 'FCLB', 'req_ipaddr_str' => $_SERVER['REMOTE_ADDR']));
            $fee_transac_id = $this->dbconnection->get_last_id();
            /* --------------------------------------------------------------------------------------- */

            $month_arr = array(1 => "April", 2 => "May", 3 => "June", 4 => "July", 5 => "Aug", 6 => "Sep", 7 => "Oct", 8 => "Nov", 9 => "Dec", 10 => "Jan", 11 => "Feb", 12 => "Mar");


            /* ---------- Saving Details to Fee Payment Details table(fee_transaction_det)  --------- */
            if ($fee_cat_id == 2) { //monthly
                $amount = ($final_total - $fine_amount) / $month_no;
                for ($m = $init_mont; $m <= $fin_mont; $m++) {

                    $this->save_transaction_details($class_fee_head_id[0]->id, $student_cat, $amount, $m, $month_arr[$m], 0, NULL, $fee_cat_id, $fee_transac_id, $user_id);
                }

                /* ----- fine details saved ---- */

                if ($transport_fee_amt != 0) {
                    $this->save_transaction_details($class_fee_head_id[0]->id, $student_cat, $transport_fee_amt, 0, '', 0, NULL, 6, $fee_transac_id, $user_id);
                }

                if ($school[0]->fine_monthly_segregation == 'YES') {

                    $duemonthid = $init_mont;
                    $quer_fine = $this->dbconnection->select("class_fee_det", "fee_amount", 'class_fee_head_id in(select id from class_fee_head '
                            . ' where year=' . $class_fee_head_year
                            . ' and  (from_class_id <=' . $student_class_id . ' and  to_class_id >=' . $student_class_id
                            . ' and course=' . $student[0]->course_id . ')) and status=1 and stud_cat=0 and fee_cat=0 and '
                            . ' ( fine_condition=1 and no_of_months=1)');

                    for ($d = $fine_duemonth; $d >= 1; $d--) {

                        $amount = $d * $quer_fine[0]->fee_amount;
                        $this->save_transaction_details($class_fee_head_id[0]->id, $student_cat, $amount, 0, $month_arr[$duemonthid], $d, NULL, 0, $fee_transac_id, $user_id);
                        $duemonthid++;
                    }
                } else {

                    $last_due_month = $init_mont + ($fine_duemonth - 1);
                    $month_desc = "$month_arr[$init_mont] to $month_arr[$last_due_month]";
                    $this->save_transaction_details($class_fee_head_id[0]->id, $student_cat, $fine_amount, 0, $month_desc, $fine_duemonth, NULL, 0, $fee_transac_id, $user_id);
                }
            } else if ($fee_cat_id == 1) {//annual
                $this->save_transaction_details($class_fee_head_id[0]->id, $student_cat, $final_total, 0, '', 0, NULL, $fee_cat_id, $fee_transac_id, $user_id);
            } else if ($fee_cat_id == 4) {//half yearly fees
                $this->save_transaction_details($class_fee_head_id[0]->id, $student_cat, $final_total, 0, '', 0, NULL, $fee_cat_id, $fee_transac_id, $user_id);
            } else if ($fee_cat_id == 3) {//other fees
                foreach ($otherfee as $key => $value) {

                    $this->save_transaction_details($class_fee_head_id[0]->id, $student_cat, $value, 0, '', 0, $key, $fee_cat_id, $fee_transac_id, $user_id);
                    $cnt_other++;
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
                'return_url' => base_url() . 'payment/respond?transac_id=' . $fee_transac_id . '&total=' . $final_total
                . '&school_id=' . $school_id . '&pgw=' . $payment_gateway . '&max_sesion_id=' . $max_sesion_id . '&fee_action_id=' . $fee_action_id,
                'final_total' => $final_total,
                'email' => $email,
                'name' => $student[0]->first_name . ' ' . $student[0]->middle_name . ' ' . $student[0]->last_name,
                'refrence_no_order_id' => $refrence_no,
                'MID' => $school[0]->pgw_mid,
                'EncKey' => $school[0]->pgw_enckey,
                'Payment_gateway' => $school[0]->payment_gateway,
                'fee_transac_id' => $fee_transac_id,
                'school_id' => $school_id,
                'pgw' => $payment_gateway,
                'max_sesion_id' => $max_sesion_id,
                'student_id' => $student_id,
            );
//                print_r($data);





            $audit = array("action" => "Student Payment Request made with transaction id $fee_transac_id",
                "module" => "Student Fees Module",
                'datetime' => date("Y-m-d H:i:s"),
                'userid' => $this->session->userdata('user_id'));
            $this->dbconnection->insert("auditntrail", $audit);

            switch ($payment_gateway) {
                case 'WORLDLINE':
                    $this->Worldline_payment_gateway($data);
                    break;
                default:
                    $this->hdfc_payment_gateway($data);
                    break;
            }
        }
    }

    public function save_transaction_details($class_fee_head_id, $student_cat, $amount, $month_no, $month_desc, $due_month_no, $other_fee_id, $fee_cat_id, $fee_transac_id, $user_id) {
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

    public function wordline_success($response_var) {
        $data = array('response_var' => $response_var);
    }

    public function respond() {
//            print_r($_GET);
//            print_r($_POST);
        list($current_year, $month, $day) = explode('-', date('Y-m-d'));
        $maxn = '';
        $inputall = $this->input->post();
        $total = $this->input->get('total');
        $school_id = $this->input->get('school_id');
        $session_id = $this->input->get('max_sesion_id');
        $payment_gateway = $this->input->get('pgw');
        $trans_id = $this->input->get('transac_id');
        $trans_cnt_query = $this->dbconnection->select('fee_transaction_head', 'count(id) as cnt', "id=$trans_id and (response_code=0 or response_code=2)");
        $requestfee_action_id = $this->input->get('fee_action_id');
        if ($payment_gateway == 'WORLDLINE') {
            include ($_SERVER['DOCUMENT_ROOT'].'/assets/gateway/AWLMEAPI.php');
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
            $Remarks = $this->dbconnection->Get_namme('fee_transaction_action', 'id', "$requestfee_action_id", 'full_pymt_description');
            $this->db->db_select('crmfeesclub');
        } else {
            $responseCode = $this->input->post('ResponseCode');
            $response_var = array('txnRefNo' => $this->input->post('TransactionID'),
                'payment_id' => $this->input->post('PaymentID'),
                'orderId' => $this->input->post('MerchantRefNo'),
                'amount' => $total,
                'statusCode' => $responseCode,
                'statusDesc' => $this->input->post('ResponseMessage'),
                'txnReqDate' => $this->input->post('DateCreated'),
                'responseCode' => $responseCode,
                'payment_method' => $this->input->post('PaymentMethod'),
                'txnRemarks' => $this->input->post('Description'),
                'full_pgw_response_json' => json_encode($this->input->post()),
                'doubleresponse' => $trans_cnt_query[0]->cnt,
            );
            $success_page = 'feepayment/gateway/hdfc_success_page';
            $Remarks = $response_var['txnRemarks'];
            $this->db->db_select('crmfeesclub');

            $PaymentMethod = $this->dbconnection->Get_namme('payment_method_desc', 'payment_code', '' . $response_var['payment_method'] . '', 'payment_desc');
        }
        $school_code = $this->dbconnection->Get_namme("school", "id", $school_id, "school_code");
        $this->db->db_select('crmfeesclub_' . $school_id);

//                echo 'response='.$responseCode;
        if ($responseCode == 0) { //success
            if ($trans_cnt_query[0]->cnt > 0) {
                $status = 0;
                $paid_status = 0;
                $remarks_message = 'Duplicate Success has receive';
            } else {
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
            }
        } else {
            $status = 0;
            $paid_status = 0;
            if ($response_var['orderId'] == NULL || $response_var['orderId'] == '') {
                $remarks_message = 'OrderId is Null. Invalid Access';
            } else {
                $remarks_message = 'Failure Payment';
                if ($PaymentMethod != '') {
                    $remarks_message .= ' using';
                }
            }
            $receipt_no = "";
        }
//               echo 'paid_status='.$paid_status;
//                /*---------- Updating Details to Fee Payment record table(fee_transaction_head)  ---------*/
        if ($response_var['orderId'] != NULL || $response_var['orderId'] != '' || $trans_cnt_query[0]->cnt > 0) {
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
                'receipt_no' => $receipt_no,
                'date_modified' => date('Y-m-d H:i:s'),
                'modified_by' => $this->session->userdata('user_id'),
                'full_pgw_response_json' => $response_var['full_pgw_response_json'],
            );

            $this->dbconnection->update("fee_transaction_head", $data, "id=$trans_id");
        }
//                /*---------------------------------------------------------------------------------------*/
//                
//                
//                /*---------- Saving Details to Fee Payment Action table(fee_transaction_action)  ---------*/
        $this->dbconnection->insert("fee_transaction_action", array('fee_transaction_head_id' => $trans_id, 'action_description' => $remarks_message . ' ' . $PaymentMethod,
            'created_by' => $this->session->userdata('user_id'), 'full_pymt_description' => $Remarks));
//                
//                /*---------------------------------------------------------------------------------------*/
//                
//                
//                
//                
//		/*------------------------------------------------------------------------------*/
        $audit = array("action" => "Student Update Fees Status After Payment for transaction id $trans_id",
            "module" => "Student Fees Module",
            'datetime' => date("Y-m-d H:i:s"),
            'userid' => $this->session->userdata('user_id'));
        $this->dbconnection->insert("auditntrail", $audit);
//                
        $this->load->view($success_page, $response_var);
    }

    

    public function save_receipt_log($trans_id, $maxn) {
        $data1 = array(
            'recipt_no' => $maxn,
            'fee_trans_id' => $trans_id
        );
        $this->dbconnection->insert("receipt_log", $data1);
    }

    public function GatewayResponse() {
        $datat = array(
            'remarks' => $_POST,
        );
        $this->dbconnection->insert("payments", $datat);
    }

    public function send_sms($amount_val, $year_val, $school_val, $admission_val, $mon_year, $month_name, $mob_number) {
        if ($mon_year == 'month') {
            $next_year = $year_val + 1;
            $next_year = substr($next_year, -2);
            $session = $year_val . '-' . $next_year;
            $message_content = "INR $amount_val is deposited as monthly fee for the month of $month_name - $session into $school_val account against student admission no $admission_val . We welcome you in FEESCLUB family. Thanks!";
        } else {
            $blank = " ";
            $message_content = "INR $amount_val is deposited as annual fee for the year $year_val into $school_val $blank account against student admission no $admission_val.We welcome you in FEESCLUB family. Thanks!";
        }

        $username = "Jagan@mildtrix.com";
        $password = "Inspiron6411";
        $approved_senderid = "FECLUB";
        $mob_number = "$mob_number";
        $message = $message_content;
        $enc_msg = rawurlencode($message); // Encoded message
        $fullapiurl = "http://smsc.biz/httpapi/send?username=$username&password=$password&sender_id=$approved_senderid&route=T&phonenumber=$mob_number&message=$enc_msg";
        $ch = curl_init($fullapiurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
    }

    public function change_password() {
        $user_id = $this->session->userdata('user_id');
        $password = $_POST['change_password'];

        $salt = $this->generateRandomString();
        $password = md5($password . $salt);
        $data = array(
            'password' => $password,
            'salt' => $salt,
            'encrypt_id' => 2,
            'change_password' => 1,
            'last_date_modified' => date('Y-m-d H:i:s'),
            'last_modified_by' => $this->session->userdata('user_id')
        );
        $user = $this->dbconnection->update('user', $data, 'id =' . $user_id);

//Audit Trail
        $audit = array("action" => 'Change User Password',
            "module" => "Student Module",
            'datetime' => date("Y-m-d H:i:s"),
            'userid' => $this->session->userdata('user_id'),
            'student_id' => $user_id,
            'page' => 'Student',
            'remarks' => 'Change Password'
        );
        $this->dbconnection->insert("auditntrail", $audit);

        header("Location: " . site_url("student"));
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
        $student_id = $this->input->post('stud_id');
        $month_id = $this->input->post('month_id');
        $student = $this->dbconnection->select('student', '*', 'id = ' . $student_id);
        $student_cat = $student[0]->stud_category;
        $user_id = $this->session->userdata('user_id');
        $student_cat = $student[0]->stud_category;
        $user = $this->dbconnection->select('user', '*', 'id = ' . $user_id);
        $school_id = $this->session->userdata('school_id');
        $max_year = $this->dbconnection->select('accedemic_session', 'max(id) as max_year');
        $year = $max_year[0]->max_year;

        $max_year = $this->dbconnection->select('class_fee_head', 'max(year) as max_year');
        $fee_session_year = $max_year[0]->max_year;

        $monthly_fee_paid = $this->dbconnection->select('fee_transaction_det', 'count(month_no) as paid', "fee_trans_head_id in( select id from fee_transaction_head where year=$year and student_id=$student_id and paid_status=1 and response_code=0) and fee_cat_id=2");
        $student_class_id = $student[0]->class_id;
        $monthly_fee = $this->db->query('SELECT fee_amount,(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name FROM class_fee_det where fee_cat=2 and stud_cat=' . $student_cat . '  and class_fee_head_id in(select id from class_fee_head where year=' . $fee_session_year . ' and  (from_class_id <=' . $student_class_id . ' and  to_class_id >=' . $student_class_id . ' and course=' . $student[0]->course_id . ')) and status=1');

        $total_paid_month = $monthly_fee_paid[0]->paid;
        $total_check_month = count($month_id);
        $total_pay_month = $total_check_month - $total_paid_month;
        list($year, $month, $day) = explode('-', date('Y-m-d'));

//---------------- Applying Fine if any -------------------------------//
        $count = 0;
        $pm = $total_paid_month + 1;
        $l = $total_pay_month;
        while ($l > 0) {
            if ($pm < ($month - 3)) {

                $count++;
            }
            $l--;
            $pm++;
        }
        $due_month = $count;

        $fine_amount = 0;
        $fine_apply_status = 0;
        if ($day < $this->school[0]->start_pay_date || $day > $this->school[0]->last_pay_date) {

            if ($this->school[0]->transc_freeze_status == 1) {

                $disable_trans = 1;
            }
            if ($due_month > 0) {

                $fine_apply_status = 1;
            }
        } else {

            if ($due_month > 0) {

                $fine_apply_status = 1;
            }
        }



        if ($fine_apply_status == 1) {

            $quer_fine = $this->dbconnection->select("class_fee_det", "fee_amount", 'class_fee_head_id in(select id from class_fee_head  where year=' . $fee_session_year . ' '
                    . 'and  (from_class_id <=' . $student_class_id . ' and  to_class_id >=' . $student_class_id . ' '
                    . 'and course=' . $student[0]->course_id . ')) and status=1 and stud_cat=0 and fee_cat=0 and '
                    . ' (( fine_condition=1 and no_of_months=' . $due_month . ') or ( fine_condition=2 and no_of_months<' . $due_month . ') '
                    . ' or ( fine_condition=3 and no_of_months <= ' . $due_month . ') '
                    . ' or ( fine_condition=4 and no_of_months > ' . $due_month . ') '
                    . ' or ( fine_condition=5 and no_of_months >= ' . $due_month . '))');

            if (count($quer_fine) > 0) {
                $fine_amount = $quer_fine[0]->fee_amount;
            }
        }
//-------------------------------- //

        $table_html = '';

        $total_fee = 0;
        foreach ($monthly_fee->result() as $obj) {
            $total_fee = $total_fee + $obj->fee_amount * $total_pay_month;
            $table_html .= '<tr>';
            $table_html .= '<td>' . $obj->fee_name . '</td>';
            $table_html .= '<td>' . $obj->fee_amount * $total_pay_month . ' </td>';
            $table_html .= '</tr>';
        }
        if ($student[0]->transport_amt != 0) {
            $total_fee = $total_fee + $student[0]->transport_amt * $total_pay_month;
            $table_html .= '<tr>';
            $table_html .= '<td>Transport Fee</td>';
            $table_html .= '<td><input type="text" readonly="true" style="border: 0px;width:65px;background:inherit" name="trans_fee_amt" value="' . $student[0]->transport_amt * $total_pay_month . '"></td>';
            $table_html .= '</tr>';
        }
        if ($fine_apply_status == 1) {
            $total_fee = $total_fee + $fine_amount;
            $table_html .= '<tr>';
            $table_html .= '<td>Fine (for ' . $due_month . ' Month)</td>';
            $table_html .= '<input type="hidden" name="fine_due_month" value=' . $due_month . '>';
            $table_html .= '<td><input type="text" readonly="true" style="border: 0px;width:65px;background:inherit" name="fine_amt" value="' . $fine_amount . '"></td>';
            $table_html .= '</tr>';
        }

        $table_html .= '<tr style="font-size: 17px;font-weight: bold;">';
        $table_html .= '<td>Total</td>';
        $table_html .= '<td><input type="text" readonly="true" style="border: 0px;width:65px;background:inherit" name="total_m" value="' . $total_fee . '"></td>';
        $table_html .= '</tr>';

        echo $table_html . '|' . $total_fee . '|' . $total_paid_month;
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
        $pdf->Image('assets/img/' . $img, 20, 20, 30, 30);

        $pdf->SetFont('Arial', 'B', 20);

        $pdf->SetXY(55, 23);
        $pdf->Write(0, $data['school_name']);
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY(60, 30);
        $pdf->Write(0, strtoupper($data['school_address']));

        $pdf->SetXY(60, 35);
        $pdf->Write(0, 'MAIL : ' . $data['email'] . ' | TEL : ' . $data['phone']);
        $pdf->SetFont('Arial', '', 10);

        $pdf->SetXY(60, 78.5);
        $pdf->Write(0, $data['transaction_id']);
        $pdf->SetXY(140, 77.7);
        $pdf->Write(0, $data['date']);

        $pdf->SetXY(60, 88);
        $pdf->Write(0, $data['receipt_no']);

        $pdf->SetXY(60, 98);
        $pdf->Write(0, $data['admission_no']);

        $pdf->SetXY(60, 107.8);
        $pdf->Write(0, $data['name']);

        $pdf->SetXY(60, 116.8);
        $pdf->Write(0, $data['class']);

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
            $top_height = $top_height + 6;
        }
        if ($data['transport_fee'] > 0) {
            $total = $total + $data['transport_fee'];
            $pdf->SetXY(15, $top_height);
            $pdf->Write(0, 'Transport Fees');
            $pdf->SetXY(108, $top_height);
            $pdf->Write(0, $data['transport_fee']);
            $top_height = $top_height + 6;
        }
        foreach ($data['annual_fee'] as $obj) {
            $total = $total + $obj->fee_amount;
            $pdf->SetXY(15, $top_height);
            $pdf->Write(0, $obj->fee_name);

            $pdf->SetXY(108, $top_height);
            $pdf->Write(0, $obj->fee_amount);
            $top_height = $top_height + 6;
        }
        foreach ($data['other_fee'] as $obj) {
            $total = $total + $obj->fee_amount;
            $pdf->SetXY(15, $top_height);
            $pdf->Write(0, $obj->fee_name);

            $pdf->SetXY(108, $top_height);
            $pdf->Write(0, $obj->fee_amount);
            $top_height = $top_height + 6;
        }
        foreach ($data['fine_fee'] as $obj) {
            $total = $total + $obj->fee_amount;
            $pdf->SetXY(15, $top_height);
            $pdf->Write(0, $obj->fee_name);

            $pdf->SetXY(108, $top_height);
            $pdf->Write(0, $obj->fee_amount);
            $top_height = $top_height + 6;
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

        $query_transaction = $this->db->query("select f1.*,f2.class_fee_head_id,group_concat(distinct(f2.fee_cat_id)) as fee,count(case when f2.month_no<>0 then f2.month_no end) as m,min(case when f2.month_no<>0 then f2.month_no end) as from_month,max(f2.due_month_no) as d from fee_transaction_head f1, fee_transaction_det f2 where f1.id=$fee_transaction_id and f1.response_message=0 and f1.id=f2.fee_trans_head_id group by f1.id");
        $q = $query_transaction->result();
        $school_id = $this->session->userdata('school_id');
        $school = $this->school;
        $student = $this->dbconnection->select('student', 'id,course_id,transport_amt,'
                . ' class_id,(select class_name from class where id=student.class_id) as class_name,'
                . ' concat(first_name," ",middle_name," ",last_name) as name,admission_no,'
                . ' stud_category,'
                . ' (select c.cat_name from category c where c.id=stud_category) as cat_name,'
                . '  section_id,(select s.sec_name from section s where s.id=section_id) as sec_name,'
                . ' email_address, phone, dob, status, date_created, created_by,last_date_modified, last_modified_by', 'id = ' . $q[0]->student_id);



        $transaction_id = $q[0]->transaction_id;
        $payment_date = $q[0]->payment_date;
        $receipt_no = $q[0]->receipt_no;

        $fee_type_name = 'Fee Paid';
        $transport_fee = 0;
        $monthly_fee = array();
        $annual_fee = array();
        $other_fee = array();
        $fine_fee = array();
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
                $monthly_fee = $this->db->query("SELECT (" . $q[0]->m . "*fee_amount) as fee_amount,(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name FROM class_fee_det  where fee_cat=2 and stud_cat=" . $student[0]->stud_category . " and class_fee_head_id=" . $q[0]->class_fee_head_id . " and status=1");
                $monthly_fee = $monthly_fee->result();
            } else if ($value == 1) {
                $str .= ' Annual Fees,';
                $annual_fee = $this->db->query("SELECT fee_amount,(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name FROM class_fee_det  where fee_cat=1 and stud_cat=" . $student[0]->stud_category . " and class_fee_head_id=" . $q[0]->class_fee_head_id . " and status=1");
                $annual_fee = $annual_fee->result();
            } else if ($value == 3) {
                $str .= ' Other Fees,';
                $other_fee = $this->db->query("SELECT amount as fee_amount,(select fee_name from fee_master where id=other_fee_id) as fee_name FROM fee_transaction_det  where fee_cat_id=3 and fee_trans_head_id=$fee_transaction_id");
                $other_fee = $other_fee->result();
            } else if ($value == 4) {
                $str .= ' Half-Yearly Fees,';
                $half_fee = $this->db->query("SELECT amount,(select fee_name from fee_master where id=other_fee_id) as fee_name FROM fee_transaction_det  where fee_cat_id=4 and fee_trans_head_id=$fee_transaction_id");
                $half_fee = $half_fee->result();
            } else if ($value == 0) {

                if ($q[0]->d > 1) {
                    $str .= ' ' . $q[0]->d . ' Months Fine';
                } else {
                    $str .= ' ' . $q[0]->d . ' Month Fine';
                }
                $fine_fee = $this->db->query("SELECT sum(amount) as fee_amount,'Fine for " . $q[0]->d . " Months' as fee_name FROM fee_transaction_det  where fee_cat_id=0 and fee_trans_head_id=$fee_transaction_id");
                $fine_fee = $fine_fee->result();
            } else if ($value == 6) {
                $str .= ' Transport Fees,';
                $transport_fee = $q[0]->m * $student[0]->transport_amt;
            }
        }
        $str = rtrim($str, ',');

        $month_session = $str;
        $max_year1 = $this->dbconnection->select('accedemic_session', 'max(id) as max_year1');
        $fee_session_year = $max_year1[0]->max_year1;
        $session = $this->dbconnection->select('accedemic_session', '*', 'id=' . $q[0]->year);
        $accedemic_session = $session[0]->session;
//		$yearly_fee = $this->db->query('SELECT fee_amount,(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name FROM class_fee_det  where stud_cat=' . $student[0]->stud_category . ' and class_fee_head_id='.$q[0]->class_fee_head_id.' and status=1');
//		$total_amount = 0;
        $total_amt_words = $q[0]->total_amount;
        $data = array(
            'school_id' => $school_id,
            'school_name' => $school[0]->description,
            'school_address' => $school[0]->address,
            'phone' => $school[0]->phone,
            'email' => $school[0]->email,
            'transaction_id' => $transaction_id,
            'date' => date('d-m-Y', strtotime($payment_date)),
            'receipt_no' => $receipt_no,
            'admission_no' => $student[0]->admission_no,
            'name' => $student[0]->name,
            'class' => $student[0]->class_name,
            'secname' => $student[0]->sec_name,
            'cat' => $student[0]->cat_name,
            'fee_type_name' => $fee_type_name,
            'month_session' => $month_session,
            'year' => $accedemic_session,
            'monthly_fee' => $monthly_fee,
            'annual_fee' => $annual_fee,
            'other_fee' => $other_fee,
            'fine_fee' => $fine_fee,
            'student_id' => $student[0]->id,
            'fee_transaction_id' => $fee_transaction_id,
            'transport_fee' => $transport_fee,
            'total_amt_words' => $this->convert_number_to_words($total_amt_words),
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
            trigger_error(
                    'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX, E_USER_WARNING
            );
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

}
