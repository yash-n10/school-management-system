<?php
if (!defined('BASEPATH')) 
    exit('No direct script access allowed');

//STORE PAYMENT
class Payment extends CI_Controller {
	public function __construct() {
		parent::__construct();

		if ($this->session->userdata('login_type') != 'student' || empty($this->session->userdata('user_id'))) {
			redirect('/login');
		}

		$this->id 	= $this->session->userdata('school_id');
		$this->school 	= $this->dbconnection->select('school', '*', 'id = ' . $this->id);
		$this->countries = $this->dbconnection->select('countries', '*', 'id=' . $this->school[0]->country_id);
		$this->state 	= $this->dbconnection->select('states', '*', 'id=' . $this->school[0]->state_id);
		$this->city 	= $this->dbconnection->select('cities', '*', 'id=' . $this->school[0]->city_id);
    
		if ($this->id != 0) {
			$this->db->db_select('crmfeesclub_' . $this->id);
		}

		$this->academic_session = $this->dbconnection->select("accedemic_session", "max(id) as fin_year,start_date,end_date,session", "status='Y' and active='Y'");
		$fetch_startyr = isset($this->academic_session[0]->start_date) ? explode('-', $this->academic_session[0]->start_date) : array('0');
		$this->session_start_yr = reset($fetch_startyr);

		$this->academic_session_pre = $this->dbconnection->select("accedemic_session", "max(id) as fin_year", "status='Y' and active!='Y'","id","DESC");
		$this->previousSessionID=$this->academic_session_pre[0]->fin_year;
		$this->p_academic_session=$this->dbconnection->select("accedemic_session", "*", "id=".$this->previousSessionID);
		$pyear=$this->p_academic_session[0]->start_date;
		$this->psession=$this->p_academic_session[0]->session;
		$this->previousSessionyear = date('Y', strtotime($pyear));

		$user_id = $this->session->userdata('user_id');
		$user = $this->dbconnection->select('user', 'student_id', 'id = ' . $user_id);
		$student_id = $user[0]->student_id;

		$student = $this->dbconnection->select('student', 'id,transport_amt,fine_waiver,course_id,'
								. ' class_id,(select class_name from class where id=student.class_id) as class_name,'
								. ' concat(first_name," ",middle_name," ",last_name) as name,first_name,'
								. ' stud_category,student_academicyear_id,'
								. ' (select c.cat_name from category c where c.id=stud_category) as cat_name,'
								. '  section_id,(select s.sec_name from section s where s.id=section_id) as sec_name,'
								. ' email_address, phone,status,date_created, created_by,last_date_modified, last_modified_by,start_fee_month,student_type', 'id = ' . $student_id);
        
		$school_id = $this->session->userdata('school_id');
		
		$student_type = $student[0]->student_type;
		$student_cat 	= $student[0]->stud_category;

		$new_student_class_id = $student[0]->class_id;
			// $student_class_id= ($new_student_class_id) -1; //old class

		$section_id = $student[0]->section_id;
		$course_id = $student[0]->course_id;
		$transport_amt = $student[0]->transport_amt;
		$student_academicyear_id = $student[0]->student_academicyear_id;

		$this->school_id=$school_id;
		$this->page_title = 'Payment';
		$this->section = 'store';
		$this->page_name = 'payment_view'; //Amitabh
		$this->customview = ''; 
	}


