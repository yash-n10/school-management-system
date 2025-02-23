<style>
    .form-group{margin-bottom: 10px;} 
    fieldset { 
        border: solid 1px #a6a6a6 !important;
        padding: 0 10px 10px 10px;
        border-bottom: none;
        border-top-left-radius: 25px;
        border-bottom-left-radius: 25px;
        border-top: 2px solid #29a3a3 !important;
    }
    legend{
        width: auto !important;
        padding:0 10px;
        border: none;
        font-size: 14px;
        font-variant: small-caps;
        letter-spacing: 1px;
        text-decoration: underline;
    }
    .form-control{
        padding: 6px 5px !important;
        color:darkblue
    }
    .error-block {
        font-size: 12px;
        color: red;
    }
    .error-block >p {
        margin: 3px;
    }
</style>
<link href="<?php echo e(base_url("assets/AdminLTE/plugins/bootstrap-fileinput/bootstrap-fileinput.css")); ?>" rel="stylesheet" type="text/css" />
<div class="form-group">
    <div class="panel  panel-default"> 

        <div class="panel-body">

            <form enctype="multipart/form-data" id="employeedetails-form" action="" method="post">
                <div class="col-sm-12 col-md-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <fieldset class="">
                                <legend class="" style="font-size:18px;color:green">
                                    Exam Details <span class="required"></span>
                                </legend>
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label  style="font-weight: 600">Class</label> <span style='color:red;font-weight:bold'>*</span>
                                        <select name="class" id="class" class="form-control">
                                        	<option>Select Class</option>
                                        	<?php foreach ($fetch_class as $key => $value) { ?>
                                        	<option value="<?php echo $value->id ?>"><?php echo $value->class_name; ?></option>	
                                        	<?php } ?>
                                        </select>
                                        <span class="error-block"></span>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label style="font-weight: 600">Subject</label> <span style='color:red;font-weight:bold'>*</span>
                                        <select name="subject" id="subject" class="form-control">
                                        	<option>Select Subject</option>
                                        	<?php foreach ($fetch_subject as $key => $value) { ?>
                                        	<option value="<?php echo $value->id ?>"><?php echo $value->name; ?></option>	
                                        	<?php } ?>
                                        </select>
                                        <span class="error-block"></span>
                                    </div>
                                    <div class="form-group col-sm-4">
                                        <label style="font-weight: 600">Exam</label> <span style='color:red;font-weight:bold'>*</span>
                                        <select name="exam" id="exam" class="form-control">
                                        	<option>Select Exam</option>
                                        	<?php foreach ($fetch_exam as $key => $value) { ?>
                                        	<option value="<?php echo $value->id ?>"><?php echo $value->name; ?></option>	
                                        	<?php } ?>
                                        </select>

                                        <span class="error-block"></span>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row" style="padding-top:2%">
                        <div class="col-sm-12">
                            <fieldset class="">
                                <legend class="" style="font-size:18px;color:green">
                                    Question Group A <span class="required"></span>
                                </legend>

                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Question 1</label>
                                        <input class="form-control" name="question_1" id="question_1" type="text" value="" >
                                        <span class="error-block"></span>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Question 2</label>
                                        <input class="form-control" name="question_2" id="question_2" type="text" value="" >
                                        <span class="error-block"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Question 3</label>
                                        <input type='text' class="form-control" id="question_3" name="question_3" value="" >

                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Question 4</label>
                                        <input type='text' class="form-control" id="question_4" name="question_4" value="" >
                                        <span class="error-block"></span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Question 5</label>
                                        <input class="form-control" name="question_5" id="question_5" type="text" value="">
                                        <span class="error-block"></span>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Question 6</label>
                                        <input  class="form-control" name="question_6" id="question_6" type="text" value="">
                                        <span class="error-block"></span>
                                    </div>
                                </div>
                            </fieldset>
                            <fieldset class="">

                                <legend class="" style="font-size:18px;color:green">
                                    Question Group B <span class="required"></span>
                                </legend>
                                <div class="row"> 
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Question 7</label>
                                        <input class="form-control" name="question_7" id="question_7" type="text" value="" >
                                        <span class="error-block"></span>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Question 8</label>
                                        <input  class="form-control" name="question_8" id="question_8" type="text" value="">
                                        <span class="error-block"></span>
                                    </div>
                                </div>

                                <div class="row"> 
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Question 9</label>
                                        <input class="form-control" name="question_9" id="question_9" type="text" value="" >
                                        <span class="error-block"></span>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Question 10</label>
                                        <input  class="form-control" name="question_10" id="question_10" type="text" value="">
                                        <span class="error-block"></span>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Question 11</label>
                                        <input class="form-control" name="question_11" id="question_11" type="text" value="" >
                                        <span class="error-block"></span>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Question 12</label>
                                        <input  class="form-control" name="question_12" id="question_12" type="text" value="">
                                        <span class="error-block"></span>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="">

                                <legend class="" style="font-size:18px;color:green">
                                    Question Group C <span class="required"></span>
                                </legend>
                                <div class="row"> 
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Question 13</label>
                                        <input class="form-control" name="question_13" id="question_13" type="text" value="" >
                                        <span class="error-block"></span>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Question 14</label>
                                        <input  class="form-control" name="question_14" id="question_14" type="text" value="">
                                        <span class="error-block"></span>
                                    </div>
                                </div>

                                <div class="row"> 
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Question 15</label>
                                        <input class="form-control" name="question_15" id="question_15" type="text" value="" >
                                        <span class="error-block"></span>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Question 16</label>
                                        <input  class="form-control" name="question_16" id="question_16" type="text" value="">
                                        <span class="error-block"></span>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Question 17</label>
                                        <input class="form-control" name="question_17" id="question_17" type="text" value="" >
                                        <span class="error-block"></span>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Question 18</label>
                                        <input  class="form-control" name="question_18" id="question_18" type="text" value="">
                                        <span class="error-block"></span>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset class="">
                                <legend class="" style="font-size:18px;color:green">
                                    Question Group D <span class="required"></span>
                                </legend>
                                <div class="row"> 
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Question 19</label>
                                        <input class="form-control" name="question_19" id="question_19" type="text" value="" >
                                        <span class="error-block"></span>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Question 20</label>
                                        <input  class="form-control" name="question_20" id="question_20" type="text" value="">
                                        <span class="error-block"></span>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Question 21</label>
                                        <input class="form-control" name="question_21" id="question_21" type="text" value="" >
                                        <span class="error-block"></span>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Question 22</label>
                                        <input  class="form-control" name="question_22" id="question_22" type="text" value="">
                                        <span class="error-block"></span>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Question 23</label>
                                        <input class="form-control" name="question_23" id="question_23" type="text" value="" >
                                        <span class="error-block"></span>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label style="font-weight: 600">Question 24</label>
                                        <input  class="form-control" name="question_24" id="question_24" type="text" value="">
                                        <span class="error-block"></span>
                                    </div>
                                </div>
                            </fieldset>

                        </div>     
                    </div>
                    <div class="row" style="padding-top:2%">
                        <div class="col-lg-12" style="text-align:center"> 
                            <button type="button" class="btn btn-primary" style="width: 120px;font-family: sans-serif;float:left" id="back" ><i class="fa fa-arrow-left"> </i> Back</button>
                            <input type="button" class="btn btn-success" style="width: 120px;font-family: sans-serif;" name="saveemployee" id="btn_save" value="<?php echo $task; ?>">
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->
<script src="<?php echo e(base_url("assets/AdminLTE/plugins/bootstrap-fileinput/bootstrap-fileinput.js")); ?>" type="text/javascript"></script> 
<script>

    $(document).ready(function ()
    {
        var task = '<?php echo $task; ?>';
        var question_id = '<?php echo $employee_id; ?>';

        $('#back').click(function () {
//                alert('hi');
            window.location.href = '<?php echo base_url('academics/OnlineExam/OnlineExam'); ?>';
        });

        $('#btn_save').click(function () {

            if (!$('#employeedetails-form')[0].checkValidity()) {
                $(this).show();
                $('#employeedetails-form')[0].reportValidity();
                return false;
            } else {
                var formdata = $('form').serialize();
                if (task == 'Save')
                {
                    action_url = '<?php echo base_url('academics/OnlineExam/OnlineExam/save'); ?>';
                }
                else
                {
                    action_url = '<?php echo base_url('academics/OnlineExam/OnlineExam/update'); ?>' + '/' + question_id;
                }
//                alert(action_url);
                $.ajax
                        ({
                            type: 'POST',
                            data: formdata,
                            url: action_url,
                            dataType: "text",
                            success: function (data)
                            {
                               window.location.href = '<?php echo base_url('academics/OnlineExam/OnlineExam'); ?>';

                            },
                            error: function (data)
                            {
                                alert('error occured while saving' + data);
                            }

                        });
            }
        });



    });



</script>