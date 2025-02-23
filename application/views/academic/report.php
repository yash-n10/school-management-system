
<style>
/*    td.highlight {
    background-color: lightskyblue !important;
} */
tr.highlight {
    background-color: antiquewhite !important;
}  
</style>

<div class="form-group has-feedback">
  <form id="form_add" name="attendance" method="POST">
    <div class="box">    
      <div class="box-body">     
        <div class="row">
         <!--  <div class="col-md-2 form-group">
            <label for="exampleFormControlSelect1">Category</label>
            <select class="form-control" id="examname" name="examname" required>
               <option value="">&nbsp;&nbsp;--Select Category--&nbsp;&nbsp;</option>
                <?php foreach($cate as $cvalue){?>
                  <option value="<?php echo $cvalue->id;?>"><?php echo $cvalue->name;?></option>
                <?php }?>
            </select>
          </div> -->

          <div class="col-md-2 form-group">
            <label for="exampleFormControlSelect1">Class</label>
            <select class="form-control" id="class" name="class" required>
               <option value="">&nbsp;&nbsp;--Select Class--&nbsp;&nbsp;</option>
                <?php foreach($class as $clvalue){?>
                  <option value="<?php echo $clvalue->id;?>"><?php echo $clvalue->class_name;?></option>
                <?php }?>
            </select>
          </div>

          <div class="col-md-2 form-group">
            <label for="exampleFormControlSelect1">Section</label>
            <select class="form-control" id="section" name="section" required>
               <option value="">&nbsp;&nbsp;--Select Section--&nbsp;&nbsp;</option>
            </select>
          </div>

          <div class="col-md-2 form-group">
            <label for="exampleFormControlSelect1">Subject</label>
            <select class="form-control" id="subject" name="subject" required>
              <option value="">&nbsp;&nbsp;--Select Subject--&nbsp;&nbsp;</option>
             </select>
          </div>

          <div class="col-md-2 form-group">
            <label for="exampleFormControlSelect1">Date of Assign</label>
            <select class="form-control" id="datesub" name="datesub" required>
              <option value="">&nbsp;&nbsp;--Select D/O/A--&nbsp;&nbsp;</option>
                <?php foreach($assig as $dvalue){?>
                  <option value="<?php echo $dvalue->doa;?>"><?php echo $dvalue->doa;?></option>
<!--                   <option value="<?php echo $dvalue->date_created;?>"><?php $date = $dvalue->date_created; echo $newDate = date("d-m-Y", strtotime($date));?></option>
 -->                <?php }?>
             </select>
          </div>

          <div class="col-md-1 form-group">
              <label for="exampleFormControlSelect1">&nbsp;</label>
              <a onclick="vie()" title="VIEW MARKS" class="btn btn-success form-control" id="view_marks" title="View Report"> <i class="fa fa-eye fa-lg"></i>  </a>
          </div>    
        </div>    
      </div>   
    </div>

    <div class="box" id="dataview" style="display: none;">
      <div class="box-body" id="ddd">
            
      </div>   
    </div>
  </form>
</div>

<script>
function vie()
{
  if(!$('#form_add')[0].checkValidity()) 
  {
    $(this).show();
    $('#form_add')[0].reportValidity();
    return false;
  }
  else
  {  
    // var examnam = $('#examname').find('option:selected').val();
    var clas = $('#class').find('option:selected').val();
    var section = $('#section').find('option:selected').val();
    var subject = $('#subject').find('option:selected').val();
    var datesub = $('#datesub').find('option:selected').val();


    $.ajax({
        url : "<?php echo site_url('academics/homework/Report/GetData')?>",
        type: "POST",
        data: {clas:clas,section:section,subject:subject,datesub:datesub},
        // data: {examnam:examnam,clas:clas,section:section,subject:subject,datesub:datesub,},
        success: function(data)
        {         
           $('html, body').animate({
                scrollTop: $("#ddd").offset().top
            }, 1000);
          $('#ddd').empty();
          $("#ddd").append(data);
          var table =$('#templatelistss').DataTable({
                  "scrollY": "400px",
                  "scrollCollapse": true,
                  "paging":         false,
                  "searching": false
                });
          $('#templatelistss tbody')
            .on( 'click', 'td', function () {
                var colIdx = table.cell(this).index().row;
                $('.highlight').removeClass('highlight');
                $( table.row( colIdx ).nodes()).addClass('highlight');
            } );
        },        
    });

    $('#dataview').show();

  }
}

$(function ()
{
    $('#period').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true
    });
});


$('#class').on('change keyup',function(){
    var value = $(this).val();
    $.ajax({
        url : "<?php echo site_url('academics/homework/Report/GetSection')?>",
        type: "POST",
        data: {id:value},
        success: function(data)
        {         
          $('#section').empty();
          $("#section").append(data);
        },        
    });
});

$('#class,'+'#section').on('change click keyup',function(){
  var clas = $('#class').find('option:selected').val();
  var sect = $('#section').find('option:selected').val();

  $.ajax({
      url : "<?php echo site_url('academics/homework/Report/GetSubjects')?>",
      type: "POST",
      data: {clasid:clas,sect:sect},
      success: function(data)
      { 
        $('#subject').empty();
        $("#subject").append(data);

      },        
  });
});


function save_reportss()
{
  
  $.ajax({
        type:'POST',
        url:"<?php echo base_url('academics/homework/Report/save_stud_report');?>",
        data:$('#form_add').serialize(),
        datatype:'text',
        success:function(data)
        {
            alert('Assignment Report successfully submited.')
            location.reload();
        },
  });
}

$('#class,'+'#section,'+'#subject').on('change click keyup',function(){
  // var cate = $('#examname').find('option:selected').val();
  var clas = $('#class').find('option:selected').val();
  var sect = $('#section').find('option:selected').val();
  var sub = $('#subject').find('option:selected').val();
    $.ajax({
      url : "<?php echo site_url('academics/homework/Report/GetDoa')?>",
      type: "POST",
      data: {clasid:clas,sect:sect,sub:sub},
      success: function(data)
      { 
        $('#datesub').empty();
        $("#datesub").append(data);

      },        
  });
});


  function updat(id,stid)
  {
    var re =  $("input[name='report["+stid+"]']:checked").val();
    var rem = $('#rem_'+stid).val();
    $("#tick_"+id).hide();
    $("#refre_"+id).show();
    
  }

  function update_report(){
     $.ajax({
          type:'POST',
          url:"<?php echo base_url('academics/homework/Report/update_stud_report');?>",
          data:$('#form_add').serialize(),
          datatype:'text',
          success:function(data)
          {
            alert(' Assignment Remarks Updated Successfully');
            //location.reload();
          },
    });
  }
</script>