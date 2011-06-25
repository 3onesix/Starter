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
	</head>
	<body>
		<form id="signin" method="post" action="<?=site_url('admin/authenticate')?>">
			<div class="field">
				<input type="text" name="username" placeholder="username" />
			</div>
			<div class="field">
				<input type="password" name="password" placeholder="password" />
			</div>
			<div class="actions">
				<input type="submit" name="commit" value="Sign In">
			</div>
		</form>
	</body>
</html>