<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_issue extends CI_Controller {
    
    public $page_code = 'stock_issue';
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

        $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y' and active='Y'", '', '', array('id'));
    }

    public function index() {
        if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->data['page_name'] = 'stock_issue_list';
        $this->data['page_title'] = 'Stock issue';
        $this->data['section'] = 'inventory';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->data['employee'] = $this->dbconnection->select("employee", "*", "status='1'");
        $this->data['pro'] = $this->dbconnection->select("product", "*", "status='Y'");
        $this->data['uqc'] = $this->dbconnection->select("crmfeesclub.uqc", "*", "");
        $this->load->view('index', $this->data);
    }

    public function fetorder() {
        $this->load->model('Mymodel', 'm');
        $staff_id = $this->input->post('staff_id');
        $order = $this->m->fetorder($staff_id);
        ?>
        <select class='form-control' name='req_no'>
            <option value=''>Select</option>
        <?php
        if ($order) {
            foreach ($order as $data) {
                ?>
                    <option value='<?php echo $data->req_no; ?>'><?php echo $data->req_no; ?></option>
                <?php
            }
        }
        ?>
        </select>
            <?php
        }

        public function fetpro() {
            $this->load->model('Mymodel', 'm');
            $staff_id = $this->input->post('staff_id');
            $req_no = $this->input->post('req_no');
            $product = $this->m->getpro($staff_id, $req_no);
            $this->load->view('inventory/load_fetchpro', array('product' => $product));
        }

        public function fetchbatch() {
            $this->load->model('Mymodel', 'm');
            $proid = $this->input->post('proid');
            $id = $this->input->post('id');
            $batch = $this->m->getfetchBatch($proid);
            ?>
        <div class='container'>
            <div class='row'>
        <?php
        if ($batch) {
            foreach ($batch as $data) {
                ?>
                        <input type="checkbox" value="<?php echo $data->batch; ?>" onclick="chkbatch(this.value, '<?php echo $id; ?>',<?php echo $data->qty; ?>,<?php echo $data->id; ?>)"> <label><?php echo $data->batch; ?> &nbsp;&nbsp;(<?php echo $data->qty; ?>)</label><br />
                <?php
            }
        }
        ?>
            </div>
        </div>
                <?php
            }

            public function pro_bat() {
                $proid = $this->input->post('proid');
                $batch = $this->input->post('batch');
                $tblid = $this->input->post('tblid');

                $pro_bat = $this->dbconnection->select('stock', 'price', "product_id='$proid' AND batch = '$batch' AND id = '$tblid'");
                echo $price = $pro_bat[0]->price;
            }

            public function issue() {
                if (substr($this->right_access, 0, 1) != 'C' || substr($this->right_access, 2, 1) != 'U') {
        //            redirect(base_url(), 'refresh');
                    redirect('404');
                }
                for ($i = 0; $i < count($this->input->post('pro')); $i++) {
                    $upd_id = $this->input->post('upd_id')[$i];
                    $pro = $this->input->post('pro')[$i];
                    $batch = $this->input->post('batch')[$i];
                    $tblid = $this->input->post('tblid')[$i];

                    $stock = $this->dbconnection->select('stock', 'qty', "id='$tblid'");
                    $qtyy = $stock[0]->qty;
                    $qt = $this->input->post('qty')[$i];
                    $newvar = $qtyy - $qt;

                    $up_field = array(
                        'qty' => $newvar
                    );
                    $this->dbconnection->update('stock', $up_field, "id='$tblid'");


                    $requisition = $this->dbconnection->select('requisition', 'balqty', "id='$upd_id'");
                    $balqty = $requisition[0]->balqty;
                    $nwvr = $balqty - $qt;
                    $req_update = array(
                        'balqty' => $nwvr
                    );

                    $this->dbconnection->update('requisition', $req_update, "id='$upd_id'");

                    $issued_product = array(
                        'staff' => $this->input->post('staff'),
                        'req_no' => $this->input->post('req_no'),
                        'product' => $this->input->post('pro')[$i],
                        'batch' => $this->input->post('batch')[$i],
                        'order_qty' => $this->input->post('ordqty')[$i],
                        'rec_qty' => $this->input->post('qty')[$i],
                        'rest_qty' => $this->input->post('restqty')[$i],
                        'uqc' => $this->input->post('quc')[$i],
                        'amt' => $this->input->post('price')[$i],
                        'tot_amt' => $this->input->post('total_price')[$i],
                    );
                    $this->dbconnection->insert('product_issued', $issued_product);
                }
            }

        }
        