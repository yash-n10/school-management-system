<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_pdf_indirect extends CI_Controller {

    public function __construct() {
        parent::__construct();
  //               error_reporting(-1);
		// ini_set('display_errors', 1);

// Access Control
        switch ($this->session->userdata('login_type')) {
//                    case 'appadmin':
//                        $this->right_access = 'CRUD';
//                        break;
            case 'admin':
                $this->right_access = 'CRUD';
                break;
            case 'office':
                $this->right_access = '-R--';
                break;
            case 'school':
                $this->right_access = '-R--';
                break;
            case 'principal':
                $this->right_access = 'CRUD';
                break;
            default:
                $this->right_access = '----';
                redirect(base_url(), 'refresh');
        }

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

//            $this->month=$this->session->userdata('act_year_from');
        if ($this->id != 0) {
            $this->db->db_select('crmfeesclub_' . $this->id);
//                $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year", "active='Y'");
        }

        $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y' and active='Y'");
        $fetch_startyr = isset($this->academic_session[0]->start_date) ? explode('-', $this->academic_session[0]->start_date) : array('0');
        $this->session_start_yr = reset($fetch_startyr);

        $this->page_title = 'Fee Collect';
        $this->section = 'feepayment/collection';
        $this->page_name = 'offline_payment_upload';
        $this->customview = '';
    }

    /* --------------- Payment ------------ */

    public function payment_pdf_indirect() {
        $this->load->library('numbertowords');

        $month = array(1 => "April", 2 => "May", 3 => "June", 4 => "July", 5 => "August", 6 => "September", 7 => "October", 8 => "Novemeber", 9 => "December", 10 => "January", 11 => "February", 12 => "March");

        $fee_transaction_id = $this->uri->segment(5);
        $query_transaction = $this->db->query("select f1.id,f1.student_id,group_concat(distinct(f2.fee_cat_id)) as fee,f1.receipt_no, f1.total_amount,f1.payment_date,f1.payment_method,f1.response_message,f1.remarks,f1.bill_name,f1.contact,f2.other_fee_id,(select fee_name from fee_master where id=f2.other_fee_id) feename from fee_transaction_head f1,fee_transaction_det f2 where f1.id=f2.fee_trans_head_id and f1.status=1 and f1.paid_status=1 and f2.fee_cat_id=8 and f1.id=$fee_transaction_id");
        $q = $query_transaction->result();

        $stud_id=$q[0]->student_id;
        $student = $this->dbconnection->select('student', 'id,roll,course_id,transport_amt,'
                . ' class_id,(select class_name from class where id=student.class_id) as class_name,'
                . ' concat(first_name," ",middle_name," ",last_name) as name,admission_no,'
                . ' stud_category,'
                . ' (select c.cat_name from category c where c.id=stud_category) as cat_name,'
                . '  section_id,(select s.sec_name from section s where s.id=section_id) as sec_name,father_name,'
                . ' email_address, phone, dob, status, date_created, created_by,last_date_modified, last_modified_by', 'id = ' . $stud_id);

        $school_id = $this->session->userdata('school_id');

         $fe_desc = explode(',', $q[0]->fee);
        $str = '';
        $monthly = 0;
        $annual = 0;
        $half_yearly = 0;
        $other = 0;
        $fine = 0;
        foreach ($fe_desc as $index => $value) {
              if ($value == 8) {
                $str .= ' Instant/Misc. Fees,';
                $instant_fee = $this->db->query("SELECT amount as fee_amount,(select fee_name from fee_master where id=other_fee_id) as fee_name FROM fee_transaction_det  where fee_cat_id=8 and fee_trans_head_id=$fee_transaction_id")->result();
               
            } 
        }


        $school = $this->school_desc;
        $logo = 'assets/img/' . $this->session->userdata('school_id') . '.JPG';
        $inv_view = 'payment_dompdf_indirect';
        $size = 'A4';
        $orientation = 'landscape';
        $array = array('logo' => $logo, 'school_desc' => $school, 'q' => $q,'student'=>$student,'instant_fee'=>$instant_fee);
        $this->load->view('feepayment/collection/' . $inv_view, $array);
        $html = $this->output->get_output();
        $this->load->library('pdf');
        $this->dompdf->load_html($html);
        $this->dompdf->set_paper($size, $orientation);
        $this->dompdf->render();
        $this->dompdf->stream("payment_pdf.pdf", array("Attachment" => FALSE));
    }
    
    
    

}
