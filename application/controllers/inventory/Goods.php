<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Goods extends CI_Controller {

    public $page_code = 'goods_grn';
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
        $this->data['page_name'] = 'goods_list';
        $this->data['page_title'] = 'Goods';
        $this->data['section'] = 'inventory';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->data['vendor'] = $this->dbconnection->select("ledger", "*", "status='Y' AND under_group = 36");
        $this->data['pro'] = $this->dbconnection->select("product", "*", "status='Y'");
        $this->data['uqc'] = $this->dbconnection->select("crmfeesclub.uqc", "*", "");
        $this->load->view('index', $this->data);
    }

    public function fet_order() {
        $vendor_id = $this->input->post('vendor_id');
        $this->load->model('Mymodel', 'm');
        $ord = $this->m->fetch_order($vendor_id);
        ?>
        <select class='form-control'>
            <option value="">Select</option>
        <?php
        if ($ord) {
            foreach ($ord as $data) {
                ?>     
                    <option value="<?php echo $data->order_no; ?>"><?php echo $data->order_no; ?></option>
                    <?php
                }
            }
            ?>
        </select>
            <?php
        }

        public function order() {
            $order_no = $this->input->post('ord_no');
            $this->load->model('Mymodel', 'm');
            $ord = $this->m->fetch_order_all($order_no);
            $voucher = $this->dbconnection->select('voucher_master', 'id,voucher_name,is_igst', 'voucher_group=5');
            $this->load->view('inventory/load_goods', array('voucher' => $voucher, 'ord' => $ord, 'order_no' => $order_no));
        }

        public function submit_grn() {
            
            if (substr($this->right_access, 0, 1) != 'C') {
    //            redirect(base_url(), 'refresh');
                redirect('404');
            }
            
            $this->form_validation->set_rules('inv_no', 'Invoice No', 'required');
            $this->form_validation->set_rules('recqty[]', 'Invoice No', 'required');
            $this->form_validation->set_rules('rate[]', 'Invoice No', 'required');
            $resp = array();
            if ($this->form_validation->run() == true) {
                for ($i = 0; $i < count($this->input->post('pro')); $i++) {
                    $upd_id = $this->input->post('upd_id')[$i];
                    $field = array(
                        'grn_no' => 'GRN_' . time(),
                        'vendor' => $this->input->post('vendor'),
                        'vw_ord' => $this->input->post('vw_ord'),
                        'inv_no' => $this->input->post('inv_no'),
                        'voucher_type' => $this->input->post('voucher_type'),
                        'discount_type' => $this->input->post('dic'),
                        'pro' => $this->input->post('pro')[$i],
                        'batch' => $this->input->post('batch')[$i],
                        'mfg_date' => $this->input->post('mfg_date')[$i],
                        'exp_date' => $this->input->post('exp_date')[$i],
                        'size' => $this->input->post('size')[$i],
                        'color' => $this->input->post('color')[$i],
                        'uqc' => $this->input->post('uqc')[$i],
                        'ordqty' => $this->input->post('ordqty')[$i],
                        'recqty' => $this->input->post('recqty')[$i],
                        'blnqty' => $this->input->post('blnqty')[$i],
                        'rate' => $this->input->post('rate')[$i],
                        'gstrate' => $this->input->post('gstrate')[$i],
                        'taxtype' => $this->input->post('taxtype')[$i],
                        'basicamt' => $this->input->post('basicamt')[$i],
                        'discount' => $this->input->post('discount')[$i],
                        'gstamt' => $this->input->post('gstamt')[$i],
                        'finalamt' => $this->input->post('finalamt')[$i],
                        'basictotal' => $this->input->post('basictotal'),
                        'gst_c' => $this->input->post('gst_c'),
                        'gst_s' => $this->input->post('gst_s'),
                        'gst_i' => $this->input->post('gst_i'),
                        'nettotal' => $this->input->post('nettotal'),
                        'date_created' => date("Y-m-d H:i:s"),
                        'created_by' => $_SERVER['REMOTE_ADDR']
                    );
                    $this->dbconnection->insert('GRN', $field);
                    $last_id = $this->db->insert_id();

                    $upd_field = array(
                        'received_qty' => $this->input->post('recqty')[$i] + $this->input->post('hidden_recqty')[$i],
                        'bal_qty' => $this->input->post('blnqty')[$i]
                    );
                    $this->dbconnection->update('purchase_order', $upd_field, 'id=' . $upd_id);

                    $pro = $this->input->post('pro')[$i];
                    $batch = $this->input->post('batch')[$i];
                    $mfg_date = $this->input->post('mfg_date')[$i];
                    $exp_date = $this->input->post('exp_date')[$i];
                    $size = $this->input->post('size')[$i];
                    $color = $this->input->post('color')[$i];

                    if ($qur = $this->dbconnection->select('stock', '*', "product_id=$pro && batch='$batch' && mfg_date='$mfg_date' && exp_date='$exp_date' && size='$size' && color='$color'")) {
                        $qtyy = $qur[0]->qty;
                        $up_field = array(
                            'qty' => $qtyy + $this->input->post('recqty')[$i]
                        );
                        $this->dbconnection->update('stock', $up_field, "product_id=$pro && batch='$batch' && mfg_date='$mfg_date' && exp_date='$exp_date' && size='$size' && color='$color'");
                    } else {
                        $stock_ins = array(
                            'product_id' => $this->input->post('pro')[$i],
                            'batch' => $this->input->post('batch')[$i],
                            'mfg_date' => $this->input->post('mfg_date')[$i],
                            'exp_date' => $this->input->post('exp_date')[$i],
                            'size' => $this->input->post('size')[$i],
                            'color' => $this->input->post('color')[$i],
                            'actual_mrp' => $this->input->post('finalamt')[$i],
                            'qty' => $this->input->post('recqty')[$i],
                            'price' => $this->input->post('rate')[$i],
                            'tax_price' => $this->input->post('gstamt')[$i]
                        );

                        $this->dbconnection->insert('stock', $stock_ins);
                    }
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


                $resp['success'] = 'Y';
                $resp['error'] = array();
                echo json_encode($resp);
            } else {
                $error = array(
                    'inv_no' => form_error('inv_no'),
                    'recqty' => form_error('recqty'),
                    'rate' => form_error('rate')
                );
                $resp['success'] = 'N';
                $resp['error'] = $error;
                echo json_encode($resp);
            }
        }

    }
    