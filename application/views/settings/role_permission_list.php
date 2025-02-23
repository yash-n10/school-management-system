<style>
	td.disp_row {
		padding: 0px 0px 0px 5px; height:27px;
	}
</style>

<div class="form-group has-feedback">
	<div class="box box-primary">
		<div class="box-body">
			<div class="col-lg-8 col-lg-offset-2" id="successMessage" 
				<?php if ($this->session->flashdata('successmsg')) { ?> 
					style="padding: 10px 20px;background: #CCF5CC;text-align:center" <?php 
				} ?>>
				<?php echo $this->session->flashdata('successmsg'); ?>
			</div>
			
			<div class="col-lg-2">
			</div>
        
			<div class="col-lg-12" style="text-align:right;">
				<div class="col-lg-12" style="text-align:right;">
					<button class="btn btn-add" id="add_role_permission" style="border-radius: 2px;"> 
						<i class="fa fa-plus-circle fa-lg"></i><b>&nbsp;&nbsp;Add</b></button>
				</div>
			</div>
		</div>

		<div class="box-body">
			<div class="table-responsive">
				<table class="table table-bordered table-striped" id="period">
					<thead style="background:#99ceff;">
						<tr>
							<th style="border-bottom:0px; width:10%;">S.No.</th>
							<th style="border-bottom:0px; width:40%;">Role Code</th>
							<th style="border-bottom:0px; width:40%;">Role Name</th>
							<th style="border-bottom:0px; width:10%;">Action</th>
						</tr>
					</thead>
					<thead style="background: #cce6ff">
						<tr id="searchhead">
							<th style="border-bottom:2px solid darkcyan; border-top:0px">
								<i class="fa fa-search" style='position: absolute;margin: 0px 0px 3px 3px;'></i><input type="text" class="form-control search" style="width:100%; border-radius:2px; padding-right:10px; padding-left:17px; height: 22px;" placeholder="" data-column="0"/>
							</th>
							<th style="border-bottom:2px solid darkcyan;border-top:0px">
								<i class="fa fa-search" style='position: absolute;margin: 0px 0px 3px 3px;'></i><input type="text" class="form-control search" style="width:100%; border-radius:2px; padding-right:10px; padding-left:17px; height: 22px;" placeholder="" data-column="1"/>
							</th>
							<th style="border-bottom:2px solid darkcyan;border-top:0px">
								<i class="fa fa-search" style='position: absolute;margin: 0px 0px 3px 3px;'></i><input type="text" class="form-control search" style="width:100%; border-radius:2px; padding-right:10px; padding-left:17px; height: 22px;" placeholder="" data-column="2"/>
							</th>
							<th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
						</tr>
					</thead>
          
					<tbody>
						<?php 
						$i = '1';
						foreach($group as $val) {
							if($val->status == 'Y') {      
							?>
							<tr>
								<td class="disp_row" style="padding: 0px 0px 0px 5px; height:30px; vertical-align:middle;"><?php echo $i;?></td>
								<td class="disp_row" style="padding: 0px 0px 0px 5px; height:30px; vertical-align:middle;"><?php echo $val->group_code?></td>
								<td class="disp_row" style="padding: 0px 0px 0px 5px; height:30px; vertical-align:middle;"><?php echo $val->group_type?></td>
								<td class="disp_row" style="padding: 0px 0px 0px 20px; height:30px; vertical-align:middle;"><span><a class="btn a-edit" title="Edit" href="<?php echo base_url();?>settings/Role_permission/edit/<?php echo $val->id;?>">
									<i class="fa fa-edit"></i> </a></span>
									<?php if($val->id >13) {?><span><a class="btn a-delete" title="Delete" onclick="deletes(<?php echo $val->id;?>)">
										<i class="fa fa-trash"></i> </a></span> <?php }?>
								</td>
							</tr>
							<?php $i++;
							} 
						}?>
					</tbody>
				</table>
			</div>
		</div>   
	</div>
</div>

<script>
    
$(function ()
{
    var table=$('#period').DataTable({
        "paging": true,
		"pagelength": 10,
        "lengthChange": true,
		"searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true
    });
            
	$('#searchhead th input').on('keyup change', function () {
//            if ( this.search() !== this.value ) {
//                this
//                    .search( this.value )
//                    .draw();
//            }
		var i = $(this).attr('data-column');
		var v = $(this).val();
		table.columns(i).search(v).draw();
    });
	<?php if ($this->session->flashdata('successmsg')) { ?>
        $('#myMsgModal').modal('show');
    <?php }?>
});


function deletes(id)
{
	var r = confirm("Please confirm if you want to Delete?");
	if (r == true) 
	{ 
		var del_id = id;
		$.post('<?php echo base_url('settings/Role_permission/del'); ?>',{del_id:del_id},function(data){
			alert('Data Deleted Successfully !!');
			location.reload();
		});
	}
}
</script>

<script>
	var globalid = '';
	var url = "<?php echo e(base_url()); ?>";
    var newtxt = 1000;

    $(document).ready(function ()
    {
        $('#add_role_permission').click(function () {
			window.location.href = "<?php echo e(base_url('settings/Role_permission/save_role_permission')); ?>";
        });
    }); 

	setTimeout(function () {
        $('#successMessage').fadeOut("slow");
    }, 5000);
</script>