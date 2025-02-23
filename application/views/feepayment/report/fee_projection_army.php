<div class="form-group has-feedback">
        <div class="box">
            
            <div class="box-body">
                        <div class="tab-content" id="month">

                                             <div class="col-sm-12 col-md-12">
                                                <label class="control-label col-md-1">Quarter</label>
                                                <div class="col-sm-3 col-md-3">
                                                      <?php $m=date('m');?>
                                                    <select name="month" id="lst_Month" class="form-control">
                                                      <option value="">Select Quarter</option>
                                                          <option value="0" <?php //if($m==4 || $m==5 || $m==6) echo 'selected=selected';?>>Quarter1</option>
                                                          <option value="1" <?php //if($m==7 || $m==8 || $m==9) echo 'selected=selected';?>>Quarter2</option>
                                                          <option value="2" <?php //if($m==10 || $m==11 || $m==12) echo 'selected=selected';?>>Quarter3</option>
                                                          <option value="3" <?php //if($m==1 || $m==2 || $m==3) echo 'selected=selected';?>>Quarter4</option>

                                                    </select>
                                                    <span class="help-block"></span>
                                                </div>

                                            </div>

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
                                                                     <!-- <th> Status </th> -->
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
    datatable();
    $('#lst_Month').change(function()
    {
        var mon = $(this).val();
       // alert(mon);

        
        $('#fee_load_td').html("<tr><td colspan='10'><h3 style='text-align:center'> Loading....... </h3></td></tr>");
        $.ajax({
            
                    url: '<?php echo base_url(); ?>feepayment/report/fee_projection_report_army',
                    dataType: "text",
                    method: 'post',  
                    data: {month:mon},
                    // data: {  month:mon, },
                    success: function(data) {
//                      alert(data);
                        $('#month_load').html(data);
                    },
                    error: function(data) {
                    alert('Error occured!'+data);

                    }
            
        });
        
        
        
    });


    function datatable()
        {

           $('#studentlist1').DataTable({


                dom: 'Bfrtip',
            
                 buttons: [
                                {
                                    extend: 'collection',
                                    text: 'Export',
                                    className: 'red',
                                    buttons: [
                              
                                        'excel',
                                        'csv',
                                        {
                                            extend: 'pdf',
                                            orientation: 'portrait',
                                            pageSize: 'A4'
                                        },
                                        {
                                            extend: 'print',
                                            orientation: 'portrait',
                                            pageSize: 'A4'
                                        },
                                    ]
                                }
                            ],
               
            });
            }




//         $('#monthlstClass').change(function()
//     {
//         var class_id1 = $(this).val();
//        // alert(mon);
//         var mon=$('#lst_Month').val();
//        	var section_id1=$('#monthlstSection').val();
//        	// alert(class_id1);
//        	// alert(section_id1);

        
//         $('#fee_load_td').html("<tr><td colspan='10'><h3 style='text-align:center'> Loading....... </h3></td></tr>");
//         $.ajax({
            
//                     url: '<?php echo base_url(); ?>feepayment/report/fee_projection_report_army',
//                     dataType: "text",
//                     method: 'post',  
//                      data: {month:mon,class_id:class_id1,section_id:section_id1},
//                     success: function(data) {
// //                      alert(data);
//                         $('#month_load').html(data);
//                     },
//                     error: function(data) {
//                     alert('Error occured!'+data);

//                     }
            
//         });
        
        
        
//     });


//          $('#monthlstSection').change(function()
//     {
//         var section_id1 = $(this).val();
//         var mon=$('#lst_Month').val();
//        	var class_id1=$('#monthlstClass').val();

        
//         $('#fee_load_td').html("<tr><td colspan='10'><h3 style='text-align:center'> Loading....... </h3></td></tr>");
//         $.ajax({
            
//                     url: '<?php echo base_url(); ?>feepayment/report/fee_projection_report_army',
//                     dataType: "text",
//                     method: 'post',  
//                     data: {month:mon,class_id:class_id1,section_id:section_id1},
//                     success: function(data) {
// //                      alert(data);
//                         $('#month_load').html(data);
//                     },
//                     error: function(data) {
//                     alert('Error occured!'+data);

//                     }
            
//         });
        
        
        
    // });
    
    
    
    
});
            

</script>