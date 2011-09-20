<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
		<title><?=$this->config->item('starter_product_name')?>: Signin</title>
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<meta name="viewport" content="width=device-width, initial-scale=1"/>
		<!-- Adding "maximum-scale=1" fixes the Mobile Safari auto-zoom bug: http://filamentgroup.com/examples/iosScaleBug/ -->
		
		<link rel="stylesheet" href="<?=base_url()?>assets/app/css/login.css" type="" />
	</head>
	<body>
		<form id="signin" method="post" action="<?=site_url('admin/authenticate')?>">
			<h1 class="image" style="background-image: url(<?=site_url($this->config->item('starter_product_image'))?>)"><a href="<?=site_url('admin')?>"><?=$this->config->item('starter_product_name')?></a></h1>
			<div class="field">
				<label for="username_field">Username<label>
				<input type="text" name="username" id="username_field" />
			</div>
			<div class="field">
				<label for="password_field">Password<label>
				<input type="password" name="password" id="password_field" />
			</div>
			<div class="actions">
				<input type="submit" name="commit" value="Sign In">
			</div>
		</form>
	</body>
</html>