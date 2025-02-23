<div class="form-group has-feedback">
    <div class="box">            
        <div class="box-body">
            <div class="col-lg-12">
                <div class="col-lg-12" style="text-align:right; padding-top: 20px;"><a class="btn btn-danger btn-sm" href="<?php echo base_url(); ?>account/Group_ledger"><span class="glyphicon glyphicon-share-alt"></span> Back</a></div>
            </div>
        </div>

        <div class="box-body">
            <div class="col-md-6">
                <table id="examples" class="table table-striped table-bordered" style="width:100%;">
                    <thead>
                        <?php
                        $mon = date('m');
                        $fromyear;
                        $toyear;
                        $fyear;
                        if ($mon > 3) {
                            $fromyear = date('Y');
                            $toyear = date('Y') + 1;
                            $fyear = $fromyear . "-" . $toyear;
                        } else {
                            $fromyear = date('Y') - 1;
                            $toyear = date('Y');
                            $fyear = $fromyear . "-" . $toyear;
                        }
                        $from_date = $fromyear . "-04-01"; //date('Y-m-d');
                        $to_date = $toyear . "-03-31"; // date('Y-m-d'); 



                        $drt = 0;
                        $crt = 0;
                        $TDclosingbal = 0;
                        $TCclosingbal = 0;
                        $TBal = 0;
                        $TDBal = 0;
                        $TCBal = 0;
                        ?> <tr>
                            <td><strong>Liabilities</strong></td>
                            <td><strong>Amount</strong></td>
                        </tr>
