<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Dashboard">
  <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

  <title>Sistem Informasi Akademik SMA Mardisiswa</title>

  <link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/jquery.domenu-0.95.77.css')?>"/>
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css"/>
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.2.0/styles/github.min.css"/>
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

  <script src="<?=base_url('assets/js/jquery.js')?>"></script>  

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

           <li class="sub">
            <a  href="">
              <i class="fa fa-home" href="<?=base_url('users/home')?>"></i>
              <span>Beranda</span>
            </a>

          <li class="sub-menu">
            <a class="active" href="javascript:;" >
              <i class="fa fa-book"></i>
              <span>Adminisntrasi Akademik</span>
            </a>
            <ul class="sub">
              <li><a  href="<?=base_url('siswas')?>">Data siswa</a></li>
              <li><a  href="<?=base_url('batchinput/do_upload/data')?>">Input Data siswa</a></li>
              <li><a  href="<?=base_url('gurus')?>">Data Guru</a></li>
              <li><a  href="<?=base_url('mapels')?>">Data Mata Pelajaran</a></li>
              <li><a  href="<?=base_url('mapels/seleksiMapel')?>">Seleksi Mata Pelajaran</a></li>
              <li><a  href="<?=base_url('mapels/seleksiMapelUN')?>">Seleksi Mapel UN</a></li>
              <li><a  href="<?=base_url('kelas')?>">Data Kelas siswa</a></li>
              <li><a  href="<?=base_url('pengampu/pilihKelas')?>">Data Pengampu</a></li>
              <li><a  href="<?=base_url('nilai')?>">Data Nilai siswa </a></li>
              <li><a  href="<?=base_url('tahunajaran')?>">Tahun Ajaran</a></li>
            </ul>
          </li>

          <li class="sub-menu">
            <a href="javascript:;" >
              <i class="fa fa-book"></i>
              <span>Adminisntrasi Kelulusan</span>
            </a>
            <ul class="sub">
              <li><a  href="<?=base_url('siswas/menuKelulusan/')?>">Menu kelulusan</a></li>
              <li><a  href="<?=base_url('tahunajaran/bukaSKHU')?>">Set Tanggal SKHU</a></li>
              <li><a  href="<?=base_url('siswas/menuBatalKelulusan')?>">Pembatalan Kelulusan</a></li>
            </ul>
          </li>

          <li class="sub-menu">
            <a href="javascript:;" >
              <i class="fa fa-book"></i>
              <span>Adminisntrasi Ujian</span>
            </a>
            <ul class="sub">
              <li><a  href="<?=base_url('nilai/isiKartu')?>">Upload Data Kartu</a></li>
              <li><a  href="<?=base_url('tahunajaran/setTanggal')?>">Set Tanggal Download Kartu</a></li>
            </ul>
          </li>

          <li class="sub-menu">
            <a href="javascript:;" >
              <i class="fa fa-desktop"></i>
              <span>Adminisntrasi Sistem</span>
            </a>
            <ul class="sub">
              <li>
	            <a href="<?=base_url('konten/manageNews')?>" >
	              <i class="fa fa-newspaper-o"></i>
	              <span>Berita</span>
	            </a>
	          </li>
	          <li><a  href="<?=base_url('konten/manageCategory')?>">Category</a></li>
	          <li>
	            <a href="<?=base_url('konten/managePage')?>">
	              <i class="fa fa-file-o"></i>
	              <span>Laman</span>
	            </a>
	          </li>
	          <li>
	            <a href="<?=base_url('konten/manageEvent')?>">
	              <i class="fa fa-calendar"></i>
	              <span>Event</span>
	            </a>
	          </li>
	           <li>
	            <a href="<?=base_url('konten/manageGallery')?>">
	              <i class="fa fa-picture-o"></i>
	              <span>Galeri</span>
	            </a>
	          </li>
	          <li>
	            <a href="<?=base_url('konten/manageMenu')?>">
	              <i class="fa fa-list-alt"></i>
	              <span>Menu</span>
	            </a>
	          </li>
	          <li class="sub-menu">
	            <a href="">
	              <i class="fa fa-picture-o"></i>
	              <span>Front Page</span>
	            </a>
	            <ul class="sub">
	            	 <li>
			            <a href="<?=base_url('konten/manageSlider')?>">
			              <i class="fa fa-picture-o"></i>
			              <span>Slider</span>
			            </a>
			         </li>
			         <li>
			            <a href="<?=base_url('konten/managePartner')?>">
			              <i class="fa fa-picture-o"></i>
			              <span>Partner</span>
			            </a>
			         </li>
			          <li>
			            <a href="<?=base_url('konten/manageSambutan')?>">
			              <i class="fa fa-info-circle"></i>
			              <span>Sambutan</span>
			            </a>
			         </li>
			         <li>
			            <a href="<?=base_url('konten/manageTesti')?>">
			              <i class="fa fa-commenting-o"></i>
			              <span>Testimonial Siswa</span>
			            </a>
			         </li>
			         <li>
			            <a href="<?=base_url('konten/manageLinks')?>">
			              <i class="fa fa-link"></i>
			              <span>Tautan</span>
			            </a>
			         </li>
	            </ul>
	          </li>
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