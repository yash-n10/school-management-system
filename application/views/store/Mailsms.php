<?php

//error_reporting(E_ALL);
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* 	
 * 	@author : Joyonto Roy
 * 	date	: 20 August, 2013
 * 	University Of Dhaka, Bangladesh
 *   Nulled By Vokey 
 * 	Ekattor School & College Management System
 * 	http://codecanyon.net/user/joyontaroy
 */

class Mailsms extends CI_Controller {

    public $page_code = 'mailsms';
    public $page_id = '';
    public $page_perm = '----';

    function __construct() {
        parent::__construct();
        $this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");

        $this->load->model('Email_model');
        $this->load->database();
        /* cache control */
//        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
//        $this->output->set_header('Pragma: no-cache');
        $this->load->helper('tam_helper');
//        $this->dynamic_load->add_css(array('href' => asset_url('css','bootstrap.min.css'), 'rel'  => 'stylesheet', 'type' => 'text/css'));
//        $this->dynamic_load->add_js('footer', array('src' => asset_url('js','bootstrap.min.js'), 'type' => 'text/javascript'));
        if (empty($this->session->userdata('user_id'))) {
            redirect('/login');
        }

        $this->total_school = $this->dbconnection->select("school", "count(*) as cnt", "status=1");
        $this->school1 = $this->dbconnection->select('school', '*', 'id = ' . $this->session->userdata('school_id'));

        $this->id = $this->session->userdata('school_id');

        if ($this->id != 0) {
            $this->db->db_select('crmfeesclub_' . $this->id);
//            $this->user = $this->dbconnection->select('user', '*', 'id = ' . $this->session->userdata('user_id'));
//            $this->total_user = $this->dbconnection->select("user", "count(*) as users");
        } else {
//            $this->user = $this->dbconnection->select('user', '*', 'id = ' . $this->session->userdata('user_id'));
//            $this->total_user = $this->dbconnection->select("user", "count(*) as users");
        }
        $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
        $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
        $this->right_access = $this->page_perm;

        if (strpos($this->page_perm, '----') == true) {
            redirect(base_url(''), 'refresh');
        }
        $this->user_details = $this->dbconnection->select("user", "*", "id={$this->session->userdata('user_id')}");
        $this->page_title = 'Mail/SMS';
        $this->section = 'communication';
        $this->page_name = 'mail_sms';
        $this->customview = '';
    }

    /*     * *default functin, redirects to login page if no principal logged in yet** */

    public function index() {
        $page_data['page_name'] = $this->page_name;
        $page_data['page_title'] = $this->page_title;
        $page_data['section'] = $this->section;
        $page_data['customview'] = $this->customview;
        $page_data['right_access'] = $this->right_access;
        $page_data['sentdata'] = $this->dbconnection->select("mail", "*", "status='Y' and created_by={$this->session->userdata('user_id')}");
        $page_data['inboxdata'] = $this->dbconnection->select("mail", "*", "status='Y' and to_user='{$this->user_details[0]->email}'");
        $page_data['trashdata'] = $this->dbconnection->select("mail", "*", "status='N'");
        $page_data['smsdata'] = $this->dbconnection->select("messages", "*", "created_by={$this->session->userdata('user_id')}");
        $this->load->view('index', $page_data);
    }

    public function compose_mail() {
//        $this->session->set_flashdata('successmailmsg','');
        if (substr($this->right_access, 0, 1) != 'C') {
            redirect('404');
        }
        $page_data['page_name'] = 'composemail';
        $page_data['page_title'] = 'Compose Mail';
        $page_data['section'] = 'communication';
        $page_data['customview'] = '';
        $this->load->view('index', $page_data);
    }

