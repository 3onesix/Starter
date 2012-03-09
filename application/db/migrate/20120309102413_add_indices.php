<?php
class Add_Indices
{
	function up()
	{
		$CI =& get_instance();
		$CI->db->query('ALTER TABLE `pages` ADD INDEX (`page_id`)');
		$CI->db->query('ALTER TABLE `pages` ADD INDEX (`slug`)');
		
		$CI->db->query('ALTER TABLE `page_modules` ADD INDEX (`page_id`)');
		
		$CI->db->query('ALTER TABLE `module_files` ADD INDEX (`module_id`)');
		$CI->db->query('ALTER TABLE `module_files` ADD INDEX (`include_on_page`)');
		
		$CI->db->query('ALTER TABLE `page_variables` ADD INDEX (`page_id`)');
		$CI->db->query('ALTER TABLE `page_variables` ADD INDEX (`page_variable_id`)');
		
		$CI->db->query('ALTER TABLE `templates` ADD INDEX (`file`)');
	}
}