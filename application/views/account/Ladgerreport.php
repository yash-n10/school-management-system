<div class="form-group has-feedback">
    <div class="box">            
        <div class="box-body">
            <div class="col-lg-12">
                <div class="col-lg-12" style="text-align:right; padding-top: 20px;"><a class="btn btn-danger btn-sm" href="<?php echo base_url(); ?>account/Group_ledger"><span class="glyphicon glyphicon-share-alt"></span> Back</a></div>
            </div>
        </div>

        <div class="box-body">
            <form name="gstledger" class="form-inline" method="post" action="<?php echo base_url(); ?>account/Trail_balance/grpledgerreport">
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
                <div class="form-group col-md-2 col-sm-2">
                    <label></label>
                    <input type="date" class="form-control" id="from_date" name="from_date" value="<?php echo $from_date; ?>" readonly>
                </div>
                <div class="form-group col-md-2 col-sm-3">
                    <label></label>
                    <input type="date" class="form-control" id="to_date" name="to_date" value="<?php echo date("Y-m-d"); ?>" readonly>
                </div>
                <div class="form-group col-md-2 col-sm-3 col-md-offset-1" style="margin-top:15px;">
                    <input type="hidden" name="group_name" id="group_name" value="<?php echo $accountsledger[0]->PARTICULARS; ?>">
                    <!-- <input type="submit" class="btn btn-primary" value="Search" name="submit1"> -->
                </div>
            </form>
        </div>
        <div class="box-body">
            <table id="examples" class="table table-striped table-bordered" style="width:100%;">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Particular</th>		
                        <th>Voucher Type</th>
                        <th>Voucher</th>
                        <th>Debit</th>
                        <th>Credit</th>
                    </tr> 
                </thead>			        
                <tbody>
<?php
$tdebit = 0;
$tcredit = 0;
$i = 1;
foreach ($accountsledger as $value) {
    $tdebit += $value->DEBIT;
    $tcredit += $value->CREDIT;
    ?>
                        <tr>
                            <td><?php echo $value->DATE; ?></td>		        		
                            <td><a style="color: black;text-decoration: none;" target="_blank" href="<?php echo site_url(); ?><?php echo $value->PAGE_NAME; ?>"><?php echo $value->PARTICULARS_NAME; ?></a></td>
                            <td align="right"><a style="color: black;text-decoration: none;" target="_blank" href="<?php echo site_url(); ?><?php echo $value->PAGE_NAME; ?>"><?php echo $value->VOUCHER_TYPE; ?></a></td>
                            <td align="right"><a style="color: black;text-decoration: none;" target="_blank" href="<?php echo site_url(); ?><?php echo $value->PAGE_NAME; ?>"><?php echo $value->VOUCHER; ?></a></td>
                            <td><a style="color: black;text-decoration: none;" target="_blank" href="<?php echo site_url(); ?><?php echo $value->PAGE_NAME; ?>"><?php echo $value->DEBIT; ?></a></td><td><a style="color: black;text-decoration: none;" target="_blank" href="<?php echo site_url(); ?><?php echo $value->PAGE_NAME; ?>"><?php echo number_format(abs($value->CREDIT), 2); ?></a></td>

                        </tr>
    <?php
    $i++;
}
$drcr = "";
if ($tcredit >= $tdebit) {
    $drcr = "By  ";
//bal= sumcr - sumdr;
}
if ($tcredit <= $tdebit) {
    $drcr = "To     ";
//bal = sumdr - sumcr;
}

if ($tcredit >= $tdebit) {
    $drcr = "By  ";
    $bal = $tcredit - $tdebit;
    $debit = $bal;
    $credit = "0.00";
    $gtot = $tdebit + $bal;
}
if ($tcredit <= $tdebit) {
    $drcr = "To     ";
    $bal = $tdebit - $tcredit;
    $debit = "0.00";
    $credit = $bal;
    $gtot = $tcredit + $bal;
}
?>

                <tfoot style="background-color:#DCDCDC;">
                    <tr>

                        <td></td>
                        <td align="right"><b><?php echo "   Total :"; ?></b></td>		
                        <td> </td>
                        <td></td>
                        <td align="right"><b><?php echo number_format(abs($gtot), 2); ?></b></td>
                        <td align="right"><b><?php echo number_format(abs($gtot), 2); ?></b></td>
                    </tr>
                </tfoot>

                <tfoot style="background-color: #F5F5F5">
                    <tr>
                        <th></th>
                        <td align="right"><b><?php echo $drcr . "   Closing Balance"; ?></b></td>
                        <th> </th>
                        <th> </th>
                        <td align="right"><b><?php echo number_format(abs($debit), 2); ?></b></td>
                        <td align="right"><b><?php echo number_format(abs($credit), 2); ?></b></td>

                    </tr>
                </tfoot>						
                </tbody>
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

