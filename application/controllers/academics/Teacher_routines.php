<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Teacher_routines extends CI_Controller {

    public $page_code = 'teacher_routine';
    public $page_id = '';
    public $page_perm = '----';

    public function __construct() {
        parent::__construct();

//print_r($this->session->userdata());
        $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");

        $this->id = $this->session->userdata('school_id');
        $this->school_desc = $this->dbconnection->select("school", "*", "id=" . $this->id . " and status = 1");
        $this->schools = $this->dbconnection->select("school", "*", 'status = 1');


        if ($this->id != 0)
            $this->db->db_select('crmfeesclub_' . $this->id);
        
        $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
        $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
        $this->right_access = $this->page_perm;

        if (strpos($this->page_perm, '----') == true) {
            redirect(base_url(''), 'refresh');
        }
        $this->page_title = 'Teacher Routine';
        $this->section = 'academic';
        $this->page_name = 'teacher_routines';
        $this->customview = '';
    }

    public function index() {
        
        if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->data['page_name'] = $this->page_name;
        $this->data['page_title'] = $this->page_title;
        $this->data['section'] = $this->section;
        $this->data['customview'] = $this->customview;
        /*
          $this->data['classes']=$this->dbconnection->select('class','*','status="Y"');
          $this->data['section1']=$this->dbconnection->select('section','*','status="Y"');
          $this->data['subjects']=$this->dbconnection->select('subject','*','status=1');
          $this->data['teacher']=$this->dbconnection->select('employee','*','status=1 and category_id=1');
         */

        $this->data['teacher'] = $this->dbconnection->select('employee', '*', 'status=1 and category_id=1');
        $this->data['period'] = $this->dbconnection->select('class_periods', '*', 'status=1', 'time_start');

        $this->load->view('index', $this->data);
    }

    public function todayroutine() {

        $tid = $this->session->userdata();

        $period = $this->dbconnection->select('class_periods', '*', 'status=1', 'time_start');
        ?>
        <table class="table table-striped table-bordered table-hover" cellspacing="0" cellpadding="0" border="2">
            <thead>
                <tr>
                    <th>Time<br/>Day</th>
                    <?php foreach ($period as $per_value) { ?>
                        <th><?php echo $per_value->name; ?><br/>(<?php echo $per_value->time_start; ?>:<?php echo $per_value->time_start_min; ?> - <?php echo $per_value->time_end; ?>:<?php echo $per_value->time_end_min; ?>)</th>
                    <?php } ?>
                </tr> 
            </thead>
            <tbody>
                <?php
                $d = date('w');
                if ($d == 0)
                    $day = 'sunday';
                else if ($d == 1)
                    $day = 'monday';
                else if ($d == 2)
                    $day = 'tuesday';
                else if ($d == 3)
                    $day = 'wednesday';
                else if ($d == 4)
                    $day = 'thursday';
                else if ($d == 5)
                    $day = 'friday';
                else if ($d == 6)
                    $day = 'saturday';

                $todaydate = date('Y-m-d');
                ?>				 
                <tr class="gradeA">
                    <td width="100"><?php echo strtoupper($day); ?></td>

                    <?php foreach ($period as $per_valu) { ?>
                        <td>
                            <?php
                            if ($day == 'sunday') {
                                echo 'Holiday';
                            } else {
                                $pid = $per_valu->id;
                                $tid = $this->input->post('tid');
                                $todaydate = date('Y-m-d');


                                $subteac = $this->dbconnection->GetSubsti($todaydate, $day, $tid);
                                $cc = count($subteac);
                                if ($cc > 0) {
                                    $periodid = $subteac->period_id;
                                    if ($periodid == $pid) {
                                        ?>
                                        <button class="btn btn-success" data-toggle="dropdown" style="width:100%;">
                                            <p><b>Class : </b><span><?php echo $subteac->class_name; ?></span></p> 
                                            <p><b>Section : </b><span><?php echo $subteac->sec_name; ?></span></p> 
                                            <p><b>Subject : </b><span><?php echo $subteac->name; ?></span></p> 
                                            <p><b>* </b><span>Assigned</span></p> 
                                        </button>
                                        <?php
                                    } else {
                                        
                                    }
                                } else {
                                    
                                }

                                $data = $this->dbconnection->GetTeacherData($pid, $day, $tid);
                                $countper = count($data);
                                if ($countper > 0) {
                                    $data->id;
                                    ?>
                                    <button class="btn btn-info" data-toggle="dropdown" style="width:100%;">
                                        <p><b>Class : </b><span><?php echo $data->class_name; ?></span></p> 
                                        <p><b>Section : </b><span><?php echo $data->sec_name; ?></span></p> 
                                        <p><b>Subject : </b><span><?php echo $data->name; ?></span></p> 
                                    </button>
                                    <?php
                                } else {
                                    
                                }
                            }
                            ?>
                        </td>

                    <?php } ?>
                </tr>
            </tbody>
        </table>
        <?php
    }

    public function view() {
        $period = $this->dbconnection->select('class_periods', '*', 'status=1', 'time_start');
        ?>
        <table cellpadding="0" cellspacing="0" border="2"  class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th>Time<br/>Day</th>
                    <?php foreach ($period as $per_value) { ?>
                        <th><?php echo $per_value->name; ?><br/>(<?php echo $per_value->time_start; ?>:<?php echo $per_value->time_start_min; ?> - <?php echo $per_value->time_end; ?>:<?php echo $per_value->time_end_min; ?>)</th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($d = 1; $d <= 7; $d++) {

                    if ($d == 1)
                        $day = 'sunday';
                    else if ($d == 2)
                        $day = 'monday';
                    else if ($d == 3)
                        $day = 'tuesday';
                    else if ($d == 4)
                        $day = 'wednesday';
                    else if ($d == 5)
                        $day = 'thursday';
                    else if ($d == 6)
                        $day = 'friday';
                    else if ($d == 7)
                        $day = 'saturday';
                    ?>

                    <tr class="gradeA">
                        <td width="100"><?php echo strtoupper($day); ?></td>
                        <?php foreach ($period as $per_valu) { ?>
                            <td>  
                                <?php
                                if ($day == 'sunday') {
                                    echo 'Holiday';
                                } else {
                                    ?>  

                                    <?php
                                    $pid = $per_valu->id;
                                    $tid = $this->input->post('tid');
                                    $data = $this->dbconnection->GetTeacherData($pid, $day, $tid);
                                    $countper = count($data);
                                    if ($countper > 0) {
                                        ?>
                                        <button class="btn btn-info" data-toggle="dropdown" style="width:100%;">

                                            <p><b>Class : </b><span><?php echo $data->class_name; ?></span></p> 
                                            <p><b>Section : </b><span><?php echo $data->sec_name; ?></span></p> 
                                            <p><b>Subject : </b><span><?php echo $data->name; ?></span></p>
                                        </button> 
                                        <?php
                                    } else {
                                        echo '--';
                                    }
                                }
                                ?>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <?php
    }

}
