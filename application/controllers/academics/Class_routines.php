<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Class_routines extends CI_Controller {

    public $page_code = 'class_routine';
    public $page_id = '';
    public $page_perm = '----';

    public function __construct() {


        parent::__construct();
//        error_reporting(-1);
//        ini_set('display_errors', 1);
//        $this->db->db_debug=TRUE;
        $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");

       // switch ($this->session->userdata('login_type')) {
       //     case 'appadmin':
       //         $this->right_access = 'CRUD';
       //         break;
       //     case 'admin':
       //         $this->right_access = 'CRUD';
       //         break;
       //     case 'principal':
       //         $this->right_access = '-R--';
       //         break;
       //     case 'office':
       //         $this->right_access = 'CR--';
       //         break;
       //     default:
       //         $this->right_access = '----';
       //         redirect(base_url(), 'refresh');
       // }
        $this->id = $this->session->userdata('school_id');
        $this->school_desc = $this->dbconnection->select("school", "*", "id=" . $this->id . " and status = 1");
        $this->schools = $this->dbconnection->select("school", "*", 'status = 1');

        if ($this->id != 0)
            $this->db->db_select('crmfeesclub_' . $this->id);
        
        $this->academic_session=$this->dbconnection->select("accedemic_session","id as fin_year,start_date,end_date","active='Y'","id","DESC","1");

        $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
        $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
        $this->right_access = $this->page_perm;

        if (strpos($this->page_perm, '----') == true) {
            redirect(base_url(''), 'refresh');
        }

        $this->page_title = 'Class Routine';
        $this->section = 'academic';
        $this->page_name = 'class_routine_list';
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
        $this->data['academic_session'] = $this->academic_session[0]->fin_year;
        $this->data['classes'] = $this->dbconnection->select('class', '*', 'status="Y"');
        $this->data['section1'] = $this->dbconnection->select('section', '*', 'status="Y"');
        $this->data['sectionname'] = array_column($this->dbconnection->select_returnarray('section', '*', 'status="Y"'), "sec_name", "id");
        $this->data['subjects'] = $this->dbconnection->select('subject', '*', 'status=1');
        $this->data['teacher'] = $this->dbconnection->select('employee', '*', 'status=1 and category_id=1');
        $db=$this->db->query("select ct.teacher_id,concat(e.employee_code,'-',e.name) name,ct.class_id,ct.section_id from class_teachet_alloc ct inner join employee e on ct.teacher_id=e.id and e.category_id=1 where ct.status=1 and e.status=1")->result();
        $this->data['teachername'] = $this->query_to_array_convert($db, 'class_id', 'section_id', 'name');
        $this->data['coursename'] = $this->dbconnection->select('course', '*', 'status="Y"');
        //print_r($db);
        $this->data['period'] = $this->dbconnection->select('class_periods', '*', 'status=1', 'time_start');
       $this->data['classroutinedata'] = $this->dbconnection->getClassRoutine();
        $this->data['right_access'] = $this->right_access;
  // echo "<pre>"; print_r($this->data);die();
        $this->load->view('index', $this->data);
    }

    
    public function addClassRoutine($task='Save') {
        
        if (substr($this->right_access, 0, 1) != 'C' ) {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
                $this->data['page_name'] = 'add_class_routine';
		$this->data['page_title'] = $this->page_title;
		$this->data['section'] = $this->section;
		$this->data['customview'] = $this->customview;

		$this->data['task'] = $task;
		$this->data['clas'] = '';
		$this->data['sec'] = '';
                $this->data['classroutine']=array();
		$this->data['classroutine_id'] = 0;
		$this->data['classlist'] = $this->dbconnection->select('class', '*', 'status="Y"');
        $this->data['sectionlist'] = $this->dbconnection->select('section', '*', 'status="Y"');
        $this->data['courselist'] = $this->dbconnection->select('course', '*', 'status="Y"');
        $this->data['period'] = $this->dbconnection->select('class_periods', '*', 'status=1', 'time_start');
//                $this->data['subjects'] = $this->dbconnection->select('subject', '*', 'status=1');
        // $this->data['subjects'] = $this->dbconnection->select_join('subject s', 's.id,s.name', "s.status=1 and cst.status=1 and cst.academic_year_id={$this->academic_session[0]->fin_year}","class_subject_teacher cst","s.id=cst.subject_id ","inner");
        $this->data['subjects'] = $this->db->query("select s.id,s.name,cst.teacher_id from subject s,class_subject_teacher cst where cst.status=1 and s.status=1 and cst.academic_year_id={$this->academic_session[0]->fin_year} and s.id=cst.subject_id");
		$this->load->view('index', $this->data);
        
    }
    
    public function save() {

        if (substr($this->right_access, 0, 1) != 'C' || $this->input->method(FALSE)!='post') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->form_validation->set_rules('class_list', 'Class ', 'required');
        $this->form_validation->set_rules('section_list', 'Section', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->form_validation->set_error_delimiters('<div class="error" style="color:red">', '</div>');
//            $this->session->set_flashdata('errormsg', "There");
            $this->addClassRoutine('Save');
            
        } else {
           
            $dayarray=array('1'=>'sunday','2'=>'monday','3'=>'tuesday','4'=>'wednesday','5'=>'thursday','6'=>'friday','7'=>'saturday');
            
            for ($d = 2; $d <= 7; $d++) {
                
                foreach($this->input->post('subject_id')[$dayarray[$d]] as $key=>$value) {
                    $data['class_id'] = $this->input->post('class_list');
                    $data['subject_id'] = $value;
                    $data['period_id'] = $key;
                    $data['day'] = $dayarray[$d];
                    $data['section_id'] = $this->input->post('section_list');
                    $data['course_id'] = $this->input->post('course_list');
                    $data['status'] = 1;
                    $data['academic_year_id'] = $this->academic_session[0]->fin_year;
                    $data['date_created'] = date('Y-m-d H:i:s');
                    $data['created_by'] =$this->session->userdata('user_id');

                    $this->db->insert('class_routine', $data);
                }
                
            }
            
                
            
            
            $this->session->set_flashdata('successmsg', "Successfully Created Record");
           if($this->uri->segment(3)=='addClassRoutine') {
               header("Location: " . site_url("academics/class_routines/addClassRoutine"));
           }else{
               header("Location: " . site_url("academics/class_routines/editClassRoutine/").$this->input->post('class_list')."/".$this->input->post('section_list')."/".$this->input->post('course_list'));
           }
            
            
        }
        
    }
    
    public function editClassRoutine($clas,$sec,$crse,$task='Update') {
        if (substr($this->right_access, 2, 1) != 'U'  ) {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
                $this->data['page_name'] = 'add_class_routine';
		$this->data['page_title'] = $this->page_title;
		$this->data['section'] = $this->section;
		$this->data['customview'] = $this->customview;

		$this->data['task'] = $task;
		$this->data['classroutine_id'] = 0;
		$this->data['classlist'] = $this->dbconnection->select('class', '*', 'status="Y"');
                $this->data['sectionlist'] = $this->dbconnection->select('section', '*', 'status="Y"');
                $this->data['period'] = $this->dbconnection->select('class_periods', '*', 'status=1', 'time_start');
                $this->data['subjects'] = $this->dbconnection->select_join('subject s', 's.id,s.name', "s.status=1 and cst.status=1 and cst.class_id=$clas and cst.section_id=$sec and cst.academic_year_id={$this->academic_session[0]->fin_year}","class_subject_teacher cst","s.id=cst.subject_id","inner");
//                $this->data['subjects'] = $this->dbconnection->select('subject s', 's.id,s.name', "s.status=1");
                
                $clasroutine=$this->dbconnection->select("class_routine","subject_id,day,period_id","status=1 and class_id=$clas and section_id=$sec and academic_year_id={$this->academic_session[0]->fin_year}");
		
                $qclassroutine=array();
                foreach ($clasroutine as $value) {
                   $qclassroutine[$value->day][$value->period_id]=$value->subject_id; 
                }
                
                if(empty($qclassroutine)) {
                    $this->data['task'] = 'Save';
                }
                $this->data['qclassroutine']=$qclassroutine;
                $this->data['clas']=$clas;
                $this->data['sec']=$sec;
                $this->data['crse']=$crse;
                
                $this->load->view('index', $this->data);
        
    }

//    public function update() {
//
//        if (substr($this->right_access, 2, 1) != 'U') {
////            redirect(base_url(), 'refresh');
//            redirect('404');
//        }
//        $this->data['page_name'] = $this->page_name;
//        $this->data['page_title'] = $this->page_title;
//        $this->data['section'] = $this->section;
//        $this->data['customview'] = $this->customview;
//
//        $c_id = $this->uri->segment(4);
//
////$data['class_id'] = $this->input->post('class_id');
//        $data['subject_id'] = $this->input->post('subject_id');
//        /* $data['time_start'] = $this->input->post('time_start');
//          $data['time_start_min'] = $this->input->post('time_start_min');
//          $data['time_end'] = $this->input->post('time_end');
//          $data['time_end_min'] = $this->input->post('time_end_min'); */
//        $data['period_id'] = $this->input->post('period');
//        $data['day'] = $this->input->post('day');
//        $data['section_id'] = $this->input->post('section_id');
//        $table = 'class_routine';
//
//        $this->dbconnection->update($table, $data, 'id=' . $c_id);
//        
//    }
    
    public function update() {
        
        if (substr($this->right_access, 2, 1) != 'U' || $this->input->method(FALSE)!='post') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->form_validation->set_rules('class_list', 'Class ', 'required');
        $this->form_validation->set_rules('section_list', 'Section', 'required');
        if ($this->form_validation->run() == FALSE) {
            $this->form_validation->set_error_delimiters('<div class="error" style="color:red">', '</div>');
//            $this->session->set_flashdata('errormsg', "There");
            $this->editClassRoutine($this->input->post('class_list'),$this->input->post('section_list'),'Update');
            
        } else {
            
            $this->dbconnection->update("class_routine",["status"=>0,"date_modified"=>date('Y-m-d H:i:s'),"modified_by"=>$this->session->userdata('user_id')],"class_id={$this->input->post('class_list')} and section_id={$this->input->post('section_list')} and status=1 and academic_year_id={$this->academic_session[0]->fin_year}");
            
            $dayarray=array('1'=>'sunday','2'=>'monday','3'=>'tuesday','4'=>'wednesday','5'=>'thursday','6'=>'friday','7'=>'saturday');
            
            for ($d = 2; $d <= 7; $d++) {
                
                foreach($this->input->post('subject_id')[$dayarray[$d]] as $key=>$value) {
                    $data['class_id'] = $this->input->post('class_list');
                    $data['subject_id'] = $value;
                    $data['period_id'] = $key;
                    $data['day'] = $dayarray[$d];
                    $data['section_id'] = $this->input->post('section_list');
                    $data['course_id'] = $this->input->post('course_list');
                    $data['status'] = 1;
                    $data['academic_year_id'] = $this->academic_session[0]->fin_year;
                    $data['date_created'] = date('Y-m-d H:i:s');
                    $data['created_by'] =$this->session->userdata('user_id');

                    $this->db->insert('class_routine', $data);
                }
                
            }
            
                
            
            
            $this->session->set_flashdata('successmsg', "Successfully Updated Record");
            header("Location: " . site_url("academics/class_routines/editClassRoutine/").$this->input->post('class_list')."/".$this->input->post('section_list'));
            
        }
        
        
    }

//    public function delete() {
//
//        if (substr($this->right_access, 3, 1) != 'D') {
////            redirect(base_url(), 'refresh');
//            redirect('404');
//        }
//        $this->data['page_name'] = $this->page_name;
//        $this->data['page_title'] = $this->page_title;
//        $this->data['section'] = $this->section;
//        $this->data['customview'] = $this->customview;
//
//        $cr_id = $this->input->post('cr');
//        $data = array('status' => 0);
//        $this->dbconnection->update('class_routine', $data, 'id=' . $cr_id);
//    }
    
    public function query_to_array_convert($query_fee, $indx1, $indx2, $val) {

        $array = [];
        foreach ($query_fee as $value) {
            $array[$value->$indx1][$value->$indx2] = $value->$val;
        }

        return $array;
    }
    
    public function getSubjects() {
        $classid=$this->input->post('classid');
        $sectionid=$this->input->post('sectionid');
        $courseid=$this->input->post('courseid');
        if(empty($sectionid)){
            $q=" and cst.class_id=$classid";   
        }
       else{
            $q=" and cst.class_id=$classid and cst.section_id=$sectionid";
        }
        
        $fetch_subject=$this->dbconnection->select_join("class_subject_teacher cst","cst.subject_id,s.name","s.status=1 and cst.status=1 and cst.academic_year_id={$this->academic_session[0]->fin_year} $q","subject s","s.id=cst.subject_id","inner");
        
        $option="<option value=''>-- Select --</option>";
        foreach ($fetch_subject as $value) {
            
            $option.="<option value='$value->subject_id'>$value->name</option>";
            
        }
        if($this->session->userdata('school_id')==5)
        {
            if(($classid==14) || ($classid==15)){
                $check_data=$this->dbconnection->select("class_routine","id","class_id=$classid and section_id='$sectionid' and course_id='$courseid' and status=1 and academic_year_id={$this->academic_session[0]->fin_year}");
            }
            else{
                $check_data=$this->dbconnection->select("class_routine","id","class_id=$classid and section_id='$sectionid' and status=1 and academic_year_id={$this->academic_session[0]->fin_year}");
            }
        }
        
        if(count($check_data)>0) {
            $already='true';
        }else{
            $already='false';
        }
  
     
        echo json_encode([$option,$already]);
        
    }


    public function prints()
    {
        // error_reporting(-1);
        // ini_set('display_errors', 1);
        // $this->db->debug=TRUE;


        $academic_session = $this->academic_session[0]->fin_year;
        $classes = $this->dbconnection->select('class', '*', 'status="Y"');
        $section1 = $this->dbconnection->select('section', '*', 'status="Y"');
        $sectionname = array_column($this->dbconnection->select_returnarray('section', '*', 'status="Y"'), "sec_name", "id");
        $subjects = $this->dbconnection->select('subject', '*', 'status=1');
        $teacher= $this->dbconnection->select('employee', '*', 'status=1 and category_id=1');

        $db=$this->db->query("select ct.teacher_id,concat(e.employee_code,'-',e.name) name,ct.class_id,ct.section_id from class_teachet_alloc ct inner join employee e on ct.teacher_id=e.id and e.category_id=1 where ct.status=1 and e.status=1")->result();
            $teachername = $this->query_to_array_convert($db, 'class_id', 'section_id', 'name');
            $period = $this->dbconnection->select('class_periods', '*', 'status=1', 'time_start');
        $school = $this->school_desc;
        $array = array('students'=>$db,'school'=>$school,'classes'=>$classes,'section1'=>$section1,'sectionname'=>$sectionname,'subjects'=>$subjects,'teacher'=>$teacher,'teachername'=>$teachername,'period'=>$period,'academic_session'=>$academic_session);
        $this->load->view('academic/print/class_routine_print',$array);
        $html = $this->output->get_output();
        $this->load->library('pdf');
        $this->dompdf->load_html($html);
        $this->dompdf->set_paper('A3','landscape');
        $this->dompdf->render();
        ob_end_clean();
        $this->dompdf->stream("ClassRoutine.pdf", array("Attachment" => FALSE));
        
    }

}
