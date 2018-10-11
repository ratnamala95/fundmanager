<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {


	public function __construct() 
  	{
   		parent::__construct();
   		 
   		$retailerId = $this->session->userdata('REATILER_ID');
		if ($this->session->userdata('REATILER_ID')) {

			redirect('dashboard');		 	
		} 
		
   		$this->load->model('usermodel');

 	}

	public function index()
	{
		$this->load->view('login_view');
	}
	

	public function distributoralldata()
	{
		$data['rowDistributor'] = $this->Dbaction->getAllData("users",'id,name',array("role"=>DISTRIBUTOR_ROLE,"status" => 1));


		 $response = array();
		foreach($data['rowDistributor'] as  $result ){
		   $response[] = array("value"=>$result['id'],"label"=>$result['name']);
		}

		//print_r($response[]);

		echo json_encode($response);
	}


	public function register()
	{
		$data['rowcity']=$this->Dbaction->getAllData('city','',['status'=>1]);
		
		if ($this->input->post('register')) {
			
			$this->form_validation->set_rules('name', 'Full Name', 'required');
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
			$this->form_validation->set_rules('distributor_name','Distributor name', 'trim|required');
			$this->form_validation->set_rules('city_id','City', 'trim|required');
	        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
			$this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|matches[password]');
			
	        
			
	       // $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

			if ($this->form_validation->run() == FALSE)
	            {
	                
	                //$this->session->set_flashdata('message', array('message' => $aMsg ,'class' => 'alert-success'));
	                $this->load->view('register_view',$data);	
	            }
	        else
	            {



	            	$data =$this->usermodel->registrationdata();

	            	if (empty($data)) {

	            		$strUserName = $this->input->post('name');
	            		$emailId = $this->input->post('email');
	            		$password = $this->input->post('password');

	            		$url = base_url("user/verifyemail").'/'.md5($emailId);
  					//	$strMessage= ' Thank you for registering at '.SITE_TITLE.' <br /> your account is created and must be activated before you can use it.  Your registration successfully. To activate the account click on the following link : <br /> <a href="'.$url.'" style="background: rgb(254,145,38);outline: none;border: none;padding: 10px 0;font-size: 1em;color: #fff;display: block;width: 22%;text-align: center; margin: 1.5em 0 0;" >Confirm Email </a><br /> <p>after activation you may login '.base_url('user/login').' </p><table><tr><th>Username :</th> <td> '.$emailId.' </td> <tr> <tr><th>Password :</th> <td> '.$password.' </td> <tr> </table>';
  					$strMessage= ' Thank you for registering at '.SITE_TITLE.' <br />  your account has been created!. <br /> follow the link to login : '.base_url('user/login').' </p><table><tr><th>Username :</th> <td> '.$emailId.' </td> <tr> <tr><th>Password :</th> <td> '.$password.' </td> <tr> </table>'; 

  						$fullMessage = $this->Dbaction->emailTemplate($strUserName,$strMessage);
  				
  				 									
						$this->Dbaction->sendEmail($emailId,'Registration successfully',$fullMessage);	

	            		$this->session->set_flashdata('registersuccessmsg',"your account has been created!.");
	            		redirect('user/login');

	            	} else {

	            		$this->session->set_flashdata('registererror',"Email already exists.");
	            		$data['rowcity']=$this->Dbaction->getAllData('city','',['status'=>1]);
	            		//redirect('user/register');
	            		$this->load->view('register_view',$data);	
	            		
	            	}
	                
	            }
	    } else { 

	    	 $this->load->view('register_view',$data);	
		}        


		
	}



	public function verifyemail()
	{
		
		$userEmailId = $this->uri->segment(3);
		$data = $this->usermodel->checkverifyemail($userEmailId);
		
		if (md5($data)==$userEmailId) {
			$this->session->set_flashdata('registersuccessmsg','Your email verify successfully.Please login');
			redirect('user/login');

		} else {
			$this->session->set_flashdata('loginerrormsg','Your email is not verify. Please try again');
			redirect('user/login');
		}
		
		
	}



	public function login()
	{
		
		if ($this->session->userdata('REATILER_ID')) {

			redirect('dashboard');		 	
		} 


		if ($this->input->post('login')) {
		
			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
	        $this->form_validation->set_rules('password', 'Password', 'trim|required');


	        if ($this->form_validation->run()==FALSE) {
	        	
	        	$this->load->view('login_view');

	        } else {

	        	$username = $this->input->post('email');
	        	$password = $this->input->post('password');

	        	$data = $this->usermodel->checklogin($username, $password);

	        
	        	
	        	if ($data=='') {

	        		$this->session->set_flashdata('loginerrormsg', 'Email address and password does not match ');
	        		//redirect('user/login');
	        		$this->load->view('login_view');

	        	} else if($data->status==0) {

	        		$this->session->set_flashdata('loginerrormsg', 'Your account is inactivate');
	        		//redirect('user/login');
	        		$this->load->view('login_view');

	        	} else {
	        		
	        		
	        		$this->session->set_userdata('REATILER_ID', $data->id);
	        		$this->session->set_userdata('REATILER_LOGIN_ID', $data->id);
	        		$this->session->set_userdata('DISTRIBUTOR_ID',$data->distributor_id);
	        		$this->session->set_userdata('REATILER_LOGIN_NAME', $data->name);
	        		$this->session->set_userdata('REATILER_LOGIN_EMAIL', $data->email);
	        		$this->session->set_userdata('REATILER_IMAGE', $data->image);

				
					$warehousedata=$this->Dbaction->getSingleData('users','warehouse_id',['id'=>$data->distributor_id]);							

	        		$this->session->set_userdata('WAREHOUSE_ID',$warehousedata['warehouse_id']);


	        		redirect('dashboard');
	        	}
	        	
	        }

	    } else {

	    	$this->load->view('login_view');
	    }    
		
	}





	public function forgotpassword()
	{
		if ($this->input->post('reset')) {

			$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

			if ($this->form_validation->run()==FALSE) {
	        	
	        	$this->load->view('forgot_password_view');
	        } else {
	        	$emailId = $this->input->post('email');
	        	$data = $this->usermodel->checkvalidemail($emailId);

	        	if ($data->email) {
	        		
	            	$url = base_url("user/forgotchangepassword").'/'.md5($data->email);
  					$strMessage= 'You recently requested to reset your password . please <a href="'.$url.'">click here </a>';  

  					$fullMessage = $this->Dbaction->emailTemplate($strUserName="",$strMessage);			
					$this->Dbaction->sendEmail($data->email,'Reset Password',$fullMessage);	

  					//$this->Dbaction->sendEmail($data->email,'Reset Password',$message);

	        		$this->session->set_flashdata('forgotsuccessmsg','Please check your email.');
	        		redirect('user/forgotpassword');

	        	} else {
	        		$this->session->set_flashdata('forgoterrorsmsg','Your email is not exists.');
	        		redirect('user/forgotpassword');
	        	}
	        	


	        }

			
		} else {
			$this->load->view('forgot_password_view');
		}
		
	}



	public function forgotchangepassword()
	{
		$emailId = $this->uri->segment(3);
		if ($this->input->post('changepassword')) {

			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
			$this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|matches[password]');
			if ($this->form_validation->run()==FALSE) {

				$this->load->view('forgot_change_password_view',['emailId'=>$emailId]);
			} else if ($this->input->post('emailId')=='') {

				$this->session->set_flashdata('changepasserrormsg','Invalid link !! Forgot password again ');
				redirect('user/forgotchangepassword');

			} else {
				$emailId = $this->input->post('emailId');
				$password = $this->input->post('password');
				
				$data = $this->usermodel->forgotchangepass($emailId,$password);
				

				$strMessage= 'Your password change successfully. please login <a href="'.base_url('user').'">click here </a>';  

				$fullMessage = $this->Dbaction->emailTemplate($data->name,$strMessage);			
				//echo decrypt($emailId); die();
				$this->Dbaction->sendEmail($data->email,'Change Password',$fullMessage);	


				$this->session->set_flashdata('registersuccessmsg','Your password change successfully.Please login');
				redirect('user/login');

			}	


		} else {

			$this->load->view('forgot_change_password_view',['emailId'=>$emailId]);

		}
		
		
	}


	public function findwarehouse()
	{
		$data = $this->Dbaction->getData('users',['city_id'=>$this->input->post('id')]);
		echo $data['id'];
	}

/*
	public function changepassword()
	{
		$this->form_validation->set_rules('oldpassword','Old Password','trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|matches[password]');

		$data = $this->input->post();

		//print_r($data);

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('change_password_view');
			//redirect('changepassword');
		} else {

		 	$oldpass = $this->input->post('oldpassword');
			$newpass = $this->input->post('password');

			$data = $this->usermodel->changepass($oldpass, $newpass);

			if ($data=='') {
				
				$this->session->set_flashdata('errorchangepass',' Old Password does not match');
				$this->load->view('change_password_view');

				

			} else {

				$this->session->set_flashdata('successchangepass',' Password change successfully');
				$this->load->view('change_password_view');

			}

		}
	}

	*/

	

}


?>	
