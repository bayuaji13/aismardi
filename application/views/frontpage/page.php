<!-- ******CONTENT****** --> 
<div class="content container">
	<div class="page-wrapper">
		<header class="page-heading clearfix">
			<h1 class="heading-title pull-left"><?php echo $pageTitle;?></h1>
			<div class="breadcrumbs pull-right">
				<ul class="breadcrumbs-list">
					<li class="breadcrumbs-label">Anda Disini:</li>
					<li><a href="<?php echo base_url();?>">Home</a>
					<?php 
					if(!empty($page)){
					?>
					<i class="fa fa-angle-right"></i></li>
					<li><a href="<?php echo base_url('page/'.$page['pageName']);?>"><?php echo $pageTitle;?></a></li>
					<?php 	
					}else {
					?>
					</li>
					<?php 
					}
					?>
				</ul>
			</div><!--//breadcrumbs-->
		</header> 
		<div class="page-content">
			<div class="row page-row">
				<div class="news-wrapper col-md-8 col-sm-7">                         
					<article class="news-item">
						<?php
						if(!empty($page)){
						?>
						<p class="meta text-muted">Diposting pada: <?php echo $tanggal;?></p>
						<?php echo $page['pageContent'];?>
						<?php 	
						}
						?>
					</article><!--//news-item-->
				</div><!--//news-wrapper-->
				<aside class="page-sidebar  col-md-3 col-md-offset-1 col-sm-4 col-sm-offset-1 col-xs-12">                    
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
						if(empty($latestNews)){
							echo "Tidak ada berita";
						}else{
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
						}
						?>
					</section><!--//widget-->
				</aside>
			</div><!--//page-row-->
		</div><!--//page-content-->
	</div><!--//page--> 
</div><!--//content-->