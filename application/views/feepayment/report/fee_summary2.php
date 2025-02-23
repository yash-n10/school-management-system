<div class="form-group ">

                            
                            <div class="col-sm-12" style="padding-top:1%;text-align:center">
                                <div class="col-sm-3">
                                <form method="post" action="<?php echo base_url();?>feepayment/Report/monthlyfees_wise_fee_summary2">
                                    <label class="control-label">Session</label>
                                    
                                    <select class="form-control" name="aca_session" id="aca_session">
                                        <!-- <option value="all">All</option> -->
                                        <?php
                                        foreach ($session as $ses) {
                                            ?>
                                            <option value="<?php echo $ses->id; ?>"><?php echo $ses->session; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label class="control-label">Collection Center</label>
                                    <select class="form-control" name="collection_center" id="collection_center3">
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
                                
                                <div class="col-sm-3">
                                    <label class="control-label"> From Date</label>
                                    <input type='date' class="form-control" id="inputdatemf" name="frmdate" value="" style="width:100%" min="<?php echo $school_date_created;?>">
                                </div> 
                                
                                
                                <div class="col-sm-3">
                                    <label class="control-label"> To Date</label>
                                    <input type='date' class="form-control" id="inputdatemt" name="todate" value="" style="width:100%" min="<?php echo $school_date_created;?>">
                                </div> 
                            </div>
                    
                                    <!--</div>-->
                                   
                                  

                                <div class="col-sm-12" style="text-align: center;padding-top:2%">
                                     <input id="submit" type="submit" class="btn btn-danger">                                  
                                </div>
                                </form>
                            </div>

