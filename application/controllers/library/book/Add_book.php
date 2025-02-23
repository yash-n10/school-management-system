<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Add_book extends CI_Controller {
    
    public $page_code = 'add_book';
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

        $this->data['category']  = $this->dbconnection->select("book_category", "*", "status='Y'");
        $this->data['publisher']  = $this->dbconnection->select("book_publisher", "*", "status='Y'");
        $this->data['author']  = $this->dbconnection->select("book_author", "*", "status='Y'");
        $this->data['vendor']  = $this->dbconnection->select("book_vendor", "*", "status='Y'");
        $this->data['library_location']  = $this->dbconnection->select("library_location", "*", "status='Y'");
        $this->data['page_name'] = 'book/add_book';
        $this->data['page_title'] = 'Add Book';
        $this->data['section'] = 'library';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->load->view('index', $this->data);
    }

    public function add()
    {
    	$category 	= $this->input->post('category');
    	$name 		= $this->input->post('name');
    	$publisher 	= $this->input->post('publisher');
    	$author 	= $this->input->post('author');
    	$vendor 	= $this->input->post('vendor');
    	$location 	= $this->input->post('location');
    	$almirah 	= $this->input->post('almirah');
    	$rack 		= $this->input->post('rack');
    	$quantity 	= $this->input->post('quantity');

    	$array = array(
    		'book_category_id'		=>	$category,
    		'name'					=>	$name,
    		'book_publisher_id'		=>	$publisher,
    		'book_author_id'		=>	$author,
    		'book_vendor_id'		=>	$vendor,
    		'library_location_id'	=>	$location,
    		'almirah_no'			=>	$almirah,
    		'rack_no'				=>	$rack,
    		'quantity'				=>	$quantity,
    		'created_by'			=>	$this->user_id,
    		'ip'					=>	$_SERVER['REMOTE_ADDR'],
    	);

    	$this->dbconnection->insert('book', $array);
    	$last_id = $this->db->insert_id();

    	$ids 	= $this->input->post('ids');
    	
    	foreach ($ids as $key => $value) {
    		$detail =array(
    			'book_id' 		=> $last_id,
    			'acc_no' 		=> $this->input->post('accession')[$key],
    			'isbn_no' 		=> $this->input->post('isbn')[$key],
    			'publish_year' 	=> $this->input->post('pub_year')[$key],
    			'edition' 		=> $this->input->post('edition')[$key],
    			'cost' 			=> $this->input->post('cost')[$key],
    			'page_no' 		=> $this->input->post('page')[$key],
    			'created_by'	=> $this->user_id,
    			'ip' 			=> $_SERVER['REMOTE_ADDR'],
    		);
    		$this->dbconnection->insert('book_detail', $detail);    		
            
    	}
        redirect('library/book/book_list');
    }
    public function edit_book($id)
    {
        $this->data['category']  = $this->dbconnection->select("book_category", "*", "status='Y'");
        $this->data['publisher']  = $this->dbconnection->select("book_publisher", "*", "status='Y'");
        $this->data['author']  = $this->dbconnection->select("book_author", "*", "status='Y'");
        $this->data['vendor']  = $this->dbconnection->select("book_vendor", "*", "status='Y'");
        $this->data['library_location']  = $this->dbconnection->select("library_location", "*", "status='Y'");
        $this->data['book']=$data=$this->dbconnection->select("book", "*", "id='$id'");
        $this->data['book_detail']=$book_details=$this->dbconnection->select("book_detail", "*", "book_id='$id'");
        
        $this->data['page_name'] = 'book/edit_book';
        $this->data['page_title'] = 'Edit Book';
        $this->data['section'] = 'library';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        // echo "<prev(array)>";print_r($this->data);die();
        $this->load->view('index', $this->data);

    }
    
   public function update_data()
    {
        $id         = $this->input->post('book_id');
        $category   = $this->input->post('category');
        $name       = $this->input->post('name');
        $publisher  = $this->input->post('publisher');
        $author     = $this->input->post('author');
        $vendor     = $this->input->post('vendor');
        $location   = $this->input->post('location');
        $almirah    = $this->input->post('almirah');
        $rack       = $this->input->post('rack');
        $quantity   = $this->input->post('quantity');

        //UPDATE IN BOOK_DETAIL
        $isbn = $this->input->post('isbn[0]');
        $edition = $this->input->post('edition[0]');
        $cost = $this->input->post('cost[0]');
        $page = $this->input->post('page[0]');
        $publish = $this->input->post('pub_year[0]');

        $array = array(
            'book_category_id'      =>  $category,
            'name'                  =>  $name,
            'book_publisher_id'     =>  $publisher,
            'book_author_id'        =>  $author,
            'book_vendor_id'        =>  $vendor,
            'library_location_id'   =>  $location,
            'almirah_no'            =>  $almirah,
            'rack_no'               =>  $rack,/*
            'quantity'              =>  $quantity,*/
            'last_date_modified'    =>  date('Y-m-d H:i:s'),
            'last_modified_by'      =>  $this->user_id,
        );
$array2= array('isbn_no' =>$isbn ,'publish_year'=>$publish,'edition'=>$edition,'cost'=> $cost,'page_no'=>$page);
// echo"<pre>";print_r($array2);die();
        $this->dbconnection->update('book',$array,'id='.$id);
        $this->dbconnection->update('book_detail',$array2,'id='.$id);
        $this->session->set_flashdata('successmsg', "Successfully Updated.");
        redirect('library/book/add_book/edit_book/'.$id);
    }
}