

<style>
    .dt-button.red {
        color: darkgreen;
        font-weight: bold;
    }
</style>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js" type="text/javascript"></script>
<form id="frmstudent1" role="form" method="POST">
<div class="table-responsive">
<table id="studentlist1" class="table table-bordered table-striped">
    <thead>
        <tr> 
	<th>fee heads</th>
	<th>fee sub heads</th>
	<th>Sl.No</th>
	<th>ADMISSION NO</th>
	<th>TRANSACTION DATE</th>
	<th>TRANSACTION ID</th>
	<th>NAME</th>
	<th>CLASS-SEC</th>
	<th>ROLL NO</th>
	<th>MONTH DETAILS</th>
	<th>TOTAL AMOUNT</th>
	<th>Tution Fee</th>
	<th>Yearly Development Charge</th>
	<th>Examination Fee</th>
	<th>Pupil Fund</th>
	<th>Computer Fee</th>
	<th>Science Fee</th>
	<th>Smart Class & SMS</th>
	<th>Registration Fee/CBSE Board Fee</th>
	<th>Text Book</th>
	<th>Olympiad Fee</th>
	<th>Belt Fee</th>
	<th>Admission Form</th>
	<th>Magazine Fee</th>
	<th>Annual Development Fee</th>
	<th>Re-Admission Fee</th>
	<th>Excursion Charge</th>
	<th>Transfer Fee</th>
	<th>Badge Fee</th>
	<th>Diary Fee</th>
	<th>Excercise Book</th>
	<th>Transport Fee</th>
	<th>Admission Fee</th>
	<th>Prev Year  Fine</th>
	<th>Re-Admission-Fine</th>
	<th>Fine</th>
	<th>FINE WAIVER</th>
	<th>POS No.</th>
	<th>Remarks/Receipt No/Collection Centre</th>
 
</tr>
<tbody id="daily_load_td">

