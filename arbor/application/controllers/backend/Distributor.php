<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Distributor extends Backend_Controller {


	function __construct()
	{
		parent::__construct();
		$this->tblName = "users";
	}

	public function index()
	{
		$user_role = $this->session->userdata['admin_logged_role_id'];
		$user_id   = $this->session->userdata['admin_user']->id;


		$aWcon = array("role" => DISTRIBUTOR_ROLE);
		if($user_role == WAREHOUSE_ROLE)
		{
			$aWcon['warehouse_id'] = $user_id;

			if($this->input->get())
			{
				$con = $this->input->get('name');
				$aRows = $this->Dbaction->getCustomQuery("select * from users where role = ".DISTRIBUTOR_ROLE." and warehouse_id = ".$user_id." and (name like'%".$con."%' or email like '%".$con."%') ORDER BY id DESC ");
			}
			else
			{
				$aRows = $this->Dbaction->getAllData($this->tblName,'',$aWcon);
			}
		}
		else
		{
			if($this->input->get())
			{
				$con = $this->input->get('name');
				$aRows = $this->Dbaction->getCustomQuery("select * from users where role = ".DISTRIBUTOR_ROLE." and (name like'%".$con."%' or email like '%".$con."%') ORDER BY id DESC ");
				//pr($this->db->last_query());

			}
			else
			{
				$aRows = $this->Dbaction->getAllData($this->tblName,'',$aWcon,'','',['id'=>'DESC']);
			}
		}

		$aCities = $this->Dbaction->getAllData("city",'',array("status" => 1));

		$this->content = 'distributor/index';
		$this->title   = 'Distributor';
		$this->data    = array("aRows" => $aRows,"aCities" => $aCities);
		$this->layout();
	}

	public function res()
	{
		unset($_GET['name']);
		redirect(getSiteUrl('distributor/index'), 'refresh');
	}


	public function change($id = 0)
	{
		$aUsr = json_decode(json_encode($_SESSION['admin_user']),True);
	  $aValidations = array(
	      array(
	        'field'  => 'val[oldpassword]',
	        'label'  => 'Old Password',
	        'rules'  => 'required|trim|min_length[6]',
	      ),
	      array(
	        'field'  => 'val[newpassword]',
	        'label'  => 'New Password',
	        'rules'  => 'required|trim|min_length[6]',
	      ),
	      array(
	        'field'  => 'val[password]',
	        'label'  => 'Congirm Password',
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
	      $aRow = $this->Dbaction->getData('users',array('id' => $id));
	      if(isset($aVals)){
	        $aVals['oldpassword'] = $this->Dbaction->encryptFunction($aVals['oldpassword']);
	        if($aRow['password']==$aVals['oldpassword'])
	        {
	          pr('yayy');
	          if($aVals['newpassword']==$aVals['password'])
	          {
	            $fin['password'] = $this->Dbaction->encryptFunction($aVals['newpassword']);
	            $res = $this->Dbaction->updateData('users',$fin,array('id' => $id));
	            if($res)
	            {
	              $aMsg = "Password Changed!";
	              $this->session->set_flashdata('message', array('message' => $aMsg ,'class' => 'alert-success'));
	              redirect(getSiteUrl('distributor/profile/'.$id));
	            }
	          }
	          else
	          {
	            $aMsg = "Passwords do not match!";
	            $this->session->set_flashdata('message', array('message' => $aMsg ,'class' => 'alert-danger'));
	            redirect(getSiteUrl('distributor/change/'.$id));
	          }

	        }
	        else
	        {
	          $aMsg = "Please enter current password in 'Old Password' field!";
	          $this->session->set_flashdata('message', array('message' => $aMsg ,'class' => 'alert-danger'));
	          redirect(getSiteUrl('distributor/change/'.$id));
	        }
	      }
	      // $this->session->set_flashdata('message', array('message' => $aMsg ,'class' => 'alert-success'));
	      // redirect(getSiteUrl('warehouse/profile/'.$id));
	    }
	  }

	  $this->content = 'changePass';
	  $this->title = 'Change Passsword';
	  $this->data = array('aUsr' => $aUsr);
	  $this->layout("login");
	}

	public function profile($id = 0)
	{
		$aUsr = json_decode(json_encode($_SESSION['admin_user']),True);
//		pr($aUsr);
		$aRow = $this->Dbaction->getData($this->tblName,array("id" =>$aUsr['id']));
		$aWhouses = $this->Dbaction->getAllData("users",'',array("role" => WAREHOUSE_ROLE));

		$this->content = 'distributor/profile';
		$this->title   = 'Distributor';
		$this->data    = array("aRow" => $aRow,"aWhouses" => $aWhouses);
		$this->layout();
	}


	public function add($id = 0)
	{
		$bEdit = false;
		$aRow = array();
		$aUsr = json_decode(json_encode($_SESSION['admin_user']),True);
		if($id > 0)
		{
			$bEdit = true;
			$aRow = $this->Dbaction->getData($this->tblName,array("id" =>$id));
			$id = $aRow['id'];
		}


		$user_role = $this->session->userdata['admin_logged_role_id'];
		$user_id   = $this->session->userdata['admin_user']->id;

		$aWcon = array("status" => 1,"role" => WAREHOUSE_ROLE);
		if($user_role == WAREHOUSE_ROLE)
		{
			$aWcon['id'] = $user_id;
			$count = $this->Dbaction->getCustomQuery('select count(id) from users where role = '.WAREHOUSE_ROLE.' and warehouse_id = '.$user_id);
			$count = $count[0]['count(id)'];
			$count++;
		}

		$aWhouses = $this->Dbaction->getAllData("users",'',$aWcon);
		$aCities = $this->Dbaction->getAllData("city",'',array("status" => 1));

		$aValidations = array(
				array(
					'field'  => 'val[name]',
					'label'  => 'Distributor Name',
					'rules'  => 'required|callback_is_custom_unique[users||name||id||'.$id.']',
				),
				array(
					'field'  => 'val[email]',
					'label'  => 'Distributor Email',
					'rules'  => 'required|callback_is_custom_unique[users||email||id||'.$id.']',
				),
				array(
					'field'  => 'val[password]',
					'label'  => 'Password',
					'rules'  => 'trim|min_length[6]',
				),
			array(
					'field'  => 'val[mobNum]',
					'label'  => 'Mobile Number',
					'rules'  => 'trim|max_length[10]',
				),
		);

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		$this->form_validation->set_rules($aValidations);

		if($this->form_validation->run())
		{
			if($this->input->post('val'))
			{
				$aVals = $this->input->post('val');
				$count = $this->Dbaction->getCustomQuery('select count(id) from users where role = '.DISTRIBUTOR_ROLE.' and warehouse_id = '.$aVals['warehouse_id']);
				$count = $count[0]['count(id)'];
				$count++;

				$image_name = "";
				if(isset($_FILES['image']) && $_FILES['image'])
				{
//					pr($_FILES);die;
					$aImage = $this->Dbaction->uploadFiles("image","gif|jpg|png|jpeg");
					if(isset($aImage['file_name']) && $aImage['file_name'])
					{
						$image_name = $aImage['file_name'];
					}
				}

				if($image_name)
				{
					$aVals['image'] = $image_name;
				}

				if(isset($aVals['id']) && $aVals['id'] > 0)
				{
					$edit_id = $aVals['id'];
					unset($aVals['id']);
//					pr($aVals);die;
					$this->Dbaction->updateData($this->tblName,$aVals,array("id" => $edit_id));
					$strUserName = $aVals['name'];
					$strUserMessage='<h2>Your profile has been updated!</h2><br> <p>We recommend you review the changes!</p>';
					$strFullMessage =$this->Dbaction->emailTemplate($strUserName,$strUserMessage);
					$this->Dbaction->sendEmail($aVals['email'],'Profile Updated!',$strFullMessage);
					$aMsg = "Data updated successfully";
				}
				else
				{
					$aVals['role'] = DISTRIBUTOR_ROLE;
					$aVals['password'] = $this->Dbaction->encryptFunction($aVals['password']);
					$aVals['user_count'] = $count;
					$aVals['status'] = 1;
					$aVals['timestamp'] = date("Y-m-d");
					$this->Dbaction->addData($this->tblName,$aVals);
					$strUserName = $aVals['name'];
					$strUserMessage='<h2>Welcome to the family!</h2><br> <p>You are our newest distributor!</p>';
					$strFullMessage =$this->Dbaction->emailTemplate($strUserName,$strUserMessage);
					$this->Dbaction->sendEmail($aVals['email'],'Account Created!',$strFullMessage);
					$aMsg = "Data added successfully";
				}

				$this->session->set_flashdata('message', array('message' => $aMsg ,'class' => 'alert-success'));
				if($aUsr['role'] == DISTRIBUTOR_ROLE)
				{
					redirect(getSiteUrl('distributor/profile'), 'refresh');
				}
				else
				{
					redirect(getSiteUrl('distributor'), 'refresh');
				}

			}
		}

		$this->content = 'distributor/add';
		$this->title   = $bEdit ? 'Update Distributor' : 'Add Distributor';
		$this->data    = array("bEdit" => $bEdit,"aRow" => $aRow,"aWhouses" => $aWhouses,"aUsr" => $aUsr,"aCities" => $aCities);
		$this->layout();
	}

	public function delete($id = 0)
	{
		//pr($aRows);die;
		// if($aRows)
		// {
		$deact['status'] = 0;
		$this->Dbaction->updateData('users',$deact,array('distributor_id' => $id));
		$this->Dbaction->updateData('users',$deact,array('id' => $id));
		// }
		// else
		// {
		// $this->Dbaction->deleteData($this->tblName,array("id" => $id));
		// }
		$this->session->set_flashdata('message', array('message' => "Data deleted successfully" ,'class' => 'alert-success'));
		redirect(getSiteUrl('distributor'), 'refresh');
	}


}
