<div class="tab-pane" id="chartjs">
	<!-- page start-->
	<div class="row mt">
		<div class="col-lg-9">
			<div class="content-panel"> 
				<div class="panel-body" id="tampilan rapor">
					<?php foreach ($data as $row): ?>
						<?php
							$kd_kelas = $row['kd_kelas'];
							$kd_pelajaran = $row['kd_pelajaran'];
							$string = $row['string'];
						?>
						<?=anchor(base_url()."pengampu/isiNilaiSiswaAmpu/$kd_kelas/$kd_pelajaran/$field/$tahun_ajaran/$semester",$string ." - Semester ".$semester);?>	
						<br/>
					<?php endforeach ?>
				</div>

			</div>
		</div>
	</div>
</div>