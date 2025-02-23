<div class="form-group has-feedback">
    <div class="box">            
        <div class="box-body">
            <!--  <div class="col-lg-12">
            <div class="col-lg-12" style="text-align:right; padding-top: 20px;"><a href="<?php echo base_url(); ?>academics/paper_creditlist" class="btn btn-success">  BACK  </a></div>
            </div> -->
        </div>

        <div class="box-body">
            <form id="form_exam" action="<?php echo base_url('account/Payment/add_payment'); ?>" method="post">
                <div class="row">

                    <div class="col-md-4 form-group">
                        <label for="exampleFormControlSelect1">Voucher No</label>
                        <input type="text" class="form-control" name="voucher_no" id="voucher_no" value="<?php echo $voucher_no; ?>" style="cursor:not-allowed" readonly>   	
                    </div>

                    <div class="col-md-3 form-group col-md-offset-2">
                        <label for="exampleFormControlSelect1">Date</label>
                        <input type="date" class="form-control" id="date" name="date" value="<?php echo date("Y-m-d"); ?>">	
                    </div>

                </div>
                <hr>

                <table class="table" id="result">
                    <thead>
                    <th>CR/DR</th>
                    <th>Particulars</th>
                    <th>Amount</th>											

                    <th>
                        <button type="button" class="btn btn-success btn-sm pull-right" name="add" id="addd" ><i class="fa fa-plus-circle fa-lg"></i>Add</button>
                    </th>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width: 300px;"> 
                                <select name="crdr[]" id="crdr_1" class='form-control input-sm' required>
                                    <option value="">Select</option>
                                    <option value="DR">DR</option>
                                    <option value="CR">CR</option>		
                                </select>
                            </td>
                            <td>													
                                <select name="particulars[]" id="particulars_1" class='form-control input-sm' required>
                                    <option value="">Select</option>
                                    <?php foreach ($ledger as $value_name) { ?>
                                        <option value="<?php echo $value_name->id; ?>"> <?php echo $value_name->ledger_name; ?></option>
                                    <?php } ?>
                                </select>					
                            </td>

                            <td style="width: 300px;">													
                                <input type="number" class="form-control" name="amount[]" id="amount_1" required onchange='totamt(this)' onkeypress="eway__()">	
                            </td>

                            <td></td>
                        </tr>
                    </tbody>
                </table>

                <div class="row">        
                    <div class="col-md-10 form-group">
                        <label for="exampleFormControlSelect1">Narration</label>
                        <textarea class="form-control" id="narration" name="narration" rows="3" placeholder="Give Information"></textarea>
                    </div>	

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
                <div class="box-body" id="addbutton">
                    <input type='submit' class="btn btn-success pull-right"  id='btnsubmit' name='submit_pay' onclick="eway()" value='SUBMIT' class='btn btn-success'>
                </div>

                <div id="eway_bill" class="modal fade" role="dialog">
                    <div class="modal-dialog" style="width:70%;">
                        <div class="modal-content">
                            <div class="modal-body">
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table" id="results" width="100%">
                                            <thead>
                                            <th>Sr.No</th>
                                            <th width="350px">Option</th>
                                            <th width="280px">Voucher No</th>
                                            <th width="200px">Amount</th>
                                            <th><button type="button" class="btn btn-success btn-sm pull-right" name="adds" id="adds">ADD</button></th>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                <tr>
                                                    <td><?php echo $i ?></td>
                                                    <td width="350px">
                                                        <input type="radio" name="radio1[]" id="radio_1" value="against reffrence">Against Reffrence
                                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="radio1[]" id="radio_1" value="advance">Advance

                                                    </td>
                                                    <td width="280px">
                                                        <select class="form-control select2" name="outstanding[]" id="outstanding_1">
                                                            <option>Select</option>
                                                            <?php foreach ($outstanding_reports as $value_report) { ?>                    
                                                                <option value="<?php echo $value_report->bill_no; ?>"><?php echo $value_report->bill_no; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                    <td width="200px"><input type="text" class="form-control" name="amounts[]" id="amounts_1"></td>
                                                </tr>
                                                <?php $i++; ?>
                                            </tbody>
                                        </table>
                                    </div>                         
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-primary" data-dismiss="modal" onClick="clearform_();">PROCEED</a>
                                <a class="btn btn-default" data-dismiss="modal">Close</a>
                            </div>
                        </div>
                    </div>
                </div>  

            </form>
        </div>
    </div>

</div>

<script>
    function clearform()
    {
        document.getElementById("results").value = "";
        document.getElementById("radio_1").value = "";
        document.getElementById("outstanding_1").value = "";
        document.getElementById("amounts_1").value = "";
    }
    function eway()
    {
        $('#eway_bill').modal({backdrop: 'static', keyboard: false, show: true});
        /*var url = "<?php echo base_url('outstanding_data'); ?>",*/

        $.ajax({

            url: "<?php echo base_url('outstanding_data'); ?>",
            type: "POST",
            data: $('#form_payment').serialize(),
            dataType: "JSON",
            success: function (data)
            {

                $('#outstanding_1').html('');
                $('#outstanding_1').html(data.successdata);
                /*$('#crdr').val();
                 $('#particulars').val();
                 $('#date').val();
                 //alert(data); // show response from the php script.*/

            }
        });


    }

    var counter = 2;
    $("#addd").click(function () {
        var tlen = $("#result>tbody>tr").length;
        counter = tlen + 1;
        var row = "<tr id='delete'><td><select class='form-control' name='crdr[]' id='crdr_" + counter + "' required><option value=''>Select</option><option value='CR'>CR</option><option value='DR'>DR</option></select></td><td><select class='form-control' name='particulars[]' id='particulars_" + counter + "' required><option value=''>Select</option><?php foreach ($ledger as $value_name) { ?><option value='<?php echo $value_name->id; ?>'><?php echo $value_name->ledger_name; ?></option><?php } ?></select></td><td><input type='number' class='form-control' name='amount[]' id='amount_" + counter + "' required onchange='totamt(this)'></td><td onclick='rv(this)'><a><strong>X</strong></a></td></tr>";
        $("#result").append(row);
        $('select').select2({width: '100%', theme: "classic"});//      
        $('select').on("select2:close", function () {
            $(this).focus();
            counter++;
        });

    });

    function rv(abc)
    {
        $(abc).parent('tr').remove();
        totamt();
    }


    $("#adds").click(function () {
        row_no = Number(document.getElementById("results").rows.length) + '.';

        var rows = '<tr id="deletes"><td>' + row_no + '</td><td><input type="radio" name="radio1[]" id="radio_' + counter + '" value="against reffrence">Against Reffrence &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type="radio" name="radio1[]" id="radio_' + counter + '" value="advance">Advance</td><td><select class="form-control select2" name="outstanding[]" id="outstanding_' + counter + '"><option>Select</option><?php foreach ($outstanding_reports as $value_report) { ?><option value="<?php echo $value_report->bill_no; ?>"><?php echo $value_report->bill_no; ?></option><?php } ?></select></td><td><input type="text" class="form-control" name="amounts[]" id="amounts_' + counter + '"></td><td onclick="rv(this)"><a class="btn btn-success btn-sm pull-right">X<strong></strong></a></td></td></tr>'
        $("#results").append(rows);
        $('select').select2({width: '100%'});
        $('select').on("select2:close", function () {
            $(this).focus();
        });
        counter++;
    });


// function del(del){
//   $(del).parent('tr').remove();
// }

    function totamt(cred)
    {
        var tlen = $("#result>tbody>tr").length;
        var tdebit = 0;
        var tcredit = 0;
//$('input[name^=amount]').each(function () 
        for (var i = 1; i <= tlen; i++)
        {
//var crdrr = $(this).parent('td').next('td').find("input[name='crdr[]']").val();
//var amt = $(this).parent('td').next('td').find("input[name='amount[]']").val();
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
    $('#eway_bill').on('hidden.bs.modal', function (e) {
        document.form_payment.submit();
    });
</script>
