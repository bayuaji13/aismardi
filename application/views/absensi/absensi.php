<script type="text/javascript" src="<?=base_url('assets/js/jquery.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('assets/js/jquery.tokenize.js')?>"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/jquery.tokenize.css')?>"/>

<h3><i class="fa fa-angle-right"></i> Absensi Siswa</h3>
<div class="tab-pane" id="chartjs">
	<div class="row mt">
		<?php 
			$attr = 'onSubmit = "return confirm(\'Apakah Anda yakin data yang dimasukkan sudah BENAR?\');"';
			echo form_open('siswas/setAbsensi/'. $semester,$attr); ?>
		<div class="col-lg-4">
			<div class="content-panel"> 
				<h4><i class="fa fa-angle-right"></i>Sakit</h4>
				<div class="panel-body">
					<p>Ketikkan NIS siswa yang sakit</p>
					<?=form_dropdown('sakit[]',[],'','id="tokenize1" multiple="multiple" class="tokenize-sample"')?>
					<script type="text/javascript">
						$('#tokenize1').tokenize({
						    datas: "<?=base_url('siswas/cariSiswaAll')?>"
						});
						</script>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="content-panel"> 
				<h4><i class="fa fa-angle-right"></i>IZIN</h4>
				<div class="panel-body">
					<p>Ketikkan NIS siswa  yang izin</p>
					<?=form_dropdown('izin[]',[],'','id="tokenize2" multiple="multiple" class="tokenize-sample"')?>
					<script type="text/javascript">
						$('#tokenize2').tokenize({
						    datas: "<?=base_url('siswas/cariSiswaAll')?>"
						});
						</script>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="content-panel"> 
				<h4><i class="fa fa-angle-right"></i>ALFA</h4>
				<div class="panel-body">
					<p>Ketikkan NIS siswa yang alfa</p>
					<?=form_dropdown('alfa[]',[],'','id="tokenize3" multiple="multiple" class="tokenize-sample"')?>
					<script type="text/javascript">
						$('#tokenize3').tokenize({
						    datas: "<?=base_url('siswas/cariSiswaAll')?>"
						});
						</script>
				</div>
			</div>
		</div>
		<!-- <div class="row mt"> -->
			<div class="col-lg-12">
				<div class="content-panel">
					<div class="panel-body"> 
						<div class="form-group">
                              <label for="inputTanggal">Tanggal : </label>
                              <input type="date" name="tanggal" id="inputTanggal" required="required">
                          </div>
						<?=form_submit('submit', 'Masukkan data');?>
						<?=form_close();?>
					<div class="panel-body"> 
				</div>
			</div>
		<!-- </div> -->
	</div>
</div>



