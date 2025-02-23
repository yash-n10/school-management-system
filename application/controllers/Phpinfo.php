<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
class Phpinfo extends CI_Controller {
    public function __construct() {
        parent::__construct();
        error_reporting(E_ALL & ~E_NOTICE);
        $this->id = $this->session->userdata('shop_id');
        
        $this->user_id = $this->session->userdata('user_id');
        $this->db->db_select('digikhata_' . $this->id);
    }
     public function index() {
         phpinfo();
     }
}
 ?> 