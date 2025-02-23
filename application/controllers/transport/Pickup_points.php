<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pickup_points extends MY_ListController
{
	public function __construct()
	{
                $this->page_code = 'pickup_points';
                
		parent::__construct();
		
		$this->page_title = 'Route Pickup Points';
		$this->rec_type = 'Pickup Point';
		$this->rec_types = 'Pickup Points';
		$this->section = 'transport';
		$this->dbtable = 'transport_pickup_points';
		$this->display_columns = array('id' => 'ID', 'route_id_disp' => 'Route Code', 'location_id_disp' => 'Pickup Location', 'pick_up_time' => 'Pickup Time', 
				);
		$this->edit_columns = array(
				'route_id' => array('disp' => 'Route Code', 'type' => 'select', 'select_opts' => $this->dbconnection->select('routes', 'id AS opt_id, route_code AS opt_disp')),
				'location_id' => array('disp' => 'Pickup Location', 'type' => 'select', 'select_opts' => $this->dbconnection->select('locations', 'id AS opt_id, location_description AS opt_disp')),
				'pick_up_time' => array('disp' => 'Pickup Time', 'type' => 'time', 'required' => TRUE),
				);
		$this->search_columns = array(
				'alpha_num' => array(
					),
				'numeric' => array(
					),
				);
		$this->rec_key = 'id';
		$this->data_table = $this->dbtable . ' AS t1';
		$this->data_select = 'id, pick_up_time, ' . 
				'route_id, (SELECT route_code FROM routes AS t2 WHERE t2.id=t1.route_id) AS route_id_disp, ' .
				'location_id, (SELECT location_description FROM locations AS t2 WHERE t2.id=t1.location_id) AS location_id_disp, ';	
		$this->data_select_where = 'status=1';
		$this->data_delete = 'UPDATE';
		$this->data_delete_update = array('status' => '0');
		
		$this->admission_csv_columns = array(
				array('field' => 'location_id', 'human_name' => 'Location'),//0
				array('field' => 'route_id', 'human_name' => 'Route Name'),//1
				array('field' => 'pick_up_time', 'human_name' => 'Pickup Time'),//2

				);
	}
	
	public function download_format() {
        $this->load->helper('download');
        $fh = fopen('php://memory', 'w');
        
        fputcsv($fh, array_column($this->admission_csv_columns, 'human_name'));
        fseek($fh, 0);
        $csv = stream_get_contents($fh);
        force_download('FeesClub-Pickup-NewUPLOAD-Format.csv', $csv);
    }
	
	public function importcsv() {

        $this->data['page_name'] = 'upload_pickup';
        $this->data['page_title'] = 'Upload Pickup';
        $this->data['section'] = 'transport';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;
		$this->data['fetch_route'] = $this->dbconnection->select("routes", "id,route_code", "status=1");
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
		
		
		$query = $this->dbconnection->select_returnarray("locations", "id,location_description");
        $locations = array_change_key_case(array_column($query, 'id', 'location_description'));
		
		$query = $this->dbconnection->select_returnarray("routes", "id,route_code");
        $route = array_change_key_case(array_column($query, 'id', 'route_code'));

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
                // if (in_array($rowarr['route_id'], $location_file)) {
                    // $this->data['errors'][] = "Pickup'" . $rowarr['route_id'] . "' previously present in this file, skipping...";
                    // continue;
                // }

                // $location_file[] = $rowarr['route_id'];
                // if (isset($route_code[$rowarr['route_id']])) {
                    // $this->data['errors'][] = "Pickup '" . $rowarr['route_id'] . "' already present, skipping...";
                    // continue;
                // }
				
				if (!isset($locations[$rowarr['location_id']])) {
                    $this->data['errors'][] = "Pickup '" . $rowarr['route_id'] . "' has undefined Location of '" . $rowarr['location_id'] . "', skipping...";
                    continue;
                }
				
				if (!isset($route[$rowarr['route_id']])) {
                    $this->data['errors'][] = "Pickup '" . $rowarr['route_id'] . "' has undefined Routes of '" . $rowarr['route_id'] . "', skipping...";
                    continue;
                }


				


                $data_student = array(
				
					"location_id" => $locations[$rowarr['location_id']],
                    "route_id" => $route[$rowarr['route_id']],
					"pick_up_time" =>$rowarr['pick_up_time'],

                );
                $this->db->insert('transport_pickup_points', $this->security->xss_clean($data_student));
                $employee_id = $this->dbconnection->get_last_id();
                
                $audit = array("action" => 'Upload Pickup Information',
                    "module" => "TRANSPORT",
                    'datetime' => date("Y-m-d H:i:s"),
                    'userid' => $this->session->userdata('user_id'),
                    'student_id' => $employee_id,
                    'page' => 'upload_pickup',
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

    public function pickup_points()
    {
        $this->data['transport_pickup_points'] = $this->db->query("select tpp.id, tpp.pick_up_time,tpp.amounts,tpp.location_id,(select location_description from locations where id=tpp.location_id) as location_name,tpp.route_id,(select route_code from routes where id=tpp.route_id) as route_name from transport_pickup_points tpp where status='1'")->result();
        $this->data['route_code'] = $this->dbconnection->select('routes','*','status=1');
        $this->data['location'] = $this->dbconnection->select('locations', '*','');
        $this->data['page_name'] = 'pickup_points';
        $this->data['page_title'] = 'pickup_points';
        $this->data['section'] = 'transport';
        $this->data['customview'] = '';
        $this->load->view('index', $this->data);
    }

    function save()
    {
        $routes = $this->input->post('routes');
        $pick_up_time = $this->input->post('pickup_time');
        $location_id = $this->input->post('location');
        $amounts = $this->input->post('amounts');

        $array = array(
            'route_id'  => $routes,
            'pick_up_time'  => $pick_up_time,
            'location_id'  => $location_id,
            'amounts'  => $amounts,
        );
        $this->dbconnection->insert('transport_pickup_points', $array);
        $pickup_data = $this->db->query("select tpp.id, tpp.pick_up_time,tpp.amounts,tpp.location_id,(select location_description from locations where id=tpp.location_id) as location_name,tpp.route_id,(select route_code from routes where id=tpp.route_id) as route_name from transport_pickup_points tpp where status='1'")->result();
        ?>
       <table class="table table-bordered table-striped" id="book_publisher">
                    <thead style="background:#99ceff;">
                      <tr>
                        <th>Sl No.</th>
                        <th>Route Code</th>
                        <th>Pickup Location</th>
                        <th>Time</th>
                        <th>Amount</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php $x = 1;foreach($pickup_data as $value){?>
                        <tr>
                            <td><?php echo $x;?>.</td>
                            <td><?php echo $value->route_name;?></td>
                            <td><?php echo $value->location_name;?></td>
                            <td><?php echo $value->pick_up_time;?></td>
                            <td><?php echo $value->amounts;?></td>
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
        $pickup_data = $this->db->query("select tpp.id, tpp.pick_up_time,tpp.amounts,tpp.location_id,(select location_description from locations where id=tpp.location_id) as location_name,tpp.route_id,(select route_code from routes where id=tpp.route_id) as route_name from transport_pickup_points tpp where status='1' and id=".$id)->result();
        $hid=$pickup_data[0]->id; 
        $pick_up_time=$pickup_data[0]->pick_up_time; 
        $amounts=$pickup_data[0]->amounts; 
        $location_id=$pickup_data[0]->location_id; 
        $route_id=$pickup_data[0]->route_id;
              
        $array=array('hid'=>$hid,'pick_up_time'=>$pick_up_time,'amounts'=>$amounts,'location_id'=>$location_id,'route_id'=>$route_id);
        echo json_encode($array);
    }

    public function update_data()
    {
        $hid = $this->input->post('hid');
        $routes = $this->input->post('routes');
        $pick_up_time = $this->input->post('pickup_time');
        $location_id = $this->input->post('location');
        $amounts = $this->input->post('amounts');

         $array = array(
            'route_id'  => $routes,
            'pick_up_time'  => $pick_up_time,
            'location_id'  => $location_id,
            'amounts'  => $amounts,
        );
       
        $this->dbconnection->update('transport_pickup_points',$array,'id='.$hid);
   
        $pickup_data = $this->db->query("select tpp.id, tpp.pick_up_time,tpp.amounts,tpp.location_id,(select location_description from locations where id=tpp.location_id) as location_name,tpp.route_id,(select route_code from routes where id=tpp.route_id) as route_name from transport_pickup_points tpp where status='1'")->result();
        ?>
       <table class="table table-bordered table-striped" id="book_publisher">
                    <thead style="background:#99ceff;">
                      <tr>
                        <th>Sl No.</th>
                        <th>Route Code</th>
                        <th>Pickup Location</th>
                        <th>Time</th>
                        <th>Amount</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php $x = 1;foreach($pickup_data as $value){?>
                        <tr>
                            <td><?php echo $x;?>.</td>
                            <td><?php echo $value->route_name;?></td>
                            <td><?php echo $value->location_name;?></td>
                            <td><?php echo $value->pick_up_time;?></td>
                            <td><?php echo $value->amounts;?></td>
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
        $pickup_data = $this->db->query("select tpp.id, tpp.pick_up_time,tpp.amounts,tpp.location_id,(select location_description from locations where id=tpp.location_id) as location_name,tpp.route_id,(select route_code from routes where id=tpp.route_id) as route_name from transport_pickup_points tpp where status='1'")->result();
        ?>
        <table class="table table-bordered table-striped" id="book_publisher">
                    <thead style="background:#99ceff;">
                      <tr>
                        <th>Sl No.</th>
                        <th>Route Code</th>
                        <th>Pickup Location</th>
                        <th>Time</th>
                        <th>Amount</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php $x = 1;foreach($pickup_data as $value){?>
                        <tr>
                            <td><?php echo $x;?>.</td>
                            <td><?php echo $value->route_name;?></td>
                            <td><?php echo $value->location_name;?></td>
                            <td><?php echo $value->pick_up_time;?></td>
                            <td><?php echo $value->amounts;?></td>
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
}
