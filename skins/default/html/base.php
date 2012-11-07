<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<title><?php echo $title ?></title>
		<meta charset="UTF-8" />
		<?php echo HTML::style('skins/'.Hierarchive::$skin.'/css/base.css') ?>
	</head>
	<body>
		<div id="header">
			
		</div>

		<?php echo $body ?>

		<div id="footer" class="noprint">
			<hr />
			<ol>
				<li>
					This is
					<a href="http://github.com/samwilson/hierarchive" title="Go to the Hierarchive homepage on Github">Hierarchive</a>.
				</li>
				<li>
					<a href="http://github.com/samwilson/hierarchive/issues/new">Report a problem</a>.
				</li>
				<li>
					Powered by Kohana <?php echo Kohana::VERSION ?>
					(<dfn title="Kohana codename"><?php echo Kohana::CODENAME ?></dfn>).
					Currently in <?php switch (Kohana::$environment) {
						case Kohana::PRODUCTION: echo 'production';
						case Kohana::STAGING: echo 'staging';
						case Kohana::TESTING: echo 'testing';
						case Kohana::DEVELOPMENT: echo 'development';
					} ?> mode.
				</li>
			</ol>

			<?php if (Kohana::$environment == Kohana::DEVELOPMENT): ?>
				<div id="kohana-profiler">
					<?php echo View::factory('kohana/profile') ?>
				</div>
			<?php endif ?>

		</div>

	</body>
</html>