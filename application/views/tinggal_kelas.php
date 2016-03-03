<script type="text/javascript" src="<?=base_url('assets/js/jquery.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('assets/js/jquery.tokenize.js')?>"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/jquery.tokenize.css')?>"/>

<h3><i class="fa fa-angle-right"></i> List Siswa tinggal kelas / tidak lulus</h3>
<div class="tab-pane" id="chartjs">
	<div class="row mt">
		<?php 
			$attr = 'onSubmit = "return confirm(\'Apakah Anda yakin data yang dimasukkan sudah BENAR?\');"';
			echo form_open('tahunajaran/setTinggalKelas',$attr); ?>
		<div class="col-lg-4">
			<div class="content-panel"> 
				<h4><i class="fa fa-angle-right"></i>Tingkat 1</h4>
				<div class="panel-body">
					<p>Ketikkan NIS siswa tingkat 1 yang tinggal kelas</p>
					<?=form_dropdown('daftar[]',[],'','id="tokenize1" multiple="multiple" class="tokenize-sample"')?>
					<script type="text/javascript">
						$('#tokenize1').tokenize({
						    datas: "getTinggalKelas/2"
						});
						</script>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="content-panel"> 
				<h4><i class="fa fa-angle-right"></i>Tingkat 2</h4>
				<div class="panel-body">
					<p>Ketikkan NIS siswa tingkat 2 yang tinggal kelas</p>
					<?=form_dropdown('daftar[]',[],'','id="tokenize2" multiple="multiple" class="tokenize-sample"')?>
					<script type="text/javascript">
						$('#tokenize2').tokenize({
						    datas: "getTinggalKelas/3"
						});
						</script>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="content-panel"> 
				<h4><i class="fa fa-angle-right"></i>Tingkat 3</h4>
				<div class="panel-body">
					<p>Ketikkan NIS siswa tingkat 3 yang tidak lulus</p>
					<?=form_dropdown('daftar[]',[],'','id="tokenize3" multiple="multiple" class="tokenize-sample"')?>
					<script type="text/javascript">
						$('#tokenize3').tokenize({
						    datas: "getTinggalKelas/4"
						});
						</script>
				</div>
			</div>
		</div>
		<!-- <div class="row mt"> -->
			<div class="col-lg-12">
				<div class="content-panel">
					<div class="panel-body"> 
						<?=form_submit('submit', 'Masukkan data');?>
						<?=form_close();?>
					<div class="panel-body"> 
				</div>
			</div>
		<!-- </div> -->
	</div>
</div>



