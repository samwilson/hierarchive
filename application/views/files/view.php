

<?php if (count($file->categories()) > 0): ?>
	<ol class="breadcrumb">
		<?php foreach ($file->categories() as $parent): ?>
			<li>
				<a href="<?php echo Route::url('category', array('id' => $parent->id())) ?>">
					<span class="name"><?php echo $parent->name() ?></span>
				</a>
			</li>
		<?php endforeach ?>
	</ol>
<?php endif ?>

<div class="file">
	<h1><?=$file->name() ?> <small>#<?php echo $file->id() ?></small></h1>

	<p class="text-muted">
		Revision <?=$file->revision()?>
		&bull; <a href="<?=Route::url('render', array('id'=>$file->id(), 'size'=>Model_File::SIZE_ORIGINAL, 'ext'=>$file->ext())) ?>">Download</a>
		&bull; <a href="<?=Route::url('file', array('id'=>$file->id(), 'action'=>'edit')) ?>">Edit</a>
	</p>

	<?php if ($file->ext()=='txt'): ?>
	<pre><?= HTML::chars($file->contents()) ?></pre>

	<?php elseif ($file->ext()=='md'): ?>
	<?= \Michelf\MarkdownExtra::defaultTransform($file->contents()) ?>

	<?php elseif ($file->ext()=='html'): ?>
	<?= $file->contents() ?>

	<?php else: ?>
	<p class="image">
		<img src="<?=Route::url('render', array('id'=>$file->id(), 'size'=>Model_File::SIZE_SMALL, 'ext'=>$file->ext())) ?>" />
	</p>

	<?php endif ?>

	<h2>History</h2>
	<table class="table">
		<thead>
			<tr>
				<th>Date</th>
				<th>User</th>
				<th>Changes</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($file->history() as $h): ?>
			<tr>
				<td><?=$h['date_and_time']?></td>
				<td></td>
				<td><?=Hierarchive::msg('changes.'.$h['change_type'], unserialize($h['details']))?></td>
				
			</tr>
			<?php endforeach ?>
		</tbody>
	</table>

</div>
