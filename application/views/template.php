<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?=$title ?></title>

		<link href="<?=Media::url('css/bootstrap.min.css') ?>" rel="stylesheet">
		<link href="<?=Media::url('css/bootstrap-theme.min.css') ?>" rel="stylesheet">
		<link href="<?=Media::url('css/app.css') ?>" rel="stylesheet">

		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body class="controller-<?=$controller ?> action-<?=$action ?> environment-<?=Hierarchive::env()?>">

		<?php if (Kohana::$environment > Kohana::PRODUCTION): ?>
		<div class="alert-warning">
			Currently in <strong><?=Hierarchive::env()?></strong> mode.
			<span class="text-muted">Unset <tt>$_SERVER['KOHANA_ENV']</tt>
			for production (and to remove this notice).</span>
		</div>
		<?php endif ?>

		<div class="container">
			<nav class="navbar navbar-default" role="navigation">
				<div class="container-fluid">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="<?=Route::url('default') ?>"><?=$title ?></a>
					</div>

					<div class="collapse navbar-collapse" id="navbar-collapse">
						<ul class="nav navbar-nav">
							<li><a href="<?=Route::url('default', array('controller'=>'categories')) ?>">Categories</a></li>
							<li><a href="<?=Route::url('default', array('controller'=>'files', 'action'=>'edit')) ?>">New</a></li>
							<li><a href="<?=Route::url('default') ?>">Recent changes</a></li>
						</ul>
					</div>
				</div>
			</nav>

			<?php if (isset($alerts)): ?>
				<?php foreach ($alerts as $alert): ?>
					<div class="alert alert-<?=$alert['type'] ?>">
						<?=$alert['message'] ?>
					</div>
				<?php endforeach ?>
			<?php endif ?>

			<div class="view"><?=$view ?></div>

		</div>

		<footer class="hidden-print">

			<div class="text-muted container small">
				<ol class="">
					<li class="">
						<a href="http://github.com/samwilson/hierarchive" title="Go to the Hierarchive homepage on Github">
							This is Hierarchive <?= Hierarchive::$version ?>
						</a>
					</li>
					<li>
						<a href="http://github.com/samwilson/hierarchive/issues/new" title="Log an issue or feature request">
							<span class="text-danger">Report a problem</span>
						</a>
					</li>
					<li>
						<a href="http://kohanaframework.org/" class="nowrap">
							Powered by Kohana <dfn><?php echo Kohana::CODENAME ?></dfn> <?php echo Kohana::VERSION ?>
						</a>
					</li>
				</ol>
			</div><!-- .container.text-center -->

			<?php if (Kohana::$environment == Kohana::DEVELOPMENT): ?>
				<div class="well" id="kohana-profiler"><?=View::factory('kohana/profile') ?></div>
			<?php endif ?>

		</footer>

		<script src="<?=Media::url('js/jquery.min.js') ?>"></script>
		<script src="<?=Media::url('js/bootstrap.min.js') ?>"></script>
	</body>
</html>
