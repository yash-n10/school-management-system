<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Trail_balance extends CI_Controller {

    public $page_code = 'class_routine';
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

        if (strpos($this->page_perm, '----') == true) {
            redirect(base_url(''), 'refresh');
        }

        $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y' and active='Y'");
    }

    public function index() {
        if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $mon = date('m');
        $fromyear;
        $toyear;
        $fyear;
        if ($mon > 3) {
            $fromyear = date('Y');
            $toyear = date('Y') + 1;
            $fyear = $fromyear . "-" . $toyear;
        } else {
            $fromyear = date('Y') - 1;
            $toyear = date('Y');
            $fyear = $fromyear . "-" . $toyear;
        }
//echo  $fyear;
        $from_date = $fromyear . "-04-01"; //date('Y-m-d');
        $to_date = $toyear . "-03-31"; //date('Y-m-d');
        $this->data['page_name'] = 'trail_balance';
        $this->data['page_title'] = 'Trail balance';
        $this->data['section'] = 'account';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->data['trial_bal'] = $this->dbconnection->get_trialbalance($from_date, $to_date);
        $this->data['trial_group'] = $this->dbconnection->select('vw_voucher', '*', '');
//  $this->data['ledname']=$trial_group->ID;
        $this->load->view('index', $this->data);
    }

    public function grpledgerreport() {
        if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->data['page_name'] = 'grpledgerreport';
        $this->data['page_title'] = 'Group Ledger';
        $this->data['section'] = 'account';
        $grpcode = $this->uri->segment(4);
        $this->data['grpledger'] = $this->dbconnection->select('vw_voucher', '*', 'GROUP_CODE=' . $grpcode);
        $this->load->view('index', $this->data);
    }

    public function add_groupledger() {
        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->data['page_name'] = 'groupreport';
        $this->data['page_title'] = 'Reports';
        $this->data['section'] = 'account';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $particulars = $this->input->post('ledger_name');
        $frm = $this->input->post('from_date');
        $to = $this->input->post('to_date');
        $this->data['accountsledger'] = $this->dbconnection->get_ledger($particulars, $frm, $to);
        $this->data['ledger_group'] = $this->dbconnection->select('ledger_group', '*', 'id=' . $particulars);
        $this->load->view('index', $this->data);
//$ledname=$ledgername[0]->ledger_name;
// $address=$ledgername[0]->address;
// $opening_date=$ledgername[0]->opening_date;
// $opening_balance=$ledgername[0]->opening_balance;
//$crdr=$ledgername[0]->cr_dr;
    }

    public function ledgerreport() {
        if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->data['page_name'] = 'Ladgerreport';
        $this->data['page_title'] = 'Accounts Ledger';
        $this->data['section'] = 'account';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $particulars = $this->input->post('group_name');
        $frm = $this->input->post('from_date');
        $to = $this->input->post('to_date');
        $this->data['accountsgroups'] = $this->dbconnection->get_ledger_group($particulars, $frm, $to);
        $gid = $this->uri->segment(4);
        $this->data['accountsledger'] = $this->dbconnection->select('vw_voucher', '*', 'PARTICULARS=' . $gid);
        $this->load->view('index', $this->data);
    }

    public function delt_ajax_return() {
        $id = $_POST['id'];
        $data = array(
            'BILL_GEN_NO' => $id,
        );
//$this->dbconnection->delete('voucher',$data);
//$this->session->set_flashdata('form_contra', $voucher.   'Successfully Deleted');
    }

}
