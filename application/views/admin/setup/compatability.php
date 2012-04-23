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
		<section class="large">
			<h1 class="image" style="background-image: url(<?=site_url($this->config->item('starter_product_image'))?>)"><a href="<?=site_url('admin')?>"><?=$this->config->item('starter_product_name')?></a></h1>
				<?php if (count($errors) == 0):?>
					<p><?=$this->config->item('starter_product_name')?> has checked your server configuration. Everything looks good!</p>
					<a class="btn" href="?compat">Setup database</a>
				<?php else: ?>
					<p><?=$this->config->item('starter_product_name')?> has checked your server configuration. There is a problem.</p>
					<ul>
					<?php foreach($errors as $error):?>
						<li class="error"><?=$error?></li>
					<?php endforeach; ?>
					</ul>
					<a class="btn" href="">Recheck configuration</a>
				<?php endif; ?>
		</section>
	</body>
</html>