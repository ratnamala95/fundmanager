<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->library('Aauth');
		$this->load->helper('url');
	}

	public function index()
	{
		$data['admin_data'] = $this->checkAccess();

		$this->load->view('layout/header',$data);
		$this->load->view('welcome_message',$data);
		$this->load->view('layout/footer',$data);
	}

	/**
	*to verify whether user is logged in!
	*@param void
	*@return mixed
	**/

	function checkAccess()
	{
		if($this->aauth->is_loggedin()){
			return $this->session->all_userdata();
		}else {
			redirect('auth/login');
		}
	}

}
