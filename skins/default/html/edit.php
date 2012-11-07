<form action="">
	<table>
		<tr>
			<td>Title:</td>
			<td><?php echo Form::input('title', $resource->get_title()) ?></td>
		</tr>
		<tr>
			<td>Parent:</td>
			<td><?php echo Form::input('parent_id', $resource->get_parent_id()) ?></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<?php echo Form::submit('submit', 'Save') ?>
				<a href="<?php echo Route::url('resource', array('id'=>$resource->get_id())) ?>"
				   title="Return to view">Cancel</a>
			</td>
		</tr>
	</table>
</form>