<?php defined('BASEPATH') OR exit('No direct script access allowed');



class Product extends Frontend_Controller
{
	
	function __construct()
	{
		parent::__construct();
		//secho "hello";

	}


	public function index()
	{
		$productslug = $this->uri->segment(2);

		if ($this->uri->segment(2)) {

			$aJoins = array(
				'category' => 'products.category = category.id',
				'inventory' => 'products.id = inventory.product_name'
			);

			//$acondition
			//
			if ($this->session->userdata('REATILER_ID')) {

				$acondition['warehouse_id']=$this->session->userdata('WAREHOUSE_ID');
			}

			$acondition['products.slug']=$productslug;
			$acondition['products.status']=1;
			$acondition['upcomming']=0;


					
			$data['productResults'] = $this->Dbaction->getSingleData("products","products.*,category.name as category_name,inventory.price AS price, inventory.sale_price AS sale_price, inventory.size AS size,pieces_per_set,gst",$acondition,$aJoins);

			

		}
	
		$filter["category.id"] = $data['productResults']['category'];
		$filter["products.id !=  "] = $data['productResults']['id'];
			
		if ($this->session->userdata('REATILER_ID')) {

		    $filter['warehouse_id']=$this->session->userdata('WAREHOUSE_ID');
	    }	
	
		$aOrders=array('timestamp','DESC');
		$aJoins = array(
			'category' => 'products.category = category.id',
			'inventory' => 'products.id = inventory.product_name'
		);
	
		$data['totalrow'] = $this->Dbaction->getAllData("products","products.*,category.name as category_name",$filter,$aJoins,'',$aOrders);

	
		$url = 'product/'.$this->uri->segment(2);
		$strLimit=4;
		$searchpagination = $this->Dbaction->pagination(base_url($url),count($data['totalrow']),$strLimit,base_url($url));
	
		
		$data['productrowdata'] = $this->Dbaction->getAllData("products","products.*,category.name as category_name,inventory.price AS price, inventory.sale_price AS sale_price,pieces_per_set,gst",$filter,$aJoins,$strLimit,$aOrders,$this->uri->segment(3));
		
		$data['aRowImage'] = $this->Dbaction->getAllData('images','',['img_product_id'=>$data['productResults']['id']],'',4,$aOrders=array('img_id'=>'DESC'));		
		
		$data['totalproductcart'] = $this->productcartcount();
		$data['rowattrdata']  = $this->Dbaction->getAllData("attributes",'',array("status" => 1));	
		
		//$data['catrow'] = $this->Dbaction->getAllData("category","",['status'=>1],"",7);
		$this->load->view('product_view',$data);


	}


	

}


?>