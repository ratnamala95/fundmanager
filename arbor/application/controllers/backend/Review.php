<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Review extends Frontend_Controller {

	public function index()
	{
		// echo "<pre>";
		// print_r($this->session->userdata());
		if (!empty($this->input->post('submit_review'))) { 	

	 		$this->form_validation->set_rules('title', 'Title', 'trim|required');
			$this->form_validation->set_rules('text', 'Description', 'trim|required');
			if ($this->form_validation->run() == TRUE)
	        {

	        	$strUserName = $this->session->userdata('admin_user')->name;
	        	$strUserEmail= $this->session->userdata('admin_user')->email;
				$strUserMessage='<h2>Thank you for your feedback.</h2><p>We have appreciate having you as a customer and your feedback helps us serve you batter </p>';			
				$strFullMessage =$this->Dbaction->emailTemplate($strUserName,$strUserMessage);
				//echo $strFullMessage; die();
				$this->Dbaction->sendEmail($strUserEmail ,'Review',$strFullMessage);
				$this->sendreviewenquirytoadmin();
	        	
	        	$this->session->set_flashdata('Review_msg','Thank you! for your feedback');        	

	        	redirect(getSiteUrl('review'), 'refresh');

       		}
       	}


		$this->content = 'review/index';
		$this->title   = 'Review';
		$this->data    = array();
		$this->layout();
	}

	function sendreviewenquirytoadmin()
	{ 
		$strContName = $this->session->userdata('admin_user')->name;
	    $strContEmail= $this->session->userdata('admin_user')->email;
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


}


?>