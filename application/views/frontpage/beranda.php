<!-- ******CONTENT****** --> 
<div class="content container">
	<div id="promo-slider" class="slider flexslider">
		<ul class="slides">
			<?php 
				foreach ($sliders as $slider){
					echo '<li>';
					echo "<img width='1140' height='350' src='".base_url('assets/uploads/images/sliders/'.$slider['sliderUrl'])."'  alt='' />";
					echo '<p class="flex-caption">';
					echo "<span class='main' >".$slider['sliderTitle']."</span>";
					echo '<br />';
					echo '</p>';
					echo '</li>';
				}
			?>
		</ul><!--//slides-->
	</div><!--//flexslider-->
	<section class="news">
		<h1 class="section-heading text-highlight"><span class="line">Berita Terbaru</span></h1>     
		<div class="carousel-controls">
			<a class="prev" href="#news-carousel" data-slide="prev"><i class="fa fa-caret-left"></i></a>
			<a class="next" href="#news-carousel" data-slide="next"><i class="fa fa-caret-right"></i></a>
		</div><!--//carousel-controls--> 
		<div class="section-content clearfix">
			<div id="news-carousel" class="news-carousel carousel slide">
				<div class="carousel-inner">
					<?php 
						if(empty($latestNews))
							echo 'Tidak ada berita';
						else{
							for ($indeks = 1; $indeks <= count($latestNews); $indeks++){
								if ($indeks == 1)
									echo '<div class="item active">';
								else if($indeks != 1 && ($indeks)%4 == 0)
									echo '<div class="item">';
								echo '<div class="col-md-4 news-item">';
								echo "<h2 class='title'><a href='".$latestNews[$indeks-1]['newsUrl']."'>".$latestNews[$indeks-1]['newsTitle']."</a></h2>";
								echo "<img class='thumb' width='100' height='100' src='".base_url('assets/uploads/images/images/'.$latestNews[$indeks-1]['newsThumbnail'])."'  alt='".$latestNews[$indeks-1]['newsTitle']."' />";
								echo "<p>".$latestNews[$indeks-1]['newsContent']."</p>";
								echo "<a class='read-more' href='".$latestNews[$indeks-1]['newsUrl']."'>Selengkapnya<i class='fa fa-chevron-right'></i></a>";
								echo '</div><!--//news-item-->';
								if(($indeks)%3 == 0)
									echo '</div><!--//item-->';
							}
						}
					?>
				</div><!--//carousel-inner-->
			</div><!--//news-carousel-->  
		</div><!--//section-content-->     
	</section><!--//news-->
	<div class="row cols-wrapper">
		<div class="col-md-3">
			<section class="events">
				<h1 class="section-heading text-highlight"><span class="line">Event Terdekat</span></h1>
				<div class="section-content" style="min-height: auto">
				<?php 
					if (empty($latestEvents))
						echo "Tidak ada event terdekat";
					else{
						foreach ($latestEvents as $event){
							echo '<div class="event-item">';
							echo '<p class="date-label">';
							echo "<span class='month'>".$event['monthBegin']."</span>";
							echo "<span class='date-number'>".$event['dayBegin']."</span>";
							echo '</p>';
							echo '<div class="details">';
							echo "<h2 class='title'>".$event['eventTitle']."</h2>";
							if ($event['duration'] == 'days')
								echo "<p class='time'><i class='fa fa-calendar-o'></i>".$event['dayBegin']." ".$event['monthBegin']." - ".$event['dayEnded']." ".$event['monthEnded']."</p>";
							else 
								echo "<p class='time'><i class='fa fa-clock-o'></i>".$event['hourBegin']." - ".$event['hourEnded']."</p>";
							echo "<p class='location'><i class='fa fa-map-marker'></i>".$event['locationName']."</p>";
							echo '</div><!--//details-->';
							echo '</div><!--event-item-->';
						}
					}
				?>
					<a class="read-more" href="<?php echo base_url('event/')?>">Semua event<i class="fa fa-chevron-right"></i></a>
				</div><!--//section-content-->
			</section><!--//events-->
		</div><!--//col-md-3-->
		<div class="col-md-6">
			<section class="video">
				<h1 class="section-heading text-highlight"><span class="line">Sambutan Kepala Sekolah</span></h1>
				<div class="section-content news-item col-md-12"> 
				<?php 
					if (empty($sambutan['imageUrl']) && $sambutan['sambutanKonten'] == "")
						echo "Tidak ada sambutan";
					else {
						echo "<img class='thumb' width='100' height='100' style='float: left; margin-right: 10px;' src='assets/uploads/images/sambutan/".$sambutan['imageUrl']."'  alt='' />";
						echo "<p class='description'>".$sambutan['sambutanKonten']."</p>";
					}
				?>
				</div><!--//section-content-->
			</section><!--//video-->
		</div>
		<div class="col-md-3">
			<section class="links">
				<h1 class="section-heading text-highlight"><span class="line">Tautan</span></h1>
				<div class="section-content">
				<?php 
					foreach ($daftarTautan as $tautan){
						echo "<p><a href='".$tautan['linkUrl']."'><i class='fa fa-caret-right'></i>".$tautan['linkName']."</a></p>";
					}
				?>
				</div><!--//section-content-->
			</section><!--//links-->
			<section class="testimonials">
				<h1 class="section-heading text-highlight"><span class="line">Apa Kata Siswa</span></h1>
				<div class="carousel-controls">
					<a class="prev" href="#testimonials-carousel" data-slide="prev"><i class="fa fa-caret-left"></i></a>
					<a class="next" href="#testimonials-carousel" data-slide="next"><i class="fa fa-caret-right"></i></a>
				</div><!--//carousel-controls-->
				<div class="section-content">
					<div id="testimonials-carousel" class="testimonials-carousel carousel slide">
						<div class="carousel-inner">
						<?php 
							for ($indeks = 1; $indeks <= count($daftarTestimoni); $indeks++){
								if ($indeks == 1)
									echo '<div class="item active" style="min-height: 200px">';
								else if($indeks != 1)
									echo '<div class="item" style="min-height: 200px">';
								echo '<blockquote class="quote">';
								echo "<p><i class='fa fa-quote-left'></i>".$daftarTestimoni[$indeks-1]['testiContent']."</p>";
								echo '</blockquote>';
								echo '<div class="row">';
								echo "<p class='people col-md-8 col-sm-3 col-xs-8'><span class='name'>".$daftarTestimoni[$indeks-1]['testiName']."</span><br /><span class='title'>".$daftarTestimoni[$indeks-1]['testiAngkatan']."</span></p>";
								echo "<img class='profile col-md-4 pull-right' width='90' height='60' src='".base_url('assets/uploads/images/sambutan/'.$daftarTestimoni[$indeks-1]['testiImage'])."'  alt='".$daftarTestimoni[$indeks-1]['testiName']."' />";
								echo '</div>';
								echo '</div><!--//item-->';
							}
						?>
						</div><!--//carousel-inner-->
					</div><!--//testimonials-carousel-->
				</div><!--//section-content-->
			</section><!--//testimonials-->
		</div><!--//col-md-3-->
	</div><!--//cols-wrapper-->
	<section class="awards">
		<div id="awards-carousel" class="awards-carousel carousel slide">
			<div class="carousel-inner">
				<div class="item active">
					<ul class="logos">
						<li class="col-md-2 col-sm-2 col-xs-4">
							<a href="#"><img class="img-responsive" src="assets/images/awards/award1.jpg"  alt="" /></a>
						</li>
						<li class="col-md-2 col-sm-2 col-xs-4">
							<a href="#"><img class="img-responsive" src="assets/images/awards/award2.jpg"  alt="" /></a>
						</li>
						<li class="col-md-2 col-sm-2 col-xs-4">
							<a href="#"><img class="img-responsive" src="assets/images/awards/award3.jpg"  alt="" /></a>
						</li>
						<li class="col-md-2 col-sm-2 col-xs-4">
							<a href="#"><img class="img-responsive" src="assets/images/awards/award4.jpg"  alt="" /></a>
						</li>
						<li class="col-md-2 col-sm-2 col-xs-4">
							<a href="#"><img class="img-responsive" src="assets/images/awards/award5.jpg"  alt="" /></a>
						</li>
						<li class="col-md-2 col-sm-2 col-xs-4">
							<a href="#"><img class="img-responsive" src="assets/images/awards/award6.jpg"  alt="" /></a>
						</li>             
					</ul><!--//slides-->
				</div><!--//item-->
				
				<div class="item">
					<ul class="logos">
						<li class="col-md-2 col-sm-2 col-xs-4">
							<img class="img-responsive" src="assets/images/awards/award7.jpg"  alt="" />
						</li>
						<li class="col-md-2 col-sm-2 col-xs-4">
							<img class="img-responsive" src="assets/images/awards/award6.jpg"  alt="" />
						</li>
						<li class="col-md-2 col-sm-2 col-xs-4">
							<img class="img-responsive" src="assets/images/awards/award5.jpg"  alt="" />
						</li>
						<li class="col-md-2 col-sm-2 col-xs-4">
							<img class="img-responsive" src="assets/images/awards/award4.jpg"  alt="" />
						</li>
						<li class="col-md-2 col-sm-2 col-xs-4">
							<img class="img-responsive" src="assets/images/awards/award3.jpg"  alt="" />
						</li>
						<li class="col-md-2 col-sm-2 col-xs-4">
							<img class="img-responsive" src="assets/images/awards/award2.jpg"  alt="" />
						</li>             
					</ul><!--//slides-->
				</div><!--//item-->
			</div><!--//carousel-inner-->
			<a class="left carousel-control" href="#awards-carousel" data-slide="prev">
				<i class="fa fa-angle-left"></i>
			</a>
			<a class="right carousel-control" href="#awards-carousel" data-slide="next">
				<i class="fa fa-angle-right"></i>
			</a>

		</div>
	</section>
</div><!--//content-->