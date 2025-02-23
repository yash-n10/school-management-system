<div class="form-group has-feedback">
    <div class="box">            
        <div class="box-body">
            <!--  <div class="col-lg-12">
            <div class="col-lg-12" style="text-align:right; padding-top: 20px;"><a href="<?php echo base_url(); ?>academics/paper_creditlist" class="btn btn-success">  BACK  </a></div>
            </div> -->
        </div>
        <div class="box-body">
            <table id="examples" class="table table-striped table-bordered" style="width:100%;" action="<?php echo base_url(); ?>account/Profitloss_account/plreport">
                <thead>
                    <tr>
                        <td>Expenditure</td>
                        <td>Amount</td>	
                        <td>Income</td>
                        <td>Amount</td>	
                    </tr> 
                </thead>
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

                $TDclosingbal = 0;
                $TCclosingbal = 0;
                ?>
                <tbody>
                    <tr>
                <?php
                $particulars = 'Stock-in-Hand';
                $trial_bala = $this->dbconnection->get_pl($particulars, $from_date, $to_date);
                $drt = $trial_bala[0]->DEBIT;
                $crt = $trial_bala[0]->CREDIT;
                ?>			        		
                        <td><a style="color: black;text-decoration: none;" target="_blank" href="<?php echo site_url(); ?>account/Profitloss_account/plreport/<?php echo $trial_bala[0]->GROUP_CODE; ?>"><strong>To Opening Stock </strong></a></td>
                        <td align="right">
                            <a style="color: black;text-decoration: none;" target="_blank" href="<?php echo site_url(); ?>account/Profitloss_account/plreport/<?php echo $trial_bala[0]->GROUP_CODE; ?>">
                                ₹<?php
                        $Dclosingbal = "";
                        $Cclosingbal = "";
                        $bal = "0";
                        if ($drt >= $crt) {
                            $Dclosingbal = ($drt - $crt);
                            $Cclosingbal = "";
                            $bal = $Dclosingbal + " Dr";
                        } else if ($crt >= $drt) {
                            $Cclosingbal = ($crt - $drt);
                            $Dclosingbal = "";
                            $bal = $Cclosingbal + " Cr";
                        }
                        if ($Dclosingbal != "") {
                            $TDclosingbal += $Dclosingbal;
                        } else if ($Cclosingbal != "") {
                            $TCclosingbal += $Cclosingbal;
                        }
                        echo $bal;
                ?>
                            </a>
                        </td>
                                <?php
                                $particulars = 'Sales Accounts';
                                $trial_balb = $this->dbconnection->get_pl($particulars, $from_date, $to_date);
                                $drt = $trial_balb[0]->DEBIT;
                                $crt = $trial_balb[0]->CREDIT;
                                ?>
                        <td><a style="color: black;text-decoration: none;" target="_blank" href="<?php echo site_url(); ?>account/Profitloss_account/plreport/<?php echo $trial_balb[0]->GROUP_CODE; ?>"><strong>By Sales Accounts</strong></a></td>
                        <td align="right"><a style="color: black;text-decoration: none;" target="_blank" href="<?php echo site_url(); ?>account/Profitloss_account/plreport/<?php echo $trial_balb[0]->GROUP_CODE; ?>">₹ 
                        <?php
                        $Dclosingbal = "";
                        $Cclosingbal = "";
                        $bal = "0";
                        if ($drt >= $crt) {
                            $Dclosingbal = ($drt - $crt);
                            $Cclosingbal = "";
                            $bal = $Dclosingbal + " Dr";
                        } else if ($crt >= $drt) {
                            $Cclosingbal = ($crt - $drt);
                            $Dclosingbal = "";
                            $bal = $Cclosingbal + " Cr";
                        }
                        if ($Dclosingbal != "") {
                            $TDclosingbal += $Dclosingbal;
                        } else if ($Cclosingbal != "") {
                            $TCclosingbal += $Cclosingbal;
                        }
                        echo $bal;
                        ?></a>
                        </td>
                    </tr>
                    <tr>
                                <?php
                                $particulars = 'Purchase Accounts';
                                $trial_balc = $this->dbconnection->get_pl($particulars, $from_date, $to_date);
                                $drt = $trial_balc[0]->DEBIT;
                                $crt = $trial_balc[0]->CREDIT;
                                ?><td><a style="color: black;text-decoration: none;" target="_blank" href="<?php echo site_url(); ?>account/Profitloss_account/plreport/<?php echo $trial_balc[0]->GROUP_CODE; ?>"><strong>To Purchase Accounts</strong></a></td>
                        <td align="right">
                            <a style="color: black;text-decoration: none;" target="_blank" href="<?php echo site_url(); ?>account/Profitloss_account/plreport/<?php echo $trial_balc[0]->GROUP_CODE; ?>">
                                ₹<?php
                                $Dclosingbal = "";
                                $Cclosingbal = "";
                                $bal = "0";
                                if ($drt >= $crt) {
                                    $Dclosingbal = ($drt - $crt);
                                    $Cclosingbal = "";
                                    $bal = $Dclosingbal + " Dr";
                                } else if ($crt >= $drt) {
                                    $Cclosingbal = ($crt - $drt);
                                    $Dclosingbal = "";
                                    $bal = $Cclosingbal + " Cr";
                                }
                                if ($Dclosingbal != "") {
                                    $TDclosingbal += $Dclosingbal;
                                } else if ($Cclosingbal != "") {
                                    $TCclosingbal += $Cclosingbal;
                                }
                                echo $bal;
                                ?></a>
                        </td>
                                <?php
                                $particulars = 'Direct Incomes';
                                $trial_bald = $this->dbconnection->get_pl($particulars, $from_date, $to_date);
                                $drt = $trial_bald[0]->DEBIT;
                                $crt = $trial_bald[0]->CREDIT;
                                ?>
                        <td><a style="color: black;text-decoration: none;" target="_blank" href="<?php echo site_url(); ?>account/Profitloss_account/plreport/<?php echo $trial_bald[0]->GROUP_CODE; ?>"><strong>By Direct Incomes</strong></a></td>
                        <td align="right"><a style="color: black;text-decoration: none;" target="_blank" href="<?php echo site_url(); ?>account/Profitloss_account/plreport/<?php echo $trial_bald[0]->GROUP_CODE; ?>">₹
                                <?php
                                $Dclosingbal = "";
                                $Cclosingbal = "";
                                $bal = "0";
                                if ($drt >= $crt) {
                                    $Dclosingbal = ($drt - $crt);
                                    $Cclosingbal = "";
                                    $bal = $Dclosingbal + " Dr";
                                } else if ($crt >= $drt) {
                                    $Cclosingbal = ($crt - $drt);
                                    $Dclosingbal = "";
                                    $bal = $Cclosingbal + " Cr";
                                }
                                if ($Dclosingbal != "") {
                                    $TDclosingbal += $Dclosingbal;
                                } else if ($Cclosingbal != "") {
                                    $TCclosingbal += $Cclosingbal;
                                }
