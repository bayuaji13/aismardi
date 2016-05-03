<h3><i class="fa fa-angle-right"></i> Tabel Siswa Berprestasi per Mapel, Tingkat <?=$data['tingkat']?></h3>
<div class="tab-pane" id="chartjs">
<!-- page start-->

<?php
$idx = 0;
// echo count($data['nama_mapel']);
for ($i=0; $i < count($data['nama_mapel']); $i++) { 
	// if (($i+1)%3 == 0 || $i == 0)
	// {
	// 	echo '<div class="row mt">';
	// }
	?>
	<div class="col-lg-4">
		<div class="content-panel"> 
			<h5>&nbsp;<i class="fa fa-angle-right"></i> <?=$data['nama_mapel'][$i]?></h5>
			<div class="panel-body text-center">
				<table class="table table-bordered table-striped table-condensed" width="60%">
					<thead>
						<tr>
							<th>No.</th>
							<th>nisn</th>
							<th>Nama</th>
							<th>Nilai Mapel</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$i_idx = 0;
							foreach ($data['hasil'][$i] as $siswa) {
								// print_r($siswa);
								// die();
								$i_idx++;
								echo '<tr>';
								echo '<td>'.$i_idx.'</td>';
								echo '<td>'.$siswa['nisn'].'</td>';
								echo "<td><a href=".base_url('siswas/managesiswa/read/'.$siswa['kd_siswa']).">".$siswa['nama_siswa']."</a></td>";
								echo '<td>'.$siswa['rerata'].'</td>';
								echo '</tr>';
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>  
	<?php
	// if (($i+1)%3 == 0 || $i == 0)
	// {
	// 	echo '</div>';
	// }
}

?>

</div>
<!-- page end-->
</section>          
</section><!-- /MAIN CONTENT -->