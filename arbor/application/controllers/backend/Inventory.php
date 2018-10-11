<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends Backend_Controller {


	function __construct()
	{
		parent::__construct();
		$this->tblName = "inventory";
	}

	public function index()
	{

		$seg = $this->uri->segment(4);
		$code = '';
		$conditions = array();
		$aVals = array();
		$strLimit=20;


		$aJoins = array(
					"products" => "products.id = inventory.product_name",
					"users" => "users.id = inventory.warehouse_id",
				);
		
		if($this->input->get())
		{
			$aVals = $this->input->get('sel');

			$this->session->set_userdata(array('sel' => $aVals));
			if($aVals['warehouse_id'] && $aVals['warehouse_id'] != '')
			{

				$seg = '';
				$conditions['inventory.warehouse_id'] = $aVals['warehouse_id'];
				//$conditions['users.city_id'] = $this->session->userdata('admin_user')->city_id;
				unset($aVals['warehouse_id']);
			}

			if($aVals['code'] && $aVals['code'] != '')
			{
					$code = $aVals['code'];
			}
			
			if (isset($aVals['orderby']) && ''!=$aVals['orderby']) {
				if($aVals['orderby']==1) {
					$aOrders['inventory.inventory_updated_date'] = 'DESC';
				} else if($aVals['orderby']==2) {
					$aOrders['inventory.id'] = 'ASC';
				} else if($aVals['orderby']==3) {
					$aOrders['inventory.id'] = 'DESC';
				}
			}
		}
		else
		{
			if($this->session->userdata('sel') != NULL)
			{
                $aVals = $this->session->userdata('sel');
            }
		}

		$aOrders['inventory.id'] = 'DESC';

		$aUsr = json_decode(json_encode($_SESSION['admin_user']), True);
		if($aUsr['role'] == WAREHOUSE_ROLE)
		{
			$aCons = $this->Dbaction->getAllData($this->tblName,'inventory.*',$conditions,$aJoins,'',$aOrders);
			$aCons = $this->Dbaction->userializeInventory($aCons);
			$aRows = $this->Dbaction->getLikeData($this->tblName,'inventory.*,users.city_id AS city_id',$conditions,$aJoins,$strLimit,$aOrders,$code,$seg);
		//	pr($aRows);die;
			$aRows = $this->Dbaction->userializeInventory($aRows);

	
		}
		else
		{
			$aRows = $this->Dbaction->getLikeData($this->tblName,'inventory.*,users.city_id AS city_id',$conditions,$aJoins,$strLimit,$aOrders,$code,$seg);
		// echo '<pre>';	
		// pr($aRows);die;
		//pr($this->db->last_query());
			$aRows = $this->Dbaction->userializeInventory($aRows);
			$aCons = $this->Dbaction->getAllData($this->tblName,'','','','',$aOrders);
			$aCons = $this->Dbaction->userializeInventory($aCons);

		}
		//echo $this->db->last_query();
		/* echo "<pre>";
        print_r($aRows); */

		$aCodes = $this->Dbaction->getCustomQuery("select id,code,name,image from products where status = 1");

		$aSizes  = $this->Dbaction->set_select_value($this->Dbaction->getAllData("attributes",'',array("type" => "size","status" => 1)),"id","name");
		$aWare = $this->Dbaction->set_select_value($this->Dbaction->getAllData("users",'',array("role" => WAREHOUSE_ROLE,"status" => 1)),"id","name");


		$rows = $this->Dbaction->getLikeData($this->tblName,'',$conditions,$aJoins,'',$aOrders,$code,$seg);

		

		//$rows = $this->Dbaction->getLikeData($this->tblName,'',$conditions);
		$paging = $this->Dbaction->paging(base_url('backend/inventory/index'),count($rows),$strLimit,base_url('backend/inventory'));

		$this->content = 'inventory/index';
		$this->title   = 'Inventory';
		$this->data    = array("aRows" => $aRows,"aCons" => $aCons,"aSizes" => $aSizes, "aWare" => $aWare, "aCodes" => $aCodes, "aUsr" => $aUsr);
		$this->layout();
	}

	public function resetIndex()
	{
		$this->session->unset_userdata('sel');
		$this->index($_SESSION['ret']);
	}

	public function add($id = 0,$ret = 0,$data='')
	{
	
		$bEdit = false;
		$aRow = array();
		$tempo = array();
		$aPro = array();
		$row = array();
		$aAttr = array();
		$aUsr = json_decode(json_encode($_SESSION['admin_user']), True);

		if($id > 0)
		{
			$bEdit = true;
			$aRow = $this->Dbaction->getData($this->tblName,array("id" =>$id));
			$row = $this->Dbaction->getData('products',array("id" =>$aRow['product_name']));
			$row = $this->Dbaction->toSimpleArray($row);
			$tempo = unserialize($aRow['size']);
			$id = $aRow['id'];
		}


		if($aUsr['role']==WAREHOUSE_ROLE)
		{
			$aWare = $this->Dbaction->getAllData("users",'',array("role" => 2,"id" => $aUsr['id']));
		}

		else
		{
			$aWare = $this->Dbaction->getAllData("users",'',array("role" => 2));
		}

		$aSizes  = $this->Dbaction->set_select_value($this->Dbaction->getAllData("attributes",'',array("type" => "size","status" => 1)),"id","name");
		$aProdu = $this->Dbaction->set_select_value($this->Dbaction->getAllData("products",'',array("status" => 1,"upcomming" => 0)),"id","name");
		$aCodes = $this->Dbaction->getCustomQuery("select id,code from products where status = 1");


		$aValidations = array(
			array(
			'field' => 'val[product_name]',
			'label' => 'Product Name',
			'rules' => 'required',
			),
			array(
			'field' => 'val[category]',
			'label' => 'Category',
			'rules' => 'trim',
			),
			array(
			'field' => 'val[warehouse_id]',
			'label' => 'Warehouse',
			'rules' => 'trim|required',
			),
			array(
			'field' => 'val[size]',
			'label' => 'Size',
			'rules' => 'trim',
			)
		);

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		$this->form_validation->set_rules($aValidations);

		if($this->form_validation->run())
		{
			if($this->input->post('val'))
			{
				$aVals = $this->input->post('val');
//				pr($row['size']);die;
					$trans['warehouse_id'] = $aVals['warehouse_id'];
					$trans['user_id'] = $aUsr['id'];
					$trans['product_id'] = $aVals['product_name'];
					$trans['product_code'] = $aVals['code'];
					$trans['flag'] = 1;
					$trans['date'] = date("Y-m-d");
					$aDats = $this->Dbaction->getData('inventory',array('code' => $aVals['code'],'warehouse_id' => $aVals['warehouse_id']));

			if (!$aDats)
				{
					$aAttr = $this->Dbaction->toSimpleArray($this->Dbaction->getData('products',array("id" =>$aVals['product_name'])));
//				pr($aVals);
//				pr($aAttr);die;
					$temp = array_combine($aAttr['size'],$aVals['size']);

					$trans['inventory'] = serialize($temp);
					$aVals['status'] = 1;
					$aVals['size'] = serialize($temp);
					$this->Dbaction->addData($this->tblName,$aVals);
					$this->Dbaction->addData('transactions',$trans);
					$aMsg = "Data added successfully";
				}

				else
				{
					if(isset($aVals['id']) && $aVals['id'] > 0)
					{
						$te = array();
						$edit_id = $aVals['id'];
						unset($aVals['id']);
						foreach($row['size'] as $in => $size)
						{
							foreach($aSizes as $key => $value)
							{
								if($size==$key)
								{
									array_push($te,$key);
								}
							}
						}
						$temp = array_combine($te,$aVals['size']);
//						pr($temp);die;
						$trans['inventory'] = serialize($temp);
						$te['attributes'] = $aRow['size'];
						$aRow['size'] = $this->Dbaction->toSimpleArray($te);
						if($aRow['code']==$aVals['code']){
							foreach ($aRow['size'] as $size=>$quantity){
								$temp[$size] =  $temp[$size]+$quantity;
							}
						}
						$aVals['size'] = serialize($temp);
						$this->Dbaction->updateData($this->tblName,$aVals,array("id" => $edit_id));
						$this->Dbaction->addData('transactions',$trans);
						$aMsg = "Data updated successfully";
					}
					else
					{
						$aMsg = "Entry for this product under this warehouse already exists in inventory!";
						$this->session->set_flashdata('message', array('message' => $aMsg ,'class' => 'alert-danger'));
						redirect(getSiteUrl('inventory/index/'), 'refresh');
					}
				}

				$this->session->set_flashdata('message', array('message' => $aMsg ,'class' => 'alert-success'));
				redirect(getSiteUrl('inventory/index/'), 'refresh');
			}
		}


		$this->content = 'inventory/add';
		$this->title   = $bEdit ? 'Update Inventory' : 'Make a New Entry';
		$this->data    = array("bEdit" => $bEdit,"aRow" => $aRow,"tempo" => $tempo,"aSizes" => $aSizes, "aProdu" => $aProdu, "aCodes" => $aCodes,"row" => $row,"aPro" => $aPro,"aAttr" => $aAttr,"aWare" => $aWare,"aUsr" => $aUsr);
		$this->layout();
	}

	public function interm()
	{
		$id = $_POST['mdl'];
		$this->add($id);
	}

	public function selectProduct()
	{
		$id = $_POST["product"];
		$pRow = $id != ''?$this->Dbaction->getData('products',array("id" => $id)):'';
		if($pRow != '')
		{
			$pRow['attributes'] = unserialize($pRow['attributes']);
		}

		$aSizes  = $this->Dbaction->set_select_value($this->Dbaction->getAllData("attributes",'',array("type" => "size","status" => 1)),"id","name");
		$this->load->view('backend/inventory/size',array("row" => $pRow,"aSizes" => $aSizes));
	}

	/*public function subInventory($id = 0)
	{
		$bEdit = false;
		$aUsr = json_decode(json_encode($_SESSION['admin_user']), True);
		if($id > 0)
		{
			$bEdit = true;
			$aRow = $this->Dbaction->getData($this->tblName,array('id'=>$id));
			$aPro = $this->Dbaction->getData('products',array('id'=>$aRow['product_name']));
			$temp['attributes'] = $aRow['size'];
			$aRow['size'] = $this->Dbaction->toSimpleArray($temp);
			$size = $this->Dbaction->toSimpleArray($aPro);
//			pr($size);die;
		}

		$aWare = $this->Dbaction->getAllData("users",'',array("role" => 2));
		$aSizes  = $this->Dbaction->set_select_value($this->Dbaction->getAllData("attributes",'',array("type" => "size","status" => 1)),"id","name");

		if($this->input->post('val'))
		{
			$aVals = $this->input->post('val');

			$trans['warehouse_id'] = $aVals['warehouse_id'];
			$trans['user_id'] = $aUsr['id'];
			$trans['product_id'] = $aVals['product_name'];
			$trans['product_code'] = $aVals['code'];
			$trans['flag'] = 0;

			$edit_id = $aVals['id'];
			unset($aVals['id']);
			$temp = array();

			$te = array_combine($size['size'],$aVals['size']);
			foreach($aRow['size'] as $key => $value)
			{
				foreach($te as $size => $quantity)
				{
					if($key==$size)
					{
						$temp[$key]= $value-$quantity;
					}
				}
			}

			$trans['inventory'] = serialize($temp);
			$aVals['size'] = serialize($temp);

			$this->Dbaction->updateData($this->tblName,$aVals,array("id" => $edit_id));
			$this->Dbaction->addData('transactions',$trans);
			$aMsg = "Data updated successfully";
			$this->session->set_flashdata('message', array('message' => $aMsg ,'class' => 'alert-success'));
			redirect(getSiteUrl('inventory/index'), 'refresh');


		}

		$this->content = 'inventory/sub';
		$this->title   = 'Modify';
		$this->data    = array("bEdit" => $bEdit,"aRow" => $aRow,"aWare" => $aWare,"aSizes" => $aSizes);
		$this->layout();
	}*/


	public function trans($id = 0)
	{
		$seg = $this->uri->segment(4);
		$strLimit = 5;
		$conditions = array();
		$aVals = array();
		$date = array();
		$code = '';

		$bEdit = false;

		if($this->input->get())
		{
			$aVals = $this->input->get('sel');
			if($aVals['warehouse_id'] != ''){$conditions['warehouse_id'] = $aVals['warehouse_id'];}
			if($aVals['product_code'] != ''){$code = $aVals['product_code'];}

			if($aVals['fdate'] != '' && $aVals['sdate'] != '')
			{
			    $date['fdate'] = $aVals['fdate'];
			    $date['sdate'] = $aVals['sdate'];
			}
			$seg = '';
			$this->session->set_userdata(array('sel' => $aVals));
		}
		else
		{
			if($this->session->userdata('sel') != NULL){
                $aVals = $this->session->userdata('sel');
				if($aVals['warehouse_id'] != ''){$conditions['warehouse_id'] = $aVals['warehouse_id'];}
				if($aVals['product_code'] != ''){$code = $aVals['product_code'];}
				if($aVals['fdate'] != '' && $aVals['sdate'] != '')
				{
				    $date['fdate'] = $aVals['fdate'];
				    $date['sdate'] = $aVals['sdate'];
				}

            }
		}

//		if($id>0)
//		{
//			$bEdit = true;
////			pr('yay');
//			$aRows = $this->Dbaction->getAllData('transactions','',array('product_id' => $id),'',$strLimit,array(),$this->uri->segment(4));
//			$aRows = $this->Dbaction->userializeTrans($aRows);
////			pr($aRows);
//		}
//		else
//		{
			$aRows = $this->Dbaction->userializeTrans($this->Dbaction->getTransData('transactions','',$conditions,'',$strLimit,$code,$date,$seg));
//		}
//		pr($this->db->last_query());

		$aCodes = $this->Dbaction->getCustomQuery("select id,code,name,image from products where status = 1");
		$aDates = $this->Dbaction->getCustomQuery("select distinct date from transactions");

		$aWare = $this->Dbaction->getAllData("users",'');
		$aSizes  = $this->Dbaction->set_select_value($this->Dbaction->getAllData("attributes",'',array("type" => "size","status" => 1)),"id","name");

		$rows = $this->Dbaction->getTransData('transactions','',$conditions,'',0,$code,$date);
		$paging = $this->Dbaction->paging(base_url('backend/inventory/trans'),count($rows),$strLimit,base_url('backend/inventory/trans'));

		$this->content = 'transactions/index';
		$this->title   = 'Transactions';
		$this->data    = array("bEdit" => $bEdit,"aWare" => $aWare,"aSizes" => $aSizes,"aCodes" => $aCodes,"aDates" => $aDates,"aRows" => $aRows);
		$this->layout();
	}

	public function tranz($id = 0)
	{
		$_SESSION['pro']=$id;
		$conditions = array();
		$aVals = array();
		$strLimit = 5;
		$seg = $this->uri->segment(4);
		$date = array();


		if($this->input->get())
		{
			$aVals = $this->input->get('sel');
			if($aVals['warehouse_id'] != ''){$conditions['warehouse_id'] = $aVals['warehouse_id'];}
			if($aVals['fdate'] != ''){$date['fdate'] = $aVals['fdate'];}
			if($aVals['sdate'] != ''){$date['sdate'] = $aVals['sdate'];}
			$this->session->set_userdata(array('sel' => $aVals));
		}
		else
		{
			if($this->session->userdata('sel') != NULL){
        $aVals = $this->session->userdata('sel');
				if($aVals['warehouse_id'] != ''){$conditions['warehouse_id'] = $aVals['warehouse_id'];}
				if($aVals['fdate'] != ''){$date['fdate'] = $aVals['fdate'];}
				if($aVals['sdate'] != ''){$date['sdate'] = $aVals['sdate'];}
      }
		}

//		foreach ($aVals as $key => $value)
//		{
//			if($aVals[$key] != '')
//			{
//				$conditions[$key] = $value;
//			}
//		}

		$bEdit = false;
		if($id>0)
		{
			$bEdit = true;
			$conditions['product_id'] = $id;
			$aRows = $this->Dbaction->getTransData('transactions','',$conditions,'',$strLimit,'',$date);
			$aRows = $this->Dbaction->userializeTrans($aRows);
//			pr($this->db->last_query());
//			pr($conditions);
		}

		$aCodes = $this->Dbaction->getCustomQuery("select id,code,name,image from products where status = 1");
		$aDates = $this->Dbaction->getCustomQuery("select distinct date from transactions");

		$aWare = $this->Dbaction->getAllData("users",'');
		$aSizes  = $this->Dbaction->set_select_value($this->Dbaction->getAllData("attributes",'',array("type" => "size","status" => 1)),"id","name");

		$rows = $this->Dbaction->getAllData('transactions','',$conditions);
		$paging = $this->Dbaction->paging(base_url('backend/inventory/tranz'),count($rows),$strLimit,base_url('backend/inventory/tranz'));

		$this->content = 'transactions/index';
		$this->title   = 'Transactions';
		$this->data    = array("bEdit" => $bEdit,"aWare" => $aWare,"aSizes" => $aSizes,"aCodes" => $aCodes,"aDates" => $aDates,"aRows" => $aRows);
		$this->layout();
	}

	public function resetTrans()
	{
		$this->session->unset_userdata('sel');
		$this->session->unset_userdata('pro');

		$this->trans();
	}
	public function resetTranz()
	{
		$id = $_SESSION['pro'];
		$this->session->unset_userdata('sel');
		$this->session->unset_userdata('pro');

		$this->tranz($id);
	}

	public function editTrans($id = 0)
	{
		$bEdit = false;
		if($id>0)
		{
			$bEdit = true;
			$aRow = $this->Dbaction->getData('transactions',array('trans_id'=>$id));
			$aWare = $this->Dbaction->getData('users',array('id'=>$aRow['warehouse_id']));
			$aUsr = $this->Dbaction->getData('users',array('id'=>$aRow['user_id']));
		}

		$ret = $aRow['product_id'];
		$aSizes  = $this->Dbaction->set_select_value($this->Dbaction->getAllData("attributes",'',array("type" => "size","status" => 1)),"id","name");

		$aValidations = array(
			array(
			'field' => 'val[quantity]',
			'label' => 'Quantity',
			'rules' => 'required',
			)
		);

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		$this->form_validation->set_rules($aValidations);


		if ($this->form_validation->run())
		{
			if($this->input->post('val'))
			{
				$bEdit = false;
				$aVals = $this->input->post('val');
				$aVals['new'] = array_combine($aVals['size'],$aVals['quantity']);
				$eRow = $this->Dbaction->getData('inventory',array('warehouse_id' => $aRow['warehouse_id'],'code' => $aRow['product_code']));
				$eRow['size'] = unserialize($eRow['size']);
				$aRow['inventory'] = unserialize($aRow['inventory']);

				if ($aRow['flag']==1)
				{
					foreach($aRow['inventory'] as $size => $quant)
					{
						$eRow['size'][$size] = $eRow['size'][$size] - $quant;
					}

					foreach($aVals['new'] as $size => $quant)
					{
						$eRow['size'][$size] = $eRow['size'][$size] + $quant;
					}
				}
				else if($aRow['flag']==0)
				{
					$aMsg = "You cannot edit this entry!";
					$this->session->set_flashdata('message', array('message' => $aMsg ,'class' => 'alert-warning'));
					redirect(getSiteUrl('inventory/tranz/'.$ret), 'refresh');
				}

				$eRow['size'] = serialize($eRow['size']);
				$aRow['inventory'] = serialize($aVals['new']);

				$this->Dbaction->updateData('inventory',$eRow,array('id' => $eRow['id']));
				$this->Dbaction->updateData('transactions',$aRow,array('trans_id' => $aRow['trans_id']));

				$aMsg = "Data updated successfully";
				$this->session->set_flashdata('message', array('message' => $aMsg ,'class' => 'alert-success'));
				redirect(getSiteUrl('inventory/tranz/'.$ret), 'refresh');

			}
		}

		$this->content = 'transactions/edit';
		$this->title   = 'Transactions';
		$this->data    = array("bEdit" => $bEdit,"aRow" => $aRow,"aWare" => $aWare,"aUsr" => $aUsr,"aSizes" => $aSizes);
		$this->layout();
	}


	public function delete($id = 0)
	{
		$this->Dbaction->deleteData($this->tblName,array("id" => $id));
		$this->session->set_flashdata('message', array('message' => "data deleted successfully" ,'class' => 'alert-success'));
		redirect(getSiteUrl('inventory/index/'), 'refresh');
	}

	/*public function whouse()
	{

//		$ware = ;
//	pr($_POST);die;
		$condition = array();
		if(isset($_POST["wareh"]))
		{
			$this->session->set_userdata('warehouseid',$_POST["wareh"]);

		}

		if($this->session->userdata('warehouseid'))
		{
			$condition['warehouse_id']=$this->session->userdata('warehouseid');
		}

		if(isset($_POST["size"]))
		{
			$this->session->set_userdata('size',$_POST["size"]);

		}

		if($this->session->userdata('size')){
			$condition['size']=$this->session->userdata('size');
		}

		if(isset($_POST["code"]))
		{
			$this->session->set_userdata('code',$_POST["code"]);
		}
		if($this->session->userdata('code'))
		{
			$condition['code']=$this->session->userdata('code');
		}

		if(isset($_POST["name"]))
		{
			$this->session->set_userdata('name',$_POST["name"]);
		}
		if($this->session->userdata('name'))
		{
			$condition['product_name']=$this->session->userdata('name');
		}
//		echo $ware;
		$aUsr = json_decode(json_encode($_SESSION['admin_user']), True);

//		pr($condition);die;
		$aRows = $this->Dbaction->getAllData($this->tblName,'',$condition);
		$aRows = $this->Dbaction->userializeInventory($aRows);
		$aCons = $this->Dbaction->getAllData($this->tblName,'');
		$aCons = $this->Dbaction->userializeInventory($aCons);

		$aCodes = $this->Dbaction->getCustomQuery("select id,code,name,image from products where status = 1");

		$aSizes  = $this->Dbaction->set_select_value($this->Dbaction->getAllData("attributes",'',array("type" => "size","status" => 1)),"id","name");
		$aWare = $this->Dbaction->set_select_value($this->Dbaction->getAllData("users",'',array("role" => WAREHOUSE_ROLE,"status" => 1)),"id","name");

		$this->load->view('/backend/inventory/indice',array("aRows" => $aRows,"aCons" => $aCons,"aSizes" => $aSizes, "aWare" => $aWare, "aCodes" => $aCodes, "aUsr" => $aUsr));
	}*/

	/*public function tranware()
	{
//		pr($_SERVER['QUERY_STRING']);
		if(isset($_GET["ware"]))
		{
			$this->session->set_userdata('warehouseid',$_GET["ware"]);

		}

		if($this->session->userdata('warehouseid'))
		{
			$condition['warehouse_id']=$this->session->userdata('warehouseid');
		}

		if(isset($_GET["code"]))
		{
			$this->session->set_userdata('code',$_GET["code"]);

		}

		if($this->session->userdata('code'))
		{
			$condition['product_code']=$this->session->userdata('code');
		}

		if(isset($_GET["date"]))
		{
			$this->session->set_userdata('date',$_GET["date"]);

		}

		if($this->session->userdata('date'))
		{
			$condition['date']=$this->session->userdata('date');
		}

//		pr($condition);
//		die;
		$aRows = $this->Dbaction->userializeTrans($this->Dbaction->getAllData('transactions','',$condition));
		$aCodes = $this->Dbaction->getCustomQuery("select id,code,name,image from products where status = 1");
		$aDates = $this->Dbaction->getCustomQuery("select distinct date from transactions");

		$aWare = $this->Dbaction->getAllData("users",'');
		$aSizes  = $this->Dbaction->set_select_value($this->Dbaction->getAllData("attributes",'',array("type" => "size","status" => 1)),"id","name");

		$this->load->view('backend/inventory/transac',array("aWare" => $aWare,"aSizes" => $aSizes,"aCodes" => $aCodes,"aDates" => $aDates,"aRows" => $aRows));
	}*/

	/*public function invent($id = 0)
	{
		if($id > 0)
		{
			$aData = $this->Dbaction->getData('products',array("id" =>$id));
			$aStyle = $this->Dbaction->toSimpleArray($aData);
			$id = 0;
			$this->add($id,$aData);
		}

	}*/
}

?>
