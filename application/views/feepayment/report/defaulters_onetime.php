<div class="form-group">
    <div class='box box-primary panel'>
        <div class="panel-heading" style="padding: 0px 8px;border-bottom: 0px;background-color: #dff0d8;">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tillnow" style="font-weight:bold;" onclick="showhide('tillnow','monthwise');">Till Now Defaulters</a></li>
                <li class=""><a data-toggle="tab" href="#monthwise" style="font-weight:bold" onclick="showhide('monthwise','tillnow');">Month Wise Defaulters</a></li>

            </ul>
        </div>
        <div class='box-body'>

            <div class="tab-content">
                <div class="tab-pane fade active in" id="tillnow"> 
                    <div class="col-sm-12 col-md-12">
                        <label class="control-label col-md-2">Class Name</label>
                        <div class="col-sm-2 col-md-2">
                            <select name="annuallstClass" id="annuallstClass" class="form-control">
                                <!--<option value="">Select Class</option>-->
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
                        <label class="control-label col-md-2">Section Name</label>
                        <div class="col-sm-2 col-md-2">
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
						<?php if($schoolgrp!='ARMY'){ ?>
							<div class="" style="float:right;" id="div_change">
                            <?php $date = date('m');?>
                            <a class="btn btn-success" id="defaulter_export" href="<?php echo base_url("feepayment/Report/exportdefaulters/all/all/all/$date/tillmonth"); ?>" download>
                                <i class="fa fa-cloud-download fa-lg"></i>&nbsp; Export 
                            </a>

                        </div>
						<?php } ?>
                        
                    </div>
                    <div class="col-sm-12 col-md-12">
                        <label class="control-label col-md-2">Choose Term:</label>
                        <div class="col-sm-2 col-md-2">
                            <select name="term" id="term" class="form-control">
                                <option value="all">All</option>

                                <option value="1">Annual</option>
                                <option value="2">Monthly</option>
                                <option value="3">Onetime</option>

                            </select>
                            <span class="help-block"></span>
                        </div>
                        <label class="control-label col-md-2">Choose Till Month:</label>
                       
						<?php if($schoolgrp=='ARMY'){ ?>
							<div class="col-sm-2 col-md-2">
                            <?php $m=date('m');?>
                            <select name="choosetillmonth" id="choosetillmonth" class="form-control">
                                <option value="0">Select</option>
                                <option value="06" <?php if($m==4) echo 'selected=selected';?>>April</option>
                                <option value="06" <?php if($m==5) echo 'selected=selected';?>>May</option>
                                <option value="06" <?php if($m==6) echo 'selected=selected';?>>June</option>
                                <option value="09" <?php if($m==7) echo 'selected=selected';?>>July</option>
                                <option value="09" <?php if($m==8) echo 'selected=selected';?>>August</option>
                                <option value="09" <?php if($m==9) echo 'selected=selected';?>>September</option>
                                <option value="12" <?php if($m==10) echo 'selected=selected';?>>October</option>
                                <option value="12" <?php if($m==11) echo 'selected=selected';?>>November</option>
                                <option value="12" <?php if($m==12) echo 'selected=selected';?>>December</option>
                                <option value="03" <?php if($m==1) echo 'selected=selected';?>>January</option>
                                <option value="03" <?php if($m==2) echo 'selected=selected';?>>February</option>
                                <option value="03" <?php if($m==3) echo 'selected=selected';?>>March</option>

                            </select>
                            <span class="help-block"></span>
                        </div>
						<?php } else{ ?>
							 <div class="col-sm-2 col-md-2">
                            <?php $m=date('m');?>
                            <select name="choosetillmonth" id="choosetillmonth" class="form-control">
                                <option value="0">Select</option>
                                <option value="04" <?php if($m==4) echo 'selected=selected';?>>April</option>
                                <option value="05" <?php if($m==5) echo 'selected=selected';?>>May</option>
                                <option value="06" <?php if($m==6) echo 'selected=selected';?>>June</option>
                                <option value="07" <?php if($m==7) echo 'selected=selected';?>>July</option>
                                <option value="08" <?php if($m==8) echo 'selected=selected';?>>August</option>
                                <option value="09" <?php if($m==9) echo 'selected=selected';?>>September</option>
                                <option value="10" <?php if($m==10) echo 'selected=selected';?>>October</option>
                                <option value="11" <?php if($m==11) echo 'selected=selected';?>>November</option>
                                <option value="12" <?php if($m==12) echo 'selected=selected';?>>December</option>
                                <option value="01" <?php if($m==1) echo 'selected=selected';?>>January</option>
                                <option value="02" <?php if($m==2) echo 'selected=selected';?>>February</option>
                                <option value="03" <?php if($m==3) echo 'selected=selected';?>>March</option>

                            </select>
                            <span class="help-block"></span>
                        </div>
					<?php } ?>
						 
						
                    </div>
                </div>

                <div class="tab-pane fade in" id="monthwise"> 
                    <div class="col-sm-12 col-md-12">
                        <label class="control-label col-md-2">Class Name</label>
                        <div class="col-sm-2 col-md-2">
                            <select name="lstClass" id="lstClass" class="form-control">
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
                        <label class="control-label col-md-2">Section Name</label>
                        <div class="col-sm-2 col-md-2">
                            <select name="section" id="lstSection" class="form-control">
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
                        <div class="" style="float:right;" id="div_change1">
                            <?php // $date1 = date('m'); ?>
                            <a class="btn btn-success" id="defaulter_export1" href="<?php echo base_url("feepayment/Report/exportdefaulters/all/all/all/$date/monthwise"); ?>" download>
                                <i class="fa fa-cloud-download fa-lg"></i>&nbsp; Export 
                            </a>
                        </div>
                    </div>
                  
                    <div class="col-sm-12 col-md-12">
                        
                        <label class="control-label col-md-2">Choose Term:</label>
                        <div class="col-sm-2 col-md-2">
                            <select name="term1" id="term1" class="form-control">
                                <option value="all">All</option>

                                <option value="1">Annual</option>
                                <option value="2">Monthly</option>
                                <option value="3">Onetime</option>

                            </select>
                            <span class="help-block"></span>
                        </div>
                        
                        <label class="control-label col-md-2">For Month (only):</label>
                        <div class="col-sm-2 col-md-2">
                            <select name="month" id="month" class="form-control">
                                <option value="0">Select</option>
                                <option value="04" <?php if($m==4) echo 'selected=selected';?>>April</option>
                                <option value="05" <?php if($m==5) echo 'selected=selected';?>>May</option>
                                <option value="06" <?php if($m==6) echo 'selected=selected';?>>June</option>
                                <option value="07" <?php if($m==7) echo 'selected=selected';?>>July</option>
                                <option value="08" <?php if($m==8) echo 'selected=selected';?>>August</option>
                                <option value="09" <?php if($m==9) echo 'selected=selected';?>>September</option>
                                <option value="10" <?php if($m==10) echo 'selected=selected';?>>October</option>
                                <option value="11" <?php if($m==11) echo 'selected=selected';?>>November</option>
                                <option value="12" <?php if($m==12) echo 'selected=selected';?>>December</option>
                                <option value="01" <?php if($m==1) echo 'selected=selected';?>>January</option>
                                <option value="02" <?php if($m==2) echo 'selected=selected';?>>February</option>
                                <option value="03" <?php if($m==3) echo 'selected=selected';?>>March</option>

                            </select>
                            <span class="help-block"></span>
                        </div>
                        
                    </div>
                </div>

            </div>


        </div>
    </div>
