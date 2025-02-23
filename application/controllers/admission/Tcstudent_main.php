<?php
ini_set('max_execution_time', 0);

defined('BASEPATH') OR exit('No direct script access allowed');

class Tcstudent_main extends CI_Controller {    
    
    public function __construct() {
        
        $this->page_code = 'inactive_student';

        parent::__construct();
        $this->id=$this->session->userdata('school_id');
        if ($this->id != 0) {
            $this->db->db_select('crmfeesclub_' . $this->id);
        }
        // error_reporting(-1);
        // ini_set('display_errors', 1);
        // $this->db->db_debug=TRUE;
        
        $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y' and active='Y'");
        $fetch_startyr = isset($this->academic_session[0]->start_date) ? explode('-', $this->academic_session[0]->start_date) : array('0');
        $this->session_start_yr = reset($fetch_startyr);
        $this->fin_year = $this->academic_session[0]->fin_year;
        $this->school_desc = $this->dbconnection->select("crmfeesclub.school", "*", "id=" . $this->id . " and status = 1");
        $this->school_date_created=$this->school_desc[0]->start_report_date;
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
        
        
         $this->dualpermission = $this->dbconnection->select("dual_permission", "authorise_person3,permission", "link_code=$this->page_id");
        $this->page_perm = !empty($this->dualpermission) ? $this->dualpermission[0]->permission : '----';
        $this->person = !empty($this->dualpermission) ? $this->dualpermission[0]->authorise_person3 : '';
        $this->dual_right_access = $this->page_perm;
        $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year", "active='Y'");
    }
    
    public function index() {
        
        $this->data['page_name'] = 'tc_student_page';
        $this->data['page_title'] = 'Inactive Student';
        $this->data['section'] = 'admission';
        $this->data['customview'] = '';
        $this->data['student'] = $this->dbconnection->select("student","id,admission_no","status='Y'" );
        $this->data['query_payment']=$this->db->query("SELECT tc.id as tc_id,tc.student_id,tc.date,tc.status,tc.reason,tc.remarks,"
    . "stu.id as stu_id,stu.start_fee_month,stu.admission_no,stu.class_id,(select class_name from class where id=stu.class_id) as class_name,"
    . "(concat(stu.first_name,' ',stu.middle_name,' ',stu.last_name)) as name,"
    . "stu.stud_category,stu.start_fee_month,(select c.cat_name from category c where c.id=stud_category) as cat_name,(select max(id) from class_fee_head) as max_class_fee_id,"
    . "(select sum(fee_amount) from class_fee_det where fee_cat=1 and stud_cat=stu.stud_category) as annual_fee_amount,"
    . "(select sum(fee_amount) from class_fee_det where fee_cat=5 and stud_cat=stu.stud_category) as quarterly_fee_amount,"
    . "(select sum(fee_amount) from class_fee_det where fee_cat=10 and stud_cat=stu.stud_category) as onetime_fee_amount "
    . "FROM tc_passout tc join student stu on tc.student_id=stu.id order by tc.student_id ")->result();
        $this->load->view('index', $this->data);
        
    }

    public function AddTcStudentPage()
    {
        $this->data['page_name'] = 'add_tcstudent';
        $this->data['page_title'] = 'Inactive Student';
        $this->data['section'] = 'admission';
        $this->data['customview'] = '';
        $this->data['student'] = $this->dbconnection->select("student","id,admission_no","status='Y'" );
        $this->data['tcstudent'] = $this->db->query("SELECT tc.id as tc_id,tc.student_id,tc.date,tc.status,tc.reason,tc.remarks,stu.id as stu_id,stu.admission_no,stu.class_id,(select class_name from class where id=stu.class_id) as class_name,stu.stud_category,(select c.cat_name from category c where c.id=stud_category) as cat_name,(select max(id) from class_fee_head) as max_class_fee_id,(select sum(fee_amount) from class_fee_det where fee_cat=1 and stud_cat=stu.stud_category) as annual_fee_amount,(select sum(fee_amount) from class_fee_det where fee_cat=5 and stud_cat=stu.stud_category) as quarterly_fee_amount,(select sum(fee_amount) from class_fee_det where fee_cat=10 and stud_cat=stu.stud_category) as onetime_fee_amount FROM tc_passout tc,student stu where tc.student_id=stu.id order by tc.student_id")->result();
        $this->load->view('index', $this->data);
    }

    public function add() {
        parent::add();

        /* -------------- */
        $month = date('m');
        if ($month >= 4 && $month <= 12) {
            $month = $month - 3;
        } else {
            $month = $month + 9;
        }
        /* ------------------ */

        if ($this->dbtablelastid) {

            if ($this->input->post('status') == 'PASS') {
                
            }

            $student_id = $this->dbconnection->Get_namme("tc_passout", "id", "$this->dbtablelastid", "student_id");
            $class_id = $this->dbconnection->Get_namme("student", "id", "$student_id", "class_id");
            $section_id = $this->dbconnection->Get_namme("student", "id", "$student_id", "section_id");
            $course_id = $this->dbconnection->Get_namme("student", "id", "$student_id", "course_id");
            $stud_category = $this->dbconnection->Get_namme("student", "id", "$student_id", "stud_category");

            $previoussession = $this->dbconnection->Get_namme("student", "id", "$student_id", "student_academicyear_id");

            $this->dbconnection->update("student", array('status' => 'N', 'last_date_modified' => date('Y-m-d H:i:s'), 'last_modified_by' => $this->session->userdata('user_id')), "id=$student_id"); //TC

            $query_defaulter = $this->db->query("select s.id,if(count(f1.id)=0,'1','0') as annual,if(count(d2.month_no)>=$month"
                    . " ,'0',cast($month-count(d2.month_no) as char)) as monthly from student as s"
                    . " left join ( fee_transaction_head as f1 inner join fee_transaction_det d1 on f1.id=d1.fee_trans_head_id and d1.fee_cat_id=1)"
                    . " on f1.student_id=s.id and f1.paid_status=1 and f1.year=$previoussession"
                    . " left join ( fee_transaction_head as f2 inner join fee_transaction_det d2 on f2.id=d2.fee_trans_head_id and d2.fee_cat_id=2)"
                    . " on f2.student_id=s.id and f2.paid_status=1 and f2.year=$previoussession and f2.response_code=0 where s.id=$student_id group by s.id");

            $query_defaulter = $query_defaulter->result();
            $datac = array(
                "student_id" => $student_id,
                "class_id" => $class_id,
                "section_id" => $section_id,
                "course_id" => $course_id,
                "stud_category" => $stud_category,
                "acedemic_year_id" => $previoussession,
                'no_unpaid_month' => $query_defaulter[0]->monthly,
                'annual_unpaid' => $query_defaulter[0]->annual,
                'half_year_unpaid' => 3,
                'created_by' => $this->session->userdata('user_id'),
                'date_created' => date('Y-m-d H:i:s')
            );
            $this->dbconnection->insert("student_class_acedemic_log", $datac);
            $this->dbconnection->update("user", array('status' => 0, 'last_date_modified' => date('Y-m-d H:i:s'), 'last_modified_by' => $this->session->userdata('user_id')), "student_id=$student_id");
            $audit = array("action" => 'USER DELETED',
                "module" => $this->uri->segment(1),
                "page" => basename(__FILE__, '.php'),
                'datetime' => date("Y-m-d H:i:s"),
                'userid' => $this->session->userdata('user_id'),
                'remarks' => 'StudentID:' . $student_id,
                'ip_address' => $_SERVER['REMOTE_ADDR'],
            );
            $this->dbconnection->insert("auditntrail", $audit);
        }
    }

