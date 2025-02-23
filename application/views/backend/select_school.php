
<div class="form-group has-feedback">
    <div class="box">

        <div class="box-body">
            <form class="form-horizontal" method="POST"  name="frmTransactions">

              


                    <div class="col-sm-6 col-md-6" id="fetch_transac">
                        <div class="panel  panel-default" >                                   
                            <div class="panel-heading" style="background:#004080;color:white;padding: 5px 15px;"><i class="glyphicon glyphicon-info-sign"></i> <b> Choose School</b></div>
                            <div class="panel-body" style="padding:0px">
                                <table class="table" style="border:0px;">
                                    <tr style=" border-left:20px !important;">
                                        
                                        <td>
                                            <select class="form-control" id="scl_id" style="width:100%">
                                                    <option value="0" data-gw="">Select School</option>
                                                    <?php foreach ($school as $sckl) { ?>
                                                        <option value="<?php echo $sckl->id ?>" data-gw="<?php echo $sckl->payment_gateway ?>" data-code="<?php echo $sckl->school_code ?>"> <?php echo $sckl->description ?></option>
                                                    <?php } ?>
                                            </select>
                                        </td>
                                        
                                        <td>
                                           
                                            <button type="button" class="btn btn-success" id="select_school" style="width:100%">Go</button>                                            
                                           
                                        </td>
                                        

                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center">                     
                                            <button type="button" class="btn btn-warning" id="view_trans_not_updated">View Transaction Not updated</button>                              
                                        </td>
                                    </tr>


                                </table>   
                            </div>



                        </div>
                    </div>

                    <div class="col-sm-6 col-md-6" id="fee_stud_trans1">

                    </div>


            </form>
        </div>
        
        <div class="box-body">
                <div class="col-sm-12 col-md-12" id="div_trans_not_update">

                </div>
        </div>
        
        <div class="box-body">
                <div class="col-sm-12 col-md-12" id="fee_stud_trans_det">

                </div>
        </div>
        
        
    </div>
</div>

<script>
$('#view_trans_not_updated').hide();

    $('#scl_id').change(function(){
       
//            if($('#scl_id').find(':selected').attr('data-gw')=='HDFC'){
            if($('#scl_id').find(':selected').attr('data-gw')=='HDFC'  || $('#scl_id').find(':selected').attr('data-gw')=='CCAVENUE'){
                $('#view_trans_not_updated').show();
            }else{
                $('#view_trans_not_updated').hide();
                $('#tbl_trans_not_update').hide();
            }
            
            $('#div_trans_not_update').html('');
    });


    $('#select_school').click(function ()
    {
        var schl_id = $('#scl_id').val();

        if (schl_id == '')
        {
            alert('Please Select School');
        } else
        {
            
            
            
            $.ajax(
                    {
                        type: "POST",
                        data: {
                            school_id: schl_id
                        },
                        url: "<?php echo base_url('Backend/get_info'); ?>",
                        dataType: "text",
                        success: function (data)
                        {
                            $('#fee_stud_trans1').html(data);
                            $('select').select2({width:'100%',theme: "classic"});
                        },
                        error: function (req, status)
                        {
                            alert('error');
                        }
                    });
        }
    });
    
    
    $('#view_trans_not_updated').click(function(){
    
        var school_id=$('#scl_id').val();
        var pgw=$('#scl_id').find(':selected').attr('data-gw');
        var school_code=$('#scl_id').find(':selected').attr('data-code');
                    $.ajax(
                    {
                        type: "POST",
                        data: {
                            school_id: school_id,
                            pgw: pgw,
                            school_code: school_code,
                        },
                        url: "<?php echo base_url('Backend/trans_notupdate_info'); ?>",
                        dataType: "text",
                        success: function (data)
                        {
                            $('#div_trans_not_update').html(data);
                            var table =$('#tbl_trans_not_update').DataTable( {
                                "scrollX": true,
                                "scrollY": "300px",
                                "scrollCollapse": true,
                                "paging":         false,
                                "order": [[2, "asc"]]

                            } );

                        },
                        error: function (req, status)
                        {
                            alert('error');
                        }
                    });
    });
    
    function payupdate(adm_no,stud_id,date) {
    
        $.ajax(
                    {
                        type: "POST",
                        data: {
                            school_id: $('#scl_id').val(),
                            adm: adm_no,
                            stud_id: stud_id,
                            pay_date: date,
                            autostatus:'true'
                        },
                        url: "<?php echo base_url('Backend/get_trans_status'); ?>",
                        dataType: "text",
                        success: function (data)
                        {
                            $('#fee_stud_trans_det').html(data);
                        },
                        error: function (req, status)
                        {
                            alert('error' + req);
                        }
                    });
    }
    

</script>