</div>
<div class="box" id="box_tillnow">
    <div class="box-body">
        <div class="col-sm-12 col-md-12" id="annual_load">
            <form id='frmtemplate' role="form" method="POST">
                <table id="studentlist" class="table table-bordered table-striped"  style="margin-top: 25px;">
                    <thead>
                        <tr>
                            <th> Admission No </th>
                            <th> Student Name </th>
                            <th> Class </th>
                            <th> Section </th>
                            <th> Fees Category </th>
                            <!--<th> Father's Name </th>-->
                            <th> Mobile No. </th>
                            <th> Annual</th>
                            <th> Onetime</th>
                            <th> Student Type</th>
                            <th> Start Fee Month</th>
                            <th> Monthly ( <?php
                                if (date('Y-m-d') > $session_end_date) {
                                    echo 'Till March';
                                } else {
                                    echo 'Including Current Month-' . date('M');
                                }
                                ?>) </th>
                            <th> Total Unpaid Amount</th>
                        </tr>
                    </thead>
                    <thead style="background: #cce6ff">
                            <tr id="searchhead">
                                    <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                        <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="0"/>
                                    </th>
                                    <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                        <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="1"/>
                                    </th>
                                    <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                        <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="2"/>
                                    </th>
                                    <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                        <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="3"/>
                                    </th>
                                    <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                        <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="4"/>
                                    </th>
                                    <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                        <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="5"/>
                                    </th>
                                    <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                        <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="6"/>
                                    </th>
                                    <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                        <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="7"/>
                                    </th>
                                    <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                        <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="8"/>
                                    </th>
                                    <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                        <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="9"/>
                                    </th>
                                    <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                        <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="10"/>
                                    </th>
                                    <th style="border-bottom:2px solid darkcyan;border-top:0px">
                                        <i class="fa fa-search" style='position: absolute;margin: 7px 5px 6px 3px;'></i><input type="text" class="form-control search" style="width:100%;border-radius: 5px;padding-right: 10px; padding-left:19px;   height: 27px;" placeholder="" data-column="11"/>
                                    </th>
                                <!--<th style="border-bottom:2px solid darkcyan;border-top:0px"></th>-->
                            </tr>
                    </thead>
                    <tbody id="annual_load_td">
                        <?php
                        if (isset($data) && count($data) > 0) {
                            // print_r($data);
                            foreach ($data as $student) {
                                
                                // die();
                                ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td ></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

<div class="box" id="box_monthwise">
    <div class="box-body">
        <div class="col-sm-12 col-md-12" id="monthly_load">
            <form id='frmtemplate' role="form" method="POST">
                <table id="studentlist1" class="table table-bordered table-striped"  style="margin-top: 25px;">
                    <thead>
                        <tr>
                            <th> Admission No </th>
                            <th> Student Name </th>
                            <th> Class </th>
                            <th> Section </th>
                            <th> Fees Category </th>
                            <!--<th> Father's Name </th>-->
                            <th> Mobile No. </th>
                            <th> Annual</th>
                            <th> Onetime</th>
                            <th> Unpaid Month </th>
                            <th> Total Unpaid Amount</th>
                        </tr>
                    </thead>
                    <tbody id="annual_load_td">
                        <?php
                        if (isset($data) && count($data) > 0) {
                            foreach ($data as $student) {
                                ?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td ></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>
<!-- /.box-body -->
</div>
<!-- /.box -->

<script>

    $(document).ready(function ()
    {
        datatable();

        $('#annuallstClass' + ',#annuallstSection' + ',#term' +',#choosetillmonth').change(function ()
        {


            datatable();
            var class_id = $('#annuallstClass').val();
            var section_id = $('#annuallstSection').val();
            var term = $('#term').val();
            var choosetillmonth = $('#choosetillmonth').val();

            $('#defaulter_export').attr('href', '<?php echo base_url('feepayment/report/exportdefaulters_test'); ?>' + '/' + class_id + '/' + section_id + '/' + term + '/' + choosetillmonth+'/'+'tillmonth');
////         alert(class_id);
//
//
//        $('#annual_load_td').html("<tr><td colspan='7'><h3 style='text-align:center'> Loading....... </h3></td></tr>");
//        $.ajax({
//            
//                    url: '<?php // echo base_url();     ?>report/defaulter_report',
//                    dataType: "text",
//                    method: 'post',  
//                    data: {
//                                class_id:class_id,                                             
//                                section_id:section_id,                                             
//                    },
//                    success: function(data) {
////                      alert(data);
//                        $('#annual_load').html(data);
//                    },
//                    error: function() {
//                    alert('Error occured!');
//
//                    }
//            
//        });
//        


        });

        function datatable()
        {
            var class_id = $('#annuallstClass').val();
            var section_id = $('#annuallstSection').val();
            var term = $('#term').val();
            var choosetillmonth = $('#choosetillmonth').val();
//alert (term);
           table =  $('#studentlist').DataTable({
                 "destroy": true,
                "paging": true,

				"lengthMenu": [[10, 50, 100,1000, -1], [10, 50, 100,1000, "All"]],
                serverSide: true,
                dom: 'lfBrtip',
			
                 buttons: [
//                           'excel', 'pdf', 'csv' 
                                {
                                    extend: 'collection',
                                    text: 'Export',
                                    className: 'red',
                                    buttons: [
                              
//                                      '<i class="fa fa-file-excel-o"></i>copy',
                                        'excel',
                                        'csv',
                                        {
                                            extend: 'pdf',
                                            orientation: 'portrait',
                                            pageSize: 'A4'
                                        },
                                        {
                                            extend: 'print',
                                            orientation: 'portrait',
                                            pageSize: 'A4'
                                        },
                                    ]
                                }
                            ],
							
                            
                ajax: {
                    url: '<?php echo base_url('feepayment/report/defaulter_report_test'); ?>',
                    type: 'POST',
                    data: {class_id: class_id,
                        section_id: section_id,
                        term: term,
                        choosetillmonth: choosetillmonth,
                        indication:'tillmonth'
                    }
                }
               
            });
            }
           
            
//        }

        
        $('#lstClass' + ',#lstSection' + ',#term1' +',#month').change(function ()
        { 
            var class_id = $('#lstClass').val();
            var section_id = $('#lstSection').val();
            var term = $('#term1').val();
            var month = $('#month').val();   

            datatable1();
            $('#defaulter_export1').attr('href', '<?php echo base_url('feepayment/report/exportdefaulters_test'); ?>' + '/' + class_id + '/' + section_id + '/'+term+'/' + month+'/'+'monthwise');

            
        });
        
        
        
        function datatable1()
        {
            var class_id = $('#lstClass').val();
            var section_id = $('#lstSection').val();
            var choosetillmonth = $('#month').val();
            var term = $('#term1').val();
            $('#studentlist1').DataTable({
                "destroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "processing": true,
                serverSide: true,
                ajax: {
                    url: '<?php echo base_url('feepayment/report/defaulter_report_test'); ?>',
                    type: 'POST',
                    data: {class_id: class_id,
                        section_id: section_id,
                        choosetillmonth: choosetillmonth,
                        term:term,
                        indication:'monthwise'
                    }
                }

            });
        }
        
        
        $('#box_monthwise').hide();
    });
    
     $('#searchhead th input').on('keyup change', function () {
    //            if ( this.search() !== this.value ) {
    //                this
    //                    .search( this.value )
    //                    .draw();
    //            }
                var i = $(this).attr('data-column');
                var v = $(this).val();
                table.columns(i).search(v).draw();
            }); 
    
    function showhide(m,n){
    
        $('#box_'+m).show();
        $('#box_'+n).hide();
    }
    function printPageArea(areaID){
    var printContent = document.getElementById(areaID);
    var WinPrint = window.open('', '', 'width=900,height=650');
    WinPrint.document.write(printContent.innerHTML);
    WinPrint.document.close();
    WinPrint.focus();
    WinPrint.print();
    WinPrint.close();
}
</script>