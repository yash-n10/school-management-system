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



class Teacher extends CI_Controller

{

    

    

    function __construct()

    {

        parent::__construct();

		$this->load->database();

        /*cache control*/

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

    

    /***default functin, redirects to login page if no admin logged in yet***/

    public function index()

    {

        if ($this->session->userdata('teacher_login') != 1)

            redirect(base_url() . 'login', 'refresh');

        if ($this->session->userdata('teacher_login') == 1)

            redirect(base_url() . 'teacher/dashboard', 'refresh');

    }

    

    /***ADMIN DASHBOARD***/

    function dashboard()

    {

        if ($this->session->userdata('teacher_login') != 1)

          redirect(base_url(), 'refresh');
         $this->load->model('core_model');
        $login_type = $this->session->userdata('login_type');
        $user_id = $this->session->userdata($login_type.'_id');
        $results = $this->db->get_where('email',array('type' => strtolower($login_type)))->result_array();
        $i = 0 ;
        foreach($results as $result){
             $unread = explode(',',$result['unread']);
             if(in_array($user_id,$unread)){
                 $i++;
             }
             
        }
        $res_query = array(
			'where'  => array('user_inbox_id'=>$user_id, 'status'=>'1')
		);
	$count_unread_message   = $this->core_model->get_count($res_query, 'parent_enquiry');
	$page_data['count_unread_message'] = $count_unread_message;
        $page_data['page_name']  = 'dashboard';
        $page_data[$login_type.'_message'] =  $i;
        
        $page_data['page_title'] = get_phrase('teacher_dashboard');
        $this->load->view('index', $page_data);

    }

    

    

    /*ENTRY OF A NEW STUDENT*/

    

    

    /****MANAGE STUDENTS CLASSWISE*****/

    function student($param1 = '', $param2 = '', $param3 = '')

    {

        if ($this->session->userdata('teacher_login') != 1)

            redirect('login', 'refresh');

        if ($param1 == 'create') {

            $data['name']        = $this->input->post('name');

            $data['birthday']    = $this->input->post('birthday');

            $data['sex']         = $this->input->post('sex');

            $data['religion']    = $this->input->post('religion');

            $data['blood_group'] = $this->input->post('blood_group');

            $data['address']     = $this->input->post('address');

            $data['phone']       = $this->input->post('phone');

            $data['email']       = $this->input->post('email');

            $data['father_name'] = $this->input->post('father_name');

            $data['mother_name'] = $this->input->post('mother_name');

            $data['class_id']    = $this->input->post('class_id');

            $data['roll']        = $this->input->post('roll');

            $data['password']    = rand(1000000, 10000000);

            $this->db->insert('student', $data);

            $student_id = mysql_insert_id();

            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $student_id . '.jpg');

            $this->email_model->account_opening_email('student', $data['email']); //SEND EMAIL ACCOUNT OPENING EMAIL

            redirect(base_url() . 'teacher/student', 'refresh');

        }

        if ($param2 == 'do_update') {

            $data['name']        = $this->input->post('name');

            $data['birthday']    = $this->input->post('birthday');

            $data['sex']         = $this->input->post('sex');

            $data['religion']    = $this->input->post('religion');

            $data['blood_group'] = $this->input->post('blood_group');

            $data['address']     = $this->input->post('address');

            $data['phone']       = $this->input->post('phone');

            $data['email']       = $this->input->post('email');

            $data['father_name'] = $this->input->post('father_name');

            $data['mother_name'] = $this->input->post('mother_name');

            $data['class_id']    = $this->input->post('class_id');

            $data['roll']        = $this->input->post('roll');

            

            $this->db->where('student_id', $param3);

            $this->db->update('student', $data);

            move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/student_image/' . $param3 . '.jpg');

            redirect(base_url() . 'teacher/student/' . $param1, 'refresh');

        } else if ($param2 == 'edit') {

            $page_data['edit_data'] = $this->db->get_where('student', array(

                'student_id' => $param3

            ))->result_array();

        } else if ($param2 == 'personal_profile') {

            $page_data['personal_profile']   = true;

            $page_data['current_student_id'] = $param3;

        } else if ($param2 == 'academic_result') {

            $page_data['academic_result']    = true;

            $page_data['current_student_id'] = $param3;

        }

        if ($param2 == 'delete') {

            $this->db->where('student_id', $param2);

            $this->db->delete('student');

            redirect(base_url() . 'teacher/student/' . $param1, 'refresh');

        }

        $page_data['class_id']   = $param1;

        $page_data['students']   = $this->db->get_where('student', array(

            'class_id' => $param1

        ))->result_array();

        $page_data['page_name']  = 'student';

        $page_data['page_title'] = get_phrase('student_view');

        $this->load->view('index', $page_data);

    }

    

    /****MANAGE TEACHERS*****/

    function teacher_list($param1 = '', $param2 = '')

