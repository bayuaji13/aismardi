<div class="tab-pane" id="chartjs">
	<!-- page start-->
	<div class="row mt">
		<div class="col-lg-12">
			<div class="content-panel"> 
				<div class="panel-body">
					<?php
						$tahun_ajaran = $this->tahun_ajaran->getCurrentTA();
						foreach ($data as $row) {
							$kd_guru = $row['kd_guru'];
							echo anchor(base_url()."pengampu/monitorListKelasMapel/$kd_guru/$tahun_ajaran/$semester",$row['nama_guru']);
							echo "<br/>";
						}
					?>
				</div>
			</div>
		</div>
	</div>
</div>