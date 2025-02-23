<style>
    fieldset { 
        border: solid 1px #DDD !important;
        padding: 0 10px 10px 10px;
        border-bottom: none;
        /*background:beige;*/
    }
    legend{
        width: auto !important;
        padding:0 10px;
        border: none;
        font-size: 15px;
        color:green;
        margin-bottom: 8px !important; 
    }
    ul#menu li {
        display:inline;

    }

</style>
    <!-- Modal -->
<div id="myModalReceipt" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Receipt Download</h4>
      </div>
      <div class="modal-body">
          <p>1.) <a id="single-copy" href="" class="btn"><i class="glyphicon glyphicon-download-alt"> </i> Single Copy Receipt</a></p>
          <p>2.) <a id="double-copy" href="" target="_blank" class="btn" style="color:#555285;"><i class="glyphicon glyphicon-circle-arrow-down"> </i>  Double copy Receipt</a></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="mdlclose">Close</button>
      </div>
    </div>

  </div>
</div>
<div class="form-group has-feedback">
    <div class="box"> 


        <?php
        if (isset($errors) && count($errors) > 0) {
            ?>
            <div class="box">
                <div class="box-body">
                    <legend><u>Errors</u></legend>
                    <pre>
                        <?php
//    print_r($errors);
                        foreach ($errors as $error => $v) {
                            echo "$v\n";
                        }
                        ?>
                    </pre>
                </div>	
            </div>
            <?php
        }
        ?>

        <div class="box-body" style="padding-top:3%">
            <div class="tab-content">


                <!---------------------   FEE COLLECTION    ----------------------------------------->      

                <div class="tab-pane fade in active" id="fee_collect">

                    <div class="col-sm-12 col-md-12">
                        <div class="panel  panel-default">

                            <div class="panel-heading" style="padding: 5px 15px;">

                                <i class="glyphicon glyphicon-info-sign"></i> <b>Choose Student</b>


                                <ul class="nav nav-tabs" id="menu" style="display: inline-block;list-style-type: none;margin:0px;padding-left: 2%;border-bottom: 0px">

                                    <li class="active"><a data-toggle="tab" href="#admsn_wise" style="font-weight:bold;padding: 1px 10px;" class="btn">Admission No Wise</a></li>   
                                    <li class=""><a data-toggle="tab" href="#class_wise" style="font-weight:bold;padding: 1px 10px;" class="btn">Class Wise</a></li>
                                                                           
                                </ul>
                            </div>
                            <div class="panel-body" style="padding:0px">
                                <div class="tab-content">
                                    <div class="tab-pane fade " id="class_wise">
                                        <div class="table-responsive">
                                            <table class="table" style="border:0px;margin:0px">


                                                <tr>
                                                    <th style="width:30%;border:0px;"> Class Name </th>
                                                    <th style="width:30%;border:0px;"> Section </th>
                                                    <th style="width:30%;border:0px;"> Student</th>
                                                    <th style="width:10%;border:0px;"></th>
                                                </tr>
                                                <tr>
                                                    <td style="width:30%;border:0px;">
                                                        <select class="form-control" id="fee_class" style="width:90%">
                                                            <option value="">Select Class </option>
                                                            <?php
                                                            foreach ($aclass as $rcls) {
                                                                ?>
                                                                <option value="<?php echo $rcls->id; ?>"><?php echo $rcls->class_name; ?></option>
                                                                <?php
                                                            }
                                                            ?>

                                                        </select>
                                                    </td>
                                                    <td style="width:30%;border:0px;">
                                                        <select class="form-control" id="fee_section" style="width:90%">

                                                            <option value="0">Select Section</option>
                                                            <?php
                                                            foreach ($asection as $rsec) {
                                                                ?>
                                                                <option value="<?php echo $rsec->id; ?>"><?php echo $rsec->sec_name; ?></option>
                                                                <?php
                                                            }
                                                            ?>

                                                        </select>
                                                    </td>
                                                    <td style="width:30%;border:0px;" id="admsn_td">
                                                        <select class="form-control" id="fee_addmission_no" style="width:90%">

                                                            <option value="">   </option>

                                                        </select>
                                                    </td>
                                                    <td style="width:10%;border:0px;">
                                                        <button type="button" class="btn btn-success" id="load_submit" data-load="class">Submit</button>
                                                    </td>
                                                </tr>

                                            </table>
                                        </div>
                                    </div> 
                                    <div class="tab-pane fade active in" id="admsn_wise"style="padding-top:2%">

                                        <table class="table" style="border:0px;">
                                            <tr>
                                                <td style="border:0px;width:10%;">

                                                </td>
                                                <th style="width:10%;border:0px;">Admission No </th>    
                                                <td style="border:0px;width:20%;">
                                                    <input type="text" id="fee_admsn" name="fee_admsn" class="form-control" value="<?= set_value('fee_admsn') ?>" style="width:100%">
                                                </td>
                                                <td style="border:0px;width:10%;">
                                                    <button type="button" class="btn btn-success" id="load_submit1" data-load="admsn">Submit</button>
                                                </td>
                                                <td style="border:0px;width:50%;">

                                                </td>
                                            </tr>
                                        </table>

                                    </div>
                                </div>
                            </div>



                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12" id="fee_collect_div">

                        <div class="panel  panel-success">
                            <div class="panel-heading" style="padding: 5px 15px;"><i class="glyphicon glyphicon-th-list"></i><b> <span style="color:black">Student Information</span></b></div>
                            <div class="panel-body" style="padding:0px">
                            </div>
                        </div>
                        <div class="panel  panel-info">
                            <div class="panel-heading" style="padding: 5px 15px;"><i class="glyphicon glyphicon-folder-open">  </i> <b> <span style="color:black"> Fees Collection</span></b></div>
                            <div class="panel-body" style="padding:0px;">

                            </div>
                        </div>
                        <div class="panel  panel-success">
                            <div class="panel-heading" style="padding: 5px 15px;"><i class="glyphicon glyphicon-time">  </i> <b> <span style="color:black"> Transaction History</span></b></div>
                            <div class="panel-body" style="padding:0px;">

                            </div>
                        </div>
                    </div>





                </div>

                <!---------------------    UPLOAD  FEE COLLECTION    ----------------------------------------->  
            </div>
        </div>

    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

