<?php 
	$module = $this->module_model->first(array('simple_name' => 'starter_googleanalytics'));
	if ($module->setting('username') && $module->setting('password') && $module->setting('profile')):
?>
<?php $this->load->helper('googleanalytics'); ?>
<?php analytics_view('Site Stats', 'visits', array('range' => 'week')); ?>
<?php analytics_view('Mobile Stats', 'mobile', array('range' => 'week')); ?>
<?php endif; ?>