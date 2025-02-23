<div class="form-group has-feedback">
  <div class="box">            
    <div class="box-body">
      <div class="col-lg-12">
        <div class="col-lg-12" style="text-align:right;"></div>
      </div>
    </div>
 
      
    <div class="box-body">
      <form>
        <div class="row">
        <div class="col-md-2 form-group">
          <label for="exampleFormControlSelect1">Examination Name</label>
          
          <select class="form-control" id="examname" onchange="showbutton();">
             <option value="">&nbsp;&nbsp;--Select Examination--&nbsp;&nbsp;</option>
            <?php
              foreach ($examination as $key => $exam_value) {
            ?>
              <option value="<?php echo $exam_value->id;?>"><?php echo $exam_value->name;?></option>
            <?php           
              }
            ?>
          </select>
        </div>

        <?php if(substr($right_access, 0,1)=='C') {?>    
        <div class="col-md-1 form-group" style="text-align: center" style="display:none">
            <label for="exampleFormControlSelect1">&nbsp;</label>
            <a title="ADD ROOMS" class="btn btn-add form-control" id="add_rooms" title="Add Rooms" data-toggle="modal" data-target="#add_exam_rooms" style="display:none;"> <i class="fa fa-plus-circle fa-lg"></i>  </a>
            <!--<button data-toggle="modal" data-target="#add_rooms" class="btn btn-add" id="add_rooms"> <i class="fa fa-plus-circle fa-lg"></i> </button>-->
        </div>
        <?php } ?>    
        <?php if(substr($right_access, 1,1)=='R') {?>    
        
            <?php }?>
            <div class="col-md-2 form-group">
                
            </div>
        </div>
      </form>
    </div>
  </div>

  <div class="box" id="viewdatabox">
    <div class="box-body" id="viewdata">
        <p>No data available in table</p>
    </div>
   
  </div>
  <style>
    table ,tr td{
      border:1px solid red
    }
    tbody {
      display:block;
      height:440px;
      overflow:auto;
    }
    thead, tbody tr {
      display:table;
      width:100%;
      table-layout:fixed;
    }
    thead {
      width: calc( 100% - 1em );
    }
    table {
      width:100%;
    }
  </style>
  <div class="box" id="adddatabox" style="display:none;">
    <form id="form_add" method="post">
      <div class="box-body" id="adddata">
         
      </div>
      <hr/>
      <div class="box-body" id="addbutton">
         <a class="btn btn-success pull-right" id="add">SUBMIT</a>
      </div>
    </form>
  </div>

  <div class="box" id="alreadydata" style="display:none;">
    <div class="box-body" id="adddata">
       <p>Room No. for this exam is already added!!</p>
       <p>Click on <a title="Click Here" class="btn btn-success" id="view_markss">View Rooms</a> To View its room details</p>
    </div>
  </div>
</div>

<?php if(substr($right_access, 2,1)=='U') {?>
<div id="EditModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Marks</h4>
      </div>
      <div class="modal-body">
        
        <div class="row form-group">
            <label class="col-md-2">Student Name :</label>
            <div class="col-md-8" style='padding-bottom:1%'>
              <input type="text" class="form-control" id="names" name="datefrom" placeholder="Name" disabled="" />        
            </div>                       
      </div>

      <div class="row form-group">
          <label class="col-md-2">Class No :</label>
          <div class="col-md-8" style='padding-bottom:1%'>
              <input type="text" class="form-control" id="classe" name="day" placeholder="Day" disabled="" />
              <input type="hidden" class="form-control" id="routinid" />
          </div>           
      </div> 


      <div class="row form-group">
          <label class="col-md-2">Section :</label>
          <div class="col-md-8" style='padding-bottom:1%'>
              <input type="text" class="form-control" id="sectione" name="day" placeholder="Day" disabled="" />
              <input type="hidden" class="form-control" id="routinid" />
          </div>           
      </div> 


      <div class="row form-group">
          <label class="col-md-2">Subject :</label>
          <div class="col-md-8" style='padding-bottom:1%'>
              <input type="text" class="form-control" id="subjecte" name="day" placeholder="Day" disabled="" />
              <input type="hidden" class="form-control" id="routinid" />
          </div>           
      </div> 

      <div class="row form-group">
          <label class="col-md-2">Marks Obtained :</label>
          <div class="col-md-8" style='padding-bottom:1%'>
              <input type="text" class="form-control" id="marksobt" name="day" placeholder="Marks Obtained"/>
          </div>   
                 
      </div> 

      </div>
      <div class="modal-footer">
        <input type="hidden" id="examid" value="">
        <input type="hidden" id="classid" value="">
        <input type="hidden" id="sectionid" value="">
        <input type="hidden" id="markid" value="">
        <input type="hidden" id="studentid" value="">
        <input type="hidden" id="subjectid" value="">

        <a class="btn btn-success update" onclick="update()">Update</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<?php }?>

