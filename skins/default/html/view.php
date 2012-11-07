
<?php echo HTML::anchor($resource->get_id().'/edit', 'Edit') ?>

<?php if ($resource->has_parents()): ?>
<ol class="breadcrumbs">
	<?php foreach ($resource->get_parents() as $parent): ?>
	<li>
		<a href="<?php echo Route::url('resource', array('id'=>$parent->get_id())) ?>">
			<?php echo $parent->get_title() ?>
		</a> &raquo;
	</li>
<?php endforeach ?>
</ol>
<?php endif ?>

<h1>#<?php echo $resource->get_id() ?>: <?php echo $resource->get_title() ?></h1>

<dl>
	<dt>Description:</dt>
	<dd><?php echo $resource->get_description() ?></dd>
</dl>

<ol class="resource-contents">
	<?php foreach ($resource->get_contents() as $item): ?>
	<li class="resource">
		<a href="<?php echo Route::url('resource', array('id'=>$item->get_id())) ?>">
			<?php echo $item->get_title() ?>
		</a>
		<?php echo $item->get_description() ?>
	</li>
	<?php endforeach ?>
</ol>
