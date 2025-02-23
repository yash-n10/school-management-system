
    <div class="panel-body" style="padding:0px;">
        <form  id="transac_form" name="transac_form">

            <div class="col-md-8" style="padding:1%;">
                <div class="box " style="border: 1px solid lightgrey;">
                    <div class="box-header" style="background: aliceblue;padding:5px">
                        <h4 class="box-title" >Paid Details</h4>
                    </div>
                    <div class="box-body">

                       
                            <table class="table" style="border:0px;margin:0px; padding:5px;" id="paid_details">
                                <thead>
                                <th> Paid For</th>
                                <th>Amount</th>
                                <th>Payment Date</th>
                                <th>Transaction ID</th>
                                <th>Payment ID</th>
                                <th>Order ID</th>
                                <th>Paid Using</th>

                                </thead>
                                <tbody>
                                <?php 
                                 for ($j = 0; $j < $count_ann; $j++) { ?>
                                    <tr>
                                        <td> <?php if($cat_id[$j]==2 || $cat_id[$j]==5) echo $mnth[$j]; else echo $fee_category[$cat_id[$j]]; ?></td>
                                        <td> <?php echo $ann_amnt[$j]; ?></td>
                                        <td> <?php echo $ann_pay_date[$j]; ?></td>
                                        <td> <?php echo $ann_trans_id[$j]; ?></td>
                                        <td> <?php echo $ann_pay_id[$j]; ?></td>
                                        <td> <?php echo $ann_order_id[$j]; ?></td>
                                        <td> <?php echo $ann_pay_mode[$j]; ?></td>
                                    </tr>
                                <?php } ?>

                                    
                                </tbody>
                            </table>
                    
                    </div>
                </div>
            </div>


            <div class="col-md-4" style="padding:1%;">
                <div class="box " style="border: 1px solid lightgrey;">
                    <div class="box-header" style="background: aliceblue;padding:5px">
                        <h4 class="box-title" >Payment Details To Update</h4>
                    </div>
                    <div class="box-body">

                        <div class='row'>

                            <div class="col-md-12" style="padding:10px;">
                                <label class="col-md-5">Merchant Ref No/Order ID</label>
                             <?php // if($pgw=='HDFC'){?>
                             <?php if($autostatus=='true'){
                                 $readonly='readonly';?>
                            
                               
                                <select class="col-md-7" name="ref_no" id="ref_no">
                                    <option value="0"> Select Merchant Ref No</option>
                                    <?php for ($i = 0; $i < $cnt; $i++) { ?>
                                        <option value="<?php echo $ref[$i] ?>"><?php echo $ref[$i] ?></option>
                                    <?php } ?>
                                </select>
                            
                             <?php } else{
                                 $readonly='';?>
                                <input class="col-md-7" type="text" class="form-control"  name="ref_no" id="ref_no" placeholder="Enter merchant ref no">
                             <?php }?>
                            </div>    
                            <div class="col-md-12" style="padding:10px;">
                                <label class="col-md-5">Payment Date</label>
                                <input class="col-md-7" type="text" class="form-control" id="pay_date" name="pay_date" readonly>
                            </div>

                            <div class="col-md-12" style="padding:10px;">
                                <label class="col-md-5">Payment Id</label>
                                <input class="col-md-7" type="text" class="form-control" id="paym_id" name="paym_id" <?php echo $readonly;?> placeholder="Enter payment id">
                            </div>

                            <div class="col-md-12" style="padding:10px;">
                                <label class="col-md-5">Transaction Id</label>
                                <input class="col-md-7" type="text" class="form-control" id="transac_id" name="transac_id" <?php echo $readonly;?> placeholder="Enter transaction id">
                            </div>

                            <div class="col-md-12" style="padding:10px;">
                                <label class="col-md-5">Payment Method</label>
                                <input class="col-md-7" type="text" class="form-control" id="pay_method" name="pay_method" <?php echo $readonly;?> placeholder="Enter payment method">
                            </div>  
                            <div class="col-md-12" style="padding:10px;">
                                <label class="col-md-5">Payment Mode</label>
                                <input class="col-md-7" type="text" class="form-control" id="pay_mode" name="pay_mode" <?php echo $readonly;?> placeholder="Enter payment mode">
                            </div> 
                            <div class="col-md-12" style="padding:10px; text-align: center;">
                                <input type="button" class="btn btn-success" id="update" name="update" value="Update Transaction">
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </form>
    </div>



