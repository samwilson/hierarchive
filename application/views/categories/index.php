
<h1><?=$category->name()?></h1>

<h2>Subcategories</h2>
<ol>
	<?php foreach ($category->subcategories() as $cat): ?>
	<li><?=$cat->name() ?></li>
	<?php endforeach ?>

	<?php if (count($category->subcategories())==0): ?>
	<li>
		<a href="<?=Route::url('default', array('controller'=>'categories', 'action'=>'edit')) ?>">
			Add a subcategory here
		</a>
	</li>
	<?php endif ?>
</ol>

<div class="files">
	<h2>Files</h2>
	<?php $files = $category->files(); for ($f = 0; $f < count($files); $f++): $file = $files[$f]; ?>

	<?php if ($f % 6 == 0) echo '<div class="row">' ?>

		<div class="col-md-2">
			<a class="thumbnail" href="<?=Route::url('file', array('id' => $file->id())) ?>">
				<img src="<?=Route::url('render', array('id'=>$file->id(), 'size'=>Model_File::SIZE_THUMB)) ?>" />
				<div class="caption"><?=$file->name() ?></div>
			</a>
		</div>

		<?php if (($f+1) % 6 == 0 OR $f+1==count($files)) echo '</div>' ?>

	<?php endfor ?>

</div>
