<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Report_defaulter extends CI_Controller {

    public function __construct() {

        parent::__construct();
        if (empty($this->session->userdata('user_id')) || $this->session->userdata('user_group_id') == 4) {
            redirect('/login');
        }
        // error_reporting(-1);
        // ini_set('display_errors', 1);
        // $this->db->db_debug=TRUE;
        $this->id = $this->session->userdata('school_id');
        $this->school_desc = $this->dbconnection->select("school", "*", "id=" . $this->id . " and status = 1");
        $this->school_date_created=$this->dbconnection->Get_namme("school","id",$this->id,"start_report_date");
        if ($this->id != 0)
            $this->db->db_select('crmfeesclub_' . $this->id);
        $this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y' and active='Y'");
        $fetch_startyr = isset($this->academic_session[0]->start_date) ? explode('-', $this->academic_session[0]->start_date) : array('0');
        $this->session_start_yr = reset($fetch_startyr);
        $fetch_endyr = isset($this->academic_session[0]->end_date) ? explode('-', $this->academic_session[0]->end_date) : array('0');
        $this->session_end_yr = reset($fetch_endyr);

          $this->schoolgrp=$this->dbconnection->Get_namme("crmfeesclub.school","id",$this->id,"school_group");
    }

    public function index() {
     

        $this->data['page_title'] = 'Fee Defaulters';
        $this->data['section'] = 'feepayment/report';
        $this->data['page_name'] = 'fee_defaulter_headwise';
        $this->data['customview'] = '';
        $this->data['school_date_created'] =$this->school_date_created;
        $this->data['aclass'] = $this->dbconnection->select("class", "id,class_name", "status='Y'");
        $this->data['asection'] = $this->dbconnection->select("section", "id,sec_name", "status='Y'");
        $this->data['acategory'] = $this->dbconnection->select("category", "id,cat_name", "status='Y'");
        $this->data['asession'] = $this->dbconnection->select("accedemic_session", "*", "status='Y'","id","DESC");
        $this->data['session_end_date'] = $this->academic_session[0]->end_date;
        $this->data['collection_center'] = $this->dbconnection->select("collection_center", "id,collection_code,collection_desc", "status='Y'");
        $schoolgrp=$this->dbconnection->Get_namme("crmfeesclub.school","id",$this->id,"school_group");
        $this->data['schoolgrp'] = $schoolgrp;
        $this->load->view('index', $this->data);
       
    }

    public function defaulter_report() {
        $aca_session = $this->input->post('aca_session');
        // die();
        $class_id = $this->input->post('class_id');
        $section_id = $this->input->post('section_id');
        $term = $this->input->post('term');
        $indication = $this->input->post('indication');
        $month = $this->input->post('choosetillmonth');
        
        /* -------------- */
        if ($month >= 4 && $month <= 12) {
           $month = $month - 3;
        } else {
           $month = $month + 9;
        }
        
        
        /* ------------------ */

        if (date('Y-m-d') > $this->academic_session[0]->end_date) {
            $month = 12;
        }

        $order = '';
        $like = array();
        $or_like = array();
        $output = array();
        $offset = $this->input->post('start');
        $limit = $this->input->post('length');

        $select = "s.id,s.admission_no,concat(s.first_name,' ',s.middle_name,' ',s.last_name) as name,s.class_id,s.stud_category,s.course_id,(select class_name from class where id=s.class_id) as class_name,(select sec_name from section where id=s.section_id) as sec_name,(select cat_code from category where id=s.stud_category) as cat_code,s.father_name,s.phone,s.transport_amt,s.student_academicyear_id";
        if($this->session->userdata('school_id')==35)
        {
            $strfeecat="and s.stud_category!=4";
        }
        else if($this->session->userdata('school_id')==5)
        {
            $strfeecat="and s.stud_category NOT IN (3,5)";
        }
        else if($this->session->userdata('school_id')==29)
        {
            $strfeecat="and s.stud_category!=3";
        }
        else{
            $strfeecat="";
        }
        if ($section_id == 'all' && $class_id == 'all') {
            $str_query = "where s.status='Y'";
        } else if ($section_id == 'all' && $class_id != 'all') {
            $str_query = "where s.class_id=$class_id and s.status='Y'" ;
        } else {

            $str_query = "where s.class_id=$class_id and s.section_id=$section_id and s.status='Y'";
        }
        $month_arr = array(1 => 'April', '2' => 'May', '3' => 'June', '4' => 'July', '5' => 'Aug', '6' => 'Sep', '7' => 'Oct', '8' => 'Nov', '9' => 'Dec', '10' => 'Jan', '11' => 'Feb', '12' => 'Mar', '13' => 'Apr', '14' => 'May');


        if($indication=='monthwise'){
            $month_no_query="'$month_arr[$month]'";
        }else{
             $month_no_query="cast($month-count(d2.month_no) as char)";
        }
        

        if ($term == 'all') {
            if($this->session->userdata('school_id')==29)
            {
                $query_defaulter = $this->db->query("select $select,if(count(f1.id)=0,'Unpaid','Paid') as annual,if(count(d2.month_no)>=$month"
                    . " ,'Paid',$month_no_query) as monthly from student as s"
                    . " left join ( fee_transaction_head as f1 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d1 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f1.id=d1.fee_trans_head_id and d1.fee_cat_id=1 and f1.year=$aca_session)"
                    . " on f1.student_id=s.id and f1.paid_status=1 "
                    . " left join ( fee_transaction_head as f2 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d2 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f2.id=d2.fee_trans_head_id and d2.fee_cat_id in (2,5) and f2.year=$aca_session)"
                    . " on f2.student_id=s.id and f2.paid_status=1  and f2.response_code=0 $str_query $strfeecat group by s.id having ( annual!='Paid' or monthly!='Paid')")->result();
            }
            else
            {
              $query_defaulter = $this->db->query("select $select,if(count(f1.id)=0,'Unpaid','Paid') as annual,if(count(d2.month_no)>=$month"
                    . " ,'Paid',$month_no_query) as monthly from student as s"
                    . " left join ( fee_transaction_head as f1 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d1 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f1.id=d1.fee_trans_head_id and d1.fee_cat_id=1 and f1.year=$aca_session)"
                    . " on f1.student_id=s.id and f1.paid_status=1 "
                    . " left join ( fee_transaction_head as f2 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d2 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f2.id=d2.fee_trans_head_id and d2.fee_cat_id in (2,5) and f2.year=$aca_session)"
                    . " on f2.student_id=s.id and f2.paid_status=1  and f2.response_code=0  $str_query $strfeecat group by s.id having ( annual!='Paid' or monthly!='Paid')")->result();  
            }


            if ($offset == '') {
                $str_query2 = "limit $limit";
            } else {
                $str_query2 = "limit $limit offset $offset";
            }
            $query = $this->db->query("select $select,if(count(f1.id)=0,'Unpaid','Paid') as annual,if(count(d2.month_no)>=$month"
                    . " ,'Paid',$month_no_query) as monthly from student as s"
                    . " left join ( fee_transaction_head as f1 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d1 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f1.id=d1.fee_trans_head_id and d1.fee_cat_id=1 and f1.year=$aca_session)"
                    . " on f1.student_id=s.id and f1.paid_status=1 "
                    . " left join ( fee_transaction_head as f2 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d2 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f2.id=d2.fee_trans_head_id and d2.fee_cat_id in (2,5) and f2.year=$aca_session)"
                    . " on f2.student_id=s.id and f2.paid_status=1  and f2.response_code=0  $str_query $strfeecat  group by s.id having ( annual!='Paid' or monthly!='Paid') $str_query2");
        } else if ($term == '1') {

            $query_defaulter = $this->db->query("select $select,if(count(f1.id)=0,'Unpaid','Paid') as annual,"
                    . " '' as monthly from student as s"
                    . " left join ( fee_transaction_head as f1 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d1 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f1.id=d1.fee_trans_head_id and d1.fee_cat_id=1 and f1.year=$aca_session)"
                    . " on f1.student_id=s.id and f1.paid_status=1 "
                    . " $str_query $strfeecat group by s.id having ( annual!='Paid')")->result();

            if ($offset == '') {
                $str_query2 = "limit $limit";
            } else {
                $str_query2 = "limit $limit offset $offset";
            }
            $query = $this->db->query("select $select,if(count(f1.id)=0,'Unpaid','Paid') as annual,"
                    . " '' as monthly from student as s"
                    . " left join ( fee_transaction_head as f1 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d1 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f1.id=d1.fee_trans_head_id and d1.fee_cat_id=1 and f1.year=$aca_session)"
                    . " on f1.student_id=s.id and f1.paid_status=1 "
                    . " $str_query $strfeecat group by s.id having ( annual!='Paid') $str_query2");
        } else {

            $query_defaulter = $this->db->query("select $select,'' as annual,if(count(d2.month_no)>=$month"
                    . " ,'Paid',$month_no_query) as monthly from student as s"
                    . " left join ( fee_transaction_head as f2 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d2 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f2.id=d2.fee_trans_head_id and d2.fee_cat_id in (2,5) and f2.year=$aca_session)"
                    . " on f2.student_id=s.id and f2.paid_status=1  and f2.response_code=0  $str_query $strfeecat group by s.id having ( monthly!='Paid')")->result();

            if ($offset == '') {
                $str_query2 = "limit $limit";
            } else {
                $str_query2 = "limit $limit offset $offset";
            }
            $query = $this->db->query("select $select,'' as annual,if(count(d2.month_no)>=$month"
                    . " ,'Paid',$month_no_query) as monthly from student as s"
                    . " left join ( fee_transaction_head as f2 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d2 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f2.id=d2.fee_trans_head_id and d2.fee_cat_id in (2,5) and f2.year=$aca_session)"
                    . " on f2.student_id=s.id and f2.paid_status=1 and f2.response_code=0 $str_query $strfeecat group by s.id having (monthly!='Paid') $str_query2");
        }



        $count_filtered = count($query_defaulter);


        $search_columns = array(
            'alpha_num' => array(
                'admission_no',
                'first_name',
            ),
            'numeric' => array(
                'admission_no'
            ),
        );

        $search = $this->input->post('search');
        if (ctype_digit($search['value'])) {
            $search_cols = $search_columns['numeric'];
        } else {
            $search_cols = $search_columns['alpha_num'];
        }
        foreach ($search_cols AS $search_col) {
            $or_like[] = array('col' => $search_col, 'val' => $search['value']);
        }

        $output['draw'] = $this->input->post('draw');
        $output['recordsTotal'] = $count_filtered;
        $output['recordsFiltered'] = $count_filtered;


        $stud_cat_query = $this->db->query("select id from category where status='Y'")->result_array();
        

        $sfees = array();
        foreach ($stud_cat_query as $scq) {
            $fee_query = $this->db->query("select s.id,s.year, Sum(Case When s1.fee_cat in(2,5) Then s1.fee_amount Else 0 End) mon, Sum(Case When s1.fee_cat = 1 Then s1.fee_amount Else 0 End) ann  from class_fee_head s, class_fee_det s1 where s.id=s1.class_fee_head_id  and  s1.status=1 and s1.stud_cat={$scq['id']} group by s.id")->result_array();
            foreach ($fee_query as $fq) {

              $sfees[$scq['id']][$fq['id']]['mon'] = $fq['mon'];
             $sfees[$scq['id']][$fq['id']]['ann'] = $fq['ann'];
            }
        }



        $records_arr = array();
        $e = 1;
        $totsum=0;
//        echo $month_arr[5]; 
        foreach ($query->result() as $row) {


            $recarr = array();
            $recarr[] = $e;
            $recarr[] = $row->admission_no;
            $recarr[] = $row->name;
            $recarr[] = $row->class_name;
            $recarr[] = $row->sec_name;
            $recarr[] = $row->cat_code;
            $recarr[] = $row->phone;
            $recarr[] = $row->annual;


            $clasfeehead = $this->db->query("select id from class_fee_head where from_class_id<=$row->class_id and to_class_id>=$row->class_id and course=$row->course_id and status='Y' and year<=$this->session_start_yr order by id desc limit 1")->result_array();
            

            if ($row->annual == 'Paid' || $row->annual == '') {
                $anns = 0;
            } else {
                $anns = $sfees[$row->stud_category][$clasfeehead[0]['id']]['ann'];
            }

            if ($row->monthly == 'Paid' || $row->monthly == '') {
                $mons = 0;
                $h = '';
            } else {
                
                if($indication=='monthwise'){
                    $mons = $sfees[$row->stud_category][$clasfeehead[0]['id']]['mon'];
                    $h='';
                }else{
                    $schoolgrp=$this->dbconnection->Get_namme("crmfeesclub.school","id",$this->id,"school_group");
                    $this->data['schoolgrp'] = $schoolgrp;
                    if($schoolgrp=='ARMY'){
                         $f = explode(' ', $row->monthly);

                    $mons = $f[0] * $sfees[$row->stud_category][$clasfeehead[0]['id']]['mon']/3;
                    $mn = $month - ($row->monthly - 1);
                    if ($month_arr[$mn] == $month_arr[$month]) {
                        $h = ' months (' . $month_arr[$mn] . ')';
                    } else {
                        $h = ' months (' . $month_arr[$mn] . ' to ' . $month_arr[$month] . ')';
                    }
                    }
                    else{
                        $f = explode(' ', $row->monthly);
                    $mons = $f[0] * $sfees[$row->stud_category][$clasfeehead[0]['id']]['mon'];
                    $mn = $month - ($row->monthly - 1);
                    if ($month_arr[$mn] == $month_arr[$month]) {
                        $h = ' months (' . $month_arr[$mn] . ')';
                    } else {
                        $h = ' months (' . $month_arr[$mn] . ' to ' . $month_arr[$month] . ')';
                    }
                    }
                   
                }
            }
             $sum_fees = $mons + $anns + ($row->transport_amt * $row->monthly);


            $recarr[] = $row->monthly . $h;
            if($this->session->userdata('school_id')!=35){
            $recarr[] = $row->transport_amt * $row->monthly;
            }
            $recarr[] = $sum_fees;
            $records_arr[] = $recarr;
            $e++;
        }

//        $records_arr[]=array('Total','','','','','','','','',$totsum);
                
        $output['data'] = $records_arr;
//        print_r($output['data']);
        echo json_encode($output);
    }

    public function exportdefaulters() {
        
        $aca_session = $this->uri->segment(4);
        $class_id = $this->uri->segment(5);
        $section_id = $this->uri->segment(6);
        $term = $this->uri->segment(7);
        $month = $this->uri->segment(8);
        $indication = $this->uri->segment(9);
        
         /* -------------- */
        if ($month >= 4 && $month <= 12) {
            $month = $month - 3;
        } else {
            $month = $month + 9;
        }
        /* ------------------ */

        if (date('Y-m-d') > $this->academic_session[0]->end_date) {
            $month = 12;
        }

        $select = "s.id,s.admission_no,concat(s.first_name,' ',s.middle_name,' ',s.last_name) as name,s.class_id,s.stud_category,s.course_id,(select class_name from class where id=s.class_id) as class_name,(select sec_name from section where id=s.section_id) as sec_name,(select cat_code from category where id=s.stud_category) as cat_code,s.father_name,s.phone,s.transport_amt";
        if($this->session->userdata('school_id')==35)
        {
            $strfeecat="and s.stud_category!=4";
        }
        else if($this->session->userdata('school_id')==29)
        {
            $strfeecat="and s.stud_category!=3";
        }
        else if($this->session->userdata('school_id')==5)
        {
            $strfeecat="and s.stud_category NOT IN (3,5)";
        }
        else{
            $strfeecat="";
        }
        if ($section_id == 'all' && $class_id == 'all') {
            $str_query = "where s.status='Y'  and s.student_academicyear_id=".$this->academic_session[0]->fin_year;
        } else if ($section_id == 'all' && $class_id != 'all') {
            $str_query = "where s.class_id=$class_id and s.status='Y' and s.student_academicyear_id=".$this->academic_session[0]->fin_year;
        } else {

            $str_query = "where s.class_id=$class_id and s.section_id=$section_id and s.status='Y' and s.student_academicyear_id=".$this->academic_session[0]->fin_year;
        }

        $month_arr = array(1 => 'April', '2' => 'May', '3' => 'June', '4' => 'July', '5' => 'Aug', '6' => 'Sep', '7' => 'Oct', '8' => 'Nov', '9' => 'Dec', '10' => 'Jan', '11' => 'Feb', '12' => 'Mar', '13' => 'Apr', '14' => 'May');
        
        $month_arr_qtr = array(3 => 'April', '3' => 'May', '3' => 'June', '6' => 'July', '6' => 'Aug', '6' => 'Sep', '9' => 'Oct', '9' => 'Nov', '9' => 'Dec', '12' => 'Jan', '12' => 'Feb', '12' => 'Mar', '13' => 'Apr', '14' => 'May');

        $head = (date('Y-m-d') > $this->academic_session[0]->end_date) ? 'Till March' : 'Including Current Month-' . date('M');

        if($indication=='monthwise'){
            $month_no_query="'$month_arr[$month]'";
            
            $display_columns = array(
                'admission_no' => 'Admission No', 'name' => "Student\'s Name",
                'class' => 'Class', 'sec_name' => 'Section','cat_code' => 'Fee Category',
               'phone'=>'Phone No.','annual' => 'Annual',
                'monthly' => "Unpaid Month",'transport' => 'Transport' ,'amount' => 'Total Unpaid Amount',
            );
            
        }else{


            $month_no_query="cast($month-count(d2.month_no) as char)";
            if($this->session->userdata('school_id')!=35){
            $display_columns = array(
                'admission_no' => 'Admission No', 'name' => 'Student&apos;s Name',
                'class' => 'Class', 'sec_name' => 'Section','cat_code' => 'Fee Category',
                'phone'=>'Phone No.','annual' => 'Annual',
                'monthly' => "Monthly ($head)",'transport' => 'Transport', 'amount' => 'Total Unpaid Amount',
            );
        } else{
        	 $display_columns = array(
                'admission_no' => 'Admission No', 'name' => 'Student&apos;s Name',
                'class' => 'Class', 'sec_name' => 'Section','cat_code' => 'Fee Category',
                'phone'=>'Phone No.','annual' => 'Annual',
                'monthly' => "Monthly ($head)", 'amount' => 'Total Unpaid Amount',
            );
        }


        }
        
        if ($term == 'all') {// Both Term
            $query_defaulter = $this->db->query("select $select,if(count(f1.id)=0,'Unpaid','Paid') as annual,if(count(d2.month_no)>=$month"
                    . " ,'Paid',$month_no_query) as monthly from student as s"
                    . " left join ( fee_transaction_head as f1 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d1 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f1.id=d1.fee_trans_head_id and d1.fee_cat_id=1 and f1.year={$this->academic_session[0]->fin_year})"
                    . " on f1.student_id=s.id and f1.paid_status=1 "
                    . " left join ( fee_transaction_head as f2 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d2 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f2.id=d2.fee_trans_head_id and d2.fee_cat_id in (2,5) and f2.year={$this->academic_session[0]->fin_year})"
                    . " on f2.student_id=s.id and f2.paid_status=1 and f2.response_code=0  $str_query $strfeecat  group by s.id having ( annual!='Paid' or monthly!='Paid')");
        } else if ($term == '1') { //For Annual
            $query_defaulter = $this->db->query("select $select,if(count(f1.id)=0,'Unpaid','Paid') as annual,"
                    . " '' as monthly from student as s"
                    . " left join ( fee_transaction_head as f1 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d1 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f1.id=d1.fee_trans_head_id and d1.fee_cat_id=1 and f1.year={$this->academic_session[0]->fin_year})"
                    . " on f1.student_id=s.id and f1.paid_status=1 "
                    . " $str_query $strfeecat group by s.id having ( annual!='Paid')");
        } else { // For Monthly
            $query_defaulter = $this->db->query("select $select,'' as annual,if(count(d2.month_no)>=$month"
                    . " ,'Paid',$month_no_query) as monthly from student as s"
                    . " left join ( fee_transaction_head as f2 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d2 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f2.id=d2.fee_trans_head_id and d2.fee_cat_id in (2,5) and f2.year={$this->academic_session[0]->fin_year})"
                    . " on f2.student_id=s.id and f2.paid_status=1 and f2.response_code=0  $str_query $strfeecat group by s.id having ( monthly!='Paid')");
        }

        $school_code=$this->session->userdata('school_code');
        $filename = "$school_code-Defaulters-Export-" . date('Ymd') . ".csv";

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename=' . $filename);
       
        
        $colnames = array();
        foreach ($display_columns as $field => $disp) {
            $colnames[] = $disp;
        }

        $out = fopen('php://output', 'w');
        fputcsv($out, $colnames);

        $stud_cat_query = $this->db->query("select id from category where status='Y'")->result_array();


        $sfees = array();
        foreach ($stud_cat_query as $scq) {
            $fee_query = $this->db->query("select s.id, Sum(Case When s1.fee_cat in (2,5) Then s1.fee_amount Else 0 End) mon, Sum(Case When s1.fee_cat = 1 Then s1.fee_amount Else 0 End) ann  from class_fee_head s, class_fee_det s1 where s.id=s1.class_fee_head_id  and  s1.status=1 and s1.stud_cat={$scq['id']} group by s.id")->result_array();

            foreach ($fee_query as $fq) {
                $sfees[$scq['id']][$fq['id']]['mon'] = $fq['mon'];
                $sfees[$scq['id']][$fq['id']]['ann'] = $fq['ann'];
            }
        }
        $records_arr = array();
        $totsum=0;
        foreach ($query_defaulter->result() as $row) {


            $recarr = array();
            $recarr[] = $row->admission_no;
            $recarr[] = $row->name;
            $recarr[] = $row->class_name;
            $recarr[] = $row->sec_name;
            $recarr[] = $row->cat_code;
//            $recarr[] = $row->father_name;
            $recarr[] = $row->phone;
            $recarr[] = $row->annual;

            $clasfeehead = $this->db->query("select id from class_fee_head where from_class_id<=$row->class_id and to_class_id>=$row->class_id and course=$row->course_id and status='Y' and year<=$this->session_start_yr order by id desc limit 1")->result_array();;


            if ($row->annual == 'Paid' || $row->annual == '') {
                $anns = 0;
            } else {
                $anns = $sfees[$row->stud_category][$clasfeehead[0]['id']]['ann'];
            }

            if ($row->monthly == 'Paid' || $row->monthly == '') {
                $mons = 0;
                $h = '';
            } else {
                
                if($indication=='monthwise'){
                    $mons = $sfees[$row->stud_category][$clasfeehead[0]['id']]['mon'];
                    $h='';
                }else{
                    $schoolgrp=$this->dbconnection->Get_namme("crmfeesclub.school","id",$this->id,"school_group");
                    $this->data['schoolgrp'] = $schoolgrp;
                    if($schoolgrp=='ARMY'){
                         $f = explode(' ', $row->monthly);
                    $mons = $f[0] * $sfees[$row->stud_category][$clasfeehead[0]['id']]['mon']/3;
                    //$mons = $f[0] * $sfees[$row->stud_category][$clasfeehead[0]['id']]['mon'];
                    $mn = $month - ($row->monthly - 1);
                    if ($month_arr[$mn] == $month_arr[$month]) {
                        $h = ' months Unpaid-(' . $month_arr[$mn] . ')';
                    } else {
                        $h = ' months Unpaid-(' . $month_arr[$mn] . ' to ' . $month_arr[$month] . ')';
                    }
                    }
                    else{
                        $f = explode(' ', $row->monthly);
                    $mons = $f[0] * $sfees[$row->stud_category][$clasfeehead[0]['id']]['mon'];
                    $mn = $month - ($row->monthly - 1);
                    if ($month_arr[$mn] == $month_arr[$month]) {
                        $h = ' months Unpaid-(' . $month_arr[$mn] . ')';
                    } else {
                        $h = ' months Unpaid-(' . $month_arr[$mn] . ' to ' . $month_arr[$month] . ')';
                    }
                    }
                   
                }
            }
            $sum_fees = $mons + $anns + ($row->transport_amt * $row->monthly);
            $recarr[] = $row->monthly . $h;
            if($this->session->userdata('school_id')!=35){
            $recarr[] = $row->transport_amt * $row->monthly;
        }
            $recarr[] = $sum_fees;
            $totsum+=$sum_fees;
            fputcsv($out, $recarr);
        }
        $recarr=array('Total','','','','','','','','','',$totsum);
        fputcsv($out, $recarr);
        fclose($out);
    }

    public function student_fee_status() {
        
        $this->data['page_title'] = 'Student Fee Status';
        $this->data['section'] = 'feepayment/report';
        $this->data['page_name'] = 'fees_status';
        $this->data['customview'] = '';
        $this->data['school_date_created'] =$this->school_date_created;
        $this->data['aclass'] = $this->dbconnection->select("class", "id,class_name", "status='Y'");
        $this->data['asection'] = $this->dbconnection->select("section", "id,sec_name", "status='Y'");
        $this->data['asession'] = $this->dbconnection->select("accedemic_session", "*", "status='Y'","id","DESC");
        $this->load->view('index', $this->data);
    }

    public function load_fees_status() {

        error_reporting(-1);
        ini_set('display_errors', 1);
        $this->db->db_debug=TRUE;
        $a_ses_id = $this->input->post('a_ses_id');
        $class_id = $this->input->post('class_id');
        $section_id = $this->input->post('section_id');

        $select = "s.*,concat(s.first_name,' ',s.middle_name,' ',s.last_name) as name,(select class_name from class where id=s.class_id) as class_name,(select sec_name from section where id=s.section_id) as sec_name,(select cat_code from category where id=s.stud_category) as cat_code,start_fee_month";

        if ($section_id == 'all' && $class_id == 'all') {
            $str_query = "where s.status='Y'  ";
        } else if ($section_id == 'all' && $class_id != 'all') {
            $str_query = "where s.class_id=$class_id and s.status='Y'  ";
        } else {

            $str_query = "where s.class_id=$class_id and s.section_id=$section_id and s.status='Y'  ";
        }


        $month_arr = array('1' => 'April', '2' => 'May', '3' => 'June', '4' => 'July', '5' => 'Aug', '6' => 'Sep', '7' => 'Oct', '8' => 'Nov', '9' => 'Dec', '10' => 'Jan', '11' => 'Feb', '12' => 'Mar');

        $feemaster=$this->dbconnection->select("fee_master","id","status=1 and fee_cat_id=1");
        
//        if($this->session->userdata('school_id')==5){
        if(empty($feemaster)){
            $query_defaulter = $this->db->query("select $select,'' as annual,count(d2.month_no)"
                . " as monthly from student as s"
                . " left join ( fee_transaction_head as f2 inner join fee_transaction_det d2 on f2.id=d2.fee_trans_head_id and d2.fee_cat_id in (2,5))"
                . " on f2.student_id=s.id and f2.paid_status=1 and f2.status=1 and f2.response_code=0 and f2.year=$a_ses_id $str_query  group by s.id ");

        }else{
            $query_defaulter = $this->db->query("select $select,if(count(f1.id)=0,'Unpaid','Paid') as annual,count(d2.month_no)"
                . " as monthly from student as s"
                . " left join ( fee_transaction_head as f1 inner join fee_transaction_det d1 on f1.id=d1.fee_trans_head_id and d1.fee_cat_id=1)"
                . " on f1.student_id=s.id and f1.paid_status=1 and f1.status=1 "
                . " left join ( fee_transaction_head as f2 inner join fee_transaction_det d2 on f2.id=d2.fee_trans_head_id and d2.fee_cat_id in (2,5))"
                . " on f2.student_id=s.id and f2.paid_status=1 and f2.status=1 and f2.response_code=0 $str_query and f1.year=$a_ses_id and f2.year=$a_ses_id group by s.id ");

            
        }
        $i = 0;
        foreach ($query_defaulter->result() as $row) {

            $this->data['student_id'][$i] = $row->id;
            $this->data['start_fee_month'][$i] = $row->start_fee_month;

            $this->data['admsn_no'][$i] = $row->admission_no;
            $this->data['name'][$i] = $row->name;
            $this->data['class_id'][$i] = $row->class_name;
            $this->data['section_id'][$i] = $row->sec_name;
            $this->data['studcat_id'][$i] = $row->cat_code;
            $this->data['annual'][$i] = $row->annual;
            $this->data['month'][$i] = $row->monthly;

            $i++;
        }
        $this->data['cnt'] = $i;
        $this->data['month_arr'] = $month_arr;
        $schoolgrp=$this->dbconnection->Get_namme("crmfeesclub.school","id",$this->id,"school_group");
        $this->data['schoolgrp'] = $schoolgrp;

        $this->load->view('feepayment/report/load_fees_status', $this->data);
    }

    public function fee_projection() {

  if($this->schoolgrp=='ARMY')
        {

        $this->data['page_title'] = 'Fee Projection';
        $this->data['section'] = 'feepayment/report';
        // $this->data['page_name'] = 'fee_projection';
        $this->data['page_name'] = 'fee_projection_army';
        $this->data['customview'] = '';
        $this->data['school_date_created'] =$this->school_date_created;

        $this->data['aclass'] = $this->dbconnection->select("class", "id,class_name", "status='Y'");
        $this->data['asection'] = $this->dbconnection->select("section", "id,sec_name", "status='Y'");
        $schoolgrp=$this->dbconnection->Get_namme("crmfeesclub.school","id",$this->id,"school_group");
        $this->data['school_group'] =  $schoolgrp;
        $this->load->view('index', $this->data);


        }
        else
        {
        $this->data['page_title'] = 'Fee Projection';
        $this->data['section'] = 'feepayment/report';
        $this->data['page_name'] = 'fee_projection';
        $this->data['customview'] = '';
        $this->data['school_date_created'] =$this->school_date_created;

        $this->data['aclass'] = $this->dbconnection->select("class", "id,class_name", "status='Y'");
        $this->data['asection'] = $this->dbconnection->select("section", "id,sec_name", "status='Y'");
        $schoolgrp=$this->dbconnection->Get_namme("crmfeesclub.school","id",$this->id,"school_group");
        $this->data['school_group'] =  $schoolgrp;
         $this->load->view('index', $this->data);
        }
       
    }

    public function fee_projection_report() {
        
        $month = $this->input->post('month');
        $mnth_name = date('F', strtotime("{$this->session_start_yr}-" . $month . "-01"));
        
        if ($month >= 4 && $month <= 12) {
            $month1 = $month - 3;
            $yearmn = $this->session_start_yr;
        } else if ($month >= 1 && $month <= 3) {
            $month1 = $month + 9;
            $yearmn = $this->session_end_yr;
        }

        $class = array();
        $section = array();
        $strength = array();
        $estimated = array();
        $collected = array();
        $class_qry = $this->dbconnection->select("class", "id, class_name", "status='Y'");
        $category_qry = $this->dbconnection->select("category", "*", "status='Y'");
        $acourse = $this->dbconnection->select("course", "*", "status='Y'");
        $i = 0;
        $j = 0;
        $sum_estimated = 0;
        $cntj = array();
        foreach ($class_qry as $cls) {
            $section_qry = $this->dbconnection->select("student", "distinct(section_id) as sec_id , (select sec_name from section where id = sec_id) as section_name", "class_id=$cls->id");
            foreach ($section_qry as $sec) {
                $s1 = 0;
                $class[$i][$j] = $cls->class_name;
                $section[$i][$j] = $sec->section_name;
                $sum_stregth = 0;
                $sum_estimated = 0;
                foreach ($category_qry as $cat) {
                    $strength_qry = $this->dbconnection->select("student", "count(id) as count_stud", "class_id=$cls->id and section_id=$sec->sec_id and stud_category=$cat->id and status='Y'");

                    $sum_stregth = $sum_stregth + $strength_qry[0]->count_stud;
                    $max_year_classfee = $this->dbconnection->select('class_fee_head', 'max(year) as max_year', "(from_class_id<=$cls->id and to_class_id>=$cls->id) and status='Y' and year<=$this->session_start_yr");
                    $estimated_qry = $this->dbconnection->select("class_fee_head", "id,course", "from_class_id<=$cls->id and to_class_id>=$cls->id and status='Y' and year={$max_year_classfee[0]->max_year}");
                    if (count($estimated_qry) > 1) {
                        foreach ($estimated_qry as $crse) {

                            $strength_qry_coursewise = $this->dbconnection->select("student", "count(id) as count_course_stud", "class_id=$cls->id and section_id=$sec->sec_id and stud_category=$cat->id and course_id=$crse->course and status='Y'");
                            $fetch_class_fee = $this->dbconnection->select("class_fee_det", "sum(fee_amount) total_fee", "class_fee_head_id=" . $crse->id . " and stud_cat=$cat->id and fee_cat in (2,5) and status=1");
                            $amount_estimated = $fetch_class_fee[0]->total_fee;
                            $sum_estimated = $sum_estimated + ($amount_estimated * $strength_qry_coursewise[0]->count_course_stud);
                        }
                    } else {
                        $fetch_class_fee = $this->dbconnection->select("class_fee_det", "sum(fee_amount) total_fee1", "class_fee_head_id=" . $estimated_qry[0]->id . " and stud_cat=$cat->id and fee_cat in (2,5) and status=1");
                        $amount_estimated = $fetch_class_fee[0]->total_fee1;
                        $sum_estimated = $sum_estimated + ($amount_estimated * $strength_qry[0]->count_stud);
                    }
                }
                $strength[$i][$j] = $sum_stregth;
                $estimated[$i][$j] = $sum_estimated . ' INR';
                $stud = $this->dbconnection->select("(select id from fee_transaction_head where student_id in (select id from student where class_id=$cls->id and section_id=$sec->sec_id) and year={$this->academic_session[0]->fin_year} and Year(payment_date)=$yearmn) a", "*", "");
                foreach ($stud as $row) {
                    // print_r($stud);
                    // die();
                    $collected_qry = array();
                    $collected_qry = $this->dbconnection->select("fee_transaction_det", "sum(amount) as monthly, count(month_no) as mon", "fee_trans_head_id=$row->id and fee_cat_id in (2,5)");
                  
                     $collect = $collected_qry[0]->monthly;
                     $mnth_no = $collected_qry[0]->mon;
                     if ($this->schoolgrp =="ARMY")
                     {
                        if ($mnth_no != '' && $mnth_no = $month1) {
                            $s = $collect / $mnth_no;
                        }
                        else if ($mnth_no != '' && $mnth_no <= $month1) {
                            $s = $collect;
                        }
                         else {
                            $s = 0;
                        }
                         $s1 = $s1 + $s;
                     }
                     else
                     {
                        if ($mnth_no != '' && $mnth_no >= $month1) 
                        {
                            $s = $collect / $mnth_no;
                        } else
                        {
                            $s = 0;
                        }
                        $s1 = $s1 + $s;
                     }
                    
                }
                $collected[$i][$j] = $s1;
                $balance[$i][$j] = $estimated[$i][$j] - $collected[$i][$j] . ' INR';
                $j++;
            }
            $cntj[$i] = $j;
            $j = 0;
            $i++;
        }

            
        $data = array(
            'cnti' => $i,
            'cntj' => $cntj,
            'class' => $class,
            'section' => $section,
            'strength' => $strength,
            'estimated' => $estimated,
            'collected' => $collected,
            'balance' => $balance,
            'mnth' => $mnth_name,
        );

        $this->load->view('feepayment/report/load_fee_projection', $data);
    }

    public function fee_summary() {
        $schoolgrp=$this->dbconnection->Get_namme("crmfeesclub.school","id",$this->id,"school_group");
        $this->data['schoolgrp'] = $schoolgrp;
        if($schoolgrp=='ARMY')
        {
            $this->data['page_title'] = 'Fee Summary';
            $this->data['section'] = 'feepayment/report';
            $this->data['page_name'] = 'fee_summary_army';
            $this->data['customview'] = '';
            $this->data['school_date_created'] =$this->school_date_created;
            $this->data['collection_center'] = $this->dbconnection->select("collection_center", "id,collection_code,collection_desc", "status='Y'");
            $fee_type = $this->dbconnection->select_returnarray("fee_master", "id,fee_name,fee_cat_id", "status=1");
            $this->data['fee_ty']=array_column($fee_type, 'fee_name', 'id');

            $this->load->view('index', $this->data);
        }
    else{
            $this->data['page_title'] = 'Fee Summary';
            $this->data['section'] = 'feepayment/report';
            $this->data['page_name'] = 'fee_summary';
            $this->data['customview'] = '';
            $this->data['school_date_created'] =$this->school_date_created;
            $this->data['session'] =$this->dbconnection->select("accedemic_session", "*", "status='Y'","id","DESC");
            $this->data['collection_center'] = $this->dbconnection->select("collection_center", "id,collection_code,collection_desc", "status='Y'");
            $fee_type = $this->dbconnection->select_returnarray("fee_master", "id,fee_name,fee_cat_id", "status=1");
            $this->data['fee_ty']=array_column($fee_type, 'fee_name', 'id');

            $this->load->view('index', $this->data);
    }
    }

    public function daily_wise_fee_summary() {

        $aca_session_daily = $this->input->post('aca_session_daily');
        $date = date('Y-m-d', strtotime($this->input->post('date')));
        $this->data['fee_details'] = $this->find_fee($date);
        $this->data['dateee'] = $date;
        $this->data['trans_status'] = $this->dbconnection->Get_namme("crmfeesclub.school", "id", $this->session->userdata('school_id'), "transport_fee");
        if($this->session->userdata('school_id')==35)
        {
            $this->load->view('feepayment/report/load_daily_wise_fee_summ_hzb', $this->data);
        }
        else
        {
            $this->load->view('feepayment/report/load_daily_wise_fee_summ', $this->data);
        }
        
    }

    public function find_fee($date) {
        $admission = array();
        $studclass = array();
        $studcategory = array();
        $studname = array();
        $amount = array();
        $aca_session_daily = $this->input->post('aca_session_daily');
        if ($this->session->userdata('school_id') != 9) {
            $strquery3 = "";
        } else {
            $strquery3 = " and ( mode!='NB' or (mode='NB' and payment_date<'2017-04-24 00:00:00'))";
        }

        if ($this->input->post('colcenter') == 'all') {
            $str_query1 = '';
        } else {
            $str_query1 = " and collection_centre= '{$this->input->post('colcenter')}'";
        }
        $fetch_transaction_date = $this->dbconnection->select("fee_transaction_head", "distinct(student_id) as stud", "payment_date Like '%$date%' and year=$aca_session_daily and paid_status=1 and response_code=0 $str_query1 $strquery3 ");
        $fee_details['stud_cnt'] = count($fetch_transaction_date);
        $i = 0;
        $fee_type = $this->dbconnection->select("fee_master", "id,fee_name,fee_cat_id", "status=1");
        $fee_details['fee_ty'] = $fee_type;
        $k = 0;

        $fee_details['paymodeqry']=$this->dbconnection->select("crmfeesclub.mode","id,mode_name");
        foreach ($fee_details['paymodeqry'] as $p) { $tot_mode[$p->id]=0;}
        $fee_details['tot_mode']=$tot_mode;
        foreach ($fee_type as $row) {
            $fee_details['f_name'][$row->id] = $row->fee_name;
        }

        foreach ($fetch_transaction_date as $q) {
            $j = 0;
//            $fee_head_id = $this->dbconnection->select("fee_transaction_head", "id", "student_id=$q->stud and paid_status=1 and response_code=0 and payment_date Like '%$date%'");
            $stud = $this->dbconnection->select("student", "id,admission_no,stud_category,(select cat_name from category where id=stud_category) as stud_cat_name,concat(first_name,' ', middle_name,' ',last_name) as name,class_id,(select class_name from class where id=class_id) as class_name, (select sec_name from section where id=section_id) as sec_name,course_id,transport_amt", "id=$q->stud");
            $fee_details['admission'][$i] = $stud[0]->admission_no;
            $fee_details['studclass'][$i] = $stud[0]->class_name . ' ' . $stud[0]->sec_name;
            $fee_details['studname'][$i] = $stud[0]->name;
            $stud_class = $stud[0]->class_id;
            $stud_course = $stud[0]->course_id;
            $fee_details['stud_cat'][$i] = $stud[0]->stud_cat_name;
            $stud_cat = $stud[0]->stud_category;
            $total = 0;


            foreach ($fee_type as $row) {

                $max_class_year = $this->dbconnection->select('class_fee_head', 'max(year) as max_year, max(id) as max_id', "(from_class_id<=$stud_class and to_class_id>=$stud_class) and course=$stud_course and status='Y' and year<=$this->session_start_yr");
                
                $s=($row->fee_cat_id==3)  ?'':"and stud_cat=$stud_cat";
                $class_fee = $this->dbconnection->select("class_fee_det", "fee_amount,fee_cat", "class_fee_head_id={$max_class_year[0]->max_id} $s and status=1  and fee_id=" . $row->id);
                if ($row->fee_cat_id!=8 && count($class_fee) > 0) {
                    $fee_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,month_no", "fee_trans_head_id in (select id from fee_transaction_head where student_id=$q->stud and paid_status=1 and response_code=0 and payment_date Like '%$date%' $str_query1 $strquery3 ) and fee_cat_id=" . $class_fee[0]->fee_cat);
                    $fee_amt = 0;
                    if (count($fee_qry) > 0) {
                        foreach ($fee_qry as $rfee) {
                            $fee_amt = $fee_amt + $class_fee[0]->fee_amount;
                            $total += $class_fee[0]->fee_amount;
                        }
                        $fee_details['fee_amnt'][$i][$row->id] = $fee_amt;
//                    if (count($fee_qry) > 0) {
//                        $fee_details['fee_amnt'][$i][$row->id] = count($fee_qry)*$class_fee[0]->fee_amount;
//                        $total += count($fee_qry)*$class_fee[0]->fee_amount;
                    } else {
                        $fee_details['fee_amnt'][$i][$row->id] = 0;
                        $total += 0;
                    }
                }else if($row->fee_cat_id==8){
                    $fee_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,amount,other_fee_id", "fee_trans_head_id in (select id from fee_transaction_head where student_id=$q->stud and paid_status=1 and response_code=0 and payment_date Like '%$date%' $str_query1 $strquery3 ) and fee_cat_id=8");
                    $fee_amt=0;
                    if (count($fee_qry) > 0) {
                        foreach ($fee_qry as $rfee) {
                            $fee_amt = $fee_amt + $rfee->amount;
                            $total += $rfee->amount;
                        }
                        $fee_details['fee_amnt'][$i][$row->id] = $fee_amt;
                    }else {
                        $fee_details['fee_amnt'][$i][$row->id] = 0;
                        $total += 0;
                    }
                    
                } else {
                    $fee_details['fee_amnt'][$i][$row->id] = 0;
                    $total += 0;
                }
            }


//transport
//            if (!empty($stud[0]->transport_amt)) {
                $trns_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,amount", "fee_trans_head_id in (select id from fee_transaction_head where student_id=$q->stud and paid_status=1 and response_code=0 and payment_date Like '%$date%' $str_query1 $strquery3 ) and fee_cat_id=6");
                $trans_amt = 0;
                if (count($trns_qry) > 0) {
                    foreach ($trns_qry as $rt) {
                        $trans_amt = $trans_amt + $rt->amount;
                        $total += $rt->amount;
                    }
                    $fee_details['transport_amt'][$i] = $trans_amt;
                } else {
                    $fee_details['transport_amt'][$i] = 0;
                    $total += 0;
                }
//            } else {
//                $fee_details['transport_amt'][$i] = 0;
//                $total += 0;
//            }

//fine

            $fine_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,month_no,amount", "fee_trans_head_id in (select id from fee_transaction_head where student_id=$q->stud and paid_status=1 and response_code=0 and payment_date Like '%$date%' $str_query1 $strquery3 ) and fee_cat_id=0");
            $fine_amt = 0;
            if (count($fine_qry) > 0) {
                foreach ($fine_qry as $rfine) {
                    $fine_amt = $fine_amt + $rfine->amount;
                    $total += $rfine->amount;
                }
                $fee_details['fine'][$i] = $fine_amt;
            } else {
                $fee_details['fine'][$i] = 0;
                $total += 0;
            }
            $readmsnfine_qry = $this->dbconnection->select("fee_transaction_det", "amount", "fee_trans_head_id in (select id from fee_transaction_head where student_id=$q->stud and paid_status=1 and response_code=0 and payment_date Like '%$date%' $str_query1 $strquery3 ) and fee_cat_id=11");
            $fee_details['readmsnfine'][$i]=!empty($readmsnfine_qry)?$readmsnfine_qry[0]->amount:0;
            $total += $fee_details['readmsnfine'][$i];
            
            $qry = $this->dbconnection->select("fee_transaction_head", "id,sum(discount_amount) discount_amount,group_concat(receipt_no) receipt_no", "student_id=$q->stud and paid_status=1 and response_code=0 and payment_date Like '%$date%' $str_query1 $strquery3 ","","student_id");
            
            $total -= $qry[0]->discount_amount;
            $fee_details['instant_discount'][$i] = $qry[0]->discount_amount;
            $fee_details['receipt_no'][$i] = $qry[0]->receipt_no;
            $fee_details['total1'][$i] = $total;
            $i++;
        }
        return $fee_details;
    }

    public function monthly_wise_fee_summary() {
        $aca_session_mon = $this->input->post('aca_session_mon');
         $get_ses_det= $this->dbconnection->select("accedemic_session", "start_date,end_date,session", "status='Y' and id=".$aca_session_mon);
        $fetch_startyr = isset($get_ses_det[0]->start_date) ? explode('-', $get_ses_det[0]->start_date) : array('0');
        $session_start_yr = reset($fetch_startyr);
        $month = $this->input->post('month');
        if ($month >= 1 && $month <= 9) {
            $month = $month + 3;
            $year = $session_start_yr;
            // $year = $this->session_start_yr;
        } else {
            $month = $month - 9;
            $year = $session_start_yr;
            // $year = $this->session_end_yr;
        }


        
//        if ($month >= 4 && $month <= 12) {
//            $month = $month - 3;
//        } else if ($month >= 1 && $month <= 3) {
//            $month = $month + 9;
//        }
        $this->data1['monthly_fee'] = $this->find_mnth_fee($month, $year);
        $this->data1['trans_status'] = $this->dbconnection->Get_namme("crmfeesclub.school", "id", $this->session->userdata('school_id'), "transport_fee");
        $this->load->view('feepayment/report/load_monthly_wise_fee_summ', $this->data1);
    }

    public function find_mnth_fee($month, $yearmn) {
        $admission = array();
        $studclass = array();
        $studcategory = array();
        $studname = array();
        $amount = array();
        $aca_session_mon = $this->input->post('aca_session_mon');
        if ($this->session->userdata('school_id') != 9) {
            $strquery3 = "";
        } else {
            $strquery3 = " and ( mode!='NB' or (mode='NB' and payment_date<'2017-04-24 00:00:00'))";
        }

        if ($this->input->post('colcenter') == 'all') {
            $str_query1 = '';
        } else {
            $str_query1 = " and collection_centre= '{$this->input->post('colcenter')}'";
        }

//        $fetch_transaction_mnth = $this->dbconnection->select("fee_transaction_head", "distinct(student_id) as stud", "MONTH(payment_date)='$month' and year={$this->academic_session[0]->fin_year} and paid_status=1 and response_code=0 $str_query1 $strquery3");
        $fetch_transaction_mnth = $this->dbconnection->select("fee_transaction_head", "distinct(student_id) as stud", "MONTH(payment_date)='$month' and Year(payment_date)=$yearmn and year=$aca_session_mon and paid_status=1 and response_code=0 $str_query1 $strquery3");
        $monthly_fee['stud_cnt'] = count($fetch_transaction_mnth);
        $i = 0;
        $fee_type = $this->dbconnection->select("fee_master", "id,fee_name,fee_cat_id", "status=1");
        $monthly_fee['fee_ty'] = $fee_type;
        $k = 0;
        foreach ($fee_type as $row) {
            $monthly_fee['f_name'][$row->id] = $row->fee_name;
        }

        foreach ($fetch_transaction_mnth as $q) {
            $j = 0;
//            $fee_head_id1 = $this->dbconnection->select("fee_transaction_head", "id", "student_id=$q->stud and paid_status=1 and response_code=0 and MONTH(payment_date)='$month' and year={$this->academic_session[0]->fin_year} $str_query1 $strquery3 ");
            $fee_head_id1 = $this->dbconnection->select("fee_transaction_head", "id", "student_id=$q->stud and paid_status=1 and response_code=0 and MONTH(payment_date)='$month' and Year(payment_date)=$yearmn and year=$aca_session_mon $str_query1 $strquery3 ");
            $stud = $this->dbconnection->select("student", "id,admission_no,stud_category,(select cat_name from category where id=stud_category) as stud_cat_name,concat(first_name,' ', middle_name,' ',last_name) as name,class_id,(select class_name from class where id=class_id) as class_name, (select sec_name from section where id=section_id) as sec_name,course_id,transport_amt", "id=$q->stud");
            $monthly_fee['admission'][$i] = $stud[0]->admission_no;
            $monthly_fee['studclass'][$i] = $stud[0]->class_name . ' ' . $stud[0]->sec_name;
            $monthly_fee['studname'][$i] = $stud[0]->name;
            $stud_class = $stud[0]->class_id;
            $stud_course = $stud[0]->course_id;
            $monthly_fee['stud_cat'][$i] = $stud[0]->stud_cat_name;
            $stud_cat = $stud[0]->stud_category;
            $total = 0;
            foreach ($fee_type as $row) {
                
                $max_class_year = $this->dbconnection->select('class_fee_head', 'max(year) as max_year, max(id) as max_id', "(from_class_id<=$stud_class and to_class_id>=$stud_class) and course=$stud_course and status='Y' and year<=$this->session_start_yr");
                 $s=($row->fee_cat_id==3)?'':"and stud_cat=$stud_cat";
                $class_fee = $this->dbconnection->select("class_fee_det", "fee_amount,fee_cat", "class_fee_head_id={$max_class_year[0]->max_id} $s and status=1 and fee_id=" . $row->id);
                if ($row->fee_cat_id!=8 && count($class_fee) > 0) {
//                        $fee_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,fee_cat_id", "fee_trans_head_id in (select id from fee_transaction_head where student_id=$q->stud and paid_status=1 and response_code=0 and MONTH(payment_date)='$month' and year={$this->academic_session[0]->fin_year} $str_query1 $strquery3 ) and fee_cat_id=" . $class_fee[0]->fee_cat);
                    $fee_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,fee_cat_id", "fee_trans_head_id in (select id from fee_transaction_head where student_id=$q->stud and paid_status=1 and response_code=0 and MONTH(payment_date)='$month' and Year(payment_date)=$yearmn and year=$aca_session_mon $str_query1 $strquery3 ) and fee_cat_id=" . $class_fee[0]->fee_cat);
                    $fee_amt = 0;
                    if (count($fee_qry) > 0) {
                        foreach ($fee_qry as $rfee) {
                            $fee_amt = $fee_amt + $class_fee[0]->fee_amount;
                            $total += $class_fee[0]->fee_amount;
                        }
                        $monthly_fee['fee_amnt'][$i][$row->id] = $fee_amt;
//                        $monthly_fee['fee_amnt'][$i][$row->id] = $class_fee[0]->fee_amount;
//                        $total += $class_fee[0]->fee_amount;
                    } else {
                        $monthly_fee['fee_amnt'][$i][$row->id] = 0;
                        $total += 0;
                    }
                } else if($row->fee_cat_id==8){
                    $fee_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,amount,other_fee_id", "fee_trans_head_id in (select id from fee_transaction_head where student_id=$q->stud and paid_status=1 and response_code=0 and MONTH(payment_date)='$month' and Year(payment_date)=$yearmn and year=$aca_session_mon $str_query1 $strquery3 ) and fee_cat_id=8");
                    $fee_amt=0;
                    if (count($fee_qry) > 0) {
                        foreach ($fee_qry as $rfee) {
                            $fee_amt = $fee_amt + $rfee->amount;
                            $total += $rfee->amount;
                        }
                        $monthly_fee['fee_amnt'][$i][$row->id] = $fee_amt;
                    }else {
                        $monthly_fee['fee_amnt'][$i][$row->id] = 0;
                        $total += 0;
                    }
                    
                }  else {
                    $monthly_fee['fee_amnt'][$i][$row->id] = 0;
                    $total += 0;
                }
            }

//                echo $stud[0]->transport_amt;
//transport
//            if (!empty($stud[0]->transport_amt)) {
                $trns_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,amount", "fee_trans_head_id in (select id from fee_transaction_head where student_id=$q->stud and paid_status=1 and response_code=0 and MONTH(payment_date)='$month' and Year(payment_date)=$yearmn and year=$aca_session_mon $str_query1 $strquery3 ) and fee_cat_id=6");
                $trans_amt = 0;
                if (count($trns_qry) > 0) {
                    foreach ($trns_qry as $rt) {
                        $trans_amt = $trans_amt + $rt->amount;
                        $total += $rt->amount;
                    }
                    $monthly_fee['transport_amt'][$i] = $trans_amt;
                } else {
                    $monthly_fee['transport_amt'][$i] = 0;
                    $total += 0;
                }
//                        print_r($trns_qry);
//            } else {
//                $monthly_fee['transport_amt'][$i] = 0;
//                $total += 0;
//            }

//                echo $fee_details['transport_amt'][$i];
//fine
//                $fine_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,month_no,amount", "fee_trans_head_id in (select id from fee_transaction_head where student_id=$q->stud and paid_status=1 and response_code=0 and MONTH(payment_date)='$month' and year={$this->academic_session[0]->fin_year} $str_query1 $strquery3 ) and fee_cat_id=0");
            $fine_qry = $this->dbconnection->select("fee_transaction_det", "id,fee_trans_head_id,month_no,amount", "fee_trans_head_id in (select id from fee_transaction_head where student_id=$q->stud and paid_status=1 and response_code=0 and MONTH(payment_date)='$month' and Year(payment_date)=$yearmn and year=$aca_session_mon $str_query1 $strquery3 ) and fee_cat_id=0");
            $fine_amt = 0;
            if (count($fine_qry) > 0) {
                foreach ($fine_qry as $rfine) {
                    $fine_amt = $fine_amt + $rfine->amount;
                    $total += $rfine->amount;
                }
                $monthly_fee['fine'][$i] = $fine_amt;
            } else {
                $monthly_fee['fine'][$i] = 0;
                $total += 0;
            }
            
            $readmsnfine_qry = $this->dbconnection->select("fee_transaction_det", "amount", "fee_trans_head_id in (select id from fee_transaction_head where student_id=$q->stud and paid_status=1 and response_code=0 and MONTH(payment_date)='$month' and Year(payment_date)=$yearmn and year=$aca_session_mon $str_query1 $strquery3 ) and fee_cat_id=11");
            $readmsnfine_amt=!empty($readmsnfine_qry)?$readmsnfine_qry[0]->amount:0;
            $monthly_fee['readmsnfine'][$i] = $readmsnfine_amt;
            $total += $readmsnfine_amt;
            $monthly_fee['total1'][$i] = $total;
            $i++;
        }
        return $monthly_fee;
    }

    public function monthlyfees_wise_fee_summary() {
        $aca_session = $this->input->post('aca_session');
        $fdate = $this->input->post('frmdate');
        $tdate = $this->input->post('todate');
        if ($this->input->post('colcenter') == 'all') {
            $str_query1 = '';
        } else {
            $str_query1 = " and fh.collection_centre= '{$this->input->post('colcenter')}'";
        }

        $str_query = "fh.payment_date>=DATE_FORMAT('$fdate', '%Y-%m-%d 00:00:00') and fh.payment_date<=DATE_FORMAT('$tdate', '%Y-%m-%d 23:59:59')"; 
        
        $fee_details=array();
        $fetch_transaction_date=$this->db->query("SELECT fh.id,group_concat(distinct(fd.fee_cat_id)) fee_cat,fd.class_fee_head_id, fh.payment_method,fh.transaction_id,fh.year,DATE_FORMAT(fh.payment_date, '%d-%m-%Y') payment_date,fh.total_amount,fh.response_message,fh.student_id,fh.pos_no,s.admission_no,concat(s.first_name,' ',s.middle_name,' ',s.last_name) as name,s.class_id,s.section_id,s.stud_category,s.course_id,s.roll,s.transport_amt,s.start_fee_month,GROUP_CONCAT(distinct(fd.month_no) order by fd.month_no) month_details,fh.discount_amount,fh.collection_centre,fh.receipt_no,fh.remarks,fh.mode,fd.stud_category as fee_stud_category FROM `fee_transaction_head` fh inner join student s on fh.student_id=s.id inner join fee_transaction_det fd on fd.fee_trans_head_id=fh.id WHERE $str_query and fh.paid_status=1 and fh.year=$aca_session and  fh.response_code=0 $str_query1
group by fh.id")->result();
//        $fetch_transaction_date = $this->dbconnection->select("fee_transaction_head", "student_id as stud, payment_date", "payment_date>=DATE_FORMAT('$fdate', '%Y-%m-%d 00:00:00') and payment_date<=DATE_FORMAT('$tdate', '%Y-%m-%d 23:59:59') and paid_status=1 and response_code=0 $str_query1 ");
        $fee_details['fetch_transaction_date']=$fetch_transaction_date;
        $fee_type = $this->dbconnection->select_returnarray("fee_master", "id,fee_name,fee_cat_id", "status=1");
        $fee_details['fee_ty']=array_column($fee_type, 'fee_name', 'id');
        $fee_details['fee_cat_id']=array_column($fee_type, 'fee_cat_id', 'id');

        $fee_details['trans_status'] = $this->dbconnection->Get_namme("crmfeesclub.school", "id", $this->session->userdata('school_id'), "transport_fee");
        $fee_details['paymodeqry']=$this->dbconnection->select("crmfeesclub.mode","id,mode_name");
        $fee_details['session_start_yr']=$this->session_start_yr;
        $fee_details['month_arr']= array('0'=>'', '1' => 'APR', '2' => 'MAY', '3' => 'JUN', '4' => 'JUL', '5' => 'AUG', '6' => 'SEP', '7' => 'OCT', '8' => 'NOV', '9' => 'DEC', '10' => 'JAN', '11' => 'FEB', '12' => 'MAR', '13' => 'APR', '14' => 'MAY');
        $tot_mode=array();
        foreach ($fee_details['paymodeqry'] as $p) { $tot_mode[$p->id]=0;}
        $fee_details['tot_mode']=$tot_mode;
        $class = $this->dbconnection->select_returnarray("class", "id,class_name", "status='Y'");
        $section = $this->dbconnection->select_returnarray("section", "id,sec_name", "status='Y'");
        
        $fee_details['class'] = array_column($class, 'class_name', 'id');
        $fee_details['section'] = array_column($section, 'sec_name', 'id');
        $fee_details['rmvcol'] = $this->input->post('rmvcol');
        $fee_details['rmvcol1'] = $this->input->post('rmvcol1');
        $fee_details['schgrp'] = $this->dbconnection->Get_namme("crmfeesclub.school","id",$this->id,"school_group");
        
        $this->load->view('feepayment/report/load_monthlyfee_wise_fee_summ', $fee_details);
    }


}
