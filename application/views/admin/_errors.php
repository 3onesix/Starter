<?php if (isset($errors) && is_array($errors) && count($errors)): ?>
<div id="message" class="error">
	<ul>
		<?php foreach($errors as $error): ?>
			<li><?=$error?></li>
		<?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>