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
            <select class="form-control" id="examname">
               <option value="">&nbsp;&nbsp;-- Select Examination--&nbsp;&nbsp;</option>
              <?php
                foreach ($examination as $key => $exam_value) {
              ?>
                <option value="<?php echo $exam_value->id;?>"><?php echo $exam_value->name;?></option>
              <?php           
                }
              ?>
            </select>
          </div>

          <div class="col-md-2 form-group">
            <label for="exampleFormControlSelect1">Class</label>
            <select class="form-control" id="class">
               <option value="">&nbsp;&nbsp;-- Select Class--&nbsp;&nbsp;</option>
              <?php
                foreach ($class as $key => $class_value) {
              ?>
                <option value="<?php echo $class_value->id;?>"><?php echo $class_value->class_name;?></option>
              <?php 
                }
              ?>
            </select>
          </div>

          <div class="col-md-2 form-group">
            <label for="exampleFormControlSelect1">Section</label>
            <select class="form-control" id="section">
               <option value="">&nbsp;&nbsp;-- Select Section--&nbsp;&nbsp;</option>
            </select>
          </div>

          <div class="col-md-1 form-group">
              <label for="exampleFormControlSelect1">&nbsp;</label>
              <a title="VIEW RESULT" class="btn btn-success form-control" id="view_result" title=" View Result"> <i class="fa fa-eye fa-lg"></i> </a>
          </div>
          
        </div>
      </form>

       
    </div>
  </div>

  <div class="box" id="viewdatabox">
    <div class="box-body" id="viewdata">
      <p>No data available in table</p>
    </div>  

    <div class="box-body" id="display" style="display:none;">
      
    </div>   
  </div>
  

</div>



<script>


$('#class').on('click change keyup',function(){
    var value = $(this).val();
    $.ajax({
        url : "<?php echo site_url('academics/Results/GetSection')?>",
        type: "POST",
        data: {id:value},
        success: function(data)
        {         
          $('#section').empty();
          $("#section").append(data);
        },        
    });
});




$('#view_result').click(function(){
    var exam = $('#examname').find('option:selected').val();
    var clas = $('#class').find('option:selected').val();
    var sect = $('#section').find('option:selected').val();
   
    $.ajax({
        url : "<?php echo site_url('academics/Results/GetData')?>",
        type: "POST",
        data: {exam:exam,clas:clas,sect:sect},
        success: function(data)
        {       
          $('#viewdatabox').html(data);
        },        
    });    
});


function view(id,e_id,c_id,s_id,name)
{
  $('.stuname').text(name);
  $('#myModals').modal('show'); 
   $.ajax({
        url : "<?php echo site_url('academics/Results/Getresu')?>",
        type: "POST",
        data: {id:id,examid:e_id,classid:c_id,sectid:s_id},
        success: function(data)
        {         
          $('#datass').html('');
          $("#datass").html(data);
        },        
    });
}

</script>