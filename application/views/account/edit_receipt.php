<div class="page-content-inner">
    <div class="box">
        <div class="box-body">
            <div class="row action_section">
                <div class="row">
                    <!-- <div class="col-md-4 col-md-offset-4">
                    <div class="alert alert-success alert-dismissible"  id="success-alert">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">�</a>
                    <strong>Success!</strong>
                    </div>
                    </div> -->

                    <form id="form_editpayment" action="<?php echo base_url('account/Acc_ledger/ud_receipt'); ?>" method="post">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-7"><a href="<?php echo base_url('account/Acc_ledger'); ?>" class="btn btn-primary btn-sm pull-left">Back</a></div>
                            <div class="col-md-4 pull-right">
                            <!--  <span style="color: red">NOTE:-*To add new Voucher Details press Ctrl+B<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*To Delete Voucher Details press Ctrl+D</span> -->
                            </div>
                        </div>
                        <?php
                        foreach ($data as $val) {
//print_r($val);
                        }
                        ?>


                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                                <label for="Voucher">Voucher No</label>                     
                                <input class="form-control" type="text" readonly="" name="voucher_no" id="voucher_no" style="cursor:not-allowed;width: 350px;" value="<?php echo $val->VOUCHER; ?>">   
                            </div>

                            <div class="col-md-5 pull-right">
                                <label for="Date">Date</label><br>                  
                                <input type="date" name="date" id="date" value="<?php echo $val->DATE; ?>" class="form-control" style="width: 50%">
                            </div>
                            <div class="col-md-1"></div>
                        </div>         

                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <table class='table' id="result">
                                    <thead>
                                        <tr>
                                            <th>CR/DR</th>
                                            <th>Particulars</th>
                                            <th>Amount</th>
                                            <th><button type="button" class="btn btn-success btn-sm pull-right" name="add" id="add">ADD</button></th>                 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($data as $result) {
// print_r($result);       
                                            ?>
                                            <tr>                         
                                                <?php $crdr = $result->D_C; ?>
                                                <td>
                                                    <select class="form-control" name="crdr[]" id="crdr_<?php echo $i; ?>" required >
                                                        <option value=''>Select</option>
                                                        <option value="CR" <?php if ($crdr == 'CR') {
                                                echo 'selected';
                                            } ?>>CR</option>
                                                        <option value="DR" <?php if ($crdr == 'DR') {
                                                echo 'selected';
                                            } ?>>DR</option>
                                                    </select>
                                                </td>
                                                <td style="width: 400px;">
                                                    <select class="form-control" name="particulars[]" id="particulars_<?php echo $i; ?>" required>
                                                        <option value="">Select</option>
    <?php foreach ($ledger as $value_name) { ?>                    
                                                            <option value="<?php echo $value_name->id; ?>" <?php if ($result->PARTICULARS == $value_name->id) {
            echo 'selected';
        } ?>><?php echo $value_name->ledger_name; ?></option>
                                                    <?php } ?>
                                                    </select>
                                                </td>
                                                <td style="width:350px;">

                                                    <input type="text" name="amount[]" id="amount_<?php echo $i; ?>" class="form-control" value="<?php if ($crdr == 'CR') {
                                                    echo $result->CREDIT;
                                                } else if ($crdr == 'DR') {
                                                    echo $result->DEBIT;
                                                }
                                                ?>" required onkeyup='totamt(this)'>
                                                </td>  
                                                <td onclick='rv(this)'><a <strong>X</strong></a></td>         
                                            </tr>
    <?php
    $i++;
}
?>
                                    </tbody>            
                                </table>
                            </div>
                            <div class="col-md-1"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <center><label>Narration</label></center>
                                <textarea class="form-control" style="background: lightgrey;" id="narration" name="narration" rows="3" placeholder="Give Information"><?php echo $result->NARRATION; ?></textarea>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <table class="table">
                                    <tr>
                                        <th colspan="11" style="width:80%; text-align:right">Total DR</th>
                                        <td><input class="form-control" type="text" readonly="" name="total_debit" id="total_debit" style="cursor:not-allowed;" placeholder="Rs."></td></tr>
                                    <tr>
                                        <th colspan="11" style="width:80%; text-align:right">Total CR</th>
                                        <td><input class="form-control" type="text" readonly="" name="total_credit" id="total_credit" style="cursor:not-allowed;" placeholder="Rs."></td></tr>

                                </table>
                            </div>
                            <div class="col-md-1"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 col-md-offset-5">                               
                                <input type="hidden" class="form-control" name="c_id" value="<?php echo $result->ID; ?>">
                                <button type="submit" class="btn btn-primary" id="btnsubmit"> <span class="glyphicon glyphicon-ok"></span> Update</button> 

                                <a class="btn btn-primary" id="delsubmit" onclick="deletes('<?php echo $result->BILL_GEN_NO; ?>')"> <span class="glyphicon glyphicon-ok"></span> Delete</a>                               
                            </div>            
                        </div>
                    </form>
                </div>         
            </div>
        </div>
    </div>
