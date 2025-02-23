<style>
.modal-dialog {
  position: absolute;
  top: 40%;
  left: 50%;
  transform: translate(-50%, -50%) !important;
}
.modal-header .close {
    margin-top: -27px!important;
}
input[type="date"].form-control
{
  line-height: 17px;
}
</style>
<div class="box-body">
	<div class="tab-content">
		<div class="tab-pane fade in active" id="stud_attend">
			<div class="row">
				<form id="attendance" name="attendance" method="POST">
					<div class="col-md-12" style="padding-left:25px; padding-right:25px;">
						<div class="panel panel-default">
							<div class="heading">
								<h4 class="" style="color:teal; padding-left:20px; padding-top:10px;"> Attendance </h4></div>

               <hr>
               <div class="panel-body">
                <div class="col-sm-1 form-group">
                 <label for="">Class</label>
               </div>
               <div class="col-sm-3 form-group">
                
               <?php if($this->session->userdata('user_group_id')==8){ ?>
                <select class="form-control" id="cls" name="cls"> <option value="0">Select Class </option>
                  <?php foreach($class_data as $cls){ ?>
                   <option value="<?php echo $cls->class_id; ?>"> <?php echo $cls->class_name; ?></option>
                 <?php }  ?>
               </select>
               <?php } else { ?>
                 <select class="form-control" id="cls" name="cls"> <option value="0">Select Class </option>
                  <?php foreach($class as $cls){ ?>
                   <option value="<?php echo $cls->id; ?>"> <?php echo $cls->class_name; ?></option>
                 <?php }  ?>
               </select>
              <?php } ?>
             </div>
             <div class="col-sm-1 form-group">
               <label for="">Section</label>
             </div>
             <div class="col-sm-3 form-group">
              <?php if($this->session->userdata('user_group_id')==8){ ?>
                <select class="form-control" id="sec" name="sec"> <option value="0">Select Section </option>
                  <?php foreach($class_data as $cls){ ?>
                   <option value="<?php echo $cls->section_id; ?>"> <?php echo $cls->sec_name; ?></option>
                 <?php }  ?>
               </select>
               <?php } else { ?>
               <select class="form-control" id="sec" name="sec"> <option value="0">Select Section </option>
                <?php foreach($classsection as $sec){ ?>
                 <option value="<?php echo $sec->id; ?>"> <?php echo $sec->sec_name; ?></option>
               <?php }  ?>
             </select>
           <?php } ?>
           </div>
           <div class="col-sm-1 form-group">
             <label for="">Date</label>
           </div>
           <div class='col-sm-3 input-group date' id='datetimepicker1'>
             <input type='date' class="form-control" id="attendance_date" name="attendance_date" value="<?php echo date("Y-m-d"); ?>" max="<?php echo date("Y-m-d"); ?>">
           </div>
         </div>
         <div class="row">
          <div class="" style="float:right; padding-right:20px; margin-bottom:20px;">
           <span><input type="button" class="btn btn-success" value="Capture Attendance" id="manage_attendance">  </span>
           <span><input type="button" class="btn btn-info" value="Edit/View Attendance" id="view_attendance"></span>
           <a href="<?php echo base_url('attendance/student_attendance/register_stu');?>" class="btn btn-warning">Monthly Attendance </a>
           <?php if(($school_data[0]->sms_integration=='YES') && ($sms_set[0]->sms=='YES') && ($sms_set[0]->sms_mode=='AUTO')){ ?>   
           <a  class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">Send SMS</a>
         <?php } ?>
         </div>
       </div>
     </div>
   </div>


   <div class="col-md-12" style="padding-left:25px; padding-right:25px;">
    <div class="panel panel-default">
     <div class="heading">
      <h4 class="" style="color:teal; padding-left:20px; padding-top:10px;">Mark Attendance </h4>
      <hr>
      <div class="panel-body" id="div_upload_student">
       <table id="student_att" class="table table-bordered table-stripped">
        <thead>
         <tr>
          <th> Sl.No</th>
          <th> Admission No</th>
          <th> Student Name</th>
          <th> Attendance</th>
          <!-- <th>Periods</th> -->
          <th> Remarks</th>
        </tr>
      </thead>
    </table> 
  </div>
