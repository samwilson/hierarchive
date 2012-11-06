<?php //echo View::factory('breadcrumbs')->render(); ?>

<h1>#<?php echo $id ?>: <?php echo $title ?></h1>

<h2>Metadata</h2>

<dl>
	<dt>Description:</dt>
	<dd><?php echo $resource->get_description() ?></dd>
</dl>

<h2>Contents</h2>