    public function send_mail() {
        if (substr($this->right_access, 0, 1) != 'C') {
            redirect('404');
        }
        $from = $this->user_details[0]->email;
        
        if (empty($from)) {
            $this->session->set_flashdata('errormailmsg', 'Email Id is not configured with your user Account');
            header("Location: " . site_url("communication/mailsms/compose_mail"));
        }
        $subject = $this->input->post('subject');
        $message = $this->input->post('message');
        $attach = $this->input->post('attachment');
     
        $config = Array(
            'protocol' => 'smtp',
//            'smtp_crypto' => 'ssl',
            'smtp_host' => 'ssl://sg2plcpnl0143.prod.sin2.secureserver.net',
            'smtp_port' => 465,
            'smtp_user' => 'info@feesclub.com',
            'smtp_pass' => 'fees@2018',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'wordwrap' => TRUE
        );

        $this->load->library('email', $config);
       $this->email->initialize($config);
       // $this->email->set_header('MIME-Version', '1.0; charset=utf-8');
       // $this->email->set_header('Content-type', 'multipart/mixed');
       // $this->email->set_header('Content-type', 'text/html,application/octet-stream');
       // $this->email->set_header('Content-Disposition', 'attachment; filename=Feesclub');

        $this->email->from($from, $this->session->userdata('school_name'));
//        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
//        $this->email->set_newline("\r\n");
//          $this->email->_set_date();
        if (!empty($_FILES['attachment']['name'])) {
//        $this->email->set_header('Content-type', 'application/octet-stream');
//        $this->email->set_header('Content-Transfer-Encoding', 'base64');
//        $this->email->set_header('Content-Disposition', 'attachment');
//        $this->email->set_header('Content-type', 'application/octet-stream');
            $this->load->helper('file_upload_helper');
            $path1 = pathinfo($_FILES['attachment']['name']);
            $ext1 = $path1['extension'];
            $filename = 'Attach_' . $this->id . '_' . date('Ymdhis') . '.' . $path1['extension'];
            $status = do_upload('attachment', './assets/attach/', $filename);
            if (!empty($status['errors'])) {

                $this->session->set_flashdata('errormailmsg', $status['errors']);
                $this->compose_mail();
                return;
            } else {
                $this->email->attach('assets/attach/' . $filename, 'attachment', $this->session->userdata('school_name'));
            }
        }
        $to_data = array();
        $more_email = array();
        switch ($this->input->post('mail_to')) {
            case 'all_employee':
                $to_data = $this->dbconnection->select_returnarray("employee", "id,email", "status='1' and email!='' ");

                break;
            case 'teaching_staff':
                $to_data = $this->dbconnection->select_returnarray("employee", "id,email", "status='1' and email!='' and category_id=1");

                break;
            case 'non_teaching_staff':
                $to_data = $this->dbconnection->select_returnarray("employee", "id,email", "status='1' and email!='' and category_id=2");

                break;
            case 'all_student':
                $to_data = $this->dbconnection->select_returnarray("student", "id,admission_no,email_address as email", "status='Y' and email_address!=''");

                break;
            default:
                $to_data[] = ['email' => $this->input->post('to_email')];
                break;
        }

        foreach ($to_data as $key => $value) {
            $more_email[] = $value['email'];
        }

        $to = $more_email;
        $this->email->to($to);
        $e = $this->email->send();
        if ($e) {
            $this->session->set_flashdata('successmailmsg', 'Email Sent');
//            echo 'Email sent.';
            foreach ($to as $value) {
                $data = array(
                    'from_user' => $from,
                    'to_user' => $value,
                    'subject' => $subject,
                    'message_content' => $message,
                    'attachment' => $filename,
                    'type' => $this->input->post('mail_to'),
                    'sent_ts' => date('Y-m-d H:i:s'),
                    'send_ip' => $this->input->ip_address(),
                    'created_by' => $this->session->userdata('user_id'),
                );
                $this->dbconnection->insert('mail', $this->security->xss_clean($data));
            }

            header("Location: " . site_url("communication/mailsms/compose_mail"));
        } else {
            $this->session->set_flashdata('errormailmsg', 'Email is Not Sent');
            $this->compose_mail();
            show_error($this->email->print_debugger());
            return;
        }
    }

