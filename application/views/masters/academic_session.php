<div class="form-group has-feedback">
	<div class="box">            
		<div class="box-body">
			<?php if(substr($right_access, 0,1)=='C'){?>
				<div class="col-lg-12">
					<div class="col-lg-12" style="text-align:right;"><button data-toggle="modal" data-target="#div_academic_session" class="btn btn-add" id="add_session"> <i class="fa fa-plus-circle fa-lg"></i> </button></div>
				</div>
			<?php }?>
		</div>

		<div class="box-body">
			<?php if(substr($right_access, 1,1)=='R'){?>
				<form id='frmtemplate' role="form" method="POST">
					<div class="table-responsive">
						<table id="datalist" class="table table-bordered table-striped dTable">
							<thead style="background:#99ceff;">
								<tr>
									<th style="border-bottom:0px">Session Id</th>
									<th style="border-bottom:0px">Academic Session</th>
									<th style="border-bottom:0px">Start Date</th>
									<th style="border-bottom:0px">End Date</th>
									<th style="border-bottom:0px">Status</th>
									<th style="border-bottom:0px">Action</th>
								</tr>
							</thead>
							<thead style="background: #cce6ff">
								<tr id="searchhead">
									<th style="border-bottom:2px solid darkcyan;border-top:0px">
										<i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="id"/>
									</th>
									<th style="border-bottom:2px solid darkcyan;border-top:0px">
										<i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="session"/>
									</th>
									<th style="border-bottom:2px solid darkcyan;border-top:0px">
										<i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="start_date"/>
									</th>
									<th style="border-bottom:2px solid darkcyan;border-top:0px">
										<i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="end_date"/>
									</th>
									<th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
									<th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
								</tr>
							</thead>
						
							<tbody>
								<?php 
								if(count($asession) > 0) {
									foreach ($asession as $sess) {
								?>
									<tr <?php $statuss = $sess->active; if($statuss=='Y'){ echo 'style="background: lightcyan;color: darkblue;font-weight: bold;"';}?>>
										<td><span id="id<?php echo $sess->id?>"><?php echo $sess->id; ?></span></td>
										<td><span class="editable"  id="sess<?php echo $sess->id?>"><?php echo $sess->session; ?></span></td>
										<td><span class="editable"  id="start_date<?php echo $sess->id?>"><?php echo $sess->start_date; ?></span></td>
										<td><span class="editable"  id="end_date<?php echo $sess->id?>"><?php echo $sess->end_date; ?></span></td>
										<td><?php echo $statusname[$statuss]; ?></td>
								<!-- <td><?php  if($statuss=='N'){echo 'Inactive';}else{echo 'Active';}?></td> -->
										<td>
											<?php 
											if(substr($right_access, 2,1)=='U') {
												if($statuss=='Y'){?>
													<span><a class="btn a-edit" id="<?php echo $sess->id; ?>" onclick="view_fees(<?php echo $sess->id; ?>,'<?php echo $sess->active;?>','<?php echo $sess->session; ?>','<?php echo $sess->start_date; ?>','<?php echo $sess->end_date; ?>')"><i class="fa fa-edit"></i> </a></span>
												<?php } 
												else if($statuss=='N' && $sess->end_date>=date('Y-m-d')) {?>
													<span><a class="btn a-edit" id="<?php echo $sess->id; ?>" onclick="view_fees(<?php echo $sess->id; ?>,'<?php echo $sess->active;?>','<?php echo $sess->session; ?>','<?php echo $sess->start_date; ?>','<?php echo $sess->end_date; ?>')"><i class="fa fa-edit"></i> </a></span>
												<?php }
											}
											if(substr($right_access, 3,1)=='D') {
												if($statuss=='N' && $sess->end_date>=date('Y-m-d')) {?>
													<span><a class="btn a-delete" id="<?php echo $sess->id; ?>" onclick="delet(<?php echo $sess->id; ?>)"><i class="fa fa-trash"></i> Delete</a></span>
												<?php }
											}?>
										</td>
									</tr>
									<?php 
									}
								} 
								?>
							</tbody>
							<tfoot>
							</tfoot>
						</table>
					</div>
				</form>
			<?php }
			?>
		</div>
		<!-- /.box-body -->
	</div>
	<!-- /.box -->
