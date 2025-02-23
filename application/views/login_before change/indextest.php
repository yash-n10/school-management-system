<!doctype html>
<html class="no-js" lang="zxx">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <?php include 'application/views/includes.php';?>
  <title><?php echo $page_title; ?></title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Favicons -->
  <link rel="shortcut icon" href="images/favicon.ico">
  <link rel="apple-touch-icon" href="images/icon.png">
  <link href="https://fonts.googleapis.com/css?family=Dosis:400,500,600,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">


  <!-- Stylesheets -->
  <link rel="stylesheet" href="<?php echo base_url(''); ?>/assets/login/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(''); ?>/assets/login/css/plugins.css">
  <link rel="stylesheet" href="<?php echo base_url(''); ?>/assets/login/css/style.css">
  <link rel="stylesheet" href="<?php echo base_url(''); ?>/assets/login/css/custom.css">
  <script src="<?php echo base_url(''); ?>/assets/login/js/vendor/modernizr-3.5.0.min.js"></script>
  <style type="text/css">
  .accountbox-wrapper.is-visible .body-overlay, .login-wrapper.is-visible .body-overlay {
    opacity: 0;
    visibility: visible;
    z-index: 21;
  }
  .accountbox {
    left: 22%;
    top: 55%;
  }
  .accountbox-wrapper.is-visible .accountbox, .login-wrapper.is-visible .accountbox {
    -webkit-transform: translate(-50%, -50%);
    -moz-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    -o-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    opacity: 0.8;
    visibility: visible;
  }
  .accountbox-wrapper.is-visible .body-overlay, .login-wrapper.is-visible .body-overlay {
    opacity: 0.2;
    visibility: visible;
    z-index: 21;
  }
.fullscreen {
    min-height: 100vh;
    width: 100%;
}
</style>
<meta name="google-site-verification" content="ncnGjkUWopz3Vu6e4Db46Bq7cSyBjV-lwqTx0TTUZlk" />

<!-- Global site tag (gtag.js) - Google Analytics starts-->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-134467486-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-134467486-1');
</script>
<!-- Global site tag (gtag.js) - Google Analytics ends-->

<!-- Adsense Auto-Ads starts here-->
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
 (adsbygoogle = window.adsbygoogle || []).push({
  google_ad_client: "ca-pub-9085674872653712",
  enable_page_level_ads: true
});
</script>
<!-- Adsense Auto-Ads endss here -->
<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
      'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '1515071985294916');
    fbq('track', 'PageView');
  </script>
  <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=1515071985294916&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Facebook Pixel Code -->
  </head>

  <body style="background-image: url(<?php echo base_url();?>assets/login/images/1.png); background-repeat: no-repeat;">
  <!-- Main wrapper -->
  <div class="wrapper" id="wrapper">
    <!-- Header -->
    <header id="header" class="jnr__header header--one clearfix">
      <!-- Start Mainmenu Area -->
      <div class="mainmenu__wrapper bg__cat--1 poss-relative header_top_line sticky__header">
        <div class="container">
          <div class="row d-none d-lg-flex">
            <div class="col-sm-4 col-md-6 col-lg-2 order-1 order-lg-1">
              <div class="logo">
                <a href="http://mildtrix.com" target="_blank">
                  <img class="login-box" src="<?php echo base_url(); ?>template/images/fclogo.png">
                </a>
              </div>
            </div>
            <div class="col-sm-4 col-md-2 col-lg-9 order-3 order-lg-2">
              <div class="mainmenu__wrap">
                <nav class="mainmenu__nav">
                  <ul class="mainmenu">
                    <li class="drop"><a href="https://www.mildtrix.com/" target="_blank">MILDTRIX</a></li>
                    <li><a href="#">CONTACT</a></li>
                  </ul>
                </nav>
              </div>
            </div>

          </div>
          <!-- Mobile Menu -->
          <div class="mobile-menu d-block d-lg-none">
            <div class="logo">
             <a href="http://mildtrix.com" target="_blank">
              <img class="login-box" src="<?php echo base_url(); ?>template/images/fclogo.png" width="90%">
            </a>
          </div>

        </div>
        <!-- Mobile Menu -->
      </div>
    </div>
    <!-- End Mainmenu Area -->
  </header>
   <div class="container">
    <div class="row">
            <div class="col-sm">
               <div class="accountbox">
                  <div class="accountbox__inner">
                      <h4>Login to Continue</h4>
                      <div class="accountbox__login">
                          <div class='col-xs-12'>
                              <p style="color:red;margin-left:50px;" id='error_msg'><?php echo $msg; ?></p>
                          </div> 
                          <form action="<?php echo base_url("login/submitLogin") ?>" method="post">
                              <div class="single-input">
                                  <input ttype="text" name="username" placeholder="Username   e.g(  SchoolCode-AdmissionNo  )">
                              </div>
                              <div class="single-input">
                                  <input type="password" name="password" class="form-control" placeholder="Password">
                              </div>
                              <div class="single-input">
                                  <p> <input type="checkbox" name="chkRememberme" id="chkRememberme" style="width:20px;height:16px;"> Remember Me
                                   <button type="submit" class="dcare__btn">Sign In</button></p>
                               </div>
                           </form>
                       </div>                                    
                   </div>                                  
                </div>
            </div>
            <div class="col-sm logo">
              <!-- One of three columns -->
            </div>
            <div class="col-sm">
              <!-- One of three columns -->
            </div>
          </div>
        </div>   
  </div>

