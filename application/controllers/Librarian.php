<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*	

 *	@author : Joyonto Roy

 *	date	: 20 August, 2013

 *	University Of Dhaka, Bangladesh

 *	Ekattor School & College Management System

 *	http://codecanyon.net/user/joyontaroy

 */



class Librarian extends CI_Controller

{
   function __construct()
    {
        parent::__construct();
		//
		
	    //
		$this->load->database();
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		$this->load->helper('tam_helper');
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

    

    /***default functin, redirects to login page if no admin logged in yet***/

    public function index()

    {
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url() . 'login', 'refresh');
      if ($this->session->userdata('student_login') == 1){
         
		redirect(base_url() . 'librarian/dashboard', 'refresh');
			}
     }

    

    /***ADMIN DASHBOARD***/

    function dashboard()

    {
	    
        $page_data['page_name'] = 'dashboard';       
        $page_data['page_name']  = 'dashboard';

        $page_data['page_title'] = get_phrase('librarian_dashboard');		
        $this->load->view('index', $page_data);

    }

    

    

    /****MANAGE TEACHERS*****/

    function teacher_list($param1 = '', $param2 = '', $param3 = '')

    {

        if ($this->session->userdata('student_login') != 1)

            redirect(base_url(), 'refresh');

        if ($param1 == 'personal_profile') {

            $page_data['personal_profile']   = true;

            $page_data['current_teacher_id'] = $param2;

        }

        $page_data['teachers']   = $this->db->get('teacher')->result_array();

        $page_data['page_name']  = 'teacher';

        $page_data['page_title'] = get_phrase('teacher_list');

        $this->load->view('index', $page_data);

    }
   
    /****MANAGE SUBJECTS*****/

    function subject($param1 = '', $param2 = '')
     {
        if ($this->session->userdata('student_login') != 1)
        redirect(base_url(), 'refresh');
        $student_profile         = $this->db->get_where('student', array(
            'student_id' => $this->session->userdata('student_id')))->row();

        $student_class_id        = $student_profile->class_id;
        $page_data['subjects']   = $this->db->get_where('subject', array(
            'class_id' => $student_class_id))->result_array();

        $page_data['page_name']  = 'subject';

        $page_data['page_title'] = get_phrase('subject_list');

        $this->load->view('index', $page_data);

     }   
    

    

    

    /****MANAGE EXAM MARKS*****/

    function marks($exam_id = '', $class_id = '', $subject_id = '')

    {

        if ($this->session->userdata('student_login') != 1)

            redirect(base_url(), 'refresh');

        

        $student_profile       = $this->db->get_where('student', array(

            'student_id' => $this->session->userdata('student_id')

        ))->row();

        $page_data['class_id'] = $student_profile->class_id;

        

        if ($this->input->post('operation') == 'selection') {

            $page_data['exam_id']    = $this->input->post('exam_id');

            //$page_data['class_id']	=	$this->input->post('class_id');

            $page_data['subject_id'] = $this->input->post('subject_id');

            

            if ($page_data['exam_id'] > 0 && $page_data['class_id'] > 0 && $page_data['subject_id'] > 0) {

                redirect(base_url() . 'student/marks/' . $page_data['exam_id'] . '/' . $page_data['class_id'] . '/' . $page_data['subject_id'], 'refresh');

            } else {

                $this->session->set_flashdata('mark_message', 'Choose exam, class and subject');

                redirect(base_url() . 'student/marks/', 'refresh');

            }

        }

        $page_data['exam_id']    = $exam_id;

        //$page_data['class_id']	=	$class_id;

        $page_data['subject_id'] = $subject_id;

        $this->db->select('grand_total');
			$this->db->where('exam_id',$exam_id);
			$res = $this->db->get_where('exam');
			
			$emgm = $res->row_array();
			extract($emgm);
			$page_data['grand_total'] = $grand_total;

        $page_data['page_info'] = 'Exam marks';

        

        $page_data['page_name']  = 'marks';

        $page_data['page_title'] = get_phrase('view_marks');

        $this->load->view('index', $page_data);

    }

    

    

