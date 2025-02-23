      <div class="form-group">
        <div class="box">            
          <div class="box-body" style="padding-top:2%">
            
              <div class="row" >
                  <div class="col-lg-4"></div>
                  <div class="col-lg-1"  style="padding-right: 0px">
                      <label> YEAR </label>
                  </div>
                  <div class="col-lg-1" style="padding-left: 0px">
                      <input type="text" class="form-control" id="year_list" style="background:beige;font-weight:bold" value="<?php echo $year_list;?>"/>
                  </div>
                  <?php if(substr($right_access,0,1)=='C'){?>
                  <div class="col-lg-6" style="text-align:right;"><button data-toggle="modal" data-target="#div_holiday" class="btn btn-add" id="add_holiday"> <i class="fa fa-plus-circle fa-lg"></i> </button></div>
                  <?php }?>
              </div>
          </div>


            

            
            <div class="box-body">
            

              <form id='frmtemplate' role="form" method="POST">
                  <div class="table-responsive"> 
                <table id="holidaylist" class="table table-bordered table-striped">
                <thead>
                        <tr style="background:#99ceff;">
                                        
                                        
                                        <th style="border-bottom:0px">Holiday Name</th>
                                        <th style="border-bottom:0px">Holiday From/Holiday On</th>
                                        <th style="border-bottom:0px">Holiday To</th>
                                        <th style="border-bottom:0px">Day Name</th>
                                        <th style="border-bottom:0px">Remarks</th>
                                        <th style="border-bottom:0px">Actions</th>
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
                        <th style="border-bottom:2px solid darkcyan;border-top:0px"></th>
                    </tr>
                </thead>
                  <tbody>
                  <?php 
              $count = 1;
              foreach($fetch_holiday as $row):?>
               
                    <tr>
                      
                      <td><?php echo $row->holiday_name;?></td>                                         
                      <td data-date="<?=$row->holiday_date_from?>"><?php if ($row->holiday_date_from!='0000-00-00') echo date('l, jS F Y', strtotime($row->holiday_date_from)); ?></td>
                      <td data-date="<?=$row->holiday_date_to?>"><?php if ($row->holiday_date_to!='0000-00-00') echo date('l, jS F Y', strtotime($row->holiday_date_to)); ?></td>
                      <td><?php echo $row->day_name;?></td>                                         
                      <td><?php echo $row->remarks;?></td>                                         
                      <td>
                          <div class="form-group row">
                              <?php if(substr($right_access,3,1)=='D'){?>
                              <div class="col-sm-1" >
                                  <input type="checkbox" class="btn"  id="<?php echo $row->id; ?>">
                              </div>
                              <?php }if(substr($right_access,2,1)=='U'){?>
                            <div class="col-sm-2">
                             <a class="btn a-edit" id="<?php echo $row->id;?>" style="padding-left:0px">
                              <i class="fa fa-edit"></i> 
                            </a>
                            </div>
                              <?php }?>
                          </div>
                      </td>
                           
                    </tr>
                 <?php endforeach;?>
                  </tbody>
                  <tfoot>
                  </tfoot>
                </table>
                  </div>
                <?php if(substr($right_access,3,1)=='D'){?>
                  <div class="box-body" style="text-align:right">
                    <?php if(count($fetch_holiday) > 0){?>              
                    <input type="button" class="btn btn-danger" id="emp_cats" value="Delete" onclick="deleteClass();">
                    <?php }   ?>
                    
                  </div>
                <?php }?>
               

                 </form>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
        <div id="div_holiday" class="modal fade" role="dialog">
                <div class="modal-dialog">

                  <!-- Modal content-->
                  <div class="modal-content">
                      <form action="<?php echo base_url('hr/holidays/save')?>" method="post" id="frm_holiday" class="form-horizontal">
                          
                          <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3 class="modal-title">Add Holiday</h3>
			 </div>
                          <div class="modal-body form">
                              <div class="form-body">
                              <div class="form-group">
                                              <label class="control-label col-md-4">Year</label>
                                              <div class="col-md-8" style='padding-bottom:1%;'>
                                                  <input type="number" class="form-control" id="year" name="year" placeholder="Year" value='<?=$year_list?>' style="width:20%" required min="2000" max="2099" step="1"/>
                                              </div>
                            </div>
                             <div class="form-group">
                                              <label class="control-label col-md-4">Holiday Name</label>
                                              <div class="col-md-8" style='padding-bottom:1%'>
                                                  <input type="text" class="form-control" id="hname" name="hname" placeholder="Holiday Name" value='' required/>
                                              </div>
                            </div>
                            <div class="form-group">
                                              <label class="control-label col-md-4">Holiday Date From</label>
                                              <div class='input-group date col-md-8' id='datetimepicker1' style='padding-left:15px;padding-right:15px'>
                                                        <input type='date' class="form-control" id="hdate_from" name="hdate_from" placeholder="From" value="<?php // echo $doj; ?>" required>
                                             </div>
                            </div>
                              <div class="form-group">
                                              <label class="control-label col-md-4">Holiday Date To</label>
                                              <div class='input-group date col-md-8' id='datetimepicker2' style='padding-left:15px;padding-right:15px'>
                                                        <input type='date' class="form-control" id="hdate_to" name="hdate_to" placeholder="To" value="<?php // echo $doj; ?>" >
                                             </div>
                            </div>
                              <div class="form-group">
                                              <label class="control-label col-md-4">Remarks</label>
                                              <div class="col-md-8">
                                                  <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Remarks" value=''/>
                                              </div>
                            </div>
                              </div>
                            </div>
                          <div class="modal-footer">
                            
                                <button type="button" class="btn btn-success" id="btn_save">Save</button>
                            </div>
                      </form>
                    <!--</div>-->
                  </div>

                </div>
        </div>

