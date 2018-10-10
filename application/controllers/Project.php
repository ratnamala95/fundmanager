<?php

/**
 *
 */
class Project extends Griglia_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->tbl = 'projects';
  }

  public function index()
  {
    $fund = array();
    $projects = $this->Dbaction->getAllData($this->tbl,'');

    $this->content = 'project/index';
    $this->title = 'Projects';
    $this->data = array('projects' => $projects);
    $this->layout();
  }

  public function add($id = 0)
  {
    $aRow = array();
    $bEdit = false;

    if($id>0)
    {
      $bEdit = true;
      $aRow = $this->Dbaction->getData('projects',array('id' => $id));
    }
    $aValidations = array(
      array(
        'field' => 'val[project_name]',
        'label' => 'Project Name',
        'rules' => 'required|trim|callback_is_custom_unique[projects||project_name||id||'.$id.']',
      )
    );

    $this->form_validation->set_error_delimiters('<div class=" alert alert-danger">','</div>');
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

					$this->Dbaction->updateData($this->tbl,$aVals,array("id" => $edit_id));
					$aMsg = "Data updated successfully";
        }else {
          $this->Dbaction->adddata($this->tbl,$aVals);
          $aMsg = 'Data added successfully!';
        }
        $this->session->set_flashdata('message',array('message' => $aMsg, 'class' => 'alert alert-success'));
        redirect(base_url('project/index'));
      }
    }
    $this->content = 'project/add';
    $this->title = 'Add New Project';
    $this->data = array('aRow' => $aRow,'bEdit' => $bEdit);
    $this->layout();
  }

  public function delete($id = 0)
  {
    $page = $this->uri->segment(1);
    if($id>0)
    {
      $update['status'] = 0;
      $this->Dbaction->updateData('projects',$update,array('id' => $id));
      $this->session->set_flashdata('message', array('message' => 'Project Deleted!','class' => 'alert-success'));
      redirect(base_url($page));
    }
    else {
      $this->session->set_flashdata('message', array('message' => 'Project cannot be deleted!','class' => 'alert-danger'));
      redirect(base_url($page));
    }
  }
}

 ?>
