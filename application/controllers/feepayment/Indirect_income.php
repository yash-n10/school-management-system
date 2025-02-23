<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Indirect_income extends CI_Controller {
    
    public function __construct() {
        // error_reporting(-1);
        // ini_set('display_errors', 1);
        // $this->db->db_debug=TRUE;
        parent::__construct();
        if (empty($this->session->userdata('user_id')) || $this->session->userdata('user_group_id') == 4) {
            redirect('/login');
        }
       	$this->id = $this->session->userdata('school_id');
        $this->school_desc = $this->dbconnection->select("school", "*", "id=" . $this->id . " and status = 1");
        if ($this->id != 0)
            $this->db->db_select('crmfeesclub_' . $this->id);
        $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y' and active='Y'");
        $fetch_startyr = isset($this->academic_session[0]->start_date) ? explode('-', $this->academic_session[0]->start_date) : array('0');
        $this->session_start_yr = reset($fetch_startyr);
        $fetch_endyr = isset($this->academic_session[0]->end_date) ? explode('-', $this->academic_session[0]->end_date) : array('0');
        $this->session_end_yr = reset($fetch_endyr);

    }
    
    
    public function index() {
        // error_reporting(-1);
        // ini_set('display_errors', 1);
        // $this->db->db_debug=TRUE;
        $this->data['page_title'] = 'Indirect Income';
        $this->data['section'] = 'feepayment';
        $this->data['page_name'] = 'indirect_income';
        $this->data['customview'] = '';
        $this->data['fee_type'] = $this->dbconnection->select("fee_master","*","status='1' and fee_cat_id=8");
        $this->data['admission_no'] = $this->dbconnection->select("student","*","");
        $this->data['bank_list'] = $this->dbconnection->select("crmfeesclub.bank", "bank_code", "");
        $this->data['collection_centers'] = $this->dbconnection->select("collection_center", "id,collection_code,collection_desc", "status='Y'");

        $this->data['fetch_trans_data'] = $this->db->query("select f1.id, f1.total_amount,f1.payment_date,f1.bill_name,f1.contact,f1.payment_method,f1.response_message,f1.remarks,f2.other_fee_id,(select fee_name from fee_master where id=f2.other_fee_id) feename from fee_transaction_head f1,fee_transaction_det f2 where f1.id=f2.fee_trans_head_id and f1.status=1 and f1.paid_status=1 and f2.fee_cat_id=8 and f1.payment_date>=DATE_FORMAT('2020-07-20 00:00:00', '%Y-%m-%d 00:00:00') group by f1.id")->result();

        // $fetch_instant_fees_det = $this->dbconnection->select("fee_master","id,fee_name,");
        $this->load->view('index', $this->data); 
    }


        public function save_offln_payment_indirect()
        {
		// error_reporting(-1);
  //       ini_set('display_errors', 1);
  //       $this->db->db_debug=TRUE;
        $no_of_month = 0;
        $current_year = $this->academic_session[0]->fin_year;

        $school_code = $this->school_desc[0]->school_code;

        $inputall = $this->input->post();
        $payment_date = $inputall['payment_date'];
        $bill_name = $inputall['bill_name'];
        $bill_contact = $inputall['bill_contact'];
        $remarks = $inputall['remarks'];
        $student_id = $inputall['admission_no'];
         $final_total = str_replace("INR", "", $inputall['tot_amount']);
        if (!empty($inputall['fee_head']) && $final_total != 0) 
        {
            if ($inputall['automatic_receipt'] == 'YES') {

                $receipt_log = $this->dbconnection->select('receipt_log', 'max(recipt_no) as rec');

                $number = strlen($receipt_log[0]->rec);

                $str = '';
                for ($i = 1; $i <= (6 - $number); $i++) {
                    $str .= '0';                                                      
                }

                $maxn = $str . ($receipt_log[0]->rec + 1);
                $receipt_no = 'OFLN' . $current_year . $school_code . $maxn;
            } else {
                $receipt_no = $inputall['receipt_no'];
                $maxn = '';
            }
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
            $fth=$this->dbconnection->insert("fee_transaction_head", array('student_id' =>$student_id, 'year' => $current_year,
            'total_amount' => $final_total, 'discount_amount' => '0', 'paid_by' => $this->session->userdata('user_id'), 'payment_date' => date('Y-m-d H:i:s', strtotime($payment_date)),'remarks' => $remarks, 'mode' => $inputall['mode_payment'],
            'cheque_no'=>$inputall['cheque_no'],'cheque_date'=>$inputall['cheque_date'],'cheque_status'=>$inputall['cheque_status'],'pos_no'=>$inputall['pos_no'],
            'collection_centre' => $inputall['collection_center'], 'response_code' => 0, 'payment_method' => $inputall['mode_payment'],
            'response_message' => 'Payment Successful', 'paid_status' => $paid_status,'date_created'=>date('Y-m-d H:i:s'),
            'receipt_no' => $receipt_no, 'bank_name' => '','bill_name'=>$bill_name,'contact'=>$bill_contact, 'created_by' => $this->session->userdata('user_id')));
            $fee_transac_id = $this->dbconnection->get_last_id();

            // print_r($fth);
            // die();

            if ($inputall['automatic_receipt'] == 'YES') {

                $data1 = array(
                    'fee_trans_id' => $fee_transac_id,
                    'recipt_no' => $maxn
                );
                $this->dbconnection->insert("receipt_log", $data1);
            }
            foreach ($inputall['fee_head'] as $selected) {
                 if ($selected == 8) {

                    if (!empty($inputall['instantfee_chk'])) {
                        foreach ($inputall['instantfee_chk'] as $k1=>$instselected) {
                            foreach ($instselected as $k2=>$v2) {
                                // echo "<pre>";
                                // print_r($v2);
                            $this->dbconnection->insert("fee_transaction_det", array('amount' => $v2, 'fee_cat_id' => $selected,
                                'other_fee_id' => $k2, 'fee_trans_head_id' => $fee_transac_id,
                                'class_fee_head_id' => '', 'stud_category' => '', 'created_by' => $this->session->userdata('user_id')));
                            }
                        }
                    }
                }else {
                    echo 'nooooo';
                }
            }
             $d['msg']= 'Successfully Saved';
            $d['fee_trans_id']= $fee_transac_id;
        } else {
            $d['msg']= 'Oops, No Fees has been selected Or Total Amount is Zero !!!';
            $d['fee_trans_id']= 0;
        }
        
        echo json_encode($d);
    }

    public function getadmdata() 
    {

        $stid = $this->input->post('stid');

        $fetch_stud = $this->dbconnection->select("student", "id,admission_no,transport_amt,CONCAT(first_name,' ',middle_name,' ',last_name) as name,course_id,father_name,dob,stud_category,(select cat_name from category where id=stud_category) as category_name,phone,email_address,class_id,section_id,student_academicyear_id,(select session from accedemic_session where id=student_academicyear_id) as session,start_fee_month,student_type", "id='$stid'");

            $class = !empty($fetch_stud) ? $fetch_stud[0]->class_id : 0;
            $section = !empty($fetch_stud) ? $fetch_stud[0]->section_id : 0;
            $course_id = !empty($fetch_stud) ? $fetch_stud[0]->course_id : 0;
            $stud_category = !empty($fetch_stud) ? $fetch_stud[0]->stud_category : 0;
            $stud_id = $fetch_stud[0]->id;
            $admsn = $fetch_stud[0]->admission_no;
            $stud_acedemic_session_id = !empty($fetch_stud) ? $fetch_stud[0]->student_academicyear_id : 0;
            $stud_acedemic_session = !empty($fetch_stud) ? $fetch_stud[0]->session : 0;
            $start_fee_month=$fetch_stud[0]->start_fee_month;

        $data = array(
            'student_id' => $stid,
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
            );
        echo json_encode($data);

    }
}
