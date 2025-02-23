<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Reports extends CI_Controller {
    
    public $page_code = 'reports';
    public $page_id = '';
    public $page_perm = '----';
    
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('Mymodel', 'm');

        $this->user_id = $this->session->userdata('user_id');
       
        $this->id = $this->session->userdata('school_id');
        $this->school_desc  = $this->dbconnection->select("school", "*", "id=" . $this->id . " and status = 1");
        if ($this->id != 0) {
            $this->db->db_select('crmfeesclub_' . $this->id);
        }
         /*$this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");
        $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
        $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
        $this->right_access = $this->page_perm;
        if (strpos($this->page_perm, '----') == true) {
            redirect(base_url(''), 'refresh');
        }*/
        //$this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y' and active='Y'", '', '', array('id'));
    }

    public function index()
    {
        /*if (substr($this->right_access, 1, 1) != 'R') 
        {
            redirect('404');
        }*/
        
        $this->data['page_name'] = 'report/report';
        $this->data['page_title'] = 'Reports';
        $this->data['section'] = 'library';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->load->view('index', $this->data);
    }

    public function get_data()
    {
        $type = $this->input->post('type');
        $data = '';
        $loc = $this->db->query("SELECT * FROM library_location WHERE status='Y'")->result();
        $cat = $this->db->query("SELECT * FROM book_category WHERE status='Y'")->result();
        $pub = $this->db->query("SELECT * FROM book_publisher WHERE status='Y'")->result();
        $ven = $this->db->query("SELECT * FROM book_vendor WHERE status='Y'")->result();
        $aut = $this->db->query("SELECT * FROM book_author WHERE status='Y'")->result();
        $acc = $this->db->query("SELECT id,acc_no FROM book_detail WHERE status='Y'")->result();
        $book = $this->db->query("SELECT id,name FROM book WHERE status='Y'")->result();
        if($type=='AR')
        {
            $data.= "<form>";
            $data.= "<div class='row col-md-4' style='padding: 0px 0px 0px 24px;'>";
            $data.= "<div class='form-group'>";
            $data.= "<label for='almirah'>Almirah No:</label>";
            $data.= "<input type='text' class='form-control' id='almirah' placeholder='Enter Almirah No.'>";
            $data.= "</div>";
            $data.= "<div class='form-group'>";
            $data.= "<label for='almirah'>Library Location:</label>";
            $data.= "<select class='form-control' id='location'>";
            foreach ($loc as $key => $value) 
            {
                $data.= "<option value='$value->id'>$value->name</option>";
            }
            $data.= "</select>";
            $data.= "</div>";
            $data.= "<a onclick='gets()' class='btn btn-primary'>GET</a>";            
            $data.= "</div>";
            $data.= "<div class='col-md-4' style='padding: 0px 0px 0px 40px;'>";
            $data.= "<div class='form-group'>";
            $data.= "<label for='rack'>Rack No:</label>";
            $data.= "<input type='text' class='form-control' id='rack' placeholder='Enter Rack No.'>";
            $data.= "</div>";
            $data.= "</div>";
            $data.= "</form>";
        }
        else if($type=='CA')
        {
            $data.= "<form>";
            $data.= "<div class='row col-md-4' style='padding: 0px 0px 0px 24px;'>";           
            $data.= "<div class='form-group'>";
            $data.= "<label for='almirah'>Category:</label>";
            $data.= "<select class='form-control' id='category'>";
            foreach ($cat as $key => $cat_value) 
            {
                $data.= "<option value='$cat_value->id'>$cat_value->category_name</option>";
            }
            $data.= "</select>";
            $data.= "</div>";
            $data.= "<div class='form-group'>";
            $data.= "<label for='almirah'>Library Location:</label>";
            $data.= "<select class='form-control' id='location'>";
            foreach ($loc as $key => $value) 
            {
                $data.= "<option value='$value->id'>$value->name</option>";
            }
            $data.= "</select>";
            $data.= "</div>";
            $data.= "<a onclick='get_ca()' class='btn btn-primary'>GET</a>";            
            $data.= "</div>";
        }
        else if($type=='PU')
        {
            $data.= "<form>";
            $data.= "<div class='row col-md-4' style='padding: 0px 0px 0px 24px;'>";           
            $data.= "<div class='form-group'>";
            $data.= "<label for='almirah'>Publisher:</label>";
            $data.= "<select class='form-control' id='publisher'>";
            foreach ($pub as $key => $pub_value) 
            {
                $data.= "<option value='$pub_value->id'>$pub_value->name</option>";
            }
            $data.= "</select>";
            $data.= "</div>";
            $data.= "<div class='form-group'>";
            $data.= "<label for='almirah'>Library Location:</label>";
            $data.= "<select class='form-control' id='location'>";
            foreach ($loc as $key => $value) 
            {
                $data.= "<option value='$value->id'>$value->name</option>";
            }
            $data.= "</select>";
            $data.= "</div>";
            $data.= "<a onclick='gets_pub()' class='btn btn-primary'>GET</a>";            
            $data.= "</div>";
        }
        else if($type=='VE')
        {
            $data.= "<form>";
            $data.= "<div class='row col-md-4' style='padding: 0px 0px 0px 24px;'>";           
            $data.= "<div class='form-group'>";
            $data.= "<label for='almirah'>Vendor:</label>";
            $data.= "<select class='form-control' id='vendor'>";
            foreach ($ven as $key => $ven_value) 
            {
                $data.= "<option value='$ven_value->id'>$ven_value->name</option>";
            }
            $data.= "</select>";
            $data.= "</div>";
            $data.= "<div class='form-group'>";
            $data.= "<label for='almirah'>Library Location:</label>";
            $data.= "<select class='form-control' id='location'>";
            foreach ($loc as $key => $value) 
            {
                $data.= "<option value='$value->id'>$value->name</option>";
            }
            $data.= "</select>";
            $data.= "</div>";
            $data.= "<a onclick='gets_ven()' class='btn btn-primary'>GET</a>";            
            $data.= "</div>";
        }
        else if($type=='AU')
        {
            $data.= "<form>";
            $data.= "<div class='row col-md-4' style='padding: 0px 0px 0px 24px;'>";           
            $data.= "<div class='form-group'>";
            $data.= "<label for='almirah'>Author:</label>";
            $data.= "<select class='form-control' id='author'>";
            foreach ($aut as $key => $aut_value) 
            {
                $data.= "<option value='$aut_value->id'>$aut_value->name</option>";
            }
            $data.= "</select>";
            $data.= "</div>";
            $data.= "<div class='form-group'>";
            $data.= "<label for='almirah'>Library Location:</label>";
            $data.= "<select class='form-control' id='location'>";
            foreach ($loc as $key => $value) 
            {
                $data.= "<option value='$value->id'>$value->name</option>";
            }
            $data.= "</select>";
            $data.= "</div>";
            $data.= "<a onclick='gets_aut()' class='btn btn-primary'>GET</a>";            
            $data.= "</div>";
        }

        else if($type=='AN')
        {
            $data.= "<form>";
            $data.= "<div class='row col-md-4' style='padding: 0px 0px 0px 24px;'>";           
            $data.= "<div class='form-group'>";
            $data.= "<label for='almirah'>Accession No:</label>";
            $data.= "<select class='form-control' id='accession'>";
            foreach ($acc as $key => $acc_value) 
            {
                $data.= "<option value='$acc_value->id'>$acc_value->acc_no</option>";
            }
            $data.= "</select>";
            $data.= "</div>";
            $data.= "<div class='form-group'><br><br><br>";            
            $data.= "</div>";
            $data.= "<a onclick='gets_acc()' class='btn btn-primary'>GET</a>";            
            $data.= "</div>";
        }
        else if($type=='BN')
        {
            $data.= "<form>";
            $data.= "<div class='row col-md-4' style='padding: 0px 0px 0px 24px;'>";           
            $data.= "<div class='form-group'>";
            $data.= "<label for='almirah'>Book/Document Name:</label>";
            $data.= "<select class='form-control' id='book_name' onchange='getBook(this)'>";
            foreach ($book as $key => $book_value) 
            {
                $data.= "<option value='$book_value->id'>$book_value->name</option>";
            }
            $data.= "</select>";
            $data.= "</div>";
            $data.= "<div class='form-group'>";
            $data.= "<label for='almirah'>Accession No:</label>";
            $data.= "<select class='form-control' id='acc'>";
            $data.= "<option value=''>Select Any One......</option>";
            $data.= "</select>";
            $data.= "</div>";
            $data.= "<a onclick='gets_book()' class='btn btn-primary'>GET</a>";            
            $data.= "</div>";
        }
        $array = array(           
            'datas'=>$data,
        );
        echo json_encode($array);
    }

    function get_div_data()
    {
        $almirah    = $this->input->post('almirah');
        $rack       = $this->input->post('rack');
        $location       = $this->input->post('location');
        if($rack=='')
        {
            $querys = $this->db->query("SELECT t1.name,t1.almirah_no,t1.rack_no,t2.acc_no,t2.isbn_no,t2.publish_year FROM book as t1 LEFT JOIN book_detail as t2 ON t1.id=t2.book_id WHERE t1.almirah_no='$almirah' AND library_location_id='$location'")->result();     
        }
        else
        {
            $querys = $this->db->query("SELECT t1.name,t1.almirah_no,t1.rack_no,t2.acc_no,t2.isbn_no,t2.publish_year FROM book as t1 LEFT JOIN book_detail as t2 ON t1.id=t2.book_id WHERE t1.almirah_no='$almirah' AND t1.rack_no='$rack' AND library_location_id='$location'")->result();     
        }
        
        
        $i = 1;
        $tb = "<table class='table table-striped table-dark' id='book_detail'>";
        $tb.= "<thead>";
        $tb.= "<tr>";
        $tb.= "<th scope='col'>S.No</th>";
        $tb.= "<th scope='col'>Document/Book Name</th>";
        $tb.= "<th scope='col'>Accession No</th>";
        $tb.= "<th scope='col'>Almirah No</th>";
        $tb.= "<th scope='col'>Rack No</th> "; 
        $tb.= "</tr>";
        $tb.= "</thead>";
        $tb.= "<tbody id='book_detail_student'>";
        foreach ($querys as $key => $value) 
        {
            $tb.= "<tr>";
            $tb.= "<td scope='col'>$i</td>";   
            $tb.= "<td scope='col'>$value->name</td>";   
            $tb.= "<td scope='col'>$value->acc_no</td>";   
            $tb.= "<td scope='col'>$value->almirah_no</td>";   
            $tb.= "<td scope='col'>$value->rack_no</td>";
            $tb.= "</tr>";   
        $i++;
        }
        $tb.= "</tbody>";   
        $tb.= "</table>";   
        $array = array(           
            'datas'=>$tb,
        );
        echo json_encode($array);
    }

    function get_ca_data()
    {        
        $category       = $this->input->post('category');
        $location       = $this->input->post('location');

        $querys = $this->db->query("SELECT t1.name,t2.acc_no,t2.isbn_no,t1.almirah_no,t1.rack_no FROM book as t1 JOIN book_detail as t2 ON t2.book_id=t1.id WHERE t1.book_category_id=$category AND t1.library_location_id=$location")->result();
        $i = 1;
        $tb = "<table class='table table-striped table-dark' id='book_detail'>";
        $tb.= "<thead>";
        $tb.= "<tr>";
        $tb.= "<th scope='col'>S.No</th>";
        $tb.= "<th scope='col'>Document/Book Name</th>";
        $tb.= "<th scope='col'>Accession No</th>";
        $tb.= "<th scope='col'>Almirah No</th>";
        $tb.= "<th scope='col'>Rack No</th> "; 
        $tb.= "</tr>";
        $tb.= "</thead>";
        $tb.= "<tbody id='book_detail_student'>";
        foreach ($querys as $key => $value) 
        {
            $tb.= "<tr>";
            $tb.= "<td scope='col'>$i</td>";   
            $tb.= "<td scope='col'>$value->name</td>";   
            $tb.= "<td scope='col'>$value->acc_no</td>";   
            $tb.= "<td scope='col'>$value->almirah_no</td>";   
            $tb.= "<td scope='col'>$value->rack_no</td>";
            $tb.= "</tr>";   
        $i++;
        }
        $tb.= "</tbody>";   
        $tb.= "</table>";   
        $array = array(           
            'datas'=>$tb,
        );
        echo json_encode($array);
    }

    function get_pub_data()
    {        
        $publisher      = $this->input->post('publisher');
        $location       = $this->input->post('location');

        $querys = $this->db->query("SELECT t1.name,t2.acc_no,t2.isbn_no,t1.almirah_no,t1.rack_no FROM book as t1 JOIN book_detail as t2 ON t2.book_id=t1.id WHERE t1.book_publisher_id=$publisher AND t1.library_location_id=$location")->result();
        $i = 1;
        $tb = "<table class='table table-striped table-dark' id='book_detail'>";
        $tb.= "<thead>";
        $tb.= "<tr>";
        $tb.= "<th scope='col'>S.No</th>";
        $tb.= "<th scope='col'>Document/Book Name</th>";
        $tb.= "<th scope='col'>Accession No</th>";
        $tb.= "<th scope='col'>Almirah No</th>";
        $tb.= "<th scope='col'>Rack No</th> "; 
        $tb.= "</tr>";
        $tb.= "</thead>";
        $tb.= "<tbody id='book_detail_student'>";
        foreach ($querys as $key => $value) 
        {
            $tb.= "<tr>";
            $tb.= "<td scope='col'>$i</td>";   
            $tb.= "<td scope='col'>$value->name</td>";   
            $tb.= "<td scope='col'>$value->acc_no</td>";   
            $tb.= "<td scope='col'>$value->almirah_no</td>";   
            $tb.= "<td scope='col'>$value->rack_no</td>";
            $tb.= "</tr>";   
        $i++;
        }
        $tb.= "</tbody>";   
        $tb.= "</table>";   
        $array = array(           
            'datas'=>$tb,
        );
        echo json_encode($array);
    }

    function get_ven_data()
    {        
        $vendor         = $this->input->post('vendor');
        $location       = $this->input->post('location');

        $querys = $this->db->query("SELECT t1.name,t2.acc_no,t2.isbn_no,t1.almirah_no,t1.rack_no FROM book as t1 JOIN book_detail as t2 ON t2.book_id=t1.id WHERE t1.book_vendor_id=$vendor AND t1.library_location_id=$location")->result();
        $i = 1;
        $tb = "<table class='table table-striped table-dark' id='book_detail'>";
        $tb.= "<thead>";
        $tb.= "<tr>";
        $tb.= "<th scope='col'>S.No</th>";
        $tb.= "<th scope='col'>Document/Book Name</th>";
        $tb.= "<th scope='col'>Accession No</th>";
        $tb.= "<th scope='col'>Almirah No</th>";
        $tb.= "<th scope='col'>Rack No</th> "; 
        $tb.= "</tr>";
        $tb.= "</thead>";
        $tb.= "<tbody id='book_detail_student'>";
        foreach ($querys as $key => $value) 
        {
            $tb.= "<tr>";
            $tb.= "<td scope='col'>$i</td>";   
            $tb.= "<td scope='col'>$value->name</td>";   
            $tb.= "<td scope='col'>$value->acc_no</td>";   
            $tb.= "<td scope='col'>$value->almirah_no</td>";   
            $tb.= "<td scope='col'>$value->rack_no</td>";
            $tb.= "</tr>";   
        $i++;
        }
        $tb.= "</tbody>";   
        $tb.= "</table>";   
        $array = array(           
            'datas'=>$tb,
        );
        echo json_encode($array);
    }

    function get_aut_data()
    {        
        $author         = $this->input->post('author');
        $location       = $this->input->post('location');

        $querys = $this->db->query("SELECT t1.name,t2.acc_no,t2.isbn_no,t1.almirah_no,t1.rack_no FROM book as t1 JOIN book_detail as t2 ON t2.book_id=t1.id WHERE t1.book_author_id=$author AND t1.library_location_id=$location")->result();
        $i = 1;
        $tb = "<table class='table table-striped table-dark' id='book_detail'>";
        $tb.= "<thead>";
        $tb.= "<tr>";
        $tb.= "<th scope='col'>S.No</th>";
        $tb.= "<th scope='col'>Document/Book Name</th>";
        $tb.= "<th scope='col'>Accession No</th>";
        $tb.= "<th scope='col'>Almirah No</th>";
        $tb.= "<th scope='col'>Rack No</th> "; 
        $tb.= "</tr>";
        $tb.= "</thead>";
        $tb.= "<tbody id='book_detail_student'>";
        foreach ($querys as $key => $value) 
        {
            $tb.= "<tr>";
            $tb.= "<td scope='col'>$i</td>";   
            $tb.= "<td scope='col'>$value->name</td>";   
            $tb.= "<td scope='col'>$value->acc_no</td>";   
            $tb.= "<td scope='col'>$value->almirah_no</td>";   
            $tb.= "<td scope='col'>$value->rack_no</td>";
            $tb.= "</tr>";   
        $i++;
        }
        $tb.= "</tbody>";   
        $tb.= "</table>";   
        $array = array(           
            'datas'=>$tb,
        );
        echo json_encode($array);
    }

    function get_accession()
    {
        $accession        = $this->input->post('accession');
        $querys = $this->db->query("SELECT t1.id,t1.acc_no,t1.book_id,t2.name,t2.almirah_no,t2.rack_no,t3.name as library_name FROM book_detail as t1 JOIN book as t2 ON t1.book_id=t2.id JOIN library_location as t3 ON t2.library_location_id=t3.id WHERE t1.id=$accession")->result();
        $i = 1;
        $tb = "<table class='table table-striped table-dark' id='book_detail'>";
        $tb.= "<thead>";
        $tb.= "<tr>";
        $tb.= "<th scope='col'>S.No</th>";
        $tb.= "<th scope='col'>Document/Book Name</th>";
        $tb.= "<th scope='col'>Accession No</th>";
        $tb.= "<th scope='col'>Almirah No</th>";
        $tb.= "<th scope='col'>Rack No</th> "; 
        $tb.= "<th scope='col'>Library Location</th> "; 
        $tb.= "</tr>";
        $tb.= "</thead>";
        $tb.= "<tbody id='book_detail_student'>";
        foreach ($querys as $key => $value) 
        {
            $tb.= "<tr>";
            $tb.= "<td scope='col'>$i</td>";   
            $tb.= "<td scope='col'>$value->name</td>";   
            $tb.= "<td scope='col'>$value->acc_no</td>";   
            $tb.= "<td scope='col'>$value->almirah_no</td>";   
            $tb.= "<td scope='col'>$value->rack_no</td>";
            $tb.= "<td scope='col'>$value->library_name</td>";
            $tb.= "</tr>";   
        $i++;
        }
        $tb.= "</tbody>";   
        $tb.= "</table>";   
        $array = array(           
            'datas'=>$tb,
        );
        echo json_encode($array);
    }

    function get_accession_by_book()
    {
        $accession   = $this->input->post('accession');
        $querys = $this->db->query("SELECT t1.id,t1.acc_no,t1.book_id,t2.name,t2.almirah_no,t2.rack_no,t3.name as library_name FROM book_detail as t1 JOIN book as t2 ON t1.book_id=t2.id JOIN library_location as t3 ON t2.library_location_id=t3.id WHERE t1.id=$accession")->result();
        $i = 1;
        $tb = "<table class='table table-striped table-dark' id='book_detail'>";
        $tb.= "<thead>";
        $tb.= "<tr>";
        $tb.= "<th scope='col'>S.No</th>";
        $tb.= "<th scope='col'>Document/Book Name</th>";
        $tb.= "<th scope='col'>Accession No</th>";
        $tb.= "<th scope='col'>Almirah No</th>";
        $tb.= "<th scope='col'>Rack No</th> "; 
        $tb.= "<th scope='col'>Library Location</th> "; 
        $tb.= "</tr>";
        $tb.= "</thead>";
        $tb.= "<tbody id='book_detail_student'>";
        foreach ($querys as $key => $value) 
        {
            $tb.= "<tr>";
            $tb.= "<td scope='col'>$i</td>";   
            $tb.= "<td scope='col'>$value->name</td>";   
            $tb.= "<td scope='col'>$value->acc_no</td>";   
            $tb.= "<td scope='col'>$value->almirah_no</td>";   
            $tb.= "<td scope='col'>$value->rack_no</td>";
            $tb.= "<td scope='col'>$value->library_name</td>";
            $tb.= "</tr>";   
        $i++;
        }
        $tb.= "</tbody>";   
        $tb.= "</table>";   
        $array = array(           
            'datas'=>$tb,
        );
        echo json_encode($array);
    }

    function get_accession_bybook()
    {
        $book_id = $this->input->post('book_id');
        $querys = $this->db->query("SELECT t2.id,t2.acc_no FROM book as t1 JOIN book_detail as t2 ON t1.id=t2.book_id WHERE t1.id=$book_id")->result();
        $tb.= "<option value=''>Select Any One......</option>";
        foreach ($querys as $key => $value) 
        {
            $tb.= "<option value='$value->id'>$value->acc_no</option>";
            $i++;
        }
        $array = array(           
            'datas'=>$tb,
        );
        echo json_encode($array);
    }
}