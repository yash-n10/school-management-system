<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct() {
		parent::__construct();

		if (empty($this->session->userdata('user_id'))) {
			redirect('/login');
		}
         // error_reporting(-1);
         //       ini_set('display_errors',1);
         //       $this->db->db_debug=TRUE;
        
		$this->total_school = $this->dbconnection->select("school", "count(*) as cnt", "status=1");
		$this->school1 = $this->dbconnection->select('school', '*', 'id = ' . $this->session->userdata('school_id'));

		$this->id = $this->session->userdata('school_id');
		$this->academic_session=array();
        
		if ($this->id != 0) {
			$this->db->db_select('crmfeesclub_' . $this->id);
			$this->user = $this->dbconnection->select('user', '*', 'id = ' . $this->session->userdata('user_id'));
			$user_id = $this->session->userdata('user_id');
            
			$this->user = $this->dbconnection->select('user', '*', 'id = ' . $user_id);
			$this->stud_id = $this->user[0]->student_id;
			$this->employee_id = $this->user[0]->employee_id;
				
			$this->total_user = $this->dbconnection->select("user", "count(*) as users");
			$this->academic_session=$this->dbconnection->select("accedemic_session","id as fin_year,start_date,end_date","status='Y' and active='Y'","id","DESC","1");
			$fetch_startyr = isset($this->academic_session[0]->start_date) ? explode('-', $this->academic_session[0]->start_date) : array('0');
			$this->session_start_yr = reset($fetch_startyr);
			$fetch_endyr = isset($this->academic_session[0]->end_date) ? explode('-', $this->academic_session[0]->end_date) : array('0');
			$this->session_end_yr = reset($fetch_endyr);
		            
		} else {
			$this->user = $this->dbconnection->select('user', '*', 'id = ' . $this->session->userdata('user_id'));
			$this->total_user = $this->dbconnection->select("user", "count(*) as users");
		}

		$this->pre_academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year", "status='Y' and active!='Y'","id","DESC","1");
		$this->previousSessionID=$this->pre_academic_session[0]->fin_year;
		$this->p_academic_session=$this->dbconnection->select("accedemic_session", "*", "id=".$this->previousSessionID);
		$pyear=$this->p_academic_session[0]->start_date;
		$this->psession=$this->p_academic_session[0]->session;

		$this->page_title = '';
		$this->section = '';
		$this->page_name = '';
		$this->customview = '';
       }

	public function index() {
        	$login_tp = $this->session->userdata('login_type');
//            echo strtoupper($login_tp);die();

		if ($login_tp == 'appadmin') {
			$this->page_title 	= 'Welcome Software Admin';
			$this->section 	= 'dashboard';
			$this->page_name	= 'index';
			$this->customview	= '';

			$school_query = $this->dbconnection->select("school", "*", "status=1");

			$count = 0;
			$count_reg = 0;
			foreach ($school_query as $obj_sch) {
				$this->db->db_select('crmfeesclub_' . $obj_sch->id);
				$student_query = $this->dbconnection->select("student", "COUNT(IF(registered_status='1',1, NULL)) 'registered', count(id) tot", "status='Y'");
//                			$student_registered_query = $this->dbconnection->select("student", "*", "status='Y' and registered_status=1");
				$count = $count + $student_query[0]->tot;
				$count_reg = $count_reg + $student_query[0]->registered;
			}
			$this->db->db_select('crmfeesclub');

			$this->data[$login_tp . '_message'] = 0;
			$total_school = $this->total_school;
			$this->data['total_school'] = $total_school[0]->cnt;
			$this->data['total_students'] = $count;
			$this->data['total_registered'] = $count_reg;

			$total_users = $this->total_user;
			$this->data['total_users'] = $total_users[0]->users;
          	} 
		elseif ((strtoupper($login_tp) == 'BOOKSTORE') OR (strtoupper($login_tp) == 'CLOTHSTORE')) {
			$fun_name='multistores_dashboard';
            
			if (method_exists($this, $fun_name)) {

				$this->$fun_name();
			} else {
				$this->admin_dashboard();
			} 
		}
		elseif (($login_tp == 'approver1') OR ($login_tp == 'approver2') OR ($login_tp == 'approver3')) {
			$fun_name='multiapprovers_dashboard';
            
			if (method_exists($this, $fun_name)) {

				$this->$fun_name();
			} else {
				$this->admin_dashboard();
			} 
		}
		elseif ($login_tp == 'student') {
			$fun_name='multistudents_dashboard';
            
			if (method_exists($this, $fun_name)) {

				$this->$fun_name();
			} else {
				$this->admin_dashboard();
			} 
		}
		else {
			$fun_name=$login_tp.'_dashboard';
            
			if (method_exists($this, $fun_name)) {
				$this->$fun_name();
			} else {
				$this->admin_dashboard();
			} 
				//calling usergroup dashboard function;
		}

		$this->data['page_name'] = $this->page_name;
		$this->data['page_title'] = $this->page_title;
		$this->data['section'] = $this->section;
		$this->data['customview'] = $this->customview;

		$this->load->view('index', $this->data);
	}

    
	public function admin_dashboard_olds() {
		$count = 0;
		$count_reg = 0;

//            $user_nam = $this->dbconnection->select("user", "user_name", "id=" . $this->session->userdata('user_id'));
//            $nm = $user_nam[0]->user_name;
				
		$name = explode("-", $this->session->userdata('user_name'));
		$usr_nm = $name[1];
            
		$this->data[$this->session->userdata('login_type') . '_message'] = 0;
		$this->data['school1'] = $this->school1;
		$this->data['school_name'] = $this->data['school1'][0]->description;
		$this->data['school_address'] = $this->data['school1'][0]->address;

		$this->data['tot_stud'] = $this->dbconnection->select("student", "count(if(status='Y',1,NULL)) as students,COUNT(IF(registered_status='1' and status='Y',1, NULL)) 'registered',COUNT(IF(registered_status='1' and status='P',1, NULL)) 'pending'", " status='Y' or status='P'");
		$this->data['total_students'] = $this->data['tot_stud'][0]->students;

//            $this->data['tot_stud_reg'] = $this->dbconnection->select("student", "count(admission_no) as students_reg", "status='Y' and registered_status=1");
		$this->data['total_registered'] = $this->data['tot_stud'][0]->registered;

//            $this->data['tot_stud_pending'] = $this->dbconnection->select("student", "count(admission_no) as students_pending", "status='P' and registered_status=1");
		$this->data['total_pending'] = $this->data['tot_stud'][0]->pending;

		$date = date("Y-m");
		$month_year=explode('-',$date);
		$month=$month_year[1];

		$school=array();            
//            $school['online']=array();
//            $school['offline']=array();
//            $school['total']=array();
//            $school['online_cnt']=array();
//            $school['offline_cnt']=array();
//            $school['success_payment_cnt']=array();
//            $school['failure_payment_cnt']=array();
//            $school['visiting_payment_cnt']=array();
//            $school['halfsuccess_payment_cnt']=array();
            
		$school['mon']=date('F',strtotime($date));

              if($month>=1 and $month<=3) {
			$new_month=$month+9;
                     $yearmn1= $this->session_end_yr;
		} else { 
			$new_month=$month-3;
			$yearmn1= $this->session_start_yr;
              }
                
              if($this->session->userdata('school_id')!=9) {
			$strquery3="";
              } else {
                     $strquery3=" and ( mode!='NB' or (mode='NB' and payment_date<'2017-04-24 00:00:00'))";
              }
                
              $school['mnth']=$new_month;
              $school['session_start_yr']=$this->session_start_yr;
              $school['session_end_yr']=$this->session_end_yr;
              $arr=array('1'=>4,'2'=>5, '3'=>6, '4'=>7, '5'=>8, '6'=>9, '7'=>10, '8'=>11, '9'=>12, '10'=>1, '11'=>2, '12'=>3);
              $yearquery=!empty($this->academic_session)? "year={$this->academic_session[0]->fin_year} and ":'';
              $school['yearquery']=$yearquery;
              $school['strquery3']=$strquery3;
//                for($i=1; $i<=$new_month; $i++)
//                {              
//                    $yearmn=($i >= 1 && $i <= 9)?$this->session_start_yr:$this->session_end_yr;
//                     $amount=$this->dbconnection->select("fee_transaction_head","count(if(collection_centre='FCLB',id,NULL)) as on_cnt,count(if(collection_centre!='FCLB',id,NULL)) as off_cnt,sum(if(collection_centre='FCLB',total_amount,0)) as amnt, sum(if(collection_centre!='FCLB',total_amount,0)) as amt", "$yearquery Month(payment_date)=$arr[$i] and Year(payment_date)=$yearmn  and response_code=0 and paid_status=1 $strquery3");                     
////                     $school['online'][$i]=$this->session->userdata('school_id')!=9 ? $amount[0]->amnt :'';
//                     $school['online'][$i]=$amount[0]->amnt;
////                     $amount1=$this->dbconnection->select("fee_transaction_head","count(id) as off_cnt, sum(total_amount) as amt", "$yearquery Month(payment_date)=$arr[$i] and Year(payment_date)=$yearmn and collection_centre!='FCLB' and response_code=0 and paid_status=1 ");
//                     $school['offline'][$i]=$amount[0]->amt;
//                     $school['total'][$i]=($amount[0]->amnt+$amount[0]->amt);
////                     $school['online_cnt'][$i]=$this->session->userdata('school_id')!=9 ? $amount[0]->on_cnt:'';
//                     $school['online_cnt'][$i]=$amount[0]->on_cnt;
//                     $school['offline_cnt'][$i]=$amount[0]->off_cnt;     
//                     $payment_analytics=$this->db->query("SELECT count(scount) success_count, count(fcount) failure_count, count(gcount) visiting_count,count(halfcount) hcount FROM ( SELECT  CASE WHEN response_code=0 THEN 1 ELSE NULL END scount,   CASE WHEN response_code=2  THEN 1 ELSE NULL END  fcount,  CASE WHEN response_code=1  THEN 1 ELSE NULL END  gcount,CASE WHEN response_code=0 and response_status=0  THEN 1 ELSE NULL END  halfcount from fee_transaction_head where $yearquery MONTH(payment_date)=$arr[$i] and Year(payment_date)=$yearmn and collection_centre='FCLB') t")->result();
////                     $payment_analytics=$payment_analytics->result();
//                     $school['success_payment_cnt'][$i]=$payment_analytics[0]->success_count;
//                     $school['failure_payment_cnt'][$i]=$payment_analytics[0]->failure_count;
//                     $school['visiting_payment_cnt'][$i]=$payment_analytics[0]->visiting_count;
//                     $school['halfsuccess_payment_cnt'][$i]=$payment_analytics[0]->hcount;
//                }
                
//                $tot_stud1=$this->dbconnection->select("student","count(id) as stud","status='Y'");
              $ayearquery=!empty($this->academic_session)? " and f1.year={$this->academic_session[0]->fin_year}":'';

//                $annual_defaulter = $this->db->query("select if(count(f1.id)=0,'Unpaid','Paid') as annual,s.id from student as s"
//                    . " left join ( fee_transaction_head as f1 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d1 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f1.id=d1.fee_trans_head_id and d1.fee_cat_id=1 $ayearquery)"
//                    . " on f1.student_id=s.id and f1.paid_status=1 "
//                    
//                    . " where s.status='Y' group by s.id having ( annual!='Paid')");
             
              $byearquery=!empty($this->academic_session)? " and f2.year={$this->academic_session[0]->fin_year}":'';

//                $monthly_defaulter = $this->db->query("select if(count(d2.month_no)>=$new_month"
//                    . " ,'Paid',concat(cast($new_month-count(d2.month_no) as char),' months Unpaid')) as monthly from student as s"
//                    . " left join ( fee_transaction_head as f2 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d2 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f2.id=d2.fee_trans_head_id and d2.fee_cat_id=2 $byearquery)"
//                    . " on f2.student_id=s.id and f2.paid_status=1 and f2.response_code=0 where s.status='Y'  group by s.id having ( monthly!='Paid')");
//                $ann_cnt=0;
//                $ann=$this->dbconnection->select("fee_transaction_head","distinct(student_id) as stud","paid_status=1 and response_code=0");
//                foreach($ann as $row)
//                {
//                    $fee_head=$this->dbconnection->select("fee_transaction_head","id","student_id=$row->stud");
//                    $fee_det=$this->dbconnection->select("fee_transaction_det","id","fee_cat_id=1 and fee_trans_head_id=".$fee_head[0]->id);
//                    if(count($fee_det)>=1)
//                    {
//                        ++$ann_cnt;
//                    }
//                }
//                
//               $annual=($tot_stud1[0]->stud)-$ann_cnt;
//               $school['defaulter_ann']=$annual_defaulter->num_rows();      
		$school['defaulter_ann']=0;      
      
//               $cls=$this->dbconnection->select("class","id,class_name","status='Y'");
              $tot_def=0;
              $tot_mon_def=0;
              $tot_stud1=0;
/*/               foreach($cls as $row)
//               {
//                   $def_cnt=0; $def=0; $ann_fee_def=0;
//                   $total_cl_stud= $this->dbconnection->select("student","count(admission_no) as students","status='Y' and class_id=$row->id");
//                   $school['class'][$row->class_name]['total_class_student']=$total_cl_stud[0]->students;                       
//                   $amount=$this->dbconnection->select("fee_transaction_head","sum(total_amount) as amnt, count(id) as on_cnt", "response_code=0 and paid_status=1 and $yearquery MONTH(payment_date)='$month' and Year(payment_date)=$yearmn1 and collection_centre='FCLB' $strquery3 and student_id in(select id from student where class_id=$row->id)");
////                   $school['class'][$row->class_name]['online_amnt']=$this->session->userdata('school_id')!=9 ? $amount[0]->amnt:'';
//                   $school['class'][$row->class_name]['online_amnt']=$amount[0]->amnt;
////                   $school['class'][$row->class_name]['online_cunt']=$this->session->userdata('school_id')!=9 ? $amount[0]->on_cnt:'';
//                   $school['class'][$row->class_name]['online_cunt']=$amount[0]->on_cnt;
//                   $amount1=$this->dbconnection->select("fee_transaction_head","sum(total_amount) as amt, count(id) as off_cnt", "response_code=0 and paid_status=1 and $yearquery MONTH(payment_date)='$month' and Year(payment_date)=$yearmn1 and collection_centre!='FCLB' and student_id in(select id from student where class_id=$row->id)");
//                   $school['class'][$row->class_name]['offline_amnt']=$amount1[0]->amt; 
//                   $school['class'][$row->class_name]['offline_cunt']=$amount1[0]->off_cnt;
//
////                   $stud_cnt=$this->dbconnection->select("student","id","id in(select student_id from fee_transaction_head where paid_status=1 and response_code=0) and class_id=$row->id");
////                   $stud=0;
////                   foreach($stud_cnt as $s)
////                   {   
//////                       ++$stud;
////                       $fee_det=$this->dbconnection->select("fee_transaction_det","count(month_no) as mon","fee_cat_id=2 and fee_trans_head_id in(select id from fee_transaction_head where student_id=$s->id)");
////                       $fee_det_ann=$this->dbconnection->select("fee_transaction_det","id","fee_cat_id=1 and fee_trans_head_id in(select id from fee_transaction_head where student_id=$s->id)");
////                       if($fee_det[0]->mon<=$new_month)
////                       {
////                           ++$def;
////                       }
////                       
////                       if(count($fee_det_ann)>=1)
////                       {
////                           ++$ann_fee_def;
////                       }
////                   }
////                   $stud_cnt1=($total_cl_stud[0]->students-count($stud_cnt));                  
////                   $tot_def=$stud_cnt1+$def;
////                   $tot_ann_def=$total_cl_stud[0]->students-$ann_fee_def;
////                   echo $tot_def;
////                   echo $def.'<br>';
////                   $school['class'][$row->class_name]['defaulter']=$total_cl_stud[0]->students-($amount[0]->on_cnt+$amount1[0]->off_cnt);
                     $class_annual_defaulter = $this->db->query("select if(count(f1.id)=0,'Unpaid','Paid') as annual,s.id from student as s"
                          . " left join ( fee_transaction_head as f1 inner join fee_transaction_det d1 on f1.id=d1.fee_trans_head_id and d1.fee_cat_id=1)"
                          . " on f1.student_id=s.id and f1.paid_status=1 $ayearquery"
                          . " where s.status='Y' and s.class_id={$row->id} group by s.id having ( annual!='Paid')");
             
                     $class_monthly_defaulter = $this->db->query("select if(count(d2.month_no)>=$new_month"
                          . " ,'Paid',concat(cast($new_month-count(d2.month_no) as char),' months Unpaid')) as monthly from student as s"
                          . " left join ( fee_transaction_head as f2 inner join fee_transaction_det d2 on f2.id=d2.fee_trans_head_id and d2.fee_cat_id=2)"
                          . " on f2.student_id=s.id and f2.paid_status=1 $byearquery and f2.response_code=0 where s.status='Y' and s.class_id={$row->id} group by s.id having ( monthly!='Paid')");
                     $school['class'][$row->class_name]['defaulter']=$class_monthly_defaulter->num_rows();
                     $school['class'][$row->class_name]['ann1_defaulter']=$class_annual_defaulter->num_rows();
			$tot_mon_def+=$tot_def;
              }        
              $school['defaulter_mon']=$monthly_defaulter->num_rows();                */

              $school['defaulter_mon']=0;                
              $this->data['school']= $school;
            
              $this->page_title = 'Dashboard';
              $this->data['user_name'] = $usr_nm;
              $this->section = 'dashboard';
              $this->page_name = 'admin_dashboard';
              $this->customview = '';
	}
    
    
	public function principal_dashboard() {
              $count = 0;
              $count_reg = 0;

//            $user_nam = $this->dbconnection->select("user", "user_name", "id=" . $this->session->userdata('user_id'));
//            $nm = $user_nam[0]->user_name;

		$name = explode("-", $this->session->userdata('user_name'));
		$usr_nm = $name[1];
            
              $this->data[$this->session->userdata('login_type') . '_message'] = 0;
              $this->data['school1'] = $this->school1;
              $this->data['school_name'] = $this->data['school1'][0]->description;
              $this->data['school_address'] = $this->data['school1'][0]->address;

		$this->data['tot_stud'] = $this->dbconnection->select("student", "count(if(status='Y',1,NULL)) as students,COUNT(IF(registered_status='1' and status='Y',1, NULL)) 'registered',COUNT(IF(registered_status='1' and status='P',1, NULL)) 'pending'", " status='Y' or status='P'");

		$this->data['total_students'] 	= $this->data['tot_stud'][0]->students;
		$this->data['total_pending'] 		= $this->data['tot_stud'][0]->pending;
		$this->data['total_registered'] 	= $this->data['tot_stud'][0]->registered;

		$this->data['tot_recepen'] = $this->db->query("select count(f1.id) as pending from fee_transaction_head f1 where f1.response_message like '%Receipt Cancelation Pending%' group by f1.id")->result();
		$this->data['total_pending_rep'] = $this->data['tot_recepen'][0]->pending;

		$date = date("Y-m");
		$month_year=explode('-',$date);
		$month=$month_year[1];

		$school=array();
		
/*           $school['online']=array();
//            $school['offline']=array();
//            $school['total']=array();
//            $school['online_cnt']=array();
//            $school['offline_cnt']=array();
//            $school['success_payment_cnt']=array();
//            $school['failure_payment_cnt']=array();
//            $school['visiting_payment_cnt']=array();
//            $school['halfsuccess_payment_cnt']=array();  */
           
		$school['mon']=date('F',strtotime($date));

              if($month>=1 and $month<=3) {
			$new_month=$month+9;
                     $yearmn1= $this->session_end_yr;
		} else { 
			$new_month=$month-3;
			$yearmn1= $this->session_start_yr;
		}
                
		if($this->session->userdata('school_id')!=9) {
			$strquery3="";
		} else {
			$strquery3=" and ( mode!='NB' or (mode='NB' and payment_date<'2017-04-24 00:00:00'))";
		}
                
              $school['mnth']=$new_month;
              $school['session_start_yr']=$this->session_start_yr;
              $school['session_end_yr']=$this->session_end_yr;
              $arr=array('1'=>4,'2'=>5, '3'=>6, '4'=>7, '5'=>8, '6'=>9, '7'=>10, '8'=>11, '9'=>12, '10'=>1, '11'=>2, '12'=>3);
              $yearquery=!empty($this->academic_session)? "year={$this->academic_session[0]->fin_year} and ":'';
              $school['yearquery']=$yearquery;
              $school['strquery3']=$strquery3;
//                for($i=1; $i<=$new_month; $i++)
//                {              
//                    $yearmn=($i >= 1 && $i <= 9)?$this->session_start_yr:$this->session_end_yr;
//                     $amount=$this->dbconnection->select("fee_transaction_head","count(if(collection_centre='FCLB',id,NULL)) as on_cnt,count(if(collection_centre!='FCLB',id,NULL)) as off_cnt,sum(if(collection_centre='FCLB',total_amount,0)) as amnt, sum(if(collection_centre!='FCLB',total_amount,0)) as amt", "$yearquery Month(payment_date)=$arr[$i] and Year(payment_date)=$yearmn  and response_code=0 and paid_status=1 $strquery3");                     
////                     $school['online'][$i]=$this->session->userdata('school_id')!=9 ? $amount[0]->amnt :'';
//                     $school['online'][$i]=$amount[0]->amnt;
////                     $amount1=$this->dbconnection->select("fee_transaction_head","count(id) as off_cnt, sum(total_amount) as amt", "$yearquery Month(payment_date)=$arr[$i] and Year(payment_date)=$yearmn and collection_centre!='FCLB' and response_code=0 and paid_status=1 ");
//                     $school['offline'][$i]=$amount[0]->amt;
//                     $school['total'][$i]=($amount[0]->amnt+$amount[0]->amt);
////                     $school['online_cnt'][$i]=$this->session->userdata('school_id')!=9 ? $amount[0]->on_cnt:'';
//                     $school['online_cnt'][$i]=$amount[0]->on_cnt;
//                     $school['offline_cnt'][$i]=$amount[0]->off_cnt;     
//                     $payment_analytics=$this->db->query("SELECT count(scount) success_count, count(fcount) failure_count, count(gcount) visiting_count,count(halfcount) hcount FROM ( SELECT  CASE WHEN response_code=0 THEN 1 ELSE NULL END scount,   CASE WHEN response_code=2  THEN 1 ELSE NULL END  fcount,  CASE WHEN response_code=1  THEN 1 ELSE NULL END  gcount,CASE WHEN response_code=0 and response_status=0  THEN 1 ELSE NULL END  halfcount from fee_transaction_head where $yearquery MONTH(payment_date)=$arr[$i] and Year(payment_date)=$yearmn and collection_centre='FCLB') t")->result();
////                     $payment_analytics=$payment_analytics->result();
//                     $school['success_payment_cnt'][$i]=$payment_analytics[0]->success_count;
//                     $school['failure_payment_cnt'][$i]=$payment_analytics[0]->failure_count;
//                     $school['visiting_payment_cnt'][$i]=$payment_analytics[0]->visiting_count;
//                     $school['halfsuccess_payment_cnt'][$i]=$payment_analytics[0]->hcount;
//                }
                
                
//                $tot_stud1=$this->dbconnection->select("student","count(id) as stud","status='Y'");
                
		$ayearquery=!empty($this->academic_session)? " and f1.year={$this->academic_session[0]->fin_year}":'';

//                $annual_defaulter = $this->db->query("select if(count(f1.id)=0,'Unpaid','Paid') as annual,s.id from student as s"
//                    . " left join ( fee_transaction_head as f1 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d1 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f1.id=d1.fee_trans_head_id and d1.fee_cat_id=1 $ayearquery)"
//                    . " on f1.student_id=s.id and f1.paid_status=1 "
//                    
//                    . " where s.status='Y' group by s.id having ( annual!='Paid')");
             
              $byearquery=!empty($this->academic_session)? " and f2.year={$this->academic_session[0]->fin_year}":'';

//                $monthly_defaulter = $this->db->query("select if(count(d2.month_no)>=$new_month"
//                    . " ,'Paid',concat(cast($new_month-count(d2.month_no) as char),' months Unpaid')) as monthly from student as s"
//                    . " left join ( fee_transaction_head as f2 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d2 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f2.id=d2.fee_trans_head_id and d2.fee_cat_id=2 $byearquery)"
//                    . " on f2.student_id=s.id and f2.paid_status=1 and f2.response_code=0 where s.status='Y'  group by s.id having ( monthly!='Paid')");
//                $ann_cnt=0;
//                $ann=$this->dbconnection->select("fee_transaction_head","distinct(student_id) as stud","paid_status=1 and response_code=0");
//                foreach($ann as $row)
//                {
//                    $fee_head=$this->dbconnection->select("fee_transaction_head","id","student_id=$row->stud");
//                    $fee_det=$this->dbconnection->select("fee_transaction_det","id","fee_cat_id=1 and fee_trans_head_id=".$fee_head[0]->id);
//                    if(count($fee_det)>=1)
//                    {
//                        ++$ann_cnt;
//                    }
//                }
//                
//               $annual=($tot_stud1[0]->stud)-$ann_cnt;
//               $school['defaulter_ann']=$annual_defaulter->num_rows();      
		$school['defaulter_ann']=0;      
      
//               $cls=$this->dbconnection->select("class","id,class_name","status='Y'");
		$tot_def=0;
		$tot_mon_def=0;
		$tot_stud1=0;
//               foreach($cls as $row)
//               {
//                   $def_cnt=0; $def=0; $ann_fee_def=0;
//                   $total_cl_stud= $this->dbconnection->select("student","count(admission_no) as students","status='Y' and class_id=$row->id");
//                   $school['class'][$row->class_name]['total_class_student']=$total_cl_stud[0]->students;                       
//                   $amount=$this->dbconnection->select("fee_transaction_head","sum(total_amount) as amnt, count(id) as on_cnt", "response_code=0 and paid_status=1 and $yearquery MONTH(payment_date)='$month' and Year(payment_date)=$yearmn1 and collection_centre='FCLB' $strquery3 and student_id in(select id from student where class_id=$row->id)");
////                   $school['class'][$row->class_name]['online_amnt']=$this->session->userdata('school_id')!=9 ? $amount[0]->amnt:'';
//                   $school['class'][$row->class_name]['online_amnt']=$amount[0]->amnt;
////                   $school['class'][$row->class_name]['online_cunt']=$this->session->userdata('school_id')!=9 ? $amount[0]->on_cnt:'';
//                   $school['class'][$row->class_name]['online_cunt']=$amount[0]->on_cnt;
//                   $amount1=$this->dbconnection->select("fee_transaction_head","sum(total_amount) as amt, count(id) as off_cnt", "response_code=0 and paid_status=1 and $yearquery MONTH(payment_date)='$month' and Year(payment_date)=$yearmn1 and collection_centre!='FCLB' and student_id in(select id from student where class_id=$row->id)");
//                   $school['class'][$row->class_name]['offline_amnt']=$amount1[0]->amt; 
//                   $school['class'][$row->class_name]['offline_cunt']=$amount1[0]->off_cnt;
//
////                   $stud_cnt=$this->dbconnection->select("student","id","id in(select student_id from fee_transaction_head where paid_status=1 and response_code=0) and class_id=$row->id");
////                   $stud=0;
////                   foreach($stud_cnt as $s)
////                   {   
//////                       ++$stud;
////                       $fee_det=$this->dbconnection->select("fee_transaction_det","count(month_no) as mon","fee_cat_id=2 and fee_trans_head_id in(select id from fee_transaction_head where student_id=$s->id)");
////                       $fee_det_ann=$this->dbconnection->select("fee_transaction_det","id","fee_cat_id=1 and fee_trans_head_id in(select id from fee_transaction_head where student_id=$s->id)");
////                       if($fee_det[0]->mon<=$new_month)
////                       {
////                           ++$def;
////                       }
////                       
////                       if(count($fee_det_ann)>=1)
////                       {
////                           ++$ann_fee_def;
////                       }
////                   }
////                   $stud_cnt1=($total_cl_stud[0]->students-count($stud_cnt));                  
////                   $tot_def=$stud_cnt1+$def;
////                   $tot_ann_def=$total_cl_stud[0]->students-$ann_fee_def;
////                   echo $tot_def;
////                   echo $def.'<br>';
////                   $school['class'][$row->class_name]['defaulter']=$total_cl_stud[0]->students-($amount[0]->on_cnt+$amount1[0]->off_cnt);
//                    $class_annual_defaulter = $this->db->query("select if(count(f1.id)=0,'Unpaid','Paid') as annual,s.id from student as s"
//                        . " left join ( fee_transaction_head as f1 inner join fee_transaction_det d1 on f1.id=d1.fee_trans_head_id and d1.fee_cat_id=1)"
//                        . " on f1.student_id=s.id and f1.paid_status=1 $ayearquery"
//
//                        . " where s.status='Y' and s.class_id={$row->id} group by s.id having ( annual!='Paid')");
//             
//                    $class_monthly_defaulter = $this->db->query("select if(count(d2.month_no)>=$new_month"
//                        . " ,'Paid',concat(cast($new_month-count(d2.month_no) as char),' months Unpaid')) as monthly from student as s"
//                        . " left join ( fee_transaction_head as f2 inner join fee_transaction_det d2 on f2.id=d2.fee_trans_head_id and d2.fee_cat_id=2)"
//                        . " on f2.student_id=s.id and f2.paid_status=1 $byearquery and f2.response_code=0 where s.status='Y' and s.class_id={$row->id} group by s.id having ( monthly!='Paid')");
//                   $school['class'][$row->class_name]['defaulter']=$class_monthly_defaulter->num_rows();
//                   $school['class'][$row->class_name]['ann1_defaulter']=$class_annual_defaulter->num_rows();
////                   $tot_mon_def+=$tot_def;
//               }        
               
//               $school['defaulter_mon']=$monthly_defaulter->num_rows();                
              $school['defaulter_mon']=0;                
                              
              $this->data['school']= $school;
            
		$this->page_title = 'Dashboard';
		$this->data['user_name'] = $usr_nm;
		$this->section = 'dashboard';
		$this->page_name = 'principal_dashboard';
		$this->customview = '';
	}
    
    
	public function office_dashboard() {
		error_reporting(-1);

		$count = 0;
		$count_reg = 0;
//            $user_nam = $this->dbconnection->select("user", "user_name", "id=" . $this->session->userdata('user_id'));
//            $nm = $user_nam[0]->user_name;
   
		$name = explode("-", $this->session->userdata('user_name'));
		$usr_nm = $name[1];
            
		$this->data[$this->session->userdata('login_type') . '_message'] = 0;
		$this->data['school1'] = $this->school1;
		$this->data['school_name'] = $this->data['school1'][0]->description;
		$this->data['school_address'] = $this->data['school1'][0]->address;

		$this->data['tot_stud'] = $this->dbconnection->select("student", "count(if(status='Y',1,NULL)) as students,COUNT(IF(registered_status='1' and status='Y',1, NULL)) 'registered',COUNT(IF(registered_status='1' and status='P',1, NULL)) 'pending'", " status='Y' or status='P'");
		$this->data['total_students'] = $this->data['tot_stud'][0]->students;

//            $this->data['tot_stud_reg'] = $this->dbconnection->select("student", "count(admission_no) as students_reg", "status='Y' and registered_status=1");
		$this->data['total_registered'] = $this->data['tot_stud'][0]->registered;

//            $this->data['tot_stud_pending'] = $this->dbconnection->select("student", "count(admission_no) as students_pending", "status='P' and registered_status=1");
		$this->data['total_pending'] = $this->data['tot_stud'][0]->pending;

		$date = date("Y-m");
		$month_year=explode('-',$date);
              $month=$month_year[1];

              $school=array();            
//            $school['online']=array();
//            $school['offline']=array();
//            $school['total']=array();
//            $school['online_cnt']=array();
//            $school['offline_cnt']=array();
//            $school['success_payment_cnt']=array();
//            $school['failure_payment_cnt']=array();
//            $school['visiting_payment_cnt']=array();
//            $school['halfsuccess_payment_cnt']=array();
		$school['mon']=date('F',strtotime($date));

              if($month>=1 and $month<=3) {
			$new_month=$month+9;
			$yearmn1= $this->session_end_yr;
              } else { 
			$new_month=$month-3;
			$yearmn1= $this->session_start_yr;
              }
                
                if($this->session->userdata('school_id')!=9){
                    $strquery3="";
                } else{
                    $strquery3=" and ( mode!='NB' or (mode='NB' and payment_date<'2017-04-24 00:00:00'))";
                }
                
                $school['mnth']=$new_month;
                $school['session_start_yr']=$this->session_start_yr;
                $school['session_end_yr']=$this->session_end_yr;
                $arr=array('1'=>4,'2'=>5, '3'=>6, '4'=>7, '5'=>8, '6'=>9, '7'=>10, '8'=>11, '9'=>12, '10'=>1, '11'=>2, '12'=>3);
                $yearquery=!empty($this->academic_session)? "year={$this->academic_session[0]->fin_year} and ":'';
                $school['yearquery']=$yearquery;
                $school['strquery3']=$strquery3;
//                for($i=1; $i<=$new_month; $i++)
//                {              
//                    $yearmn=($i >= 1 && $i <= 9)?$this->session_start_yr:$this->session_end_yr;
//                     $amount=$this->dbconnection->select("fee_transaction_head","count(if(collection_centre='FCLB',id,NULL)) as on_cnt,count(if(collection_centre!='FCLB',id,NULL)) as off_cnt,sum(if(collection_centre='FCLB',total_amount,0)) as amnt, sum(if(collection_centre!='FCLB',total_amount,0)) as amt", "$yearquery Month(payment_date)=$arr[$i] and Year(payment_date)=$yearmn  and response_code=0 and paid_status=1 $strquery3");                     
////                     $school['online'][$i]=$this->session->userdata('school_id')!=9 ? $amount[0]->amnt :'';
//                     $school['online'][$i]=$amount[0]->amnt;
////                     $amount1=$this->dbconnection->select("fee_transaction_head","count(id) as off_cnt, sum(total_amount) as amt", "$yearquery Month(payment_date)=$arr[$i] and Year(payment_date)=$yearmn and collection_centre!='FCLB' and response_code=0 and paid_status=1 ");
//                     $school['offline'][$i]=$amount[0]->amt;
//                     $school['total'][$i]=($amount[0]->amnt+$amount[0]->amt);
////                     $school['online_cnt'][$i]=$this->session->userdata('school_id')!=9 ? $amount[0]->on_cnt:'';
//                     $school['online_cnt'][$i]=$amount[0]->on_cnt;
//                     $school['offline_cnt'][$i]=$amount[0]->off_cnt;     
//                     $payment_analytics=$this->db->query("SELECT count(scount) success_count, count(fcount) failure_count, count(gcount) visiting_count,count(halfcount) hcount FROM ( SELECT  CASE WHEN response_code=0 THEN 1 ELSE NULL END scount,   CASE WHEN response_code=2  THEN 1 ELSE NULL END  fcount,  CASE WHEN response_code=1  THEN 1 ELSE NULL END  gcount,CASE WHEN response_code=0 and response_status=0  THEN 1 ELSE NULL END  halfcount from fee_transaction_head where $yearquery MONTH(payment_date)=$arr[$i] and Year(payment_date)=$yearmn and collection_centre='FCLB') t")->result();
////                     $payment_analytics=$payment_analytics->result();
//                     $school['success_payment_cnt'][$i]=$payment_analytics[0]->success_count;
//                     $school['failure_payment_cnt'][$i]=$payment_analytics[0]->failure_count;
//                     $school['visiting_payment_cnt'][$i]=$payment_analytics[0]->visiting_count;
//                     $school['halfsuccess_payment_cnt'][$i]=$payment_analytics[0]->hcount;
//                }
                
                
//                $tot_stud1=$this->dbconnection->select("student","count(id) as stud","status='Y'");
                $ayearquery=!empty($this->academic_session)? " and f1.year={$this->academic_session[0]->fin_year}":'';

//                $annual_defaulter = $this->db->query("select if(count(f1.id)=0,'Unpaid','Paid') as annual,s.id from student as s"
//                    . " left join ( fee_transaction_head as f1 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d1 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f1.id=d1.fee_trans_head_id and d1.fee_cat_id=1 $ayearquery)"
//                    . " on f1.student_id=s.id and f1.paid_status=1 "
//                    
//                    . " where s.status='Y' group by s.id having ( annual!='Paid')");
             
                $byearquery=!empty($this->academic_session)? " and f2.year={$this->academic_session[0]->fin_year}":'';

//                $monthly_defaulter = $this->db->query("select if(count(d2.month_no)>=$new_month"
//                    . " ,'Paid',concat(cast($new_month-count(d2.month_no) as char),' months Unpaid')) as monthly from student as s"
//                    . " left join ( fee_transaction_head as f2 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d2 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f2.id=d2.fee_trans_head_id and d2.fee_cat_id=2 $byearquery)"
//                    . " on f2.student_id=s.id and f2.paid_status=1 and f2.response_code=0 where s.status='Y'  group by s.id having ( monthly!='Paid')");
//                $ann_cnt=0;
//                $ann=$this->dbconnection->select("fee_transaction_head","distinct(student_id) as stud","paid_status=1 and response_code=0");
//                foreach($ann as $row)
//                {
//                    $fee_head=$this->dbconnection->select("fee_transaction_head","id","student_id=$row->stud");
//                    $fee_det=$this->dbconnection->select("fee_transaction_det","id","fee_cat_id=1 and fee_trans_head_id=".$fee_head[0]->id);
//                    if(count($fee_det)>=1)
//                    {
//                        ++$ann_cnt;
//                    }
//                }
//                
//               $annual=($tot_stud1[0]->stud)-$ann_cnt;
//               $school['defaulter_ann']=$annual_defaulter->num_rows();      
               $school['defaulter_ann']=0;      
      
//               $cls=$this->dbconnection->select("class","id,class_name","status='Y'");
               $tot_def=0;
               $tot_mon_def=0;
               $tot_stud1=0;
//               foreach($cls as $row)
//               {
//                   $def_cnt=0; $def=0; $ann_fee_def=0;
//                   $total_cl_stud= $this->dbconnection->select("student","count(admission_no) as students","status='Y' and class_id=$row->id");
//                   $school['class'][$row->class_name]['total_class_student']=$total_cl_stud[0]->students;                       
//                   $amount=$this->dbconnection->select("fee_transaction_head","sum(total_amount) as amnt, count(id) as on_cnt", "response_code=0 and paid_status=1 and $yearquery MONTH(payment_date)='$month' and Year(payment_date)=$yearmn1 and collection_centre='FCLB' $strquery3 and student_id in(select id from student where class_id=$row->id)");
////                   $school['class'][$row->class_name]['online_amnt']=$this->session->userdata('school_id')!=9 ? $amount[0]->amnt:'';
//                   $school['class'][$row->class_name]['online_amnt']=$amount[0]->amnt;
////                   $school['class'][$row->class_name]['online_cunt']=$this->session->userdata('school_id')!=9 ? $amount[0]->on_cnt:'';
//                   $school['class'][$row->class_name]['online_cunt']=$amount[0]->on_cnt;
//                   $amount1=$this->dbconnection->select("fee_transaction_head","sum(total_amount) as amt, count(id) as off_cnt", "response_code=0 and paid_status=1 and $yearquery MONTH(payment_date)='$month' and Year(payment_date)=$yearmn1 and collection_centre!='FCLB' and student_id in(select id from student where class_id=$row->id)");
//                   $school['class'][$row->class_name]['offline_amnt']=$amount1[0]->amt; 
//                   $school['class'][$row->class_name]['offline_cunt']=$amount1[0]->off_cnt;
//
////                   $stud_cnt=$this->dbconnection->select("student","id","id in(select student_id from fee_transaction_head where paid_status=1 and response_code=0) and class_id=$row->id");
////                   $stud=0;
////                   foreach($stud_cnt as $s)
////                   {   
//////                       ++$stud;
////                       $fee_det=$this->dbconnection->select("fee_transaction_det","count(month_no) as mon","fee_cat_id=2 and fee_trans_head_id in(select id from fee_transaction_head where student_id=$s->id)");
////                       $fee_det_ann=$this->dbconnection->select("fee_transaction_det","id","fee_cat_id=1 and fee_trans_head_id in(select id from fee_transaction_head where student_id=$s->id)");
////                       if($fee_det[0]->mon<=$new_month)
////                       {
////                           ++$def;
////                       }
////                       
////                       if(count($fee_det_ann)>=1)
////                       {
////                           ++$ann_fee_def;
////                       }
////                   }
////                   $stud_cnt1=($total_cl_stud[0]->students-count($stud_cnt));                  
////                   $tot_def=$stud_cnt1+$def;
////                   $tot_ann_def=$total_cl_stud[0]->students-$ann_fee_def;
////                   echo $tot_def;
////                   echo $def.'<br>';
////                   $school['class'][$row->class_name]['defaulter']=$total_cl_stud[0]->students-($amount[0]->on_cnt+$amount1[0]->off_cnt);
//                    $class_annual_defaulter = $this->db->query("select if(count(f1.id)=0,'Unpaid','Paid') as annual,s.id from student as s"
//                        . " left join ( fee_transaction_head as f1 inner join fee_transaction_det d1 on f1.id=d1.fee_trans_head_id and d1.fee_cat_id=1)"
//                        . " on f1.student_id=s.id and f1.paid_status=1 $ayearquery"
//
//                        . " where s.status='Y' and s.class_id={$row->id} group by s.id having ( annual!='Paid')");
//             
//                    $class_monthly_defaulter = $this->db->query("select if(count(d2.month_no)>=$new_month"
//                        . " ,'Paid',concat(cast($new_month-count(d2.month_no) as char),' months Unpaid')) as monthly from student as s"
//                        . " left join ( fee_transaction_head as f2 inner join fee_transaction_det d2 on f2.id=d2.fee_trans_head_id and d2.fee_cat_id=2)"
//                        . " on f2.student_id=s.id and f2.paid_status=1 $byearquery and f2.response_code=0 where s.status='Y' and s.class_id={$row->id} group by s.id having ( monthly!='Paid')");
//                   $school['class'][$row->class_name]['defaulter']=$class_monthly_defaulter->num_rows();
//                   $school['class'][$row->class_name]['ann1_defaulter']=$class_annual_defaulter->num_rows();
////                   $tot_mon_def+=$tot_def;
//               }        
               
//               $school['defaulter_mon']=$monthly_defaulter->num_rows();                
               $school['defaulter_mon']=0;                
                              
               $this->data['school']= $school;
            
            
            
            $this->data['page_title'] = 'Dashboard';
            $this->data['user_name'] = $usr_nm;
            $this->data['section'] = 'dashboard';
            $this->data['page_name'] = 'office_dashboard';
            // $this->data['customview'] = $this->customview;
           // echo "<pre>"; print_r($this->data);
            // $this->load->view('dashboard/index',$this->data);
            $this->load->view('dashboard/office_dashboard',$this->data);
    }
    

	public function multistores_dashboard() {
		error_reporting(-1);

		$count = 0;
		$count_reg = 0;
   
		$name = explode("-", $this->session->userdata('user_name'));
		$usr_nm = $name[1];

		$var_grouptype = $this->dbconnection->select("user_group", "group_type", "id={$this->session->userdata('user_group_id')}"); 
		$this->var_role = !empty($var_grouptype) ? $var_grouptype[0]->group_type : '----';

		$this->data['fetch_student'] 	= $this->dbconnection->select('student', 'id, admission_no, first_name, middle_name, last_name', 'status=1');

//		$str = 'store_type="' . $this->var_role . '" and active="Y" and final_status="Rejected"';
              $this->data['store_bill_reject'] = $this->dbconnection->select_order('store_bill_hdr','*,'
					. '(select admission_no from student where admission_no=store_bill_hdr.admission_no) as adm_no,'
					. '(select first_name from student where admission_no=store_bill_hdr.admission_no) as student_fname,'
					. '(select middle_name from student where admission_no=store_bill_hdr.admission_no) as student_midname,'
					. '(select last_name from student where admission_no=store_bill_hdr.admission_no) as student_lname,'
					. 'bill_date, date_approved1, approved1_by, approve1_comment, approved2_by, date_approved2,'
					. 'approve2_comment, approved3_by, date_approved3, approve3_comment, final_status, final_comment', 'status=1 AND final_status="Rejected" AND store_type = "' . $this->var_role . '"', 'id', 'ASC');

		$this->data[$this->session->userdata('login_type') . '_message'] = 0;
		$this->data['school1'] = $this->school1;
		$this->data['school_name'] = $this->data['school1'][0]->description;
		$this->data['school_address'] = $this->data['school1'][0]->address;

              $this->data['school']= $school;

              $this->page_title = 'Dashboard';
              $this->data['user_name'] = $usr_nm;
              $this->section = 'dashboard';
              $this->page_name = 'multistores_dashboard';
              $this->customview = '';
	}


	public function multiapprovers_dashboard() {
		error_reporting(-1);

		$count = 0;
		$count_reg = 0;
   
		$name = explode("-", $this->session->userdata('user_name'));
		$usr_nm = $name[1];

		$var_grouptype = $this->dbconnection->select("user_group", "group_type", "id={$this->session->userdata('user_group_id')}"); 
		$this->var_role = !empty($var_grouptype) ? $var_grouptype[0]->group_type : '----';

		$this->data['fetch_student'] 	= $this->dbconnection->select('student', 'id, admission_no, first_name, middle_name, last_name', 'status=1');

		if($this->var_role == 'Approver 1')
			$this->data['store_bill_appr'] = $this->dbconnection->select_order('store_bill_hdr','*,'
					. '(select admission_no from student where admission_no=store_bill_hdr.admission_no) as adm_no,'
					. '(select first_name from student where admission_no=store_bill_hdr.admission_no) as student_fname,'
					. '(select middle_name from student where admission_no=store_bill_hdr.admission_no) as student_midname,'
					. '(select last_name from student where admission_no=store_bill_hdr.admission_no) as student_lname,'
					. 'bill_date, date_approved1, approved1_by, approve1_comment, approved2_by, date_approved2,'
					. 'approve2_comment, approved3_by, date_approved3, approve3_comment, final_status, final_comment', 'status="Y" AND final_status="Sent for Approval"', 'id', 'ASC');
		
		elseif($this->var_role == 'Approver 2')
			$this->data['store_bill_appr'] = $this->dbconnection->select_order('store_bill_hdr','*,'
					. '(select admission_no from student where admission_no=store_bill_hdr.admission_no) as adm_no,'
					. '(select first_name from student where admission_no=store_bill_hdr.admission_no) as student_fname,'
					. '(select middle_name from student where admission_no=store_bill_hdr.admission_no) as student_midname,'
					. '(select last_name from student where admission_no=store_bill_hdr.admission_no) as student_lname,'
					. 'bill_date, date_approved1, approved1_by, approve1_comment, approved2_by, date_approved2,'
					. 'approve2_comment, approved3_by, date_approved3, approve3_comment, final_status, final_comment', 'status="Y" AND final_status="Pending with Approver 2"', 'id', 'ASC');

		elseif($this->var_role == 'Approver 3')
			$this->data['store_bill_appr'] = $this->dbconnection->select_order('store_bill_hdr','*,'
					. '(select admission_no from student where admission_no=store_bill_hdr.admission_no) as adm_no,'
					. '(select first_name from student where admission_no=store_bill_hdr.admission_no) as student_fname,'
					. '(select middle_name from student where admission_no=store_bill_hdr.admission_no) as student_midname,'
					. '(select last_name from student where admission_no=store_bill_hdr.admission_no) as student_lname,'
					. 'bill_date, date_approved1, approved1_by, approve1_comment, approved2_by, date_approved2,'
					. 'approve2_comment, approved3_by, date_approved3, approve3_comment, final_status, final_comment', 'status="Y" AND final_status="Pending with Approver 3"', 'id', 'ASC');

		$this->data[$this->session->userdata('login_type') . '_message'] = 0;
		$this->data['school1'] = $this->school1;
		$this->data['school_name'] = $this->data['school1'][0]->description;
		$this->data['school_address'] = $this->data['school1'][0]->address;

              $this->data['school']= $school;

              $this->page_title = 'Dashboard';
              $this->data['user_name'] = $usr_nm;
              $this->section = 'dashboard';
              $this->page_name = 'multiapprovers_dashboard';
              $this->customview = '';
	}
    
    
	public function teacher_dashboard() {
        // error_reporting(-1);

		$count = 0;
		$count_reg = 0;
		$user_nam = $this->dbconnection->select("user", "user_name", "id=" . $this->session->userdata('user_id'));

		$nm = $user_nam[0]->user_name;
		$name = explode("-", $nm);
		$usr_nm = $name[1];
            
		$this->data[$this->session->userdata('login_type') . '_message'] = 0;
		$this->data['school1'] = $this->school1;
		$this->data['school_name'] = $this->data['school1'][0]->description;
		$this->data['school_address'] = $this->data['school1'][0]->address;

		$this->data['tot_stud'] = $this->dbconnection->select("student", "count(if(status='Y',1,NULL)) as students,COUNT(IF(registered_status='1' and status='Y',1, NULL)) 'registered',COUNT(IF(registered_status='1' and status='P',1, NULL)) 'pending'", " status='Y' or status='P'");
		$this->data['total_students'] = $this->data['tot_stud'][0]->students;
		$this->data['total_pending'] = $this->data['tot_stud'][0]->pending;

		$date = date("Y-m-d");
		$d = date_parse_from_format("Y-m-d", $date);
		$mon=$d["month"];
		$day=$d["day"];
            
		$this->data['attendance_data']	= $this->db->query("select sh.id,sh.class_id,(select class_name from class where id=sh.class_id) as class_name,sh.section_id,(select sec_name from section where id=sh.section_id) as section_name,sh.sms,sh.month,sd.atten_date,ct.teacher_id,(select name from employee where id=ct.teacher_id) as teacher_name from stud_mnthly_att_head sh,stud_mnthly_att_detail sd,class_teachet_alloc ct where sh.id=sd.mnthly_att_head_id and sh.status='Y'and sh.month='$mon' and sd.atten_date='$day'and ct.status='1' and ct.class_id=sh.class_id and ct.section_id=sh.section_id group by sd.atten_date")->result();

		$this->data['class_data']		= $this->db->query("select ct.teacher_id,ct.class_id,ct.section_id,c.id,c.class_name,s.id,s.sec_name from class_teachet_alloc ct,class c,section s where ct.status=1 and c.status='Y' and ct.class_id=c.id and ct.section_id=s.id and ct.teacher_id=".$this->employee_id)->result();

		$this->data['teacher_profile']	= $this->db->query('select * from employee where id='.$this->employee_id)->result();

		$i = 0;
		$k = 0;
		$t = date('d-m-Y');
		$day1 = date("l", strtotime($t));

		$tot_period = 0;
		$period = $this->dbconnection->select("class_routine", "count(id) as cnt", "day='Monday' and status=1");
		$tot_period = $period[0]->cnt;

		$period1 = $this->dbconnection->select("class_routine", "count(id) as cnt", "day='Tuesday' and status=1");
		if ($period1[0]->cnt > $tot_period) {
			$tot_period = $period1[0]->cnt;
		}

		$period2 = $this->dbconnection->select("class_routine", "count(id) as cnt", "day='Wednesday' and status=1");
		if ($period2[0]->cnt > $tot_period) {
			$tot_period = $period2[0]->cnt;
		}

		$period3 = $this->dbconnection->select("class_routine", "count(id) as cnt", "day='Thursday' and status=1");
		if ($period3[0]->cnt > $tot_period) {
			$tot_period = $period3[0]->cnt;
		}

		$period4 = $this->dbconnection->select("class_routine", "count(id) as cnt", "day='Friday' and status=1");
		if ($period4[0]->cnt > $tot_period) {
			$tot_period = $period4[0]->cnt;
		}

		$period5 = $this->dbconnection->select("class_routine", "count(id) as cnt", "day='Saturday' and status=1");
		if ($period5[0]->cnt > $tot_period) {
			$tot_period = $period5[0]->cnt;
		}

		$day_q = $this->db->query("select day from class_routine where status=1 group by day having count(id)=$tot_period");
		$day_nm = $day_q->result();
		$day = $day_nm[0]->day;

        // $period_cnt_all = $this->dbconnection->select("class_routine", "count(id) as cnt", "status=1 and day='$day'","","","","","$limit = '7'","");
		$period_cnt_all = $this->db->query("select count(id) as cnt from class_periods where status='1'")->result();
		$tot_periodall = $period_cnt_all[0]->cnt;
        //   print_r($tot_periodall);
        // die();
        // $period_cnt_all = $this->dbconnection->select("class_routine", "*", " status=1 and day='$day'");
        
		$period_cnt = $this->db->query("select cr.class_id,(select class_name from class where id=cst.class_id) as classs_name,cr.section_id,cr.day,cr.period_id,cp.name as period_name,cp.time_start,cp.time_start_min,cp.time_end,cp.time_end_min,cst.id,cst.class_id,cst.teacher_id,cst.subject_id,(select name from subject where id=cst.subject_id) as subject_name,emp.id,emp.name from class_periods cp,class_routine cr,employee emp,class_subject_teacher cst where cr.period_id=cp.id and cr.status=1 and cr.day='$day' and cst.teacher_id=emp.id and cst.class_id=cr.class_id and cst.section_id=cr.section_id and cst.subject_id=cr.subject_id  group by cr.period_id")->result();
		$period_cnt1 = $this->db->query("select cr.class_id,(select class_name from class where id=cst.class_id) as classs_name,cr.section_id,cr.day,cr.period_id,cp.name as period_name,cp.time_start,cp.time_start_min,cp.time_end,cp.time_end_min,cst.id,cst.class_id,cst.section_id,(select sec_name from section where id=cst.section_id) as sec_name,cst.teacher_id,cst.subject_id,(select name from subject where id=cst.subject_id) as subject_name,emp.id,emp.name from class_periods cp,class_routine cr,employee emp,class_subject_teacher cst where cr.period_id=cp.id and cr.status=1 and cr.day='$day' and cst.teacher_id=emp.id and cst.class_id=cr.class_id and cst.section_id=cr.section_id and cst.subject_id=cr.subject_id and emp.id=" . $this->employee_id . "  group by cr.period_id")->result();

		foreach ($period_cnt as $row) {
			$this->data['period_name'][$k] 	= $row->period_name;
			$this->data['start_min'][$k] 	= $row->time_start_min;
			$this->data['end_min'][$k] 	= $row->time_end_min;
			$this->data['start'][$k] 	= $row->time_start;
			$this->data['end'][$k] 	= $row->time_end;
			$k++;
		}
		$date = date('d-m-Y');
		$teacher_id=$this->employee_id;
		$gettodayRou = $this->db->query("select cr.class_id,cr.section_id,cr.subject_id,cr.day,cr.period_id,cp.name,cp.time_start,cp.time_start_min,cp.time_end,cp.time_end_min,cst.teacher_id,(select name from employee where id=teacher_id) as teachername,sub.name as subject_name from class_periods cp,class_routine cr,class_subject_teacher cst,subject sub where cr.period_id=cp.id and cr.status=1 and cr.day='$day' and cr.subject_id=sub.id and cst.teacher_id=" . $this->employee_id . " group by cst.teacher_id")->result();

		$i = 0;
		$max_j = 0;
		$t = date('d-m-Y');
		$day1 = date("l", strtotime($t));
		$day_name = $this->dbconnection->select("class_routine", "distinct(day)", "status=1");

		foreach ($day_name as $d) {
			$subject = $this->dbconnection->select("class_routine", "*", "status=1 and day='" . $d->day . "'");
			$j = 0;
			$this->data['dayyy'][$i] = $d->day;
			$this->data['date']		= date("Y-m-d");
            
			foreach ($subject as $row) {
				$subj = $row->subject_id;
				if ($row->subject_id == 0) {
					$this->data['day_subject'][$i][$j] = 'Break';
					$this->data['tchr_nam'][$i][$j] = '';
				
				} else {
					$this->data['day_subject'][$i][$j] = $this->dbconnection->Get_namme("subject", "id", "$subj", "name");
					$sub_teachr = $this->dbconnection->select("class_subject_teacher", "teacher_id,class_id,section_id,id,(select name from employee where id=teacher_id) as tec_name,(select class_name from class where id=class_id) as cls_name,(select sec_name from section where id=section_id) as sec_name", "subject_id=$subj and teacher_id=" . $this->employee_id . " and status=1");
					$countsub_tea = count($sub_teachr);
					if ($countsub_tea > 0) {
						$this->data['tchr_nam'][$i][$j] = '(' . $sub_teachr[0]->tec_name . ')';
						$this->data['class_p_id'][$i][$j] = '(' . $sub_teachr[0]->cls_name ;
						$this->data['sec_p_id'][$i][$j] =  $sub_teachr[0]->sec_name . ')';
					} else {
						$this->data['tchr_nam'][$i][$j] = '';
					}
				}
				$j++;
			}
			if ($j > $max_j)
				$max_j = $j;

			$i++;
		}

//            $this->data['tot_stud_reg'] = $this->dbconnection->select("student", "count(admission_no) as students_reg", "status='Y' and registered_status=1");
		$this->data['total_registered'] = $this->data['tot_stud'][0]->registered;
		$this->data['cnt'] = $i;
		$this->data['count'] = $max_j;
		$this->data['today'] = $day1;
		$this->data['school'] = $this->school_dashboard();
		$this->data['period'] = $tot_period;
		$this->data['tot_periodall'] = $tot_periodall;
		$this->data['row'] = $gettodayRou;
		$this->data['period_cnt1'] = $period_cnt;
		$this->data['period_cnt'] = $period_cnt1;
		
		$this->page_title 	= 'Welcome ' . $usr_nm;
		$this->section 	= 'dashboard';
		$this->page_name	= 'teacher_dashboard';
		$this->customview	= '';
	}
    
    
	public function student_dashboard_old() {
        
		$usr_name = explode("-", $this->session->userdata('user_name'));
		$this->data['school1'] = $this->school1;

		$stud_info = $this->dbconnection->select("student", "id,CONCAT(first_name,' ',middle_name,' ',last_name) as name, email_address, admission_no, father_name, mother_name, address, dob, phone, class_id,(select class_name from class where id=class_id) as cls, section_id, (select sec_name from section where id=section_id) as sec, (select course_name from course where id=course_id) as course_name,(select cat_name from category where id=stud_category) as stud_cat", "admission_no='$usr_name[1]' and status='Y'");
		if(empty($stud_info))
			redirect('/login');
            
		$s_name = $stud_info[0]->name;
           	$s_class = $stud_info[0]->class_id;
           	$s_sec = $stud_info[0]->section_id;
            
		$class_teacher = $this->dbconnection->select("employee", "*", "id=(select teacher_id from class_teachet_alloc where class_id=$s_class and section_id=$s_sec and status=1)");
		$count_ct = count($class_teacher);
		if($count_ct>0) {
			$teacher_name 		= $class_teacher[0]->name;
        		$this->data['teacher'] 	= $teacher_name;
			$this->data['teacher_contact'] 	= $class_teacher[0]->phone_no;
			$this->data['teacher_email'] 	= $class_teacher[0]->email;
        	}
        	else {
        		$teacher_name = 'N/A';
        		$this->data['teacher'] = $teacher_name;
			$this->data['teacher_contact'] = 'N/A';
			$this->data['teacher_email'] = 'N/A';
        	}

		$subject = $this->dbconnection->select("class_routine", "distinct(subject_id)", "class_id=$s_class and section_id=$s_sec and status=1");

		$i = 0;
              $j = 0;
              $t = date('d-m-Y');
		$day1 = date("l", strtotime($t));

		$routine = $this->dbconnection->select("class_routine", "*", "class_id=$s_class and section_id=$s_sec and day LIKE '$day1%' and status=1");
		foreach ($routine as $r) {
			$rout_id = $r->id;
		}

        	foreach ($subject as $row) {
			$sub = $row->subject_id;
			if ($row->subject_id == 0) {
				$this->data['subject'][$i] = '';
				$this->data['tchr_nm'][$i] = '';
			} 
			else {                    
				$this->data['subject'][$i] = $this->dbconnection->Get_namme("subject", "id", "$sub", "name");
				$sub_teacher = $this->dbconnection->select("class_subject_teacher", "teacher_id,id,(select name from employee where id=teacher_id) as teac_name", "subject_id=$sub and class_id=$s_class and section_id=$s_sec and status=1");
				$count_tec = count($sub_teacher);
				
				if($count_tec>0) {
					$this->data['tchr_nm'][$i] = $sub_teacher[0]->teac_name;
				} else {
					$this->data['tchr_nm'][$i] ='N/A';
				}
			}
			$i++;
		}

		$fee_info = $this->dbconnection->select("fee_transaction_head", "id,total_amount,payment_date", "paid_status=1 and response_code=0 and student_id=" . $stud_info[0]->id,'payment_date','DESC');
		$cnt_sub = count($subject);
		$fee_date1 =  !empty($fee_info)? date("d-M-Y", strtotime($fee_info[0]->payment_date)):'';

              $this->data['sub_cnt'] = $cnt_sub;
              $this->data['student_name'] = $stud_info[0]->name;
              $this->data['sec'] = $stud_info[0]->sec;
		$this->data['clas'] = $stud_info[0]->cls;
		$this->data['course_name'] = $stud_info[0]->course_name;
		$this->data['fee_stud_category'] = $stud_info[0]->stud_cat;
                
		$this->data['class_id'] = $s_class;
		$this->data['sect_id'] = $s_sec;
		$this->data['assig'] = $this->dbconnection->select('assignment', 'count(*) as total', 'class_id='.$s_class.' AND section_id='.$s_sec.' AND dos>CURDATE()');
		$this->data['dob'] = $stud_info[0]->dob;
		$this->data['contact'] = $stud_info[0]->phone;
		$this->data['father'] = $stud_info[0]->father_name;
		$this->data['mother'] = $stud_info[0]->mother_name;
		$this->data['addrs'] = $stud_info[0]->address;
		$this->data['email'] = $stud_info[0]->email_address;
		$this->data['adm'] = $stud_info[0]->admission_no;
           
		$this->data['fee_amnt'] = $fee_info[0]->total_amount;
		$this->data['fee_date'] = $fee_date1;
		$this->data['day'] = $day1;
		$this->data['period'] = count($routine);
		$this->data['periods'] = $this->dbconnection->select('class_periods', '*', 'status=1');
		$this->page_title = 'Dashboard';
		$this->section = 'dashboard';
		$this->page_name = 'student_dashboard';
		$this->customview = '';
	}
