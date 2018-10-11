<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Frontend_Controller {


	function __construct() 
  	{
   		parent::__construct();
   		$this->load->model('usermodel');

   		$retailerId = $this->session->userdata('REATILER_ID');
		if ($retailerId=='') {

			redirect('user/login');		 

		} 

		$currentLoginData = $this->Dbaction->getData('users',['id'=>$this->session->userdata('REATILER_ID')]);
		//echo "<pre>";
		//print_r($currentLoginData);
		if ($currentLoginData) {
			$this->session->set_userdata('REATILER_IMAGE',$currentLoginData['image']);
		}
	}


 	public function index()
 	{

 		$userId = $this->session->userdata('REATILER_ID');
 		$data['userrow'] = $this->usermodel->checklogindata($userId);
 		//print_r($data);
 		$data['citydata'] = $this->Dbaction->getAllData("city",'',array("status" => 1));

 		$data['totalproductcart'] = $this->productcartcount();
		//$data['catrow'] = $this->Dbaction->getAllData("category","",['status'=>1],"",7);
		$data['totalproductcart'] = $this->productcartcount();
		
 		$this->load->view('dashboard',$data);	

 	}

 	public function updateprofile()
 	{


		$this->form_validation->set_rules('name','Name', 'trim|required');
		$this->form_validation->set_rules('city','City', 'trim|required');

		
		
		//$data = $this->input->post();
		
		$userId = $this->session->userdata('REATILER_ID');

		$data['totalproductcart'] = $this->productcartcount();
		//$data['catrow'] = $this->Dbaction->getAllData("category","",['status'=>1],"",7);
		$data['totalproductcart'] = $this->productcartcount();

		if ($this->form_validation->run()) {	
			
			//$this->load->library('upload');
			//

		
			$imageName='';
			if(isset($_FILES['userfile']) && $_FILES['userfile']['error']==0)
			{							
				$aImage = $this->Dbaction->uploadFiles("userfile","gif|jpg|png|jpeg");
				
				if(isset($aImage['file_name']) && $aImage['file_name'])
				{
					$imageName = $aImage['file_name'];
				}

				//print_r($this->upload->display_errors('<p>', '</p>'));
				//die();
			}

			$this->session->set_flashdata('successupdatemsg',' Profile updated successfully ! ');
			$this->usermodel->updateprofile($userId ,$imageName);

			$data['userrow'] = $this->usermodel->checklogindata($userId);
 			//print_r($data);
 			$data['citydata'] = $this->Dbaction->getAllData("city",'',array("status" => 1));

 			redirect('dashboard/updateprofile');	 			

 		} else {
 			
 			$data['userrow'] = $this->usermodel->checklogindata($userId);
 			//print_r($data);
 			$data['citydata'] = $this->Dbaction->getAllData("city",'',array("status" => 1));	
 			$this->load->view('dashboard',$data);	

 		}		

 	}

 	// customer review
 	public function review()
 	{
 		
 		if (!empty($this->input->post('submit_review'))) { 	

	 		$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('text', 'Description', 'trim|required');
			if ($this->form_validation->run() == TRUE)
	        {

	        	$strUserName = $this->session->userdata('REATILER_LOGIN_NAME');
	        	$strUserEmail= $this->session->userdata('REATILER_LOGIN_EMAIL');
				$strUserMessage='<h2>Thank you for your feedback.</h2><p>We have appreciate having you as a customer and your feedback helps us serve you batter </p>';			
				$strFullMessage =$this->Dbaction->emailTemplate($strUserName,$strUserMessage);
				//echo $strFullMessage; die();
				$this->Dbaction->sendEmail($strUserEmail ,'Review',$strFullMessage);
				$this->sendreviewenquirytoadmin();
	        	//$this->Dbaction->adddata('contact_inquiry',$this->input->post());
	        	$this->session->set_flashdata('Review_msg','Thank you! for your feedback');        	

	        	redirect('dashboard/review');

       		}


       	}
 		
 		$this->load->view('review');	

 	}
 	

	function sendreviewenquirytoadmin()
	{ 
		$strContName = $this->session->userdata('REATILER_LOGIN_NAME');
	    $strContEmail= $this->session->userdata('REATILER_LOGIN_EMAIL');
	 	$strContMessage =$this->input->post('text');
	 	$strtitle = $this->input->post('title');
	 	
	 	$strUserName=SITE_TITLE;
		$subject =' Review recived';
		

		$to=ADMIN_EMAIL;
			
								
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "From: ".$strContEmail. "\r\n";		
		$headers.="Return-Path: ".$strContEmail."\r\n" ;
		$headers.="Reply-To: ".$strContEmail."\r\n" ;
		

		$strMessage = '
		<div style="font-weight:bold;">
		<p> You have recived a review. customer information following below.</p>
		<table>'; 		

		$strMessage .= '<tr><th>Name : </th><td>'.$strContName.'</td></tr>
		<tr><th>Email : </th><td>'.$strContEmail.'</td></tr>
		<tr><th>Title : </th><td>'.$strtitle.'</td></tr>
		<tr><th>Msg : </th><td>'.$strContMessage.'</td></tr>
		';				
					
		$strMessage .='</table>';	

		$strFullMessage = $this->Dbaction->emailTemplate($strUserName,$strMessage);
		$this->Dbaction->sendEmail($strContEmail, $subject ,$strFullMessage);
	
	}
 	// customer review



 	public function changepassword()
	{
		$this->form_validation->set_rules('oldpassword','Old Password','trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|matches[password]');

		//$data = $this->input->post();

		//print_r($data);
		//$data['catrow'] = $this->Dbaction->getAllData("category","",['status'=>1],"",7);

		$data['totalproductcart'] = $this->productcartcount();

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('change_password_view',$data);
			//redirect('changepassword');
		} else {

		 	$oldpass = $this->input->post('oldpassword');
			$newpass = $this->input->post('password');

			$succesdata = $this->usermodel->changepass($oldpass, $newpass);

			
			if ($succesdata=='') {
				
				$this->session->set_flashdata('errorchangepass',' Old Password does not match');
				$this->load->view('change_password_view',$data);
				
			} else {

				$strUserName = $this->session->userdata('REATILER_LOGIN_NAME');
        		$emailId = $this->session->userdata('REATILER_LOGIN_EMAIL');
        		$url = base_url("user/login");
					$strMessage= 'Your Password change successfully. please login your account <a href="'.$url.'">click here </a>';  
				$fullMessage = $this->Dbaction->emailTemplate($strUserName,$strMessage);			
				$this->Dbaction->sendEmail($emailId,'Update password',$fullMessage);	

				$this->session->set_flashdata('successchangepass',' Password changed successfully !');
				redirect('dashboard/changepassword');
				//$this->load->view('change_password_view',$data);

			}

		}
	}



	public function orders()
	{
	    /*$aJoin = array( 
					'orders_details' => 'orders_details.od_order_id=orders.orders_id',
					'products'=>'products.id=orders_details.od_product_id',
					'inventory'=>'inventory.product_name=orders_details.od_product_id'
				); 
		*/
		$aCon = array(
					'customers_id'=>$this->session->userdata('REATILER_ID'),
					'order_delivery_status'=>0,
				);
		$aOrders = array('trans_date','DESC');
		$data['orderList'] = $this->Dbaction->getAllData('orders','',$aCon,$aJoin=array(),'',$aOrders);
		//print_r($data['orderList']);



		// previous orders list
		$aPrevCon = array(
					'customers_id'=>$this->session->userdata('REATILER_ID'),
					'order_delivery_status'=>1,

				);
		$data['previousOrderList'] = $this->Dbaction->getAllData('orders','',$aPrevCon);


		//$data['catrow'] = $this->Dbaction->getAllData("category","",['status'=>1],"",7);
		$data['totalproductcart'] = $this->productcartcount();
		
		$this->load->view('orders_view',$data);
	}



	public function orderdetails()
	{
		if ($this->uri->segment(3)) {

		$ajoin = array(
					'city' =>'city.id=orders.billing_city',
				);	
		$data['orderInfo'] = $this->Dbaction->getSingleData('orders','',['orders_id'=>$this->uri->segment(3)],$ajoin);

			$aCon = array(
					'od_order_id'=>$this->uri->segment(3),
					'od_cust_id'=>$this->session->userdata('REATILER_ID'),
					
				);
			$aJoin = array( 
					'orders' => 'orders.orders_id = orders_details.od_order_id',
					'products'=>'products.id=orders_details.od_product_id',
					'inventory'=>'inventory.product_name=orders_details.od_product_id'
				); 

			$data['orderDetails'] = $this->Dbaction->getAllData('orders_details','',$aCon,$aJoin);
           

			
			//$data['catrow'] = $this->Dbaction->getAllData("category","",['status'=>1],"",7);
			$data['totalproductcart'] = $this->productcartcount();
		
			$this->load->view('orders_details_view',$data);
		}
		
	}

	public function documentdata()
	{
		$aryResponse=array();
		$aryResponse['status']=0;	
		$strHtml="";
		$orderId = $this->input->post('id');
		$aRowData = $this->Dbaction->getAllData('order_document','',['doc_order_id'=>$orderId],'','',$aOrders=array('doc_id'=>'DESC'));
		$strHtml.='<table class="table"><thead><tr><th>Name</th><th>Download Link</th></tr></thead><tbody>';

		if (isset($aRowData) && count($aRowData)>0) {
			$aryResponse['status']=1;
			$count=0;
			foreach ($aRowData as $resultData) {
				++$count;
				$filename = preg_replace('/\\.[^.\\s]{3,4}$/', '', $resultData['doc_name']);
				$strHtml.='<tr class="'.$resultData['doc_id'].'"><td>'. $filename .'</td><td><a href="'.base_url('assets/uploads/'.$resultData['doc_name']).'" download class="btn btn-primary" style="color:#fff">Download File </a></td></tr>';
			}
		}
		$strHtml.='</tbody></table>';

		$aryResponse['message']=$strHtml;
		echo json_encode($aryResponse);
	}

	public function logout()
	{

		if($this->session->userdata('REATILER_ID')) {

			$this->session->unset_userdata('REATILER_ID');
			$this->session->unset_userdata('REATILER_LOGIN_ID');
			$this->session->unset_userdata('WAREHOUSE_ID');
			$this->session->unset_userdata('DISTRIBUTOR_ID');
			redirect('home');
		}
	}


}


?>

