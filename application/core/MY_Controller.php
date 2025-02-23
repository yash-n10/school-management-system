<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_ListController extends CI_Controller
{
    public $page_code = '';
    public $page_id='';
    public $page_perm='----';
    
	public function __construct()
	{
		parent::__construct();
		if (empty($this->session->userdata('user_id'))) {
			redirect('/login');
		}
                
                $this->page_id=$this->dbconnection->Get_namme("link_page","l_code","$this->page_code","id");
                
		$this->id = $this->session->userdata('school_id');
		$this->user_group_id = $this->session->userdata('user_group_id');
		if ($this->user_group_id == 3) {       //for school
			   $this->user_groups=$this->dbconnection->select('user_group','id,group_type',"id not in(1,2,3)");
		} elseif ($this->user_group_id == 2) { // for supervisor
			   $this->user_groups=$this->dbconnection->select('user_group','id,group_type',"id not in(1,2)");
		} else {                             // for administrator
			   $this->user_groups=$this->dbconnection->select('user_group','*');
		}
		$this->school=$this->dbconnection->select('school','*', "id=".$this->id." and status = 1"); 
                $this->school_code=$this->session->userdata('school_code');
		if ($this->id !=0 ) $this->db->db_select('crmfeesclub_'.$this->id);

		$this->read_only = FALSE;
                
                $permission=$this->dbconnection->select("user_group_permission","permission","link_code=$this->page_id and user_group_id={$this->session->userdata('user_group_id')}");
                $this->page_perm=!empty($permission) ? $permission[0]->permission:'----';
                $this->right_access=$this->page_perm;

                if(strpos($this->page_perm, '----') == true) {
                    redirect(base_url(''), 'refresh');
                }
                
	}

/*  --------------------------------      Record View      ------------------------------------ */
	public function index()
	{
            
                if (substr($this->right_access, 1, 1) != 'R') {
        //            redirect(base_url(), 'refresh');
                    redirect('404');
                }
		$this->data['school'] = isset($this->school_desc[0]->description) ? $this->school_desc[0]->description : '';

		$this->data['page_title'] = $this->page_title;
		$this->data['rec_type'] = $this->rec_type;
		$this->data['rec_types'] = $this->rec_types;
		$this->data['display_columns'] = $this->display_columns;
		$this->data['edit_columns'] = $this->edit_columns;
		$this->data['rec_key'] = $this->rec_key;
		$this->data['section'] = $this->section;
		$this->data['read_only'] = isset($this->read_only) ? $this->read_only : FALSE;
		$this->data['modal_form'] = isset($this->modal_form) ? $this->modal_form : array('status'=>TRUE);
        $this->data['stdview'] = isset($this->stdview) ? $this->stdview : 'generic_list';
        $this->data['right_access']  = isset($this->right_access) ? $this->right_access : 'CRUD';
//		if (isset($this->data_select_where)) $where = $this->data_select_where; else $where = '';
//		if (isset($this->data_select_order)) $order = $this->data_select_order; else $order = '';

		$this->load->view('index', $this->data);
	}

        public function add_form() {   //if $this->modal_form['status']==FALSE
            
            if(substr($this->right_access,0,1)!='C'){
                redirect('404');
            }
            
                $this->data =[
                    'page_name'             => $this->modal_form['page_name'],
                    'page_title'            => $this->page_title,
                    'section'               => $this->section,
                    'customview'            => '',
                    'edit_columns'          => $this->edit_columns,
                    'school'                => $this->school,
                    'task'                  => 'Save',
                    
                    ];
                    $this->load->view('index', $this->data);
            
        }
        
        
        public function edit_form($id) {
            
            if(substr($this->right_access, 2,1)!='U') {
                redirect('404');
            }
                $this->data =[
                    'page_name'             => $this->modal_form['page_name'],
                    'page_title'            => $this->page_title,
                    'section'               => $this->section,
                    'customview'            => '',
                    'edit_columns'          =>$this->edit_columns,
                    'school'                => $this->school,
                    'task'                  => 'Update',
                    'data' => $this->dbconnection->select($this->data_table, $this->data_select, "id=$id"),
                    ];
                    // echo "<pre>";print_r($this->data['page_name']);die();
                    $this->load->view('index', $this->data);
        }
        
	public function help()
	{
		$this->data['page_title'] = $this->page_title;
		$this->load->view($this->section . '/help', $this->data);
	}

/*  -------------------------------- To save the new record ---------------------------------- */
	public function add()
	{
            
		if (! $this->input->is_ajax_request() || $this->read_only || substr($this->right_access, 0, 1) != 'C') {
			redirect('404');
		}
		$data = array();
		foreach ($this->edit_columns as $col => $colparams) {
			if (isset($colparams['save_function'])) {
				$data[$col] = $colparams['save_function'] . '(' . trim($this->input->post($col)) . ')';
			} else {
				$data[$col] = trim($this->input->post($col));
			}
		}
                if(isset ($this->extra_add_columns)) {
                        foreach ($this->extra_add_columns as $colk => $colv) {
                                $data[$colk] = $colv;
                        }
                }
		$result = $this->dbconnection->insert($this->dbtable, $this->security->xss_clean($data));
                $this->dbtablelastid=$this->dbconnection->get_last_id();
		//Audit Trail
		$audit = array("action"=> 'Add',
				"module" => $this->page_title,
				"page" => basename(__FILE__, '.php'),
				'datetime' => date("Y-m-d H:i:s"),
				'userid' => $this->session->userdata('user_id'),
				'remarks' => 'ID:'.$this->dbtablelastid,
				'ip_address' => $_SERVER['REMOTE_ADDR'],
				);
		$this->dbconnection->insert("auditntrail",$audit);
		echo 1;
	}

/* ----------------------------- To Update the record ------------------------------------------- */
        public function update($id)
        {
//		$id = $this->uri->segment(4);
		if (!$this->input->is_ajax_request() || $this->read_only || substr($this->right_access, 2, 1) != 'U') {
			redirect('404');
		}

		$data = array();
		foreach ($this->edit_columns as $col => $colparams) 
		{
			if (isset($colparams['save_function'])) {
				$data[$col] = $colparams['save_function'] . '(' . trim($this->input->post($col)) . ')';
			} elseif (isset($colparams['save_function_php'])) {
				$data[$col] = $colparams['save_function_php'](trim($this->input->post($col)));
			} else {
				$data[$col] = trim($this->input->post($col));
			}
		}
                
                if(isset ($this->extra_edit_columns)) {
                        foreach ($this->extra_edit_columns as $colk => $colv) {
                                $data[$colk] = $colv;
                        }
                }

		$this->updateind=$this->dbconnection->update($this->dbtable, $this->security->xss_clean($data), array('id'=> $id));

		//Audit Trail
		$audit = array("action"=> 'Update',
				"module" => $this->page_title,
				"page" => basename(__FILE__, '.php'),
				'datetime' => date("Y-m-d H:i:s"),
				'userid' => $this->session->userdata('user_id'),
				'remarks' => 'ID:'.$id,
				'ip_address' => $_SERVER['REMOTE_ADDR'],
				);
		$this->dbconnection->insert("auditntrail",$audit);

		echo 1;

	}

/* -------------------------------- To Delete the record ---------------------------------------- */
        public function delete()
        {
		if (!$this->input->is_ajax_request() || $this->read_only || substr($this->right_access, 3, 1) != 'D') {
			redirect('404');
		}
                $last = $this->uri->total_segments();
		$id = $this->uri->segment($last);
                
		if ($id != trim($this->input->post('id'))) return false;

		if (!isset($this->data_delete) || $this->data_delete == 'DELETE') {
			$this->delind=$this->dbconnection->delete($this->dbtable, array('id'=> trim($this->input->post('id')) ) );
		} elseif (isset($this->data_delete) && $this->data_delete == 'UPDATE' && isset($this->data_delete_update) && is_array($this->data_delete_update)) {
			$this->delind=$this->dbconnection->update($this->dbtable, $this->data_delete_update, array('id'=> $id));
                       
		} else {
                 
			return false;
                        
		}

		//Audit Trail
		$audit = array("action"=> 'Delete',
				"module" => $this->page_title,
				"page" => basename(__FILE__, '.php'),
				'datetime' => date("Y-m-d H:i:s"),
				'userid' => $this->session->userdata('user_id'),
				'remarks' => 'ID:'.$id,
				'ip_address' => $_SERVER['REMOTE_ADDR'],
				);
		$this->dbconnection->insert("auditntrail",$audit);
		echo 1;
	}

	public function paged_data()
	{
		if(! $this->input->is_ajax_request()) {
			redirect('404');
		}

		if (isset($this->data_select_where)) $where = $this->data_select_where; else $where = '';
		$like = array();
		$or_like = array();
		$order = '';
		$rec_key = $this->rec_key;

		$offset = $this->input->post('start');
		$limit = $this->input->post('length');

		// Map column names to positions used by datatable
		$colno = 0;
		$colnotoname = array();
		foreach ($this->display_columns as $field => $disp) {
			$colnotoname[$colno] = $field;
			$colno++;
		}
		$orderpartsarr = array();
		foreach ($this->input->post('order') as $orderpart) {
			if (isset($colnotoname[$orderpart['column']])) {
				if ($orderpart['dir'] == 'asc') {
					$orderpartsarr[] = $colnotoname[$orderpart['column']] . " ASC";
				} else {
					$orderpartsarr[] = $colnotoname[$orderpart['column']] . " DESC";
				}
			}
		}
		if (count($orderpartsarr) > 0) {
			$order = implode(', ', $orderpartsarr);
		}

		$search = $this->input->post('search');
		if (ctype_digit($search['value'])) {
			$search_cols = $this->search_columns['numeric'] + $this->search_columns['alpha_num'];
		} elseif ($search['value'] != '') {
			$search_cols = $this->search_columns['alpha_num'];
		} else {
			$search_cols = array();
		}
		foreach ($search_cols AS $search_col) {
			$or_like[] = array('col' => $search_col, 'val' => $search['value']);
		}

                $v=0;
                $requestData= $_REQUEST;
                foreach ($this->display_columns as  $field => $disp) {
                    if(!empty($requestData['columns'][$v]['search']['value'])){
                        $or_like[] = array('col' => $field, 'val' => $requestData['columns'][$v]['search']['value']);
                    }
                    $v++;
                }
                
		$output = array('draw' => $this->input->post('draw'));
		$output['orderpartsarr'] = $orderpartsarr;
		$output['order'] = $order;

		$output['recordsTotal'] = $this->dbconnection->count($this->data_table, $where);
		$output['recordsFiltered'] = $this->dbconnection->count($this->data_table, $where,$like,$or_like);

		$records = $this->dbconnection->select_limit_query($this->data_table,$this->data_select,$where,$order,$limit,$offset,$like,$or_like);
                
                $right_access  = isset($this->right_access) ? $this->right_access : 'CRUD';
		$records_arr = array();
                
		foreach ($records as $rec) {
                        $recactions  ='';
			$recarr = array();
			foreach ($this->display_columns as $field => $disp) {
				$recarr[] = $rec->$field;
			}
//			if (!$this->read_only) {
			
                                if (substr($right_access, 2,1)=='U') {
				$recactions = "<a class=\"btn a-edit\" onclick=\"edit_rec('{$rec->$rec_key}');\" data-toggle=\"tooltip\" title=\"Edit\" data-placement=\"bottom\"><i class=\"fa fa-edit\"></i></a>";
                                }
				if (substr($right_access, 3,1)=='D') {
					$recactions .= "<a class=\"btn a-delete\" data-toggle=\"modal\" onclick=\"delete_rec('{$rec->$rec_key}');\" title=\"Delete\"><i class=\"fa fa-trash\"></i></a>";
				}
				if (isset($this->edit_columns['lat']) && isset($this->edit_columns['long'])) {
					$recactions .= "<a class=\"btn\" target='_blank' href='https://www.google.com/maps/place/$rec->location_description/@$rec->lat,$rec->long,8z'><i class=\"fa fa-map\"></i> Map</a>";
				}
                                if($this->page_code=='exam') {
                                        $recactions .= "<a class=\"btn \" onclick=\"exam_schedule('{$rec->$rec_key}');\" style=\"color: rgb(0, 39, 255);padding: 0 8px;\" title=\"Exam Schedule\"><i class=\"fa fa-calendar\"></i></a>";
                                }
				$recarr[] = $recactions;
//                        }
			$records_arr[] = $recarr;
		}

		$output['data'] = $records_arr;

		echo json_encode($output);

	}

	public function getrec($id)
	{
		if(! $this->input->is_ajax_request()) {
			redirect('404');
		}

		$data = $this->dbconnection->select($this->data_table, $this->data_select, "id=$id");

		echo json_encode($data);
	}

	public function exportcsv()
	{
		$records = $this->dbconnection->select($this->data_table, $this->data_select,$this->data_select_where);

		$filename = "FCLB-$this->school_code-$this->rec_type-Export-" . date('Ymd') . ".csv";

		header( 'Content-Type: text/csv' );
		header( 'Content-Disposition: attachment;filename='.$filename);

		$colnames = array();
		foreach ($this->display_columns as $field => $disp) {
			$colnames[] = $disp;
		}
                if(!isset($this->export_edit_columns) || $this->export_edit_columns){
                    foreach ($this->edit_columns as $col => $colparams) {
                            if (!isset($this->display_columns[$col])) {
                                    $colnames[] = $colparams['disp'];
                            }
                    }
                }
		$out = fopen('php://output', 'w');
		fputcsv($out, $colnames);
		foreach ($records as $rec) {
			$recarr = array();
			foreach ($this->display_columns as $field => $disp) {
				$recarr[] = $rec->$field;
			}
                        if(!isset($this->export_edit_columns) || $this->export_edit_columns){
			foreach ($this->edit_columns as $col => $colparams) {
				if (!isset($this->display_columns[$col])) {
					$recarr[] = $rec->$col;
				}
			}
			}
			fputcsv($out, $recarr);
		}
		fclose($out);
	}
        
        
        public function duplication_check() {
            
            $field=trim($this->input->post('field_name'));
            $value=trim($this->input->post('value'));
            $fetch=array();
            $fetch=$this->dbconnection->select($this->dbtable,"id","$field='$value'");
            if(count($fetch)>0) {
                $msg= ucwords($field).' Already Exist. Please Try Another';
            }else{
                $msg='';
            }
            echo $msg; 
        }

}
