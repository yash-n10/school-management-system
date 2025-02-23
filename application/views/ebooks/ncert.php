         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css">
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css">


<div class="form-group has-feedback">
  <div class="box">
    <div class="box-body">
       <div class="col-lg-12" style="text-align:right;">
           <?php if(substr($right_access, 0,1)=='C') {?>
          <a class="btn btn-add" data-toggle="modal" data-target="#myModal" title="Add Books Pdf">
            <i class="fa fa-plus-circle fa-lg"></i>&nbsp;
          </a>
           <?php } ?>
        </div>

    </div>
    <div class="box-body">
        <?php if(substr($right_access, 1,1)=='R') {?>
        <div class="table-responsive">
      <table cellpadding="0" cellspacing="0" border="2"  class="table table-striped table-bordered" id="period">
        <thead style="background:#99ceff;">
          <tr>
              <th style="border-bottom:0px">S.No.</th>
              <th style="border-bottom:0px">Class</th>
              <th style="border-bottom:0px">Section</th>
              <th style="border-bottom:0px">Subject</th>
              <th style="border-bottom:0px">Uploaded</th>
              <th style="border-bottom:0px">Descriptions</th>
              <th style="border-bottom:0px">View</th>
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
               
                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
            </tr>
        </thead>
          <tbody>
            <?php 
           
            $i=1;
            foreach($homework as $value){?>
              <tr>
                <td><?php echo $i;?></td>
                <td><?php echo $value->class_name;?></td>
                <td><?php echo $value->sec_name;?></td>
                <td><?php echo $value->name;?></td>
                <td><?php echo $value->date_created;?></td>
                <td><?php echo $value->description;?></td>
                <?php if($value->attachment !='') {?>
                  <td><a href="<?php echo base_url();?>/assets/ebooks/ncert/<?php echo $value->attachment;?>" class="btn btn-primary">View</a></td>
                <?php } else { ?>
                  <td><button class="btn btn-warning">No Attachment</button></td>
                <?php } ?>
                <td>
                    <?php if(substr($right_access, 2,1)=='U') {?>
                    <span>
                        <a class="btn a-edit" onclick="edit(<?php echo $value->id;?>,'<?php echo $value->doa;?>',<?php echo $value->class_id;?>,<?php echo $value->section_id;?>,<?php echo $value->subject_id;?>,'<?php echo $value->attachment;?>','<?php echo $value->dos;?>','<?php echo $value->description;?>')"><i class="fa fa-edit"></i> </a>
                    </span>
                    <?php }?>
                    <?php if (substr($right_access, 3,1)=='D'){?>
                    <span>
                        <a class="btn a-delete" onclick="delet(<?php echo $value->id;?>)"><i class="fa fa-trash"></i> 
                        </a>
                    </span>
                    <?php } ?>
                </td>
              </tr>

              <?php if(substr($right_access, 1,1)=='R') {?>
              <div id="viewModal_<?php echo $value->id;?>" class="modal fade" role="dialog">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Questions</h4>
                    </div>
                    <div class="modal-body">
                      <?php if($value->attachment==''){?>
                        <p><?php echo $value->description;?></p>
                      <?php }else{?>
                      	<p><?php echo $value->description;?></p>
                      	<a href="<?php echo base_url();?>/homework/<?php echo $value->attachment;?>" target="_blank" style="font-size: 16px;"><b>Click Here to View</b></a><br>
                        <img src="<?php echo base_url();?>/homework/<?php echo $value->attachment;?>" style="height:100px;width:100%;"/>
                      <?php }?>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
          <?php }?>

            <?php 
              $i++;
              }
            ?>
          </tbody>
      </table>
        </div>   
        <?php }?>
    </div>   
  </div>
