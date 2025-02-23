<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase_order extends CI_Controller {
    
    public $page_code = 'purchase_order';
    public $page_id = '';
    public $page_perm = '----';
    
    public function __construct() {
        parent::__construct();
// $this->db->db_debug=TRUE;
//          error_reporting(-1);
//          ini_set('display_errors', 1);
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
        // $this->db->db_debug=TRUE;
        //  error_reporting(-1);
        //  ini_set('display_errors', 1);
        if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->load->model('Mymodel', 'm');
        $this->data['page_name'] = 'purchase_order';
        $this->data['page_title'] = 'Purchase Order';
        $this->data['section'] = 'inventory';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->data['vendor'] = $this->dbconnection->select("ledger", "*", "status='Y' AND under_group = 36");
        $this->data['pro'] = $this->dbconnection->select("product", "*", "status='Y'");
        $this->data['purchase_order'] = $this->m->purchase_order();
        // $this->data['uqc'] = $this->dbconnection->select("collegefclb.uqc", "*", "");
        $this->load->view('index', $this->data);
    }

    public function add() {
        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->load->model('Mymodel', 'm');
        $this->data['page_name'] = 'purchase_order_add';
        $this->data['page_title'] = 'Add';
        $this->data['section'] = 'inventory';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->data['vendor'] = $this->dbconnection->select("ledger", "*", "status='Y' AND under_group = 36");
        $this->data['pro'] = $this->dbconnection->select("product", "*", "status='Y'");
        $this->data['purchase_order'] = $this->dbconnection->select("purchase_order", "*", "status='Y'");
        $this->data['uqc'] = $this->dbconnection->select("crmfeesclub.uqc", "*", "");
        $this->load->view('index', $this->data);
    }

    public function save() {
        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        for ($i = 0; $i < count($this->input->post('pro')); $i++) {
            $field = array(
                'vendor' => $this->input->post('vendor'),
                'order_date' => $this->input->post('order_date'),
                'order_no' => 'ORD_' . time(),
                'product' => $this->input->post('pro')[$i],
                'uqc' => $this->input->post('uqc')[$i],
                'order_qty' => $this->input->post('qty')[$i],
                'received_qty' => 0,
                'bal_qty' => $this->input->post('qty')[$i],
                'date_created' => date("Y-m-d H:i:s"),
                'created_by' => $_SERVER['REMOTE_ADDR']
            );

            $this->dbconnection->insert('purchase_order', $field);
            $last_id = $this->db->insert_id();
        }

        $audit = array(
            "action" => 'Add',
            "module" => 'Purchase Order',
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
        $pro = $this->dbconnection->select("product", "*", "status='Y'");
        $uqc_tbl = $this->dbconnection->select("collegefclb.uqc", "*", "");
        $id = $this->input->post('id');
        $productt = $this->input->post('product');
        $uqc = $this->input->post('uqc');
        $qty = $this->input->post('qty');
        ?>
        <table class='table'>
            <tr>
                <th>Product</th>
                <td>
                    <select class='form-control' id="pro">
        <?php
        foreach ($pro as $product) {
            ?>
                            <option value="<?php echo $product->id; ?>" <?php if ($product->id == $productt) {
                echo "selected";
            } ?>><?php echo $product->product; ?></option>
        <?php } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>UQC</th>
                <td>
                    <select class="form-control" id="uqc">
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
                <td><input type="text" class='form-control' id="qty" value="<?php echo $qty; ?>"></td>
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
        $pro = $this->input->post('pro');
        $uqc = $this->input->post('uqc');
        $qty = $this->input->post('qty');
        $id = $this->input->post('id');
        $field = array(
            'product' => $pro,
            'uqc' => $uqc,
            'order_qty' => $qty
        );
        $this->dbconnection->update('purchase_order', $field, "id='$id'");
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
