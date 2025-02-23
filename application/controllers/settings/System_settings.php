<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_settings extends CI_Controller
{
        public $page_code = 'system_settings';
        public $page_id = '';
        public $page_perm = '----';
        
	public function __construct()
	{
		parent::__construct();
		$this->page_id = $this->dbconnection->Get_namme("link_page", "l_code", "$this->page_code", "id");


		$this->id=$this->session->userdata('school_id');

		if ($this->id !=0) {
			$this->db->db_select('crmfeesclub_'.$this->id);
		}
                $permission = $this->dbconnection->select("user_group_permission", "permission", "link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
                $this->page_perm = !empty($permission) ? $permission[0]->permission : '----';
                $this->right_access = $this->page_perm;

                if (strpos($this->page_perm, '----') == true) {
                    redirect(base_url(''), 'refresh');
                }
                
		$this->page_name = 'system_settings';
		$this->page_title = 'System Settings';
		$this->section = 'settings';
		$this->customview = '';
	}

	public function index() {
                if (substr($this->right_access, 1, 1) != 'R') {
        //            redirect(base_url(), 'refresh');
                    redirect('404');
                }
		$page_data['page_name'] = $this->page_name;
		$page_data['page_title'] = $this->page_title;
		$page_data['section'] = $this->section;
		$page_data['customview'] = $this->customview;
		$page_data['settings'] = $this->db->get('settings')->result_array();
		$this->load->view('index', $page_data);
	}

	public function update($param1 = '') {
            if (substr($this->right_access, 2, 1) != 'U') {
    //            redirect(base_url(), 'refresh');
                redirect('404');
            }
		$this->db->where('type', $param1);
		$this->db->update('settings', array(
					'description' => $this->input->post('description')
					));
		$this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
		redirect(base_url() . 'settings/system_settings', 'refresh');
	}
	
	public function upload_logo() {
                if (substr($this->right_access, 2, 1) != 'U') {
        //            redirect(base_url(), 'refresh');
                    redirect('404');
                }
                $config['upload_path']          = './uploads/' . $this->session->userdata('school_code') . '/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 100;
                $config['max_width']            = 1024;
                $config['max_height']           = 768;
		$config['file_name']		= $this->session->userdata('school_code') . 'logo';
		$config['file_ext_tolower']	= TRUE;
		$config['overwrite']		= TRUE;

		if (!is_dir($config['upload_path'])) mkdir($config['upload_path']);

		$this->upload->initialize($config);

		if (!$this->upload->do_upload('userfile')) {
			$this->session->set_flashdata('flash_message', $this->upload->display_errors());
			echo $this->upload->display_errors();
		} else {
			$this->session->set_flashdata('flash_message', get_phrase('settings_updated'));
		}

		    
		
		redirect(base_url() . 'settings/system_settings', 'refresh');
	}
}
