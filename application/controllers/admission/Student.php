<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends MY_ListController {

    public function __construct() {
        $this->page_code = 'student';
        parent::__construct();

        if (empty($this->session->userdata('user_id')) || $this->session->userdata('user_group_id') == 4) {
            redirect('/login');
        }
        $this->id = $this->session->userdata('school_id');
//        error_reporting(-1);
//        ini_set('display_errors', TRUE);
//        $this->db->db_debug=TRUE;
//        switch ($this->session->userdata('login_type')) {
//            case 'appadmin':
//                $this->right_access = 'CRUD';
//                break;
//            case 'admin':
//                $this->right_access = 'CRUD';
//                break;
//            case 'principal':
//                $this->right_access = 'CRUD';
//                break;
//            case 'school':
//                $this->right_access = 'CRUD';
//                break;
//            case 'office':
//                $this->right_access = 'CRUD';
//                break;
//            default:
//                $this->right_access = '----';
//                redirect(base_url(), 'refresh');
//        }

        $this->page_title = 'Students';
        $this->rec_type = 'Student';
        $this->rec_types = 'Students';
        $this->section = 'admission';
        $this->dbtable = 'student';
        $this->stdview = 'admission/student_list';
        $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y' and active='Y'");

        $this->display_columns = array('id' => 'Student ID', 'admission_no' => 'Admission No.',
            'name_disp' => 'Student Name', 'father_name' => 'Father&apos;s Name',
            'dob' => 'DOB', 'stud_category_disp' => 'Category', 'email_address' => 'Email',
            'phone' => 'Phone No.', 'class_id_disp' => 'Class Name', 'section_id_disp' => 'Section Name', 'acedemic_id_disp' => 'Acedemic Session'
        );
        if ($this->school[0]->transport_fee == 'YES') {
            $this->display_columns['transport_amt'] = 'Transport Fee';
        }
        $this->edit_columns = array(
            'student_academicyear_id' => array('disp' => 'Academic Session', 'type' => 'select', 'select_opts' => $this->dbconnection->select('accedemic_session', 'id AS opt_id, session AS opt_disp', 'status="Y"'), 'required' => TRUE),
            'admission_no' => array('disp' => 'Admission No.', 'type' => 'text', 'required' => TRUE, 'duplication_check' => TRUE, 'serverRules' => 'trim|required'),
            'admission_date' => array('disp' => 'Admission Date.', 'type' => 'text', 'required' => TRUE),
            'roll' => array('disp' => 'Roll No.', 'type' => 'number', 'required' => TRUE, 'serverRules' => 'trim'),
            'first_name' => array('disp' => 'First Name', 'type' => 'text', 'required' => TRUE, 'serverRules' => 'trim|required'),
            'middle_name' => array('disp' => 'Middle Name', 'type' => 'text', 'serverRules' => 'trim'),
            'last_name' => array('disp' => 'Last Name', 'type' => 'text', 'serverRules' => 'trim'),
            'class_id' => array('disp' => 'Class Name', 'type' => 'select', 'select_opts' => $this->dbconnection->select('class', 'id AS opt_id, class_name AS opt_disp', 'status="Y"'), 'required' => TRUE, 'serverRules' => 'required'),
            'first_class' => array('disp' => 'First Class', 'type' => 'select', 'select_opts' => $this->dbconnection->select('class', 'id AS opt_id, class_name AS opt_disp', 'status="Y"')),
            'section_id' => array('disp' => 'Section Name', 'type' => 'select', 'select_opts' => $this->dbconnection->select('section', 'id AS opt_id, sec_name AS opt_disp', 'status="Y"')),
            'course_id' => array('disp' => 'Course', 'type' => 'select', 'select_opts' => $this->dbconnection->select('course', 'id AS opt_id, course_name AS opt_disp', 'status="Y"')),
            'dob' => array('disp' => 'D.O.B.', 'type' => 'date', 'required' => TRUE),
            'gender' => array('disp' => 'Gender', 'type' => 'date', 'required' => TRUE),
            'mother_tongue' => array('disp' => 'Mother Tongue', 'type' => 'date', 'required' => TRUE),
            'student_aadhar' => array('disp' => 'Aadhar', 'type' => 'number', 'required' => TRUE),
            'birth_place' => array('disp' => 'Birth Place', 'type' => 'text', 'required' => TRUE),
            'nationality' => array('disp' => 'Nationality', 'type' => 'text', 'required' => TRUE),
            'religion' => array('disp' => 'Religion', 'type' => 'text', 'required' => TRUE),
            'caste' => array('disp' => 'Caste', 'type' => 'text', 'required' => TRUE),
            'transport_amt' => array('disp' => 'Transport Fee', 'type' => 'text', 'required' => TRUE),
            'fine_waiver' => array('disp' => 'Fine Waiver', 'type' => 'select', 'select_opts' => array((object) array('opt_id' => 'NO', 'opt_disp' => 'NO'), (object) array('opt_id' => 'YES', 'opt_disp' => 'YES')), 'required' => TRUE),
            'father_name' => array('disp' => 'Father&apos;s Name', 'type' => 'text', 'required' => TRUE),
            'father_phone' => array('disp' => 'Father&apos;s Phone', 'type' => 'text', 'required' => TRUE),
            'father_aadhar' => array('disp' => 'Father&apos;s Aadhar', 'type' => 'text', 'required' => TRUE),
            'mother_name' => array('disp' => 'Mother&apos;s Name', 'type' => 'text', 'required' => TRUE),
            'mother_phone' => array('disp' => 'Mother&apos;s Phone', 'type' => 'text', 'required' => TRUE),
            'mother_aadhar' => array('disp' => 'Mother&apos;s Aadhar', 'type' => 'text', 'required' => TRUE),
            'guardian_name' => array('disp' => 'Guardian&apos;s Name', 'type' => 'text', 'required' => TRUE),
            'guardian_phone' => array('disp' => 'Guardian&apos;s Phone', 'type' => 'text', 'required' => TRUE),
            'guardian_aadhar' => array('disp' => 'Guardian&apos;s Aadhar', 'type' => 'text', 'required' => TRUE),
            'blood_group' => array('disp' => 'Blood Group', 'type' => 'text', 'required' => TRUE),
            'height' => array('disp' => 'Height', 'type' => 'text', 'required' => TRUE),
            'weight' => array('disp' => 'Weight', 'type' => 'text', 'required' => TRUE),
            'vision' => array('disp' => 'Vision', 'type' => 'text', 'required' => TRUE),
            'address' => array('disp' => 'Present Address', 'type' => 'text', 'required' => TRUE),
            'permanent_address' => array('disp' => 'Permanent Address', 'type' => 'text', 'required' => TRUE),
//            'email_address' => array('disp' => 'Email Address', 'type' => 'email', 'required' => TRUE, 'serverRules' => 'trim|required|valid_email'),
            'email_address' => array('disp' => 'Email Address', 'type' => 'email', 'required' => TRUE),
            'phone' => array('disp' => 'Contact Number', 'type' => 'tel', 'required' => TRUE, 'serverRules' => 'trim|required|numeric'),
            'stud_category' => array('disp' => 'Fee Category', 'type' => 'select', 'select_opts' => $this->dbconnection->select('category', 'id AS opt_id, cat_name AS opt_disp', 'status="Y"'), 'required' => TRUE, 'serverRules' => 'required'),
            'ppoint_id' => array('disp' => 'Pickup Point', 'type' => 'select', 'select_opts' => $this->dbconnection->select('locations', 'id AS opt_id, location_description AS opt_disp', '')),
            'transport_id' => array('disp' => 'Vehical No', 'type' => 'select', 'select_opts' => $this->dbconnection->select('vehicle', 'id AS opt_id, vehicle_no AS opt_disp', '')),
        );
		if($this->session->userdata('school_id')==43){
			$this->edit_columns = array(
            'student_academicyear_id' => array('disp' => 'Academic Session', 'type' => 'select', 'select_opts' => $this->dbconnection->select('accedemic_session', 'id AS opt_id, session AS opt_disp', 'status="Y" and active!="N"'), 'required' => TRUE),
            'admission_no' => array('disp' => 'Admission No.', 'type' => 'text', 'required' => TRUE, 'duplication_check' => TRUE, 'serverRules' => 'trim|required'),
            'admission_date' => array('disp' => 'Admission Date.', 'type' => 'text', 'required' => TRUE),
            'roll' => array('disp' => 'Roll No.', 'type' => 'number', 'required' => TRUE, 'serverRules' => 'trim'),
            'first_name' => array('disp' => 'First Name', 'type' => 'text', 'required' => TRUE, 'serverRules' => 'trim|required'),
            'middle_name' => array('disp' => 'Middle Name', 'type' => 'text', 'serverRules' => 'trim'),
            'last_name' => array('disp' => 'Last Name', 'type' => 'text', 'serverRules' => 'trim'),
            'hostel' => array('disp' => 'Hostel Name', 'type' => 'text', 'required' => TRUE, 'serverRules' => 'trim|required'),
            'class_id' => array('disp' => 'Class Name', 'type' => 'select', 'select_opts' => $this->dbconnection->select('class', 'id AS opt_id, class_name AS opt_disp', 'status="Y"'), 'required' => TRUE, 'serverRules' => 'required'),
            'first_class' => array('disp' => 'First Class', 'type' => 'select', 'select_opts' => $this->dbconnection->select('class', 'id AS opt_id, class_name AS opt_disp', 'status="Y"')),
            'section_id' => array('disp' => 'Section Name', 'type' => 'select', 'select_opts' => $this->dbconnection->select('section', 'id AS opt_id, sec_name AS opt_disp', 'status="Y"')),
            'course_id' => array('disp' => 'Course', 'type' => 'select', 'select_opts' => $this->dbconnection->select('course', 'id AS opt_id, course_name AS opt_disp', 'status="Y"')),
            'dob' => array('disp' => 'D.O.B.', 'type' => 'date', 'required' => TRUE),
            'gender' => array('disp' => 'Gender', 'type' => 'date', 'required' => TRUE),
            'mother_tongue' => array('disp' => 'Mother Tongue', 'type' => 'date', 'required' => TRUE),
            'student_aadhar' => array('disp' => 'Aadhar', 'type' => 'number', 'required' => TRUE),
            'birth_place' => array('disp' => 'Birth Place', 'type' => 'text', 'required' => TRUE),
            'nationality' => array('disp' => 'Nationality', 'type' => 'text', 'required' => TRUE),
            'religion' => array('disp' => 'Religion', 'type' => 'text', 'required' => TRUE),
            'caste' => array('disp' => 'Caste', 'type' => 'text', 'required' => TRUE),
            'transport_amt' => array('disp' => 'Transport Fee', 'type' => 'text', 'required' => TRUE),
            'fine_waiver' => array('disp' => 'Fine Waiver', 'type' => 'select', 'select_opts' => array((object) array('opt_id' => 'NO', 'opt_disp' => 'NO'), (object) array('opt_id' => 'YES', 'opt_disp' => 'YES')), 'required' => TRUE),
            'father_name' => array('disp' => 'Father&apos;s Name', 'type' => 'text', 'required' => TRUE),
            'father_phone' => array('disp' => 'Father&apos;s Phone', 'type' => 'text', 'required' => TRUE),
            'father_aadhar' => array('disp' => 'Father&apos;s Aadhar', 'type' => 'text', 'required' => TRUE),
            'mother_name' => array('disp' => 'Mother&apos;s Name', 'type' => 'text', 'required' => TRUE),
            'mother_phone' => array('disp' => 'Mother&apos;s Phone', 'type' => 'text', 'required' => TRUE),
            'mother_aadhar' => array('disp' => 'Mother&apos;s Aadhar', 'type' => 'text', 'required' => TRUE),
            'guardian_name' => array('disp' => 'Guardian&apos;s Name', 'type' => 'text', 'required' => TRUE),
            'guardian_phone' => array('disp' => 'Guardian&apos;s Phone', 'type' => 'text', 'required' => TRUE),
            'guardian_aadhar' => array('disp' => 'Guardian&apos;s Aadhar', 'type' => 'text', 'required' => TRUE),
            'blood_group' => array('disp' => 'Blood Group', 'type' => 'text', 'required' => TRUE),
            'height' => array('disp' => 'Height', 'type' => 'text', 'required' => TRUE),
            'weight' => array('disp' => 'Weight', 'type' => 'text', 'required' => TRUE),
            'vision' => array('disp' => 'Vision', 'type' => 'text', 'required' => TRUE),
            'address' => array('disp' => 'Present Address', 'type' => 'text', 'required' => TRUE),
            'permanent_address' => array('disp' => 'Permanent Address', 'type' => 'text', 'required' => TRUE),
//            'email_address' => array('disp' => 'Email Address', 'type' => 'email', 'required' => TRUE, 'serverRules' => 'trim|required|valid_email'),
            'email_address' => array('disp' => 'Email Address', 'type' => 'email', 'required' => TRUE),
            'phone' => array('disp' => 'Contact Number', 'type' => 'tel', 'required' => TRUE, 'serverRules' => 'trim|required|numeric'),
            'stud_category' => array('disp' => 'Fee Category', 'type' => 'select', 'select_opts' => $this->dbconnection->select('category', 'id AS opt_id, cat_name AS opt_disp', 'status="Y"'), 'required' => TRUE, 'serverRules' => 'required'),
            'ppoint_id' => array('disp' => 'Pickup Point', 'type' => 'select', 'select_opts' => $this->dbconnection->select('locations', 'id AS opt_id, location_description AS opt_disp', '')),
            'transport_id' => array('disp' => 'Vehical No', 'type' => 'select', 'select_opts' => $this->dbconnection->select('vehicle', 'id AS opt_id, vehicle_no AS opt_disp', '')),
            'id' => array('disp' => 'Student Id', 'type' => 'text', 'required' => TRUE, 'serverRules' => 'required'),
            'sets' => array('disp' => 'Sets', 'type' => 'text'),
            'net_roll' => array('disp' => 'Net Roll No', 'type' => 'text'),
            'headmaster' => array('disp' => 'Head Master', 'type' => 'text'),
            'color_house' => array('disp' => 'Color House', 'type' => 'text'),
            'auditorium_seat' => array('disp' => 'Auditorium Sitting Plan', 'type' => 'text'),
            'coaching' => array('disp' => 'Akash/ETC', 'type' => 'text'),
            'bottle' => array('disp' => 'Bottle', 'type' => 'text'),
            'parv' => array('disp' => 'Parv', 'type' => 'text'),
            'medium' => array('disp' => 'Medium', 'type' => 'text'),
            'exam_roll' => array('disp' => 'Exam Roll', 'type' => 'text'),
            'n_roll' => array('disp' => 'N roll No', 'type' => 'text'),
            'pl_house' => array('disp' => 'Pl House', 'type' => 'text'),
            'plan_house' => array('disp' => 'Plan House', 'type' => 'text'),
            'final_house' => array('disp' => 'Final House', 'type' => 'text'),
            'religion' => array('disp' => 'Religion', 'type' => 'text'),
            'category' => array('disp' => 'Category', 'type' => 'text'),
            'blood_group' => array('disp' => 'Blood Group', 'type' => 'text'),
            'reference_no' => array('disp' => 'Reg No', 'type' => 'text'),
            'co_curricular' => array('disp' => 'Co Curricular', 'type' => 'text'),
            'category' => array('disp' => 'Category', 'type' => 'text')

                    );
		}
        if ($this->school[0]->admsn_in_between == 'YES') {
            $this->edit_columns['student_type'] = array('disp' => 'student_type', 'type' => 'text', 'required' => TRUE);
            $this->edit_columns['start_fee_month'] = array('disp' => 'start_fee_month', 'type' => 'text', 'required' => TRUE);
        }
        $this->extra_add_columns = array('created_by' => $this->session->userdata('user_id'));
        // $this->extra_add_columns = array('student_academicyear_id' => $this->academic_session[0]->fin_year, 'created_by' => $this->session->userdata('user_id'));
        $this->extra_edit_columns = array('last_modified_by' => $this->session->userdata('user_id'), 'last_date_modified' => date('Y-m-d H:i:s'));
//                $this->custom_search_columns=array('id','admission_no','first_name','father_name','dob','stud_category','email_address');
        $this->search_columns = array(
            'alpha_num' => array(
                'first_name',
                'last_name',
                'email_address',
                'phone',
//					'class_id_disp',
                'admission_no',
            ),
            'numeric' => array(
                'id',
                'phone',
                'transport_amt',
            ),
            'custom' => array('id', 'admission_no', 'first_name', 'father_name', 'dob', 'stud_category', 'email_address', 'phone', 'class_id', 'section_id'),
        );
        $this->rec_key = 'id';
        $this->modal_form = array('status' => FALSE, 'page_name' => 'add_student');
        $this->data_table = $this->dbtable . ' AS t1';

        
        if($this->session->userdata('school_id')==43){
           $this->data_select = 'id,student_type, admission_no,admission_date,roll, first_name, middle_name, last_name, CONCAT(first_name, " ", middle_name, " ", last_name) AS name_disp, father_name, ' .
               'dob,gender, stud_category, (SELECT cat_name FROM category WHERE id=t1.stud_category) AS stud_category_disp,(select session from accedemic_session where id=t1.student_academicyear_id) AS acedemic_id_disp, email_address, phone,student_academicyear_id, ' .
               'class_id, (SELECT class_name FROM class WHERE id=t1.class_id) AS class_id_disp, ' .
                'section_id, (SELECT sec_name FROM section WHERE id=t1.section_id) AS section_id_disp, course_id,mother_tongue,student_aadhar, ' .
                'birth_place,nationality,religion,caste,father_phone,father_aadhar,mother_name,mother_phone,mother_aadhar,guardian_name,guardian_phone,'
              . 'guardian_aadhar,blood_group,height,weight,vision,address,permanent_address,student_academicyear_id as sessid,transport_amt,fine_waiver,photo,family_photo,ppoint_id,transport_id,start_fee_month,first_class,hostel,sets,net_roll,headmaster,color_house,auditorium_seat,coaching,bottle,parv,medium,exam_roll,n_roll,pl_house,plan_house,final_house,religion,blood_group,reference_no,co_curricular,category';
        }
        else{
$this->data_select = 'id,student_type, admission_no,admission_date,roll, first_name, middle_name, last_name, CONCAT(first_name, " ", middle_name, " ", last_name) AS name_disp, father_name, ' .
                'dob,gender, stud_category, (SELECT cat_name FROM category WHERE id=t1.stud_category) AS stud_category_disp,(select session from accedemic_session where id=t1.student_academicyear_id) AS acedemic_id_disp, email_address, phone,student_academicyear_id, ' .
                'class_id, (SELECT class_name FROM class WHERE id=t1.class_id) AS class_id_disp, ' .
                'section_id, (SELECT sec_name FROM section WHERE id=t1.section_id) AS section_id_disp, course_id,mother_tongue,student_aadhar, ' .
                'birth_place,nationality,religion,caste,father_phone,father_aadhar,mother_name,mother_phone,mother_aadhar,guardian_name,guardian_phone,'
                . 'guardian_aadhar,blood_group,height,weight,vision,address,permanent_address,student_academicyear_id as sessid,transport_amt,fine_waiver,photo,family_photo,ppoint_id,transport_id,start_fee_month,first_class';
            
        }
        $this->data_select_where = 'status="Y"';
        $this->data_delete = 'UPDATE';
        $this->data_delete_update = array('status' => 'N', 'last_date_modified' => date('Y-m-d'), 'last_modified_by' => $this->session->userdata('user_id'));


        $this->dualpermission = $this->dbconnection->select("dual_permission", "authorise_person3,permission", "link_code=$this->page_id");
//        $dualpermission = $this->dbconnection->select("dual_permission", "authorise_person3,permission", "link_code=$this->page_id and authorise_person3={$this->session->userdata('user_id')}");
        $this->page_perm = !empty($this->dualpermission) ? $this->dualpermission[0]->permission : '----';
        $this->person = !empty($this->dualpermission) ? $this->dualpermission[0]->authorise_person3 : '';
        $this->dual_right_access = $this->page_perm;
//        print_r($this->dualpermission);
//        die();
    }

    public function index() {

        $this->data['class'] = $this->dbconnection->select("class", "id,class_name", "status='Y'");
        $this->data['sectionj'] = $this->dbconnection->select("section", "id,sec_name", "status='Y'");
        $this->data['asession'] = $this->dbconnection->select('accedemic_session', '*', 'status="Y"','id','desc','','');
        parent::index();
    }

    public function add() {

        if (!$this->input->is_ajax_request() || substr($this->right_access, 0, 1) != 'C') {
//			redirect('404');
            show_404();
        }

        if (isset($_FILES['photo']) && !empty($_FILES['photo']['name'])) {
            $this->edit_columns['photo'] = array('disp' => 'Photo', 'type' => 'file', 'serverRules' => 'callback_file_check');
          
        } else {
            $this->edit_columns['photo'] = array('disp' => 'Photo', 'type' => 'file');
          
        }

        if (isset($_FILES['family_photo']) && !empty($_FILES['family_photo']['name'])) {
            $this->edit_columns['family_photo'] = array('disp' => 'FPhoto', 'type' => 'file', 'serverRules' => 'callback_file_check_family');
          
        } else {
            $this->edit_columns['family_photo'] = array('disp' => 'FPhoto', 'type' => 'file');
            
        }
//                parent::add();

        $data = array();
        $this->dbtablelastid = 0;

        /* ------- Validation  -------------------- */
        $validationArr = array();
        foreach ($this->edit_columns as $col => $val) {
            if (isset($val['serverRules'])) {
                $validationArr[$col] = $val['serverRules'];
                $this->form_validation->set_rules($col, $val['disp'], $val['serverRules']);
            }
        }

        /* ------------------------------------------ */
        if ($this->form_validation->run() == FALSE) {
//                       $errors = validation_errors();
            $errors = array();
            foreach ($this->edit_columns as $col => $val) {
                if (isset($val['serverRules'])) {
                    $errors[$col] = form_error("$col", '<p>', '</p>');
                }
            }
            echo json_encode(['error' => $errors]);
        } else {

            foreach ($this->edit_columns as $col => $colparams) {
                if (isset($colparams['save_function'])) {
                    $data[$col] = $colparams['save_function'] . '(' . $this->input->post($col) . ')';
                } elseif (isset($colparams['save_function_php'])) {
                    $data[$col] = $colparams['save_function_php']($this->input->post($col));
                } elseif (isset($colparams['type']) && $colparams['type'] == 'file') {
                    $this->load->helper('file_upload_helper');
                     //-----------------Single Photo--------------------//
                    if (isset($_FILES['photo']) && !empty($_FILES['photo']['name'])) {
                       

                        $path1 = pathinfo($_FILES['photo']['name']);
                       
                         $ext1 = $path1['extension'];
                         $filename = strtoupper($this->session->userdata('school_code')) . '_' . stripslashes(str_replace('/', '-', $this->input->post('admission_no'))) . '_' . $this->academic_session[0]->fin_year . '_' . date('Ymdhis') . '.' . $path1['extension'];
                        
                          $status = do_upload('photo', './assets/img/pic/', $filename);
                       
                         
                        if (!empty($status['errors'])) {
                            $this->session->set_flashdata('errormsg', $status['errors']);
                        } else {
                            $data['photo'] = $filename;
                             
                        }
                    }
                    //-----------------Single Photo End--------------------//

                    //-----------------Family Photo--------------------//

                    if (isset($_FILES['family_photo']) && !empty($_FILES['family_photo']['name'])) {
                      
                        $path11 = pathinfo($_FILES['family_photo']['name']);
                       
                        $ext11 = $path11['extension'];
                        $filename_family = strtoupper($this->session->userdata('school_code')) . '_' . stripslashes(str_replace('/', '-', $this->input->post('admission_no'))) . '_' . $this->academic_session[0]->fin_year . '_' . date('Ymdhis') . '.' . $path11['extension'];
                        
                        $status_family = do_upload('family_photo', './assets/Schools_Photos/family_pic/', $filename_family);
                       
                        if (!empty($status_family['errors'])) {
                            $this->session->set_flashdata('errormsg', $status_family['errors']);
                        } else {
                            $data['family_photo'] = $filename_family;
                           
                        }
                       
                    }
                } else {
                    $data[$col] = $this->input->post($col);
                }
            }
            if (isset($this->extra_add_columns)) {
                foreach ($this->extra_add_columns as $colk => $colv) {
                    $data[$colk] = $colv;
                }
            }
//code for dual permission goes here
            if (count($this->dualpermission) > 0) {

                $data['status'] = 'P';
            }
//code for dual permission end here

            $result = $this->dbconnection->insert($this->dbtable, $this->security->xss_clean($data));
            $this->dbtablelastid = $this->dbconnection->get_last_id();

            if ($this->input->post('phone') == '')
                $phone = '9876543210';
            else
                $phone = $this->input->post('phone');

            $admission_no = $this->input->post('admission_no');

            $student_id = $this->dbtablelastid;

            if ($this->school[0]->pwd_generation == 'AUTO') {

                $this->dbconnection->update("student", array('registered_status' => 1), array('id' => $student_id));
                $hashoptions = array(); // No options currently, but, we could add in future
                $pwhash = password_hash($this->input->post('phone'), PASSWORD_DEFAULT, $hashoptions); // Generate new hash
                $this->load->library('Randomno');
                $salt = $this->randomno->generateRandomString();

                $password = md5($this->input->post('phone') . $salt);



                $data_user = array(
                    "user_name" => "{$this->school[0]->school_code}-$admission_no",
                    'password' => $password,
                    'salt' => $salt,
                    'pw_hash' => $pwhash,
                    "encrypt_id" => 2,
                    "user_group_id" => 4,
                    "student_id" => $student_id,
                    "change_password" => 0,
                    'created_by' => $this->session->userdata('user_id'),
                    "contact_no" => $phone,
                    "email" => $this->input->post('email_address'),
                );

                $this->dbconnection->insert("user", $data_user);
            }


//LEDGER ENTRY//

            $data = array(
                'ledger_code' => $student_id,
                'ledger_name' => $this->input->post('first_name') . ' ' . $this->input->post('middle_name') . ' ' . $this->input->post('last_name'),
                'under_group' => 21,
                'email' => $this->input->post('email_address'),
                'phone' => $phone,
                'address' => $this->input->post('address'),
                'city' => '',
                'state' => '',
                'zip_code' => '',
                'uid_no' => $this->input->post('student_aadhar'),
                'pan_no' => '',
                'bank_name' => '',
                'account_number' => '',
                'cr_dr' => '',
                'opening_date' => '',
                'opening_balance' => 0,
                'credit_limit' => '',
                'credit_days' => '',
                'created_by' => $this->session->userdata('user_id'),
                'created_ip' => $_SERVER['REMOTE_ADDR'],
            );
//print_r($data);
            $this->dbconnection->insert('ledger', $data);
            $ledgerid = $this->dbconnection->get_last_id();



            $this->dbconnection->update("student", array('student_ledger_id' => $ledgerid), array('id' => $student_id));
//LEDGER ENTRY END//
//transport allocation entry
            if (!empty($this->input->post('ppoint_id')) && !empty($this->input->post('transport_id'))) {
                $trans_data = array(
                    'pickup_point' => $this->input->post('ppoint_id'),
                    'student' => $student_id,
                    'transport_id' => $this->input->post('transport_id'),
                    'date_created' => date('Y-m-d'),
                    'created_by' => $this->session->userdata('user_id'),
                );
                $this->dbconnection->insert('transport_allocation', $trans_data);
            }

            if (!empty($this->input->post('stud_category'))) {
                $this->dbconnection->insert('transport_feecategory_monthly_log', array(
                    'student_id' => $student_id,
                    'change_name' => 'stud_category',
                    'year' => $this->academic_session[0]->fin_year,
                    'apr' => $this->input->post('stud_category'),
                    'may' => $this->input->post('stud_category'),
                    'jun' => $this->input->post('stud_category'),
                    'jul' => $this->input->post('stud_category'),
                    'aug' => $this->input->post('stud_category'),
                    'sep' => $this->input->post('stud_category'),
                    'oct' => $this->input->post('stud_category'),
                    'nov' => $this->input->post('stud_category'),
                    'dec' => $this->input->post('stud_category'),
                    'jan' => $this->input->post('stud_category'),
                    'feb' => $this->input->post('stud_category'),
                    'mar' => $this->input->post('stud_category'),
                    'created_by' => $this->session->userdata('user_id'),
                    'ip_address' => $this->input->ip_address()));
            }

            if (!empty($this->input->post('transport_amt'))) {

                switch ($this->session->userdata('school_id')) {
                    case 29: //june
                        $apr = $may = $jul = $aug = $sep = $oct = $nov = $dec = $jan = $feb = $mar = $this->input->post('transport_amt');
                        $jun = '0';
                        break;
                    case 24: //june
                        $apr = $may = $jul = $aug = $sep = $oct = $nov = $dec = $jan = $feb = $mar = $this->input->post('transport_amt');
                        $jun = '0';
                        break;
                    case 25:// may
                        $apr = $jun = $jul = $aug = $sep = $oct = $nov = $dec = $jan = $feb = $mar = $this->input->post('transport_amt');
                        $may = '0';
                        break;
                    default:
                        $apr = $may = $jun = $jul = $aug = $sep = $oct = $nov = $dec = $jan = $feb = $mar = $this->input->post('transport_amt');
                }
                $this->dbconnection->insert('transport_feecategory_monthly_log', array(
                    'student_id' => $student_id,
                    'change_name' => 'transport_amt',
                    'year' => $this->academic_session[0]->fin_year,
                    'apr' => $apr,
                    'may' => $may,
                    'jun' => $jun,
                    'jul' => $jul,
                    'aug' => $aug,
                    'sep' => $sep,
                    'oct' => $oct,
                    'nov' => $nov,
                    'dec' => $dec,
                    'jan' => $jan,
                    'feb' => $feb,
                    'mar' => $mar,
                    'created_by' => $this->session->userdata('user_id'),
                    'ip_address' => $this->input->ip_address()));
            }



            /* ---------- Auditntrail  --------------------- */
            $audit = array("action" => 'Add',
                "module" => $this->page_title,
                "page" => basename(__FILE__, '.php'),
                'datetime' => date("Y-m-d H:i:s"),
                'userid' => $this->session->userdata('user_id'),
                'remarks' => 'ID:' . $this->dbtablelastid,
                'ip_address' => $_SERVER['REMOTE_ADDR'],
            );
            $this->dbconnection->insert("auditntrail", $audit);

            $this->session->set_flashdata('successmsg', "Successfully Created Record $this->dbtablelastid.");


            echo json_encode(['success' => 'Record added successfully.']);
        }
    }

    public function update($id) {
//                parent::update($id);
        if (!$this->input->is_ajax_request() || substr($this->right_access, 2, 1) != 'U') {
            show_404();
        }

        $$datarecord = $this->dbconnection->select('student', "photo,family_photo,transport_amt,stud_category", "id=" . $id);

        if (isset($_FILES['photo']) && !empty($_FILES['photo']['name'])) {
            $this->edit_columns['photo'] = array('disp' => 'Photo', 'type' => 'file', 'serverRules' => 'callback_file_check');
        } else {
//            if(file_exists('assets/img/pic/'.$datarecord[0]->photo)){}else{
            $this->edit_columns['photo'] = array('disp' => 'Photo', 'type' => 'file');
//            }
        }

        if (isset($_FILES['family_photo']) && !empty($_FILES['family_photo']['name'])) {
            $this->edit_columns['family_photo'] = array('disp' => 'FPhoto', 'type' => 'file', 'serverRules' => 'callback_file_check_family');
        } else {
//            if(file_exists('assets/img/pic/'.$datarecord[0]->photo)){}else{
            $this->edit_columns['family_photo'] = array('disp' => 'FPhoto', 'type' => 'file');
//            }
        }

        /* ------- Validation  -------------------- */
        $validationArr = array();
        foreach ($this->edit_columns as $col => $val) {
            if (isset($val['serverRules'])) {
                $validationArr[$col] = $val['serverRules'];
                $this->form_validation->set_rules($col, $val['disp'], $val['serverRules']);
            }
        }

        /* ------------------------------------------ */

        if ($this->form_validation->run() == FALSE) {
//            $errors = validation_errors();
            $errors = array();
            foreach ($this->edit_columns as $col => $val) {
                if (isset($val['serverRules'])) {
                    $errors[$col] = form_error("$col", '<p>', '</p>');
                }
            }
            echo json_encode(['error' => $errors]);
        } else {

            $data = array();
            foreach ($this->edit_columns as $col => $colparams) {
                if (isset($colparams['save_function'])) {
                    $data[$col] = $colparams['save_function'] . '(' . $this->input->post($col) . ')';
                } elseif (isset($colparams['save_function_php'])) {
                    $data[$col] = $colparams['save_function_php']($this->input->post($col));
                } elseif (isset($colparams['type']) && $colparams['type'] == 'file') {
                    $this->load->helper('file_upload_helper');
                    if (isset($_FILES['photo']) && !empty($_FILES['photo']['name'])) {
                        $path1 = pathinfo($_FILES['photo']['name']);
                        $ext1 = $path1['extension'];
                        $filename = strtoupper($this->session->userdata('school_code')) . '_' . stripslashes(str_replace('/', '', $this->input->post('admission_no'))) . '_' . $this->academic_session[0]->fin_year . '_' . date('Ymdhis') . '.' . $path1['extension'];
                        $status = do_upload('photo', './assets/img/pic/', $filename);
                        if (!empty($status['errors'])) {
                            $this->session->set_flashdata('errormsg', $status['errors']);
                        } else {
                            $data['photo'] = $filename;
                           
                        }
                    }

                    if (isset($_FILES['family_photo']) && !empty($_FILES['family_photo']['name'])) {
                        $path11 = pathinfo($_FILES['family_photo']['name']);
                        $ext11 = $path11['extension'];
                        $family_photo_filename = strtoupper($this->session->userdata('school_code')) . '_' . stripslashes(str_replace('/', '', $this->input->post('admission_no'))) . '_' . $this->academic_session[0]->fin_year . '_' . date('Ymdhis') . '.' . $path11['extension'];
                        $status = do_upload('family_photo', './assets/Schools_Photos/family_pic/', $family_photo_filename);
                        if (!empty($status['errors'])) {
                            $this->session->set_flashdata('errormsg', $status['errors']);
                        } else {
                            $data['family_photo'] = $family_photo_filename;
                        }
                    }
                } else {
                    $data[$col] = $this->input->post($col);
                }
            }

            if (isset($this->extra_edit_columns)) {
                foreach ($this->extra_edit_columns as $colk => $colv) {
                    $data[$colk] = $colv;
                }
            }
            $this->updateind = $this->dbconnection->update($this->dbtable, $this->security->xss_clean($data), array('id' => $id));

            $arrmon = array(1 => "apr", 2 => "may", 3 => "jun", 4 => "jul", 5 => "aug", 6 => "sep", 7 => "oct", 8 => "nov", 9 => "dec", 10 => "jan", 11 => "feb", 12 => "mar");
            $start = array_search(lcfirst(date('M')), $arrmon);
            $end = 12;
            $array_trans = array();
            $array_feecat = array();
            for ($s = $start; $s <= $end; $s++) {
                $array_trans["$arrmon[$s]"] = $this->input->post('transport_amt');
                $array_feecat["$arrmon[$s]"] = $this->input->post('stud_category');
            }

            if ($datarecord[0]->stud_category != $this->input->post('stud_category')) {

                $this->dbconnection->insert('changes_fee_auditntrail', array(
                    'student_id' => $id,
                    'change_name' => 'stud_category',
                    'tbl_name' => 'student',
                    'field_name' => 'stud_category',
                    'old_value' => $datarecord[0]->stud_category,
                    'new_value' => $this->input->post('stud_category'),
                    'userid' => $this->session->userdata('user_id'),
                    'ip_address' => $this->input->ip_address()));


                $array_feecat['date_modified'] = date('Y-m-d H:i:s');
                $array_feecat['modified_by'] = $this->session->userdata('user_id');
                $array_feecat['ip_address'] = $this->input->ip_address();

                $this->dbconnection->update('transport_feecategory_monthly_log', $array_feecat, "student_id=$id and year={$this->academic_session[0]->fin_year} and change_name='stud_category'");
            }

            if ($datarecord[0]->transport_amt != $this->input->post('transport_amt')) {

                $this->dbconnection->insert('changes_fee_auditntrail', array(
                    'student_id' => $id,
                    'change_name' => 'transport_amt',
                    'tbl_name' => 'student',
                    'field_name' => 'transport_amt',
                    'old_value' => $datarecord[0]->transport_amt,
                    'new_value' => $this->input->post('transport_amt'),
                    'userid' => $this->session->userdata('user_id'),
                    'ip_address' => $this->input->ip_address()));

                switch ($this->session->userdata('school_id')) {
                    case 29: //june
//                        $apr = $may = $jul = $aug = $sep = $oct = $nov = $dec = $jan = $feb = $mar = $this->input->post('transport_amt');
//                        $jun = '0';
                        $array_trans['jun'] = 0;
                        break;
                    case 24: //june
//                        $apr = $may = $jul = $aug = $sep = $oct = $nov = $dec = $jan = $feb = $mar = $this->input->post('transport_amt');
//                        $jun = '0';
                        $array_trans['jun'] = 0;
                        break;
                    case 25:// may
//                        $apr = $jun = $jul = $aug = $sep = $oct = $nov = $dec = $jan = $feb = $mar = $this->input->post('transport_amt');
//                        $may = '0';
                        $array_trans['may'] = 0;
                        break;
                    default:
//                        $apr = $may = $jun = $jul = $aug = $sep = $oct = $nov = $dec = $jan = $feb = $mar = $this->input->post('transport_amt');
                }
                $array_trans['date_modified'] = date('Y-m-d H:i:s');
                $array_trans['modified_by'] = $this->session->userdata('user_id');
                $array_trans['ip_address'] = $this->input->ip_address();
                $this->dbconnection->update('transport_feecategory_monthly_log', $array_trans, "student_id=$id and year={$this->academic_session[0]->fin_year} and change_name='transport_amt'");
            }

            if (!empty($this->input->post('pwd_change')) && $this->input->post('pwd_change') == 'YES') {

//                        $this->dbconnection->update("student", array('registered_status'=>1), array('id'=>$student_id));
                $hashoptions = array(); // No options currently, but, we could add in future
                $pwhash = password_hash($this->input->post('phone'), PASSWORD_DEFAULT, $hashoptions); // Generate new hash
                $this->load->library('Randomno');
                $salt = $this->randomno->generateRandomString();
                $password = md5($this->input->post('phone') . $salt);

                $datau = array(
                    'password' => $password,
                    'pw_hash' => $pwhash,
                    'salt' => $salt,
                    'encrypt_id' => 2,
                    'change_password' => 1,
                    'contact_no' => $this->input->post('phone'),
                    'last_date_modified' => date('Y-m-d H:i:s'),
                    'last_modified_by' => $this->session->userdata('user_id'),
                );
                $this->dbconnection->update('user', $datau, 'student_id ="' . $id . '"');
            }

//LEDGER ENTRY//
            $firstname = $this->input->post('first_name');
            $middlename = $this->input->post('middle_name');
            $lastname = $this->input->post('last_name');

            $student_name = $firstname . ' ' . $middlename . ' ' . $lastname;
            $field = array
                (
                'ledger_code' => $student_ledger_id,
                'ledger_name' => $student_name,
                'under_group' => 21,
                'email' => $this->input->post('email_address'),
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address'),
                'city' => '',
                'state' => '',
                'zip_code' => '',
                'uid_no' => $this->input->post('student_aadhar'),
                'pan_no' => '',
                'bank_name' => '',
                'account_number' => '',
                'cr_dr' => '',
                'opening_date' => '',
                'opening_balance' => '',
                'credit_limit' => '',
                'credit_days' => '',
                'last_modified_by' => $this->session->userdata('user_id'),
                'modified_ip' => $_SERVER['REMOTE_ADDR'],
            );
// print_r($field);
// die();

            $this->dbconnection->update('ledger', $field, 'ledger_code=' . $id);

//LEDGER ENTRY END//
//transport allocation 
            $trans_updata = array(
                'pickup_point' => $this->input->post('ppoint_id'),
                'transport_id' => $this->input->post('transport_id'),
                'last_date_modified' => date('Y-m-d'),
                'last_modified_by' => $this->session->userdata('user_id'),
            );
            $this->dbconnection->update('transport_allocation', $trans_updata, 'student="' . $id . '"');

//Audit Trail
            $audit = array("action" => 'Update',
                "module" => $this->page_title,
                "page" => basename(__FILE__, '.php'),
                'datetime' => date("Y-m-d H:i:s"),
                'userid' => $this->session->userdata('user_id'),
                'remarks' => 'ID:' . $id,
                'ip_address' => $_SERVER['REMOTE_ADDR'],
            );
            $this->dbconnection->insert("auditntrail", $audit);
            $this->session->set_flashdata('successmsg', "Successfully Updated Record $id.");

            echo json_encode(['success' => 'Record updated successfully.']);
        }
    }

    public function paged_data() {
        if (!$this->input->is_ajax_request()) {
            redirect('404');
        }
        $session = $this->input->post('session_id');
        $class = $this->input->post('class_id');
        $section = $this->input->post('section_id');
        $status = $this->input->post('status');
        $where = '';
        if ($session != 'All') {
            $where .= " student_academicyear_id=$session and";
        }
        if ($class != 'All') {
            $where .= " class_id=$class and";
        }
        if ($section != 'All') {
            $where .= " section_id=$section and";
        }
//        if ($status != 'Y') {
//            $where .= "t1.status=$status";
//        }
//        if (isset($this->data_select_where))
//            $where .= $this->data_select_where;
//        else
        if ($this->school[0]->school_group == 'ARMY') {
            $where .= " status='$status'";
        } else
        {
            
            $where .= " status='Y'";
        }


        $like = array();
        $or_like = array();
        $order = '';
        $rec_key = $this->rec_key;

        $offset = $this->input->post('start');
        $limit = $this->input->post('length');

// Map column names to positions used by datatable
        $colno = 0;
        $colnotoname = array();
        foreach ($this->display_columns as $field => $disp) {
            $colnotoname[$colno] = $field;
            $colno++;
        }
        $orderpartsarr = array();
        foreach ($this->input->post('order') as $orderpart) {
            if (isset($colnotoname[$orderpart['column']])) {
                if ($orderpart['dir'] == 'asc') {
                    $orderpartsarr[] = $colnotoname[$orderpart['column']] . " ASC";
                } else {
                    $orderpartsarr[] = $colnotoname[$orderpart['column']] . " DESC";
                }
            }
        }
        if (count($orderpartsarr) > 0) {
            $order = implode(', ', $orderpartsarr);
        }

        $search = $this->input->post('search');
        if (ctype_digit($search['value'])) {
            $search_cols = $this->search_columns['numeric'] + $this->search_columns['alpha_num'];
        } elseif ($search['value'] != '') {
            $search_cols = $this->search_columns['alpha_num'];
        } else {
            $search_cols = array();
        }
        foreach ($search_cols AS $search_col) {
            $or_like[] = array('col' => $search_col, 'val' => $search['value']);
        }


        $v = 0;
        $requestData = $_REQUEST;
        foreach ($this->search_columns['custom'] as $field) {
            if (!empty($requestData['columns'][$v]['search']['value'])) {
                $or_like[] = array('col' => $field, 'val' => $requestData['columns'][$v]['search']['value']);
            }
            $v++;
        }

        $output = array('draw' => $this->input->post('draw'));
        $output['orderpartsarr'] = $orderpartsarr;
        $output['order'] = $order;

        $output['recordsTotal'] = $this->dbconnection->count($this->data_table, $where);
        $output['recordsFiltered'] = $this->dbconnection->count($this->data_table, $where, $like, $or_like);

        $records = $this->dbconnection->select_limit_query($this->data_table, $this->data_select, $where, $order, $limit, $offset, $like, $or_like);


        $records_arr = array();

        foreach ($records as $rec) {
            $recactions = '';
            $recarr = array();
            foreach ($this->display_columns as $field => $disp) {
                $recarr[] = $rec->$field;
            }
//			if (!$this->read_only) {
            if ($this->dualpermission > 0) {
                if (($status == 'P') && $this->school[0]->school_group == 'ARMY') {
                    if (($this->person) == $this->session->userdata('user_id') || $this->dual_right_access == 'C') {
                        $recactions .= "<input type=\"checkbox\" class=\"btn\" style=\"margin: -2px 0 0;\"  id=\"{$rec->$rec_key}\">";
                        $recactions .= "<a  data-toggle=\"modal\" onclick=\"approve('{$rec->$rec_key}');\" title=\"Approve\" style=\"padding: 0px 8px;color:green\"><i class=\"fa fa-check\"></i></a>";
                    }
                    if (($this->person) == $this->session->userdata('user_id') || $this->dual_right_access == 'D') {

                        $recactions .= "<a data-toggle=\"modal\" onclick=\"reject('{$rec->$rec_key}');\" title=\"Reject\" style=\"padding: 0px 8px;color:red\"><i class=\"fa fa-close\"></i></a>";
                    }
                } else if ($status == 'N') {
                    if (($this->person) == $this->session->userdata('user_id') || $this->dual_right_access == 'C') {
                        $recactions .= "<a class=\"btn-xs btn btn-success\" data-toggle=\"modal\" onclick=\"approve('{$rec->$rec_key}');\"><i class=\"fa fa-check\"></i>Approve</a>";
                    }
                }
            }
            
            if (substr($this->right_access, 2, 1) == 'U') {
                $recactions .= "<a class=\"btn a-edit\" onclick=\"edit_rec('{$rec->$rec_key}');\" data-toggle=\"tooltip\" title=\"Edit\" data-placement=\"bottom\"><i class=\"fa fa-edit\"></i></a>";
            }
            if (substr($this->right_access, 3, 1) == 'D') {
                $recactions .= "<a class=\"btn a-delete\" data-toggle=\"modal\" onclick=\"delete_rec('{$rec->$rec_key}');\"><i class=\"fa fa-trash\"></i></a>";
            }

            
            if (isset($this->edit_columns['lat']) && isset($this->edit_columns['long'])) {
                $recactions .= "<a class=\"btn\" target='_blank' href='https://www.google.com/maps/place/$rec->location_description/@$rec->lat,$rec->long,8z'><i class=\"fa fa-map\"></i>Map</a>";
            }
            $recarr[] = $recactions;
//                        }
            $records_arr[] = $recarr;
        }

        $output['data'] = $records_arr;

        echo json_encode($output);
    }

    public function file_check() {

//        $this->load->helper('file');
        $allowed_mime_type_arr = array('image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/png', 'image/x-png');
        $mime = get_mime_by_extension($_FILES['photo']['name']);

        if (empty($_FILES['photo']['name'])) {
            $this->form_validation->set_message('file_check', 'Please choose a file to upload.');
            return false;
        } else {

            if (in_array($mime, $allowed_mime_type_arr)) {
                return true;
            } else {
                $this->form_validation->set_message('file_check', 'Please select only gif/jpg/png file.');
                return false;
            }
        }
    }

    public function file_check_family() {

//        $this->load->helper('file');
        $allowed_mime_type_arr = array('image/gif', 'image/jpeg', 'image/jpg', 'image/pjpeg', 'image/png', 'image/x-png');
        $mime = get_mime_by_extension($_FILES['family_photo']['name']);

        if (empty($_FILES['family_photo']['name'])) {
            $this->form_validation->set_message('file_check', 'Please choose a file to upload.');
            return false;
        } else {

            if (in_array($mime, $allowed_mime_type_arr)) {
                return true;
            } else {
                $this->form_validation->set_message('file_check', 'Please select only gif/jpg/png file.');
                return false;
            }
        }
    }

    public function Get_vehicle() {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }
        $id = $this->input->post('id');
        $vehicle = $this->db->query('select t1.*,t3.id as vid,t3.vehicle_no from transport_pickup_points as t1 join routes as t2 on t1.route_id=t2.id join vehicle as t3 on t2.vehicle=t3.id where location_id=' . $id)->result();
        $successdata = '';
        $successdata .= '<option value="">Select</option>';
        foreach ($vehicle as $value) {
            $successdata .= '<option value="' . $value->vid . '">' . $value->vehicle_no . '</option>';
        }
        echo json_encode(['successdata' => $successdata]);
    }

    public function Get_amount() {
        // if (!$this->input->is_ajax_request()) {
        //     show_404();
        // }
        $pickup_point = $this->input->post('ppoint_id');
        $vehicle_no = $this->input->post('vehicle');
        $amount = $this->db->query('select t1.*,t3.id as vid,t3.vehicle_no from transport_pickup_points as t1 join routes as t2 on t1.route_id=t2.id join vehicle as t3 on t2.vehicle=t3.id where location_id='.$pickup_point.' and t3.id='.$vehicle_no.'')->result();
       
        $amount=$amount[0]->amounts;
        $array=array('amount'=>$amount);
        echo json_encode($array);
        
    }

    public function exportcsv() {

        $where = '';
        if ($this->uri->segment(4) != 'All') {
            $where .= " student_academicyear_id={$this->uri->segment(4)} and";
        }
        if ($this->uri->segment(5) != 'All') {
            $where .= " class_id={$this->uri->segment(5)} and";
        }
        if ($this->uri->segment(6) != 'All') {
            $where .= " section_id={$this->uri->segment(6)} and";
        }
        if ($this->school[0]->school_group == 'ARMY') {


            $where .= " status='{$this->uri->segment(7)}'";
        } else {
            $where .= " status='Y'";
        }
        // print_r($where);
        // die();
        $records = $this->dbconnection->select($this->data_table, $this->data_select, $where);
        $school_code = $this->session->userdata('school_code');
        $filename = "FCLB-$school_code-$this->rec_type-Export-" . date('Ymd') . ".csv";

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $filename);

        $colnames = array();
        foreach ($this->display_columns as $field => $disp) {
            $colnames[] = $disp;
        }
        foreach ($this->edit_columns as $col => $colparams) {
            if (!isset($this->display_columns[$col])) {
                $colnames[] = $colparams['disp'];
            }
        }

        $out = fopen('php://output', 'w');
        fputcsv($out, $colnames);
        foreach ($records as $rec) {
            $recarr = array();
            foreach ($this->display_columns as $field => $disp) {
                $recarr[] = $rec->$field;
            }
            foreach ($this->edit_columns as $col => $colparams) {
                if (!isset($this->display_columns[$col])) {
                    $recarr[] = $rec->$col;
                }
            }
            fputcsv($out, $recarr);
        }
        fclose($out);
    }

    public function student_report() {
//        error_reporting(-1);
//		ini_set('display_errors', 1);
        $this->page_code = 'student_report';
        $this->page_id = $this->dbconnection->Get_namme("crmfeesclub.link_page", "l_code", "$this->page_code", "id");
        $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
        $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
        $this->right_access = $this->page_perm;

        if (strpos($this->page_perm, '----') == true) {
            redirect(base_url(''), 'refresh');
        }

        if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }

        $col = array();
        if ($this->input->post()) {
            $class_id = $this->input->post('class_list');
            $section_id = $this->input->post('section_list');
            $fee_id = $this->input->post('fee_category');
            $option = $this->input->post('optradio');
            $str_query = '';
            if ($class_id != 'All') {
                $str_query .= ' and class_id=' . $class_id;
            }
            if ($section_id != 'All') {
                $str_query .= ' and section_id=' . $section_id;
            }
            if ($fee_id != 'All') {
                $str_query .= ' and stud_category=' . $fee_id;
            }

            $select = '';

            if (!empty($this->input->post('optradio')[1])) {
                $select .= 'admission_no,';
                $col['admission_no'] = 'Admission No';
            }
            if (!empty($this->input->post('optradio')[2])) {
                $select .= "concat(first_name,' ',middle_name,' ',last_name) stud_name,";
                $col['stud_name'] = 'Student Name';
            }
            if (!empty($this->input->post('optradio')[3])) {
                $select .= 'roll,';
                $col['roll'] = 'Roll';
            }
            if (!empty($this->input->post('optradio')[4])) {
                $select .= 'father_name,';
                $col['father_name'] = 'Father\'s Name';
            }
            if (!empty($this->input->post('optradio')[5])) {
                $select .= 'mother_name,';
                $col['mother_name'] = 'Mother\'s Name';
            }
            if (!empty($this->input->post('optradio')[6])) {
                $select .= 'guardian_name,';
                $col['guardian_name'] = 'Guardian\'s Name';
            }
            if (!empty($this->input->post('optradio')[7])) {
                $select .= 'phone,';
                $col['phone'] = 'Contact No.';
            }
            if (!empty($this->input->post('optradio')[8])) {
                $select .= 'email_address,';
                $col['email_address'] = 'Email Address';
            }
            
            if($this->session->userdata('school_id')==43){
            if (!empty($this->input->post('optradio')[9])) {
                $select .= 'hostel,';
                $col['hostel'] = 'Hostel Name';
            }	
              if (!empty($this->input->post('optradio')[10])) {
                $select .= 'sets,';
                $col['sets'] = 'Sets';
            }	
              if (!empty($this->input->post('optradio')[11])) {
                $select .= 'headmaster,';
                $col['headmaster'] = 'Head Master';
            }	
              if (!empty($this->input->post('optradio')[12])) {
                $select .= 'color_house,';
                $col['color_house'] = 'Colour House';
            }	
              if (!empty($this->input->post('optradio')[13])) {
                $select .= 'coaching,';
                $col['coaching'] = 'Aksah/ETC';
            }	
              if (!empty($this->input->post('optradio')[14])) {
                $select .= 'bottle,';
                $col['bottle'] = 'Bottle';
            }	
              if (!empty($this->input->post('optradio')[15])) {
                $select .= 'pl_house,';
                $col['pl_house'] = 'Pl House';
            }	
              if (!empty($this->input->post('optradio')[16])) {
                $select .= 'medium,';
                $col['medium'] = 'Medium';
            }	
              if (!empty($this->input->post('optradio')[17])) {
                $select .= 'reference_no,';
                $col['reference_no'] = 'Reg No';
            }	
              if (!empty($this->input->post('optradio')[18])) {
                $select .= 'category,';
                $col['category'] = 'Category';
            }	

            }
            //  if (!empty($this->input->post('optradio')[9])) {
            //     $select .= 'stud_category,';
            //     $col['stud_category'] = 'Fee Category';
            // }
            rtrim($select, ',');
            $data['stud_report'] = $this->dbconnection->select("student", "$select", "status='Y' $str_query", "roll");
        } else {
            $col['admission_no'] = 'Admission No';
            $col['stud_name'] = 'Student Name';
            $data['stud_report'] = $this->dbconnection->select("student", "admission_no,concat(first_name,' ',middle_name,' ',last_name) stud_name,stud_category", "status='Y'", "admission_no");
        }
        $data['aclass'] = $this->dbconnection->select("class", "class_name,id", "status='Y'");
        $data['asection'] = $this->dbconnection->select("section", "sec_name,id", "status='Y'");
        $data['feecategory'] = $this->dbconnection->select("category", "cat_name,id", "status='Y'");
        $data['academic_sessions'] = $this->dbconnection->select("accedemic_session", "id,session", "status='Y'");
        $data['col'] = $col;
        $data['page_title'] = 'Student Report';
        $data['section'] = 'admission';
        $data['page_name'] = 'student_report';
        $this->load->view('index', $data);
    }

    public function approvestudentlist() {

        $data['class'] = $this->dbconnection->select("class", "id,class_name", "status='Y'");
        $data['sectionj'] = $this->dbconnection->select("section", "id,sec_name", "status='Y'");

        $data['rec_type'] = 'Student';
        $data['rec_types'] = 'Students';
        $data['dbtable'] = 'student';
        $data['page_title'] = 'Student Approve';
        $data['section'] = 'admission';
        $data['page_name'] = 'approve_student';
        $data['academic_session'] = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y'");

        $data['display_columns'] = array('id' => 'Student ID', 'admission_no' => 'Admission No.',
            'name_disp' => 'Student Name', 'father_name' => 'Father&apos;s Name',
            'dob' => 'DOB', 'stud_category_disp' => 'Category',
            'phone' => 'Phone No.', 'class_id_disp' => 'Class', 'section_id_disp' => 'Section',
        );
        $data['search_columns'] = array(
            'alpha_num' => array(
                'first_name',
                'last_name',
                'email_address',
                'phone',
//					'class_id_disp',
                'admission_no',
            ),
            'numeric' => array(
                'id',
                'phone',
                'transport_amt',
            ),
            'custom' => array('id', 'admission_no', 'first_name', 'father_name', 'dob', 'stud_category', 'email_address', 'phone', 'class_id', 'section_id'),
        );



        $data['stud_report'] = $this->dbconnection->select("student", "id,admission_no,concat(first_name,' ',middle_name,' ',last_name) stud_name,father_name,dob,gender,stud_category,(SELECT cat_name FROM category WHERE id=student.stud_category) AS stud_category_disp,(select session from accedemic_session where id=student.student_academicyear_id) AS acedemic_id_disp, email_address, phone,student_academicyear_id,class_id, (SELECT class_name FROM class WHERE id=student.class_id) AS class_id_disp,section_id, (SELECT sec_name FROM section WHERE id=student.section_id) AS section_id_disp, course_id,mother_tongue,student_aadhar,birth_place,nationality,religion,caste,father_phone,father_aadhar,mother_name,mother_phone,mother_aadhar,guardian_name,guardian_phone,guardian_aadhar,blood_group,height,weight,vision,address,permanent_address", "status='P'", "admission_no");
        $this->load->view('index', $data);
    }

    public function approve($id) {
        if (!$this->input->is_ajax_request() || substr($this->dual_right_access != 'C')) {
            show_404();
        }
        $data = array(
            'status' => 'Y',
        );
        $this->dbconnection->update("student", $data, array('id' => $id));
    }
    
     public function bulkapprove() {
            
		$student_id_string = $this->input->post('student_id_string');
		foreach ($student_id_string as $val) {
                    $q=$this->dbconnection->update('student',array('status'=>'Y'),'id='.$val);                       
                }
	}

    public function reject($id) {
        if (!$this->input->is_ajax_request() || substr($this->dual_right_access != 'C')) {
            show_404();
        }
        $data = array(
            'status' => 'N',
        );
        $this->dbconnection->update("student", $data, array('id' => $id));
    }

    public function checkpay() {
        $id = $this->input->post('id');

        $get = $this->dbconnection->select("fee_transaction_head", "id", "paid_status=1 and status=1 and response_code=0");

        if (count($get) > 0) {
            echo "You Dont able to change the start fee month as payment has been already done of this student!!";
        } else {
            echo '0';
        }
    }

}
