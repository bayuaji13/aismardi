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
							<td width="40%">Jenisn</td>
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
			<h4><i class="fa fa-angle-right"></i>Organisnasi / Kegiatan </h4>
			<div class="panel-body">
				<table class="table table-bordered table-striped table-condensed">
					<thead>
						<tr>
							<td width="40%">Jenisn</td>
							<td>Nilai</td>
							<td>Keterangan</td>
						</tr>
					</thead>
					<tbody>
						<?php
							for ($j=0; $j < 3; $j++) { 
								if (isset($organisnasi[$id_siswa[$i]][$j]['nama_organisnasi'])){
									$val[$j]['nama_organisnasi'] = $organisnasi[$id_siswa[$i]][$j]['nama_organisnasi'];
								} else {
									$val[$j]['nama_organisnasi'] = "";
								}

								if (isset($organisnasi[$id_siswa[$i]][$j]['nilai_organisnasi'])){
									$val[$j]['nilai_organisnasi'] = $organisnasi[$id_siswa[$i]][$j]['nilai_organisnasi'];
								} else {
									$val[$j]['nilai_organisnasi'] = "";
								}

								if (isset($organisnasi[$id_siswa[$i]][$j]['keterangan'])){
									$val[$j]['keterangan'] = $organisnasi[$id_siswa[$i]][$j]['keterangan'];
								} else {
									$val[$j]['keterangan'] = "";
								}


								?>
								<tr>
									<td>
										<input type="text" class="form-control" name="nama_organisnasi[<?=$i?>][]" value="<?=$val[$j]['nama_organisnasi']?>">
										<input type="hidden" class="form-control" name="nama_organisnasi_lama[<?=$i?>][]" value="<?=$val[$j]['nama_organisnasi']?>">
									</td>
									<td>
										<input type="text" class="form-control" name="nilai_organisnasi[<?=$i?>][]" value="<?=$val[$j]['nilai_organisnasi']?>">
									</td>
									<td>
										<input type="text" class="form-control" name="ket_organisnasi[<?=$i?>][]" value="<?=$val[$j]['keterangan']?>">
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