<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_products extends CI_Controller {
    
    public $page_code = 'manage_products';
    public $page_id = '';
    public $page_perm = '----';
    
    public function __construct() {
        parent::__construct();

        $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");

// $accesspermission = $this->dbconnection->select('crmfeesclub.user_group_permission', 'permission', "status='Y' AND link_code='$link_code' AND user_group_id=".$this->session->userdata('user_group_id')); 
// $tt=$this->right_access= $this->right_access = (count($accesspermission)==0 || empty($accesspermission[0]->permission)) ? '----':$accesspermission[0]->permission;
// if($this->right_access=='----') {
// redirect(base_url(), 'refresh');
// }

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
        $this->data['page_name'] = 'manage_products_list';
        $this->data['page_title'] = 'Manage products';
        $this->data['section'] = 'inventory';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->data['gst_rate'] = $this->dbconnection->select("gst_rate", "*", "");
        $this->data['cat'] = $this->dbconnection->select("product_category", "*", "status='Y'");
        $this->data['grp'] = $this->dbconnection->select("product_group", "*", "status='Y'");
        $this->data['comp'] = $this->dbconnection->select("product_company", "*", "status='Y'");
        $this->data['uqc'] = $this->dbconnection->select("crmfeesclub.uqc", "*", "");

        $this->load->view('index', $this->data);
    }

    public function save() {
        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        if (!empty($this->input->post('save'))) {
            $this->form_validation->set_rules('cat', 'Category', 'required');
            $this->form_validation->set_rules('gst', 'GST Rate', 'required');
            if ($this->form_validation->run() == true) {
                $field = array(
                    'cat_name' => $this->input->post('cat'),
                    'gst_id' => $this->input->post('gst'),
                    'date_created' => date("Y-m-d H:i:s"),
                    'created_by' => $_SERVER['REMOTE_ADDR']
                );
                $this->dbconnection->insert('product_category', $field);
                $last_id = $this->db->insert_id();

                $audit = array(
                    "action" => 'Add',
                    "module" => 'Manage Product',
                    "page" => basename(__FILE__, '.php'),
                    'created_at' => date("Y-m-d H:i:s"),
                    'user_id' => $this->session->userdata('user_id'),
                    'remarks' => 'ID:' . $last_id,
                    'ip' => $_SERVER['REMOTE_ADDR']
                );

//$this->dbconnection->insert('auditntrail',$audit);
                redirect('inventory/manage_products');
            } else {
                $this->data['page_name'] = 'manage_products_list';
                $this->data['page_title'] = 'Manage products';
                $this->data['section'] = 'inventory';
                $this->data['customview'] = '';
                $this->data['right_access'] = $this->right_access;
                $this->data['state'] = $this->dbconnection->select("crmfeesclub.states", "*", "");
                $this->data['ledger'] = $this->dbconnection->select("ledger", "*", "");
                $this->data['gst_rate'] = $this->dbconnection->select("gst_rate", "*", "");
                $this->load->view('index', $this->data);
            }
        }
    }

    public function save_grop() {
        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->form_validation->set_rules('cat', 'Category', 'required');
        $this->form_validation->set_rules('group_name', 'Category', 'required');
        $resp = array();
        if ($this->form_validation->run() == true) {
            $field = array(
                'product_category_id' => $this->input->post('cat'),
                'group_name' => $this->input->post('group_name'),
                'date_created' => date("Y-m-d H:i:s"),
                'created_by' => $_SERVER['REMOTE_ADDR']
            );

            $this->dbconnection->insert('product_group', $field);
            $last_id = $this->db->insert_id();

            $audit = array(
                "action" => 'Add',
                "module" => 'Manage Product',
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
                'cat' => form_error('cat'),
                'group_name' => form_error('group_name')
            );
            $resp['success'] = 'N';
            $resp['error'] = $error;
            echo json_encode($resp);
        }
    }

    public function red() {
        if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->load->model('Mymodel', 'm');
        $this->data['page_name'] = 'cat_list';
        $this->data['page_title'] = 'Category List';
        $this->data['section'] = 'inventory';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->data['gst_rate'] = $this->dbconnection->select("gst_rate", "*", "");
        $this->data['pro_cat'] = $this->m->catData();

        $this->load->view('index', $this->data);
    }

    public function edit() {
        
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $id = $this->input->post('id');
        $cat = $this->input->post('cat');
        $code = $this->input->post('code');
        $gst_rate = $this->dbconnection->select("gst_rate", "*", "");
        ?>
        <table class='table'>
            <tr>
                <th>Category</th>
                <td><input type="text" class="form-control" value="<?php echo $cat; ?>" id="cat_edt"></td>
            </tr>
            <tr>
                <th>GST</th>
                <td>
                    <select class="form-control" id="gst_edt">
                        <option value="">Select</option>
        <?php
        if ($gst_rate) {
            foreach ($gst_rate as $rate) {
                ?>
                                <option value="<?php echo $rate->id; ?>" <?php if ($rate->id == $code) {
                    echo "selected";
                } ?>><?php echo $rate->gstrate_type; ?></option>
                <?php
            }
        }
        ?>
                    </select>
                    <input type="hidden" id="upd_id" value="<?php echo $id; ?>">
                </td>
            </tr>
        </table>
        <?php
    }

    public function update() {
        
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $newDateString = date('Y-m-d h:i:s');
        $upd_id = $this->input->post('upd_id');

        $field = array(
            'cat_name' => $this->input->post('cat_edt'),
            'gst_id' => $this->input->post('gst_edt'),
            'last_date_modified' => $newDateString,
            'last_modified_by' => $this->session->userdata('user_id'),
            'modified_ip' => $_SERVER['REMOTE_ADDR']
        );

        $this->dbconnection->update('product_category', $field, 'id=' . $upd_id);


        $audit = array(
            "action" => 'Update',
            "module" => 'Category',
            "page" => basename(__FILE__, '.php'),
            'created_at' => date("Y-m-d H:i:s"),
            'user_id' => $this->session->userdata('user_id'),
            'remarks' => 'ID:' . $upd_id,
            'ip' => $_SERVER['REMOTE_ADDR']
        );

//$this->dbconnection->insert('auditntrail',$audit);
    }

    public function del() {
        
        if (substr($this->right_access, 3, 1) != 'D') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $id = $this->input->post('id');
        $field = array(
            'status' => 'N'
        );
        if ($this->dbconnection->select('product', 'category', 'category=' . $id)) {
            echo "N";
        } else {
            $this->dbconnection->update('product_category', $field, 'id=' . $this->input->post('id'));
            $last_id = $this->db->insert_id();
        }

        $audit = array(
            "action" => 'Delete',
            "module" => 'Category',
            "page" => basename(__FILE__, '.php'),
            'created_at' => date("Y-m-d H:i:s"),
            'remarks' => 'ID:' . $this->input->post('id'),
            'ip' => $_SERVER['REMOTE_ADDR']
        );

//$this->dbconnection->insert('auditntrail',$audit);
    }

    public function group() {
        
        if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->load->model('Mymodel', 'm');
        $this->data['page_name'] = 'group_list';
        $this->data['page_title'] = 'Group List';
        $this->data['section'] = 'inventory';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->data['group'] = $this->m->grpData();

        $this->load->view('index', $this->data);
    }

    public function editgrp() {
        
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $id = $this->input->post('id');
        $cat_id = $this->input->post('cat_id');
        $grp = $this->input->post('grp');
        $cat = $this->dbconnection->select("product_category", "*", "");
        ?>
        <table class='table'>
            <tr>
                <th>Category</th>
                <td>
                    <select id="cat_edt" class="form-control">
                        <option value="">Select</option>
        <?php
        if ($cat) {
            foreach ($cat as $data) {
                ?>
                                <option value="<?php echo $data->id; ?>" <?php if ($data->id == $cat_id) {
                    echo "selected";
                } ?>><?php echo $data->cat_name; ?></option>
                <?php
            }
        }
        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Group Name</th>
                <td>
                    <input type="text" id="group_name_edt" class="form-control" value="<?php echo $grp; ?>">
                </td>
            </tr>
            <input type="text" id="upd_id" value="<?php echo $id; ?>">
        </table>
        <?php
    }

    public function updategrpp() {
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $newDateString = date('Y-m-d h:i:s');
        $upd_id = $this->input->post('upd_id');

        $field = array(
            'product_category_id' => $this->input->post('cat_edt'),
            'group_name' => $this->input->post('group_name_edt'),
            'last_date_modified' => $newDateString,
            'last_modified_by' => $this->session->userdata('user_id'),
            'modified_ip' => $_SERVER['REMOTE_ADDR']
        );

        $this->dbconnection->update('product_group', $field, 'id=' . $upd_id);


        $audit = array(
            "action" => 'Update',
            "module" => 'Group',
            "page" => basename(__FILE__, '.php'),
            'created_at' => date("Y-m-d H:i:s"),
            'user_id' => $this->session->userdata('user_id'),
            'remarks' => 'ID:' . $upd_id,
            'ip' => $_SERVER['REMOTE_ADDR']
        );

//$this->dbconnection->insert('auditntrail',$audit);
    }

    public function delgrp() {
        if (substr($this->right_access, 3, 1) != 'D') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $id = $this->input->post('id');
        $cat_id = $this->input->post('cat');
        $field = array(
            'status' => 'N'
        );

        if ($this->dbconnection->select('product', 'group', 'group=' . $id)) {
            echo "N";
        } else {
            $this->dbconnection->update('product_group', $field, 'id=' . $this->input->post('id'));
            $last_id = $this->db->insert_id();
        }

        $audit = array(
            "action" => 'Delete',
            "module" => 'Group',
            "page" => basename(__FILE__, '.php'),
            'created_at' => date("Y-m-d H:i:s"),
            'remarks' => 'ID:' . $this->input->post('id'),
            'ip' => $_SERVER['REMOTE_ADDR']
        );

//$this->dbconnection->insert('auditntrail',$audit);
    }

    function comp_save() {
        
        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->form_validation->set_rules('cat_comp', 'Category', 'required');
        $this->form_validation->set_rules('group_comp', 'Group', 'required');
        $this->form_validation->set_rules('company', 'Company', 'required');
        $resp = array();
        if ($this->form_validation->run() == true) {
            $field = array(
                'category_id' => $this->input->post('cat_comp'),
                'product_group_id' => $this->input->post('group_comp'),
                'com_name' => $this->input->post('company'),
                'date_created' => date("Y-m-d H:i:s"),
                'created_by' => $_SERVER['REMOTE_ADDR']
            );

            $this->dbconnection->insert('product_company', $field);
            $last_id = $this->db->insert_id();

            $audit = array(
                "action" => 'Add',
                "module" => 'Company',
                "page" => basename(__FILE__, '.php'),
                'created_at' => date("Y-m-d H:i:s"),
                'user_id' => $this->session->userdata('user_id'),
                'remarks' => 'ID:' . $last_id,
                'ip' => $_SERVER['REMOTE_ADDR']
            );

//$this->dbconnection->insert('auditntrail',$audit);

            $this->input->post('cat_comp');
            $resp['success'] = 'Y';
            $resp['error'] = array();
            echo json_encode($resp);
        } else {
            $error = array(
                'cat_comp' => form_error('cat_comp'),
                'group_comp' => form_error('group_comp'),
                'company' => form_error('company')
            );
            $resp['success'] = 'N';
            $resp['error'] = $error;
            echo json_encode($resp);
        }
    }

    public function company() {
        if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->load->model('Mymodel', 'm');
        $this->data['page_name'] = 'company_list';
        $this->data['page_title'] = 'Company List';
        $this->data['section'] = 'inventory';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;

        $this->data['comp'] = $this->m->compData();

        $this->load->view('index', $this->data);
    }

    public function comp_edit() {
        
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $id = $this->input->post('id');
        $cat = $this->input->post('cat');
        $group = $this->input->post('group');
        $comp = $this->input->post('comp');

        $catt = $this->dbconnection->select("product_category", "*", "");
        $grp = $this->dbconnection->select("product_group", "*", "");
        ?>
        <table class='table'>
            <tr>
                <th>Category</th>
                <td>
                    <select id="cat_comp_edt" class="form-control">
                        <option value="">Select</option>
        <?php
        if ($catt) {
            foreach ($catt as $data) {
                ?>
                                <option value="<?php echo $data->id; ?>" <?php if ($data->id == $cat) {
                    echo "selected";
                } ?>><?php echo $data->cat_name; ?></option>
                <?php
            }
        }
        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Group Name</th>
                <td>
                    <select id="group_comp_edt" class="form-control">
                        <option value="">Select</option>
        <?php
        if ($grp) {
            foreach ($grp as $data) {
                ?>
                                <option value="<?php echo $data->id; ?>" <?php if ($data->id == $group) {
                    echo "selected";
                } ?>><?php echo $data->group_name; ?></option>
                <?php
            }
        }
        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Company</th>
                <td><input type="text" value="<?php echo $comp; ?>" class="form-control" id="company_edt"></td>
            </tr>
            <input type="hidden" id="upd_id" value="<?php echo $id; ?>">
        </table>
                        <?php
                    }

                    public function updatecomp() {
                        
                            if (substr($this->right_access, 2, 1) != 'U') {
                    //            redirect(base_url(), 'refresh');
                                redirect('404');
                            }
                        $newDateString = date('Y-m-d h:i:s');
                        $upd_id = $this->input->post('upd_id');

                        $field = array(
                            'category_id' => $this->input->post('cat_comp_edt'),
                            'product_group_id' => $this->input->post('group_comp_edt'),
                            'com_name' => $this->input->post('company_edt'),
                            'last_date_modified' => $newDateString,
                            'last_modified_by' => $this->session->userdata('user_id'),
                            'modified_ip' => $_SERVER['REMOTE_ADDR']
                        );

                        $this->dbconnection->update('product_company', $field, 'id=' . $upd_id);


                        $audit = array(
                            "action" => 'Update',
                            "module" => 'Company',
                            "page" => basename(__FILE__, '.php'),
                            'created_at' => date("Y-m-d H:i:s"),
                            'user_id' => $this->session->userdata('user_id'),
                            'remarks' => 'ID:' . $upd_id,
                            'ip' => $_SERVER['REMOTE_ADDR']
                        );

//$this->dbconnection->insert('auditntrail',$audit);
                    }

                    public function delcomp() {
                        
                        if (substr($this->right_access, 3, 1) != 'D') {
                //            redirect(base_url(), 'refresh');
                            redirect('404');
                        }
                        $id = $this->input->post('id');
                        $cat_id = $this->input->post('cat_id');
                        $grp_id = $this->input->post('grp_id');

                        $field = array(
                            'status' => 'N'
                        );

                        if ($this->dbconnection->select('product', '*', 'category=' . $cat_id . ' AND group=' . $grp_id)) {
                            echo "N";
                        } else {
                            $this->dbconnection->update('product_company', $field, 'id=' . $id);
                            $last_id = $this->db->insert_id();
                        }

                        $audit = array(
                            "action" => 'Delete',
                            "module" => 'Company',
                            "page" => basename(__FILE__, '.php'),
                            'created_at' => date("Y-m-d H:i:s"),
                            'remarks' => 'ID:' . $this->input->post('id'),
                            'ip' => $_SERVER['REMOTE_ADDR']
                        );

//$this->dbconnection->insert('auditntrail',$audit);
                    }

                    public function pro_save() {
                        $this->load->model('Mymodel', 'm');
                        if (substr($this->right_access, 0, 1) != 'C') {
                //            redirect(base_url(), 'refresh');
                            redirect('404');
                        }
                        $this->form_validation->set_rules('pro_cat', 'Category', 'required');
                        $this->form_validation->set_rules('pur_uqc', 'Purchase UQC', 'required');
                        $this->form_validation->set_rules('pro_grp', 'Purchase UQC', 'required');
                        $this->form_validation->set_rules('pro_comp', 'Purchase UQC', 'required');
                        $this->form_validation->set_rules('pro', 'Purchase UQC', 'required');
                        $this->form_validation->set_rules('hsn', 'Purchase UQC', 'required');
                        $this->form_validation->set_rules('desc', 'Purchase UQC', 'required');
                        $this->form_validation->set_rules('gst_rate', 'Purchase UQC', 'required');
                        $this->form_validation->set_rules('qty_limit', 'Purchase UQC', 'required');
                        $this->form_validation->set_rules('tax_type', 'Purchase UQC', 'required');

                        $resp = array();

                        if ($this->form_validation->run() == true) {
                            $product = array(
                                'category' => $this->input->post('pro_cat'),
                                'purchase_uqc' => $this->input->post('pur_uqc'),
                                'group' => $this->input->post('pro_grp'),
                                'alternate_quc' => $this->input->post('rad'),
                                'company' => $this->input->post('pro_comp'),
                                'stock_uqc' => $this->input->post('stk_uqc'),
                                'product' => $this->input->post('pro'),
                                'purc_stock_equal' => $this->input->post('ult_sale'),
                                'hsn' => $this->input->post('hsn'),
                                'desc' => $this->input->post('desc'),
                                'gst_rate' => $this->input->post('gst_rate'),
                                'qty_limit' => $this->input->post('qty_limit'),
                                'tax_type' => $this->input->post('tax_type'),
                            	

                            	'batch'=>$this->input->post('batch'),
                            	'mgf_date'=>$this->input->post('mgf_date'),
                            	'exp_date'=>$this->input->post('exp_date'),
                            	'size'=>$this->input->post('size'),
                            	'color'=>$this->input->post('color'),
                            	
                                'date_created' => date("Y-m-d H:i:s"),
                                'created_by' => $_SERVER['REMOTE_ADDR']
                            );
                            $this->dbconnection->insert('product', $product);
                            $last_id = $this->db->insert_id();

                            $audit = array(
                                "action" => 'Add',
                                "module" => 'Product',
                                "page" => basename(__FILE__, '.php'),
                                'created_at' => date("Y-m-d H:i:s"),
                                'user_id' => $this->session->userdata('user_id'),
                                'remarks' => 'ID:' . $last_id,
                                'ip' => $_SERVER['REMOTE_ADDR']
                            );
//$this->dbconnection->insert('auditntrail',$audit);

                            $item_movement = array(
                                'trans_type' => 'OPENING',
                                'product_id' => $this->input->post('pro'),
                                'batch' => $this->input->post('batch'),
                                'exp_date' => $this->input->post('exp_date'),
                                'mfg_date' => $this->input->post('mfg_date'),
                                'size' => $this->input->post('size'),
                                'color' => $this->input->post('color'),
                                'opening_qty' => $this->input->post('op_qty'),
                                'in_qty' => 0,
                                'out_qty' => 0,
                                'qty' => $this->input->post('op_qty'),
                                'date_created' => date("Y-m-d H:i:s"),
                                'created_by' => $_SERVER['REMOTE_ADDR']
                            );
                            $this->dbconnection->insert('item_transaction_movement', $item_movement);

                            $stock = array(
                                'product_id' => $last_id,
                                'batch' => $this->input->post('batch'),
                                'mfg_date' => $this->input->post('mfg_date'),
                                'exp_date' => $this->input->post('exp_date'),
                                'size' => $this->input->post('size'),
                                'color' => $this->input->post('color'),
                                'actual_mrp' => $this->input->post('actual_mrp'),
                                'qty' => $this->input->post('op_qty'),
                                'price' => $this->input->post('price'),
                                'tax_price' => $this->input->post('tax_price'),
                                'qty' => $this->input->post('op_qty'),
                                'date_created' => date("Y-m-d H:i:s"),
                                'created_by' => $_SERVER['REMOTE_ADDR']
                            );
                            $this->dbconnection->insert('stock', $stock);


                            $resp['success'] = 'Y';
                            $resp['error'] = array();
                            echo json_encode($resp);
                        } else {
                            $error = array(
                                'pro_cat' => form_error('pro_cat'),
                                'pur_uqc' => form_error('pur_uqc'),
                                'pro_grp' => form_error('pro_grp'),
                                'pro_comp' => form_error('pro_comp'),
                                'pro' => form_error('pro'),
                                'hsn' => form_error('hsn'),
                                'desc' => form_error('desc'),
                                'gst_rate' => form_error('gst_rate'),
                                'qty_limit' => form_error('qty_limit'),
                                'tax_type' => form_error('tax_type')
                            );

                            $resp['success'] = 'N';
                            $resp['error'] = $error;
                            echo json_encode($resp);
                        }
                    }

                    public function product() {
                        
                        if (substr($this->right_access, 1, 1) != 'R') {
                //            redirect(base_url(), 'refresh');
                            redirect('404');
                        }
                        $this->load->model('Mymodel', 'm');
                        $this->data['page_name'] = 'product_list';
                        $this->data['page_title'] = 'Product';
                        $this->data['section'] = 'inventory';
                        $this->data['customview'] = '';
                        $this->data['right_access'] = $this->right_access;
                        $this->data['gst_rate'] = $this->dbconnection->select("gst_rate", "*", "");
                        $this->data['uqc'] = $this->dbconnection->select("crmfeesclub.uqc", "*", "");
                        $this->data['pro'] = $this->m->proData();
                        $this->load->view('index', $this->data);
                    }

                }
                