	public function index() {
		$user_id=$this->session->userdata('user_id');
		$query=$this->db->query("SELECT * FROM user where id='$user_id'");
		$query=$query->result();
		$query=$query[0];
		
		$student_id	= $query->student_id;
		$student_data	= $this->db->query("SELECT * FROM student where id='$student_id'");
		$student_data	= $student_data->result();
		$student_data	= $student_data[0];
		$admission_no= $student_data->admission_no;

		$strsql = "SELECT admission_no, SUM(amt_charged) AS 'tot_amt_charged', SUM(amt_paid) AS 'tot_amt_paid', approved, status "
						. "FROM student_acc_book "
						. "GROUP BY admission_no, approved "
						. "HAVING status = 'Y' AND approved = 'Y' AND admission_no = '" . $admission_no . "'"; 
		$outstanding = $this->db->query($strsql);
		$outstanding=$outstanding->result();
		$outstanding=$outstanding[0];

		$strsql = "SELECT admission_no, SUM(amt_charged) AS 'tot_amt_charged', SUM(amt_paid) AS 'tot_amt_paid', approved, status "
						. "FROM student_acc_book "
						. "GROUP BY admission_no, approved "
						. "HAVING status = 'Y' AND approved = 'N' AND admission_no = '" . $admission_no . "'"; 
		$unbilled	= $this->db->query($strsql);
		$unbilled	= $unbilled->result();
		$unbilled	= $unbilled[0];
// - $outstanding->tot_amt_paid
		$bill_amount=$this->db->query("SELECT bill_amt FROM store_bill_hdr where admission_no='$admission_no' and final_status='APPROVED'")->result();
		$bill_amt=0;
		foreach ($bill_amount as $key) {
			$bill_amt = $bill_amt + $key->bill_amt;
		}
		$trans_hist= $this->db->query("SELECT * FROM store_transaction where student_id='$student_id' and paid_status=1");
		$trans_hist=$trans_hist->result();
		$total_paid=0;
		foreach ($trans_hist as $key) {
			$total_paid=$total_paid + $key->total_amount;
		}
		$data['amount']	= $outstanding->tot_amt_charged + $bill_amt - $total_paid;
		$data['unbilled']	= $unbilled->tot_amt_charged;

		$data['trans_hist'] = $trans_hist;
//	print_r(count($trans_hist)); die();	
		$data['page_title']	= $this->page_title ;
		$data['section']	= $this->section ;
		$data['page_name']= $this->page_name;
		$data['student_id']	= $student_id;
		
		$this->load->view('index',$data);
	}


