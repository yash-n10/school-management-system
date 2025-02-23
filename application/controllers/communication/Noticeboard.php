<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Noticeboard extends MY_ListController {

    public function __construct() {
        
        $this->page_code = 'school_noticeboard';
        parent::__construct();


        $this->page_title = 'Noticeboard';
        $this->rec_type = 'Notice';
        $this->rec_types = 'Notices';
        $this->section = 'communication';
        $this->dbtable = 'noticeboard';
        
        $this->display_columns = array('id' => '#', 'notice_title' => 'Title', 'notice' => 'Notice', 'create_timestamp_disp' => 'Date');
        $this->edit_columns = array(
            'notice_title' => array('disp' => 'Title', 'type' => 'text', 'required' => TRUE),
            'notice' => array('disp' => 'Notice', 'type' => 'textbox', 'required' => TRUE),
            'create_timestamp' => array('disp' => 'Date', 'type' => 'date', 'required' => TRUE),
        );
        $this->search_columns = array(
            'alpha_num' => array(
                'notice_title',
                'notice',
            ),
            'numeric' => array(
            ),
        );
        $this->rec_key = 'id';
        $this->data_table = $this->dbtable . ' AS t1';
        $this->data_select = 'id,notice_title,notice,DATE_FORMAT(create_timestamp, "%d-%m-%Y") as create_timestamp_disp';
        // $this->data_select = 'id, notice_title, notice, FROM_UNIXTIME(create_timestamp, "%Y-%m-%dT%H:%i:%s") AS create_timestamp, FROM_UNIXTIME(create_timestamp, "%Y-%m-%d %H:%i:%s") AS create_timestamp_disp';
        $this->data_select_where = '';



        

    }

}
