<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_pdf extends CI_Controller {

    public function __construct() {
        parent::__construct();
                
		error_reporting(-1);
		ini_set('display_errors', 1);

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

    public function payment_pdf() {
    	
		error_reporting(-1);
		ini_set('display_errors', 1);
		
		$this->db->debug=TRUE;
        $this->load->library('numbertowords');

        $month = array(1 => "April", 2 => "May", 3 => "June", 4 => "July", 5 => "August", 6 => "September", 7 => "October", 8 => "Novemeber", 9 => "December", 10 => "January", 11 => "February", 12 => "March");

        $fee_transaction_id = $this->uri->segment(5);
        $query_transaction = $this->db->query("select f1.*,f2.class_fee_head_id,group_concat(distinct(f2.fee_cat_id)) as fee,count(case when f2.month_no<>0 and f2.fee_cat_id in (2,5) then f2.month_no end) as m,min(case when f2.month_no<>0 and f2.fee_cat_id in (2,5) then f2.month_no end) as from_month,max(f2.due_month_no) as d,f2.stud_category as fee_stud_cat from fee_transaction_head f1, fee_transaction_det f2 where f1.id=$fee_transaction_id and f1.response_message=0 and f1.status=1 and f1.id=f2.fee_trans_head_id group by f1.id");
        $q = $query_transaction->result();

        $ff=$this->db->query("select f1.*,f2.class_fee_head_id,group_concat(distinct(f2.fee_cat_id)) as fee,f2.amount as ff_nn_amt,f2.stud_category as fee_stud_cat from fee_transaction_head f1, fee_transaction_det f2 where f1.id=$fee_transaction_id and f1.response_message=0 and f1.status=1 and f1.id=f2.fee_trans_head_id and f2.fee_cat_id=0 group by f1.id")->result();

       

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
        $readmsnfine_fee = array();
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
            if ($value == 2 ) {
                if ($q[0]->m > 1) {

                    $month_var = $q[0]->from_month + $q[0]->m - 1;
                    $str .= $month[$q[0]->from_month] . "-" . $month[$month_var] . " Fees,";
                } else {
                    $str .= $month[$q[0]->from_month] . " Fees,";
                }

//Amitabh 17-Oct-2020: Added code to get correct patment details
			// --Checking if *class_fee_det* and *fee_transaction_det* have same amount OR not
                $sum_class_fee_chk = $this->db->query("SELECT (" . $q[0]->m . " * fee_amount) AS fee_amt,"
													. " (SELECT fee_name FROM fee_master WHERE id=class_fee_det.fee_id) AS fee_name "
													. " 	FROM class_fee_det "
													. " 	WHERE fee_cat=2 AND stud_cat=" . $student[0]->stud_category . " AND "
													. " 	class_fee_head_id=" . $q[0]->class_fee_head_id . " AND status=1");

				$sum_class_chk = 0; 
				foreach($sum_class_fee_chk->result() as $row) {
					$sum_class_chk = $sum_class_chk + $row->fee_amt;
				}

				$sum_fee_trans_det_chk = $this->db->query("SELECT ftd.amount as tot_amt"
													. " FROM fee_transaction_det ftd, fee_transaction_head fth"
													. " WHERE fth.id = ftd.fee_trans_head_id "
													. " AND ftd.fee_trans_head_id =" . $fee_transaction_id . " AND ftd.fee_cat_id=" . $value);

				$sum_trans_chk = 0; 
				foreach($sum_fee_trans_det_chk->result() as $row_1) {
					$sum_trans_chk = $sum_trans_chk + $row_1->tot_amt;
				}
			
			//-- Changing query if there is *MISMATCH* in TOTAL OR *NO MISMATCH*
				$sqlstr = '';
				// echo "<pre>";print_r($q[0]);die();
				// print_r($sum_class_chk);echo"<br>";print_r($sum_trans_chk);die();
				if ($sum_class_chk == $sum_trans_chk) {
					// -- Removing **Yearly.../Exam...Fee** if *Start Month* is not 1 (April)
					$sqlstr = "SELECT (" . $q[0]->m . "*fee_amount) AS fee_amount,"
										. " (SELECT fee_name from fee_master where id=class_fee_det.fee_id) AS fee_name "
										. " FROM class_fee_det "
										. " WHERE fee_cat = 2 AND stud_cat = " . $student[0]->stud_category . " AND "
										. " class_fee_head_id = " . $q[0]->class_fee_head_id . " AND status = 1";
				} else {
					$sqlstr = "SELECT DISTINCT (" . $q[0]->m . " * fee_amount) AS fee_amount, "
										. " (SELECT fee_name from fee_master WHERE id = class_fee_det.fee_id) AS fee_name "
										. " FROM class_fee_det "
										. " WHERE fee_cat = 2 AND stud_cat = " . $student[0]->stud_category . " AND "
										. " class_fee_head_id = " . $q[0]->class_fee_head_id . " AND status = 0 AND fee_amount <> 0";
					$sum_class_fee_chk1 = $this->db->query($sqlstr);
					$sum_class_chk1 = 0; 
					foreach($sum_class_fee_chk1->result() as $row) {
						$sum_class_chk1 = $sum_class_chk1 + $row->fee_amount;
					}
					
					if ($sum_class_chk1 <> $sum_trans_chk)	

						$sqlstr = "SELECT DISTINCT (" . $q[0]->m . " * fee_amount) AS fee_amount, "
										. " (SELECT fee_name from fee_master where id=class_fee_det.fee_id) AS fee_name "
										. " FROM class_fee_det "
										. " WHERE fee_cat = 2 AND stud_cat = " . $student[0]->stud_category . " AND "
										. " class_fee_head_id = " . $q[0]->class_fee_head_id . " AND status = 0 AND fee_amount <> 0 "
										. " AND class_fee_det.fee_id not in (2,3)";
				} 
//Amit :: Code ends here 

               // $monthly_fee = $this->db->query("SELECT (" . $q[0]->m . "*fee_amount) as fee_amount,(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name FROM class_fee_det  where fee_cat=2 and stud_cat=" . $q[0]->fee_stud_cat . " and class_fee_head_id=" . $q[0]->class_fee_head_id . " and status=1");
                $monthly_fee = $this->db->query($sqlstr);
				$monthly_fee = $monthly_fee->result();

            } else if ($value == 5) {
               if ($q[0]->m > 1) {

                    $month_var = $q[0]->from_month + $q[0]->m - 1;
                    $str .= $month[$q[0]->from_month] . "-" . $month[$month_var] . " Fees,";
                } else {
                    $str .= $month[$q[0]->from_month] . " Fees,";
                }
                $monthly_fee = $this->db->query("SELECT round(" . $q[0]->m . "*(fee_amount/3)) as fee_amount,(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name,fee_id FROM class_fee_det  where fee_cat=5 and stud_cat=" . $q[0]->fee_stud_cat . " and class_fee_head_id=" . $q[0]->class_fee_head_id . " and status=1");
                $monthly_fee = $monthly_fee->result();

            }  else if ($value == 1) {
                $str .= ' Annual Fees,';
                $annual_fee = $this->db->query("SELECT fee_amount,(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name FROM class_fee_det  where fee_cat=1 and stud_cat=" . $q[0]->fee_stud_cat . " and class_fee_head_id=" . $q[0]->class_fee_head_id . " and status=1");
                $annual_fee = $annual_fee->result();

            } else if ($value == 9) {
                $str .= ' Onetime Fees,';
                $one_fee = $this->db->query("SELECT fee_amount,(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name FROM class_fee_det  where fee_cat in (9,10) and stud_cat=" . $q[0]->fee_stud_cat . " and class_fee_head_id=" . $q[0]->class_fee_head_id . " and status=1");
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
            	 $ff_amttt=$ff[0]->ff_nn_amt;
                if($ff_amttt>0)
                {
                    if ($q[0]->d > 1) {
						$str .= ' ' . $q[0]->d . ' Months Fine';
					} else {
						$str .= ' ' . $q[0]->d . ' Month Fine';
					}
                }

                $fine_fee = $this->db->query("SELECT sum(amount) as fee_amount,'Fine for " . $q[0]->d . " Months' as fee_name FROM fee_transaction_det  where fee_cat_id=0 and fee_trans_head_id=$fee_transaction_id");
                $fine_fee = $fine_fee->result();

            } else if ($value == 11) {
//                $str .= ' Re-Admission-Fine,';
                $readmsnfine_fee = $this->db->query("SELECT amount as fee_amount,'Re-Admission-Fine' as fee_name FROM fee_transaction_det  where fee_cat_id=11 and fee_trans_head_id=$fee_transaction_id");
                $readmsnfine_fee = $readmsnfine_fee->result();
                
            } else if ($value == 6) {
                $transport_fee = $this->db->query("SELECT sum(amount) as fee_amount FROM fee_transaction_det  where fee_cat_id=6 and fee_trans_head_id=$fee_transaction_id")->result();
                $str .= ' Transport Fees,';
//                $transport_fee = $q[0]->m * $student[0]->transport_amt;
                $transport_fee = $transport_fee[0]->fee_amount;

            } else if ($value == 7) {
                if($this->session->userdata('school_id')!=35)
                {
                    $str .= ' Fine Waiver,';
					$discount = $q[0]->discount_amount;
                }
                
            }
        }
        $str = rtrim($str, ',');

        $college_id = $this->session->userdata('school_id');
        /* 		$reggistration_no = ;
          $college_id = $this->id; */
        /* $data = $this->dbconnection->select('collegefclb.college', '*', 'id=' . $college_id); */
        $logo = 'assets/img/' . $this->session->userdata('school_id') . '.JPG';
        /*        $pdf_id = $data[0]->result_pdf_id;
          $data_inv = $this->dbconnection->select('collegefclb.result_pdf', '*', 'id=' . $pdf_id); */
        $inv_view = 'payment_dompdf';
        $size = 'A4';
        /*        $invoice_demo_no = $data_inv[0]->result_pdf_no; */
        $orientation = 'landscape';
        /* $reg_no = $this->uri->segment('4');//$reggistration_no; */
        /* $this->db->db_select('crmfeesclub_'.$this->id);
         */
        /* $stud=$this->Mymodel->get_student_byreg($reg_no);
         */
        $array = array('logo' => $logo, 'school_desc' => $school, 'q' => $q, 'student' => $student, 'fee_paid' => $str, 'monthly_fee' => $monthly_fee, 'transport_fee' => $transport_fee, 'annual_fee' => $annual_fee, 'other_fee' => $other_fee, 'fine_fee' => $fine_fee, 'discount' => $discount, 'half_fee' => $half_fee,'instant_fee'=>$instant_fee,'readmsnfine_fee'=>$readmsnfine_fee,'one_fee'=>$one_fee);
        $this->load->view('feepayment/collection/' . $inv_view, $array);
        $html = $this->output->get_output();
        $this->load->library('pdf');
        $this->dompdf->load_html($html);
        $this->dompdf->set_paper($size, $orientation);
        $this->dompdf->render();
        $this->dompdf->stream("payment_pdf.pdf", array("Attachment" => FALSE));
    }
    
    
    public function dot_matrix() {
        $month = array(1 => "April", 2 => "May", 3 => "June", 4 => "July", 5 => "August", 6 => "September", 7 => "October", 8 => "Novemeber", 9 => "December", 10 => "January", 11 => "February", 12 => "March");

        $fee_transaction_id = $this->uri->segment(5);
        $query_transaction = $this->db->query("select f1.*,f2.class_fee_head_id,group_concat(distinct(f2.fee_cat_id)) as fee,count(case when f2.month_no<>0 and f2.fee_cat_id=2 then f2.month_no end) as m,min(case when f2.month_no<>0 and f2.fee_cat_id=2 then f2.month_no end) as from_month,max(f2.due_month_no) as d from fee_transaction_head f1, fee_transaction_det f2 where f1.id=$fee_transaction_id and f1.response_message=0 and f1.status=1 and f1.id=f2.fee_trans_head_id group by f1.id");
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

//Amitabh 16-Oct-2020: Added code to get correct patment details
			// --Checking if *class_fee_det* and *fee_transaction_det* have same amount OR not
                $sum_class_fee_chk = $this->db->query("SELECT (" . $q[0]->m . " * fee_amount) AS fee_amt,"
													. " (SELECT fee_name FROM fee_master WHERE id=class_fee_det.fee_id) AS fee_name "
													. " 	FROM class_fee_det "
													. " 	WHERE fee_cat=2 AND stud_cat=" . $student[0]->stud_category . " AND "
													. " 	class_fee_head_id=" . $q[0]->class_fee_head_id . " AND status=1");

				$sum_class_chk = 0; 
				foreach($sum_class_fee_chk->result() as $row) {
					$sum_class_chk = $sum_class_chk + $row->fee_amt;
				}

				$sum_fee_trans_det_chk = $this->db->query("SELECT ftd.amount as tot_amt"
													. " FROM fee_transaction_det ftd, fee_transaction_head fth"
													. " WHERE fth.id = ftd.fee_trans_head_id "
													. " AND ftd.fee_trans_head_id =" . $fee_transaction_id . " AND ftd.fee_cat_id=" . $value);

				$sum_trans_chk = 0; 
				foreach($sum_fee_trans_det_chk->result() as $row_1) {
					$sum_trans_chk = $sum_trans_chk + $row_1->tot_amt;
				}
			
			//-- Changing query if there is *MISMATCH* in TOTAL OR *NO MISMATCH*
				$sqlstr = '';
				if ($sum_class_chk == $sum_trans_chk) {
					// -- Removing **Yearly.../Exam...Fee** if *Start Month* is not 1 (April)
					$sqlstr = "SELECT (" . $q[0]->m . "*fee_amount) AS fee_amount,"
										. " (SELECT fee_name from fee_master where id=class_fee_det.fee_id) AS fee_name "
										. " FROM class_fee_det "
										. " WHERE fee_cat = 2 AND stud_cat = " . $student[0]->stud_category . " AND "
										. " class_fee_head_id = " . $q[0]->class_fee_head_id . " AND status = 1";
				} else {
					$sqlstr = "SELECT DISTINCT (" . $q[0]->m . " * fee_amount) AS fee_amount, "
										. " (SELECT fee_name from fee_master WHERE id = class_fee_det.fee_id) AS fee_name "
										. " FROM class_fee_det "
										. " WHERE fee_cat = 2 AND stud_cat = " . $student[0]->stud_category . " AND "
										. " class_fee_head_id = " . $q[0]->class_fee_head_id . " AND status = 0 AND fee_amount <> 0";
					$sum_class_fee_chk1 = $this->db->query($sqlstr);
					$sum_class_chk1 = 0; 
					foreach($sum_class_fee_chk1->result() as $row) {
						$sum_class_chk1 = $sum_class_chk1 + $row->fee_amount;
					}
					
					if ($sum_class_chk1 <> $sum_trans_chk)	
						$sqlstr = "SELECT DISTINCT (" . $q[0]->m . " * fee_amount) AS fee_amount, "
										. " (SELECT fee_name from fee_master where id=class_fee_det.fee_id) AS fee_name "
										. " FROM class_fee_det "
										. " WHERE fee_cat = 2 AND stud_cat = " . $student[0]->stud_category . " AND "
										. " class_fee_head_id = " . $q[0]->class_fee_head_id . " AND status = 0 AND fee_amount <> 0 "
										. " AND class_fee_det.fee_id not in (2,3)";
				} 
//Amit :: Code ends here 

           //     $monthly_fee = $this->db->query("SELECT (" . $q[0]->m . "*fee_amount) as fee_amount,(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name,fee_id FROM class_fee_det  where fee_cat=2 and stud_cat=" . $student[0]->stud_category . " and class_fee_head_id=" . $q[0]->class_fee_head_id . " and status=1");
                $monthly_fee = $this->db->query(sqlstr);
				$monthly_fee = $monthly_fee->result();

            } else if ($value == 1) {
                $str .= ' Annual Fees,';
                $annual_fee = $this->db->query("SELECT fee_amount,(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name,fee_id FROM class_fee_det  where fee_cat=1 and stud_cat=" . $student[0]->stud_category . " and class_fee_head_id=" . $q[0]->class_fee_head_id . " and status=1");
                $annual_fee = $annual_fee->result();

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
                    $str .= ' ' . $q[0]->d . ' Months Fine';
                } else {
                    $str .= ' ' . $q[0]->d . ' Month Fine';
                }
                $fine_fee = $this->db->query("SELECT sum(amount) as fee_amount,'Fine for " . $q[0]->d . " Months' as fee_name FROM fee_transaction_det  where fee_cat_id=0 and fee_trans_head_id=$fee_transaction_id");
                $fine_fee = $fine_fee->result();

            } else if ($value == 6) {
                $transport_fee = $this->db->query("SELECT sum(amount) as fee_amount FROM fee_transaction_det  where fee_cat_id=6 and fee_trans_head_id=$fee_transaction_id")->result();
                $str .= ' Transport Fees,';
//                $transport_fee = $q[0]->m * $student[0]->transport_amt;
                $transport_fee = $transport_fee[0]->fee_amount;

            } else if ($value == 7) {
                $str .= ' Fine Waiver,';
                $discount = $q[0]->discount_amount;

            }
        }

        $str = rtrim($str, ',');
