<div class="form-group has-feedback">
    <div class="box">            
        <div class="box-body">
            <!--  <div class="col-lg-12">
            <div class="col-lg-12" style="text-align:right; padding-top: 20px;"><a href="<?php echo base_url(); ?>academics/paper_creditlist" class="btn btn-success">  BACK  </a></div>
            </div> -->
        </div>

        <div class="box-body">
            <form id="form_led" action="<?php echo base_url('account/Group_ledger/add_groupledger'); ?>" method="post">       
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <?php
                        $mon = date('m');
                        $fromyear;
                        $toyear;
                        $fyear;
                        if ($mon > 3) {
                            $fromyear = date('Y');
                            $toyear = date('Y') + 1;
                            $fyear = $fromyear . "-" . $toyear; //2018-2019
                        } else {
                            $fromyear = date('Y') - 1;
                            $toyear = date('Y');
                            $fyear = $fromyear . "-" . $toyear; //2017-2018
                        }
//echo  $fyear;
                        $from_date = $fromyear . "-04-01"; //date('Y-m-d');
                        $to_date = date('Y-m-d');
                        ?>
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th colspan="2" style="font-size: 20px;"><center>Select Account</center></th>
                            </tr>
                            <tr>
                                <td colspan="2"><center>
                                <select class="form-control" name="ledger_name" id="ledger_name" style="width:220px;">
                                    <option value="">Select</option>
                                    <?php foreach ($ledger_group as $ledger_name_value) { ?>
                                        <option value="<?php echo $ledger_name_value->id; ?>"><?php echo $ledger_name_value->group_name; ?></option>
                                    <?php } ?>
                                </select>
                            </center>
                            </td>
                            </tr>
                            <tr>

                                <td>
                            <center><input type='date' name='from_date' class='form-control' id='from_date' value="<?php echo $from_date; ?>" style="width:320px;"></center>
                            </td>
                            <td>
                            <center><input type='date' name='to_date' class='form-control ' value="<?php echo date("Y-m-d"); ?>" id='to_date' style="width:320px;"></center>
                            </td>
                            </tr>
                            <tr>
                                <td colspan="2"><center><input type="submit" class="btn btn-primary" value="SUBMIT"></center>
                            </tr>
                        </table>
                    </div>
                </div>       			
            </form>
        </div>
    </div>
</div>


