<div class="row mt">
	<div class="col-lg-12">
		<div class="content-panel">
			<h4><i class="fa fa-angle-right"></i> Pilih Kelas : </h4>
			<p>
			<?php
				foreach ($kelas as $row) {
					$id_kelas = $row['id_kelas'];
					$nama_kelas = $row['nama_kelas'];
					?>
					<p> &nbsp;&nbsp; <a href="<?=base_url().'pengampu/pilihPengampu/'.$id_kelas?>"><button type="button" class="btn btn-default">Kelas <?=$nama_kelas?></button></a></p>
					<?php
				}
			?>
			</p>
		</div>
	</div>
</div>