//        $this->load->library('FpdfGen');
//        $this->load->library('PDF_JavaScript');
//        $this->load->library('PDF_autoprint');

        include('application/libraries/PDF_autoprint.php');
//        include('fpdi/fpdi.php');
        $this->fpdf = new PDF_AutoPrint();

        $this->fpdf->AddPage();
        $this->fpdf->setSourceFile("./fpdf/dot_matrix.pdf");
        $import = $this->fpdf->importPage(1);
        $this->fpdf->useTemplate($import, NULL, NULL, 0, 0, true);
        
        $this->fpdf->SetFont('Courier', '', 7);
        $this->fpdf->SetXY(30, 28);
        $this->fpdf->Write(0, $q[0]->receipt_no);
        $this->fpdf->SetXY(135, 28);
        $this->fpdf->Write(0, $q[0]->receipt_no);
        
        $this->fpdf->SetXY(70, 28);
        $this->fpdf->Write(0, $q[0]->payment_date);
        $this->fpdf->SetXY(169.5, 28);
        $this->fpdf->Write(0, $q[0]->payment_date);
        
        $this->fpdf->SetXY(30, 31.5);
        $this->fpdf->Write(0, $str);
        $this->fpdf->SetXY(135, 31.5);
        $this->fpdf->Write(0, $str);
        
        $this->fpdf->SetXY(30, 35);
        $this->fpdf->Write(0, $student[0]->name);
        $this->fpdf->SetXY(135, 35);
        $this->fpdf->Write(0, $student[0]->name);
        
        $this->fpdf->SetXY(30, 38.5);
        $this->fpdf->Write(0, $student[0]->admission_no);
        $this->fpdf->SetXY(135, 38.5);
        $this->fpdf->Write(0, $student[0]->admission_no);
        
        $this->fpdf->SetXY(70, 38.5);
        $this->fpdf->Write(0, $student[0]->class_name.'-'.$student[0]->sec_name);
        $this->fpdf->SetXY(180, 38.5);
        $this->fpdf->Write(0, $student[0]->class_name.'-'.$student[0]->sec_name);
        
        $total = 0;
