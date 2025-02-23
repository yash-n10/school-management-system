<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ebooks extends CI_Controller {
// class Ebooks extends MY_ListController {

//    public $page_code = '';
//    public $page_id = '';
//    public $page_perm = '----';
    error_reporting(-1);
    ini_set('display_errors', 1);
    $this->db->db_debug=TRUE;
    public function __construct() {
        $this->page_code = 'notes';

        parent::__construct();


//        switch ($this->session->userdata('login_type')) {
//            case 'appadmin':
//                $this->right_access = 'CRUD';
//                break;
//            case 'admin':
//                $this->right_access = '-R--';
//                break;
//            case 'principal':
//                $this->right_access = 'CR--';
//                break;
//            case 'teacher':
//                $this->right_access = 'CRUD';
//                break;
//            default:
//                $this->right_access = '----';
//                redirect(base_url(), 'refresh');
//        }
        $this->id = $this->session->userdata('school_id');

//        if ($this->id != 0)
//            $this->db->db_select('crmfeesclub_' . $this->id);
        $this->page_title = 'Add Book PDF';
        $this->section = 'academic';
        $this->page_name = 'add_ebooks_pdf';
        $this->customview = '';
    }

    public function index() {
//         if (substr($this->right_access, 1, 1) != 'R') {
// //            redirect(base_url(), 'refresh');
//             redirect('404');
//         }
        error_reporting(-1);
    ini_set('display_errors', 1);
    $this->db->db_debug=TRUE;
        $this->data['page_name'] = $this->page_name;
        $this->data['page_title'] = $this->page_title;
        $this->data['section'] = $this->section;
        $this->data['customview'] = $this->customview;
        $this->data['right_access']  = $this->right_access;
        $data = $this->dbconnection->select('user', '*', 'id=' . $this->session->userdata('user_id'));
        $tid = $data[0]->employee_id;

        $this->data['classs'] = $this->dbconnection->select("class", "id,class_name", "id IN (SELECT class_id FROM class_subject_teacher WHERE teacher_id=$tid)");

        $this->data['homework'] = $this->dbconnection->select('ebooks_pdf','*','status=1');

        $this->data['category'] = $this->dbconnection->select('assignment_category', '*', 'status="Y"');
        $this->load->view('index', $this->data);
    }

    public function GetDesc() {
        $id = $this->input->post('id');
        $datass = $this->dbconnection->select('assignment', 'description', 'id=' . $id);
        echo $desc = $datass[0]->description;
    }

    public function GetSection() {
        $id = $this->input->post('id');

        if ($this->session->userdata('login_type') == 'teacher') {
            $datass = $this->dbconnection->select('user', '*', 'id=' . $this->session->userdata('user_id'));
            $tid = $datass[0]->employee_id;

            $sec_name = $this->dbconnection->select_join("class_subject_teacher as t1", "t2.*", "t2.status = 'Y' AND t1.class_id=$id AND t1.teacher_id=$tid AND t1.status='1'", "section as t2", "t1.section_id=t2.id");
            echo "<option value=''>--Select Section--</option>";
            foreach ($sec_name as $value) {
                echo "<option value='$value->id'>$value->sec_name</option>";
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

            $sec_name = $this->dbconnection->select_join("class_subject_teacher as t1", "t2.*", "t2.status = '1' AND t1.class_id=$class_id AND t1.section_id=$section_id AND t1.teacher_id=$tid", "subject as t2", "t1.subject_id=t2.id");

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

    public function save() {

        if (substr($this->right_access, 0, 1) != 'C') {
            redirect('404');
        }
        $sch_id=$this->session->userdata('school_id');
        $photoimg_name=$_FILES['upload_data']['name'];
        $pic_img_name=$sch_id.'_'.time();
        $fileExt = pathinfo($photoimg_name, PATHINFO_EXTENSION);
        $photoimg_upload_name=$pic_img_name;
        $config['upload_path'] = 'assets/ebooks/ncert';
        $config['allowed_types'] = 'jpg|png|jpeg|pdf|msword';
        $config['file_name'] =$photoimg_upload_name;
        $config['overwrite'] = false;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if($this->upload->do_upload('userfile'))
        {  
            $uploadData_1 = $this->upload->data();
            $image = $uploadData_1['file_name'];             
            $new_name = $sch_id.'_'.time().$uploadData_1['file_ext'];  
            $data=  array(
                'doa' => $this->input->post('homework_date'),
                'description' => $this->input->post('descr'),
                'class_id' => $this->input->post('class'),
                'section_id' => $this->input->post('section'),
                'subject_id' => $this->input->post('subject'),
                'dos' => $this->input->post('dos'),
                'attachment' => $new_name,
            );
           
        }
        else
        {
            $data=  array(
                'doa' => $this->input->post('homework_date'),
                'description' => $this->input->post('descr'),
                'class_id' => $this->input->post('class'),
                'section_id' => $this->input->post('section'),
                'subject_id' => $this->input->post('subject'),
                'dos' => $this->input->post('dos'),
            );
             
        }

        $result = $this->dbconnection->insert('ebooks_pdf',$data);


        $lastid = $this->dbconnection->get_last_id();
        $audit = array("action" => 'Add Ebooks',
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

    public function Delete() {
        if (substr($this->right_access, 3, 1) != 'D') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $id = $this->input->post('id');
        $data = array(
            'status' => 0,
        );
        $this->dbconnection->update("assignment", $data, "id=$id");

        $audit = array("action" => 'Delete Assignment Homework',
            "module" => $this->uri->segment(1),
            "page" => basename(__FILE__, '.php'),
            'datetime' => date("Y-m-d H:i:s"),
            'userid' => $this->session->userdata('user_id'),
            'remarks' => 'ID:' . $id,
            'ip_address' => '',
        );
        $this->dbconnection->insert("auditntrail", $audit);
    }

    public function Update_home() {
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $id = $this->input->post('id_ed');
        $datas = array(
            'description' => $this->input->post('descr_ed'),
            'class_id' => $this->input->post('class_ed'),
            'section_id' => $this->input->post('section_ed'),
            'subject_id' => $this->input->post('subject_ed'),
            'dos' => $this->input->post('dos_ed'),
            'doa' => $this->input->post('doa_ed'),
        );
        $this->dbconnection->update("assignment", $datas, "id=$id");

        $audit = array("action" => 'Update Assignment Homework',
            "module" => $this->uri->segment(1),
            "page" => basename(__FILE__, '.php'),
            'datetime' => date("Y-m-d H:i:s"),
            'userid' => $this->session->userdata('user_id'),
            'remarks' => 'ID:' . $id,
            'ip_address' => '',
        );
        $this->dbconnection->insert("auditntrail", $audit);

        echo 1;
    }

}
