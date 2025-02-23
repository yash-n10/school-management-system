<style>
    tr.highlight {
    background-color: antiquewhite !important;
    border-color: #d6e9c6 !important;

   
    }
</style>
<div class="panel  panel-success" style="border-color: darkseagreen">
    <div class="panel-heading" style="padding: 5px 15px;background: #c7eab9;border-color: darkseagreen"><i class="glyphicon glyphicon-th-list"></i> <b> <span style="color:black">Transaction Details</span></b></div>
    <div class="panel-body" style="padding:0px">
        <form id="trans_form" name="trans_form">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="trans_tbl">
                    <thead>
                        <tr>
                            <th>Admission No.</th>
                            <th>Student Id</th>
                            <th>Student Name</th>
                            <th>Merchant Ref No.</th>
                            <th>Payment Id</th>
                            <th>Payment Date</th>
                            <th>Payment Method</th>
                            <!--<th>No of Months</th>-->
                            <th>Monthly Amount</th>
                            <th>Annual Amount</th>
                            <th>Half yearly Amount</th>
                            <th>Other Fee Amount</th>
                            <th>Fine Amount</th>
                            <!--<th>Description</th>-->
                            <th>Transaction Id</th>
                            <th>Response Message</th>
                            <th>Status</th>

                        </tr>
                    </thead>


                    <tbody id="trans_tbody">
                        <?php for ($j = 0; $j < $count; $j++) { ?>
                            <tr id="tbl_rw">
                                <td id="adm" name="adm"><?php echo $stud_admission[$j]; ?></td>
                                <td id="stud_id" name="stud_id"><?php echo $student_id[$j]; ?></td>
                                <td id="stud_name" name="stud_name"><?php echo $stud_name[$j]; ?></td>
                                <td id="ref_no" name="ref_no"><?php echo $description[$j]; ?></td>
                                <td name="pay_id" id="pay_id"><?php echo $pay_id[$j]; ?></td>
                                <td name="pay_date" id="pay_date"><?php echo $pay_date[$j]; ?></td>
                                <td name="pay_meth" id="pay_meth"><?php echo $pay_method[$j]; ?></td>

                                <?php if ($fee == 0) { ?>
                                    <td id="mnth_amnt" name="mnth_amnt"><?php echo '0'; ?></td>
                                    <td id="ann" name="ann"><?php echo '0'; ?></td>
                                    <td id="half" name="half"><?php echo '0'; ?></td>
                                    <td id="other" name="other"><?php echo '0'; ?></td>
                                    <td id="fine" name="fine"><?php echo '0'; ?></td>
                                <?php } else {
//                                    for ($k = 0; $k < $fee; $k++) { ?>
                                        <td id="mnth_amnt" name="mnth_amnt"><?php echo $paid_mnthly[$j]; ?></td>
                                        <td id="ann" name="ann"><?php echo $anual[$j]; ?></td>
                                        <td id="half" name="half"><?php echo $half_yearly[$j]; ?></td>
                                        <td id="other" name="other"><?php echo $other[$j]; ?></td>
                                        <td id="fine" name="fine"><?php echo $fine[$j]; ?></td>
        <?php // }
    } ?>
                                <!--<td id="desc" name="desc"><?php // echo $description[$j]; ?></td>-->
                                <td name="trans_id" id="trans_id"><?php echo $trans_id[$j]; ?></td>
                                <td name="resp" id="resp"><?php echo $response[$j]; ?></td>
                                <td id="status" name="status"><?php echo $status[$j]; ?></td>
                            </tr>
<?php } ?>

                    </tbody>

                </table>
            </div>
        </form>

    </div> 
</div>

<div class="panel" style="text-align:right; margin-top:10px; margin-bottom:10px;border:0px;box-shadow:0px">
    <input type="button" class="btn btn-success" value="Get Details TO Update" id="update_tran" name="update_tran">
</div>

<div id="fill_det" class="panel">

</div>


<script>

    var school_id = "<?php echo $school_id; ?>";
    var date_payment = "<?php echo $date_payment; ?>";
    var school_code = "<?php echo $scl_code; ?>";
    var autostatus = "<?php echo $autostatus; ?>";
    
    var table =$('#trans_tbl').DataTable( {
                "scrollX": true,
                "scrollY": "300px",
                "scrollCollapse": true,
                "paging":         false,
                "order": [[5, "asc"]]
            } );
            $('#trans_tbl tbody').on( 'click', 'td', function () {
                var colIdx = table.cell(this).index().row;
    //            alert(colIdx);
                $('.highlight').removeClass( 'highlight' );
                $( table.row( colIdx ).nodes() ).addClass( 'highlight' );
            } );
    $('#update_tran').click(function ()
    {
        var adm_no = $('#trans_tbl').find('td:eq(0)').html();
        var stud_id = $('#trans_tbl').find('td:eq(1)').html();
        var date = $('#trans_tbl').find('td:eq(5)').html();
//    alert(date);
//    var ref_no= "<?php // echo $description[$j] ?>";
//    alert(ref_no);

        $.ajax({
            type: 'POST',
            data: {admission: adm_no,
                studnt_id: stud_id,
                pay_date: date_payment,
                school_id: school_id,
                scl_code: school_code,
                pgw: 'HDFC',
                autostatus:autostatus
            },
            url: "<?php echo base_url('backend/load_div'); ?>",
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
    });
</script>