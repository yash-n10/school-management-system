<div class="form-group has-feedback">
  <div class="box">            
    <div class="box-body">
      <div class="col-lg-12">
        <div class="col-lg-12" style="text-align:right;"><button data-toggle="modal" data-target="#div_subs_teacher" class="btn btn-add" id="add_session" title="Add Substitute Teacher"> <i class="fa fa-plus-circle fa-lg"></i> </button></div>
      </div>
    </div>

    <div class="box-body">
        <div class="table-responsive">
      <table id="templatelist" class="table table-bordered table-striped">
        <thead style="background:#99ceff;">
          <tr>
            <th style="border-bottom:0px">Assigned Date</th>
            <th style="border-bottom:0px">Class</th>
            <th style="border-bottom:0px">Section</th>
            <th style="border-bottom:0px">Subject</th>
            <th style="border-bottom:0px">Timing</th>
            <th style="border-bottom:0px">Assigned Teacher</th>
            <th style="border-bottom:0px">Remarks</th>
            <th style="border-bottom:0px">Action</th>
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
                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="4"/>
                </th>
                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="5"/>
                </th>
                <th style="border-bottom:2px solid darkcyan;border-top:0px">
                    <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="6"/>
                </th>
                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
            </tr>
        </thead>
        <tbody>
          <?php foreach($assignteacher as $data){

            ?>
            <tr>
              <td><?php echo $data['date'];?></td>
              <td><?php echo $data['class_name'];?></td>
              <td><?php echo $data['sec_name'];?></td>
              <td><?php echo $data['subject'];?></td>
              <td><?php if($data['pid']){?>
                <?php echo $data['tstart'];?>:<?php echo $data['tstart_min'];?> &nbsp; - &nbsp; <?php echo $data['tend'];?>:<?php echo $data['tend_min'];?>
                 <?php  }else{?>
                <?php echo 'N/A'; }?>

                </td>
              
              <td><?php echo $data['name'];?></td>
              <td><?php echo $data['remarks'];?></td>
              <td>             
                <?php $date =  $data['date']; $assigndate =date('Y-m-d',strtotime($date));?>
                <span><a class="btn a-edit" id="<?php echo $data['idss']; ?>" onclick="edit(<?php echo $data['idss']; ?>,'<?php echo $assigndate;?>','<?php echo $data['day'];?>',<?php echo $data['class_id']; ?>,<?php echo $data['section_id']; ?>,<?php echo $data['subject_id'];?>,<?php echo $data['teacher_id']; ?>,<?php echo $data['id']; ?>,'<?php echo trim($data['remarks']);?>')"><i class="fa fa-edit"></i> </a></span>
                <span><a class="btn a-delete" id="<?php echo $data['id']; ?>" onclick="delet(<?php echo $data['id']; ?>)"><i class="fa fa-trash"></i> </a></span>
              </td>
            </tr>
          <?php }?>
        </tbody>
      </table>
    </div>
    </div>
  </div>
</div>


