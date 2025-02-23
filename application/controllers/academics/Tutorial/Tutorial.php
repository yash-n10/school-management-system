<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tutorial extends CI_Controller {

    public function __construct() {
        $this->page_code = 'assignment_homework';

        parent::__construct();

//        }
        $this->id = $this->session->userdata('school_id');
         if ($this->id != 0) {
            $this->db->db_select('crmfeesclub_' . $this->id);
            $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y' and active='Y'");
        }

//        if ($this->id != 0)
//            $this->db->db_select('crmfeesclub_' . $this->id);
        $this->page_title = 'Add Tutorial';
        $this->section = 'academic/Tutorial';
        $this->page_name = 'tutorial';
        $this->customview = '';
    }

    public function index() {
    	// error_reporting(-1);
    	// ini_set('display_errors', 1);
        $this->data['page_name'] = $this->page_name;
        $this->data['page_title'] = $this->page_title;
        $this->data['section'] = $this->section;
        $this->data['customview'] = $this->customview;
        $this->data['class'] = $this->dbconnection->select('class','*','status="Y"');
        $this->data['subject'] = $this->dbconnection->select('subject','*','status="1"');
        $this->data['video_tutorial'] = $this->dbconnection->select('video_tutorial','*','status="Y"');
        $this->data['video_tutorial'] = $this->db->query('select t1.id,t1.class_id,(select class_name from class where id=t1.class_id) as class_name,t1.subject_id,(select name from subject where id=t1.subject_id) as subject_name,t1.video_url,t1.title,t1.image_video,t1.lesson_date from video_tutorial t1 where status="Y"')->result();
        // $data = $this->dbconnection->select('user', '*', 'id=' . $this->session->userdata('user_id'));
        // $tid = $data[0]->employee_id;

        // $this->data['classs'] = $this->dbconnection->select("class", "id,class_name", "id IN (SELECT class_id FROM class_subject_teacher WHERE teacher_id=$tid)");

        // $this->data['tutorial'] = $this->dbconnection->select('tutorial','*','status="Y"');
        $this->load->view('index', $this->data);
    }

    function save()
    {
        
        $class_id = $this->input->post('v_class');
        $subject_id = $this->input->post('subject');
        $title = $this->input->post('title');
        $video_url = $this->input->post('video_url');
        $image_video = $this->input->post('image_video');
        $lesson_date = $this->input->post('lesson_date');


        $sch_id=$this->session->userdata('school_id');
        $photoimg_name=$_FILES['upload_data']['name'];
        $pic_img_name=$sch_id.'_'.time();
        $fileExt = pathinfo($photoimg_name, PATHINFO_EXTENSION);
        $photoimg_upload_name=$pic_img_name;
        $config['upload_path'] = 'tutorial_image/';
        $config['allowed_types'] = 'jpg|png|jpeg|pdf|msword';
        $config['file_name'] =$photoimg_upload_name;
        $config['overwrite'] = false;
        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        // $r=$_FILES["image"]["name"];
        // $config['upload_path'] = 'tutorial_image/';
        // $config['allowed_types'] = 'jpg|png';
        // $config['max_size'] = '2048000000';
        // $config['overwrite'] = FALSE;
        // $this->load->library('upload',$config);
        // $this->upload->initialize($config);
        //  $this->upload->do_upload('image');
        if($this->upload->do_upload('image'))
        {  
            $uploadData_1 = $this->upload->data();
            $image = $uploadData_1['file_name'];             
            $new_name = $sch_id.'_'.time().$uploadData_1['file_ext']; 
            
            // $homeattach = array('upload_data' => $this->upload->data());
            $array = array(
            'class_id'  => $class_id,
            'subject_id'  => $subject_id,
            'title'  => $title,
            'video_url'  => $video_url,
            'image_video'  => $new_name,
            'lesson_date'  => $lesson_date,
        );
       }

        $this->dbconnection->insert('video_tutorial', $array);
        $this->data['video_tutorial'] = $this->db->query('select t1.id,t1.class_id,(select class_name from class where id=t1.class_id) as class_name,t1.subject_id,(select name from subject where id=t1.subject_id) as subject_name,t1.video_url,t1.title,t1.image_video,t1.lesson_date from video_tutorial t1 where status="Y"')->result();
        ?>
        <table class="table table-bordered table-striped" id="book_publisher">
            <thead style="background:#99ceff;">
              <tr>
					    <th>Sl No.</th>
					    <th>CLass Name</th>
					    <th>Subject Name</th>
					    <th>Title</th>
					    <th>Video url</th>
					    <th>Date</th>
					    <th>Image</th>
					    <th>Action</th>
					  </tr>
            </thead>
            <tbody>
               <?php $x = 1;foreach($video_tutorial as $value){?>
		                <tr>
		                    <td><?php echo $x;?>.</td>
		                    <td><?php echo $value->class_name;?></td>
		                    <td><?php echo $value->subject_name;?></td>
		                    <td><?php echo $value->title;?></td>
		                    <td><?php echo $value->video_url;?></td>
		                    <td><?php echo $value->lesson_date;?></td>
		                    <td><?php echo $value->image_video;?></td>
		                    <td><a  data-toggle="tooltip" data-placement="top" title="Edit" onclick="update(<?php echo $value->id;?>)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a data-toggle="tooltip" data-placement="top" title="Delete" style="cursor: pointer;" onclick="deletes(<?php echo $value->id;?>)"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
		                </tr>
		                <?php $x++;}?>
            </tbody>
        </table>
        <script type="text/javascript">
            $(document).ready(function() {
              $('#book_publisher').DataTable();
            });
        </script>
    <?php
    }

    public function update()
    {
        $id=$this->input->post('id');
        $video_tutorial=$this->dbconnection->select("video_tutorial","*", "id='$id'");
        $hid=$video_tutorial[0]->id; 
        $title=$video_tutorial[0]->title; 
        $video_url=$video_tutorial[0]->video_url; 
        $lesson_date=$video_tutorial[0]->lesson_date; 
        $class_id=$video_tutorial[0]->class_id; 
        $subject_id=$video_tutorial[0]->subject_id; 
        $image_video=$video_tutorial[0]->image_video;       
              
        $array=array('hid'=>$hid,'title'=>$title,'video_url'=>$video_url,'lesson_date'=>$lesson_date,'class_id'=>$class_id,'subject_id'=>$subject_id,'image_video'=>$image_video);
        echo json_encode($array);
    }


    public function update_data()
    {
         $id=$this->input->post('hid');
       // $r=$_FILES["image"]["name"];
         $class_id = $this->input->post('v_class');
        $subject_id = $this->input->post('subject');
        $title = $this->input->post('title');
        $video_url = $this->input->post('video_url');
        // $image_video = $this->input->post('image_video');
        $lesson_date = $this->input->post('lesson_date');
            $array = array(
            'class_id'  => $class_id,
            'subject_id'  => $subject_id,
            'title'  => $title,
            'video_url'  => $video_url,
            // 'image_video'  => $r,
            'lesson_date'  => $lesson_date,
        );

            // print_r($array);
       

        $this->dbconnection->update('video_tutorial', $array,'id='.$id);
        $this->data['video_tutorial'] = $this->db->query('select t1.id,t1.class_id,(select class_name from class where id=t1.class_id) as class_name,t1.subject_id,(select name from subject where id=t1.subject_id) as subject_name,t1.video_url,t1.title,t1.image_video,t1.lesson_date from video_tutorial t1 where status="Y"')->result();
        ?>
        <table class="table table-bordered table-striped" id="book_publisher">
            <thead style="background:#99ceff;">
              <tr>
                        <th>Sl No.</th>
                        <th>CLass Name</th>
                        <th>Subject Name</th>
                        <th>Title</th>
                        <th>Video url</th>
                        <th>Date</th>
                        <th>Image</th>
                        <th>Action</th>
                      </tr>
            </thead>
            <tbody>
               <?php $x = 1;foreach($video_tutorial as $value){?>
                        <tr>
                            <td><?php echo $x;?>.</td>
                            <td><?php echo $value->class_name;?></td>
                            <td><?php echo $value->subject_name;?></td>
                            <td><?php echo $value->title;?></td>
                            <td><?php echo $value->video_url;?></td>
                            <td><?php echo $value->lesson_date;?></td>
                            <td><?php echo $value->image_video;?></td>
                            <td><a  data-toggle="tooltip" data-placement="top" title="Edit" onclick="update(<?php echo $value->id;?>)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a data-toggle="tooltip" data-placement="top" title="Delete" style="cursor: pointer;" onclick="deletes(<?php echo $value->id;?>)"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                        </tr>
                        <?php $x++;}?>
            </tbody>
        </table>
        <script type="text/javascript">
            $(document).ready(function() {
              $('#book_publisher').DataTable();
            });
        </script>
    <?php
    }
}