    {

        if ($this->session->userdata('teacher_login') != 1)

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

        if ($this->session->userdata('teacher_login') != 1)

            redirect(base_url(), 'refresh');

        if ($param1 == 'create') {

            $data['name']       = $this->input->post('name');

            $data['class_id']   = $this->input->post('class_id');

            $data['teacher_id'] = $this->input->post('teacher_id');

            $this->db->insert('subject', $data);

            redirect(base_url() . 'teacher/subject/', 'refresh');

        }

        if ($param1 == 'do_update') {

            $data['name']       = $this->input->post('name');

            $data['class_id']   = $this->input->post('class_id');

            $data['teacher_id'] = $this->input->post('teacher_id');

            

            $this->db->where('subject_id', $param2);

            $this->db->update('subject', $data);

            redirect(base_url() . 'teacher/subject/', 'refresh');

        } else if ($param1 == 'edit') {

            $page_data['edit_data'] = $this->db->get_where('subject', array(

                'subject_id' => $param2

            ))->result_array();

        }

        if ($param1 == 'delete') {

            $this->db->where('subject_id', $param2);

            $this->db->delete('subject');

            redirect(base_url() . 'teacher/subject/', 'refresh');

        }

        $page_data['subjects']   = $this->db->get('subject')->result_array();

        $page_data['page_name']  = 'subject';

        $page_data['page_title'] = get_phrase('view_subject');

        $this->load->view('index', $page_data);

    }

    

    

    

    /****MANAGE EXAM MARKS*****/

    function marks($exam_id = '', $class_id = '', $subject_id = '')

    {

        if ($this->session->userdata('teacher_login') != 1)

            redirect(base_url(), 'refresh');

        

        if ($this->input->post('operation') == 'selection') {

            $page_data['exam_id']    = $this->input->post('exam_id');

            $page_data['class_id']   = $this->input->post('class_id');

            $page_data['subject_id'] = $this->input->post('subject_id');

            

            if ($page_data['exam_id'] > 0 && $page_data['class_id'] > 0 && $page_data['subject_id'] > 0) {

                redirect(base_url() . 'teacher/marks/' . $page_data['exam_id'] . '/' . $page_data['class_id'] . '/' . $page_data['subject_id'], 'refresh');

            } else {

                $this->session->set_flashdata('mark_message', 'Choose exam, class and subject');

                redirect(base_url() . 'teacher/marks/', 'refresh');

            }

        }

        if ($this->input->post('operation') == 'update') {

            /*
            $data['mark_obtained'] = $this->input->post('mark_obtained');

            $data['comment']       = $this->input->post('comment');

            

            $this->db->where('mark_id', $this->input->post('mark_id'));

            $this->db->update('mark', $data);
            */
            
            foreach($_POST['mark_obtained'] as $key =>  $mark)
            {
                $data['mark_obtained'] = $mark;
                $data['comment'] = $_POST['comment'][$key];            

                $this->db->where('mark_id', $_POST['mark_id'][$key]);
                $this->db->update('mark', $data);
            }           
            

            redirect(base_url() . 'teacher/marks/' . $this->input->post('exam_id') . '/' . $this->input->post('class_id') . '/' . $this->input->post('subject_id'), 'refresh');

        }

        $page_data['exam_id']    = $exam_id;

        $page_data['class_id']   = $class_id;

        $page_data['subject_id'] = $subject_id;

        $this->db->select('grand_total');
			$this->db->where('exam_id',$exam_id);
			$res = $this->db->get_where('exam');
			
			$emgm = $res->row_array();
			extract($emgm);
			$page_data['grand_total'] = $grand_total;

        $page_data['page_info'] = 'Exam marks';

        

        $page_data['page_name']  = 'marks';

        $page_data['page_title'] = get_phrase('manage_exam_marks');

        $this->load->view('index', $page_data);

    }

    

    /*****BACKUP / RESTORE / DELETE DATA PAGE**********/

    function backup_restore($operation = '', $type = '')

    {

        if ($this->session->userdata('teacher_login') != 1)

            redirect(base_url(), 'refresh');

        

        if ($operation == 'create') {

            $this->crud_model->create_backup($type);

        }

        if ($operation == 'restore') {

            $this->crud_model->restore_backup();

            $this->session->set_flashdata('backup_message', 'Backup Restored');

            redirect(base_url() . 'teacher/backup_restore/', 'refresh');

        }

        if ($operation == 'delete') {

            $this->crud_model->truncate($type);

            $this->session->set_flashdata('backup_message', 'Data removed');

            redirect(base_url() . 'teacher/backup_restore/', 'refresh');

        }

        

        $page_data['page_info']  = 'Create backup / restore from backup';

        $page_data['page_name']  = 'backup_restore';

        $page_data['page_title'] = get_phrase('manage_backup_restore');

        $this->load->view('index', $page_data);

    }

    

    /******MANAGE OWN PROFILE AND CHANGE PASSWORD***/

