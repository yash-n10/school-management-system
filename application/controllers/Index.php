<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

	public function __construct() 
	{
		parent::__construct();
	}

	public function index() {
		if(empty($this->session->userdata('user_id'))){
			redirect('/login');
		}
		redirect('/dashboard');
	}
}
