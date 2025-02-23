<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Books extends CI_Controller {
    
    public $page_code = 'books';
    public $page_id = '';
    public $page_perm = '----';
    
    public function __construct() {
        parent::__construct();
        $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");

        $this->load->model('Mymodel', 'm');
        
        
        
        $this->id = $this->session->userdata('school_id');
        if ($this->id != 0) {
            $this->db->db_select('crmfeesclub_' . $this->id);
        }
        $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
        $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
        $this->right_access = $this->page_perm;

        if (strpos($this->page_perm, '----') == true) {
            redirect(base_url(''), 'refresh');
        }
		$this->admission_csv_columns = array(
				array('field' => 'lib_book_code', 'human_name' => 'Book Code/Acc No'),//0
				array('field' => 'title', 'human_name' => 'Book Title'),//1
				array('field' => 'subtitle', 'human_name' => 'Subtitle'),//3
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
        
        $this->page_title = 'Books';
        $this->section = 'library';
        $this->page_name = 'books_list';
        $this->customview = '';
        $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y' and active='Y'", '', '', array('id'));
    }

    public function index() {
        if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->data['page_name'] = 'books_list';
        $this->data['page_title'] = 'Books';
        $this->data['section'] = 'library';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->data['books'] = $this->dbconnection->select("library_books", "*");
        $this->data['library'] = $this->dbconnection->select("library_card", "*", "status='Y'");
		$this->data['class_group']  = $this->dbconnection->select("class", "*", "status='Y'");
        $this->data['uqc'] = $this->dbconnection->select("crmfeesclub.uqc", "*", "");
        $this->load->view('index', $this->data);
    }

    public function add() {
        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->data['page_name'] = 'add_books_list';
        $this->data['page_title'] = 'Add Books';
        $this->data['section'] = 'library';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->data['vendor'] = $this->dbconnection->select("ledger", "*", "status='Y' AND under_group = 36");
        $this->data['library'] = $this->dbconnection->select("library_card", "*", "status='Y'");
		$this->data['class_group']  = $this->dbconnection->select("class", "*", "status='Y'");
        $this->data['uqc'] = $this->dbconnection->select("crmfeesclub.uqc", "*", "");
        $this->load->view('index', $this->data);
    }

    public function save() {
        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $book_code = md5(uniqid() . time);
        $field = array(
            'book_code' => $book_code,
			'lib_book_code' => $this->input->post('lib_book_code'),
            'isbn' => $this->input->post('isbn'),
            'publisher' => $this->input->post('publisher'),
            'title' => $this->input->post('title'),
            'cost' => $this->input->post('cost'),
            'subtitle' => $this->input->post('subtitle'),
            'binding_type' => $this->input->post('binding'),
            'description' => $this->input->post('desc'),
            'location' => $this->input->post('location'),
            'author' => $this->input->post('author'),
            'for_class' => $this->input->post('for_class'),
            'edition' => $this->input->post('edition'),
            'actual_qty' => $this->input->post('qty'),
            'rest_qty' => $this->input->post('qty'),
			'vendor' => $this->input->post('source'),
			'entry_date' => $this->input->post('entry_date'),
			'page_no' => $this->input->post('page_no')

        );

        $this->dbconnection->insert('library_books', $field);
        redirect('library/Books/index');
    }

    public function edit($id) {
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->data['page_name'] = 'edit_books';
        $this->data['page_title'] = 'Edit Books';
        $this->data['section'] = 'library';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->data['library_book_edit'] = $this->dbconnection->select("library_books", "*", "id='$id'");
        $this->data['library'] = $this->dbconnection->select("library_card", "*", "status='Y'");
        $this->data['uqc'] = $this->dbconnection->select("crmfeesclub.uqc", "*", "");
        $this->load->view('index', $this->data);
    }

    public function update() {
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $id = $this->input->post('upd_id');
        $add_qty = $this->input->post('add_qty');
        $qty_data = $this->dbconnection->select('library_books', 'actual_qty,issued_qty,rest_qty', "id='$id'");

        $act_qty = $qty_data[0]->actual_qty;
        $issued_qty = $qty_data[0]->issued_qty;
        $rest_qty = $qty_data[0]->rest_qty;

        $actual_qty = $act_qty + $add_qty;
        $rst_qty = $actual_qty - $issued_qty;

        $up_field = array(
			'lib_book_code' => $this->input->post('lib_book_code'),
            'isbn' => $this->input->post('isbn'),
            'publisher' => $this->input->post('publisher'),
            'title' => $this->input->post('title'),
            'cost' => $this->input->post('cost'),
            'subtitle' => $this->input->post('subtitle'),
            'binding_type' => $this->input->post('binding'),
            'description' => $this->input->post('desc'),
            'location' => $this->input->post('location'),
            'author' => $this->input->post('author'),
            'for_class' => $this->input->post('for_class'),
            'edition' => $this->input->post('edition'),
            'actual_qty' => $actual_qty,
            'rest_qty' => $rst_qty
        );

        $this->dbconnection->update('library_books', $up_field, "id='$id'");
        redirect('library/Books/index');
    }

    public function issue() {
        $id = $this->input->post('id');
        $lib_books = $this->dbconnection->select('library_books', '*', "id='$id'");
        $book_code = $lib_books[0]->book_code;
        $title = $lib_books[0]->title;
        $for_class = $lib_books[0]->for_class;
        $rest_qty = $lib_books[0]->rest_qty;
        $all = array($book_code, $title, $for_class, $rest_qty);
        echo json_encode($all);
    }

    public function fetch_lib_det() {
        $adm_no = $this->input->post('adm_no');
        $data = $this->dbconnection->select('library_card', '*', "adm_no='$adm_no'");

        $dt = $this->m->issued_qty($adm_no);
        $tot_issued_qty = $dt[0]->cnt;
        $lib_card_no = $data[0]->lib_card_no;
        $first_name = $data[0]->first_name;
        $middle_name = $data[0]->middle_name;
        $last_name = $data[0]->last_name;
        $classs = $data[0]->class;
        $section = $data[0]->section;
        $roll = $data[0]->roll;
        $no_book = $data[0]->no_book;
        $days_allow = $data[0]->days_allow;
        $card_exp = $data[0]->card_exp;

        $all = array($lib_card_no, $first_name, $middle_name, $last_name, $classs, $section, $roll, $no_book, $days_allow, $card_exp, $tot_issued_qty);
        echo json_encode($all);
    }

    public function book_issue_save() {
        if (substr($this->right_access, 0, 1) != 'C') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $field = array(
            'adm_no' => $this->input->post('adm_no'),
            'lib_card_no' => $this->input->post('lib_card_no'),
            'first_name' => $this->input->post('first_name'),
            'middle_name' => $this->input->post('middle_name'),
            'last_name' => $this->input->post('last_name'),
            'class' => $this->input->post('classs'),
            'section' => $this->input->post('sec'),
            'roll' => $this->input->post('roll'),
            'no_book' => $this->input->post('no_book'),
            'days_allow' => $this->input->post('days_allow'),
            'card_exp' => $this->input->post('card_exp'),
            'book_code' => $this->input->post('book_code'),
            'issued_qty' => $this->input->post('issued_book'),
            'date_created' => date("Y-m-d H:i:s"),
            'created_by' => $_SERVER['REMOTE_ADDR']
        );

        $this->dbconnection->insert('issued_books', $field);
        $last_id = $this->db->insert_id();
        $iss_book = $this->dbconnection->select('issued_books', 'book_code', "id='$last_id'");
        $book_code = $iss_book[0]->book_code;

        $libb_bookk = $this->dbconnection->select('library_books', '*', "book_code='$book_code'");
        $issued_qty = $libb_bookk[0]->issued_qty;

        if ($issued_qty == 0) {
            $update = array(
                'issued_qty' => $this->input->post('issued_book')
            );
            $this->dbconnection->update('library_books', $update, "book_code='$book_code'");

            $lib_book = $this->dbconnection->select('library_books', '*', "book_code='$book_code'");
            $actual_qty = $lib_book[0]->actual_qty;
            $issued_qty = $lib_book[0]->issued_qty;
            $rest_qty = $actual_qty - $issued_qty;

            $update1 = array(
                'rest_qty' => $rest_qty
            );

            $this->dbconnection->update('library_books', $update1, "book_code='$book_code'");
        } else {
            $qty = $this->input->post('issued_book');
            $lib_book = $this->dbconnection->select('library_books', '*', "book_code='$book_code'");
            $actual_qty = $lib_book[0]->actual_qty;
            $issued_qty = $lib_book[0]->issued_qty;

            $add_qty = $issued_qty + $qty;
            $update1 = array(
                'issued_qty' => $add_qty
            );

            $this->dbconnection->update('library_books', $update1, "book_code='$book_code'");

            $libs_books = $this->dbconnection->select('library_books', '*', "book_code='$book_code'");
            $actual_qtyy = $libs_books[0]->actual_qty;
            $issued_qtyy = $libs_books[0]->issued_qty;

            $rst_qty = $actual_qtyy - $issued_qtyy;
            $update1 = array(
                'rest_qty' => $rst_qty
            );
            $this->dbconnection->update('library_books', $update1, "book_code='$book_code'");
        }
    }
	
	
	public function exportcsv() {


        //$where = ' status=1';
        $records = $this->dbconnection->select("library_books", "lib_book_code,title,subtitle,edition,actual_qty,issued_qty,rest_qty,
		year_published,genre,author,publisher,binding_type,cost,description,for_class,location,isbn,normal_loc,current_loc,current_loaned_to,
		current_return_deadline,vendor,entry_date,page_no");
		//current_return_deadline", $where);

        $filename = "FeesClub-Books-Export-" . date('Ymd') . ".csv";

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $filename);

        $colnames = array();
        $colnames[] = 'Book Code/Acc No';
        $colnames[] = 'Book Name';
        $colnames[] = 'Subtitle';
        $colnames[] = 'Edition';
        $colnames[] = 'Actual Qty';
        $colnames[] = 'Year Published';
        $colnames[] = 'Genre';
        $colnames[] = 'Author';
        $colnames[] = 'Publisher';
        $colnames[] = 'Binding Type';
        $colnames[] = 'Cost';
        $colnames[] = 'Description';
        $colnames[] = 'For Class';
        $colnames[] = 'Location';
        $colnames[] = 'Isbn No';
        $colnames[] = 'Normal Location';
		$colnames[] = 'Source/Vendor';
		$colnames[] = 'Entry Date';
		$colnames[] = 'Page No.';
		




        $out = fopen('php://output', 'w');
        fputcsv($out, $colnames);
        foreach ($records as $rec) {
            $recarr = array();
            $recarr[] = $rec->lib_book_code;
            $recarr[] = $rec->title;
            $recarr[] = $rec->subtitle;
            $recarr[] = $rec->edition;
            $recarr[] = $rec->actual_qty;
            $recarr[] = $rec->year_published;
            $recarr[] = $rec->genre;
            $recarr[] = $rec->author;
            $recarr[] = $rec->publisher;
            $recarr[] = $rec->binding_type;
            $recarr[] = $rec->cost;
            $recarr[] = $rec->description;
            $recarr[] = $rec->for_class;
            $recarr[] = $rec->location;
            $recarr[] = $rec->isbn;
            $recarr[] = $rec->normal_loc;
			$recarr[] = $rec->vendor;
			$recarr[] = $rec->entry_date;
			$recarr[] = $rec->page_no;


            fputcsv($out, $recarr);
        }
        fclose($out);
    }

    public function importcsv() {

        $this->data['page_name'] = 'upload_books';
        $this->data['page_title'] = 'Upload Books';
        $this->data['section'] = 'library';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        $this->data['fetch_class'] = $this->dbconnection->select("class", "class_code,UPPER(class_name) class_name", "status='Y'");
        // $this->data['fetch_department'] = $this->dbconnection->select("employee_department", "id,UPPER(department_desc) department_desc", "status=1");
        // $this->data['fetch_category'] = $this->dbconnection->select("employee_category", "id,UPPER(category_desc) category_desc", "status=1");
        // $this->data['fetch_leave_group'] = $this->dbconnection->select("leave_group", "id,UPPER(leave_group_name) leave_group_name", "status=1");
        // $this->data['fetch_bank'] = $this->bank;

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
	
	public function upload() {

        if(substr($this->right_access, 0, 1) != 'C') {
			redirect('404');
	}
//                ini_set('max_input_time', 0);
        ini_set('max_execution_time', 3600);
//                ini_set('display_errors', 1);
//                error_reporting(-1);
//		ini_set('display_errors', 1);
        $this->data['errors'] = array();
// Cache employee_code
        $this->db->select('lib_book_code');
        $query = $this->db->get('library_books');
        $employee_code = array_column($query->result_array(), NULL, 'lib_book_code');

      
// Cache class_group

        $query = $this->dbconnection->select_returnarray("class", "class_code", "status='Y'");
        $class_group = array_change_key_case(array_column($query, NULL, 'class_code'), CASE_UPPER);


       // $category =array('TEACHING'=>'1','NON-TEACHING'=>'2');
        
        if (!empty($_FILES['admission_upload']['tmp_name'])) {  

            $employee_code_file = array();
            $handle = fopen($_FILES['admission_upload']['tmp_name'], "r");
            fgetcsv($handle); // Read and discard header row
            while (($row = fgetcsv($handle, 10000, ",")) !== FALSE) {
                $rowarr = array();
                foreach ($row as $pos => $value) {
//                                        if($pos!=13 || $pos!=14 || $pos!=15 ){
//                    if ($pos < 4) {
//                        if (!isset($this->admission_csv_columns[$pos]))
//                            continue;
//                    }
                    $rowarr[$this->admission_csv_columns[$pos]['field']] = trim($value);
                }
                /* ------ checking duplicate admission number in csv file  -------- */
                if (in_array($rowarr['lib_book_code'], $employee_code_file)) {
                    $this->data['errors'][] = "Book Code '" . $rowarr['lib_book_code'] . "' previously present in this file, skipping...";
                    continue;
                }

                $employee_code_file[] = $rowarr['lib_book_code'];
                if (isset($employee_code[$rowarr['lib_book_code']])) {
                    $this->data['errors'][] = "Book Code '" . $rowarr['lib_book_code'] . "' already present, skipping...";
                    continue;
                }

                if (!empty($data[18]) && date('Y', strtotime(str_replace('/', '-', $data[18]))) == 1970) {
                    $this->data['errors'][] = "Line $linerow: Book Code '" . $data[0] . "' contains Renewal date Invalid, skipping...";
                    continue;
                }
                
                // if (!isset($class_group[strtoupper($rowarr['for_class'])])) {
                    // $this->data['errors'][] = "Book Code '" . $rowarr['lib_book_code'] . "' has undefined Class group of '" . $rowarr['for_class'] . "', skipping...";
                    // continue;
                // }

                $book_code = md5(uniqid());

//				$reference_no = "$this->country_code-$this->state_code-$this->city_code-$this->school_code-{$rowarr['admission_no']}";
//                                if(!empty($this->data['errors'])) {
                $data_student = array(
//						"reference_no" => $reference_no,
					
					'book_code'=> $book_code,

                    "lib_book_code" => $rowarr['lib_book_code'],
                    "title" => $rowarr['title'],
					"subtitle" => $rowarr['subtitle'],
					"edition" => $rowarr['edition'],
					"actual_qty" => $rowarr['actual_qty'],
					"issued_qty" => 0,
					"rest_qty" => $rowarr['actual_qty'],
					"year_published" => $rowarr['year_published'],
					//"genre" => $rowarr['genre'],
					"author" => $rowarr['author'],
					"publisher" => $rowarr['publisher'],
					"binding_type" => $rowarr['binding_type'],
					"cost" => $rowarr['cost'],
					"description" => $rowarr['description'],
					"for_class" => $rowarr['for_class'],
                    //"for_class" => $class_group[strtoupper($rowarr['for_class'])],
					"location" => $rowarr['location'],
					"isbn" => $rowarr['isbn'],
					"vendor" => $rowarr['vendor'],
					"entry_date" =>!empty($rowarr['entry_date'])? date('Y-m-d', strtotime(str_replace('/', '-', $rowarr['entry_date']))):'',
					"page_no" => $rowarr['page_no'],

                );
                $this->db->insert('library_books', $this->security->xss_clean($data_student));
                $employee_id = $this->dbconnection->get_last_id();
                //$this->employee_leave($leave_group[strtoupper($rowarr['class_code'])], $employee_id);

                //$book_code[$rowarr['lib_book_code']] = TRUE;

                
                $audit = array("action" => 'Upload Books Information',
                    "module" => "Library Module",
                    'datetime' => date("Y-m-d H:i:s"),
                    'userid' => $this->session->userdata('user_id'),
                    'student_id' => $employee_id,
                    'page' => 'upload_books',
                    'remarks' => ''
                );
                $this->dbconnection->insert("auditntrail", $audit);
//                                }
//                            }else {/*------------  end of checking duplicate data in csv file   -------------*/
//                                
//                            }
            }
        }
        if (empty($this->data['errors'])) {
            $this->session->set_flashdata('employeeupload', 'Successfully Uploaded !');
        } else {
            $this->session->set_flashdata('employeeupload', 'File has some error !');
        }
        $this->importcsv();
    }
	
	
	

}
