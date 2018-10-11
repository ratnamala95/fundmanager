<?php defined("BASEPATH") OR exit("No direct script access allowed");

/**
* 
*/
class Checkout extends Frontend_Controller
{
	
	function __construct()
	{
		parent::__construct();
		//$this->cart->destroy();
	}


	public function index()
	{
		//$this->Dbaction->sendInvoiceTemplatePlaceOrders(18);
		//print_r($this->cart->contents());
		$aBillingCons = array(
			'customers_id'=>$this->session->userdata('REATILER_LOGIN_ID'),
			'wrehouse_id'=>$this->session->userdata('WAREHOUSE_ID'),
		);
		$aBillingOrder = array(
			'trans_date'=>'DESC',
		);
		$data['aBillingAddress'] = $this->Dbaction->getSingleData('orders','billing_name,billing_email,billing_phone,billing_address,billing_postcode,billing_city',$aBillingCons,'',$aBillingOrder);

	

		$aCons = array(

					'cart_retailer_id'=>$this->session->userdata('REATILER_LOGIN_ID'),
					'cart_warehouse_id'=>$this->session->userdata('WAREHOUSE_ID'),
						
				);
		$aJoins = array(
					'products'=>'products.id=cart.cart_pro_id',
					'inventory'=>'inventory.product_name=cart.cart_pro_id'
				);
		$data['cartproduct'] = $this->Dbaction->getAllData('cart',"*",$aCons,$aJoins);

		$data['cityrow'] = $this->Dbaction->getAllData("city","",['status'=>"1"]);

		$data['totalproductcart'] = $this->productcartcount();
		//$data['catrow'] = $this->Dbaction->getAllData("category","",['status'=>1],"",7);
		$this->load->view('checkout_billing_view', $data);

	}


