<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Crud_model extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }
	
	function clear_cache()
	{
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
	}
	function get_type_name_by_id($type,$type_id='',$field='name')
	{
		return	$this->db->get_where($type,array($type.'_id'=>$type_id))->row()->$field;	
	}
	
	////////STUDENT/////////////
	function get_students($class_id)
	{
		$query	=	$this->db->get_where('student' , array('class_id' => $class_id));
		return $query->result_array();
	}
	
	function get_student_info($student_id)
	{
		$query	=	$this->db->get_where('student' , array('student_id' => $student_id));
		return $query->result_array();
	}
     
    function get_dormitory_students($dormitory_id)
    {
    	$query	=	$this->db->get_where('dormitory' , array('dormitory_id' => $dormitory_id));
		return $query->result_array();
    } 
	 function get_room_students($droom_id)
    {
    	$query	=	$this->db->get_where('student' , array('dormitory_room_number' => $droom_id));
		return $query->result_array();
    } 
	/////////TEACHER/////////////
	function get_teachers()
	{
		$query	=	$this->db->get('teacher' );
		return $query->result_array();
	}
	function get_dep_teachers($department_id)
	{
		$this->db->where('employee_department_id',$department_id);
		$query	=	$this->db->get('teacher' );
		return $query->result_array();
	}
	function get_teacher_name($teacher_id)
	{
		$query	=	$this->db->get_where('teacher' , array('teacher_id' => $teacher_id));
		$res	=	$query->result_array();
		foreach($res as $row)
			return $row['name'];
	}
	function get_teacher_info($teacher_id)
	{
		$query	=	$this->db->get_where('teacher' , array('teacher_id' => $teacher_id));
		return $query->result_array();
	}
	function get_staff_info($staff_id)
	{
		$query	=	$this->db->get_where('staff_data' , array('staff_id' => $staff_id));
		return $query->result_array();
	}
        function get_teacher_detail($teacher_id)
	{
		$query	=$this->db->get_where('teacher' , array('teacher_id' => $teacher_id));
		return $query->row();
	}
	
	//////////SUBJECT/////////////
	function get_subjects()
	{
		$query	= $this->db->get('subject' );
		return $query->result_array();
	}	
	function get_subject_info($subject_id)
	{
		$query	=	$this->db->get_where('subject' , array('subject_id' => $subject_id));
		return $query->result_array();
	}
	function get_subjects_by_class($class_id)
	{
		$query	=	$this->db->get_where('subject' , array('class_id' => $class_id));
		return $query->result_array();
	}
	function get_students_by_class($class_id)
	{
		$query	=	$this->db->get_where('student' , array('class_id' => $class_id));
		return $query->result_array();
	}
	function get_rooms_by_dormitory($dormitory_id)
	{
		$query	=	$this->db->get_where('room' , array('dormitory_id' => $dormitory_id));
		return $query->result_array();
	}
	function get_subject_name_by_id($subject_id)
	{
		$query	=	$this->db->get_where('subject' , array('subject_id' => $subject_id))->row();
		return $query->name;
	}
	////////////CLASS///////////
	function get_class_name($class_id)
	{
		$query	=	$this->db->get_where('class' , array('class_id' => $class_id));
		$res	=	$query->result_array();
		foreach($res as $row)
			return $row['name'];
	}
	function get_dept_name($dept_id)
	{
		$query	=	$this->db->get_where('departments' , array('department_id' => $dept_id));
		$res	=	$query->result_array();
		foreach($res as $row)
			return $row['department_name'];
	}
	function get_room_name($room_id)
	{
		$query	=	$this->db->get_where('room' , array('room_id' => $room_id));
		$res	=	$query->result_array();
		foreach($res as $row)
			return $row['name'];
	}
	function get_class_name_numeric($class_id)
	{
		$query	=	$this->db->get_where('class' , array('class_id' => $class_id));
		$res	=	$query->result_array();
		foreach($res as $row)
			return $row['name_numeric'];
	}	
	function get_classes()
	{
		$query	=	$this->db->get('class' );
		return $query->result_array();
	}	
	function get_dormitories()
	{
		$query	=	$this->db->get('dormitory' );
		return $query->result_array();
	}	
	function get_class_info($class_id)
	{
		$query	=	$this->db->get_where('class' , array('class_id' => $class_id));
		return $query->result_array();
	}
	
	//////////EXAMS/////////////
	function get_exams()
	{
		$query	=	$this->db->get('exam' );
		return $query->result_array();
	}	
	function get_exam_info($exam_id)
	{
		$query	=	$this->db->get_where('exam' , array('exam_id' => $exam_id));
		return $query->result_array();
	}	
	//////////GRADES/////////////
	function get_grades()
	{
		$query	=	$this->db->get('grade' );
		return $query->result_array();
	}	
	function get_grade_info($grade_id)
	{
		$query	=	$this->db->get_where('grade' , array('grade_id' => $grade_id));
		return $query->result_array();
	}	
	function get_grade($mark_obtained)
	{
		$query	=	$this->db->get('grade' );
		$grades	=	$query->result_array();
		foreach($grades as $row)
		{
			if($mark_obtained >= $row['mark_from'] && $mark_obtained <= $row['mark_upto'])
				return $row;
		}
	}

	function create_log($data)
	{
		$data['timestamp']	=	strtotime(date('Y-m-d').' '.date('H:i:s'));
		$data['ip']			=	$_SERVER["REMOTE_ADDR"];
		$location 			=	new SimpleXMLElement(file_get_contents('http://freegeoip.net/xml/'.$_SERVER["REMOTE_ADDR"]));
		$data['location']	=	$location->City.' , '.$location->CountryName;
		$this->db->insert('log' , $data);
	}
	function get_system_settings()
	{
		$query	=	$this->db->get('settings' );
		return $query->result_array();
	}
	
		
	
	////////BACKUP RESTORE/////////
	function create_backup($type)
	{
		$this->load->dbutil();
		
		
		$options = array(
                'format'      => 'txt',             // gzip, zip, txt
                'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
                'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
                'newline'     => "\n"               // Newline character used in backup file
              );
		
		 
		if($type == 'all')
		{
			$tables = array('');
			$file_name	=	'system_backup';
		}
		else 
		{
			$tables = array('tables'	=>	array($type));
			$file_name	=	'backup_'.$type;
		}

		$backup =& $this->dbutil->backup(array_merge($options , $tables)); 


		$this->load->helper('download');
		force_download($file_name.'.sql', $backup);
	}
	
	
	/////////RESTORE TOTAL DB/ DB TABLE FROM UPLOADED BACKUP SQL FILE//////////
	function restore_backup()
	{
		move_uploaded_file($_FILES['userfile']['tmp_name'], 'uploads/backup.sql');
		$this->load->dbutil();
		
		
		$prefs = array(
            'filepath'						=> 'uploads/backup.sql',
			'delete_after_upload'			=> TRUE,
			'delimiter'						=> ';'
        );
		$restore =& $this->dbutil->restore($prefs); 
		unlink($prefs['filepath']);
	}
	
	/////////DELETE DATA FROM TABLES///////////////
	function truncate($type)
	{
		if($type == 'all')
		{
			$this->db->truncate('student');
			$this->db->truncate('mark');
			$this->db->truncate('teacher');
			$this->db->truncate('subject');
			$this->db->truncate('class');
			$this->db->truncate('exam');
			$this->db->truncate('grade');
			$this->db->truncate('ebook');
			$this->db->truncate('pdf');
		}
		else
		{	
			$this->db->truncate($type);
		}
	}
	
	function get_email_info($email_id)
	{
		$query	=$this->db->get_where('email' , array('id' => $email_id));
		return $query->result_array();
	}
	////////IMAGE URL//////////
	function get_image_url($type = '' , $id = '')
	{
		if(file_exists('uploads/'.$type.'_image/'.$id.'.jpg'))
			$image_url	=	base_url().'uploads/'.$type.'_image/'.$id.'.jpg';
		else
			$image_url	=	base_url().'uploads/user.jpg';
			
		return $image_url;
	}
	function get_pdf_url($type = '' , $id = '')
	{
		if(file_exists('uploads/'.$type.'_files/'.$id.'.pdf')){
			$pdf_url	=	base_url().'uploads/'.$type.'_files/'.$id.'.pdf';
		}
			
		return $pdf_url;
	}
	
	
	//on 10-01-2015 for batch loading in teacher
	function get_batch($dept_id)
	{
		$query	=	$this->db->get_where('academicyear' , array('academic_id' => $dept_id));
		$res	=	$query->result_array();
		foreach($res as $row)
			return $row['session_name'];
	}
	function get_batch_all()
	{
		$query	=	$this->db->get('academicyear' );
		return $query->result_array();
	}


}

