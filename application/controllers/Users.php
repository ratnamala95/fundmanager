<?php
defined('BASEPATH') OR exit('No direct script access allowed');

  /**
   *
   */
  class Users extends Griglia_Controller
  {

    function __construct()
    {
      parent::__construct();
    }

    public function login()
    {
      if($this->input->post('val'))
      {
        $aVals = $this->input->post('val');
        $aUser = $this->Dbaction->userLogin($aVals);

        if($aUser)
        {
          $this->session->set_userdata('user_logged_in', true);
          $this->session->set_userdata('user_logged_role_id', $aUser[0]->role);
          $this->session->set_userdata('user', $aUser[0]);

          $this->session->set_flashdata('message', array('message' => 'Login successful!','class' => 'alert-success'));
          redirect(base_url('dashboard'), 'refresh');
        }

      }
      else {
        // $this->session->set_flashdata('message', array('message' => 'Login failed','class' => 'alert-danger'));
				// redirect(base_url('users/login'), 'refresh');
      }

      $this->content = 'login';
  		$this->title   = 'Login';
  		$this->data    = array();
  		$this->layout("login");
    }


    public function register()
    {
      $aValidations = array(
        array(
          'field'  => 'val[name]',
          'label'  => 'User Name',
          'rules'  => 'required|trim',
        ),
        array(
          'field'  => 'val[email]',
          'label'  => 'Email',
          'rules'  => 'required|trim|is_unique[users.email]',
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
          $aVals['role'] = FUNDMANAGER_ROLE;
          $aVals['status'] = 1;
          $aVals['password'] = $this->Dbaction->encryptFunction($aVals['password']);
          $this->Dbaction->adddata('users',$aVals);
          $this->session->set_flashdata('message', array('message' => 'Registered!','class' => 'alert-success'));
          redirect(base_url('users/login'));
        }
      }

      $this->content = 'frontend/register';
  		$this->title   = 'Register';
  		$this->data    = array();
  		$this->layout("login");
    }

    public function logout()
  	{
  		$this->session->set_userdata('user_logged_in', '');
  		$this->session->set_userdata('user', '');

  		$this->session->set_flashdata('message', array('message' => 'Logged out successfully','class' => 'alert-success'));
  		redirect(base_url(''), 'refresh');
  	}

    public function resetPassword($id = 0 )
    {
      $reset = false;
      $aValidations = array(
        array(
          'field'  => 'info[email]',
          'label'  => 'Email',
          'rules'  => 'required|trim',
        ),
      );

      $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
  		$this->form_validation->set_rules($aValidations);
      if($this->form_validation->run())
  		{
        if($this->input->post('info'))
        {

          $aVals = $this->input->post('info');
          $to = $aVals['email'];
          unset($aVals);
          // pr($to);die;
          $aEmail  = $this->Dbaction->set_select_value($this->Dbaction->getAllData("users",'',array('email' => $to)),"id","email");
          unset($aEmail['']);
          foreach($aEmail as $id => $email)
          {
            // pr($aEmail);die;
            $subject = "Password Reset";
            $body = "Follow the link to change your password!<br />".base_url('users/resetPassword/').$id;
            $this->Dbaction->sendEmail($to,$subject,$body);
            $this->session->set_flashdata('message', array('message' => 'Follow link in email to change password','class' => 'alert-success'));
            redirect(base_url('users/login'));
          }
        }
      }

      $this->content = 'template/reset';
      $this->title = 'Reset Password';
      $this->data = array('reset' => $reset);
      $this->layout('login');
    }

    public function delete($id)
    {
      $page = '';
      if($id>0)
      {
        $update['status'] = 0;
        $aRow = $this->Dbaction->getData('users',array('id' => $id));
        if($aRow['role']==FUNDMANAGER_ROLE)
        {
          $page = 'fundmanager';
        }
        else if($aRow['role']==MODERATOR_ROLE)
        {
          $page = 'moderator';
        }
        // pr($aRow);die;
        $this->Dbaction->updateData('users',$update,array('id' => $id));
        $this->session->set_flashdata('message', array('message' => 'User Deleted!','class' => 'alert-success'));
        redirect(base_url($page));
      }
      else {
        $this->session->set_flashdata('message', array('message' => 'User cannot be deleted!','class' => 'alert-danger'));
        redirect(base_url($page));
      }
    }
  }

 ?>
