
<style type="text/css">
.edit_form .form-control{
  margin-bottom:5px;
}

.mycontent-left {
  border-right: 1px dashed #333;
}

#payhistory {
  padding-bottom:20px;
  border-bottom: 1px dashed #333;
}

</style>
<div class="wrapper">


  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- CHANGE USER PASSWORD FIRST LOGIN -->
    <div class="modal fade" id="modal_change_password" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <form class="form-horizontal" id="change_initial_password" method="POST" role="form" action="<?php echo base_url("school/change_password") ?>">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Change User Password</h4>
          </div>
          <div class="modal-body">
            <div class="box-body edit_form">
              <div class="form-group">
                <label for="change_password" class="col-sm-4 control-label">Password:</label>
                <div class="col-sm-8">
                  <input type="password" class="form-control" id="change_password" name="change_password" value="" required autofocus>
                </div>
              </div>
              <div class="form-group">
                <label for="change_re_password" class="col-sm-4 control-label">Re-enter Password:</label>
                <div class="col-sm-8">
                  <input type="password" class="form-control" id="change_re_password" name="change_re_password" value="" required>
                </div>
              </div>
            </div>
            <p id="change_initial_error" style="color:red"></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" name="btn_edit_user" id="btn_edit_user" class="btn btn-primary"><i class="fa fa-lock"></i> Update Password</button>
          </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Main content -->
   <section class="content">
            <div class="row">

                <div class="col-md-12" id="content_div">
                        <?php include $page_name.'.php';?>

                </div>
            </div>
  </section>
  </div>



  <?php require_once(APPPATH."includes/copyright.php"); ?>
</div>

<?php require_once(APPPATH."includes/footer_school.php"); ?>
<script type="text/javascript">
  $(document).ready(function() {
    <?php // if($user[0]->change_password == 0){ ?>
//      $('#modal_change_password').modal('show');
    <?php // } ?>
  });
  </script>
    </body>
</html>