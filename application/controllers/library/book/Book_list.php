<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Book_list extends CI_Controller {
    
    public $page_code = 'book_list';
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

        $this->admission_csv_columns = array(
                array('field' => 'book_cat', 'human_name' => 'Book Category'),//0
                array('field' => 'book_name', 'human_name' => 'Book Name'),//1
                array('field' => 'publisher', 'human_name' => 'Publisher'),//3
                array('field' => 'edition', 'human_name' => 'Edition'),//4
                array('field' => 'actual_qty', 'human_name' => 'Quantity'),//5
                array('field' => 'year_published', 'human_name' => 'Year Published'),//8
                array('field' => 'author', 'human_name' => 'Author'),
                array('field' => 'publisher', 'human_name' => 'Publisher'),
                array('field' => 'binding_type', 'human_name' => 'Binding Type'),
                array('field' => 'cost', 'human_name' => 'Cost'),
                array('field' => 'description', 'human_name' => 'Description'),
                array('field' => 'for_class', 'human_name' => 'For Class'),
                array('field' => 'location', 'human_name' => 'location'),
                array('field' => 'isbn', 'human_name' => 'ISBN'),
                array('field' => 'vendor', 'human_name' => 'Source/Vendor'),
                array('field' => 'entry_date', 'human_name' => 'Date'),
                array('field' => 'page_no', 'human_name' => 'Page No'),
                );
    }

    public function index()
    {
        if (substr($this->right_access, 1, 1) != 'R') 
        {
            redirect('404');
        }

        //$this->data['book']  = $this->dbconnection->select("book", "*", "status='Y'");
        $this->data['book']  = $this->db->query("SELECT t1.*,t3.name as type_name,t2.category_name FROM book as t1 JOIN book_category as t2 ON t2.id=t1.book_category_id JOIN book_type as t3 ON t3.id=t2.type_id WHERE t1.status='Y'")->result();
        $this->data['page_name'] = 'book/book_list';
        $this->data['page_title'] = 'Book Lists';
        $this->data['section'] = 'library';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->load->view('index', $this->data);
    }

    public function delete()
    {
        $id = $this->input->post(id);
        $array = array('id'=>$id);
        $this->dbconnection->delete('book',$array);
        $array_detail = array('book_id'=>$id);
        $this->dbconnection->delete('book_detail',$array_detail);
        $book = $this->db->query("SELECT t1.*,t3.name as type_name,t2.category_name FROM book as t1 JOIN book_category as t2 ON t2.id=t1.book_category_id JOIN book_type as t3 ON t3.id=t2.type_id WHERE t1.status='Y'")->result();
        ?>
        <table class="table table-bordered table-striped" id="book_list">
            <thead style="background:#99ceff;">
              <tr>
                <th>Sl No.</th>
                <th>Type</th>
                <th>Category</th>
                <th>Name</th>
                <th>Almirah No</th>
                <th>Rack No</th>
                <th>Created At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                <?php 
                $i = 1;
                foreach($book as $value){?>
                    <tr>
                        <td><?php echo $i;?></td>
                        <td><?php echo $value->type_name;?></td>
                        <td><?php echo $value->category_name;?></td>
                        <td><?php echo $value->name;?></td>
                        <td><?php echo $value->almirah_no;?></td>
                        <td><?php echo $value->rack_no;?></td>
                        <td><?php echo date('d-m-Y',strtotime($value->date_created));?></td>
                        <td><a href="#"><i class="fa fa-eye" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;<a href="#"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;<a style="cursor: pointer;" onclick="deletes(<?php echo $value->id;?>)"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                    </tr>
                <?php $i++;}?>
            </tbody>
        </table>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#book_list').DataTable();
            });
        </script>
    <?php
    }


    public function importcsv() {

        $this->data['page_name'] = 'upload_books';
        $this->data['page_title'] = 'Upload Books';
        $this->data['section'] = 'library/book';
        $this->data['customview'] = '';
        $this->data['category']  = $this->dbconnection->select("book_category", "*", "status='Y'");
        $this->data['publisher']  = $this->dbconnection->select("book_publisher", "*", "status='Y'");
        $this->data['author']  = $this->dbconnection->select("book_author", "*", "status='Y'");
        $this->data['vendor']  = $this->dbconnection->select("book_vendor", "*", "status='Y'");
        $this->data['library_location']  = $this->dbconnection->select("library_location", "*", "status='Y'");
        $this->load->view('index', $this->data);
    }

    public function download_format() {
        $this->load->helper('download');
        $fh = fopen('php://memory', 'w');
        
        fputcsv($fh, array_column($this->admission_csv_columns, 'human_name'));
        fseek($fh, 0);
        $csv = stream_get_contents($fh);
        $school_code=$this->session->userdata('school_code');
        force_download($school_code.'-Book-NewUPLOAD-Format.csv', $csv);
    }
}