	public function request() {
		$amount=$this->input->post('amount');
		$user_id=$this->session->userdata('user_id');
    	
		$query	= $this->db->query("SELECT * FROM user where id='$user_id'");
		$query	= $query->result();
		$query	= $query[0];
		$student_id=$query->student_id;

		$student = $this->dbconnection->select('student', 'id,reference_no,first_name, middle_name, last_name, stud_category,admission_no,'
					. ' (select c.cat_name from category c where c.id=stud_category) as cat_name,'
					. ' class_id,(select cl.class_name from class cl where cl.id=class_id) as class_name,'
					. ' section_id,(select s.sec_name from section s where s.id=section_id) as sec_name,'
					. ' course_id,email_address, phone,status, date_created, created_by, last_date_modified, last_modified_by,start_fee_month,student_type', 'id = ' . $student_id);

		$class_name 	= $student[0]->class_name;
		$student_class_id = $student[0]->class_id;
		$user_id 	 	= $this->session->userdata('user_id');
		$student_cat 	= $student[0]->stud_category;
		
		if ($student[0]->email_address == '') {
			$email = 'abc@gmail.com';
		} else {
			$email = $student[0]->email_address;
		}

		$school 	= $this->school;
    
		$countries	= $this->countries;
		$country_code = $countries[0]->country_code;
        
		$state 	= $this->state;
		$state_code = $state[0]->state_code;
        
		$city 	= $this->city;
		$city_code = $city[0]->city_code;
        
		$admission_no = $student[0]->admission_no;
		$school_code = $school[0]->school_code;
		$class_code = $class_name;

		$max_sesion_id = $this->academic_session[0]->fin_year;

		$year_class = $this->dbconnection->select('class_fee_head', 'max(year) as year, max(id) as max_id', "(from_class_id <=$student_class_id and  to_class_id >=$student_class_id) and course=" . $student[0]->course_id . " and status='Y' and year<=$this->session_start_yr");
        
		$class_fee_head_year = $year_class[0]->year;
		$max_class_fee_id 	 = $year_class[0]->max_id;

		$this->dbconnection->insert("store_transaction", array(
													'student_id' 		=> $student_id, 
													'request_status' 	=> 1, 
													'year' 	=> $max_sesion_id,
													'status'	=>1,
													'total_amount' 	=> $amount, 
													'paid_by' 		=> $this->session->userdata('user_id'), 
													'payment_date' 	=> date('Y-m-d H:i:s'), 
													'date_created' 	=> date('Y-m-d H:i:s'), 
													'remarks' => 'Sent to payment gateway', 'mode' => 'FCLB'
												)
								);
		$fee_transac_id = $this->dbconnection->get_last_id();
		
		$refrence_no = "$school_code-$admission_no-$fee_transac_id";

		$payment_gateway = !empty($school[0]->payment_gateway) ? $school[0]->payment_gateway : 'nogateway';
		
		$data = array(
					'description' 	=> $description,
					'return_url' 	=> base_url() . "store/payment/respond?transac_id=$fee_transac_id&total=$final_total&school_id=$school_id&pgw=$payment_gateway&max_sesion_id=$max_sesion_id&fee_action_id=$fee_action_id",
					'final_total' 	=> $amount,
					'email' 		=> $email,
					'name' 		=> $student[0]->first_name . ' ' . $student[0]->middle_name . ' ' . $student[0]->last_name,
					'refrence_no_order_id' => $refrence_no,
					'MID' 		=> $school[0]->pgw_mid,
					'EncKey' 		=> $school[0]->pgw_enckey,
					'AccessCode'	=> $school[0]->pgw_access_code,
					'Live_Test' 	=> $school[0]->test_live_mode,
					'Payment_gateway' => $payment_gateway,
					'fee_transac_id' 	=> $fee_transac_id,
					'school_id' 	=> $this->school_id,
					'pgw' 		=> $payment_gateway,
					'max_sesion_id' => $max_sesion_id,
					'student_id' 	=> $student_id,
					'fee_action_id' => $fee_action_id,
					'token_name'	=>$this->token_name,
					'token_name'	=>$this->token_hash
				);

		$audit = array(
					"action" => 'PAYMENT REQUEST',
					"module" => $this->page_title,
					"page" => basename(__FILE__, '.php'),
					'datetime' => date("Y-m-d H:i:s"),
					'userid' => $this->session->userdata('user_id'),
					'remarks' => 'ID:' . $fee_transac_id,
					'ip_address' => $_SERVER['REMOTE_ADDR'],
				);
		$this->dbconnection->insert("auditntrail", $audit);

		switch ($payment_gateway) {
			case 'WORLDLINE':
// 	                   	if($school_code=='MTBS') 
//	                       	$school_code='CPS'; 

				$amtfinal = $final_total * 100;
				$data['product_code'] = "$school_code^$amtfinal";
				$this->Worldline_payment_gateway($data);
				break;
            
			case 'CCAVENUE':
				$this->hdfc_ccavenue_gateway($data);
				break;
                
			default:
				$this->hdfc_payment_gateway($data);
				break;
		}
	}
	
	
	public function Worldline_payment_gateway($data) {
		$this->load->view('feepayment/gateway/WL_Pay_page', $data);
	}


	public function hdfc_payment_gateway($data) {
		$this->load->view('feepayment/gateway/hdfc_payment_page', $data);
	}


	public function hdfc_ccavenue_gateway($data) {
			// echo '<pre>';print_r($data);die();
			$this->load->view('feepayment/gateway/hdfc_ccavenue_payment_page', $data);
	}


	public function wordline_success($response_var) {
		$data = array('response_var' => $response_var);
	}

