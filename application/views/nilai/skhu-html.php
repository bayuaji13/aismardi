
<script>
function printContent(el){
	var restorepage = document.body.innerHTML;
	var printcontent = document.getElementById(el).innerHTML;
	document.body.innerHTML = printcontent;
	window.print();
	document.body.innerHTML = restorepage;
}</script>
<div class="tab-pane" id="chartjs">
	<!-- page start-->
	<div class="row mt">
		<div class="col-lg-12">
			<div class="content-panel"> 
				<div class="panel-body" id="rapor">



<table>
	<tr>
		<td>
			<img src="<?=base_url('assets/img/logo.png')?>" width="120px" height="120px">
		</td>
		<td>
			<p align="center">
				Yayasan Catur Praya Tunggal<br/>
				S M A  M A R D I S I S W A <br/>
				(TERAKREDITASI “A”) <br/>
				Jl. Sukun Raya No.45 Srondol Wetan, Banyumanik <br/>
				Semarang (50263) Telephone/Faximile : (024) 7471629 <br/>
				Email : sma_mardisiswa@yahoo.co.id <br/>
			</p>
			<hr/>
		</td>
	</tr>
</table>
<table>
	<tr>
		<td width="100%">
			<p align="center">
						SURAT KETERANGAN <br/>
						HASIL UJIAN NASIONAL <br/>
						(Sementara) <br/>

						SEKOLAH MENENGAH ATAS <br/>
						PROGRAM STUDI : ${jurusan} <br/>
						TAHUN PELAJARAN ${tahun_ajaran} <br/>

			</p>
		</td>
	</tr>
</table>



			<hr/>
				&nbsp;&nbsp;<button onclick="printContent('rapor')">Print Rapor</button>
			</div>
		</div>
	</div>
</div>