</div>


<!-- Update Modal-->
<div id="sessionedi" class="modal fade editmodal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" id="modal_header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Edit Academic Session</h4>
			</div>
			
			<form id="form_e" method="post">
				<div class="modal-body" id="modal-body">
					<div class="row form-group">
						<label class="col-md-2">Session :</label>
						<div class="col-md-8" style='padding-bottom:1%'>
							<input type="text" class="form-control sessi" id="sessi" name="sessions" placeholder="0000-0000" value="" required maxlength="9" />
							<small id="emailHelp" class="form-text text-muted">Ex: 2000-2001 (Only Numeric value)</small>
						</div>
						<?php
						$this->db->select('session,active');
						$this->db->from('accedemic_session');
						$querys = $this->db->get();
						$rowses = $querys->result_array();
						$vars = array();
						$stats = array();
         
						foreach($rowses as $seees)
						{
							$vars[] = $seees['session'];
							$stats[] = $seees['active'];                  
						}
						?>
           
						<input type="hidden" id="ac_sesss" value="<?php foreach($vars as $datass){echo $datass.' ';}?>">
						<input type="hidden" id="ac_statuss" value="<?php foreach($stats as $stat_datass){echo $stat_datass.' ';}?>">
					</div>
					<div class="row form-group">
						<label class="col-md-2">Start Date:</label>
						<div class="col-md-8" style='padding-bottom:1%'>
							<input type="date" id="astdate" name="astdate" class="form-control" value="2017-11-11" required>
						</div>
					</div> 
					<div class="row form-group">
						<label class="col-md-2">End Date:</label>
						<div class="col-md-8" style='padding-bottom:1%'>
							<input type="date" id="aendate" name="aendate" class="form-control" value="" required>
						</div>
					</div>
					<div class="row form-group">
						<label class="col-md-2">Status :</label>
						<div class="col-md-8" style='padding-bottom:1%'>
							<select class="form-control" id="astatuss" name="statuss">
								<option value="N">Inactive Session</option>
								<option value="Y">Active Session</option>
                                <!-- <option value="P">Previous Session</option> -->
								<option value="U">NewAdmission Session</option>
							</select>
						</div>
					</div>
				</div>

				<div class="modal-footer" id="modal-footer">
					<input type="hidden" value="<?php echo $sess->id;?>" id="s_id"> 
					<input type="hidden" value="<?php echo $sess->session; ?>" id="ssss"> 
					<a class="btn btn-success upd" onclick="update()">Update</a>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>  
			</form> 
		</div>
	</div>
</div>
<!-- END Update Modal-->


<div id="div_academic_session" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" id="modal_header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Add Academic Session</h4>
			</div>
			<form id="form_a" method="post">
				<div class="modal-body" id="modal-body">
					<div class="row form-group">
						<label class="col-md-2">Session :</label>
						<div class="col-md-8" style='padding-bottom:1%'>
							<input type="text" class="form-control sess" id="session" name="session" placeholder="0000-0000" required maxlength="9" />
							<small id="emailHelp" class="form-text text-muted">Ex: 2000-2001 (Only Numeric value)</small>
						</div>
						<?php
						$this->db->select('session,active');
						$this->db->from('accedemic_session');
						$this->db->where('status="Y"');
						$query = $this->db->get();
						$rowse = $query->result_array();
						$var = array();
						$stat = array();
					
						foreach($rowse as $seee) {
							$var[] = $seee['session'];
							$stat[] = $seee['active'];                          
						}
						?>
             
						<input type="hidden" id="ac_sess" value="<?php foreach($var as $datas){echo $datas.' ';}?>">
						<input type="hidden" id="ac_status" value="<?php foreach($stat as $stat_datas){echo $stat_datas.' ';}?>">
					</div>
        
					<div class="row form-group">
						<label class="col-md-2">Start Date:</label>
						<div class="col-md-8" style='padding-bottom:1%'>
							<input type="date" id="stdate" class="form-control" value="" required>
						</div>
					</div> 
					<div class="row form-group">
						<label class="col-md-2">End Date:</label>
						<div class="col-md-8" style='padding-bottom:1%'>
							<input type="date" id="endate" class="form-control" value="" required>
						</div>
					</div>

					<div class="row form-group">
						<label class="col-md-2">Status :</label>
						<div class="col-md-8" style='padding-bottom:1%'>
							<select class="form-control" id="astatus" name="status">
								<option value="N">Inactive Session</option>
								<option value="Y">Active Session</option>
						<!-- <option value="P">Previous Session</option> -->
								<option value="U">NewAdmission Session</option>
							</select>
						</div>
					</div>  
				</div>

				<div class="modal-footer" id="modal-footer">
					<a class="btn btn-success" onclick="save()">SAVE</a>
				</div>   
			</form>
		</div>
	</div>
