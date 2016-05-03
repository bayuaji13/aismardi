<script type="text/javascript" src="<?=base_url('assets/js/jquery.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('assets/js/jquery.tokenize.js')?>"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/jquery.tokenize.css')?>"/>

<h3><i class="fa fa-angle-right"></i> Ubah Status Tunggakan Siswa</h3>
<div class="tab-pane" id="chartjs">
	<div class="row mt">
		<?php 
			$attr = 'onSubmit = "return confirm(\'Apakah Anda yakin data yang dimasukkan sudah BENAR?\');"';
			echo form_open('siswas/setTunggakan'); ?>
		<div class="col-lg-6">
			<div class="content-panel"> 
				<h4><i class="fa fa-angle-right"></i>Ganti Ke Tidak Menunggak</h4>
				<div class="panel-body">
					<p>Ketikkan nisn siswa yang akan diganti ke tidak menunggak</p>
					<?=form_dropdown('tidak_menunggak[]',array(),'','id="tokenize1" multiple="false" class="tokenize-sample"')?>
					<script type="text/javascript">
						$('#tokenize1').tokenize({
						    datas: "<?=base_url('siswas/cariSiswaAll')?>"
						});
						</script>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="content-panel"> 
				<h4><i class="fa fa-angle-right"></i>Ganti Ke Menunggak</h4>
				<div class="panel-body">
					<p>Ketikkan nisn siswa akan diganti ke menunggak</p>
					<?=form_dropdown('menunggak[]',array(),'','id="tokenize2" multiple="multiple" class="tokenize-sample"')?>
					<script type="text/javascript">
						$('#tokenize2').tokenize({
						    datas: "<?=base_url('siswas/cariSiswaAll/')?>"
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
					</div> 
				</div>
			</div>
		<!-- </div> -->
	</div>
</div>