<script>


  $(function () 
  {
            var table=$('#holidaylist').DataTable({
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
  $(document).ready(function()
  {
      
//  $('#datetimepicker1').datetimepicker({
//                todayBtn: true,
//                autoclose: true,
//                pickerPosition: "bottom-left",
//                format:'yyyy-mm-dd',
//                minView: 2,
//
//            }); 
//            $('#datetimepicker2').datetimepicker({
//                todayBtn: true,
//                autoclose: true,
//                pickerPosition: "bottom-left",
//                format:'yyyy-mm-dd',
//                minView: 2,
//
//            }); 
        });
        
        
//----------------------Edit operation-----------------------------
$('#holidaylist a').click(function()
{   
    var holiday=$(this).closest('tr').find("td:nth-child(1)").text();
    var date_from=$(this).closest('tr').find("td:nth-child(2)").data('date');
    var date_to=$(this).closest('tr').find("td:nth-child(3)").data('date');
    var remarks=$(this).closest('tr').find("td:nth-child(5)").text();
//    alert(category);
    var id=$(this).attr('id');
//    alert(id);
    var action_url='<?php echo base_url('hr/holidays/update');?>'+'/'+id;
    $('#year').val($('#year_list').val());
    $('#hname').val(holiday);
    $('#hdate_from').val(date_from);
    $('#hdate_to').val(date_to);
    $('#remarks').val(remarks);
    $('#frm_holiday').attr('action',action_url);
    $('#frm_holiday .modal-title').text('Update Holiday');
    
    $('#div_holiday').modal({'show':true});
    
});


//-------------------------------------------------------------------
    $('#div_holiday').on('hidden.bs.modal',function(e) 
    {
            $('#year').val('');
            $('#hname').val('');
            $('#hdate_from').val('');
            $('#hdate_to').val('');
            $('#remarks').val('');
            $('#frm_holiday').attr('action',"<?php echo site_url('hr/holidays/save')?>");
            $('#frm_holiday .modal-title').text('Add Holiday');
    });


//--------------------------------------------------------------------



    $('#btn_save').click(function()
    {
            var formdata=$('#frm_holiday').serialize();
            var action_url=$('#frm_holiday').attr('action');
//             alert(action_url);
        if(!$('#frm_holiday')[0].checkValidity())
        {
    //                                                alert($('#add_stud_frm')[0].validationMessage);
            $(this).show();
            $('#frm_holiday')[0].reportValidity();
                                        return false;
        }
        else{

            $.ajax
            ({
                type:'POST',
                data:formdata,
                url: action_url,
                datatype:"text",
                success: function(data)
                {
                    window.location.href = '<?php echo base_url('hr/holidays');?>';

                },
                error: function(data)
                {
                    alert('error occured while saving'+data);
                }

            });
        }

    });


    $('#year_list').change(function()
    {
            var year=this.value;
            window.location.href = '<?php echo base_url('hr/holidays/year');?>'+'/'+year;
    
    
    });



  function deleteClass()
  {
                var r = confirm("Are you sure you want to delete this record?");
//                var id='1';
                if(r == true)
                 {
                      var class_id_string =[];
                      var i=0;
                      $("input:checked").each(function () 
                      {
                            class_id_string[i]= $(this).attr("id");
                            i++;
                      });

//
                    $.ajax({
                          url : "<?php echo site_url('hr/holidays/delete')?>",
                          type: "POST",
                          data: {class_id_string:class_id_string},
                          dataType: "text",
                          success: function(data)
                          {
                               window.location.href = "<?php echo base_url('hr/holidays');?>";
//                         
                          },
                          error : function(data,status)
                          {
                                alert('e'+data+status);
                      }});

                  }
  }

</script>