	public function respond() {
		error_reporting(-1);
		ini_set('display_errors', 1);
      
		$this->db->db_debug=TRUE;
		$ERROR = '';
		$insert_to_db = 'NO';

		list($current_year, $month, $day) = explode('-', date('Y-m-d'));
		$maxn = '';
		$inputall = $this->input->post();
		$total = $this->input->get('total');

		$school_id = $this->id;
		$session_id = $this->academic_session[0]->fin_year;

		$payment_gateway = !empty($this->school[0]->payment_gateway) ? $this->school[0]->payment_gateway : 'HDFC';
			$trans_id = $this->input->get('transac_id');

		if ($payment_gateway == 'WORLDLINE') {  // WORLDLINE ............
			include ($_SERVER['DOCUMENT_ROOT'] . '/assets/gateway/AWLMEAPI.php');
            
			$obj = new AWLMEAPI();
			$resMsgDTO = new ResMsgDTO();
			$reqMsgDTO = new ReqMsgDTO();
			$enc_key = !empty($this->school[0]->pgw_enckey) ? $this->school[0]->pgw_enckey : '48b3ea074f36178c4f59c10bfd9c4416';
			$responseMerchant = $_REQUEST['merchantResponse'];
			$response = $obj->parseTrnResMsg($responseMerchant, $enc_key);
            
			if ($response->getStatusCode() == 'S') {
				$responseCode = 0;
			} else {
				$responseCode = 2;
			}

			$trans_cnt_query = $this->dbconnection->select('store_transaction', 'count(id) as cnt', "id=$trans_id and (response_code=0 or response_code=2) and status=1");
 			$requestfee_action_id = $this->input->get('fee_action_id');
			
			$response_var = array(
					'txnRefNo' 		=> $response->getPgMeTrnRefNo(),
					'payment_id' 		=> $response->getPgMeTrnRefNo(),
					'orderId' 			=> $response->getOrderId(),
					'amount' 			=> $response->getTrnAmt(),
					'statusCode' 		=> $response->getStatusCode(),
					'statusDesc' 		=> $response->getStatusDesc(),
					'txnReqDate' 		=> $response->getTrnReqDate(),
					'responseCode' 	=> $responseCode,
					'payment_method'	=> $response->getAddField9(),
					'txnRemarks' 		=> '',
					'full_pgw_response_json' => json_encode((array) $response),
					'doubleresponse' 	=> $trans_cnt_query[0]->cnt,
				);
			
			$success_page 	= 'feepayment/gateway/WL_Success_page';
			$PaymentMethod 	= $response_var['payment_method'];
			$PaymentMode 	= $response_var['payment_method'];
			$Remarks 		= $this->dbconnection->Get_namme('store_transaction', 'id', "$requestfee_action_id", 'remarks');

			if ($response_var['orderId'] != NULL && $response_var['orderId'] != '' && $trans_cnt_query[0]->cnt == 0) {
				$insert_to_db = 'YES';
			} else {
				$ERROR .= 'Invalid Access Or Time Out Or Double Response Received!';
			}

			$response_var['ERROR'] = $ERROR;
			$this->db->db_select('crmfeesclub');

		} elseif ($payment_gateway == 'CCAVENUE') { // CCAVENUE...........
			include ($_SERVER['DOCUMENT_ROOT'] . '/assets/gateway/Crypto.php');
            
			$workingKey 		= !empty($this->school[0]->pgw_enckey) ? $this->school[0]->pgw_enckey : '3F5E6C3F9219D7489C617C2924F18929';  //Working Key should be provided here.
			$encResponse	= $inputall["encResp"];   //This is the response sent by the CCAvenue Server
			$rcvdString 		= decrypt($encResponse, $workingKey);  //Crypto Decryption used as per the specified working key.
			$order_status 	= "";
			$decryptValues	= explode('&', $rcvdString);
			$dataSize 		= sizeof($decryptValues);
			$response 		= array();

			for ($i = 0; $i < $dataSize; $i++) {
				$information = explode('=', $decryptValues[$i]);
				$response[$information[0]] = $information[1];
			}

			$school_id=$this->session->userdata('school_id');
			$trans_cnt_query = $this->dbconnection->select('store_transaction', 'count(id) as cnt', "id=$trans_id and (response_code=0 or response_code=2) and status=1");
			
			$requestfee_action_id = $response['merchant_param2'];
			
			if ($response['order_status'] === "Success") {
				$responseCode = 0;
				$statusCode = 'S';
			} else {
				$responseCode = 2;
				$statusCode = 'F';
			}

			$response_var = array(
				'txnRefNo' 		=> $response['tracking_id'],
				'payment_id' 		=> $response['tracking_id'],
				'orderId' 			=> $response['order_id'],
				'amount' 			=> round($response['amount'], 0),
				'statusCode' 		=> $statusCode,
				'statusDesc' 		=> $response['order_status'],
				'txnReqDate' 		=> date('Y-m-d H:i:s', strtotime(str_replace("/", "-", "{$response['trans_date']}"))),
				'responseCode' 		=> $responseCode,
				'payment_method' 	=> $response['payment_mode'],
				'txnRemarks' 		=> '',
				'full_pgw_response_json' => json_encode($response),
				'doubleresponse' 	=> $trans_cnt_query[0]->cnt,
			);
			$success_page = 'feepayment/gateway/hdfc_ccavenue_success_page';
			$PaymentMethod = $response['payment_mode'];
            
			if ($PaymentMethod == 'Debit Card') {
				$PaymentMode = 'DC';
			} else if ($PaymentMethod == 'Credit Card') {
				$PaymentMode = 'CC';
			} else if ($PaymentMethod == 'Net Banking') {
				$PaymentMode = 'NB';
			} else {
				$PaymentMode = $PaymentMethod;
			}
			$Remarks = $this->dbconnection->Get_namme('store_transaction', 'id', "$requestfee_action_id", 'remarks');

			if ($response['order_status'] === "Success" || $response['order_status'] === "Aborted" || $response['order_status'] === "Failure") {
						  // echo "<br>Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.";                                         
             
				if ($response_var['orderId'] != NULL && $response_var['orderId'] != '' && $trans_cnt_query[0]->cnt == 0) {
					$insert_to_db = 'YES';
				} else {
					$ERROR .= 'Invalid Access Or Time Out Or Double Response Received!';
				}
            
			} else {
						//    echo "<br>Security Error. Illegal access detected";
				$ERROR .= 'Security_Error. Illegal access detected';
			}

			$response_var['ERROR'] = $ERROR;
			$this->db->db_select('crmfeesclub');

		} else { // DEFAULT HDFC EBS
			$HASHING_METHOD = 'sha512';
			$enc_key = !empty($this->school[0]->pgw_enckey) ? $this->school[0]->pgw_enckey : 'e643efc7cd6cb3a61bbed0842644dd76';
			$hashData = $enc_key;
			$post_val = $this->input->post();
			ksort($post_val);
            
			foreach ($post_val as $key => $value) {
				if (strlen($value) > 0 && $key != 'SecureHash') {
					$hashData .= '|' . $value;
				}
			}

			$trans_id = $this->input->get('transac_id');
			$trans_cnt_query = $this->dbconnection->select('store_transaction', 'count(id) as cnt', "id=$trans_id and (response_code=0 or response_code=2) and status=1");
			$requestfee_action_id = $this->input->get('fee_action_id');

			$responseCode 	= $this->input->post('ResponseCode');
			$response_var 	= array(
						'txnRefNo' 		=> trim($this->input->post('TransactionID')),
						'payment_id' 		=> trim($this->input->post('PaymentID')),
						'orderId' 			=> trim($this->input->post('MerchantRefNo')),
						'amount' 			=> $total,
						'statusCode' 		=> $responseCode,
						'statusDesc' 		=> trim($this->input->post('ResponseMessage')),
						'txnReqDate' 		=> $this->input->post('DateCreated'),
						'responseCode' 	=> $responseCode,
						'payment_method'  => trim($this->input->post('PaymentMethod')),
						'txnRemarks' 		=> trim($this->input->post('Description')),
						'full_pgw_response_json' 	=> json_encode($this->input->post()),
						'doubleresponse'    => $trans_cnt_query[0]->cnt,
						'trans_id'			=>$trans_id
					);
            
			$success_page = 'feepayment/gateway/hdfc_success_page';
			$Remarks 	 = $response_var['txnRemarks'];
			$this->db->db_select('crmfeesclub');

			$PaymentMethod	= $this->dbconnection->Get_namme('payment_method_desc', 'payment_code', '' . $response_var['payment_method'] . '', 'payment_desc');
			$PaymentMode 	= $this->dbconnection->Get_namme('payment_method_desc', 'payment_code', '' . $response_var['payment_method'] . '', 'payment_mode');

			if (strlen($hashData) > 0) {
				$secureHash = strtoupper(hash($HASHING_METHOD, $hashData));

				if ($secureHash == $this->input->post('SecureHash')) {
					if ($response_var['orderId'] != NULL && $response_var['orderId'] != '' && $trans_cnt_query[0]->cnt == 0) {
						$insert_to_db = 'YES';
					} else {
						$ERROR .= 'Invalid Access Or Time Out Or Double Response Received!'; // user may refresh the page
					}
				
				} else {
					$ERROR .= 'Hash validation failed'; // Do not receive same data
				}
			
			} else {
				$ERROR .= 'Invalid response'; // does not receive any response
			}
			
			$response_var['ERROR'] = $ERROR;
		}
        
		$school_code = $this->dbconnection->Get_namme("school", "id", $school_id, "school_code");
		$this->db->db_select('crmfeesclub_' . $school_id);

		if ($insert_to_db == 'YES') {
			if ($responseCode == 0) { //success
				$status = 1;
				$paid_status = 1;
				$remarks_message = 'Successful Payment';

				if ($PaymentMethod != '') {
					$remarks_message .= ' using';
				}

				$receipt_log = $this->dbconnection->select('receipt_log', 'max(recipt_no) as rec');
				$number = strlen($receipt_log[0]->rec);

				$str = '';
				for ($i = 1; $i <= (6 - $number); $i++) {
					$str .= '0';
				}
				$maxn = $str . ($receipt_log[0]->rec + 1);
				$this->save_receipt_log($trans_id, $maxn);
				$receipt_no = "FC$session_id$school_code$maxn";
			
				$student_id_=$this->dbconnection->Get_namme("store_transaction","id","$trans_id","student_id");
                
			} else {
				$status = 0;
				$paid_status = 0;

				$remarks_message = 'Failure Payment';
				if ($PaymentMethod != '') {
					$remarks_message .= ' using';
				}

				$receipt_no = "";
			}


            /* ---------- Updating Details to STORE Payment record table(store transaction)  --------- */

			$data = array(
						'paid_status' 		=> $paid_status,
						'response_status' 	=> 1,
						'paid_by' 		=> $this->session->userdata('user_id'),
						'payment_date'	=> date('Y-m-d H:i:s'),
						'transaction_id'	=> $response_var['txnRefNo'],
						'response_code'	=> $responseCode,
						'response_message' => $response_var['statusDesc'],
						'remarks' 		=> $remarks_message . ' ' . $PaymentMethod,
						'payment_method'	=> $PaymentMethod,
						'mode' 			=> $PaymentMode,
						'date_modified' 	=> date('Y-m-d H:i:s'),
						'modified_by' 		=> $this->session->userdata('user_id'),
						'full_pgw_response_json' => $response_var['full_pgw_response_json']
					);  

			$this->dbconnection->update("store_transaction", $data, "id=$trans_id");
		
		} else {

		}

		$audit = array(
				"action" 	=> 'PAYMENT RESPONSE',
				"module" 	=> $this->page_title,
				"page" 	=> basename(__FILE__, '.php'),
				'datetime'	=> date("Y-m-d H:i:s"),
				'userid' 	=> $this->session->userdata('user_id'),
				'remarks' 	=> 'ID:' . $trans_id,
				// 'ip_address' => $_SERVER['REMOTE_ADDR'],
		);
		$this->dbconnection->insert("auditntrail", $audit);

		$this->load->view($success_page, $response_var);
	}