<div id="div_subs_teacher" class="modal fade" role="dialog">
  <form id="form_add" class="form-horizontal" method="post">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title">Add Substitute Teacher</h3>
        </div>  
        <div class="modal-body">          
          <div class="form-group">
              <label class="control-label col-md-2">Date :</label>
              <div class="col-md-8" style='padding-bottom:1%'>
                  <input type="date" class="form-control" id="date" name="datefrom" placeholder="From(YYYY-MM-DD)" required/>
              </div>                        
          </div>
          
          <div class=" form-group">
              <label class="control-label col-md-2">Day :</label>
              <div class="col-md-8" style='padding-bottom:1%'>
                  <input type="text" class="form-control" id="day" name="day" placeholder="Day" disabled="" />
              </div>           
          </div> 
          
          <div class=" form-group">
            <label class="control-label col-md-2">Class :</label>
            <div class="col-md-8" style='padding-bottom:1%'>
                <select class="form-control" id="classselect">
                   <option value="">&nbsp;&nbsp;-- Select Class--&nbsp;&nbsp;</option>
                    <?php 
                      foreach ($classes as $key => $value) 
                      {
                    ?>
                         <option value="<?php echo $value->id;?>"><?php echo $value->class_name;?></option>
                    <?php
                      }
                    ?>               
                </select>
            </div>           
          </div>

          <div class=" form-group">
            <label class="control-label col-md-2">Section :</label>
            <div class="col-md-8" style='padding-bottom:1%'>
              <select class="form-control" id="sectionselect" disabled="">
                <option value="">&nbsp;&nbsp;-- Select Section--&nbsp;&nbsp;</option>
              </select>
            </div>           
          </div>

          <div class=" form-group">
            <label class="control-label col-md-2">Subject :</label>
            <div class="col-md-8" style='padding-bottom:1%'>
              <select name="subject_add" class="form-control" id="subj" required>
              </select>
            </div>           
          </div> 
         
          <div class=" form-group">
            <label class="control-label col-md-2">Teacher :</label>
            <div class="col-md-8" style='padding-bottom:1%'>
              <select name="teacher_add" class="form-control" id="teacher" required>
                <option value="">&nbsp;&nbsp;-- Select Teacher--&nbsp;&nbsp;</option>
                <?php 
                  foreach($teacher as $tdata)
                  {
                    $tid    =   $tdata->id; 
                    $tname  =   $tdata->name;
                ?>
                <option value="<?php echo $tid;?>"><?php echo $tname;?></option>
                <?php 
                  }
                ?>
              </select>
            </div>           
          </div>

          <div class=" form-group">
            <label class="control-label col-md-2">Remarks :</label>
            <div class="col-md-8" style='padding-bottom:1%'>
               <textarea class="form-control" id="remarks" rows="3"></textarea>
            </div>   
          </div>

        </div>
        <div class="modal-footer">
          <a class="btn btn-success" onclick="save()">SAVE</a>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </form>
</div>

<!-- Edit Modal-->

<div id="edit_subs_teacher" class="modal fade" role="dialog">
 <form id="form_class_add" class="form-horizontal" method="post">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      
      <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title">Edit Substitute Teacher</h3>
      </div>  
      <div class="modal-body" id="editdata">
       
        <div class=" form-group">
            <label class="control-label col-md-2">Date :</label>
            <div class="col-md-8" style='padding-bottom:1%'>
              <!--   <input type="date" class="form-control" id="date" name="datefrom" placeholder="From(YYYY-MM-DD)"/> -->
              <input type="date" name="date" id="dates" value="" style="display: block;width: 100%;height: 34px;padding: 6px 12px;font-size: 14px;line-height: 1.42857143;color: #555;background-color: #fff;background-image: none;border: 1px solid #ccc;"/>
            </div>   
                     
        </div>
         <div class=" form-group">
            <label class="control-label col-md-2">Day :</label>
            <div class="col-md-8" style='padding-bottom:1%'>
                <input type="text" class="form-control" id="daye" name="day" placeholder="Day" disabled="" />
                <input type="hidden" class="form-control" id="routinid" />
            </div>           
        </div> 
        <div class=" form-group">
            <label class="control-label col-md-2">Class :</label>
            <div class="col-md-8" style='padding-bottom:1%'>
               <select name="class" class="form-control" id="classselecte">
                   
                    <?php 
                      foreach ($classes as $key => $value) 
                      {
                    ?>
                      <option value="<?php echo $value->id;?>"><?php echo $value->class_name;?></option>
                    <?php
                      }
                    ?>               
                </select>
            </div>           
        </div>
        <div class=" form-group">
            <label class="control-label col-md-2">Section :</label>
            <div class="col-md-8" style='padding-bottom:1%'>
              <select name="section" class="form-control" id="sectionselecte">
                
              </select>
            </div>           
        </div>
        <div class=" form-group">
            <label class="control-label col-md-2">Subject :</label>
            <div class="col-md-8" style='padding-bottom:1%'>
              <select name="subject" class="form-control" id="subje">
               
              </select>
            </div>           
        </div> 
       
        <div class=" form-group">
            <label class="control-label col-md-2">Teacher :</label>
            <div class="col-md-8" style='padding-bottom:1%'>
               <select name="teacher" class="form-control" id="teachere">
                <option value="">&nbsp;&nbsp;-- Select Teacher--&nbsp;&nbsp;</option>
                <?php 
                  foreach($teacher as $tdata)
                    {
                      $tid    =   $tdata->id; 
                      $tname  =   $tdata->name;
                ?>
                   <option value="<?php echo $tid;?>"><?php echo $tname;?></option>
                <?php 
                    }
                 ?>
                 </select>
            </div>           
        </div>
        <div class=" form-group">
            <label class="control-label col-md-2">Remarks :</label>
            <div class="col-md-8" style='padding-bottom:1%'>
               <textarea class="form-control" name="remarks" id="remarkse" rows="3"></textarea>
            </div>   
        </div>
   
      </div>
      <div class="modal-footer">
         <a class="btn btn-success update" onclick="update()">Update</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
  </form>
