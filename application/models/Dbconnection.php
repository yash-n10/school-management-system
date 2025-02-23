<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dbconnection extends CI_Model {
	function __construct(){
		// Call the Model constructor
		parent::__construct();
		$db = $this->load->database();
	}

	function insert($table,$data){
		$res = $this->db->insert($table, $data);
		if($res){
			return true;
		}else{
			return $this->db->error();
		}
	}

	function select($table,$select,$where='',$order='',$order_type='ASC',$fals='', $group_by = array(), $limit = '', $offset = '') {
		$this->db->select($select);
		$this->db->from($table);
		if ($where != '' && $fals=='') {
			$this->db->where($where);
		}else if($where != '' && !empty($fals)){
                    $this->db->where($where, NULL, FALSE);
                }
                if (is_array($group_by) && count($group_by) > 0) {
                    $this->db->group_by($group_by);
                }
		if ($order != '') {
			$this->db->order_by($order,$order_type);
		}
                if ($offset != '' && $limit != '') {
                    $this->db->limit($limit, $offset);
                } else if ($limit != '') {
                    $this->db->limit($limit);
                }

		$query = $this->db->get();

		return $query->result(); 
	}
        
        function select_returnarray($table, $select, $where = '', $order = '', $order_type = 'ASC', $group_by = array(), $limit = '', $offset = '') {
            $this->db->select($select);
            $this->db->from($table);
            if ($where != '') {
                $this->db->where($where);
            }
            if (is_array($group_by) && count($group_by) > 0) {
                $this->db->group_by($group_by);
            }
            if ($order != '') {
                $this->db->order_by($order, $order_type);
            }
            if ($offset != '' && $limit != '') {
                $this->db->limit($limit, $offset);
            } else if ($limit != '') {
                $this->db->limit($limit);
            }

            $query = $this->db->get();

            return $query->result_array();
        }

	function count($table, $where='',$likearr = array(),$or_likearr = array()) 
	{
		if ($where != '') {
			$this->db->where($where);
		}

		if (is_array($likearr) && count($likearr) > 0) {
			$this->db->group_start();
			foreach ($likearr as $like) {
				$this->db->like($like['col'],$like['val']);
			}
			$this->db->group_end();
		}

		if (is_array($or_likearr) && count($or_likearr) > 0) {
			$this->db->group_start();
			foreach ($or_likearr as $or_like) {
				$this->db->or_like($or_like['col'],$or_like['val']);
			}
			$this->db->group_end();
		}

		$this->db->from($table);

		return $this->db->count_all_results();
	}

	function select_join($table,$select,$where='',$table_join,$table_join_on,$join_type=''){
		$this->db->select($select); 
		$this->db->from($table);
		if($where != ''){
			$this->db->where($where);
		}
		$this->db->join($table_join,$table_join_on,$join_type);

		$query = $this->db->get();

		return $query->result(); 
	}

	function select_order($table,$select,$where='',$order_by,$order_type)
	{
		$this->db->select($select); 
		$this->db->from($table);
		if($where != ''){
			$this->db->where($where);
		}
		$this->db->order_by($order_by,$order_type);

		$query = $this->db->get();

		return $query->result(); 
	}

	function update($table,$data,$where){
		$res = $this->db->update($table, $data, $where);
		if($res){
			return true;
		}else{
			return $this->db->_error_message();
		}
	}

	function delete($table, $where=array()){
		$res = $this->db->delete($table, $where); 
		if($res){
			return true;
		}else{
			return $this->db->_error_message();
		}
	}

	function get_last_id(){
		return $this->db->insert_id();
	}


	function select_limit_query($table,$select,$where,$order,$limit,$offset = '',$likearr = array(),$or_likearr = array()){
		$this->db->select($select);
		$this->db->from($table);
		if ($where != '') $this->db->where($where);


		if (is_array($likearr) && count($likearr) > 0) {
			$this->db->group_start();
			foreach ($likearr as $like) {
				$this->db->like($like['col'],$or_like['val']);
			}
			$this->db->group_end();
		}
		if (is_array($or_likearr) && count($or_likearr) > 0) {
			$this->db->group_start();
			foreach ($or_likearr as $or_like) {
				$this->db->or_like($or_like['col'],$or_like['val']);
			}
			$this->db->group_end();
		}

		$this->db->order_by($order);
		if ($offset != '') {
			$this->db->limit($limit, $offset);
		} else {
			$this->db->limit($limit);
		}
		$query = $this->db->get();

		return $query->result(); 
	}

	public function get_table_data($table_name,$col_to_fetch,$col_val_arr) 
	{   
		$this->db->select($col_to_fetch);
		$this->db->from($table_name);
		$this->db->where($col_val_arr);
		return $this->db->get()->row()->$col_to_fetch;

	}
	public function Get_namme($tablename, $tbl_pk, $tbl_pk_value, $col_name) {
		$this->db->select($col_name);
		$this->db->from($tablename);
		$this->db->where($tbl_pk, $tbl_pk_value);
                $query = $this->db->get();
                if ($query->num_rows() > 0)
                {
                    $value = $query->row()->$col_name; 

                }
                else{
                    $value='';
                }
                 return $value;
		
	}
	function get_subject_name_by_id($subject_id)
	{
		$query	=	$this->db->get_where('subject' , array('id' => $subject_id))->row();
		return $query->name;
	}
	function get_section_name_by_id($section_id)
	{
		$query	=	$this->db->get_where('section' , array('id' => $section_id))->row();
		return $query->sec_name;
	}
        function get_subject($class_id,$section_id)
	{
		$query = $this->db->query("SELECT t1.subject_id,t2.teacher_id,t3.name,t4.name as teacher_name,t5.class_name,t6.sec_name FROM `class_routine` as t1 left join `class_subject_teacher` as t2 on t2.subject_id = t1.subject_id AND t2.class_id=t1.class_id AND t2.section_id = t1.section_id left join `subject` as t3 on t3.id = t1.subject_id left join `employee` as t4 on t4.id = t2.teacher_id left join `class` as t5 on t5.id=t1.class_id left join section as t6 on t1.section_id = t6.id WHERE  t1.class_id=$class_id AND t1.section_id=$section_id AND t1.status= 1 GROUP BY t1.subject_id HAVING t1.subject_id>0");
		return $query->result();
	}
	function selectexam($examid)
	{
		$query = $this->db->query("SELECT * FROM `exam` WHERE id=$examid");
		return $query->result();
	}
        function GetRoutine($class_id,$sect_id,$day,$date)
	{

		$this->db->select('t1.*,t2.name as subjectname,t3.teacher_id,t4.name as teachername,t6.name as assignedteacher');
		$this->db->from('class_routine as t1');
		$this->db->join('subject as t2', 't2.id = t1.subject_id','left');
		$this->db->join('class_subject_teacher as t3', 't3.class_id = t1.class_id AND t3.section_id=t1.section_id AND t3.subject_id=t1.subject_id','left');
		$this->db->join('employee as t4', 't4.id = t3.teacher_id','left');
		$this->db->join('class_substitute_routine as t5', 't5.class_routine_id = t1.id AND t5.status=1 AND t5.date="'.$date.'"','left');
		$this->db->join('employee as t6', 't6.id=t5.teacher_id','left');
		
		$this->db->where('t1.day', $day);
		$this->db->where('t1.class_id', $class_id);
		$this->db->where('t1.section_id', $sect_id);
		$this->db->where('t1.status', '1');
		$this->db->ORDER_BY('t1.time_start');
		$query = $this->db->get();
		$row = $query->result_array();
		return $row;
	}

function GetRoutineTeacher($teacher_id,$day,$date)
	{

		$this->db->select('t1.*,t2.name as subjectname,t3.teacher_id,t4.name as teachername,t6.name as assignedteacher');
		$this->db->from('class_routine as t1');
		$this->db->join('subject as t2', 't2.id = t1.subject_id','left');
		$this->db->join('class_subject_teacher as t3', 't3.class_id = t1.class_id AND t3.section_id=t1.section_id AND t3.subject_id=t1.subject_id','left');
		$this->db->join('employee as t4', 't4.id = t3.teacher_id','left');
		$this->db->join('class_substitute_routine as t5', 't5.class_routine_id = t1.id AND t5.status=1 AND t5.date="'.$date.'"','left');
		$this->db->join('employee as t6', 't6.id=t5.teacher_id','left');
		
		$this->db->where('t1.day', $day);
		$this->db->where('t1.status', '1');
		$this->db->where('t6.id', $teacher_id);
		$this->db->ORDER_BY('t1.time_start');
		$query = $this->db->get();
		$row = $query->result_array();
		return $row;
	}

//	function get_marks($class_id,$section_id,$student_id,$examid)
//	{
//		$query = $this->db->query("SELECT t1.id,t1.class_id,t4.name as subjectname,t1.section_id,t2.mark_id,t2.mark_obtained,t2.mark_total,t3.pass_mark FROM `class_routine` as t1 left join `mark` as t2 on  t2.student_id=$student_id AND t2.class_id = t1.class_id AND t2.subject_id=t1.subject_id AND t2.exam_id=$examid left join `exam` as t3 on t3.id=t2.exam_id left join `subject` as t4 on t1.subject_id = t4.id WHERE t1.class_id=$class_id AND t1.section_id=$section_id AND t1.status= 1 GROUP BY t1.subject_id HAVING t1.subject_id>0");
//		return $query->result();
//	}
//        function get_marks($class_id,$section_id,$student_id,$examid)
//	{
//		$query = $this->db->query("SELECT t1.id,t1.class_id,t4.name as subjectname,t1.section_id,t2.mark_id,t2.mark_obtained,t2.mark_total,t3.pass_mark,t5.subject_id,t4.id from exam_routine_head as t1,mark as t2,exam as t3,subject as t4,exam_routine_det as t5 where t1.class_id=$class_id AND t1.section_id=$section_id and t2.student_id=$student_id AND t2.class_id = t1.class_id and t3.id=t2.exam_id and t5.subject_id=t4.id and t1.exam_id=$examid;");
//		return $query->result();
//	}
	function get_marks($class_id,$section_id,$student_id,$examid)
	{
		$query = $this->db->query("SELECT t1.id,t1.class_id,t4.name as subjectname,t1.section_id,t2.mark_id,t2.mark_obtained,t2.mark_total,t3.pass_mark FROM `class_routine` as t1 left join `mark` as t2 on  t2.student_id=$student_id AND t2.class_id = t1.class_id AND t2.subject_id=t1.subject_id AND t2.exam_id=$examid left join `exam` as t3 on t3.id=t2.exam_id left join `subject` as t4 on t1.subject_id = t4.id WHERE t1.class_id=$class_id AND t1.section_id=$section_id AND t1.status= 1 GROUP BY t1.subject_id HAVING t1.subject_id>0");
		return $query->result();
	}


	function get_max_value($col_name,$rename,$table,$where='')
	{
		$this->db->select_max($col_name,$rename); 
		$this->db->from($table);
		if($where != ''){
			$this->db->where($where);
		}
		$max_value= $this->db->get()->row()->$rename;
		return $max_value;
	}



	function fetch_information($table,$col_fetch_by,$col_fetch_condition,$fetch_col1='',$fetch_col2='',$fetch_col3='',$fetch_col4='',$fetch_col5='')
	{

		$fetched_data=$this->dbconnection->select("$table","$fetch_col1,$fetch_col2,$fetch_col3,$fetch_col4,$fetch_col5","$col_fetch_by=$col_fetch_condition");
		echo json_encode($fetched_data);

	}
        
        
        function GetTotalStudent($cid,$secti)
	{
		$sect = trim($secti);
		$query = $this->db->query("SELECT t2.* from `section` as t1 JOIN `student` as t2 ON t2.section_id = t1.id WHERE t1.sec_name= '$sect' AND t2.class_id= '$cid' AND t2.section_id=t1.id AND t2.status='Y' AND t1.status='Y'");
		$sql = $this->db->last_query();
		/*$row = $query->row_array(); */
		return $query->num_rows();

		
	}
        function GetSubjectTeacher($clsid,$secid,$subid)
	{
		$querya = $this->db->query("SELECT t2.* FROM `class_subject_teacher` as t1 join `employee` as t2 ON t2.id=t1.teacher_id WHERE t1.class_id = $clsid AND t1.section_id = $secid AND t1.subject_id = $subid AND t1.status = '1'");
                $rowa = $querya->num_rows();
                if($rowa>0)
                {
                  $datas = $querya->row();
                  $name = $datas->name;
                }
                else
                {
                  $name='';
                }
                return $name;
	}
        
        function GetSubjectName($cid,$sid,$day)
	{
		$query = $this->db->query("SELECT t2.*,t1.id as crid,t3.name as pname,t3.id as cpid,t3.time_start,t3.time_start_min,t3.time_end,t3.time_end_min FROM `class_routine` as t1 join `subject` as t2 on t2.id = t1.subject_id left join `class_periods` as t3 on t3.id = t1.period_id WHERE t1.class_id =$cid AND t1.section_id =$sid AND t1.status= 1 AND t2.status = 1 AND t1.day='$day'");

		$datas = $query->result_array();
		return $datas;
	}

	    function GetSubjectTeacherSubs($subjectid,$sectionset,$class_set,$day)
	{

		$query = $this->db->query("select c1.day,c2.teacher_id,c4.name from class_routine c1 ,class_subject_teacher c2,employee c4 where c2.teacher_id=c4.id and c1.class_id='$class_set' and c1.section_id='$sectionset' and c1.day='$day' and  c1.status=1 and c4.status=1 and period_id not in('$subjectid') group by c4.name");

		$datas = $query->result_array();

		return $datas;
	}

        function GetSubjectLists($class_id,$subject_id)
	{
		$query = $this->db->query("SELECT t2.id,t2.name FROM class_routine as t1 join subject as t2 on t2.id = t1.subject_id WHERE t1.class_id=$class_id AND t1.section_id=$subject_id GROUP BY t1.subject_id HAVING t1.subject_id>0");
		return $query->result();
	}

        
        function selectasteacher()
	{
		$query = $this->db->query("SELECT t1.teacher_id,t1.id as idss,t1.date,t1.remarks,t1.status,t2.name,t3.*,t4.class_name,t5.name as subject,t6.sec_name,t7.time_start as tstart,t7.time_start_min as tstart_min,t7.time_end as tend,t7.time_end_min as tend_min,t7.id as pid from `class_substitute_routine` as t1 join `employee` as t2 ON t1.teacher_id = t2.id join `class_routine` as t3 ON t3.id = t1.class_routine_id join `class` as t4 ON t4.id = t3.class_id join `subject` as t5 ON t5.id=t3.subject_id join `section` as t6 on t6.id=t3.section_id left join `class_periods` as t7 on t7.id=t3.period_id WHERE t1.status='1'");

		$datas = $query->result_array();
		return $datas;
	}

	function selectasteacherById($id)
	{
		$query = $this->db->query("SELECT t1.teacher_id,t1.id as idss,t1.date,t1.day,t1.remarks,t1.status,t2.name,t3.*,t4.class_name,t5.name as subject,t6.sec_name from `class_substitute_routine` as t1 join `employee` as t2 ON t1.teacher_id = t2.id join `class_routine` as t3 ON t3.id = t1.class_routine_id join `class` as t4 ON t4.id = t3.class_id join `subject` as t5 ON t5.id=t3.subject_id join `section` as t6 on t6.id=t3.section_id WHERE t1.status='1' AND t1.id=$id");

		$datas = $query->row();
		return $datas;
	}
        
        function selectStudentData($exam,$clas,$sect,$subj)
	{
		$query = $this->db->query("SELECT t1.id,t2.id as cid,t3.id as secid,t1.admission_no,t1.first_name,t2.class_name,t3.sec_name,t4.mark_id,t4.mark_total,t4.mark_obtained,t4.class_id,t5.name as subjectname,t6.grand_total FROM `student` as t1 join `class` as t2 ON t1.class_id=t2.id join `section` as t3 ON t3.id=t1.section_id LEFT JOIN `mark` as t4 ON t4.class_id = $clas AND t4.subject_id = $subj AND t4.exam_id = $exam AND t4.student_id=t1.id join`subject`as t5 ON t5.id = $subj join `exam` as t6 ON t6.id=$exam WHERE t1.class_id=$clas AND t1.section_id=$sect AND t1.status='Y' ORDER BY t1.admission_no ASC");

		$datas = $query->result_array();
		return $datas;
	}

        function selectexamRoomdata($exam)
        {
            $query = $this->db->query("SELECT t1.id,t1.exam_id,t1.room_no,t1.no_of_seats,t2.name from exam_room_head as t1,exam as t2 where t2.id=t1.exam_id and exam_id=$exam");
            $datas = $query->result_array();
		return $datas;
        }

	function CountData($datacheck)
	{
		$this->db->select('count(*) as count');
		$this->db->from('mark');
		$this->db->where($datacheck);
		$query = $this->db->get();
		$row = $query->result();
		return $data = $row[0]->count;
		
	}
//        function GetRoutinedata($pid,$day,$clsid,$sec)
//	{
//		$query = $this->db->query("SELECT cr.id,cr.subject_id,s.name,e.name as tname "
//                        . "FROM `class_routine` as cr "
//                        . "join `subject` as s ON s.id=cr.subject_id "
//                        . "left join `class_subject_teacher` as cst on cst.class_id=cr.class_id AND cst.section_id=cr.section_id AND cst.subject_id=cr.subject_id and cst.status=1 "
//                        . "left join `employee` as e on e.id=cst.teacher_id and e.status='1' "
//                        . "WHERE cr.`class_id` = $clsid AND cr.`section_id` = $sec AND cr.`period_id` = $pid AND cr.`status`='1' AND cr.`day` LIKE '$day'");
//		$rows = $query->result_array();
//		return $rows;
//	}
        function GetRoutinedata($pid,$day,$clsid,$sec,$academic_session)
	{
		$query = $this->db->query("SELECT cr.id,cr.subject_id,s.name,e.name as tname "
                        . "FROM `class_routine` as cr "
                        . "join `subject` as s ON s.id=cr.subject_id and s.status=1 "
                        . "join `class_subject_teacher` as cst on cst.class_id=cr.class_id AND cst.section_id=cr.section_id and cst.status=1 and cst.academic_year_id=cr.academic_year_id and cr.subject_id=cst.subject_id "
                        . "left join `employee` as e on e.id=cst.teacher_id and e.status='1' "
                        . "WHERE cr.`class_id` = $clsid AND cr.`section_id` = $sec AND cr.`period_id` = $pid AND cr.`status`='1' AND cr.`day` LIKE '$day' AND cr.academic_year_id=$academic_session and cst.status=1");
		$rows = $query->result_array();
		return $rows;
	}
        
        function getClassRoutine() {
            return $query =$this->db->query("SELECT cr.id,cr.class_id,cr.section_id,cr.day,cr.period_id,cr.subject_id,s.name,cst.teacher_id,e.name tname "
                    . "FROM class_routine cr "
                    . "join subject s on s.id=cr.subject_id and s.status=1 "

                    . "left join `class_subject_teacher` as cst on cst.class_id=cr.class_id AND cst.section_id=cr.section_id AND cst.subject_id=cr.subject_id and cst.status=1 "
                    . "left join `employee` as e on e.id=cst.teacher_id and e.status='1' "
                    . "WHERE cr.`status`='1' group by cr.id,cr.class_id,cr.section_id,cr.day,cr.period_id;")->result_array();
        }

	function get_classteacher_name_by_id($clid,$sec)
	{
		$query = $this->db->query("SELECT t1.*, t2.name FROM `class_teachet_alloc` as t1 join `employee` as t2 on t2.id=t1.teacher_id WHERE t1.class_id=$clid AND t1.section_id=$sec");
		$rowct = $query->row();
		return $rowct;
	}
        
        
        function GetTeacherData($pid,$day,$tid)
	{
		$query = $this->db->query("SELECT t1.id,t3.class_name,t4.sec_name,t5.name FROM `class_routine` as t1 JOIN `class_subject_teacher` as t2 ON t1.class_id=t2.class_id AND t1.section_id=t2.section_id AND t1.subject_id = t2.subject_id JOIN `class` as t3 on t3.id=t2.class_id JOIN `section` as t4 on t4.id=t2.section_id JOIN `subject` as t5 on t5.id=t2.subject_id WHERE t1.period_id=$pid AND t1.day='$day' AND t2.teacher_id=$tid and t2.status=1 and t1.status=1");
		return $data = $query->row();

	}

	function GetSubsti($todaydate,$day,$tid)
	{
		$query = $this->db->query("SELECT t2.*,t3.class_name,t4.sec_name,t5.name FROM `class_substitute_routine` as t1 JOIN class_routine as t2 ON t2.id=t1.class_routine_id JOIN `class` as t3 on t3.id=t2.class_id JOIN `section` as t4 on t4.id=t2.section_id JOIN `subject` as t5 on t5.id=t2.subject_id WHERE t1.date='$todaydate' AND t1.teacher_id = $tid");
		return $subteac = $query->row();

	}

//		public function selectstudent($exam,$clas,$sect)
//	{
//		$query = $this->db->query("SELECT t1.id,t1.admission_no,t1.first_name,t1.middle_name,t1.last_name,t2.class_name,t3.sec_name FROM `student` as t1 JOIN `class` as t2 on t2.id=t1.class_id JOIN `section` as t3 on t3.id=t1.section_id WHERE t1.`class_id` = $clas AND t1.`section_id` = $sect");
//		return $row = $query->result();
//	}
        
 //       public function selectstudent($exam,$clas,$sect)
//	{
//		$query = $this->db->query("SELECT t1.id as sid,t1.admission_no,t1.first_name,t1.middle_name,t1.last_name,t2.class_name,t3.sec_name FROM `student` as t1 JOIN `class` as t2 on t2.id=t1.class_id JOIN `section` as t3 on t3.id=t1.section_id WHERE t1.`class_id` = $clas AND t1.`section_id` = $sect");
//		return $row = $query->result();
//	}
		public function selectstudent($exam,$clas,$sect)
	{
		$query = $this->db->query("SELECT t1.id,t1.admission_no,t1.first_name,t1.middle_name,t1.last_name,t2.class_name,t3.sec_name FROM `student` as t1 JOIN `class` as t2 on t2.id=t1.class_id JOIN `section` as t3 on t3.id=t1.section_id WHERE t1.`class_id` = $clas AND t1.`section_id` = $sect");
		return $row = $query->result();
	}
        
        public function dbcon()
	{
		$query = $this->db->query("SELECT t1.*,t2.class_name,t3.sec_name,t4.name FROM `assignment` as t1 JOIN `class` as t2 ON t2.id=t1.class_id JOIN `section` as t3 ON t3.id=t1.section_id JOIN `subject` as t4 ON t4.id=t1.subject_id  WHERE t1.status=1");
		return $row = $query->result();
	}

	public function dbcon_ebook_pdf()
	{
		$query = $this->db->query("SELECT t1.*,t2.class_name,t3.sec_name,t4.name FROM `ebooks_pdf` as t1 JOIN `class` as t2 ON t2.id=t1.class_id JOIN `section` as t3 ON t3.id=t1.section_id JOIN `subject` as t4 ON t4.id=t1.subject_id  WHERE t1.status=1");
		return $row = $query->result();
	}

	public function dbcon_ebook_pdf_student($cid,$sid)
	{
		$query = $this->db->query("SELECT t1.*,t2.class_name,t3.sec_name,t4.name FROM `ebooks_pdf` as t1 JOIN `class` as t2 ON t2.id=t1.class_id JOIN `section` as t3 ON t3.id=t1.section_id JOIN `subject` as t4 ON t4.id=t1.subject_id  WHERE t1.status=1 and t1.class_id=$cid AND t1.section_id=$sid order by id desc");
		return $row = $query->result();
	}
        
	public function selectassignment($cid,$sid)
	{
		$query = $this->db->query("SELECT t1.*,t3.name as subject FROM `assignment` as t1  JOIN `subject` as t3 ON t1.subject_id = t3.id  WHERE t1.class_id=$cid AND t1.section_id=$sid  ORDER BY t1.id");
		// $query = $this->db->query("SELECT t1.*,t3.name as subject FROM `assignment` as t1  JOIN `subject` as t3 ON t1.subject_id = t3.id  WHERE t1.class_id=$cid AND t1.section_id=$sid AND t1.dos>CURDATE() ORDER BY t1.id");
		// echo $this->db->last_query();
		return $row = $query->result();
	}
	public function selectCompletassignment($cid,$sid)
	{
		$query = $this->db->query("SELECT t1.*,t3.name as subject FROM `assignment` as t1 JOIN `subject` as t3 ON t1.subject_id = t3.id  WHERE t1.class_id=$cid AND t1.section_id=$sid  ORDER BY t1.id");
		return $row = $query->result(); 
		// print_r($query);
	}

	public function select_homework($clas,$section,$subject,$datesub)
	{
		$query = $this->db->query("SELECT  t1.assi_category_id,t1.id,t1.dos,t1.subject_id,aa.homework_status,aa.homework_upload,t3.id as stid,t1.dos,t2.class_name,t3.section_id,t3.admission_no,t3.first_name,t4.sec_name from assignment as t1 JOIN class as t2 ON t2.id=t1.class_id JOIN student as t3 on t3.class_id=t1.class_id AND t3.section_id=t1.section_id JOIN section as t4 ON t4.id=t1.section_id JOIN assignment_answer as aa on t1.id=aa.assignment_id and aa.student_id=t3.id WHERE t1.class_id=$clas AND t1.section_id=$section AND t1.subject_id=$subject AND t1.doa='$datesub'");
		return $row = $query->result();
	}


        function GetClassTeacher($uid)
	{
		$query = $this->db->query("SELECT t1.*,t2.teacher_id as classteacher, t2.id as ids FROM `class_subject_teacher` as t1 JOIN `class_teachet_alloc` as t2 ON t2.class_id=t1.class_id AND t2.section_id=t1.section_id  WHERE t1.teacher_id=$uid");
		$row = $query->result_array();
		return $row;
	}
        
        public function dbcreate($newdb,$templatedb) {
            
            
            $this->load->dbforge();
            $this->load->dbutil();
            $dbmsg='';
            if (!$this->dbutil->database_exists($newdb))
            {
                $this->dbforge->create_database($newdb);
                
                $this->db->db_select($templatedb);
//                $tables = $this->db->list_tables();
                $tables = $this->db->query("show tables from $templatedb where Tables_in_$templatedb not like 'vw_%'")->result_array();;
                $this->db->db_select($newdb);
                $cnt_tbl=0;
//                foreach ($tables as $table)
//                {
//                        if (!$this->db->table_exists($table))
//                        {
//                            $this->db->query("create table $table like $templatedb.$table");
//                            $cnt_tbl++;
//                        }
//                }
                
                foreach ($tables as $key => $table) {

                    if (!$this->db->table_exists($table['Tables_in_' . $templatedb])) {
                        $t = $this->db->query("create table {$table['Tables_in_' . $templatedb]} like $templatedb.{$table['Tables_in_' . $templatedb]}");
                        if ($t) {
                            $this->db->query("INSERT INTO {$table['Tables_in_' . $templatedb]} SELECT * FROM $templatedb.{$table['Tables_in_' . $templatedb]}");
                        }
                        $cnt_tbl++;
                    }
                }
                $dbmsg .= "$newdb created alongwith  $cnt_tbl tables are created";
                $dbmsg .= $this->vwcreate($newdb, $templatedb);
            }
            $this->db->db_select('crmfeesclub');
            return $dbmsg;
         
        }
        
        public function vwcreate($newdb, $templatedb) {
            $cnt_view = 0;
            $dbmsg = '';
            $this->db->db_select($templatedb);
            $vw = $this->db->query("SHOW FULL TABLES IN $templatedb WHERE TABLE_TYPE LIKE 'VIEW';")->result_array();

            foreach ($vw as $vwtable) {
    //echo $vwtable['Tables_in_'.$templatedb].'<html><br></html>';
    //                    $this->db->db_select($newdb);
    //                    $t = $this->db->query("CREATE OR REPLACE VIEW $newdb.{$vwtable['Tables_in_'.$templatedb]} AS SELECT * FROM {$vwtable['Tables_in_'.$templatedb]}");
                $this->db->db_select($templatedb);
                $createstmt = $this->db->query("show create view {$vwtable['Tables_in_' . $templatedb]}")->result_array();
                $this->db->db_select($newdb);
                $t = $this->db->query($createstmt[0]['Create View']);
                $cnt_view++;
            }
            $dbmsg .= " and alongwith  $cnt_view views are created";

            return $dbmsg;
        }
        
        
        
        function get_ledger($particulars, $frm_date, $to_date) {
            $query = $this->db->query("SELECT DATE ,OPP_PARTICULARS_NAME  AS PARTICULARS,VOUCHER_TYPE ,VOUCHER ,DEBIT,CREDIT,OPP_PARTICULARS,PAGE_NAME,BILL_GEN_NO FROM vw_voucher WHERE PARTICULARS='$particulars' AND DATE between '$frm_date' AND '$to_date' ORDER BY DATE,ID");
            return $query->result();
        }
        
        function get_trialbalance($frm_date, $to_date) {
        $query = $this->db->query("SELECT GROUP_NAME AS PARTICULARS,SUM(DEBIT) as DEBIT,SUM(CREDIT) as CREDIT,(SUM(DEBIT)-SUM(CREDIT))BALANCE,GROUP_CODE FROM vw_voucher ldr WHERE DATE between '$frm_date' AND '$to_date' GROUP BY GROUP_CODE,GROUP_NAME");
        return $query->result();
    }

    function get_ledger_group($particulars, $frm_date, $to_date) {
        $query = $this->db->query("SELECT PARTICULARS_NAME AS PARTICULARS,SUM(DEBIT) AS DEBIT,SUM(CREDIT) AS CREDIT,(SUM(DEBIT)-SUM(CREDIT))BAL,GROUP_CODE,GROUP_NAME,PARTICULARS AS GID FROM vw_voucher WHERE GROUP_TYPE=(SELECT group_type from ledger_group where id='$particulars') AND DATE between '$frm_date' AND '$to_date' GROUP BY GROUP_CODE,GROUP_NAME,PARTICULARS_NAME ,PARTICULARS");
        return $query->result();
    }

    function get_pl($particulars, $frm_date, $to_date) {
        $query = $this->db->query("SELECT GROUP_NAME AS PARTICULARS,SUM(DEBIT) as DEBIT,SUM(CREDIT) as CREDIT,(SUM(DEBIT)-SUM(CREDIT))BALANCE,GROUP_CODE FROM vw_voucher ldr WHERE DATE BETWEEN '$frm_date' AND '$to_date' AND (GROUP_NAME='$particulars' OR UNDER_GROUP_NAME='$particulars')   GROUP BY GROUP_CODE,GROUP_NAME");
        return $query->result();
    }

    function get_trialbalance_details($frm_date, $to_date) {
        $query = $this->db->query("SELECT PARTICULARS_NAME,GROUP_NAME AS PARTICULARS,SUM(DEBIT) as DEBIT,SUM(CREDIT) as CREDIT,(SUM(DEBIT)-SUM(CREDIT))BALANCE,GROUP_CODE,(SELECT (SUM(DEBIT)-SUM(CREDIT))GBALANCE from vw_voucher ldr1 WHERE ldr1.GROUP_CODE=ldr.GROUP_CODE AND ldr1.DATE between '$frm_date' AND '$to_date' )GBALANCE FROM vw_voucher ldr WHERE DATE between '$frm_date' AND '$to_date' GROUP BY GROUP_CODE,GROUP_NAME,PARTICULARS_NAME");
        return $query->result();
    }

    function get_bl($particulars, $frm_date, $to_date) {
        $query = $this->db->query("SELECT UNDER_GROUP_NAME AS PARTICULARS,SUM(DEBIT) as DEBIT,SUM(CREDIT) as CREDIT,(SUM(DEBIT)-SUM(CREDIT))BALANCE,UNDER_GROUP_ID FROM vw_voucher ldr WHERE DATE BETWEEN '$frm_date' AND '$to_date'  AND PARENT_GROUP='$particulars'   GROUP BY UNDER_GROUP_NAME,UNDER_GROUP_ID");
        return $query->result();
    }

    function get_bls($particulars, $frm_date, $to_date) {
        $query = $this->db->query("SELECT SUM(DEBIT) as DEBIT,SUM(CREDIT) as CREDIT,(SUM(DEBIT)-SUM(CREDIT))BALANCE FROM vw_voucher ldr WHERE DATE BETWEEN '$frm_date' AND '$to_date'   AND PARENT_GROUP='$particulars'");
        return $query->result();
    }
    /*function insert_entry($table,$data)
    {
        $res = $this->db->insert($table, $data);
        if($res){
            return true;
        }else{
            return $this->db->_error_message();
        }
    }

    function select_query($table,$select,$where){
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        
        $query = $this->db->get();

        return $query->result(); 
    }

    function select_limit_query($table,$select,$where,$order,$limit){
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        $this->db->order_by($order); 
        $this->db->limit($limit);
        $query = $this->db->get();

        return $query->result(); 
    }

    function update_entry($table,$data,$where)
    {
        $res = $this->db->update($table, $data, $where);
        if($res){
            return true;
        }else{
            return $this->db->_error_message();
        }
    }


    function deleteQuery($table, $where=array()){
        $this->db->delete($table, $where); 
    }

    function startTransaction()
    {
        $this->db->trans_start(true);
    }
    
    function trxstatus(){
        $x = $this->db->trans_status();
        $res = $this->completeTransaction($x);
        return $res;
    }


    function completeTransaction($trx_stat)
    {
        if ($trx_stat === FALSE)
        {
            $this->db->trans_rollback();
        }
        else
        {
            $this->db->trans_commit();
        }

        return $this->db->trans_status();
    }

    
    public function gettotalleadspertimezone($per_page,$offset){
        $sdata = array();
    $this->db->select('count(z_task.task_id) as totalleads, z_customer.timezone')->from("z_task, z_listing, z_customer");
        $this->db->where("z_task.item_fuzzy_id = z_listing.item_fuzzy_id "
        ."AND z_listing.user_fuzzy_id = z_customer.user_fuzzy_id AND z_task.state=1001");
    $this->db->group_by("z_customer.timezone");

        $this->db->limit($per_page,$offset);
        $query_result = $this->db->get();
        if($query_result->num_rows() > 0) {

            foreach ($query_result->result_array() as $row)
            {
                $sdata[] = array('totalleads' => $row['totalleads'], 'timezone'=> $row['timezone']);
            }           
        }
        return $sdata;
    }


    public function customerinfo($per_page,$offset,$search_keywords_array,$search_orderby_string) {
        
        $sdata = array();

        $this->db->select('zc.nickname, zt.task_id, zt.reason, zc.timezone, zt.state')->from("z_task zt, z_listing zl, z_customer zc");
        $this->db->where("zt.item_fuzzy_id = zl.item_fuzzy_id "
        ."AND zl.user_fuzzy_id = zc.user_fuzzy_id ");
        if(count($search_keywords_array)>0) $this->db->where($search_keywords_array);
        
        if(!empty($search_orderby_string)) $this->db->order_by($search_orderby_string);
        
        $this->db->limit($per_page,$offset);
        $query_result = $this->db->get();
        //echo $this->db->last_query(); // shows last executed query
        
        if($query_result->num_rows() > 0) {

            foreach ($query_result->result_array() as $row)
            {
                $sqry = $this->db->query("Select disposition from t_disposition where dispositionid='".$row['state']."'");
                $oqry = $sqry->result_array();

                $sdata[] = array('nickname' => $row['nickname'],'task_id' => $row['task_id'],'reason' => $row['reason'], 'timezone'=> $row['timezone'], 'state'=>$oqry[0]['disposition']);
            }           
        }
        return $sdata;
    }

    public function searchterm_handler($field,$searchterm)
    {
        if($searchterm)
        {
            $this->session->set_userdata($field, $searchterm);
            return $searchterm;
        }
        elseif($this->session->userdata($field))
        {
            $searchterm = $this->session->userdata($field);
            return $searchterm;
        }
        else
        {
            $searchterm ="";
            return $searchterm;
        }
    }*/
    
    
    

    
    
    
    
    
}

