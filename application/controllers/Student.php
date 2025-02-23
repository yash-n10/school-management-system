<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Student extends CI_Controller {

    function __construct() {

        parent::__construct();
        // error_reporting(-1);
        // ini_set('display_errors',1);
        // $this->db->db_debug=TRUE;
//
        //
//        $this->load->database();
//        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
//        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
//        $this->output->set_header('Pragma: no-cache');
//        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        $this->load->helper('tam_helper');
        $this->id = $this->session->userdata('school_id');
        if ($this->session->userdata('login_type') != 'student' || empty($this->session->userdata('user_id')) || $this->id == 0) {
            redirect('/login');
        }

        $this->school = $this->dbconnection->select('school', '*', 'id = ' . $this->session->userdata('school_id'));

        

        if ($this->id != 0) {
            $this->db->db_select('crmfeesclub_' . $this->id);

            $user_id = $this->session->userdata('user_id');
            $this->user = $this->dbconnection->select('user', '*', 'id = ' . $user_id);
            $this->stud_id = $this->user[0]->student_id;
            $student_profile = $this->db->get_where('student', array('id' => $this->stud_id))->row();
            $this->class_id = $this->db->get_where('student', array('id' => $this->stud_id))->row()->class_id;
            $this->section_id = $this->db->get_where('student', array('id' => $this->stud_id))->row()->section_id;
            $this->class_name = $this->db->get_where('class', array('id' => $this->class_id))->row()->class_name;
            $this->section_name = $this->db->get_where('section', array('id' => $this->section_id))->row()->sec_name;
            $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y' and active='Y'");
            $fetch_startyr = isset($this->academic_session[0]->start_date) ? explode('-', $this->academic_session[0]->start_date) : array('0');
            $this->session_start_yr = reset($fetch_startyr);
        }

    }

    /*     * *default functin, redirects to login page if no admin logged in yet** */

//    public function index() {
//        if ($this->session->userdata('student_login') != 1)
//            redirect(base_url() . 'login', 'refresh');
//        if ($this->session->userdata('student_login') == 1) {
//            redirect(base_url() . 'student/dashboard', 'refresh');
//        }
//    }



//    function dashboard() {
//        $student_id = $this->session->userdata('student_id');
////$standard=$this->db->query("SELECT s.student_id,st.standard_name FROM `student` s join class c on s.class_id=c.class_id join standard st on st.standard_id=c.standard_id where s.student_id='".$student_id."'");
//
//        $page_data['poll'] = $results[0];
//        $page_data['poll_answer'] = $this->db->get_where('poll_answer', array('poll_id' => $page_data['poll']['poll_id']))->result_array();
////print_r($page_data);exit;
//        $login_type = $this->session->userdata('login_type');
//        $user_id = $this->session->userdata($login_type . '_id');
//        $results = $this->db->get_where('email', array('type' => strtolower($login_type)))->result_array();
//        $i = 0;
//        foreach ($results as $result) {
//            $unread = explode(',', $result['unread']);
//            if (in_array($user_id, $unread)) {
//                $i++;
//            }
//        }
//        $page_data['page_name'] = 'dashboard';
//        $page_data[$login_type . '_message'] = $i;
//        $page_data['page_name'] = 'dashboard';
//
//        $page_data['page_title'] = get_phrase('student_dashboard');
//
//        $this->load->view('index', $page_data);
//    }

    /*     * **MANAGE TEACHERS**** */

    function teacher_list($param1 = '', $param2 = '', $param3 = '') {

        if ($this->session->userdata('student_login') != 1)
            redirect(base_url(), 'refresh');

        if ($param1 == 'personal_profile') {

            $page_data['personal_profile'] = true;

            $page_data['current_teacher_id'] = $param2;
        }

        $page_data['teachers'] = $this->db->get('teacher')->result_array();

        $page_data['page_name'] = 'teacher';

        $page_data['page_title'] = get_phrase('teacher_list');

        $this->load->view('index', $page_data);
    }

    /*     * **MANAGE SUBJECTS**** */

    function subject($param1 = '', $param2 = '') {
        $user_id = $this->session->userdata('user_id');
        $user = $this->dbconnection->select('user', '*', 'id = ' . $user_id);
        $student_id = $user[0]->student_id;

        if ($this->session->userdata('login_type') != 'student')
            redirect(base_url(), 'refresh');
        $student_profile = $this->db->get_where('student', array('id' => $student_id))->row();
        $class_id = $student_profile->class_id;
        $section_id = $student_profile->section_id;

//$page_data['subjects']   = $this->db->get_where('class_subject_teacher', array('class_id' => $class_id,'section_id' => $section_id))->result_array();
        $page_data['subjects'] = $this->dbconnection->get_subject($class_id, $section_id);


        $page_data['student_id'] = $this->stud_id;
        $page_data['class_id'] = $this->class_id;
        $page_data['class_name'] = $this->class_name;
        $page_data['section_name'] = $this->section_name;
        $page_data['section'] = 'academic';
        $page_data['page_name'] = 'student_subject';
        $page_data['page_title'] = get_phrase('view_subject_list');

        $this->load->view('index', $page_data);
    }

    /*     * **MANAGE EXAM MARKS**** */

    function exam($exam_id = '', $class_id = '', $subject_id = '') {

        $user_id = $this->session->userdata('user_id');
        $user = $this->dbconnection->select('user', '*', 'id = ' . $user_id);
        $student_id = $user[0]->student_id;

        if ($this->session->userdata('login_type') != 'student')
            redirect(base_url(), 'refresh');
        $student_profile = $this->db->get_where('student', array('id' => $student_id))->row();
        $page_data['class_id'] = $student_profile->class_id;
        if ($this->input->post('operation') == 'selection') {
            $page_data['exam_id'] = $this->input->post('exam_id');
            $page_data['subject_id'] = $this->input->post('subject_id');
            if ($page_data['exam_id'] > 0 && $page_data['class_id'] > 0 && $page_data['subject_id'] > 0) {
                redirect(base_url() . 'student/marks/' . $page_data['exam_id'] . '/' . $page_data['class_id'] . '/' . $page_data['subject_id'], 'refresh');
            } else {
                $this->session->set_flashdata('mark_message', 'Choose exam, class and subject');
                redirect(base_url() . 'student/marks/', 'refresh');
            }
        }

        $page_data['exam_id'] = $exam_id;
//$page_data['class_id']	=	$class_id;
        $page_data['subject_id'] = $subject_id;
        $this->db->select('grand_total');
        $this->db->where('exam_id', $exam_id);
        $res = $this->db->get_where('exam');
        $emgm = $res->row_array();
        extract($emgm);
        $page_data['grand_total'] = $grand_total;

        $page_data['page_info'] = 'Exam marks';
        $page_data['page_name'] = 'marks';
        $page_data['page_title'] = get_phrase('view_marks');
        $this->load->view('index', $page_data);
    }

    /*     * ********MANAGING MARKS***************** */

    function upcexam() {
        $user_id = $this->session->userdata('user_id');
        $user = $this->dbconnection->select('user', '*', 'id = ' . $user_id);
        $student_id = $user[0]->student_id;

        if ($this->session->userdata('login_type') != 'student')
            redirect(base_url(), 'refresh');
        $student_profile = $this->db->get_where('student', array('id' => $student_id))->row();
        $class_id = $student_profile->class_id;
        $section_id = $student_profile->section_id;

        $page_data['exam'] = $this->dbconnection->select('exam', '*', 'status=1');
        // $page_data['exam'] = $this->dbconnection->select('exam', '*', 'status=1 AND date_created > CURRENT_DATE()');
        // print


//$page_data['subject']=$this->dbconnection->get_marks($class_id,$section_id,$student_id);

        $page_data['student_id'] = $this->stud_id;
        $page_data['class_id'] = $this->class_id;
        $page_data['section_id'] = $this->section_id;
        $page_data['class_name'] = $this->class_name;
        $page_data['section_name'] = $this->section_name;
        $page_data['section'] = 'academic';
        $page_data['page_name'] = 'student_upcomingexam';
        $page_data['page_title'] = get_phrase('upcoming_exam');

        $this->load->view('index', $page_data);
    }

    function marks() {
        $user_id = $this->session->userdata('user_id');
        $user = $this->dbconnection->select('user', '*', 'id = ' . $user_id);
        $student_id = $user[0]->student_id;

        if ($this->session->userdata('login_type') != 'student')
            redirect(base_url(), 'refresh');
        $student_profile = $this->db->get_where('student', array('id' => $student_id))->row();
        $class_id = $student_profile->class_id;
        $section_id = $student_profile->section_id;

        $result=$this->db->query("select mk.student_id,mk.mark_obtained,mk.periodic_test,mk.note_book,mk.sub_enrichment,mk.written_exam,ex.name,ex.excode,ex.theory_mark,ex.practical_mark,ex.class_performance_mks,ex.subj_assgn_marks,ex.grand_total,ex.pass_mark,sub.name as subjectname from mark mk, exam ex, subject sub where ex.id=mk.exam_id and  sub.id=mk.subject_id and mk.class_id=$class_id and mk.section_id=$section_id and mk.student_id=".$this->stud_id)->result();


        $page_data['exam'] = $this->dbconnection->select('exam', '*', 'status=1 AND date_created < CURRENT_DATE()');



//$page_data['subject']=$this->dbconnection->get_marks($class_id,$section_id,$student_id);

        $page_data['student_id'] = $this->stud_id;
        $page_data['class_id'] = $this->class_id;
        $page_data['section_id'] = $this->section_id;
        $page_data['class_name'] = $this->class_name;
        $page_data['section_name'] = $this->section_name;
        $page_data['result'] = $result;
        $page_data['section'] = 'academic';
        $page_data['page_name'] = 'student_marks';
        $page_data['page_title'] = get_phrase('view_exam_result');

        $this->load->view('index', $page_data);
    }

    function Getresult() {

        $examid = $this->input->post('examid');
        $class_id = $this->input->post('clsid');
        $student_id = $this->input->post('stuid');
        $section_id = $this->input->post('secid');

        $examdata = $this->dbconnection->selectexam($examid);
        
         $dat = $this->db->query("select mk.student_id,mk.mark_obtained,mk.periodic_test,mk.note_book,mk.sub_enrichment,mk.written_exam,ex.name,ex.excode,ex.theory_mark,ex.practical_mark,ex.class_performance_mks,ex.subj_assgn_marks,ex.grand_total,ex.pass_mark,sub.name as subjectname from mark mk, exam ex, subject sub where ex.id=mk.exam_id and  sub.id=mk.subject_id and ex.id=$examid and mk.class_id=$class_id and mk.section_id=$section_id and mk.student_id=$student_id")->result();

        // $dat = $this->dbconnection->get_marks($class_id, $section_id, $student_id, $examid);
        ?>


        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><?php echo $examdata[0]->name; ?></h4>

        </div>
        <div class="modal-body">
      
            <p>Total Marks: <?php echo $examdata[0]->grand_total; ?> &nbsp;&nbsp;||&nbsp;&nbsp;<span>Pass Mark: <?php echo $examdata[0]->pass_mark; ?></span></p>
            <table cellpadding="0" cellspacing="0" border="2" class="table table-striped table-bordered" id="subjlist">
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Marks</th>
                        <th>Out Of</th>
                        <th>Status</th>
                    </tr>
                </thead>
        <?php
        foreach ($dat as $value) {

             $subject_id = $value->subjectname;
            $mark_obtained = $value->mark_obtained;
            $mark_total = $value->grand_total;
            $pass_mark = $value->pass_mark;
            ?>

                    <tbody id="datass">
                     
            ?>
            <tr>
                <td><?php if ($subject_id) {
                echo $subject_id;
            } else {
                echo 'N/A';
            } ?></td>
                <td><?php if ($mark_obtained) {
                echo $mark_obtained;
            } else {
                echo 'N/A';
            } ?></td>
                <td><?php if ($mark_total) {
                echo $mark_total;
            } else {
                echo 'N/A';
            } ?></td>
                <td><?php if ($mark_obtained) {
                if ($mark_obtained < $pass_mark) {
                    echo 'FAIL';
                } else {
                    echo 'PASS';
                }
            } else {
                echo 'N/A';
            } ?></td>                  
            </tr>
                    </tbody>

            <?php
        }
        ?>
            </table>
            <p>* (N/A) -&nbsp;<span> Marks has been not updated upto now</span></p>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>

                <?php
            }

            /*             * ********MANAGING TODAY CLASS ROUTINE***************** */

            function GetRout() {
                $class_id = $this->input->post('clasid');
                $sect_id = $this->input->post('secid');
                $day = $this->input->post('day');
                $date = $this->input->post('date');

                $row = $this->dbconnection->GetRoutine($class_id, $sect_id, $day, $date);
                // $row  = $this->db->query("select cr.class_id,cr.section_id,cr.day,cr.period_id,cp.name,cp.time_start,cp.time_start_min,cp.time_end,cp.time_end_min from class_periods cp,class_routine cr where cr.period_id=cp.id and class_id=" . $this->class_id . " and section_id=" . $this->section_id . " and cr.status=1 and day='$day'")->result();
                echo $this->db->last_query();
                ?>
        <tr style="background:#cce6ff;">
            <th style="background:#ffe6e6;"> Time </th>
        <?php foreach ($row as $data) { ?>
                <th style="color:#3366cc"><?php echo $data['time_start'] . ":" . $data['time_start_min'] . "-" . $data['time_end'] . ":" . $data['time_end_min']; ?></th>
        <?php } ?>
        </tr>

        <tr>
            <td style="background:#cce6ff;"> Subject <br>(Teacher) </td>
        <?php foreach ($row as $datas) { ?>
                <td> <?php if ($datas['subject_id'] == '0') {
                echo 'Break';
            } else {
                echo $datas['subjectname'];
            } ?> <br><b><?php
            if ($datas['subject_id'] == '0') {
                echo '';
            } else {
                if ($datas['assignedteacher']) {
                    echo "(" . $datas['assignedteacher'] . ")";
                } else {
                    if ($datas['teachername']) {
                        echo "(" . $datas['teachername'] . ")";
                    } else {
                        echo 'N/A';
                    }
                }
            }
            ?> </b></td>
            <?php } ?>    
        </tr>
        <?php
    }

    /*     * ********MANAGING CLASS ROUTINE***************** */

    function class_routine($param1 = '', $param2 = '', $param3 = '') {

        $user_id = $this->session->userdata('user_id');
        $user = $this->dbconnection->select('user', '*', 'id = ' . $user_id);
        $student_id = $user[0]->student_id;

        if ($this->session->userdata('login_type') != 'student')
            redirect(base_url(), 'refresh');

        $student_profile = $this->db->get_where('student', array('id' => $student_id))->row();
        $class_id = $student_profile->class_id;
        $section_id = $student_profile->section_id;


        $i = 0;
        $k = 0;
        $t = date('d-m-Y');
        $day1 = date("l", strtotime($t));

        $tot_period = 0;

        $period = $this->dbconnection->select("class_routine", "count(id) as cnt", "class_id=" . $this->class_id . " and section_id=" . $this->section_id . " and day='Monday' and status=1");
        $tot_period = $period[0]->cnt;

        $period1 = $this->dbconnection->select("class_routine", "count(id) as cnt", "class_id=" . $this->class_id . " and section_id=" . $this->section_id . " and day='Tuesday' and status=1");
        if ($period1[0]->cnt > $tot_period) {
            $tot_period = $period1[0]->cnt;
        }

        $period2 = $this->dbconnection->select("class_routine", "count(id) as cnt", "class_id=" . $this->class_id . " and section_id=" . $this->section_id . " and day='Wednesday' and status=1");
        if ($period2[0]->cnt > $tot_period) {
            $tot_period = $period2[0]->cnt;
        }

        $period3 = $this->dbconnection->select("class_routine", "count(id) as cnt", "class_id=" . $this->class_id . " and section_id=" . $this->section_id . " and day='Thursday' and status=1");
        if ($period3[0]->cnt > $tot_period) {
            $tot_period = $period3[0]->cnt;
        }

        $period4 = $this->dbconnection->select("class_routine", "count(id) as cnt", "class_id=" . $this->class_id . " and section_id=" . $this->section_id . " and day='Friday' and status=1");
        if ($period4[0]->cnt > $tot_period) {
            $tot_period = $period4[0]->cnt;
        }

        $period5 = $this->dbconnection->select("class_routine", "count(id) as cnt", "class_id=" . $this->class_id . " and section_id=" . $this->section_id . " and day='Saturday' and status=1");
        if ($period5[0]->cnt > $tot_period) {
            $tot_period = $period5[0]->cnt;
        }

        $day_q = $this->db->query("select day from class_routine where class_id=" . $this->class_id . " and section_id=" . $this->section_id . " and status=1 group by day having count(id)=$tot_period");
        $day_nm = $day_q->result();
        $day = $day_nm[0]->day;

        // $period_cnt = $this->dbconnection->select("class_routine", "*", "class_id=" . $this->class_id . " and section_id=" . $this->section_id . " and status=1 and day='$day'");
        $period_cnt = $this->db->query("select cr.class_id,cr.section_id,cr.day,cr.period_id,cp.name,cp.time_start,cp.time_start_min,cp.time_end,cp.time_end_min from class_periods cp,class_routine cr where cr.period_id=cp.id and cr.class_id=" . $this->class_id . " and cr.section_id=" . $this->section_id . " and cr.status=1 and day='$day'")->result();
        /*  echo '<pre>';
          print_r($period_cnt); */

        foreach ($period_cnt as $row) {
            $page_data['start'][$k] = $row->time_start;
            $page_data['start_min'][$k] = $row->time_start_min;
            $page_data['end'][$k] = $row->time_end;
            $page_data['end_min'][$k] = $row->time_end_min;
            $k++;
        }

        $i = 0;
        $max_j = 0;
        $t = date('d-m-Y');
        $day1 = date("l", strtotime($t));
        $day_name = $this->dbconnection->select("class_routine", "distinct(day)", "class_id=" . $this->class_id . " and section_id=" . $this->section_id . " and status=1");

        foreach ($day_name as $d) {
            $subject = $this->dbconnection->select("class_routine", "*", "class_id=" . $this->class_id . " and section_id=" . $this->section_id . " and status=1 and day='" . $d->day . "'");
            $j = 0;
            $page_data['day'][$i] = $d->day;

            foreach ($subject as $row) {
                $subj = $row->subject_id;
                if ($row->subject_id == 0) {
                    $page_data['day_subject'][$i][$j] = 'Break';
                    $page_data['tchr_nam'][$i][$j] = '';
                } else {
                    $page_data['day_subject'][$i][$j] = $this->dbconnection->Get_namme("subject", "id", "$subj", "name");
                    $sub_teachr = $this->dbconnection->select("class_subject_teacher", "teacher_id,id,(select name from employee where id=teacher_id) as tec_name", "subject_id=$subj and class_id=" . $this->class_id . " and section_id=" . $this->section_id . " and status=1");
                    $countsub_tea = count($sub_teachr);
                    if ($countsub_tea > 0) {
                        $page_data['tchr_nam'][$i][$j] = '(' . $sub_teachr[0]->tec_name . ')';
                    } else {
                        $page_data['tchr_nam'][$i][$j] = '(N/A)';
                    }
                }
                $j++;
            }
            if ($j > $max_j)
                $max_j = $j;
            $i++;
        }

        $page_data['cnt'] = $i;
        $page_data['count'] = $max_j;
        $page_data['today'] = $day1;
        $page_data['period'] = $tot_period;
        $page_data['class_id'] = $class_id;
        $page_data['section_id'] = $section_id;
        $page_data['section_name'] = $this->section_name;
        $page_data['section'] = 'academic';
        $page_data['page_name'] = 'student_class_routine';
        $page_data['page_title'] = 'My Class Routine';

        $this->load->view('index', $page_data);
    }

    /*     * ********MANAGE LIBRARY / BOOKS******************* */

    function book($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('login_type') != 'student')
            redirect(base_url(), 'refresh');

        $page_data['student_id'] = $this->stud_id;
        $page_data['class_id'] = $this->class_id;
        $page_data['class_name'] = $this->class_name;
        $page_data['section'] = 'student';
        $page_data['section_name'] = $this->section_name;

        $page_data['books'] = $this->db->get('library_books')->result_array();
        // print_r($page_data['books']);
        // die();
        $page_data['page_name'] = 'book';
        $page_data['page_title'] = get_phrase('library_books_list');
        $this->load->view('index', $page_data);
    }

    /*     * **************************************************************
      Previous Question Papers
     * ************************************************************** */

    /*     * **************************************************************
      Online Test
     * ************************************************************** */


    /*     * ****************************************************************
      Results
     * **************************************************************** */

    function result($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('student_login') != 1)
            $page_data['page_name'] = 'online_test_results';
        $page_data['page_title'] = get_phrase('online_test_results');
        $page_data['onlinetest_id'] = $param1;
