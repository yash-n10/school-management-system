<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vendors extends CI_Controller {
    
    public $page_code = 'vendors';
    public $page_id = '';
    public $page_perm = '----';
    
    public function __construct() {
        parent::__construct();


//         if(empty($this->session->userdata('user_group_id'))) {
//            redirect(base_url(), 'refresh');
//         }
//         $accesspermission = $this->dbconnection->select('collegefclb.user_group_permission', 'permission', "status='Y' AND link_code='$link_code' AND user_group_id=".$this->session->userdata('user_group_id')); 
//
//        $tt=$this->right_access= $this->right_access = (count($accesspermission)==0 || empty($accesspermission[0]->permission)) ? '----':$accesspermission[0]->permission;
//
//        if($this->right_access=='----') {
//            redirect(base_url(), 'refresh');
//         }

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
        $this->data['page_name'] = 'Vendors_list';
        $this->data['page_title'] = 'Vendor';
        $this->data['section'] = 'masters';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->data['state'] = $this->dbconnection->select("crmfeesclub.states", "*", "");
        $this->data['ledger'] = $this->dbconnection->select("ledger", "*", "under_group = 36");

        $this->load->view('index', $this->data);
    }

    public function save() {
        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->form_validation->set_rules('vendor_type', 'Vendor Type', 'required');
        $this->form_validation->set_rules('vendor_name', 'Vendor Name', 'required|alpha');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required|max_length[12]');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('zip_code', 'Zip Code', 'required');
        $this->form_validation->set_rules('adhaar_no', 'Addhar No.', 'required|max_length[12]');
        $this->form_validation->set_rules('pan_no', 'PAN No', 'required');
        $this->form_validation->set_rules('bank_name', 'Bank Name', 'required');
        $this->form_validation->set_rules('acc_no', 'Account No.', 'required');
        $this->form_validation->set_rules('op_date', 'Opening Date', 'required');
        $this->form_validation->set_rules('dr_cr', 'Opening Amount Type', 'required');
        $this->form_validation->set_rules('op_amt', 'Opening Amount', 'required|numeric');
        $this->form_validation->set_rules('credit_limit', 'Credit Limit', 'required|numeric');
        $this->form_validation->set_rules('credit_days', 'Credit days', 'required|numeric');
        $resp = array();
        if ($this->form_validation->run() == TRUE) {
            $field = array(
                'party_type' => $this->input->post('vendor_type'),
                'ledger_name' => $this->input->post('vendor_name'),
                'under_group' => 36,
                'b2b_type' => $this->input->post('b2b_type'),
                'gst_no' => $this->input->post('gstin'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'address' => $this->input->post('address'),
                'city' => $this->input->post('city'),
                'state' => $this->input->post('state'),
                'zip_code' => $this->input->post('zip_code'),
                'uid_no' => $this->input->post('adhaar_no'),
                'pan_no' => $this->input->post('pan_no'),
                'bank_name' => $this->input->post('bank_name'),
                'account_number' => $this->input->post('acc_no'),
                'opening_date' => $this->input->post('op_date'),
                'cr_dr' => $this->input->post('dr_cr'),
                'credit_limit' => $this->input->post('credit_limit'),
                'credit_days' => $this->input->post('credit_days'),
                'opening_balance' => $this->input->post('op_amt'),
                'date_created' => date("Y-m-d H:i:s"),
                'created_by' => $_SERVER['REMOTE_ADDR']
            );

            $this->dbconnection->insert('ledger', $field);
            $last_id = $this->db->insert_id();

//			$audit = array(
//			"action"=> 'Add',
//			"module" => 'Vendors',
//			"page" => basename(__FILE__, '.php'),
//			'created_at' => date("Y-m-d H:i:s"),
//			'user_id' => $this->session->userdata('user_id'),
//			'remarks' => 'ID:'.$last_id,
//			'ip' => $_SERVER['REMOTE_ADDR']
//			);
//			
//			
//			$this->dbconnection->insert('auditntrail',$audit);
            $this->session->set_flashdata('successmsg', 'Vendor added ' . $last_id);
            $resp['success'] = 'Y';
            $resp['error'] = array();
            echo json_encode($resp);
        } else {
            $error = array
                (
                'vendor_type' => form_error('vendor_type'),
                'vendor_name' => form_error('vendor_name'),
                'email' => form_error('email'),
                'phone' => form_error('phone'),
                'address' => form_error('address'),
                'city' => form_error('city'),
                'state' => form_error('state'),
                'zip_code' => form_error('zip_code'),
                'adhaar_no' => form_error('adhaar_no'),
                'pan_no' => form_error('pan_no'),
                'bank_name' => form_error('bank_name'),
                'acc_no' => form_error('acc_no'),
                'op_date' => form_error('op_date'),
                'dr_cr' => form_error('dr_cr'),
                'op_amt' => form_error('op_amt'),
                'credit_limit' => form_error('credit_limit'),
                'credit_days' => form_error('credit_days')
            );
            $resp['success'] = 'N';
            $resp['error'] = $error;
            echo json_encode($resp);
        }
    }

    public function edit() {
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $st = $this->dbconnection->select("collegefclb.states", "*", "");

        $upd_id = $this->input->post('id');
        $ledger_name = $this->input->post('ledger_name');
        $party_type = $this->input->post('party_type');
        $b2b_type = $this->input->post('b2b_type');
        $opening_date = $this->input->post('opening_date');
        $opening_balance = $this->input->post('opening_balance');
        $cr_dr = $this->input->post('cr_dr');
        $address = $this->input->post('address');
        $city = $this->input->post('city');
        $zip_code = $this->input->post('zip_code');
        $state = $this->input->post('state');
        $phone = $this->input->post('phone');
        $email = $this->input->post('email');
        $bank_name = $this->input->post('bank_name');
        $account_number = $this->input->post('account_number');
        $gst_no = $this->input->post('gst_no');
        $uid_no = $this->input->post('uid_no');
        $pan_no = $this->input->post('pan_no');
        $credit_limit = $this->input->post('credit_limit');
        $credit_days = $this->input->post('credit_days');
        ?>
        <div class="row">
            <div class="col-sm-6">
                <label>Vendor Type</label>
                <select class="form-control" id="vendor_type_edt">
                    <option value="">Select</option>
                    <option value="1" <?php if ($party_type == 1) {
            echo 'selected';
        } ?>>Registerd</option>
                    <option value="2" <?php if ($party_type == 2) {
            echo 'selected';
        } ?>>Unregistered</option>
                </select>
                <span id="error-vendor_type"></span>
            </div>
            <div class="col-sm-6">
                <label>Vendor Name</label>
                <input type="text" class="form-control" id="vendor_name_edt" value="<?php echo $ledger_name; ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <label>B2B Type</label>
                <select class="form-control" id="b2b_type_edt">
                    <option value="">Select</option>
                    <option value="1" <?php if ($b2b_type == 1) {
            echo 'selected';
        } ?>>Regular</option>
                    <option value="2" <?php if ($b2b_type == 2) {
            echo 'selected';
        } ?>>Composite</option>
                </select>
            </div>
            <div class="col-sm-6">
                <label>GSTIN</label>
                <input type="text" class="form-control" id="gstin_edt" value="<?php echo $gst_no; ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <label>Email</label>
                <input type="email" class="form-control" id="email_edt" value="<?php echo $email; ?>">
                <span id="error-email"></span>
            </div>
            <div class="col-sm-6">
                <label>Phone No.</label>
                <input type="text" class="form-control" id="phone_edt" value="<?php echo $phone; ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <label>Address</label>
                <textarea class="form-control" id="address_edt" rows='1'><?php echo $address; ?></textarea>
                <span id="error-address"></span>
            </div>
            <div class="col-sm-6">
                <label>City</label>
                <input type="text" class="form-control" id="city_edt" value="<?php echo $city; ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <label>State</label>
                <select class="form-control" id="state_edt">
                    <option value="">Select</option>
        <?php
        if ($st) {
            foreach ($st as $states) {
                ?>
                            <option value="<?php echo $states->id; ?>" <?php if ($states->id == $state) {
                    echo "selected";
                } ?>><?php echo $states->state_name; ?></option>
                            <?php
                        }
                    }
                    ?>
                </select>
                <span id="error-state"></span>
            </div>
            <div class="col-sm-6">
                <label>ZIP Code</label>
                <input type="text" class="form-control" id="zip_code_edt" value="<?php echo $zip_code; ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <label>Adhaar No</label>
                <input type="text" class="form-control" id="adhaar_no_edt" value="<?php echo $uid_no; ?>">
            </div>
            <div class="col-sm-6">
                <label>PAN No.</label>
                <input type="text" class="form-control" id="pan_no_edt" value="<?php echo $pan_no; ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <label>Bank Name</label>
                <input type="text" class="form-control" id="bank_name_edt" value="<?php echo $bank_name; ?>">
                <span id="error-bank_name"></span>
            </div>
            <div class="col-sm-6">
                <label>Account No.</label>
                <input type="text" class="form-control" id="acc_no_edt" value="<?php echo $account_number; ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <label>Opening Date</label>
                <input type="date" class="form-control" id="op_date_edt" value="<?php echo $opening_date; ?>">
            </div>
            <div class="col-sm-6">
                <label>Opening Amount</label>
                <div class="row">
                    <div class='col-sm-6'>
                        <select class='form-control' id="dr_cr_edt">
                            <option value="">Select</option>
                            <option value="DR" <?php if ($cr_dr == 'DR') {
                        echo "selected";
                    } ?>>DR</option>
                            <option value="CR" <?php if ($cr_dr == 'CR') {
                        echo "selected";
                    } ?>>CR</option>
                        </select>
                    </div>
                    <div class='col-sm-6'>
                        <input type="text" class="form-control" id="op_amt_edt" value="<?php echo $opening_balance; ?>">
                    </div>
                </div>
                <input type="hidden" id="upd_id" value="<?php echo $upd_id; ?>">
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <label>Credit Limit</label>
                <input type="text" class="form-control" value="<?php echo $credit_limit; ?>" id="credit_limit_edt">
                <span id="error-credit_limit"></span>
            </div>
            <div class="col-sm-6">
                <label>Credit Days</label>
                <input type="text" class="form-control" value="<?php echo $credit_days; ?>"id="credit_days_edt">
                <span id="error-credit_days"></span>
            </div>
        </div>
        <?php
    }

    public function update() {
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $upd_id = $this->input->post('upd_id');
        $newDateString = date('Y-m-d h:i:s');

        $field = array
            (
            'ledger_name' => $this->input->post('vendor_name_edt'),
            'party_type' => $this->input->post('vendor_type_edt'),
            'b2b_type' => $this->input->post('b2b_type_edt'),
            'opening_date' => $this->input->post('op_date_edt'),
            'opening_balance' => $this->input->post('op_amt_edt'),
            'cr_dr' => $this->input->post('dr_cr_edt'),
            'address' => $this->input->post('address_edt'),
            'city' => $this->input->post('city_edt'),
            'zip_code' => $this->input->post('zip_code_edt'),
            'state' => $this->input->post('state_edt'),
            'phone' => $this->input->post('phone_edt'),
            'email' => $this->input->post('email_edt'),
            'bank_name' => $this->input->post('bank_name_edt'),
            'account_number' => $this->input->post('acc_no_edt'),
            'gst_no' => $this->input->post('gstin_edt'),
            'uid_no' => $this->input->post('adhaar_no_edt'),
            'pan_no' => $this->input->post('pan_no_edt'),
            'credit_limit' => $this->input->post('credit_limit_edt'),
            'credit_days' => $this->input->post('credit_days_edt'),
            'last_date_modified' => $newDateString,
            'last_modified_by' => $this->session->userdata('user_id'),
            'modified_ip' => $_SERVER['REMOTE_ADDR']
        );

        $this->dbconnection->update('ledger', $field, 'id=' . $upd_id);


//		$audit = array(
//		"action"=> 'Update',
//		"module" => 'Vendors',
//		"page" => basename(__FILE__, '.php'),
//		'created_at' => date("Y-m-d H:i:s"),
//		'user_id' => $this->session->userdata('user_id'),
//		'remarks' => 'ID:'.$upd_id,
//		'ip' => $_SERVER['REMOTE_ADDR']
//		);
//		
//		$this->dbconnection->insert('auditntrail',$audit);
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

        $audit = array(
            "action" => 'Delete',
            "module" => 'Vendors',
            "page" => basename(__FILE__, '.php'),
            'created_at' => date("Y-m-d H:i:s"),
            'user_id' => $this->session->userdata('user_id'),
            'remarks' => 'ID:' . $this->input->post('del_id'),
            'ip' => $_SERVER['REMOTE_ADDR']
        );

        $this->dbconnection->insert('auditntrail', $audit);
    }

}
