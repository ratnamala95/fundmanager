<?php defined("BASEPATH") OR die("direct path not access");

/**
* 
*/
class About extends Frontend_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}


	public function index()
	{
		$data['totalproductcart'] = $this->productcartcount();
		$this->load->view('about_view',$data);
	}
}

?>