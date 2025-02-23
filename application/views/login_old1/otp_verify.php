<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."includes/header_login.php");
?>
<style type="text/css">
.login-box-body{
  border-radius:10px;
}
</style>
<div class="login-box">
  <div class="login-box-body" style="height:270px;">
    <h2 style="text-align:center;padding-bottom:25px;"><b>FEES<a style="color:#2ecc71">CLUB</a></b></h2>
     <p class="login-box-msg">Enter OTP sent to your registered mobile number </p>
     <span class="glyphicon glyphicon-phone form-control-feedback"></span>

    <form role="form" method="POST" action="<?php echo base_url("Recreate_password/verify") ?>">
         <div class="form-group has-feedback">
        <input type="text" class="form-control" id="otp" name="otp" placeholder="Enter OTP" value="" autofocus>
        </div>
       
        <div class="col-xs-4" style="margin-top: 5px;">
          <button type="button"  id="verify" name="verify" class="btn btn-primary btn-block btn-flat">Next</button>
        </div>
         <div class="col-xs-5"style="margin-top: 5px;">
          <button type="button"  id="resend" name="resend" class="btn btn-primary btn-block btn-flat">Resend OTP</button>
        </div>
    </form>
</div>
      </div>
<?php require_once(APPPATH."includes/footer_login.php"); ?>
<script>  
    var txt_otp_val=$("#otp").val();   
    $("#verify").click(function(e)
    {
                   $.ajax({
                        url: '<?php echo base_url('Recreate_password/verify');?>',
                        dataType: "text",
                        method: 'POST',
                        data:{txt_otp_val:$("#otp").val()},                    
                        success: function(data) {
                            if(data !=1)
                            {
                                $('body').html(data);
                            }
                            else 
                            {
                                alert('Invalid Captcha');
                            }
                        },
                    });
    });
    
</script>
