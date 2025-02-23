<div class="form-group has-feedback">
  <div class="box box-primary">
    <div class="box-body">
    
	<a href='<?php echo base_url('inventory/Resale/sale_pro'); ?>' class='pull-right'>
		<button class="btn btn-add" id="add_record" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Add Item">
			<i class="fa fa-plus-circle fa-lg"></i>&nbsp; 
		</button>
	</a><br /><br />
       <div class="table-responsive">
        <table class="table table-bordered table-striped" id="period">
          <thead style="background:#99ceff;">
            <tr>
               <th>Sl No.</th>
               <th>Invoice No</th>
			   <th>Name</th>
			   <th>City</th>
			   <th>State</th>
			   <th>Phone</th>
			   <th>GSTIN No</th>
			   <th>Net Total</th>
			   <th>Action</th>
            </tr>
          </thead>
          
          
          <tbody>
            <?php
		     if($resale)
			 {
				 $i = 1;
				 foreach($resale as $data)
				 {
		   ?>
		   <tr>
		       <td><?php echo $i; ?></td>
		       <td><?php echo $data->inv_no; ?></td>
			   <td><?php echo $data->ledger_name; ?></td>
			   <td><?php echo $data->city; ?></td>
			   <td><?php echo $data->st; ?></td>
			   <td><?php echo $data->phone; ?></td>
			   <td><?php echo $data->gst_no; ?></td>
			   <td><?php echo $data->net_tot; ?></td>
			   <td>
			     <a href="<?php echo base_url('inventory/Resale/resale_view/'.$data->id); ?>" class="btn a-view" title="View"><i class="fa fa-eye"></i></a> | 
			     <a href="<?php echo base_url('inventory/Resale/resale_edit/'.$data->id); ?>" class="btn a-edit" title="Edit"><i class="fa fa-edit"></i></a>
			   </td>
		   </tr>
		   <?php 
		        $i++;
				 }
			 }
		   ?>
          </tbody>
        </table>
        </div>
  </div>
</div>
</div>

<script>
$(function (){
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