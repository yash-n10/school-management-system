<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class FpdfGen {
        public function __construct() {
		
		include('fpdf/fpdf.php');
		include('fpdi/fpdi.php');
		$pdf = new FPDF();
                $pdf = new FPDI();
		$pdf->AddPage();
		
		$CI =& get_instance();
		$CI->fpdf = $pdf;
		
	}
}

