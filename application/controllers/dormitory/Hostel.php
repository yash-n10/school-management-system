<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Hostel extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (empty($this->session->userdata('user_id'))) {
            redirect('/login');
        }


        $this->id = $this->session->userdata('school_id');
        $this->school_desc = $this->dbconnection->select("school", "*", "id=" . $this->id . " and status = 1");
        $this->schools = $this->dbconnection->select("school", "*", 'status = 1');
        if ($this->id != 0)
            $this->db->db_select('crmfeesclub_' . $this->id);
    }

    public function dormitory_type($param1 = '', $param2 = '') {
        if ($param1 == 'save') {
            $data = array(
                'dorm_type' => $this->input->post('dorm_typ'),
                'created_by' => $this->session->userdata('user_id'),
            );
            $this->dbconnection->insert("dorm_type", $data);
        } else if ($param1 == 'update') {
            $data = array(
                'dorm_type' => $this->input->post('dorm_typ'),
            );
            $this->db->where('id', $param2);
            $this->db->update('dorm_type', $data);
        } else if ($param1 == 'delete') {
            $class_id_string = $this->input->post('class_id_string');
            foreach ($class_id_string as $val) {
                $this->dbconnection->update('dorm_type', array('status' => 0, 'last_modified_by' => $this->session->userdata('user_id'), 'date_modified' => date('Y-m-d H:i:s')), 'id=' . $val);
            }
        } else {
            $page_data = array(
                'fetch_dorm_type' => $this->dbconnection->select("dorm_type", "*", "status=1"),
                'page_name' => 'dormitory_type',
            );

            $this->load->view('hostel/index_hostel', $page_data);
        }
    }

    public function dormitory_list($param1 = '', $param2 = '') {
        if ($param1 == 'save') {
            $data = array(
                'dormitory_no' => $this->input->post('d_no'),
                'dormitory_name' => $this->input->post('d_name'),
                'dorm_type_id' => $this->input->post('dorm_type'),
                'no_of_rooms' => $this->input->post('room_no'),
                'description' => $this->input->post('address'),
                'contact' => $this->input->post('contact'),
                'warden' => $this->input->post('warden'),
                'created_by' => $this->session->userdata('user_id'),
            );

            $this->dbconnection->insert("dormitory", $data);
        } else if ($param1 == 'update') {
            $data = array(
                'dormitory_no' => $this->input->post('d_no'),
                'dormitory_name' => $this->input->post('d_name'),
                'dorm_type_id' => $this->input->post('d_type'),
                'no_of_rooms' => $this->input->post('room_no'),
                'description' => $this->input->post('address'),
                'contact' => $this->input->post('contact'),
                'warden' => $this->input->post('warden'),
            );

            $this->db->where('id', $param2);
            $this->db->update('dormitory', $data);
        } else if ($param1 == 'delete') {
            $class_id_string = $this->input->post('class_id_string');
            foreach ($class_id_string as $val) {
                $this->dbconnection->update('dormitory', array('status' => 0, 'last_modified_by' => $this->session->userdata('user_id'), 'last_modified' => date('Y-m-d H:i:s')), 'id=' . $val);
            }
        } else {
            $page_data = array(
                'fetch_dormitory' => $this->dbconnection->select("dormitory", "*,(select dorm_type from dorm_type where id=dorm_type_id) as d_type", "status=1"),
                'page_name' => 'dormitory_view',
                'fetch_dorm_type' => $this->dbconnection->select("dorm_type", "*", "status=1"),
            );

            $this->load->view('hostel/index_hostel', $page_data);
        }
    }

    public function room_list($param1 = '', $param2 = '') {
        if ($param1 == 'save') {
            $data = array(
                'room_no' => $this->input->post('room_cnt'),
                'dorm_id' => $this->input->post('dorm_name'),
                'max_student' => $this->input->post('student'),
                'amount' => $this->input->post('amt'),
                'description' => $this->input->post('desc'),
            );

            $this->dbconnection->insert("room", $data);
        } else if ($param1 == 'update') {
            $data = array(
                'room_no' => $this->input->post('room_no'),
                'dorm_id' => $this->input->post('dorm_name'),
                'max_student' => $this->input->post('student'),
                'amount' => $this->input->post('amt'),
                'description' => $this->input->post('desc'),
            );

            $this->db->where('id', $param2);
            $this->db->update('room', $data);
        } else if ($param1 == 'delete') {
            $class_id_string = $this->input->post('class_id_string');
            foreach ($class_id_string as $val) {
                $this->dbconnection->update('room', array('status' => 0, 'last_modified_by' => $this->session->userdata('user_id'), 'last_modified' => date('Y-m-d H:i:s')), 'id=' . $val);
            }
        }
        $page_data = array(
            'fetch_dorm' => $this->dbconnection->select("dormitory", "dormitory_name,dormitory_no,id", "status=1"),
            'fetch_room' => $this->dbconnection->select("room", "id,room_no,dorm_id,max_student,amount,description,(select dormitory_name from dormitory where id=dorm_id) as dorm_name", "status=1"),
            'page_name' => 'room_view',
        );
        $this->load->view('hostel/index_hostel', $page_data);
    }

    public function allocate_student($param1 = '', $param2 = '') {
        $cls_id = $this->input->post('clas');
//               echo $cls_id;
        $stud_id = $this->input->post('adm');
        $dorm = $this->input->post('dorm_name');
        if ($param1 == 'save') {
            $data = array(
                'stud_id' => $this->input->post('adm'),
                'room_id' => $this->input->post('room_no'),
                'alloc_date' => $this->input->post('alloc_d'),
                'amount' => $this->input->post('amnt'),
                'berth_no' => $this->input->post('berth'),
            );
            $this->dbconnection->insert("dorm_room_student", $data);
        }


        if ($param1 == 'update') {
            $data = array(
                'stud_id' => $this->input->post('adm'),
                'room_id' => $this->input->post('room_no'),
                'alloc_date' => $this->input->post('alloc_d'),
                'amount' => $this->input->post('amnt'),
                'berth_no' => $this->input->post('berth'),
            );
            $this->db->where('id', $param2);
            $this->db->update('dorm_room_student', $data);
        }

        if ($param1 == 'delete') {
            $id = $this->input->post('class_id_string');
            foreach ($id as $val) {
                $this->dbconnection->update('dorm_room_student', array('status' => 0, 'last_modified_by' => $this->session->userdata('user_id'), 'date_modified' => date('Y-m-d H:i:s')), 'id=' . $val);
            }
        }

        $page_data = array(
            'fetch_stud' => $this->dbconnection->select("student", "id,admission_no,concat(first_name,'',middle_name,'',last_name)as stud_name,class_id,(select class_name from class where id=class_id) as class", "accomodation_status='Y'"),
            'fetch_dorm' => $this->dbconnection->select("dormitory", "dormitory_name,dormitory_no,id", "status=1"),
            'fetch_stud_room' => $this->dbconnection->select("dorm_room_student", "id,stud_id,room_id,(select room_no from room where id=room_id) as room_no,berth_no,amount,alloc_date,(select admission_no from student where id=stud_id) as admission, (select concat(first_name,'',middle_name,'',last_name) from student where id=stud_id) as stud_name, (select dormitory_name from dormitory where id=(select dorm_id from room where id=room_id)) as dorm_name,(select dorm_id from room where id=room_id) as dorm_id, (select class_name from class where id=(select class_id from student where id=stud_id)) as class", "status=1"),
            'page_name' => 'stud_allocation',
        );
//                                echo json_encode($page_data);

        $this->load->view('hostel/index_hostel', $page_data);
    }

    public function get_room() {
        $d_id = $this->input->post('dorm_no');
        $r_id = $this->input->post('room_no');
        $fetch_room = $this->dbconnection->select("room", "*", "status=1 and dorm_id=$d_id");

        $return = '';
        $return .= '<select class="form-control" name="room_no" id="room_no">';
        $return .= "<option value=''>- Select Room -</option>";
        foreach ($fetch_room as $room) {
            $return .= "<option value='" . $room->id . "'>" . $room->room_no . "</option>";
        }
        $return .= '</select>';
        echo $return;
    }

    public function get_room1() {
        $d_id = $this->input->post('dorm_no');
        $r_id = $this->input->post('room_no');
        $fetch_room = $this->dbconnection->select("room", "*", "status=1 and dorm_id=$d_id");

        $return = '';
        $return .= '<select class="form-control" name="room_no" id="room_no">';
        $return .= "<option value=''>- Select Room -</option>";
        $return .= "<option value='0'>- All -</option>";
        foreach ($fetch_room as $room) {
            $return .= "<option value='" . $room->id . "'>" . $room->room_no . "</option>";
        }
        $return .= '</select>';
        echo $return;
    }

    public function student_detail() {
        $admisn_no = $this->input->post('admission');
//               echo $admisn_no;
        $fetch_stud = $this->dbconnection->select("student", "admission_no,id,concat(first_name,'',middle_name,'',last_name) as name, class_id, (select class_name from class where id=class_id) as class", "id=$admisn_no");

//               print_r($fetch_stud);
        echo json_encode($fetch_stud, JSON_UNESCAPED_SLASHES);
    }

    public function fetch_amount() {
        $room_num = $this->input->post('room');
        $dorm_num = $this->input->post('dorm');
        $fetch_room_amnt = $this->dbconnection->select("room", "amount", "id=$room_num and dorm_id=$dorm_num");

        echo json_encode($fetch_room_amnt);
    }

    public function dormitory_report($param1 = '', $param2 = '') {

        $this->data['page_name'] = 'under_cons';
        $this->data['page_title'] = 'Dormitory Report';
        $this->data['section'] = 'hostel';
        $this->data['customview'] = '';
        // $this->data['right_access'] = $this->right_access;
        // $this->data['employee'] = $this->dbconnection->select("employee", "*", "status='1'");
        $this->load->view('hostel/index_hostel', $this->data);
        // $page_data = array(
        //     'dormitory' => $this->dbconnection->select("dormitory", "*", ""),
        //     'room' => $this->dbconnection->select("room", "*", ""),
        //     'page_name' => 'ncert',
        // );
        // $this->load->view('hostel/index_hostel', $page_data);
    }

    public function dorm_fetch() {
        $this->data['dormitory'] = array();
        $dorm = $this->input->post('dormit');
        if ($dorm != 0) {
            $this->data['dormitory'] = $this->dbconnection->select("dormitory", "*", "id=$dorm");
        } else if ($dorm == 0) {
            $this->data['dormitory'] = $this->dbconnection->select("dormitory", "*", "");
        }

        $i = 0;
        $dorm_id = array();
        $dorm_no = array();
        $dorm_name = array();
        $room = array();
        $tot_alloc = array();
        $tot_avail = array();

        foreach ($this->data['dormitory'] as $row) {
            $dorm_id[$i] = $row->id;
            $dorm_no[$i] = $row->dormitory_no;
            $dorm_name[$i] = $row->dormitory_name;
            $room[$i] = $row->no_of_rooms;
            $tot_allocated = $this->dbconnection->select("dorm_room_student", "count(distinct(room_id)) as cn", "room_id in (select id from room where dorm_id=$row->id)");
            $tot_alloc[$i] = $tot_allocated[0]->cn;
            $tot_avail[$i] = (($row->no_of_rooms) - ($tot_allocated[0]->cn));
            $i++;
        }
        $cnt = $i;

        $data = array(
            'dorm_id' => $dorm_id,
            'dorm_num' => $dorm_no,
            'dorm_name' => $dorm_name,
            'room_num' => $room,
            'allocated' => $tot_alloc,
            'vacant' => $tot_avail,
            'count' => $cnt,
        );

//             print_r($data);
        $this->load->view('hostel/dorm_report_upload', $data);
    }

    public function room_fetch() {
        $rom_id = $this->input->post('room');
        $dorm = $this->input->post('dorm_id');
        $this->data['room'] = array();

        if ($rom_id != 0 && $dorm != 0) {
            $this->data['room'] = $this->dbconnection->select("room", "*,(select count(id) from dorm_room_student where room_id=$rom_id) as tot_alloc, (select dormitory_no from dormitory where id=$dorm) as d_no, (select dormitory_name from dormitory where id=$dorm) as d_name", "status=1 and id=$rom_id and dorm_id=$dorm");
        } else if ($rom_id == 0 && $dorm != 0) {
            $this->data['room'] = $this->dbconnection->select("room", "*,(select dormitory_no from dormitory where id=$dorm) as d_no,(select dormitory_name from dormitory where id=$dorm) as d_name", "status=1 and dorm_id=$dorm");
        } else if ($rom_id == 0 && $dorm == 0) {
            $this->data['room'] = $this->dbconnection->select("room", "*,(select dormitory_no from dormitory where status=1) as d_no, (select dormitory_name from dormitory where status=1) as d_name", "status=1 and id in (select distinct(room_id) from dorm_room_student where status=1)");
        }


        $i = 0;
        $id = array();
        $dorm_id = array();
        $dorm_name = array();
        $room = array();
        $max = array();
        $tot_alloc = array();
        $tot_avail = array();

        foreach ($this->data['room'] as $row) {
            $id[$i] = $row->id;
            $dorm_id[$i] = $row->d_no;
            $dorm_name[$i] = $row->d_name;
            $room[$i] = $row->room_no;
            $max[$i] = $row->max_student;
            $alloc = $this->dbconnection->select("dorm_room_student", "count(id) as cnt", "room_id=$row->id");
            $tot_alloc[$i] = $alloc[0]->cnt;
            $tot_avail[$i] = (($row->max_student) - ($alloc[0]->cnt));

            $i++;
        }

        $c = $i;

        $data = array(
            'id' => $id,
            'dorm_no' => $dorm_id,
            'dorm_n' => $dorm_name,
            'room_no' => $room,
            'max_stud' => $max,
            'total' => $tot_alloc,
            'avail' => $tot_avail,
            'count' => $c,
        );

//                print_r($this->data['room']);

        $this->load->view('hostel/room_report_upload', $data);
    }

    public function berth_fetch() {
        $rom_id = $this->input->post('room');
        $dorm = $this->input->post('dorm_id');
        $this->data['berth'] = array();

        if ($rom_id != 0 && $dorm != 0) {
            $this->data['berth'] = $this->dbconnection->select("dorm_room_student", "id,berth_no,room_id,(select dormitory_no from dormitory where id=$dorm) as d_id, (select dormitory_name from dormitory where id=$dorm) as d_name", "status=1 and room_id=$rom_id");
        } else if ($rom_id == 0 && $dorm != 0) {
            $this->data['berth'] = $this->dbconnection->select("dorm_room_student", "id,berth_no,room_id,(select dormitory_no from dormitory where id=$dorm) as d_id, (select dormitory_name from dormitory where id=$dorm) as d_name", "status=1 and room_id in(select id from room where dorm_id=$dorm)");
        }

//                else if($rom_id!=0 && $dorm==0)
//                {
//                    $this->data['berth']=$this->dbconnection->select("dorm_room_student","id,berth_no,room_id,(select dormitory_no from dormitory where id in(select dorm_id from room where room_id=$rom_id)) as d_id, (select dormitory_name from dormitory where id in(select dorm_id from room where room_id=$rom_id)) as d_name","status=1 and room_id=$rom_id");
//                }
//                
//                else if($rom_id==0 && $dorm==0)
//                {
//                    $this->data['berth']=$this->dbconnection->select("dorm_room_student","id,berth_no,room_id,(select dormitory_no from dormitory where status=1) as d_id, (select dormitory_name from dormitory where status=1) as d_name","status=1");
//                }
//              

        $i = 0;
        $id = array();
        $dorm_id = array();
        $dorm_name = array();
        $room = array();
        $berth = array();

        foreach ($this->data['berth'] as $row) {
            $room_field = $this->dbconnection->select("room", "room_no,max_student", "id=$row->room_id");
            $id[$i] = $row->id;
            $dorm_id[$i] = $row->d_id;
            $dorm_name[$i] = $row->d_name;
            $room[$i] = $room_field[0]->room_no;
            $berth[$i] = $row->berth_no;
            $i++;
        }

        $cnt = $i;


        $data = array(
            'id' => $id,
            'dorm_num' => $dorm_id,
            'dorm_name' => $dorm_name,
            'room_no' => $room,
            'berth_no' => $berth,
            'count' => $cnt,
        );
//                     print_r($data);
//                     print_r($this->data['berth']);

        $this->load->view('hostel/berth_report_upload', $data);
    }

    public function count_room() {
        $dorm = $this->input->post('dorm_id');
        $room_count = $this->dbconnection->select("room", "count(id) as room", "dorm_id=$dorm");
        $dorm_count = $this->dbconnection->select("dormitory", "no_of_rooms", "id=$dorm");
        $room_no = $room_count[0]->room;
        $dorm_room = $dorm_count[0]->no_of_rooms;
        if ($room_no < $dorm_room) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function count_berth() {
        $dorm1 = $this->input->post('dorm');
        $room1 = $this->input->post('room');

        $berth_count = $this->dbconnection->select("dorm_room_student", "count(id) as total", "room_id=$room1");
        $room_berth = $this->dbconnection->select("room", "max_student", "id=$room1 and dorm_id=$dorm1");

        $room_berth = $room_berth[0]->max_student;
        $berth = $berth_count[0]->total;

        if ($berth < $room_berth) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function report_hos() {

        $this->data['page_name'] = 'under_cons';
        $this->data['page_title'] = 'Dormitory Report';
        $this->data['section'] = 'hostel';
        $this->data['customview'] = '';
        $this->load->view('hostel/berth_report_upload', $this->data);
    }

}
