<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sms_Notification extends CI_Controller {

    public function __construct() {
       error_reporting(-1);
       ini_set('display_errors', 1);
        // $this->db->db_debug=TRUE;
       $this->page_code = 'sms_notification';
       parent::__construct();

       $this->id = $this->session->userdata('school_id');
       if ($this->id != 0) {
        $this->db->db_select('crmfeesclub_' . $this->id);
    }
    $this->section = 'communication';
    $this->dbtable = 'sms_notification';
    $this->page_name='sms_notification';
    $this->customview='';
}

public function index() {
    error_reporting(-1);
    ini_set('display_errors', 1);
    $this->db->db_debug=TRUE;
    $page_data['page_name'] = $this->page_name;
    $page_data['page_title'] = 'Sms Notification';
    $page_data['section'] = $this->section;
    $page_data['customview'] = $this->customview;
    if ($this->id != 0) {
        $str="id!=1 and id!=4";
        $page_data['link'] = $this->db->query("SELECT * FROM crmfeesclub.link_page lp "
            . "where  (lp.module_id=1 or lp.module_id in (select module_id from crmfeesclub.school_modules where school_id=$this->id and status='Y'))  and (lp.link_status='' or lp.link_status is null) order by grand_node,priority")->result();
    }else{
        $str='';
        $page_data['link'] = $this->db->query("SELECT * from crmfeesclub.link_page where link_status='' or link_status='NULL' or link_status is null order by grand_node,priority")->result();
    }
    $page_data['group'] = $this->dbconnection->select("user_group", "*", "$str");
    $page_data['sms_notification']    = $this->dbconnection->select('sms_notification', '*', "");
    $page_data['sms_type_master']    = $this->dbconnection->select('sms_type_master', '*', "");
    $this->load->view('index', $page_data);
}

public function save()
{
    foreach ($this->input->post('page') as  $key => $value) {
        $sms = !empty($this->input->post('SY')[$key]) ? $this->input->post('SY')[$key] : '';
        $mail = !empty($this->input->post('MY')[$key]) ? $this->input->post('MY')[$key] : '';
        $val = array(
            'link_code' => $this->input->post('page')[$key],
            'activity' => $this->input->post('activity')[$key],
            'sms' => $sms,
            'mail' => $mail,
            'sms_mode' => $this->input->post('mode')[$key],
            'status' => 'Y',
            'date_created' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('user_id'),
            'created_ip' => $_SERVER['REMOTE_ADDR']
        );
           //  echo '<pre>';
           // print_r($val);
        $this->dbconnection->insert('sms_notification', $this->security->xss_clean($val));
    }
    $this->session->set_flashdata('successmsg', "SMS Configured Successfully.");

    redirect('communication/Sms_Notification');
}


}
