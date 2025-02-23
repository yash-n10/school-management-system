<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Task_model extends MY_Model {
	
	
	function insert_task($taskdata){
		return $this->db->insert('tasks',$taskdata);
	}
	function gettasks($user_id,$login_type){
		$this->db->where('task_user_id',$user_id);
		$this->db->where('task_user_type',$login_type);
		$this->db->order_by('task_modified_date', desc);
		$query = $this->db->get_where('tasks');
		return $query->result();
	}
	function gettask($taskid){
		$this->db->where('task_id',$taskid);
		$query = $this->db->get_where('tasks');
		return $query->row_array();
	}
	function update_task($taskdata,$taskid){
		$this->db->where('task_id',$taskid);
		return $this->db->update('tasks',$taskdata);
	}
	function delete_task($taskid){
		$this->db->where('task_id',$taskid);
		return $this->db->delete('tasks',$taskdata);
	}
	function getcounttask($user_id,$login_type,$sdate,$edate){
		$this->db->where('task_user_id',$user_id);
		$this->db->where('task_user_type',$login_type);
		$this->db->where('task_status !=','completed');
		$this->db->where('task_start_date >=',$sdate);
		$this->db->where('task_end_date <=',$edate);
		
		return $this->db->count_all_results('tasks');
	}
	
	//load subjects in teacher
	public function getsubject($fc_id,$ft_id)
	{
		$this->db->select('*');
		$this->db->where('class_id',$fc_id);
		$this->db->where('teacher_id',$ft_id);
		$query = $this->db->get_where('subject');
		return $query->result();
	}
	
}