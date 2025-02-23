
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
               /*error_reporting(-1);
       ini_set('display_errors', 1);*/
        $user_grp_name = array();
        $user_grp = $this->dbconnection->select("user_group", "id,group_type");
        // print_r($user_grp);
        // die();
        foreach ($user_grp as $r) {
            $user_grp_name[$r->id] = $r->group_type;
        }
        $this->user_grp_name = $user_grp_name;
    }

    public function index() {
        // print_r($this->user_grp_name);
        if (!empty($this->session->userdata('user_id'))) {

            redirect('/dashboard');
        }
//        error_reporting(-1);
//		ini_set('display_errors', 1);
        $this->data['page'] = 'login';
        $this->data['page_title'] = 'FeesClub ERP Login';
        $this->data['schools'] = $this->dbconnection->select('school', '*',"status=1");
        $this->data['msg'] = '';
        $this->load->view('login/index', $this->data);
    }

    public function check_group($checker = '') {
//print_r($_POST);
        $this->data['page'] = 'check_group';
        $this->data['page_title'] = 'FeesClub ERP Login';
        $this->data['checker'] = $checker;
        $this->data['schools'] = $this->dbconnection->select('school', '*');
        $this->data['login_group'] = isset($_POST['login_group']) ? $_POST['login_group'] : $checker;
        $this->load->view('login/check_group', $this->data);
    }

    public function call_database($school_id) {
        if ($school_id != 0)
            $this->db->db_select('crmfeesclub_' . $school_id);
    }

    public function submitLogin($user = '', $pass = '', $schoolid = '') {
        $valid_user = FALSE;
        $locked_out = FALSE;
        $in='err';
        if (preg_match('/-/', $this->input->post('username'))) { // We need a - in our username to separate school code from user name
            $school_code_arr = explode('-', $this->input->post('username'));
            if ($school_code_arr[0] == '@') { // Application Admin User
                $school_id = 0;
                $school_name = '';
            } else {
                $school = $this->dbconnection->select("school", "id,school_code,description", "school_code='" . $school_code_arr[0] . "'  and status=1");
                if (count($school) == 1) {
                    $school_id = $school[0]->id;
                    $school_name = $school[0]->description;
                    $school_code = $school[0]->school_code;
                } else {
                	 	$this->data['page'] = 'login';
                        $this->data['page_title'] = 'FeesClub ERP Login';
                        $this->data['msg'] = 'Invalid School Id';
                         redirect('login/index/'.$in,'refresh');
                    // $school_id = FALSE;

                }
            }
            $sch_module = $this->dbconnection->select('school_modules', 'modules', "school_id=$school_id and status='Y'");
            // echo"<pre>";print_r($sch_module);die();
            if ($school_id !== FALSE) { // We have a school ID
                if ($school_id != 0) { // Switch to the school DB for non-application level users 
                    $this->call_database($school_id);
                }
                $user = $this->dbconnection->select("user", "id, password, salt, pw_hash, last_bad_pw_ts, bad_pw_tally, user_name, user_group_id", "user_name='" . $this->input->post('username') . "' and status=1");
                if (count($user) == 1) {
                    $hashoptions = array(); // No options currently, but, we could add in future
                    if ($user[0]->bad_pw_tally > 5 && $user[0]->last_bad_pw_ts > (time() - 300)) { // Locked out!
                        $locked_out = TRUE;
                        $unlock_ts = $user[0]->last_bad_pw_ts + 300;
                        $unlock_delta = $unlock_ts - time();
                    } elseif ($user[0]->pw_hash != '') { // Modern password hash present, we use that
                        if (password_verify($_POST['password'], $user[0]->pw_hash)) { // Is the provided password good?
                            $user_login_update_array = array();
                            if (password_needs_rehash($user[0]->pw_hash, PASSWORD_DEFAULT, $hashoptions)) { // Is the current hash outdated?
                                $newpwhash = password_hash($_POST['password'], PASSWORD_DEFAULT, $hashoptions); // Generate new hash
                                $user_login_update_array['pw_hash'] = $newpwhash;
                            }
                            $user_login_update_array['last_bad_pw_ts'] = 0;
                            $user_login_update_array['bad_pw_tally'] = 0;
                            $user_login_update_array['last_login_ts'] = time();
                            $this->dbconnection->update("user", $user_login_update_array, "id=" . $user[0]->id);
                            $user_id = $user[0]->id;
                            $valid_user = TRUE;
                        } else { // BAD PASSWORD!?! We need to do something about that!
                            $this->db->where('id', $user[0]->id);
                            $this->db->set('last_bad_pw_ts', time());
                            if ($user[0]->bad_pw_tally == '') {
                                $this->db->set('bad_pw_tally', 1);
                            } else {
                                $this->db->set('bad_pw_tally', 'bad_pw_tally+1', FALSE);
                            }
                            $this->db->update('user');
                        }
                    } else { // Oh oh, no modern password hash present - go for legacy upgrade
                        $password = md5($_POST['password'] . $user[0]->salt);
                        if ($password == $user[0]->password) { // Good, we have the right legacy password, let's upgrade
                            $newpwhash = password_hash($_POST['password'], PASSWORD_DEFAULT, $hashoptions);
                            $user_login_update_array['pw_hash'] = $newpwhash;
                            $user_login_update_array['last_bad_pw_ts'] = 0;
                            $user_login_update_array['bad_pw_tally'] = 0;
                            $user_login_update_array['last_login_ts'] = time();
                            $this->dbconnection->update("user", $user_login_update_array, "id=" . $user[0]->id);
                            $user_id = $user[0]->id;
                            $valid_user = TRUE;
                        } else { // BAD PASSWORD!?! We need to do something about that!
                            $this->db->where('id', $user[0]->id);
                            $this->db->set('last_bad_pw_ts', time());
                            if ($user[0]->bad_pw_tally == '') {
                                $this->db->set('bad_pw_tally', 1);
                            } else {
                                $this->db->set('bad_pw_tally', 'bad_pw_tally+1', FALSE);
                            }
                            $this->db->update('user');
                        }
                    }
                }

                if ($valid_user) {
                   
                    $login_type = $this->user_grp_name[$user[0]->user_group_id];
//				
//					1: // Administrator
//						
//					2: // Supervisor
//						
//					3: // School
//				
//					4: // Student
//						
//					5: // Parent
//						
//					6: // Teacher
//					
//					7: // Principal
//						
//					8: // Office
//						
//					9: // Librarian
//						
//					10: // Accountant


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
                                'logintype'=>'login'
                            )
                    );
                    

//				if ($login_type != 'appadmin') { /*---------student-------------*/
////					header("Location: " . base_url("student/dashboard"));
//					header("Location: " . base_url("dashboard/".$login_type."_dashboard"));
//				}else {                       /*--for student,supervisor and school and admin-----*/
                    header("Location: " . base_url("dashboard"));
//				}
                }
// We're done with the school specific database calls for now - reset to 0
                $this->call_database(0);
            }
        }

        if ($locked_out) {
            $this->data['page'] = 'login';
            $this->data['page_title'] = 'FeesClub ERP Login';
            $this->data['msg'] = "Login attempts blocked for $unlock_delta seconds due to failures";
            $this->load->view('login/index', $this->data);
        } else if (!$valid_user) {
            $this->data['page'] = 'login';
            $this->data['page_title'] = 'FeesClub ERP Login';
            $this->data['msg'] = 'Invalid username and password';
            $this->load->view('login/index', $this->data);
        }
    }

    public function student($username, $password) {
        $this->data['page'] = 'login-student';
        $this->data['page_title'] = 'FeesClub ERP Login';
        $this->data['username'] = $username;
        $this->data['password'] = $password;
        $this->load->view('login/login_student', $this->data);
    }

    public function logout() {
        $this->session->sess_destroy();
        header("Location: " . base_url("login"));
    }

    public function go() {
        header('Content-type: application/json');
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Credentials", "true");
        header("Access-Control-Allow-Methods", "GET,HEAD,OPTIONS,POST,PUT");
        header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept, Authorization");
        echo json_encode('hello');
    }

    public function setrememberme($user) {
        $selector = base64_encode(mt_rand(0, 9));
        $authenticator = hash('sha256', base64_encode(mt_rand(0, 9)));

        setcookie(
                'auth_tokens', $selector . ':' . $authenticator, 0, '/'
        );

        $data = array('selector' => $selector,
            'token' => $authenticator,
            'userid' => $user,
            'expires' => date("Y-m-d H:i:s", strtotime("+30 minutes")));

        $this->dbconnection->insert('auth_tokens', $data);
    }

    public function destroyrememberme($user) {
        $where = array('userid' => $user);
        $odet = $this->dbconnection->select('auth_tokens', 'count(*) as cnt', $where);
        if ($odet[0]->cnt > 0) {
            $this->dbconnection->delete('auth_tokens', $where);
        }
        unset($_COOKIE['auth_tokens']);
    }
	
	
	
    public function xml() {
        $this->data['page'] = 'login-student';
        
        $this->load->view('login/sitemap.xml', $this->data);
    }

    public function newpage() {
        
        if (!empty($this->session->userdata('user_id'))) {

            redirect('/dashboard');
        }
//        error_reporting(-1);
//      ini_set('display_errors', 1);
        $this->data['page'] = 'login';
        $this->data['page_title'] = 'FeesClub ERP Login';
        $this->data['schools'] = $this->dbconnection->select('school', '*',"status=1");
        $this->data['msg'] = '';
        $this->load->view('login/indextest', $this->data);
    }


}

?>
