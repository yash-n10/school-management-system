<?php

//htmlentities
    function e($str)
    {
        if ( ! is_array($str))
        {
                return htmlspecialchars($str, ENT_QUOTES);
        }
        foreach ($str as $key => $val)
        {
                $str[$key] = htmlspecialchars($val, ENT_QUOTES);
        }

	return $str;
        
//        htmlentities($string, $flags, $encoding, $double_encode)
//        htmlentities($string, $flags);
    }

?>