<div id="add_exam_rooms" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" id="modal_header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Rooms</h4>
            </div>
            <form id="form_a" method="post">
                <div class="modal-body" id="modal-body">
                    <div class="row form-group">
                        <label class="col-md-2">Room No. :</label>
                        <div class="col-md-8" style='padding-bottom:1%'>
                            <input type="text" id="room_no" name="room_no" class="form-control" value="" required>
                        </div>
                    </div> 
                    <div class="row form-group">
                        <label class="col-md-2">No. of Seats:</label>
                        <div class="col-md-8" style='padding-bottom:1%'>
                            <input type="number" id="seats" class="form-control" name="seats" value="" required>
                        </div>
                    </div>
                     <div class="row form-group">
                          <label class="col-md-2">Invigilator 1:</label>
                          <div class="col-md-8" style='padding-bottom:1%'>
                            <select class="form-control" id="invigilator_1" name="invigilator_1" required>
                                 <?php
                                    foreach ($teacher as $key => $teach) {
                                  ?>
                                    <option value="<?php echo $teach->id;?>"><?php echo $teach->name;?></option>
                                  <?php           
                                    }
                                  ?>
                            </select>
                        </div>
                     </div>  
                    <div class="row form-group">
                          <label class="col-md-2">Invigilator 2:</label>
                          <div class="col-md-8" style='padding-bottom:1%'>
                            <select class="form-control" id="invigilator_2" name="invigilator_2">
                                 <?php
                                    foreach ($teacher as $key => $teach) {
                                  ?>
                                    <option value="<?php echo $teach->id;?>"><?php echo $teach->name;?></option>
                                  <?php           
                                    }
                                  ?>
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



<div id="allocate_exam_room" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" id="modal_header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Allocate Rooms</h4>
            </div>
            <form id="form_allocate" method="post">
                <div class="modal-body" id="modal-body">
                    <div class="row form-group">
                        <label class="col-md-2">Room No. :</label>
                        <div class="col-md-8" style='padding-bottom:1%'>
                            <input type="text" id="room_no_alloc" name="room_no_alloc" class="form-control" value="" disabled>
                        </div>
                    </div> 
                    <div class="row form-group">
                        <label class="col-md-2">No. of Seats:</label>
                        <div class="col-md-8" style='padding-bottom:1%'>
                            <input type="number" id="seats_alloc" class="form-control" name="seats_alloc" value="" disabled>
                        </div>
                    </div>
                     <div class="row form-group">
                          <label class="col-md-2">Class:</label>
                          <div class="col-md-8" style='padding-bottom:1%'>
                            <select class="form-control" id="class" name="class" required>
                                 <?php
                                    foreach ($class as $key => $cls) {
                                  ?>
                                    <option value="<?php echo $cls->id;?>"><?php echo $cls->class_name;?></option>
                                  <?php           
                                    }
                                  ?>
                            </select>
                        </div>
                     </div>  
                    <div class="row form-group">
                          <label class="col-md-2">Section:</label>
                          <div class="col-md-8" style='padding-bottom:1%'>
                            <select class="form-control" id="section" name="section">
                               
                            </select>
                        </div>
                     </div>  
                    <div class="row form-group">
                          <label class="col-md-2">From Roll:</label>
                          <div class="col-md-8" style='padding-bottom:1%'>
                            <select class="form-control" id="invigilator_2" name="invigilator_2">
                                 <?php
                                    foreach ($teacher as $key => $teach) {
                                  ?>
                                    <option value="<?php echo $teach->id;?>"><?php echo $teach->name;?></option>
                                  <?php           
                                    }
                                  ?>
                            </select>
                        </div>
                     </div>  
                    <div class="row form-group">
                          <label class="col-md-2">To Roll:</label>
                          <div class="col-md-8" style='padding-bottom:1%'>
                            <select class="form-control" id="invigilator_2" name="invigilator_2">
                                 <?php
                                    foreach ($teacher as $key => $teach) {
                                  ?>
                                    <option value="<?php echo $teach->id;?>"><?php echo $teach->name;?></option>
                                  <?php           
                                    }
                                  ?>
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

<form name="form-any" method="post" action="" id="form-any" style="display:none">
    <input type="hidden" name="formdata" id="formdata" value="">
