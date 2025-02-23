<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Acc_ledger extends CI_Controller {

    public $page_code = 'acc_ledger';
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
        
        $this->data['page_name'] = 'acc_ledger';
        $this->data['page_title'] = 'Account Ledger';
        $this->data['section'] = 'account';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->data['state'] = $this->dbconnection->select("crmfeesclub.states", "*", "");
        $this->data['ledger'] = $this->dbconnection->select('ledger', '*', '');
        $this->load->view('index', $this->data);
    }

    public function acc_report() {
        
        if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        
        $this->data['page_name'] = 'accountsreport';
        $this->data['page_title'] = 'Reports';
        $this->data['section'] = 'account';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $particulars = $this->input->post('ledger_name');
        $frm = $this->input->post('from_date');
        $to = $this->input->post('to_date');
        $this->data['accountsledger'] = $this->dbconnection->get_ledger($particulars, $frm, $to);
        $this->data['ledgername'] = $this->dbconnection->select('ledger', '*', 'id=' . $particulars);

//$ledname=$ledgername[0]->ledger_name;
// $address=$ledgername[0]->address;
// $opening_date=$ledgername[0]->opening_date;
// $opening_balance=$ledgername[0]->opening_balance;
//$crdr=$ledgername[0]->cr_dr;

        $this->load->view('index', $this->data);
    }

    public function edit_payment() {
        
//        if (substr($this->right_access, 2, 1) != 'U') {
////            redirect(base_url(), 'refresh');
//            redirect('404');
//        }
        $this->data['page_name'] = 'edit_payment';
        $this->data['page_title'] = 'Reports';
        $this->data['section'] = 'account';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $bill = $this->input->post('formdata');
        $id = $this->uri->segment(4);
        $this->data['data'] = $this->dbconnection->select('vw_voucher', '*', "BILL_GEN_NO='$bill'");
        $this->data['vw_ledger'] = $this->dbconnection->select('vw_ledger', '*', 'group_type="Bank Accounts" or group_type="Cash-in-Hand" ');
        $this->data['ledger'] = $this->dbconnection->select('ledger', '*', '');
        $this->load->view('index', $this->data);
    }

    public function ud_payment() {

        $temp = count($this->input->post('crdr'));
        $crd = $this->input->post('crdr');
        $par = $this->input->post('particulars');
        $amo = $this->input->post('amount');
        $voucher = $this->input->post('voucher_no');

        for ($i = 0; $i < $temp; $i++) {

            if ($i == 0) {
                $this->dbconnection->delete('voucher', 'bill_gen_no="' . $voucher . '"');
            }


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
                'module_name' => 'Payment',
                'voucher_type' => 'Payment',
                'bill_gen_no' => $voucher,
                'page_name' => 'edit_payment',
                'created_by' => $this->session->userdata('user_id'),
                'created_ip' => $_SERVER['REMOTE_ADDR'],
            );


            $this->dbconnection->insert('voucher', $data);
            $last_id = $this->db->insert_id();

//            $audit = array(
//                "action" => 'Add',
//                "module" => 'Group',
//                "page" => basename(__FILE__, '.php'),
//                'created_at' => date("Y-m-d H:i:s"),
//                'user_id' => $this->session->userdata('user_id'),
//                'remarks' => 'ID:' . $last_id,
//                'ip' => $_SERVER['REMOTE_ADDR']
//            );
//            $this->dbconnection->insert('auditntrail', $audit);
            $this->session->set_flashdata('successmsg', ' Successfully Updated ' . $last_id);
//echo json_encode(['error'=>array(),'success'=>'Y']);
        }
