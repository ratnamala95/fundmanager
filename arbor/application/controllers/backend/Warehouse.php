<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Warehouse extends Backend_Controller {


	function __construct()
	{
		parent::__construct();
		$this->tblName = "users";
	}

	public function index()
	{
//		unset($_GET['name']);
		if($this->input->get())
		{
			$name = $this->input->get('name');
			$aRows = $this->Dbaction->getCustomQuery("select * from users where role = 2 and (name like '%".$name."%' or email like '%".$name."%')");
//			pr($this->db->last_query());
		}
		else
		{
			$aRows = $this->Dbaction->getAllData($this->tblName,'',array("role" => WAREHOUSE_ROLE),'','',['id'=>'DESC']);
		}

//		unset($_GET['name']);
//		$aRows = $this->Dbaction->getAllData($this->tblName,'',array("role" => WAREHOUSE_ROLE));
		$this->content = 'warehouse/index';
		$this->title   = 'Warehouse';
		$this->data    = array("aRows" => $aRows);
		$this->layout();
	}
	public function res()
	{
		unset($_GET['name']);
		redirect(getSiteUrl('warehouse'), 'refresh');
	}
	public function profile($id = 0)
	{
		$aUsr = json_decode(json_encode($_SESSION['admin_user']),True);
//		pr($aUsr);
		$aRow = $this->Dbaction->getData($this->tblName,array("id" =>$aUsr['id']));

		$this->content = 'warehouse/profile';
		$this->title   = 'Warehouse';
		$this->data    = array("aRow" => $aRow);
		$this->layout();
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
								redirect(getSiteUrl('warehouse/profile/'.$id));
							}
						}
						else
						{
							$aMsg = "Passwords do not match!";
							$this->session->set_flashdata('message', array('message' => $aMsg ,'class' => 'alert-danger'));
							redirect(getSiteUrl('warehouse/change/'.$id));
						}

					}
					else
					{
						$aMsg = "Please enter current password in 'Old Password' field!";
						$this->session->set_flashdata('message', array('message' => $aMsg ,'class' => 'alert-danger'));
						redirect(getSiteUrl('warehouse/change/'.$id));
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

		$count = $this->Dbaction->getCustomQuery('select count(id) from users where role = '.WAREHOUSE_ROLE);
		$count = $count[0]['count(id)'];
		$count++;

		$aCities = $this->Dbaction->getAllData("city",'',array("status" => 1));

		$aValidations = array(
				array(
					'field'  => 'val[name]',
					'label'  => 'Warehouse Name',
					'rules'  => 'required|callback_is_custom_unique[users||name||id||'.$id.']',
				),
				array(
					'field'  => 'val[email]',
					'label'  => 'Warehouse Email',
					'rules'  => 'required|callback_is_custom_unique[users||email||id||'.$id.']',
				),
				array(
					'field'  => 'val[password]',
					'label'  => 'Password',
					'rules'  => 'trim|min_length[6]',
				),
		);

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		$this->form_validation->set_rules($aValidations);

		if($this->form_validation->run())
		{
			if($this->input->post('val'))
			{
				$aVals = $this->input->post('val');

				$image_name = "";
				if(isset($_FILES['image']) && $_FILES['image'])
				{
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

//				pr($aVals);die;
				if(isset($aVals['id']) && $aVals['id'] > 0)
				{
					$edit_id = $aVals['id'];
					unset($aVals['id']);
					$this->Dbaction->updateData($this->tblName,$aVals,array("id" => $edit_id));
					$strUserName = $aVals['name'];
					$strUserMessage='<h2>Your profile has been updated!</h2><br> <p>We recommend you review the changes!</p>';
					$strFullMessage =$this->Dbaction->emailTemplate($strUserName,$strUserMessage);
					$this->Dbaction->sendEmail($aVals['email'],'Profile Updated!',$strFullMessage);
					$aMsg = "Data updated successfully";
				}
				else
				{
					$aVals['role'] = WAREHOUSE_ROLE;
					$aVals['password'] = $this->Dbaction->encryptFunction($aVals['password']);
					$aVals['user_count'] = $count;
					$aVals['status'] = 1;
					$aVals['timestamp'] = date("Y-m-d");
					$this->Dbaction->addData($this->tblName,$aVals);
					$strUserName = $aVals['name'];
					$strUserMessage='<h2>Welcome to the family!</h2><br> <p>You are our newest warehouse!</p>';
					$strFullMessage =$this->Dbaction->emailTemplate($strUserName,$strUserMessage);
					$this->Dbaction->sendEmail($aVals['email'],'Account Created!',$strFullMessage);
					$aMsg = "Data added successfully";
				}


				$this->session->set_flashdata('message', array('message' => $aMsg ,'class' => 'alert-success'));
				if($aUsr['role'] == WAREHOUSE_ROLE)
				{
					redirect(getSiteUrl('warehouse/profile'), 'refresh');
				}
				else
				{
					redirect(getSiteUrl('warehouse'), 'refresh');
				}
			}
		}

	
		$this->content = 'warehouse/add';
		$this->title   = $bEdit ? 'Update Warehouse' : 'Add Warehouse';
		$this->data    = array("bEdit" => $bEdit,"aRow" => $aRow,"aCities" => $aCities,"aUsr" => $aUsr);
		$this->layout();
	}


	public function delete($id = 0)
	{
		$aRows = array();
		// if($id>0)
		// {
		// $aRows = $this->Dbaction->getAllData('users','',array('warehouse_id' => $id));
		// }
		// if($aRows)
		// {
		$dact['status'] = 0;
		$dact['parent_flag'] = 0;
		$this->Dbaction->updateData('users',$dact,array('warehouse_id' => $id));
		$this->Dbaction->updateData('users',$dact,array('id' => $id));
		// }
		// else
		// {
		// $this->Dbaction->deleteData($this->tblName,array("id" => $id));
		// }
		$this->session->set_flashdata('message', array('message' => "Data deleted successfully" ,'class' => 'alert-success'));
		redirect(getSiteUrl('warehouse'), 'refresh');
	}





	public function activate($id = 0)
	{
		$act['status'] = 1;
		$act['parent_flag'] = 1;
		$this->Dbaction->updateData('users',$act,array('warehouse_id' => $id));
		$this->Dbaction->updateData('users',$act,array('id' => $id));
		redirect(getSiteUrl('warehouse'), 'refresh');
	}

	public function request()
	{
		$aUsr = ($_SESSION['admin_user']);
		$aUsr = json_decode(json_encode($aUsr), True);

		$aWare =$this->Dbaction->set_select_value($this->Dbaction->getAllData("users",'',array("role" => WAREHOUSE_ROLE,"status" => 1)),"id","name");

		$aValidations = array(
				array(
					'field'  => 'val[warehouse_id]',
					'label'  => 'Warehouse Name',
					'rules'  => 'required',
				),
				array(
					'field'  => 'val[product_id]',
					'label'  => 'Product Name',
					'rules'  => 'required',
				)
		);

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		$this->form_validation->set_rules($aValidations);


		if($this->form_validation->run())
		{
//			echo 'validations alright!';die;
			if($this->input->post('val'))
			{
				$aVals = $this->input->post('val');
				$aVals['size'] = (serialize(array_combine($aVals['size'],$aVals['quantity'])));
				unset($aVals['quantity']);
				$aVals['sender'] = $aUsr['id'];
				$aVals['reciever'] = $aVals['warehouse_id'];
				unset($aVals['warehouse_id']);
				$aVals['message'] = "Product Requested!";
				$aVals['status'] = 0;
//				pr($aVals);die;
				$this->Dbaction->addData("requests",$aVals);
				$aMsg = "Request sent!";

				$this->session->set_flashdata('message', array('message' => $aMsg ,'class' => 'alert-success'));
				redirect(getSiteUrl('product'), 'refresh');
			}
		}
		/*else
		{
			$aMsg = "Error!";
			$this->session->set_flashdata('message', array('message' => $aMsg ,'class' => 'alert-danger'));
		}*/


		$this->content = 'warehouse/request';
		$this->data    = array("aWare" => $aWare,"aUsr" => $aUsr);
		$this->title   = 'Warehouse';
		$this->layout();
	}

	public function replace()
	{
		$ware = $_POST["warehouse"]	;
		$rRows = $this->Dbaction->getAllData('inventory','',array('warehouse_id' => $ware));
		$rRows = $this->Dbaction->userializeInventory($rRows);
		$rProds = $this->Dbaction->getAllData('products','',array('status' => 1));

		$aCats = $this->Dbaction->getAllData('category','',array('status' => 1));

		$aSizes  = $this->Dbaction->set_select_value($this->Dbaction->getAllData("attributes",'',array("type" => "size","status" => 1)),"id","name");
		$aCodes  = $this->Dbaction->set_select_value($this->Dbaction->getAllData("attributes",'',array("type" => "codes","status" => 1)),"id","name");

		$this->load->view('backend/warehouse/products',array("rProds"=>$rProds,"rRows"=>$rRows,"aCats"=>$aCats,"aSizes" => $aSizes,"aCodes" => $aCodes));
	}

	public function requests($id = 0)
	{
		$aUsr = json_decode(json_encode($_SESSION['admin_user']), True);
//		pr($id);die;
		if($id > 0)
		{
			$mData = $this->Dbaction->getData("requests",array('id'=>$id));
			$iData = $this->Dbaction->getData("inventory",array('product_name'=> $mData['product_id'],'code'=> $mData['code'],'warehouse_id' => $aUsr['id']));
//			pr($mData);
//			pr($iData);die;

			if($iData)
			{
				$res = $this->Dbaction->checkInventory($mData,$iData);
//				pr($res);die;
				if($res)
				{
					$trans['warehouse_id'] = $mData['sender'];
					$trans['user_id'] = $mData['reciever'];
					$trans['product_code'] = $mData['code'];
					$trans['inventory'] = $mData['size'];
					$trans['flag'] = 1;

					$stat['status']=1;
					$stat['message']='aprroved!';
					$this->Dbaction->updateData('requests',$stat,array('id' => $mData['id']));
					$this->Dbaction->adddata('transactions',$trans);
					$aMsg = 'You just approved a product request from another warehouse!';
				}
			}
			else
			{
				$aMsg = "You don't have provisions to approve this request!";
			}
				$this->session->set_flashdata('message', array('message' => $aMsg ,'class' => 'alert-success'));
				redirect(getSiteUrl('warehouse/requests'), 'refresh');
		}


		$aRows = $this->Dbaction->getAllData('requests','');
		$aRows = $this->Dbaction->userializeInventory($aRows);
		$aWhouses = $this->Dbaction->getAllData("users",'',array('role' => 2));
		$aProds = $this->Dbaction->getAllData("products",'',array("status" => 1));

		$aSizes  = $this->Dbaction->set_select_value($this->Dbaction->getAllData("attributes",'',array("type" => "size","status" => 1)),"id","name");





		$this->content = 'warehouse/requests';
		$this->data    = array("aRows" => $aRows,"aSizes" => $aSizes,"aUsr" => $aUsr,"aProds" => $aProds,"aWhouses" => $aWhouses);
		$this->title   = 'Warehouse';
		$this->layout();

	}

	public function sRequests()
	{
		$aUsr = json_decode(json_encode($_SESSION['admin_user']), True);
		$aRows = $this->Dbaction->getAllData('requests','');
		$aRows = $this->Dbaction->userializeInventory($aRows);
		$aWhouses = $this->Dbaction->getAllData("users",'',array('role' => 2));
		$aProds = $this->Dbaction->getAllData("products",'',array("status" => 1));

		$aSizes  = $this->Dbaction->set_select_value($this->Dbaction->getAllData("attributes",'',array("type" => "size","status" => 1)),"id","name");

		$this->content = 'warehouse/sRequests';
		$this->data    = array("aRows" => $aRows,"aSizes" => $aSizes,"aUsr" => $aUsr,"aProds" => $aProds,"aWhouses" => $aWhouses);
		$this->title   = 'Warehouse';
		$this->layout();

	}

	public function reject($id = 0)
	{
		$temp = $this->Dbaction->getData("requests",array('id'=>$id));

		$mData = $this->Dbaction->getData("inventory",array('product_name'=>$temp['product_id'],'warehouse_id'=>$temp['sender'],'code'=>$temp['code']));

		$iData = $this->Dbaction->getData("inventory",array('product_name'=>$temp['product_id'],'warehouse_id'=>$temp['reciever'],'code'=>$temp['code']));
//		pr($temp);die;
		$res = $this->Dbaction->reject($iData,$mData,$temp);

		if ($res)
		{
			$trans['warehouse_id'] = $temp['sender'];
			$trans['user_id'] = $temp['reciever'];
			$trans['product_code'] = $temp['code'];
			$trans['inventory'] = $temp['size'];
			$trans['flag'] = 0;

			$stat['status'] = 0;
			$this->Dbaction->updateData('requests',$stat,array('id' => $temp['id']));
			$this->Dbaction->adddata('transactions',$trans);
			$aMsg = 'Request rejected!';

			$this->session->set_flashdata('message', array('message' => $aMsg ,'class' => 'alert-success'));
			redirect(getSiteUrl('warehouse/requests'), 'refresh');
		}

	}

	public function mod()
	{
		$ware = $_POST["mdl"]	;

		$data = $this->Dbaction->getAllData('inventory','',array('id'=>$ware));
		$aSizes  = $this->Dbaction->set_select_value($this->Dbaction->getAllData("attributes",'',array("type" => "size","status" => 1)),"id","name");
		$data = $this->Dbaction->userializeInventory($data);

		$this->load->view('backend/warehouse/modal',array('data'=>$data,'aSizes'=>$aSizes));
	}



}
