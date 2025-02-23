<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Template
 *
 * Enables the user to load template
 *
 * Usage:
 *
 * Load it within your Controllers:
 * $this->load->library("Template");
 *
 * Configure CodeIgniter to Auto-Load it:
 *
 * Edit application/config/autoload.php
 * $autoload['libraries'] = array('Template');
 *
 *
 * Use it in your view files
 * $this->template->view('view', $parameters);
 * 
 */
class Template {

	var $obj;
	var $template;

	public function __construct($template = array('template' => 'template'))
	{
		$this->obj =& get_instance();
		$this->template = $template['template'];
	}

	/**
	 *
	 * set_template()
	 *
	 * Sets the template 
	 * 
	 */
	public function set_template($template)
	{ 
		$this->template = $template;
	}

	/**
	 *
	 * view()
	 *
	 * Loads the view 
	 * 
	 */
	public function view($view, $data = NULL, $return = FALSE)
	{ 
		$CI = & get_instance();
        $CI->load->library("session");
		$CI->load->model('user_model');

		$loaded_data = array();
		$loaded_data['content'] = $this->obj->load->view($view, $data, true);

		if(isset($CI->session->userdata['user_data']['id'])){ 
			$notification_query = array(
				'where' => array('status' => 1, 'user_inbox_id' => $CI->session->userdata['user_data']['id']),
			);
			$notification_count = $CI->user_model->get_count($notification_query, 'user_inbox');
			$loaded_data['notification'] = $notification_count;
		}

		if ($return)
		{
			$output = $this->obj->load->view($this->template, $loaded_data, true);
			return $output;
		}
		else
		{
			$this->obj->load->view($this->template, $loaded_data, false);
		}
	}

}