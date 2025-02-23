<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group extends CI_Controller {
    
    public $page_code = 'group';
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
        $this->data['page_name'] = 'group';
        $this->data['page_title'] = 'Group';
        $this->data['section'] = 'account';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->data['group_detail'] = $this->dbconnection->select("ledger_group", "*", "");


        $this->load->view('index', $this->data);
    }

    public function save() {
        
        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->form_validation->set_rules('group_name', 'Group Name', 'required|is_unique[ledger_group.group_name]');
        $this->form_validation->set_rules('under_group', 'Group Name', 'required');
        $this->form_validation->set_rules('description', 'Group Name', 'required');
        if ($this->form_validation->run() == FALSE) {
            $error = array
                (
                'group_name' => form_error('group_name'),
                'under_group' => form_error('under_group'),
                'description' => form_error('description')
            );
            echo json_encode(['error' => $error, 'success' => 'N']);
        } else {
            $group_name = $this->input->post('group_name');
            $under_group = $this->input->post('under_group');
            $description = $this->input->post('description');
            $created_by = $this->session->userdata('user_id');
            $ledger_group = $this->dbconnection->select('ledger_group', '*', 'id=' . $under_group);
            $parent_group = $ledger_group[0]->parent_group;
            $parent_group_id = $ledger_group[0]->parent_group_id;
            $group_type = $ledger_group[0]->group_type;
            $under_group = $ledger_group[0]->group_name;

            $data = array(
                'group_name' => $group_name,
                'under_group' => $under_group,
                'description' => $description,
                'parent_group_id' => $parent_group_id,
                'parent_group' => $parent_group,
                'group_type' => $group_type,
                'created_by' => $this->session->userdata('user_id'),
                'created_ip' => $_SERVER['REMOTE_ADDR'],
            );


            $this->dbconnection->insert('ledger_group', $data);
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
            $this->session->set_flashdata('successmsg', 'Group Added ' . $last_id);
            echo json_encode(['error' => array(), 'success' => 'Y']);
//echo "success";	
        }
    }

    public function edit() {
        
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $id = $this->input->post('id');
        $group_name = $this->input->post('group_name');
        $under_group = $this->input->post('under_group');
        $description = $this->input->post('description');
        $created_by = $this->session->userdata('user_id');
        $grp_detail = $this->dbconnection->select('ledger_group', '*', 'id=' . $under_group);
// $parent_group=$ledger_group[0]->parent_group;
// $parent_group_id=$ledger_group[0]->parent_group_id;
// $group_type=$ledger_group[0]->group_type;
// $under_group=$ledger_group[0]->group_name;
        ?>
        <div class="form-group" style="width:90%;margin-left:5%;">
            <label for="email">Group Name</label>
            <input type="text" id="group_name_edt" class="form-control" value="<?php echo $group_name; ?>">
        </div>

        <div class="form-group" style="width:90%;margin-left:5%;">
            <label for="email">Under Group</label>
            <select class="form-control" name="under_group" id="under_group_edt">

                <?php foreach ($grp_detail as $group_value) { ?>										
                    <option value="<?php echo $group_value->id; ?>"<?php
                    if ($group_value->id == $under_group) {
                        echo "selected";
                    }
                    ?>> <?php echo $group_value->under_group; ?></option>
        <?php } ?>

            </select>

        </div>
        <input type="hidden" id="update_id" value="<?php echo $id; ?>">

        <div class="form-group" style="width:90%;margin-left:5%;">
            <label for="email">Description</label><br />
            <input type="text" id="description_edt" class="form-control" value="<?php echo $description; ?>">
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

        $data = array(
            'group_name' => $this->input->post('group_name_edt'),
            'under_group' => $this->input->post('under_group_edt'),
            'description' => $this->input->post('description_edt'),
            'parent_group_id' => $this->input->post('description_edt'),
            'parent_group' => $this->input->post('parent_group'),
            'group_type' => $this->input->post('group_type'),
            'updated_by' => $this->session->userdata('user_id'),
//'ent_by' => $ent_by,
//'date_modified' => $newDateString,
            'last_updated' => $this->session->userdata('user_id'),
        );
        $this->dbconnection->update('ledger_group', $data, 'id=' . $this->input->post('update_id'));

//        $audit = array(
//            "action" => 'Update',
//            "module" => 'Group',
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
        $this->dbconnection->update('ledger_group', $field, 'id=' . $this->input->post('del_id'));
        $last_id = $this->db->insert_id();

//        $audit = array(
//            "action" => 'Delete',
//            "module" => 'Group',
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