//$page_data['onlinetest'] = $this->db->get_where('onlinetest', array('classname' => $param1))->result_array();
        if (!empty($_POST)) {
//print_r($_POST['classname']);
//$page_data['onlinetest'] = $this->db->get_where('onlinetest', array('classname' => $_POST['classname'],'subject'=>$_POST['subject']))->result_array();
//$page_data['onlinetest'] = $this->db->query("select * from onlinetest where classname='".$_POST['classname']."'  and subject='".$_POST['subject']."' ORDER BY RAND()")->result_array();

            $right_answer = 0;
            $wrong_answer = 0;
            $unanswered = 0;
//print_r($_POST);exit;
            $keys = array_keys($_POST);
            $order = join(",", $keys);

//$query="select * from questions id IN($order) ORDER BY FIELD(id,$order)";
//print_r( $query);exit;
//$response=mysql_query("select id,answer from questions where id IN($order) ORDER BY FIELD(id,$order)")   or die(mysql_error());
            $page_data['response'] = $this->db->query("select onlinetest_id,ans from onlinetest where onlinetest_id IN ('" . $order . "')  ORDER BY FIELD(onlinetest_id,$order)")->result_array();
//print_r($page_data['response']);exit;
            /* while($result=mysql_fetch_array($response)){
              if($result['answer']==$_POST[$result['id']]){
              $right_answer++;
              }else if($_POST[$result['id']]==5){
              $unanswered++;
              }
              else{
              $wrong_answer++;
              }
              } */
        }
        $this->load->view('student/results', $page_data);
    }

    /*     * ********MANAGE TRANSPORT / VEHICLES / ROUTES******************* */

    function transport($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('login_type') != 'student')
            redirect(base_url(), 'refresh');

