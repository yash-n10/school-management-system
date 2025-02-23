<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Results extends CI_Controller {

    public $page_code = 'class_routine';
    public $page_id = '';
    public $page_perm = '----';
    
    public function __construct() {
        parent::__construct();


        $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");


        $this->id = $this->session->userdata('school_id');
        $this->school_desc = $this->dbconnection->select("school", "*", "id=" . $this->id . " and status = 1");
        $this->schools = $this->dbconnection->select("school", "*", 'status = 1');


        if ($this->id != 0)
            $this->db->db_select('crmfeesclub_' . $this->id);
        
        $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
        $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
        $this->right_access = $this->page_perm;
        
        $this->academic_session=$this->dbconnection->select("accedemic_session","id as fin_year,session,start_date,end_date","active='Y'","id","DESC","1");

        if (strpos($this->page_perm, '----') == true) {
            redirect(base_url(''), 'refresh');
        }
        $this->page_title = 'Student Results';
        $this->section = 'academic';
        $this->page_name = 'results';
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
        $this->data['examination'] = $this->dbconnection->select("exam", "*", "status = 1");
        $this->data['class'] = $this->dbconnection->select("class", "*", "status = 'Y'");
        $this->data['subject'] = $this->dbconnection->select("subject", "*", "status = 1");

        $this->load->view('index', $this->data);
    }

    public function GetSection() {
        $id = $this->input->post('id');
        $data = $this->dbconnection->select('class', 'section', 'status="Y" and id=' . $id);
        $sec = $data[0]->section;
        $sectionfetch = explode("-", $sec);
        foreach ($sectionfetch as $val) {
            $sec_name = $this->dbconnection->select("section", "*", "id=$val");
            foreach ($sec_name as $value) {
                echo "<option value='$value->id'>$value->sec_name</option>";
            }
        }
    }

    public function Getresu() {
        $student_id = $this->input->post('id');
        $examid = $this->input->post('examid');
        $class_id = $this->input->post('classid');
        $section_id = $this->input->post('sectid');
        $dat = $this->db->query("select mk.student_id,mk.mark_obtained,mk.periodic_test,mk.note_book,mk.sub_enrichment,mk.written_exam,ex.name,ex.excode,ex.theory_mark,ex.practical_mark,ex.class_performance_mks,ex.subj_assgn_marks,ex.grand_total,ex.pass_mark,sub.name as subjectname from mark mk, exam ex, subject sub where ex.id=mk.exam_id and  sub.id=mk.subject_id and ex.id=$examid and mk.class_id=$class_id and mk.section_id=$section_id and mk.student_id=$student_id")->result();

        foreach ($dat as $value) {

            $subject_id = $value->subjectname;
            $mark_obtained = $value->mark_obtained;
            $mark_total = $value->grand_total;
            $pass_mark = $value->pass_mark;
            ?>
            <tr>
                <td><?php if ($subject_id) {
                echo $subject_id;
            } else {
                echo 'N/A';
            } ?></td>
                <td><?php if ($mark_obtained) {
                echo $mark_obtained;
            } else {
                echo 'N/A';
            } ?></td>
                <td><?php if ($mark_total) {
                echo $mark_total;
            } else {
                echo 'N/A';
            } ?></td>
                <td><?php if ($mark_obtained) {
                if ($mark_obtained < $pass_mark) {
                    echo 'FAIL';
                } else {
                    echo 'PASS';
                }
            } else {
                echo 'N/A';
            } ?></td>                  
            </tr>
            <?php
        }
    }
    
    public function pdf_result() {

        $id = $this->uri->segment(4);
        $examid = $this->uri->segment(5);
        $class_id = $this->uri->segment(6);
        $section_id = $this->uri->segment(7);
        
        $invoice_demo_id = 3;
        $school_data=$this->school_desc = $this->dbconnection->select("crmfeesclub.school", "*", "id=" . $this->id . " and status = 1");

        $pdf_id = $invoice_demo_id;
        $data_inv = $this->dbconnection->select('crmfeesclub.invoice_demo', '*', 'id=' . $pdf_id);
        if($this->session->userdata('school_id')==5)
        {
            $inv_view = 'vv_primary_result';
        }
        else
        {
            $inv_view = $data_inv[0]->invoice_page_view;
        }
        
        $size = $data_inv[0]->size;
        $invoice_demo_no = $data_inv[0]->invoice_demo_no;
        $orientation = $data_inv[0]->orientation;
        $session=$this->academic_session[0]->session;
        
        $result=$this->db->query("select mk.student_id,mk.mark_obtained,mk.periodic_test,mk.note_book,mk.sub_enrichment,mk.written_exam,ex.name,ex.excode,ex.theory_mark,ex.practical_mark,ex.class_performance_mks,ex.subj_assgn_marks,ex.grand_total,ex.pass_mark,sub.name as subjectname from mark mk, exam ex, subject sub where ex.id=mk.exam_id and  sub.id=mk.subject_id and ex.id=$examid and mk.class_id=$class_id and mk.section_id=$section_id and mk.student_id=$id")->result();
        $student=$this->db->query("select t1.admission_no,t1.roll,t1.first_name,t1.middle_name,t1.last_name,t1.father_name,t1.mother_name ,t1.dob,t1.class_id,t1.section_id,t1.phone,t1.address,t2.class_name,t3.sec_name from student as t1 ,class as t2 , section as t3 where t1.class_id=t2.id and t1.section_id=t3.id and  t1.id=$id;")->result();
        

        $array = array('result' => $result,'student_data'=>$student,  'school_data' => $school_data,'session'=>$session);
        $this->load->view('academic/' . $inv_view, $array);
        $html = $this->output->get_output();
        $this->load->library('pdf');

        $this->dompdf->load_html($html);
        $this->dompdf->set_paper($size, $orientation);
        if ($invoice_demo_no == '5') {
            $customPaper = array(0, 0, 280, 1000);
            $this->dompdf->set_paper($customPaper);
        }
        $this->dompdf->render();
        $this->dompdf->stream("result.pdf", array("Attachment" => false));
    }
    
    
        
    
    

    public function GetData() {
        $exam = $this->input->post('exam');
        $clas = $this->input->post('clas');
        $sect = $this->input->post('sect');
        $row = $this->dbconnection->selectstudent($exam, $clas, $sect);
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
                        <th>Result</th>
                    </tr>
                </thead>
                <tbody>
        <?php
        $x = 1;
        foreach ($row as $value) {

            $student_id = $this->dbconnection->Get_namme("student", "admission_no", "$value->admission_no", "id");
            $name = $value->first_name . ' ' . $value->middle_name . ' ' . $value->last_name;
            ?>
                        <tr>
                            <td class="sorting_1"><?php echo $x; ?></td>
                            <!-- <td><?php echo $value->sid; ?></td> -->
                            <td><?php echo $value->admission_no; ?></td>
                            <td><?php echo $value->class_name; ?></td>
                            <td><?php echo $value->sec_name; ?></td>
                            <td><?php echo $name; ?></td>
                            <td><a onclick="view(<?php echo $student_id; ?>,<?php echo $exam; ?>,<?php echo $clas; ?>,<?php echo $sect; ?>, '<?php echo $name; ?>')"><i class="fa fa-edit"></i>&nbsp;View</a> &nbsp;&nbsp;
                            <a id="<?php echo $student_id;?>" target="_blank"  href="<?php echo base_url();?>academics/Results/pdf_result/<?php echo $student_id;?>/<?php echo $exam; ?>/<?php echo $clas; ?>/<?php echo $sect; ?>" data-toggle="tooltip" data-placement="top" title="Download"><i class="fa fa-file-alt"></i>Download</a>

                            </td>
                        </tr>
                                <?php
                                $x++;
                            }
                            ?>                                   
                </tbody>	         	
            </table>

            <div id="myModals" class="modal fade in" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content" id="dats">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                                <?php
                                $examdata = $this->dbconnection->selectexam($exam);
                                ?>
                            <h4 class="modal-title"><?php echo $examdata[0]->name; ?></h4>					           
                        </div>

                        <div class="modal-body">
                            <p class="stuname" style="font-weight: bold;"></p>
                            <p>Exam Date: <?php $dates = $examdata[0]->start_date;
                                $dats = strtotime($dates);
                                echo date('d/m/Y', $dats); ?></p>
                            <p>Total Marks: <?php echo $examdata[0]->grand_total; ?> &nbsp;&nbsp;||&nbsp;&nbsp;<span>Pass Mark: <?php echo $examdata[0]->pass_mark; ?></span></p>
                            <table class="table table-striped table-bordered" id="subjlist" cellspacing="0" cellpadding="0" border="2">
                                <thead>
                                    <tr>
                                        <th>Subject</th>
                                        <th>Marks</th>
                                        <th>Out Of</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="datass">

                                </tbody>			                	
                            </table>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>

                    </div>
                </div>
            </div>	

        </div>


        <script>
            $('#templatelistss').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true
            });
        </script>
        <?php
    }

}