    /**********MANAGING CLASS ROUTINE******************/

    function class_routine($param1 = '', $param2 = '', $param3 = '')

    {

        if ($this->session->userdata('student_login') != 1)

            redirect(base_url(), 'refresh');

        

        $student_profile         = $this->db->get_where('student', array(

            'student_id' => $this->session->userdata('student_id')

        ))->row();
		
		$student_id = $this->db->get_where('student', array('student_id' => $this->session->userdata('student_id')
                ))->row()->student_id;
		
		$class_id = $this->db->get_where('student', array('student_id' => $student_id
                ))->row()->class_id;
				
		$class_name = $this->db->get_where('class', array('class_id' => $class_id
                ))->row()->name;


        $page_data['class_id']   = $student_profile->class_id;
		
		$page_data['class_name'] = $class_name;

        $page_data['page_name']  = 'class_routine';

        $page_data['page_title'] = get_phrase('class_routine_list');

        $this->load->view('index', $page_data);

    }

    

    /******MANAGE BILLING / INVOICES WITH STATUS*****/

    function invoice($param1 = '', $param2 = '', $param3 = '')

    {

        //if($this->session->userdata('student_login')!=1)redirect(base_url() , 'refresh');

        if ($param1 == 'make_payment') {

            $invoice_id      = $this->input->post('invoice_id');

            $system_settings = $this->db->get_where('settings', array(

                'type' => 'paypal_email'

            ))->row();

            $invoice_details = $this->db->get_where('invoice', array(

                'invoice_id' => $invoice_id

            ))->row();

            

            /****TRANSFERRING USER TO PAYPAL TERMINAL****/

            $this->paypal->add_field('rm', 2);

            $this->paypal->add_field('no_note', 0);

            $this->paypal->add_field('item_name', $invoice_details->title);

            $this->paypal->add_field('amount', $invoice_details->amount);

            $this->paypal->add_field('custom', $invoice_details->invoice_id);

            $this->paypal->add_field('business', $system_settings->description);

            $this->paypal->add_field('notify_url', base_url() . 'student/invoice/paypal_ipn');

            $this->paypal->add_field('cancel_return', base_url() . 'student/invoice/paypal_cancel');

            $this->paypal->add_field('return', base_url() . 'student/invoice/paypal_success');

            

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

                $data['payment_details']   = $ipn_response;

                $data['payment_timestamp'] = strtotime(date("m/d/Y"));

                $data['payment_method']    = 'paypal';

                $data['status']            = 'paid';

                $invoice_id                = $_POST['custom'];

                $this->db->where('invoice_id', $invoice_id);

                $this->db->update('invoice', $data);

            }

        }

        if ($param1 == 'paypal_cancel') {

            $this->session->set_flashdata('flash_message', get_phrase('payment_cancelled'));

            redirect(base_url() . 'student/invoice/', 'refresh');

        }

        if ($param1 == 'paypal_success') {

            $this->session->set_flashdata('flash_message', get_phrase('payment_successfull'));

            redirect(base_url() . 'student/invoice/', 'refresh');

        }

        $student_profile         = $this->db->get_where('student', array(

            'student_id' => $this->session->userdata('student_id')

        ))->row();

        $student_id              = $student_profile->student_id;

        $page_data['invoices']   = $this->db->get_where('invoice', array(

            'student_id' => $student_id

        ))->result_array();

        $page_data['page_name']  = 'invoice';

        $page_data['page_title'] = get_phrase('invoice/payment_list');

