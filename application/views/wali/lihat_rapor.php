<div class="tab-pane" id="chartjs">
	<!-- page start-->
	<div class="row mt">
		<div class="col-lg-12">
			<div class="content-panel"> 
				<div class="panel-body">
					<?php
						$tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
						foreach ($data as $row) {
							echo anchor(base_url().$row['link'],$row['teks']);
							echo "<br/>";
						}
					?>
				</div>
			</div>
		</div>
	</div>
</div>