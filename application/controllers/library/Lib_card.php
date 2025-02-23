<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lib_card extends CI_Controller {
    
    public $page_code = 'lib_card';
    public $page_id = '';
    public $page_perm = '----';
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Mymodel', 'm');

        
        $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");

        $this->id = $this->session->userdata('school_id');
        $this->school_desc  = $this->dbconnection->select("school", "*", "id=" . $this->id . " and status = 1");
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
        if (substr($this->right_access, 1, 1) != 'R') 
        {
            redirect('404');
        }
        $this->data['page_name'] = 'lib_card_list';
        $this->data['page_title'] = 'Library Card';
        $this->data['section'] = 'library';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->data['vendor'] = $this->dbconnection->select("ledger", "*", "status='Y' AND under_group = 36");
        $this->data['library'] = $this->dbconnection->select("library_card", "*", "status='Y'");
        $this->data['class'] = $this->dbconnection->select("class", "*", "status='Y'");
        $this->data['session'] = $this->dbconnection->select("accedemic_session", "*", "status='Y'");
        
        $this->data['uqc'] = $this->dbconnection->select("crmfeesclub.uqc", "*", "");
        $this->load->view('index', $this->data);
    }

    public function prints()
    {
        $year       = $this->input->post('year');
        $class      = $this->input->post('class');
        $section    = $this->input->post('section');
        $student    = $this->input->post('students');
        if($class=='all')
        {
            $students = $this->dbconnection->select('student','*',"student_academicyear_id=$year");
        }
        else if($section=='all')
        {
            $students = $this->dbconnection->select('student','*',"student_academicyear_id=$year AND class_id=$class");
        }
        else if($student =='all')
        {
            $students = $this->dbconnection->select('student','*',"student_academicyear_id=$year AND class_id=$class AND section_id=$section");
        }
        else
        {
            $students = $this->dbconnection->select('student','*',"student_academicyear_id=$year AND class_id=$class AND section_id=$section AND id=$student");
        }

        $school = $this->school_desc;
        $array = array('students'=>$students,'school'=>$school);
        $this->load->view('library/card',$array);
        $html = $this->output->get_output();
        $this->load->library('pdf');
        $this->dompdf->load_html($html);
        $this->dompdf->set_paper('A4','portrait');
        $this->dompdf->render();
        ob_end_clean();
        $this->dompdf->stream("Card.pdf", array("Attachment" => FALSE));
        
    }

    public function get_sec()
    {
    	$id = $this->input->post('id');
    	$class = $this->dbconnection->select("class", "section", "status='Y' AND id = $id");
    	$sec = $class[0]->section;
    	$section_explode = explode('-',$sec);
    	?>
    	<option value="all">Select Section</option> 
    	<?php
    	foreach ($section_explode as $key => $value) 
    	{
    		$section = $this->dbconnection->select("section", "*", "status='Y' AND id = $value");
    		?>
    		<option value="<?php echo $section[0]->id;?>"><?php echo $section[0]->sec_name;?></option>	
    		<?php 
    	}
    }

    public function get_student()
    {

    	$id = $this->input->post('id');
    	$classs = $this->input->post('classs');
    	$year = $this->input->post('year');
    	$student = $this->dbconnection->select("student", "*", "status='Y' AND section_id = $id AND class_id = $classs AND student_academicyear_id=$year",'admission_no','ASC');    	
    	?>
    	<option value="all">Select Student</option> 
    	<?php
    	foreach ($student as $key => $value) 
    	{
    		?>
    		<option value="<?php echo $value->id;?>"><?php echo $value->admission_no;?></option>	
    		<?php 
    	}
    }




    public function add() 
    {
        if (substr($this->right_access, 0, 1) != 'C') {
            //redirect(base_url(), 'refresh');
            redirect('404');
        }

        $this->data['page_name'] = 'lib_card_add';
        $this->data['page_title'] = 'Library Card';
        $this->data['section'] = 'library';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->data['student'] = $this->dbconnection->select("student", "*", "status='Y' AND library_card_id='0'");
        $this->data['lib_card'] = $this->dbconnection->select("library_card", "*", "status='Y'");
        $this->load->view('index', $this->data);
    }

    public function fetdata() 
    {
        $adm_no = $this->input->post('adm');
        $studet = $this->m->fetchdata($adm_no);
        $id = $studet[0]->id;
        $first_name = $studet[0]->first_name;
        $middle_name = $studet[0]->middle_name;
        $last_name = $studet[0]->last_name;
        $classname = $studet[0]->classname;
        $secname = $studet[0]->secname;
        $roll = $studet[0]->roll;

        $all = array($id, $first_name, $middle_name, $last_name, $classname, $secname, $roll);
        echo json_encode($all);
    }

    public function save() 
    {
        //error_reporting(-1);
        if (substr($this->right_access, 0, 1) != 'C') {
    //redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->form_validation->set_rules('adm_no', 'Admission No', 'required');
        $this->form_validation->set_rules('no_book', 'No of Books', 'required');
        $this->form_validation->set_rules('allow_days', 'allow Days', 'required');
        $this->form_validation->set_rules('late_fine', 'Late Fine', 'required');
        $this->form_validation->set_rules('card_exp', 'Card Expiry', 'required');

        if ($this->form_validation->run() == true) {
            $field = array(
                'adm_no' => $this->input->post('adm_no'),
                'first_name' => $this->input->post('stu_name'),
                'middle_name' => $this->input->post('stu_name1'),
                'last_name' => $this->input->post('stu_name2'),
                'class' => $this->input->post('class'),
                'section' => $this->input->post('section'),
                'roll' => $this->input->post('roll'),
                'lib_card_no' => $this->input->post('lib_card_no'),
                'no_book' => $this->input->post('no_book'),
                'days_allow' => $this->input->post('allow_days'),
                'late_fine' => $this->input->post('late_fine'),
                'card_exp' => $this->input->post('card_exp'),
                'date_created' => date("Y-m-d H:i:s"),
                'created_by' => $_SERVER['REMOTE_ADDR']
            );

            $this->dbconnection->insert('library_card', $field);

            $last_id = $this->db->insert_id();

            $upfield = array(
                'library_card_id' => $last_id
            );

            $this->dbconnection->update('student', $upfield, 'admission_no=' . $this->input->post('adm_no'));
            redirect('library/Lib_card/index');
        } else {
            $this->data['page_name'] = 'lib_card_add';
            $this->data['page_title'] = 'Library Card';
            $this->data['section'] = 'library';
            $this->data['customview'] = '';
            $this->data['right_access'] = $this->right_access;
            $this->data['student'] = $this->dbconnection->select("student", "*", "status='Y'");
            $this->load->view('index', $this->data);
        }
    }

    public function edit() {
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $id = $this->input->post('id');
        $no_book = $this->input->post('no_book');
        $days_allow = $this->input->post('days_allow');
        $late_fine = $this->input->post('late_fine');
        $card_exp = $this->input->post('card_exp');
        ?>
        <table class="table">
            <tr>
                <th>Allow(No. of Book)</th>
                <td><input type="text" value="<?php echo $no_book; ?>" name="no_book" id="no_book" class="form-control"></td>
            </tr>

            <tr>
                <th>Days Allow</th>
                <td><input type="text" value="<?php echo $days_allow; ?>" name="days_allow" id="days_allow" class="form-control"></td>
            </tr>

            <tr>
                <th>Late Fine</th>
                <td><input type="text" value="<?php echo $late_fine; ?>" name="late_fine" id="late_fine" readonly class="form-control"></td>
            </tr>

            <tr>
                <th>Card Expiry</th>
                <td><input type="date" value="<?php echo $card_exp; ?>" name="card_exp" id="card_exp" class="form-control"></td>
            </tr>
            <input type="hidden" id='id' value="<?php echo $id; ?>">
        </table>
        <?php
    }

    public function update() {
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $id = $this->input->post('id');
        $field = array(
            'no_book' => $this->input->post('no_book'),
            'days_allow' => $this->input->post('days_allow'),
            'late_fine' => $this->input->post('late_fine'),
            'card_exp' => $this->input->post('card_exp'),
            'last_date_modified' => date("Y-m-d H:i:s"),
            'modified_ip' => $_SERVER['REMOTE_ADDR'],
            'last_modified_by' => $this->session->userdata('user_group_id')
        );
        $this->dbconnection->update('library_card', $field, "id='$id'");
    }

    public function view() {
        if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $adm_no = $this->input->post('adm_no');
        $first_name = $this->input->post('first_name');
        $middle_name = $this->input->post('middle_name');
        $last_name = $this->input->post('last_name');
        $class = $this->input->post('class');
        $section = $this->input->post('section');
        $roll = $this->input->post('roll');
        $lib_card_no = $this->input->post('lib_card_no');
        $no_book = $this->input->post('no_book');
        $days_allow = $this->input->post('days_allow');
        $late_fine = $this->input->post('late_fine');
        $card_exp = $this->input->post('card_exp');
        ?>
        <table class="table">
            <tr> 
                <th>Admission No.</th>
                <td colspan='3'><?php echo $adm_no; ?></td>
            </tr>
            <tr>			 
                <th>Student Name</th>
                <td><?php echo $first_name; ?></td>
                <td><?php echo $middle_name; ?></td>
                <td><?php echo $last_name; ?></td>
            </tr>

            <tr>
                <th>Class/Section</th>
                <td><?php echo $class; ?></td>
                <td colspan='2'><?php echo $section; ?></td>			
            </tr>


            <tr>
                <th>Roll</th>
                <td colspan='3'><?php echo $roll; ?></td>			 
            </tr>

            <tr>
                <th>Library Card No</th>
                <td colspan='3'><?php echo $lib_card_no; ?></td>			 
            </tr>

            <tr>
                <th>Allow(No. of Books)</th>
                <td colspan='3'><?php echo $no_book; ?></td>			 
            </tr>

            <tr>
                <th>Days Allow</th>
                <td colspan='3'><?php echo $days_allow; ?></td>			 
            </tr>

            <tr>
                <th>Late Fine</th>
                <td colspan='3'><?php echo $late_fine; ?></td>			 
            </tr>

            <tr>
                <th>Card Expiry</th>
                <td colspan='3'><?php echo $card_exp; ?></td>			 
            </tr>
        </table>
        <?php
    }

}
