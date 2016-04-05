<!-- ******CONTENT****** --> 
<div class="content container">
	<div class="page-wrapper">
		<header class="page-heading clearfix">
			<h1 class="heading-title pull-left"><?php echo $pageTitle;?></h1>
			<div class="breadcrumbs pull-right">
				<ul class="breadcrumbs-list">
					<li class="breadcrumbs-label">Anda Disini: </li>
					<li><a href="<?php echo base_url();?>">Home</a><i class="fa fa-angle-right"></i></li>
					<li class="current">Events</li>
				</ul>
			</div><!--//breadcrumbs-->
		</header> 
		<div class="page-content">
			<div class="row page-row">
				<div class="events-wrapper col-md-8 col-sm-7">
				<?php 
					if(!empty($event)){
						foreach ($event as $row){
							echo '<article class="events-item page-row has-divider clearfix">';
							echo '	<div class="date-label-wrapper col-md-1 col-sm-2">';
							echo '		<p class="date-label">';
							echo "			<span class='month'>".$row['monthBegin']."</span>";
							echo "			<span class='date-number'>".$row['dayBegin']."</span>";
							echo '		</p>';
							echo '	</div><!--//date-label-wrapper-->';
							echo '	<div class="details col-md-11 col-sm-10">';
							echo "		<h3 class='title'>".$row['eventTitle']."</h3>";
							if ($row['duration'] == 'days')
								echo "	<p class='meta'><span class='time'><i class='fa fa-calendar-o'></i>".$row['dayBegin']." ".$row['monthBegin']." - ".$row['dayEnded']." ".$row['monthEnded']."</span><span class='location'><i class='fa fa-map-marker'></i>".$row['locationName']."</span></p>";
							else
								echo "	<p class='meta'><span class='time'><i class='fa fa-clock-o'></i>".$row['hourBegin']." - ".$row['hourEnded']."</span><span class='location'><i class='fa fa-map-marker'></i>".$row['locationName']."</span></p>";
							echo $row['eventContent'];
							echo '	</div><!--//details-->';
							echo '</article><!--//events-item-->';
						}
						echo $links;
					}else 
						echo 'Tidak ada event';
				?>                     
				</div><!--//events-wrapper-->
				<aside class="page-sidebar  col-md-3 col-md-offset-1 col-sm-4 col-sm-offset-1">                    
					<section class="widget has-divider">
						<h1 class="section-heading text-highlight">Tautan</h1>
						<div class="section-content">
						<?php 
							foreach ($daftarTautan as $tautan){
								echo "<p><a href='".$tautan['linkUrl']."'><i class='fa fa-caret-right'></i>".$tautan['linkName']."</a></p>";
							}
						?>
					</section><!--//widget-->
					<section class="widget has-divider">
						<h3 class="title">Berita Terakhir</h3>
						<?php 
							foreach ($latestNews as $news){
								echo '<article class="news-item row">';
								echo '	<figure class="thumb col-md-2">';
								echo "		<img src='".base_url('assets/uploads/images/images/'.$news['newsThumbnail'])."' alt='".$news['newsTitle']."' >";
								echo '	</figure>';
								echo '	<div class="details col-md-10">';
								echo "		<h4 class='title'><a href='".$news['newsUrl']."'>".$news['newsTitle']."</a></h4>";
								echo '	</div>';
								echo '</article><!--//news-item-->';
							}
						?>
					</section><!--//widget-->
				</aside>
			</div><!--//page-row-->
		</div><!--//page-content-->
	</div><!--//page--> 
</div><!--//content-->