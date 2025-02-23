<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 include_once APPPATH.'/third_party/mpdf-master/mpdf.php';
 
class M_pdf {
 
    public $param;
    public $pdf;
 
    public function __construct($param = '"en-GB-x","A4","","",10,10,10,10,6,3')
    {
       // $a='a';
        $this->param =$param;
        $this->pdf = new mPDF($this->param);
        //return $a;
    }
}