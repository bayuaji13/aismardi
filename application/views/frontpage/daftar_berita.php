<!-- ******CONTENT****** --> 
<div class="content container">
	<div class="page-wrapper">
		<header class="page-heading clearfix">
			<h1 class="heading-title pull-left"><?php echo $pageTitle;?></h1>
			<div class="breadcrumbs pull-right">
				<ul class="breadcrumbs-list">
					<li class="breadcrumbs-label">Anda Disini:</li>
					<li><a href="<?php echo base_url();?>">Home</a><i class="fa fa-angle-right"></i></li>
					<li><a href="<?php echo base_url('berita');?>">Berita</a>
					<?php 
					if (isset($kategori) && isset($kategoriPid)){
					?>
					<i class="fa fa-angle-right"></i></li>
					<li><a href="<?php echo base_url('berita/'.$kategoriPid);?>"><?php echo $kategori;?></a></li>
					<?php
					}else 
					?>
					</li>
				</ul>
			</div><!--//breadcrumbs-->
		</header> 
		<div class="page-content">
			<div class="row page-row">
				<div class="news-wrapper col-md-8 col-sm-7">                         
				<?php 
					if(!empty($berita)){
						foreach ($berita as $row){
							echo '<article class="news-item page-row has-divider clearfix row">';
							echo '	<figure class="thumb col-md-2 col-sm-3 col-xs-4">';
							echo "		<img class='img-responsive' src='".base_url('assets/uploads/images/images/'.$row['newsThumbnail'])."' alt='".$row['newsTitle']."' />";
							echo '	</figure>';
							echo '	<div class="details col-md-10 col-sm-9 col-xs-8">';
							echo "		<h3 class='title'><a href='".$row['newsUrl']."'>".$row['newsTitle']."</a></h3>";
							echo "		<p>".$row['newsContent']."</p>";
							echo "		<a class='btn btn-theme read-more' href='".$row['newsUrl']."'>Selengkapnya<i class='fa fa-chevron-right'></i></a>";
							echo '	</div>';
							echo '</article><!--//news-item-->';
						}
						echo $links;
					}else 
						echo 'Tidak ada berita';
				?>
				</div><!--//news-wrapper-->
				<aside class="page-sidebar  col-md-3 col-md-offset-1 col-sm-4 col-sm-offset-1">                    
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
										echo "<p class='time text-muted'><i class='fa fa-calendar-o'></i>".$event['dayBegin']." ".$event['monthBegin']." - ".$event['dayEnded']." ".$event['monthEnded'];
									else 
										echo "<p class='time text-muted'><i class='fa fa-clock-o'></i>".$event['hourBegin']." - ".$event['hourEnded'];
									echo "<br><i class='fa fa-map-marker'></i>".$event['locationName']."</p>";
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