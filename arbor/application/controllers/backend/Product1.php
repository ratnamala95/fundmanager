<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product1 extends Backend_Controller {

	
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$aRows = $this->Dbaction->getAllData("products");	
		$this->content = 'product';
		$this->title   = 'Products';
		$this->data    = array("aRows" => $aRows);
		$this->layout();	
	}

	public function view($id = 0)
	{
		$aRow = $this->Dbaction->getData("products",array("id" =>$id));	
		$this->content = 'view_product';
		$this->title   = 'Products';
		$this->data    = array("aRow" => $aRow);
		$this->layout();	
	}

	public function category($id = 0)
	{
		$aRows = $this->Dbaction->getAllData("category");	
		$this->content = 'category';
		$this->title   = 'Category';
		$this->data    = array("aRows" => $aRows);
		$this->layout();	
	}



	public function edit($id = 0)
	{
		if($this->input->post('val'))
		{
			$aVals = $this->input->post('val');
			$this->Dbaction->updateData('products',$aVals,array('id' => $id));
			$this->session->set_flashdata('message', array('message' => 'Product updated successfully','class' => 'alert-success'));
			redirect(getSiteUrl('product'), 'refresh');
		}	
		$aRow = $this->Dbaction->getData("products",array("id" =>$id));	
		$this->content = 'edit_product';
		$this->title   = 'Products';
		$this->data    = array("aRow" => $aRow);
		$this->layout();	
	}

	public function upload()
	{
		if(isset($_FILES['product_file']) && $_FILES['product_file'])
		{			
			require APPPATH .'libraries/PHPExcel.php';
			$tmpfname = $_FILES['product_file']['tmp_name'];
			$excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
			$excelObj = $excelReader->load($tmpfname);
			$worksheet = $excelObj->getSheet(0);
			$lastRow = $worksheet->getHighestRow();
			for ($row = 2; $row <= $lastRow; $row++)
			{
				$card_code = trim($worksheet->getCell('A'.$row)->getValue());
				$aVals['card_code'] = $card_code;
				$aVals['featured'] = $worksheet->getCell('B'.$row)->getValue() ? $worksheet->getCell('B'.$row)->getValue() : 0;
				$aVals['weight'] = $worksheet->getCell('C'.$row)->getValue() ? $worksheet->getCell('C'.$row)->getValue() : "0";
				$aVals['size'] = $worksheet->getCell('D'.$row)->getValue() ? $worksheet->getCell('D'.$row)->getValue() : "";
				$aVals['description'] = trim($worksheet->getCell('E'.$row)->getValue()) ? trim($worksheet->getCell('E'.$row)->getValue()) : "";
				$aVals['price'] = $worksheet->getCell('F'.$row)->getValue() ? $worksheet->getCell('F'.$row)->getValue() : "0.00";
				$aVals['video_url'] = $worksheet->getCell('G'.$row)->getValue() ? $worksheet->getCell('G'.$row)->getValue() : "";
				$aVals['status'] = $worksheet->getCell('H'.$row)->getValue() ? $worksheet->getCell('H'.$row)->getValue() : 0;	

				if($card_code != "")
				{
					$aRow = $this->Dbaction->getData("products",array("card_code" =>$card_code));	
					if($aRow)
					{
						$this->Dbaction->updateData('products',$aVals,array('card_code' => $card_code));
					}
					else
					{
						$this->Dbaction->adddata('products',$aVals);
					}
				}					
			}

			$this->session->set_flashdata('message', array('message' => 'Product uploaded successfully','class' => 'alert-success'));
			redirect(getSiteUrl('product'), 'refresh');	
		}
		$this->content = 'upload_product';
		$this->title   = 'Upload Product';
		$this->data    = array();
		$this->layout();	
	}
}
