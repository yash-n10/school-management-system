<div class="form-group has-feedback">
	<div class="box box-primary">
		<div class="box-body">    
			<div class='row'>
				<div class='col-sm-3'>Routes</div>
				<div class='col-sm-6'>

					<?php
					if($this->session->flashdata('success')){
						?>
						<div class="alert alert-success alert-dismissible" id="suc_msg">
							<a href="#" class="close" data-dismiss="alert"></a>
							<?php echo $this->session->flashdata('success'); ?>
						</div>
					<?php } ?>
				</div>

				<div class='col-sm-3'>
					<!-- <a href="<?php echo base_url(); ?>" class="btn btn-primary pull-right ">BACK</a> -->
					<a class="btn btn-import pull-right" id="studexport" href='<?= base_url()?>transport/Routes/importcsv' data-toggle="tooltip" data-placement="bottom" title="Import Routes">
						<i class="fa fa-cloud-upload fa-lg"></i>&nbsp;
					</a>
				</div>	
			</div>  
			<hr> 
			<style type="text/css">
				@media (min-width: 992px){
						 .ccmonths{
					  	margin-top: -29px;
					  	box-shadow: 2px 2px 4px 7px #ccc!important;
						}
					}
					@media (min-width: 320px) and (max-width: 480px) {
						 .ccmonths{					  
					  	box-shadow: 2px 2px 4px 3px #ccc!important;
						}
					}
					


			</style>
			<form id="publisher_data">
				<div class="row top">
					<div class="col-md-12">						
						<div class="col-md-3">
							<div class="form-group">
								<label for="inputPassword" class="col-sm-4 col-form-label">Class</label>
								<div class="col-sm-8">
									<select name="class" id="class">
										<option value="">Select Class</option>
										<?php foreach($class as $data) { ?>
											<option value="<?php echo $data->id ?>"><?php echo $data->class_name ?></option>
										<?php } ?>
									</select>
									<input type="hidden" class="form-control" id="hid" value="" >
								</div>
							</div>
						</div>
						<div class="col-md-8">
							<div class="form-group">
								<label for="inputPassword" class="col-sm-3 col-form-label">Months Allocate</label>
								<div class="col-sm-8 ccmonths">
									<div class="row">
										<div class="">
											<?php
													$count = 1;
											foreach($month as $mon) {
											
												if ($count%4 == 1)
											    {  
											         echo "<div class='col-md-3'>";
											    }?>
											 <div class="icheck-material-primary">
												<input type="checkbox" id="chk_id_<?php echo $mon->id ?>" value="<?php echo $mon->id ?>" name="month[]" />
												<label for="primary"><?php echo $mon->month_name;?></label>
												</div><?php 
											    if ($count%4 == 0)
											    {
											        echo "</div>";
											    }
											    $count++;
											 }?>
											
										</div>
									</div><!--End Row-->
								</div>
							</div>
						</div>
					</div>
					<div class="">
						<div class="col-md-4"></div>
						<div class="col-md-4">
							<button class="btn btn-success" type="button" onclick="Save();"> save </button>
						</div>
						<div class="col-md-4"></div>
					</div>
				</div>
				<hr>
				
				
			</form>
		</div>
	</div>
</div>

<div class="form-group has-feedback">
	<div class="box box-primary">
		<div class="box-body">    
			<div class="table-responsive" id="data_tab">
				<table class="table table-bordered table-striped" id="book_publisher">
					<thead style="background:#99ceff;">
						<tr>
							<th>Sl No.</th>
							<th>Class</th>
							<th>Month</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
                        <?php $x = 1;foreach($setupdata as $value){
                        	$cat = '';
            				$cat_id = '';
                        	if ($value->month_id != '') {
				                $monthfetch = explode("-", $value->month_id);
				                // print_r($monthfetch);
				                foreach ($monthfetch as $val) {
				                    $fetch_mon_name = $this->dbconnection->select("month", "month_name", "status='Y' and id=".$val);
				                    if ($cat == '') {
				                        $cat = $fetch_mon_name[0]->month_name;
				                        $cat_id = $val;
				                    } else {
				                        $cat = $cat . ' , ' . $fetch_mon_name[0]->month_name;
				                        $cat_id = $cat_id . ' , ' . $val;
				                    }
				                }
				            }
                        	?>
                        <tr>
                        <td><?php echo $x; ?></td>
                        <td><?php echo $value->class_name; ?></td>
                        <td><?php echo $cat; ?></td>
                        </tr>
                         <?php $x++;}?>
                    </tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script>
		$(document).ready(function() {
	  $('#book_publisher').DataTable();
	});
	function Save()
	{
		var class_name=$('#class').val();

      	var month='';
          $("input[name='month[]']:checked").each(function() 
          {
              if(month == '')
              {
                month  = this.value;           
              }
              else
              {
                month  += "-"+ this.value ; 
              }
          });
          $.ajax({
          	url: '<?php echo base_url();?>transport/Transport_FeeSetup/save',
          	data:{class_name:class_name,month:month},
          	// dataType: "json",
          	type:"POST",
              success: function(data)
              {
              	$('#data_tab').html('');
            	$('#data_tab').html(data);
				$("#publisher_data")[0].reset();
              }
          });
	}
</script>


