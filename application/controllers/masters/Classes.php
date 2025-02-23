<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Classes extends CI_Controller {

    public $page_code = 'classes';
    public $page_id = '';
    public $page_perm = '----';

    public function __construct() {
        parent::__construct();

        $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");


        $this->id = $this->session->userdata('school_id');
        $this->db->db_select('crmfeesclub_' . $this->id);

        $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
        $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
        $this->right_access = $this->page_perm;

        if (strpos($this->page_perm, '----') == true) {
            redirect(base_url(''), 'refresh');
        }
        $this->page_title = 'Classes';
        $this->section = 'masters';
        $this->page_name = 'class_view';
        $this->customview = '';
    }

    public function index() {
        if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->data['page_name'] = $this->page_name;
        $this->data['id'] = $this->id;
        $this->data['page_title'] = $this->page_title;
        $this->data['section'] = $this->section;
        $this->data['customview'] = $this->customview;
        $this->data['navi'] = 'classes';
        $this->data['right_access'] = $this->right_access;
        /* $this->data['aclass'] = $this->dbconnection->select('class', '*'); */

        $oclass = $this->dbconnection->select("class cls", "cls.id, cls.class_name,cls.class_code,cls.section,cls.last_monthlyfeepay_month", "status='Y'");
        $this->data['category'] = $this->dbconnection->select('category', '*', 'status ="Y"');
        $this->data['asection'] = $this->dbconnection->select('section', '*', 'status ="Y"');
        $aclass = array();

        foreach ($oclass as $key) {
            $totalstud = $this->dbconnection->select("student", "count(id) as totalstud", "class_id=".$key->id. " and status=1");
            $totalreg = $this->dbconnection->select("student", "count(id) as totalreg", "class_id=" . $key->id . " and registered_status=1");

            $cat = '';
            $cat_id = '';

            if ($key->section != '') {
                $sectionfetch = explode("-", $key->section);
                foreach ($sectionfetch as $val) {
                    $fetch_sec_name = $this->dbconnection->select("section", "sec_name", "id=$val and status='Y'");
                    if ($cat == '') {
                        $cat = $fetch_sec_name[0]->sec_name;
                        $cat_id = $val;
                    } else {
                        $cat = $cat . ' , ' . $fetch_sec_name[0]->sec_name;
                        $cat_id = $cat_id . ' , ' . $val;
                    }
                }
            }

            $this->data['aclass'][] = array(
                'id' => $key->id,
                'class_name' => $key->class_name,
                'class_code' => $key->class_code,
                'last_monthlyfeepay_month' => $key->last_monthlyfeepay_month,
                'section' => $cat,
                'section_id' => $cat_id,
                'totalstud' => $totalstud[0]->totalstud,
                'totalreg' => $totalreg[0]->totalreg
            );
        }
        $this->load->view('index', $this->data);
    }

    public function addclass() {

        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $result = $this->dbconnection->insert('class', array(
            'class_code' => $this->input->post('class_code'),
            'class_name' => $this->input->post('class_name'),
            'section' => $this->input->post('section'),
            'last_monthlyfeepay_month' => !empty($this->input->post('last_monthlyfeepay_month')) ? $this->input->post('last_monthlyfeepay_month') : 12,
            'created_by' => $this->session->userdata('user_id')
                )
        );
        $audit = array("action" => 'Add',
            "module" => "Class Module",
            'datetime' => date("Y-m-d H:i:s"),
            'userid' => $this->session->userdata('user_id'),
            'page' => 'School',
            'remarks' => ''
        );
        $this->dbconnection->insert("auditntrail", $audit);
        echo 1;
    }

    public function update_class() {
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }

        $class_id = $this->uri->segment(4);
        $this->dbconnection->update('class', array('class_code' => $this->input->post('class_code'), 'class_name' => $this->input->post('class_name'), 'section' => $this->input->post('section'), 'last_monthlyfeepay_month' => !empty($this->input->post('last_monthlyfeepay_month')) ? $this->input->post('last_monthlyfeepay_month') : 12, 'last_modified_by' => $this->session->userdata('user_id'), 'last_date_modified' => date('Y-m-d H:i:s')), array('id' => $class_id)
        );


//Audit Trail
        $audit = array("action" => 'Update',
            "module" => "Class Module",
            'datetime' => date("Y-m-d H:i:s"),
            'userid' => $this->session->userdata('user_id'),
            'student_id' => '',
            'page' => 'class',
            'remarks' => ''
        );
        $this->dbconnection->insert("auditntrail", $audit);
        echo 1;
    }

    public function delete_class() {
        if (substr($this->right_access, 3, 1) != 'D') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $result = array();
        $result = $this->dbconnection->update('class', array('status' => 'N', 'last_modified_by' => $this->session->userdata('user_id'), 'last_date_modified' => date('Y-m-d H:i:s')), array('id' => trim($this->input->post('classid'))));

//Audit Trail
        $audit = array("action" => 'Delete',
            "module" => "Class Module",
            'datetime' => date("Y-m-d H:i:s"),
            'userid' => $this->session->userdata('user_id'),
            'student_id' => '',
            'page' => 'School',
            'remarks' => ''
        );
        $this->dbconnection->insert("auditntrail", $audit);
        echo 1;
    }

}
