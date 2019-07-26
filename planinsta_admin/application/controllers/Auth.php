<?php defined('BASEPATH') or exit('No Direct script access allowed!');

  /**
   *
   */
  class Auth extends CI_Controller
  {

    function __construct()
    {
      parent::__construct();
      $this->load->helper(array('form','url'));
      $this->load->library('form_validation');
      $this->load->library('Aauth');
      $this->load->helper('security');
    }

    function index()
    {
      if($this->aauth->is_loggedin())
      {
        redirect('Dashboard');
      }else {
        redirect('auth/login');
      }
    }


    function login()
    {
      if($this->aauth->is_loggedin())
      {
        redirect('Dashboard');
      }else {
        $this->form_validation->set_rules('username','Username','trim|required|xss_clean' );
        $this->form_validation->set_rules('password','Password','trim|required|xss_clean');

        if($this->form_validation->run()){
          if($this->aauth->login($this->input->post('username'),$this->input->post('password'))){
            redirect('dashboard');
          }
        }

        $data['title'] = 'Login';
        $this->load->view('auth/header',$data);
        $this->load->view('auth/login',$data);
        $this->load->view('auth/footer',$data);
      }
    }

    function logout()
    {
      $this->aauth->logout();
      redirect('auth/login');
    }

    function forgot_password()
    {
      $this->form_validation->set_rules('username','Email or Username','trim|required|xss_clean');
      if($this->form_validation->run()){
        if($this->aauth->remind_password($this->input->post('username'))){
          $this->session->set_flashdata(array(
            'message' => 'A password reset link has been sent to your registered email-Id!',
            'class' => 'success',
          ));
        }else {
          $this->session->set_flashdata(array(
            'message' => $this->lang->line('aauth_error_email_invalid'),
            'class' => 'danger',
          ));
        }
        redirect('auth/login');
      }

      $data['title'] = 'Forgot Password';
      $this->load->view('auth/header',$data);
      $this->load->view('auth/forgotpass',$data);
      $this->load->view('auth/footer',$data);
    }

    function checkAccess()
    {
      if($this->aauth->is_loggedin())
      {
        return $this->session->all_userdata();
      }else {
        redirect('auth/login');
      }
    }
  }

 ?>
