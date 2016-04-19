<div class="tab-pane" id="chartjs">
	<div class="row mt">
		<?php 
			echo form_open('mapels/setSeleksiMapel'); 
			for ($i=0; $i < count($mapel); $i++) { 
				unset($mapel[$i]['kkm']);
			}
			?>
		<div class="col-lg-4">
			<div class="content-panel"> 
				<h4><i class="fa fa-angle-right"></i>Tingkat 1 (belum ada penjurusan)</h4>
				<div class="panel-body">
					<p>Pilih Daftar Mapel untuk tingkat 1</p>
					<?php
					foreach ($mapel as $row) {?>
						<div class="checkbox">
						  <label>
						   <input type="checkbox" name="non_jurusan[]" value="<?=$row['id_mapel']?>" <?php if(in_array($row,$non_jurusan)) echo 'checked="checked"' ?> >
						   <?=$row['nama_mapel']?> 
						  </label>
						</div>
					<?php
					}
					?>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="content-panel"> 
				<h4><i class="fa fa-angle-right"></i>Jurusan IPA</h4>
				<div class="panel-body">
					<p>Pilih Daftar Mapel untuk IPA</p>
					<?php
					foreach ($mapel as $row) {?>
						<div class="checkbox">
						  <label>
						   <input type="checkbox" name="ipa[]" value="<?=$row['id_mapel']?>" <?php if(in_array($row,$ipa)) echo 'checked="checked"' ?> >
						   <?=$row['nama_mapel']?> 
						  </label>
						</div>
					<?php
					}
					?>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="content-panel"> 
				<h4><i class="fa fa-angle-right"></i>Jurusan IPS</h4>
				<div class="panel-body">
					<p>Pilih Daftar Mapel untuk IPS</p>
					<?php
					foreach ($mapel as $row) {?>
						<div class="checkbox">
						  <label>
						   <input type="checkbox" name="ips[]" value="<?=$row['id_mapel']?>" <?php if(in_array($row,$ips)) echo 'checked="checked"' ?> >
						   <?=$row['nama_mapel']?> 
						  </label>
						</div>
					<?php
					}
					?>
				</div>
			</div>
		</div>
		
	<div class="row mt">
		<div class="col-lg-12">
			<div class="content-panel">
					<div class="panel-body"> 
						<?=form_close();?>
						<?=form_submit('submit', 'Masukkan data');?>
						<div class="panel-body"> </div>
					</div>
			</div>
		</div>
	</div>
</div>
	