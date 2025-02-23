<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Classnoticeboard extends MY_ListController {

    public function __construct() {
        $this->page_code = 'class_notice';
        parent::__construct();

        

        $this->page_title = 'Class Noticeboard';
        $this->rec_type = 'Notice';
        $this->rec_types = 'Notices';
        $this->section = 'communication';
        $this->dbtable = 'classnotice';
        $this->display_columns = array('id' => '#', 'notice_class_disp' => 'Class', 'notice_title' => 'Title', 'notice' => 'Notice', 'create_timestamp_disp' => 'Date/Time');
        $this->edit_columns = array(
            'notice_class' => array('disp' => 'Class', 'type' => 'text', 'required' => TRUE),
            'notice_title' => array('disp' => 'Title', 'type' => 'text', 'required' => TRUE),
            'notice' => array('disp' => 'Notice', 'type' => 'textbox', 'required' => TRUE),
            'create_timestamp' => array('disp' => 'Date/Time', 'type' => 'datetime-local', 'required' => TRUE, 'save_function_php' => 'strtotime'),
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
        $this->data_select = 'id, notice_class, notice_class AS notice_class_disp, notice_title, notice, ' .
                'FROM_UNIXTIME(create_timestamp, "%Y-%m-%dT%H:%i:%s") AS create_timestamp, FROM_UNIXTIME(create_timestamp, "%Y-%m-%d %H:%i:%s") AS create_timestamp_disp';
        $this->data_select_where = '';
    }

}