</div>
</div>
						<!-- <div class="col-lg-12"  style="text-align: center;">
							<input type="button" class="btn btn-success" id="save_attendance" value="Save Attendance"> 
							<input type="button" class="btn btn-success" id="update_attendance" value="Update Attendance"> 
						</div> -->


            <div class="col-lg-12"  style="text-align: center;">
              <?php if(($school_data[0]->sms_integration=='YES') && ($sms_set[0]->sms=='YES') && ($sms_set[0]->sms_mode=='AUTO')){ ?>       
                <input type="button" class="btn btn-success" id="save_attendance_sms" value="Save Attendance & Send SMS"> 
              <?php } else { ?>
                <input type="button" class="btn btn-success" id="save_attendance" value="Save Attendance"> 
              <?php } ?>
              <input type="button" class="btn btn-success" id="update_attendance" value="Update Attendance"> 
            </div>
          </div>
        </div>
      </form> 
    </div>
  </div>
</div> 
</div> 

<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Send SMS</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="manual_sms_form">
      <div class="modal-body">
        <div class="panel-body">
          <div class="row">
          <div class="col-sm-1 form-group">
            <label for="">Class</label>
          </div>
          <div class="col-sm-3 form-group">
            <select class="form-control" id="sms_class" name="sms_class"> <option value="0">Select Class </option>
              <?php foreach($class as $cls){ ?>
                <option value="<?php echo $cls->id; ?>"> <?php echo $cls->class_name; ?></option>
              <?php }  ?>
            </select>
          </div>
          <div class="col-sm-1 form-group">
            <label for="">Section</label>
          </div>
          <div class="col-sm-3 form-group">
            <select class="form-control" id="sms_section" name="sms_section"> <option value="0">Select Section </option>
              <?php foreach($classsection as $sec){ ?>
                <option value="<?php echo $sec->id; ?>"> <?php echo $sec->sec_name; ?></option>
              <?php }  ?>
            </select>
          </div>
          <div class="col-sm-1 form-group">
            <label for="">Date</label>
          </div>
          <div class='col-sm-3 input-group date'>
            <input type='date' class="form-control" id="date_sms" name="date_sms" value="<?php echo date("Y-m-d"); ?>" max="<?php echo date("Y-m-d"); ?>">
          </div>
          </div>
          <div class="row">
           <div class="col-sm-1 form-group">
            <label for="">Send To</label>
          </div>
          <div class="col-sm-3 form-group">
            <select class="form-control" id="send_to" name="send_to">
              <option value="">Select</option>
              <option value="ALL_STUDENT">All Students</option>
              <option value="ALL_PRESENT">All Present</option>
              <option value="ALL_ABSENT">All Absent</option>
            </select>
          </div>
          <div class="col-sm-1 form-group">
            <label for="">Message</label>
          </div>
          <div class="col-sm-5 form-group">
            <textarea class="form-control" rows="3" cols="10" id="message" name="message"></textarea>
            <span id="remaining">160 characters remaining</span>
            <span id="messageses">1 message(s)</span>
          </div>
        </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="Send_Sms_Manual">Send</button>
      </div>
    </form>
    </div>
  </div>
</div>

<script>

