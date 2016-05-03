<h3><i class="fa fa-angle-right"></i> Diagram Nilai Tingkat</h3>
<div class="tab-pane" id="chartjs">
<!-- page start-->

<?php
$idx = 0;
foreach ($data as $row) {
$idx++;
?>
<div class="row mt">
	<div class="col-lg-6">
	<a href = "<?=base_url('monitor/prestasiMapel/'.$idx.'')?>">
		<h4><i class="fa fa-angle-right"></i> Tingkat <?=$idx?> - 10 Terbaik</h4>
	</a>
		<div class="content-panel"> 
				<div class="panel-body">

					<table class="table table-bordered table-striped table-condensed" width="60%">
					<thead>
						<tr>
							<th>No.</th>
							<th>nisn</th>
							<th>Nama</th>
							<th>Rerata Nilai</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$i_idx = 0;
							foreach ($row['upper'] as $siswa) {
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
	<div class="col-lg-6">
	<a href = "<?=base_url('monitor/risky/'.$idx.'')?>">
		<h4><i class="fa fa-angle-right"></i> Tingkat <?=$idx?> - 10 Terendah</h4>
	</a>
		<div class="content-panel"> 
				<div class="panel-body">
					<table class="table table-bordered table-striped table-condensed" width="60%">
					<thead>
						<tr>
							<th>No.</th>
							<th>nisn</th>
							<th>Nama</th>
							<th>Rerata Nilai</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$i_idx = 0;
							foreach ($row['lower'] as $siswa) {
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
</div>
<?php	
}

?>

</div>
<!-- page end-->
</section>          
</section><!-- /MAIN CONTENT -->