<script>
function printContent(el){
	var restorepage = document.body.innerHTML;
	var printcontent = document.getElementById(el).innerHTML;
	document.body.innerHTML = printcontent;
	window.print();
	document.body.innerHTML = restorepage;
}
</script>
<div class="tab-pane" id="chartjs">
	<!-- page start-->
	<div class="row mt">
		<div class="col-lg-12">
			<div class="content-panel"> 
				<div class="panel-body" id="rapor">
					<?=$data?>
				</div>
					<hr/>
				&nbsp;&nbsp;<button onclick="printContent('rapor')">Print Rapor</button>
			</div>
		</div>
	</div>
</div>