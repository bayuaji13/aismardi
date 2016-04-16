<div class="tab-pane" id="chartjs">
	<!-- page start-->
	<div class="row mt">
		<div class="col-lg-9">
			<div class="content-panel"> 
				<div class="panel-body" id="tampilan rapor">
					<?php foreach ($data as $row): ?>
						<?php
							$id_kelas = $row['id_kelas'];
							$id_mapel = $row['id_mapel'];
							$string = $row['string'];
						?>
						<?=anchor(base_url()."pengampu/isiNilaiSiswaAmpu/$id_kelas/$id_mapel/$semester",$string ." - Semester ".$semester);?>	
						<br/>
					<?php endforeach ?>
				</div>

			</div>
		</div>
	</div>
</div>