<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Modal extends CI_Controller {

	
	function __construct()
    {
        parent::__construct();
		$this->load->database();
		$this->load->helper('tam_helper');
		/*cache control*/
		$this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
    }
	
	/***default functin, redirects to login page if no admin logged in yet***/
	public function index()
	{
		
	}
	
	
	function popup($param1 = '' , $param2 = '' , $param3 = '')
	{
		if($param1	==	'student_profile' )
		{
			$page_data['current_student_id']	=	$param2;
		}
		else if($param1	==	'dormitory_profile' )
		{
			$page_data['dormitory_id']	=	$param2;
		}
		else if($param1	==	'dormitory_room' )
		{
			$page_data['droom_id']	=	$param2;
		}
		else if($param1	== 'student_academic_result')
		{
			$page_data['current_student_id']	=	$param2;
		}
		else if($param1	== 'student_id_card')
		{
			$page_data['current_student_id']	=	$param2;
		}
		else if($param1	== 'student_sms')
		{
			$page_data['current_student_id']	=	$param2;
		}
		else if($param1	== 'student_mail')
		{
			$page_data['current_student_id']	=	$param2;
		}
		else if($param1	==	'student_promote')
		{
			$page_data['edit_data']	=	$this->db->get_where('student' , array('student_id'=>$param2))->result_array();
			$page_data['class_id']	=	$param3;
			$page_data['current_student_id']	=	$param2;
		}
		else if($param1	== 'edit_student')
		{
			$this->db->where('status',1);
		    $page_data['country_data'] = $this->db->get_where('tam_country')->result_array();
			$page_data['edit_data']	=	$this->db->get_where('student' , array('student_id'=>$param2))->result_array();
			$page_data['class_id']	=	$param3;
		}
		else if($param1	== 'teacher_id_card')
		{
			$page_data['current_teacher_id']	=	$param2;
		}
		else if($param1	== 'staff_id_card')
		{
			$page_data['current_staff_id']	=	$param2;
		}
		else if($param1	== 'teacher_profile')
		{
			$page_data['current_teacher_id']=	$param2;
		}
		else if($param1	== 'staff_profile')
		{
			$page_data['current_staff_id']=	$param2;
		}
                else if($param1	=='email_body')
		{
			$page_data['current_email_id']=	$param2;
		}
		else if($param1	== 'edit_teacher')
		{
			$this->db->where('department_status','active');
		    $page_data['departments'] = $this->db->get('departments')->result_array();
			$page_data['edit_data']	=	$this->db->get_where('teacher' , array('teacher_id'=>$param2))->result_array();
			
		}
		else if($param1	== 'edit_staff')
		{
			$this->db->where('department_status','active');
		    $page_data['departments'] = $this->db->get('departments')->result_array();
			$page_data['edit_data']	=	$this->db->get_where('staff_data' , array('staff_id'=>$param2))->result_array();
		}
		else if($param1	== 'add_parent')
		{
			$page_data['student_id']=	$param2;
			$page_data['class_id']	=	$param3;
		}
		else if($param1	== 'edit_parent')
		{
			$page_data['edit_data']	=	$this->db->get_where('parent' , array('parent_id'=>$param2))->result_array();
			$page_data['class_id']	=	$param3;
		}
		else if($param1	== 'edit_academicyear')
		{
			$page_data['edit_data']	=	$this->db->get_where('academicyear' , array('academic_id'=>$param2))->result_array();
		}
		else if($param1	== 'edit_subject')
		{
			$page_data['edit_data']	=	$this->db->get_where('subject' , array('subject_id'=>$param2))->result_array();
		}
		/***START this code added on 01-08-2014 by KP*****/
		else if($param1	== 'edit_fees_category')
		{
			$page_data['edit_data']	=	$this->db->get_where('fees_category' , array('fees_category_id'=>$param2))->result_array();
		}
		else if($param1	== 'edit_class_wise_fees')
		{
			$page_data['edit_data']	= $this->db->get_where('class_wise_fees' , array('fee_amount_id'=>$param2))->result_array();
		}
		else if($param1	=='edit_student_fees')
		{
			$page_data['class_id']		= $param3;
			$page_data['student_id']        = $param2;
		}
		/***END this code added on 01-08-2014 by KP*****/
		else if($param1	== 'edit_class')
		{
			$this->db->where('standard_status','active');
		
			$page_data['standards'] = $this->db->get('standard')->result_array();
			$page_data['edit_data']	= $this->db->get_where('class' , array('class_id'=>$param2))->result_array();
		}
		else if($param1	== 'edit_exam')
		{
			$page_data['edit_data']	= $this->db->get_where('exam' , array('exam_id'=>$param2))->result_array();
		}
		else if($param1	== 'edit_grade')
		{
			$page_data['edit_data']	= $this->db->get_where('grade' , array('grade_id'=>$param2))->result_array();
		}
		else if($param1	== 'edit_class_routine')
		{
			$page_data['edit_data']	= $this->db->get_where('class_routine' , array('class_routine_id'=>$param2))->result_array();
		}
		else if($param1	== 'view_invoice')
		{
			$page_data['edit_data']	= $this->db->get_where('invoice' , array('invoice_id'=>$param2))->result_array();
		}
		else if($param1	== 'edit_invoice')
		{
			$page_data['edit_data']	= $this->db->get_where('invoice' , array('invoice_id'=>$param2))->result_array();
		}
		else if($param1	== 'edit_book')
		{
			$page_data['edit_data']	= $this->db->get_where('book' , array('book_id'=>$param2))->result_array();
		}else if($param1	==	'edit_books_category')
		{
			$page_data['edit_data']	=	$this->db->get_where('books_category' , array('books_category_id'=>$param2))->result_array();
		}
		else if($param1	== 'edit_transport')
		{
			$page_data['edit_data']	= $this->db->get_where('transport' , array('transport_id'=>$param2))->result_array();
		}
		else if($param1	== 'add_pickups')
		{
			$page_data['route_id']	=	$param2;
			
			$page_data['points_data']	= $this->db->get_where('transport_points' , array('prid'=>$param2))->result();
		}
		else if($param1	== 'edit_dormitory')
		{
			$page_data['edit_data']	= $this->db->get_where('dormitory' , array('dormitory_id'=>$param2))->result_array();
		}
		else if($param1	== 'edit_room')
		{
			$page_data['edit_data']	= $this->db->get_where('room' , array('room_id'=>$param2))->result_array();
		}
		else if($param1	== 'edit_notice')
		{			
			$page_data['edit_data']	= $this->db->get_where('noticeboard' , array('notice_id'=>$param2))->result_array();
		}
		else if($param1	== 'edit_leave')
		{	
		$this->db->select('leave_data.*,leave_types.leave_type_title as ltype,leave_types.leave_type_max_days');
		
		$this->db->from('leave_data');
		
		$this->db->join('leave_types','leave_type_id=leave_tid');	
		
		$this->db->where('leave_id',$param2);	
			$page_data['edit_data']	= $this->db->get()->result_array();
			
			$this->load->model('leave_model');
		
		    $page_data['ltype_data'] = $this->leave_model->listltypes();
		}
		else if($param1	== 'edit_classnotice')
		{			
			$page_data['edit_data']	= $this->db->get_where('classnotice' , array('notice_id'=>$param2))->result_array();			
		}
		else if($param1	== 'edit_staffnotice')
		{			
			$page_data['edit_data']	= $this->db->get_where('staffnotice' , array('notice_id'=>$param2))->result_array();			
		}
		else if($param1	== 'edit_assignment')
		{
			$page_data['edit_data']	= $this->db->get_where('assignments' , array('assignment_id'=>$param2))->result_array();
		}
                else if($param1 == 'teacher_enquiry'){
                    $page_data['teacher_id']    = $param2;
                    
                    $subject__id = $param3;
                    $this->db->select('student.name as student_name,student.student_id,teacher.name as teacher_name,teacher.teacher_id,teacher.email,class.name as class_name,subject.name,subject.subject_id,subject.class_id');
                    $this->db->from('subject');
                    $this->db->join('teacher', 'subject.teacher_id =teacher.teacher_id');
                    $this->db->join('class', 'class.class_id =subject.class_id');
                    $this->db->join('student', 'student.class_id =subject.class_id');
                    $this->db->where(array('subject.subject_id' => $param3,'student.student_id' =>$this->session->userdata('parent_id')));
                    $page_data['info'] = $this->db->get()->row();
                    $page_data['student_name']  = $param3;
                    $page_data['class_name']    = $param4;
                    $page_data['subject_name']  = $param5;
                }
		else if($param1	== 'edit_timetable_category')
		{
			$page_data['edit_data']	= $this->db->get_where('timetable_categories' , array('timetable_category_id'=>$param2))->result_array();
		}
		else if($param1	== 'edit_employee_category')
		{
			$page_data['edit_data']	= $this->db->get_where('employee_categories' , array('employee_category_id'=>$param2))->result_array();
		}
		else if($param1	== 'edit_department')
		{
			$page_data['edit_data']	= $this->db->get_where('departments' , array('department_id'=>$param2))->result_array();
		}
		else if($param1	== 'edit_standard')
		{
			$page_data['edit_data']	= $this->db->get_where('standard' , array('standard_id'=>$param2))->result_array();
		}
		else if($param1	== 'edit_timetable')
		{
			$this->load->library('fckeditor');
			$this->db->where('timetable_category_status','active');
		$page_data['timetable_categories_view']   = $this->db->get('timetable_categories')->result_array();
			$page_data['edit_data']	= $this->db->get_where('timetables' , array('timetable_id'=>$param2))->result_array();
		}
		$page_data['page_name']	= $param1;		
		$this->load->view('modal' ,$page_data);
	}
}