<?php
$k=0;
foreach ($fee_transaction_head as $key ) {
$k++;

//GETTING STUDENT DETAILS
$student_data=$this->db->query("SELECT * FROM student where id = '$key->student_id'");
$student_data=$student_data->result();
$student_data=$student_data[0];
$class=$this->db->query("SELECT class_name FROM class where id='$student_data->class_id'");
$class=$class->result();
$class=$class[0];
$section=$this->db->query("SELECT sec_name FROM section where id='$student_data->section_id'");
$section=$section->result();
$section=$section[0];



//GETTING FEES BIFURCATION
$fees=$this->db->query("SELECT * FROM fee_transaction_det where fee_trans_head_id='$key->id'");
$fees=$fees->result();


//THIS IS CLASS FEE ID AS IN CLASS FEE HEAD AND DET
$class_fee_head_id=$this->db->query("SELECT * FROM class_fee_head where from_class_id<='$student_data->class_id' and to_class_id>='$student_data->class_id' and year='$key->year' and course=$student_data->course_id");
$class_fee_head_id=$class_fee_head_id->result();
$class_fee_head_id=$class_fee_head_id[0];
$class_fee_head_id=$class_fee_head_id->id;






//FOR GETTING NO OF MONTHS AND MONTH DESCRIPTION IN CASE OF MONTHLY FEE
$month_desc='';
$fee_types=array();
$fee_sub_types=array();
$no_of_months=0;
$i=0;
foreach ($fees as $value) {
	$month_desc=$month_desc.' '.$value->month_desc;
	if ($value->fee_cat_id==2) {
		$no_of_months=$no_of_months+1 ;
		
	}
	$fee_types[$i]=$value->fee_cat_id;
	$fee_sub_types[$i]=$value->other_fee_id;
	$i++;
}

//GETTING MONTHLY FEES FROM CLASS FEE DET ACCORDING TO DATE
if(in_array(2,$fee_types)){
	$tution=$this->db->query("SELECT fee_amount FROM class_fee_det WHERE class_fee_head_id='$class_fee_head_id' and last_applicable_till > '$key->payment_date' and fee_id=1 and stud_cat=$student_data->stud_category order by last_applicable_till ");
	$tution=$tution->result();
	$tution=$tution[0];
	$tution=$tution->fee_amount;

	$yearly=$this->db->query("SELECT fee_amount FROM class_fee_det WHERE class_fee_head_id='$class_fee_head_id' and last_applicable_till > '$key->payment_date' and fee_id=2 order by last_applicable_till");
	$yearly=$yearly->result();
	$yearly=$yearly[0];
	$yearly=$yearly->fee_amount;
	$exam=$this->db->query("SELECT fee_amount FROM class_fee_det WHERE class_fee_head_id='$class_fee_head_id' and last_applicable_till > '$key->payment_date' and fee_id=3 order by last_applicable_till");
	$exam=$exam->result();
	$exam=$exam[0];
	$exam=$exam->fee_amount;

	$pupil=$this->db->query("SELECT fee_amount FROM class_fee_det WHERE class_fee_head_id='$class_fee_head_id' and last_applicable_till > '$key->payment_date' and fee_id=4 order by last_applicable_till");
	$pupil=$pupil->result();
	$pupil=$pupil[0];
	$pupil=$pupil->fee_amount;

	$computer=$this->db->query("SELECT fee_amount FROM class_fee_det WHERE class_fee_head_id='$class_fee_head_id' and last_applicable_till > '$key->payment_date' and fee_id=5 order by last_applicable_till");
	$computer=$computer->result();
	$computer=$computer[0];
	$computer=$computer->fee_amount;

	$science=$this->db->query("SELECT fee_amount FROM class_fee_det WHERE class_fee_head_id='$class_fee_head_id' and last_applicable_till > '$key->payment_date' and fee_id=6 order by last_applicable_till");
	$science=$science->result();
	$science=$science[0];
	$science=$science->fee_amount;

	$smart_class=$this->db->query("SELECT fee_amount FROM class_fee_det WHERE class_fee_head_id='$class_fee_head_id' and last_applicable_till > '$key->payment_date' and fee_id=8 order by last_applicable_till");
	$smart_class=$smart_class->result();
	$smart_class=$smart_class[0];
	$smart_class=$smart_class->fee_amount;

}


//FOR OTHER/ADDITIONAL FEE
$registration='';
if(in_array(3,$fee_types)){
	//FOR CBSE BOARD FEE / REGISTRATION FEE
	if (in_array(10,$fee_sub_types) ) {
	$registration=$this->db->query("SELECT fee_amount FROM class_fee_det WHERE class_fee_head_id='$class_fee_head_id' and last_applicable_till > '$key->payment_date' and fee_id=10  order by last_applicable_till ");
	$registration=$registration->result();
	$registration=$registration[0];
	$registration=$registration->fee_amount;
	// print_r($registration);
	}
	if (in_array(11,$fee_sub_types) ) {
	$registration=$this->db->query("SELECT fee_amount FROM class_fee_det WHERE class_fee_head_id='$class_fee_head_id' and last_applicable_till > '$key->payment_date' and fee_id=11  order by last_applicable_till ");
	$registration=$registration->result();
	$registration=$registration[0];
	$registration=$registration->fee_amount;
	// print_r($registration);

	}
	
	//FOR OLYMPIAD FEE
	if (in_array(138,$fee_sub_types) or in_array(139,$fee_sub_types) or in_array(140,$fee_sub_types) or in_array(141,$fee_sub_types)  ) {
	// echo "string";
	$olympiad=$this->db->query("SELECT fee_amount FROM class_fee_det WHERE class_fee_head_id='$class_fee_head_id' and last_applicable_till > '$key->payment_date' and fee_id=138  order by last_applicable_till ");
	$olympiad=$olympiad->result();
	$olympiad=$olympiad[0];
	$olympiad=$olympiad->fee_amount;
	}
	else{
		$book=0;
	foreach ($fee_sub_types as $a) {
	if(($a>32 and $a<94) or ($a>94 and $a<118) or ($a>119 and $a<138) or $a==142)
	$book1=$this->db->query("SELECT fee_amount FROM class_fee_det WHERE class_fee_head_id='$class_fee_head_id' and last_applicable_till > '$key->payment_date' and fee_id='$a'  order by last_applicable_till ");
	$book1=$book1->result();
	$book1=$book1[0];
	$book=$book +$book1->fee_amount;

	}
	}

}

//FOR INSTANT FEE
if(in_array(8,$fee_types)){
	if (in_array(29,$fee_sub_types) ) {
	// echo "string";
	$registration=$this->db->query("SELECT fee_amount FROM class_fee_det WHERE class_fee_head_id='$class_fee_head_id' and last_applicable_till > '$key->payment_date' and fee_id=29  order by last_applicable_till ");
	$registration=$registration->result();
	$registration=$registration[0];
	$registration=$registration->fee_amount;
	}

	if (in_array(15,$fee_sub_types)) {
	// echo "string";
	$belt=$this->db->query("SELECT fee_amount FROM class_fee_det WHERE class_fee_head_id='$class_fee_head_id' and last_applicable_till > '$key->payment_date' and fee_id=15  order by last_applicable_till ");
	$belt=$belt->result();
	$belt=$belt[0];
	$belt=$belt->fee_amount;
	}
	if (in_array(16,$fee_sub_types)) {
	// echo "string";
	$admission_form=$this->db->query("SELECT fee_amount FROM class_fee_det WHERE class_fee_head_id='$class_fee_head_id' and last_applicable_till > '$key->payment_date' and fee_id=16  order by last_applicable_till ");
	$admission_form=$admission_form->result();
	$admission_form=$admission_form[0];
	$admission_form=$admission_form->fee_amount;
	}
	
	if (in_array(17,$fee_sub_types)) {
	// echo "string";
	$magzine=$this->db->query("SELECT fee_amount FROM class_fee_det WHERE class_fee_head_id='$class_fee_head_id' and last_applicable_till > '$key->payment_date' and fee_id=17  order by last_applicable_till ");
	$magzine=$magzine->result();
	$magzine=$magzine[0];
	$magzine=$magzine->fee_amount;
	}
	if (in_array(15,$fee_sub_types)) {
	// echo "string";
	$belt=$this->db->query("SELECT fee_amount FROM class_fee_det WHERE class_fee_head_id='$class_fee_head_id' and last_applicable_till > '$key->payment_date' and fee_id=15  order by last_applicable_till ");
	$belt=$belt->result();
	$belt=$belt[0];
	$belt=$belt->fee_amount;
	}
	if (in_array(19,$fee_sub_types)) {
	// echo "string";
	$excursion=$this->db->query("SELECT fee_amount FROM class_fee_det WHERE class_fee_head_id='$class_fee_head_id' and last_applicable_till > '$key->payment_date' and fee_id=19  order by last_applicable_till ");
	$excursion=$excursion->result();
	$excursion=$excursion[0];
	$excursion=$excursion->fee_amount;
	}
	if (in_array(20,$fee_sub_types)) {
	// echo "string";
	$transfer=$this->db->query("SELECT fee_amount FROM class_fee_det WHERE class_fee_head_id='$class_fee_head_id' and last_applicable_till > '$key->payment_date' and fee_id=20  order by last_applicable_till ");
	$transfer=$transfer->result();
	$transfer=$transfer[0];
	$transfer=$transfer->fee_amount;
	}
	if (in_array(21,$fee_sub_types)) {
	// echo "string";
	$badge=$this->db->query("SELECT fee_amount FROM class_fee_det WHERE class_fee_head_id='$class_fee_head_id' and last_applicable_till > '$key->payment_date' and fee_id=21  order by last_applicable_till ");
	$badge=$badge->result();
	$badge=$badge[0];
	$badge=$badge->fee_amount;
	}
	if (in_array(23,$fee_sub_types)) {
	// echo "string";
	$exercise=$this->db->query("SELECT fee_amount FROM class_fee_det WHERE class_fee_head_id='$class_fee_head_id' and last_applicable_till > '$key->payment_date' and fee_id=23  order by last_applicable_till ");
	$exercise=$exercise->result();
	$exercise=$exercise[0];
	$exercise=$exercise->fee_amount;
	}
	if (in_array(118,$fee_sub_types)) {
	// echo "string";
	$previous_fine=$this->db->query("SELECT fee_amount FROM class_fee_det WHERE class_fee_head_id='$class_fee_head_id' and last_applicable_till > '$key->payment_date' and fee_id=118  order by last_applicable_till ");
	$previous_fine=$previous_fine->result();
	$previous_fine=$previous_fine[0];
	$previous_fine=$previous_fine->fee_amount;
	}
	if (in_array(32,$fee_sub_types)) {
	// echo "string";
	$transport=$this->db->query("SELECT fee_amount FROM class_fee_det WHERE class_fee_head_id='$class_fee_head_id' and last_applicable_till > '$key->payment_date' and fee_id=32  order by last_applicable_till ");
	$transport=$transport->result();
	$transport=$transport[0];
	$transport=$transport->fee_amount;
	}
	if (in_array(31,$fee_sub_types)) {
	// echo "string";
	$retest=$this->db->query("SELECT fee_amount FROM class_fee_det WHERE class_fee_head_id='$class_fee_head_id' and last_applicable_till > '$key->payment_date' and fee_id=31  order by last_applicable_till ");
	$retest=$retest->result();
	$retest=$retest[0];
	$retest=$retest->fee_amount;
	}
	
}

//FOR ANNUAL FEE
if (in_array(8,$fee_types)) {
	
	if (in_array(7,$fee_sub_types)) {
	// echo "string";
	$annual_dev=$this->db->query("SELECT fee_amount FROM class_fee_det WHERE class_fee_head_id='$class_fee_head_id' and last_applicable_till > '$key->payment_date' and fee_id=7  order by last_applicable_till ");
	$annual_dev=$annual_dev->result();
	$annual_dev=$annual_dev[0];
	$annual_dev=$annual_dev->fee_amount;
	}
	if (in_array(18,$fee_sub_types)) {
	// echo "string";
	$re_admission=$this->db->query("SELECT fee_amount FROM class_fee_det WHERE class_fee_head_id='$class_fee_head_id' and last_applicable_till > '$key->payment_date' and fee_id=18  order by last_applicable_till ");
	$re_admission=$re_admission->result();
	$re_admission=$re_admission[0];
	$re_admission=$re_admission->fee_amount;
	}
	if (in_array(22,$fee_sub_types)) {
	// echo "string";
	$diary=$this->db->query("SELECT fee_amount FROM class_fee_det WHERE class_fee_head_id='$class_fee_head_id' and last_applicable_till > '$key->payment_date' and fee_id=22  order by last_applicable_till ");
	$diary=$diary->result();
	$diary=$diary[0];
	$diary=$diary->fee_amount;
	}
}
if (in_array(9,$fee_types)) {
	
	if (in_array(94,$fee_sub_types)) {
	// echo "string";
	$admission=$this->db->query("SELECT fee_amount FROM class_fee_det WHERE class_fee_head_id='$class_fee_head_id' and last_applicable_till > '$key->payment_date' and fee_id=7  order by last_applicable_till ");
	$admission=$admission->result();
	$admission=$admission[0];
	$admission=$admission->fee_amount;
	}
}
//FOR TESTING PURPOSE
// print_r($belt);die();
// print_r($fee_types);
// echo "<pre>";print_r($student_data);
// echo "<pre>";print_r($fees);die();
// die();
?>
<tr style="background-color:white; color:black;">
	<td><?php print_r($fee_types);?></td>
	<td><?php print_r($fee_sub_types);?></td>
	<td><?php echo $k;?></td>
	<td><?php echo $student_data->admission_no;?></td>
	<td><?php echo $key->payment_date;?></td>
	<td><?php echo $key->transaction_id;?></td>
	<td><?php echo $student_data->first_name.' '.$student_data->middle_name.' '.$student_data->last_name;?></td>
	<td><?php echo $class->class_name.' - '.$section->sec_name; ?></td>
	<td><?php echo $student_data->roll;?></td>
	<td><?php echo $month_desc;echo $no_of_months; ?></td>
	<td><?php echo $key->total_amount-$key->discount_amount;?></td>
	<td><?php echo $tution *$no_of_months;?></td>
	<td><?php echo $yearly*$no_of_months;?></td>
	<td><?php echo $exam*$no_of_months;?></td>
	<td><?php echo $pupil*$no_of_months;?></td>
	<td><?php echo $computer*$no_of_months;?></td>
	<td><?php echo $science*$no_of_months;?></td>
	<td><?php echo $smart_class*$no_of_months;?></td>
	<td><?php echo $registration;?></td>
	<td><?php echo $book;?></td>
	<td><?php echo $olympiad;?></td>
	<td><?php echo $belt;?></td>
	<td><?php echo $admission_form;?></td>
	<td><?php echo $magzine;?></td>
	<td><?php echo $annual_dev;?></td>
	<td><?php echo $re_admission;?></td>
	<td><?php echo $excursion ;?></td>
	<td><?php echo $transfer;?></td>
	<td><?php echo $badge;?></td>
	<td><?php echo $diary;?></td>
	<td><?php echo $exercise;?></td>
	<td><?php echo $transport;?></td>
	<td><?php echo $admission;?></td>
	<td><?php echo $prev_fine;?></td>
	<td><?php echo '';?></td>
	<td><?php echo '';?></td>
	<td><?php echo $key->discount_amount;?></td>
	<td><?php echo $key->pos_no;?></td>
	<td><?php echo 'Remarks:<br>'.$key->remarks . '<br> Receipt No:<br>'.$key->receipt_no.'<br>Collection Centre:<br>'.$key->collection_centre;?></td>
</tr>
<?php
}
?>
</tbody>
</table>
<script>
   
  $(document).ready( function () {
    $('studentlist1').DataTable({
             dom: 'Bfrtip',
                 buttons: [
                                {
                                    extend: 'collection',
                                    text: 'Export',
                                    className: 'red',
                                    buttons: [
                              
                                        'excel',
                                        'csv',
                                        {
                                            extend: 'pdf',
                                            orientation: 'landscape',
                                            pageSize: 'A3'
                                        },
                                        {
                                            extend: 'print',
                                            orientation: 'landscape',
                                            pageSize: 'A3'
                                        },
                                    ]
                                }
                            ]

                            
            });
} ); 

    </script>