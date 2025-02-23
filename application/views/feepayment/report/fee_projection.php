<div class="form-group has-feedback">
        <div class="box">
            
            <div class="box-body">
                        <div class="tab-content" id="month">

                                            <?php if ($school_group='ARMY') { ?>

                                             <div class="col-sm-12 col-md-12">
                                                <label class="control-label col-md-2">Month Name</label>
                                                <div class="col-sm-3 col-md-3">
                                                    <select name="month" id="lst_Month" class="form-control">
                                                      <option value="">Select Month</option>
                                                          <option value="04">April</option>
                                                          <option value="05">May</option>
                                                          <option value="06">June</option>
                                                          <option value="07">July</option>
                                                          <option value="08">August</option>
                                                          <option value="09">September</option>
                                                          <option value="10">October</option>
                                                          <option value="11">November</option>
                                                          <option value="12">December</option>
                                                          <option value="01">January</option>
                                                          <option value="02">February</option>
                                                          <option value="03">March</option>


                                                    </select>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                        <?php } else{ ?>
                                             <div class="col-sm-12 col-md-12">
                                                <label class="control-label col-md-2">Month Name</label>
                                                <div class="col-sm-3 col-md-3">
                                                    <select name="month" id="lst_Month" class="form-control">
                                                      <option value="">Select Month</option>
                                                          <option value="04">April</option>
                                                          <option value="05">May</option>
                                                          <option value="06">June</option>
                                                          <option value="07">July</option>
                                                          <option value="08">August</option>
                                                          <option value="09">September</option>
                                                          <option value="10">October</option>
                                                          <option value="11">November</option>
                                                          <option value="12">December</option>
                                                          <option value="01">January</option>
                                                          <option value="02">February</option>
                                                          <option value="03">March</option>


                                                    </select>
                                                    <span class="help-block"></span>
                                                </div>
                                            </div>
                                        <?php } ?>



                                            <div class="col-sm-12 col-md-12"  id="month_load">
                                                   
                                                            <form id='frmtemplate1' role="form" method="POST">
                                                             <table id="studentlist1" class="table table-bordered table-striped" style="margin-top: 25px;">
                                                                 <thead>
                                                                 <tr>
                                                                     <th> SNo. </th>
                                                                     <th> Class </th>
                                                                     <th> Section </th>
                                                                     <th> Month </th>
                                                                     <th> Strength </th>
                                                                     <th> Estimated Fee </th>
                                                                     <th> Collected Fee </th>
                                                                     <th> Balance Amount </th>
                                                                     <th> Status </th>
                                                                 </tr>
                                                                 </thead>
                                                                 <tbody id="fee_load_td">
<!--                                                                                        <tr>
                                                                                            <th colspan="10" ></th>
                                                                                        </tr>-->
                                                             </tbody>
                                                             </table>
                                                             </form>
                                                   
                                            </div>
                                    </div>

                    
                        </div>
    </div>
                       
               
</div>


<script>
$(document).ready(function()
{
    $('#lst_Month').change(function()
    {
        var mon = $(this).val();
//        alert(mon);
//        var class_id1=$('#monthlstClass').val();
//        var section_id1=$('#monthlstSection').val();
//        var from_date=$('#inputdate3').val();
//        var to_date=$('#inputdate4').val();

//        if(class_id1=='')
//        {
//            alert('Please select Class !!!');
//        }
        
        $('#fee_load_td').html("<tr><td colspan='10'><h3 style='text-align:center'> Loading....... </h3></td></tr>");
        $.ajax({
            
                    url: '<?php echo base_url(); ?>feepayment/report/fee_projection_report',
                    dataType: "text",
                    method: 'post',  
                    data: {
//                                 
                                month:mon,                                             
                    },
                    success: function(data) {
//                      alert(data);
                        $('#month_load').html(data);
                    },
                    error: function(data) {
                    alert('Error occured!'+data);

                    }
            
        });
        
        
        
    });
    
    
    
    
});
            

</script>