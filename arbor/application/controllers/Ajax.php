<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Ajax extends Frontend_Controller
{
	public function __construct()
	{
		parent::__construct();
	}



	public function filterbyattribute()
	{
		

		$sizeId="";
		$styleId="";
		$codeId="";
		$filterbycategory="";

		

		
		if ($this->input->post('searchkey')) {

			$searchbykey = $this->input->post('searchkey');
			$this->session->set_userdata(['filterbysearchkey'=>$searchbykey]);
			
		}

		if ($this->input->post('categoryslug')) {

			$filterbycategory = $this->input->post('categoryslug');
			$this->session->set_userdata(['filterprobycategory'=>$filterbycategory]);

		} 

		if ($this->input->post('startrange') && $this->input->post('endrange')) {

			$this->session->set_userdata(['startrange'=>$this->input->post('startrange')]);
			$this->session->set_userdata(['endrange'=>$this->input->post('endrange')]);
		}

		if ($this->session->userdata('filterprobycategory')=="") {
				
			$filterbycategory = $this->input->post('catslug');
			$this->session->set_userdata(['filterprobycategory'=>$filterbycategory]);
		}



		if ($this->input->post('sizeId')) {

			$sizeId = $this->input->post('sizeId');
			$this->session->set_userdata(['filtersize'=>$sizeId]);
					
		}

		if ($this->input->post('styleId')) {

			$styleId = $this->input->post('styleId');
			$this->session->set_userdata(['filterstyle'=>$styleId]);
		}

		if ($this->input->post('codeId')) {

			$codeId = $this->input->post('codeId');
			$this->session->set_userdata(['filtercode'=>$codeId]);
		}

		
		if ($this->input->post('filterprice')) {

			$filterprice = $this->input->post('filterprice');
			$this->session->set_userdata(['filterprice'=>$filterprice]);
		}
	
			
		$this->load->model('searchmodel');
		$data['productrowdata'] = $this->searchmodel->filterattrdata($filterbycategory,$sizeId,$styleId,$codeId);

						
		$this->load->view('product_filter_view',$data);
		//return json_encode(array('code'=>1,'message'=>'success'));
		//die;
	}



	public function productcheckavailable()
	{
		if ($this->input->post('productId')) {
			
			$proId = $this->input->post('productId');
			$acons = array(

					'product_name'=>$proId

				);
			$aJoins = array();
					
			$data = $this->Dbaction->getSingleData('inventory','',$acons,$aJoins);

		//echo "<pre>";	
		//print_r($data['size']); die();

			if ($this->input->post('sizeId') && $this->input->post('qty')) {

				$qty = $this->input->post('qty');
				$sizeId = $this->input->post('sizeId');
				$arySizeData = unserialize($data['size']);

			
				foreach ($arySizeData as $key => $value) {
					if ($sizeId==$key) {

						$aryResponse=array();
						if ($value!=0 && $value>=$qty) {
						
							$aryResponse['status']=1;
							$aryResponse['message']="";
							$aryResponse['cartsuccessbtn']='<button onclick="addtocart()" class="add-to-cart btn btn-default" id="cartbtn" type="button">add to cart</button>';
	
							
						} else {
						
							$aryResponse['status']=0;
							$aryResponse['message']="In this size quantity Not available";
							$aryResponse['carterrorbtn']='<button class="add-to-cart btn btn-default" id="cartbtn" type="button">Quantity Not available</button>';

							
						}

					echo json_encode($aryResponse);	
						
					}
					
				}			
			} else {
				$aryResponse=array();
				if (empty($this->input->post('sizeId'))) {
					$aryResponse['status']=0;
					$aryResponse['carterrorbtn']="";
					$aryResponse['message']="please Select size";
				}

				if (empty($this->input->post('qty'))) {
					$aryResponse['status']=0;
					$aryResponse['carterrorbtn']="";
					$aryResponse['message']="please select Quantity";
				}

				echo json_encode($aryResponse);
			}

		}	

	}


}

?>