// $this->session->set_flashdata('form_payment', $voucher.   'Successfully Updated');
        redirect('account/Acc_ledger', 'refresh');
    }

    public function delt_ajax_return() {
        $id = $_POST['id'];
        $data = array(
            'BILL_GEN_NO' => $id,
        );
        $this->dbconnection->delete('voucher', $data);

//$this->session->set_flashdata('form_contra', $voucher.   'Successfully Deleted');
    }

    public function edit_receipt() {
        $this->data['page_name'] = 'edit_receipt';
        $this->data['page_title'] = 'Reports';
        $this->data['section'] = 'account';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $bill = $this->input->post('formdata');
        $id = $this->uri->segment(4);
        $this->data['data'] = $this->dbconnection->select('vw_voucher', '*', "BILL_GEN_NO='$bill'");
        $this->data['vw_ledger'] = $this->dbconnection->select('vw_ledger', '*', 'group_type="Bank Accounts" or group_type="Cash-in-Hand" ');
        $this->data['ledger'] = $this->dbconnection->select('ledger', '*', '');
        $this->load->view('index', $this->data);
    }

    public function ud_receipt() {

        $temp = count($this->input->post('crdr'));
        $crd = $this->input->post('crdr');
        $par = $this->input->post('particulars');
        $amo = $this->input->post('amount');
        $voucher = $this->input->post('voucher_no');
        for ($i = 0; $i < $temp; $i++) {
            if ($i == 0) {
                $this->dbconnection->delete('voucher', 'bill_gen_no="' . $voucher . '"');
            }
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
                'module_name' => 'Receipt',
                'voucher_type' => 'Receipt',
                'bill_gen_no' => $voucher,
                'page_name' => 'edit_receipt',
                'created_by' => $this->session->userdata('user_id'),
                'created_ip' => $_SERVER['REMOTE_ADDR'],
            );

            $this->dbconnection->insert('voucher', $data);
            $last_id = $this->db->insert_id();

//            $audit = array(
//                "action" => 'Add',
//                "module" => 'Group',
//                "page" => basename(__FILE__, '.php'),
//                'created_at' => date("Y-m-d H:i:s"),
//                'user_id' => $this->session->userdata('user_id'),
//                'remarks' => 'ID:' . $last_id,
//                'ip' => $_SERVER['REMOTE_ADDR']
//            );
//            $this->dbconnection->insert('auditntrail', $audit);
            $this->session->set_flashdata('successmsg', ' Successfully Updated ' . $last_id);
//echo json_encode(['error'=>array(),'success'=>'Y']);
        }
        redirect('account/Acc_ledger', 'refresh');
    }

    public function edit_journal() {
        $this->data['page_name'] = 'edit_journal';
        $this->data['page_title'] = 'Reports';
        $this->data['section'] = 'account';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $bill = $this->input->post('formdata');
        $id = $this->uri->segment(4);
        $this->data['data'] = $this->dbconnection->select('vw_voucher', '*', "BILL_GEN_NO='$bill'");
        $this->data['vw_ledger'] = $this->dbconnection->select('vw_ledger', '*', 'group_type="Bank Accounts" or group_type="Cash-in-Hand" ');
        $this->data['ledger'] = $this->dbconnection->select('ledger', '*', '');
        $this->load->view('index', $this->data);
    }

    public function ud_journal() {
        $temp = count($this->input->post('crdr'));
        $crd = $this->input->post('crdr');
        $par = $this->input->post('particulars');
        $amo = $this->input->post('amount');
        $voucher = $this->input->post('voucher_no');

        for ($i = 0; $i < $temp; $i++) {

            if ($i == 0) {
                $this->dbconnection->delete('voucher', 'bill_gen_no="' . $voucher . '"');
            }

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
                'module_name' => 'Journal',
                'voucher_type' => 'Journal',
                'bill_gen_no' => $voucher,
                'page_name' => 'edit_journal',
                'created_by' => $this->session->userdata('user_id'),
                'created_ip' => $_SERVER['REMOTE_ADDR'],
            );

            $this->dbconnection->insert('voucher', $data);
            $last_id = $this->db->insert_id();
//            $audit = array(
//                "action" => 'Add',
//                "module" => 'Group',
//                "page" => basename(__FILE__, '.php'),
//                'created_at' => date("Y-m-d H:i:s"),
//                'user_id' => $this->session->userdata('user_id'),
//                'remarks' => 'ID:' . $last_id,
//                'ip' => $_SERVER['REMOTE_ADDR']
//            );
//            $this->dbconnection->insert('auditntrail', $audit);
            $this->session->set_flashdata('successmsg', ' Successfully Updated ' . $last_id);
//echo json_encode(['error'=>array(),'success'=>'Y']);
        }
        redirect('account/Acc_ledger', 'refresh');
    }

    public function edit_contra() {
        $this->data['page_name'] = 'edit_contra';
        $this->data['page_title'] = 'Reports';
        $this->data['section'] = 'account';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $bill = $this->input->post('formdata');
        $id = $this->uri->segment(4);
        $this->data['data'] = $this->dbconnection->select('vw_voucher', '*', "BILL_GEN_NO='$bill'");
        $this->data['vw_ledger'] = $this->dbconnection->select('vw_ledger', '*', 'group_type="Bank Accounts" or group_type="Cash-in-Hand" ');
        $this->data['ledger'] = $this->dbconnection->select('ledger', '*', '');
        $this->load->view('index', $this->data);
    }

    public function ud_contra() {
        $temp = count($this->input->post('crdr'));
        $crd = $this->input->post('crdr');
        $par = $this->input->post('particulars');
        $amo = $this->input->post('amount');
        $voucher = $this->input->post('voucher_no');

        for ($i = 0; $i < $temp; $i++) {

            if ($i == 0) {
                $this->dbconnection->delete('voucher', 'bill_gen_no="' . $voucher . '"');
            }

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
                'module_name' => 'Contra',
                'voucher_type' => 'Contra',
                'bill_gen_no' => $voucher,
                'page_name' => 'edit_contra',
                'created_by' => $this->session->userdata('user_id'),
                'created_ip' => $_SERVER['REMOTE_ADDR'],
            );

            $this->dbconnection->insert('voucher', $data);
            $last_id = $this->db->insert_id();
//            $audit = array(
//                "action" => 'Add',
//                "module" => 'Group',
//                "page" => basename(__FILE__, '.php'),
//                'created_at' => date("Y-m-d H:i:s"),
//                'user_id' => $this->session->userdata('user_id'),
//                'remarks' => 'ID:' . $last_id,
//                'ip' => $_SERVER['REMOTE_ADDR']
//            );
//            $this->dbconnection->insert('auditntrail', $audit);
            $this->session->set_flashdata('successmsg', ' Successfully Updated ' . $last_id);
//echo json_encode(['error'=>array(),'success'=>'Y']);
        }
        redirect('account/Acc_ledger', 'refresh');
    }

    public function edit_debit_note() {
        $this->data['page_name'] = 'edit_debit_note';
        $this->data['page_title'] = 'Reports';
        $this->data['section'] = 'account';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $bill = $this->input->post('formdata');
        $id = $this->uri->segment(4);
        $this->data['data'] = $this->dbconnection->select('vw_voucher', '*', "BILL_GEN_NO='$bill'");
        $this->data['vw_ledger'] = $this->dbconnection->select('vw_ledger', '*', 'group_type="Bank Accounts" or group_type="Cash-in-Hand" ');
        $this->data['ledger'] = $this->dbconnection->select('ledger', '*', '');
        $this->load->view('index', $this->data);
    }

    public function ud_debit_note() {
        $temp = count($this->input->post('crdr'));
        $crd = $this->input->post('crdr');
        $par = $this->input->post('particulars');
        $amo = $this->input->post('amount');
        $voucher = $this->input->post('voucher_no');

        for ($i = 0; $i < $temp; $i++) {

            if ($i == 0) {
                $this->dbconnection->delete('voucher', 'bill_gen_no="' . $voucher . '"');
            }

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
                'module_name' => 'Debit Note',
                'voucher_type' => 'Debit Note',
                'bill_gen_no' => $voucher,
                'page_name' => 'edit_debit_note',
                'created_by' => $this->session->userdata('user_id'),
                'created_ip' => $_SERVER['REMOTE_ADDR'],
            );

            $this->dbconnection->insert('voucher', $data);
            $last_id = $this->db->insert_id();
//            $audit = array(
//                "action" => 'Add',
//                "module" => 'Group',
//                "page" => basename(__FILE__, '.php'),
//                'created_at' => date("Y-m-d H:i:s"),
//                'user_id' => $this->session->userdata('user_id'),
//                'remarks' => 'ID:' . $last_id,
//                'ip' => $_SERVER['REMOTE_ADDR']
//            );
//            $this->dbconnection->insert('auditntrail', $audit);
            $this->session->set_flashdata('successmsg', ' Successfully Updated ' . $last_id);
//echo json_encode(['error'=>array(),'success'=>'Y']);
        }
        redirect('account/Acc_ledger', 'refresh');
    }

    public function edit_credit_note() {
        $this->data['page_name'] = 'edit_credit_note';
        $this->data['page_title'] = 'Reports';
        $this->data['section'] = 'account';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $bill = $this->input->post('formdata');
        $id = $this->uri->segment(4);
        $this->data['data'] = $this->dbconnection->select('vw_voucher', '*', "BILL_GEN_NO='$bill'");
        $this->data['vw_ledger'] = $this->dbconnection->select('vw_ledger', '*', 'group_type="Bank Accounts" or group_type="Cash-in-Hand" ');
        $this->data['ledger'] = $this->dbconnection->select('ledger', '*', '');
        $this->load->view('index', $this->data);
    }

    public function ud_credit_note() {
        $temp = count($this->input->post('crdr'));
        $crd = $this->input->post('crdr');
        $par = $this->input->post('particulars');
        $amo = $this->input->post('amount');
        $voucher = $this->input->post('voucher_no');

        for ($i = 0; $i < $temp; $i++) {

            if ($i == 0) {
                $this->dbconnection->delete('voucher', 'bill_gen_no="' . $voucher . '"');
            }

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
//                "module" => 'Group',
//                "page" => basename(__FILE__, '.php'),
//                'created_at' => date("Y-m-d H:i:s"),
//                'user_id' => $this->session->userdata('user_id'),
//                'remarks' => 'ID:' . $last_id,
//                'ip' => $_SERVER['REMOTE_ADDR']
//            );
//            $this->dbconnection->insert('auditntrail', $audit);
            $this->session->set_flashdata('successmsg', ' Successfully Updated ' . $last_id);
//echo json_encode(['error'=>array(),'success'=>'Y']);
        }
        redirect('account/Acc_ledger', 'refresh');
    }

}
