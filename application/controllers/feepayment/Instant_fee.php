<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Instant_fee extends MY_ListController {
    
    public function __construct() {
        $this->page_code = 'instant_fee';
        parent::__construct();

        switch($this->session->userdata('login_type')){
                    case 'appadmin':
                                        $this->right_access = 'CRUD';
                                        break;
                    case 'admin':
                                        $this->right_access = 'CRUD';
                                        break;
                    case 'principal':
                                        $this->right_access = '-R--';
                                        break;
                    case 'office':
                                        $this->right_access = 'CR--';
                                        break;
                    default:
                                        $this->right_access = '----';
                                        redirect(base_url(), 'refresh');
                }
        $this->page_title = 'Instant/Misc. Fee';
        $this->rec_type = 'Instant Fee';
        $this->rec_types = 'Instant Fee';
        $this->section = 'feepayment';
        $this->dbtable = 'student_other_fee';
        $this->stdview='feepayment/fee_types';
        $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y' and active='Y'");

        $this->display_columns = array('student_id' => 'Student ID', 'student_id_disp' => 'Admission No.',
            'name_disp' => 'Student Name','fee_id_disp'=> 'Fee Name','amount' =>'Amount','paid_status'=>'Paid Status'
        );
       //http://jsfiddle.net/jEADR/62/
        $this->edit_columns = array(

            'fee_id' => array('disp' => 'Fee Name', 'type' => 'select', 'select_opts' => $this->dbconnection->select('fee_master', 'id AS opt_id, fee_name AS opt_disp', 'status=1 and fee_cat_id="8"'), 'required' => TRUE, 'serverRules' => 'required'),
            'class' => array('disp' => 'Class', 'type' => 'select', 'select_opts' => $this->dbconnection->select('class', 'id AS opt_id, class_name AS opt_disp', 'status="Y"')),
            'section' => array('disp' => 'Section', 'type' => 'select', 'select_opts' => $this->dbconnection->select('section', 'id AS opt_id, sec_name AS opt_disp', 'status="Y"')),
//            
        );
//        $this->extra_add_columns = array('student_academicyear_id' => $this->academic_session[0]->fin_year, 'created_by' => $this->session->userdata('user_id'));
//        $this->extra_edit_columns = array('last_modified_by' => $this->session->userdata('user_id'), 'last_date_modified' => date('Y-m-d H:i:s'));

//        $this->search_columns = array(
//            'alpha_num' => array(
//                'first_name',
//                'last_name',
//                'email_address',
//                'phone',
////					'class_id_disp',
//                'admission_no',
//            ),
//            'numeric' => array(
//                'id',
//                'phone',
//                'transport_amt',
//            ),
//            'custom' => array('id', 'admission_no', 'first_name', 'father_name', 'dob', 'stud_category', 'email_address', 'phone', 'class_id', 'section_id'),
//        );
        $this->rec_key = 'id';
        $this->modal_form = array('status' => FALSE, 'page_name' => 'add_instant_fee');
        $this->data_table = $this->dbtable . ' AS t1';

        $this->data_select = '*';
        $this->data_select_where = '';
        $this->data_delete = 'UPDATE';
        $this->data_delete_update = array('status' => 'N', 'last_date_modified' => date('Y-m-d'), 'last_modified_by' => $this->session->userdata('user_id'));

    }
    
    
    public function index() {

        $this->data['page_name'] = '';
        $this->data['page_title'] = $this->page_title;
        $this->data['section'] = $this->section;
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access; 
        $this->data['stdview']='feepayment/instant_fee';
//        $this->data['session_start_yr'] = $this->session_start_yr;
//        $this->data['session_start_month'] = $this->session_start_month;

        $this->data['instant_fee'] = $this->dbconnection->select('student_other_fee', '*,(select admission_no from student where id=student_id) as admission,(select fee_name from fee_master where id=fee_id) as fee_name', 'status="Y"');

        $this->load->view('index', $this->data);
    }
    
//    public function add() {
//        parent::add();
//    }

     public function load_bulk_alloc() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }

        $optradio = $this->input->post('optradio');
        
        if($optradio=='single') {
            $adm = $this->input->post('admission_no');
            $this->data['fetch_qry'] = $this->dbconnection->select("student", "id,admission_no, concat(first_name,' ',middle_name,' ',last_name) as name", "admission_no='$adm'");
            // $this->data['fetch_qry'] = $this->dbconnection->select("student", "id,admission_no, concat(first_name,' ',middle_name,' ',last_name) as name", "admission_no='$adm' and status='Y'");
        }else{
            
            $class_str='';
            $section_str='';
            foreach ($this->input->post('class') as $key => $value) {
                $class_str.= $value.',';
            }
            $class_str= rtrim($class_str,',');
            foreach ($this->input->post('section') as $key1 => $value1) {
                $section_str.= $value1.',';
            }
            $section_str=rtrim($section_str,',');
            $this->data['fetch_qry'] = $this->dbconnection->select("student", "id,admission_no, concat(first_name,' ',middle_name,' ',last_name) as name", "class_id in ($class_str) and section_id in ($section_str) and status='Y'","admission_no");
            
            
        }

        $this->data['common_amt']= $optradio=='group'?$this->input->post('common_amt'):'';
        $this->load->view("feepayment/load_instant_fee_alloc", $this->data);
     }
     
     
     public function allocate_student() {
         
        if ( substr($this->right_access, 0, 1) != 'C') {
                redirect('404');
        }
//        error_reporting(-1);
//		ini_set('display_errors', 1);
        foreach ($this->input->post('chk_row') as $key => $value) {
            $data = array(
                'student_id'=>$value,
                'year'=>$this->academic_session[0]->fin_year,
                'fee_id'=>$this->input->post('fee_id'),
                'amount'=>$this->input->post('instant_amt')[$value],
                'remarks'=>$this->input->post('remarks'),
                'row_code'=>'',
                'paid_status'=>0,
                'date_created'=>date('Y-m-d H:i:s'),
                'created_by'=>$this->session->userdata('user_id'),
            );
            $this->dbconnection->insert('student_other_fee', $this->security->xss_clean($data));
        }
        $this->session->set_flashdata('instantfee_success_msg','Successfully Allocated');
        header("Location: " . base_url("feepayment/instant_fee/add_form"));
        
     }
     
     
     
     public function deleteinstant() {
         if (substr($this->right_access, 3, 1) != 'D') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $result = array();
        $result = $this->dbconnection->update('student_other_fee', array('status' => 'N', 'modified_by' => $this->session->userdata('user_id'), 'last_date_modified' => date('Y-m-d H:i:s')), array('id' => trim($this->input->post('ida'))));

//Audit Trail
        $audit = array("action" => 'Delete',
            "module" => "Instant Fee Module",
            'datetime' => date("Y-m-d H:i:s"),
            'userid' => $this->session->userdata('user_id'),
            'student_id' => '',
            'page' => 'Instant Fee',
            'remarks' => ''
        );
        $this->dbconnection->insert("auditntrail", $audit);
        echo 1;
     }


}
