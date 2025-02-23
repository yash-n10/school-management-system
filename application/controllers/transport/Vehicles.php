<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicles extends MY_ListController
{
	public function __construct()
	{
                $this->page_code = 'assignment_homework';
		parent::__construct();


		$this->page_title = 'Vehicles';
		$this->rec_type = 'Vehicle';
		$this->rec_types = 'Vehicles';
		$this->section = 'transport';
		$this->dbtable = 'vehicle';
		$this->display_columns = array('id' => 'ID', 'vehicle_no' => 'Vehicle No.', 'total_seats' => 'Seats', 'max_allot_seats' => 'Usable Seats', 
				'vehicle_type' => 'Vehicle Type', 'contact_person' => 'Contact', 'insurance_renew_date' => 'Insurance Renewal Date',
				);
		$this->edit_columns = array(
				'vehicle_no' => array('disp' => 'Vehicle No', 'type' => 'text', 'required' => TRUE, 'maxlength' => 30),
				'total_seats' => array('disp' => 'Seats', 'type' => 'number', 'required' => TRUE, 'maxlength' => 30),
				'max_allot_seats' => array('disp' => 'Usable Seats', 'type' => 'number', 'required' => TRUE, 'maxlength' => 30),
				'vehicle_type' => array('disp' => 'Vehicle Type', 'type' => 'select', 'select_opts' => array(
							(object) array('opt_id' => 'Ownership', 'opt_disp' => 'Ownership'),
							(object) array('opt_id' => 'Contract', 'opt_disp' => 'Contract'),
							),
						),
				'contact_person' => array('disp' => 'Contact', 'type' => 'text', 'required' => TRUE, 'maxlength' => 50),
				'insurance_renew_date' => array('disp' => 'Insurance Renewal Date', 'type' => 'date', 'required' => TRUE),
				);
		$this->search_columns = array(
				'alpha_num' => array(
					'vehicle_no',
					),
				'numeric' => array(
					),
				);
		$this->rec_key = 'id';
		$this->data_table = $this->dbtable . ' AS t1';
		$this->data_select = 'id, vehicle_no, total_seats, max_allot_seats, vehicle_type, contact_person, insurance_renew_date';
		$this->data_select_where = 'status=1';
		$this->data_delete = 'UPDATE';
		$this->data_delete_update = array('status' => '0');
		
		$this->admission_csv_columns = array(
				array('field' => 'vehicle_no', 'human_name' => 'Vehicle No.'),//0
				array('field' => 'total_seats', 'human_name' => 'TotalSeats'),//1
				array('field' => 'max_allot_seats', 'human_name' => 'Usable Seats'),//2
				array('field' => 'vehicle_type', 'human_name' => 'Vehicle Type'),//3
				array('field' => 'contact_person', 'human_name' => 'Contact'),//4
				array('field' => 'insurance_renew_date', 'human_name' => 'Insurance Renewal Date'),//5

				);
	}
	
	 public function download_format() {
        $this->load->helper('download');
        $fh = fopen('php://memory', 'w');
        
        fputcsv($fh, array_column($this->admission_csv_columns, 'human_name'));
        fseek($fh, 0);
        $csv = stream_get_contents($fh);
        force_download('FeesClub-Vechicle-NewUPLOAD-Format.csv', $csv);
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
        $this->db->select('vehicle_no');
        $query = $this->db->get('vehicle');
        $vechicle_no = array_column($query->result_array(), NULL, 'vehicle_no');
		$vehicle_type =array('Ownership'=>'Ownership','Contract'=>'Contract');

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
                if (in_array($rowarr['vehicle_no'], $location_file)) {
                    $this->data['errors'][] = "Vehicles'" . $rowarr['vehicle_no'] . "' previously present in this file, skipping...";
                    continue;
                }

                $location_file[] = $rowarr['vehicle_no'];
                if (isset($vechicle_no[$rowarr['vehicle_no']])) {
                    $this->data['errors'][] = "Vehicles '" . $rowarr['vehicle_no'] . "' already present, skipping...";
                    continue;
                }
				
				$location_file[] = $rowarr['vehicle_no'];
                if (isset($vechicle_no[$rowarr['vehicle_no']])) {
                    $this->data['errors'][] = "Vehicles '" . $rowarr['vehicle_no'] . "' already present, skipping...";
                    continue;
                }
				
				if (!isset($vehicle_type[$rowarr['vehicle_type']])) {
                    $this->data['errors'][] = "Vehicles'" . $rowarr['vehicle_no'] . "' has undefined vehicle_type of '" . $rowarr['vehicle_type'] . "', skipping...";
                    continue;
                }
				
				if (!empty($data[5]) && date('Y', strtotime(str_replace('/', '-', $data[5]))) == 1970) {
                    $this->data['errors'][] = "Line $linerow: Vehicles '" . $data[0] . "' contains Renewal date Invalid, skipping...";
                    continue;
                }


                $data_student = array(
				
					"vehicle_no" => $rowarr['vehicle_no'],
                    "total_seats" => $rowarr['total_seats'],
					"max_allot_seats" => $rowarr['max_allot_seats'],
                    "vehicle_type" => $rowarr['vehicle_type'],
					"contact_person" => $rowarr['contact_person'],
                    "insurance_renew_date" =>!empty($rowarr['insurance_renew_date'])? date('Y-m-d', strtotime(str_replace('/', '-', $rowarr['insurance_renew_date']))):'',
                );
                $this->db->insert('vehicle', $this->security->xss_clean($data_student));
                $employee_id = $this->dbconnection->get_last_id();
                
                $audit = array("action" => 'Upload Vehicles Information',
                    "module" => "TRANSPORT",
                    'datetime' => date("Y-m-d H:i:s"),
                    'userid' => $this->session->userdata('user_id'),
                    'student_id' => $employee_id,
                    'page' => 'upload_vechicles',
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

        $this->data['page_name'] = 'upload_vechicles';
        $this->data['page_title'] = 'Upload Vehicles';
        $this->data['section'] = 'transport';
        $this->data['customview'] = '';
        $this->data['right_access'] = $this->right_access;

        $this->load->view('index', $this->data);
    }


    public function vehicles_list()
    {
        // if (substr($this->right_access, 1, 1) != 'R') 
        // {
        //     redirect('404');
        // }
        $this->data['vehicle'] = $this->dbconnection->select('vehicle','*','status=1');
        $this->data['page_name'] = 'vehicles';
        $this->data['page_title'] = 'Vehicles';
        $this->data['section'] = 'transport';
        $this->data['customview'] = '';
        $this->load->view('index', $this->data);
    }

    function save()
    {
        $vehicle_no = $this->input->post('vehicle_no');
        $seats = $this->input->post('seats');
        $usable_seats = $this->input->post('usable_seats');
        $vehicle_type = $this->input->post('vehicle_type');
        $contact = $this->input->post('contact');
        $insurance_date = $this->input->post('insurance_date');

        $array = array(
            'vehicle_no'  => $vehicle_no,
            'total_seats'  => $seats,
            'max_allot_seats'  => $usable_seats,
            'vehicle_type'  => $vehicle_type,
            'contact_person'  => $contact,
            'insurance_renew_date'  => $insurance_date,
        );
        // print_r($array);
        // die();
        $this->dbconnection->insert('vehicle', $array);
        $vehicle_data = $this->dbconnection->select("vehicle", "*", "status='1'");
        ?>
        <table class="table table-bordered table-striped" id="book_publisher">
            <thead style="background:#99ceff;">
              <tr>
                <th>Sl No.</th>
                <th>Vehicle No</th>
                <th>Seats</th>
                <th>Usable Seats</th>
                <th>Vehicle Type</th>
                <th>Contact</th>
                <th>Insurance Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                <?php $x = 1;foreach($vehicle_data as $value){?>
                <tr>
                   <td><?php echo $x;?>.</td>
                            <td><?php echo $value->vehicle_no;?></td>
                            <td><?php echo $value->total_seats;?></td>
                            <td><?php echo $value->max_allot_seats;?></td>
                            <td><?php echo $value->vehicle_type;?></td>
                            <td><?php echo $value->contact_person;?></td>
                            <td><?php echo date('d/m/Y',strtotime($value->insurance_renew_date));?></td>
                            <td><a  data-toggle="tooltip" data-placement="top" title="Edit" onclick="update(<?php echo $value->id;?>)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a data-toggle="tooltip" data-placement="top" title="Delete" style="cursor: pointer;" onclick="deletes(<?php echo $value->id;?>)"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                   <!--  <td><a href="" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a data-toggle="tooltip" data-placement="top" title="Delete" style="cursor: pointer;" onclick="deletes(<?php echo $value->id;?>)"><i class="fa fa-trash" aria-hidden="true"></i></a></td> -->
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
        $vechicles_list=$this->dbconnection->select("vehicle","*", "id='$id'");
        $hid=$vechicles_list[0]->id; 
        $vehicle_no=$vechicles_list[0]->vehicle_no; 
        $total_seats=$vechicles_list[0]->total_seats; 
        $max_allot_seats=$vechicles_list[0]->max_allot_seats; 
        $vehicle_type=$vechicles_list[0]->vehicle_type; 
        $contact=$vechicles_list[0]->contact_person; 
        $insurance_date=$vechicles_list[0]->insurance_renew_date;       
              
        $array=array('hid'=>$hid,'vehicle_no'=>$vehicle_no,'total_seats'=>$total_seats,'max_allot_seats'=>$max_allot_seats,'vehicle_type'=>$vehicle_type,'contact'=>$contact,'insurance_date'=>$insurance_date);
        echo json_encode($array);
    }

    public function update_data()
    {
        $hid = $this->input->post('hid');
        $vehicle_no = $this->input->post('vehicle_no');
        $seats = $this->input->post('seats');
        $usable_seats = $this->input->post('usable_seats');
        $vehicle_type = $this->input->post('vehicle_type');
        $contact = $this->input->post('contact');
        $insurance_date = $this->input->post('insurance_date');

        $array = array(
            'vehicle_no'  => $vehicle_no,
            'total_seats'  => $seats,
            'max_allot_seats'  => $usable_seats,
            'vehicle_type'  => $vehicle_type,
            'contact_person'  => $contact,
            'insurance_renew_date'  => $insurance_date,
        );
       
        $this->dbconnection->update('vehicle',$array,'id='.$hid);
   
        $vehicle_data = $this->dbconnection->select("vehicle", "*", "status='1'");
        ?>
                <table class="table table-bordered table-striped" id="book_publisher">
            <thead style="background:#99ceff;">
              <tr>
                <th>Sl No.</th>
                <th>Vehicle No</th>
                <th>Seats</th>
                <th>Usable Seats</th>
                <th>Vehicle Type</th>
                <th>Contact</th>
                <th>Insurance Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                <?php $x = 1;foreach($vehicle_data as $value){?>
                <tr>
                   <td><?php echo $x;?>.</td>
                            <td><?php echo $value->vehicle_no;?></td>
                            <td><?php echo $value->total_seats;?></td>
                            <td><?php echo $value->max_allot_seats;?></td>
                            <td><?php echo $value->vehicle_type;?></td>
                            <td><?php echo $value->contact_person;?></td>
                            <td><?php echo date('d/m/Y',strtotime($value->insurance_renew_date));?></td>
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
        $this->dbconnection->delete('vehicle',$array);
        $vehicle_data = $this->dbconnection->select("vehicle", "*", "status='1'");
        ?>
        <table class="table table-bordered table-striped" id="book_publisher">
            <thead style="background:#99ceff;">
              <tr>
                <th>Sl No.</th>
                <th>Vehicle No</th>
                <th>Seats</th>
                <th>Usable Seats</th>
                <th>Vehicle Type</th>
                <th>Contact</th>
                <th>Insurance Date</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
                <?php $x = 1;foreach($vehicle_data as $value){?>
                <tr>
                    <td><?php echo $x;?>.</td>
                    <td><?php echo $value->vehicle_no;?></td>
                    <td><?php echo $value->total_seats;?></td>
                    <td><?php echo $value->max_allot_seats;?></td>
                    <td><?php echo $value->vehicle_type;?></td>
                    <td><?php echo $value->contact_person;?></td>
                    <td><?php echo date('d/m/Y',strtotime($value->insurance_renew_date));?></td>
                           
                    <td><a href="" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>&nbsp;&nbsp;<a data-toggle="tooltip" data-placement="top" title="Delete" style="cursor: pointer;" onclick="deletes(<?php echo $value->id;?>)"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
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
