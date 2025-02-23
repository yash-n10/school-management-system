<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exams extends MY_ListController
{
        
	public function __construct()
	{
                $this->page_code = 'exam';
		parent::__construct();
                
//                error_reporting(-1);
//                ini_set('display_errors',1);
//                $this->db->db_debug=TRUE;
                $this->academic_session=$this->dbconnection->select("accedemic_session","max(id) as fin_year","active='Y'");
		$this->page_title = 'Exams';
		$this->rec_type = 'Exam';
		$this->rec_types = 'Exams';
		$this->section = 'academic';
		$this->dbtable = 'exam';
		$this->display_columns = array('id' => '#', 'name' => 'Exam Name', 'date' => 'Exam Date','grand_total' => 'Grand Total', 'pass_mark' => 'Pass Mark');
		$this->edit_columns = array(
				'excode' => array('disp' => 'Term', 'type' => 'select', 'select_opts' => array((object) array('opt_id' => 'TERM1', 'opt_disp' => 'TERM 1'), (object) array('opt_id' => 'TERM2', 'opt_disp' => 'TERM 2'), (object) array('opt_id' => 'TERM3', 'opt_disp' => 'TERM 3')), 'required' => TRUE, 'serverRules' => 'required'),
				'name' => array('disp' => 'Exam Name', 'type' => 'text', 'required' => TRUE),
				'grand_total' => array('disp' => 'Grant Total', 'type' => 'number', 'required' => TRUE),
				'pass_mark' => array('disp' => 'Pass Mark', 'type' => 'number', 'required' => TRUE),
				
				);
                $this->extra_add_columns = array('created_by'=>$this->session->userdata('user_id'),'academic_year_id'=> $this->academic_session[0]->fin_year);
                $this->extra_edit_columns = array('modified_by'=>$this->session->userdata('user_id'),'date_modified'=>date('Y-m-d H:i:s'));

		$this->search_columns = array(
				'alpha_num' => array(
					'name',
					),
				'numeric' => array(
					),
				);
		$this->rec_key = 'id';
		$this->data_table = $this->dbtable . ' AS t1';
		$this->data_select = '*';
		$this->data_select_where = 'status="1"';
		$this->data_delete = 'UPDATE';
		$this->data_delete_update = array('status' => 'N');
	}
       
        public function index()
	{
            
                if (substr($this->right_access, 1, 1) != 'R') {
        //            redirect(base_url(), 'refresh');
                    show_permission();
                }
		$this->data['school'] = isset($this->school_desc[0]->description) ? $this->school_desc[0]->description : '';

		$this->data['page_title'] = $this->page_title;
		$this->data['display_columns'] = $this->display_columns;
                $this->data['rec_type'] = $this->rec_type;
		$this->data['rec_types'] = $this->rec_types;
		$this->data['edit_columns'] = $this->edit_columns;
		$this->data['rec_key'] = $this->rec_key;
		$this->data['section'] = $this->section;
		$this->data['read_only'] = isset($this->read_only) ? $this->read_only : FALSE;
		$this->data['modal_form'] = isset($this->modal_form) ? $this->modal_form : array('status'=>TRUE);
                $this->data['customview'] = 'academic/exam_list';
                $this->data['right_access']  = isset($this->right_access) ? $this->right_access : 'CRUD';
                $this->data['termdata']  = $this->dbconnection->select("exam",'*',"status=1 and extype='TERM'");
                $this->data['unitdata']  = $this->dbconnection->select("exam",'*',"status=1 and extype='UNIT'");
//		if (isset($this->data_select_where)) $where = $this->data_select_where; else $where = '';
//		if (isset($this->data_select_order)) $order = $this->data_select_order; else $order = '';

		$this->load->view('index', $this->data);
	}
        
        public function add()
	{
            
            if($this->input->post('extype')=='TERM') {
                $this->edit_columns = array(
                                    'excode' => array(),
                                    'name' => array(),
                                    'extype' => array(),
                                    'theory_mark' => array(),
                                    'practical_mark' => array(),
                                    'class_performance_mks' => array(),
                                    'subj_assgn_marks' => array(),
                                    'grand_total' => array(),
                                    'pass_mark' => array(),

                                    );
            }else{
                $this->edit_columns['extype']=array();
            }
            parent::add();
            
        }
        
        public function update($id)
	{
            if($this->input->post('extype')=='TERM') {
                $this->edit_columns = array(
				'excode' => array(),
				'name' => array(),
				'extype' => array(),
				'theory_mark' => array(),
				'practical_mark' => array(),
				'class_performance_mks' => array(),
				'subj_assgn_marks' => array(),
				'grand_total' => array(),
				'pass_mark' => array(),
				
				);
            }else{
                $this->edit_columns['extype']=array();
            }
            parent::update($id);
            
        }
        
        public function examSchedule($id) {
            
            $this->data['page_name'] = 'exam_schedule';
            $this->data['page_title'] = 'Exam Schedule';
            $this->data['section'] = $this->section;
            $this->data['customview'] = '';
            $this->data['exam_id'] = $id;
            $this->data['exam_name'] = $this->dbconnection->Get_namme('exam', 'id', $id,"name");
            $this->data['exam_details'] = $this->dbconnection->select('exam', '*', "id=$id");
            $this->data['classes'] = $this->dbconnection->select('class', '*', 'status="Y"');
            $this->data['section1'] = $this->dbconnection->select('section', '*', 'status="Y"');
            $this->data['course'] = $this->dbconnection->select('course', '*', 'status="Y"');
            $this->data['exam'] = $this->dbconnection->select('exam', '*', 'status=1 and academic_year_id='.$this->academic_session[0]->fin_year);
            $this->data['sectionname'] = array_column($this->dbconnection->select_returnarray('section', '*', 'status="Y"'), "sec_name", "id");
            $this->data['subjects'] = $this->dbconnection->select('subject', '*', 'status=1');
            
            $this->data['right_access'] = $this->right_access;
            $this->data['task'] = 'Save';

            $this->load->view('index', $this->data);
            
        }
        
        
        public function getSchedule() {
            
            $classid=$this->input->post('classid');
            $sectionid=$this->input->post('sectionid');
            $courseid=$this->input->post('courseid');
            $examid=$this->input->post('examid');
            $tbody='';
            $examhead=$this->dbconnection->select("exam_routine_head","*","exam_id=$examid and class_id=$classid and section_id=$sectionid and course_id=$courseid and status=1 and academic_year_id=".$this->academic_session[0]->fin_year);
            $subjects = $this->dbconnection->select_join('subject s', 's.id,s.name', "s.status=1 and cst.status=1 and cst.class_id=$classid and cst.section_id=$sectionid","class_subject_teacher cst","s.id=cst.subject_id","inner");
            $exam_details = $this->dbconnection->select('exam', '*', "id=$examid");
            if(empty($examhead)){
                $tbody.="<tr><td style='width:14%'><input type='date' name='date_exam[]' class='form-control'></td>";
                $tbody.="<td style='width:14%'>";
                $tbody.="<select name='subject[]' class='form-control'><option value=''></option>";
                foreach ($subjects as $value) {
                    $tbody.="<option value='$value->id'>$value->name</option>";
                }
                
                $tbody.="</select></td>";
                // $tbody.="<td style='width:14%'><input type='number' name='total[]' class='form-control'></td><td style='width:14%'><input type='number' name='pass[]' class='form-control' ></td>";
                $tbody.="<td style='width:14%'><div class='input-group input-append bootstrap-timepicker' ><input value ='' type='text' class='form-control time-picker' name ='start_time[]'><span class='input-group-addon add-on'><i class='fa fa-clock-o'></i></span></div></td>";
//                $tbody.="<td style='width:14%'><div class='input-group'><input type='text' class='form-control timepicker'><div class='input-group-addon'><i class='fa fa-clock-o'></i></div></div></td>";
                $tbody.="<td style='width:14%'><div class='input-group input-append bootstrap-timepicker' ><input value ='' type='text' class='form-control time-picker' name ='end_time[]'><span class='input-group-addon add-on'><i class='fa fa-clock-o'></i></span></div></td>";
                $tbody.="<td style='width:14%'><input type='text' name='room[]' class='form-control'></td><td style='width:2%'></td></tr>";
                
            }else{
                $examdet=$this->dbconnection->select("exam_routine_det","*","exam_routine_head_id={$examhead[0]->id} and status=1");
                foreach ($examdet as $ed) {
                    $tbody.="<tr><td style='width:14%'><input type='date' name='date_exam[]' class='form-control' value='$ed->date' required></td>";
                    $tbody.="<td style='width:14%'>";
                    $tbody.="<select name='subject[]' class='form-control'><option value='' required>--Select Subject--</option>";
                    foreach ($subjects as $value) {
                        if ($ed->subject_id == $value->id) {
                            $selected="selected=selected";
                        }else{
                            $selected="";
                        }
                        $tbody.="<option value='$value->id' $selected>$value->name</option>";
                    }

                    $tbody.="</select></td>";
                    // $tbody.="<td style='width:14%'><input type='number' name='total[]' class='form-control' value='$ed->total_marks' required></td><td style='width:14%'><input type='number' name='pass[]' class='form-control' value='$ed->pass_marks'></td>";
                    $tbody.="<td style='width:14%'><div class='input-group input-append bootstrap-timepicker' ><input value='$ed->start_timing' type='text' class='form-control time-picker' name ='start_time[]' required><span class='input-group-addon add-on'><i class='fa fa-clock-o'></i></span></div></td>";
    //                $tbody.="<td style='width:14%'><div class='input-group'><input type='text' class='form-control timepicker'><div class='input-group-addon'><i class='fa fa-clock-o'></i></div></div></td>";
                    $tbody.="<td style='width:14%'><div class='input-group input-append bootstrap-timepicker' ><input value='$ed->end_timing' type='text' class='form-control time-picker' name ='end_time[]' required><span class='input-group-addon add-on'><i class='fa fa-clock-o'></i></span></div></td>";
                    // $tbody.="<td style='width:14%'><input type='text' name='room[]' class='form-control' value='$ed->room_no'></td><td style='width:2%'></td></tr>";
                }
            }
            $this->data1['tbody']=$tbody;
            echo json_encode($this->data1);
            
        }
        
        
        public function getSubjects() {
            $classid=$this->input->post('classid');
            $sectionid=$this->input->post('sectionid');
            $courseid=$this->input->post('courseid');
            $examid=$this->input->post('examid');
            $subjects = $this->dbconnection->select_join('subject s', 's.id,s.name', "s.status=1 and cst.status=1 and cst.class_id=$classid and cst.section_id=$sectionid","class_subject_teacher cst","s.id=cst.subject_id","inner");
            echo json_encode($subjects);
        }
        
        public function saveSchedule() {
            
            $classid=$this->input->post('classid');
            $sectionid=$this->input->post('sectionid');
            $courseid=$this->input->post('courseid');
            $examid=$this->input->post('examid');
            $examhead=$this->dbconnection->select("exam_routine_head","*","exam_id=$examid and class_id=$classid and section_id=$sectionid and course_id=$courseid and status=1 and academic_year_id=".$this->academic_session[0]->fin_year);
            if(empty($examhead)){
                $datahead=array(
                            'academic_year_id'=>$this->academic_session[0]->fin_year,
                            'class_id'=>$classid,
                            'section_id'=>$sectionid,
                            'course_id'=>$courseid,
                            'exam_id'=>$examid,
                            'created_by'=>$this->session->userdata('user_id')
                );
                        
                $this->dbconnection->insert('exam_routine_head', $datahead);
                $last_id=$this->dbconnection->get_last_id();
                $this->insertSchedule($last_id,'Created');
            }else{
                $this->dbconnection->update("exam_routine_det",["status"=>0,"date_modified"=>date('Y-m-d H:i:s'),"modified_by"=>$this->session->userdata('user_id')],"exam_routine_head_id={$examhead[0]->id}");
                $this->insertSchedule($examhead[0]->id,'Updated');
            }
            
        }
        
        public function insertSchedule($last_id,$msg) {
            
                
                foreach($this->input->post('date_exam') as $key=>$det) {
                    $datadet=array(
                            'exam_routine_head_id'=>$last_id,
                            'date'=>$det,
                            'subject_id'=>$this->input->post('subject')[$key],
                            'total_marks'=>'',
                            'pass_marks'=>'',
                            'start_timing'=>$this->input->post('start_time')[$key],
                            'end_timing'=>$this->input->post('end_time')[$key],
                            'room_no'=>'',
                            'created_by'=>$this->session->userdata('user_id')
                );
                        
                $this->dbconnection->insert('exam_routine_det', $datadet);
                }
                
                 //$this->session->set_userdata('successmsg', "Successfully $msg Record");
                $this->data1['msg']="Successfully $msg Record";
                 $this->getSchedule();
        }

        public function pdf_exam_routine() {

        $examid = $this->uri->segment(4);
        $classid = $this->uri->segment(5);
        $sectionid = $this->uri->segment(6);
        // $section_id = $this->uri->segment(7);

        
        $invoice_demo_id = 4;
        $school_data=$this->school_desc = $this->dbconnection->select("crmfeesclub.school", "*", "id=" . $this->id . " and status = 1");

        $pdf_id = $invoice_demo_id;
        $data_inv = $this->dbconnection->select('crmfeesclub.invoice_demo', '*', 'id=' . $pdf_id);
        $inv_view = $data_inv[0]->invoice_page_view;
        $size = $data_inv[0]->size;
        $invoice_demo_no = $data_inv[0]->invoice_demo_no;
        $orientation = $data_inv[0]->orientation;
        $session=$this->academic_session[0]->session;


        $examhead=$this->dbconnection->select("exam_routine_head","*","exam_id=$examid and class_id=$classid and section_id=$sectionid and status=1 and academic_year_id=".$this->academic_session[0]->fin_year);

        $subjects = $this->dbconnection->select_join('subject s', 's.id,s.name', "s.status=1 and cst.status=1 and cst.class_id=1 and cst.section_id=1","class_subject_teacher cst","s.id=cst.subject_id","inner");

        $exam_details = $this->dbconnection->select('exam', '*', "id=$examid");

        $examdet=$this->dbconnection->select("exam_routine_det","*","exam_routine_head_id={$examhead[0]->id} and status=1");

        // print_r($examdet);
        // die();

        $array = array('examhead' => $examhead,'subjects'=>$subjects,  'school_data' => $school_data,'session'=>$session,'exam_details'=>$exam_details,'examdet'=>$examdet);
        $this->load->view('academic/' . $inv_view, $array);
        $html = $this->output->get_output();
        $this->load->library('pdf');
        $this->dompdf->load_html($html);
        $this->dompdf->set_paper($size, $orientation);
        if ($invoice_demo_no == '5') {
            $customPaper = array(0, 0, 280, 1000);
            $this->dompdf->set_paper($customPaper);
        }
        $this->dompdf->render();
        $this->dompdf->stream("Routine.pdf", array("Attachment" => false));
    }
        
        
        
}
