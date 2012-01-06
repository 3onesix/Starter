<?php $this->load->helper('googleanalytics'); ?>
<?php analytics_view('Site Stats', 'visits', array('range' => 'week')); ?>
<?php analytics_view('Mobile Stats', 'mobile', array('range' => 'week')); ?>
