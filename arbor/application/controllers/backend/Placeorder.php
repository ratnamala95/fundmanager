<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Placeorder extends Backend_Controller {
	function __construct()
	{
		parent::__construct();
		$this->tblName = "orders";
	}

	public function index()
	{
		

		$distributorId = $this->session->userdata('admin_user')->id;
		$cityId = $this->session->userdata('admin_user')->city_id;
		$aCond = array(
					'products.status'=>1,
					'products.upcomming'=>0,
					'users.city_id'=>$cityId
				);	
		$aJoin = array(
					'products'=>'products.id=inventory.product_name',
					'users'=>'users.id=inventory.warehouse_id'
				);

		$aRowProduct = $this->Dbaction->getAllData('inventory','inventory.id AS id,inventory.size AS size,products.name as name,products.status AS status, products.upcomming AS upcomming',$aCond,$aJoin,'',['name','ASC']);
		
		$aUserCond = array(
					'distributor_id'=>$distributorId,
					'status'=>1
				);
		$aRowRetailer = $this->Dbaction->getAllData('users','users.id,users.name,users.status',$aUserCond);


		$this->content = 'placeorder/index';
		$this->title   = 'place order';
		$this->data    = array('aRowProduct'=>$aRowProduct,'aRowRetailer'=>$aRowRetailer);
		$this->layout();
	}

	public function ajxdata()
	{
	
		$aryResponse=array();
		$strHtml='';
		$cityId = $this->session->userdata('admin_user')->city_id;
		if ($this->input->post('inventoryId')) {
			$aryResponse['status']=1;
			$invId = $this->input->post('inventoryId');
			$aCond = array(
					'inventory.id' => $invId,
					'products.status' => 1,
					'products.upcomming' => 0,
					'users.city_id' => $cityId,
				);	
			$aJoin = array(
					'products'=>'products.id=inventory.product_name',
					'users'=>'users.id=inventory.warehouse_id'
				);
			$aRowProduct = $this->Dbaction->getSingleData('inventory','inventory.*,products.id AS product_id ,products.name AS product_name,products.code AS code,inventory.gst AS gst,inventory.pieces_per_set AS pieces_per_set',$aCond,$aJoin);
			//echo $this->db->last_query();
			//print_r($aRowProduct);
			$arySizeData = unserialize($aRowProduct['size']);
			$arySizeName=array();
			foreach ($arySizeData as $key => $value) {
				$aRowSizeData = $this->Dbaction->getSingleData('attributes','id,name',['type'=>'size','id'=>$key]);
				$arySizeName[$key]=$aRowSizeData['name'];
				
			}
			//print_r($arySizeName);
			
			/* hidden field start here */
			$strHtml.='<input type="hidden" name="od_product_id" value="'.$aRowProduct['product_id'].'">';
			$strHtml.='<input type="hidden" name="od_product_name" value="'.$aRowProduct['product_name'].'">';
			$strHtml.='<input type="hidden" name="od_product_code" value="'.$aRowProduct['code'].'">';
			$strHtml.='<input type="hidden" name="od_product_price" value="'.$aRowProduct['sale_price'].'">';
			
			/* hidden field End here */
			

			$strHtml.='<div class="form-group"><label>Product code</label><input type="text" required="" class="form-control border-input" placeholder="Product code" disabled="disabled" value="'. $aRowProduct['code']  .'"></div>';
			$strHtml.='<div class="form-group"><label>Pieces per set</label><input type="text" required="" class="form-control border-input" placeholder="Pieces per set" value="'.$aRowProduct['pieces_per_set'].'" disabled></div>';
			$strHtml.='<div class="form-group"><label>GST in percent</label><input type="text" required="" class="form-control border-input" placeholder="GST in percent" value="'.$aRowProduct['gst'].'%" disabled></div>';
			$strHtml.='<div class="form-group"><label>Product price</label><input type="text" required="" class="form-control border-input" placeholder="price" value="'.$aRowProduct['sale_price'].'" disabled></div>';


			
			$sizeOptionData='';
			if (!empty($arySizeName)) {

				foreach ($arySizeName as $id => $name) {
					$sizeOptionData.= '<option value="'.$id.'">'.$name.'</option>';
				}

				$strHtml.='<div class="form-group"><label>Choose Size</label><select id="size" name="size" required="required" onchange="qtyfind($(this),'.$invId.')" class="form-control border-input"><option value="">select Size</option>'.$sizeOptionData.'</select></div>';

			}

					

			$aryResponse['message']=$strHtml;					
		}

		echo json_encode($aryResponse);
	}

	public function ajxqtyfind()
	{
		$aryResponse=array();
		$aryResponse['status']=0;
		$strHtml='';

		if (!empty($this->input->post('sizeId')) && !empty($this->input->post('inventoryId'))) {
			$aryResponse['status']=1;
			$sizeId = $this->input->post('sizeId');
			$invId = $this->input->post('inventoryId');
			$aCond = array(
					'inventory.id' => $invId,					
				);	
			$aRowProduct = $this->Dbaction->getSingleData('inventory','inventory.size AS size,inventory.pieces_per_set AS pieces_per_set',$aCond);

			$strPiecesPerSet = $aRowProduct['pieces_per_set'];
			$arySizeData = unserialize($aRowProduct['size']);
			if ($arySizeData) {
				foreach ($arySizeData as $key => $value) {
					if ($key==$sizeId) {
						$strQty= $value;
					}
				}
			}
			//number_format((int)$availableSet);
			$sizeOptionData="";
			if (!empty($strQty) && $strQty>=$strPiecesPerSet) {
				$totalAvailableSet= $strQty/$strPiecesPerSet;
				
				for ($i=1; $i <= $totalAvailableSet ; $i++) { 
					$sizeOptionData.= '<option value="'.$i.'">'.$i.'</option>';
				}

				
			} else {
				$sizeOptionData.= '<option value="">Quantity not available</option>';
			}

			$strHtml.='<div class="form-group"><label>Choose Qty</label><select id="qty" name="qty" onchange="findprice($(this),'.$invId.')" required="required" class="form-control border-input"><option value="">select Qty</option>'.$sizeOptionData.'</select></div>';	
			
			$aryResponse['message']=$strHtml;
		}

		echo json_encode($aryResponse);
	}


	public function ajxpricefind()
	{
		$strHtml='';
		$aryResponse= array();
		$aryResponse['status']=0;
		$qty = $this->input->post('qty');
		$invId = $this->input->post('inventoryId');
		$aCond = array(
					'inventory.id' => $invId,					
				);	
		$aRowProduct = $this->Dbaction->getSingleData('inventory','inventory.pieces_per_set AS pieces_per_set,inventory.gst AS gst,inventory.size AS size,inventory.pieces_per_set AS pieces_per_set,inventory.sale_price AS price',$aCond);
		if (!empty($aRowProduct)) {
			$aryResponse['status']=1;
			$strGst = $aRowProduct['gst'];
			$strProPrice = $aRowProduct['price'];
			$piecesPerSet = $aRowProduct['pieces_per_set'];

			$totalPieces= $qty*$piecesPerSet;
			$subTotalPrice=$strProPrice*$totalPieces;
			$gstPrice =($subTotalPrice*$strGst)/100;
			$grandTotalPrice = $subTotalPrice+ $gstPrice;

			/* hidden field start here */
			$strHtml.='<input type="hidden" name="total_price" value="'.$subTotalPrice.'">';
			$strHtml.='<input type="hidden" name="grand_price" value="'.$grandTotalPrice.'">';
			/* hidden field End here */

			$strHtml.='<div class="form-group"><label>Sub total Price</label><input type="text" required="" class="form-control border-input" placeholder="Sub total Price" value="'.$subTotalPrice.'" disabled></div>';
			$strHtml.='<div class="form-group"><label>GST Price</label><input type="text" required="" class="form-control border-input" placeholder="GST Price" value="'.$gstPrice.'" disabled></div>';
			$strHtml.='<div class="form-group"><label>Grand Total Price</label><input type="text" required="" class="form-control border-input" placeholder="Grand Total Price" value="'.$grandTotalPrice.'" disabled></div>';
		}

		$aryResponse['message']=$strHtml;

		echo json_encode($aryResponse);
	}

	public function order() 	
	{

		if (!empty($this->input->post())) {

			

			$this->form_validation->set_rules('placeorderfor','Place Order for' ,'required');
			$this->form_validation->set_rules('od_product_id','Product Name','trim|required');
			$this->form_validation->set_rules('size','Product Size','required');
			$this->form_validation->set_rules('qty','Product Qty','required');
			

			if ($this->form_validation->run()) {

				$distributorId = $this->session->userdata('admin_user')->id;
				$warehouseId = $this->session->userdata('admin_user')->warehouse_id;
				$customerName = $this->session->userdata('admin_user')->name;
				$customerEmail = $this->session->userdata('admin_user')->email;
				
				if (!empty($this->input->post('retailerId'))) {
					$retailerId = $this->input->post('retailerId');
					$aRowUser = $this->Dbaction->getSingleData('users','',['id'=>$retailerId]);
					$orderdata['distributor_id'] = $distributorId;
					$orderdata['wrehouse_id'] = $aRowUser['warehouse_id'];
					$orderdata['customers_id'] = $retailerId;
					$orderdata['customers_name'] = $aRowUser['name'];
					$orderdata['customers_email'] = $aRowUser['email'];

					// order Details data insert 
					$detailsData['od_cust_id'] = $retailerId;
					$detailsData['od_warehouse_id'] = $aRowUser['warehouse_id'];
					
				} else {
					$orderdata['distributor_id'] = $distributorId;
					$orderdata['wrehouse_id'] = $warehouseId;
					$orderdata['customers_id'] = $distributorId;
					$orderdata['customers_name'] = $customerName;
					$orderdata['customers_email'] = $customerEmail;

					// order Details data insert 
					$detailsData['od_cust_id'] = $distributorId;
					$detailsData['od_warehouse_id'] = $warehouseId;

					
				}

			
				
			/*
				$orderdata['billing_name']=$this->input->post('billing_name');
				$orderdata['billing_email']=$this->input->post('billing_email');
				$orderdata['billing_phone']=$this->input->post('billing_phone');
				$orderdata['billing_city']=$this->input->post('billing_city');
				$orderdata['billing_address']=$this->input->post('billing_address');
				$orderdata['billing_postcode']=$this->input->post('billing_postcode'); */
				
				$orderdata['customer_type'] = "1";
				$orderdata['customer_trans_order_id']="ORDER".rand(0,99).time();
				$orderdata['order_total']=$this->input->post('grand_price');
				$orderdata['orders_status']=0;

		
				$lastInsertId = $this->Dbaction->adddata('orders',$orderdata);
				

				// order details data insert
				$aryActulSize=array();
				$strSize = $this->input->post('size');
				$strQty = $this->input->post('qty');
				$aryActulSize[$strSize] = $strQty;
				
				$detailsData['od_order_id'] = $lastInsertId;
				$detailsData['od_product_id']=$this->input->post('od_product_id');
				$detailsData['od_product_name']=$this->input->post('od_product_name');
				$detailsData['od_product_code']=$this->input->post('od_product_code');
				$detailsData['od_product_price']=$this->input->post('od_product_price');
				$detailsData['od_product_qty']=$strQty;
				$detailsData['od_size']=serialize($aryActulSize);
				$detailsData['od_subtotal']=$this->input->post('total_price');			

				$this->Dbaction->adddata('orders_details',$detailsData);

			}			
		}
		redirect(getSiteUrl('order'), 'refresh');
		//echo $this->index();		
	}


}
?>