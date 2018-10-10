<?php
class Moderator extends Griglia_Controller
{

  function __construct()
  {
    parent::__construct();
  }

  public function index()
  {
    $moderators = $this->Dbaction->getAllData('users','',array('role' => MODERATOR_ROLE,'status' => 1));

    $this->content = 'moderator/index';
    $this->title = 'Moderators';
    $this->data = array('moderators' => $moderators);
    $this->layout();
  }

  public function add($id = 0)
  {
    $bEdit = false;
    $aRow = array();
    if($id>0)
    {
      $bEdit = true;
      $aRow = $this->Dbaction->getData('users',array('id' => $id));
      $aRow['projects'] = unserialize($aRow['projects']);
    }

    $projects = $this->Dbaction->set_select_value($this->Dbaction->getAllData("projects",'',array()),"id","project_name");
    unset($projects['']);

    $aValidations = array(
      array(
        'field' => 'val[name]',
        'label' => 'Username',
        'rules' => 'required|callback_is_custom_unique[users||name||id||'.$id.']',
      ),
      array(
        'field' => 'val[email]',
        'label' => 'Email',
        'rules' => 'required|callback_is_custom_unique[users||email||id||'.$id.']',
      ),
      array(
        'field' => 'val[password]',
        'label' => 'Password',
        'rules' => 'min_length[6]|trim'
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

          // $aVals['projects'] = serialize($aVals['projects']);

					$this->Dbaction->updateData('users',$aVals,array("id" => $edit_id));
					$aMsg = "User updated successfully";
        }else {
          $aVals['role'] = MODERATOR_ROLE;
          $aVals['status'] = 1;

          $aVals['projects'] = serialize($aVals['projects']);
          $aVals['password'] = $this->Dbaction->encryptFunction($aVals['password']);

          $this->Dbaction->adddata('users',$aVals);
          $aMsg = 'User Added!';
        }
        $this->session->set_flashdata('message',array('message' => $aMsg,'class' => 'alert alert-success'));
        redirect(base_url('moderator'),'refresh');
      }
    }

    $this->content = 'moderator/add';
    $this->title = $bEdit ? 'Update':'Add';
    $this->data = array('projects' => $projects,'bEdit' => $bEdit,'aRow' => $aRow);
    $this->layout();
  }
}


 ?>