</form> 
<script>

function showbutton(){
    $('#add_rooms').show();
    
}
function update()
{
  
  var examid = $('#examid').val();
  var classid = $('#classid').val();
  var sectionid = $('#sectionid').val();
  var markid = $('#markid').val();
  var studentid = $('#studentid').val();
  var marksobt = $('#marksobt').val();
  var subjectid = $('#subjectid').val();
  
  if(markid==0)
  {
    $('#EditModal').modal('hide');
    $.ajax({
      url   : "<?php echo site_url('academics/Marks/GetTotalMark')?>",
      type  : "POST",
      data  : {id:examid,classid:classid,studentid:studentid,marksobt:marksobt,subjectid:subjectid},
      success: function(data)
      {    
        var exam = $('#examname').find('option:selected').val();
        
        $.ajax({
              url : "<?php echo site_url('academics/Marks/GetData')?>",
              type: "POST",
              data: {exam:exam,clas:clas,sect:sect,subj:subj},
              success: function(data)
              {    
                $('#viewdata').html(data);
                $('#templatelistss').DataTable({
                 "paging": true,
                 "lengthChange": true,
                 "searching": true,
                 "ordering": true,
                 "info": true,
                 "autoWidth": true
                });

              },        
          });
      },        
    });  
  }
  else
  {
     $('#EditModal').modal('hide');
      $.ajax({
        url : "<?php echo site_url('academics/Marks/UpdateMarks')?>",
        type: "POST",
        data: {id:markid,marks:marksobt},
        success: function(data)
        { 

          var exam = $('#examname').find('option:selected').val();
          var clas = $('#class').find('option:selected').val();
          var sect = $('#section').find('option:selected').val();
          var subj = $('#subject').find('option:selected').val();
          
          $.ajax({
                url : "<?php echo site_url('academics/Marks/GetData')?>",
                type: "POST",
                data: {exam:exam,clas:clas,sect:sect,subj:subj},
                success: function(data)
                {    
                  $('#viewdata').html(data);
                  $('#templatelistss').DataTable({
                   "paging": true,
                   "lengthChange": true,
                   "searching": true,
                   "ordering": true,
                   "info": true,
                   "autoWidth": true
                  });

                },        
            });
        },        
    });
  }

}

function editmarks(exam,a,b)
{
//  $('#names').val(fname);
//  $('#classe').val(clsname);
//  $('#sectione').val(secname);
//  $('#subjecte').val(subjectname);
//  $('#marksobt').val(marksobt);

  $('#examid').val(exam);
  $('#room_no_alloc').val(a);
  $('#seats_alloc').val(b);
//  $('#markid').val(markid);
//  $('#studentid').val(stid);
//  $('#subjectid').val(subj);

$.post('<?php echo base_url('academics/Exam_rooms/editRoomAlloc'); ?>', {exam: exam,a:a,b:b}, function (data) {
//                alert('Data Deleted Successfully');
//                location.reload();
            }); 
            
//  $('#allocate_exam_room').modal('show'); 
}


$('#add').on('click',function(){
  if(!$('#form_add')[0].checkValidity()) {
    $(this).show();
    $('#form_add')[0].reportValidity();
    return false;
  }
  else
  {  
    var exam = $('#examname').find('option:selected').val();
    var clas = $('#class').find('option:selected').val();
    var sect = $('#section').find('option:selected').val();
    var subj = $('#subject').find('option:selected').val(); 
    
    $.ajax({
      url : "<?php echo site_url('academics/Marks/GetGrandTotalMark')?>",
      type: "POST",
      data: {id:exam},
      success: function(data)
      {         
        
        var i=0;
        $('form input[name=user_input]').each(function(){
          i++;
          
          var student_id = $('#stid_'+i).val();
          var subject_id = subj;
          var class_id = clas;
          var exam_id = exam;
          var mark_obtained = $(this).val();
          var totalmark = data;
           $.ajax({
              url : "<?php echo site_url('academics/Marks/AddMark')?>",
              type: "POST",
              data: {student_id:student_id,subject_id:subject_id,class_id:class_id,exam_id:exam_id,mark_obtained:mark_obtained,mark_total:totalmark},
              success: function(data)
              { 
                location.reload()
              },        
          });
        });

        alert('Marks Successfully Added');
      },        
    });
  }
});

$('#class').on('click change keyup',function(){
    var value = $(this).val();
    $.ajax({
        url : "<?php echo site_url('academics/Exam_rooms/getclasssection')?>",
        type: "POST",
        data: {id:value},
        success: function(data)
        {         
          $("#section").html(data);
//          $('#section').empty();
//          $("#section").append(data);
        },        
    });
});


