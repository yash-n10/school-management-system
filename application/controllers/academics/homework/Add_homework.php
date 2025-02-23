<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add_homework extends MY_ListController {

//    public $page_code = '';
//    public $page_id = '';
//    public $page_perm = '----';

    public function __construct() {
        $this->page_code = 'assignment_homework';

        parent::__construct();

        // error_reporting(-1);
        // ini_set('display_errors', 1);
        // $this->db->db_debug=TRUE;
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
        $this->school_desc = $this->dbconnection->select("crmfeesclub.school", "*", "id=" . $this->id . " and status = 1");
        // $this->schools = $this->dbconnection->select("school", "*", 'status = 1');
        // $this->sms_setting=$this->dbconnection->select('crmfeesclub.sms_notification','*',"link_code=$this->page_id");

//        if ($this->id != 0)
//            $this->db->db_select('crmfeesclub_' . $this->id);
        $this->page_title = 'Add Homework';
        $this->section = 'academic';
        $this->page_name = 'add_homework';
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
        $this->data['school_data']=$this->school_desc;
        // $this->data['sms_set']=$this->sms_setting;
        $data = $this->dbconnection->select('user', '*', 'id=' . $this->session->userdata('user_id'));
        $tid = $data[0]->employee_id;
        $user_group_id = $data[0]->user_group_id;
         if($user_group_id==2)
        {
             $this->data['classs'] = $this->dbconnection->select("class", "id,class_name", "status='Y'");
        }
        else{
             $this->data['classs'] = $this->dbconnection->select("class", "id,class_name", "id IN (SELECT class_id FROM class_subject_teacher WHERE teacher_id=$tid)");
        }
       

        $this->data['homework'] = $this->dbconnection->dbcon();

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
            $data = $this->dbconnection->select('class', 'section', 'status="Y" and id=' . $id,"","","","group by section");
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
	    $config['upload_path'] = 'homework/';
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

        $result = $this->dbconnection->insert('assignment',$data);


        $lastid = $this->dbconnection->get_last_id();
        $audit = array("action" => 'Add Assignment Homework',
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


    public function save_send() {

        if (substr($this->right_access, 0, 1) != 'C') {
            redirect('404');
        }

        $class_id=$this->input->post('class');
        $section_id=$this->input->post('section');

        switch ($this->session->userdata('school_id')) {
            case 26 : $sender = 'MOUNTC';
            $sms_gy = 'send_smstomountc';
            break;
        case 5 : $sender = 'VVSJSR';
            $sms_gy = 'send_bulksmsind_vv';
            break;
        default : $sender = 'MILDRX';
            $sms_gy = 'send_bulksmsind';
            break;
        }
      
        $config['upload_path'] = 'homework/';
        $config['allowed_types'] = 'gif|jpg|png|pdf|msword';
        $config['max_size'] = '2048000000';
        $config['overwrite'] = FALSE;
        $this->load->library('upload',$config);
        $this->upload->initialize($config);
         $this->upload->do_upload('userfile');
        if($this->upload->do_upload('userfile'))
        {  
            $homeattach = array('upload_data' => $this->upload->data());

            $data=  array(
                'doa' => $this->input->post('homework_date'),
                'description' => $this->input->post('descr'),
                'class_id' => $this->input->post('class'),
                'section_id' => $this->input->post('section'),
                'subject_id' => $this->input->post('subject'),
                'dos' => $this->input->post('dos'),
                'attachment' => $homeattach['upload_data']['file_name'],
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

        $result = $this->dbconnection->insert('assignment',$data);

        $select_stud=$this->dbconnection->select('student','*','class_id=$class_id and section_id=$section_id');


        $lastid = $this->dbconnection->get_last_id();
        $audit = array("action" => 'Add Assignment Homework',
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

    public function upload_homework()
    {

        $id=$this->input->post('home_id');

        $sch_id=$this->session->userdata('school_id');
        $photoimg_name=$_FILES['upload_data']['name'];
        $pic_img_name=$sch_id.'_'.time();
        $fileExt = pathinfo($photoimg_name, PATHINFO_EXTENSION);
        $photoimg_upload_name=$pic_img_name;
	    $config['upload_path'] = 'homework/answer';
        $config['allowed_types'] = 'jpg|png|jpeg|pdf|msword';
        $config['file_name'] =$photoimg_upload_name;
        $config['overwrite'] = false;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if($this->upload->do_upload('home_upload'))
        {  
        	$uploadData_1 = $this->upload->data();
       		$image = $uploadData_1['file_name'];       		 
    		$new_name = $sch_id.'_'.time().$uploadData_1['file_ext']; 

            $data=  array(
                'homework_upload' => $new_name,
                'homework_status' =>'SUBMITTED',
            );
           
        }
        $this->dbconnection->update('assigment',$data,'id='.$id);
    }

    public function homework_add() {
        $this->data['page_name'] = 'homework';
        $this->data['page_title'] = $this->page_title;
        $this->data['section'] = $this->section;
        $this->data['customview'] = $this->customview;
        $this->data['right_access']  = $this->right_access;
        $this->data['school_data']=$this->school_desc;
        $data = $this->dbconnection->select('user', '*', 'id=' . $this->session->userdata('user_id'));
        $tid = $data[0]->employee_id;
        $user_group_id = $data[0]->user_group_id;
         if($user_group_id==2)
        {
             $this->data['classs'] = $this->dbconnection->select("class", "id,class_name", "status='Y'");
        }
        else{
             $this->data['classs'] = $this->dbconnection->select("class", "id,class_name", "id IN (SELECT class_id FROM class_subject_teacher WHERE teacher_id=$tid)");
        }
       

        $this->data['homework'] = $this->dbconnection->dbcon();

        $this->data['category'] = $this->dbconnection->select('assignment_category', '*', 'status="Y"');
        $this->load->view('index', $this->data);
    }



}
