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
           <h5 class="centered">Admin</h5>

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
              <i class="fa fa-book"></i>
              <span>Administrasi Akademik</span>
            </a>
            <ul class="sub">
              <li><a  href="<?=base_url('siswas')?>">Data siswa</a></li>
              <li><a  href="<?=base_url('batchinput/do_upload/data')?>">Input Data siswa</a></li>
              <li><a  href="<?=base_url('gurus')?>">Data Guru</a></li>
              <li><a  href="<?=base_url('mapels')?>">Data Mata Pelajaran</a></li>
              <li><a  href="<?=base_url('kelas')?>">Data Kelas siswa</a></li>
              <li><a  href="<?=base_url('pengampu')?>">Data Guru Pengampu</a></li>
              <li><a  href="<?=base_url('nilai')?>">Data Nilai siswa </a></li>
              <li><a  href="<?=base_url('jadwals')?>">Jadwal</a></li>
              <li><a  href="<?=base_url('tahunajaran')?>">Tahun Ajaran</a></li>
            </ul>
          </li>

          <li class="sub-menu">
            <a href="javascript:;" >
              <i class="fa fa-desktop"></i>
              <span>Administrasi Sistem</span>
            </a>
            <ul class="sub">
              <li>
	            <a href="javascript:;" >
	              <i class="fa fa-newspaper-o"></i>
	              <span>Berita</span>
	            </a>
	            <ul class="sub">
	              <li><a  href="<?=base_url('users/manageUser')?>">Tambah Berita</a></li>
	            </ul>
	             <ul class="sub">
	              <li><a  href="<?=base_url('users/manageUser')?>">Lihat Daftar Berita</a></li>
	            </ul>
	          </li>
	          <li><a  href="<?=base_url('users/manageUser')?>">Category</a></li>
	          <li>
	            <a href="javascript:;" >
	              <i class="fa fa-file-o"></i>
	              <span>Laman</span>
	            </a>
	            <ul class="sub">
	              <li><a  href="<?=base_url('users/manageUser')?>">Tambah Laman</a></li>
	            </ul>
	             <ul class="sub">
	              <li><a  href="<?=base_url('users/manageUser')?>">Lihat Daftar Laman</a></li>
	            </ul>
	          </li>
	          <li>
	            <a href="javascript:;" >
	              <i class="fa fa-calendar"></i>
	              <span>Event</span>
	            </a>
	            <ul class="sub">
	              <li><a  href="<?=base_url('users/manageUser')?>">Tambah Event</a></li>
	            </ul>
	             <ul class="sub">
	              <li><a  href="<?=base_url('users/manageUser')?>">Lihat Daftar Event</a></li>
	            </ul>
	          </li>
              <li><a  href="<?=base_url('users/manageUser')?>">Laman Muka</a></li>
              <li><a  href="<?=base_url('users/manageUser')?>">Daftar Data User</a></li>
              <li><a  href="<?=base_url('logs/showLog')?>">Log Sistem</a></li>
            </ul>
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