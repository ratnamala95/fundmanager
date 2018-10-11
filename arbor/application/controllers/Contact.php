<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Contact extends Frontend_Controller
{
	
	function  __construct()
	{
		parent::__construct();

	}


	public function index()
	{
		$data['totalproductcart'] = $this->productcartcount();
		//$data['catrow'] = $this->Dbaction->getAllData("category","",['status'=>1],"",7);
		//print_r($this->productcartcount());
		$this->load->view('contact_view',$data);
	}



	public function inquiry()
	{
		//$data['catrow'] = $this->Dbaction->getAllData("category","",['status'=>1],"",7);		
		$this->form_validation->set_rules('name', 'Full Name', 'trim|required');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|required|exact_length[10]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('text', 'Message', 'trim|required');

		if ($this->form_validation->run() == TRUE)
        {

        	$strUserName = $this->input->post('name');
			$strUserMessage='<h2>Thank you for contacting us.</h2><p>We have received your enquiry. You are very important to us, all information received will always remain confidential. We will contact you as soon as we review your message.</p>';			
			$strFullMessage =$this->Dbaction->emailTemplate($strUserName,$strUserMessage);
			$this->Dbaction->sendEmail($this->input->post('email'),'Contact enquiry',$strFullMessage);

			$this->sendcontactenquirytoadmin();

        	//$this->Dbaction->adddata('contact_inquiry',$this->input->post());
        	$this->session->set_flashdata('contactinquiirymsg','<h3>Thank you!</h3>Your message has been successfully sent. We will contact you very soon!');
        	redirect('contact');

        } else {

        	$this->load->view('contact_view');	

        }	
	}



	function sendcontactenquirytoadmin()
	{ 
		$strContName =$this->input->post('name');
	 	$strContPhone =$this->input->post('phone');
	 	$strContEmail =$this->input->post('email');
	 	$strContMessage =$this->input->post('text');
	 	
	 	$strUserName=SITE_TITLE;
		$subject =' Contact enquiry recived';
		

		$to=ADMIN_EMAIL;
			
								
		$headers = "MIME-Version: 1.0\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= "From: ".$strContEmail. "\r\n";		
		$headers.="Return-Path: ".$strContEmail."\r\n" ;
		$headers.="Reply-To: ".$strContEmail."\r\n" ;
		

	$strMessage = '
	<div style="font-weight:bold;">
	<p> You have recived a contact enquiry. customer information following below.</p>

	<table>'; 		

		$strMessage .= '<tr><th>Name : </th><td>'.$strContName.'</td></tr>
		<tr><th>phone : </th><td>'.$strContPhone.'</td></tr>
		<tr><th>email : </th><td>'.$strContEmail.'</td></tr>
		<tr><th>message : </th><td>'.$strContMessage.'</td></tr>
		';				
					
		$strMessage .='</table>';	

		$strFullMessage = $this->Dbaction->emailTemplate($strUserName,$strMessage);
		$this->Dbaction->sendEmail($strContEmail, $subject ,$strFullMessage);
	
	}
}

?>