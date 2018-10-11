<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Backend_Controller {

	
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->content = 'dashboard';
		$this->title   = 'Dashboard';
		$this->data    = array();
		$this->layout();		
	}

	public function setting()
	{
		if($this->input->post('val'))
		{	
			$aVals = $this->input->post('val');
			foreach ($aVals as $aKey => $aVal)
			{
				$this->Dbaction->updateData('setting',array("option_value" => $aVal),array('option_key' => $aKey));
			}
			$this->session->set_flashdata('message', array('message' => 'Settings updated successfully','class' => 'alert-success'));
			redirect(getSiteUrl('dashboard/setting'), 'refresh');
		}
		$aRows = $this->Dbaction->getAllData("setting");
		$this->content = 'setting';
		$this->title   = 'Settings';
		$this->data    = array("aRows" => $aRows);
		$this->layout();		
	}

	
}
