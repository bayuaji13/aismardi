<?php if ($query->num_rows() > 0 ) : ?>
	<table border="0">
		<tr>
			<td>User</td>
			<td>Level</td>
			<td colspan="2">Actions</td>
		</tr>
		<?php foreach ($query->result() as $row) : ?>
			<tr>
				<td><?php echo $row->user; ?></td>
				<td><?php echo $row->level; ?></td>
				<td><?php echo anchor('users/edit_user/'.$row->user, 'Edit') ; ?></td>
				<td><?php echo anchor('users/delete_user/'.$row->user, 'Delete') ; ?></td>
			</tr>
		<?php endforeach;?>
		</table>
<?php endif;?>