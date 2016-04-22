
<div class="tab-pane" id="chartjs">
	<!-- page start-->
	<?php 
	if ($this->session->userdata('level') == 1){
		$isWali = $this->pengampu_m->isWali($this->session->userdata['id_transaksi']);
    	$isGuruBP = $this->pengampu_m->isGuruBP($this->session->userdata['id_transaksi']);
		if ($isWali or $isGuruBP){	
		echo '<div class="row mt">
		<div class="col-lg-12">
			<div class="content-panel"> 
				<div class="panel-body">';
		if ($isWali){
			echo '<a  href="'.base_url('users/siftToWali').'"><button type="button" class="btn btn-primary">Masuk Sebagai Wali</button></a>&nbsp;&nbsp;';
		}
		if ($isGuruBP){
			echo '<a  href="'.base_url('users/siftToGuruBP').'"><button type="button" class="btn btn-primary">Masuk Sebagai Guru BP</button></a>';
		}
		echo '		</div>
				</div>
			</div>
		</div>';

		}
	}
	?>
	<div class="row mt">
		<div class="col-lg-12">
			<div class="content-panel"> 
				<div class="panel-body">
					<h2 align="center">Selamat Datang di Sistem Informasi Akademik</h2>

					<div id="body" style="text-align:center">
						<div style="text-align:center"><img src="<?=base_url('assets/img/Foto.png')?>" width="40%" height="30%"/></div></br></br>
						<h4>Semarang </h4>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

		