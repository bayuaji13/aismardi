<!-- ******CONTENT****** --> 
<div class="content container">
	<div class="page-wrapper">
		<header class="page-heading clearfix">
			<h1 class="heading-title pull-left"><?php echo $judulBerita;?></h1>
			<div class="breadcrumbs pull-right">
				<ul class="breadcrumbs-list">
					<li class="breadcrumbs-label">You are here:</li>
					<li><a href="<?php echo base_url();?>">Home</a><i class="fa fa-angle-right"></i></li>
					<li><a href="<?php echo base_url('berita');?>">Berita</a><i class="fa fa-angle-right"></i></li>
					<li><a href="<?php echo base_url('berita/'.$kategoriPid);?>"><?php echo $kategori;?></a><i class="fa fa-angle-right"></i></li>
					<li class="current"><?php echo $judulBerita;?></li>
				</ul>
			</div><!--//breadcrumbs-->
		</header> 
		<div class="page-content">
			<div class="row page-row">
				<div class="news-wrapper col-md-8 col-sm-7">                         
					<article class="news-item">
						<p class="meta text-muted">Diposting pada: <?php echo $tanggal;?></p>
						<?php echo $konten;?>                  
					</article><!--//news-item-->
				</div><!--//news-wrapper-->
				<aside class="page-sidebar  col-md-3 col-md-offset-1 col-sm-4 col-sm-offset-1 col-xs-12">                    
					<section class="widget has-divider">
						<h3 class="title">Berita Terkait</h3>
						<?php 
							if(empty($similarBerita)){
								echo 'Tidak ada Berita Terkait';
							}else{
								foreach ($similarBerita as $row){
									echo '<article class="news-item row">';
									echo '<figure class="thumb col-md-2 col-sm-3 col-xs-3">';
									echo "<img width='40' height='40' src='".base_url('assets/uploads/images/images/'.$row['newsThumbnail'])."' alt='' />";
									echo '</figure>';
									echo '<div class="details col-md-10 col-sm-9 col-xs-9">';
									echo "<h4 class='title'><a href='".$row['newsUrl']."'>".$row['newsTitle']."</a></h4>";
									echo '</div>';
									echo '</article><!--//news-item-->';
								}
							}
						?>
					</section><!--//widget-->
					<section class="widget has-divider">
						<h3 class="title">Event Terdekat</h3>
						<?php 
							if (empty($latestEvents))
								echo "Tidak ada event terdekat";
							else{
								foreach ($latestEvents as $event){
									echo '<article class="events-item row page-row">';
									echo '<div class="date-label-wrapper col-md-3 col-sm-4 col-xs-4">';
									echo '<p class="date-label">';
									echo "<span class='month'>".$event['monthBegin']."</span>";
									echo "<span class='date-number'>".$event['dayBegin']."</span>";
									echo '</p>';
									echo '</div><!--//date-label-wrapper-->';
									echo '<div class="details col-md-9 col-sm-8 col-xs-8">';
									echo "<h5 class='title'>".$event['eventTitle']."</h2>";
									if ($event['duration'] == 'days')
										echo "<p class='time text-muted'><i class='fa fa-calendar-o'></i>".$event['dayBegin']." ".$event['monthBegin']." - ".$event['dayEnded']." ".$event['monthEnded']."</p>";
									else 
										echo "<p class='time text-muted'><i class='fa fa-clock-o'></i>".$event['hourBegin']." - ".$event['hourEnded'];
									echo $event['locationName']."</p>";
									echo '</div><!--//details-->';
									echo '</article>';
								}
							}
						?>
					</section><!--//widget-->
				</aside>
			</div><!--//page-row-->
		</div><!--//page-content-->
	</div><!--//page--> 
</div><!--//content-->