    public function send_mail_codeigniter() {
        $config = Array(
            'protocol' => 'smtp',
//            'smtp_crypto' => 'ssl',
            'smtp_host' => 'ssl://sg2plcpnl0143.prod.sin2.secureserver.net',
            'smtp_port' => 465,
            'smtp_user' => 'info@feesclub.com',
            'smtp_pass' => 'fees@2018',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'wordwrap' => TRUE
        );

        $this->load->library('email');
        $this->email->initialize($config);
        $this->email->from('neha.smiley.np@gmail.com', $this->session->userdata('school_name'));
        $this->email->to('neha.np.prasad@gmail.com');
        $this->email->subject('sfdgfh');
        $this->email->message('hellooooooooo Smiley');
        $this->email->attach('assets/attach/Invoice.pdf', 'attachment', 'Feesclub');
        $e = $this->email->send();
        if ($e) {
            echo 'Email Sent';
        } else {
            show_error($this->email->print_debugger());
        }
    }

    public function send_mail_mailer() {

        $this->load->library('PHPMail');
        $this->PHPmail->IsMail();                                      // set mailer to use SMTP
        $this->PHPmail->Host = "sg2plcpnl0143.prod.sin2.secureserver.net";  // specify main and backup server
        $this->PHPmail->SMTPAuth = true;     // turn on SMTP authentication
        $this->PHPmail->Username = "info@feesclub.com";  // SMTP username
        $this->PHPmail->Password = "fees@2018"; // SMTP password

        $this->PHPmail->From = "info@feesclub.com";
        $this->PHPmail->FromName = "Feesclub";

        $this->PHPmail->AddAddress("neha.np.prasad@gmail.com", "neha");
        $this->PHPmail->WordWrap = 50;                                 // set word wrap to 50 characters
        $this->PHPmail->IsHTML(true);                                  // set email format to HTML
        $this->PHPmail->Subject = 'make some smile';
        $this->PHPmail->Body = "Plz check the attachment";
//$mail->AddStringAttachment($attachment,$application, 'base64', 'application/pdf');
        if (!$this->PHPmail->Send()) {
            echo "Message could not be sent. <p>";
            echo "Mailer Error: " . $this->PHPmail->ErrorInfo;
            exit;
        }

        echo "Message has been sent";
    }

    public function compose_sms() {
        if (substr($this->right_access, 0, 1) != 'C') {
            redirect('404');
        }
        $page_data['page_name'] = 'composesms';
        $page_data['page_title'] = 'Compose SMS';
        $page_data['section'] = 'communication';
        $page_data['customview'] = '';
        $this->load->view('index', $page_data);
    }

    function send_sms() {
        $this->load->helper('sms_helper');
        if (substr($this->right_access, 0, 1) != 'C') {
            redirect('404');
        }

//        $to=$this->input->post('to_number');
        $msg = $this->input->post('message');

        switch ($this->session->userdata('school_id')) {
            case 26 : $sender = 'MOUNTC';
                $sms_gy = 'send_smstomountc';
                break;
            case 5 : $sender = 'VVSJSR';
            $sms_gy = 'send_bulksmsind_vv';
            break;
            default : $sender = 'MILDRX';
                $sms_gy = 'send_bulksmsind';
                break;
        }


        switch ($this->input->post('sms_to')) {
            case 'all_employee':
                $to_data = $this->dbconnection->select_returnarray("employee", "id,phone_no", "status='1' and (phone_no!='' or phone_no!=0) ");

                break;
            case 'teaching_staff':
                $to_data = $this->dbconnection->select_returnarray("employee", "id,phone_no", "status='1' and (phone_no!='' or phone_no!=0) and category_id=1");

                break;
            case 'non_teaching_staff':
                $to_data = $this->dbconnection->select_returnarray("employee", "id,phone_no", "status='1' and (phone_no!='' or phone_no!=0) and category_id=2");

                break;
            case 'all_student':
                $to_data = $this->dbconnection->select_returnarray("student", "id,admission_no,phone as phone_no", "status='Y' and (phone!='' or phone!=0)");

                break;
            default:
                $to_data[] = ['phone_no' => $this->input->post('to_number'), 'id' => 'specific'];
                break;
        }


        foreach ($to_data as $value) {

            $s = $sms_gy($value['phone_no'], $msg, $sender);

            $data = array(
                'from_user' => $this->user_details[0]->user_name,
                'to_user' => $value['id'],
                'to_number' => $value['phone_no'],
                'message_content' => $msg,
                'type' => $this->input->post('sms_to'),
                'response' => $s['responseCode'],
                'msg_id' => $s['msgid'],
                'sent_ts' => date('Y-m-d H:i:s'),
                'send_ip' => $this->input->ip_address(),
                'created_by' => $this->session->userdata('user_id'),
            );
            $this->dbconnection->insert('messages', $this->security->xss_clean($data));
        }
        $this->session->set_flashdata('successsmsmsg', 'SMS Sent');
        header("Location: " . site_url("communication/mailsms/compose_sms"));
    }