<!-- //Header -->
<!-- Strat Slider Area -->
<!-- <div class="slide__carosel owl-carousel owl-theme"> -->
  
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
        <div class="modal fade" id="newmodal" role="dialog" style="top:100px;">
          <div class="modal-dialog ">
            <div class="modal-content" style="font-family: 'poppins', sans-serif; ">
              <div class="modal-header" style="background-color: red">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" style="color:white; text-align:center;">IMPORTANT NOTICE (आवश्यक सूचना)</h4>
              </div>
              <div class="modal-body">
                <div>
                  <p style="text-align: center;font-weight: 600;"><u>Just Released a new <b style="color:green">FEESCLUB APP </b> on<br> Google play store.</u></p>
                  <p style="text-align: center;font-weight: 500;">Please uninstall old <b style="color:red">"Feesclub Fee"</b> app and Download New <b style="color:green">"Feesclub"  </b> app  now. <br>
                    <br>कृपया  ओल्ड <b style="color:red">"Feesclub Fee"</b> app को uninstall करे और नया <b style="color:green">"Feesclub"  </b> app डाउनलोड कर लीजिये |</p>
                  </div>
                  <div style="padding:5px">
                    <center><a href="https://play.google.com/store/apps/details?id=com.feesclub.erp.feesclubfee" target="_blank" type="button" class="btn btn-success">DOWNLOAD NOW</a>&nbsp;&nbsp;<a style="padding:5px;" data-dismiss="modal" target="_blank" type="button" class="btn btn-warning dnd">&#10004; DONE<small>(Don't show again)</small></a></center>
                  </div>
                </div>

                <div class="modal-footer" style="background-color: red; padding: 2px;">
                  <!--<center><a href="https://play.google.com/store/apps/details?id=com.feesclub.erp.feesclubfee" target="_blank" type="button" class="btn btn-success">Download Now</a></center>-->
                </div>
              </div>
            </div>
          </div>


                        <script>
             //console.log("Hello amit");
             $(document).ready(function() {


              if ($.cookie("no_thanks") == null) {


                $('#newmodal').appendTo("body");
                function show_modal(){
                  $('#newmodal').modal();
                  //console.log("showing");
                }


                window.setTimeout(show_modal, 3000);
              }

              $(".dnd").click(function() {
                document.cookie = "no_thanks=true; expires=Fri, 31 Dec 9999 23:59:59 UTC";
                //console.log("cookie set!");
              });
            });

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

<!-- JS Files -->
<script src="<?php echo base_url(''); ?>/assets/login/js/vendor/jquery-3.2.1.min.js"></script>
<script src="<?php echo base_url(''); ?>/assets/login/js/popper.min.js"></script>
<script src="<?php echo base_url(''); ?>/assets/login/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(''); ?>/assets/login/js/plugins.js"></script>
<script src="<?php echo base_url(''); ?>/assets/login/js/active.js"></script>
</body>
</html>
