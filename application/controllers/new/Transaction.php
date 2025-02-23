<?php
/**
 * 
 */
class Transaction extends CI_Controller
{
public function index()
	{
		$this->load->view('new/transaction');
	}
public function update(){
		// error_reporting(-1);
		$school=$this->input->post('school');
		$id = $this->input->post('transaction');
		$school='crmfeesclub_'.$school.".fee_transaction_head";
		$id = 'transaction_id='.$id;
		$query2=$this->dbconnection->select($school,"*",$id);
		$query=$query2[0];
	
		$this->load->view('new/trans_update',$query2);
	}
public function updated(){
		$data = $this->input->post();
		print_r($data);die();
		$transaction_id=$data['transaction_id'];
		$wh='transaction_id='.$transaction_id;
		print_r($wh);die();
		$data2 = array(
			'id' =>$data['id'] ,
			'student_id'=>$data['student_id'],
			'request_status'=>$data['request_status'],
			'response_status'=>$data['response_status'],
			'chargeback_status'=>$data['chargeback_status'],
			'total_amount'=>$data['total_amount'],
			'discount_amount'=>$data['discount_amount'],
			'year'=>$data['year'],
			'paymet_date'=>$data['paymet_date'],
			'transaction_id'=>$data['transaction_id'],
			'response_code'=>$data['response_code'],
			'payment_method'=>$data['payment_method'],
			'response_message'=>$data['response_message'],
			'remarks'=>$data['remark'],
			'status'=>$data['status'],
			'paid_status'=>$data['paid_status'],
			'receipt_no'=>$data['receipt_no'],
			'mode'=>$data['mode'],
			'cheque_no'=>$data['cheque_no'],
			'cheque_date'=>$data['cheque_date'],
			'cheque_status'=>$data['cheque_status'],
			'pos_no'=>$data['pos_no'],
			'bank_name'=>$data['bank_name'],
			'collection_center'=>$data['collection_center'] 
		);
		// $this->dbconnection->update('fee_transaction_head',$data2,);
	}

public function delete()
{
	$this->load->view('new/transaction_delete');
}
public function deleted()
{
	$data = $this->input->post('tid');
	$tid= 'transaction_id='.$data;
	// echo $tid;die();

	$this->db->query('DELETE FROM fee_transaction_head WHERE "$tid"');
	if($this->db->query('DELETE FROM fee_transaction_head WHERE "$tid"')) {
		echo "SUCCESS";
	}
	else{
		echo "FAILURE";
	}
}
}
?>