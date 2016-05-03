<script type="text/javascript">
						<?php
						if (isset($alert)){
							if ($alert == 'success')
								$alerts = "Data berhasil dimasukkan";
							else if ($alert == 'fail')
								$alerts = "Ada data yang gagal dimasukkan";
							echo 'alert("'.$alerts.'")';
						}
						?>
					</script>
<div class="tab-pane" id="chartjs">
	<div class="row mt">
		<div class="col-lg-12">
			<div class="content-panel"> 
				<div class="panel-body">
					<?php 
						if (isset($alert)){
							if ($alert == 'fail'){
								?>
								<div class="alert alert-danger"><?=$this->session->flashdata('notice');?></div>
								<?php
							}
						}

						if (isset($url)){
							echo '<p> Gunakan file excel dari link dibawah ini : '.$url.'</p>';
						} 

					?>

					<?php echo form_open_multipart('nilai/do_upload_kartu');?>

					<input type="file" name="userfile" size="20" />

					<br /><br />

					<input type="submit" value="upload" />

					</form>
				</div>
			</div>
		</div>
	</div>
</div>
					
