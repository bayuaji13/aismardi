<?php echo form_open('users/new_user'); ?>
<?php if (validation_errors()) : ?>
	<h3>Whoops! terjadi error : </h3>
	<p><?=validation_errors();?></p>
<?php endif;?>
<table border="0">
<tr>
	<td>User</td>
	<td><?=form_input($user)?></td>
</tr>
<tr>
	<td>Password</td>
	<td><?=form_password($pass)?></td>
</tr>
<tr>
	<td>Level</td>
	<td><?php echo form_dropdown('level',$level);?></td>
</tr>
</table>
	<?=form_submit('submit', 'Create');?>
	or <?php anchor('users/new_user','cancel');?>
<?=form_close();?>