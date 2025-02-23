<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ledger extends CI_Controller {

    public $page_code = 'ledger';
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
        $this->data['page_name'] = 'ledger';
        $this->data['page_title'] = 'Ledger';
        $this->data['section'] = 'account';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->data['state'] = $this->dbconnection->select("crmfeesclub.states", "*", "");
        $this->data['ledger_group'] = $this->dbconnection->select("ledger_group", "*", "");
        $this->data['ledger_detail'] = $this->dbconnection->select_join('ledger', 'ledger.*,ledger_group.group_name as name', 'ledger.status="Y" and ledger_group.status="Y"', 'ledger_group', 'ledger.under_group=ledger_group.id', 'left join');
        $this->load->view('index', $this->data);
    }

    public function save() {

        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        
        $this->form_validation->set_rules('ledger_name', 'Ledger Name', 'required|is_unique[ledger.ledger_name]');
        $this->form_validation->set_rules('under_group', 'Under Group Name', 'required');
        $this->form_validation->set_rules('email', 'Email');
        $this->form_validation->set_rules('phone', 'Phone');
        $this->form_validation->set_rules('address', 'Address');
        $this->form_validation->set_rules('city', 'City');
        $this->form_validation->set_rules('state', 'State');
        $this->form_validation->set_rules('zip_code', 'Zip Code');
        $this->form_validation->set_rules('uid_no', 'Aadhar');
        $this->form_validation->set_rules('pan_no', 'Pan No.');
        $this->form_validation->set_rules('bank_name', 'Bank Name');
        $this->form_validation->set_rules('account_number', 'Account No.');
        $this->form_validation->set_rules('cr_dr', 'Cr Dr');
        $this->form_validation->set_rules('opening_date', 'Opening Date');
        $this->form_validation->set_rules('opening_balance', 'Opening Amount');
        $this->form_validation->set_rules('credit_limit', 'Credit Limt');
        $this->form_validation->set_rules('credit_days', 'Credit Days');

        if ($this->form_validation->run() == FALSE) {
            $error = array
                (
                'ledger_name' => form_error('ledger_name'),
                'under_group' => form_error('under_group'),
                'email' => form_error('email'),
                'phone' => form_error('phone'),
                'city' => form_error('city'),
                'address' => form_error('address'),
                'state' => form_error('state'),
                'zip_code' => form_error('zip_code'),
                'uid' => form_error('uid'),
                'pan_no' => form_error('pan_no'),
                'bank_name' => form_error('bank_name'),
                'account_number' => form_error('account_number'),
                'cr_dr' => form_error('cr_dr'),
                'opening_date' => form_error('opening_date'),
                'opening_balance' => form_error('opening_balance'),
                'credit_limit' => form_error('credit_limit'),
                'credit_days' => form_error('credit_days'),
            );
            echo json_encode(['error' => $error, 'success' => 'N']);
        } else {

            $data = array(
                'ledger_name' => $this->input->post('ledger_name'),
                'under_group' => $this->input->post('under_group'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address'),
                'city' => $this->input->post('city'),
                'state' => $this->input->post('state'),
                'zip_code' => $this->input->post('zip_code'),
                'uid_no' => $this->input->post('uid_no'),
                'pan_no' => $this->input->post('pan_no'),
                'bank_name' => $this->input->post('bank_name'),
                'account_number' => $this->input->post('account_number'),
                'cr_dr' => $this->input->post('cr_dr'),
                'opening_date' => $this->input->post('opening_date'),
                'opening_balance' => $this->input->post('opening_balance'),
                'credit_limit' => $this->input->post('credit_limit'),
                'credit_days' => $this->input->post('credit_days'),
                'created_by' => $this->session->userdata('user_id'),
                'created_ip' => $_SERVER['REMOTE_ADDR'],
            );
//print_r($data);
            $this->dbconnection->insert('ledger', $data);
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
            $this->session->set_flashdata('successmsg', 'Ledger Added' . $last_id);
            echo json_encode(['error' => array(), 'success' => 'Y']);
        }
    }

    public function edit() {
        
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $id = $this->input->post('id');
        $ledger_name = $this->input->post('ledger_name');
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $phone = $this->input->post('phone');
        $address = $this->input->post('address');
        $city = $this->input->post('city');
        $state = $this->input->post('state');
        $zip_code = $this->input->post('zip_code');
        $uid_no = $this->input->post('uid_no');
        $pan_no = $this->input->post('pan_no');
        $bank_name = $this->input->post('bank_name');
        $account_number = $this->input->post('account_number');
        $opening_date = $this->input->post('opening_date');
        $cr_dr = $this->input->post('cr_dr');
        $opening_balance = $this->input->post('opening_balance');
        $credit_limit = $this->input->post('credit_limit');
        $credit_days = $this->input->post('credit_days');
        $state = $this->dbconnection->select('collegefclb.states', '*');
        $data = $this->dbconnection->select('ledger', '*', 'id=' . $id);
        $name = strtoupper($data[0]->ledger_name);
        $ledger_group = $this->dbconnection->select('ledger_group', '*', '');
        ?>
        <div class="form-group" style="width:90%;margin-left:5%;">
            <div class="row">
                <div class="col-md-6">
                    <label for="email">Ledger Name</label>
                    <input type="text" class="form-control" id="ledger_name_edt" name="ledger_name" value="<?php echo $ledger_name; ?>">
                </div>
                <div class="col-md-6">
                    <label for="email">Group Name</label>
                    <select class="form-control" name="under_group" id="under_group_edt">
                        <?php foreach ($ledger_group as $value_group) { ?>										
                            <option value="<?php echo $value_group->id; ?>"<?php if ($data[0]->under_group == $value_group->id) echo 'selected=selected'; ?>><?php echo $value_group->group_name; ?></option>
                        <?php } ?>
                    </select>                  

                </div>
            </div>
        </div>

        <div class="form-group" style="width:90%;margin-left:5%;">
            <div class="row">
                <div class="col-md-6">               
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email_edt" name="email" value="<?php echo $email; ?>">

                </div>
                <div class="col-md-6">               
                    <label for="email">Phone Number</label>
                    <input type="text" class="form-control" id="phone_edt" name="phone" value="<?php echo $phone; ?>">  
                </div>
            </div>
        </div>
        <div class="form-group" style="width:90%;margin-left:5%;">
            <label for="email">Address</label><br />
            <textarea type="text" class="form-control" id="address_edt" name="address"><?php echo $address; ?></textarea>
        </div>
        <div class="form-group" style="width:90%;margin-left:5%;">
            <div class="row">
                <div class="col-md-6">               
                    <label for="email">City</label>
                    <input type="text" class="form-control" id="city_edt" name="city" value="<?php echo $city; ?>">     
                </div>
                <div class="col-md-6">               
                    <label for="email">State</label>
                    <select class="form-control" name="state" id="state_edt">                     
                        <?php foreach ($state as $value_state) { ?>										
                            <option value="<?php echo $value_state->state_code; ?>"<?php if ($data[0]->state == $value_state->state_code) echo 'selected=selected'; ?>><?php echo $value_state->state_name; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group" style="width:90%;margin-left:5%;">
            <div class="row">
                <div class="col-md-6">               
                    <label for="email">Zip Code</label>
                    <input type="text" class="form-control" id="zip_code_edt" name="zip_code" value="<?php echo $zip_code; ?>">

                </div>
                <div class="col-md-6">               
                    <label for="email">Aadhar Number</label>
                    <input type="text" class="form-control" id="uid_no_edt" name="adhar" value="<?php echo $uid_no; ?>">

                </div>
            </div>
        </div>
        <div class="form-group" style="width:90%;margin-left:5%;">
            <div class="row">
                <div class="col-md-12">               
                    <label for="email">Pan No.</label>
                    <input type="text" class="form-control" id="pan_no_edt" name="pan_no" value="<?php echo $pan_no; ?>">


                </div>
            </div>
        </div> 
        <div class="form-group" style="width:90%;margin-left:5%;">
            <div class="row">
                <div class="col-md-12">               
                    <label for="email">Bank Name</label>
                    <input type="text" class="form-control" id="bank_name_edt" name="bank_name" value="<?php echo $bank_name; ?>">

                </div>
            </div>
        </div>

        <div class="form-group" style="width:90%;margin-left:5%;">
            <div class="row">
                <div class="col-md-6">               
                    <label for="email">Account No.</label>
                    <input type="text" class="form-control" id="account_number_edt" name="account_number" value="<?php echo $account_number; ?>">

                </div>
                <div class="col-md-6">               
                    <label for="email">Opening Date</label>
                    <input type="date" class="form-control" id="opening_date_edt" name="op_date" value="<?php echo $opening_date; ?>"> 

                </div>
            </div>
        </div>

        <div class="form-group" style="width:90%;margin-left:5%;">
            <div class="row">
                <div class="col-md-6">               
                    <label for="email">Opening Amount</label>
                    <select class='form-control' id="cr_dr_edt" name="cr_dr" required="">
                        <option value="<?php echo $cr_dr ?>"><?php echo $cr_dr; ?></option>
                        <option value="DR">DR</option>
                        <option value="CR">CR</option>
                    </select>         
                </div>
                <div class="col-md-6">
                    <label for="email"></label>
                    <input type="text" class="form-control" id="opening_balance_edt" name="op_amount" placeholder="Opening Amount" value="<?php echo $opening_balance; ?>">

                </div>
            </div>
        </div>
        <div class="form-group" style="width:90%;margin-left:5%;">
            <div class="row">
                <div class="col-md-6">               
                    <label for="email">Credit Limit</label>
                    <input type="text" class="form-control" id="credit_limit_edt" name="credit_limit" value="<?php echo $credit_limit; ?>">

                </div>
                <div class="col-md-6">
                    <label for="email">Credit Days</label>
                    <input type="text" class="form-control" id="credit_days_edt" name="credit_days" value="<?php echo $credit_days; ?>">

                </div>
            </div>
        </div>
        <input type="hidden" id="update_id" value="<?php echo $id; ?>">
        <?php
    }

    public function update() {
        
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $upd_id = $this->input->post('update_id');
        $newDateString = date('Y-m-d h:i:s');

        $field = array
            (
            'ledger_name' => $this->input->post('ledger_name_edt'),
            'under_group' => $this->input->post('under_group_edt'),
            'email' => $this->input->post('email_edt'),
            'phone' => $this->input->post('phone_edt'),
            'address' => $this->input->post('address_edt'),
            'city' => $this->input->post('city_edt'),
            'state' => $this->input->post('state_edt'),
            'zip_code' => $this->input->post('zip_code_edt'),
            'uid_no' => $this->input->post('uid_no_edt'),
            'pan_no' => $this->input->post('pan_no_edt'),
            'bank_name' => $this->input->post('bank_name_edt'),
            'account_number' => $this->input->post('account_number_edt'),
            'cr_dr' => $this->input->post('cr_dr_edt'),
            'opening_date' => $this->input->post('opening_date_edt'),
            'opening_balance' => $this->input->post('opening_balance_edt'),
            'credit_limit' => $this->input->post('credit_limit_edt'),
            'credit_days' => $this->input->post('credit_days_edt'),
            'last_modified_by' => $this->session->userdata('user_id'),
            'modified_ip' => $_SERVER['REMOTE_ADDR'],
        );

        $this->dbconnection->update('ledger', $field, 'id=' . $this->input->post('update_id'));

//        $audit = array(
//            "action" => 'Update',
//            "module" => 'Ledger',
//            "page" => basename(__FILE__, '.php'),
//            'created_at' => date("Y-m-d H:i:s"),
//            'user_id' => $this->session->userdata('user_id'),
//            'remarks' => 'ID:' . $upd_id,
//            'ip' => $_SERVER['REMOTE_ADDR']
//        );
//
//        $this->dbconnection->insert('auditntrail', $audit);
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
        $this->dbconnection->update('ledger', $field, 'id=' . $this->input->post('del_id'));
        $last_id = $this->db->insert_id();

//        $audit = array(
//            "action" => 'Delete',
//            "module" => 'Ledger',
//            "page" => basename(__FILE__, '.php'),
//            'created_at' => date("Y-m-d H:i:s"),
//            'user_id' => $this->session->userdata('user_id'),
//            'remarks' => 'ID:' . $this->input->post('del_id'),
//            'ip' => $_SERVER['REMOTE_ADDR']
//        );
//
//        $this->dbconnection->insert('auditntrail', $audit);
    }

}