</div>
<?php if(substr($right_access, 0,1)=='C') {?>
        <div id="myModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              
                <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">Add Books PDF</h3>
                </div>
              <form style="width:90%;margin-left:5%;" id="form_a" name="form_a" method="post" enctype="multipart/form-data">
              <div class="modal-body">
               <div class="form-group">
                    <label for="exampleFormControlFile1" class="control-label">Class</label>
                    <select class="form-control" id="class" name="class" required>
                      <option value="">-- Select Class Name --</option>
                      <?php foreach($classs as $value){?>
                      <option value="<?php echo $value->id;?>"><?php echo $value->class_name;?></option>
                      <?php }?>
                    </select>
                  </div> 
                  <div class="form-group">
                    <label for="exampleFormControlFile1" class="control-label">Section</label>
                    <select class="form-control" id="section" name="section" required>
                       <option value="">-- Select Section --</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleFormControlFile1" class="control-label">Subject</label>
                    <select class="form-control" id="subject" name="subject" required>
                       <option value="">-- Select Subject --</option>
                    </select>
                  </div>
                 <div class="form-group">
                    <label for="pwd">Upload Date</label>
                    <input type="text" id="homework_date" name="homework_date" class="form-control" value="<?php echo date('Y-m-d'); ?>" readonly="">
                    <span id="date_add_error" class="text-danger"></span>
                </div>

                   <div class="form-group">
                  <label for="pwd">Attach Document</label>
                  <div class="dropify-wrapper" style="height: 34px;">
                      <div class="dropify-message" style="top: 30%;">
                        <p><i class="fa fa-cloud-upload dropi18"></i>Drag and drop a file here or click</p>
                      </div>
                      <div class="dropify-loader"></div>
                      <input type="file" id="userfile" name="userfile" class="form-control filestyle" autocomplete="off">
                    
                  </div>
                  </div>
                  <center><img id="previewHolder" alt="" width="250px" height="200px"/ style="display:none"></center>
                   
                  <div class="form-group">
                    <label for="pwd" class="control-label">Description</label>
                     <textarea class="form-control"  name="descr" rows="2"></textarea>
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
<?php }?>

<?php if(substr($right_access, 2,1)=='U') {?>
        <div id="EditModal" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              
                <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h3 class="modal-title">Edit Books PDF</h3>
                </div>
              <form style="width:90%;margin-left:5%;" id="form_ed" method="post" enctype="multipart/form-data">
                <div class="modal-body">
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
                    <label for="exampleFormControlFile1" class="control-label">Uploaded Date</label>
                   <input type="text" class="form-control" id="doa_ed" name="doa_ed" value="" required>           
                  </div>
              
              </div>
              <div class="modal-footer">
                  <a id="update" class="btn btn-success" onclick="update()">Update</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
              </form> 
            </div>
          </div>
        </div>
<?php }?>
<!--   <script src="https://cdn.ckeditor.com/4.5.1/standard/ckeditor.js"></script>
  <link href="https://cdn.ckeditor.com/theme/css/sdk-inline.css" rel="stylesheet"> -->
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


function edit(id,doa,clid,seid,subid,attached,dos,desc)
{
  
  $("#class_ed option[value="+clid+"]").attr('selected','selected').trigger('change');
  $("#section_ed option[value="+seid+"]").attr('selected','selected').trigger('change');
  $("#subject_ed option[value="+subid+"]").attr('selected','selected').trigger('change');
  $("#doa_ed").val(doa);
  $("#dos_d").val(dos);
  $("#id_ed").val(id);
  $("#descr_ed").val(desc);
  // $("#userfile_ed").val(attached);


  
  var value = clid;
  $.ajax({
      url : "<?php echo site_url('ebooks/Ncert/GetSection')?>",
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
      url : "<?php echo site_url('ebooks/Ncert/GetSubjects')?>",
      type: "POST",
      data: {clasid:clas,sect:sect},
      success: function(data)
      { 
        $('#subject_ed').empty();
        $("#subject_ed").append(data);
      },        
  });

  $.ajax({
      url : "<?php echo site_url('ebooks/Ncert/GetDesc')?>",
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

      var descr = $('#descr_ed').val();
      // var descr = CKEDITOR.instances['descr_ed'].getData();
      var clas = $('#class_ed').find('option:selected').val();
      var sect = $('#section_ed').find('option:selected').val();
      var subj = $('#subject_ed').find('option:selected').val();
      var dos  = $('#dos_d').val();
      var doa  = $('#dos_ed').val();

      var  data = new FormData($('#form_ed')[0]);
      $.ajax({
        url : "<?php echo site_url('ebooks/Ncert/Update_home')?>",
        method: "POST",
        data: {descr_ed:descr,class_ed:clas,section_ed:sect,subject_ed:subj,dos_ed:dos,id_ed:id,doa_ed:doa},
       
        success: function(data)
        {
          //console.log(data);
          location.reload();
        }
      });
   
}


$(function ()
{
  // CKEDITOR.replace('descr');
  // CKEDITOR.replace('descr_ed');

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
      url : "<?php echo site_url('ebooks/Ncert/GetSection')?>",
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
      url : "<?php echo site_url('ebooks/Ncert/GetSection')?>",
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
      url : "<?php echo site_url('ebooks/Ncert/GetSubjects')?>",
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
      url : "<?php echo site_url('ebooks/Ncert/GetSubjects')?>",
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
//   	var formData = new FormData($('#form_a')[0]);
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
                             url:'<?php echo base_url();?>ebooks/Ncert/save',
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
    url : "<?php echo site_url('ebooks/Ncert/Delete')?>",
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

