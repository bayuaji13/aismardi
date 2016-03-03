<div class="tab-pane" id="chartjs">
	<!-- page start-->
	<div class="row mt">
		<div class="col-lg-12">
			<div class="content-panel"> 
				<div class="panel-body">
					<h3 align="center">Bantuan Penggunaan Sistem</h3>

					<div id="body" style="text-align:center"></br></br>

						<h4>Untuk User Manual / Buku Panduan penggunaan sistem dapat di download di <a href="<?=base_url().'assets/docs/usermanual.pdf'?>"> sini </a></h4>
						<?php
							if ($this->session->userdata['level'] == 9){
							?>
							<h4>Untuk User Manual / Buku Panduan Khusus Admin dapat di download di <a href="<?=base_url().'assets/docs/adminmanual.pdf'?>"> sini </a></h4>
						<?php
							}
						?>
				</div>
			</div>
		</div>
	</div>
</div>