<div class="form-group has-feedback">
    <div class="box box-primary">
        <div class="page-content-inner">
            <!--<div class="box">-->
                <div class="box-body">
                    <div class="col-lg-12">
                        <div class="col-lg-12" style="text-align:right; padding-top: 20px;"><a href="<?php echo base_url(); ?>account/Acc_ledger" class="btn btn-success"> BACK </a></div>
                    </div>
                    <hr/>
                </div>

                <div class="box-body">	    			 
                    <form name="gstledger" class="form-inline" method="post" action="<?php echo base_url('account/Group_ledger/add_groupledger'); ?>">
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
                            <input type="date" class="form-control from-date" id="from_date" name="from_date" value="<?php echo $from_date; ?>">
                        </div>
                        <div class="form-group col-md-2 col-sm-3">
                            <label></label>
                            <input type="date" class="form-control" id="to_date" name="to_date" value="<?php echo date("Y-m-d"); ?>">
                        </div>
                        <div class="form-group col-md-2 col-sm-3 col-md-offset-1" style="margin-top: 15px;" >
                            <input type="hidden" name="ledger_name" id="ledger_name" value="<?php //echo $ledgernameas[0]->id;  ?>">
                            <input type="submit" class="btn btn-primary" value="Search" name="submit1">
                        </div>
                    </form>
                </div>
                <div class="box-body">		    
                    <table id="examples" class="table table-striped table-bordered" style="width:100%;">
                        <thead>
                            <tr>				            
                                <th>Particular</th>		
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>ID</th>				              	                
                            </tr> 
                        </thead>				      
                        <tbody>
                            <?php
                            $i = 1;
                            $tdebit = 0;
                            $tcredit = 0;
                            foreach ($accountsgroups as $value) {
                                $drt = $value->DEBIT;
                                $crt = $value->CREDIT;
                                $GID = $value->GID;

                                $Dclosingbal = "";
                                $Cclosingbal = "";
                                if ($drt >= $crt) {
                                    $Dclosingbal = ($drt - $crt);
                                    $tdebit += $Dclosingbal;
                                    $Cclosingbal = "";
                                }
                                if ($crt >= $drt) {
                                    $Cclosingbal = ($crt - $drt);
                                    $tcredit += $Cclosingbal;
                                    $Dclosingbal = "";
                                }
                                ?>
                                <tr>
                                    <td><a style="color: black;text-decoration: none;" target="_blank" href="<?php echo site_url(); ?>account/Group_ledger/ledgerreport/<?php echo $value->GID; ?>"><?php echo $value->PARTICULARS; ?></a></td>
                                    <td align="right"><a style="color: black;text-decoration: none;" target="_blank" href="<?php echo site_url(); ?>account/Group_ledger/ledgerreport/<?php echo $value->GID; ?>"><?php echo number_format(abs($Dclosingbal), 2); ?></a></td>
                                    <td align="right"><a style="color: black;text-decoration: none;" target="_blank" href="<?php echo site_url(); ?>account/Group_ledger/ledgerreport/<?php echo $value->GID; ?>"><?php echo number_format(abs($Cclosingbal), 2); ?></a></td>
                                    <td><a style="color: black;text-decoration: none;" target="_blank" href="<?php echo site_url(); ?>account/Group_ledger/ledgerreport/<?php echo $value->GID; ?>"><?php echo $value->GID; ?></a></td>
                                </tr>
                                <!--end opening value-->
    <?php
    $i++;
}
?>


                        <tfoot style="background-color:#DCDCDC;">
                            <tr>
                                <td><b><?php echo "   Total :"; ?></b></td>	
                                <td align="right"><b><?php echo number_format(abs($tdebit), 2); ?></b></td>
                                <td align="right"><b><?php echo number_format(abs($tcredit), 2); ?></b></td>
                                <td></td>			                
                            </tr>
                        </tfoot>

                        </tbody>
                    </table>

                </div>
<!--            </div>-->
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
</script>
