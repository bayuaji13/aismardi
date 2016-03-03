<div class="btn-group">
	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
		Pilih Tahun Ajaran
		<span class="caret"></span>
	</button>
	<ul class="dropdown-menu">
		<?php for($i=0;$i<$tingkat;$i++) {
			$tahun_ajaran = $this->tahun_ajaran->getCurrentTA() - $i;
			$url_rapor = base_url()."batchoutput/exporterRapor2013/$kd_siswa/$semester/$tahun_ajaran";
			$ta2 = $tahun_ajaran+1;
			$teks = $tahun_ajaran . " / " . $ta2 ;
		?>
		<li><a href="<?=$url_rapor?>"><?=$teks?></a></li>
		<?php } ?>
	</ul>
</div>
<hr/>