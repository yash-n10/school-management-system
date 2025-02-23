         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css">
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css">


<div class="form-group has-feedback">
  <div class="box">
    <div class="box-body">
       <div class="col-lg-12" style="text-align:right;">
          <a class="btn btn-add" data-toggle="modal" data-target="#myModal" title="Add Homework">
            <i class="fa fa-plus-circle fa-lg"></i>&nbsp;
          </a>
        </div>

    </div>
    <div class="box-body">

        <div class="table-responsive">
      <table cellpadding="0" cellspacing="0" border="2"  class="table table-striped table-bordered" id="period">
        <thead style="background:#99ceff;">
          <tr>
              <th style="border-bottom:0px">S.No.</th>
              <th style="border-bottom:0px">Class</th>
              <th style="border-bottom:0px">Section</th>
              <th style="border-bottom:0px">Subject</th>
              <th style="border-bottom:0px">Module</th>
              <th style="border-bottom:0px">Topic</th>
              <th style="border-bottom:0px">Time Period</th>
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
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>

          </tbody>
      </table>
        </div>   

    </div>   
  </div>
</div>
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              
                <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">Add Syllabus</h3>
                </div>
              <form style="width:90%;margin-left:5%;" id="form_a" name="form_a" method="post" enctype="multipart/form-data">
              <div class="modal-body">
               <div class="form-group">
                    <label for="exampleFormControlFile1" class="control-label">Class</label>
                    <select class="form-control" id="class" name="class_id" required>
                      <option value="">-- Select Class Name --</option>
                      <?php foreach($class as $value){?>
                      <option value="<?php echo $value->id;?>"><?php echo $value->class_name;?></option>
                      <?php }?>
                    </select>
                  </div> 
                  <div class="form-group">
                    <label for="exampleFormControlFile1" class="control-label">Section</label>
                    <select class="form-control" id="section" name="section_id" required>
                       <option value="">-- Select Section --</option>

                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleFormControlFile1" class="control-label">Subject</label>
                    <select class="form-control" id="subject" name="subject_id" required>
                       <option value="">-- Select Subject --</option>
                       <?php foreach($subject as $value){?>
                      <option value="<?php echo $value->id;?>"><?php echo $value->name;?></option>
                      <?php }?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleFormControlFile1" class="control-label">Module</label>
                    <select class="form-control" id="module_id" name="module_id" required>
                       <option value="">-- Select Module --</option>
                       <?php foreach($subject as $value){?>
                      <option value="<?php echo $value->id;?>"><?php echo $value->name;?></option>
                      <?php }?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="pwd" class="control-label">Topic To be covered</label>
                     <textarea class="form-control" id="topic" name="topic" rows="3"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="pwd" class="control-label">TIme Period</label>
                     <input type="number" class="form-control" name="time_period" id="time_period">
                  </div>
                  <hr/>
                 
               
              </div>
              <div class="modal-footer">
                <button id="submit" type="submit" class="btn btn-success">Submit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>   
              </div>
              </form> 
            </div>
          </div>
        </div>

        <div id="EditModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              
                <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">Edit Homework</h3>
                </div>
              <form style="width:90%;margin-left:5%;" id="form_ed" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                  <!-- <div class="form-group">
                    <label for="exampleFormControlSelect1" class="control-label">Category</label>
                    <select class="form-control" id="categ_ed" name="categ_ed" required>
                      <option value="">-- Select Category --</option>
                      <?php foreach($category as $catvalue){?>
                      <option value="<?php echo $catvalue->id;?>"><?php echo $catvalue->name;?></option>
                      <?php }?>
                    </select>
                  </div> -->
                  
                 <!--  <div class="form-group">
                    <label for="email" class="control-label">Title</label>
                     <input type="hidden" class="form-control" id="id_ed" name="id_ed" value="">
                    <input type="text" class="form-control" id="title_ed" name="title_ed" required>
                  </div> -->
                <div class="form-group">
                    <label for="exampleFormControlFile1" class="control-label">Class</label>
                    <select class="form-control" id="class_ed" name="class_ed" required>
                      <option value="">-- Select Class Name --</option>
                      <?php foreach($classs as $value){?>
                      <option value="<?php echo $value->id;?>"><?php echo $value->class_name;?></option>
                      <?php }?>
                    </select>
                  </div> 
                 
                  <div class="form-group">
                    <label for="exampleFormControlFile1" class="control-label">Section</label>
                    <select class="form-control" id="section_ed" name="section_ed" required>
                       <option value="">-- Select Section --</option>
                    </select>
                  </div>
                
                  <div class="form-group">
                    <label for="exampleFormControlFile1" class="control-label">Subject</label>
                    <select class="form-control" id="subject_ed" name="subject_ed" required>
                       <option value="">-- Select Subject --</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="pwd" class="control-label">Description</label>
                     <textarea class="form-control" id="descr_ed" name="descr_ed" rows="3"></textarea>
                  </div>
                  <hr/>
                  <div class="form-group">
                    <label for="exampleFormControlFile1" class="control-label">Date of Assign</label>
                   <input type="text" class="form-control" id="doa_ed" name="doa_ed" value="" required>           
                  </div>
                 
                  <div class="form-group">
                    <label for="exampleFormControlFile1" class="control-label">Date of Submission</label>
                   <input type="text" class="form-control" id="dos_d" name="dos_ed" value="" required>           
                  </div>

                  <!--  <div class="form-group">
                  <label for="pwd">Attach Document</label>
                  <div class="dropify-wrapper" style="height: 34px;">
                      <div class="dropify-message" style="top: 30%;">
                        <p><i class="fa fa-cloud-upload dropi18"></i>Drag and drop a file here or click</p>
                      </div>
                      <div class="dropify-loader"></div>
                      <input type="file" id="userfile_ed" name="userfile_ed" class="form-control filestyle" autocomplete="off">
                    
                  </div>
                  </div>
                  <center><img id="previewHolder_ed" alt="" width="250px" height="200px" style="dispaly:none"></center> -->
              </div>
              <div class="modal-footer">
                  <a id="update" class="btn btn-success" onclick="update()">Update</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
              </form> 
            </div>
          </div>
        </div>
  <script src="https://cdn.ckeditor.com/4.5.1/standard/ckeditor.js"></script>
  <link href="https://cdn.ckeditor.com/theme/css/sdk-inline.css" rel="stylesheet">
