<!--<style type="text/css">
    .edit_form .form-control{
        margin-bottom:5px;
    }
</style>-->

<?php
foreach ($cities as $city) {
    $city_name[$city->id] = $city->city_name;
    $state_name[$city->id] = $city->city_state;
}
?>

<div class="form-group has-feedback">

    <!-- general form elements -->
    <div class="box">

            <div class="box-body">
                <div class="col-lg-12">
                    <div class="col-lg-12" style="text-align:right;"><button type="button" data-toggle="modal" class="btn btn-success" id="add_schools"><i class="fa fa-plus-circle fa-lg"></i> Add School</button></div>

                </div>
            </div>
            <div class="box-body table-responsive">
                <table id="schoollist" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                       
                            <th>ID</th>
                            <th>School Name</th>
                            <th>School Code</th>
                            <th>Address</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Contact No.</th>
                            <th>Email Address</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($schools as $school) { ?>
                            <tr>
                                <td><?php echo $school->id ?></td>
                                <td><?php echo $school->description; ?></td>
                                <td><?php echo $school->school_code; ?></td>
                                <td><?php echo $school->address; ?></td>
                                <td><?php echo $school->state_name; ?></td>
                                <td><?php echo $city_name[$school->city_id]; ?></td>
                                <td><?php echo $school->phone; ?></td>
                                <td><?php echo $school->email; ?></td>
                                <td><?php
                                    if ($school->status == '1') {
                                        echo '<a style="color:green;">Active<a>';
                                    } else {
                                        echo '<a style="color:red;">Inactive</a>';
                                    }
                                    ?></td>
                                <td> 
                                <!--<a class="btn" onclick="edit_school('<?php // echo $this->encrypt->encode($school->id);  ?>', '<?php // echo $school->description;  ?>', '<?php // echo $school->school_code;  ?>', '<?php // echo $school->address;  ?>', '<?php // echo $school->state_id;  ?>', '<?php // echo $school->city_id;  ?>', '<?php // echo $school->phone  ?>', '<?php // echo $school->email;  ?>', '<?php // echo $school->status;  ?>', '<?php // echo $school->fee_type1;  ?>', '<?php // echo $school->fee_type2;  ?>', '<?php // echo $school->last_pay_date;  ?>')">-->
                                    <a class="btn" id="<?php echo $school->id ?>" >
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <!--<a class="btn" data-toggle="modal" data-target="#delete_user_<?php // echo $school->id;   ?>">-->
                                    <!-- <a class="btn" onclick="delete_school('<?php echo $this->encrypt->encode($school->id); ?>', '<?php echo $school->description; ?>')">
                                        <i class="fa fa-trash"></i> Delete
                                    </a> -->
                                </td>
                            </tr>

<?php } ?>
                    </tbody>
                    <tfoot>
                    </tfoot>
                </table>
            </div>


    </div>
</div>


