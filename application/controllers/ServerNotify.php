<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Notification
 *
 * @author Win7
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class ServerNotify extends CI_Controller {

    public function __construct() {
        parent::__construct();
//        error_reporting(-1);
//                ini_set('display_errors',1);
//                $this->db->db_debug=TRUE;
//		if(empty($this->session->userdata('user_id'))){
//			redirect('/login');
//		}
    }

    public function GatewayResponse() {
//        echo 'hello';
//                                    print_r($_POST);
        $datat = array(
            'amount' => $this->input->post('Amount'),
            'date' => $this->input->post('DateCreated'),
            'description' => $this->input->post('Description'),
            'merchant_ref_no' => $this->input->post('MerchantRefNo'),
            'net_amount' => $this->input->post('NetAmount'),
            'payment_id' => $this->input->post('PaymentID'),
            'payment_method' => $this->input->post('PaymentMethod'),
            'payment_mode' => $this->input->post('PaymentMode'),
            'response_code' => $this->input->post('ResponseCode'),
            'response_message' => $this->input->post('ResponseMessage'),
            'transaction_id' => $this->input->post('TransactionID'),
            'status' => $this->input->post('status'),
            'chargeback_amount' => $this->input->post('ChargebackAmount'),
        );
        $this->dbconnection->insert("gateway_response", $datat);
    }

    public function CCAvenueResponse() {
                                   print_r($this->input->post());
                                   
        include ($_SERVER['DOCUMENT_ROOT'] . '/assets/gateway/Crypto.php');
        $workingKey='0230E900A4E51F12C51408158BF0B515';
            $encResponse = $this->input->post('encResp');   //This is the response sent by the CCAvenue Server
            $rcvdString = decrypt($encResponse, $workingKey);  //Crypto Decryption used as per the specified working key.
//            $order_status = "";
            $decryptValues = explode('&', $rcvdString);
            $dataSize = sizeof($decryptValues);
            $response = array();

            for ($i = 0; $i < $dataSize; $i++) {
                $information = explode('=', $decryptValues[$i]);
                $response[$information[0]] = $information[1];
            }
            if ($response['order_status'] === "Success") {
                $responseCode = 0;
                $statusCode = 'S';
            } else {
                $responseCode = 2;
                $statusCode = 'F';
            }
        $datat = array(
            'amount' => round($response['amount'], 0),
            'date' => date('Y-m-d H:i:s', strtotime(str_replace("/", "-", "{$response['trans_date']}"))),
            'description' => json_encode($response),
            'merchant_ref_no' => $this->input->post('order_id'),
            'net_amount' => round($response['amount'], 0),
            'payment_id' => $response['tracking_id'],
            'payment_method' => $response['payment_mode'],
            'payment_mode' => $response['payment_mode'],
            'response_code' => $responseCode,
            'response_message' => $response['order_status'],
            'transaction_id' => $response['tracking_id'],
            'status' => $response['order_status'],
        );
        $this->dbconnection->insert("gateway_response", $datat);
    }


}
