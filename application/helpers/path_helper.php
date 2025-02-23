<?php
/**
 * Get asset URL
 *
 * @access  public
 * @return  string
 */
if (!function_exists('asset_url'))
{
	function asset_url($type = '', $filename = '')
	{
		//get an instance of CI so we can access our configuration
		$CI =& get_instance();
		//return the full asset path

		switch($type)
		{
				case 'js':
					return base_url().$CI->config->item('asset_url').$CI->config->item('js').$filename;
					break;

				case 'css':
					return base_url().$CI->config->item('asset_url').$CI->config->item('css').$filename;
					break;

				case 'images':
					return base_url().$CI->config->item('asset_url').$CI->config->item('images').$filename;
					break;

				case 'social':
					return base_url().$CI->config->item('asset_url').$CI->config->item('images').'social/'.$filename;
					break;

				case 'who_images':
					return base_url().$CI->config->item('asset_url').$CI->config->item('uploads').'who_images/thumb/'.$filename;
					break;

				case 'supply_images':
					return base_url().$CI->config->item('asset_url').$CI->config->item('uploads').'supply_images/thumb/'.$filename;
					break;

				default:
					return base_url().$CI->config->item('asset_url');
					break; 
		}
	}
}

if (!function_exists('slug_url'))
{
	function slug_url($controller, $id, $title)
	{
		if ($title != '')
			return base_url($controller.'/'.$title);
		else
			return base_url($controller.'/'.$id);
	}
}

if (!function_exists('backend_path'))
{
	function backend_url()
	{
		//get an instance of CI so we can access our configuration
		$CI =& get_instance();  
		//return the full backend path
        return base_url().$CI->config->item('backend_path');
	}

	function backend_view()
	{ 
		//get an instance of CI so we can access our configuration
		$CI =& get_instance();
		//return the full file
		return $CI->config->item('backend_path');
	}
}