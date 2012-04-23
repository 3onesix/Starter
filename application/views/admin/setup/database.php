<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title><?=$this->config->item('starter_product_name')?>: Compatability</title>
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<!-- Adding "maximum-scale=1" fixes the Mobile Safari auto-zoom bug: http://filamentgroup.com/examples/iosScaleBug/ -->

		<link rel="stylesheet" href="<?=base_url()?>assets/app/css/setup.css" type="" />
	</head>
	<body>
		<section>
			<h1 class="image" style="background-image: url(<?=site_url($this->config->item('starter_product_image'))?>)"><a href="<?=site_url('admin')?>"><?=$this->config->item('starter_product_name')?></a></h1>
			<?php if ( isset($error) ): ?>
			<div class="error"><?=$error?></div>
			<?php endif; ?>
			<form action="?compat" method="post">
				<div class="field">
					<label for="host">Host URL</label>
					<input id="host" name="host" type="text" value="localhost" />
				</div>
				<div class="field">
					<label for="database">Database Name</label>
					<input id="database" name="database" type="text" />
				</div>
				<div class="field">
					<label for="username">Username</label>
					<input id="username" name="username" type="text" />
				</div>
				<div class="field">
					<label for="password">Password</label>
					<input id="password" name="password" type="password" />
				</div>
				<div class="actions">
					<input type="submit" name="submit" value="check connection" >
				</div>
			</form>
		</section>
	</body>
</html>