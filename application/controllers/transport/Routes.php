<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Routes extends MY_ListController
{
	public function __construct()
	{
        $this->page_code = 'route';                
		parent::__construct();
		
		$this->page_title = 'Routes';
		$this->rec_type = 'Route';
		$this->rec_types = 'Routes';
		$this->section = 'transport';
		$this->dbtable = 'routes';
		$this->display_columns = array('id' => 'ID', 'vehicle_disp' => 'Vehicle No.', 'route_code' => 'Route Code', 'start_place_disp' => 'Start', 'end_place_disp' => 'End', 
				);
                
		$this->edit_columns = array(
				'vehicle' => array('disp' => 'Vehicle No', 'type' => 'select', 'select_opts' => $this->dbconnection->select('vehicle', 'id AS opt_id, vehicle_no AS opt_disp')),
				'route_code' => array('disp' => 'Route Code', 'type' => 'text', 'required' => TRUE, 'maxlength' => 30),
				'start_place' => array('disp' => 'Start', 'type' => 'select', 'select_opts' => $this->dbconnection->select('locations', 'id AS opt_id, location_description AS opt_disp')),
				'end_place' => array('disp' => 'End', 'type' => 'select', 'select_opts' => $this->dbconnection->select('locations', 'id AS opt_id, location_description AS opt_disp')),
				);
                $this->export_edit_columns=FALSE;
		$this->search_columns = array(
				'alpha_num' => array(
					'route_code',
					),
				'numeric' => array(
					),
				);
		$this->rec_key = 'id';
		$this->data_table = $this->dbtable . ' AS t1';
		$this->data_select = 'id, vehicle, (SELECT vehicle_no FROM vehicle AS t2 WHERE t2.id=t1.vehicle) AS vehicle_disp, ' . 
				'route_code, ' .
				'start_place, (SELECT location_description FROM locations AS t2 WHERE t2.id=t1.start_place) AS start_place_disp, ' .
				'end_place, (SELECT location_description FROM locations AS t2 WHERE t2.id=t1.end_place) AS end_place_disp';
		$this->data_select_where = 'status=1';
		$this->data_delete = 'UPDATE';
		$this->data_delete_update = array('status' => '0');
		
		
		$this->admission_csv_columns = array(
				array('field' => 'vehicle', 'human_name' => 'Vehicle No.'),//0
				array('field' => 'route_code', 'human_name' => 'Route Name'),//1
				array('field' => 'start_place', 'human_name' => 'Start Place'),//2
				array('field' => 'end_place', 'human_name' => 'End Place'),//3

				);
	}
	
	public function download_format() {
        $this->load->helper('download');
        $fh = fopen('php://memory', 'w');
        
        fputcsv($fh, array_column($this->admission_csv_columns, 'human_name'));
        fseek($fh, 0);
        $csv = stream_get_contents($fh);
        force_download('FeesClub-Routes-NewUPLOAD-Format.csv', $csv);
    }
	
	public function importcsv() {

        $this->data['page_name'] = 'upload_routes';
        $this->data['page_title'] = 'Upload Routes';
        $this->data['section'] = 'transport';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
		$this->data['fetch_vehicle'] = $this->dbconnection->select("vehicle", "id,vehicle_no", "status=1");
		$this->data['fetch_locations'] = $this->dbconnection->select("locations", "id,location_description");

        $this->load->view('index', $this->data);
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
		
		// Cache vechicle_no
        $this->db->select('route_code');
        $query = $this->db->get('routes');
        $route_code = array_column($query->result_array(), NULL, 'route_code');
		
		$query = $this->dbconnection->select_returnarray("vehicle", "id,vehicle_no", "status=1");
        $vehicle_no = array_change_key_case(array_column($query, 'id', 'vehicle_no'));
		
		$query = $this->dbconnection->select_returnarray("locations", "id,location_description");
        $locations = array_change_key_case(array_column($query, 'id', 'location_description'));

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
                if (in_array($rowarr['route_code'], $location_file)) {
                    $this->data['errors'][] = "Routes'" . $rowarr['route_code'] . "' previously present in this file, skipping...";
                    continue;
                }

                $location_file[] = $rowarr['route_code'];
                if (isset($route_code[$rowarr['route_code']])) {
                    $this->data['errors'][] = "Routes '" . $rowarr['route_code'] . "' already present, skipping...";
                    continue;
                }

				
				if (!isset($vehicle_no[$rowarr['vehicle']])) {
                    $this->data['errors'][] = "Routes '" . $rowarr['route_code'] . "' has undefined vehicle_no of '" . $rowarr['vehicle'] . "', skipping...";
                    continue;
                }
				if (!isset($locations[$rowarr['start_place']])) {
                    $this->data['errors'][] = "Routes '" . $rowarr['route_code'] . "' has undefined Start Place of '" . $rowarr['start_place'] . "', skipping...";
                    continue;
                }
				if (!isset($locations[$rowarr['end_place']])) {
                    $this->data['errors'][] = "Routes '" . $rowarr['route_code'] . "' has undefined End Place of '" . $rowarr['end_place'] . "', skipping...";
                    continue;
                }
				


                $data_student = array(
				
					"vehicle" =>$vehicle_no[$rowarr['vehicle']],
                    "route_code" =>$rowarr['route_code'],
					"start_place" =>$locations[$rowarr['start_place']],
                    "end_place" => $locations[$rowarr['start_place']],

                );
                $this->db->insert('routes', $this->security->xss_clean($data_student));
                $employee_id = $this->dbconnection->get_last_id();
                
                $audit = array("action" => 'Upload Routes Information',
                    "module" => "TRANSPORT",
                    'datetime' => date("Y-m-d H:i:s"),
                    'userid' => $this->session->userdata('user_id'),
                    'student_id' => $employee_id,
                    'page' => 'upload_routes',
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

    public function routes_list()
    {
        $this->data['routes'] = $this->db->query("select r.id,r.vehicle,(select vehicle_no from vehicle where id=r.vehicle) as vehicle_name,r.route_code,r.start_place,(select location_description from locations where id=r.start_place) as start_point,r.end_place,(select location_description from locations where id=r.end_place) as end_point from routes r where status=1")->result();
        // $this->data['routes'] = $this->dbconnection->select('routes','*','status=1');
        $this->data['vehicle'] = $this->dbconnection->select('vehicle','*','status=1');
        $this->data['location'] = $this->dbconnection->select('locations', '*','');
        $this->data['trip'] = $this->dbconnection->select('trip', '*','status="Y"');
        $this->data['page_name'] = 'routes';
        $this->data['page_title'] = 'Routes';
        $this->data['section'] = 'transport';
        $this->data['customview'] = '';
        $this->load->view('index', $this->data);
    }

    function save()
    {
        $vehicle_no = $this->input->post('vehicle_no');
        $route_code = $this->input->post('routes');
        $start_place = $this->input->post('start_point');
        $end_place = $this->input->post('end_point');
        $trip = $this->input->post('trip');

        $array = array(
            'vehicle'  => $vehicle_no,
            'route_code'  => $route_code,
            'start_place'  => $start_place,
            'end_place'  => $end_place,
            'trip_id'  => $trip,
        );
        // print_r($array);
        // die();
        $this->dbconnection->insert('routes', $array);
        $routes_data = $this->db->query("select r.vehicle,(select vehicle_no from vehicle where id=r.vehicle) as vehicle_name,r.route_code,r.start_place,(select location_description from locations where id=r.start_place) as start_point,r.end_place,(select location_description from locations where id=r.end_place) as end_point,r.trip_id,(select trip_name from trip where id=r.trip_id) as trip_name from routes r where status=1")->result();
        ?>
       <table class="table table-bordered table-striped" id="book_publisher">
                    <thead style="background:#99ceff;">
                      <tr>
                        <th>Sl No.</th>
                        <th>Route Code</th>
                        <th>Vehicle No</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Trip</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php $x = 1;foreach($routes_data as $value){?>
                        <tr>
                            <td><?php echo $x;?>.</td>
                            <td><?php echo $value->route_code;?></td>
                            <td><?php echo $value->vehicle_name;?></td>
                            <td><?php echo $value->start_point;?></td>
                            <td><?php echo $value->end_point;?></td>
                            <td><?php echo $value->trip_name; ?></td>
                            <td><a  data-toggle="tooltip" data-placement="top" title="Edit" onclick="update(<?php echo $value->id;?>)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a data-toggle="tooltip" data-placement="top" title="Delete" style="cursor: pointer;" onclick="deletes(<?php echo $value->id;?>)"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                </tr>
                <?php $x++;}?>
            </tbody>
        </table>
        <script type="text/javascript">
            $(document).ready(function() {
              $('#book_publisher').DataTable();
            });
        </script>
    <?php
    }

    public function update()
    {
        $id=$this->input->post('id');
        $routes_list=$this->db->query("select r.id,r.vehicle,(select vehicle_no from vehicle where id=r.vehicle) as vehicle_name,r.route_code,r.start_place,(select location_description from locations where id=r.start_place) as start_point,r.end_place,(select location_description from locations where id=r.end_place) as end_point,r.trip_id,(select trip_name from trip where id=r.trip_id) as trip_name from routes r where status=1 and id=".$id)->result();
        $hid=$routes_list[0]->id; 
        $vehicle_no=$routes_list[0]->vehicle; 
        $route_code=$routes_list[0]->route_code; 
        $start_place=$routes_list[0]->start_place; 
        $end_place=$routes_list[0]->end_place; 
        $trip=$routes_list[0]->trip_id; 
              
        $array=array('hid'=>$hid,'vehicle_no'=>$vehicle_no,'route_code'=>$route_code,'start_place'=>$start_place,'end_place'=>$end_place,'trip'=>$trip);
        echo json_encode($array);
    }

    public function update_data()
    {
        $hid = $this->input->post('hid');
        $vehicle_no = $this->input->post('vehicle_no');
        $routes = $this->input->post('routes');
        $start_point = $this->input->post('start_point');
        $end_point = $this->input->post('end_point');
        $trip = $this->input->post('trip');

        $array = array(
            'vehicle'  => $vehicle_no,
            'route_code'  => $routes,
            'start_place'  => $start_point,
            'end_place'  => $end_point,
            'trip'  => $trip,
        );
       
        $this->dbconnection->update('routes',$array,'id='.$hid);
   
        $routes_data = $this->db->query("select r.vehicle,(select vehicle_no from vehicle where id=r.vehicle) as vehicle_name,r.route_code,r.start_place,(select location_description from locations where id=r.start_place) as start_point,r.end_place,(select location_description from locations where id=r.end_place) as end_point,r.trip_id,(select trip_name from trip where id=r.trip_id) as trip_name from routes r where status=1")->result();
        ?>
        <table class="table table-bordered table-striped" id="book_publisher">
                    <thead style="background:#99ceff;">
                      <tr>
                        <th>Sl No.</th>
                        <th>Route Code</th>
                        <th>Vehicle No</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Trip</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php $x = 1;foreach($routes_data as $value){?>
                        <tr>
                            <td><?php echo $x;?>.</td>
                            <td><?php echo $value->route_code;?></td>
                            <td><?php echo $value->vehicle_name;?></td>
                            <td><?php echo $value->start_point;?></td>
                            <td><?php echo $value->end_point;?></td>
                            <td><?php echo $value->trip_name; ?></td>
                            <td><a  data-toggle="tooltip" data-placement="top" title="Edit" onclick="update(<?php echo $value->id;?>)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a data-toggle="tooltip" data-placement="top" title="Delete" style="cursor: pointer;" onclick="deletes(<?php echo $value->id;?>)"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                </tr>
                <?php $x++;}?>
            </tbody>
        </table>
        <script type="text/javascript">
            $(document).ready(function() {
              $('#book_publisher').DataTable();
            });
        </script>
    <?php
}
    function delete()
    {
        $id = $this->input->post(id);
        $array = array('id'=>$id);
        $this->dbconnection->delete('routes',$array);
        $routes_data = $this->db->query("select r.vehicle,(select vehicle_no from vehicle where id=r.vehicle) as vehicle_name,r.route_code,r.start_place,(select location_description from locations where id=r.start_place) as start_point,r.end_place,(select location_description from locations where id=r.end_place) as end_point,r.trip_id,(select trip_name from trip where id=r.trip_id) as trip_name from routes r where status=1")->result();
        ?>
        <table class="table table-bordered table-striped" id="book_publisher">
                    <thead style="background:#99ceff;">
                      <tr>
                        <th>Sl No.</th>
                        <th>Route Code</th>
                        <th>Vehicle No</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Trip</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php $x = 1;foreach($routes_data as $value){?>
                        <tr>
                            <td><?php echo $x;?>.</td>
                            <td><?php echo $value->route_code;?></td>
                            <td><?php echo $value->vehicle_name;?></td>
                            <td><?php echo $value->start_point;?></td>
                            <td><?php echo $value->end_point;?></td>
                            <td><?php echo $value->trip_name; ?></td>
                            <td><a  data-toggle="tooltip" data-placement="top" title="Edit" onclick="update(<?php echo $value->id;?>)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a data-toggle="tooltip" data-placement="top" title="Delete" style="cursor: pointer;" onclick="deletes(<?php echo $value->id;?>)"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                </tr>
                <?php $x++;}?>
            </tbody>
        </table>
        <script type="text/javascript">
            $(document).ready(function() {
              $('#book_publisher').DataTable();
            });
        </script>
        <?php
    }

    public function savetrip()
    {
        $trip_name=$this->input->post('trip_name');
        $data = array(
            'trip_name' =>$trip_name ,
             );
        $this->dbconnection->insert('trip',$data);
    }
}
