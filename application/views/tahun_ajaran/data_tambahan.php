<script type="text/javascript" src="<?=base_url().'assets'?>/bower_components/jquery/jquery.min.js"></script>
  <script type="text/javascript" src="<?=base_url().'assets'?>/bower_components/moment/min/moment.min.js"></script>
  <script type="text/javascript" src="<?=base_url().'assets'?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?=base_url().'assets'?>/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" href="<?=base_url().'assets'?>/bower_components/bootstrap/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="<?=base_url().'assets'?>/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
<div class="row mt">
	<div class="col-lg-12">
		<div class="content-panel">
		<div class="panel-body">
			<form class="form-inline" action="<?=base_url('tahunajaran/prosesSetData')?>" method="post">
			<h4><i class="fa fa-angle-right"></i> Atur Data Tambahan Tahun Ajaran : </h4>
			<p>

			<label for="tanggal_mulai">Tahun Peraturan Menteri (SKHU) : </label>
			<input type="text" class="form-control" name="tahun_peraturan" id="tahun_peraturan" required="required">
			<br/>
			<label for="tanggal_mulai">Nomor Peraturan Menteri (SKHU) : </label>
			<input type="text" class="form-control" name="nomor_peraturan" id="nomor_peraturan" required="required">
			<br/>
			<label for="tanggal_akhir">Nama Kepala Sekolah  : </label>
			<input type="text" class="form-control" name="nama_kepsek" id="nama_kepsek" required="required">
			<br/>
			</p>
			<input type="submit" value="Masukkan Data" name="Submit">
			</form>
		</div>
		</div>
	</div>
</div>
