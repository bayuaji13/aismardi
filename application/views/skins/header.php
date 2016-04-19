<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->  
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->  
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->  
<head>
    <title>SMA Mardisiswa - <?php echo $pageTitle;?></title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">    
    <link rel="shortcut icon" href="favicon.ico">  
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700' rel='stylesheet' type='text/css'>   
    <!-- Global CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css');?>">   
    <!-- Plugins CSS -->    
    <link rel="stylesheet" href="<?php echo base_url('assets/font-awesome/css/font-awesome.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/flexslider/flexslider.css');?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/pretty-photo/css/prettyPhoto.css');?>"> 
    <!-- Theme CSS -->  
    <link id="theme-style" rel="stylesheet" href="<?php echo base_url('assets/css/frontpage/styles.css');?>">
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head> 

<body class="home-page">
    <div class="wrapper">
        <!-- ******HEADER****** --> 
        <header class="header">  
            
            <div class="header-main container">
                <h1 class="logo col-md-4 col-sm-4">
                    <a href="<?php echo base_url();?>">Logo</a>
                </h1><!--//logo-->           
                <div class="info col-md-8 col-sm-8">
                    <br />
                    <div class="contact pull-right">
                        <p class="phone"><i class="fa fa-phone"></i>Contact 0800 123 4567</p> 
                        <p class="email"><i class="fa fa-envelope"></i><a href="#">info@smamardisiswa.sch.id</a></p>
                    </div><!--//contact-->
                </div><!--//info-->
            </div><!--//header-main-->
        </header><!--//header-->
        
        <!-- ******NAV****** -->
        <nav class="main-nav" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-collapse">
                        <span class="sr-only">Navigasi</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button><!--//nav-toggle-->
                </div><!--//navbar-header-->            
                <div class="navbar-collapse collapse" id="navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="active nav-item"><a href="<?php echo base_url();?>">Beranda</a></li>
                        <li class="nav-item dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false" href="#">Profil <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url('page/sejarah');?>">Sejarah</a></li>
                                <li><a href="<?php echo base_url('page/visi-misi');?>">Visi-Misi</a></li>
                                <li><a href="<?php echo base_url('page/pimpinan');?>">Pimpinan</a></li>  
								<li><a href="<?php echo base_url('page/staff');?>">Staff</a></li>  
                            </ul>
                        </li>
						<li class="nav-item dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false" href="#">Akademik <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url('page/kurikulum');?>">Kurikulum</a></li>
								<li><a href="<?php echo base_url('page/ekstra-kurikuler');?>">Ekstra Kurikuler</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a href="<?php echo base_url('berita');?>">Berita</a></li>
						<li class="nav-item dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false" href="#">Fasilitas <i class="fa fa-angle-down"></i></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo base_url('page/laboratorium');?>">Laboratorium</a></li>
								<li><a href="<?php echo base_url('page/fasilitas-keagamaan');?>">Fasilitas Keagamaan</a></li>
								<li><a href="<?php echo base_url('page/fasilitas-olahraga');?>">Fasilitas Olahraga</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a href="<?php echo base_url('event/');?>">Event</a></li>
						<li class="nav-item"><a href="<?php echo base_url('page/penerimaan-siswa-baru');?>">Penerimaan Siswa Baru</a></li>
						<li class="nav-item"><a href="<?php echo base_url('galeri/');?>">Galeri</a></li>
                    </ul><!--//nav-->
                </div><!--//navabr-collapse-->
            </div><!--//container-->
        </nav><!--//main-nav-->