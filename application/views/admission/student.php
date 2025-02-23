 
<style>
     fieldset { 
 border: solid 1px #DDD !important;
    padding: 0 10px 10px 10px;
    border-bottom: none;
    background:beige;
}
legend{
    width: auto !important;
    padding:0 10px;
    border: none;
    font-size: 18px;
    color:green;
}
</style>
<div class="form-group has-feedback">
        <div class="box">            
             <div class="box-header">
                 <h3 class="box-title main_head"><u>Students</u></h3>
                    
            </div>
            
            
            <div class="box-body" style="padding-left:25px;padding-right:25px;">
                        <div class="col-lg-12" style="background:Wheat;padding:0px;border-radius: 20px; " >
                         <ul class="nav nav-pills" style="padding-left:20px">
                             
                             <li class="active"><a data-toggle="pill" href="#stud_info"><i class="fa fa-list"></i>Student List</a></li>
                             <li class="" style=""><a data-toggle="pill" href="#upload_admission"><i class="glyphicon glyphicon-upload"></i>Upload Students</a></li>
                             <li class="" style=""><a data-toggle="pill" href="#download_admission"><i class="glyphicon glyphicon-download"></i>Download Students</a></li>
                             <li class="" style=""><a data-toggle="pill" href="#bulk_update"><i class="glyphicon glyphicon-upload"></i>Bulk Promote</a></li>
                         </ul>
                            
                        </div>
                    
            </div>
            

            
            
            
            
            
             <div class="box-body">
                
                 <div class="tab-content">


                     <!--//---------------------------------Student Information -----------------------------------------------------------------//-->                    

                                     <div class="tab-pane fade in active" id="stud_info">

                                                                  <div class="box-body">
                                                                   <div class="col-lg-12">
                                                                     <div class="col-lg-12" style="text-align:right;"><button class="btn btn-success" id="add_student"> <i class="fa fa-plus-circle fa-lg"></i> Add Student</button></div>

                                                                   </div>
                                                                 </div>


                                                                 <div class="box-body  ">
                                                                 <div class="col-sm-12">


                                                                   <form id="frmstudent" role="form" method="POST" style="width:100%">
                                                                      <?php 
