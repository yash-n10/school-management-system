<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Locations extends MY_ListController
{
	public function __construct()
	{
                $this->page_code = 'location';
		parent::__construct();

		

		$this->page_title = 'Locations';
		$this->rec_type = 'Location';
		$this->rec_types = 'Locations';
		$this->section = 'masters';
		$this->dbtable = 'locations';
//		$this->display_columns = array('id' => 'ID', 'location_description' => 'Description', 'parent_disp' => 'Parent', 'type_disp' => 'Type', 'iso' => 'ISO Standard');
		$this->display_columns = array('id' => 'ID', 'location_description' => 'Description',  'iso' => 'ISO Standard');
		$this->edit_columns = array(
				'location_description' => array('disp' => 'Location Description', 'type' => 'text', 'required' => TRUE),
//				'parent' => array('disp' => 'Parent Location', 'type' => 'select', 'select_opts' => $this->dbconnection->select('locations', 'id AS opt_id, location_description AS opt_disp')),
//				'type' => array('disp' => 'Location Type', 'type' => 'select', 'select_opts' => $this->dbconnection->select('location_types', 'id AS opt_id, type_name AS opt_disp'), 'required' => TRUE),
				'iso' => array('disp' => 'ISO Standard ID', 'type' => 'text'),
				'lat' => array('disp' => 'Latitide', 'type' => 'text'),
				'long' => array('disp' => 'Longitude', 'type' => 'text'),
				);
		$this->search_columns = array(
				'alpha_num' => array(
					'location_description',
					'iso',
					),
				'numeric' => array(
					),
				);
		$this->rec_key = 'id';
		$this->data_table = $this->dbtable . ' AS t1';
		$this->data_select = 'id, location_description, parent, (SELECT location_description FROM locations AS t2 WHERE t2.id=t1.parent) AS parent_disp, type, (SELECT type_name FROM location_types WHERE location_types.id=t1.type) AS type_disp, iso, lat, long';
		$this->data_select_where = '';
		
		
		
		$this->admission_csv_columns = array(
				array('field' => 'location_description', 'human_name' => 'Location Description'),//0
				array('field' => 'iso', 'human_name' => 'ISO'),//1

				);
	}
	
	 public function download_format() {
        $this->load->helper('download');
        $fh = fopen('php://memory', 'w');
        
        fputcsv($fh, array_column($this->admission_csv_columns, 'human_name'));
        fseek($fh, 0);
        $csv = stream_get_contents($fh);
        force_download('FeesClub-Location-NewUPLOAD-Format.csv', $csv);
    }
	
	public function upload() {

        if(substr($this->right_access, 0, 1) != 'C') {
			redirect('404');
	}
//                ini_set('max_input_time', 0);
        ini_set('max_execution_time', 3600);
//                ini_set('display_errors', 1);
//                error_reporting(-1);
//		ini_set('display_errors', 1);
        $this->data['errors'] = array();
		
		// Cache location_description
        $this->db->select('location_description');
        $query = $this->db->get('locations');
        $location_description = array_column($query->result_array(), NULL, 'location_description');


        if (!empty($_FILES['admission_upload']['tmp_name'])) {  

            $location_file = array();
            $handle = fopen($_FILES['admission_upload']['tmp_name'], "r");
            fgetcsv($handle); // Read and discard header row
            while (($row = fgetcsv($handle, 10000, ",")) !== FALSE) {
                $rowarr = array();
                foreach ($row as $pos => $value) {

                    $rowarr[$this->admission_csv_columns[$pos]['field']] = trim($value);
                }
                /* ------ checking duplicate admission number in csv file  -------- */
                if (in_array($rowarr['location_description'], $location_file)) {
                    $this->data['errors'][] = "Locations'" . $rowarr['location_description'] . "' previously present in this file, skipping...";
                    continue;
                }

                $location_file[] = $rowarr['location_description'];
                if (isset($location_description[$rowarr['location_description']])) {
                    $this->data['errors'][] = "Locations '" . $rowarr['location_description'] . "' already present, skipping...";
                    continue;
                }


                $data_student = array(
				
					"location_description" => $rowarr['location_description'],
                    "iso" => $rowarr['iso'],
                );
                $this->db->insert('locations', $this->security->xss_clean($data_student));
                $employee_id = $this->dbconnection->get_last_id();
                
                $audit = array("action" => 'Upload Location Information',
                    "module" => "TRANSPORT",
                    'datetime' => date("Y-m-d H:i:s"),
                    'userid' => $this->session->userdata('user_id'),
                    'student_id' => $employee_id,
                    'page' => 'upload_locations',
                    'remarks' => ''
                );
                $this->dbconnection->insert("auditntrail", $audit);
//                                }
//                            }else {/*------------  end of checking duplicate data in csv file   -------------*/
//                                
//                            }
            }
        }
        if (empty($this->data['errors'])) {
            $this->session->set_flashdata('employeeupload', 'Successfully Uploaded !');
        } else {
            $this->session->set_flashdata('employeeupload', 'File has some error !');
        }
        $this->importcsv();
    }
	
	public function importcsv() {

        $this->data['page_name'] = 'upload_locations';
        $this->data['page_title'] = 'Upload Locations';
        $this->data['section'] = 'transport';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;

        $this->load->view('index', $this->data);
    }
	
	
}
