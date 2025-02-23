<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Voucher_master extends CI_Controller {

    public $page_code = 'voucher_master';
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
        $this->data['page_name'] = 'voucher_master';
        $this->data['page_title'] = 'Voucher Master';
        $this->data['section'] = 'account';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->data['voucher_master'] = $this->dbconnection->select("voucher_master", '*', 'status="Y" ');
        $this->data['voucher_master_group'] = $this->dbconnection->select("voucher_master", '*', 'status="Y" and voucher_group="PRIMARY"');
        $this->data['voucher_group'] = $this->dbconnection->select('voucher_master', 'voucher_code', 'id');
        $this->load->view('index', $this->data);
    }

    public function save() {
        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->form_validation->set_rules('voucher_name', 'Voucher Name', 'trim|required|is_unique[voucher_master.voucher_name]');
        $this->form_validation->set_rules('voucher_group', 'Under Voucher Group', 'trim|required');
        $this->form_validation->set_rules('is_igst', 'IS IGST', 'trim|required');
//$created_by = $this->session->userdata('user_id');


        if ($this->form_validation->run() == FALSE) {
            $error = array(
                'voucher_name' => form_error('voucher_name'),
                'voucher_group' => form_error('voucher_group'),
                'is_igst' => form_error('is_igst'),
            );
            echo json_encode(['error' => $error, 'success' => 'N']);
        } else {
            if ($this->input->post('is_igst') == 'YES') {
                $status = 'NO';
            } else {
                $status = 'YES';
            }
            $data = array(
                'voucher_code' => strtoupper(str_replace(' ', '_', $this->input->post('voucher_name'))),
                'voucher_name' => ucwords($this->input->post('voucher_name')),
                'voucher_group' => $this->input->post('voucher_group'),
                'is_igst' => $this->input->post('is_igst'),
                'is_cgst' => $status,
                'is_sgst' => $status,
                'date_created' => date('Y-m-d H:i:s'),
                'created_by' => $this->session->userdata('user_id'),
                'created_ip' => $this->input->ip_address(),
            );
//print_r($data);
            $this->dbconnection->insert('voucher_master', $this->security->xss_clean($data));
            $id = $this->dbconnection->insert_id();
//            $audit = array(
//                "action" => 'Add',
//                "module" => 'Voucher Master',
//                "page" => basename(__FILE__, '.php'),
//                'created_at' => date("Y-m-d H:i:s"),
//                'user_id' => $this->session->userdata('user_id'),
//                'remarks' => 'ID:' . $last_id,
//                'ip' => $_SERVER['REMOTE_ADDR']
//            );
//            $this->dbconnection->insert('auditntrail', $audit);
            $this->session->set_flashdata('successmsg', 'Voucher Master Added ' . $last_id);
            echo json_encode(['error' => array(), 'success' => 'Y']);
        }
    }

    public function edit() {
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $id = $this->input->post('id');
        $voucher_name = $this->dbconnection->Get_namme('voucher_master', 'id', $id, 'voucher_name');
        $voucher_group = $this->dbconnection->Get_namme('voucher_master', 'id', $id, 'voucher_group');
        $is_igst = $this->dbconnection->Get_namme('voucher_master', 'id', $id, 'is_igst');
        $description = $this->input->post('description');
        ?>
        <div class="form-group" style="width:90%;margin-left:5%;">
            <label for="email">Voucher Name</label>
            <input type="text" id="voucher_name_edt" class="form-control" value="<?php echo $voucher_name; ?>">
        </div>

        <div class="form-group" style="width:90%;margin-left:5%;">
            <label for="email">Under Voucher Group</label>
            <input type="text" id="under_group_edt" class="form-control" value="<?php echo $voucher_group; ?>">
        </div>
        <input type="hidden" id="update_id" value="<?php echo $id; ?>">

        <div class="form-group" style="width:90%;margin-left:5%;">
            <label for="email">IS IGST?</label><br />
            <select name="is_igst" id="is_igst" class="form-control required">   

                <option value="">Select</option>
                <option value="YES">YES</option>
                <option value="NO">NO</option>
            </select>
        </div>
        <div class="form-group" style="width:90%;margin-left:5%;">
            <label for="email">IS CGST?</label><br />
            <select name="is_cgst" id="is_cgst" class="form-control required " style="pointer-events: none">
                <option value="">Select</option>
                <option value="YES">YES</option>
                <option value="NO">NO</option>
            </select>
        </div>
        <div class="form-group" style="width:90%;margin-left:5%;">
            <label for="email">IS SGST?</label><br />
            <select name="is_sgst" id="is_sgst" class="form-control required" style="pointer-events: none">
                <option value="">Select</option>
                <option value="YES">YES</option>
                <option value="NO">NO</option>
            </select>
        </div>

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
            'date_modified' => $newDateString,
            'modified_by' => $this->session->userdata('user_id'),
            'modified_ip' => $_SERVER['REMOTE_ADDR']
        );

        $this->dbconnection->update('voucher_master',$field,'id='.$this->input->post('update_id'));

//        $audit = array(
//            "action" => 'Update',
//            "module" => 'Voucher Master',
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
        $this->dbconnection->update('voucher_master', $field, 'id=' . $this->input->post('del_id'));
        $last_id = $this->db->insert_id();

//        $audit = array(
//            "action" => 'Delete',
//            "module" => 'Voucher Master',
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