<!-- Modal EDIT SCHOOL -->
<div class="modal fade" id="edit_school" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" role="form" name="form_edit" action="<?php echo base_url("admin_school/edit_school") ?>"> 
                <!--<form class="form-horizontal">-->
                <div class="modal-header" id="modal_header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">School Information</h4>
                </div>
                <div class="modal-body" id="modal-body">
                    <input type="hidden" name="edit_school_id" id="edit_school_id" value="">
                    <!--                                <div class="box-body edit_form">-->
                    <div class="row">
                        <div class="col-sm-5">

                            <div class="form-group">
                                <label for="school_name" class="col-sm-3 control-label">School Name :</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="edit_school_name" name="edit_school_name" value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="school_name" class="col-sm-3 control-label">School Code :</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="edit_school_code" name="edit_school_code" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="school_address" class="col-sm-3 control-label">Address :</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" id="edit_school_address" name="edit_school_address" required></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="Country" class="col-sm-3 control-label">Country :</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="edit_country" name="edit_country" onchange="select_country()"> 
                                        <option value="">- Select Country -</option>
                                        <?php foreach ($country as $obj_country) { ?>
                                            <option value="<?php echo $obj_country->id; ?>" <?php ?>><?php echo $obj_country->country_name ?></option>
<?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" id="div_state">
                                <label for="edit_school_state" class="col-sm-3 control-label">State:</label>
                                <div class="col-sm-9">
                                <!--<select class="form-control" id="edit_school_state" name="edit_school_state" onchange="select_edit_city(<?php // echo $school->id; ?>)">--> 
                                    <select class="form-control" id="edit_school_state" name="edit_school_state" onchange="select_edit_city();"> 
                                        <?php foreach ($states as $state) { ?>
                                            <option value="<?php echo $state->id ?>" ><?php echo $state->state_name ?></option>
<?php } ?>
                                    </select>
                                </div>
                            </div>


<?php // $cities_selected = $this->dbconnection->select('cities','*',"city_state = '".$state_name[$school->city_id]."'");   ?>
                            <div class="form-group" id="div_city">
                                <label for="edit_school_city" class="col-sm-3 control-label">City:</label>
                                <div class="col-sm-9" id="div_edit_city">
                                    <select class="form-control" id="edit_school_city" name="edit_school_city">
                                        <option value="">-- Select City---</option> 
                                        <?php foreach ($cities as $city_s) { ?>
                                            <option value='<?php echo $city_s->id ?>'><?php echo $city_s->city_name ?></option>
<?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contact_no" class="col-sm-3 control-label">Contact No.:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="edit_contact_no" name="edit_contact_no" value="" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email_address" class="col-sm-3 control-label">Email Address:</label>
                                <div class="col-sm-9">
                                <!--<input type="email" class="form-control" id="edit_email_address" name="edit_email_address" value="" onblur="check_edit_email(<?php // echo $school->id;   ?>)" required>-->
                                    <input type="email" class="form-control" id="edit_email_address" name="edit_email_address" value=""  required>
                                    <input type="hidden" id="orig_edit_email_address" name="orig_edit_email_address" value="">
                                    <span id="span_edit_email_error" style="color:red"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="edit_school_status" class="col-sm-3 control-label">Status:</label>
                                <div class="col-sm-9">
                                    <select class="form-control" id="edit_school_status" name="edit_school_status"> 
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="form-group">
                                <label for="fee_struct" class="col-sm-6 control-label">Fee Structure: </label>
                                <!--<label for="fee_struct" class="col-sm-3"></label>-->

                                <div class="col-sm-6">
                                    <label class="radio-inline  col-sm-1">1.)</label> 
                                    <!--<label class="radio-inline col-sm-3"><input type="radio" id="editoptradio1a" name="editoptradio1" <?php // if($school->fee_type1==1) {echo 'checked';}  ?> value="1">Monthly</label>-->
                                    <label class="radio-inline col-sm-3"><input type="radio" id="editoptradio1a" name="editoptradio1" value="1">Monthly</label>
                                    <label class="radio-inline col-sm-3"><input type="radio" id="editoptradio1b" name="editoptradio1" value="2">Quarterly</label>
                                    <label class="radio-inline  col-sm-5"></label> 
                                </div>

                                <label class="col-sm-6 control-label"></label>
                                <div class="col-sm-6">
                                    <label class=" radio-inline col-sm-1">2.)</label>
                                    <label class="radio-inline col-sm-3"><input type="radio" id="editoptradio2a" name="editoptradio2"  value="3">Half-Yearly</label>
                                    <label class="radio-inline col-sm-3"><input type="radio" id="editoptradio2b" name="editoptradio2"  value="4">Annual</label>
                                    <label class="radio-inline  col-sm-5"></label> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="start_date" class="col-sm-6 control-label">Start Payment Day (of every month):</label>
                                <div class="col-sm-6" style="padding-top:1%">
                                    <input type="text" class="form-control" id="edit_start_pay_date" name="edit_start_pay_date" required placeholder="Day">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="last_date" class="col-sm-6 control-label">Last Payment Day (of every month):</label>
                                <div class="col-sm-6" style="padding-top:1%">
                                    <input type="text" class="form-control" id="edit_last_pay_date" name="edit_last_pay_date" required placeholder="Day">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="lbl_trans_freeze_status" class="col-sm-6 control-label">Whether to Freeze the payment after crossing Due Date :</label>
                                <div class="col-sm-6" style="padding-top:1%">
                                    <select class="form-control" name="edit_trans_freeze_status" id="edit_trans_freeze_status">
                                        <option value="0">NO</option>
                                        <option value="1">YES</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="lbl_fine_monthly_segregation" class="col-sm-6 control-label">Whether to have Fine details With Monthly Segregation :</label>
                                <div class="col-sm-6" style="padding-top:1%">
                                    <select class="form-control" name="edit_fine_monthly_segregation" id="edit_fine_monthly_segregation">
                                        <option value="NO">NO</option>
                                        <option value="YES">YES</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="lbl_pymt_gateway" class="col-sm-6 control-label">Choose Payment Gateway :</label>
                                <div class="col-sm-6" style="padding-top:1%">
                                    <select class="form-control" name="edit_pymt_gateway" id="edit_pymt_gateway">
                                        <option value="">Select</option>
                                        <?php foreach ($pymt_gw as $gw) { ?>                                                   
                                            <option value="<?php echo $gw->pymt_gw_code; ?>"><?php echo $gw->pymt_gw_code; ?></option>                                                   
<?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="lbl_mid" class="col-sm-6 control-label">Enter Mid of Chosen Payment Gateway :</label>
                                <div class="col-sm-6" style="padding-top:1%">
                                    <input type="text" class="form-control" id="edit_mid" name="edit_mid" required placeholder="Merchant Id">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="lbl_enckey" class="col-sm-6 control-label">Enter Encryption Key of Chosen Payment Gateway :</label>
                                <div class="col-sm-6" style="padding-top:1%">
                                    <input type="text" class="form-control" id="edit_enckey" name="edit_enckey" required placeholder="Encryption Key">
                                </div>
                            </div>

                        </div>







                    </div>
                </div>
                <div class="modal-footer" id="modal-footer">
                    <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                    <!--<button type="button" name="btn_edit_school" id="btn_edit_school<?php // echo $school->id;   ?>" class="btn btn-primary" onclick="form_submit(<?php // echo $school->id;   ?>)"><i class="fa fa-edit"></i> Save changes</button>-->
                    <button type="submit" name="btn_edit_school" id="btn_edit_school" class="btn btn-success" style="padding: 2px 12px !important;width: 130px;font-weight: bold;font-family: monospace;border-radius: 12px">
                    <!--<i class="fa fa-edit"></i>--> 
                        Update</button> 
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal DELETE SCHOOL -->
<div class="modal fade" id="delete_school" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" role="form" action="<?php echo base_url("admin_school/delete_school") ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Delete School</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="delete_school_id" id="delete_school_id" value="">
                    Are you sure you want to <b style="color:red">delete</b> school <label id ='del_school_desc'></label>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" name="btn_edit_school" id="btn_edit_school" class="btn btn-primary"><i class="fa fa-trash"></i> Delete</button>
                </div>
            </form>
        </div>
    </div> 
</div>    

<script>
    $(document).ready(function () {
        $("#schoollist").DataTable();
        $('#add_schools').click(function()
        {


                window.location.href = "<?php echo base_url('admin_school/addedit_schview');?>";

        });
    });









//  function form_submit(school_id){
//    $.ajax({
//        type: 'POST',
//        url: '<?php // echo base_url('admin_school/edit_school');   ?>',
//        data: {
//            edit_school_name:$("#edit_school_name"+school_id).val(),
//            edit_school_address:$("#edit_school_address"+school_id).val(),
//            edit_school_city:$("#edit_school_city"+school_id+" option:selected").val(),
//            edit_contact_no:$("#edit_contact_no"+school_id).val(),
//            edit_email_address:$("#edit_email_address"+school_id).val(),
//            edit_school_status:$("#edit_school_status"+school_id+" option:selected").val(),
//            edit_school_id:$("#edit_school_id"+school_id).val(),
//            orig_edit_email_address:$("#orig_edit_email_address"+school_id).val(),
//            fee_type1:$("input[name=editoptradio1]").val(),
//            fee_type2:$("input[name=editoptradio2]").val()
//        },
//        success: function(res) {
//          location.href=$('#base_url').val()+'admin_school';
//        },
//        error: function(req, status){
//            return false;
//        }
//    });
//  }

    // function show_class(id)
    // {
    //     location.href = $('#base_url').val() + 'school/class?school=' + id;
    // }




    // function delete_school(id, desc)
    // {
    //     $('#delete_school_id').val(id);
    //     $('#del_school_desc').text(desc);
    //     $('#delete_school').modal('show');
    // }
    
    $('#schoollist a').click(function()
    {   

        var id=$(this).attr('id');
    
        window.location.href = "<?php echo base_url('admin_school/addedit_schview');?>"+'/'+id;

    });


</script>
