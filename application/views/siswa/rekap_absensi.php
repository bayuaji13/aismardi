
<div class="tab-pane" id="chartjs">
	<div class="row mt">
		<div class="col-lg-4">
			<div class="content-panel"> 
				<div class="panel-body">
					<h3 align="center">Rekap Absensi</h3>

					<div id="body">
						<table>
							<thead>
								<tr>
									<th>Keterangan</th>
									<th> </th>
									<th>Jumlah Hari</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Sakit</td>
									<td>&nbsp;</td>
									<td><?=$sakit?></td>
								</tr>
								<tr>
									<td>Izin</td>
									<td>&nbsp;</td>
									<td><?=$izin?></td>
								</tr>
								<tr>
									<td>Tanpa Keterangan</td>
									<td>&nbsp;</td>
									<td><?=$alfa?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-8">
			<div class="content-panel"> 
				<div class="panel-body">
					<br/><br/>
					
					<div id="calendar" class="has-toolbar fc">
					</div>
					

				</div>
			</div>
		</div>
	</div>
</div>

		