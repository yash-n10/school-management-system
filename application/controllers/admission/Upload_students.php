<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Upload_students extends CI_Controller {

    public $page_code = 'upload_student';
    public $page_id = '';
    public $page_perm = '----';

    public function __construct() {
        parent::__construct();

        $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");

//		switch($this->session->userdata('login_type')){
//                    case 'appadmin':
//                                        $this->right_access = 'CRUD';
//                                        break;
//                    case 'admin':
//                                        $this->right_access = 'CRUD';
//                                        break;
//                    case 'office':
//                                        $this->right_access = 'CRUD';
//                                        break;
//                    case 'principal':
//                                        $this->right_access = 'CRUD';
//                                        break;
//                    case 'school':
//                                        $this->right_access = 'CRUD';
//                                        break;
//                    default:
//                                        $this->right_access = '----';
////                        echo base_url();
//                                        redirect(base_url(), 'refresh');
//                }

        $this->id = $this->session->userdata('school_id');
        $this->school_desc = $this->dbconnection->select("school", "*", "id=" . $this->id . " and status = 1");
        $this->schools = $this->dbconnection->select("school", "*", 'status = 1');
        $this->countries = $this->dbconnection->select('countries', '*', 'id=' . $this->school_desc[0]->country_id);
        $this->state = $this->dbconnection->select('states', '*', 'id=' . $this->school_desc[0]->state_id);
        $this->city = $this->dbconnection->select('cities', '*', 'id=' . $this->school_desc[0]->city_id);

        $this->country_code = $this->countries[0]->country_code;
        $this->state_code = $this->state[0]->state_code;
        $this->city_code = $this->city[0]->city_code;
        $this->school_code = $this->school_desc[0]->school_code;

        if ($this->id != 0)
            $this->db->db_select('crmfeesclub_' . $this->id);

        $this->page_title = 'Upload Students';
        $this->section = 'admission';
        $this->page_name = 'upload_students';
        $this->customview = '';
//                $a = array();
//                foreach ($this->session->userdata('sch_modules') as $r) {
//                    array_push($a, $r->modules);
//                };
        $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y' and active='Y'");
       
       
            $this->admission_csv_columns = array(
            array('field' => 'admission_no', 'human_name' => 'Admission Number'), //0
            array('field' => 'first_name', 'human_name' => 'First Name'), //1
            array('field' => 'middle_name', 'human_name' => 'Middle Name'), //2
            array('field' => 'last_name', 'human_name' => 'Last Name'), //3
            array('field' => 'stud_category', 'human_name' => 'Fee Category'), //4
            array('field' => 'class_id', 'human_name' => 'Class'), //5
            array('field' => 'section_id', 'human_name' => 'Section'), //6
            array('field' => 'phone', 'human_name' => 'Student\'s Phone Number'), //7
            array('field' => 'email_address', 'human_name' => 'Email Address'), //8
            array('field' => 'father_name', 'human_name' => 'Fathers Name'),
            array('field' => 'dob', 'human_name' => 'D.O.B.'),
            array('field' => 'gender', 'human_name' => 'Gender'),
            array('field' => 'course_id', 'human_name' => 'Course'),
            array('field' => 'transport_amt', 'human_name' => 'Transport Fee per month(if any)'),
            array('field' => 'fine_waiver', 'human_name' => 'Fine Waiver(if want to waive off then YES)'),
            array('field' => 'admission_date', 'human_name' => 'Admission Date'),
            array('field' => 'mother_name', 'human_name' => 'Mother\'s Name'),
            array('field' => 'student_aadhar', 'human_name' => 'Student\'s Aadhar No'),
            array('field' => 'father_aadhar', 'human_name' => 'Father\'s Aadhar No'),
            array('field' => 'mother_aadhar', 'human_name' => 'Mother\'s Aadhar No'),
            array('field' => 'father_phone', 'human_name' => 'Father\'s Phone No'),
            array('field' => 'mother_phone', 'human_name' => 'Mother\'s Phone No'),
            array('field' => 'guardian_name', 'human_name' => 'Guardian\'s Name'),
            array('field' => 'guardian_aadhar', 'human_name' => 'Guardian\'s Aadhar No'),
            array('field' => 'guardian_phone', 'human_name' => 'Guardian\'s Phone No'),
            array('field' => 'address', 'human_name' => 'Correspondence Address'),
            array('field' => 'roll', 'human_name' => 'Roll'),
            array('field' => 'ppoint_id', 'human_name' => 'Pickup Point'),
            array('field' => 'transport_id', 'human_name' => 'Vehicle No.'),
            array('field' => 'student_type', 'human_name' => 'Student Type'),
            array('field' => 'start_fee_month', 'human_name' => 'Start Fee Month'),
            array('field' => 'first_class', 'human_name' => 'First Adm Class'),
            array('field' =>'hostel' ,'human_name'=>'Hostel Name' ),
            array('field' =>'religion' ,'human_name'=>'Religion' ),
            array('field' =>'caste' ,'human_name'=>'Caste' ),

 
        );
       






        $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
        $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
        $this->right_access = $this->page_perm;


        $this->dualpermission = $this->dbconnection->select("dual_permission", "permission", "link_code=$this->page_id");
//        $dualpermission = $this->dbconnection->select("dual_permission", "authorise_person3,permission", "link_code=$this->page_id and authorise_person3={$this->session->userdata('user_id')}");
        $this->page_perm = !empty($this->dualpermission) ? $this->dualpermission[0]->permission : '----';
        $this->dual_right_access = $this->page_perm;


        if (strpos($this->page_perm, '----') == true) {
            redirect(base_url(''), 'refresh');
        }
    }

    public function index() {
        if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->data['page_name'] = $this->page_name;
        $this->data['page_title'] = $this->page_title;
        $this->data['section'] = $this->section;
        $this->data['session'] = $this->dbconnection->select("accedemic_session", "*", "status='Y' and active!='N'");
        $this->data['aclass'] = $this->dbconnection->select("class", "*", "status='Y'");
        $this->data['asection'] = $this->dbconnection->select("section", "id,sec_name", "status='Y'");
        $this->data['acategory'] = $this->dbconnection->select("category", "id,cat_code", "status='Y'");
        $this->data['acourse'] = $this->dbconnection->select("course", "id,course_code", "status='Y'");
        $this->data['aLocations'] = $this->dbconnection->select("locations", "id,location_description", "");
        $this->data['aVehicleNo'] = $this->dbconnection->select("vehicle", "id,vehicle_no", "status=1");
        $this->data['customview'] = $this->customview;
        $this->data['right_access'] = $this->right_access;

        $this->load->view('index', $this->data);
    }

    public function upload() {
//        if (substr($this->right_access, 0, 1) == 'C') {
////            redirect(base_url(), 'refresh');
//            redirect('404');
//        }
//                ini_set('max_input_time', 0);
        ini_set('max_execution_time', 3600);
//                       error_reporting(-1);
//	ini_set('display_errors', 1);
//       $this->db->db_debug=TRUE;
        $this->data['errors'] = array();
// Cache Admission Numbers
        $this->db->select('admission_no');
        $query = $this->db->get('student');
        $admission_nos = array_column($query->result_array(), NULL, 'admission_no');

// Cache Classes
        $this->db->select('id, class_code');
        $this->db->where('status="Y"');
        $query = $this->db->get('class');
        $classes = array_change_key_case(array_column($query->result_array(), 'id', 'class_code'), CASE_UPPER);

// Cache Categories
        $this->db->select('id, cat_code');
        $this->db->where('status="Y"');
        $query = $this->db->get('category');
        $cats = array_change_key_case(array_column($query->result_array(), 'id', 'cat_code'), CASE_UPPER);

// Cache Courses
        $this->db->select('id, course_code');
        $this->db->where('status="Y"');
        $query = $this->db->get('course');
        $courses = array_change_key_case(array_column($query->result_array(), 'id', 'course_code'), CASE_UPPER);

// Cache Pickup Points
        $this->db->select('id, location_description');
        $query = $this->db->get('locations');
        $locations = array_change_key_case(array_column($query->result_array(), 'id', 'location_description'), CASE_UPPER);

// Cache Vehicle No
        $this->db->select('id, vehicle_no');
        $this->db->where('status=1');
        $query = $this->db->get('vehicle');
        $vehicle_no = array_change_key_case(array_column($query->result_array(), 'id', 'vehicle_no'), CASE_UPPER);

        $studtype=array("EXISTING"=>'EXISTING','NEW ADMISSION'=>'NEW ADMISSION','TRANSFERED'=>'TRANSFERED');
        if (!empty($_FILES['admission_upload']['tmp_name'])) {

            $admsn_no_file = array();
            $handle = fopen($_FILES['admission_upload']['tmp_name'], "r");
            fgetcsv($handle); // Read and discard header row
            while (($row = fgetcsv($handle, 10000, ",")) !== FALSE) {
                $rowarr = array();
                foreach ($row as $pos => $value) {
//                                        if($pos!=13 || $pos!=14 || $pos!=15 ){
                    if ($pos < 13) {
                        if (!isset($this->admission_csv_columns[$pos]))
                            continue;
                    }
                    $rowarr[$this->admission_csv_columns[$pos]['field']] = trim($value);
                }
                /* ------ checking duplicate admission number in csv file  -------- */
                if (in_array($rowarr['admission_no'], $admsn_no_file)) {
                    $this->data['errors'][] = "Admission Number '" . $rowarr['admission_no'] . "' previously present in this file, skipping...";
                    continue;
                }

                $admsn_no_file[] = $rowarr['admission_no'];
                if (isset($admission_nos[$rowarr['admission_no']])) {
                    $this->data['errors'][] = "Admission Number '" . $rowarr['admission_no'] . "' already present, skipping...";
                    continue;
                }

                if (!isset($cats[strtoupper($rowarr['stud_category'])])) {
                    $this->data['errors'][] = "Admission Number '" . $rowarr['admission_no'] . "' has undefined category of '" . $rowarr['stud_category'] . "', skipping...";
                    continue;
                }

                if (!isset($classes[strtoupper($rowarr['class_id'])])) {
                    $this->data['errors'][] = "Admission Number '" . $rowarr['admission_no'] . "' has undefined class of '" . $rowarr['class_id'] . "', skipping...";
                    continue;
                }

                if ($rowarr['course_id'] != '') {
                    if (!isset($courses[strtoupper(trim($rowarr['course_id']))])) {
                        $this->data['errors'][] = "Admission Number '" . $rowarr['admission_no'] . "' has undefined course of '" . $rowarr['course_id'] . "', skipping...";
                        continue;
                    }
                    $course = $courses[strtoupper($rowarr['course_id'])];
                } else {
                    $course = 0;
                }

                if ($rowarr['student_type'] != '') {
                    if (!isset($studtype[strtoupper(trim($rowarr['student_type']))])) {
                    $this->data['errors'][] = "Admission Number '" . $rowarr['admission_no'] . "' has undefined student type of '" . $rowarr['student_type'] . "', skipping...";
                    continue;
                    }
                    $student_type = $studtype[strtoupper($rowarr['student_type'])];
                } else {
                    $student_type = 'EXISTING';
                }


                if ($rowarr['start_fee_month'] != '') {
                    $start_fee_month = $rowarr['start_fee_month'];
                } else {
                    $start_fee_month = '1';
                }


                if (!empty($data[15]) && date('Y', strtotime(str_replace('/', '-', $data[15]))) == 1970) {
                    $this->data['errors'][] = "Line $linerow: Admission Number '" . $data[0] . "' contains Admission date Invalid, skipping...";
                    continue;
                }
                $ppoint_id = 0;
                if (!empty($data[27]) && !isset($locations[strtoupper($rowarr['ppoint_id'])])) {
                    $this->data['errors'][] = "Line $linerow: Admission Number '" . $data[0] . "' contains Undefined Locations, skipping...";
                    continue;
                }
                if (!empty($data[27])) {
                    $ppoint_id = $locations[strtoupper($rowarr['ppoint_id'])];
                }
                $transport_id = 0;
                if (!empty($data[28]) && !isset($vehicle_no[strtoupper($rowarr['transport_id'])])) {
                    $this->data['errors'][] = "Line $linerow: Admission Number '" . $data[0] . "' contains Undefined Vehicle No, skipping...";
                    continue;
                }
                if (!empty($data[28])) {
                    $transport_id = $vehicle_no[strtoupper($rowarr['transport_id'])];
                }

//				$reference_no = "$this->country_code-$this->state_code-$this->city_code-$this->school_code-{$rowarr['admission_no']}";
//                                if(!empty($this->data['errors'])) {
                $data_student = array(
//						"reference_no" => $reference_no,
                    "reference_no" => '',
                    "admission_no" => $rowarr['admission_no'],
                    "first_name" => $rowarr['first_name'],
                    "middle_name" => $rowarr['middle_name'],
                    "last_name" => $rowarr['last_name'],
                    "stud_category" => $cats[strtoupper($rowarr['stud_category'])],
                    "class_id" => $classes[strtoupper($rowarr['class_id'])],
                    "section_id" => $rowarr['section_id'],
                    "phone" => $rowarr['phone'],
                    "email_address" => $rowarr['email_address'],
                    "father_name" => $rowarr['father_name'],
                    "dob" => date('Y-m-d', strtotime($rowarr['dob'])),
                    "gender" => $rowarr['gender'],
                    "course_id" => $course,
                    "transport_amt" => !empty($rowarr['transport_amt']) ? $rowarr['transport_amt'] : 0,
                    "fine_waiver" => !empty($rowarr['fine_waiver']) ? strtoupper($rowarr['fine_waiver']) : 'NO',
                    "admission_date" => date('Y-m-d', strtotime(str_replace('/', '-', $rowarr['admission_date']))),
                    "mother_name" => $rowarr['mother_name'],
                    "student_aadhar" => $rowarr['student_aadhar'],
                    "father_aadhar" => $rowarr['father_aadhar'],
                    "mother_aadhar" => $rowarr['mother_aadhar'],
                    "father_phone" => $rowarr['father_phone'],
                    "mother_phone" => $rowarr['mother_phone'],
                    "guardian_name" => $rowarr['guardian_name'],
                    "guardian_aadhar" => $rowarr['guardian_aadhar'],
                    "guardian_phone" => $rowarr['guardian_phone'],
                    "address" => $rowarr['address'],
                    "roll" => $rowarr['roll'],
                    "ppoint_id" => $ppoint_id,
                    "transport_id" => $transport_id,
                    "student_type" => $student_type,
                    "start_fee_month" => $start_fee_month,
                    "first_class" => $rowarr['first_class'],
                    "student_academicyear_id" => $this->input->post('academic_session'),
                    "religion" => $rowarr['religion'],
                    "caste" => $rowarr['caste'],

                    // "student_academicyear_id" => $this->academic_session[0]->fin_year,
                    "created_by" => $this->session->userdata('user_id'),
                );
//code for dual permission goes here
                if (count($this->dualpermission) > 0) {

                    $data_student['status'] = 'P';
                }
//code for dual permission end here
                $this->db->insert('student', $this->security->xss_clean($data_student));
                $student_id = $this->db->insert_id();

                $admission_nos[$rowarr['admission_no']] = TRUE;

                if ($this->school_desc[0]->pwd_generation == 'AUTO') { //chinmaya //lfs
                    $hashoptions = array(); // No options currently, but, we could add in future
                    if ($rowarr['phone'] == '') {
                        $phn = '9876543210';
                    } else {
                        $phn = $rowarr['phone'];
                    }
                    $pwhash = password_hash($phn, PASSWORD_DEFAULT, $hashoptions); // Generate new hash

                    $data_user = array(
                        "user_name" => $this->school_code . '-' . $rowarr['admission_no'],
                        "pw_hash" => $pwhash,
                        "user_group_id" => 4,
                        "student_id" => $student_id,
                        "change_password" => 0,
                        'created_by' => $this->session->userdata('user_id'),
                        "contact_no" => $phn,
                        "email" => $rowarr['email_address'],
                    );
                    $this->dbconnection->insert("user", $data_user);
                    $this->dbconnection->update("student", array('registered_status' => 1), array('id' => $student_id));
                }

//LEDGER ENTRY//

                $field = array(
                    'ledger_code' => $student_id,
                    'ledger_name' => $rowarr['first_name'] . ' ' . $rowarr['middle_name'] . ' ' . $rowarr['last_name'],
                    'under_group' => 21,
                    'email' => $rowarr['email_address'],
                    'phone' => $rowarr['phone'],
                    'address' => $rowarr['address'],
                    'city' => '',
                    'state' => '',
                    'zip_code' => '',
                    'uid_no' => $rowarr['student_aadhar'],
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
//	print_r($field);
                $this->dbconnection->insert('ledger', $field);
                $ledgerid = $this->dbconnection->get_last_id();
                $this->dbconnection->update("student", array('student_ledger_id' => $ledgerid), array('id' => $student_id));
//LEDGER ENTRY END//


                $this->dbconnection->update("student", array('registered_status' => 1), array('id' => $student_id));




//transport allocation entry
                if (!empty($ppoint_id) && !empty($transport_id)) {
                    $trans_data = array(
                        'pickup_point' => $ppoint_id,
                        'student' => $student_id,
                        'transport_id' => $transport_id,
                        'date_created' => date('Y-m-d'),
                        'created_by' => $this->session->userdata('user_id'),
                    );
                    $this->dbconnection->insert('transport_allocation', $trans_data);
                }

                if (!empty($cats[strtoupper($rowarr['stud_category'])])) {
                    $this->dbconnection->insert('transport_feecategory_monthly_log', array(
                        'student_id' => $student_id,
                        'change_name' => 'stud_category',
                        'year' => $this->academic_session[0]->fin_year,
                        'apr' => $cats[strtoupper($rowarr['stud_category'])],
                        'may' => $cats[strtoupper($rowarr['stud_category'])],
                        'jun' => $cats[strtoupper($rowarr['stud_category'])],
                        'jul' => $cats[strtoupper($rowarr['stud_category'])],
                        'aug' => $cats[strtoupper($rowarr['stud_category'])],
                        'sep' => $cats[strtoupper($rowarr['stud_category'])],
                        'oct' => $cats[strtoupper($rowarr['stud_category'])],
                        'nov' => $cats[strtoupper($rowarr['stud_category'])],
                        'dec' => $cats[strtoupper($rowarr['stud_category'])],
                        'jan' => $cats[strtoupper($rowarr['stud_category'])],
                        'feb' => $cats[strtoupper($rowarr['stud_category'])],
                        'mar' => $cats[strtoupper($rowarr['stud_category'])],
                        'created_by' => $this->session->userdata('user_id'),
                        'ip_address' => $this->input->ip_address()));
                }

                if (!empty($rowarr['transport_amt'])) {

                    switch ($this->session->userdata('school_id')) {
                        case 29: //june
                            $apr = $may = $jul = $aug = $sep = $oct = $nov = $dec = $jan = $feb = $mar = $rowarr['transport_amt'];
                            $jun = '0';
                            break;
                        case 24: //june
                            $apr = $may = $jul = $aug = $sep = $oct = $nov = $dec = $jan = $feb = $mar = $rowarr['transport_amt'];
                            $jun = '0';
                            break;
                        case 25:// may
                            $apr = $jun = $jul = $aug = $sep = $oct = $nov = $dec = $jan = $feb = $mar = $rowarr['transport_amt'];
                            $may = '0';
                            break;
                        default:
                            $apr = $may = $jun = $jul = $aug = $sep = $oct = $nov = $dec = $jan = $feb = $mar = $rowarr['transport_amt'];
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

                $audit = array("action" => 'Upload Student Information',
                    "module" => "Admission Module",
                    'datetime' => date("Y-m-d H:i:s"),
                    'userid' => $this->session->userdata('user_id'),
                    'student_id' => $student_id,
                    'page' => 'School',
                    'remarks' => ''
                );
                $this->dbconnection->insert("auditntrail", $audit);
//                                }
//                            }else {/*------------  end of checking duplicate data in csv file   -------------*/
//                                
//                            }
            }
        }
        $this->index();
    }

    public function bulk_update() {

        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }

        if (!$this->session->flashdata('bulkupdate')) {
            $this->data['errors'] = array();
// Cache Admission Numbers
            $this->db->select('admission_no,transport_amt,stud_category');
            $query = $this->db->get('student');
            $admission_nos = array_column($query->result_array(), NULL, 'admission_no');
            $transport_amt = array_column($query->result_array(), 'transport_amt', 'admission_no');
            $stud_category = array_column($query->result_array(), 'stud_category', 'admission_no');

// Cache Classes
            $this->db->select('id, class_code');
            $this->db->where('status="Y"');
            $query = $this->db->get('class');
            $classes = array_change_key_case(array_column($query->result_array(), 'id', 'class_code'), CASE_UPPER);

// Cache Categories
            $this->db->select('id, cat_code');
            $this->db->where('status="Y"');
            $query = $this->db->get('category');
            $cats = array_change_key_case(array_column($query->result_array(), 'id', 'cat_code'), CASE_UPPER);

// Cache Courses
            $this->db->select('id, course_code');
            $this->db->where('status="Y"');
            $query = $this->db->get('course');
            $courses = array_change_key_case(array_column($query->result_array(), 'id', 'course_code'), CASE_UPPER);


// Cache Pickup Points
            $this->db->select('id, REPLACE(location_description, " ", "") location_description');
            $query = $this->db->get('locations');
            $locations = array_change_key_case(array_column($query->result_array(), 'id', 'location_description'), CASE_UPPER);

// Cache Vehicle No
            $this->db->select('id, REPLACE(vehicle_no, " ", "") vehicle_no');
            $this->db->where('status=1');
            $query = $this->db->get('vehicle');
            $vehicle_no = array_change_key_case(array_column($query->result_array(), 'id', 'vehicle_no'), CASE_UPPER);

//                print_r($vehicle_no);
            if (!empty($_FILES['admission_upload']['tmp_name'])) {

                $admsn_no_file = array();
                $handle = fopen($_FILES['admission_upload']['tmp_name'], "r");
                fgetcsv($handle); // Read and discard header row
                while (($row = fgetcsv($handle, 10000, ",")) !== FALSE) {
                    $rowarr = array();
                    $data_student = array();
                    foreach ($row as $pos => $value) {


//                                        if($pos!=13 || $pos!=14 || $pos!=15){
                        if ($pos < 13) {
                            if (!isset($this->admission_csv_columns[$pos]))
                                continue;
                        }
                        $rowarr[$this->admission_csv_columns[$pos]['field']] = trim($value);
                    }
                    /* ------ checking duplicate admission number in csv file  -------- */
                    if (in_array($rowarr['admission_no'], $admsn_no_file)) {
                        $this->data['errors'][] = "Admission Number '" . $rowarr['admission_no'] . "' previously present in this file, skipping...";
                        continue;
                    }

                    $admsn_no_file[] = $rowarr['admission_no'];
                    if (!isset($admission_nos[$rowarr['admission_no']])) {
                        $this->data['errors'][] = "Admission Number '" . $rowarr['admission_no'] . "' is not already present, skipping...";
                        continue;
                    }


                    if (!empty($rowarr['stud_category']) && !isset($cats[strtoupper($rowarr['stud_category'])])) {
                        $this->data['errors'][] = "Admission Number '" . $rowarr['admission_no'] . "' has undefined category of '" . $rowarr['stud_category'] . "', skipping...";
                        continue;
                    }

                    if (!empty($rowarr['class_id']) && !isset($classes[strtoupper($rowarr['class_id'])])) {
                        $this->data['errors'][] = "Admission Number '" . $rowarr['admission_no'] . "' has undefined class of '" . $rowarr['class_id'] . "', skipping...";
                        continue;
                    }

                    if (!empty($rowarr['course_id']) && !isset($courses[strtoupper($rowarr['course_id'])])) {
                        $this->data['errors'][] = "Admission Number '" . $rowarr['admission_no'] . "' has undefined course of '" . $rowarr['course_id'] . "', skipping...";
                        continue;
                    }
//                                    $course=$courses[$rowarr['course_id']];
                    if (!empty($rowarr['admission_date']) && date('Y', strtotime(str_replace('/', '-', $rowarr['admission_date']))) == 1970) {
                        $this->data['errors'][] = "Line $linerow: Admission Number '" . $data[0] . "' contains Admission date Invalid, skipping...";
                        continue;
                    }

                    $ppoint_id = 0;
                    if (!empty($rowarr['ppoint_id'])) {
                        if (!isset($locations[strtoupper(str_replace(' ', '', $rowarr['ppoint_id']))])) {
                            $this->data['errors'][] = "Line $linerow: Admission Number '" . $data[0] . "' contains Undefined Locations, skipping...";
                            continue;
                        }
                        $ppoint_id = $locations[strtoupper(str_replace(' ', '', $rowarr['ppoint_id']))];
                    }

                    $transport_id = 0;
                    if (!empty($rowarr['transport_id'])) {
                        if (!isset($vehicle_no[strtoupper(str_replace(' ', '', $rowarr['transport_id']))])) {

                            $this->data['errors'][] = "Line $linerow: Admission Number '" . $data[0] . "' contains Undefined Vehicle No, skipping...";
                            continue;
                        }
                        $transport_id = $vehicle_no[strtoupper(str_replace(' ', '', $rowarr['transport_id']))] . '<br>';
                    }




                    foreach ($rowarr as $index => $value) {

                        if (!empty($value)) {
                            if ($index == 'stud_category') {
                                $data_student[$index] = $cats[strtoupper($value)];
                            } else if ($index == 'first_name') {
                                $data_student[$index] = $value;
                                $data_student['middle_name'] = '';
                                $data_student['last_name'] = '';
                            } else if ($index == 'class_id') {
                                $data_student[$index] = $classes[strtoupper($value)];
                            } else if ($index == 'course_id') {
                                $data_student[$index] = $courses[strtoupper($value)];
                            } else if ($index == 'dob') {
                                $data_student[$index] = date('Y-m-d', strtotime(str_replace('/', '-', $rowarr['dob'])));
                            } else if ($index == 'admission_date') {
                                $data_student[$index] = date('Y-m-d', strtotime(str_replace('/', '-', $rowarr['admission_date'])));
                            } else if ($index == 'ppoint_id') {
                                $data_student[$index] = $ppoint_id;
                            } else if ($index == 'transport_id') {
                                $data_student[$index] = $transport_id;
                            } else {
                                $data_student[$index] = $value;
                            }
                        }elseif($index=='transport_amt' && $value==0) {
                            $data_student['transport_amt'] = 0;
                        }
                    }

                    $student_id = $this->dbconnection->Get_namme('student', 'admission_no', $rowarr['admission_no'], 'id');
                    $data_student['last_date_modified'] = date('Y-m-d H:i:s');
                    $data_student['last_modified_by'] = $this->session->userdata('user_id');
//                                $data_student['student_academicyear_id']=$this->academic_session[0]->fin_year;
                    $this->dbconnection->update("student", $data_student, array('id' => $student_id));

                    $arrmon = array(1 => "apr", 2 => "may", 3 => "jun", 4 => "jul", 5 => "aug", 6 => "sep", 7 => "oct", 8 => "nov", 9 => "dec", 10 => "jan", 11 => "feb", 12 => "mar");
                    $start = array_search(lcfirst(date('M')), $arrmon);
                    $end = 12;
                    $array_trans = array();
                    $array_feecat = array();
                    for ($s = $start; $s <= $end; $s++) {
                        $array_trans["$arrmon[$s]"] = !empty($rowarr['transport_amt']) ? $rowarr['transport_amt'] :0;
                  
                        $array_feecat["$arrmon[$s]"] = !empty($rowarr['stud_category'])? $cats[strtoupper($rowarr['stud_category'])] :0;
                        
                    }
                    if (!empty($rowarr['stud_category']) && $stud_category[$rowarr['admission_no']] != $rowarr['stud_category']) {
                        $this->dbconnection->insert('changes_fee_auditntrail', array(
                            'student_id' => $student_id,
                            'change_name' => 'stud_category',
                            'tbl_name' => 'student',
                            'field_name' => 'stud_category',
                            'old_value' => $stud_category[$rowarr['admission_no']],
                            'new_value' => $cats[strtoupper($rowarr['stud_category'])],
                            'userid' => $this->session->userdata('user_id'),
                            'ip_address' => $this->input->ip_address()));

                        $array_feecat['date_modified'] = date('Y-m-d H:i:s');
                        $array_feecat['modified_by'] = $this->session->userdata('user_id');
                        $array_feecat['ip_address'] = $this->input->ip_address();

                        $this->dbconnection->update('transport_feecategory_monthly_log', $array_feecat, "student_id=$student_id and year={$this->academic_session[0]->fin_year} and change_name='stud_category'");
                    }

                    if (!empty($rowarr['transport_amt']) && $transport_amt[$rowarr['admission_no']] != $rowarr['transport_amt']) {
                        $this->dbconnection->insert('changes_fee_auditntrail', array(
                            'student_id' => $student_id,
                            'change_name' => 'transport_amt',
                            'tbl_name' => 'student',
                            'field_name' => 'transport_amt',
                            'old_value' => $transport_amt[$rowarr['admission_no']],
                            'new_value' => $rowarr['transport_amt'],
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
                        $this->dbconnection->update('transport_feecategory_monthly_log', $array_trans, "student_id=$student_id and year={$this->academic_session[0]->fin_year} and change_name='transport_amt'");
                    }

                    if (!empty($rowarr['ppoint_id']) && !empty($rowarr['transport_id'])) {
                        $trans_updata = array(
                            'pickup_point' => $ppoint_id,
                            'transport_id' => $transport_id,
                            'last_date_modified' => date('Y-m-d'),
                            'last_modified_by' => $this->session->userdata('user_id'),
                        );
                        $this->dbconnection->update('transport_allocation', $trans_updata, 'student="' . $student_id . '"');
                    }

                    if($this->session->userdata('school_id')==35)
                    {
            
                        if(!empty($rowarr['admission_no'])) {
                        
                            $hashoptions = array(); // No options currently, but, we could add in future
                            $pwhash = password_hash($rowarr['admission_no'], PASSWORD_DEFAULT, $hashoptions); // Generate new hash
                            $this->load->library('Randomno');
                            $salt = $this->randomno->generateRandomString();
                            $password = md5($rowarr['admission_no'] . $salt);

                            $datau = array(
                                'password' => $password,
                                'pw_hash' => $pwhash,
                                'salt' => $salt,
                                'encrypt_id' => 2,
                                'change_password' => 1,
                                'contact_no' => $rowarr['phone'],
                                'last_date_modified' => date('Y-m-d H:i:s'),
                                'last_modified_by' => $this->session->userdata('user_id'),
                            );
                            $this->dbconnection->update('user', $datau, 'student_id ="' . $student_id . '"');
                        }
                    }
                    else
                    {
                        if(!empty($rowarr['phone'])) {
                        
                            $hashoptions = array(); // No options currently, but, we could add in future
                            $pwhash = password_hash($rowarr['phone'], PASSWORD_DEFAULT, $hashoptions); // Generate new hash
                            $this->load->library('Randomno');
                            $salt = $this->randomno->generateRandomString();
                            $password = md5($rowarr['phone'] . $salt);

                            $datau = array(
                                'password' => $password,
                                'pw_hash' => $pwhash,
                                'salt' => $salt,
                                'encrypt_id' => 2,
                                'change_password' => 1,
                                'contact_no' => $rowarr['phone'],
                                'last_date_modified' => date('Y-m-d H:i:s'),
                                'last_modified_by' => $this->session->userdata('user_id'),
                            );
                            $this->dbconnection->update('user', $datau, 'student_id ="' . $student_id . '"');
                        }
                    }

                    
                    

                    $audit = array("action" => 'Bulk Update Student Information',
                        "module" => "Admission Module",
                        'datetime' => date("Y-m-d H:i:s"),
                        'userid' => $this->session->userdata('user_id'),
                        'student_id' => $student_id,
                        'page' => 'Upload_students',
                        'remarks' => ''
                    );
                    $this->dbconnection->insert("auditntrail", $audit);
//                                }
//                            }else {/*------------  end of checking duplicate data in csv file   -------------*/
//                                
                }
            }
            if (empty($this->data['errors'])) {
                $this->session->set_flashdata('bulkupdate', 'Successfully Updated !');
            } else {
                $this->session->set_flashdata('bulkupdate', 'File has some error !');
            }
            $this->index();
        } else {
            redirect(base_url('/admission/upload_students'), 'refresh');
        }
    }

    public function download_format() {
        $this->load->helper('download');
        $fh = fopen('php://memory', 'w');
        fputcsv($fh, array_column($this->admission_csv_columns, 'human_name'));
        fseek($fh, 0);
        $csv = stream_get_contents($fh);
        $school_code=$this->session->userdata('school_code');
        force_download('FCLB-'.$school_code.'-Admission-Format.csv', $csv);
    }

}
