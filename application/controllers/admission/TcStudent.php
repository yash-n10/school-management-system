<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class TcStudent extends MY_ListController {    
    
    public function __construct() {
        
        $this->page_code = 'inactive_student';

        parent::__construct();

        if ($this->id != 0) {
            $this->db->db_select('crmfeesclub_' . $this->id);
//                $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year", "active='Y'");
        }
        
//        $this->id = $this->session->userdata('school_id');
//        $this->school_date_created=$this->dbconnection->Get_namme("crmfeesclub.school","id",$this->id,"start_report_date");
        
        $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y' and active='Y'");
        $fetch_startyr = isset($this->academic_session[0]->start_date) ? explode('-', $this->academic_session[0]->start_date) : array('0');
        $this->session_start_yr = reset($fetch_startyr);
        $this->fin_year = $this->academic_session[0]->fin_year;
//        $this->id = $this->session->userdata('school_id');
        $this->school_desc = $this->dbconnection->select("crmfeesclub.school", "*", "id=" . $this->id . " and status = 1");
        $this->school_date_created=$this->school_desc[0]->start_report_date;
        $this->bank_name = $this->dbconnection->select("crmfeesclub.bank", "bank_code", "");
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
//        $dualpermission = $this->dbconnection->select("dual_permission", "authorise_person3,permission", "link_code=$this->page_id and authorise_person3={$this->session->userdata('user_id')}");
        $this->page_perm = !empty($this->dualpermission) ? $this->dualpermission[0]->permission : '----';
        $this->person = !empty($this->dualpermission) ? $this->dualpermission[0]->authorise_person3 : '';
        $this->dual_right_access = $this->page_perm;
        $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year", "active='Y'");
        $this->page_title = 'Inactive Students';
        $this->rec_type = 'Inactive Students';
        $this->rec_types = 'Inactive Students';
        $this->section = 'admission';
        $this->dbtable = 'tc_passout';
        $this->display_columns = array('admissionno_disp' => 'Admission No',
            'name_disp' => 'Student Name', 'date' => 'Date', 'academic_year_id_disp' => 'Academic Session', 'reason' => 'Reason', 'remarks' => 'Remarks', 'status' => 'Status');
        $this->edit_columns = array(
            'student_id' => array('disp' => 'Admission No', 'type' => 'select', 'select_opts' => $this->dbconnection->select('student', 'id AS opt_id, admission_no AS opt_disp'), 'required' => TRUE, 'duplication_check' => TRUE),
            'status' => array('disp' => 'Inactive Type', 'type' => 'select', 'select_opts' => array((object) array('opt_id' => 'TC', 'opt_disp' => 'TC'), (object) array('opt_id' => 'PASS', 'opt_disp' => 'PassOut'), (object) array('opt_id' => 'LEFTWITHOUT', 'opt_disp' => 'Left Without Information'), (object) array('opt_id' => 'FEEDUES', 'opt_disp' => 'Fee Defaulter')), 'required' => TRUE),
            'date' => array('disp' => 'Date', 'type' => 'date', 'required' => TRUE),
            'reason' => array('disp' => 'Reason', 'type' => 'select', 'select_opts' => array((object) array('opt_id' => 'PARENT_REQUEST', 'opt_disp' => 'Parent Request'), (object) array('opt_id' => 'HIGHER_STUDIES', 'opt_disp' => 'Higher Studies'), (object) array('opt_id' => 'LEFTWITHOUT', 'opt_disp' => 'Left Without Information'), (object) array('opt_id' => 'FEEDUES', 'opt_disp' => 'Fee Defaulter')), 'required' => TRUE),
            'remarks' => array('disp' => 'Remarks', 'type' => 'text', 'required' => TRUE),
        );
        $this->extra_add_columns = array('academic_year_id' => !empty($this->academic_session[0]->fin_year) ? $this->academic_session[0]->fin_year : 0, 'created_by' => $this->session->userdata('user_id'));
        $this->extra_edit_columns = array('academic_year_id' => !empty($this->academic_session[0]->fin_year) ? $this->academic_session[0]->fin_year : 0, 'last_modified_by' => $this->session->userdata('user_id'), 'last_date_modified' => date('Y-m-d H:i:s'));
//                $this->custom_search_columns=array('id','admission_no','first_name','father_name','dob','stud_category','email_address');
        $this->search_columns = array(
            'alpha_num' => array(
                'date',
                'reason',
                'remarks',
                'admission_no',
                'student_id',
            ),
            'numeric' => array(
//                  'id','phone',
            ),
            'custom' => array(
              // 'id','admission_no','first_name','father_name','dob','stud_category','email_address','phone','class_id','section_id'
            ),
        );
        $this->rec_key = 'id';
        $this->modal_form = array('status' => TRUE);
        $this->data_table = $this->dbtable . ' AS t1';

        $this->data_select = 'id,student_id, (SELECT admission_no FROM student WHERE id=t1.student_id) AS admissionno_disp,' .
                '( SELECT CONCAT(first_name, " ", middle_name, " ", last_name) FROM student WHERE id=t1.student_id) AS name_disp,' .
                '( SELECT session FROM accedemic_session WHERE id=t1.academic_year_id) AS academic_year_id_disp,status,' .
                'date,reason,remarks';
        $this->data_select_where = '';
        $this->data_delete = 'DELETE';
//      $this->data_delete_update = array('status' => 'N','last_date_modified' => date('Y-m-d'), 'last_modified_by'=>$this->session->userdata('user_id'));
    }
    
    public function index() {
        
        if($this->school[0]->school_group=='ARMY') {
            $this->TcStudentPage();
        }
        else if(($this->session->userdata('school_id')==29)||($this->session->userdata('school_id')==8)){
        	redirect('admission/Tcstudent_main');
        }
        else{
            parent::index();
        }
        
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
        $records = $this->dbconnection->select($this->data_table, $this->data_select, $this->data_select_where);

        $filename = "FeesClub-$this->rec_type-Export-" . date('Ymd') . ".csv";

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
    . "stu.stud_category,stu.start_fee_month,(select c.cat_name from category c where c.id=stud_category) as cat_name FROM tc_passout tc join student stu on tc.student_id=stu.id order by tc.student_id")->result();

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
    
    public function AddTcStudentPage()
    {
        $this->data['page_name'] = 'tcstudent';
        $this->data['page_title'] = 'Inactive Student';
        $this->data['section'] = 'admission';
        $this->data['customview'] = '';
        $this->data['student'] = $this->dbconnection->select("student","id,admission_no","status='Y'" );
        $this->data['tcstudent'] = $this->db->query("SELECT tc.id as tc_id,tc.student_id,tc.date,tc.status,tc.reason,tc.remarks,stu.id as stu_id,stu.admission_no,stu.class_id,(select class_name from class where id=stu.class_id) as class_name,stu.stud_category,(select c.cat_name from category c where c.id=stud_category) as cat_name,(select max(id) from class_fee_head) as max_class_fee_id,(select sum(fee_amount) from class_fee_det where fee_cat=1 and stud_cat=stu.stud_category) as annual_fee_amount,(select sum(fee_amount) from class_fee_det where fee_cat=5 and stud_cat=stu.stud_category) as quarterly_fee_amount,(select sum(fee_amount) from class_fee_det where fee_cat=10 and stud_cat=stu.stud_category) as onetime_fee_amount FROM tc_passout tc,student stu where tc.student_id=stu.id order by tc.student_id")->result();
        $this->load->view('index', $this->data);
    }
    
    public function EditTcStudentPage()
    {
        $id=$this->uri->segment(4);
        $this->data['page_name'] = 'editTcstudent';
        $this->data['page_title'] = 'Edit Inactive Student';
        $this->data['section'] = 'admission';
        $this->data['customview'] = '';
        $this->data['student'] = $this->dbconnection->select("student","id,admission_no","status='Y'" );
        $this->data['tcstudent'] = $this->db->query("select tc.id as tc_id,tc.student_id,tc.date,tc.status,tc.reason,tc.academic_year_id,tc.remarks,stu.admission_no,stu.first_name, stu.middle_name,stu.last_name,stu.father_name,stu.dob,email_address,stu.phone from tc_passout tc, student stu where tc.student_id=stu.id and tc.id=$id")->result();
        $adm=$this->data['tcstudent'][0]->admission_no;
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

            $fetch_fees_mon_quar = $this->dbconnection->select("class_fee_det as fee", "fee.id,fee.fee_id,fee.fee_amount, (Select fee_name from fee_master where id=fee.fee_id) as fee_desc", "fee.class_fee_head_id=" . $max_class_fee_id . " and fee_cat=$this->fee_cat1 and status=1 and stud_cat=" . $stud_category);
            $qpm = $this->dbconnection->select("fee_transaction_det", "count(month_no) cnt_paid", "fee_trans_head_id in(select id from fee_transaction_head where year=$year and student_id=" . $fetch_stud[0]->id . " and paid_status=1 and response_code=0 and status=1) and fee_cat_id=$this->fee_cat1");
//                        $qpm=$this->dbconnection->select("fee_trans_det","sum(month_no) cnt_paid","year=$year and student_id=".$fetch_stud[0]->id ." and paid_status=1 and fee_cat_id=$this->fee_cat1");
            $paid_month = $qpm[0]->cnt_paid;
            $chqqpm = $this->dbconnection->select("fee_transaction_det", "count(month_no) cnt_paid", "fee_trans_head_id in(select id from fee_transaction_head where year=$year and student_id=" . $fetch_stud[0]->id . " and paid_status=2 and response_code=0 and status=1) and fee_cat_id=5");
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
            'fee_session_year' => $fee_session_year,
            'fetch_tc'=>$fetch_tc,
            'start_fee_month' => $start_fee_month,
            'transport_fee_amt' => !empty($fetch_stud) ? $fetch_stud[0]->transport_amt : 0
        );
//         echo json_encode($data);


        $this->load->view('admission/load_tcstudent', $data);
        }
            
    }
    
    
    
     function loadfeedata() {    
     	// error_reporting(-1);
     	// ini_set('display_errors', 1);
     	// $this->db->db_debug=TRUE;

         $admsn=$this->input->post('adm');
         
        $month = array(1 => "April", 2 => "May", 3 => "June", 4 => "July", 5 => "Aug", 6 => "Sep", 7 => "Oct", 8 => "Nov", 9 => "Dec", 10 => "Jan", 11 => "Feb", 12 => "Mar");
        $fetch_stud = $this->dbconnection->select("student", "id,start_fee_month,transport_amt,CONCAT(first_name,' ',middle_name,' ',last_name) as name,course_id,father_name,dob,stud_category,(select cat_name from category where id=stud_category) as category_name,phone,email_address,class_id,section_id,student_academicyear_id,(select session from accedemic_session where id=student_academicyear_id) as session", " admission_no='$admsn'");

        $course_id = !empty($fetch_stud) ? $fetch_stud[0]->course_id : 0;
        $class_id = !empty($fetch_stud) ? $fetch_stud[0]->class_id : 0;
        $section_id = !empty($fetch_stud) ? $fetch_stud[0]->section_id : 0;
        $stud_category = !empty($fetch_stud) ? $fetch_stud[0]->stud_category : 0;
        $stud_id = $fetch_stud[0]->id;
        $stud_acedemic_session_id = !empty($fetch_stud) ? $fetch_stud[0]->student_academicyear_id : 0;
        $stud_acedemic_session = !empty($fetch_stud) ? $fetch_stud[0]->session : 0;
        $year = $stud_acedemic_session_id;
        // $year = $this->academic_session[0]->fin_year;
        $start_fee_month=$fetch_stud[0]->start_fee_month;
        $fetch_tc=$this->dbconnection->select("tc_passout","*","student_id=$stud_id");
        	if($stud_acedemic_session=='2020-2021')
        	{
        		$fee_session_query = $this->dbconnection->select("class_fee_head", "max(year) as accd_session, max(id) as max_id", "(from_class_id<=$class_id and to_class_id>=$class_id) and course=" . $course_id . " and status='Y' and year=".$this->academic_session[0]->fin_year);
        	}
        	else{
        		$fee_session_query = $this->dbconnection->select("class_fee_head", "max(year) as accd_session, max(id) as max_id", "(from_class_id<=$class_id and to_class_id>=$class_id) and course=" . $course_id . " and status='Y' and year<=$this->session_start_yr");
        	}

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

            $fetch_fees_mon_quar = $this->dbconnection->select("class_fee_det as fee", "fee.id,fee.fee_id,fee.fee_amount, (Select fee_name from fee_master where id=fee.fee_id) as fee_desc", "fee.class_fee_head_id=" . $max_class_fee_id . " and fee_cat=$this->fee_cat1 and status=1 and stud_cat=" . $stud_category);
            $qpm = $this->dbconnection->select("fee_transaction_det", "count(month_no) cnt_paid", "fee_trans_head_id in(select id from fee_transaction_head where year=$year and student_id=" . $fetch_stud[0]->id . " and paid_status=1 and response_code=0 and status=1) and fee_cat_id=$this->fee_cat1");
//                        $qpm=$this->dbconnection->select("fee_trans_det","sum(month_no) cnt_paid","year=$year and student_id=".$fetch_stud[0]->id ." and paid_status=1 and fee_cat_id=$this->fee_cat1");
            $paid_month = $qpm[0]->cnt_paid;
            $chqqpm = $this->dbconnection->select("fee_transaction_det", "count(month_no) cnt_paid", "fee_trans_head_id in(select id from fee_transaction_head where year=$year and student_id=" . $fetch_stud[0]->id . " and paid_status=2 and response_code=0 and status=1) and fee_cat_id=5");
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
        
        if ($due_month > 0) {
            
            $fine_month = $due_month;
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

            if (count($quer_fine) > 0) {
                $fine_amount = $quer_fine[0]->fee_amount;
            }
        }


        $collection_center_qry = $this->dbconnection->select("collection_center", "id,collection_code,collection_desc", "status='Y'");

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
            'fine_month' => $fine_month,
            'fine_amount' => $fine_amount,
            'fee_session_year' => $fee_session_year,
            'collection_centers' => $collection_center_qry,
            'bank_list' => $this->bank_name,
            'fetch_tc'=>$fetch_tc,
            'start_fee_month' => $start_fee_month,
            'transport_fee_amt' => !empty($fetch_stud) ? $fetch_stud[0]->transport_amt : 0
        );
