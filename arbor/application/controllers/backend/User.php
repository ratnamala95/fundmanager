<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Backend_Controller {


	function __construct()
	{
		parent::__construct();
	}

	public function login()
	{

		if($this->input->post('val'))
		{
			$aVals = $this->input->post('val');
			$aUser = $this->Dbaction->adminLogin($aVals);
			if($aUser)
			{
				$this->session->set_userdata('admin_logged_in', true);
				$this->session->set_userdata('admin_logged_role_id', $aUser[0]->role);
				$this->session->set_userdata('admin_user', $aUser[0]);
				$this->session->set_flashdata('message', array('message' => 'Login successful!','class' => 'alert-success'));
				redirect(getSiteUrl('dashboard'), 'refresh');
			}
			else
			{
				$this->session->set_flashdata('message', array('message' => 'Login failed','class' => 'alert-danger'));
				redirect(getSiteUrl(''), 'refresh');
			}

		}

		$this->content = 'login';
		$this->title   = 'Login';
		$this->data    = array();
		$this->layout("login");
	}

	public function logout()
	{
		$this->session->set_userdata('admin_logged_in', '');
		$this->session->set_userdata('admin_logged_role_id', '');
		$this->session->set_userdata('admin_user', '');

		$this->session->set_flashdata('message', array('message' => 'Logout successfully','class' => 'alert-success'));
		redirect(getSiteUrl(''), 'refresh');
	}

	public function changepassword($id = 0)
	{
		$aUsr = json_decode(json_encode($_SESSION['admin_user']),True);
		$aRow = $this->Dbaction->getData('users',array('id'=>$id));
		$aValidations = array(
	      array(
	        'field'  => 'val[password]',
	        'label'  => 'Password',
	        'rules'  => 'required|trim|min_length[6]',
	      ),
	  );

	  $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
	  $this->form_validation->set_rules($aValidations);

	  if($this->form_validation->run())
	  {
	    if($this->input->post('val'))
	    {
				$aVals = $this->input->post('val');
				$fin['password'] = $this->Dbaction->encryptFunction($aVals['password']);

				$res = $this->Dbaction->updateData('users',$fin,array('id' => $id));
				if($res)
				{
					$aMsg = "Password Changed!";
					$this->session->set_flashdata('message', array('message' => $aMsg ,'class' => 'alert-success'));
					// redirect(getSiteUrl('dashboard'));
				}
				else
				{
					$aMsg = "Password Changed!";
					$this->session->set_flashdata('message', array('message' => $aMsg ,'class' => 'alert-success'));
				}
			}

			if($aRow['role']==WAREHOUSE_ROLE)
			{
				redirect(getSiteUrl('warehouse'));
			}
			else if($aRow['role']==DISTRIBUTOR_ROLE)
			{
				redirect(getSiteUrl('distributor'));
			}
			else if($aRow['role']==RETAILER_ROLE)
			{
				redirect(getSiteUrl('retailer'));
			}
		}

		$this->content = "changePass";
		$this->title = "Change Password";
		$this->data = array('aUsr' => $aUsr);
		$this->layout("login");
	}
}
