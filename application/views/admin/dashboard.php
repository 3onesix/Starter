<?php $this->load->view('admin/_header'); ?>
<?php foreach ($widgets as $widget): ?>
	<div class="widget <?=$widget->size?>">
		<?php include('assets/site/modules/'.$widget->module->simple_name.'/views/widgets/'.$widget->view.'.php') ?>
	</div>
<?php endforeach; ?>
<?php $this->load->view('admin/_footer'); ?>