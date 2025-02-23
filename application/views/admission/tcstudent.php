<style>
    .form-group{margin-bottom: 10px;} 
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
    .form-control{
        padding: 6px 5px !important;
        color:darkblue
    }
    .error-block {
        font-size: 12px;
        color: red;
    }
    .error-block >p {
        margin: 3px;
    }
</style>
<link href="<?php echo e(base_url("assets/AdminLTE/plugins/bootstrap-fileinput/bootstrap-fileinput.css")); ?>" rel="stylesheet" type="text/css" />

<script>
    function chkadmissio()
    {
        var adm=$('#admission_no').val();
        
       $('#fee_collect_div').html('<div class="panel  panel-success">\n\
<div class="panel-heading" style="padding: 5px 15px;">\n\
<i class="glyphicon glyphicon-th-list"></i><b> <span style="color:black">Student Information</span></b>\n\
</div>\n\
<div class="panel-body" style="padding:0px"></div>\n\
</div>\n\
<div class="panel  panel-info">\n\
<div class="panel-heading" style="padding: 5px 15px;">\n\
<i class="glyphicon glyphicon-folder-open">  </i> <b> <span style="color:black"> Fees Collection</span></b>\n\
</div>\n\
<div class="panel-body" style="padding:0px;"></div></div>');
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('admission/TcStudent/load_student_fee_div'); ?>',
                    data:
                            {
                                adm: adm,
                            },
                    success: function (res)
                    {
//                                           alert(res);
                        $('#fee_collect_div').html(res);
                        $('select').select2({width:'100%',theme: "classic"});

                    },
                    error: function (req, status)
                    {
                        alert('No data Found');
                        return false;
                    }
                });
                
                
    }
</script>
<div class="panel  panel-default"> 
    <div class="panel-body">
        <form enctype="multipart/form-data" id="studentdetails" action="" method="post">
            <div class="col-sm-12 col-md-12">
                <div class="row">
                    <div class="col-sm-12">
                        <fieldset class="">
                            <legend class="" style="font-size:18px;color:green"> Official Details <span class="required"></span></legend>
                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <label  style="font-weight: 600">Admission No.</label>
                                    <select class="form-control chosen-select" id="admission_no" name="admission_no" required onchange='chkadmissio()'>
                                        <option value="">Select Admission No.</option>       
                                        <?php foreach ($student as $opt) { ?>
                                            <option value="<?php echo $opt->admission_no; ?>"><?php echo $opt->admission_no; ?></option>
                                        <?php } ?>
                                    </select>
                                    <span class="error-block"></span>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Inactive Type</label>
                                    <select class="form-control chosen-select" id="inactive_type" name="inactive_type" required>
                                        <option value="">Select </option>       
                                        <option value="TC">TC </option>       
                                        <option value="PASS">Passout </option>       
                                        <option value="LEFTWITHOUT">Left Without Information </option>       
                                    </select>
                                    <span class="error-block"></span>
                                </div>

                                <div class="form-group col-sm-4">
                                    <label  style="font-weight: 600">Date</label><span style='color:red;font-weight:bold'>*</span>
                                    <input class="form-control" name="date" id="date" type="date" value="" required>
                                    <span class="error-block"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Reason</label><span style='color:red;font-weight:bold'>*</span>
                                    <select class="form-control chosen-select" id="reason" name="reason" required>
                                        <option value="">Select </option>       
                                        <option value="PR">Parent Request</option>       
                                        <option value="HS">Higher Studies</option>       
                                        <option value="LEFTWITHOUT">Left Without Information</option>       
                                        <option value="TRANSFER">Transfer</option>       
                                        <option value="PAYMENT_DUE">Payment Due</option>       
                                    </select>
                                    <span class="error-block"></span>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label style="font-weight: 600">Remarks</label>
                                    <input class="form-control" name="remarks" id="remarks" type="text" value="" pattern="[a-zA-Z ]+" required>
                                    <span class="error-block"></span>
                                </div>

                            </div>
                        </fieldset>
                    </div>
                </div>

                <div class="row" style="padding-top:2%">
                    <div class="col-sm-12" id="fee_collect_div">
                        <div class="panel  panel-success">
                            <div class="panel-heading" style="padding: 5px 15px;"><i class="glyphicon glyphicon-th-list"></i><b> <span style="color:black">Student Information</span></b></div>
                            <div class="panel-body" style="padding:0px"></div>
                        </div>
                        <div class="panel  panel-info">
                            <div class="panel-heading" style="padding: 5px 15px;"><i class="glyphicon glyphicon-folder-open">  </i> <b> <span style="color:black"> Fees Collection</span></b></div>
                            <div class="panel-body" style="padding:0px;"></div>
                        </div>
                    </div>
                </div>   
                
                 <div class="row" style="padding-top:2%">
                    <div class="col-lg-12" style="text-align:center"> 
                        <a href ="<?php echo base_url('admission/TcStudent/TcStudentPage'); ?>" type="button" class="btn btn-primary" style="width: 120px;font-family: sans-serif;float:left" id="back" ><i class="fa fa-arrow-left"> </i> Back</a>
                        <input type="button" class="btn btn-success" style="width: 120px;font-family: sans-serif;" name="savetc" id="save_tc_student" value="SAVE">
                    </div>
                </div>
                
            </div>
        </form>
    </div>

</div>
<script src="<?php echo base_url("assets/AdminLTE/plugins/bootstrap-fileinput/bootstrap-fileinput.js"); ?>" type="text/javascript"></script>
<script>
    var globalid = '';
    var save_method = '<?php // echo $task; ?>';

    $('#back1').click(function () {
//        window.location.href = "<?php // echo base_url('admission/TcStudent/TcStudentPage'); ?>";
    });
    
        
$('#save_tc_student').click(function ()
    {
//        alert('sdf');
            var r = confirm("Are you sure you want to Generate TC?");
            if(r==true){

                 $.ajax
                    ({
                        url: "<?php echo base_url('admission/TcStudent/saveTcStudent') ?>",
                        type: "POST",
                        data: $('#studentdetails').serialize(),
                        dataType: "json",
                        success: function (data) {
                            window.location.href = "<?php echo base_url('admission/TcStudent/TcStudentPage') ?>";
                        },
                        error: function (errdata) {
//                            alert('error');
                        }
                    });
           
                    }
                    else
            {
                return false;
            }
    });
    
    
</script>