//        if(count($monthly_fee)>0) {
            foreach ($monthly_fee as $key => $value) {
                $total = $total + $value->fee_amount;
                switch ($value->fee_id) {
                    case 1:
                            $this->fpdf->SetXY(80, 65);
                            $this->fpdf->Write(0, $value->fee_amount);
                            $this->fpdf->SetXY(190, 65);
                            $this->fpdf->Write(0, $value->fee_amount);
                        break;
                    case 2:
                            $this->fpdf->SetXY(80, 70.5);
                            $this->fpdf->Write(0, $value->fee_amount);
                            $this->fpdf->SetXY(190, 70.5);
                            $this->fpdf->Write(0, $value->fee_amount);
                        break;
                    case 3:
                            $this->fpdf->SetXY(80, 150);
                            $this->fpdf->Write(0, $value->fee_amount);
                            $this->fpdf->SetXY(190, 150);
                            $this->fpdf->Write(0, $value->fee_amount);
                        break;
                    default:
                        break;
                }
                
            }
//        }
        
        foreach ($annual_fee as $obj) {
            $total = $total + $obj->fee_amount;
            switch ($obj->fee_id) {
                    case 4:
                            $this->fpdf->SetXY(80, 85);
                            $this->fpdf->Write(0, $obj->fee_amount);
                            $this->fpdf->SetXY(190, 85);
                            $this->fpdf->Write(0, $obj->fee_amount);
                        break;
                    case 5:
                            $this->fpdf->SetXY(80, 92);
                            $this->fpdf->Write(0, $obj->fee_amount);
                            $this->fpdf->SetXY(190, 92);
                            $this->fpdf->Write(0, $obj->fee_amount);
                        break;
                    case 8:
                            $this->fpdf->SetXY(80, 98);
                            $this->fpdf->Write(0, $obj->fee_amount);
                            $this->fpdf->SetXY(190, 98);
                            $this->fpdf->Write(0, $obj->fee_amount);
                        break;
                    case 9:
                            $this->fpdf->SetXY(80, 110);
                            $this->fpdf->Write(0, $obj->fee_amount);
                            $this->fpdf->SetXY(190, 110);
                            $this->fpdf->Write(0, $obj->fee_amount);
                        break;
                    case 7:
                            $this->fpdf->SetXY(80, 136);
                            $this->fpdf->Write(0, $obj->fee_amount);
                            $this->fpdf->SetXY(190, 136);
                            $this->fpdf->Write(0, $obj->fee_amount);
                        break;
                    default:
                        break;
                }
        }
        
        foreach ($fine_fee as $obj) {
            $total = $total + $obj->fee_amount;
            $this->fpdf->SetXY(80, 118);
            $this->fpdf->Write(0, $obj->fee_amount);
            $this->fpdf->SetXY(190, 118);
            $this->fpdf->Write(0, $obj->fee_amount);
            
        }
        
        $this->fpdf->SetXY(80, 217);
        $this->fpdf->Write(0, $total);
        $this->fpdf->SetXY(190, 217);
        $this->fpdf->Write(0, $total);
        $this->fpdf->AutoPrint();
        $this->fpdf->Output();
        
    }

        public function payment_pdf_army() {
        $this->load->library('numbertowords');

        $month = array(1 => "April", 2 => "May", 3 => "June", 4 => "July", 5 => "August", 6 => "September", 7 => "October", 8 => "Novemeber", 9 => "December", 10 => "January", 11 => "February", 12 => "March");

        $fee_transaction_id = $this->uri->segment(5);
       //to fetch transaction details with total amount
        $query_transaction = $this->db->query("select f1.*,f2.class_fee_head_id,f2.stud_category,group_concat(distinct(f2.fee_cat_id)) as fee,count(case when f2.month_no<>0 and f2.fee_cat_id in (2,5) then f2.month_no end) as m,min(case when f2.month_no<>0 and f2.fee_cat_id in (2,5) then f2.month_no end) as from_month,max(f2.due_month_no) as d from fee_transaction_head f1, fee_transaction_det f2 where f1.id=$fee_transaction_id and f1.response_message=0 and f1.status=1 and f1.id=f2.fee_trans_head_id group by f1.id");
        $q = $query_transaction->result();
        // to fetch student details
        $student = $this->dbconnection->select('student', 'id,roll,course_id,transport_amt,'
                . ' class_id,(select class_name from class where id=student.class_id) as class_name,'
                . ' concat(first_name," ",middle_name," ",last_name) as name,admission_no,'
                . ' stud_category,'
                . ' (select c.cat_name from category c where c.id=stud_category) as cat_name,'
                . '  section_id,(select s.sec_name from section s where s.id=section_id) as sec_name,father_name,'
                . ' email_address, phone, dob, status, date_created,start_fee_month,created_by,last_date_modified, last_modified_by', 'id = ' . $this->uri->segment(6));

        $start_fee_month = $student[0]->start_fee_month;
        $school_id = $this->session->userdata('school_id');
        $school = $this->school_desc;
        $transport_fee = 0;
        $discount = 0;
        $monthly_fee = array();
        $annual_fee = array();
        $one_fee = array();
        $other_fee = array();
        $instant_fee = array();
        $readmsnfine_fee = array();
        $fine_fee = array();
        $half_fee = array();
        $fe_desc = explode(',', $q[0]->fee);
        $str = '';
        $monthly = 0;
        $annual = 0;
        $half_yearly = 0;
        $other = 0;
        $fine = 0;
        // echo "<pre>";print_r($fe_desc);die();   
        foreach ($fe_desc as $index => $value) {
            if ($value == 2 ) {
                if ($q[0]->m > 1) {

                    $month_var = $q[0]->from_month + $q[0]->m - 1;
                    $str .= $month[$q[0]->from_month] . "-" . $month[$month_var] . " Fees,";
                } else {
                    $str .= $month[$q[0]->from_month] . " Fees,";
                }


//Amitabh 16-Oct-2020: Added code to get correct patment details
			// --Checking if *class_fee_det* and *fee_transaction_det* have same amount OR not
                $sum_class_fee_chk = $this->db->query("SELECT (" . $q[0]->m . " * fee_amount) AS fee_amt,"
													. " (SELECT fee_name FROM fee_master WHERE id=class_fee_det.fee_id) AS fee_name "
													. " 	FROM class_fee_det "
													. " 	WHERE fee_cat=2 AND stud_cat=" . $student[0]->stud_category . " AND "
													. " 	class_fee_head_id=" . $q[0]->class_fee_head_id . " AND status=1");

				$sum_class_chk = 0; 
				foreach($sum_class_fee_chk->result() as $row) {
					$sum_class_chk = $sum_class_chk + $row->fee_amt;
				}

				$sum_fee_trans_det_chk = $this->db->query("SELECT ftd.amount as tot_amt"
													. " FROM fee_transaction_det ftd, fee_transaction_head fth"
													. " WHERE fth.id = ftd.fee_trans_head_id "
													. " AND ftd.fee_trans_head_id =" . $fee_transaction_id . " AND ftd.fee_cat_id=" . $value);

				$sum_trans_chk = 0; 
				foreach($sum_fee_trans_det_chk->result() as $row_1) {
					$sum_trans_chk = $sum_trans_chk + $row_1->tot_amt;
				}
			
			//-- Changing query if there is *MISMATCH* in TOTAL OR *NO MISMATCH*
				$sqlstr = '';
				if ($sum_class_chk == $sum_trans_chk) {
					$sqlstr = "SELECT (" . $q[0]->m . "*fee_amount) AS fee_amount,"
										. " (SELECT fee_name from fee_master where id=class_fee_det.fee_id) AS fee_name "
										. " FROM class_fee_det "
										. " WHERE fee_cat = 2 AND stud_cat = " . $student[0]->stud_category . " AND "
										. " class_fee_head_id = " . $q[0]->class_fee_head_id . " AND status = 1";
				} else {
					
					// -- Removing **Yearly.../Exam...Fee** if *Start Month* is not 1 (April)
					$sqlstr = "SELECT DISTINCT (" . $q[0]->m . " * fee_amount) AS fee_amount, "
										. " (SELECT fee_name from fee_master WHERE id = class_fee_det.fee_id) AS fee_name "
										. " FROM class_fee_det "
										. " WHERE fee_cat = 2 AND stud_cat = " . $student[0]->stud_category . " AND "
										. " class_fee_head_id = " . $q[0]->class_fee_head_id . " AND status = 0 AND fee_amount <> 0";
					$sum_class_fee_chk1 = $this->db->query($sqlstr);
					$sum_class_chk1 = 0; 
					foreach($sum_class_fee_chk1->result() as $row) {
						$sum_class_chk1 = $sum_class_chk1 + $row->fee_amount;
					}
					
					if ($sum_class_chk1 <> $sum_trans_chk)	
						$sqlstr = "SELECT DISTINCT (" . $q[0]->m . " * fee_amount) AS fee_amount, "
										. " (SELECT fee_name from fee_master where id=class_fee_det.fee_id) AS fee_name "
										. " FROM class_fee_det "
										. " WHERE fee_cat = 2 AND stud_cat = " . $student[0]->stud_category . " AND "
										. " class_fee_head_id = " . $q[0]->class_fee_head_id . " AND status = 0 AND fee_amount <> 0 "
										. " AND class_fee_det.fee_id not in (2,3)";
				} 
	/*			else {
					$sqlstr = "SELECT (" . $q[0]->m . "*fee_amount) AS fee_amount,"
										. " (SELECT fee_name from fee_master where id=class_fee_det.fee_id) AS fee_name "
										. " FROM class_fee_det "
										. " WHERE fee_cat = 2 AND stud_cat = " . $student[0]->stud_category . " AND "
										. " class_fee_head_id = " . $q[0]->class_fee_head_id . " AND status = 1";
				} */
//Amit :: Code ends here 

           //     $monthly_fee = $this->db->query("SELECT (" . $q[0]->m . "*fee_amount) as fee_amount,(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name FROM class_fee_det  where fee_cat=2 and stud_cat=" . $student[0]->stud_category . " and class_fee_head_id=" . $q[0]->class_fee_head_id . " and status=1");
                $monthly_fee = $this->db->query(strsql);
				$monthly_fee = $monthly_fee->result();
				
            } else if ($value == 5) {
				if ($q[0]->m > 1) {
                    $month_var = $q[0]->from_month + $q[0]->m - 1;
                    $str .= $month[$q[0]->from_month] . "-" . $month[$month_var] . " Fees,";
                } else {
                    $str .= $month[$q[0]->from_month] . " Fees,";
                }
                $monthly_fee = $this->db->query("SELECT round(" . $q[0]->m . "*(fee_amount/3)) as fee_amount,(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name,fee_id FROM class_fee_det  where fee_cat=5 and stud_cat=" . $q[0]->stud_category . " and class_fee_head_id=" . $q[0]->class_fee_head_id . " and status=1");
                $monthly_fee = $monthly_fee->result();

            } else if ($value == 1) {
                $str .= ' Annual Fees,';
                $annual_fee = $this->db->query("SELECT fee_amount,(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name,fee_id FROM class_fee_det  where fee_cat=1 and stud_cat=" . $q[0]->stud_category . " and class_fee_head_id=" . $q[0]->class_fee_head_id . " and status=1");
                $annual_fee = $annual_fee->result();
            
			} else if ($value == 9) {
                $str .= ' Onetime Fees,';
                $one_fee = $this->db->query("SELECT fee_amount,(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name FROM class_fee_det  where fee_cat in (9,10) and stud_cat=" . $q[0]->stud_category . " and class_fee_head_id=" . $q[0]->class_fee_head_id . " and status=1");
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
                    $str .= ' ' . $q[0]->d . ' Months Fine';
                } else {
                    $str .= ' ' . $q[0]->d . ' Month Fine';
                }

                $fine_fee = $this->db->query("SELECT sum(amount) as fee_amount,'Fine for " . $q[0]->d . " Months' as fee_name FROM fee_transaction_det  where fee_cat_id=0 and fee_trans_head_id=$fee_transaction_id");
                $fine_fee = $fine_fee->result();

            } else if ($value == 11) {
//                $str .= ' Re-Admission-Fine,';
                $readmsnfine_fee = $this->db->query("SELECT amount as fee_amount,'Re-Admission-Fine' as fee_name FROM fee_transaction_det  where fee_cat_id=11 and fee_trans_head_id=$fee_transaction_id");
                $readmsnfine_fee = $readmsnfine_fee->result();
                
            } else if ($value == 6) {
                $transport_fee = $this->db->query("SELECT sum(amount) as fee_amount FROM fee_transaction_det  where fee_cat_id=6 and fee_trans_head_id=$fee_transaction_id")->result();
                $str .= ' Transport Fees,';
//                $transport_fee = $q[0]->m * $student[0]->transport_amt;
                $transport_fee = $transport_fee[0]->fee_amount;

            } else if ($value == 7) {
                $str .= ' Fine Waiver,';
                $discount = $q[0]->discount_amount;
            }
        }

        $str = rtrim($str, ',');

        $college_id = $this->session->userdata('school_id');
        /*      $reggistration_no = ;
          $college_id = $this->id; */
        /* $data = $this->dbconnection->select('collegefclb.college', '*', 'id=' . $college_id); */
        $logo = 'assets/img/' . $this->session->userdata('school_id') . '.JPG';
        /*        $pdf_id = $data[0]->result_pdf_id;
          $data_inv = $this->dbconnection->select('collegefclb.result_pdf', '*', 'id=' . $pdf_id); */
        $inv_view = 'payment_dompdf';
        $size = 'A4';
        /*        $invoice_demo_no = $data_inv[0]->result_pdf_no; */
        $orientation = 'landscape';
        /* $reg_no = $this->uri->segment('4');//$reggistration_no; */
        /* $this->db->db_select('crmfeesclub_'.$this->id);
         */
        /* $stud=$this->Mymodel->get_student_byreg($reg_no);
         */
        $array = array('logo' => $logo, 'school_desc' => $school,'start_fee_month'=>$start_fee_month, 'q' => $q, 'student' => $student, 'fee_paid' => $str, 'monthly_fee' => $monthly_fee, 'transport_fee' => $transport_fee, 'annual_fee' => $annual_fee, 'other_fee' => $other_fee, 'fine_fee' => $fine_fee, 'discount' => $discount, 'half_fee' => $half_fee,'instant_fee'=>$instant_fee,'readmsnfine_fee'=>$readmsnfine_fee,'one_fee'=>$one_fee);
       // echo "<pre>"; print_r($array);die();
        $this->load->view('feepayment/collection/' . $inv_view, $array);
        $html = $this->output->get_output();
        $this->load->library('pdf');
        $this->dompdf->load_html($html);
        $this->dompdf->set_paper($size, $orientation);
        $this->dompdf->render();
        $this->dompdf->stream("payment_pdf.pdf", array("Attachment" => FALSE));
    }

}
