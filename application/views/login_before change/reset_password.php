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

<body class="hold-transition login-page" style="background: #70e1f5;  /* fallback for old browsers */
      background: -webkit-linear-gradient(to bottom, #ffd194, #70e1f5);  /* Chrome 10-25, Safari 5.1-6 */
      background: linear-gradient(to bottom, #ffd194, #70e1f5); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
      /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
      background-size:cover;margin:0px;padding: 0px;
      ">
    <div class="login-box">
        <div class="login-logo">
            <img class="login-box" src="<?php echo base_url(); ?>template/images/FeesClub_logo.png">
        </div>
        <div class="login-box-body" style="box-shadow:inset 0 34px rgba(255,255,255,0.2), inset 0 -6px 96px rgba(0,0,0,0.3), 0 4px 40px rgba(0,0,0,0.5);">
            <p class="login-box-msg" style="font-family:cursive;font-weight:bold">Reset Password?</p>
            <form role="form" method="POST" action="<?php echo base_url("Recreate_password/send_otp") ?>" name="reset_form">
                <div class="form-group">
                    <label for="user_name">User Name </label> 
                    <input type="text" class="form-control col-sm" name="user_name" required="" id="user_name"  placeholder="User Name" value="" autofocus>
                </div>

                <div class="form-group">
                    <label for="Captcha" name=""> Captcha </label> <?php echo $cap['image']; ?>
                    <input type="text" id="captcha" class="form-control" name="captcha" id="captcha" placeholder="Enter the captcha shown" value=""  required="" autofocus style="margin-top:10px;">
                </div>
                <div class="form-group" style="height:auto">

                    <div class="col-xs-6">
                        <a style="font-family: Source Sans Pro,sans-serif;font-weight:bold;text-decoration:underline" id="trymethod" href="#">Try another method?</a>
                
                    </div>
                    <div class="col-xs-6">
                    <button type="button" name="send_otp" id="send_otp" class="btn btn-primary btn-block btn-flat" id="send_otp" style="border-radius: 60px" disabled="true"> Send Email </button>
                
                    </div>
                </div>
                


            </form>
            <div class="form-group" style="padding-top: 2%;margin-top: 2%">
                    <p class="login-box-msg" style="font-family:cursive;font-weight:bold;padding-bottom:3%"> <a style="color:#0baf91;font-family: Source Sans Pro,sans-serif;font-weight:bold;text-decoration:underline" href="<?php echo base_url('login') ?>">Click here to Login</a></p>
                </div>
        </div>
        <!--    <div >
        <h4 style="text-align:center;"><a style="color:#0baf91; text-align:center" href="<?php // echo base_url('login') ?>">Click here to Login</a></h4>
        </div>-->
    </div>
            <!-- jQuery 3 -->
        <script src="<?php echo base_url(''); ?>/assets/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="<?php echo base_url(''); ?>/assets/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="<?php echo base_url(''); ?>/assets/AdminLTE/plugins/iCheck/icheck.min.js"></script>

    <script>
    var gen_val ='<?php echo $cap['word']; ?>';
    
    $('#user_name').change(function(){
        var str=$('#user_name').val();
        if(str.indexOf('-') == -1){
            alert('Username is Invalid');
            $('#send_otp').attr('disabled',true);
        } else{
            $('#send_otp').attr('disabled',false);
        }
    });
    
    $("#send_otp").click(function () {
        

            if (!$('form')[0].checkValidity())
            {
//                                                alert($('#add_stud_frm')[0].validationMessage);
                $(this).show();
                $('form')[0].reportValidity();
                return false;
            } else {
                var str=$('#user_name').val();
//                if(str.indexOf('-') ==-1){
//                        alert(str.indexOf('-'));
//                    }
                if ($("#captcha").val() == gen_val)
                {
                    
//                    window.location.href = "<?php // echo base_url('Recreate_password/send_otp') ?>";
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url('Recreate_password/send_otp'); ?>',
                        data:$('form').serialize(),
                        success: function (res)
                        {
                            alert(res);
//                            $('#div_city').html(res);
//                            $('#div_city').css("display", "block");
                        },
                        error: function (req, status) {
                            return false;
                        }
                    });
                }
                else
                {
                    alert('Invalid Captcha');
                   
//                    window.location.href = "<?php // echo base_url('Recreate_password/reset_password') ?>";
                }
            }
        

    });
    
    $('#trymethod').click(function(e){
    e.preventDefault();
            $('form').empty();
            $('form').html(
                '<div class="form-group"><p style="color:blue;text-align: center;margin:0px;padding-top:3%"> Please Contact us on  : <span style="font-weight:bold;color:black;text-align: center"> 0651-2543964 / 8580205490 </span></p></div>\n\
                <div class="form-group"><p class="login-box-msg" style="font-family:cursive;font-weight:bold;padding-bottom:3%"> <a style="color:font-family: Source Sans Pro,sans-serif;font-weight:bold;text-decoration:underline" href="<?php echo base_url('Recreate_password/reset_password') ?>">Back To Password Reset</a></p></div>'    
                )
    });

</script>
</body>
</html>
