<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Sistem Informasi Akademik MTs Taqwal Ilah</title>

    <!-- Bootstrap core CSS -->
    <link href="<?=base_url('assets/css/bootstrap.css')?>" rel="stylesheet">
    <!--external css-->
    <link href="<?=base_url('assets/font-awesome/css/font-awesome.css')?>" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/zabuto_calendar.css')?>">
    <link rel="stylesheet" type="text/css" href="<?=base_url('assets/js/gritter/css/jquery.gritter.css')?>" />
    <link rel="stylesheet" type="text/css" href="<?=base_url('assets/lineicons/style.css')?>">    
    
    <!-- Custom styles for this template -->
    <link href="<?=base_url('assets/css/style.css')?>" rel="stylesheet">
    <link href="<?=base_url('assets/css/style-responsive.css')?>" rel="stylesheet">

    
    
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
      <!--header start-->
      <header class="header black-bg">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
              </div>
            <!--logo start-->
            <a href="" class="logo"><b>Sistem Informasi Akademik</b>
            <!--logo end-->
            
            <div class="top-menu">
              <ul class="nav pull-right top-menu">
                    <li><a class="logout" href="<?=base_url('users/logout')?>">Keluar</a></li>
              </ul>
            </div>
        </header>
      <!--header end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
              
                  <p class="centered"><a href=""><img src="<?=base_url('assets/img/ui-sam.jpg')?>" class="img-circle" width="60"></a></p>
                  <h5 class="centered">Yayasan</h5>
                    
                  <li class="sub-menu">
                      <a  href="">
                          <i class="fa fa-home"></i>
                          <span>Beranda</span>
                      </a>
                      <ul class="sub">
                          <li><a  href="<?=base_url('IsiBeranda/showProfil')?>">Profil</a></li>
                          <li><a  href="<?=base_url('IsiBeranda/showTentang')?>">Tentang</a></li>
                          <li><a  href="<?=base_url('IsiBeranda/showBantuan')?>">Bantuan</a></li>
                       </ul>
                  </li>
                  <li class="sub-menu">
                      <a class="active" href="javascript:;" >
                          <i class="fa fa-dashboard"></i>
                          <span>Laporan Akademik</span>
                      </a>
                      <ul class ="sub" >
                          <li><a  href="<?=base_url('nilai')?>">Nilai Siswa</a></li>
                          <li><a  href="<?=base_url('charts')?>">Diagram Nilai Siswa</a></li>
                      </ul>
                  </li>
                  <li class="sub-menu">
                      <a href="http://localhost/simo" >
                          <i class="fa fa-th"></i>
                          <span>Simopresmik</span>
                      </a>
                  </li>
                  <li class="sub-menu">
                    <a href="<?=base_url('users/ubahPassword')?>" >
                      <i class="fa fa-desktop"></i>
                      <span>Ubah Password</span>
                    </a>
                  </li>
              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
                <section class="wrapper">