//         echo json_encode($data);


        $this->load->view('admission/load_tcstudent', $data);
//        }
            
    }
    
    
    public function saveTcStudent() {
//        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect('404');
//        }
        $student_id = $this->input->post('student_id');       
        $date = $this->input->post('date');
        $inactive_type = $this->input->post('inactive_type');
        $reason = $this->input->post('reason');
        $remarks=$this->input->post('remarks');
        
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
            $audit = array("action" => 'USER DELETED',
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

        $student_id = $this->input->post('student_id');
        $date = $this->input->post('date');
        $inactive_type = $this->input->post('inactive_type');
        $reason = $this->input->post('reason');
        $remarks=$this->input->post('remarks');
        $data = array(
            'student_id'=>$student_id,
            'date' => $date,
            'status' => $inactive_type,
            'reason' => $reason,
            'remarks' => $remarks,
            'created_by' => $this->session->userdata('user_id'),
        );

        $this->dbconnection->update('tc_passout', $data,'id='.$update_id);
        
        $audit = array("action" => 'Inactive Students',
            "module" => $this->uri->segment(1),
            "page" => basename(__FILE__, '.php'),
            'datetime' => date("Y-m-d H:i:s"),
            'userid' => $this->session->userdata('user_id'),
            'remarks' => 'ID:' . $student_id,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
        );
        $this->dbconnection->insert("auditntrail", $audit);
        
        $this->session->set_flashdata('successmsg', "Successfully Created Record .");


        echo json_encode(['success' => 'Record added successfully.']);
    }

}