<script>


        $(document).ready(function () {
        var date_format = 'mm/dd/yyyy';
        $('#homework_date,#dos').datepicker({
            format: date_format,
            autoclose: true
        });

    });


         $(document).ready(function () {
        var date_format = 'mm/dd/yyyy';
        $('#doa_ed,#dos_d').datepicker({
            format: date_format,
            autoclose: true
        });

    });


function edit(id,doa,clid,seid,subid,attached,dos)
{
  
  $("#class_ed option[value="+clid+"]").attr('selected','selected').trigger('change');
  $("#section_ed option[value="+seid+"]").attr('selected','selected').trigger('change');
  $("#subject_ed option[value="+subid+"]").attr('selected','selected').trigger('change');
  $("#doa_ed").val(doa);
  $("#dos_d").val(dos);
  $("#id_ed").val(id);
  // $("#userfile_ed").val(attached);


  
  var value = clid;
  $.ajax({
      url : "<?php echo site_url('academics/homework/Add_homework/GetSection')?>",
      type: "POST",
      data: {id:value},
      success: function(data)
      {         
        $('#section_ed').empty();
        $("#section_ed").append(data);
      },        
  });

  var clas = clid;
  var sect = seid;

  $.ajax({
      url : "<?php echo site_url('academics/homework/Add_homework/GetSubjects')?>",
      type: "POST",
      data: {clasid:clas,sect:sect},
      success: function(data)
      { 
        $('#subject_ed').empty();
        $("#subject_ed").append(data);
      },        
  });

  $.ajax({
      url : "<?php echo site_url('academics/homework/Add_homework/GetDesc')?>",
      type: "POST",
      data: {id:id},
      success: function(data)
      { 
        CKEDITOR.instances['descr_ed'].setData(data);
      },        
  });

  $('#update').attr('onclick','update('+id+')');
  $('#EditModal').modal('show');

}

function update(id)
{

      var descr = CKEDITOR.instances['descr_ed'].getData();
      var clas = $('#class_ed').find('option:selected').val();
      var sect = $('#section_ed').find('option:selected').val();
      var subj = $('#subject_ed').find('option:selected').val();
      var dos  = $('#dos_d').val();
      var doa  = $('#dos_ed').val();

      var  data = new FormData($('#form_ed')[0]);
      $.ajax({
        url : "<?php echo site_url('academics/homework/Add_homework/Update_home')?>",
        method: "POST",
        data: {descr_ed:descr,class_ed:clas,section_ed:sect,subject_ed:subj,dos_ed:dos,id_ed:id,doa_ed:doa},
       /* contentType:false,
        processData:false,
        cache:false,*/
        success: function(data)
        {
          //console.log(data);
          location.reload();
        }
      });
   
}


