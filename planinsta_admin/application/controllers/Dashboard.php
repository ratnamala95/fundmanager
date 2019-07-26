<?php defined('BASEPATH') or exit('No direct script access allowed!');

/**
 *
 */
class Dashboard extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    $this->load->helper(array('form','url'));
    $this->load->library('Aauth');
  }

  function index()
  {
    $data['admin_data'] = $this->checkAccess();
    $data['title'] = 'Dashboard';

    $this->load->view('layout/header',$data);
    $this->load->view('layout/index',$data);
    $this->load->view('layout/footer',$data);
  }

  private function checkAccess()
  {
    if($this->aauth->is_loggedin()){
      return $this->session->all_userdata();
    }else {
      redirect('auth/login');
    }
  }


}

 ?>
