<style>
    /*.form-group{margin-bottom: 10px;}*/ 
    fieldset { 
        border: solid 1px #a6a6a6 !important;
        padding: 0 10px 10px 10px;
        border-bottom: none;
        /*    border-radius: 8px;*/
        border-top-left-radius: 25px;
        border-bottom-left-radius: 25px;
        border-top: 2px solid #29a3a3 !important;
    }
    legend{
        width: auto !important;
        padding:0 10px;
        border: none;
        font-size: 14px;
        font-variant: small-caps;
        letter-spacing: 1px;
        text-decoration: underline;
    }
    /*    .form-control{
    padding: 6px 5px !important;
    color:darkblue
    }
    .error-block {
    font-size: 12px;
    color: red;
    }
    .error-block >p {
    margin: 3px;
    }*/
</style>
<div class="form-group has-feedback">
    <div class="panel  panel-default" > 
        <form id='frmaddsection' action="<?php echo base_url('feepayment/instant_fee/allocate_student')  ?>" role="form" method="POST" name="addInstantFee" class="form-horizontal">
        <div class="panel-body">
            
                 
               <?php if($this->session->flashdata('instantfee_success_msg')) {?>
        <div class="alert alert-success" style="background-color:#ccf1b9 !important;color:#980909 !important;padding: 7px;text-align:center" id="successMessage">
            <i class="fa fa-check"> </i> <label> <?php echo $this->session->flashdata('instantfee_success_msg');?></label>
        </div>
        <?php }?>                       
                <div class="form-group">
                    
                    <label class="control-label col-sm-2 col-sm-offset-1" for="fee_id">Fee Name:</label>
                    <div class="col-sm-3">
                        <select name="fee_id" class="form-control" id="fee_id" required>

                            <option value="">Select</option>
                            <?php foreach ($edit_columns['fee_id']['select_opts'] as $opt) { ?>
                                <option  value="<?php echo $opt->opt_id; ?>"><?php echo $opt->opt_disp; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2 col-sm-offset-1" for="email">Allocate to student:</label>
                    <div class="col-sm-3">
                        <label class="radio-inline"><input type="radio" name="optradio" checked value="single">Single</label>
                        <label class="radio-inline"><input type="radio" name="optradio" value="group">Group</label>
                    </div>
                </div>
                <div class="form-group" id="single_div">
                    <label class="control-label col-sm-2 col-sm-offset-1" for="email">Enter Admission No:</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="admission_no" name="admission_no" required>
                    </div>
                    <div class="col-sm-3">
                        <button type="button" name="go" id="go" class="btn btn-info">GO</button>
                    </div>
                </div>
                <div class="form-group" style="display: none" id="group_div">
                    <label class="control-label col-sm-2 col-sm-offset-1" for="class">Class & Sec:</label>
                    <div class="col-sm-3">
                    <select name="class[]" class="form-control" id="class" multiple >

                        <option value="Select">Select</option>
                        <?php foreach ($edit_columns['class']['select_opts'] as $opt) { ?>
                            <option  value="<?php echo $opt->opt_id; ?>"><?php echo $opt->opt_disp; ?></option>
                        <?php } ?>
                    </select>
                        <input type="checkbox" id="checkbox" >Select All
                    </div>
                    <div class="col-sm-3">
                        <select name="section[]" class="form-control" id="section" multiple data-placeholder="Section">

                            <option value="Select">Select</option>
                            <?php foreach ($edit_columns['section']['select_opts'] as $opt) { ?>
                                <option  value="<?php echo $opt->opt_id; ?>"><?php echo $opt->opt_disp; ?></option>
                            <?php } ?>
                        </select>
                        <input type="checkbox" id="checkbox1" >Select All
                    </div>
                    
                    
                </div>
                <div class="form-group" style="display: none" id="group_div1">
                    <label class="control-label col-sm-3" for="amount">Amount(Common to all) :</label>
                    <div class="col-sm-3">
                        <input type="number" class="form-control" id="common_amt" name="common_amt" value="0">
                    </div>
                    <div class="col-sm-3">
                        <button type="button" name="go1" id="go1" class="btn btn-info">GO</button>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2 col-sm-offset-1" for="remarks">Remarks :</label>
                    <div class="col-sm-3 ">
                        <input type="text" class="form-control" id="remarks" name="remarks" required>
                    </div>
                    
                </div>
                
                <fieldset class="">
                    <legend class="" style="font-size:18px;color:green">
                        Allocate to Student <span class="required"></span>
                    </legend>
                    <div class="row" id="div_alloc_student">

                        <div class="col-sm-12">
                            <div class="overlay" id="preloader" style="display:none;">
                                <i class="fa fa-refresh fa-spin" style="top: 13%;color:#f39c12"></i>
                            </div>
                            <table name="allocate_stud_tbl" id="allocate_stud_tbl" class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="chk_all" id="chk_all"></th>
                                        <th>Admission No</th>
                                        <th>Student's Name</th>
                                        <th>Class - Sec</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
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
                </fieldset>

               
            
        </div>
        <div class="panel-footer" style="text-align: center">
            <button type="submit" name="submit" id="submit" class="btn btn-success" disabled>Allocate</button>
        </div>
            </form>
        <!-- /.box-body -->
    </div>
</div>
<!-- /.box -->

<script>
    $(document).ready(function(){
        $("#class").select2({
            placeholder: "Class",
            width:'100%',
            theme:'classic',
            allowClear: false
            
        });
        $("#section").select2({
            placeholder: "Section",
            width:'100%',
            theme:'classic',
            allowClear: false
            
        });
    });
    
    $('#go,#go1').click(function ()
    {

        
        
        if(!$('#frmaddsection')[0].checkValidity())
        {
//            alert($(this).validationMessage);
            $(this).show();
            $('#frmaddsection')[0].reportValidity();
            return false;
        }
        else{
            $('#div_alloc_student #preloader').css('display', 'inline-block');
//        $("#div_transfer_student #preloader").fadeOut("slow");
        $('#submit').removeAttr('disabled');
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('feepayment/instant_fee/load_bulk_alloc') ?>',
            data:$('#frmaddsection').serialize(),
            success: function (data)
            {
                $('#div_alloc_student').html(data);
                $('#div_alloc_student #preloader').css('display', 'none');
            },
            error: function (req, status)
            {
                alert('error while loading');
            }

        });
        }
    });
    
    $('input[name="optradio"]').click(function(){
        if(this.value=='group') {
            $('#group_div').css('display','block');
            $('#group_div1').css('display','block');
            $('#single_div').css('display','none');
            $('#admission_no').attr('required',false);
            $('#class').attr('required',true);
            $('#section').attr('required',true);
        }else{
            $('#single_div').css('display','block');
            $('#group_div').css('display','none');
            $('#group_div1').css('display','none');
            $('#admission_no').attr('required',true);
            $('#class').attr('required',false);
            $('#section').attr('required',false);
        }
    });
    
    $("#checkbox").click(function(){
        if($("#checkbox").is(':checked') ){

            $("#class > option[value!='Select']").attr("selected","true");
            $("#class").trigger("change");
        }else{
            $("#class > option[value!='Select']").removeAttr("selected");
           $("#class").trigger("change");
   
         }
 
    });
    $("#checkbox1").click(function(){
        if($("#checkbox1").is(':checked') ){
            $("#section > option[value!='Select']").attr("selected","true");  
            $("#section").trigger("change");
        }else{
            $("#section > option[value!='Select']").removeAttr("selected");  
            $("#section").trigger("change");
         }
         
    });
    
    setTimeout(function () {
        $('#successMessage').fadeOut("slow");
    }, 5000);
</script>