</div>

<!--End Edit Modal-->

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
//            if ( this.search() !== this.value ) {
//                this
//                    .search( this.value )
//                    .draw();
//            }
            var i = $(this).attr('data-column');
            var v = $(this).val();
            table.columns(i).search(v).draw();
        });
  
});


$('#classselect').on('change',function(){ 
    var value = $(this).val();
    var day = $('#day').val();
    var set = $('#sectionselect').val();
    if(set=='')
    {
      var sect = '1';
    }
    else
    {
      var sect = $('#sectionselect').val();
    }

    $.ajax({
        url : "<?php echo site_url('academics/substitute_teacher/GetSection')?>",
        type: "POST",
        data: {id:value},
        success: function(data)
        {
          $('#sectionselect').attr('disabled',false);
          $('#sectionselect').empty();
          $("#sectionselect").append(data);
        },
        
    });

    $.ajax({
        url : "<?php echo site_url('academics/substitute_teacher/GetSubject')?>",
        type: "POST",
        data: {cid:value,sid:sect,day:day},
        success: function(data)
        {
          console.log(data);
          $('#subj').empty();
          $("#subj").append(data);
        },
        
  });

});

$('#classselecte').on('change',function(){ 
    var value = $(this).val();
    $.ajax({
        url : "<?php echo site_url('academics/substitute_teacher/GetSection')?>",
        type: "POST",
        data: {id:value},
        success: function(data)
        {         
          $('#sectionselecte').empty();
          $("#sectionselecte").append(data);
        },        
    });
});

$('#date').on('change',function(){
  var date = $('#date').val();
  var weekday = ["sunday","monday","tuesday","wednesday","thursday","friday","saturday"];
  var a = new Date(date);
  var day = weekday[a.getDay()];
  $('#day').val(day);
})


$('#sectionselect,'+'#classselect').on('change',function() {

  var clas = $('#classselect').find('option:selected').val();
  var set = $('#sectionselect').find('option:selected').val();

    if(set=='')
    {
      var sect = '1';
    }
    else
    {
      var sect = $('#sectionselect').val();
    }
  var day = $('#day').val();
  $.ajax({
      url : "<?php echo site_url('academics/substitute_teacher/GetSubject')?>",
      type: "POST",
      data: {cid:clas,sid:sect,day:day},
      success: function(data)
      {
        //console.log(data);
        $('#subj').empty();
        $("#subj").append(data);
      },
      
  });
});

$('#sectionselecte,'+'#classselecte').on('change',function() {
  var clas = $('#classselecte').find('option:selected').val();
  var sect = $('#sectionselecte').find('option:selected').val();
  var day = $('#daye').val();
  $.ajax({
      url : "<?php echo site_url('academics/substitute_teacher/GetSubject')?>",
      type: "POST",
      data: {cid:clas,sid:sect,day:day},
      success: function(data)
      {
        //console.log(data);
        $('#subje').empty();
        $("#subje").append(data);
      },
      
  });
});

