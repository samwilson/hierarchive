<form method="post">
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
			<td>Description:</td>
			<td><?php echo Form::textarea('description', $resource->get_description()) ?></td>
		</tr>
		<tr>
			<td></td>
			<td>
				<?php echo Form::submit('save', 'Save') ?>
				<?php if ($resource->loaded()): ?>
				<input type="hidden" name="id" value="<?php echo $resource->get_id() ?>" />
				<a href="<?php echo Route::url('resource', array('id'=>$resource->get_id())) ?>"
				   title="Return to view">Cancel</a>
				<?php endif ?>
			</td>
		</tr>
	</table>
</form>