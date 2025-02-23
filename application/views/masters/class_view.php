      <div class="form-group has-feedback">
        <div class="box">
           
            <div class="box-body">
                <div class="col-lg-12">
                    <?php if(substr($right_access,0,1)=='C'){?>
                    <div class="col-lg-12" style="text-align:right;">
                        <button class="btn btn-add" id="add_class">
                          <i class="fa fa-plus-circle fa-lg"></i> 
                          </button>
                    </div>
                    <?php }?>
                </div>
            </div>
                        
            <div class="box-body">

              <form id='frmclass' role="form" method="POST">
                  <div class="table-responsive">
                <table id="classlist" class="table table-bordered table-striped dTable">
                  <thead style="background:#99ceff;">
                  <tr>
                    <th style="border-bottom:0px">Class ID</th>
                    <th style="border-bottom:0px">Class Code</th>
                    <th style="border-bottom:0px">Class Name</th>
                    <th style="border-bottom:0px">Section </th>                              
                    <th style="border-bottom:0px">Total No. of Students</th>
                    <th style="border-bottom:0px">Total No. of Registered Students</th>
                    <th style="border-bottom:0px">Last Month For Monthly Fee</th>
                    <th style="border-bottom:0px">Action</th>
                  </tr>
                  </thead>
                  <thead style="background: #cce6ff">
                            <tr id="searchhead">
                                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                                <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                            </tr>
                 </thead>
                  <tbody>
                  <?php 
                  if(isset($aclass) && count($aclass) > 0){
                      $month_arr = array(1 => "April", 2 => "May", 3 => "June", 4 => "July", 5 => "August", 6 => "September", 7 => "October", 8 => "Novemeber", 9 => "December", 10 => "January", 11 => "February", 12 => "March");

                  foreach ($aclass as $class) { 
                      $cid = $class['id'];
                      $section = $class['section'];
                      $arr = explode(',',$section);

                    ?>
                  <tr>
                    <td onclick="view_student('<?php echo $class['id']; ?>');"><?php echo $class['id']; ?></td>
                    <td onclick="view_student('<?php echo $class['id']; ?>');"><?php echo $class['class_code']; ?></td>
                    <td onclick="view_student('<?php echo $class['id']; ?>');"><?php echo $class['class_name']; ?></td>
                    <td onclick="view_student('<?php echo $class['id']; ?>');"><?php echo $class['section']; ?></td>                                    
                    <td onclick="view_student('<?php echo $class['id']; ?>');"><?php echo $class['totalstud']?>
                     (<?php   
                          $count = count($arr);
                          $i=1;
                          foreach($arr as $sect)
                          { 
                            echo $sect.':';
                            echo '&nbsp;';
                            echo $this->dbconnection->GetTotalStudent($cid,$sect);
                            $i++;
                            if($i<=$count)
                            {
                              echo ',';
                            }
                            
                          }
                        ?>)</td>
                    <td onclick="view_student('<?php echo $class['id']; ?>');"><?php echo $class['totalreg']?></td>
                    <td onclick="view_student('<?php echo $class['id']; ?>');"><?php echo $month_arr[$class['last_monthlyfeepay_month']]?></td>
                    <td>
                        <?php if(substr($right_access,2,1)=='U'){?>
                      <a class="btn a-edit" onclick="updateClass('<?php echo $class['id']; ?>', '<?php echo $class['class_code']; ?>', '<?php echo $class['class_name']; ?>','<?php echo $class['section_id'];?>','<?php echo $class['last_monthlyfeepay_month'];?>');">
                        <i class="fa fa-edit"></i> 
                      </a>
                        <?php }if (substr($right_access,3,1)=='D'){?>
                      <a class="btn a-delete" data-toggle="modal" onclick="deleteClass('<?php echo $class['id']; ?>');">
                        <i class="fa fa-trash"></i> 
                      </a>
                        <?php } ?>                     
                    </td>                                                                                                                                                   
                         
                  </tr>
                  <?php } 
                  }
                  ?>
                  </tbody>
                  <tfoot>
                  </tfoot>
                </table>
                  </div>
                 </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>

<script>
var globalid = '';
var url = "<?php echo base_url();?>";
var newtxt = 1000;

$(document).ready(function()
{



  $('#add_class').click(function()
  {
      save_method = 'add';
      $('#fee-box').empty();
      $('#form_class_add')[0].reset(); // reset form on modals
      $('.form-group').removeClass('has-error'); // clear error class
      $('.help-block').empty(); // clear error string
      $('#classid').empty();
      $('#btn_save').text('Save');
      $('select').trigger('change');
      $('#modal_form').modal('show'); // show bootstrap modal
  });

  <?php if(!empty($_GET['school'])){ ?>
    select_template();
    $('#school').attr("disabled","disabled");
  <?php } ?>

 


});


//$(function () {
//
//   $('#classlist').DataTable({
//    "paging": true,
//    "lengthChange": true,
//    "searching": true,
//    "ordering": true,
//    "info": true,
//    "autoWidth": true
//
//  });
//  
//});



function view_student(classid,schoolid)
{
 
  <?php 
      $school_id = $this->session->userdata('school_id');
  ?>

  <?php if($school_id == ''){ ?>
//    window.location.href = "<?php // echo site_url('school/student/')?>/"+classid+"<?php echo '?school=' ?>"+schoolid;
  <?php }else{ ?>
//    window.location.href = "<?php // echo site_url('school/student/')?>/"+classid+"<?php echo '?school='.$school_id ?>";
  <?php } ?>
}