        $this->load->view('index', $page_data);

    }

    

    /**********MANAGE LIBRARY / BOOKS********************/

    function book($param1 = '', $param2 = '', $param3 = '')

    {

        if ($this->session->userdata('student_login') != 1)

            redirect('login', 'refresh');

        

        $page_data['books']      = $this->db->get('book')->result_array();

        $page_data['page_name']  = 'book';

        $page_data['page_title'] = get_phrase('library_books_list');

        $this->load->view('index', $page_data);

        

    }
    
    /*Manage E-Book*/
    	function ebooks($param1 = '', $param2 = '', $param3 = '')

    {

        if ($this->session->userdata('student_login') != 1)

            redirect('login', 'refresh');

        

        $page_data['ebooks']      = $this->db->get('ebooks')->result_array();

        $page_data['page_name']  = 'ebooks';

        $page_data['page_title'] = get_phrase('ebooks_list');
		
		$page_data['ebooks_category_id'] = $param1;
        $page_data['ebooks'] = $this->db->get_where('ebooks', array(
                    'ebooks_category_id' => $param1
                ))->result_array();

        $this->load->view('index', $page_data);


    }
   /****************************************************************
   			Previous Question Papers
   ****************************************************************/ 
    function questionpaper($param1 = '', $param2 = '', $param3 = ''){
        if ($this->session->userdata('student_login') != 1)
            redirect('login', 'refresh');
        $page_data['ebooks']      = $this->db->get('ebooks')->result_array();
        $page_data['page_name']  = 'ebooks';
        $page_data['page_title'] = get_phrase('previous_question_papers');
		$page_data['ebooks_category_id'] = $param1;
        $page_data['ebooks'] = $this->db->get_where('ebooks', array(
                    'ebooks_category_id' => $param1
                ))->result_array();

        $this->load->view('student/questionpapers', $page_data);
    }
	/****************************************************************
   			Online Test
     ****************************************************************/ 
    function onlinetest($param1 = '', $param2 = '', $param3 = ''){
        if ($this->session->userdata('student_login') != 1)
            redirect('login', 'refresh');
        $page_data['onlinetest']      = $this->db->get('onlinetest')->result_array();
        $page_data['page_name']  = 'online_test';
        $page_data['page_title'] = get_phrase('online_test');
		$page_data['onlinetest_id'] = $param1;
        //$page_data['onlinetest'] = $this->db->get_where('onlinetest', array('classname' => $param1))->result_array();
		if(!empty($_POST)){
			//print_r($_POST['classname']);
			//$page_data['onlinetest'] = $this->db->get_where('onlinetest', array('classname' => $_POST['classname'],'subject'=>$_POST['subject']))->result_array();
			$page_data['onlinetest'] = $this->db->query("select * from onlinetest where classname='".$_POST['classname']."'  and subject='".$_POST['subject']."' ORDER BY RAND()")->result_array();
		}
        $this->load->view('student/onlinetests', $page_data);
    }
	
	/******************************************************************
			Results
	******************************************************************/
	function result($param1 = '', $param2 = '', $param3 = ''){
        if ($this->session->userdata('student_login') != 1)
        $page_data['page_name']  = 'online_test_results';
        $page_data['page_title'] = get_phrase('online_test_results');
		$page_data['onlinetest_id'] = $param1;
        //$page_data['onlinetest'] = $this->db->get_where('onlinetest', array('classname' => $param1))->result_array();
		if(!empty($_POST)){
			//print_r($_POST['classname']);
			//$page_data['onlinetest'] = $this->db->get_where('onlinetest', array('classname' => $_POST['classname'],'subject'=>$_POST['subject']))->result_array();
			//$page_data['onlinetest'] = $this->db->query("select * from onlinetest where classname='".$_POST['classname']."'  and subject='".$_POST['subject']."' ORDER BY RAND()")->result_array();
			
				$right_answer=0;
				$wrong_answer=0;
				$unanswered=0; 
			//print_r($_POST);exit;
			   $keys=array_keys($_POST);
			   $order=join(",",$keys);
			
			   //$query="select * from questions id IN($order) ORDER BY FIELD(id,$order)";
			  //print_r( $query);exit;
			
			   //$response=mysql_query("select id,answer from questions where id IN($order) ORDER BY FIELD(id,$order)")   or die(mysql_error());
				$page_data['response'] = $this->db->query("select onlinetest_id,ans from onlinetest where onlinetest_id IN ('".$order."')  ORDER BY FIELD(onlinetest_id,$order)")->result_array();
				//print_r($page_data['response']);exit;
			   /*while($result=mysql_fetch_array($response)){
				   if($result['answer']==$_POST[$result['id']]){
						   $right_answer++;
					   }else if($_POST[$result['id']]==5){
						   $unanswered++;
					   }
					   else{
						   $wrong_answer++;
					   }
			   }*/
			
			
		}
        $this->load->view('student/results', $page_data);
    }
    /**********MANAGE TRANSPORT / VEHICLES / ROUTES********************/

    function transport($param1 = '', $param2 = '', $param3 = '')

    {

        if ($this->session->userdata('student_login') != 1)

            redirect('login', 'refresh');

        

       $sid = $this->session->userdata('student_id');
		
		
		$this->db->join('transport_points','pid=ppoint_id');
		$this->db->join('transport','transport.transport_id =student.transport_id');
		$this->db->where('student_id',$sid);
		$query = $this->db->get_where('student');
		
		$transports = $query->result();
		
		//print_r($transports);

        $page_data['transports'] = $transports;

        $page_data['page_name'] = 'transport';

  

        $page_data['page_title'] = get_phrase('transport_list');

        $this->load->view('index', $page_data);

        

    }

    /**********MANAGE DORMITORY / HOSTELS / ROOMS ********************/

    function dormitory($param1 = '', $param2 = '', $param3 = '')

    {

        if ($this->session->userdata('student_login') != 1)

            redirect('login', 'refresh');

        
		
		$sid = $this->session->userdata('student_id');
		
		
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

       

        $page_data['page_title']  = get_phrase('dormitory');

        $this->load->view('index', $page_data);

        

    }

    
	/**********WATCH ASSIGNMENT ********************/

    function assignments($param1 = '', $param2 = '', $param3 = '')

    {

        if ($this->session->userdata('student_login') != 1)

            redirect('login', 'refresh');

        

        $page_data['assignments']    = $this->db->get('assignments')->result_array();

        $page_data['page_name']  = 'assignments';

        $page_data['page_title'] = get_phrase('assignments');

        $this->load->view('index', $page_data);

        

    }
	

    /**********WATCH NOTICEBOARD AND EVENT ********************/

    function noticeboard($param1 = '', $param2 = '', $param3 = '')

    {

        if ($this->session->userdata('student_login') != 1)

            redirect('login', 'refresh');
		
        $page_data['notices']    = $this->db->get('noticeboard')->result_array();		
		$page_data['class_notices']  = $this->db->get_where('classnotice', array(

            'notice_class' => $this->session->userdata('student_class')
			))->result_array();
        $page_data['page_name']  = 'noticeboard';

        $page_data['page_title'] = get_phrase('noticeboard');

        $this->load->view('index', $page_data);

        

    }

    

    /**********MANAGE DOCUMENT / home work FOR A SPECIFIC CLASS or ALL*******************/

    function document($do = '', $document_id = '')

    {

        if ($this->session->userdata('student_login') != 1)

            redirect('login', 'refresh');

        

        $page_data['page_name']  = 'manage_document';

        $page_data['page_title'] = get_phrase('manage_documents');

        $page_data['documents']  = $this->db->get('document')->result_array();

        $this->load->view('index', $page_data);

    }

    

    

    /******MANAGE OWN PROFILE AND CHANGE PASSWORD***/

    function manage_profile($param1 = '', $param2 = '', $param3 = '')

    {

        if ($this->session->userdata('student_login') != 1)

            redirect(base_url() . 'login', 'refresh');

        if ($param1 == 'update_profile_info') {

            $data['name']        = $this->input->post('name');

            $data['birthday']    = $this->input->post('birthday');

            $data['sex']         = $this->input->post('sex');

            $data['religion']    = $this->input->post('religion');

            $data['blood_group'] = $this->input->post('blood_group');

            $data['address']     = $this->input->post('address');

            $data['phone']       = $this->input->post('phone');

            $data['email']       = $this->input->post('email');

            

            $this->db->where('student_id', $this->session->userdata('student_id'));

            $this->db->update('student', $data);

            $this->session->set_flashdata('flash_message', get_phrase('account_updated'));

            redirect(base_url() . 'student/manage_profile/', 'refresh');

        }

        if ($param1 == 'change_password') {

            $data['password']             = $this->input->post('password');

            $data['new_password']         = $this->input->post('new_password');

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

        $page_data['page_name']  = 'manage_profile';

        $page_data['page_title'] = get_phrase('manage_profile');

        $page_data['edit_data']  = $this->db->get_where('student', array(

            'student_id' => $this->session->userdata('student_id')

        ))->result_array();

        $this->load->view('index', $page_data);

    }
	
	 /****MANAGE ATTENDENCE*****/
    function attendence($class_id = '', $month = '')
    {
        if ($this->session->userdata('student_login') != 1)
            redirect(base_url(), 'refresh');
			
			
		 $student_profile       = $this->db->get_where('student', array(

            'student_id' => $this->session->userdata('student_id')

        ))->row();

        $page_data['class_id'] = $student_profile->class_id;
		
        
        if ($this->input->post('operation') == 'selection') {
					
			$page_data['month']   = $this->input->post('month');
			
            
            if ($page_data['class_id'] > 0 && $page_data['month'] > 0) {
                redirect(base_url() . 'student/attendence/' . $page_data['class_id'] . '/' . $page_data['month'], 'refresh');
            } else {
                $this->session->set_flashdata('attendence_message', 'Choose class');
                redirect(base_url() . 'student/attendence/', 'refresh');
            }
        }
     
        $page_data['class_id']   = $class_id;
		
		$page_data['month']   = $month;
        
        $page_data['page_info'] = 'Attendence';
        
        $page_data['page_name']  = 'attendence';
        $page_data['page_title'] = get_phrase('view_attendence');
        $this->load->view('index', $page_data);
    }
    function  email(){
        $login_type = $this->session->userdata('login_type');
        $user_id = $this->session->userdata($login_type.'_id');
        $page_data['result']    =  $this->db->get_where('email',array('type' => 'student' ))->result_array();
        foreach($page_data['result'] as $row){
           $id =  $row['id'];
           $unread = explode(',',$row['unread']);
           $read   = explode(',', $row['read']);
          if(($key = array_search($user_id, $unread)) !== false) {
              unset($unread[$key]);
              $read[] = $user_id;
          }
          $data['read'] = implode(',',$read);
          $data['unread'] =implode(',',$unread);
          $this->db->where('id', $id);
          $this->db->update('email', $data);
        }
        $page_data['page_info'] = 'emailview';
        $page_data['user_id']   = $user_id;
        $page_data['page_name'] = 'email_view';
        $page_data['page_title']= get_phrase('email_view');
        $this->load->view('index', $page_data);
    }
    function email_delete($param1){
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
        redirect(base_url()."".$login_type."/email");
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
            
            $page_data['page_title'] = get_phrase('mark_view');
            $this->load->view('index', $page_data);
            
         }
		 
		 function tasks(){
			 
			if ($this->session->userdata('student_login') != 1)

            redirect('login', 'refresh');
			
			$login_type = $this->session->userdata('login_type');
             $user_id = $this->session->userdata($login_type . '_id');
			 
			 $this->load->model('task_model');
			 $page_data['tasks_data'] = $this->task_model->gettasks($user_id,$login_type);
			 
			$page_data['page_info'] = 'tasks_view';
            $page_data['page_name'] = 'tasks_view';
            $page_data['page_title'] = get_phrase('tasks_view');
            $this->load->view('index', $page_data);
			
		 }
		 
		 function taskadd(){
			 
			if ($this->session->userdata('student_login') != 1)

            redirect('login', 'refresh');
			 
			$page_data['page_info'] = 'task_add';
            $page_data['page_name'] = 'task_add';
            $page_data['page_title'] = get_phrase('task_add');
            $this->load->view('index', $page_data);
			
		 }
		  function taskedit($tid){
			 
			if ($this->session->userdata('student_login') != 1)

            redirect('login', 'refresh');
			$this->load->model('task_model');
			$page_data['task_data'] = $this->task_model->gettask($tid);
			 
			$page_data['page_info'] = 'task_edit';
            $page_data['page_name'] = 'task_edit';
            $page_data['page_title'] = get_phrase('task_edit');
            $this->load->view('index', $page_data);
			
		 }
		 function taskinsert(){
			 
			 if ($this->session->userdata('student_login') != 1)

             redirect('login', 'refresh');
			 
			 $login_type = $this->session->userdata('login_type');
             $user_id = $this->session->userdata($login_type . '_id');
			 
			 $taskdata['task_title'] = $this->input->post('task_title');
			 $taskdata['task_description'] = $this->input->post('task_description');
			 $taskdata['task_start_date'] = date("Y-m-d",strtotime($this->input->post('task_start_date')));
			 $taskdata['task_end_date'] = date("Y-m-d",strtotime($this->input->post('task_end_date')));
			 $taskdata['task_status'] = $this->input->post('task_status');
			 $taskdata['task_user_type'] = $login_type;
			 $taskdata['task_user_id'] = $user_id;
			 $taskdata['task_added_date'] =  date('Y-m-d H:i:s');
			 $taskdata['task_modified_date'] =  date('Y-m-d H:i:s');
			 
			 $this->load->model('task_model');
			 
			 $res = $this->task_model->insert_task($taskdata);
			 
			 if($res){
				 
				  $this->session->set_flashdata('msg', 'true');
				  $this->session->set_flashdata('task_title', $this->input->post('task_title'));
				  redirect(base_url().''.$login_type.'/tasks', 'refresh');
			 }
			 
			 
			 
		 }
		 function taskupdate(){
			 
			 if ($this->session->userdata('student_login') != 1)

             redirect('login', 'refresh');
			 
			 $login_type = $this->session->userdata('login_type');
             $user_id = $this->session->userdata($login_type . '_id');
			 
			 $tid = $this->input->post('hid_tid');
			 
			 if($tid !=''){
			 
			 $taskdata['task_title'] = $this->input->post('task_title');
			 $taskdata['task_description'] = $this->input->post('task_description');
			 $taskdata['task_start_date'] = date("Y-m-d",strtotime($this->input->post('task_start_date')));
			 $taskdata['task_end_date'] = date("Y-m-d",strtotime($this->input->post('task_end_date')));
			 $taskdata['task_status'] = $this->input->post('task_status');
			 $taskdata['task_user_type'] = $login_type;
			 $taskdata['task_user_id'] = $user_id;
			 $taskdata['task_modified_date'] =  date('Y-m-d H:i:s');
			 
			 $this->load->model('task_model');
			 
			 $res = $this->task_model->update_task($taskdata,$tid);
			 
			 if($res){
				 
				  $this->session->set_flashdata('msg', 'add_true');
				  $this->session->set_flashdata('task_title', $this->input->post('task_title'));
				  redirect(base_url().''.$login_type.'/tasks', 'refresh');
			 }
			 }
			 
			 
			 
		 }
		 function taskdelete($tid){
			 
			  if ($this->session->userdata('student_login') != 1)

             redirect('login', 'refresh');
			 
			 $login_type = $this->session->userdata('login_type');
             $user_id = $this->session->userdata($login_type . '_id');
			 $this->load->model('task_model');
			 
			 
			 $res = $this->task_model->delete_task($tid);
			 
			 if($res){
				 
				  $this->session->set_flashdata('msg', 'del_true');
				  $this->session->set_flashdata('task_title', $this->input->post('task_title'));
				  redirect(base_url().''.$login_type.'/tasks', 'refresh');
			 }
		 }
		  function datecompare(){
		
			$date_1 = $this->input->post('startDate');
			$date_2 = $this->input->post('endDate');
			 
			if (strtotime($date_2) >= strtotime($date_1))
			{ 
				echo "true";
			}
			else
			{
				echo "false";
			}
		}
		
		/****VIEW DAILYATTENDENCE*****/
		function dailyattendence(){
			if ($this->session->userdata('student_login') != 1)
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
			if ($this->session->userdata('student_login') != 1)
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
			if ($this->session->userdata('student_login') != 1)
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

}
