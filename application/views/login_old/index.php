<!DOCTYPE html>
<html style="height:auto ;min-height:100%;margin:0px;padding:0px">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <?php include 'application/views/includes.php';?>
        <title><?php echo $page_title; ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="<?php echo base_url(''); ?>/assets/AdminLTE/bower_components/bootstrap/dist/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?php echo base_url(''); ?>/assets/AdminLTE/bower_components/font-awesome/css/font-awesome.min.css">
                <link rel="stylesheet" href="<?php echo base_url(''); ?>/assets/AdminLTE/bower_components/font-awesome/css/font-awesome-animation.min.css">
        <link rel="stylesheet" href="<?php echo base_url(''); ?>/assets/AdminLTE/bower_components/select2/dist/css/select2.min.css">
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
            }
/*            .has-feedback label~.form-control-feedback {
    padding-top: 10px;
}*/
        </style>
    </head>
    <body class="hold-transition login-page" style="background: #70e1f5;  /* fallback for old browsers */
          background: -webkit-linear-gradient(to bottom, #ffd194, #70e1f5);  /* Chrome 10-25, Safari 5.1-6 */
          background: linear-gradient(to bottom, #ffd194, #70e1f5); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
          /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
          background-size:cover;margin:0px;width:100%;padding:0px
          ">

        <div class="login-box" >
            <div class="login-logo">
                <a href="http://mildtrix.com">
                <img class="login-box" src="<?php echo base_url(); ?>template/images/FeesClub_logo.png">
                
                </a>
                <!--<p>You value your time - infact we all do</p>-->
            </div>
            <div class="login-box-body" style="box-shadow:inset 0 34px rgba(255,255,255,0.2), inset 0 -6px 96px rgba(0,0,0,0.3), 0 4px 40px rgba(0,0,0,0.5);">
                <p class="login-box-msg" style="font-family:cursive;font-weight:bold">Already Have an Account?  </p>
                <div class='row'>
                    <div class='col-xs-12'>
                        <p style="color:red;margin-left:50px;" id='error_msg'><?php echo $msg; ?></p>
<!--                        <label style="color:brown;font-size: 14px;text-align: center;font-weight:bold">
                            NOTE : <span style="font-size: 13px;text-align: center;font-stretch:semi-expanded">  Student's Username e.g ( SchoolCode - 11545 )<br>
                                <a id="getschoolcode"> <i class="fa fa-play faa-horizontal animated"> </i>  GET SCHOOL CODE</a></span>
                        </label>-->
                    </div> 
                </div>
                <form action="<?php echo base_url("login/submitLogin") ?>" method="post">
                    <div class="form-group has-feedback" style="border-bottom: 1px solid cornflowerblue;">
                        
                        <input type="username" name="username" class="form-control" placeholder="Username   e.g(  SchoolCode-AdmissionNo  )" >
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback" style="border-bottom: 1px solid cornflowerblue;">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <div class="checkbox icheck">
                                <label>
                                    <input type="checkbox" name="chkRememberme" id="chkRememberme"> Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat" style="border-radius: 60px;">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>

                </form>
                <p style='text-align: center'><a style="text-align:center;font-weight:bold" href="<?php echo base_url('Recreate_password/reset_password') ?>">Forgot password?</a></p>
                <div class="row" style="border-top: 1px dashed grey;padding-top:2%;margin-top: 2%">
                    <div class="col-xs-12" style='text-align: center'>
                        <p class="login-box-msg" style="font-family:cursive;font-weight:bold;padding-bottom:3%">Don't Have any Account?</p>
                        <h5><a style="color:#0baf91;font-weight:bold;text-decoration:underline" href="<?php echo base_url('register') ?>">Click here to Register as Student</a></h5>

                    </div>
                </div>
                <!--<p style="color:blue;text-align: center;margin:0px;padding-top:3%"> Helpdesk No  : <span style="font-weight:bold;color:black;;text-align: center"> 1.) 0651-2543964 (9 AM to 6PM)  2.)7209524047 </span></p>-->
                <!--<p style="color:blue;text-align: center;margin:0px;padding-top:3%"> Helpdesk No  <i class="fa fa-lg fa-phone" aria-hidden="true"></i> : <span style="font-weight:bold;color:black;;text-align: center"> 8578063164 / 7361815861 </span></p>-->
                <p style="color:blue;text-align: center;margin:0px;padding-top:3%"> Helpdesk No  <i class="fa fa-lg fa-phone" aria-hidden="true"></i> : <span style="font-weight:bold;color:black;;text-align: center"> 0651-2543964 / 8580205490 </span></p>
                <!--<p style="color:darkgreen;text-align: center;margin:0px;padding-top:3%"> <span style="color:blue">Whatsapp On </span> <i class="fa fa-lg fa-whatsapp" aria-hidden="true"></i> : <span style="font-weight:bold;color:black;;text-align: center"> 8578063164 / 7361815861 </span></p>            </div>-->
                <p style="color:darkgreen;text-align: center;margin:0px;padding-top:3%"> <span style="color:blue">Whatsapp On </span> <i class="fa fa-lg fa-whatsapp" aria-hidden="true"></i> : <span style="font-weight:bold;color:black;;text-align: center"> 7209524047 </span></p>            </div>
        </div>
        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog modal-sm">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">School Code</h4>
                </div>
                <div class="modal-body">
                    <select class="form-control" id="sch" style="width:100%">
                        <option>Search Your School</option>
                        <?php foreach($schools as $r) {?>
                        <option value="<?php echo $r->school_code?>"><?php echo $r->description?></option>
                        <?php }?>
                    </select>
                    <input id="schcode" type="text" class="form-control" style="color:red">
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
        </div>

        <!-- jQuery 3 -->
        <script src="<?php echo base_url(''); ?>/assets/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
        <!-- Bootstrap 3.3.7 -->
        <script src="<?php echo base_url(''); ?>/assets/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(''); ?>/assets/AdminLTE/bower_components/select2/dist/js/select2.min.js"></script>
        <!-- iCheck -->
        <script src="<?php echo base_url(''); ?>/assets/AdminLTE/plugins/iCheck/icheck.min.js"></script>
        <script>
            $(function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });

        //            $('input[type=username],'+'input[type=password]').change(function(){
        //                $('#error_msg').text('');
        //            });

            });
            $('#getschoolcode').click(function(e){
                e.preventDefault();
                $('#myModal').modal('show');
            });


             $("#sch").select2({
//                allowClear:true,
//                placeholder: 'Position'
                });
                $('#sch').change(function(){
//                    alert('hi');
                    $('#schcode').val('Your School Code is : '+this.value);
                });

        </script>
    </body>
</html>
