<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
        $this->load->model('Mymodel','m');

        //$link_code='goods_grn';
         if(empty($this->session->userdata('user_group_id'))) {
            redirect(base_url(), 'refresh');
         }
		 
		switch($this->session->userdata('login_type')){
                    case 'appadmin':
                                        $this->right_access = 'CRUD';
                                        break;
                    case 'admin':
                                        $this->right_access = 'CRUD';
                                        break;
                    case 'principal':
                                        $this->right_access = '-R--';
                                        break;
                    case 'office':
                                        $this->right_access = 'CR--';
                                        break;
					case 'hod':
                                        $this->right_access = 'CR--';
                                        break;
					case 'hoi':
                                        $this->right_access = 'CRUD';
                                        break;
                    default:
                                        $this->right_access = '----';
                                        redirect(base_url(), 'refresh');
        }
		$this->id = $this->session->userdata('school_id');		
		if ($this->id != 0) {
            $this->db->db_select('crmfeesclub_' . $this->id);
        }
		
		$this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y' and active='Y'",'','',array('id'));
	}
        
	public function index(){
		$this->data['page_name'] = 'issued_books_list';
		$this->data['page_title'] = 'Issued Books';
		$this->data['section'] = 'library';
		$this->data['customview'] = '';
		$this->data['right_access'] = $this->right_access;
        $this->data['issued_books'] = $this->m->issued_books();
        $this->data['library'] = $this->dbconnection->select("library_card","*","status='Y'");
        $this->data['uqc'] = $this->dbconnection->select("crmfeesclub.uqc","*","");
		$this->load->view('index', $this->data);
	}
}