    public function send_sms_biz_payment($amount_val, $year_val, $school_val, $admission_val, $mon_year, $month_name, $mob_number) {
        $this->load->helper('sms_helper');
        if ($mon_year == 'month') {
            $next_year = $year_val + 1;
            $next_year = substr($next_year, -2);
            $session = $year_val . '-' . $next_year;
            $message_content = "INR $amount_val is deposited as monthly fee for the month of $month_name - $session into $school_val account against student admission no $admission_val . We welcome you in FEESCLUB family. Thanks!";
        } else {
            $blank = " ";
            $message_content = "INR $amount_val is deposited as annual fee for the year $year_val into $school_val $blank account against student admission no $admission_val.We welcome you in FEESCLUB family. Thanks!";
        }

        send_sms_biz($mob_number, $message_content);
    }

    /*     * ****MANAGE SMS CLASSWISE***** */

    function sms_view($param1 = '', $param2 = '') {
//echo "The class id is ".$param1;
        if ($param2 == 'send_group_sms') {
            $numbers = $this->input->post('sms_recepients1');
            $msg = $this->input->post('send_sms');
            if ($numbers == -1 || $numbers == "-1") {
                send_sms_to_class($param1, $msg);
            }
        }
        if ($param2 == 'send_template_sms') {
            
        }
        $page_data['class_id'] = $param1;
        $page_data['page_name'] = 'sms_view';
        $page_data['page_title'] = get_phrase('sms_view');
        $this->load->view('index', $page_data);
    }

    /*     * ****MANAGE SMS TEMPLATE***** */

    function sms_template_view($param1 = '', $param2 = '') {

        if ($param1 == 'create') {
            $data['sms_template_content'] = $this->input->post('sms_template_content');
            $this->db->insert('sms_template', $data);
            redirect(base_url() . 'communication/mailsms/sms_template_view', 'refresh');
        }
        if ($param1 == 'do_update') {
            $data['sms_template_content'] = $this->input->post('sms_template_content');
            $this->db->where('sms_template_id', $param2);
            $this->db->update('sms_template_content', $data);
//$this->db->last_query();
            redirect(base_url() . 'communication/mailsms/sms_template_view', 'refresh');
        } else if ($param1 == 'edit') {
            $page_data['edit_data'] = $this->db->get_where('sms_template', array(
                        'sms_template_id' => $param2
                    ))->result_array();
        }
        if ($param1 == 'delete') {
            $this->db->where('sms_template_id', $param2);
            $this->db->delete('sms_template');
            redirect(base_url() . 'communication/mailsms/sms_template_view', 'refresh');
        }
        $page_data['sms_templates'] = $this->db->get('sms_template')->result_array();
        $page_data['page_name'] = 'sms_template_view';
        $page_data['page_title'] = get_phrase('sms_template_view');
        $this->load->view('index', $page_data);
    }

    function sent_sms() {
        $page_data['sent_sms'] = $this->db->get('sent_sms')->result_array();
        $page_data['page_name'] = 'sent_sms';
        $page_data['page_title'] = get_phrase('sent_sms');
        $this->load->view('index', $page_data);
    }

    /* ########################MANAGE MAIL SMS############################### */