	public function transaction()
	{
		
		$this->form_validation->set_rules('billing_name','Billiing name' ,'required');
		$this->form_validation->set_rules('billing_email','Billing email','trim|required|valid_email');
		$this->form_validation->set_rules('billing_phone','Billing phone','required|exact_length[10]');
		$this->form_validation->set_rules('billing_city','Billing city','required');
		$this->form_validation->set_rules('billing_address','Billing address','required');
		$this->form_validation->set_rules('billing_postcode','Billing postcode','required');

		
		if ($this->form_validation->run()) {
			
			if ($this->session->userdata('REATILER_ID')) {
				
				$orderdata['wrehouse_id'] = $this->session->userdata('WAREHOUSE_ID');
				$orderdata['distributor_id'] = $this->session->userdata('DISTRIBUTOR_ID');
				$orderdata['customers_id'] = $this->session->userdata('REATILER_LOGIN_ID');
				$orderdata['customers_name'] = $this->session->userdata('REATILER_LOGIN_NAME');
				$orderdata['customers_email'] = $this->session->userdata('REATILER_LOGIN_EMAIL');
				$orderdata['customer_type'] = "1";
				$orderdata['customer_trans_order_id']="ORDER".rand(0,99).time();

			} else {

				$orderdata['customer_type']="guest";
			}

			$orderdata['billing_name']=$this->input->post('billing_name');
			$orderdata['billing_email']=$this->input->post('billing_email');
			$orderdata['billing_phone']=$this->input->post('billing_phone');
			$orderdata['billing_city']=$this->input->post('billing_city');
			$orderdata['billing_address']=$this->input->post('billing_address');
			$orderdata['billing_postcode']=$this->input->post('billing_postcode');
			$orderdata['order_total']=$this->input->post('total');
			$orderdata['orders_status']=0;

			$lastInsertId = $this->Dbaction->adddata('orders',$orderdata);


			
			foreach ($this->input->post('id') as $key=>$items) {

				$detailsData['od_order_id'] = $lastInsertId;
				$detailsData['od_cust_id'] = $this->session->userdata('REATILER_LOGIN_ID');
				$detailsData['od_warehouse_id'] = $this->session->userdata('WAREHOUSE_ID');
				$detailsData['od_product_id']=$items;
				$detailsData['od_product_name']=$this->input->post('name')[$key];
				$detailsData['od_product_code']=$this->input->post('code')[$key];
				$detailsData['od_product_price']=$this->input->post('price')[$key];
				$detailsData['od_product_qty']=$this->input->post('qty')[$key];
				$detailsData['od_size']=$this->input->post('size')[$key];
				$detailsData['od_subtotal']=$this->input->post('sub_total')[$key];			

				$this->Dbaction->adddata('orders_details',$detailsData);


		// data insert in transaction table and update  Inventory table
			/*
				$inventory  = array(
							$this->input->post('size')[$key]=>$this->input->post('qty')[$key]
						);			

				$transData['order_id'] = $lastInsertId;
				$transData['user_id'] = $this->session->userdata('REATILER_LOGIN_ID');
				$transData['warehouse_id'] = $this->session->userdata('WAREHOUSE_ID');
				$transData['inventory']=serialize($inventory);
				$transData['flag']=0;
				$transData['product_id']=$items;
				$transData['product_code']=$this->input->post('code')[$key];	

				$this->Dbaction->adddata('transactions',$transData);

				//echo $this->db->last_query();
				//die();
				
				$this->updateInventoryData($items,$this->input->post('size')[$key],$this->input->post('qty')[$key]);
			*/	
		// insert data in transaction table			

			}

// email send to user start	
		
			$strUserName = $this->input->post('billing_name');
			$strUserMessage='<p>Thank you for shopping with us. we have received your order. We will process your order as soon as possible</p>';
			
			$strFullMessage =$this->Dbaction->emailTemplate($strUserName,$strUserMessage);
			$this->Dbaction->sendEmail($this->input->post('billing_email'),'Order success',$strFullMessage);
	//send email invoice to user
			$this->Dbaction->sendInvoiceTemplatePlaceOrders($lastInsertId); 

// email send to user end



// email send to distributor start	
	$distributorId = $this->session->userdata('DISTRIBUTOR_ID');

	$data = $this->Dbaction->getData('users',['id'=>$distributorId]);

	
	$distName = $data['name'];
	$strDistMessage = '<p> You have recived a order. Please confirm this order for next processing. </p>';
	
	$strFullDistMessage =$this->Dbaction->emailTemplate($distName,$strDistMessage);
	$this->Dbaction->sendEmail($data['email'],'Order received',$strFullDistMessage);


// email send to distributor start	

	// delete cart table items when order submit successfully
			$cartdeletecondition = array(
									'cart_warehouse_id' => $this->session->userdata('WAREHOUSE_ID'),
									'cart_retailer_id' => $this->session->userdata('REATILER_LOGIN_ID')
									);
				$this->Dbaction->deleteData('cart',$cartdeletecondition);

			//$this->cart->destroy();
			redirect('checkout/successorder');

		} else {

			echo $this->index();
			//redirect('checkout');
		}

		

		
		
	}



	public function updateInventoryData($proId,$proSize,$proQty)
	{
		$aCons=array(
				"product_name"=>$proId,
			);
		$data = $this->Dbaction->getSingleData("inventory",'*',$aCons);
//print_r($data);
		$aryAttrData = unserialize($data['size']);

		$newAry=array();
		foreach ($aryAttrData as $key => $value) {
			if ($key==$proSize) {

				$aryAttrData[$proSize]=($value-$proQty);
			}
		}


		$aVals['size'] =serialize($aryAttrData);
		$aCons= array(
					'id'=>$data['id'],
				);		
		$this->Dbaction->updateData("inventory",$aVals,$aCons);
	}



	public function successorder()
	{
		$data['totalproductcart'] = $this->productcartcount();
		//$data['catrow'] = $this->Dbaction->getAllData("category","",['status'=>1],"",7);
		$this->load->view('order_success_view',$data);
	}
}

?>