//echo $bal;
                                ?></a></td>
                    </tr>

                    <tr>
                                <?php
                                $particulars = 'Direct Expenses';
                                $trial_bale = $this->dbconnection->get_pl($particulars, $from_date, $to_date);
                                $drt = $trial_bale[0]->DEBIT;
                                $crt = $trial_bale[0]->CREDIT;
                                ?>
                        <td><a style="color: black;text-decoration: none;" target="_blank" href="<?php echo site_url(); ?>account/Profitloss_account/plreport/<?php echo $trial_bale[0]->GROUP_CODE; ?>"><strong>To Direct Expenses</strong></a></td>
                        <td align="right"><a style="color: black;text-decoration: none;" target="_blank" href="<?php echo site_url(); ?>account/Profitloss_account/plreport/<?php echo $trial_bale[0]->GROUP_CODE; ?>">
                                ₹ <?php
                                $Dclosingbal = "";
                                $Cclosingbal = "";
                                $bal = "0";
                                if ($drt >= $crt) {
                                    $Dclosingbal = ($drt - $crt);
                                    $Cclosingbal = "";
                                    $bal = $Dclosingbal + " Dr";
                                } else if ($crt >= $drt) {
                                    $Cclosingbal = ($crt - $drt);
                                    $Dclosingbal = "";
                                    $bal = $Cclosingbal + " Cr";
                                }
                                if ($Dclosingbal != "") {
                                    $TDclosingbal += $Dclosingbal;
                                } else if ($Cclosingbal != "") {
                                    $TCclosingbal += $Cclosingbal;
                                }