//		$this->db->join('transport_points','pid=ppoint_id');
//		$this->db->join('transport','transport.transport_id =student.transport_id');
//		$this->db->where('student_id',$sid);
//		$query = $this->db->get_where('student');
//		
//		$transports = $query->result();
//        $page_data['transports'] = $transports;
        $page_data['page_name'] = 'transport';
        $page_data['student_id'] = $this->stud_id;
        $page_data['class_id'] = $this->class_id;
        $page_data['class_name'] = $this->class_name;
        $page_data['section'] = 'student';
        $page_data['section_name'] = $this->section_name;
        $page_data['page_title'] = get_phrase('transport_list');

        $this->load->view('index', $page_data);
    }

    /*     * ********MANAGE DORMITORY / HOSTELS / ROOMS ******************* */

    function dormitory($param1 = '', $param2 = '', $param3 = '') {

        if ($this->session->userdata('student_login') != 1)
            redirect('login', 'refresh');
        $sid = $this->session->userdata('student_id');
        $this->db->select('dormitory.name as dname,room.name as rname,student.name as sname,student.roll as sroll');
        $this->db->from('student');
        $this->db->join('dormitory', 'dormitory.dormitory_id = student.dormitory_id');
        $this->db->join('room', 'room.room_id = student.dormitory_room_number');
        $this->db->where('student_id', $sid);
        $query = $this->db->get();
        $ddata = $query->row_array();
//print_r($ddata);
// $page_data['dormitories'] = $this->db->get('dormitory')->result_array();
        $page_data['dormitories'] = $ddata;
        $page_data['page_name'] = 'dormitory';



        $page_data['page_title'] = get_phrase('dormitory');

        $this->load->view('index', $page_data);
    }

    /*     * ********WATCH ASSIGNMENT ******************* */

    function assignments($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('login_type') != 'student')
            redirect(base_url(), 'refresh');

        $page_data['student_id'] = $this->stud_id;
        $page_data['class_id'] = $this->class_id;
        $page_data['class_name'] = $this->class_name;
        $page_data['section'] = 'academic';
        $page_data['page_name'] = 'student_assignments';

        $page_data['assig'] = $this->dbconnection->select('assignment', 'count(id) as total', 'class_id=' . $this->class_id . ' AND section_id=' . $this->section_id );
        // $page_data['assig'] = $this->dbconnection->select('assignment', 'count(id) as total', 'class_id=' . $this->class_id . ' AND section_id=' . $this->section_id . ' AND dos>CURDATE()');

        // print_r($page_data['assig']);
        // die();

        // $page_data['complete'] = $this->dbconnection->selectCompletassignment($this->class_id, $this->section_id);
        $page_data['todo'] = $this->dbconnection->selectassignment($this->class_id, $this->section_id);
        $page_data['complete'] = $this->dbconnection->selectCompletassignment($this->class_id, $this->section_id);
        // print_r($page_data['todo']);
        // die();
        $page_data['section_name'] = $this->section_name;
        $page_data['assignments'] = $this->db->get('class')->result_array();
        $page_data['page_title'] = get_phrase('assignments');
        $this->load->view('index', $page_data);
    }

    function GetRemarksData($as_id, $st_id) {
        return $dts = 123;
    }

    /*     * ********WATCH NOTICEBOARD AND EVENT ******************* */

    function noticeboard($param1 = '', $param2 = '', $param3 = '') {
        if ($this->session->userdata('login_type') != 'student')
            redirect(base_url(), 'refresh');


               $page_data['notices']    = $this->db->get('noticeboard')->result_array();	
               $page_data['class_notices']    = $this->db->get('classnotice')->result_array();    
  //              echo $this->session->userdata('student_class');	
		// $page_data['class_notices']  = $this->db->get_where('classnotice', array('notice_class' => $this->session->userdata('student_class')))->result_array();
  //       print_r($page_data['class_notices'] );
  //       die();
        $page_data['student_id'] = $this->stud_id;
        $page_data['class_id'] = $this->class_id;
        $page_data['class_name'] = $this->class_name;
        $page_data['section'] = 'student';
        $page_data['section_name'] = $this->section_name;
        $page_data['page_name'] = 'noticeboard';
        $page_data['page_title'] = get_phrase('noticeboard');
        $this->load->view('index', $page_data);
    }

    /*     * ********MANAGE DOCUMENT / home work FOR A SPECIFIC CLASS or ALL****************** */

    function document($do = '', $document_id = '') {

        if ($this->session->userdata('student_login') != 1)
            redirect('login', 'refresh');



        $page_data['page_name'] = 'manage_document';

        $page_data['page_title'] = get_phrase('manage_documents');

        $page_data['documents'] = $this->db->get('document')->result_array();

        $this->load->view('index', $page_data);
    }

    /*     * ****MANAGE OWN PROFILE AND CHANGE PASSWORD** */

    function manage_profile($param1 = '', $param2 = '', $param3 = '') {

        if ($this->session->userdata('student_login') != 1)
            redirect(base_url() . 'login', 'refresh');

        if ($param1 == 'update_profile_info') {

            $data['name'] = $this->input->post('name');

            $data['birthday'] = $this->input->post('birthday');

            $data['sex'] = $this->input->post('sex');

            $data['religion'] = $this->input->post('religion');

            $data['blood_group'] = $this->input->post('blood_group');

            $data['address'] = $this->input->post('address');

            $data['phone'] = $this->input->post('phone');

            $data['email'] = $this->input->post('email');



            $this->db->where('student_id', $this->session->userdata('student_id'));

            $this->db->update('student', $data);

            $this->session->set_flashdata('flash_message', get_phrase('account_updated'));

            redirect(base_url() . 'student/manage_profile/', 'refresh');
        }

        if ($param1 == 'change_password') {

            $data['password'] = $this->input->post('password');

            $data['new_password'] = $this->input->post('new_password');

            $data['confirm_new_password'] = $this->input->post('confirm_new_password');



            $current_password = $this->db->get_where('student', array(
                        'student_id' => $this->session->userdata('student_id')
                    ))->row()->password;

            if ($current_password == $data['password'] && $data['new_password'] == $data['confirm_new_password']) {

                $this->db->where('student_id', $this->session->userdata('student_id'));

                $this->db->update('student', array(
                    'password' => $data['new_password']
                ));

                $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
            } else {

                $this->session->set_flashdata('flash_message', get_phrase('password_mismatch'));
            }

            redirect(base_url() . 'student/manage_profile/', 'refresh');
        }

        $page_data['page_name'] = 'manage_profile';

        $page_data['page_title'] = get_phrase('manage_profile');

        $page_data['edit_data'] = $this->db->get_where('student', array(
                    'student_id' => $this->session->userdata('student_id')
                ))->result_array();

        $this->load->view('index', $page_data);
    }

    /*     * **MANAGE ATTENDENCE**** */

    function attendence($class_id = '', $month = '') {
        if ($this->session->userdata('login_type') != 'student')
            redirect(base_url(), 'refresh');

        $today = date('y-m-d');

        $status = $this->dbconnection->select("student_attendance", "attendance", "student_id=" . $this->stud_id . " and date='$today'");
        if (count($status) > 0) {
            if ($status[0]->attendance == 'P') {
                $attendance = 'Present';
            } else {
                $attendance = 'Absent';
            }
        } else if (count($status) <= 0) {
            $attendance = 'Attendance not Recorded';
        }
        $session = $this->dbconnection->select("accedemic_session", "*", "status='Y'");
        $i = 0;
        foreach ($session as $row) {
            $page_data['session'][$i] = $row->session;
            $page_data['sess_id'][$i] = $row->id;
            $i++;
        }


        $page_data['attend'] = $attendance;
        $page_data['count'] = $i;
        $page_data['class_name'] = $this->class_name;
        $page_data['section'] = 'student';
        $page_data['section_name'] = $this->section_name;
        $page_data['month'] = $month;
        $page_data['page_info'] = 'Attendence';
        $page_data['page_name'] = 'attendence';
        $page_data['page_title'] = 'My Attendance';
        $this->load->view('index', $page_data);
    }

    function month_attendance() {
        if ($this->session->userdata('login_type') != 'student')
            redirect(base_url(), 'refresh');
        $fetch_stud_attendance_report = $this->dbconnection->select("student", "id,admission_no,concat(first_name,' ',middle_name,' ',last_name) as name", "class_id=$this->class_id and section_id=$this->section_id and status='Y'");
        $mnth = $this->input->post('month');
        $user = $this->session->userdata('user_name');
        $admsn = explode('-', $user);
        $attendance = $this->dbconnection->select("student_attendance", "count(id) as cnt", "attendance='P' and MONTH(date)='$mnth' and admission_no='$admsn[1]'");
        $date = new DateTime('last day of this month');
        $numDaysOfCurrentMonth = $date->format('d');
        $present = $attendance[0]->cnt;
        $absent = $numDaysOfCurrentMonth - $present;

        $responce->cols[] = array(
            "id" => 'A',
            "label" => "Topping",
            "pattern" => "",
            "type" => "string"
        );
        $responce->cols[] = array(
            "id" => 'B',
            "label" => "Total",
            "pattern" => "",
            "type" => "number"
        );

        $responce->rows[]["c"] = array(
            array(
                "v" => "Total Present",
                "f" => null
            ),
            array(
                "v" => 3.33 * $present,
                "f" => null
            )
        );

        $responce->rows[]["c"] = array(
            array(
                "v" => "Total Absent",
                "f" => null
            ),
            array(
                "v" => 3.33 * $absent,
                "f" => null
            )
        );


        $page_data['yr'] = $this->input->post('year');
        ;
        $page_data['total_days'] = $this->input->post('total_days');
        $page_data['total_off_days'] = $this->input->post('total_sun');
        $page_data['each_sunday'] = $this->input->post('weekend');
        $page_data['total_work'] = $this->input->post('total_work');
        $page_data['class_id'] = $this->class_id;
        $page_data['student_id'] = $this->stud_id;
        $page_data['name'] = $fetch_stud_attendance_report[0]->name;
        $page_data['adm'] = $fetch_stud_attendance_report[0]->admission_no;
        $page_data['section'] = 'student';
        $page_data['section_name'] = $this->section_name;
        $page_data['month'] = $this->input->post('month');
        $page_data['page_info'] = 'Attendence';
        $page_data['page_name'] = 'monthly_attendance';
        $page_data['page_title'] = 'My Attendance';
        $this->load->view('student/monthly_attendance', $page_data);
    }

    function email() {
        $login_type = $this->session->userdata('login_type');
        $user_id = $this->session->userdata($login_type . '_id');
        $page_data['result'] = $this->db->get_where('email', array('type' => 'student'))->result_array();
        foreach ($page_data['result'] as $row) {
            $id = $row['id'];
            $unread = explode(',', $row['unread']);
            $read = explode(',', $row['read']);
            if (($key = array_search($user_id, $unread)) !== false) {
                unset($unread[$key]);
                $read[] = $user_id;
            }
            $data['read'] = implode(',', $read);
            $data['unread'] = implode(',', $unread);
            $this->db->where('id', $id);
            $this->db->update('email', $data);
        }
        $page_data['page_info'] = 'emailview';
        $page_data['user_id'] = $user_id;
        $page_data['page_name'] = 'email_view';
        $page_data['page_title'] = get_phrase('email_view');
        $this->load->view('index', $page_data);
    }

    function email_delete($param1) {
        $email_id = $param1;
        $login_type = $this->session->userdata('login_type');
        $user_id = $this->session->userdata($login_type . '_id');
        $result = $this->db->get_where('email', array('id' => $email_id))->row();
        $unread = explode(',', $result->unread);
        $read = explode(',', $result->read);
        if (($key = array_search($user_id, $unread)) !== false) {
            unset($unread[$key]);
        }
        if (($key = array_search($user_id, $read)) !== false) {
            unset($read[$key]);
        }
        $data['read'] = implode(',', $read);
        $data['unread'] = implode(',', $unread);
        $this->db->where('id', $email_id);
        $this->db->update('email', $data);
        redirect(base_url() . "" . $login_type . "/email");
    }

    function view_attendance_chart() {
        $login_type = $this->session->userdata('login_type');
        $user_id = $this->session->userdata($login_type . '_id');
        $this->db->select('*');
        $this->db->from('attendence');
        $this->db->where('student_id', $user_id);
        $this->db->order_by("month", "asc");
        $query = $this->db->get();
        $results = $query->result_array();
        foreach ($results as $result) {
            $present[$result['month']] = $result['present'];
        }
        for ($i = 1; $i <= 12; $i++) {
            if (!key_exists($i, $present)) {
                $present[$i] = 0;
            }
        }
        ksort($present);
        $prsent_day = '[' . implode(',', $present) . ']';

        $this->db->select('*');
        $this->db->from('workingdays');
        $this->db->order_by("work_id", "asc");
        $query = $this->db->get();
        $results1 = $query->result_array();
        foreach ($results1 as $result1) {
            $work[$result1['work_id']] = $result1['total_days'];
        }
        for ($i = 1; $i <= 12; $i++) {
            if (!key_exists($i, $work)) {
                $work[$i] = 0;
            }
        }
        ksort($work);
        $work_day = '[' . implode(',', $work) . ']';
        $page_data['page_info'] = 'attendence_view';
        $page_data['work_day'] = $work_day;
        $page_data['present_day'] = $prsent_day;
        $page_data['user_id'] = $user_id;
        $page_data['page_name'] = 'attendence_view';
        $page_data['page_title'] = get_phrase('attendence_view');
        $this->load->view('index', $page_data);
    }

    function view_mark_chart() {
        error_reporting(1);
        $login_type = $this->session->userdata('login_type');
        $user_id = $this->session->userdata($login_type . '_id');
        $exam_id = $this->input->post('exam_id');
        if (isset($exam_id) && (!empty($exam_id))) {
            $this->db->select('mark.*,subject.*,subject.name as sname, exam.*');
            $this->db->from('mark');
            $this->db->join('subject', 'mark.subject_id = subject.subject_id');
            $this->db->join('exam', 'mark.exam_id = exam.exam_id');
            $this->db->where(array('mark.student_id' => $user_id, 'mark.exam_id' => $exam_id));
            $page_data['exam_id'] = $exam_id;
        } else {
            $this->db->select('*');
            $this->db->from('mark');
            $this->db->join('subject', 'mark.subject_id = subject.subject_id');
            $this->db->where('mark.student_id', $user_id);
        }
        $query = $this->db->get();
        $results = $query->result_array();

        foreach ($results as $result) {
            $subject[] = "'" . $result['sname'] . "'";
            $mark[] = $result['mark_obtained'];
            $subject_total[] = $result['grand_total'];
            $page_data['chart_title'] = $result['exam_name'];
        }

        $page_data['subject_obtain'] = '[' . implode(',', $subject) . ']';
        $page_data['subject_total'] = '[' . implode(',', $subject_total) . ']';
        $page_data['mark'] = '[' . implode(',', $mark) . ']';
        $page_data['page_info'] = 'mark_view';
        $page_data['user_id'] = $user_id;
        $page_data['page_name'] = 'mark_view';

        $page_data['page_title'] = get_phrase('mark_view');
        $this->load->view('index', $page_data);
    }

    function tasks() {

        if ($this->session->userdata('student_login') != 1)
            redirect('login', 'refresh');

        $login_type = $this->session->userdata('login_type');
        $user_id = $this->session->userdata($login_type . '_id');

        $this->load->model('task_model');
        $page_data['tasks_data'] = $this->task_model->gettasks($user_id, $login_type);

        $page_data['page_info'] = 'tasks_view';
        $page_data['page_name'] = 'tasks_view';
        $page_data['page_title'] = get_phrase('tasks_view');
        $this->load->view('index', $page_data);
    }

    function taskadd() {

        if ($this->session->userdata('student_login') != 1)
            redirect('login', 'refresh');

        $page_data['page_info'] = 'task_add';
        $page_data['page_name'] = 'task_add';
        $page_data['page_title'] = get_phrase('task_add');
        $this->load->view('index', $page_data);
    }

    function taskedit($tid) {

        if ($this->session->userdata('student_login') != 1)
            redirect('login', 'refresh');
        $this->load->model('task_model');
        $page_data['task_data'] = $this->task_model->gettask($tid);

        $page_data['page_info'] = 'task_edit';
        $page_data['page_name'] = 'task_edit';
        $page_data['page_title'] = get_phrase('task_edit');
        $this->load->view('index', $page_data);
    }

    function taskinsert() {

        if ($this->session->userdata('student_login') != 1)
            redirect('login', 'refresh');

        $login_type = $this->session->userdata('login_type');
        $user_id = $this->session->userdata($login_type . '_id');

        $taskdata['task_title'] = $this->input->post('task_title');
        $taskdata['task_description'] = $this->input->post('task_description');
        $taskdata['task_start_date'] = date("Y-m-d", strtotime($this->input->post('task_start_date')));
        $taskdata['task_end_date'] = date("Y-m-d", strtotime($this->input->post('task_end_date')));
        $taskdata['task_status'] = $this->input->post('task_status');
        $taskdata['task_user_type'] = $login_type;
        $taskdata['task_user_id'] = $user_id;
        $taskdata['task_added_date'] = date('Y-m-d H:i:s');
        $taskdata['task_modified_date'] = date('Y-m-d H:i:s');

        $this->load->model('task_model');

        $res = $this->task_model->insert_task($taskdata);

        if ($res) {

            $this->session->set_flashdata('msg', 'true');
            $this->session->set_flashdata('task_title', $this->input->post('task_title'));
            redirect(base_url() . '' . $login_type . '/tasks', 'refresh');
        }
    }

    function taskupdate() {

        if ($this->session->userdata('student_login') != 1)
            redirect('login', 'refresh');

        $login_type = $this->session->userdata('login_type');
        $user_id = $this->session->userdata($login_type . '_id');

        $tid = $this->input->post('hid_tid');

        if ($tid != '') {

            $taskdata['task_title'] = $this->input->post('task_title');
            $taskdata['task_description'] = $this->input->post('task_description');
            $taskdata['task_start_date'] = date("Y-m-d", strtotime($this->input->post('task_start_date')));
            $taskdata['task_end_date'] = date("Y-m-d", strtotime($this->input->post('task_end_date')));
            $taskdata['task_status'] = $this->input->post('task_status');
            $taskdata['task_user_type'] = $login_type;
            $taskdata['task_user_id'] = $user_id;
            $taskdata['task_modified_date'] = date('Y-m-d H:i:s');

            $this->load->model('task_model');

            $res = $this->task_model->update_task($taskdata, $tid);

            if ($res) {

                $this->session->set_flashdata('msg', 'add_true');
                $this->session->set_flashdata('task_title', $this->input->post('task_title'));
                redirect(base_url() . '' . $login_type . '/tasks', 'refresh');
            }
        }
    }

    function taskdelete($tid) {

        if ($this->session->userdata('student_login') != 1)
            redirect('login', 'refresh');

        $login_type = $this->session->userdata('login_type');
        $user_id = $this->session->userdata($login_type . '_id');
        $this->load->model('task_model');


        $res = $this->task_model->delete_task($tid);

        if ($res) {

            $this->session->set_flashdata('msg', 'del_true');
            $this->session->set_flashdata('task_title', $this->input->post('task_title'));
            redirect(base_url() . '' . $login_type . '/tasks', 'refresh');
        }
    }

    function datecompare() {

        $date_1 = $this->input->post('startDate');
        $date_2 = $this->input->post('endDate');

        if (strtotime($date_2) >= strtotime($date_1)) {
            echo "true";
        } else {
            echo "false";
        }
    }

    /*     * **VIEW DAILYATTENDENCE**** */

    function dailyattendence() {
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url(), 'refresh');

        $login_type = $this->session->userdata('login_type');
        $user_id = $this->session->userdata($login_type . '_id');

        $this->db->where('student_id', $user_id);
        $query = $this->db->get_where('daily_attendence');
        $addata = $query->result();
        $page_data['ad_data'] = $addata;

        $page_data['page_info'] = 'Daily Attendence';
        $page_data['page_name'] = 'daily_attendence';
        $page_data['page_title'] = get_phrase('daily_attendence');
        $this->load->view('index', $page_data);
    }

    /*     * **VIEW PLACEMENTS**** */

    function placements() {
        if ($this->session->userdata('login_type') != 'student')
            redirect(base_url(), 'refresh');

        $page_data['student_id'] = $this->stud_id;
        $page_data['class_id'] = $this->class_id;
        $page_data['class_name'] = $this->class_name;
        $page_data['section'] = 'student';
        $page_data['section_name'] = $this->section_name;

        $this->load->model('placement_model');
        $page_data['placement_data'] = $this->placement_model->getplacementsactive();
        $page_data['page_name'] = 'placements';
        $page_data['page_title'] = get_phrase('view_placements');
        $this->load->view('index', $page_data);
    }

    /*     * **VIEW TIMETABLE**** */

    function timetables() {
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url(), 'refresh');
        $this->db->select('timetables.*,timetable_categories.timetable_category_name as cname');
        $this->db->from('timetables,timetable_categories');
        $this->db->where('timetables.timetable_cid = timetable_categories.timetable_category_id');
        $this->db->where('timetable_status', 'active');
        $this->db->where('timetable_delete', 'N');
        $this->db->order_by('timetable_modified_date', desc);
        $page_data['timetable_view'] = $this->db->get()->result_array();
        $page_data['page_name'] = 'timetables';
        $page_data['page_title'] = get_phrase('timetables');
        $this->load->view('index', $page_data);
    }

    function feecollect() {

        if ($this->session->userdata('student_login') != 1)
            redirect(base_url(), 'refresh');

        $login_type = $this->session->userdata('login_type');
        $user_id = $this->session->userdata($login_type . '_id');
        $this->db->select('student_id,class_id,roll,name');
        $this->db->where('student_id', $user_id);
        $query = $this->db->get_where('student');

        $cdata = $query->row_array();
        extract($cdata);

        $fc_cid = $class_id;

        $fc_rollid = $user_id;

        $this->load->model('fee_model');

        $page_data['fcollectclassdata'] = $this->fee_model->getfeeclassdata($fc_cid);

        $page_data['fcollectalldata'] = $this->fee_model->getfeealldata($fc_cid);

        $page_data['fcollectrolldata'] = $this->fee_model->getfeerolldata($fc_cid, $fc_rollid);

//$page_data['fcollectstandarddata'] = $this->fee_model->getfeestandarddata($fc_cid);

        $page_data['class_roll_data'] = array('fc_class_id' => $fc_cid, 'fc_roll_id' => $fc_rollid);

        $page_data['stddata'] = $cdata;


        $page_data['page_name'] = 'feecollect';
        $page_data['page_title'] = get_phrase('payment_list');
        $this->load->view('index', $page_data);
    }

    function fee_pay_history() {

        $sdnt_id = $this->input->post('sid');
        $petr_id = $this->input->post('pid');

        $this->load->model('fee_model');

        $payhisdata = $this->fee_model->getPayData($sdnt_id, $petr_id);



        $paydata = "";

        $paydata .= "<table class='table table-bordered'<tr><th>Receipt No </th><th> Pay Amount </th><th> Late Charge </th><th> Mode </th><th> Date </th><tr>";

        foreach ($payhisdata as $payhisdata_view) {

            $mode = $payhisdata_view->fee_collection_mode;

            if ($mode == 0) {
                $md_val = "Cash";
            } else if ($mode == 1) {
                $md_val = "Cheque";
            }

            $paydata .= '<tr><td>' . $payhisdata_view->fee_collection_receipt . '</td><td>' . $payhisdata_view->fee_collection_amount . '</td><td>' . $payhisdata_view->fee_collection_late_charge . '</td><td>' . $md_val . '</td><td>' . date("d-m-Y", strtotime($payhisdata_view->fee_collection_date)) . '</td></tr>';
        }

        $paydata .= "</table>";

        echo $paydata;
    }

    function googlenews() {
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url(), 'refresh');

        $page_data['page_name'] = 'googlenews';
        $page_data['page_title'] = get_phrase('google_news');
        $this->load->view('index', $page_data);
    }
    
    
    function payment_history() {
        
     
        $this->paydata=[
//            'transaction_history' => $this->db->query("select f1.*,group_concat(distinct(f2.fee_cat_id)) as fee,count(case when f2.month_no<>0 then f2.month_no end) as m,min(case when f2.month_no<>0 then f2.month_no end) as from_month,max(f2.due_month_no) as d from fee_transaction_head f1, fee_transaction_det f2 where f1.student_id=$this->stud_id and f1.year=$year and status=1 and paid_status=1 and f1.response_message is not NULL and f1.id=f2.fee_trans_head_id group by f1.id order by f1.payment_date"),
            'transaction_history' => $this->db->query("select f1.*,group_concat(distinct(f2.fee_cat_id)) as fee,count(case when f2.month_no<>0 then f2.month_no end) as m,min(case when f2.month_no<>0 then f2.month_no end) as from_month,max(f2.due_month_no) as d from fee_transaction_head f1, fee_transaction_det f2 where f1.student_id=$this->stud_id  and status=1 and paid_status=1 and f1.response_message is not NULL and f1.id=f2.fee_trans_head_id group by f1.id order by f1.payment_date"),
            'page_name'               => 'view_payment',
            'page_title'              => 'Payment History',
            'section'                 => 'student',
            'customview'              => '',
            'acedemic_session'        => $this->dbconnection->select("accedemic_session", "id,start_date,end_date,session", "status='Y'")
                ];
        $this->load->view('index',$this->paydata);
    }

    function view_tutorial() {
        if ($this->session->userdata('login_type') != 'student')
            redirect(base_url(), 'refresh');

        $page_data['student_id'] = $this->stud_id;
        $page_data['class_id'] = $this->class_id;
        $page_data['class_name'] = $this->class_name;
        $page_data['section'] = 'academic/Tutorial';
        $page_data['page_name'] = 'student_tutorial';

        $video_tutorial = $this->db->query('select t1.id,t1.class_id,(select class_name from class where id=t1.class_id) as class_name,t1.subject_id,(select name from subject where id=t1.subject_id) as subject_name,t1.video_url,t1.title,t1.image_video,t1.lesson_date from video_tutorial t1 where t1.status="Y" and t1.class_id='.$this->class_id)->result();
        if(!empty($video_tutorial)){
            $page_data['tutorial']=$video_tutorial;
        }
        $page_data['page_title'] = 'View Tutorial';
        $this->load->view('index', $page_data);
    }
    function GetVideoUrl()
    {
         $id=$this->input->post('id');
        $video_tutorial = $this->db->query('select t1.id,t1.class_id,(select class_name from class where id=t1.class_id) as class_name,t1.subject_id,(select name from subject where id=t1.subject_id) as subject_name,t1.video_url,t1.title,t1.image_video,t1.lesson_date from video_tutorial t1 where t1.status="Y" and t1.id='.$id)->result();
        $video_url=$video_tutorial[0]->video_url;
        $title=$video_tutorial[0]->title;
        $subject_id=$video_tutorial[0]->subject_id;
        $subject_name=$video_tutorial[0]->subject_name;
        $array=array('title'=>$title,'video_url'=>$video_url,'subject_id'=>$subject_id,'subject_name'=>$subject_name);
        echo json_encode($array);
    }

     public function upload_homework()
    {
         $id=$this->input->post('home_id');

       $sch_id=$this->session->userdata('school_id');
        $photoimg_name=$_FILES['upload_data']['name'];
        $pic_img_name=$sch_id.'_'.time();
        $fileExt = pathinfo($photoimg_name, PATHINFO_EXTENSION);
        $photoimg_upload_name=$pic_img_name;
        $config['upload_path'] = 'homework/answer';
        $config['allowed_types'] = 'jpg|png|jpeg|pdf|msword';
        $config['file_name'] =$photoimg_upload_name;
        $config['overwrite'] = false;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if($this->upload->do_upload('home_upload'))
        {  
            $uploadData_1 = $this->upload->data();
            $image = $uploadData_1['file_name'];             
            $new_name = $sch_id.'_'.time().$uploadData_1['file_ext']; 
            $data=  array(
                'assignment_id'=>$id,
                'student_id'=>$this->stud_id,
                'homework_upload' => $new_name,
                'homework_status' =>'SUBMITTED',
            );
            
            
        }
        $this->dbconnection->insert('assignment_answer',$data);
            echo '<script>
            alert("Successfully Submitted");
                        window.location.assign("assignments"); 
                 </script>';
    }


    public function student_view_ncert() {

       $student_id = $this->stud_id;
        $class_id = $this->class_id;
        $section_id = $this->section_id;
        $class_name = $this->class_name;

        $this->data['page_name'] = 'student_view_ncert';
        $this->data['page_title'] = 'View Books PDF';
        $this->data['section'] = 'ebooks';
        $this->data['customview'] = $this->customview;
        // $this->data['right_access']  = $this->right_access;

        $this->data['homework'] = $this->dbconnection->dbcon_ebook_pdf_student($this->class_id,$this->section_id);
        // print_r($this->data['homework']);
        // die();
        // $this->data['homework'] = $this->dbconnection->select('ebooks_pdf','*','status=1');
        $this->load->view('index', $this->data);
    }

     public function student_notes() {
        $this->data['page_name'] = 'student_notes';
        $this->data['page_title'] = 'Notes';
        $this->data['section'] = 'ebooks';
        $this->data['customview'] = $this->customview;

         $class_id = $this->class_id;
        $section_id = $this->section_id;
       
        $this->data['notes'] = $this->db->query("select t1.id as id,t1.class_id,(select class_name from class where id=t1.class_id) as class_name,t1.section_id,(select sec_name from section where id=t1.section_id) as section_name,t1.dop,t1.description,t1.subject_id,(select name from subject where id=t1.subject_id) as subject_name,t1.attachment from notes t1 where t1.status='1' and t1.class_id=$class_id and t1.section_id=$section_id")->result();
       // print_r($this->data['notes']);
       //  die();
        $this->load->view('index', $this->data);
    }


}
