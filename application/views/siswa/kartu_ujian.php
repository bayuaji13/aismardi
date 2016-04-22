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
				<div class="panel-body" id="kartu_ujian">
					<?=$data?>
				</div>
					<hr/>
				&nbsp;&nbsp;<button onclick="printContent('kartu_ujian')">Print Kartu</button>
			</div>
		</div>
	</div>
</div>