    function getClass() {
        $this->load->model('fee_model');
        $sm_class_data = $this->fee_model->getclass();

        $apnddata .= ' 	<div class="control-group"><label class="control-label" for="rec_c_id">' . get_phrase('class') . '</label>
<div class="controls"><select id="rec_c_id" name="rec_c_id" class="uniform validate[required]"><option value="">----select class----</option><option value="all">ALL</option>';

        foreach ($sm_class_data as $sm_class_data_view) {

            $apnddata .= '<option value="' . $sm_class_data_view->class_id . '">' . $sm_class_data_view->name . '-' . $sm_class_data_view->name_numeric . '</option>';
        }
        $apnddata .= '</select></div></div>';

        echo $apnddata;
    }

    function sendmailsms() {

        $rmthd = $this->input->post('receivermethod');
        $rtype = $this->input->post('receivertype');

        if ($rtype == 1) {

            $sm_qry = $this->db->get('teacher')->result();

            $smsdata = '';
            foreach ($sm_qry as $sm_qry_dta) {
                if ($sm_qry_dta->phone != '') {
                    $smsdata .= $sm_qry_dta->phone . ',';
                }
            }

            $smsto = rtrim($smsdata, ',');
        }

        if ($rtype == 2) {

            $cid = $this->input->post('rec_c_id');

            if ($cid != '' && $cid != 'all') {
                $this->db->where('class_id', $cid);
            }

            $sm_qry = $this->db->get('student')->result();


            $smsdata = '';
            foreach ($sm_qry as $sm_qry_dta) {
                if ($sm_qry_dta->phone != '') {
                    $smsdata .= $sm_qry_dta->phone . ',';
                }
            }


            $smsto = rtrim($smsdata, ',');
        }

        if ($rtype == 3) {

            $cid = $this->input->post('rec_c_id');

            if ($cid != '' && $cid != 'all') {
                $this->db->where('class_id', $cid);
            }

            $sm_qry = $this->db->get('student')->result();


            $smsdata = '';
            foreach ($sm_qry as $sm_qry_dta) {
                if ($sm_qry_dta->parent_phone1 != '') {
                    $smsdata .= $sm_qry_dta->parent_phone1 . ',';
                }
            }


            $smsto = rtrim($smsdata, ',');
        }

        if ($rmthd == 1) {

            $msg = $this->input->post('smmsg');


            $sus_sm = send_tam_sms($smsto, $msg);

// if($sus_sm !=''){
            $this->session->set_flashdata('msg', 'SMS Send Success');
            redirect(base_url() . 'communication/mailsms', 'refresh');
// }
        }
        if ($rmthd == 2) {
            $ac_type = $rtype;
            $email_subject = $this->input->post('smmsgt');
            $email_body = $this->input->post('smmsg');
            if ($ac_type == 2) {
                $cid = $this->input->post('rec_c_id');

                if ($cid != '' && $cid != 'all') {
                    $this->db->where('class_id', $cid);
                }
                $results = $this->db->get('student')->result_array();
                foreach ($results as $result) {
                    if (!empty($result['email'])) {
                        $student_email[] = $result['email'];
                        $student_id[] = $result['student_id'];
                    }
                }
                $student_to = implode(',', $student_email);
                $student_read = implode(',', $student_id);
                $data = array();
                $data['unread'] = $student_read;
                $data['read'] = "";
                $data['time'] = date("Y-m-d H:i:s");
                $data['type'] = 'student';
                $data['subject'] = $email_subject;
                $data['body'] = $email_body;

                $this->db->insert('email', $data);
                $this->email_model->send_email('student', $student_to, $email_subject, $email_body);
            } else if ($ac_type == 1) {
                $results = $this->db->get('teacher')->result_array();
                foreach ($results as $result) {
                    if (!empty($result['email'])) {
                        $teacher_email[] = $result['email'];
                        $teacher_id[] = $result['teacher_id'];
                    }
                }
                $teacher_read = implode(',', $teacher_id);
                $data = array();
                $data['unread'] = $teacher_read;
                $data['read'] = "";
                $data['time'] = date("Y-m-d H:i:s");
                $data['type'] = 'teacher';
                $data['subject'] = $email_subject;
                $data['body'] = $email_body;
                $this->db->insert('email', $data);

                $teacher_to = implode(',', $teacher_email);
                $this->email_model->send_email('teacher', $teacher_to, $email_subject, $email_body);
            } else if ($ac_type == 3) {

                $cid = $this->input->post('rec_c_id');

                if ($cid != '' && $cid != 'all') {
                    $this->db->where('class_id', $cid);
                }
                $result = $this->db->get('student')->result_array();

                foreach ($result as $result) {

                    if (!empty($result['parent_email'])) {
                        $parent_email[] = $result['parent_email'];
                        $parent_id[] = $result['student_id'];
                    }
                }
                if (!empty($parent_id)) {
                    $parent_read = implode(',', $parent_id);
                }
                $data = array();
                $data['unread'] = $parent_read;
                $data['read'] = "";
                $data['time'] = date("Y-m-d H:i:s");
                $data['type'] = 'parent';
                $data['subject'] = $email_subject;
                $data['body'] = $email_body;
                $this->db->insert('email', $data);

                $parent_to = implode(',', $parent_email);
                $this->email_model->send_email('parent', $parent_to, $email_subject, $email_body);
            }

            $this->session->set_flashdata('msg', 'Mail Send Success');
            redirect(base_url() . 'communication/mailsms', 'refresh');
        }

//send_tam_sms($to,$msg);
    }

