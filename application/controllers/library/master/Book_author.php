<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Book_author extends CI_Controller {
    
    public $page_code = 'book_author';
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
        $this->data['author_data'] = $this->dbconnection->select("book_author", "*", "status='Y'");
        $this->data['page_name'] = 'master/book_author';
        $this->data['page_title'] = 'Book Author';
        $this->data['section'] = 'library';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->load->view('index', $this->data);
    }

    function save()
    {
        $author = $this->input->post('author');

        $array = array(
            'name'  => $author,
            'created_by' => $this->user_id,
            'ip' =>$_SERVER['REMOTE_ADDR'],
        );

        $this->dbconnection->insert('book_author', $array);
        $author_data = $this->dbconnection->select("book_author", "*", "status='Y'");
        ?>
        <table class="table table-bordered table-striped" id="book_author">
            <thead style="background:#99ceff;">
              <tr>
                <th>Sl No.</th>
                <th>Author Name</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                <?php $x = 1;foreach($author_data as $value){?>
                <tr>
                    <td><?php echo $x;?>.</td>
                    <td><?php echo $value->name;?></td>
                    <td><?php echo date('d/m/Y',strtotime($value->date_created));?></td>
                    <td><a href="" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a data-toggle="tooltip" data-placement="top" title="Delete" style="cursor: pointer;" onclick="deletes(<?php echo $value->id;?>)"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                </tr>
                <?php $x++;}?>
            </tbody>
        </table>
        <script type="text/javascript">
            $(document).ready(function(){
              $('#book_author').DataTable();
            });
        </script>
    <?php
    }

    function delete()
    {
        $id = $this->input->post(id);
        $array = array('id'=>$id);
        $this->dbconnection->delete('book_author',$array);
        $publisher_data = $this->dbconnection->select("book_author", "*", "status='Y'");
        ?>
        <table class="table table-bordered table-striped" id="book_author">
            <thead style="background:#99ceff;">
              <tr>
                <th>Sl No.</th>
                <th>Publisher Name</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                <?php $x = 1;foreach($publisher_data as $value){?>
                <tr>
                    <td><?php echo $x;?>.</td>
                    <td><?php echo $value->name;?></td>
                    <td><?php echo date('d/m/Y',strtotime($value->date_created));?></td>
                    <td><a href="" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a data-toggle="tooltip" data-placement="top" title="Delete" style="cursor: pointer;" onclick="deletes(<?php echo $value->id;?>)"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                </tr>
                <?php $x++;}?>
            </tbody>
        </table>
        <script type="text/javascript">
            $(document).ready(function() {
              $('#book_author').DataTable();
            });
        </script>
        <?php
    }
       public   function update()
    {
        $id=$this->input->post('id');
        $book_cat=$this->dbconnection->select("book_author", "*", "id='$id'");
        $hid=$book_cat[0]->id; 
        $name=$book_cat[0]->name; 
       
       
       
         $array=array('hid'=>$hid,'name'=>$name);
         echo json_encode($array);
    }
     public function update_data()
    {
        
       
        $type = $this->input->post('author');
        $hid = $this->input->post('hid');
      
//print_r($_POST);exit;
        $array = array(
            'name'  => $type,
            
        );
       
      $this->dbconnection->update('book_author',$array,'id='.$hid);
   
     
        $author_data = $this->dbconnection->select("book_author", "*", "status='Y'");
        ?>
        <table class="table table-bordered table-striped" id="book_author">
            <thead style="background:#99ceff;">
              <tr>
                <th>Sl No.</th>
                <th>Author Name</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                <?php $x = 1;foreach($author_data as $value){?>
                <tr>
                    <td><?php echo $x;?>.</td>
                    <td><?php echo $value->name;?></td>
                    <td><?php echo date('d/m/Y',strtotime($value->date_created));?></td>
                    <td><a href="" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a data-toggle="tooltip" data-placement="top" title="Delete" style="cursor: pointer;" onclick="deletes(<?php echo $value->id;?>)"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                </tr>
                <?php $x++;}?>
            </tbody>
        </table>
        <script type="text/javascript">
            $(document).ready(function(){
              $('#book_author').DataTable();
            });
        </script>
    <?php
}
}