function updateClass(id,code,name,section,last_monthlyfeepay_month,school)
{
    $("#school option[value="+school+"]").attr('selected', 'selected');
    $('#errmodal').empty();
    $('#form_class_add')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string
    $('#classid').empty();
    $('#classid').append('<div class="form-group"><label class="control-label col-md-3">Class ID</label><div class="col-md-9" id="modal_classid">'+id+'</span></div></div>');
    $('#className').val(name);
    $('#classCode').val(code);
//    $('#last_monthlyfeepay_month').val(last_monthlyfeepay_month).prop('selected');
    $('#last_monthlyfeepay_month').val(last_monthlyfeepay_month).trigger('change');

    var arr = section.split(',');
    $.each(arr, function(index, val) 
    {
        if(val!='')
        $('input[type=checkbox][value='+val+']').prop('checked', true);
    });

    globalid = id;
    save_method = 'update';
    $('#btn_save').text('Update');
    $('#modal_form').modal('show');
    return false;
}

function save()
{
    var r = confirm("Are you sure you want to save?");
    if (r == true) 
    {
        $('#btnSave').text('saving...'); //change button text
        $('#btnSave').attr('disabled',true); //set button disable 
        var err = '';
         $('#errmodal').empty();

        if($('#className').val() == '')
        {
                    err = 'Please input Class Name.';
        }
        
        if($('#classCode').val() == '')
        {
                    err = 'Please input Class Code.';
        }

        if(err == '')
        {
          $('#errmodal').empty();
          var url;
          var class_name=$('#className').val();
          var class_code=$('#classCode').val();
          var last_monthlyfeepay_month=$('#last_monthlyfeepay_month').val();

          var section='';
          $("input[name='chkname[]']:checked").each(function() 
          {
              if(section == '')
              {
                section  = this.value;           
              }
              else
              {
                section  += "-"+ this.value ; 
              }
          });

          if(save_method == 'add') 
          {
              url = "<?php echo site_url('masters/Classes/addclass')?>";
          } 
          else 
          {
              var modal_classid1=$('#modal_classid').text();
              $('#btnSave').text('updating...');
              url = "<?php echo site_url('masters/Classes/update_class')?>/"+modal_classid1;
          }

          $.ajax
          ({
              url : url,
              type: "POST",
              data: 
              {
                  class_code:class_code,
                  class_name:class_name,
                  section:section,
                  last_monthlyfeepay_month:last_monthlyfeepay_month
              },
              dataType: "text",
              success: function(data)
              {
                if(data == 1)
                {
                    $('#modal_form').modal('hide');
                    window.location.reload();
                }

                $('#btnSave').text('save');
                $('#btnSave').attr('disabled',false);
              }
          });                    
        }
        else
        {
          $('#errmodal').css('color','Red');
          $('#errmodal').append(err);
          $('#btnSave').text('save'); //change button text
          $('#btnSave').attr('disabled',false); //set button disable 
        }
    } 
    else 
    {
      return false;
    }
}



function deleteClass(id,school_id)
{

  var r = confirm('Are you sure you want to delete this record?');
  if(r == true){
    var dataval = { 'classid' : id , 'school_id' : school_id} ;
    $.ajax({
          url : "<?php echo site_url('masters/Classes/delete_class')?>",
          type: "POST",
          data: dataval,
          dataType: "text",
          success: function(data)
          {
             window.location.reload();
          },
          error: function (data, status)
          {
              alert('Error deleting class.');

          }
      });
  }else{
    return false;
  }
}

</script>


<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" id="modal_header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Class</h3>
            </div>
            <div class="modal-body" id="modal-body">

                <form action="#class_section_add" id="form_class_add" name="form_class_add" class="form-horizontal">
                <div class="form-body">

                    <div class="form-group">
                        <div class="col-md-3">                              
                        </div>
                        <div class="col-md-9" id="errmodal">                          
                        </div>
                    </div>


                   <div id="classid">                         
                   </div>
                   
                    <div class="form-group">
                        <label class="control-label col-md-3">Class Code</label>
                        <div class="col-md-9">
                            <input id="classCode" name="classCode" placeholder="Class Code" class="form-control" type="text">
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Class Name</label>
                        <div class="col-md-9">
                            <input id="className" name="className" placeholder="Class Name" class="form-control" type="text">
                            <span class="help-block"></span>
                        </div>
                    </div>
                   
                   <div class="form-group">
                        <label class="control-label col-md-3">Section Name</label>
                        <div class="col-md-9">                              
                            <?php foreach($asection as $sec) 
                            { ?>
                              <div class="col-md-6">
                                <input type="checkbox" id="chk_id_<?php echo $sec->id ?>" name="chkname[]" value="<?php echo $sec->id ?>"  ><span style="padding:2%"> <?php echo $sec->sec_name ?> </span>
                              </div>
                            <?php                                         
                            }?>
                        </div>
                            
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Last Month For Monthly Fee</label>
                        <div class="col-md-9">
                            <select name="last_monthlyfeepay_month" id="last_monthlyfeepay_month" class="form-control">
                                        <option value="">Select Month</option>
                                        <option value="1">April</option>
                                        <option value="2">May</option>
                                        <option value="3">June</option>
                                        <option value="4">July</option>
                                        <option value="5">August</option>
                                        <option value="6">September</option>
                                        <option value="7">October</option>
                                        <option value="8">November</option>
                                        <option value="9">December</option>
                                        <option value="10">January</option>
                                        <option value="11">February</option>
                                        <option value="12">March</option>
                            </select>
                            
                            <span class="help-block"></span>
                        </div>
                    </div>
                </div>
                
            </form>
        </div>
        <div class="modal-footer" id="modal-footer">
            <button type="button" id="btn_save" onclick="save()" class="btn btn-success">Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
</div>