//echo $bal;
                                ?></a></td>

                        <td><strong>By Closing Stock</strong></td>
                        <td align="right">
                            ₹ <?php
                        $particulars = 'Direct Expenses';
                        $trial_bal = $this->dbconnection->get_pl($particulars, $from_date, $to_date);
                        $drt = $trial_bal[0]->DEBIT;
                        $crt = $trial_bal[0]->CREDIT;

                        $Dclosingbal = "";
                        $Cclosingbal = "";
                        $bal = "0";
                        if ($drt >= $crt) {
                            $Dclosingbal = ($drt - $crt);
                            $Cclosingbal = "";
                            $bal = $Dclosingbal + " Dr";
                        } else if ($crt >= $drt) {
                            $Cclosingbal = ($crt - $drt);
                            $Dclosingbal = "";
                            $bal = $Cclosingbal + " Cr";
                        }
                        if ($Dclosingbal != "") {
                            $TDclosingbal += $Dclosingbal;
                        } else if ($Cclosingbal != "") {
                            $TCclosingbal += $Cclosingbal;
                        }
//echo $bal;
                        ?></td>	
                    </tr>
                    <tr>
                        <td ><strong>To G.P</strong></td>
                                <?php
                                $lgp = 0;
                                $tgp = 0;
                                $rgp = 0;
                                if (($TDclosingbal) > ($TCclosingbal)) {
                                    $rgp = $TDclosingbal - $TCclosingbal;
                                    $tgp = $TDclosingbal;
                                } else {
                                    $lgp = $TCclosingbal - $TDclosingbal;
                                    $tgp = $TCclosingbal;
                                }
                                ?> 
                        <td align="right"><strong> ₹<?php echo number_format($lgp, 2); ?></strong></td>
                        <td ><strong>By G.P</strong></td>
                        <td align="right"><strong> ₹<?php echo number_format($rgp, 2); ?></strong></td>

                    </tr>
                    <tr>
                        <td><strong></strong>
                        <td align="right">₹ <?php echo number_format($tgp, 2); ?></td>
                        <td><strong></strong></td>
                        <td align="right">₹ <?php echo number_format($tgp, 2); ?></td>	
                    </tr>
                            <?php
                            if (($rgp) > ($lgp)) {
                                ?>
                        <tr>

                            <td ><strong>To G.P</strong></td>
                            <td align="right"><strong> ₹<?php echo $rgp; ?></strong></td>

                                <?php
                                $particulars = 'Indirect Incomes';
                                $trial_balf = $this->dbconnection->get_pl($particulars, $from_date, $to_date);
                                $drt = $trial_balf[0]->DEBIT;
                                $crt = $trial_balf[0]->CREDIT;
                                ?>
                            <td ><a style="color: black;text-decoration: none;" target="_blank" href="<?php echo site_url(); ?>account/Profitloss_account/plreport/<?php echo $trial_balf[0]->GROUP_CODE; ?>"><strong>Indirect Income</strong></a></td>
    <?php
    $Dclosingbal = "";
    $Cclosingbal = "";
    $bal = "0";
    if ($drt >= $crt) {
        $Dclosingbal = ($drt - $crt);
        $Cclosingbal = "";
        $bal = $Dclosingbal + " Dr";
    } else if ($crt >= $drt) {
        $Cclosingbal = ($crt - $drt);
        $Dclosingbal = "";
        $bal = $Cclosingbal + " Cr";
    }
    if ($Dclosingbal != "") {
        $TDclosingbal += $Dclosingbal;
    } else if ($Cclosingbal != "") {
        $TCclosingbal += $Cclosingbal;
    }
    ?>
                            <td align="right"><a style="color: black;text-decoration: none;" target="_blank" href="<?php echo site_url(); ?>account/Profitloss_account/plreport/<?php echo $trial_balf[0]->GROUP_CODE; ?>">₹ <?php echo number_format($bal, 2); ?></a></td>
                        </tr>
                        <tr>
    <?php
    $particulars = 'Indirect Expenses';
    $trial_balg = $this->dbconnection->get_pl($particulars, $from_date, $to_date);
    $drt = $trial_balg[0]->DEBIT;
    $crt = $trial_balg[0]->CREDIT;
    ?>
                            <td><a style="color: black;text-decoration: none;" target="_blank" href="<?php echo site_url(); ?>account/Profitloss_account/plreport/<?php echo $trial_balg[0]->GROUP_CODE; ?>"><strong>Indirect Expense</strong></a></td>
                        <?php
                        $Dclosingbal = "";
                        $Cclosingbal = "";
                        $bal = "0";
                        if ($drt >= $crt) {
                            $Dclosingbal = ($drt - $crt);
                            $Cclosingbal = "";
                            $bal = $Dclosingbal + " Dr";
                        } else if ($crt >= $drt) {
                            $Cclosingbal = ($crt - $drt);
                            $Dclosingbal = "";
                            $bal = $Cclosingbal + " Cr";
                        }
                        if ($Dclosingbal != "") {
                            $TDclosingbal += $Dclosingbal;
                        } else if ($Cclosingbal != "") {
                            $TCclosingbal += $Cclosingbal;
                        }
                        ?>
                            <td align="right"><a style="color: black;text-decoration: none;" target="_blank" href="<?php echo site_url(); ?>account/Profitloss_account/plreport/<?php echo $trial_balg[0]->GROUP_CODE; ?>">₹ <?php echo number_format($bal, 2); ?></a></td>

                            <td ><strong></strong></td>
                            <td align="right"><strong> </strong></td>
                        </tr>
                            <?php
                        } else {
                            ?>
                        <tr>
                            <?php
                            $particulars = 'Indirect Expenses';
                            $trial_balg = $this->dbconnection->get_pl($particulars, $from_date, $to_date);
                            $drt = $trial_balg[0]->DEBIT;
                            $crt = $trial_balg[0]->CREDIT;
                            ?>
                            <td ><a style="color: black;text-decoration: none;" target="_blank" href="<?php echo site_url(); ?>account/Profitloss_account/plreport/<?php echo $trial_balg[0]->GROUP_CODE; ?>"><strong>Indirect Expense</strong></a></td>
                            <?php
                            $Dclosingbal = "";
                            $Cclosingbal = "";
                            $bal = "0";
                            if ($drt >= $crt) {
                                $Dclosingbal = ($drt - $crt);
                                $Cclosingbal = "";
                                $bal = $Dclosingbal + " Dr";
                            } else if ($crt >= $drt) {
                                $Cclosingbal = ($crt - $drt);
                                $Dclosingbal = "";
                                $bal = $Cclosingbal + " Cr";
                            }
                            if ($Dclosingbal != "") {
                                $TDclosingbal += $Dclosingbal;
                            } else if ($Cclosingbal != "") {
                                $TCclosingbal += $Cclosingbal;
                            }
//echo $bal;										
                            ?>
                            <td align="right">₹ <?php echo number_format($bal, 2); ?></td>

                            <td ><strong>By G.P</strong></td>
                            <td align="right"><strong> ₹<?php echo number_format($rgp, 2); ?></strong></td>
                        </tr>
                        <!-- ******************************************************* -->
                        <tr>

                            <td ><strong> </strong></td>
                            <td align="right"><strong>  </strong></td>

                            <?php
                            $particulars = 'Indirect Incomes';
                            $trial_balf = $this->dbconnection->get_pl($particulars, $from_date, $to_date);
                            $drt = $trial_balh[0]->DEBIT;
                            $crt = $trial_balh[0]->CREDIT;
                            ?>
                            <td ><a style="color: black;text-decoration: none;" target="_blank" href="<?php echo site_url(); ?>account/Profitloss_account/plreport/<?php echo $trial_balh[0]->GROUP_CODE; ?>"><strong>Indirect Income</strong></a></td>
                            <?php
                            $Dclosingbal = "";
                            $Cclosingbal = "";
                            $bal = "0";
                            if ($drt >= $crt) {
                                $Dclosingbal = ($drt - $crt);
                                $Cclosingbal = "";
                                $bal = $Dclosingbal + " Dr";
                            } else if ($crt >= $drt) {
                                $Cclosingbal = ($crt - $drt);
                                $Dclosingbal = "";
                                $bal = $Cclosingbal + " Cr";
                            }
                            if ($Dclosingbal != "") {
                                $TDclosingbal += $Dclosingbal;
                            } else if ($Cclosingbal != "") {
                                $TCclosingbal += $Cclosingbal;
                            }
//echo $bal;										
                            ?>
                            <td align="right">₹ <?php echo number_format($bal, 2); ?></td>
                        </tr>
                            <?php
                        }
                        ?> 
                    <!-- ***************************************************************** -->	
                    <tr>
                        <td ><strong>N.P.</strong></td>
                        <?php
                        $np = $TCclosingbal - $TDclosingbal;
                        ?> 
                        <td align="right" ><strong> ₹ <?php echo number_format($np, 2); ?></strong></td>

                    </tr>
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

