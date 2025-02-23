<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if(!function_exists('do_upload'))
{
	function do_upload($u,$path,$filename) {
             $CI =& get_instance();
//            $config['upload_path'] = './assets/img/logo/';
            $config['upload_path'] = $path;
            $config['allowed_types'] = "gif|jpg|jpeg|png|pdf";
//            $config['max_size'] = 10485760;
//            $config['max_size']	= '100';
//            $config['max_width'] = 1024;
//            $config['max_height'] = 768;
            $config['file_name'] = $filename;
            $CI->upload->initialize($config);
            $CI->load->library('upload', $config);

            if (!$CI->upload->do_upload($u)) {
                
                return $data = array('errors' => $CI->upload->display_errors());
            } else {
                return $data = array('upload_data' => $CI->upload->data());
            }
        }
}
?>