</div>


<script>

//$('.sess').change(function(){
//  var value=$(this).val();
//  var year = value.split('-');
//  var startyr = year[0];
//  var endyr = year[1];
//
//  $('#stdate').attr('min',startyr+'-04-01');
//  $('#stdate').attr('max',startyr+'-12-30');
//
//});

$('#stdate').change(function(){
  var values=$(this).val();
//  var value=$('.sess').val();
//  var year = value.split('-');
//  var startyr = year[0];
//  var endyr = year[1];

  $('#endate').attr('min',values);
//  $('#endate').attr('max',endyr+'-04-01');

});

//$('.sessi').change(function(){
//  var value=$(this).val();
//  var year = value.split('-');
//  var startyr = year[0];
//  var endyr = year[1];
//
//  $('#astdate').attr('min',startyr+'-04-01');
//  $('#astdate').attr('max',startyr+'-12-30');
// 
//  
//});

$('#astdate').change(function(){
  var values=$(this).val();
//  var value=$('.sessi').val();
//  var year = value.split('-');
//  var startyr = year[0];
//  var endyr = year[1];

  $('#aendate').attr('min',values);
//  $('#aendate').attr('max',endyr+'-04-01');

});

function view_fees(id,stat,session,sdate,edate)
{

    var sessionid=id;
  
    $("#astatuss").find('option').attr("selected",false) ;
    $("#astatuss option[value="+stat+"]").attr('selected','selected').trigger('change');
    $('#sessi').val('');
    $('#sessi').val(session); 
    $('#astdate').val('');
    $('#astdate').val(sdate); 
    $('#aendate').val('');
    $('#aendate').val(edate);




    $('#ssss').val('');
    $('#ssss').val(session);
    $('.upd').attr('onclick',"update("+sessionid+")");
    $('.editmodal').modal('show');

}

//$('#session,'+'#sessi').keyup(function() {
//  if (/\D/g.test(this.value))
//  {
//    // Filter non-digits from input value.
//    this.value = this.value.replace(/\D/g, '');
//  }
//  var foo = $(this).val().split("-").join(""); // remove hyphens
//  if (foo.length > 0) {
//    foo = foo.match(new RegExp('.{1,4}', 'g')).join("-");
//  }
//  $(this).val(foo);
//});




