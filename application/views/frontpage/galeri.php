<!-- ******CONTENT****** --> 
<div class="content container">
	<div class="page-wrapper">
		<header class="page-heading clearfix">
			<h1 class="heading-title pull-left"><?php echo $title;?></h1>
			<div class="breadcrumbs pull-right">
				<ul class="breadcrumbs-list">
					<li class="breadcrumbs-label">Anda Disini:</li>
					<li><a href="<?php echo base_url();?>">Home</a><i class="fa fa-angle-right"></i></li>
					<li class="current">Galeri</li>
				</ul>
			</div><!--//breadcrumbs-->
		</header> 
		<div class="page-content">    
			<div class="row page-row">
			<?php 
				if(!empty($galeri)){
					foreach ($galeri as $row){
						echo '<div class="col-md-4 col-sm-4 col-xs-12 text-center">';
						echo '	<div class="album-cover">';
						echo "		<a href='".base_url('assets/uploads/images/galleries/'.$row['imageUrl'])."'><img class='img-responsive' src='".base_url('assets/uploads/images/galleries/thumb__'.$row['imageUrl'])."' alt='".$row['imageTitle']."' /></a>";
						echo '		<div class="desc">';
						echo "			<h4><small>".$row['imageTitle']."</small></h4>";
						echo '		</div>';
						echo '	</div>';
						echo '</div>';
					}
				}else 
					echo 'Tidak Ada Konten Pada Galeri';
			?>				
			
			</div><!--//page-row-->
			<?php 
				if(!empty($galeri))
					echo $links;
			?>
		</div><!--//page-content-->
	</div><!--//page--> 
</div><!--//content-->