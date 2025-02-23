<div class="form-group has-feedback">
  <div class="box box-primary">
  <div class="box-body">
  <div class="col-sm-2"></div>
  <div class="col-sm-8">
     <div class="box-body">
	 <?php
	  @$tbl_data_id = $late_fine[0]->id;
	  @$tbl_data_lf = $late_fine[0]->late_fine;
	  if($tbl_data_id != 1){
	 ?>
	   <form action="<?php echo base_url('library/Late_fine/save'); ?>" method="post">
		   <table class="table">
		     <tr>
			   <th>Late Fine/day</th> 
			   <td><input type="number" name='late_fine' class='form-control'></td> 
		     </tr>
			 <tr>
			   <td colspan='2' align='center'><input type="submit" name='save' class='btn btn-success btn-xs'></td>
			 </tr>
		   </table>
	   </form>
	 <?php }else{
		 ?>
		 <form action="<?php echo base_url('library/Late_fine/re_update'); ?>" method="post">
		   <table class="table">
		     <tr>
			   <th>Late Fine/day</th> 
			   <td><input type="number" value='<?php echo $tbl_data_lf; ?>' name='tbl_late_fine' class='form-control'></td> 
		     </tr>
			 <input type="hidden" name='tbl_idd' value='<?php echo $tbl_data_id; ?>'>
			 <tr>
			   <td colspan='2' align='center'><input type="submit" value='Update' class='btn btn-success btn-xs'></td>
			 </tr>
		   </table>
	    </form>
		 <?php
	 } ?>  
	   
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
</script>