			<div id="footer">
				&copy; <?=date('Y')?> <?=$this->config->item('starter_copyright')?>
			</div>
		</div>
		<script src="/assets/shared/js/jquery-1.6.1.min.js"></script>
		<script src="/assets/shared/js/jquery.easing.1.3.js"></script>
		<script src="/assets/app/js/app.js"></script>
		<?php if (isset($scripts)): ?>
		<?php foreach($scripts as $script): ?>
			<script src="<?=$script?>" type="text/javascript"></script>
		<?php endforeach; ?>
		<?php endif; ?>
	</body>
</html>