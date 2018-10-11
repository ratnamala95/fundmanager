<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Retailer extends Backend_Controller {


	function __construct()
	{
		parent::__construct();
		$this->tblName = "users";
	}

	public function index()
	{
		$user_role = $this->session->userdata['admin_logged_role_id'];
		$user_id   = $this->session->userdata['admin_user']->id;

		$aWcon = array("role" => RETAILER_ROLE);
		if($user_role == WAREHOUSE_ROLE)
		{
			$aWcon['warehouse_id'] = $user_id;
			$aRows = $this->Dbaction->getAllData($this->tblName,'',$aWcon);
			if($this->input->get())
			{
				$con = $this->input->get('name');
				$aRows = $this->Dbaction->getCustomQuery("select * from users where role = ".RETAILER_ROLE." and warehouse_id = ".$user_id." and (name like'%".$con."%' or email like '%".$con."%') ORDER BY id DESC ");
			}
		}
		if($user_role == DISTRIBUTOR_ROLE)
		{
			$aWcon['distributor_id'] = $user_id;
			$aRows = $this->Dbaction->getAllData($this->tblName,'',$aWcon);
			if($this->input->get())
			{
				$con = $this->input->get('name');
				$aRows = $this->Dbaction->getCustomQuery("select * from users where role = ".RETAILER_ROLE." and distributor_id = ".$user_id." and (name like'%".$con."%' or email like '%".$con."%') ORDER BY id DESC ");
			}
		}
		else
		{
			if($this->input->get())
			{
				$con = $this->input->get('name');
				$aRows = $this->Dbaction->getCustomQuery("select * from users where role = ".RETAILER_ROLE." and (name like'%".$con."%' or email like '%".$con."%') ORDER BY id DESC ");
//				pr($this->db->last_query());

			}
			else
			{
				$aRows = $this->Dbaction->getAllData($this->tblName,'',$aWcon,'','',['id'=>'DESC']);
			}
		}


		$this->content = 'retailer/index';
		$this->title   = 'Retailer';
		$this->data    = array("aRows" => $aRows);
		$this->layout();
	}

	public function res()
	{
		unset($_GET['name']);
		redirect(getSiteUrl('retailer/index'), 'refresh');
	}

	public function activate($id = 0 )
	{

		// $aRow = $this->Dbaction->getData('users',array('id' => $id));
		$aRow['status'] = 1;
		$this->Dbaction->updateData('users',$aRow,array('id' => $id));

		$this->index();
	}


	public function add($id = 0)
	{
		$bEdit = false;
		$aRow = array();
		$aDists = array();
		$currWare = array();
		$aUsr = json_decode(json_encode($_SESSION['admin_user']), True);
//		pr($aUsr);die;
		if($id > 0)
		{
			$bEdit = true;
			$aRow = $this->Dbaction->getData($this->tblName,array("id" =>$id));
			$id = $aRow['id'];
		}



		$aWcon = array("status" => 1,"role" => DISTRIBUTOR_ROLE);
		if($aUsr['role'] == DISTRIBUTOR_ROLE)
		{
			$aWcon['id'] = $aUsr['id'];
		}

		$wCon = array("status" => 1,"role" => WAREHOUSE_ROLE);
		if($aUsr['role'] == DISTRIBUTOR_ROLE)
		{
			$aCurrUser = $this->Dbaction->getData("users",array("id"=> $aUsr['id']));
			$wCon['id'] = isset($aCurrUser) ? $aCurrUser['warehouse_id'] : 0;
			$aDists = $this->Dbaction->getAllData("users",'',array('role'=>DISTRIBUTOR_ROLE,'id'=>$aUsr['id']));
//			pr($aDists);die;
		}
		if($aUsr['role'] == WAREHOUSE_ROLE)
		{
			$aDists = $this->Dbaction->getAllData("users",'',array('role'=>DISTRIBUTOR_ROLE,'warehouse_id'=>$aUsr['id']));
			$currWare = $this->Dbaction->getData($this->tblName,array('id'=>$aUsr['id']));
//			pr($currWare);die;
		} elseif ($aUsr['role'] == ADMIN_ROLE) {
			$aDists = $this->Dbaction->getAllData("users",'',array('role'=>DISTRIBUTOR_ROLE));
		}

		$aRetailers = $this->Dbaction->getAllData("users",'',$aWcon);
		$aWhouses = $this->Dbaction->getAllData("users",'',$wCon);

		$aValidations = array(
				array(
					'field'  => 'val[name]',
					'label'  => 'Retailer Name',
					'rules'  => 'required|callback_is_custom_unique[users||name||id||'.$id.']',
				),
				array(
					'field'  => 'val[email]',
					'label'  => 'Retailer Email',
					'rules'  => 'required|callback_is_custom_unique[users||email||id||'.$id.']',
				),
				array(
					'field'  => 'val[mobNum]',
					'label'  => 'Mobile Number',
					'rules'  => 'trim|required',
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
				$count = $this->Dbaction->getCustomQuery('select count(id) from users where role = '.DISTRIBUTOR_ROLE.' and warehouse_id = '.$aVals['warehouse_id']);
				$count = $count[0]['count(id)'];
				$count++;
				if(isset($aVals['id']) && $aVals['id'] > 0)
				{
					$edit_id = $aVals['id'];
					unset($aVals['id']);
					$this->Dbaction->updateData($this->tblName,$aVals,array("id" => $edit_id));
					$aMsg = "Data updated successfully";
				}
				else
				{
					$aVals['role'] = RETAILER_ROLE;
					$aVals['password'] = $this->Dbaction->encryptFunction($aVals['password']);
					$aVals['user_count'] = $count;
					$aVals['status'] = 1;
					$aVals['timestamp'] = date("Y-m-d");
					$this->Dbaction->addData($this->tblName,$aVals);
					$aMsg = "Data added successfully";
				}

				$this->session->set_flashdata('message', array('message' => $aMsg ,'class' => 'alert-success'));
				redirect(getSiteUrl('retailer'), 'refresh');
			}
		}

		$aCities = $this->Dbaction->getAllData("city",'',array("status" => 1));

		$this->content = 'retailer/add';
		$this->title   = $bEdit ? 'Update Retailer' : 'Add Retailer';
		$this->data    = array("bEdit" => $bEdit,"aRow" => $aRow,"aRetailers" => $aRetailers,"aWhouses" => $aWhouses,"aDists" => $aDists,"currWare" => $currWare,"aUsr" => $aUsr,"aCities"=>$aCities);
		$this->layout();
	}

	public function delete($id = 0)
	{
		$aRows = array();
		$deact['status'] = 0;
		$this->Dbaction->updateData($this->tblName,$deact,array('id' => $id));
		$this->session->set_flashdata('message', array('message' => "Data deleted successfully" ,'class' => 'alert-success'));
		redirect(getSiteUrl('retailer'), 'refresh');
	}

	public function replace()
	{
		$aRow = array();
		$warehouse = $_POST["warehouse"]	;
		$aRcon['warehouse_id'] = $warehouse;
		$aRcon['distributor_id'] = 0;
		$aDist = $this->Dbaction->getAllData("users",'',$aRcon);
		$this->load->view('backend/retailer/distributor',array("aDist" => $aDist,"aRow" => $aRow));
	}

}

?>
