<div class="tab-pane" id="chartjs">
	<!-- page start-->
	<div class="row mt">
		<div class="col-lg-12">
			<div class="content-panel"> 
				<div class="panel-body" id="tampilan rapor">
	<?php echo form_open('nilai/processFilter'); ?>
		<select name="mapel">
			<option value="">--pilih mapel--</option>
			<?php foreach($mapel->result_array() as $row) :?>
				<option value="<?php echo $row['kd_pelajaran']?>"> <?php echo $row['nama_pelajaran']; ?></option>';
			<?php endforeach;?> 
		</select>
		<select name="kelas">
			<option value="">--pilih kelas--</option>
			<?php foreach($kelas->result_array() as $row) :?>
				<option value="<?php echo $row['kd_kelas']?>"> <?php echo $row['nama_kelas']; ?></option>';
			<?php endforeach;?> 
		</select>
		<select name="lulus">
			<option value="">--pilih kelulusan--</option>
			<option value="2">dibawah KKM (tidak lulus)</option>
			<option value="1">diatas KKM (lulus)</option>
		</select>
		<input type="submit" name="submitFilter" value="Filter">
	</form>
	<?php echo form_open('nilai/clearFilter'); ?>
		<input type="submit" value="Clear Filter">
	</form>
</div></div></div></div></div>
