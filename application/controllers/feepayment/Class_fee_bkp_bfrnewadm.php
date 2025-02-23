<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Class_fee extends CI_Controller {

    public $page_code = 'class_fee';
    public $page_id = '';
    public $page_perm = '----';
    
    public function __construct() {
        parent::__construct();

//        error_reporting(-1);
//        ini_set('display_errors', 1);
//        $this->db->db_debug=TRUE;
        $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");

// Access Control
//        switch ($this->session->userdata('login_type')) {
////            case 'appadmin':
////                $this->right_access = 'CRUD';
////                break;
//            case 'admin':
//                $this->right_access = 'CRUD';
//                break;
//            case 'principal':
//                $this->right_access = 'CR--';
//                break;
//            default:
//                $this->right_access = '----';
//                redirect(base_url(), 'refresh');
//        }

        $this->id = $this->session->userdata('school_id');
        $this->academic_session = array();
        $this->school_desc = $this->dbconnection->select("school", "*", "id=" . $this->id . " and status = 1");
        $this->schools = $this->dbconnection->select("school", "*", 'status = 1');
        $this->bank = $this->dbconnection->select("bank", "*");

        if ($this->id != 0) {
            $this->db->db_select('crmfeesclub_' . $this->id);
//            $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year", "active='Y'");
        }
        
        $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
        $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
        $this->right_access = $this->page_perm;
        
        if (strpos($this->page_perm, '----') == true) {
            redirect(base_url(''), 'refresh');
        }
        
        $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y' and active='Y'");
        $fetch_startyr=isset($this->academic_session[0]->start_date)? explode('-',$this->academic_session[0]->start_date) : array('0','0');
        $this->session_start_yr= reset($fetch_startyr);
        $this->session_start_month= $fetch_startyr[1];
        
        $this->fee_type1 = $this->school_desc[0]->fee_type1;
        $this->fee_type2 = $this->school_desc[0]->fee_type2;

        $this->page_title = 'Class Fee';
        $this->section = 'feepayment';
        $this->page_name = 'class_fee';
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
        $this->data['right_access'] = $this->right_access;
        $this->data['session_start_yr'] = $this->session_start_yr;
        $this->data['session_start_month'] = $this->session_start_month;

        $this->data['class_fee'] = $this->dbconnection->select('class_fee_head', '*,(select class_name from class where id=class_fee_head.from_class_id) as from_class,(select class_name from class where id=class_fee_head.to_class_id) as to_class,year,(select course_name from course where id=class_fee_head.course) as course_name', 'status="Y"');

        $this->load->view('index', $this->data);
    }

    public function upload_class_fee() {
        
        if (substr($this->right_access, 0, 1) != 'C' ) {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
  
        $class = $this->dbconnection->select('class', '*', 'status="Y"');
        $this->stud_category = $this->dbconnection->select("category", "*", 'status="Y"');

        $data = array(
            'page_name' => 'upload_class_fee',
            'page_title' => $this->page_title,
            'section' => $this->section,
            'customview' => $this->customview,
            'student_cat' => $this->dbconnection->select('category', '*', 'status="Y"'),
            'upload' => 0,
            'task' => 'add',
            'message' => '',
            'stud_cat' => $this->stud_category,
            'id' => '',
            'class' => $class,
            'course' => $this->dbconnection->select('course', '*', 'status="Y"'),
//                            'course_id'=>$qry_class_fee_head[0]->id,
            'fee_type1' => $this->fee_type1,
            'fee_type2' => $this->fee_type2,
            'onetime' => $this->school_desc[0]->onetime,
            'annual_fee' => $this->dbconnection->select('fee_master', '*', 'status=1 and fee_cat_id=1'),
            'monthly_fee' => $this->dbconnection->select('fee_master', '*', 'status=1 and fee_cat_id=2'),
            'other_fee' => $this->dbconnection->select('fee_master', '*', 'status=1 and fee_cat_id=3'),
            'quarterly_fee' => $this->dbconnection->select('fee_master', '*', 'status=1 and fee_cat_id=5'),
            'onetime_fee' => $this->dbconnection->select('fee_master', '*', 'status=1 and fee_cat_id in (9,10)'),
            'half_yearly_fee' => $this->dbconnection->select('fee_master', '*', 'status=1 and fee_cat_id=4'),
            'fine_rule' => $this->dbconnection->select('fine_rule', '*', ''),
            'readmsnfine_fee' =>array(),
        );

        $this->load->view('index', $data);
    }

    public function save_class_fee($data2 = array('task' => 'save')) {
        /* -------------saving class fee head----------------- */

        if ($this->input->post('to_class_id') == 'Select Class') {
            $toclass_id = $this->input->post('from_class_id');
        } else {
            $toclass_id = $this->input->post('to_class_id');
        }
        $data = array('year' => $this->input->post('year'),
            'from_class_id' => $this->input->post('from_class_id'),
            'to_class_id' => $toclass_id,
            'course' => $this->input->post('student_course'),
            'created_date' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('user_id'),
        );
        if ($data2['task'] == 'save') {
            if (substr($this->right_access, 0, 1) != 'C') {
    //            redirect(base_url(), 'refresh');
                redirect('404');
            }
            $this->dbconnection->insert('class_fee_head', $data);
            $head_id = $this->dbconnection->get_last_id();
        } else {
            if (substr($this->right_access, 2, 1) != 'U') {
    //            redirect(base_url(), 'refresh');
                redirect('404');
            }
            $head_id = $data2['id'];
        }

        /* --------------------------------------------------------- */
        $stud_cat = $this->dbconnection->select("category", "*", "status='Y'");
        /* -------------------saving class fee det----------------- */
        $inputall = $this->input->post();

//------------------  Annual ---------------------------//

        if (!empty($inputall['chkfee1'])) {
            foreach ($inputall['chkfee1'] as $selected) {
                foreach ($stud_cat as $obj_stud_cat) {
                    $data = array(
                        'class_fee_head_id' => $head_id,
                        'fee_amount' => $inputall['annual_fee_amount'][$selected][$obj_stud_cat->id],
                        'fee_id' => $inputall['annual_fee_id'][$selected],
                        'fee_cat' => 1,
                        'stud_cat' => $obj_stud_cat->id
                    );
                    $this->dbconnection->insert('class_fee_det', $data);
                }
            }
        }
 
//    
        if (!empty($inputall['chkfee2'])) {
            foreach ($inputall['chkfee2'] as $selected1) {

                foreach ($stud_cat as $obj_stud_cat) {
                    $data = array(
                        'class_fee_head_id' => $head_id,
                        'fee_amount' => $inputall['monthly_fee_amount'][$selected1][$obj_stud_cat->id],
                        'fee_id' => $inputall['monthly_fee_id'][$selected1],
                        'fee_cat' => 2,
                        'stud_cat' => $obj_stud_cat->id
                    );
                    $this->dbconnection->insert('class_fee_det', $data);
                }
            }
        }
        
        if (!empty($inputall['chkfee3'])) {
            foreach ($inputall['chkfee3'] as $selected1) {
                foreach ($stud_cat as $obj_stud_cat) {
                    $data = array(
                        'class_fee_head_id' => $head_id,
                        'fee_amount' => $inputall['half_yearly_fee_amount'][$selected1][$obj_stud_cat->id],
                        'fee_id' => $inputall['half_yearly_fee_id'][$selected1],
                        'fee_cat' => 4,
                        'stud_cat' => $obj_stud_cat->id
                    );
                    $this->dbconnection->insert('class_fee_det', $data);
//                                        echo $inputall['half_yearly_fee_amount'][$selected1][$obj_stud_cat->id];
                }
            }
        }
        
        
        //------------------  Onetime ---------------------------//

        if (!empty($inputall['chkfee9'])) {
            foreach ($inputall['chkfee9'] as $selected) {
                foreach ($stud_cat as $obj_stud_cat) {
                    $data = array(
                        'class_fee_head_id' => $head_id,
                        'fee_amount' => $inputall['onetime_fee_amount'][$selected][$obj_stud_cat->id],
                        'fee_id' => $selected,
                        'fee_cat' => $inputall['onetime_fee_id'][$selected],
                        'stud_cat' => $obj_stud_cat->id
                    );
                    $this->dbconnection->insert('class_fee_det', $data);
                }
            }
        }
        
        
        //------------------  Quarterly ---------------------------//
        if (!empty($inputall['chkfee5'])) {
            foreach ($inputall['chkfee5'] as $selected) {
                foreach ($stud_cat as $obj_stud_cat) {
                    $data = array(
                        'class_fee_head_id' => $head_id,
                        'fee_amount' => $inputall['quarterly_fee_amount'][$selected][$obj_stud_cat->id],
                        'fee_id' => $inputall['quarterly_fee_id'][$selected],
                        'fee_cat' => 5,
                        'stud_cat' => $obj_stud_cat->id
                    );
                    $this->dbconnection->insert('class_fee_det', $data);
                }
            }
        }
//        ------------------ Other ---------------------//
        for ($i = 0; $i < count($inputall['other_fee_id']); $i++) {
            $data = array(
                'class_fee_head_id' => $head_id,
                'fee_amount' => $inputall['other_fee_amount'][$i],
                'fee_id' => $inputall['other_fee_id'][$i],
                'fee_cat' => 3,
            );

            $this->dbconnection->insert('class_fee_det', $data);
        }

//--------------------  Fine -------------------------//
        
        if($this->school_desc[0]->school_group=='ARMY'){
             for ($i = 0; $i < count($inputall['from_day']); $i++) {
            $data = array(
                'class_fee_head_id' => $head_id,
                'fine_condition' => $inputall['fine_condn_to'][$i],
                'fee_amount' => $inputall['fine_amount'][$i],
                'no_of_months' => $inputall['no_of_months'][$i],
                'fine_rule_id' => $inputall['fine_rule_id'][$i],
                'fee_cat' => 0,
            );
            $this->dbconnection->insert('class_fee_det', $data);
        }
        }
        else{
             for ($i = 0; $i < count($inputall['no_of_months']); $i++) {
            $data = array(
                'class_fee_head_id' => $head_id,
                'fine_condition' => $inputall['fine_condn'][$i],
                'fee_amount' => $inputall['fine_amount'][$i],
                'no_of_months' => $inputall['no_of_months'][$i],
                'fee_cat' => 0,
            );
            $this->dbconnection->insert('class_fee_det', $data);
            }
        }
       
//       
        /* ---------------------------------------------------- */
        
        /*----------------Re-Admission Fine --------------------*/
        
        
            $data = array(
                'class_fee_head_id' => $head_id,
                'fee_amount' => $inputall['re_admission_fine_amount'],
                'no_of_months' => $inputall['re_admission_fine_month'],
                'fee_cat' => 11,
            );
            $this->dbconnection->insert('class_fee_det', $data);
        
    }

    public function delete_class_fee() {
        
        if (substr($this->right_access, 3, 1) != 'D') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $school_id = $this->session->userdata('school_id');
        $fee_id_array = explode("|", $this->input->post('fee_id'));
        foreach ($fee_id_array as $obj_fee_id) {

            $this->dbconnection->update('class_fee_head', array('status' => 'N', 'modified_by' => $this->session->userdata('user_id'), 'modified_date' => date('Y-m-d H:i:s')), 'id=' . $obj_fee_id);
        }

        $audit = array("action" => 'Delete',
//                    "module" => "Class Module",
            'datetime' => date("Y-m-d H:i:s"),
            'userid' => $this->session->userdata('user_id'),
//                    'school_id' => $school_id,
            'student_id' => '',
            'page' => 'School',
            'remarks' => ''
        );
        $this->dbconnection->insert("auditntrail", $audit);
        echo 1;
    }

    public function editClassFee($id) {

        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
//               error_reporting(E_ALL);
//        $id = $this->input->post('id');
//        $year = $this->input->post('year');
//        $from_class = $this->input->post('from');
//        $to_class = $this->input->post('to');
//        $category = $this->input->post('cat');
//        $school = $this->school;
////               $school=$this->dbconnection->select('school','fee_type1,fee_type2','status=1 and id='.$this->session->userdata('school_id'));
//               $qry_annual_fee=$this->dbconnection->select("fee_master","id,fee_name","fee_cat_id=1 and status=1");  
//               $half_yearly_fee=$this->dbconnection->select("fee_master","id,fee_name","fee_cat_id=4 and status=1");  
//              
//               $qry_monthly_fee=$this->dbconnection->select("fee_master","id,fee_name","fee_cat_id=2 and status=1");     
//               $qry_other_fee=$this->dbconnection->select("fee_master","id,fee_name","fee_cat_id=3 and status=1");     
//               $qry_student_cat=$this->dbconnection->select('category','*','status="Y"');
        $qry_fine_fee = $this->dbconnection->select('class_fee_det', '*', 'class_fee_head_id=' . $id . ' and fee_cat=0 and status=1');
//        $qry_fine_fee = $this->db->query("select cfd.id,cfd.fee_amount,cfd.fine_condition,cfd.no_of_months,fr.from_day,fr.to_day from class_fee_det cfd,fine_rule fr where cfd.class_fee_head_id=' . $id . ' and cfd.fee_cat=0 and cfd.status=1'")->result();
        $qry_readmsnfine_fee = $this->dbconnection->select('class_fee_det', '*', 'class_fee_head_id=' . $id . ' and fee_cat=11 and status=1');

        $qry_class_fee_ann_det_chk = $this->dbconnection->select('class_fee_det', 'distinct(fee_id) as fee_id', 'class_fee_head_id=' . $id . ' and fee_cat=1 and status=1');
        $qry_class_fee_ann_det_amt = $this->dbconnection->select('class_fee_det', '*', 'class_fee_head_id=' . $id . ' and fee_cat=1 and status=1');
//               
        $qry_class_fee_mon_det_chk = $this->dbconnection->select('class_fee_det', 'distinct(fee_id) as fee_id', 'class_fee_head_id=' . $id . ' and fee_cat=2 and status=1');
        $qry_class_fee_mon_det_amt = $this->dbconnection->select('class_fee_det', '*', 'class_fee_head_id=' . $id . ' and fee_cat=2 and status=1');
//               
//               
        $qry_class_fee_other_det = $this->dbconnection->select('class_fee_det', 'fee_id,fee_amount', 'class_fee_head_id=' . $id . ' and fee_cat=3 and status=1');
        $qry_class_fee_sem_det_chk = $this->dbconnection->select('class_fee_det', 'distinct(fee_id) as fee_id', 'class_fee_head_id=' . $id . ' and fee_cat=4 and status=1');
        $qry_class_fee_sem_det_amt = $this->dbconnection->select('class_fee_det', '*', 'class_fee_head_id=' . $id . ' and fee_cat=4 and status=1');
        
        
        //----------------------------Onetime-----------------------------//
        $qry_class_fee_one_det_chk = $this->dbconnection->select('class_fee_det', 'distinct(fee_id) as fee_id', 'class_fee_head_id=' . $id . ' and fee_cat in (9,10)  and status=1');
        $qry_class_fee_one_det_amt = $this->dbconnection->select('class_fee_det', '*', 'class_fee_head_id=' . $id . ' and fee_cat in (9,10) and status=1');
        
        
        //--------------------------Quarterly--------------------------------//
        $qry_class_fee_qtr_det_chk = $this->dbconnection->select('class_fee_det', 'distinct(fee_id) as fee_id', 'class_fee_head_id=' . $id . ' and fee_cat=5 and status=1');
        $qry_class_fee_qtr_det_amt = $this->dbconnection->select('class_fee_det', '*', 'class_fee_head_id=' . $id . ' and fee_cat=5 and status=1');

        $qry_class_fee_head = $this->dbconnection->select('class_fee_head', '*', 'id=' . $id . ' and status="Y"');

        $class = $this->dbconnection->select('class', '*', 'status="Y"');
        $this->stud_category = $this->dbconnection->select("category", "*", 'status="Y"');
        
        
        $data = array(
            'page_name' => 'upload_class_fee',
            'page_title' => $this->page_title,
            'section' => $this->section,
            'customview' => $this->customview,
            'task' => 'edit',
            'student_cat' => $this->dbconnection->select('category', '*', 'status="Y"'),
            'upload' => 0,
            'message' => '',
            'id' => $id,
            'year' => $qry_class_fee_head[0]->year,
            'from' => $qry_class_fee_head[0]->from_class_id,
            'to' => $qry_class_fee_head[0]->to_class_id,
            'stud_cat' => $this->stud_category,
            'onetime' => $this->school_desc[0]->onetime,
            'qry_class_fee_ann_det_chk' => $qry_class_fee_ann_det_chk,
            'qry_class_fee_ann_det_amt' => $qry_class_fee_ann_det_amt,
            'qry_class_fee_sem_det_chk' => $qry_class_fee_sem_det_chk,
            'qry_class_fee_sem_det_amt' => $qry_class_fee_sem_det_amt,
            'qry_class_fee_mon_det_chk' => $qry_class_fee_mon_det_chk,
            'qry_class_fee_mon_det_amt' => $qry_class_fee_mon_det_amt,
            'qry_class_fee_one_det_chk' => $qry_class_fee_one_det_chk,
            'qry_class_fee_one_det_amt' => $qry_class_fee_one_det_amt,
            'qry_class_fee_qtr_det_chk' => $qry_class_fee_qtr_det_chk,
            'qry_class_fee_qtr_det_amt' => $qry_class_fee_qtr_det_amt,
            'qry_class_fee_other_det' => $qry_class_fee_other_det,
            'class' => $class,
            'fine_fee' => $qry_fine_fee,
            'readmsnfine_fee' => $qry_readmsnfine_fee,
            'course_id' => $qry_class_fee_head[0]->course,
            'course' => $this->dbconnection->select('course', '*', 'status="Y"'),
            'fee_type1' => $this->fee_type1,
            'fee_type2' => $this->fee_type2,
            'annual_fee' => $this->dbconnection->select('fee_master', '*', 'status=1 and fee_cat_id=1'),
            'monthly_fee' => $this->dbconnection->select('fee_master', '*', 'status=1 and fee_cat_id=2'),
            'other_fee' => $this->dbconnection->select('fee_master', '*', 'status=1 and fee_cat_id=3'),
            'half_yearly_fee' => $this->dbconnection->select('fee_master', '*', 'status=1 and fee_cat_id=4'),
            'quarterly_fee' => $this->dbconnection->select('fee_master', '*', 'status=1 and fee_cat_id=5'),
            'onetime_fee' => $this->dbconnection->select('fee_master', '*', 'status=1 and fee_cat_id in (9,10)'),
            'fine_rule' => $this->dbconnection->select_join('fine_rule fr', 'fr.*,cd.fee_amount',"","class_fee_det cd","fr.id=cd.fine_rule_id and cd.class_fee_head_id=$id and cd.status=1 and cd.fee_cat=0 and cd.stud_cat=0","left"),
            'session_start_yr' => $this->session_start_yr,
            'session_start_month' => $this->session_start_month
        );

        $this->load->view('index', $data);
    }

    public function update_class_fee($id) {
//        error_reporting(E_ALL);
        
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $inputall = $this->input->post();
        if ($this->input->post('to_class_id') == 'Select Class') {
            $toclass_id = $this->input->post('from_class_id');
        } else {
            $toclass_id = $this->input->post('to_class_id');
        }

        /* ---------------------------updating head---------------------------- */
        $data = array('year' => $this->input->post('year'),
            'from_class_id' => $this->input->post('from_class_id'),
            'to_class_id' => $toclass_id,
            'created_date' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('user_id'),
            'course' => $this->input->post('student_course'),
        );
        $this->dbconnection->update('class_fee_head', $data, 'id=' . $id . ' and course=' . $this->input->post('student_course'));
        $this->dbconnection->update('class_fee_det', array('status' => 0), 'class_fee_head_id=' . $id);
        $data2 = array('task' => 'update',
            'id' => $id);
        $this->save_class_fee($data2);
    }

}
