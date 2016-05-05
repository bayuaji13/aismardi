<script type="text/javascript" src="<?=base_url('assets/js/jquery-1.9.1.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('assets/js/jquery.tokenize.js')?>"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/jquery.tokenize.css')?>"/>

<h3><i class="fa fa-angle-right"></i> Membatalkan kelulusan siswa</h3>
<div class="tab-pane" id="chartjs">
	<div class="row mt">
		<?php 
			$attr = 'onSubmit = "return confirm(\'Apakah Anda yakin data yang dimasukkan sudah BENAR?\');"';
			echo form_open('siswas/setBatalLulus'); ?>
		<div class="col-lg-6">
			<div class="content-panel"> 
				<h4><i class="fa fa-angle-right"></i>Pembatalan kelulusan</h4>
				<div class="panel-body">
					<p>Ketikkan nisn siswa yang seharusnya tidak lulus</p>
					<?=form_dropdown('tidak_lulus[]',array(),'','id="tokenize1" multiple="false" class="tokenize-sample"')?>
					<script type="text/javascript">
						$('#tokenize1').tokenize({
						    datas: "<?=base_url('siswas/cariSiswaLulus')?>"
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



