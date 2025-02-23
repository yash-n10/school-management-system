<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Credit_note extends CI_Controller {

    public $page_code = 'credit_note';
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
        $this->data['page_name'] = 'credit_note';
        $this->data['page_title'] = 'Credit Note';
        $this->data['section'] = 'account';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->data['state'] = $this->dbconnection->select("crmfeesclub.states", "*", "");
        $this->data['ledger'] = $this->dbconnection->select('ledger', '*', '');
        $voucher = $this->db->query("SELECT count(bill_gen_no) as vno FROM voucher where voucher_type='credit_note' and module_name ='credit_note' group by bill_gen_no;")->result();


        $v_no = count($voucher) + 1;
        $date = date('ymd');
// $this->data['voucher_no'] = 'PAY/'.$date.'/';
        $this->data['voucher_no'] = 'DN/' . $date . '/' . $v_no;
        $this->load->view('index', $this->data);
    }

    public function add_credit_note() {
        
        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }

        $temp = count($this->input->post('crdr'));
        $crd = $this->input->post('crdr');
        $par = $this->input->post('particulars');
        $amo = $this->input->post('amount');
        $voucher = $this->input->post('voucher_no');
        $date = $this->input->post('date');

        for ($i = 0; $i < $temp; $i++) {
            $date = $this->input->post('date');
            $crdr = $crd[$i];
            $particulars = $par[$i];
            $amount = $amo[$i];
            $narration = $this->input->post('narration');
            $total_amount = $this->input->post('total_debit');
            $credit = 0;
            $debit = 0;
            if ($crdr == 'CR') {

                $credit = $amo[$i];
            } else if ($crdr == 'DR') {
                $debit = $amo[$i];
            }

            $chk = 0;
            for ($m = 0; $m < $temp; $m++) {
                $cd1 = $crd[$m];
                if ($crdr != $cd1) {
                    if ($chk == 0) {
                        $opp_parti = $par[$m];
                        $chk++;
                    }
                }
            }

            $data = array(
                'voucher' => $voucher,
                'date' => $date,
                'd_c' => $crdr,
                'debit' => $debit,
                'credit' => $credit,
                'particulars' => $particulars,
                'opp_particulars' => $opp_parti,
                'amount' => $total_amount,
                'narration' => $narration,
                'module_name' => 'Credit Note',
                'voucher_type' => 'Credit Note',
                'bill_gen_no' => $voucher,
                'page_name' => 'edit_credit_note',
                'created_by' => $this->session->userdata('user_id'),
                'created_ip' => $_SERVER['REMOTE_ADDR'],
            );
            $this->dbconnection->insert('voucher', $data);
            $last_id = $this->db->insert_id();

//            $audit = array(
//                "action" => 'Add',
//                "module" => 'Ledger',
//                "page" => basename(__FILE__, '.php'),
//                'created_at' => date("Y-m-d H:i:s"),
//                'user_id' => $this->session->userdata('user_id'),
//                'remarks' => 'ID:' . $last_id,
//                'ip' => $_SERVER['REMOTE_ADDR']
//            );
//
//            $this->dbconnection->insert('auditntrail', $audit);
            $this->session->set_flashdata('successmsg', 'Success' . $last_id);
//
        }
        $payment_voucher = $this->session->set_userdata('voucher', $voucher);
        redirect('account/Acc_ledger', 'refresh');
    }

}
