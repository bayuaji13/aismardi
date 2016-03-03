<h3><i class="fa fa-angle-right"></i> Menu tahun ajaran </h3>
<div class="tab-pane" id="chartjs">
	<div class="row mt">
		<div class="col-lg-12">
			<div class="content-panel"> 
				<h4><i class="fa fa-angle-right"></i> Progres pengisian nilai Tahun Ajaran <?=$tahun_ajaran?> </h4>
				<div class="panel-body">
					<div class="progress">
						<?php 
							if ($total_nilai != 0)
								$persen = round(($terisi / $total_nilai) * 100);
							else
								$persen = 0;
							$persen .= '%';
						?>
						<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?=$terisi?>" aria-valuemin="0" aria-valuemax="<?=$total_nilai?>" style="width: <?=$persen?>">
						
						</div>
					</div>
					<p>
						Data nilai siswa sudah masuk sebanyak <?=$terisi?> dari <?=$total_nilai?> total nilai yang harus diisi (<?=$persen?> data sudah terisi)
						
						</p>
				</div>
			</div>
		</div>
	</div>
	<div class="row mt">
		<div class="col-lg-12">
			<div class="alert alert-danger"> 
				<h4><i class="fa fa-angle-right"></i> PERHATIAN !! </h4>
				<div class="panel-body">
					<b>
					Sebelum memulai tahun ajaran baru, PASTIKAN semua data sudah beres.<br/> Selanjutnya anda akan memilih siswa yang tinggal kelas / tidak lulus (Bila ada)
					<br/> Kelas HARUS diisi lagi tiap pergantian tahun ajaran
					</b>
					<br/>
					<br/>
					<?=anchor('tahunajaran/confirmTABaru','KLIK di Sini untuk melanjutkan ke tahun ajaran baru','class="btn btn-danger"')?>
				</div>
			</div>
		</div>
	</div>
</div>