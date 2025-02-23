<?php
    if(!function_exists('flash_message'))
    {  
        function flash_message($message = '', $selector = '')
        {
//            print_r('test');exit;
            switch($selector) {
                case 'error':
                    return '<p class="bg-danger"><a class="close" data-dismiss="alert">&times;</a>'.$message.'</p>';					
                break;

                case 'warning':
                    return '<p class="bg-warning"><a class="close" data-dismiss="alert">&times;</a>'.$message.'</p>';
                break;

                case 'info':
                    return '<p class="bg-info"><a class="close" data-dismiss="alert">&times;</a>'.$message.'</p>';
                break;

                case 'success':
                default:
                    return '<p class="bg-success"><a class="close" data-dismiss="alert">&times;</a>'.$message.'</p>';
                break;
            }
        }
    }
?>