function update(id){ 
if(!$('#form_e')[0].checkValidity()) {
    $(this).show();
    $('#form_e')[0].reportValidity();
    return false;
}
else
{
  var sessionval = $('#sessi').val();
  var sessvalue = $('#ssss').val();
  var astdate = $('#astdate').val();
  var aendate = $('#aendate').val();

  if(sessionval=='')
  {
    alert('Please Fill Academic Year!!');
  }
  else
  { 
    var stats = $('#astatuss').val();
    if(stats=='N')
    {
      var today = new Date();
      var stdate = $('#astdate').val();
      var endate = $('#aendate').val();

      var start = new Date(stdate); 
      var end = new Date(endate); 

      if(start<=today && end>=today)
      {
        alert('Sorry! You cant Deactivate it as it is a CURRENT SESSION YEAR');
      }

      else
      {
        var a_sesss = $('#ac_sesss').val();
        var numb = a_sesss.split(' ');

        if(sessvalue == sessionval)
        {
          var r = confirm("Are you sure you want to Update?");  
          if (r == true) 
          { 
            $.ajax({
              url: "<?php echo base_url('masters/Academic_sessions/update_session')?>",
              type: "POST",
              data: {session:sessionval,status:stats,id:id,astdate:astdate,aendate:aendate},
              success: function(data) {
                console.log(data);
                location.reload();
              },
            });
          }
        }  

        else if($.inArray(sessionval,numb) > -1)
        {
          alert('Academic Session is Already Available');
        }

        else
        {
          var r = confirm("Are you sure you want to Update?");  
          if (r == true) 
          { 

            $.ajax({
              url: "<?php echo base_url('masters/Academic_sessions/update_session')?>",
              type: "POST",
              data: {session:sessionval,status:stats,id:id,astdate:astdate,aendate:aendate},
              success: function(data) {
                console.log(data);
                location.reload();
              },
            });
          }
        }

      }
     
    }

    else
    {
      var stat = $('#ac_statuss').val();
        var statusval = stat.split(' ');
        if ( $.inArray(stats,statusval) > -1 )
        {
          alert('There is Already Active Academic session (!! One Time Only One Active Session');
        }

        else
        {

          var r = confirm("Are you sure you want to Update?");
          if (r == true) 
          {            
            $.ajax({
              url: "<?php echo base_url('masters/Academic_sessions/update_session')?>",
              type: "POST",
              data: {session:sessionval,status:stats,id:id,astdate:astdate,aendate:aendate},
              success: function(data) {
                console.log(data);
                location.reload();
              },
            });
          }
        }
      }
    
  }
  }
}

function save()
{
  if(!$('#form_a')[0].checkValidity()) {
      $(this).show();
      $('#form_a')[0].reportValidity();
      return false;
  }
  else
  {
  var sess = $('#session').val();
  if(sess=='')
  {
    alert('Please Fill Academic Year!!');
  }
  else
  {
    var stat = $('#astatus').val();
    if(stat=='N')
    {
      var ac_sess = $('#ac_sess').val();
      var stdate = $('#stdate').val();
      var endate = $('#endate').val();

      var numbers = ac_sess.split(' ');
      if ( $.inArray(sess,numbers) > -1 )
      {
        alert('Academic Session Year is Already Available');
      }
      else
      {
        var r = confirm("Are you sure you want to save?");  
        if (r == true) 
        {            
          $.ajax({
              url: "<?php echo base_url('masters/Academic_sessions/save_session')?>",
              type: "POST",
              data: {session:sess,status:stat,stdate:stdate,endate:endate},
              success: function(data) {
                console.log(data);
                location.reload();
              },
          });
         }
      }
    }
    else
    {
      var ac_status = $('#ac_status').val();
      var stdate = $('#stdate').val();
      var endate = $('#endate').val();

      var stat_data = ac_status.split(' ');
      if ( $.inArray(stat,stat_data) > -1 )
      {
        alert('There is Already Active Academic session (!! One Time Only One Active Session)');
      }
      else
      {
        var r = confirm("Are you sure you want to save?");
        if (r == true) 
        {            
          $.ajax({
            url: "<?php echo base_url('masters/Academic_sessions/save_session')?>",
            type: "POST",
            data: {session:sess,status:stat,stdate:stdate,endate:endate},
            success: function(data) {
              console.log(data);
              location.reload();
            },
          });
        }
      }
    }
  }
  }
}

//$(function() 
//{
//  $('#datalist').DataTable({
//   "paging": true,
//   "lengthChange": true,
//   "searching": true,
//   "ordering": true,
//   "info": true,
//   "autoWidth": true
//  });
//  
//});

function delet(id)
{
  var r = confirm("Are you sure you want to Delete?");
  if (r == true) 
  {            
    $.ajax({
      url: "<?php echo base_url('masters/Academic_sessions/delete_session')?>",
      type: "POST",
      data: {id:id},
      success: function(data) {
        console.log(data);
        
        location.reload();
      },
    });
  }
}

/*
$('#astatuss').on('change keyup',function(){
  var today = new Date();
  var stdate = $('#astdate').val();
  var endate = $('#aendate').val();

  var start = new Date(stdate); 
  var end = new Date(endate); 

  if(start<=today && end>=today)
  {
    alert('Greater');
  }

  else
  {
    alert('Smaller');
  }
  
});*/
</script>