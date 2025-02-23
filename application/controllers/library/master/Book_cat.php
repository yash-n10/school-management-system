<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Book_cat extends CI_Controller {
    
    public $page_code = 'book_category';
    public $page_id = '';
    public $page_perm = '----';
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Mymodel', 'm');

        $this->user_id = $this->session->userdata('user_id');
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

    public function index()
    {
        if (substr($this->right_access, 1, 1) != 'R') 
        {
            redirect('404');
        }

        $this->data['type']  = $this->dbconnection->select("book_type", "*", "");
        $this->data['category'] = $this->dbconnection->select_join("book_category as t1", "t1.*,t2.name", "t1.status='Y'","book_type as t2","t2.id=t1.type_id","");
        $this->data['page_name'] = 'master/book_category';
        $this->data['page_title'] = 'Book Category';
        $this->data['section'] = 'library';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->load->view('index', $this->data);
    }

    function save()
    {
        $type = $this->input->post('type');
        $cate = $this->input->post('cate');
        $book_std = $this->input->post('book_std');
        $book_staff =$this->input->post('book_staff');
        $day_std =$this->input->post('day_std');
        $day_staff =$this->input->post('day_staff');
        $fine_staff =$this->input->post('fine_staff');
        $fine_std =$this->input->post('fine_std');

        $array = array(
            'type_id'  => $type,
            'category_name'  => $cate,
            'day_alot_stud'  => $day_std,
            'stud_book_alot'  => $book_std,
            'staff_book_alot'  => $book_staff,
            'day_alot_staff'  => $day_staff,
            'fine_stud'  => $fine_std,
            'fine_staff'  => $fine_staff,
            'created_by' => $this->user_id,
            'ip' =>$_SERVER['REMOTE_ADDR'],
        );
      
        $this->dbconnection->insert('book_category', $array);
        $category = $this->dbconnection->select_join("book_category as t1", "t1.*,t2.name", "t1.status='Y'","book_type as t2","t2.id=t1.type_id","");
        ?>
        <table class="table table-bordered table-striped" id="book_category">
            <thead style="background:#99ceff;">
              <tr>
                <th>Sl No.</th>
                <th>Type</th>
                <th>Category Name</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                <?php $x = 1;foreach($category as $value){?>
                <tr>
                    <td><?php echo $x;?>.</td>
                    <td><?php echo $value->name;?></td>
                    <td><?php echo $value->category_name;?></td>
                    <td><?php echo date('d/m/Y',strtotime($value->date_created));?></td>
                    <td><a href="" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a data-toggle="tooltip" data-placement="top" title="Delete" style="cursor: pointer;" onclick="deletes(<?php echo $value->id;?>)"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                </tr>
                <?php $x++;}?>
            </tbody>
        </table>
        <script type="text/javascript">
            $(document).ready(function() {
              $('#book_category').DataTable();
            });
        </script>
    <?php
    }

    function delete()
    {
        $id = $this->input->post(id);
        $array = array('id'=>$id);
        $this->dbconnection->delete('book_category',$array);
        $category = $this->dbconnection->select_join("book_category as t1", "t1.*,t2.name", "t1.status='Y'","book_type as t2","t2.id=t1.type_id","");
        ?>
        <table class="table table-bordered table-striped" id="book_category">
            <thead style="background:#99ceff;">
              <tr>
                <th>Sl No.</th>
                <th>Type</th>
                <th>Category Name</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                <?php $x = 1;foreach($category as $value){?>
                <tr>
                    <td><?php echo $x;?>.</td>
                    <td><?php echo $value->name;?></td>
                    <td><?php echo $value->category_name;?></td>
                    <td><?php echo date('d/m/Y',strtotime($value->date_created));?></td>
                    <td><a href="" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a data-toggle="tooltip" data-placement="top" title="Delete" style="cursor: pointer;" onclick="deletes(<?php echo $value->id;?>)"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                </tr>
                <?php $x++;}?>
            </tbody>
        </table>
        <script type="text/javascript">
            $(document).ready(function() {
              $('#book_category').DataTable();
            });
        </script>
        <?php
    }
    public   function update()
    {
        $id=$this->input->post('id');
        $book_cat=$this->dbconnection->select("book_category", "*", "id='$id'");
        $hid=$book_cat[0]->id; 
        $type_id=$book_cat[0]->type_id; 
        $cate =  $book_cat[0]->category_name;
        $book_std = $book_cat[0]->stud_book_alot;
        $book_staff =$book_cat[0]->day_alot_stud;
        $day_std =$book_cat[0]->day_alot_stud;
        $day_staff =$book_cat[0]->day_alot_staff;
        $fine_staff =$book_cat[0]->fine_staff;
        $fine_std =$book_cat[0]->fine_stud;
        $type  = $this->dbconnection->select("book_type", "*", "");
        $tid=$type->id;
        $typess='';
        //$return = "<option value=''>Select</option>";
        foreach ($type  as $key => $value) 
        {
        	if($tid==$type_id)
        	{
             $typess .= "<option value='$value->id' selected>$value->name llll</option>";
        	}
        	else
        	{
        	$typess .= "<option value='$value->id' selected>$value->name momkojoi</option>";	
        	}
        }

         $array=array('cat'=>$cate,'book_std'=>$book_std,'book_staff'=>$book_staff,'day_std'=> $day_std,'day_staff'=> $day_staff,'fine_std'=>$fine_std,'fine_staff'=>$fine_staff,'typess'=>$typess,'hid'=>$hid);
         echo json_encode($array);
    }
      
      

       
    public function update_data()
    {
        
       
        $type = $this->input->post('type');
        $cate = $this->input->post('cate');
        $book_std = $this->input->post('book_std');
        $book_staff =$this->input->post('book_staff');
        $day_std =$this->input->post('day_std');
        $day_staff =$this->input->post('day_staff');
        $fine_staff =$this->input->post('fine_staff');
        $fine_std =$this->input->post('fine_std');
        $hid =$this->input->post('hid');

        $array = array(
            'type_id'  => $type,
            'category_name'  => $cate,
            'day_alot_stud'  => $day_std,
            'stud_book_alot'  => $book_std,
            'staff_book_alot'  => $book_staff,
            'day_alot_staff'  => $day_staff,
            'fine_stud'  => $fine_std,
            'fine_staff'  => $fine_staff,
            
        );
       
      $this->dbconnection->update('book_category',$array,'id='.$hid);
   
     $category = $this->dbconnection->select_join("book_category as t1", "t1.*,t2.name", "t1.status='Y'","book_type as t2","t2.id=t1.type_id","");
        ?>
        <table class="table table-bordered table-striped" id="book_category">
            <thead style="background:#99ceff;">
              <tr>
                <th>Sl No.</th>
                <th>Type</th>
                <th>Category Name</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                <?php $x = 1;foreach($category as $value){?>
                <tr>
                    <td><?php echo $x;?>.</td>
                    <td><?php echo $value->name;?></td>
                    <td><?php echo $value->category_name;?></td>
                    <td><?php echo date('d/m/Y',strtotime($value->date_created));?></td>
                    <td><a href="" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a data-toggle="tooltip" data-placement="top" title="Delete" style="cursor: pointer;" onclick="deletes(<?php echo $value->id;?>)"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                </tr>
                <?php $x++;}?>
            </tbody>
        </table>
        <script type="text/javascript">
            $(document).ready(function() {
              $('#book_category').DataTable();
            });
        </script>
    <?php
    }
}