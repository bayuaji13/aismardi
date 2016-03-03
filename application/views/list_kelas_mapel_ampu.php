<div class="tab-pane" id="chartjs">
	<!-- page start-->
	<div class="row mt">
		<div class="col-lg-9">
			<div class="content-panel"> 
				<div class="panel-body" id="tampilan rapor">
					<?php
						$kd_guru = $this->session->userdata('kd_transaksi');
						foreach ($data as $row): ?>
						<?php
							$kd_kelas = $row['kd_kelas'];
							$kd_pelajaran = $row['kd_pelajaran'];
							$string = $row['string'];

						?>
						<?=anchor(base_url()."pengampu/monitorGuruMapelKelas/$kd_guru/$kd_pelajaran/$kd_kelas/$tahun_ajaran/$semester",$string ." - Semester ".$semester);?>	
						<br/>
					<?php endforeach ?>
				</div>

			</div>
		</div>
	</div>
</div>