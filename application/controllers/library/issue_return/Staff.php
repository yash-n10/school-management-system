<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staff extends CI_Controller {
    
    public $page_code = 'staff';
    public $page_id = '';
    public $page_perm = '----';
    
    public function __construct() 
    {
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
        
        $this->data['page_name'] = 'issue_return/staff';
        $this->data['page_title'] = 'Issue Return (STAFF)';
        $this->data['section'] = 'library';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->load->view('index', $this->data);
    }

    function getdata()
    {
        $stu_id = $this->input->post('stu_id');
        $gets = $this->input->post('gets');
        if($gets=='A')
        {
            $data_tmp_book_issue = $this->db->query("SELECT t1.*,t2.acc_no,t2.isbn_no,t3.name,t3.book_publisher_id,t3.almirah_no,t3.rack_no FROM book_issue as t1 JOIN book_detail as t2 ON t2.id=t1.book_detail_id JOIN book as t3 ON t3.id=t1.book_id WHERE t1.created_by=$this->user_id AND t1.st_id=$stu_id AND t1.issue_user_type='STA' AND t1.status='Y' ORDER BY t1.id DESC")->result();
        }
        else
        {
            $data_tmp_book_issue = $this->db->query("SELECT t1.*,t2.acc_no,t2.isbn_no,t3.name,t3.book_publisher_id,t3.almirah_no,t3.rack_no FROM book_issue as t1 JOIN book_detail as t2 ON t2.id=t1.book_detail_id JOIN book as t3 ON t3.id=t1.book_id WHERE t1.created_by=$this->user_id AND t1.st_id=$stu_id AND t1.issue_user_type='STA' AND t1.status='Y' AND t1.issue_status='$gets' ORDER BY t1.id DESC")->result();
        }
        
        $x=1;
        $tb = "<table class='table table-striped table-dark' id='book_detail'>";
        $tb.= "<thead>";
        $tb.= "<tr>";
        $tb.= "<th scope='col'>S.No</th>";
        $tb.= "<th scope='col'>Document/Book Name</th>";
        $tb.= "<th scope='col'>Accession No</th>";
        $tb.= "<th scope='col'>Issued Date</th>";
        $tb.= "<th scope='col'>Submission Date</th> ";                                   
        $tb.= "<th scope='col'>Returned Date</th>";                                 
        $tb.= "<th scope='col'>Late Fine</th>";                                 
        $tb.= "<th scope='col'>Action</th>";
        $tb.= "</tr>";
        $tb.= "</thead>";
        $tb.= "<tbody id='book_detail_student'>";
        foreach ($data_tmp_book_issue as $key => $value) 
        {
            $id = $value->id;
            $status = $value->issue_status;
            if($status=='I')
            {
                $color = 'ISSUE';
            }
            else if($status=='L')
            {
                $color = 'LATE';
            }
            else
            {
                $color = 'RETURN';
            }
            $tb.= "<tr class='$color'>";
            $tb.= "<th scope='row'>$x</th>";
            $tb.= "<td>$value->name</td>";
            $tb.= "<td>$value->acc_no</td>";
            $tb.= "<td>$value->issue_from_date</td>";
            $tb.= "<td>$value->issue_to_date</td>";
            $tb.= "<td>$value->returned_date</td>";
            $tb.= "<td>&#x20B9; $value->fine_fees</td>";
            if($status=='I')
            {
            $tb.= "<td><a class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Return' onclick='return_book($value->id)'><span><i class='fa fa-undo'></i>&nbsp;</span></a></td>";
            }
            else if($status=='L')
            {
            $tb.= "<td><a class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Return' onclick='return_book($value->id)'><span><i class='fa fa-undo'></i>&nbsp;</span></a></td>";
            }
            else{
            $tb.="<td></td>";
            }
            $tb.="</tr>";   
            $x++;
        }
        $tb.= "</tbody>";
        $tb.= "</table>";
        $array = array(           
            'datas'=>$tb,
        );
        echo json_encode($array);
    }

    function get_detail()
    {
        $no = $this->input->post('adm_no');
        
        $data = $this->db->query("SELECT t1.* FROM employee as t1 WHERE t1.employee_code='$no'")->result();
        $emp_id         = $data[0]->id;
        $employee_code  = $data[0]->employee_code;
        $name           = $data[0]->name;
        $class          = $data[0]->class_name;
        $section        = $data[0]->sec_name;
        $user_id        = $this->user_id;
        
        /***************LATE DAYS UPDATE***************/
        $this->db->query("UPDATE book_issue SET issue_status='L' WHERE str_to_date(issue_to_date,'%d-%m-%Y') < DATE(NOW()) AND issue_status='I'");
        
        /****************UPDATE LATE FEES FINE******************/
        $update_tmp_book_issue = $this->db->query("SELECT t1.*,t2.acc_no,t2.isbn_no,t3.name,t3.book_publisher_id,t3.almirah_no,t3.rack_no,t4.fine_stud as fine FROM book_issue as t1 JOIN book_detail as t2 ON t2.id=t1.book_detail_id JOIN book as t3 ON t3.id=t1.book_id JOIN book_category as t4 ON t4.id=t3.book_category_id WHERE t1.created_by=$this->user_id AND t1.st_id=$stu_id AND t1.issue_user_type='STA' AND t1.status='Y' AND t1.issue_status='L' ORDER BY t1.id DESC")->result();

        foreach ($update_tmp_book_issue as $key) 
        {
            $ids = $key->id;
            $fine = $key->fine;
            $query_days = $this->db->query("SELECT DATEDIFF(DATE(NOW()),str_to_date(issue_to_date,'%d-%m-%Y')) as difference FROM book_issue WHERE str_to_date(issue_to_date,'%d-%m-%Y') < DATE(NOW()) AND issue_status='L' AND id=$ids")->result();
            $diff =  $query_days[0]->difference * $fine;
            $this->db->query("UPDATE book_issue SET fine_fees=$diff WHERE id=$ids");
        }

        $data_tmp_book_issue = $this->db->query("SELECT t1.*,t2.acc_no,t2.isbn_no,t3.name,t3.book_publisher_id,t3.almirah_no,t3.rack_no,t4.fine_stud as fine FROM book_issue as t1 JOIN book_detail as t2 ON t2.id=t1.book_detail_id JOIN book as t3 ON t3.id=t1.book_id JOIN book_category as t4 ON t4.id=t3.book_category_id WHERE t1.created_by=$this->user_id AND t1.st_id=$stu_id AND t1.issue_user_type='STA' AND t1.status='Y' ORDER BY t1.id DESC")->result();
        
        $x=1;
        $tb = "<table class='table table-striped table-dark' id='book_detail'>";
        $tb.= "<thead>";
        $tb.= "<tr>";
        $tb.= "<th scope='col'>S.No</th>";
        $tb.= "<th scope='col'>Document/Book Name</th>";
        $tb.= "<th scope='col'>Accession No</th>";
        $tb.= "<th scope='col'>Issued Date</th>";
        $tb.= "<th scope='col'>Submission Date</th> ";                                   
        $tb.= "<th scope='col'>Returned Date</th>";                                 
        $tb.= "<th scope='col'>Late Fine</th>";                                   
        $tb.= "<th scope='col'>Action</th>";
        $tb.= "</tr>";
        $tb.= "</thead>";
        $tb.= "<tbody id='book_detail_student'>";
        foreach ($data_tmp_book_issue as $key => $value) 
        {
            $id = $value->id;          
            $status = $value->issue_status;
            $fine = $value->fine_fees;
            if($status=='I')
            {
                $color = 'ISSUE';
            }
            else if($status=='L')
            {
                $color = 'LATE';
            }
            else
            {
                $color = 'RETURN';
            }
            $tb.= "<tr class='$color'>";
            $tb.= "<th scope='row'>$x</th>";
            $tb.= "<td>$value->name</td>";
            $tb.= "<td>$value->acc_no</td>";
            $tb.= "<td>$value->issue_from_date</td>";
            $tb.= "<td>$value->issue_to_date</td>";
            $tb.= "<td>$value->returned_date</td>";
            $tb.= "<td>&#x20B9; $fine</td>";
            if($status=='I')
            {
            $tb.= "<td><a class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Return' onclick='return_book($value->id)'><span><i class='fa fa-undo'></i>&nbsp;</span></a></td>";
            }
            else if($status=='L')
            {
            $tb.= "<td><a class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Return' onclick='return_book($value->id)'><span><i class='fa fa-undo'></i>&nbsp;</span></a></td>";
            }
            else
            {
            $tb.="<td></td>";
            }
            $tb.="</tr>";   
            $x++;
        }
        $tb.= "</tbody>";
        $tb.= "</table>";
        $array = array(
            'ids'=>$stu_id,
            'admission_no'=>$admission_no,
            'name'=>$name,
            'class'=>$class,
            'section'=>$section,
            'datas'=>$tb,
        );
        echo json_encode($array);
    }

    function get_book()
    {
        $book_no    = $this->input->post('book_no');
        $stu_id     = $this->input->post('stu_id');
        $data       = $this->db->query("SELECT t1.*,t2.almirah_no,t2.book_publisher_id,t2.name,t2.rack_no FROM book_detail as t1 JOIN book as t2 ON t2.id=t1.book_id WHERE t1.acc_no='$book_no'")->result();
       
        $array = array(
            'stu_id'            => $stu_id,
            'book_detail_id'    => $data[0]->id,
            'book_id'           => $data[0]->book_id,
            'created_by'        => $this->user_id,
            'ip'                => $_SERVER['REMOTE_ADDR'],
        );

        $this->dbconnection->insert('tmp_book_issue',$array);

        $data_tmp_book_issue = $this->db->query("SELECT t1.*,t2.acc_no,t2.isbn_no,t3.name,t3.book_publisher_id,t3.almirah_no,t3.rack_no FROM tmp_book_issue as t1 JOIN book_detail as t2 ON t2.id=t1.book_detail_id JOIN book as t3 ON t3.id=t1.book_id WHERE t1.created_by=$this->user_id AND t1.stu_id=$stu_id")->result();

        ?>
        <table class="table table-striped table-dark" id="book_details">
            <thead>
                <tr>
                    <th scope="col">Accession No</th>
                    <th scope="col">Document/Book Name</th>
                    <th scope="col">Publisher</th>
                    <th scope="col">Almirah No</th>
                    <th scope="col">Rack No</th>                                    
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($data_tmp_book_issue as $key => $value) 
                {
                ?>
                    <tr>
                        <th scope="row"><?php echo $value->acc_no;?></th>
                        <td><?php echo $value->name;?></td>
                        <td><?php echo $value->book_publisher_id;?></td>
                        <td><?php echo $value->almirah_no;?></td>
                        <td><?php echo $value->rack_no;?></td>
                        <td><a onclick="remove(<?php echo $value->id;?>)" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Remove"><span><i class="fa fa-trash"></i>&nbsp;</span></a></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <?php
    }

    function delete_get_book()
    {
        $id = $this->input->post('id');
        $stu_id = $this->input->post('stu_id');

        $array = array(
            'id' => $id,
        );
        $this->dbconnection->delete('tmp_book_issue',$array);

        $data_tmp_book_issue = $this->db->query("SELECT t1.*,t2.acc_no,t2.isbn_no,t3.name,t3.book_publisher_id,t3.almirah_no,t3.rack_no FROM tmp_book_issue as t1 JOIN book_detail as t2 ON t2.id=t1.book_detail_id JOIN book as t3 ON t3.id=t1.book_id WHERE t1.created_by=$this->user_id AND t1.stu_id=$stu_id")->result();

        ?>
        <table class="table table-striped table-dark" id="book_details">
            <thead>
                <tr>
                    <th scope="col">Accession No</th>
                    <th scope="col">Document/Book Name</th>
                    <th scope="col">Publisher</th>
                    <th scope="col">Almirah No</th>
                    <th scope="col">Rack No</th>                                    
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($data_tmp_book_issue as $key => $value) {
                ?>
                <tr>
                    <th scope="row"><?php echo $value->acc_no;?></th>
                    <td><?php echo $value->name;?></td>
                    <td><?php echo $value->book_publisher_id;?></td>
                    <td><?php echo $value->almirah_no;?></td>
                    <td><?php echo $value->rack_no;?></td>
                    <td><a onclick="remove(<?php echo $value->id;?>)" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Remove"><span><i class="fa fa-trash"></i>&nbsp;</span></a></td>
                </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <?php
    }

    function final_issue()
    {
        $stu_id = $this->input->post('stu_id');
        $data_tmp_book_issue = $this->db->query("SELECT t1.*,t2.acc_no,t2.isbn_no,t3.name,t3.book_publisher_id,t3.almirah_no,t3.rack_no FROM tmp_book_issue as t1 JOIN book_detail as t2 ON t2.id=t1.book_detail_id JOIN book as t3 ON t3.id=t1.book_id WHERE t1.created_by=$this->user_id AND t1.stu_id=$stu_id")->result();
     
        foreach ($data_tmp_book_issue as $key => $value) 
        {
            $id = $value->id;
            $book_id = $value->book_id;
            $days = $this->db->query("SELECT t2.day_alot_stud FROM book as t1 JOIN book_category as t2 ON t1.book_category_id=t2.id WHERE t1.id=$book_id")->result();
            $issue_days = $days[0]->day_alot_stud;
            $book_detail_id = $value->book_detail_id;
            $date = date('M d, Y');
            $date = strtotime($date);
            $date = strtotime("+$issue_days day", $date);
            
            $array = array(
                'issue_user_type'   =>  'STA',
                'st_id'             =>  $stu_id,
                'book_id'           =>  $book_id,
                'book_detail_id'    =>  $book_detail_id,
                'issue_from_date'   =>  date('d-m-Y'),
                'issue_to_date'     =>  date('d-m-Y', $date),
                'created_by'        =>  $this->user_id,
                'ip'                =>  $_SERVER['REMOTE_ADDR'],
            );
            $this->dbconnection->insert('book_issue',$array);

            $array_tmp = array(
                'id'  =>    $id,
            );

            $this->dbconnection->delete('tmp_book_issue',$array_tmp);
        }

        $data_book_issue = $this->db->query("SELECT t1.*,t2.acc_no,t2.isbn_no,t3.name,t3.book_publisher_id,t3.almirah_no,t3.rack_no FROM book_issue as t1 JOIN book_detail as t2 ON t2.id=t1.book_detail_id JOIN book as t3 ON t3.id=t1.book_id WHERE t1.created_by=$this->user_id AND t1.st_id=$stu_id AND t1.issue_user_type='STA' AND t1.status='Y' ORDER BY t1.id DESC")->result();

        $x=1;
        $tb = "<table class='table table-striped table-dark' id='book_detail'>";
        $tb.= "<thead>";
        $tb.= "<tr>";
        $tb.= "<th scope='col'>S.No</th>";
        $tb.= "<th scope='col'>Document/Book Name</th>";
        $tb.= "<th scope='col'>Accession No</th>";
        $tb.= "<th scope='col'>Issued Date</th>";
        $tb.= "<th scope='col'>Submission Date</th> ";                                   
        $tb.= "<th scope='col'>Returned Date</th>";                                 
        $tb.= "<th scope='col'>Late Fine</th>";                                   
        $tb.= "<th scope='col'>Action</th>";
        $tb.= "</tr>";
        $tb.= "</thead>";
        $tb.= "<tbody id='book_detail_student'>";
        foreach ($data_book_issue as $key => $value) 
        {
            $status = $value->issue_status;
            if($status=='I')
            {
                $color = 'ISSUE';
            }
            else
            {
                $color = 'RETURN';
            }
            $tb.= "<tr class='$color'>";
            $tb.= "<th scope='row'>$x</th>";
            $tb.= "<td>$value->name</td>";
            $tb.= "<td>$value->acc_no</td>";
            $tb.= "<td>$value->issue_from_date</td>";
            $tb.= "<td>$value->issue_to_date</td>";
            $tb.= "<td>$value->returned_date</td>";
            $tb.= "<td>&#x20B9; $value->fine_fees</td>";
            if($status=='I')
            {
            $tb.= "<td><a class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Return' onclick='return_book($value->id)'><span><i class='fa fa-undo'></i>&nbsp;</span></a></td>";
            }
            else{
            $tb.="<td></td>";
            }
            $tb.= "</tr>";   
            $x++;
        }
        $tb.= "</tbody>";
        $tb.= "</table>";
        $array = array(
            'datas'=>$tb,
        );
        echo json_encode($array);
    }

    function return_book()
    {
        $id = $this->input->post('id');
        $book = $this->db->query("SELECT t1.fine_fees,t1.id,t3.acc_no,t2.name,t4.name as publisher_name,t1.issue_from_date,t1.issue_to_date,t2.almirah_no,t2.rack_no FROM book_issue as t1 JOIN book as t2 on t2.id=t1.book_id JOIN book_detail as t3 ON t3.id=t1.book_detail_id JOIN book_publisher as t4 ON t4.id=t2.book_publisher_id WHERE t1.id=$id")->result();
        ?>
        <tr>
            <td><input type="hidden" id="book_return_id" value="<?php echo $book[0]->id;?>"><?php echo $book[0]->acc_no;?></td>    
            <td><?php echo $book[0]->name;?></td>    
            <td><?php echo $book[0]->publisher_name;?></td>    
            <td><?php echo $book[0]->issue_from_date;?></td>    
            <td><?php echo $book[0]->issue_to_date;?></td>    
            <td><?php echo $book[0]->almirah_no;?></td>    
            <td><?php echo $book[0]->rack_no;?></td>    
            <td>&#x20B9; <?php echo $book[0]->fine_fees;?></td>
        </tr>
        <?php
    }

    function return_book_final()
    {
        $br_id = $this->input->post('br_id');
        $stu_id = $this->input->post('stu_id');

        $date = date('d-m-Y');
        $array = array('issue_status'=>'R','returned_date'=>$date);
        $this->dbconnection->update('book_issue',$array,"id=$br_id AND st_id=$stu_id");

        $data_book_issue = $this->db->query("SELECT t1.*,t2.acc_no,t2.isbn_no,t3.name,t3.book_publisher_id,t3.almirah_no,t3.rack_no FROM book_issue as t1 JOIN book_detail as t2 ON t2.id=t1.book_detail_id JOIN book as t3 ON t3.id=t1.book_id WHERE t1.created_by=$this->user_id AND t1.st_id=$stu_id AND t1.issue_user_type='STA' AND t1.status='Y' ORDER BY t1.id DESC")->result();

        $x=1;
        $tb = "<table class='table table-striped table-dark' id='book_detail'>";
        $tb.= "<thead>";
        $tb.= "<tr>";
        $tb.= "<th scope='col'>S.No</th>";
        $tb.= "<th scope='col'>Document/Book Name</th>";
        $tb.= "<th scope='col'>Accession No</th>";
        $tb.= "<th scope='col'>Issued Date</th>";
        $tb.= "<th scope='col'>Submission Date</th> ";                                   
        $tb.= "<th scope='col'>Returned Date</th>";                                   
        $tb.= "<th scope='col'>Late Fine</th>";                                 
        $tb.= "<th scope='col'>Action</th>";
        $tb.= "</tr>";
        $tb.= "</thead>";
        $tb.= "<tbody id='book_detail_student'>";
        foreach ($data_book_issue as $key => $value) 
        {
            $status = $value->issue_status;
            if($status=='I')
            {
                $color = 'ISSUE';
            }
            else
            {
                $color = 'RETURN';
            }
            $tb.= "<tr class='$color'>";
            $tb.= "<th scope='row'>$x</th>";
            $tb.= "<td>$value->name</td>";
            $tb.= "<td>$value->acc_no</td>";
            $tb.= "<td>$value->issue_from_date</td>";
            $tb.= "<td>$value->issue_to_date</td>";
            $tb.= "<td>$value->returned_date</td>";
            $tb.= "<td>&#x20B9; $value->fine_fees</td>";
            if($status=='I')
            {
            $tb.= "<td><a class='btn btn-primary' data-toggle='tooltip' data-placement='top' title='Return' onclick='return_book($value->id)'><span><i class='fa fa-undo'></i>&nbsp;</span></a></td>";
            }
            else{
            $tb.="<td></td>";
            }
            $tb.= "</tr>";   
            $x++;
        }
        $tb.= "</tbody>";
        $tb.= "</table>";
        $array = array(
            'datas'=>$tb,
        );
        echo json_encode($array);
    }
}