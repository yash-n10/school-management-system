<?php
/**
 * Get asset URL
 *
 * @access  public
 * @return  string
 */
if(!function_exists('site_name'))
{  
    function site_name()
    {
        //get an instance of CI so we can access our configuration
        $CI =& get_instance();  
        //return the full asset path
        return $CI->config->item('site_name');
    }
}
if(!function_exists('time_elapsed_string'))
{
	function time_elapsed_string($ptime)
	{
		$etime = time() - $ptime;

		if ($etime < 1)
		{
			return '0 seconds';
		}

		$a = array( 12 * 30 * 24 * 60 * 60  =>  'year',
					30 * 24 * 60 * 60       =>  'month',
					24 * 60 * 60            =>  'day',
					60 * 60                 =>  'hour',
					60                      =>  'minute',
					1                       =>  'second'
					);

		foreach ($a as $secs => $str)
		{
			$d = $etime / $secs;
			if ($d >= 1)
			{
				$r = round($d);
				return $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
			}
		}
	}
}
if(!function_exists('get_supply_images'))
{
	function get_supply_images($supply_id)
	{
		$CI =& get_instance(); 
		$CI->load->library("session");
		$CI->load->model('user_model');
		
		$conditions = array(
			'select' => '*', 
			'where' => array('supply_id'=> $supply_id),
		);
		
		$images = $CI->user_model->get_rows($conditions, 'supply_images');
		
		return $images;
	}
}

if (!function_exists('show_permission'))
{

	function show_permission($page = '', $log_error = TRUE)
	{
		$_error =& load_class('Exceptions', 'core');
		$_error->show_permission($page, $log_error);
		exit(4); // EXIT_UNKNOWN_FILE
	}
}