//                                                                       foreach($schools as $school)
//                                                                       {
//                                                                         $school_name[$school->id] = $school->description;
//                                                                       }
                                                                     ?>
                                                                       <div class="table-responsive">
                                                                     <table id="studlist1" class="table table-bordered table-striped" style="width:100%">
                                                                       <thead >
                                                                       <tr>
                                                                         <th style="width:5%">Student ID</th>
                                                                         
                                                                         <th style="width:10%">Admission No.</th>
                                                                         <th style="width:10%">Student Name</th>
                                                                         <th style="width:10%">Father's Name</th>
                                                                         <th style="width:10%">DOB</th>
                                                                         <th style="width:5%">Category</th>
                                                                         <th style="width:10%">Email Address</th>
                                                                         <th style="width:10%">Phone No.</th>
                                                                         <th style="width:10%">Class Name</th>
                                                                         <th style="width:10%">Section Name</th>
                                                                         <th style="width:10%">Action</th>
                                                                       </tr>
                                                                       </thead>
                                                                       <tbody>
                                                                       <?php 
                                                                       if(isset($data) && count($data) > 0){
                                                                       foreach ($data as $student) {?>
                                                                       <tr>
                                                                         <td style="width:5%"><?php echo $student->id; ?></td>
                                                                    
                                                                         <td style="width:10%"><?php echo $student->admission_no; ?></td>
                                                                         <td style="width:10%"><?php echo $student->first_name; ?></td>
                                                                         <td style="width:10%"><?php echo $student->father_name; ?></td>
                                                                         <td style="width:5%"><?php echo  $student->dob; ?></td>
                                                                         <td style="width:10%"><?php echo $student->cat_name; ?></td>
                                                                         <td style="width:10%"><?php echo $student->email_address; ?></td>
                                                                         <td style="width:10%"><?php echo $student->phone; ?></td>
                                                                         <td style="width:10%"><?php echo $student->class_name; ?></td>
                                                                         <td style="width:10%"><?php echo $student->sec_name; ?></td>

                                                                         <td style="width:10%">
                                                                           <a class="btn" onclick="update_student('<?php echo $student->id?>','<?php echo $student->admission_no?>','<?php echo $student->first_name?>','<?php echo $student->middle_name?>','<?php echo $student->last_name?>','<?php echo $student->email_address?>','<?php echo $student->phone?>','<?php echo $student->class_id?>','<?php echo $student->section_id?>',<?php echo $student->stud_category?>,'<?php echo $student->father_name?>','<?php echo $student->dob?>','<?php echo $student->course_id?>');">
                                                                             <i class="fa fa-edit"></i> Edit
                                                                           </a>
                                                                              <?php if ($this->session->userdata('user_group_id') == 1 || $this->session->userdata('user_group_id') == 2){?>
                                                                                 <a class="btn" onclick="deleteStudent('<?php echo $student->id;?>','<?php // echo $student->school_id;?>')">
                                                                                   <i class="fa fa-delete"></i> Delete
                                                                                 </a>
                                                                              <?php } ?> 
                                                                         </td>
                                                                       </tr>
                                                                       <?php } 
                                                                       }
                                                                       ?>
                                                                       </tbody> 

                                                                     </table>
                                                                       </div>
                                                                      </form>
                                                                     </div>
                                                                 </div>
                                                                 <!-- /.box-body -->

                                      </div>
                     
                     
                                        <!--//-------------------------------------------------Student Upload-------------------------------------------------------------//-->
                                        <div class="tab-pane fade" id="upload_admission">

                                                                 <div class="box-header">
                                                                 <div class="" style="float:right;">
                                                                 <!--<a type='button' class="btn btn-info" name='dwnld' id='dwnld' value='Download Format'></a>-->

                                                                 <a  class="btn btn-info" id="download" href="<?php echo base_url('School/download_format');?>" style="background:#46b8da;margin-top: 5%">
                                                                         <span class="glyphicon glyphicon-download"></span>Download format
                                                                 </a>
                                                                 </div>
                                                                 </div>
                                                                 <!-- /.box-header -->

                                                                 <div class="box-body">
                                                                 <div class="col-lg-6">
                                                                 <?php // echo $message;?>
                                                                 </div>


                                                                 </div>

                                                                 <div class="box-body">
                                                                            <form enctype='multipart/form-data' id='form' class="form-horizontal" action="<?php // echo base_url('school/admission'); ?>" method='post'>

                                                                              <div class="box-body">
                                                                                <div class="col-lg-3">Select CSV File to upload</div>
                                                                                <div class="col-lg-3">
                                                                                  <input class="form-control" size='50' type='file' name='admission_upload'>
                                                                                </div>
                                                                                <div class="col-lg-6"><input type='submit' class="btn btn-success" name='submit' id='submit' value='Upload'></div>
                                                                              </div>
                                                                            </form>
                                                                     </div>
                                                                 
                                                                 <div class="box-body">
                                                                     <fieldset>
                                                                         <legend><u>Instructions</u></legend>
                                                                         
                                                                          <p>
                                                                             1.)  First Download the Format (File Should be in CSV( Comma Separated Delimited) Format).
                                                                         </p>
                                                                         <p>
                                                                             2.)  Enter Class Code like (e.g for nursery => NUR , for lkg => LKG, for class I =>1 , for class II =>2  and so on) in class column (as created in Class Link).
                                                                         </p>
                                                                         <p>
                                                                             3.)  Enter Section Id instead of Section Name in Section Column (as created in Section Link).
                                                                         </p>
                                                                         <p>
                                                                             4.)  Enter Course Code in Course Column for Class 11 and 12 (as created in Course Link).
                                                                         </p>
                                                                         <p>
                                                                             5.)  Dob should in the format of "dd-mm-YYYY" or "dd/mm/YYYY" e.g( 02-10-2017).
                                                                         </p>
                                                                     </fieldset>
                                                                 </div>
                                    </div>
                                        
                                     <!--//-------------------------------------------------Student Upload-------------------------------------------------------------//-->
                                        <div class="tab-pane fade" id="download_admission">

                                                                
                                                                 
                                            <div class="box-header">
                                                
                                            </div>            
                                            <div class="box-header">
                                                
                                            </div>
                                                    <div class="box-body">
                                                               
                                                        <div class="col-lg-1"><label>Download:</label></div>
                                                                <div class="col-lg-2">
                                                                    <select class="form-control" name="" id="export_condn">
                                                                        <option value="all">All</option>
                                                                        <?php foreach($aclass as $cls){ ?>
                                                                            <option value="<?php echo $cls->id; ?>"> <?php echo $cls->class_name.' &nbsp;&nbsp;  Students'; ?></option>
                                                                            <?php } ?>
                                                                    </select>
                                                                </div>
                                                        <!--<input type="hidden" id="cond_hidden" value="all">                                                        <div class="col-lg-2">
                                                            <label>Students</label>
                                                        </div>-->
                                                        <?php // $con=?>
                                                                <div class="col-lg-6" id="div_change">
                                                                   <a class="btn btn-success" id="student_export" href="<?php echo base_url('School/exportcsv/all');?>" download>
                                                                            <i class="fa fa-cloud-download fa-lg"></i>&nbsp; Export 
                                                                    </a>
                                                                </div>
                                                                 
                                                        </div>
                                                                 
                                                                 
                                    </div>    
                                        
                                        <!-- ---------------------------------------------- Bulk Promote --------------------------------------- -->
                                        
                                                            <div class="tab-pane fade" id="bulk_update">
                                                                <form id="transfer" name="transfer" method="POST">
                                                                    <div class="row" style="margin-bottom: 10px;">  
                                                                    <div class="col-lg-2">From Class</div>
                                                                    <div class="col-lg-3">
                                                                        <select name="from_class" id="from_class" class="form-control">
                                                                        <option value="">Select Class</option>
                                                                           <?php foreach($aclass as $cls){ ?>
                                                                            <option value="<?php echo $cls->id; ?>"> <?php echo $cls->class_name; ?></option>
                                                                            <?php }  ?>
                                                                        </select>
                                                                    </div>
                                                                    
                                                                 
                                                                    <div class="col-md-1" style="margin-left:50px;">To Class</div>
                                                                    <div class="col-md-3">
                                                                        <select name="to_class" id="to_class" class="form-control">
                                                                            <option value="">Select Class</option>
                                                                            <?php foreach($aclass as $cls){ ?>
                                                                            <option value="<?php echo $cls->id; ?>"> <?php echo $cls->class_name; ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                    </div>
                                                                    
                                                                    <div class="col-md-2"> 
                                                                        <input type="button" class="btn btn-success" id="promote" value="Promote">
                                                                    </div>
                                                                    </div>
                                                                <div id="div_transfer_student" class="row">
                                                                    <div class="col-md-12">
                                                                        <center>
                                                                   <table id="student_promote" class="table table-bordered table-striped table-fixed"  style="margin-top: 25px; width:60%">
                                                                       <thead>
                                                                           <tr>
                                                                               <th>  </th>
                                                                               <th>Admission No</th>
                                                                               <th> Student Name </th>
                                                                           </tr>
                                                                       </thead>
                                                                    </table>
                                                                        </center>
                                                                    </div>
                                                                </div>
                                                                </form>
                                                                
                                                            </div>
                                               </div>


                                     </div>
                </div> 
              </div>

<div class="modal fade" id="modal_form" name="modal_form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" id="modal_header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Student</h4>
            </div>
            <div class="modal-body" id="modal-body">
                <form action="#" id="add_stud" name="add_stud" class="form-horizontal">

                    <div class="form-body">

                      <div class="form-group">
                            <div class="col-md-3"></div>
                            <div class="col-md-9" id="errmodal">
                              
                            </div>
                        </div>


                       <div id="studentid"><input type="hidden" id="htnstudentid" name="student_id" value=""></div>
                       <div id="admissioncode"><input type="hidden" id="htnadmissioncode" name="admission_code" value=""></div>
                       

                       <div class="form-group" id="admission_no">
                           <label class="control-label col-md-3">Admission No</label> 
                            <div class="col-md-9">
                           <input id="admissionNo" name="admissionNo" placeholder="Admission No" class="form-control" type="text">
                                <span class="help-block"></span></div>
                        </div>
                       
                       
                        
                        <div class="form-group">
                            <label class="control-label col-md-3">First Name</label>
                            <div class="col-md-9">
                                <input id="firstName" name="firstName" placeholder="First Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="control-label col-md-3">Middle Name</label>
                            <div class="col-md-9">
                                <input id="midName" name="midName" placeholder="Middle Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Last Name</label>
                            <div class="col-md-9">
                                <input id="lastName" name="lastName" placeholder="Last Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <label class="control-label col-md-3">Father's Name</label>
                            <div class="col-md-9">
                                <input id="fName" name="fName" placeholder="Father's Name" class="form-control" type="text">
                                <span class="help-block"></span>
                            </div>
                        </div>
                       
                       <div class="form-group">
                            <label class="control-label col-md-3">D.O.B</label>
                            <div class="col-md-9">
                                <!--<input id="dob1" name="dob1" placeholder="Date of birth" class="form-control" type="text">-->
                                <!--<span class="help-block"></span>-->
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' class="form-control" id="dob1" name="dob1" value="" placeholder="Date Of Birth">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                </div>
                                 <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Email Address</label>
                            <div class="col-md-9">
                                <input id="emailadd" name="emailadd" placeholder="Email Address" class="form-control" type="text" onchange="isValidEmailAddress()">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-3">Contact No</label>
                            <div class="col-md-9">
                                <input id="contactNo" name="contactNo" placeholder="Contact No." class="form-control" type="text" onchange="check_contact()">
                                <span class="help-block"></span>
                            </div>
                        </div>
                   

                        <div class="form-group">
                            <label class="control-label col-md-3">Class Name</label>
                            <div class="col-md-9">
                                <select name="lstClass" id="lstClass" class="form-control">
                                  <option value="">Select Class</option>
                                  <?php
                                    foreach($aclass as $class){
                                      ?>
                                      <option value="<?php echo $class->id;?>"><?php echo $class->class_name;?></option>
                                      <?php
                                    }
                                  ?>
                                </select>
                                <span class="help-block"></span>
                            </div> 
                        </div>
                       <div class="form-group">
                            <label class="control-label col-md-3">Section Name</label>
                            <div class="col-md-9">
                                <select name="section" id="lstSection" class="form-control">
                                  <option value="">Select Section</option>
                                  <?php
                                    foreach($asection as $sec){
                                      ?>
                                      <option value="<?php echo $sec->id;?>"><?php echo $sec->sec_name;?></option>
                                      <?php
                                    }
                                  ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                       <div class="form-group">
                            <label class="control-label col-md-3">Category</label>
                            <div class="col-md-9">
                                <select name="category" id="1stcategory" class="form-control">
                                  <option value="">Select Category</option>
                                  <?php
                                    foreach($acategory as $category1){
                                      ?>
                                      <option value="<?php echo $category1->id;?>"><?php echo $category1->cat_name;?></option>
                                      <?php
                                    }
                                  ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>
                       
                       
                        <div class="form-group">
                            <label class="control-label col-md-3">Course</label>
                            <div class="col-md-9">
                                <select name="1stcourse" id="1stcourse" class="form-control">
                                  <option value="0">Select Course</option>
                                  <?php
                                    foreach($acourse as $course){
                                      ?>
                                      <option value="<?php echo $course->id;?>"><?php echo $course->course_name;?></option>
                                      <?php
                                    }
                                  ?>
                                </select>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        
                        
                    </div>
                </form>
            </div>
            <div class="modal-footer" id="modal-footer">
                <button type="button" id="btn_save" onclick="save()" class="btn btn-success">Save</button>
                <!--<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>-->
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->
                
                
               
                 
            


</div>
      </div>



<script>
 //********************************* Upload Student ***********************************************//
   $(document).ready(function()
   {
         
                
                $('#export_condn').click(function()
                {
                    var val=$(this).val();
                    $('#student_export').attr('href','<?php echo base_url('School/exportcsv');?>'+'/'+val);
                    

                });
                
                $('#submit').click(function()
                {
//                            alert('hi');
                          var r = confirm("Are you sure you want to upload this data?");
                          $('#submit').val('Uploading.....');
                          if(r == true)
                          {  
                              
                                    
                                  $('#submit').val('Uploading.....');   
                                    
                                    var data = new FormData($('#form')[0]);
//                                    alert(data);
                                    $.ajax
                                    ({
                                                url: '<?php echo base_url('school/admission'); ?>',
                                                dataType: "text",
                                                method: 'post',
                                                data:data,
                                                async : false,
                                                contentType:false,
                                                processData:false,
                                                cache:false,
                                                success: function(data) {
//                                                    alert('g');
                                                       window.location.reload();
                                                },
                                                 error: function(data)
                                                    {
                                                        alert('error');
                                                    }
                                     });

                                    
                                  return true;
                          }
                          else
                          {
                                    return false;
                          }
                });
                
                $('#from_class').change(function()
                {
                    var clas=this.value;
//                    alert(clas);
                    $.ajax({
                       type:'POST',
                       url:'<?php echo base_url('school/load_bulk_promote')?>',
                       data:
                       {
                           class:clas,
                       },
                       success:function(data)
                       {
                           $('#div_transfer_student').html(data);
                       },
                       error:function(req,status)
                       {
                           alert('error while loading');
                       }
                       
                    });
                });
                
                $('#promote').click(function()
                {  
                     var to_cls=$('#to_class').val();
                     var val=0;
                     $('input:checked[name="chk_row[]"]').each(function() 
                      {
                        
                            var $this = $(this);
                            if($this.is(":checked"))
                            {
                                val=1;
                                return;
                               
                            }
                            
                      });

                       if(to_cls=='' || val==0) 
                       {
                           alert('please select class and student to be promoted');
                       }
                       
                       else
                       {
                           $.ajax({
                              type:'POST',
                              url:"<?php echo base_url('school/promote_class')?>",
                              data:$('#transfer').serialize(),
                              datatype:'text',
                              success:function(data)
                             {
                                alert('Successfully Promoted');
                             },
                             error:function(req,status)
                             {
                                 alert('Error while promoting');
                             }
                           });
                       }
                       
                });
                
                
              $('#add_student').click(function()
                {
                        save_method = 'add';
                        $('#add_stud')[0].reset(); // reset form on modals
    //                    $('#admission_no').empty();
    //                    
    //                   $("#admission_no").append('<label class="control-label col-md-3">Admission No.</label>\n\
    //                    <div class="col-md-9"><input id="admissionNo" name="admissionNo" placeholder="Admission No" class="form-control" type="text">\n\
    //                    <span class="help-block"></span></div>');
                        $('.form-group').removeClass('has-error'); // clear error class
                        $('.help-block').empty(); // clear error string
                        clear_error();
                        $('#modal_form').modal('show'); // show bootstrap modal
                        $('.modal-title').text('Student Information'); // Set Title to Bootstrap modal title
                });  
                
                
                var indication = '<?php echo $indication;?>';
            if(indication=='class_datatable')
            {
                            $('#studlist1').DataTable(
                            {

//                                  dom: 'Bfrtip',
//                                  buttons: [
//                                                 {
//                                                     extend: 'collection',
//                                                     text: 'Export',
//                                                     buttons: [
//                 //                                        'copy',
//                                                         'excel',
//                                                         'csv',
//                                                         'pdf',
//                                                         'print'
//                                                     ]
//                                                 }
//                                             ],
//                                             serverSide: true,  
                             });
            }
            else{
                
            $('#studlist1').DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": true,
                serverSide: true,
		ajax: {
			url: '<?php echo base_url('school/paged_data'); ?>',
			type: 'POST',
                        data: { where:'status="Y"'}
		},
//                "dom": 'Bfrtip',
//                 buttons: [
//                                {
//                                    extend: 'collection',
//                                    text: 'Export',
//                                    buttons: [
////                                        'copy',
//                                        'excel',
//                                        'csv',
//                                        'pdf',
//                                        'print'
//                                    ]
//                                }
//                            ],
		
	});
        }
        
        
        
        
        $('#datetimepicker1').datetimepicker({
               todayBtn: true,
               autoclose: true,
                 pickerPosition: "bottom-left",
//                  pickTime: false,
                    format:'yyyy-mm-dd',
                  minView: 2,
                 
//                 defaultViewDate: {year:2017, month:4, day:12},
            });
                
  });

  function select_class(){
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url('school/get_class'); ?>',
        data: {
            school:$("#school_name option:selected").val()
        },
        success: function(res) {
          $('#class_name_div').empty();
         $('#class_name_div').append(res);
        },
        error: function(req, status){
            return false;
        }
    });
  }
  
  function select_section(){
    $.ajax({
        type: 'POST',
        url: '<?php echo base_url('school/get_section'); ?>',
        data: {
            school:$("#lstSection option:selected").val()
        },
        success: function(res) {
          $('#section_name_div').empty();
         $('#section_name_div').append(res);
        },
        error: function(req, status){
            return false;
        }
    });
  }
  
 //*****************************************Student Information**********************************************************************// 
  
