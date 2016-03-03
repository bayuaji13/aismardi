<script type="text/javascript">
	function validate(){

		var eduInput = document.getElementsByName('nilai[]');
		for (i=0; i<eduInput.length; i++)
			{
			 if (eduInput[i].value < 0 || eduInput[i].value > <?=$max?>)
				{
			 	 alert('Gunakan range 0..<?=$max?>');		 
			 	 return false;
				}
			}
	}

</script>
<?php
if (isset($_GET['success'])){
            echo "<script>alert('Data berhasil dimasukkan')</script>";
        }
        ?>

<div class="tab-pane" id="chartjs">
	<div class="row mt">
		<div class="col-lg-6">
			<div class="content-panel"> 
				<div class="panel-body">
					<p class="alert alert-success"> Isi dengan range 0 sampai <?=$max?></p>
					<?php echo form_open('pengampu/prosesIsiNilaiSiswaAmpu', array('onsubmit' => 'return validate()')); ?>
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
					<?=form_input($tahun_ajaran)?>
					<?=form_input($field)?>
					<?=form_input($kd_pelajaran)?>
					<?=form_input($kd_kelas)?>
					<?=form_submit('submit', 'Masukkan Nilai');?>
					<?=form_close();?>
				</div>
			</div>
		</div>
	</div>
</div>