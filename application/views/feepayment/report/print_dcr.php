<div class="form-group">
    <div class='box'>
        <div class='box-header form-group'>
            <form method="post" action="<?php echo base_url()?>feepayment/Report/print_dsr">
                                    <div class="col-sm-12" style="padding-top:1%;text-align:center">
                                        <label class="control-label col-sm-2">Collection Center</label>
                                        <div class="col-sm-3">
                                            <select class="form-control" name="col_center" id="col_center">
                                                <option value="all">All</option>
                                                <?php
                                                foreach ($collection_center as $cc) {
                                                    ?>
                                                    <option value="<?php echo $cc->collection_code; ?>"><?php echo $cc->collection_desc; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <label class="control-label col-sm-1">Date</label>
                                        <div class="col-sm-3">
                                            <input type='date' name="report_date" class="form-control" id="report_date" value="" style="width:100%" min="<?php echo $school_date_created;?>">
                                        </div> 
                                        <input type="submit" name="submit" value="PRINT" class="btn btn-success">
                                    
                                    </div>
                                </form>
        </div>
    </div>















