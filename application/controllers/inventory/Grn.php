<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Grn extends CI_Controller {
    public $page_code = 'goods_grn';
    public $page_id = '';
    public $page_perm = '----';
    public function __construct() {
        parent::__construct();
        $this->load->model('Mymodel', 'm');

        $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");

// $accesspermission = $this->dbconnection->select('collegefclb.user_group_permission', 'permission', "status='Y' AND link_code='$link_code' AND user_group_id=".$this->session->userdata('user_group_id')); 
// $tt=$this->right_access= $this->right_access = (count($accesspermission)==0 || empty($accesspermission[0]->permission)) ? '----':$accesspermission[0]->permission;
// if($this->right_access=='----') {
// redirect(base_url(), 'refresh');
// }
        
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
        $this->data['page_name'] = 'grn_list';
        $this->data['page_title'] = 'GRN';
        $this->data['section'] = 'inventory';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->data['vendor'] = $this->dbconnection->select("ledger", "*", "status='Y' AND under_group = 36");
        $this->data['pro'] = $this->dbconnection->select("product", "*", "status='Y'");
        $this->data['uqc'] = $this->dbconnection->select("crmfeesclub.uqc", "*", "");
        $this->data['grn'] = $this->m->getGRNdata();
        $this->load->view('index', $this->data);
    }

    public function vieww() {
        if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $grn_no = $this->input->post('grn_no');
        $grn_fet = $this->m->grn_fetch($grn_no);
        $this->load->view('inventory/load_grn_list', array('grn_fet' => $grn_fet));
    }

    public function edit() {
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $grn_no = $this->input->post('grn_no');

        $grn_fet = $this->m->edit_grn($grn_no);

        $inv_no = $grn_fet[0]->inv_no;
        $voucher_type = $grn_fet[0]->voucher_type;
        $discount_type = $grn_fet[0]->discount_type;
        $prname = $grn_fet[0]->prname;
        $ordqty = $grn_fet[0]->ordqty;
        $recqty = $grn_fet[0]->recqty;
        $blnqty = $grn_fet[0]->blnqty;
        $rate = $grn_fet[0]->rate;
        $gstrate = $grn_fet[0]->gstrate;
        $taxtype = $grn_fet[0]->taxtype;
        $basicamt = $grn_fet[0]->basicamt;
        $discount = $grn_fet[0]->discount;
        $gstamt = $grn_fet[0]->gstamt;
        $finalamt = $grn_fet[0]->finalamt;
        $basictotal = $grn_fet[0]->basictotal;
        $gst_c = $grn_fet[0]->gst_c;
        $gst_s = $grn_fet[0]->gst_s;
        $gst_i = $grn_fet[0]->gst_i;
        $nettotal = $grn_fet[0]->nettotal;

        $voucher = $this->dbconnection->select('voucher_master', 'id,voucher_name,is_igst', 'voucher_group=5');
        $this->load->view('inventory/load_grn_edit', array('grn_fet' => $grn_fet, 'voucher' => $voucher, 'inv_no' => $inv_no, 'voucher_type' => $voucher_type, 'discount_type' => $discount_type, 'ordqty' => $ordqty, 'recqty' => $recqty, 'blnqty' => $blnqty, 'rate' => $rate, 'gstrate' => $gstrate, 'basicamt' => $basicamt, 'discount' => $discount, 'gstamt' => $gstamt, 'finalamt' => $finalamt, 'basictotal' => $basictotal, 'gst_c' => $gst_c, 'gst_s' => $gst_s, 'gst_i' => $gst_i, 'nettotal' => $nettotal));
    }

    public function edit_save() {
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        for ($i = 0; $i < count($this->input->post('pro')); $i++) {
            $newDateString = date('Y-m-d h:i:s');
            $upd_id = $this->input->post('upd_id')[$i];
            $field = array(
                'inv_no' => $this->input->post('inv_no'),
                'voucher_type' => $this->input->post('voucher_type'),
                'discount_type' => $this->input->post('dic'),
                'pro' => $this->input->post('pro')[$i],
                'batch' => $this->input->post('batch')[$i],
                'mfg_date' => $this->input->post('mfg_date')[$i],
                'exp_date' => $this->input->post('exp_date')[$i],
                'size' => $this->input->post('size')[$i],
                'color' => $this->input->post('color')[$i],
                'uqc' => $this->input->post('uqc')[$i],
                'ordqty' => $this->input->post('ordqty')[$i],
                'recqty' => $this->input->post('recqty')[$i],
                'blnqty' => $this->input->post('blnqty')[$i],
                'rate' => $this->input->post('rate')[$i],
                'gstrate' => $this->input->post('gstrate')[$i],
                'taxtype' => $this->input->post('taxtype')[$i],
                'basicamt' => $this->input->post('basicamt')[$i],
                'discount' => $this->input->post('discount')[$i],
                'gstamt' => $this->input->post('gstamt')[$i],
                'finalamt' => $this->input->post('finalamt')[$i],
                'basictotal' => $this->input->post('basictotal'),
                'gst_c' => $this->input->post('gst_c'),
                'gst_s' => $this->input->post('gst_s'),
                'gst_i' => $this->input->post('gst_i'),
                'nettotal' => $this->input->post('nettotal'),
                'last_date_modified' => $newDateString,
                'last_modified_by' => $this->session->userdata('user_id'),
                'modified_ip' => $_SERVER['REMOTE_ADDR']
            );

            $this->dbconnection->update('GRN', $field, 'id=' . $upd_id);
        }
        $audit = array(
            "action" => 'Update',
            "module" => 'GRN',
            "page" => basename(__FILE__, '.php'),
            'created_at' => date("Y-m-d H:i:s"),
            'user_id' => $this->session->userdata('user_id'),
            'remarks' => 'ID:' . $upd_id,
            'ip' => $_SERVER['REMOTE_ADDR']
        );
        $this->dbconnection->insert('auditntrail', $audit);
    }

}
