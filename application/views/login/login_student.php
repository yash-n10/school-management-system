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
            <div class="login-box-body">
                <p class="login-box-msg">Please login using the username and password given below.</p>

                <form role="form" method="POST" action="<?php echo base_url("login/submitLogin") ?>">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo $username; ?>" autofocus>
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" name="password" placeholder="Password" value="<?php echo $password; ?>">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8" style="color:red">
                            Username: <?php echo $username; ?><br/>
                            Password: <?php echo $password; ?>
                        </div>
                        <div class="col-xs-4">
                            <button type="submit" name="submit_login" class="btn btn-primary btn-block btn-flat">Login</button>
                        </div>
                    </div>
                    <a href="<?php echo base_url('register') ?>">Register as Student</a><br>
                </form>
            </div>
        </div>
        <!-- jQuery 3 -->
    <script src="<?php echo base_url(''); ?>/assets/AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="<?php echo base_url(''); ?>/assets/AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="<?php echo base_url(''); ?>/assets/AdminLTE/plugins/iCheck/icheck.min.js"></script>
    </body>
</html>