    function manage_profile($param1 = '', $param2 = '', $param3 = '')

    {

        if ($this->session->userdata('teacher_login') != 1)

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

            

            $this->db->where('teacher_id', $this->session->userdata('teacher_id'));

            $this->db->update('teacher', $data);

            $this->session->set_flashdata('flash_message', get_phrase('account_updated'));

            redirect(base_url() . 'teacher/manage_profile/', 'refresh');

        }

        if ($param1 == 'change_password') {

            $data['password']             = $this->input->post('password');

            $data['new_password']         = $this->input->post('new_password');

            $data['confirm_new_password'] = $this->input->post('confirm_new_password');

            

            $current_password = $this->db->get_where('teacher', array(

                'teacher_id' => $this->session->userdata('teacher_id')

            ))->row()->password;

            if ($current_password == $data['password'] && $data['new_password'] == $data['confirm_new_password']) {

                $this->db->where('teacher_id', $this->session->userdata('teacher_id'));

                $this->db->update('teacher', array(

                    'password' => $data['new_password']

                ));

                $this->session->set_flashdata('flash_message', get_phrase('password_updated'));

            } else {

                $this->session->set_flashdata('flash_message', get_phrase('password_mismatch'));

            }

            redirect(base_url() . 'teacher/manage_profile/', 'refresh');

        }

        $page_data['page_name']  = 'manage_profile';

        $page_data['page_title'] = get_phrase('manage_profile');

        $page_data['edit_data']  = $this->db->get_where('teacher', array(

            'teacher_id' => $this->session->userdata('teacher_id')

        ))->result_array();

