<!DOCTYPE html>
<html lang="en" class="no-js">
    <head>
        <title>FeesClub ERP Login</title>
        <style>
            body.login .box-login, body.login .box-forgot, body.login .box-register {
                background-image: url("<?php echo base_url('') ?>imgco/2.jpg");
                border-radius: 5px;
                box-shadow: -30px 30px 50px rgba(0, 0, 0, 0.32);
                overflow: hidden;
                padding: 0px 0px 15px 0px;

            }
        </style>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta content="" name="description" />
        <meta content="" name="author" />
        <link rel="stylesheet" href="<?php echo base_url('') ?>assetsco/plugins/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url('') ?>assetsco/fonts/style.css">
        <link rel="stylesheet" href="<?php echo base_url('') ?>assetsco/css/main.css">
        <link rel="stylesheet" href="<?php echo base_url('') ?>assetsco/css/main-responsive.css">
        <link rel="stylesheet" href="<?php echo base_url('') ?>assetsco/ryz.css">
    </head>
    <body class="login example2">
        <div class="main-login col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-3">
            <img src = "<?php echo base_url('') ?>/imgco/girl.png" class = "fc_girl" />

            <div class="box-login login-heading-animate project-images" style="display: block;">
                <div class="col-md-6 fc_norm_text">				
                    <br />				
                    <p>
                        <i class="fa fa-key faa-pulse animated fa-1x"></i> Enter Admission Number for Vivek Vidyalaya Student
                    </p>
                    <form method="post" action="<?php echo e(base_url('vvlogin/submit')); ?>">
                        <div class="form-group" id="frg_em">
                            <span class="input-icon">
                                <input required="" maxlength="20" type="text" class="form-control limited" name="adm_no" placeholder="Admission Number">
                                <i class="fa fa-user"></i> 
                            </span>
                        </div>
                        <input type="hidden" value="STD" name="Ltype" class="frg" checked="">
                        <div class="form-actions">
                             <a href="http://vivekvidyalayajsr.org/fee-instruction.php" class="btn btn-light-grey go-back">
                            <i class="fa fa-circle-arrow-left"></i> Back
                            </a> 
                            <button id="frg_sub" name="vv_pay_submit" type="submit" class="btn btn-bricky pull-right">
                                Submit <i class="fa fa-arrow-circle-right"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>	
            <div class="copyright" style = "color:lime;background: #000;border-radius:5px;margin:5px 0;padding: 5px 15px;">
                <?php echo date('Y'); ?> &copy; MildTrix Business Solution. <br />Design and Developed By MildTrix Software Team.
            </div>
        </div>
    </body>
</html>