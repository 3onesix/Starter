<?php if (isset($errors) && is_array($errors) && count($errors)): ?>
<ul>
	<?php foreach($errors as $error): ?>
		<li class="error"><?=$error?></li>
	<?php endforeach; ?>
</ul>
<?php endif; ?>