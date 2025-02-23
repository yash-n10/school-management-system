<?php
defined('BASEPATH') OR exit('No direct script access allowed');

foreach ($user_groups as $user_group) {
    $user_group_name[$user_group->id] = $user_group->group_type;
}
foreach ($schools as $school) {
    $school_name[$school->id] = $school->description;
    $school_email[$school->id] = $school->email;
}
foreach ($students as $student) {
    $student_email[$student->id] = $student->email_address;
}
?>
<!-- Modal ADD USER -->
<div class="modal fade" id="add_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" role="form" enctype="multipart/form-data" id="add_user_form" action="<?php echo base_url("settings/users/add_user") ?>">
                <div class="modal-header">
                    <input type="hidden" name="edit_user_id" id="edit_user_id" value="">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Add User</h4>
                </div>
                <div class="modal-body">                            
                    <div id="user_grp1">
                        <div class="form-group">
                            <label for="school_status" class="col-sm-3 control-label">User Group:</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="user_group" name="user_group" onchange="select_user_group(this)" required autofocus>
                                    <option value="">Select user group</option>
                                    <?php foreach ($user_groups as $user_group) { ?>
                                        <option value="<?php echo $user_group->id ?>"><?php echo $user_group->group_type; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" style="display:none" id="select_school">
                            <label for="school" class="col-sm-3 control-label">School:</label>
                            <div class="col-sm-9">
                                <select class="form-control" id="school" name="school" onchange="school_change()" > 
                                    <option value="">- Select School -</option>
                                    <?php foreach ($schools as $school) { ?>
                                        <option data-attr1="<?php echo $school->school_code ?>" value="<?php echo $school->id ?>"><?php echo $school->description; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="div_userinfo" style="display:none">
                            <label for="userinfo" class="col-sm-3 control-label" id="userinfo_lbl">User Info:</label>
                            <div class="col-sm-9" id="div_userinfo_select">
                                <select class="form-control" id="userinfo" name="userinfo"> 
                                    <option value="0">- Select -</option>
                                    
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="user_name" class="col-sm-3 control-label">Username:</label>
                            <div class="col-sm-9">
                                <div class="form-group">
                                    
                                    <div class="col-sm-2" style="padding-right:0px;">
                                        <input type="text" class="form-control" style="pointer-events: none;padding-right:0px;" id="school_code" name="school_code" value="<?php if($this->session->userdata('school_code')==''){echo '@';}else{echo $this->session->userdata('school_code');}?>-">
                                    </div>
                                    <div class="col-sm-10" style="padding-left:0px;">
                                        <input type="text" class="form-control" id="user_name" name="user_name" required autofocus>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group" id="div_pwd">
                            <label for="user_name" class="col-sm-3 control-label">Password:</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="Password" name="Password" required autofocus>
                            </div>
                        </div>
                        <div class="form-group" id="div_cnfrm_pwd">
                            <label for="user_name" class="col-sm-3 control-label">Confirm Password:</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="ConfirmPassword" name="ConfirmPassword" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="contact_no" class="col-sm-3 control-label">Contact No:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="contact_no" name="contact_no" required autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-3 control-label">Email:</label>
                            <div class="col-sm-9">
                                <input type="email" class="form-control" id="email" name="email" required autofocus>
                            </div>
                        </div>



                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="btn_add_user" name="btn_add_user" class="btn btn-primary pull-right"><i class="fa fa-plus-circle"></i> <span id="txt">Save</span></button>
                </div>
            </form>
        </div>
    </div>
</div>



<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php if(substr($right_access, 1,1)=='R') {?>
            <div class="box">
                <div class="box-body">
                    <?php // if ($this->session->flashdata('user_message')) { ?>
                        <!--<div class="alert alert-success"> <?php // echo $this->session->flashdata('user_message') ?> </div>-->
                    <?php // } ?>
                </div>
                <div class="box-body">
                    <div class="col-lg-12">
                        <?php if(substr($right_access, 0,1)=='C') {?>
                      <div class="col-lg-12" style="text-align:right;"><button type="button" data-toggle="modal" data-target="#add_user" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add User</button></div>
                        <?php }?>
                    </div>
                </div>
                <?php if($this->session->userdata('user_group_id')==1){?>
                <div class="box-body">
                    <label class="col-lg-1">School</label>
                    <div class="col-lg-3" style="text-align:right;">
                      
                        <select class="form-control" id="school_select" style="font-weight:bold" name="school"> 
                        <option>- Select -</option>
                        <?php foreach($schools as $school){ ?>
                        <option data-attr1="<?php echo $school->school_code ?>" value="<?php echo $school->id ?>" <?php if($school_select==$school->id){echo 'selected=selected';} ?>><?php echo $school->description; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                </div>
                <?php }?>
                <div class="box-body">
                    <table id="userlist" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email Address</th>
                                <th>User Group</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($users as $user) {
                        $username = explode('-', $user->user_name) ?>
                                <tr>
                                    <td><?php echo $user->user_name; ?></td>
                                    <td><?php echo $user->email; ?></td>
                                    <td><?php echo $user_group_name[$user->user_group_id]; ?></td>
                                    <td><?php if($user->status==1){echo '<a style="color:green;">Active<a>';}else{ echo '<a style="color:red;">Inactive</a>';} ?></td>

                                    <td>
                                        
                                                <?php if(substr($right_access, 2,1)=='U') {?>
                                                <a class="btn" onclick="edit_user(this,'<?php echo $this->encrypt->encode($user->id); ?>','<?php echo $username[0]; ?>', '<?php echo $username[1]; ?>','<?php echo $user->student_id; ?>','<?php echo $user->employee_id; ?>','<?php echo $user->contact_no; ?>', '<?php echo $user->email; ?>',<?php echo $user->user_group_id ?>)">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <?php }?>
                                                <?php if($user->status==1){
                                                    if(substr($right_access, 3,1)=='D') {?>
                                                <a class="btn" onclick="delete_user('<?php echo $this->encrypt->encode($user->id); ?>',  '<?php echo $user->user_group_id; ?>','<?php echo $username[1]; ?>')">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>
                                                <?php }}?>
                                                <?php if(substr($right_access, 2,1)=='U') {?>
                                                <a class="btn" onclick="change_user_pwd('<?php echo $this->encrypt->encode($user->id); ?>', '<?php echo $user->user_group_id; ?>', '<?php echo $user->user_name; ?>')">
                                                    <i class="fa fa-lock"></i> Password
                                                </a>
                                                <?php }?>
                                       
                                       
                                    </td>
                                </tr>


<?php } ?>
                        </tbody>
                        <tfoot>
                        </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->

                <!-- </form> -->
            </div>
            <?php }?>
            <!-- /.box -->
        </div>

        <!--/.col (right) -->
    </div>
    <!-- /.row -->
</section>







<!-- Modal DELETE USER -->
<div class="modal fade" id="delete_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" role="form" action="<?php echo base_url("settings/users/delete_user") ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Delete User</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="delete_user_id" id="delete_user_id" value="">
                    <input type="hidden" name="delete_user_group" id="delete_user_group" value="">
                    <input type="hidden" name="school" id="delete_school" value="">
                    Are you sure you want to <b style="color:red">delete</b> user <label id="del_user_name"></label>?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" name="btn_edit_school" id="btn_edit_school" class="btn btn-primary"><i class="fa fa-trash"></i> Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Modal CHANGE PASSWORD -->
<div class="modal fade" id="change_password_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" method="POST" role="form" action="<?php echo base_url("settings/users/change_password") ?>">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Reset User Password</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="change_user_id" id="change_user_id" value="">
                    <input type="hidden" name="change_user_group" id="change_user_group" value="">
                    <input type="hidden" name="school" id="change_school" value="">
                    <!--<input type="hidden" name="change_user_group" id="change_user_group" value="<?php // echo $this->encrypt->encode($user->user_group_id);  ?>">-->
                    <div class="box-body edit_form">
                        <div class="form-group">
                            <label for="change_password" class="col-sm-4 control-label">Password:</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="change_password" name="change_password" value="" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="change_re_password_lbl" class="col-sm-4 control-label">Re-enter Password:</label>
                            <div class="col-sm-8">
                                <input type="password" class="form-control" id="change_re_password" name="change_re_password" value="" required>
                            </div>
                        </div>  Are you sure you want to reset password for username <label id="change_pwd_user_name"></label> ?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" name="btn_reset_user" id="btn_reset_user" class="btn btn-primary"><i class="fa fa-lock"></i> Reset Password</button>
                </div>
            </form>
        </div>
    </div>
</div>





<script>
    var user_group ='<?php echo $user_grp_id; ?>';
    $(document).ready(function () {

        // $("#userlist").DataTable();
        datatable();
        
        $('#add_user').on('hidden.bs.modal',function(e) 
        {
                $('#add_user_form')[0].reset();
                $('#myModalLabel').text('Add User');
                $('#div_pwd').html('<label for="user_name" class="col-sm-3 control-label">Password:</label><div class="col-sm-9"><input type="password" class="form-control" id="Password" name="Password" required autofocus></div>');
                $('#div_cnfrm_pwd').html('<label for="user_name" class="col-sm-3 control-label">Confirm Password:</label><div class="col-sm-9"><input type="password" class="form-control" id="ConfirmPassword" name="ConfirmPassword" required autofocus></div>');
                $('#select_school').hide();
                $('#div_userinfo').hide();
//                $('select').trigger('change');
                $('#frmsection').attr('action',"<?php echo site_url('user/add_user')?>");
//                        $('#frmsection .modal-title').text('Add Section');
        });


    });

    function datatable()
        {
            $('#userlist').DataTable({
                 "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                dom: 'lfBrtip',
                buttons: [
                                {
                                    extend: 'collection',
                                    text: 'Export',
                                    className: 'red',
                                    buttons: [
                                        'excel',
                                        'csv',

                                    ]
                                }
                            ],

            });
        }
    
    function school_change()
    {
        $('#school_code').val($('#school').find(':selected').attr('data-attr1') + '-');
        var school_id =$('#school').val();
        var user_group =   $('#user_group').val();   
        get_userinfo(user_group,school_id);
    }


    $('#school_select').change(function()
    {
            var school_id=this.value;
//                    alert(admn_no);
            window.location.href = '<?php echo base_url('settings/users/index/fetch');?>'+'/'+school_id;


    });
    
    $('#ConfirmPassword').change(function () {
        
        if ($('#ConfirmPassword').val() != $('#Password').val())
        {
            $('#ConfirmPassword').focus();
            alert('Password did not match');
        }
    });
    
    $('#change_re_password').change(function () {
//        alert($('#change_re_password').val() +'  '+$('#change_password').val());
        if ($('#change_re_password').val() != $('#change_password').val())
        {
            $('#change_re_password').focus();
            alert('Password did not match');
        }
    });

    function select_user_group(me)
    {
        var user_group = $(me).val();
        var session_grp= '<?php echo $user_grp_id; ?>';
        if(session_grp==1) { // appadmin login
            if (user_group != 1) { // selected user group is not app admin
    //        alert('hello');
                $('#select_school').css('display', 'block');
                $('#school').show();
                $('#school').val('');
                $('#school').attr('required',true);
                $('#userinfo').val('0');

                
            } else {
                $('#select_school').css('display', 'none');
                $('#school').attr('required',false);
                $('#school_code').val('@-');
            }
        }
        else{
            var school_id ='';
             get_userinfo(user_group,school_id);
        }
//        $('select').trigger('change');
    }
    
    
    function get_userinfo(user_group,school_id,userinfo='0') {
//        alert(user_group +'   '+ school_id+' '+userinfo);
            $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('settings/users/get_userinfo_dropdown'); ?>',
                    data: {
                        user_group: user_group,
                        school_id: school_id,
                        
                    },
                    success: function(res) {
//                        alert(res);
                      $('#div_userinfo').css('display', 'block');
                      $('#div_userinfo').empty();
                      $('#div_userinfo').html(res);
                      
                      if(user_group==4)
                        {
                            $('#userinfo_lbl').text('Student Info');
                            $('#div_userinfo_select #userinfo').val(userinfo);


                        }
                        else{
                            $('#userinfo_lbl').text('Employee Info');
                            $('#div_userinfo_select #userinfo').val(userinfo);

                        }
//                        $('select').select2({width:'100%',theme: "classic"});
                      $('#add_user').modal('show');
                      
                    },
                    error: function(req, status){
                        alert(req);
                        return false;
                    }
            });
    }



    $("#upload_type").change(function () {

        if ($(this).val() == 1)
        {
            var html = '';
            html += '<div class="form-group">';
            html += '<div class="col-sm-3"></div>';
            html += '<div class="col-sm-6"><input class="form-control" size="50" type="file" name="admn_file_upload"></div>';
            html += '<div class="col-sm-3"></div>';
            html += '</div>';
            $('#user_grp2').show();
            $('#user_grp1').hide();
            $('#user_grp1').html('');
            $('#user_grp2').html(html);
            $('#txt').text('Upload');
            $('#btn_add_user').removeClass('btn-primary');
            $('#btn_add_user').addClass('btn-success');
        } else
        {
            $('#user_grp2').hide();
            $('#user_grp1').show();
            $('#txt').text('Add user');
            $('#btn_add_user').removeClass('btn-success');
            $('#btn_add_user').addClass('btn-primary');
        }

    });



/*----------------- duplicate user check -------------------*/
    $("#user_name").on('change', function (e) {

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url('settings/users/check_user'); ?>',
            data: {
                user: $(this).val(),
                school_code:$('#school_code').val()

            },
            success: function (res)
            {
//                alert(res);

                if (res >= 1) {

                    alert('User  already registered Try another');
                    $('#btn_add_user').attr('disabled',true);
                    $('#user_name').focus();
                    $('#user_name').css("border", "1px solid red");

                }
                else{
                    $('#btn_add_user').attr('disabled',false);
                    $('#user_name').css("border-color", "#d2d6de");
                }
            },
            error: function (req, status) {
                alert('error');
            }
        });


    });