//  $(document).ready(function()
//  {
////
////            $('#studtable').hide();
////            $(".dropdown-toggle").dropdown();
//            
//            
//            
//                
//    
//            
////
//  });

function update_student(studid,admission_no,firstname,middle_name,lastname,emailadd,contactno,class_id,section,category,fathername,bday,course)
{
                $('#add_stud')[0].reset(); // reset form on modals
                save_method = 'update';
                $('.form-group').removeClass('has-error'); // clear error class
                $('.help-block').empty(); // clear error string
                $('#htnstudentid').val(studid);
//                $('#htnadmissioncode').val(admission_code);
                $('#admissionNo').val(admission_no); 
                $('#firstName').val(firstname);
                $('#midName').val(middle_name);
                $('#lastName').val(lastname);
                $('#fName').val(fathername); 
                $('#dob1').val(bday);
                $('#emailadd').val(emailadd);
                $('#contactNo').val(contactno);
                $('#lstClass').val(class_id).prop('selected', true);
                $('#lstSection').val(section).prop('selected', true);               
                $('#1stcategory').val(category).prop('selected', true);
                $('#1stcourse').val(course).prop('selected', true);
                clear_error();
                $('#modal_form').modal('show'); // show bootstrap modal
                $('.modal-title').text('Update Student Information'); // Set Title to Bootstrap modal title     

    }
