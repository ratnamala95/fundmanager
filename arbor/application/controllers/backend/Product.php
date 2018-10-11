<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends Backend_Controller {


	function __construct()
	{
		parent::__construct();
		$this->tblName = "products";
	}

	public function index()
	{
		$this->session->unset_userdata('sel');
		$this->session->unset_userdata('product_code');
		$this->session->unset_userdata('date');
		$this->session->unset_userdata('sel');

		$strLimit=20;


		$_SESSION['admin_user']? $aUsr = json_decode(json_encode($_SESSION['admin_user']),True):'';
		$count['counter'] = array();

		$aRows = $this->Dbaction->getAllData('products');

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
					$this->Dbaction->updateData('products',$aRow,array('id' => $aRow['id']));
				}
				else {
					// pr('got it');
					// pr('*');
				}
			}
		}


		$predict = $this->Dbaction->getCustomQuery('select name,code from products');
		$aJoins = array("category" => "products.category = category.id");
		$aRows = $this->Dbaction->getAllData($this->tblName,"products.*,category.name as category_name",array(),$aJoins,$strLimit,array('id'=>'desc'),$this->uri->segment(4));

		$rows = $this->Dbaction->getAllData($this->tblName,'');
		$paging = $this->Dbaction->paging(base_url('backend/product/index'),count($rows),$strLimit,base_url('backend/product'));

		$this->content = 'product/index';
		$this->title   = 'Products';
		$this->data    = array("aRows" => $aRows,'predict' => $predict);
		$this->layout();
	}


	public function add($id = 0)
	{
		

		$bEdit = false;
		$aRow = array();
		if($id > 0)
		{
			$bEdit = true;
			$aRow = $this->Dbaction->getData($this->tblName,array("id" =>$id));
			$id = $aRow['id'];
		}

		$aCats = $this->Dbaction->getAllData("category",'',array("status" => 1));
		/*$aWare = $this->Dbaction->getAllData("users",'',array("role" => 2));*/

		$aSizes  = $this->Dbaction->set_select_value($this->Dbaction->getAllData("attributes",'',array("type" => "size","status" => 1)),"id","name");
		$aStyles = $this->Dbaction->set_select_value($this->Dbaction->getAllData("attributes",'',array("type" => "style","status" => 1)),"id","name");
		$aCodes  = $this->Dbaction->set_select_value($this->Dbaction->getAllData("attributes",'',array("type" => "codes","status" => 1)),"id","name");


		$aValidations = array(
				array(
					'field'  => 'val[name]',
					'label'  => 'Product Name',
					'rules'  => 'required|callback_is_custom_unique[products||name||id||'.$id.']',
				)	,
				array(
					'field'  => 'val[code]',
					'label'  => 'Code',
					'rules'  => 'required|callback_is_custom_unique[products||code||id||'.$id.']',
				)
		);

		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		$this->form_validation->set_rules($aValidations);

		if($this->form_validation->run())
		{
			if($this->input->post('val'))
			{
				
		 	
 
				$image_name = "";
				if(isset($_FILES['image']) && $_FILES['image'])
				{
					$aImage = $this->Dbaction->uploadFiles("image","gif|jpg|png|jpeg");
					if(isset($aImage['file_name']) && $aImage['file_name'])
					{
						$image_name = $aImage['file_name'];
					}
				}

				$aVals = $this->input->post('val');

				$aAttrs = $aVals['attributes'];

				$aVals['attributes'] = serialize($aAttrs);


				if($image_name)
				{
					$aVals['image'] = $image_name;
				}

				if(isset($aVals['id']) && $aVals['id'] > 0)
				{
					$edit_id = $aVals['id'];
					unset($aVals['id']);
					$this->Dbaction->updateData($this->tblName,$aVals,array("id" => $edit_id));
					$aMsg = "Data updated successfully";
				}
				else
				{
//					$aVals['status'] = 1;
					$aVals['timestamp'] = date("Y-m-d");
					$temp = str_replace(' ','-',$aVals['name']);
					$aVals['slug'] = strtolower(str_replace('/','-',$temp));
					$this->Dbaction->addData($this->tblName,$aVals);
					$aMsg = "Data added successfully";
				}

				$this->session->set_flashdata('message', array('message' => $aMsg ,'class' => 'alert-success'));
				redirect(getSiteUrl('product'), 'refresh');
			}
		}

 		$this->content = 'product/add';
		$this->title   = $bEdit ? 'Update product' : 'Add product';
		$this->data    = array("bEdit" => $bEdit,"aRow" => $aRow,"aCats" => $aCats,"aSizes" => $aSizes, "aStyles" => $aStyles, "aCodes" => $aCodes, /*"aWare" => $aWare*/);
		$this->layout();
	}


	public function delete($id = 0)
	{
		$this->Dbaction->deleteData($this->tblName,array("id" => $id));
		$this->session->set_flashdata('message', array('message' => "data deleted successfully" ,'class' => 'alert-success'));
		redirect(getSiteUrl('product'), 'refresh');
	}

	public function search()
	{
		$code = $_POST["name"];
//		echo $code;
		$aJoins = array("category" => "products.category = category.id");
//		$aRows = $this->Dbaction->getAllData($this->tblName,"products.*,category.name as category_name",array('code' => $code),$aJoins);
		$aRows = $this->Dbaction->getCustomQuery("SELECT products.*, category.name as category_name FROM products JOIN category ON products.category = category.id WHERE code like '%".$code."%' OR products.name like '%".$code."%'");

		$this->load->view('backend/product/search',array("aRows" => $aRows));

	}

	public function counter()
	{
		$_SESSION['admin_user']? $aUsr = json_decode(json_encode($_SESSION['admin_user']),True):'';
		$count['counter'] = array();

		$aRows = $this->Dbaction->getAllData('products');

		if($aRows)
		{
			foreach ($aRows as $aRow)
			{
				$count = unserialize($aRow['counter']) ;
				if($count == ''){
					$count = array();
				}

				if($count=='' || !in_array($aUsr['id'],$count)){
					pr(unserialize($aRow['counter']));
					pr('didnt get it');
					array_push($count,$aUsr['id']);
					$aRow['counter'] = serialize($count);
					pr($aRow['counter']);
					$this->Dbaction->updateData('products',$aRow,array('id' => $aRow['id']));
				}
				else {
					pr('got it');
					pr('*');
				}
			}
		}
	}


	public function add_image($id=0)
	{  
		if(isset($_FILES['userfile']) && $_FILES['userfile'])
	 	{     
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
		        	$aImage = $this->Dbaction->uploadFiles("userfile","gif|jpg|png|jpeg");
			 		if(isset($aImage['file_name']) && $aImage['file_name'])
			 		{
			 			$image_name = $aImage['file_name'];

			 			if (isset($image_name)) {
				        	$aVals = array(
				        			'img_product_id'=>$id,
				        			'img_name'=>$image_name
				        		);
				       		$this->Dbaction->addData('images',$aVals);
				        }
			 		}
		        }    
		        
		    }		  
		} 
		$aRow = $this->Dbaction->getData($this->tblName,array("id" =>$id));
		$aRowImage = $this->Dbaction->getAllData('images',"",array("img_product_id" =>$id),'','',$aOrders=array('img_id'=>'DESC'));
		
	    $this->content = 'product/add_image';
		$this->title   = 'Gallery images';
		$this->data    = array('id'=>$id,'aRow'=>$aRow,'aRowImage'=>$aRowImage);
		$this->layout();
	}

	public function deleteimage($id = 0,$proId=0)
	{
		$aRowImage = $this->Dbaction->getData('images',array("img_id" => $id));
		if (isset($aRowImage['img_name']) && ''!=$aRowImage['img_name']) {
			unlink(FCPATH."assets/uploads/".$aRowImage['img_name']);
			
		}
		$this->Dbaction->deleteData('images',array("img_id" => $id));
		$this->session->set_flashdata('message', array('message' => "Image deleted successfully" ,'class' => 'alert-success'));
		
		redirect(getSiteUrl('product/add_image/'.$proId), 'refresh');
	}

	

	public function createcsvfile() {
		$data= array();
		$aJoins= array(
					'category'=>'category.id=products.category',
					'inventory'=>'inventory.product_name=products.id'
				);
		$aRowData = $this->Dbaction->getAllData("products",'products.id AS pro_id,products.name AS product_name,products.code AS code,category.name AS category,inventory.gst AS gst,inventory.sale_price AS price,inventory.size AS attributes,products.status as status',$aCons = array(),$aJoins,$aLImit  = 0,$aOrders = array());
		$aryAttributes = array();

        $fields=array();
        $fields[0]='id';
        $fields[1]='Product Name';
        $fields[2]='Product Code';
        $fields[3]='Category';
        $fields[4]='GST';
        $fields[5]='Price';
        /*$fields[4]='status';*/
       	$rowSizeData = $this->Dbaction->getAllData('attributes','id,name',['type'=>'size']);
       	$count=5;
       	foreach ($rowSizeData as $resSize) {
       		++$count;
       		$fields[$count]=$resSize['name'];
       		$arySize[$count]=$resSize['id'];
       	}

     
    	header("Content-type: application/csv");
        header("Content-Disposition: attachment; filename=\"product_information".".csv\"");
        header("Pragma: no-cache");
        header("Expires: 0");
        $delimiter = ",";
        $handle = fopen('php://output', 'w');        
    	fputcsv($handle, $fields, $delimiter);

        foreach ($aRowData as $resultData) {
        	$data['0'] =$resultData['pro_id'];
        	$data['1'] =$resultData['product_name'];
        	$data['2'] =$resultData['code'];
        	$data['3'] =$resultData['category'];
        	$data['4'] =$resultData['gst'].'%';
        	$data['5'] =$resultData['price'];
        	/*$data['4'] = ($resultData['status'] == '1')?'Active':'Inactive';*/
        	if (isset($resultData['attributes']) && ''!=$resultData['attributes']) {
        		$aryAttributes = unserialize($resultData['attributes']);  
        		$cnt=5; 
        	
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
