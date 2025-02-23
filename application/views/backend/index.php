<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH."includes/header.php");
?>
<style type="text/css">
.edit_form .form-control{
  margin-bottom:5px;
}
</style>
<div class="wrapper">
    <?php require_once(APPPATH."includes/banner.php"); 
    require_once(APPPATH."includes/navigation-admin.php");  
    ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    
    <!---------------------------------------------------------------------------------------------->
    
    <!---------------------------------- Main content --------------------------------------------->
    <section class="content">
            <div class="row">

                    <div class="col-md-12">

                        <div class="box">
<!--                            <div class="box-header">
                                <h3 class="box-title main_head"><u>Backend Facility</u></h3>

                           </div>-->
                            <div class="box-body">
                                <ul>
                                    <li>
                                        <a href="<?php // echo base_url('Backend/transfer_student');?>">1. Transfer Student data of chinmaya school from feesclub_v4 to crmfeesclub_9 </a>
                                    </li>
                                    <li>
                                        <a href="<?php // echo base_url('Backend/transfer_users');?>">2. Transfer Users data of chinmaya school from feesclub_v4 to crmfeesclub_9</a>
                                    </li>
                                    <li>
                                        <a href="<?php // echo base_url('Backend/transfer_student_fees');?>">3. Transfer student fees from fee_trans_det to new transaction tables</a>
                                    </li>
                                    <li>
                                        <a href="<?php // echo base_url('Backend/transac_status');?>">4. Worldline transaction Status</a>
                                    </li>
                                </ul>
                                <form enctype='multipart/form-data' id='form' class="form-horizontal" action="<?php echo base_url('Backend/datapayment'); ?>" method='post'>
                                <div class="col-lg-3">
                                        <input class="form-control" size='50' type='file' name='uploadm'>
                                </div>
                                <div class="col-lg-6"><input type='submit' class="btn btn-success" name='submit' id='submit' value='Upload'></div>
                                </form>
                            </div>
                        </div>
                        
                    </div>

            </div>
   
    </section>
 
    
    
        
  </div>
  <!-- /.content-wrapper -->
  <?php require_once(APPPATH."includes/copyright.php"); ?>
</div>
        

        
<input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
<?php require_once(APPPATH."includes/footer.php"); ?>


<script>

</script>
