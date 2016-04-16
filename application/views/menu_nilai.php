
<div class="tab-pane" id="chartjs">
	<!-- page start-->
	<div class="row mt">
		<div class="col-lg-9">
		<h4><i class="fa fa-angle-right"></i> Pilih Semester  </h4> 
			<div class="content-panel"> 
				<div class="panel-body" id="container">
				<!-- <form> -->
				<table>
					<tr>
						<td colspan="2">
							<?php
								$id_pengampu = $this->session->userdata('id_transaksi');
							?>
							<a id="link" href="<?=base_url('pengampu/getKelasDanMapelAmpu/'.$id_pengampu.'/1')?>" ><button id="linkButton" class="btn btn-success btn-lg">Semester 1</button></a><br/><br/>
							<a id="link" href="<?=base_url('pengampu/getKelasDanMapelAmpu/'.$id_pengampu.'/2')?>" ><button id="linkButton" class="btn btn-success btn-lg">Semester 2</button></a>
						</td>
					</tr>
				</table>
				<!-- </form> -->
				

				</div>
			</div>
		</div>
	</div>
</div>
	