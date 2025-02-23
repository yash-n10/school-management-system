<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Double_concern extends CI_Controller {
    
    public $page_code = 'role_permission';
    public $page_id = '';
    public $page_perm = '----';
    
    public function __construct() {
        
        
        parent::__construct();
        $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");

        $this->id = $this->session->userdata('school_id');
        if ($this->id != 0) {
            $this->db->db_select('crmfeesclub_' . $this->id);
        }
        $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
        $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
        $this->right_access = $this->page_perm;

        $this->user_groups = $this->dbconnection->select('user_group', '*');
        
        if (strpos($this->page_perm, '----') == true) {
            redirect(base_url(''), 'refresh');
        }

//$this->academic_session = $this->dbconnection->select("academic_session", "max(id) as fin_year,start_date,batch_name,end_date,session", "status='Y' and active='Y'",'','',array('id'));
    }

    public function index() {
//        if (substr($this->right_access, 1, 1) != 'R') {
////            redirect(base_url(), 'refresh');
//            redirect('404');
//        }
         $this->data['page_name'] = 'double_concern';
        $this->data['page_title'] = 'Double Permission';
        $this->data['section'] = 'settings';
        $this->data['customview'] = '';
        if ($this->id != 0) {
            $str="id!=1 and id!=4";
            $this->data['link'] = $this->db->query("SELECT * FROM crmfeesclub.link_page lp "
//                . "inner join crmfeesclub.school_modules sm on (lp.module_id=sm.module_id or lp.module_id=1) "
                . "where  (lp.module_id=1 or lp.module_id in (select module_id from crmfeesclub.school_modules where school_id=$this->id and status='Y'))  and (lp.link_status='' or lp.link_status is null) order by grand_node")->result();
        }else{
            $str='';
            $this->data['link'] = $this->dbconnection->select("crmfeesclub.link_page", "*", "link_status='' or link_status is null","grand_node");
        }
        
        $this->data['datas'] = array_column($this->dbconnection->select_returnarray('dual_permission', '*', 'status="Y"'), 'permission', 'link_code');
        
        $this->data['group'] = $this->dbconnection->select("user_group", "*", "$str");
//        $this->data['employee']    = $this->dbconnection->select('employee', '*', "");
        $this->data['employee']    = $this->db->query("select emp.id,emp.name,us.id as user_id,us.user_name,us.user_group_id from employee emp,user us where emp.id=us.employee_id;")->result();
        $this->data['dual_permission']    = $this->dbconnection->select('dual_permission', '*', "");

        $this->load->view('index', $this->data);
    }

    
    public function double() {
        $this->data['page_name'] = 'double_concern';
        $this->data['page_title'] = 'Double Permission';
        $this->data['section'] = 'settings';
        $this->data['customview'] = '';
        if ($this->id != 0) {
            $str="id!=1 and id!=4";
            $this->data['link'] = $this->db->query("SELECT * FROM crmfeesclub.link_page lp "
//                . "inner join crmfeesclub.school_modules sm on (lp.module_id=sm.module_id or lp.module_id=1) "
                . "where  (lp.module_id=1 or lp.module_id in (select module_id from crmfeesclub.school_modules where school_id=$this->id and status='Y'))  and (lp.link_status='' or lp.link_status is null) order by grand_node")->result();
        }else{
            $str='';
            $this->data['link'] = $this->dbconnection->select("crmfeesclub.link_page", "*", "link_status='' or link_status is null","grand_node");
        }
        
        $this->data['datas'] = array_column($this->dbconnection->select_returnarray('dual_permission', '*', 'status="Y"'), 'permission', 'link_code');
        
        $this->data['group'] = $this->dbconnection->select("user_group", "*", "$str");
//        $this->data['employee']    = $this->dbconnection->select('employee', '*', "");
        $this->data['employee']    = $this->db->query("select emp.id,emp.name,us.id as user_id,us.user_name,us.user_group_id from employee emp,user us where emp.id=us.employee_id;")->result();
        $this->data['dual_permission']    = $this->dbconnection->select('dual_permission', '*', "");

        $this->load->view('index', $this->data);
    }
    
    
    public function dualconcernsave() {
        foreach ($this->input->post('page') as  $key => $value) {
//            $this->input->post('batch') as $key => $value
            $row1 = !empty($this->input->post('C')[$key]) ? $this->input->post('C')[$key] : '-';

            $row4 = !empty($this->input->post('D')[$key]) ? $this->input->post('D')[$key] : '';

            echo 'link=' . $this->input->post('page')[$key];
            $row5 = $row1  . $row3 . $row4;
            echo '<html><br></html>';

            $val = array(
                'authorise_person1' => $this->input->post('user_group')[$key],
                'authorise_person2' => $this->input->post('user_group_sec')[$key],
                'authorise_person3' => $this->input->post('user_group_th')[$key],
                'permission' => $row5,
                'link_code' => $this->input->post('page')[$key],
                'status' => 'Y',
                'date_created' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('user_id'),
                'created_ip' => $_SERVER['REMOTE_ADDR']
            );
//            print_r($val);
//            die();
            $this->dbconnection->insert('dual_permission', $this->security->xss_clean($val));
            if ($this->id == 0) {
                $this->dbconnection->insert('crmfeesclub_0.dual_permission', $this->security->xss_clean($data));
            }
        }
        $this->session->set_flashdata('successmsg', "Permission Successfully Created. $this->dbtablelastid.");

        redirect('settings/Role_permission/double');
    }
    
    public function CheckUsers() {
        $user = $this->input->post('user');
//        $user_chk_query = $this->dbconnection->select("user", "employee_id", "employee_id=$user");
//        echo $validuser=$user_chk_query[0]->employee_id;
        
        if ($usercnt = $this->dbconnection->select('user', 'count(*) as cnt', "employee_id='$user'")) {
            echo $usercnt[0]->cnt;
        } else {
            echo 0;
        }
//        print_r($exam_type);
    }

}
