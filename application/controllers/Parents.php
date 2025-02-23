<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/* 	
 * 	@author : Joyonto Roy
 * 	date	: 20 August, 2013
 * 	University Of Dhaka, Bangladesh
 * 	Ekattor School & College Management System
 * 	http://codecanyon.net/user/joyontaroy
 */

class Parents extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		if (empty($this->session->userdata('user_id'))) {
			redirect('/login');
		}

		$this->total_school=$this->dbconnection->select("school","count(*) as cnt","status=1");
		$this->school1=$this->dbconnection->select('school','*','id = '.$this->session->userdata('school_id'));

		$this->id=$this->session->userdata('school_id');

		if ($this->id !=0) {
			$this->db->db_select('crmfeesclub_'.$this->id);
			$this->user= $this->dbconnection->select('user','*','id = '.$this->session->userdata('user_id'));
			$this->total_user=$this->dbconnection->select("user","count(*) as users");
		} else {
			$this->user= $this->dbconnection->select('user','*','id = '.$this->session->userdata('user_id'));
			$this->total_user=$this->dbconnection->select("user","count(*) as users"); 
		}
    }

    /*     * *default functin, redirects to login page if no admin logged in yet** */

    public function index() {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url() . 'login', 'refresh');
        if ($this->session->userdata('parent_login') == 1)
            redirect(base_url() . 'parents/dashboard', 'refresh');
    }

    /*     * *ADMIN DASHBOARD** */

    function dashboard() {
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');
         $this->load->model('core_model');
        $login_type = $this->session->userdata('login_type');
        $user_id = $this->session->userdata($login_type . '_id');
        $results = $this->db->get_where('email', array('type' => strtolower($login_type)))->result_array();
        $i = 0;
        foreach ($results as $result) {
            $unread = explode(',', $result['unread']);
            if (in_array($user_id, $unread)) {
                $i++;
            }
        }
         $res_query = array(
			'where'  => array('user_id'=>$user_id, 'status'=>'1')
		);
	$count_unread_message   = $this->core_model->get_count($res_query, 'parent_enquiry');
	$page_data['count_unread_message'] = $count_unread_message;
	/*  Daily Attendence by Elite on 27-08-2014  */
			
			$ad_sid = $user_id;
			
			$ad_pdate = date('Y-m-d');
			
			$this->db->where('student_id',$ad_sid);
			
			$this->db->where('present_date',$ad_pdate);
			
			$res = $this->db->get_where('daily_attendence');
			
			$page_data['ad_data'] = $res -> row_array();
			
			
			
			
			/*  Daily Attendence by Elite on 27-08-2014  */
        $page_data['page_name'] = 'dashboard';
        $page_data[$login_type . '_message'] = $i;
        $page_data['page_title'] = get_phrase('parent_dashboard');

        $this->load->view('index', $page_data);
    }

    /*     * **MANAGE TEACHERS**** */

    function teacher_list($param1 = '', $param2 = '', $param3 = '') {

       
//        if ($this->session->userdata('parent_login') != 1)
//            redirect(base_url(), 'refresh');

        if ($param1 == 'personal_profile') {

            $page_data['personal_profile'] = true;

            $page_data['current_teacher_id'] = $param2;
        }

        $page_data['teachers'] = $this->db->get('teacher')->result_array();

        $page_data['page_name'] = 'teacher';

        $page_data['page_title'] = get_phrase('manage_teacher');
		$page_data['page_title'] = get_phrase('teacher_list');

        $this->load->view('index', $page_data);
    }

    /*     * ******************************************************************************************************** */







    /*     * **MANAGE SUBJECTS**** */

    function subject($param1 = '', $param2 = '') {
		
		


        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');



        $parent_profile = $this->db->get_where('student', array(
                    'student_id' => $this->session->userdata('student_id')
                ))->row();

        $parent_class_id = $parent_profile->class_id;

        $page_data['subjects'] = $this->db->get_where('subject', array(
                    'class_id' => $parent_class_id
                ))->result_array();
				
				
				
				
				
		$login_type = $this->session->userdata('login_type');
        $user_id = $this->session->userdata($login_type . '_id');
		
		$this->db->select('student.class_id,class.name as cname,subject.name as sname,teacher.name as tname');
		$this->db->from('student,class,subject,teacher');
		$this->db->where('student.student_id',$user_id);
		$this->db->where('class.class_id =student.class_id and subject.class_id = student.class_id and teacher.teacher_id = subject.teacher_id');
		$query = $this->db->get_where();
		
		$page_data['psdata']= $query->result_array();
		
		
				
				

        $page_data['page_name'] = 'subject';

        $page_data['page_title'] = get_phrase('subjects_list');

        $this->load->view('index', $page_data);
    }

    /*     * **MANAGE EXAM MARKS**** */

    function marks($exam_id = '', $class_id = '', $subject_id = '') {

        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');

		$login_type = $this->session->userdata('login_type');
        $user_id = $this->session->userdata($login_type . '_id');



        $student_id = $this->db->get_where('student', array('student_id' => $this->session->userdata('parent_id')))->row()->student_id;

        $class_id = $this->db->get_where('student', array('student_id' => $student_id))->row()->class_id;

        $page_data['student_id'] = $student_id;

        $page_data['class_id'] = $class_id;

        if ($this->input->post('operation') == 'selection') {
			
			

           // $page_data['exam_id'] = $this->input->post('exam_id');

            //$page_data['class_id']	=	$this->input->post('class_id');

            //$page_data['subject_id'] = $this->input->post('subject_id');
			
			
			$login_type = $this->session->userdata('login_type');
            $user_id = $this->session->userdata($login_type . '_id');
            $exam_id = $this->input->post('exam_id');
            if(isset($exam_id) &&(!empty($exam_id))){
                $this->db->select('mark.*,subject.*,exam.name as exam_name');
                $this->db->from('mark');
                $this->db->join('subject', 'mark.subject_id = subject.subject_id');
                $this->db->join('exam', 'mark.exam_id = exam.exam_id');
                $this->db->where(array('mark.student_id' =>$user_id,'mark.exam_id' => $exam_id));
                $page_data['exam_id'] = $exam_id;
				
				
				
				 $query = $this->db->get();
            	 $results = $query->result();
				 $page_data['marks_data'] = $results;
				 
				 $this->db->select('grand_total,pass_mark');
			$this->db->where('exam_id',$exam_id);
			$res = $this->db->get_where('exam');
			
			$emgm = $res->row_array();
			extract($emgm);
			$page_data['grand_total'] = $grand_total;
			$page_data['pass_mark'] = $pass_mark;
            }



           /* if ($page_data['exam_id'] > 0 && $page_data['class_id'] > 0 && $page_data['subject_id'] > 0) {

                redirect(base_url() . 'parents/marks/' . $page_data['exam_id'] . '/' . $page_data['class_id'] . '/' . $page_data['subject_id'], 'refresh');
            }*/ else {

                $this->session->set_flashdata('mark_message', 'Choose exam, class and subject');

                redirect(base_url() . 'parents/marks/', 'refresh');
            }
        }

        //$page_data['exam_id'] = $exam_id;
        //$page_data['subject_id'] = $subject_id;
        $page_data['page_info'] = 'Exam marks';
        $page_data['page_name'] = 'marks';
        //$page_data['page_title'] = get_phrase('manage_exam_marks');
		$page_data['page_title'] = get_phrase('view_exam_marks');
        $this->load->view('index', $page_data);
    }

    /*     * ********MANAGING CLASS ROUTINE***************** */

    function class_routine($param1 = '', $param2 = '', $param3 = '') {

        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');



        $student_id = $this->db->get_where('student', array('student_id' => $this->session->userdata('parent_id')
                ))->row()->student_id;

        $class_id = $this->db->get_where('student', array('student_id' => $student_id
                ))->row()->class_id;
				
		$class_name = $this->db->get_where('class', array('class_id' => $class_id
                ))->row()->name;

        $page_data['student_id'] = $student_id;

        $page_data['class_id'] = $class_id;
		
		$page_data['class_name'] = $class_name;

        $page_data['page_name'] = 'class_routine';

        //$page_data['page_title'] = get_phrase('manage_class_routine');
		
		$page_data['page_title'] = get_phrase('class_routine_list');

        $this->load->view('index', $page_data);
    }

    /*     * ****MANAGE BILLING / INVOICES WITH STATUS**** */

    function invoice($param1 = '', $param2 = '', $param3 = '') {

        //if($this->session->userdata('parent_login')!=1)redirect(base_url() , 'refresh');

        if ($param1 == 'make_payment') {

            $invoice_id = $this->input->post('invoice_id');

            $system_settings = $this->db->get_where('settings', array(
                        'type' => 'paypal_email'
                    ))->row();

            $invoice_details = $this->db->get_where('invoice', array(
                        'invoice_id' => $invoice_id
                    ))->row();



            /*             * **TRANSFERRING USER TO PAYPAL TERMINAL*** */

            $this->paypal->add_field('rm', 2);

            $this->paypal->add_field('no_note', 0);

            $this->paypal->add_field('item_name', $invoice_details->title);

            $this->paypal->add_field('amount', $invoice_details->amount);

            $this->paypal->add_field('custom', $invoice_details->invoice_id);

            $this->paypal->add_field('business', $system_settings->description);

            $this->paypal->add_field('notify_url', base_url() . 'parents/invoice/paypal_ipn');

            $this->paypal->add_field('cancel_return', base_url() . 'parents/invoice/paypal_cancel');

            $this->paypal->add_field('return', base_url() . 'parents/invoice/paypal_success');



            $this->paypal->submit_paypal_post();

            // submit the fields to paypal
        }

        if ($param1 == 'paypal_ipn') {

            if ($this->paypal->validate_ipn() == true) {

                $ipn_response = '';

                foreach ($_POST as $key => $value) {

                    $value = urlencode(stripslashes($value));

                    $ipn_response .= "\n$key=$value";
                }

                $data['payment_details'] = $ipn_response;

                $data['payment_timestamp'] = strtotime(date("m/d/Y"));

                $data['payment_method'] = 'paypal';

                $data['status'] = 'paid';

                $invoice_id = $_POST['custom'];

                $this->db->where('invoice_id', $invoice_id);

                $this->db->update('invoice', $data);
            }
        }

        if ($param1 == 'paypal_cancel') {

            $this->session->set_flashdata('flash_message', get_phrase('payment_cancelled'));

            redirect(base_url() . 'parents/invoice/', 'refresh');
        }

        if ($param1 == 'paypal_success') {

            $this->session->set_flashdata('flash_message', get_phrase('payment_successfull'));

            redirect(base_url() . 'parents/invoice/', 'refresh');
        }

        $parent_profile = $this->db->get_where('student', array(
                    'student_id' => $this->session->userdata('student_id')
                ))->row();

        $student_id = $this->db->get_where('student', array('student_id' => $this->session->userdata('parent_id')
                ))->row()->student_id;

        $class_id = $this->db->get_where('student', array('student_id' => $student_id
                ))->row()->class_id;

        $page_data['student_id'] = $student_id;

        $page_data['class_id'] = $class_id;



        $page_data['invoices'] = $this->db->get_where('invoice', array(
                    'student_id' => $student_id
                ))->result_array();

        $page_data['page_name'] = 'invoice';

        $page_data['page_title'] = get_phrase('manage_invoice/payment');
		$page_data['page_title'] = get_phrase('invoice/payment_list');

        $this->load->view('index', $page_data);
    }

    /*     * ********MANAGE LIBRARY / BOOKS******************* */

    function book($param1 = '', $param2 = '', $param3 = '') {

        if ($this->session->userdata('parent_login') != 1)
            redirect('login', 'refresh');



        $page_data['books'] = $this->db->get('book')->result_array();

        $page_data['page_name'] = 'book';

        //$page_data['page_title'] = get_phrase('manage_library_books');
		$page_data['page_title'] = get_phrase('library_books');

        $this->load->view('index', $page_data);
    }

    /*     * ********MANAGE TRANSPORT / VEHICLES / ROUTES******************* */

    function transport($param1 = '', $param2 = '', $param3 = '') {

        if ($this->session->userdata('parent_login') != 1)
            redirect('login', 'refresh');

		$sid = $this->session->userdata('parent_id');
		
		
		$this->db->join('transport_points','pid=ppoint_id');
		$this->db->join('transport','transport.transport_id =student.transport_id');
		$this->db->where('student_id',$sid);
		$query = $this->db->get_where('student');
		
		$transports = $query->result();
		
		//print_r($transports);

        $page_data['transports'] = $transports;

        $page_data['page_name'] = 'transport';

        //$page_data['page_title'] = get_phrase('manage_transport');
		
		$page_data['page_title'] = get_phrase('transport_list');

        $this->load->view('index', $page_data);
    }

    /*     * ********MANAGE DORMITORY / HOSTELS / ROOMS ******************* */

    function dormitory($param1 = '', $param2 = '', $param3 = '') {

        if ($this->session->userdata('parent_login') != 1)
            redirect('login', 'refresh');

		$sid = $this->session->userdata('parent_id');
		
		
		$this->db->select('dormitory.name as dname,room.name as rname,student.name as sname,student.roll as sroll');
		$this->db->from('student');
		$this->db->join('dormitory','dormitory.dormitory_id = student.dormitory_id');
		$this->db->join('room','room.room_id = student.dormitory_room_number');
		$this->db->where('student_id',$sid);
		$query = $this->db->get();
		$ddata= $query->row_array();
		//print_r($ddata);

       // $page_data['dormitories'] = $this->db->get('dormitory')->result_array();
		$page_data['dormitories'] = $ddata;
        $page_data['page_name'] = 'dormitory';

        //$page_data['page_title'] = get_phrase('manage_dormitory');
		$page_data['page_title'] = get_phrase('dormitory');

        $this->load->view('index', $page_data);
    }

    /*     * ********WATCH ASSIGNMENTS ******************* */

    function assignments($param1 = '', $param2 = '', $param3 = '') {

        if ($this->session->userdata('parent_login') != 1)
            redirect('login', 'refresh');



        $page_data['assignments'] = $this->db->get('assignments')->result_array();

        $page_data['page_name'] = 'assignments';

        $page_data['page_title'] = get_phrase('assignments');

        $this->load->view('index', $page_data);
    }

    /*     * ********WATCH NOTICEBOARD AND EVENT ******************* */

    function noticeboard($param1 = '', $param2 = '', $param3 = '') {

        if ($this->session->userdata('parent_login') != 1)
            redirect('login', 'refresh');



        $page_data['notices'] = $this->db->get('noticeboard')->result_array();

        $page_data['page_name'] = 'noticeboard';

        $page_data['page_title'] = get_phrase('noticeboard');

        $this->load->view('index', $page_data);
    }

    /*     * ********MANAGE DOCUMENT / home work FOR A SPECIFIC CLASS or ALL****************** */

    function document($do = '', $document_id = '') {

        if ($this->session->userdata('parent_login') != 1)
            redirect('login', 'refresh');



        $page_data['page_name'] = 'manage_document';

        $page_data['page_title'] = get_phrase('manage_documents');

        $page_data['documents'] = $this->db->get('document')->result_array();

        $this->load->view('index', $page_data);
    }

    /*     * ****MANAGE OWN PROFILE AND CHANGE PASSWORD** */

    function manage_profile($param1 = '', $param2 = '', $param3 = '') {

        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url() . 'login', 'refresh');

        if ($param1 == 'update_profile_info') {

            $data['name'] = $this->input->post('name');

            $data['email'] = $this->input->post('email');



            $this->db->where('parent_id', $this->session->userdata('parent_id'));

            $this->db->update('parent', $data);

            $this->session->set_flashdata('flash_message', get_phrase('account_updated'));

            redirect(base_url() . 'parents/manage_profile/', 'refresh');
        }

        if ($param1 == 'change_password') {

            $data['password'] = $this->input->post('password');

            $data['new_password'] = $this->input->post('new_password');

            $data['confirm_new_password'] = $this->input->post('confirm_new_password');



            $current_password = $this->db->get_where('parent', array(
                        'parent_id' => $this->session->userdata('parent_id')
                    ))->row()->password;

            if ($current_password == $data['password'] && $data['new_password'] == $data['confirm_new_password']) {

                $this->db->where('parent_id', $this->session->userdata('parent_id'));

                $this->db->update('parent', array(
                    'password' => $data['new_password']
                ));

                $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
            } else {

                $this->session->set_flashdata('flash_message', get_phrase('password_mismatch'));
            }

            redirect(base_url() . 'parents/manage_profile/', 'refresh');
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
        if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');





        $student_id = $this->db->get_where('student', array('student_id' => $this->session->userdata('parent_id')
                ))->row()->student_id;

        $class_id = $this->db->get_where('student', array('student_id' => $student_id
                ))->row()->class_id;

        $page_data['student_id'] = $student_id;

        $page_data['class_id'] = $class_id;

        if ($this->input->post('operation') == 'selection') {

            $page_data['month'] = $this->input->post('month');
            if ($page_data['class_id'] > 0 && $page_data['month'] > 0) {
                redirect(base_url() . 'parents/attendence/' . $page_data['class_id'] . '/' . $page_data['month'], 'refresh');
            } else {
                $this->session->set_flashdata('parents_message', 'Choose class');
                redirect(base_url() . 'parents/attendence/', 'refresh');
            }
        }

        $page_data['month'] = $month;
        $page_data['page_info'] = 'Attendence';
        $page_data['page_name'] = 'attendence';
        //$page_data['page_title'] = get_phrase('manage_attendence');
		$page_data['page_title'] = get_phrase('view_monthly_attendence');
        $this->load->view('index', $page_data);
    }

    function email() {
        $login_type = $this->session->userdata('login_type');
        $user_id = $this->session->userdata($login_type . '_id');
        $page_data['result'] = $this->db->get_where('email', array('type' => 'parent'))->result_array();
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
     function view_attendance_chart(){
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
        $results = $query->result_array();
        foreach ($results as $result) {
            $work[$result['work_id']] = $result['total_days'];
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
         function view_mark_chart(){
             error_reporting(1);
            $login_type = $this->session->userdata('login_type');
            $user_id = $this->session->userdata($login_type . '_id');
            $exam_id = $this->input->post('exam_id');
            if(isset($exam_id) &&(!empty($exam_id))){
                $this->db->select('mark.*,subject.*,exam.*');
                $this->db->from('mark');
                $this->db->join('subject', 'mark.subject_id = subject.subject_id');
                $this->db->join('exam', 'mark.exam_id = exam.exam_id');
                $this->db->where(array('mark.student_id' =>$user_id,'mark.exam_id' => $exam_id));
                $page_data['exam_id'] = $exam_id;
            }
            else
            {
                $this->db->select('*');
                $this->db->from('mark');
                $this->db->join('subject', 'mark.subject_id = subject.subject_id');
                $this->db->where('mark.student_id', $user_id);
            }
            $query = $this->db->get();
            $results = $query->result_array();
           
            foreach($results as $result){
                $subject[] ="'".$result['name']."'";
                $mark[]  = $result['mark_obtained'];
                $subject_total[]  = $result['grand_total'];
                $page_data['chart_title'] = $result['exam_name']; 
            }
            
            $page_data['subject_obtain'] = '['.implode(',',$subject).']';
            $page_data['subject_total'] = '['.implode(',',$subject_total).']';
            $page_data['mark'] = '['.implode(',',$mark).']';
            $page_data['page_info'] = 'mark_view';
            $page_data['user_id'] = $user_id;
            $page_data['page_name'] = 'mark_view';
            $page_data['chk_exam_id'] = $exam_id;
            $page_data['page_title'] = get_phrase('mark_view');
            $this->load->view('index', $page_data);
            
         }
    function teacher_contact1(){
        $login_type = $this->session->userdata('login_type');
        $user_id = $this->session->userdata($login_type . '_id');
        //get  student and it class name
        $this->db->select('class.name as class_name,student.*');
        $this->db->from('student');
        $this->db->join('class', 'class.class_id =student.class_id');
        $this->db->where('student.student_id',$user_id);
        $page_data['student_detail'] = $this->db->get()->row();
      
        //get teacher  email name 
        $this->db->select('teacher.name as teacher_name,teacher.teacher_id,teacher.email,class.name');
        $this->db->from('teacher');
        $this->db->join('subject', 'subject.teacher_id =teacher.teacher_id');
        $this->db->join('class', 'class.class_id =subject.class_id');
        $this->db->where('subject.class_id', 10);
        $page_data['teacher_detail'] = $this->db->get()->result_array();
        $page_data['page_info'] = 'teacher_contact';
        $page_data['user_id'] = $user_id;
        $page_data['page_name'] = 'teacher_contact';
        $page_data['page_title'] = get_phrase('teacher_contact');
       
        $this->load->view('index', $page_data);
    }
   function teacher_enquiry(){
        $login_type = $this->session->userdata('login_type');
        $user_id    = $this->session->userdata($login_type . '_id');
        $teacher_id = $this->input->post('teacher_id');
        $class_id   = $this->input->post('class_id');
        $subject_id = $this->input->post('subject_id');
        $enquiry    = $this->input->post('enquiry');
        $data = array();
        $data['status'] = 0;
        $data['time'] = time();
        $data['user_id'] = $teacher_id;
        $data['subject_id'] = $subject_id;
        $data['class_id']   = $class_id;
        $data['user_inbox_id']  = $teacher_id;
        $data['enquiry'] = $enquiry;
        $this->db->insert('parent_enquiry', $data);
        $this->teacher_contact();
    }
    function teacher_replay(){
        $data = array();
//        $this->dynamic_load->add_css(array('href' => asset_url('css','style.css'), 'rel'  => 'stylesheet', 'type' => 'text/css'));
//        $this->dynamic_load->add_css(array('href' => asset_url('css','inbox.css'), 'rel'  => 'stylesheet', 'type' => 'text/css'));
//        $this->dynamic_load->add_css(array('href' => asset_url('css','responsive.css'), 'rel'  => 'stylesheet', 'type' => 'text/css'));
//        $this->dynamic_load->add_css(array('href' => asset_url('css','core/jquery.mCustomScrollbar.css'), 'rel'  => 'stylesheet', 'type' => 'text/css'));
//        $this->dynamic_load->add_js('footer', array('src' => asset_url('js','core/jquery.mCustomScrollbar.js'), 'type' => 'text/javascript'));
//        $this->dynamic_load->add_js('footer', array('src' => asset_url('js','app.js'), 'type' => 'text/javascript'));
//        $this->dynamic_load->add_js('footer', array('src' => asset_url('js','core/bootstrap.js'), 'type' => 'text/javascript'));
//        $this->dynamic_load->add_js('footer', array('src' => asset_url('js','inbox.js'), 'type' => 'text/javascript'));
       
        $login_type = $this->session->userdata('login_type');
        $user_id = $this->session->userdata($login_type.'_id');
        $this->load->model('core_model');
        $query = $this->db->query(
                                    "SELECT student.name as sname,teacher.name as tname,parent_enquiry.*
                                     FROM parent_enquiry
                                     LEFT JOIN student ON student.student_id  = parent_enquiry.user_id
                                     LEFT JOIN teacher  ON teacher.teacher_id = parent_enquiry.user_inbox_id
                                     WHERE parent_enquiry.user_inbox_id = '" . $user_id . "' group by parent_enquiry.user_id
                                     ORDER BY parent_enquiry.time ASC"
					);
	$page_data['messages'] = $query->result();
        $page_data['page_info'] = 'teacher_reply';
        $page_data['user_id'] = $user_id;
        $page_data['page_name'] = 'teacher_reply';
        $page_data['page_title'] = get_phrase('teacher_reply');
        $this->load->view('index', $page_data);
        
       }
       function ajax(){
        error_reporting(1);
        $login_type = $this->session->userdata('login_type');
        $user_id = $this->session->userdata($login_type.'_id');
        $return = array();
		$method = $this->input->post('method');
                $id = $this->input->post('id');
                  
		if($method === 'get_user_messages') {
		        $this->load->model('core_model');
                        $query = $this->db->query(
						"SELECT student.name as sname,teacher.name as tname,parent_enquiry.*
						 FROM parent_enquiry
						 LEFT JOIN student ON student.student_id  = parent_enquiry.user_id
						 LEFT JOIN teacher  ON teacher.teacher_id = parent_enquiry.user_inbox_id
						 WHERE parent_enquiry.user_inbox_id = '".$user_id."' and parent_enquiry.user_id = '".$id."'
						 ORDER BY parent_enquiry.time ASC"
					);
			$results  = $query->result();
                      //  echo $this->db->last_query();
                        $where = array('user_inbox_id' => $user_id);
			$update_info = array('status' => 0);
			$this->core_model->update_table($update_info, $where, 'parent_enquiry');
                	$html = $this->load->view('parent/message_body',array('results' => $results), TRUE);
			$return['html']   = $html;
			$return['status'] = 'success';
                }
                  elseif($method == 'send_message') {
		        $message = $this->input->post('message');
			$chat_id = $this->input->post('chat_user_id');
                        $class_id = $this->input->post('class_id');
			$insert_inbox_info = array();

			$insert_inbox_info['user_inbox_id'] = $chat_id;
			$insert_inbox_info['enquiry']       = $message;
			$insert_inbox_info['class_id']      = $class_id;
			$insert_inbox_info['user_id']       = $user_id;
			$insert_inbox_info['status']        = 1;
			$insert_inbox_info['time']          = time();
			$this->db->insert('parent_enquiry',$insert_inbox_info);
			$enquiry_id =  mysql_insert_id();
;
			$query = $this->db->query(
						"SELECT student.name as sname,teacher.name as tname,parent_enquiry.*
						 FROM parent_enquiry
						 LEFT JOIN student ON student.student_id  = parent_enquiry.user_id
						 LEFT JOIN teacher  ON teacher.teacher_id = parent_enquiry.user_inbox_id
						 WHERE parent_enquiry.id = '".$enquiry_id."'
						 ORDER BY parent_enquiry.time ASC"
					);
			$results  = $query->result();

			$html = $this->load->view('parent/message_body', array('results' => $results), TRUE);
			$return['html']   = $html;
			$return['status'] = 'success';
		
		}
                echo json_encode($return);
		exit;
        }
		
		/****VIEW DAILYATTENDENCE*****/
		function dailyattendence(){
			if ($this->session->userdata('parent_login') != 1)
            redirect(base_url(), 'refresh');
			
			$login_type = $this->session->userdata('login_type');
            $user_id = $this->session->userdata($login_type.'_id');
			
			$this->db->where('student_id',$user_id);
			$query=$this->db->get_where('daily_attendence');
			$addata = $query->result();
			$page_data['ad_data'] = $addata;
			
			$page_data['page_info'] = 'Daily Attendence';
        	$page_data['page_name'] = 'daily_attendence';
        	$page_data['page_title'] = get_phrase('daily_attendence');
        	$this->load->view('index', $page_data);
		}
		
		/****VIEW PLACEMENTS*****/
		function placements()
		{
			if ($this->session->userdata('parent_login') != 1)
				redirect(base_url(), 'refresh');
			$this->load->model('placement_model');
			$page_data['placement_data'] = $this->placement_model->getplacementsactive();
			$page_data['page_name']  = 'placements';
			$page_data['page_title'] = get_phrase('view_placements');
			$this->load->view('index', $page_data);
		}
		/****VIEW TIMETABLE*****/
		function timetables()
		{
			if ($this->session->userdata('parent_login') != 1)
			redirect(base_url(), 'refresh');
			$this->db->select('timetables.*,timetable_categories.timetable_category_name as cname');
			$this->db->from('timetables,timetable_categories');
			$this->db->where('timetables.timetable_cid = timetable_categories.timetable_category_id');
			$this->db->where('timetable_status','active');
			$this->db->where('timetable_delete','N');
			$this->db->order_by('timetable_modified_date',desc);
			$page_data['timetable_view']   = $this->db->get()->result_array();
			$page_data['page_name']  = 'timetables';
			$page_data['page_title'] = get_phrase('timetables');
			$this->load->view('index', $page_data);
		}
		
		function feecollect(){
		
			if ($this->session->userdata('parent_login') != 1)
				redirect(base_url(), 'refresh');
				
				$login_type = $this->session->userdata('login_type');
                $user_id = $this->session->userdata($login_type.'_id');
				$this->db->select('student_id,class_id,roll,name');
				$this->db->where('student_id',$user_id);
				$query = $this->db->get_where('student');
				
				$cdata = $query->row_array();
				extract($cdata);
				
				$fc_cid = $class_id;
		
		        $fc_rollid = $user_id;
		
		$this->load->model('fee_model');
		
		$page_data['fcollectclassdata'] = $this->fee_model->getfeeclassdata($fc_cid);
		
		$page_data['fcollectalldata'] = $this->fee_model->getfeealldata($fc_cid);
		
		$page_data['fcollectrolldata'] = $this->fee_model->getfeerolldata($fc_cid,$fc_rollid);
		
		//$page_data['fcollectstandarddata'] = $this->fee_model->getfeestandarddata($fc_cid);
		
		$page_data['class_roll_data'] = array('fc_class_id' => $fc_cid, 'fc_roll_id' => $fc_rollid);
			
			$page_data['stddata'] = $cdata;
			
			
			$page_data['page_name']  = 'feecollect';
			$page_data['page_title'] = get_phrase('payment_list');
			$this->load->view('index', $page_data);
			
			
		}
		
		function fee_pay_history(){
		
		$sdnt_id = $this->input->post('sid');
		$petr_id = $this->input->post('pid');
		
		 $this->load->model('fee_model');
		 
		 $payhisdata = $this->fee_model->getPayData($sdnt_id,$petr_id);
		 
		
		
		$paydata ="";
		
		$paydata .="<table class='table table-bordered'<tr><th>Receipt No </th><th> Pay Amount </th><th> Late Charge </th><th> Mode </th><th> Date </th><tr>";
		
		foreach($payhisdata as $payhisdata_view){
			
			$mode = $payhisdata_view->fee_collection_mode;
			
			if($mode == 0){
				$md_val = "Cash";
			} else if($mode == 1){
				$md_val = "Cheque";
			}
			
			$paydata .='<tr><td>'.$payhisdata_view->fee_collection_receipt.'</td><td>'.$payhisdata_view->fee_collection_amount.'</td><td>'.$payhisdata_view->fee_collection_late_charge.'</td><td>'.$md_val.'</td><td>'.date("d-m-Y",strtotime($payhisdata_view->fee_collection_date)).'</td></tr>';
			
		}
		
		$paydata .="</table>";
		
		echo $paydata;
		
		
	}
	
	

			
		
}
