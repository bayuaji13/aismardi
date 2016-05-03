<script type="text/javascript" src="<?=base_url('assets/js/jquery-1.9.1.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('assets/js/jquery.tokenize.js')?>"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/jquery.tokenize.css')?>"/>

<h3><i class="fa fa-angle-right"></i> Input siswa tidak lulus</h3>
<div class="tab-pane" id="chartjs">
	<div class="row mt">
		<?php 
			$attr = 'onSubmit = "return confirm(\'Apakah Anda yakin data yang dimasukkan sudah BENAR?\');"';
			echo form_open('siswas/setTidakLulus'); ?>
		<div class="col-lg-6">
			<div class="content-panel"> 
				<h4><i class="fa fa-angle-right"></i>Siswa TIDAK LULUS</h4>
				<div class="panel-body">
					<p>Ketikkan nisn siswa yang TIDAK LULUS</p>
					<?=form_dropdown('tidak_lulus[]',array(),'','id="tokenize1" multiple="false" class="tokenize-sample"')?>
					<script type="text/javascript">
						$('#tokenize1').tokenize({
						    datas: "<?=base_url('siswas/cariSiswaT3')?>"
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