<?php
$particulars = 'Liabilities';
$trial_bala = $this->dbconnection->get_bl($particulars, $from_date, $to_date);
foreach ($trial_bala as $value) {
    $drt = $value->DEBIT;
    $crt = $value->CREDIT;
    $Dclosingbal = "";
    $Cclosingbal = "";
    $bal = "0";
    if ($drt >= $crt) {
        $Dclosingbal = ($drt - $crt);
        $Cclosingbal = "";
        $bal = $Dclosingbal . " Dr";
    } else if ($crt >= $drt) {
        $Cclosingbal = ($crt - $drt);
        $Dclosingbal = "";
        $bal = $Cclosingbal . " Cr";
    }
    if ($Dclosingbal != "") {
        $TDBal += $Dclosingbal;
    } else if ($Cclosingbal != "") {
        $TDBal += $Cclosingbal;
    }
    ?>

                            <tr>
                                <td><strong><?php echo $value->PARTICULARS; ?></strong></td>
                                <td align="right"><strong>₹<?php echo $bal; ?></strong></td>
                            </tr>
                        <?php } ?>
                        <!-- profit and loss ac-->
                        <?php
                        $particulars = 'Expenses';
                        $trial_bala = $this->dbconnection->get_bls($particulars, $from_date, $to_date);
                        $drt = $trial_bala[0]->DEBIT;
                        $crt = $trial_bala[0]->CREDIT;

                        $Dclosingbal = "";
                        $Cclosingbal = "";
                        $bal = "0";
                        if ($drt >= $crt) {
                            $Dclosingbal = ($drt - $crt);
                            $Cclosingbal = "";
                            $bal = $Dclosingbal . " Dr";
                        } else if ($crt >= $drt) {
                            $Cclosingbal = ($crt - $drt);
                            $Dclosingbal = "";
                            $bal = $Cclosingbal . " Cr";
                        }
                        if ($Dclosingbal != "") {
                            $TDclosingbal += $Dclosingbal;
                        } else if ($Cclosingbal != "") {
                            $TCclosingbal += $Cclosingbal;
                        }
                        $particulars = 'Stock-in-Hand';
                        $trial_bala = $this->dbconnection->get_pl($particulars, $from_date, $to_date);

                        $drt = $trial_bala[0]->DEBIT;
                        $crt = $trial_bala[0]->CREDIT;

                        $Dclosingbal = "";
                        $Cclosingbal = "";
                        $bal = "0";
                        if ($drt >= $crt) {
                            $Dclosingbal = ($drt - $crt);
                            $Cclosingbal = "";
                            $bal = $Dclosingbal . " Dr";
                        } else if ($crt >= $drt) {
                            $Cclosingbal = ($crt - $drt);
                            $Dclosingbal = "";
                            $bal = $Cclosingbal . " Cr";
                        }
                        if ($Dclosingbal != "") {
                            $TDclosingbal += $Dclosingbal;
                        } else if ($Cclosingbal != "") {
                            $TCclosingbal += $Cclosingbal;
                        }
                        $particulars = 'Income';
                        $trial_bala = $this->dbconnection->get_bls($particulars, $from_date, $to_date);
                        $drt = $trial_bala[0]->DEBIT;
                        $crt = $trial_bala[0]->CREDIT;

                        $Dclosingbal = "";
                        $Cclosingbal = "";
                        $bal = "0";
                        if ($drt >= $crt) {
                            $Dclosingbal = ($drt - $crt);
                            $Cclosingbal = "";
                            $bal = $Dclosingbal . " Dr";
                        } else if ($crt >= $drt) {
                            $Cclosingbal = ($crt - $drt);
                            $Dclosingbal = "";
                            $bal = $Cclosingbal . " Cr";
                        }
                        if ($Dclosingbal != "") {
                            $TDclosingbal += $Dclosingbal;
                        } else if ($Cclosingbal != "") {
                            $TCclosingbal += $Cclosingbal;
                        }

                        $balance = ($TDclosingbal - $TCclosingbal);


                        if ($balance < 0) {
                            $TDBal += $balance;
                            ?>


                            <tr>		
                                <td><strong>Profit & Loss A/C</strong></td>
                                <td align="right"><strong>₹<?php echo $balance; ?></strong></td>
                            </tr>

                        <?php } ?>				
                        <tr>		
                            <td><strong>Grand Total</strong></td>
                            <td align="right"><strong>₹<?php echo $TDBal; ?></strong></td>
                        </tr>	
                        <!-- end profit and loss ac-->
                    </thead>
                </table>
            </div>
            <div class="col-md-6">
                <table id="exampless" class="table table-striped table-bordered" style="width:100%;">
                    <thead>
                        <tr>
                            <td align="center"><strong>Assets</strong></td>
                            <td><strong>Amount</strong></td>
                        </tr>	
                        <?php
                        $particulars = 'Assets';
                        $trial_bala = $this->dbconnection->get_bl($particulars, $from_date, $to_date);
                        foreach ($trial_bala as $value) {
                            $drt = $value->DEBIT;
                            $crt = $value->CREDIT;
                            $Dclosingbal = "";
                            $Cclosingbal = "";
                            $bal = "0";
                            if ($drt >= $crt) {
                                $Dclosingbal = ($drt - $crt);
                                $Cclosingbal = "";
                                $bal = $Dclosingbal . " Dr";
                            } else if ($crt >= $drt) {
                                $Cclosingbal = ($crt - $drt);
                                $Dclosingbal = "";
                                $bal = $Cclosingbal . " Cr";
                            }
                            if ($Dclosingbal != "") {
                                $TCBal += $Dclosingbal;
                            } else if ($Cclosingbal != "") {
                                $TCBal += $Cclosingbal;
                            }
                            ?>

                            <tr>
                                <td><strong><?php echo $value->PARTICULARS; ?></strong></td>
                                <td align="right"><strong>₹<?php echo $bal; ?></strong></td>
                            </tr>
                        <?php
                        }
                        if ($balance > 0) {
                            $TCBal += $balance;
                            ?>
                            <tr>		
                                <td><strong>Profit & Loss A/C</strong></td>
                                <td align="right"><strong>₹<?php echo $balance; ?></strong></td>
                            </tr>

                        <?php } ?>				
                        <tr>		
                            <td><strong>Grand Total</strong></td>
                            <td align="right"><strong>₹<?php echo $TCBal; ?></strong></td>
                        </tr>			
                    </thead>			        			
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#examples,#exampless').DataTable({
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

