<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title><?=$this->config->item('starter_product_name')?>: Migrations</title>
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
			<p><?=$app_name?> needs to run migrations on the database. This will only take a moment.</p>
			<a class="btn" href="?migrate">Run Migrations</a>
		</section>
	</body>
</html>