<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bus_report extends CI_Controller {

    public function __construct() {

        parent::__construct();
        if (empty($this->session->userdata('user_id')) || $this->session->userdata('user_group_id') == 4) {
            redirect('/login');
        }
        $this->id = $this->session->userdata('school_id');
        if ($this->id != 0)
            $this->db->db_select('crmfeesclub_' . $this->id);
        $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y' and active='Y'");
        $fetch_startyr = isset($this->academic_session[0]->start_date) ? explode('-', $this->academic_session[0]->start_date) : array('0');
        $this->session_start_yr = reset($fetch_startyr);
        $fetch_endyr = isset($this->academic_session[0]->end_date) ? explode('-', $this->academic_session[0]->end_date) : array('0');
        $this->session_end_yr = reset($fetch_endyr);
    }
    
    public function index()
    {
        $this->data['page_title'] = 'Bus Conveyance Report';
        $this->data['section'] = 'transport';
        $this->data['page_name'] = 'bus_report';
        $this->data['customview'] = '';
        $this->data['aroute'] = $this->dbconnection->select("routes","route_code,id","status=1","route_code");
        if($this->input->post()){
            $route = $this->input->post('route_list');
            $str_query='';
            if($route!='All'){
                    $str_query.=' and t5.id='.$route;
            }
            $this->data['bus_data'] = $this->db->query('select t1.admission_no,concat(t1.first_name," ",t1.middle_name," ",t1.last_name) first_name,t1.roll,t1.transport_amt,t2.class_name,t3.sec_name,t4.vehicle_no,t5.route_code,t6.location_description from student as t1 inner join class as t2 on t1.class_id=t2.id inner join section as t3 on t1.section_id=t3.id inner join vehicle as t4 on t1.transport_id=t4.id inner join routes as t5 on t4.id=t5.vehicle '.$str_query.' inner join locations as t6 on t5.id=t6.id where t1.status="Y"  order by t2.class_name,t3.sec_name,t1.admission_no')->result();
        }else{
            $this->data['bus_data'] = $this->db->query('select t1.admission_no,concat(t1.first_name," ",t1.middle_name," ",t1.last_name) first_name,t1.roll,t1.transport_amt,t2.class_name,t3.sec_name,t4.vehicle_no,t5.route_code,t6.location_description from student as t1 inner join class as t2 on t1.class_id=t2.id inner join section as t3 on t1.section_id=t3.id inner join vehicle as t4 on t1.transport_id=t4.id inner join routes as t5 on t4.id=t5.vehicle inner join locations as t6 on t5.id=t6.id where t1.status="Y" ')->result();
        }
        
        $this->load->view('index', $this->data); 
    }
}