<div class="form-group has-feedback">
    <div class="box box-primary panel">

        <div class="panel-heading" style="padding: 0px 8px;border-bottom: 0px;background-color: #dff0d8;">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tillnow" style="font-weight:bold;" >Student Fee Status</a></li>
                <li class=""><a data-toggle="tab" href="#monthwise" style="font-weight:bold">Student Fee Ledger</a></li>

            </ul>
        </div>
        <div class="box-body">

            <div class="tab-content">
                <div class="tab-pane fade active in" id="tillnow"> 
                    
                    <div class="col-sm-12 col-md-12">
                        <label class="control-label col-md-2">Class Name</label>
                        <div class="col-sm-3 col-md-3">
                            <select name="annuallstClass" id="annuallstClass" class="form-control">
                                <option value="">Select Class</option>
                                <option value="all">All Class</option>
                                <?php
                                foreach ($aclass as $class) {
                                    ?>
                                    <option value="<?php echo $class->id; ?>"><?php echo $class->class_name; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="help-block"></span>
                        </div>
                        <div class="" style="float:right;" id="div_change">
                                   <!--  <a class="btn btn-success" id="paylog_export" href="<?php // echo base_url("Report/exportpaymentlog/all/all/all/all"); ?>">
                                        <i class="fa fa-cloud-download fa-lg"></i>&nbsp; Export 
                                    </a> -->
                                      <a class="btn btn-success" id="paylog_export" href="<?php  //echo base_url("Report/exportpaymentlog/all/all/all/all"); ?>" download>
                                        <i class="fa fa-cloud-download fa-lg"></i>&nbsp; Export 
                                    </a>
                                </div> 
                    </div>

                    <div class="col-sm-12 col-md-12">
                        <label class="control-label col-md-2">Section Name</label>
                        <div class="col-sm-3 col-md-3">
                            <select name="annualsection" id="annuallstSection" class="form-control">
                                <option value="all">All Section</option>
                                <?php
                                foreach ($asection as $sec) {
                                    ?>
                                    <option value="<?php echo $sec->id; ?>"><?php echo $sec->sec_name; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>

                     <div class="col-sm-12 col-md-12">
                        <label class="control-label col-md-2">Session</label>
                        <div class="col-sm-3 col-md-3">
                            <select name="aca_session" id="aca_session" class="form-control">
                                <?php
                                foreach ($asession as $ses) {
                                    ?>
                                    <option value="<?php echo $ses->id; ?>"><?php echo $ses->session; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12" id="annual_load"  style="padding-top: 3%;">

                        <form id='frmtemplate' role="form" method="POST">
                            <table id="studentlist" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th> Admission No </th>
                                        <th> Student Name </th>
                                        <th> Class </th>
                                        <th> Section </th>
                                        <th> Fees Category </th>
                                        <th> Annual Fees Status </th>
                                        <th> No. Of Paid Month</th>
                                    </tr>
                                </thead>
                                <tbody id="annual_load_td">
                                    <tr>
                                        <td>  </td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td>  </td>
                                        <td> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>


                    </div>
                </div>
                <div class="tab-pane fade in" id="monthwise"> 
                     <div class="col-sm-12 col-md-12">
                        <label class="control-label col-md-2">Session</label>
                        <div class="col-sm-3 col-md-3">
                            <select name="aca_session_led" id="aca_session_led" class="form-control">
                                <?php
                                foreach ($asession as $ses) {
                                    ?>
                                    <option value="<?php echo $ses->id; ?>"><?php echo $ses->session; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <label class="control-label col-md-2">Class Name</label>
                        <div class="col-sm-3 col-md-3">
                            <select name="annuallstClass1" id="annuallstClass1" class="form-control">
                                <!-- <option value="">Select Class</option> -->
                                <option value="all">All Class</option>
                                <?php
                                foreach ($aclass as $class) {
                                    ?>
                                    <option value="<?php echo $class->id; ?>"><?php echo $class->class_name; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="help-block"></span>
                        </div>
                        <div class="" style="float:right;" id="div_change">
                                    <a class="btn btn-success" id="paylog_export1" href="<?php // echo base_url("Report/exportpaymentlog/all/all/all/all"); ?>">
                                        <i class="fa fa-cloud-download fa-lg"></i>&nbsp; Export 
                                    </a>
                                   <!--  <a class="btn btn-success" id="paylog_export1" href="<?php // echo base_url("Report/exportpaymentlog/all/all/all/all"); ?>" download>
                                        <i class="fa fa-cloud-download fa-lg"></i>&nbsp; Export 
                                    </a> -->
                                </div>
                    </div>

                    <div class="col-sm-12 col-md-12">
                        <label class="control-label col-md-2">Section Name</label>
                        <div class="col-sm-3 col-md-3">
                            <select name="annualsection1" id="annuallstSection1" class="form-control">
                                <option value="all">All Section</option>
                                <?php
                                foreach ($asection as $sec) {
                                    ?>
                                    <option value="<?php echo $sec->id; ?>"><?php echo $sec->sec_name; ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                            <span class="help-block"></span>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12" id="annual_load1"  style="padding-top: 3%;">

                        <form id='frmtemplate' role="form" method="POST">
                            <table id="studentlist1" class="table table-bordered table-striped">
                                <thead>
                                    <tr><?php $y=date('y');?>
                                        <th> Admission No </th>
                                        <th> Student Name </th>
                                        <th> Class </th>
                                        <th> Apr'<?=$y;?> </th>
                                        <th> May'<?=$y;?> </th>
                                        <th> Jun'<?=$y;?> </th>
                                        <th> Jul'<?=$y;?> </th>
                                        <th> Aug'<?=$y;?> </th>
                                        <th> Sep'<?=$y;?></th>
                                        <th> Oct'<?=$y;?></th>
                                        <th> Nov'<?=$y;?></th>
                                        <th> Dec'<?=$y;?></th>
                                        <th> Jan'<?=$y+1;?></th>
                                        <th> Feb'<?=$y+1;?></th>
                                        <th> Mar'<?=$y+1;?></th>
                                    </tr>
                                </thead>
                                <tbody id="annual_load_td1">
                                    <tr>
                                        <td>  </td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td>  </td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                        <td> </td>
                                    </tr>
                                </tbody>
                            </table>
                        </form>


                    </div>
                </div>
            </div>    
        </div>


    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->

<script>
    $(document).ready(function ()
    {

        $('#aca_session' + ',#annuallstClass' + ',#annuallstSection').change(function ()
        {
            var a_ses_id = $('#aca_session').val();
            var class_id = $('#annuallstClass').val();
            var section_id = $('#annuallstSection').val();


            $('#annual_load_td').html("<tr><td colspan='10'><h3 style='text-align:center'> Loading....... </h3></td></tr>");
            $.ajax({

                url: '<?php echo base_url(); ?>feepayment/report/load_fees_status',
                dataType: "text",
                method: 'post',
                data: {
                    a_ses_id: a_ses_id,
                    class_id: class_id,
                    section_id: section_id,
                },
                success: function (data) {
                    $('#annual_load').html(data);
                           
                },
                error: function () {
                    alert('Error occured!');

                }

            });

        });
        
        
        $('#aca_session_led' +',#annuallstClass1' + ',#annuallstSection1').change(function ()
        {

            var aca_session_led = $('#aca_session_led').val();
            var class_id = $('#annuallstClass1').val();
            var section_id = $('#annuallstSection1').val();
            $('#annual_load_td1').html("<tr><td colspan='10'><h3 style='text-align:center'> Loading....... </h3></td></tr>");
            $.ajax({

                url: '<?php echo base_url(); ?>feepayment/report/student_ledger',
                dataType: "text",
                method: 'post',
                data: {
                    aca_session_led: aca_session_led,
                    class_id: class_id,
                    section_id: section_id,
                },
                success: function (data) {
//                      alert(data);
//                    $('#annual_load').empty();
                    $('#annual_load1').html(data);
                           
                },
                error: function () {
                    alert('Error occured!');

                }

            });



        });
        
        
 // Export code inactive


 
       $('#paylog_export').click(function(e){
            e.preventDefault();
            var csv = [];
              var table = document.querySelector('#studentlist');
                var rows = table.querySelectorAll("tr");
            for (var i = 0; i < rows.length; i++) {
                var row = [], cols = rows[i].querySelectorAll("td, th");

                for (var j = 0; j < cols.length; j++) 
                    row.push(cols[j].innerText);

                csv.push(row.join(","));        
            }
            downloadCSV(csv.join("\n"), 'FeesStatus.csv');
        });
        
        $('#paylog_export1').click(function(e){
            e.preventDefault();
            var csv = [];
             var table = document.querySelector('#studentlist1');
                var rows = table.querySelectorAll("tr");
            for (var i = 0; i < rows.length; i++) {
                var row = [], cols = rows[i].querySelectorAll("td, th");

                for (var j = 0; j < cols.length; j++) 
                    row.push(cols[j].innerText);

                csv.push(row.join(","));        
            }
            downloadCSV(csv.join("\n"), 'FeesStatus.csv');
        });
        

         // Export code inactive
        
        function downloadCSV(csv, filename) {
            var csvFile;
            var downloadLink;

            // CSV file
            csvFile = new Blob([csv], {type: "text/csv"});

            // Download link
            downloadLink = document.createElement("a");

            // File name
            downloadLink.download = filename;

            // Create a link to the file
            downloadLink.href = window.URL.createObjectURL(csvFile);

            // Hide download link
            downloadLink.style.display = "none";

            // Add the link to DOM
            document.body.appendChild(downloadLink);

            // Click download link
            downloadLink.click();
        }

    });
</script>