        $this->load->view('index', $page_data);

    }

    

    /**********MANAGING CLASS ROUTINE******************/

    function class_routine($param1 = '', $param2 = '', $param3 = '')

    {

        if ($this->session->userdata('teacher_login') != 1)

            redirect(base_url(), 'refresh');

        if ($param1 == 'create') {

            $data['class_id']   = $this->input->post('class_id');

            $data['subject_id'] = $this->input->post('subject_id');

            $data['time_start'] = $this->input->post('time_start');

            $data['time_end']   = $this->input->post('time_end');

            $data['day']        = $this->input->post('day');

            $this->db->insert('class_routine', $data);

            redirect(base_url() . 'teacher/class_routine/', 'refresh');

        }

        if ($param1 == 'edit' && $param2 == 'do_update') {

            $data['class_id']   = $this->input->post('class_id');

            $data['subject_id'] = $this->input->post('subject_id');

            $data['time_start'] = $this->input->post('time_start');

            $data['time_end']   = $this->input->post('time_end');

            $data['day']        = $this->input->post('day');

            

            $this->db->where('class_routine_id', $param3);

            $this->db->update('class_routine', $data);

            redirect(base_url() . 'teacher/class_routine/', 'refresh');

        } else if ($param1 == 'edit') {

            $page_data['edit_data'] = $this->db->get_where('class_routine', array(

                'class_routine_id' => $param2

            ))->result_array();

        }

        if ($param1 == 'delete') {

            $this->db->where('class_schedule_id', $param2);

            $this->db->delete('class_schedule');

            redirect(base_url() . 'teacher/class_routine/', 'refresh');

        }

        $page_data['page_name']  = 'class_routine';

        $page_data['page_title'] = get_phrase('view_class_routine');

        $this->load->view('index', $page_data);

    }

    

    

    /**********MANAGE LIBRARY / BOOKS********************/

    function book($param1 = '', $param2 = '', $param3 = '')

    {

        if ($this->session->userdata('teacher_login') != 1)

            redirect('login', 'refresh');

        

        $page_data['books']      = $this->db->get('book')->result_array();

        $page_data['page_name']  = 'book';

        $page_data['page_title'] = get_phrase('view_library_books');

        $this->load->view('index', $page_data);

        

    }

    /**********MANAGE TRANSPORT / VEHICLES / ROUTES********************/

    function transport($param1 = '', $param2 = '', $param3 = '')

    {

        if ($this->session->userdata('teacher_login') != 1)

            redirect('login', 'refresh');

        

        $page_data['transports'] = $this->db->get('transport')->result_array();

        $page_data['page_name']  = 'transport';

        $page_data['page_title'] = get_phrase('transport_list');

        $this->load->view('index', $page_data);

        

    }

    

    /***MANAGE EVENT / NOTICEBOARD, WILL BE SEEN BY ALL ACCOUNTS DASHBOARD**/

    function noticeboard($param1 = '', $param2 = '', $param3 = '')

    {

        if ($this->session->userdata('teacher_login') != 1)

            redirect(base_url(), 'refresh');

        

        if ($param1 == 'create') {

            $data['notice_title']     = $this->input->post('notice_title');

            $data['notice']           = $this->input->post('notice');

            $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));

            $this->db->insert('noticeboard', $data);

            redirect(base_url() . 'teacher/noticeboard/', 'refresh');

        }

        if ($param1 == 'do_update') {

            $data['notice_title']     = $this->input->post('notice_title');

            $data['notice']           = $this->input->post('notice');

            $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));

            $this->db->where('notice_id', $param2);

            $this->db->update('noticeboard', $data);

            $this->session->set_flashdata('flash_message', get_phrase('notice_updated'));

            redirect(base_url() . 'teacher/noticeboard/', 'refresh');

        } else if ($param1 == 'edit') {

            $page_data['edit_data'] = $this->db->get_where('noticeboard', array(

                'notice_id' => $param2

            ))->result_array();

        }

        if ($param1 == 'delete') {

            $this->db->where('notice_id', $param2);

            $this->db->delete('noticeboard');

            redirect(base_url() . 'teacher/noticeboard/', 'refresh');

        }

        $page_data['page_name']  = 'noticeboard';

        $page_data['page_title'] = get_phrase('manage_noticeboard');

        $page_data['notices']    = $this->db->get('noticeboard')->result_array();

        $this->load->view('index', $page_data);

    }

    

	/**********MANAGE Assignment / home work FOR A SPECIFIC CLASS or ALL*******************/
	
	function assignments($param1 = '', $param2 = '', $param3 = '')

    {

        if ($this->session->userdata('teacher_login') != 1)

            redirect(base_url(), 'refresh');

        

        if ($param1 == 'create') {
			
			$data['assignment_teacher']     = $this->input->post('assignment_teacher');			           
			
			$data['class_id']     = $this->input->post('assignment_class_id');
			
			$data['subject_id']     = $this->input->post('subject_id');
			
			$data['assignment_title']     = $this->input->post('assignment_title');
			
			$data['teacher_id']     = $this->session->userdata('teacher_id');//by session

            $data['assignment']           = $this->input->post('assignment');
			
			$data['assignment_attachment'] = $_FILES['assignmentfile']['name'];

            $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));
			
			$data['posted_on']=strtotime(date('m/d/Y'));
				
            $this->db->insert('assignments', $data);
			$assignment_id = mysql_insert_id();
			
            move_uploaded_file($_FILES['assignmentfile']['tmp_name'], 'uploads/assignment_attachment/' . $_FILES['assignmentfile']['name']);

            redirect(base_url() . 'teacher/assignments/', 'refresh');

        }

        if ($param1 == 'do_update') {
			
			$data['assignment_teacher']     = $this->input->post('assignment_teacher');		
			
			$data['class_id']     = $this->input->post('assignment_class_id');
			
			$data['subject_id']     = $this->input->post('subject_id');
			
            $data['assignment_title']     = $this->input->post('assignment_title');

            $data['assignment']           = $this->input->post('assignment');
			
			if($_FILES['assignmentfile']['name'])
				$data['assignment_attachment'] = $_FILES['assignmentfile']['name'];
			else
				$data['assignment_attachment'] = $this->input->post('assignmentfile1');
			
			$data['teacher_id']     = $this->session->userdata('teacher_id');//by session
			
			$data['posted_on']=strtotime(date('m/d/Y'));

            $data['create_timestamp'] = strtotime($this->input->post('create_timestamp'));

            $this->db->where('assignment_id', $param2);

            $this->db->update('assignments', $data);

            $this->session->set_flashdata('flash_message', get_phrase('assignment_updated'));
			
			move_uploaded_file($_FILES['assignmentfile']['tmp_name'], 'uploads/assignment_attachment/' . $_FILES['assignmentfile']['name']);


            redirect(base_url() . 'teacher/assignments/', 'refresh');

        } else if ($param1 == 'edit') {

            $page_data['edit_data'] = $this->db->get_where('assignments', array(

                'assignment_id' => $param2

            ))->result_array();

        }

        if ($param1 == 'delete') {

            $this->db->where('assignment_id', $param2);

            $this->db->delete('assignments');

            redirect(base_url() . 'teacher/assignments/', 'refresh');

        }

        $page_data['page_name']  = 'assignments';

        $page_data['page_title'] = get_phrase('manage_assignments');

        $page_data['assignments']    = $this->db->get('assignments')->result_array();


        $this->load->view('index', $page_data);

    }
	
	//load subjects
	function assignments_subjects($param1 = '', $param2 = '', $param3 = '')

    {
		$this->load->model('task_model');
		
		$fc_id = $this->input->post('get_fc_id');
		
		$ft_id=$this->session->userdata('teacher_id');
		
		$fp_data = $this->task_model->getsubject($fc_id,$ft_id);
		$fcvalue ='<option value="">-- Select Subject --</option>';
		
		foreach($fp_data as $fp_data_view){
			
			$fcvalue .='<option value="'.$fp_data_view->subject_id.'">'.$fp_data_view->name.'</option>';
		}
		
		echo $fcvalue;
	}
	

    /**********MANAGE DOCUMENT / home work FOR A SPECIFIC CLASS or ALL*******************/

    function document($do = '', $document_id = '')

    {

        if ($this->session->userdata('teacher_login') != 1)

            redirect('login', 'refresh');

        if ($do == 'upload') {

            move_uploaded_file($_FILES["userfile"]["tmp_name"], "uploads/document/" . $_FILES["userfile"]["name"]);

            $data['document_name'] = $this->input->post('document_name');

            $data['file_name']     = $_FILES["userfile"]["name"];

            $data['file_size']     = $_FILES["userfile"]["size"];

            $this->db->insert('document', $data);

            redirect(base_url() . 'admin/manage_document', 'refresh');

        }

        if ($do == 'delete') {

            $this->db->where('document_id', $document_id);

            $this->db->delete('document');

            redirect(base_url() . 'admin/manage_document', 'refresh');

        }

        $page_data['page_name']  = 'manage_document';

        $page_data['page_title'] = get_phrase('manage_documents');

        $page_data['documents']  = $this->db->get('document')->result_array();

        $this->load->view('index', $page_data);

    }

    	 /****MANAGE ATTENDENCE*****/
    function attendence($class_id = '', $month = '')
    {
        if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        
        if ($this->input->post('operation') == 'selection') {
		
            $page_data['class_id']   = $this->input->post('class_id');
			
			$page_data['month']   = $this->input->post('month');
            
            if ($page_data['class_id'] > 0 && $page_data['month'] > 0) {
                redirect(base_url() . 'teacher/attendence/' . $page_data['class_id'] . '/' . $page_data['month'], 'refresh');
            } else {
                $this->session->set_flashdata('attendence_message', 'Choose class');
                redirect(base_url() . 'teacher/attendence/', 'refresh');
            }
        }
        if ($this->input->post('operation') == 'update') {
		
            /*
            $data['present'] = $this->input->post('present');
			
            $this->db->where('attendence_id', $this->input->post('atten_id'));
            $this->db->update('attendence', $data);
           */
             foreach($_POST['present'] as $key => $p)
            {
                $data['present'] = $p;
                $this->db->where('attendence_id', $_POST['atten_id'][$key]);
                $this->db->update('attendence', $data);
            }
 
            redirect(base_url() . 'teacher/attendence/' . $this->input->post('class_id'). '/' . $this->input->post('month') , 'refresh');
        }
		
		if ($this->input->post('working') == 'days') {
		
			$data['total_days'] = $this->input->post('totaldays'); 
			
            
            $this->db->where('work_id', $this->input->post('month'));
            $this->db->update('workingdays', $data);
            
            redirect(base_url() . 'teacher/attendence/' . $this->input->post('class_id'). '/' . $this->input->post('month') , 'refresh');
        }
		
        $page_data['class_id']   = $class_id;
		
		$page_data['month']   = $month;
        
        $page_data['page_info'] = 'Attendence';
        
        $page_data['page_name']  = 'attendence';
        $page_data['page_title'] = get_phrase('manage_attendence');
        $this->load->view('index', $page_data);
    }
     function  email(){
        $login_type = $this->session->userdata('login_type');
        $user_id = $this->session->userdata($login_type.'_id');
        $page_data['result']    =  $this->db->get_where('email',array('type' => 'teacher' ))->result_array();
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
      function parent_enquiry(){
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
                                     WHERE parent_enquiry.user_inbox_id = '".$user_id."' group by parent_enquiry.user_id
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
						 WHERE parent_enquiry.user_inbox_id = '".$user_id."' or parent_enquiry.user_inbox_id = '".$id."'
						 ORDER BY parent_enquiry.time ASC"
					);
			$results  = $query->result();
                      //  echo $this->db->last_query();
                        $where = array('user_inbox_id' => $user_id);
			$update_info = array('status' => 0);
			$this->core_model->update_table($update_info, $where, 'parent_enquiry');
                	$html = $this->load->view('teacher/message_body',array('results' => $results), TRUE);
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

			$html = $this->load->view('teacher/message_body', array('results' => $results), TRUE);
			$return['html']   = $html;
			$return['status'] = 'success';
		
		}
                echo json_encode($return);
		exit;
        }
		
		/****VIEW PLACEMENTS*****/
		function placements()
		{
			if ($this->session->userdata('teacher_login') != 1)
				redirect(base_url(), 'refresh');
			$this->load->model('placement_model');
			$page_data['placement_data'] = $this->placement_model->getplacementsactive();
			$page_data['page_name']  = 'placements';
			$page_data['page_title'] = get_phrase('view_placements');
			$this->load->view('index', $page_data);
		}
		/****MANAGE TIMETABLE CATEGORY*****/
		function timetables()
		{
			if ($this->session->userdata('teacher_login') != 1)
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
		
		/****VIEW MONTHLY ATTENDENCE*****/
		function mymonthlyattendence() {
		 if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
		 
			  $login_type = $this->session->userdata('login_type');
        $user_id = $this->session->userdata($login_type.'_id');
			  $this->db->select('staff_attendence.*,teacher.name as tname,teacher.employee_code as ecode,workingdays.total_days as tdays');
			  $this->db->from('staff_attendence,teacher,workingdays');
			  $this->db->where('staff_attendence.user_id',$user_id);
			  $this->db->where('staff_attendence.user_id = teacher.teacher_id');
			  $this->db->where('staff_attendence.month = workingdays.work_id');
			  $this->db->order_by('workingdays.work_id');
			  $query = $this->db->get_where();
			  $page_data['attendence_data'] = $query->result();
			  
				$page_data['page_info'] = 'Mothly Attendence';
				$page_data['page_name'] = 'monthlyattendence';
				$page_data['page_title'] = get_phrase('monthly_attendence');
				$this->load->view('index', $page_data);
			  
		 
		 
	}
	/****VIEW DAILYATTENDENCE*****/
		function dailyattendence(){
			if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
			
			$login_type = $this->session->userdata('login_type');
            $user_id = $this->session->userdata($login_type.'_id');
			
			$this->db->where('staff_id',$user_id);
			$this->db->where('staff_type','teaching');
			$query=$this->db->get_where('daily_staffattendence');
			$addata = $query->result();
			$page_data['ad_data'] = $addata;
			
			$page_data['page_info'] = 'Daily Attendence';
        	$page_data['page_name'] = 'daily_attendence';
        	$page_data['page_title'] = get_phrase('staff_daily_attendence');
        	$this->load->view('index', $page_data);
		}
	
	
	/***MANAGE LEAVE **/

    function leavemanagement($param1 = '', $param2 = '', $param3 = '')

    {

        if ($this->session->userdata('teacher_login') != 1)

            redirect(base_url(), 'refresh');

       

        if ($param1 == 'create') {

            $data['leave_tid']     = $this->input->post('leave_type');
			
			$data['leave_aid']     = $this->session->userdata('teacher_id');
			
			$data['leave_utype']     = 'teacher';
			
			$data['leave_fdate']     = date("Y-m-d",strtotime($this->input->post('lstartDate')));
			
			$data['leave_tdate']     = date("Y-m-d",strtotime($this->input->post('lendDate')));
			
			$data['leave_count']     = $this->input->post('no_dts');
			
			$data['leave_comments']     = $this->input->post('comments');
			
			$data['leave_added_date']     = date('Y-m-d H:i:s');
			
			$data['leave_modified_date']     = date('Y-m-d H:i:s');

            $this->db->insert('leave_data', $data);

            redirect(base_url() . 'teacher/leavemanagement/', 'refresh');

        }

        if ($param1 == 'do_update') {

           $data['leave_tid']     = $this->input->post('leave_type');
			
			$data['leave_aid']     = $this->session->userdata('teacher_id');
			
			$data['leave_utype']     = 'teacher';
			
			$data['leave_fdate']     = date("Y-m-d",strtotime($this->input->post('lstartDate')));
			
			$data['leave_tdate']     = date("Y-m-d",strtotime($this->input->post('lendDate')));
			
			$data['leave_count']     = $this->input->post('no_dts');
			
			$data['leave_comments']     = $this->input->post('comments');
			
			$data['leave_status']     = 0;
			
			$data['leave_modifed_by']     = $this->session->userdata('teacher_id');
			
			$data['leave_modified_date']     = date('Y-m-d H:i:s');

            $this->db->where('leave_id', $param2);

            $this->db->update('leave_data', $data);

            $this->session->set_flashdata('flash_message', get_phrase('leave_updated'));

            redirect(base_url() . 'teacher/leavemanagement/', 'refresh');

        } else if ($param1 == 'edit') {

            $page_data['edit_data'] = $this->db->get_where('leave_data', array(

                'leave_id' => $param2

            ))->result_array();

        }

        if ($param1 == 'delete') {
			
			$data['leave_modified_date']     = date('Y-m-d H:i:s');
			
			$data['leave_modifed_by']     = $this->session->userdata('teacher_id');
			
			$data['leave_delete']     = 'Y';

            $this->db->where('leave_id', $param2);

            $this->db->update('leave_data', $data);

            $this->session->set_flashdata('flash_message', get_phrase('leave_updated'));

            redirect(base_url() . 'teacher/leavemanagement/', 'refresh');

        }
		
		$this->load->model('leave_model');
		
		$page_data['ltype_data'] = $this->leave_model->listltypes();

       
        $tid     = $this->session->userdata('teacher_id');
        $page_data['page_name']  = 'leavemanagement';

        $page_data['page_title'] = get_phrase('leave management');
		
		$this->db->select('leave_data.*,leave_types.leave_type_title as ltype');
		
		$this->db->from('leave_data');
		
		$this->db->join('leave_types','leave_type_id=leave_tid');
		
		$this->db->where('leave_delete','N');
                
                 $this->db->where('leave_aid',$tid);
		
		$this->db->order_by('leave_modified_date','desc');
		
		$query = $this->db->get();
		
        $page_data['leave_data']    = $query ->result_array();
		
		

        $this->load->view('index', $page_data);

    }
	
	function ltypedata(){
		
		$ltid = $this->input->post('lType');
		
		$this->load->model('leave_model');
		
		$ltype_data = $this->leave_model->getltype($ltid);
		
		extract($ltype_data );
		
		$lttid = $this->session->userdata('teacher_id');
		$this->db->select_sum('leave_count');
		$this->db->where('leave_tid',$ltid);
		$this->db->where('leave_aid',$lttid);
		$this->db->where('leave_delete','N');
		$query = $this->db->get('leave_data')->row_array();
		
		extract($query);
		//echo $leave_count;
		//echo $leave_type_max_days;

               if( $leave_count ==''){
			
			$leave_count=0;
		} else {
			
			$leave_count = $leave_count;
		}

		$rms = $leave_type_max_days - $leave_count;
		 $arr = array('thks' => $leave_count , 'mdays' => $leave_type_max_days, 'rms' => $rms ,'sts' => 'true');  
		//add the header here
    header('Content-Type: application/json');
    echo json_encode( $arr );
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
   function caldays(){
	   
	   		$date_1 = date('Y-m-d',strtotime($this->input->post('startDate')));
			$date_2 = date('Y-m-d',strtotime($this->input->post('endDate')));
			$date1=date_create($date_1);
			$date2=date_create($date_2);
			$diff=date_diff($date1,$date2);
			$dval = $diff->format("%a");
			
			echo $dval+1;

   }
   
   
   /* ####################################  Email / SMS Single Parent  #######################################*/
   function sms_student_data(){
	  $sid = $this->input->post('sid');
	  
	  $this->db->select('name,father_name,parent_phone1');
	  $this->db->where('student_id',$sid);
	  $query = $this->db->get_where('student');
	  
	  $data= $query->row_array();
	  extract($data);
	  
	 echo '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="custom-tam-mode">Send SMS to '.$father_name.' (Parent Name)</h3>
			</div>
			<div class="modal-body">
			<div id="sms-overlay"><img src="'.base_url().'/template/images/ajax-loader-2.gif"></div>
			<div id="sms-feedback"></div>
			    <form class="form-horizontal" method="post" action="#" id="snd-frm">
				<div class="control-group">
				<label class="control-label" for="inputEmail">Student Name</label>
				<div class="controls">
				<p class="cstm-sts-txt">'.$name.'</p>
				</div>
				</div>
				<div class="control-group">
				<label class="control-label" for="inputEmail">Parent Phone</label>
				<div class="controls">
				<p class="cstm-sts-txt">'.$parent_phone1.'</p>
				</div>
				</div>
				<div class="control-group">
				<label class="control-label" for="inputPassword">Message</label>
				<div class="controls">
				<textarea id="smessage" name="smessage" placeholder="Message" style="resize:none" maxlength="130"> </textarea>
				</div>
				</div>
				<div class="control-group">
				<label class="control-label" for=""></label>
				<div class="controls">
				<p id="smessage_feedback"> </p>
				</div>
				</div>
				<div class="control-group">
				<div class="controls">
				<input type="hidden" value="'.$parent_phone1.'" id="smsphone" name="smsphone">
				<button type="button" class="btn btn-success" id="sndsmsbtn">Send SMS</button>
				</div>
				</div>
				</form>
				
			</div>
			<div class="modal-footer">
			<button class="btn btn-success btn-small" data-dismiss="modal" aria-hidden="true">Close</button>
			
			</div>';
	  
   }
   function sms_student_snd(){
	   
	  $sphone = $this->input->post('smsphone');
	   
	  $smsg = $this->input->post('smessage');
	  
	  $res = send_tam_sms($sphone,$smsg);
	  
	  if($res){
		  echo "true";
	  } else {
		  echo "false";
	  }
	  
	   
   }
   function email_student_data(){
	  $sid = $this->input->post('sid');
	  
	  $this->db->select('name,father_name');
	  $this->db->where('student_id',$sid);
	  $query = $this->db->get_where('student');
	  
	  $data= $query->row_array();
	  extract($data);
	  
	 echo '<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3 id="custom-tam-mode">Send Email to '.$father_name.' (Parent Name)</h3>
			</div>
			<div class="modal-body">
			<div id="sms-overlay"><img src="'.base_url().'/template/images/ajax-loader-2.gif"></div>
			<div id="sms-feedback"></div>
			    <form class="form-horizontal" method="post" action="#" id="snd-frm">
				<div class="control-group">
				<label class="control-label" for="inputEmail">Student Name</label>
				<div class="controls">
				<p class="cstm-sts-txt">'.$name.'</p>
				</div>
				</div>
				<div class="control-group">
				<label class="control-label" for="inputEmail">Subject</label>
				<div class="controls">
				<input type="text" name="ssub" id="ssub" >
				</div>
				</div>
				<div class="control-group">
				<label class="control-label" for="inputPassword">Message</label>
				<div class="controls">
				<textarea id="smmessage" name="smmessage" placeholder="Message" style="resize:none" rows="8"> </textarea>
				</div>
				</div>
				<div class="control-group">
				<label class="control-label" for=""></label>
				<div class="controls">
				<p id="smessage_feedback"> </p>
				</div>
				</div>
				<div class="control-group">
				<div class="controls">
				<input type="hidden" value="'.$sid.'" id="mid" name="mid">
				<button type="button" class="btn btn-success" id="sndmailbtn">Send Mail</button>
				</div>
				</div>
				</form>
				
			</div>
			<div class="modal-footer">
			<button class="btn btn-success btn-small" data-dismiss="modal" aria-hidden="true">Close</button>
			
			</div>';
	  
   }
   function mail_student_snd(){
	   
	 $ssub = $this->input->post('ssub');
	   
	 $smsg = $this->input->post('smmessage');
	  
	 $mid = $this->input->post('mid');
	  
	  $this->db->select('parent_email');
	  $this->db->where('student_id',$mid);
	  $query = $this->db->get_where('student');
	  
	  $datam= $query->row_array();
	  extract($datam);
	  
	  			  $data = array();
                  $data['unread'] = $mid;
                  $data['read'] = "";
                  $data['time'] = date("Y-m-d H:i:s");
                  $data['type'] = 'parent';
                  $data['subject'] = $ssub;
                  $data['body'] = $smsg;
                 $res = $this->db->insert('email', $data);
				  
				  
                 
				  
				  if($res){
					  echo "true";
				  } else {
					  echo "false";
				  }
   }
	
	
	/* ////////////////////// Fee Collect //////////////////////// */
	
	
	function feecollect(){
		
		if ($this->session->userdata('teacher_login') != 1)
            redirect(base_url(), 'refresh');
        
      	$this->load->model('fee_model');
		
		$page_data['class_data'] = $this->fee_model->getclass();
		
        $page_data['page_name']  = 'feecollect';
        $page_data['page_title'] = get_phrase('student_fee_details');
        $this->load->view('index', $page_data);
		
		
	}
	
	function fee_collect_get_student(){
		
		$fc_cid = $this->input->post('get_fcollect_cid');
		
		$this->load->model('fee_model');
			
		$fp_student_data = $this->fee_model->getrolls($fc_cid);
		
		$sdata ='<option value="">--- select student ---</option>';
		
		foreach($fp_student_data as $fp_student_data_view){
			
			$sdata .= '<option value="'.$fp_student_data_view->student_id.'">'.$fp_student_data_view->name.'</option>';
		}
		
		echo $sdata;
	}
	
	function fee_collect_get_data(){
		$fc_cid = $this->input->post('get_fcollect_cid');
		
		$fc_rollid = $this->input->post('get_fcollect_rollid');
		
		$this->load->model('fee_model');
		
		$page_data['fcollectclassdata'] = $this->fee_model->getfeeclassdata($fc_cid);
		
		$page_data['fcollectalldata'] = $this->fee_model->getfeealldata($fc_cid);
		
		$page_data['fcollectrolldata'] = $this->fee_model->getfeerolldata($fc_cid,$fc_rollid);
		
		//$page_data['fcollectstandarddata'] = $this->fee_model->getfeestandarddata($fc_cid);
		
		$page_data['class_roll_data'] = array('fc_class_id' => $fc_cid, 'fc_roll_id' => $fc_rollid);
		
		$this->load->view('feecollectdata_techer', $page_data);
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

     public function salary_structure() {

         $user_id = $this->session->userdata('user_id');
            $this->user = $this->dbconnection->select('user', '*', 'id = ' . $user_id);
            $this->stud_id = $this->user[0]->student_id;
            $this->employee_id = $this->user[0]->employee_id;
        $this->data['page_name'] = 'salary_structure';
        $this->data['page_title'] = 'Salary Structure';
        $this->data['section'] ='teacher';
        $this->data['fetch_salary_structure'] = $this->dbconnection->select('salary_head', "id,emp_id,(select employee_code from employee where status=1 and id=emp_id) as emp_code, (select name from employee where status=1 and id=emp_id) as emp_name, year,gross_salary,(ctc_month*12) as ctc_year,ctc_month,(gross_salary-net_payable) as deduction,net_payable,(ctc_month-gross_salary) as employer_contri,start_date,end_date,active_status", "status=1 and emp_id='" . $this->employee_id . "'");
        $this->load->view('index', $this->data);
    }

		
    }
