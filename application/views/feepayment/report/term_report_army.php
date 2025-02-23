<div class="form-group has-feedback">
<!--    <div class="box">

        <div class="box-body">-->
            <div class="col-lg-12">
                <div class="panel with-nav-tabs panel-success">
                    <div class="panel-heading" style="padding: 0px 8px;border-bottom: 0px;">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#date" style="font-weight:bold">Date Wise Term Report</a></li>
                            <li class=""><a data-toggle="tab" href="#category" style="font-weight:bold">Category Wise Term Report</a></li>
                            <li class=""><a data-toggle="tab" href="#classsect" style="font-weight:bold">Class & Section Wise Term Report</a></li>
                            <li class=""><a data-toggle="tab" href="#feehead" style="font-weight:bold">Fee Head Wise Term Report</a></li>

                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="date">

                                <div class="col-sm-12 col-md-12" style="padding-top:1%">
                                    <label class="control-label col-md-2 col-sm-2">Start Date</label>
                                    <div class="col-sm-3 col-md-3">
                                        <input type="date" id="inputdate1" class="form-control" style="padding: 6px 4px;" min="<?php echo $school_date_created;?>">
                                    </div>  


                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <label class="control-label col-md-2 col-sm-2">End Date</label>
                                    <div class="col-sm-3 col-md-3">
                                        <input type="date" id="inputdate2" class="form-control" style="padding: 6px 4px;" min="<?php echo $school_date_created;?>">

                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <label class="control-label col-md-2 col-sm-2">Collection Center</label>
                                    <div class="col-sm-3 col-md-3">
                                        <select class="form-control" name="collection_center" id="collection_center">
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
                                </div>
                                <div class="col-sm-12 col-md-12" id="date_load" style="padding-top:2%">

                                    <form id="frmstudent1" role="form" method="POST">

                                        <table id="studentlist1" class="table table-bordered table-striped">
                                            <caption id="tabletitle" style="text-align:center">DATE WISE TERM REPORT</caption>
                                            <thead>

                                                <tr> 

                                                    <th rowspan="3" style="border-bottom:1px solid black;"> Transaction Date </th>
                                                    <th rowspan="3" style="border-bottom:1px solid black;"> Transaction Count </th>
                                                    <th colspan="3" style="text-align: center;border-bottom:1px solid black"> Term</th>
                                                    
                                                    <th rowspan="3" style="border-bottom:1px solid black;"> Grand Total </th>
                                                    <th colspan="3" style="text-align: center;border-bottom:1px solid black"> Mode</th>

                                                </tr> 
                                                <tr>
                                                    <th style="border-bottom:1px solid black;"> Onetime </th>
                                                    <th style="border-bottom:1px solid black;"> Annual </th>
                                                    <th style="border-bottom:1px solid black;"> Quarterly </th>
                                                    <th style="border-bottom:1px solid black;">  </th>
                                                    <th style="border-bottom:1px solid black;">  </th>
                                                </tr>
                                            </thead>
                                            <tbody id="date_load_td">

                                            </tbody>
                                        </table>


                                    </form>

                                </div>
                            </div>
                            <div class="tab-pane fade" id="category">
                                <div class="col-sm-12 col-md-12" style="padding-top:1%">
                                    <label class="control-label col-md-2 col-sm-2">Start Date</label>
                                    <div class="col-sm-3 col-md-3">
                                        <input type="date" id="inputdate3" class="form-control" style="padding: 6px 4px;" min="<?php echo $school_date_created;?>">

                                    </div>


                                </div>
                                <div class="col-sm-12 col-md-12"> 
                                    <label class="control-label col-md-2 col-sm-2">End Date</label>
                                    <div class="col-sm-3 col-md-3">
                                        <input type="date" id="inputdate4" class="form-control" style="padding: 6px 4px;" min="<?php echo $school_date_created;?>">

                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <label class="control-label col-md-2 col-sm-2">Collection Center</label>
                                    <div class="col-sm-3 col-md-3">
                                        <select class="form-control" name="collection_center1" id="collection_center1">
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
                                </div>
                                <div class="col-sm-12 col-md-12" id="category_load" style="padding-top:2%">

                                    <form id="frmstudent2" role="form" method="POST">

                                        <table id="studentlist2" class="table table-bordered table-striped">
                                            <caption id="tabletitle1" style="text-align:center">CATEGORY WISE TERM REPORT</caption>
                                            <thead>

                                                <tr> 
                                                    <th rowspan="2" style="border-bottom:1px solid black;"> Category </th>
                                                    <th colspan="2" style="text-align: center;border-bottom:1px solid black;"> Term</th>
                                                    <th rowspan="2" style="border-bottom:1px solid black;"> Grand Total </th>
                                                    <th colspan="2" style="text-align: center;border-bottom:1px solid black"> Mode</th>

                                                </tr>
                                                <tr>
                                                    <th style="border-bottom:1px solid black;"> Annual </th>
                                                    <th style="border-bottom:1px solid black;"> Monthly </th>
                                                    <th style="border-bottom:1px solid black;">  </th>
                                                    <th style="border-bottom:1px solid black;">  </th>
                                                </tr>

                                            </thead>
                                            <tbody id="category_load_td">
                                            <!--                                                                                        <tr>
                                            <th colspan="10" ></th>
                                            </tr>-->
                                            </tbody>
                                        </table>


                                    </form>

                                </div>
                            </div>
                            <div class="tab-pane fade" id="classsect">
                                <div class="col-sm-12 col-md-12" style="padding-top:1%">
                                    <label class="control-label col-md-2 col-sm-2">Start Date</label>
                                    <div class="col-sm-3 col-md-3">
                                        <input type="date" id="inputdate5" class="form-control" style="padding: 6px 4px;" min="<?php echo $school_date_created;?>">

                                    </div>

                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <label class="control-label col-md-2 col-sm-2">End Date</label>
                                    <div class="col-sm-3 col-md-3">
                                        <input type="date" id="inputdate6" class="form-control" style="padding: 6px 4px;" min="<?php echo $school_date_created;?>">

                                    </div>
                                </div>

                                <div class="col-sm-12 col-md-12">
                                    <label class="control-label col-md-2 col-sm-2">Category</label>
                                    <div class="col-sm-3 col-md-3">
                                        <select class="form-control" id="categorylist3">
                                            <option value="">All</option>
                                            <?php
                                            foreach ($acategory as $cat) {
                                                ?>
                                                <option value="<?php echo $cat->id; ?>"><?php echo $cat->cat_name; ?></option>
                                                <?php
                                            }
                                            ?>

                                        </select>
                                        <!--<span class="help-block"></span>-->
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <label class="control-label col-md-2 col-sm-2">Collection Center</label>
                                    <div class="col-sm-3 col-md-3">
                                        <select class="form-control" name="collection_center2" id="collection_center2">
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
                                </div>
                                <div class="col-sm-12 col-md-12" id="classsect_load" style="padding-top:2%">

                                    <form id="frmstudent3" role="form" method="POST">

                                        <table id="studentlist3" class="table table-bordered table-striped">
                                            <caption id="tabletitle2" style="text-align:center">CLASS WISE TERM REPORT</caption>
                                            <thead>
                                                <tr> 
                                                    <th rowspan="2" style="border-bottom:1px solid black;"> Class</th>
                                                    <th rowspan="2" style="border-bottom:1px solid black;"> Section </th>
                                                    <th colspan="2" style="text-align: center;border-bottom:1px solid black;"> Term</th>
                                                    <th rowspan="2" style="border-bottom:1px solid black;"> Grand Total </th>
                                                    <th colspan="2" style="text-align: center;border-bottom:1px solid black"> Mode</th>

                                                </tr>
                                                <tr>
                                                    <th style="border-bottom:1px solid black;"> Annual </th>
                                                    <th style="border-bottom:1px solid black;"> Monthly </th>
                                                    <th style="border-bottom:1px solid black;">  </th>
                                                    <th style="border-bottom:1px solid black;">  </th>
                                                </tr>

                                            </thead>
                                            <tbody id="classsect_load_td">
                                            <!--                                                                                        <tr>
                                            <th colspan="10" ></th>
                                            </tr>-->
                                            </tbody>
                                        </table>


                                    </form>

                                </div>
                            </div>
                            <div class="tab-pane fade in" id="feehead">

                                <div class="col-sm-12 col-md-12" style="padding-top:1%">
                                    <label class="control-label col-md-2 col-sm-2">Start Date</label>
                                    <div class="col-sm-3 col-md-3">
                                        <input type="date" id="feedate4" class="form-control" style="padding: 6px 4px;" min="<?php echo $school_date_created;?>">
                                    </div>  


                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <label class="control-label col-md-2 col-sm-2">End Date</label>
                                    <div class="col-sm-3 col-md-3">
                                        <input type="date" id="feedate5" class="form-control" style="padding: 6px 4px;" min="<?php echo $school_date_created;?>">

                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-12">
                                    <label class="control-label col-md-2 col-sm-2">Collection Center</label>
                                    <div class="col-sm-3 col-md-3">
                                        <select class="form-control" name="collection_center4" id="collection_center4">
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
                                </div>
                                <div class="col-sm-12 col-md-12" id="feehead_load" style="padding-top:2%">

                                    <form id="frmstudent4" role="form" method="POST">

                                        <table id="studentlist4" class="table table-bordered table-striped">
                                            <caption id="tabletitle" style="text-align:center">FEE HEAD WISE TERM REPORT</caption>
                                            <thead>

                                                <tr> 

                                                    <th rowspan="2" style="border-bottom:1px solid black;"> Transaction Date </th>
                                                    <th colspan="2" style="text-align: center;border-bottom:1px solid black"> Term</th>
                                                    <th rowspan="2" style="border-bottom:1px solid black;"> Grand Total </th>
                                                    <th colspan="2" style="text-align: center;border-bottom:1px solid black"> Mode</th>

                                                </tr> 
                                                <tr>
                                                    <th style="border-bottom:1px solid black;">  </th>
                                                    <th style="border-bottom:1px solid black;">  </th>
                                                    <th style="border-bottom:1px solid black;">  </th>
                                                    <th style="border-bottom:1px solid black;">  </th>
                                                </tr>
                                            </thead>
                                            <tbody id="feehead_load_td">

                                            </tbody>
                                        </table>


                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
