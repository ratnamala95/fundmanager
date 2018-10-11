<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Cart extends Frontend_Controller
{	
	function __construct()
	{
		parent::__construct();
		//$this->load->library('cart');
	}

	public function index()
	{
		echo $this->checkout();
	}


	public function addcart()
	{

		$aCons = array(
					'cart_retailer_id'=>$this->session->userdata('REATILER_LOGIN_ID'),
					'cart_warehouse_id'=>$this->session->userdata('WAREHOUSE_ID'),
					'cart_distributor_id'=>$this->session->userdata('DISTRIBUTOR_ID'),
					'cart_pro_id'=>$this->input->post('cart_pro_id'),
					'cart_pro_name'=>$this->input->post('cart_pro_name'),
					'cart_pro_code'=>$this->input->post('cart_pro_code'),					
						
				);
		$rowCartdata = $this->Dbaction->getData('cart',$aCons);

		$aInvCon = array(
				'product_name'=>$this->input->post('cart_pro_id'),
			);
		$inventoryData = $this->Dbaction->getData('inventory',$aInvCon);
		$aryInventorySize = unserialize($inventoryData['size']);
		$strPricePerSet = $inventoryData['pieces_per_set'];

		$strSize = $this->input->post('cart_pro_size');
		$strQty = $this->input->post('quantity');
		$aryOrderData =  array_combine($strSize, $strQty);

		//print_r($aryOrderData);
		$aryResponse="";
		$aryResponse['errorstatus']=0;
		$aryResponse['successstatus']=0;
		foreach ($aryOrderData as $orderSizeId => $orderSizeQty) 
		{
			if (array_key_exists($orderSizeId, $aryInventorySize)) 
			{
				$availableQty = $aryInventorySize[$orderSizeId]/$strPricePerSet;
				if ($availableQty >= $orderSizeQty) {

					$aryResponse['successstatus']=1;	

				} else {

					$aryResponse['errorstatus']=1;	
					$aryResponse['message']="Quantity not available";	
				}
				
			}	
		}

	
			if ($rowCartdata && $aryResponse['errorstatus']==0) {

				$size = $this->input->post('cart_pro_size');
				$qty = $this->input->post('quantity');
				$data =  array_combine($size, $qty);
			//print_r($data);	
				
				$oldSize = unserialize($rowCartdata['cart_pro_size']);
				$newarrysize= array();
				foreach ($oldSize as $oldSizeId => $oldQtyVal) {

					if (array_key_exists($oldSizeId, $data)) {

						if ($data[$oldSizeId]) {

							$newarrysize[$oldSizeId] = ($data[$oldSizeId]);

						} else {

							$newarrysize[$oldSizeId] = $oldQtyVal;
						}
						
					} 
					
				}

				//print_r($newarrysize);

				$serializeProductData = serialize($newarrysize);
				$price	= $this->input->post('cart_pro_price');
				$totalQty =array_sum($newarrysize);
				$subtotal = $price*$totalQty;

				
				$this->db->set(['cart_pro_size'=> $serializeProductData ]);
				$this->db->set(['cart_pro_qty'=> $totalQty]);
				$this->db->where('cart_id', $rowCartdata['cart_id']);
				$this->db->update('cart');


			} elseif($aryResponse['errorstatus']==0) {

				$size = $this->input->post('cart_pro_size');
				$qty = $this->input->post('quantity');
				$price	= $this->input->post('cart_pro_price');
				$totalQty =array_sum($this->input->post('quantity'));
				$subtotal = $price*$totalQty;
				$data =  array_combine($size, $qty);
				$productSize = serialize($data);

				$aVals = array(

						'cart_retailer_id'=>$this->session->userdata('REATILER_LOGIN_ID'),
						'cart_warehouse_id'=>$this->session->userdata('WAREHOUSE_ID'),
						'cart_distributor_id'=>$this->session->userdata('DISTRIBUTOR_ID'),
						'cart_pro_id'=>$this->input->post('cart_pro_id'),
						'cart_pro_name'=>$this->input->post('cart_pro_name'),
						'cart_pro_slug'=>$this->input->post('cart_pro_slug'),
						'cart_pro_code'=>$this->input->post('cart_pro_code'),
						'cart_pro_size'=>$productSize,
						'cart_pro_price'=>$price,
						'cart_pro_qty'=>$totalQty,
	 					'cart_pro_image'=>$this->input->post('cart_pro_image'),
						

					);

				$this->Dbaction->adddata('cart',$aVals);

			}

		echo json_encode($aryResponse);
		
	}


public function checkquantityavailable()
{
		

		$productId = $this->input->post('proId');
		$productSize = $this->input->post('proSize');
		$productQty = $this->input->post('qty');
	
		// fetch inventory data according to product id
		$aCon= array(
						'product_name' => $this->input->post('proId'),
					);
		$rowInventoryData = $this->Dbaction->getData("inventory",$aCon);
		$piecesPerSet = $rowInventoryData['pieces_per_set'];
		$aryInventorySize = unserialize($rowInventoryData['size']);
		

		//print_r($rowInventoryData);

			$aryResponse= array();
		
			foreach ($aryInventorySize as $inventorySize => $inventoryQty) {

				if ($inventorySize==$productSize) {
					

					$totalAvailabelSet = $inventoryQty/$piecesPerSet;
					$totalAvailabelSet = number_format((int)$totalAvailabelSet);
					
					if ($totalAvailabelSet>=$productQty) {
						
						$aryResponse['status']=1;						
						$aryResponse['message']="Quuantity updated";
					} else {
						$aryResponse['totalqtyavailable']=$totalAvailabelSet;
						$aryResponse['status']=0;
						$aryResponse['message']="Quuantity not available";

					}

				}

			}

	echo json_encode($aryResponse);

}



public function updatecart()
{

	if ($this->input->post()) 
	{	

		//print_r($this->input->post());


		$cartId = $this->input->post('cartId');
		$proId = $this->input->post('proId');
		$proSize = $this->input->post('proSize');
		$qty = $this->input->post('qty');

		$aInventoryCons= array(

					'product_name'=>$proId
				);
		$aInventoryJoins = array(
					'products'=>'products.id=inventory.product_name',
				);

			
		$inventorydata = $this->Dbaction->getSingleData("inventory","",$aInventoryCons,$aInventoryJoins);
		$piecesPerSet = $inventorydata['pieces_per_set'];
		$arySizeInventoryData = unserialize($inventorydata['size']);
		$gstPercent = $inventorydata['gst'];



												


		//print_r($arySizeInventoryData);

		foreach ($arySizeInventoryData as $key => $value) {

			if ($key==$proSize) {

				$aryResponse=array();
				//$totalAvailabelSet = number_format($value/$piecesPerSet);
				$totalAvailabelSet = $value/$piecesPerSet;
				$totalAvailabelSet = number_format((int)$totalAvailabelSet);
				if ($totalAvailabelSet>=$qty && $qty!=0) {

					$aCartConditions= array(
									'cart_id' => $cartId,
								);

					$rowCartData = $this->Dbaction->getData("cart",$aCartConditions);
					//$setPerPiece = $rowCartData['pieces_per_set'];
					$newprice = ($rowCartData['cart_pro_price'])*($qty*$piecesPerSet);

					$oldsizedata = unserialize($rowCartData['cart_pro_size']);
					$newarraysize = array();

					//print_r($oldsizedata);
					$newsizearray = array();
					foreach ($oldsizedata as $oldsizeid => $oldsizeqty) {

						if ($oldsizeid==$proSize) {

							$newsizearray[$oldsizeid] = $qty;

						} else {

							$newsizearray[$oldsizeid] = $oldsizeqty;

						}
						
					}

					//print_r($newsizearray);
					
					$newSizeData = serialize($newsizearray);
					$totalQty = array_sum($newsizearray);


					$aCons = array(
									'cart_id'=>$cartId
								);

					$aVals = array(
								'cart_pro_size'=>$newSizeData,
								'cart_pro_qty'=>$totalQty,
							);

					$updateCartData = $this->Dbaction->updateData("cart",$aVals,$aCons);

					if ($updateCartData) {

						$cartdata = $this->cartData();
						$subtotalPrice=0;
						$subprice=0;
						$totalgstprices=0;
						foreach ($cartdata['cartproduct'] as  $resultCartProduct) {

							$subprice = $resultCartProduct['cart_pro_price']*($resultCartProduct['cart_pro_qty']*$resultCartProduct['pieces_per_set']);
							$subtotalPrice = $subtotalPrice + $subprice;
							$gst=($subprice*$resultCartProduct['gst'])/100;
							$totalgstprices = $totalgstprices + $gst; 

						}
						$totalprices=$subtotalPrice+$totalgstprices;
						$gstprice = ($newprice*$gstPercent)/100;

						$aryResponse['status']=1;
						$aryResponse['message']=" Quantity updated";
						$aryResponse['price'] = number_format($newprice,2);
						$aryResponse['gstprice']= number_format($gstprice,2);
						$aryResponse['totalgstprice']= number_format($totalgstprices,2);
						$aryResponse['subtotalprice'] = number_format($subtotalPrice,2);
						$aryResponse['totalprices'] = number_format($totalprices,2);

					} else {

						$aryResponse['totalqtyavailable']=$totalAvailabelSet;
						$aryResponse['status']=0;
						$aryResponse['message']=" Error !! something wrong";
					}


				} else {
					$aryResponse['status']=0;
					$aryResponse['totalqtyavailable']=$totalAvailabelSet;
					$aryResponse['message']="Quantity not available";	
				}	

				echo json_encode($aryResponse);	
			}
		}


	}


}	



	public function checkout()
	{
		$data = $this->cartData();
		$this->load->view("checkout_view", $data);
	}

	


	public function cartData()
	{
		/*$aCons = array(

					'cart_retailer_id'=>$this->session->userdata('REATILER_LOGIN_ID'),
					'cart_warehouse_id'=>$this->session->userdata('WAREHOUSE_ID'),
						
				);
		$aJoins = array(
					'inventory'=>'inventory.product_name=cart.cart_pro_id',
					'products'=>'products.id=inventory.product_name'
					
				);
		$data['cartproduct'] = $this->Dbaction->getAllData('cart',"*",$aCons,$aJoins);*/


		$rowData = $this->db->query('SELECT * FROM cart LEFT JOIN products ON products.id=cart.cart_pro_id LEFT JOIN inventory ON inventory.product_name=cart.cart_pro_id GROUP BY cart_pro_id ORDER BY cart.cart_id DESC');
		$data['cartproduct'] = $rowData->result_array();
	


		$data['totalproductcart'] = $this->productcartcount();
		//$data['catrow'] = $this->Dbaction->getAllData("category","",['status'=>1],"",7);

		return $data;
	}


	


	public function removecart()
	{
		//$aryResponse= array();

		$cartId = $this->input->post('cart_id');
		$sizeId =$this->input->post('sizeId');
			

		$aCons = array(
					'cart_id' => $cartId,
					'cart_retailer_id' =>$this->session->userdata('REATILER_ID')
				);
		$cartRemoveData = $this->Dbaction->getData('cart',$aCons);
		$cartSizeData = unserialize($cartRemoveData['cart_pro_size']);

		$newsizearray=array();
		foreach ($cartSizeData as $cartSizeId => $cartSizeQty) {

			if ($cartSizeId == $sizeId) {
				$newsizearray[$cartSizeId]=0;
			} else {

				$newsizearray[$cartSizeId]=$cartSizeQty;
			}
			
		}
	//print_r($newsizearray);	
		$totalQty = array_sum($newsizearray);

		if ($totalQty) {

			$aVals = array(
					'cart_pro_size'=>serialize($newsizearray),
					'cart_pro_qty'=>$totalQty,
				);
			$updateCartData = $this->Dbaction->updateData("cart",$aVals,$aCons);

		} else {

			$this->Dbaction->deleteData('cart',$aCons);
		}

		

	
	}



}

?>