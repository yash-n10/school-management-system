<div class="form-group ">
<!--    <div class="box">

        <div class="box-body">-->
            <div class="col-lg-12">
                <div class="panel with-nav-tabs panel-success">
                <div class="panel-heading" style="padding: 0px 8px;border-bottom: 0px;">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#daily" style="font-weight:bold">Date Wise Fee Summary</a></li>
                            <li class=""><a data-toggle="tab" href="#monthly" style="font-weight:bold">Month Wise Fee Summary</a></li>
                            <li class=""><a data-toggle="tab" href="#monthlyfees" style="font-weight:bold">Type 3 Fee Summary</a></li>
                            <li class=""><a data-toggle="tab" href="#print_dcr" style="font-weight:bold">Print DCR</a></li>

                            
                        </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade active in" id="daily">
                            
                            <div class="col-sm-12" style="padding-top:1%;text-align:center">
                            	 <label class="control-label col-sm-1">Session</label>
                            	<div class="col-sm-2">
                                   
                                    <select class="form-control" name="aca_session_daily" id="aca_session_daily">
                                        <?php
                                        foreach ($session as $ses) {
                                            ?>
                                            <option value="<?php echo $ses->id; ?>"><?php echo $ses->session; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <label class="control-label col-sm-2">Collection Center</label>
                                <div class="col-sm-3">
                                    <select class="form-control" name="collection_center" id="collection_center1">
                                        <option value="all">All</option>
                                        <?php
                                        foreach ($collection_center as $cc) {
                                            ?>
                                            <option value="<?php echo $cc->collection_code; ?>"><?php echo $cc->collection_desc; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <label class="control-label col-sm-1">Date</label>
                                <div class="col-sm-3">
                                    <input type='date' class="form-control" id="inputdate1" value="" style="width:100%" min="<?php echo $school_date_created;?>">
                                </div> 
                                
                            </div>

                             <!--  <form method="post" action="<?php echo base_url()?>feepayment/Report/print_dsr">
                                    <div class="col-sm-12" style="padding-top:1%;text-align:center">
                                        <label class="control-label col-sm-2">Collection Center</label>
                                        <div class="col-sm-3">
                                            <select class="form-control" name="col_center" id="col_center">
                                                <option value="all">All</option>
                                                <?php
                                                foreach ($collection_center as $cc) {
                                                    ?>
                                                    <option value="<?php echo $cc->collection_code; ?>"><?php echo $cc->collection_desc; ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <label class="control-label col-sm-1">Date</label>
                                        <div class="col-sm-3">
                                            <input type='date' name="report_date" class="form-control" id="report_date" value="" style="width:100%" min="<?php echo $school_date_created;?>">
                                        </div> 
                                        <input type="submit" name="submit" value="PRINT" class="btn btn-success">
                                    
                                    </div>
                                </form> -->

                            <div class="col-sm-12" id="daily_load" style="padding-top:5%">

                                <form id="frmstudent1" role="form" method="POST">

                                    <table id="studentlist1" class="table table-bordered table-striped">
                                        <thead >
                                            <tr> 

                                                <th rowspan="2" style="border-bottom:1px solid black;"> ADMISSION NO. </th>
                                                <th rowspan="2" style="border-bottom:1px solid black;"> NAME </th>
                                                <th rowspan="2" style="border-bottom:1px solid black;"> CLASS </th>

                                                <th rowspan="2" style="border-bottom:1px solid black;"> CATEGORY </th>
                                                <th colspan="11" style="text-align: center;border-bottom:1px solid black;"> FEE TYPE</th>
                                                <th rowspan="2" style="text-align: center;border-bottom:1px solid black;"> Instant Discount</th>
                                                <th rowspan="2" style="text-align: center;border-bottom:1px solid black;"> Receipt No</th>
                                                <th rowspan="2" style="border-bottom:1px solid black;"> TOTAL FEE </th>
                                            </tr> 
                                            <tr>

                                            </tr>
                                        </thead>
                                        <tbody id="daily_load_td">
                                        <!--                                                                                        <tr>
                                        <th colspan="10" ></th>
                                        </tr>-->
                                        </tbody>
                                    </table>


                                </form>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="monthly">
                            <div class="col-sm-12 col-md-12" style="padding-top:1%">
                            	 <label class="control-label col-sm-1">Session</label>
                            	<div class="col-sm-2">
                                   
                                    <select class="form-control" name="aca_session_mon" id="aca_session_mon">
                                        <!-- <option value="all">All</option> -->
                                        <?php
                                        foreach ($session as $ses) {
                                            ?>
                                            <option value="<?php echo $ses->id; ?>"><?php echo $ses->session; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                 <label class="control-label col-sm-2">Collection Center</label>
                                <div class="col-sm-3">
                                    <select class="form-control" name="collection_center" id="collection_center2">
                                        <option value="all">All</option>
                                        <?php
                                        foreach ($collection_center as $cc) {
                                            ?>
                                            <option value="<?php echo $cc->collection_code; ?>"><?php echo $cc->collection_desc; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <label class="control-label col-md-1 col-sm-1">Month</label>
                                <div class="col-sm-3 col-md-3">

                                    <select name="month" id="lstMonth" class="form-control">
                                        <option value="">Select Month</option>
                                        <option value="1">April</option>
                                        <option value="2">May</option>
                                        <option value="3">June</option>
                                        <option value="4">July</option>
                                        <option value="5">August</option>
                                        <option value="6">September</option>
                                        <option value="7">October</option>
                                        <option value="8">November</option>
                                        <option value="9">December</option>
                                        <option value="10">January</option>
                                        <option value="11">February</option>
                                        <option value="12">March</option>


                                    </select>


                                </div>
                               

                            </div>

                            <div class="col-md-12" id="monthly_load" style="padding-top:5%">

                                <form id="frmstudent2" role="form" method="POST">

                                    <table id="studentlist2" class="table table-bordered table-striped" >
                                        <thead>
                                            <tr> 

                                                <th rowspan="2" style="border-bottom:1px solid black; width:3%"> ADMISSION NO. </th>
                                                <th rowspan="2" style="border-bottom:1px solid black; width:6%"> NAME </th>
                                                <th rowspan="2" style="border-bottom:1px solid black; width:4%"> CLASS </th>

                                                <th rowspan="2" style="border-bottom:1px solid black; width:3%"> CATEGORY </th>
                                                <th colspan="11" style="text-align: center;border-bottom:1px solid black; width:77%"> FEE TYPE</th>
                                                <th rowspan="2" style="border-bottom:1px solid black; width:7%"> TOTAL FEE </th>
                                            </tr>
                                            <tr>

                                            </tr>

                                        </thead>
                                        <tbody id="monthly_load_td">
                                        <!--                                                                                        <tr>
                                        <th colspan="10" ></th>
                                        </tr>-->
                                        </tbody>
                                    </table>


                                </form>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="monthlyfees">
                            
                            <div class="col-sm-12" style="padding-top:1%;text-align:center">
                                <div class="col-sm-3">
                                    <label class="control-label">Session</label>
                                    <select class="form-control" name="aca_session" id="aca_session">
                                        <!-- <option value="all">All</option> -->
                                        <?php
                                        foreach ($session as $ses) {
                                            ?>
                                            <option value="<?php echo $ses->id; ?>"><?php echo $ses->session; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label class="control-label">Collection Center</label>
                                    <select class="form-control" name="collection_center" id="collection_center3">
                                        <option value="all">All</option>
                                        <?php
                                        foreach ($collection_center as $cc) {
                                            ?>
                                            <option value="<?php echo $cc->collection_code; ?>"><?php echo $cc->collection_desc; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="col-sm-3">
                                    <label class="control-label"> From Date</label>
                                    <input type='date' class="form-control" id="inputdatemf" value="" style="width:100%" min="<?php echo $school_date_created;?>">
                                </div> 
                                
                                
                                <div class="col-sm-3">
                                    <label class="control-label"> To Date</label>
                                    <input type='date' class="form-control" id="inputdatemt" value="" style="width:100%" min="<?php echo $school_date_created;?>">
                                </div> 
                            </div>
                            <div class="col-sm-12" style="padding-top:1%;">
                                <label class="control-label col-sm-3"> Columns to remove from report</label>
                                <div class="col-sm-9">
                                    
                                </div>
                                <div class="col-sm-9">
                                    <!--<div class="form-check-inline">-->
                                    <!--<label class="form-check-label">-->
                                        <input type="checkbox" class="form-check-input" value="fee_cat" name="rmvcol[]">&nbsp; Fee Category &nbsp;&nbsp;
                                        <input type="checkbox" class="form-check-input" value="status"  name="rmvcol[]">&nbsp; Status &nbsp;&nbsp;
                                        <?php foreach($fee_ty as $d=>$v) { ?>
                                            <input type="checkbox" class="form-check-input" id="<?php echo 'f_'.$d;?>" value="<?php echo $d;?>"  name="rmvcol1[]">&nbsp; <?php echo $v;?> &nbsp;&nbsp;
                                        <?php } ?>
                                        <input type="checkbox" class="form-check-input" id="none" value="none"  name="rmvcol[]">&nbsp;None &nbsp;&nbsp;    
                                    <!--</label>-->
                                    <!--</div>-->
                                   
                                  
                                </div>
                                <div class="col-sm-12" style="text-align: center;padding-top:2%">
                                     <button id="rmv" type="button" class="btn btn-danger">Remove</button>
                                </div>
                            </div>

                            <div class="col-sm-12 table-responsive" id="monthlyfees_load" style="padding-top:5%">

                                <form id="frmstudent3" role="form" method="POST">

                                    <table id="studentlist3" class="table table-bordered table-striped">
                                        <thead id="monthlyfees_load_th">
                                            <tr> 

                                                <th rowspan="2" style="border-bottom:1px solid black;"> FEE CATEGORY</th>
                                                <th rowspan="2" style="border-bottom:1px solid black;"> PAYMENT MODE </th>
                                                <th rowspan="2" style="border-bottom:1px solid black;"> TRANSACTION ID. </th>
                                                <th rowspan="2" style="border-bottom:1px solid black;"> TRANSACTION DATE. </th>
                                                <th rowspan="2" style="border-bottom:1px solid black;"> TOTAL AMOUNT </th>
                                                <th rowspan="2" style="border-bottom:1px solid black;"> STATUS </th>
                                                <th rowspan="2" style="border-bottom:1px solid black;"> ADMISSION NO. </th>
                                                <th rowspan="2" style="border-bottom:1px solid black;"> STUDENT NAME </th>
                                                <th rowspan="2" style="border-bottom:1px solid black;"> CLASS-SEC </th>
                                                <th rowspan="2" style="border-bottom:1px solid black;"> ROLL NO </th>
                                                <th rowspan="2" style="border-bottom:1px solid black;"> MONTH DETAILS </th>
                                                <th colspan="11" style="text-align: center;border-bottom:1px solid black;"> FEE TYPE</th>
                                            </tr> 
                                            <tr>

                                            </tr>
                                        </thead>
                                        <tbody id="monthlyfees_load_td">
                                        <!--                                                                                        <tr>
                                        <th colspan="10" ></th>
                                        </tr>-->
                                        </tbody>
                                    </table>


                                </form>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="print_dcr">
                            
                <form method="post" action="<?php echo base_url()?>feepayment/Report/print_dsr_new">
                <div class="col-sm-12" style="padding-top:1%;text-align:center">
                    <label class="control-label col-md-2 col-sm-2">Session</label>
                    <div class="col-sm-2 col-md-2">
                        <select name="aca_session_dcr" id="aca_session_dcr" class="form-control">
                            <?php foreach ($session as $ses) {?>
                                <option value="<?php echo $ses->id; ?>"><?php echo $ses->session; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <label class="control-label col-sm-2">Collection Center</label>
                    <div class="col-sm-2">
                        <select class="form-control" name="col_center" id="col_center">
                            <option value="all">All</option>
                            <?php
                            foreach ($collection_center as $cc) {
                                ?>
                                <option value="<?php echo $cc->collection_code; ?>"><?php echo $cc->collection_desc; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <label class="control-label col-sm-1">Date</label>
                    <div class="col-sm-2">
                        <input type='date' name="report_date" class="form-control" id="report_date" value="" style="width:100%" min="<?php echo $school_date_created;?>">
                    </div> 
                    <input type="submit" name="submit" value="PRINT" class="btn btn-success">

                </div>
            </form>
                            
                        </div>
                    </div>
                </div>
            </div>

            </div>

<!--        </div>

    </div>-->
</div>



<script type="text/javascript">

    $(document).ready(function ()
    {


//        $('#datetimepicker1').datetimepicker({
//            todayBtn: true,
//            autoclose: true,
//            pickerPosition: "bottom-left",
////                  pickTime: false,
//            format: 'yyyy-mm-dd 00:00:00',
//            minView: 2,
//
////                 defaultViewDate: {year:2017, month:4, day:12},
//        });
//            $('#datetimepicker2').datetimepicker({
//               todayBtn: true,
//               autoclose: true,
//                 pickerPosition: "bottom-left",
//                 format:'yyyy-mm-dd 00:00:00',
//                  minView: 2,
////                 defaultViewDate: {year:2017, month:4, day:12},
//            });
//            $('#datetimepicker3').datetimepicker({
//               todayBtn: true,
//               autoclose: true,
//                 pickerPosition: "bottom-left",
//                 format:'yyyy-mm-dd 00:00:00',
//                  minView: 2,
////                 defaultViewDate: {year:2017, month:4, day:12},
//            });
//            $('#datetimepicker4').datetimepicker({
//               todayBtn: true,
//               autoclose: true,
//                 pickerPosition: "bottom-left",
//                 format:'yyyy-mm-dd 00:00:00',
//                  minView: 2,
////                 defaultViewDate: {year:2017, month:4, day:12},
//            });

//            $('#inputdate').val($('#datetimepicker1').val());

        $('#aca_session_daily' + ',#inputdate1,'+'#collection_center1').change(function ()
        {


            var aca_session_daily = $('#aca_session_daily').val();
            var date = $('#inputdate1').val();
            var colcenter = $('#collection_center1').val();


            $('#daily_load_td').html("<tr><td colspan='17'><h3 style='text-align:center'> Loading....... </h3></td></tr>");
//         alert(from_date);
            $.ajax({

                url: '<?php echo base_url(); ?>feepayment/report/daily_wise_fee_summary',
                dataType: "text",
                method: 'post',
                data: {

                    aca_session_daily: aca_session_daily,
                    date: date,
                    colcenter: colcenter
                },
                success: function (data) {
//                      alert(data);
                    $('#daily_load').html(data);
                },
                error: function () {
                    alert('Error while Loading!');

                }

            });



        });


        $('#aca_session_mon'+',#lstMonth,'+'#collection_center2').change(function ()
        {

            var aca_session_mon = $('#aca_session_mon').val();
            var month = this.value;
            var colcenter = $('#collection_center2').val();
//            alert(month);
            $('#monthly_load_td').html("<tr><td colspan='17'><h3 style='text-align:center'> Loading....... </h3></td></tr>");
            $.ajax({

                url: '<?php echo base_url(); ?>feepayment/report/monthly_wise_fee_summary',
                dataType: "text",
                method: 'post',
                data: {

                    aca_session_mon: aca_session_mon,
                    month: month,
                    colcenter: colcenter
                },
                success: function (data) {
//                    alert(data);
                    $('#monthly_load').html(data);
                },
                error: function (data) {
                    alert('Error occured!' + data);

                }

            });


        });
        
        
        
        $('#aca_session' +',#inputdatemf,'+'#inputdatemt,'+'#collection_center3,'+'#rmv').on('change click',function ()
        {


            var aca_session = $('#aca_session').val();
            var frmdate = $('#inputdatemf').val();
            var todate = $('#inputdatemt').val();
            var colcenter = $('#collection_center3').val();
            var rmvcol=[];
            var rmvcol1=[];
            var ind=0;
            var ind1=0;
            $("input[name='rmvcol[]']:checked").each(function() 
            {
                
                  rmvcol[ind]  = this.value;           
                ind++;
            });
             $("input[name='rmvcol1[]']:checked").each(function() 
            {
                
                  rmvcol1[ind1]  = this.value;           
                ind1++;
            });
            if(frmdate!='' && todate!='' && colcenter!='') {
            $('#monthlyfees_load_td').html("<tr><td colspan='17'><h3 style='text-align:center'> Loading....... </h3></td></tr>");
//         alert(from_date);
            $.ajax({

                url: '<?php echo base_url(); ?>feepayment/report/monthlyfees_wise_fee_summary',
                dataType: "text",
                method: 'post',
                data: {

                    aca_session: aca_session,
                    frmdate: frmdate,
                    todate: todate,
                    colcenter: colcenter,
                    rmvcol: rmvcol,
                    rmvcol1: rmvcol1
                },
                success: function (data) {
//                      alert(data);
                    $('#monthlyfees_load').html(data);
//                    $('#monthlyfees_load_th').html(data.thead);
//                    $('#monthlyfees_load_td').html(data.tbody);
                },
                error: function () {
                    alert('Error while Loading!');

                }

            });
            }
                

        });


        $('#none').click(function(){
                    $('input[name="rmvcol[]"]').not(this).prop('checked',false);
                    $('input[name="rmvcol[]"]').not(this).attr('disabled',this.checked);
                    $('input[name="rmvcol1[]"]').not(this).prop('checked',false);
                    $('input[name="rmvcol1[]"]').not(this).attr('disabled',this.checked);
                    
        });

    });



</script>