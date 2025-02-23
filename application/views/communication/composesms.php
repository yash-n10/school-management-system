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
<div class="panel  panel-default">
    <div class="panel-body">
        <?php if($this->session->flashdata('successsmsmsg')) {?>
                    <div class="alert alert-success" style="padding: 7px;text-align:center;background: #08a2129c !important">
                        <label> <?php echo $this->session->flashdata('successsmsmsg');?></label>
                    </div>
                <?php }?>
        <?php if($this->session->flashdata('errorsmsmsg')) {?>
                    <div class="alert alert-danger" style="padding: 7px;text-align:center">
                        <label> <?php print_r($this->session->flashdata('errorsmsmsg'))  ;?></label>
                    </div>
                <?php }?>
        <form enctype="multipart/form-data" id="studentdetails" action="<?php echo base_url('communication/mailsms/send_sms');?>" method="post" class="form-horizontal">
            <div class="col-sm-12 col-md-12">
                
                <div class="form-group">
                    <label class="control-label col-sm-4" for="sms_to">SMS To:</label>
                    <div class="col-sm-3">
                        <select class="form-control" name="sms_to" id="sms_to" onchange="mail_to_change(this)">
                            <option value="" <?php echo  set_select('sms_to', '', TRUE); ?>>Select</option>
                            <option value="all_employee" <?php echo  set_select('sms_to', 'all_employee'); ?>>All Employee</option>
                            <option value="teaching_staff" <?php echo  set_select('sms_to', 'teaching_staff'); ?>>Teaching Staff</option>
                            <option value="non_teaching_staff" <?php echo  set_select('sms_to', 'non_teaching_staff'); ?>>Non-Teaching Staff</option>
                            <option value="all_student" <?php echo  set_select('sms_to', 'all_student'); ?>>All Students</option>
                            <option value="specific_number" <?php echo  set_select('sms_to', 'specific_number'); ?>>Specific Number</option>
                            
                        </select>
                    </div>
                </div>
                <div class="form-group" id="div_specific_number">
                    <label class="control-label col-sm-4" for="subject">To Mobile Number:</label>
                    <div class="col-sm-6">
                        <input class="form-control" name="to_number" id="to_number" type="number" value="<?php echo set_value('to_number'); ?>">
                    </div>
                </div>
                
                <div class="form-group">
                    <label class="control-label col-sm-4" for="message">Message:</label>
                    <div class="col-sm-6">
                        <textarea class="form-control" rows="10" id="message" name="message" maxlength="160"><?php echo set_value('message'); ?></textarea>
                    </div>
                </div>

            </div>
            <div class="col-sm-12 col-md-12" style="text-align: center;padding-top:2%">
                <a  class="btn btn-primary" style="width: 120px;font-family: sans-serif;float:left" id="back" href="<?php echo base_url('communication/mailsms');?>"><i class="fa fa-arrow-left"> </i> Back</a>
                <input type="submit" class="btn btn-success" style="width: 120px;font-family: sans-serif;" name="send_sms" id="send_sms" value="Send SMS"  >
            </div>
        </form>
    </div>    
</div>

<script>
    
$(function ()
{

//  CKEDITOR.replace('descr_ed');

    if($('#sms_to').val()=='specific_number') {
        $('#div_specific_number').show();
        $('#to_number').attr('required',true);
    }else{
        $('#div_specific_number').hide();
        $('#to_number').attr('required',false);
    }
});

function mail_to_change(me) {
    $('#div_specific_number').hide();
    $('#to_number').attr('required',false);
        switch(me.value) {
        case '':
            
            break;
        case 'specific_number':
           $('#div_specific_number').show();
           $('#to_number').attr('required',true);
            break;
        default:
            
    }
}
</script>
    