    function send_sms_unpaid_mem() {

        $data1 = $this->input->post('smem');
        $pname = $this->input->post('hid_pname');
        $pddate = $this->input->post('hid_pddate');
        foreach ($data1 as $key => $value) {


            $this->db->select('name as sname,parent_phone1 as pphone');
            $this->db->where('student_id', $value);
            $query = $this->db->get_where('student');

            $rse = $query->row_array();

            extract($rse);



            $sid = $sname;

            $to = $pphone;

            $msg = "Please payment amount for " . $pname . "  on or before due date " . $pddate . " for your child " . $sid . "";



            send_tam_sms($to, $msg);
        }
    }

    public
            function graphstudent() {
        $page_data = '';
        $page_data['page_name'] = 'graphstudent';
        $page_data['page_title'] = get_phrase('Student_Graph');
        $page_data['exam'] = $this->db->query('select * from exam where 1 order by name asc')->result_array();
        $page_data['class'] = $this->db->query('select * from class where 1 order by name asc')->result_array();
        foreach ($page_data['class'] as $class) {
            $classes[$class['class_id']] = $class['name'];
        }
        $page_data['class_name'] = $classes;
        $page_data['subject'] = $this->db->query('select * from subject where 1 order by name asc')->result_array();
        foreach ($page_data['subject'] as $subjects) {
            $subjectsall[$subjects['subject_id']] = $subjects['name'];
        }
        $page_data['subjectsall'] = $subjectsall;
        if ($_POST['rollnumber'] && $_POST['exam_ids']) {
            $_POST['subject_id'] = '';
            $_POST['class_id'] = '';
            $page_data['marks'] = $this->db->query("SELECT s.roll,s.name,m.mark_obtained,m.subject_id FROM `mark` m JOIN student s ON s.student_id = m.student_id WHERE s.roll='" . $_POST['rollnumber'] . "' and m.exam_id='" . $_POST['exam_ids'] . "'")->result_array();
        } else if ($_POST['subject_id'] && $_POST['class_id'] && $_POST['exam_id']) {
            $_POST['rollnumber'] = '';
            $page_data['marks'] = $this->db->query("SELECT s.roll,s.name,m.mark_obtained FROM `mark` m JOIN student s ON s.student_id = m.student_id WHERE m.subject_id = '" . $_POST['subject_id'] . "' AND m.class_id = '" . $_POST['class_id'] . "' and m.exam_id='" . $_POST['exam_id'] . "'")->result_array();
        }
//print_r($page_data['marks']);
        $this->load->view('index', $page_data);
    }

