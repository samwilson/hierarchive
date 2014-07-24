
<h1>
	<?= ($file->id()) ? 'Edit file #'.$file->id() : 'Create a file' ?>
</h1>

<?php $form_action = ($file->id())
	? Route::url('file', array('id'=>$file->id(), 'action'=>'edit'))
	: Route::url('default', array('controller' => 'files', 'action' => 'edit')) ?>
<form method="post" action="<?=$form_action ?>" enctype="multipart/form-data" role="form">

	<div class="form-group">
		<label for="name" class="">Name:</label>
		<div class="">
			<input type="text" id="name" name="name" value="<?=HTML::chars($file->name())?>" class="form-control" />
		</div>
	</div>

	<ul class="nav nav-tabs" role="tablist">
		<li class="<?php if ( ! $file->is_text()) echo 'active' ?>">
			<a href="#upload" role="tab" data-toggle="tab">Upload</a>
		</li>
		<li class="<?php if ($file->is_text()) echo 'active' ?>">
			<a href="#text-entry" role="tab" data-toggle="tab">Text entry</a>
		</li>
	</ul>

	<div class="tab-content">

		<div class="tab-pane well <?php if ( ! $file->is_text()) echo 'active' ?>" id="upload">
			<div class="form-group">
				<label for="">Upload a single file:</label>
				<input type="file" id="upload_file" name="upload_file" class="" />
			</div>
		</div>

		<div class="tab-pane well <?php if ($file->is_text()) echo 'active' ?>" id="text-entry">
			<div class="form-group">
				<label for="text_file">Text:</label>
				<textarea id="text_file" name="text_file" rows="24" cols="80" class="form-control"><?=HTML::chars($file->contents())?></textarea>
			</div>
			<div class="form-group">
				<label for="type">Type:</label>
				<?=Form::select('type', Model_File::$text_types, $file->type(), array('class'=>'form-control')) ?>
			</div>
		</div>

	</div><!-- .tab-content -->

	<div class="row">
		<div class="form-group col-md-12">
			<input type="submit" class="btn btn-primary" value="Save" />
			<?php if ($file->id()): ?>
			<a href="<?=Route::url('file', array('id' => $file->id())) ?>" class="btn btn-default">Cancel</a>
			<?php endif ?>
		</div>
	</div>

</form>
