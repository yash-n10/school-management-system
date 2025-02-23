
<div class="panel  panel-default">

    <div class="panel-heading" style="padding: 5px 15px;background: #C70039;color:white"><i class="glyphicon glyphicon-info-sign"></i> <b>Choose Admission No and Payment Date</b></div>
    <div class="panel-body" style="padding:0px">
        <table class="table" style="border:0px">


            <tr style="border-left:20px !important;">
            <input type="hidden" id="sid" name="sid" value="<?php echo $school_id ?>">

            <td>
                <select class="form-control" required id="adm" name="adm">
                            <option id="0"> Select Admission No</option>
                            <?php foreach ($student as $row) { ?>
                                <option value="<?php echo $row->admission_no ?>" data-id="<?php echo $row->id ?>"><?php echo $row->admission_no; ?></option>
                            <?php } ?>
                </select>
            </td>

            <td>

               <input type="date" name="pay_date" id="pay_date" placeholder="Payment Date" required class="form-control">

            </td>

            <td>

                    <button type="button" class="btn btn-success" id="trans_detail_submit1">Submit</button>                                           

            </td>

            </tr>


        </table>   
    </div>



</div>




<script>

    $('#trans_detail_submit1').click(function ()
    {
        var scool_id = $('#sid').val();
//       alert(scool_id);
        var adm_no = $('#adm').val();
        var stud_id = $('#adm').find(':selected').attr('data-id');
//       alert(adm_no);
        var date = $('#pay_date').val();
//       alert(date);

        if (adm_no == '' || date == '')
        {
            alert('Please enter required field');
        } else
        {
            $.ajax(
                    {
                        type: "POST",
                        data: {
                            school_id: scool_id,
                            adm: adm_no,
                            stud_id: stud_id,
                            pay_date: date,
                            autostatus:'false'
                        },
                        url: "<?php echo base_url('Backend/get_trans_status'); ?>",
                        dataType: "text",
                        success: function (data)
                        {
                            $('#fee_stud_trans_det').html(data);
                        },
                        error: function (req, status)
                        {
                            alert('error' + req);
                        }
                    });
        }
    });


</script>