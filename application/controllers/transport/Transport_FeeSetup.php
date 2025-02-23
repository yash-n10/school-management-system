<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transport_FeeSetup extends CI_Controller {

    public function __construct() {

        parent::__construct();



        $link_code = 'Transport';

        $this->db->db_debug = TRUE;

        if (empty($this->session->userdata('user_group_id'))) {
            redirect(base_url(), 'refresh');
        }
        $accesspermission = $this->dbconnection->select('crmfeesclub.user_group_permission', 'permission', "status='Y' AND link_code='$link_code' AND user_group_id=" . $this->session->userdata('user_group_id'));

        $tt = $this->right_access = $this->right_access = (count($accesspermission) == 0 || empty($accesspermission[0]->permission)) ? '----' : $accesspermission[0]->permission;

        if ($this->right_access == 'CRUD') {
            redirect(base_url(), 'refresh');
        }

        $this->id = $this->session->userdata('school_id');
        $this->academic_session = array();
        $this->school_desc = $this->dbconnection->select("school", "*", "id=" . $this->id . " and status = 1");
        $this->schools = $this->dbconnection->select("school", "*", 'status = 1');
        $this->bank = $this->dbconnection->select("bank", "*");
        if ($this->id != 0) {
            $this->db->db_select('crmfeesclub_' . $this->id);
            $this->academic_session=$this->dbconnection->select("accedemic_session","max(id) as fin_year","active='Y'");
        }
        $this->page_title = 'Transport Fees Setup';
        $this->section = 'transport';
        $this->page_name = 'transport_feesetup';
        $this->customview = '';
    }

    public function index() {
        $this->data['page_name'] = $this->page_name;
        $this->data['page_title'] = $this->page_title;
        $this->data['section'] = $this->section;
        $this->data['customview'] = $this->customview;
        $this->data['class'] = $this->dbconnection->select('class','*','status="Y"'); 
        $this->data['month'] = $this->dbconnection->select('month','*','status="Y"'); 
        $this->data['setupdata']=$this->db->query('select t1.class_id,(select class_name from class where id=t1.class_id) as class_name,t1.month_id,(select month_name from month where id=t1.month_id) as month_name from transport_feesetup t1 where status="Y"')->result();
        $this->data['right_access'] = $this->right_access; 
        $this->load->view('index', $this->data);
    }

    public function save()
    {
        $class=$this->input->post('class_name');
        $month=$this->input->post('month');

        $data= array(
            'class_id' => $class, 
            'month_id' => $month, 
        );
        $this->dbconnection->insert('transport_feesetup',$data);
        $setupdata=$this->db->query('select t1.class_id,(select class_name from class where id=t1.class_id) as class_name, t1.month_id,(select month_name from month where id=t1.month_id) as month_name from transport_feesetup t1 where status="Y"')->result(); 
         // print_r($setupdata);die();?>
        
        <table class="table table-bordered table-striped" id="book_publisher">
                    <thead style="background:#99ceff;">
                        <tr>
                            <th>Sl No.</th>
                            <th>Class</th>
                            <th>Month</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $x = 1;foreach($setupdata as $value){?>
                        <tr>
                        <td><?php echo $x; ?></td>
                        <td><?php echo $value->class_name; ?></td>
                        <td><?php echo $value->month_name; ?></td>
                        </tr>
                         <?php $x++;}?>
                    </tbody>
                </table>
                 <script type="text/javascript">
            $(document).ready(function() {
              $('#book_publisher').DataTable();
            });
        </script>
    <?php }

   
}
