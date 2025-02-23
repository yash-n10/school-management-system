<div class="form-group has-feedback">
  <div class="box">            
   <!--  <div class="box-body">
      <div class="col-lg-12">
        <div class="col-lg-12" style="text-align:right;"><a class="btn btn-add" id="add_session" title="Add Class Teacher" href="<?php echo base_url('academics/Subject_teachers/add_form') ?>"> <i class="fa fa-plus-circle fa-lg"></i> </a></div>
      </div>
    </div> -->

    <div class="box-body">
                        <div class="col-md-5 col-md-offset-3">
                            <?php if ($this->session->flashdata('successmsg')) { ?>
                                <div class="col-md-12">
                                    <div class="alert alert-success alert-le"  id="success-alert">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Success!</strong> <?php echo $this->session->flashdata('successmsg'); ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

    <div class="box-body">
      	<form id='frmtemplate' role="form" method="POST">
          	<div class="table-responsive">
        		<table id="datalist" class="table table-bordered table-striped dTable">
          			<thead style="background:#99ceff;">
			            <tr>
			              <th style="border-bottom:0px">Session Id</th>
			              <th style="border-bottom:0px">Academic Session</th>
			              <th style="border-bottom:0px">Action</th>
			            </tr>
          			</thead>
		          <!-- 	<thead style="background: #cce6ff">
			            <tr id="searchhead">

			                <th style="border-bottom:2px solid darkcyan;border-top:0px">
			                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="id"/>
			                </th>
			                <th style="border-bottom:2px solid darkcyan;border-top:0px">
			                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="session"/>
			                </th>
			                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
			            </tr>
		        	</thead> -->
          			<tbody>
			            <?php 
			              if(count($asession) > 0){
			              foreach ($asession as $sess) 
			              {
			            ?>
		              <tr <?php $statuss = $sess->active; if($statuss=='Y'){ echo 'style="background: lightcyan;color: darkblue;font-weight: bold;"';}?>>
		                <td><span id="id<?php echo $sess->id?>"><?php echo $sess->id; ?></span></td>
		                <td><span class="editable"  id="sess<?php echo $sess->id?>"><?php echo $sess->session; ?></span></td>
		                <td><a class="label label-primary" id="<?php echo $sess->id; ?>" onclick="updateAssignTeacher(this);" style="font-size: 12px;font-weight: 600;">Assign Subject Teacher</span></a></td>
		              </tr>
			            <?php 
			                }
			              } 
			            ?>
          			</tbody>
          			<tfoot></tfoot>
        </table>
          </div>
      </form>
      </div>
    <!-- /.box-body -->

    <div class="box-body">
        <div class="table-responsive">
      <table id="templatelist" class="table table-bordered table-striped">
        <thead style="background:#99ceff;">
          <tr>
            <th style="border-bottom:0px">Class</th>
            <th style="border-bottom:0px">Section</th>
            <th style="border-bottom:0px">Subject</th>
            <th style="border-bottom:0px">Teacher</th>
          </tr>
        </thead>
        <thead style="background: #cce6ff">
            <tr id="searchhead">
                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="0"/>
                </th>
                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="1"/>
                </th>
                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="2"/>
                </th>
                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="3"/>
                </th>

            </tr>
        </thead>
        <tbody>
          <?php foreach($selectdata as $data){
            ?>
            <tr>
              <td><?php echo $data->class_id_disp;?></td>
              <td><?php echo $data->section_id_disp;?></td>
              <td><?php echo $data->subject_id_disp;?></td>
              
              <td><?php echo $data->teacher_id_disp;?></td>
            </tr>
          <?php }?>
        </tbody>
      </table>
    </div>
    </div>
  </div>
</div>

<form name="form-any" method="post" action="" id="form-any" style="display:none">
    <input type="hidden" name="formdata" id="formdata" value="">
</form> 


<script>

$(function() 
{
  var table =$('#templatelist').DataTable({
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

    function updateAssignTeacher(me)
    {
        var academic_id = me.id;
        document.getElementById('form-any').action = '<?php echo site_url('academics/Subject_teachers_ruchi/add_subject_teachers') ?>';
        $('#formdata').val(academic_id);
        document.getElementById('form-any').submit();
    }


</script>