<script>
    var scl_code = "<?php echo $school_code ?>";
    var scl_id = "<?php echo $school_id ?>";
    var paymnt_date = "<?php echo $paymnt_date ?>";
    var pgw = "<?php echo $pgw; ?>";
    var autostatus = "<?php echo $autostatus; ?>";
    $('#transac_form #ref_no').change(function ()
    {
        var mer = $('#transac_form #ref_no').val();

        var orderid=[];
        $('#paid_details>tbody>tr>td:nth-child(6)').each(function()
        {
         
          orderid.push($(this).text().trim());  
          
        });

        if($.inArray(mer.trim(),orderid)!=-1){
            
            alert('Already Updated with this Merchant Ref No/Order Id !!! ');
            $('#update').attr('disabled',true);
        }else{

         $('#update').attr('disabled',false);
        $.ajax({
            type: "POST",
            data: {ref: mer,
                scool_code: scl_code,
                pgw: pgw,
                scool_id: scl_id},
            dataType: "JSON",
            url: "<?php echo base_url('backend/fill_data') ?>",
            success: function (data)
            {
                $.each(data, function (index, element)
                {
                    $('#transac_form #pay_date').val(data['paym_date3']);
                    $('#transac_form #paym_id').val(data['pay_id']);
                    $('#transac_form #transac_id').val(data['trans_id']);
                    $('#transac_form #pay_method').val(data['pay_method']);
                    $('#transac_form #pay_mode').val(data['pay_mode']);
                });
            },
            error: function (data)
            {
                alert('error');
            }
        });
        }
    });


    $('#update').click(function ()
    {
        var mer = $('#transac_form #ref_no').val();
//        var stud_id=$('#trans_tbl').find('td:eq(1)').html();
//        alert(mer);
        var form_data = $('#transac_form').serialize() + '&school_code=' + scl_code + '&school_id=' + scl_id;
//        alert(form_data);
        if (mer != '')
        {
            var r = confirm("Are you sure you want to update this transaction?");
            if (r == true) {
                $.ajax({
                    type: "POST",
                    data: form_data,
                    dataType: "text",
                    url: "<?php echo base_url('backend/save_transaction'); ?>",
                    success: function (data)
                    {
                        alert(" Updated Successfully");
                        $('#update').attr('disabled', true);
                        if(pgw=='HDFC' || (pgw=='CCAVENUE' && autostatus=='true')) {
                            var adm_no=$('#trans_tbl').find('td:eq(0)').html();
                            var stud_id=$('#trans_tbl').find('td:eq(1)').html();
                            var date=$('#trans_tbl').find('td:eq(5)').html();
                            var urlfn="<?php echo base_url('backend/load_div')?>";
                        }else{
                            var adm_no=$('#fee_stud_trans1 #adm').val();
                            var stud_id=$('#fee_stud_trans1 #adm').find(':selected').attr('data-id');
                            var date=$('#fee_stud_trans1 #pay_date').val();
                            var urlfn="<?php echo base_url('backend/Worldline_trans_status/')?>"+scl_id+'/'+scl_code+'/'+pgw;
                        }
                        $.ajax({
                            type: 'POST',
                            data: {admission: adm_no,
                                adm: adm_no,
                                studnt_id: stud_id,
                                pay_date: paymnt_date,
                                school_id: scl_id,
                                scl_code: scl_code},
                            url: urlfn,
                            dataType: "text",
                            success: function (data)
                            {
                                $('#fill_det').html(data);
                            },
                            error: function (req, status)
                            {
                                alert('error');
                            }
                        });
//                        window.location.reload();
                    },
                    error: function ()
                    {
                        alert("error");
                    }
                });
            } else
            {
                return false;
            }
        } else
        {
            alert('Please enter the required details');
        }
    });
</script>