</div>


<script>
    var tlen = $("#result>tbody>tr").length;
    var counter = tlen + 1;
    $("#add").click(function () {
        var row = "<tr id='delete'><td><select class='form-control' name='crdr[]' id='crdr_" + counter + "' required ><option value=''>Select</option><option value='CR'>CR</option><option value='DR'>DR</option></select></td><td><select class='form-control' name='particulars[]' id='particulars_" + counter + "' required><option value=''>Select</option><?php foreach ($ledger as $value_name) { ?><option value='<?php echo $value_name->id; ?>'><?php echo $value_name->ledger_name; ?></option><?php } ?></select></td><td><input type='text' name='amount[]' id='amount_" + counter + "' class='form-control' required onkeyup='totamt(this)'></td><td style='width:10px;' onclick='rv(this)'><a class='btn btn-success btn-sm pull-right'><strong>X</strong></a></td></tr>";
        $("#result").append(row);
        $('select').select2({width: '100%'});
        $('select').on("select2:close", function () {
            $(this).focus();
        });
        counter++;
    });


    function rv(abc)
    {
        $(abc).parent('tr').remove();
        totamt();
    }



    function totamt()
    {
        var tlen = $("#result>tbody>tr").length;
        var counter = tlen + 1;
        var tdebit = 0;
        var tcredit = 0;
        for (var i = 1; i <= tlen; i++)
        {
            var crdrr = $("#crdr_" + i).val();
            var amt = $("#amount_" + i).val();


            if (crdrr == "DR")
            {
                tdebit += Number(amt);
            }

            if (crdrr == "CR")
            {
                tcredit += Number(amt);
            }

        }
        $("#total_debit").val(tdebit);
        $("#total_credit").val(tcredit);
        if (tcredit != tdebit)
        {
            var bal = Number(tcredit - tdebit);
            $("#btnsubmit").prop('disabled', true);
        } else
        {
            $("#btnsubmit").prop('disabled', false);
        }
    }

    $(document).ready(function () {
        $("#success-alert").fadeTo(2000, 500).slideUp(500, function () {
            $("#success-alert").fadeOut(500);
        });
    });


    function deletes(id)
    {
        var r = confirm("Are You Sure Want To Delete ?");
        if (r == true)
        {
            $.ajax({
                url: "<?php echo base_url('account/Acc_ledger/delt_ajax_return'); ?>",
                type: "POST",
                data: {id: id},
                success: function (data)
                {
                    alert('Data Deleted Successfully');
                    window.location = 'index';
//location.reload();
                },
            });
        } else
        {

        }
    }
</script>
<script>
    window.onload = function () {

        var tlen = $("#result>tbody>tr").length;
        var counter = tlen + 1;
        var tdebit = 0;
        var tcredit = 0;
        for (var i = 1; i <= tlen; i++)
        {
            var crdrr = $("#crdr_" + i).val();
            var amt = $("#amount_" + i).val();

            if (crdrr == "DR")
            {
                tdebit += Number(amt);

            }
            if (crdrr == "CR")
            {
                tcredit += Number(amt);
            }

        }
        $("#total_debit").val(tdebit);
        $("#total_credit").val(tcredit);
        if (tcredit != tdebit)
        {
            var bal = Number(tcredit - tdebit);
            $("#btnsubmit").prop('disabled', true);
        } else
        {
            $("#btnsubmit").prop('disabled', false);
        }
    }


</script>