$(document).ready(function(){
    var $remaining = $('#remaining'),
        $messageses = $remaining.next();

    $('#message').keyup(function(){
        var chars = this.value.length,
            messageses = Math.ceil(chars / 160),
            remaining = messageses * 160 - (chars % (messageses * 160) || messageses * 160);

        $remaining.text(remaining + ' characters remaining');
        $messageses.text(messageses + ' message(s)');
    });
});


  $('#update_attendance').hide();
  $(document).ready(function()
  {

    $('#manage_attendance').click(function()
    {
      var task='add';
      fetch(task);

    });

    $('#view_attendance').click(function()
    {
      var task='edit';
      fetch(task);

    });

    function fetch(task)
    {
//            alert(task);

var cls=$('#cls').val();
var sec=$('#sec').val();
var date=$('#attendance_date').val();

if ($('#cls').val()==0 || $('#sec').val()==0 || !Date.parse(date))
{
  alert('Please select Class and Section and Date'); 
}
else if(task=='add')
{
 $('#update_attendance').hide();
 $('#save_attendance').show();
 $.ajax({
  type:'POST',
  data:
  {
    class:cls,
    section:sec,
    date:date,
  },
  url:'<?php echo base_url('attendance/student_attendance/validate_attendance');?>',
  datatype:'text',
  success:function(data)
  { 
    if(data==1)
    {
      alert('Attendance already captured for selected class and section');
      $('#save_attendance').attr('disabled',true);
      $('#div_upload_student').html('');
    }

    else
    {

     $('#save_attendance').attr('disabled',false); 
     $.ajax({ 
      type:'POST',
      url:'<?php echo base_url('attendance/student_attendance/load_student');?>',
      data:
      {
        task:task,
        class:cls,
        section:sec,
        date:date,
      },
      datatype:'text',
      success:function(data)
      {
        $('#div_upload_student').html(data);
      },
      error:function(req,status)
      {
        alert('error while loading');
      },

    });

   }
 },
 error:function(req,status)
 {
  alert('error');
},

});
}

else
{

 $('#update_attendance').show();
 $('#save_attendance').hide();


 $.ajax({ 
  type:'POST',
  url:'<?php echo base_url('attendance/student_attendance/load_student');?>',
  data:
  {
    task:task,
    class:cls,
    section:sec,
    date:date,
  },
  datatype:'text',
  success:function(data)
  {
    $('#div_upload_student').html(data);
  },
  error:function(req,status)
  {
    alert('error while loading');
  },

});
}
}

$('#save_attendance').click(function()
{
  if ($('#cls').val()==0 || $('#sec').val()==0 || $('#attendance_date')=='')
  {
    alert('Please select Class and Section and Date'); 
  }
  else
  {
   $.ajax({
    type:'POST',
    url:"<?php echo base_url('attendance/student_attendance/save_stud_attendance');?>",
    data:$('#attendance').serialize(),
    datatype:'text',
    success:function(data)
    {
                        alert('Attendance saved successfully');
                        window.location.reload();
                      },
                      error:function(req,status)
                      {
                        alert('error while saving');
                      }
                    });
 }
});

$('#save_attendance_sms').click(function()
{
  if ($('#cls').val()==0 || $('#sec').val()==0 || $('#attendance_date')=='')
  {
    alert('Please select Class and Section and Date'); 
  }
  else
  {
    $.ajax({
        type:'POST',
        url:"<?php echo base_url('attendance/student_attendance/save_stud_attendance_sms');?>",
        data:$('#attendance').serialize(),
        datatype:'text',
        success:function(data)
        {
          alert('Attendance saved successfully');
          window.location.reload();
        },
        error:function(req,status)
        {
          alert('error while saving');
        }
    });
 }
});


$('#Send_Sms_Manual').click(function()
{
  if ($('#sms_class').val()==0 || $('#sms_section').val()==0 || $('#date_sms')=='')
  {
    alert('Please select Class and Section and Date'); 
  }
  else
  {
   $.ajax({
    type:'POST',
    url:"<?php echo base_url('attendance/student_attendance/send_atten_sms_manual');?>",
    data:$('#manual_sms_form').serialize(),
    datatype:'text',
    success:function(data)
    {
      
      if(data==1)
      {
        alert('Please capture Attendance');
        window.location.assign('https://erp.feesclub.com/attendance/Student_attendance');
      }else {
        alert('SMS Send successfully');
        window.location.reload();
      }
      // console.log(data);
      // alert('SMS Send successfully');
      // window.location.reload();
    },
    error:function(req,status)
    {
      alert('error while saving');
    }
  });
 }
});

$('#update_attendance').click(function()
{
  $.ajax({
    type:'POST',
    url:"<?php echo base_url('attendance/student_attendance/update_stud_attendance');?>",
    data:$('#attendance').serialize(),
    datatype:'text',
    success:function(data)
    {
      alert('Attendance updated successfully');
      window.location.reload();
    },
    error:function(req,status)
    {
      alert('error while updating');
    }
  });

});


});



</script>









