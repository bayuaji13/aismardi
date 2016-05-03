<script>
function printContent(el){
	var restorepage = document.body.innerHTML;
	var printcontent = document.getElementById(el).innerHTML;
	document.body.innerHTML = printcontent;
	window.print();
	document.body.innerHTML = restorepage;
}
</script>

<div class="tab-pane" id="chartjs" ng-app="" ng-controller="validationCtrl">
	<!-- page start-->
	<div class="row mt">

		<div class="col-lg-8">
			<div class="content-panel"> 
				<div class="panel-body" id="rapor">
					<img style="float: left;" src="http://smamardisiswa.sch.id/assets/img/logo.png" height="120px" width="120px"> <p align="center">
						Yayasan Catur Praya Tunggal<br/>
						S M A  M A R D I S I S W A <br/>
						(TERAKREDITASI “A”) <br/>
						Jl. Sukun Raya No.45 Srondol Wetan, Banyumanik <br/>
						Semarang (50263) Telephone/Faximile : (024) 7471629 <br/>
						Email : sma_mardisiswa@yahoo.co.id <br/>
					</p>
					<hr/>
					<?=$data?>
				</div>
					<hr/>
				&nbsp;&nbsp;<button onclick="printContent('rapor')">Print Rapor</button>
			</div>
		</div>
	</div>
</div>