<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Role_permission extends CI_Controller {
    
    public $page_code = 'role_permission';
    public $page_id = '';
    public $page_perm = '----';
    
    public function __construct() {
        
        
        parent::__construct();
        $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");

        $this->id = $this->session->userdata('school_id');
        $this->data['page_title'] = 'Role Permission save';
        if ($this->id != 0) {
            $this->db->db_select('crmfeesclub_' . $this->id);
        }
        $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
        $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
        $this->right_access = $this->page_perm;

        if (strpos($this->page_perm, '----') == true) {
            redirect(base_url(''), 'refresh');
        }

//$this->academic_session = $this->dbconnection->select("academic_session", "max(id) as fin_year,start_date,batch_name,end_date,session", "status='Y' and active='Y'",'','',array('id'));
    }

    public function index() {
        //if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
  //          redirect('404');
//        }
        $this->data['page_name'] = 'role_permission_list';
        $this->data['page_title'] = 'Role Permission';
        $this->data['section'] = 'settings';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        if ($this->id != 0) {
            $str="id!=1";
            // $str="id!=1 and id!=4";
        }else{
            $str='';
        }
        $this->data['group'] = $this->dbconnection->select("user_group", "*", "$str");


        $this->load->view('index', $this->data);
    }

    public function save_role_permission() {
        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->data['page_name'] = 'role_permission_save';
        $this->data['page_title'] = 'Role Permission';
        $this->data['section'] = 'settings';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        if ($this->id != 0) {
            // $str="id!=1";
            $str="id!=1 and id!=4";
            $this->data['link'] = $this->db->query("SELECT * FROM crmfeesclub.link_page lp "
//                . "inner join crmfeesclub.school_modules sm on (lp.module_id=sm.module_id or lp.module_id=1) "
                . "where  (lp.module_id=1 or lp.module_id in (select module_id from crmfeesclub.school_modules where school_id=$this->id and status='Y'))  and (lp.link_status='' or lp.link_status is null) order by grand_node,priority")->result();
        }else{
            $str='';
            $this->data['link'] = $this->db->query("SELECT * from crmfeesclub.link_page where link_status='' or link_status='NULL' or link_status is null order by grand_node,priority")->result();
//            $this->data['link'] = $this->dbconnection->select("crmfeesclub.link_page", "*", "link_status='' or link_status is null","grand_node");
        }
        $this->data['group'] = $this->dbconnection->select("user_group", "*", "$str");
        
//        $this->data['link'] = $this->dbconnection->select("crmfeesclub.link_page", "*", "link_status='' or link_status is null","grand_node");
        $this->load->view('index', $this->data);
    }

    public function save() {
        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $group_code = $this->input->post('group_code');
        $group_name = $this->input->post('group_name');
        $data = array(
            'group_code' => $group_code,
            'group_type' => $group_name,
            'status' => 'Y',
            'date_created' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('user_id'),
            'ip' => $_SERVER['REMOTE_ADDR']
        );
        $this->dbconnection->insert('user_group', $this->security->xss_clean($data));
        if ($this->id == 0) {
            $this->dbconnection->insert('crmfeesclub_0.user_group', $this->security->xss_clean($data));
        }
        $uid = $this->dbconnection->get_last_id();
        $this->dbtablelastid = $uid;
        foreach ($this->input->post('idd') as $value) {
            $row1 = !empty($this->input->post('C')[$value]) ? $this->input->post('C')[$value] : '-';
            $row2 = !empty($this->input->post('R')[$value]) ? $this->input->post('R')[$value] : '-';
            $row3 = !empty($this->input->post('U')[$value]) ? $this->input->post('U')[$value] : '-';
            $row4 = !empty($this->input->post('D')[$value]) ? $this->input->post('D')[$value] : '-';

            echo 'limk=' . $this->input->post('link_code')[$value];
            $row5 = $row1 . $row2 . $row3 . $row4;
            echo '<html><br></html>';

            $val = array(
                'user_group_id' => $uid,
                'permission' => $row5,
                'link_code' => $this->input->post('link_code')[$value],
                'status' => 'Y',
                'date_created' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('user_id'),
                'created_ip' => $_SERVER['REMOTE_ADDR']
            );
            $this->dbconnection->insert('user_group_permission', $this->security->xss_clean($val));
            if ($this->id == 0) {
                $this->dbconnection->insert('crmfeesclub_0.user_group_permission', $this->security->xss_clean($data));
            }
        }
//echo $link_code;
//        $audit = array("action" => 'Save',
//            "module" => $this->page_title,
//            "page" => basename(__FILE__, '.php'),
//            'created_at' => date("Y-m-d H:i:s"),
//            'user_id' => $this->session->userdata('user_id'),
//            'remarks' => 'ID:' . $this->dbtablelastid,
//            'ip' => $this->input->ip_address()
//        );
//        $this->dbconnection->insert("auditntrail", $audit);
        $this->session->set_flashdata('successmsg', "Permission Successfully Created. $this->dbtablelastid.");

//        echo json_encode(['success' => 'Permission successfully added.']);
        redirect('settings/Role_permission/index');
    }

    public function del() {
        if (substr($this->right_access, 3, 1) != 'D') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->input->post('del_id');
        $field = array(
            'status' => 'N'
        );
        $this->dbconnection->update('user_group', $field, 'id=' . $this->input->post('del_id'));
        if ($this->id == 0) {
                $this->dbconnection->update('crmfeesclub_0.user_group', $field, 'id=' . $this->input->post('del_id'));
        }
//        $last_id = $this->db->insert_id();

//        $audit = array(
//            "action" => 'Delete',
//            "module" => 'User Group',
//            "page" => basename(__FILE__, '.php'),
//            'created_at' => date("Y-m-d H:i:s"),
//            'user_id' => $this->session->userdata('user_id'),
//            'remarks' => 'ID:' . $this->input->post('del_id'),
//            'ip' => $_SERVER['REMOTE_ADDR']
//        );
//
//        $this->dbconnection->insert('auditntrail', $audit);
    }

    public function edit() {
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $id = $this->uri->segment(4);
        $this->data['page_name'] = 'role_permission_edit';
        $this->data['page_title'] = 'Role Permission';
        $this->data['section'] = 'settings';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        
        $this->data['id'] = $id;
        $this->data['datas'] = array_column($this->dbconnection->select_returnarray('user_group_permission', '*', 'status="Y" AND user_group_id=' . $id), 'permission', 'link_code');
//        $this->data['link'] = $this->dbconnection->select("link_page", "*", "","grand_node");
        if ($this->id != 0) {
            // $str="id!=1";
            $str="id!=1 and id!=4 and id!=14";
            $this->data['link'] = $this->db->query("SELECT * FROM crmfeesclub.link_page lp "
//                . "inner join crmfeesclub.school_modules sm on (lp.module_id=sm.module_id or lp.module_id=1) "
                . "where  (lp.module_id=1 or lp.module_id in (select module_id from crmfeesclub.school_modules where school_id=$this->id and status='Y'))  and (lp.link_status='student' or lp.link_status='' or link_status='NULL' or lp.link_status is null) order by grand_node,priority")->result();
        }else{
            $str='';
            $this->data['link'] = $this->db->query("SELECT * from crmfeesclub.link_page where link_status='' or link_status='NULL' or link_status is null order by grand_node,priority")->result();
//            $this->data['link'] = $this->dbconnection->select("crmfeesclub.link_page", "*", "link_status='' or link_status is null","grand_node");
        }
// echo "<pre>";print_r($this->id);die();
        $this->data['group'] = $this->dbconnection->select('user_group', '*', 'id=' . $id);

        $this->load->view('index', $this->data);
    }

    public function update() {
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $id = $this->input->post('id');
        $group_code = $this->input->post('group_code');
        $group_name = $this->input->post('group_name');
        $data = array(
            'group_code' => $group_code,
            'group_type' => $group_name,
            'status' => 'Y',
            'date_created' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('user_id'),
            'ip' => $_SERVER['REMOTE_ADDR']
        );

        
        $this->dbconnection->update('user_group', $this->security->xss_clean($data), 'id=' . $id);
        
//$uid=$this->dbconnection->get_last_id();
//$this->dbtablelastid = $uid;
        $this->dbconnection->delete('user_group_permission', 'user_group_id='.$id);
        
        if ($this->id == 0) {
                $this->dbconnection->update('crmfeesclub_0.user_group', $this->security->xss_clean($data), 'id=' . $id);
                $this->dbconnection->delete('crmfeesclub_0.user_group_permission', 'user_group_id='.$id);
        }
        foreach ($this->input->post('idd') as $value) {
            $row1 = !empty($this->input->post('C')[$value]) ? $this->input->post('C')[$value] : '-';
            $row2 = !empty($this->input->post('R')[$value]) ? $this->input->post('R')[$value] : '-';
            $row3 = !empty($this->input->post('U')[$value]) ? $this->input->post('U')[$value] : '-';
            $row4 = !empty($this->input->post('D')[$value]) ? $this->input->post('D')[$value] : '-';
            $rows = !empty($this->input->post('link_code')[$value]) ? $this->input->post('link_code')[$value] : '-';

            $row5 = $row1 . $row2 . $row3 . $row4;

            $val = array(
                'user_group_id' => $id,
                'link_code' => $value,
                'permission' => $row5,
                'status' => 'Y',
                'last_date_modified' => date('Y-m-d H:i:s'),
                'last_modified_by' => $this->session->userdata('user_id'),
                'created_ip' => $_SERVER['REMOTE_ADDR']
            );
//print_r($val);
            $this->dbconnection->insert('user_group_permission', $this->security->xss_clean($val));
            if ($this->id == 0) {
                    $this->dbconnection->insert('crmfeesclub_0.user_group_permission', $this->security->xss_clean($val));
            }
//     $this->dbconnection->update('user_group_permission', $this->security->xss_clean($val),'user_group_id=' . $id); 
        }
        
        $this->session->set_flashdata('successmsg', "Permission Successfully Updated.");

//        echo json_encode(['success' => 'Permission successfully updated.']);
        redirect('settings/Role_permission/index');
    }

}
