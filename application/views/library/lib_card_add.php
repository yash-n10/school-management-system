<div class="form-group has-feedback">
  <div class="box box-primary">
  <div class="box-body">
    <div class="col-sm-2"></div>
  <div class="col-sm-8">
     <div class="box-body">
	   <form action="<?php echo base_url('library/Lib_card/save'); ?>" method="post">
		   <table class="table">
			 <tr> 
			   <th>Admission No.</th>
			   <td colspan='3'>
			     <select name="adm_no" class="form-control" onchange="adm(this.value)">
				   <option value=''>Select</option>
				   <?php
				     foreach($student as $data){
				   ?>
				   <option value="<?php echo $data->admission_no; ?>"><?php echo $data->admission_no; ?></option>
				   <?php } ?>
				 </select>
				 <span style="color:red;"><?php echo form_error('adm_no'); ?></span>
			   </td>
			 </tr>
             <tr>			 
			   <th>Student Name</th>
			   <td><input type="text" id="stu_name" name="stu_name" class="form-control" readonly></td>
			   <td><input type="text" id="stu_name1" name="stu_name1" class="form-control" readonly></td>
			   <td><input type="text" id="stu_name2" name="stu_name2" class="form-control" readonly></td>
             </tr>

             <tr>
                <th>Class/Section</th>
			    <td><input type="text" id="class" name="class" class="form-control" readonly></td>
                <td colspan='2'><input type="text" id="section" name="section" class="form-control" readonly></td>			
             </tr>
			 

             <tr>
                <th>Roll</th>
			    <td colspan='3'><input type="text" id="roll" name="roll" class="form-control" readonly></td>			 
             </tr>
			 
			 <tr>
                <th>Library Card No</th>
			    <td colspan='3'><input type="text" id="lib_card" name="lib_card_no" class="form-control" readonly></td>			 
             </tr>
			 
			 <tr>
                <th>Allow(No. of Books)</th>
			    <td colspan='3'><input type="number" name="no_book" class="form-control">
				<span style="color:red;"><?php echo form_error('no_book'); ?></span>
				</td>			 
             </tr>
			 
			 <tr>
                <th>Days Allow</th>
			    <td colspan='3'><input type="number" name="allow_days" class="form-control">
				<span style="color:red;"><?php echo form_error('allow_days'); ?></span>
				</td>			 
             </tr>
			 
			  <!--<tr>
                <th>Late Fine</th>
			    <td colspan='3'>--><input type="hidden" value='0' name="late_fine" class="form-control" readonly>
				<span style="color:red;"><?php echo form_error('late_fine'); ?></span>
				<!--</td>			 
             </tr>-->
			 
			 <tr>
                <th>Card Expiry</th>
			    <td colspan='3'><input type="date" name="card_exp" class="form-control">
				<span style="color:red;"><?php echo form_error('card_exp'); ?></span>
				</td>			 
             </tr>
			 
			 <tr>
			    <td colspan='4' align='center'><input type="submit" name="save" value="Submit" class="btn btn-success"></td>			 
             </tr>
		   </table>
	   </form>
    </div>
  </div>
  <div class="col-sm-2"></div>  
  </div>
  </div>
</div>

<script>
$(function ()
{
    var table=$('#period').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true
    });
            $('#searchhead th input').on('keyup change', function () {
            var i = $(this).attr('data-column');
            var v = $(this).val();
            table.columns(i).search(v).draw();
        });
});

function adm(adm){
	$.post('<?php echo base_url('library/Lib_card/fetdata'); ?>',{adm:adm},function(data){
		
		var stu = $.parseJSON(data);
		var id = stu[0];
		var fir_name = stu[1];
        var lib_card = fir_name.substring(0,3);
		var roll = stu[6];
		var final_lib_card = lib_card+id+roll;
		
		$("#stu_name").val(stu[1]);
		$("#stu_name1").val(stu[2]);
		$("#stu_name2").val(stu[3]);
		$("#class").val(stu[4]);
		$("#section").val(stu[5]);
		$("#roll").val(stu[6]);
		$("#lib_card").val(final_lib_card);
	});
}
</script>