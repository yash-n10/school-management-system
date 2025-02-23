<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Holidays extends CI_Controller 
{
        public $page_code = 'holiday';
        public $page_id = '';
        public $page_perm = '----';
        
	public function __construct() 
        {
		parent::__construct();

		$this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");
 
		$this->id=$this->session->userdata('school_id');
                $this->academic_session=array();
		$this->school_desc=$this->dbconnection->select("school","*", "id=".$this->id." and status = 1");
		$this->schools=$this->dbconnection->select("school","*",'status = 1');
		$this->bank=$this->dbconnection->select("bank","*");
		if ($this->id !=0 ) {
                    $this->db->db_select('crmfeesclub_'.$this->id);                 
                    $this->academic_session=$this->dbconnection->select("accedemic_session","max(id) as fin_year","active='Y'");
                }
                
                $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
                $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
                $this->right_access = $this->page_perm;

                if (strpos($this->page_perm, '----') == true) {
                    redirect(base_url(''), 'refresh');
                }
                $this->page_title = 'Holidays';
		$this->section = 'hr';
		$this->page_name = 'holidays';
		$this->customview = '';
	}
        
        
        public function index($param1 = '')
        {
                if (substr($this->right_access, 1, 1) != 'R') {
        //            redirect(base_url(), 'refresh');
                    redirect('404');
                }        
		if ($param1 == '') {
			$year_list=date('Y');
		} else {
			$year_list=$param1;
		}

		$this->data['page_name'] = $this->page_name;
		$this->data['page_title'] = $this->page_title;
		$this->data['section'] = $this->section;
		$this->data['customview'] = $this->customview;
		$this->data['year_list'] = $year_list;
		$this->data['right_access'] = $this->right_access;
		$this->data['fetch_holiday'] = $this->dbconnection->select('holiday','*,(concat((select DAYNAME(holiday_date_from)),"",(IF((select DAYNAME(holiday_date_to)) is NULL,"",(select concat(" - ",DAYNAME(holiday_date_to))))))) as day_name',"status=1 and year=$year_list");

		$this->load->view('index', $this->data);
        }

	public function year($year = '') {
		$this->index($year);
	}

	public function save() {
                
                if (substr($this->right_access, 0, 1) != 'C') {
        //            redirect(base_url(), 'refresh');
                    redirect('404');
                }
        
		$data=array(
				'holiday_name' => $this->input->post('hname'),                          
				'holiday_date_from' => $this->input->post('hdate_from'),                          
				'holiday_date_to' => $this->input->post('hdate_to'),                          
				'remarks' => $this->input->post('remarks'),
				'year'=>$this->input->post('year'),
				'accademic_year_id'=>$this->academic_session[0]->fin_year,
				'created_by' => $this->session->userdata('user_id'),  

			   );

		$q=$this->dbconnection->insert('holiday', $data);
                $holi_id = $this->dbconnection->get_last_id();
                if($q){

                                $audit = array(
                                                "action" => 'Add Holiday',
                                                "module" => "Holiday Module",
                                                'datetime' => date("Y-m-d H:i:s"),
                                                'userid' => $this->session->userdata('user_id'),
                                                'student_id' => 0,
                                                'page' => 'holidays',
                                                'remarks' => 'Addition of Holiday of ID:'.$holi_id,
                                            );
                                $this->dbconnection->insert("auditntrail", $audit);
                        }
	}
	
	public function update($param2) {
            
                if (substr($this->right_access, 2, 1) != 'U') {
        //            redirect(base_url(), 'refresh');
                    redirect('404');
                }
                
		$data = array(
				'holiday_name' => $this->input->post('hname'),                          
				'holiday_date_from' => $this->input->post('hdate_from'),                          
				'holiday_date_to' => $this->input->post('hdate_to'),                          
				'remarks' => $this->input->post('remarks'), 
				'year'=>$this->input->post('year'),
//                                'accademic_year_id'=>$this->academic_session[0]->fin_year,
				'date_modified'=>date('Y-m-d H:i:s'),
				'modified_by' => $this->session->userdata('user_id'),  

			     );

		$this->db->where('id', $param2);
		$q=$this->db->update('holiday', $data);   
                if($q){

                                $audit = array(
                                                "action" => 'Update Holiday',
                                                "module" => "Holiday Module",
                                                'datetime' => date("Y-m-d H:i:s"),
                                                'userid' => $this->session->userdata('user_id'),
                                                'student_id' => 0,
                                                'page' => 'holidays',
                                                'remarks' => 'Updation of Holiday of ID:'.$param2,
                                            );
                                $this->dbconnection->insert("auditntrail", $audit);
                        }

	}

	public function delete() {
            
            if (substr($this->right_access, 3, 1) != 'D') {
    //            redirect(base_url(), 'refresh');
                redirect('404');
            }
		$class_id_string = $this->input->post('class_id_string');
		foreach ($class_id_string as $val) {
			$q=$this->dbconnection->update('holiday',array('status'=>0,'modified_by'=>$this->session->userdata('user_id'),'date_modified'=>date('Y-m-d H:i:s')),'id='.$val);                       
		
                        if($q){

                                $audit = array(
                                                "action" => 'Delete Holiday',
                                                "module" => "Holiday Module",
                                                'datetime' => date("Y-m-d H:i:s"),
                                                'userid' => $this->session->userdata('user_id'),
                                                'student_id' => 0,
                                                'page' => 'holidays',
                                                'remarks' => 'Deletion of Holiday of ID:'.$val,
                                            );
                                $this->dbconnection->insert("auditntrail", $audit);
                        }
                }
	}
}