function save()
{
  var date    = $('#date').val();
  var remarks = $('#remarks').val();
  var day     = $('#day').val();
  var routid  = $('#subj').find('option:selected').val();
  var tid     = $('#teacher').find('option:selected').val();

  if(!$('#form_add')[0].checkValidity()) {
      $(this).show();
      $('#form_add')[0].reportValidity();
      return false;
  }
  else{
    $.ajax({
        url : "<?php echo site_url('academics/substitute_teacher/save')?>",
        type: "POST",
        data: {date:date,routid:routid,tid:tid,remarks:remarks,day:day},
        success: function(data)
        {
          if(data=='1')
          {
            alert('Substitute Teacher Assigned Successfully');
            location.reload();
          }

        },
        
    });
  }
}

function delet(id)
{
  var r = confirm("Are you sure you want to Delete?");
  if (r == true) 
  {            
    $.ajax({
      url: "<?php echo base_url('academics/substitute_teacher/delete_routine')?>",
      type: "POST",
      data: {id:id},
      success: function(data) {
        
          alert('Successfully Deleted');
          location.reload();
                
      },
    });
  }
}


function edit(id,date,day,cld,secid,subid,tid,rouid,remarks)
{
  $("form")[0].reset();
  $('#routinid').val(rouid)
  $('#classselecte option').removeAttr('selected')
  $('#dates').val(date);
  $('#daye').val(day);
  $("#classselecte option[value="+cld+"]").attr('selected', 'selected').trigger('change');  
  
  $("#subje option[value="+subid+"]").attr('selected', 'selected').trigger('change');  
  $("#teachere option[value="+tid+"]").attr('selected', 'selected').trigger('change'); 
  $('#remarkse').val(remarks); 

  var aa = $('#classselecte').find('option:selected').val();
  $.ajax({
      url : "<?php echo site_url('academics/substitute_teacher/GetSection')?>",
      type: "POST",
      data: {id:aa},
      success: function(data)
      {
        $('#sectionselecte').empty();
        $("#sectionselecte").append(data);
        $("#sectionselecte option[value="+secid+"]").attr('selected', 'selected').trigger('change');  
      },
      
  });

  $.ajax({
      url : "<?php echo site_url('academics/substitute_teacher/GetSubject')?>",
      type: "POST",
      data: {cid:cld,sid:secid,day:day},
      success: function(data)
      {
        $('#subje').empty();
        $("#subje").append(data);
        $("#subje option[value="+subid+"]").attr('selected', 'selected').trigger('change');  
      },
      
  });
  $('.update').attr('onclick',"update("+id+")");
  $('#edit_subs_teacher').modal('show'); 
}

$('#dates').on('click change',function(){
  var date = $('#dates').val();
  var weekday = ["sunday","monday","tuesday","wednesday","thursday","friday","saturday"];
  var a = new Date(date);
  var day = weekday[a.getDay()];
  $('#daye').val(day);
 
  var aas = $('#classselecte').find('option:selected').val();
  
  $('#sectionselecte').empty();
   $.ajax({
        url : "<?php echo site_url('academics/substitute_teacher/GetSection')?>",
        type: "POST",
        data: {id:aas},
        success: function(data)
        {
          $("#sectionselecte").append(data);
        },        
    });

  var aass = $('#classselecte').find('option:selected').val();
  var sect_id = '1';
  
})

function update(id)
{
  var id = id;

  var date    = $('#dates').val();
  var remarks = $('#remarkse').val();
  var day   = $('#daye').val();
  var routid  = $('#subje').find('option:selected').val();
  var tid     = $('#teachere').find('option:selected').val();

  /*var aaa = $("form").serialize();
  alert(aaa);
*/
  $.ajax({
      url : "<?php echo site_url('academics/substitute_teacher/update')?>",
      type: "POST",
      data: {date:date,routid:routid,tid:tid,remarks:remarks,day:day,id:id},
      success: function(data)
      {
        console.log(data);
        location.reload();
      },
      
  });

}

</script>