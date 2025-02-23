<div class="form-group has-feedback">
    <div class="box box-primary">
        <div class="page-content-inner">
<!--            <div class="box">-->
                <div class="box-body">
                    <div class="col-lg-12">
                        <div class="col-lg-12" style="text-align:right; padding-top: 20px;"><a href="<?php echo base_url(); ?>account/Acc_ledger" class="btn btn-success"> BACK </a></div>
                    </div>
                    <hr/>
                </div>

                <div class="box-body">	    			 
                    <form name="gstledger" class="form-inline" method="post" action="<?php echo base_url('account/Acc_ledger/acc_report'); ?>">
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
                        <div class="form-group col-md-2 col-sm-3">
                            <label></label>
                            <input type="date" class="form-control from-date" id="from_date" name="from_date" value="<?php echo $from_date; ?>">
                        </div>
                        <div class="form-group col-md-2 col-sm-3">
                            <label></label>
                            <input type="date" class="form-control" id="to_date" name="to_date" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                        <div class="form-group col-md-2 col-sm-3 col-md-offset-1" style="margin-top: 18px;" >
                            <input type="hidden" name="ledger_name" id="ledger_name" value="<?php echo $ledgername[0]->id; ?>">
                            <input type="submit" class="btn btn-primary" value="Search" name="submit1">
                        </div>
                    </form>
                </div>
                <div>
                    <center><strong style="font-size: 20px;"><?php foreach ($ledgername as $val) {
                            echo $val->ledger_name;
                        } ?></strong></center>
                    <center><strong style="font-size: 20px;"><?php foreach ($ledgername as $val) {
                            echo $val->address;
                        } ?></strong></center> 
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
                            if ($val->cr_dr == 'CR') {
                                $cr = $val->opening_balance;
                            } else {
                                $dr = $val->opening_balance;
                            }
                            ?>
                            <tr>
                                <td><?php
                            $str = strtotime($val->opening_date);
                            echo date('Y-m-d', $str);
                            ?></td>
                                <td>
                                    <label style="color: black;text-decoration: none;" target="_blank" id="<?php echo $value->BILL_GEN_NO; ?>"><?php echo "Opening"; ?></label>
                                </td>
                                <td>
                                    <label style="color: black;text-decoration: none;" target="_blank" id="<?php echo $value->BILL_GEN_NO; ?>"><?php ?></label>
                                </td>
                                <td>
                                    <label style="color: black;text-decoration: none;" target="_blank" id="<?php echo $value->BILL_GEN_NO; ?>"><?php ?></label>
                                </td>
                                <td align="right">
                                    <label style="color: black;text-decoration: none;" target="_blank" id="<?php echo $value->BILL_GEN_NO; ?>"><?php echo number_format((float) $dr, 2); ?></label>
                                </td>
                                <td align="right">
                                    <label style="color: black;text-decoration: none;" target="_blank" id="<?php echo $value->BILL_GEN_NO; ?>"><?php echo number_format((float) $cr, 2); ?></label>
                                </td>


                            </tr>
                            <!--end opening value-->
<?php
$tdebit = $dr;
$tcredit = $cr;
$i = 1;
foreach ($accountsledger as $value) {
//echo '<pre>';
//print_r($value);
    $tdebit += $value->DEBIT;
    $tcredit += $value->CREDIT;
    ?>
                                <tr>
                                    <td><?php echo $value->DATE; ?></td>
                                    <td>
                                        <a style="color: black;text-decoration: none;" target="_blank" id="<?php echo $value->BILL_GEN_NO; ?>"  onclick="gotos(this, '<?php echo $value->PAGE_NAME; ?>')"><?php echo $value->PARTICULARS; ?></a>
                                    </td>
                                    <td>
                                        <a style="color: black;text-decoration: none;" target="_blank" id="<?php echo $value->BILL_GEN_NO; ?>"  onclick="gotos(this, '<?php echo $value->PAGE_NAME; ?>')"><?php echo $value->VOUCHER_TYPE; ?></a>
                                    </td>
                                    <td>
                                        <a style="color: black;text-decoration: none;" target="_blank" id="<?php echo $value->BILL_GEN_NO; ?>"  onclick="gotos(this, '<?php echo $value->PAGE_NAME; ?>')"><?php echo $value->VOUCHER; ?></a>
                                    </td>
                                    <td align="right">
                                        <a style="color: black;text-decoration: none;" target="_blank" id="<?php echo $value->BILL_GEN_NO; ?>"  onclick="gotos(this, '<?php echo $value->PAGE_NAME; ?>')"><?php echo $value->DEBIT; ?></a>
                                    </td>
                                    <td align="right">
                                        <a style="color: black;text-decoration: none;" target="_blank" id="<?php echo $value->BILL_GEN_NO; ?>"  onclick="gotos(this, '<?php echo $value->PAGE_NAME; ?>')"><?php echo number_format(abs($value->CREDIT), 2); ?></a>
                                    </td>


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
            <!--</div>-->
        </div>
    </div>
</div>
</div>

<form name="form-any" method="post" action="" id="form-any" style="display:none">
    <input type="hidden" name="formdata" id="formdata" value="">
</form>
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

    function gotos(m, page)
    {

        var id = m.id;
        document.getElementById('form-any').action = '<?php echo base_url(); ?>account/Acc_ledger/' + page;
        $('#formdata').val(id);
        document.getElementById('form-any').submit();
    }
</script>