	public function save_receipt_log($trans_id, $maxn) {
		$data1 = array(
				'recipt_no' => $maxn,
				'fee_trans_id' => $trans_id
		);
		$this->dbconnection->insert("receipt_log", $data1);
	}

	public function payment_receipt($id) {
		$data1=$this->db->query("SELECT * FROM store_transaction where id='$id'");
		$data1=$data1->result();
		$data1=$data1[0];
		// echo"<pre>";print_r($data1);die();
		$student_id=$data1->student_id;
		$admission_no=$this->db->query("SELECT admission_no FROM student WHERE id='$student_id'");
		$admission_no=$admission_no->result();
		$admission_no=$admission_no[0]->admission_no;
		$data=array();
		$data['transaction_id']=$data1->transaction_id;
		$data['payment_date']=$data1->transaction_id;
		$data['mode']=$data1->mode;
		$data['admission_no']=$admission_no;
		// print_r($data);die();
		$this->load->view('store/payment_receipt',$data);
	}

	public function bill($id) {
		$data['id']=$id;
		$this->load->view('store/bill_pdf',$data);
		$size = 'A4';
		$orientation = 'landscape';

		$html = $this->output->get_output();

		$this->load->library('pdf');
		$this->dompdf->load_html($html);
		$this->dompdf->set_paper($size, $orientation);
		$this->dompdf->render();
		$this->dompdf->stream("payment_pdf.pdf", array("Attachment" => FALSE));
	}

}

?>