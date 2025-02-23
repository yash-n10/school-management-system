<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_school extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (empty($this->session->userdata('user_id')) || $this->session->userdata('user_group_id')!=1) {
            redirect('/login');
        }

        $this->id = $this->session->userdata('school_id');
//                if ($this->id != 0) $this->db->db_select('crmfeesclub_'.$this->id);
        $this->load->library('encrypt');
        $this->page_title = 'Schools Creation';
        $this->section = 'admin_school';
        $this->page_name = 'index';
        $this->customview = '';
    }
    public function send_msg() {
      
//        $auth_key = '45282AuBnr8Ci6t52746bc3'; //autherization key of api.
//        $sender_id = 'djncom';
        
        $url="http:sms.bulksmsind.in/sendSMS?username=mildrix&message=hishammiphp&sendername=MILDRX&smstype=TRANS&numbers=8877284322&apikey=d4c88a1f-4dc5-445f-8c19-165b6a4c8465";
//        $ch = curl_init($url);
//        curl_setopt($ch, CURLOPT_POST, True);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        print_r($result);
        curl_close($ch);
    }

    public function index() {
//		$this->data['page']= 'school';
        $this->data['page_name'] = $this->page_name;
        $this->data['page_title'] = $this->page_title;
        $this->data['section'] = $this->section;
        $this->data['customview'] = $this->customview;
        $this->data['schools'] = $this->dbconnection->select('school', '*,(select state_name from states where id=state_id) as state_name');
        $this->data['country'] = $this->dbconnection->select('countries', '*');

//		$this->data['cities'] = $this->dbconnection->select('cities','*');
        $cities = $this->db->query('select * from cities order by city_name');
        $this->data['cities'] = $cities->result();
        $this->data['states'] = $this->dbconnection->select('states', '*');
        $this->data['pymt_gw'] = $this->dbconnection->select('payment_gateway_list', '*');
//$this->data['user_groups']= $this->dbconnection->select('user_group','*');;
//$this->data['users']= $this->dbconnection->select('user','*');;
        $this->load->view('index', $this->data);
    }

    public function select_country() {
        $states = $this->dbconnection->select('states', '*', "country_id = '" . $_POST['country_id'] . "'");
        $return = '';
        $return .= '<label style="font-weight: 600">State</label>';

        $return .= '<select class="form-control" id="school_state" name="school_state" onchange="select_state()">';
        $return .= "<option value=''>Select</option>";
        foreach ($states as $obj_states) {
            $return .= "<option value='" . $obj_states->id . "'>" . $obj_states->state_name . "</option>";
        }
        $return .= '</select>';

        echo $return;
    }

    
    public function select_state() {
        $cities = $this->dbconnection->select('cities', '*', "city_state = '" . $_POST['state'] . "'");
        $return = '';
        $return .= '<label style="font-weight: 600">City</label>';

        $return .= '<select class="form-control" id="school_city" name="school_city" onchange="select_city()">';
        $return .= "<option value=''>Select</option>";
        foreach ($cities as $obj_cities) {
            $return .= "<option value='" . $obj_cities->id . "'>" . $obj_cities->city_name . "</option>";
        }
        $return .= '</select>';

        echo $return;
    }

    public function addedit_schview() {

        $this->data['page_name'] = 'addedit_schview';       
        $this->data['section'] = $this->section;
        $this->data['customview'] = $this->customview;
        $this->data['country'] = $this->dbconnection->select('countries', '*');
        $cities = $this->db->query('select * from cities order by city_name');
        $this->data['cities'] = $cities->result();
        $this->data['states'] = $this->dbconnection->select('states', '*');
        $this->data['pymt_gw'] = $this->dbconnection->select('payment_gateway_list', '*');
        $this->data['modules'] = $this->dbconnection->select('module', '*','id>2');
        $this->data['sch_group'] = $this->dbconnection->select('school_groups', '*','');
        
        
        
        if(empty($this->uri->segment(3))) { //add school
            
            $this->data['page_title'] = 'Add School';
            $this->data['task'] = 'Save';
            $this->data['action_url'] = 'admin_school/save_school' ;
            
            $this->data['school_name']='';
            $this->data['school_code']='';
            $this->data['vision']='';
            $this->data['selected_country']='';
            $this->data['selected_state']='';
            $this->data['selected_city']='';
            $this->data['contact_no']='';
            $this->data['email_addr']='';
            $this->data['sch_addr']='';
            $this->data['fee_type1']='';
            $this->data['fee_type2']='';
            $this->data['start_pay_day']='';
            $this->data['last_pay_day']='';
            $this->data['fine_type_checkbox']='';
            $this->data['trans_freeze_status']='';
            $this->data['fine_monthly_segregation']='';
            $this->data['annual_last_month']='0';
            $this->data['selected_pw_gw']='';
            $this->data['stop_trans']='NO';
            $this->data['pgw_mid']='';
            $this->data['pgw_enc_key']='';
            $this->data['pgw_access_code']='';
            $this->data['test_live_mode']='';
            $this->data['sch_modules']=array();
            $this->data['pwd_gen']='';
            $this->data['trans_fee_status']='';
            $this->data['school_status']='';
            $this->data['start_report_date']=date('Y-m-d');
            $this->data['school_group']='';
            $this->data['sms_integration']='';
            $this->data['send_sms']='';
    
                
          
            
        }else { // edit school
            
            $this->data['page_title'] = 'Edit School';
            $this->data['task'] = 'Update';
            $this->data['action_url'] = "admin_school/update_school/".$this->uri->segment(3);
            $schools = $this->dbconnection->select('school', '*,(select state_name from states where id=state_id) as state_name',"id=".$this->uri->segment(3));
            
            $this->data['school_name']=$schools[0]->description;
            $this->data['school_code']=$schools[0]->school_code;
            $this->data['vision']=$schools[0]->vision;
            $this->data['selected_country']=$schools[0]->country_id;
            $this->data['selected_state']=$schools[0]->state_id;
            $this->data['selected_city']=$schools[0]->city_id;
            $this->data['contact_no']=$schools[0]->phone;
            $this->data['email_addr']=$schools[0]->email;
            $this->data['sch_addr']=$schools[0]->address;
            $this->data['fee_type1']=$schools[0]->fee_type1;
            $this->data['fee_type2']=$schools[0]->fee_type2;
            $this->data['start_pay_day']=$schools[0]->start_pay_date;
            $this->data['last_pay_day']=$schools[0]->last_pay_date;
            $this->data['fine_type_checkbox']=$schools[0]->fine_type_checkbox;
            $this->data['trans_freeze_status']=$schools[0]->transc_freeze_status;
            $this->data['fine_monthly_segregation']=$schools[0]->fine_monthly_segregation;
            $this->data['annual_last_month']=$schools[0]->annual_month;
            $this->data['selected_pw_gw']=$schools[0]->payment_gateway;
            $this->data['stop_trans']=$schools[0]->stop_transaction;
            $this->data['pgw_mid']=$schools[0]->pgw_mid;
            $this->data['pgw_enc_key']=$schools[0]->pgw_enckey;
            $this->data['pgw_access_code']=$schools[0]->pgw_access_code;
            $this->data['test_live_mode']=$schools[0]->test_live_mode;
            $this->data['sch_modules']=$this->dbconnection->select("school_modules","modules","school_id=".$this->uri->segment(3)." and status='Y'");
            $this->data['pwd_gen']=$schools[0]->pwd_generation;
            $this->data['trans_fee_status']=$schools[0]->transport_fee;
            $this->data['school_status']=$schools[0]->status;
            $this->data['start_report_date']=$schools[0]->start_report_date;
            $this->data['school_group']=$schools[0]->school_group;
            $this->data['selected_school_group']=$schools[0]->school_group;
            $this->data['onetime']=$schools[0]->onetime;
            $this->data['admsn_in_between']=$schools[0]->admsn_in_between;
            $this->data['sms_integration']=$schools[0]->sms_integration;
            $this->data['send_sms']=$schools[0]->send_sms;


        }
        

        $this->load->view('index', $this->data);
    }

    
    public function save_school() {


        $data = array(
            'description' => $this->input->post('school_name'),
            'school_code' => $this->input->post('school_code'),
            'vision' => $this->input->post('vision'),
            'status' => $this->input->post('school_status'),
            'address' => $this->input->post('school_address'),
            'city_id' => $this->input->post('school_city'),
            'state_id' => $this->input->post('school_state'),
            'phone' => $this->input->post('contact_no'),
            'email' => $this->input->post('email_address'),
            'country_id' => $this->input->post('country'),
            'fee_type1' => $this->input->post('optradio1'),
            'fee_type2' => $this->input->post('optradio2'),
            'onetime' => $this->input->post('optradio3'),
            'start_pay_date' => $this->input->post('start_pay_date'),
            'last_pay_date' => $this->input->post('last_pay_date'),
            'fine_type_checkbox' => $this->input->post('fine_type_checkbox'),
            'transc_freeze_status' => $this->input->post('trans_freeze_status'),
            'fine_monthly_segregation' => $this->input->post('fine_monthly_segregation'),
            'annual_month' => $this->input->post('annual_month'),
            'payment_gateway' => $this->input->post('pymt_gateway'),
            'pgw_mid' => $this->input->post('mid'),
            'pgw_enckey' => $this->input->post('enckey'),
            'pgw_access_code' => $this->input->post('pgw_access_code'),
            'test_live_mode' => $this->input->post('test_live_mode'),
            'stop_transaction' => $this->input->post('stop_transaction'),
            'start_report_date' => $this->input->post('start_report_date'),
            'school_group' => $this->input->post('school_group'),
            'pwd_generation' => $this->input->post('pwd_generation'),
            'transport_fee' => $this->input->post('transport_fee'),
            'created_by' => $this->session->userdata('user_id'),
            'admsn_in_between' =>  $this->input->post('adm_btw'),
            'sms_integration' => $this->input->post('sms_integration'),
            'send_sms' => $this->input->post('send_sms'),
        );

        $school = $this->dbconnection->insert('school', $data);
        $school_id = $this->db->insert_id();
        
        $dbcreate='';
        $input_all=$this->input->post();
        if($school) {
            if(!empty($input_all['module_privl'])) {
                foreach($input_all['module_privl'] as $k=>$v)
                {
                    $this->dbconnection->insert('school_modules',array('school_id'=>$school_id,'modules'=>$v,'module_id'=>$k,'created_by' => $this->session->userdata('user_id')) );
                }
            }
            
            if($this->input->post('school_status')=='1') {
                $dbcreate=$this->dbconnection->dbcreate('crmfeesclub_'.$school_id,'crmfeesclub_0');
//                if($dbcreate!='') {
//                    
//                    $modules_id= array_column($this->db->query("SELECT m.id FROM crmfeesclub.module m inner join crmfeesclub.school_modules n on m.m_code=n.modules where n.status='Y' and n.school_id=$id")->result_array(),'id');
//                    $this->db->query("INSERT INTO crmfeesclub_$id.user_group_permission SELECT * FROM crmfeesclub.user_group_permission where link_code in ( select id from crmfeesclub.link_page where module_id in (".implode(",", $modules_id)."))");
//                }
            }
        }
        
//Audit Trail
        $audit = array("action" => "Add School of school id $school_id and $dbcreate" ,
            "module" => "Admin School Module",
            'datetime' => date("Y-m-d H:i:s"),
            'userid' => $this->session->userdata('user_id'),
            'student_id' => 0,
            'page' => 'Admin School',
            'remarks' => ''
        );
        $this->dbconnection->insert("auditntrail", $audit);

//        echo "<script>alert('Successfully school added and '..')  ; window.location.href='".base_url('settings/users')."';</script>";
        header("Location: " . site_url("admin_school"));
    }

    public function update_school($id) {


        $data = array(
            'description' => $this->input->post('school_name'),
            'school_code' => $this->input->post('school_code'),
            'vision' => $this->input->post('vision'),
            'status' => $this->input->post('school_status'),
            'address' => $this->input->post('school_address'),
            'city_id' => $this->input->post('school_city'),
            'state_id' => $this->input->post('school_state'),
            'phone' => $this->input->post('contact_no'),
            'email' => $this->input->post('email_address'),
            'country_id' => $this->input->post('country'),
            'fee_type1' => $this->input->post('optradio1'),
            'fee_type2' => $this->input->post('optradio2'),
            'onetime' => $this->input->post('optradio3'),
            'start_pay_date' => $this->input->post('start_pay_date'),
            'last_pay_date' => $this->input->post('last_pay_date'),
            'fine_type_checkbox' => $this->input->post('fine_type_checkbox'),
            'transc_freeze_status' => $this->input->post('trans_freeze_status'),
            'fine_monthly_segregation' => $this->input->post('fine_monthly_segregation'),
            'annual_month' => $this->input->post('annual_month'),
            'payment_gateway' => $this->input->post('pymt_gateway'),
            'pgw_mid' => $this->input->post('mid'),
            'pgw_enckey' => $this->input->post('enckey'),
            'pgw_access_code' => $this->input->post('pgw_access_code'),
            'test_live_mode' => $this->input->post('test_live_mode'),
            'stop_transaction' => $this->input->post('stop_transaction'),
            'start_report_date' => $this->input->post('start_report_date'),
            'school_group' => $this->input->post('school_group'),
            'pwd_generation' => $this->input->post('pwd_generation'),
            'transport_fee' => $this->input->post('transport_fee'),
            'last_modified_by' => $this->session->userdata('user_id'),
            'last_date_modified'=>date('Y-m-d H:i:s'),
             'admsn_in_between' => $this->input->post('adm_btw'),
            'sms_integration' => $this->input->post('sms_integration'),
            'send_sms' => $this->input->post('send_sms'),
        );

        $school = $this->dbconnection->update('school', $data,"id=$id");
 
        
        $input_all=$this->input->post();
        $dbcreate='';
        if($school) {
            if(!empty($input_all['module_privl'])) {
                $this->dbconnection->update('school_modules', array("status"=>'N',"date_modified"=>date('Y-m-d H:i:s'),'modified_by' => $this->session->userdata('user_id')),"school_id=$id");
                foreach($input_all['module_privl'] as $k=>$v)
                {
                    $this->dbconnection->insert('school_modules',array('school_id'=>$id,'modules'=>$v,'module_id'=>$k,'created_by' => $this->session->userdata('user_id')) );
                }
            }
            
            if($this->input->post('school_status')=='1') {
                $dbcreate=$this->dbconnection->dbcreate('crmfeesclub_'.$id,'crmfeesclub_0');
                
//                if($dbcreate!='') {
//                    
//
//                    $modules_id= array_column($this->db->query("SELECT m.id FROM crmfeesclub.module m inner join crmfeesclub.school_modules n on m.m_code=n.modules where n.status='Y' and n.school_id=$id")->result_array(),'id');
//                    $this->db->query("INSERT INTO crmfeesclub_$id.user_group_permission SELECT * FROM crmfeesclub.user_group_permission where link_code in ( select id from crmfeesclub.link_page where module_id in (".implode(",", $modules_id)."))");
//                }
                
            }
        }
//Audit Trail
        $audit = array("action" => 'Update School of school id '.$id.' and '.$dbcreate,
            "module" => "Admin School Module",
            'datetime' => date("Y-m-d H:i:s"),
            'userid' => $this->session->userdata('user_id'),
            'student_id' => 0,
            'page' => 'Admin School',
            'remarks' => ''
        );
        $this->dbconnection->insert("auditntrail", $audit);

        echo "<script>alert('Successfully Updated')  ; window.location.href='".base_url('admin_school')."';</script>";

    }

    public function delete_school() {
        $school_id = $this->encrypt->decode($_POST['delete_school_id']);
        $school = $this->dbconnection->delete('school', 'id =' . $school_id);

        $this->dbconnection->delete('user', 'school_id =' . $school_id);
        $this->dbconnection->delete('accedemic_session', 'school_id =' . $school_id);
        $this->dbconnection->delete('category', 'school_id =' . $school_id);
        $this->dbconnection->delete('class', 'school_id =' . $school_id);
        $class_fee_head = $this->dbconnection->select('class_fee_head', 'id', 'school_id =' . $school_id);
        $this->dbconnection->delete('class_fee_head', 'school_id =' . $school_id);



        foreach ($class_fee_head as $key) {
            $this->dbconnection->delete('class_fee_det', 'class_fee_head_id =' . $key->id);
        }

        $student_id = $this->dbconnection->select('student', 'id', "school_id =" . $school_id);
        $this->dbconnection->delete('collection_center', 'school_id =' . $school_id);
        $this->dbconnection->delete('course', 'school_id =' . $school_id);
        $this->dbconnection->delete('fee_master', 'school_id =' . $school_id);
        $this->dbconnection->delete('fee_trans_det', 'school_id =' . $school_id);
        $this->dbconnection->delete('receipt_log', 'school_id =' . $school_id);
        $this->dbconnection->delete('section', 'school_id =' . $school_id);
        $this->dbconnection->delete('student', 'school_id =' . $school_id);

        $this->dbconnection->delete('auditntrail', 'school_id =' . $school_id);


//Audit Trail
        $audit = array("action" => 'Delete School',
            "module" => "Admin School Module",
            'datetime' => date("Y-m-d H:i:s"),
            'userid' => $this->session->userdata('user_id'),
            'school_id' => 0,
            'student_id' => 0,
            'page' => 'User',
            'remarks' => ''
        );
        $this->dbconnection->insert("auditntrail", $audit);

        header("Location: " . site_url("admin_school"));
    }

    public function check_email() {
        $cities = $this->dbconnection->select('school', 'count(*) as school_count', "email = '" . $_POST['email_address'] . "'");
        echo $cities[0]->school_count;
    }

    public function generateRandomString($length = 25) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }



}
