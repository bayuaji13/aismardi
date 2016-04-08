<div class="tab-pane" id="chartjs">
	<div class="row mt">
		<div class="col-lg-6">
			<?php $nama_kelas = $this->kelas->getNamaKelas($id_kelas); ?>
				<h3><i class="fa fa-angle-right"></i>Pilih pengampu mapel untuk kelas <?=$nama_kelas?>  </h3> <br/>
			<div class="content-panel"> 
				<div class="panel-body">
					<?php echo form_open('pengampu/setPengampu'); 
					?>
					<table id="datatable" class="table table-bordered table-striped table-condensed">
						<input type="hidden" name="id_kelas" value="<?=$id_kelas?>">
						<?php 
							if ($this->session->flashdata('notice') != null ){
								echo "<script>alert('".$this->session->flashdata('notice')."')</script>";
							}
							foreach ($mapel as $row_mapel) {
							?>
								<tr>
									<td>
										<p><?=$row_mapel['nama_mapel']?></p>
										<input type="hidden" name="mapel[]" value="<?=$row_mapel['id_mapel']?>">
									</td>
									<td>
										<select name="pengampu[]" required="required">
											<option value="">Pilih pengampu</option>
											<?php
											$pengampuSekarang = $this->pengampu_m->cekPengampu($id_kelas,$row_mapel['id_mapel']);
											foreach ($guru as $row_guru) {
												?>
												<option value="<?=$row_guru['id_guru']?>" <?php if ($pengampuSekarang == $row_guru['id_guru']) echo 'selected="selected"'?> >
												<?=$row_guru['nama']?></option>
												<?php
											}
											?>
										</select>
									</td>
								</tr>
							<?php
							}
						?>

					</table>
					<?=form_submit('submit', 'Submit pilihan');?>
					<?=form_close();?>
				</div>
			</div>
		</div>
	</div>
</div>