//    
    
   function isValidEmailAddress(emailadd)
    {               
                alert('hi');
                var pattern= /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
                return pattern.test(emailadd);
    }
  

    
    function clear_error()
    {
                $('#errmodal').empty();
              //  $('#admission_no').empty();
                $('#contactNo').css('border-color','#d2d6de');
                $('#emailadd').css('border-color','#d2d6de');
                $('#lastName').css('border-color','#d2d6de');
                $('#firstName').css('border-color','#d2d6de');
                $('#middleName').css('border-color','#d2d6de');
                $('#fname').css('border-color','#d2d6de');
                $('#dob').css('border-color','#d2d6de');
                $('#btnSave').text('save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
    }
    
    
    
    function save()
    {
                var r = confirm("Are you sure you want to save this record?");
                if(r ===true)
                {
                    
                                        $('#btnSave').text('saving...'); //change button text
                                        $('#btnSave').attr('disabled',true); //set button disable 


                        //
                                        var errmsg = '';
                                        if( $('#firstName').val() ==='')
                                        {
                                                            if(errmsg ===''){
                                                              errmsg = 'First Name is a required field.<br />';
                                                            }else{
                                                              errmsg += 'First Name is a required field.<br />';
                                                            }

                                                            $('#firstName').css('border-color','Red');
                                        }
                                        

                                        if(save_method ==='add')
                                            {


                                                            if($("#admissionNo").val() ==='')
                                                            { 
                                                                           if(errmsg ===''){
                                                                             errmsg = 'Admission Code is a required field.<br />';
                                                                           }else{
                                                                             errmsg += 'Admission Code is a required field.<br />';
                                                                           }
                                                                           $('#admissionNo').css('border-color','Red');
                                                            }
                                                            else if($("#admissionNo").val()!='')
                                                            {
                                                                
                                                                            $.ajax({
                                                                                        url : "<?php echo site_url('school/check_admission_no')?>",
                                                                                        type: "POST",
                                                                                        data: { admsn:$("#admissionNo").val()},
                                                                                        dataType: "text",
                                                                                        success: function(data)
                                                                                        { 
//                                                                                            alert('hi');
                                                                                           
                                                                                                if(data==0)
                                                                                                {
//                                                                                                     alert(data);
                                                                                                            if(errmsg ==='')
                                                                                                            {
                                                                                                                        errmsg = 'Admission No already exist.<br />';
                                                                                                            }
//                                                                                                            
                                                                                                            else
                                                                                                            {
                                                                                                                        errmsg += 'Admission No already exist.<br />';
                                                                                                            }
                                                                                                            $('#admissionNo').css('border-color','Red'); 
                                                                                                            alert('Admisson no already exists.');
                                                                                                                     
                                                                                                }
                                                                                               else if(data==1)       
                                                                                               {
                                                                                                 url = "<?php echo site_url('school/add_student')?>";
                                                                                               }
      
                                                                                                }
                                                                                    });
                                                                        
                                                            }


                                            }
                                            
                                            
//                                            alert('err'+errmsg);
//=====================================================  save======================================//

                                        if(errmsg ==='')
                                        {
                                                        clear_error();

                                                         if(save_method ==='add')
                                                          {





                                                                         $('#btnSave').text('saving...');
                                                                         url = "<?php echo site_url('school/add_student')?>";
                                                          }
                                                          else
                                                          {
                                                              $('#btnSave').text('saving...');

                                                            url = "<?php echo site_url('school/update_student_info')?>";  

                                                          }

                                                              var dataval=$('#add_stud').serialize();

                                                          // ajax adding data to database
                                                          $.ajax({
                                                              url : url,
                                                              type: "POST",
                                                              data: dataval,
                                                              dataType: "text",
                                                              success: function(data)
                                                              {

                                      //                            alert(data);
                                  //
                                  //                                if(data ==1) //if success close modal and reload ajax table
                                  //                                {
                                                                      $('#modal_form').modal('hide');
//                                                                      $('#frmstudent').submit();
                                                                      window.location.reload();
                                      //                                window.location.href="<?php // echo base_url('school/template');?>";
                                  //                                }

                                  //                                $('#btnSave').text('save'); //change button text
                                  //                                $('#btnSave').attr('disabled',false); //set button enable 

                                                              }
                                                          });
                                          }else{
                                            $('#errmodal').css('color','Red');
                                            $('#errmodal').append("<div>"+errmsg+"</div>");
                                            $('#btnSave').text('save'); //change button text
                                            $('#btnSave').attr('disabled',false); //set button disable       }
                                          }


//====================================================================================================================//
                  }
                  else
                  {
                    return false;
                  }
      }
      
      
      
        function view_student_fees(school,id, status)
        {
                  if(status ===0)
                  {
                    alert('Student is not yet registered.');
                  }
                  else
                  {
//                    window.location.href = "<?php // echo site_url('school/student_fees')?>/"+id+"/"+school;
                  }
        }
        
        
        function deleteStudent(id)
        {

                 var r = confirm('Are you sure you want to delete this record?');
                 if(r ===true)
                 {
                   var url = "<?php echo site_url('school/delete_student')?>";
                   var dataval = { 'studentid' : id} ;

                   $.ajax({
                         url : url,
                         type: "POST",
                         data: dataval,
                         dataType: "JSON",
                         success: function(data)
                         {
                             window.location.reload();

     //                      $('#frmstudent').submit();
                         }
                     });
                 }
                 else
                 {
                   return false;
                 }

        }
        
        
        
        function select_category(category='')
        {


                $.ajax({
                  type: 'POST',
                  url: '<?php echo base_url('school/get_category'); ?>',
                  data: {
                      category: category,
                  },
                  success: function(res) {
                    $('#category_div').empty();
                   $('#category_div').append(res);
                  },
                  error: function(req, status){
                      return false;
                  }
              });

          }
          
             function select_course(course='')
            {
                  $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('school/get_course'); ?>',
                    data: {
                        course:course,
                    },
                    success: function(res) {
                      $('#course_div').empty();
                     $('#course_div').append(res);
                    },
                    error: function(req, status){
                        return false;
                    }
                });

            } 
          
          
             function select_section(section='')
            {


                  $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('school/get_section'); ?>',
                    data: {
                        section:section,
                    },
                    success: function(res) {
                      $('#section_div').empty();
                     $('#section_div').append(res);
                    },
                    error: function(req, status){
                        return false;
                    }
                });

            } 
            
            
            function select_class(class_id = '',category ='',section='')
            {
              $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('school/get_class'); ?>',
                    data: {

                        class_id: class_id
                    },
                    success: function(res) {
                      $('#class_name_div').empty();
                     $('#class_name_div').append(res);
                    },
                    error: function(req, status){
                        return false;
                    }
                });

                select_category(category);
                select_section(section);


              }
              
              
                function check_contact(contactNo)
                {
//                    alert('hi');
//                   var contact= document.getElementById('contactNo');
                   var phone = '/^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/';
                   if(contactNo.value.match(phone))
                   {  
                       alert('hello');
                       return true;
                   }
                   else
                   {
                       alert('please enter valid contact number');
                   }
               }
            

</script>
