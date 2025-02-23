<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Issued_books extends CI_Controller {
    
    public $page_code = 'Issued_books';
    public $page_id = '';
    public $page_perm = '----';
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Mymodel', 'm');

        $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");

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
        $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y' and active='Y'", '', '', array('id'));
    }

    public function index() {
        if (substr($this->right_access, 1, 1) != 'R') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $this->data['page_name'] = 'issued_books_list';
        $this->data['page_title'] = 'Issued Books';
        $this->data['section'] = 'library';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
        print_r($this->data);die();
        $this->data['issued_books'] = $this->m->issued_books();
        $this->data['library'] = $this->dbconnection->select("library_card", "*", "status='Y'");
        $this->data['late_fine'] = $this->dbconnection->select("library_late_fine", "*", "status='Y'");
        $this->data['uqc'] = $this->dbconnection->select("crmfeesclub.uqc", "*", "");
        $this->load->view('index', $this->data);
    }

    public function return_book() {
        if (substr($this->right_access, 2, 1) != 'U') {
//            redirect(base_url(), 'refresh');
            redirect('404');
        }
        $book_code = $this->input->post('book_code');
        $issued_qty = $this->input->post('issued_qty');
        $id = $this->input->post('id');
        $issu_book = $this->dbconnection->select('library_books', "*", "book_code='$book_code'");

        $actual_qtyy = $issu_book[0]->actual_qty;
        $issued_qtyy = $issu_book[0]->issued_qty;
        $rest_qtyy = $issu_book[0]->rest_qty;

        $return_issued_qty = $issued_qtyy - $issued_qty;
        $rst_qt = $rest_qtyy + $issued_qty;

        $up = array(
            'issued_qty' => $return_issued_qty,
            'rest_qty' => $rst_qt
        );

        $this->dbconnection->update('library_books', $up, "book_code='$book_code'");

        $up1 = array(
            'book_status' => 'Returned',
            'late_fine' => $this->input->post('tot_late_fine'),
            'return_date' => date("Y-m-d H:i:s")
        );
        $this->dbconnection->update('issued_books', $up1, "id='$id'");
    }

}
