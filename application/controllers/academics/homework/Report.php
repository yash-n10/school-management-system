<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Report extends MY_ListController {

    public $page_code = '';
    public $page_id = '';
    public $page_perm = '----';

    public function __construct() {

        $this->page_code = 'assignment_report';
        parent::__construct();

//        switch ($this->session->userdata('login_type')) {
//            case 'appadmin':
//                $this->right_access = 'CRUD';
//                break;
//            case 'admin':
//                $this->right_access = 'CRUD';
//                break;
//            case 'principal':
//                $this->right_access = 'CR--';
//                break;
//            case 'teacher':
//                $this->right_access = '-R--';
//                break;
//            default:
//                $this->right_access = '----';
//                redirect(base_url(), 'refresh');
//        }
        $this->id = $this->session->userdata('school_id');


//        if ($this->id != 0)
//            $this->db->db_select('crmfeesclub_' . $this->id);
        $this->page_title = 'Assignment Report';
        $this->section = 'academic';
        $this->page_name = 'report';
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
        $this->data['cate'] = $this->dbconnection->select('assignment_category', 'name,id', 'status="Y"');
        $this->data['assig'] = $this->dbconnection->select('assignment', 'distinct(doa)', 'status="1"', 'doa');

        if ($this->session->userdata('login_type') == 'teacher') {
            $data = $this->dbconnection->select('user', '*', 'id=' . $this->session->userdata('user_id'));
            $tid = $data[0]->employee_id;
            $this->data['class'] = $this->dbconnection->select("class", "id,class_name", "id IN (SELECT class_id FROM class_subject_teacher WHERE teacher_id=$tid)");
        } else {
            $this->data['class'] = $this->dbconnection->select("class", "*", "status = 'Y'");
        }
        $this->load->view('index', $this->data);
    }

    public function GetSection() {
        $id = $this->input->post('id');
        if ($this->session->userdata('login_type') == 'teacher') {
            $data = $this->dbconnection->select('class', 'section', 'status="Y" and id=' . $id);
            $sec = $data[0]->section;
            $sectionfetch = explode("-", $sec);
            echo "<option value=''>--Select Section--</option>";
            foreach ($sectionfetch as $val) {
                $sec_name = $this->dbconnection->select("section", "*", "id=$val");
                foreach ($sec_name as $value) {
                    echo "<option value='$value->id'>$value->sec_name</option>";
                }
            }
        } else {
            $data = $this->dbconnection->select('class', 'section', 'status="Y" and id=' . $id);
            $sec = $data[0]->section;
            $sectionfetch = explode("-", $sec);
            echo "<option value=''>--Select Section--</option>";
            foreach ($sectionfetch as $val) {
                $sec_name = $this->dbconnection->select("section", "*", "id=$val");
                foreach ($sec_name as $value) {
                    echo "<option value='$value->id'>$value->sec_name</option>";
                }
            }
        }
    }

    public function GetSubjects() {
        $class_id = $this->input->post('clasid');
        $section_id = $this->input->post('sect');

        if ($this->session->userdata('login_type') == 'teacher') {
            $datass = $this->dbconnection->select('user', '*', 'id=' . $this->session->userdata('user_id'));
            $tid = $datass[0]->employee_id;

            // $sec_name = $this->dbconnection->select_join("class_subject_teacher as t1", "t2.*", "t1.status='1' AND t2.status = '1' AND t1.class_id=$class_id AND t1.section_id=$section_id AND t1.teacher_id=$tid", "subject as t2", "t1.subject_id=t2.id");
            $sec_name = $this->db->query("SELECT `t2`.* FROM `class_subject_teacher` as `t1` JOIN `subject` as `t2` ON `t1`.`subject_id`=`t2`.`id` WHERE `t1`.`status` = '1' AND `t2`.`status` = '1' AND `t1`.`class_id` = $class_id AND `t1`.`section_id` = $section_id AND `t1`.`teacher_id` = $tid group by t2.name")->result();
            // echo '<pre>';
            foreach ($sec_name as $key => $value) {
                // print_r($value);
                ?>
                <option value="">Select</option>
                <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                <?php
            }
        } else {
            // $data = $this->dbconnection->GetSubjectLists($class_id, $section_id
            $data = $this->dbconnection->select_join("class_subject_teacher as t1", "t2.*", "t1.status='1' AND t2.status = '1' AND t1.class_id=$class_id AND t1.section_id=$section_id ", "subject as t2", "t1.subject_id=t2.id");
                $count = count($data);
            if ($count > 0) {
                foreach ($data as $value) {
                    ?>
                    <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                    <?php
                }
            } else {
                echo "<option>No Subject Allocated to Class</option>";
            }
        }
    }

    public function GetDoa() {
         error_reporting(-1);
               ini_set('display_errors',1);
               $this->db->db_debug=TRUE;
        $class_id = $this->input->post('clasid');
        $section_id = $this->input->post('sect');
        $subject_id = $this->input->post('sub');
        // $cate = $this->input->post('cate');

        if ($this->session->userdata('login_type') == 'teacher') {

            $sec_name = $this->dbconnection->select('assignment', '*', 'class_id=' . $class_id . ' AND section_id=' . $section_id . ' AND subject_id=' . $subject_id . ' AND status=1');
            $count = count($sec_name);
            if ($count > 0) {
                foreach ($sec_name as $key => $value) {
                    ?>
                    <option value="<?php echo $value->doa; ?>"><?php echo $value->doa;?></option>

                    <?php
                }
            } else {
                echo '<option value="">No Homework Assigned</option>';
            }
        } else {
            $sec_name = $this->dbconnection->select('assignment', '*', 'class_id=' . $class_id . ' AND section_id=' . $section_id . ' AND subject_id=' . $subject_id . ' AND status=1');
            $count = count($sec_name);
            if ($count > 0) {
                foreach ($sec_name as $key => $value) {
                    ?>
                    <option value="<?php echo $value->date_created; ?>"><?php $date = $value->date_created;
                    echo $newDate = date("d-m-Y", strtotime($date));
                    ?></option>
                    <?php
                }
            } else {
                echo '<option value="">No Homework Assigned</option>';
            }
        }
    }

    public function GetData() {

        // $examnam = $this->input->post('examnam');
        $clas = $this->input->post('clas');
        $section = $this->input->post('section');
        $subject = $this->input->post('subject');
        $datesub = $this->input->post('datesub');

        $datas = $this->dbconnection->select('assignment', '*', 'class_id=' . $clas . ' AND section_id=' . $section . ' AND subject_id=' . $subject . ' AND doa = "' . $datesub . '" AND status=1');
        if (count($datas) > 0) {
            $hwid = $datas[0]->id;
        } else {
            $hwid = 0;
        }

        $checkdata = $this->dbconnection->select('assignment_report', '*', 'assignment_id=' . $hwid);
        $count = count($checkdata);


        $data = $this->dbconnection->select_homework($clas, $section, $subject, $datesub);
        // echo '<pre>';
        // print_r($data);
        if ($count > 0) {
            ?>
            <div class="table-responsive">
                <table id="templatelistss" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Admission No</th>
                            <th>Student name</th>
                            <th>Class</th>
                            <!-- <th>Title</th> -->
                            <th>D/O/S</th>
                            <th>Status</th>
                            <th>Answer</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($data as $value) {
                            $id = $value->id;
                            $st_id = $value->stid;
                            $c_data = $this->dbconnection->select('assignment_report', '*', 'assignment_id=' . $id . ' AND student_id = ' . $st_id . '');
                            $ans=$this->dbconnection->select('assignment_answer','*','assignment_id='.$id);
                            ?>
                            <tr>
                        <input type="hidden" value="<?php echo $c_data[0]->id; ?>" name="review_id[]">
                        <td><?php echo $value->admission_no; ?></td>
                        <td><?php echo $value->first_name; ?></td>
                        <td><?php echo $value->class_name; ?>&nbsp;-&nbsp;<?php echo $value->sec_name; ?></td>
                        <!-- <td><?php echo $value->title; ?></td> -->
                        <td><?php $date = $value->dos; echo $newDate = date("d-m-Y", strtotime($date));?></td>
                        <td>
                            <label class="radio-inline"><input name="report[<?php echo $c_data[0]->id; ?>]" id="repo<?php echo$value->stid; ?>" value="C" class="rad" type="radio"  <?php
                                $sts = $c_data[0]->assignment_status;
                                if ($sts == 'C') {
                                   echo 'checked="checked"';
                                } else {
                                       
                                }
                                ?>>DONE
                            </label>
                            <label class="radio-inline"><input name="report[<?php echo $c_data[0]->id; ?>]" id="repo<?php echo$value->stid; ?>" value="N" class="rad" type="radio" <?php
                                $sts = $c_data[0]->assignment_status;
                                if ($sts == 'N') {
                                    echo 'checked="checked"';
                                } else {
                    
                                }
                                ?>>NOT DONE
                            </label>
                        </td>
                         <?php if($ans[0]->homework_status=='SUBMITTED') { ?>
                           <td><span><a class="btn" href="<?php echo base_url()?>homework/answer/<?php echo $ans[0]->homework_upload;?>" target="_blank">View Answer</a></span></td>
                            
                        <?php } else{ ?>
                        <td><button class="btn btn-danger">Not Submitted</button></td>
                    <?php } ?>
                        <td><textarea name="rem[]" id="rem_<?php echo $value->stid; ?>" class="form-control"><?php echo $c_data[0]->remarks; ?></textarea></td>

                        </tr>
            <?php } ?>


                    </tbody>
                </table>
            </div>

            <div class="box-body" id="ddd">
                <div class="col-lg-12" style="text-align: center;">
                    <a class="btn btn-success" id="update_report" onclick="update_report()">Update Assignment Report</a> 
                </div>
            </div> 

            <?php
        } else {
            ?>
            <div class="table-responsive">
                <table id="templatelistss" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Admission No</th>
                            <th>Student name</th>
                            <th>Class</th>
                            <!-- <th>Title</th> -->
                            <th>D/O/S</th>
                            <th>Status</th>
                            <th>Answer</th>
                            <th>Remarks</th>

                        </tr>
                    </thead>
                    <tbody>
            <?php foreach ($data as $value) { ?>
                            <tr>
                                <td><?php echo $value->admission_no; ?></td>
                                <td><?php echo $value->first_name; ?></td>
                                <td><?php echo $value->class_name; ?>&nbsp;-&nbsp;<?php echo $value->sec_name; ?></td>
                                <!-- <td><?php echo $value->title; ?></td> -->
                                <td><?php $date = $value->dos;
                echo $newDate = date("d-m-Y", strtotime($date));
                ?></td>
                                <td>
                                    <label class="radio-inline"><input name="report[<?php echo $value->stid; ?>]" id="repo<?php echo $value->stid; ?>" value="C" class="rad" type="radio">DONE</label>
                                    <label class="radio-inline"><input name="report[<?php echo $value->stid; ?>]" id="repo<?php echo $value->stid; ?>" value="N" class="rad" checked="checked" type="radio">NOT DONE</label>
                                </td>
                                <?php if($value->homework_status=='SUBMITTED') { ?>
                                <td><span><a class="btn" href="<?php echo base_url()?>homework/answer/<?php echo $value->homework_upload;?>" target="_blank">View Answer</a></span></td>                            
                                <?php } else{ ?>
                                <td><button class="btn btn-danger">Not Submitted</button></td>
                            <?php } ?>
                                <td><textarea name="rem[]" class="form-control"></textarea></td>

                            </tr>
            <?php } ?>


                    </tbody>
                </table>
            </div>

            <div class="box-body" id="ddd">
                <div class="col-lg-12" style="text-align: center;">
                    <a class="btn btn-success" id="save_reportss" onclick="save_reportss()">Save Assignment Report</a> 
                </div>
            </div> 
            <?php
        }
    }

    function save_stud_report() {

        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $student = $this->input->post();
        // $category = $this->input->post('examname');
        $class = $this->input->post('class');
        $section = $this->input->post('section');
        $subject = $this->input->post('subject');
        $doa = $this->input->post('datesub');

        $data = $this->dbconnection->select('assignment', '*', 'class_id=' . $class . ' AND section_id=' . $section . ' AND subject_id=' . $subject . ' AND date_created = "' . $doa . '" AND status=1');
        $hwid = $data[0]->id;
        $i = 0;
        foreach ($student['report'] as $val => $r) {

            $data = array(
                'assignment_id' => $hwid,
                // 'assi_category_id' => $category,
                'student_id' => $val,
                'remarks' => $student['rem'][$i],
                'assignment_status' => $r,
            );
            $i++;
            $this->dbconnection->insert("assignment_report", $data);

            $lastid = $this->dbconnection->get_last_id();
            $audit = array("action" => 'Add Assignment Report',
                "module" => $this->uri->segment(1),
                "page" => basename(__FILE__, '.php'),
                'datetime' => date("Y-m-d H:i:s"),
                'userid' => $this->session->userdata('user_id'),
                'remarks' => 'ID:' . $lastid,
                'ip_address' => '',
            );
            $this->dbconnection->insert("auditntrail", $audit);
            echo 1;
        }
    }

    public function update_stud_report() {

        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }

        $student = $this->input->post();
        $i = 0;
        foreach ($student['review_id'] as $val => $r) {
            $id = $r;

            $data = array(
                'remarks' => $student['rem'][$i],
                'assignment_status' => $student['report'][$r],
            );
            $this->dbconnection->update("assignment_report", $data, array('id' => $r));

            $audit = array("action" => 'Update Assignment Report',
                "module" => $this->uri->segment(1),
                "page" => basename(__FILE__, '.php'),
                'datetime' => date("Y-m-d H:i:s"),
                'userid' => $this->session->userdata('user_id'),
                'remarks' => 'ID:' . $id,
                'ip_address' => '',
            );
            $this->dbconnection->insert("auditntrail", $audit);

            $i++;
        }
    }

}
