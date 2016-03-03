<div class="tab-pane" id="chartjs">
	<!-- page start-->
		<div class="row mt">
			

	<?php for ($i=0; $i < sizeof($data); $i=$i+2) { 
		# code...
		$row1 = $data[$i];
		$row2 = $data[$i+1];
		?>
			<div class="col-lg-6">
				<div class="content-panel"> 
				<h4><i class="fa fa-angle-right"></i> <?=$row1['nama']?></h4>
					<div class="panel-body" id="tampilan rapor">
						<div class="progress ">
							<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: <?=$row1['terisi']?>%">
								<span class="sr-only"><?=$row1['terisi']?> % Complete</span>
							</div>
						</div>
					</div>
				</div>
				</div>
			<div class="col-lg-6">
				<div class="content-panel"> 
				<h4><i class="fa fa-angle-right"></i> <?=$row2['nama']?></h4>
					<div class="panel-body" id="tampilan rapor">
						<div class="progress ">
							<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: <?=$row2['terisi']?>%">
								<span class="sr-only"><?=$row2['terisi']?> % Complete</span>
							</div>
						</div>
					</div>
				</div>
				</div>

	<?php } ?>
			
		</div>		
</div>