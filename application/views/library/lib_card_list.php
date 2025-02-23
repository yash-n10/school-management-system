  <div class="form-group has-feedback">
    <div class="box box-primary">
      <div class="box-body">    
          <form class="form-inline" action="<?php echo base_url('library/print/Lib_card/prints');?>" target="_blank" method="POST">
            <div class="row">
              <div class="col-md-1">
                <label for="year">Year:</label>
              </div>
              <div class="col-md-2">
                <select id="year" name="year" class="form-control" required="">                             
                    <option value="all">Select Year</option>
                    <?php foreach($session as $session_value){?>
                    <option value="<?php echo $session_value->id;?>"><?php echo $session_value->session;?></option>
                    <?php }?>
                </select>
              </div>
              <div class="col-md-1">
                <label for="month">Class:</label>
              </div>
              
              <div class="col-md-2">
                <select id="class" name="class" class="form-control" required="" onchange="get_sec(this)">
                  <option value="all">Select Class</option>  
                  <?php 
                    foreach($class as $class_val)
                    {
                  ?>
                    <option value="<?php echo $class_val->id;?>"><?php echo $class_val->class_name;?></option>
                  <?php 
                    }
                  ?>
                </select>
              </div>
              <div class="col-md-1">
                <label for="email">Section:</label>
              </div>
              
              <div class="col-md-2">
                <select id="section" name="section" class="form-control" required="" onchange="get_student(this)">
                  <option value="all">Select Section</option>  
                </select>
              </div>

              <div class="col-md-1">
                <label for="email">Admission No:</label>
              </div>
              
              <div class="col-md-2">
                <select id="students" name="students" class="form-control" required="">
                  <option value="all">Select Admission No</option>  
                </select>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="col-md-12">
                <button type="submit" class="btn btn-primary pull-right">Submit</button>
              </div>
            </div>
          </form>
      </div>
    </div>
 <!--    <div class="box box-primary">
      <div class="box-body">
        <div class="print" id="print">
        </div>
      </div>
    </div>
    <br>
    <div class="box box-primary">
      <div class="box-body">
      
        	<a href='<?php echo base_url('library/Lib_card/add'); ?>' class='pull-right'>
        		<button class="btn btn-add" id="add_record" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Add Item">
        			<i class="fa fa-plus-circle fa-lg"></i>&nbsp; 
        		</button>
        	</a><br /><br />
  	
          <div class="table-responsive">
          <table class="table table-bordered table-striped" id="period">
            <thead style="background:#99ceff;">
              <tr>
                <th>Sl No.</th>
                <th>Student Name.</th>
                <th>Class</th>
                <th>Library Card No.</th>
                <th>No. Of Books</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
  		  <?php
  		    $i = 1;
  		    foreach($library as $data){
  		  ?>
  		   <tr>
  		     <td><?php echo $i; ?></td>
  		     <td><?php echo $data->first_name; ?></td>
  		     <td><?php echo $data->class; ?></td>
  		     <td><?php echo $data->lib_card_no; ?></td>
  		     <td><?php echo $data->no_book; ?></td>
  		     <td>
  			   <a class="btn a-view" title="View" onclick="view('<?php echo $data->adm_no; ?>','<?php echo $data->first_name; ?>','<?php echo $data->middle_name; ?>','<?php echo $data->last_name; ?>','<?php echo $data->section; ?>','<?php echo $data->roll; ?>','<?php echo $data->lib_card_no; ?>','<?php echo $data->no_book; ?>','<?php echo $data->days_allow; ?>','<?php echo $data->late_fine; ?>','<?php echo $data->card_exp; ?>')"><i class="fa fa-eye"></i></i></a>
  			   <a class="btn a-edit" title="Edit" onclick="edit(<?php echo $data->id; ?>,'<?php echo $data->no_book; ?>','<?php echo $data->days_allow; ?>','<?php echo $data->late_fine; ?>','<?php echo $data->card_exp; ?>')"><i class="fa fa-edit"></i></a>
  			 </td>
  		   </tr>
  			<?php $i++; } ?>
            </tbody>
          </table>
          </div>
         
          <div id="ViewModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h3 class="modal-title" id="modal-title">View</h3>
                </div>
                    
                <div class="modal-body">
                  <div id='view_grn'></div>
                </div>
  			  
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
       
  	  
  	  
  	  
          <div id="editModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-xs ">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h3 class="modal-title" id="modal-title">Edit</h3>
                </div>    
                <div class="modal-body">
                  <div id='edit_grn'></div>
                </div>
  			  
                <div class="modal-footer">
                  <button type="button" class="btn btn-success btn-xs" data-dismiss="modal" onclick="update()">Update</button>
                  <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>
    </div> -->
  </div>

  <script>
  

  function get_student(m)
  {
    var year = $('#year').val();
    var classs = $('#class').val();
    var section = m.value;
    $.ajax({
      url: "<?php echo base_url('library/print/Lib_card/get_student'); ?>",
      type: "POST",
      data: {id:section,classs:classs,year:year},
      success: function(data)
      {
        $('#students').html(data);  
      }
    });
  }

  function get_sec(m)
  {
    var classs = m.value;
    $.ajax({
      url: "<?php echo base_url('library/print/Lib_card/get_sec'); ?>",
      type: "POST",
      data: {id:classs},
      success: function(data)
      {
        $('#section').html(data);
        console.log(data);  
      }
    });
  }

  $(function (){
      var table=$('#period').DataTable({
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

  function edit(id,no_book,days_allow,late_fine,card_exp){
  	$.ajax({
  		url: "<?php echo base_url('library/print/Lib_card/edit'); ?>",
  		type: "POST",
  		data: {id:id,no_book:no_book,days_allow:days_allow,late_fine:late_fine,card_exp:card_exp},
  		success: function(data){
  			$("#edit_grn").html(data);
  			$("#editModal").modal('show');
  		}
  	});
  }

  function update(){
  	var no_book = $("#no_book").val();
  	var days_allow = $("#days_allow").val();
  	var late_fine = $("#late_fine").val();
  	var card_exp = $("#card_exp").val();
  	var id = $("#id").val();
  	$.post('<?php echo base_url('library/Lib_card/update'); ?>',{no_book:no_book,days_allow:days_allow,late_fine
  	:late_fine,card_exp:card_exp,id:id},function(data){
  		alert('Update Successfully');
  		location.reload();
  	});
  }

  function view(adm_no,first_name,middle_name,last_name,section,roll,lib_card_no,no_book,days_allow,late_fine,card_exp){
  	$.post('<?php echo base_url('library/Lib_card/view'); ?>',{adm_no:adm_no,first_name:first_name,middle_name:middle_name,last_name:last_name,section:section,roll:roll,lib_card_no:lib_card_no,no_book:no_book,days_allow:days_allow,late_fine:late_fine,card_exp:card_exp},function(data){
  		$("#view_grn").html(data);
  		$("#ViewModal").modal('show');
  	});
  }
  </script>