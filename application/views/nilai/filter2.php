<?php if ($mapel->num_rows() > 0 ) : ?>
	<form action='nilai/filterNilai'>
		<select class="mapels">
			<?php foreach($mapel->result_array() as $row) :?>
				<option value="<?php echo $row['kd_pelajaran']?>"> <?php echo $row['nama_pelajaran']; ?></option>';
			<?php endforeach;?> 
		</select>
		<select class="mapels">
			<?php foreach($kelas->result_array() as $row) :?>
				<option value="<?php echo $row['kd_kelas']?>"> <?php echo $row['nama_kelas']; ?></option>';
			<?php endforeach;?> 
		</select>
		<input type="submit" value="Filter">
	</form>
<?php endif;?>