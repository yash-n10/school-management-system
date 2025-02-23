<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Late_fine extends CI_Controller {
    
    public $page_code = 'late_fine';
    public $page_id = '';
    public $page_perm = '----';
    
    public function __construct() {
        parent::__construct();
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
        $this->data['page_name'] = 'late_fine_list';
        $this->data['page_title'] = 'Late Fine';
        $this->data['section'] = 'library';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->data['late_fine'] = $this->dbconnection->select("library_late_fine", "*", "status='Y'");
        $this->data['library'] = $this->dbconnection->select("library_card", "*", "status='Y'");
        $this->data['uqc'] = $this->dbconnection->select("crmfeesclub.uqc", "*", "");
        $this->load->view('index', $this->data);
    }

    public function add() {
        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->data['page_name'] = 'add_late_fine';
        $this->data['page_title'] = 'Add Late Fine';
        $this->data['section'] = 'library';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->data['books'] = $this->dbconnection->select("library_books", "*");
        $this->data['late_fine'] = $this->dbconnection->select("library_late_fine", "*", "status='Y'");
        $this->data['library'] = $this->dbconnection->select("library_card", "*", "status='Y'");
        $this->data['uqc'] = $this->dbconnection->select("crmfeesclub.uqc", "*", "");
        $this->load->view('index', $this->data);
    }

    public function save() {
        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $field = array(
            'late_fine' => $this->input->post('late_fine'),
            'date_created' => date("Y-m-d H:i:s"),
            'created_by' => $_SERVER['REMOTE_ADDR']
        );
        $this->dbconnection->insert('library_late_fine', $field);
        redirect('library/Late_fine');
    }

    public function edit() {
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $id = $this->input->post('id');
        $late_fine = $this->input->post('late_fine');
        ?>
        <form action='<?php echo base_url('library/Late_fine/update'); ?>' method='post'>
            <table class='table'>
                <tr>
                    <th>Late Fine</th>
                    <td><input type='text' name='late_fine' value='<?php echo $late_fine; ?>' class='form-control'></td>
                </tr>
                <input type='hidden' name='id' value='<?php echo $id; ?>'>
                <tr>
                    <td colspan='2' align='center'><input type='submit' class='btn btn-success btn-xs' value='Update'></td>
                </tr>
            </table>
        </form>  
        <?php
    }

    public function update() {
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $id = $this->input->post('id');

        $up_field = array(
            'late_fine' => $this->input->post('late_fine'),
            'last_date_modified' => date("Y-m-d H:i:s"),
            'last_modified_by' => $_SERVER['REMOTE_ADDR']
        );
        $this->dbconnection->update('library_late_fine', $up_field, "id = '$id'");
        redirect('library/Late_fine');
    }

    public function re_update() {
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $id = $this->input->post('tbl_idd');

        $up_field = array(
            'late_fine' => $this->input->post('tbl_late_fine'),
            'last_date_modified' => date("Y-m-d H:i:s"),
            'last_modified_by' => $_SERVER['REMOTE_ADDR']
        );

        $this->dbconnection->update('library_late_fine', $up_field, "id = '$id'");
        redirect('library/Late_fine');
    }

}
