<h3><i class="fa fa-angle-right"></i> Pengisian Nilai Pengembangan</h3>
<div class="tab-pane" id="chartjs">
<?=form_open('walis/prosesIsiNilaiPengembangan')?>
<input type="hidden" name="semester" value="<?=$semester?>">
<input type="hidden" name="tahun_ajaran" value="<?=$tahun_ajaran?>">
<input type="hidden" name="id_kelas" value="<?=$id_kelas?>">

<?php
$i = -1;
foreach ($id_siswa as $siswa) { $i++
?>
<div class="col-lg-12">
<div class="col-lg-6">
<input type="hidden" name="id_siswa[]
" value="<?=$id_siswa[$i]?>">
	<div class="row mt">
		<h4><i class="fa "></i><?=$nama_siswa[$i]?></h4>
		<div class="content-panel"> 
			<h4><i class="fa fa-angle-right"></i> Ekstrakurikuler </h4>
			<div class="panel-body">
				<table class="table table-bordered table-striped table-condensed">
					<thead>
						<tr>
							<td width="40%">Jenis</td>
							<td>Nilai</td>
							<td>Keterangan</td>
						</tr>
					</thead>
					<tbody>
						<?php
							for ($j=0; $j < 3; $j++) { 
								if (isset($kegiatan[$id_siswa[$i]][$j]['nama_kegiatan'])){
									$val[$j]['nama_kegiatan'] = $kegiatan[$id_siswa[$i]][$j]['nama_kegiatan'];
								} else {
									$val[$j]['nama_kegiatan'] = "";
								}

								if (isset($kegiatan[$id_siswa[$i]][$j]['nilai_kegiatan'])){
									$val[$j]['nilai_kegiatan'] = $kegiatan[$id_siswa[$i]][$j]['nilai_kegiatan'];
								} else {
									$val[$j]['nilai_kegiatan'] = "";
								}

								if (isset($kegiatan[$id_siswa[$i]][$j]['keterangan'])){
									$val[$j]['keterangan'] = $kegiatan[$id_siswa[$i]][$j]['keterangan'];
								} else {
									$val[$j]['keterangan'] = "";
								}

								?>
								<tr>
									<td>
										<input type="text" class="form-control" name="nama_kegiatan[<?=$i?>][]" value="<?=$val[$j]['nama_kegiatan']?>">
										<input type="hidden" class="form-control" name="nama_kegiatan_lama[<?=$i?>][]" value="<?=$val[$j]['nama_kegiatan']?>">
									</td>
									<td>
										<input type="text" class="form-control" name="nilai_kegiatan[<?=$i?>][]" value="<?=$val[$j]['nilai_kegiatan']?>">
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
<div class="col-lg-6">
	<div class="row mt">
		<h4><i class="fa "></i> </h4>
		<div class="content-panel"> 
			<h4><i class="fa fa-angle-right"></i>Organisasi / Kegiatan </h4>
			<div class="panel-body">
				<table class="table table-bordered table-striped table-condensed">
					<thead>
						<tr>
							<td width="40%">Jenis</td>
							<td>Nilai</td>
							<td>Keterangan</td>
						</tr>
					</thead>
					<tbody>
						<?php
							for ($j=0; $j < 3; $j++) { 
								if (isset($organisasi[$id_siswa[$i]][$j]['nama_organisasi'])){
									$val[$j]['nama_organisasi'] = $organisasi[$id_siswa[$i]][$j]['nama_organisasi'];
								} else {
									$val[$j]['nama_organisasi'] = "";
								}

								if (isset($organisasi[$id_siswa[$i]][$j]['nilai_organisasi'])){
									$val[$j]['nilai_organisasi'] = $organisasi[$id_siswa[$i]][$j]['nilai_organisasi'];
								} else {
									$val[$j]['nilai_organisasi'] = "";
								}

								if (isset($organisasi[$id_siswa[$i]][$j]['keterangan'])){
									$val[$j]['keterangan'] = $organisasi[$id_siswa[$i]][$j]['keterangan'];
								} else {
									$val[$j]['keterangan'] = "";
								}


								?>
								<tr>
									<td>
										<input type="text" class="form-control" name="nama_organisasi[<?=$i?>][]" value="<?=$val[$j]['nama_organisasi']?>">
										<input type="hidden" class="form-control" name="nama_organisasi_lama[<?=$i?>][]" value="<?=$val[$j]['nama_organisasi']?>">
									</td>
									<td>
										<input type="text" class="form-control" name="nilai_organisasi[<?=$i?>][]" value="<?=$val[$j]['nilai_organisasi']?>">
									</td>
									<td>
										<input type="text" class="form-control" name="ket_organisasi[<?=$i?>][]" value="<?=$val[$j]['keterangan']?>">
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