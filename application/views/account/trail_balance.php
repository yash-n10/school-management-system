<div class="form-group has-feedback">
    <div class="box">            
        <div class="box-body">
            <!--  <div class="col-lg-12">
            <div class="col-lg-12" style="text-align:right; padding-top: 20px;"><a href="<?php echo base_url(); ?>academics/paper_creditlist" class="btn btn-success">  BACK  </a></div>
            </div> -->
        </div>

        <div class="box-body">
            <form name="gstledger" class="form-inline" method="post" action="<?php echo base_url('account/trail_balance'); ?>">
                <div class="form-group col-md-2 col-sm-3">
                    <label for="filter by date"><b>Filter By Date:</b></label>
                </div><br><br>
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
//echo	$fyear;
                $from_date = $fromyear . "-04-01"; //date('Y-m-d');
                $to_date = date('Y-m-d');
                ?>

                <?php
                foreach ($trial_group as $value) {
                    
                }
                ?>
                <div class="form-group col-md-2 col-sm-2">
                    <label></label>
                    <input type="date" class="form-control from-date" id="from_date" name="from_date" value="<?php echo $from_date; ?>">
                </div>
                <div class="form-group col-md-2 col-sm-3">
                    <label></label>
                    <input type="date" class="form-control" id="to_date" name="to_date" value="<?php echo date("Y-m-d"); ?>">
                </div>
                <div class="form-group col-md-5 col-sm-3 col-md-offset-1" style="margin-top: 15px;">
                    <input type="hidden" name="trial" id="trial" value="<?php echo $value->ID; ?>">
                    <input type="submit" class="btn btn-primary" value="Search" name="submit1">
                </div>
            </form>
        </div>
        <div class="box-body">
            <table id="examples" class="table table-striped table-bordered" style="width:100%;">
                <thead>
                    <tr>
                        <th>Group Name</th>		
                        <th>Debit</th>
                        <th>Credit</th>
                        <th>ID</th>
                    </tr> 
                </thead>

                <tbody>
                    <?php
                    $i = 1;
                    foreach ($trial_bal as $value) {

                        $drt = $value->DEBIT;
                        $crt = $value->CREDIT;


                        $Dclosingbal = "";
                        $Cclosingbal = "";
                        if ($drt >= $crt) {
                            $Dclosingbal = ($drt - $crt);
                            $Cclosingbal = "";
                        }
                        if ($crt >= $drt) {
                            $Cclosingbal = ($crt - $drt);
                            $Dclosingbal = "";
                        }
                        ?>
                        <tr>			        		
                            <td><a style="color: black;text-decoration: none;" target="_blank" href="<?php echo site_url(); ?>account/Trail_balance/grpledgerreport/<?php echo $value->GROUP_CODE; ?>"><?php echo $value->PARTICULARS; ?></a></td>
                            <td><a style="color: black;text-decoration: none;" target="_blank" href="<?php echo site_url(); ?>account/Trail_balance/grpledgerreport/<?php echo $value->GROUP_CODE; ?>"><?php echo $Dclosingbal; ?></a></td>
                            <td><a style="color: black;text-decoration: none;" target="_blank" href="<?php echo site_url(); ?>account/Trail_balance/grpledgerreport/<?php echo $value->GROUP_CODE; ?>"><?php echo $Cclosingbal; ?></a></td>
                            <td><a style="color: black;text-decoration: none;" target="_blank" href="<?php echo site_url(); ?>account/Trail_balance/grpledgerreport/<?php echo $value->GROUP_CODE; ?>"><?php echo $value->GROUP_CODE; ?></a></td>


                        </tr>
    <?php
    $i++;
    if ($Dclosingbal != "") {
        $TDclosingbal += $Dclosingbal;
    }
    if ($Cclosingbal != "") {
        $TCclosingbal += $Cclosingbal;
    }
}
?>
                </tbody>
                <tfoot>
                    <tr>
                        <td>Grand Total</td>		
                        <td align="right" rowspan="1" colspan="1"><strong>₹<?php echo $TDclosingbal; ?></strong></td>
                        <td align="right" rowspan="1" colspan="1"><strong>₹<?php echo $TCclosingbal; ?></strong></td>

                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#examples').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'collection',
                    text: 'Export',
                    buttons: [
                        'excel',
                        'csv',
                        'pdf',
                        'print'
                    ]
                }
            ]
        });
    });
</script>

