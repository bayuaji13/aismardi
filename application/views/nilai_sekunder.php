<h3><i class="fa fa-angle-right"></i> Pengisian Nilai Sekunder</h3>
<div class="tab-pane" id="chartjs">
<?=form_open('walis/prosesIsiNilaiSekunder')?>
<input type="hidden" name="semester" value="<?=$semester?>">
<input type="hidden" name="tahun_ajaran" value="<?=$tahun_ajaran?>">
<input type="hidden" name="kd_kelas" value="<?=$kd_kelas?>">

<?php
$i = -1;
foreach ($kd_siswa as $siswa) { $i++
?>
<div class="col-lg-12">
<div class="col-lg-4">
	<div class="row mt">
		<h4><i class="fa fa-angle-right"></i> <?=$nama_siswa[$i]?></h4>
		<div class="content-panel"> 
			<h4><i class="fa fa-angle-right"></i> nilai antar mapel</h4>
			<?php
				if (isset($sekunder[$kd_siswa[$i]]['nilai'])){
							$nilai = $sekunder[$kd_siswa[$i]]['nilai'];
						} else 
							$nilai = "";
			?>
			<div class="panel-body">
				<input type="hidden" name="kd_siswa[]" value="<?=$kd_siswa[$i]?>">
				<textarea name="antar_mapel[]" class="form-control" style="margin: 0px -2.05966px 0px 0px; height: 186px; resize : none;"><?=$nilai?></textarea>
			</div>
		</div>
	</div>
</div>
<div class="col-lg-4">
	<div class="row mt">
		<h4><i class="fa "></i> </h4>
		<div class="content-panel"> 
			<h4><i class="fa fa-angle-right"></i> pengembangan diri</h4>
			<div class="panel-body">
				<table class="table table-bordered table-striped table-condensed">
					<thead>
						<tr>
							<td width="80%">Kegiatan</td>
							<td>Nilai</td>
						</tr>
					</thead>
					<tbody>
						<?php
							for ($j=0; $j < 3; $j++) { 
								if (isset($kegiatan[$kd_siswa[$i]][$j]['jenisn'])){
									$val[$j]['jenisn'] = $kegiatan[$kd_siswa[$i]][$j]['jenisn'];
								} else {
									$val[$j]['jenisn'] = "";
								}

								if (isset($kegiatan[$kd_siswa[$i]][$j]['keterangan'])){
									$val[$j]['keterangan'] = $kegiatan[$kd_siswa[$i]][$j]['keterangan'];
								} else {
									$val[$j]['keterangan'] = "";
								}
								?>
								<tr>
									<td>
										<input type="text" class="form-control" name="nama_kegiatan[<?=$i?>][]" value="<?=$val[$j]['jenisn']?>">
									</td>
									<td>
										<input type="text" class="form-control" name="ket_kegiatan[<?=$i?>][]" value="<?=$val[$j]['keterangan']?>">
									</td>
								</tr>
						<?php
						}			
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="col-lg-4">
	<div class="row mt">
		<h4><i class="fa "></i> </h4>
		<div class="content-panel"> 
			<h4><i class="fa fa-angle-right"></i> kehadiran</h4>
			<div class="panel-body">
				<table class="table table-bordered table-striped table-condensed">
					<thead>
						<tr>
							<td>Keterangan</td>
							<td>Jumlah</td>
						</tr>
					</thead>
					<tbody>
					<?php
						if (isset($sekunder[$kd_siswa[$i]]['sakit'])){
							$sakit = $sekunder[$kd_siswa[$i]]['sakit'];
						} else 
							$sakit = 0;
						if (isset($sekunder[$kd_siswa[$i]]['izin'])){
							$izin = $sekunder[$kd_siswa[$i]]['izin'];
						} else 
							$izin = 0;

						if (isset($sekunder[$kd_siswa[$i]]['alfa'])){
							$alfa = $sekunder[$kd_siswa[$i]]['alfa'];
						} else 
							$alfa = 0;

					?>
					<tr>
						<td width="40%"><label class="col-sm-2 col-sm-2 control-label">Sakit</label></td>
						<td><input type="text" class="form-control" name="sakit[]" value="<?=$sakit?>"></td>
					</tr>
					<tr>
						<td width="40%"><label class="col-sm-2 col-sm-2 control-label">Izin</label></td>
						<td><input type="text" class="form-control" name="izin[]" value="<?=$izin?>"></td>
					</tr>
					<tr>
						<td width="40%"><label class="col-sm-2 col-sm-2 control-label">alfa</label></td>
						<td><input type="text" class="form-control" name="alfa[]" value="<?=$alfa?>"></td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
</div>

		
<?php
}
?>
<div class="col-lg-12">
	<div class="row mt">
		<div class="content-panel"> 
			<div class="panel-body">
				<?=form_submit('submit', 'Masukkan data');?>
				<?=form_close();?>
			</div>
		</div>
	</div>
</div>
</div>