$('#class,'+'#section').on('change click keyup',function(){
  var clas = $('#class').find('option:selected').val();
  var sect = $('#section').val();
//alert(sect);
   $.ajax({
        url : "<?php echo site_url('academics/Marks/GetSubjects')?>",
        type: "POST",
        data: {clasid:clas,sect:sect},
        success: function(data)
        { 

          $('#subject').empty();
          $("#subject").append(data);
        },        
    });

});

$('#view_marks,'+'#view_markss').on('click',function(){
  $('#alreadydata').hide();
  $('#adddatabox').hide();
  $('#viewdatabox').show();
  var exam = $('#examname').find('option:selected').val();
//  var clas = $('#class').find('option:selected').val();
//  var sect = $('#section').find('option:selected').val();
//  var subj = $('#subject').find('option:selected').val();
  
  $.ajax({
        url : "<?php echo site_url('academics/Exam_rooms/GetData')?>",
        type: "POST",
        data: {exam:exam},
        success: function(data)
        {    
          $('#viewdata').html(data);
          $('#templatelistss').DataTable({
           "paging": true,
           "lengthChange": true,
           "searching": true,
           "ordering": true,
           "info": true,
           "autoWidth": true
          });
        },        
    });
});

$('#section').on('click change',function(){
  var val = $(this).val();
  if(val=='')
  {
    alert('Please Select Class First');
  }
});


$('#examname').on('change',function(){
     $('#alreadydata').hide();
  $('#adddatabox').hide();
  $('#viewdatabox').show();
  var exam = $('#examname').find('option:selected').val();
//  var clas = $('#class').find('option:selected').val();
//  var sect = $('#section').find('option:selected').val();
//  var subj = $('#subject').find('option:selected').val();
  
  $.ajax({
        url : "<?php echo site_url('academics/Exam_rooms/GetData')?>",
        type: "POST",
        data: {exam:exam},
        success: function(data)
        {    
          $('#viewdata').html(data);
          $('#templatelistss').DataTable({
           "paging": true,
           "lengthChange": true,
           "searching": true,
           "ordering": true,
           "info": true,
           "autoWidth": true
          });
        },        
    });
    })

$('#examnamee').on('change',function(){
  $('#alreadydata').hide();
  $('#viewdatabox').hide();
  $('#adddatabox').show();
  
  var exam = $('#examname').find('option:selected').val();

  $.ajax({
        url : "<?php echo site_url('academics/Exam_rooms/Get')?>",
        type: "POST",
        data: {exam:exam},
        success: function(data)
        {    
          var ddd = data;
         if(ddd>0)
         {
            $('#adddatabox').hide();
            $('#view_marks').attr('disabled',false);
            $('#alreadydata').show();  

         }
         else
         {
            $('#view_marks').attr('disabled',true);
            $.ajax({
                url : "<?php echo site_url('academics/Exam_rooms/GetAddData')?>",
                type: "POST",
                data: {exam:exam},
                success: function(data)
                {    
                  $('#adddata').html(data);
                },        
            });
         }
        
        },        
    });
})


 function save()
    {
        if (!$('#form_a')[0].checkValidity()) {
            $(this).show();
            $('#form_a')[0].reportValidity();
            return false;
        } else
        {
            var room_no = $('#room_no').val();
            if (room_no == '')
            {
                alert('Please Fill Room No.!!');
            } else
            {
                    var room_no = $('#room_no').val();
                    var seats = $('#seats').val();
                    var invigilator_1 = $('#invigilator_1').val();
                    var invigilator_2 = $('#invigilator_2').val();
                    var exam = $('#examname').find('option:selected').val();
                        var r = confirm("Are you sure you want to save?");
                        if (r == true)
                        {
                            $.ajax({
                                url: "<?php echo base_url('academics/Exam_rooms/save_rooms') ?>",
                                type: "POST",
                                data: {room_no: room_no, seats: seats,invigilator_1:invigilator_1,invigilator_2:invigilator_2,exam:exam},
                                success: function (data) {
                                    console.log(data);
                                    location.reload();
                                    alert("Room added successfully");
                                },
                            });
                        }
                    }
            }
        }
        
        
        function updateaddroomalloc(me)
    {
        var idmain = me.id;
//        alert(idmain);
        document.getElementById('form-any').action = '<?php echo site_url('academics/Exam_rooms/editRoomAlloc') ?>';
        $('#formdata').val(idmain);
        document.getElementById('form-any').submit();

    }
    

</script>