<!--
        </div>

    </div>-->
</div>


<script type="text/javascript">

    $(document).ready(function ()
    {
        $('#inputdate1' + ',#inputdate2' + ',#collection_center').change(function()
        {
            var from_date = $('#inputdate1').val();
            var to_date = $('#inputdate2').val();
            var collection_center = $('#collection_center').val();
            if (to_date == '')
            {
                $('#tabletitle').text(' DATE WISE TERM REPORT (' + from_date + ')');
            } 
            else 
            {
                $('#tabletitle').text(' DATE WISE TERM REPORT (' + from_date + ' TO ' + to_date + ')');
            }

            $('#date_load_td').html("<tr><td colspan='10'><h3 style='text-align:center'> Loading....... </h3></td></tr>");
            $.ajax({
                url: '<?php echo base_url(); ?>feepayment/Report_Army/date_wise_term_report',
                dataType: "text",
                method: 'post',
                data: {
                    from_date: from_date,
                    to_date: to_date,
                    collection_center: collection_center
                },
                success: function (data) {
                    $('#date_load').html(data);
                    if (to_date == '')
                    {
                        $('#tabletitle').text(' DATE WISE TERM REPORT (' + from_date + ')');
                    } 
                    else 
                    {
                        $('#tabletitle').text(' DATE WISE TERM REPORT (' + from_date + ' TO ' + to_date + ')');
                    }
                },
                error: function () {
                }
            });
        });


        $('#inputdate3' + ',#inputdate4' + ',#collection_center1').change(function ()
        {


            var from_date = $('#inputdate3').val();
            var to_date = $('#inputdate4').val();
            var collection_center = $('#collection_center1').val();
            if (to_date == '')
            {
                $('#tabletitle1').text(' CATEGORY WISE TERM REPORT (' + from_date + ')');
            } else {
                $('#tabletitle1').text(' CATEGORY WISE TERM REPORT (' + from_date + ' TO ' + to_date + ')');
            }

            $('#category_load_td').html("<tr><td colspan='10'><h3 style='text-align:center'> Loading....... </h3></td></tr>");
//         alert(from_date);
            $.ajax({

                url: '<?php echo base_url(); ?>feepayment/Report_Army/category_wise_term_report',
                dataType: "text",
                method: 'post',
                data: {

                    from_date: from_date,
                    to_date: to_date,
                    collection_center: collection_center
                },
                success: function (data) {
//                      alert(data);
                    $('#category_load').html(data);
                    if (to_date == '')
                    {
                        $('#tabletitle1').text(' CATEGORY WISE TERM REPORT (' + from_date + ')');
                    } else {
                        $('#tabletitle1').text(' CATEGORY WISE TERM REPORT (' + from_date + ' TO ' + to_date + ')');
                    }

                },
                error: function () {
                    alert('Error while Loading!');

                }

            });



        });


        $('#inputdate5' + ',#inputdate6' + ',#collection_center2' + ',#categorylist3').change(function ()
        {


            var from_date = $('#inputdate5').val();
            var to_date = $('#inputdate6').val();
            var category = $('#categorylist3').val();
            var collection_center = $('#collection_center2').val();
            if (to_date == '')
            {
                $('#tabletitle2').text(' CLASS WISE TERM REPORT (' + from_date + ')');
            } else {
                $('#tabletitle2').text(' CLASS WISE TERM REPORT (' + from_date + ' TO ' + to_date + ')');
            }
//        $('#tabletitle1').text(' CATEGORY WISE TERM REPORT FROM '+from_date+' TO '+to_date);
            $('#classsect_load_td').html("<tr><td colspan='10'><h3 style='text-align:center'> Loading....... </h3></td></tr>");
//         alert(from_date);
            $.ajax({

                url: '<?php echo base_url(); ?>feepayment/Report_Army/class_wise_term_report',
                dataType: "text",
                method: 'post',
                data: {

                    from_date: from_date,
                    to_date: to_date,
                    category: category,
                    collection_center: collection_center
                },
                success: function (data) {
//                      alert(data);
                    $('#classsect_load').html(data);
                    if (to_date == '')
                    {
                        $('#tabletitle2').text(' CLASS WISE TERM REPORT (' + from_date + ')');
                    } else {
                        $('#tabletitle2').text(' CLASS WISE TERM REPORT (' + from_date + ' TO ' + to_date + ')');
                    }
                },
                error: function () {
                    alert('Error while Loading!');

                }

            });



        });

        $('#feedate4' + ',#feedate5' + ',#collection_center4').change(function ()
        {


            var from_date = $('#feedate4').val();
            var to_date = $('#feedate5').val();
            var collection_center = $('#collection_center4').val();
            if (to_date == '')
            {
                $('#tabletitle').text(' FEE HEAD WISE TERM REPORT (' + from_date + ')');
            } else {
                $('#tabletitle').text(' FEE HEAD WISE TERM REPORT (' + from_date + ' TO ' + to_date + ')');
            }

            $('#feehead_load_td').html("<tr><td colspan='10'><h3 style='text-align:center'> Loading....... </h3></td></tr>");
//         alert(from_date);
            $.ajax({

                url: '<?php echo base_url(); ?>feepayment/Report_Army/feehead_wise_term_report',
                dataType: "text",
                method: 'post',
                data: {

                    from_date: from_date,
                    to_date: to_date,
                    collection_center: collection_center
                },
                success: function (data) 
                {
//                      alert(data);
                    $('#feehead_load').html(data);
                    if (to_date == '')
                    {
                        $('#tabletitle').text(' FEE HEAD WISE TERM REPORT (' + from_date + ')');
                    } else {
                        $('#tabletitle').text(' FEE HEAD WISE TERM REPORT (' + from_date + ' TO ' + to_date + ')');
                    }
                },
                error: function () {
                    alert('Error while Loading!');

                }

            });



        });



    });



</script>