<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Exceptions extends CI_Exceptions
{
	var $CI="";
        function __construct(){
            parent::__construct();
            $this->CI =& get_instance();
        }
        
                        /**
	 * General Error Page
	 *
	 * Takes an error message as input (either as a string or an array)
	 * and displays it using the specified template.
	 *
	 * @param	string		$heading	Page heading
	 * @param	string|string[]	$message	Error message
	 * @param	string		$template	Template name
	 * @param 	int		$status_code	(default: 500)
	 *
	 * @return	string	Error page output
	 */
	public function show_permission($page = '', $log_error = TRUE)
	{       
                if (is_cli())
		{
			$heading = 'Permission Denied';
			$message = 'You Dont\'t have permission to the controller/method pair you requested.';
		}
		else
		{
			$heading = 'Permission Denied';
			$message = 'You Dont\'t have permission to the page you requested.';
		}

		// By default we log this, but allow a dev to skip it
		if ($log_error)
		{
			log_message('error', $heading.': '.$page);
		}

		echo $this->show_error($heading, $message, 'error_permission', 404);
		exit(4); // EXIT_UNKNOWN_FILE
		
	}

	// --------------------------------------------------------------------


}

class MyCustomExtension extends MY_Exceptions {} //define your exceptions