//    public function student_dashboard_old() {
//        
//            $usr_name = explode("-", $this->session->userdata('user_name'));
////                echo $usr_name[1];
//            $stud_info = $this->dbconnection->select("student", "id,CONCAT(first_name,' ',middle_name,' ',last_name) as name, email_address, admission_no, father_name, mother_name, address, dob, phone, class_id,(select class_name from class where id=class_id) as cls, section_id, (select sec_name from section where id=section_id) as sec", "admission_no='$usr_name[1]'");
//            $s_name = $stud_info[0]->name;
//            $s_class = $stud_info[0]->class_id;
//            $s_sec = $stud_info[0]->section_id;
//            
//
//            $class_teacher = $this->dbconnection->select("employee", "*", "id=(select teacher_id from class_teachet_alloc where class_id=$s_class and section_id=$s_sec and status=1)");
//            $teacher_name = $class_teacher[0]->name;
//            $subject = $this->dbconnection->select("class_routine", "distinct(subject_id)", "class_id=$s_class and section_id=$s_sec and status=1");
//
//
//            $i = 0;
//            $j = 0;
//            $t = date('d-m-Y');
//            $day1 = date("l", strtotime($t));
//            $routine = $this->dbconnection->select("class_routine", "*", "class_id=$s_class and section_id=$s_sec and day LIKE '$day1%' and status=1");
//            foreach ($routine as $r) {
//                $subj = $r->subject_id;
//                if ($r->subject_id == 0) {
//                    $this->data['day_subject'][$j] = 'Break';
//                    $this->data['start'][$j] = $r->time_start;
//                    $this->data['start_min'][$j] = $r->time_start_min;
//                    $this->data['end'][$j] = $r->time_end;
//                    $this->data['end_min'][$j] = $r->time_end_min;
//                    $this->data['tchr_nam'][$j] = '';
//                } else {
//                    $this->data['day_subject'][$j] = $this->dbconnection->Get_namme("subject", "id", "$subj", "name");
//                    $this->data['start'][$j] = $r->time_start;
//                    $this->data['start_min'][$j] = $r->time_start_min;
//                    $this->data['end'][$j] = $r->time_end;
//                    $this->data['end_min'][$j] = $r->time_end_min;
//                    $sub_teachr = $this->dbconnection->select("class_subject_teacher", "teacher_id,id,(select name from employee where id=teacher_id) as tec_name", "subject_id=$subj and class_id=$s_class and section_id=$s_sec and status=1");
//                    $this->data['tchr_nam'][$j] = '(' . $sub_teachr[0]->tec_name . ')';
//                }
//                $j++;
//            }
//
//
//            foreach ($subject as $row) {
//                $sub = $row->subject_id;
//                if ($row->subject_id == 0) {
//                    
//                } else {
//                    $this->data['subject'][$i] = $this->dbconnection->Get_namme("subject", "id", "$sub", "name");
//                    $sub_teacher = $this->dbconnection->select("class_subject_teacher", "teacher_id,id,(select name from employee where id=teacher_id) as teac_name", "subject_id=$sub and class_id=$s_class and section_id=$s_sec and status=1");
//                    $this->data['tchr_nm'][$i] = $sub_teacher[0]->teac_name;
//                }
//                $i++;
//            }
//
//            $fee_info = $this->dbconnection->select("fee_transaction_head", "max(id) as id,total_amount,payment_date", "paid_status=1 and response_code=0 and student_id=" . $stud_info[0]->id);
//            $cnt_sub = count($subject);
//            $fee_date1 = date("d-m-y", strtotime($fee_info[0]->payment_date));
//
//
//            $this->data['sub_cnt'] = $cnt_sub;
//            $this->data['student_name'] = $stud_info[0]->name;
//            $this->data['sec'] = $stud_info[0]->sec;
//            $this->data['clas'] = $stud_info[0]->cls;
//            $this->data['dob'] = $stud_info[0]->dob;
//            $this->data['contact'] = $stud_info[0]->phone;
//            $this->data['father'] = $stud_info[0]->father_name;
//            $this->data['mother'] = $stud_info[0]->mother_name;
//            $this->data['addrs'] = $stud_info[0]->address;
//            $this->data['email'] = $stud_info[0]->email_address;
//            $this->data['adm'] = $stud_info[0]->admission_no;
//            $this->data['teacher'] = $teacher_name;
//            $this->data['teacher_contact'] = $class_teacher[0]->phone_no;
//            $this->data['email'] = $class_teacher[0]->email;
//            $this->data['fee_amnt'] = $fee_info[0]->total_amount;
//            $this->data['fee_date'] = $fee_date1;
//            $this->data['day'] = $day1;
//            $this->data['period'] = count($routine);
//            
//            $this->page_title = 'Dashboard';
//            $this->section = 'dashboard';
//            $this->page_name = 'student_dashboard';
//            $this->customview = '';
//            
//    }

    
	public function result_graph() {
		$date	= date('Y-m-d');
		$mon 	= date('m', strtotime($date));
		$end 	= date('Y-m-d', strtotime($date . ' +1 year'));
		$curr 	= $date;
		$user 	= $this->session->userdata('user_name');
		$admsn 	= explode('-', $user);
		$date 	= new DateTime('last day of this month');
		$numDaysOfCurrentMonth = $date->format('d');

		$attendance = $this->dbconnection->select("student_attendance", "count(id) as cnt", "attendance='P' and MONTH(date)='$mon' and admission_no='$admsn[1]'");
		$present = $attendance[0]->cnt;
		$absent = $numDaysOfCurrentMonth - $present;

		$responce->cols[] = array(
								"id" => 'A',
								"label" => "Topping",
								"pattern" => "",
								"type" => "string"
							);
		$responce->cols[] = array(
								"id" => 'B',
								"label" => "Total",
								"pattern" => "",
								"type" => "number"
							);

		$responce->rows[]["c"] = array(
									array(
										"v" => "Total Present",
										"f" => null
									),
									array(
										"v" => 3.33 * $present,
										"f" => null
									)
								);

		$responce->rows[]["c"] = array(
									array(
										"v" => "Total Absent",
										"f" => null
									),
									array(
										"v" => 3.33 * $absent,
										"f" => null
									)
								);

		echo json_encode($responce);
	}

    public function change_password() {
        $user_id = $this->session->userdata('user_id');
        $password = $_POST['change_password'];

        $salt = $this->generateRandomString();
        $encryption = $this->dbconnection->select('encrypt', '*');
        $value = rand(0, count($encryption) - 1);
        $encryption_id = $encryption[$value]->id;
        $encryption_type = $encryption[$value]->encryption_type;

        $password = $encryption_type($password . $salt);

        $data = array(
            'password' => $password,
            'salt' => $salt,
            'encrypt_id' => $encryption_id,
            'change_password' => 1,
            'last_date_modified' => date('Y-m-d H:i:s'),
            'last_modified_by' => $this->session->userdata('user_id')
        );
        $user = $this->dbconnection->update('user', $data, 'id =' . $user_id);
        header("Location: " . site_url("dashboard"));
    }

    public function generateRandomString($length = 25) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    private function school_dashboard() {
            $count = 0;
            $count_reg = 0;
//            $this->benchmark->mark('query1');
            $name = explode("-", $this->session->userdata('user_name'));
            $usr_nm = $name[1];
//            $this->benchmark->mark('query1end');
//            echo 'query1 time='.$this->benchmark->elapsed_time('query1', 'query1end').' <html><br></html>';
            $this->data[$this->session->userdata('login_type') . '_message'] = 0;
            $this->data['school1'] = $this->school1;
            $this->data['school_name'] = $this->data['school1'][0]->description;
            $this->data['school_address'] = $this->data['school1'][0]->address;

           $this->data['tot_stud'] = $this->dbconnection->select("student", "count(if(status='Y',1,NULL)) as students,COUNT(IF(registered_status='1' and status='Y',1, NULL)) 'registered',COUNT(IF(registered_status='1' and status='P',1, NULL)) 'pending'", " status='Y' or status='P'");
            $this->data['total_students'] = $this->data['tot_stud'][0]->students;

//            $this->data['tot_stud_reg'] = $this->dbconnection->select("student", "count(admission_no) as students_reg", "status='Y' and registered_status=1");
            $this->data['total_registered'] = $this->data['tot_stud'][0]->registered;
//            $this->benchmark->mark('query3end');
//            echo 'query3end time='.$this->benchmark->elapsed_time('query2end', 'query3end').' <html><br></html>';

            $date = date("Y-m");
            $month_year=explode('-',$date);
            $month=$month_year[1];
//            echo $month;
            $school=array();            
            $school['online']=array();
            $school['offline']=array();
            $school['total']=array();
            $school['online_cnt']=array();
            $school['offline_cnt']=array();
            $school['success_payment_cnt']=array();
            $school['failure_payment_cnt']=array();
            $school['visiting_payment_cnt']=array();
            $school['halfsuccess_payment_cnt']=array();
            $school['mon']=date('F',strtotime($date));

               if($month>=1 and $month<=3)
                {
                    $new_month=$month+9;
                    $yearmn1= $this->session_end_yr;
                }
                else
                { 
                    $new_month=$month-3;
                    $yearmn1= $this->session_start_yr;
                }
                
                if($this->session->userdata('school_id')!=9){
                    $strquery3="";
                } else{
                    $strquery3=" and ( mode!='NB' or (mode='NB' and payment_date<'2017-04-24 00:00:00'))";
                }
                $school['mnth']=$new_month;
                $arr=array('1'=>4,'2'=>5, '3'=>6, '4'=>7, '5'=>8, '6'=>9, '7'=>10, '8'=>11, '9'=>12, '10'=>1, '11'=>2, '12'=>3);
                $yearquery=!empty($this->academic_session)? "year={$this->academic_session[0]->fin_year} and ":'';

                for($i=1; $i<=$new_month; $i++)
                {         
                    
                    $yearmn=($i >= 1 && $i <= 9)?$this->session_start_yr:$this->session_end_yr;

//                     $amount=$this->dbconnection->select("fee_transaction_head","count(id) as on_cnt, sum(total_amount) as amnt", "$yearquery Month(payment_date)=$arr[$i] and Year(payment_date)=$yearmn and collection_centre='FCLB' and response_code=0 and paid_status=1 $strquery3");                     
//                     $school['online'][$i]=$this->session->userdata('school_id')!=9 ? $amount[0]->amnt :'';
//                     $school['online'][$i]=$amount[0]->amnt;
                     $school['online'][$i]=0;
//                     $this->benchmark->mark("query4end");
//                    echo 'query4end time='.$this->benchmark->elapsed_time('query3end', "query4end").' <html><br></html>';
                    
//                     $amount1=$this->dbconnection->select("fee_transaction_head","count(id) as off_cnt, sum(total_amount) as amt", "$yearquery Month(payment_date)=$arr[$i] and Year(payment_date)=$yearmn and collection_centre!='FCLB' and response_code=0 and paid_status=1");
//                     $school['offline'][$i]=$amount1[0]->amt;
//                     $school['total'][$i]=($amount[0]->amnt+$amount1[0]->amt);
                     $school['offline'][$i]=0;
                     $school['total'][$i]=0;
//                     $this->benchmark->mark("query5end");
//                    echo 'query5end time='.$this->benchmark->elapsed_time('query4end', "query5end").' <html><br></html>';
//                     $school['online_cnt'][$i]=$this->session->userdata('school_id')!=9 ? $amount[0]->on_cnt:'';
//                     $school['online_cnt'][$i]=$amount[0]->on_cnt;
//                     $school['offline_cnt'][$i]=$amount1[0]->off_cnt;         
                     $school['online_cnt'][$i]=0;
                     $school['offline_cnt'][$i]=0;
                     
//                     $payment_analytics=$this->db->query("SELECT count(scount) success_count, count(fcount) failure_count, count(gcount) visiting_count,count(halfcount) hcount FROM ( SELECT  CASE WHEN response_code=0 THEN 1 ELSE NULL END scount,   CASE WHEN response_code=2  THEN 1 ELSE NULL END  fcount,  CASE WHEN response_code=1  THEN 1 ELSE NULL END  gcount,CASE WHEN response_code=0 and response_status=0 THEN 1 ELSE NULL END  halfcount from fee_transaction_head where $yearquery MONTH(payment_date)=$arr[$i] and Year(payment_date)=$yearmn and collection_centre='FCLB') t");
//                     $payment_analytics=$payment_analytics->result();
//                     $school['success_payment_cnt'][$i]=$payment_analytics[0]->success_count;
//                     $school['failure_payment_cnt'][$i]=$payment_analytics[0]->failure_count;
//                     $school['visiting_payment_cnt'][$i]=$payment_analytics[0]->visiting_count;
//                     $school['halfsuccess_payment_cnt'][$i]=$payment_analytics[0]->hcount;
                     $school['success_payment_cnt'][$i]=0;
                     $school['failure_payment_cnt'][$i]=0;
                     $school['visiting_payment_cnt'][$i]=0;
                     $school['halfsuccess_payment_cnt'][$i]=0;
                }
                
                
                $tot_stud1=$this->data['total_students'];
                $ayearquery=!empty($this->academic_session)? " and f1.year={$this->academic_session[0]->fin_year}":'';

                
//                $annual_defaulter = $this->db->query("select if(count(f1.id)=0,'Unpaid','Paid') as annual,s.id from student as s"
//                    . " left join ( fee_transaction_head as f1 inner join fee_transaction_det d1 on f1.id=d1.fee_trans_head_id and d1.fee_cat_id=1)"
//                    . " on f1.student_id=s.id and f1.paid_status=1 $ayearquery"
//                    
//                    . " where s.status='Y' group by s.id having ( annual!='Paid')");
             
                $byearquery=!empty($this->academic_session)? " and f2.year={$this->academic_session[0]->fin_year}":'';

//                $monthly_defaulter = $this->db->query("select if(count(d2.month_no)>=$new_month"
//                    . " ,'Paid',concat(cast($new_month-count(d2.month_no) as char),' months Unpaid')) as monthly from student as s"
//                    . " left join ( fee_transaction_head as f2 inner join fee_transaction_det d2 on f2.id=d2.fee_trans_head_id and d2.fee_cat_id=2)"
//                    . " on f2.student_id=s.id and f2.paid_status=1 $byearquery and f2.response_code=0 where s.status='Y' group by s.id having ( monthly!='Paid')");

//            echo $query_defaulter->num_rows();
//                $this->benchmark->mark("query6end");
//                echo 'query6end time='.$this->benchmark->elapsed_time('query5end', "query6end").' <html><br></html>';
//                $ann_cnt=0;
//                $ann=$this->dbconnection->select("fee_transaction_head","distinct(student_id) as stud","paid_status=1 and response_code=0");
//                $this->benchmark->mark("query7end");
//                echo 'query7end time='.$this->benchmark->elapsed_time('query6end', "query7end").' <html><br></html>';
//                foreach($ann as $row)
//                {
//                    $fee_head=$this->dbconnection->select("fee_transaction_head","id","student_id=$row->stud");
////                    $this->benchmark->mark("query8end");
////                    echo 'query8end time='.$this->benchmark->elapsed_time('query7end', "query8end").' <html><br></html>';
//                    $fee_det=$this->dbconnection->select("fee_transaction_det","id","fee_cat_id=1 and fee_trans_head_id=".$fee_head[0]->id);
////                    $this->benchmark->mark("query9end");
////                    echo 'query9end time='.$this->benchmark->elapsed_time('query8end', "query9end").' <html><br></html>';
//                    if(count($fee_det)>=1)
//                    {
//                        ++$ann_cnt;
//                    }
//                }
                
//               $annual=($tot_stud1)-$ann_cnt;
//               $school['defaulter_ann']=$annual_defaulter->num_rows();       
               $school['defaulter_ann']=0;       
               $cls=$this->dbconnection->select("class","id,class_name","status='Y'");
//               $this->benchmark->mark("query10end");
//               echo 'query10end time='.$this->benchmark->elapsed_time('query9end', "query10end").' <html><br></html>';
               $tot_def=0;
               $tot_mon_def=0;
               $tot_stud1=0;
               foreach($cls as $row)
               {
                   $def_cnt=0; $def=0; $ann_fee_def=0;
//                   $total_cl_stud= $this->dbconnection->select("student","count(admission_no) as students","status='Y' and class_id=$row->id");
                   $school['class'][$row->class_name]['total_class_student']=0;                       
//                   $amount=$this->dbconnection->select("fee_transaction_head","sum(total_amount) as amnt, count(id) as on_cnt", "response_code=0 and paid_status=1 and $yearquery MONTH(payment_date)='$month' and Year(payment_date)=$yearmn and collection_centre='FCLB' $strquery3 and student_id in(select id from student where class_id=$row->id)");
//                   $school['class'][$row->class_name]['online_amnt']=$this->session->userdata('school_id')!=9 ? $amount[0]->amnt:'';
                   $school['class'][$row->class_name]['online_amnt']=0;
//                   $school['class'][$row->class_name]['online_cunt']=$this->session->userdata('school_id')!=9 ? $amount[0]->on_cnt:'';
                   $school['class'][$row->class_name]['online_cunt']=0;
//                   $amount1=$this->dbconnection->select("fee_transaction_head","sum(total_amount) as amt, count(id) as off_cnt", "response_code=0 and paid_status=1 and $yearquery  MONTH(payment_date)='$month' and Year(payment_date)=$yearmn and collection_centre!='FCLB' and student_id in(select id from student where class_id=$row->id)");
                   $school['class'][$row->class_name]['offline_amnt']=0; 
                   $school['class'][$row->class_name]['offline_cunt']=0;

//                    $class_annual_defaulter = $this->db->query("select if(count(f1.id)=0,'Unpaid','Paid') as annual,s.id from student as s"
//                    . " left join ( fee_transaction_head as f1 inner join fee_transaction_det d1 on f1.id=d1.fee_trans_head_id and d1.fee_cat_id=1)"
//                    . " on f1.student_id=s.id and f1.paid_status=1 $ayearquery"
//                    
//                    . " where s.status='Y' and s.class_id={$row->id} group by s.id having ( annual!='Paid')");
             
//                    $class_monthly_defaulter = $this->db->query("select if(count(d2.month_no)>=$new_month"
//                        . " ,'Paid',concat(cast($new_month-count(d2.month_no) as char),' months Unpaid')) as monthly from student as s"
//                        . " left join ( fee_transaction_head as f2 inner join fee_transaction_det d2 on f2.id=d2.fee_trans_head_id and d2.fee_cat_id=2)"
//                        . " on f2.student_id=s.id and f2.paid_status=1 $byearquery and f2.response_code=0 where s.status='Y' and s.class_id={$row->id} group by s.id having ( monthly!='Paid')");
//                   $stud_cnt=$this->dbconnection->select("student","id","id in(select student_id from fee_transaction_head where paid_status=1 and response_code=0) and class_id=$row->id");
//                   $stud=0;
//                   foreach($stud_cnt as $s)
//                   {   
////                       ++$stud;
//                       $fee_det=$this->dbconnection->select("fee_transaction_det","count(month_no) as mon","fee_cat_id=2 and fee_trans_head_id in(select id from fee_transaction_head where student_id=$s->id)");
//                       $fee_det_ann=$this->dbconnection->select("fee_transaction_det","id","fee_cat_id=1 and fee_trans_head_id in(select id from fee_transaction_head where student_id=$s->id)");
//                       if($fee_det[0]->mon<=$new_month)
//                       {
//                           ++$def;
//                       }
//                       
//                       if(count($fee_det_ann)>=1)
//                       {
//                           ++$ann_fee_def;
//                       }
//                   }
//                   $stud_cnt1=($total_cl_stud[0]->students-count($stud_cnt));                  
//                   $tot_def=$stud_cnt1+$def;
//                   $tot_ann_def=$total_cl_stud[0]->students-$ann_fee_def;
//                   echo $tot_def;
//                   echo $def.'<br>';
//                   $school['class'][$row->class_name]['defaulter']=$total_cl_stud[0]->students-($amount[0]->on_cnt+$amount1[0]->off_cnt);
//                   $school['class'][$row->class_name]['defaulter']=$class_monthly_defaulter->num_rows();
//                   $school['class'][$row->class_name]['ann1_defaulter']=$class_annual_defaulter->num_rows();
                   $school['class'][$row->class_name]['defaulter']=0;
                   $school['class'][$row->class_name]['ann1_defaulter']=0;
                  
               }        
               
//               $school['defaulter_mon']=$monthly_defaulter->num_rows();                
               $school['defaulter_mon']=0;                
               $this->data['school']= $school;
            
            
            
            $this->page_title = 'Dashboard';
            $this->data['user_name'] = $usr_nm;
            $this->section = 'dashboard';
            $this->page_name = 'school_dashboard';
            $this->customview = '';

    }


    public function govt_dashboard() {

        // print_r($_SESSION);
//                error_reporting(-1);
//      ini_set('display_errors', 1);
            $count = 0;
            $count_reg = 0;
//            $user_nam = $this->dbconnection->select("user", "user_name", "id=" . $this->session->userdata('user_id'));
//
//            $nm = $user_nam[0]->user_name;
            $name = explode("-", $this->session->userdata('user_name'));
            $usr_nm = $name[1];
            
            $this->data[$this->session->userdata('login_type') . '_message'] = 0;
            $this->data['school1'] = $this->school1;
            $this->data['school_name'] = $this->data['school1'][0]->description;
            $this->data['school_address'] = $this->data['school1'][0]->address;

            $this->data['tot_stud'] = $this->dbconnection->select("student", "count(if(status='Y',1,NULL)) as students,COUNT(IF(registered_status='1' and status='Y',1, NULL)) 'registered',COUNT(IF(registered_status='1' and status='P',1, NULL)) 'pending'", " status='Y' or status='P'");
            $this->data['total_students'] = $this->data['tot_stud'][0]->students;

//            $this->data['tot_stud_reg'] = $this->dbconnection->select("student", "count(admission_no) as students_reg", "status='Y' and registered_status=1");
            $this->data['total_registered'] = $this->data['tot_stud'][0]->registered;

//            $this->data['tot_stud_pending'] = $this->dbconnection->select("student", "count(admission_no) as students_pending", "status='P' and registered_status=1");
            $this->data['total_pending'] = $this->data['tot_stud'][0]->pending;


            $date = date("Y-m");
            $month_year=explode('-',$date);
            $month=$month_year[1];
//            echo $month;
            $school=array();            
            $school['mon']=date('F',strtotime($date));

               if($month>=1 and $month<=3)
                {
                    $new_month=$month+9;
                    $yearmn1= $this->session_end_yr;
                }
                else
                { 
                    $new_month=$month-3;
                    $yearmn1= $this->session_start_yr;
                }
                
                if($this->session->userdata('school_id')!=9){
                    $strquery3="";
                } else{
                    $strquery3=" and ( mode!='NB' or (mode='NB' and payment_date<'2017-04-24 00:00:00'))";
                }
                
                $school['mnth']=$new_month;
                $school['session_start_yr']=$this->session_start_yr;
                $school['session_end_yr']=$this->session_end_yr;
                $arr=array('1'=>4,'2'=>5, '3'=>6, '4'=>7, '5'=>8, '6'=>9, '7'=>10, '8'=>11, '9'=>12, '10'=>1, '11'=>2, '12'=>3);
                $yearquery=!empty($this->academic_session)? "year={$this->academic_session[0]->fin_year} and ":'';
                $school['yearquery']=$yearquery;
                $school['strquery3']=$strquery3;

                $ayearquery=!empty($this->academic_session)? " and f1.year={$this->academic_session[0]->fin_year}":'';

             
                $byearquery=!empty($this->academic_session)? " and f2.year={$this->academic_session[0]->fin_year}":'';
   
               $school['defaulter_ann']=0;      
      
//               $cls=$this->dbconnection->select("class","id,class_name","status='Y'");
               $tot_def=0;
               $tot_mon_def=0;
               $tot_stud1=0;
              
               $school['defaulter_mon']=0;                
                              
               $this->data['school']= $school;
            
            
            
            $this->page_title = 'Dashboard';
            $this->data['user_name'] = $usr_nm;
            $this->section = 'dashboard';
            $this->page_name = 'govt_dashboard';
            $this->customview = '';
            
    }



    public function admin_dashboard() {
            // error_reporting(-1);
            // ini_set('display_errors', 1);
            // $this->db->db_debug=TRUE;
            $count = 0;
            $count_reg = 0;
            $name = explode("-", $this->session->userdata('user_name'));
            $usr_nm = $name[1];
            
            $this->data[$this->session->userdata('login_type') . '_message'] = 0;
            $this->data['school1'] = $this->school1;
            $this->data['school_name'] = $this->data['school1'][0]->description;
            $this->data['school_address'] = $this->data['school1'][0]->address;
            $this->data['tot_stud'] = $this->dbconnection->select("student", "count(if(status='Y',1,NULL)) as students,COUNT(IF(registered_status='1' and status='Y',1, NULL)) 'registered',COUNT(IF(registered_status='1' and status='P',1, NULL)) 'pending'", " status='Y' or status='P'");
            $this->data['total_students'] = $this->data['tot_stud'][0]->students;
            $this->data['total_registered'] = $this->data['tot_stud'][0]->registered;
            $this->data['total_pending'] = $this->data['tot_stud'][0]->pending;
             $this->previousSessionID;
           $tot_active_stu = $this->dbconnection->select('student','count(id) as tot_active',"status='Y' and student_academicyear_id=".$this->academic_session[0]->fin_year);
             // print_r($tot_active_stu);
           $this->data['total_active_student']=$tot_active_stu[0]->tot_active;
           $this->data['tot_pre_stu'] = $this->dbconnection->select('student','count(id) as tot_prev','status="Y" and student_academicyear_id='.$this->previousSessionID);
            $this->data['total_prev_student']=$this->data['tot_pre_stu'][0]->tot_prev;
            if($this->session->userdata('school_id')==8)
            {
                $date = date("Y-m-d");
            $d = date_parse_from_format("Y-m-d", $date);
            $mon=$d["month"];
             $day=$d["day"];

            // echo $d = date("Y-m-d");
            // $mon=$d["month"];
            // $day=$d["day"];
            $this->data['attendance_data']=$this->db->query("select sh.id,sh.class_id,(select class_name from class where id=sh.class_id) as class_name,sh.section_id,(select sec_name from section where id=sh.section_id) as section_name,sh.sms,sh.month,sd.atten_date from stud_mnthly_att_head sh,stud_mnthly_att_detail sd where sh.id=sd.mnthly_att_head_id and sh.status='Y'and sh.month='$mon' and sd.atten_date='$day' group by sd.atten_date")->result();
            // echo $this->db->last_query();
            // print_r($this->data['attendance_data']);
            // die();
            }
           
            $date = date("Y-m");
            $month_year=explode('-',$date);
            $month=$month_year[1];
            $school=array();            
            $school['mon']=date('F',strtotime($date));

            if($month>=1 and $month<=3)
            {
                $new_month=$month+9;
                $yearmn1= $this->session_end_yr;
            }
            else
            { 
                $new_month=$month-3;
                $yearmn1= $this->session_start_yr;
            }
            if($this->session->userdata('school_id')!=9)
            {
                $strquery3="";
            } else
            {
                $strquery3=" and ( mode!='NB' or (mode='NB' and payment_date<'2017-04-24 00:00:00'))";
            }
                
            $school['mnth']=$new_month;
            $school['session_start_yr']=$this->session_start_yr;
            $school['session_end_yr']=$this->session_end_yr;
            $arr=array('1'=>4,'2'=>5, '3'=>6, '4'=>7, '5'=>8, '6'=>9, '7'=>10, '8'=>11, '9'=>12, '10'=>1, '11'=>2, '12'=>3);
            $yearquery=!empty($this->academic_session)? "year={$this->academic_session[0]->fin_year} and ":'';
            $school['yearquery']=$yearquery;
            $school['strquery3']=$strquery3;
            // $ayearquery=!empty($this->academic_session)? " and f1.year={$this->academic_session[0]->fin_year}":'';
            // $annual_defaulter = $this->db->query("select if(count(f1.id)=0,'Unpaid','Paid') as annual,s.id from student as s"
            //        . " left join ( fee_transaction_head as f1 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d1 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f1.id=d1.fee_trans_head_id and d1.fee_cat_id=1 $ayearquery)"
            //        . " on f1.student_id=s.id and f1.paid_status=1 "
                   
            //        . " where s.status='Y' group by s.id having ( annual!='Paid')");
             
            // $byearquery=!empty($this->academic_session)? " and f2.year={$this->academic_session[0]->fin_year}":'';

            // $monthly_defaulter = $this->db->query("select if(count(d2.month_no)>=$new_month"
            //        . " ,'Paid',concat(cast($new_month-count(d2.month_no) as char),' months Unpaid')) as monthly from student as s"
            //        . " left join ( fee_transaction_head as f2 USE INDEX FOR JOIN (student_id,year_indx) inner join fee_transaction_det d2 USE INDEX FOR JOIN (fee_trans_head_id,fee_cat_id_indx) on f2.id=d2.fee_trans_head_id and d2.fee_cat_id=2 $byearquery)"
            //        . " on f2.student_id=s.id and f2.paid_status=1 and f2.response_code=0 where s.status='Y'  group by s.id having ( monthly!='Paid')");
            // $ann_cnt=0;
            // $ann=$this->dbconnection->select("fee_transaction_head","distinct(student_id) as stud","paid_status=1 and response_code=0");
            // foreach($ann as $row)
            // {
            //     $fee_head=$this->dbconnection->select("fee_transaction_head","id","student_id=$row->stud");
            //     $fee_det=$this->dbconnection->select("fee_transaction_det","id","fee_cat_id=1 and fee_trans_head_id=".$fee_head[0]->id);
            //     if(count($fee_det)>=1)
            //     {
            //         ++$ann_cnt;
            //     }
            // }
               
            // $annual=($tot_stud1[0]->stud)-$ann_cnt;
            $school['defaulter_ann']=0;      
            // $school['defaulter_ann']=$annual_defaulter->num_rows();      

            $tot_def=0;
            $tot_mon_def=0;
            $tot_stud1=0;
            // foreach($cls as $row)
            // {
            //     $def_cnt=0; $def=0; $ann_fee_def=0;
            //     $total_cl_stud= $this->dbconnection->select("student","count(admission_no) as students","status='Y' and class_id=$row->id");
            //     $school['class'][$row->class_name]['total_class_student']=$total_cl_stud[0]->students;                       
            //     $amount=$this->dbconnection->select("fee_transaction_head","sum(total_amount) as amnt, count(id) as on_cnt", "response_code=0 and paid_status=1 and $yearquery MONTH(payment_date)='$month' and Year(payment_date)=$yearmn1 and collection_centre='FCLB' $strquery3 and student_id in(select id from student where class_id=$row->id)");
            //     $school['class'][$row->class_name]['online_amnt']=$amount[0]->amnt;
            //     $school['class'][$row->class_name]['online_cunt']=$amount[0]->on_cnt;
            //     $amount1=$this->dbconnection->select("fee_transaction_head","sum(total_amount) as amt, count(id) as off_cnt", "response_code=0 and paid_status=1 and $yearquery MONTH(payment_date)='$month' and Year(payment_date)=$yearmn1 and collection_centre!='FCLB' and student_id in(select id from student where class_id=$row->id)");
            //     $school['class'][$row->class_name]['offline_amnt']=$amount1[0]->amt; 
            //     $school['class'][$row->class_name]['offline_cunt']=$amount1[0]->off_cnt;
            //     $class_annual_defaulter = $this->db->query("select if(count(f1.id)=0,'Unpaid','Paid') as annual,s.id from student as s"
            //            . " left join ( fee_transaction_head as f1 inner join fee_transaction_det d1 on f1.id=d1.fee_trans_head_id and d1.fee_cat_id=1)"
            //            . " on f1.student_id=s.id and f1.paid_status=1 $ayearquery"

            //            . " where s.status='Y' and s.class_id={$row->id} group by s.id having ( annual!='Paid')");
            
            //     $class_monthly_defaulter = $this->db->query("select if(count(d2.month_no)>=$new_month"
            //            . " ,'Paid',concat(cast($new_month-count(d2.month_no) as char),' months Unpaid')) as monthly from student as s"
            //            . " left join ( fee_transaction_head as f2 inner join fee_transaction_det d2 on f2.id=d2.fee_trans_head_id and d2.fee_cat_id=2)"
            //            . " on f2.student_id=s.id and f2.paid_status=1 $byearquery and f2.response_code=0 where s.status='Y' and s.class_id={$row->id} group by s.id having ( monthly!='Paid')");
            //     $school['class'][$row->class_name]['defaulter']=$class_monthly_defaulter->num_rows();
            //     $school['class'][$row->class_name]['ann1_defaulter']=$class_annual_defaulter->num_rows();
            // }        

            /*----------------------------------FEE PROJECTTION---------------------------------------*/

            if ($month >= 4 && $month <= 12) {
                $month1 = $month - 3;
                $yearmn = $this->session_start_yr;
            } else if ($month >= 1 && $month <= 3) {
                $month1 = $month + 9;
                $yearmn = $this->session_end_yr;
            }
        //     $class = array();
        //     $section = array();
        //     $strength = array();
        //     $estimated = array();
        //     $collected = array();
        //     $class_qry = $this->dbconnection->select("class", "id, class_name", "status='Y'");
        //     $category_qry = $this->dbconnection->select("category", "*", "status='Y'");
        //     $acourse = $this->dbconnection->select("course", "*", "status='Y'");
        //     $i = 0;
        //     $j = 0;
        //     $sum_estimated = 0;
        //     $cntj = array();
        //     foreach ($class_qry as $cls) {
        //         $section_qry = $this->dbconnection->select("student", "distinct(section_id) as sec_id , (select sec_name from section where id = sec_id) as section_name", "class_id=$cls->id");
        //         foreach ($section_qry as $sec) {
        //             $s1 = 0;
        //             $class[$i][$j] = $cls->class_name;
        //             $section[$i][$j] = $sec->section_name;
        //             $sum_stregth = 0;
        //             $sum_estimated = 0;
        //         foreach ($category_qry as $cat)
        //         {
        //             $strength_qry = $this->dbconnection->select("student", "count(id) as count_stud", "class_id=$cls->id and section_id=$sec->sec_id and stud_category=$cat->id and status='Y'");
        //             $sum_stregth = $sum_stregth + $strength_qry[0]->count_stud;
                    
        //             $max_year_classfee = $this->dbconnection->select('class_fee_head', 'max(year) as max_year', "(from_class_id<=$cls->id and to_class_id>=$cls->id) and status='Y' and year<=$this->session_start_yr");
        //             $estimated_qry = $this->dbconnection->select("class_fee_head", "id,course", "from_class_id<=$cls->id and to_class_id>=$cls->id and status='Y' and year={$max_year_classfee[0]->max_year}");

        //             if (count($estimated_qry) > 1) 
        //             {
        //                 foreach ($estimated_qry as $crse) {

        //                     $strength_qry_coursewise = $this->dbconnection->select("student", "count(id) as count_course_stud", "class_id=$cls->id and section_id=$sec->sec_id and stud_category=$cat->id and course_id=$crse->course and status='Y'");
                            
        //                     $fetch_class_fee = $this->dbconnection->select("class_fee_det", "sum(fee_amount) total_fee", "class_fee_head_id=" . $crse->id . " and stud_cat=$cat->id and fee_cat in (2,5) and status=1");

        //                     $amount_estimated = $fetch_class_fee[0]->total_fee;
        //                     $sum_estimated = $sum_estimated + ($amount_estimated * $strength_qry_coursewise[0]->count_course_stud);

        //                 }
        //             } else
        //             {
        //                 $fetch_class_fee = $this->dbconnection->select("class_fee_det", "sum(fee_amount) total_fee1", "class_fee_head_id=" . $estimated_qry[0]->id . " and stud_cat=$cat->id and fee_cat in (2,5) and status=1");
        //                 $amount_estimated = $fetch_class_fee[0]->total_fee1;
        //                 $sum_estimated = $sum_estimated + ($amount_estimated * $strength_qry[0]->count_stud);
                         
        //             }
        //         }
        //         $strength[$i][$j] = $sum_stregth;
        //         $estimated[$i][$j] = $sum_estimated ;
        //         $stud = $this->dbconnection->select("(select id from fee_transaction_head where student_id in (select id from student where class_id=$cls->id and section_id=$sec->sec_id) and year={$this->academic_session[0]->fin_year} and Year(payment_date)=$yearmn) a", "*", "");

                
        //             foreach ($stud as $row) 
        //             {
        //                 $collected_qry = array();
        //                 $collected_qry = $this->dbconnection->select("fee_transaction_det", "sum(amount) as monthly, count(month_no) as mon", "fee_trans_head_id=$row->id and fee_cat_id in (2,5)");
                        
        //                 $collect = $collected_qry[0]->monthly;
        //                 $mnth_no = $collected_qry[0]->mon;
                        
        //                 if ($this->schoolgrp =="ARMY")
        //                 {
        //                     if ($mnth_no != '' && $mnth_no = $month1) {
        //                         $s = $collect / $mnth_no;
        //                     }
        //                     else if ($mnth_no != '' && $mnth_no <= $month1) {
        //                         $s = $collect;
        //                     }
        //                     else {
        //                         $s = 0;
        //                     }
        //                  $s1 = $s1 + $s;
        //                 }
        //                 else
        //                 {
        //                     if ($mnth_no != '' && $mnth_no >= $month1) 
        //                     {
        //                         $s = $collect / $mnth_no;
        //                     }
        //                     else
        //                     {
        //                         $s = 0;
        //                     }
        //                     $s1 = $s1 + $s;
        //                 }
                    
        //             }
        //             $collected[$i][$j] = $s1;
        //             $balance[$i][$j] = $estimated[$i][$j] - $collected[$i][$j] . ' INR';
        //             $balanc= $sum_estimated - $s1 ;
        //             $j++;
        //     }
        //     $cntj[$i] = $j;
        //     $j = 0;
        //     $i++;
        // }
            /*----------------------------------FEE PROJECTTION---------------------------------------*/
               
            $school['defaulter_mon']=0;    
            // $school['defaulter_mon']=$monthly_defaulter->num_rows();    

            $data['strength'] = $strength;
            $data['estimated'] = $sum_estimated;
            $data['collected'] = $s1;
            $data['balance'] = $balanc;
            $data['mnth'] = $mnth_name;               
                              
            $this->data['school']= $school;
            $this->data['pro_data']= $data;
            $this->page_title = 'Dashboard';
            $this->data['user_name'] = $usr_nm;
            $this->section = 'dashboard';
            $this->page_name = 'admin_dashboard_final';
            $this->customview = '';

            // $this->data['page_name'] = $this->page_name;
            // $this->data['page_title'] = $this->page_title;
            // $this->data['section'] = $this->section;
            // $this->data['customview'] = $this->customview;

            // $this->load->view('index', $this->data);

           
            
    }

        public function student_dashboard() {
        // error_reporting(-1);
        // ini_set('display_errors', 1);
            $usr_name = explode("-", $this->session->userdata('user_name'));

            $stud_info = $this->dbconnection->select("student", "id,CONCAT(first_name,' ',middle_name,' ',last_name) as name, email_address, admission_no, father_name, mother_name, address, dob, phone, class_id,(select class_name from class where id=class_id) as cls, section_id, (select sec_name from section where id=section_id) as sec, (select course_name from course where id=course_id) as course_name,(select cat_name from category where id=stud_category) as stud_cat", "admission_no='$usr_name[1]' and status='Y'");
            $this->data['school1'] = $this->school1;
            if(empty($stud_info))
                redirect('/login');
            
            $s_name = $stud_info[0]->name;
            $s_class = $stud_info[0]->class_id;
            $s_sec = $stud_info[0]->section_id;
            $s_id = $stud_info[0]->id;
            

            // $class_teacher = $this->dbconnection->select("employee", "*", "id=(select teacher_id from class_teachet_alloc where class_id=$s_class and section_id=$s_sec and status=1)");
            // if($this->session->userdata('school_id')==8){
                 $video_tutorial = $this->db->query('select t1.id,t1.class_id,(select class_name from class where id=t1.class_id) as class_name,t1.subject_id,(select name from subject where id=t1.subject_id) as subject_name,t1.video_url,t1.title,t1.image_video,t1.lesson_date from video_tutorial t1 where t1.status="Y" and t1.class_id='.$s_class)->result();
                 // print_r($tutorial);
           if(!empty($video_tutorial))
           {
            $this->data['tutorial']=$video_tutorial;
           }
           // print_r($this->data['tutorial']);
           // die();
            // }
          
           
            // $count_ct = count($class_teacher);
            // if($count_ct>0){
            //     $teacher_name = $class_teacher[0]->name;
            //     $this->data['teacher'] = $teacher_name;
            //     $this->data['teacher_contact'] = $class_teacher[0]->phone_no;
            //     $this->data['teacher_email'] = $class_teacher[0]->email;
            // }
            // else{
            //     $teacher_name = 'N/A';
            //     $this->data['teacher'] = $teacher_name;
            //     $this->data['teacher_contact'] = 'N/A';
            //     $this->data['teacher_email'] = 'N/A';
            // }



            $subject = $this->dbconnection->select("class_routine", "distinct(subject_id)", "class_id=$s_class and section_id=$s_sec and status=1");


            $i = 0;
            $j = 0;
            date_default_timezone_set('Asia/Kolkata');
            $t = date('d-m-Y');
            $day1 = date("l", strtotime($t));
            $routine = $this->dbconnection->select("class_routine", "*", "class_id=$s_class and section_id=$s_sec and day LIKE '$day1%' and status=1");
           
            foreach ($routine as $r) 
            {
                $rout_id = $r->id;

            }

            foreach ($subject as $row) 
            {
                $sub = $row->subject_id;
                if ($row->subject_id == 0) 
                {
                    $this->data['subject'][$i] = '';
                    $this->data['tchr_nm'][$i] = '';
                } 
                else 
                {                    
                    $this->data['subject'][$i] = $this->dbconnection->Get_namme("subject", "id", "$sub", "name");
                    $sub_teacher = $this->dbconnection->select("class_subject_teacher", "teacher_id,id,(select name from employee where id=teacher_id) as teac_name", "subject_id=$sub and class_id=$s_class and section_id=$s_sec and status=1");
                    $count_tec = count($sub_teacher);
                    if($count_tec>0)
                    {
                        $this->data['tchr_nm'][$i] = $sub_teacher[0]->teac_name;
                    }
                    else
                    {
                        $this->data['tchr_nm'][$i] ='N/A';
                    }
                }
                $i++;
            }



           $i = 0;
        $k = 0;

        date_default_timezone_set('Asia/Kolkata');
         $t = date('d-m-Y');
         $day1 = date("l", strtotime($t));

        $tot_period = 0;

        $period = $this->dbconnection->select("class_routine", "count(id) as cnt", "class_id=$s_class and section_id=$s_sec and day='Monday' and status=1");
        $tot_period = $period[0]->cnt;

        $period1 = $this->dbconnection->select("class_routine", "count(id) as cnt", "class_id=$s_class and section_id=$s_sec and day='Tuesday' and status=1");
        if ($period1[0]->cnt > $tot_period) {
            $tot_period = $period1[0]->cnt;
        }

        $period2 = $this->dbconnection->select("class_routine", "count(id) as cnt", "class_id=$s_class and section_id=$s_sec and day='Wednesday' and status=1");
        if ($period2[0]->cnt > $tot_period) {
            $tot_period = $period2[0]->cnt;
        }

        $period3 = $this->dbconnection->select("class_routine", "count(id) as cnt", "class_id= $s_class and section_id=$s_sec and day='Thursday' and status=1");
        if ($period3[0]->cnt > $tot_period) {
            $tot_period = $period3[0]->cnt;
        }

        $period4 = $this->dbconnection->select("class_routine", "count(id) as cnt", "class_id=$s_class and section_id=$s_sec and day='Friday' and status=1");
        if ($period4[0]->cnt > $tot_period) {
            $tot_period = $period4[0]->cnt;
        }

        $period5 = $this->dbconnection->select("class_routine", "count(id) as cnt", "class_id=$s_class and section_id=$s_sec and day='Saturday' and status=1");
        if ($period5[0]->cnt > $tot_period) {
            $tot_period = $period5[0]->cnt;
        }

        $day_q = $this->db->query("select day from class_routine where class_id=$s_class and section_id=$s_sec and status=1 group by day having count(id)=$tot_period");
        $day_nm = $day_q->result();
        $day = $day_nm[0]->day;

        $period_cnt = $this->dbconnection->select("class_routine", "*", "class_id=$s_class and section_id=$s_sec and status=1 and day='$day'");
        $period_cnt = $this->db->query("select cr.class_id,cr.section_id,cr.day,cr.period_id,cp.name,cp.time_start,cp.time_start_min,cp.time_end,cp.time_end_min from class_periods cp,class_routine cr where cr.period_id=cp.id and class_id=$s_class and section_id=$s_sec and cr.status=1 and day='$day'")->result();
          // echo '<pre>';
          // print_r($period_cnt); 

        foreach ($period_cnt as $row) {
            $this->data['start'][$k] = $row->time_start;
            $this->data['start_min'][$k] = $row->time_start_min;
            $this->data['end'][$k] = $row->time_end;
            $this->data['end_min'][$k] = $row->time_end_min;
            $k++;
        }

        $i = 0;
        $max_j = 0;
        date_default_timezone_set('Asia/Kolkata');
         $t = date('d-m-Y');
         $day1 = date("l", strtotime($t));
        $day_name = $this->dbconnection->select("class_routine", "distinct(day)", "class_id=$s_class and section_id=$s_sec and status=1");

        foreach ($day_name as $d) {
            $subject = $this->dbconnection->select("class_routine", "*", "class_id=$s_class and section_id=$s_sec and status=1 and day='" . $d->day . "'");
            $j = 0;
            $this->data['day'][$i] = $d->day;

            foreach ($subject as $row) {
                $subj = $row->subject_id;
                if ($row->subject_id == 0) {
                    $this->data['day_subject'][$i][$j] = 'Break';
                    $this->data['tchr_nam'][$i][$j] = '';
                } else {
                    $this->data['day_subject'][$i][$j] = $this->dbconnection->Get_namme("subject", "id", "$subj", "name");
                    $sub_teachr = $this->dbconnection->select("class_subject_teacher", "teacher_id,id,(select name from employee where id=teacher_id) as tec_name", "subject_id=$subj and class_id=$s_class and section_id=$s_sec and status=1");
                    $countsub_tea = count($sub_teachr);
                    if ($countsub_tea > 0) {
                        $this->data['tchr_nam'][$i][$j] = '(' . $sub_teachr[0]->tec_name . ')';
                    } else {
                        $this->data['tchr_nam'][$i][$j] = '(N/A)';
                    }
                }
                $j++;
            }
            if ($j > $max_j)
                $max_j = $j;
            $i++;
        }


        // <!----Todays Routine ---->
        $todaysrou = $this->dbconnection->GetRoutine($s_class, $s_sec, $day1, $t);
        // echo '<pre>';
        // print_r($todaysrou);
                // echo $this->db->last_query();
        //----Todays Routine ----//

        $homework = $this->db->query("SELECT t1.*,t2.class_name,t3.sec_name,t4.name FROM `assignment` as t1 JOIN `class` as t2 ON t2.id=t1.class_id JOIN `section` as t3 ON t3.id=t1.section_id JOIN `subject` as t4 ON t4.id=t1.subject_id  WHERE t1.status=1 and t1.class_id=$s_class and t1.section_id=$s_sec")->result();
        // $homework=$this->db->query('select t1.class_id,t1.section_id,t1.subject_id,t4.name,t1.doa,t1.dos,t1.attachment,t1.description from assignment t1,class t2,section t3,subject t4 where t1.class_id=t2.id and t1.section_id=t3.id and t1.subject_id=t4.id and t1.status=1 and t1.class_id='.$s_class.' and t1.section_id='.$s_sec.'')->result();
        // print_r($homework);

        $todaysbirth=$this->db->query("SELECT s.first_name,s.middle_name,s.last_name,s.class_id,s.section_id,c.class_name,se.sec_name FROM crmfeesclub_8.student s,crmfeesclub_8.class c,crmfeesclub_8.section se WHERE MONTH(s.dob) = MONTH(NOW()) AND DAY(s.dob) = DAY(NOW()) and s.class_id=c.id and s.section_id=se.id and s.id='$s_id'")->result();

        $fee_info = $this->dbconnection->select("fee_transaction_head", "id,total_amount,payment_date", "paid_status=1 and response_code=0 and student_id=" . $stud_info[0]->id,'payment_date','DESC');
        $cnt_sub = count($subject);
        $fee_date1 =  !empty($fee_info)? date("d-M-Y", strtotime($fee_info[0]->payment_date)):'';

        $fee_info = $this->dbconnection->select("fee_transaction_head", "id,total_amount,payment_date", "paid_status=1 and response_code=0 and student_id=" . $stud_info[0]->id,'payment_date','DESC');
        $cnt_sub = count($subject);


        $this->data['sub_cnt'] = $cnt_sub;
        $this->data['student_name'] = $stud_info[0]->name;
        $this->data['sec'] = $stud_info[0]->sec;
        $this->data['clas'] = $stud_info[0]->cls;
        $this->data['course_name'] = $stud_info[0]->course_name;
        $this->data['fee_stud_category'] = $stud_info[0]->stud_cat;
            
        $this->data['class_id'] = $s_class;
        $this->data['sect_id'] = $s_sec;
        $this->data['assig'] = $this->dbconnection->select('assignment', 'count(*) as total', 'class_id='.$s_class.' AND section_id='.$s_sec.' AND dos>CURDATE()');
        $this->data['dob'] = $stud_info[0]->dob;
        $this->data['contact'] = $stud_info[0]->phone;
        $this->data['father'] = $stud_info[0]->father_name;
        $this->data['mother'] = $stud_info[0]->mother_name;
        $this->data['addrs'] = $stud_info[0]->address;
        $this->data['email'] = $stud_info[0]->email_address;
        $this->data['adm'] = $stud_info[0]->admission_no;
       
        $this->data['fee_amnt'] = $fee_info[0]->total_amount;
        $this->data['fee_date'] = $fee_date1;
        $this->data['birthday'] = $todaysbirth;
        $this->data['homework'] = $homework;

        $this->data['cnt'] = $i;
        $this->data['count'] = $max_j;
        $this->data['today'] = $day1;
        $this->data['period'] = $tot_period;
        $this->data['todaysrou'] = $todaysrou;
        $this->page_title = 'Dashboard';
        $this->section = 'dashboard';
        $this->page_name = 'student_dashboard_new';
        $this->customview = '';
    }


       public function multistudents_dashboard() {
		error_reporting(-1);

		$usr_name = explode("-", $this->session->userdata('user_name'));

		$stud_info = $this->dbconnection->select("student", "id,CONCAT(first_name,' ',middle_name,' ',last_name) as name, email_address, admission_no, father_name, mother_name, address, dob, phone, class_id,(select class_name from class where id=class_id) as cls, section_id, (select sec_name from section where id=section_id) as sec", "admission_no='$usr_name[1]' and status='Y'");
		$this->data['school1'] = $this->school1;
            
		if(empty($stud_info))
			redirect('/login');
            
		$s_name	= $stud_info[0]->name;
		$s_class	= $stud_info[0]->class_id;
		$s_sec	= $stud_info[0]->section_id;
		$s_id 	= $stud_info[0]->id;
            
		date_default_timezone_set('Asia/Kolkata');
		$t = date('d-m-Y');
		$day1 = date("l", strtotime($t));

		$todaysbirth=$this->db->query("SELECT s.first_name,s.middle_name,s.last_name,s.class_id,s.section_id,c.class_name,se.sec_name FROM crmfeesclub_8.student s,crmfeesclub_8.class c,crmfeesclub_8.section se WHERE MONTH(s.dob) = MONTH(NOW()) AND DAY(s.dob) = DAY(NOW()) and s.class_id=c.id and s.section_id=se.id and s.id='$s_id'")->result();

		$this->data['student_name'] = $stud_info[0]->name;
		$this->data['sec'] 	= $stud_info[0]->sec;
		$this->data['clas'] 	= $stud_info[0]->cls;
            
		$this->data['class_id'] 	= $s_class;
		$this->data['sect_id'] 	= $s_sec;

		$this->data['dob'] 		= $stud_info[0]->dob;
		$this->data['contact'] 	= $stud_info[0]->phone;
		$this->data['father'] 	= $stud_info[0]->father_name;
		$this->data['mother'] 	= $stud_info[0]->mother_name;
		$this->data['addrs'] 	= $stud_info[0]->address;
		$this->data['email'] 	= $stud_info[0]->email_address;
		$this->data['adm'] 	= $stud_info[0]->admission_no;

		$this->data['birthday'] 	= $todaysbirth;

		$strsql = "SELECT sab.admission_no, concat(std.first_name,' ',std.middle_name, ' ', std.last_name)  AS fullname,  "
						. "SUM(sab.amt_charged)  AS 'tot_amt_charged', SUM(sab.amt_paid) AS 'tot_amt_paid' "
						. "FROM student_acc_book sab, student std "
						. "WHERE sab.admission_no = std.admission_no GROUP BY sab.admission_no "
						. "HAVING sab.admission_no = '" . $usr_name[1] . "'"; 

		$query = $this->db->query($strsql);
		$this->data['student_pay'] = $query->result();

		$this->data[$this->session->userdata('login_type') . '_message'] = 0;
		
              $this->page_title = 'Dashboard';
              $this->data['user_name'] = $usr_nm;
              $this->section = 'dashboard';
              $this->page_name = 'multistudents_dashboard';
              $this->customview = '';
	}

}
