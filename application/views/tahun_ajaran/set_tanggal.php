<div class="row mt">

	<div class="col-lg-12">
		<div class="content-panel">
		<div class="panel-body">
			<form class="form-inline" action="<?=base_url('tahunajaran/prosesSetTanggal')?>" method="post">
			<h4><i class="fa fa-angle-right"></i> Atur rentang waktu download kartu : </h4>
			<p>
			<label for="keterangan">Tes : </label>
			<select class="form-control" id="tes" name="keterangan" required="required">
				<option value="uts">UTS</option>
				<option value="uas">UAS</option>
			</select>
			<label for="tanggal_mulai">Tanggal Mulai : </label>
			<input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai" required="required">
			<label for="tanggal_akhir">Tanggal Selesai : </label>
			<input type="date" class="form-control" name="tanggal_akhir" id="tanggal_akhir" required="required">
			<br/>
			</p>
			<input type="submit" value="Masukkan Data" name="Submit">
			</form>
		</div>
		</div>
	</div>
</div>