$(function ()
{
  CKEDITOR.replace('descr');
  CKEDITOR.replace('descr_ed');

    var table =$('#period').DataTable({
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


$('#class').on('change keyup',function(){
  var value = $(this).val();
  $.ajax({
      url : "<?php echo site_url('academics/homework/Add_homework/GetSection')?>",
      type: "POST",
      data: {id:value},
      success: function(data)
      {         
        $('#section').empty();
        $("#section").append(data);
      },        
  });
});

$('#class_ed').on('change keyup',function(){
  var value = $(this).val();
  $.ajax({
      url : "<?php echo site_url('academics/homework/Add_homework/GetSection')?>",
      type: "POST",
      data: {id:value},
      success: function(data)
      {         
        $('#section_ed').empty();
        $("#section_ed").append(data);
      },        
  });
});




$('#class,#section').on('click change keyup',function(){
  var clas = $('#class').find('option:selected').val();
  var sect = $('#section').find('option:selected').val();

  $.ajax({
      url : "<?php echo site_url('academics/homework/Add_homework/GetSubjects')?>",
      type: "POST",
      data: {clasid:clas,sect:sect},
      success: function(data)
      { 
        $('#subject').empty();
        $("#subject").append(data);
      },        
  });
});

$('#class_ed,#section_ed').on('click change keyup',function(){
  var clas = $('#class_ed').find('option:selected').val();
  var sect = $('#section_ed').find('option:selected').val();

  $.ajax({
      url : "<?php echo site_url('academics/homework/Add_homework/GetSubjects')?>",
      type: "POST",
      data: {clasid:clas,sect:sect},
      success: function(data)
      { 
        $('#subject_ed').empty();
        $("#subject_ed").append(data);
      },        
  });
});


// $("#submit").click(function(event)
// {

//   if(!$('#form_a')[0].checkValidity()) {
//       $(this).show();
//       $('#form_a')[0].reportValidity();
//       return false;
//   }
//   else{   
//    var formData = new FormData($('#form_a')[0]);
//     var categ = $('#category').find('option:selected').val();
//     var title = $('#title').val();
//       //var descr = $('#descr').val(); 
//     var descr = CKEDITOR.instances['descr'].getData();
//     var clas = $('#class').find('option:selected').val();
//     var sect = $('#section').find('option:selected').val();
//     var subj = $('#subject').find('option:selected').val();
//     var dos  = $('#dos').val();
//     var doa  = $('#homework_date').val();

//     var file_data = $('#userfile').val()$('#userfile')[0].files[0];
   

//     $.ajax({
//       url : "<?php echo site_url('academics/homework/Add_homework/save')?>",
//       type: "POST",
//       data:new FormData(this),
//       processData:false,
//       contentType:false,
//       cache:false,
//       async:false,
//       //data: {categ:categ,title:title,descr:descr,clas:clas,sect:sect,subj:subj,dos:dos,doa:doa,file_data:file_data},
//      // data:formData,
//       success: function(data)
//       {
//         console.log(data);
//        // location.reload();
//       }
//     });
//   }
// });

 $('#form_a').submit(function(e){
                    e.preventDefault(); 
                         $.ajax({
                             url:'<?php echo base_url();?>academics/Syllabus/save_syllabus',
                             type:"post",
                             data:new FormData(this),
                             processData:false,
                             contentType:false,
                             cache:false,
                             async:false,
                              success: function(data){
                                 console.log(data);
                               location.reload();
                           }
                         });
                    });

function delet(id)
{
   var r = confirm("Are you sure you want to Delete?");
  if (r == true) 
  {  
  $.ajax({
    url : "<?php echo site_url('academics/homework/Add_homework/Delete')?>",
    type : "POST",
    data : {id:id},
    success: function(data)
    {
      //console.log(data);
      location.reload();
    }
  });
  }
}



$("#userfile").change(function() {
    var file = this.files[0];
    var fileType = file.type;
    // var match = ['image/jpeg', 'image/png', 'image/jpg'];
    var match = ['application/pdf', 'application/msword', 'application/vnd.ms-office', 'image/jpeg', 'image/png', 'image/jpg'];
    if(!((fileType == match[0]) || (fileType == match[1]) || (fileType == match[2]) || (fileType == match[3]) || (fileType == match[4]) || (fileType == match[5]))){
        alert('Sorry, only JPG, JPEG, & PNG, PDF,WORD files are allowed to upload.');
        $("#userfile").val('');
        return false;
    }
    else{

      readURL(this);
      $('#previewHolder').css('display','block');
    }
});

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      $('#previewHolder').attr('src', e.target.result);
    }

    reader.readAsDataURL(input.files[0]);
  }
}

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"></script>

