<div class="tab-pane" id="chartjs">
	<div class="row mt">
		<div class="col-lg-6">
			<div class="content-panel"> 
				<div class="panel-body">
					<?php echo form_open('wali/prosesIsiNilaiKI1'); ?>
					<table id="datatable" class="table table-bordered table-striped table-condensed">
						<?php 
							$i = 0;
							foreach ($label as $row) : 
						?>
								<tr>
									<td>
										<?=$label[$i]?>
										<?=form_input($kd_siswa[$i])?>
									</td>
									<td>
										<?=form_input($nilai[$i])?>
									</td>
								</tr>
						<?php
							$i++;
							endforeach;
						?>

					</table>
					<?=form_input($semester)?>
					<?=form_input($kd_kelas)?>
					<?=form_input($tahun_ajaran)?>
					<?=form_submit('submit', 'Masukkan Nilai');?>
					<?=form_close();?>
				</div>
			</div>
		</div>
	</div>
</div>