    function sms_student_data() {
        $sid = $this->input->post('sid');

        $this->db->select('name,father_name,parent_phone1');
        $this->db->where('student_id', $sid);
        $query = $this->db->get_where('student');

        $data = $query->row_array();
        extract($data);

        echo '<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">�</button>
<h3 id="custom-tam-mode">Send SMS to ' . $father_name . ' (Parent Name)</h3>
</div>
<div class="modal-body">
<div id="sms-overlay"><img src="' . base_url() . '/template/images/ajax-loader-2.gif"></div>
<div id="sms-feedback"></div>
<form class="form-horizontal" method="post" action="#" id="snd-frm">
<div class="control-group">
<label class="control-label" for="inputEmail">Student Name</label>
<div class="controls">
<p class="cstm-sts-txt">' . $name . '</p>
</div>
</div>
<div class="control-group">
<label class="control-label" for="inputEmail">Parent Phone</label>
<div class="controls">
<p class="cstm-sts-txt">' . $parent_phone1 . '</p>
</div>
</div>
<div class="control-group">
<label class="control-label" for="inputPassword">Message</label>
<div class="controls">
<textarea id="smessage" name="smessage" placeholder="Message" style="resize:none" maxlength="130"> </textarea>
</div>
</div>
<div class="control-group">
<label class="control-label" for=""></label>
<div class="controls">
<p id="smessage_feedback"> </p>
</div>
</div>
<div class="control-group">
<div class="controls">
<input type="hidden" value="' . $parent_phone1 . '" id="smsphone" name="smsphone">
<button type="button" class="btn btn-success" id="sndsmsbtn">Send SMS</button>
</div>
</div>
</form>

</div>
<div class="modal-footer">
<button class="btn btn-success btn-small" data-dismiss="modal" aria-hidden="true">Close</button>

</div>';
    }

    function sms_student_snd() {

        $sphone = $this->input->post('smsphone');

        $smsg = $this->input->post('smessage');

        $res = send_tam_sms($sphone, $smsg);

        if ($res) {
            echo "true";
        } else {
            echo "false";
        }
    }

    function email_student_data() {
        $sid = $this->input->post('sid');

        $this->db->select('name,father_name');
        $this->db->where('student_id', $sid);
        $query = $this->db->get_where('student');

        $data = $query->row_array();
        extract($data);

        echo '<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">�</button>
<h3 id="custom-tam-mode">Send Email to ' . $father_name . ' (Parent Name)</h3>
</div>
<div class="modal-body">
<div id="sms-overlay"><img src="' . base_url() . '/template/images/ajax-loader-2.gif"></div>
<div id="sms-feedback"></div>
<form class="form-horizontal" method="post" action="#" id="snd-frm">
<div class="control-group">
<label class="control-label" for="inputEmail">Student Name</label>
<div class="controls">
<p class="cstm-sts-txt">' . $name . '</p>
</div>
</div>
<div class="control-group">
<label class="control-label" for="inputEmail">Subject</label>
<div class="controls">
<input type="text" name="ssub" id="ssub" >
</div>
</div>
<div class="control-group">
<label class="control-label" for="inputPassword">Message</label>
<div class="controls">
<textarea id="smmessage" name="smmessage" placeholder="Message" style="resize:none" rows="8"> </textarea>
</div>
</div>
<div class="control-group">
<label class="control-label" for=""></label>
<div class="controls">
<p id="smessage_feedback"> </p>
</div>
</div>
<div class="control-group">
<div class="controls">
<input type="hidden" value="' . $sid . '" id="mid" name="mid">
<button type="button" class="btn btn-success" id="sndmailbtn">Send Mail</button>
</div>
</div>
</form>

</div>
<div class="modal-footer">
<button class="btn btn-success btn-small" data-dismiss="modal" aria-hidden="true">Close</button>

</div>';
    }

    function mail_student_snd() {

        $ssub = $this->input->post('ssub');

        $smsg = $this->input->post('smmessage');

        $mid = $this->input->post('mid');

        $this->db->select('parent_email');
        $this->db->where('student_id', $mid);
        $query = $this->db->get_where('student');

        $datam = $query->row_array();
        extract($datam);

        $data = array();
        $data['unread'] = $mid;
        $data['read'] = "";
        $data['time'] = date("Y-m-d H:i:s");
        $data['type'] = 'parent';
        $data['subject'] = $ssub;
        $data['body'] = $smsg;
        $res = $this->db->insert('email', $data);




        if ($res) {
            echo "true";
        } else {
            echo "false";
        }
    }

}

?>