    public function update($id) {
        $prevstudent_id = $this->dbconnection->Get_namme("tc_passout", "id", "$id", "student_id");
        $prevstudclass_id = $this->dbconnection->Get_namme("student", "id", "$prevstudent_id", "class_id");
        $newstudent_id = $this->input->post('student_id');
        $newstudclass_id = $this->dbconnection->Get_namme("student", "id", "$newstudent_id", "class_id");
        $section_id = $this->dbconnection->Get_namme("student", "id", "$newstudent_id", "section_id");
        $course_id = $this->dbconnection->Get_namme("student", "id", "$newstudent_id", "course_id");
        $stud_category = $this->dbconnection->Get_namme("student", "id", "$newstudent_id", "stud_category");
        $previoussession = $this->dbconnection->Get_namme("student", "id", "$newstudent_id", "student_academicyear_id");

        /* -------------- */
        $month = date('m');
        if ($month >= 4 && $month <= 12) {
            $month = $month - 3;
        } else {
            $month = $month + 9;
        }
        /* ------------------ */
        parent::update($id);

        if ($this->updateind) {

            if ($prevstudent_id != $newstudent_id) {
                $this->dbconnection->update("student", array('status' => 'Y', 'last_date_modified' => date('Y-m-d H:i:s'), 'last_modified_by' => $this->session->userdata('user_id')), "id=$prevstudent_id"); //TC
                $this->dbconnection->delete("student_class_acedemic_log", ['student_id' => $prevstudent_id]);
                $this->dbconnection->update("user", array('status' => 1, 'last_date_modified' => date('Y-m-d H:i:s'), 'last_modified_by' => $this->session->userdata('user_id')), "student_id=$prevstudent_id");
                $audit = array("action" => 'USER ACTIVE',
                    "module" => $this->uri->segment(1),
                    "page" => basename(__FILE__, '.php'),
                    'datetime' => date("Y-m-d H:i:s"),
                    'userid' => $this->session->userdata('user_id'),
                    'remarks' => 'StudentID:' . $prevstudent_id,
                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                );
                $this->dbconnection->insert("auditntrail", $audit);
            }
            $this->dbconnection->update("student", array('status' => 'N', 'last_date_modified' => date('Y-m-d H:i:s'), 'last_modified_by' => $this->session->userdata('user_id')), "id=$newstudent_id"); //TC

            $query_defaulter = $this->db->query("select s.id,if(count(f1.id)=0,'1','0') as annual,if(count(d2.month_no)>=$month"
                    . " ,'0',cast($month-count(d2.month_no) as char)) as monthly from student as s"
                    . " left join ( fee_transaction_head as f1 inner join fee_transaction_det d1 on f1.id=d1.fee_trans_head_id and d1.fee_cat_id=1)"
                    . " on f1.student_id=s.id and f1.paid_status=1 and f1.year=$previoussession"
                    . " left join ( fee_transaction_head as f2 inner join fee_transaction_det d2 on f2.id=d2.fee_trans_head_id and d2.fee_cat_id=2)"
                    . " on f2.student_id=s.id and f2.paid_status=1 and f2.year=$previoussession and f2.response_code=0 where s.id=$newstudent_id group by s.id");

            $query_defaulter = $query_defaulter->result();
            $datac = array(
                "student_id" => $newstudent_id,
                "class_id" => $newstudclass_id,
                "section_id" => $section_id,
                "course_id" => $course_id,
                "stud_category" => $stud_category,
                "acedemic_year_id" => $previoussession,
                'no_unpaid_month' => $query_defaulter[0]->monthly,
                'annual_unpaid' => $query_defaulter[0]->annual,
                'half_year_unpaid' => 3,
                'created_by' => $this->session->userdata('user_id'),
                'date_created' => date('Y-m-d H:i:s')
            );
            $this->dbconnection->update("student_class_acedemic_log", $datac, "student_id=$newstudent_id");
            $this->dbconnection->update("user", array('status' => 0, 'last_date_modified' => date('Y-m-d H:i:s'), 'last_modified_by' => $this->session->userdata('user_id')), "student_id=$newstudent_id");
            $audit = array("action" => 'USER DELETED',
                "module" => $this->uri->segment(1),
                "page" => basename(__FILE__, '.php'),
                'datetime' => date("Y-m-d H:i:s"),
                'userid' => $this->session->userdata('user_id'),
                'remarks' => 'StudentID:' . $newstudent_id,
                'ip_address' => $_SERVER['REMOTE_ADDR'],
            );
            $this->dbconnection->insert("auditntrail", $audit);
        }
    }

    public function delete() {
        $prevstudent_id = $this->dbconnection->Get_namme("tc_passout", "id", trim($this->input->post('id')), "student_id");
        parent::delete();
        if ($this->delind) {
            $this->dbconnection->update("student", array('status' => 'Y', 'last_date_modified' => date('Y-m-d H:i:s'), 'last_modified_by' => $this->session->userdata('user_id')), "id=" . $prevstudent_id); //TC

            $this->dbconnection->delete("student_class_acedemic_log", ['student_id' => $prevstudent_id]);
            $this->dbconnection->update("user", array('status' => 1, 'last_date_modified' => date('Y-m-d H:i:s'), 'last_modified_by' => $this->session->userdata('user_id')), "student_id=$prevstudent_id");
            $audit = array("action" => 'USER ACTIVE',
                "module" => $this->uri->segment(1),
                "page" => basename(__FILE__, '.php'),
                'datetime' => date("Y-m-d H:i:s"),
                'userid' => $this->session->userdata('user_id'),
                'remarks' => 'StudentID:' . $prevstudent_id,
                'ip_address' => $_SERVER['REMOTE_ADDR'],
            );
            $this->dbconnection->insert("auditntrail", $audit);
        }
    }

    
    public function deleteTCstudent()
    {
        $prevstudent_id = $this->dbconnection->Get_namme("tc_passout", "id", trim($this->uri->segment(4)), "student_id");
        $this->delind=$this->dbconnection->delete($this->dbtable, array('id'=> trim($this->uri->segment(4)) ) );
        if($this->delind){
         $this->dbconnection->update("student", array('status' => 'Y', 'last_date_modified' => date('Y-m-d H:i:s'), 'last_modified_by' => $this->session->userdata('user_id')), "id=" . $prevstudent_id); //TC

            $this->dbconnection->delete("student_class_acedemic_log", ['student_id' => $prevstudent_id]);
            $this->dbconnection->update("user", array('status' => 1, 'last_date_modified' => date('Y-m-d H:i:s'), 'last_modified_by' => $this->session->userdata('user_id')), "student_id=$prevstudent_id");
            $audit = array("action" => 'USER ACTIVE',
                "module" => $this->uri->segment(1),
                "page" => basename(__FILE__, '.php'),
                'datetime' => date("Y-m-d H:i:s"),
                'userid' => $this->session->userdata('user_id'),
                'remarks' => 'StudentID:' . $prevstudent_id,
                'ip_address' => $_SERVER['REMOTE_ADDR'],
            );
            $this->dbconnection->insert("auditntrail", $audit);
        }

         redirect('admission/TcStudent');
    }

