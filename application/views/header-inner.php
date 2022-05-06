
<?php 
  $path = base_url('assets/sports/');
?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <TITLE>REGISTER-LOGIN | TDEX</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="<?php echo isset($metaDesp)?$metaDesp:'';?>">
  <meta name="keywords" content="<?php echo isset($metaKeys)?$metaKeys:'';?>"/>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="<?=$path?>images/sports-fav.png" type="image/x-icon">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!--<script src="https://www.club699.com/assets/global/js/jquerygoogle.min.js"></script>-->
  
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="<?=$path?>css/style.css">
  <link rel="stylesheet" type="text/css" href="<?=$path?>css/responsive.css">
   <link rel="stylesheet" type="text/css" href="<?=$path?>css/sb-admin-2.css">
  <link rel="stylesheet" type="text/css" href="<?=$path?>css/sb-admin-2.min.css">
    <link rel="stylesheet" type="text/css" href="<?=$path?>css/sb-custom.css">
  
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,800,900&display=swap" rel="stylesheet">   
 
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
  <link rel="stylesheet" href="<?=$path?>css/intlTelInput.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/arab-token/css/slidercaptcha.min.css" type="text/css" />
<style>
    .sports-header-nav ul li a.active:before {content:""; width:28px; display: none;height:4px; background-color:#110180; right:0; left:0; position:absolute; margin-right:auto; margin-left:auto; bottom:-4px;}
  .ful_login:before {
    content: '';
    position: absolute;
    width: 15%;
    height: 100px;
    background: #3ab54b78;
    left: 0;
    top: 0;
    z-index: 1;
    clip-path: polygon(0 0, 0% 100%, 100% 0);
}
.slidercaptcha {
            margin: 0 auto;
            width: 314px;
            height: 286px;
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.125);
            margin-top: 40px;
            background-color: #fff !important;
        }

            .slidercaptcha .card-body {
                padding: 1rem;
            }

            .slidercaptcha canvas:first-child {
                border-radius: 4px;
                border: 1px solid #e6e8eb;
            }

            .slidercaptcha.card .card-header {
                background-image: none;
                background-color: rgba(0, 0, 0, 0.03);
                border-bottom: 0px !important;
            }

        .refreshIcon {
            top: -54px;
        }
        .login-cont_dt
        {
            display: none;
        }
</style>
</head>

<body class="login-body bg-gradient-primary" style="background: #0f1932 !important;">

    <header class="header-in">
      <div class="header-cont">
        <div class="header-top py-3 col-sm-12 p-0">
          <div class="container">
            <div class="d-flex flex-wrap align-items-center">
              <!--<aside class="col-sm-3 col-md-3 col-lg-3 header-l">-->
              <!--  <div class="sports-header-logo mx-auto">-->
                  <!--<a href="<?=base_url();?> "><img src="<?=base_url()?>assets/sports/images/logo.png" alt="logo"/></a>-->
              <!--  </div>-->
              <!--</aside>-->

              <aside class="col-sm-12 col-md-12 col-lg-12 sports-header-nav p-0">
              <nav class="navbar navbar-expand-sm navbar-dark">
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    <ul class="navbar-nav w-100" style="display: flex;justify-content: center;">
                      <li class="nav-item">
                        <a class="nav-link active" href="<?=base_url();?> " style="background: #f42f54;padding: 11px 30px;border-radius: 30px;">Home</a>
                      </li>
                 
                 
                      <!--<li class="nav-item">-->
                      <!--  <a class="nav-link" href="<?=base_url();?>#">About Us</a>-->
                      <!--</li>-->
                      <!--<li class="nav-item">-->
                      <!--  <a class="nav-link" href="<?=base_url();?>#">Product</a>-->
                      <!--</li>-->
                      <!--<li class="nav-item">-->
                      <!--  <a class="nav-link" href="<?=base_url();?>#">Package</a>-->
                      <!--</li>  -->
                      <!--<li class="nav-item">-->
                      <!--  <a class="nav-link" href="<?=base_url();?>#">Contact Us</a>-->
                      <!--</li>    -->
                    </ul>
                  </div> 
              </nav>
              </aside>
            </div>
          </div>
        </div>

      </div>
  </header>
  <!-- ========= END HEADER =========-->  
