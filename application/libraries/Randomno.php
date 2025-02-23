<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');
 
class Randomno {
 
	function generateRandomString($length = 25) {
            
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                return $randomString;
                
	}
 
}
?>