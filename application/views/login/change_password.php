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
  <div class="login-box-body" style="height:420px;">
    <h2 style="text-align:center;padding-bottom:25px;"><b>FEES<a style="color:#2ecc71">CLUB</a></b></h2>
  
    <form role="form" method="POST" action="<?php echo base_url("Recreate_password/change_password") ?>">
         <div class="modal-body">
            <div class="box-body edit_form">
           
              <div class="form-group">
                <label for="change_password" class="control-label">Create New Password:</label>
                <div class="">
                  <input type="password" class="form-control" id="change_password" name="change_password" value="" required autofocus>
                </div>
              </div>
              <div class="form-group">
                <label for="change_re_password" class="control-label">Confirm Password:</label>
                <div class="">
                  <input type="password" class="form-control" id="change_password" name="change_re_password" value="" required>
                </div>
              </div>
            </div>
            <p id="change_initial_error" style="color:red"></p>
          </div>
        
        <div class="col-xs-8">
          <button type="submit" class="btn btn-primary btn-block btn-flat"  name="btn_edit_user" id="btn_edit_user">Update Password</button>
        </div>
    </form>
</div>
    </div>
<?php require_once(APPPATH."includes/footer_login.php"); ?>
