<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function insert($data, $table)
	{
		$this->db->insert($table, $data);
	}
	/* Insert multiple records */
    public function insert_batch($table='',$data='')
    {
        $result = $this->db->insert_batch($table,$data);
        return $result;
    }
	public function get_rows($filters = array(), $table)
	{
		$this->db->from($table);

		if (isset($filters['select']))
			$this->db->select($filters['select']);

		if (isset($filters['where']))
			$this->db->where($filters['where']);

		if (isset($filters['where_in']))
			$this->db->where_in($filters['where_in']['field'], $filters['where_in']['value']);
		
		if (isset($filters['or_where_in']))
			$this->db->or_where_in($filters['or_where_in']['field'], $filters['or_where_in']['value']);

		if (isset($filters['where_not_in']))
			$this->db->where_not_in($filters['where_not_in']['field'], $filters['where_not_in']['value']);

		if (isset($filters['orderby']))
			$this->db->order_by($filters['orderby']['field'],$filters['orderby']['order']);
		
		if (isset($filters['multiple_orderby']))
		{
			if(key_exists('secure', $filters['multiple_orderby'])){
				$secure = $filters['multiple_orderby']['secure'];
			}
			else{
				$secure = 1;
			}
			$this->db->order_by($filters['multiple_orderby']['order_by'], '', $secure);
		}
			
		if (isset($filters['join']))
		{
			foreach ($filters['join'] as $key => $join)
				$this->db->join($join['table'], $join['condition'], isset($join['type'])?$join['type']:NULL);
		}
		
		if (isset($filters['like']))
		{
			foreach ($filters['like'] as $key => $like)
				$this->db->like($like['field'], $like['value']);
		}
		
		if (isset($filters['or_like']))
		{
			foreach ($filters['or_like'] as $key => $like)
				$this->db->or_like($like['field'], $like['value']);
		}

		/*if (isset($filters['or_where_in']))
			$this->db->or_where_in($filters['or_where_in']);*/

		if (isset($filters['or_where']))
		{
			foreach($filters['or_where'] as $key=>$or_where)
				$this->db->or_where($or_where);
		}

		if (isset($filters['limit']))
			$this->db->limit($filters['limit']['limit'], $filters['limit']['from']);

		if (isset($filters['groupby']))
			$this->db->group_by($filters['groupby']['field']);

		if (isset($filters['query']))
			return $this->db->query($filters['query'])->result();

		if (isset($filters['row']))
		{
			if($filters['row'] == 2)
				return $this->db->get()->row_array();
			else
				return $this->db->get()->row();
		}
		else
		{
			if(isset($filters['result']))
				return $this->db->get()->result_array();
			else
				return $this->db->get()->result();
		}
   }

	public function get_field($field, $where, $table)
	{
		$this->db->from($table);
		$this->db->where($where);
		$row = $this->db->get()->row();
		
		if ($row)
			return $row->$field;
	}

	public function get_count($filters = array(), $table)
	{
		if (isset($filters['select']))
			$this->db->select($filters['select']);
		else
			$this->db->select('count(id) as total');

		if (isset($filters['where']))
			$this->db->where($filters['where']);

		if (isset($filters['join']))
		{
			foreach($filters['join'] as $key => $join) 
				$this->db->join($join['table'], $join['condition'], isset($join['type'])?$join['type']:NULL); 
		}

		$this->db->from($table);

		$row = $this->db->get()->row();
		if ($row)
			return $row->total;
		else
			return 0;
	}

	public function update_table($data, $where, $table, $set='')
	{
		if ($set == 1) 
		{
			$this->db->where('id', $where['id']);

			foreach ($data as $field)
				$this->db->set($field, $field.'+1', FALSE);

			return $this->db->update($table);
		}
		else 
		{
			return $this->db->update($table, $data, $where);
		}
	}

	public function get_columns($table)
	{
		$columns = $this->db->list_fields($table);
		return $columns;
	}

	public function delete($where, $table)
	{
		$this->db->where($where);
		return $this->db->delete($table); 	
	}
	public function insert_counter($data, $table)
	{
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}

	public function data_count($query ,$table='')
	{
		if(isset($query['select']))
			$this->db->select($query['select']);
		if(isset($query['where']))
			$this->db->where($query['where']);
        if(isset($query['where_in']))
            $this->db->where_in($query['where_in']['field'],$query['where_in']['data']);
        if(isset($query['join'])) {
			foreach($query['join'] as $key=>$join) {
				$this->db->join($join['table'], $join['condition'], isset($join['type'])?$join['type']:NULL);
			}
		}
        if(isset($query['where_not_in']))
            $this->db->where_not_in($query['where_not_in']['field'],$query['where_not_in']['data']);
        if(!empty ($table))
            $this->db->from($table);
        else
            $this->db->from($this->tableName);
        
        if(isset ($query['groupby']))
            $this->db->group_by($query['groupby']);
        
        
        return $this->db->get()->num_rows();
	}
	/* Delete multiple records*/
    public function delete_multiple($table = '',$field = '' ,$where_in = '',$where = '')
    {
        if(!empty($where_in))
		{
			$this->db->where_in($field,$where_in);
            if(!empty($where))
                $this->db->where($where);
			$this->db->delete($table);
			if($this->db->affected_rows() > 0)
				return true;
			else
				return false;
		}
    }
}

/* Location: ./application/core/MY_Model.php */