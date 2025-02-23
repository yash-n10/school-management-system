
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Vvlogin extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $user_grp_name = array();
        $user_grp = $this->dbconnection->select("user_group", "id,group_type");
        foreach ($user_grp as $r) {
            $user_grp_name[$r->id] = $r->group_type;
        }
        $this->user_grp_name = $user_grp_name;
        
    }

    public function index() {
        
        if (!empty($this->session->userdata('user_id')) && $this->session->userdata('user_group_id')==4) {

            redirect('/payment');
        }

        $this->load->view('login/vvlogin');
    }


    public function call_database($school_id) {
        if ($school_id != 0)
            $this->db->db_select('crmfeesclub_' . $school_id);
    }

    public function submit($user = '', $pass = '', $schoolid = '') {
        $valid_user = FALSE;
        $locked_out = FALSE;

       
                $school = $this->dbconnection->select("school", "id,school_code,description", "school_code='VV'  and status=1");
                if (count($school) == 1) {
                    $school_id = $school[0]->id;
                    $school_name = $school[0]->description;
                    $school_code = $school[0]->school_code;
                } else {
                    $school_id = FALSE;
                }

            $sch_module = $this->dbconnection->select('school_modules', 'modules', "school_id=$school_id and status='Y'");
            if ($school_id !== FALSE) { // We have a school ID
                if ($school_id != 0) { // Switch to the school DB for non-application level users 
                    $this->call_database($school_id);
                }
                $user = $this->dbconnection->select("user", "id, password, salt, pw_hash, last_bad_pw_ts, bad_pw_tally, user_name, user_group_id", "user_name='VV-" . $this->input->post('adm_no') . "' and status=1 and student_id!=0");
                if (count($user) == 1) {
                     $valid_user = TRUE;
                }

                if ($valid_user) {

                    $login_type = $this->user_grp_name[$user[0]->user_group_id];
                    $this->session->set_userdata(
                            array(
                                'user_id' => $user[0]->id,
                                'user_name' => $user[0]->user_name,
                                'user_group_id' => $user[0]->user_group_id,
                                'school_id' => $school_id,
                                'school_name' => $school_name,
                                'school_code' => $school_code,
                                'login_type' => $login_type, // it has user type information ... e.g student, teacher, principle, admin, appadmin etc
                                'sch_modules' => $sch_module,
                                'logintype'=>'vvlogin'
                            )
                    );
                  
                    header("Location: " . base_url("payment"));

                }

                $this->call_database(0);
            }


        if (!$valid_user) {
            $this->data['page'] = 'login';
            $this->data['page_title'] = 'FeesClub ERP Login';
            $this->data['msg'] = 'Invalid Admission';
            $this->load->view('login/vvlogin', $this->data);
        }
    }


    public function logout() {
        $this->session->sess_destroy();
        header("Location: " . base_url("vvlogin"));
    }


}

?>
