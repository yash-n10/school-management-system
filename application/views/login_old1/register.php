<html style="height:auto;margin:0px;padding:0px">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $page_title; ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="<?php echo base_url(''); ?>/assets/AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo base_url(''); ?>/assets/AdminLTE/bower_components/font-awesome/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="<?php echo base_url(''); ?>/assets/AdminLTE/bower_components/Ionicons/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url(''); ?>/assets/AdminLTE/dist/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?php echo base_url(''); ?>/assets/AdminLTE/plugins/iCheck/square/blue.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
        <style>
            .login-box{
                margin: auto;
                padding-top: 2% !important;
                padding-bottom: 5% !important;
            }
            body {
                position: relative;
                height: auto;
                min-height: 100% !important;
            }
        </style>
    </head>
    <body class="hold-transition login-page" style="
background: linear-gradient(to bottom, rgba(241, 90, 90, 0.5) 0%, rgba(255, 133, 133, 0.67) 47%, rgba(114, 179, 247, 0.53) 82%, rgba(19, 110, 207, 0.55) 100%);
          ">
        <div class="login-box">
            <div class="login-logo">
                <img class="login-box" src="<?php echo base_url(); ?>template/images/FeesClub_logo.png">
            </div>
            <div class="login-box-body" style="box-shadow:inset 0 34px rgba(255,255,255,0.2), inset 0 -6px 96px rgba(0,0,0,0.3), 0 4px 40px rgba(0,0,0,0.5);">            
                <?php
                if (isset($status)) {
                    echo '    <p class="login-box-msg">' . $status . "</p>\n";
                } else {
                    ?>
                    <p class="login-box-msg" style="font-family:cursive;font-weight:bold">New Member?</p>
                    <!--<p class="login-box-msg">Please complete the details to register.</p>-->
                    <?php
                }
                ?>
                <form role="form" method="POST" action="<?php echo base_url("register/register_student") ?>">
                    <div class="form-group" style="border-bottom: 1px solid cornflowerblue;">
                        <select class="form-control" id="school_state" name="school_state" onchange="select_city()" required> 
                            <option value="">- Select State -</option>
                            <?php foreach ($states as $state) { ?>
                                <option value="<?php echo $state->id ?>"><?php echo $state->state_name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group" id="div_city" style="display:none;border-bottom: 1px solid cornflowerblue;">
                    </div>
                    <div class="form-group" id="div_school" style="display:none;border-bottom: 1px solid cornflowerblue;">
                    </div>
                    <div class="form-group" style="border-bottom: 1px solid cornflowerblue;">
                        <input type="text" class="form-control" id="admission_no" name="admission_no" placeholder="Admission No" onchange="check_admission()" required>
                    </div>

                    <div class="form-group" style="border-bottom: 1px solid cornflowerblue;">
                        <input type="password" class="form-control" id="password" name="password" required placeholder="Password" onkeyup="password_validate();"> <span id="result"></span>
                    </div>
                    <div class="form-group" style="border-bottom: 1px solid cornflowerblue;">
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required placeholder="Confirm Password" onchange="check_password()" >
                    </div>
                    <div class="row">
                        <div class="col-xs-8" id="error_message" style="color:red"></div>
                        <div class="col-xs-4">
                            <button style="background-color:#0baf91;border-radius: 60px" type="submit" id="submit_login" name="submit_login" class="btn btn-primary btn-block btn-flat" >Register</button>
                        </div>
                    </div>

                </form>

                <div class="row" style="border-top: 1px dashed grey;padding-top:2%;margin-top: 2%">
                    <div class="col-xs-12" style='text-align: center'>
                        <p class="login-box-msg" style="font-family:cursive;font-weight:bold;padding-bottom:3%">Already Have an Account?  <a style="color:#0baf91;font-family: Source Sans Pro,sans-serif;font-weight:bold;text-decoration:underline" href="<?php echo base_url('login') ?>">LOGIN</a></p>

                        <!--                            <h5></h5>-->
                    </div>
                </div>
            </div>
        </div>


        <!-- jQuery 3 -->
        <script src="<?php echo base_url(''); ?>/assets/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="<?php echo base_url(''); ?>/assets/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="<?php echo base_url(''); ?>/assets/AdminLTE/plugins/iCheck/icheck.min.js"></script>

        <script type="text/javascript">
            function select_city()
            {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('register/select_city'); ?>',
                    data: {
                        state: $("#school_state option:selected").val()
                    },
                    success: function (res)
                    {
                        $('#div_city').html(res);
                        $('#div_city').css("display", "block");
                    },
                    error: function (req, status) {
                        return false;
                    }
                });
            }

            $(document.body).on('change', '#school_name', function ()
            {
                $("#admission_no").val('');
                $("#first_name").val('');

                $("#last_name").val('');
                $("#contact_no").val('');
                $("#email_address").val('');

                $('#admission_no').css("border-color", "#d2d6de");
                $('#first_name').css("border-color", "#d2d6de");
                $('#last_name').css("border-color", "#d2d6de");
                $('#contact_no').css("border-color", "#d2d6de");
                $('#email_address').css("border-color", "#d2d6de");

                $('#error_message').html('');
                $('#submit_login').attr('disabled', false);

                if ($("#school_name").val() == 'prospect') {
                    $('#error_message').html('Sorry, your school has not yet upgraded to FeesClub.');
                    $('#submit_login').attr('disabled', true);
                }

            });
        //$('#school_name').on('change',function(){
        //
        //
        //alert('hello');
        //
        //});
            function select_school()
            {
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('register/select_school'); ?>',
                    data: {
                        city: $("#school_city option:selected").val()
                    },
                    success: function (res) {
                        $('#div_school').html(res);
                        $('#div_school').css("display", "block");
                    },
                    error: function (req, status) {
                        return false;
                    }
                });
            }

            function check_admission()
            {

                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url('register/check_admission'); ?>',
                    data: {
                        school: $("#school_name option:selected").val(),
                        admission_no: $('#admission_no').val()
                    },
                    dataType: "text",
                    success: function (res)
                    {
                        if (res == 0)
                        {
                            $('#admission_no').css("border-color", "red");
                            $('#error_message').html('Invalid admission no.');
                            $('#submit_login').attr('disabled', true);

                        } else if (res == 1)
                        {

                            $('#admission_no').css("border-color", "red");
                            $('#error_message').html('you are already registered Pls Login');
                            $('#submit_login').attr('disabled', true);
                        } else {
                            $('#admission_no').css("border-color", "#d2d6de");
                            $('#error_message').html('');
                            $('#submit_login').attr('disabled', false);
                        }
                    },
                    error: function (req, status) {
                        return false;
                    }
                });
            }


            var strength = 0;
            function password_validate()
            {
                var password = $('#password').val();

        //initial strength
                $('#result').html('');
                $('#submit_login').attr('disabled', true);

        //if the password length is less than 8, return message. 
                if (password.length < 8)
                {
        //            alert('too short');
        //            $('#result').removeClass();
        //            $('#result').addClass('short');
                    $('#result').css('color', '#FF0000');

                    $('#result').html('Too short');
                    $('#submit_login').attr('disabled', false);

                }

        //length is ok, lets continue.

        //if length is 8 characters or more, increase strength value
                if (password.length >= 8)
                {

                    strength += 1;
        //            alert('grater 8 '+ strength);
                }

        //if password contains both lower and uppercase characters, increase strength value

                if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/))
                {
                    strength += 1;
        //            alert('uper lower '+ strength);
                }

        //if it has numbers and characters, increase strength value

                if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/))
                {
                    strength += 1;
        //            alert('uper lower '+ strength);
                }

        //if it has one special character, increase strength value 
                if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/))
                {
                    strength += 1;
        //            alert('special '+ strength);
                }

        //if it has two special characters, increase strength value
                if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,",%,&,@,#,$,^,*,?,_,~])/))
                {
                    strength += 1;
        //             alert('two special '+ strength);
                }

        //now we have calculated strength value, we can return messages
        //if value is less than 2

                if (strength < 2)
                {
        //              $('#result').removeClass();
        //              $('#result').addClass('weak');
                    $('#result').css('color', '#E66C2C');
                    $('#result').html('Weak');
        //              strength=0;
        //              return 'Weak';
                } else if (strength == 2)
                {
        //              $('#result').removeClass();
        //              $('#result').addClass('good');
                    $('#result').css('color', '#2D98F3');
        //              return 'Good';
                    $('#result').html('Good');

                } else if (strength > 8)
                {
        //              $('#result').removeClass(); 
        //              $('#result').addClass('strong');
                    $('#result').css('color', '#006400');
        //              return 'Strong';
                    $('#result').html('Strong');

                }
        //          else
        //          {
        //          }





            }


            function check_password()
            {
                var password = $('#password').val();
                var confirm_password = $('#confirm_password').val();


                if (password != confirm_password)
                {
        //                          $('#password').css("border-color","red");
                    $('#confirm_password').css("border-color", "red");
                    $('#error_message').html('Incorrect Password');
                    $('#submit_login').attr('disabled', true);
                } else
                {
                    $('#password').css("border-color", "#d2d6de");
                    $('#confirm_password').css("border-color", "#d2d6de");
                    $('#error_message').html('');
                    $('#submit_login').attr('disabled', false);


                }


            }





        //  function check_fname()
        //  {
        ////  alert($("#school_name option:selected").val());
        ////  alert($('#admission_no').val());
        ////  alert($('#first_name').val());
        //            $.ajax({
        //                type: 'POST',
        //                url: '<?php // echo base_url('register/check_fname');   ?>',
        //                data: {
        //                    school:$("#school_name option:selected").val(),
        //                    admission_no:$('#admission_no').val(),
        //                    first_name:$('#first_name').val()
        //                },
        //                success: function(res) 
        //                {
        //        //          alert(res);
        //
        //                            if(res == 0)
        //                            {
        //                                    $('#first_name').css("border-color","red");
        //                                    $('#error_message').html("you are not allowed to registered");
        //                                    $('#submit_login').attr('disabled',true);
        //                            }
        //                            else if(res == 1)
        //                            {
        //                                            $('#first_name').css("border-color","#d2d6de");
        //                                            $('#error_message').html('you are already registered Pls Login');
        //                                            $('#submit_login').attr('disabled',false);
        //                            }
        //                            else {
        //
        //                          }
        //                },
        //                error: function(req, status){
        //                    return false;
        //                }
        //            });
        //  }
        //
        //  function check_lname()
        //  {
        //    $.ajax({
        //        type: 'POST',
        //        url: '<?php // echo base_url('register/check_lname');   ?>',
        //        data: {
        //            school:$("#school_name option:selected").val(),
        //            admission_no:$('#admission_no').val(),
        //            last_name:$('#last_name').val()
        //        },
        //        success: function(res) {
        //          if(res == 0){
        ////              alert('you are not allowed to register');
        //            $('#last_name').css("border-color","red");
        //            $('#error_message').html("you are not allowed to register");
        //            $('#submit_login').attr('disabled',true);
        //          }else if(res==1){
        ////              alert('you are already registered Pls Login');
        //            $('#last_name').css("border-color","#d2d6de");
        //            $('#error_message').html('you are already registered Pls Login');
        //            $('#submit_login').attr('disabled',false);
        //          }
        //        },
        //        error: function(req, status){
        //            return false;
        //        }
        //    });
        //  }

        </script>
    </body>
</html>