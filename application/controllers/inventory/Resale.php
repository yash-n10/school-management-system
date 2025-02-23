<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Resale extends CI_Controller {
    
    public $page_code = 'resale';
    public $page_id = '';
    public $page_perm = '----';
    
    public function __construct() {
        parent::__construct();
         $this->db->db_debug=TRUE;
         error_reporting(-1);
         ini_set('display_errors', 1);
        $this->load->model('Mymodel', 'm');
        $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");

        $this->id = $this->session->userdata('school_id');
        if ($this->id != 0) {
            $this->db->db_select('crmfeesclub_' . $this->id);
        }
        $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
        $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
        $this->right_access = $this->page_perm;

        if (strpos($this->page_perm, '----') == true) {
            redirect(base_url(''), 'refresh');
        }

        $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y' and active='Y'", '', '', array('id'));
    }

    public function index() {
        if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->load->model('Mymodel', 'm');
        $this->data['page_name'] = 'resale_list';
        $this->data['page_title'] = 'Resale';
        $this->data['section'] = 'inventory';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->data['resale'] = $this->m->resale_cust_detail();
        $this->load->view('index', $this->data);
    }

    public function sale_pro() {
        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->load->model('Mymodel', 'm');
        $this->data['page_name'] = 'sale_pro_form';
        $this->data['page_title'] = 'Add Product';
        $this->data['section'] = 'inventory';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->data['pro'] = $this->dbconnection->select("product", "*", "status='Y'");
        $this->data['ledger'] = $this->dbconnection->select("ledger", "*", "status='Y' AND under_group = '21'");
        $this->load->view('index', $this->data);
    }

    public function fetchpro() {
        $proid = $this->input->post('proid');
        $fetpro = $this->m->fetchprogrp($proid);
        $cat = $fetpro[0]->catname;
        $grp = $fetpro[0]->grpname;
        $comp = $fetpro[0]->comname;

        $purchase_uqc = $fetpro[0]->purchase_uqc;
        $stock_uqc = $fetpro[0]->stock_uqc;
        $puruqc = $fetpro[0]->puruqc;
        $stkuqc = $fetpro[0]->stkuqc;
        if ($stock_uqc != '') {
            $slect_option = "<option value='" . $purchase_uqc . "'>" . $puruqc . "</option><option value='" . $stock_uqc . "'>" . $stkuqc . "</option>";
        } else {
            $slect_option = "<option value='" . $purchase_uqc . "'>" . $puruqc . "</option>";
        }

        $data = array($cat, $grp, $comp, $slect_option);

        echo json_encode($data);
    }

    public function fetchled() {
        $led_id = $this->input->post('led_id');
        $led = $this->dbconnection->select('ledger', '*,(select state_name from crmfeesclub.states where id=state)st', "id='$led_id'");

        $add = $led[0]->address;
        $city = $led[0]->city;
        $state = $led[0]->st;
        $phone = $led[0]->phone;
        $gst_no = $led[0]->gst_no;
        $pan_no = $led[0]->pan_no;

        $dt = array($add, $city, $state, $phone, $gst_no, $pan_no);
        echo json_encode($dt);
    }

    public function save_resale() {
        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $field_cust_detail = array(
            'inv_no' => $this->input->post('inv_no'),
            'customer_id' => $this->input->post('name'),
            'net_tot' => $this->input->post('ntot')
        );

        $this->dbconnection->insert('resale_cust_detail', $field_cust_detail);
        $last_id = $this->db->insert_id();

        for ($i = 0; $i < count($this->input->post('cat')); $i++) {
            $field = array(
                'resale_cust_detail_id' => $last_id,
                'pro' => $this->input->post('pro')[$i],
                'cat' => $this->input->post('cat')[$i],
                'group' => $this->input->post('group')[$i],
                'comp' => $this->input->post('comp')[$i],
                'uqc' => $this->input->post('uqc')[$i],
                'price' => $this->input->post('price')[$i],
                'qty' => $this->input->post('qty')[$i],
                'tot_price' => $this->input->post('totamt')[$i]
            );
            $this->dbconnection->insert('resale', $field);
        }
        redirect('inventory/Resale/index');
    }

    public function resale_view($id) {
        if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->data['resale'] = $this->dbconnection->select('resale', '*,(select pro.product from product as pro where pro.id=resale.pro)proname,(select name from crmfeesclub.uqc where id=resale.uqc)uqcname', "resale_cust_detail_id = '$id'");

        $this->data['page_name'] = 'resale_product_view';
        $this->data['page_title'] = 'Resale Product';
        $this->data['section'] = 'inventory';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->load->view('index', $this->data);
    }

    public function resale_edit($ids) {
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->data['page_name'] = 'resale_product_edit';
        $this->data['page_title'] = 'Resale Product Update';
        $this->data['section'] = 'inventory';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->data['resale'] = $this->m->resale_edits($ids);
        $this->data['resale_edit'] = $this->dbconnection->select('resale', '*', "resale_cust_detail_id = '$ids'");
        $this->data['pro'] = $this->dbconnection->select("product", "*", "status='Y'");
        $this->data['uqc'] = $this->dbconnection->select("crmfeesclub.uqc", "*");
        $this->data['ledger'] = $this->dbconnection->select("ledger", "*", "status='Y' AND under_group = '21'");
        $this->load->view('index', $this->data);
    }

}
