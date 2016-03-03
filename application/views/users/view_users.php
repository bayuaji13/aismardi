<?php if ($query->num_rows() > 0 ) : ?>
	<table border="0">
		<tr>
			<td>ID</td>
			<td>First Name</td>
			<td>Last Name</td>
			<td>Created Date</td>
			<td>Is Active</td>
			<td colspan="2">Actions</td>
		</tr>
		<?php foreach ($query->result() as $row) : ?>
			<tr>
				<td><?php echo $row->id; ?></td>
				<td><?php echo $row->first_name; ?></td>
				<td><?php echo $row->last_name; ?></td>
				<td><?php echo date
					("d-m-Y", $row->created_date); ?></td>
					<td><?php echo
						($row->is_active ? 'Yes' : 'No'); ?></td>
						<?php endforeach ; ?>
					</table>
				<?php endif ; ?>