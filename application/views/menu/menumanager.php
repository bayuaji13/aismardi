<script type="text/javascript" src="<?=base_url('assets/js/jquery.min.js')?>"></script>
<script type="text/javascript" src="<?=base_url('assets/js/jquery.tokenize.js')?>"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/jquery.tokenize.css')?>"/>
<style>
	#div_loader {
		display:none;
		text-align: center;
		position: fixed;
		top: 50%;
		left: 50%;
		margin-top: -50px;
		margin-left: -100px;
	}
</style>

<h3><i class="fa fa-angle-right"></i> List Siswa tinggal kelas / tidak lulus</h3>
<div class="tab-pane" id="chartjs">
	<div class="row mt">
		<div class="col-lg-12">
			<div class="content-panel">
				<div class="panel-body">
					<div class="dd" id="domenu-1">
					    <button id="domenu-add-item-btn" class="dd-new-item">+</button>
					    <!-- .dd-item-blueprint is a template for all .dd-item's -->
					    <li class="dd-item-blueprint">
					      <!-- @migrating-from 0.48.59 button container -->
					      <button class="collapse" data-action="collapse" type="button" style="display: none;">-</button>
					      <button class="expand" data-action="expand" type="button" style="display: none;">+</button>
					      <div class="dd-handle dd3-handle">Drag</div>
					      <div class="dd3-content">
					        <span class="item-name">[item_name]</span>
					        <!-- @migrating-from 0.13.29 button container-->
					        <!-- .dd-button-container will hide once an item enters the edit mode -->
					        <div class="dd-button-container">
					          <!-- @migrating-from 0.13.29 add button-->
					          <button class="custom-button-example">&#x270E;</button>
					          <button class="item-add">+</button>
					          <button class="item-remove" data-confirm-class="item-remove-confirm">&times;</button>
					        </div>
					        <!-- Inside of .dd-edit-box you can add your custom input fields -->
					        <div class="dd-edit-box" style="display: none;">
					          <!-- data-placeholder has a higher priority than placeholder -->
					          <!-- data-placeholder can use token-values; when not present will be set to "" -->
					          <!-- data-default-value specifies a default value for the input; when not present will be set to "" -->
					          <input type="text" name="title" autocomplete="off" placeholder="Item"
					                 data-placeholder="Any nice idea for the title?"
					                 data-default-value="doMenu List Item. {?numeric.increment}">
					          <select name="custom-select">
					            <option>Pilih..</option>
					            <optgroup label="Laman">
					            <?php 
					            foreach ($pages as $page){
					            	echo "<option value='laman_".$page['pageId']."'>".$page['pageTitle']."</option>";
					            }
					            ?>
					            </optgroup>
					            <optgroup label="Tautan">
					            <?php 
					            foreach ($tautan as $row){
					            	echo "<option value='tautan_".$row['linkId']."'>".$row['linkName']."</option>";
					            }
					            ?>
					            </optgroup>
					          </select>
					          <!-- @migrating-from 0.13.29 an element ".end-edit" within ".dd-edit-box" exists the edit mode on click -->
					          <i class="end-edit">save</i>
					        </div>
					      </div>
					    </li>
					
					    <ol class="dd-list"></ol><br>
					    
					  </div>
					  <div>
					  	<input type="button" id="simpan" value="Simpan Menu">
					  </div>
				</div>	
				<div style="min-height: 48px;" >
					<div id="div_loader">
						<img src="<?php echo base_url("/assets/img/loader.gif"); ?>"
							alt="Memuat." /> Sedang Memuat...
					</div>
				</div>				
			</div>
		</div>
	</div>
</div>



