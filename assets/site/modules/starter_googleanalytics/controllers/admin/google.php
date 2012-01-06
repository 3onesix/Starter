<?php

class Google extends MY_Controller
{
	protected $require_login = TRUE;
	
	public function __construct()
	{
		parent::__construct();
		
		$this->module = $this->module_model->first(array('simple_name' => 'starter_googleanalytics'));
		
		$this->load->helper('googleanalytics');
		
		$this->load->library('GoogleAnalytics', array(
			'email' => $this->module->setting('username'),
			'password' => $this->module->setting('password')
		));
		$this->googleanalytics->setProfile('ga:'.$this->module->setting('profile'));
	}
	
	function action_index()
	{
		echo $this->load->view('admin/_header', null, true);
		analytics_view('Visits for the last month', 'visits', array('range' => 'week'));
		echo $this->load->view('admin/_footer', null, true);
	}
	
	function get($dimensions, $metrics, $sort = null, $filters = null)
	{
		$report = $this->googleanalytics->getReport(
			array(
				'dimensions' => urlencode($dimensions),
				'metrics' => urlencode($metrics),
				'sort' => $sort ? urlencode($sort) : '',
				'filters' => $filters ? urlencode($filters) : ''
			)
		);
		return $report;
	}
	
	function action_api($method = 'visits') {
		//figure out date range
		if ($this->input->get('date-from') && $this->input->get('date-to'))
		{
			$this->googleanalytics->setDateRange($this->input->get('date-from'), $this->input->get('date-to'));
		}
		elseif ($this->input->get('range'))
		{
			switch ($this->input->get('range')) {
				case 'today':
					$today = date('Y-m-d', time());
					$this->googleanalytics->setDateRange($today, $today);
				break;
				case 'week':
					$from = date('Y-m-d', strtotime('Today - 7 days'));
					$to   = date('Y-m-d', time());
					$this->googleanalytics->setDateRange($from, $to);
				break;
				case 'month':
					$from = date('Y-m-d', strtotime('Today - 30 days'));
					$to   = date('Y-m-d', time());
					$this->googleanalytics->setDateRange($from, $to);
				break;
			}
		}
		else
		{
			$this_month = date('Y-m-01', time());
			$last_month = date('Y-m-d', strtotime($this_month.' - 1 month'));
			
			$this->googleanalytics->setDateRange($last_month, $this_month);
		}
		
		switch ($method)
		{
			case 'browsers':
				$report = $this->get('ga:browser', 'ga:visits', '-ga:visits');
			break;
			case 'mobile':
				$report = $this->get('ga:date,ga:isMobile', 'ga:visits');
			break;
			case 'page':
				if ($this->input->get('path'))
				{
					$report = $this->get('ga:date', 'ga:visits', null, 'ga:pagePath=='.$this->input->get('path'));
				}
				else
				{
					$report = $this->get('ga:pagePath', 'ga:visits');
				}
			break;
			default:
				$report = $this->get('ga:date', 'ga:uniquePageviews,ga:visits');
			break;
		}
		
		echo json_encode($report);
	}
	
}