<script>

//    function ChangeUrl(page, url) {
//        if (typeof (history.pushState) != "undefined") {
//            var obj = { Page: page, Url: url };
//            history.pushState(obj, obj.Page, obj.Url);
//        } else {
//            alert("Browser does not support HTML5.");
//        }
//    }
//   ChangeUrl('new', base_url('feepayment/collection/Offline_payment'));
    $(document).ready(function ()
    {
//            ChangeUrl('new', base_url('feepayment/collection/Offline_payment'));
        $('#submit').click(function () {
            var r = confirm("Are you sure you want to upload this students?");
            if (r == true)
            {

                $('#submit').val('Uploading');
//                    ChangeUrl('new', base_url('Offline_payment'));
                return true;
            } else {
                return false;
            }
        });

//            $('#fee_class').change(function()
//            {
//                $('#fee_section').val('');
//                $('#fee_addmission_no1').val('');
//            });

        $('#fee_class,' + '#fee_section').change(function ()
        {

//                alert('hi');

            $.ajax({
                type: 'POST',
                url: '<?php echo base_url('feepayment/collection/offline_payment/get_admsn_no'); ?>',
                data: {
                    class: $('#fee_class').val(),
                    section: $('#fee_section').val(),
                },
                success: function (res) {
//                        alert(res);
                    $('#admsn_td').empty();
                    $('#admsn_td').append(res);
                    $('select').select2({width:'100%',theme: "classic"});
                },
                error: function (req, status) {
                    return false;
                }
            });

        });


        $('#load_submit,' + '#load_submit1').click(function ()
        {
            var class_load = $('#fee_class').val();
            var section_load = $('#fee_section').val();
            var admsn_load = $('#fee_admission_no1').val();
            var admsn_load1 = $('#fee_admsn').val();
            var dataload = $(this).attr('data-load');

//                alert(dataload);
            if ((class_load == '' || section_load == '' || admsn_load == '') && dataload == 'class')
            {

                alert(" Please choose Class or Section or Student");

            } else
            {
                $('#fee_collect_div').html('<div class="panel  panel-success">\n\
<div class="panel-heading" style="padding: 5px 15px;">\n\
<i class="glyphicon glyphicon-th-list"></i><b> <span style="color:black">Student Information</span></b>\n\
</div>\n\
<div class="panel-body" style="padding:0px"></div>\n\
</div>\n\
<div class="panel  panel-info">\n\
<div class="panel-heading" style="padding: 5px 15px;">\n\
<i class="glyphicon glyphicon-folder-open">  </i> <b> <span style="color:black"> Fees Collection</span></b>\n\
</div>\n\
<div class="panel-body" style="padding:0px;"></div></div>\n\
<div class="panel  panel-success">\n\
<div class="panel-heading" style="padding: 5px 15px;">\n\
<i class="glyphicon glyphicon-time">  </i> <b> <span style="color:black"> Transaction History</span></b>\n\
</div><div class="panel-body" style="padding:0px;"></div></div>');
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('feepayment/collection/offline_payment_army/load_student_fee_div'); ?>',
                    data:
                            {
                                class: class_load,
                                section: section_load,
                                admsn: admsn_load,
                                admsn_wise: admsn_load1,
                                dataload: dataload
                            },
                    success: function (res)
                    {
//                                           alert(res);
                        $('#fee_collect_div').html(res);
                        $('select').select2({width:'100%',theme: "classic"});

                    },
                    error: function (req, status)
                    {
                        alert('No data Found');
                        return false;
                    }
                });
            }

        });



    });



</script>