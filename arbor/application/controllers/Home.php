<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Frontend_Controller {

	function __construct() 
  	{
  		parent::__construct();
   		$this->tblPro = "products";
   		$this->tblCat = "category";
   		   		

 	}


	public function index()
	{
		if ($this->session->userdata('REATILER_ID')) {

			$acondition['warehouse_id']=$this->session->userdata('WAREHOUSE_ID');
		}
		
		$aOrders=array('timestamp','DESC');
		$aJoins = array(
				'category' => 'products.category = category.id',
				'inventory' => 'products.id = inventory.product_name'
			);
		$acondition['products.status']=1;
		$acondition['upcomming']=0;


			
		$data['totalrow'] = $this->Dbaction->getAllData($this->tblPro,"products.*,category.name as category_name",$acondition,$aJoins,'',$aOrders);



		$this->Dbaction->pagination(base_url('welcome/index'),count($data['totalrow']),6,base_url('welcome'));

		
		
		$data['productRowData'] = $this->Dbaction->getAllData($this->tblPro,"products.*,category.name as category_name,inventory.price AS price, inventory.sale_price AS sale_price,inventory.gst AS GST_PRICE",$acondition,$aJoins,6,$aOrders,$this->uri->segment(3));

	//	echo $this->db->last_query();

			
		$data['totalproductcart'] = $this->productcartcount();


		//$data['catrow'] = $this->Dbaction->getAllData("category","",['status'=>1],"",7);
		
		$this->load->view('index',$data);

	}


}
