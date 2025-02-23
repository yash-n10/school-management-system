

            <div class="row">

                    <div class="col-md-12">

                        <div class="box">
<!--                            <div class="box-header">
                                <h3 class="box-title main_head"><u>Backend Facility</u></h3>

                           </div>-->
                            <div class="box-body">
                                
                                <!--<form enctype='multipart/form-data' id='form' class="form-horizontal" action="<?php // echo base_url('Backend/davb_due_log_update'); ?>" method='post'>-->
                                <form enctype='multipart/form-data' id='form' class="form-horizontal" action="<?php echo base_url('Backend/datapayment'); ?>" method='post'>
                                    <div class="col-lg-3">
                                        <label class="control-label">Uploadm</label> <span style="color:red">Please dont use the same file again</span>
                                    </div>
                                        <div class="col-lg-3">
                                        <input class="form-control"  type='file' name='uploadm' required="">
                                    </div>
                                    <div class="col-lg-6"><input type='submit' class="btn btn-success" name='submit' id='submit' value='Upload'></div>
                                </form>
                                
                                <?php echo $message;?>
                            </div>
                        </div>
                        
                        <div class="box">
                            <div class="box-body">
                                            <?php
        if (isset($errors) && count($errors) > 0) {
            ?>
            <div class="box">
                <div class="box-body">                    
                    <legend style='color:red'><u>Errors</u></legend>
                    <pre>
<?php
foreach ($errors as $error => $v) {
    echo "$v\n";
}
?>
                    </pre>
                </div>	
            </div>
            <?php
        }
        ?>
                            </div>
                        </div>
                        
                    </div>

            </div>

        
