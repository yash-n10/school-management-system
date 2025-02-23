<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marks extends CI_Controller {

    public $page_code = 'marks';
    public $page_id = '';
    public $page_perm = '----';

    public function __construct() {
        parent::__construct();

        $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");
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
        $this->page_title = 'Student Marks';
        $this->section = 'academic';
        $this->page_name = 'marks';
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
        $this->data['right_access']  = $this->right_access;

        $this->data['examination'] = $this->dbconnection->select("exam", "*", "status = 1");
        if ($this->session->userdata('login_type') == 'teacher') {
            $data = $this->dbconnection->select('user', '*', 'id=' . $this->session->userdata('user_id'));
            $tid = $data[0]->employee_id;
//	    	$this->data['class']=$this->dbconnection->select_class($tid);
            $this->data['class'] = $this->dbconnection->select("class", "id,class_name", "id IN(SELECT class_id FROM class_subject_teacher WHERE teacher_id=$tid)");
        } else {
            $this->data['class'] = $this->dbconnection->select("class", "*", "status = 'Y'");
        }


        $this->load->view('index', $this->data);
    }

    public function GetSection() {
        $id = $this->input->post('id');
        if ($this->session->userdata('login_type') == 'teacher') {
            $datass = $this->dbconnection->select('user', '*', 'id=' . $this->session->userdata('user_id'));
            $tid = $datass[0]->employee_id;

            $sec_name = $this->dbconnection->select_join("class_subject_teacher as t1", "t2.*", "t2.status = 'Y' AND t1.class_id=$id AND t1.teacher_id=$tid AND t1.status='1'", "section as t2", "t1.section_id=t2.id");
            echo "<option value=''>--Select ---</option>";
            foreach ($sec_name as $value) {
                echo "<option value='$value->id'>$value->sec_name</option>";
            }
        } else {
            $data = $this->dbconnection->select('class', 'section', 'status="Y" and id=' . $id);

            $sec = $data[0]->section;
            $sectionfetch = explode("-", $sec);
            echo "<option value=''>--Select ---</option>";
            foreach ($sectionfetch as $val) {
                $sec_name = $this->dbconnection->select("section", "*", "id=$val");
                foreach ($sec_name as $value) {
                    echo "<option value='$value->id'>$value->sec_name</option>";
                }
            }
        }
    }

    public function GetAddData() {
        echo $exam = $this->input->post('exam');
        $clas = $this->input->post('clas');
        $sect = $this->input->post('sect');
        $subj = $this->input->post('subj');
        $datas = $this->dbconnection->selectStudentData($exam, $clas, $sect, $subj);
        ?>	
        <div class="table-responsive">
            <table id="templatelistss" class="table table-bordered table-striped" style="height: 400px;overflow-y: auto;">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Admission No</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Student name</th>
                        <th>Mark Obtained</th>
                        <th>Total Marks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 0;
                    foreach ($datas as $key => $value) {
                        $count++;
                        ?>
                        <tr>
                            <td class="sorting_1"><?php echo $count; ?></td>
                            <td><?php echo $value['admission_no']; ?></td>
                            <td><?php echo $value['class_name']; ?></td>
                            <td><?php echo $value['sec_name']; ?></td>
                            <td><?php echo $value['first_name']; ?></td>
                            <td><input type="number" id="markobt" name="user_input[]" style="width:100%;" required="" value="0" min="0" max="<?php echo $value['grand_total']; ?>">
                                
                                <input type="hidden" id="stid_<?php echo $count; ?>" value="<?php echo $value['sid']; ?>" name="student[]">
                                <input type="hidden" id="grand_total" name="grand_total" value="<?php echo $value['grand_total']; ?>">
                            </td>
                            <td><?php echo $value['grand_total']; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php
    }
    
    
        public function GetAddDataTerm() {
         $exam = $this->input->post('exam');
         $clas = $this->input->post('clas');
         $sect = $this->input->post('sect');
         $subj = $this->input->post('subj');
        $datas = $this->dbconnection->selectStudentData($exam, $clas, $sect, $subj);    



        $weightage = $this->dbconnection->select("exam", "*", 'id=' .$exam);
        ?>	
        <div class="table-responsive">
            <table id="templatelistssterm" class="table table-bordered table-striped" style="height: 400px;overflow-y: auto;">
                <thead>
                    <tr>                        
                        <th>S.No</th>
                        <th>Admission No</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Student name</th>          
                        <th>External Marks (<?php echo $weightage[0]->theory_mark; ?>)</th>
                        <th>Unit/Periodic Test/Practical (<?php echo $weightage[0]->practical_mark; ?>)</th>
                        <th>Subject Assignment (<?php echo $weightage[0]->subj_assgn_marks;?>)</th>
                        <th>Class Performance (<?php echo $weightage[0]->class_performance_mks; ?>)</th>
                        <th>Grand Total</th>
                        <th>Total Marks</th>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 0;
                    foreach ($datas as $key => $value) {
                         $adm=$value['admission_no'];
                         $student_id = $this->dbconnection->Get_namme("student", "admission_no", "$adm", "id");
                        $count++;
                        ?>
                        <tr>
                            <td class="sorting_1"><?php echo $count; ?></td>
                            <td><?php echo $value['admission_no']; ?></td>
                            <td><?php echo $value['class_name']; ?></td>
                            <td><?php echo $value['sec_name']; ?></td>
                            <td><?php echo $value['first_name']; ?></td>
                            <td><input type="number" id="markobtexternal" name="user_input_external[]" style="width:100%;" onchange="autocal(this);" class="marks" max="<?php echo $weightage[0]->theory_mark; ?>" min="0" required></td>
                            <td><input type="number" id="markobtunit" name="user_input_unit[]" style="width:100%;" onchange="autocal(this);" class="marks" min="0" max="<?php echo $weightage[0]->practical_mark; ?>"></td>
                            <td><input type="number" id="markobtsubenrichment" name="user_input_subenrichment[]" style="width:100%;"  onchange="autocal(this);" class="marks" min="0" max="<?php echo $weightage[0]->subj_assgn_marks; ?>" required></td>
                            <td><input type="number" id="markobtclassrecord" name="user_input_classrecord[]" style="width:100%;"  onchange="autocal(this);" class="marks" min="0" max="<?php echo $weightage[0]->class_performance_mks; ?>" required> </td>
                            <td><input type="number" id="markobtgrandtotal" name="user_input_grandtotal[]" style="width:100%;"    readonly class="marks" required>
                                <input type="hidden" id="stid_<?php echo $count; ?>" value="<?php echo $student_id; ?>" name="student[]">
                                <input type="hidden" id="exam_type" name="exam_type" value="<?php echo $weightage[0]->extype; ?>">
                                <input type="hidden" id="grand_total" name="grand_total" value="<?php echo $weightage[0]->grand_total; ?>">
                            </td>
                            <td><?php echo $value['grand_total']; ?></td>
                            <td><input type="text" id="comment" name="comment[]" style="width:100%;"></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
                
            </table>
        </div>
        <?php
    }
    
    
    

    public function GetData() {
        $exam = $this->input->post('exam');
        $clas = $this->input->post('clas');
        $sect = $this->input->post('sect');
        $subj = $this->input->post('subj');
        $datas = $this->dbconnection->selectStudentData($exam, $clas, $sect, $subj);
        ?>	
        <div class="table-responsive">
            <table id="templatelistss" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Admission No</th>
                        <th>Class</th>
                        <th>Section</th>
                        <th>Student name</th>
                        <th>Mark Obtained</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 0;
                    foreach ($datas as $key => $value) {
                        // print_r($value);
                        $count++;
                        ?>
                        <tr>
                            <td class="sorting_1"><?php echo $count; ?></td>
                            <td><?php echo $value['admission_no']; ?></td>
                            <td><?php echo $value['class_name']; ?></td>
                            <td><?php echo $value['sec_name']; ?></td>
                            <td><?php echo $value['first_name']; ?></td>
                            <td><?php
                                if (($value['mark_obtained']) == '') {
                                    echo '--';
                                } else {
                                    echo $value['mark_obtained'] . ' / ' . $value['mark_total'];
                                }
                                ?></td>
                            <td>
                                <a onclick="editmarks(<?php echo $exam; ?>,<?php echo $clas; ?>,<?php echo $sect; ?>,<?php echo $subj; ?>,<?php
                                if (($value['mark_id']) == '') {
                                    echo '0';
                                } else {
                                    echo $value['mark_id'];
                                }
                                ?>,<?php echo $value['admission_no']; ?>, '<?php echo $value['class_name']; ?>', '<?php echo $value['sec_name']; ?>', '<?php echo $value['first_name']; ?>',<?php
                       if (($value['mark_obtained']) == '') {
                           echo '0';
                       } else {
                           echo $value['mark_obtained'];
                       }
                       ?>, '<?php echo $value['subjectname']; ?>')"><i class="fa fa-edit"></i>Edit</a>
                            </td>
                        </tr>
            <?php
        }
        ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    public function UpdateMarks() {
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $where = "mark_id=" . $this->input->post('id');
        $marks = $this->input->post('marks');
        $data = array(
            'mark_obtained' => $marks,
        );
        $table = 'mark';
        $datas = $this->dbconnection->update($table, $data, $where);
        echo $this->db->last_query();

        $audit = array("action" => 'Update Marks',
            "module" => "Update Marks Module",
            'datetime' => date("Y-m-d H:i:s"),
            'userid' => $this->session->userdata('user_id'),
            'remarks' => ''
        );
        $this->dbconnection->insert("auditntrail", $audit);
    }

    public function GetTotalMark() {
        $examid = $this->input->post('id');
        $classid = $this->input->post('classid');
        $studentid = $this->input->post('studentid');
        $marksobt = $this->input->post('marksobt');
        $subjectid = $this->input->post('subjectid');

        $totalmarks = $this->dbconnection->select("exam", "grand_total", "id=$examid");
        $mark_total = $totalmarks[0]->grand_total;

        $data = array(
            'board_id' => 1,
            'student_id' => $studentid,
            'subject_id' => $subjectid,
            'class_id' => $classid,
            'exam_id' => $examid,
            'mark_obtained' => $marksobt,
            'mark_total' => $mark_total,
        );
        $this->dbconnection->insert('mark', $data);
    }

    public function GetGrandTotalMark() {
        $examid = $this->input->post('id');
        $totalmarks = $this->dbconnection->select("exam", "grand_total", "id=$examid");
        echo $mark_total = $totalmarks[0]->grand_total;
    }
    
    
    public function ExamType() {
        $examid = $this->input->post('exam');
        $exam_type_query = $this->dbconnection->select("exam", "extype", "id=$examid");
        echo $exam_type=$exam_type_query[0]->extype;
//        print_r($exam_type);
    }

    public function Get() {

        $subject_id = $this->input->post('subj');
        $class_id = $this->input->post('clas');
        $exam_id = $this->input->post('exam');

        $datacheck = array(
            'subject_id' => $subject_id,
            'class_id' => $class_id,
            'exam_id' => $exam_id,
        );

        echo $data = $this->dbconnection->CountData($datacheck);
    }

    public function AddMark() {
        $board_id = 1;
//        $student_id = $this->input->post('student');
        $subject_id = $this->input->post('subject');
        $class_id = $this->input->post('class_id');
        $section_id = $this->input->post('section_id');
        $exam_id = $this->input->post('examname');
//        $periodic_test = $this->input->post('periodic');
//        $note_book = $this->input->post('note_book');
//        $sub_enrichment = $this->input->post('assignment');
//        $written_exam = $this->input->post('written');
//        $comment = $this->input->post('comment');
        $exam_type = $this->input->post('exam_type');      
//        $mark_obtained = $this->input->post('mark_obtained');
//        $mark_total = $this->input->post('mark_total');       
        
        if($exam_type=='TERM'){
        foreach ($this->input->post('student') as $key => $value) {


            $data = array(
            'board_id' => 1,
            'student_id' => $this->input->post('student')[$key],
            'subject_id' => $subject_id,
            'class_id' => $class_id,
            'section_id' => $section_id,
            'exam_id' => $exam_id,
            'periodic_test' => $this->input->post('user_input_unit')[$key],
            'note_book' => $this->input->post('user_input_classrecord')[$key],
            'sub_enrichment' => $this->input->post('user_input_subenrichment')[$key],
            'written_exam' => $this->input->post('user_input_external')[$key],
            'mark_obtained' => $this->input->post('user_input_grandtotal')[$key],
            'mark_total' => $this->input->post('grand_total'),
            'comment' => $this->input->post('comment')[$key],
            );
//                print_r($data);
//                die();
            $this->dbconnection->insert('mark', $data);
            $this->session->set_flashdata('successmsg', "Successfully Created Record ");
        }
        echo json_encode(['success' => 'Record added successfully.']);
        }
        else{
             foreach ($this->input->post('student') as $key => $value) {
            $data = array(
            'board_id' => 1,
            'student_id' => $this->input->post('student')[$key],
            'subject_id' => $subject_id,
            'class_id' => $class_id,
            'section_id' => $section_id,
            'exam_id' => $exam_id,
            'periodic_test' => $this->input->post('user_input_unit')[$key],
            'note_book' => '',
            'sub_enrichment' => '',
            'written_exam' => '',
            'mark_obtained' => $this->input->post('mark_obtained')[$key],
            'mark_total' => $this->input->post('grand_total'),
            'comment' => $this->input->post('comment')[$key],
            );
//                print_r($data);
//                die();
            $this->dbconnection->insert('mark', $data);
            $this->session->set_flashdata('successmsg', "Successfully Created Record ");
             }
             echo json_encode(['success' => 'Record added successfully.']);
        }
        
       
        $audit = array("action" => 'Add Marks',
            "module" => "Add Marks Module",
            'datetime' => date("Y-m-d H:i:s"),
            'userid' => $this->session->userdata('user_id'),
            'remarks' => ''
        );
        $this->dbconnection->insert("auditntrail", $audit);
    }

    public function GetSubjects() {
        $class_id = $this->input->post('clasid');
        $section_id = $this->input->post('sect');

        if ($this->session->userdata('login_type') == 'teacher') {
            $datass = $this->dbconnection->select('user', '*', 'id=' . $this->session->userdata('user_id'));
            $tid = $datass[0]->employee_id;

            $sec_name = $this->dbconnection->select_join("class_subject_teacher as t1", "t2.*", "t1.status='1' AND t2.status = '1' AND t1.class_id=$class_id AND t1.section_id=$section_id", "subject as t2", "t1.subject_id=t2.id");

            foreach ($sec_name as $key => $value) {
                ?>
                <option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
                <?php
            }
        } else {
            $data = $this->dbconnection->GetSubjectLists($class_id, $section_id);
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

}
