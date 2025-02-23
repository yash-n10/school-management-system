<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Book_barcode extends CI_Controller {
    
    public $page_code = 'book_barcode';
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
       /* if (substr($this->right_access, 1, 1) != 'R') 
        {
            redirect('404');
        }*/
        $this->data['page_name'] = 'book_barcode';
        $this->data['page_title'] = 'Book Barcode';
        $this->data['section'] = 'library/print';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->data['category'] = $this->dbconnection->select("book_category", "*", "status='Y'");
        $this->data['publisher'] = $this->dbconnection->select("book_publisher", "*", "status='Y'");
        $this->data['author'] = $this->dbconnection->select("book_author", "*", "status='Y'");
        $this->data['location'] = $this->dbconnection->select("library_location", "*", "status='Y'");
        $this->load->view('index', $this->data);
    }

    public function getbook()
    {
        $category = $this->input->post('category');        
        $publisher = $this->input->post('publisher');        
        $author = $this->input->post('author');        
        $location = $this->input->post('location');
    	$almirah=$this->input->post('almirah');
    if($category){
        $where = "t2.book_category_id='$category'";
 	}

 	if($publisher){
 		$where ="t2.book_publisher_id='$publisher'"; 
 	}
 	if ($author) {
 		$where ="t2.book_author_id='$author'";
 	}
 	if ($location) {
 		$where="t2.library_location_id='$location'";
 	}
 	if ($almirah) {
 		$where="t2.almirah_no='$almirah'";
 	}
 // AND t2.book_publisher_id=$publisher AND t2.book_author_id=$author AND t2.library_location_id=$location
        $data = $this->db->query("SELECT t1.id,t1.acc_no,t1.book_id,t2.name FROM book_detail as t1 JOIN book as t2 ON t2.id=t1.book_id WHERE $where AND t2.status='Y'")->result();   
        

        $ret = '';
        // $ret=$data;
        foreach ($data as $key => $value) {
            
            $ret.="<tr> <td> <input type='checkbox' name='chkbox[]' class='checkBoxClass' value=$value->id></td>";
            $ret.="<td> $value->name </td>";
            $ret.="<td> $value->acc_no </td></tr>";
        }

        $arr = array('ret'=>$ret); 
        echo json_encode($arr);
    }

    public function prints()
    {   
      
    	$category = $this->input->post('category');
    	$publisher = $this->input->post('publisher');
    	$author = $this->input->post('author');
    	$location = $this->input->post('location');
    	$chkbox = $this->input->post('chkbox');
      
        $array = array('book'=>$chkbox);
        $this->load->view('library/print/barcode',$array);
        // $html = $this->output->get_output();
        // $this->load->library('pdf');
       

        // $this->dompdf->load_html($html);
        // $this->dompdf->set_paper('A4','portrait');
        // $this->dompdf->render();
        // ob_end_clean();
        // $this->dompdf->stream("Barcode.pdf", array("Attachment" => FALSE));        
    }

   



}
