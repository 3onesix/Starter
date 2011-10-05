<?=$copy?>

<ul>
	<?php foreach ($contacts as $contact): ?>
		<li><?=$contact['title']?> <?=$contact['name']?></li>
	<?php endforeach; ?>
</ul>