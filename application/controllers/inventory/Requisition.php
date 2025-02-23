<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Requisition extends CI_Controller {
    
    public $page_code = 'requisition';
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
        $this->load->model('Mymodel', 'm');
        $this->data['page_name'] = 'requistion_list';
        $this->data['page_title'] = 'Requisition';
        $this->data['section'] = 'inventory';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->data['pro'] = $this->dbconnection->select("product", "*", "status='Y'");
        $this->data['employee'] = $this->dbconnection->select("employee", "*", "status='1'");
        $this->data['requisition'] = $this->m->requisition();
        $this->data['uqc'] = $this->dbconnection->select("crmfeesclub.uqc", "*", "");

        $this->load->view('index', $this->data);
    }

    public function add() {
        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->data['page_name'] = 'requisition_add';
        $this->data['page_title'] = 'Add';
        $this->data['section'] = 'inventory';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->data['pro'] = $this->dbconnection->select("product", "*", "status='Y'");
        $this->data['employee'] = $this->dbconnection->select("employee", "*", "status='1'");
        $this->data['uqc'] = $this->dbconnection->select("crmfeesclub.uqc", "*", "");

        $this->load->view('index', $this->data);
    }

    public function save() {
        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        for ($i = 0; $i < count($this->input->post('pro')); $i++) {
            $unq_no = 'REQ_' . time();
            $field = array(
                'req_no' => $unq_no,
                'staff_id' => $this->input->post('staff'),
                'pro_id' => $this->input->post('pro')[$i],
                'qty' => $this->input->post('qty')[$i],
                'balqty' => $this->input->post('qty')[$i],
                'uqc_id' => $this->input->post('uqc')[$i],
                'date_created' => date("Y-m-d H:i:s"),
                'created_by' => $_SERVER['REMOTE_ADDR']
            );

            $this->dbconnection->insert('requisition', $field);
            $last_id = $this->db->insert_id();
        }
        $audit = array(
            "action" => 'Add',
            "module" => 'Requisition',
            "page" => basename(__FILE__, '.php'),
            'created_at' => date("Y-m-d H:i:s"),
            'user_id' => $this->session->userdata('user_id'),
            'remarks' => 'ID:' . $last_id,
            'ip' => $_SERVER['REMOTE_ADDR']
        );

//$this->dbconnection->insert('auditntrail',$audit);	
    }

    public function edit() {
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $id = $this->input->post('id');
        $pro = $this->dbconnection->select("product", "*", "status='Y'");
        $uqc_tbl = $this->dbconnection->select("crmfeesclub.uqc", "*", "");
        $product = $this->input->post('product');
        $qty = $this->input->post('qty');
        $uqc = $this->input->post('uqc');
        ?>
        <table class="table">
            <tr>
                <th>Product</th>
                <td>
                    <select class="form-control" id="product">
        <?php
        foreach ($pro as $data) {
            ?>
                            <option value="<?php echo $data->id; ?>" <?php if ($data->id == $product) {
                echo "selected";
            } ?>><?php echo $data->product; ?></option>
                        <?php } ?>  
                    </select>
                </td>
            </tr>
            <tr>
                <th>UQC</th>
                <td>
                    <select class='form-control' id="uqc">
        <?php
        foreach ($uqc_tbl as $dt) {
            ?>
                            <option value="<?php echo $dt->id; ?>" <?php if ($dt->id == $uqc) {
                echo "selected";
            } ?>><?php echo $dt->name; ?></option>
                        <?php } ?>  
                    </select>
                </td>
            </tr>
            <tr>
                <th>Quantity</th>
                <td><input type="text" value="<?php echo $qty; ?>" class="form-control" id="qty"></td>
            </tr>
            <input type="hidden" id="id" value="<?php echo $id; ?>">
        </table>
        <?php
    }

    public function update() {
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $product = $this->input->post('product');
        $uqc = $this->input->post('uqc');
        $qty = $this->input->post('qty');
        $id = $this->input->post('id');

        $field = array(
            'pro_id' => $product,
            'qty' => $qty,
            'uqc_id' => $uqc
        );
        $this->dbconnection->update('requisition', $field, "id='$id'");
    }

    public function prouqc() {
        $proid = $this->input->post('proid');
        $prouqc = $this->m->prouqc($proid);

        $purchase_uqc = $prouqc[0]->purchase_uqc;
        $stock_uqc = $prouqc[0]->stock_uqc;
        $puruqc = $prouqc[0]->puruqc;
        $stkuqc = $prouqc[0]->stkuqc;
        if ($stock_uqc != '') {
            ?>
            <option value='<?php echo $purchase_uqc; ?>'><?php echo $puruqc; ?></option>
            <option value='<?php echo $stock_uqc; ?>'><?php echo $stkuqc; ?></option>
            <?php
        } else {
            ?>
            <option value='<?php echo $purchase_uqc; ?>'><?php echo $puruqc; ?></option>
            <?php
        }
    }

}
