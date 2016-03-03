<h3><i class="fa fa-angle-right"></i> Daftar siswa Rawan - Tingkat <?=$tingkat?></h3>
<div class="tab-pane" id="chartjs">
<!-- page start-->
<div class="row mt">
<?php

$idx = 0;
if ($data == null){
	die("belum ada data nilai");
}
else {
	foreach ($data as $semester) {
		$idx++;
		?>
			<div class="col-lg-6">
				<h4><i class="fa fa-angle-right"></i>Semester <?=$idx?></h4>
				<div class="content-panel"> 
						<div class="panel-body">
							<?php
							if ($semester == null){
								echo "belum ada data untuk semester ". $idx;
							} else{ ?>
							<table class="table table-bordered table-striped table-condensed" width="60%">
							<thead>
								<tr>
									<th>No.</th>
									<th>NIS</th>
									<th>Nama</th>
									<th>Jumlah mapel dibawah KKM</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$i_idx = 0;
									foreach ($semester as $siswa) {
										// print_r($siswa);
										// die();
										$i_idx++;
										echo '<tr>';
										echo '<td>'.$i_idx.'</td>';
										echo '<td>'.$siswa['nis'].'</td>';
										echo "<td><a href=".base_url('siswas/managesiswa/read/'.$siswa['kd_siswa']).">".$siswa['nama_siswa']."</a></td>";
										echo '<td>'.$siswa['jumlah'].'</td>';
										echo '</tr>';
									}
								?>
							</tbody>
							</table>
							<?php } ?>
						</div>
				</div>
				
			</div>                
		
	<?php	
		
	}
}

?>
</div>
</div>
<!-- page end-->
</section>          
</section><!-- /MAIN CONTENT -->