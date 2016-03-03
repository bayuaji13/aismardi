<h3><i class="fa fa-angle-right"></i> Ubah Password</h3>
<div class="tab-pane" id="chartjs">
	<div class="row mt">
		<div class="col-lg-6">
			<div class="content-panel"> 
				<div class="panel-body">
					<?php echo form_open('users/ubahPassword'); ?>
					<?php if (validation_errors()) : ?>
						<h3>Whoops! terjadi error : </h3>
						<p><?=validation_errors();?></p>
					<?php endif;?>
					<?php if (isset($error)) : ?>
						<h3>Whoops! terjadi error : </h3>
						<p><?=$error;?></p>
					<?php endif;?>
					<table class="table table-bordered table-striped table-condensed" width="60%">
						<tr>
							<th>Password Lama:</th>
							<td><?=form_password($password_lama)?></td>
						</tr>
						<tr>
							<th>Password :</th>
							<td><?=form_password($password)?></td>
						</tr>
						<tr>
							<th>Konf. Password :</th>
							<td><?=form_password($password_conf)?></td>
						</tr>
					</table>
					<?=form_submit('submit', 'Ubah');?>
					or <?=form_reset('reset', 'Reset');?>
					<?=form_close();?>
				</div>
			</div>
		</div>
	</div>
</div>