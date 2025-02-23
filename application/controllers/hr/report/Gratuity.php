<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gratuity extends CI_Controller
{
	 public $page_code = 'gratuity';
    public $page_id = '';
    public $page_perm = '----';

    public function __construct() {

        parent::__construct();
        $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");

        $this->id = $this->session->userdata('school_id');
        $this->school_desc = $this->dbconnection->select("school", "*", "id=" . $this->id . " and status = 1");
        $this->schools = $this->dbconnection->select("school", "*", 'status = 1');
        $this->bank = $this->dbconnection->select("bank", "*");
        if ($this->id != 0)
            $this->db->db_select('crmfeesclub_' . $this->id);
        
        $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
        $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
        $this->right_access = $this->page_perm;

        if (strpos($this->page_perm, '----') == true) {
            redirect(base_url(''), 'refresh');
        }
        
        $this->page_title = 'Gratuity';
        $this->section = 'hr/report';
        $this->page_name = 'gratuity';
        $this->customview = '';
    }
	public function index()
	{
			$this->data['page_name'] = $this->page_name;
		$this->data['page_title'] = $this->page_title;
		$this->data['section'] = $this->section;
		$this->data['customview'] = $this->customview;
		$this->data['right_access'] = $this->right_access;
		$this->load->view('index',$this->data);
	}
public function pdf()
    {

        $month=$this->input->post('month');
        $name = $this->school_desc[0]; 
        // echo $month;
        $query= $this->db->query('SELECT id,name,designation_id,employee_code FROM employee');
        $rows=$query->num_rows();
        $query= $query->result();
        $this->data['query']=$query;
        $this->data['month']=$month;
        $this->data['name']=$name;
        $this->data['rows']=$rows;
        $this->load->view('hr/report/gratuity_pdf',$this->data);
    $html = $this->output->get_output();
        $this->load->library('pdf');
    $size = 'A4';
    $orientation = 'landscape';
        $this->dompdf->load_html($html);
        $this->dompdf->set_paper($size, $orientation);
        $this->dompdf->render();
        ob_end_clean();
        $this->dompdf->stream("DCR.pdf", array("Attachment" => false));
}
}
?>