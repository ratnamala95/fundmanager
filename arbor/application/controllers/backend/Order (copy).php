<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends Backend_Controller {
	function __construct()
	{
		parent::__construct();
		$this->tblName = "orders";
	}

	public function index()
	{
		$aVals = array();
		$aCond = array();
		if($this->input->get())
		{
			$aVals = $this->input->get('sel');

			$this->session->set_userdata(array('sel' => $aVals));
			if(isset($aVals['warehouse_id']) && $aVals['warehouse_id'] != '')
			{				
				$aCond['orders.wrehouse_id'] = $aVals['warehouse_id'];
			}
			if (isset($aVals['distributor_id']) && $aVals['distributor_id']!='') {
				$aCond['orders.distributor_id'] = $aVals['distributor_id'];
			}
			if (isset($aVals['retailer_id']) && $aVals['retailer_id']!='') {
				$aCond['orders.customers_id'] = $aVals['retailer_id'];
			}
			
		}

		


		$_SESSION['admin_user']? $aUsr = json_decode(json_encode($_SESSION['admin_user']),True):'';
		$count['counter'] = array();

		$aRows = $this->Dbaction->getAllData('orders');

		if($aRows)
		{
			foreach ($aRows as $aRow)
			{
				$count = unserialize($aRow['counter']) ;
				if($count == ''){
					$count = array();
				}

				if($count=='' || !in_array($aUsr['id'],$count)){
					array_push($count,$aUsr['id']);
					$aRow['counter'] = serialize($count);
					$this->Dbaction->updateData('orders',$aRow,array('orders_id' => $aRow['orders_id']));
				}
				else {
					// pr('got it');
					// pr('*');
				}
			}
		}
        $aJoins = array( 
					"users" => "orders.wrehouse_id = users.id"
				); 
        $aOrders = array('trans_date'=>'DESC');

		//$aJoins = array();
		$aRows = $this->Dbaction->getAllData($this->tblName,"orders.*,users.name as user_name,",$aCond,$aJoins,'',$aOrders );
		//echo $this->db->last_query();
		
		$aWare = $this->Dbaction->getAllData("users",'',array("role" => WAREHOUSE_ROLE,"status" => 1));
		$aDistributor = $this->Dbaction->getAllData("users",'',array("role" => DISTRIBUTOR_ROLE,"status" => 1));
		$aRetailer = $this->Dbaction->getAllData("users",'',array("role" => RETAILER_ROLE,"status" => 1));

		
		$this->content = 'orders/index';
		$this->title   = 'Orders';
		$this->data    = array("aRows" => $aRows,"aWare" => $aWare,'aDistributor'=>$aDistributor,'aRetailer'=>$aRetailer,'aVals'=>$aVals);
		$this->layout();
	}


	public function details( $id = 0)
	{
		if ($this->uri->segment(4)) {

		$ajoin = array('city' =>'city.id=orders.billing_city');
		$orderInfo = $this->Dbaction->getSingleData('orders','',['orders_id'=>$this->uri->segment(4)],$ajoin);
//		echo 	$this->db->last_query();die;

		$aCon = array('od_order_id'=>$this->uri->segment(4),
								 /*'od_cust_id'=>$this->session->userdata('REATILER_ID')*/);

		$aJoin = array( 'orders' => 'orders.orders_id = orders_details.od_order_id',
										'products'=>'products.id=orders_details.od_product_id',
										'inventory'=>'inventory.product_name=orders_details.od_product_id'
									);

		$orderDetails = $this->Dbaction->getAllData('orders_details','',$aCon,$aJoin);
//echo 	$this->db->last_query();die;
		}

			$this->content = 'orders/details';
			$this->title   = 'Details';
			$this->data    = array("orderInfo" => $orderInfo,"orderDetails" => $orderDetails/*,"catrow" => $catrow*/);
			$this->layout();

	}

	public function approve($id = 0)
	{
		$aUsr = json_decode(json_encode($_SESSION['admin_user']), True);
		$aVals['orders_status']=1;

		$aTran = $this->Dbaction->getCustomQuery('select * from orders_details where od_order_id = '.$id);
		foreach($aTran as $atrans)
		{
			$trans['order_id'] = $atrans['od_order_id'];
			$trans['warehouse_id'] = $atrans['od_warehouse_id'];
			$trans['user_id'] = $aUsr['id'];
			$trans['product_id'] = $atrans['od_product_id'];
			$trans['product_code'] = $atrans['od_product_code'];
//			$temp = array($atrans['od_size'] => $atrans['od_product_qty']);
			$trans['flag'] = 0;
			$trans['date'] = date('Y-m-d');

			$aRow = $this->Dbaction->getData('inventory',array('product_name' => $trans['product_id'],'warehouse_id' => $trans['warehouse_id']));

			$aRow['size'] = unserialize($aRow['size']);
			$atrans['od_size'] = unserialize($atrans['od_size']);

			foreach($atrans['od_size'] as $si => $qu)
			{
				$te[$si] = $qu*$aRow['pieces_per_set'];
			}

			$trans['inventory'] = serialize($te);

			foreach($aRow['size'] as $si => $qu)
			{
				$totalAvailabelSet[$si] = $qu/$aRow['pieces_per_set']; //14.6
				$totalAvailabelSet[$si] = number_format((int)$totalAvailabelSet[$si]); //14
			}

//			pr($totalAvailabelSet);
//			$aRow['size'] = $totalAvailabelSet;

			foreach($totalAvailabelSet as $si => $qu)
			{
				foreach($atrans['od_size'] as $tsi => $tqu)
				{
					if($si == $tsi)
					{
						if ($qu >= $tqu)
						{
							$temp[$si] = $qu - $tqu;
//							pr($temp);
						}
						else
						{
							$temp[$si] = $qu;
							$aMsg = 'Cannot Approve Order! Product quantity insufficient!';
							$this->session->set_flashdata('message', array('message' => $aMsg ,'class' => 'alert-danger'));
							redirect(getSiteUrl('order/index'), 'refresh');
						}
					}
				}
			}
			$totalAvailabelSet = $temp;

			foreach($aRow['size'] as $si => $qu)
			{
				foreach($atrans['od_size'] as $tsi => $tqu)
				{
					if($si == $tsi)
					{
						$tem[$si] = $qu - ($tqu*$aRow['pieces_per_set']);
					}
				}
			}

			$aRow['size'] = serialize($tem);


			$this->Dbaction->updateData('inventory',$aRow,array('id' => $aRow['id']));
			$this->Dbaction->adddata('transactions',$trans);

		}



		// email send to user start

			$retailerdata = $this->Dbaction->getData('orders',['orders_id'=>$id ]);
			$strUserName= $retailerdata['customers_name'];
			$strUserEmail= $retailerdata['customers_email'];
			$strUserMessage='<p>Your order has been approved. </p>';
			$strFullMessage =$this->Dbaction->emailTemplate($strUserName,$strUserMessage);
			$this->Dbaction->sendEmail($strUserEmail,'Order Confirmed',$strFullMessage);

		// email send to user end


		$this->Dbaction->updateData('orders',$aVals,array('orders_id' => $id));
		$aMsg = 'Order Approved!';
		$this->session->set_flashdata('message', array('message' => $aMsg ,'class' => 'alert-success'));
		redirect(getSiteUrl('order/index'), 'refresh');

	}

	public function disapprove($id)
	{
		$aUsr = json_decode(json_encode($_SESSION['admin_user']), True);
		$aVals['orders_status']=2;

		$aTran = $this->Dbaction->getCustomQuery('select * from orders_details where od_order_id = '.$id);
		foreach($aTran as $atrans)
		{
			$trans['order_id'] = $atrans['od_order_id'];
			$trans['warehouse_id'] = $atrans['od_warehouse_id'];
			$trans['user_id'] = $aUsr['id'];
			$trans['product_id'] = $atrans['od_product_id'];
			$trans['product_code'] = $atrans['od_product_code'];
//			$temp = array($atrans['od_size'] => $atrans['od_product_qty']);
			$trans['flag'] = 1;
			$trans['date'] = date('Y-m-d');

			$aRow = $this->Dbaction->getData('inventory',array('product_name' => $trans['product_id'],'warehouse_id' => $trans['warehouse_id']));

			$aRow['size'] = unserialize($aRow['size']);
			$atrans['od_size'] = unserialize($atrans['od_size']);

			foreach($atrans['od_size'] as $si => $qu)
			{
				$te[$si] = $qu*$aRow['pieces_per_set'];
			}

			$trans['inventory'] = serialize($te);

			foreach($aRow['size'] as $si => $qu)
			{
				foreach($atrans['od_size'] as $tsi => $tqu)
				{
					if($si == $tsi)
					{
						$tem[$si] = $qu + ($tqu*$aRow['pieces_per_set']);
					}
				}
			}
			// die;
			$aRow['size'] = serialize($tem);


			$this->Dbaction->updateData('inventory',$aRow,array('id' => $aRow['id']));
			$this->Dbaction->adddata('transactions',$trans);

		}

		$this->Dbaction->updateData('orders',$aVals,array('orders_id' => $id));
		$aMsg = 'Order Denounced!';
		$this->session->set_flashdata('message', array('message' => $aMsg ,'class' => 'alert-success'));
		redirect(getSiteUrl('order/index'), 'refresh');
	}



	public function uploadbuilty($id=0)
	{  
		if(isset($_FILES['userfile']) && $_FILES['userfile'])
	 	{    
	 		$orderId =$this->input->post('order_id'); 
		    $this->load->library('upload');
		    $dataInfo = array();
		    $files = $_FILES;
		    $cpt = count($_FILES['userfile']['name']);
		    for($i=0; $i<$cpt; $i++)
		    {           
		        $_FILES['userfile']['name']= $files['userfile']['name'][$i];
		        $_FILES['userfile']['type']= $files['userfile']['type'][$i];
		        $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
		        $_FILES['userfile']['error']= $files['userfile']['error'][$i];
		        $_FILES['userfile']['size']= $files['userfile']['size'][$i];    

		        if ($_FILES['userfile']['error']==0) {
		        	$aDocx = $this->Dbaction->uploadFiles("userfile","doc|docx|txt|pdf");
			 		if(isset($aDocx['file_name']) && $aDocx['file_name'])
			 		{
			 			$doc_name = $aDocx['file_name'];

			 			if (isset($doc_name)) {
				        	$aVals = array(
				        			'doc_order_id'=>$orderId,
				        			'doc_name'=>$doc_name
				        		);
				       		$this->Dbaction->addData('order_document',$aVals);
				       		$this->session->set_flashdata('message', array('message' => 'File uploadad successfully' ,'class' => 'alert-success'));
				        } 
			 		} else {
			 			$this->session->set_flashdata('message', array('message' => 'File format not correct. only accept documnet,pdf and text files.' ,'class' => 'alert-danger'));
			 		}
		        }    
		        
		    }		  
		} 
		redirect(getSiteUrl('order'), 'refresh');		    
	}


	public function documentdata()
	{	
		$aryResponse=array();
		$aryResponse['status']=0;
		$strHtml="";
		$orderId = $this->input->post('id');
		$aRowData = $this->Dbaction->getAllData('order_document','',['doc_order_id'=>$orderId],'','',$aOrders=array('doc_id'=>'DESC'));
		$strHtml.='<table class="table"><thead><tr><th>Id</th><th>Download Link</th><th>Action</th></tr></thead><tbody>';

		if (isset($aRowData) && count($aRowData)>0) {
			$count=0;
			$aryResponse['status']=1;
			foreach ($aRowData as $resultData) {
				++$count;
				$filename = preg_replace('/\\.[^.\\s]{3,4}$/', '', $resultData['doc_name']);
				$strHtml.='<tr class="'.$resultData['doc_id'].'"><td>'. $filename .'</td><td><a href="'.base_url('assets/uploads/'.$resultData['doc_name']).'" download class="btn btn-primary" style="color:#fff">Download File </a></td><td><a href="javascript:void(0)" onclick="removedocument('.$resultData['doc_id'].')" class="btn btn-primary"><i class="fa fa-trash-o" aria-hidden="true" style="color:#fff"></i></td></tr>';
			}
		}
		$strHtml.='</tbody></table>';
		$aryResponse['message']=$strHtml;
		echo json_encode($aryResponse);
	}

	public function removedocument()
	{
		$docId = $this->input->post('id');
		$data = $this->Dbaction->deleteData('order_document',array("doc_id" => $docId));
		$aryResponse=array();
		if ($data) {
			$aryResponse['status']=1;
		} else {
			$aryResponse['status']=0;
		}

		echo json_encode($aryResponse);
	}


	public function createcsvfile() {
		$data= array();
		$aJoins= array(
					'orders'=>'orders.orders_id=orders_details.od_order_id',
					'inventory'=>'inventory.product_name=orders_details.od_product_id',
					/*'category'=>'category.id=products.category',*/
					
				);


		$aRowData = $this->Dbaction->getAllData("orders_details",'orders_details.*,orders.customer_trans_order_id AS trans_id,orders.billing_name AS billing_name,orders.billing_phone AS billing_phone,orders.billing_address AS billing_address,orders.billing_city AS billing_city,orders.distributor_id AS distributor_id,orders.wrehouse_id AS warehouse_id,orders_details.od_product_name AS product_name,orders_details.od_product_code AS product_code,inventory.gst AS gst,orders_details.od_size as size_data',$aCons = array(),$aJoins,$aLImit  = 0,$aOrders = array());
/*
		echo "<pre>";
		print_r($aRowData);
		die();*/
		$aryAttributes = array();
		$arySize = array();

        $fields=array();
        $fields[0]='Trans id';
        $fields[1]='Billing Name';
        $fields[2]='Billing Phone';
        $fields[3]='Billing Address';
        $fields[4]='Billing City';
        $fields[5]='distributor';
        $fields[6]='wrehouse';
        $fields[7]='Product Name';
        $fields[8]='code';
        $fields[9]='Price';
        $fields[10]='GST';
        $fields[11]='total Price';
        /*$fields[4]='status';*/
        
       	$rowSizeData = $this->Dbaction->getAllData('attributes','id,name',['type'=>'size']);
       	$count=count($fields)-1;
       	foreach ($rowSizeData as $resSize) {
       		++$count;
       		$fields[$count]=$resSize['name'];
       		$arySize[$count]=$resSize['id'];
       	}

     
    	header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=\"orders_details".".csv\"");
        header("Pragma: no-cache");
        header("Expires: 0");
        $delimiter = ",";
        $handle = fopen('php://output', 'w');        
    	fputcsv($handle, $fields, $delimiter);

    	
        foreach ($aRowData as $resultData) {
        	// find city name according to billing id
        	$aRowCity =$this->Dbaction->getData('city',['id'=>$resultData['billing_city']]);
        	$aRowDistributor =$this->Dbaction->getData('users',['id'=>$resultData['distributor_id']]);
        	$aRowWarehouse =$this->Dbaction->getData('users',['id'=>$resultData['warehouse_id']]);
        	$price =$resultData['od_subtotal'];
        	$totalPrice=0;
        	$gstPrice=0;
        	if (isset($resultData['gst']) && ''!=$resultData['gst']) {
        		$gstPercent = $resultData['gst'];
        		$gstPrice=($price*$gstPercent)/100;
        		$totalPrice=$price+$gstPrice;
        	} else {        		
        	    $totalPrice=$price;
        	}

        	$data[0] =$resultData['trans_id'];
        	$data[1] =$resultData['billing_name'];
        	$data[2] =$resultData['billing_phone'];
        	$data[3] =$resultData['billing_address'];
        	$data[4] =$aRowCity['name'];
        	$data[5] =$aRowDistributor['name'];
        	$data[6] =$aRowWarehouse['name'];
        	$data[7] =$resultData['product_name'];
        	$data[8] =$resultData['product_code'];
        	$data[9] =$price;
        	$data[10] =$gstPrice;
        	$data[11] =$totalPrice;
        	/*$data['4'] = ($resultData['status'] == '1')?'Active':'Inactive';*/

        	if (isset($resultData['size_data']) && ''!=$resultData['size_data']) {
        		$aryAttributes = unserialize($resultData['size_data']);  
        		$cnt=count($data)-1; 
        		
        		foreach ($aryAttributes as $key => $value) {
        			$size = $this->Dbaction->getData('attributes',['id'=>$key]);
        			++$cnt;
        			
        			if (in_array($key, $arySize)) {
		       			$data[$key] = $value;
		       		} else {
		       			$data[$key] = 0;
		       		}        			        			
        		} 

        	}
        	
          	fputcsv($handle, $data, $delimiter);
        }

           
        fclose($handle);
        exit;
    }

}
