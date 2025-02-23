<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Promotion_passout extends CI_Controller {
    
    public $page_code = 'promotion';
    public $page_id = '';
    public $page_perm = '----';
    public function __construct() {
        parent::__construct();

        $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");

        
        $this->id = $this->session->userdata('school_id');
        $this->school_desc = $this->dbconnection->select("school", "*", "id=" . $this->id . " and status = 1");

        if ($this->id != 0) {
            $this->db->db_select('crmfeesclub_' . $this->id);
//                $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "active='Y'");
        }

        $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y' and active='Y'");
        $currentYear = date('Y');
        $currentMonth = date('m');

        $activesessionendYear = $this->academic_session[0]->end_date;
        $activesessionstartYear = $this->academic_session[0]->start_date;

        $this->previousSession = '';
        $this->previousSessionID = 0;
        $this->nextSession = '';
        $this->nextSessionID = 0;
        $this->appliedmonth = 0;
        if ($currentYear == date('Y', strtotime($activesessionendYear))) {

            $this->previousSession = $this->academic_session[0]->session;
            $this->previousSessionID = $this->academic_session[0]->fin_year;
            $this->previousSessionyear = date('Y', strtotime($activesessionstartYear));
            $this->appliedmonth = date('m', strtotime($activesessionendYear));
            $fetchnextsession = $this->dbconnection->select("accedemic_session", "*", "Year(start_date)=$currentYear");
            $this->nextSession = !empty($fetchnextsession) ? $fetchnextsession[0]->session : 'No NextSession Created';
            $this->nextSessionID = !empty($fetchnextsession) ? $fetchnextsession[0]->id : 0;
        } elseif ($currentYear == date('Y', strtotime($activesessionstartYear))) {

            $fetchprevsession = $this->dbconnection->select("accedemic_session", "*", "Year(end_date)=$currentYear");
            $this->previousSession = !empty($fetchprevsession) ? $fetchprevsession[0]->session : 'No PreviousSession Created';
            $this->previousSessionID = !empty($fetchprevsession) ? $fetchprevsession[0]->id : 0;
            $this->previousSessionyear = date('Y', strtotime($fetchprevsession[0]->start_date));
            $this->nextSession = $this->academic_session[0]->session;
            $this->nextSessionID = $this->academic_session[0]->fin_year;
            $this->appliedmonth = date('m', strtotime($activesessionstartYear));
//                $this->appliedmonth=$this->appliedmonth+3;
        }

        $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
        $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
        $this->right_access = $this->page_perm;

        if (strpos($this->page_perm, '----') == true) {
            redirect(base_url(''), 'refresh');
        }
        $this->page_title = 'Promotion/Passout';
        $this->section = 'admission';
        $this->page_name = 'promotion_passout';
        $this->customview = '';
    }

    public function index() {

        if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->data['page_name'] = $this->page_name;
        $this->data['page_title'] = $this->page_title;
        $this->data['section'] = $this->section;
        $this->data['customview'] = $this->customview;
        $this->data['right_access'] = $this->right_access;
        $this->data['aclass'] = $this->dbconnection->select("class", "*", "status='Y'");
        $this->data['previousSession'] = $this->previousSession;
        $this->data['nextSession'] = $this->nextSession;
        $this->data['nextSessionID'] = $this->nextSessionID;
        $this->data['appliedmonth'] = $this->appliedmonth;

        $this->load->view('index', $this->data);
    }

    public function load_bulk_promote() {
        if (!$this->input->is_ajax_request() || substr($this->right_access, 0, 1) != 'C') {
            redirect('404');
        }

        $frm_cls = $this->input->post('class');
        $this->data['asec'] = $this->dbconnection->select("section", "*", "status='Y'");
        $this->data['acourse'] = $this->dbconnection->select("course", "*", "status='Y'");
        $this->data['fetch_qry'] = $this->dbconnection->select("student", "id,admission_no, concat(first_name,' ',middle_name,' ',last_name) as name,section_id,course_id", "class_id=$frm_cls and status='Y' and student_academicyear_id=$this->previousSessionID");
        $this->load->view("admission/bulk_transfer", $this->data);
    }

    public function promote_class() {

        if (!$this->input->is_ajax_request() || substr($this->right_access, 0, 1) != 'C') {
            redirect('404');
        }

        $old_class = $this->input->post('from_class');
        $new_class = ($this->input->post('to_class') == 'same') ? $old_class : $this->input->post('to_class');
        $inputall = $this->input->post();

        /* -------------- */
        $month = date('m');
        if ($month >= 4 && $month <= 12) {
            $month = $month - 3;
        } else {
            $month = $month + 9;
        }
        /* ------------------ */

//Not Promoted Student Updation
//        $arr=array();
//        $fetchstud=$this->db->query("select id from student where class_id=$old_class and status='Y' and student_academicyear_id=$this->previousSessionID");
//        $fetchstud=$fetchstud->result_array();
//        foreach($fetchstud as $s) {
//           $arr[]=$s['id'];
//        }
//        $a= array_diff($arr,$inputall['chk_row']);
//      
//        foreach($a as $v){
//            $this->dbconnection->update('student',array('student_academicyear_id'=>$this->nextSessionID,'last_date_modified'=>date('Y-m-d H:i:s'),'last_modified_by'=>$this->session->userdata('user_id')),'id='.$v);
//        }
//Promoted Student Updation
        foreach ($inputall['chk_row'] as $chk_stud) {
            $class_id = $this->dbconnection->Get_namme("student", "id", "$chk_stud", "class_id");
            $section_id = $this->dbconnection->Get_namme("student", "id", "$chk_stud", "section_id");
            $course_id = $this->dbconnection->Get_namme("student", "id", "$chk_stud", "course_id");
            $stud_category = $this->dbconnection->Get_namme("student", "id", "$chk_stud", "stud_category");
            $transport_amt = $this->dbconnection->Get_namme("student", "id", "$chk_stud", "transport_amt");
            $this->dbconnection->update('student', array('class_id' => $new_class, 'section_id' => $inputall['section'][$chk_stud], 'course_id' => $inputall['course'][$chk_stud], 'student_academicyear_id' => $this->nextSessionID, 'last_date_modified' => date('Y-m-d H:i:s'), 'last_modified_by' => $this->session->userdata('user_id')), 'id=' . $chk_stud);

            $check_fee_struc_zero=$this->db->query("SELECT sum(fee_amount) famt FROM class_fee_det cd inner join class_fee_head ch on cd.class_fee_head_id=ch.id "
                    . "where (ch.from_class_id<=$class_id and ch.to_class_id>=$class_id) and ch.course=$course_id and ch.status='Y' and ch.year<=$this->previousSessionyear and cd.stud_cat=$stud_category "
                    . "and cd.fee_cat in (1,2,5,4) and cd.status=1;")->result();
            $total_fee=$check_fee_struc_zero[0]->famt+$transport_amt;
            
            $fetch_instant_fees_det = $this->dbconnection->select("student_other_fee as fee", "fee.*, (Select fee_name from fee_master where id=fee.fee_id) as fee_desc", "fee.student_id=" . $chk_stud . " and year=$this->previousSessionID and paid_status!=1 and status='Y'");
            
            if(empty($total_fee)) {
                $dmonth=0;
                $dann=0;
            }else{
                $query_defaulter = $this->db->query("select s.id,if(count(f1.id)=0,'1','0') as annual,if(count(d2.month_no)>=$month"
                    . " ,'0',cast($month-count(d2.month_no) as char)) as monthly from student as s"
                    . " left join ( fee_transaction_head as f1 inner join fee_transaction_det d1 on f1.id=d1.fee_trans_head_id and d1.fee_cat_id=1)"
                    . " on f1.student_id=s.id and f1.paid_status=1 and f1.year=$this->previousSessionID"
                    . " left join ( fee_transaction_head as f2 inner join fee_transaction_det d2 on f2.id=d2.fee_trans_head_id and d2.fee_cat_id=2)"
                    . " on f2.student_id=s.id and f2.paid_status=1 and f2.year=$this->previousSessionID and f2.response_code=0 where s.id=$chk_stud group by s.id")->result();
                
                $dmonth=$query_defaulter[0]->monthly;
                $dann=$query_defaulter[0]->annual;
            }
            
            if(count($fetch_instant_fees_det)>0) {
                $dinstant='YES';
            }else{
                $dinstant='NO';
            }
            
            $datac = array(
                "student_id" => $chk_stud,
                "class_id" => $old_class,
                "section_id" => $section_id,
                "course_id" => $course_id,
                "stud_category" => $stud_category,
                "acedemic_year_id" => $this->previousSessionID,
                'no_unpaid_month' => $dmonth,
                'annual_unpaid' => $dann,
                'instant_fee_unpaid'=>$dinstant,
                'half_year_unpaid' => 3,
                'created_by' => $this->session->userdata('user_id'),
                'date_created' => date('Y-m-d H:i:s')
            );
            $this->dbconnection->insert("student_class_acedemic_log", $datac);
        }

        $audit = array("action" => 'Class Promotion',
            "module" => $this->uri->segment(1),
            "page" => basename(__FILE__, '.php'),
            'datetime' => date("Y-m-d H:i:s"),
            'userid' => $this->session->userdata('user_id'),
            'remarks' => 'FromCLassID:' . $old_class,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
        );
        $this->dbconnection->insert("auditntrail", $audit);
    }

    public function passout_class() {

        if (!$this->input->is_ajax_request() || substr($this->right_access, 0, 1) != 'C') {
            redirect('404');
        }

        $old_class = $this->input->post('from_class');
//        $new_class=$this->input->post('to_class');
        $inputall = $this->input->post();

        /* -------------- */
        $month = date('m');
        if ($month >= 4 && $month <= 12) {
            $month = $month - 3;
        } else {
            $month = $month + 9;
        }
        /* ------------------ */
//        $arr=array();
//        $fetchstud=$this->db->query("select id from student where class_id=$old_class and status='Y' and student_academicyear_id=$this->previousSessionID");
//        $fetchstud=$fetchstud->result_array();
//        foreach($fetchstud as $s) {
//           $arr[]=$s['id'];
//        }
//        $a= array_diff($arr,$inputall['chk_row']);
////        print_r($a);
//        foreach($a as $v){
//            $this->dbconnection->update('student',array('student_academicyear_id'=>$this->nextSessionID),'id='.$v);
//        }
//Promoted Student Updation
        foreach ($inputall['chk_row'] as $chk_stud) {
            $class_id = $this->dbconnection->Get_namme("student", "id", "$chk_stud", "class_id");
            $section_id = $this->dbconnection->Get_namme("student", "id", "$chk_stud", "section_id");
            $course_id = $this->dbconnection->Get_namme("student", "id", "$chk_stud", "course_id");
            $stud_category = $this->dbconnection->Get_namme("student", "id", "$chk_stud", "stud_category");
            $transport_amt = $this->dbconnection->Get_namme("student", "id", "$chk_stud", "transport_amt");
            $this->dbconnection->update("student", array('student_academicyear_id' => $this->nextSessionID, 'status' => 'N', 'last_date_modified' => date('Y-m-d H:i:s'), 'last_modified_by' => $this->session->userdata('user_id')), "id=$chk_stud"); //TC
            $this->dbconnection->insert('tc_passout', array('student_id' => $chk_stud, 'status' => 'PASS', 'date' => date('Y-m-d'), 'academic_year_id' => $this->nextSessionID, 'created_by' => $this->session->userdata('user_id')));
            
            
            $check_fee_struc_zero=$this->db->query("SELECT sum(fee_amount) famt FROM class_fee_det cd inner join class_fee_head ch on cd.class_fee_head_id=ch.id "
                    . "where (ch.from_class_id<=$class_id and ch.to_class_id>=$class_id) and ch.course=$course_id and ch.status='Y' and ch.year<=$this->previousSessionyear and cd.stud_cat=$stud_category "
                    . "and cd.fee_cat in (1,2,5,4) and cd.status=1;")->result();
            $total_fee=$check_fee_struc_zero[0]->famt+$transport_amt;
            
            $fetch_instant_fees_det = $this->dbconnection->select("student_other_fee as fee", "fee.*, (Select fee_name from fee_master where id=fee.fee_id) as fee_desc", "fee.student_id=" . $chk_stud . " and year=$this->previousSessionID and paid_status!=1 and status='Y'");
            
            if(empty($total_fee)) {
                $dmonth=0;
                $dann=0;
            }else{
            
            $query_defaulter = $this->db->query("select s.id,if(count(f1.id)=0,'1','0') as annual,if(count(d2.month_no)>=$month"
                    . " ,'0',cast($month-count(d2.month_no) as char)) as monthly from student as s"
                    . " left join ( fee_transaction_head as f1 inner join fee_transaction_det d1 on f1.id=d1.fee_trans_head_id and d1.fee_cat_id=1)"
                    . " on f1.student_id=s.id and f1.paid_status=1 and f1.year=$this->previousSessionID"
                    . " left join ( fee_transaction_head as f2 inner join fee_transaction_det d2 on f2.id=d2.fee_trans_head_id and d2.fee_cat_id=2)"
                    . " on f2.student_id=s.id and f2.paid_status=1 and f2.year=$this->previousSessionID and f2.response_code=0 where s.id=$chk_stud group by s.id");
            $query_defaulter = $query_defaulter->result();
            $dmonth=$query_defaulter[0]->monthly;
                $dann=$query_defaulter[0]->annual;
            }
            if(count($fetch_instant_fees_det)>0) {
                $dinstant='YES';
            }else{
                $dinstant='NO';
            }
            
            $data = array(
                "student_id" => $chk_stud,
                "class_id" => $old_class,
                "section_id" => $section_id,
                "course_id" => $course_id,
                "stud_category" => $stud_category,
                "acedemic_year_id" => $this->previousSessionID,
                'no_unpaid_month' => $dmonth,
                'annual_unpaid' => $dann,
                'instant_fee_unpaid'=>$dinstant,
                'half_year_unpaid' => 3,
                'created_by' => $this->session->userdata('user_id'),
                'date_created' => date('Y-m-d H:i:s')
            );
            $this->dbconnection->insert("student_class_acedemic_log", $data);

            $this->dbconnection->update("user", array('status' => 0, 'last_date_modified' => date('Y-m-d H:i:s'), 'last_modified_by' => $this->session->userdata('user_id')), "student_id=$chk_stud");
            $audit = array("action" => 'USER DELETED',
                "module" => $this->uri->segment(1),
                "page" => basename(__FILE__, '.php'),
                'datetime' => date("Y-m-d H:i:s"),
                'userid' => $this->session->userdata('user_id'),
                'remarks' => 'StudentID:' . $chk_stud,
                'ip_address' => $_SERVER['REMOTE_ADDR'],
            );
            $this->dbconnection->insert("auditntrail", $audit);
        }

        $audit = array("action" => 'Class PassOut',
            "module" => $this->uri->segment(1),
            "page" => basename(__FILE__, '.php'),
            'datetime' => date("Y-m-d H:i:s"),
            'userid' => $this->session->userdata('user_id'),
            'remarks' => 'FromCLassID:' . $old_class,
            'ip_address' => $_SERVER['REMOTE_ADDR'],
        );
        $this->dbconnection->insert("auditntrail", $audit);
    }

//    public function tc_class(){
//        
//        if (! $this->input->is_ajax_request()) {
//                redirect('404');
//        }
//        
//        $old_class=$this->input->post('from_class');
//        $new_class=$this->input->post('to_class');
//        $inputall=$this->input->post();
//        
//        
////        $arr=array();
////        $fetchstud=$this->db->query("select id from student where class_id=$old_class and status='Y' and student_academicyear_id=$this->previousSessionID");
////        $fetchstud=$fetchstud->result_array();
////        foreach($fetchstud as $s) {
////           $arr[]=$s['id'];
////        }
////        $a= array_diff($arr,$inputall['chk_row']);
//////        print_r($a);
////        foreach($a as $v){
////            $this->dbconnection->update('student',array('student_academicyear_id'=>$this->nextSessionID),'id='.$v);
////        }
//        
//        //Promoted Student Updation
//        foreach($inputall['chk_row'] as $chk_stud)
//        {
//            $this->dbconnection->update("student",array('student_academicyear_id'=>$this->previousSessionID,'status'=>'N','last_date_modified'=>date('Y-m-d H:i:s'),'last_modified_by'=>$this->session->userdata('user_id')),"id=$chk_stud");//TC
//            $this->dbconnection->insert('tc_passout',array('student_id'=>$chk_stud,'status'=>'PASS','date'=>date('Y-m-d'),'academic_year_id'=>$this->previousSessionID,'created_by'=>$this->session->userdata('user_id')));
//        }
//        
//        $audit = array("action"=> 'Class TC',
//                        "module" => $this->uri->segment(1),
//                        "page" => basename(__FILE__, '.php'),
//                        'datetime' => date("Y-m-d H:i:s"),
//                        'userid' => $this->session->userdata('user_id'),
//                        'remarks' => 'FromCLassID:'.$old_class,
//                        'ip_address' => $_SERVER['REMOTE_ADDR'],
//                        );
//        $this->dbconnection->insert("auditntrail",$audit);
//    }
}