    public function exportcsv() {
        $records = $this->dbconnection->select('tc_passout', '*', 'status="Y"');

        $filename = "FeesClub-TC-Export-" . date('Ymd') . ".csv";

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $filename);

        $colnames = array();
        foreach ($this->display_columns as $field => $disp) {
            $colnames[] = $disp;
        }
//      foreach ($this->edit_columns as $col => $colparams) {
//          if (!isset($this->display_columns[$col])) {
//              $colnames[] = $colparams['disp'];
//          }
//      }

        $out = fopen('php://output', 'w');
        fputcsv($out, $colnames);
        foreach ($records as $rec) {
            $recarr = array();
            foreach ($this->display_columns as $field => $disp) {
                $recarr[] = $rec->$field;
            }
//          foreach ($this->edit_columns as $col => $colparams) {
//              if (!isset($this->display_columns[$col])) {
//                  $recarr[] = $rec->$col;
//              }
//          }
            fputcsv($out, $recarr);
        }
        fclose($out);
    }
    
    public function TcStudentPage()
    {
        $this->data['page_name'] = 'Tc_student_list';
        $this->data['page_title'] = 'Inactive Student';
        $this->data['section'] = 'admission';
        $this->data['customview'] = '';
        $this->data['student'] = $this->dbconnection->select("student","id,admission_no","status='Y'" );


     $this->data['query_payment']=$this->db->query("SELECT tc.id as tc_id,tc.student_id,tc.date,tc.status,tc.reason,tc.remarks,"
    . "stu.id as stu_id,stu.start_fee_month,stu.admission_no,stu.class_id,(select class_name from class where id=stu.class_id) as class_name,"
    . "(concat(stu.first_name,' ',stu.middle_name,' ',stu.last_name)) as name,"
    . "stu.stud_category,stu.start_fee_month,(select c.cat_name from category c where c.id=stud_category) as cat_name,(select max(id) from class_fee_head) as max_class_fee_id,"
    . "(select sum(fee_amount) from class_fee_det where fee_cat=1 and stud_cat=stu.stud_category) as annual_fee_amount,"
    . "(select sum(fee_amount) from class_fee_det where fee_cat=5 and stud_cat=stu.stud_category) as quarterly_fee_amount,"
    . "(select sum(fee_amount) from class_fee_det where fee_cat=10 and stud_cat=stu.stud_category) as onetime_fee_amount "
    . "FROM tc_passout tc join student stu on tc.student_id=stu.id order by tc.student_id")->result();

        $this->data['quarterly']=$this->db->query("SELECT tc.student_id,ftd.id,sum(ftd.amount) amount,count(case when ftd.month_no<>0 and "
                . "ftd.fee_cat_id=5 then ftd.month_no end) as m,ftd.month_no,ftd.fee_cat_id ,ftd.other_fee_id,ftd.fee_trans_head_id,"
                . "ftd.class_fee_head_id,ftd.stud_category,ftd.month_desc,ftd.due_month_no,fth.student_id FROM tc_passout tc "
                . "left join (fee_transaction_head fth    join fee_transaction_det ftd  on ftd.fee_trans_head_id=fth.id and fth.paid_status=1 "
                . "and ftd.fee_cat_id=5)  on tc.student_id=fth.student_id  group by tc.student_id  order by tc.student_id")->result();

        $this->data['refundable_onetime']=$this->db->query("SELECT tc.student_id,ftd.amount"
                . ",ftd.fee_cat_id,ftd.fee_trans_head_id,"
                . "ftd.class_fee_head_id,ftd.stud_category FROM tc_passout tc  "
                . "left join (fee_transaction_head fth join fee_transaction_det ftd  on ftd.fee_trans_head_id=fth.id and fth.paid_status=1 "
                . "and ftd.fee_cat_id=10)  on tc.student_id=fth.student_id group by tc.student_id  order by tc.student_id")->result();


        $this->data['annual']=$this->db->query("SELECT tc.student_id,ftd.id,ftd.amount,count(case when ftd.month_no<>0 and ftd.fee_cat_id=1 "
                . "then ftd.month_no end) as m,ftd.month_no,ftd.fee_cat_id ,ftd.other_fee_id,ftd.fee_trans_head_id,ftd.class_fee_head_id,"
                . "ftd.stud_category,ftd.month_desc, ftd.due_month_no,fth.student_id   FROM tc_passout tc left join "
                . "(fee_transaction_head fth join fee_transaction_det ftd  on ftd.fee_trans_head_id=fth.id and fth.paid_status=1 and "
                . "ftd.fee_cat_id=1)  on tc.student_id=fth.student_id  group by tc.student_id  order by tc.student_id")->result();
                            
        $this->load->view('index', $this->data);
    }
    
    public function EditTcStudentPage()
    {
        // error_reporting(-1);
        // ini_set('display_errors', 1);
        // $this->db->db_debug=TRUE;
        $id=$this->uri->segment(4);
        $this->data['page_name'] = 'editTcstudent_new';
        $this->data['page_title'] = 'Edit Inactive Student';
        $this->data['section'] = 'admission';
        $this->data['customview'] = '';
        $this->data['student'] = $this->dbconnection->select("student","id,admission_no","" );
        $this->data['tcstudent'] = $this->db->query("select tc.id as tc_id,tc.student_id,tc.date,tc.status,tc.reason,tc.board_roll,tc.registration_no,tc.tc_number,tc.session_name,tc.first_class,tc.date_of_adm,tc.caster_category,tc.dob_adm,tc.dob_word,tc.failed_in_class,tc.last_class,tc.schl_borad,tc.promotion_clas,tc.prom_cls_yes,tc.fee_due,tc.fee_consession,tc.fee_consession_nature,tc.working_days,tc.days_present,tc.ncc_caded,tc.curricular,tc.general_conduct,tc.session_name,tc.sub1,tc.sub2,tc.sub3,tc.sub4,tc.sub5,tc.sub6,tc.academic_year_id,tc.remarks,stu.id,stu.admission_no,stu.first_name,stu.middle_name,stu.last_name,stu.father_name,stu.mother_name,stu.dob,email_address,stu.phone from tc_passout tc, student stu where tc.student_id=stu.id and tc.id=$id")->result();
        // print_r($this->data['tcstudent']);
        // die();
        // $adm=$this->data['tcstudent'][0]->admission_no;
//        die();
//        $this->loadfeedata($adm);
        $this->data['update_id']=$id;
        $this->load->view('index', $this->data);
    }

    public function load_student_fee_div() {        
        $admsn=$this->input->post('adm');
//         die();
        $month = array(1 => "April", 2 => "May", 3 => "June", 4 => "July", 5 => "Aug", 6 => "Sep", 7 => "Oct", 8 => "Nov", 9 => "Dec", 10 => "Jan", 11 => "Feb", 12 => "Mar");
        $fetch_stud = $this->dbconnection->select("student", "id,start_fee_month,transport_amt,CONCAT(first_name,' ',middle_name,' ',last_name) as name,course_id,father_name,dob,stud_category,(select cat_name from category where id=stud_category) as category_name,phone,email_address,class_id,section_id,student_academicyear_id,(select session from accedemic_session where id=student_academicyear_id) as session", " admission_no='$admsn' and status='Y'");

        $course_id = !empty($fetch_stud) ? $fetch_stud[0]->course_id : 0;
        $class_id = !empty($fetch_stud) ? $fetch_stud[0]->class_id : 0;
        $section_id = !empty($fetch_stud) ? $fetch_stud[0]->section_id : 0;
        $stud_category = !empty($fetch_stud) ? $fetch_stud[0]->stud_category : 0;
        $stud_id = $fetch_stud[0]->id;
        $stud_acedemic_session_id = !empty($fetch_stud) ? $fetch_stud[0]->student_academicyear_id : 0;
        $stud_acedemic_session = !empty($fetch_stud) ? $fetch_stud[0]->session : 0;
        $year = $this->academic_session[0]->fin_year;
        $start_fee_month=$fetch_stud[0]->start_fee_month;
        $fetch_tc=$this->dbconnection->select("tc_passout","*","student_id=$stud_id");
//        print_r($fetch_tc);
//        echo count($fetch_tc);
//        die();
         if(count($fetch_tc)>0) 
        {
             echo '<p style="color:red;font-size:16px;"><b>Already Alloted TC to this Admission No.</b></p>';
             
             
        }
        else{
            $fee_session_query = $this->dbconnection->select("class_fee_head", "max(year) as accd_session, max(id) as max_id", "(from_class_id<=$class_id and to_class_id>=$class_id) and course=" . $course_id . " and status='Y' and year<=$this->session_start_yr");
            $fee_session_year = $fee_session_query[0]->accd_session;
            $max_class_fee_id = $fee_session_query[0]->max_id;

        $class_fee_head_id = 0;
        if ($max_class_fee_id != NULL || $max_class_fee_id != '') {
            $class_fee_head_id = $max_class_fee_id;
                            
//            --------------------------OneTime----------------------------------
                
            $onetime_fee = $this->db->query('SELECT fee_amount,'
                . '(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name,fee_cat '
                . 'FROM class_fee_det where fee_cat in (9,10) and stud_cat=' . $stud_category . ' and'
                . ' class_fee_head_id=' . $max_class_fee_id . ' and status=1'); 
            $onetime_fee_paid = $this->db->query('SELECT * from fee_transaction_det where fee_trans_head_id in( select id from fee_transaction_head where year=' . $year . ' and student_id=' . $fetch_stud[0]->id . ' and paid_status=1 and status=1) and fee_cat_id in (9,10)')->result();
//          --------------------------------OneTime-------------------------------

            /* -------------------------------  Monthly or Quarterly ----------------------------- */

            $fetch_fees_mon_quar = $this->dbconnection->select("class_fee_det as fee", "fee.id,fee.fee_id,fee.fee_amount, (Select fee_name from fee_master where id=fee.fee_id) as fee_desc", "fee.class_fee_head_id=" . $max_class_fee_id . " and fee_cat=2 and status=1 and stud_cat=" . $stud_category);
            $qpm = $this->dbconnection->select("fee_transaction_det", "count(month_no) cnt_paid", "fee_trans_head_id in(select id from fee_transaction_head where year=$year and student_id=" . $fetch_stud[0]->id . " and paid_status=1 and response_code=0 and status=1) and fee_cat_id=2");
//          $qpm=$this->dbconnection->select("fee_trans_det","sum(month_no) cnt_paid","year=$year and student_id=".$fetch_stud[0]->id ." and paid_status=1 and fee_cat_id=$this->fee_cat1");
             $paid_month = $qpm[0]->cnt_paid;
             $yearr = date("Y");  
             // if($paid_month==0)
             // {
             //    $paid_month_name=' -'.$yearr;
             // }


             if($paid_month==1)
             {
                $paid_month_name='April -'.$yearr;
             }
             if($paid_month==2)
             {
                $paid_month_name='May -'.$yearr;
             }
             if($paid_month==3)
             {
                $paid_month_name='June -'.$yearr;
             }
             if($paid_month==4)
             {
                $paid_month_name='July -'.$yearr;
             }
             if($paid_month==5)
             {
                $paid_month_name='August -'.$yearr;
             }
             if($paid_month==6)
             {
                $paid_month_name='September -'.$yearr;
             }
             if($paid_month==7)
             {
                $paid_month_name='October -'.$yearr;
             }
             if($paid_month==8)
             {
                $paid_month_name='November -'.$yearr;
             }
             if($paid_month==9)
             {
                $paid_month_name='December - -'.$yearr;
             }
             if($paid_month==10)
             {
                $paid_month_name='January -'.$yearr;
             }
             if($paid_month==11)
             {
                $paid_month_name='February -'.$yearr;
             }
             if($paid_month==12)
             {
                $paid_month_name='March -'.$yearr;
             }
            $chqqpm = $this->dbconnection->select("fee_transaction_det", "count(month_no) cnt_paid", "fee_trans_head_id in(select id from fee_transaction_head where year=$year and student_id=" . $fetch_stud[0]->id . " and paid_status=2 and response_code=0 and status=1) and fee_cat_id=2");
//                        $qpm=$this->dbconnection->select("fee_trans_det","sum(month_no) cnt_paid","year=$year and student_id=".$fetch_stud[0]->id ." and paid_status=1 and fee_cat_id=$this->fee_cat1");
            $chqpaid_month = $chqqpm[0]->cnt_paid;

            /* ------------------------------------------------------------------------------------ */

            /* -------------------------------  Half-Yearly or Annual ----------------------------- */

            $fetch_fees_half_ann = $this->dbconnection->select("class_fee_det as fee", "fee.id,fee.fee_id,fee.fee_amount, (Select fee_name from fee_master where id=fee.fee_id) as fee_desc,(Select fee_type from fee_master where id=fee.fee_id) as fee_type,(Select month_set from fee_master where id=fee.fee_id) as month_set", "fee.class_fee_head_id=" . $max_class_fee_id . " and fee_cat=$this->fee_cat2 and status=1 and stud_cat=" . $stud_category);
            $half_ann_fee_paid = $this->dbconnection->select_join('fee_transaction_head a', 'a.paid_status,a.remarks,a.receipt_no', "a.year=$year and a.student_id=" . $fetch_stud[0]->id . " and a.paid_status=1 and a.status=1 and b.fee_cat_id=" . $this->fee_cat2, "fee_transaction_det b", " a.id=b.fee_trans_head_id", "inner");
            if (count($half_ann_fee_paid) > 0) {
                $paid_status2 = count($half_ann_fee_paid);

                $remark2 = $half_ann_fee_paid[0]->remarks;
                $receipt_no2 = $half_ann_fee_paid[0]->receipt_no;
            } else {
                $paid_status2 = 0;
                $remark2 = '';
                $receipt_no2 = '';
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
                . " count(case when f2.month_no<>0 and f2.fee_cat_id in (2,5) then f2.month_no end) as m,min(case when f2.month_no<>0 and f2.fee_cat_id in (2,5) then f2.month_no end) as from_month,"
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
                }else if ($value == 5) {
                    if ($payment->m > 1) {

                        $month_var = $payment->from_month + $payment->m - 1;
                        $str .= $payment->m . " Months Fees (" . $month[$payment->from_month] . " to " . $month[$month_var] . "),";
                    } else {
                        $str .= $payment->m . " Month Fees (" . $month[$payment->from_month] . "),";
                    }
                }  else if ($value == 1) {
                    $str .= ' Annual Fees,';
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

        $data = array(
            'student_id' => $stud_id,
            'admission_no' => $admsn,
            'student_name' => !empty($fetch_stud) ? $fetch_stud[0]->name : '',
            'father_name' => !empty($fetch_stud) ? $fetch_stud[0]->father_name : '',
            'dob' => !empty($fetch_stud) ? $fetch_stud[0]->dob : '',
            'category_id' => !empty($fetch_stud) ? $fetch_stud[0]->stud_category : 0,
            'category_name' => !empty($fetch_stud) ? $fetch_stud[0]->category_name : '',
            'course_id' => !empty($fetch_stud) ? $fetch_stud[0]->course_id : 0,
            'class_id' => $class_id,
            'section_id' => $section_id,
            'stud_acedemic_session_id' => $stud_acedemic_session_id,
            'stud_acedemic_session' => $stud_acedemic_session,
            'active_acedemic_session' => $this->academic_session,
            'class_fee_head_id' => $class_fee_head_id,
            'class' => $this->dbconnection->Get_namme("class", "id", "$class_id", "class_name"),
            'section' => $this->dbconnection->Get_namme("section", "id", "$section_id", "sec_name"),
            'course' => $this->dbconnection->Get_namme("course", "id", "$course_id", "course_name"),
            'phone' => !empty($fetch_stud) ? $fetch_stud[0]->phone : '',
            'email_address' => !empty($fetch_stud) ? $fetch_stud[0]->email_address : '',
            'fee_type1' => $this->school_desc[0]->fee_type1,
            'fee_type2' => $this->school_desc[0]->fee_type2,
            'onetime_avai' =>$this->school_desc[0]->onetime,
            'paid_month' => $paid_month,
            'chqpaid_month' => $chqpaid_month,
            'onetime_fee' => $onetime_fee,
            'onetime_fee_paid' => $onetime_fee_paid,
            'month' => $month,
            'fees1' => $fetch_fees_mon_quar,
            'fees2' => $fetch_fees_half_ann,
            'paid_status2' => $paid_status2,
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
            'fee_session_year' => $fee_session_year,
            'fetch_tc'=>$fetch_tc,
            'start_fee_month' => $start_fee_month,
            'paid_month_name' => $paid_month_name,
            'transport_fee_amt' => !empty($fetch_stud) ? $fetch_stud[0]->transport_amt : 0
        );
//         echo json_encode($data);


        $this->load->view('admission/load_tcstudent', $data);
        }
            
    }
    
    
    
     function loadfeedata() {    
        error_reporting(-1);
        ini_set('display_errors', 1);
        $this->db->db_debug=TRUE;

         $admsn=$this->input->post('adm');
         
        $month = array(1 => "April", 2 => "May", 3 => "June", 4 => "July", 5 => "Aug", 6 => "Sep", 7 => "Oct", 8 => "Nov", 9 => "Dec", 10 => "Jan", 11 => "Feb", 12 => "Mar");
        $fetch_stud = $this->dbconnection->select("student", "id,admission_date,start_fee_month,transport_amt,CONCAT(first_name,' ',middle_name,' ',last_name) as name,course_id,father_name,mother_name,dob,stud_category,(select cat_name from category where id=stud_category) as category_name,phone,email_address,class_id,section_id,student_academicyear_id,(select session from accedemic_session where id=student_academicyear_id) as session,first_class", " admission_no='$admsn'");
            // print_r($fetch_stud);
            // die();
        $course_id = !empty($fetch_stud) ? $fetch_stud[0]->course_id : 0;
        $class_id = !empty($fetch_stud) ? $fetch_stud[0]->class_id : 0;
        $section_id = !empty($fetch_stud) ? $fetch_stud[0]->section_id : 0;
        $stud_category = !empty($fetch_stud) ? $fetch_stud[0]->stud_category : 0;
        $stud_id = $fetch_stud[0]->id;
         $dobb = $fetch_stud[0]->dob;
        $datee = date('Y-m-d', strtotime($dobb));
        $month_year=explode('-',$datee);
        $year=$month_year[0];
        $mon=$month_year[1];
        $month_name = strtoupper(date("F", mktime(0, 0, 0, $mon, 10))); 
        $day=$month_year[2];
        $this->load->library('numbertowords');
        $year_words=strtoupper($this->numbertowords->convert_number($year));
         $date_words=strtoupper($this->numbertowords->convert_number($day));
        // die();
        $stud_acedemic_session_id = !empty($fetch_stud) ? $fetch_stud[0]->student_academicyear_id : 0;
        $stud_acedemic_session = !empty($fetch_stud) ? $fetch_stud[0]->session : 0;
        $year = $stud_acedemic_session_id;
        // $year = $this->academic_session[0]->fin_year;
        $start_fee_month=$fetch_stud[0]->start_fee_month;
        $fetch_tc=$this->dbconnection->select("tc_passout","*","student_id=$stud_id");

            if($stud_acedemic_session=='2020-2021')
            {
                $fee_session_query = $this->dbconnection->select("class_fee_head", "max(year) as accd_session, max(id) as max_id", "(from_class_id<=$class_id and to_class_id>=$class_id) and course=" . $course_id . " and status='Y' and year=".$this->academic_session[0]->fin_year);
                // echo 'hii';
            }
            else{
                $fee_session_query = $this->dbconnection->select("class_fee_head", "max(year) as accd_session, max(id) as max_id", "(from_class_id<=$class_id and to_class_id>=$class_id) and course=" . $course_id . " and status='Y' and year<=$this->session_start_yr");
                // echo 'bye';
            }
            // print_r($fee_session_query);

            

            $fee_session_year = $fee_session_query[0]->accd_session;
            $max_class_fee_id = $fee_session_query[0]->max_id;

        $class_fee_head_id = 0;
        if ($max_class_fee_id != NULL || $max_class_fee_id != '') {
            $class_fee_head_id = $max_class_fee_id;
                            
//            --------------------------OneTime----------------------------------
                
            $onetime_fee = $this->db->query('SELECT fee_amount,'
                . '(select fee_name from fee_master where id=class_fee_det.fee_id) as fee_name,fee_cat '
                . 'FROM class_fee_det where fee_cat in (9,10) and stud_cat=' . $stud_category . ' and'
                . ' class_fee_head_id=' . $max_class_fee_id . ' and status=1'); 
            $onetime_fee_paid = $this->db->query('SELECT * from fee_transaction_det where fee_trans_head_id in( select id from fee_transaction_head where year=' . $year . ' and student_id=' . $fetch_stud[0]->id . ' and paid_status=1 and status=1) and fee_cat_id in (9,10)')->result();
//          --------------------------------OneTime-------------------------------

            /* -------------------------------  Monthly or Quarterly ----------------------------- */

            $fetch_fees_mon_quar = $this->dbconnection->select("class_fee_det as fee", "fee.id,fee.fee_id,fee.fee_amount, (Select fee_name from fee_master where id=fee.fee_id) as fee_desc", "fee.class_fee_head_id=" . $max_class_fee_id . " and fee_cat=2 and status=1 and stud_cat=" . $stud_category);
            $qpm = $this->dbconnection->select("fee_transaction_det", "count(month_no) cnt_paid", "fee_trans_head_id in(select id from fee_transaction_head where year=$stud_acedemic_session_id and student_id=" . $fetch_stud[0]->id . " and paid_status=1 and response_code=0 and status=1) and fee_cat_id=2");
            $paid_month = $qpm[0]->cnt_paid;
            if($stud_acedemic_session=='2020-2021')
            {
                $yearr = date("Y"); 
                if($paid_month==0)
             {
                $paid_month_name=' '.$yearr;
             }
             if($paid_month==1)
             {
                $paid_month_name='April '.$yearr;
             }
             if($paid_month==2)
             {
                $paid_month_name='May '.$yearr;
             }
             if($paid_month==3)
             {
                $paid_month_name='June '.$yearr;
             }
             if($paid_month==4)
             {
                $paid_month_name='July '.$yearr;
             }
             if($paid_month==5)
             {
                $paid_month_name='August '.$yearr;
             }
             if($paid_month==6)
             {
                $paid_month_name='September '.$yearr;
             }
             if($paid_month==7)
             {
                $paid_month_name='October '.$yearr;
             }
             if($paid_month==8)
             {
                $paid_month_name='November '.$yearr;
             }
             if($paid_month==9)
             {
                $paid_month_name='December '.$yearr;
             }
             if($paid_month==10)
             {
                $paid_month_name='January '.$yearr;
             }
             if($paid_month==11)
             {
                $paid_month_name='February '.$yearr;
             }
             if($paid_month==12)
             {
                $paid_month_name='March '.$yearr;
             }
            }
            else
            {
                $yearr = '2019'; 
                if($paid_month==0)
             {
                $paid_month_name=' '.$yearr;
             }
             if($paid_month==1)
             {
                $paid_month_name='April '.$yearr;
             }
             if($paid_month==2)
             {
                $paid_month_name='May '.$yearr;
             }
             if($paid_month==3)
             {
                $paid_month_name='June '.$yearr;
             }
             if($paid_month==4)
             {
                $paid_month_name='July '.$yearr;
             }
             if($paid_month==5)
             {
                $paid_month_name='August '.$yearr;
             }
             if($paid_month==6)
             {
                $paid_month_name='September '.$yearr;
             }
             if($paid_month==7)
             {
                $paid_month_name='October '.$yearr;
             }
             if($paid_month==8)
             {
                $paid_month_name='November '.$yearr;
             }
             if($paid_month==9)
             {
                $paid_month_name='December '.$yearr;
             }
             if($paid_month==10)
             {
                $paid_month_name='January 2020';
             }
             if($paid_month==11)
             {
                $paid_month_name='February 2020';
             }
             if($paid_month==12)
             {
                $paid_month_name='March 2020';
             }
            }
             
            
            $chqqpm = $this->dbconnection->select("fee_transaction_det", "count(month_no) cnt_paid", "fee_trans_head_id in(select id from fee_transaction_head where year=$year and student_id=" . $fetch_stud[0]->id . " and paid_status=2 and response_code=0 and status=1) and fee_cat_id=2");
            $chqpaid_month = $chqqpm[0]->cnt_paid;

            /* ------------------------------------------------------------------------------------ */

            /* -------------------------------  Half-Yearly or Annual ----------------------------- */

            $fetch_fees_half_ann = $this->dbconnection->select("class_fee_det as fee", "fee.id,fee.fee_id,fee.fee_amount, (Select fee_name from fee_master where id=fee.fee_id) as fee_desc,(Select fee_type from fee_master where id=fee.fee_id) as fee_type,(Select month_set from fee_master where id=fee.fee_id) as month_set", "fee.class_fee_head_id=" . $max_class_fee_id . " and fee_cat=$this->fee_cat2 and status=1 and stud_cat=" . $stud_category);
            $half_ann_fee_paid = $this->dbconnection->select_join('fee_transaction_head a', 'a.paid_status,a.remarks,a.receipt_no', "a.year=$year and a.student_id=" . $fetch_stud[0]->id . " and a.paid_status=1 and a.status=1 and b.fee_cat_id=" . $this->fee_cat2, "fee_transaction_det b", " a.id=b.fee_trans_head_id", "inner");
            if (count($half_ann_fee_paid) > 0) {
                $paid_status2 = count($half_ann_fee_paid);

                $remark2 = $half_ann_fee_paid[0]->remarks;
                $receipt_no2 = $half_ann_fee_paid[0]->receipt_no;
            } else {
                $paid_status2 = 0;
                $remark2 = '';
                $receipt_no2 = '';
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
                . " count(case when f2.month_no<>0 and f2.fee_cat_id in (2,5) then f2.month_no end) as m,min(case when f2.month_no<>0 and f2.fee_cat_id in (2,5) then f2.month_no end) as from_month,"
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
                }else if ($value == 5) {
                    if ($payment->m > 1) {

                        $month_var = $payment->from_month + $payment->m - 1;
                        $str .= $payment->m . " Months Fees (" . $month[$payment->from_month] . " to " . $month[$month_var] . "),";
                    } else {
                        $str .= $payment->m . " Month Fees (" . $month[$payment->from_month] . "),";
                    }
                }  else if ($value == 1) {
                    $str .= ' Annual Fees,';
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

        $data = array(
            'student_id' => $stud_id,
            'admission_no' => $admsn,
            'student_name' => !empty($fetch_stud) ? $fetch_stud[0]->name : '',
            'admission_date' => $fetch_stud[0]->admission_date,
            'father_name' => !empty($fetch_stud) ? $fetch_stud[0]->father_name : '',
            'mother_name' => !empty($fetch_stud) ? $fetch_stud[0]->mother_name : '',
            'first_class' => $fetch_stud[0]->first_class,
            'dob' => $fetch_stud[0]->dob ,
            'category_id' => !empty($fetch_stud) ? $fetch_stud[0]->stud_category : 0,
            'category_name' => !empty($fetch_stud) ? $fetch_stud[0]->category_name : '',
            'course_id' => !empty($fetch_stud) ? $fetch_stud[0]->course_id : 0,
            'class_id' => $class_id,
            'section_id' => $section_id,
            'stud_acedemic_session_id' => $stud_acedemic_session_id,
            'stud_acedemic_session' => $stud_acedemic_session,
            'active_acedemic_session' => $this->academic_session,
            'class_fee_head_id' => $class_fee_head_id,
            'class' => $this->dbconnection->Get_namme("class", "id", "$class_id", "class_name"),
            'section' => $this->dbconnection->Get_namme("section", "id", "$section_id", "sec_name"),
            'course' => $this->dbconnection->Get_namme("course", "id", "$course_id", "course_name"),
            'phone' => !empty($fetch_stud) ? $fetch_stud[0]->phone : '',
            'email_address' => !empty($fetch_stud) ? $fetch_stud[0]->email_address : '',
            'fee_type1' => $this->school_desc[0]->fee_type1,
            'fee_type2' => $this->school_desc[0]->fee_type2,
            'onetime_avai' =>$this->school_desc[0]->onetime,
            'paid_month' => $paid_month,
            'chqpaid_month' => $chqpaid_month,
            'onetime_fee' => $onetime_fee,
            'onetime_fee_paid' => $onetime_fee_paid,
            'month' => $month,
            'fees1' => $fetch_fees_mon_quar,
            'fees2' => $fetch_fees_half_ann,
            'paid_status2' => $paid_status2,
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
            'fee_session_year' => $fee_session_year,
            'fetch_tc'=>$fetch_tc,
            'start_fee_month' => $start_fee_month,
            'year_words' => $year_words,
            'date_words' => $date_words,
            'month_name' => $month_name,
            'paid_month_name' => $paid_month_name,
            'transport_fee_amt' => !empty($fetch_stud) ? $fetch_stud[0]->transport_amt : 0
        );
        echo json_encode($data);


        // $this->load->view('admission/load_tcstudent', $data);
//        }
            
    }
    
    
    public function saveTcStudent() {
//        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect('404');
//        }

        $admission_no = $this->input->post('admission_no');       
        $student=$this->dbconnection->select("student","id","admission_no=$admission_no");  
        $student_id=$student[0]->id;
           
        $date = $this->input->post('date');
        $inactive_type = $this->input->post('inactive_type');
        $reason = $this->input->post('reason');
        $remarks=$this->input->post('remarks');
        $date_of_adm=$this->input->post('first_adm_date');
        $first_class=$this->input->post('first_class');
        $dob_adm=$this->input->post('dob_adm');
        $dob_word=$this->input->post('dob_word');
        $failed_in_class=$this->input->post('failed_in_class');
        $last_class=$this->input->post('last_class');
        $schl_borad=$this->input->post('schl_borad');
        $promotion_clas=$this->input->post('promotion_clas');
        $fee_due=$this->input->post('fee_due');
        $prom_cls_yes=$this->input->post('prom_cls_yes');
        $fee_consession=$this->input->post('fee_consession');
        $fee_consession_nature=$this->input->post('fee_consession_nature');
        $working_days=$this->input->post('working_days');
        $days_present=$this->input->post('days_present');
        $ncc_caded=$this->input->post('ncc_caded');
        $curricular=$this->input->post('curricular');
        $general_conduct=$this->input->post('general_conduct');
        $board_roll=$this->input->post('board_roll');
        $registration_no=$this->input->post('registration_no');
        $session_name=$this->input->post('session_name');
        $tc_number=$this->input->post('tc_number');
        $sub1=$this->input->post('sub1');
        $sub2=$this->input->post('sub2');
        $sub3=$this->input->post('sub3');
        $sub4=$this->input->post('sub4');
        $sub5=$this->input->post('sub5');
        $sub6=$this->input->post('sub6');
        $sub7=$this->input->post('sub7');
        $caste_category=$this->input->post('caste_category');
        
        $fetch=$this->dbconnection->select("tc_passout","*","student_id=$student_id");

         if(count($fetch)>0) 
        {
            $this->session->set_flashdata('errormsg', "Already created Record.");
            echo json_encode(['error' => 'Already Present.']);
        
        }
        else
        {
             
            $data = array(
                'student_id'=>$student_id,
                'date' => $date,
                'status' => $inactive_type,
                'reason' => $reason,
                'remarks' => $remarks,
                'date_of_adm' => $date_of_adm,
                'first_class' => $first_class,
                'dob_adm' => $dob_adm,
                'dob_word' => $dob_word,
                'failed_in_class' => $failed_in_class,
                'last_class' => $last_class,
                'schl_borad' => $schl_borad,
                'fee_due' => $fee_due,
                'promotion_clas' => $promotion_clas,
                'prom_cls_yes' => $prom_cls_yes,
                'fee_due' => $fee_due,
                'fee_consession' => $fee_consession,
                'fee_consession_nature' => $fee_consession_nature,
                'working_days' => $working_days,
                'days_present' => $days_present,
                'ncc_caded' => $ncc_caded,
                'curricular' => $curricular,
                'general_conduct' => $general_conduct,
                'session_name' => $session_name,
                'board_roll' => $board_roll,
                'registration_no' => $registration_no,
                'tc_number' => $tc_number,
                'sub1' => $sub1,
                'sub2' => $sub2,
                'sub3' => $sub3,
                'sub4' => $sub4,
                'sub5' => $sub5,
                'sub6' => $sub6,
                'sub7' => '',
                'caster_category' => $caste_category,
                'created_by' => $this->session->userdata('user_id'),
            );
            $this->dbconnection->insert('tc_passout', $data);
            $this->dbtablelastid = $this->dbconnection->get_last_id();

            $student_id_tc = $this->dbconnection->Get_namme("tc_passout", "id", "$this->dbtablelastid", "student_id");
            $class_id = $this->dbconnection->Get_namme("student", "id", "$student_id_tc", "class_id");
            $section_id = $this->dbconnection->Get_namme("student", "id", "$student_id_tc", "section_id");
            $course_id = $this->dbconnection->Get_namme("student", "id", "$student_id_tc", "course_id");
            $stud_category = $this->dbconnection->Get_namme("student", "id", "$student_id_tc", "stud_category");

            $previoussession = $this->dbconnection->Get_namme("student", "id", "$student_id_tc", "student_academicyear_id");

            $this->dbconnection->update("student", array('status' => 'N', 'last_date_modified' => date('Y-m-d H:i:s'), 'last_modified_by' => $this->session->userdata('user_id')), "id=$student_id"); //TC

            $query_defaulter = $this->db->query("select s.id,if(count(f1.id)=0,'1','0') as annual,if(count(d2.month_no)>=$month"
                    . " ,'0',cast($month-count(d2.month_no) as char)) as monthly from student as s"
                    . " left join ( fee_transaction_head as f1 inner join fee_transaction_det d1 on f1.id=d1.fee_trans_head_id and d1.fee_cat_id=1)"
                    . " on f1.student_id=s.id and f1.paid_status=1 and f1.year=$previoussession"
                    . " left join ( fee_transaction_head as f2 inner join fee_transaction_det d2 on f2.id=d2.fee_trans_head_id and d2.fee_cat_id=2)"
                    . " on f2.student_id=s.id and f2.paid_status=1 and f2.year=$previoussession and f2.response_code=0 where s.id=$student_id_tc group by s.id");

            $query_defaulter = $query_defaulter->result();
            $datac = array(
                "student_id" => $student_id_tc,
                "class_id" => $class_id,
                "section_id" => $section_id,
                "course_id" => $course_id,
                "stud_category" => $stud_category,
                "acedemic_year_id" => $previoussession,
                'no_unpaid_month' => $query_defaulter[0]->monthly,
                'annual_unpaid' => $query_defaulter[0]->annual,
                'half_year_unpaid' => 3,
                'created_by' => $this->session->userdata('user_id'),
                'date_created' => date('Y-m-d H:i:s')
            );
            $this->dbconnection->insert("student_class_acedemic_log", $datac);
            $this->dbconnection->update("user", array('status' => 0, 'last_date_modified' => date('Y-m-d H:i:s'), 'last_modified_by' => $this->session->userdata('user_id')), "student_id=$student_id");
                $audit = array(
                    "action" => 'USER DELETED',
                    "module" => $this->uri->segment(1),
                    "page" => basename(__FILE__, '.php'),
                    'datetime' => date("Y-m-d H:i:s"),
                    'userid' => $this->session->userdata('user_id'),
                    'remarks' => 'ID:' . $student_id,
                    'ip_address' => $_SERVER['REMOTE_ADDR'],
                );
            $this->dbconnection->insert("auditntrail", $audit);
            
            $this->session->set_flashdata('successmsg', "Successfully Created Record.");

            echo json_encode(['success' => 'Record added successfully.']);
        }
    }
    
    
    public function updateTcStudent() {

        $update_id=$this->input->post('update_id');

        $admission_no = $this->input->post('admission_no');       
        $student=$this->dbconnection->select("student","id","admission_no=$admission_no");  
        $student_id=$student[0]->id;
           
        $update_id = $this->input->post('update_id');
        $date = $this->input->post('date');
        $inactive_type = $this->input->post('inactive_type');
        $father_name = $this->input->post('father_name');
        $mother_name = $this->input->post('mother_name');
        $reason = $this->input->post('reason');
        $remarks=$this->input->post('remarks');
        $date_of_adm=$this->input->post('first_adm_date');
        $first_class=$this->input->post('first_class');
        $dob_adm=$this->input->post('dob_adm');
        $dob_word=$this->input->post('dob_word');
        $failed_in_class=$this->input->post('failed_in_class');
        $last_class=$this->input->post('last_class');
        $schl_borad=$this->input->post('schl_borad');
        $promotion_clas=$this->input->post('promotion_clas');
        $fee_due=$this->input->post('fee_due');
        $prom_cls_yes=$this->input->post('prom_cls_yes');
        $fee_consession=$this->input->post('fee_consession');
        $fee_consession_nature=$this->input->post('fee_consession_nature');
        $working_days=$this->input->post('working_days');
        $days_present=$this->input->post('days_present');
        $ncc_caded=$this->input->post('ncc_caded');
        $curricular=$this->input->post('curricular');
        $general_conduct=$this->input->post('general_conduct');
        $board_roll=$this->input->post('board_roll');
        $registration_no=$this->input->post('registration_no');
        $session_name=$this->input->post('session_name');
        $tc_number=$this->input->post('tc_number');
        $sub1=$this->input->post('sub1');
        $sub2=$this->input->post('sub2');
        $sub3=$this->input->post('sub3');
        $sub4=$this->input->post('sub4');
        $sub5=$this->input->post('sub5');
        $sub6=$this->input->post('sub6');
        $sub7=$this->input->post('sub7');
        $caste_category=$this->input->post('caste_category');
             
            $data = array(
                'status' => $inactive_type,
                'reason' => $reason,
                'remarks' => $remarks,
                'date_of_adm' => $date_of_adm,
                'first_class' => $first_class,
                'dob_adm' => $dob_adm,
                'dob_word' => $dob_word,
                'failed_in_class' => $failed_in_class,
                'last_class' => $last_class,
                'schl_borad' => $schl_borad,
                'fee_due' => $fee_due,
                'promotion_clas' => $promotion_clas,
                'prom_cls_yes' => $prom_cls_yes,
                'fee_due' => $fee_due,
                'fee_consession' => $fee_consession,
                'fee_consession_nature' => $fee_consession_nature,
                'working_days' => $working_days,
                'days_present' => $days_present,
                'ncc_caded' => $ncc_caded,
                'curricular' => $curricular,
                'general_conduct' => $general_conduct,
                'session_name' => $session_name,
                'board_roll' => $board_roll,
                'registration_no' => $registration_no,
                'tc_number' => $tc_number,
                'sub1' => $sub1,
                'sub2' => $sub2,
                'sub3' => $sub3,
                'sub4' => $sub4,
                'sub5' => $sub5,
                'sub6' => $sub6,
                'sub7' => '',
                'caster_category' => $caste_category,
                'created_by' => $this->session->userdata('user_id'),
            );

        $this->dbconnection->update('tc_passout', $data,'id='.$update_id);

        $datas=array(
            'father_name'=>$father_name,
            'mother_name'=>$mother_name,

        );
        $this->dbconnection->update('student', $datas,'id='.$update_id);

        $this->session->set_flashdata('successmsg', "Successfully Updated Record .");


        echo json_encode(['success' => 'Record Updated successfully.']);
    }



}
