<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mymodel extends CI_Model {

	function __construct(){
		// Call the Model constructor
		parent::__construct();
		
		$db = $this->load->database();
	}

	public function paper_select($programme,$branch,$sem,$paper_cat)
	{	

		$query = $this->db->query("SELECT t1.* from paper as t1 where t1.status='Y' and t1.prog_id='$programme' and t1.branch_code='$branch' and t1.sem_year='$sem' and t1.paper_cat='$paper_cat' ");
		$row = $query->result();
		return $row;
	}

	public function prp_export()
	{
		$query = $this->db->query("SELECT t1.prp_id,t1.batch_id,t1.prog_id,t1.branch_code,t1.sem_year,t1.paper_cat,t1.prp_title,t1.prp_code,t1.paper_credit,t1.status,t1.acc_session_id,t2.session,t3.name,t4.br_name,t5.paper_cat_name from paper as t1 LEFT JOIN academic_session as t2 ON t2.id=t1.batch_id LEFT JOIN programme as t3 ON t3.id=t1.prog_id LEFT JOIN branch as t4 ON t4.id=t1.branch_code LEFT JOIN paper_cat as t5 ON t5.id=t1.paper_cat  where t1.status='Y' order by prp_id ");
		$row = $query->result();
		return $row;
	}

	public function generic_prp($batch_id,$prog_id,$branch_id,$sem_id,$stud_id)
	{
		$query = $this->db->query(" SELECT t1.id,t1.batch_id,t1.programme_id,t1.branch_id,t1.sem_id,t1.student_id,t1.status,t2.paper_cat_grp,t2.paper,t2.special_paper,t2.status as grid_status,t3.prp_title,t3.prp_code,t4.paper_cat_name from student_sem_paper as t1 LEFT JOIN student_sem_paper_grid as t2 ON t2.student_sem_paper_id=t1.id LEFT JOIN paper as t3 ON t3.prp_id=t2.paper LEFT JOIN paper_cat as t4 ON t4.id=t2.paper_cat_grp where t1.status='Y' and t2.status='Y' and t1.batch_id='$batch_id' and t1.programme_id='$prog_id' and t1.branch_id='$branch_id' and t1.sem_id='$sem_id' and t1.student_id='$stud_id' and t2.paper_cat_grp='5' ");
		$row = $query->result();
		return $row;
	}

	public function communication_prp($batch_id,$prog_id,$branch_id,$sem_id,$stud_id)
	{
		$query = $this->db->query("SELECT t1.id,t1.batch_id,t1.programme_id,t1.branch_id,t1.sem_id,t1.student_id,t1.status,t2.paper_cat_grp,t2.paper,t2.special_paper,t2.status as grid_status,t3.prp_title,t3.prp_code,t4.paper_cat_name from student_sem_paper as t1 LEFT JOIN student_sem_paper_grid as t2 ON t2.student_sem_paper_id=t1.id LEFT JOIN paper as t3 ON t3.prp_id=t2.paper LEFT JOIN paper_cat as t4 ON t4.id=t2.paper_cat_grp where t1.status='Y' and t2.status='Y' and t1.batch_id='$batch_id' and t1.programme_id='$prog_id' and t1.branch_id='$branch_id' and t1.sem_id='$sem_id' and t1.student_id='$stud_id' and t2.paper_cat_grp='6' ");
		$row = $query->result();
		return $row;
	}

	public function core_details($batch_id,$prog_id,$branch_id,$sem_id,$reg_id)
	{
		$query = $this->db->query("SELECT t1.prp_id,t1.batch_id,t1.prog_id,t1.branch_code,t1.sem_year,t1.paper_cat,t1.prp_title,t1.prp_code,t1.paper_credit,t1.acc_session_id,t1.status,t2.paper_cat_name,t3.id,t3.registeration_no,t3.college_roll_no from paper as t1 LEFT JOIN paper_cat as t2 ON t2.id=t1.paper_cat LEFT JOIN student as t3 ON t3.batch_id=t1.batch_id and t3.programme_id=t1.prog_id  and t3.branch_id=t1.branch_code and t3.semester_no=t1.sem_year where t1.status='Y' and t1.batch_id='$batch_id' and t1.prog_id='$prog_id' and t1.paper_cat='1' and t1.sem_year='$sem_id' and t3.registeration_no = '$reg_id' "); /*t1.branch_code='45'  and t3.registeration_no='18%04d'*/
		$row = $query->result();
		return $row;
	}

	public function stud_details($reg_no)
	{
		$query = $this->db->query("SELECT t1.id,t1.registeration_no,t1.admission_date,t1.college_roll_no,t1.university_roll_no,t1.first_name,t1.middle_name,t1.last_name,t1.name_hindi,t1.father_name,t1.dob,t1.batch_id,t1.student_acedemic_year_id,t1.programme_id,t1.branch_id,t1.semester_no,t1.course_id,t1.mother_name,t1.status,t2.session,t2.batch_name,t2.status as academic_status,t3.name as prog_name,t3.no_of_years,t3.no_of_semester from student as t1 LEFT JOIN academic_session as t2 ON t2.id=t1.batch_id LEFT JOIN programme as t3 ON t3.id=t1.programme_id where t1.status='Y' and t2.status='Y' and t1.registeration_no='$reg_no' ");
		$row = $query->result();
		return $row;
	}

	public function get_roll_sheet($id)
	{	

		$query = $this->db->query("SELECT t1.prp_id,t1.sem_year,t1.prp_code,t1.status as prp_status,t2.timee,t2.datee,t2.sessionn,t3.name,t4.exam_code,t4.exam_name,t5.ass_college,t6.college_name from paper as t1 LEFT JOIN exam_schedule as t2 ON t2.paper=t1.prp_id LEFT JOIN programme as t3 ON t3.id=t1.prog_id LEFT JOIN exam as t4 ON t4.id=t2.exam LEFT JOIN exam_center as t5 ON t5.id=t4.id LEFT JOIN exam_venue as t6 ON t6.id=t5.ass_college where t1.status='Y' and t1.prp_id='$id'");
		$row = $query->result_array();
		return $row;
	}

	public function get_stud_details($batch,$prog,$branch,$sem,$subject)
	{	
         
		$query = $this->db->query("select pp.*,pp.prp_id as subject_id,pp.prp_title as pname,st.registeration_no as reg_no,st.university_roll_no as exam_rollno,concat(st.first_name,' ',st.middle_name,' ',st.last_name)sname,st.id as student_id,st.dob,st.phone,st.address from paper pp left join paper_cat pc on pp.paper_cat=pc.id  inner join student st on pp.batch_id =st.batch_id and pp.prog_id=st.programme_id and pp.branch_code=st.branch_id and pp.sem_year=st.semester_no where pc.paper='Yes' and `pp`.`prog_id` = '$prog' AND `pp`.`branch_code` = '$branch' AND `pp`.`sem_year` = '$sem' AND `pp`.`prp_id` = '$subject'  and st.id NOT IN(select student_id from stud_non_examallowance where paper='$subject')");
	    
		$norow=$query->num_rows();
		if($norow>0)
		{		
		
		$query1 = $query->result();
		}
		else
		{
		$query1 = $this->dbconnection->select_join('student_sem_paper_grid as spg','ssp.student_id,spg.subject_id,(select prp_title from paper where paper.prp_id=spg.subject_id)pname,(select first_name from student where student.id=ssp.student_id)sname,(select registeration_no from student where student.id=ssp.student_id)reg_no,(select university_roll_no from student where student.id=ssp.student_id)exam_rollno,(select dob from student where student.id=ssp.student_id)dob,(select phone from student where student.id=ssp.student_id)phone,(select address from student where student.id=ssp.student_id)address',
		'ssp.programme_id='. $this->input->post('prog').' AND ssp.branch_id='. $this->input->post('branch').' AND ssp.sem_id='. $this->input->post('sem').' AND spg.subject_id='. $this->input->post('subject').' AND student_id  NOT IN(select student_id from stud_non_examallowance where paper=$subject)','student_sem_paper as ssp','spg.student_sem_paper_id=ssp.id AND spg.status="Y"','inner join');
		}
		
		$result = $query->result();
		return $result;
	}
    
	public function get_memo_details()
	{

		$query = $this->db->query("SELECT id,college_roll_no,registeration_no,university_roll_no,status,CONCAT(first_name,' ',middle_name,' ',last_name) as stud_name from student where status='Y' ");
		$row = $query->result_array();
		
	}

	public function get_memo_total()
	{	

		$query = $this->db->query(" SELECT count(first_name) as count from student where status='Y' ");
		$row = $query->result_array();
		return $row;
	}

	public function get_roll_total($exam_not)
	{	

		$query = $this->db->query(" SELECT count(first_name) as count from student where status='Y' and id NOT IN(select student_id from stud_non_examallowance where paper='$exam_not') ");
		$row = $query->result_array();
		return $row;
	}

	public function get_student_sem_paper()
	{	

		$query = $this->db->query(" SELECT t1.id,t1.sem_id,t2.name,t3.br_name,t4.registeration_no,t4.first_name,t4.middle_name,t4.last_name,t4.father_name,t4.dob from student_sem_paper as t1 LEFT JOIN programme as t2 ON t2.id=t1.programme_id LEFT JOIN branch as t3 ON t3.id=t1.branch_id LEFT JOIN student as t4 ON t4.id=t1.student_id where t1.status='Y'");
		$row = $query->result_array();
		return $row;
	}

	/*public function getstudent_sem_paper($id)
	{	
		$query = $this->db->query("SELECT t1.id,t1.status,t1.sem_id,t2.id as prog_id,t2.name,t2.no_of_semester,t3.id as branch_id,t3.br_name,t4.id as stud_id,t4.first_name,t4.middle_name,t4.last_name as stud_name,t5.subject_id,t6.prp_title from student_sem_paper as t1 LEFT JOIN programme as t2 ON t2.id=t1.programme_id LEFT JOIN branch as t3 ON t3.id=t1.branch_id LEFT JOIN student as t4 ON t4.id=t1.student_id  LEFT JOIN student_sem_paper_grid as t5 ON t5.student_sem_paper_id=t1.id and t5.status='Y' LEFT JOIN paper as t6 ON t6.prp_id=t5.subject_id where t1.id='$id' and t1.status='Y' ");
		$row = $query->result_array();
		return $row;
	}*/

	public function getstudent_sem_paper($id)
	{	
		$query = $this->db->query("SELECT t1.*,t2.registeration_no,t2.first_name,t2.middle_name,t2.last_name,t2.father_name,t2.dob from student_sem_paper as t1 LEFT JOIN student as t2 ON t2.id=student_id where t1.status='Y' and t1.id='$id'  ");
		$row = $query->result_array();
		return $row;
	}

	public function getstudent_sem_paper_grid($id)
	{	
		$query = $this->db->query(" SELECT t1.id,t2.id as grid_id,t2.student_sem_paper_id,t2.paper_cat_grp,t2.paper,t2.special_paper,t2.status as stud_sem_prp_gridstatus,t7.paper_cat_name,t7.paper,t8.prp_title,t9.prp_title as special_paper from student_sem_paper as t1 LEFT JOIN student_sem_paper_grid as t2 ON student_sem_paper_id=t1.id LEFT JOIN paper_cat as t7 ON t7.id=t2.paper_cat_grp LEFT JOIN paper as t8 ON t8.prp_id=t2.paper LEFT JOIN special_paper as t9 ON t9.prp_id=t2.special_paper where t1.id='$id' and t1.status='Y' and t7.paper='No' ");
		$row = $query->result_array();
		return $row;
	}

	public function getpaper()
	{
		$query = $this->db->query("select prp_id,prp_title from paper inner join paper_cat  on paper.paper_cat=paper_cat.id where paper_cat.paper='No' and paper.status='Y'");
		$row = $query->result_array();
		return $row;
	}
	
    public function getfaculty_sem_paper($id)
	{	
		$query = $this->db->query("SELECT t1.id,t1.programme_id,t1.branch_id,t1.sem_id,t1.faculty_id,t1.status,t2.name,t2.no_of_semester,t2.no_of_years,t3.br_name,t4.f_firstname,t4.f_lastname,t4.fid ,t5.subject_id,t5.status as grid_status,t6.prp_id,t6.prp_title from faculty_sem_paper as t1 LEFT JOIN programme as t2 ON t2.id=t1.programme_id LEFT JOIN branch as t3 ON t3.id=t1.branch_id LEFT JOIN faculty as t4 ON t4.fid=t1.faculty_id LEFT JOIN faculty_sem_paper_grid as t5 ON t5.faculty_sem_paper_id=t1.id and t5.status='Y' LEFT JOIN paper as t6 ON t6.prp_id=t5.subject_id where t1.id='$id' and t1.status='Y' ");
		$row = $query->result_array();
		return $row;
	}

	public function get_student_byreg($regno)
	{	

		$query = $this->db->query("select *,(select b_name from batch where id=student.batch_id)batchname,(select name from programme where id=student.programme_id)program,(select br_name from branch where id=student.branch_id)branchname from student where registeration_no='$regno'");
		$row = $query->result_array();
		return $row;
	}

	public function get_sem_wise_paper($prog,$branch,$sem,$batch)
	{	
        $query = $this->db->query("select pc.t_marks,pc.pass_marks,pp.prp_id,pp.prp_title as pname,pp.paper_credit as prp_credit from paper pp inner join paper_credit_detail pc on pc.paper_credit_id=(select pc_id from paper_credit pcd where pp.prp_id=pcd.prp_id) where pp.prog_id='$prog' and pp.branch_code='$branch' and pp.sem_year='$sem' and pp.batch_id='$batch'");
		$row = $query->result_array();
		return $row;
	}
	public function get_sem_wise_result($studid,$batch,$prog,$branch,$sem,$pcode)
	{	

		$query = $this->db->query("select emd.exam_roll_no,emd.total_marks_ob from exam_confirmmarks_detail as emd INNER JOIN exam_confirmmarks em ON emd.exam_confirmmarks_id=em.e_id where emd.exam_roll_no='$studid' and em.prog_id='$prog' and em.branch_code='$branch' and em.sem_year='$sem' and em.prp_code='$pcode' and em.batch='$batch'");
		$row = $query->result_array();
		//echo $abc = $this->db->last_query();
		return $row;
	}
	public function get_sem_wise_center($prog,$branch,$sem)
	{
		$query = $this->db->query("select  cl.id,cl.c_code,cl.c_name,cl.address,(select city_name from collegefclb.cities ct where ct.id=cl.city_id)city,(select state_name from collegefclb.states ct where ct.id=cl.state_id)state from collegefclb_1.exam_center ec inner join collegefclb.college cl on ec.ass_college=cl.id where ec.programme='$prog' and ec.branch='$branch' and ec.sem='$sem' ");
		$row = $query->result_array();
		return $row;
	}
	public function get_sem_wise_exam($prog,$branch,$sem)
	{	

		$query = $this->db->query("select distinct exam,(select exam.exam_name from exam where exam.id=exam_schedule.exam)examname from exam_schedule where prog_id='$prog' and branch_code='$branch' and sem_year='$sem'");
		$row = $query->result_array();
		return $row;
	}
	public function get_sem_wise_exam_paper($prog,$branch,$sem,$exam)
	{	

		$query = $this->db->query("select *,(select prp_title from paper where paper.prp_id=exam_schedule.paper)pname from exam_schedule where prog_id='$prog' and branch_code='$branch' and sem_year='$sem' and exam='$exam'");
		$row = $query->result_array();
		return $row;
	}
	public function get_prog_wise_semester_year($prog)
	{	

		$query = $this->db->query("select * from programme where id='$prog'");
		$row = $query->result_array();
		return $row;
	}
	
	/*public function get_faculty_subj_allo($faculty,$bran,$prog)
	{	

		$query = $this->db->query("SELECT t1.*,t2.br_code,t2.br_name,t2.id as branch_id,t2.br_code,t2.programme_id,t2.status as branch_status,t3.no_of_semester,t3.status as program_status,t3.id as prog_id from faculty as t1 LEFT JOIN branch as t2 ON t2.id=t1.fid LEFT JOIN programme as t3 ON t3.id=t2.programme_id where t1.id='$faculty' and t2.id='$bran' and t3.id='$prog'");
		$row = $query->result_array();
		return $row;
	}*/

	public function get_faculty_subj_allo()
	{	

		$query = $this->db->query("SELECT t1.*,t2.br_code,t2.br_name,t2.id as branch_id,t2.br_code,t2.programme_id,t2.status as branch_status,t3.no_of_semester,t3.status as program_status,t3.id as prog_id from faculty as t1 LEFT JOIN branch as t2 ON t2.id=t1.fid LEFT JOIN programme as t3 ON t3.id=t2.programme_id where t1.status='Y' ");
		$row = $query->result_array();
		return $row;
	}
	
	public function get_faculty()
	{	

		$query = $this->db->query(" SELECT t1.id,t1.programme_id,t1.branch_id,t1.sem_id,t1.faculty_id,t1.status,t2.name,t2.no_of_semester,t2.no_of_years,t3.br_name,t4.f_firstname,t4.f_lastname from faculty_sem_paper as t1 LEFT JOIN programme as t2 ON t2.id=t1.programme_id LEFT JOIN branch as t3 ON t3.id=t1.branch_id LEFT JOIN faculty as t4 ON t4.fid=t1.faculty_id where t1.status='Y' ");
		$row = $query->result_array();
		return $row;
	}
	
	public function get_papercredit()
	{	

		$query = $this->db->query("SELECT t1.pc_id,t1.sem,t2.name,t3.br_name,t4.prp_title as paper from paper_credit as t1 LEFT JOIN programme as t2 ON t2.id=t1.prog LEFT JOIN branch as t3 ON t3.id=t1.branch LEFT JOIN paper as t4 ON t4.prp_id=t1.prp_id where t1.status='Y'  ");
		$row = $query->result_array();
		return $row;
	}
	
	public function edit_papercredit()
	{	

		$query = $this->db->query("SELECT * from paper_credit");
		$row = $query->result_array();
		return $row;
	}
	
	public function get_allowedstudent()
	{	
        $query = $this->db->query("select st.first_name,st.registeration_no,st.dob,st.phone,st.address from stud_examallowance as se join student as st on se.student_id=st.id");
		$row = $query->result_array();
		return $row;
	}
	public function get_gradebymarks($marks)
	{	
	
		$query = $this->db->query("select * from grade_setting where marks_obt_form<='$marks' and marks_obt_to>='$marks'");
		$row = $query->result_array();
		//echo $abc=$this->db->last_query();
		return $row; 
	}
	
	public function studell($id)
	{
		$this->db->where('student_id', $id);
        $this->db->delete('stud_non_examallowance');
		if($this->db->affected_rows() > 0)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function catData()
	{
		$query = $this->db->query("select pc.id,pc.cat_name,pc.gst_id,gr.code from product_category as pc join gst_rate as gr on gr.id=pc.gst_id where pc.status = 'Y'");
		$result = $query->result();
		return $result;
		
	}
	
	public function grpData()
	{
		$query = $this->db->query("select *,pc.id as pro_cat_id ,pc.cat_name,pg.id as pg_id from product_group as pg join product_category as pc on pg.product_category_id=pc.id where pg.status = 'Y'");
		$result = $query->result();
		return $result;
		
	}
	
	public function compData()
	{
		$query = $this->db->query("select id,category_id,(select cat_name from product_category where id=product_company.category_id)cat_name,product_group_id,(select group_name from product_group where id=product_company.product_group_id)group_name,com_name from product_company where status = 'Y'");
		$result = $query->result();
		return $result;
	}
	
	
	public function proData()
	{
		$query = $this->db->query("select stk.*,pro.id,pro.category,(select cat_name from product_category where id=pro.category)category_name,pro.company,(select com_name from product_company where id=pro.company)comp_name,pro.group,(select group_name from product_group where id=pro.group)group_name,pro.product,pro.hsn from product as pro join stock as stk on stk.product_id=pro.id where pro.status = 'Y'");
		$result = $query->result();
		return $result;
	}
	public function reqData()
	{
		$query = $this->db->query("select req_no from requisition GROUP BY req_no");
		$result = $query->result();
		return $result;
		
	}
	
	public function fetch_order($vendor_id)
	{
		$query = $this->db->query("select distinct order_no from purchase_order where vendor = '$vendor_id' AND bal_qty > 0");
		$result = $query->result();
		return $result;
	}
	
	public function fetch_order_all($order_no)
	{
		$query = $this->db->query("select po.*,(select pro.product from product as pro where pro.id=po.product)proname,(select tax_type from product as pro where pro.id=po.product)taxtype,(select gstrate from gst_rate where id= (select gst_rate from product as pro where pro.id=po.product))gstper,(select name from collegefclb.uqc where id=uqc)uqcname from purchase_order as po where order_no = '$order_no' AND bal_qty > 0");
		$result = $query->result();
		return $result;
	}
	
	public function getGRNdata()
	{
		$query = $this->db->query("select distinct grn_no,vendor,(select ledger_name from ledger where id=GRN.vendor)vendername,vw_ord,inv_no,basictotal,gst_c,gst_s,gst_i,nettotal from GRN");
		$result = $query->result();
		return $result;
	}
	
	public function grn_fetch($grn_no)
	{
		$query = $this->db->query("select inv_no,pro,uqc,ordqty,recqty,blnqty,rate,gstrate,taxtype,basicamt,discount,gstamt,finalamt from GRN where grn_no = '$grn_no'");
		
		$result = $query->result();
		return $result;
	}
	
	public function edit_grn($grn_no)
	{
		$query = $this->db->query("select GRN.*,(select product from product as pr where pr.id=GRN.pro)prname from GRN where grn_no = '$grn_no'");
		$result = $query->result();
		return $result;
	}
	
	public function fetorder($staff_id)
	{
		$query = $this->db->query("select distinct req_no from requisition where staff_id = '$staff_id' AND balqty > 0");
		$result = $query->result();
		return $result;
	}
	
	public function getpro($staff_id,$req_no)
	{
		 $this->db->db_debug=TRUE;
         error_reporting(-1);
         ini_set('display_errors', 1);
		$query = $this->db->query("select id,pro_id,(select pro.product from product as pro where pro.id=requisition.pro_id)proname,qty,balqty,uqc_id,(select name from crmfeesclub.uqc where id=requisition.uqc_id)uqcname from requisition where req_no = '$req_no' AND staff_id = '$staff_id' AND balqty > 0");
		$result = $query->result();
		return $result;
	}
	
	public function getfetchBatch($proid)
	{
		$query = $this->db->query("select batch from stock where product_id = '$proid' AND qty > 0");
		$result = $query->result();
		return $result;
	}
	
	public function fetchstu($batch,$prog,$bran,$rest,$type) //selecting
	{
		if($rest == 'OFF'){
		  $query = $this->db->query("select id,registeration_no,university_roll_no,first_name,father_name,dob,batch_id,(select batch_name from academic_session where id=student.batch_id)batchname,programme_id,(select name from programme where id=student.programme_id)proname,(select code from programme where id=student.programme_id)procode,branch_id,(select br_name from branch where id=student.batch_id)brname,(select br_code from branch where id=student.batch_id)brcode,course_id,(select course_name from extra_course where id=student.course_id)coursename,(select course_code from extra_course where id=student.course_id)coursecode from student where batch_id = '$batch' AND programme_id = '$prog' AND branch_id = '$bran'");
		  $result = $query->result();
		  return $result;	
		}else{
			if($type == 'REG'){
			  $query = $this->db->query("select id,registeration_no,university_roll_no,first_name,father_name,dob,batch_id,(select batch_name from academic_session where id=student.batch_id)batchname,programme_id,(select name from programme where id=student.programme_id)proname,(select code from programme where id=student.programme_id)procode,branch_id,(select br_name from branch where id=student.batch_id)brname,(select br_code from branch where id=student.batch_id)brcode,course_id,(select course_name from extra_course where id=student.course_id)coursename,(select course_code from extra_course where id=student.course_id)coursecode from student where batch_id = '$batch' AND programme_id = '$prog' AND branch_id = '$bran' AND registeration_no = ''");
		      $result = $query->result();
		      return $result;	
			}else{
				$query = $this->db->query("select id,registeration_no,university_roll_no,first_name,father_name,dob,batch_id,(select batch_name from academic_session where id=student.batch_id)batchname,programme_id,(select name from programme where id=student.programme_id)proname,(select code from programme where id=student.programme_id)procode,branch_id,(select br_name from branch where id=student.batch_id)brname,(select br_code from branch where id=student.batch_id)brcode,course_id,(select course_name from extra_course where id=student.course_id)coursename,(select course_code from extra_course where id=student.course_id)coursecode from student where batch_id = '$batch' AND programme_id = '$prog' AND branch_id = '$bran' AND university_roll_no = ''");
		        $result = $query->result();
		        return $result;
			}
		}
	}
	
	public function pattern_edit($year,$college)
	{
		$query = $this->db->query("select rp.year_onward,rp.college,rp.typee,rp.no_of_segment,rp.separatorr,rp.after_separator,rpg.content,rpg.no_of_digit,rpg.first_last from reg_pattern as rp inner join reg_pattern_grid as rpg on rp.id=rpg.reg_pattern_id where rp.year_onward = '$year' AND rp.college = '$college'");
		$result = $query->result();
		if($result)
		{
		  return $result;	
		}
		else
		{
			return false;
		}
	}
	
	public function pattern()
	{
		$query = $this->db->query("SELECT *,(select c_name from college where id=reg_pattern.college)collegename FROM reg_pattern;");
		$result = $query->result();
		return $result;
	}
	
	public function roll_pattern()
	{
		$query = $this->db->query("SELECT *,(select c_name from college where id=roll_pattern.college)collegename FROM roll_pattern;");
		$result = $query->result();
		return $result;
	}
	
	public function edit_grid($id)
	{
		$query = $this->db->query("SELECT *,(select c_name from college where id=reg_pattern.college)collegename FROM reg_pattern where id = '$id'");
		$result = $query->result();
		return $result;
	}
	
	public function roll_edit_grid($id)
	{
		$query = $this->db->query("SELECT *,(select c_name from college where id=roll_pattern.college)collegename FROM roll_pattern where id = '$id'");
		$result = $query->result();
		return $result;
	}
	
	public function generate($college_id)
	{
		$query = $this->db->query("select rp.id,rp.college,rp.year_onward,rp.typee,rp.no_of_segment,rp.separatorr,rp.after_separator,rpg.content,rpg.no_of_digit,rpg.first_last from collegefclb.reg_pattern as rp join collegefclb.reg_pattern_grid as rpg on rp.id=rpg.reg_pattern_id where rp.college = 1 AND year_onward = 2018");
		$result = $query->result();
		return $result;
	}
	
	public function fetchstus($batch, $prog, $bran, $rest, $type) //generating
	{
		if($rest == 'OFF'){
		  $query = $this->db->query("select id,college_roll_no,batch_id,student_acedemic_year_id,(select batch_name from academic_session where id=student.batch_id)batchname,branch_id,(select br_name from branch where id=student.branch_id)branchname,programme_id,(select name from programme where id=student.programme_id)progname,(select code from programme where id=student.programme_id)paper_code from student where batch_id = '$batch' AND programme_id = '$prog' AND branch_id = '$bran'");
		  $result = $query->result();
		  return $result;	
		}else{
			if($type == 'REG'){
			  $query = $this->db->query("select id,college_roll_no,batch_id,student_acedemic_year_id,(select batch_name from academic_session where id=student.batch_id)batchname,branch_id,(select br_name from branch where id=student.branch_id)branchname,programme_id,(select name from programme where id=student.programme_id)progname,(select code from programme where id=student.programme_id)paper_code from student where batch_id = '$batch' AND programme_id = '$prog' AND branch_id = '$bran' AND registeration_no = ''");
		      $result = $query->result();
		      return $result;	
			}else{
				$query = $this->db->query("select id,college_roll_no,batch_id,student_acedemic_year_id,(select batch_name from academic_session where id=student.batch_id)batchname,branch_id,(select br_name from branch where id=student.branch_id)branchname,programme_id,(select name from programme where id=student.programme_id)progname,(select code from programme where id=student.programme_id)paper_code from student where batch_id = '$batch' AND programme_id = '$prog' AND branch_id = '$bran' AND university_roll_no = ''");
		        $result = $query->result();
		        return $result;
			}	
		}
	}
	
	public function get_patterns($college_id)
	{
		$query = $this->db->query("select rp.id,rp.college,rp.year_onward,rp.typee,rp.no_of_segment,rp.separatorr,rp.after_separator,rpg.content,rpg.no_of_digit,rpg.first_last from collegefclb.reg_pattern as rp join collegefclb.reg_pattern_grid as rpg on rp.id=rpg.reg_pattern_id");
		$result = $query->result();
		return $result;
	}
	
	public function get_patterns_roll($college_id)
	{
		$query = $this->db->query("select rp.id,rp.college,rp.year_onward,rp.typee,rp.no_of_segment,rp.separatorr,rp.after_separator,rpg.content,rpg.no_of_digit,rpg.first_last from collegefclb.roll_pattern as rp join collegefclb.roll_pattern_grid as rpg on rp.id=rpg.roll_pattern_id");
		$result = $query->result();
		return $result;
	}
	
	public function myquery($prog,$branch,$sem,$subject)
	{
		$query = $this->db->query("select emd.stid,emd.total_marks_ob,em.emp_id from exam_marks_detail as emd join exam_marks as em on emd.exam_marks_id=em.e_id where em.prog_id = '$prog' AND em.branch_code='$branch' AND em.sem_year='$sem' AND em.prp_code='$subject'");
		$result = $query->result();
		if($result)
		{
		  return $result;	
		}
		else
		{
			return false;
		}
	}
	
	public function paper_group(){
		$query = $this->db->query("select * from paper as pr join paper_cat as pc on pr.paper_cat=pc.id where pc.paper = 'No' AND pr.status = 'Y'");
		$result = $query->result();
		if($result)
		{
		  return $result;	
		}
		else
		{
			return false;
		}
	}
	
	public function subj($subject){
		$query = $this->db->query("select ex.id,pcd.exam,(select exam_name from exam where id=pcd.exam)examname from paper_credit_detail as pcd join exam as ex on pcd.exam=ex.id join paper_credit as pc where pcd.status='Y' AND pc.pc_id=pcd.paper_credit_id AND pc.prp_id='$subject'");
		$result = $query->result();
		if($result)
		{
		  return $result;	
		}
		else
		{
			return false;
		}
	}
	
	public function getcollegeData($college_id,$batch,$prog,$branch,$sem,$subject,$examname)
		{
		$query = $this->db->query("select st.id,st.registeration_no,st.university_roll_no,pp.prp_title from collegefclb_$college_id.paper pp inner join collegefclb_$college_id.paper_cat ppc on pp.paper_cat=ppc.id inner join collegefclb_$college_id.student st on pp.batch_id=st.batch_id and pp.prog_id=st.programme_id and pp.branch_code=st.branch_id and pp.sem_year=st.semester_no where ppc.paper='Yes' and pp.prp_id='$subject' and pp.batch_id='$batch' and pp.prog_id='$prog' and pp.branch_code='$branch' and pp.sem_year='$sem' and st.id NOT IN(select student_id from stud_non_examallowance where paper=$subject)");
		$result = $query->result();
		
		$query1 = $this->db->query("select ssp.student_id,(select university_roll_no from student where id=ssp.student_id)university_roll_no,sspg.paper,(select prp_title from paper where prp_id=sspg.paper)papername from collegefclb_$college_id.student_sem_paper as ssp join collegefclb_$college_id.student_sem_paper_grid as sspg on ssp.id=sspg.student_sem_paper_id where ssp.programme_id='$prog' and ssp.branch_id='$branch' and ssp.sem_id='$sem' and sspg.paper='$subject'");
		$result1 = $query1->result();
		
		if($result){
		  return $result;	
		}else{
			return $result1;
		}
	}
	 
	public function full_marks($college_id,$batch,$prog,$branch,$sem,$subject,$examname){
		$query = $this->db->query("select prp.prp_code,pcd.t_marks,pcd.pass_marks,pcd.exam,pc.prp_id from paper as prp join paper_credit as pc on prp.prp_id=pc.prp_id join paper_credit_detail as pcd on pc.pc_id=pcd.paper_credit_id where prp.batch_id = '$batch' AND prp.prog_id = '$prog' AND prp.branch_code = '$branch' AND prp.sem_year = '$sem' AND pcd.exam = '$examname' AND pc.prp_id = $subject");
		$result = $query->result();
		if($result)
		{
		  return $result;	
		}
		else
		{
			return false;
		}
	}
    
    public function max_stu(){
		$query = $this->db->query("select max(registeration_no)max_length from student");
		$result = $query->result();
		if($result){
		  return $result;	
		}else{
			return false;
		}
	}

    public function max_stu_roll(){
		$query = $this->db->query("select max(substr(university_roll_no,6,4))max_length from student");
		$result = $query->result();
		if($result){
		  return $result;	
		}else{
		  return false;
		}
	}

    public function requisition(){
		$query = $this->db->query("select req.id,req.uqc_id,req.req_no,req.staff_id,(select name from employee where id=req.staff_id)empname,pro_id,(select pro.product from product as pro where pro.id=req.pro_id)proname,qty,balqty from requisition as req where req.status='Y'");
		$result = $query->result();
		if($result){
		  return $result;	
		}else{
		  return false;
		}
	}

    public function purchase_order(){
		$query = $this->db->query("select po.uqc,po.id,po.order_no,po.vendor,(select ledger_name from ledger where id=po.vendor)venname,po.order_date,po.product,(select product from product where id=po.product)proname,order_qty from purchase_order as po where po.status='Y'");
		$result = $query->result();
		if($result){
		  return $result;	
		}else{
		  return false;
		}
	}	
	
	public function fetchdata($adm_no){
		$query = $this->db->query("select stu.id,stu.admission_no,stu.first_name,stu.middle_name,stu.last_name,stu.class_id,(select class_name from class where id=stu.class_id)classname,section_id,(select sec_name from section where id=stu.section_id)secname,roll from student as stu where admission_no = '$adm_no'");
		$result = $query->result();
		if($result){
		  return $result;	
		}else{
		  return false;
		}
	}

    public function issued_books(){
		$query = $this->db->query("select ib.id,ib.book_status,lb.title,lb.edition,lb.isbn,ib.adm_no,ib.first_name,ib.lib_card_no,ib.date_created,ib.issued_qty,ib.book_code,ib.return_date,ib.days_allow,ib.late_fine from library_books as lb join issued_books as ib on lb.book_code=ib.book_code");
		$result = $query->result();
		if($result){
		  return $result;	
		}else{
		  return false;
		}
	}

    public function issued_qty($adm_no){
		$query = $this->db->query("select count(adm_no)cnt from issued_books where adm_no = '$adm_no'");
		$result = $query->result();
		if($result){
		  return $result;	
		}else{
		  return false;
		}
	}

	public function product_issued(){
		$query = $this->db->query("select staff,(select name from employee where id=staff)empname,req_no,product,(select pro.product from product as pro where pro.id=product_issued.product)proname,batch,order_qty,rec_qty,rest_qty,uqc from product_issued");
		$result = $query->result();
		if($result){
		  return $result;	
		}else{
		  return false;
		}
	}

	public function resale_cust_detail(){
		$query = $this->db->query("select rcd.id,rcd.inv_no,rcd.customer_id,rcd.net_tot,ld.ledger_name,ld.address,ld.city,ld.state,(select state_name from crmfeesclub.states where id=ld.state)st,ld.phone,ld.gst_no,ld.pan_no from resale_cust_detail as rcd join ledger as ld on rcd.customer_id=ld.id");
		$result = $query->result();
		if($result){
		  return $result;	
		}else{
		  return false;
		}
	}

	public function stock_report(){
		$query = $this->db->query("select product_id,(select pro.product from product as pro  where pro.id=stock.product_id)proname,(select pro.hsn from product as pro  where pro.id=stock.product_id)hsn,batch,qty,mfg_date,exp_date,size,color,price from stock");
		$result = $query->result();
		if($result){
		  return $result;	
		}else{
		  return false;
		}
	}	
}