/*-----------------------------------------------------------------*/




    function edit_user(me,id,sch_code,user_name,student_id,employee_id ,contact_no, email = '', user_group_id)
    {
 
        $('#myModalLabel').text('Update User');
        $('#school_code').val(sch_code+'-');        
        $('#user_name').val(user_name);
        $('#contact_no').val(contact_no);
        $('#email').val(email);
        $('#edit_user_id').val(id);
        $('#user_group').val(user_group_id).prop('selected', true).trigger('change');
        $('#add_user_form').attr('action', '<?php echo base_url('settings/users/edit_user'); ?>');
        
        if(user_group_id==4){            
            var userinfo=student_id;
        } else{
            var userinfo=employee_id;
        }

        if(sch_code!='@') {
            
                $('#div_userinfo').css('display', 'block');
                var session_group_id ='<?php echo $user_grp_id;?>';
                if(session_group_id==1) {
                    
                    $('#select_school').css('display', 'block');
                    $("#school option[data-attr1="+sch_code+"]").attr('selected', true);
                   
                    var school_id=$('#school_select').val();
                } else{
                    var school_id=session_group_id;
                }
                get_userinfo(user_group_id,school_id,userinfo);
           
        } else{
            $('#div_userinfo').css('display', 'none');
            $('#add_user').modal('show');
        }

        $('#div_pwd').empty();
        $('#div_cnfrm_pwd').empty();
        
    }


    function delete_user(id,grp_id, desc)
    {
        $('#delete_user_id').val(id);
        $('#delete_user_group').val(grp_id);
        $('#delete_school').val($('#school_select').val());
        $('#del_user_name').text(desc);
        $('#delete_user').modal('show');
    }

    function change_user_pwd(id, grp_id, name)
    {
        $('#change_user_id').val(id);
        $('#change_user_group').val(grp_id);
        $('#change_school').val($('#school_select').val());
        $('#change_pwd_user_name').text(name);
        $('#change_password_model').modal('show');

    }


</script>
