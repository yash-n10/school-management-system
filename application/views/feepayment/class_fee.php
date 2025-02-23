<div class="form-group has-feedback" id="load">
	<div class="box">
		<div class="box-body">
		<div class="col-lg-12">
		<div class="col-lg-12" style="text-align:right;">
			<button class="btn btn-add" id="add_class_fee" title="Add Class Fee"> <i class="fa fa-plus-circle fa-lg"></i> </button>
		</div>
		</div>
		</div>

<div class="box-body">


<form id='frmtemplate' role="form" method="POST">
<div class="table-responsive">
<table id="templatelist" class="table table-bordered table-striped ">
<thead style="background:#99ceff;">
<tr>
<th style="border-bottom:0px">Class Fee ID </th>
<th style="border-bottom:0px">Year</th>
<th style="border-bottom:0px">Class Range</th>

<th style="border-bottom:0px">Course</th>
<th style="border-bottom:0px"> Action </th>

</tr>
</thead>
<thead style="background: #cce6ff">
<tr id="searchhead">
<th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
<th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
<th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
<th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
<th style="border-bottom:2px solid darkcyan;border-top:0px"></th>

</tr>
</thead>
<tbody>

<?php foreach($class_fee as $obj_fee)
{
$yearval=$obj_fee->year;
$yval=strlen($yearval);
if($yval>=4)
{
$sess_name=$obj_fee->year;
}
else{
$sess_name=$this->dbconnection->Get_namme("accedemic_session", "id", "$obj_fee->year", "session");
}
?>
<tr>
<td> <?php echo $obj_fee->id; ?></td>
<td><?php echo $sess_name . ' '. 'onwards';?></td>
<!-- <td><?php //echo "$obj_fee->year"." onwards";?></td> -->
<td><?php echo "$obj_fee->from_class"."-"."$obj_fee->to_class";?></td>

<td><?php echo $obj_fee->course_name;?></td>
<td>


<span>
<?php if($obj_fee->year>$session_start_yr || ($obj_fee->year==$session_start_yr && $session_start_month==date('m'))){?>
<input type="checkbox" class="btn " name="chk<?php echo $obj_fee->id?>" id="<?php echo $obj_fee->id?>">
<?php }?>

<a class="btn"  onclick="updateClassFee(<?php echo $obj_fee->id; ?>, <?php echo $obj_fee->year; ?>, <?php echo $obj_fee->from_class_id; ?>,<?php echo $obj_fee->to_class_id;?>);">
<?php  if($obj_fee->year>$session_start_yr || ($obj_fee->year==$session_start_yr && $session_start_month==date('m'))||($this->session->userdata('school_id')==8)||($this->session->userdata('school_id')==29)){echo '<i class="fa fa-edit"></i> Edit';}else{ echo '<i class="fa fa-eye"></i>  View';}?>
<!-- <?php if($obj_fee->year>$session_start_yr || ($obj_fee->year==$session_start_yr && $session_start_month==date('m'))){echo '<i class="fa fa-edit"></i> Edit';}else{ echo '<i class="fa fa-eye"></i>  View';}?> -->
</a>

</span>
</td>
</tr>

<?php } ?>     
</tbody>
</table>
</div>
<div class="box-body" style="text-align:right">

<!-- <div class="col-lg-2"><input type="button" class="btn btn-success" id="add_template" value="Add Template"></div> -->
<?php if(count($class_fee) > 0){?>
<!--                    <input type="button" class="btn btn-success" id="save_fee_type" value="Save">-->
<input type="button" class="btn btn-danger" id="delete_template" value="Delete" onclick="deleteClassFee();">
<?php }   ?>

</div>
</form>
</div>

<!-- /.box-body -->
</div>
<!-- /.box -->
</div>

<script>
var globalid = '';
var url = "<?php echo base_url();?>";
var newtxt = 1000;

$(document).ready(function()
{
$(function () {

$('#templatelist').DataTable({
"paging": true,
"lengthChange": true,
"searching": true,
"ordering": true,
"info": true,
"autoWidth": true,
"order": [[1, "desc"]]

});

});


$('#add_class_fee').click(function()
{


window.location.href = "<?php echo base_url('feepayment/class_fee/upload_class_fee');?>";

});


});

function deleteClassFee()
{
//       alert('hello');
var fee_id = '';
$("#templatelist :checkbox").each(function(){
if(this.checked)
{

if(fee_id == ''){
fee_id =this.id;
}else{
fee_id += '|'+this.id;
}
}

});

var r = confirm('Are you sure you want to delete this record?');
if(r == true){

$.ajax({
url : "<?php echo site_url('feepayment/class_fee/delete_class_fee')?>",
type: "POST",
data:{fee_id:fee_id},
dataType: "text",
success: function(data)
{
window.location.reload();
},
error: function (data)
{
alert('Error deleting class.');

}
});
}else{
return false;
}
}

function updateClassFee(id,year,from_class,to_class,stud_cat)
{
//    alert('hi');
//    window.location.href = "<?php // echo base_url('Fee/editClassFee');?>";
window.location.href = "<?php echo site_url('feepayment/class_fee/editClassFee')?>"+'/'+id;
//      $.ajax({
//            url : "<?php // echo site_url('feepayment/class_fee/editClassFee')?>",
//            type: "POST",
//            data: {
//                id:id,
//                year:year,
//                from:from_class,
//                to:to_class,
//                cat:stud_cat
//            },
//            dataType: "text",
//            success: function(data)
//            {
////                alert(data);
//               $('#load').html(data);
//            },
//            error: function (data)
//            {
//                alert('Error');
//
//            }
//        });
}
</script>






