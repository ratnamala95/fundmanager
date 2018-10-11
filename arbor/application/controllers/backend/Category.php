<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends Backend_Controller {

	
	function __construct()
	{
		parent::__construct();
		$this->tblName = "category";
	}

	public function index()
	{
		$aRows = $this->Dbaction->getAllData("category",'','','','',['id'=>'DESC']);	
		$this->content = 'category/index';
		$this->title   = 'Category';
		$this->data    = array("aRows" => $aRows);
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


		$aValidations = array(				
				array(	
					'field'  => 'val[name]',
					'label'  => 'Category Name',
					'rules'  => 'required|callback_is_custom_unique[category||name||id||'.$id.']',
				) //							
		);
			
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
		$this->form_validation->set_rules($aValidations);

		if($this->form_validation->run())
		{
			if($this->input->post('val'))
			{
				$aVals = $this->input->post('val');
				if(isset($aVals['id']) && $aVals['id'] > 0)
				{
					$edit_id = $aVals['id'];
					unset($aVals['id']);
					$this->Dbaction->updateData($this->tblName,$aVals,array("id" => $edit_id));
					$aMsg = "Category updated successfully";
				}
				else
				{
					$aVals['slug'] = str_replace(' ','-',$aVals['name']);
					$this->Dbaction->addData($this->tblName,$aVals);
					$aMsg = "Category added successfully";
				}
				
				$this->session->set_flashdata('message', array('message' => $aMsg ,'class' => 'alert-success'));
				redirect(getSiteUrl('category'), 'refresh');
			}
		}	

		$this->content = 'category/add';
		$this->title   = $bEdit ? 'Update Category' : 'Add Category';
		$this->data    = array("bEdit" => $bEdit,"aRow" => $aRow);
		$this->layout();	
	}



	public function delete($id = 0)
	{
		$this->Dbaction->deleteData($this->tblName,array("id" => $id));
		$this->session->set_flashdata('message', array('message' => "Category deleted successfully" ,'class' => 'alert-success'));
		redirect(getSiteUrl('category'), 'refresh');
	}

	
}
