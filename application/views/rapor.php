<div class="row mt">
	<div class="col-lg-12">
		<div class="content-panel">
			<h4><i class="fa fa-angle-right"></i> Tabel Rapor siswa</h4>
			<p>
				<table class="table table-bordered table-striped table-condensed" width="60%">
				<thead>
					<tr>
						<th > No. </th>
						<th > NIS</th>
						<th > Nama siswa</th>
						<th > Semester 1 </th>
						<th > Semester 2 </th>
					</tr>
					</thead>
					<?php
					$i = 0;
					foreach ($siswa as $row) {
						$i++;
						?>
						<tr>
							<td align="center"><?=$i?>.</td>
							<td><?=$row['nis']?></td>
							<td><?=$row['nama_siswa']?></td>
							<td><a href="<?=base_url('batchoutput/exporterRapor2013/'.$row['kd_siswa'].'/1')?>">Semester 1 </a></td>
							<td><a href="<?=base_url('batchoutput/exporterRapor2013/'.$row['kd_siswa'].'/2')?>">Semester 2 </a></td>
						</tr>

						<?php 
					}
					?>

				</table>
			</p>
		</div>
	</div>
</div>