<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Class_teachers extends MY_ListController
{
	public function __construct()
	{
                $this->page_code = 'class_teachers';
		parent::__construct();

//		switch($this->session->userdata('login_type'))
//		{
//                    case 'appadmin':
//                        $this->right_access = 'CRUD';
//                        break;
//                    case 'admin':
//                            $this->right_access = 'CRUD';
//                            break;
//                    case 'principal':
//                        $this->right_access = 'CR--';
//                        break;
//                    case 'teacher':
//                        $this->right_access = '-R--';
//                        break;
//                    default:
//                        $this->right_access = '----';
//                        redirect(base_url(), 'refresh');
//		}   

		$this->page_title = 'Class Teachers';
		$this->rec_type = 'Class Teacher';
		$this->rec_types = 'Class Teachers';
		$this->section = 'academic';
		$this->dbtable = 'class_teachet_alloc';
		$this->display_columns = array('class_id_disp' => 'Class', 'section_id_disp' => 'Section', 'teacher_id_disp' => 'Teacher');
		 $this->academic_session=$this->dbconnection->select("accedemic_session","max(id) as fin_year","active='Y'");

		$this->edit_columns = array(
			'class_id' => array('disp' => 'Class', 'type' => 'select', 'select_opts' => $this->dbconnection->select('class', 'id AS opt_id, class_name AS opt_disp', 'status="Y"'), 'required' => TRUE),
			'section_id' => array('disp' => 'Section', 'type' => 'select', 'select_opts' => $this->dbconnection->select('section', 'id AS opt_id, sec_name AS opt_disp', 'status="Y"'), 'required' => TRUE),
			'teacher_id' => array('disp' => 'Teacher', 'type' => 'select', 'select_opts' => $this->dbconnection->select('employee', 'id AS opt_id, name AS opt_disp', 'status=1 and category_id=1'), 'required' => TRUE),
			// 'teacher_id' => array('disp' => 'Teacher', 'type' => 'select', 'select_opts' => $this->dbconnection->select('employee', 'id AS opt_id, name AS opt_disp', 'status=1 and category_id=1'), 'required' => TRUE,'duplication_check' => TRUE),
			);
                $this->extra_add_columns = array('created_by'=>$this->session->userdata('user_id'),'academic_year_id'=> $this->academic_session[0]->fin_year);
                $this->extra_edit_columns = array('modified_by'=>$this->session->userdata('user_id'),'date_modified'=>date('Y-m-d H:i:s'));

		$this->search_columns = array(
			'alpha_num' => array(
				),
			'numeric' => array(
				),
			);
		if($this->session->userdata('login_type') =='teacher')
		{
			//print_r($this->session->userdata);
			
			$data = $this->dbconnection->select('user','*','id='.$this->session->userdata('user_id'));                       
			$uid =	 $data[0]->employee_id;

			$row = $this->dbconnection->GetClassTeacher($uid);
			$id=array();
			foreach($row as $data)
			{
				$id[] = $data['ids'];
			}

			$idd = implode(",",$id);
		}

		$this->rec_key = 'id';
		$this->data_table = $this->dbtable . ' AS t1';
		$this->data_select = 'id, ' .
					'class_id, (SELECT class_name FROM class WHERE id=t1.class_id) AS class_id_disp, ' .
					'section_id, (SELECT sec_name FROM section WHERE id=t1.section_id) AS section_id_disp, ' .
					'teacher_id, (SELECT name FROM employee WHERE id=t1.teacher_id) AS teacher_id_disp, ';
		
		
		if($this->session->userdata('login_type') =='teacher')
		{
			$this->data_select_where = 'status="1" AND id IN('.$idd.')';
		}
		else
		{
			$this->data_select_where = 'status="1"';
		}

		$this->data_select_order = 'class_id_disp ASC, section_id ASC';
		$this->data_delete = 'UPDATE';
		$this->data_delete_update = array('status' => '0');

	}
}
