<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exam_rooms extends CI_Controller {

    public $page_code = 'exam_rooms';
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
        $this->academic_session=$this->dbconnection->select("accedemic_session","max(id) as fin_year","active='Y'");

        $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
        $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
        $this->right_access = $this->page_perm;

        if (strpos($this->page_perm, '----') == true) {
            redirect(base_url(''), 'refresh');
        }
        $this->page_title = 'Exam Rooms Allocation';
        $this->section = 'academic';
        $this->page_name = 'exam_rooms';
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
        $this->data['teacher'] = $this->dbconnection->select('employee', '*', 'status=1 and category_id=1');
        $this->data['class'] = $this->dbconnection->select("class", "*", "status = 'Y'");
//        if ($this->session->userdata('login_type') == 'teacher') {
//            $data = $this->dbconnection->select('user', '*', 'id=' . $this->session->userdata('user_id'));
//            $tid = $data[0]->employee_id;
////	    	$this->data['class']=$this->dbconnection->select_class($tid);
//            $this->data['class'] = $this->dbconnection->select("class", "id,class_name", "id IN(SELECT class_id FROM class_subject_teacher WHERE teacher_id=$tid)");
//        } else {
//            $this->data['class'] = $this->dbconnection->select("class", "*", "status = 'Y'");
//        }


        $this->load->view('index', $this->data);
    }
    
        public function save_rooms() {
        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $room_no = $this->input->post('room_no');
        $seats = $this->input->post('seats');
        $invigilator_1 = $this->input->post('invigilator_1');
        $invigilator_2 = $this->input->post('invigilator_2');
        $exam_id=$this->input->post(exam);
        $data = array(
            'exam_id'=>$exam_id,
            'room_no' => $room_no,
            'no_of_seats' => $seats,
            'invigilator1' => $invigilator_1,
            'invigilator2' => $invigilator_2,
            'status' => $this->session->userdata('user_id'),
            'academic_year_id'=>$this->academic_session[0]->fin_year,
            'created_by' => $this->session->userdata('user_id'),
        );

        $this->dbconnection->insert('exam_room_head', $data);
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
        $exam = $this->input->post('exam');
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
                            <td><input type="number" id="markobt" name="user_input" style="width:100%;" required="" value="0">
                                <input type="hidden" id="stid_<?php echo $count; ?>" value="<?php echo $value['sid']; ?>">
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

    public function GetData() {
        $exam = $this->input->post('exam');
//        $clas = $this->input->post('clas');
//        $sect = $this->input->post('sect');
//        $subj = $this->input->post('subj');
        $datas = $this->dbconnection->selectexamRoomdata($exam);
        ?>	
        <div class="table-responsive">
            <table id="templatelistss" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Room No.</th>
                        <th>No. of seats</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $count = 0;
                    foreach ($datas as $key => $value) {
                        
                        $count++;
                        ?>
                        <tr>
                            <td class="sorting_1"><?php echo $value['id']; ?></td>
                            <td><?php echo $value['room_no']; ?></td>
                            <td><?php echo $value['no_of_seats']; ?></td>
                            <td>
                                <a onclick="updateaddroomalloc(this)" id="<?php echo $value['id']; ?>">
                                    <i class="fa fa-edit"></i>Edit</a>&nbsp;
                            <a id="<?php echo $student_id;?>" class="btn btn-success btn-sm" target="_blank"  href="<?php echo base_url();?>academics/Exam_rooms/pdfinvoices/<?php echo $value['id'];?>" data-toggle="tooltip" data-placement="top" title="Download"><i class="fa fa-file-alt"></i>Sitting Plan</a>&nbsp;

                            <a id="<?php echo $val->id;?>" class="btn btn-warning btn-sm" target="_blank" href="<?php echo base_url(('academics/Exam_rooms/'));?>pdf_atten_sheet/<?php echo $value['id'];?>" data-toggle="tooltip" data-placement="top" title="Download"><i class="fa fa-file-alt"></i>Attendence Sheet</a>
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

    public function Get() {

//        $room_no = $this->input->post('room_no');
//        $class_id = $this->input->post('clas');
        $exam_id = $this->input->post('exam');

        $datacheck = array(
//            'subject_id' => $subject_id,
//            'class_id' => $class_id,
            'exam_id' => $exam_id,
        );

        echo $data = $this->dbconnection->CountDataroom($datacheck);
    }

    public function AddMark() {

        if (substr($this->right_access, 0, 1) == 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $board_id = 1;
        $student_id = $this->input->post('student_id');
        $subject_id = $this->input->post('subject_id');
        $class_id = $this->input->post('class_id');
        $exam_id = $this->input->post('exam_id');

        $mark_obtained = $this->input->post('mark_obtained');
        $mark_total = $this->input->post('mark_total');
        $data = array(
            'board_id' => $board_id,
            'student_id' => $student_id,
            'subject_id' => $subject_id,
            'class_id' => $class_id,
            'exam_id' => $exam_id,
            'mark_obtained' => $mark_obtained,
            'mark_total' => $mark_total,
        );


        $this->dbconnection->insert('mark', $data);
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

            $sec_name = $this->dbconnection->select_join("class_subject_teacher as t1", "t2.*", "t1.status='1' AND t2.status = '1' AND t1.class_id=$class_id AND t1.section_id=$section_id AND t1.teacher_id=$tid", "subject as t2", "t1.subject_id=t2.id");

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
    
    function getclasssection()
    {
        
        $id = $this->input->post('id');
        if($id==''){
   
                $sec_name = $this->dbconnection->select("section", "*", "status='Y'");
                foreach ($sec_name as $value) {
                echo "<option value='$value->id'>$value->sec_name</option>";
            }
        }
        else{
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
    
    public function editRoomAlloc() {

        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
         $id = $this->input->post('formdata');

        $data = array(
            'page_name' => 'add_exam_room_alloc',
            'page_title' => $this->page_title,
            'section' => $this->section,
            'customview' => $this->customview,
            'task' => 'edit',
            'room_no' => $this->dbconnection->Get_namme('exam_room_head', 'id', $id, 'room_no'),
            'exam_room_head' => $this->db->query("SELECT t1.id,t1.exam_id,t1.room_no,t1.no_of_seats,t1.academic_year_id,t2.name  from exam_room_head as t1,exam as t2 where  t2.id=t1.exam_id and t1.id=$id")->result(),
            'exam_room_detail' => $this->dbconnection->select("exam_room_detail", "*", "status='Y' and exam_room_head_id=$id"),
//             'teacher' => $this->dbconnection->select('employee', '*', 'status=1 and category_id=1'),
             'class' =>$this->dbconnection->select("class", "*", "status = 'Y'"),
//             'section' =>$this->dbconnection->select("section", "*", "status = 'Y'"),
             'student' =>$this->dbconnection->select("student", "id,roll", "status = 'Y'"),
            'updateid' => $id,
        );
        $this->load->view('index', $data);
        
    }
    
     public function saveExamRoomAlloc() {

        $updateid = $this->input->post('updateid');
        $field = array(
            'status' => 'N'
        );
        $this->dbconnection->update('exam_room_detail', $field, 'exam_room_head_id=' . $updateid);

        foreach ($this->input->post('class') as $key => $value) {


            $data = array(
                'exam_room_head_id'=>$updateid,
                'class_id' => $this->input->post('class')[$key],
                'section_id' => $this->input->post('section')[$key],
                'from_roll' => $this->input->post('from_roll')[$key],
                'to_roll' => $this->input->post('to_roll')[$key],
                'academic_year_id' =>$this->academic_session[0]->fin_year,
                'status' => 'Y',
                'date_created' => date("Y-m-d H:i:s"),
                'created_by' => $this->session->userdata('user_id')
            );
//            print_r($data);
//            die();
             
            $this->dbconnection->insert('exam_room_detail', $data);
            $this->session->set_flashdata('successmsg', "Successfully Created Record ");
        }
        echo json_encode(['success' => 'Record added successfully.']);
    }
    
    public function btn_download_pop_load() {

        if ($this->uri->segment(4) == 'dwld_yes')
        {
            $exam_deatil_id = $this->input->post('exam_id');
        }
        else
        {
            $exam_deatil_id = $this->uri->segment(5);
        }

        $query_transaction = $this->db->query("SELECT t1.id,t1.exam_id,t1.room_no,t1.no_of_seats,t1.academic_year_id,t2.name,t3.exam_room_head_id,t3.class_id,t3.section_id,t3.from_roll,t3.to_roll,t4.class_name,t5.sec_name from exam_room_head as t1,exam as t2,exam_room_detail as t3,class as t4,section as t5 where t3.class_id=t4.id and t3.section_id=t5.id and t3.exam_room_head_id=t1.id and t2.id=t1.exam_id and t3.exam_room_head_id=$exam_deatil_id");
//        $query_transaction = $this->db->query("select f1.*,f2.class_fee_head_id,group_concat(distinct(f2.fee_cat_id)) as fee,count(case when f2.month_no<>0 and f2.fee_cat_id=2 then f2.month_no end) as m,min(case when f2.month_no<>0 and f2.fee_cat_id=2 then f2.month_no end) as from_month,max(f2.due_month_no) as d from fee_transaction_head f1, fee_transaction_det f2 where f1.id=$fee_transaction_id and f1.response_message=0 and f1.status=1 and f1.id=f2.fee_trans_head_id group by f1.id");
        $q = $query_transaction->result();
        
        $class_name=$q[0]->class_name;
        $section_name=$q[0]->sec_name;
        $exam_name=$q[0]->name;
        $no_of_seats=$q[0]->no_of_seats;
        $from_roll=$q[0]->from_roll;
        $to_roll=$q[0]->to_roll;
        $room_no=$q[0]->room_no;
        $academic_year_id=$q[0]->academic_year_id;
        $school_id = $this->session->userdata('school_id');
        $school = $this->school_desc;

        $session_name= $this->dbconnection->Get_namme('accedemic_session', 'id', $academic_year_id, 'session');

        $data = array(
            'school_id' => $school_id,
            'school_name' => $school[0]->description,
            'school_address' => $school[0]->address,
            'vision' => $school[0]->vision,
            'phone' => $school[0]->phone,
            'email' => $school[0]->email,
            'room_no' => $room_no,
            'exam_name' => $exam_name,
            'class' => $class_name,
            'section' => $section_name,
            'from_roll' => $from_roll,
            'to_roll' => $to_roll,
            'total_seats' => $no_of_seats,
            'session'=>$session_name,
//            'q'=>$q,
        );
//        print_r($data);
//        die();
        if ($this->uri->segment(4) == 'dwld_yes')
            $this->download_pdf($data);
        else
            $this->download_pdf($data);
    }
    
//    dompdf

    public function pdfinvoices() {

        $id = $this->uri->segment(4);
        
        $invoice_demo_id = 1;
        $school_data=$this->school_desc = $this->dbconnection->select("crmfeesclub.school", "*", "id=" . $this->id . " and status = 1");

        $pdf_id = $invoice_demo_id;
        $data_inv = $this->dbconnection->select('crmfeesclub.invoice_demo', '*', 'id=' . $pdf_id);
        $inv_view = $data_inv[0]->invoice_page_view;
        $size = $data_inv[0]->size;
        $invoice_demo_no = $data_inv[0]->invoice_demo_no;
        $orientation = $data_inv[0]->orientation;
        
        $invoice_data = $this->db->query("SELECT t1.id,t1.exam_id,t1.room_no,t1.no_of_seats,t1.academic_year_id,t2.name,t3.exam_room_head_id,t3.class_id,t3.section_id,t3.from_roll,t3.to_roll,t4.class_name,t5.sec_name,t6.name as exam_name from exam_room_head as t1,exam as t2,exam_room_detail as t3,class as t4,section as t5,exam as t6 where t3.class_id=t4.id and t3.section_id=t5.id and t3.exam_room_head_id=t1.id and t2.id=t1.exam_id and t1.exam_id=t6.id and t3.exam_room_head_id=$id")->result();
//        $company_data = $this->dbconnection->select_join('users as t1', 't2.*', 't1.id=' . $this->user_id, 'company as t2', 't1.company_id=t2.id');
//
//        $bank_detail = $this->dbconnection->select('bank', '*','');
        $array = array('invoice_data' => $invoice_data,  'school_data' => $school_data);
        $this->load->view('academic/' . $inv_view, $array);
        $html = $this->output->get_output();
// Load library
        $this->load->library('pdf');
// Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->set_paper($size, $orientation);
        if ($invoice_demo_no == '5') {
            $customPaper = array(0, 0, 280, 1000);
            $this->dompdf->set_paper($customPaper);
        }
        $this->dompdf->render();
        $this->dompdf->stream("Sitting_plan.pdf", array("Attachment" => false));
    }
    
    
    public function pdf_atten_sheet() {

        $id = $this->uri->segment(4);
        
        $invoice_demo_id = 2;
        $school_data=$this->school_desc = $this->dbconnection->select("crmfeesclub.school", "*", "id=" . $this->id . " and status = 1");

        $pdf_id = $invoice_demo_id;
        $data_inv = $this->dbconnection->select('crmfeesclub.invoice_demo', '*', 'id=' . $pdf_id);
        $inv_view = $data_inv[0]->invoice_page_view;
        $size = $data_inv[0]->size;
        $invoice_demo_no = $data_inv[0]->invoice_demo_no;
        $orientation = $data_inv[0]->orientation;
        
        $invoice_data = $this->db->query("SELECT t1.id,t1.exam_id,t1.room_no,t1.no_of_seats,t1.academic_year_id,t2.name,t3.exam_room_head_id,t3.class_id,t3.section_id,t3.from_roll,t3.to_roll,t4.class_name,t5.sec_name,t6.name as exam_name,t7.first_name ,t7.middle_name,t7.last_name ,t7.roll from exam_room_head as t1,exam as t2,exam_room_detail as t3,class as t4,section as t5,exam as t6,student as t7 where t3.class_id=t4.id and t3.section_id=t5.id and t3.exam_room_head_id=t1.id and t2.id=t1.exam_id and t1.exam_id=t6.id and t3.exam_room_head_id=$id group by roll")->result();
//        $company_data = $this->dbconnection->select_join('users as t1', 't2.*', 't1.id=' . $this->user_id, 'company as t2', 't1.company_id=t2.id');
//
//        $bank_detail = $this->dbconnection->select('bank', '*','');
        $array = array('invoice_data' => $invoice_data,  'school_data' => $school_data);
        $this->load->view('academic/' . $inv_view, $array);
        $html = $this->output->get_output();
// Load library
        $this->load->library('pdf');
// Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->set_paper($size, $orientation);
        if ($invoice_demo_no == '5') {
            $customPaper = array(0, 0, 280, 1000);
            $this->dompdf->set_paper($customPaper);
        }
        $this->dompdf->render();
        $this->dompdf->stream("sheet.pdf", array("Attachment" => false));
    }


    public function getsturoll() {
        if (!empty($this->input->post('roll'))) {
            $this->input->post('cls');
            $this->input->post('sec');
            $query = $this->dbconnection->select('student', 'roll', 'class_id=' . $this->input->post('cls') . ' AND section_id=' . $this->input->post('sec'));

            $return = "<option value=''>Select</option>";
            foreach ($query as $roll_no) {

                $return .= "<option value='" . $roll_no->roll . "'>" . $roll_no->roll . "</option>";
            }
        }
        echo $return;
    }

}
