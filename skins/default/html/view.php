

<?php if ($resource->has_parents()): ?>
	<ol class="breadcrumbs">
		<?php foreach ($resource->get_parents() as $parent): ?>
			<li>
				<a href="<?php echo Route::url('resource', array('id' => $parent->get_id())) ?>">
					<span class="title"><?php echo $parent->get_title() ?></span>
				</a>
				<span class="arrow">&raquo;</span>
			</li>
		<?php endforeach ?>
	</ol>
<?php endif ?>

<div class="resource">
	<h1>#<?php echo $resource->get_id() ?>: <?php echo $resource->get_title() ?></h1>

	<p class="edit"><?php echo HTML::anchor($resource->get_id() . '/edit', 'Edit') ?></p>

	<div class="description"><?php echo Markdown($resource->get_description()) ?></div>

	<ol class="resource-contents">
		<?php $row = 'b'; foreach ($resource->get_contents() as $item): $row = ($row=='b') ? 'a' : 'b'; ?>
			<li class="resource <?php echo "row-$row" ?>">
				<h3>
					<a href="<?php echo Route::url('resource', array('id' => $item->get_id())) ?>">
						<?php echo $item->get_title() ?>
					</a>
				</h3>
				<div class="description"><?php echo Markdown($item->get_description()) ?></div>
			</li>
		<?php endforeach ?>
	</ol>

</div>