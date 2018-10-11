<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attribute extends Backend_Controller {

	
	function __construct()
	{
		parent::__construct();

		$type = $this->uri->segment(3);
		if($this->uri->segment(3) == "add" || $this->uri->segment(3) == "delete")
		{
			$type = $this->uri->segment(4);
		}
		
		$aTypes = array("size","style","codes");

		if(!in_array($type, $aTypes))
		{
			redirect("backend", 'refresh');
		}
		
		$this->tblName = "attributes";
		$this->mainTitle = ucfirst($type);
		$this->ListUrl = getSiteUrl("attribute/{$type}");
		$this->attrType = $type;
		$this->viewFolder = "attributes";
	}

	public function index()
	{
		$aRows = $this->Dbaction->getAllData($this->tblName,"*",array("type" => $this->attrType),'','',['id'=>'DESC']);	
		$this->content = $this->viewFolder.'/index';
		$this->title   = $this->mainTitle;
		$this->data    = array("aRows" => $aRows,"aType" => $this->attrType);
		$this->layout();	
	}


	public function add($type = "",$id = 0)
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
					'label'  => 'Name',
					'rules'  => 'required|callback_is_custom_unique['.$this->tblName.'||name||id||'.$id.']',
				)						
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
					$aMsg = "data updated successfully";
				}
				else
				{
					$aVals['type'] = $this->attrType;
					$this->Dbaction->addData($this->tblName,$aVals);
					$aMsg = "data added successfully";
				}
				
				$this->session->set_flashdata('message', array('message' => $aMsg ,'class' => 'alert-success'));
				redirect($this->ListUrl, 'refresh');
			}
		}	

		$this->content =  $this->viewFolder.'/add';
		$this->title   = $bEdit ? 'Update '.$this->mainTitle : 'Add '.$this->mainTitle;
		$this->data    = array("bEdit" => $bEdit,"aRow" => $aRow);
		$this->layout();	
	}



	public function delete($type = "",$id = 0)
	{
		$this->Dbaction->deleteData($this->tblName,array("id" => $id));
		$this->session->set_flashdata('message', array('message' => "data deleted successfully" ,'class' => 'alert-success'));
		redirect($this->ListUrl, 'refresh');
	}

	
}
